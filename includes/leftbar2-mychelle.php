<?php
    session_start();
    $id_page = 0;
    // for($i=0;$i<count($_SESSION["strSession"]);$i++){

    // }
    // if(in_array(,$_SESSION["strSession"][][0])){

    // }else
    
?>  
<!-- class="navbar-nav sidebar sidebar-dark accordion" -->
        <ul style="background-color:#102958;" class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <a   class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <img src="images/logo_small.png" width="90%"  alt="">
            </a>

            <li  class="nav-item" >
                <a class="nav-link" href="Dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <?php //$page_policy = array("1", "2", "3"); //if (in_array($page_policy,$_SESSION['application_page'][0])) { 
                if($_SESSION['entry']==1){ ?>
            <li class="nav-item ">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#entry" aria-expanded="true"
                    aria-controls="entry">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Entry Policy</span>
                </a>
                <div id="entry" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <?php if (in_array("1",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="entry-policy.php">New Policy</a>
                        <?php } ?>
                        <?php if (in_array("2",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="entry-policy-due.php">Due Policy</a>
                        <?php } ?>
                        <?php if (in_array("3",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="entry-policy-overdue.php">Overdue Policy</a>
                        <?php } ?>
                    </div>
                </div>
            </li>
             <?php } ?>

            <?php if (in_array("4",$_SESSION['application_page'])) { ?>    
            <li class="nav-item">
                <a class="nav-link" href="customer-information.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Customer List</span></a>
            </li>
            <?php } ?>

            <?php if (in_array("5",$_SESSION['application_page'])) { ?>
            <li class="nav-item">
                <a class="nav-link" href="insurance-partner.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Partners List</span></a>
            </li>
            <?php } ?>

            <?php if (in_array("6",$_SESSION['application_page'])) { ?>
            <li class="nav-item">
                <a class="nav-link" href="product-management.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Products Management</span></a>
            </li>
            <?php } ?>

            <?php if (in_array("7",$_SESSION['application_page'])) { ?>
            <li class="nav-item">
                <a class="nav-link" href="agent-management.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Agent Management</span></a>
            </li>
            <?php } ?>

            <?php //$page_report = array("9","10","11","12","13","14","15"); //if ( 
              if($_SESSION['report']==1){ ?>
             <li class="nav-item ">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report" aria-expanded="true"
                    aria-controls="report">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Reports</span>
                </a>
                <div id="report" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <?php if (in_array("9",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item " href="report-customer_list.php">Customer List</a><?php } ?>
                        <?php if (in_array("10",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item " href="report-partner_list.php">Partners List</a><?php } ?>
                        <?php if (in_array("11",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item " href="report-customer-sales-total.php">Sales By Customer</a><?php } ?>
                        <?php if (in_array("12",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item " href="report-product-sales.php">Sales By Products</a><?php } ?>
                        <?php if (in_array("13",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item " href="report-monthly-sales.php">Monthly Sales</a><?php } ?>
                        <?php if (in_array("14",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item " href="report-sales-commission.php">Commission Report</a><?php } ?>
                        <?php if (in_array("15",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item " href="report-history.php">History Report</a><?php } ?>

                    </div>
                </div>
            </li>
            <?php } ?>

            

            <?php //if (in_array("18" || "19" || "20" || "21" || "22" || "23" || "24",$_SESSION['application_page'])) { 
                 if($_SESSION['setting']==1){ ?>
            <li class="nav-item ">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true"
                    aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Setting</span>
                </a>
                <div id="collapseTwo2" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <?php if (in_array("18",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="companylist.php">Company Setting</a><?php } ?>
                        <?php if (in_array("19",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="alert-date-settings.php">Alert Date</a><?php } ?>
                        <?php if (in_array("20",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="products_categories.php">Products Categories</a><?php } ?>
                        <?php if (in_array("21",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="sub_categories.php">Sub Categories</a><?php } ?>
                        <?php if (in_array("22",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="period.php">Period</a><?php } ?>
                        <?php if (in_array("23",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="currency_list.php">Currency List</a><?php } ?>
                        <?php if (in_array("24",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="currency_convertion.php">Currency Conversions</a><?php } ?>
                        <?php if (in_array("25",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="customer_level.php">Customer Leval</a><?php } ?>
                        <!-- companylist.php -->
                    </div>
                </div>
            </li>
            <?php } ?>

            <?php //if (in_array("16" || "17",$_SESSION['application_page'])) { 
                if($_SESSION['user']==1){ ?>
            <li class="nav-item ">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                    aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>User Set Up</span>
                </a>
                <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <?php if (in_array("16",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item" href="manage-role.php">User Role</a><?php } ?>
                        <?php if (in_array("17",$_SESSION['application_page'])) { ?>
                        <a class="collapse-item " href="manage-user.php">User Management</a><?php } ?>
                    </div>
                </div>
            </li>
            <?php } ?>

            <li class="nav-item">
                <a class="nav-link" href="change-password.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Change Password</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

        </ul>
        <!-- End of Sidebar -->