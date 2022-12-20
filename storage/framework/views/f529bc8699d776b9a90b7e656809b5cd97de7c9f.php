

<?php $__env->startSection('content'); ?>
<!-- <form id="frm_trn_se" onsubmit="return validateForm()"  method="POST" class="needs-validation"  >     -->

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[198,'index'])); ?>" class="btn singlebt">Role Master</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSaveSE" disabled="disabled"><i class="fa fa-save" ></i> Save</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo"  disabled="disabled"><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-lock"></i> Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div><!--row-->
    </div>
<form id="frm_trn_se"  method="POST">   

    <div class="container-fluid filter">

<div class="inner-form">
    <div class="row">
			<div class="col-lg-1 pl"><p>Role Code</p></div>
			<div class="col-lg-1 pl">
        <input type="text" name="RCODE" id="RCODE" disabled  class="form-control mandatory" value="<?php echo e($objSE->RCODE); ?>"  autocomplete="off" readonly style="text-transform:uppercase" autofocus >
     	</div>
			
			<div class="col-lg-1 pl col-md-offset-1"><p>Description</p></div>
			<div class="col-lg-3 pl">
   
                <input type="text" name="DESCRIPTIONS" id="DESCRIPTIONS" value="<?php echo e($objSE->DESCRIPTIONS); ?>" disabled class="form-control" autocomplete="off" />
                <span class="text-danger" id="ERROR_DESCRIPTIONS"></span> 

            </div>
			</div>
		</div>

    <div class="row">
      <div class="col-lg-1"><p>Module Name </p></div>  
      <div class="col-lg-11">
        <ul >
            <?php $__currentLoopData = $ModuleList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod_row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <?php
                if(in_array($mod_row->MODULEID_REF,$SavedModArr)){ 
                    $strchk = "checked";
                  }else{
                    $strchk = "";                    
                  }                 
             ?>
            <li style="list-style: none; padding: 6px 0; display: inline-table;padding-right: 15px;"><input disabled style="margin-right: 5px;" type="checkbox" name="MODULE_NAME_<?php echo e($mod_row->MODULEID_REF); ?>"  id="MODULE_NAME_<?php echo e($mod_row->MODULEID_REF); ?>" value="<?php echo e($mod_row->MODULEID_REF); ?>" <?php echo $strchk; ?> ><?php echo e($mod_row->MODULENAME); ?> </li>     
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul> 
      </div>       
    </div>  

    <div class="row" style="margin-left: 1px;">
      <div class="col-lg-2 pl"><p>De-Activated</p></div>
      <div class="col-lg-1 pl pr">
      <input disabled type="checkbox"   name="DEACTIVATED"  id="deactive-checkbox_0" <?php echo e($objSE->DEACTIVATED == 1 ? "checked" : ""); ?>

        value='<?php echo e($objSE->DEACTIVATED == 1 ? 1 : 0); ?>' tabindex="2"  >
      </div>
      
      <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
      <div class="col-lg-2 pl">
        <input disabled type="date" name="DODEACTIVATED" class="form-control" id="DODEACTIVATED" <?php echo e($objSE->DEACTIVATED == 1 ? "" : "disabled"); ?> value="<?php echo e(isset($objSE->DODEACTIVATED) && $objSE->DODEACTIVATED !="" && $objSE->DODEACTIVATED !="1900-01-01" ? $objSE->DODEACTIVATED:''); ?>" tabindex="3" placeholder="dd/mm/yyyy"  />
      </div>
    </div>

</div>

<div class="container-fluid">
  <div class="row">
    <div class="tab-content">
                              <div id="Material" class="tab-pane fade in active">
                                  <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:450px;margin-top:10px;" >
                                  <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                                          <thead id="thead1"  style="position: sticky;top: 0">
                                                  <tr>
                                                        <th>Module Name</th> 
                                                        <th>Voucher Type Code <input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1"> </th>
                                                        <th>Voucher Description</th>
                                                        <th>Add</th>
                                                        <th>Edit</th>
                                                        <th>Cancel</th>
                                                        <th>View</th>
                                                        <th>Approval 1</th>
                                                        <th>Approval 2</th>
                                                        <th>Approval 3</th>
                                                        <th>Approval 4</th>
                                                        <th>Approval 5</th>
                                                        <th>Print</th>
                                                        <th>Attachment</th>
                                                        <th>Amendment</th>
                                                        <th>Amount Matrix</th>
                                                  </tr>
                                          </thead>
                                          <tbody>
                                          <?php if(!empty($objSEMAT)): ?>
                                <?php $__currentLoopData = $objSEMAT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                <tr  class="participantRow modulename_<?php echo e($row->MODULEID); ?>">

                                  <td><input type="text" name="MODULENAME_<?php echo e($row->VTID_REF); ?>" id="MODULENAME_<?php echo e($row->VTID_REF); ?>" value="<?php echo e($row->MODULENAME); ?>"  class="form-control mandatory" style="width:200px" readonly="" tabindex="1"> </td>
                                  <td ><input type="text" name="VTID_REF_POPUP_<?php echo e($row->VTID_REF); ?>" id="VTID_REF_POPUP_<?php echo e($row->VTID_REF); ?>"   value="<?php echo e($row->VCODE); ?>" class="form-control mandatory" style="width:91px" readonly="" tabindex="1"></td>
                                  <td hidden> <input type="text" name="VTID_REF_<?php echo e($row->VTID_REF); ?>" id="VTID_REF_<?php echo e($row->VTID_REF); ?>"  value="<?php echo e($row->VTID_REF); ?>"  ><input type="text" name="rowscount[]" value="<?php echo e($row->VTID_REF); ?>" /></td>
                                  <td><input type="text" name="VTID_DESCRITPIONS_<?php echo e($row->VTID_REF); ?>" id="VTID_DESCRITPIONS_<?php echo e($row->VTID_REF); ?>" value="<?php echo e($row->DESCRIPTIONS); ?>"   class="form-control mandatory" style="width:250px" readonly="" tabindex="1"></td>

                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="ADD_<?php echo e($row->VTID_REF); ?>"       id="ADD_<?php echo e($row->VTID_REF); ?>"       <?php echo e($row->ADD == 1 ? 'checked' : ''); ?> ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="EDIT_<?php echo e($row->VTID_REF); ?>"      id="EDIT_<?php echo e($row->VTID_REF); ?>"      <?php echo e($row->EDIT == 1 ? 'checked' : ''); ?> ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox"  name="CANCEL_<?php echo e($row->VTID_REF); ?>"    id="CANCEL_<?php echo e($row->VTID_REF); ?>"    <?php echo e($row->CANCEL == 1 ? 'checked' : ''); ?>  ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="VIEW_<?php echo e($row->VTID_REF); ?>"      id="VIEW_<?php echo e($row->VTID_REF); ?>"      <?php echo e($row->VIEW == 1 ? 'checked' : ''); ?> ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="APPROVAL1_<?php echo e($row->VTID_REF); ?>" id="APPROVAL1_<?php echo e($row->VTID_REF); ?>" <?php echo e($row->APPROVAL1 == 1 ? 'checked' : ''); ?>  ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="APPROVAL2_<?php echo e($row->VTID_REF); ?>" id="APPROVAL2_<?php echo e($row->VTID_REF); ?>" <?php echo e($row->APPROVAL2 == 1 ? 'checked' : ''); ?>   ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="APPROVAL3_<?php echo e($row->VTID_REF); ?>" id="APPROVAL3_<?php echo e($row->VTID_REF); ?>" <?php echo e($row->APPROVAL3 == 1 ? 'checked' : ''); ?>  ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="APPROVAL4_<?php echo e($row->VTID_REF); ?>" id="APPROVAL4_<?php echo e($row->VTID_REF); ?>" <?php echo e($row->APPROVAL4 == 1 ? 'checked' : ''); ?>  ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="APPROVAL5_<?php echo e($row->VTID_REF); ?>" id="APPROVAL5_<?php echo e($row->VTID_REF); ?>" <?php echo e($row->APPROVAL5 == 1 ? 'checked' : ''); ?>  ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="PRINT_<?php echo e($row->VTID_REF); ?>"      id="PRINT_<?php echo e($row->VTID_REF); ?>"     <?php echo e($row->PRINT == 1 ? 'checked' : ''); ?>  ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="ATTACHMENT_<?php echo e($row->VTID_REF); ?>" id="ATTACHMENT_<?php echo e($row->VTID_REF); ?>" <?php echo e($row->ATTECHMENT == 1 ? 'checked' : ''); ?>   ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="AMENDMENT_<?php echo e($row->VTID_REF); ?>"  id="AMENDMENT_<?php echo e($row->VTID_REF); ?>"  <?php echo e($row->AMENDMENT == 1 ? 'checked' : ''); ?> ></td>
                                  <td style="text-align:center; width: 81px;"><input disabled type="checkbox" name="AMOUNTMATRIX_<?php echo e($row->VTID_REF); ?>" id="AMOUNTMATRIX_<?php echo e($row->VTID_REF); ?>" <?php echo e($row->AMOUNT_MATRIX == 1 ? 'checked' : ''); ?>  ></td>
                                             
                                 </tr>              
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            <?php endif; ?>
                                          </tbody>
                                  </table>
                                  </div>	
                              </div>
                          </div>
                      </div>
  </div>
</div>

</div>
<!-- </div> -->
</form>
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
#custom_dropdown, #udfforsemst_filter {
    display: inline-table;
    margin-left: 15px;
}
.dataTables_wrapper .row:nth-child(1) .col-sm-6:nth-child(2){text-align:right;}
#filtercolumn{color: #ecd178;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    }



</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('bottom-scripts'); ?>
<script>


     
$(document).ready(function(e) {



$('#btnAdd').on('click', function() {
  var viewURL = '<?php echo e(route("master",[198,"add"])); ?>';
              window.location.href=viewURL;
});

$('#btnExit').on('click', function() {
  var viewURL = '<?php echo e(route('home')); ?>';
              window.location.href=viewURL;
});



});
</script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('bottom-scripts'); ?>
<script>

//no button
$("#NoBtn").click(function(){
    $("#alert").modal('hide');
    $("#LABEL").focus();
});

//ok button
$("#OkBtn").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $(".text-danger").hide();
    window.location.href = '<?php echo e(route("master",[198,"index"])); ?>';
});

$("#OkBtn1").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $("#OkBtn1").hide();
    $("#"+$(this).data('focusname')).focus();
    // $("[id*=txtlabel]").focus();
    $(".text-danger").hide();
});

//
function showError(pId,pVal){
    $("#"+pId+"").text(pVal);
    $("#"+pId+"").show();
}
function getFocus(){
    var FocusId=$("#FocusId").val();
    $("#"+FocusId).focus();
    $("#closePopup").click();
}
function highlighFocusBtn(pclass){
       $(".activeYes").hide();
       $(".activeNo").hide();
       
       $("."+pclass+"").show();
    }

</script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Common\RoleMaster\mstfrm198view.blade.php ENDPATH**/ ?>