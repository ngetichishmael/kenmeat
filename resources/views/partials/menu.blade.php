<style>
    /* Add custom CSS styles for the main-menu container */
    .main-menu-container {
        max-height: calc(100vh - 100px); /* Set a max height with some padding at the bottom */
        overflow-y: auto; /* Enable vertical scrolling */
    }
</style>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header mb-3 mt-0">
        <ul class="nav navbar-nav flex-row " style="padding-top:10px;">
            <li class="nav-item me-auto">
                <a class="" href="#">
                    <center>
                        <img src="{!! asset('app-assets/images/logo.png') !!}" alt="Kenmeat" class="img"
                            style="height: 70px; padding-left:15px;">
                    </center>

                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item {!! Nav::isRoute('app.dashboard') !!}">
                <a class="d-flex align-items-center" href="{!! route('app.dashboard') !!}">
                    <i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Todo">
                        Dashboards</span>
                </a>
            </li>
            <li class="nav-item {!! Nav::isResource('customer') !!}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Todo">
                        Customers</span>
                </a>
                <ul class="menu-content">
                    <li style="padding-left: 30px"><a class="d-flex align-items-center {!! Nav::isRoute('customer') !!}"
                            href="{{ route('customer') }}"><i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">List</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center {!! Nav::isRoute('outlets') !!}"
                            href="{{ route('outlets') }}"><i data-feather='map-pin'></i><span class="menu-item text-truncate">Outlets</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center {!! Nav::isRoute('comment') !!}"
                            href="{{ route('CustomerComment') }}"><i data-feather='map-pin'></i><span
                                class="menu-item text-truncate">Comments</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {!! Nav::isResource('regions') !!}">
                <a class="d-flex align-items-center" href="#"><i data-feather="globe"></i><span
                        class="menu-title text-truncate" data-i18n="Invoice">Maps</span></a>
                <ul class="menu-content">
                    <li style="padding-left: 30px" class="nav-item {!! Nav::isResource('maps') !!}">
                        <a class="d-flex align-items-center" href="{!! route('maps') !!}">
                            <i data-feather="map-pin"></i><span class="menu-item text-truncate">Customers</span>
                        </a>
                    </li>
                    <li style="padding-left: 30px" class="nav-item {!! Nav::isResource('current-information') !!}">
                        <a class="d-flex align-items-center" href="{!! route('current-information') !!}">
                            <i data-feather="map-pin"></i><span class="menu-item text-truncate">Sales Agents</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {!! Nav::isResource('visits') !!}">
                <a class="d-flex align-items-center" href="#"><i data-feather='truck'></i><span
                        class="menu-title text-truncate" data-i18n="Invoice">Visits</span></a>
                <ul class="menu-content">
                    <li style="padding-left: 30px"><a class="nav-item {!! Nav::isResource('UsersVisits') !!} d-flex align-items-center"
                            href="{!! route('UsersVisits') !!}"><i data-feather="map-pin"></i><span
                                class="menu-item text-truncate">Users</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center" href="{!! route('CustomerVisits') !!}"><i
                                data-feather="map-pin"></i><span class="menu-item text-truncate">Customers</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center" href="{!! route('Checkins') !!}"><i
                                data-feather="map-pin"></i><span class="menu-item text-truncate">Checkins</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {!! Nav::isResource('orders') !!}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='shopping-cart'></i><span class="menu-title text-truncate" data-i18n="Todo">
                        Orders</span>
                </a>
                <ul class="menu-content">
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{{ route('orders.pendingorders') }}"> <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Pending Orders</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{{ route('orders.pendingdeliveries') }}"> <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Pending Deliveries</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center" href="{!! route('delivery.index') !!}"> <i data-feather='map-pin'></i>
                            <span class="menu-title text-truncate" data-i18n="Todo">
                                Delivery History</span>
                        </a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center" href="{!! route('orders.vansalesorders') !!}">
                        <i data-feather='map-pin'></i>
                           <span class="menu-title text-truncate" data-i18n="Todo">
                                Vansales Orders</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {!! Nav::isRoute('payment') !!}">
                <a class="d-flex align-items-center" href="{{ route('PaidPayment') }}">
                    <i data-feather="credit-card"></i><span class="menu-title text-truncate" data-i18n="Todo">
                        Payments</span>
                </a>
            </li>
            <li class="nav-item {!! Nav::isResource('warehousing') !!}">
                <a class="d-flex align-items-center" href="#"><i data-feather='archive'></i><span
                        class="menu-title text-truncate" data-i18n="Invoice"> Warehousing</span></a>
                <ul class="menu-content">
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{!! route('warehousing.index') !!}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">All
                                Warehouses</span></a></li>

                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{!! route('inventory.approval') !!}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Approve
                                Stock</span></a></li>
                 
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href=" {{ route('stock.lifts') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Stock Lifts</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{{ route('stock.recon') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Stock Reconciliation</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{{ route('Returns') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Returns</span></a>
                    </li>
                 
                                <!-- <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{!! route('supplier') !!}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Suppliers</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center {!! Nav::isRoute('customer.*') !!}"
                            href="{{ route('pricing') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Pricing</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{!! route('product.category') !!}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Categories</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{!! route('product.brand') !!}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Brands</span></a>
                    </li> -->
                </ul>
            </li>

            <li class="nav-item {!! Nav::isResource('StockLevel') !!}">
                <a class="d-flex align-items-center" href="{!! route('StockLevel') !!}"><i data-feather='tv'></i><span class="menu-title text-truncate" data-i18n="Invoice">Stock Level</span></a>
            </li>

           <!-- <li class="nav-item {!! Nav::isResource('stock') !!}">
                <a class="d-flex align-items-center" href="#"><i data-feather="layers"></i><span
                        class="menu-title text-truncate" data-i18n="Invoice">Stocks</span></a>
                <ul class="menu-content">
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href=" {{ route('stock.lifts') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Stock Lifts</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{{ route('stock.recon') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Stock Reconciliation</span></a>
                    </li>
              
                </ul>
            </li> -->

            <li class="nav-item {!! Nav::isResource('users') !!}">
                <a class="d-flex align-items-center" href="{!! route('users.list') !!}">
                    <i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Todo"> Users</span>
                </a>
                <!-- <ul class="menu-content">
                    <li style="padding-left: 50px"><a class="d-flex align-items-center"
                            href="{!! route('users.admins') !!}">
                            <span class="menu-item text-truncate">Admin</span></a>
                    </li>
                </ul> -->
            </li>

            <li class="nav-item {!! Nav::isResource('target') !!}">
                <a class="d-flex align-items-center" href="#"><i data-feather="target"></i><span
                        class="menu-title text-truncate" data-i18n="Invoice">Target</span></a>
                <ul class="menu-content">
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href=" {{ route('sales.target') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Sales</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{{ route('visit.target') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Visits</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{{ route('leads.target') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Leads</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{{ route('order.target') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Orders</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {!! Nav::isResource('regions') !!}">
                <a class="d-flex align-items-center" href="#"><i data-feather="map-pin"></i><span
                        class="menu-title text-truncate" data-i18n="Invoice">Regions</span></a>
                <ul class="menu-content">
                    <li style="padding-left: 30px">
                        <a class="d-flex align-items-center nav-item {!! Nav::isResource('regions') !!}"
                            href="{{ route('regions') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Regions</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center {!! Nav::isResource('subregions') !!}"
                            href="{{ route('subregions') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Sub
                                Regions</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center{!! Nav::isResource('areas') !!}"
                            href="{{ route('areas') }}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Routes</span></a>
                    </li>
                    <!-- <li class="nav-item {!! Nav::isResource('maps') !!}">
                        <a class="d-flex align-items-center" href="#"><span class="menu-title text-truncate"
                                data-i18n="Invoice">Maps</span></a>
                        <ul class="menu-content">
                            <li class="nav-item {!! Nav::isResource('maps') !!}">
                                <a class="d-flex align-items-center" href="{!! route('maps') !!}">
                                    <span class="menu-title text-truncate" data-i18n="Todo">
                                        Maps</span>
                                </a>
                            </li>
                            <li class="nav-item {!! Nav::isResource('current-information') !!}">
                                <a class="d-flex align-items-center" href="{!! route('current-information') !!}">
                                    <span class="menu-title text-truncate" data-i18n="Todo">
                                        Sales Agents</span>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                </ul>
            </li>
            <li class="nav-item {!! Nav::isResource('routes') !!}">
                <a class="d-flex align-items-center" href="">
                    <i data-feather='map'></i><span class="menu-title text-truncate" data-i18n="Todo"> Route
                        Scheduling</span>
                </a>
                <ul class="menu-content">
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href=" {!! route('routes.index') !!}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Assigned</span></a>
                    </li>
                    <li style="padding-left: 30px"><a class="d-flex align-items-center"
                            href="{!! route('routes.individual') !!}">
                            <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Individual</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {!! Nav::isResource('notification') !!}">
                <a class="d-flex align-items-center" href="{!! route('ChatSupport') !!}"><i
                        data-feather="message-circle"></i><span class="menu-title text-truncate"
                        data-i18n="Invoice">Chats</span></a>
            </li>
            <!-- <li class="nav-item {!! Nav::isResource('survey') !!}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="clipboard"></i><span class="menu-title text-truncate">Survey</span>
                </a>
                <ul class="menu-content">
                    <li style="padding-left: 30px">
                        <a class="d-flex align-items-center" href="{!! route('survey.index') !!}">
                           <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Survey</span>
                        </a>
                    </li>
                    <li style="padding-left: 30px">
                        <a class="d-flex align-items-center {!! Nav::isResource('survey') !!}" href="{!! route('SurveryResponses') !!}">
                           <i data-feather='map-pin'></i>
                            <span class="menu-item text-truncate">Responses</span>
                        </a>
                    </li>
                </ul>
            </li> -->
            <li class="nav-item {!! Nav::isResource('reports') !!}">
                <a class="d-flex align-items-center" href="{!! route('users.reports') !!}"><i
                        data-feather='book-open'></i><span class="menu-title text-truncate" data-i18n="Invoice">All
                        Reports</span></a>
            </li>
            <li class="nav-item {!! Nav::isResource('MerchandiserReport') !!}">
                <a class="d-flex align-items-center" href="{!! route('MerchandiserReport') !!}"><i data-feather='tv'></i><span class="menu-title text-truncate" data-i18n="Invoice">Promo Reports</span></a>
            </li>


            <li class="nav-item {!! Nav::isResource('Activity') !!}">
                <a class="d-flex align-items-center" href="{!! route('activity.index') !!}"><i
                        data-feather='file-text'></i><span class="menu-title text-truncate" data-i18n="Invoice">Activity Logs</span></a>
            </li>

        </ul>

    </div>
</div>
