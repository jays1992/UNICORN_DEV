@extends('layouts.app')
@section('content')


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="{{route('master',[76,'index'])}}" class="btn singlebt">Store Master</a>
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
         
          @CSRF
          <div class="inner-form">
              
                <div class="row">
                  <div class="col-lg-2 pl"><p>Store Code</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-11 pl">
                    <input type="text" name="STCODE" id="STCODE" value="{{$docarray['DOC_NO']}}" {{$docarray['READONLY']}} class="form-control" maxlength="{{$docarray['MAXLENGTH']}}" autocomplete="off" style="text-transform:uppercase" >

                
                        <span class="text-danger" id="ERROR_STCODE"></span> 
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-2 pl"><p>Store Name</p></div>
                  <div class="col-lg-5 pl">
                    <input type="text" name="NAME" id="NAME" class="form-control mandatory" value="{{ old('NAME') }}" maxlength="200" tabindex="2"  />
                    <span class="text-danger" id="ERROR_NAME"></span> 
                  </div>
                </div>


                <div class="row">
                  <div class="col-lg-2 pl"><p>Registered Address Line 1</p></div>
                  <div class="col-lg-4 pl">
                    <input type="text" name="Address1" id="Address1" class="form-control mandatory"  maxlength="200" required tabindex="7" >
                    <span class="text-danger" id="ERROR_REGADDL1"></span>
                  </div>
                  
                    <div class="col-lg-2 pl"><p>Registered Address Line 2</p></div>
                  <div class="col-lg-4 pl">
                    <input type="text" name="Address2" id="Address2" class="form-control"  maxlength="200" tabindex="8" >
                  </div>
                
                </div>

                <div class="row">
			
                  <div class="col-lg-2 pl"><p>Country</p></div>
                  <div class="col-lg-2 pl">
                    <input type="text" name="CTRYID_REF_POPUP" id="CTRYID_REF_POPUP" class="form-control mandatory" required readonly tabindex="9" />
                    <input type="hidden" name="CTRYID_REF" id="CTRYID_REF" />
                    <span class="text-danger" id="ERROR_CTRYID_REF"></span>
                  </div>
                  
                  <div class="col-lg-1 pl"><p>State</p></div>
                  <div class="col-lg-2 pl">
                    <input type="text" name="STID_REF_POPUP" id="STID_REF_POPUP" class="form-control mandatory" required readonly tabindex="10" />
                    <input type="hidden" name="STID_REF" id="STID_REF" />
                    <span class="text-danger" id="ERROR_STID_REF"></span>
                  </div>
                
                  <div class="col-lg-1 pl"><p>City</p></div>
                  <div class="col-lg-2 pl">
                    <input type="text" name="CITYID_REF_POPUP" id="CITYID_REF_POPUP" class="form-control mandatory" required readonly tabindex="11" />
                    <input type="hidden" name="CITYID_REF" id="CITYID_REF" />
                    <span class="text-danger" id="ERROR_CITYID_REF"></span>
                  </div>
                  
                    
                  <div class="col-lg-1 pl"><p>Pincode</p></div>
                  <div class="col-lg-1 pl">
                    <input type="text" name="PINCODE" id="PINCODE" class="form-control "  maxlength="10" tabindex="12"  autocomplete="off" >
                  </div>
                
                </div>





                <div class="row">
                  <div class="col-lg-6 pl">
                    <div class=" table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:300px;" >
                      <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                        <thead id="thead1"  style="position: sticky;top: 0">
                          <tr>
                          <th>
                              Rack No
                              <input class="form-control" type="hidden" name="Row_Count" id ="Row_Count"> 
                              <input type="hidden" id="focusid" >
                          </th>
                          <th>Rack Description</th>
                          <th>BIN No</th>
                          <th width="5%">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr  class="participantRow">
                              <td><input  class="form-control w-100" type="text" name="RACKNO_0" id ="txtrackno_0"  maxlength="30" autocomplete="off" style="text-transform:uppercase;width:100%;" onkeypress="return AlphaNumaric(event,this)" ></td>
                              <td><input  class="form-control w-100" type="text" name="DESCRIPTIONS_0" id ="txtdesc_0" maxlength="200" autocomplete="off" style="width:100%;" ></td>
                              <td><input  class="form-control w-100" type="text" name="BINNO_0" id ="txtbin_0" maxlength="15" autocomplete="off" style="width:100%;" onkeypress="return AlphaNumaric(event,this)" ></td>

                              <td align="center" >
                                  <button class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                                  <button class="btn remove" title="Delete" data-toggle="tooltip" disabled><i class="fa fa-trash" ></i></button>
                              </td>
                          </tr>
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


<!--******************************** START Country State City *********************************************************-->
  <!-- Country popup Div-->

<div id="cor_ctryidref_popup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id='cor_ctryidref_close' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Country</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">

      <table id="cor_country_tab1" class="display nowrap table  table-striped table-bordered" width="100%">
        <thead>
          <tr>
            <th class="ROW1" style="width: 10%" align="center">Select</th> 
            <th class="ROW2" style="width: 40%" >Code</th>
            <th class="ROW3" style="width: 40%" >Name</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <td class="ROW1" style="width: 10%" align="center"><span class="check_th">&#10004;</span></td>
          <td class="ROW2"  style="width: 40%"><input type="text" autocomplete="off"  class="form-control" id="cor_country_codesearch" onkeyup="searchCountryCode()" /></td>
          <td class="ROW3"  style="width: 40%"><input type="text" autocomplete="off"  class="form-control" id="cor_country_namesearch" onkeyup="searchCountryName()" /></td>
        </tr>
        </tbody>
      </table>


      <table id="cor_country_tab2" class="display nowrap table  table-striped table-bordered" width="100%">
        <tbody id="cor_country_body">
        @foreach ($objCountryList as $index=>$CountryList)
        
        <tr >
          <td class="ROW1" style="width: 12%" align="center"> <input type="checkbox" name="SELECT_CORCTRYID_REF[]"  id="cor_ctryidref_{{ $CountryList->CTRYID }}" class="cls_cor_ctryidref" value="{{ $CountryList->CTRYID }}" ></td>
          <td class="ROW2" style="width: 39%">{{ $CountryList->CTRYCODE }}
          <input type="hidden" id="txtcor_ctryidref_{{ $CountryList->CTRYID }}" data-desc="{{ $CountryList->CTRYCODE }} - {{ $CountryList->NAME }}" value="{{ $CountryList->CTRYID }}"/>
          </td>
          <td class="ROW3" style="width: 39%">{{ $CountryList->NAME }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>


<!-- State popup Div-->
<div id="cor_stidref_popup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id='cor_stidref_close' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>State</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">

      <table id="cor_state_tab1" class="display nowrap table  table-striped table-bordered" width="100%">
        <thead>
          <tr>
            <th class="ROW1" style="width: 10%" align="center">Select</th> 
            <th class="ROW2" style="width: 40%" >Code</th>
            <th class="ROW3" style="width: 40%" >Name</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <td class="ROW1" style="width: 10%" align="center"><span class="check_th">&#10004;</span></td>
          <td class="ROW2"  style="width: 40%"><input type="text" autocomplete="off"  class="form-control" id="cor_state_codesearch" onkeyup="searchStateCode()" /></td>
          <td class="ROW3"  style="width: 40%"><input type="text" autocomplete="off"  class="form-control" id="cor_state_namesearch" onkeyup="searchStateName()" /></td>
        </tr>
        </tbody>
      </table>

      <table id="cor_state_tab2" class="display nowrap table  table-striped table-bordered" width="100%">
        <tbody id="cor_state_body">
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>


<!-- City popup Div-->
<div id="cor_cityidref_popup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id='cor_cityidref_close' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>City</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">

      <table id="cor_city_tab1" class="display nowrap table  table-striped table-bordered" width="100%">
        <thead>
          <tr>
            <th class="ROW1" style="width: 10%" align="center">Select</th> 
            <th class="ROW2" style="width: 40%" >Code</th>
            <th class="ROW3" style="width: 40%" >Name</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <td class="ROW1" style="width: 10%" align="center"><span class="check_th">&#10004;</span></td>
          <td class="ROW2"  style="width: 40%"><input type="text" autocomplete="off"  class="form-control"  id="cor_city_codesearch" onkeyup="searchCityCode()" /></td>
          <td class="ROW3"  style="width: 40%"><input type="text" autocomplete="off"  class="form-control"  id="cor_city_namesearch" onkeyup="searchCityName()" /></td>
        </tr>
        </tbody>
      </table>

      <table id="cor_city_tab2" class="display nowrap table  table-striped table-bordered" width="100%">
        <tbody id="cor_city_body">
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!--******************************** END Country State City *********************************************************-->

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

function validateForm(){

    $("#focusid").val('');
    var txtrackno  =   $.trim($("[id*=txtrackno]").val());
    var txtdesc     =   $.trim($("[id*=txtdesc]").val());
    var txtbin     =   $.trim($("[id*=txtbin]").val());

    var STCODE          =   $.trim($("#STCODE").val());

    $("#OkBtn1").hide();

    if(STCODE ===""){
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").hide();  
      $("#OkBtn").show();              
      $("#AlertMessage").text('Please enter Store Code.');
      $("#alert").modal('show');
      $("#OkBtn").focus();
      return false;
    }
    else if(txtrackno ==="" && txtdesc !=""){
        $("#focusid").val('txtrackno_0');
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").hide();
        $("#OkBtn").show();
        $("#AlertMessage").text('Please enter rack no.');
        $("#alert").modal('show');
        $("#OkBtn").focus();
        highlighFocusBtn('activeOk');
        return false;
    }
    else if(txtrackno ==="" && txtbin !=""){
        $("#focusid").val('txtrackno_0');
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").hide();
        $("#OkBtn").show();
        $("#AlertMessage").text('Please enter rack no.');
        $("#alert").modal('show');
        $("#OkBtn").focus();
        highlighFocusBtn('activeOk');
        return false;
    }
    else if(txtrackno !="" && txtdesc ===""){
        $("#focusid").val('txtdesc_0');
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").hide();
        $("#OkBtn").show();
        $("#AlertMessage").text('Please enter description.');
        $("#alert").modal('show');
        $("#OkBtn").focus();
        highlighFocusBtn('activeOk');
        return false;
    }
    else if(txtrackno !="" && txtbin ===""){
        $("#focusid").val('txtbin_0');
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").hide();
        $("#OkBtn").show();
        $("#AlertMessage").text('Please enter bin no.');
        $("#alert").modal('show');
        $("#OkBtn").focus();
        highlighFocusBtn('activeOk');
        return false;
    }
    else{
        event.preventDefault();
        var RackArray = []; 
        var allblank1 = [];  
        var allblank2 = [];
        var allblank3 = [];
        var allblank4 = [];
        var allblank5 = []; 
        var texid1    = "";
        var texid2    = "";
        var texid3    = "";
        var texid4    = "";
        var texid5    = "";
   
        $("[id*=txtrackno]").each(function(){

            if($.trim($(this).val()) ==="" && $.trim($(this).parent().parent().find('[id*="txtdesc"]').val()) != "" ){
              allblank1.push('true');
              texid1 = $(this).attr('id');
            }
            else if($.trim($(this).val()) ==="" && $.trim($(this).parent().parent().find('[id*="txtbin"]').val()) != "" ){
              allblank2.push('true');
              texid2 = $(this).attr('id');
            }
            else if($.trim($(this).val()) !="" && $.trim($(this).parent().parent().find('[id*="txtdesc"]').val()) === "" ){
              allblank3.push('true');
              texid3 = $(this).parent().parent().find('[id*="txtdesc"]').attr('id');
            }
            else if($.trim($(this).val()) !="" && $.trim($(this).parent().parent().find('[id*="txtbin"]').val()) === "" ){
              allblank4.push('true');
              texid4 = $(this).parent().parent().find('[id*="txtbin"]').attr('id');
            }
            else if (RackArray.indexOf($.trim($(this).val())+$.trim($(this).parent().parent().find('[id*="txtbin"]').val())) > -1) {
              allblank5.push('true');
              texid5 = $(this).attr('id');
            }
            else{
              allblank1.push('false');
              allblank2.push('false');
              allblank3.push('false');
              allblank4.push('false');
              allblank5.push('false');
            }

            RackArray.push($.trim($(this).val())+$.trim($(this).parent().parent().find('[id*="txtbin"]').val()));
           
        });

        
        if(jQuery.inArray("true", allblank1) !== -1){
          $("#focusid").val(texid1);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").hide();
            $("#OkBtn").show();
            $("#AlertMessage").text('Please enter rack no.');
            $("#alert").modal('show');
            $("#OkBtn").focus();
            highlighFocusBtn('activeOk');
            return false;
          }
          else if(jQuery.inArray("true", allblank2) !== -1){
            $("#focusid").val(texid2);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").hide();
            $("#OkBtn").show();
            $("#AlertMessage").text('Please enter rack no.');
            $("#alert").modal('show');
            $("#OkBtn").focus();
            highlighFocusBtn('activeOk');
            return false;
          }
          else if(jQuery.inArray("true", allblank3) !== -1){
            $("#focusid").val(texid3);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").hide();
            $("#OkBtn").show();
            $("#AlertMessage").text('Please enter description.');
            $("#alert").modal('show');
            $("#OkBtn").focus();
            highlighFocusBtn('activeOk');
            return false;
          }
          else if(jQuery.inArray("true", allblank4) !== -1){
            $("#focusid").val(texid4);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").hide();
            $("#OkBtn").show();
            $("#AlertMessage").text('Please enter bin no.');
            $("#alert").modal('show');
            $("#OkBtn").focus();
            highlighFocusBtn('activeOk');
            return false;
          }
          else if(jQuery.inArray("true", allblank5) !== -1){
            $("#focusid").val(texid5);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").hide();
            $("#OkBtn").show();
            $("#AlertMessage").text('Duplicate rack no.');
            $("#alert").modal('show');
            $("#OkBtn").focus();
            highlighFocusBtn('activeOk');
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
  
}

$(document).ready(function(e) {

    $('#Row_Count').val("1");
  
    $("#example2").on('click', '.add', function() {
        var $tr = $(this).closest('table');
        var allTrs = $tr.find('tbody').last();
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
        
        //$clone.find('[id*="txtdesc"]').val('');
        //$clone.find('[id*="chkmdtry"]').prop('checked', false);
        
        event.preventDefault();
    });

    $("#example2").on('click', '.remove', function() {

        var rowCount = $('#Row_Count').val();

        if (rowCount > 1) {
            $(this).closest('tbody').remove();     
        } 
        
        if (rowCount <= 1) { 
            $(document).find('.remove').prop('disabled', false);  
        }
        event.preventDefault();
    });    

});


  $('#btnAdd').on('click', function() {
      var viewURL = '{{route("master",[76,"add"])}}';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '{{route('home')}}';
    window.location.href=viewURL;
  });

 var formResponseMst = $( "#frm_mst_add" );
     formResponseMst.validate();

    $("#STCODE").blur(function(){
      $(this).val($.trim( $(this).val() ));
      $("#ERROR_STCODE").hide();
      validateSingleElemnet("STCODE");
         
    });

    $( "#STCODE" ).rules( "add", {
        required: true,
        nowhitespace: true,
        //StringNumberRegex: true, //from custom.js
        messages: {
            required: "Required field.",
        }
    });

    $("#NAME").blur(function(){
        $(this).val($.trim( $(this).val() ));
        $("#ERROR_NAME").hide();
        validateSingleElemnet("NAME");
    });

    $( "#NAME" ).rules( "add", {
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
          if(element_id=="STCODE" || element_id=="stcode" ) {
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
            url:'{{route("master",[76,"codeduplicate"])}}',
            type:'POST',
            data:formData,
            success:function(data) {
                if(data.exists) {
                    $(".text-danger").hide();
                    showError('ERROR_STCODE',data.msg);
                    $("#STCODE").focus();
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
        $("#OkBtn1").hide();

        var getDataForm = $("#frm_mst_add");
        var formData = getDataForm.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'{{route("master",[76,"save"])}}',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();

                    if(data.errors.STCODE){
                       // showError('ERROR_STCODE',data.errors.STCODE);
                        $("#YesBtn").hide();
                        $("#NoBtn").hide();
                        $("#OkBtn1").hide();
                        $("#OkBtn").show();
                        $("#AlertMessage").text("Store Code is "+data.errors.STCODE);
                        $("#alert").modal('show');
                        $("#OkBtn").focus();
                    }
                    if(data.errors.NAME){
                       // showError('ERROR_NAME',data.errors.NAME);
                        $("#YesBtn").hide();
                        $("#NoBtn").hide();
                        $("#OkBtn1").hide();
                        $("#OkBtn").show();
                        $("#AlertMessage").text("Store Name is "+data.errors.NAME);
                        $("#alert").modal('show');
                        $("#OkBtn").focus();
                    }
                   if(data.exist=='duplicate') {

                      $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn").show();
                      $("#OkBtn1").hide();

                      $("#AlertMessage").text(data.msg);

                      $("#alert").modal('show');
                      $("#OkBtn").focus();

                   }
                   if(data.save=='invalid') {

                      $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn").show();
                      $("#OkBtn1").hide();

                      $("#AlertMessage").text(data.msg);

                      $("#alert").modal('show');
                      $("#OkBtn").focus();

                   }
                }
                if(data.success) {                   
                    //console.log("succes MSG="+data.msg);
                    
                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn1").show();
                    $("#OkBtn").hide();

                    $("#AlertMessage").text(data.msg);

                    $(".text-danger").hide();
                    $("#frm_mst_add").trigger("reset");

                    $("#alert").modal('show');
                    $("#OkBtn1").focus();

                  //  window.location.href='{{ route("master",[76,"index"])}}';
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
      window.location.href = "{{route('master',[76,'index'])}}";

    }); 
        
    $("#OkBtn").click(function(){
      $("#alert").modal('hide');

    });////ok button


   window.fnUndoYes = function (){
      
      //reload form
      window.location.href = "{{route('master',[76,'add'])}}";

   }//fnUndoYes


   window.fnUndoNo = function (){
      $("#STCODE").focus();
   }//fnUndoNo


    function showError(pId,pVal){

      $("#"+pId+"").text(pVal);
      $("#"+pId+"").show();

    }//showError

    function highlighFocusBtn(pclass){
       $(".activeYes").hide();
       $(".activeNo").hide();
       
       $("."+pclass+"").show();
    }

    $(function() { 
      $("#STCODE").focus();  
    });

    check_exist_docno(@json($docarray['EXIST']));




/******************************** START Country State City ********************************************************* */
    
// Country popup function

$("#CTRYID_REF_POPUP").on("click",function(event){ 
  $("#cor_ctryidref_popup").show();
});

$("#CTRYID_REF_POPUP").keyup(function(event){
  if(event.keyCode==13){
    $("#cor_ctryidref_popup").show();
  }
});

$("#cor_ctryidref_close").on("click",function(event){ 
  $("#cor_ctryidref_popup").hide();
});

$('.cls_cor_ctryidref').click(function(){
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc")

  $("#CTRYID_REF_POPUP").val(texdesc);
  $("#CTRYID_REF").val(txtval);

  getCountryWiseState(txtval);
  
  $("#CTRYID_REF_POPUP").blur(); 
  $("#STID_REF_POPUP").focus(); 
  
  $("#cor_ctryidref_popup").hide();
  searchCountryCode();
  searchCountryName();

  $(this).prop("checked",false);
  event.preventDefault();
});

function searchCountryCode() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("cor_country_codesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("cor_country_tab2");
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

function searchCountryName() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("cor_country_namesearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("cor_country_tab2");
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

function getCountryWiseState(CTRYID_REF){
    $("#cor_state_body").html('');
		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
		
    $.ajax({
        url:'{{route("master",[76,"getCountryWiseState"])}}',
        type:'POST',
        data:{CTRYID_REF:CTRYID_REF},
        success:function(data) {
          
            $("#STID_REF_POPUP").val('');
            $("#STID_REF").val('');
			$("#CITYID_REF_POPUP").val('');
            $("#CITYID_REF").val('');
			$("#cor_city_body").html('');
            $("#cor_state_body").html(data);
            bindStateEvents(); 

        },
        error:function(data){
          console.log("Error: Something went wrong.");
          $("#state_body").html('');
          
        },
    });	
  }

// State popup function

$("#STID_REF_POPUP").on("click",function(event){ 
  $("#cor_stidref_popup").show();
});

$("#STID_REF_POPUP").keyup(function(event){
  if(event.keyCode==13){
    $("#cor_stidref_popup").show();
  }
});

$("#cor_stidref_close").on("click",function(event){ 
  $("#cor_stidref_popup").hide();
});

function bindStateEvents(){
  $('.cls_cor_stidref').click(function(){
    var id = $(this).attr('id');
    var txtval =    $("#txt"+id+"").val();
    var texdesc =   $("#txt"+id+"").data("desc")

    $("#STID_REF_POPUP").val(texdesc);
    $("#STID_REF").val(txtval);
	
	var CTRYID_REF	=	$("#CTRYID_REF").val();
	
	getStateWiseCity(CTRYID_REF,txtval);
	
	$("#STID_REF_POPUP").blur(); 
	$("#CITYID_REF_POPUP").focus(); 
	
    $("#cor_stidref_popup").hide();
    searchStateCode();
    searchStateName();
    $(this).prop("checked",false);
    event.preventDefault();
  });
}

function searchStateCode() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("cor_state_codesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("cor_state_tab2");
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

function searchStateName() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("cor_state_namesearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("cor_state_tab2");
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

function getStateWiseCity(CTRYID_REF,STID_REF){
    $("#cor_city_body").html('');
		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
		
    $.ajax({
        url:'{{route("master",[76,"getStateWiseCity"])}}',
        type:'POST',
        data:{CTRYID_REF:CTRYID_REF,STID_REF:STID_REF},
        success:function(data) {
          
            $("#CITYID_REF_POPUP").val('');
            $("#CITYID_REF").val('');

            $("#cor_city_body").html(data);
            bindCityEvents(); 
			
        },
        error:function(data){
          console.log("Error: Something went wrong.");
          $("#cor_city_body").html('');
          
        },
    });	
  }

// Citiy popup function

$("#CITYID_REF_POPUP").on("click",function(event){ 
  $("#cor_cityidref_popup").show();
});

$("#CITYID_REF_POPUP").keyup(function(event){
  if(event.keyCode==13){
    $("#cor_cityidref_popup").show();
  }
});

$("#cor_cityidref_close").on("click",function(event){ 
  $("#cor_cityidref_popup").hide();
});

function bindCityEvents(){

	$('.cls_cor_cityidref').click(function(){

		var id = $(this).attr('id');
		var txtval =    $("#txt"+id+"").val();
		var texdesc =   $("#txt"+id+"").data("desc")

		$("#CITYID_REF_POPUP").val(texdesc);
		$("#CITYID_REF").val(txtval);

		$("#cor_cityidref_popup").hide();
		
		
    searchCityCode();

    $(this).prop("checked",false);
		event.preventDefault();
	});
}

function searchCityCode() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("cor_city_codesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("cor_city_tab2");
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

function searchCityName() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("cor_city_namesearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("cor_city_tab2");
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

check_exist_docno(@json($docarray['EXIST']));


/******************************** END Country State City ********************************************************* */

    
</script>

@endpush