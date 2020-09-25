<?php

namespace Daspeweb\Framework\Controller;
use App\Http\Controllers\Controller;
use Daspeweb\Framework\CheckPermission;
use Daspeweb\Framework\DaspewebHelper;
use Daspeweb\Framework\Exception\ObserverException;
use Daspeweb\Framework\Model\ModelNew;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class APIController extends Controller
{
    use UpsertData;

    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function destroy($slug, $id){
        $model = DaspewebHelper::getModelBySlug($slug);
        $modelInstance = $model::find($id);
        $modelInstance->delete();
        return response()->json($modelInstance->toArray());
    }

    public function storeRaw($slug, Request $request){
        try{
            CheckPermission::check('A', $slug);
            $newModel = DaspewebHelper::getModelBySlug($slug);
            $createdModel = $newModel::create($request->all());
        }catch (ObserverException $e){
            session()->flash('warning', $e->getMessage());
            return redirect()->back();
        }catch (\Exception $e){
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
        }

        return response()->json($createdModel);
    }

    public function updateRaw($slug, Request $request){
        try{
            CheckPermission::check('E', $slug);
            $newModel = DaspewebHelper::getModelBySlug($slug);
            $modelInstance = $newModel::find($request->input('id'));
            $modelInstance->fill($request->all());
            $modelInstance->save();
        }catch (ObserverException $e){
            session()->flash('warning', $e->getMessage());
            return redirect()->back();
        }catch (\Exception $e){
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
        }
        return response()->json($modelInstance);
    }

    public function upsertRaw(Request $request, $slug, $key, $value){

        $upsertedModel = null;
        try{
            CheckPermission::check('E', $slug);
            $model = DaspewebHelper::getModelBySlug($slug);
            $upsertedModel = $model::where($key, $value)->first();
            if($upsertedModel->id == null){
                $upsertedModel = $model::create($request->except(['api_token']));
            }else{
                $upsertedModel->fill($request->except(['api_token']));
                $upsertedModel->save();
            }
        }catch (ObserverException $e){
            session()->flash('warning', $e->getMessage());
            return redirect()->back()->withInput();
        }
        return response()->json($upsertedModel);
    }

    public function store($slug, Request $request){
        try{
            CheckPermission::check('A', $slug);
            $newModel = DaspewebHelper::getModelBySlug($slug);
            $newModel = $this->upsertData($slug, $newModel, $request, true);
            $newModel->save();
        }catch (ObserverException $e){
            session()->flash('warning', $e->getMessage());
            return redirect()->back()->withInput();
        }

        return response()->json($newModel->toArray());
    }

    public function update($slug, Request $request){
        try{
            $modelInstance = DaspewebHelper::getModelBySlug($slug);
            $modelInstance = $this->upsertData($slug, $modelInstance, $request, false, $request->input('id'));
            $modelInstance->save();
        }catch (ObserverException $e){
            session()->flash('warning', $e->getMessage());
            return redirect()->back()->withInput();
        }
        return response()->json($modelInstance->toArray());
    }


    public function show($slug, $id){
        CheckPermission::check('R', $slug);
        $model = DaspewebHelper::getModelBySlug($slug);
        $query = $model::whereId($id);
        $query = $this->handleWithV2($query);

        $result = $this->orderBy($query)->get();
        return response()->json($result);
    }
    public function index($slug, Request $request){
        $modelInfo = DaspewebHelper::info($slug);
        CheckPermission::check('B', $slug);
        $model = DaspewebHelper::getModelBySlug($slug);
        $query = $model::orderBy('created_at', 'desc');;
        $query = $this->handleFilters($query);
        $query = $this->handleFiltersV2($query);
        $query = $this->handleWith($query);
        $query = $this->handleWithV2($query);
        if(CheckPermission::loadOnlyIfOwner('B', $slug)){
            $fields = explode(',', $modelInfo->ownership_fields);
            if(count($fields) > 0){
                $query->where(function ($query) use ($fields){
                    foreach ($fields as $key => $value){
                        $query->orWhere(trim($value), Auth::user()->id);
                    }
                });
            }
        }
        $query = $this->orderBy($query);
        $pageSize = \request()->has('page-size') ? \request()->input('page-size') : 15;
        $returnData = $query->paginate($request->has('paginate') ? $request->input('paginate') : $pageSize);
        return response()->json($returnData);
    }
    public function count($slug){
        $model = DaspewebHelper::getModelBySlug($slug);
        $query = $model::orderBy('created_at', 'desc');
        $query = $this->handleFilters($query);
        $query = $this->handleFiltersV2($query);
        $query = $this->orderBy($query);
        $count = $query->count();
        return response()->json($count);
    }

    private function handleFiltersV2(\Illuminate\Database\Eloquent\Builder $query){
        if(!\request()->has('filter')){
            return $query;
        }
        $filters = json_decode(request()->input('filter'));
//        dd($filters);
        foreach ($filters as $filter){
            if ($filter->criteria == 'in'){
                $query->whereIn($filter->field, $filter->values);
            }else{
                $query->where($filter->field,'like', $filter->values);
            }
        }
        return $query;
    }

    private function handleFilters($query){
        foreach (request()->all() as $key => $value){
            preg_match('/(filter--)(.*)/', $key, $matches);
            if (count($matches) == 0) continue;
            $query->where($matches[2], request()->input($matches[0]));
        }
        return $query;
    }
    private function handleWith($query){
        if (!\request()->has('with--')) return $query;
        foreach (explode(',', \request()->input('with--')) as $relationship){
            $query->with($relationship);
        }
        return $query;
    }
    private function handleWithV2($query){
        if(!\request()->has('with')){
            return $query;
        }
        foreach (json_decode(request()->get('with')) as $key => $with){
            $query->with($with);
        }
        return $query;
    }

    private function orderBy($query){
        if(!\request()->has('orderBy')){
            return $query;
        }
        foreach (json_decode(request()->get('orderBy')) as $key => $order){
            $query->orderBy($order->field, $order->order);
        }
        return $query;
    }
}
