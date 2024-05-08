<script>

    $(document).ready(function() {
        // alert('ready');
        var id_customer_input = document.getElementById("id_customer_input").value;

        if(id_customer_input != ""){

        // alert('id_customer_input:'+id_customer_input);
        $.get('get_customer.php?id=' + id_customer_input, function(data){

        var result = JSON.parse(data);
       
        $.each(result, function(index, item){

        // document.getElementById("id_customer_input").value =customer_id;
        // alert('item.customer_name:'+item.customer_name);

        if(item.customer_type=="Personal"){
            document.getElementById("name_c_input").value = item.customer_name;
        }else{
            document.getElementById("name_c_input").value = item.company_name;
        }

        document.getElementById("type_c_input").value = item.customer_type;

        document.getElementById("customer_c_input").value = item.customer_id;
        document.getElementById("level_c_input").value = item.customer_level;
        document.getElementById("customer_de").value = item.description;

        document.getElementById("title_c_input").value = item.title_name;
        document.getElementById("first_c_input").value = item.first_name;
        document.getElementById("last_c_input").value = item.last_name;
        document.getElementById("nick_c_input").value = item.nick_name;

        document.getElementById("mobile_c_input").value = item.mobile;

        document.getElementById("personal_c_input").value = item.tax_id;


        // document.getElementById("company_c_input").value = item.company_name;
        
        document.getElementById("tel_c_input").value = item.tel;
        document.getElementById("tel_c_input2").value = item.tel;
        document.getElementById("email_c_input").value = item.email;

        document.getElementById("address_input").value = item.address_number;
        document.getElementById("building_input").value = item.building_name;
        document.getElementById("soi_input").value = item.soi;
        document.getElementById("road_input").value = item.road;

        // if(status==1){
        //     document.getElementById("status_c_input").checked = true;
        // }else{
        //     document.getElementById("status_c_input").checked = false;
        // }

/////////////////////////////////////////////////
        var provinceObject = $('#province');
        var districtObject = $('#district');
        var sub_districtObject = $('#sub_district');
        var postcodeObject = $('#postcode');

    if(item.province!=""){
        $.get('get_province_id.php?code_id=' + item.province, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                document.getElementById("province").value=item.code;
            });
            $("#province").selectpicker('refresh');
        });
    }else{
        document.getElementById("province").value="0";
        $("#province").selectpicker('refresh');
    }

    if(item.district!=""){
        $.get('get_district_id.php?code_id=' + item.district, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                districtObject.html('<option value="'+item.code+'">'+item.name_en+'</option>')
            });
            $("#district").selectpicker('refresh');
        });
    }else{
        districtObject.html('<option value="0">Choose a district</option>');
        $("#district").selectpicker('refresh');
    }

    if(item.sub_district!=""){
        $.get('get_sub_district_id.php?code_id=' + item.sub_district, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                sub_districtObject.html('<option value="'+item.code+'">'+item.name_en+'</option>')
            });
            $("#sub_district").selectpicker('refresh');
        });
    }else{
        sub_districtObject.html('<option value="0">Choose a sub-district</option>');
        $("#sub_district").selectpicker('refresh');
    }

    if(item.post_code!=""){
        postcodeObject.html('<option value="'+item.post_code+'">'+item.post_code+'</option>');
        $("#postcode").selectpicker('refresh');
    }else{
        postcodeObject.html('<option value="0">Choose a post code</option>');
        $("#postcode").selectpicker('refresh');
    }
        ClickChange_personal();
        });
        // alert('End checked');
    });

        
        contact_person_hidden();
        
        // alert('id_customer_input:'+id_customer_input);
        $.get('get_contact.php?id=' + id_customer_input, function(data){
        var result = JSON.parse(data);
        if(result!=""){
            // alert('result value:');
            document.getElementById("same_co").checked = true; 
            document.getElementById("same_co").value = "true";
            value = "true";
        }else{
            document.getElementById("same_co").checked = false; 
            document.getElementById("same_co").value = "false";
            value = "fale";
            removelist_contact();

            document.getElementById('same_co').removeAttribute("disabled");
            document.getElementById('title_co').removeAttribute("disabled");
            document.getElementById('default_co').removeAttribute("disabled");
            document.getElementById("default_co").checked = true;
            for (var i = 0; i < input_contact_array.length; i++){
                document.getElementById(input_contact_array[i]).readOnly = false;
                document.getElementById(input_contact_array[i]).value = "";
            }
        }
            if (value == "true") {
                document.getElementById("same_co").value="false";
                removelist_contact();
                same_customer();
            }
        });
        
        }
    });

    var input_customer = ["name_c_input", "customer_c_input", "nick_c_input", "status_c_input","mobile_c_input"
        ,"personal_c_input","tel_c_input","tel_c_input2","email_c_input","address_input"
        ,"building_input","soi_input","road_input","first_c_input","last_c_input"
        ,"company_c_input"];

    var input_contact_array = ["first_co","mobile_co","last_co","tel_co","nick_co"
        ,"email_co","position_co","line_co","remark_co","department"];

 // for (var i = 0; i < input_customer.length; i++){}
// $(document).ready(function() {
        var i=0; 
        var input_value=0;

        var input_contact = 0;

    function removelist_contact() {
        input_contact=0;
        for (let i = 0; i <= input_value; i++) {
            $('#row-con' + i + '').remove();
        }
    }

    function same_customer() {
         var input_customer = ["name_c_input", "customer_c_input", "nick_c_input", "status_c_input","mobile_c_input"
        ,"personal_c_input","tel_c_input","tel_c_input2","email_c_input","address_input"
        ,"building_input","soi_input","road_input","first_c_input","last_c_input"
        ,"company_c_input"];

    var input_contact_array = ["first_co","mobile_co","last_co","tel_co","nick_co"
        ,"email_co","position_co","line_co","remark_co","department"];

        // document.getElementById('default_co').readOnly = true;
        var value = document.getElementById("same_co").value;
        var customer_id = document.getElementById("id_customer_input").value;
        var default_contact = document.getElementById("id_default_contact").value;
        // alert('default_contact:'+default_contact);

        // if(value=="false"){
            var start="true";
            if (customer_id != "") {
            
                    // $.get('get_contact.php?id=' + customer_id, function(data){
                $.get('get_contact_for_rela_default.php?id=' + default_contact, function(data){
                    var result = JSON.parse(data);
                    if(result!=""){
                    $.each(result, function(index, item){
                        if(start=="true"){
                            input_contact=0;
                            for (let i = 0; i <= input_value; i++) {
                                $('#row-con' + i + '').remove();
                            }
            document.getElementById('title_co').setAttribute("disabled","disabled");
            document.getElementById('default_co').setAttribute("disabled","disabled");
            document.getElementById('first_co').readOnly = true;
            document.getElementById('mobile_co').readOnly = true;
            document.getElementById('last_co').readOnly = true;
            document.getElementById('tel_co').readOnly = true;
            document.getElementById('nick_co').readOnly = true;
            document.getElementById('email_co').readOnly = true;
            document.getElementById('position_co').readOnly = true;
            document.getElementById('line_co').readOnly = true;
            document.getElementById('remark_co').readOnly = true;
            document.getElementById('department').readOnly = true;

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

                            if(item.default_contact=="0"){
                                document.getElementById("default_co").checked = false; 
                            }else{
                                document.getElementById("default_co").checked = true; 
                            }
                        //     document.getElementById('same_co').readOnly = false;
                        document.getElementById("same_co").setAttribute("disabled","disabled");
                        // document.getElementById("same_co").value="false";

                            start="false";
                        }else{
                            input_value++;
                            input_contact++;
                            // same_contact(item);
                             
                        }
                    });
                 }else{ //if(result!=""){

            document.getElementById('title_co').removeAttribute("disabled");
            document.getElementById('default_co').removeAttribute("disabled");
            for (var i = 0; i < input_contact_array.length; i++){
                document.getElementById(input_contact_array[i]).readOnly = false;
            }
            

                        document.getElementById("default_co").checked = true;

                        // document.getElementById('same_co').readOnly = false;
                        // document.getElementById("same_co").checked = false; 
                        // document.getElementById("same_co").value="false";

                        if(document.getElementById("title_c_input").value==""){
                            document.getElementById("title_co").value   ="Mr.";
                        }
                        // document.getElementById("title_co").value   = document.getElementById("title_c_input").value;
                        document.getElementById("first_co").value   = document.getElementById("first_c_input").value;
                        document.getElementById("last_co").value    = document.getElementById("last_c_input").value;
                        document.getElementById("nick_co").value    = document.getElementById("nick_c_input").value;
                        document.getElementById('mobile_co').value  = document.getElementById("mobile_c_input").value;

                        if(document.getElementById("type_c_input").value=="Personal"){
                            document.getElementById('tel_co').value     = document.getElementById("tel_c_input2").value;
                        }else{
                            document.getElementById('tel_co').value     = document.getElementById("tel_c_input").value;
                        }

                        document.getElementById('email_co').value   = document.getElementById("email_c_input").value;

                        document.getElementById('position_co').value = "";
                        document.getElementById('line_co').value = "";
                        document.getElementById('remark_co').value = "";
                        document.getElementById('department').value = "";

                            if(item.default_contact=="0"){
                                document.getElementById("default_co").checked = false; 
                            }else{
                                document.getElementById("default_co").checked = true; 
                            }

                        // start="true";

                    }

                });

            }else{
                document.getElementById("id_customer_input").value="";
                document.getElementById("title_co").value   = document.getElementById("title_c_input").value;
                document.getElementById("first_co").value   = document.getElementById("first_c_input").value;
                        document.getElementById("last_co").value    = document.getElementById("last_c_input").value;
                        document.getElementById("nick_co").value    = document.getElementById("nick_c_input").value;
                        document.getElementById('mobile_co').value  = document.getElementById("mobile_c_input").value;
                        if(document.getElementById("type_c_input").value=="Personal"){
                            document.getElementById('tel_co').value     = document.getElementById("tel_c_input2").value;
                        }else{
                            document.getElementById('tel_co').value     = document.getElementById("tel_c_input").value;
                        }
                        document.getElementById('email_co').value   = document.getElementById("email_c_input").value;

            }
       
            // document.getElementById("same_co").value="true";
        // }else{
        //     document.getElementById('title_co').removeAttribute("disabled");
        //     document.getElementById('default_co').removeAttribute("disabled");

        //     for (var i = 0; i < input_contact_array.length; i++){
        //         document.getElementById(input_contact_array[i]).readOnly = false;
        //         document.getElementById(input_contact_array[i]).value = "";
        //     }

        //     document.getElementById("title_co").value = "Mr."
        //     document.getElementById("same_co").value="false";
        //     document.getElementById("default_co").checked = true;
        //     document.getElementById("id_co").value = "";

        //     // alert('Check :'+input_value);
        //     for (let i = 0; i <= input_value; i++) {
        //         input_contact=0;
        //         $('#row-con' + i + '').remove();
        //     }
        // }

    }


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
        // body_add +='<button type="button" class="btn btn_remove_con" name="remove" style="background-color: #0275d8;color: #F9FAFA;" id="'+ input_value +'">X</button>';
        body_add +='                </div>&nbsp;&nbsp;';
        body_add +='                </div>';
        body_add +='            </div>';
        body_add +='<div class="panel-body">';
        body_add +='    <div class="form-group row mb-20 col-md-10 col-md-offset-1">';
        body_add +='<input id="id_co" name="id_co[]" value="'+item.id+'" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  hidden="true">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" for="staticEmail" >Title:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2">';
        body_add +='            <select id="title_co" name="title_co[]" style="border-color:#102958;" class="form-control" disabled="true">';
        body_add +='                    <?php  if(item.title_name=="Mr."){ ?>';
        body_add +='                        <option value="Mr." selected>Mr.</option>';
        body_add +='                    <?php }else{ ?>';
        body_add +='                        <option value="Mr." >Mr.</option>';
        body_add +='                    <?php } ?>';
        body_add +='                    <?php  if(item.title_name=="Ms."){ ?>';
        body_add +='                        <option value="Ms." selected>Ms.</option>';
        body_add +='                    <?php }else{ ?>';
        body_add +='                        <option value="Ms." >Ms.</option>';
        body_add +='                    <?php } ?>';
        body_add +='                    <?php  if(item.title_name=="Mrs."){ ?>';
        body_add +='                        <option value="Mrs." selected>Mrs.</option>';
        body_add +='                    <?php }else{ ?>';
        body_add +='                        <option value="Mrs." >Mrs.</option>';
        body_add +='                    <?php } ?>';
        body_add +='                </select>';    
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='        </div>';
        body_add +='        <div class="col" >';
        body_add +='        </div>';
        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >First name:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="first_co" name="first_co[]" value="'+item.first_name+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" disabled="true" >';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" ><small><font color="red">*</font></small>Last name:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="last_co" name="last_co[]" value="'+item.last_name+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" disabled="true" >';
        body_add +='        </div>';

        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Nickname:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="nick_co" name="nick_co[]" value="'+item.nick_name+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" disabled="true" >';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='           <label style="color: #102958;" >Email:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="email_co" name="email_co[]" value="'+item.email+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" disabled="true" >';
        body_add +='       </div>';
        
        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Mobile:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="mobile_co" name="mobile_co[]" value="'+item.mobile+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" disabled="true" >';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Tel:</label>';
        body_add +='        </div>  ';
        body_add +='        <div class="col">';
        body_add +='            <input id="tel_co" name="tel_co[]" value="'+item.tel+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"disabled="true"  >';
        body_add +='        </div>';

        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Line ID:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="line_co" name="line_co[]" value="'+item.line_id+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" disabled="true" >';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='        </div>';

        body_add +='    </div>';

        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='       <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Position:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="position_co" name="position_co[]" value="'+item.position+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" disabled="true" >';
        body_add +='        </div>';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Department:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="department" name="department[]" value="'+item.department+'" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" disabled="true" >';
        body_add +='        </div>';

        body_add +='    </div>';

        body_add +='     <div class="form-group row col-md-10 col-md-offset-1">';

        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Remark:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <textarea id="remark_co" name="remark_co[]" value="'+item.remark+'" minlength="1" maxlength="255" style="color: #0C1830;border-color:#102958;" class="form-control" disabled="true" rows="2"></textarea>';
        body_add +='        </div>';
          
        body_add +='    </div>';

        body_add +='     <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-4 " >';

        var value = item.default_contact;
        // alert('default_contact:'+item.default_contact);
        if(value=="0"){
        body_add +='            <input id="default_co'+input_value+'" name="default_co[]" class="form-check-input" disabled="true" type="radio" value="'+input_value+'" id="flexCheckDefault" >';
        }else{
        body_add +='            <input id="default_co'+input_value+'" name="default_co[]" class="form-check-input" disabled="true" type="radio" value="'+input_value+'" id="flexCheckDefault" checked>';
        }


        body_add +='            <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">';
        body_add +='                &nbsp;&nbsp;&nbsp;&nbsp; Default Contact';
        body_add +='            </label>';
        body_add +='        </div>';
        body_add +='     </div>';



        body_add +='    </div>';
        body_add +='</div>';
        body_add +='</div>';                             
        body_add +='</div>';
        body_add +='</div>';

        $('#field_contact').append(body_add);

        return item;
     }


    $('#add-con').click(function() {
        
            input_contact++;
            // alert('Check :'+input_value);
            var inputs = $('input');
            // alert('not checked');
            // alert('value'+inputs.length);

            // 42=2/48=3/54=4/60=5
            // if(inputs.length >= 75) {
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
        body_add +='                <div class="col text-right">';
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
        body_add +='            <select id="title_co" name="title_co[]" style="border-color:#102958;" class="form-control">';
        
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
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='        </div>';
        body_add +='        <div class="col" >';
        body_add +='        </div>';
        body_add +='    </div>';
        
        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >First name:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="first_co" name="first_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" ><small><font color="red">*</font></small>Mobile:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="mobile_co'+input_value+'" name="mobile_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" required>';
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
        body_add +='            <input id="last_co" name="last_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" required>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_left" >';
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
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='           <label style="color: #102958;" ><small><font color="red">*</font></small>Email:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="email_co" name="email_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" required>';
        body_add +='       </div>';
        body_add +='    </div>';
        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='       <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" ><small><font color="red">*</font></small>Position:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="position_co" name="position_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" required>';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Line ID:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="line_co" name="line_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control" >';
        body_add +='        </div>';
        body_add +='    </div>';
        body_add +='    <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='            <label style="color: #102958;" >Remark:</label>';
        body_add +='        </div>';
        body_add +='        <div class="col">';
        body_add +='            <input id="remark_co" name="remark_co[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  >';
        body_add +='        </div>';

        body_add +='<div class="col-sm-2 label_left" >';
        body_add +='    <label style="color: #102958;" ><small><font color="red">*</font></small>Department:</label>';
        body_add +='</div>';
        body_add +='        <div class="col " class="form-control" >';
        body_add +='            <input id="department" name="department[]" minlength="1" maxlength="50" style="color: #0C1830;border-color:#102958;" type="text" class="form-control"  required>';
        body_add +='        </div>';

        body_add +='    </div>';


        body_add +='     <div class="form-group row col-md-10 col-md-offset-1">';
        body_add +='        <div class="col-sm-2 label_left" >';
        body_add +='        </div>';
        body_add +='        <div class="col-sm-4" >';
        
        var value = document.getElementById("same_co").value;
        if(value=="false"){
        body_add +='            <input id="default_co'+input_value+'" name="default_co[]" class="form-check-input" type="radio" value="'+input_value+'" id="flexCheckDefault" >';
        }else{
        body_add +='            <input id="default_co'+input_value+'" name="default_co[]" class="form-check-input" disabled="true" type="radio" value="'+input_value+'" id="flexCheckDefault" >';
        }


        body_add +='            <label style="color: #102958;" class="form-check-label" for="flexCheckDefault">';
        body_add +='                &nbsp;&nbsp;&nbsp;&nbsp; Default Contact';
        body_add +='            </label>';
        body_add +='        </div>';
        body_add +='     </div>';


        body_add +='    </div>';
        body_add +='</div>';
        body_add +='</div>';                             
        body_add +='</div>';
        body_add +='</div>';

        $('#field_contact').append(body_add);
    });

        $(document).on('click', '.btn_remove_con', function() {
            input_contact--;
            var button_id = $(this).attr("id");
            // document.getElementById('default_co'+input_value+'').value="false";
            // var get_status = document.getElementById('default_co'+input_value+'').value;
            var get_status = document.getElementById('default_co'+button_id+'').checked;
            // alert('get_status:'+get_status+' input_value:'+button_id);
            if(get_status==true){
                document.getElementById('default_co'+button_id+'').checked;
                document.getElementById('default_co').checked = true;  
            }
            $('#row-con' + button_id + '').remove();
        });
    // });
    
    function clear_customer() {
        input_contact=0;
        document.getElementById("id_customer_input").value="";
        // document.getElementById('type_c_input').removeAttribute("disabled");
        // document.getElementById('status_c_input').removeAttribute("disabled");
        // document.getElementById('same_co').removeAttribute("disabled");

        for (var i = 0; i < input_customer.length; i++){
            // document.getElementById(input_customer[i]).readOnly = false;
            document.getElementById(input_customer[i]).value ="";
        }

        // document.getElementById('province').removeAttribute("disabled");
        // document.getElementById('district').removeAttribute("disabled");
        // document.getElementById('sub_district').removeAttribute("disabled");
        // document.getElementById('postcode').removeAttribute("disabled");

        // document.getElementById('level_c_input').removeAttribute("disabled");
        // document.getElementById('title_c_input').removeAttribute("disabled");

        document.getElementById("type_c_input").value = "Personal";


        // document.getElementById("same_co").checked = false;
        document.getElementById("same_co").value="false";

        // document.getElementById('title_co').removeAttribute("disabled");
        // document.getElementById('default_co').removeAttribute("disabled");
        // document.getElementById("default_co").checked = true;

            // document.getElementById('first_co').readOnly = false;
            // document.getElementById('mobile_co').readOnly = false;
            // document.getElementById('last_co').readOnly = false;
            // document.getElementById('tel_co').readOnly = false;
            // document.getElementById('nick_co').readOnly = false;
            // document.getElementById('email_co').readOnly = false;
            // document.getElementById('position_co').readOnly = false;
            // document.getElementById('line_co').readOnly = false;
            // document.getElementById('remark_co').readOnly = false;
            // document.getElementById('department').readOnly = false;
            

        document.getElementById("title_co").value = "Mr."
        document.getElementById('level_c_input').value = "0";
        document.getElementById('customer_de').value = "";
        document.getElementById('title_c_input').value = "Mr.";

        document.getElementById("first_co").value = "";
        document.getElementById("last_co").value = "";
        document.getElementById("nick_co").value = "";

        document.getElementById('mobile_co').value = "";
        document.getElementById('tel_co').value = "";
        document.getElementById('email_co').value = "";

        document.getElementById('position_co').value = "";
        document.getElementById('line_co').value = "";
        document.getElementById('remark_co').value = "";
        document.getElementById('department').value = "";

        document.getElementById('province').value = "";

        
        document.getElementById('first_c_input').value = "";
        document.getElementById('last_c_input').value = "";

        var districtObject = $('#district');
        var sub_districtObject = $('#sub_district');
        var postcodeObject = $('#postcode');
        districtObject.html('<option value="0">Choose a district</option>');
        sub_districtObject.html('<option value="0">Choose a sub-district</option>');
        postcodeObject.html('<option value="0">Choose a post code</option>');

        $("#province").selectpicker('refresh');
        $("#district").selectpicker('refresh');
        $("#sub_district").selectpicker('refresh');
        $("#postcode").selectpicker('refresh');

        input_contact=0;
        for (let i = 0; i <= input_value; i++) {
                $('#row-con' + i + '').remove();
        }
        ClickChange_personal();
    }

    function contact_person_hidden() {
        document.getElementById('name_c_input').readOnly = true;
        document.getElementById('type_c_input').setAttribute("disabled","disabled");
        document.getElementById('customer_c_input').readOnly = true;

        document.getElementById('nick_c_input').readOnly = true;
        document.getElementById('status_c_input').setAttribute("disabled","disabled");

        document.getElementById('mobile_c_input').readOnly = true;
        document.getElementById('personal_c_input').readOnly = true;
        document.getElementById('tel_c_input').readOnly = true;
        document.getElementById('tel_c_input2').readOnly = true;

        document.getElementById('email_c_input').readOnly = true;

        document.getElementById('address_input').readOnly = true;
        document.getElementById('building_input').readOnly = true;
        document.getElementById('soi_input').readOnly = true;
        document.getElementById('road_input').readOnly = true;

        document.getElementById('province').setAttribute("disabled","disabled");
        document.getElementById('district').setAttribute("disabled","disabled");
        document.getElementById('sub_district').setAttribute("disabled","disabled");
        document.getElementById('postcode').setAttribute("disabled","disabled");

        document.getElementById('level_c_input').setAttribute("disabled","disabled");
        document.getElementById('title_c_input').setAttribute("disabled","disabled");
        document.getElementById('first_c_input').readOnly = true;
        document.getElementById('last_c_input').readOnly = true;

        document.getElementById('company_c_input').readOnly = true;
    }

    $(document).on('click','.editAction_contact', function () {
        var customer_id = $(this).closest("tr").find(".customer_id_c").text();
        document.getElementById("id_co").value = $(this).closest("tr").find(".id_c").text();
        document.getElementById("title_co").value = $(this).closest("tr").find(".title_name_c").text();
        document.getElementById("first_co").value = $(this).closest("tr").find(".first_name_c").text();
        document.getElementById("last_co").value = $(this).closest("tr").find(".last_name_c").text();
        document.getElementById("nick_co").value = $(this).closest("tr").find(".nick_name_c").text();

        document.getElementById('mobile_co').value = $(this).closest("tr").find(".mobile_c").text();
        document.getElementById('tel_co').value = $(this).closest("tr").find(".tel_c").text();
        document.getElementById('email_co').value = $(this).closest("tr").find(".email_c").text();

        document.getElementById('position_co').value = $(this).closest("tr").find(".position_c").text();
        document.getElementById('line_co').value = $(this).closest("tr").find(".line_id_c").text();
        document.getElementById('remark_co').value = $(this).closest("tr").find(".remark_c").text();
        document.getElementById('department').value = $(this).closest("tr").find(".department_c").text();

        if($(this).closest("tr").find(".default_contact_c").text()=="0"){
            document.getElementById("default_co").checked = false; 
        }else{
            document.getElementById("default_co").checked = true; 
        }
        $('#ModalContact').modal('hide');
    });

    $(document).on('click','.editAction', function () {
        var customer_id = $(this).closest("tr").find(".customer_id_c").text();

        // alert('start:'+customer_id);
        var modalUrl = 'model_contact.php?id_customer=' + customer_id;
        // $('#ModalContact').modal('show');
        // โหลดเนื้อหาใหม่ของโมดัลด้วย URL ใหม่
        // $('#ModalContact .modal-content').load(modalUrl);
        $('#ModalContact .table_contact').load(modalUrl);
        // $('#table_contact .modal-content').load(modalUrl);
        // alert('modalUrl:'+modalUrl);

        var name = $(this).closest("tr").find(".name_c").text();
        var type = $(this).closest("tr").find(".type_c").text();
        var id = $(this).closest("tr").find(".id_c").text();
        var nick = $(this).closest("tr").find(".nick_c").text();
        var status = $(this).closest("tr").find(".status_c").text();

        var mobile = $(this).closest("tr").find(".mobile_c").text();
        var personal = $(this).closest("tr").find(".personal_c").text();
        var tel = $(this).closest("tr").find(".tel_c").text();
        var email = $(this).closest("tr").find(".email_c").text();

        var address = $(this).closest("tr").find(".address_c").text();
        var building = $(this).closest("tr").find(".building_c").text();
        var soi = $(this).closest("tr").find(".soi_c").text();
        var road = $(this).closest("tr").find(".road_c").text();

        var province = $(this).closest("tr").find(".province_c").text();
        var district = $(this).closest("tr").find(".district_c").text();
        var sub_district = $(this).closest("tr").find(".sub_district_c").text();
        var postcode = $(this).closest("tr").find(".post_code_c").text();

        var title_name = $(this).closest("tr").find(".title_id_c").text();
        var first_name = $(this).closest("tr").find(".first_id_c").text();
        var last_name = $(this).closest("tr").find(".last_id_c").text();
        var customer_level = $(this).closest("tr").find(".customer_level_c").text();
        var customer_name = $(this).closest("tr").find(".customer_name").text();
        var tax_id = $(this).closest("tr").find(".tax_id").text();

        var description = $(this).closest("tr").find(".description").text();
        // document.getElementById('customer_c_input').setAttribute("disabled","disabled");
      
        contact_person_hidden();

        document.getElementById("id_default_contact").value = $(this).closest("tr").find(".id_con").text();

        document.getElementById("id_customer_input").value =customer_id;
        document.getElementById("name_c_input").value = name;

        document.getElementById("type_c_input").value = type;

        ClickChange_personal();

        document.getElementById("customer_c_input").value = id;
        document.getElementById("nick_c_input").value = nick;
        if(status==1){
            document.getElementById("status_c_input").checked = true;
        }else{
            document.getElementById("status_c_input").checked = false;
        }

        document.getElementById("mobile_c_input").value = mobile;
        document.getElementById("personal_c_input").value = personal;
        document.getElementById("tel_c_input").value = tel;
        document.getElementById("tel_c_input2").value = tel;
        document.getElementById("email_c_input").value = email;

        document.getElementById("address_input").value = address;
        document.getElementById("building_input").value = building;
        document.getElementById("soi_input").value = soi;
        document.getElementById("road_input").value = road;

        document.getElementById("level_c_input").value = customer_level;
        document.getElementById("customer_de").value = description;

        document.getElementById("title_c_input").value = title_name;
        document.getElementById("first_c_input").value = first_name;
        document.getElementById("last_c_input").value = last_name;

        document.getElementById("company_c_input").value = customer_name;
        

        var provinceObject = $('#province');
        var districtObject = $('#district');
        var sub_districtObject = $('#sub_district');
        var postcodeObject = $('#postcode');

    if(province!=""){
        $.get('get_province_id.php?code_id=' + province, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                document.getElementById("province").value=item.code;
            });
            $("#province").selectpicker('refresh');
        });
    }else{
        document.getElementById("province").value="0";
        $("#province").selectpicker('refresh');
    }

    if(district!=""){
        $.get('get_district_id.php?code_id=' + district, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                districtObject.html('<option value="'+item.code+'">'+item.name_en+'</option>')
            });
            $("#district").selectpicker('refresh');
        });
    }else{
        districtObject.html('<option value="0">Choose a district</option>');
        $("#district").selectpicker('refresh');
    }

    if(sub_district!=""){
        $.get('get_sub_district_id.php?code_id=' + sub_district, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                sub_districtObject.html('<option value="'+item.code+'">'+item.name_en+'</option>')
            });
            $("#sub_district").selectpicker('refresh');
        });
    }else{
        sub_districtObject.html('<option value="0">Choose a sub-district</option>');
        $("#sub_district").selectpicker('refresh');
    }

    if(postcode!=""){
        postcodeObject.html('<option value="'+postcode+'">'+postcode+'</option>');
        $("#postcode").selectpicker('refresh');
    }else{
        postcodeObject.html('<option value="0">Choose a post code</option>');
        $("#postcode").selectpicker('refresh');
    }
        var value = document.getElementById("same_co").checked;
        var customer_id = document.getElementById("id_customer_input").value;
        
        $.get('get_contact.php?id=' + customer_id, function(data){
        var result = JSON.parse(data);
        if(result!=""){
            // alert('result value:');
            document.getElementById("same_co").checked = true; 
            document.getElementById("same_co").value = "true";
            value = "true";
        }else{
            document.getElementById("same_co").checked = false; 
            document.getElementById("same_co").value = "false";
            value = "fale";
            removelist_contact();

            document.getElementById('same_co').removeAttribute("disabled");
            document.getElementById('title_co').removeAttribute("disabled");
            document.getElementById('default_co').removeAttribute("disabled");
            document.getElementById("default_co").checked = true;
            for (var i = 0; i < input_contact_array.length; i++){
                document.getElementById(input_contact_array[i]).readOnly = false;
                document.getElementById(input_contact_array[i]).value = "";
            }
        }
            if (value == "true") {
                document.getElementById("same_co").value="false";
                removelist_contact();
                same_customer();
            }

        });
        $('#ModalCustomer').modal('hide');
    });

function ClickChange_personal() {
    var value_type = document.getElementById("type_c_input").value;
    // alert('value_type:'+value_type);
    if(value_type=="Corporate"){
        $('.corporate').show();
        $('.personal').hide();

                document.getElementById("title_input").hidden = true;
                document.getElementById("first_input").hidden = true;
                document.getElementById("last_input").hidden = true;
                document.getElementById("nick_input").hidden = true;

                document.getElementById("title_c_label").hidden = true;
                document.getElementById("first_c_label").hidden = true;
                document.getElementById("last_c_label").hidden = true;
                document.getElementById("nick_c_label").hidden = true;

                document.getElementById("div_personal").hidden = true;
                // document.getElementById("div_personal_tel").hidden = true;

                document.getElementById("div_corporate").hidden = false;
                document.getElementById("div_personal_tel_la").hidden = false;
                document.getElementById("div_personal_tel_in").hidden = false;

                document.getElementById("div_personal_e_per").hidden = true;
                document.getElementById("div_personal_e_cor").hidden = false;

                // document.getElementById("div_r_email_label").hidden = false;
                // document.getElementById("div_r_email_input").hidden = false;

                document.getElementById('first_c_input').removeAttribute('required');
                document.getElementById('last_c_input').removeAttribute('required');
                document.getElementById('company_c_input').setAttribute("required","required");

    }else{
        $('.corporate').hide();
        $('.personal').show();
        
                document.getElementById("title_input").hidden = false;
                document.getElementById("first_input").hidden = false;
                document.getElementById("last_input").hidden = false;
                document.getElementById("nick_input").hidden = false;

                document.getElementById("title_c_label").hidden = false;
                document.getElementById("first_c_label").hidden = false;
                document.getElementById("last_c_label").hidden = false;
                document.getElementById("nick_c_label").hidden = false;

                document.getElementById("div_personal_e_per").hidden = false;

                document.getElementById("div_personal").hidden = false;
                // document.getElementById("div_personal_tel").hidden = false;


                document.getElementById("div_corporate").hidden = true;
                document.getElementById("div_personal_tel_la").hidden = true;
                document.getElementById("div_personal_tel_in").hidden = true;

                
                document.getElementById("div_personal_e_cor").hidden = true;

                // document.getElementById("div_r_email_label").hidden = true;
                // document.getElementById("div_r_email_input").hidden = true;

                // document.getElementById("company_c_label").hidden = true;
                // document.getElementById("company_input").hidden = true;

                // document.getElementById('title_c_input').setAttribute("required","required");
                document.getElementById('first_c_input').setAttribute("required","required");
                document.getElementById('last_c_input').setAttribute("required","required");
                document.getElementById('company_c_input').removeAttribute('required');

        // alert('End ClickChange_personal');
    }
            // document.getElementById("demo").innerHTML = "You selected: " + x;

}
</script>