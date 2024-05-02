<div id="ModalRenew" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
            <div class="col-sm-12 px-3" class="text-left">
                Please enter new information.
            </div>
            </div>  
            <div class="modal-body">

            <div class="form-group row col-md-12">
                <div class="col-sm-2 " >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period:</label>
                </div> 
                <div class="col-sm-4">
                    <select id="period_popup"  required="required" style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>
                        <!-- <option value="" selected>Select Period</option> -->
                        <?php  foreach($results_period as $result){ ?>
                        <option value="<?php echo $result->id; ?>" ><?php echo $result->period; ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-sm-2 " >
                </div>
                <div class="col-sm-4">
                </div>
            </div>

            <script>
  $(document).ready(function(){
    $('#start_date_popup').datepicker({
      format: 'dd-mm-yyyy',
      language: 'en'
    });
    $('#end_date_popup').datepicker({
      format: 'dd-mm-yyyy',
      language: 'en'
    });
    $('#paid_date_pop').datepicker({
      format: 'dd-mm-yyyy',
      language: 'en'
    });
  });
</script>

            <div class="form-group row col-md-12">
                <div class="col-sm-2" >
                    <label style="color: #102958;" ><small><font color="red">*</font></small>Start date:</label>
                </div> 
                <div class="col-sm-4">
                    <input id="start_date_popup"  required="required" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" 
                    value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" required>
                </div>
                <div class="col-sm-2 " >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>End date:</label>
                </div> 
                <div class="col-sm-4">
                    <input id="end_date_popup"  required="required" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control" 
                    value="<?php echo $start_date; ?>" placeholder="dd-mm-yyyy" required>
                </div>
            </div>

            <div class="form-group row col-md-12">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Premium Rate:</label>
                </div>
                <div class="col-sm-2">
                    <input id="premium_rate_pop"  type="number" style="border-color:#102958;" step="0.01" min="0" class="form-control" 
                        onchange="
                        var premium = parseFloat(this.value).toFixed(2);
                        var percent = parseFloat(document.getElementById('percent_trade_pop').value).toFixed(2);
                        if(document.getElementById('calculate_php').value=='Percentage'){
                        if(Number.isInteger(parseFloat(this.value).toFixed(2))){
                            this.value=this.value+'.00';
                        }else{
                            this.value=parseFloat(this.value).toFixed(2);
                        }
                            var commission = ((percent / 100) * premium);
                        }else{
                        document.getElementById('percent_trade_pop').value = parseFloat(document.getElementById('percent_trade_pop').value).toFixed(2);
                            var commission = percent;
                        }
                        document.getElementById('commission_pop').value =parseFloat(commission).toFixed(2);
                        " required/>
                </div>

                <div class="col-sm-2 " >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Paid Date:</label>
                </div> 
                <div class="col-sm-2">
                    <input id="paid_date_pop" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" placeholder="dd-mm-yyyy"
                    value="<?php echo $paid_date; ?>" >
                </div>

                <div class="col-sm-2 " >
                     <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Calculate by:</label>
                </div>
                <div class="col-sm-2 " >
                    <select id="calculate_php" value="<?php echo $result->product_category; ?>" style="color: #0C1830;border-color:#102958;" class="form-control" 
                        onchange="
                        if(document.getElementById('percent_trade_pop').value!=''){
                        var premium = parseFloat(document.getElementById('premium_rate_pop').value).toFixed(2);
                        var percent = parseFloat(document.getElementById('percent_trade_pop').value).toFixed(2);
                        if(document.getElementById('calculate_php').value=='Percentage'){
                            if (parseFloat(percent)>100){
                                document.getElementById('percent_trade_pop').value=parseFloat(100.00).toFixed(2)+'%';
                            }else{
                                document.getElementById('percent_trade_pop').value=parseFloat(percent).toFixed(2)+'%';
                            } 
                            var percent = parseFloat(document.getElementById('percent_trade_pop').value).toFixed(2);
                            var commission = ((percent / 100) * premium);
                        }else{
                            document.getElementById('percent_trade_pop').value = percent;
                            var commission = percent;
                        }
                        document.getElementById('commission_pop').value =parseFloat(commission).toFixed(2);
                        }
                        " required/>
                        <option value="Percentage" >Percentage</option>
                        <option value="Net Value" >Net Value</option>
                    </select>
                </div>

                <div class="col-sm-2 " >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Value:</label>
                </div> 
                <div class="col-sm-2 " >
                    <input id="percent_trade_pop" type="text" class="form-control" style="border-color:#102958;" onchange="
                        var num = parseInt(parseFloat(this.value).toFixed(0));
                        if(Number.isInteger(num)){
                        var premium = parseFloat(document.getElementById('premium_rate_pop').value).toFixed(2);
                        var percent = parseFloat(this.value).toFixed(2);
                        if(document.getElementById('calculate_php').value=='Percentage'){
                            if (parseFloat(this.value)>100){
                                this.value=parseFloat(100.00).toFixed(2)+'%';
                            }else{
                                this.value=parseFloat(this.value).toFixed(2)+'%';
                            } 
                            var percent = parseFloat(this.value).toFixed(2);
                            var commission = ((percent / 100) * premium);
                        }else{
                            document.getElementById('percent_trade_pop').value = this.value;
                            var commission = percent;
                        }
                        document.getElementById('commission_pop').value =parseFloat(commission).toFixed(2);
                        }else{
                            this.value='';
                        }
                        " />
                </div> 
                 <div class="col-sm-2 " >
                    <label style="color: #102958;" for="staticEmail" >Commission rate:</label>
                </div> 
                <div class="col-sm-2 " >
                    <input type="number" id="commission_pop" style="border-color:#102958;" class="form-control" readOnly/>
                </div>
                 <div class="col-sm-2 " >
                    <label style="color: #102958;" for="staticEmail" >Payment status:</label>
                </div> 
                <div class="col-sm-2 " >
                    <select id="payment_status_pop" style="color: #0C1830;border-color:#102958;" class="form-control"   >
                        <option value="Paid" >Paid</option>
                        <option value="Not Paid" >Not Paid</option>
                    </select>
                </div>

            </div>    

        </div>

             <div class="modal-footer">
            <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn" onclick="click_payment()" >Submit</button>
            </div>
        </div>
    </div>
</div>
<script >
    function click_payment() {
        document.getElementById("period").value = document.getElementById("period_popup").value;
        $("#period").selectpicker('refresh');
        document.getElementById("start_date").value = document.getElementById("start_date_popup").value;
        document.getElementById("end_date").value = document.getElementById("end_date_popup").value;
        
        var value_premium = document.getElementById("premium_rate_pop").value;
        var value_percent = document.getElementById("percent_trade_pop").value;
        if(value_premium=="" || value_percent==""){
            alert('Please enter complete information.');
        }else{
            document.getElementById("premium_rate").value = document.getElementById("premium_rate_pop").value;
            document.getElementById("percent_trade").value = document.getElementById("percent_trade_pop").value;
            document.getElementById("calculate").value = document.getElementById("calculate_php").value;
            document.getElementById("commission").value = document.getElementById("commission_pop").value;
            document.getElementById("payment_status").value = document.getElementById("payment_status_pop").value;
            document.getElementById("paid_date").value = document.getElementById("paid_date_pop").value;
            $('#ModalRenew').modal('hide');
        }
    }   
</script>