<?php

namespace Daspeweb\Framework\Observers;

use App\DwModel;
use Daspeweb\Framework\DaspewebHelper;
use Illuminate\Support\Facades\Artisan;

class DwModelObserver
{
    public function saved(DwModel $dwModel){
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
    }
}
