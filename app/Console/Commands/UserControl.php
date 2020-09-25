<?php

namespace Daspeweb\Framework\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserControl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daspeweb:usercontrol';

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
        $roleSeeder = new \RoleSeeder();
        $roleSeeder->run();
        $this->info('');
        $this->info('Olar, eu sou o Gui bot... kkkk');
        $esqueceuOuNovo = $this->choice('Você esqueceu a senha ou quer criar o usuário?', ['esqueci, rs', 'criar novo'], 1);
        if($esqueceuOuNovo == 'esqueci, rs'){
            $this->info('Esses são os primeiros 10 usuários.');
            $headers = ['Id', 'Name', 'Email'];
            $users = User::all(['id', 'name', 'email'])->take(10)->toArray();
            $this->table($headers, $users);
            $id = $this->ask('Qual o id do usuário que você quer redefinir a senha?');
            $user = User::find($id);
            $user->password = Hash::make($this->secret('Qual a senha?'));
            $user->save();
            $this->info('Teje feito. Vai com Deus.');
        }else{
            $user = new User();
            $this->info('');
            $this->info('Então beleza então...');
            $user->name = $this->ask('Qual o primeiro nome do usuário', 'Admin');
            $user->last_name = $this->ask('Qual o último nome do usuário', 'Daspe Web');
            $user->email = $this->ask('Qual o email', 'contato@daspeweb.com.br');
            $pw = $this->secret('Qual a senha (enter para padrão)');
            $user->password = Hash::make($pw == '' || $pw == null ? '103201' : $pw);
            $user->role_id = Role::where('name_api', 'admin')->first()->id;
            $user->save();
            $this->info('Teje criado.');
        }
    }
}
