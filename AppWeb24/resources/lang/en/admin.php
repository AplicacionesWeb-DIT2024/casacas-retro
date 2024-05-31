<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'camiseta' => [
        'title' => 'Camisetas',

        'actions' => [
            'index' => 'Camisetas',
            'create' => 'New Camiseta',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'Nombre' => 'Nombre',
            'Descripción' => 'Descripción',
            'Precio' => 'Precio',
            'Talle' => 'Talle',
            'Cantidad' => 'Cantidad',
            'Categoría' => 'Categoría',
        ],
    ],

    'talle' => [
        'title' => 'Talles',

        'actions' => [
            'index' => 'Talles',
            'create' => 'New Talle',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'talle' => [
        'title' => 'Talles',

        'actions' => [
            'index' => 'Talles',
            'create' => 'New Talle',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'Talle' => 'Talle',
            'Ancho' => 'Ancho',
            'Altura' => 'Altura',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];