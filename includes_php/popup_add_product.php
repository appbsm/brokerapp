<?php
include_once('includes/connect_sql.php');

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

<div id="ModalProduct" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >

    <div class="modal-content">
            <br>
            <div class="form-group row px-3 ">
            <div class="col-sm-6" class="text-left">
                <h4 class="modal-title padding-left">Select Product</h4>
            </div>
            <div class="col-sm-6 text-right" >
            </div>
      </div>

      <div class="modal-body">
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-2">
                            <label style="color: #102958;" for="staticEmail" class="col-form-label">Products Name:</label>
                        </div>
                        <div class="col-sm-10">
                            <select id="popup_product" style="color: #4590B8;border-color:#102958;" class="form-control selectpicker" data-live-search="true" multiple="multiple" title="Search Products" >
                                <!-- <option value="">Select Product Name</option> -->
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row col-md-10 col-md-offset-1">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">
                            <textarea id="popup_product_all" name="popup_product_all" class="form-control" style="color: #0C1830;border-color:#102958;" rows="1" readonly>
                            </textarea>
                        </div>
                    </div>

                    <script>
                        var selectedOptions = Array.from(document.getElementById("popup_product").selectedOptions).map(option => option.textContent);
                        var selectedOptionsText = selectedOptions.join("\n");
                        document.getElementById("popup_product_all").value = selectedOptionsText;
                        var lineCount = (selectedOptionsText.match(/\n/g) || []).length + 1;
                        document.getElementById("popup_product_all").rows = lineCount;

                        document.getElementById("popup_product").addEventListener("change", function() {
                            var selectedOptions = Array.from(this.selectedOptions).map(option => option.textContent);
                            var selectedOptionsText = selectedOptions.join("\n");
                            // var selectedOptionsText = selectedOptions.join(", ");
    
                            // ใส่ค่าที่เลือกทั้งหมดลงใน textarea ที่มี id เป็น product_name_all
                            document.getElementById("popup_product_all").value = selectedOptionsText;
                            var lineCount = (selectedOptionsText.match(/\n/g) || []).length + 1;
                            document.getElementById("popup_product_all").rows = lineCount;
                        });
                    </script>
        
      </div>

      <div class="modal-footer">
        <button type="button" style="background-color: #0275d8;color: #F9FAFA;" class="btn btn-default" onclick="saveFunction()" >Save</button>

        <button type="button" style="background-color: #0275d8;color: #F9FAFA;" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>

    <script>
        
        function saveFunction() {
            var product_object = $('#product_name');
            var selectElement = document.getElementById("popup_product");
            // ตรวจสอบว่ามีสินค้าที่ถูกเลือกหรือไม่
            if (selectElement.selectedOptions.length > 0) {
                // สร้างอาร์เรย์เพื่อเก็บค่าที่ถูกเลือก
                var selectedValues = [];
                
                // วนลูปเพื่อเก็บค่าที่ถูกเลือกลงในอาร์เรย์
                for (var i = 0; i < selectElement.selectedOptions.length; i++) {
                    selectedValues.push(selectElement.selectedOptions[i].value);
                }
                // selectedValues.push("1");
                // selectedValues.push("2");

                // ส่งค่าที่ถูกเลือกไปยังหน้า PHP โดยใช้ AJAX
                var xhr = new XMLHttpRequest();
                var id = document.getElementById("insurance_com").value;
                xhr.open("POST", "save_product.php?id="+id, true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // alert('xhr.responseText:'+xhr.responseText);
                        // alert('Save button clicked!');

                        //////////////  เมื่อมีการแก้ไขให้ดึงใหม่
                        product_object.html('');
                        $.get('get_product.php?id=' + id,function(data){
                            var result = JSON.parse(data);
                            product_object.append($('<option></option>').val("").html("Select Product Name"));
                            document.getElementById("product_cat").value = "";
                            document.getElementById("sub_cat").value = "";
                            $.each(result, function(index, item){
                                product_object.append(
                                $('<option></option>').val(item.id).html(item.product_name));
                                
                            });
                        });
                        ////////////// 
                        $("#popup_product").selectpicker('refresh');
                        $('#ModalProduct').modal('hide');
                    }
                };
                xhr.send(JSON.stringify(selectedValues));
                // alert('sent JSON :'+JSON.stringify(selectedValues));

            } else {
                // ถ้าไม่มีสินค้าที่ถูกเลือก
                alert("Please select at least one product.");
            }
  
        }

    </script>


  </div>
</div>

