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
                'text'       => 'Chauffeur waybills',
                'route'      => 'admin.drivers.waybill',
                'url'        => 'admin/driver-waybill',
                'can'        => 'admin.drivers.waybill',
                'classes'    => 'nav-link active',
            ],

            /*[
                'text'       => 'Chauffeur waybill list',
                'route'      => 'admin.drivers.list',
                'url'        => 'admin/driver-waybill-list',
                'can'        => 'admin.drivers.list',
                'classes'    => 'nav-link active',
            ],*/
            /*[
                'text'       => 'Dépêches',
                // 'route'      => 'admin.dispatches.index',
                'can'        => 'admin.dispatches.index',
                'classes'    => 'nav-link active',
            ],*/


            [
                'text'       => 'Statuts',
                'route'      => 'admin.statuses.index',
                'can'        => 'admin.statuses.index',
                'classes'    => 'nav-link active',
            ],

//            [
//                'text'       => 'Paramètres soumissons',
//                'route'      => 'admin.settings.index',
//                'can'        => 'admin.settings.index',
//                'classes'    => 'nav-link active',
//            ],

        [
        'text'       => 'Dispatch ',
        'route'      => 'admin.driver_progress.index',
        'can'        => 'admin',
        'classes'    => 'nav-link active',
        'icon'       => 'fa fa-bars',
//        'classes'    => 'bold-text',
    ],
    [
                'text'       => 'Route Chauffeur',
                'route'      => 'admin.dispatches.index',
                'can'        => 'admin',
                'classes'    => 'nav-link active',
                // 'route'      => 'admin.route-chauffeur.index',
                'icon'       => 'fa fa-bars',
                // 'classes'    => 'bold-text',
    ],


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
//        'classes'    => 'bold-text',
        'active' => ['admin/*'],
    ],

    [
        'text'       => 'bordereaux rapide',
        'url'        => 'admin/waybills?waybill=quick',
        'can'        => 'admin.users.index',
        'classes'    => 'nav-link active',
    ],
    [
        'text'       => 'Chauffeur waybill',
        'url'        => 'admin/driver-waybill',
        // 'route'      => 'admin.drivers.waybill',
        'route'      => 'admin.drivers.waybill',
        'can'        => 'drivers',
        'classes'    => 'nav-link active',
    ],



];
























/*
 * <?php
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
                'url'        => 'admin/waybills?waybill=false',
                'can'        => 'admin.submissions.index',
                'classes'    => 'nav-link active',
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

            [
                'text'       => 'Paramètres soumissons',
                'route'      => 'admin.settings.index',
                'can'        => 'admin.settings.index',
                'classes'    => 'nav-link active',
            ],


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
    ]
];

 */
