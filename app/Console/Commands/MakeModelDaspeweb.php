<?php

namespace Daspeweb\Framework\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeModelDaspeweb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daspeweb:make:model {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $modelName = $this->option('model');
        $str = __DIR__ . '/stubs/model.stub';
        $file = fopen($str, "r");
        $fullClassTxt = '';
        while (($buffer = fgets($file)) !== false) {
            $fullClassTxt .= $buffer;
        }
//        $line = fgets($file);
        $fullClassTxt = str_replace("DummyClass", $modelName, $fullClassTxt);
        file_put_contents(app_path() . '\\'.$modelName.'.php', $fullClassTxt);
    }
}
