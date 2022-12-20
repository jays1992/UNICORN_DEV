<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[385,'index'])); ?>" class="btn singlebt">Instrument Method</a>
                </div><!--col-2-->
                <div class="col-lg-10 topnav-pd">
                <button class="btn topnavbt" id="btnAdd" disabled="disabled" ><i class="fa fa-plus"></i> Add</button>
                <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                <button class="btn topnavbt" id="btnSave"  tabindex="3"  ><i class="fa fa-floppy-o"></i> Save</button>
                <button class="btn topnavbt" id="btnView" disabled="disabled" ><i class="fa fa-eye"></i> View</button>
                <button class="btn topnavbt" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                <button class="btn topnavbt" id='btnUndo' ><i class="fa fa-undo"></i> Undo</button>
                <button class="btn topnavbt" id="btnCancel"  disabled="disabled" ><i class="fa fa-times"></i> Cancel</button>
                <button class="btn topnavbt" id="btnApprove"  disabled="disabled" ><i class="fa fa-thumbs-o-up"></i> Approved</button>
                <button class="btn topnavbt"  id="btnAttach"  disabled="disabled" ><i class="fa fa-link"></i> Attachment</button>
                <button class="btn topnavbt" id="btnExit"><i class="fa fa-power-off"></i> Exit</button>
              </div>
            </div>
    </div>
   
    <div class="container-fluid purchase-order-view filter">     
         <form id="frm_mst_add" method="POST"  > 
          <?php echo csrf_field(); ?>
          <div class="inner-form">
            <div class="row">
              <div class="col-lg-2 pl"><p>Instrument Method Code</p></div>
              <div class="col-lg-2 pl">
                <div class="col-lg-11 pl">
                <input type="text" name="INSTRUMENT_METHOD_CODE" id="INSTRUMENT_METHOD_CODE" value="<?php echo e($docarray['DOC_NO']); ?>" <?php echo e($docarray['READONLY']); ?> class="form-control" maxlength="<?php echo e($docarray['MAXLENGTH']); ?>" autocomplete="off" style="text-transform:uppercase" >
              
                    <span class="text-danger" id="ERROR_INSTRUMENT_METHOD_CODE"></span> 
                </div>
              </div>
            </div>
              <div class="row">
                <div class="col-lg-2 pl"><p>Instrument Method Name</p></div>
                <div class="col-lg-2 pl">
                  <input type="text" name="INSTRUMENT_METHOD_NAME" id="INSTRUMENT_METHOD_NAME" class="form-control mandatory" value="<?php echo e(old('INSTRUMENT_METHOD_NAME')); ?>" maxlength="200" tabindex="2"  />
                  <span class="text-danger" id="ERROR_INSTRUMENT_METHOD_NAME"></span> 
                </div>
              </div>
          </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('alert'); ?>
<!-- Alert -->
<div id="alert" class="modal"  role="dialog"  data-backdrop="static" >
  <div class="modal-dialog" >
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

  $('#btnAdd').on('click', function() {
      var viewURL = '<?php echo e(route("master",[385,"add"])); ?>';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });

 var formResponseMst = $( "#frm_mst_add" );
     formResponseMst.validate();

     $("#INSTRUMENT_METHOD_CODE").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_INSTRUMENT_METHOD_CODE").hide();
        validateSingleElemnet("INSTRUMENT_METHOD_CODE");
    });

    $( "#INSTRUMENT_METHOD_CODE" ).rules( "add", {
        required: true,
        //StringRegex: true,  //from custom.js
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field."
        }
    });
   
    $("#INSTRUMENT_METHOD_NAME").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_INSTRUMENT_METHOD_NAME").hide();
        validateSingleElemnet("INSTRUMENT_METHOD_NAME");
    });

    $( "#INSTRUMENT_METHOD_NAME" ).rules( "add", {
        required: true,
        //StringRegex: true,  //from custom.js
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field."
        }
    });

    

    //validae single element
    function validateSingleElemnet(element_id){
      var validator =$("#frm_mst_add" ).validate();
         if(validator.element( "#"+element_id+"" )){
            //check duplicate code
          if(element_id=="INSTRUMENT_METHOD_CODE" || element_id=="INSTRUMENT_METHOD_CODE" ) {
            checkDuplicateCode();
          }

         }
    }

    // //check duplicate exist code
    function checkDuplicateCode(){
        
        //validate and save data
        var getDataForm = $("#frm_mst_add");
        var formData = getDataForm.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'<?php echo e(route("master",[385,"codeduplicate"])); ?>',
            type:'POST',
            data:formData,
            success:function(data) {
                if(data.exists) {
                    $(".text-danger").hide();
                    showError('ERROR_INSTRUMENT_METHOD_CODE',data.msg);
                    $("#INSTRUMENT_METHOD_CODE").focus();
                }                                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
            },
        });
    }

    //validate
    $( "#btnSave" ).click(function() {
        if(formResponseMst.valid()){
            //set function nane of yes and no btn 
            $("#alert").modal('show');
            $("#AlertMessage").text('Do you want to save to record.');
            $("#YesBtn").data("funcname","fnSaveData");  //set dynamic fucntion name
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

        var getDataForm = $("#frm_mst_add");
        var formData = getDataForm.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'<?php echo e(route("master",[385,"save"])); ?>',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();

                    if(data.errors.INSTRUMENT_METHOD_CODE){
                        showError('ERROR_INSTRUMENT_METHOD_CODE',data.errors.INSTRUMENT_METHOD_CODE);
                    }
                   if(data.exist=='duplicate') {
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
                    $("#frm_mst_add").trigger("reset");
                    $("#alert").modal('show');
                    $("#OkBtn").focus();

                  //  window.location.href='<?php echo e(route("master",[385,"index"])); ?>';
                }
                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
            },
        });
      
   } // fnSaveData    
    $("#NoBtn").click(function(){    
      $("#alert").modal('hide');
      var custFnName = $("#NoBtn").data("funcname");
          window[custFnName]();

    }); //no button  
    
    $("#OkBtn").click(function(){
        $("#alert").modal('hide');
        $("#YesBtn").show();  //reset
        $("#NoBtn").show();   //reset
        $("#OkBtn").hide();
        $(".text-danger").hide();
        window.location.href = '<?php echo e(route("master",[385,"index"])); ?>';        
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
      window.location.href = "<?php echo e(route('master',[385,'add'])); ?>";
   }//fnUndoYes
   window.fnUndoNo = function (){
      $("#INSTRUMENT_METHOD_CODE").focus();
   }//fnUndoNo
    function showError(pId,pVal){
      $("#"+pId+"").text(pVal);
      $("#"+pId+"").show();

    }//showError
    function highlighFocusBtn(pclass){
       $(".activeYes").hide();
       $(".activeNo").hide();       
       $("."+pclass+"").show();
    }
    $(function() { $("#INSTRUMENT_METHOD_CODE").focus(); });   

check_exist_docno(<?php echo json_encode($docarray['EXIST'], 15, 512) ?>);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Quality\InstrumentMethod\mstfrm385add.blade.php ENDPATH**/ ?>