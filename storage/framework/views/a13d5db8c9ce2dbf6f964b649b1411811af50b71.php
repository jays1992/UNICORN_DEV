
<?php $__env->startSection('content'); ?>

    <div class="container-fluid topnav">
      <div class="row">
          <div class="col-lg-2">
          <a href="<?php echo e(route('master',[$FormId,'index'])); ?>" class="btn singlebt">Task Type</a>
          </div>
          <div class="col-lg-10 topnav-pd">
          <button class="btn topnavbt" id="btnAdd" disabled="disabled" ><i class="fa fa-plus"></i> Add</button>
          <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
          <button class="btn topnavbt" id="btnSave"  tabindex="3"  ><i class="fa fa-save"></i> Save</button>
          <button class="btn topnavbt" id="btnView" disabled="disabled" ><i class="fa fa-eye"></i> View</button>
          <button class="btn topnavbt" disabled="disabled"><i class="fa fa-print"></i> Print</button>
          <button class="btn topnavbt" id='btnUndo' ><i class="fa fa-undo"></i> Undo</button>
          <button class="btn topnavbt" id="btnCancel"  disabled="disabled" ><i class="fa fa-times"></i> Cancel</button>
          <button class="btn topnavbt" id="btnApprove"  disabled="disabled" ><i class="fa fa-lock"></i> Approved</button>
          <button class="btn topnavbt"  id="btnAttach"  disabled="disabled" ><i class="fa fa-link"></i> Attachment</button>
          <button class="btn topnavbt" id="btnExit"><i class="fa fa-power-off"></i> Exit</button>
        </div>
      </div>
  </div>
   
    <div class="container-fluid purchase-order-view filter">     
         <form id="frm_mst_add" method="POST"> 
          <?php echo csrf_field(); ?>
          <div class="inner-form">
                <div class="row">
                  <div class="col-lg-2 pl"><p>Task Type Code</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-11 pl">
                    <input type="text" name="TASK_TYPECODE" id="TASK_TYPECODE" value="<?php echo e($docarray['DOC_NO']); ?>" <?php echo e($docarray['READONLY']); ?> class="form-control" maxlength="<?php echo e($docarray['MAXLENGTH']); ?>" autocomplete="off" style="text-transform:uppercase" >
						
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-2 pl"><p>Task Type Name</p></div>
                  <div class="col-lg-5 pl">
                    <input type="text" name="TASK_TYPENAME" id="TASK_TYPENAME" class="form-control mandatory" value="<?php echo e(old('TASK_TYPENAME')); ?>" maxlength="200" tabindex="2"  />
                  </div>
                </div>
          </div>
        </form>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('alert'); ?>
<div id="alert" class="modal"  role="dialog"  data-backdrop="static">
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
            <div id="alert-active" class="activeYes"></div>Yes</button>
            <button class="btn alertbt" name='NoBtn' id="NoBtn"   data-funcname="fnUndoNo" >
            <div id="alert-active" class="activeNo"></div>No</button>
            <button class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;">
            <div id="alert-active" class="activeOk"></div>OK</button>
            <button class="btn alertbt" name='OkBtn1' id="OkBtn1" style="display:none;margin-left: 90px;">
            <div id="alert-active" class="activeOk1"></div>OK</button>
        </div>
		    <div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('bottom-scripts'); ?>
<script>
  
  $('#btnAdd').on('click', function() {
      var viewURL = '<?php echo e(route("master",[$FormId,"add"])); ?>';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });

    var formResponseMst = $( "#frm_mst_add" );
     formResponseMst.validate();

      $( "#TASK_TYPECODE" ).rules( "add", {
        required: true,
        nowhitespace: true,
        messages: {
        required: "Required field.",
        }
      });
      $( "#TASK_TYPENAME" ).rules( "add", {
        required: true,
        normalizer: function(value) {
         return $.trim(value);
        },
        messages: {
        required: "Required field."
        }
      });

    
  $( "#btnSave" ).click(function() {
      if(formResponseMst.valid()){
      var TASK_TYPECODE          =   $.trim($("#TASK_TYPECODE").val());
      if(TASK_TYPECODE ===""){
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").hide();  
        $("#OkBtn").show();              
        $("#AlertMessage").text('Please enter Task Type Code.');
        $("#alert").modal('show');
        $("#OkBtn").focus();
        return false;
      }
        $("#alert").modal('show');
        $("#AlertMessage").text('Do you want to save to record.');
        $("#YesBtn").data("funcname","fnSaveData");
        $("#YesBtn").focus();
        highlighFocusBtn('activeYes');
      }
    });

    
      $("#YesBtn").click(function(){
        $("#alert").modal('hide');
        var customFnName = $("#YesBtn").data("funcname");
          window[customFnName]();
      });


      window.fnSaveData = function (){
        event.preventDefault();
        $("#OkBtn1").hide();
        var getDataForm = $("#frm_mst_add");
        var formData = getDataForm.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'<?php echo e(route("master",[$FormId,"save"])); ?>',
            type:'POST',
            data:formData,
            success:function(data) {
            if(data.errors) {
              $(".text-danger").hide();
              if(data.errors.TASK_TYPECODE){
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn1").hide();
                $("#OkBtn").show();
                $("#AlertMessage").text("Post Level Code is "+data.errors.TASK_TYPECODE);
                $("#alert").modal('show');
                $("#OkBtn").focus();
              }
              if(data.exist=='duplicate') {
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn").show();
                $("#OkBtn1").hide();
                $("#AlertMessage").text(data.msg);
                $("#alert").modal('show');
                $("#OkBtn").focus();
              }
            }
            if(data.success) {                   
              $("#YesBtn").hide();
              $("#NoBtn").hide();
              $("#OkBtn1").show();
              $("#OkBtn").hide();
              $("#AlertMessage").text(data.msg);
              $(".text-danger").hide();
              $("#frm_mst_add").trigger("reset");
              $("#alert").modal('show');
              $("#OkBtn1").focus();
          }
        },
        error:function(data){
        console.log("Error: Something went wrong.");
        },
      });
    } 

        $("#NoBtn").click(function(){
          $("#alert").modal('hide');
          var custFnName = $("#NoBtn").data("funcname");
          window[custFnName]();
        });
   
          $("#OkBtn").click(function(){
          $("#alert").modal('hide');
          $("#YesBtn").show();
          $("#NoBtn").show();
          $("#OkBtn").hide();
          $("#OkBtn1").hide();
          $(".text-danger").hide();
          $("#TASK_TYPECODE").focus();
          });

    
          $("#btnUndo").click(function(){
              $("#AlertMessage").text("Do you want to erase entered information in this record?");
              $("#alert").modal('show');
              $("#YesBtn").data("funcname","fnUndoYes");
              $("#YesBtn").show();
              $("#NoBtn").data("funcname","fnUndoNo");
              $("#NoBtn").show();
              $("#OkBtn").hide();
              $("#OkBtn1").hide();
              $("#NoBtn").focus();
              highlighFocusBtn('activeNo');
              });

              $("#OkBtn1").click(function(){
              $("#alert").modal('hide');
              $("#YesBtn").show();
              $("#NoBtn").show();
              $("#OkBtn").hide();
              $("#OkBtn1").hide();
              $(".text-danger").hide();
              window.location.href = "<?php echo e(route('master',[$FormId,'index'])); ?>";
              }); 

    
          $("#OkBtn").click(function(){
            $("#alert").modal('hide');
          });


        window.fnUndoYes = function (){
          window.location.href = "<?php echo e(route('master',[$FormId,'add'])); ?>";
        }


      window.fnUndoNo = function (){
      $("#TASK_TYPECODE").focus();
      }

    function highlighFocusBtn(pclass){
       $(".activeYes").hide();
       $(".activeNo").hide();
       $("."+pclass+"").show();
    }

    check_exist_docno(<?php echo json_encode($docarray['EXIST'], 15, 512) ?>);

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\PROJECTS\UNICORN_DEV\resources\views/masters/PreSales/TaskType/mstfrm434add.blade.php ENDPATH**/ ?>