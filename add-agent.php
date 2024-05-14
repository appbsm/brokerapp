<?php
	include_once('includes/connect_sql.php');
	session_start();
	error_reporting(0);
	include_once('includes/fx_insurance_products.php');
	include_once('includes/fx_agent_db.php');
	include_once('includes/fx_address.php');

	if(strlen($_SESSION['alogin'])=="") {
		header('Location: logout.php');
	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST)) {
			save_agent($conn, $_POST);
			//print_r($_POST);
		}
		header('Location: agent-management.php');
	}

	$insurance = get_insurance_company ($conn);
	$agent_id = generate_agent_id($conn);
	$provinces = get_provinces($conn);
	$districts = get_district_by_province($conn, $provinces[0]['code']);
	$subdistricts = get_subdistrict_by_district($conn, $districts[0]['code']);
	 // print_r($insurance);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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
	<script src="js/DataTables/datatables.min.js"></script> 
</head>

<body id="page-top" >

    <!-- Page Wrapper -->
    <div id="wrapper" >
        <?php include('includes/leftbar2.php');?>   
        <?php include('includes/topbar2.php');?>  

    <div class="container-fluid " >
        <div class="row breadcrumb-div" style="background-color:#ffffff">
            <div class="col-md-12" >
                <ul class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                    <li class="active"  ><a href="agent-management.php">Agent List</a></li>
                    <li class="active">Add Agent</li>
                </ul>
            </div>
        </div>
    </div>

<form method="post" onSubmit="return valid();">
<br>

<div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="form-group row col-md-10 col-md-offset-1">
							<div class="col-sm-6">
								<div class="panel-title" style="color: #102958;" >
									<h2 class="title">Add Agent</h2>
								</div>
							</div>
						</div>
					</div>
   
					<div class="panel-body">
						<div class="form-group row col-md-10 col-md-offset-1">
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Agent ID:</label>
							<div class="col-sm-2 label_left">
								<input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="agent_id" required="required" class="form-control" id="success" value="<?php echo $agent_id;?>" readOnly>               
							</div>
							
							<!-- <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"></label> -->
							<div class="col">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked="checked">
									<label style="color: #0C1830;" class="form-check-label" for="flexCheckDefault">
									&nbsp;&nbsp;&nbsp;&nbsp; Active
									</label>
								</div>
							</div>  
						</div>
						

						<div class="form-group row col-md-10 col-md-offset-1">
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Title:</label>
							<div id="col_title" class="col-sm-2 label_left">
								<select id="input_title" style="border-color:#102958; color: #000;" name="title_name" class="form-control" id="default" >
									<option value="" selected>Select Title </option>
									<option value="Mr." <?php echo (trim($customer['title_name'])=="Mr.") ? 'selected' : '';?>>Mr.</option>
									<option value="Ms." <?php echo (trim($customer['title_name'])=="Ms.") ? 'selected' : '';?>>Ms.</option>
									<option value="Mrs." <?php echo (trim($customer['title_name'])=="Mrs.") ? 'selected' : '';?>>Mrs.</option>       
								</select>    
							</div>
							
							<div class="col  ">
							</div>
							<label style="color: #102958;" for="agent_type" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Agent Type:</label>
							<div id="col_title" class="col-sm-4">
								<select id="agent_type" style="border-color:#102958; color: #000;" name="agent_type" class="form-control" id="default" >
									<option value="" selected>Select Agent Type</option>
									<option value="Primary" >Primary</option>
									<option value="Sub-agent" >Sub-agent</option>							    
								</select>    
							</div>						 
						</div>

						<div class="form-group row col-md-10 col-md-offset-1">               
							<label style="color: #102958;" for="first_name" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>First name:</label>
							<div class="col-sm-4">
								<input id="input_fname" minlength="1" maxlength="100" style="color: #000;border-color:#102958;" type="text" name="first_name" class="form-control" id="first_name"  required>
							</div>
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label"><small><font color="red">*</font></small>Last name:</label>
							<div class="col-sm-4 ">
								<input id="input_lname" minlength="1" maxlength="100" style="color: #000;border-color:#102958;" type="text" name="last_name" class="form-control" required>
							</div>
							
						</div>

						<div class="form-group row col-md-10 col-md-offset-1">
							<label style="color: #102958;" for="nick_name" class="col-sm-2 col-form-label">Nickname:</label>
							<div class="col-sm-4 ">
								<input minlength="1" maxlength="100" style="color: #000;border-color:#102958;" type="text" name="nick_name" class="form-control" >
							</div>
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tax ID / Passport ID:</label>
							<div class="col-sm-4">
								<!--<input minlength="13" maxlength="13" style="color: #000;border-color:#102958;" type="text" name="tax_id" class="form-control" id="success"  required pattern="\d{13}">-->
								<input minlength="1" maxlength="13" style="color: #000;border-color:#102958;" type="text" name="tax_id" class="form-control" id="success"  >
							</div>
						</div>
						
						<div class="form-group row col-md-10 col-md-offset-1">
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Tel:</label>
							<div class="col-sm-4">
								<input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="tel" class="form-control" id="success" >
							</div>
							
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Mobile:</label>
							<div class="col-sm-4">
								<input style="color: #000;border-color:#102958;" type="text" name="mobile" class="form-control" id="mobile" value="" pattern="\d{3}-\d{3}-\d{4}">
							</div>
							<script>
								document.getElementById('mobile').addEventListener('input', function (e) {
									var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
									e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
								});
							</script>
						</div>

						<div class="form-group row col-md-10 col-md-offset-1">
							 <label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
							<div class="col-sm-4">
								<input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="email" name="email" class="form-control" id="success" value="" >
							</div>
						</div>
           
						<div class="panel-heading">
							<div class="form-group row col-md-10 col-md-offset-1">
									<div class="panel-title" style="color: #102958;" >
										<h2 class="title">Address</h2>
									</div>
							</div>
						</div>
						
						<!--
						<div class="form-group row col-md-10 col-md-offset-1">
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Address No:</label>
							<div class="col-4">
								<input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="address_number"  class="form-control" id="address_number" value="" >
							</div>
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Building Name:</label>
							<div class="col-4">
								<input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="building_name"  class="form-control" id="building_name" value="" >
							</div>
						</div>

						<div class="form-group row col-md-10 col-md-offset-1">
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Soi:</label>
							<div class="col-4">
								<input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="soi" class="form-control" id="soi" value="" >
						   
							</div>
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Road:</label>
							<div class="col-4">
								<input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="road"  class="form-control" id="road" value="" >
							</div>
						</div>
						-->
						
						<div class="form-group row col-md-10 col-md-offset-1">
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Address No:</label>
							<div class="col-sm-2">
								<input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="address_number"  class="form-control" id="address_number" value="" >
							</div>
							<label style="color: #102958;" for="staticEmail" class="col-sm-1 col-form-label">Soi:</label>
							<div class="col">
								<input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="soi" class="form-control" id="soi" value="" >
						   
							</div>
							<label style="color: #102958;" for="staticEmail" class="col-sm-1 col-form-label">Road:</label>
							<div class="col">
								<input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="road"  class="form-control" id="road" value="" >
							</div>
						</div>

						<div class="form-group row col-md-10 col-md-offset-1">
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Building Name:</label>
							<div class="col">
								<input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="building_name"  class="form-control" id="building_name" value="" >
							</div>
						</div>

						<div class="form-group row col-md-10 col-md-offset-1">
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Province:</label>
							<div class="col-sm-4">
								 <select style="color: #4590B8;border-color:#102958;" name="province" class="form-control selectpicker" data-live-search="true" id="province" >
									<option value="" selected>Select Province</option>
									<?php foreach ($provinces as $province) { ?>
									<option value="<?php echo $province['code']?>"><?php echo $province['name_en'];?></option>
									<?php }?>
								</select>
						   
							</div>
							
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">District:</label>
							<div class="col-sm-4">
								<select style="color: #4590B8;border-color:#102958;" name="district" class="form-control selectpicker" data-live-search="true" id="district" >
											<option value="" selected>Select District</option>
											<?php foreach ($districts as $district) { ?>
									<option value="<?php echo $district['code']?>"><?php echo $district['name_en'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group row col-md-10 col-md-offset-1">
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Sub-district:</label>
							<div class="col-sm-4">
								<!-- <input minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" name="name"  class="form-control" id="success" value" > -->

								<select style="color: #4590B8;border-color:#102958;" name="sub_district" class="form-control selectpicker" data-live-search="true" id="sub_district" >
									<option value="" selected>Select Subdistrict</option>
									<?php foreach ($subdistricts as $sub) { ?>
									<option value="<?php echo $sub['code']?>"><?php echo $sub['name_en'];?></option>
									<?php } ?>	
								</select>
							</div>
							<label style="color: #102958;" for="staticEmail" class="col-sm-2 col-form-label">Post Code:</label>
							<div class="col-sm-4">
								<input minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" name="post_code" id="post_code" class="form-control" >
								 <!--<select style="color: #4590B8;border-color:#102958;" name="name_title" class="form-control" id="default" >
											<option value="Mr." selected></option>
									</select>-->
							</div>
						</div>

						<!-- 1 Start -->

						<div class="panel-heading">
							<div class="form-group row col-md-10 col-md-offset-1">
								<!-- <div class="col-sm-4"> -->
									<div class="panel-title" style="color: #102958;" >
										<h2 class="title">Under Partner</h2>
									</div>
							</div>
						</div>

						<div id="insurance_section">
							<div class="form-group row col-md-11 col-md-offset-1">

								<label style="color: #102958;" for="staticEmail" class="col-2 col-form-label">Under Code:</label>
								<div class="col">
									<input id="agent_code1" name="agent_code[]" minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control" id="agent_code" value="" >
								</div>
								
								<label style="color: #102958;" for="staticEmail" class="col-2 col-form-label">Partner Name:</label>
								<div class="col">
									<select name="insurance_company[]" style="color:#000;border-color:#102958;" class="form-control" id="insurance_company" value="" >
									<option value="" selected>Select Partner</option>
									<?php foreach ($insurance as $i) {
									
										?>
									<option value="<?php echo $i['id']?>"><?php echo $i['insurance_company'];?></option>
									<?php } ?>
									</select>
								</div>

								<div class="col-sm-1">
				                     <div class="under-clone-cancel1" id="under-clone-cancel1" ></div>
				                </div>

							</div>

							<div class="form-group row col-md-11 col-md-offset-1">
			                    <div class="col-sm-2">
			                         <label style="color: #102958;" class="col-form-label" >Percentage Value:</label>
			                    </div>
			                    <div class="col-sm-3">
			                        <input id="agent_percent1" name="agent_percent[]" type="text" value="<?php echo number_format((float)$insu['percen_value'], 2, '.', ',').'%'; ?>" class="form-control" style="border-color:#102958;" onchange="
			                        var num = $(this).val().replace(/,/g,'');
			                        // if (/^\d*\.?\d+$/.test(num)) {
			                        if (parseFloat(num)) {
			                            if (parseFloat(num)>100){
			                                this.value=parseFloat(100.00).toFixed(2)+'%';
			                            }else{
			                                this.value=parseFloat(num).toFixed(2)+'%';
			                            } 
			                        }else{
			                            this.value='';
			                        }
			                    " />
			                    </div>
			                    <div class="col-sm-4">
			                        <input id="default_type_per1" name="default_type1" value="Percentage" class="form-check-input" type="radio" checked>
			                        <label style="color: #102958;" class="form-check-label" >
			                            &nbsp;&nbsp;&nbsp;&nbsp; Default Percentage
			                        </label>
			                    </div>

			                    <div class="col-1">
			                        <label></label>
			                    </div> 
			                </div>

			                <div class="form-group row col-md-11 col-md-offset-1">
			                    <div class="col-sm-2 " >
			                         <label style="color: #102958;" for="staticEmail" >Net Value:</label>
			                    </div>

			                    <div class="col-sm-3">
			                        <input id="agent_net1" name="agent_net[]" type="text" value="<?php echo number_format((float)$insu['net_value'], 2, '.', ','); ?>" class="form-control" style="border-color:#102958;" onchange="
			                            var num = $(this).val().replace(/,/g,'');
			                            // if (parseFloat(num)) {
			                            if (/^\d*\.?\d+$/.test(num)) {
			                                 var value_con  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num);
			                                this.value=value_con;
			                            }else{
			                                this.value='';
			                            }
			                        "/>
			                    </div>
			                    <div class="col-sm-4">
			                        <input id="default_type_net1" name="default_type1" value="Net Value" class="form-check-input" type="radio"
			                        <?php if($insu['type_default']=='Net Value'){ echo "checked"; } ?> >
			                        <label style="color: #102958;" class="form-check-label" >
			                            &nbsp;&nbsp;&nbsp;&nbsp; Default Net Value
			                        </label>
			                    </div>
			                    <div class="col-1">
			                    </div> 

			                </div>


						</div>
             
						<div class="insurance-section-clone" id="insurance-section-clone" ></div>	

						<div class="form-group row col-md-10 col-md-offset-1">
							<div  class="col-sm-12 text-right  ">
								<div style="padding-top: 10px;">
									<button style="background-color: #0275d8;color: #F9FAFA;" type="button" name="add_more_insur" class="btn btn-labeled" id="add-insurance">+ Add More Partner<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
								</div>
							</div>
							<div  class="col-sm-12 "></div>
						</div>
						
						<div class="form-group row col-md-10 col-md-offset-1">
							<div class="col-md-12">
							<button style="background-color: #0275d8;color: #F9FAFA;" type="submit" name="submit" class="btn  btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
							</button>
							&nbsp;&nbsp;
							<a href="agent-management.php" class="btn btn-primary" style="background-color: #0275d8;color: #F9FAFA;" >
								<span class="text">Cancel</span>
							</a>
							</div>
						</div>
          

					</div>
				</div>                             
			</div>
		</div>

    <br><br><br>
</form>
  
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/custom.js"></script>

        <script>
            $(function($) {
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();

                $('#province').change(function(){
					//alert($(this).val())
					$.ajax({
					type:"post", 
					url: "includes/fx_address.php", 
					data: {
						action: 'get_district',
						id_province: $(this).val()
					},
					success: function(result) {
						
						var obj = eval("(" + result + ")");
						subdistrict = obj;
						// console.log(subdistrict);
						$("#district option").remove();
						$("#sub_district option").remove();

						var options_s = $("#sub_district");
                        options_s.append($("<option />").val("").text("Select Subdistrict"));

						var options = $("#district");
                        options.append($("<option />").val("").text("Select District"));
                        $('#post_code').val("");
						$.each(obj, function(item) {
							//console.log(item);
							
							options.append($("<option />").val(obj[item].code).text(obj[item].name_en));
						});	
                        $("#district").selectpicker('refresh');
                        $("#sub_district").selectpicker('refresh');
					}				  
					});
				});
				
				$('#district').change(function(){
					//alert($(this).val())
					$.ajax({
					type:"post", 
					url: "includes/fx_address.php", 
					data: {
						action: 'get_subdistrict',
						id_district: $(this).val()
					},
					success: function(result) {
						
						var obj = eval("(" + result + ")");
						$("#sub_district option").remove();
						var options = $("#sub_district");
						options.append($("<option />").val("").text("Select Subdistrict"));
						//don't forget error handling!
						 var zipcodes_tmp = [];

						$.each(obj, function(item) {
							// console.log(item);
							zipcodes_tmp[obj[item].code] = obj[item].zip_code;
							options.append($("<option />").val(obj[item].code).text(obj[item].name_en));
						});	
						zipcodes = zipcodes_tmp;			
						// console.log(zipcodes);
                        $("#district").selectpicker('refresh');		
                        $("#sub_district").selectpicker('refresh');
					}				  
					});
				});
				
				$('#sub_district').change(function(){
					var id = $(this).val();
					//alert(id)
					console.log(id);
					var selected = zipcodes[id];
					console.log(selected);
					$('#post_code').val(selected);
				});

                var insur_ct = 1;
				$('#add-insurance').click(function(){
                  

                    clone = $('#insurance_section').clone();
                    clone.attr('id','insurance-section_'+insur_ct);

                    clone.find("#agent_code1").val("");

                    clone.find("#under-clone-cancel1").attr('id','under-clone-cancel-new'+insur_ct);
                    clone.find("#default_type_per1").prop('checked', true).attr('name','default_type'+(insur_ct+1));
                    clone.find("#default_type_net1").removeAttr('checked').attr('name','default_type'+(insur_ct+1));
                    clone.find("#agent_percent1").attr('id','agent_percent_new'+insur_ct).val("");
                    clone.find("#agent_net1").attr('id','agent_net_new'+insur_ct).val("");

                    clone.appendTo(".insurance-section-clone");
					// $("#insurance_section").clone().attr('id', 'insurance-section_'+insur_ct).appendTo(".insurance-section-clone");
					
                     // var body_add ='<div id="'+ insur_ct +'" class="form-group row col-md-10 col-md-offset-1">';
                    // body_add +='<div class="col text-right">';
                    var body_add ='<button type="button" class="btn btn_remove_insu" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ insur_ct +'">X</button>';
                    // body_add +='</div></div>&nbsp;&nbsp;';
                    $("#under-clone-cancel-new"+insur_ct).append(body_add);  

					insur_ct++;
				});

                $(document).on('click', '.btn_remove_insu', function() {
                    var button_id = $(this).attr("id");
                    $('#insurance-section_' + button_id + '').remove();
                    $('#' + button_id + '').remove();
                });

            });
        </script>

    <?php include('includes/footer.php'); ?>
</body>

</html>

<style>
	@media (min-width: 1340px){
		.label_left{
			max-width: 180px;
		}
		.label_right{
			max-width: 190px;
		}
	}

	.btn-default {
		color: #0C1830 !important;
		border-color: #102958 !important;
	}

	.bootstrap-select.btn-group .dropdown-toggle .caret {
		right: 10px !important;
		margin-top: -4px !important;
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

</style>

<div id="loading-overlay">
    <img src="loading.gif" alt="Loading...">
</div>