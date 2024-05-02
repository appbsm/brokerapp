<script>
	var input_contact = 0;
	var i=0; 
	var input_value=0;

$(document).ready(function() {
    var customer_id = document.getElementById("id_company").value;
// alert('customer_id:'+customer_id);
    
$.get('get_contact_for_company.php?id=' + customer_id, function(data){
        var result = JSON.parse(data);
        var start="true";
        if(result!=""){
            $.each(result, function(index, item){
                if(start=="true"){
                input_contact=0;
                for (let i = 0; i <= input_value; i++) {
                    $('#row-con' + i + '').remove();
                }
                document.getElementById("rela_contact").value = item.id;
                document.getElementById("id_co").value = item.id;
                document.getElementById("title_co").value = item.title_name;
                document.getElementById("first_co").value = item.first_name;
                document.getElementById("last_co").value = item.last_name;
                document.getElementById("nick_co").value = item.nick_name;

                document.getElementById('mobile_co').value = item.mobile;
                document.getElementById('tel_co').value = item.tel;
                document.getElementById('email_co').value = item.email;

                document.getElementById('position_co').value = item.position;
                document.getElementById('line_co').value = item.line_id;
                document.getElementById('remark_co').value = item.remark;


                document.getElementById('department').value = item.department;

                // alert('customer_id:'+item.default_contact);
                // if(item.default_contact==1){
                    // document.getElementById("default_co").checked = ture;
                // }else{
                    // document.getElementById("default_co").checked = false;
                // }
                // document.getElementById("default_co").value = "default_id:"+item.id;
                document.getElementById("default_co").value = "default_id:0";
                
                start="false";

                }else{
                    input_value++;
                    input_contact++;
                    same_contact(item); 
                }
            });
        }
    });
});

	$('#add-con').click(function() {
			// alert('Start add-con');
            input_contact++;
            // alert('Check :'+input_value);
        var inputs = $('input');

        if(input_contact >= 5) {
            input_contact--;
            alert('Only five inputs allowed');
            return;
        }

        if(inputs.last().length > 0) {
            i = parseInt(inputs.last()[0].name.split('_')[1]); 
        }
        input_value++;
        i++;

            var body_add ='';
        body_add +='<div id="row-con'+input_value+'" class="container-fluid">';
        body_add +='<div class="row">';
        body_add +='    <div class="col-md-12 ">';
        body_add +='        <div class="panel">';
        body_add +='            <div class="panel-heading">';
        body_add +='            <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='                <div class="col">';
        body_add +='                    <div class="panel-title" style="color: #102958;" >';
        // body_add +='                        <h2 class="title">Contact Person '+input_value+'</h2>';
        body_add +='                        <h2 class="title">Contact Person</h2>';
        body_add +='                    </div>';
        body_add +='                </div>';
        body_add +='<div class="col">';
        body_add +='</div>  ';

        body_add +='               <div class="col text-right">';
        body_add +='<button type="button" class="btn btn_remove_con" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ input_value +'">X</button>';
        body_add +='                </div>&nbsp;&nbsp;';
        body_add +='                </div>';
        body_add +='            </div>';

        body_add +='<div class="panel-body">';
        body_add +='    <div class="form-group row mb-20 col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" ><small><font color="red">*</font></small>Title Name:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';

        body_add +='<input id="id_co" name="id_co[]" value="" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  hidden="true">';

        body_add +='            <select id="title_co" name="title_co[]" style="color: #4590B8;border-color:#102958;" class="form-control" required>';
        body_add +='                    <option value="" selected>Select Title Name</option>';
        body_add +='                    <?php  if($name_title=="Mr."){ ?>';
        body_add +='                        <option value="Mr." selected>Mr.</option>';
        body_add +='                    <?php }else{ ?>';
        body_add +='                        <option value="Mr." >Mr.</option>';
        body_add +='                    <?php } ?>';
        body_add +='                    <?php  if($name_title=="Ms."){ ?>';
        body_add +='                        <option value="Ms." selected>Ms.</option>';
        body_add +='                    <?php }else{ ?>';
        body_add +='                        <option value="Ms." >Ms.</option>';
        body_add +='                    <?php } ?>';
        body_add +='                    <?php  if($name_title=="Mrs."){ ?>';
        body_add +='                        <option value="Mrs." selected>Mrs.</option>';
        body_add +='                    <?php }else{ ?>';
        body_add +='                        <option value="Mrs." >Mrs.</option>';
        body_add +='                    <?php } ?>';
        body_add +='                </select>';    
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='        </div>';
        body_add +='        <div class="col" >';
        body_add +='        </div>';
        body_add +='    </div>';
        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" ><small><font color="red">*</font></small>First name:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="first_co" name="first_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" ><small><font color="red">*</font></small>Mobile:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="mobile_co'+input_value+'" name="mobile_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>';
        body_add +='        </div>';
        body_add +='    </div>';

        body_add +='<script>';
        body_add +='document.getElementById("mobile_co'+input_value+'").addEventListener("input", function (e) {';
        body_add +='    var x = e.target.value.replace(/'+'\\D/'+'g,'+"''"+').match(/'+'(\\d{0,3})(\\d{0,3})(\\d{0,4})/'+');';
        body_add +='    e.target.value = !x[2] ? x[1] : x[1] + '+"'-'"+' + x[2] + (x[3] ? '+"'-'"+' + x[3] : '+"''"+');';
        body_add +='});';
        body_add +='</'+'script>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" ><small><font color="red">*</font></small>Last name:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="last_co" name="last_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" >Tel:</label>';
        body_add +='        </div>  ';
        body_add +='        <div class="col">';
        body_add +='            <input id="tel_co" name="tel_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';
        body_add +='    </div>';
        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Nickname:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="nick_co" name="nick_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='           <label style="color: #102958;" ><small><font color="red">*</font></small>Email:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="email_co" name="email_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>';
        body_add +='       </div>';
        body_add +='    </div>';
        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='       <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" ><small><font color="red">*</font></small>Position:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="position_co" name="position_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" ><small><font color="red">*</font></small>Line ID:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="line_co" name="line_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>';
        body_add +='        </div>';
        body_add +='    </div>';
        body_add +='     <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Remark:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="remark_co" name="remark_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';

        body_add +='<div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" ><small><font color="red">*</font></small>Department:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col " class="form-control" >';
        body_add +='            <input id="department" name="department[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>';
        body_add +='</div>';

        body_add +='    </div>';

        body_add +='     <div class="form-group row col-md-10 col-md-offset-1">';
         body_add +='        <div class="col-sm-6" >';
        body_add +='<input hidden="true" id="default_co_id" name="default_co_id[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="default_id:'+input_value+'" >';
        body_add +='            <input id="default_co'+input_value+'" name="default_co[]" class="form-check-input" type="radio" value="default_id:'+input_value+'" id="flexCheckDefault" >';
        body_add +='            <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">';
        body_add +='                &nbsp;&nbsp;&nbsp;&nbsp; Default Contact';
        body_add +='            </label>';
        body_add +='        </div>';
        body_add +='    </div>';


        body_add +='    </div>';
        body_add +='</div>';
        body_add +='</div>';                             
        body_add +='</div>';
        body_add +='</div>';
        

        // alert('End field_contact');

        $('#field_contact').append(body_add);
    });


	$(document).on('click', '.btn_remove_con', function() {
            input_contact--;
            var button_id = $(this).attr("id");
            var get_status = document.getElementById('default_co'+button_id+'').checked;
            if(get_status==true){
                document.getElementById('default_co'+button_id+'').checked;
                document.getElementById('default_co').checked = true;  
            }
            $('#row-con' + button_id + '').remove();
        });

</script>

<script type="text/javascript">
    function same_contact(item) {
        var body_add ='';
        body_add +='<div id="row-con'+input_value+'" class="container-fluid">';
        body_add +='<div class="row">';
        body_add +='    <div class="col-md-12 ">';
        body_add +='        <div class="panel">';
        body_add +='            <div class="panel-heading">';
        body_add +='            <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='                <div class="col">';
        body_add +='                    <div class="panel-title" style="color: #102958;" >';
        // body_add +='                        <h2 class="title">Contact Person '+input_value+'</h2>';
        body_add +='                        <h2 class="title">Contact Person</h2>';
        body_add +='                    </div>';
        body_add +='                </div>';
        body_add +='<div class="col">';
        body_add +='</div>  ';
        body_add +='                <div class="col text-right">';
        body_add +='<button type="button" class="btn btn_remove_con" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ input_value +'">X</button>';
        body_add +='                </div>&nbsp;&nbsp;';
        body_add +='                </div>';
        body_add +='            </div>';
        body_add +='<div class="panel-body">';

        body_add +='<input id="rela_contact" name="rela_contact[]" value="'+item.id+'" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  hidden="true">';

        body_add +='    <div class="form-group row mb-20 col-md-10 col-md-offset-1">';
        body_add +='<input id="id_co" name="id_co[]" value="'+item.id+'" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  hidden="true">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Title Name:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <select id="title_co" name="title_co[]" style="color: #4590B8;border-color:#102958;" class="form-control" >';

        if(item.title_name=="Mr."){
            body_add +='                        <option value="Mr." selected>Mr.</option>';
        }else{
            body_add +='                        <option value="Mr." >Mr.</option>';
        }
        if(item.title_name=="Ms."){
            body_add +='                        <option value="Ms." selected>Ms.</option>';
        }else{
            body_add +='                        <option value="Ms." >Ms.</option>';
        }
        if(item.title_name=="Mrs."){
            body_add +='                        <option value="Mrs." selected>Mrs.</option>';
        }else{
            body_add +='                        <option value="Mrs." >Mrs.</option>';
        }

        // body_add +='                    <?php  if(item.title_name=="Mr."){ ?>';
        // body_add +='                        <option value="Mr." selected>Mr.</option>';
        // body_add +='                    <?php }else{ ?>';
        // body_add +='                        <option value="Mr." >Mr.</option>';
        // body_add +='                    <?php } ?>';
        // body_add +='                    <?php  if(item.title_name=="Ms."){ ?>';
        // body_add +='                        <option value="Ms." selected>Ms.</option>';
        // body_add +='                    <?php }else{ ?>';
        // body_add +='                        <option value="Ms." >Ms.</option>';
        // body_add +='                    <?php } ?>';
        // body_add +='                    <?php  if(item.title_name=="Mrs."){ ?>';
        // body_add +='                        <option value="Mrs." selected>Mrs.</option>';
        // body_add +='                    <?php }else{ ?>';
        // body_add +='                        <option value="Mrs." >Mrs.</option>';
        // body_add +='                    <?php } ?>';

        body_add +='                </select>';    
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='        </div>';
        body_add +='        <div class="col" >';
        body_add +='        </div>';
        body_add +='    </div>';
        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >First name:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="first_co" name="first_co[]" value="'+item.first_name+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" >Mobile:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="mobile_co'+input_value+'" name="mobile_co[]" value="'+item.mobile+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >';
        body_add +='        </div>';
        body_add +='    </div>';

        body_add +='<script>';
        body_add +='document.getElementById("mobile_co'+input_value+'").addEventListener("input", function (e) {';
        body_add +='    var x = e.target.value.replace(/'+'\\D/'+'g,'+"''"+').match(/'+'(\\d{0,3})(\\d{0,3})(\\d{0,4})/'+');';
        body_add +='    e.target.value = !x[2] ? x[1] : x[1] + '+"'-'"+' + x[2] + (x[3] ? '+"'-'"+' + x[3] : '+"''"+');';
        body_add +='});';
        body_add +='</'+'script>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Last name:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="last_co" name="last_co[]" value="'+item.last_name+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" >Tel:</label>';
        body_add +='        </div>  ';
        body_add +='        <div class="col">';
        body_add +='            <input id="tel_co" name="tel_co[]" value="'+item.tel+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';
        body_add +='    </div>';
        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Nickname:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="nick_co" name="nick_co[]" value="'+item.nick_name+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='           <label style="color: #102958;" >Email:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="email_co" name="email_co[]" value="'+item.email+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='       </div>';
        body_add +='    </div>';
        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='       <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Position:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="position_co" name="position_co[]" value="'+item.position+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" >Line ID:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="line_co" name="line_co[]" value="'+item.line_id+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';
        body_add +='    </div>';
        body_add +='     <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Remark:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="remark_co" name="remark_co[]" value="'+item.remark+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';

        body_add +='<div class="col-sm-2 label_right" >';
        body_add +='            <label style="color: #102958;" >Department:</label>';
        body_add +='       </div>';
        body_add +='        <div class="col " class="form-control" >';
        body_add +='            <input id="department" name="department[]" value="'+item.department+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';

        body_add +='    </div>';

        body_add +='     <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-6 " >';
        body_add +='<input hidden="true" id="default_co_id" name="default_co_id[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" value="default_id:'+input_value+'" >';
        var value = item.default_contact;
        if(value=="0"){
        body_add +='       <input id="default_co'+input_value+'" name="default_co[]" class="form-check-input" type="radio"  id="flexCheckDefault" value="default_id:'+input_value+'" >';
        }else{
        body_add +='       <input id="default_co'+input_value+'" name="default_co[]" class="form-check-input" type="radio"  id="flexCheckDefault" value="default_id:'+input_value+'" checked>';
        }

        body_add +='            <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">';
        body_add +='                &nbsp;&nbsp;&nbsp;&nbsp; Default Contact';
        body_add +='            </label>';
        body_add +='        </div>'; 
        body_add +='    </div>';

        body_add +='    </div>';
        body_add +='</div>';
        body_add +='</div>';                             
        body_add +='</div>';
        body_add +='</div>';

        $('#field_contact').append(body_add);

        return item;
     }

</script>