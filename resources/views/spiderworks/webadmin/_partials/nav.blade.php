<nav class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">

        {{config('app.name')}}
        <div class="sidebar-header-controls" style="padding-left:80px">

            <button type="button" class="btn btn-link d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
            </button>
        </div>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu" style="margin-top: 20px;">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        @widget('\Spiderworks\Webadmin\Widgets\AdminMenu')

        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</nav>