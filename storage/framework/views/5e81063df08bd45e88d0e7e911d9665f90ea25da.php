<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[120,'index'])); ?>" class="btn singlebt">Branch Group</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button href="#" id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button id="btnSave"   class="btn topnavbt" tabindex="4"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView"  disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt"  id="btnUndo" ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled" ><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" <?php echo e((isset($objRights->APPROVAL1) || isset($objRights->APPROVAL2) || isset($objRights->APPROVAL3) || isset($objRights->APPROVAL4) || isset($objRights->APPROVAL5)) &&  ($objRights->APPROVAL1||$objRights->APPROVAL2||$objRights->APPROVAL3||$objRights->APPROVAL4||$objRights->APPROVAL5) == 1 ? '' : 'disabled'); ?>><i class="fa fa-lock"></i> Approved</button>
                        <a href="#" class="btn topnavbt"  disabled="disabled"><i class="fa fa-link" ></i> Attachment</a>
                        <button class="btn topnavbt" id="btnExit"><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
         <form id="frm_mst_edit" method="POST"  > 
          <?php echo csrf_field(); ?>
          <?php echo e(isset($objResponse->BGID) ? method_field('PUT') : ''); ?>

          <div class="inner-form">
          
              
              <div class="row">
                  <div class="col-lg-2 pl"><p>Branch Group Code</p></div>
                  <div class="col-lg-2 pl">
                  
                    <label> <?php echo e($objResponse->BG_CODE); ?> </label>
                    <input type="hidden" name="BGID" id="BGID" value="<?php echo e($objResponse->BGID); ?>" />
                    <input type="hidden" name="BG_CODE" id="BG_CODE" value="<?php echo e($objResponse->BG_CODE); ?>" autocomplete="off"  maxlength="20"   />
                    <input type="hidden" name="user_approval_level" id="user_approval_level" value="<?php echo e($user_approval_level); ?>"  />
                  
                </div>
                </div>

                <div class="row">
                
                  <div class="col-lg-2 pl"><p>Description</p></div>
                  <div class="col-lg-5 pl">
                    <input type="text" name="BG_DESC" id="BG_DESC" class="form-control mandatory" value="<?php echo e(old('BG_DESC',$objResponse->BG_DESC)); ?>" maxlength="200" tabindex="1"  />
                    <span class="text-danger" id="ERROR_BG_DESC"></span> 
                  </div>
                </div>
          
                <div class="row" id="alps_sap" style="display:none;">
                  <div class="col-lg-2 pl"><p>SAP Code</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-11 pl">
                        <input type="text" name="SAP_CODE" id="SAP_CODE"  value="<?php echo e(old('SAP_CODE',$objResponse->SAP_CODE)); ?>" class="form-control mandatory" autocomplete="off" maxlength="20" tabindex="1" style="text-transform:uppercase" />
                        <span class="text-danger" id="ERROR_SAP_CODE"></span> 
                    </div>
                  </div>
                </div>


                <div class="row" id="alps_ref" style="display:none;">
                  <div class="col-lg-2 pl"><p>ALPS Ref No</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-11 pl">
                        <input type="text" name="ALPS_REF" id="ALPS_REF" value="<?php echo e(old('ALPS_REF',$objResponse->ALPS_REFNO)); ?>" class="form-control mandatory" autocomplete="off" maxlength="20" tabindex="1" style="text-transform:uppercase" />
                        <span class="text-danger" id="ERROR_ALPS_REF"></span> 
                    </div>
                  </div>
                </div>
          
             
              

              <div class="row">
                <div class="col-lg-2 pl"><p>De-Activated</p></div>
                <div class="col-lg-1 pl pr">
                <input type="checkbox"   name="DEACTIVATED"  id="deactive-checkbox_0" <?php echo e($objResponse->DEACTIVATED == 1 ? "checked" : ""); ?>

                 value='<?php echo e($objResponse->DEACTIVATED == 1 ? 1 : 0); ?>' tabindex="2"  >
                </div>
                
                <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
                <div class="col-lg-2 pl">
                  <input type="date" name="DODEACTIVATED" class="form-control" id="DODEACTIVATED" <?php echo e($objResponse->DEACTIVATED == 1 ? "" : "disabled"); ?> value="<?php echo e(isset($objResponse->DODEACTIVATED) && $objResponse->DODEACTIVATED !="" && $objResponse->DODEACTIVATED !="1900-01-01" ? $objResponse->DODEACTIVATED:''); ?>" tabindex="3" placeholder="dd/mm/yyyy"  />
                </div>
             </div>

          </div>
        </form>
    </div><!--purchase-order-view-->


<?php $__env->stopSection(); ?>
<?php $__env->startSection('alert'); ?>
<!-- Alert -->
<div id="alert" class="modal"  role="dialog"  data-backdrop="static" >
  <div class="modal-dialog"  >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='closePopup' >&times;</button>
        <h4 class="modal-title">System Alert Message</h4>
      </div>
      <div class="modal-body">
	  <h5 id="AlertMessage" ></h5>
        <div class="btdiv">    
            <button class="btn alertbt" name='YesBtn' id="YesBtn" data-funcname="fnSaveData">
              <div id="alert-active" class="activeYes"></div>Yes
            </button>
            <button class="btn alertbt" name='NoBtn' id="NoBtn"   data-funcname="fnUndoNo" >
              <div id="alert-active" class="activeNo"></div>No
            </button>
            <button class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;">
              <div id="alert-active" class="activeOk"></div>OK</button>
        </div><!--btdiv-->
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Alert -->
<?php $__env->stopSection(); ?>
<!-- btnSave -->

<?php $__env->startPush('bottom-scripts'); ?>
<script>
$(document).ready(function(e) {
  var obj = <?php echo json_encode($objcompany); ?>;
  if(obj.NAME.indexOf('ALPS') != -1)
  {
    $('#alps_sap').show();
    $('#alps_ref').show();
  }
  else
  {
    $('#alps_sap').hide();
    $('#alps_ref').hide();
  }
});
$('#btnAdd').on('click', function() {
      var viewURL = '<?php echo e(route("master",[120,"add"])); ?>';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });

 var formDataMst = $( "#frm_mst_edit" );
     formDataMst.validate();

    $("#BG_DESC").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_BG_DESC").hide();
        validateSingleElemnet("BG_DESC");

    });

    $("#BG_DESC").keydown(function(){
       
        $("#ERROR_BG_DESC").hide();
        validateSingleElemnet("BG_DESC");

    });

    $( "#BG_DESC" ).rules( "add", {
        required: true,
        //StringRegex: true,  //from custom.js
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field"
        }
    });

    // $("#SAP_CODE").blur(function(){
    //     $(this).val($.trim( $(this).val() ));
    //     $("#ERROR_SAP_CODE").hide();
    //     validateSingleElemnet("SAP_CODE");

    // });

    // $( "#SAP_CODE" ).rules( "add", {
    //     required: true,
    //     //StringRegex: true,  //from custom.js
    //     normalizer: function(value) {
    //         return $.trim(value);
    //     },
    //     messages: {
    //         required: "Required field"
    //     }
    // });

    // $("#ALPS_REF").blur(function(){
    //     $(this).val($.trim( $(this).val() ));
    //     $("#ERROR_ALPS_REF").hide();
    //     validateSingleElemnet("ALPS_REF");

    // });

    // $( "#ALPS_REF" ).rules( "add", {
    //     required: true,
    //     //StringRegex: true,  //from custom.js
    //     normalizer: function(value) {
    //         return $.trim(value);
    //     },
    //     messages: {
    //         required: "Required field"
    //     }
    // });

    $("#DODEACTIVATED").blur(function(){
      $(this).val($.trim( $(this).val() ));
      $("#ERROR_DODEACTIVATED").hide();
      validateSingleElemnet("DODEACTIVATED");
    });

    $( "#DODEACTIVATED" ).rules( "add", {
        required: true,
        DateValidate:true,
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field"
        }
    });

    //validae single element
    function validateSingleElemnet(element_id){
      var validator =$("#frm_mst_edit" ).validate();
          validator.element( "#"+element_id+"" );
    }

    //validate
    $( "#btnSave" ).click(function() {

        if(formDataMst.valid()){
            //set function nane of yes and no btn 
            $("#alert").modal('show');
            $("#AlertMessage").text('Do you want to save to record.');
            $("#YesBtn").data("funcname","fnSaveData");  //set dynamic fucntion name
            $("#YesBtn").focus();
            highlighFocusBtn('activeYes');

        }

    });//btnSave

    
    //validate and approve
    $("#btnApprove").click(function() {
        
        if(formDataMst.valid()){
            //set function nane of yes and no btn 
            $("#alert").modal('show');
            $("#AlertMessage").text('Do you want to save to record.');
            $("#YesBtn").data("funcname","fnApproveData");  //set dynamic fucntion name of approval
            $("#YesBtn").focus();
            highlighFocusBtn('activeYes');

        }

    });//btnSave


    $("#YesBtn").click(function(){

      $("#alert").modal('hide');
      var customFnName = $("#YesBtn").data("funcname");
          window[customFnName]();

    }); //yes button

    
    window.fnSaveData = function (){
        
        //validate and save data
        event.preventDefault();

        var getDataForm = $("#frm_mst_edit");
        var formData = getDataForm.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'<?php echo e(route("mastermodify",[120,"update"])); ?>',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();

                    if(data.errors.BG_DESC){
                        showError('ERROR_BG_DESC',data.errors.BG_DESC);
                    }
                   if(data.exist=='norecord') {

                    $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn").show();

                      $("#AlertMessage").text(data.msg);

                      $("#alert").modal('show');
                      $("#OkBtn").focus();

                   }
                   if(data.save=='invalid') {

                      $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn").show();

                      $("#AlertMessage").text(data.msg);

                      $("#alert").modal('show');
                      $("#OkBtn").focus();

                   }
                }
                if(data.success) {                   
                    console.log("succes MSG="+data.msg);
                    
                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn").show();

                    $("#AlertMessage").text(data.msg);

                    $(".text-danger").hide();
                    $("#frm_mst_edit").trigger("reset");

                    $("#alert").modal('show');
                    $("#OkBtn").focus();

                }
                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
            },
        });

    };// fnSaveData


    // save and approve 
    window.fnApproveData = function (){
        
        //validate and save data
        event.preventDefault();

        var getDataForm = $("#frm_mst_edit");
        var formData = getDataForm.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'<?php echo e(route("mastermodify",[120,"singleapprove"])); ?>',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();

                    if(data.errors.BG_DESC){
                        showError('ERROR_BG_DESC',data.errors.BG_DESC);
                    }
                   if(data.exist=='norecord') {

                    $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn").show();

                      $("#AlertMessage").text(data.msg);

                      $("#alert").modal('show');
                      $("#OkBtn").focus();

                   }
                   if(data.save=='invalid') {

                      $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn").show();

                      $("#AlertMessage").text(data.msg);

                      $("#alert").modal('show');
                      $("#OkBtn").focus();

                   }
                }
                if(data.success) {                   
                    console.log("succes MSG="+data.msg);
                    
                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn").show();

                    $("#AlertMessage").text(data.msg);

                    $(".text-danger").hide();
                    $("#frm_mst_edit").trigger("reset");

                    $("#alert").modal('show');
                    $("#OkBtn").focus();

                }
                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
            },
        });

    };// fnApproveData

    //no button
    $("#NoBtn").click(function(){

      $("#alert").modal('hide');
      var custFnName = $("#NoBtn").data("funcname");
          window[custFnName]();

    }); //no button

   
    $("#OkBtn").click(function(){

        $("#alert").modal('hide');

        $("#YesBtn").show();
        $("#NoBtn").show();
        $("#OkBtn").hide();

        $(".text-danger").hide();
        window.location.href = '<?php echo e(route("master",[120,"index"])); ?>';

    }); ///ok button

    $("#btnUndo").click(function(){

        $("#AlertMessage").text("Do you want to erase entered information in this record?");
        $("#alert").modal('show');

        $("#YesBtn").data("funcname","fnUndoYes");
        $("#YesBtn").show();

        $("#NoBtn").data("funcname","fnUndoNo");
        $("#NoBtn").show();

        $("#OkBtn").hide();
        $("#NoBtn").focus();
        highlighFocusBtn('activeNo');

    }); ////Undo button

   
    $("#OkBtn").click(function(){
      
        $("#alert").modal('hide');

    });////ok button


   window.fnUndoYes = function (){
      
      //reload form
      window.location.reload();

   }//fnUndoYes


   window.fnUndoNo = function (){

      $("#BG_CODE").focus();

   }//fnUndoNo


    //
    function showError(pId,pVal){

      $("#"+pId+"").text(pVal);
      $("#"+pId+"").show();

    }  

    function highlighFocusBtn(pclass){
       $(".activeYes").hide();
       $(".activeNo").hide();
       
       $("."+pclass+"").show();
    }

</script>
<script type="text/javascript">
$(function () {

$('input[type=checkbox][name=DEACTIVATED]').change(function() {
    if ($(this).prop("checked")) {
      $(this).val('1');
      $('#DODEACTIVATED').removeAttr('disabled');
    }
    else {
      $(this).val('0');
      $('#DODEACTIVATED').prop('disabled', true);
      $('#DODEACTIVATED').val('');
      
    }
});

});

$(function() { 
  //$("#BG_DESC").focus(); 
});
</script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Common\BranchGroup\mstfrm120edit.blade.php ENDPATH**/ ?>