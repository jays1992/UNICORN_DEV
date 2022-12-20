<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[$FormId,'index'])); ?>" class="btn singlebt">Asset No Master</a>
                </div><!--col-2-->

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

              </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
         <form id="frm_mst_add" method="POST" onsubmit="return validateForm()" class="needs-validation"  > 
         
          <?php echo csrf_field(); ?>
          <div class="inner-form">
              
                <div class="row">
                  <div class="col-lg-2 pl"><p>Asset Code No*</p></div>
                  <div class="col-lg-2 pl">
                  <input type="text" name="ASTCODENO" id="ASTCODENO" value="<?php echo e($docarray['DOC_NO']); ?>" <?php echo e($docarray['READONLY']); ?> class="form-control" maxlength="<?php echo e($docarray['MAXLENGTH']); ?>" autocomplete="off" style="text-transform:uppercase" >

                    <span class="text-danger" id="ERROR_ASTCODENO"></span> 
                  </div>

                  <div class="col-lg-2 pl"><p>Asset Date</p></div>
                    <div class="col-lg-2 pl">
                      <input type="date" name="ASTDATES" id="ASTDATES" class="form-control" maxlength="100">
                    </div>

                  <div class="col-lg-2 pl"><p>Asset Code*</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASSETCODE" id="ASSETCODE" class="form-control mandatory"  autocomplete="off" readonly/>
                      <input type="hidden" name="ASSETID_REF" id="ASCATID" class="form-control" autocomplete="off" />
                      <input type="hidden" id="focusid" >                             
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2 pl"><p>Asset Description</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTDESCRIPTIONS" id="DESCRIPTIONS" class="form-control" readonly="" maxlength="100">
                    </div>

                    <div class="col-lg-2 pl"><p>Asset Group</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASGCODE" id="ASGCODE" class="form-control" readonly="" maxlength="100">
                      <input type="hidden" name="ASGID_REF" id="ASGID_REF" class="form-control" readonly="" maxlength="100">
                    </div>
                  
                  <div class="col-lg-2 pl"><p>Asset Type</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASSETTYPE" id="ASSETTYPE" class="form-control" readonly="" maxlength="100">
                      <input type="hidden" name="ASTID_REF" id="ASTID_REF" class="form-control" readonly="" maxlength="100">
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-2 pl"><p>Asset Category</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASSETCATEGRY" id="ASSETCATEGRY" class="form-control mandatory" autocomplete="off" readonly="">
                      <input type="hidden" name="ASCATGRYID" id="ASCATGRYID" class="form-control" autocomplete="off">
                    </div>
                  </div>
                  <br>
                    <div class="row">
                    <div class="col-lg-2 pl"><p>Date of Purchase</p></div>
                    <div class="col-lg-2 pl">
                      <input type="date" name="ASTDATEPURCH" id="ASTDATEPURCH" class="form-control"  maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Party Name (Supplier)</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTPARTYNAME" id="ASTPARTYNAME" class="form-control"  maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Asset Basic Cost</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTBCOST" id="ASTBCOST" class="form-control amt"  onkeypress="return onlyNumberKey(event)"  maxlength="100" > 
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 pl"><p>Freight Inward</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTPINWARD" id="ASTPINWARD" class="form-control amt"  onkeypress="return onlyNumberKey(event)"  maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Loading & unloading</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTLOADUNLOAD" id="ASTLOADUNLOAD" class="form-control amt"  onkeypress="return onlyNumberKey(event)"  maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Custom Duty</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTCUSTDUTY" id="ASTCUSTDUTY" class="form-control amt"  onkeypress="return onlyNumberKey(event)" maxlength="100" > 
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 pl"><p>C & F charges</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTCFCHARGE" id="ASTCFCHARGE" class="form-control amt"  onkeypress="return onlyNumberKey(event)" maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Taxes (GST)</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTTAXGST" id="ASTTAXGST" class="form-control amt"  onkeypress="return onlyNumberKey(event)" maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Other 1</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTOTHER1" id="ASTOTHER1" class="form-control amt"  onkeypress="return onlyNumberKey(event)" maxlength="100" > 
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 pl"><p>Other 2</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTOTHER2" id="ASTOTHER2" class="form-control amt"  onkeypress="return onlyNumberKey(event)" maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Total Asset Cost </p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTTOTALCOST" id="ASTTOTALCOST" class="form-control"  maxlength="100" readonly> 
                    </div>

                    <div class="col-lg-2 pl"><p>Vendor's Bill No</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTVDRBILLNO" id="ASTVDRBILLNO" class="form-control"  maxlength="100" > 
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 pl"><p>Bill Date</p></div>
                    <div class="col-lg-2 pl">
                      <input type="date" name="ASTBILLNO" id="ASTBILLNO" class="form-control"  maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Bill amount</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTBILLAMT" id="ASTBILLAMT" class="form-control"  maxlength="100" readonly> 
                    </div>

                    <div class="col-lg-2 pl"><p>Qty</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTQTY" id="ASTQTY" class="form-control" onkeypress="return onlyNumberKey(event)" maxlength="100" > 
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 pl"><p>Other Specification 1</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTOTHERSPEF1" id="ASTOTHERSPEF1" class="form-control"  maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Other Specification 2</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTOTHERSPEF2" id="ASTOTHERSPEF2" class="form-control"  maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Other Specification 3</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTOTHERSPEF3" id="ASTOTHERSPEF3" class="form-control"  maxlength="100" > 
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 pl"><p>Date of Manufacturing</p></div>
                    <div class="col-lg-2 pl">
                      <input type="date" name="ASTDATEOFMANF" id="ASTDATEOFMANF" class="form-control"  maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Expiry Date</p></div>
                    <div class="col-lg-2 pl">
                      <input type="date" name="ASTEXPDATE" id="ASTEXPDATE" class="form-control"  maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>GRN No (if any) & Date</p></div>
                    <div class="col-lg-2 pl">
                      <input type="date" name="ASTGRNNODATE" id="ASTGRNNODATE" class="form-control"  maxlength="100" > 
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-2 pl"><p>Purchase voucher No</p></div>
                    <div class="col-lg-2 pl">
                      <input type="text" name="ASTPURVOUCHNO" id="ASTPURVOUCHNO" class="form-control"  maxlength="100" > 
                    </div>

                    <div class="col-lg-2 pl"><p>Date</p></div>
                    <div class="col-lg-2 pl">
                      <input type="date" name="ASTDATE" id="ASTDATE" class="form-control"  maxlength="100" > 
                    </div>                    
                  </div>
                </div>
        </form>
    </div><!--purchase-order-view-->

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




<div id="asetmstpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width: 600px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='emp_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Asset Code Details</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="MachTable" class="display nowrap table  table-striped table-bordered" width="100%">
    <thead>
      <tr>
        <th class="ROW1" style="width: 10%" align="center">Select</th> 
        <th class="ROW2" style="width: 40%">Code</th>
        <th  class="ROW3"style="width: 40%">Description</th>
      </tr>
    </thead>
    <tbody>
    <tr>
      <td class="ROW1" style="width: 10%" align="center"><span class="check_th">&#10004;</span></td>
      <td class="ROW2"  style="width: 40%">
        <input type="text" autocomplete="off"  class="form-control" id="search_astcode_1" onkeyup="searchAstCode(this.id,'AstTable2','1')" />
      </td>
      <td class="ROW3"  style="width: 40%">
        <input type="text" autocomplete="off"  class="form-control" id="search_astcode_2" onkeyup="searchAstCode(this.id,'AstTable2','2')" />
      </td>
    </tr>
    </tbody>
    </table>
      <table id="AstTable2" class="display nowrap table  table-striped table-bordered" width="100%" style="font-size: 13px;">
        <thead id="thead2">
          
        </thead>
        <tbody id="tbody_subglacct">       
        </tbody>
      </table>
    </div>
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
    var ASTCODENO  =   $.trim($("[id*=ASTCODENO]").val());
    var ASTQTY  =   $.trim($("[id*=ASTQTY]").val());
    
    $("#OkBtn1").hide();

    if(ASTCODENO ===""){
      $("#focusid").val('ASTCODENO');
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").hide();  
      $("#OkBtn").show();              
      $("#AlertMessage").text('Please enter Asset Code No.');
      $("#alert").modal('show');
      $("#OkBtn").focus();
      return false;
    }
    else if(ASTQTY ===""){
      $("#focusid").val('ASTQTY');
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").hide();  
      $("#OkBtn").show();              
      $("#AlertMessage").text('Please enter Qty.');
      $("#alert").modal('show');
      $("#OkBtn").focus();
      return false;
    }
    
    else{
      $("#alert").modal('show');
      $("#AlertMessage").text('Do you want to save to record.');
      $("#YesBtn").data("funcname","fnSaveData");  
      $("#YesBtn").focus();
      highlighFocusBtn('activeYes');
    }
}

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
      var validator =$("#frm_mst_add" ).validate();
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
        var getDataForm = $("#frm_mst_add");
        var formData = getDataForm.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'<?php echo e(route("master",[$FormId,"codeduplicate"])); ?>',
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
            url:'<?php echo e(route("master",[$FormId,"save"])); ?>',
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
                    $("#frm_mst_add").trigger("reset");

                    $("#alert").modal('show');
                    $("#OkBtn1").focus();

                  //  window.location.href='<?php echo e(route("master",[$FormId,"index"])); ?>';
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
    window.location.href = "<?php echo e(route('master',[$FormId,'index'])); ?>";

    });


    
    $("#OkBtn").click(function(){
      $("#alert").modal('hide');

    });////ok button


   window.fnUndoYes = function (){
      
      //reload form
      window.location.href = "<?php echo e(route('master',[$FormId,'add'])); ?>";

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

    check_exist_docno(<?php echo json_encode($docarray['EXIST'], 15, 512) ?>);



     let AstTable2 = "#AstTable2";
      let MachTable = "#MachTable";
      let headers     = document.querySelectorAll(AstTable2 + " th");

      headers.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(MachTable, ".clsdpid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function searchAstCode(search_id,table_id,index_no) {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(search_id);
        filter = input.value.toUpperCase();
        table = document.getElementById(table_id);
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[index_no];
          if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }       
        }
      }
   
  $("#ASSETCODE").focus(function(event){
  
  $('#tbody_subglacct').html('Loading...');
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $.ajax({
      url:'<?php echo e(route("master",[410,"getemplCode"])); ?>',
      type:'POST',
      success:function(data) {
          $('#tbody_subglacct').html(data);
          bindEmpEvents();
      },
      error:function(data){
          console.log("Error: Something went wrong.");
          $('#tbody_subglacct').html('');
      },
  });        
   $("#asetmstpopup").show();
   event.preventDefault();
}); 

$("#emp_closePopup").on("click",function(event){ 
  $("#asetmstpopup").hide();
  event.preventDefault();
});

function bindEmpEvents(){

  $('.clsemp').click(function(){

    var id = $(this).attr('id');
    var txtval =    $("#txt"+id+"").val();
    var texdesc =   $("#txt"+id+"").data("desc");
    var DESCRIPTIONS =   $("#txt"+id+"").data("ccname");
    var ASGCODE =   $("#txt"+id+"").data("lvopbl");
    var ASSETTYPE =   $("#txt"+id+"").data("astype");
    var ASGID_REF =   $("#txt"+id+"").data("asgid");
    var ASTID_REF =   $("#txt"+id+"").data("astid");
    var ASCATID =   $("#txt"+id+"").data("ascatid");
    var ASSETCATEGRY =   $("#txt"+id+"").data("ascatname");
   //alert(txtval);

    $("#ASSETCODE").val(texdesc);
    $("#ASSETCODE").blur();
    $("#DESCRIPTIONS").val(DESCRIPTIONS);
    $("#ASGCODE").val(ASGCODE);
    $("#ASSETTYPE").val(ASSETTYPE);
    $("#ASGID_REF").val(ASGID_REF);
    $("#ASTID_REF").val(ASTID_REF);
    $("#ASCATID").val(txtval);
    $("#ASSETCATEGRY").val(ASSETCATEGRY);
    $("#asetmstpopup").hide();
    $(this).prop("checked",false);
    event.preventDefault();
  });
} 

$(".amt").on("blur", function(){
    var sum=0;
    $(".amt").each(function(){
        if($(this).val() != "")
          sum += parseInt($(this).val());   
    });
    $("#ASTTOTALCOST").val(sum);
    $("#ASTBILLAMT").val(sum);
});

    $(document).ready(function(e) {
      var d = new Date(); 
      var today = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;
      $('#ASTDATES').val(today);
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Asset\AssetNoMaster\mstfrm410add.blade.php ENDPATH**/ ?>