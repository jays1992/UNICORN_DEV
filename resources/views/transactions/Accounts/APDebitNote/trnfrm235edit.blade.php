
@extends('layouts.app')
@section('content')
@inject('helper', 'App\Helpers\Helper')  
    

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="{{route('transaction',[235,'index'])}}" class="btn singlebt">AP Debit/Credit Note</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSave" ><i class="fa fa-save"></i> Save</button>
                        <button style="display:none" class="btn topnavbt buttonload"> <i class="fa fa-refresh fa-spin"></i> {{Session::get('save')}}</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo"  ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button style="display:none" class="btn topnavbt buttonload_approve" > <i class="fa fa-refresh fa-spin"></i> {{Session::get('approve')}}</button>
                        <button class="btn topnavbt" id="btnApprove" {{ (isset($objRights->APPROVAL1) || isset($objRights->APPROVAL2) || isset($objRights->APPROVAL3) || isset($objRights->APPROVAL4) || isset($objRights->APPROVAL5)) &&  ($objRights->APPROVAL1||$objRights->APPROVAL2||$objRights->APPROVAL3||$objRights->APPROVAL4||$objRights->APPROVAL5) == 1 ? '' : 'disabled'}} ><i class="fa fa-lock"></i>  Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div><!--row-->
    </div>

    <!-- <form id="frm_trn_apdcn" onsubmit="return validateForm()"  method="POST" class="needs-validation"  > -->
    <div class="container-fluid filter">
      <form id="frm_trn_apdcn"  method="POST"> 
      @csrf
      {{isset($objAPDRCR->APDRCRID[0]) ? method_field('PUT') : '' }}
	<div class="inner-form">
	
		<div class="row">
        <div class="col-lg-2 pl"><p>Debit/Credit No</p></div>
        <div class="col-lg-2 pl">
              <input type="hidden" name="APDRCRID" id="APDRCRID" value="{{ isset($objAPDRCR->APDRCRID)?$objAPDRCR->APDRCRID:'' }}" />
              <input {{$ActionStatus}} type="text" name="AP_DOC_NO" id="AP_DOC_NO" value="{{ isset($objAPDRCR->AP_DOC_NO)?$objAPDRCR->AP_DOC_NO:'' }}" class="form-control mandatory"  autocomplete="off" readonly style="text-transform:uppercase"  >
         </div>
        <div class="col-lg-2 pl"><p>Debit/Credit Date</p></div>
        <div class="col-lg-2 pl">
                  <input {{$ActionStatus}} type="date" name="AP_DOC_DT" id="AP_DOC_DT"  value="{{ isset($objAPDRCR->AP_DOC_DT)?$objAPDRCR->AP_DOC_DT:'' }}" onchange="checkPeriodClosing(235,this.value,1)" class="form-control mandatory"  placeholder="dd/mm/yyyy" />
        </div>

        <div class="col-lg-2 pl"><p>Source</p></div>
        <div class="col-lg-2 pl">
          <select {{$ActionStatus}} name="SOURCE_TYPE" id="SOURCE_TYPE"  onchange='sourceType(this.value)' class="form-control mandatory">
          <option {{ isset($objAPDRCR->SOURCE_TYPE) && $objAPDRCR->SOURCE_TYPE =='Vendor'?'selected="selected"':'' }} value="Vendor">Vendor</option>
          <option {{ isset($objAPDRCR->SOURCE_TYPE) && $objAPDRCR->SOURCE_TYPE =='Employee'?'selected="selected"':'' }} value="Employee">Employee</option>
          </select>
        </div>        
    </div>

    <div class="row">
      <div class="col-lg-2 pl"><p id="titalName">Vendor</p></div>
        <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="txtvendor" id="txtvendor" class="form-control"   value="{{isset($objAPDRCRSL->SGLCODE)?$objAPDRCRSL->SGLCODE.'-'.$objAPDRCRSL->SLNAME:''}}"  readonly />
                <input type="hidden" name="SLID_REF" id="SLID_REF"  class="form-control " value="{{ isset($objAPDRCR->SLID_REF)?$objAPDRCR->SLID_REF:'' }}" />
                <input type="hidden" name="Tax_State" id="Tax_State" class="form-control" autocomplete="off" value="{{ isset($objtaxstate)?$objtaxstate:'' }}" />
                <input type="hidden" name="hdnAccounting" id="hdnAccounting" class="form-control" autocomplete="off" />
                <input type="hidden" name="hdnTDS" id="hdnTDS" class="form-control" autocomplete="off" />
                <input type="hidden" name="hdnCostCenter" id="hdnCostCenter" class="form-control" autocomplete="off" />
                <input type="hidden" name="hdnCostCenter2" id="hdnCostCenter2" class="form-control" autocomplete="off" />
        </div>

        <div class="col-lg-2 pl"><p>Type</p></div>
        <div class="col-lg-2 pl">
          <select {{$ActionStatus}} name="AP_TYPE" id="AP_TYPE"  class="form-control mandatory">
            <option {{ isset($objAPDRCR->AP_TYPE) && $objAPDRCR->AP_TYPE =='Credit Note'?'selected="selected"':'' }} value="Credit Note">Credit Note</option>
            <option {{ isset($objAPDRCR->AP_TYPE) && $objAPDRCR->AP_TYPE =='Debit Note'?'selected="selected"':'' }} value="Debit Note">Debit Note</option>
            <option {{ isset($objAPDRCR->AP_TYPE) && $objAPDRCR->AP_TYPE =='Invoice'?'selected="selected"':'' }} value="Invoice">Invoice</option>
          </select>
        </div>
        <div class="col-lg-2 pl"><p> Reference No</p></div> 
        <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="REF_NO" id="REF_NO" value="{{ isset($objAPDRCR->REF_NO)?$objAPDRCR->REF_NO:'' }}" maxlength="30" class="form-control" autocomplete="off" />
        </div>
    </div>

    <div class="row">
      <div class="col-lg-2 pl"><p>Reference Date</p></div>
        <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="date" name="REF_DT" id="REF_DT" value="{{ isset($objAPDRCR->REF_DT)?$objAPDRCR->REF_DT:'' }}" class="form-control"  placeholder="dd/mm/yyyy"  />
        </div>
        
      <div class="col-lg-2 pl"><p>FC</p></div>
      <div class="col-lg-2 pl">
          <input type="checkbox" {{$ActionStatus}} name="FC" id="FC" class="form-checkbox" {{isset($objAPDRCR->FC) && $objAPDRCR->FC == 1 ? 'checked' : ''}} >
      </div>
      
      <div class="col-lg-2 pl"><p>Currency</p></div>
      <div class="col-lg-2 pl" id="divcurrency" >

      
          <input type="text" {{$ActionStatus}} name="CRID_popup" id="txtCRID_popup" disabled class="form-control"   autocomplete="off"   value="{{ isset($objAPDRCR->CRDESCRIPTION) && $objAPDRCR->CRDESCRIPTION !=''? $objAPDRCR->CRCODE.'-'.$objAPDRCR->CRDESCRIPTION:'' }}"/>
      
          <input type="hidden"  name="CRID_REF" id="CRID_REF" class="form-control" autocomplete="off"   value="{{ isset($objAPDRCR->CRID_REF)?$objAPDRCR->CRID_REF:'' }}" />
          
      </div>    
  </div>

    <div class="row">		
      <div class="col-lg-2 pl"><p>Conversion Factor</p></div>
      <div class="col-lg-2 pl">
          <input type="text" {{$ActionStatus}} name="CONVFACT" id="CONVFACT" class="form-control" onkeyup="MultiCurrency_Conversion('tot_amt')" maxlength="100" autocomplete="off" value="{{ isset($objAPDRCR->CONVFACT)?$objAPDRCR->CONVFACT:'' }}"  />
      </div>

        <div class="col-lg-2 pl"><p>Reason of Debit/Credit Note</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="text" name="REASON_DRCR_NOTE" id="REASON_DRCR_NOTE" value="{{ isset($objAPDRCR->REASON_DRCR_NOTE)?$objAPDRCR->REASON_DRCR_NOTE:'' }}" maxlength="200" class="form-control"  autocomplete="off"   />
        </div>
    
          <div class="col-lg-2 pl"><p>Common Narration</p></div>
          <div class="col-lg-2 pl">
              <input {{$ActionStatus}} type="text" name="COMMON_NARRATION" id="COMMON_NARRATION" class="form-control" value="{{ isset($objAPDRCR->COMMON_NAPRATION)?$objAPDRCR->COMMON_NAPRATION:'' }}" autocomplete="off"  />                          
          </div>
    </div>


    <div class="row">
      <div class="col-lg-2 pl"><p>Total Amount</p></div>
          <div class="col-lg-2 pl">
              <input {{$ActionStatus}} type="text" name="tot_amt" id="tot_amt" class="form-control"  autocomplete="off" readonly  />
          </div>

    <div id="multi_currency_section" style="display:none">
      <div class="col-lg-2 pl"  ><p id="currency_section"></p></div>
      <div class="col-lg-2 pl">
          <input type="text"  name="TotalValue_Conversion" id="TotalValue_Conversion" class="form-control"  autocomplete="off" readonly  />
      </div>
      </div>
    </div>
    
	</div>

	<div class="container-fluid">
		<div class="row">
			<ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#Accounting">Accounting</a></li> 
        <li><a data-toggle="tab" href="#TDS">TDS</a></li> 
        <li><a data-toggle="tab" href="#udf">UDF</a></li>
        <!-- <li><a data-toggle="tab" href="#CostCenter">Cost Center</a></li> -->
			</ul>
      <div class="tab-content">
      <div id="Accounting" class="tab-pane fade in active">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                            
                            <tr>
                                <th width="8%">GL Code<input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1"></th>
                                <th width="15%">Description</th>
								<th width="20%">Account Balance</th>
                                <th width="8%">Amount</th>
                                <th width="5%">Discount%</th>
                                <th width="5%">Discount Amount</th>
                                <th width="5%">Taxable Amount</th>
                                <th width="8%">SAC Code</th>
                                <th width="5%">IGST</th>
                                <th width="5%">IGST Amount</th>
                                <th width="5%">CGST</th>
                                <th width="5%">CGST Amount</th>
                                <th width="5%">SGST</th>
                                <th width="5%">SGST Amount</th>
                                <th width="8%">Total Amount</th>
                                <th width="8%">Remarks</th>
                                <th width="8%">Cost Center</th>                                
                                <th width="8%">Adjustment</th>                                
                                <th width="8%">Type</th>                                
                                <th width="5%">Action</th>
                            </tr>
                    </thead>
                    <tbody>
                    @if(!empty($objAPDRCRACC))
                      @foreach($objAPDRCRACC as $key => $row)
                          <tr  class="participantRow">
                                  <td style="text-align:center;" >
                                  <input {{$ActionStatus}} type="text" name={{"txtGLID_".$key}} id={{"txtGLID_".$key}} class="form-control" value="{{$row->GLCODE}}"  autocomplete="off"  readonly/></td>
                                  <td hidden><input type="hidden" name={{"GLID_REF_".$key}} id={{"GLID_REF_".$key}} class="form-control" value="{{$row->GLID_REF}}" autocomplete="off" /></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"Description_".$key}} id={{"Description_".$key}} class="form-control" value="{{$row->NAME}}"  autocomplete="off"  readonly/></td>
								  <td><input {{$ActionStatus}} type="text" name={{"ACCOUNT_BALANCE_".$key}} id={{"ACCOUNT_BALANCE_".$key}} class="form-control"  autocomplete="off" value="{{$helper->getBalance_show($row->GLID_REF)}}" readonly/></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"GL_AMT_".$key}} id={{"GL_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$row->AMT}}"   autocomplete="off"  /></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"DISC_PER_".$key}} id={{"DISC_PER_".$key}} class="form-control four-digits" value="{{$row->DISC_PER}}" maxlength="12"  autocomplete="off"  /></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"DISC_AMT_".$key}} id={{"DISC_AMT_".$key}} class="form-control two-digits" value="{{$row->DISC_AMT}}" maxlength="15"  autocomplete="off"  /></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"TAX_AMT_".$key}} id={{"TAX_AMT_".$key}} class="form-control two-digits" value="{{$row->TaxableAMT}}" maxlength="15"  autocomplete="off" readonly /></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"txtHSN_".$key}} id={{"txtHSN_".$key}} class="form-control" value="{{$row->HSNCODE}}" autocomplete="off"  readonly/></td>
                                  <td hidden><input type="hidden" name={{"HSNID_REF_".$key}} id={{"HSNID_REF_".$key}} class="form-control" value="{{$row->HSNID_REF}}" autocomplete="off" /></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"IGST_".$key}} id={{"IGST_".$key}} class="form-control four-digits" maxlength="12" value="{{$row->IGST}}" autocomplete="off"  readonly/></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"IGST_AMT_".$key}} id={{"IGST_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$row->IGSTAMT}}" autocomplete="off" readonly /></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"CGST_".$key}} id={{"CGST_".$key}} class="form-control four-digits" maxlength="12" value="{{$row->CGST}}" autocomplete="off"  readonly/></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"CGST_AMT_".$key}} id={{"CGST_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$row->CGSTAMT}}" autocomplete="off" readonly /></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"SGST_".$key}} id={{"SGST_".$key}} class="form-control four-digits" maxlength="12" value="{{$row->SGST}}" autocomplete="off"  readonly/></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"SGST_AMT_".$key}} id={{"SGST_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$row->SGSTAMT}}" autocomplete="off" readonly /></td>
                      @php
                          $Total=number_format(($row->TaxableAMT+$row->IGSTAMT+$row->CGSTAMT+$row->SGSTAMT),2, '.', '');
                      @endphp
                                  <td><input {{$ActionStatus}} type="text" name={{"TT_AMT_".$key}} id={{"TT_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$Total}}" autocomplete="off" readonly /></td>
                                  <td><input {{$ActionStatus}} type="text" name={{"REMARKS_".$key}} id={{"REMARKS_".$key}} class="form-control" maxlength="200" value="{{$row->REMAPKS}}" autocomplete="off" /></td>
                                  <td align="center" ><button class="btn" id={{"BtnCCID_".$key}} name={{"BtnCCID_".$key}} type="button"><i class="fa fa-clone"></i></button></td>
                                  <td hidden><input type="text" name={{"CCID_REF_".$key}} id={{"CCID_REF_".$key}} class="form-control" value="{{$row->CCID_REF}}" autocomplete="off"  readonly/></td>
                                  
                                  
                                  
                                  
                            <td align="center" ><button class="btn" name={{"ADJ_".$key}} id={{"ADJ_".$key}}  onclick="GetAdjustment(this.id);" type="button"><i class="fa fa-clone"></i></button></td>
                            <td hidden ><input type="hidden" name={{"PAYMENTID_REF_".$key}} id={{"PAYMENTID_REF_".$key}}  class="form-control" autocomplete="off"  value="{{$row->PAYMENTID_REF}}" /></td>
                            <td hidden ><input type="hidden" name={{"ADJUSTMENT_AMOUNT_".$key}} id={{"ADJUSTMENT_AMOUNT_".$key}}  class="form-control" autocomplete="off" value="{{$row->ADJUSTMENT_AMOUNT}}" /></td>

                            <td>                                 
                            <select name={{"TYPE_".$key}} id={{"TYPE_".$key}}  class="form-control" style="width: 85px;">
                            <option value="Advance" {{ isset($row->TYPE) && $row->TYPE =='Advance'?'selected="selected"':'' }} >Advance</option>
                            <option value="Loan" {{ isset($row->TYPE) && $row->TYPE =='Loan'?'selected="selected"':'' }}>Loan</option>                            
                            <option value="Medical" {{ isset($row->TYPE) && $row->TYPE =='Medical'?'selected="selected"':'' }}>Medical</option>
                            <option value="Conveyance" {{ isset($row->TYPE) && $row->TYPE =='Conveyance'?'selected="selected"':'' }}>Conveyance</option>
                            <option value="Others" {{ isset($row->TYPE) && $row->TYPE =='Others'?'selected="selected"':'' }}>Others</option>
                            </select></td>
                                  
                                  
                                  
                                  
                                  
                                  <td align="center" >
                                    <button {{$ActionStatus}} class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                                    <button {{$ActionStatus}} class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                                  </td>
                          </tr>
                          <tr></tr>
                      @endforeach 
                    @endif
                    </tbody>
            </table>
            </div>	
        </div> 
        <div id="TDS" class="tab-pane fade">
            <div class="row" style="margin-top:10px;margin-left:3px;" >	
                <div class="col-lg-1 pl"><p>TDS Applicable</p></div>
                <div class="col-lg-2 pl">
                  <select {{$ActionStatus}} name="drpTDS" id="drpTDS" class="form-control">
                      <option value=""></option>    
                      <option {{ isset($objAPDRCR->TDS) && $objAPDRCR->TDS =='1'?'selected="selected"':'' }} value="Yes">Yes</option>
                      <option {{ isset($objAPDRCR->TDS) && $objAPDRCR->TDS =='0'?'selected="selected"':'' }} value="No">No</option>
                  </select>
                </div>
            </div>
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                <table id="example3" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                            <tr>
                                <th width="8%">TDS<input class="form-control" type="hidden" name="Row_Count4" id ="Row_Count4"></th>
                                <th width="8%">TDS Ledger</th>
                                <th width="5%">Applicable</th>
                                <th width="8%">Assessable Value</th>
                                <th width="5%">TDS Rate</th>
                                <th width="8%">TDS Amount</th>
                                <th width="8%">Assessable Value</th>
                                <th width="5%">Surcharge Rate</th>
                                <th width="8%">Surcharge Amount</th>
                                <th width="8%">Assessable Value</th>
                                <th width="5%">Cess Rate</th>
                                <th width="8%">Cess Amount</th>
                                <th width="8%">Assessable Value</th>
                                <th width="5%">Special Cess Rate </th>
                                <th width="8%">Special Cess Amount</th>
                                <th width="8%">Total TDS Amount</th>                         
                                <th width="8%">Action</th>
                            </tr>
                    </thead>
                    <tbody id="tbody_tds">
                    @if(!empty($objAPDRCRTDS))
                      @foreach($objAPDRCRTDS as $tkey => $trow)
                        <tr  class="participantRow3">
                            <td style="text-align:center;" >
                            <input {{$ActionStatus}} type="text" name={{"txtTDS_".$tkey}} id={{"txtTDS_".$tkey}} class="form-control" value="{{$trow->CODE}}" autocomplete="off"  readonly/></td>
                            <td hidden><input type="hidden" name={{"TDSID_REF_".$tkey}} id={{"TDSID_REF_".$tkey}} value="{{$trow->TDSID_REF}}" class="form-control" autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"TDSLedger_".$tkey}} id={{"TDSLedger_".$tkey}} class="form-control" value="{{$trow->CODE_DESC}}" autocomplete="off"  readonly/></td>
                            <td  align="center" style="text-align:center;" ><input {{$ActionStatus}} type="checkbox" name={{"TDSApplicable_".$tkey}} id={{"TDSApplicable_".$tkey}} {{isset($trow->TDS_APPLICABLE) && $trow->TDS_APPLICABLE == 1?'checked' : ''}}/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"ASSESSABLE_VL_TDS_".$tkey}} id={{"ASSESSABLE_VL_TDS_".$tkey}} class="form-control two-digits" value="{{$trow->ASSESSABLE_VL_TDS}}" maxlength="15"  autocomplete="off"  /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"TDS_RATE_".$tkey}} id={{"TDS_RATE_".$tkey}} class="form-control four-digits" maxlength="12" value="{{$trow->TDS_RATE}}" autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name={{"TDS_EXEMPT_".$tkey}} id={{"TDS_EXEMPT_".$tkey}} class="form-control two-digits" value="{{$trow->TDS_EXEMP_LIMIT}}" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"TDS_AMT_".$tkey}} id={{"TDS_AMT_".$tkey}} class="form-control two-digits" maxlength="15"  autocomplete="off"  value="{{$trow->TDS_AMT}}" readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"ASSESSABLE_VL_SURCHARGE_".$tkey}} id={{"ASSESSABLE_VL_SURCHARGE_".$tkey}} class="form-control two-digits" value="{{$trow->ASSESSABLE_VL_SURCHARGE}}" maxlength="15"  autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"SURCHARGE_RATE_".$tkey}} id={{"SURCHARGE_RATE_".$tkey}} class="form-control four-digits" maxlength="12" value="{{$trow->SURCHARGE_RATE}}"  autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name={{"SURCHARGE_EXEMPT_".$tkey}} id={{"SURCHARGE_EXEMPT_".$tkey}} class="form-control two-digits" value="{{$trow->SURCHARGE_EXEMP_LIMIT}}" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"SURCHARGE_AMT_".$tkey}} id={{"SURCHARGE_AMT_".$tkey}} class="form-control two-digits" maxlength="15" value="{{$trow->SURCHARGE_AMT}}" autocomplete="off"  readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"ASSESSABLE_VL_CESS_".$tkey}} id={{"ASSESSABLE_VL_CESS_".$tkey}} class="form-control two-digits" maxlength="15" value="{{$trow->ASSESSABLE_VL_CESS}}" autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"CESS_RATE_".$tkey}} id={{"CESS_RATE_".$tkey}} class="form-control four-digits" maxlength="12" value="{{$trow->CESS_RATE}}" autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name={{"CESS_EXEMPT_".$tkey}} id={{"CESS_EXEMPT_".$tkey}} class="form-control two-digits" value="{{$trow->CESS_EXEMP_LIMIT}}" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"CESS_AMT_".$tkey}} id={{"CESS_AMT_".$tkey}} class="form-control two-digits" maxlength="15" value="{{$trow->CESS_AMT}}" autocomplete="off"  readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"ASSESSABLE_VL_SPCESS_".$tkey}} id={{"ASSESSABLE_VL_SPCESS_".$tkey}} class="form-control two-digits" maxlength="15" value="{{$trow->ASSESSABLE_VL_SPCESS}}"  autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"SPCESS_RATE_".$tkey}} id={{"SPCESS_RATE_".$tkey}} class="form-control four-digits" maxlength="12" value="{{$trow->SPCESS_RATE}}" autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name={{"SPCESS_EXEMPT_".$tkey}} id={{"SPCESS_EXEMPT_".$tkey}} class="form-control two-digits" value="{{$trow->SP_CESS_EXEMP_LIMIT}}" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"SPCESS_AMT_".$tkey}} id={{"SPCESS_AMT_".$tkey}} class="form-control two-digits" maxlength="15" value="{{$trow->SPCESS_AMT}}"  autocomplete="off"  readonly/></td>
                  @php
                    $TotalTDS=number_format(($trow->TDS_AMT+$trow->SURCHARGE_AMT+$trow->CESS_AMT+$trow->SPCESS_AMT),2, '.', '');
                  @endphp
                            <td><input {{$ActionStatus}} type="text" name={{"TOT_TD_AMT_".$tkey}} id={{"TOT_TD_AMT_".$tkey}} class="form-control two-digits" maxlength="15" value="{{$TotalTDS}}"  autocomplete="off"  readonly/></td>
                            <td style="min-width: 100px;" >
                            <button {{$ActionStatus}} class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                            <button {{$ActionStatus}} class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                          </td>
                        </tr>
                        <tr></tr>
                      @endforeach
                    @else
                        <tr  class="participantRow3">
                            <td style="text-align:center;" >
                            <input {{$ActionStatus}} type="text" name="txtTDS_0" id="txtTDS_0" class="form-control"  autocomplete="off"  readonly/></td>
                            <td hidden><input type="hidden" name="TDSID_REF_0" id="TDSID_REF_0" class="form-control" autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name="TDSLedger_0" id="TDSLedger_0" class="form-control"  autocomplete="off"  readonly/></td>
                            <td  align="center" style="text-align:center;" ><input {{$ActionStatus}} type="checkbox" name="TDSApplicable_0" id="TDSApplicable_0" /></td>
                            <td><input {{$ActionStatus}} type="text" name="ASSESSABLE_VL_TDS_0" id="ASSESSABLE_VL_TDS_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
                            <td><input {{$ActionStatus}} type="text" name="TDS_RATE_0" id="TDS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name="TDS_EXEMPT_0" id="TDS_EXEMPT_0" class="form-control two-digits" /></td>
                            <td><input {{$ActionStatus}} type="text" name="TDS_AMT_0" id="TDS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name="ASSESSABLE_VL_SURCHARGE_0" id="ASSESSABLE_VL_SURCHARGE_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name="SURCHARGE_RATE_0" id="SURCHARGE_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name="SURCHARGE_EXEMPT_0" id="SURCHARGE_EXEMPT_0" class="form-control two-digits" /></td>
                            <td><input {{$ActionStatus}} type="text" name="SURCHARGE_AMT_0" id="SURCHARGE_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name="ASSESSABLE_VL_CESS_0" id="ASSESSABLE_VL_CESS_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name="CESS_RATE_0" id="CESS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name="CESS_EXEMPT_0" id="CESS_EXEMPT_0" class="form-control two-digits" /></td>
                            <td><input {{$ActionStatus}} type="text" name="CESS_AMT_0" id="CESS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name="ASSESSABLE_VL_SPCESS_0" id="ASSESSABLE_VL_SPCESS_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name="SPCESS_RATE_0" id="SPCESS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name="SPCESS_EXEMPT_0" id="SPCESS_EXEMPT_0" class="form-control two-digits" /></td>
                            <td><input {{$ActionStatus}} type="text" name="SPCESS_AMT_0" id="SPCESS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name="TOT_TD_AMT_0" id="TOT_TD_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                            <td style="min-width: 100px;" >
                            <button {{$ActionStatus}} class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                            <button {{$ActionStatus}} class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                          </td>
                        </tr>
                        <tr></tr>
                    @endif
                    </tbody>
            </table>
            </div>	
        </div> 
        <div id="udf" class="tab-pane fade">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="margin-top:10px;height:280px;width:50%;">
                <table id="example4" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                    <tr >
                        <th>UDF Fields<input class="form-control" type="hidden" name="Row_Count2" id ="Row_Count2"></th>
                        <th>Value / Comments</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($objAPDRCRUDF))
                        @foreach($objAPDRCRUDF as $Ukey => $Urow)
                            <tr  class="participantRow4">
                                <td><input {{$ActionStatus}} type="text" name={{"popupUDF_APID_".$Ukey}} id={{"popupUDF_APID_".$Ukey}}  class="form-control"  autocomplete="off"  readonly/></td>
                                <td hidden><input type="hidden" name={{"UDF_APID_REF_".$Ukey}}  id={{"UDF_APID_REF_".$Ukey}} class="form-control" value="{{$Urow->UDFJVID_REF}}" autocomplete="off" /></td>
                                <td hidden><input type="hidden" name={{"UDFismandatory_".$Ukey}} id={{"UDFismandatory_".$Ukey}} class="form-control" autocomplete="off" /></td>
                                <td id={{"udfinputid_".$Ukey}}>
                                {{-- dynamic input --}} 
                                </td>
                                <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                            </tr>
                            <tr></tr>
                        @endforeach 
                    @else
                      @if($objUdfAPData)
                        @foreach($objUdfAPData as $uindex=>$uRow)
                          <tr  class="participantRow4">
                              <td><input {{$ActionStatus}} type="text" name={{"popupUDF_APID_".$uindex}} id={{"popupUDF_APID_".$uindex}} class="form-control" value="{{$uRow->LABEL}}" autocomplete="off"  readonly/></td>
                              <td hidden><input type="hidden" name={{"UDF_APID_REF_".$uindex}} id={{"UDF_APID_REF_".$uindex}} class="form-control" value="{{$uRow->UDFJVID}}" autocomplete="off"   /></td>
                              <td hidden><input type="hidden" name={{"UDFismandatory_".$uindex}} id={{"UDFismandatory_".$uindex}} value="{{$uRow->ISMANDATORY}}" class="form-control"   autocomplete="off" /></td>
                              <td id={{"udfinputid_".$uindex}} >
                              </td>
                              <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>                          
                          </tr>
                          <tr></tr>
                        @endforeach
                      @else
                          <tr  class="participantRow4">
                              <td><input {{$ActionStatus}} type="text" name="popupUDF_APID_0" id="popupUDF_APID_0" class="form-control" value="" autocomplete="off"  readonly/></td>
                              <td hidden><input type="hidden" name="UDF_APID_REF_0" id="UDF_APID_REF_0" class="form-control" value="" autocomplete="off"   /></td>
                              <td hidden><input type="hidden" name="UDFismandatory_0" id="UDFismandatory_0" value="" class="form-control"   autocomplete="off" /></td>
                              <td id="udfinputid_0" >
                              </td>
                              <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>                          
                          </tr>
                          <tr></tr>
                      @endif
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
                        <th>GLID<input class="form-control" type="hidden" name="Row_Count3" id ="Row_Count3"></th>
                        <th>CCID</th>
                        <th>CC_AMT</th>
                        <th>CC_RMKS</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($objAPDRCRCCD))
                        @foreach($objAPDRCRCCD as $cckey => $ccrow)
                          <tr  class="participantRow5">
                              <td><input {{$ActionStatus}} type="text" name={{"GLID_".$cckey}} id={{"GLID_".$cckey}} class="form-control"  value="{{$ccrow->GLID_REF}}" autocomplete="off"  readonly/></td>
                              <td><input {{$ActionStatus}} type="text" name={{"CCID_".$cckey}} id={{"CCID_".$cckey}} class="form-control" value="{{$ccrow->CCID_REF}}"  autocomplete="off"   readonly/></td>
                              <td><input {{$ActionStatus}} type="text" name={{"CC_AMT_".$cckey}} id={{"CC_AMT_".$cckey}} class="form-control two-digits" value="{{$ccrow->AMT}}"   autocomplete="off" readonly/></td>
                              <td><input {{$ActionStatus}} type="text" name={{"CC_RMKS_".$cckey}} id={{"CC_RMKS_".$cckey}} class="form-control two-digits" value="{{$ccrow->REMARKS}}"  autocomplete="off"  readonly/></td>                          
                          </tr>
                          <tr></tr>
                          @endforeach 
                    @else
                      <tr  class="participantRow5">
                          <td><input {{$ActionStatus}} type="text" name="GLID_0" id="GLID_0" class="form-control"  autocomplete="off"  readonly/></td>
                          <td><input {{$ActionStatus}} type="text" name="CCID_0" id="CCID_0" class="form-control" autocomplete="off"   readonly/></td>
                          <td><input {{$ActionStatus}} type="text" name="CC_AMT_0" id="CC_AMT_0" class="form-control two-digits"   autocomplete="off" readonly/></td>
                          <td><input {{$ActionStatus}} type="text" name="CC_RMKS_0" id="CC_RMKS_0" class="form-control"  autocomplete="off"  readonly/></td>                          
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
<!-- Vendor Dropdown -->
<div id="vendoridpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='vendor_close_popup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p id="titalNamemp">Vendor Details</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="VendorCodeTable" class="display nowrap table  table-striped table-bordered" >
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
        <td class="ROW2"><input type="text" id="vendorcodesearch" class="form-control" autocomplete="off" onkeyup="VendorCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="vendornamesearch" class="form-control" autocomplete="off" onkeyup="VendorNameFunction()"></td>
      </tr>
    </tbody>
    </table>
      <table id="VendorCodeTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2"> 
        </thead>
        <tbody id="tbody_vendor" >
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Vendor Dropdown-->



<!-- Currency Dropdown -->
<div id="cridpopup" class="modal" role="dialog"  data-backdrop="static">
<div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='crid_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Currency</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="CurrencyTable" class="display nowrap table  table-striped table-bordered" width="100%">
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
        <td class="ROW2"><input type="text" id="currencycodesearch" class="form-control" onkeyup="CurrencyCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="currencynamesearch" class="form-control" onkeyup="CurrencyNameFunction()"></td>
      </tr>
    </tbody>
    </table>
      <table id="CurrencyTable2" class="display nowrap table  table-striped table-bordered" width="100%">
        <thead id="thead2">
          <!-- <tr>
            <th>GLCode</th>
            <th>GLName</th>
          </tr> -->
          
        </thead>
        <tbody>
        @foreach ($objothcurrency as $crindex=>$crRow)
        <tr>
          <td class="ROW1"> <input type="checkbox" name="SELECT_CRID[]" id="cridcode_{{ $crindex }}" class="clscrid" value="{{ $crRow-> CRID }}" ></td>
          <td class="ROW2">{{ $crRow-> CRCODE }}
            <input type="hidden" id="txtcridcode_{{ $crindex }}" data-desc="{{ $crRow-> CRCODE }}" data-desc2="{{ $crRow-> CRDESCRIPTION }}"  value="{{ $crRow-> CRID }}"/>
          </td>
          <td class="ROW3">{{ $crRow-> CRDESCRIPTION }}</td>
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
<!-- Currency Dropdown-->  




<!-- Adjustment -->
<div id="Adjustmentpopup" class="modal" role="dialog"  data-backdrop="static" >
  <div class="modal-dialog modal-md" style="width:1250px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='AdjustmentclosePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Adjustment</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="adjustmentTable" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
      <thead style="position: sticky;top: 0">
        <tr>
          <th>Doc No</th>
          <th>Doc Date</th>
          <th>Type</th>          
          <th>Amount</th>
          <th>Balance Amount</th>
          <th>Amount (Adjustment)</th>
        </tr>
        <tr>        
        <td id="Data_seach_adjustment" colspan="8">please wait...</td>
        </tr>

      </thead>
      <tbody id="tbody_adjustment">
          
      </tbody>
    </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Adjustment-->



<!--GL dropdown-->

<div id="gl_popup" class="modal" role="dialog"  data-backdrop="static">
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
      <table id="GlCodeTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">
        </thead>
        <tbody id="tbody_gl">
        @foreach ($objgeneralledger as $index=>$glRow)
          <tr >
              <td class="ROW1"> <input type="checkbox" name="SELECT_GLID_REF[]" id="glidcode_{{ $index }}" class="clsglid" value="{{ $glRow-> GLID }}" ></td>
              <td class="ROW2">{{ $glRow-> GLCODE }}
                <input type="hidden" id="txtglidcode_{{ $index }}" data-desc="{{ $glRow-> GLCODE }}" data-desc2="{{ $glRow-> GLNAME }}"  value="{{ $glRow-> GLID }}"/>
              </td>
              <td class="ROW3">{{ $glRow-> GLNAME }}</td>
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
<!--GL dropdown-->

<!--hsn dropdown-->

<div id="hsn_popup" class="modal" role="dialog"  data-backdrop="static">
<div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='hsn_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>HSN Account</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="hsnCodeTable" class="display nowrap table  table-striped table-bordered" >
    <thead>
    <tr id="none-select" class="searchalldata" hidden>
            <td> 
                 <input type="hidden" name="hdn_hsnID" id="hdn_hsnID"/>
                 <input type="hidden" name="hdn_hsnID2" id="hdn_hsnID2"/>
                 <input type="hidden" name="hdn_hsnID3" id="hdn_hsnID3"/>
                 <input type="hidden" name="hdn_hsnID4" id="hdn_hsnID4"/>
                 <input type="hidden" name="hdn_hsnID5" id="hdn_hsnID5"/>
                 <input type="hidden" name="hdn_hsnID6" id="hdn_hsnID6"/>
            </td>
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
        <td class="ROW2"><input type="text" id="hsncodesearch" class="form-control" autocomplete="off" onkeyup="hsnCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="hsnnamesearch" class="form-control" autocomplete="off" onkeyup="hsnNameFunction()"></td>
      </tr>

    </tbody>
    </table>
      <table id="hsnCodeTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">
        </thead>
        <tbody id="tbody_hsn">
          @foreach ($objHSN as $index=>$hsnRow)
            <tr >
                <td class="ROW1"> <input type="checkbox" name="SELECT_HSNID_REF[]" id="hsnidcode_{{ $index }}" class="clshsnid" value="{{ $hsnRow-> HSNID }}" ></td>
                <td class="ROW2">{{ $hsnRow-> HSNCODE }}
                  <input type="hidden" id="txthsnidcode_{{ $index }}" data-desc="{{ $hsnRow-> HSNCODE }}" data-desc2="{{ $hsnRow-> HSNDESCRIPTION }}"  value="{{ $hsnRow-> HSNID }}"/>
                </td>
                <td class="ROW3">{{ $hsnRow-> HSNDESCRIPTION }}</td>
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
<!--hsn dropdown-->

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
            </td>
    </tr>
    <tr>
            <th style="width:20%;">GL Code</th>
            <th style="width:20%;">GL Description</th>
            <th style="width:15%;">Cost Centre Code</th>
            <th style="width:15%;">Amount</th>
            <th style="width:15%;">Remarks</th>
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
            <td style="width:20%;">
            <input {{$ActionStatus}} type="text" name="ppGLID_0" id="ppGLID_0" class="form-control"  autocomplete="off"  readonly/></td>
            <td hidden><input type="hidden" name="hdnGLID_0" id="hdnGLID_0" class="form-control" autocomplete="off" /></td>
            <td style="width:20%;"><input {{$ActionStatus}} type="text" name="hdnDescription_0" id="hdnDescription_0" class="form-control"  autocomplete="off"  readonly/></td>
            <td style="width:15%;"><input {{$ActionStatus}} type="text" name="CostCenter_0" id="CostCenter_0" class="form-control" maxlength="20"  autocomplete="off" readonly  /></td>
            <td hidden><input type="hidden" name="hdnCCID_0" id="hdnCCID_0" class="form-control" autocomplete="off" /></td>
            <td style="width:15%;"><input {{$ActionStatus}} type="text" name="hdnCCAMT_0" id="hdnCCAMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
            <td style="width:15%;"><input {{$ActionStatus}} type="text" name="CCRMKS_0" id="CCRMKS_0" class="form-control" maxlength="200"  autocomplete="off"  /></td>
            <td style="width:15%;">
            <button {{$ActionStatus}} class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
            <button {{$ActionStatus}} class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
          </td>
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

// START VENDOR CODE FUNCTION
let tid_vendor = "#VendorCodeTable2";
let tid_vendor2 = "#VendorCodeTable";
let headers_vendor = document.querySelectorAll(tid_vendor2 + " th");

      
headers_vendor.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(tid_vendor, ".clsvendorid", "td:nth-child(" + (i + 1) + ")");
  });
});

function VendorCodeFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("vendorcodesearch");
    filter = input.value.toUpperCase();
    if(filter.length == 0)
    {
      var CODE = ''; 
      var NAME = ''; 
      loadVendor(CODE,NAME); 
    }
    else if(filter.length >= 3)
    {
      var CODE = filter; 
      var NAME = ''; 
      loadVendor(CODE,NAME); 
    }
    else
    {
      table = document.getElementById("VendorCodeTable2");
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
}

function VendorNameFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("vendornamesearch");
    filter = input.value.toUpperCase();
    if(filter.length == 0)
    {
      var CODE = ''; 
      var NAME = ''; 
      loadVendor(CODE,NAME);
    }
    else if(filter.length >= 3)
    {
      var CODE = ''; 
      var NAME = filter; 
      loadVendor(CODE,NAME);  
    }
    else
    {
      table = document.getElementById("VendorCodeTable2");
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
}

function loadVendor(CODE,NAME){
   
  $("#tbody_vendor").html('');
  var CommonValue = $('#SOURCE_TYPE').val();

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url:'{{route("transaction",[$FormId,"getVendor"])}}',
    type:'POST',
    data:{'CODE':CODE,'NAME':NAME,'CommonValue':CommonValue},
    success:function(data) {
      $("#tbody_vendor").html(data); 
      bindVendorEvents();
      showSelectedCheck($("#SLID_REF").val(),"SELECT_SLID_REF"); 
    },
    error:function(data){
    console.log("Error: Something went wrong.");
    $("#tbody_vendor").html('');                        
    },
  });
}

$('#txtvendor').click(function(event){ 

  var CODE = ''; 
  var NAME = ''; 
  loadVendor(CODE,NAME);  

  var CommonValue = $('#SOURCE_TYPE').val();
    if(CommonValue=='Vendor'){
      $('#titalNamemp').html('Vendor Details');
    }else{
      $('#titalNamemp').html('Employee Details');
    }

  $("#vendoridpopup").show();
  event.preventDefault();
});

$("#vendor_close_popup").click(function(event){
  $("#vendoridpopup").hide();
  event.preventDefault();
});

function bindVendorEvents(){

  $('.clsvendorid').click(function(){
    
    var id = $(this).attr('id');
    var txtval =    $("#txt"+id+"").val();
    var texdesc =   $("#txt"+id+"").data("desc");
    var oldSLID_REF =   $("#SLID_REF").val();
    var AccountingClone = $('#hdnAccounting').val();   
    var TDSClone = $('#hdnTDS').val();   
    var CostClone = $('#hdnCostCenter').val();  

    $("#txtvendor").val(texdesc);
    $("#txtvendor").blur();
    $("#SLID_REF").val(txtval);

    if (txtval != oldSLID_REF){
      
      $('#tot_amt').val('0.00');
      MultiCurrency_Conversion('tot_amt');  
      $('#Accounting').html(AccountingClone);
      var count11 = <?php echo json_encode($objCount1); ?>;
        $('#Row_Count1').val(count11);
        $('#example2').find('.participantRow').each(function(){
          $(this).find('input:text').val('');
          $(this).find('input:hidden').val('');
          var rowcount = $('#Row_Count1').val();
          if(rowcount > 1)
          {
            $(this).closest('.participantRow').remove();
            rowcount = parseInt(rowcount) - 1;
            $('#Row_Count1').val(rowcount);
          }
        });

        $('#TDS').html(TDSClone);
        var count44 = <?php echo json_encode($objCount4); ?>;
        $('#Row_Count4').val(count44);
        $('#example3').find('.participantRow3').each(function(){
          $(this).find('input:text').val('');
          $(this).find('input:hidden').val('');
          $(this).find('input:checkbox').removeAttr('checked');
          var rowcount = $('#Row_Count4').val();
          if(rowcount > 1)
          {
            $(this).closest('.participantRow3').remove();
            rowcount = parseInt(rowcount) - 1;
            $('#Row_Count4').val(rowcount);
          }
        });

        $('#CostCenter').html(CostClone);
        var count33 = <?php echo json_encode($objCount3); ?>;
        $('#Row_Count3').val(count33);
        $('#example5').find('.participantRow5').each(function(){
          $(this).find('input:text').val('');
          $(this).find('input:hidden').val('');
          var rowcount = $('#Row_Count3').val();
          if(rowcount > 1)
          {
            $(this).closest('.participantRow5').remove();
            rowcount = parseInt(rowcount) - 1;
            $('#Row_Count3').val(rowcount);
          }
        });
      $('#Row_Count1').val('1');
      $('#Row_Count4').val('1');
      $('#Row_Count3').val('1');

    }


    $("#vendoridpopup").hide();
    $("#vendorcodesearch").val(''); 
    $("#vendornamesearch").val('');

    var customid = txtval;
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url:'{{route("transaction",[235,"getShipTo"])}}',
              type:'POST',
              data:{'id':customid},
              success:function(data) {
                $("#Tax_State").val(data);
              },
              error:function(data){
                console.log("Error: Something went wrong.");
                $("#Tax_State").val('');
              },
          });
          $.ajax({
              url:'{{route("transaction",[235,"getTDSApplicability"])}}',
              type:'POST',
              data:{'id':customid},
              success:function(data) {
                if(data == 1)
                {
                  $('#drpTDS').val('Yes');
                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });
                      $.ajax({
                          url:'{{route("transaction",[235,"getTDSDetails"])}}',
                          type:'POST',
                          data:{'id':customid},
                          success:function(data) {
                            $("#tbody_tds").html('');
                            $("#tbody_tds").html(data);
                          },
                          error:function(data){
                            console.log("Error: Something went wrong.");
                            var TDSBody = $('#tbody_tds').html();
                            $("#tbody_tds").html(TDSBody);
                          },
                      });
                }
                else
                {
                  $('#drpTDS').val('No');
                }
              },
              error:function(data){
                console.log("Error: Something went wrong.");
                $('#drpTDS').val('');
              },
          });  
          event.preventDefault();
      });
  }

//Vendor Ends



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
    $("#gl_popup").show();
    var id = $(this).attr('id');
    var id2 = $(this).parent().parent().find('[id*="GLID_REF"]').attr('id');
    var id3 = $(this).parent().parent().find('[id*="Description"]').attr('id');
    $('#hdn_GLID').val(id);
    $('#hdn_GLID2').val(id2);
    $('#hdn_GLID3').val(id3);
    event.preventDefault();
  });

  $("#gl_closePopup").click(function(event){
    $("#gl_popup").hide();
    event.preventDefault();
  });

  
    $(".clsglid").click(function(){
      var fieldid = $(this).attr('id');
      var txtid =    $("#txt"+fieldid+"").val();
      var txtval =   $("#txt"+fieldid+"").data("desc");
      var txtdesc =   $("#txt"+fieldid+"").data("desc2");

      var txt_id1= $('#hdn_GLID').val();
      var txt_id2= $('#hdn_GLID2').val();
      var txt_id3= $('#hdn_GLID3').val();
      
      $('#'+txt_id1).val(txtval);
      $('#'+txt_id2).val(txtid);
      $('#'+txt_id3).val(txtdesc);
	  
	  var rowid="ACCOUNT_BALANCE_"+txt_id1.split('_').pop();
      getBalanceGrid(txtid,rowid);
	  
      $("#gl_popup").hide();
      $("#glcodesearch").val(''); 
      $("#glnamesearch").val(''); 
      
      event.preventDefault();
    });

      

  //GL/SL Account Ends
//------------------------

//------------------------
  //HSN Account
    let hsntid = "#hsnCodeTable2";
    let hsntid2 = "#hsnCodeTable";
    let hsnheaders = document.querySelectorAll(hsntid2 + " th");

      // Sort the table element when clicking on the table headers
      hsnheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(hsntid, ".clshsnid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function hsnCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("hsncodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("hsnCodeTable2");
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

  function hsnNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("hsnnamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("hsnCodeTable2");
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

  $('#Accounting').on('click','[id*="txtHSN"]',function(event){
    $("#hsn_popup").show();
    var id = $(this).attr('id');
    var id2 = $(this).parent().parent().find('[id*="HSNID_REF"]').attr('id');
    var id3 = $(this).parent().parent().find('[id*="IGST_"]').attr('id');
    var id4 = $(this).parent().parent().find('[id*="CGST_"]').attr('id');
    var id5 = $(this).parent().parent().find('[id*="SGST_"]').attr('id');
    $('#hdn_hsnID').val(id);
    $('#hdn_hsnID2').val(id2);
    $('#hdn_hsnID3').val(id3);
    $('#hdn_hsnID4').val(id4);
    $('#hdn_hsnID5').val(id5);
    event.preventDefault();
  });

  $("#hsn_closePopup").click(function(event){
    $("#hsn_popup").hide();
    event.preventDefault();
  });
  
  $(".clshsnid").click(function(){
      var fieldid = $(this).attr('id');
      var txtid =    $("#txt"+fieldid+"").val();
      var txtval =   $("#txt"+fieldid+"").data("desc");
      var txtdesc =   $("#txt"+fieldid+"").data("desc2");

      var txt_id1= $('#hdn_hsnID').val();
      var txt_id2= $('#hdn_hsnID2').val();
      $('#'+txt_id1).val(txtval);
      $('#'+txt_id2).val(txtid);
      $("#hsn_popup").hide();
      $("#hsncodesearch").val(''); 
      $("#hsnnamesearch").val(''); 
      
      var taxstate = $('#Tax_State').val();     
      var customid = txtid;
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
        $.ajax({
              url:'{{route("transaction",[235,"gettaxCode"])}}',
              type:'POST',
              data:{'id':customid,'taxstate':taxstate},
              success:function(data) {                
                  $('#hdn_hsnID6').val(data);
              },
              error:function(data){
                console.log("Error: Something went wrong.");
              },
        });
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url:'{{route("transaction",[235,"gettax"])}}',
              type:'POST',
              data:{'id':customid,'taxstate':taxstate},
              success:function(data) {
                if(taxstate == 'WithinState')
                {
                  var txt_id3= $('#hdn_hsnID3').val();
                  var txt_id4= $('#hdn_hsnID4').val();
                  $('#'+txt_id3).val('0.0000');
                  $('#'+txt_id3).parent().parent().find('[id*="IGST_AMT"]').val('0.00');
                  $('#'+txt_id4).val(data);
                  var taxamount = $('#'+txt_id3).parent().parent().find('[id*="TAX_AMT"]').val();
                  var amt1 = parseFloat((parseFloat(data)*parseFloat(taxamount))/100).toFixed(2);
                  $('#'+txt_id4).parent().parent().find('[id*="CGST_AMT"]').val(amt1);
                  var TaxCode1 = $('#hdn_hsnID6').val();
                    $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                    });
                    $.ajax({
                          url:'{{route("transaction",[235,"gettax2"])}}',
                          type:'POST',
                          data:{'id':customid,'taxstate':taxstate,'TaxCode1':TaxCode1},
                          success:function(data) {                
                                var txt_id5= $('#hdn_hsnID5').val();
                                $('#'+txt_id5).val(data);
                                var taxamount2 = $('#'+txt_id5).parent().parent().find('[id*="TAX_AMT"]').val();
                                var amt2 = parseFloat((parseFloat(data)*parseFloat(taxamount2))/100).toFixed(2);
                                $('#'+txt_id4).parent().parent().find('[id*="SGST_AMT"]').val(amt2);
                                var amt4 = $('#'+txt_id5).parent().parent().find('[id*="CGST_AMT"]').val();
                                var amt3 = parseFloat(parseFloat(taxamount2)+parseFloat(amt2)+parseFloat(amt4)).toFixed(2);
                                $('#'+txt_id4).parent().parent().find('[id*="TT_AMT"]').val(amt3);
                          },
                          error:function(data){
                            console.log("Error: Something went wrong.");
                          },
                    });
                }
                else if(taxstate == 'OutofState')
                {
                  var txt_id3= $('#hdn_hsnID3').val();
                  var txt_id4= $('#hdn_hsnID4').val();
                  var txt_id5= $('#hdn_hsnID5').val();
                  $('#'+txt_id4).val('0.0000');
                  $('#'+txt_id4).parent().parent().find('[id*="CGST_AMT"]').val('0.00');
                  $('#'+txt_id5).val('0.0000');
                  $('#'+txt_id4).parent().parent().find('[id*="SGST_AMT"]').val('0.00');
                  $('#'+txt_id3).val(data);
                  var taxamount = $('#'+txt_id3).parent().parent().find('[id*="TAX_AMT"]').val();
                  var amt1 = parseFloat((parseFloat(data)*parseFloat(taxamount))/100).toFixed(2);
                  $('#'+txt_id4).parent().parent().find('[id*="IGST_AMT"]').val(amt1);
                  var amt3 = parseFloat(parseFloat(taxamount)+parseFloat(amt1)).toFixed(2);
                  $('#'+txt_id4).parent().parent().find('[id*="TT_AMT"]').val(amt3);
                }
              },
              error:function(data){
                console.log("Error: Something went wrong.");
              },
          });
    var totalamount = 0.00;
    $('#example2').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TT_AMT"]').val() != '')
        {
          var ttamt21 = $(this).find('[id*="TT_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(ttamt21)).toFixed(2);
        }
    });

    $('#example3').find('.participantRow3').each(function()
    {
        if($(this).find('[id*="TOT_TD_AMT"]').val() != '')
        {
          var tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(tttdsamt21)).toFixed(2);
        }
    });
    $('#tot_amt').val(totalamount);
    MultiCurrency_Conversion('tot_amt');  
              
      event.preventDefault();
  });
  //HSN Account Ends
//------------------------


//------------------------
  //Cost Center Dropdown
  $('#Accounting').on('click','[id*="BtnCCID"]',function(event){
    var id = $(this).parent().parent().find('[id*="CCID_REF"]').attr('id');
    var glcode = $(this).parent().parent().find('[id*="txtGLID"]').val();
    var glid = $(this).parent().parent().find('[id*="GLID_REF"]').val();
    var gldesc = $(this).parent().parent().find('[id*="Description"]').val();
    var amt = $(this).parent().parent().find('[id*="TAX_AMT"]').val();
    var remarks = $(this).parent().parent().find('[id*="REMARKS"]').val();
        $('#hdn_CCID').val(id);
        $('#hdn_CCID2').val(glcode);
        $('#hdn_CCID3').val(glid);
        $('#hdn_CCID4').val(gldesc);
        $('#hdn_CCID5').val(amt);
        $('#hdn_CCID6').val(remarks);

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
                var ccamt = $(this).find('[id*="CC_AMT"]').val();
                var ccrmks = $(this).find('[id*="CC_RMKS"]').val();
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
                $clone.find('[id*="hdnDescription"]').val(gldesc);
                $clone.find('[id*="CCRMKS_"]').val(ccrmks);
                $clone.find('[id*="hdnCCAMT_"]').val(ccamt);
                $clone.find('[id*="hdnCCID_"]').val(ccid);
                $clone.find('[id*="CostCenter_"]').val(cccode);
                $tr.closest('#CostTable2').append($clone);
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
              $(this).find('[id*="hdnDescription"]').val(gldesc);
              $(this).find('[id*="CCRMKS_"]').val(remarks);
          });
        }
        bindCostCenter();
        $("#costpopup").show();
        event.preventDefault();
  });

  $("#costpopup").on('click',"#cc_closePopup",function(event){

        var cc_amt = $('#hdn_CCID5').val();
        var ccamt = 0.00;
        if(cc_amt != '')
        {
          $('#CostTable2').find('.participantRow2').each(function(){
              var ccamt2 = $(this).find('[id*="hdnCCAMT"]').val();
              ccamt = parseFloat(parseFloat(ccamt)+parseFloat(ccamt2)).toFixed(2);
          });
          if(ccamt != 'NaN' && ccamt != '0.00' && ccamt != 0 )
          {
            if (parseFloat(ccamt) != parseFloat(cc_amt))
            {
                  $('[id*="hdnCCAMT"]').val('');
                  $("#FocusId").val($('[id*="hdnCCAMT"]'));
                  $("#ProceedBtn").focus();
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn").hide();
                  $("#OkBtn1").show();
                  $("#AlertMessage").text('Amount must be equal to Taxable Amount entered in Accounting tab.');
                  $("#alert").modal('show');
                  $("#OkBtn1").focus();
                  return false;
            }          
            else
            {
            }
          }
        }       

        $('#CostTable2').find('.participantRow2').each(function(){
            var GLID_REF = $(this).find('[id*="hdnGLID"]').val();
            var CCID_REF = $(this).find('[id*="hdnCCID"]').val();
            var CC_AMT = $(this).find('[id*="hdnCCAMT"]').val();
            var CC_RMKS = $(this).find('[id*="CCRMKS_"]').val();
            var txtid = $('#hdn_CCID').val();
            var CostCenter12= [];
            $('#example5').find('.participantRow5').each(function(){
              if($(this).find('[id*="GLID"]').val() != '')
              {
                var ccitem = $(this).find('[id*="GLID"]').val()+'-'+$(this).find('[id*="CCID"]').val();
                CostCenter12.push(ccitem);
              }
            });

            var costitem = GLID_REF+'-'+CCID_REF;
            if(jQuery.inArray(costitem, CostCenter12) !== -1)
            {
              $('#example5').find('.participantRow5').each(function(){
              if($(this).find('[id*="GLID"]').val() != '')
                {
                  if(costitem == $(this).find('[id*="GLID"]').val()+'-'+$(this).find('[id*="CCID"]').val())
                  {
                    $(this).find('[id*="CC_AMT_"]').val(CC_AMT);
                    $(this).find('[id*="CC_RMKS_"]').val(CC_RMKS);
                  }
                }
              });
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
            else
            {
              if(CC_AMT != 'NaN' && CC_AMT != '')
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
                $clone.find('[id*="CC_AMT_"]').val(CC_AMT);
                $clone.find('[id*="CC_RMKS_"]').val(CC_RMKS);
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
                $('#example5').find('.participantRow5').each(function()
                  {
                    if($(this).find('[id*="GLID"]').val() == '')
                    {
                      $(this).closest("tr").remove();
                    }
                });
              }
            }
        });
        
        $('#CostTable2').off(); 
        $("#costpopup").hide();
        var ccpop = $('#hdnCostCenter2').val();
        $("#costpopup").html(ccpop);
        event.preventDefault();      
      });

    function bindCostCenter(){
      $('#CostTable2').on('focusout','[id*="hdnCCAMT"]',function(event){        
        if($(this).val() != '')
        {
          if(intRegex.test($(this).val())){
            $(this).val($(this).val() +'.00');
          }
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
            url:'{{route("transaction",[235,"getCostCenter"])}}',
            type:'POST',
            data:{'customid':customid,fieldid:fieldid},
            success:function(data) {
              $("#tbody_ppcost").html(data);    
              bindCostCenter2();     
              showSelectedCheck($("#"+fieldid).val(),"SELECT_"+fieldid);                    
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
  if ($("#FC").is(":checked") == true){
          $('#txtCRID_popup').removeAttr('disabled');          
          $('#CONVFACT').prop('readonly',false);
          $('#txtCRID_popup').prop('readonly',true);
      }
      else
      {
        $('#txtCRID_popup').prop('disabled',true);
          $('#txtCRID_popup').val('');
          $('#CRID_REF').val('');
          $('#CONVFACT').val('');
          $('#CONVFACT').prop('readonly',true);
      }
  
  
  var totalamount = 0.00;
    $('#example2').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TT_AMT"]').val() != '')
        {
          var ttamt21 = $(this).find('[id*="TT_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(ttamt21)).toFixed(2);
        }
    });

    $('#example3').find('.participantRow3').each(function()
    {
        if($(this).find('[id*="TOT_TD_AMT"]').val() != '')
        {
          var tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(tttdsamt21)).toFixed(2);
        }
    });
  $('#tot_amt').val(totalamount);
  MultiCurrency_Conversion('tot_amt');  

var Accounting = $("#Accounting").html(); 
$('#hdnAccounting').val(Accounting);
var TDS = $("#TDS").html(); 
$('#hdnTDS').val(TDS);
var CostCenter = $("#CostCenter").html(); 
$('#hdnCostCenter').val(CostCenter);
var CostCenter2 = $("#costpopup").html(); 
$('#hdnCostCenter2').val(CostCenter2);

// var objlastdt = <?php echo json_encode($objlastdt[0]->AP_DOC_DT); ?>;
// var today = new Date(); 
// var ardate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
// $('#AP_DOC_DT').attr('min',objlastdt);
// $('#AP_DOC_DT').attr('max',ardate);
// $('#AP_DOC_DT').val(ardate);

var count1 = <?php echo json_encode($objCount1); ?>;
var count2 = <?php echo json_encode($objCount2); ?>;

var count3 = <?php echo json_encode($objCount3); ?>;
var count4 = <?php echo json_encode($objCount4); ?>;
var apudf = <?php echo json_encode($objUdfAPData); ?>;
if(count2 != "0")
{
  var count2 = <?php echo json_encode($objCountUDF); ?>;
  
}
if(count2 == "0")
  {
    count2 = "1";
  }
$("#Row_Count1").val(count1);
$("#Row_Count2").val(count2);
$("#Row_Count3").val(count3);
$("#Row_Count4").val(count4);
$('#example4').find('.participantRow4').each(function(){
  var txt_id4 = $(this).find('[id*="udfinputid"]').attr('id');
  var udfid = $(this).find('[id*="UDF_APID_REF"]').val();
  $.each( apudf, function( apukey, apuvalue ) {
    if(apuvalue.UDF_APID == udfid)
    {
      var txtvaltype2 =   apuvalue.VALUETYPE;
      var strdyn2 = txt_id4.split('_');
      var lastele2 =   strdyn2[strdyn2.length-1];
      var dynamicid2 = "udfvalue_"+lastele2;
      
      var chkvaltype2 =  txtvaltype2.toLowerCase();
      var strinp2 = '';

      if(chkvaltype2=='date'){
      strinp2 = '<input type="date" placeholder="dd/mm/yyyy" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"  > ';       
      }
      else if(chkvaltype2=='time'){
      strinp2= '<input type="time" placeholder="h:i" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"  > ';
      }
      else if(chkvaltype2=='numeric'){
      strinp2 = '<input type="text" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"   > ';
      }
      else if(chkvaltype2=='text'){
      strinp2 = '<input type="text" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"  > ';          
      }
      else if(chkvaltype2=='boolean'){            
          strinp2 = '<input type="checkbox" name="'+dynamicid2+ '" id="'+dynamicid2+'" class="" > ';
      }
      else if(chkvaltype2=='combobox'){
      var txtoptscombo2 =   apuvalue.DESCRIPTIONS;
      var strarray2 = txtoptscombo2.split(',');
      var opts2 = '';
      for (var i = 0; i < strarray2.length; i++) {
          opts2 = opts2 + '<option value="'+strarray2[i]+'">'+strarray2[i]+'</option> ';
      }
      strinp2 = '<select name="'+dynamicid2+ '" id="'+dynamicid2+'" class="form-control" required>'+opts2+'</select>' ;          
      }
      $('#'+txt_id4).html('');  
      $('#'+txt_id4).html(strinp2);
    }
  });
});

$('#btnAdd').on('click', function() {
  var viewURL = '{{route("transaction",[235,"add"])}}';
              window.location.href=viewURL;
});

$('#btnExit').on('click', function() {
  var viewURL = '{{route('home')}}';
              window.location.href=viewURL;
});


$("#Accounting").on('focusout', "[id*='GL_AMT']", function() 
{
  var totalamount = 0.00;
  if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0')
  {
    if(intRegex.test($(this).val())){
      $(this).val($(this).val() +'.00');
    }
    var tamt = $(this).val();
    if($(this).parent().parent().find("[id*='DISC_PER']").val() != '')
    {
      var dispercnt = $(this).parent().parent().find("[id*='DISC_PER']").val();
      var disamt = 0.00;
      disamt =  parseFloat((parseFloat(tamt)*parseFloat(dispercnt))/100).toFixed(2);
      $(this).parent().parent().find("[id*='DISC_AMT']").val(disamt);
      var netamt = parseFloat(parseFloat(tamt) - parseFloat(disamt)).toFixed(2);
      $(this).parent().parent().find("[id*='TAX_AMT']").val(netamt);
      if($(this).parent().parent().find("[id*='IGST_AMT']").val() != '' &&  $(this).parent().parent().find("[id*='IGST_AMT']").val() != '.00')
      {
        IGST = $(this).parent().parent().find("[id*='IGST_AMT']").val();
        netamt = parseFloat(parseFloat(netamt) + parseFloat(IGST)).toFixed(2);
        $(this).parent().parent().find("[id*='CGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='SGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='CGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='SGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
      else if($(this).parent().parent().find("[id*='CGST_AMT']").val() != '' &&  $(this).parent().parent().find("[id*='CGST_AMT']").val() != '.00')
      {
        CGST = $(this).parent().parent().find("[id*='CGST_AMT']").val();
        SGST = $(this).parent().parent().find("[id*='SGST_AMT']").val();
        netamt = parseFloat(parseFloat(netamt) + parseFloat(CGST) + parseFloat(SGST)).toFixed(2);
        $(this).parent().parent().find("[id*='IGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
      else if($(this).parent().parent().find("[id*='SGST_AMT']").val() != '' &&  $(this).parent().parent().find("[id*='SGST_AMT']").val() != '.00')
      {
        CGST = $(this).parent().parent().find("[id*='CGST_AMT']").val();
        SGST = $(this).parent().parent().find("[id*='SGST_AMT']").val();
        netamt = parseFloat(parseFloat(netamt) + parseFloat(CGST) + parseFloat(SGST)).toFixed(2);
        $(this).parent().parent().find("[id*='IGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
      else
      {
        $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='CGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='SGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
    }
    else
    {
      $(this).parent().parent().find("[id*='DISC_PER']").val('0.0000');
      $(this).parent().parent().find("[id*='DISC_AMT']").val('0.00');
      $(this).parent().parent().find("[id*='TAX_AMT']").val(tamt);
      $(this).parent().parent().find("[id*='CGST_']").val('0.0000');
      $(this).parent().parent().find("[id*='SGST_']").val('0.0000');
      $(this).parent().parent().find("[id*='IGST_']").val('0.0000');
      $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
      $(this).parent().parent().find("[id*='CGST_AMT']").val('0.00');
      $(this).parent().parent().find("[id*='SGST_AMT']").val('0.00');
      $(this).parent().parent().find("[id*='TT_AMT']").val(tamt);
    }
    $('#example2').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TT_AMT"]').val() != '')
        {
          var ttamt21 = $(this).find('[id*="TT_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(ttamt21)).toFixed(2);
        }
    });

    $('#example3').find('.participantRow3').each(function()
    {
        if($(this).find('[id*="TOT_TD_AMT"]').val() != '')
        {
          var tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(tttdsamt21)).toFixed(2);
        }
    });
    $('#tot_amt').val(totalamount);
    MultiCurrency_Conversion('tot_amt');  
  }
  else
  {
      $(this).val('');
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn").hide();
      $("#OkBtn1").show();
      $("#AlertMessage").text('Amount must be greater than Zero.');
      $("#alert").modal('show');
      $("#OkBtn1").focus();
      highlighFocusBtn('activeOk1');
      return false;
  }
});
$("#Accounting").on('focusout', "[id*='DISC_PER']", function() 
{
  var totalamount = 0.00;
  var tamt = $(this).parent().parent().find("[id*='GL_AMT']").val();
  if($(this).val() != '' && $(this).val() != '.0000')
  {
    if(intRegex.test($(this).val())){
      $(this).val($(this).val() +'.0000');
    }
    var dispercnt = $(this).val();
    var disamt = 0.00;
    disamt =  parseFloat((parseFloat(tamt)*parseFloat(dispercnt))/100).toFixed(2);
    $(this).parent().parent().find("[id*='DISC_AMT']").val(disamt);
    var netamt = parseFloat(parseFloat(tamt) - parseFloat(disamt)).toFixed(2);
    $(this).parent().parent().find("[id*='TAX_AMT']").val(netamt);
    if($(this).parent().parent().find("[id*='IGST_AMT']").val() != '')
      {
        IGST = $(this).parent().parent().find("[id*='IGST_AMT']").val();
        netamt = parseFloat(parseFloat(netamt) + parseFloat(IGST)).toFixed(2);
        $(this).parent().parent().find("[id*='CGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='SGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='CGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='SGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
      else if($(this).parent().parent().find("[id*='CGST_AMT']").val() != '')
      {
        CGST = $(this).parent().parent().find("[id*='CGST_AMT']").val();
        SGST = $(this).parent().parent().find("[id*='SGST_AMT']").val();
        netamt = parseFloat(parseFloat(netamt) + parseFloat(CGST) + parseFloat(SGST)).toFixed(2);
        $(this).parent().parent().find("[id*='IGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
      else if($(this).parent().parent().find("[id*='SGST_AMT']").val() != '')
      {
        CGST = $(this).parent().parent().find("[id*='CGST_AMT']").val();
        SGST = $(this).parent().parent().find("[id*='SGST_AMT']").val();
        netamt = parseFloat(parseFloat(netamt) + parseFloat(CGST) + parseFloat(SGST)).toFixed(2);
        $(this).parent().parent().find("[id*='IGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
      else
      {
        $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='CGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='SGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
  }
  else
    {
      $(this).parent().parent().find("[id*='TAX_AMT']").val(tamt);
      $(this).parent().parent().find("[id*='CGST_']").val('0.0000');
      $(this).parent().parent().find("[id*='SGST_']").val('0.0000');
      $(this).parent().parent().find("[id*='IGST_']").val('0.0000');
      $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
      $(this).parent().parent().find("[id*='CGST_AMT']").val('0.00');
      $(this).parent().parent().find("[id*='SGST_AMT']").val('0.00');
      $(this).parent().parent().find("[id*='TT_AMT']").val(tamt);
    }
    $('#example2').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TT_AMT"]').val() != '')
        {
          var ttamt21 = $(this).find('[id*="TT_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(ttamt21)).toFixed(2);
        }
    });

    $('#example3').find('.participantRow3').each(function()
    {
        if($(this).find('[id*="TOT_TD_AMT"]').val() != '')
        {
          var tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(tttdsamt21)).toFixed(2);
        }
    });
    $('#tot_amt').val(totalamount);
    MultiCurrency_Conversion('tot_amt');  
});
$("#Accounting").on('focusout', "[id*='DISC_AMT']", function() 
{
  var totalamount = 0.00;
  var tamt = $(this).parent().parent().find("[id*='GL_AMT']").val();
  if($(this).val() != '' && $(this).val() != '.00')
  {
    if(intRegex.test($(this).val())){
      $(this).val($(this).val() +'.00');
    }
    var disamt = $(this).val();
    var dispercnt = 0.00;
    dispercnt =  parseFloat((parseFloat(disamt)*100)/parseFloat(tamt)).toFixed(4);
    $(this).parent().parent().find("[id*='DISC_PER']").val(dispercnt);
    var netamt = parseFloat(parseFloat(tamt) - parseFloat(disamt)).toFixed(2);
    $(this).parent().parent().find("[id*='TAX_AMT']").val(netamt);
    if($(this).parent().parent().find("[id*='IGST_AMT']").val() != '')
      {
        IGST = $(this).parent().parent().find("[id*='IGST_AMT']").val();
        netamt = parseFloat(parseFloat(netamt) + parseFloat(IGST)).toFixed(2);
        $(this).parent().parent().find("[id*='CGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='SGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='CGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='SGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
      else if($(this).parent().parent().find("[id*='CGST_AMT']").val() != '')
      {
        CGST = $(this).parent().parent().find("[id*='CGST_AMT']").val();
        SGST = $(this).parent().parent().find("[id*='SGST_AMT']").val();
        netamt = parseFloat(parseFloat(netamt) + parseFloat(CGST) + parseFloat(SGST)).toFixed(2);
        $(this).parent().parent().find("[id*='IGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
      else if($(this).parent().parent().find("[id*='SGST_AMT']").val() != '')
      {
        CGST = $(this).parent().parent().find("[id*='CGST_AMT']").val();
        SGST = $(this).parent().parent().find("[id*='SGST_AMT']").val();
        netamt = parseFloat(parseFloat(netamt) + parseFloat(CGST) + parseFloat(SGST)).toFixed(2);
        $(this).parent().parent().find("[id*='IGST_']").val('0.0000');
        $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
      else
      {
        $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='CGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='SGST_AMT']").val('0.00');
        $(this).parent().parent().find("[id*='TT_AMT']").val(netamt);
      }
  }
  else
    {
      $(this).parent().parent().find("[id*='TAX_AMT']").val(tamt);
      $(this).parent().parent().find("[id*='CGST_']").val('0.0000');
      $(this).parent().parent().find("[id*='SGST_']").val('0.0000');
      $(this).parent().parent().find("[id*='IGST_']").val('0.0000');
      $(this).parent().parent().find("[id*='IGST_AMT']").val('0.00');
      $(this).parent().parent().find("[id*='CGST_AMT']").val('0.00');
      $(this).parent().parent().find("[id*='SGST_AMT']").val('0.00');
      $(this).parent().parent().find("[id*='TT_AMT']").val(tamt);
    }
    $('#example2').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TT_AMT"]').val() != '')
        {
          var ttamt21 = $(this).find('[id*="TT_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(ttamt21)).toFixed(2);
        }
    });

    $('#example3').find('.participantRow3').each(function()
    {
        if($(this).find('[id*="TOT_TD_AMT"]').val() != '')
        {
          var tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(tttdsamt21)).toFixed(2);
        }
    });
    $('#tot_amt').val(totalamount);
    MultiCurrency_Conversion('tot_amt');  
});

$("#TDS").on('change',"#drpTDS",function(){
    if($(this).val() == 'Yes')
    {
      var customid = $("#SLID_REF").val();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url:'{{route("transaction",[235,"getTDSDetails"])}}',
              type:'POST',
              data:{'id':customid},
              success:function(data) {
                $("#tbody_tds").html('');
                $("#tbody_tds").html(data);
              },
              error:function(data){
                console.log("Error: Something went wrong.");
                var TDSBody = $('#tbody_tds').html();
                $("#tbody_tds").html(TDSBody);
              },
          });
    }
    else if($(this).val() == 'No')
    {
        var TDSClone = $('#hdnTDS').val();
        $('#TDS').html(TDSClone);
        var count44 = <?php echo json_encode($objCount4); ?>;
        $('#Row_Count4').val(count44);
        $('#example3').find('.participantRow3').each(function(){
          $(this).find('input:text').val('');
          $(this).find('input:hidden').val('');
          $(this).find('input:checkbox').removeAttr('checked');
          var rowcount = $('#Row_Count4').val();
          if(rowcount > 1)
          {
            $(this).closest('.participantRow3').remove();
            rowcount = parseInt(rowcount) - 1;
            $('#Row_Count4').val(rowcount);
          }
        });
        $("#drpTDS").val('No');
    }
    else
    {
        var TDSClone = $('#hdnTDS').val();
        $('#TDS').html(TDSClone);
        var count44 = <?php echo json_encode($objCount4); ?>;
        $('#Row_Count4').val(count44);
        $('#example3').find('.participantRow3').each(function(){
          $(this).find('input:text').val('');
          $(this).find('input:hidden').val('');
          $(this).find('input:checkbox').removeAttr('checked');
          var rowcount = $('#Row_Count4').val();
          if(rowcount > 1)
          {
            $(this).closest('.participantRow3').remove();
            rowcount = parseInt(rowcount) - 1;
            $('#Row_Count4').val(rowcount);
          }
        });
        $("#drpTDS").val('');
    }
});

$("#TDS").on('change', "[id*='TDSApplicable']", function() 
{
  var totalamount = 0.00;
  if($(this).is(':checked') == true)
  {
    var taxamt12 = 0.00;
    $('#example2').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TAX_AMT"]').val() != '')
        {
          var taxamt21 = $(this).find('[id*="TAX_AMT"]').val();
          taxamt12 = parseFloat(parseFloat(taxamt12)+parseFloat(taxamt21)).toFixed(2);
        }
    });
    $(this).parent().parent().find("[id*='ASSESSABLE_VL_']").val(taxamt12);
    var tdsamt = 0.00;
    var tdsrate = $(this).parent().parent().find("[id*='TDS_RATE_']").val();
    var tdsexempt = $(this).parent().parent().find("[id*='TDS_EXEMPT_']").val();
    if (parseFloat(taxamt12) > parseFloat(tdsexempt))
    {
        tdsamt = parseFloat(((parseFloat(taxamt12) - parseFloat(tdsexempt))*parseFloat(tdsrate))/100).toFixed(2);
    }
    else
    {
      tdsamt =  0.00;
    }
    $(this).parent().parent().find("[id*='TDS_AMT_']").val(tdsamt);

    var SURCHARGEamt = 0.00;
    var SURCHARGErate = $(this).parent().parent().find("[id*='SURCHARGE_RATE_']").val();
    var SURCHARGEexempt = $(this).parent().parent().find("[id*='SURCHARGE_EXEMPT_']").val();
    if (parseFloat(taxamt12) > parseFloat(SURCHARGEexempt))
    {
        SURCHARGEamt = parseFloat(((parseFloat(taxamt12) - parseFloat(SURCHARGEexempt))*parseFloat(SURCHARGErate))/100).toFixed(2);
    }
    else
    {
      SURCHARGEamt =  0.00;
    }
    $(this).parent().parent().find("[id*='SURCHARGE_AMT_']").val(SURCHARGEamt);

    var CESSamt = 0.00;
    var CESSrate = $(this).parent().parent().find("[id*='CESS_RATE_']").val();
    var CESSexempt = $(this).parent().parent().find("[id*='CESS_EXEMPT_']").val();
    if (parseFloat(taxamt12) > parseFloat(CESSexempt))
    {
        CESSamt = parseFloat(((parseFloat(taxamt12) - parseFloat(CESSexempt))*parseFloat(CESSrate))/100).toFixed(2);
    }
    else
    {
      CESSamt =  0.00;
    }
    $(this).parent().parent().find("[id*='CESS_AMT_']").val(CESSamt);

    var SPCESSamt = 0.00;
    var SPCESSrate = $(this).parent().parent().find("[id*='SPCESS_RATE_']").val();
    var SPCESSexempt = $(this).parent().parent().find("[id*='SPCESS_EXEMPT_']").val();
    if (parseFloat(taxamt12) > parseFloat(SPCESSexempt))
    {
        SPCESSamt = parseFloat(((parseFloat(taxamt12) - parseFloat(SPCESSexempt))*parseFloat(SPCESSrate))/100).toFixed(2);
    }
    else
    {
      SPCESSamt =  0.00;
    }
    $(this).parent().parent().find("[id*='SPCESS_AMT_']").val(SPCESSamt);

    var totalTDSamt = 0.00;
    totalTDSamt = parseFloat(parseFloat(tdsamt) + parseFloat(SURCHARGEamt) + parseFloat(CESSamt) + parseFloat(SPCESSamt)).toFixed(2);
    $(this).parent().parent().find("[id*='TOT_TD_AMT']").val(totalTDSamt);
  }
  else
  {
    $(this).parent().parent().find("[id*='ASSESSABLE_VL_']").val('0.00');
    $(this).parent().parent().find("[id*='AMT_']").val('0.00');
  }
  $('#example2').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TT_AMT"]').val() != '')
        {
          var ttamt21 = $(this).find('[id*="TT_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(ttamt21)).toFixed(2);
        }
    });

    $('#example3').find('.participantRow3').each(function()
    {
        if($(this).find('[id*="TOT_TD_AMT"]').val() != '')
        {
          var tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(tttdsamt21)).toFixed(2);
        }
    });
    $('#tot_amt').val(totalamount);
    MultiCurrency_Conversion('tot_amt');  
});


$("#TDS").on('focusout', "[id*='ASSESSABLE_VL_']", function() 
{
  var totalamount = 0.00;
    if(intRegex.test($(this).val())){
      $(this).val($(this).val() +'.00');
    }
    var taxamtTDS =  $(this).parent().parent().find("[id*='ASSESSABLE_VL_TDS']").val();
    var tdsamt = 0.00;
    var tdsrate = $(this).parent().parent().find("[id*='TDS_RATE_']").val();
    var tdsexempt = $(this).parent().parent().find("[id*='TDS_EXEMPT_']").val();
    if (parseFloat(taxamtTDS) > parseFloat(tdsexempt))
    {
        tdsamt = parseFloat(((parseFloat(taxamtTDS) - parseFloat(tdsexempt))*parseFloat(tdsrate))/100).toFixed(2);
    }
    else
    {
      tdsamt =  0.00;
    }
    $(this).parent().parent().find("[id*='TDS_AMT_']").val(tdsamt);

    var taxamtSURCHARGE =  $(this).parent().parent().find("[id*='ASSESSABLE_VL_SURCHARGE']").val();
    var SURCHARGEamt = 0.00;
    var SURCHARGErate = $(this).parent().parent().find("[id*='SURCHARGE_RATE_']").val();
    var SURCHARGEexempt = $(this).parent().parent().find("[id*='SURCHARGE_EXEMPT_']").val();
    if (parseFloat(taxamtSURCHARGE) > parseFloat(SURCHARGEexempt))
    {
        SURCHARGEamt = parseFloat(((parseFloat(taxamtSURCHARGE) - parseFloat(SURCHARGEexempt))*parseFloat(SURCHARGErate))/100).toFixed(2);
    }
    else
    {
      SURCHARGEamt =  0.00;
    }
    $(this).parent().parent().find("[id*='SURCHARGE_AMT_']").val(SURCHARGEamt);

    var taxamtCESS =  $(this).parent().parent().find("[id*='ASSESSABLE_VL_CESS']").val();
    var CESSamt = 0.00;
    var CESSrate = $(this).parent().parent().find("[id*='CESS_RATE_']").val();
    var CESSexempt = $(this).parent().parent().find("[id*='CESS_EXEMPT_']").val();
    if (parseFloat(taxamtCESS) > parseFloat(CESSexempt))
    {
        CESSamt = parseFloat(((parseFloat(taxamtCESS) - parseFloat(CESSexempt))*parseFloat(CESSrate))/100).toFixed(2);
    }
    else
    {
      CESSamt =  0.00;
    }
    $(this).parent().parent().find("[id*='CESS_AMT_']").val(CESSamt);

    var taxamtSPCESS =  $(this).parent().parent().find("[id*='ASSESSABLE_VL_SPCESS']").val();
    var SPCESSamt = 0.00;
    var SPCESSrate = $(this).parent().parent().find("[id*='SPCESS_RATE_']").val();
    var SPCESSexempt = $(this).parent().parent().find("[id*='SPCESS_EXEMPT_']").val();
    if (parseFloat(taxamtSPCESS) > parseFloat(SPCESSexempt))
    {
        SPCESSamt = parseFloat(((parseFloat(taxamtSPCESS) - parseFloat(SPCESSexempt))*parseFloat(SPCESSrate))/100).toFixed(2);
    }
    else
    {
      SPCESSamt =  0.00;
    }
    $(this).parent().parent().find("[id*='SPCESS_AMT_']").val(SPCESSamt);

    var totalTDSamt = 0.00;
    totalTDSamt = parseFloat(parseFloat(tdsamt) + parseFloat(SURCHARGEamt) + parseFloat(CESSamt) + parseFloat(SPCESSamt)).toFixed(2);
    $(this).parent().parent().find("[id*='TOT_TD_AMT']").val(totalTDSamt);

    $('#example2').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TT_AMT"]').val() != '')
        {
          var ttamt21 = $(this).find('[id*="TT_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(ttamt21)).toFixed(2);
        }
    });

    $('#example3').find('.participantRow3').each(function()
    {
        if($(this).find('[id*="TOT_TD_AMT"]').val() != '')
        {
          var tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(tttdsamt21)).toFixed(2);
        }
    });
    $('#tot_amt').val(totalamount);
    MultiCurrency_Conversion('tot_amt');  
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

  $clone.find('[id*="hdnCCAMT"]').val('');
  $clone.find('[id*="hdnCCID"]').val('');
  $clone.find('[id*="CostCenter"]').val('');
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
  window.location.href = "{{route('transaction',[235,'add'])}}";
}//fnUndoYes


window.fnUndoNo = function (){
    
}//fnUndoNo

});
</script>

@endpush

@push('bottom-scripts')
<script>

$(document).ready(function() {




    $('#frm_trn_apdcn1').bootstrapValidator({       
        fields: {
            txtlabel: {
                validators: {
                    notEmpty: {
                        message: 'The Document Number is required'
                    }
                }
            },            
        },
        submitHandler: function(validator, form, submitButton) {
            alert( "Handler for .submit() called." );
             event.preventDefault();
             $("#frm_trn_apdcn").submit();
        }
    });
});



$("#btnSave").click(function() {
  var formJournalVoucher = $("#frm_trn_apdcn");
  if(formJournalVoucher.valid()){
 
 $("#FocusId").val('');
 var AP_DOC_NO          =   $.trim($("#AP_DOC_NO").val());
 var AP_DOC_DT          =   $.trim($("#AP_DOC_DT").val());
 var AP_TYPE            =   $.trim($("#AP_TYPE").val());
 var REASON_DRCR_NOTE   =   $.trim($("#REASON_DRCR_NOTE").val());
 var SLID_REF           =   $.trim($("#SLID_REF").val());

 


 if(AP_DOC_NO ===""){
     $("#FocusId").val($("#AP_DOC_NO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please enter value in Document Number.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(AP_DOC_DT ===""){
     $("#FocusId").val($("#AP_DOC_DT"));
     $("#AP_DOC_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Document Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }  
 else if(SLID_REF ===""){
     $("#FocusId").val($("#SLID_REF"));
     $("#SLID_REF").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Vendor.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(AP_TYPE ===""){
     $("#FocusId").val($("#AP_TYPE"));
     $("#AP_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Document Type.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(REASON_DRCR_NOTE ==="" && AP_TYPE !="Invoice"){
     $("#FocusId").val($("#REASON_DRCR_NOTE"));
     $("#REASON_DRCR_NOTE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please enter Reason of Debit/Credit Note.');
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
              var ccamt = 0.00;
              var glamt = 0.00;
              glcode = '';
              var glitem = $(this).find('[id*="GLID_REF"]').val();
              glcode = $(this).find('[id*="txtGLID"]').val()+'-'+$(this).find('[id*="Description"]').val();
              glamt = $(this).find('[id*="TAX_AMT"]').val();
              
              $('#example5').find('.participantRow5').each(function()
              {
                  if($(this).find('[id*="GLID"]').val() != '' && $(this).find('[id*="GLID"]').val() == glitem)
                  {   
                      if($(this).find('[id*="AMT"]').val() != '' && $.trim($(this).find("[id*=AMT]").val())!=".00" && 
                          $.trim($(this).find("[id*=AMT]").val()) > "0") 
                      {
                        ccamt = parseFloat(parseFloat(ccamt) + parseFloat($(this).find('[id*="AMT"]').val())).toFixed(2);        
                      } 
                  }
              });

                if(ccamt != '')
                {
                  if(glamt != ccamt)
                  {
                    $("#FocusId").val($("#tot_amt"));
                    $("#ProceedBtn").focus();
                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn1").show();
                    $("#AlertMessage").text('Amount of Cost Center not match with Amount entered in Accounting tab for '+glcode);
                    $("#alert").modal('show');
                    $("#OkBtn1").focus();
                    highlighFocusBtn('activeOk1');
                    return false;
                  }
                }
            }
            else
            {
                  allblank.push('false');
            }
            if($.trim($(this).find("[id*=GL_AMT]").val())!="" && $.trim($(this).find("[id*=GL_AMT]").val())!=".00" && 
                  $.trim($(this).find("[id*=GL_AMT]").val()) > "0")
            {
                  allblank2.push('true');
            }
            else
            {
                  allblank2.push('false');
            }
        });
    }
        if(jQuery.inArray("false", allblank) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please select GL in Accounting Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank2) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Amount in Accounting Tab must be greater than zero.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
          else if(checkPeriodClosing(235,$("#AP_DOC_DT").val(),0) ==0){
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text(period_closing_msg);
            $("#alert").modal('show');
            $("#OkBtn1").focus();
          }
        // else if(jQuery.inArray("false", allblank3) !== -1){
        //   $("#FocusId").val($("#tot_amt"));
        //   $("#ProceedBtn").focus();
        //   $("#YesBtn").hide();
        //   $("#NoBtn").hide();
        //   $("#OkBtn1").show();
        //   $("#AlertMessage").text('Amount of Cost Center not match with Amount entered in Accounting tab for '+glcode);
        //   $("#alert").modal('show');
        //   $("#OkBtn1").focus();
        //   return false;
        //   }  
        else{
                $("#alert").modal('show');
                $("#AlertMessage").text('Do you want to save to record.');
                $("#YesBtn").data("funcname","fnSaveData");  //set dynamic fucntion name
                $("#YesBtn").focus();
                $("#OkBtn").hide();
                $("#OkBtn1").hide();
                highlighFocusBtn('activeYes');
          }

  }
});

$( "#btnApprove" ).click(function() {
  var formJournalVoucher = $("#frm_trn_apdcn");
  if(formJournalVoucher.valid()){
 
 $("#FocusId").val('');
 var AP_DOC_NO          =   $.trim($("#AP_DOC_NO").val());
 var AP_DOC_DT          =   $.trim($("#AP_DOC_DT").val());
 var AP_TYPE            =   $.trim($("#AP_TYPE").val());
 var REASON_DRCR_NOTE   =   $.trim($("#REASON_DRCR_NOTE").val());
 var SLID_REF           =   $.trim($("#SLID_REF").val());

 

 if(AP_DOC_NO ===""){
     $("#FocusId").val($("#AP_DOC_NO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please enter value in Document Number.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(AP_DOC_DT ===""){
     $("#FocusId").val($("#AP_DOC_DT"));
     $("#AFSDT").val();  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Document Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }     
 else if(SLID_REF ===""){
     $("#FocusId").val($("#SLID_REF"));
     $("#SLID_REF").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Vendor.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(AP_TYPE ===""){
     $("#FocusId").val($("#AP_TYPE"));
     $("#AFSDT").val();  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Document Type.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(REASON_DRCR_NOTE ==="" && AP_TYPE !="Invoice"){
     $("#FocusId").val($("#REASON_DRCR_NOTE"));
     $("#REASON_DRCR_NOTE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please enter Reason of Debit/Credit Note.');
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
              var ccamt = 0.00;
              var glamt = 0.00;
              glcode = '';
              var glitem = $(this).find('[id*="GLID_REF"]').val();
              glcode = $(this).find('[id*="txtGLID"]').val()+'-'+$(this).find('[id*="Description"]').val();
              glamt = $(this).find('[id*="TAX_AMT"]').val();
              
              $('#example5').find('.participantRow5').each(function()
              {
                  if($(this).find('[id*="GLID"]').val() != '' && $(this).find('[id*="GLID"]').val() == glitem)
                  {   
                      if($(this).find('[id*="AMT"]').val() != '' && $.trim($(this).find("[id*=AMT]").val())!=".00" && 
                          $.trim($(this).find("[id*=AMT]").val()) > "0") 
                      {
                        ccamt = parseFloat(parseFloat(ccamt) + parseFloat($(this).find('[id*="AMT"]').val())).toFixed(2);        
                      } 
                  }
              });

                if(ccamt != '')
                {
                  if(glamt != ccamt)
                  {
                    $("#FocusId").val($("#tot_amt"));
                    $("#ProceedBtn").focus();
                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn1").show();
                    $("#AlertMessage").text('Amount of Cost Center not match with Amount entered in Accounting tab for '+glcode);
                    $("#alert").modal('show');
                    $("#OkBtn1").focus();
                    highlighFocusBtn('activeOk1');
                    return false;
                  }
                }
            }
            else
            {
                  allblank.push('false');
            }
            if($.trim($(this).find("[id*=GL_AMT]").val())!="" && $.trim($(this).find("[id*=GL_AMT]").val())!=".00" && 
                  $.trim($(this).find("[id*=GL_AMT]").val()) > "0")
            {
                  allblank2.push('true');
            }
            else
            {
                  allblank2.push('false');
            }
        });
    }
        if(jQuery.inArray("false", allblank) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please select GL in Accounting Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank2) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please enter Amount in Accounting Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          } 
          else if(checkPeriodClosing(235,$("#AP_DOC_DT").val(),0) ==0){
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text(period_closing_msg);
            $("#alert").modal('show');
            $("#OkBtn1").focus();
          }
        // else if(jQuery.inArray("false", allblank3) !== -1){
        //   $("#FocusId").val($("#tot_amt"));
        //   $("#ProceedBtn").focus();
        //   $("#YesBtn").hide();
        //   $("#NoBtn").hide();
        //   $("#OkBtn1").show();
        //   $("#AlertMessage").text('Amount of Cost Center not match with Amount entered in Accounting tab for '+glcode);
        //   $("#alert").modal('show');
        //   $("#OkBtn1").focus();
        //   return false;
        //   } 
        else{
                $("#alert").modal('show');
                $("#AlertMessage").text('Do you want to approve to record.');
                $("#YesBtn").data("funcname","fnApproveData");  //set dynamic fucntion name
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



window.fnSaveData = function (){

//validate and save data
event.preventDefault();

     var trnseForm = $("#frm_trn_apdcn");
    var formData = trnseForm.serialize();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$("#btnSave").hide(); 
$(".buttonload").show(); 
$("#btnApprove").prop("disabled", true);
$.ajax({
    url:'{{ route("transaction",[235,"update"])}}',
    type:'POST',
    data:formData,
    success:function(data) {
      $(".buttonload").hide(); 
      $("#btnSave").show();   
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
      $("#btnSave").show();   
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

//validate and save data
event.preventDefault();

     var trnseForm = $("#frm_trn_apdcn");
    var formData = trnseForm.serialize();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$("#btnApprove").hide(); 
$(".buttonload_approve").show();  
$("#btnSave").prop("disabled", true);
$.ajax({
    url:'{{ route("transaction",[235,"Approve"])}}',
    type:'POST',
    data:formData,
    success:function(data) {
      $("#btnApprove").show();  
      $(".buttonload_approve").hide();  
      $("#btnSave").prop("disabled", false);
       
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
        $("#btnSave").prop("disabled", false);
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
    window.location.href = '{{route("transaction",[235,"index"]) }}';
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

function getBalance(bankid,fieldid,fieldidshow){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var TaxStatus = $.ajax({type: 'POST',
  url:'{{route("transaction",[235,"getBalance"])}}',
  async: false,
  dataType: 'json',
  data: {id:bankid},
  done: function(response) {return response;}}).responseText;
  var TaxStatus=parseFloat(TaxStatus).toFixed(2);
  if(TaxStatus == '' || TaxStatus==0){
  $("#"+fieldid).text('Balance 0.00');
  $("#"+fieldidshow).text('Balance 0.00');
}
else if(TaxStatus > 0 ){
  $("#"+fieldid).text('Balance '+TaxStatus);
  $("#"+fieldidshow).text('Balance '+Math.abs(TaxStatus).toFixed(2)+' Dr');
}else if(TaxStatus < 0 ){
  $("#"+fieldid).text('Balance '+TaxStatus);
  $("#"+fieldidshow).text('Balance '+Math.abs(TaxStatus).toFixed(2)+' Cr');
}
}


function getBalanceGrid(bankid,fieldid){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var TaxStatus = $.ajax({type: 'POST',
  url:'{{route("transaction",[235,"getBalanceGrid"])}}',
  async: false,
  dataType: 'json',
  data: {id:bankid},
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

$(document).ready(function(){
  var lastdt = <?php echo json_encode($objlastdt[0]->AP_DOC_DT); ?>;
  var apdoc = <?php echo json_encode($objAPDRCR); ?>;
  var today = new Date(); 
  var sodate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2);
  if(lastdt < apdoc.AP_DOC_DT)
  {
	$('#AP_DOC_DT').attr('min',lastdt);
  }
  else
  {
	  $('#AP_DOC_DT').attr('min',apdoc.AP_DOC_DT);
  }
  $('#AP_DOC_DT').attr('max',sodate);
});



		
	 //Currency Dropdown
   let crtid = "#CurrencyTable2";
      let crtid2 = "#CurrencyTable";
      let currencyheaders = document.querySelectorAll(crtid2 + " th");

      // Sort the table element when clicking on the table headers
      currencyheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(crtid, ".clscrid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function CurrencyCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("currencycodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("CurrencyTable2");
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

  function CurrencyNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("currencynamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("CurrencyTable2");
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

  $('#txtCRID_popup').click(function(event){
    showSelectedCheck($("#CRID_REF").val(),"SELECT_CRID");
         $("#cridpopup").show();
      });

      $("#crid_closePopup").click(function(event){
        $("#cridpopup").hide();
      });

      $(".clscrid").click(function(){
        var fieldid = $(this).attr('id');
        var txtval =    $("#txt"+fieldid+"").val();
        var texdesc =   $("#txt"+fieldid+"").data("desc")+'-'+$("#txt"+fieldid+"").data("desc2");      
        
        $('#txtCRID_popup').val(texdesc);    
        $('#CRID_REF').val(txtval);
        $("#cridpopup").hide();
        $('#CONVFACT').val(GetConvFector(txtval));
        $("#currencycodesearch").val(''); 
        $("#currencynamesearch").val(''); 
        MultiCurrency_Conversion('tot_amt');  
        event.preventDefault();
      });

      

  //Currency Dropdown Ends		


  $("#FC").change(function() {
      if ($(this).is(":checked") == true){
          $(this).parent().parent().find('#txtCRID_popup').removeAttr('disabled');
          $(this).parent().parent().find('#txtCRID_popup').prop('readonly','true');
          $('#CONVFACT').prop('readonly',false);
         
      }
      else
      {
          $(this).parent().parent().find('#txtCRID_popup').prop('disabled','true');
          $(this).parent().parent().find('#txtCRID_popup').removeAttr('readonly');
          $(this).parent().parent().find('#txtCRID_popup').val('');
          $(this).parent().parent().find('#CRID_REF').val('');
          $(this).parent().parent().find('#CONVFACT').val('');
          $('#CONVFACT').prop('readonly',true);
         
      }
	  MultiCurrency_Conversion('tot_amt');  
  });


  function sourceType(value){    
    
    var CommonValue = $('#SOURCE_TYPE').val();
    if(CommonValue=='Vendor'){
      $('#titalName').html('Vendor');
      $('#txtvendor').val('');
      $('#SLID_REF').val('');
      $('#Tax_State').val('');
      $('#tot_amt').val('0.00');
      resetTab();
    }else{
      $('#titalName').html('Employee');
      $('#txtvendor').val('');
      $('#SLID_REF').val('');
      $('#Tax_State').val('');
      $('#tot_amt').val('0.00');
      resetTab();      
    }
  }

  
function resetTab(){

$('#example2').find('.participantRow').each(function(){
  var rowcount = $(this).closest('table').find('.participantRow').length;
  $(this).find('input:text').val('');
  $(this).find('input:hidden').val('');
  $(this).find('input:checkbox').prop('checked', false);

  if(rowcount > 1){
    $(this).closest('.participantRow').remove();
    rowcount = parseInt(rowcount) - 1;
    $('#Row_Count1').val(rowcount);
  }
});

$('#example3').find('.participantRow3').each(function(){
  var rowcount = $(this).closest('table').find('.participantRow3').length;
  $(this).find('input:text').val('');
  $(this).find('input:checkbox').prop('checked',false);      
  if(rowcount > 1)
  {
    $(this).closest('.participantRow3').remove();
    rowcount = parseInt(rowcount) - 1;
    $('#Row_Count4').val(rowcount);
  }
});

$('#drpTDS').val('No');

}	

$(document).ready(function(){
  var CommonValue = $('#SOURCE_TYPE').val();
    if(CommonValue=='Vendor'){
      $('#titalName').html('Vendor');
    }else{
      $('#titalName').html('Employee');
    }
});






//--------------------Adjustment Popup Section Starts here-----------------------------------------
let strtid = "#adjustmentTable";
      let strheaders = document.querySelectorAll(strtid + " th");

      // Sort the table element when clicking on the table headers
      strheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(strtid, ".clsstrid", "td:nth-child(" + (i + 1) + ")");
        });
      });




  function GetAdjustment(id){  
    var sourcetype = $('#SOURCE_TYPE').find(":selected").text();
    if(sourcetype !="Employee"){
      return false;
    }


  var RawID               =   id.split('_').pop();
  var EMPID_REF           =   $.trim($("#SLID_REF").val());
  var GLID_REF            =   $.trim($("#GLID_REF_"+RawID).val());
  var GL_AMT              =   $.trim($("#GL_AMT_"+RawID).val());
  var PAYMENTID_REF       =   $.trim($("#PAYMENTID_REF_"+RawID).val());
  var ADJUSTMENT_AMOUNT   =   $.trim($("#ADJUSTMENT_AMOUNT_"+RawID).val());
  var MAINUOMID_REF       =   $("#MAINUOMID_REF_"+RawID).val();
  var ALTUOMID_REF        =   $("#ALTUOMID_REF_"+RawID).val();
  var APDRCRID 			  =   $.trim($("#APDRCRID").val());

  
  if(EMPID_REF ===""){
  $("#FocusId").val('txtvendor');
  $("#ProceedBtn").focus();
  $("#YesBtn").hide();
  $("#NoBtn").hide();
  $("#OkBtn1").show();
  $("#AlertMessage").text('Please select employee.');
  $("#alert").modal('show');
  $("#OkBtn1").focus();
  return false;
  }
  else if(GLID_REF ===""){
  $("#FocusId").val('txtGLID_'+RawID);
  $("#ProceedBtn").focus();
  $("#YesBtn").hide();
  $("#NoBtn").hide();
  $("#OkBtn1").show();
  $("#AlertMessage").text('Please select GL Code.');
  $("#alert").modal('show');
  $("#OkBtn1").focus();
  return false;
}else if(GL_AMT ===""){
  $("#FocusId").val('GL_AMT_'+RawID);
  $("#ProceedBtn").focus();
  $("#YesBtn").hide();
  $("#NoBtn").hide();
  $("#OkBtn1").show();
  $("#AlertMessage").text('Please enter amount in material tab.');
  $("#alert").modal('show');
  $("#OkBtn1").focus();
  return false;
}
else if(GLID_REF ===""){
  $("#FocusId").val('txtGLID_'+RawID);
  $("#ProceedBtn").focus();
  $("#YesBtn").hide();
  $("#NoBtn").hide();
  $("#OkBtn1").show();
  $("#AlertMessage").text('Please select GL Code.');
  $("#alert").modal('show');
  $("#OkBtn1").focus();
  return false;
}
else{
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    })
    $("#Data_seach_adjustment").show();
    $('#tbody_adjustment').html('');

   $.ajax({
                url:'{{route("transaction",[$FormId,"GetAdjData"])}}',
                type:'POST',
                data:{EMPID_REF:EMPID_REF,PAYMENTID_REF:PAYMENTID_REF,ADJUSTMENT_AMOUNT:ADJUSTMENT_AMOUNT,ACTION_TYPE:'EDIT',RawID:RawID,APDRCRID:APDRCRID},
              
                success:function(data) {
                  $("#Data_seach_adjustment").hide();
                    $('#tbody_adjustment').html(data);
  
                    bindAdjustmentEvents();                   
                    event.preventDefault();  
                   },
                error:function(data){
                  $("#Data_seach_adjustment").hide();
                  console.log("Error: Something went wrong.");
                  $('#tbody_adjustment').html('');
                  bindAdjustmentEvents();
                  event.preventDefault();               
                },
            });  
        }
        $("#Adjustmentpopup").show();
      }


$("#AdjustmentclosePopup").click(function(event){  
var PAYMENTID_REF       = [];
var AMOUNT              = [];
var RawID               = '';

  $('#adjustmentTable').find('.clsstrid').each(function(){
     RawID              =   $("#RawID").val();
    if($(this).find('[id*="Adj_Amount"]').val() != '')
  {
    var PAYMENTID       =     $(this).find('[id*="adj_Docid"]').val();
                              PAYMENTID_REF.push(PAYMENTID);
    var A_AMOUNT        =     $(this).find('[id*="Adj_Amount"]').val();
                              AMOUNT.push(parseFloat(A_AMOUNT));  

  } 
});  

  $("#PAYMENTID_REF_"+RawID).val(PAYMENTID_REF);
  $("#ADJUSTMENT_AMOUNT_"+RawID).val(AMOUNT);
  $("#Adjustmentpopup").hide();  


  var TotalValue= getArraySum(AMOUNT); 
if(intRegex.test(TotalValue)){
  TotalValue = (TotalValue +'.000');
}

    if(parseFloat($.trim($("#GL_AMT_"+RawID).val())) != "" && parseFloat($.trim($("#GL_AMT_"+RawID).val())) < parseFloat($.trim(TotalValue)) ){
      $("#Adjustmentpopup").hide();
      $("#ProceedBtn").focus();
      $("#YesBtn").hide();
      $("#PAYMENTID_REF_"+RawID).val('');
      $("#ADJUSTMENT_AMOUNT_"+RawID).val('');
      $("#NoBtn").hide();
      $("#OkBtn").hide();
      $("#OkBtn1").show();
      $("#AlertMessage").text('Adjustment Amount cannot be greater than Amount in Material Tab.');
      $("#alert").modal('show');
      $("#OkBtn1").focus();
      return false;
  }
});

      



		
	function bindAdjustmentEvents(){
		
        $('#adjustmentTable').on('keyup','[id*="Adj_Amount"]',function(event){
			
			var adjvalue 		=	$(this).val();
			var balanceamount 	= 	$(this).parent().parent().find('[id*="adj_Paymentamount"]').val();
			
			if(parseFloat(adjvalue) > parseFloat(balanceamount)){
     $(this).val('');
     $("#FocusId").val($(this));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Adjustment Amount can not be greater than Balance Amount.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
			}
			// else{
			//   var mqty = $(this).parent().parent().find('[id*="CONV_MAIN_QTY"]').val();
			//   var aqty = $(this).parent().parent().find('[id*="CONV_ALT_QTY"]').val();
			//   var daltqty = parseFloat((dqty * aqty)/mqty).toFixed(3);
			//   $(this).parent().parent().find('[id*="DISPATCH_ALT_QTY"]').val(daltqty);
      //  // getTotalRowValue(); 
			// }
			
        });
    }


    function getArraySum(a){
          var total=0;
          for(var i in a) { 
              total += a[i];
          }
          return total;
      }
	  

// Adjustment Popup Ends


function isNumberDecimalKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

    return true;
}
</script>


@endpush