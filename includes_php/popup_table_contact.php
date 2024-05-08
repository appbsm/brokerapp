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
<!--   editAction  ModalContact ModalCustomer -->

<div id="ModalContact" class="modal fade" role="dialog" >
  <div class="modal-dialog modal-lg" >

    <div class="modal-content " >
            <br>
        <div class="form-group row px-3 ">
            <div class="col-sm-6" class="text-left">
                <h4 class="modal-title padding-left">Select Contact</h4>
            </div>
            <div class="col-sm-6 text-right" >             
            </div>
      </div>

      <div class="modal-body" >

       <div class="table-responsive" style="font-size: 13px;">

          <table class="table" id="example2" width="100%"   >
            <thead style="font-size: 13px;">
              <tr>
                <th class="text-center" width="20px" style="color: #102958;" hidden="true" >#</th>
                <th class="text-center" width="50px" >Select</th>
                
                <th>Title name</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Nick name</th>
                <th>Tel</th>
                <th>Mobile</th>
                <th>Email</th>

                <th hidden="true"></th>
                <th hidden="true"></th>
                <th hidden="true"></th>
                <th hidden="true"></th>
                <th hidden="true"></th>
                <th hidden="true"></th>

              </tr>
            </thead>
            <tbody class="table_contact" style="font-size: 13px;">
<?php 
    // $id_customer
    // $sql_c = " SELECT cl.description,customer.* from customer 
    //     LEFT JOIN customer_level cl ON customer.customer_level = cl.id
    //     WHERE customer.status = 1 ";

    $sql_c = "SELECT con.* FROM customer ct
        LEFT JOIN rela_customer_to_contact re_c ON ct.id = re_c.id_customer
        LEFT JOIN contact con ON con.id = re_c.id_contact
        WHERE re_c.id_customer ='".$id_customer."'";
    // print_r($sql_c);
    $query_c = $dbh->prepare($sql_c);
    $query_c->execute();
    $results_c=$query_c->fetchAll(PDO::FETCH_OBJ);

    if($query_c->rowCount() > 0){
       foreach($results_c as $result){ 
?>
              <tr  >
                <td hidden="true" ></td>
                <td class="text-center">
                <i title="Select Record" class="editAction_contact">
                    <a >
                        <svg height="20" viewBox="0 0 256 256" width="20" ><g fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"><path d="m16.000736 48.000563a31.999783 31.999783 0 0 1 31.999783-31.999781"/><path d="m-239.99926 48.000563a31.999783 31.999783 0 0 1 31.99978-31.999781" transform="scale(-1 1)"/><path d="m-239.99926-207.99947a31.999783 31.999783 0 0 1 31.99978-31.99978" transform="scale(-1)"/><path d="m16.000736-207.99947a31.999783 31.999783 0 0 1 31.999783-31.99978" transform="scale(1 -1)"/><path d="m239.99923 143.99987v31.9998"/><path d="m239.99923 80.000312v31.999798"/><path d="m16.000747 143.99991v31.99976"/><path d="m16.000751 80.000312v31.999798"/><path d="m112.00008 16.000744h-31.999796"/><path d="m175.99964 16.000748h-31.99976"/><path d="m112.00008 239.99922h-31.999796"/><path d="m175.99964 239.99922h-31.99976"/><path d="m96.000202 127.99999h63.999558"/><path d="m128 96.000192v63.999598"/></g></svg>
                    </a>
                </i>
                </td>

                <td class="title_name_c text-center"><?php echo $result->title_name;?></td>
                <td class="first_name_c"><?php  echo $result->first_name; ?></td>
                <td class="last_name_c text-center" ><?php echo $result->last_name;?></td>
                <td class="nick_name_c" ><?php echo $result->nick_name;?></td>
                <td class="tel_c text-center"><?php echo $result->tel;?></td>
                <td class="mobile_c text-center"><?php echo $result->mobile;?></td>
                <td class="email_c text-center"><?php echo $result->email;?></td>

                <td class="id_c" hidden="true" ><?php echo $result->id;?></td>
                <td class="line_id_c" hidden="true" ><?php echo $result->line_id;?></td>
                <td class="position_c" hidden="true" ><?php echo $result->position;?></td>
                <td class="remark_c" hidden="true" ><?php echo $result->remark;?></td>
                <td class="default_contact_c" hidden="true" ><?php echo $result->default_contact;?></td>
                <td class="department_c" hidden="true" ><?php echo $result->department;?></td>

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

