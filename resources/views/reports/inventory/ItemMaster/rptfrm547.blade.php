
@extends('layouts.app')
@section('content')
<!-- <form id="frm_rpt_pbs" onsubmit="return validateForm()"  method="POST" class="needs-validation"  >     -->

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-4">
                
                <a href="{{route('report',[$FormId,'index'])}}" class="btn singlebt">Item Master</a>
                </div>
                <div class="col-lg-10 topnav-pd">
                       
                </div>
            </div>
    </div><!--topnav-->	
    <!-- multiple table-responsive table-wrapper-scroll-y my-custom-scrollbar -->
    <div class="container-fluid purchase-order-view">
        <form id="frm_rpt_pbs"  method="POST">   
            @csrf
            <div class="container-fluid filter">
                    <div class="inner-form">
                        <div class="row">
                            <div class="col-lg-3 pl"><p>From Date</p></div>
                            <div class="col-lg-3 pl">
                                <input type="date" name="From_Date" id="From_Date" value="{{ old('From_Date') }}" class="form-control mandatory"  placeholder="dd/mm/yyyy" />
                            </div>
                            <div class="col-lg-3 pl"><p>To Date</p></div>
                            <div class="col-lg-3 pl">
                                <input type="date" name="To_Date" id="To_Date" value="{{ old('To_Date') }}" class="form-control mandatory"  placeholder="dd/mm/yyyy" />
                            </div>                                                       
                        </div>
                        
                        <div class="row"> 
                                                         
                            <div class="col-lg-3 pl"><p>Item Group</p></div>
                            <div class="col-lg-3 pl" id="div_itemgrp">
                                <select name="ITEMGID[]" data-hide-disabled="hide" multiple data-actions-box="true" id="ITEMGID" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjItemGrp as $Gindex=>$GRow)
                                        <option value="{{$GRow->ITEMGID}}" selected>{{$GRow->GROUPNAME}}</option>
                                @endforeach
                                </select>
                            </div>
                            
                            <div class="col-lg-3 pl"><p>Item Sub Group</p></div>
                            <div class="col-lg-3 pl" id="div_itemid">
                                <select name="ISGID[]" data-hide-disabled="hide" multiple data-actions-box="true" id="ISGID" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjItemSubGrp as $Iindex=>$IRow)
                                    <option value="{{$IRow->ISGID}}" selected>
                                        {{$IRow->DESCRIPTIONS}} ({{$IRow->ISGCODE}})                                                                           
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">                   
                            <div class="col-lg-3 pl"><p>Category</p></div>
                            <div class="col-lg-3 pl" id="div_itemid">
                                <select name="ICID[]" data-hide-disabled="hide" multiple data-actions-box="true" id="ICID" class="form-control selectpicker" multiple data-live-search="true"  >
                                @foreach($ObjCategory as $Iindex=>$IRow)
                                    <option value="{{$IRow->ICID}}" selected>
                                        {{$IRow->DESCRIPTIONS}} ({{$IRow->ICCODE}})                                                                             
                                    </option>
                                @endforeach
                                </select>
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
                                <button class="btn topnavbt" id="btnView" {{isset($objRights->VIEW) && $objRights->VIEW != 1 ? 'disabled' : ''}}><i class="fa fa-eye"></i> View</button>
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
            <!-- <button class="btn alertbt" name='OkBtn1' id="OkBtn1" style="display:none;margin-left: 90px;">
            <div id="alert-active" class="activeOk1"></div>OK</button> -->

            <button onclick="getFocus()" class="btn alertbt" name='OkBtn1' id="OkBtn1" style="display:none;margin-left: 90px;"><div id="alert-active" class="activeOk1"></div>OK</button>
            <input type="hidden" id="focusid" >
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

    $('#btnPdf').on('click', function() {
        $('#Flag').val('P');
        var Flag = $('#Flag').val();
        var formData = 'Flag='+ Flag;
        var consultURL = '{{route("report",[$FormId,"ViewReport",":rcdId"]) }}';
        consultURL = consultURL.replace(":rcdId",formData);
        window.location.href=consultURL;
        event.preventDefault();
    }); 

    $('#btnExcel').on('click', function() {
        $('#Flag').val('E');
        var Flag = $('#Flag').val();
        var formData = 'Flag='+ Flag;
        var consultURL = '{{route("report",[$FormId,"ViewReport",":rcdId"]) }}';
        consultURL = consultURL.replace(":rcdId",formData);
        window.location.href=consultURL;
        event.preventDefault();
    });

    $('#btnView').on('click', function() {
        $("#focusid").val('');
        var From_Date       =   $.trim($("#From_Date").val());
        var To_Date         =   $.trim($("#To_Date").val());
        
        var ISGID = [];
        $("select[name='ISGID[]']").each(function() {
            var value3 = $(this).val();
            if (value3) {
                ISGID.push(value3);
            }
        });

        var ITEMGID = [];
        $("select[name='ITEMGID[]']").each(function() {
            var value5 = $(this).val();
            if (value5) {
                ITEMGID.push(value5);
            }
        });

        var ICID  = [];
        $("select[name='ICID[]']").each(function() {
            var value6 = $(this).val();
            if (value6) {
                ICID.push(value6);
            }
        });

        if(From_Date ===""){
            $("#focusid").val('From_Date');
            $("#ProceedBtn").focus();
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select From Date.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }

        else if(To_Date ===""){
            $("#focusid").val('To_Date');
            $("#ProceedBtn").focus();
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select To Date.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }

        else if(ITEMGID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Item Group.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }

        else if(ISGID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Sub Group.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }

        else if(ICID  == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Please Select Category.');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            return false;
        }
        
        else{
            $('#Flag').val('H');
            var trnsoForm = $("#frm_rpt_pbs");
            var formData = trnsoForm.serialize();
            // var consultURL = '{{route("report",[$FormId,"ViewReport",":rcdId"]) }}';
            // // var formdata = {'SONO': SONO};
            // consultURL = consultURL.replace(":rcdId",formData);
            // window.location.href=consultURL;
            // event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#btnView").hide();               
            $(".buttonload").show();
            $.ajax({
                url:'{{route("report",[$FormId,"ViewReport"])}}',
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

function getFocus(){
    var focusid=$("#focusid").val();
    $("#"+focusid).focus();
    $("#closePopup").click();
}

</script>

@endpush