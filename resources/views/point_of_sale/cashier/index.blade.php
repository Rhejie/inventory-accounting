@extends('_layouts.cashier.default-pos')

@section('content')
<!-- Hidden buttons will show when the view became smaller-->
    <div class="container-fluid col-lg-12 d-lg-none d-xl-none" id="hidden-buttons">
        <div class="row">
            <div class="col-lg-6 col-md-3 col-sm-3 col-3 col-6 mb-1">
                <button type="button" class="btn col-lg-4 text-white btn-danger" data-toggle="collapse" href="#first-column" role="button" aria-expanded="false" aria-controls="first-column" style="background-color: #ff4500">
                    <i class="fas fa-list-ol"></i>
                    <span>Running Order</span>
                </button>
            </div>
            <div class="col-lg-6 col-md-3 col-sm-3 col-3 col-6 mb-1">
                <button type="button" id="btn-cart" class="btn col-lg-4 text-white" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="second-column third-column"  style="background-color: #9932cc">
                    <i class="fas fa-cart-plus"></i>
                    <span>Cart</span>
                </button>
            </div>
            <div class="col-lg-6 col-md-3 col-sm-3 col-3 col-6 mb-1">
                <button type="button" id="btn-product" class="btn col-lg-4 text-white" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="second-column third-column" style="background-color: #808080">
                    <i class="fas fa-warehouse"></i>
                    <span>Products</span>
                </button>
            </div>
            <div class="col-lg-6 col-md-3 col-sm-3 col-3 col-6 mb-1">
                <button type="button" class="btn col-lg-4 text-white" style="background-color: #8DB600">
                    <i class="fas fa-list"></i>
                    <span>Others</span>
                </button>
            </div>
        </div>
        <hr/>
    </div>
    <!-- End of hidden buttons -->

    <div class="container-fluid mt-1">
        <div class="row">
            <div id="first-column" class="col-lg-2 d-lg-block d-xl-block collapse">
                <div id="running_order">
                    <h5>Running Orders 
                        <span id="refresh_order" style="padding-left: 5px;">
                            <i class="fas fa-sync-alt" style="font-size: 15px;"></i>
                        </span>
                    </h5>
                    <div class="form-group" id="search-bar">
                        <span class="fa fa-search form-control-feedback" ></span>
                        <input type="text" id="search_running_orders" autocomplete="off" class="form-control" placeholder="Table, Order Number, Waiter, Customer">
                    </div>

                    <div id="orders_info" class="">
                        <div id="single_order_information">
                            <div id="order_info" >
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a  href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition1" role="button" aria-expanded="false" aria-controls="order_condition1"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition1">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition2" role="button" aria-expanded="false" aria-controls="order_condition2"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition2">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition3" role="button" aria-expanded="false" aria-controls="order_condition3"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition3">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition4" role="button" aria-expanded="false" aria-controls="order_condition4"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition4">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition5" role="button" aria-expanded="false" aria-controls="order_condition5"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition5">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition6" role="button" aria-expanded="false" aria-controls="order_condition6"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition6">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition7" role="button" aria-expanded="false" aria-controls="order_condition7"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition7">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition8" role="button" aria-expanded="false" aria-controls="order_condition8"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition8">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;"/>
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition9" role="button" aria-expanded="false" aria-controls="order_condition9"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition9">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;"/>
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition" role="button" aria-expanded="false" aria-controls="order_condition"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition" role="button" aria-expanded="false" aria-controls="order_condition"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition" role="button" aria-expanded="false" aria-controls="order_condition"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition" role="button" aria-expanded="false" aria-controls="order_condition"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition" role="button" aria-expanded="false" aria-controls="order_condition"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>

                        <div id="single_order_information">
                            <div id="order_info">
                                <p>
                                    <span id="running_order_customer_name">Cust: Walk-in Customer</span>
                                    <a href="#" class="text-dark">
                                        <i class="fas fa-chevron-right" data-toggle="collapse" href="#order_condition" role="button" aria-expanded="false" aria-controls="order_condition"></i>
                                    </a>
                                </p>
                                <p> 
                                    Table: <span id="running_order_table_name">None</span>
                                </p>
                            </div>
                            <div class="collapse" id="order_condition">
                                <p> 
                                    Waiter: <span id="running_order_waiter_name">Mr. Jonson</span>
                                </p>
                                <p> 
                                    Order: <span id="running_order_order_number">A 000187</span>
                                </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p class="order_processing">Started Cooking: 0/3</p>
                                <p class="order_done">Done: 3/3 </p>
                                <hr style="margin-top: 10px; margin-bottom: 5px;" />
                                <p>
                                    Time Count:
                                    <span id="order_min_count">12</span> : 
                                    <span id="order_sec_count">56</span> M
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="modify">
                        <button type="button" class="btn btn-block btn-dark mb-2">
                            <i class="far fa-edit"></i>
                            Modify Order
                        </button>
                    </div>
                    <div id="order-details">
                        <button type="button" class="btn border-dark btn-light btn-block mb-2">
                            <i class="fas fa-exclamation-circle"></i>
                            Order Details
                        </button>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <button id="btn-tooltip" type="button" class="btn border-dark btn-light" data-toggle="tooltip" data-placement="top" title="Print KOT" style="width: 100%;">KOT</button>
                        </div>
                        <div class="col-6">
                            <button id="btn-tooltip" type="button" class="btn border-dark btn-light" data-toggle="tooltip" data-placement="top" title="Print BOT" style="width: 100%;">BOT</button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <button type="button" class="btn border-dark btn-light" style="width: 100%;">Invoice</button>
                        </div>
                        <div class="col-6">
                            <button id="btn-tooltip" type="button" class="btn border-dark btn-light" data-toggle="tooltip" data-placement="top" title="Print bill for Customer Before Invoicing" style="width: 100%;">Bill</button>
                        </div>
                    </div>

                    <div id="cancel-order">
                        <button type="button" class="btn border-dark btn-block btn-light mb-2">
                            <i class="fas fa-ban"></i>
                            Cancel Order
                        </button>
                    </div>
                    <div id="kitchen-status">
                        <button type="button" class="btn border-dark btn-light btn-block mb-2">
                            <i class="fas fa-spinner"></i>
                            Kitchen Status
                        </button>
                    </div>
                </div>
            </div>
            <!-- End of 1st column / side bar -->

            <!-- Start of 2nd column / middle part  -->
            <div class="col-lg-5 mt-1 collapse ml-auto multi-collapse show" id="second-column">
                <!-- Div for navigation buttons -->
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                        <button id="btn-second-column-nav" class="btn text-dark btn-block  bg-white border-dark mb-1">
                            <span><i class="fas fa-utensils"></i></span>
                            <span>Dine In</span>
                        </button>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                        <button id="btn-second-column-nav" class="btn text-dark btn-block  bg-white border-dark mb-1">
                            <span><i class="fas fa-sign-out-alt"></i></span>
                            <span>Take Away</span>
                        </button>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                        <button id="btn-second-column-nav" class="btn text-dark btn-block  bg-white border-dark mb-1">
                            <span><i class="fas fa-truck"></i></span>
                            <span>Delivery</span>
                        </button>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                        <button id="btn-second-column-nav" class="btn text-dark btn-block  bg-white border-dark mb-1">
                            <span><i class="fas fa-table"></i></span>
                            <span>Table</span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 col-xl-5 col-lg-5 col-md-5 col-sm-5">
                        <div class="dropdown">
                            <button class="btn btn-sm border-dark btn-block bg-white dropdown-toggle d-inline-block text-truncate" data-toggle="dropdown" style="width: 105%;">
                                <span>Mr. Jonson</span>
                            </button>
                            <div class="dropdown-menu">
                                <div class="form-group container-fluid" id="search-bar">
                                    <span class="fa fa-search form-control-feedback" ></span>
                                    <input type="text" id="search_running_orders" autocomplete="off" class="form-control" placeholder="Search">
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Sample 1</a>
                                <a class="dropdown-item" href="#">Sample 2</a>
                                <a class="dropdown-item" href="#">Sample 3</a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown col-5 col-lg-5 col-md-5 col-sm-5">
                        <button class="btn btn-sm border-dark btn-block bg-white dropdown-toggle d-inline-block text-truncate" style="width: 105%;" data-toggle="dropdown">
                            <span class="">Walk-in Customer</span>
                        </button>
                        <div class="dropdown-menu">
                            <div class="form-group container-fluid" id="search-bar">
                                <span class="fa fa-search form-control-feedback" ></span>
                                <input type="text" id="search_running_orders" autocomplete="off" class="form-control" placeholder="Search">
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Sample 1</a>
                            <a class="dropdown-item" href="#">Sample 2</a>
                            <a class="dropdown-item" href="#">Sample 3</a>
                        </div>
                    </div>
                    <div class="col-1 col-lg-1 col-md-1 col-sm-1">
                        <div class="mt-1">
                            <a href="#" class="text-dark"><i class="fas fa-pencil-alt" style="font-size: 25px;"></i></a>
                        </div>
                    </div>
                    <div class="col-2 col-lg-1 col-md-1 col-sm-1">
                        <div class="">
                            <a href="#" class="text-dark"><i class="far fa-plus-square" style="font-size: 30px;"></i></a>
                        </div>
                    </div>
                </div>
            <!-- End of navigation buttons -->

                <div class="table-responsive py-2 table-customized"> 
                    <table class="table table-hover">
                        <thead class="thead-default">
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Discount</th>   
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                            </tr>
                            <tr>
                                <th scope="row">7</th>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                            </tr>
                            <tr>
                                <th scope="row">8</th>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                                <td>Sample</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-1">
                    <div class="col-lg-4 col-4">

                        Total Item <i class="fas fa-calendar-alt"></i> : 
                        0
                    </div>
                    <div class="col-lg-4 col-4">
                        Sub Total: 0.00
                    </div>
                    <div class="col-lg-4 col-4">
                        Discount <i class="fas fa-coins"></i> : 
                        0.00
                    </div>
                    <div class="col-lg-4 col-4">
                        Discount: 0
                    </div>
                    <div class="col-lg-4 col-4">
                        Tax <i class="far fa-eye-slash"></i> : 
                        0.00
                    </div>
                    <div class="col-lg-4 col-4">
                        Charge <i class="fas fa-cash-register"></i> : 
                        0.00
                    </div>
                </div>

                <hr/>
                <div class="col-lg-12 badge-dark">
                    <h4 class="text-center"> Total Payable : 0.00 </h4>
                </div>
                <hr/>

                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                        <button id="btn-second-column-bottom" class="btn text-white btn-block border-dark mb-1" style="background-color: #b22222; width: 100%;">
                            <span><i class="fas fa-times"></i></span>
                            <span>Cancel</span>
                        </button>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                        <button id="btn-second-column-bottom" class="btn text-white btn-block border-dark mb-1" style="background-color: #9932cc; width: 100%">
                            <span><i class="fas fa-clipboard-list"></i></span>
                            <span>Draft</span>
                        </button>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                        <button id="btn-second-column-bottom" class="btn text-white btn-block border-dark mb-1" style="background-color: #708090; width: 100%">
                            <span><i class="fas fa-file-invoice"></i></span>
                            <span>Quick Invoice</span>
                        </button>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                        <button id="btn-second-column-bottom" class="btn text-white btn-block border-dark mb-1" style="background-color: #9acd32; ">
                            <span><i class="fas fa-shopping-cart"></i></span>
                            <span>Place Order</span>
                        </button>
                    </div>
                </div>
            </div>
        <!-- End of 2nd column -->

            <!-- Start of 3rd column  -->
            <div class="col-lg-5">

            <div class="collapse multi-collapse show" id="third-column">
                <div class="container border rounded border-secondary">
                    <div class="form-group mt-1" id="search-bar">
                        <span class="fa fa-search form-control-feedback" ></span>
                        <input type="text" id="search_running_orders" autocomplete="off" class="form-control" placeholder="Name or Code or Category or VEG or BEV or BAR">
                    </div>
                    <div id="items_info" class="align-content-center">
                            <div class="row">
                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item1.jpeg" class="img-fluid imgDiv d-block">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name by gleent" style="max-width: 100%;">Sample Name by gleent</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item2.jpeg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item3.png" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>      
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item4.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>  
                                </div>
                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item5.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item6.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item7.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>  
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item8.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item9.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item10.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item11.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>      
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item12.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item13.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item14.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item15.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item16.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item17.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item18.png" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item19.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item20.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item17.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item18.png" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item19.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item20.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item17.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item18.png" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item19.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item20.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item17.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item18.png" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item19.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3 col-6">
                                    <div class="border rounded border-secondary m-1 mb-3 text-center item_information">
                                        <span class="d-block">Price:300.00</span>
                                        <img src="item20.jpg" class="img-fluid imgDiv">
                                        <span class="d-inline-block text-truncate" data-toggle="tooltip" data-placement="bottom" title="Sample Name" style="max-width: 100%;">Sample Name</span>
                                        <button class="btn btn-sm dropdown-toggle btn-block" data-toggle="dropdown">Sizes</button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Small</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Medium</button>
                                            <button type="button" class="btn btn-sm border-dark btn-light btn-block">Large</button>
                                        </div>  
                                    </div>
                                </div>

                            </div> <!-- end of row -->
                        </div> <!-- end of itemInfo div -->
                    </div>
                </div>
            </div>
        </div> <!-- 3rd column -->
        </div>
    </div>  

@endsection

@section('scripts')

<script type="text/javascript">
        function resize() {
            if ($(window).width() < 990) {
                if ($('#third-column').hasClass('show') && $('#second-column').hasClass('show')){
                    $('#third-column').removeClass('show');
                }
            }
            else {
                $('#third-column').addClass('show');
                $('#second-column').addClass('show');
            }
        }
        $(document).ready( function() {
            $(window).resize(resize);
            resize();
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>

@endsection