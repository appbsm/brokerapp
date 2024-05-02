
$(function(){
    var productObject = $('#product_cat');
    var subObject = $('#sub_cat');
    var result_type1 = "";
    var result_type2 = "";
    $.get('get_product_categories.php?type=Life', function(data){
        result_type1 = JSON.parse(data);
    });
    $.get('get_product_categories.php?type=Non Life', function(data){
        result_type2 = JSON.parse(data);
    });

    productObject.on('change', function(){
        var productId = $(this).val();
        // alert('Change productId:'+productId);

        subObject.html('');
        if(productId=="Life"){
            $.each(result_type1, function(index, item){
                subObject.append(
                    $('<option></option>').val(item.id).html(item.sub_categories)
                );
            });
        }else{
             $.each(result_type2, function(index, item){
                subObject.append(
                    $('<option></option>').val(item.id).html(item.sub_categories)
                );
            });
        }
    });
});
