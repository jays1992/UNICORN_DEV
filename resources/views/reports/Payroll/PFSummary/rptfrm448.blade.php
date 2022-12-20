
@extends('layouts.app')
@section('content')
    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-4">
                <a href="{{route('report',[448,'index'])}}" class="btn singlebt">PF Summary</a>
                </div><!--col-2-->
                <div class="col-lg-10 topnav-pd">
                </div>
            </div>
    </div><!--topnav-->	
    <div class="container-fluid purchase-order-view">
        <form id="frm_rpt"  method="POST">   
            @csrf
            <div class="container-fluid filter">

                    <div class="inner-form">
         
                        <div class="row"> 
                            <div class="col-lg-3 pl"><p>Branch Group</p></div>
                            <div class="col-lg-3 pl">
                                <select name="BranchGroup[]" data-hide-disabled="hide" multiple data-actions-box="true" id="BranchGroup"  class="form-control selectpicker" multiple data-live-search="true"  >
                                    @foreach($objBranchGroup as $bgindex=>$bgRow)
                                        <option value="{{$bgRow->BGID}}" selected>{{$bgRow->BG_CODE}}-{{$bgRow->BG_DESC}}</option>
                                    @endforeach
                                </select>
                            </div>                            
                            <div class="col-lg-3 pl"><p>Branch Name</p></div>
                            <div class="col-lg-3 pl">
                                <select name="BranchName[]" data-hide-disabled="hide" multiple data-actions-box="true" id="BranchName"  class="form-control selectpicker" multiple data-live-search="true"  >
                                    @foreach($objBranch as $bindex=>$bRow)
                                        <option value="{{$bRow->BRID}}" selected>{{$bRow->BRCODE}}-{{$bRow->BRNAME}}</option>
                                    @endforeach
                                </select>
                            </div> 
                        </div>
                        <div class="row"> 
                            <div class="col-lg-3 pl"><p>Pay Period</p></div>
                            <div class="col-lg-3 pl" id="div_cust">
                                <select name="PAYPERIODID[]" data-hide-disabled="hide" multiple data-actions-box="true" id="PAYPERIODID" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjPayPeriod as $index=>$Row)
                                        <option value="{{$Row->PAYPERIODID}}" selected>{{$Row->PAY_PERIOD_CODE}}-{{$Row->PAY_PERIOD_DESC}}</option>
                                @endforeach
                                </select>
                            </div>                            
                            <div class="col-lg-3 pl"><p>Employee Type</p></div>
                            <div class="col-lg-3 pl" id="div_itemgrp">
                                <select name="ETYPEID[]" data-hide-disabled="hide" multiple data-actions-box="true" id="ETYPEID" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjEmployeeType as $index=>$Row)
                                        <option value="{{$Row->ETYPEID}}" selected>{{$Row->ECODE}}-{{$Row->NAME}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

               

                        <div class="row"> 
                            <div class="col-lg-3 pl"><p>Employee Category</p></div>
                            <div class="col-lg-3 pl" id="div_cust">
                                <select name="CATID[]" data-hide-disabled="hide" multiple data-actions-box="true" id="CATID" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjEmployeeCategory as $index=>$Row)
                                        <option value="{{$Row->CATID}}" selected>{{$Row->CATCODE}}-{{$Row->NAME}}</option>
                                @endforeach
                                </select>
                            </div>                            
                            <div class="col-lg-3 pl"><p>Department</p></div>
                            <div class="col-lg-3 pl" id="div_itemgrp">
                                <select name="DEPID[]" data-hide-disabled="hide" multiple data-actions-box="true" id="DEPID" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjDepartment as $index=>$Row)
                                        <option value="{{$Row->DEPID}}" selected>{{$Row->DCODE}}-{{$Row->NAME}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-lg-3 pl"><p>Division</p></div>
                            <div class="col-lg-3 pl" id="div_cust">
                                <select name="DIVID[]" data-hide-disabled="hide" multiple data-actions-box="true" id="DIVID" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjDivision as $index=>$Row)
                                        <option value="{{$Row->DIVID}}" selected>{{$Row->DIVCODE}}-{{$Row->NAME}}</option>
                                @endforeach
                                </select>
                            </div>                            
                            <div class="col-lg-3 pl"><p>Grade</p></div>
                            <div class="col-lg-3 pl" id="div_itemgrp">
                                <select name="GRADEID[]" data-hide-disabled="hide" multiple data-actions-box="true" id="GRADEID" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjGrade as $index=>$Row)
                                        <option value="{{$Row->GRADEID}}" selected>{{$Row->GRADE_CODE}}-{{$Row->GRADE_DESC}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>      
                     </div> 

                        

                 
                    </div>
                    <div class="inner-form">
                        <div class="row"> </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-4 pl text-center">
                            <button style="display:none"  class="btn topnavbt buttonload" disabled> <i class="fa fa-refresh fa-spin"></i>{{Session::get('report_button')}}</button>
                                <button class="btn topnavbt" id="btnView" {{$objRights->VIEW != 1 ? 'disabled' : ''}}><i class="fa fa-eye"></i> View</button>
                                <input type="hidden" id="Flag" name="Flag" />
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                    </div>
                    <div class="inner-form">
                        <div class="row">
                            <div class="frame-container col-lg-12 pl text-center" >
                                <button class="iframe-button3" id="btnPrint">
                                    Print
                                </button>
                                <button class="iframe-button" id="btnPdf">
                                    Export to PDF
                                </button>
                                <button class="iframe-button2" id="btnExcel">
                                    Export to Excel
                                </button>
                                <iframe id="iframe_rpt" width="100%" height="1000" >
                                </iframe>
                            </div>
                        </div>
                    </div>

                </div>
        </form>
    </div><!--purchase-order-view-->

<!-- </div> -->

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
            <button class="btn alertbt" name='YesBtn' id="YesBtn" data-funcname="fnSaveData">
            <div id="alert-active" class="activeYes"></div>Yes
            </button>
            <button class="btn alertbt" name='NoBtn' id="NoBtn"   data-funcname="fnUndoNo" >
            <div id="alert-active" class="activeNo"></div>No
            </button>
            <button class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;">
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


@push('bottom-css')
<style>
.topnavbt {
    margin-left: 312px !important;
}
.dropdown-toggle{
    height: 30px;
    width: 320px !important;
    border: 2px !important;
    color: black !important;
    font-size: 14px;
    font-weight: 500;
}

.frame-container {
  position: relative;
}
.iframe-button {
  display: none;
  position: absolute;
  top: 15px;
  left: 950px;
  width:150px;
}
.iframe-button2 {
  display: none;
  position: absolute;
  top: 15px;
  left: 1125px;
  width:150px;
}
.iframe-button3 {
  display: none;
  position: absolute;
  top: 15px;
  left: 875px;
  width:50px;
}


</style>
@endpush
@push('bottom-scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>


$(document).ready(function(e) {
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
      //reload form
      window.location.reload();
   }//fnUndoYes

   window.fnUndoNo = function (){
      $("#From_Date").focus();
   }//fnUndoNo

// 




$('#btnPdf').on('click', function() {
    $('#Flag').val('P');
    var Flag = $('#Flag').val();
    var formData = 'Flag='+ Flag;
    var consultURL = '{{route("report",[448,"ViewReport",":rcdId"]) }}';
    consultURL = consultURL.replace(":rcdId",formData);
    window.location.href=consultURL;
    event.preventDefault();
}); 

$('#btnExcel').on('click', function() {
    $('#Flag').val('E');
    var Flag = $('#Flag').val();
    var formData = 'Flag='+ Flag;
    var consultURL = '{{route("report",[448,"ViewReport",":rcdId"]) }}';
    consultURL = consultURL.replace(":rcdId",formData);
    window.location.href=consultURL;
    event.preventDefault();
});

$('#btnView').on('click', function() {
        var From_Date       = $('#From_Date').val();
        var To_Date         = $('#To_Date').val();
        var BranchGroup = [];
        $("select[name='BranchGroup[]']").each(function() {
            var value = $(this).val();
            if (value) {
                BranchGroup.push(value);
            }
        });

        var BranchName = [];
        $("select[name='BranchName[]']").each(function() {
            var value2 = $(this).val();
            if (value2) {
                BranchName.push(value2);
            }
        });
        


        var ETYPEID = [];
        $("select[name='ETYPEID[]']").each(function() {
            var value3 = $(this).val();
            if (value3) {
                ETYPEID.push(value3);
            }
        });

        var CATID = [];
        $("select[name='CATID[]']").each(function() {
            var value3 = $(this).val();
            if (value3) {
                CATID.push(value3);
            }
        });

        var DEPID = [];
        $("select[name='DEPID[]']").each(function() {
            var value3 = $(this).val();
            if (value3) {
                DEPID.push(value3);
            }
        });

        var DIVID = [];
        $("select[name='DIVID[]']").each(function() {
            var value3 = $(this).val();
            if (value3) {
                DIVID.push(value3);
            }
        });

        var GRADEID = [];
        $("select[name='GRADEID[]']").each(function() {
            var value3 = $(this).val();
            if (value3) {
                GRADEID.push(value3);
            }
        });



        var PAYPERIODID = [];
        $("select[name='PAYPERIODID[]']").each(function() {
            var value3 = $(this).val();
            if (value3) {
                PAYPERIODID.push(value3);
            }
        });


        
        if(BranchGroup  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Branch Group.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(BranchName  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Branch.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
      
        else if(PAYPERIODID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Pay Period.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(ETYPEID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Employee Type.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(CATID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Employee Category.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(DEPID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Department.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(DIVID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Division.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }

        else if(GRADEID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Grade.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
   

        else{
            $('#Flag').val('H');
            var trnsoForm = $("#frm_rpt");
            var formData = trnsoForm.serialize();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#btnView").hide();               
                $(".buttonload").show();
                $.ajax({
                    url:'{{route("report",[448,"ViewReport"])}}',
                    type:'POST',
                    data:formData,
                    success:function(data) {
                        $("#btnView").show();               
                        $(".buttonload").hide();
                        var localS = data;
                        document.getElementById('iframe_rpt').src = "data:text/html;charset=utf-8," + escape(localS);
                        $('#btnPdf').show();
                        $('#btnExcel').show();
                        $('#btnPrint').show();
                    },
                    error:function(data){
                        $("#btnView").show();               
                        $(".buttonload").hide();
                        console.log("Error: Something went wrong.");
                        var localS = "";
                        document.getElementById('iframe_rpt').src = "data:text/html;charset=utf-8," + escape(localS);
                        $('#btnPdf').hide();
                        $('#btnExcel').hide();
                        $('#btnPrint').hide();
                    },
                });
                event.preventDefault();
        }
  });
  $("#OkBtn1").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $("#OkBtn1").hide();
    $(".text-danger").hide();
});

});







</script>


@endpush