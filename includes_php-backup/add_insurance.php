<?php
include('includes/config.php');
$sql_product = " SELECT * from product_categories WHERE type='Life' and status = 1 ";
$query_product = $dbh->prepare($sql_product);
$query_product->execute();
$results_product=$query_product->fetchAll(PDO::FETCH_OBJ);
?>

<script type="text/javascript">
     function ClickChange() {
        alert('not checked');
        var value_status = document.getElementById("status_i_input").value;
        if(value_status=="Not renew"){
            $('#ModalNotrenew').modal('show');
            document.getElementById("area_not").hidden = false;
        }else{
            document.getElementById("area_not").hidden = true;
        }
    }
</script> 


<script >
    $(document).ready(function() {
        var input_insurance = 0;
        var i=0; 
        var input_value=0;


        

        // document.getElementById("id_co").value =
        $('#add').click(function() {
            alert('click add');
        input_insurance++;
        
        // Get inputs created (if any)
        var inputs = $('input');
        // var inputs = $('#policy');

        if(input_insurance >= 5) {
            alert('Only five inputs allowed');
            input_insurance--;
            return;
            // alert('Max'+inputs.length);
        }

        // Get last input to avoid duplicated IDs / names
        if(inputs.last().length > 0) {
            // Split name to get only last part of name, the numeric one

            i = parseInt(inputs.last()[0].name.split('_')[1]); 
        }
        input_value++;
        i++;
        var body_add ='<div id="row'+input_value+'" class="container-fluid">';
        body_add +='<div class="row">';
        body_add +='<div class="col-md-12 ">';
        body_add +='<div class="panel">';

        body_add +='<div class="panel-heading">';
        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='<div class="col">';
        body_add +='<div class="panel-title" style="color: #102958;" >';
        // body_add +='<h2 class="title">Insurance information '+input_value+'</h2>';
        body_add +='<h2 class="title">Insurance information </h2>';
        body_add +='</div>';
        body_add +='</div>';
        body_add +='<div class="col-sm-2 ">';
        body_add +='</div>';
        body_add +='<button type="button" class="btn btn_remove" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ input_value +'">X</button>';
        body_add +='</div>';
        body_add +='</div>';


        body_add +='<div class="panel-body">';


        body_add +='<div class="form-group row col-md-10 col-md-offset-1" >';
        body_add +='        <div class="col-sm-2  label_left"  >';
        body_add +='           <label style="color: #102958;" for="staticEmail" >Policy No:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col ">';
        body_add +='            <input id="policy" name="policy[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" required="required" >';
        body_add +='        </div>';
               
                
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Status:</label>';
        body_add +='        </div>';

        body_add +='        <div class="col">';
        body_add +='        <select id="status_i_input'+input_value+'" name="status[]" onchange="ClickChange'+input_value+'()" style="border-color:#102958;" class="form-control" >';
        body_add +='            <option value="New">New</option>';
        body_add +='            <option value="Follow up">Follow up</option>';
        body_add +='            <option value="Renew">Renew</option>';
        body_add +='            <option value="Wait">Wait</option>';
        body_add +='            <option value="Not renew">Not renew</option>';
        body_add +='        </select>';
        body_add +='        </div>';

        // body_add +='        <div class="col-sm-2 label_right" >';
        // body_add +='        </div>';
        // body_add +='        <div class="col" >';
        // body_add +='        </div>';

        body_add +='    </div>';

        body_add +='<script type="text/javascript">';
        body_add +='function ClickChange'+input_value+'() {';
        // body_add +='alert('+'"checked"'+');';

        body_add +='var value_status = document.getElementById("status_i_input'+input_value+'").value;';
        body_add +='if(value_status=="Not renew"){';
        body_add +='    $('+"'#ModalNotrenew"+input_value+"'"+').modal('+"'show'"+');';
        body_add +='    document.getElementById("area_not'+input_value+'").hidden = false;';
        body_add +='}else{';
        body_add +='    document.getElementById("area_not'+input_value+'").hidden = true;';
        body_add +='}';
        body_add +='}';
        body_add +='</'+'script>';

        body_add +='   <div class="form-group row mb-20 col-md-10 col-md-offset-1">';
        body_add +='       <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Product Category:</label>';
        body_add +='       </div>';
        body_add +='        <div class="col">';
        body_add +=' <select id="product_cat'+input_value+'" name="product_cat[]" style="color:#0C1830;border-color:#102958;"class="form-control" id="default" >';
        body_add +='               <option value="Life">Life</option>';
        body_add +='               <option value="Non Life">Non Life</option>';
        body_add +='           </select>';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2  label_right" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Sub Categories:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col"  >';
        body_add +='        <select id="sub_cat'+input_value+'" name="sub_cat[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" >';
        body_add +='            <?php  foreach($results_product as $result){ ?>';
        body_add +='       <option value="<?php echo $result->id; ?>" ><?php echo $result->sub_categories; ?></option>';
        body_add +='            <? } ?>';
        body_add +='        </select>';
        body_add +='        </div>';

        body_add +='    </div>';

        body_add +='    <div class="form-group row mb-20 col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2  label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Insurance Company:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col"  >';
        body_add +='       <select name="insurance_com[]"  style="color: #0C1830;border-color:#102958;"class="form-control"  >';
        body_add +='            <?php  foreach($results_company as $result){ ?>';
        body_add +='                <option value="<?php echo $result->id; ?>" ><?php echo $result->insurance_name; ?></option>';
        body_add +='            <? } ?>';
        body_add +='        </select>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2  label_right" >';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='       </div>';

        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Product Name:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col">';
        body_add +='            <input name="product_name[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Period:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        
        body_add +='<select name="period[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" >';
        body_add +='    <?php  foreach($results_period as $result){ ?>';
        body_add +='    <option value="<?php echo $result->id; ?>" ><?php echo $result->period; ?></option><? } ?>';
        body_add +='</select>';

        body_add +='        </div>';
        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" id="datepicker" >Start date:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col">';
        body_add +='            <input id="start_date" name="start_date[]" style="color: #0C1830;border-color:#102958;" type="date"  class="form-control">';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >End date:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col">';
        body_add +='            <input id="end_date" name="end_date[]" style="color: #0C1830;border-color:#102958;" type="date" name="name"  class="form-control" id="success" >';
        body_add +='        </div>';
        body_add +='    </div>';

        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Agent Name:</label>';
        body_add +='        </div>';

        body_add +='    <div class="col">';
        body_add +='        <select id="agent_name'+input_value+'" name="agent[]" style="color: #0C1830;border-color:#102958;" class="form-control selectpicker" id="default" data-live-search="true" value="" >';
        body_add +='        <?php  foreach($results_agent as $result){ ?>';
        body_add +='            <option value="<?php echo $result->id; ?>" ><?php echo $result->title_name." ".$result->first_name." ".$result->last_name."(".$result->nick_name.")"; ?></option><? } ?>';
        body_add +='        </select>';
        body_add +='    </div>';

        body_add +='    <div class="col-sm-2 label_right" >';
        body_add +='        <label style="color: #102958;" for="staticEmail" >Upload Documents:</label>';
        body_add +='    </div>';
                
        body_add +='    <div class="col">';
        body_add +='        <input name="file_d[]" type="file" style="width: 100%;" name="img" src="<?php echo htmlentities($path_file) ?>" id="imgInp">';
        body_add +='    </div>';

        body_add +='</div>';

        body_add +='<div id="area_not'+input_value+'" class="form-group row col-md-10 col-md-offset-1" hidden="true" >';
        body_add +='    <div class="col-sm-2 label_left" >';
        body_add +='    </div>';
        body_add +='    <div class="col">';
        body_add +='    </div>';
        body_add +='     <div class="col-sm-2 label_right" >';
        body_add +='        <label style="color: #102958;" for="staticEmail" >Reason:</label>';
        body_add +='    </div>';
        body_add +='    <div class="col">';
        body_add +='        <textarea class="form-control" id="textarea_detail'+input_value+'" name="textarea_detail[]" rows="5" placeholder="Cancellation reason" ></textarea>';
        body_add +='    </div>';
        body_add +='</div>';

        body_add +='</div>';
        body_add +='</div></div></div></div>';

        body_add +='<div id="ModalNotrenew'+input_value+'" data-backdrop="static" class="modal fade" role="dialog">';
        body_add +='<div class="modal-dialog modal-lg" >';
        body_add +='<div class="modal-content">';
        body_add +='    <div class="modal-header">';
        body_add +='    <div class="col-sm-12 px-3" class="text-left">Please include the reason why the customer did not renew the insurance.';
        body_add +='    </div>';
        body_add +='    </div>  ';
        body_add +='    <div class="modal-body">';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Reason:</label>';
        body_add +='            <textarea class="form-control" id="textarea_pop'+input_value+'" name="textarea_pop" rows="5" placeholder="Cancellation reason"  ></textarea>';
        body_add +='    </div>';
        body_add +='     <div class="modal-footer">';
        // body_add +='<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
        body_add +='    <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn" onclick="click_renew'+input_value+'()" >Submit</button>';
        body_add +='    </div>';
        body_add +='</div>';
        body_add +='</div>';
        body_add +='</div>';

    body_add +='<script >';
    body_add +='function click_renew'+input_value+'() {';
    body_add +='    var value_text = document.getElementById("textarea_pop'+input_value+'").value;';
    body_add +='    if(value_text==""){';
    body_add +='        alert('+"'Please enter information'"+');';
    body_add +='    }else{';
    body_add +='        document.getElementById("textarea_detail'+input_value+'").value = value_text;';
    body_add +='        $('+"'#ModalNotrenew"+input_value+"'"+').modal('+"'hide'"+');';
    body_add +='    }';
    body_add +='}   ';
    body_add +='</'+'script>';

    body_add +='<script >';
    // body_add +='$(function(){';
    
    body_add +='var result_type1 = "";';
    body_add +='var result_type2 = "";';
    body_add +=' $.get('+"'get_product_categories.php?type=Life'"+', function(data){';
    body_add +='    result_type1 = JSON.parse(data);';
    body_add +='});';
    body_add +='$.get('+"'get_product_categories.php?type=Non Life'"+', function(data){';
    body_add +='    result_type2 = JSON.parse(data);';
    body_add +='});';
    body_add +='var pro_type'+input_value+' ="Non Life";';

    // body_add +='productObject.on('+"'change'"+', function(){';
    body_add +='document.getElementById('+"'product_cat"+input_value.toString()+"'"+').addEventListener('+"'change'"+', function() {';
    

    body_add +='var productObject = $('+"'#product_cat"+input_value+"'"+');';
    body_add +='var subObject = $('+"'#sub_cat"+input_value+"'"+');';
    body_add +='subObject.html('+"''"+');'; 
// body_add +='var productId = this.value;';
    body_add +='var productId = productObject.value;';
    // body_add +='productId = document.getElementById('+"'product_cat"+input_value.toString()+"'"+').value;';
    // body_add +='var productId = document.getElementById('+"'product_cat1'"+').value;';

    // body_add +='alert('+"'input_value:product_cat'"+"+"+input_value.toString()+');';
    // body_add +='alert('+"'pro_type :'"+"+pro_type"+input_value+');';
    // body_add +='alert('+"'productId :'"+"+productId"+');';
    // body_add +='alert('+"'product_cat"+input_value.toString()+"'"+');';

    body_add +='if(pro_type'+input_value+'=="Life"){';
    body_add +='        $.each(result_type1, function(index, item){';
    body_add +='           subObject.append(';
    body_add +='               $('+"'<option></option>'"+').val(item.id).html(item.sub_categories)';
    body_add +='           );';
    body_add +='       });';
    body_add +='   pro_type'+input_value+' ="Non Life"';
    body_add +='   }else{';
    body_add +='        $.each(result_type2, function(index, item){';
    body_add +='            subObject.append(';
    body_add +='                $('+"'<option></option>'"+').val(item.id).html(item.sub_categories)';
    body_add +='            );';
    body_add +='        });';
    body_add +='   pro_type'+input_value+' ="Life"';
    body_add +='    }';


    body_add +='});';
    // body_add +='});';
    // body_add +='alert('+"'Test script'"+');';
    body_add +='</'+'script>';
    

        // <button type="button" class="btn_remove" name="remove" id="'+ i +'">X</button>

        // var body_add ='<div class="container-fluid"><h2 class="title">Insurance information</h2><div class="panel-body"></div></div>';
 
        $('#dynamic_field').append(body_add);
        // $('#dynamic_field2').append(body_add2);
        $("#agent_name"+input_value).selectpicker('refresh');
    });
    $(document).on('click', '.btn_remove', function() {
        input_insurance--;
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

    });
</script>