<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[178,'index'])); ?>" class="btn singlebt">Pay Period</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button id="btnSave"   class="btn topnavbt" tabindex="7"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView"  disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt"  id="btnUndo" ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled" ><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove"<?php echo e((isset($objRights->APPROVAL1) || isset($objRights->APPROVAL2) || isset($objRights->APPROVAL3) || isset($objRights->APPROVAL4) || isset($objRights->APPROVAL5)) &&  ($objRights->APPROVAL1||$objRights->APPROVAL2||$objRights->APPROVAL3||$objRights->APPROVAL4||$objRights->APPROVAL5) == 1 ? '' : 'disabled'); ?>><i class="fa fa-lock"></i> Approved</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-link" ></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit"><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
         <form id="frm_mst_edit" method="POST"  > 
          <?php echo csrf_field(); ?>
          <?php echo e(isset($objResponse->PAYPERIODID) ? method_field('PUT') : ''); ?>

          <div class="inner-form">
          
              
              <div class="row">
              <div class="col-lg-2 pl"><p>Pay Period Code</p></div>
              <div class="col-lg-2 pl">                  
                <label> <?php echo e($objResponse->PAY_PERIOD_CODE); ?> </label>
                <input type="hidden" name="PAYPERIODID" id="PAYPERIODID" value="<?php echo e($objResponse->PAYPERIODID); ?>" />
                <input type="hidden" name="PAY_PERIOD_CODE" id="PAY_PERIOD_CODE" value="<?php echo e($objResponse->PAY_PERIOD_CODE); ?>" autocomplete="off"  maxlength="20"   />
                <input type="hidden" name="user_approval_level" id="user_approval_level" value="<?php echo e($user_approval_level); ?>"  />
            </div>
            </div>

            <div class="row">
              <div class="col-lg-2 pl"><p>Description</p></div>
              <div class="col-lg-5 pl">
                <input type="text" name="PAY_PERIOD_DESC" id="PAY_PERIOD_DESC" class="form-control mandatory" value="<?php echo e(old('PAY_PERIOD_DESC',$objResponse->PAY_PERIOD_DESC)); ?>" maxlength="200" tabindex="1"  />
                <span class="text-danger" id="ERROR_PAY_PERIOD_DESC"></span> 
              </div>
            </div>

            <div class="row">
                <div class="col-lg-2 pl"><p>Month</p></div>
                <div class="col-lg-2 pl">
                  <select name="MTID_REF" id="MTID_REF" class="form-control mandatory" tabindex="2" required >
                    <option value="" selected="selected">-- Please select --</option>
                    <?php $__currentLoopData = $objMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($row->MTID); ?>"  <?php if($row->MTID == $objResponse->MTID_REF ): ?> selected <?php endif; ?> ><?php echo e($row->MTCODE); ?> - <?php echo e($row->MTDESCRIPTION); ?> </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <span class="text-danger" id="ERROR_MTID_REF"></span> 
                </div>
                <div class="col-lg-2 pl"><p>Year</p></div>
                <div class="col-lg-2 pl">
                  <select name="YRID_REF" id="YRID_REF" class="form-control mandatory" tabindex="3" required >
                    <option value="" selected="selected">-- Please select --</option>
                    <?php $__currentLoopData = $objYear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($row->YRID); ?>"  <?php if($row->YRID == $objResponse->YRID_REF ): ?> selected <?php endif; ?> > <?php echo e($row->YRCODE); ?> - ( <?php echo e($row->YRDESCRIPTION); ?> ) </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <span class="text-danger" id="ERROR_YRID_REF"></span>
                </div>
            </div>

            <div class="row">
              <div class="col-lg-2 pl"><p>De-Activated</p></div>
              <div class="col-lg-2 pl pr">
              <input type="checkbox"   name="DEACTIVATED"  id="deactive-checkbox_0" <?php echo e($objResponse->DEACTIVATED == 1 ? "checked" : ""); ?>

                value='<?php echo e($objResponse->DEACTIVATED == 1 ? 1 : 0); ?>' tabindex="4"  >
              </div>
              
              <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
              <div class="col-lg-2 pl">
                <input type="date" name="DODEACTIVATED" class="form-control" id="DODEACTIVATED" <?php echo e($objResponse->DEACTIVATED == 1 ? "" : "disabled"); ?> value="<?php echo e(isset($objResponse->DODEACTIVATED) && $objResponse->DODEACTIVATED !="" && $objResponse->DODEACTIVATED !="1900-01-01" ? $objResponse->DODEACTIVATED:''); ?>" tabindex="5" placeholder="dd/mm/yyyy"  />
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
// $('#btnAdd').on('click', function() {
//       var viewURL = '<?php echo e(route("master",[178,"add"])); ?>';
//       window.location.href=viewURL;
//   });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });

 var formDataMst = $( "#frm_mst_edit" );
     formDataMst.validate();

     $("#PAY_PERIOD_DESC").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_PAY_PERIOD_DESC").hide();
        validateSingleElemnet("PAY_PERIOD_DESC");
    });
     $("#PAY_PERIOD_DESC").keydown(function(){
       
        $("#ERROR_PAY_PERIOD_DESC").hide();
        validateSingleElemnet("PAY_PERIOD_DESC");
    });

    $( "#PAY_PERIOD_DESC" ).rules( "add", {
        required: true,
        //StringRegex: true,  //from custom.js
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field."
        }
    });

    $("#MTID_REF").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_MTID_REF").hide();
        validateSingleElemnet("MTID_REF");
    });

    $( "#MTID_REF" ).rules( "add", {
        required: true,
        //StringRegex: true,  //from custom.js
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field."
        }
    });
    $("#YRID_REF").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_YRID_REF").hide();
        validateSingleElemnet("YRID_REF");
    });

    $( "#YRID_REF" ).rules( "add", {
        required: true,
        //StringRegex: true,  //from custom.js
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field."
        }
    });

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
            url:'<?php echo e(route("mastermodify",[178,"update"])); ?>',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();

                    if(data.errors.PAY_PERIOD_CODE){
                        showError('ERROR_PAY_PERIOD_CODE',data.errors.PAY_PERIOD_CODE);
                    }
                    if(data.errors.PAY_PERIOD_DESC){
                        showError('ERROR_PAY_PERIOD_DESC',data.errors.PAY_PERIOD_DESC);
                    }
                    if(data.errors.MTID_REF){
                        showError('ERROR_MTID_REF',data.errors.MTID_REF);
                    }
                    if(data.errors.YRID_REF){
                        showError('ERROR_YRID_REF',data.errors.YRID_REF);
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
            url:'<?php echo e(route("mastermodify",[178,"singleapprove"])); ?>',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();

                    if(data.errors.PAY_PERIOD_CODE){
                        showError('ERROR_PAY_PERIOD_CODE',data.errors.PAY_PERIOD_CODE);
                    }
                    if(data.errors.PAY_PERIOD_DESC){
                        showError('ERROR_PAY_PERIOD_DESC',data.errors.PAY_PERIOD_DESC);
                    }
                    if(data.errors.MTID_REF){
                        showError('ERROR_MTID_REF',data.errors.MTID_REF);
                    }
                    if(data.errors.YRID_REF){
                        showError('ERROR_YRID_REF',data.errors.YRID_REF);
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
        window.location.href = '<?php echo e(route("master",[178,"index"])); ?>';

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

      $("#PLCODE").focus();

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
	
	var today = new Date(); 
    var dodeactived_date = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
    $('#DODEACTIVATED').attr('min',dodeactived_date);

	$('input[type=checkbox][name=DEACTIVATED]').change(function() {
		if ($(this).prop("checked")) {
		  $(this).val('1');
		  $('#DODEACTIVATED').removeAttr('disabled');
		  $('#DODEACTIVATED').prop('required',true);
		}
		else {
		  $(this).val('0');
		  $('#DODEACTIVATED').prop('disabled', true);
      $('#DODEACTIVATED').removeAttr('required');
		  $('#DODEACTIVATED').val('');
		  $('#DODEACTIVATED').removeClass("error");
		  $('#DODEACTIVATED-error').hide();
		  
		}
	});

});

$(function() { 
  //$("#DESCRIPTIONS").focus(); 
});
</script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Payroll\PayPeriod\mstfrm178edit.blade.php ENDPATH**/ ?>