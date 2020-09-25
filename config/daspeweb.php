<?php

return [
    'timestamps_format' => 'd/m/Y H:i',
    'date_format' => 'd/m/Y',

    'favicon_path' => '',

    'everything_allowed' => true,

    //login options
    'auth' => [
        'facebook' => false,
        'google' => false,
    ],

    'slug-info' => [
        'ListView' => [
            'singular_name' => 'Modo de Visualização',
            'plural_name' => 'Modos de Visualização',
            'icon' => 'fas fa-eye',
            'is_displayed_on_app_center' => 0,
            'has_owner_field' => 1,
            'app_center_group' => 'Controle sistema',
        ],
        'ListViewCriteria' => [
            'singular_name' => 'Critério Modo de Visualização',
            'plural_name' => 'Critérios Modo de Visualização',
            'icon' => 'fas fa-archive',
            'has_owner_field' => 1,
            'is_displayed_on_app_center' => 0,

        ],
        'Role' => [
            'singular_name' => 'Função',
            'plural_name' => 'Funções',
            'icon' => 'fas fa-user-shield',
            'is_displayed_on_app_center' => 1,
            'has_owner_field' => 1,
            'app_center_group' => 'Controle sistema',
        ],
        'User' => [
            'singular_name' => 'Usuário',
            'plural_name' => 'Usuários',
            'icon' => 'fas fa-user',
            'is_displayed_on_app_center' => 1,
            'has_owner_field' => 1,
            'app_center_group' => 'Controle sistema',
        ],
        'dw_models' => [
            'is_displayed_on_app_center' => 0,
        ],
        'dw_permission_details' => [
            'is_displayed_on_app_center' => 0,
        ],
        'dw_permission_detail_roles' => [
            'is_displayed_on_app_center' => 0,
        ],
        'UserForAdmin' => [
            'singular_name' => 'Usuário Para Administrador',
            'plural_name' => 'Usuário Para Administradores',
            'icon' => 'fas fa-user',
            'is_displayed_on_app_center' => 1,
            'has_owner_field' => 1,
            'app_center_group' => 'Controle sistema',
        ],
    ]

];
