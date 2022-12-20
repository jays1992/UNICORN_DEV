
@extends('layouts.app')
@section('content')
@inject('helper', 'App\Helpers\Helper')    

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="{{route('transaction',[415,'index'])}}" class="btn singlebt">Manual Journal Voucher (MJV)</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSaveJV" disabled="disabled"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" {{isset($objRights->PRINT) && $objRights->PRINT != 1 ? 'disabled' : ''}} ><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo" disabled="disabled" ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-lock"></i>  Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div><!--row-->
    </div>

    <!-- <form id="frm_trn_jv" onsubmit="return validateForm()"  method="POST" class="needs-validation"  > -->
    <div class="container-fluid filter">
      <form id="frm_trn_jv"  method="POST"> 
      @csrf
      {{isset($objJV->MJVID[0]) ? method_field('PUT') : '' }}
	<div class="inner-form">
	
		<div class="row">
        <div class="col-lg-1 pl"><p>MJV No</p></div>
        <div class="col-lg-2 pl">
              <input type="hidden" name="MJVID" id="MJVID" value="{{ isset($objJV->MJVID)?$objJV->MJVID:'' }}" />
              <input {{$ActionStatus}} type="text" name="MJV_NO" id="MJV_NO" value="{{ isset($objJV->MJV_NO)?$objJV->MJV_NO:'' }}" class="form-control mandatory"  autocomplete="off" readonly style="text-transform:uppercase"  >
         </div>
        <div class="col-lg-1 pl"><p>MJV Date</p></div>
        <div class="col-lg-2 pl">
                  <input {{$ActionStatus}} type="date" name="MJV_DT" id="MJV_DT" value="{{ isset($objJV->MJV_DT)?$objJV->MJV_DT:'' }}" class="form-control mandatory"  placeholder="dd/mm/yyyy" readonly />
        </div>
        <div class="col-lg-1 pl"><p> Reverse	</p></div> 
        <div class="col-lg-2 pl">
                  <input {{$ActionStatus}} type="checkbox" name="REVERSE" id="REVERSE" {{isset($objJV->REVERSE) && $objJV->REVERSE == 1 ? 'checked' : ''}} />
        </div>
        <div class="col-lg-1 pl"><p>Reverse Date</p></div>
        <div class="col-lg-2 pl">
                  <input {{$ActionStatus}} type="date" name="REVERSE_DT" id="REVERSE_DT" value="{{ isset($objJV->REVERSE_DT)?$objJV->REVERSE_DT:'' }}" class="form-control"  placeholder="dd/mm/yyyy" disabled >
        </div>
		</div>

    <div class="row">
        <div class="col-lg-1 pl"><p>Remarks</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="text" name="REMARKS" id="REMARKS" class="form-control" value="{{ isset($objJV->REMARKS)?$objJV->REMARKS:'' }}"  autocomplete="off"   />
        </div>
        <div class="col-lg-1 pl"><p>Source Doc No</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="text" name="SOURCE_DOCNO" id="SOURCE_DOCNO" class="form-control"  value="{{ isset($objJV->SOURCE_DOCNO)?$objJV->SOURCE_DOCNO:'' }}"   autocomplete="off" disabled  />
        </div>
        
        <div class="col-lg-1 pl"><p>Source Doc Date</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="date" name="SOURCE_DOCDT" id="SOURCE_DOCDT" autocomplete="off"  value="{{ isset($objJV->SOURCE_DOCDT)?$objJV->SOURCE_DOCDT:'' }}"  class="form-control"disabled  >
        </div>

        <div class="col-lg-1 pl"><p>Common Narration</p></div>
          <div class="col-lg-2 pl">
              <input {{$ActionStatus}} type="text" name="NARRATION" id="NARRATION" class="form-control"  value="{{ isset($objJV->NARRATION)?$objJV->NARRATION:'' }}"   autocomplete="off"  />                          
          </div>

    </div>
    <div class="row">                         
          <div class="col-lg-1 pl"><p>Sub Ledger</p></div>
          <div class="col-lg-1 pl">
              <input type="checkbox" name="SubGL" id="SubGL" disabled  />
              <input type="hidden" name="hdnAccounting" id="hdnAccounting" class="form-control"  autocomplete="off"  />
              <input type="hidden" name="hdnCostCenter" id="hdnCostCenter" class="form-control"  autocomplete="off"  />
          </div>
    </div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#Accounting">Accounting</a></li> 
        <!--<li><a data-toggle="tab" href="#udf">UDF</a></li>-->
        <!-- <li><a data-toggle="tab" href="#CostCenter">Cost Center</a></li> -->
			</ul>
      <div class="tab-content">
        <div id="Accounting" class="tab-pane fade in active">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:400px;margin-top:10px;" >
                <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                            
                            <tr>
                                <th width="15%">GL/SL<input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1" value="{{$objCount1}}"></th>
                                <th width="20%">Description</th>
								<th width="20%">Account Balance</th>
                                <th width="10%">Debit Amount</th>
                                <th width="10%">Credit Amount</th>
                                <th width="20%">Narration</th>
                                <th width="15%">CC Code</th>
                                <th width="10%">Action</th>
                            </tr>
                    </thead>
                    <tbody>
                    @if(!empty($objJVACC))
                      @foreach($objJVACC as $key => $row)
                        <tr  class="participantRow">
                            <td style="text-align:center;" >
                            <input {{$ActionStatus}} type="text" name={{"txtGLID_".$key}} id={{"txtGLID_".$key}} class="form-control" value="{{$row->GLCODE}}"  autocomplete="off"  readonly/></td>
                            <td hidden><input type="hidden" name={{"GLID_REF_".$key}} id={{"GLID_REF_".$key}} class="form-control" value="{{$row->GLID_REF}}" autocomplete="off" /></td>
                            <td hidden><input type="hidden" name={{"txtflag_".$key}} id={{"txtflag_".$key}} class="form-control" value="{{$row->SGLID_REF}}" autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"Description_".$key}} id={{"Description_".$key}} class="form-control" value="{{$row->NAME}}"  autocomplete="off"  readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"ACCOUNT_BALANCE_".$key}} id={{"ACCOUNT_BALANCE_".$key}} class="form-control"  autocomplete="off" value="{{$helper->getBalance_show($row->GLID_REF)}}" readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"DR_AMT_".$key}} id={{"DR_AMT_".$key}} class="form-control two-digits right" value="{{$row->DR_AMT}}" maxlength="15"  autocomplete="off" {{$row->CR_AMT > ".00" && $row->DR_AMT == ".00" ? 'disabled' : ''}} onkeyup="getTotalRowValue()"  /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"CR_AMT_".$key}} id={{"CR_AMT_".$key}} class="form-control two-digits right" value="{{$row->CR_AMT}}" maxlength="15"  autocomplete="off" {{$row->DR_AMT > ".00" && $row->CR_AMT == ".00" ? 'disabled' : ''}} onkeyup="getTotalRowValue()" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"NARRATION_".$key}} id={{"NARRATION_".$key}} class="form-control" value="{{$row->NARRATION}}"  autocomplete="off"  /></td>
                            <td align="center" ><button  class="btn" id={{"BtnCCID_".$key}} name={{"BtnCCID_".$key}} type="button"><i class="fa fa-clone"></i></button></td>
                            <td hidden><input type="text" name={{"CCID_REF_".$key}} id={{"CCID_REF_".$key}} class="form-control" value="{{$row->CCID_REF}}"  autocomplete="off"  readonly/></td>
                            <td align="center" >
                              <button {{$ActionStatus}} class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                              <button {{$ActionStatus}} class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                            </td>
                        </tr>
                        <tr></tr>
                      @endforeach 
                    @endif
                    </tbody>

                    <style>
                    .total-row{
                      text-align:right !important;
                      font-size:13px !important;
                      font-weight:bold !important;
                    }
                    .right{
                      text-align:right !important;
                    }
                    </style>

                    <tr>
                      <td class="total-row" colspan="3" style="text-align:center ! important;">TOTAL</td>
                      <td class="total-row" id="DR_AMT_TOTAL"></td>
                      <td class="total-row" id="CR_AMT_TOTAL"></td>
                      <td class="total-row"></td>
                      <td class="total-row"></td>
                      <td class="total-row"></td>
                    </tr>

            </table>
            </div>	
        </div> 
        <div id="udf" class="tab-pane fade">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="margin-top:10px;height:280px;width:50%;">
                <table id="example4" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                    <tr >
                        <th>UDF Fields<input class="form-control" type="hidden" name="Row_Count2" id ="Row_Count2" value="{{isset($objCount2)? $objCount2 : (isset($objCountUDF)? objCountUDF : 1)}}"></th>
                        <th>Value / Comments</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($objJVUDF))
                        @foreach($objJVUDF as $Ukey => $Urow)
                            <tr  class="participantRow4">
                                <td><input {{$ActionStatus}} type="text" name={{"popupUDFJVID_".$Ukey}} id={{"popupUDFJVID_".$Ukey}}  class="form-control"  autocomplete="off"  readonly/></td>
                                <td hidden><input type="hidden" name={{"UDFJVID_REF_".$Ukey}}  id={{"UDFJVID_REF_".$Ukey}} class="form-control" value="{{$Urow->UDFJVID_REF}}" autocomplete="off" /></td>
                                <td hidden><input type="hidden" name={{"UDFismandatory_".$Ukey}} id={{"UDFismandatory_".$Ukey}} class="form-control" autocomplete="off" /></td>
                                <td id={{"udfinputid_".$Ukey}}>
                                {{-- dynamic input --}} 
                                </td>
                                <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                            </tr>
                            <tr></tr>
                        @endforeach 
                    @else
                        @foreach($objUdfJVData as $uindex=>$uRow)
                          <tr  class="participantRow4">
                              <td><input {{$ActionStatus}} type="text" name={{"popupUDFJVID_".$uindex}} id={{"popupUDFJVID_".$uindex}} class="form-control" value="{{$uRow->LABEL}}" autocomplete="off"  readonly/></td>
                              <td hidden><input type="hidden" name={{"UDFJVID_REF_".$uindex}} id={{"UDFJVID_REF_".$uindex}} class="form-control" value="{{$uRow->UDFJVID}}" autocomplete="off"   /></td>
                              <td hidden><input type="hidden" name={{"UDFismandatory_".$uindex}} id={{"UDFismandatory_".$uindex}} value="{{$uRow->ISMANDATORY}}" class="form-control"   autocomplete="off" /></td>
                              <td id={{"udfinputid_".$uindex}} >
                                
                              </td>
                              <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                              
                          </tr>
                          <tr></tr>
                        @endforeach
                    @endif 
                    </tbody>
                </table>
            </div>
        </div> 
        <div id="CostCenter" class="tab-pane fade" >
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="margin-top:10px;height:280px;width:50%;">
                <table id="example5" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                    <tr >
                        <th>GLID<input class="form-control" type="hidden" name="Row_Count3" id ="Row_Count3" value="{{$objCount3}}"></th>
                        <th>CCID</th>
                        <th>DR_AMT</th>
                        <th>CR_AMT</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($objJVCCD))
                        @foreach($objJVCCD as $cckey => $ccrow)
                          <tr  class="participantRow5">
                              <td><input {{$ActionStatus}} type="text" name={{"GLID_".$cckey}} id={{"GLID_".$cckey}} class="form-control"  value="{{$ccrow->GLID_REF}}" autocomplete="off"  readonly/></td>
                              <td><input {{$ActionStatus}} type="text" name={{"CCID_".$cckey}} id={{"CCID_".$cckey}} class="form-control" value="{{$ccrow->CCID_REF}}"  autocomplete="off"   readonly/></td>
                              <td><input {{$ActionStatus}} type="text" name={{"D_AMT_".$cckey}} id={{"D_AMT_".$cckey}} class="form-control two-digits" value="{{$ccrow->DR_AMT}}"   autocomplete="off" readonly/></td>
                              <td><input {{$ActionStatus}} type="text" name={{"C_AMT_".$cckey}} id={{"C_AMT_".$cckey}} class="form-control two-digits" value="{{$ccrow->CR_AMT}}"  autocomplete="off"  readonly/></td>                          
                          </tr>
                          <tr></tr>
                          @endforeach 
                    @else
                          <tr  class="participantRow5">
                              <td><input {{$ActionStatus}} type="text" name="GLID_0" id="GLID_0" class="form-control"  autocomplete="off"  readonly/></td>
                              <td><input {{$ActionStatus}} type="text" name="CCID_0" id="CCID_0" class="form-control" autocomplete="off"   readonly/></td>
                              <td><input {{$ActionStatus}} type="text" name="D_AMT_0" id="D_AMT_0" class="form-control two-digits"   autocomplete="off" readonly/></td>
                              <td><input  {{$ActionStatus}} type="text" name="C_AMT_0" id="C_AMT_0" class="form-control two-digits"  autocomplete="off"  readonly/></td>                          
                          </tr>
                          <tr></tr>
                    @endif 
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
		
	</div>
  </form>	
</div>

<!-- </div> -->

@endsection
@section('alert')
<!--GL/SL dropdown-->

<div id="glsl_popup" class="modal" role="dialog"  data-backdrop="static">
<div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='gl_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>GL Account</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="GlCodeTable" class="display nowrap table  table-striped table-bordered" >
    <thead>
    <tr id="none-select" class="searchalldata" hidden>
            <td> <input type="hidden" name="hdn_GLID" id="hdn_GLID"/>
            <input type="hidden" name="hdn_GLID2" id="hdn_GLID2"/>
            <input type="hidden" name="hdn_GLID3" id="hdn_GLID3"/>
            <input type="hidden" name="hdn_GLID4" id="hdn_GLID4"/></td>
    </tr>

    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Code</th>
      <th class="ROW3">Description</th>
    </tr>

    </thead>
    <tbody>
    
    <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="glcodesearch" class="form-control" autocomplete="off" onkeyup="GLCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="glnamesearch" class="form-control" autocomplete="off" onkeyup="GLNameFunction()"></td>
      </tr>

    </tbody>
    </table>
      <table id="GlCodeTable2" class="display nowrap table  table-striped table-bordered" width="100%">
        <thead id="thead2">
        </thead>
        <tbody id="tbody_glsl">
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<!--Cost Centre dropdown-->

<div id="costpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width:80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='cc_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Cost Center</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="CostTable" class="display nowrap table  table-striped table-bordered" style="width:100%;">
    <thead>
    <tr id="none-select" class="searchalldata" hidden>
            
            <td> <input type="hidden" name="hdn_CCID" id="hdn_CCID"/>
            <input type="hidden" name="hdn_CCID2" id="hdn_CCID2"/>
            <input type="hidden" name="hdn_CCID3" id="hdn_CCID3"/>
            <input type="hidden" name="hdn_CCID4" id="hdn_CCID4"/>
            <input type="hidden" name="hdn_CCID5" id="hdn_CCID5"/>
            <input type="hidden" name="hdn_CCID6" id="hdn_CCID6"/>
            <input type="hidden" name="hdn_CCID7" id="hdn_CCID7"/>
            </td>
    </tr>
    <tr>
            <th style="width:20%;">GL Code</th>
            <th style="width:20%;">GL Description</th>
            <th style="width:15%;">Cost Centre Code</th>
            <th style="width:15%;">Debit Amount</th>
            <th style="width:15%;">Credit Amount</th>
            <th style="width:15%;">Action</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    
    </tr>
    </tbody>
    </table>
      <table id="CostTable2" class="display nowrap table  table-striped table-bordered" style="width:100%;">
        <thead id="thead2">
        </thead>
        <tbody id="tbody_cc"> 
          <tr class="participantRow2">
            <td style="width:20%;"><input {{$ActionStatus}} type="text" name="ppGLID_0" id="ppGLID_0" class="form-control"  autocomplete="off"  readonly/></td>
            <td hidden><input type="hidden" name="hdnGLID_0" id="hdnGLID_0" class="form-control" autocomplete="off" /></td>
            <td hidden><input type="hidden" name="hdnflag_0" id="hdnflag_0" class="form-control" autocomplete="off" /></td>
            <td style="width:20%;"><input {{$ActionStatus}} type="text" name="hdnDescription_0" id="hdnDescription_0" class="form-control"  autocomplete="off"  readonly/></td>
            <td style="width:15%;"><input {{$ActionStatus}} type="text" name="CostCenter_0" id="CostCenter_0" class="form-control" maxlength="20"  autocomplete="off" readonly  /></td>
            <td hidden><input type="hidden" name="hdnCCID_0" id="hdnCCID_0" class="form-control" autocomplete="off" /></td>
            <td style="width:15%;"><input {{$ActionStatus}} type="text" name="hdnDRAMT_0" id="hdnDRAMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
            <td style="width:15%;"><input {{$ActionStatus}} type="text" name="hdnCRAMT_0" id="hdnCRAMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
            <td style="width:15%;">
            <button {{$ActionStatus}} class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
            <button {{$ActionStatus}} class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button></td>
          </tr>      
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<div id="ppcostcenter" class="modal" role="dialog"  data-backdrop="static">
<div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='closeppcostcenter' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Cost Center</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="ppcostcenter1" class="display nowrap table  table-striped table-bordered" >
    <thead>
    <tr id="none-select" class="searchalldata" hidden>
            <td> <input type="hidden" name="hdn_cc1" id="hdn_cc1"/>
            <input type="hidden" name="hdn_cc2" id="hdn_cc2"/></td>
    </tr>

    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Code</th>
      <th class="ROW3">Description</th>
    </tr>

    </thead>
    <tbody>

      <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="ppcostcodesearch" class="form-control" autocomplete="off" onkeyup="ppcostCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="ppcostnamesearch" class="form-control" autocomplete="off" onkeyup="ppcostNameFunction()"></td>
      </tr>

    </tbody>
    </table>
      <table id="ppcostcenter2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">
        </thead>
        <tbody id="tbody_ppcost">
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>

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

<!-- Print -->
<div id="ReportView" class="modal" role="dialog"  data-backdrop="static"  >
  <div class="modal-dialog modal-md" style="width:50%; height:60%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='ReportViewclosePopup' >&times;</button>          
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Manual JV Print</p></div>
        <div class="row">
          <div class="frame-container col-lg-12 pl text-center" >
                <button class="btn topnavbt" id="btnReport">
                    Print
                </button>
                <button class="btn topnavbt" id="btnPdf">
                    PDF
                </button>
                <button class="btn topnavbt" id="btnExcel">
                    Excel
                </button>
          </div>
        </div>
        
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
          <div class="inner-form">
              <div class="row">
                  <div class="frame-container col-lg-12 pl " >                      
                      <iframe id="iframe_rpt" width="100%" height="1000" >
                      </iframe>
                  </div>
              </div>
          </div>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Print-->
@endsection


@push('bottom-css')
<style>
#custom_dropdown, #udfforsemst_filter {
    display: inline-table;
    margin-left: 15px;
  }
.dataTables_wrapper .row:nth-child(1) .col-sm-6:nth-child(2){text-align:right;}
#filtercolumn{color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
  }
  .single button {
    background: #eff7fb;
    width: 30px;
    border: 1px;
    padding: 10px 0;
    margin: 5px 0;
    text-align: center;
    /* color: #0f69cc; */
    font-weight: bold;
}

</style>
@endpush
@push('bottom-scripts')
<script>

//------------------------
  //GL/SL Account
  let tid = "#GlCodeTable2";
    let tid2 = "#GlCodeTable";
    let headers = document.querySelectorAll(tid2 + " th");

      // Sort the table element when clicking on the table headers
      headers.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(tid, ".clsglid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function GLCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("glcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("GlCodeTable2");
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

  function GLNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("glnamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("GlCodeTable2");
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

  $('#Accounting').on('click','[id*="txtGLID"]',function(event){
    var SL = $('#SubGL').is(':checked');

    var fieldid = $(this).parent().parent().find('[id*="GLID_REF"]').attr('id');


      $("#tbody_glsl").html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'{{route("transaction",[415,"getglsl"])}}',
            type:'POST',
            data:{'SL':SL,fieldid:fieldid},
            success:function(data) {
              $("#tbody_glsl").html(data);    
              bindGeneralLedger();  
              showSelectedCheck($("#"+fieldid).val(),"SELECT_"+fieldid);                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
              $("#tbody_glsl").html('');                        
            },
        });
    $("#glsl_popup").show();
    var id = $(this).attr('id');
    var id2 = $(this).parent().parent().find('[id*="GLID_REF"]').attr('id');
    var id3 = $(this).parent().parent().find('[id*="Description"]').attr('id');
    var id4 = $(this).parent().parent().find('[id*="txtflag_"]').attr('id');
    $('#hdn_GLID').val(id);
    $('#hdn_GLID2').val(id2);
    $('#hdn_GLID3').val(id3);
    $('#hdn_GLID4').val(id4);
    event.preventDefault();
  });

  $("#gl_closePopup").click(function(event){
    $("#glsl_popup").hide();
    event.preventDefault();
  });

  function bindGeneralLedger()
  {
    $('#GlCodeTable2').off(); 
    $(".clsglid").click(function(){
      var fieldid = $(this).attr('id');
      var txtid =    $("#txt"+fieldid+"").val();
      var txtval =   $("#txt"+fieldid+"").data("desc");
      var txtdesc =   $("#txt"+fieldid+"").data("desc2");
      var txtflag =   $("#txt"+fieldid+"").data("desc3");

      var txt_id1= $('#hdn_GLID').val();
      var txt_id2= $('#hdn_GLID2').val();
      var txt_id3= $('#hdn_GLID3').val();
      var txt_id4= $('#hdn_GLID4').val();
      
      $('#'+txt_id1).val(txtval);
      $('#'+txt_id2).val(txtid);
      $('#'+txt_id3).val(txtdesc);
      $('#'+txt_id4).val(txtflag);
	  
	  var rowid="ACCOUNT_BALANCE_"+txt_id1.split('_').pop();
      getBalanceGrid(txtid,rowid,txtflag);
	  
      $("#glsl_popup").hide();
      $("#glcodesearch").val(''); 
      $("#glnamesearch").val(''); 
     
      
      var customid = txtid;
      
      event.preventDefault();
    });
  }

      

  //GL/SL Account Ends
//------------------------


//------------------------
  //Cost Center Dropdown

  $('#Accounting').on('click','[id*="BtnCCID"]',function(event){
    var id = $(this).parent().parent().find('[id*="CCID_REF"]').attr('id');
    var glcode = $(this).parent().parent().find('[id*="txtGLID"]').val();
    var glid = $(this).parent().parent().find('[id*="GLID_REF"]').val();
    var glflag = $(this).parent().parent().find('[id*="txtflag"]').val();
    var gldesc = $(this).parent().parent().find('[id*="Description"]').val();
    var dramt = $(this).parent().parent().find('[id*="DR_AMT"]').val();
    var cramt = $(this).parent().parent().find('[id*="CR_AMT"]').val();
        $('#hdn_CCID').val(id);
        $('#hdn_CCID2').val(glcode);
        $('#hdn_CCID3').val(glid);
        $('#hdn_CCID4').val(glflag);
        $('#hdn_CCID5').val(gldesc);
        $('#hdn_CCID6').val(dramt);
        $('#hdn_CCID7').val(cramt);

        var objcost = <?php echo json_encode($objCostCenter); ?>;    
        var gl12 = [];
        $('#example5').find('.participantRow5').each(function(){
          if($(this).find('[id*="GLID"]').val() != '')
          {
            var glitem = $(this).find('[id*="GLID"]').val();
            gl12.push(glitem);
          }
        });

        if(jQuery.inArray(glid, gl12) !== -1)
        {          
          $('#example5').find('.participantRow5').each(function(){           

            if($(this).find('[id*="GLID"]').val() == glid)
            {
                var ccid = $(this).find('[id*="CCID"]').val();
                var D_AMT = $(this).find('[id*="D_AMT"]').val();
                var C_AMT = $(this).find('[id*="C_AMT"]').val();
                var cccode = '';
                $.each( objcost, function( cckey, ccvalue ) {
                  if(ccvalue.CCID == ccid)
                  {
                    cccode = ccvalue.CCCODE;
                  }
                });

                var $tr = $('.participantRow2').closest('#CostTable2');
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

                $clone.find('[id*="ppGLID"]').val(glcode);
                $clone.find('[id*="hdnGLID"]').val(glid);
                $clone.find('[id*="hdnflag"]').val(glflag);
                $clone.find('[id*="hdnDescription"]').val(gldesc);
                $clone.find('[id*="hdnDRAMT_"]').val(D_AMT);
                $clone.find('[id*="hdnCRAMT_"]').val(C_AMT);
                $clone.find('[id*="hdnCCID_"]').val(ccid);
                $clone.find('[id*="CostCenter_"]').val(cccode);
                $tr.closest('#CostTable2').append($clone);
                if(dramt != '' && cramt == '.00')
                {
                  $clone.find('[id*="hdnCRAMT"]').prop('disabled','true');
                  $clone.find('[id*="hdnDRAMT"]').removeAttr('disabled');
                }
                else if(cramt != '' && dramt == '.00')
                {
                  $clone.find('[id*="hdnDRAMT"]').prop('disabled','true');
                  $clone.find('[id*="hdnCRAMT"]').removeAttr('disabled');
                }
            }
          });

          $('#CostTable2').find('.participantRow2').each(function()
          {
            if($(this).find('[id*="hdnGLID"]').val() == '')
            {
              $(this).closest("tr").remove();
            }
          });

        }
        else
        {
            $('#CostTable2').find('.participantRow2').each(function(){
                $(this).find('[id*="ppGLID"]').val(glcode);
                $(this).find('[id*="hdnGLID"]').val(glid);
                $(this).find('[id*="hdnflag"]').val(glflag);
                $(this).find('[id*="hdnDescription"]').val(gldesc);
                $(this).find('[id*="hdnDRAMT_"]').val('');
                $(this).find('[id*="hdnCRAMT_"]').val('');
                $(this).find('[id*="hdnCCID_"]').val('');
                $(this).find('[id*="CostCenter_"]').val('');
                if(dramt != '' && cramt == '')
                {
                  $(this).find('[id*="hdnCRAMT"]').prop('disabled','true');
                  $(this).find('[id*="hdnDRAMT"]').removeAttr('disabled');
                }
                else if(cramt != '' && dramt == '')
                {
                  $(this).find('[id*="hdnDRAMT"]').prop('disabled','true');
                  $(this).find('[id*="hdnCRAMT"]').removeAttr('disabled');
                }
            });
        }
        bindCostCenter();
        $("#costpopup").show();
        event.preventDefault();
  });

  $("#costpopup").on('click',"#cc_closePopup", function(event){

        var dr_amt = $('#hdn_CCID6').val();
        var damt = 0.00;
        if(dr_amt != '')
        {
          $('#CostTable2').find('.participantRow2').each(function(){
              var damt2 = $(this).find('[id*="hdnDRAMT"]').val();
              damt = parseFloat(parseFloat(damt)+parseFloat(damt2)).toFixed(2);
          });
          if (parseFloat(damt) > parseFloat(dr_amt))
          {
                $('[id*="hdnDRAMT"]').val('');
                $("#FocusId").val($('[id*="hdnDRAMT"]'));
                $("#ProceedBtn").focus();
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn").hide();
                $("#OkBtn1").show();
                $("#AlertMessage").text('Debit Amount cannot be greater than Debit amount entered in Accounting tab.');
                $("#alert").modal('show');
                $("#OkBtn1").focus();
                return false;
          }
          else if (parseFloat(damt) < parseFloat(dr_amt))
          {
                $('[id*="hdnDRAMT"]').val('');
                $("#FocusId").val($('[id*="hdnDRAMT"]'));
                $("#ProceedBtn").focus();
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn").hide();
                $("#OkBtn1").show();
                $("#AlertMessage").text('Debit Amount cannot be less than Debit amount entered in Accounting tab.');
                $("#alert").modal('show');
                $("#OkBtn1").focus();
                return false;
          }
          else
          {

          }
        }

        var cr_amt = $('#hdn_CCID7').val();
        var camt = 0.00;
        if(cr_amt != '')
        {
          $('#CostTable2').find('.participantRow2').each(function(){
              var camt2 = $(this).find('[id*="hdnCRAMT"]').val();
              camt = parseFloat(parseFloat(camt)+parseFloat(camt2)).toFixed(2);
          });
          if (parseFloat(camt) > parseFloat(cr_amt))
          {
                $('[id*="hdnCRAMT"]').val('');
                $("#FocusId").val($('[id*="hdnCRAMT"]'));
                $("#ProceedBtn").focus();
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn").hide();
                $("#OkBtn1").show();
                $("#AlertMessage").text('Credit Amount cannot be greater than Credit amount entered in Accounting tab.');
                $("#alert").modal('show');
                $("#OkBtn1").focus();
                return false;
          }
          else if (parseFloat(camt) < parseFloat(cr_amt))
          {
                $('[id*="hdnCRAMT"]').val('');
                $("#FocusId").val($('[id*="hdnCRAMT"]'));
                $("#ProceedBtn").focus();
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn").hide();
                $("#OkBtn1").show();
                $("#AlertMessage").text('Credit Amount cannot be less than Credit amount entered in Accounting tab.');
                $("#alert").modal('show');
                $("#OkBtn1").focus();
                return false;
          }
          else
          {

          }        
        }

                var $tr = $('.participantRow5').closest('table');
                var allTrs = $tr.find('.participantRow5').last();
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

                $clone.find('[id*="GLID"]').val('');
                $clone.find('[id*="CCID"]').val('');
                $clone.find('[id*="D_AMT"]').val('');
                $clone.find('[id*="C_AMT"]').val('');
                $tr.closest('table').append($clone);   
                var rowCount3 = $('#Row_Count3').val();
                rowCount3 = parseInt(rowCount3)+1;
                $('#Row_Count3').val(rowCount3);


        $('#CostTable2').find('.participantRow2').each(function(){
              var GLID_REF = $(this).find('[id*="hdnGLID"]').val();
              $('#example5').find('.participantRow5').each(function()
                {
                  if($(this).find('[id*="GLID"]').val() == GLID_REF)
                  {
                    $(this).closest("tr").remove();
                  }
                });
        });

        $('#CostTable2').find('.participantRow2').each(function(){

            var GLID_REF = $(this).find('[id*="hdnGLID"]').val();
            var CCID_REF = $(this).find('[id*="hdnCCID"]').val();
            var DRAMT_REF = $(this).find('[id*="hdnDRAMT"]').val();
            if (DRAMT_REF == '')
            {
              DRAMT_REF = 0.00;
            } 
            var CRAMT_REF = $(this).find('[id*="hdnCRAMT"]').val();
            if (CRAMT_REF == '')
            {
              CRAMT_REF = 0.00;
            } 
            var txtid = $('#hdn_CCID').val();
            var CostCenter12= [];
            var TOTAMT = 0.00;
            TOTAMT = parseFloat(parseFloat(DRAMT_REF)+parseFloat(CRAMT_REF)).toFixed(2);
    
              if(TOTAMT != 'NaN' && TOTAMT != '0.00')
              {                
                var $tr = $('.participantRow5').closest('table');
                var allTrs = $tr.find('.participantRow5').last();
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

                $clone.find('[id*="GLID"]').val(GLID_REF);
                $clone.find('[id*="CCID"]').val(CCID_REF);
                $clone.find('[id*="D_AMT"]').val(DRAMT_REF);
                $clone.find('[id*="C_AMT"]').val(CRAMT_REF);
                $tr.closest('table').append($clone);   
                var rowCount3 = $('#Row_Count3').val();
                rowCount3 = parseInt(rowCount3)+1;
                $('#Row_Count3').val(rowCount3); 
                if ($('#'+txtid).val().indexOf(CCID_REF) !== -1) {                
                } 
                else 
                {
                  if($('#'+txtid).val() == '')
                  {
                    $('#'+txtid).val(CCID_REF);
                  }
                  else
                  {
                    $('#'+txtid).val($('#'+txtid).val()+','+CCID_REF);
                  }
                }                
              }
        });
              $('#example5').find('.participantRow5').each(function()
                {
                  if($(this).find('[id*="GLID"]').val() == '')
                  {
                    $(this).closest("tr").remove();
                  }
                });
        $('#CostTable2').off(); 
        $("#costpopup").hide();
        var costcenter = $('#hdnCostCenter').val();
        $("#costpopup").html(costcenter);
        event.preventDefault();      
      });

    function bindCostCenter(){
      $('#CostTable2').on('focusout','[id*="hdnDRAMT"]',function(event){
        
        if($(this).val() != '')
        {
          $(this).parent().parent().find('[id*="hdnCRAMT"]').prop('disabled','true');
          if(intRegex.test($(this).val())){
            $(this).val($(this).val() +'.00');
          }
        }
        else
        {
          $(this).parent().parent().find('[id*="hdnCRAMT"]').removeAttr('disabled');
        }
      });

      $('#CostTable2').on('focusout','[id*="hdnCRAMT"]',function(event){
        if($(this).val() != '')
        {
          $(this).parent().parent().find('[id*="hdnDRAMT"]').prop('disabled','true');
          if(intRegex.test($(this).val())){
            $(this).val($(this).val() +'.00');
          }
        }
        else
        {
          $(this).parent().parent().find('[id*="hdnDRAMT"]').removeAttr('disabled');
        }
      });
    }

      

  //Cost Center Dropdown Ends
//------------------------

//------------------------
//Cost Center Dropdown2

let cid = "#ppcostcenter2";
    let cid2 = "#ppcostcenter1";
    let ccheaders = document.querySelectorAll(cid2 + " th");

      // Sort the table element when clicking on the table headers
      ccheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(cid, ".clscccd", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function ppcostCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ppcostcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ppcostcenter2");
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

  function ppcostNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ppcostnamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ppcostcenter2");
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

  $('#costpopup').on('click','[id*="CostCenter"]',function(event){
    var customid = $(this).parent().parent().find('[id*="hdnGLID"]').val();
    var fieldid = $(this).parent().parent().find('[id*="hdnCCID"]').attr('id');

    $("#tbody_ppcost").html('');
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      
      $.ajax({
          url:'{{route("transaction",[415,"getCostCenter"])}}',
          type:'POST',
          data:{'customid':customid,fieldid:fieldid},
          success:function(data) {
            $("#tbody_ppcost").html(data);    
            bindCostCenter2();   
            showSelectedCheck($("#"+fieldid).val(),"SELECT_"+fieldid)                  
          },
          error:function(data){
            console.log("Error: Something went wrong.");
            $("#tbody_ppcost").html('');                        
          },
      });

    $("#ppcostcenter").show();
    var id = $(this).attr('id');
    var id2 = $(this).parent().parent().find('[id*="hdnCCID"]').attr('id');
    $('#hdn_cc1').val(id);
    $('#hdn_cc2').val(id2);
    event.preventDefault();
  });

  $("#closeppcostcenter").click(function(event){
    $("#ppcostcenter").hide();
    event.preventDefault();
  });

  function bindCostCenter2()
  {
    $('#ppcostcenter2').off(); 
    $(".clscccd").click(function(){
      var fieldid = $(this).attr('id');
      var txtid =    $("#txt"+fieldid+"").val();
      var txtval =   $("#txt"+fieldid+"").data("desc");

      var txt_id1= $('#hdn_cc1').val();
      var txt_id2= $('#hdn_cc2').val();
      
      $('#'+txt_id1).val(txtval);
      $('#'+txt_id2).val(txtid);
      $("#ppcostcenter").hide();
      $("#ppcostcodesearch").val(''); 
      $("#ppcostnamesearch").val(''); 
      
      event.preventDefault();
    });
  }  
  



 //Cost Center2 Dropdown Ends
//------------------------
//------------------------
     
$(document).ready(function(e) {
var Accounting = $("#Accounting").html(); 
$('#hdnAccounting').val(Accounting);
var CostCenter = $("#costpopup").html(); 
$('#hdnCostCenter').val(CostCenter);

// var objlastJVDT = <?php echo json_encode($objlastJVDT[0]->MJV_DT); ?>;
// var today = new Date(); 
// var jvdate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
// $('#MJV_DT').attr('min',objlastJVDT);
// $('#MJV_DT').attr('max',jvdate);

var lastdt = <?php echo json_encode($objlastJVDT[0]->MJV_DT); ?>;
var jv = <?php echo json_encode($objJV); ?>;
var today = new Date(); 
var sodate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2);
// if(lastdt < jv.MJV_DT)
// {
// $('#MJV_DT').attr('min',lastdt);
// }
// else
// {
//   $('#MJV_DT').attr('min',jv.MJV_DT);
// }

$('#MJV_DT').attr('min',jv.MJV_DT);
$('#MJV_DT').attr('max',jv.MJV_DT);




var jvudf = <?php echo json_encode($objUdfJVData); ?>;
var count2 = <?php echo json_encode($objCountUDF); ?>;
// $("#Row_Count1").val(1);
// $("#Row_Count2").val(count2);
$('#example4').find('.participantRow4').each(function(){
  var txt_id4 = $(this).find('[id*="udfinputid"]').attr('id');
  var udfid = $(this).find('[id*="UDFJVID_REF"]').val();
  $.each( jvudf, function( jvukey, jvuvalue ) {
    if(jvuvalue.UDFJVID == udfid)
    {
      var txtvaltype2 =   jvuvalue.VALUETYPE;
      var strdyn2 = txt_id4.split('_');
      var lastele2 =   strdyn2[strdyn2.length-1];
      var dynamicid2 = "udfvalue_"+lastele2;
      
      var chkvaltype2 =  txtvaltype2.toLowerCase();
      var strinp2 = '';

      if(chkvaltype2=='date'){
      strinp2 = '<input {{$ActionStatus}} type="date" placeholder="dd/mm/yyyy" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"  > ';       
      }
      else if(chkvaltype2=='time'){
      strinp2= '<input {{$ActionStatus}} type="time" placeholder="h:i" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"  > ';
      }
      else if(chkvaltype2=='numeric'){
      strinp2 = '<input {{$ActionStatus}} type="text" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"   > ';
      }
      else if(chkvaltype2=='text'){
      strinp2 = '<input {{$ActionStatus}} type="text" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"  > ';          
      }
      else if(chkvaltype2=='boolean'){            
          strinp2 = '<input {{$ActionStatus}} type="checkbox" name="'+dynamicid2+ '" id="'+dynamicid2+'" class="" > ';
      }
      else if(chkvaltype2=='combobox'){
      var txtoptscombo2 =   jvuvalue.DESCRIPTIONS;
      var strarray2 = txtoptscombo2.split(',');
      var opts2 = '';
      for (var i = 0; i < strarray2.length; i++) {
          opts2 = opts2 + '<option value="'+strarray2[i]+'">'+strarray2[i]+'</option> ';
      }
      strinp2 = '<select {{$ActionStatus}} name="'+dynamicid2+ '" id="'+dynamicid2+'" class="form-control" required>'+opts2+'</select>' ;          
      }
      $('#'+txt_id4).html('');  
      $('#'+txt_id4).html(strinp2);
    }
  });
});

$('#btnAdd').on('click', function() {
  var viewURL = '{{route("transaction",[415,"add"])}}';
              window.location.href=viewURL;
});

$('#btnExit').on('click', function() {
  var viewURL = '{{route('home')}}';
              window.location.href=viewURL;
});


$('#REVERSE').on('change', function() {
  if($(this).is(':checked') == true)
  {
    $('#REVERSE_DT').removeAttr('disabled');
  }
  else
  {
    $('#REVERSE_DT').prop('disabled','true');
  }
});
$("#Accounting").on('focusout', "[id*='CR_AMT']", function() 
{
  if($(this).val() != '')
  {
    if(intRegex.test($(this).val())){
      $(this).val($(this).val() +'.00');
    }
    $(this).parent().parent().find("[id*='DR_AMT']").prop('disabled','true');
    $(this).parent().parent().find("[id*='DR_AMT']").val('');
  }
  else
  {
    $(this).parent().parent().find("[id*='DR_AMT']").removeAttr('disabled');
  }
});
$("#Accounting").on('focusout', "[id*='DR_AMT']", function() 
{
  if($(this).val() != '')
  {
    if(intRegex.test($(this).val())){
      $(this).val($(this).val() +'.00');
    }
    $(this).parent().parent().find("[id*='CR_AMT']").prop('disabled','true');
    $(this).parent().parent().find("[id*='CR_AMT']").val('');
  }
  else
  {
    $(this).parent().parent().find("[id*='CR_AMT']").removeAttr('disabled');
  }
});


//delete row
$("#Accounting").on('click', '.remove', function() {
    var rowCount = $(this).closest('table').find('.participantRow').length;
    if (rowCount > 1) {
    $(this).closest('.participantRow').remove();     
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
    getTotalRowValue();
    event.preventDefault();
});

$("#costpopup").on('click', '.remove', function() {
    var rowCount = $(this).closest('table').find('.participantRow2').length;
    if (rowCount > 1) {
    $(this).closest('.participantRow2').remove();     
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
$("#Accounting").on('click', '.add', function() {
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

  $clone.find('input:text').val('');
  $clone.find('input:hidden').val('');
  $clone.find('input:text').removeAttr('disabled');
  $tr.closest('table').append($clone);         
  var rowCount1 = $('#Row_Count1').val();
  rowCount1 = parseInt(rowCount1)+1;
  $('#Row_Count1').val(rowCount1);
  $clone.find('.remove').removeAttr('disabled'); 
  event.preventDefault();
});

$("#costpopup").on('click', '.add', function() {
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

  $clone.find('[id*="CostCenter_"]').val('');
  $clone.find('[id*="hdnCCID_"]').val('');
  $clone.find('[id*="hdnDRAMT_"]').val('');
  $clone.find('[id*="hdnCRAMT_"]').val('');
  $clone.find('input:text').removeAttr('disabled');
  $tr.closest('table').append($clone);         
  var rowCount3 = $('#Row_Count3').val();
  rowCount3 = parseInt(rowCount3)+1;
  $('#Row_Count3').val(rowCount3);
  $clone.find('.remove').removeAttr('disabled'); 
  event.preventDefault();
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
    //reload form
  window.location.href = "{{route('transaction',[415,'add'])}}";
}//fnUndoYes


window.fnUndoNo = function (){
    $("#AFSNO").focus();
}//fnUndoNo

});
</script>

@endpush

@push('bottom-scripts')
<script>

$(document).ready(function() {

//   $("#btnSaveJV").on("submit", function( event ) {

//     if ($("#frm_trn_jv").valid()) {
//         // Do something
//         alert( "Handler for .submit() called." );
//         event.preventDefault();
//     }
// });


    $('#frm_trn_jv1').bootstrapValidator({       
        fields: {
            txtlabel: {
                validators: {
                    notEmpty: {
                        message: 'The Enquiry Number is required'
                    }
                }
            },            
        },
        submitHandler: function(validator, form, submitButton) {
            alert( "Handler for .submit() called." );
             event.preventDefault();
             $("#frm_trn_jv").submit();
        }
    });
});



$( "#btnSaveJV" ).click(function() {
  var formJournalVoucher = $("#frm_trn_jv");
  if(formJournalVoucher.valid()){
 
 $("#FocusId").val('');
 var MJV_NO          =   $.trim($("#MJV_NO").val());
 var MJV_DT          =   $.trim($("#MJV_DT").val());
 var REVERSE        =   $("#REVERSE").is(':checked');
 var REVERSE_DT     =   $("#REVERSE_DT").val();

 
 var tot_dramt = 0.00;
 var tot_cramt = 0.00;

 $('#example2').find('.participantRow').each(function()
  {
      var dramt = 0.00;
      var cramt = 0.00;

      if($(this).find('[id*="DR_AMT"]').val() != '')
      {
        dramt = $(this).find('[id*="DR_AMT"]').val();
      }
      if($(this).find('[id*="CR_AMT"]').val() != '')
      {
        cramt = $(this).find('[id*="CR_AMT"]').val();
      }
      tot_dramt = parseFloat(parseFloat(tot_dramt)+parseFloat(dramt)).toFixed(2);
      tot_cramt = parseFloat(parseFloat(tot_cramt)+parseFloat(cramt)).toFixed(2);
  });

  

 if(MJV_NO ===""){
     $("#FocusId").val($("#MJV_NO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please enter value in MJV Number.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(MJV_DT ===""){
     $("#FocusId").val($("#MJV_DT"));
     $("#AFSDT").val();  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select MJV Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }  

 else if(REVERSE === true && REVERSE_DT ===""){
  $("#FocusId").val($("#REVERSE_DT"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Reversal Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else{
    event.preventDefault();
    var allblank = [];
    var allblank2 = [];
    var allblank3 = [];
    var glcode = '';

          $('#example2').find('.participantRow').each(function()
          {    
              if($.trim($(this).find("[id*=txtGLID]").val())!="")
              {
                glcode = '';
                var gldamt = 0.00;
                var glcamt = 0.00;
                var cdamt  = 0.00;
                var ccamt  = 0.00;

                var glitem = $(this).find('[id*="GLID_REF"]').val();
                glcode = $(this).find('[id*="txtGLID"]').val()+'-'+$(this).find('[id*="Description"]').val();
                
                if($(this).find('[id*="DR_AMT"]').val() != '.00' && $(this).find('[id*="DR_AMT"]').val() != '') 
                {
                  gldamt = $(this).find('[id*="DR_AMT"]').val();        
                } 
                if($(this).find('[id*="CR_AMT"]').val() != '.00' && $(this).find('[id*="CR_AMT"]').val() != '') 
                {
                  glcamt = $(this).find('[id*="CR_AMT"]').val();        
                }
                
                $('#example5').find('.participantRow5').each(function()
                {
                    if($(this).find('[id*="GLID"]').val() != '' && $(this).find('[id*="GLID"]').val() == glitem)
                    {
                      if($(this).find('[id*="D_AMT"]').val() != '.00' && $(this).find('[id*="D_AMT"]').val() != '') 
                      {
                        cdamt = parseFloat(parseFloat(cdamt) + parseFloat($(this).find('[id*="D_AMT"]').val())).toFixed(2);        
                      } 
                      if($(this).find('[id*="C_AMT"]').val() != '.00' && $(this).find('[id*="C_AMT"]').val() != '') 
                      {
                        ccamt = parseFloat(parseFloat(ccamt) + parseFloat($(this).find('[id*="C_AMT"]').val())).toFixed(2);        
                      }   
                    }
                });

                  if(cdamt != '')
                  {
                    if(gldamt != cdamt)
                    {
                      $("#alert").modal('show');
                      $("#AlertMessage").text('Debit Amount of Cost Center not match with Debit Amount entered in Accounting tab for '+glcode);
                      $("#YesBtn").hide(); 
                      $("#NoBtn").hide();  
                      $("#OkBtn1").show();
                      $("#OkBtn1").focus();
                      highlighFocusBtn('activeOk');
                    }
                  }
                  if(ccamt != '')
                  {
                    if(glcamt != ccamt)
                    {
                      $("#alert").modal('show');
                      $("#AlertMessage").text('Credit Amount of Cost Center not match with Credit Amount entered in Accounting tab for '+glcode);
                      $("#YesBtn").hide(); 
                      $("#NoBtn").hide();  
                      $("#OkBtn1").show();
                      $("#OkBtn1").focus();
                      highlighFocusBtn('activeOk');
                    }
                  }
              }
              else
              {
                    allblank.push('false');
              }
              if($.trim($(this).find("[id*=DR_AMT]").val())!=""){
                allblank3.push('true');         
              }            
              else
              {
                if($.trim($(this).find("[id*=CR_AMT]").val())!="")
                {
                    allblank3.push('true');
                }
                else
                {
                    allblank3.push('false');
                }
              }              
          });
  }
        if(jQuery.inArray("false", allblank) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please select GL / SL in Accounting Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank3) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please enter Debit / Credit value in Accounting Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }  
        else if(parseFloat(tot_dramt) != parseFloat(tot_cramt)){
          $("#alert").modal('show');
          $("#AlertMessage").text('Debit / Credit value must equal in Accounting Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else{
                $("#alert").modal('show');
                $("#AlertMessage").text('Do you want to save to record.');
                $("#YesBtn").data("funcname","fnSaveData");  //set dynamic fucntion name
                $("#YesBtn").focus();
                $("#OkBtn").hide();
                highlighFocusBtn('activeYes');
          }

  }
});

$("#YesBtn").click(function(){

$("#alert").modal('hide');
var customFnName = $("#YesBtn").data("funcname");
    window[customFnName]();

}); //yes button

// $("#btnSaveJV" ).click(function() {
//     var formReqData = $("#frm_trn_jv");
//     if(formReqData.valid()){
//       validateForm();
//     }
// });

window.fnSaveData = function (){

//validate and save data
event.preventDefault();

     var trnseForm = $("#frm_trn_jv");
    var formData = trnseForm.serialize();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$("#btnSaveJV").hide(); 
$(".buttonload").show(); 
$("#btnApprove").prop("disabled", true);
$.ajax({
    url:'{{ route("transaction",[415,"update"])}}',
    type:'POST',
    data:formData,
    success:function(data) {
      $(".buttonload").hide(); 
      $("#btnSaveJV").show();   
      $("#btnApprove").prop("disabled", false);
       
        if(data.errors) {
            $(".text-danger").hide();

            if(data.errors.LABEL){
                showError('ERROR_LABEL',data.errors.LABEL);
                        $("#YesBtn").hide();
                        $("#NoBtn").hide();
                        $("#OkBtn1").show();
                        $("#AlertMessage").text('Please enter correct value in Label.');
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
            // $("#frm_mst_country").trigger("reset");

            $("#alert").modal('show');
            $("#OkBtn").focus();
            // window.location.href="{{ route('transaction',[90,'index']) }}";
        }
        else if(data.cancel) {                   
            console.log("cancel MSG="+data.msg);
            
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").show();

            $("#AlertMessage").text(data.msg);

            $(".text-danger").hide();
            // $("#frm_mst_country").trigger("reset");

            $("#alert").modal('show');
            $("#OkBtn1").focus();
            // window.location.href="{{ route('transaction',[90,'index']) }}";
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
        $("#btnSaveJV").show();   
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

$( "#btnApprove" ).click(function() {
  var formJournalVoucher = $("#frm_trn_jv");
  if(formJournalVoucher.valid()){
 
 $("#FocusId").val('');
 var MJV_NO          =   $.trim($("#MJV_NO").val());
 var MJV_DT          =   $.trim($("#MJV_DT").val());
 var REVERSE        =   $("#REVERSE").is(':checked');
 var REVERSE_DT     =   $("#REVERSE_DT").val();

 var tot_dramt = 0.00;
 var tot_cramt = 0.00;

 $('#example2').find('.participantRow').each(function()
  {
      var dramt = 0.00;
      var cramt = 0.00;

      if($(this).find('[id*="DR_AMT"]').val() != '.00')
      {
        dramt = $(this).find('[id*="DR_AMT"]').val();
      }
      if($(this).find('[id*="CR_AMT"]').val() != '.00')
      {
        cramt = $(this).find('[id*="CR_AMT"]').val();
      }
      tot_dramt = parseFloat(parseFloat(tot_dramt)+parseFloat(dramt)).toFixed(2);
      tot_cramt = parseFloat(parseFloat(tot_cramt)+parseFloat(cramt)).toFixed(2);
  });

 if(MJV_NO ===""){
     $("#FocusId").val($("#MJV_NO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please enter value in MJV Number.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(MJV_DT ===""){
     $("#FocusId").val($("#MJV_DT"));
     $("#AFSDT").val();  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select MJV Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }  

 else if(REVERSE === true && REVERSE_DT ===""){
  $("#FocusId").val($("#REVERSE_DT"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Reversal Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else{
    event.preventDefault();
    var allblank = [];
    var allblank2 = [];
    var allblank3 = [];
    var glcode = '';

          $('#example2').find('.participantRow').each(function()
          {    
              if($.trim($(this).find("[id*=txtGLID]").val())!="")
              {
                glcode = '';
                var gldamt = 0.00;
                var glcamt = 0.00;
                var cdamt  = 0.00;
                var ccamt  = 0.00;

                var glitem = $(this).find('[id*="GLID_REF"]').val()
                glcode = $(this).find('[id*="txtGLID"]').val()+'-'+$(this).find('[id*="Description"]').val();
                gldamt = $(this).find('[id*="DR_AMT"]').val()
                glcamt = $(this).find('[id*="CR_AMT"]').val()
                
                $('#example5').find('.participantRow5').each(function()
                {
                    if($(this).find('[id*="GLID"]').val() != '' && $(this).find('[id*="GLID"]').val() == glitem)
                    {
                      if($(this).find('[id*="D_AMT"]').val() != '.00' && $(this).find('[id*="D_AMT"]').val() != '') 
                      {
                        cdamt = parseFloat(parseFloat(cdamt) + parseFloat($(this).find('[id*="D_AMT"]').val())).toFixed(2);        
                      } 
                      if($(this).find('[id*="C_AMT"]').val() != '.00' && $(this).find('[id*="C_AMT"]').val() != '') 
                      {
                        ccamt = parseFloat(parseFloat(ccamt) + parseFloat($(this).find('[id*="C_AMT"]').val())).toFixed(2);        
                      }   
                    }
                });

                if(cdamt != '')
                  {
                    if(gldamt != cdamt)
                    {
                      $("#alert").modal('show');
                      $("#AlertMessage").text('Debit Amount of Cost Center not match with Debit Amount entered in Accounting tab for '+glcode);
                      $("#YesBtn").hide(); 
                      $("#NoBtn").hide();  
                      $("#OkBtn1").show();
                      $("#OkBtn1").focus();
                      highlighFocusBtn('activeOk');
                    }
                  }
                  if(ccamt != '')
                  {
                    if(glcamt != ccamt)
                    {
                      $("#alert").modal('show');
                      $("#AlertMessage").text('Credit Amount of Cost Center not match with Credit Amount entered in Accounting tab for '+glcode);
                      $("#YesBtn").hide(); 
                      $("#NoBtn").hide();  
                      $("#OkBtn1").show();
                      $("#OkBtn1").focus();
                      highlighFocusBtn('activeOk');
                    }
                  }
              }
              else
              {
                    allblank.push('false');
              }
              if($.trim($(this).find("[id*=DR_AMT]").val())!=".00"){
                allblank3.push('true');         
              }            
              else
              {
                if($.trim($(this).find("[id*=CR_AMT]").val())!=".00")
                {
                    allblank3.push('true');
                }
                else
                {
                    allblank3.push('false');
                }
              }              
          });
  }
        if(jQuery.inArray("false", allblank) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please select GL / SL in Accounting Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank3) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please enter Debit / Credit value in Accounting Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }  
        else if(parseFloat(tot_dramt) != parseFloat(tot_cramt)){
          $("#alert").modal('show');
          $("#AlertMessage").text('Debit / Credit value must equal in Accounting Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }  
        else{
                $("#alert").modal('show');
                $("#AlertMessage").text('Do you want to save to record.');
                $("#YesBtn").data("funcname","fnApproveData");  //set dynamic fucntion name
                $("#YesBtn").focus();
                $("#OkBtn").hide();
                highlighFocusBtn('activeYes');
          }

  }
});

window.fnApproveData = function (){

//validate and save data
event.preventDefault();

     var trnseForm = $("#frm_trn_jv");
    var formData = trnseForm.serialize();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$("#btnApprove").hide(); 
$(".buttonload_approve").show();  
$("#btnSaveJV").prop("disabled", true);
$.ajax({
    url:'{{ route("transaction",[415,"Approve"])}}',
    type:'POST',
    data:formData,
    success:function(data) {
      $("#btnApprove").show();  
      $(".buttonload_approve").hide();  
      $("#btnSaveJV").prop("disabled", false);
       
        if(data.errors) {
            $(".text-danger").hide();

            if(data.errors.LABEL){
                showError('ERROR_LABEL',data.errors.LABEL);
                        $("#YesBtn").hide();
                        $("#NoBtn").hide();
                        $("#OkBtn1").show();
                        $("#AlertMessage").text('Please enter correct value in Label.');
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
            // $("#frm_mst_country").trigger("reset");

            $("#alert").modal('show');
            $("#OkBtn").focus();
            // window.location.href="{{ route('transaction',[90,'index']) }}";
        }
        else if(data.cancel) {                   
            console.log("cancel MSG="+data.msg);
            
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").show();

            $("#AlertMessage").text(data.msg);

            $(".text-danger").hide();
            // $("#frm_mst_country").trigger("reset");

            $("#alert").modal('show');
            $("#OkBtn1").focus();
            // window.location.href="{{ route('transaction',[90,'index']) }}";
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
        $("#btnSaveJV").prop("disabled", false);
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

function showAlert(msg){
  $("#alert").modal('show');
  $("#AlertMessage").text(msg);
  $("#YesBtn").hide(); 
  $("#NoBtn").hide();  
  $("#OkBtn1").show();
  $("#OkBtn1").focus();
  highlighFocusBtn('activeOk');
}
//no button
$("#NoBtn").click(function(){
    $("#alert").modal('hide');
    $("#LABEL").focus();
});

//ok button
$("#OkBtn").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $(".text-danger").hide();
    window.location.href = '{{route("transaction",[415,"index"]) }}';
});

$("#OkBtn1").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $("#OkBtn1").hide();
    $("#"+$(this).data('focusname')).focus();
    // $("[id*=txtlabel]").focus();
    $(".text-danger").hide();
});

//
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

function getTotalRowValue(){

  var DR_AMT  = 0;
  var CR_AMT  = 0;

  $('#Accounting').find('.participantRow').each(function(){
    DR_AMT  = $(this).find('[id*="DR_AMT"]').val() > 0?DR_AMT+parseFloat($(this).find('[id*="DR_AMT"]').val()):DR_AMT;
    CR_AMT = $(this).find('[id*="CR_AMT"]').val() > 0?CR_AMT+parseFloat($(this).find('[id*="CR_AMT"]').val()):CR_AMT;
  });

  DR_AMT  = DR_AMT > 0?parseFloat(DR_AMT).toFixed(2):'';
  CR_AMT = CR_AMT > 0?parseFloat(CR_AMT).toFixed(2):'';

  $("#DR_AMT_TOTAL").text(DR_AMT);
  $("#CR_AMT_TOTAL").text(CR_AMT);
}

$(document).ready(function(){
  getTotalRowValue();
});

function getBalanceGrid(bankid,fieldid,flag){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var TaxStatus = $.ajax({type: 'POST',
  url:'{{route("transaction",[415,"getBalance"])}}',
  async: false,
  dataType: 'json',
  data: {id:bankid,flag:flag},
  done: function(response) {return response;}}).responseText;
  var TaxStatus=parseFloat(TaxStatus).toFixed(2);
  if(TaxStatus == '' || TaxStatus==0){
  $("#"+fieldid).val('0.00');

}
else if(TaxStatus > 0 ){
  $("#"+fieldid).val(Math.abs(TaxStatus).toFixed(2)+' Dr');
}else if(TaxStatus < 0 ){
  $("#"+fieldid).val(Math.abs(TaxStatus).toFixed(2)+' Cr');
}
}

//--------------------------------------Print Script Starts Here-----------------------------------
$('#btnPrint').on('click', function() {
            var DOCID    ='{{$objJV->MJVID}}';     
            var Flag    = 'H';
            var formData = 'SO='+ DOCID + '&MJVID='+ DOCID + '&Flag='+ Flag ;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route("transaction",[415,"ViewReport"])}}',
                type:'POST',
                data:formData,
                success:function(data) {
                    $("#report_title").html('Receipt Voucher Print');
                    $('#ReportView').show();
                    var localS = data;
                    document.getElementById('iframe_rpt').src = "data:text/html;charset=utf-8," + escape(localS);
                    $('#btnPdf').show();
                    $('#btnExcel').show();
                    $('#btnPrint').show();
                },
                error:function(data){
                    // console.log("Error: Something went wrong.");
                    // var localS = "";
                    // document.getElementById('iframe_rpt').src = "data:text/html;charset=utf-8," + escape(localS);
                    // $('#btnPdf').hide();
                    // $('#btnExcel').hide();
                    // $('#btnPrint').hide();
                    $("#ProceedBtn").focus();
                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn1").show();
                    $("#AlertMessage").text('Something Went Wrong.');
                    $("#alert").modal('show');
                    $("#OkBtn1").focus();
                    return false;
                },
            });
            event.preventDefault();
        
  });


  $('#btnExcel').on('click', function() {
            var DOCID    ='{{$objJV->MJVID}}';  
            var Flag = 'E';
            var formData = 'SO='+ DOCID + '&MJVID='+ DOCID + '&Flag='+ Flag ;
            var consultURL = '{{route("transaction",[415,"ViewReport",":rcdId"]) }}';
            consultURL = consultURL.replace(":rcdId",formData);
            window.location.href=consultURL;
            event.preventDefault();
      
});



$('#btnPdf').on('click', function() {
  var DOCID    ='{{$objJV->MJVID}}';  
  var Flag = 'P';
  var formData = 'SO='+ DOCID + '&MJVID='+ DOCID + '&Flag='+ Flag ;
  var consultURL = '{{route("transaction",[415,"ViewReport",":rcdId"]) }}';
  consultURL = consultURL.replace(":rcdId",formData);
  window.location.href=consultURL;
  event.preventDefault();
      
}); 


$("#ReportViewclosePopup").click(function(event){
        $("#ReportView").hide();
        event.preventDefault();
      });

//--------------------------------------Print Script Ends Here-----------------------------------
</script>


@endpush