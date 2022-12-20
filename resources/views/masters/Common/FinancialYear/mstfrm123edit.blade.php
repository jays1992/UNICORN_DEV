@extends('layouts.app')
@section('content')


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="{{route('master',[123,'index'])}}" class="btn singlebt">Financial Year Master</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button href="#" id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                        <button id="btnSave"   class="btn topnavbt" tabindex="8"><i class="fa fa-floppy-o"></i> Save</button>
                        <button class="btn topnavbt" id="btnView"  disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt"  id="btnUndo" ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled" ><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" {{ (isset($objRights->APPROVAL1) || isset($objRights->APPROVAL2) || isset($objRights->APPROVAL3) || isset($objRights->APPROVAL4) || isset($objRights->APPROVAL5)) &&  ($objRights->APPROVAL1||$objRights->APPROVAL2||$objRights->APPROVAL3||$objRights->APPROVAL4||$objRights->APPROVAL5) == 1 ? '' : 'disabled'}}><i class="fa fa-thumbs-o-up"></i> Approved</button>
                        <a href="#" class="btn topnavbt"  disabled="disabled"><i class="fa fa-link" ></i> Attachment</a>
                        <button class="btn topnavbt" id="btnExit"><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
         <form id="frm_mst_edit" method="POST"  > 
          @CSRF
          {{isset($objResponse->FYID) ? method_field('PUT') : '' }}
          <div class="inner-form">
          
              
              <div class="row">
                  <div class="col-lg-1 pl"><p>FY Code</p></div>
                  <div class="col-lg-2 pl">
                  
                    <label> {{$objResponse->FYCODE}} </label>
                    <input type="hidden" name="FYID" id="FYID" value="{{ $objResponse->FYID }}" />
                    <input type="hidden" name="FYCODE" id="FYCODE" value="{{ $objResponse->FYCODE }}" autocomplete="off"  maxlength="6"   />
                    <input type="hidden" name="user_approval_level" id="user_approval_level" value="{{ $user_approval_level }}"  />
                  
                </div>
                </div>

                <div class="row">
                
                  <div class="col-lg-1 pl"><p>FY Description</p></div>
                  <div class="col-lg-3 pl">
                    <input type="text" name="FYDESCRIPTION" id="FYDESCRIPTION" class="form-control mandatory" value="{{ old('FYDESCRIPTION',$objResponse->FYDESCRIPTION) }}" maxlength="30" tabindex="1"  />
                    <span class="text-danger" id="ERROR_FYDESCRIPTION"></span> 
                  </div>
                </div>


                <div class="row">
                  <div class="col-lg-1 pl"><p>FY Start Month</p></div>
                  <div class="col-lg-1 pl">
                   
                      <select name="FYSTMONTH" id="FYSTMONTH" class="form-control mandatory" tabindex="2">
                        <option value="" selected="">Select</option>
                        @foreach($objMonthList as $MonthList)
                        <option {{isset($objResponse->FYSTMONTH) && $objResponse->FYSTMONTH ==$MonthList->MTCODE?'selected="selected"':''}} value="{{$MonthList->MTCODE}}">{{$MonthList->MTCODE}}</option>
                        @endforeach
                      </select>
                      <span class="text-danger" id="ERROR_FYSTMONTH"></span> 
                   
                  </div>

                  <div class="col-lg-1 pl"><p>FY Start Year</p></div>
                  <div class="col-lg-1 pl">
                    
                      <select name="FYSTYEAR" id="FYSTYEAR" class="form-control mandatory" tabindex="3">
                        <option value="" selected="">Select</option>
                        @foreach($objYearList as $YearList)
                        <option {{isset($objResponse->FYSTYEAR) && $objResponse->FYSTYEAR ==$YearList->YRCODE?'selected="selected"':''}} value="{{$YearList->YRCODE}}">{{$YearList->YRCODE}}</option>
                        @endforeach
                      </select>
                      <span class="text-danger" id="ERROR_FYSTYEAR"></span> 
                   
                  </div>

                </div>

                <div class="row">
                  <div class="col-lg-1 pl"><p>FY End Month</p></div>
                  <div class="col-lg-1 pl">
                   
                      <select name="FYENDMONTH" id="FYENDMONTH" class="form-control mandatory" tabindex="4">
                        <option value="" selected="">Select</option>
                        @foreach($objMonthList as $MonthList)
                        <option {{isset($objResponse->FYENDMONTH) && $objResponse->FYENDMONTH ==$MonthList->MTCODE?'selected="selected"':''}} value="{{$MonthList->MTCODE}}">{{$MonthList->MTCODE}}</option>
                        @endforeach
                      </select>
                      <span class="text-danger" id="ERROR_FYENDMONTH"></span> 
                   
                  </div>

                  <div class="col-lg-1 pl"><p>FY End Year</p></div>
                  <div class="col-lg-1 pl">
                    
                      <select name="FYENDYEAR" id="FYENDYEAR" class="form-control mandatory" tabindex="5">
                      <option value="" selected="">Select</option>
                        @foreach($objYearList as $YearList)
                        <option {{isset($objResponse->FYENDYEAR) && $objResponse->FYENDYEAR ==$YearList->YRCODE?'selected="selected"':''}} value="{{$YearList->YRCODE}}">{{$YearList->YRCODE}}</option>
                        @endforeach
                      </select>
                      <span class="text-danger" id="ERROR_FYENDYEAR"></span> 
                   
                  </div>

                </div>
          
          
             
              

              <div class="row">
                <div class="col-lg-1 pl"><p>De-Activated</p></div>
                <div class="col-lg-1 pl pr">
                <input type="checkbox"   name="DEACTIVATED"  id="deactive-checkbox_0" {{$objResponse->DEACTIVATED == 1 ? "checked" : ""}}
                 value='{{$objResponse->DEACTIVATED == 1 ? 1 : 0}}' tabindex="6"  >
                </div>
                
                <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
                <div class="col-lg-2 pl">
                  <input type="date" name="DODEACTIVATED" class="form-control" id="DODEACTIVATED" {{$objResponse->DEACTIVATED == 1 ? "" : "disabled"}} value="{{isset($objResponse->DODEACTIVATED) && $objResponse->DODEACTIVATED !="" && $objResponse->DODEACTIVATED !="1900-01-01" ? $objResponse->DODEACTIVATED:''}}" tabindex="7" placeholder="dd/mm/yyyy"  />
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
            <button class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;">
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
$('#btnAdd').on('click', function() {
      var viewURL = '{{route("master",[123,"add"])}}';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '{{route('home')}}';
    window.location.href=viewURL;
  });

 var formDataMst = $( "#frm_mst_edit" );
     formDataMst.validate();

    $("#FYDESCRIPTION").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_FYDESCRIPTION").hide();
        validateSingleElemnet("FYDESCRIPTION");

    });

    $( "#FYDESCRIPTION" ).rules( "add", {
        required: true,
        //StringRegex: true,  //from custom.js
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field"
        }
    });

    $("#FYSTMONTH").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_FYSTMONTH").hide();
        validateSingleElemnet("FYSTMONTH");
    });

    $( "#FYSTMONTH" ).rules( "add", {
        required: true,
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field."
        }
    });

    $("#FYSTYEAR").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_FYSTYEAR").hide();
        validateSingleElemnet("FYSTYEAR");
    });

    $( "#FYSTYEAR" ).rules( "add", {
        required: true,
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field."
        }
    });

    $("#FYENDMONTH").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_FYENDMONTH").hide();
        validateSingleElemnet("FYENDMONTH");
    });

    $( "#FYENDMONTH" ).rules( "add", {
        required: true,
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field."
        }
    });

    $("#FYENDYEAR").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_FYENDYEAR").hide();
        validateSingleElemnet("FYENDYEAR");
    });

    $( "#FYENDYEAR" ).rules( "add", {
        required: true,
        normalizer: function(value) {
            return $.trim(value);
        },
        messages: {
            required: "Required field."
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
            //set function nane of yes and no btn 
            $("#alert").modal('show');
            $("#AlertMessage").text('Do you want to save to record.');
            $("#YesBtn").data("funcname","fnSaveData");  //set dynamic fucntion name
            $("#YesBtn").focus();
            highlighFocusBtn('activeYes');

        }

    });//btnSave

    
    //validate and approve
    $("#btnApprove").click(function() {
        
        if(formDataMst.valid()){
            //set function nane of yes and no btn 
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
            url:'{{route("mastermodify",[123,"update"])}}',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();

                    if(data.errors.FYDESCRIPTION){
                        showError('ERROR_FYDESCRIPTION',data.errors.FYDESCRIPTION);
                    }
                   if(data.exist=='norecord') {

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
            url:'{{route("mastermodify",[123,"singleapprove"])}}',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();

                    if(data.errors.FYDESCRIPTION){
                        showError('ERROR_FYDESCRIPTION',data.errors.FYDESCRIPTION);
                    }
                   if(data.exist=='norecord') {

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
        window.location.href = '{{route("master",[123,"index"]) }}';

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

      $("#FYCODE").focus();

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
  //$("#FYDESCRIPTION").focus(); 
});
</script>


@endpush