<?php
namespace Daspeweb\Framework;

use App\ListView;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class HandlerListViewFilter
{
    static function handler(Builder $query, $viewId, $model) : Builder{
        if (!request()->has('view_id') || request()->input('view_id') == 'todos' ) return $query;

        $listView = ListView::whereId($viewId)->with('criterias')->first();

        foreach ($listView->criterias as $criteria){

            switch ($criteria->criteria_api){
                case '=':
                    if($criteria->field_type == 'selectdropdown'){
                        $query->where(function($query) use ($criteria){
                            $valueArr = explode(',', $criteria->value_api);
                            foreach ($valueArr as $value){
                                $query->orWhere($criteria->field_api, trim($value));
                            }

                        });
                    }else if($criteria->field_type == 'date' || $criteria->field_type == 'timestamp') {
                        if (self::isRelativeDate($criteria->value_api)) {
                            $query = self::getQueryForRelativeDate($query, self::getRelativeDate($criteria->value_api), $criteria, '=');
                        }else {
                            $query->where(function ($query) use ($criteria) {
                                $query->where($criteria->field_api, '>=', Carbon::createFromFormat(self::formatForDate($criteria->field_type), $criteria->value_api)->hour(0)->minute(0)->second(0));
                                $query->where($criteria->field_api, '<=', Carbon::createFromFormat(self::formatForDate($criteria->field_type), $criteria->value_api)->hour(23)->minute(59)->second(59));
                            });
                        }
                    }else{
                        $query->where($criteria->field_api, $criteria->value_api);
                    }
                    break;
                case '<>':
                    if($criteria->field_type == 'selectdropdown'){
                        $query->where(function($query) use ($criteria){
                            $valueArr = explode(',', $criteria->value_api);
                            foreach ($valueArr as $value){
                                $query->where($criteria->field_api, '<>',trim($value));
                            }
                        });
                    }else{
                        $query->where($criteria->field_api, '<>', $criteria->value_api);
                    }
                    break;
                case 'like':
                    $query->where($criteria->field_api, 'like', '%'.$criteria->value_api.'%');
                    break;
                case 'not like':
                    $query->where($criteria->field_api, 'not like', '%'.$criteria->value_api.'%');
                    break;
                case 'starts with':
                    $query->where($criteria->field_api, 'like', $criteria->value_api.'%');
                    break;
                case 'ends with':
                    $query->where($criteria->field_api, 'like', '%'.$criteria->value_api);
                    break;
                case '>':
                    if($criteria->field_type == 'date'  || $criteria->field_type == 'timestamp') {
                        if (self::isRelativeDate($criteria->value_api)) {
                            $query = self::getQueryForRelativeDate($query, self::getRelativeDate($criteria->value_api), $criteria, '>');
                        }else {
                            $query->where($criteria->field_api, '>', Carbon::createFromFormat(self::formatForDate($criteria->field_type), $criteria->value_api)->hour(23)->minute(59)->second(59));
                        }
                    }else{
                        $query->where($criteria->field_api, '>', $criteria->value_api);
                    }
                    break;
                case '>=':
                    if($criteria->field_type == 'date' || $criteria->field_type == 'timestamp'){
                        if(self::isRelativeDate( $criteria->value_api)){
                            $query = self::getQueryForRelativeDate($query, self::getRelativeDate($criteria->value_api), $criteria, '>=');
                        }else if($criteria->field_type == 'date') {
                            $query->where($criteria->field_api, '>=', Carbon::createFromFormat(self::formatForDate($criteria->field_type) , $criteria->value_api)->hour(23)->minute(59)->second(59) );
                        }else if($criteria->field_type == 'timestamp'){
                            $query->where($criteria->field_api, '>=', Carbon::createFromFormat(self::formatForDate($criteria->field_type) , $criteria->value_api));
                        }
                    }
                    else{
                        $query->where($criteria->field_api, '>=', $criteria->value_api);
                    }
                    break;
                case '<':
                    if($criteria->field_type == 'date'  || $criteria->field_type == 'timestamp') {
                        if (self::isRelativeDate($criteria->value_api)) {
                            $query = self::getQueryForRelativeDate($query, self::getRelativeDate($criteria->value_api), $criteria, '<');
                        }else{
                            $query->where($criteria->field_api, '<', Carbon::createFromFormat(self::formatForDate($criteria->field_type), $criteria->value_api)->hour(0)->minute(0)->second(0));
                        }
                    }else{
                        $query->where($criteria->field_api, '<', $criteria->value_api);
                    }
                    break;
                case '<=':
                    if($criteria->field_type == 'date' || $criteria->field_type == 'timestamp'){
                        if(self::isRelativeDate( $criteria->value_api)){
                            $query = self::getQueryForRelativeDate($query, self::getRelativeDate($criteria->value_api), $criteria, '<=');
                        }else if($criteria->field_type == 'date') {
                            $query->where($criteria->field_api, '<=', Carbon::createFromFormat(self::formatForDate($criteria->field_type) , $criteria->value_api)->hour(23)->minute(59)->second(59) );
                        }else if($criteria->field_type == 'timestamp'){
                            $query->where($criteria->field_api, '<=', Carbon::createFromFormat(self::formatForDate($criteria->field_type) , $criteria->value_api));
                        }
                    }
                    else{
                        $query->where($criteria->field_api, '<=', $criteria->value_api);
                    }
                    break;
            }
        }
        return $query;
    }

    static function getQueryForRelativeDate($query, $dates, $criteria, $operator){
        $secondOperator = '<=';
        $query->where(function ($query) use ($dates, $criteria, $operator, $secondOperator){
            if($operator == '='){
                if(self::isFilterBefore($criteria->value_api)){
                    $dates[1] = Carbon::now();
                    $operator = '>=';
                }else if(self::isFilterLater($criteria->value_api)){
                    $dates[1] = Carbon::now();
                    $secondOperator = '>=';
                    $operator = '<=';
                }
            }
            $query->where($criteria->field_api, $operator, $dates[0]);
            if($dates[1] <> null){
                $query->where($criteria->field_api, $secondOperator, $dates[1]);
            }

        });
        return $query;
    }
    static function formatForDate($fieldType){
        if($fieldType == 'date'){
            return 'd/m/Y';
        }
        return 'd/m/Y H:i';
    }

    static function getRelativeDate($expression){
        $expression = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$expression);
        $expression = strtolower($expression);
        $dt1 = null;
        $dt2 = null;
        if($expression == 'hoje'){
            $dt1 = Carbon::now()->startOfDay();
            $dt2 = Carbon::now()->endOfDay();
        }else if ($expression == 'amanha'){
            $dt1 = Carbon::now()->startOfDay();
            $dt2 = Carbon::now()->addDay()->endOfDay();
        }else if ($expression == 'ontem'){
            $dt1 = Carbon::now()->subDay()->startOfDay();
            $dt2 = Carbon::now()->subDay()->endOfDay();
        }

        $pattern = '/([a-z]+)( )([0-9]+)( )([a-z]+)/';
        preg_match($pattern, $expression, $matches);
        $periodName = self::fixPeriodName($matches[1]);
        if($matches[5] == 'dias'){
            if($periodName == 'ultimos'){
                $dt1 = Carbon::now()->subDays($matches[3])->startOfDay();
            }else if($periodName == 'proximos'){
                $dt1 = Carbon::now()->addDays($matches[3])->endOfDay();
            }
        }else if($matches[5] == 'semanas'){
            if($periodName == 'ultimos'){
                $dt1 = Carbon::now()->subWeeks($matches[3])->startOfDay();
            }else if($periodName == 'proximos'){
                $dt1 = Carbon::now()->addWeeks($matches[3])->endOfDay();
            }
        }else if($matches[5] == 'meses'){
            if($periodName == 'ultimos'){
                $dt1 = Carbon::now()->subMonths($matches[3])->startOfDay();
            }else if($periodName == 'proximos'){
                $dt1 = Carbon::now()->addMonths($matches[3])->endOfDay();
            }
        }
        else if($matches[5] == 'anos'){
            if($periodName == 'ultimos'){
                $dt1 = Carbon::now()->subYears($matches[3])->startOfDay();
            }else if($periodName == 'proximos'){
                $dt1 = Carbon::now()->addYears($matches[3])->endOfDay();
            }
        }
        return [$dt1, $dt2];
    }

    static function isRelativeDate($value){
        $a = collect(['hoje', 'amanh', 'ontem', 'ltim', 'xim'])->filter(function ($item) use ($value){
            return str_contains($value, $item);
        });
        if(count($a) > 0) return true;
        return false;
    }

    public static function isFilterBefore($value){//uLTIMo
        $a = collect(['ltim'])->filter(function ($item) use ($value){
            return str_contains($value, $item);
        });
        if(count($a) > 0) return true;
        return false;
    }
    public static function isFilterLater($value){
        $a = collect(['xim'])->filter(function ($item) use ($value){//proXIMo
            return str_contains($value, $item);
        });
        if(count($a) > 0) return true;
        return false;
    }
    static function fixPeriodName($period){
        return [
            'anos' => 'anos',
            'ano' => 'anos',
            'ultimos' => 'ultimos',
            'ultimo' => 'ultimos',
            'ultimas' => 'ultimos',
            'ultima' => 'ultimos',
            'proximos' => 'proximos',
            'proximo' => 'proximos',
            'proximas' => 'proximos',
            'proxima' => 'proximos',
            'últimos' => 'ultimos',
            'último' => 'ultimos',
            'últimas' => 'ultimos',
            'última' => 'ultimos',
            'próximos' => 'proximos',
            'próximo' => 'proximos',
            'próximas' => 'proximos',
            'próxima' => 'proximos',
        ][$period];
    }
}
