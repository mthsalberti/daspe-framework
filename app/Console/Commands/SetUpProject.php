<?php

namespace Daspeweb\Framework\Console\Commands;

use App\Role;
use App\User;
use Daspeweb\Framework\DaspewebHelper;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SetUpProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daspeweb:sunrise {--fresh} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $composer;

    /**
     * Create a new command instance.
     *
     * @param Composer $composer
     * @return void
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Running composer dump-autoload');
        $this->call('config:cache');
        $this->composer->dumpAutoloads();
        $this->composer->dumpOptimized();
        if($this->option('force') <> null){
            $this->call('vendor:publish', ['--force' => true, '--tag' => 'daspeweb']);
        }else{
            $this->call('vendor:publish', ['--tag' => 'daspeweb']);
        }

        if($this->option('fresh') <> null){
            $this->call('migrate:fresh');
        }else {
            $this->call('migrate');
        }
        $this->call('daspeweb:permissions');
        if (User::count() == 0 ){
            $this->call('daspeweb:usercontrol');
        }

        DaspewebHelper::clearCache();

        $tables = array_map('reset', \DB::select('SHOW TABLES'));
        foreach ($tables as $tableName){
            if(!Schema::hasColumn($tableName, 'user_id') && $tableName <> 'migrations' && $tableName <> 'password_resets'){
                Schema::disableForeignKeyConstraints();
                \Illuminate\Support\Facades\Schema::table($tableName, function (Blueprint $table){
                    try{
                        $table->unsignedInteger('user_id')->nullable();
                        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                    }catch (Exception $e){}
                });
                Schema::enableForeignKeyConstraints();
            }
        }

        $this->call('serve');
    }

}
