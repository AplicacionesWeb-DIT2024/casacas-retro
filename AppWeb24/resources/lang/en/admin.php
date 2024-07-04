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
            'create' => 'Nueva Camiseta',
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
            'Imagen' => 'Imagen',
        ],
    ],

    'talle' => [
        'title' => 'Talles',

        'actions' => [
            'index' => 'Talles',
            'create' => 'Nuevo Talle',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'Talle' => 'Talle',
            'Ancho' => 'Ancho',
            'Altura' => 'Altura',
            
        ],
    ],

    'user' => [
        'title' => 'Usuarios',

        'actions' => [
            'index' => 'Usuarios',
            'create' => 'Nuevo Usuario',
            'edit' => 'Edit :name',
        ],
        'columns' => [
            'id' => 'ID',
            'name' => 'Nombre',
            'email' => 'Correo Electrónico',
            // Otros campos de la tabla users
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];