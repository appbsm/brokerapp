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
                <div class="col-sm-2  label_left"  >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Policy No:</label>
                </div>
                <div class="col-sm-4 ">
                    <input id="policy_popup"  minlength="1" maxlength="50" style="color: #000;border-color:#102958;" type="text" class="form-control input_text" value="<?php echo $policy_no; ?>" required>
                </div>
            </div>

            <div class="form-group row col-md-12">
                <!-- <div class="col-sm-2 " >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period:</label>
                </div> 
                <div class="col-sm-2">
                    <select id="period_popup"  required="required" style="color: #0C1830;border-color:#102958;"class="form-control" value="0" required>
                        <?php  foreach($results_period as $result){ ?>
                        <option value="<?php echo $result->id; ?>" ><?php echo $result->period; ?></option>
                        <? } ?>
                    </select>
                </div> -->

                <div class="col-sm-2  label_left" >
                    <label style="color: #102958;" >Currency:</label>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="currency_popup" style="border-color:#102958; color: #000;  text-align: center;" class="form-control"
                     value="<?php echo $currency_name; ?>" readOnly/>
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Period type:</label>
                </div>
                <div class="col-sm-2">
                    <select id="period_type_popup" style="color: #0C1830;border-color:#102958;"class="form-control" >
                        <!-- <option value="" selected>Select Period</option> -->
                        <option value="Day" <?php if($period_type=="Day"){ echo "selected";} ?> >Day</option>
                        <option value="Month" <?php if($period_type=="Month"){ echo "selected";} ?> >Month</option>
                    </select>
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;"  ><small><font color="red">*</font></small>Period:</label>
                </div>
                <div class="col-sm-2">
                    <?php if($period_type==""){ $period_type = "Day";} ?>
                    <select <?php if($period_type=="Day"){echo 'hidden="true"';} ?>  id="period_month_popup" style="color: #0C1830;border-color:#102958;"class="form-control" value="0"  >
                        <!-- <option value="" selected>Select Period</option> -->
                        <?php  foreach($results_period as $result){ ?>
                        <option value="<?php echo $result->id; ?>" 
                            <?php if ($result->id==$period_id) { echo 'selected="selected"'; } ?>
                            ><?php echo $result->period; ?></option>
                        <? } ?>
                    </select>
                    <input <?php if($period_type=="Month"){echo 'hidden="true"';} ?> id="period_day_popup" minlength="1" maxlength="3" value="<?php echo $period_day; ?>" style="color: #0C1830;border-color:#102958;" type="number" class="form-control input_text" >
                </div>
            </div>

            <script>
                $('#period_type_popup').change(function(){
                    // var value_period = document.getElementById("period_type").value;
                    var value_period = $(this).val();
                    // alert("value_period:"+value_period);
                    if(value_period == "Day"){
                        document.getElementById("period_day_popup").hidden = false;
                        document.getElementById("period_day_popup").readOnly = false;
                        document.getElementById("period_day_popup").setAttribute("required","required");
                        document.getElementById("period_month_popup").hidden = true;
                        document.getElementById("period_month_popup").removeAttribute('required');
                    }else if(value_period == "Month"){
                        document.getElementById("period_day_popup").hidden = true;
                        document.getElementById("period_day_popup").removeAttribute('required');
                        document.getElementById("period_month_popup").hidden = false;
                        document.getElementById("period_month_popup").setAttribute("required","required");

                    }else{
                        document.getElementById("period_day_popup").hidden = false;
                        document.getElementById("period_day_popup").readOnly = true;
                        document.getElementById("period_month_popup").hidden = true;
                    }
                });
            </script>

            <div class="form-group row col-md-12">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" ><small><font color="red">*</font></small>Start date:</label>
                </div> 
                <div class="col-sm-2">
                    <input id="start_date_popup"  required="required" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" 
                    value="" placeholder="dd-mm-yyyy" >
                    <?php //echo $start_date; ?>
                </div>
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>End date:</label>
                </div> 
                <div class="col-sm-2">
                    <input id="end_date_popup"  required="required" style="color: #0C1830;border-color:#102958;" type="text"  class="form-control" 
                    value="" placeholder="dd-mm-yyyy" >
                    <?php //echo $stop_date; ?>
                </div>
            </div>

            <div class="form-group row col-md-12">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Premium Rate:</label>
                </div>
                <div class="col-sm-2">
                    <input id="premium_rate_popup"  type="text" style="border-color:#102958;" step="0.01" min="0" class="form-control" 
                        value="<?php echo number_format((float)$premium_rate, 2, '.', ','); ?>"
                        onchange="
                        // var premium = parseFloat(this.value).toFixed(2);
                        // var percent = parseFloat(document.getElementById('percent_trade_pop').value).toFixed(2);
                        // if(document.getElementById('calculate_pop').value=='Percentage'){
                        // if(Number.isInteger(parseFloat(this.value).toFixed(2))){
                        //     this.value=this.value+'.00';
                        // }else{
                        //     this.value=parseFloat(this.value).toFixed(2);
                        // }
                        //     var commission = ((percent / 100) * premium);
                        // }else{
                        // document.getElementById('percent_trade_pop').value = parseFloat(document.getElementById('percent_trade_pop').value).toFixed(2);
                        //     var commission = percent;
                        // }
                        // document.getElementById('commission_pop').value =parseFloat(commission).toFixed(2);
                        " />
                </div>

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Conversion Value:</label>
                </div>
                <div class="col-sm-2">
                    <input id="convertion_value_popup"  type="text" style="border-color:#102958;" step="0.01" min="0" class="form-control" 
                        value="<?php echo number_format((float)$premium_rate, 2, '.', ','); ?>" readOnly/>
                </div>  

                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Collected Date:</label>
                </div> 
                <div class="col-sm-2">
                    <input id="paid_date_popup" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" placeholder="dd-mm-yyyy"
                    value="<?php echo $paid_date; ?>" >
                </div>
            </div>

            <div class="form-group row col-md-12">
                <div class="col-sm-2 label_left" >
                     <label style="color: #102958;" for="staticEmail" >Commission Type:</label>
                </div>
                <div class="col-sm-2 " >
                    <select id="calculate_popup" value="<?php echo $result->product_category; ?>" style="color: #0C1830;border-color:#102958;" class="form-control" 
                        onchange="
                    // if(document.getElementById('percent_trade_popup').value!=''){
                    //     var premiumInput = document.getElementById('convertion_value_popup').value.replace(/,/g,'');
                    //     var premium = parseFloat(premiumInput).toFixed(2);

                    //     var percent = parseFloat(document.getElementById('percent_trade_popup').value).toFixed(2);

                    //     if(document.getElementById('calculate_popup').value=='Percentage'){
                    //         if (parseFloat(percent)>100){
                    //             document.getElementById('percent_trade_popup').value=parseFloat(100.00).toFixed(2)+'%';
                    //         }else{
                    //             document.getElementById('percent_trade_popup').value=parseFloat(percent).toFixed(2)+'%';
                    //         } 
                    //         var percent = parseFloat(document.getElementById('percent_trade_popup').value).toFixed(2);
                    //         var commission = ((percent / 100) * premium);

                    //     }else if(document.getElementById('calculate_popup').value=='Net Value'){
                    //         document.getElementById('percent_trade_popup').value = percent;
                    //         var commission = percent;
                    //     }
                    //     if(commission!='NaN'){
                    //         var commissionNumber  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(commission);
                    //         document.getElementById('commission_popup').value =commissionNumber;
                    //     }
                    // }
                        " />
                        <option value="" selected>Select Calculate by</option>
                        <option value="Percentage" <?php if ("Percentage"==$calculate_type) { echo ' selected="selected"'; } ?> >Percentage</option>
                        <option value="Net Value" <?php if ("Net Value"==$calculate_type) { echo ' selected="selected"'; } ?> >Net Value</option>
                    </select>
                </div>
            </div> 

            <div class="form-group row col-md-12">
                <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Commission Value:</label>
                </div> 
                <div class="col-sm-2 " >
                    <input id="percent_trade_popup" type="text" class="form-control" style="border-color:#102958;"
                    value="<?php echo number_format((float)$percent_trade, 2, '.', ''); ?>" onchange="
                        var num = $(this).val().replace(/,/g,'');
                        if (parseFloat(num)) {
                            var premiumInput = document.getElementById('convertion_value_popup').value.replace(/,/g,'');
                            var premium = parseFloat(premiumInput).toFixed(2);
                        if(document.getElementById('calculate_popup').value=='Percentage'){
                            if (parseFloat(num)>100){
                                this.value=parseFloat(100.00).toFixed(2)+'%';
                            }else{
                                this.value=parseFloat(num).toFixed(2)+'%';
                            } 
                            var percent = parseFloat(this.value).toFixed(2);
                            var commission = ((percent / 100) * premium);
                        }else{
                            document.getElementById('percent_trade_popup').value = num;
                            var value_con  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(num);
                            this.value=value_con;
                            var commission = num;
                        }
                            // document.getElementById('commission').value =parseFloat(commission).toFixed(2);
                            if(commissionNumber!=''){
                                var commissionNumber  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(commission);
                                document.getElementById('commission_popup').value =commissionNumber;
                            }
                        }else{
                            this.value='';
                            document.getElementById('commission_popup').value ='';
                        }
                        " />
                </div> 
                 <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Commission rate:</label>
                </div> 
                <div class="col-sm-2 " >
                    <input type="text" id="commission_popup" style="border-color:#102958;" class="form-control" value="<?php echo number_format((float)$commission_rate, 2, '.', ''); ?>" readOnly/>
                </div>
                 <div class="col-sm-2 label_left" >
                    <label style="color: #102958;" for="staticEmail" >Commission Status:</label>
                </div> 
                <div class="col-sm-2 " >
                    <select id="payment_status_popup" style="color: #0C1830;border-color:#102958;" class="form-control"   >
                       
                        <option value="Paid" >Paid</option>
                         <option value="Not Paid" selected>Not Paid</option>
                    </select>
                </div>
            </div>

    </div>

            <div class="modal-footer">
                <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn" onclick="click_payment()" >Submit</button>
                <button type="button" style="background-color: #0275d8;color: #F9FAFA;" class="btn " data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

        <script>
            $(function(){
                var premium_rate_object = $('#premium_rate_popup');
                var convertion_value_object = $('#convertion_value_popup');
                var currency_object = $('#currency');

               premium_rate_object.on('change', function(){
                    
                var premium_value = $(this).val().replace(/,/g,'');
                // alert('premium_value:'+premium_value);
                
                if (parseFloat(premium_value)) {

                    var partner_currency = document.getElementById("partner_currency").value;
                    var partner_currency_value = document.getElementById("partner_currency_value").value;
                    if(currency_object.val()=='฿THB'){
                        var formattedResult  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(premium_value);
                        convertion_value_object.val(formattedResult);
                    }else{
                        if(partner_currency!=''){
                            if(parseInt(partner_currency)>parseInt(partner_currency_value)){
                                var value = (premium_value/partner_currency_value);
                                var formattedResult  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(premium_value);
                                convertion_value_object.val(formattedResult);
                            }else{
                                var value = (premium_value*partner_currency_value);
                                var formattedResult  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
                                convertion_value_object.val(formattedResult);
                            }
                        }else{

                            var formattedResult  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(premium_value);
                            convertion_value_object.val(formattedResult);
                        }
                    }

                        var commission=0;
                        var premiumInput = document.getElementById('premium_rate_popup').value.replace(/,/g,'');
                        var premium = parseFloat(premiumInput).toFixed(2);
                        var con_vaInput = document.getElementById('convertion_value_popup').value.replace(/,/g,'');
                        var con_va = parseFloat(con_vaInput).toFixed(2);
                        var percentInput = document.getElementById('percent_trade_popup').value.replace(/,/g,'');
                        var percent = parseFloat(percentInput).toFixed(2);

                        // if(Number.isInteger(parseFloat(premium))){
                            if(document.getElementById('calculate_popup').value=='Percentage'){
                                var commission = ((percent / 100) * con_va);
                            }else{

                                var commission = percent;
                            }
                        // }else{
                        //  document.getElementById('premium_rate').value=parseFloat(con_va);
                        // }

                        if(commission!='NaN'){
                            var commissionNumber  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(commission);
                            document.getElementById('commission_popup').value =commissionNumber;
                        }

                        // var value_pre  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(premium_value);
                        var value_pre  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format($(this).val().replace(/,/g,''));
                        this.value=value_pre;
                 }else{
                    this.value='';
                    document.getElementById('commission_popup').value ='';
                    convertion_value_object.val('');
                 }

                });
            });
            </script>

            <script>
              $(document).ready(function(){
                $('#start_date_popup').datepicker({
                  format: 'dd-mm-yyyy',
                  language: 'en'
                }).on('changeDate', function(e) {
                    updateEndDate();
                });
                $('#end_date_popup').datepicker({
                  format: 'dd-mm-yyyy',
                  language: 'en'
                });
                $('#paid_date_popup').datepicker({
                  format: 'dd-mm-yyyy',
                  language: 'en'
                });
              

                $('#period_type_popup').change(function(){
                    // var value_period = document.getElementById("period_type").value;
                    var value_period = $(this).val();
                    // alert("value_period:"+value_period);
                    if(value_period == 'Day'){
                        document.getElementById("period_day_popup").hidden = false;
                        document.getElementById("period_day_popup").readOnly = false;
                        document.getElementById('period_day_popup').setAttribute("required","required");
                        document.getElementById("period_month_popup").hidden = true;
                        document.getElementById('period_month_popup').removeAttribute('required');
                    }else if(value_period == 'Month'){
                        document.getElementById("period_day_popup").hidden = true;
                        document.getElementById('period_day_popup').removeAttribute('required');
                        document.getElementById("period_month_popup").hidden = false;
                        document.getElementById('period_month_popup').setAttribute("required","required");

                    }else{
                        document.getElementById("period_day_popup").hidden = false;
                        document.getElementById("period_day_popup").readOnly = true;
                        document.getElementById("period_month_popup").hidden = true;
                    }
                });

                  document.getElementById('period_day_popup').addEventListener('input', updateEndDate);
                  document.getElementById('period_month_popup').addEventListener('input', updateEndDate);
                  $('#start_date_popup').on('change', function() { updateEndDate(); });

            function updateEndDate() {
                var periodDayInput = document.getElementById('period_day_popup');
                var periodMonthInput = document.getElementById('period_month_popup');
                var startDateInput = document.getElementById('start_date_popup');
                var endDateInput = document.getElementById('end_date_popup');
                // var periodDayInput.html;
                var period_type = document.getElementById('period_type_popup');
                // alert("periodMonthInput.html:"+periodMonthInput.options[periodMonthInput.selectedIndex].text);

                var parts = startDateInput.value.split('-');
                var startDate = new Date(parts[2], parts[1] - 1, parts[0]); 

                if(period_type.value == 'Day'){
                    var periodDay = parseInt(periodDayInput.value);
                    // ตรวจสอบว่า period_day และ start_date มีค่าหรือไม่
                    if (!isNaN(periodDay) && startDate instanceof Date && !isNaN(startDate.getTime())) {
                      // สร้างวัตถุ Date จาก start_date
                      var endDate = new Date(startDate.getTime());

                      // เพิ่มจำนวนวันตาม period_day
                      endDate.setDate(endDate.getDate() + periodDay);

                      // แสดงวันที่ใน input end_date
                      var formattedEndDate = endDate.getDate().toString().padStart(2, '0') + '-' + (endDate.getMonth() + 1).toString().padStart(2, '0') + '-' + endDate.getFullYear();
                      endDateInput.value = formattedEndDate;
                      $('#end_date_popup').datepicker('update', formattedEndDate);
                      $('#end_date').datepicker('update', formattedEndDate);
                    } else {
                      // หากไม่มีค่าใน period_day หรือ start_date ก็เคลียร์ค่าใน input end_date
                      endDateInput.value = '';
                    }
                }else if(period_type.value == 'Month'){
                    var periodDay = parseInt(periodMonthInput.options[periodMonthInput.selectedIndex].text);
                    if (!isNaN(periodDay) && startDate instanceof Date && !isNaN(startDate.getTime())) {
                        var endDate = new Date(addMonths(startDate, periodDay));
                        // alert("endDate:"+endDate);
                        var formattedEndDate = endDate.getDate().toString().padStart(2, '0') + '-' + (endDate.getMonth() + 1).toString().padStart(2, '0') + '-' + endDate.getFullYear();
                        // endDateInput.value = addMonths(startDate, periodMonthInput.value);
                        endDateInput.value = formattedEndDate;
                        $('#end_date_popup').datepicker('update', formattedEndDate);
                        $('#end_date').datepicker('update', formattedEndDate);
                    }else {
                      // หากไม่มีค่าใน period_day หรือ start_date ก็เคลียร์ค่าใน input end_date
                      endDateInput.value = '';
                    }
                }
              }

               // ฟังก์ชันสำหรับการเพิ่มเดือนให้กับวันที่
                  function addMonths(date, months) {
                    var d = new Date(date);
                    d.setMonth(d.getMonth() + parseInt(months));
                    // var currentDate = new Date(); // ดึงวันที่ปัจจุบัน
                    // currentDate.setMonth(currentDate.getMonth() + 3); // เพิ่ม 3 เดือน
                    return d;
                  }
            });

            </script>


<script >
    function click_payment() {

        var value_policy_popup = document.getElementById("policy_popup").value;

        var value_start = document.getElementById("start_date_popup").value;
        var value_end = document.getElementById("end_date_popup").value;
        
        var paid_date = document.getElementById("paid_date_popup").value;
        var period_type  = document.getElementById("period_type_popup").value;
        
        var premium_rate_pop = document.getElementById("premium_rate_popup").value;
        var commission = document.getElementById("commission_popup").value;

        
        if(value_start=="" || value_end=="" || paid_date=="" || period_type=="" || premium_rate_pop=="" || commission=="" || value_policy_popup=="" ){
            alert('Please enter complete information.');
        }else{
            
                if(period_type == "Day"){
                    if(document.getElementById("period_day_popup").value==""){
                        alert('Please enter complete information.');
                        return false;
                    }
                    document.getElementById("period_day").hidden = false;
                    document.getElementById("period_day").readOnly = false;
                    document.getElementById("period_day").setAttribute("required","required");
                    document.getElementById("period_month").hidden = true;
                    document.getElementById("period_month").removeAttribute('required');
                    document.getElementById("period_day").value = document.getElementById("period_day_popup").value;
                }else if(period_type == "Month"){
                    document.getElementById("period_day").hidden = true;
                    document.getElementById("period_day").removeAttribute('required');
                    document.getElementById("period_month").hidden = false;
                    document.getElementById("period_month").setAttribute("required","required");
                    document.getElementById("period_month").value = document.getElementById("period_month_popup").value;
                }

            var value_percent  = document.getElementById("percent_trade_popup").value;
            var value_premium  = document.getElementById("premium_rate_popup").value;
            var calculate  = document.getElementById("calculate_popup").value;
            var payment_status = document.getElementById("payment_status_popup").value;

            $("#period").selectpicker('refresh');

            document.getElementById("policy").value = value_policy_popup;
            document.getElementById("period_type").value = period_type;

            $('#start_date').datepicker('update', value_start);
            $('#end_date').datepicker('update', value_end);
            $('#paid_date').datepicker('update', paid_date);

            document.getElementById("start_date").value  = value_start;
            document.getElementById("end_date").value    = value_end;
            document.getElementById("paid_date").value = paid_date;

            document.getElementById("premium_rate").value = value_premium;
            document.getElementById("percent_trade").value = value_percent;

            document.getElementById("calculate").value = calculate;
            document.getElementById("commission").value = commission;
            document.getElementById("payment_status").value = payment_status;
            


            convertion_value_funtion();

            $('#ModalRenew').modal('hide');
        }
    }

    function convertion_value_funtion(){
        var premium_rate_object = $('#premium_rate_popup');
        var convertion_value_object = $('#convertion_value');
        var currency_object = $('#currency');   
        var premium_value =document.getElementById("premium_rate_popup").value.replace(/,/g,'');
        
                if (parseFloat(premium_value)) {
                    // var partner_currency = document.getElementById("partner_currency").value;
                    // var partner_currency_value = document.getElementById("partner_currency_value").value;
                    if(currency_object.val()=='฿THB'){
                        var formattedResult  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(premium_value);
                        convertion_value_object.val(formattedResult);
                    }else{
                        if(partner_currency!=''){
                            if(parseInt(partner_currency)>parseInt(partner_currency_value)){
                                var value = (premium_value/partner_currency_value);
                                var formattedResult = value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                convertion_value_object.val(formattedResult);
                            }else{
                                var value = (premium_value*partner_currency_value);
                                var formattedResult = value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                convertion_value_object.val(formattedResult);
                            }
                        }else{
                            var formattedResult = premium_value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            convertion_value_object.val(formattedResult);
                        }
                    }
                        var commission=0;
                        var premiumInput = document.getElementById('premium_rate').value.replace(/,/g,'');
                        var premium = parseFloat(premiumInput).toFixed(2);
                        var con_vaInput = document.getElementById('convertion_value').value.replace(/,/g,'');
                        var con_va = parseFloat(con_vaInput).toFixed(2);
                        var percentInput = document.getElementById('percent_trade').value.replace(/,/g,'');
                        var percent = parseFloat(percentInput).toFixed(2);

                            if(document.getElementById('calculate').value=='Percentage'){
                                var commission = ((percent / 100) * con_va);
                            }else{

                                var commission = percent;
                            }
   
                        if(commission!='NaN'){
                            var commissionNumber  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(commission);
                            document.getElementById('commission').value =commissionNumber;
                        }

                        var value_pre  = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(premium_value);
                        document.getElementById("premium_rate").value=value_pre;

                 }else{
                    ocument.getElementById("premium_rate").value='';
                    document.getElementById('commission').value ='';
                    convertion_value_object.val('');
                 }
    }   
</script>