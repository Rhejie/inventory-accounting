<?php
// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'title' => 'Dashboard',
            'root' => true,
            'icon' => 'flaticon-home', // or can be 'flaticon-home' or any flaticon-*
            'page' => 'dashboard',
            'new-tab' => false,
        ],

        // Screen
        // [
        //     'title' => 'Point of Sale',
        //     'root' => true,
        //     'icon' => 'media/svg/icons/Devices/iMac.svg', // or can be 'flaticon-home' or any flaticon-*
        //     'arrow'=> true,
        //     'submenu' => [
        //         [
        //             'title' => 'Cashier',
        //             'bullet' => 'dot',
        //             'icon' => 'media/svg/icons/Shopping/Barcode.svg',
        //             'page' => 'point-of-sale/cashier',
        //         ],
        //         [
        //             'title' => 'Kitchen',
        //             'bullet' => 'dot',
        //             'icon' => 'media/svg/icons/Food/Miso-soup.svg',
        //             'page' => 'point-of-sale/kitchen',
        //         ],
        //         [
        //             'title' => 'Waiter',
        //             'bullet' => 'dot',
        //             'icon' => 'media/svg/icons/Cooking/Dinner.svg',
        //             'page' => 'point-of-sale/waiter',
        //         ]

        //     ]
        // ],

        // Customer
        [
            'title' => 'Projects',
            'root' => true,
            'icon' => 'media/svg/icons/General/User.svg', // or can be 'flaticon-home' or any flaticon-*
            'arrow'=> true,
            'submenu' => [
                [
                    'title' => 'Project List',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Clothes/Tie.svg',
                    'page' => 'project',
                ]
            ]
        ],

        // Sale
        [
            // 'title' => 'Sale',
            'title' => 'Transaction',
            'root' => true,
            'icon' => 'media/svg/icons/Shopping/Sale2.svg', // or can be 'flaticon-home' or any flaticon-*
            'arrow' => true,
            'submenu' => [
                [
                    // 'title' => 'Invoice',
                    'title' => 'Job Order',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'sale/invoice',
                ],
                [
                    'title' => 'Quotation',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'sale/quotation',
                ],
                [
                    // 'title' => 'Daily Sales',
                    'title' => 'Billing',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'sale/daily-sales',

                ],
                [
                    // 'title' => 'Void / Return',
                    'title' => 'Collection',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'sale/void',
                ],


            ]
        ],



         // fix asset inventory
        [
            'title' => 'Fixed Assets Inventory',
            'root' => true,
            'icon' => 'media/svg/icons/General/clipboard.svg', // or can be 'flaticon-home' or any flaticon-*
            'arrow' => true,
            'submenu' => [
                [
                    // 'title' => 'All',
                    'title' => 'Fixed Assets',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'inventory/assets/fixed/assets',
                ],
                [
                    'title' => 'Heavy Equipment',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => '/heavy-equipment#/heavy-equipment-list',
                ],
                [
                    'title' => 'Truck / Vehicle',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'inventory/assets/vehicles',

                ],
                [
                    'title' => 'Others',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'inventory/assets/others',
                ],

                 [
                    'title' => 'Categories',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'inventory/categories',
                ],

                 [
                    'title' => 'Types',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'inventory/categories/types',
                ],


            ]
        ],




         /*
         // Product
         [
            'title' => 'Product',
            'root' => true,
            'icon' => 'media/svg/icons/Shopping/Bag2.svg', // or can be 'flaticon-home' or any flaticon-*
            'arrow' => true,
            'submenu' => [
                [
                    'title' => 'Product Category',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'product/product-category',
                ],
                [
                    'title' => 'Stock Management',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'product/stock-management',
                ],
                [
                    'title' => 'Stock Adjustment',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'product/stock-adjustment',
                ],
                [
                    'title' => 'Defect Item',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'product/defect-item',
                ],


            ]
        ],

        */


         // Purchase
         [
            'title' => 'Purchase',
            'root' => true,
            'icon' => 'media/svg/icons/Shopping/Rouble.svg', // or can be 'flaticon-home' or any flaticon-*
            'arrow' => true,
            'submenu' => [
                [
                    'title' => 'Supplier Management',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'purchase/supplier-management'
                ],
                [
                    'title' => 'Purchase Order',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'purchase/purchase-order'
                ],
                [
                    'title' => 'Purchase Received',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'purchase/purchase-received'
                ],
                [
                    'title' => 'Return Item to Supplier',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Design/Layers.svg',
                    'page' => 'purchase/return-item-to-supplier'
                ],


            ]
        ],

        // Reports
        [
            'section' => 'Reports',
        ],
        [
            'title' => 'Summary Report',
            'icon' => 'media/svg/icons/Files/Folder.svg',
            'bullet' => 'line',
            'root' => true,
            'arrow'=> true,
            'submenu' => [
                [
                    'title' => 'Income Summary',
                    'bullet' => 'dot',
                    'page' => ''

                ],
                [
                    'title' => 'Expense Summary',
                    'bullet' => 'dot',
                    'page' => ''

                ],
                [
                    'title' => 'Sale Summary',
                    'bullet' => 'dot',
                    'page' => ''

                ],
                [
                    'title' => 'Purchase Summary',
                    'bullet' => 'dot',
                    'page' => ''

                ],
                [
                    'title' => 'Product Sale Summary',
                    'bullet' => 'dot',
                    'page' => ''

                ]

            ],


        ],

        // Financial Report
        [
            'title' => 'Financial Report',
            'root' => true,
            'icon' => 'media/svg/icons/General/User.svg', // or can be 'flaticon-home' or any flaticon-*
            'arrow'=> true,
            'submenu' => [
                [
                    'title' => 'Profit and Loss',
                    'bullet' => 'dot',
                    'icon' => 'media/svg/icons/Clothes/Tie.svg',
                    'page' => 'reporet/financial-summary',
                ]
            ]
        ],

         // Custom
        [
            'section' => 'Settings',
        ],
        [
            'title' => 'General Settings',
            'icon' => 'media/svg/icons/General/Settings-1.svg',
            'bullet' => 'line',
            'root' => true,
            'arrow' => true,
            'submenu' => [
                [
                    'title' => 'Users',
                    'bullet' => 'dot',
                    'submenu' => [
                        [
                            'title' => 'List - Default',
                            'page' => 'test',
                        ],
                        [
                            'title' => 'List - Datatable',
                            'page' => 'custom/apps/user/list-datatable'
                        ],

                    ]
                ],

            ]
        ],

    ]

];
