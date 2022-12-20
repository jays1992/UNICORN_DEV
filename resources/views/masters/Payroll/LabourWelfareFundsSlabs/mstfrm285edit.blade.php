@extends('layouts.app')
@section('content')


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="{{route('master',[285,'index'])}}" class="btn singlebt">Labour Welfare Funds Slabs</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button href="#" id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button id="btnSave"   class="btn topnavbt" tabindex="4"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView"  disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt"  id="btnUndo" ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled" ><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove"{{ (isset($objRights->APPROVAL1) || isset($objRights->APPROVAL2) || isset($objRights->APPROVAL3) || isset($objRights->APPROVAL4) || isset($objRights->APPROVAL5)) &&  ($objRights->APPROVAL1||$objRights->APPROVAL2||$objRights->APPROVAL3||$objRights->APPROVAL4||$objRights->APPROVAL5) == 1 ? '' : 'disabled'}}><i class="fa fa-lock"></i> Approved</button>
                        <a href="#" class="btn topnavbt"  disabled="disabled"><i class="fa fa-link" ></i> Attachment</a>
                        <button class="btn topnavbt" id="btnExit"><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
         <form id="frm_mst_edit" method="POST" onsubmit="return validateForm()" class="needs-validation"  > 
          @CSRF
          {{isset($objResponse->TDSSLABID) ? method_field('PUT') : '' }}
          <div class="inner-form">
          
                <div class="row">            
                  <div class="col-lg-2 pl"><p>Financial Year*</p></div>
                  <div class="col-lg-2 pl">
                      <select name="FYID_REF" id="FYID_REF" class="form-control mandatory" onchange="getFYearName(this.value)" tabindex="4">
                      <option value="" selected >Select</option>
                        @foreach ($objYearList as $key=>$val)
                        <option {{isset($objResponse->FYID_REF) && $objResponse->FYID_REF == $val-> YRID ?'selected="selected"':''}} value="{{ $val-> YRID }}">{{ $val->YRCODE }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="ERROR_FYID_REF"></span>                             
                  </div>

                  <div class="col-lg-2 pl"><p>Financial Year Description</p></div>
                  <div class="col-lg-2 pl">
                    <input type="text" id="YRDESCRIPTION" value="{{ $objFyDesList->YRDESCRIPTION }}" class="form-control"  maxlength="100" readonly > 
                  </div>

                  <div class="col-lg-2 pl"><p>State* </p></div>
                  <div class="col-lg-2 pl">
                    <select name="STID_REF" id="STID_REF" class="form-control mandatory" tabindex="4">
                      <option value="" selected >Select</option>
                        @foreach ($objDataList as $key=>$val)
                        <option {{isset($objResponse->STID_REF) && $objResponse->STID_REF == $val-> STID ?'selected="selected"':''}} value="{{ $val-> STID }}">{{ $val->NAME }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="focusid" >
                    <span class="text-danger" id="ERROR_STID_REF"></span>                             
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
                    <div class=" table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:300px;" >
                      <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                        <thead id="thead1"  style="position: sticky;top: 0">
                      <tr>                          
                          <th colspan="2"  width="3%">Salary Range <input class="form-control" type="hidden" name="Row_Count" id ="Row_Count"> </th>                         
                          <th rowspan="2" width="3%">Tax Rate %</th>
                          <th colspan="2" width="3%">L.W</th>
                          <th rowspan="2" width="3%">Remarks</th>
                          <th rowspan="2" width="3%">Action</th>
                      </tr>                      
                          <tr>
                              <th>From</th>
                              <th>To</th>
                              <th colspan="2" width="3%">Amount</th>
                          </tr>
                  </thead>

                        <tbody>
                          @if(!empty($objDataResponse))
                          @php $n=1; @endphp
                          @foreach($objDataResponse as $key => $row)
                          <tr  class="participantRow">
                            <td hidden><input type="hidden" name="LWFSLABDID" id="LWFSLABDID" value="{{ $row->LWFSLABDID }}" /></td>
                              <td><input  class="form-control" type="text" name={{"SALARY_FR_".$key}}   id ={{"SALARY_FR_".$key}}  value="{{ $row->SALARY_FR }}" autocomplete="off"  onkeypress="return onlyNumberKey(event)" ></td>
                              <td><input  class="form-control" type="text" name={{"SALARY_TO_".$key}}   id ={{"SALARY_TO_".$key}}  value="{{ $row->SALARY_TO }}" autocomplete="off"  onkeypress="return onlyNumberKey(event)" ></td>
                              <td><input  class="form-control" type="text" name={{"TAX_RATE_".$key}}    id ={{"TAX_RATE_".$key}}    value="{{ $row->TAX_RATE }}" autocomplete="off" onkeypress="return onlyNumberKey(event)" style="width: 99%"></td>
                              <td><input  class="form-control" type="text" name={{"LWF_AMOUNT_".$key}}  id ={{"LWF_AMOUNT_".$key}}  value="{{ $row->LWF_AMOUNT }}" autocomplete="off" onkeypress="return onlyNumberKey(event)" style="width: 99%"></td>
                              <td></td>
                              <td><input  class="form-control" type="text" name={{"REMARKS_".$key}}     id ={{"REMARKS_".$key}}     value="{{ $row->REMARKS }}" autocomplete="off" style="width: 99%" ></td>
              
                              <td align="center" >
                                  <button class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                                  <button class="btn remove" title="Delete" data-toggle="tooltip"><i class="fa fa-trash" ></i></button>
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
        var SALARY_FR  =   $.trim($("[id*=SALARY_FR]").val());
        var FYID_REF          =   $.trim($("#FYID_REF").val());
        var STID_REF          =   $.trim($("#STID_REF").val());
        $("#OkBtn1").hide();
    
        if(FYID_REF ===""){
          $("#focusid").val('FYID_REF');
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").hide();  
          $("#OkBtn").show();              
          $("#AlertMessage").text('Please enter Financial Year.');
          $("#alert").modal('show');
          $("#OkBtn").focus();
          return false;
        }
        else if(STID_REF ===""){
          $("#focusid").val('STID_REF');
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").hide();  
          $("#OkBtn").show();              
          $("#AlertMessage").text('Please enter State.');
          $("#alert").modal('show');
          $("#OkBtn").focus();
          return false;
        }
        
        else{
            event.preventDefault();
              var allblank1 = [];
              var allblank2 = [];
              var allblank3 = [];
              var allblank6 = [];
    
              var focustext1= "";
              var focustext2= "";
              var focustext3= "";
              var focustext6= "";
            
              $('#example2').find('.participantRow').each(function(){
     
              if($.trim($(this).find("[id*=SALARY_FR]").val()) ==""){
                
                allblank1.push('false');
                focustext1 = $(this).find("[id*=SALARY_FR]").attr('id');
              }
                else if($.trim($(this).find("[id*=SALARY_TO]").val()) ==""){
                  allblank2.push('false');
                  focustext2 = $(this).find("[id*=SALARY_TO]").attr('id');
                }
    
                else if($.trim($(this).find("[id*=TAX_RATE]").val()) ==""){
                  allblank3.push('false');
                  focustext3 = $(this).find("[id*=TAX_RATE]").attr('id');
                }  
                else if($.trim($(this).find("[id*=REMARKS]").val()) ==""){
                  allblank6.push('false');
                  focustext6 = $(this).find("[id*=REMARKS]").attr('id');
                }             
    
                  });
    
            if(jQuery.inArray("false", allblank1) !== -1){
                $("#focusid").val(focustext1);
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn1").hide();  
                $("#OkBtn").show();
                $("#AlertMessage").text('Please enter Salary Range From.');
                $("#alert").modal('show');
                $("#OkBtn").focus();
                highlighFocusBtn('activeOk');
                return false;
              }
              else if(jQuery.inArray("false", allblank2) !== -1){
                $("#focusid").val(focustext2);
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn1").hide();  
                $("#OkBtn").show();
                $("#AlertMessage").text('Please enter Salary Range To.');
                $("#alert").modal('show');
                $("#OkBtn").focus();
                highlighFocusBtn('activeOk');
                return false;
              }
              else if(jQuery.inArray("false", allblank3) !== -1){
                $("#focusid").val(focustext3);
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn1").hide();  
                $("#OkBtn").show();
                $("#AlertMessage").text('Please enter Tax Rate.');
                $("#alert").modal('show');
                $("#OkBtn").focus();
                highlighFocusBtn('activeOk');
                return false;
              }              
              else if(jQuery.inArray("false", allblank6) !== -1){
                $("#focusid").val(focustext6);
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn1").hide();  
                $("#OkBtn").show();
                $("#AlertMessage").text('Please enter Remarks.');
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
    
    var r_count = $('#Row_Count').val();
    $("#example2").on('click', '.remove', function() {
    var rowCount = $(this).closest('table').find('.participantRow').length;
    if (rowCount > 1) {
    $(this).closest('.participantRow').remove();
    rowCount = parseInt(rowCount)-1;
    $('#Row_Count').val(rowCount);     
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
        
        $clone.find('[id*="txtdesc"]').val('');
        $clone.find('[id*="txtID"]').val('0'); 
        $clone.find('[id*="chkmdtry"]').prop("checked", false); 
        $clone.find('[id*="deactive-checkbox"]').prop("checked", false); 
        $clone.find('[id*="decativateddate"]').val('');
        event.preventDefault();
    });




  $(document).ready(function(e) {
  var formResponseMst = $( "#frm_mst_edit" );
  formResponseMst.validate();
  var rcount = <?php echo json_encode($objCount); ?>;
    $('#Row_Count').val(rcount);
    //$('#Row_Count').val("1");
  $('#btnAdd').on('click', function() {
      var viewURL = '{{route("master",[285,"add"])}}';
                  window.location.href=viewURL;
    });
    $('#btnExit').on('click', function() {
      var viewURL = '{{route('home')}}';
                  window.location.href=viewURL;
    });         
});

    
      $('#btnAdd').on('click', function() {
          var viewURL = '{{route("master",[285,"add"])}}';
          window.location.href=viewURL;
      });
    
      $('#btnExit').on('click', function() {
        var viewURL = '{{route('home')}}';
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
                url:'{{route("master",[285,"codeduplicate"])}}',
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
      //set function nane of yes and no btn 
      $("#alert").modal('show');
      $("#AlertMessage").text('Do you want to save to record.');
      $("#YesBtn").data("funcname","fnApproveData");  //set dynamic fucntion name of approval
      $("#YesBtn").focus();
      highlighFocusBtn('activeYes');
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
                url:'{{ route("mastermodify",[285,"update"]) }}',
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
    
                      //  window.location.href='{{ route("master",[285,"index"])}}';
                    }
                    
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                },
            });
          
       } // fnSaveData
    
    
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
            url:'{{route("mastermodify",[285,"Approve"])}}',
            type:'POST',
            data:formData,
            success:function(data) {
               
                if(data.errors) {
                    $(".text-danger").hide();                    
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
                    window.location.href='{{ route("master",[285,"index"])}}';

                }
                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
            },
        });

    };// fnApproveData


        
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
        window.location.href = "{{route('master',[285,'index'])}}";
    
        });
    
    
        
        $("#OkBtn").click(function(){
          $("#alert").modal('hide');
    
        });////ok button
    
    
       window.fnUndoYes = function (){
          
          //reload form
          window.location.href = "{{route('master',[285,'add'])}}";
    
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
    
        function getFYearName(YRID){
        $("#YRDESCRIPTION").val('');
        
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            $.ajax({
                url:'{{route("master",[285,"getFYearName"])}}',
                type:'POST',
                data:{YRID:YRID},
                success:function(data) {
                   $("#YRDESCRIPTION").val(data);                
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                },
            });	
      }
        
    </script>
    
    <script>
        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
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