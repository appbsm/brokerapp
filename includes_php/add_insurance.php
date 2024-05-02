<?php
include('includes/config.php');
// $sql_product = " SELECT * from product_categories WHERE type='Life' and status = 1 ";
// $query_product = $dbh->prepare($sql_product);
// $query_product->execute();
// $results_product=$query_product->fetchAll(PDO::FETCH_OBJ);
?>

<script type="text/javascript">
     var input_value=0;
     function ClickChange() {
        var value_status = document.getElementById("status_i_input").value;
        if(value_status=="Not renew"){
            $('#ModalNotrenew').modal('show');
            document.getElementById("area_not").hidden = false;
            document.getElementById("area_not_label").hidden = false;
        }else{
            document.getElementById("area_not").hidden = true;
            document.getElementById("area_not_label").hidden = true;
        }

        if(value_status=="New" || value_status=="Renew"){
            document.getElementById("paid_date").removeAttribute("disabled");
        }else{
            document.getElementById("paid_date").setAttribute("disabled","disabled");
            // document.getElementById("paid_date").value=new Date();
        }


        var payment_object = $('#payment_status');
        payment_object.html('');
        if(value_status=="New" || value_status=="Follow up"){
            document.getElementById("payment_status").setAttribute("disabled","disabled");
            payment_object.append($('<option></option>').val("Paid").html("Paid"));
        }else if(value_status=="Wait" || value_status=="Not renew"){
            document.getElementById("payment_status").setAttribute("disabled","disabled");
            payment_object.append($('<option></option>').val("Not Paid").html("Not Paid"));
        }else if(value_status=="Renew"){
            document.getElementById('payment_status').removeAttribute("disabled");
            payment_object.append($('<option></option>').val("Paid").html("Paid"));
            payment_object.append($('<option></option>').val("Not Paid").html("Not Paid"));
            $('#ModalRenew').modal('show');
        }
    }
</script> 

<script type="text/javascript">
    function information_rela(item) {
        var inputs = $('input');

        if(inputs.last().length > 0) {
            i = parseInt(inputs.last()[0].name.split('_')[1]); 
        }
        input_value++;
        i++;

        // alert('Run information_rela:'+item.id);

        var body_add ='<div id="row'+input_value+'" class="container-fluid">';
        body_add +='<div class="row">';
        body_add +='<div class="col-md-12 ">';
        body_add +='<div class="panel">';

        body_add +='<div class="panel-heading">';
        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='<div class="col">';
        body_add +='<div class="panel-title" style="color: #102958;" >';
        body_add +='<h2 class="title">Insurance information </h2>';
        body_add +='</div>';
        body_add +='</div>';
        body_add +='<div class="col-sm-2 ">';
        body_add +='</div>';
        // body_add +='<button type="button" class="btn btn_remove" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ input_value +'">X</button>';
        body_add +='</div>';
        body_add +='</div>';


        body_add +='<div class="panel-body">';


        body_add +='<div class="form-group row col-md-10 col-md-offset-1" >';

        body_add +='<input hidden="true" id="id_insurance_info" name="id_insurance_info[]" value="'+item.id+'" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >';
        body_add +='</input>';

        body_add +='        <div class="col-sm-2  label_left"  >';
        body_add +='           <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Policy No:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col ">';
        body_add +='            <input id="policy" name="policy[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" required="required" value="'+item.policy_no+'" >';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2  label_left" >';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='        </div>';
               
        body_add +='</div>';

        body_add +='<div class="form-group row col-md-10 col-md-offset-1" >';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Status:</label>';
        body_add +='        </div>';

        body_add +='    <div class="col-sm-2">';
        body_add +='        <select id="status_i_input'+input_value+'" name="status[]" onchange="ClickChange'+input_value+'()" style="border-color:#102958;" class="form-control" required>';
        if(item.status=="New"){
            body_add +='<option value="New" selected>New</option>';
        }else{
            body_add +='<option value="New" >New</option>';
        }
        if(item.status=="Follow up"){
            body_add +='<option value="Follow up" selected>Follow up</option>';
        }else{
            body_add +='<option value="Follow up" >Follow up</option>';
        }
        if(item.status=="Renew"){
            body_add +='<option value="Renew" selected>Renew</option>';
        }else{
            body_add +='<option value="Renew" >Renew</option>';
        }
        if(item.status=="Wait."){
            body_add +='<option value="Wait" selected>Wait</option>';
        }else{
            body_add +='<option value="Wait" >Wait</option>';
        }
        if(item.status=="Not renew"){
            body_add +='<option value="Not renew" selected>Not renew</option>';
        }else{
            body_add +='<option value="Not renew" >Not renew</option>';
        }
        body_add +='        </select>';
        body_add +='    </div>';

        body_add +='         <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Payment status:</label>';
        body_add +='        </div> ';

        body_add +='        <div class="col-sm-2 " >';
        if(item.status=="Renew"){
            body_add +='<select  id="payment_status'+input_value+'" name="payment_status[]" style="color: #0C1830;border-color:#102958;" class="form-control" >';
        }else{
            body_add +='<select disabled="true" id="payment_status'+input_value+'" name="payment_status[]" style="color: #0C1830;border-color:#102958;" class="form-control" >';
        }
        // body_add +='<option value="New" selected>New</option>';
        if(item.payment_status=="Paid"){
            body_add +='<option value="Paid"  selected>Paid</option>';
        }else{
            body_add +='<option value="Paid"  >Paid</option>';
        }
        if(item.payment_status=="Not Paid"){
            body_add +='<option value="Not Paid"  selected>Not Paid</option>';
        }else{
            body_add +='<option value="Not Paid"  >Not Paid</option>';
        }
        body_add +='            </select>';
        body_add +='        </div>';

        body_add +='</div>';

        //start popup_reason----------------------------------------------------------------
        body_add +='<script type="text/javascript">';
        body_add +='function ClickChange'+input_value+'() {';

        body_add +='var value_status = document.getElementById("status_i_input'+input_value+'").value;';
        body_add +='if(value_status=="Not renew"){';
        body_add +='    $('+"'#ModalNotrenew"+input_value+"'"+').modal('+"'show'"+');';
        body_add +='    document.getElementById("area_not'+input_value+'").hidden = false;';
        body_add +='    document.getElementById("area_not_label'+input_value+'").hidden = false;';
        body_add +='}else{';
        body_add +='    document.getElementById("area_not'+input_value+'").hidden = true;';
        body_add +='    document.getElementById("area_not_label'+input_value+'").hidden = true;';
        body_add +='}';

        body_add +='if(value_status=="New" || value_status=="Renew"){';
        body_add +='document.getElementById("paid_date'+input_value+'").removeAttribute("disabled");';
        body_add +='}else{';
        body_add +='document.getElementById("paid_date'+input_value+'").setAttribute("disabled","disabled");';
        body_add +='}';

        // body_add +=' alert('+"'ClickChange:'"+'+value_status); ';

        body_add +='var payment_object = $('+"'#payment_status"+input_value+"'"+');';
        body_add +='payment_object.html('+"''"+');';
        body_add +='if(value_status=="New" || value_status=="Follow up"){';
        body_add +='    document.getElementById("payment_status'+input_value+'").setAttribute("disabled","disabled");';
        body_add +='    payment_object.append($('+"'<option></option>'"+').val("Paid").html("Paid"));';
        body_add +='}else if(value_status=="Wait" || value_status=="Not renew"){';
        body_add +='    document.getElementById("payment_status'+input_value+'").setAttribute("disabled","disabled");';
        body_add +='    payment_object.append($('+"'<option></option>'"+').val("Not Paid").html("Not Paid"));';
        body_add +='}else if(value_status=="Renew"){';
        body_add +='    document.getElementById("payment_status'+input_value+'").removeAttribute("disabled");';
        body_add +='    payment_object.append($('+"'<option></option>'"+').val("Paid").html("Paid"));';
        body_add +='    payment_object.append($('+"'<option></option>'"+').val("Not Paid").html("Not Paid"));';
        body_add +='    $('+"'#ModalRenew"+input_value+"'"+').modal('+"'show'"+');';
        body_add +='}';

        body_add +='}';
        body_add +='</'+'script>';

        body_add +='   <div class="form-group row mb-20 col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2  label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Partner Company:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col"  >';
        body_add +='<input hidden="true" type="text" id="currency_id'+input_value+'" name="currency_id[]" style="border-color:#102958;" class="form-control" value="<?php echo $currency_id; ?>" required/>';

         // body_add +=' <select id="product_cat'+input_value+'" name="product_cat[]" style="color:#0C1830;border-color:#102958;" class="form-control"  >';

        body_add +='<select id="insurance_com'+input_value+'" name="insurance_com[]" style="color:#0C1830;border-color:#102958;" class="form-control" >';
        body_add +='            <?php  foreach($results_company as $result){ ?>';
        body_add +='                <option value="<?php echo $result->id_partner; ?>" ><?php echo $result->insurance_company; ?></option>';
        body_add +='            <? } ?>';
        body_add +='        </select>';

        body_add +='<script type="text/javascript">';
        body_add +='    document.getElementById("insurance_com'+input_value+'").value = '+item.insurance_company_id+';';
        body_add +='</'+'script>';
        body_add +='        </div>';

        body_add +='   </div>';

        body_add +='   <div class="form-group row mb-20 col-md-10 col-md-offset-1">';
        body_add +='       <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Product Category:</label>';
        body_add +='       </div>';
        body_add +='        <div class="col">';
        body_add +=' <select id="product_cat'+input_value+'" name="product_cat[]" style="color:#0C1830;border-color:#102958;"class="form-control" required>';

        body_add +='<?php  foreach($results_categories as $result){ ?>';
        body_add +='<option value="<?php echo $result->id; ?>" ><?php echo $result->categorie; ?></option>';
        body_add +='<? } ?>';
        body_add +='           </select>';

        body_add +='<script type="text/javascript">';
        body_add +='    document.getElementById("product_cat'+input_value+'").value = '+item.product_category+';';
        body_add +='</'+'script>';

        body_add +='        </div>';

        body_add +='        <div class="col-sm-2  label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Sub Categories:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col"  >';
        body_add +=' <select id="sub_cat'+input_value+'" name="sub_cat[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>';

        // body_add +='<?php  foreach($results_sub as $result){ ?>';
        // body_add +='<option value="<?php echo $result->id; ?>"><?php echo $result->subcategorie; ?></option>';
        // body_add +='<? } ?>';

        body_add +='        </select>';
        body_add +='<script type="text/javascript">';
        body_add +='    var product_cat_object = $('+"'#product_cat"+input_value+"'"+');';
        body_add +='    var product_sub_object = $('+"'#sub_cat"+input_value+"'"+');';
        body_add +='        product_sub_object.html('+"''"+');';
        body_add +='        $.get('+"'get_product_subcategories.php?id='"+' + '+item.product_category+', function(data){';
        body_add +='        var result = JSON.parse(data);';
        body_add +='        $.each(result, function(index, item){';
        body_add +='            product_sub_object.append(';
        body_add +='               $('+"'<option></option>'"+').val(item.id).html(item.subcategorie)';
        body_add +='            );';
        body_add +='        });';
        body_add +='    document.getElementById("sub_cat'+input_value+'").value ='+item.sub_categories+' ;';
        body_add +='        });';
        body_add +='</'+'script>';

        body_add +='<script type="text/javascript">';
        
        body_add +='</'+'script>';

        body_add +='        </div>';
        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Product Name:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col">';
        body_add +='<select id="product_name'+input_value+'" name="product_name[]" style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>';
        body_add +='</select>';

        body_add +='<script type="text/javascript">';
        body_add +='    var insurance_com_object = $('+"'#insurance_com"+input_value+"'"+');';
        body_add +='    var product_object = $('+"'#product_name"+input_value+"'"+');';

        body_add +='        product_object.html('+"''"+');';

        body_add +='        $.get('+"'get_product.php?id='"+' + '+item.insurance_company_id+', function(data){';
        body_add +='        var result = JSON.parse(data);';
        body_add +='        $.each(result, function(index, item){';
        body_add +='            product_object.append(';
        body_add +='               $('+"'<option></option>'"+').val(item.id).html(item.product_name)';
        body_add +='            );';
        body_add +='        });';
        body_add +='    document.getElementById("product_name'+input_value+'").value ='+item.product_id+' ;';
        body_add +='        });';
        body_add +='</'+'script>';
        body_add +='      </div>';

        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';

        

        body_add +='        <div class="col-sm-2  label_left" >';
        body_add +='            <label style="color: #102958;"  >Currency:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2">';
        body_add +='<input type="text" id="currency'+input_value+'" name="currency[]" style="border-color:#102958;text-align: center;" class="form-control" value="'+item.currency_name+'" readOnly/>';
        body_add +='       </div>';


        body_add +='<div class="col-sm-2 label_left" >';
        body_add +='    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period type:</label>';
        body_add +='</div>';
        body_add +='<div class="col-sm-2">';
        body_add +='<select id="period_type'+input_value+'" name="period_type[]"  style="color: #0C1830;border-color:#102958;"class="form-control" >';
        // body_add +='<option value="" selected>Select Period type</option>';

        if(item.period_type == "Day"){
            body_add +='   <option value="Day" selected>Day</option>';
            body_add +='   <option value="Month" >Month</option>';
        }else{
            body_add +='   <option value="Day" >Day</option>';
            body_add +='   <option value="Month" selected>Month</option>';
        }
        body_add +='</select>';
        body_add +='</div> ';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2">'; 

        if(item.period_type=="Day"){
            body_add +='<select hidden="true" id="period_month'+input_value+'" name="period_month[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>';
            body_add +='    <?php  foreach($results_period as $result){ ?>';
            body_add +='    <option value="<?php echo $result->id; ?>" ><?php echo $result->period; ?></option><? } ?>';
            body_add +='</select>';
        }else{
            body_add +='<select id="period_month'+input_value+'" name="period_month[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>';
            body_add +='    <?php  foreach($results_period as $result){ ?>';
            body_add +='    <option value="<?php echo $result->id; ?>" ><?php echo $result->period; ?></option><? } ?>';
            body_add +='</select>';

            body_add +='<script type="text/javascript">';
            body_add +='    document.getElementById("period_month'+input_value+'").value = '+item.period+';';
            body_add +='</'+'script>';
        }

        if(item.period_type=="Month"){
            body_add +='<input hidden="true" id="period_day'+input_value+'" name="period_day[]" minlength="1" maxlength="3" style="color: #0C1830;border-color:#102958;" value="" type="number" class="form-control input_text" >';
        }else{
            body_add +='<input  id="period_day'+input_value+'" name="period_day[]" minlength="1" maxlength="3" style="color: #0C1830;border-color:#102958;" value="'+item.period_day+'" type="number" class="form-control input_text" >';
        }

        
        body_add +='        </div>';

        body_add +='    </div>';

////////////////////////////////---------------คำนวณวัน start---------------//////////////////////////////
        body_add +='<script>';
        body_add +='        $('+"'#period_type"+input_value+"'"+').change(function(){';
        body_add +='            var value_period = $(this).val();';
        body_add +='            if(value_period == "Day"){';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').hidden = false;';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').readOnly = false;';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').setAttribute("required","required");';
        body_add +='                document.getElementById('+"'period_month"+input_value+"'"+').hidden = true;';
        body_add +='                document.getElementById('+"'period_month"+input_value+"'"+').removeAttribute("required");';
        body_add +='            }else if(value_period == "Month"){';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').hidden = true;';
         body_add +='               document.getElementById('+"'period_day"+input_value+"'"+').removeAttribute("required");';
        body_add +='                document.getElementById('+"'period_month"+input_value+"'"+').hidden = false;';
        body_add +='                document.getElementById('+"'period_month"+input_value+"'"+').setAttribute("required","required");';
        body_add +='            }else{';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').hidden = false;';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').readOnly = true;';
        body_add +='                document.getElementById('+"'period_month"+input_value+"'"+').hidden = true;';
        body_add +='            }';
        body_add +='        });';
        body_add +='document.getElementById('+"'period_day"+input_value+"'"+').addEventListener("input",updateEndDate'+input_value+');';
        body_add +='document.getElementById('+"'period_month"+input_value+"'"+').addEventListener("input",updateEndDate'+input_value+');';
        body_add +='$('+"'#start_date"+input_value+"'"+').on("change", function() {updateEndDate'+input_value+'(); });';

body_add +='function updateEndDate'+input_value+'() {';
body_add +='    var periodDayInput = document.getElementById('+"'period_day"+input_value+"'"+');';
body_add +='    var periodMonthInput = document.getElementById('+"'period_month"+input_value+"'"+');';
body_add +='    var startDateInput = document.getElementById('+"'start_date"+input_value+"'"+');';
body_add +='    var endDateInput = document.getElementById('+"'end_date"+input_value+"'"+');';
body_add +='    var period_type = document.getElementById('+"'period_type"+input_value+"'"+');';

body_add +='    var parts = startDateInput.value.split("-");';
body_add +='    var startDate = new Date(parts[2], parts[1] - 1, parts[0]); ';

body_add +='    if(period_type.value == "Day"){';
body_add +='        var periodDay = parseInt(periodDayInput.value);';
body_add +='        if (!isNaN(periodDay) && startDate instanceof Date && !isNaN(startDate.getTime())) {';
body_add +='          var endDate = new Date(startDate.getTime());';
body_add +='          endDate.setDate(endDate.getDate() + periodDay);';
body_add +='          var formattedEndDate = endDate.getDate().toString().padStart(2, "0") + "-" + (endDate.getMonth() + 1).toString().padStart(2, "0") + "-" + endDate.getFullYear();';
body_add +='          endDateInput.value = formattedEndDate;';
body_add +='        } else {';
body_add +='          endDateInput.value = "";';
body_add +='        }';
body_add +='    }else if(period_type.value == "Month"){';
body_add +='        var periodDay = parseInt(periodMonthInput.options[periodMonthInput.selectedIndex].text);';
body_add +='        if (!isNaN(periodDay) && startDate instanceof Date && !isNaN(startDate.getTime())) {';
body_add +='            var endDate = new Date(addMonths(startDate, periodDay));';
body_add +='            var formattedEndDate = endDate.getDate().toString().padStart(2, "0") + "-" + (endDate.getMonth() + 1).toString().padStart(2, "0") + "-" + endDate.getFullYear();';
body_add +='            endDateInput.value = formattedEndDate;';
body_add +='        }else {';
body_add +='          endDateInput.value = "";';
body_add +='        }';
body_add +='    }';

body_add +='  }';
body_add +='</'+'script>';
////////////////////////////////-----------------คำนวณวัน end------------------//////////////////////////////


        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" id="datepicker" ><small><font color="red">*</font></small>Start date:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2">';
        body_add +='            <input id="start_date'+input_value+'" name="start_date[]" style="color: #0C1830;border-color:#102958;text-align: center;text-align: center;" type="text"  class="form-control" value="'+item.start_date_f+'" placeholder="dd-mm-yyyy" required>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>End date:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2">';
        body_add +='            <input id="end_date'+input_value+'" name="end_date[]" style="color: #0C1830;border-color:#102958;text-align: center;" type="text" name="name"  class="form-control" id="success" value="'+item.end_date_f+'" placeholder="dd-mm-yyyy" required>';
        body_add +='        </div>';
        body_add +='    </div>';

        body_add +='<script>';
        body_add +='$(document).ready(function(){';
        body_add +='$('+"'#start_date"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='$('+"'#end_date"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='$('+"'#paid_date"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='});';
        body_add +='</'+'script>';

        //End popup_reason----------------------------------------------------------------


        //start popup_renew----------------------------------------------------------------


        //End popup_renew----------------------------------------------------------------

        //Start premium----------------------------------------------------------------------------------------------

        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Premium Rate:</label>';
        body_add +='       </div>';
        body_add +='        <div class="col-sm-2">';
        body_add +='            <input id="premium_rate'+input_value+'" name="premium_rate[]" value="'+Math.round(item.premium_rate*100) / 100+'" type="number" style="border-color:#102958;text-align: right;" step="0.01" min="0" class="form-control" ';
        body_add +='                onchange="';

        body_add +='   var premium = parseFloat(this.value).toFixed(2);';

        body_add +='   var percent = parseFloat(document.getElementById('+"'percent_trade"+input_value+"'"+').value).toFixed(2);';
        body_add +='                if(document.getElementById('+"'calculate"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='                if(Number.isInteger(parseFloat(this.value).toFixed(2))){';
        body_add +='                    this.value=this.value+'+"'.00'"+';';
        body_add +='                }else{';
        body_add +='                    this.value=parseFloat(this.value).toFixed(2);';
        body_add +='                }';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else{';
        body_add +='   document.getElementById('+"'percent_trade"+input_value+"'"+').value = parseFloat(document.getElementById('+"'percent_trade"+input_value+"'"+').value).toFixed(2);';
        body_add +='                    var commission = percent;';
        body_add +='                }';
        body_add +='                document.getElementById('+"'commission"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';

        body_add +='                " required/>';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Paid Date:</label>';
        body_add +='        </div> ';
        body_add +='         <div class="col-sm-2">';
        body_add +='            <input id="paid_date'+input_value+'" name="paid_date[]"  style="color: #0C1830;border-color:#102958;text-align: center;" type="text"  class="form-control" ';
        body_add +='            value="'+item.paid_date_f+'" placeholder="dd-mm-yyyy" >';
        body_add +='        </div>';

        body_add +='    </div>';

        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='             <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Commission Type:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col " >';
        body_add +='            <select id="calculate'+input_value+'" name="calculate[]"  style="color: #0C1830;border-color:#102958;" class="form-control" ';
        body_add +='                onchange="';
        body_add +='                if(document.getElementById('+"'percent_trade"+input_value+"'"+').value!='+"''"+'){';
        body_add +='  var premium = parseFloat(document.getElementById('+"'premium_rate"+input_value+"'"+').value).toFixed(2);';
        body_add +='  var percent = parseFloat(document.getElementById('+"'percent_trade"+input_value+"'"+').value).toFixed(2);';

        body_add +='      if(document.getElementById('+"'calculate"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='      if (parseFloat(percent)>100){';
        body_add +='        document.getElementById('+"'percent_trade"+input_value+"'"+').value=parseFloat(100.00).toFixed(2)+'+"'%'"+';';
        body_add +='      }else{';
        body_add +='        document.getElementById('+"'percent_trade"+input_value+"'"+').value=parseFloat(percent).toFixed(2)+'+"'%'"+';';
        body_add +='      } ';

        body_add +='     var percent = parseFloat(document.getElementById('+"'percent_trade"+input_value+"'"+').value).toFixed(2);';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else{';
        body_add +='                    document.getElementById('+"'percent_trade"+input_value+"'"+').value = percent;';
        body_add +='                    var commission = percent;';
        body_add +='                }';
        body_add +='                document.getElementById('+"'commission"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';
        body_add +='                }';
        body_add +='                " required>';

        if(item.calculate_type=="Percentage"){
            body_add +='<option value="Percentage"  selected>Percentage</option>';
        }else{
            body_add +='<option value="Percentage"  >Percentage</option>';
        }
        if(item.calculate_type=="Net Value"){
            body_add +='<option value="Net Value"  selected>Net Value</option>';
        }else{
            body_add +='<option value="Net Value"  >Net Value</option>';
        }

        body_add +='            </select>';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2  label_left" >';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='        </div>';

        body_add +='    </div>';

        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Commission Value:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <input id="percent_trade'+input_value+'" name="percent_trade[]" value="'+Math.round(item.percent_trade*100) / 100+'" type="text" class="form-control" style="border-color:#102958;text-align: right;" onchange="';

        body_add +='                var num = parseInt(parseFloat(this.value).toFixed(0));';

        body_add +='                if(Number.isInteger(num)){';

        body_add +='var premium = parseFloat(document.getElementById('+"'premium_rate"+input_value+"'"+').value).toFixed(2);';

        body_add +='                var percent = parseFloat(this.value).toFixed(2);';

        body_add +='                if(document.getElementById('+"'calculate"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='                    if (parseFloat(this.value)>100){';
        body_add +='                        this.value=parseFloat(100.00).toFixed(2)+'+"'%'"+';';
        body_add +='                    }else{';
        body_add +='                        this.value=parseFloat(this.value).toFixed(2)+'+"'%'"+';';
        body_add +='                    } ';
        body_add +='                    var percent = parseFloat(this.value).toFixed(2);';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else{';
        body_add +='                    document.getElementById('+"'percent_trade"+input_value+"'"+').value = this.value;';
        body_add +='                    var commission = percent;';
        body_add +='                }';
        body_add +='                document.getElementById('+"'commission"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';
        body_add +='                }else{';
        body_add +='                    this.value='+"''"+';';
        body_add +='                }';

        body_add +='                " required/>';
        body_add +='        </div> ';
        body_add +='         <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Commission rate:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <input type="number" id="commission'+input_value+'" name="commission[]" value="'+Math.round(item.commission_rate*100) / 100+'" style="border-color:#102958;text-align: right;" class="form-control" readOnly/>';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Commission Status:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='             <select disabled="true" id="commission_status" name="commission_status[]" style="color: #0C1830;border-color:#102958;" class="form-control" >';

        body_add +='                <option value="'+item.commission_status+'" >'+item.commission_status+'</option>';

        body_add +='            </select>';
        body_add +='        </div>';

        body_add +='</div>';

        //End premium----------------------------------------------------------------------------------------------

        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Agent Name:'+item.agent_id+'</label>';
        body_add +='        </div>';

        body_add +='    <div class="col">';
        body_add +=' <select id="agent'+input_value+'" name="agent[]" value="'+item.agent_id+'" style="color:#0C1830;border-color:#102958;" class="form-control "  >';
        body_add +='<?php foreach($results_agent as $result){ ?>';

        body_add +='<option value="<?php echo $result->id; ?>" ><?php echo $result->title_name." ".$result->first_name." ".$result->last_name."(".$result->nick_name.")"; ?></option>';

        body_add +='            <? } ?>';
        body_add +='        </select>';
        body_add +='    </div>';

        

        body_add +='    <div class="col-sm-2 label_left" >';
        body_add +='        <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Upload Documents:</label>';
        body_add +='    </div>';
                
        body_add +='    <div class="col">';
        body_add +='        <input name="file_d[]" type="file" style="width: 100%;" name="img" src="" id="imgInp'+input_value+'" accept="application/pdf" >';
        
        if(item.file_name_uniqid){
        body_add +='       <div class="columns download">';
        body_add +='          <p>';
        body_add +='            <a href="image.php?filename='+item.file_name_uniqid+'" class="button" download="'+item.file_name+'" download><i class="fa fa-download"></i>Download '+item.file_name+'</a>';
        body_add +='          </p>';
        body_add +='      </div>';
        }
        
        body_add +='    </div>';

        body_add +='</div>';

        body_add +='<script>';
        body_add +='            document.getElementById("agent'+input_value+'").value='+item.agent_id+';';
        
        body_add +='$(document).ready( function() {';
        
        body_add +='        function checkFileSize() {';
        body_add +='            var fileInput = document.getElementById("imgInp'+input_value+'");';
        body_add +='            var fileSize = fileInput.files[0].size;';
        body_add +='            var maxSize = 5 * 1024 * 1024;';
        body_add +='            if (fileSize > maxSize) {';
        body_add +='                alert("File size exceeds 5MB. Please choose a file smaller than 5MB.");';
        body_add +='                document.getElementById("imgInp'+input_value+'").value = "";';
        body_add +='            }';
        body_add +='        }';

        body_add +='function readURL(input) {';

        body_add +='    var fileName = document.getElementById("imgInp'+input_value+'").value;';
        body_add +='    var idxDot = fileName.lastIndexOf(".") + 1;';
        body_add +='    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();';
        body_add +='    if (extFile=="pdf"){';
        body_add +='        if (input.files && input.files[0]) {';
        body_add +='            var reader = new FileReader();';
        body_add +='            reader.readAsDataURL(input.files[0]);';
        body_add +='        }';
        body_add +='    }else{';
        // body_add +='        var reader = new FileReader();';
        // body_add +='        reader.readAsDataURL(input.files[0]);';
        body_add +='        document.getElementById("imgInp'+input_value+'").value=null;';
        body_add +='        alert("Only pdf files are allowed!");';

        body_add +='    }}';

        body_add +='$("#imgInp'+input_value+'").change(function(){';

        //////////////////////////// Check File Zise
        body_add +=' $.ajax({';
        body_add +='                url: "check_folder_size_json.php",';
        body_add +='               type: "GET",';
        body_add +='                success: function(response) {';
        body_add +='                    data = JSON.parse(response);';

        body_add +='                    if (data.alert) {';
        body_add +='                        document.getElementById("imgInp").value = null;';
        body_add +='                        var message = "The folder at " + data.folderPath + " is nearly full. Remaining space: " + data.remainingSizeGB + " GB.";';
        body_add +='                        alert(message);';
        body_add +='                    }else{';

        body_add +='        checkFileSize();';
        body_add +='        readURL(this);';

        body_add +='                    }';
        body_add +='               }';
        body_add +='            });';
        //////////////////////////////

        body_add +='    });';
        body_add +='});';
        body_add +='</'+'script>';


        body_add +='<div  class="form-group row col-md-10 col-md-offset-1"  >';

        if(item.status=="Not renew"){
            body_add +='    <div id="area_not_label'+input_value+'" class="col-sm-2 label_left" >';
        }else{
            body_add +='    <div id="area_not_label'+input_value+'" hidden="true" class="col-sm-2 label_left" >';
        }
        
        body_add +='        <label style="color: #102958;" for="staticEmail" >Reason:</label>';
        body_add +='    </div>';

        if(item.status=="Not renew"){
            body_add +='    <div id="area_not'+input_value+'" class="col">';
        }else{
            body_add +='    <div id="area_not'+input_value+'" hidden="true" class="col">';
        }

        body_add +='        <textarea class="form-control" id="textarea_detail'+input_value+'" name="textarea_detail[]" rows="5" placeholder="Cancellation reason"  >'+item.reason+'</textarea>';
        body_add +='    </div>';
        body_add +='     <div class="col-sm-2 label_left" >';
        body_add +='    </div>';
        body_add +='    <div class="col">';
        body_add +='    </div>';
        body_add +='</div>';

        body_add +='</div>';
        body_add +='</div></div></div></div>';

    //Start popup ModalNotrenew ------------------------
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

    //End popup ModalNotrenew ------------------------

    //Start popup ModalRenew ------------------------

    body_add +='<div id="ModalRenew'+input_value+'" data-backdrop="static" class="modal fade" role="dialog">';
    body_add +='<div class="modal-dialog modal-lg" >';
    body_add +='    <div class="modal-content">';
    body_add +='       <div class="modal-header">';
    body_add +='        <div class="col-sm-12 px-3" class="text-left">';
    body_add +='            Please enter new information.';
    body_add +='        </div>';
    body_add +='        </div>  ';
    body_add +='        <div class="modal-body">';
    body_add +='        <div class="form-group row col-md-12">';
    body_add +='            <div class="col-sm-2 " >';
    body_add +='                <label style="color: #102958;" for="staticEmail" >Period:</label>';
    body_add +='            </div> ';
    body_add +='            <div class="col-sm-4">';
    body_add +='            <select id="period_popup'+input_value+'"  required="required" style="color: #0C1830;border-color:#102958;"class="form-control" value="0" >';
    body_add +='                    <?php  foreach($results_period as $result){ ?>';
    body_add +='                    <option value="<?php echo $result->id; ?>" ><?php echo $result->period; ?></option>';
    body_add +='                    <? } ?>';
    body_add +='                </select>';
    body_add +='            </div>';
    body_add +='            <div class="col-sm-2 " >';
    body_add +='            </div>';
    body_add +='            <div class="col-sm-4">';
    body_add +='            </div>';
    body_add +='        </div>';

    body_add +='        <div class="form-group row col-md-12">';
    body_add +='            <div class="col-sm-2" >';
    body_add +='                <label style="color: #102958;" >Start date:</label>';
    body_add +='            </div> ';
    body_add +='            <div class="col-sm-4">';
    body_add +='                <input id="start_date_popup'+input_value+'"  required="required" style="color: #0C1830;border-color:#102958;text-align: center;" type="text" class="form-control" ';
    body_add +='                value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" >';
    body_add +='            </div>';
    body_add +='            <div class="col-sm-2 " >';
    body_add +='                <label style="color: #102958;" for="staticEmail" >End date:</label>';
    body_add +='            </div> ';
    body_add +='            <div class="col-sm-4">';
    body_add +='                <input id="end_date_popup'+input_value+'"  required="required" style="color: #0C1830;border-color:#102958;text-align: center;" type="text"  class="form-control" ';
    body_add +='                value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" >';
    body_add +='            </div>';
    body_add +='        </div>';

        body_add +='<script>';
        body_add +='$(document).ready(function(){';
        body_add +='$('+"'#start_date_popup"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='$('+"'#end_date_popup"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='$('+"'#paid_date_pop"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='});';
        body_add +='</'+'script>';

    //Start premium----------------------------------------------------------------------------------------------

        body_add +='<div class="form-group row col-md-12">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" ><small><font color="red">*</font></small>Premium Rate:</label>';
        body_add +='       </div>';
        body_add +='        <div class="col-sm-2">';
        body_add +='            <input id="premium_rate_pop'+input_value+'" type="number" style="border-color:#102958;text-align: right;" step="0.01" min="0" class="form-control" ';
        body_add +='                onchange="';

        body_add +='   var premium = parseFloat(this.value).toFixed(2);';

        body_add +='   var percent = parseFloat(document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value).toFixed(2);';
        body_add +='                if(document.getElementById('+"'calculate_php"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='                if(Number.isInteger(parseFloat(this.value).toFixed(2))){';
        body_add +='                    this.value=this.value+'+"'.00'"+';';
        body_add +='                }else{';
        body_add +='                    this.value=parseFloat(this.value).toFixed(2);';
        body_add +='                }';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else{';
        body_add +='   document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value = parseFloat(document.getElementById('+"'percent_trade"+input_value+"'"+').value).toFixed(2);';
        body_add +='                    var commission = percent;';
        body_add +='                }';
        body_add +='                document.getElementById('+"'commission_pop"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';

        body_add +='                " />';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Paid Date:</label>';
        body_add +='        </div> ';
        body_add +='         <div class="col-sm-2">';
        body_add +='            <input id="paid_date_pop'+input_value+'" style="color: #0C1830;border-color:#102958;text-align: center;" type="text"  class="form-control" ';
        body_add +='            value="<?php echo $paid_date; ?>" placeholder="dd-mm-yyyy" >';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 " >';
        body_add +='             <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Calculate by:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <select id="calculate_php'+input_value+'"  value="<?php echo $result->product_category; ?>" style="color: #0C1830;border-color:#102958;" class="form-control" ';
        body_add +='                onchange="';
        body_add +='                if(document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value!='+"''"+'){';
        body_add +='  var premium = parseFloat(document.getElementById('+"'premium_rate_pop"+input_value+"'"+').value).toFixed(2);';
        body_add +='  var percent = parseFloat(document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value).toFixed(2);';

        body_add +='      if(document.getElementById('+"'calculate_php"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='      if (parseFloat(percent)>100){';
        body_add +='   document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value=parseFloat(100.00).toFixed(2)+'+"'%'"+';';
        body_add +='      }else{';
        body_add +='   document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value=parseFloat(percent).toFixed(2)+'+"'%'"+';';
        body_add +='      } ';

        body_add +='     var percent = parseFloat(document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value).toFixed(2);';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else{';
        body_add +='                    document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value = percent;';
        body_add +='                    var commission = percent;';
        body_add +='                }';
        body_add +='                document.getElementById('+"'commission_pop"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';
        body_add +='                }';
        body_add +='                " >';
        body_add +='                <option value="Percentage" >Percentage</option>';
        body_add +='                <option value="Net Value" >Net Value</option>';
        body_add +='            </select>';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Value:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <input id="percent_trade_pop'+input_value+'" type="text" class="form-control" style="border-color:#102958;text-align: right;" onchange="';

        body_add +='                var num = parseInt(parseFloat(this.value).toFixed(0));';

        body_add +='                if(Number.isInteger(num)){';

        body_add +='var premium = parseFloat(document.getElementById('+"'premium_rate_pop"+input_value+"'"+').value).toFixed(2);';

        body_add +='                var percent = parseFloat(this.value).toFixed(2);';

        body_add +='                if(document.getElementById('+"'calculate_php"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='                    if (parseFloat(this.value)>100){';
        body_add +='                        this.value=parseFloat(100.00).toFixed(2)+'+"'%'"+';';
        body_add +='                    }else{';
        body_add +='                        this.value=parseFloat(this.value).toFixed(2)+'+"'%'"+';';
        body_add +='                    } ';
        body_add +='                    var percent = parseFloat(this.value).toFixed(2);';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else{';
        body_add +='                    document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value = this.value;';
        body_add +='                    var commission = percent;';
        body_add +='                }';
        body_add +='                document.getElementById('+"'commission_pop"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';
        body_add +='                }else{';
        body_add +='                    this.value='+"''"+';';
        body_add +='                }';

        body_add +='                " />';
        body_add +='        </div> ';
        body_add +='         <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Commission rate:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <input type="number" id="commission_pop'+input_value+'" style="border-color:#102958;text-align: right;" class="form-control" readOnly/>';
        body_add +='        </div>';
        body_add +='         <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Payment status:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='<select  id="payment_status_pop'+input_value+'" style="color: #0C1830;border-color:#102958;" class="form-control" >';
        body_add +='                <option value="Paid" >Paid</option>';
        body_add +='                <option value="Not Paid" >Not Paid</option>';
        body_add +='            </select>';
        body_add +='        </div>';

        body_add +='    </div>';

        //End premium----------------------------------------------------------------------------------------------

    body_add +='        </div>';
    body_add +='         <div class="modal-footer">';
    body_add +='        <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn" onclick="click_payment'+input_value+'()" >Submit</button>';
    body_add +='        </div>';
    body_add +='    </div>';
    body_add +='</div>';
    body_add +='</div>';
 

    body_add +='<script >';
    body_add +='function click_payment'+input_value+'() {';

    // body_add +=' alert('+"'click_payment:'"+'+'+input_value+'); ';

    body_add +='    document.getElementById("period'+input_value+'").value = document.getElementById("period_popup'+input_value+'").value;';
    body_add +='    $("#period'+input_value+'").selectpicker('+"'refresh'"+');';
    body_add +='    document.getElementById("start_date'+input_value+'").value = document.getElementById("start_date_popup'+input_value+'").value;';
    body_add +='    document.getElementById("end_date'+input_value+'").value = document.getElementById("end_date_popup'+input_value+'").value;';
    
    // body_add +='  $('+"'#ModalNotrenew"+input_value+"'"+').modal('+"'hide'"+');';

    body_add +='var value_premium'+input_value+' = document.getElementById("premium_rate_pop'+input_value+'").value;';
    body_add +='    var value_percent'+input_value+' = document.getElementById("percent_trade_pop'+input_value+'").value;';
    body_add +='    if(value_premium'+input_value+'=="" || value_percent'+input_value+'==""){';
    body_add +='        alert('+"'Please enter complete information.'"+');';
    body_add +='    }else{';
    body_add +='        document.getElementById("premium_rate'+input_value+'").value = document.getElementById("premium_rate_pop'+input_value+'").value;';
    body_add +='        document.getElementById("percent_trade'+input_value+'").value = document.getElementById("percent_trade_pop'+input_value+'").value;';
    body_add +='        document.getElementById("calculate'+input_value+'").value = document.getElementById("calculate_php'+input_value+'").value;';
    body_add +='        document.getElementById("commission'+input_value+'").value = document.getElementById("commission_pop'+input_value+'").value;';
    body_add +='        document.getElementById("payment_status'+input_value+'").value = document.getElementById("payment_status_pop'+input_value+'").value;';
     body_add +='        document.getElementById("paid_date'+input_value+'").value = document.getElementById("paid_date_pop'+input_value+'").value;';
    // body_add +='        $('+"'#ModalRenew'"+').modal('+"hide'"+');';
    body_add +='        $('+"'#ModalRenew"+input_value+"'"+').modal('+"'hide'"+');';
    body_add +='    }';

    body_add +='} ';
    body_add +='</'+'script>';

    //End popup ModalRenew ------------------------


     // body_add +='var productObject = $('+"'#product_cat"+input_value+"'"+');';

    body_add +='<script type="text/javascript">';
    body_add +='$(function(){';
    body_add +='    var product_cat_object = $('+"'#product_cat"+input_value+"'"+');';
    body_add +='    var product_sub_object = $('+"'#sub_cat"+input_value+"'"+');';
    body_add +='    product_cat_object.on('+"'change'"+', function(){';
    body_add +='        var product_cat_id = $(this).val();  '; 
    body_add +='        product_sub_object.html('+"''"+');';
    body_add +='        $.get('+"'get_product_subcategories.php?id='"+' + product_cat_id, function(data){';
    body_add +='        var result = JSON.parse(data);';
    body_add +='        $.each(result, function(index, item){';
    body_add +='            product_sub_object.append(';
    body_add +='               $('+"'<option></option>'"+').val(item.id).html(item.subcategorie)';
    body_add +='            );';
    body_add +='        });';
    body_add +='        $("#sub_cat'+input_value+'").selectpicker('+"'refresh'"+');';
    body_add +='        });';
    body_add +='    });';
    body_add +='});';
    body_add +='</'+'script>';

    body_add +='<script type="text/javascript">';
    body_add +='$(function(){';

    body_add +='    var insurance_com_object = $('+"'#insurance_com"+input_value+"'"+');';
    body_add +='    var currency_object = $('+"'#currency"+input_value+"'"+');';
    body_add +='    var product_object = $('+"'#product_name"+input_value+"'"+');';
    body_add +='    var agent_name = $('+"'#agent"+input_value+"'"+');';

    body_add +='    insurance_com_object.on('+"'change'"+', function(){';
    body_add +='    var currency_id_new = $(this).val();';
    body_add +='    $.get('+"'get_currency_list.php?id='"+'+currency_id_new, function(data){';
    body_add +='        var result = JSON.parse(data);';
    body_add +='            $.each(result, function(index, item){';
    body_add +='                document.getElementById("currency_id'+input_value+'").value = item.id;';
    body_add +='                document.getElementById("currency'+input_value+'").value = item.currency;';
    body_add +='            });';
    body_add +='       });';
    
    body_add +='        product_object.html('+"''"+');';
    body_add +='        $.get('+"'get_product.php?id='"+'+currency_id_new, function(data){';
    body_add +='            var result = JSON.parse(data);';
    body_add +='            $.each(result, function(index, item){';
    body_add +='                product_object.append(';
    body_add +='                $('+"'<option></option>'"+').val(item.id).html(item.product_name)';
    body_add +='                );';
    body_add +='            });';
    body_add +='        });';

    body_add +='        agent_name.html('+"''"+');';
    body_add +='        $.get('+"'get_agent.php?id='"+'+currency_id_new, function(data){';
    body_add +='            var result = JSON.parse(data);';
    body_add +='            agent_name.append($('+"'<option></option>'"+').val('+"''"+').html("Select Agent Name"));';
    body_add +='            $.each(result, function(index, item){';
    body_add +='                agent_name.append(';
    body_add +='                $('+"'<option></option>'"+').val(item.id).html(item.title_name+" "+item.first_name+" "+item.last_name)';
    body_add +='                );';
    body_add +='            });';
    body_add +='            $("#agent'+input_value+'").selectpicker('+"'refresh'"+');';
    body_add +='        });';
    
    body_add +='    });';
    body_add +='});';
    body_add +='</'+'script>';

        $('#dynamic_field').append(body_add);
        return item;
    }
</script> 

<script >

    $(document).ready(function() {
        var input_insurance = 0;
        var i=0; 
       

        var customer_id = document.getElementById("id_insurance_info").value;
        if(customer_id != ""){
            // alert('Checked customer_id:'+customer_id);
            $.get('get_insurance_info_list.php?id=' + customer_id, function(data){
                var result = JSON.parse(data);
                $.each(result, function(index, item){
                    // alert('get JSON:'+item.id);
                    information_rela(item);
                });
            });
        }

    $('#add').click(function() {
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
        body_add +='           <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Policy No:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col ">';
        body_add +='            <input id="policy" name="policy[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control input_text" required="required" >';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2  label_left" >';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='        </div>';

        body_add +='    </div>';

        //start popup_reason----------------------------------------------------------------
        body_add +='<script type="text/javascript">';
        body_add +='function ClickChange'+input_value+'() {';

        body_add +='var value_status = document.getElementById("status_i_input'+input_value+'").value;';
        body_add +='if(value_status=="Not renew"){';
        body_add +='    $('+"'#ModalNotrenew"+input_value+"'"+').modal('+"'show'"+');';
        body_add +='    document.getElementById("area_not'+input_value+'").hidden = false;';
        body_add +='    document.getElementById("area_not_label'+input_value+'").hidden = false;';
        body_add +='}else{';
        body_add +='    document.getElementById("area_not'+input_value+'").hidden = true;';
        body_add +='    document.getElementById("area_not_label'+input_value+'").hidden = true;';
        body_add +='}';

        body_add +='if(value_status=="New" || value_status=="Renew"){';
        body_add +='document.getElementById("paid_date'+input_value+'").removeAttribute("disabled");';
        body_add +='}else{';
        body_add +='document.getElementById("paid_date'+input_value+'").setAttribute("disabled","disabled");';
        body_add +='}';

        // body_add +=' alert('+"'ClickChange:'"+'+value_status); ';

        body_add +='var payment_object = $('+"'#payment_status"+input_value+"'"+');';
        body_add +='payment_object.html('+"''"+');';
        body_add +='if(value_status=="New" || value_status=="Follow up"){';
        body_add +='    document.getElementById("payment_status'+input_value+'").setAttribute("disabled","disabled");';
        body_add +='    payment_object.append($('+"'<option></option>'"+').val("Paid").html("Paid"));';
        body_add +='}else if(value_status=="Wait" || value_status=="Not renew"){';
        body_add +='    document.getElementById("payment_status'+input_value+'").setAttribute("disabled","disabled");';
        body_add +='    payment_object.append($('+"'<option></option>'"+').val("Not Paid").html("Not Paid"));';
        body_add +='}else if(value_status=="Renew"){';
        body_add +='    document.getElementById("payment_status'+input_value+'").removeAttribute("disabled");';
        body_add +='    payment_object.append($('+"'<option></option>'"+').val("Paid").html("Paid"));';
        body_add +='    payment_object.append($('+"'<option></option>'"+').val("Not Paid").html("Not Paid"));';
        body_add +='    $('+"'#ModalRenew"+input_value+"'"+').modal('+"'show'"+');';
        body_add +='}';

        body_add +='}';
        body_add +='</'+'script>';

        /////////////////////////////------------------- END ------------------////////////////////////////////////

        body_add +='   <div class="form-group row mb-20 col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Status:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2">';
        body_add +='        <select id="status_i_input'+input_value+'" name="status[]" onchange="ClickChange'+input_value+'()" style="border-color:#102958;" class="form-control" required>';
        // body_add +='            <option value="" selected>Select Status</option>'
        body_add +='            <option value="New" >New</option>';
        body_add +='            <option value="Follow up">Follow up</option>';
        body_add +='            <option value="Renew">Renew</option>';
        body_add +='            <option value="Wait">Wait</option>';
        body_add +='            <option value="Not renew">Not renew</option>';
        body_add +='        </select>';
        body_add +='        </div>';

        body_add +='         <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Payment status:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='<select disabled="true" id="payment_status'+input_value+'" name="payment_status[]" style="color: #0C1830;border-color:#102958;" class="form-control" >';
        body_add +='                <option value="Paid" selected>Paid</option>';
        body_add +='                <option value="Not Paid" >Not Paid</option>';
        body_add +='            </select>';
        body_add +='        </div>';

        body_add +='  </div>';

        body_add +='    <div class="form-group row mb-20 col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2  label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Partner Company:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col"  >';
        body_add +='<input hidden="true" type="text" id="currency_id'+input_value+'" name="currency_id[]" style="border-color:#102958;" class="form-control" value="<?php echo $currency_id; ?>" />';
        body_add +='       <select id="insurance_com'+input_value+'" name="insurance_com[]"  style="color: #0C1830;border-color:#102958;"class="form-control"  required>';
        body_add +='    <option value="" selected>Select Insurance Company</option>';
        body_add +='            <?php  foreach($results_company as $result){ ?>';
        body_add +='                <option value="<?php echo $result->id_partner; ?>" ><?php echo $result->insurance_company; ?></option>';
        body_add +='            <? } ?>';
        body_add +='        </select>';
        body_add +='        </div>';

        body_add +='    </div>';

        body_add +='   <div class="form-group row mb-20 col-md-10 col-md-offset-1">';
        body_add +='       <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Product Category:</label>';
        body_add +='       </div>';
        body_add +='        <div class="col">';
        body_add +=' <select id="product_cat'+input_value+'" name="product_cat[]" style="color:#0C1830;border-color:#102958;"class="form-control" id="default" required>';
        body_add +='<option value="" selected>Select Product Category</option>';
        body_add +='<?php  foreach($results_categories as $result){ ?>';
        body_add +='<option value="<?php echo $result->id; ?>"><?php echo $result->categorie; ?></option>';
        body_add +='<? } ?>';

        body_add +='           </select>';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2  label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Sub Categories:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col"  >';
        body_add +='        <select id="sub_cat'+input_value+'" name="sub_cat[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>';

        body_add +='<option value="" selected>Select Product Category</option>';
        body_add +='<?php  foreach($results_sub as $result){ ?>';
        body_add +='<option value="<?php echo $result->id; ?>"><?php echo $result->subcategorie; ?></option>';
        body_add +='<? } ?>';

        body_add +='        </select>';
        body_add +='        </div>';
        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Product Name:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col">';
        body_add +='<select id="product_name'+input_value+'" name="product_name[]" style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>';
        body_add +='<option value="" selected>Select Product Name</option>';
        body_add +='<?php  foreach($results_product as $result){ ?>';
        body_add +='    <option value="<?php echo $result->id; ?>" ><?php echo $result->product_name; ?></option>';
        body_add +='<? } ?>';
        body_add +='</select>';
        body_add +='       </div>';

        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2  label_left" >';
        body_add +='            <label style="color: #102958;"  >Currency:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2">';
        body_add +='<input type="text" id="currency'+input_value+'" name="currency[]" style="border-color:#102958;text-align: center;" class="form-control" value="<?php echo $currency_name; ?>" readOnly/>';
        body_add +='       </div>';

        body_add +='<div class="col-sm-2 label_left" >';
        body_add +='    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period type:</label>';
        body_add +='</div>';
        body_add +='<div class="col-sm-2">';
        body_add +='<select id="period_type'+input_value+'" name="period_type[]"  style="color: #0C1830;border-color:#102958;"class="form-control" required>';
        body_add +='<option value="" selected>Select Period type</option>';
        body_add +='   <option value="Day"   >Day</option>';
        body_add +='   <option value="Month" >Month</option>';
        body_add +='</select>';
        body_add +='</div> ';

        body_add +='       <div class="col-sm-2 label_left" >';
        body_add +='          <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period:</label>';
        body_add +='       </div>';

        body_add +='       <div class="col-sm-2">';
        body_add +='            <select hidden="true" id="period_month'+input_value+'" name="period_month[]"  style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>';
        body_add +='    <option value="" selected>Select Period</option>';
        body_add +='    <?php  foreach($results_period as $result){ ?>';
        body_add +='    <option value="<?php echo $result->id; ?>" ><?php echo $result->period; ?></option><? } ?>';
        body_add +='            </select>';

        body_add +='<input  id="period_day'+input_value+'" name="period_day[]" minlength="1" maxlength="3" style="color: #0C1830;border-color:#102958;" type="number" class="form-control input_text"  readOnly>';

        body_add +='        </div>';
        body_add +='    </div>';

        body_add +='<script>';
        body_add +='        $('+"'#period_type"+input_value+"'"+').change(function(){';
        body_add +='            var value_period = $(this).val();';
        body_add +='            if(value_period == "Day"){';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').hidden = false;';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').readOnly = false;';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').setAttribute("required","required");';
        body_add +='                document.getElementById('+"'period_month"+input_value+"'"+').hidden = true;';
        body_add +='                document.getElementById('+"'period_month"+input_value+"'"+').removeAttribute("required");';
        body_add +='            }else if(value_period == "Month"){';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').hidden = true;';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').removeAttribute("required");';
        body_add +='                document.getElementById('+"'period_month"+input_value+"'"+').hidden = false;';
        body_add +='                document.getElementById('+"'period_month"+input_value+"'"+').setAttribute("required","required");';
        body_add +='            }else{';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').hidden = false;';
        body_add +='                document.getElementById('+"'period_day"+input_value+"'"+').readOnly = true;';
        body_add +='                document.getElementById('+"'period_month"+input_value+"'"+').hidden = true;';
        body_add +='            }';
        body_add +='        });';
        body_add +='document.getElementById('+"'period_day"+input_value+"'"+').addEventListener("input",updateEndDate'+input_value+');';
        body_add +='document.getElementById('+"'period_month"+input_value+"'"+').addEventListener("input",updateEndDate'+input_value+');';
        body_add +='$('+"'#start_date"+input_value+"'"+').on("change", function() {updateEndDate'+input_value+'(); });';

body_add +='function updateEndDate'+input_value+'() {';
body_add +='    var periodDayInput = document.getElementById('+"'period_day"+input_value+"'"+');';
body_add +='    var periodMonthInput = document.getElementById('+"'period_month"+input_value+"'"+');';
body_add +='    var startDateInput = document.getElementById('+"'start_date"+input_value+"'"+');';
body_add +='    var endDateInput = document.getElementById('+"'end_date"+input_value+"'"+');';
body_add +='    var period_type = document.getElementById('+"'period_type"+input_value+"'"+');';

body_add +='    var parts = startDateInput.value.split("-");';
body_add +='    var startDate = new Date(parts[2], parts[1] - 1, parts[0]); ';

body_add +='    if(period_type.value == "Day"){';
body_add +='        var periodDay = parseInt(periodDayInput.value);';
body_add +='        if (!isNaN(periodDay) && startDate instanceof Date && !isNaN(startDate.getTime())) {';
body_add +='          var endDate = new Date(startDate.getTime());';
body_add +='          endDate.setDate(endDate.getDate() + periodDay);';
body_add +='          var formattedEndDate = endDate.getDate().toString().padStart(2, "0") + "-" + (endDate.getMonth() + 1).toString().padStart(2, "0") + "-" + endDate.getFullYear();';
body_add +='          endDateInput.value = formattedEndDate;';
body_add +='        } else {';
body_add +='          endDateInput.value = "";';
body_add +='        }';
body_add +='    }else if(period_type.value == "Month"){';
body_add +='        var periodDay = parseInt(periodMonthInput.options[periodMonthInput.selectedIndex].text);';
body_add +='        if (!isNaN(periodDay) && startDate instanceof Date && !isNaN(startDate.getTime())) {';
body_add +='            var endDate = new Date(addMonths(startDate, periodDay));';
body_add +='            var formattedEndDate = endDate.getDate().toString().padStart(2, "0") + "-" + (endDate.getMonth() + 1).toString().padStart(2, "0") + "-" + endDate.getFullYear();';
body_add +='            endDateInput.value = formattedEndDate;';
body_add +='        }else {';
body_add +='          endDateInput.value = "";';
body_add +='        }';
body_add +='    }';

body_add +='  }';
body_add +='</'+'script>';


        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" id="datepicker" ><small><font color="red">*</font></small>Start date:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2">';
        body_add +='            <input id="start_date'+input_value+'" name="start_date[]" style="color: #0C1830;border-color:#102958;text-align: center;" type="text"  class="form-control" value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" required>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>End date:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2">';
        body_add +='            <input id="end_date'+input_value+'" name="end_date[]" style="color: #0C1830;border-color:#102958;text-align: center;" type="text" name="name"  class="form-control" id="success" value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" required>';
        body_add +='        </div>';
        body_add +='    </div>';

        body_add +='<script>';
        body_add +='$(document).ready(function(){';
        body_add +='$('+"'#start_date"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='$('+"'#end_date"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='$('+"'#paid_date"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='});';
        body_add +='</'+'script>';
        //End popup_reason----------------------------------------------------------------


        //start popup_renew----------------------------------------------------------------


        //End popup_renew----------------------------------------------------------------

        //Start premium----------------------------------------------------------------------------------------------

        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Premium Rate:</label>';
        body_add +='       </div>';
        body_add +='        <div class="col-sm-2">';
        body_add +='            <input id="premium_rate'+input_value+'" name="premium_rate[]" type="number" style="border-color:#102958;text-align: right;" step="0.01" min="0" class="form-control" ';
        body_add +='                onchange="';

        body_add +='   var premium = parseFloat(this.value).toFixed(2);';

        body_add +='   var percent = parseFloat(document.getElementById('+"'percent_trade"+input_value+"'"+').value).toFixed(2);';
        body_add +='                if(document.getElementById('+"'calculate"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='                if(Number.isInteger(parseFloat(this.value).toFixed(2))){';
        body_add +='                    this.value=this.value+'+"'.00'"+';';
        body_add +='                }else{';
        body_add +='                    this.value=parseFloat(this.value).toFixed(2);';
        body_add +='                }';
        body_add +='                    var commission = ((percent / 100) * premium);';

        body_add +='                }else if(document.getElementById('+"'calculate"+input_value+"'"+').value=='+"'Net Value'"+'){';

        body_add +='   document.getElementById('+"'percent_trade"+input_value+"'"+').value = parseFloat(document.getElementById('+"'percent_trade"+input_value+"'"+').value).toFixed(2);';
        body_add +='                    var commission = percent;';

        body_add +='                }';

        body_add +='                document.getElementById('+"'commission"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';

        body_add +='                " required/>';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='           <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Paid Date:</label>';
        body_add +='        </div> ';
        body_add +='         <div class="col-sm-2">';
        body_add +='            <input id="paid_date'+input_value+'" name="paid_date[]"  style="color: #0C1830;border-color:#102958;text-align: center;" type="text"  class="form-control" ';
        body_add +='            value="<?php echo $paid_date; ?>" placeholder="dd-mm-yyyy">';
        body_add +='        </div>';
        
        body_add +='    </div>';

        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='             <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Commission Type:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-4 " >';
        body_add +='            <select id="calculate'+input_value+'" name="calculate[]" value="<?php echo $result->product_category; ?>" style="color: #0C1830;border-color:#102958;" class="form-control" ';
        body_add +='                onchange="';
        body_add +='                if(document.getElementById('+"'percent_trade"+input_value+"'"+').value!='+"''"+'){';
        body_add +='  var premium = parseFloat(document.getElementById('+"'premium_rate"+input_value+"'"+').value).toFixed(2);';
        body_add +='  var percent = parseFloat(document.getElementById('+"'percent_trade"+input_value+"'"+').value).toFixed(2);';

        body_add +='      if(document.getElementById('+"'calculate"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='      if (parseFloat(percent)>100){';
        body_add +='        document.getElementById('+"'percent_trade"+input_value+"'"+').value=parseFloat(100.00).toFixed(2)+'+"'%'"+';';
        body_add +='      }else{';
        body_add +='        document.getElementById('+"'percent_trade"+input_value+"'"+').value=parseFloat(percent).toFixed(2)+'+"'%'"+';';
        body_add +='      } ';

        body_add +='     var percent = parseFloat(document.getElementById('+"'percent_trade"+input_value+"'"+').value).toFixed(2);';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else if(document.getElementById('+"'calculate"+input_value+"'"+').value=='+"'Net Value'"+'){';
        body_add +='                    document.getElementById('+"'percent_trade"+input_value+"'"+').value = percent;';
        body_add +='                    var commission = percent;';
        body_add +='                }';
        body_add +='                document.getElementById('+"'commission"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';
        body_add +='                }';
        body_add +='                " required>';
        body_add +='                <option value="" selected>Select Calculate by</option>';
        body_add +='                <option value="Percentage" >Percentage</option>';
        body_add +='                <option value="Net Value" >Net Value</option>';
        body_add +='            </select>';
        body_add +='        </div>';

        body_add +='    </div>';

        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Commission Value:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <input id="percent_trade'+input_value+'" name="percent_trade[]" type="text" class="form-control" style="border-color:#102958;text-align: right;" onchange="';

        body_add +='                var num = parseInt(parseFloat(this.value).toFixed(0));';

        body_add +='                if(Number.isInteger(num)){';

        body_add +='        var premium = parseFloat(document.getElementById('+"'premium_rate"+input_value+"'"+').value).toFixed(2);';

        body_add +='                var percent = parseFloat(this.value).toFixed(2);';

        body_add +='                if(document.getElementById('+"'calculate"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='                    if (parseFloat(this.value)>100){';
        body_add +='                        this.value=parseFloat(100.00).toFixed(2)+'+"'%'"+';';
        body_add +='                    }else{';
        body_add +='                        this.value=parseFloat(this.value).toFixed(2)+'+"'%'"+';';
        body_add +='                    } ';
        body_add +='                    var percent = parseFloat(this.value).toFixed(2);';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else{';
        body_add +='                    document.getElementById('+"'percent_trade"+input_value+"'"+').value = this.value;';
        body_add +='                    var commission = percent;';
        body_add +='                }';

        body_add +='                document.getElementById('+"'commission"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';

        body_add +='                }else{';
        body_add +='                    this.value='+"''"+';';
        body_add +='                }';

        body_add +='                " required/>';
        body_add +='        </div> ';

        body_add +='         <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Commission rate:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <input type="number" id="commission'+input_value+'" name="commission[]" style="border-color:#102958;text-align: right;" class="form-control" readOnly/>';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Commission Status:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='             <select disabled="true" id="commission_status" name="commission_status[]" style="color: #0C1830;border-color:#102958;" class="form-control" >';
        body_add +='                <option value="Not Paid" >Not Paid</option>';
        body_add +='            </select>';
        body_add +='        </div>';

        body_add +='    </div>';

        //End premium----------------------------------------------------------------------------------------------

        body_add +='<div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Agent Name:</label>';
        body_add +='        </div>';

        body_add +='    <div class="col">';
        body_add +=' <select id="agent'+input_value+'" name="agent[]" style="color:#0C1830;border-color:#102958;" class="form-control" required>';
        body_add +=' <option value="" selected>Select Agent Name</option>';
        body_add +='<?php foreach($results_agent as $result){ ?>';
        body_add +='<option value="<?php echo $result->id; ?>" ><?php echo $result->title_name." ".$result->first_name." ".$result->last_name."(".$result->nick_name.")"; ?></option>';
        body_add +='            <? } ?>';
        body_add +='        </select>';
        body_add +='    </div>';

        body_add +='    <div class="col-sm-2 label_left" >';
        body_add +='        <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Upload Documents:</label>';
        body_add +='    </div>';
                
        body_add +='    <div class="col">';
        body_add +='        <input name="file_d[]" type="file" style="width: 100%;" name="img" src="image.php?filename=<?php echo htmlentities($path_file) ?>" id="imgInp'+input_value+'"  accept="application/pdf" required>';
        body_add +='    </div>';

        body_add +='</div>';

        body_add +='<script>';

        body_add +='$(document).ready( function() {';

        body_add +='        function checkFileSize() {';
        body_add +='            var fileInput = document.getElementById("imgInp'+input_value+'");';
        body_add +='            var fileSize = fileInput.files[0].size;';
        body_add +='            var maxSize = 5 * 1024 * 1024;';
        body_add +='            if (fileSize > maxSize) {';
        body_add +='                alert("File size exceeds 5MB. Please choose a file smaller than 5MB.");';
        body_add +='                document.getElementById("imgInp'+input_value+'").value = "";';
        body_add +='            }';
        body_add +='        }';

        body_add +='function readURL(input) {';
        body_add +='    var fileName = document.getElementById("imgInp'+input_value+'").value;';
        body_add +='    var idxDot = fileName.lastIndexOf(".") + 1;';
        body_add +='    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();';
        body_add +='    if (extFile=="pdf"){';
        body_add +='        if (input.files && input.files[0]) {';
        body_add +='            var reader = new FileReader();';
        body_add +='            reader.readAsDataURL(input.files[0]);';
        body_add +='        }';
        body_add +='    }else{';
        // body_add +='        var reader = new FileReader();';
        // body_add +='       reader.readAsDataURL(input.files[0]);';
        body_add +='        document.getElementById("imgInp'+input_value+'").value=null;';
        body_add +='        alert("Only pdf files are allowed!");';
        body_add +='    }}';
        body_add +='$("#imgInp'+input_value+'").change(function(){';

        body_add +=' $.ajax({';
        body_add +='                url: "check_folder_size_json.php",';
        body_add +='               type: "GET",';
        body_add +='                success: function(response) {';
        body_add +='                    data = JSON.parse(response);';
        body_add +='                    if (data.alert) {';
        body_add +='                        document.getElementById("imgInp").value = null;';
        body_add +='                        var message = "The folder at " + data.folderPath + " is nearly full. Remaining space: " + data.remainingSizeGB + " GB.";';
        body_add +='                        alert(message);';
        body_add +='                    }else{';

        body_add +='                        checkFileSize();';
        body_add +='                        readURL(this);';

        body_add +='                    }';
        body_add +='               }';
        body_add +='            });';

        body_add +='    });';
        body_add +='});';

        body_add +='</'+'script>';

        body_add +='<div  class="form-group row col-md-10 col-md-offset-1" >';

        body_add +='    <div id="area_not_label'+input_value+'" hidden="true" class="col-sm-2 label_left" >';

        body_add +='        <label style="color: #102958;" for="staticEmail" >Reason:</label>';
        body_add +='    </div>';
        body_add +='    <div id="area_not'+input_value+'" hidden="true" class="col">';
        body_add +='        <textarea class="form-control" id="textarea_detail'+input_value+'" name="textarea_detail[]" rows="5" placeholder="Cancellation reason" ></textarea>';
        body_add +='    </div>';
        body_add +='     <div class="col-sm-2 label_left" >';
        body_add +='    </div>';
        body_add +='    <div class="col">';
        body_add +='    </div>';
        body_add +='</div>';

        body_add +='</div>';
        body_add +='</div></div></div></div>';

    //Start popup ModalNotrenew ------------------------
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

    //End popup ModalNotrenew ------------------------

    //Start popup ModalRenew ------------------------

    body_add +='<div id="ModalRenew'+input_value+'" data-backdrop="static" class="modal fade" role="dialog">';
    body_add +='<div class="modal-dialog modal-lg" >';
    body_add +='    <div class="modal-content">';
    body_add +='       <div class="modal-header">';
    body_add +='        <div class="col-sm-12 px-3" class="text-left">';
    body_add +='            Please enter new information.';
    body_add +='        </div>';
    body_add +='        </div>  ';
    body_add +='        <div class="modal-body">';
    body_add +='        <div class="form-group row col-md-12">';
    body_add +='            <div class="col-sm-2 " >';
    body_add +='                <label style="color: #102958;" for="staticEmail" >Period:</label>';
    body_add +='            </div> ';
    body_add +='            <div class="col-sm-4">';
    body_add +='            <select id="period_popup'+input_value+'"  required="required" style="color: #0C1830;border-color:#102958;"class="form-control" value="0" >';
    body_add +='                    <?php  foreach($results_period as $result){ ?>';
    body_add +='                    <option value="<?php echo $result->id; ?>" ><?php echo $result->period; ?></option>';
    body_add +='                    <? } ?>';
    body_add +='                </select>';
    body_add +='            </div>';
    body_add +='            <div class="col-sm-2 " >';
    body_add +='            </div>';
    body_add +='            <div class="col-sm-4">';
    body_add +='            </div>';
    body_add +='        </div>';

    body_add +='        <div class="form-group row col-md-12">';
    body_add +='            <div class="col-sm-2" >';
    body_add +='                <label style="color: #102958;" >Start date:</label>';
    body_add +='            </div> ';
    body_add +='            <div class="col-sm-4">';
    body_add +='                <input id="start_date_popup'+input_value+'"  required="required" style="color: #0C1830;border-color:#102958;text-align: center;" type="text" class="form-control" ';
    body_add +='                value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" >';
    body_add +='            </div>';
    body_add +='            <div class="col-sm-2 " >';
    body_add +='                <label style="color: #102958;" for="staticEmail" >End date:</label>';
    body_add +='            </div> ';
    body_add +='            <div class="col-sm-4">';
    body_add +='                <input id="end_date_popup'+input_value+'"  required="required" style="color: #0C1830;border-color:#102958;text-align: center;" type="text"  class="form-control" ';
    body_add +='                value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" >';
    body_add +='            </div>';
    body_add +='        </div>';

        body_add +='<script>';
        body_add +='$(document).ready(function(){';
        body_add +='$('+"'#start_date_popup"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='$('+"'#end_date_popup"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='$('+"'#paid_date_pop"+input_value+"'"+').datepicker({';
        body_add +='  format: '+"'dd-mm-yyyy'"+',';
        body_add +='  language: '+"'en'"+'';
        body_add +='});';
        body_add +='});';
        body_add +='</'+'script>';

    //Start premium----------------------------------------------------------------------------------------------

        body_add +='<div class="form-group row col-md-12">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Premium Rate:</label>';
        body_add +='       </div>';
        body_add +='        <div class="col-sm-2">';
        body_add +='            <input id="premium_rate_pop'+input_value+'" type="number" style="border-color:#102958;text-align: right;" step="0.01" min="0" class="form-control" ';
        body_add +='                onchange="';

        body_add +='   var premium = parseFloat(this.value).toFixed(2);';

        body_add +='   var percent = parseFloat(document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value).toFixed(2);';
        body_add +='                if(document.getElementById('+"'calculate_php"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='                if(Number.isInteger(parseFloat(this.value).toFixed(2))){';
        body_add +='                    this.value=this.value+'+"'.00'"+';';
        body_add +='                }else{';
        body_add +='                    this.value=parseFloat(this.value).toFixed(2);';
        body_add +='                }';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else{';
        body_add +='   document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value = parseFloat(document.getElementById('+"'percent_trade"+input_value+"'"+').value).toFixed(2);';
        body_add +='                    var commission = percent;';
        body_add +='                }';
        body_add +='                document.getElementById('+"'commission_pop"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';

        body_add +='                " />';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Paid Date:</label>';
        body_add +='        </div> ';
        body_add +='         <div class="col-sm-2">';
        body_add +='            <input id="paid_date_pop'+input_value+'" style="color: #0C1830;border-color:#102958;text-align: center;" type="text"  class="form-control" ';
        body_add +='            value="<?php echo $paid_date; ?>" placeholder="dd-mm-yyyy" >';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 " >';
        body_add +='             <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Calculate by:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <select id="calculate_php'+input_value+'"  value="<?php echo $result->product_category; ?>" style="color: #0C1830;border-color:#102958;" class="form-control" ';
        body_add +='                onchange="';
        body_add +='                if(document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value!='+"''"+'){';
        body_add +='  var premium = parseFloat(document.getElementById('+"'premium_rate_pop"+input_value+"'"+').value).toFixed(2);';
        body_add +='  var percent = parseFloat(document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value).toFixed(2);';

        body_add +='      if(document.getElementById('+"'calculate_php"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='      if (parseFloat(percent)>100){';
        body_add +='   document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value=parseFloat(100.00).toFixed(2)+'+"'%'"+';';
        body_add +='      }else{';
        body_add +='   document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value=parseFloat(percent).toFixed(2)+'+"'%'"+';';
        body_add +='      } ';

        body_add +='     var percent = parseFloat(document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value).toFixed(2);';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else{';
        body_add +='                    document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value = percent;';
        body_add +='                    var commission = percent;';
        body_add +='                }';
        body_add +='                document.getElementById('+"'commission_pop"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';
        body_add +='                }';
        body_add +='                " >';
        body_add +='                <option value="Percentage" >Percentage</option>';
        body_add +='                <option value="Net Value" >Net Value</option>';
        body_add +='            </select>';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Value:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <input id="percent_trade_pop'+input_value+'" type="text" class="form-control" style="border-color:#102958;text-align: right;" onchange="';

        body_add +='                var num = parseInt(parseFloat(this.value).toFixed(0));';

        body_add +='                if(Number.isInteger(num)){';

        body_add +='var premium = parseFloat(document.getElementById('+"'premium_rate_pop"+input_value+"'"+').value).toFixed(2);';

        body_add +='                var percent = parseFloat(this.value).toFixed(2);';

        body_add +='                if(document.getElementById('+"'calculate_php"+input_value+"'"+').value=='+"'Percentage'"+'){';
        body_add +='                    if (parseFloat(this.value)>100){';
        body_add +='                        this.value=parseFloat(100.00).toFixed(2)+'+"'%'"+';';
        body_add +='                    }else{';
        body_add +='                        this.value=parseFloat(this.value).toFixed(2)+'+"'%'"+';';
        body_add +='                    } ';
        body_add +='                    var percent = parseFloat(this.value).toFixed(2);';
        body_add +='                    var commission = ((percent / 100) * premium);';
        body_add +='                }else{';
        body_add +='                    document.getElementById('+"'percent_trade_pop"+input_value+"'"+').value = this.value;';
        body_add +='                    var commission = percent;';
        body_add +='                }';
        body_add +='                document.getElementById('+"'commission_pop"+input_value+"'"+').value =parseFloat(commission).toFixed(2);';
        body_add +='                }else{';
        body_add +='                    this.value='+"''"+';';
        body_add +='                }';

        body_add +='                " />';
        body_add +='        </div> ';
        body_add +='         <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Commission rate:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='            <input type="number" id="commission_pop'+input_value+'" style="border-color:#102958;text-align: right;" class="form-control" readOnly/>';
        body_add +='        </div>';
        body_add +='         <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Payment status:</label>';
        body_add +='        </div> ';
        body_add +='        <div class="col-sm-2 " >';
        body_add +='<select  id="payment_status_pop'+input_value+'" style="color: #0C1830;border-color:#102958;" class="form-control" >';
        body_add +='                <option value="Paid" >Paid</option>';
        body_add +='                <option value="Not Paid" >Not Paid</option>';
        body_add +='            </select>';
        body_add +='        </div>';

        body_add +='    </div>';

        //End premium----------------------------------------------------------------------------------------------

    body_add +='        </div>';
    body_add +='         <div class="modal-footer">';
    body_add +='        <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn" onclick="click_payment'+input_value+'()" >Submit</button>';
    body_add +='        </div>';
    body_add +='    </div>';
    body_add +='</div>';
    body_add +='</div>';
 

    body_add +='<script >';
    body_add +='function click_payment'+input_value+'() {';

    // body_add +=' alert('+"'click_payment:'"+'+'+input_value+'); ';

    body_add +='    document.getElementById("period'+input_value+'").value = document.getElementById("period_popup'+input_value+'").value;';
    body_add +='    $("#period'+input_value+'").selectpicker('+"'refresh'"+');';
    body_add +='    document.getElementById("start_date'+input_value+'").value = document.getElementById("start_date_popup'+input_value+'").value;';
    body_add +='    document.getElementById("end_date'+input_value+'").value = document.getElementById("end_date_popup'+input_value+'").value;';
    
    // body_add +='  $('+"'#ModalNotrenew"+input_value+"'"+').modal('+"'hide'"+');';

    body_add +='var value_premium'+input_value+' = document.getElementById("premium_rate_pop'+input_value+'").value;';
    body_add +='    var value_percent'+input_value+' = document.getElementById("percent_trade_pop'+input_value+'").value;';
    body_add +='    if(value_premium'+input_value+'=="" || value_percent'+input_value+'==""){';
    body_add +='        alert('+"'Please enter complete information.'"+');';
    body_add +='    }else{';
    body_add +='        document.getElementById("premium_rate'+input_value+'").value = document.getElementById("premium_rate_pop'+input_value+'").value;';
    body_add +='        document.getElementById("percent_trade'+input_value+'").value = document.getElementById("percent_trade_pop'+input_value+'").value;';
    body_add +='        document.getElementById("calculate'+input_value+'").value = document.getElementById("calculate_php'+input_value+'").value;';
    body_add +='        document.getElementById("commission'+input_value+'").value = document.getElementById("commission_pop'+input_value+'").value;';
    body_add +='        document.getElementById("payment_status'+input_value+'").value = document.getElementById("payment_status_pop'+input_value+'").value;';

    body_add +='document.getElementById("paid_date'+input_value+'").value = document.getElementById("paid_date_pop'+input_value+'").value;';

    // body_add +='        $('+"'#ModalRenew'"+').modal('+"hide'"+');';
    body_add +='        $('+"'#ModalRenew"+input_value+"'"+').modal('+"'hide'"+');';
    body_add +='    }';

    body_add +='} ';
    body_add +='</'+'script>';

    //End popup ModalRenew ------------------------


     // body_add +='var productObject = $('+"'#product_cat"+input_value+"'"+');';

    body_add +='<script type="text/javascript">';
    body_add +='$(function(){';
    body_add +='    var product_cat_object = $('+"'#product_cat"+input_value+"'"+');';
    body_add +='    var product_sub_object = $('+"'#sub_cat"+input_value+"'"+');';
    body_add +='    product_cat_object.on('+"'change'"+', function(){';
    body_add +='        var product_cat_id = $(this).val();  '; 
    body_add +='        product_sub_object.html('+"''"+');';
    body_add +='        $.get('+"'get_product_subcategories.php?id='"+' + product_cat_id, function(data){';
    body_add +='        var result = JSON.parse(data);';
    body_add +='        $.each(result, function(index, item){';
    body_add +='            product_sub_object.append(';
    body_add +='               $('+"'<option></option>'"+').val(item.id).html(item.subcategorie)';
    body_add +='            );';
    body_add +='        });';
    body_add +='        $("#sub_cat'+input_value+'").selectpicker('+"'refresh'"+');';
    body_add +='        });';
    body_add +='    });';
    body_add +='});';
    body_add +='</'+'script>';

    body_add +='<script type="text/javascript">';
    body_add +='$(function(){';
    body_add +='    var insurance_com_object = $('+"'#insurance_com"+input_value+"'"+');';
    body_add +='    var currency_object = $('+"'#currency"+input_value+"'"+');';
    body_add +='    var product_object = $('+"'#product_name"+input_value+"'"+');';
    body_add +='    var agent_name = $('+"'#agent"+input_value+"'"+');';

    body_add +='    insurance_com_object.on('+"'change'"+', function(){';
    body_add +='    var currency_id_new = $(this).val();';
    body_add +='    $.get('+"'get_currency_list.php?id='"+'+currency_id_new, function(data){';
    body_add +='        var result = JSON.parse(data);';
    // body_add +=' alert('+"'currency_id:'"+'+currency_id_new); ';
    body_add +='            $.each(result, function(index, item){';
    body_add +='                document.getElementById("currency_id'+input_value+'").value = item.id;';
    body_add +='                document.getElementById("currency'+input_value+'").value = item.currency;';
    body_add +='            });';
    body_add +='       });';
    
    body_add +='        product_object.html('+"''"+');';
    body_add +='        $.get('+"'get_product.php?id='"+'+currency_id_new, function(data){';
    body_add +='            var result = JSON.parse(data);';
    body_add +='            $.each(result, function(index, item){';
    body_add +='                product_object.append(';
    body_add +='                $('+"'<option></option>'"+').val(item.id).html(item.product_name)';
    body_add +='                );';
    body_add +='            });';
    body_add +='        });';

    body_add +='        agent_name.html('+"''"+');';
    body_add +='        $.get('+"'get_agent.php?id='"+'+currency_id_new, function(data){';
    body_add +='            var result = JSON.parse(data);';
    body_add +='            agent_name.append($('+"'<option></option>'"+').val('+"''"+').html("Select Agent Name"));';
    body_add +='            $.each(result, function(index, item){';
    body_add +='                agent_name.append(';
    body_add +='                $('+"'<option></option>'"+').val(item.id).html(item.title_name+" "+item.first_name+" "+item.last_name)';
    body_add +='                );';
    body_add +='            });';
    body_add +='            $("#agent'+input_value+'").selectpicker('+"'refresh'"+');';
    body_add +='        });';

    body_add +='    });';
    body_add +='});';
    body_add +='</'+'script>';


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