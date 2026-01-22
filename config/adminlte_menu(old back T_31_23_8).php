<?php
return [

    [
        'text'    => 'Menu principal',
        'icon' => 'fas fa-home',
        'classes' => 'bold-text active always-open',
        'active' => ['admin/*'],
        'submenu' => [
            [
                'text'       => 'Tableau de bord',
                'route'      => 'admin.dashboard.index',
                'can'        => 'admin.dashboard.index',
                'classes'    => 'nav-link active',
            ],
            [
                'text'       => 'Bordereaux',
                'url'        => 'admin/waybills?waybill=true',
                'can'        => 'admin.waybills.index',
                'classes'    => 'nav-link active',
            ],

            [
                'text'       => 'Soumissions',
                'can'        => 'admin.submissions.index',
                'classes'    => 'nav-link active bold-text',
                'submenu'    => [
                    [
                        'text'       => 'Nouveau',
                        'url'        => 'admin/waybills?waybill=false',
                        'can'        => 'admin.submissions.index',
                        'classes'    => 'nav-link active',
                    ],
                    [
                        'text'       => 'Archives',
                        'url'        => 'admin/waybills?archive=true',
                        'classes'    => 'nav-link active',
                    ],
                ],
            ],

            [
                'text'       => 'Carnet d´adresse',
                'route'      => 'admin.clients.index',
                'can'        => 'admin.clients.index',
                'classes'    => 'nav-link active',
            ],

            [
                'text'       => 'Chauffeurs',
                'route'      => 'admin.drivers.index',
                'can'        => 'admin.drivers.index',
                'classes'    => 'nav-link active',
            ],
            [
                'text'       => 'Dépêches',
                'route'      => 'admin.dispatches.index',
                'can'        => 'admin.dispatches.index',
                'classes'    => 'nav-link active',
            ],

            [
                'text'       => 'Statuts',
                'route'      => 'admin.statuses.index',
                'can'        => 'admin.statuses.index',
                'classes'    => 'nav-link active',
            ],

            // [
            //     'text'       => 'Paramètres soumissons',
            //     'route'      => 'admin.settings.index',
            //     'can'        => 'admin.settings.index',
            //     'classes'    => 'nav-link active',
            // ],


        ],
    ],

    [
        'text'    => 'Administration',
        'can'     => 'admin',
        'icon'    => 'fas fa-cog',
        'classes' => 'bold-text active',
        'active' => ['admin/*'],
        'submenu' => [
            [
                'text'       => 'Gestion des utilisateurs',
                'route'      => 'admin.users.index',
                'can'        => 'admin.users.index',
                'classes'    => 'nav-link active',
            ],

            [
                'text'       => 'Gestion des roles',
                'route'      => 'admin.roles.index',
                'can'        => 'admin.roles.index',
                'classes'    => 'nav-link active',
            ],
            [
                'text'       => 'Gestion des permissions',
                'route'      => 'admin.permissions.index',
                'can'        => 'admin.permissions.index',
                'classes'    => 'nav-link active',
            ],
        ],
    ],


    [
        'text'       => 'Votre compte',
        'route'      => 'admin.profile.index',
        'icon'       => 'fas fa-fw fa-user',
        'classes'    => 'bold-text',
        'active' => ['admin/*'],
    ],
    
];