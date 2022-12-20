<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('transaction',[413,'index'])); ?>" class="btn singlebt">Reimbursement</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSaveSE" disabled="disabled"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo"  disabled="disabled"><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-lock"></i> Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
      <form id="frm_mst_edit" method="POST" onsubmit="return validateForm()" class="needs-validation"  >       
        <?php echo csrf_field(); ?>
        <?php echo e(isset($objResponse->REIMBURSEID) ? method_field('PUT') : ''); ?>


       <div class="inner-form">              
             <div class="row">
               <div class="col-lg-2 pl"><p>Doc No*</p></div>
                 <div class="col-lg-2 pl">
                  <input type="text" name="CLAIM_DOC_NO" id="CLAIM_DOC_NO" value="<?php echo e($HDR->REIMBURSE_DOCNO); ?>" class="form-control mandatory" tabindex="1" maxlength="100" autocomplete="off" readonly style="text-transform:uppercase" autofocus disabled>
                 <span class="text-danger" id="ERROR_CLAIM_DOC_NO_REF"></span>                             
                 </div>

                 <div class="col-lg-2 pl"><p>Date*</p></div>
                 <div class="col-lg-2 pl">
                   <input type="date" name="REMB_DT" id="REMB_DT" value="<?php echo e($HDR->REIMBURSE_DOCDT); ?>" class="form-control"  maxlength="100" disabled> 
                 </div>

               <div class="col-lg-2 pl"><p>Pay Period Code*</p></div>
                 <div class="col-lg-2 pl">
                   <select name="PAYPERIODID_REF" id="PAYPERIODID_REF" class="form-control mandatory" onchange="getPayPrName(this.value)" tabindex="4" disabled>
                     <option value="" selected="">Select</option>
                     <?php $__currentLoopData = $objList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <option <?php echo e(isset($HDR->PAYPID_REF) && $HDR->PAYPID_REF == $val-> PAYPERIODID ?'selected="selected"':''); ?> value="<?php echo e($val-> PAYPERIODID); ?>"><?php echo e($val->PAY_PERIOD_CODE); ?></option>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </select>
                   <span class="text-danger" id="ERROR_PAYPERIODID_REF"></span>                             
                 </div>
               </div>

               <div class="row">
                 <div class="col-lg-2 pl"><p>Description</p></div>
                 <div class="col-lg-2 pl">
                   <input type="text" id="PAY_PERIOD_DESC" value="<?php echo e($HDR->PAY_PERIOD_DESC); ?>" class="form-control" readonly  maxlength="100" disabled> 
                 </div>
                 <div class="col-lg-2 pl"><p>Employee Code *</p></div>
                 <div class="col-lg-2 pl">
                 <select name="EMPID_REF" id="EMPID_REF" class="form-control mandatory" onchange="getEmpName(this.value)" tabindex="4" disabled>
                   <option value="" selected="">Select</option>
                   <?php $__currentLoopData = $objDataList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <option <?php echo e(isset($HDR->EMPID_REF) && $HDR->EMPID_REF == $val-> EMPID ?'selected="selected"':''); ?> value="<?php echo e($val-> EMPID); ?>"><?php echo e($val->EMPCODE); ?></option>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </select>
                 <input type="hidden" id="focusid" >
                 <span class="text-danger" id="ERROR_EMPID_REF"></span>                             
               </div>            
               
               <div class="col-lg-2 pl"><p>Name</p></div>
                 <div class="col-lg-2 pl">
                   <input type="text" name="FNAME" id="FNAME" value="<?php echo e($HDR->FNAME); ?>" class="form-control" readonly  maxlength="100" disabled> 
                 </div>
             </div>


             <div class="row">
             <div class="col-lg-2 pl"><p>Earning Head Code *</p></div>
                 <div class="col-lg-2 pl">
                 <select name="EARNING_HEADID_REF" id="EARNING_HEADID_REF" class="form-control mandatory" onchange="getEearHeadName(this.value)" tabindex="4" disabled>
                   <option value="" selected="">Select</option>
                   <?php $__currentLoopData = $objEarnHead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <option <?php echo e(isset($HDR->EARNING_HEADID_REF) && $HDR->EARNING_HEADID_REF == $val-> EARNING_HEADID ?'selected="selected"':''); ?> value="<?php echo e($val-> EARNING_HEADID); ?>"><?php echo e($val->EARNING_HEADCODE); ?></option>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </select>
                 <input type="hidden" id="focusid" >
                 <span class="text-danger" id="ERROR_EMPID_REF"></span>                             
               </div>

               <div class="col-lg-2 pl"><p>Name</p></div>
               <div class="col-lg-2 pl">
                 <input type="text" name="EARNING_HEAD_DESC" id="EARNING_HEAD_DESC" value="<?php echo e($HDR->EARNING_HEAD_DESC); ?>" class="form-control" readonly  maxlength="100" disabled> 
               </div>

               <div class="col-lg-2 pl"><p>Amount</p></div>
               <div class="col-lg-2 pl">
                 <input type="text" name="REMAMOUNT" id="REMAMOUNT" value="<?php echo e($HDR->AMOUNT); ?>" class="form-control" onkeypress="return onlyNumberKey(event)" maxlength="100" disabled> 
               </div>
             </div> 


             <div class="row">
               <div class="col-lg-2 pl"><p>Bill Submitted </p></div>
                   <div class="col-lg-2 pl">
                   <input type="checkbox" name="BILLSUB" id="BILLSUB" value="1" <?php echo e(isset($HDR->BILL_SUBMITTED) && $HDR->BILL_SUBMITTED =='1'?'checked':''); ?> disabled> 
                 </div>

                 <div class="col-lg-2 pl"><p>Vendor Name</p></div>
                 <div class="col-lg-2 pl">
                   <input type="text" name="VNAME" id="VNAME" value="<?php echo e(isset($HDR->VENDOR_NAME)?$HDR->VENDOR_NAME:''); ?>" class="form-control" maxlength="100" disabled> 
                 </div>

                 <div class="col-lg-2 pl"><p>Remarks</p></div>
                 <div class="col-lg-2 pl">
                   <input type="text" name="REMARKS" id="REMARKS" value="<?php echo e($HDR->REMARKS); ?>" class="form-control" maxlength="100" disabled> 
                 </div>
               </div> 

             <div id="Material" class="tab-pane fade in active">
               <div class="row">
                 <div class="col-lg-4" style="padding-left: 15px;"></div></div>
                   <div class="table-responsive table-wrapper-scroll-y" style="height:500px;margin-top:10px;" >
                     Note:- 1 row mandatory in Tab
                     <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                     <thead id="thead1"  style="position: sticky;top: 0">                      
                       <tr>                          
                       <th rowspan="2"  width="3%">Bill No </th>                         
                       <th rowspan="2" width="3%">Bill Date </th>
                       <th rowspan="2" width="3%">Amount</th>
                       <th rowspan="2" width="3%">Action </th>
                     </tr>                      
                       
                   </thead>
                     <tbody>
                      <?php if(!empty($MAT)): ?>
                      <?php $n=1; ?>
                      <?php $__currentLoopData = $MAT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <tr  class="participantRow">
                         <td><input  class="form-control" type="text" name="BILLNO[]" id=<?php echo e("BILLNO_".$key); ?> value="<?php echo e($row->BILL_NO); ?>"  autocomplete="off" style="width: 99%" disabled></td>
                         <td><input  class="form-control" type="date" name="BILL_DT[]" id=<?php echo e("BILL_DT_".$key); ?> value="<?php echo e($row->BILL_DT); ?>"  autocomplete="off" style="width: 99%" disabled></td>
                           <td><input  class="form-control" type="text" name="AMOUNT[]" id=<?php echo e("AMOUNT_".$key); ?> value="<?php echo e($row->AMOUNT); ?>" onkeypress="return onlyNumberKey(event)" autocomplete="off" style="width: 99%" disabled></td>
                           
                           <td align="center">
                           <button disabled class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                           <button disabled class="btn remove" title="Delete" data-toggle="tooltip" disabled><i class="fa fa-trash" ></i></button>
                           </td>
                       </tr>
                       <?php $n++; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                      <?php endif; ?>
                     </tbody>
                   </table>
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

 var CLAIM_DOC_NO          =   $.trim($("[id*=CLAIM_DOC_NO]").val());
 var REMB_DT               =   $.trim($("[id*=REMB_DT]").val());
 var PAYPERIODID_REF       =   $.trim($("[id*=PAYPERIODID_REF]").val());
 var EMPID_REF             =   $.trim($("[id*=EMPID_REF]").val());
 var EARNING_HEADID_REF    =   $.trim($("[id*=EARNING_HEADID_REF]").val());
 var REMAMOUNT             =   $.trim($("[id*=REMAMOUNT]").val());

 $("#OkBtn1").hide();
 if(CLAIM_DOC_NO ===""){
   $("#focusid").val('CLAIM_DOC_NO');
   $("#YesBtn").hide();
   $("#NoBtn").hide();
   $("#OkBtn1").hide();  
   $("#OkBtn").show();              
   $("#AlertMessage").text('Please enter Doc No.');
   $("#alert").modal('show');
   $("#OkBtn").focus();
   return false;
 }
 else if(REMB_DT ===""){
   $("#focusid").val('REMB_DT');
   $("#YesBtn").hide();
   $("#NoBtn").hide();
   $("#OkBtn1").hide();  
   $("#OkBtn").show();              
   $("#AlertMessage").text('Please enter Date.');
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
 else if(EARNING_HEADID_REF ===""){
   $("#focusid").val('EARNING_HEADID_REF');
   $("#YesBtn").hide();
   $("#NoBtn").hide();
   $("#OkBtn1").hide();  
   $("#OkBtn").show();              
   $("#AlertMessage").text('Please enter Earning Head Code .');
   $("#alert").modal('show');
   $("#OkBtn").focus();
   return false;
 }  
 else{
     event.preventDefault();
       var allblank1 = [];
       var focustext1= "";
       var textmsg = "";
       $('#example2').find('.participantRow').each(function(){
       var AMOUNT = $.trim($(this).find("[id*=AMOUNT]").val());
       if($.trim($(this).find("[id*=BILLNO]").val()) ==""){
         allblank1.push('false');
         focustext1 = $(this).find("[id*=BILLNO]").attr('id');
         textmsg = 'Please enter Bill No';
       }
         else if($.trim($(this).find("[id*=BILL_DT]").val()) ==""){
           allblank1.push('false');
           focustext1 = $(this).find("[id*=BILL_DT]").attr('id');
           textmsg = 'Please enter Bill Date';
         }
         else if($.trim($(this).find("[id*=AMOUNT]").val()) ==""){
           allblank1.push('false');
           focustext1 = $(this).find("[id*=AMOUNT]").attr('id');
           textmsg = 'Please enter Amount';
         }
         else if(parseFloat(AMOUNT) !== parseFloat(REMAMOUNT)){
              allblank1.push('false');
              focustext1 = $(this).find("[id*=AMOUNT]").attr('id');
              textmsg = 'Please enter Amount not match';
            }           
       });

     if(jQuery.inArray("false", allblank1) !== -1){
         $("#focusid").val(focustext1);
         $("#YesBtn").hide();
         $("#NoBtn").hide();
         $("#OkBtn1").hide();  
         $("#OkBtn").show();
         $("#AlertMessage").text(textmsg);
         $("#alert").modal('show');
         $("#OkBtn").focus();
         highlighFocusBtn('activeOk');
         return false;
       } 
       //  if(parseFloat(AMOUNT) == parseFloat(REMAMOUNT)){
       //   $("#FocusId").val('AMOUNT');    
       //   $("#YesBtn").hide();
       //   $("#NoBtn").hide();
       //   $("#OkBtn1").hide();  
       //   $("#OkBtn").show();
       //   $("#AlertMessage").text('Amount not match.');
       //   $("#alert").modal('show');
       //   $("#OkBtn").focus();
       //   highlighFocusBtn('activeOk');
       //   return false;
       // }
              
       else{
           $("#alert").modal('show');
           $("#AlertMessage").text('Do you want to save to record.');
           $("#YesBtn").data("funcname","fnSaveData");  
           $("#YesBtn").focus();
           highlighFocusBtn('activeYes');
       }

 }

}

$('#btnAdd').on('click', function() {
   var viewURL = '<?php echo e(route("transaction",[413,"add"])); ?>';
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
         url:'<?php echo e(route("transaction",[413,"codeduplicate"])); ?>',
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
         url:'<?php echo e(route("transactionmodify",[413,"update"])); ?>',
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

               //  window.location.href='<?php echo e(route("transaction",[413,"index"])); ?>';
             }
             
         },
         error:function(data){
           console.log("Error: Something went wrong.");
         },
     });
   
} // fnSaveData


//delete row
$("#Material").on('click', '.remove', function() {
 var rowCount = $(this).closest('table').find('.participantRow').length;
 if (rowCount > 1) {
 $(this).closest('.participantRow').remove();     
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
 }
 event.preventDefault();
});


//add row
$("#Material").on('click', '.add', function() {
var $tr = $(this).closest('table');
var allTrs = $tr.find('.participantRow').last();
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
 // var name = el.attr('name') || null;
 // if(name){
 //   var nameLength = name.split('_').pop();
 //   var i = name.substr(name.length-nameLength.length);
 //   var prefix1 = name.substr(0, (name.length-nameLength.length));
 //   el.attr('name', prefix1+(+i+1));
 // }
});

$clone.find('input:text').val('');
$clone.find('input:hidden').val('');
$tr.closest('table').append($clone);         
var rowCount1 = $('#Row_Count').val();
rowCount1 = parseInt(rowCount1)+1;
$('#Row_Count').val(rowCount1);
$clone.find('.remove').removeAttr('disabled'); 
event.preventDefault();
});


 
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
    url:'<?php echo e(route("transactionmodify",[$FormId,"Approve"])); ?>',
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
            window.location.href = '<?php echo e(route("transaction",[$FormId,"index"])); ?>';
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
 window.location.href = "<?php echo e(route('transaction',[413,'index'])); ?>";

 });


 
 $("#OkBtn").click(function(){
   $("#alert").modal('hide');

 });////ok button


window.fnUndoYes = function (){
   
   //reload form
   window.location.href = "<?php echo e(route('transaction',[413,'add'])); ?>";

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
         url:'<?php echo e(route("transaction",[413,"getPayPrName"])); ?>',
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
         url:'<?php echo e(route("transaction",[413,"getEmpName"])); ?>',
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

function getEearHeadName(EARNING_HEADID){
 $("#EARNING_HEAD_DESC").val('');		
 $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });		
     $.ajax({
         url:'<?php echo e(route("transaction",[413,"getEearHeadName"])); ?>',
         type:'POST',
         data:{EARNING_HEADID:EARNING_HEADID},
         success:function(data) {
            $("#EARNING_HEAD_DESC").val(data);                
         },
         error:function(data){
           console.log("Error: Something went wrong.");
         },
     });	
}

$(document).ready(function(e) {
var d = new Date(); 
var today = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;
$('#REMB_DT').val(today);

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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\transactions\Payroll\Reimbursement\trnfrm413view.blade.php ENDPATH**/ ?>