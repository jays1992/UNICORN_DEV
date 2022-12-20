
<?php $__env->startSection('content'); ?>
<div class="container-fluid topnav">
  <div class="row">
    <div class="col-lg-2"><a href="<?php echo e(route('transaction',[$FormId,'index'])); ?>" class="btn singlebt">Serial No & Barcode (IN)</a></div>

    <div class="col-lg-10 topnav-pd">
      <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
      <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
      <button class="btn topnavbt" id="btnSaveSE" disabled="disabled"><i class="fa fa-floppy-o" ></i> Save</button>
      <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
      <button class="btn topnavbt" id="btnUndo"  disabled="disabled"><i class="fa fa-undo"></i> Undo</button>
      <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
      <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-thumbs-o-up"></i> Approved</button>
      <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
      <button class="btn topnavbt" id="btnDownload"><i class="fa fa-barcode"></i> Download</button>
      <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
    </div>
  </div>
</div>

<form id="transaction_form" onsubmit="return validateForm()"  method="POST" class="needs-validation"  >  
  <?php echo csrf_field(); ?>
  <div class="container-fluid filter">
	  <div class="inner-form">
     
      <div class="row">
        <div class="col-lg-2" style="margin-left:20px;">Select/Deselect All</div>
        <div class="col-lg-1"><input type="checkbox" id="select_all" /> </div>
      </div>

      <div class="row main-box">
      <?php 
      if(isset($objMATDetail) && !empty($objMATDetail)){
      foreach($objMATDetail as $index=>$row_data){
      ?>
      <div class="col-lg-6">
        <div class="sub-box">
          <input type="checkbox" name="selectAll[]" value="<?php echo e($row_data->BRC_BRCID); ?>" class="checkbox" >
          <div class="row sub-box-contant">
            <div class="col-lg-12">
              <?php
              $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
              echo $generator->getBarcode($row_data->SERIALNUMBER, $generator::TYPE_CODE_128);
              ?>
            </div>
            
            <div class="col-lg-12" style="margin-top:20px;"><label>Serial No:</label> <?php echo e($row_data->SERIALNUMBER); ?></div>
            <div class="col-lg-12"><label>Item Code:</label> <?php echo e($row_data->ICODE); ?></div>
            <div class="col-lg-12"><label>Item Name:</label> <?php echo e($row_data->ITEM_NAME); ?></div>
            <div class="col-lg-12"><label>Item Group:</label> <?php echo e($row_data->GROUPNAME); ?></div>

          </div>
        </div>
      </div>
      <?php 
      }}
      ?>
      </div>

    </div>
  </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('alert'); ?>
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
          <button class="btn alertbt" name='YesBtn' id="YesBtn" data-funcname="fnSaveData"><div id="alert-active" class="activeYes"></div>Yes</button>
          <button class="btn alertbt" name='NoBtn' id="NoBtn"   data-funcname="fnUndoNo" ><div id="alert-active" class="activeNo"></div>No</button>
          <button class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;"><div id="alert-active" class="activeOk"></div>OK</button>
          <button class="btn alertbt" name='OkBtn1' id="OkBtn1" style="display:none;margin-left: 90px;" onclick="getFocus()"><div id="alert-active" class="activeOk1"></div>OK</button>
          <input type="hidden" id="FocusId" >
        </div>
		    <div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('bottom-css'); ?>
<style>
.main-box {
  padding: 1rem;
  max-width: 100%;
  max-height: 500px;
  overflow-y: auto;
  scrollbar-gutter: stable;
  border:2px solid gray;
  border-radius:4px;
  margin:20px;
  padding:20px;
}
.sub-box {
  height:auto;
  border:1px solid gray;
  border-radius:5px;
  margin:10px;
  padding:10px;
}
.sub-box-contant {
  margin:5px;
  padding:5px;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('bottom-scripts'); ?>
<script>
/*================================== BUTTON FUNCTION ================================*/
$('#btnAdd').on('click', function() {
  var viewURL = '<?php echo e(route("transaction",[$FormId,"add"])); ?>';
  window.location.href=viewURL;
});

$('#btnExit').on('click', function() {
  var viewURL = '<?php echo e(route('home')); ?>';
  window.location.href=viewURL;
});

$("#btnUndo").on("click", function() {
  $("#AlertMessage").text("Do you want to erase entered information in this record?");
  $("#alert").modal('show');
  $("#YesBtn").data("funcname","fnUndoYes");
  $("#YesBtn").show();
  $("#NoBtn").data("funcname","fnUndoNo");
  $("#NoBtn").show();    
  $("#OkBtn").hide();
  $("#NoBtn").focus();
});

window.fnUndoYes = function (){
  window.location.reload();
}

$("#YesBtn").click(function(){
  $("#alert").modal('hide');
  var customFnName = $("#YesBtn").data("funcname");
  window[customFnName]();
});

$("#NoBtn").click(function(){
  $("#alert").modal('hide');
  $("#LABEL").focus();
});

$("#OkBtn").click(function(){
  $("#alert").modal('hide');
  $("#YesBtn").show();
  $("#NoBtn").show();
  $("#OkBtn").hide();
  $(".text-danger").hide();
  window.location.href = '<?php echo e(route("transaction",[$FormId,"index"])); ?>';
});

$("#OkBtn1").click(function(){
  $("#alert").modal('hide');
  $("#YesBtn").show();
  $("#NoBtn").show();
  $("#OkBtn").hide();
  $("#OkBtn1").hide();
  $("#"+$(this).data('focusname')).focus();
  $(".text-danger").hide();
});

function showError(pId,pVal){
  $("#"+pId+"").text(pVal);
  $("#"+pId+"").show();
}

function getFocus(){
  $("#"+$("#FocusId").val()).focus();
  $("#closePopup").click();
}

function highlighFocusBtn(pclass){
  $(".activeYes").hide();
  $(".activeNo").hide();
  $("."+pclass+"").show();
}

$(document).ready(function(){
    $("#select_all").change(function(){  //"select all" change
        $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
    });

    //".checkbox" change
    $('.checkbox').change(function(){
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(false == $(this).prop("checked")){ //if this item is unchecked
            $("#select_all").prop('checked', false); //change "select all" checked status to false
        }
        //check "select all" if all checkbox items are checked
        if ($('.checkbox:checked').length == $('.checkbox').length ){
            $("#select_all").prop('checked', true);
        }
    });
});

$("#btnDownload").click(function() {
  var formReqData = $("#transaction_form");
  if(formReqData.valid()){
    validateForm();
  }
});

function validateForm(){

  var all_location_id = document.querySelectorAll('input[name="selectAll[]"]:checked');

  if(all_location_id.length == 0){
    $("#ProceedBtn").focus();
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Please select barcode item.');
    $("#alert").modal('show')
    $("#OkBtn1").focus();
    return false;
  }
  else{
    $("#alert").modal('show');
    $("#AlertMessage").text('Do you want to download barcode.');
    $("#YesBtn").data("funcname","fnDownloadData");     
    $("#YesBtn").focus();
    $("#OkBtn").hide();
    highlighFocusBtn('activeYes');
  }
}

window.fnDownloadData = function (){
  
  var all_location_id = document.querySelectorAll('input[name="selectAll[]"]:checked');
  var aIds = [];
  for(var x = 0, l = all_location_id.length; x < l;  x++){
    aIds.push(all_location_id[x].value);
  }

  var viewURL = '<?php echo e(route("transaction",[$FormId,"barcodepdf",":rcdId"])); ?>';
  var viewURL = viewURL.replace(":rcdId",aIds);

  window.location.href=viewURL;
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\transactions\inventory\Barcode\trnfrm418barcode.blade.php ENDPATH**/ ?>