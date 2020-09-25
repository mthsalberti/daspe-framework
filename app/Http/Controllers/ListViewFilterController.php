<?php
namespace Daspeweb\Framework\Controller;

use App\Http\Controllers\Controller;

class ListViewFilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getOptions($slug){
        $modelInstance = \Daspeweb\Framework\DaspewebHelper::getModelBySlug($slug);
        $fields = $modelInstance::fields()->sortBy('apiName');
        return response()->json($fields);
    }
}
