

<?php $__env->startSection('content'); ?>
<div class="container-fluid topnav">
    <div class="row">
        <div class="col-lg-2">
        <a href="<?php echo e(route('transaction',[$FormId,'index'])); ?>" class="btn singlebt">Preventive Maintenance <br/> Schedule</a>
        </div>

        <div class="col-lg-10 topnav-pd">
          <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
          <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
          <button class="btn topnavbt" id="btnSaveFormData" ><i class="fa fa-save"></i> Save</button>
          <button style="display:none" class="btn topnavbt buttonload"> <i class="fa fa-refresh fa-spin"></i> <?php echo e(Session::get('save')); ?></button>
          <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
          <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
          <button class="btn topnavbt" id="btnUndo"  ><i class="fa fa-undo"></i> Undo</button>
          <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
          <button style="display:none" class="btn topnavbt buttonload_approve" > <i class="fa fa-refresh fa-spin"></i> <?php echo e(Session::get('approve')); ?></button>
          <button class="btn topnavbt" id="btnApprove" <?php echo e((isset($objRights->APPROVAL1) || isset($objRights->APPROVAL2) || isset($objRights->APPROVAL3) || isset($objRights->APPROVAL4) || isset($objRights->APPROVAL5)) &&  ($objRights->APPROVAL1||$objRights->APPROVAL2||$objRights->APPROVAL3||$objRights->APPROVAL4||$objRights->APPROVAL5) == 1 ? '' : 'disabled'); ?>><i class="fa fa-lock"></i> Approved</button>
          <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
          <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
        </div>
    </div>
</div>
  
<form id="edit_trn_form" method="POST"  >
  <div class="container-fluid purchase-order-view">    
    <?php echo csrf_field(); ?>
    <div class="container-fluid filter">
      <div class="inner-form">

      <div class="row">
            <div class="col-lg-2 pl"><p>Schedule No</p></div>
            <div class="col-lg-2 pl">
              <input type="text" name="PMSL_NO" id="PMSL_NO" VALUE="<?php echo e(isset($HDR->PMSL_NO)?$HDR->PMSL_NO:''); ?>" class="form-control mandatory"  autocomplete="off" readonly style="text-transform:uppercase" >
            </div>
            
            <div class="col-lg-2 pl"><p>Schedule Date</p></div>
            <div class="col-lg-2 pl">
                <input type="date" name="PMSL_DATE" id="PMSL_DATE" onchange="checkPeriodClosing('<?php echo e($FormId); ?>',this.value,1)" VALUE="<?php echo e(isset($HDR->PMSL_DATE)?$HDR->PMSL_DATE:''); ?>" class="form-control mandatory" autocomplete="off" placeholder="dd/mm/yyyy" >
            </div>

            <div class="col-lg-2 pl"><p>Machine Code</p></div>
			      <div class="col-lg-2 pl">
              <input type="text" name="MACHINEID_REF_popup" id="txtMACHINEID_REF_popup" VALUE="<?php echo e(isset($HDR->MACHINE_NO)?$HDR->MACHINE_NO:''); ?>" class="form-control mandatory"  autocomplete="off"  readonly/>
              <input type="hidden" name="MACHINEID_REF" id="MACHINEID_REF" VALUE="<?php echo e(isset($HDR->MACHINEID_REF)?$HDR->MACHINEID_REF:''); ?>" class="form-control" autocomplete="off" />
              <input type="hidden" name="hdnmaterial" id="hdnmaterial" class="form-control" autocomplete="off" />
              <input type="hidden" name="hdnSpareParts" id="hdnSpareParts" class="form-control" autocomplete="off" />
              
			      </div>

        </div>

        <div class="row">

            <div class="col-lg-2 pl"><p>Machine Description</p></div>
			      <div class="col-lg-2 pl">
              <input type="text" name="MACHINEID_DESC" id="MACHINEID_DESC" VALUE="<?php echo e(isset($HDR->MACHINE_DESC)?$HDR->MACHINE_DESC:''); ?>" class="form-control"  autocomplete="off" readonly />
			      </div>

            <div class="col-lg-2 pl"><p>Remarks</p></div>
            <div class="col-lg-2 pl">
              <input type="text" name="REMARKS" id="REMARKS" VALUE="<?php echo e(isset($HDR->REMARKS)?$HDR->REMARKS:''); ?>" class="form-control"  autocomplete="off"/>
            </div>

            <div class="col-lg-2 pl"><p>Flexible Schedule</p></div>
            <div class="col-lg-2 pl">
                <select name="FLEXIBLE_SCHEDULE" id="FLEXIBLE_SCHEDULE"  class="form-control" autocomplete="off"  > 
                  <option value="">Select</option>
                  <option <?php echo e(isset($HDR->FLEXIBLE_SCHEDULE) && $HDR->FLEXIBLE_SCHEDULE =="1"?"selected='selected'":""); ?> value="1">Yes</option>
                  <option <?php echo e(isset($HDR->FLEXIBLE_SCHEDULE) && $HDR->FLEXIBLE_SCHEDULE =="0"?"selected='selected'":""); ?> value="0">No</option>
                </select>  
            </div>  
        </div>


      </div>



      <div class="container-fluid purchase-order-view">

        <div class="row">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#Material">Maintenance</a></li>
            <li><a data-toggle="tab" href="#SpareParts">Prior Instruction to Change Spare Parts</a></li>
          </ul>
            
            
            
          <div class="tab-content">

            
            <div id="Material" class="tab-pane fade in active">
              <div class="table-responsive table-wrapper-scroll-y" >
                  <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="50%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                                                  
                      <tr>
                        <th>Maintenance Schedule From Date</th>
                        <th>Maintenance Schedule To Date</th>
                        <th>Special Instruction</th>
                        <th>Action <input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1" value="<?php echo e(count($SCH)); ?>"></th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php if(isset($SCH) && !empty($SCH)): ?>
                      <?php $__currentLoopData = $SCH; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr  class="participantRow">

                        <td><input type="date"   name="PMSL_FROM_DATE_<?php echo e($key); ?>" id="PMSL_FROM_DATE_<?php echo e($key); ?>" value="<?php echo e(isset($row->PMSL_FROM_DATE)?$row->PMSL_FROM_DATE:''); ?>"  class="form-control"   autocomplete="off" style="width:200px;"  /></td>
                        <td><input type="date"   name="PMSL_TO_DATE_<?php echo e($key); ?>" id="PMSL_TO_DATE_<?php echo e($key); ?>"     value="<?php echo e(isset($row->PMSL_TO_DATE)?$row->PMSL_TO_DATE:''); ?>" class="form-control"   autocomplete="off" style="width:200px;"  /></td>
                        <td><input type="text"   name="SPECIAL_INST_<?php echo e($key); ?>" id="SPECIAL_INST_<?php echo e($key); ?>"     value="<?php echo e(isset($row->SPECIAL_INST)?$row->SPECIAL_INST:''); ?>" class="form-control"   autocomplete="off" style="width:200px;"   /></td>
                        
                        <td align="center" >
                          <button class="btn add material" title="add" data-toggle="tooltip" type="button" ><i class="fa fa-plus"></i></button>
                          <button class="btn remove dmaterial" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                        </td>

                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
								      <?php endif; ?>
                    </tbody>
                  </table>
                </div>	
              </div>

              <div id="SpareParts" class="tab-pane fade">
              <div class="table-responsive table-wrapper-scroll-y" >
                  <table id="example3" class="display nowrap table table-striped table-bordered itemlist" width="50%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                                                  
                      <tr>
                        <th>Sl. No.</th>
                        <th>Spare Parts Consumed</th>
                        <th>Action <input class="form-control" type="hidden" name="Row_Count2" id ="Row_Count2" value="<?php echo e(count($CON)); ?>"></th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php if(isset($CON) && !empty($CON)): ?>
                      <?php $__currentLoopData = $CON; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr  class="participantRow2">

                        <td><input type="text"   name="PMSL_ID_REF_<?php echo e($key); ?>" id="PMSL_ID_REF_<?php echo e($key); ?>" value="<?php echo e($key+1); ?>" class="form-control"   autocomplete="off" style="width:200px;" readonly  /></td>
                        <td><input type="text"   name="SPARE_PART_NAME_<?php echo e($key); ?>" id="SPARE_PART_NAME_<?php echo e($key); ?>" value="<?php echo e(isset($row->SPARE_PART_NAME)?$row->SPARE_PART_NAME:''); ?>"   class="form-control"   autocomplete="off" style="width:200px;"  /></td>
                        
                        
                        <td align="center" >
                          <button class="btn add material" title="add" data-toggle="tooltip" type="button" ><i class="fa fa-plus"></i></button>
                          <button class="btn remove dmaterial" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
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

<div id="MACHINEID_REF_popup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='MACHINEID_REF_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Machine Code</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="MACHINEID_REFTable" class="display nowrap table  table-striped table-bordered" >
    <thead>
    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Code</th>
      <th class="ROW3">Description</th>
    </tr>
    </thead>
    <tbody>

      <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="MACHINEID_REFcodesearch" class="form-control" onkeyup="MACHINEID_REFCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="MACHINEID_REFnamesearch" class="form-control" onkeyup="MACHINEID_REFNameFunction()"></td>
      </tr>

    </tbody>
    </table>
      <table id="MACHINEID_REFTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">
          
        </thead>
        <tbody >     
        <?php $__currentLoopData = $objMachineList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr >
          <td class="ROW1"> <input type="checkbox" name="SELECT_MACHINEID_REF[]" id="spidcode_<?php echo e($key); ?>" class="clssrequestuser" value="<?php echo e($val-> MACHINEID); ?>" ></td>  
          <td class="ROW2"><?php echo e($val-> MACHINE_NO); ?> <input type="hidden" id="txtspidcode_<?php echo e($key); ?>" data-desc="<?php echo e($val-> MACHINE_NO); ?>" data-desc1="<?php echo e($val-> MACHINE_DESC); ?>"  value="<?php echo e($val-> MACHINEID); ?>"/></td>
          <td class="ROW3"><?php echo e($val-> MACHINE_DESC); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('bottom-css'); ?>
<style>
#ItemIDcodesearch {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  font-size: 11px;
  padding: 5px 5px 5px 5px;
  border: 1px solid #ddd;
  margin-bottom: 5px;
}
#ItemIDnamesearch {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  font-size: 11px;
  padding: 5px 5px 5px 5px;
  border: 1px solid #ddd;
  margin-bottom: 5px;
}

#ItemIDTable {
  border-collapse: collapse;
  width: 950px;
  border: 1px solid #ddd;
  font-size: 11px;
}

#ItemIDTable th {
    text-align: center;
    padding: 5px;
   
    font-size: 11px;
    
    color: #0f69cc;
    font-weight: 600;
}

#ItemIDTable td {
    text-align: center;
    padding: 5px;
    font-size: 11px;
    
    font-weight: 600;
}

#ItemIDTable2 {
  border-collapse: collapse;
  width: 1050px;
  border: 1px solid #ddd;
  font-size: 11px;
}

#ItemIDTable2 th{
    text-align: left;
    padding: 5px;
   
    font-size: 11px;
    
    color: #0f69cc;
    font-weight: 600;
}

#ItemIDTable2 td {
  text-align: left;
    padding: 5px;
    font-size: 11px;
    
    font-weight: 600;
    width: 16%;
}
#CTIDDetTable2 {
  border-collapse: collapse;
  width: 1050px;
  border: 1px solid #ddd;
  font-size: 11px;
}

#CTIDDetTable2 th{
    text-align: left;
    padding: 5px;
    
    font-size: 11px;
    
    color: #0f69cc;
    font-weight: 600;
}

#CTIDDetTable2 td {
  text-align: left;
    padding: 5px;
    font-size: 11px;
    
    font-weight: 600;
    width: 20%;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('bottom-scripts'); ?>
<script>

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


//================================== MACHINE DETAILS =================================
let sptid = "#MACHINEID_REFTable2";
let sptid2 = "#MACHINEID_REFTable";
let requestuserheaders = document.querySelectorAll(sptid2 + " th");


requestuserheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(sptid, ".clssrequestuser", "td:nth-child(" + (i + 1) + ")");
  });
});

function MACHINEID_REFCodeFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("MACHINEID_REFcodesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("MACHINEID_REFTable2");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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

function MACHINEID_REFNameFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("MACHINEID_REFnamesearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("MACHINEID_REFTable2");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
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

$('#txtMACHINEID_REF_popup').click(function(event){
    showSelectedCheck($("#MACHINEID_REF").val(),"SELECT_MACHINEID_REF");
    $("#MACHINEID_REF_popup").show();
});

$("#MACHINEID_REF_closePopup").click(function(event){
  $("#MACHINEID_REF_popup").hide();
});

$(".clssrequestuser").click(function(){
  var fieldid = $(this).attr('id');
  var txtval =    $("#txt"+fieldid+"").val();
  var texdesc =   $("#txt"+fieldid+"").data("desc");
  var texdesc1 =   $("#txt"+fieldid+"").data("desc1");

  $('#txtMACHINEID_REF_popup').val(texdesc);
  $('#MACHINEID_DESC').val(texdesc1);
  $('#MACHINEID_REF').val(txtval);
  $("#MACHINEID_REF_popup").hide();
  
  $("#MACHINEID_REFcodesearch").val(''); 
  $("#MACHINEID_REFnamesearch").val(''); 
  MACHINEID_REFCodeFunction();
  event.preventDefault();
});

/*================================== ADD/REMOVE FUNCTION ==================================*/

$("#Material").on('click','.add', function() {
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
    var name = el.attr('name') || null;
	if(name){
		var nameLength = name.split('_').pop();
		var i = name.substr(name.length-nameLength.length);
		var prefix1 = name.substr(0, (name.length-nameLength.length));
		el.attr('name', prefix1+(+i+1));
	}
});
  
  $clone.find('input').val('');

  $tr.closest('table').append($clone);         
  var rowCount1 = $('#Row_Count1').val();
  rowCount1 = parseInt(rowCount1)+1;
  $('#Row_Count1').val(rowCount1);
  $clone.find('.remove').removeAttr('disabled');        
  event.preventDefault();
});

$("#Material").on('click', '.remove', function() {
  var rowCount = $(this).closest('table').find('.participantRow').length;
  if (rowCount > 1) {
      $(this).closest('.participantRow').remove();  
      var rowCount1 = $('#Row_Count1').val();
      rowCount1 = parseInt(rowCount1)-1;
      $('#Row_Count1').val(rowCount1);
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


$("#SpareParts").on('click','.add', function() {
  var $tr = $(this).closest('table');
  var allTrs = $tr.find('.participantRow2').last();
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
  
  $clone.find('input').val('');

  $tr.closest('table').append($clone);         
  var rowCount2 = $('#Row_Count2').val();
  rowCount2 = parseInt(rowCount2)+1;
  $('#Row_Count2').val(rowCount2);
  $clone.find('[id*="PMSL_ID_REF"]').val(rowCount2);
  $clone.find('.remove').removeAttr('disabled');        

  event.preventDefault();
});

$("#SpareParts").on('click', '.remove', function() {
  var rowCount = $(this).closest('table').find('.participantRow2').length;
  if (rowCount > 1) {
      $(this).closest('.participantRow2').remove();  
      var rowCount2 = $('#Row_Count2').val();
      rowCount2 = parseInt(rowCount2)-1;
      $('#Row_Count2').val(rowCount2);
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

//================================== ONLOAD FUNCTION ==================================

$(document).ready(function(e) {

  var Material = $("#Material").html(); 
  $('#hdnmaterial').val(Material);

  var SpareParts = $("#SpareParts").html(); 
  $('#hdnSpareParts').val(SpareParts);

  // var lastPMSL_DATE = <?php echo json_encode($HDR->PMSL_DATE); ?>;
  // var today = new Date(); 
  // var mrsdate = <?php echo json_encode($HDR->PMSL_DATE); ?>;
  // $('#PMSL_DATE').attr('min',lastPMSL_DATE);
  // $('#PMSL_DATE').attr('max',mrsdate);

  var lastdt = <?php echo json_encode($objlastdt[0]->PMSL_DATE); ?>;
  var pmsl = <?php echo json_encode($HDR); ?>;
  var today = new Date(); 
  var sodate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2);
  if(lastdt < pmsl.PMSL_DATE)
  {
	$('#PMSL_DATE').attr('min',lastdt);
  }
  else
  {
	  $('#PMSL_DATE').attr('min',pmsl.PMSL_DATE);
  }
  $('#PMSL_DATE').attr('max',sodate);

  var today        = new Date(); 
  var currentdate  = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;

  $('[id*="PMSL_FROM_DATE_"]').attr('min',currentdate);
  $('[id*="PMSL_TO_DATE_"]').attr('min',currentdate);



  $('#btnAdd').on('click', function() {
    var viewURL = '<?php echo e(route("transaction",[$FormId,"add"])); ?>';
    window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });
  
  $('#PMSL_NO').focusout(function(){
      var PMSL_NO   =   $.trim($(this).val());
      if(PMSL_NO ===""){
                $("#FocusId").val('PMSL_NO');
               
                
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn1").show();
                $("#AlertMessage").text('Please enter value in Schedule NO.');
                $("#alert").modal('show');
                $("#OkBtn1").focus();
                highlighFocusBtn('activeOk1');
                
            } 
        else{ 
        var trnsoForm = $("#edit_trn_form");
        var formData = trnsoForm.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'<?php echo e(route("transaction",[$FormId,"checkExist"])); ?>',
            type:'POST',
            data:formData,
            success:function(data) {
               if(data.exists) {
                    $(".text-danger").hide();
                    if(data.exists) {                   
                        console.log("cancel MSG="+data.msg);
                                      $("#YesBtn").hide();
                                      $("#NoBtn").hide();
                                      $("#OkBtn1").show();
                                      $("#AlertMessage").text(data.msg);
                                      $(".text-danger").hide();
                                      $("#PMSL_NO").val('');
                                      $("#alert").modal('show');
                                      $("#OkBtn1").focus();
                                      highlighFocusBtn('activeOk1');
                    }                 
                }                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
            },
        });
    }

   
  });


  $('#PMSL_DATE').change(function( event ) {
    var today = new Date();     
    var d = new Date($(this).val()); 
    today.setHours(0, 0, 0, 0) ;
    d.setHours(0, 0, 0, 0) ;
    var sodate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
    if (d < today) {
        $(this).val(sodate);
        $("#alert").modal('show');
        $("#AlertMessage").text('Schedule Date cannot be less than Current date');
        $("#YesBtn").hide(); 
        $("#NoBtn").hide();  
        $("#OkBtn1").show();
        $("#OkBtn1").focus();
        highlighFocusBtn('activeOk1');
        event.preventDefault();
    }
    else
    {
        event.preventDefault();
    }

    
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

});
</script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('bottom-scripts'); ?>
<script>
var formTrans = $("#edit_trn_form");
formTrans.validate();

$( "#btnSaveFormData" ).click(function() {
  if(formTrans.valid()){
    validateForm("fnSaveData");
  }
});


$( "#btnApprove" ).click(function() {
 
  if(formTrans.valid()){
    validateForm("fnApproveData");
  }
});


function validateForm(saveAction){
 
  $("#FocusId").val('');

  var PMSL_NO           = $.trim($("#PMSL_NO").val());
  var PMSL_DATE         = $.trim($("#PMSL_DATE").val());
  var MACHINEID_REF     = $.trim($("#MACHINEID_REF").val());
  var FLEXIBLE_SCHEDULE = $.trim($("#FLEXIBLE_SCHEDULE").val());
 
  if(PMSL_NO ===""){
    $("#FocusId").val('PMSL_NO');        
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Please Enter Schedule No');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    return false;
  }
  else if(PMSL_DATE ===""){
    $("#FocusId").val('PMSL_DATE');        
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Please Select Schedule Date');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    return false;
  }
  else if(MACHINEID_REF ===""){
    $("#FocusId").val('txtMACHINEID_REF_popup');    
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Please Select Machine Code');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    return false;
  } 
  else if(FLEXIBLE_SCHEDULE ===""){
    $("#FocusId").val('FLEXIBLE_SCHEDULE');    
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Please Select Flexible Schedule');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    return false;
  }
  else{
    event.preventDefault();

    var allblank1 = [];
    var allblank2 = [];
    var allblank3 = [];
    var allblank4 = [];
    var allblank5 = [];
    var allblank6 = [];
    var allblank7 = [];
    var allblank8 = [];
    var allblank9 = [];
      
    var focustext1   = "";
    var focustext2   = "";
    var focustext3   = "";
    var focustext4   = "";
    var focustext5   = "";
    var focustext6   = "";
    var focustext7   = "";
    var focustext8   = "";
    var focustext9   = "";

    $('#Material').find('.participantRow').each(function(){

        if($.trim($(this).find("[id*=PMSL_FROM_DATE]").val()) ===""){
          allblank1.push('false');
          focustext1 = $(this).find("[id*=PMSL_FROM_DATE]").attr('id');
          return false;
        }
        else if($.trim($(this).find("[id*=PMSL_TO_DATE]").val()) ===""){
          allblank2.push('false');
          focustext2 = $(this).find("[id*=PMSL_TO_DATE]").attr('id');
          return false;
        }
        else if($.trim($(this).find("[id*=SPECIAL_INST]").val()) ===""){
          allblank3.push('false');
          focustext3 = $(this).find("[id*=SPECIAL_INST]").attr('id');
          return false;
        }
        else{
          allblank1.push('true');
          allblank2.push('true');
          allblank3.push('true');

          focustext1   = "";
          focustext2   = "";
          focustext3   = "";
          return true;
        }
    });

    $('#SpareParts').find('.participantRow2').each(function(){

      if( $(this).find("[id*=SPARE_PART_NAME]").val() ===""){
        allblank4.push('false');
        focustext4 = $(this).find("[id*=SPARE_PART_NAME]").attr('id');
        return false;
      }
      else{
        allblank4.push('true');
        focustext4   = "";
        return true;
      }

    });

    if(jQuery.inArray("false", allblank1) !== -1){
      $("#FocusId").val(focustext1);
      $("#alert").modal('show');
      $("#AlertMessage").text('Maintenance From Date Is Required In Maintenance');
      $("#YesBtn").hide(); 
      $("#NoBtn").hide();  
      $("#OkBtn1").show();
      $("#OkBtn1").focus();
      highlighFocusBtn('activeOk');
    }
    else if(jQuery.inArray("false", allblank2) !== -1){
      $("#FocusId").val(focustext2);
      $("#alert").modal('show');
      $("#AlertMessage").text('Maintenance To Date Is Required In Maintenance');
      $("#YesBtn").hide(); 
      $("#NoBtn").hide();  
      $("#OkBtn1").show();
      $("#OkBtn1").focus();
      highlighFocusBtn('activeOk');
    }
    else if(jQuery.inArray("false", allblank3) !== -1){
      $("#FocusId").val(focustext3);
      $("#alert").modal('show');
      $("#AlertMessage").text('Special Instruction Is Required in Maintenance');
      $("#YesBtn").hide(); 
      $("#NoBtn").hide();  
      $("#OkBtn1").show();
      $("#OkBtn1").focus();
      highlighFocusBtn('activeOk');
    }
    else if(jQuery.inArray("false", allblank4) !== -1){
      $("#FocusId").val(focustext4);
      $("#alert").modal('show');
      $("#AlertMessage").text('Spare Parts Consumed Is Required in Prior Instruction to Change Spare Parts');
      $("#YesBtn").hide(); 
      $("#NoBtn").hide();  
      $("#OkBtn1").show();
      $("#OkBtn1").focus();
      highlighFocusBtn('activeOk');
    }
    else if(checkPeriodClosing('<?php echo e($FormId); ?>',$("#PMSL_DATE").val(),0) ==0){
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
          $("#YesBtn").data("funcname",saveAction);
          $("#OkBtn1").hide();
          $("#OkBtn").hide();
          $("#YesBtn").show();
          $("#NoBtn").show();
          $("#YesBtn").focus();
          highlighFocusBtn('activeYes');
      }
        
    }

}

$("#YesBtn").click(function(){

$("#alert").modal('hide');
  var customFnName = $("#YesBtn").data("funcname");
  window[customFnName]();

});

window.fnSaveData = function (){

    event.preventDefault();
    var trnsoForm = $("#edit_trn_form");
    var formData = trnsoForm.serialize();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#btnSaveFormData").hide(); 
    $(".buttonload").show(); 
    $("#btnApprove").prop("disabled", true);
    $.ajax({
        url:'<?php echo e(route("transaction",[$FormId,"update"])); ?>',
        type:'POST',
        data:formData,
        success:function(data) {
          $(".buttonload").hide(); 
          $("#btnSaveFormData").show();   
          $("#btnApprove").prop("disabled", false);
          
            if(data.errors) {
                $(".text-danger").hide();

                if(data.errors.PMSL_NO){
                    showError('ERROR_PMSL_NO',data.errors.PMSL_NO);
                            $("#YesBtn").hide();
                            $("#NoBtn").hide();
                            $("#OkBtn1").show();
                            $("#AlertMessage").text('Please enter correct value in Schedule NO.');
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
            $(".buttonload").hide(); 
            $("#btnSaveFormData").show();   
            $("#btnApprove").prop("disabled", false);
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

window.fnApproveData = function (){

    event.preventDefault();
    var trnsoForm = $("#edit_trn_form");
    var formData = trnsoForm.serialize();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#btnApprove").hide(); 
    $(".buttonload_approve").show();  
    $("#btnSaveFormData").prop("disabled", true);
    $.ajax({
        url:'<?php echo e(route("transaction",[$FormId,"Approve"])); ?>',
        type:'POST',
        data:formData,
        success:function(data) {
          $("#btnApprove").show();  
          $(".buttonload_approve").hide();  
          $("#btnSaveFormData").prop("disabled", false);
          
            if(data.errors) {
                $(".text-danger").hide();

                if(data.errors.PMSL_NO){
                    showError('ERROR_PMSL_NO',data.errors.PMSL_NO);
                            $("#YesBtn").hide();
                            $("#NoBtn").hide();
                            $("#OkBtn1").show();
                            $("#AlertMessage").text('Please enter correct value in Schedule NO.');
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
            $("#btnApprove").show();  
            $(".buttonload_approve").hide();  
            $("#btnSaveFormData").prop("disabled", false);
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

$("#NoBtn").click(function(){
    $("#alert").modal('hide');
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
    var FocusId=$("#FocusId").val();
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

/*================================== USER DEFINE FUNCTION ==================================*/

function isNumberDecimalKey(evt){
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  return false;

  return true;
}

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
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\transactions\PlantMaintenance\Preventive_Maintenance_Schedule\trnfrm366edit.blade.php ENDPATH**/ ?>