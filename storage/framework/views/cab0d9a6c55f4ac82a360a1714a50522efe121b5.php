<?php $__env->startSection('content'); ?>
<!-- <form id="frm_trn_so" onsubmit="return validateForm()"  method="POST" class="needs-validation"  >     -->

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[$FormId,'index'])); ?>" class="btn singlebt">Entitlement Master</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button class="btn topnavbt" id="btnAdd"      disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit"     disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSaveSO"   disabled="disabled" ><i class="fa fa-floppy-o"></i> Save</button>
                        <button class="btn topnavbt" id="btnView"     disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint"    disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo"     disabled="disabled" ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel"   disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove"  disabled="disabled"><i class="fa fa-thumbs-o-up"></i> Approved</button>
                        <button class="btn topnavbt"  id="btnAttach"  disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div>
    </div><!--topnav-->	
   

    <div class="container-fluid purchase-order-view filter">     
 
<div class="container-fluid purchase-order-view filter">     
  <form id="frm_mst_view" method="POST"  > 
    <?php echo csrf_field(); ?>
    <div class="inner-form">
        
      <div class="row">
        <div class="col-lg-2 pl"><p>Document No</p></div> 
        <div class="col-lg-2 pl">
          <input type="text" name="ENTITLEMENT_NO" id="ENTITLEMENT_NO" value="<?php echo e(isset($HDR->ENTITLEMENT_NO)?$HDR->ENTITLEMENT_NO:''); ?>" class="form-control mandatory"  autocomplete="off" <?php echo e($ActionStatus); ?> readonly style="text-transform:uppercase"> 
        </div>
        
        <div class="col-lg-2 pl"><p>Document Date</p></div>
        <div class="col-lg-2 pl">
          <input type="date" name="ENTITLEMENT_DT" id="ENTITLEMENT_DT" value="<?php echo e(isset($HDR->ENTITLEMENT_DT)?$HDR->ENTITLEMENT_DT:''); ?>" <?php echo e($ActionStatus); ?>   class="form-control mandatory" autocomplete="off" >
        </div>
      </div>


      <div class="row">
         <div class="col-lg-2 pl"><p>Employee Code</p></div>
         <div class="col-lg-2 pl">
              <input type="text" <?php echo e($ActionStatus); ?>  name="Machinepopup" id="txtEmployeepopup" class="form-control mandatory" value="<?php echo e(isset($objEmployee->EMPCODE)?$objEmployee->EMPCODE:''); ?>"  autocomplete="off"  readonly/>
              <input type="hidden" name="EMPID_REF" id="EMPID_REF" class="form-control" autocomplete="off" value="<?php echo e(isset($HDR->EMPID_REF)?$HDR->EMPID_REF:''); ?>" />  
        </div>

      <div class="col-lg-2 pl"><p>Name</p></div>
          <div class="col-lg-2 pl">
              <input type="text" <?php echo e($ActionStatus); ?>  name="EMP_DESC" id="EMP_DESC" class="form-control mandatory" value="<?php echo e(isset($objEmployee->FNAME)?$objEmployee->FNAME:''); ?>"  readonly maxlength="200"  />
          </div>
     </div>

      <div class="row">
      <div class="col-lg-2 pl"><p>Department</p></div>
        <div class="col-lg-2 pl">
            <input type="text" <?php echo e($ActionStatus); ?>  name="DEPARTMENT_NAME" id="DEPARTMENT_NAME" class="form-control mandatory" value="<?php echo e(isset($objEmployee->DCODE)?$objEmployee->DCODE:''); ?> <?php echo e(isset($objEmployee->NAME)?'-'.$objEmployee->NAME:''); ?>" autocomplete="off"  readonly/>
            <input type="hidden" name="DEPID_REF" id="DEPID_REF" class="form-control" value="<?php echo e(isset($objEmployee->DEPID)?$objEmployee->DEPID:''); ?>" autocomplete="off" />      
        </div>
        <div class="col-lg-2 pl"><p>Division</p></div>
          <div class="col-lg-2 pl">
            <input type="text" <?php echo e($ActionStatus); ?>  name="DIVNAME" id="DIVNAME" class="form-control mandatory" value="<?php echo e(isset($objEmployee->DIVCODE)?$objEmployee->DIVCODE:''); ?><?php echo e(isset($objEmployee->DIV_NAME)?'-'.$objEmployee->DIV_NAME:''); ?>" readonly maxlength="200"  />
            <input type="hidden" name="DIVID_REF" id="DIVID_REF" class="form-control" value="<?php echo e(isset($objEmployee->DIVID)?$objEmployee->DIVID:''); ?>" autocomplete="off" />  
          </div>
      </div>

        <div class="row">
          <div class="col-lg-2 pl"><p>Designation</p></div>
            <div class="col-lg-2 pl">
                      <input type="text" <?php echo e($ActionStatus); ?>  name="DESIGNATION" id="DESIGNATION" class="form-control mandatory" value="<?php echo e(isset($objEmployee->DESGCODE)?$objEmployee->DESGCODE:''); ?> <?php echo e(isset($objEmployee->DESCRIPTIONS)?'-'.$objEmployee->DESCRIPTIONS:''); ?>"  autocomplete="off"  readonly/>
                        <input type="hidden" name="DESIGID_REF" id="DESIGID_REF" value="<?php echo e(isset($objEmployee->DESGID)?$objEmployee->DESGID:''); ?>" class="form-control" autocomplete="off" />      
            </div>
          <div class="col-lg-2 pl"><p>Employee Type</p></div>
            <div class="col-lg-2 pl">

              <input type="text" <?php echo e($ActionStatus); ?>  name="EMPLOYEE_TYPE" id="EMPLOYEE_TYPE" class="form-control mandatory" value="<?php echo e(isset($objEmployee->ECODE)?$objEmployee->ECODE:''); ?> <?php echo e(isset($objEmployee->EMPLOYEE_TYPE)?'-'.$objEmployee->EMPLOYEE_TYPE:''); ?>" readonly maxlength="200"  />
              <input type="hidden" name="ETYPEID_REF" id="ETYPEID_REF" value="<?php echo e(isset($objEmployee->ETYPEID)?$objEmployee->ETYPEID:''); ?>" class="form-control" autocomplete="off" />    

            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 pl"><p>Announcement Period</p></div>
              <div class="col-lg-2 pl">
              <input type="text" <?php echo e($ActionStatus); ?>  name="PERIOD_popup_REF1" id="PERIOD_popup_REF1" class="form-control mandatory" value="<?php echo e(isset($HDR->PERIOD_CODE1)?$HDR->PERIOD_CODE1:''); ?>" onclick="get_period('PERIOD_REF1');" autocomplete="off"  readonly/>
                <input type="hidden" name="PERIOD_REF1" id="PERIOD_REF1" value="<?php echo e(isset($HDR->ANNOUNCEMENT_PAYPERIODID_REF)?$HDR->ANNOUNCEMENT_PAYPERIODID_REF:''); ?>" class="form-control" autocomplete="off" />
               </div>
            <div class="col-lg-2 pl"><p>Description</p></div>
              <div class="col-lg-2 pl">
                <input type="text" <?php echo e($ActionStatus); ?>  name="PERIOD_DESC_REF1" id="PERIOD_DESC_REF1" class="form-control mandatory" value="<?php echo e(isset($HDR->PERIOD_DESC1)?$HDR->PERIOD_DESC1:''); ?>" readonly maxlength="200"  />
              </div>
        </div>

      <div class="row">
          <div class="col-lg-2 pl"><p>Entitlement Period</p></div> 
            <div class="col-lg-2 pl">
            <input type="text" <?php echo e($ActionStatus); ?>  name="PERIOD_popup_REF2" id="PERIOD_popup_REF2" class="form-control mandatory" value="<?php echo e(isset($HDR->PERIOD_CODE2)?$HDR->PERIOD_CODE2:''); ?>" onclick="get_period('PERIOD_REF2');" autocomplete="off"  readonly/>
              <input type="hidden" name="PERIOD_REF2" id="PERIOD_REF2" value="<?php echo e(isset($HDR->ENTITLEMENT_PAYPERIODID_REF)?$HDR->ENTITLEMENT_PAYPERIODID_REF:''); ?>" class="form-control" autocomplete="off" />
              </div>
          <div class="col-lg-2 pl"><p>Description</p></div>
            <div class="col-lg-2 pl">
              <input type="text" <?php echo e($ActionStatus); ?>  name="PERIOD_DESC_REF2" id="PERIOD_DESC_REF2" value="<?php echo e(isset($HDR->PERIOD_DESC2)?$HDR->PERIOD_DESC2:''); ?>" class="form-control mandatory" readonly maxlength="200"  />
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-2 pl"><p>Approval given by</p></div>
              <div class="col-lg-2 pl">        
                <input type="text" <?php echo e($ActionStatus); ?>  name="APPROVAL_GIVENBY" id="APPROVAL_GIVENBY" value="<?php echo e(isset($HDR->GIVEN_BY)?$HDR->GIVEN_BY:''); ?>" class="form-control" autocomplete="off" />       
              </div>
            <div class="col-lg-2 pl"><p>Ref No</p></div>
              <div class="col-lg-2 pl">
                <input type="text" <?php echo e($ActionStatus); ?>  name="REF_NO" id="REF_NO" class="form-control mandatory" value="<?php echo e(isset($HDR->REF_NO)?$HDR->REF_NO:''); ?>"  maxlength="200"  />
              </div>
      </div>
        
        <div class="row">
              <div class="col-lg-2 pl"><p>Salary Sturcture</p></div>
                  <div class="col-lg-2 pl">
                      <input type="text" <?php echo e($ActionStatus); ?>  name="SALARTYSTRUCTION_popup" id="txtsalarystructure_popup" value="<?php echo e(isset($HDR->SALARY_STRUC_NO)?$HDR->SALARY_STRUC_NO:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
                      <input type="hidden" name="SALARYSTRUCTUREID_REF" id="SALARYSTRUCTUREID_REF" value="<?php echo e(isset($HDR->SALARY_STRUCID_REF)?$HDR->SALARY_STRUCID_REF:''); ?>" class="form-control" autocomplete="off" />
                  </div>
                  <div class="col-lg-2 pl"><p>Description</p></div>
                  <div class="col-lg-2 pl">
                        <input type="text" <?php echo e($ActionStatus); ?>  name="SALARY_DESC" id="SALARY_DESC" class="form-control mandatory" value="<?php echo e(isset($HDR->SALARY_STRUC_DESC)?$HDR->SALARY_STRUC_DESC:''); ?>" readonly maxlength="200"  />
                  </div>
        </div>


      <div class="row">
        <div class="col-lg-2 pl"><p>De-Activated</p></div>
        <div class="col-lg-2 pl pr">
        <input type="checkbox" <?php echo e($ActionStatus); ?>    name="DEACTIVATED"  id="deactive-checkbox_0" <?php echo e(isset($HDR->DEACTIVATED) && $HDR->DEACTIVATED == 1 ? "checked" : ""); ?> value='<?php echo e(isset($HDR->DEACTIVATED) && $HDR->DEACTIVATED == 1 ? 1 : 0); ?>' tabindex="2"  >
        </div>
        
        <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
        <div class="col-lg-2 pl">
          <input type="date" <?php echo e($ActionStatus); ?>  name="DODEACTIVATED" class="form-control" id="DODEACTIVATED" <?php echo e(isset($HDR->DEACTIVATED) && $HDR->DEACTIVATED == 1 ? "" : "disabled"); ?> value="<?php echo e(isset($HDR->DODEACTIVATED) && $HDR->DODEACTIVATED !="" && $HDR->DODEACTIVATED !="1900-01-01" ? $HDR->DODEACTIVATED:''); ?>" tabindex="3" placeholder="dd/mm/yyyy"  />
        </div>
      </div>

    </div>

    <div class="container-fluid purchase-order-view">
      <div class="row">

        <ul class="nav nav-tabs">
           <li class="active"><a data-toggle="tab" href="#EarningHead">Earning/Deduction Head</a></li>
        </ul>  
         
        <div class="tab-content">

          <div id="EarningHead" class="tab-pane fade in active">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"  >
              <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                <thead id="thead1"  style="position: sticky;top: 0"> 

                  <tr>
                    <th>Earning/Deduction Type</th>
                    <th>Earning/Deduction Code</th>
                    <th>Earning/Deduction Description</th>
                    <th>Earning/Deduction Head Type</th>
                    <th>Sq No</th>
                    <th>Amount / Formula</th>
                    <th>Formula</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th>Action </th>
                  </tr>
                </thead>
                <tbody id="tbody_salarystructure">
                  <?php if(isset($MAT) && !empty($MAT)): ?>
                  <?php $__currentLoopData = $MAT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr  class="participantRow1">

                    <td>
                      <input type="text" <?php echo e($ActionStatus); ?>  name="HEAD_TYPE_<?php echo e($key); ?>" id="HEAD_TYPE_<?php echo e($key); ?>" value="<?php echo e(isset($row['HEAD_TYPE'])? $row['HEAD_TYPE']:''); ?>" class="form-control"  autocomplete="off" readonly >
                      <input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1" value="<?php echo e(count($MAT)); ?>">
        
                    </td>
                  
                    <td><input  type="text" <?php echo e($ActionStatus); ?>  name="EARNING_HEADID_CODE_<?php echo e($key); ?>" id="EARNING_HEADID_CODE_<?php echo e($key); ?>" value="<?php echo e(isset($row['HEADCODE'])?$row['HEADCODE']:''); ?>" class="form-control"  autocomplete="off"   readonly  /></td>
                    <td hidden><input type="text" name="EARNING_HEADID_REF_<?php echo e($key); ?>" id="EARNING_HEADID_REF_<?php echo e($key); ?>" value="<?php echo e(isset($row['EARNING_HEADID_REF'])?$row['EARNING_HEADID_REF']:''); ?>"   class="form-control"  autocomplete="off" /></td>
                    
                    <td><input type="text" <?php echo e($ActionStatus); ?>  name="EARNING_HEADID_DESC_<?php echo e($key); ?>" id="EARNING_HEADID_DESC_<?php echo e($key); ?>" value="<?php echo e(isset($row['HEADDESC'])?$row['HEADDESC']:''); ?>"  class="form-control"  autocomplete="off"  readonly /></td>

                    <td><input  type="text" <?php echo e($ActionStatus); ?>  name="EARNING_TYPEID_CODE_<?php echo e($key); ?>" id="EARNING_TYPEID_CODE_<?php echo e($key); ?>" value="<?php echo e(isset($row['TYPECODE'])?$row['TYPECODE']:''); ?> <?php echo e(isset($row['TYPEDESC'])?'-'.$row['TYPEDESC']:''); ?>" class="form-control"  autocomplete="off" readonly  /></td>
                    <td hidden><input type="text" <?php echo e($ActionStatus); ?>  name="EARNING_TYPEID_REF_<?php echo e($key); ?>" id="EARNING_TYPEID_REF_<?php echo e($key); ?>" value="<?php echo e(isset($row['EARNING_TYPEID_REF'])?$row['EARNING_TYPEID_REF']:''); ?>"   class="form-control"  autocomplete="off" /></td>

                    <td><input  type="text" <?php echo e($ActionStatus); ?>  name="SQ_NO_<?php echo e($key); ?>" id="SQ_NO_<?php echo e($key); ?>"  value="<?php echo e($key+1); ?>" class="form-control"  autocomplete="off" readonly style="width:50px;" /></td>

                    <td>
                      <input type="text" <?php echo e($ActionStatus); ?>  name="AMT_FORMULA_<?php echo e($key); ?>" id="FOR_TYPE_<?php echo e($key); ?>" readonly  value="<?php echo e(isset($row['AMT_FORMULA'])?$row['AMT_FORMULA']:''); ?>" class="form-control"  autocomplete="off"  >
               
                    </td>

                    <td><input type="text" <?php echo e($ActionStatus); ?>  name="FORMULA_<?php echo e($key); ?>" id="FORMULA_<?php echo e($key); ?>" value="<?php echo e(isset($row['FORMULA'])?$row['FORMULA']:''); ?>" class="form-control"  autocomplete="off" readonly /></td>
                    <td><input type="text" <?php echo e($ActionStatus); ?>  name="AMOUNT_<?php echo e($key); ?>" id="AMOUNT_<?php echo e($key); ?>" value="<?php echo e(isset($row['AMOUNT'])?$row['AMOUNT']:''); ?>" class="form-control"  autocomplete="off" onkeypress="return isNumberDecimalKey(event,this)" <?php echo e(isset($row['AMT_FORMULA']) && $row['AMT_FORMULA']=="AMOUNT" ?"":'readonly'); ?>  /></td>
                    <td><input type="text" <?php echo e($ActionStatus); ?>  name="REMARKS_<?php echo e($key); ?>" id="REMARKS_<?php echo e($key); ?>" value="<?php echo e(isset($row['REMARKS'])?$row['REMARKS']:''); ?>" class="form-control"  autocomplete="off"/></td>

                    <td align="center" >
                      <button class="btn add material" <?php echo e($ActionStatus); ?>  title="add" data-toggle="tooltip" type="button" ><i class="fa fa-plus"></i></button>
                      <button class="btn remove dmaterial" <?php echo e($ActionStatus); ?>  title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                    </td>

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
  </form>
</div>
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

<?php $__env->startPush('bottom-scripts'); ?>
<script>
//====================// ACTION BUTTON //====================//
$("#btnSaveFormData" ).click(function() {
  var formTrans = $("#frm_mst_view").validate();
  if(formTrans.valid()){
    validateForm("fnSaveData","update");
  }
});

$( "#btnApprove" ).click(function() {
  var formTrans = $("#frm_mst_view").validate();
  if(formTrans.valid()){
    validateForm("fnApproveData","approve");
  }
});

$("#YesBtn").click(function(){
  $("#alert").modal('hide');
  var customFnName = $("#YesBtn").data("funcname");
  window[customFnName]();
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

$("#NoBtn").click(function(){
  $("#alert").modal('hide');
});

$("#OkBtn").click(function(){
  $("#alert").modal('hide');
  $("#YesBtn").show();
  $("#NoBtn").show();
  $("#OkBtn").hide();
  $(".text-danger").hide();
  window.location.href = '<?php echo e(route("master",[$FormId,"index"])); ?>';
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
  var FocusId = $("#FocusId").val();

  $("#"+FocusId).focus();
  $("#closePopup").click();
}

function highlighFocusBtn(pclass){
  $(".activeYes").hide();
  $(".activeNo").hide();
    
  $("."+pclass+"").show();
}

function showAlert(msg){
  $("#alert").modal('show');
  $("#AlertMessage").text(msg);
  $("#YesBtn").hide(); 
  $("#NoBtn").hide();  
  $("#OkBtn1").show();
  $("#OkBtn1").focus();
  highlighFocusBtn('activeOk');
}

function showAlert(msg){
  $("#alert").modal('show');
  $("#AlertMessage").text(msg);
  $("#YesBtn").hide();
  $("#NoBtn").hide();
  $("#OkBtn1").show();
  $("#OkBtn1").focus();
  highlighFocusBtn('activeOk');
  return false;
}

//====================// ADD REMOVE //====================//
$("#EarningHead").on('click','.add', function() {
    var $tr = $(this).closest('table');
    var allTrs = $tr.find('.participantRow1').last();
    var lastTr = allTrs[allTrs.length-1];
    var $clone = $(lastTr).clone();

    $clone.find('td').each(function(){
	var el = $(this).find(':first-child');
	var id = el.attr('id') || null;
	  if(id){
		  var idLength = id.split('_').pop();
		  var i = id.substr(id.length-idLength.length);
		  var prefix = id.substr(0, (id.length-idLength.length));
		  el.attr('id', prefix+(+i+1));
	  }
	  var name = el.attr('name') || null;
	if(name){
	  var nameLength = name.split('_').pop();
	  var i = name.substr(name.length-nameLength.length);
	  var prefix1 = name.substr(0, (name.length-nameLength.length));
	  el.attr('name', prefix1+(+i+1));
	}
});

    $clone.find('input:text').val('');
    $tr.closest('table').append($clone);         
    var rowCount1 = $('#Row_Count1').val();
    rowCount1 = parseInt(rowCount1)+1;
    $('#Row_Count1').val(rowCount1);
    serialNo('EarningHead','participantRow1','SQ_NO');
    $clone.find('.remove').removeAttr('disabled');        
    
    event.preventDefault();
});

$("#EarningHead").on('click', '.remove', function() {
    var rowCount = $(this).closest('table').find('.participantRow1').length;
    if (rowCount > 1) {

        $(this).closest('.participantRow1').remove();  
        var rowCount1 = $('#Row_Count1').val();
        rowCount1 = parseInt(rowCount1)-1;
        $('#Row_Count1').val(rowCount1);
        serialNo('EarningHead','participantRow1','SQ_NO');
    } 
    if (rowCount <= 1) { 
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk1');
      
          return false;
          event.preventDefault();
    }
    event.preventDefault();
});

function serialNo(table_id,row_id,input_id){
  var i=1;
  $('#'+table_id).find('.'+row_id).each(function(){
    var TextId = $(this).find("[id*="+input_id+"]").attr('id');
    $("#"+TextId).val(i);
    i++;
  });
}

//====================// SHORTING //====================//
"use strict";
var w3 = {};
w3.getElements = function (id) {
  if (typeof id == "object") {
    return [id];
  } else {
    return document.querySelectorAll(id);
  }
};
w3.sortHTML = function(id, sel, sortvalue) {
  var a, b, i, ii, y, bytt, v1, v2, cc, j;
  a = w3.getElements(id);
  for (i = 0; i < a.length; i++) {
    for (j = 0; j < 2; j++) {
      cc = 0;
      y = 1;
      while (y == 1) {
        y = 0;
        b = a[i].querySelectorAll(sel);
        for (ii = 0; ii < (b.length - 1); ii++) {
          bytt = 0;
          if (sortvalue) {
            v1 = b[ii].querySelector(sortvalue).innerText;
            v2 = b[ii + 1].querySelector(sortvalue).innerText;
          } else {
            v1 = b[ii].innerText;
            v2 = b[ii + 1].innerText;
          }
          v1 = v1.toLowerCase();
          v2 = v2.toLowerCase();
          if ((j == 0 && (v1 > v2)) || (j == 1 && (v1 < v2))) {
            bytt = 1;
            break;
          }
        }
        if (bytt == 1) {
          b[ii].parentNode.insertBefore(b[ii + 1], b[ii]);
          y = 1;
          cc++;
        }
      }
      if (cc > 0) {break;}
    }
  }
};


function showSelectedCheck(hidden_value,selectAll){

  var divid ="";

  if(hidden_value !=""){

      var all_location_id = document.querySelectorAll('input[name="'+selectAll+'[]"]');
      
      for(var x = 0, l = all_location_id.length; x < l;  x++){
      
          var checkid=all_location_id[x].id;
          var checkval=all_location_id[x].value;
      
          if(hidden_value == checkval){
          divid = checkid;
          }

          $("#"+checkid).prop('checked', false);
          
      }
  }

  if(divid !=""){
      $("#"+divid).prop('checked', true);
  }
}

function select_formula(id,formula){
  var ROW_ID  = id.split('_').pop();

  $("#FORMULA_"+ROW_ID).val('');
  $("#AMOUNT_"+ROW_ID).val('');
  $("#REMARKS_"+ROW_ID).val('');

  if(formula =="FORMULA"){
    $("#FORMULA_"+ROW_ID).attr('readonly', false);
    $("#AMOUNT_"+ROW_ID).attr('readonly', true);
  }
  else{
    $("#AMOUNT_"+ROW_ID).attr('readonly', false);
    $("#FORMULA_"+ROW_ID).attr('readonly', true);
  }

}

//====================// NUMBER DECIMAL CHECK //====================//

function isNumberDecimalKey(evt){
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  return false;

  return true;
}

//====================// VALIDATE FORM //====================//


//====================// SAVE DETAILS //====================//

window.fnSaveData = function (){

  event.preventDefault();
  var trnsoForm = $("#frm_mst_view");
  var formData = trnsoForm.serialize();

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
    url:'<?php echo e(route("master",[$FormId,"update"])); ?>',
    type:'POST',
    data:formData,
    success:function(data) {

      if(data.success) {                   
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn").show();
        $("#AlertMessage").text(data.msg);
        $(".text-danger").hide();
        $("#alert").modal('show');
        $("#OkBtn").focus();
      }
      else{                   
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").show();
        $("#AlertMessage").text(data.msg);
        $(".text-danger").hide();
        $("#alert").modal('show');
        $("#OkBtn1").focus();
      }
        
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").show();
        $("#AlertMessage").text('Error: Something went wrong.');
        $("#alert").modal('show');
        $("#OkBtn1").focus();
        highlighFocusBtn('activeOk1');
    },
  });

}

//====================// APPROVE DETAILS //====================//

window.fnApproveData = function (){

  event.preventDefault();
  var trnsoForm = $("#frm_mst_view");
  var formData = trnsoForm.serialize();

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
    url:'<?php echo e(route("master",[$FormId,"Approve"])); ?>',
    type:'POST',
    data:formData,
    success:function(data) {

      if(data.success) {                   
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn").show();
        $("#AlertMessage").text(data.msg);
        $(".text-danger").hide();
        $("#alert").modal('show');
        $("#OkBtn").focus();
      }
      else{                   
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").show();
        $("#AlertMessage").text(data.msg);
        $(".text-danger").hide();
        $("#alert").modal('show');
        $("#OkBtn1").focus();
      }
        
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").show();
        $("#AlertMessage").text('Error: Something went wrong.');
        $("#alert").modal('show');
        $("#OkBtn1").focus();
        highlighFocusBtn('activeOk1');
    },
  });

}

$(function () {
	
	var today = new Date(); 
    var dodeactived_date = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
    $('#DODEACTIVATED').attr('min',dodeactived_date);

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


$('#btnExit').on('click', function() {
  var viewURL = '<?php echo e(route('home')); ?>';
              window.location.href=viewURL;
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Payroll\EntitlementMaster\mstfrm200view.blade.php ENDPATH**/ ?>