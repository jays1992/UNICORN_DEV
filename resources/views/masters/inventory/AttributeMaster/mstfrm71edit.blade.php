@extends('layouts.app')
@section('content')


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="{{route('master',[71,'index'])}}" class="btn singlebt">Attribute Master</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button href="#" id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button id="btnSave"   class="btn topnavbt" tabindex="4"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView"  disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt"  id="btnUndo" ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled" ><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" {{ (isset($objRights->APPROVAL1) || isset($objRights->APPROVAL2) || isset($objRights->APPROVAL3) || isset($objRights->APPROVAL4) || isset($objRights->APPROVAL5)) &&  ($objRights->APPROVAL1||$objRights->APPROVAL2||$objRights->APPROVAL3||$objRights->APPROVAL4||$objRights->APPROVAL5) == 1 ? '' : 'disabled'}} ><i class="fa fa-lock"></i> Approved</button>
                        <a href="#" class="btn topnavbt"  disabled="disabled"><i class="fa fa-link" ></i> Attachment</a>
                        <button class="btn topnavbt" id="btnExit"><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
         <form id="frm_mst_edit" method="POST" onsubmit="return validateForm()" class="needs-validation"  > 
          @CSRF
          {{isset($objResponse->ATTID) ? method_field('PUT') : '' }}
          <div class="inner-form">
          
              
              <div class="row">
                  <div class="col-lg-2 pl"><p>Attribute Code</p></div>
                  <div class="col-lg-2 pl">
                  
                    <label> {{$objResponse->ATTCODE}} </label>
                    <input type="hidden" name="ATTID" id="ATTID" value="{{ $objResponse->ATTID }}" />
                    <input type="hidden" name="ATTCODE" id="ATTCODE" value="{{ $objResponse->ATTCODE }}" autocomplete="off"  maxlength="20"   />
                    <input type="hidden" name="user_approval_level" id="user_approval_level" value="{{ $user_approval_level }}"  />
                  
                </div>
                </div>

                <div class="row">
                
                  <div class="col-lg-2 pl"><p>Attribute Description</p></div>
                  <div class="col-lg-5 pl">
                    <input type="text" name="DESCRIPTIONS" id="DESCRIPTIONS" class="form-control mandatory" value="{{ old('DESCRIPTIONS',$objResponse->DESCRIPTIONS) }}" maxlength="100" tabindex="1"  />
                    <span class="text-danger" id="ERROR_DESCRIPTIONS"></span> 
                  </div>
                </div>

              <div class="row">
                <div class="col-lg-2 pl"><p>De-Activated</p></div>
                <div class="col-lg-1 pl pr">
                <input type="checkbox"   name="DEACTIVATED"  id="deactive-checkbox_0" {{$objResponse->DEACTIVATED == 1 ? "checked" : ""}}
                 value='{{$objResponse->DEACTIVATED == 1 ? 1 : 0}}' tabindex="2"  >
                </div>
                
                <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
                <div class="col-lg-2 pl">
                  <input type="date" name="DODEACTIVATED" class="form-control" id="DODEACTIVATED" {{$objResponse->DEACTIVATED == 1 ? "" : "disabled"}} value="{{isset($objResponse->DODEACTIVATED) && $objResponse->DODEACTIVATED !="" && $objResponse->DODEACTIVATED !="1900-01-01" ? $objResponse->DODEACTIVATED:''}}" tabindex="3" placeholder="dd/mm/yyyy"  />
                </div>
             </div>


             <div class="row">
                  <div class="col-lg-5 pl">
                    <div class=" table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:300px;" >
                      <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                        <thead id="thead1"  style="position: sticky;top: 0">
                          <tr>
                          <th>
                              VALUE
                              <input class="form-control" type="hidden" name="Row_Count" id ="Row_Count"> 
                              <input type="hidden" id="focusid" >
                              <input type="hidden" id="errorid" >
                              
                          </th>
                          <th width="5%">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(!empty($objDataResponse))
                        @php $n=1; @endphp
                        @foreach($objDataResponse as $key => $row)
                          <tr  class="participantRow">
                            <td>
                            <input class="form-control w-100" type="text" name={{"VALUE_".$key}} id ={{"txtvalue_".$key}}  value="{{ $row->VALUE }}" maxlength="100" autocomplete="off" style="text-transform:uppercase;width:100%;" onkeypress="return AlphaNumaricSpace(event,this)" >
                            <input  type="hidden" name={{"ATTVID_".$key}} id ={{"txtattvid_".$key}}  value="{{ $row->ATTVID }}" >
                            
                            </td>
                              
                              <td align="center" >
                                  <button class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                                  <button class="btn remove" title="Delete" data-toggle="tooltip" {{isset($n) && $n ==1?'disabled':''}}  ><i class="fa fa-trash" ></i></button>
                              </td>
                          </tr>
                          @php $n++; @endphp
                          @endforeach 
                          @endif     
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>



          </div>
        </form>
    </div><!--purchase-order-view-->


@endsection
@section('alert')
<!-- Alert -->
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
            <button onclick="setfocus();" class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;">
              <div id="alert-active" class="activeOk"></div>OK</button>
        </div><!--btdiv-->
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Alert -->
@endsection
<!-- btnSave -->

@push('bottom-scripts')
<script>
function setfocus(){
    var focusid=$("#focusid").val();
    $("#"+focusid).focus();
    $("#closePopup").click();
} 

function validateForm(UserAction){

    $("#focusid").val('');
    $("#errorid").val('');
    var txtvalue  =   $.trim($("[id*=txtvalue]").val());
    
    if(txtvalue ===""){
        $("#focusid").val('txtvalue_0');
        $("#errorid").val('1');
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn").show();
        $("#AlertMessage").text('Please enter value.');
        $("#alert").modal('show');
        $("#OkBtn").focus();
        highlighFocusBtn('activeOk');
        return false;
    }
    else{
        event.preventDefault();

        var RackArray = []; 
        var allblank1 = []; 
        var allblank5 = []; 
        var texid1    = "";
        var texid5    = "";
       
        $("[id*=txtvalue]").each(function(){
 
            if($.trim($(this).val()) ===""){
              allblank1.push('true');
              texid1 = $(this).attr('id');
            }
            else if (RackArray.indexOf($.trim($(this).val())) > -1) {
              allblank5.push('true');
              texid5 = $(this).attr('id');
            }
            else{
              allblank1.push('false');
              allblank5.push('false');
            }

            RackArray.push($.trim($(this).val()));
           
        });

        if(jQuery.inArray("true", allblank1) !== -1){
            $("#errorid").val('1');
            $("#focusid").val(texid1);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").show();
            $("#AlertMessage").text('Please enter value.');
            $("#alert").modal('show');
            $("#OkBtn").focus();
            highlighFocusBtn('activeOk');
            return false;
          }
          else if(jQuery.inArray("true", allblank5) !== -1){
            $("#errorid").val('1');
            $("#focusid").val(texid5);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").show();
            $("#AlertMessage").text('Duplicate value.');
            $("#alert").modal('show');
            $("#OkBtn").focus();
            highlighFocusBtn('activeOk');
            return false;
          }
          else{
              $("#errorid").val('');
              $("#alert").modal('show');
              $("#AlertMessage").text('Do you want to save to record.');
              $("#YesBtn").data("funcname",UserAction);  
              $("#YesBtn").focus();
              highlighFocusBtn('activeYes');
          }

    }
  
}

$(document).ready(function(e) {

    var rcount = <?php echo json_encode($objCount); ?>;

    $('#Row_Count').val(rcount);

    $("#example2").on('click', '.add', function() {
        var $tr = $(this).closest('tbody');
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

        $clone.find('input:text').val('');
        $tr.closest('table').append($clone);
        var rowCount = $('#Row_Count').val();
        rowCount = parseInt(rowCount)+1;
        $('#Row_Count').val(rowCount);
        $clone.find('.remove').removeAttr('disabled'); 
        //$clone.find('[id*="txtvalue"]').removeAttr('readonly'); 

        event.preventDefault();

    });

    $("#example2").on('click', '.remove', function() {

        var rowCount = $('#Row_Count').val();
        if (rowCount > 1) {
            $(this).closest('.participantRow').remove(); 
        } 
        if (rowCount <= 1) { 
            $(document).find('.remove').prop('disabled', true);  
        }

        event.preventDefault();

    });

});


$('#btnAdd').on('click', function() {
      var viewURL = '{{route("master",[71,"add"])}}';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '{{route('home')}}';
    window.location.href=viewURL;
  });

 var formDataMst = $( "#frm_mst_edit" );
     formDataMst.validate();

    $("#DESCRIPTIONS").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_DESCRIPTIONS").hide();
        validateSingleElemnet("DESCRIPTIONS");

    });
    $("#DESCRIPTIONS").keydown(function(){       
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
            required: "Required field"
        }
    });

    $("#DODEACTIVATED").blur(function(){
      $(this).val($.trim( $(this).val() ));
      $("#ERROR_DODEACTIVATED").hide();
      validateSingleElemnet("DODEACTIVATED");
    });

    $( "#DODEACTIVATED" ).rules( "add", {
        required: true,
        DateValidate:true,
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field"
        }
    });

    //validae single element
    function validateSingleElemnet(element_id){
      var validator =$("#frm_mst_edit" ).validate();
          validator.element( "#"+element_id+"" );
    }

    //validate
    $( "#btnSave" ).click(function() {

        if(formDataMst.valid()){
           
            validateForm('fnSaveData');

        }

    });//btnSave

    
    //validate and approve
    $("#btnApprove").click(function() {
        
        if(formDataMst.valid()){
           
            validateForm('fnApproveData');

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
            url:'{{route("mastermodify",[71,"update"])}}',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();

                    if(data.errors.DESCRIPTIONS){
                        showError('ERROR_DESCRIPTIONS',data.errors.DESCRIPTIONS);
                    }
                   if(data.exist=='norecord') {
                      $("#errorid").val('1');
                      $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn").show();

                      $("#AlertMessage").text(data.msg);

                      $("#alert").modal('show');
                      $("#OkBtn").focus();

                   }
                   if(data.save=='invalid') {
                      $("#errorid").val('1');
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
                    $("#frm_mst_edit").trigger("reset");

                    $("#alert").modal('show');
                    $("#OkBtn").focus();

                }
                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
            },
        });

    };// fnSaveData


    // save and approve 
    window.fnApproveData = function (){
        
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
            url:'{{route("mastermodify",[71,"singleapprove"])}}',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();

                    if(data.errors.DESCRIPTIONS){
                        showError('ERROR_DESCRIPTIONS',data.errors.DESCRIPTIONS);
                    }
                   if(data.exist=='norecord') {
                      $("#errorid").val('1');
                      $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn").show();

                      $("#AlertMessage").text(data.msg);

                      $("#alert").modal('show');
                      $("#OkBtn").focus();

                   }
                   if(data.save=='invalid') {
                      $("#errorid").val('1');
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
                    $("#frm_mst_edit").trigger("reset");

                    $("#alert").modal('show');
                    $("#OkBtn").focus();

                }
                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
            },
        });

    };// fnApproveData

    //no button
    $("#NoBtn").click(function(){

      $("#alert").modal('hide');
      var custFnName = $("#NoBtn").data("funcname");
          window[custFnName]();

    }); //no button

   
    $("#OkBtn").click(function(){

        $("#alert").modal('hide');

        $("#YesBtn").show();
        $("#NoBtn").show();
        $("#OkBtn").hide();

        $(".text-danger").hide();

        if($("#errorid").val() ===""){
            window.location.href = '{{route("master",[71,"index"]) }}';
        }

        //window.location.href = '{{route("master",[71,"index"]) }}';

    }); ///ok button

    $("#btnUndo").click(function(){

        $("#AlertMessage").text("Do you want to erase entered information in this record?");
        $("#alert").modal('show');

        $("#YesBtn").data("funcname","fnUndoYes");
        $("#YesBtn").show();

        $("#NoBtn").data("funcname","fnUndoNo");
        $("#NoBtn").show();

        $("#OkBtn").hide();
        $("#NoBtn").focus();
        highlighFocusBtn('activeNo');

    }); ////Undo button

   
    $("#OkBtn").click(function(){
      
        $("#alert").modal('hide');

    });////ok button


   window.fnUndoYes = function (){
      
      //reload form
      window.location.reload();

   }//fnUndoYes


   window.fnUndoNo = function (){

      $("#ATTCODE").focus();

   }//fnUndoNo


    //
    function showError(pId,pVal){

      $("#"+pId+"").text(pVal);
      $("#"+pId+"").show();

    }  

    function highlighFocusBtn(pclass){
       $(".activeYes").hide();
       $(".activeNo").hide();
       
       $("."+pclass+"").show();
    }

</script>
<script type="text/javascript">
$(function () {
	
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

$(function() { 
  //$("#DESCRIPTIONS").focus(); 
});
</script>


@endpush