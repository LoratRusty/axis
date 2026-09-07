<?php

return [
    'auth' => [
        'sign_in' => [
            'title' => 'Iniciar sesión',
            'heading' => 'Bienvenido a AXIS',
            'actions' => [
                'authenticate' => [
                    'label' => 'Iniciar sesión',
                ],
            ],
            'form' => [
                'email' => [
                    'label' => 'Correo electrónico',
                ],
                'password' => [
                    'label' => 'Contraseña',
                ],
                'remember' => [
                    'label' => 'Recordarme',
                ],
            ],
        ],
        'sign_out' => [
            'label' => 'Cerrar sesión',
        ],
    ],
    'pages' => [
        'dashboard' => [
            'title' => 'Panel Principal',
        ],
    ],
    'widgets' => [
        'account' => [
            'actions' => [
                'sign_out' => [
                    'label' => 'Cerrar sesión',
                ],
            ],
        ],
    ],
];