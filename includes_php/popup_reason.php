<!-- <div id="ModalNotrenew" data-backdrop="static" class="modal fade" role="dialog"> -->
<div id="ModalNotrenew" data-backdrop="static" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-12 px-3" class="text-left">
                    Please include the reason why the customer did not renew the insurance.
                </div>
            </div>  

            <div class="modal-body">
                <label style="color: #102958;" for="staticEmail" >Reason:</label>
                <textarea class="form-control" id="textarea_pop" name="textarea_pop" rows="5" placeholder="Cancellation reason"  ></textarea>
            </div>

            <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button style="background-color: #0275d8;color: #F9FAFA;" type="button" class="btn" onclick="click_renew()" >Submit</button>
                <button type="button" style="background-color: #0275d8;color: #F9FAFA;" class="btn " data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script >
    function click_renew() {
        var value_text = document.getElementById("textarea_pop").value;
        if(value_text==""){
            alert('Please enter information');
        }else{
            document.getElementById("textarea_detail").value = value_text;
            $('#ModalNotrenew').modal('hide');
        }
    }   
</script>