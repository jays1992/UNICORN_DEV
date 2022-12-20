

<?php $__env->startSection('content'); ?>
<!-- <form id="frm_rpt_sislw" onsubmit="return validateForm()"  method="POST" class="needs-validation"  >     -->

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-3">
                <a href="<?php echo e(route('report',[255,'index'])); ?>" class="btn singlebt">Sales Quotation Register</a>
                </div><!--col-2-->
                <div class="col-lg-10 topnav-pd">
                       
                </div>
            </div>
    </div><!--topnav-->	
    <!-- multiple table-responsive table-wrapper-scroll-y my-custom-scrollbar -->
    <div class="container-fluid purchase-order-view">
        <form id="frm_rpt_sqs"  method="POST">   
            <?php echo csrf_field(); ?>
            <div class="container-fluid filter">

                    <div class="inner-form">
                        <div class="row">
                            <div class="col-lg-3 pl"><p>From Date</p></div>
                            <div class="col-lg-3 pl">
                                <input type="date" name="From_Date" id="From_Date" value="<?php echo e(old('From_Date')); ?>" class="form-control mandatory"  placeholder="dd/mm/yyyy" />
                            </div>
                            <div class="col-lg-3 pl"><p>To Date</p></div>
                            <div class="col-lg-3 pl">
                                <input type="date" name="To_Date" id="To_Date" value="<?php echo e(old('To_Date')); ?>" class="form-control mandatory"  placeholder="dd/mm/yyyy" />
                            </div>                                                       
                        </div>
                        <div class="row"> 
                            <div class="col-lg-3 pl"><p>Branch Group</p></div>
                            <div class="col-lg-3 pl">
                                <select name="BranchGroup[]" data-hide-disabled="hide" multiple data-actions-box="true" id="BranchGroup"  class="form-control selectpicker" multiple data-live-search="true"  >
                                    <?php $__currentLoopData = $objBranchGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bgindex=>$bgRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($bgRow->BGID); ?>" selected><?php echo e($bgRow->BG_CODE); ?>-<?php echo e($bgRow->BG_DESC); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>                            
                            <div class="col-lg-3 pl"><p>Branch Name</p></div>
                            <div class="col-lg-3 pl">
                                <select name="BranchName[]" data-hide-disabled="hide" multiple data-actions-box="true" id="BranchName"  class="form-control selectpicker" multiple data-live-search="true"  >
                                    <?php $__currentLoopData = $objBranch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bindex=>$bRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($bRow->BRID); ?>" selected><?php echo e($bRow->BRCODE); ?>-<?php echo e($bRow->BRNAME); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div> 
                        </div>
                        <div class="row"> 
                            <div class="col-lg-3 pl"><p>Customer</p></div>
                            <div class="col-lg-3 pl" id="div_cust">
                                <select name="SGLID[]" id="SGLID" data-hide-disabled="hide" multiple data-actions-box="true" class="form-control selectpicker" multiple data-live-search="true"  >
                                <?php $__currentLoopData = $objSubGL; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cindex=>$cRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cRow->SGLID); ?>" selected><?php echo e($cRow->SGLCODE); ?>-<?php echo e($cRow->SLNAME); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>                            
                            <div class="col-lg-3 pl"><p>Sales Quotation</p></div>
                            <div class="col-lg-3 pl" id="div_sqno">
                                <select name="SQNO[]" id="SQNO" data-hide-disabled="hide" multiple data-actions-box="true" class="form-control selectpicker" multiple data-live-search="true"  >
                                <?php $__currentLoopData = $objQuotation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Pindex=>$PRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($PRow->SQNO); ?>" selected><?php echo e($PRow->SQNO); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div> 
                        </div>
                        <div class="row">                                                  
                            <div class="col-lg-3 pl"><p>Item</p></div>
                            <div class="col-lg-3 pl" id="div_itemid">
                                <select name="ITEMID[]" id="ITEMID" data-hide-disabled="hide" multiple data-actions-box="true" class="form-control selectpicker" multiple data-live-search="true"  >
                                <?php $__currentLoopData = $objItem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Iindex=>$IRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($IRow->ITEMID); ?>" selected>
                                        <?php echo e($IRow->NAME); ?> (<?php echo e($IRow->ICODE); ?>)                                          
                                        <?php if($company_check=='show'): ?>
                                        <?php echo e($IRow->ALPS_PART_NO!=''? '-'.$IRow->ALPS_PART_NO:''); ?>  <?php echo e($IRow->BUNAME!=''? '-'.$IRow->BUNAME:''); ?> 
                                        <?php endif; ?>                                    
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div> 
                            <div class="col-lg-3 pl"><p>Status</p></div>
                            <div class="col-lg-3 pl">
                                <select name="STATUS" id="STATUS" class="form-control selectpicker">
                                    <option value="A" selected>Approved</option>
                                    <option value="N" >Not Approved</option>
                                    <option value="C" >Cancelled</option>
                                    <option value="R" >Closed</option>
                                </select>
                            </div> 
                        </div>       
                        <div class="row"> 
                        <div class="col-lg-3 pl"><p>Quantity</p></div>
                            <div class="col-lg-3 pl">
                                <select name="Quantity" id="Quantity" class="form-control selectpicker" >
                                    <option value="All" selected>All </option>
                                    <option value="Consumed" >Consumed</option>
                                    <option value="Pending" >Pending</option>                                 
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
                                <iframe id="iframe_rpt" width="100%" height="1500" >
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
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
	
	var d = new Date(); 
    var today = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;
    d.setDate(d.getDate() + 29);
    var todate = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;

	
	var date = new Date();
	var firstDay = date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ('01').slice(-2) ;
	$('#From_Date').val(firstDay);
    $('#To_Date').val(today);

    window.fnUndoYes = function (){
      //reload form
      window.location.reload();
   }//fnUndoYes

   window.fnUndoNo = function (){
      $("#From_Date").focus();
   }//fnUndoNo

// 



$('#btnPdf').on('click', function() {
    $('#Flag').val('P');
    var Flag = $('#Flag').val();
    var formData = 'Flag='+ Flag;
    var consultURL = '<?php echo e(route("report",[255,"ViewReport",":rcdId"])); ?>';
    consultURL = consultURL.replace(":rcdId",formData);
    window.location.href=consultURL;
    event.preventDefault();
}); 

$('#btnExcel').on('click', function() {
    $('#Flag').val('E');
    var Flag = $('#Flag').val();
    var formData = 'Flag='+ Flag;
    var consultURL = '<?php echo e(route("report",[255,"ViewReport",":rcdId"])); ?>';
    consultURL = consultURL.replace(":rcdId",formData);
    window.location.href=consultURL;
    event.preventDefault();
});

$('#btnView').on('click', function() {
        var From_Date       = $('#From_Date').val();
        var To_Date         = $('#To_Date').val();
        var BranchGroup = [];
        $("select[name='BranchGroup[]']").each(function() {
            var value = $(this).val();
            if (value) {
                BranchGroup.push(value);
            }
        });

        var BranchName = [];
        $("select[name='BranchName[]']").each(function() {
            var value2 = $(this).val();
            if (value2) {
                BranchName.push(value2);
            }
        });
        
        var SGLID = [];
        $("select[name='SGLID[]']").each(function() {
            var value3 = $(this).val();
            if (value3) {
                SGLID.push(value3);
            }
        });

        var SQNO  = [];
        $("select[name='SQNO[]']").each(function() {
            var value4 = $(this).val();
            if (value4) {
                SQNO.push(value4);
            }
        });

        var ITEMID  = [];
        $("select[name='ITEMID[]']").each(function() {
            var value6 = $(this).val();
            if (value6) {
                ITEMID.push(value6);
            }
        });

        if(From_Date ==="")
        {
            $("#FocusId").val($("#From_Date"));
            $("#From_Date").val('');
            $("#ProceedBtn").focus();
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select From Date.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(To_Date ==="")
        {
            $("#FocusId").val($("#To_Date"));
            $("#To_Date").val('');
            $("#ProceedBtn").focus();
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select To Date.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(BranchGroup  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Branch Group.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(BranchName  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Branch.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(SGLID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Customer.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(SQNO  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Sales Quotation.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(ITEMID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Item.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else{
            $('#Flag').val('H');
            var trnsoForm = $("#frm_rpt_sqs");
            var formData = trnsoForm.serialize();
            // var consultURL = '<?php echo e(route("report",[255,"ViewReport",":rcdId"])); ?>';
            // // var formdata = {'SONO': SONO};
            // consultURL = consultURL.replace(":rcdId",formData);
            // window.location.href=consultURL;
            // event.preventDefault();

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#btnView").hide();               
                $(".buttonload").show();
                $.ajax({
                    url:'<?php echo e(route("report",[255,"ViewReport"])); ?>',
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\reports\sales\SalesQuotationRegister\rptfrm255.blade.php ENDPATH**/ ?>