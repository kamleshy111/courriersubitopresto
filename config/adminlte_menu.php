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
                'url'        => 'admin/waybills?waybill=false',
                'can'        => 'admin.clients.soumission',
                'classes'    => 'nav-link active',
                'submenu'    => [
                    [
                        'text'       => 'Nouveau',
                        'url'        => 'admin/waybills?waybill=false',
                        'can'        => 'admin.clients.soumission',
                        'classes'    => 'nav-link active',
                    ],
                    [
                        'text'       => 'Archives',
                        'url'        => 'admin/waybills?archive=true',
                        'can'        => 'admin.clients.soumission',
                        'classes'    => 'nav-link active',
                        ],
                    ],
                // ],
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


            /*client delivery status*/

            [
                // 'text'       => 'Chauffeur waybill upload',
                'text'       => 'Livraison en cours',
                'route'      => 'admin.clients.deliverystatus',
                // 'url'        => '/admin/driver-waybill/27/in-progress',
                'url'        => 'admin/client/in-progress',

                'can'        => 'admin.clients.deliverystatus',
                'classes'    => 'nav-link active',
                // 'id'         => 'dynamic-waybill-inprogress',
            ],
            [
                // 'text'       => 'Chauffeur waybill upload',
                'text'       => 'Livraison ramassé',
                'route'      => 'admin.clients.deliverystatus',
                // 'url'        => 'admin/driver-waybill/27/pickedup', //old
                'url'        => 'admin/client/pickedup',
                'can'        => 'admin.clients.deliverystatus',
                'classes'    => 'nav-link active',
                // 'id'         => 'dynamic-waybill-pickedup',
            ],
            [
                // 'text'       => 'Chauffeur waybill upload',
                'text'       => 'Livraison terminé',
                'route'      => 'admin.clients.deliverystatus',
                // 'url'        => 'admin/driver-waybill/27/delivered', //old
                'url'        => 'admin/client/delivered',
                'can'        => 'admin.clients.deliverystatus',
                'classes'    => 'nav-link active',
                // 'id'         => 'dynamic-waybill-delivered',
            ],

            /*[
                'text'       => 'Chauffeurs',
                'route'      => 'admin.drivers.index',
                'can'        => 'admin.drivers.index',
                'classes'    => 'nav-link active',
            ],*/


            [
                // 'text'       => 'Chauffeur waybill upload',
                'text'       => 'Livraison en cours',
                'route'      => 'admin.drivers.waybill',
                // 'url'        => '/admin/driver-waybill/27/in-progress',
                'url'        => '#',

                'can'        => 'admin.drivers.waybill',
                'classes'    => 'nav-link active',
                'id'         => 'dynamic-waybill-inprogress',
            ],
            [
                // 'text'       => 'Chauffeur waybill upload',
                'text'       => 'Livraison ramassé',
                'route'      => 'admin.drivers.waybill',
                // 'url'        => 'admin/driver-waybill/27/pickedup', //old
                'url'        => '#',
                'can'        => 'admin.drivers.waybill',
                'classes'    => 'nav-link active',
                'id'         => 'dynamic-waybill-pickedup',
            ],
            [
                // 'text'       => 'Chauffeur waybill upload',
                'text'       => 'Livraison terminé',
                'route'      => 'admin.drivers.waybill',
                // 'url'        => 'admin/driver-waybill/27/delivered', //old
                'url'        => '#',
                'can'        => 'admin.drivers.waybill',
                'classes'    => 'nav-link active',
                'id'         => 'dynamic-waybill-delivered',
            ],

            [
                // 'text'       => 'Chauffeur waybill upload',
                'text'       => 'Rapport de commission',
                'route'      => 'admin.drivers.waybill',
                // 'url'        => 'admin/driver-waybill/{id}', //old
                'url'        => '#',
                'can'        => 'admin.drivers.waybill',
                'classes'    => 'nav-link active',
                'id'         => 'dynamic-waybill-link',
            ],


            // [
            //     'text'       => 'Chauffeur waybill list',
            //     'route'      => 'admin.drivers.list',
            //     'url'        => 'admin/driver-waybill-list',
            //     'can'        => 'admin.drivers.list',
            //     'classes'    => 'nav-link active',
            // ],
            [
                // 'text'       => 'Liste de Chauffeur',
                'text'       => 'Feuillle de commission',
                'route'      => 'admin.drivers.drivers-list',
                'url'        => 'admin/drivers-list',
                // 'can'        => 'admin.drivers.list',
                'can'        => 'admin',
                'classes'    => 'nav-link active',
            ],
            [
                'text'       => 'Sommaire',
                'route'      => 'admin.waybills.deliverySummary',
                'url'        => 'admin/delivery/summary-table',
                // 'can'        => 'admin.drivers.list',
                'can'        => 'admin',
                'classes'    => 'nav-link active',
            ],
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
        'text'       => 'Bordereaux Rapide',
        'can'        => 'admin',
        'url'        => 'admin/waybills/create?waybill=true&mode=rapid',
        'can'        => 'admin.users.index',
        'classes'    => 'nav-link active',
        'icon'       => 'fa fa-bars',
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
                'text'       => 'Gestion des rôles',
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
        'can'        => 'admin.permissions.index',
//        'classes'    => 'bold-text',
        'active' => ['admin/*'],
    ],
    
    /*[
        'text'       => 'Modifier mon mot de passe',
        'route'      => 'admin.client.profile',
        // 'url'        => 'admin/driver-waybill/27/pickedup', //old
        'url'        => '#',
        'can'        => 'admin.client.profile',
        // 'classes'    => 'nav-link active',
        'id'         => 'dynamic-client-profile',
        // 'route'      => 'admin.profile.index',
        // 'icon'       => 'fas fa-fw fa-user',
        'icon' => 'fas fa-key',
//        'classes'    => 'bold-text',
        'active' => ['admin/*'],
    ],*/
    
    [
    'text'  => 'Modifier mon mot de passe',
    'route' => 'admin.user.profile',
    'icon'  => 'fas fa-key',
    'id'    => 'dynamic-user-profile',
    'active' => ['admin/users/*', 'admin/my-account'],
],

    
    [
    'text'  => 'Modifier mon profil',
    'route' => 'admin.client.profile',
    'can'   => 'admin.client.profile',
    // 'icon'  => 'fas fa-fw fa-user',
    'icon' => 'fas fa-user-edit',
    'id'    => 'dynamic-client-profile',
    'active' => ['admin/clients/*', 'admin/my-profile'],
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
                'text'       => 'Gestion des rôles',
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
