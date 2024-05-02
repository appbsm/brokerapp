<?php
include('../includes/config.php');
?>

<style>
	h1, h2, h3, h4, h5, h6, b, span, p, table, a, div, label, ul, li, div,
	button {
		font-family: Manrope, 'IBM Plex Sans Thai';
	
	
	.table th {
		vertical-align: middle !important;
		text-align: center !important;
	}
	
</style>
<!--   editAction    -->
<div id="ModalCustomer" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >

    <div class="modal-content">
        <!-- <div class="modal-header "> -->
            <br>
        <div class="form-group row px-3 ">
            <div class="col-sm-6" class="text-left">
                <h4 class="modal-title padding-left">Select Customer</h4>
            </div>
        <!-- <button type="button"  class="btn btn-default close" data-dismiss="modal">&times;</button> -->
        <!-- <button type="button" href="add-customer.php" style="background-color: #0275d8;color: #F9FAFA;" class="btn btn-default float-right" data-dismiss="modal">Add Customer</button> -->
            <div class="col-sm-6 text-right" >
                                <a href="add-customer.php" style="background-color: #0275d8;color: #F9FAFA;" class="btn">
                                    <svg  width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
										<path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
										<path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                    </svg>
                                    <span class="text">Add Customer</span>
                                </a>               
            </div>
        <!-- <br> -->
      </div>

      <div class="modal-body">

       <div class="table-responsive" style="font-size: 13px;">

          <table class="table" id="example" width="100%" >
            <thead style="font-size: 13px;">
              <tr>
                <th class="text-center" width="20px" style="color: #102958;" hidden="true" >#</th>
                <th class="text-center" width="50px" >Select</th>
                
                <th>Cust. ID</th>
                <th>Cust. name</th>
                <th>Mobile</th>
                <th width="100px" >Tel</th>
                <th>Cust. Type</th>

                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>

                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>

                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>

                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>
                <th hidden="ture"></th>
              </tr>
            </thead>
            <tbody  style="font-size: 13px;">
<?php 
// $sql_c = " SELECT * from customer WHERE status = 1 ";
$sql_c = " SELECT cl.description,customer.* from customer 
    LEFT JOIN customer_level cl ON customer.customer_level = cl.id
    WHERE customer.status = 1 ";
$query_c = $dbh->prepare($sql_c);
$query_c->execute();
$results_c=$query_c->fetchAll(PDO::FETCH_OBJ);

    if($query_c->rowCount() > 0){
       foreach($results_c as $result){ 
?>
              <tr>
                <td hidden="true" ></td>
                <td class="text-center">
                <i title="Select Record" class="editAction">
                    <a >
                        <!-- style="background-color: #0275d8;color: #F9FAFA;" class="btn" -->
 <!-- <svg  width="20" height="20" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
</svg> -->
                        
                        <!-- <svg width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 20 20">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                        <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                        </svg> -->
                        <svg height="20" viewBox="0 0 256 256" width="20" ><g fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"><path d="m16.000736 48.000563a31.999783 31.999783 0 0 1 31.999783-31.999781"/><path d="m-239.99926 48.000563a31.999783 31.999783 0 0 1 31.99978-31.999781" transform="scale(-1 1)"/><path d="m-239.99926-207.99947a31.999783 31.999783 0 0 1 31.99978-31.99978" transform="scale(-1)"/><path d="m16.000736-207.99947a31.999783 31.999783 0 0 1 31.999783-31.99978" transform="scale(1 -1)"/><path d="m239.99923 143.99987v31.9998"/><path d="m239.99923 80.000312v31.999798"/><path d="m16.000747 143.99991v31.99976"/><path d="m16.000751 80.000312v31.999798"/><path d="m112.00008 16.000744h-31.999796"/><path d="m175.99964 16.000748h-31.99976"/><path d="m112.00008 239.99922h-31.999796"/><path d="m175.99964 239.99922h-31.99976"/><path d="m96.000202 127.99999h63.999558"/><path d="m128 96.000192v63.999598"/></g></svg>
                       
                    </a>
                </i>
                </td>

                <td class="id_c text-center"><?php echo $result->customer_id;?></td>
                <td class="name_c"><?php 
                if($result->customer_type=="Corporate"){
                    echo $result->company_name;
                }else{
                    echo $result->customer_name;
                }
                ?></td>
                <td class="mobile_c text-center" ><?php echo $result->mobile;?></td>
                <td class="tel_c" ><?php echo $result->tel;?></td>
                
                <td class="type_c text-center"><?php echo $result->customer_type;?></td>

                <td class="nick_c" hidden="ture"><?php echo $result->nick_name;?></td>
                <td class="status_c" hidden="ture"><?php echo $result->status;?></td>
                <td class="personal_c" hidden="ture"><?php echo $result->tax_id;?></td>
                <td class="email_c" hidden="ture"><?php echo $result->email;?></td>

                <td class="address_c" hidden="ture"><?php echo $result->address_number;?></td>
                <td class="building_c" hidden="ture"><?php echo $result->building_name;?></td>
                <td class="soi_c" hidden="ture"><?php echo $result->soi;?></td>
                <td class="road_c" hidden="ture"><?php echo $result->road;?></td>

                <td class="province_c" hidden="ture"><?php echo $result->province;?></td>
                <td class="district_c" hidden="ture"><?php echo $result->district;?></td>
                <td class="sub_district_c" hidden="ture"><?php echo $result->sub_district;?></td>
                <td class="post_code_c" hidden="ture"><?php echo $result->post_code;?></td>
                <td class="customer_id_c" hidden="ture"><?php echo $result->id;?></td>

                <td class="title_id_c" hidden="ture"><?php echo $result->title_name;?></td>
                <td class="first_id_c" hidden="ture"><?php echo $result->first_name;?></td>
                <td class="last_id_c" hidden="ture"><?php echo $result->last_name;?></td>
                <td class="customer_level_c" hidden="ture"><?php echo $result->customer_level;?></td>
                <!-- <td class="customer_name" hidden="ture"><?php //echo $result->customer_name;?></td> -->
                <td class="customer_name" hidden="ture"><?php echo $result->company_name;?></td>
                <td class="description" hidden="ture"><?php echo $result->description;?></td>
              </tr>
<?php }} ?>

            </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" style="background-color: #0275d8;color: #F9FAFA;" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>


  </div>
</div>

