<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('transaction',[402,'index'])); ?>" class="btn singlebt">Leave Apply</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button href="#" id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button id="btnSave"   class="btn topnavbt" tabindex="4"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView"  disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt"  id="btnUndo" ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled" ><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove"<?php echo e((isset($objRights->APPROVAL1) || isset($objRights->APPROVAL2) || isset($objRights->APPROVAL3) || isset($objRights->APPROVAL4) || isset($objRights->APPROVAL5)) &&  ($objRights->APPROVAL1||$objRights->APPROVAL2||$objRights->APPROVAL3||$objRights->APPROVAL4||$objRights->APPROVAL5) == 1 ? '' : 'disabled'); ?>><i class="fa fa-lock"></i> Approved</button>
                        <a href="#" class="btn topnavbt"  disabled="disabled"><i class="fa fa-link" ></i> Attachment</a>
                        <button class="btn topnavbt" id="btnExit"><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    
    <div class="container-fluid purchase-order-view filter">     
      <form id="frm_mst_edit" method="POST" onsubmit="return validateForm()" class="needs-validation"  > 
        <?php echo csrf_field(); ?>
        <?php echo e(isset($objResponse->LEAVE_APPID) ? method_field('PUT') : ''); ?>

        <div class="inner-form">
            
              <div class="row">
                <div class="col-lg-2 pl"><p>LA No*</p></div>
                <div class="col-lg-2 pl">
                  <input type="text" name="LEAVE_APP_NO" id="LEAVE_APP_NO" VALUE="<?php echo e(isset($objResponse->LEAVE_APP_NO)?$objResponse->LEAVE_APP_NO:''); ?>" class="form-control mandatory"  autocomplete="off" readonly style="text-transform:uppercase" >
                  <span class="text-danger" id="ERROR_LEAVE_APP_NO"></span> 
                </div>

                <div class="col-lg-2 pl"><p>LA Date*</p></div>
                  <div class="col-lg-2 pl">
                    <input type="date" name="LEAVE_APP_DT" id="LEAVE_APP_DT" onchange="checkPeriodClosing(402,this.value,1)" value="<?php echo e($objResponse->LEAVE_APP_DT); ?>" class="form-control"  maxlength="100" > 
                  </div>

                <div class="col-lg-2 pl"><p>Pay Period Code*</p></div>
                  <div class="col-lg-2 pl">
                    <select name="PAYPERIODID_REF" id="PAYPERIODID_REF" class="form-control mandatory" onchange="getPayPrName(this.value)" tabindex="4">
                      <option value="" selected="">Select</option>
                      <?php $__currentLoopData = $objList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option <?php echo e(isset($objResponse->PAYPERIODID_REF) && $objResponse->PAYPERIODID_REF == $val-> PAYPERIODID ?'selected="selected"':''); ?> value="<?php echo e($val-> PAYPERIODID); ?>"><?php echo e($val->PAY_PERIOD_CODE); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="text-danger" id="ERROR_PAYPERIODID_REF"></span>                             
                  </div>
                </div> 

                <div class="row">
                  <div class="col-lg-2 pl"><p>Assign Leave Description</p></div>
                  <div class="col-lg-2 pl">
                    <input type="text" id="PAY_PERIOD_DESC" value="<?php echo e($objLvDesList->PAY_PERIOD_DESC); ?>" class="form-control" readonly  maxlength="100" > 
                  </div>
                
                  <div class="col-lg-2 pl"><p>Employee Code *</p></div>
                  <div class="col-lg-2 pl">
                  <select name="EMPID_REF" id="EMPID_REF" class="form-control mandatory" onchange="getEmpName(this.value)" tabindex="4">
                    <option value="" selected="">Select</option>
                    <?php $__currentLoopData = $objEmpList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(isset($objResponse->EMPID_REF) && $objResponse->EMPID_REF == $val-> EMPID ?'selected="selected"':''); ?> value="<?php echo e($val-> EMPID); ?>"><?php echo e($val->EMPCODE); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <input type="hidden" id="focusid" >
                  <span class="text-danger" id="ERROR_EMPID_REF"></span> 
                </div>
                
                <div class="col-lg-2 pl"><p>Name</p></div>
                  <div class="col-lg-2 pl">
                    <input type="text" id="FNAME" value="<?php echo e($objEmpName->FNAME); ?>" class="form-control" readonly maxlength="100" > 
                  </div>
              </div>


              <div class="row">
                <div class="col-lg-2 pl"><p>LA From Date*</p></div>
                <div class="col-lg-2 pl">
                  <input type="date" name="LEAVE_APP_FRDT"  id="LEAVE_APP_FRDT" value="<?php echo e($objResponse->LEAVE_APP_FRDT); ?>" onchange="leaveFromDate(this.id)" class="form-control"  maxlength="100" > 
                </div>
              
                <div class="col-lg-2 pl"><p>LA To Date *</p></div>
                <div class="col-lg-2 pl">
                  <input type="date" name="LEAVE_APP_TODT" id="LEAVE_APP_TODT" value="<?php echo e($objResponse->LEAVE_APP_TODT); ?>" onchange="leaveFromDate(this.id)" class="form-control"  maxlength="100" >
                <input type="hidden" id="focusid" >
                <span class="text-danger" id="ERROR_EMPID_REF"></span>                             
              </div>
              
              <div class="col-lg-2 pl"><p>Total Days</p></div>
                <div class="col-lg-2 pl">
                  <input type="text" name="totalday" id="totalday" class="form-control"  maxlength="100" readonly> 
                </div>
            </div>



            <div class="row">
              <div class="col-lg-2 pl"><p>Reason of Leave*</p></div>
              <div class="col-lg-2 pl">
                <input type="text" name="REASON_LEAVE" id="REASON_LEAVE" value="<?php echo e($objResponse->REASON_LEAVE); ?>" class="form-control"  maxlength="100" > 
              </div>
            
              <div class="col-lg-2 pl"><p>Address During the leave </p></div>
              <div class="col-lg-2 pl">
                <input type="text" name="ADDRESS_LEAVE" id="ADDRESS_LEAVE" value="<?php echo e($objResponse->ADDRESS_LEAVE); ?>" class="form-control"  maxlength="100"> 
              <input type="hidden" id="focusid" >
              <span class="text-danger" id="ERROR_EMPID_REF"></span>                             
            </div>
            
            <div class="col-lg-2 pl"><p>Contact no During the leave 1</p></div>
              <div class="col-lg-2 pl">
                <input type="text" name="MONO_INLEAVE1" id="MONO_INLEAVE1" value="<?php echo e($objResponse->MONO_INLEAVE1); ?>" onkeypress="return onlyNumberKey(event)" class="form-control"  maxlength="100" > 
              </div>
            </div>
            <div class="row">
              <div class="col-lg-2 pl"><p>Contact no During the leave 2 </p></div>
              <div class="col-lg-2 pl">
                <input type="text" name="MONO_INLEAVE2" id="MONO_INLEAVE2" value="<?php echo e($objResponse->MONO_INLEAVE2); ?>" onkeypress="return onlyNumberKey(event)" class="form-control"  maxlength="100" > 
              </div>
            </div>
        </div>
      </form>
  </div><!--purchase-order-view-->
  
<?php $__env->stopSection(); ?>
<?php $__env->startSection('alert'); ?>
<!-- Alert -->
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
            <div id="alert-active" class="activeYes"></div>Yes
          </button>
          <button class="btn alertbt" name='NoBtn' id="NoBtn"   data-funcname="fnUndoNo" >
            <div id="alert-active" class="activeNo"></div>No
          </button>
          <button onclick="setfocus();"  class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;">
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
<!-- btnSave -->

<?php $__env->startPush('bottom-scripts'); ?>
<script>


function setfocus(){
  var focusid=$("#focusid").val();
  $("#"+focusid).focus();
  $("#closePopup").click();
} 

function validateForm(){

  $("#focusid").val('');

  var LEAVE_APP_NO      =   $.trim($("[id*=LEAVE_APP_NO]").val());
  var LEAVE_APP_DT      =   $.trim($("[id*=LEAVE_APP_DT]").val());
  var PAYPERIODID_REF   =   $.trim($("[id*=PAYPERIODID_REF]").val());
  var EMPID_REF         =   $.trim($("[id*=EMPID_REF]").val());
  var LEAVE_APP_FRDT    =   $.trim($("[id*=LEAVE_APP_FRDT]").val());
  var LEAVE_APP_TODT    =   $.trim($("[id*=LEAVE_APP_TODT]").val());
  var REASON_LEAVE      =   $.trim($("[id*=REASON_LEAVE]").val());
  var ADDRESS_LEAVE     =   $.trim($("[id*=ADDRESS_LEAVE]").val());
  var MONO_INLEAVE1     =   $.trim($("[id*=MONO_INLEAVE1]").val());
  var MONO_INLEAVE2     =   $.trim($("[id*=MONO_INLEAVE2]").val());
  $("#OkBtn1").hide();

  if(LEAVE_APP_NO ===""){
    $("#focusid").val('LEAVE_APP_NO');
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").hide();  
    $("#OkBtn").show();              
    $("#AlertMessage").text('Please enter LA No.');
    $("#alert").modal('show');
    $("#OkBtn").focus();
    return false;
  }
  else if(LEAVE_APP_DT ===""){
    $("#focusid").val('LEAVE_APP_DT');
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").hide();  
    $("#OkBtn").show();              
    $("#AlertMessage").text('Please enter LA Date.');
    $("#alert").modal('show');
    $("#OkBtn").focus();
    return false;
  }

  else if(PAYPERIODID_REF ===""){
    $("#focusid").val('PAYPERIODID_REF');
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").hide();  
    $("#OkBtn").show();              
    $("#AlertMessage").text('Please enter Pay Period Code.');
    $("#alert").modal('show');
    $("#OkBtn").focus();
    return false;
  }
  else if(EMPID_REF ===""){
    $("#focusid").val('EMPID_REF');
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").hide();  
    $("#OkBtn").show();              
    $("#AlertMessage").text('Please enter Employee Code.');
    $("#alert").modal('show');
    $("#OkBtn").focus();
    return false;
  }
  else if(LEAVE_APP_FRDT ===""){
    $("#focusid").val('LEAVE_APP_FRDT');
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").hide();  
    $("#OkBtn").show();              
    $("#AlertMessage").text('Please enter LA From Date.');
    $("#alert").modal('show');
    $("#OkBtn").focus();
    return false;
  }
  else if(LEAVE_APP_TODT ===""){
    $("#focusid").val('LEAVE_APP_TODT');
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").hide();  
    $("#OkBtn").show();              
    $("#AlertMessage").text('Please enter LA To Date.');
    $("#alert").modal('show');
    $("#OkBtn").focus();
    return false;
  }
  else if(REASON_LEAVE ===""){
    $("#focusid").val('REASON_LEAVE');
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").hide();  
    $("#OkBtn").show();              
    $("#AlertMessage").text('Please enter Reason of Leave.');
    $("#alert").modal('show');
    $("#OkBtn").focus();
    return false;
  }

  else if((new Date(LEAVE_APP_TODT)) < (new Date(LEAVE_APP_FRDT))){
      $("#FocusId").val('LEAVE_APP_TODT');    
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").show();
      $("#AlertMessage").text('LA From Date Greater Then LA To Date.');
      $("#alert").modal('show');
      $("#OkBtn1").focus();
      return false;
    }
    else if(checkPeriodClosing(402,$("#LEAVE_APP_DT").val(),0) ==0){
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn").hide();
      $("#OkBtn1").show();
      $("#AlertMessage").text(period_closing_msg);
      $("#alert").modal('show');
      $("#OkBtn1").focus();
    }

  else{
      event.preventDefault();
      $("#alert").modal('show');
      $("#AlertMessage").text('Do you want to save to record.');
      $("#YesBtn").data("funcname","fnSaveData");  
      $("#YesBtn").focus();
      highlighFocusBtn('activeYes');
  }

}

$('#btnAdd').on('click', function() {
    var viewURL = '<?php echo e(route("transaction",[402,"add"])); ?>';
    window.location.href=viewURL;
});

$('#btnExit').on('click', function() {
  var viewURL = '<?php echo e(route('home')); ?>';
  window.location.href=viewURL;
});

var formResponseMst = $( "#frm_mst_edit" );
   formResponseMst.validate();
  $("#DESCRIPTIONS").blur(function(){
      $(this).val($.trim( $(this).val() ));
      $("#ERROR_DESCRIPTIONS").hide();
      validateSingleElemnet("DESCRIPTIONS");
  });

  $( "#DESCRIPTIONS" ).rules( "add", {
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
    var validator =$("#frm_mst_edit" ).validate();
       if(validator.element( "#"+element_id+"" )){
          //check duplicate code
        if(element_id=="ATTCODE" || element_id=="attcode" ) {
          checkDuplicateCode();
        }

       }

  }
    
      
  function leaveFromDate(id){
  var LEAVE_APP_FRDT    =   $('#LEAVE_APP_FRDT').val();
    var LEAVE_APP_TODT    =   $('#LEAVE_APP_TODT').val();
      var lfromTodate   = new Date(LEAVE_APP_TODT) - new Date(LEAVE_APP_FRDT)
      var totalDays = lfromTodate / (1000 * 60 * 60 * 24);
    $("#totalday").val(totalDays);
}

  // //check duplicate exist code
  function checkDuplicateCode(){
      
      //validate and save data
      var getDataForm = $("#frm_mst_edit");
      var formData = getDataForm.serialize();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url:'<?php echo e(route("transaction",[402,"codeduplicate"])); ?>',
          type:'POST',
          data:formData,
          success:function(data) {
              if(data.exists) {
                  $(".text-danger").hide();
                  showError('ERROR_ATTCODE',data.msg);
                  $("#ATTCODE").focus();
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

          validateForm();

      }
  });
  
//validate and approve
$("#btnApprove").click(function() {
        
        if(formResponseMst.valid()){
            //set function nane of yes and no btn 
          if(checkPeriodClosing(402,$("#LEAVE_APP_DT").val(),0) ==0){
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text(period_closing_msg);
            $("#alert").modal('show');
            $("#OkBtn1").focus();
          }
          else{
            $("#alert").modal('show');
            $("#AlertMessage").text('Do you want to save to record.');
            $("#YesBtn").data("funcname","fnApproveData");  //set dynamic fucntion name of approval
            $("#YesBtn").focus();
            highlighFocusBtn('activeYes');
          }

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
          url:'<?php echo e(route("transactionmodify",[402,"update"])); ?>',
          type:'POST',
          data:formData,
          success:function(data) {
             
              if(data.errors) {
                  $(".text-danger").hide();                    
                  if(data.errors.DESCRIPTIONS){
                     // showError('ERROR_DESCRIPTIONS',data.errors.DESCRIPTIONS);
                      $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn1").hide();
                      $("#OkBtn").show();
                      $("#AlertMessage").text("Attribute Description is "+data.errors.DESCRIPTIONS);
                      $("#alert").modal('show');
                      $("#OkBtn").focus();
                  }
                 if(data.exist=='duplicate') {

                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn1").hide();
                    $("#OkBtn").show();

                    $("#AlertMessage").text(data.msg);

                    $("#alert").modal('show');
                    $("#OkBtn").focus();

                 }
                 if(data.save=='invalid') {

                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn1").hide();
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
                  $("#OkBtn1").show();
                  $("#OkBtn").hide();

                  $("#AlertMessage").text(data.msg);

                  $(".text-danger").hide();
                  $("#frm_mst_edit").trigger("reset");

                  $("#alert").modal('show');
                  $("#OkBtn1").focus();

                //  window.location.href='<?php echo e(route("transaction",[402,"index"])); ?>';
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
 

 
window.fnApproveData = function (){

event.preventDefault();
var trnsoForm = $("#frm_mst_edit");
var formData = trnsoForm.serialize();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'<?php echo e(route("transactionmodify",[402,"Approve"])); ?>',
    type:'POST',
    data:formData,
    success:function(data) {
      
        if(data.errors) {
            $(".text-danger").hide();

            if(data.errors.PAYPERIODID_REF){
                showError('ERROR_PAYPERIODID_REF',data.errors.PAYPERIODID_REF);
                        $("#YesBtn").hide();
                        $("#NoBtn").hide();
                        $("#OkBtn1").show();
                        $("#AlertMessage").text('Please enter correct value in VQ NO.');
                        $("#alert").modal('show');
                        $("#OkBtn1").focus();
            }
          if(data.country=='norecord') {

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
            $("#alert").modal('show');
            $("#OkBtn").focus();
        }
        else if(data.cancel) {                   
            console.log("cancel MSG="+data.msg);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text(data.msg);
            $(".text-danger").hide();
            $("#alert").modal('show');
            $("#OkBtn1").focus();
        }
        else 
        {                   
            console.log("succes MSG="+data.msg);
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
  
  $("#OkBtn").click(function(){

      $("#alert").modal('hide');

      $("#YesBtn").show();  //reset
      $("#NoBtn").show();   //reset
      $("#OkBtn").hide();
      $("#OkBtn1").hide();
      $(".text-danger").hide();
      window.location.href = '<?php echo e(route("transaction",[402,"index"])); ?>'; 
  }); ///ok button

  
  
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
      
  }); ////Undo button

  
  $("#OkBtn1").click(function(){

  $("#alert").modal('hide');
  $("#YesBtn").show();  //reset
  $("#NoBtn").show();   //reset
  $("#OkBtn").hide();
  $("#OkBtn1").hide();
  $(".text-danger").hide();
  window.location.href = "<?php echo e(route('transaction',[402,'index'])); ?>";

  });


  
  $("#OkBtn").click(function(){
    $("#alert").modal('hide');

  });////ok button


 window.fnUndoYes = function (){
    
    //reload form
    window.location.href = "<?php echo e(route('transaction',[402,'add'])); ?>";

 }//fnUndoYes

  function showError(pId,pVal){

    $("#"+pId+"").text(pVal);
    $("#"+pId+"").show();

  }//showError

  function highlighFocusBtn(pclass){
     $(".activeYes").hide();
     $(".activeNo").hide();
     
     $("."+pclass+"").show();
  }  

  
  function getPayPrName(PAYPERIODID){
  $("#PAY_PERIOD_DESC").val('');
  
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  
      $.ajax({
          url:'<?php echo e(route("transaction",[402,"getPayPrName"])); ?>',
          type:'POST',
          data:{PAYPERIODID:PAYPERIODID},
          success:function(data) {
             $("#PAY_PERIOD_DESC").val(data);                
          },
          error:function(data){
            console.log("Error: Something went wrong.");
          },
      });	
}

function getEmpName(EMPID){
  $("#FNAME").val('');
  
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  
      $.ajax({
          url:'<?php echo e(route("transaction",[402,"getEmpName"])); ?>',
          type:'POST',
          data:{EMPID:EMPID},
          success:function(data) {
             $("#FNAME").val(data);                
          },
          error:function(data){
            console.log("Error: Something went wrong.");
          },
      });	
}

function getLeaveTyName(id,LTID){

  var ROW_ID = id.split('_').pop();
  
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  
      $.ajax({
          url:'<?php echo e(route("transaction",[402,"getLeaveTyName"])); ?>',
          type:'POST',
          data:{LTID:LTID},
          success:function(data) {
             $('#LEAVETYPE_DESC_'+ROW_ID+'').val(data);                
          },
          error:function(data){
            console.log("Error: Something went wrong.");
          },
      });	
}
  

$(document).ready(function() {

  var LEAVE_APP_FRDT    =   $('#LEAVE_APP_FRDT').val();
  var LEAVE_APP_TODT    =   $('#LEAVE_APP_TODT').val();
    var lfromTodate   = new Date(LEAVE_APP_TODT) - new Date(LEAVE_APP_FRDT)
    var totalDays = lfromTodate / (1000 * 60 * 60 * 24);
  $("#totalday").val(totalDays); 

});


</script>

<script>
  function onlyNumberKey(evt) {
      var ASCIICode = (evt.which) ? evt.which : evt.keyCode
      if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
          return false;
      return true;
  }
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\transactions\Payroll\LeaveApply\trnfrm402edit.blade.php ENDPATH**/ ?>