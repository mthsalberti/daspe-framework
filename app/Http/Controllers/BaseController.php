<?php

namespace Daspeweb\Framework\Controller;

use App\Http\Controllers\Controller;
use App\ListView;
use Carbon\Carbon;
use Daspeweb\Framework\CheckPermission;
use Daspeweb\Framework\DaspewebHelper;
use Daspeweb\Framework\Exception\ObserverException;
use Daspeweb\Framework\HandlerListViewFilter;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    use UpsertData;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $slug)
    {
        $r = $request;
        $renderAjax = $r->input('render-ajax');
        $model = DaspewebHelper::getModelBySlug($slug);
        $modelRaw = DaspewebHelper::getModelBySlug($slug);
        $modelInfo = DaspewebHelper::info($slug);
        CheckPermission::check('B');
        $fields_to_select = '*';
        if ($request->has('fields_to_select')){
            $fields_to_select = json_decode(request()->input('fields_to_select'));
            foreach($model->relationshipFields() as $relationField){
                if (in_array($relationField->method, $fields_to_select)){
                    unset($fields_to_select[$relationField->method]);
                    $fields_to_select = array_diff($fields_to_select, [$relationField->method] ) ;
                }
            }
            array_push($fields_to_select, 'id');
        }
        $query = $model::select('*');//seleção de campos
        if(CheckPermission::loadOnlyIfOwner('B')){
            $fields = explode(',', $modelInfo->ownership_fields);
            if(count($fields) > 0){
                $query->where(function ($query) use ($fields){
                    foreach ($fields as $key => $value){
                        $query->orWhere(trim($value), Auth::user()->id);
                    }
                });
            }
        }
        //aplica modo de visualização
        $query = HandlerListViewFilter::handler( $query, $request->input('view_id'), $model);

        //verifica se o usuário está fazendo uma pesquisa pela barra de pesquisa e então realiza a pesquisa por qualquer um dos campos indexados

        $indexesFound = Cache::get('indexes_columns_for_'.$modelRaw->getTable(), function () use ($modelRaw){
            $indexesFoundAux = [];
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            foreach ($sm->listTableIndexes($modelRaw->getTable()) as $key => $value) {
                foreach ($value->getColumns() as $key2 => $columnName){
                    array_push($indexesFoundAux, $columnName);
                }
            }
            return $indexesFoundAux;
        }, 60*24*365);

        if(\request()->input('value-to-search') != ''){
            foreach ($indexesFound as $fieldName){
                if(!str_contains($fieldName, '_id')){
                    $query->orWhere($fieldName, 'like','%' . \request()->input('value-to-search') . '%');
                }
            }
        }
        if($r->has('sort-by') && $r->input('sort-by') <> ''){
            if($r->input('sort-by-order') == 'asc'){
                $query->orderBy($r->input('sort-by'));
            }else{
                $query->orderBy($r->input('sort-by'), 'desc');
            }
        }else if($modelInfo->default_order_by){
            $query->orderBy($modelInfo->default_order_by, $modelInfo->default_order_by_direction);
        }

        //aplica relacionamentos
        foreach ($model::relationshipFields() as $field){
            if ($field->isCount){
                $query->withCount($field->method);
            }else{
                $query->with($field->method);
            }
        }

        foreach (request()->all() as $key => $value){
            preg_match('/(filter-)(.*)/', $key, $matches);
            if (!isset($matches[1]) || $matches[2] == 'to-search') continue;
            $query->where($matches[2], request()->input($matches[0]));
        }

        //{"filter":[{"field":"status","criteria":"in","values":["v1","v2"]}]}
        foreach (request()->all() as $key => $value){
            if ($key != 'filter') continue;
            $decode = json_decode(request()->input($key));
            foreach ($decode->filters as $filter){
                if ($filter->criteria == 'in'){
                    $query->whereIn($filter->field, $filter->values);
                }
            }
        }
        $dataTypeContent = $query->paginate(15);

        $listViewColl = ListView::orderBy('name')
            ->where('is_only_for_me', '')
            ->orWhere(function ($query){
                $query->whereIsOnlyForMe(true);
                $query->where('user_id', Auth::user()->id);
            })
            ->get();

        $canRead = CheckPermission::hasPermissionForThisModel('R', $slug);
        $canEdit = CheckPermission::hasPermissionForThisModel('E', $slug);
        $canAdd = CheckPermission::hasPermissionForThisModel('A', $slug);
        $canDelete = CheckPermission::hasPermissionForThisModel('D', $slug);

        $vars = [
            'listViewColl' => $listViewColl,
            'canRead' => $canRead,
            'canEdit' => $canEdit,
            'canAdd' => $canAdd,
            'canDelete' => $canDelete,
            'dataType' => $model,
            'modelRaw' => $modelRaw,
            'dataTypeContent' => $dataTypeContent,
            'slug' => $slug,
            'breadFilters' => [],
            'fields_to_select' => $fields_to_select,
            'is_related_list' => $request->has('is_related_list') == true ? true : false,
        ];
        if($renderAjax){
            $view = view('daspeweb::bread.browse-ajax', $vars);
            return $view->render();
        }
        $view = view()->exists('daspeweb::app_layout.'.$slug.'.browse') ? 'daspeweb::app_layout.'.$slug.'.browse' : 'daspeweb::bread.browse';
        return view($view, $vars);
    }

    public function show($slug, $id){
        $modelRaw = DaspewebHelper::getModelBySlug($slug);
        CheckPermission::check('R');
        $relatedDataColl = null;
        $callAction = \request()->input('call_action');
        $modelInstance = DaspewebHelper::getModelBySlug($slug)::find($id);

        CheckPermission::checkIfAllowedOnlyForOwner('R', $modelInstance, $slug);
        $canRead = CheckPermission::hasPermissionForThisModel('R', $slug);
        $canEdit = CheckPermission::hasPermissionForThisModel('E', $slug);
        $canAdd = CheckPermission::hasPermissionForThisModel('A', $slug);
        $canDelete = CheckPermission::hasPermissionForThisModel('D', $slug);
        $view = view()->exists('daspeweb::app_layout.'.$slug.'.read') ? 'daspeweb::app_layout.'.$slug.'.read' : 'daspeweb::bread.read';
        return view($view)
            ->with('canRead', $canRead)
            ->with('canEdit', $canEdit)
            ->with('canAdd', $canAdd)
            ->with('canDelete', $canDelete )
            ->with('relatedDataColl', $relatedDataColl)
            ->with('create', false)
            ->with('read', true)
            ->with('edit', false)
            ->with('modelRaw', $modelRaw)
            ->with('modelInstance', $modelInstance)
            ->with('callAction', $callAction);
    }

    public function edit(Request $request, $slug, $id)
    {
        CheckPermission::check('E');
        $model = DaspewebHelper::getModelBySlug($slug);
        $modelRaw = DaspewebHelper::getModelBySlug($slug);
        $modelInstance = $model::where('id', $id)->first();
        $useModalForm = $request->has('use_modal_form');
        $create = false;
        $read = false;
        $edit = true;
        CheckPermission::checkIfAllowedOnlyForOwner('E', $modelInstance, $slug);
        if($useModalForm){
            if (view()->exists('daspeweb::app_layout.'.$slug.'.edit-add-modal')){
                return view('daspeweb::app_layout.'.$slug.'.edit-add-modal', compact('model','modelRaw', 'slug', 'create', 'modelInstance', 'read', 'edit', 'useModalForm'));
            }
            return view('daspeweb::bread.edit-add-modal', compact('model', 'modelRaw', 'slug', 'create', 'modelInstance', 'read', 'edit', 'useModalForm'));
        }

        if (view()->exists('daspeweb::app_layout.'.$slug.'.edit-add')){
            return view('daspeweb::app_layout.'.$slug.'.edit-add', compact('model','modelRaw', 'slug', 'create', 'modelInstance', 'read', 'edit', 'useModalForm'));
        }
        return view('daspeweb::bread.edit-add', compact('model', 'modelRaw', 'slug', 'create', 'modelInstance', 'read', 'edit', 'useModalForm'));
    }

    public function create(Request $request, $slug)
    {
        CheckPermission::check('A');
        $modelRaw = DaspewebHelper::getModelBySlug($slug);
        $model = DaspewebHelper::getModelBySlug($slug);
        $create = true;
        $read = false;
        $edit = false;
        $modelInstance = DaspewebHelper::getModelBySlug($slug);
        $useModalForm = $request->has('use_modal_form');
        $vars = compact('slug', 'create', 'read', 'edit', 'useModalForm', 'modelInstance', 'modelRaw');

        if($useModalForm){
            if (view()->exists('app_layout.'.DaspewebHelper::slug().'.edit-add-modal')){
                return view('app_layout/'.DaspewebHelper::slug().'/edit-add-modal', $vars)
                    ->with('dataType', $model);
            }
            return view('daspeweb::bread.edit-add-modal', $vars)->with('dataType', $model);
        }
        if (view()->exists('app_layout.'.$slug.'.edit-add')){
            return view('app_layout.'.$slug.'.edit-add', $vars)->with('dataType', $model);
        }
        return view('daspeweb::bread.edit-add', $vars)->with('dataType', $model);
    }

    public function store(Request $request, $slug){
        try{
            CheckPermission::check('A');
            $newModel = DaspewebHelper::getModelBySlug($slug);
            $newModel = $this->upsertData($slug, $newModel, $request, true);
            $newModel->save();

        }catch (ObserverException $e){
            session()->flash('warning', $e->getMessage());
            return redirect()->back()->withInput();
        }
        return redirect()->to('/admin/'.$slug.'/'.$newModel->id);
    }

    public function update(Request $request, $slug, $id){
        try{
            CheckPermission::check('E');
            $model = DaspewebHelper::getModelBySlug($slug);
            $modelInstance = $this->upsertData($slug, $model, $request, false, $id);
            CheckPermission::checkIfAllowedOnlyForOwner('E', $modelInstance, $slug);
            $modelInstance->updated_at = Carbon::now();
            $modelInstance->save();

        }catch (ObserverException $e){
            session()->flash('warning', $e->getMessage());
            return redirect()->back()->withInput();
        }
        return $this->show($slug, $id);
    }

    public function destroy($slug, Request $request){
        CheckPermission::check('D');
        $model = DaspewebHelper::getModelBySlug($slug);
        $array = json_decode($request->input('ids'));
        $coll = $model->whereIn('id', $array);
        foreach ($coll as $modelInstance){
            CheckPermission::checkIfAllowedOnlyForOwner('DTO', $modelInstance, $slug);
        }
        $model::destroy($array);
        return response()->json(['redirect' => '/admin/'.$slug]);
    }

    public function lookup($lookupSlug){
        $model = DaspewebHelper::getModelBySlug($lookupSlug);
        $fieldsToSearchArr = explode(',', request()->input('fields-to-search'));
        $fieldsToShowArr = explode(',', request()->input('fields-to-show'));
        $fieldsToLoadArr = explode(',', request()->input('fields-to-load'));
        if ($fieldsToLoadArr[0] == "") $fieldsToLoadArr = $fieldsToShowArr;
        array_push($fieldsToLoadArr, 'id');
        $term = request()->input('term');
        $query = $model::select('*');
        $query->where(function ($query) use ($fieldsToSearchArr, $term){
            foreach ($fieldsToSearchArr as $field){
                $query->orWhere($field, 'like', '%'.$term.'%');
            }
        });
        $filterStr = \request()->input('filter');
        $filterJSON = json_decode($filterStr);
        foreach ($filterJSON as $key => $realFilter){
            $query->where($realFilter->field, $realFilter->criteria, $realFilter->value);
        }
        $r = $query->take(20)->get()->toArray();
        return response()->json($r);
    }

    public function fileUpload(){
        $slug = \request()->input('slug');
        $image = \request()->file('file');
        $path = Storage::disk('public')->putFile('tenancy2/'.website()->uuid.'/'.$slug, new File($image));
        $returnData = new \stdClass();
        $returnData->location = '/storage//'.$path;
        return json_encode($returnData) ;
    }

    public function getFieldContent($slug, $id, $field){
        $model = DaspewebHelper::getModelBySlug($slug);
        $data = $model::select($field)->where('id', $id)->first();
        CheckPermission::check('R');
        echo $data[$field];
    }

}
