<?php

namespace App;


use Daspeweb\Framework\ExtraAction;
use Daspeweb\Framework\Field\BelongsToField;
use Daspeweb\Framework\Field\Checkbox;
use Daspeweb\Framework\Field\Email;
use Daspeweb\Framework\Field\DaspewebModel;
use Daspeweb\Framework\Field\ID;
use Daspeweb\Framework\Field\Password;
use Daspeweb\Framework\Field\Text;
use Daspeweb\Framework\Field\Timestamp;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserForAdmin extends Authenticatable
{
    use Notifiable, DaspewebModel;
    protected $table = 'users';
    protected $guard_name = 'auth';
    protected $fillable = ['name', 'email', 'password', 'role_id'];
    protected $hidden = ['password', 'remember_token'];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public static function fields()
    {
        return collect([
            ID::make('id')->label('Código'),
            Text::make('name')->label('Nome')->fastSetting(1,1,1,1,1),
            Text::make('last_name')->label('Sobrenome')->fastSetting(1,1,1,1,1),
            Email::make('email')->label('E-mail')->width('col-12 col-md-6')->fastSetting(1,1,1,1,1),
//            TextArea::make('resume')->label('Resumo')->width('col-12')->fastSetting(1,1,1,1,1),
            Password::make('password')->label('Senha')->fastSetting(0,0,0,1,0)->breakUp(),
            BelongsToField::callMethod('role')->toggle()->label('Perfil')->lookupSlug('tipos-de-perfis')->fastSetting(),
            Checkbox::make('is_active')->label('Ativo?')->fastSetting(),
            Text::make('api_token')->label('Token')->fastSetting(),
//            Image::make('avatar')->label('Foto')->breakUp()->fastSetting(),
            Timestamp::make('updated_at')->label('Alterado em')->format('d/m/Y')->fastSetting(0,1,0,0,0),
            Timestamp::make('created_at')->label('Criado em')->format('d/m/Y')->fastSetting(0,1,0,0,0),
        ]);
    }

    public static function validations()
    {
        return collect([
            'name' => ['required'],
            'last_name' => ['required'],
//            'email' => ['required', 'unique'],
            'password' => ['required'],
        ]);
    }

    public static function extraActions(){
        return [
            ExtraAction::make('Desativar')
                ->where('is_active', '=', 1)
                ->link('/admin/users/deactivate/by-user-id/{id}')->onBrowseView()->onReadView()
                ->onBrowseView()
                ->onReadView(),
            ExtraAction::make('Ativar')
                ->where('is_active', '=', 0)
                ->link('/admin/users/activate/by-user-id/{id}')->onBrowseView()->onReadView()
                ->onBrowseView()
                ->onReadView(),
            ExtraAction::make('Renovar token')
                ->where('is_active', '=', 0)
                ->link('/admin/users/update-refresh-token/{id}')->onBrowseView()->onReadView()
                ->onBrowseView()
                ->onReadView(),
            ExtraAction::make('Login')
                ->link('/admin/login-as/{id}')
                ->onReadView()
        ];
    }



}
