
<?php


include_once('connect_sql.php');

// session_start();
// error_reporting(0);
session_name("broker");
session_start();

include_once('includes/fx_alert_date.php');

// $near_to_due_list = near_to_due_list($conn);
// $count_due = count($near_to_due_list);
// $overdue_list = overdue_list($conn);
// $count_overdue = count($overdue_list);
$near_to_due_list = near_to_due_list($conn);
$count_due = count($near_to_due_list);

$overdue_list = near_to_overdue_list_topbar($conn);
$count_overdue = count($overdue_list);

?>
<title>Broker Install Direct</title>



<!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
 <!-- Topbar -->
                <!-- mb-4 -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar  static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->


                  <!--   <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" style="margin-left: 500px;">
                        <i class="fa fa-bars"></i>
                    </button> -->
                    <!-- style="margin-left: 10px;" -->
                     <button id="sidebarToggleTop" class="btn btn-link  " style="margin-left: 10px;" >
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                   <!--  <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->

                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!--<i class="fas fa-bell fa-fw " style="color: yellow;"></i>-->
								<i class="fas fa-bell fa-fw bellIcon2"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-light badge-counter"><?php echo ($count_due > 0) ? $count_due : '';?></span>
                            </a>
                                                                                   
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Poilcy to Due
                                </h6>
                                
                                <!-- 
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                
                                
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>  -->
                                <?php
                                $max = ($count_due > 3 ) ? 3 : $count_due;
                                $ctr =0;                                                        
                                if ($count_due > 0) {                               
                                do {
                                    $customer = $near_to_due_list[$ctr]['customer_name'];
                                ?>
                                <a class="dropdown-item d-flex align-items-center" href="entry-policy-due.php">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?php echo date('d-m-Y');?></div>
                                        <?php echo $near_to_due_list[$ctr]['policy_no'] . ' - ' .$customer ; ?>
                                    </div>
                                </a>
                                <?php 
                                $ctr++;
                                }while($ctr < $max); 
                                } // If count_due > 0
                                ?>
                                <a class="dropdown-item text-center small text-gray-500" href="entry-policy-due.php">Show All Alerts</a>
                            </div>
                        </li>
                        
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!--<i class="fas fa-bell fa-fw" style="color: red;"></i>-->
								<i class="fas fa-bell fa-fw bellIcon1"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-light badge-counter"><?php echo ( $count_overdue > 0 ) ? $count_overdue : '';?></span>
                            </a>
                                                                                   
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Overdue Policy
                                </h6>
                                <!-- 
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                 -->
                                 <?php
                                $max = ($count_overdue > 3 ) ? 3 : $count_overdue;
                                $ctr =0;
                                if ($count_overdue > 0) {
                                do {
                                    $customer = $overdue_list[$ctr]['customer_name'];
                                ?>
                                <a class="dropdown-item d-flex align-items-center" href="entry-policy-overdue.php">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?php echo date('d-m-Y');?></div>
                                       <?php echo $overdue_list[$ctr]['policy_no'] . ' - ' .$customer ; ?>
                                    </div>
                                </a>
                                 <?php 
                                $ctr++;
                                }while($ctr < $max); 
                                } // If count_due > 0
                                ?>
                                <a class="dropdown-item text-center small text-gray-500" href="entry-policy-overdue.php">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">0</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <!-- <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="images/65cc779d5b61c.png"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a> -->
                                
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        
                        <li class="nav-item nav-item1 dropdown no-arrow">
                            <a class="nav-link nav-link1 dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['name']; ?>
                                </span>
                            <?php if(strlen($_SESSION['image'])!=""){ ?>
                                <img class="img-profile rounded-circle" src="image.php?filename=<?php echo $_SESSION['image']; ?>">
                            <?php } ?>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                               <!--  <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">Are you sure you want to Logout.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
 <!-- End of Topbar -->

 <!-- Start of loading -->
         
    <script >
        function valid() {
            // แสดง Loading overlay
            document.getElementById("loading-overlay").style.display = "flex"; // แสดง overlay

             // ให้ฟอร์มทำการ submit ต่อไป
            return true;
        }
    </script>

    <style>
        h1, h2, h3, h4, h5, h6, b, span, p, table, a, div, label, ul, li, div,
    button {
        font-family: Manrope, 'IBM Plex Sans Thai';
    }
    
    .bootstrap-select.btn-group .dropdown-toggle .caret {
        right: 10px !important;
		
    }
    
    @media all and (max-width:30em){
        .bootstrap-select.btn-group .dropdown-toggle .caret {
            margin-top: -4px !important;
        }   
    }
    
    @media all and (min-width: 768px){
        .bootstrap-select.btn-group .dropdown-toggle .caret {
            margin-top: -4px !important;
        }   
    }
	
	.btn-group>.btn:first-child {
		border-color: #102958;
	}
	
	#loading-overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5); /* ความโปร่งใสของสีดำ */
		display: none; /* ก่อนที่จะแสดง */
		justify-content: center;
		align-items: center;
	}

	#loading-overlay img {
		width: 50px; /* ขนาดของ Loading.gif */
		height: 50px;
	}
	
	.nav-item1 .nav-link1 .fa-fw:hover path {
		fill: #000 !important; 
	}
	
	.nav-item1 .nav-link1:hover .fa-fw path,
	.nav-item1 .nav-link1:hover .fa-fw,
	.nav-item1 .nav-link1:hover span {
		color: #000 !important;
	}
	
	.bellIcon1 {
		color: #ff0000; 
	}

	.bellIcon1:hover {
		color: #bb0404; 
	}
	
	.bellIcon2 {
		color: #e7df09; 
	}

	.bellIcon2:hover {
		color: #cbc40a; 
	}

    </style>


 <!-- End of loading -->