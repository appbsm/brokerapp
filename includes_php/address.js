
$(function(){
    var provinceObject = $('#province');
    var districtObject = $('#district');
    var sub_districtObject = $('#sub_district');
    var postcodeObject = $('#postcode');

    
    // on change province
    provinceObject.on('change', function(){
        var provinceId = $(this).val();
        // alert('Change provinceId:'+provinceId);
        districtObject.html('<option value="" >Select district</option>');
        sub_districtObject.html('<option value="" >Select sub-district</option>');
        postcodeObject.html('<option value="" >Select post code</option>');

        $.get('get_amphure.php?province_id=' + provinceId, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                districtObject.append(
                    $('<option></option>').val(item.code).html(item.name_en)
                );
                // $('.selectpicker').selectpicker('amphure');
            });
            $("#district").selectpicker('refresh');
        });

    });

    districtObject.on('change', function(){
        var amphureId = $(this).val();
        // alert('Change amphureId:'+amphureId);
        // districtObject.html('<option value="">เลือกตำบล</option>');
        sub_districtObject.html('<option value="" >Select sub-district</option>');
        postcodeObject.html('<option value="">Select post code</option>');
        
        $.get('get_district.php?amphure_id=' + amphureId, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                sub_districtObject.append(
                    $('<option></option>').val(item.code).html(item.name_en)
                );
            });
            $("#sub_district").selectpicker('refresh');
        });
    });

    sub_districtObject.on('change', function(){
        var sub_districtId = $(this).val();
        // alert('Change sub_districtId:'+sub_districtId);
        postcodeObject.html('<option value="" >Select a sub-district</option>');
        $.get('get_subdistrict.php?subdistrict_id=' + sub_districtId, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                postcodeObject.append(
                    $('<option></option>').val(item.code).html(item.zip_code)
                );
            });
            $("#postcode").selectpicker('refresh');
        });
    });

});
