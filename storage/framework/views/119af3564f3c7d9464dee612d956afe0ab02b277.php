
<?php $__env->startSection('content'); ?>
<div class="container-fluid topnav">
  <div class="row">
      <div class="col-lg-2">
      <a href="<?php echo e(route('master',[$FormId,'index'])); ?>" class="btn singlebt">Territory Master</a>
      </div>
      <div class="col-lg-10 topnav-pd">
      <button class="btn topnavbt" id="btnAdd" disabled="disabled" ><i class="fa fa-plus"></i> Add</button>
      <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
      <button class="btn topnavbt" id="btnSave" tabindex="3"  ><i class="fa fa-save"></i> Save</button>
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
                  <div class="col-lg-2 pl"><p>Doc No*</p></div>
                  <div class="col-lg-2 pl">
                  <input type="text" name="TRYDOC_NO" id="TRYDOC_NO" value="<?php echo e($docarray['DOC_NO']); ?>" <?php echo e($docarray['READONLY']); ?> class="form-control" maxlength="<?php echo e($docarray['MAXLENGTH']); ?>" autocomplete="off" style="text-transform:uppercase" >
                    <span class="text-danger" id="ERROR_TRYDOC_NO"></span>
                  </div>

                  <div class="col-lg-2 pl"><p>Date*</p></div>
                  <div class="col-lg-2 pl">
                  <input type="date" name="DOC_DT" id="DOC_DT" value="<?php echo e(date('Y-m-d')); ?>" class="form-control mandatory" autocomplete="off" placeholder="dd/mm/yyyy" >
                  </div>
                </div>   

                <div class="row">
                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#Material">Material</a></li>
                  </ul>
                  Note:- 1 row mandatory in Tab
                  <div class="tab-content">
                    <div id="Material" class="tab-pane fade in active">
                        <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                          <table id="example3" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                            <thead id="thead1"  style="position: sticky;top: 0">                   
                              <tr>  
                              <th rowspan="2"  width="3%">Sr. No</th>                        
                              <th rowspan="2"  width="3%">Territory Code</th>
                              <th rowspan="2"  width="3%">Territory Name</th>
                              <th rowspan="2"  width="5%">Action</th>                        
                            </tr>                      
                              
                          </thead>
                            <tbody>
                              <tr  class="participantRow">
                                <td><input class="form-control dynamic" type="text" name="SRNo[]"           id ="SRNo_0" value="1" autocomplete="off" readonly></td>
                                <td><input  class="form-control"        type="text" name="TERTORYCODE[]"    id ="TERTORYCODE_0" autocomplete="off"></td>
                                <td><input  class="form-control"        type="text" name="TERTORYNAME[]"    id ="TERTORYNAME_0" autocomplete="off"></td>                                
                                <td align="center">
                                  <button class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                                  <button class="btn remove" title="Delete" data-toggle="tooltip"><i class="fa fa-trash" ></i></button>
                                </td>
                              </tr>
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
              <input type="hidden" id="focusid" >
            
        </div><!--btdiv-->
		    <div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('bottom-scripts'); ?>
<script>

function setfocus(){
  var focusid=$("#focusid").val();
  $("#"+focusid).focus();
  $("#closePopup").click();
}
  
  function alertMsg(id,msg){
    $("#focusid").val(id);
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").hide();  
    $("#OkBtn").show();              
    $("#AlertMessage").text(msg);
    $("#alert").modal('show');
    $("#OkBtn").focus();
    return false;
  }
  
  function validateForm(actionType){
      var TRYDOC_NO                =   $.trim($("#TRYDOC_NO").val());
      var DOC_DT                =   $.trim($("#DOC_DT").val());

      if(TRYDOC_NO ===""){
        alertMsg('TRYDOC_NO','Please enter Doc No.');
      }
      else if(DOC_DT ===""){
        alertMsg('DOC_DT','Please enter Document Date.');
      }     
    
      else{
        event.preventDefault();
          var allblank1 = [];
          var focustext1= "";
          var textmsg = "";

          $('#example3').find('.participantRow').each(function(){
          if($.trim($(this).find("[id*=SRNo]").val()) ==""){
            allblank1.push('false');
            focustext1 = $(this).find("[id*=SRNo]").attr('id');
            textmsg = 'Please enter Sr. No';
          }          
          else if($.trim($(this).find("[id*=TERTORYCODE]").val()) ==""){
            allblank1.push('false');
            focustext1 = $(this).find("[id*=TERTORYCODE]").attr('id');
            textmsg = 'Please enter Territory Code';
          }
          else if($.trim($(this).find("[id*=TERTORYNAME]").val()) ==""){
            allblank1.push('false');
            focustext1 = $(this).find("[id*=TERTORYNAME]").attr('id');
            textmsg = 'Please enter Territory Name';
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
          else{
            checkDuplicateCode();
          }

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

    function checkDuplicateCode(){
        var trnFormReq  = $("#frm_mst_add");
        var formData    = trnFormReq.serialize();
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
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn1").hide();
                  $("#OkBtn").show();
                  $("#AlertMessage").text(data.msg);
                  $("#alert").modal('show');
                  $("#OkBtn").focus();
                }
                else{
                  $("#alert").modal('show');
                  $("#AlertMessage").text('Do you want to save to record.');
                  $("#YesBtn").data("funcname",actionType);
                  $("#YesBtn").focus();
                  $("#OkBtn").hide();
                  highlighFocusBtn('activeYes');
                }                                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
            },
        });
        }

        $("#btnSave" ).click(function() {
          var formReqData = $("#frm_mst_add");
          if(formReqData.valid()){
            validateForm();
          }
      });
      
      $("#YesBtn").click(function(){
          $("#alert").modal('hide');
          var customFnName = $("#YesBtn").data("funcname");
          window[customFnName]();
        });
  
     window.fnSaveData = function (){
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
                if(data.success) {                   
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn1").show();
                  $("#OkBtn").hide();
                  $("#AlertMessage").text(data.msg);
                  $("#alert").modal('show');
                  $("#OkBtn1").focus();
                }
                else{
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn1").hide();
                  $("#OkBtn").show();
                  $("#AlertMessage").text(data.msg);
                  $("#alert").modal('show');
                  $("#OkBtn").focus();
                }
                  
              },
              error:function(data){
              console.log("Error: Something went wrong.");
              },
          });
        
     }

//delete row
$("#Material").on('click', '.remove', function() {
    var rowCount = $(this).closest('table').find('.participantRow').length;
    if (rowCount > 1) {
    var row = $(this).closest('tr');
    var dynamicValue = $(row).find('.dynamic').val();
    dynamicValue = parseInt(dynamicValue);
    row.remove();
    $('.dynamic').each(function(idx, elem){
      $(elem).val(idx+1);
    });      
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
  });

  $clone.find('input:text').val('');
  $clone.find('input:hidden').val('');
  $tr.closest('table').append($clone);         
  var rowCount1 = $('#Row_Count').val();
  rowCount1 = parseInt(rowCount1)+1;
  $('#Row_Count').val(rowCount1);
  $clone.find('.remove').removeAttr('disabled'); 
  event.preventDefault();
  $clone.find('td').each(function(){
  var el = $(this).find(':first-child');
  var id = el.attr('id') || null;
  var idLength = id.split('_').pop();
  var rowCount = $('#Material tbody tr').length;
  $('#SRNo_'+idLength).val(rowCount);
  });
});

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
  
      function showError(pId,pVal){
        $("#"+pId+"").text(pVal);
        $("#"+pId+"").show();
        }
  
      function highlighFocusBtn(pclass){
         $(".activeYes").hide();
         $(".activeNo").hide();
         $("."+pclass+"").show();
      }  
  
      check_exist_docno(<?php echo json_encode($docarray['EXIST'], 15, 512) ?>);   

  $(document).ready(function(e) {
  var d = new Date(); 
  var today = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;
  $('#DOC_DT').val(today);
  });
  

  </script>

  <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\PROJECTS\UNICORN_DEV\resources\views/masters/PreSales/TerritoryMaster/mstfrm557add.blade.php ENDPATH**/ ?>