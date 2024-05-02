<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" > -->
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>

         <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script> -->
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


</head>
<style>
	.style-linechart{
		display: block;
		box-sizing: border-box;
		height: 100% !important;
		width: 100% !important;
	}
	.chart-area {
		height: 100%;
	}
	
	.border-left-warning-2 {
		border-left: .25rem solid #dd8337 !important;
	}
	.text-warning-2 {
		color: #dd8337 !important;
	}
		
	
	
	@media (max-width: 768px) {
		.chart-bar {
			height: 100%;
			width: 100% !important;
		}
		.style-StackedBar {
			display: block;
			box-sizing: border-box;
			height: 100% !important;
			width: 100% !important;
		}
		canvas {
			max-width: 100%;
			height: auto;
		}		
	}
	@media (min-width: 768px) {
		.chart-bar {
			height: 70% !important;
			width: 100% !important;
		}
		
	}
	@media (max-width: 375px) {
		.chart-bar {
			height: 50% !important;
			width: 100% !important;
		}
		.style-StackedBar {
			display: block;
			box-sizing: border-box;
			height: 50% !important;
			width: 100% !important;
		}
		canvas {
			max-width: 100%;
			height: auto;
		}
		.myDonutChart {
			position: relative;
			height: auto !important;
			width: 70% !important;
			max-width: !important;
		}
		.chart-pie {
			position: relative;
			height: auto !important;
			width: 100% !important;
		}
	}
	
	h1, h2, h3, h4, h5, h6, b, span, p, table, a, div, label, ul, li, div,
	button {
		font-family: Manrope, 'IBM Plex Sans Thai';
	}
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include('includes/leftbar2.php');?>   
        <?php include('includes/topbar2.php');?>  
        
		
		<!-- check_folder_size -->
		<!-- include_once -->
		<?php //include('check_folder_size.php');?>
		<!-- Popup modal -->
		<!--
		<div id="Modalcksize" class="modal">
			<div class="modal-content">
				<span class="close">&times;</span>
				<p>The folder is nearly full!</p>
			</div>
		</div>
		-->
		<script>
			// alert('Start');
			$(document).ready(function() {
				// ตรวจสอบว่ามีค่าคุกกี้หรือ session อยู่แล้วหรือไม่
				if (document.cookie.split(';').some((item) => item.trim().startsWith('modalDisplayedDate='))) {
					// return; // ถ้ามีแล้วก็ออกจากฟังก์ชัน	
				}else{
					// alert('not checked');
								$.ajax({
									url: 'check_folder_size_json.php',
									type: 'GET',
									success: function(response) {
										data = JSON.parse(response);
										//alert('data.alert:'+data.alert);
										if (data.alert) {
											//var message = "The folder at " + data.folderPath + " is nearly full. Remaining space: " + data.remainingSizeGB + " GB.";
											var message = "Low disk space warning for the folder. "  + " Remaining space: " + data.remainingSizeGB + " GB.";
											alert(message);
											// เซ็ตค่าคุกกี้เมื่อแสดง Modal แล้ว
											setModalDisplayedCookie();
											show();
										}
									}
								});

				}

				// ฟังก์ชันเพื่อแสดง Modal
				var show = function() {
					$('#Modalcksize').modal('show');
				};

				// เซ็ตค่าคุกกี้เมื่อแสดง Modal แล้ว
				function setModalDisplayedCookie() {
					var date = new Date();
					date.setTime(date.getTime() + (1 * 24 * 60 * 60 * 1000)); // กำหนดให้คุกกี้หมดอายุใน 1 วัน
					document.cookie = "modalDisplayedDate=" + date.toUTCString() + "; path=/";
				}

				// // แสดง Modal
				// show();

				// เซ็ตค่าคุกกี้
				setModalDisplayedCookie();

				// ตรวจสอบว่ามีค่า session หรือคุกกี้อยู่หรือไม่ และไม่ให้แสดง Modal เมื่อมีการ refresh หน้าเว็บ
				if (!sessionStorage.getItem('modalDisplayed') && !document.cookie.split(';').some((item) => item.trim().startsWith('modalDisplayedDate='))) {
					sessionStorage.setItem('modalDisplayed', 'true');
				} else {
					$('#Modalcksize').modal('hide');
				}
			});
		</script>


		<!-- check_folder_size -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
						<!-- Total Policy MONTHLY(New, Follow Up, Renew )-->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							// Query to get the number of policies that will expire within the next month
							//$sql = "SELECT COUNT(*) AS num_policies, SUM(premium_rate) AS total_premium FROM [brokerapp].[dbo].[insurance_info] WHERE DATEDIFF(month, GETDATE(), end_date) = 1";
							//$sql = "SELECT COUNT(*) AS num_policies, SUM(premium_rate) AS total_premium FROM [brokerapp].[dbo].[insurance_info] WHERE status IN ('New', 'Follow Up', 'Renew')";
							$sql = "SELECT COUNT(*) AS num_policies, SUM(premium_rate) AS total_premium FROM [brokerapp].[dbo].[insurance_info] WHERE status IN ('New', 'Follow Up', 'Renew') AND MONTH(paid_date) = MONTH(GETDATE()) AND YEAR(paid_date) = YEAR(GETDATE())";
					
							$stmt = $dbh->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetch(PDO::FETCH_ASSOC);

							$num_policies = $result['num_policies'];
							$total_premium = $result['total_premium'];
						?>
						
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-primary shadow h-100 py-2">
								<a href="entry-policy.php" style="text-decoration: none; color: inherit;">
									<div class="card-body">
										<div class="row">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: medium;">Total Policy</div>
												<div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: medium;">(Monthly)</div>
												<div class="text-xs font-weight-bold text-primary text-uppercase mt-3">Total Policy </div>
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo $num_policies; ?></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-calendar fa-2x text-gray-300"></i>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col">
												<div class="text-xs font-weight-bold text-primary text-uppercase mb-0">Total Premium </div>
												<!--<div class="h5 mb-0 font-weight-bold text-gray-800">฿<?php //echo number_format($total_premium); ?></div>-->
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo isset($total_premium) ? '฿' . number_format($total_premium, 0, '.', ',') : '฿0'; ?></div>
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<!-- ToTal Policy status=New -->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							try {
								$sql = "SELECT COUNT(*) AS num_policies, FORMAT(SUM(premium_rate), N'฿#,##0') AS total_premium
										FROM [brokerapp].[dbo].[insurance_info]
										WHERE status = 'New' AND MONTH(paid_date) = MONTH(GETDATE()) AND YEAR(paid_date) = YEAR(GETDATE())";
								$stmt = $dbh->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetch(PDO::FETCH_ASSOC);

								$num_policies = $result['num_policies'];
								$total_premium = $result['total_premium'];
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}
						?>

						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-success shadow h-100 py-2">
								<a href="entry-policy.php" style="text-decoration: none; color: inherit;">
									<div class="card-body">
										<div class="row ">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: medium;">Policy</div>
												<div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: medium;">(New)</div>
												<div class="text-xs font-weight-bold text-success text-uppercase mt-3">Total Policy </div>
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo $num_policies; ?></div>
											</div>
											<div class="col-auto">
												<!--<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>-->
												<i class="fa fa-btc fa-2x text-gray-300"></i>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col">
												<div class="text-xs font-weight-bold text-success text-uppercase mb-0">TOTAL PREMIUM</div>
												<!--<div class="h5 mb-0 font-weight-bold text-gray-800"><?php //echo $total_premium; ?></div>-->
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo isset($total_premium) ? $total_premium : '฿0'; ?></div>
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<!-- ToTal Policy status=Renew -->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							try {
								$sql = "SELECT COUNT(*) AS num_policies, FORMAT(SUM(premium_rate), N'฿#,##0') AS total_premium
										FROM [brokerapp].[dbo].[insurance_info]
										WHERE status = 'Renew' AND MONTH(paid_date) = MONTH(GETDATE()) AND YEAR(paid_date) = YEAR(GETDATE())";
								$stmt = $dbh->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetch(PDO::FETCH_ASSOC);

								$num_policies = $result['num_policies'];
								$total_premium = $result['total_premium'];
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}
						?>

						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-info shadow h-100 py-2">
								<a href="entry-policy.php" style="text-decoration: none; color: inherit;">
									<div class="card-body">
										<div class="row ">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: medium;">Policy</div>
												<div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: medium;">(Renew)</div>
												<div class="text-xs font-weight-bold text-info text-uppercase mt-3">TOTAL Policy</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo $num_policies; ?></div>
											</div>
											<div class="col-auto">
												<i class="fa fa-btc fa-2x text-gray-300"></i>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col">
												<div class="text-xs font-weight-bold text-info text-uppercase mb-0">TOTAL PREMIUM</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo isset($total_premium) ? $total_premium : '฿0'; ?></div>
												<!--<div class="h5 mb-0 font-weight-bold text-gray-800"><?php //echo isset($total_premium) ? '฿' . number_format($total_premium, 0, '.', ',') : '฿0'; ?></div>-->
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<!-- ToTal Policy status=Not Renew -->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							try {
								$sql = "SELECT COUNT(*) AS num_policies, FORMAT(SUM(premium_rate), N'฿#,##0') AS total_premium
										FROM [brokerapp].[dbo].[insurance_info]
										WHERE status = 'Not Renew'";
								$stmt = $dbh->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetch(PDO::FETCH_ASSOC);

								$num_policies = $result['num_policies'];
								$total_premium = $result['total_premium'];
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}
						?>

						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-dark shadow h-100 py-2">
								<a href="entry-policy.php" style="text-decoration: none; color: inherit;">
									<div class="card-body">
										<div class="row ">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-dark text-uppercase mb-1" style="font-size: medium;">Policy</div>
												<div class="text-xs font-weight-bold text-dark text-uppercase mb-1" style="font-size: medium;">(Not Renew)</div>
												<div class="text-xs font-weight-bold text-dark text-uppercase mt-3">TOTAL Policy</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo $num_policies; ?></div>
											</div>
											<div class="col-auto">
												<i class="fa fa-btc fa-2x text-gray-300"></i>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col">
												<div class="text-xs font-weight-bold text-dark text-uppercase mb-0">TOTAL PREMIUM</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo isset($total_premium) ? $total_premium : '฿0'; ?></div>
												<!--<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo isset($total_premium) ? '฿' . number_format($total_premium, 0, '.', ',') : '฿0'; ?></div>-->
												
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: medium;">
                                                Pending Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 mt-0">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						<!-- Due Policy -->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							// Query to get the number of policies that will expire within the next month
							//$sql = "SELECT COUNT(*) AS num_policies, SUM(premium_rate) AS total_premium FROM [brokerapp].[dbo].[insurance_info] WHERE DATEDIFF(month, GETDATE(), end_date) = 1";
							/*$sql = "SELECT COUNT(*) AS num_policies, SUM(premium_rate) AS total_premium
							FROM [brokerapp].[dbo].[insurance_info]
							WHERE end_date BETWEEN GETDATE() AND DATEADD(day, 30, GETDATE()) AND status IN ('New', 'Follow Up')";*/
							$sql = "SELECT '30-day Range' AS period,
								   COUNT(*) AS num_policies, 
								   SUM(premium_rate) AS total_premium
							FROM [brokerapp].[dbo].[insurance_info]
							WHERE end_date BETWEEN GETDATE() AND DATEADD(day, 30, GETDATE())
								  AND status IN ('New', 'Follow Up')

							UNION ALL

							SELECT 'Current Month' AS period,
								   COUNT(*) AS num_policies,
								   FORMAT(SUM(premium_rate), N'฿#,##0') AS total_premium
							FROM [brokerapp].[dbo].[insurance_info]
							WHERE status = 'Follow Up'
								  AND MONTH(paid_date) = MONTH(GETDATE())
								  AND YEAR(paid_date) = YEAR(GETDATE())
							";
							$stmt = $dbh->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetch(PDO::FETCH_ASSOC);

							$num_policies = $result['num_policies'];
							$total_premium = $result['total_premium'];
						?>

						
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-warning-2 shadow h-100 py-2">
								<a href="entry-policy.php" style="text-decoration: none; color: inherit;">
									<div class="card-body">
										<div class="row">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-warning-2 text-uppercase mb-1" style="font-size: medium;">Due Policy</div>
												<div class="text-xs font-weight-bold text-warning-2 text-uppercase mb-1" style="font-size: medium;">(Monthly)</div>
												<div class="text-xs font-weight-bold text-warning-2 text-uppercase mt-3">Total Policy </div>
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo $num_policies; ?></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-calendar fa-2x text-gray-300"></i>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col">
												<div class="text-xs font-weight-bold text-warning-2 text-uppercase mb-0">Total Premium </div>
												<!--<div class="h5 mb-0 font-weight-bold text-gray-800">฿<?php //echo number_format($total_premium); ?></div>-->
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo isset($total_premium) ? '฿' . number_format($total_premium, 0, '.', ',') : '฿0'; ?></div>
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
			
						
						<!-- ToTal Policy status=Follow Up -->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							try {
								$sql = "SELECT COUNT(*) AS num_policies, FORMAT(SUM(premium_rate), N'฿#,##0') AS total_premium
										FROM [brokerapp].[dbo].[insurance_info]
										WHERE status = 'Follow Up' AND MONTH(paid_date) = MONTH(GETDATE()) AND YEAR(paid_date) = YEAR(GETDATE())";
								$stmt = $dbh->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetch(PDO::FETCH_ASSOC);

								$num_policies = $result['num_policies'];
								$total_premium = $result['total_premium'];
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}
						?>

						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-warning shadow h-100 py-2">
								<a href="entry-policy.php" style="text-decoration: none; color: inherit;">
									<div class="card-body">
										<div class="row ">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: medium;">Policy</div>
												<div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: medium;">(Follow Up)</div>
												<div class="text-xs font-weight-bold text-warning text-uppercase mt-3">TOTAL Policy</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo $num_policies; ?></div>
											</div>
											<div class="col-auto">
												<i class="fa fa-btc fa-2x text-gray-300"></i>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col">
												<div class="text-xs font-weight-bold text-warning text-uppercase mb-0">TOTAL PREMIUM</div>
												<!--<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_premium; ?></div>-->
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo isset($total_premium) ? $total_premium : '฿0'; ?></div>
												<!--<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo isset($total_premium) ? '฿' . number_format($total_premium, 0, '.', ',') : '฿0'; ?></div>-->
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						
						<!-- ToTal Policy status=Wait -->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							try {
								$sql = "SELECT COUNT(*) AS num_policies, FORMAT(SUM(premium_rate), N'฿#,##0') AS total_premium
										FROM [brokerapp].[dbo].[insurance_info]
										WHERE status = 'Wait'";
								$stmt = $dbh->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetch(PDO::FETCH_ASSOC);

								$num_policies = $result['num_policies'];
								$total_premium = $result['total_premium'];
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}
						?>

						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-danger shadow h-100 py-2">
								<a href="entry-policy.php" style="text-decoration: none; color: inherit;">
									<div class="card-body">
										<div class="row ">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: medium;">Policy</div>
												<div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: medium;">(Wait)</div>
												<div class="text-xs font-weight-bold text-danger text-uppercase mt-3">TOTAL Policy</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo $num_policies; ?></div>
											</div>
											<div class="col-auto">
												<i class="fa fa-btc fa-2x text-gray-300"></i>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col">
												<div class="text-xs font-weight-bold text-danger text-uppercase mb-0">TOTAL PREMIUM</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800 mt-0"><?php echo isset($total_premium) ? $total_premium : '฿0'; ?></div>
												<!--<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo isset($total_premium) ? '฿' . number_format($total_premium, 0, '.', ',') : '฿0'; ?></div>-->
												
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
                    </div>
					
					

                    <!-- Sales Overview YEARLY -->
                    <div class="row">
						<!-- Sales Overview Compare current year and previous year -->
						<?php
							$month_names = array(
								1 => "Jan",
								2 => "Feb",
								3 => "Mar",
								4 => "Apr",
								5 => "May",
								6 => "Jun",
								7 => "Jul",
								8 => "Aug",
								9 => "Sep",
								10 => "Oct",
								11 => "Nov",
								12 => "Dec"
							);

							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							try {
								$sql = "SELECT MONTH(paid_date) AS month, YEAR(paid_date) AS year, SUM(premium_rate) AS total_sales
										FROM [brokerapp].[dbo].[insurance_info]
										WHERE status IN ('New', 'Follow Up', 'Renew' ,'Wait' ,'Not Renew') AND YEAR(paid_date) IN (YEAR(GETDATE()), YEAR(GETDATE()) - 1)
										GROUP BY MONTH(paid_date), YEAR(paid_date)
										ORDER BY YEAR(paid_date), MONTH(paid_date)";

								$stmt = $dbh->prepare($sql);
								$stmt->execute();
								$sales_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

								$monthly_sales_current_year = array_fill(1, 12, 0);
								$monthly_sales_previous_year = array_fill(1, 12, 0);

								foreach ($sales_data as $data) {
									if ($data['year'] == date('Y')) {
										$monthly_sales_current_year[$data['month']] = $data['total_sales'];
									} else {
										$monthly_sales_previous_year[$data['month']] = $data['total_sales'];
									}
								}
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}
						?>
						
						<div class="col-xl-12 col-lg-12">
							<div class="card shadow mb-4">
								<a href="report-monthly-sales.php" style="text-decoration: none; color: inherit;">
									<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										<h6 class="m-0 font-weight-bold text-primary">Sales Overview (YTD)</h6>
									</div>
								</a>
								<div class="card-body">
									<div class="chart-area">
										<canvas id="myLineChart" class="style-linechart"></canvas>
									</div>
								</div>
							</div>
						</div>
						<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
						<script>
							var months = [];
							var sales_current_year = [];
							var sales_previous_year = [];

							<?php foreach ($monthly_sales_current_year as $month => $total_sales): ?>
								months.push("<?php echo $month_names[$month]; ?>");
								sales_current_year.push("<?php echo $total_sales; ?>");
							<?php endforeach; ?>

							<?php foreach ($monthly_sales_previous_year as $month => $total_sales): ?>
								sales_previous_year.push("<?php echo $total_sales; ?>");
							<?php endforeach; ?>

							var ctx = document.getElementById('myLineChart').getContext('2d');
							var myLineChart = new Chart(ctx, {
								type: 'line',
								data: {
									labels: months,
									datasets: [{
										label: 'Total Sales - Current Year',
										data: sales_current_year,
										backgroundColor: 'rgba(54, 162, 235, 0.2)',
										borderColor: 'rgba(54, 162, 235, 1)',
										borderWidth: 2
									}, {
										label: 'Total Sales - Previous Year',
										data: sales_previous_year,
										backgroundColor: 'rgba(255, 99, 132, 0.2)',
										borderColor: 'rgba(255, 99, 132, 1)',
										borderWidth: 2
									}]
								},
								options: {
									scales: {
										y: {
											beginAtZero: true,
											ticks: {
												color: '#000000'
											}
										},
										x: {
											ticks: {
												color: '#000000'
											}
										}
									},
									plugins: {
										legend: {
											labels: {
												color: 'black'
											}
										}
									}
								}
							});
						</script>
					</div>
					
					<div class="row">
						<!-- Donut Chart Product Categories-->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							$sql_count = "SELECT 
											pc.categorie AS category,
											COUNT(i.id) AS policy_count,
											SUM(i.premium_rate) AS total_premium
										FROM 
											insurance_info i
										RIGHT JOIN 
											product_categories pc ON pc.id = i.product_category
										GROUP BY 
											pc.categorie;
										";

							$stmt_count = $dbh->prepare($sql_count);
							$stmt_count->execute();
							$result_count = $stmt_count->fetchAll(PDO::FETCH_ASSOC);

							$labels = array();
							$data = array();
							$premium = array(); 

							foreach ($result_count as $row) {
								$labels[] = $row['category'];
								$data[] = $row['policy_count'];
								$premium[] = $row['total_premium'];
							}

							$data_and_premium = array();
							for ($i = 0; $i < count($data); $i++) {
								$data_and_premium[] = $data[$i] . ', ' . $premium[$i];
							}
							?>

							<div class="col-xl-6 col-lg-6">
								<div class="card shadow mb-4">
									<a href="report-product-sales.php" style="text-decoration: none; color: inherit;">
										<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">Product Categories (YTD)</h6>
										</div>
									</a>
									<div class="card-body">
										<div class="chart-pie pt-2 pb-2">
											<canvas id="myDonutChart"></canvas>
										</div>
									</div>
								</div>
							</div>

							<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
							<script>
								var ctx = document.getElementById('myDonutChart').getContext('2d');
								var myDonutChart = new Chart(ctx, {
									type: 'doughnut', 
									data: {
										premium: <?php echo json_encode($premium); ?>,
										//labels: <?php echo json_encode($labels); ?>,
										labels: [
											'<?php echo $labels[0]; ?> (<?php echo $data[0]; ?>)',
											'<?php echo $labels[1]; ?> (<?php echo $data[1]; ?>)'
										],
										datasets: [{
											//data: <?php echo json_encode($data); ?>,
											data: <?php echo json_encode($premium); ?>,
											//data: [<?php echo $data[0]; ?>, <?php echo $data[1]; ?>],
											backgroundColor: [
												'rgba(255, 99, 132, 0.5)',
												'rgba(54, 162, 235, 0.5)'
											],
											borderColor: [
												'rgba(255, 99, 132, 1)',
												'rgba(54, 162, 235, 1)'
											],
											borderWidth: 1
										}]
									},
									options: {
										responsive: true,
										maintainAspectRatio: false,
										cutoutPercentage: 50, 
										legend: {
											display: false
										},
										layout: {
											padding: {
												//right: 50 
											}
										},
										plugins: {
											legend: {
												display: true,
												position: 'right',
												labels: {
													pointStyle: 'circle', 
													usePointStyle: true, 
													fontSize: 12,
												}
											},
											labels: {
												render: 'label',
												fontSize: 12 ,
												fontStyle: 'bold',
												fontColor: '#000',
												precision: 0,
												formatter: (value, ctx) => {
													let label = ctx.chart.data.labels[ctx.dataIndex];
													return label + ': ' + value;
												}
											}
										},
										tooltips: {
											callbacks: {
												label: function(tooltipItem, data) {
													var datasetLabel = data.labels[tooltipItem.index];
													var value = data.datasets[0].data[tooltipItem.index];
													var premium = <?php echo json_encode($premium); ?>;
													var tooltipText = datasetLabel + ': ' + value + ', ' + premium[tooltipItem.index] + ' (บาท)';
													return tooltipText;
												}
											}
										}
									}
								}); 
							</script>


						
						<!-- Pie Chart Product Sub Categories-->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							$sql = "SELECT p.subcategorie, COUNT(*) AS count 
							FROM [brokerapp].[dbo].[product_subcategories] p
							INNER JOIN [brokerapp].[dbo].[insurance_info] i ON p.id = i.sub_categories
							WHERE YEAR(i.paid_date) = YEAR(GETDATE()) 
							GROUP BY p.subcategorie";
							$stmt = $dbh->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

							$labels = array();
							$data = array();

							foreach ($result as $row) {
								$labels[] = $row['subcategorie'];
								$data[] = $row['count'];
							}
						?>

						<div class="col-xl-6 col-lg-6">
							<div class="card shadow mb-4">
								<a href="report-product-sales.php" style="text-decoration: none; color: inherit;">
									<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										<h6 class="m-0 font-weight-bold text-primary">Product Sub Categories (YTD)</h6>
										<!--<div class="dropdown no-arrow">
											<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
												data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
												aria-labelledby="dropdownMenuLink">
												<div class="dropdown-header">Dropdown Header:</div>
												<a class="dropdown-item" href="#">Action</a>
												<a class="dropdown-item" href="#">Another action</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</div>-->
									</div>
								</a>
								<div class="card-body">
									<div class="chart-pie pt-2 pb-2">
										<div id="myPieChart"></div>
									</div>
								</div>
							</div>
						</div>

						<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						<script type="text/javascript">
							google.charts.load('current', {'packages':['corechart']});
							google.charts.setOnLoadCallback(drawChart);

							function drawChart() {
								var data = google.visualization.arrayToDataTable([
									['Task', 'Count'],
									<?php
									foreach ($result as $row) {
										echo "['{$row['subcategorie']}', {$row['count']}],";
									}
									?>
								]);
								
								/*var colors = [
									<?php foreach ($labels as $index => $label): ?>
									<?php
										switch ($label) {
											case 'Health Insurance':
												echo "'#dc3912'";
												break;
											case 'Home Insurance':
												echo "'#ff9900'";
												break;
											case 'Life insurance':
												echo "'#109618'";
												break;
											case 'Car Insurance':
												echo "'#3366cc'";
												break;
											case 'Travel Insurance':
												echo "'#990099'";
												break;
											case 'D&O':
												echo "'#00CED1'";
												break;
											default:
												echo "'#000000'";
										}
									?>
									<?php if ($index < count($labels) - 1) echo ','; ?>
									<?php endforeach; ?>
								];*/

								var options = {
									//title: 'Revenue Sources',
									pieHole: 0.4,
									legend: { position: 'right' },
									chartArea: { width: '100%', height: '100%' },
									colors: ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099']
									//colors: colors
									
								};

								var chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
								chart.draw(data, options);
							}
						</script>
					</div>
					
					<div class="row">
						<!-- Sales by Customer Top 10 -->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							/*$sql = "SELECT cu.title_name, cu.first_name, cu.last_name, 
											SUM(info.premium_rate) AS total_premium_rate, 
											psup.subcategorie AS product
									FROM customer cu
									LEFT JOIN rela_customer_to_insurance recu ON cu.id = recu.id_customer
									JOIN insurance_info info ON info.id = recu.id_insurance_info
									JOIN product_subcategories psup ON psup.id = info.sub_categories
									WHERE YEAR(info.paid_date) = YEAR(GETDATE())
									GROUP BY cu.title_name, cu.first_name, cu.last_name, psup.subcategorie
									ORDER BY total_premium_rate DESC";
							*/
							$sql = "SELECT cu.title_name, cu.first_name, cu.last_name, 
											SUM(info.premium_rate) AS total_premium_rate, 
											psup.categorie AS product
									FROM customer cu
									LEFT JOIN rela_customer_to_insurance recu ON cu.id = recu.id_customer
									JOIN insurance_info info ON info.id = recu.id_insurance_info
									JOIN product_categories psup ON psup.id = info.product_category
									WHERE YEAR(info.paid_date) = YEAR(GETDATE())
									GROUP BY cu.title_name, cu.first_name, cu.last_name, psup.categorie
									ORDER BY total_premium_rate DESC";

							$stmt = $dbh->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

							$customers = array();
							$products = array();

							foreach ($result as $row) {
								$customer = $row['title_name'] . ' ' . $row['first_name'] . ' ' . $row['last_name'];
								$product = $row['product'];
								$total_premium_rate = $row['total_premium_rate'];

								if (!isset($customers[$customer])) {
									$customers[$customer] = array();
								}

								if (!isset($customers[$customer][$product])) {
									$customers[$customer][$product] = 0;
								}

								$customers[$customer][$product] += $total_premium_rate;

								if (!in_array($product, $products)) {
									$products[] = $product;
								}
							}

							$labels = array_keys($customers);

							$data = array();
							foreach ($customers as $customer => $purchase) {
								$customerData = array();
								foreach ($products as $product) {
									$customerData[] = isset($purchase[$product]) ? $purchase[$product] : 0;
								}
								$data[] = $customerData;
							}
						?>

						<div class="col-xl-12 col-lg-12">
							<div class="card shadow mb-4">
								<a href="report-customer-sales-total.php" style="text-decoration: none; color: inherit;">
									<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										<h6 class="m-0 font-weight-bold text-primary">Sales by Customers (YTD)</h6>
									</div>
								</a>
								<div class="card-body">
									<div class="chart-bar">
										<canvas id="myStackedBarChart" class="style-StackedBar" style="width: 100%; height: 70%;"></canvas>
									</div>
								</div>
							</div>
						</div>

						<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
						<script>
							var labels = <?php echo json_encode($labels); ?>;
							var data = <?php echo json_encode($data); ?>;
							var products = <?php echo json_encode($products); ?>;
							var ctx = document.getElementById('myStackedBarChart').getContext('2d');
							var myStackedBarChart = new Chart(ctx, {
								type: 'bar',
								data: {
									labels: labels,
									datasets: [
										<?php foreach ($products as $index => $product): ?>
										{
											label: '<?php echo $product; ?>',
											//backgroundColor: 'rgba(<?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, 0.5)',
											//borderColor: 'rgba(<?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, 1)',
											//backgroundColor: <?php echo ($product === 'Health Insurance') ? "'#dc3912'" : (($product === 'Home Insurance') ? "'#ff9900'" : (($product === 'Life insurance') ? "'#109618'" : ($product === 'Car Insurance' ? "'#3366cc'" : "'#990099'"))); ?>,
											//borderColor: <?php echo ($product === 'Health Insurance') ? "'#dc3912'" : (($product === 'Home Insurance') ? "'#ff9900'" : (($product === 'Life insurance') ? "'#109618'" : ($product === 'Car Insurance' ? "'#3366cc'" : "'#990099'"))); ?>,
											data: data.map(row => row[<?php echo $index; ?>]),
											backgroundColor: <?php
												switch ($product) {
													case 'Life':
														echo "'#ffb0c1'";
														break;
													case 'None Life':
														echo "'#9ad0f5'";
														break;
													default:
														echo "'#bd9af5'";
												}
											?>,
											borderColor: <?php
												switch ($product) {
													case 'Life':
														echo "'#ffb0c1'";
														break;
													case 'None Life':
														echo "'#9ad0f5'";
														break;
													default:
														echo "'#bd9af5'";
												}
											?>,
											borderWidth: 1
										},
										<?php endforeach; ?>
									]
								},
								options: {
									indexAxis: 'y',
									plugins: {
										title: {
											display: true,
											text: 'Sales by Customers Top 10'
										}
									},
									scales: {
										x: {
											stacked: true,
											ticks: {
												beginAtZero: true
											}
										},
										y: {
											stacked: true,
											ticks: {
												beginAtZero: true
											}
										}
									},
									legend: {
										display: true
									},
									responsive: true,
									scale: {
										x: {
											stacked: true,
										},
										y: {
											stacked: true
										}
									}
								}
							});
						</script>
					</div>
					
					<div class="row">
						<!-- Sales by Partners Top 10 -->
						<?php
							include('includes/config.php');

							try {
								$dbh = new PDO("sqlsrv:Server=".DB_HOST.";Database=".DB_NAME, DB_USER, DB_PASS);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
								die();
							}

							/*$sql = "SELECT TOP 10 ip.insurance_company AS partner_name,
											psup.subcategorie AS product,
											SUM(info.premium_rate) AS total_premium_rate
									FROM customer cu
									LEFT JOIN rela_customer_to_insurance recu ON cu.id = recu.id_customer
									JOIN insurance_info info ON info.id = recu.id_insurance_info
									LEFT JOIN insurance_partner ip ON ip.id = info.insurance_company_id
									LEFT JOIN product_subcategories psup ON psup.id = info.sub_categories
									WHERE YEAR(info.paid_date) = YEAR(GETDATE()) AND ip.status = 1 
									GROUP BY ip.insurance_company, psup.subcategorie
									ORDER BY ip.insurance_company, total_premium_rate DESC";
							*/
							$sql = "SELECT TOP 10 ip.insurance_company AS partner_name,
											psup.categorie AS product,
											SUM(info.premium_rate) AS total_premium_rate
									FROM customer cu
									LEFT JOIN rela_customer_to_insurance recu ON cu.id = recu.id_customer
									JOIN insurance_info info ON info.id = recu.id_insurance_info
									LEFT JOIN insurance_partner ip ON ip.id = info.insurance_company_id
									LEFT JOIN product_categories psup ON psup.id = info.product_category
									WHERE YEAR(info.paid_date) = YEAR(GETDATE()) AND ip.status = 1 
									GROUP BY ip.insurance_company, psup.categorie
									ORDER BY ip.insurance_company, total_premium_rate DESC";

							$stmt = $dbh->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

							$partners = array();
							$products = array();
							$total_subcategories = array();

							foreach ($result as $row) {
								$partner_name = $row['partner_name'];
								$product = $row['product'];
								$total_premium_rate = $row['total_premium_rate'];

								if (!isset($partners[$partner_name])) {
									$partners[$partner_name] = array();
								}

								$partners[$partner_name][$product] = $total_premium_rate;

								if (!in_array($product, $products)) {
									$products[] = $product;
								}
							}
						?>
						
						<script>
							window.addEventListener('resize', resizeCanvas);

							function resizeCanvas() {
								var canvas = document.getElementById('myStackedBarChartPartner');
								canvas.width = canvas.offsetWidth;
								canvas.height = canvas.offsetHeight;
							}

							// Call resizeCanvas() when the page loads or resizes
							window.onload = resizeCanvas;
						</script>
						<div class="col-xl-12 col-lg-12">
							<div class="card shadow mb-4">
								<a href="report-customer-sales-total.php" style="text-decoration: none; color: inherit;">
									<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										<h6 class="m-0 font-weight-bold text-primary">Sales by Partners (YTD)</h6>
									</div>
								</a>
								<div class="card-body">
									<div class="chart-bar">
										<canvas id="myStackedBarChartPartner" class="style-StackedBar" style="width: 100%; height: 70%;"></canvas>
									</div>
								</div>
							</div>
						</div>

						<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
						<script>
							var partners = <?php echo json_encode(array_keys($partners)); ?>;
							var products = <?php echo json_encode($products); ?>;
							var data = <?php echo json_encode(array_values($partners)); ?>;

							var datasets = products.map(function(product, index) {
							var color;
								switch (product) {
									case 'Life':
										color = '#ffb0c1';
										break;
									case 'None Life':
										color = '#9ad0f5';
										break;
									default:
										color = '#bd9af5'; 
								}

								return {
									label: product,
									data: data.map(function(partner) {
										return partner[product] || 0;
									}),
									backgroundColor: color,
									borderColor: color,
									borderWidth: 1
								};
							});


							var ctx = document.getElementById('myStackedBarChartPartner').getContext('2d');
							var myStackedBarChartPartner = new Chart(ctx, {
								type: 'bar',
								data: {
									labels: partners,
									datasets: datasets
								},
								options: {
									indexAxis: 'y',
									plugins: {
										title: {
											display: true,
											text: 'Sales by Partners'
										}
									},
									scales: {
										y: {
											stacked: true,
											ticks: {
												beginAtZero: true
											}
										},
										x: {
											stacked: true
										}
									},
									legend: {
										display: true
									},
									responsive: true,
									scale: {
										x: {
											stacked: true,
										},
										y: {
											stacked: true
										}
									}
								}
							});
						</script>
					</div>
					




                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
          <!--   <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer> -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

   <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <!-- <script src="js/bootstrap/bootstrap.min.js"></script> -->
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
            });
        </script>


    
        <?php include('includes/footer.php');?>
</body>

</html>