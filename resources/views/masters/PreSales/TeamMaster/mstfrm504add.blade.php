@extends('layouts.app')
@section('content')

<div class="container-fluid topnav">
  <div class="row">
      <div class="col-lg-2">
      <a href="{{route('master',[$FormId,'index'])}}" class="btn singlebt">Team Master</a>
      </div>
      <div class="col-lg-10 topnav-pd">
      <button class="btn topnavbt" id="btnAdd" disabled="disabled" ><i class="fa fa-plus"></i> Add</button>
      <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
      <button class="btn topnavbt" id="btnSave"  onclick="saveAction('save')" tabindex="3"  ><i class="fa fa-save"></i> Save</button>
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
          @CSRF
          <div class="inner-form">
                <div class="row">
                  <div class="col-lg-2 pl"><p>Team Master Code*</p></div>
                  <div class="col-lg-2 pl">
                  <input type="text" name="DOC_NO" id="DOC_NO" value="{{$docarray['DOC_NO']}}" {{$docarray['READONLY']}} class="form-control" maxlength="{{$docarray['MAXLENGTH']}}" autocomplete="off" style="text-transform:uppercase" >

                    <span class="text-danger" id="ERROR_DOC_NO"></span>
                  </div>

                  <div class="col-lg-2 pl"><p>Document Date*</p></div>
                  <div class="col-lg-2 pl">
                  <input type="date" name="DOC_DT" id="DOC_DT" value="{{date('Y-m-d')}}" class="form-control mandatory" autocomplete="off" placeholder="dd/mm/yyyy" >
                  </div>                  
                </div>

                <div class="row">
                  <div class="col-lg-2 pl"><p>Team Head*</p></div>
                  <div class="col-lg-2 pl">
                    <input type="text" name="TEAMHEAD" id="TEAMHEAD" onclick="getTeamHead()" class="form-control mandatory" value="{{ old('TEAMHEAD') }}" readonly/>
                    <input type="hidden" name="TEAMHEADID_REF" id="TEAMHEADID_REF" class="form-control" autocomplete="off" />
                  </div>
                  
                  <div class="col-lg-2 pl"><p>Team Name</p></div>
                  <div class="col-lg-2 pl">
                    <input type="text" name="TEAMNAME" id="TEAMNAME" class="form-control mandatory" value="{{ old('TEAMNAME') }}"  readonly/>
                  </div>
                </div>                
          </div>
        </form>
    </div>

@endsection
@section('alert')
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
          <button class="btn alertbt" name='YesBtn' id="YesBtn" data-funcname="fnSaveData"><div id="alert-active" class="activeYes"></div>Yes</button>
          <button class="btn alertbt" name='NoBtn' id="NoBtn"   data-funcname="fnUndoNo" ><div id="alert-active" class="activeNo"></div>No</button>
          <button class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;"><div id="alert-active" class="activeOk"></div>OK</button>
          <button class="btn alertbt" name='OkBtn1' id="OkBtn1" onclick="getFocus()" style="display:none;margin-left: 90px;"><div id="alert-active" class="activeOk1"></div>OK</button>
          <input type="hidden" id="FocusId" >
        </div>
		  <div class="cl"></div>
      </div>
    </div>
  </div>
</div>

  <div id="popupmodal" class="modal" role="dialog"  data-backdrop="static">
    <div class="modal-dialog modal-md column3_modal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" id='modal_close' >&times;</button>
        </div>
        <div class="modal-body">
        <div class="tablename"><p id='title_name'></p></div>
        <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
        <table id="TeamhCodeTable" class="display nowrap table  table-striped table-bordered" >
        <thead>
        <tr>
          <th>Select</th> 
          <th><p id='th_code'></th>
          <th><p id='th_name'></th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td class="ROW1"><span class="check_th">&#10004;</span></td>
          <td class="ROW2"><input type="text"  id="codesearch" class="form-control" autocomplete="off" onkeyup="searchData(this.id,1)"></td>
          <td class="ROW3"><input type="text"  id="namesearch" class="form-control" autocomplete="off" onkeyup="searchData(this.id,2)"></td>
          </tr>
        </tbody>
        </table>
          <table id="TeamhCodeTable2" class="display nowrap table  table-striped table-bordered" >
            <thead id="thead2"></thead>
            <tbody id="tbody_divpopp"></tbody>
          </table>
        </div>
        <div class="cl"></div>
        </div>
      </div>
    </div>
  </div>

@endsection
@push('bottom-scripts')
<script>

$("#modal_close").click(function(event){
  $("#popupmodal").hide();
  event.preventDefault();
});

  function getTeamHead(){

      $('#tbody_divpopp').html('Loading...');
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
      $.ajax({
          url:'{{route("master",[$FormId,"getTeamHead"])}}',
          type:'POST',
          success:function(data) {
            var html = '';
            if(data.length > 0){
            $.each(data, function(key, value) {
              html +='<tr>';
              html +='<td style="text-align:center;"><input type="checkbox" name="SELECT_CUSTID_REF[]" id="subgl_'+value.EMPID+'" class="clsts" value="'+value.EMPID+'"></td>';
              html +='<td>'+value.EMPCODE+'</td>';
              html +='<td>'+value.FNAME+'</td>';
              html +='<td hidden><input type="hidden" id="txtsubgl_'+value.EMPID+'" data-desc="'+value.EMPCODE+'" data-fname="'+value.FNAME+'" value="'+value.EMPID+'"/></td>';
              html +='</tr>';
            });
          }
          else{
            html +='<tr><td colspan="3" style="text-align:center;">No data available in table</td></tr>';
          }
          $('#tbody_divpopp').html(html);
              bindTeamHead();
          },

          error: function (request, status, error) {
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn").show();
          $("#AlertMessage").text(request.responseText);
          $("#alert").modal('show');
          $("#OkBtn").focus();
          highlighFocusBtn('activeOk');
          $("#material_data").html('<tr><td colspan="4" style="text-align:center;">No data available in table</td></tr>');                       
        },
      });
      
      $("#title_name").text('Team Head Details');
      $("#th_code").text('Team Code');
      $("#th_name").text('Team Name');    
      $("#popupmodal").show();
      event.preventDefault();
    }

    function bindTeamHead(){
      $('.clsts').click(function(){
      var idsmdl    = $(this).attr('id');
      var addId_Ref =    $("#txt"+idsmdl+"").val();
      var addCode   =   $("#txt"+idsmdl+"").data("desc");
      var fname     =   $("#txt"+idsmdl+"").data("fname");

      $('#TEAMHEAD').val(addCode);
      $('#TEAMHEADID_REF').val(addId_Ref);
      $('#TEAMNAME').val(fname);     
      $("#popupmodal").hide();
    });
  }
  
let tid = "#TeamhCodeTable2";
let tid2 = "#TeamhCodeTable";
let headers = document.querySelectorAll(tid2 + " th");

headers.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(tid, ".clsipoid", "td:nth-child(" + (i + 1) + ")");
  });
});

function searchData(txtid,no){
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById(txtid);
  filter = input.value.toUpperCase();
  table = document.getElementById("TeamhCodeTable2");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[no];
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

  $('#btnAdd').on('click', function() {
      var viewURL = '{{route("master",[$FormId,"add"])}}';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '{{route('home')}}';
    window.location.href=viewURL;
  });
   
  var formTrans = $("#frm_mst_add");
  formTrans.validate();

  function saveAction(action){
    if(formTrans.valid()){
      validateForm(action);
    }
  }

  function alertMsg(id,msg){		
      $("#FocusId").val(id);
      $("#ProceedBtn").focus();
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").show();
      $("#AlertMessage").text(msg);
      $("#alert").modal('show')
      $("#OkBtn1").focus();
      return false;
    }

  function validateForm(action){
    $("#FocusId").val('');
    var DOC_NO          =   $.trim($("#DOC_NO").val());
    var DOC_DT          =   $.trim($("#DOC_DT").val());
    var TEAMHEADID_REF  =   $.trim($("#TEAMHEADID_REF").val());

    if(DOC_NO ===""){
      alertMsg('DOC_NO','Please enter value in DOC No.');
    }
    else if(DOC_DT ===""){
      alertMsg('DOC_DT','Please enter select DOC Date.');
    } 
    else if(TEAMHEADID_REF ===""){   
      alertMsg('TEAMHEAD','Please enter select Team Head.');    
    }  
     else{
      $("#alert").modal('show');
      $("#AlertMessage").text('Do you want to '+action+' to record.');
      $("#YesBtn").data("funcname","fnSaveData");
      $("#YesBtn").data("action",action);
      $("#OkBtn1").hide();
      $("#OkBtn").hide();
      $("#YesBtn").show();
      $("#NoBtn").show();
      $("#YesBtn").focus();
      highlighFocusBtn('activeYes');
    }
  }

  $("#YesBtn").click(function(){
  $("#alert").modal('hide');
  var customFnName  = $("#YesBtn").data("funcname");
  var action        = $("#YesBtn").data("action");

  if(action ==="save"){
    window[customFnName]('{{route("master",[$FormId,"save"])}}');
  }
  else if(action ==="update"){
    window[customFnName]('{{route("master",[$FormId,"update"])}}');
  }
  else if(action ==="approve"){
    window[customFnName]('{{route("master",[$FormId,"Approve"])}}');
  }
  else{
    window.location.href = '{{route("master",[$FormId,"index"]) }}';
  }
});    

window.fnSaveData = function (path){
event.preventDefault();
var trnsoForm = $("#frm_mst_add");
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
  url:path,
  type:'POST',
  data:formData,
  success:function(data) {
    $(".buttonload").hide(); 
    $("#btnSaveFormData").show();   
    $("#btnApprove").prop("disabled", false);
     
    if(data.success){                   
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
  error: function (request, status, error){
    $(".buttonload").hide(); 
    $("#btnSaveFormData").show();   
    $("#btnApprove").prop("disabled", false);
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text(request.responseText);
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
  },
});
}
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
      window.location.href = "{{route('master',[$FormId,'index'])}}";
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
          //window.location.href = "{{route('master',[$FormId,'index'])}}";
          });

      $("#OkBtn").click(function(){
        $("#alert").modal('hide');
      });

    window.fnUndoYes = function (){
      window.location.href = "{{route('master',[$FormId,'add'])}}";
    }

  window.fnUndoNo = function (){
  $("#OPPORTUNITY_STAGECODE").focus();
  }
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

  function onlyNumberKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode != 46 && ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
  }
  

  check_exist_docno(@json($docarray['EXIST']));
  
</script>
@endpush