

<?php $__env->startSection('content'); ?>
<!-- <form id="frm_rpt_pop" onsubmit="return validateForm()"  method="POST" class="needs-validation"  >     -->

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('report',[268,'index'])); ?>" class="btn singlebt">Purchase Order Print</a>
                </div><!--col-2-->
                <div class="col-lg-10 topnav-pd">
                       
                </div>
            </div>
    </div><!--topnav-->	
    <!-- multiple table-responsive table-wrapper-scroll-y my-custom-scrollbar -->
    <div class="container-fluid purchase-order-view">
        <form id="frm_rpt_pop"  method="POST">   
            <?php echo csrf_field(); ?>
            <!-- <?php echo e(isset($objSO->SOID[0]) ? method_field('PUT') : ''); ?> -->
            <div class="container-fluid filter">

                    <div class="inner-form">
                        <div class="row">
                            <div class="col-lg-3 pl"><p>Purchase Order Number</p></div>
                            <div class="col-lg-3 pl">
                                <select name="PO_NO" id="PO_NO" class="form-control mandatory">
                                    <option value="">select</option>
                                    <?php $__currentLoopData = $ObjPO; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$Row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($Row->POID); ?>" ><?php echo e($Row->PO_NO); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="inner-form">
                        <div class="row"> </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-4 pl text-center">
                            <button style="display:none"  class="btn topnavbt buttonload" disabled> <i class="fa fa-refresh fa-spin"></i><?php echo e(Session::get('report_button')); ?></button>
                                <button class="btn topnavbt" id="btnView" <?php echo e($objRights->VIEW != 1 ? 'disabled' : ''); ?>><i class="fa fa-eye"></i> View</button>
                                <input type="hidden" id="Flag" name="Flag" />
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                    </div>
                    <div class="inner-form">
                        <div class="row">
                            <div class="frame-container col-lg-12 pl text-center" >
                                <button class="iframe-button3" id="btnPrint">
                                    Print
                                </button>
                                <button class="iframe-button" id="btnPdf">
                                    Export to PDF
                                </button>
                                <button class="iframe-button2" id="btnExcel">
                                    Export to Excel
                                </button>
                                <iframe id="iframe_rpt" width="100%" height="1000" >
                                </iframe>
                            </div>
                        </div>
                    </div>

                </div>
        </form>
    </div><!--purchase-order-view-->

<!-- </div> -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('alert'); ?>
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
            <button class="btn alertbt" name='OkBtn1' id="OkBtn1" style="display:none;margin-left: 90px;">
            <div id="alert-active" class="activeOk1"></div>OK</button>
        </div><!--btdiv-->
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<!-- Alert -->



<?php $__env->stopSection(); ?>


<?php $__env->startPush('bottom-css'); ?>
<style>
.topnavbt {
    margin-left: 312px !important;
}
.dropdown-toggle{
    height: 30px;
    width: 320px !important;
    border: 2px !important;
    color: black !important;
    font-size: 14px;
    font-weight: 500;
}

.frame-container {
  position: relative;
}
.iframe-button {
  display: none;
  position: absolute;
  top: 15px;
  left: 950px;
  width:150px;
}
.iframe-button2 {
  display: none;
  position: absolute;
  top: 15px;
  left: 1125px;
  width:150px;
}
.iframe-button3 {
  display: none;
  position: absolute;
  top: 15px;
  left: 875px;
  width:50px;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('bottom-scripts'); ?>
<script>



$(document).ready(function(e) {
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
      //reload form
      window.location.reload();
   }//fnUndoYes

   window.fnUndoNo = function (){
      $("#PO_NO").focus();
   }//fnUndoNo

   $('#btnPdf').on('click', function() {
    $('#Flag').val('P');
    var trnsoForm = $("#frm_rpt_pop");
    var formData = trnsoForm.serialize();
    var consultURL = '<?php echo e(route("report",[268,"ViewReport",":rcdId"])); ?>';
    consultURL = consultURL.replace(":rcdId",formData);
    window.location.href=consultURL;
    event.preventDefault();
}); 

$('#btnExcel').on('click', function() {
    $('#Flag').val('E');
    var trnsoForm = $("#frm_rpt_pop");
    var formData = trnsoForm.serialize();
    var consultURL = '<?php echo e(route("report",[268,"ViewReport",":rcdId"])); ?>';
    consultURL = consultURL.replace(":rcdId",formData);
    window.location.href=consultURL;
    event.preventDefault();
});

$('#btnView').on('click', function() {
        var PO_NO = $("#PO_NO").val();
        if(PO_NO  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Purchase Order.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else
        {
            $('#Flag').val('H');
            var trnsoForm = $("#frm_rpt_pop");
            var formData = trnsoForm.serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#btnView").hide();               
            $(".buttonload").show();
            $.ajax({
                url:'<?php echo e(route("report",[268,"ViewReport"])); ?>',
                type:'POST',
                data:formData,
                success:function(data) {
                    $("#btnView").show();               
                    $(".buttonload").hide();
                    var localS = data;
                    document.getElementById('iframe_rpt').src = "data:text/html;charset=utf-8," + escape(localS);
                    $('#btnPdf').show();
                    $('#btnExcel').show();
                    $('#btnPrint').show();
                },
                error:function(data){
                    $("#btnView").show();               
                    $(".buttonload").hide();
                    console.log("Error: Something went wrong.");
                    var localS = "";
                    document.getElementById('iframe_rpt').src = "data:text/html;charset=utf-8," + escape(localS);
                    $('#btnPdf').hide();
                    $('#btnExcel').hide();
                    $('#btnPrint').hide();
                },
            });
            event.preventDefault();
        }
  });
  $("#OkBtn1").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $("#OkBtn1").hide();
    $(".text-danger").hide();
});

});

</script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\reports\purchase\PurchaseOrderPrint\rptfrm268.blade.php ENDPATH**/ ?>