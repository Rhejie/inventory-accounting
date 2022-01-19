
<!--begin::Aside-->
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">

    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">

        <!--begin::Logo-->
        <a href="/" class="brand-logo" style="text-align: center">
            {{-- <img alt="Logo" src="{{ asset('/media/logos/logo-light.png') }}" /> --}}
            <img src="/img/company-logo.png" alt="logo" style="width: 100%; height: auto; ">
        </a>

        <!--end::Logo-->

        <!--begin::Toggle-->
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">

                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                        <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                    </g>
                </svg>

                <!--end::Svg Icon-->
            </span>
        </button>

        <!--end::Toolbar-->
    </div>

    <!--end::Brand-->

    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">

            <!--begin::Menu Nav-->
            <ul class="menu-nav">
                {{-- {{ Menu::renderVerMenu(config('menu_aside.items')) }} --}}
                <li class="menu-item {{ Route::is('dashboard.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                    <a href="/inventory/dashboard" class="menu-link">
                        <i class="menu-icon flaticon-home"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item menu-item-submenu {{ Route::is('project')? 'menu-item-open' : ''}} " aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="menu-icon fas fa-project-diagram"></i>
                        <span class="menu-text">Projects</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item {{ Route::is('project')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/project#/project-list" class="menu-link">
                                    <i class="menu-icon fas fa-list-ul">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Project List</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-item menu-item-submenu
                    {{ Route::is('heavy-equipment.index')? 'menu-item-open' : ''}}
                    {{ Route::is('truck-vehicle.index')? 'menu-item-open' : ''}}
                    {{ Route::is('other-invetory.index')? 'menu-item-open' : ''}}
                    {{ Route::is('fixed-asset.index')? 'menu-item-open' : ''}}
                    {{ Route::is('type-inventory.index')? 'menu-item-open' : ''}}
                    {{ Route::is('category-inventory.index')? 'menu-item-open' : ''}}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="menu-icon fas fa-cube"></i>
                        <span class="menu-text">Fixed Assets Inventory</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item {{ Route::is('fixed-asset.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/fixed-asset#/fixed-asset-list" class="menu-link">
                                    <i class="menu-icon fas fa-campground">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Fixed Assets</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('heavy-equipment.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/heavy-equipment#/list" class="menu-link">
                                    <i class="menu-icon fas fa-baby-carriage">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Heavy Equipment</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('truck-vehicle.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/truck-vehicle#/list-truck-vehicle" class="menu-link">
                                    <i class="menu-icon fas fa-car-side">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Truck / Vehicle</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('other-invetory.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/other-inventory#/other-inventory" class="menu-link">
                                    <i class="menu-icon fas fa-th-list">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Others</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('category-inventory.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/category-inventory#/category-inventory-list" class="menu-link">
                                    <i class="menu-icon fas fa-sitemap">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Categories</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('type-inventory.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/type-inventory#/type-inventory-list" class="menu-link">
                                    <i class="menu-icon fas fa-question-circle">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Types</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-item menu-item-submenu
                {{ Route::is('consumable-inventory.index')? 'menu-item-open' : ''}}
                {{ Route::is('consumable-supply.index')? 'menu-item-open' : ''}}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="menu-icon fas fa-cube"></i>
                        <span class="menu-text">Consumable Inventory</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <li class="menu-item {{ Route::is('consumable-inventory.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/consumable-items#/consumable-inventory" class="menu-link">
                                    <i class="menu-icon fas fa-th-list">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Items</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('consumable-supply.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/consumable-supply#/consumable-supply" class="menu-link">
                                    <i class="menu-icon fas fa-th-list">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Supplies</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-item menu-item-submenu
                {{ Route::is('supplier-management.index')? 'menu-item-open' : ''}}
                {{ Route::is('request-material.index')? 'menu-item-open' : ''}}
                {{ Route::is('purchase-order.index')? 'menu-item-open' : ''}}
                {{ Route::is('purchase-recieve.index') ? 'menu-item-open' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="menu-icon fas fa-cube"></i>
                        <span class="menu-text">Purchase</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item {{ Route::is('supplier-management.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/supplier-management#/supplier-management" class="menu-link">
                                    <i class="menu-icon fas fa-campground">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Supplier Management</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('request-material.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/request-material#/request-material" class="menu-link">
                                    <i class="menu-icon fas fa-baby-carriage">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Request Material</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('purchase-order.index') ? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/purchase-order#/purchase-order" class="menu-link">
                                    <i class="menu-icon far fa-newspaper">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Purchase Order</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('purchase-recieve.index') ? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/purchase-recieved#/purchase-recieved" class="menu-link">
                                    <i class="menu-icon far fa-check-circle">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Purchase Received</span>
                                </a>
                            </li>
                            {{-- <li class="menu-item" aria-haspopup="true">
                                <a href="/purchase-recieved#/purchase-recieved" class="menu-link">
                                    <i class="menu-icon fas fa-th-list">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Return Item to Supplier</span>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </li>
                <li class="menu-item menu-item-submenu
                {{ Route::is('consumable-supply-out.index')? 'menu-item-open' : ''}}
                {{ Route::is('asset-stock-out.index')? 'menu-item-open' : ''}}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="menu-icon fas fa-cube"></i>
                        <span class="menu-text">Stock Out</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <li class="menu-item {{ Route::is('consumable-supply-out.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/consumable-supply-stock-out#/consumable-item-stock-out" class="menu-link">
                                    <i class="menu-icon fas fa-th-list">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Consumable Supplies</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('asset-stock-out.index')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/fixed-asset-stock-out#/fixed-asset-stock-out" class="menu-link">
                                    <i class="menu-icon fas fa-th-list">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Fixed Assets</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- setting --}}
                <li class="menu-section">
                    <h4 class="menu-text">Settings</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                <li class="menu-item menu-item-submenu {{ Route::is('setting.project-status')? 'menu-item-open' : ''}}
                        {{ Route::is('setting.job-order-type')? 'menu-item-open' : ''}}
                        {{ Route::is('setting.bill-of-material')? 'menu-item-open' : ''}}
                        {{ Route::is('setting.maintenance-type')? 'menu-item-open' : ''}}" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Shopping/Box2.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" fill="#000000" />
                                    <path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-text">General Settings</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li class="menu-item {{ Route::is('setting.project-status')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/setting-project#/project-status" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Project Status</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('setting.maintenance-type')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/setting-maintenance#/maintenance-type" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Maintenance Type</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('setting.job-order-type')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/setting-job-order#/job-order-type" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Job Order Type</span>
                                </a>
                            </li>
                            <li class="menu-item {{ Route::is('setting.bill-of-material')? 'menu-item-active' : ''}}" aria-haspopup="true">
                                <a href="/setting-bill-of-material" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Bill Of Material</span>
                                </a>
                            </li>
                        </ul>

                    </div>
                </li>
            </ul>

            <!--end::Menu Nav-->
        </div>

        <!--end::Menu Container-->
    </div>

    <!--end::Aside Menu-->
</div>

<!--end::Aside-->
