
@extends('layouts.app')
@section('content')
<!-- <form id="frm_rpt_sis" onsubmit="return validateForm()"  method="POST" class="needs-validation"  >     -->

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-4">
                <a href="{{route('report',[382,'index'])}}" class="btn singlebt">Customer Ageing Report</a>
                </div><!--col-2-->
                <div class="col-lg-10 topnav-pd">
                       
                </div>
            </div>
    </div><!--topnav-->	
    <!-- multiple table-responsive table-wrapper-scroll-y my-custom-scrollbar -->
    <div class="container-fluid purchase-order-view">
        <form id="frm_rpt_sis"  method="POST">   
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
                            <div class="col-lg-3 pl"><p>Customer Group</p></div>
                            <div class="col-lg-3 pl" id="div_CDG">
                                <select name="CDG[]" data-hide-disabled="hide" multiple data-actions-box="true" id="CDG" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjCustomerGroup as $cindex=>$cRow)
                                        <option value="{{$cRow->CGID}}" selected>{{$cRow->CGROUP}}-{{$cRow->DESCRIPTIONS}}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 pl"><p>Customer</p></div>
                            <div class="col-lg-3 pl" id="div_CUSTOMER">
                                <select name="CUSTOMER[]" data-hide-disabled="hide" multiple data-actions-box="true" id="CUSTOMER" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjCustomer as $cindex=>$cRow)
                                        <option value="{{$cRow->SGLID}}" selected>{{$cRow->SGLCODE}}-{{$cRow->SLNAME}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 pl"><p>As On Date</p></div>
                            <div class="col-lg-3 pl">
                                <input type="date" name="AsOnDate" id="AsOnDate" value="{{ old('AsOnDate') }}" class="form-control mandatory"  placeholder="dd/mm/yyyy" />
                            </div>
                            <div class="col-lg-3 pl"><p>Report Basis</p></div>
                            <div class="col-lg-3 pl">
                                <select name="ReportBasis" data-hide-disabled="hide" id="ReportBasis" class="form-control selectpicker" data-live-search="true"  >
                                        <option value="INVOICE_DATE" selected>INVOICE_DATE</option>
                                        <option value="DUE_DATE" >DUE_DATE</option>
                                </select>
                            </div>                                                       
                        </div>
                        <div class="row">
                            <div class="col-lg-3 pl"><p>Report Type</p></div>
                            <div class="col-lg-6 pl">
                                <div class="col-lg-6 pl">
                                &nbsp;<input type="radio" name="chk_Detail" id="chk_Detail"   checked /> &nbsp; <label>Customer Ageing Document Wise</label>
                                </div>
                                <div class="col-lg-6 pl">
                                    <input type="radio" name="chk_Summary" id="chk_Summary"   /> &nbsp; <label>Customer Ageing Summary</label>
                                    <input type="hidden" name="ReportType" id="ReportType" value="Detail" />
                                </div>
                            </div>
                            <div class="col-lg-2"></div>
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
                                <iframe id="iframe_rpt" width="100%" height="1500" >
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

$('#chk_Detail').on('change',function()
{
  if($(this).is(':checked') == true)
  {
    $('#chk_Summary').prop('checked', false);
    $('#ReportType').val('Detail');
  }
  else
  {
    $(this).prop('checked', false);
    $('#ReportType').val('Summary');
  }
});

$('#chk_Summary').on('change',function()
{
  if($(this).is(':checked') == true)
  {
    $('#chk_Detail').prop('checked', false);
    $('#ReportType').val('Summary');
  }
  else
  {
    $(this).prop('checked', false);
    $('#ReportType').val('Detail');
  }
});

$('#btnPdf').on('click', function() {
    $('#Flag').val('P');
    var Flag = $('#Flag').val();
    var ReportType = $('#ReportType').val();
    var formData = 'Flag='+ Flag + '&ReportType='+ ReportType ;
    var consultURL = '{{route("report",[382,"ViewReport",":rcdId"]) }}';
    consultURL = consultURL.replace(":rcdId",formData);
    window.location.href=consultURL;
    event.preventDefault();
}); 

$('#btnExcel').on('click', function() {
    $('#Flag').val('E');
    var Flag = $('#Flag').val();
	var ReportType = $('#ReportType').val();
    var formData = 'Flag='+ Flag + '&ReportType='+ ReportType ;
    var consultURL = '{{route("report",[382,"ViewReport",":rcdId"]) }}';
    consultURL = consultURL.replace(":rcdId",formData);
    window.location.href=consultURL;
    event.preventDefault();
});

$('#btnView').on('click', function() {
        var From_Date       = $('#From_Date').val();
        var To_Date         = $('#To_Date').val();
		var ReportBasis         = $('#ReportBasis').val();
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
        
        var CDG = [];
        $("select[name='CDG[]']").each(function() {
            var value3 = $(this).val();
            if (value3) {
                CDG.push(value3);
            }
        });


        var CUSTOMER = [];
        $("select[name='CUSTOMER[]']").each(function() {
            var value4 = $(this).val();
            if (value4) {
                CUSTOMER.push(value4);
            }
        });
        
        

        if(From_Date ==="")
        {
            $("#FocusId").val($("#From_Date"));
            $("#From_Date").val('');
            $("#ProceedBtn").focus();
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select From Date.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(To_Date ==="")
        {
            $("#FocusId").val($("#To_Date"));
            $("#To_Date").val('');
            $("#ProceedBtn").focus();
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select To Date.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(BranchGroup  == '')
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
        else if(CDG  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Customer Group.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else if(CUSTOMER  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Customer.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
		else if(ReportBasis  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Report Basis.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        else{
            $('#Flag').val('H');
            var trnsoForm = $("#frm_rpt_sis");
            var formData = trnsoForm.serialize();
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#btnView").hide();               
                $(".buttonload").show();
                $.ajax({
                    url:'{{route("report",[382,"ViewReport"])}}',
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