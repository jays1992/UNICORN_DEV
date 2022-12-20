
@extends('layouts.app')
@section('content')
    

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="{{route('transaction',[$FormId,'index'])}}" class="btn singlebt">Purchase Invoice / Bill</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSave" ><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo"  ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" {{ (isset($objRights->APPROVAL1) || isset($objRights->APPROVAL2) || isset($objRights->APPROVAL3) || isset($objRights->APPROVAL4) || isset($objRights->APPROVAL5)) &&  ($objRights->APPROVAL1||$objRights->APPROVAL2||$objRights->APPROVAL3||$objRights->APPROVAL4||$objRights->APPROVAL5) == 1 ? '' : 'disabled'}} ><i class="fa fa-lock"></i>  Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div><!--row-->
    </div>

<div class="container-fluid filter">
    <form id="frm_trn_pbi"  method="POST"> 
      @csrf
      {{isset($objPBHDR->PBID[0]) ? method_field('PUT') : '' }}
	<div class="inner-form">
	
		<div class="row">
        <div class="col-lg-1 pl"><p>PB Doc No</p></div>
        <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="PB_DOCNO" id="PB_DOCNO" value="{{ isset($objPBHDR->PB_DOCNO)?$objPBHDR->PB_DOCNO:'' }}" class="form-control mandatory" maxlength="30" autocomplete="off" readonly style="text-transform:uppercase"  >
        </div>
        <div class="col-lg-1 pl"><p>PB Doc Date</p></div>
        <div class="col-lg-2 pl">
                  <input {{$ActionStatus}} type="date" name="PB_DOCDT" id="PB_DOCDT" value="{{ isset($objPBHDR->PB_DOCDT)?$objPBHDR->PB_DOCDT:'' }}" class="form-control mandatory"  placeholder="dd/mm/yyyy" />
        </div>
        <div class="col-lg-1 pl"><p>Department</p></div>
        <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="txtdepartment" id="txtdepartment" class="form-control" value="{{ isset($objPBDEP->DCODE)?$objPBDEP->DCODE:'' }} {{ isset($objPBDEP->NAME)?'-'.$objPBDEP->NAME:'' }}"  readonly  />
                <input type="hidden" name="DEPID_REF" id="DEPID_REF" value="{{ isset($objPBHDR->DEPID_REF)?$objPBHDR->DEPID_REF:'' }}"  class="form-control " />
        </div>
        <div class="col-lg-1 pl"><p>Vendor</p></div>
        <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="txtvendor" id="txtvendor" class="form-control" value="{{ isset($objPBVID->VCODE)?$objPBVID->VCODE:'' }} {{ isset($objPBVID->NAME)?'-'.$objPBVID->NAME:'' }}" readonly  />
                <input type="hidden" name="VID_REF" id="VID_REF"  class="form-control" value="{{ isset($objPBHDR->VID_REF)?$objPBHDR->VID_REF:'' }}" />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1 pl"><p> Vendor Invoice No</p></div> 
        <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="VENDOR_INNO" id="VENDOR_INNO" value="{{ isset($objPBHDR->VENDOR_INNO)?$objPBHDR->VENDOR_INNO:'' }}" maxlength="30" class="form-control" autocomplete="off" readonly />
        </div>
        <div class="col-lg-1 pl"><p> Date</p></div>
        <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="date" name="VENDOR_INDT" id="VENDOR_INDT" value="{{ isset($objPBHDR->VENDOR_INDT)?$objPBHDR->VENDOR_INDT:'' }}" class="form-control"  placeholder="dd/mm/yyyy" readonly  />
        </div>
        <div class="col-lg-1 pl"><p>Bill To </p></div>
        <div class="col-lg-2 pl" id="div_billto">
            <input {{$ActionStatus}}  type="text" name="txtBILLTO" id="txtBILLTO" class="form-control"  autocomplete="off" value="{{ isset($objBillAddress[0])?$objBillAddress[0]:'' }}" readonly  />
            <input type="hidden" name="BILLTO" id="BILLTO" class="form-control" autocomplete="off" value="{{ isset($objPBHDR->BILL_TO)?$objPBHDR->BILL_TO:'' }}" />
        </div>
        
        <div class="col-lg-1 pl"><p>Ship To</p></div>
        <div class="col-lg-2 pl" id="div_shipto">
            <input {{$ActionStatus}} type="text" name="txtSHIPTO" id="txtSHIPTO" class="form-control"  autocomplete="off" value="{{ isset($objShpAddress[0])?$objShpAddress[0]:'' }}"  readonly  />
            <input type="hidden" name="SHIPTO" id="SHIPTO" class="form-control" autocomplete="off" value="{{ isset($objPBHDR->SHIP_TO)?$objPBHDR->SHIP_TO:'' }}" />
            <input type="hidden" name="Tax_State" id="Tax_State" class="form-control" value="{{ isset($TAXSTATE[0])?$TAXSTATE[0]:'' }}" autocomplete="off" />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1 pl"><p>Remarks</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="text" name="REMARKS" id="REMARKS" autocomplete="off" class="form-control" value="{{ isset($objPBHDR->REMARKS)?$objPBHDR->REMARKS:'' }}" maxlength="200"  >
        </div>
        <div class="col-lg-1 pl"><p>Credit Days</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="text" name="Credit_days" id="Credit_days" maxlength="200" class="form-control" value="{{ isset($objPBHDR->CREDIT_DAYS)?$objPBHDR->CREDIT_DAYS:'' }}"  autocomplete="off"   />
        </div>
        <div class="col-lg-1 pl"><p>Due Date</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="date" name="DUE_DATE" id="DUE_DATE" class="form-control" value="{{ isset($objPBHDR->DUE_DATE)?$objPBHDR->DUE_DATE:'' }}"  placeholder="dd/mm/yyyy"  />                        
        </div>
        <div class="col-lg-1 pl"><p>Reverse GST</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="checkbox" name="GST_Reverse" id="GST_Reverse" {{ isset($objPBHDR->REVERSE_GST) && $objPBHDR->REVERSE_GST == 1 ? 'checked' : ''}}   />                          
        </div>
    </div>
    <div class="row">	
        <div class="col-lg-1 pl"><p>GST Input Not Avail</p></div>
        <div class="col-lg-2 pl">
            <input  {{$ActionStatus}} type="checkbox" name="GST_N_Avail" id="GST_N_Avail"  {{ isset($objPBHDR->GST_INPUT) && $objPBHDR->GST_INPUT == 1 ? 'checked' : ''}}   />
        </div>                          
        <div class="col-lg-1 pl"><p>Total Amount</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="text" name="tot_amt" id="tot_amt" class="form-control"  autocomplete="off" readonly  />
        </div>

        <div class="col-lg-2 pl ExceptionalGST" style="display:none;" ><p>Exemptional for GST</p></div>
        <div  class="col-lg-2 pl ExceptionalGST" style="display:none;">
          <input {{$ActionStatus}} type="checkbox" name="EXE_GST" id="EXE_GST" class="filter-none"  value="1" onchange="getExceptionalGst()" > 
        </div>

    </div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#Material">Material</a></li> 
        <li><a data-toggle="tab" href="#TC">T&C</a></li> 
        <li><a data-toggle="tab" href="#CT">Calculation Template</a></li>
        <li><a data-toggle="tab" href="#PaymentSlabs">Payment Slabs</a></li>                
        <li><a data-toggle="tab" href="#TDS">TDS</a></li> 
        <li><a data-toggle="tab" href="#udf">UDF</a></li>
        <li><a data-toggle="tab" href="#ADDITIONAL" id="ADDITIONAL_TAB">Additional Info</a></li>
			</ul>
      <div class="tab-content">
        <div id="Material" class="tab-pane fade in active">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:400px;margin-top:10px;" >
                <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                          <tr>
                              <th width="8%">GRN No<input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1" value="{{$objCount1}}" /></th>
                              <th width="15%">Item Code</th>
                              <th width="8%">Item Name</th>
                              <th width="5%">Main UOM</th>
                              <th width="5%">Received Qty</th>
                              <th width="5%">Alt UOM</th>
                              <th width="5%">Received Qty</th>
                              <th width="5%">Bill Qty (MU)</th>
                              <th width="5%">UOM of Bill Qty</th>
                              <th width="5%">Item Specifications</th>
                              <th width="5%">Rate as per MU</th>
                              <th width="5%">Discount %</th>
                              <th width="5%">Discount Amount</th>
                              <th width="8%">Amount after discount</th>
                              <th width="5%">IGST</th>
                              <th width="5%">IGST Amount</th>
                              <th width="5%">CGST</th>
                              <th width="5%">CGST Amount</th>
                              <th width="5%">SGST</th>
                              <th width="5%">SGST Amount</th>
                              <th width="8%">Total GST Amount</th>
                              <th width="8%">Total after GST</th>                           
                              <th width="5%">Action</th>
                          </tr>
                    </thead>
                    <tbody>
                    @if(!empty($objPBMAT))
                      @foreach($objPBMAT as $key => $row)
                          <tr  class="participantRow">
                              <td style="text-align:center;" >
                              <input {{$ActionStatus}} type="text" name={{"txtGRN_NO_".$key}} id={{"txtGRN_NO_".$key}} class="form-control" value="{{$row->GRN}}"  autocomplete="off"  readonly style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"GRN_ID_".$key}} id={{"GRN_ID_".$key}} class="form-control" value="{{$row->GRN_NO}}" autocomplete="off" style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"GEID_REF_".$key}} id={{"GEID_REF_".$key}} class="form-control" value="{{$row->GEID_REF}}" autocomplete="off" style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"POID_REF_".$key}} id={{"POID_REF_".$key}} class="form-control" value="{{$row->POID_REF}}" autocomplete="off" style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"IPOID_REF_".$key}} id={{"IPOID_REF_".$key}} class="form-control" value="{{$row->IPOID_REF}}" autocomplete="off" style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"VQID_REF_".$key}} id={{"VQID_REF_".$key}} class="form-control" value="{{$row->VQID_REF}}" autocomplete="off" style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"RFQID_REF_".$key}} id={{"RFQID_REF_".$key}} class="form-control" value="{{$row->RFQID_REF}}" autocomplete="off" style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"PIID_REF_".$key}} id={{"PIID_REF_".$key}} class="form-control" value="{{$row->PIID_REF}}" autocomplete="off" style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"MRSID_REF_".$key}} id={{"MRSID_REF_".$key}} class="form-control" value="{{$row->MRSID_REF}}" autocomplete="off" style="width:130px;" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"txtItem_".$key}} id={{"txtItem_".$key}} class="form-control" value="{{$row->ICODE}}" autocomplete="off" readonly style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"ITEMID_REF_".$key}} id={{"ITEMID_REF_".$key}} class="form-control" value="{{$row->ITEMID_REF}}" autocomplete="off" style="width:130px;" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"ItemName_".$key}} id={{"ItemName_".$key}} class="form-control"  value="{{$row->ITEMNAME}}" autocomplete="off"  readonly style="width:130px;"/></td>
                              <td><input {{$ActionStatus}} type="text" name={{"txtUOM_".$key}} id={{"txtUOM_".$key}} class="form-control" maxlength="15" value="{{$row->MAINUOM}}" autocomplete="off"  readonly style="width:130px;"/></td>
                              <td hidden><input type="hidden" name={{"UOMID_REF_".$key}} id={{"UOMID_REF_".$key}} class="form-control" value="{{$row->UOMID_REF}}" autocomplete="off" style="width:130px;" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"RECEIVED_QTY_".$key}} id={{"RECEIVED_QTY_".$key}} class="form-control three-digits" value="{{$row->RECEIVED_QTY}}" maxlength="15"  autocomplete="off" readonly style="width:130px;text-align:right;" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"txtALTUOM_".$key}} id={{"txtALTUOM_".$key}} class="form-control" maxlength="15" value="{{$row->ALTUOM}}" autocomplete="off"  readonly style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"ALT_UOMID_REF_".$key}} id={{"ALT_UOMID_REF_".$key}} class="form-control" value="{{$row->ALT_UOMID_REF}}" autocomplete="off" style="width:130px;"  /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"RECEIVED_ALT_QTY_".$key}} id={{"RECEIVED_ALT_QTY_".$key}} class="form-control three-digits" value="{{$row->ALTQTY}}" maxlength="15"  autocomplete="off" readonly style="width:130px;text-align:right;" /></td>
                              <td><input {{$ActionStatus}} {{$AlpsStatus['readonly']}} type="text" name={{"BILL_QTY_".$key}} id={{"BILL_QTY_".$key}} class="form-control three-digits" maxlength="15" value="{{$row->BILL_QTY}}"  autocomplete="off" style="width:130px;text-align:right;" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"txtBILLUOM_".$key}} id={{"txtBILLUOM_".$key}} class="form-control" maxlength="15" value="{{$row->BILLUOM}}" autocomplete="off"  readonly style="width:130px;" /></td>
                              <td hidden><input type="hidden" name={{"BILL_UOMID_REF_".$key}} id={{"BILL_UOMID_REF_".$key}} class="form-control" value="{{$row->BILL_UOMID_REF}}" autocomplete="off" style="width:130px;text-align:right;" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"ItemDesc_".$key}} id={{"ItemDesc_".$key}} class="form-control" value="{{$row->ITEM_SEPECIFICATION}}" autocomplete="off" style="width:130px;text-align:right;"  /></td>
                              <td><input {{$ActionStatus}} {{$AlpsStatus['readonly']}} type="text" name={{"BILL_RATEPUOM_".$key}} id={{"BILL_RATEPUOM_".$key}} class="form-control five-digits blurRate" value="{{$row->BILL_RATEPUOM}}" maxlength="13"  autocomplete="off" style="width:130px;text-align:right;"  /></td>
                              <td><input {{$ActionStatus}} {{$AlpsStatus['disabled']}} type="text" name={{"DISC_PER_".$key}} id={{"DISC_PER_".$key}} class="form-control four-digits" maxlength="12" value="{{$row->DISCOUNT}}" autocomplete="off" style="width:130px;text-align:right;"  /></td>
                              <td><input {{$ActionStatus}} {{$AlpsStatus['disabled']}} type="text" name={{"DISC_AMT_".$key}} id={{"DISC_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$row->DISC_AMT}}" autocomplete="off" style="width:130px;text-align:right;"  /></td>
                      @php
                          $TaxAmt=number_format((($row->BILL_QTY*$row->BILL_RATEPUOM) - $row->DISC_AMT),2, '.', '');
                      @endphp
                              <td><input {{$ActionStatus}} type="text" name={{"TAX_AMT_".$key}} id={{"TAX_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$TaxAmt}}" autocomplete="off" readonly style="width:130px;text-align:right;" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"IGST_".$key}} id={{"IGST_".$key}} class="form-control four-digits" maxlength="12" value="{{$row->IGST}}" autocomplete="off"  readonly style="width:130px;text-align:right;" onkeyup="taxGstCalculation(this.id,this.value)" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"IGST_AMT_".$key}} id={{"IGST_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$row->IGSTAMT}}"  autocomplete="off" readonly style="width:130px;text-align:right;" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"CGST_".$key}} id={{"CGST_".$key}} class="form-control four-digits" maxlength="12" value="{{$row->CGST}}" autocomplete="off"  readonly style="width:130px;text-align:right;" onkeyup="taxGstCalculation(this.id,this.value)" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"CGST_AMT_".$key}} id={{"CGST_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$row->CGSTAMT}}" autocomplete="off" readonly style="width:130px;text-align:right;" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"SGST_".$key}} id={{"SGST_".$key}} class="form-control four-digits" maxlength="12" value="{{$row->SGST}}"  autocomplete="off"  readonly style="width:130px;text-align:right;" onkeyup="taxGstCalculation(this.id,this.value)" /></td>
                              <td><input {{$ActionStatus}} type="text" name={{"SGST_AMT_".$key}} id={{"SGST_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$row->SGSTAMT}}" autocomplete="off" readonly style="width:130px;text-align:right;" /></td>
                      @php
                          $TOTGST=number_format(($row->IGSTAMT+$row->CGSTAMT+$row->SGSTAMT),2, '.', '');
                      @endphp
                              <td><input {{$ActionStatus}} type="text" name={{"TGST_AMT_".$key}} id={{"TGST_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$TOTGST}}" autocomplete="off" readonly style="width:130px;text-align:right;" /></td>
                      @php
                          $TOTAL=number_format(((($row->BILL_QTY*$row->BILL_RATEPUOM) - $row->DISC_AMT)+($row->IGSTAMT+$row->CGSTAMT+$row->SGSTAMT)),2, '.', '');
                      @endphp
                              <td><input {{$ActionStatus}} type="text" name={{"TT_AMT_".$key}} id={{"TT_AMT_".$key}} class="form-control two-digits" maxlength="15" value="{{$TOTAL}}" autocomplete="off" readonly style="width:130px;text-align:right;" /></td>
                              <td align="center" >
                                <button {{$ActionStatus}} class="btn add material" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                                <button {{$ActionStatus}} class="btn remove dmaterial" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                              </td>
                          </tr>
                          <tr></tr>
                      @endforeach 
                    @endif
                    </tbody>

                    <tr  class="participantRowFotter">
                      <td colspan="4" style="text-align:center;font-weight:bold;">TOTAL</td> 
                      <td id="RECEIVED_QTY_total"     style="text-align:right;font-weight:bold;"></td>
                      <td></td>
                      <td id="RECEIVED_ALT_QTY_total" style="text-align:right;font-weight:bold;"></td>
                      <td id="BILL_QTY_total"         style="text-align:right;font-weight:bold;"></td>
                      <td></td>
                      <td></td>
                      <td id="BILL_RATEPUOM_total"    style="text-align:right;font-weight:bold;"></td>
                      <td></td>
                      <td id="DISC_AMT_total"         style="text-align:right;font-weight:bold;"></td>
                      <td id="TAX_AMT_total"          style="text-align:right;font-weight:bold;"></td>
                      <td></td>
                      <td id="IGST_AMT_total"          style="text-align:right;font-weight:bold;"></td>
                      <td></td>
                      <td id="CGST_AMT_total"        style="text-align:right;font-weight:bold;"></td>
                      <td></td>
                      <td id="SGST_AMT_total"        style="text-align:right;font-weight:bold;"></td>
                      <td id="TGST_AMT_total"       style="text-align:right;font-weight:bold;"></td>
                      <td id="TT_AMT_total"        style="text-align:right;font-weight:bold;"></td>
                      <td></td>                                    
                    </tr>


                </table>
            </div>	
        </div> 
        <div id="TC" class="tab-pane fade">
            <div class="row" style="margin-top:10px;margin-left:3px;" >	
                <div class="col-lg-1 pl"><p>T&C Template</p></div>
                <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="txtTNCID_popup" id="txtTNCID_popup" class="form-control"  autocomplete="off"  readonly/>
                @if(!empty($objPBTNC))
                    <input type="hidden" name="TNCID_REF" id="TNCID_REF" class="form-control" value="{{$objPBTNC[0]->TNCID_REF}}" autocomplete="off" />
                @else
                    <input type="hidden" name="TNCID_REF" id="TNCID_REF" class="form-control"  autocomplete="off" />
                @endif
                </div>
            </div>
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="margin-top:10px;height:240px;width:50%;">
                <table id="example3" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                    <tr >
                        <th>Terms & Conditions Description<input class="form-control" type="hidden" name="Row_Count2" id ="Row_Count2"  value="{{$objCount3}}" /></th>
                        <th>Value / Comment</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="tncbody">
                @if(!empty($objPBTNC))
                  @foreach($objPBTNC as $Tkey => $Trow)
                      <tr  class="participantRow3">
                          <td><input {{$ActionStatus}} type="text" name={{"popupTNCDID_".$Tkey}} id={{"popupTNCDID_".$Tkey}} class="form-control"  autocomplete="off"  readonly/></td>
                          <td hidden><input type="hidden" name={{"TNCDID_REF_".$Tkey}} id={{"TNCDID_REF_".$Tkey}} class="form-control" value="{{$Trow->TNCDID_REF}}" autocomplete="off" /></td>
                          <td hidden><input type="hidden" name={{"TNCismandatory_".$Tkey}} id={{"TNCismandatory_".$Tkey}} class="form-control" autocomplete="off" /></td>
                          <td id={{"tdinputid_".$Tkey}}>
                          {{-- dynamic input --}} 
                          </td>
                          <td align="center" ><button class="btn add TNC" title="add" data-toggle="tooltip"  type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DTNC" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                      </tr>
                      <tr></tr>
                  @endforeach 
                  @else
                      <tr  class="participantRow3">
                          <td><input {{$ActionStatus}} type="text" name="popupTNCDID_0" id="popupTNCDID_0" class="form-control"  autocomplete="off"  readonly/></td>
                          <td hidden><input type="hidden" name="TNCDID_REF_0" id="TNCDID_REF_0" class="form-control" autocomplete="off" /></td>
                          <td hidden><input type="hidden" name="TNCismandatory_0" id="TNCismandatory_0" class="form-control" autocomplete="off" /></td>
                          <td id="tdinputid_0">
                            {{-- dynamic input --}} 
                          </td>
                              <td align="center" ><button class="btn add TNC" title="add" data-toggle="tooltip"  type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DTNC" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                          </tr>
                      <tr></tr>
              @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div id="CT" class="tab-pane fade">
            <div class="row" style="margin-top:10px;margin-left:3px;" >	
                <div class="col-lg-2 pl"><p>Calculation Template</p></div>
                <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="txtCTID_popup" id="txtCTID_popup" class="form-control"  autocomplete="off"  readonly/>
                @if(!empty($objPBCAL))
                  <input type="hidden" name="CTID_REF" id="CTID_REF" class="form-control" value="{{$objPBCAL[0]->CTID_REF}}" autocomplete="off" />
                @else
                  <input type="hidden" name="CTID_REF" id="CTID_REF" class="form-control" autocomplete="off" />
                @endif
                </div>
            </div>
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:240px;" >
                <table id="example5" class="display nowrap table table-striped table-bordered itemlist " width="100%" style="height:auto !important;">
                  <thead id="thead1"  style="position: sticky;top: 0">
                      <tr>
                          <th>Calculation Component<input class="form-control" type="hidden" name="Row_Count3" id ="Row_Count3" value="{{$objCount4}}" /></th>
                          <th>Rate</th>
                          <th>Value</th>
                          <th>GST Applicable</th>
                          <th>IGST Rate</th>
                          <th>IGST Amount</th>
                          <th>CGST Rate</th>
                          <th>CGST Amount</th>
                          <th>SGST Rate</th>
                          <th>SGST Amount</th>
                          <th>Total GST Amount</th>
                          <th>As per Actual</th>
                          <th width="8%">Action</th>
                      </tr>
                  </thead>
                  <tbody id="tbody_ctid">
                  @if(!empty($objPBCAL))
                    @foreach($objPBCAL as $Ckey => $Crow)
                        <tr  class="participantRow5">
                            <td><input {{$ActionStatus}} type="text" name={{"popupTID_".$Ckey}} id={{"popupTID_".$Ckey}}  class="form-control"  autocomplete="off"  readonly/></td>
                            <td hidden><input type="hidden" name={{"TID_REF_".$Ckey}}  id={{"TID_REF_".$Ckey}}  class="form-control" autocomplete="off" value="{{$Crow->TID_REF}}" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"RATE_".$Ckey}}  id={{"RATE_".$Ckey}} class="form-control four-digits" maxlength="8" autocomplete="off" value="{{$Crow->RATE}}"  readonly/></td>
                            <td hidden><input type="hidden" name={{"BASIS_".$Ckey}} id={{"BASIS_".$Ckey}} class="form-control" autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name={{"SQNO_".$Ckey}} id={{"SQNO_".$Ckey}} class="form-control" autocomplete="off" /></td>
                            <td hidden><input type="hidden" name={{"FORMULA_".$Ckey}} id={{"FORMULA_".$Ckey}} class="form-control" autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"VALUE_".$Ckey}} id={{"VALUE_".$Ckey}} class="form-control two-digits" maxlength="15" autocomplete="off" value="{{$Crow->VALUE}}" readonly/></td>
                            <td style="text-align:center;" ><input {{$ActionStatus}} type="checkbox" class="filter-none" name={{"calGST_".$Ckey}} id={{"calGST_".$Ckey}} {{$Crow->GST == 1 ? 'checked' : ''}}   ></td>
                            
                            <td><input type="text" name={{"calIGST_".$Ckey}} id={{"calIGST_".$Ckey}} class="form-control four-digits" maxlength="8" autocomplete="off" value="{{$Crow->IGST}}" readonly/></td>
                      @php
                          $IGSTAMT=number_format((($Crow->VALUE*$Crow->IGST)/100),2, '.', '');
                      @endphp        
                            <td><input {{$ActionStatus}} type="text" name={{"AMTIGST_".$Ckey}} id={{"AMTIGST_".$Ckey}} class="form-control two-digits" maxlength="15" autocomplete="off" value="{{$IGSTAMT}}"  readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"calCGST_".$Ckey}} id={{"calCGST_".$Ckey}} class="form-control four-digits" maxlength="8" autocomplete="off" value="{{$Crow->CGST}}" readonly/></td>
                      @php
                          $CGSTAMT=number_format((($Crow->VALUE*$Crow->CGST)/100),2, '.', '');
                      @endphp       
                            <td><input {{$ActionStatus}} type="text" name={{"AMTCGST_".$Ckey}} id={{"AMTCGST_".$Ckey}} class="form-control two-digits" maxlength="15" autocomplete="off" value="{{$CGSTAMT}}" readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"calSGST_".$Ckey}} id={{"calSGST_".$Ckey}} class="form-control four-digits" maxlength="8" autocomplete="off" value="{{$Crow->SGST}}" readonly/></td>
                      @php
                          $SGSTAMT=number_format((($Crow->VALUE*$Crow->SGST)/100),2, '.', '');
                      @endphp
                            <td><input {{$ActionStatus}} type="text" name={{"AMTSGST_".$Ckey}} id={{"AMTSGST_".$Ckey}} class="form-control two-digits" maxlength="15" autocomplete="off" value="{{$SGSTAMT}}" readonly/></td>
                      @php
                          $TOTGSTAMT=number_format(($IGSTAMT+$CGSTAMT+$SGSTAMT),2, '.', '');
                      @endphp      
                            <td><input {{$ActionStatus}} type="text" name={{"TOTGSTAMT_".$Ckey}} id={{"TOTGSTAMT_".$Ckey}} class="form-control two-digits"  maxlength="15" autocomplete="off" value="{{$TOTGSTAMT}}" readonly/></td>
                            <td style="text-align:center;"><input {{$ActionStatus}} type="checkbox" class="filter-none" name={{"calACTUAL_".$Ckey}} id={{"calACTUAL_".$Ckey}}  {{$Crow->ACTUAL == 1 ? 'checked' : ''}} /></td>
                            <td align="center" ><button class="btn add" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                        </tr>
                        <tr></tr>
                    @endforeach 
                    @else
                    <tr  class="participantRow5">
                        <td><input {{$ActionStatus}} type="text" name="popupTID_0" id="popupTID_0" class="form-control"  autocomplete="off"  readonly/></td>
                        <td hidden><input type="hidden" name="TID_REF_0" id="TID_REF_0" class="form-control" autocomplete="off" /></td>
                        <td><input {{$ActionStatus}} type="text" name="RATE_0" id="RATE_0" class="form-control four-digits" maxlength="8" autocomplete="off"  readonly/></td>
                        <td hidden><input type="hidden" name="BASIS_0" id="BASIS_0" class="form-control" autocomplete="off" /></td>
                        <td hidden><input type="hidden" name="SQNO_0" id="SQNO_0" class="form-control" autocomplete="off" /></td>
                        <td><input {{$ActionStatus}} type="text" name="VALUE_0" id="VALUE_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly/></td>
                        <td style="text-align:center;" ><input {{$ActionStatus}} type="checkbox" class="filter-none" name="calGST_0" id="calGST_0" value="" ></td>
                        <td><input {{$ActionStatus}} type="text" name="calIGST_0" id="calIGST_0" class="form-control four-digits" maxlength="8" autocomplete="off"  readonly/></td>
                        <td><input {{$ActionStatus}} type="text" name="AMTIGST_0" id="AMTIGST_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly/></td>
                        <td><input {{$ActionStatus}} type="text" name="calCGST_0" id="calCGST_0" class="form-control four-digits" maxlength="8" autocomplete="off"  readonly/></td>
                        <td><input {{$ActionStatus}} type="text" name="AMTCGST_0" id="AMTCGST_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly/></td>
                        <td><input {{$ActionStatus}} type="text" name="calSGST_0" id="calSGST_0" class="form-control four-digits" maxlength="8" autocomplete="off"  readonly/></td>
                        <td><input {{$ActionStatus}} type="text" name="AMTSGST_0" id="AMTSGST_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly/></td>
                        <td><input {{$ActionStatus}} type="text" name="TOTGSTAMT_0" id="TOTGSTAMT_0" class="form-control two-digits"  maxlength="15" autocomplete="off"  readonly/></td>
                        <td style="text-align:center;"><input {{$ActionStatus}} type="checkbox" class="filter-none" name="calACTUAL_0" id="calACTUAL_0" value=""   ></td>
                        <td align="center" >
                          <button {{$ActionStatus}} class="btn add" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button>
                          <button {{$ActionStatus}} class="btn remove" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button>
                        </td>
                    </tr>
                    <tr></tr>
                  @endif
                  </tbody>
                </table>
            </div>	
        </div>
        <div id="PaymentSlabs" class="tab-pane fade">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="margin-top:10px;height:280px;width:55%;">
                <table id="example6" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                      <tr >
                          <th>Day(s)<input class="form-control" type="hidden" name="Row_Count5" id ="Row_Count5" value="{{$objCount5}}" /></th>
                          <th>Due %</th>
                          <th>Remarks</th>
                          <th>Due Date</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if(!empty($objPBPSLB))
                      @foreach($objPBPSLB as $Pkey => $Prow)
                          <tr  class="participantRow6">
                              <td> <input {{$ActionStatus}} type="text" class="form-control" id={{"PAY_DAYS_".$Pkey}} name={{"PAY_DAYS_".$Pkey}} value="{{$Prow->PAY_DAYS}}" autocomplete="off"  /> </td>
                              <td> <input {{$ActionStatus}} type="text" class="form-control four-digits" id={{"DUE_".$Pkey}} name={{"DUE_".$Pkey}} value="{{$Prow->DUE}}" maxlength="8" autocomplete="off" /> </td>
                              <td> <input {{$ActionStatus}} type="text" class="form-control" id={{"PSREMARKS_".$Pkey}} name={{"PSREMARKS_".$Pkey}} value="{{$Prow->REMARKS}}" autocomplete="off"  /> </td>
                              <td> <input {{$ActionStatus}} type="text" class="form-control" id={{"DUE_DATE_".$Pkey}} name={{"DUE_DATE_".$Pkey}} value="{{$Prow->DUE_DATE}}" autocomplete="off"  /> </td>
                              
                              <td align="center" style="min-width: 100px;" >
                                <button {{$ActionStatus}} class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                                <button {{$ActionStatus}} class="btn remove" title="Delete" data-toggle="tooltip" type="button" ><i class="fa fa-trash" ></i></button>
                              </td>
                          </tr>
                          <tr></tr>
                      @endforeach 
                      @else
                      <tr  class="participantRow6">
                              <td> <input {{$ActionStatus}} type="text" class="form-control" id="PAY_DAYS_0" name="PAY_DAYS_0"  autocomplete="off" /> </td>
                              <td> <input {{$ActionStatus}} type="text" class="form-control four-digits" id="DUE_0" name="DUE_0"  maxlength="8" autocomplete="off" /> </td>
                              <td> <input {{$ActionStatus}} type="text" class="form-control" id="PSREMARKS_0" name="PSREMARKS_0" autocomplete="off"  /> </td>
                              <td> <input {{$ActionStatus}} type="date" class="form-control" id="DUE_DATE_0" name="DUE_DATE_0" autocomplete="off"  readonly /> </td>
                              <td align="center" style="min-width: 100px;" >
                                <button {{$ActionStatus}} class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                                <button {{$ActionStatus}} class="btn remove" title="Delete" data-toggle="tooltip" type="button" ><i class="fa fa-trash" ></i></button>
                              </td>
                          </tr>
                      <tr></tr>
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
                      <option {{ isset($objPBHDR->TDS) && $objPBHDR->TDS =='1'?'selected="selected"':'' }} value="Yes">Yes</option>
                      <option {{ isset($objPBHDR->TDS) && $objPBHDR->TDS =='0'?'selected="selected"':'' }} value="No">No</option>
                  </select>
                </div>
            </div>
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                <table id="example7" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                          <tr>
                              <th width="8%">TDS<input class="form-control" type="hidden" name="Row_Count4" id ="Row_Count4"  value="{{$objCount6}}" /></th>
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
                    @if(!empty($objPBTDS))
                      @foreach($objPBTDS as $tkey => $trow)
                        <tr  class="participantRow7">
                            <td style="text-align:center;" >
                            <input {{$ActionStatus}} type="text" name={{"txtTDS_".$tkey}} id={{"txtTDS_".$tkey}} class="form-control" value="{{$trow->CODE}}" autocomplete="off"  readonly/></td>
                            <td hidden><input type="hidden" name={{"TDSID_REF_".$tkey}} id={{"TDSID_REF_".$tkey}} value="{{$trow->TDSID_REF}}" class="form-control" autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"TDSLedger_".$tkey}} id={{"TDSLedger_".$tkey}} class="form-control" value="{{$trow->CODE_DESC}}" autocomplete="off"  readonly/></td>
                            <td  align="center" style="text-align:center;" ><input {{$ActionStatus}} type="checkbox" name={{"TDSApplicable_".$tkey}} id={{"TDSApplicable_".$tkey}} {{isset($trow->TDS_APPLICABLE) && $trow->TDS_APPLICABLE == 1?'checked' : ''}}/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"ASSESSABLE_VL_TDS_".$tkey}} id={{"ASSESSABLE_VL_TDS_".$tkey}} class="form-control two-digits" value="{{$trow->ASSESSABLE_VL_TDS}}" maxlength="15"  autocomplete="off"  /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"TDS_RATE_".$tkey}} id={{"TDS_RATE_".$tkey}} class="form-control four-digits" maxlength="12" value="{{$trow->TDS_RATE}}" autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name={{"TDS_EXEMPT_".$tkey}} id={{"TDS_EXEMPT_".$tkey}} class="form-control two-digits" value="0.00" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"TDS_AMT_".$tkey}} id={{"TDS_AMT_".$tkey}} class="form-control two-digits" maxlength="15"  autocomplete="off"  value="{{$trow->TDS_AMT}}" readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"ASSESSABLE_VL_SURCHARGE_".$tkey}} id={{"ASSESSABLE_VL_SURCHARGE_".$tkey}} class="form-control two-digits" value="{{$trow->ASSESSABLE_VL_SURCHARGE}}" maxlength="15"  autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"SURCHARGE_RATE_".$tkey}} id={{"SURCHARGE_RATE_".$tkey}} class="form-control four-digits" maxlength="12" value="{{$trow->SURCHARGE_RATE}}"  autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name={{"SURCHARGE_EXEMPT_".$tkey}} id={{"SURCHARGE_EXEMPT_".$tkey}} class="form-control two-digits" value="0.00" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"SURCHARGE_AMT_".$tkey}} id={{"SURCHARGE_AMT_".$tkey}} class="form-control two-digits" maxlength="15" value="{{$trow->SURCHARGE_AMT}}" autocomplete="off"  readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"ASSESSABLE_VL_CESS_".$tkey}} id={{"ASSESSABLE_VL_CESS_".$tkey}} class="form-control two-digits" maxlength="15" value="{{$trow->ASSESSABLE_VL_CESS}}" autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"CESS_RATE_".$tkey}} id={{"CESS_RATE_".$tkey}} class="form-control four-digits" maxlength="12" value="{{$trow->CESS_RATE}}" autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name={{"CESS_EXEMPT_".$tkey}} id={{"CESS_EXEMPT_".$tkey}} class="form-control two-digits" value="0.00" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"CESS_AMT_".$tkey}} id={{"CESS_AMT_".$tkey}} class="form-control two-digits" maxlength="15" value="{{$trow->CESS_AMT}}" autocomplete="off"  readonly/></td>
                            <td><input {{$ActionStatus}} type="text" name={{"ASSESSABLE_VL_SPCESS_".$tkey}} id={{"ASSESSABLE_VL_SPCESS_".$tkey}} class="form-control two-digits" maxlength="15" value="{{$trow->ASSESSABLE_VL_SPCESS}}"  autocomplete="off" /></td>
                            <td><input {{$ActionStatus}} type="text" name={{"SPCESS_RATE_".$tkey}} id={{"SPCESS_RATE_".$tkey}} class="form-control four-digits" maxlength="12" value="{{$trow->SPCESS_RATE}}" autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name={{"SPCESS_EXEMPT_".$tkey}} id={{"SPCESS_EXEMPT_".$tkey}} class="form-control two-digits" value="0.00" /></td>
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
                        <tr  class="participantRow7">
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
                        <th>UDF Fields<input class="form-control" type="hidden" name="Row_Count6" id ="Row_Count6"  value="{{$objCount2}}" /></th>
                        <th>Value / Comments</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($objPBUDF))
                      @foreach($objPBUDF as $Ukey => $Urow)
                          <tr  class="participantRow4">
                              <td><input {{$ActionStatus}} type="text" name={{"popupUDFPBID_".$Ukey}} id={{"popupUDFPBID_".$Ukey}}  class="form-control"  autocomplete="off"  readonly/></td>
                              <td hidden><input type="hidden" name={{"UDFPBID_REF_".$Ukey}}  id={{"UDFPBID_REF_".$Ukey}} class="form-control" value="{{$Urow->PB_UDFID}}" autocomplete="off" /></td>
                              <td hidden><input type="hidden" name={{"UDFismandatory_".$Ukey}} id={{"UDFismandatory_".$Ukey}} class="form-control" autocomplete="off" /></td>
                              <td id={{"udfinputid_".$Ukey}}>
                              {{-- dynamic input --}} 
                              </td>
                              <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                          </tr>
                          <tr></tr>
                      @endforeach 
                      @else
                      @if($objUdfPBData)
                        @foreach($objUdfPBData as $uindex=>$uRow)
                          <tr  class="participantRow4">
                              <td><input  {{$ActionStatus}} type="text" name={{"popupUDFPBID_".$uindex}} id={{"popupUDFPBID_".$uindex}} class="form-control" value="{{$uRow->LABEL}}" autocomplete="off"  readonly/></td>
                              <td hidden><input type="hidden" name={{"UDFPBID_REF_".$uindex}} id={{"UDFPBID_REF_".$uindex}} class="form-control" value="{{$uRow->UDFPBID}}" autocomplete="off"   /></td>
                              <td hidden><input type="hidden" name={{"UDFismandatory_".$uindex}} id={{"UDFismandatory_".$uindex}} value="{{$uRow->ISMANDATORY}}" class="form-control"   autocomplete="off" /></td>
                              <td id={{"udfinputid_".$uindex}} >
                              </td>
                              <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>                          
                          </tr>
                          <tr></tr>
                        @endforeach
                        @else
                          <tr  class="participantRow4">
                              <td><input {{$ActionStatus}} type="text" name="popupUDFPBID_0" id="popupUDFPBID_0" class="form-control" value="" autocomplete="off"  readonly/></td>
                              <td hidden><input type="hidden" name="UDFPBID_REF_0" id="UDFPBID_REF_0" class="form-control" value="" autocomplete="off"   /></td>
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

        <div id="ADDITIONAL" class="tab-pane fade">
          <div class="row" style="margin-top:10px;margin-left:3px;" >	
            <div class="col-lg-2 pl"><p>Template Master</p></div>
            <div class="col-lg-2 pl">
            <input type="text" name="txtTemplate_popup" id="txtTemplate_popup" class="form-control"  autocomplete="off"  readonly/>
            <input type="hidden" name="TEMPID_REF" id="TEMPID_REF" class="form-control" autocomplete="off" />
            </div>
          </div>
          <div class="row" style="margin-top:10px;margin-left:3px;" >	
            <div class="col-lg-2 pl"><p>Template Description</p></div>
            <div class="col-lg-6 pl">
            <textarea name="Template_Description" id="Template_Description" cols="118" rows="10" >{{ isset($Template->TEMPLATE)?$Template->TEMPLATE:'' }}</textarea>
            </div>
          </div>                                
        </div>


      </div>
    </div>
  </div>
		
	<!-- </div> -->
	</form>
</div>

<!-- </div> -->

@endsection
@section('alert')


<!-- Template Master Dropdown-->

<div id="Templatepopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='Template_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Template Master</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="TemplateTable" class="display nowrap table  table-striped table-bordered">
    <thead>
    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Name</th>
      <th class="ROW3">Date</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="Templatecodesearch" class="form-control" onkeyup="TemplateCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="Templatenamesearch" class="form-control" onkeyup="TemplateDateFunction()"></td>
    </tr>
    </tbody>
    </table>
      <table id="TemplateTable2" class="display nowrap table  table-striped table-bordered">
        <thead id="thead2">
         
        </thead>
        <tbody>
        @foreach ($objTemplateMaster as $calindex=>$TempRow)
        <tr>
            <td class="ROW1"> <input type="checkbox" name="SELECT_TEMPLATE[]" id="Templatecode_{{ $calindex }}" class="clstemplateid" value="{{ $TempRow-> TEMPLATEID }}" ></td>
            <td class="ROW2">{{ $TempRow-> TEMPLATE_NAME }}
              <input type="hidden" id="txtTemplatecode_{{ $calindex }}" data-desc="{{ $TempRow-> TEMPLATE_NAME }}" data-desc2="{{isset($TempRow->INDATE) && $TempRow->INDATE !='' && $TempRow->INDATE !='1900-01-01' ? date('d-m-Y',strtotime($TempRow->INDATE)):''}}" data-desc3="{{ $TempRow-> TEMPLATE }}"  value="{{ $TempRow-> TEMPLATEID }}"/>
            </td>
            <td class="ROW3">{{isset($TempRow->INDATE) && $TempRow->INDATE !='' && $TempRow->INDATE !='1900-01-01' ? date('d-m-Y',strtotime($TempRow->INDATE)):''}}</td>
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
<!-- Template Master Dropdown-->


<!-- DEPID Dropdown -->
<div id="depidpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='dep_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Department</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="CodeTable" class="display nowrap table  table-striped table-bordered">
      <thead>
          <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Code</th>
      <th class="ROW3">Name</th>
    </tr>
      </thead>
      <tbody>

        <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="codesearch" class="form-control" autocomplete="off" onkeyup="CodeFunction()"></td>
        <td class="ROW3"><input type="text" id="namesearch" class="form-control" autocomplete="off" onkeyup="NameFunction()"></td>
      </tr>
      </tbody>
    </table>
    <table id="CodeTable2" class="display nowrap table  table-striped table-bordered" >
      <thead id="thead2">
      </thead>
      <tbody>
      @foreach ($objdepartment as $index=>$clRow)
        <tr >
          <td class="ROW1"> <input type="checkbox" name="SELECT_DEPID_REF[]" id="depidcode_{{ $index }}" class="clsdepid" value="{{ $clRow-> DEPID }}" ></td>
            <td class="ROW2">{{ $clRow-> DCODE }}
              <input type="hidden" id="txtdepidcode_{{ $index }}" data-desc="{{ $clRow-> DCODE }}" data-desc2="{{ $clRow-> NAME }}"  value="{{ $clRow-> DEPID }}"/>
            </td>
            <td class="ROW3" >{{ $clRow-> NAME }}</td>
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
<!-- DEPID Dropdown-->

<!--VENDOR dropdown-->

<div id="vendoridpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='vendor_close_popup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Vendor Details</p></div>
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
<!--VENDOR dropdown-->

<!-- Bill To Dropdown -->
<div id="BillTopopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='BillToclosePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Bill To</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="BillToTable" class="display nowrap table  table-striped table-bordered" >
    <thead>

    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Name</th>
      <th class="ROW3">Address</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="BillTocodesearch" class="form-control" autocomplete="off" onkeyup="BillToCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="BillTonamesearch" class="form-control" autocomplete="off" onkeyup="BillToNameFunction()"></td>
      </tr>
    </tbody>
    </table>
      <table id="BillToTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">
         
        </thead>
        <tbody id="tbody_BillTo">
       
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Bill To Dropdown-->

<!-- Ship To Dropdown -->
<div id="ShipTopopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='ShipToclosePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Ship To</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="ShipToTable" class="display nowrap table  table-striped table-bordered" >
    <thead>
    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Name</th>
      <th class="ROW3">Address</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="ShipTocodesearch" class="form-control" autocomplete="off" onkeyup="ShipToCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="ShipTonamesearch" class="form-control" autocomplete="off" onkeyup="ShipToNameFunction()"></td>
      </tr>
    </tbody>
    </table>
      <table id="ShipToTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">
         
        </thead>
        <tbody id="tbody_ShipTo">
       
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Ship To Dropdown-->

<!-- TNC Header Dropdown -->
<div id="TNCIDpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='TNCID_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>T&C</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="TNCIDTable" class="display nowrap table  table-striped table-bordered" >
    <thead>

    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Code</th>
      <th class="ROW3">Name</th>
    </tr>
    </thead>
    <tbody>

    <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="TNCcodesearch" class="form-control" autocomplete="off" onkeyup="TNCCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="TNCnamesearch" class="form-control" autocomplete="off" onkeyup="TNCNameFunction()"></td>
      </tr>

    </tbody>
    </table>
      <table id="TNCIDTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">
         
        </thead>
        <tbody>
        @foreach ($objTNCHeader as $tncindex=>$tncRow)
        <tr >
          <td class="ROW1"> <input type="checkbox" name="SELECT_TNCID_REF[]" id="tncidcode_{{ $tncindex }}" class="clstncid" value="{{ $tncRow-> TNCID }}" ></td>
          <td class="ROW2">{{ $tncRow-> TNC_CODE }}
          <input type="hidden" id="txttncidcode_{{ $tncindex }}" data-desc="{{ $tncRow-> TNC_CODE }} - {{ $tncRow-> TNC_DESC }}"  
          value="{{ $tncRow-> TNCID }}"/></td><td class="ROW3" >{{ $tncRow-> TNC_DESC }}</td>
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
<!-- TNC Header Dropdown-->

<!-- TNC Details Dropdown -->
<div id="tncdetpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='tncdet_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Terms & Condition Details</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="TNCDetTable" class="display nowrap table  table-striped table-bordered" width="100%">
    <thead>
    <tr>
            <th>TNC Name</th>
            <th>Value Type</th>
    </tr>
    <tr hidden>
            <input type="hidden" name="fieldid" id="hdn_tncdet"/>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>
    <input type="text" id="tncdetcodesearch" autocomplete="off" onkeyup="TNCDetCodeFunction()">
    </td>
    <td>
    <input type="text" id="tncdetnamesearch" autocomplete="off" onkeyup="TNCDetNameFunction()">
    </td>
    </tr>
    </tbody>
    </table>
      <table id="TNCDetTable2" class="display nowrap table  table-striped table-bordered" width="100%">
        <thead id="thead2">
          
        </thead>
        <tbody id="tbody_tncdetails">       
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- TNC Details Dropdown-->

<!-- Calculation Header Dropdown -->
<div id="CTIDpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='CTID_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Calculation Template</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="CTIDTable" class="display nowrap table  table-striped table-bordered" >
    <thead>

    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Code</th>
      <th class="ROW3">Name</th>
    </tr>

    </thead>
    <tbody>


    <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="CTIDcodesearch" class="form-control" autocomplete="off" onkeyup="CTIDCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="CTIDnamesearch" class="form-control" autocomplete="off" onkeyup="CTIDNameFunction()"></td>
      </tr>

    </tbody>
    </table>
      <table id="CTIDTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">
         
        </thead>
        <tbody>
        @foreach ($objCalculationHeader as $calindex=>$calRow)
        <tr >
        <td class="ROW1"> <input type="checkbox" name="SELECT_CTID_REF[]" id="CTIDcode_{{ $calindex }}" class="clsctid" value="{{ $calRow-> CTID }}" ></td>
          <td class="ROW2">{{ $calRow-> CTCODE }}
          <input type="hidden" id="txtCTIDcode_{{ $calindex }}" data-desc="{{ $calRow-> CTCODE }} - {{ $calRow-> CTDESCRIPTION }}"  
          value="{{ $calRow-> CTID }}"/></td><td class="ROW3" >{{ $calRow-> CTDESCRIPTION }}</td>
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
<!-- Calculation Header Dropdown-->

<!-- Calculation Details Dropdown -->
<div id="ctiddetpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='ctiddet_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Terms & Condition Details</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="CTIDDetTable" class="display nowrap table  table-striped table-bordered" width="100%">
    <thead>
    <tr>
            <th>Component</th>
            <th>Basis</th>
            <th>Rate</th>
            <th>Amount</th>
            <th>Formula</th>
    </tr>
    <tr hidden>
            <input type="hidden" name="fieldid" id="hdn_ctiddet"/>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>
    <input type="text" id="CTIDdetcodesearch" autocomplete="off" onkeyup="CTIDDetCodeFunction()">
    </td>
    <td>
    <input type="text" id="CTIDdetnamesearch" autocomplete="off" onkeyup="CTIDDetNameFunction()">
    </td>
    <td>
    <input type="text" id="CTIDdetratesearch" autocomplete="off" onkeyup="CTIDDetRateFunction()">
    </td>
    <td>
    <input type="text" id="CTIDdetamountsearch" autocomplete="off" onkeyup="CTIDDetAmountFunction()">
    </td>
    <td>
    <input type="text" id="CTIDdetformulasearch" autocomplete="off" onkeyup="CTIDDetFormulaFunction()">
    </td>
    </tr>
    </tbody>
    </table>
      <table id="CTIDDetTable2" class="display nowrap table  table-striped table-bordered" width="100%">
        <thead id="thead2">
          
        </thead>
        <tbody id="tbody_ctiddetails">       
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Calculation Details Dropdown-->

<!-- Good Receipt Dropdown -->
<div id="GRNpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='GRN_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Good Receipt Note</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="GRNTable" class="display nowrap table  table-striped table-bordered" >
    <thead>
          <tr id="none-select" class="searchalldata" hidden>
            
            <td> <input type="hidden" name="hdn_GRN" id="hdn_GRN"/>
            <input type="hidden" name="hdn_GRN2" id="hdn_GRN2"/></td>
          </tr>

    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Good Receipt No</th>
      <th class="ROW3">Good Receipt Date</th>
    </tr>
    </thead>
    <tbody>
    
    <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="GRNcodesearch" class="form-control" autocomplete="off" onkeyup="GRNCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="GRNnamesearch" class="form-control" autocomplete="off" onkeyup="GRNNameFunction()"></td>
      </tr>

    </tbody>
    </table>
      <table id="GRNTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">

        </thead>
        <tbody id="tbody_GRN">     
        
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Good Receipt Dropdown-->

<!-- Item Code Dropdown -->
<div id="ITEMIDpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width:90%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='ITEMID_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Item Details</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="ItemIDTable" class="display nowrap table  table-striped table-bordered" style="width:100%" >
    <thead>
      <tr id="none-select" class="searchalldata" hidden>
            
            <td> 
                <input type="hidden" name="hdn_ItemID" id="hdn_ItemID"/>
                <input type="hidden" name="hdn_ItemID2" id="hdn_ItemID2"/>
                <input type="hidden" name="hdn_ItemID3" id="hdn_ItemID3"/>
                <input type="hidden" name="hdn_ItemID4" id="hdn_ItemID4"/>
                <input type="hidden" name="hdn_ItemID5" id="hdn_ItemID5"/>
                <input type="hidden" name="hdn_ItemID6" id="hdn_ItemID6"/>
                <input type="hidden" name="hdn_ItemID7" id="hdn_ItemID7"/>
                <input type="hidden" name="hdn_ItemID8" id="hdn_ItemID8"/>
                <input type="hidden" name="hdn_ItemID9" id="hdn_ItemID9"/>
                <input type="hidden" name="hdn_ItemID10" id="hdn_ItemID10"/>
                <input type="hidden" name="hdn_ItemID11" id="hdn_ItemID11"/>
                <input type="hidden" name="hdn_ItemID12" id="hdn_ItemID12"/>
                <input type="hidden" name="hdn_ItemID13" id="hdn_ItemID13"/>
                <input type="hidden" name="hdn_ItemID14" id="hdn_ItemID14"/>
                <input type="hidden" name="hdn_ItemID15" id="hdn_ItemID15"/>
                <input type="hidden" name="hdn_ItemID16" id="hdn_ItemID16"/>
                <input type="hidden" name="hdn_ItemID17" id="hdn_ItemID17"/>
                <input type="hidden" name="hdn_ItemID18" id="hdn_ItemID18"/>
                <input type="hidden" name="hdn_ItemID19" id="hdn_ItemID19"/>
                <input type="hidden" name="hdn_ItemID20" id="hdn_ItemID20"/>
                <input type="hidden" name="hdn_ItemID21" id="hdn_ItemID21" value="0"/>
                <input type="hidden" name="hdn_ItemID22" id="hdn_ItemID22"/>
                <input type="hidden" name="hdn_ItemID23" id="hdn_ItemID23"/>
                <input type="hidden" name="hdn_ItemID24" id="hdn_ItemID24"/>
                <input type="hidden" name="hdn_ItemID25" id="hdn_ItemID25"/>
                <input type="hidden" name="hdn_ItemID26" id="hdn_ItemID26"/>
                <input type="hidden" name="hdn_ItemID27" id="hdn_ItemID27"/>
            </td>
      </tr>
      <!-- <tr class="topnav"><button class="btn topnavbt" id="btnOk"><i class="fa fa-check"></i> OK</button></tr> -->
      <tr>
            <th style="width:8%;" id="all-check" >Select</th>
            <th style="width:10%;">Item Code</th>
            <th style="width:10%;">Name</th>
            <th style="width:8%;">Main UOM</th>
            <th style="width:8%;">Main QTY</th>
            <th style="width:8%;">Item Group</th>
            <th style="width:8%;">Item Category</th>
            <th style="width:8%;">Business Unit</th>
            <th style="width:8%;" {{$AlpsStatus['hidden']}} >ALPS Part No.</th>
            <th style="width:8%;" {{$AlpsStatus['hidden']}} >Customer Part No.</th>
            <th style="width:8%;" {{$AlpsStatus['hidden']}} >OEM Part No.</th>
            <th style="width:8%;">Status</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    <td style="width:8%;text-align:center;"><input type="checkbox" class="js-selectall" data-target=".js-selectall1" /></td>
    <td style="width:10%;">
    <input type="text" id="Itemcodesearch" class="form-control" autocomplete="off" onkeyup="ItemCodeFunction()">
    </td>
    <td style="width:10%;">
    <input type="text" id="Itemnamesearch" class="form-control" autocomplete="off" onkeyup="ItemNameFunction()">
    </td>
    <td style="width:8%;">
    <input type="text" id="ItemUOMsearch" class="form-control" autocomplete="off" onkeyup="ItemUOMFunction()">
    </td>
    <td style="width:8%;">
    <input type="text" id="ItemQTYsearch" class="form-control" autocomplete="off" onkeyup="ItemQTYFunction()">
    </td>
    <td style="width:8%;">
    <input type="text" id="ItemGroupsearch" class="form-control" autocomplete="off" onkeyup="ItemGroupFunction()">
    </td>
    <td style="width:8%;">
    <input type="text" id="ItemCategorysearch" class="form-control" autocomplete="off" onkeyup="ItemCategoryFunction()">
    </td>
    <td style="width:8%;">
    <input type="text" id="ItemBUsearch" class="form-control" autocomplete="off" onkeyup="ItemBUFunction()">
    </td>
    <td style="width:8%;" {{$AlpsStatus['hidden']}} >
    <input type="text" id="ItemAPNsearch" class="form-control" autocomplete="off" onkeyup="ItemAPNFunction()">
    </td>
    <td style="width:8%;" {{$AlpsStatus['hidden']}} >
    <input type="text" id="ItemCPNsearch" class="form-control" autocomplete="off" onkeyup="ItemCPNFunction()">
    </td>
    <td style="width:8%;" {{$AlpsStatus['hidden']}} >
    <input type="text" id="ItemOEMPNsearch" class="form-control" autocomplete="off" onkeyup="ItemOEMPNFunction()">
    </td>
    <td style="width:8%;">
    <input type="text" id="ItemStatussearch" class="form-control" autocomplete="off" onkeyup="ItemStatusFunction()">
    </td>
    </tr>
    </tbody>
    </table>
      <table id="ItemIDTable2" class="display nowrap table  table-striped table-bordered" style="width:100%" >
        <thead id="thead2">

        </thead>
        <tbody id="tbody_ItemID">     
          
          
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Item Code Dropdown-->

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
    font-weight: bold;
}
#ItemIDcodesearch {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  font-size: 11px;
  padding: 5px 5px 5px 5px;
  border: 1px solid #ddd;
  margin-bottom: 5px;
}
#ItemIDnamesearch {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  font-size: 11px;
  padding: 5px 5px 5px 5px;
  border: 1px solid #ddd;
  margin-bottom: 5px;
}
#ItemIDTable {
  border-collapse: collapse;
  width: 950px;
  border: 1px solid #ddd;
  font-size: 11px;
}
#ItemIDTable th {
    text-align: center;
    padding: 5px;
   
    font-size: 11px;
    
    color: #0f69cc;
    font-weight: 600;
}
#ItemIDTable td {
    text-align: center;
    padding: 5px;
    font-size: 11px;
   
    font-weight: 600;
}
#ItemIDTable2 {
  border-collapse: collapse;
  width: 1050px;
  border: 1px solid #ddd;
  font-size: 11px;
}
#ItemIDTable2 th{
    text-align: left;
    padding: 5px;
   
    font-size: 11px;
  
    color: #0f69cc;
    font-weight: 600;
}
#ItemIDTable2 td {
  text-align: left;
    padding: 5px;
    font-size: 11px;
    font-weight: 600;
    width: 18%;
}

</style>
@endpush
@push('bottom-scripts')
<script>
"use strict";
	var w3 = {};
  w3.getElements = function (id) {
    if (typeof id == "object") {
      return [id];
    } else {
      return document.querySelectorAll(id);
    }
  };
	w3.sortHTML = function(id, sel, sortvalue) {
    var a, b, i, ii, y, bytt, v1, v2, cc, j;
    a = w3.getElements(id);
    for (i = 0; i < a.length; i++) {
      for (j = 0; j < 2; j++) {
        cc = 0;
        y = 1;
        while (y == 1) {
          y = 0;
          b = a[i].querySelectorAll(sel);
          for (ii = 0; ii < (b.length - 1); ii++) {
            bytt = 0;
            if (sortvalue) {
              v1 = b[ii].querySelector(sortvalue).innerText;
              v2 = b[ii + 1].querySelector(sortvalue).innerText;
            } else {
              v1 = b[ii].innerText;
              v2 = b[ii + 1].innerText;
            }
            v1 = v1.toLowerCase();
            v2 = v2.toLowerCase();
            if ((j == 0 && (v1 > v2)) || (j == 1 && (v1 < v2))) {
              bytt = 1;
              break;
            }
          }
          if (bytt == 1) {
            b[ii].parentNode.insertBefore(b[ii + 1], b[ii]);
            y = 1;
            cc++;
          }
        }
        if (cc > 0) {break;}
      }
    }
  };

//------------------------
  //Department Account
  let cltid = "#CodeTable2";
    let cltid2 = "#CodeTable";
    let clheaders = document.querySelectorAll(cltid2 + " th");

      // Sort the table element when clicking on the table headers
      clheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(cltid, ".clsclid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function CodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("codesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("CodeTable2");
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

  function NameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("namesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("CodeTable2");
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

  $('#txtdepartment').on('click',function(event){
    showSelectedCheck($("#DEPID_REF").val(),"SELECT_DEPID_REF");
    $("#depidpopup").show();    
    event.preventDefault();
  });

  $("#dep_closePopup").click(function(event){
    $("#depidpopup").hide();
    event.preventDefault();
  });

  $(".clsdepid").click(function(){
        var fieldid = $(this).attr('id');
        var txtval =    $("#txt"+fieldid+"").val();
        var texdesc =   $("#txt"+fieldid+"").data("desc")+'-'+$("#txt"+fieldid+"").data("desc2"); 
        $('#txtdepartment').val(texdesc);
        $('#DEPID_REF').val(txtval);
        $("#depidpopup").hide();
        $("#codesearch").val(''); 
        $("#namesearch").val(''); 
        CodeFunction();
        event.preventDefault();
    });
  //Department Account Ends
//------------------------

//------------------------
   // START VENDOR CODE FUNCTION
let vendor_tid = "#VendorCodeTable2";
let vendor_tid2 = "#VendorCodeTable";
let vendor_headers = document.querySelectorAll(vendor_tid2 + " th");

      
vendor_headers.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(vendor_tid, ".clsvendorid", "td:nth-child(" + (i + 1) + ")");
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
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url:'{{route("transaction",[$FormId,"getVendor"])}}',
    type:'POST',
    data:{'CODE':CODE,'NAME':NAME},
    success:function(data) {
      $("#tbody_vendor").html(data); 
      bindVendorEvents();
      showSelectedCheck($("#VID_REF").val(),"SELECT_VID_REF"); 
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

  $("#vendoridpopup").show();
  event.preventDefault();
});

$("#vendor_close_popup").click(function(event){
  $("#vendoridpopup").hide();
  event.preventDefault();
}); 


function bindVendorEvents(){

  $(".clsvendorid").click(function(){
        var fieldid = $(this).attr('id');
        var txtval =    $("#txt"+fieldid+"").val();
        var texdesc =   $("#txt"+fieldid+"").data("desc")+'-'+$("#txt"+fieldid+"").data("desc2"); 
        var oldVID_REF =   $("#VID_REF").val();
        var MaterialClone = $('#hdnMaterial').val();   
        var TDSClone = $('#hdnTDS').val();   
        var TNCClone = $('#hdnTNC').val();   
        var CalculationClone = $('#hdnCalculation').val();   
        var PaymentClone = $('#hdnPayment').val();   
        $('#txtvendor').val(texdesc);
        $('#VID_REF').val(txtval);
        if (txtval != oldVID_REF)
        {            
            $('#tot_amt').val('0.00');
            $('#Material').html(MaterialClone);
            var count11 = <?php echo json_encode($objCount1); ?>;
              $('#Row_Count1').val('1');
              $('#Material').find('.participantRow').each(function(){
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
              $('#Row_Count4').val('1');
              $('#TDS').find('.participantRow7').each(function(){
                $(this).find('input:text').val('');
                $(this).find('input:hidden').val('');
                $(this).find('input:checkbox').removeAttr('checked');
                var rowcount = $('#Row_Count4').val();
                if(rowcount > 1)
                {
                  $(this).closest('.participantRow7').remove();
                  rowcount = parseInt(rowcount) - 1;
                  $('#Row_Count4').val(rowcount);
                }
              });
              $('#TC').html(TNCClone);
              var count22 = <?php echo json_encode($objCount2); ?>;
              $('#Row_Count2').val('1');
              $('#txtTNCID_popup').val('');
              $('#TNCID_REF').val('');
              $('#TC').find('.participantRow3').each(function(){
                $(this).find('input:text').val('');
                $(this).find('input:hidden').val('');
                var rowcount = $('#Row_Count2').val();
                if(rowcount > 1)
                {
                  $(this).closest('.participantRow3').remove();
                  rowcount = parseInt(rowcount) - 1;
                  $('#Row_Count2').val(rowcount);
                }
              });
              $('#CT').html(CalculationClone);
              var count33 = <?php echo json_encode($objCount3); ?>;
              $('#Row_Count3').val('1');
              $('#txtCTID_popup').val('');
              $('#CTID_REF').val('');
              $('#CT').find('.participantRow5').each(function(){
                $(this).find('input:text').val('');
                $(this).find('input:hidden').val('');
                $(this).find('input:checkbox').removeAttr('checked');
                var rowcount = $('#Row_Count3').val();
                if(rowcount > 1)
                {
                  $(this).closest('.participantRow5').remove();
                  rowcount = parseInt(rowcount) - 1;
                  $('#Row_Count3').val(rowcount);
                }
              });
              $('#PaymentSlabs').html(PaymentClone);
              var count55 = <?php echo json_encode($objCount5); ?>;
              $('#Row_Count5').val('1');
              $('#PaymentSlabs').find('.participantRow6').each(function(){
                $(this).find('input:text').val('');
                $(this).find('input:hidden').val('');
                var rowcount = $('#Row_Count5').val();
                if(rowcount > 1)
                {
                  $(this).closest('.participantRow6').remove();
                  rowcount = parseInt(rowcount) - 1;
                  $('#Row_Count5').val(rowcount);
                }
              });
            $('#Row_Count1').val('1');
            $('#Row_Count2').val('1');
            $('#Row_Count3').val('1');
            $('#Row_Count4').val('1');
            $('#Row_Count5').val('1');
        }
        $("#vendoridpopup").hide();
        $("#vendorcodesearch").val(''); 
        $("#vendornamesearch").val(''); 
       
        var customid = txtval;
              if(customid!=''){
                $("#Credit_days").val('');
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getcreditdays"])}}',
                      type:'POST',
                      data:{'id':customid},
                      success:function(data) {
                        $("#Credit_days").val(data);     
                        
                        var d = data; 
                        d = parseInt(d) - 1;
                        var pdate =$('#PB_DOCDT').val();
                        var ddate = new Date(pdate);
                        var newddate = new Date(ddate);
                        newddate.setDate(newddate.getDate() + d);
                        var piddate = newddate.getFullYear() + "-" + ("0" + (newddate.getMonth() + 1)).slice(-2) + "-" + ('0' + newddate.getDate()).slice(-2) ;
                        $("#DUE_DATE").val(piddate);
                        
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#Credit_days").val('');   
                        $("#DUE_DATE").val('');                      
                      },
                  }); 
                $("#txtBILLTO").val('');
                $("#BILLTO").val('');
                $("#txtBILLTO1").val('');
                $("#BILLTO1").val('');
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getBillTo"])}}',
                      type:'POST',
                      data:{'id':customid},
                      success:function(data) {
                        $("#txtBILLTO1").hide();
                        $("#div_billto").html(data);
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#txtBILLTO").hide();
                        $("#txtBILLTO1").show();
                      },
                  });  

                $("#txtSHIPTO").val('');
                $("#SHIPTO").val('');
                $("#txtSHIPTO1").val('');
                $("#SHIPTO1").val('');
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getShipTo"])}}',
                      type:'POST',
                      data:{'id':customid},
                      success:function(data) {
                        $("#txtSHIPTO1").hide();
                        $("#div_shipto").html(data);
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#txtSHIPTO").hide();
                        $("#txtSHIPTO1").show();
                      },
                  });  
                  $("#tbody_BillTo").html('');
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getBillAddress"])}}',
                      type:'POST',
                      data:{'id':customid},
                      success:function(data) {
                        $("#tbody_BillTo").html(data);
                        BindBillAddress();
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#tbody_BillTo").html('');
                      },
                  });   
                  $("#tbody_ShipTo").html('');
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getShipAddress"])}}',
                      type:'POST',
                      data:{'id':customid},
                      success:function(data) {
                        $("#tbody_ShipTo").html(data);       
                        BindShipAddress();                 
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#tbody_ShipTo").html('');
                      },
                  });  
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getTDSApplicability"])}}',
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
                                  url:'{{route("transaction",[$FormId,"getTDSDetails"])}}',
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

                  getTaxStatus(customid); 
                  
              }
              event.preventDefault();
    });

}


  
  //Vendor Account Ends
//------------------------

//------------------------
  //Goods Receipt Note Dropdown
  let grntid = "#GRNTable2";
      let grntid2 = "#GRNTable";
      let GRNheaders = document.querySelectorAll(grntid2 + " th");

      // Sort the table element when clicking on the table headers
      GRNheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(grntid, ".clsgrnid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function GRNCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("GRNcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("GRNTable2");
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

  function GRNNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("GRNnamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("GRNTable2");
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

  $('#Material').on('click','[id*="txtGRN_NO_"]',function(event){
    var customid = $('#VID_REF').val();
    var fieldid = $(this).parent().parent().find('[id*="GRN_ID"]').attr('id');

    $("#tbody_GRN").html('');
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      })
      $.ajax({
          url:'{{route("transaction",[$FormId,"getgoodsreceiptnote"])}}',
          type:'POST',
          data:{'id':customid,'fieldid':fieldid},
          success:function(data) {
            $("#tbody_GRN").html(data);
            BindGoodsReceiptNote();
            showSelectedCheck($("#"+fieldid).val(),"SELECT_"+fieldid);
          },
          error:function(data){
            console.log("Error: Something went wrong.");
            $("#tbody_GRN").html('');
          },
      });

      $("#GRNpopup").show();
      var id = $(this).attr('id');
      var id2 = $(this).parent().parent().find('[id*="GRN_ID"]').attr('id');

      $('#hdn_GRN').val(id);
      $('#hdn_GRN2').val(id2);
    });

    $("#GRN_closePopup").click(function(event){
      $("#GRNpopup").hide();
    });
      
    function BindGoodsReceiptNote(){
      $(".clsgrnid").click(function(){
        var fieldid = $(this).attr('id');
        var txtval =    $("#txt"+fieldid+"").val();
        var texdesc =   $("#txt"+fieldid+"").data("desc");
        var texgeid =   $("#txt"+fieldid+"").data("desc1");
        
        var txtid= $('#hdn_GRN').val();
        var txt_id2= $('#hdn_GRN2').val();

        $('#'+txtid).val(texdesc);
        $('#'+txt_id2).val(txtval);

        var CheckExist  = []; 
    $('#Material').find('.participantRow').each(function(){
      var DATA_ID  = $.trim($(this).find('[id*="GRN_ID"]').val());

      if(DATA_ID !=""){
        CheckExist.push(DATA_ID);
      }
    });

    if(CheckExist.length ==0){
      $('#'+txtid).val(texdesc);
      $('#'+txt_id2).val(txtval);
      getGeDetails(texgeid);
    }
    else if(arrayUnique(CheckExist) ==true){
      $('#'+txtid).val(texdesc);
      $('#'+txt_id2).val(txtval);
      getGeDetails(texgeid);
    }
    else{
      $('#'+txtid).val('');
      $('#'+txt_id2).val('');
      $("#alert").modal('show');
      $("#AlertMessage").text('Please Select Same GRN No In All Row.');
      $("#YesBtn").hide(); 
      $("#NoBtn").hide();  
      $("#OkBtn1").show();
      $("#OkBtn1").focus();
      highlighFocusBtn('activeOk');
    }


        $("#GRNpopup").hide();
        
        $("#GRNcodesearch").val(''); 
        $("#GRNnamesearch").val(''); 
     
        event.preventDefault();
      });
    }

    function arrayUnique(array){
    function onlyUnique(value, index, self) { 
         return self.indexOf(value) === index;
    }

    var unique = array.filter( onlyUnique );

    return (unique.length == 1);
}

function getGeDetails(id){

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
      url:'{{route("transaction",[$FormId,"getGeDetails"])}}',
      type:'POST',
      data:{'id':id},
      success:function(data) {
        
        $('#VENDOR_INNO').val(data.VENDOR_BILLNO);
        $('#VENDOR_INDT').val(data.VENDOR_BILLDT);
      },
      error:function(data){
        console.log("Error: Something went wrong.");
        $('#VENDOR_INNO').val('');
        $('#VENDOR_INDT').val('');
      },
  });
} 

      

  //Goods Receipt Note Dropdown Ends
//------------------------

//------------------------
  //Bill Address
  let billtoid = "#BillToTable2";
      let billtoid2 = "#BillToTable";
      let billtoheaders = document.querySelectorAll(billtoid2 + " th");

      // Sort the table element when clicking on the table headers
      billtoheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(billtoid, ".clsbillto", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function BillToCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("BillTocodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("BillToTable2");
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

  function BillToNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("BillTonamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("BillToTable2");
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
  $('#div_billto').on('click','#txtBILLTO',function(event){
        
          var customid = $('#VID_REF').val();
              if(customid!=''){
                $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $("#tbody_BillTo").html('');
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getBillAddress"])}}',
                      type:'POST',
                      data:{'id':customid},
                      success:function(data) {
                        $("#tbody_BillTo").html(data);
                        BindBillAddress();
                        showSelectedCheck($("#BILLTO").val(),"SELECT_BILLTO");
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#tbody_BillTo").html('');
                      },
                  }); 
              }
         $("#BillTopopup").show();
         event.preventDefault();
      });

      $("#BillToclosePopup").click(function(event){
        $("#BillTopopup").hide();
        event.preventDefault();
      });

      function BindBillAddress(){
        $(".clsbillto").click(function(){
          var fieldid = $(this).attr('id');
          var txtval =    $("#txt"+fieldid+"").val();
          var texdesc =   $("#txt"+fieldid+"").data("desc");
          $('#txtBILLTO').val(texdesc);
          $('#BILLTO').val(txtval);
          $("#BillTopopup").hide();
          $("#BillTocodesearch").val(''); 
          $("#BillTonamesearch").val(''); 
              
          event.preventDefault();
        });
      }
  //Bill Address Ends
//------------------------

//------------------------
  //Ship Address
  let shiptoid = "#ShipToTable2";
      let shiptoid2 = "#ShipToTable";
      let shiptoheaders = document.querySelectorAll(shiptoid2 + " th");

      // Sort the table element when clicking on the table headers
      shiptoheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(shiptoid, ".clsshipto", "td:nth-child(" + (i + 1) + ")");
        });
      });

  function ShipToCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ShipTocodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ShipToTable2");
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

  function ShipToNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ShipTonamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ShipToTable2");
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

  $('#div_shipto').on('click','#txtSHIPTO',function(event){

    var customid = $('#VID_REF').val();
              if(customid!=''){
                $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });  
                  $("#tbody_ShipTo").html('');
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getShipAddress"])}}',
                      type:'POST',
                      data:{'id':customid},
                      success:function(data) {
                        $("#tbody_ShipTo").html(data);       
                        BindShipAddress(); 
                        showSelectedCheck($("#SHIPTO").val(),"SELECT_SHIPTO");                
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#tbody_ShipTo").html('');
                      },
                  }); 
              }

         $("#ShipTopopup").show();
         event.preventDefault();
      });

      $("#ShipToclosePopup").click(function(event){
        $("#ShipTopopup").hide();
        event.preventDefault();
      });

      function BindShipAddress(){
        $(".clsshipto").click(function(){
          var fieldid = $(this).attr('id');
          var txtval =    $("#txt"+fieldid+"").val();
          var texdesc =   $(this).children('[id*="txtshipadd"]').text();
          var taxstate =  $("#txt"+fieldid+"").data("desc");
          var oldShipto =   $("#SHIPTO").val();
          var MaterialClone = $('#hdnMaterial').val();   
          var TDSClone = $('#hdnTDS').val();   
          var TNCClone = $('#hdnTNC').val();   
          var CalculationClone = $('#hdnCalculation').val();   
          var PaymentClone = $('#hdnPayment').val();   

          if (txtval != oldShipto)
          {
            $('#Material').html(MaterialClone);
            $('#TDS').html(TDSClone);
            $('#TC').html(TNCClone);
            $('#CT').html(CalculationClone);
            $('#PaymentSlabs').html(PaymentClone);
            $('#tot_amt').val('0.00');
            $('#Row_Count1').val('1');
            $('#Row_Count2').val('1');
            $('#Row_Count3').val('1');
            $('#Row_Count4').val('1');
            $('#Row_Count5').val('1');
          }
          $('#txtSHIPTO').val(texdesc);
          $('#SHIPTO').val(txtval);
          $('#Tax_State').val(taxstate);
          $("#ShipTopopup").hide();
          $("#ShipTocodesearch").val(''); 
          $("#ShipTonamesearch").val(''); 
           
          event.preventDefault();
        });
      }
  //Ship Address Ends
//------------------------

//------------------------
  //TNC Header
  let tnctid = "#TNCIDTable2";
      let tnctid2 = "#TNCIDTable";
      let tncheaders = document.querySelectorAll(tnctid2 + " th");

      // Sort the table element when clicking on the table headers
      tncheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(tnctid, ".clstncid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function TNCCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("TNCcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("TNCIDTable2");
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

  function TNCNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("TNCnamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("TNCIDTable2");
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
  $('#TC').on('click','#txtTNCID_popup',function(event){
    showSelectedCheck($("#TNCID_REF").val(),"SELECT_TNCID_REF");
         $("#TNCIDpopup").show();
         event.preventDefault();
      });

      $("#TNCID_closePopup").click(function(event){
        $("#TNCIDpopup").hide();
      });

      $(".clstncid").click(function(){
        var fieldid = $(this).attr('id');
        var txtval =    $("#txt"+fieldid+"").val();
        var texdesc =   $("#txt"+fieldid+"").data("desc");
        
        $('#txtTNCID_popup').val(texdesc);
        $('#TNCID_REF').val(txtval);
        $("#TNCIDpopup").hide();
        $("#TNCcodesearch").val(''); 
        $("#TNCnamesearch").val(''); 
       
        //sub GL
        var customid = txtval;
        if(customid!=''){
          
          $('#tbody_tncdetails').html('<tr><td colspan="2">Please wait..</td></tr>');
          // $('#tncbody').html('<tr><td colspan="2">Please wait..</td></tr>');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route("transaction",[$FormId,"gettncdetails2"])}}',
                type:'POST',
                data:{'id':customid},
                success:function(data) {
                    $('#tncbody').html(data);
                    bindTNCDetailsEvents();
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                  $('#tncbody').html('');
                },
            });            
            $.ajax({
                url:'{{route("transaction",[$FormId,"gettncdetails3"])}}',
                type:'POST',
                data:{'id':customid},
                success:function(data) {
                    $('#Row_Count2').val(data);
                    bindTNCDetailsEvents();
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                  $('#Row_Count2').val('0');
                },
            });
            $.ajax({
                url:'{{route("transaction",[$FormId,"gettncdetails"])}}',
                type:'POST',
                data:{'id':customid},
                success:function(data) {
                    $('#tbody_tncdetails').html(data);
                    bindTNCDetailsEvents();
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                  $('#tbody_tncdetails').html('');
                },
            });        
        }
        event.preventDefault();
      });

      

  //TNC Header Ends
//------------------------

//TNC Details Starts
//------------------------

      let tncdettid = "#TNCDetTable2";
      let tncdettid2 = "#TNCDetTable";
      let tncdetheaders = document.querySelectorAll(tncdettid2 + " th");

      // Sort the table element when clicking on the table headers
      tncdetheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(tncdettid, ".clstncdet", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function TNCDetCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("tncdetcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("TNCDetTable2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
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

  function TNCDetNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("tncdetnamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("TNCDetTable2");
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
// $('#TC').on('click','[id*="popupTNCDID"]',function(){
//      $("#tncdetpopup").show();
//      $('#hdn_tncdet').val($(this).attr('id'));
//      event.preventDefault();
//   });

$("#tncdet_closePopup").on("click",function(event){ 
     $("#tncdetpopup").hide();
});

function bindTNCDetailsEvents(){
        $('.clstncdet').dblclick(function(){
    
            var id = $(this).attr('id');
            var txtid =    $("#txt"+id+"").val();
            var txtname =   $("#txt"+id+"").data("desc");
            var fieldid2 = $(this).find('[id*="tncvalue"]').attr('id');
            var txtvaluetype = $.trim($(this).find('[id*="tncvalue"]').text());
            var txtismandatory =  $("#txt"+fieldid2+"").val();
            var txtdescription =  $("#txt"+fieldid2+"").data("desc");
            
            var txtcol = $('#hdn_tncdet').val();
            $("#"+txtcol).val(txtname);
            $("#"+txtcol).parent().parent().find("[id*='TNCDID_REF']").val(txtid);
            $("#"+txtcol).parent().parent().find("[id*='TNCismandatory']").val(txtismandatory);
            
            var txt_id4 = $("#"+txtcol).parent().parent().find("[id*='tdinputid']").attr('id');  //<td> id 

            var strdyn = txt_id4.split('_');
            var lastele =   strdyn[strdyn.length-1];

            var dynamicid = "tncdetvalue_"+lastele;

            var chkvaltype =  txtvaluetype.toLowerCase();
            var strinp = '';

            if(chkvaltype=='date'){

              strinp = '<input type="date" placeholder="dd/mm/yyyy" name="'+dynamicid+ '" id="'+dynamicid+'" class="form-control" /> ';       

            }else if(chkvaltype=='time'){
              strinp= '<input type="time" placeholder="h:i" name="'+dynamicid+ '" id="'+dynamicid+'" class="form-control" /> ';

            }else if(chkvaltype=='numeric'){
              strinp = '<input type="text" name="'+dynamicid+ '" id="'+dynamicid+'" class="form-control" /> ';

            }else if(chkvaltype=='text'){

              strinp = '<input type="text" name="'+dynamicid+ '" id="'+dynamicid+'" class="form-control" /> ';
            
            }else if(chkvaltype=='boolean'){

              strinp = '<input type="checkbox" name="'+dynamicid+ '" id="'+dynamicid+'" class="" /> ';
            
            }else if(chkvaltype=='combobox'){
              if(txtdescription !== undefined)
              {
                var strarray = txtdescription.split(',');
                
                var opts = '';

                for (var i = 0; i < strarray.length; i++) {
                  opts = opts + '<option value="'+strarray[i]+'">'+strarray[i]+'</option> ';
                }

                strinp = '<select name="'+dynamicid+ '" id="'+dynamicid+'" class="form-control" required>'+opts+'</select>' ;
              }
            }

            $('#'+txt_id4).html('');  
            $('#'+txt_id4).html(strinp);   //set dynamic input

            $("#tncdetpopup").hide();
            $("#tncdetcodesearch").val(''); 
            $("#tncdetnamesearch").val(''); 
           
            event.preventDefault();
            
        });
  }
//TNC Details Ends
//------------------------

//------------------------
  //Calculation Header
  let cttid = "#CTIDTable2";
      let cttid2 = "#CTIDTable";
      let ctheaders = document.querySelectorAll(cttid2 + " th");

      // Sort the table element when clicking on the table headers
      ctheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(cttid, ".clsctid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function CTIDCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("CTIDcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("CTIDTable2");
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

  function CTIDNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("CTIDnamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("CTIDTable2");
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
  $('#CT').on('click','#txtCTID_popup',function(event){
    showSelectedCheck($("#CTID_REF").val(),"SELECT_CTID_REF");
         $("#CTIDpopup").show();
         event.preventDefault();
      });

      $("#CTID_closePopup").click(function(event){
        $("#CTIDpopup").hide();
      });

      $(".clsctid").click(function(){
        var fieldid = $(this).attr('id');
        var txtval =    $("#txt"+fieldid+"").val();
        var texdesc =   $("#txt"+fieldid+"").data("desc");
        // var txtid= $('#hdn_fieldid').val();
        // var txt_id2= $('#hdn_fieldid2').val();
        
        $('#txtCTID_popup').val(texdesc);
        $('#CTID_REF').val(txtval);
        $("#CTIDpopup").hide();
        $("#CTIDcodesearch").val(''); 
        $("#CTIDnamesearch").val(''); 
       
        //Details
        var customid = txtval;
        if(customid!=''){
          
          $('#tbody_ctiddetails').html('<tr><td colspan="2">Please wait..</td></tr>');
          $('#tbody_ctid').html('<tr><td colspan="2">Please wait..</td></tr>');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route("transaction",[$FormId,"getcalculationdetails2"])}}',
                type:'POST',
                data:{'id':customid},
                success:function(data) {
                    $('#tbody_ctid').html(data);
                    bindCTIDDetailsEvents();
                    bindGSTCalTemplate();
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                  $('#tbody_ctid').html('');
                },
            });
            $.ajax({
                url:'{{route("transaction",[$FormId,"getcalculationdetails3"])}}',
                type:'POST',
                data:{'id':customid},
                success:function(data) {
                  $('#Row_Count3').val(data);
                    bindCTIDDetailsEvents();
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                  $('#Row_Count3').val('0');
                },
            });
            $.ajax({
                url:'{{route("transaction",[$FormId,"getcalculationdetails"])}}',
                type:'POST',
                data:{'id':customid},
                success:function(data) {
                    $('#tbody_ctiddetails').html(data);
                    bindCTIDDetailsEvents();
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                  $('#tbody_ctiddetails').html('');
                },
            }); 
              
        }
        event.preventDefault();
      });
      

  //Calculation Header Ends
//------------------------

//Calculation Details Starts
//------------------------

      let ctiddettid = "#CTIDDetTable2";
      let ctiddettid2 = "#CTIDDetTable";
      let ctiddetheaders = document.querySelectorAll(ctiddettid2 + " th");

      // Sort the table element when clicking on the table headers
      ctiddetheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(ctiddettid, ".clsctiddet", "td:nth-child(" + (i + 1) + ")");
        });
      });

    function CTIDDetCodeFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("CTIDdetcodesearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("CTIDDetTable2");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
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

    function CTIDDetNameFunction() {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById("CTIDdetnamesearch");
          filter = input.value.toUpperCase();
          table = document.getElementById("CTIDDetTable2");
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
    function CTIDDetRateFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("CTIDdetratesearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("CTIDDetTable2");
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

    function CTIDDetAmountFunction() {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById("CTIDdetamountsearch");
          filter = input.value.toUpperCase();
          table = document.getElementById("CTIDDetTable2");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
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
    function CTIDDetFormulaFunction() {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById("CTIDdetformulasearch");
          filter = input.value.toUpperCase();
          table = document.getElementById("CTIDDetTable2");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[4];
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


$("#ctiddet_closePopup").on("click",function(event){ 
     $("#ctiddetpopup").hide();
});

function bindCTIDDetailsEvents(){
        $('.clsctiddet').dblclick(function(){    
            var id = $(this).attr('id');
            var txtid =    $("#txt"+id+"").val();
            var txtname =   $("#txt"+id+"").data("desc");
            var fieldid2 = $(this).find('[id*="ctidbasis"]').attr('id');
            var txtbasis = $.trim($(this).find('[id*="ctidbasis"]').text());
            var txtactual =  $("#txt"+fieldid2+"").val();
            var txtgst =  $("#txt"+fieldid2+"").data("desc");
            var fieldid3 = $(this).find('[id*="ctidformula_"]').attr('id');
            var txtrate = $.trim($(this).find('[id*="ctidformula_"]').text());
            var txtsqno =  $("#txt"+fieldid3+"").val();
            var txtformula =  $("#txt"+fieldid3+"").data("desc");
            var txtamount = $.trim($(this).find('[id*="ctidamount_"]').text());
            var txtcol = $('#hdn_ctiddet').val();
            if(intRegex.test(txtrate)){
              txtrate = (txtrate +'.00');
            }
            $("#"+txtcol).val(txtname);
            $("#"+txtcol).parent().parent().find("[id*='TID_REF']").val(txtid);
            $("#"+txtcol).parent().parent().find("[id*='RATE']").val(txtrate);
            $("#"+txtcol).parent().parent().find("[id*='BASIS']").val(txtbasis);
            
            $("#"+txtcol).parent().parent().find("[id*='FORMULA']").val(txtformula);
            $("#"+txtcol).parent().parent().find("[id*='SQNO']").val(txtsqno); 

            if(txtactual == 1)
            {
              $("#"+txtcol).parent().parent().find("[id*='ACTUAL']").prop('checked','true');
            }     
            else
            {
              $("#"+txtcol).parent().parent().find("[id*='ACTUAL']").removeAttr('checked');
            }  

            if(txtgst == 1)
            {
              $("#"+txtcol).parent().parent().find("[id*='calGST']").prop('checked','true');
              $("#"+txtcol).parent().parent().find("[id*='calIGST']").removeAttr('readonly');
              $("#"+txtcol).parent().parent().find("[id*='AMTIGST']").removeAttr('readonly');
              $("#"+txtcol).parent().parent().find("[id*='calCGST']").removeAttr('readonly');
              $("#"+txtcol).parent().parent().find("[id*='calSGST']").removeAttr('readonly');
              $("#"+txtcol).parent().parent().find("[id*='AMTCGST']").removeAttr('readonly');
              $("#"+txtcol).parent().parent().find("[id*='AMTSGST']").removeAttr('readonly');
            }     
            else
            {
              $("#"+txtcol).parent().parent().find("[id*='calGST']").removeAttr('checked');
            } 

            var totaltaxableamount = 0;
            $('#Material').find('.participantRow').each(function()
              {
                var amount1 = $(this).find('[id*="TAX_AMT_"]').val();

                totaltaxableamount += parseFloat(amount1);
              });
            if(txtrate > 0)
            {
              txtamount = 0;
              txtamount = parseFloat((totaltaxableamount*txtrate)/100).toFixed(2);
              if(intRegex.test(txtamount)){
              txtamount = (txtamount +'.00');
              }
              $("#"+txtcol).parent().parent().find("[id*='VALUE']").val(txtamount);
            }
            else
            {
              if(intRegex.test(txtamount)){
              txtamount = (txtamount +'.00');
              }
              $("#"+txtcol).parent().parent().find("[id*='VALUE']").val(txtamount);
            }
            
            $("#ctiddetpopup").hide();
            $("#CTIDdetcodesearch").val(''); 
            $("#CTIDdetnamesearch").val(''); 
            $("#CTIDdetratesearch").val(''); 
            $("#CTIDdetamountsearch").val(''); 
            $("#CTIDdetformulasearch").val(''); 
         
            event.preventDefault();
            
        });
  }
//Calculation Details Ends
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
          td = tr[i].getElementsByTagName("td")[0];
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

  $('#Material').on('click','[id*="txtHSN"]',function(event){
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
  
  $(".clshsnid").dblclick(function(){
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
      hsnCodeFunction(); 
      var taxstate = $('#Tax_State').val();     
      var customid = txtid;
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
        $.ajax({
              url:'{{route("transaction",[$FormId,"gettaxCode"])}}',
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
              url:'{{route("transaction",[$FormId,"gettax"])}}',
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
                          url:'{{route("transaction",[$FormId,"gettax2"])}}',
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
    $('#Material').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TT_AMT"]').val() != '')
        {
          var ttamt21 = $(this).find('[id*="TT_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(ttamt21)).toFixed(2);
        }
    });

    $('#TC').find('.participantRow3').each(function()
    {
        if($(this).find('[id*="TOT_TD_AMT"]').val() != '')
        {
          var tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(tttdsamt21)).toFixed(2);
        }
    });
    $('#tot_amt').val(totalamount);
              
      event.preventDefault();
  });
  //HSN Account Ends
//------------------------
//------------------------
  //Item ID Dropdown
  let itemtid = "#ItemIDTable2";
      let itemtid2 = "#ItemIDTable";
      let itemtidheaders = document.querySelectorAll(itemtid2 + " th");

      // Sort the table element when clicking on the table headers
      itemtidheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(itemtid, ".clsitemid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function ItemCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("Itemcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
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

      function ItemNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("Itemnamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
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

      function ItemUOMFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ItemUOMsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[3];
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
      function ItemQTYFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ItemQTYsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[4];
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

      function ItemGroupFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ItemGroupsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[5];
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

      function ItemCategoryFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ItemCategorysearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[6];
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

      function ItemBUFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ItemBUsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[7];
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

      function ItemAPNFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ItemAPNsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[8];
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

      function ItemCPNFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ItemCPNsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[9];
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

      function ItemOEMPNFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ItemOEMPNsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[10];
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

      function ItemStatusFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ItemStatussearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("ItemIDTable2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[11];
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

  $('#Material').on('click','[id*="txtItem"]',function(event){
        var GRNID = $(this).parent().parent().find('[id*="GRN_ID_"]').val();
        var taxstate = $.trim($('#Tax_State').val());
        var vendorid = $.trim($('#VID_REF').val());
        if(GRNID!=''){
                $("#tbody_ItemID").html('');
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getItemDetailsGRNwise"])}}',
                      type:'POST',
                      data:{'id':GRNID, 'taxstate':taxstate, 'vendorid':vendorid},
                      success:function(data) {
                        $("#tbody_ItemID").html(data);   
                        bindItemEvents();                     
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#tbody_ItemID").html('');                        
                      },
                  }); 

                  $("#ITEMIDpopup").show();
        }

        
        var id = $(this).attr('id');
        var id2 = $(this).parent().parent().find('[id*="ITEMID_REF"]').attr('id');
        var id3 = $(this).parent().parent().find('[id*="ItemName"]').attr('id');
        var id4 = $(this).parent().parent().find('[id*="txtUOM"]').attr('id');
        var id5 = $(this).parent().parent().find('[id*="UOMID_REF_"]').attr('id');
        var id6 = $(this).parent().parent().find('[id*="RECEIVED_QTY_"]').attr('id');
        var id7 = $(this).parent().parent().find('[id*="txtALTUOM_"]').attr('id');
        var id8 = $(this).parent().parent().find('[id*="ALT_UOMID_REF_"]').attr('id');
        var id9 = $(this).parent().parent().find('[id*="RECEIVED_ALT_QTY_"]').attr('id');
        var id10 = $(this).parent().parent().find('[id*="BILL_QTY_"]').attr('id');
        var id11 = $(this).parent().parent().find('[id*="txtBILLUOM_"]').attr('id');
        var id12 = $(this).parent().parent().find('[id*="BILL_UOMID_REF_"]').attr('id');
        var id13 = $(this).parent().parent().find('[id*="ItemDesc_"]').attr('id');
        var id14 = $(this).parent().parent().find('[id*="BILL_RATEPUOM_"]').attr('id');
        var id15 = $(this).parent().parent().find('[id*="DISC_PER_"]').attr('id');
        var id16 = $(this).parent().parent().find('[id*="DISC_AMT_"]').attr('id');

        $('#hdn_ItemID').val(id);
        $('#hdn_ItemID2').val(id2);
        $('#hdn_ItemID3').val(id3);
        $('#hdn_ItemID4').val(id4);
        $('#hdn_ItemID5').val(id5);
        $('#hdn_ItemID6').val(id6);
        $('#hdn_ItemID7').val(id7);
        $('#hdn_ItemID8').val(id8);
        $('#hdn_ItemID9').val(id9);
        $('#hdn_ItemID10').val(id10);
        $('#hdn_ItemID11').val(id11);
        $('#hdn_ItemID12').val(id12);
        $('#hdn_ItemID13').val(id13);
        $('#hdn_ItemID14').val(id14);
        $('#hdn_ItemID15').val(id15);
        $('#hdn_ItemID16').val(id16);
        $('#hdn_ItemID17').val(GRNID);
        var r_count = 0;
        var GRNNO = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="ITEMID_REF"]').val() != '')
          {
            GRNNO.push($(this).find('[id*="GRN_ID_"]').val());
            r_count = parseInt(r_count)+1;
            $('#hdn_ItemID21').val(r_count);
          }
        });
        $('#hdn_ItemID18').val(GRNNO.join(', '));
        var ItemID = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="ITEMID_REF"]').val() != '')
          {
            ItemID.push($(this).find('[id*="ITEMID_REF"]').val());
          }
        });
        $('#hdn_ItemID19').val(ItemID.join(', '));
        var GEID = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="GEID_REF_"]').val() != '')
          {
            GEID.push($(this).find('[id*="GEID_REF_"]').val());
          }
        });
        $('#hdn_ItemID20').val(GEID.join(', '));
        var POID = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="POID_REF_"]').val() != '')
          {
            POID.push($(this).find('[id*="POID_REF_"]').val());
          }
        });
        $('#hdn_ItemID22').val(POID.join(', '));
        var IPOID = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="IPOID_REF_"]').val() != '')
          {
            IPOID.push($(this).find('[id*="IPOID_REF_"]').val());
          }
        });
        $('#hdn_ItemID23').val(IPOID.join(', '));
        var VQID = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="VQID_REF_"]').val() != '')
          {
            VQID.push($(this).find('[id*="VQID_REF_"]').val());
          }
        });
        $('#hdn_ItemID24').val(VQID.join(', '));
        var RFQID = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="RFQID_REF_"]').val() != '')
          {
            RFQID.push($(this).find('[id*="RFQID_REF_"]').val());
          }
        });
        $('#hdn_ItemID25').val(RFQID.join(', '));
        var PIID = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="PIID_REF_"]').val() != '')
          {
            PIID.push($(this).find('[id*="PIID_REF_"]').val());
          }
        });
        $('#hdn_ItemID26').val(PIID.join(', '));
        var MRSID = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="MRSID_REF_"]').val() != '')
          {
            MRSID.push($(this).find('[id*="MRSID_REF_"]').val());
          }
        });
        $('#hdn_ItemID27').val(MRSID.join(', '));
        event.preventDefault();
      });

      $("#ITEMID_closePopup").click(function(event){
        $("#ITEMIDpopup").hide();
        $('.js-selectall').prop("checked", false);
      });

function bindItemEvents(){

    $('#ItemIDTable2').off(); 
    $('.js-selectall').change(function(){
      var isChecked = $(this).prop("checked");
      var selector = $(this).data('target');
      $(selector).prop("checked", isChecked);
      
      
      $('#ItemIDTable2').find('.clsitemid').each(function(){
        var fieldid = $(this).attr('id');
        var txtval =   $("#txt"+fieldid+"").val();
        var txtcode =  $("#txt"+fieldid+"").data("desc");
        var fieldid2 = $(this).find('[id*="itemname"]').attr('id');
        var txtname =  $("#txt"+fieldid2+"").val();
        var txtspec =  $("#txt"+fieldid2+"").data("desc");
        var fieldid3 = $(this).find('[id*="itemuom"]').attr('id');
        var txtmuomid =  $("#txt"+fieldid3+"").val();
        var txtauom =  $("#txt"+fieldid3+"").data("desc");
        var txtmuom =  $(this).find('[id*="itemuom"]').text().trim();
        var fieldid4 = $(this).find('[id*="uomqty"]').attr('id');
        var txtauomid =  $("#txt"+fieldid4+"").val();
        var txtmuomqty =  $(this).find('[id*="uomqty"]').text().trim();
        var fieldid5 = $(this).find('[id*="irate"]').attr('id');
        var txtruom =  $("#txt"+fieldid5+"").val();
        var fieldid6 = $(this).find('[id*="itax"]').attr('id');
        var txttax2 =  $("#txt"+fieldid6+"").val();
        var txttax1 = $("#txt"+fieldid6+"").data("desc");
        var fieldid7 = $(this).find('[id*="ise"]').attr('id');
        var txtpoid = $("#txt"+fieldid7+"").val();
        var txtgeid = $("#txt"+fieldid7+"").data("desc");
        var txtmrsid = $("#txt"+fieldid7+"").data("desc1");
        var txtpiid = $("#txt"+fieldid7+"").data("desc2");
        var txtrfqid = $("#txt"+fieldid7+"").data("desc3");
        var txtvqid = $("#txt"+fieldid7+"").data("desc4");
        var txtipoid = $("#txt"+fieldid7+"").data("desc5");
        var rcount1 = parseInt($(this).closest('table').find('.clsitemid').length);
        var rcount2 = $('#hdn_ItemID21').val();
        var r_count2 = 0;

        var txtreceivedqtymu    =  $("#txt"+fieldid+"").data("desc1");
        var txtreceivedqtyau    =  $("#txt"+fieldid+"").data("desc2");
        if(intRegex.test(txtreceivedqtymu)){
          txtreceivedqtymu = (txtreceivedqtymu +'.000');
        }

        if(intRegex.test(txtreceivedqtyau)){
          txtreceivedqtyau = (txtreceivedqtyau +'.000');
        }

        if(txtpoid == undefined)
        {
          txtpoid = '';
        }
        if(txtgeid == undefined)
        {
          txtgeid = '';
        }
        var totalvalue = 0.00;
        var totalvalue2 = 0.00;
        var txttaxamt1 = 0.00;
        var txttaxamt2 = 0.00;
        var txttottaxamt = 0.00;
        var txttotamtatax =0.00;

        txtruom = parseFloat(txtruom).toFixed(5);

        var txtamt = parseFloat((parseFloat(txtreceivedqtymu)*parseFloat(txtruom))).toFixed(2);

        if(txttax1 == undefined || txttax1 == '')
        {
          txttax1     = 0.0000;
          txttaxamt1  = 0.00;
        }
        else
        {
          txttaxamt1 = parseFloat((parseFloat(txtamt)*parseFloat(txttax1))/100).toFixed(2);
        }
        if(txttax2 == undefined || txttax2 == '')
        {
          txttax2 = 0.0000;
          txttaxamt2 = 0.00;
        }
        else
        {
          txttaxamt2 = parseFloat((parseFloat(txtamt)*parseFloat(txttax2))/100).toFixed(2);
        }
        
        var txttottaxamt = parseFloat((parseFloat(txttaxamt1)+parseFloat(txttaxamt2))).toFixed(2);
        var txttotamtatax = parseFloat((parseFloat(txtamt)+parseFloat(txttottaxamt))).toFixed(2);

    
      // var intRegex = /^\d+$/;
      

      if(intRegex.test(txtruom)){
        txtruom = (txtruom +'.00000');
      }

      if(intRegex.test(txtamt)){
        txtamt = (txtamt +'.00');
      }

      if(intRegex.test(txttax1)){
        txttax1 = (txttax1 +'.0000');
      }
      if(intRegex.test(txttax2)){
        txttax2 = (txttax2 +'.0000');
      }
      if(intRegex.test(txttaxamt1)){
        txttaxamt1 = (txttaxamt1 +'.00');
      }
      if(intRegex.test(txttaxamt2)){
        txttaxamt2 = (txttaxamt2 +'.00');
      }

      if(intRegex.test(txttottaxamt)){
        txttottaxamt = (txttottaxamt +'.00');
      }
      if(intRegex.test(txttotamtatax)){
        txttotamtatax = (txttotamtatax +'.00');
      }

      var GRN2 = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="ITEMID_REF"]').val() != '')
          {
            var grnitem = $(this).find('[id*="GRN_ID_"]').val()+'-'+$(this).find('[id*="GEID_REF_"]').val()+'-'+$(this).find('[id*="POID_REF_"]').val()+'-'+$(this).find('[id*="MRSID_REF_"]').val()+'-'+$(this).find('[id*="PIID_REF_"]').val()+'-'+$(this).find('[id*="RFQID_REF_"]').val()+'-'+$(this).find('[id*="VQID_REF_"]').val()+'-'+$(this).find('[id*="IPOID_REF_"]').val()+'-'+$(this).find('[id*="ITEMID_REF"]').val();
            GRN2.push(grnitem);
            r_count2 = parseInt(r_count2) + 1;
          }
        });
      
      var GRNNOs =  $('#hdn_ItemID18').val();
      var itemids =  $('#hdn_ItemID19').val();
      var GEIDs =  $('#hdn_ItemID20').val();
      var POIDs =  $('#hdn_ItemID22').val();
      var GRNIDs =  $('#hdn_ItemID17').val();
      var IPOIDs =  $('#hdn_ItemID23').val();
      var VQIDs =  $('#hdn_ItemID24').val();
      var RFQIDs =  $('#hdn_ItemID25').val();
      var PIIDs =  $('#hdn_ItemID26').val();
      var MRSIDs =  $('#hdn_ItemID27').val();

          if($(this).find('[id*="chkId"]').is(":checked") == true) 
          {
            rcount1 = parseInt(rcount2)+parseInt(rcount1);
            if(parseInt(r_count2) >= parseInt(rcount1))
            {
                  $('#hdn_ItemID').val('');
                  $('#hdn_ItemID2').val('');
                  $('#hdn_ItemID3').val('');
                  $('#hdn_ItemID4').val('');
                  $('#hdn_ItemID5').val('');
                  $('#hdn_ItemID6').val('');
                  $('#hdn_ItemID7').val('');
                  $('#hdn_ItemID8').val('');
                  $('#hdn_ItemID9').val('');
                  $('#hdn_ItemID10').val('');
                  $('#hdn_ItemID11').val('');
                  $('#hdn_ItemID12').val('');
                  $('#hdn_ItemID13').val('');
                  $('#hdn_ItemID14').val('');
                  $('#hdn_ItemID15').val('');
                  $('#hdn_ItemID16').val('');
                  $('#hdn_ItemID17').val('');
                  $('#hdn_ItemID18').val('');
                  $('#hdn_ItemID19').val('');
                  $('#hdn_ItemID20').val('');
                  $('#hdn_ItemID22').val('');
                  $('#hdn_ItemID23').val('');
                  $('#hdn_ItemID24').val('');
                  $('#hdn_ItemID25').val('');
                  $('#hdn_ItemID26').val('');
                  $('#hdn_ItemID27').val('');
                  txtval = '';
                  txtcode = '';
                  txtname = '';
                  txtspec = '';
                  txtauom = '';
                  txtmuom = '';
                  txtmuomid = '';
                  txtauomid = '';
                  txtmuomqty='';
                  txtruom = '';
                  txtamt = '';
                  txttax1 = '';
                  txttax2 = '';
                  txtpoid = '';
                  txtgeid = '';
                  txtipoid = '';
                  txtvqid = '';
                  txtrfqid = '';
                  txtpiid = '';
                  txtmrsid = '';
                  txtreceivedqtymu = '';
                  txtreceivedqtyau = '';
                  $(".blurRate").blur();
                  $('.js-selectall').prop("checked", false);
                  return false;
                  event.preventDefault();
            }
            var txtgrnitem = GRNIDs+'-'+txtgeid+'-'+txtpoid+'-'+txtmrsid+'-'+txtpiid+'-'+txtrfqid+'-'+txtvqid+'-'+txtipoid+'-'+txtval;
            if(jQuery.inArray(txtgrnitem, GRN2) !== -1)
            {
                  $("#ITEMIDpopup").hide();
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn").hide();
                  $("#OkBtn1").show();
                  $("#AlertMessage").text('Item already exists.');
                  $("#alert").modal('show');
                  $("#OkBtn1").focus();
                  highlighFocusBtn('activeOk1');
                  $('#hdn_ItemID').val('');
                  $('#hdn_ItemID2').val('');
                  $('#hdn_ItemID3').val('');
                  $('#hdn_ItemID4').val('');
                  $('#hdn_ItemID5').val('');
                  $('#hdn_ItemID6').val('');
                  $('#hdn_ItemID7').val('');
                  $('#hdn_ItemID8').val('');
                  $('#hdn_ItemID9').val('');
                  $('#hdn_ItemID10').val('');
                  $('#hdn_ItemID11').val('');
                  $('#hdn_ItemID12').val('');
                  $('#hdn_ItemID13').val('');
                  $('#hdn_ItemID14').val('');
                  $('#hdn_ItemID15').val('');
                  $('#hdn_ItemID16').val('');
                  $('#hdn_ItemID17').val('');
                  $('#hdn_ItemID18').val('');
                  $('#hdn_ItemID19').val('');
                  $('#hdn_ItemID20').val('');
                  $('#hdn_ItemID22').val('');
                  $('#hdn_ItemID23').val('');
                  $('#hdn_ItemID24').val('');
                  $('#hdn_ItemID25').val('');
                  $('#hdn_ItemID26').val('');
                  $('#hdn_ItemID27').val('');
                  txtval = '';
                  txtcode = '';
                  txtname = '';
                  txtspec = '';
                  txtauom = '';
                  txtmuom = '';
                  txtmuomid = '';
                  txtauomid = '';
                  txtmuomqty='';
                  txtruom = '';
                  txtamt = '';
                  txttax1 = '';
                  txttax2 = '';
                  txtpoid = '';
                  txtgeid = '';
                  txtipoid = '';
                  txtvqid = '';
                  txtrfqid = '';
                  txtpiid = '';
                  txtmrsid = '';
                  txtreceivedqtymu = '';
                  txtreceivedqtyau = '';
                  $(".blurRate").blur();
                  $('.js-selectall').prop("checked", false);
                  return false;
                  event.preventDefault();
            }

            
                if($('#hdn_ItemID').val() == "" && txtval != '')
                {
                  var txtid= $('#hdn_ItemID').val();
                  var txt_id2= $('#hdn_ItemID2').val();
                  var txt_id3= $('#hdn_ItemID3').val();
                  var txt_id4= $('#hdn_ItemID4').val();
                  var txt_id5= $('#hdn_ItemID5').val();
                  var txt_id6= $('#hdn_ItemID6').val();
                  var txt_id7= $('#hdn_ItemID7').val();
                  var txt_id8= $('#hdn_ItemID8').val();
                  var txt_id9= $('#hdn_ItemID9').val();
                  var txt_id10= $('#hdn_ItemID10').val();
                  var txt_id11= $('#hdn_ItemID11').val();
                  var txt_id12= $('#hdn_ItemID12').val();
                  var txt_id13= $('#hdn_ItemID13').val();
                  var txt_id14= $('#hdn_ItemID14').val();
                  var txt_id15= $('#hdn_ItemID15').val();
                  var txt_id16= $('#hdn_ItemID16').val();

                  var $tr = $('.material').closest('table');
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
                      $clone.find('.remove').removeAttr('disabled'); 
                      $clone.find('[id*="txtItem"]').val(txtcode);
                      $clone.find('[id*="ITEMID_REF"]').val(txtval);
                      $clone.find('[id*="GEID_REF_"]').val(txtgeid);
                      $clone.find('[id*="POID_REF_"]').val(txtpoid);
                      $clone.find('[id*="IPOID_REF_"]').val(txtipoid);
                      $clone.find('[id*="VQID_REF_"]').val(txtvqid);
                      $clone.find('[id*="RFQID_REF_"]').val(txtrfqid);
                      $clone.find('[id*="PIID_REF_"]').val(txtpiid);
                      $clone.find('[id*="MRSID_REF_"]').val(txtmrsid);
                      $clone.find('[id*="ItemName"]').val(txtname);
                      $clone.find('[id*="ItemDesc"]').val(txtspec);
                      $clone.find('[id*="txtUOM_"]').val(txtmuom);
                      $clone.find('[id*="UOMID_REF_"]').val(txtmuomid);
                      $clone.find('[id*="RECEIVED_QTY_"]').val(txtreceivedqtymu);
                      $clone.find('[id*="txtALTUOM_"]').val(txtauom);
                      $clone.find('[id*="ALT_UOMID_REF_"]').val(txtauomid);
                      $clone.find('[id*="RECEIVED_ALT_QTY_"]').val(txtreceivedqtyau);
                      $clone.find('[id*="BILL_QTY_"]').val(txtreceivedqtymu);
                      $clone.find('[id*="txtBILLUOM_"]').val(txtmuom);
                      $clone.find('[id*="BILL_UOMID_REF_"]').val(txtmuomid);
                      $clone.find('[id*="BILL_RATEPUOM_"]').val(txtruom);
                      $clone.find('[id*="DISC_PER_"]').val('0.0000');
                      $clone.find('[id*="DISC_AMT_"]').val('0.00');
                      $clone.find('[id*="TAX_AMT_"]').val(txtamt);
                      $clone.find('[id*="TT_AMT_"]').val(txttotamtatax);
                      $clone.find('[id*="TGST_AMT_"]').val(txttottaxamt);
                      if($.trim($('#Tax_State').val()) == 'OutofState')
                      {                          
                        $clone.find('[id*="IGST_AMT_"]').val(txttaxamt1);
                        $clone.find('[id*="IGST_"]').val(txttax1);
                        $clone.find('[id*="SGST_"]').prop('disabled',true); 
                        $clone.find('[id*="CGST_"]').prop('disabled',true); 
                        $clone.find('[id*="SGST_AMT_"]').prop('disabled',true); 
                        $clone.find('[id*="CGST_AMT_"]').prop('disabled',true); 
                        $clone.find('[id*="SGST_AMT_"]').val('0.00');
                        $clone.find('[id*="CGST_AMT_"]').val('0.00');
                        $clone.find('[id*="SGST_"]').val('0.0000');
                        $clone.find('[id*="CGST_"]').val('0.0000');
                      }
                      else
                      {                          
                        $clone.find('[id*="CGST_AMT_"]').val(txttaxamt1);
                        $clone.find('[id*="SGST_AMT_"]').val(txttaxamt2);
                        $clone.find('[id*="IGST_AMT_"]').prop('disabled',true);                           
                        $clone.find('[id*="IGST_AMT_"]').val('0.00');
                        $clone.find('[id*="CGST_"]').val(txttax1);
                        $clone.find('[id*="IGST_"]').val('0.0000');
                        $clone.find('[id*="IGST_"]').prop('disabled',true); 
                        $clone.find('[id*="SGST_"]').val(txttax2);
                      }
                      
                      $tr.closest('table').append($clone);   
                      var rowCount = $('#Row_Count1').val();
                      rowCount = parseInt(rowCount)+1;
                      $('#Row_Count1').val(rowCount);
                      if($('#GST_Reverse').is(':checked') == true)
                      {
                        var tvalue2 = parseFloat(txtamt).toFixed(2);
                        totalvalue2 = $('#tot_amt').val();
                        totalvalue2 =  parseFloat(totalvalue2) + parseFloat(tvalue2);
                        totalvalue2 = parseFloat(totalvalue2).toFixed(2);
                        $('#tot_amt').val(totalvalue2);
                      }
                      else
                      {
                        var tvalue = parseFloat(txttotamtatax).toFixed(2);
                        totalvalue = $('#tot_amt').val();
                        totalvalue =  parseFloat(totalvalue) + parseFloat(tvalue);
                        totalvalue = parseFloat(totalvalue).toFixed(2);
                        $('#tot_amt').val(totalvalue);
                      }
                    $(".blurRate").blur();
                    // $("#ITEMIDpopup").hide();
                    event.preventDefault();
                }
                else
                {
                    var txtid= $('#hdn_ItemID').val();
                    var txt_id2= $('#hdn_ItemID2').val();
                    var txt_id3= $('#hdn_ItemID3').val();
                    var txt_id4= $('#hdn_ItemID4').val();
                    var txt_id5= $('#hdn_ItemID5').val();
                    var txt_id6= $('#hdn_ItemID6').val();
                    var txt_id7= $('#hdn_ItemID7').val();
                    var txt_id8= $('#hdn_ItemID8').val();
                    var txt_id9= $('#hdn_ItemID9').val();
                    var txt_id10= $('#hdn_ItemID10').val();
                    var txt_id11= $('#hdn_ItemID11').val();
                    var txt_id12= $('#hdn_ItemID12').val();
                    var txt_id13= $('#hdn_ItemID13').val();
                    var txt_id14= $('#hdn_ItemID14').val();
                    var txt_id15= $('#hdn_ItemID15').val();
                    var txt_id16= $('#hdn_ItemID16').val();
                    $('#'+txtid).val(txtcode);
                    $('#'+txt_id2).val(txtval);
                    $('#'+txt_id3).val(txtname);
                    $('#'+txt_id4).val(txtmuom);
                    $('#'+txt_id5).val(txtmuomid);
                    $('#'+txt_id6).val(txtreceivedqtymu);
                    $('#'+txt_id7).val(txtauom);
                    $('#'+txt_id8).val(txtauomid);
                    $('#'+txt_id9).val(txtreceivedqtyau);
                    $('#'+txt_id10).val(txtreceivedqtymu);
                    $('#'+txt_id11).val(txtmuom);
                    $('#'+txt_id12).val(txtmuomid);
                    $('#'+txt_id13).val(txtspec);
                    $('#'+txt_id14).val(txtruom);
                    $('#'+txt_id15).val('0.0000');
                    $('#'+txt_id16).val('0.00');
                    $('#'+txtid).parent().parent().find('[id*="GEID_REF_"]').val(txtgeid);
                    $('#'+txtid).parent().parent().find('[id*="POID_REF_"]').val(txtpoid);
                    $('#'+txtid).parent().parent().find('[id*="IPOID_REF_"]').val(txtipoid);
                    $('#'+txtid).parent().parent().find('[id*="VQID_REF_"]').val(txtvqid);
                    $('#'+txtid).parent().parent().find('[id*="RFQID_REF_"]').val(txtrfqid);
                    $('#'+txtid).parent().parent().find('[id*="PIID_REF_"]').val(txtpiid);
                    $('#'+txtid).parent().parent().find('[id*="MRSID_REF_"]').val(txtmrsid);
                    $('#'+txtid).parent().parent().find('[id*="TAX_AMT_"]').val(txtamt);
                    $('#'+txtid).parent().parent().find('[id*="TT_AMT_"]').val(txttotamtatax);
                    $('#'+txtid).parent().parent().find('[id*="TGST_AMT"]').val(txttottaxamt);
                    if($.trim($('#Tax_State').val()) == 'OutofState')
                      { 
                        $('#'+txtid).parent().parent().find('[id*="SGST_"]').val('0.0000');
                        $('#'+txtid).parent().parent().find('[id*="CGST_"]').val('0.0000');    
                        $('#'+txtid).parent().parent().find('[id*="IGST_"]').val(txttax1);                   
                        $('#'+txtid).parent().parent().find('[id*="IGST_AMT_"]').val(txttaxamt1);                          
                        $('#'+txtid).parent().parent().find('[id*="SGST_"]').prop('disabled',true); 
                        $('#'+txtid).parent().parent().find('[id*="CGST_"]').prop('disabled',true);
                        $('#'+txtid).parent().parent().find('[id*="SGST_AMT_"]').prop('disabled',true); 
                        $('#'+txtid).parent().parent().find('[id*="CGST_AMT_"]').prop('disabled',true);                           
                        $('#'+txtid).parent().parent().find('[id*="SGST_AMT_"]').val('0.00');
                        $('#'+txtid).parent().parent().find('[id*="CGST_AMT_"]').val('0.00');
                        
                      }
                      else
                      {   
                        $('#'+txtid).parent().parent().find('[id*="CGST_"]').val(txttax1);
                        $('#'+txtid).parent().parent().find('[id*="IGST_"]').prop('disabled',true); 
                        $('#'+txtid).parent().parent().find('[id*="IGST_AMT_"]').prop('disabled',true); 
                        $('#'+txtid).parent().parent().find('[id*="SGST_"]').val(txttax2);
                        $('#'+txtid).parent().parent().find('[id*="IGST_"]').val('0.0000');                       
                        $('#'+txtid).parent().parent().find('[id*="SGST_AMT_"]').val(txttaxamt2);
                        $('#'+txtid).parent().parent().find('[id*="CGST_AMT_"]').val(txttaxamt1);                          
                        $('#'+txtid).parent().parent().find('[id*="IGST_AMT_"]').val('0.00');
                      
                      }
                      if($('#GST_Reverse').is(':checked') == true)
                      {
                        var tvalue2 = parseFloat(txtamt).toFixed(2);
                        totalvalue2 = $('#tot_amt').val();
                        totalvalue2 =  parseFloat(totalvalue2) + parseFloat(tvalue2);
                        totalvalue2 = parseFloat(totalvalue2).toFixed(2);
                        $('#tot_amt').val(totalvalue2);
                      }
                      else
                      {
                        var tvalue = parseFloat(txttotamtatax).toFixed(2);
                        totalvalue = $('#tot_amt').val();
                        totalvalue =  parseFloat(totalvalue) + parseFloat(tvalue);
                        totalvalue = parseFloat(totalvalue).toFixed(2);
                        $('#tot_amt').val(totalvalue);
                      }
                    


                    // $("#ITEMIDpopup").hide();
                    $('#hdn_ItemID').val('');
                    $('#hdn_ItemID2').val('');
                    $('#hdn_ItemID3').val('');
                    $('#hdn_ItemID4').val('');
                    $('#hdn_ItemID5').val('');
                    $('#hdn_ItemID6').val('');
                    $('#hdn_ItemID7').val('');
                    $('#hdn_ItemID8').val('');
                    $('#hdn_ItemID9').val('');
                    $('#hdn_ItemID10').val('');
                    $('#hdn_ItemID11').val('');
                    $('#hdn_ItemID12').val('');
                    $('#hdn_ItemID13').val('');
                    $('#hdn_ItemID14').val('');
                    $('#hdn_ItemID15').val('');
                    $('#hdn_ItemID16').val('');
                    $('#hdn_ItemID17').val('');
                    $('#hdn_ItemID18').val('');
                    $('#hdn_ItemID19').val('');
                    $('#hdn_ItemID20').val('');
                    $('#hdn_ItemID22').val('');
                    $('#hdn_ItemID23').val('');
                    $('#hdn_ItemID24').val('');
                    $('#hdn_ItemID25').val('');
                    $('#hdn_ItemID26').val('');
                    $('#hdn_ItemID27').val('');

                    $(".blurRate").blur();
                    // $("#ITEMIDpopup").hide();
                    event.preventDefault();
                }
                
          }
          else if($(this).is(":checked") == false) 
          {
            var id = txtval;
            var geid = txtgeid;
            var poid = txtpoid;
            var ipoid = txtipoid;
            var vqid = txtvqid;
            var rfqid = txtrfqid;
            var piid = txtpiid;
            var mrsid = txtmrsid;
            var GRNIDs =  $('#hdn_ItemID17').val();
            var r_count = $('#Row_Count1').val();
            $('#Material').find('.participantRow').each(function()
            {
              var itemid = $(this).find('[id*="ITEMID_REF"]').val();
              var geid2 = $(this).find('[id*="GEID_REF"]').val();
              var poid2 = $(this).find('[id*="POID_REF"]').val();
              var ipoid2 = $(this).find('[id*="IPOID_REF"]').val();
              var vqid2 = $(this).find('[id*="VQID_REF"]').val();
              var rfqid2 = $(this).find('[id*="RFQID_REF"]').val();
              var piid2 = $(this).find('[id*="PIID_REF"]').val();
              var mrsid2 = $(this).find('[id*="MRSID_REF"]').val();
              var GRNID2 = $(this).find('[id*="GRN_ID_"]').val();
              if(id == itemid && geid == geid2 && poid == poid2 && GRNIDs == GRNID2 && ipoid == ipoid2&& vqid == vqid2&& rfqid == rfqid2&& piid == piid2 && mrsid == mrsid2)
              {
                  var rowCount = $('#Row_Count1').val();
                  if (rowCount > 1) {
                    var totalvalue = $('#TotalValue').val();
                    totalvalue = parseFloat(totalvalue - $(this).closest('.participantRow').find('[id*="TT_AMT_"]').val()).toFixed(2);
                    $('#TotalValue').val(totalvalue);
                    $(this).closest('.participantRow').remove(); 
                    rowCount = parseInt(rowCount)-1;
                  $('#Row_Count1').val(rowCount);
                  event.preventDefault();
                  }
                  else 
                  {
                    $(document).find('.dmaterial').prop('disabled', true);  
                    $("#ITEMIDpopup").hide();
                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn").hide();
                    $("#OkBtn1").show();
                    $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
                    $("#alert").modal('show');
                    $("#OkBtn1").focus();
                    highlighFocusBtn('activeOk1');
                    return false;
                    event.preventDefault();
                  }
                    event.preventDefault(); 
              }
            });

            $(".blurRate").blur();
            event.preventDefault();
          }
        $("#Itemcodesearch").val(''); 
        $("#Itemnamesearch").val(''); 
        $("#ItemUOMsearch").val(''); 
        $("#ItemGroupsearch").val(''); 
        $("#ItemCategorysearch").val(''); 
        $("#ItemStatussearch").val(''); 
        $('.remove').removeAttr('disabled'); 

        getActionEvent();
     
        event.preventDefault();
      });
      event.preventDefault();
    });

    $('[id*="chkId"]').change(function(){
      var fieldid = $(this).parent().parent().attr('id');       

      var txtval =   $("#txt"+fieldid+"").val();
      var txtcode =  $("#txt"+fieldid+"").data("desc");
      var fieldid2 = $(this).parent().parent().children('[id*="itemname"]').attr('id');
      var txtname =  $("#txt"+fieldid2+"").val();
      var txtspec =  $("#txt"+fieldid2+"").data("desc");
      var fieldid3 = $(this).parent().parent().children('[id*="itemuom"]').attr('id');
      var txtmuomid =  $("#txt"+fieldid3+"").val();
      var txtauom =  $("#txt"+fieldid3+"").data("desc");
      var txtmuom =  $(this).parent().parent().children('[id*="itemuom"]').text().trim();
      var fieldid4 = $(this).parent().parent().children('[id*="uomqty"]').attr('id');
      var txtauomid =  $("#txt"+fieldid4+"").val();
      var txtmuomqty =  $(this).parent().parent().children('[id*="uomqty"]').text().trim();
      var fieldid5 = $(this).parent().parent().children('[id*="irate"]').attr('id');
      var txtruom =  $("#txt"+fieldid5+"").val();
      var fieldid6 = $(this).parent().parent().children('[id*="itax"]').attr('id');
      var txttax2 =  $("#txt"+fieldid6+"").val();
      var txttax1 = $("#txt"+fieldid6+"").data("desc");
      var fieldid7 = $(this).parent().parent().children('[id*="ise"]').attr('id');
      var txtpoid = $("#txt"+fieldid7+"").val();
      var txtgeid = $("#txt"+fieldid7+"").data("desc");
      var txtmrsid = $("#txt"+fieldid7+"").data("desc1");
      var txtpiid = $("#txt"+fieldid7+"").data("desc2");
      var txtrfqid = $("#txt"+fieldid7+"").data("desc3");
      var txtvqid = $("#txt"+fieldid7+"").data("desc4");
      var txtipoid = $("#txt"+fieldid7+"").data("desc5");
      
      var txtreceivedqtymu    =  $("#txt"+fieldid+"").data("desc1");
      var txtreceivedqtyau    =  $("#txt"+fieldid+"").data("desc2");
      var r_count2 = 0;
      if(intRegex.test(txtreceivedqtymu)){
          txtreceivedqtymu = (txtreceivedqtymu +'.000');
      }

      if(intRegex.test(txtreceivedqtyau)){
        txtreceivedqtyau = (txtreceivedqtyau +'.000');
      }

      if(txtpoid == undefined)
        {
          txtpoid = '';
        }
        if(txtgeid == undefined)
        {
          txtgeid = '';
        }
        var totalvalue = 0.00;
        var totalvalue2 = 0.00;
        var txttaxamt1 = 0.00;
        var txttaxamt2 = 0.00;
        var txttottaxamt = 0.00;
        var txttotamtatax =0.00;

        txtruom = parseFloat(txtruom).toFixed(5);

        var txtamt = parseFloat((parseFloat(txtreceivedqtymu)*parseFloat(txtruom))).toFixed(2);

        if(txttax1 == undefined || txttax1 == '')
        {
          txttax1     = 0.0000;
          txttaxamt1  = 0.00;
        }
        else
        {
          txttaxamt1 = parseFloat((parseFloat(txtamt)*parseFloat(txttax1))/100).toFixed(2);
        }
        if(txttax2 == undefined || txttax2 == '')
        {
          txttax2 = 0.0000;
          txttaxamt2 = 0.00;
        }
        else
        {
          txttaxamt2 = parseFloat((parseFloat(txtamt)*parseFloat(txttax2))/100).toFixed(2);
        }
        
        var txttottaxamt = parseFloat((parseFloat(txttaxamt1)+parseFloat(txttaxamt2))).toFixed(2);
        var txttotamtatax = parseFloat((parseFloat(txtamt)+parseFloat(txttottaxamt))).toFixed(2);

    
      // var intRegex = /^\d+$/;
      

      if(intRegex.test(txtruom)){
        txtruom = (txtruom +'.00000');
      }

      if(intRegex.test(txtamt)){
        txtamt = (txtamt +'.00');
      }

      if(intRegex.test(txttax1)){
        txttax1 = (txttax1 +'.0000');
      }
      if(intRegex.test(txttax2)){
        txttax2 = (txttax2 +'.0000');
      }
      if(intRegex.test(txttaxamt1)){
        txttaxamt1 = (txttaxamt1 +'.00');
      }
      if(intRegex.test(txttaxamt2)){
        txttaxamt2 = (txttaxamt2 +'.00');
      }

      if(intRegex.test(txttottaxamt)){
        txttottaxamt = (txttottaxamt +'.00');
      }
      if(intRegex.test(txttotamtatax)){
        txttotamtatax = (txttotamtatax +'.00');
      }
      
      var GRN2 = [];
        $('#Material').find('.participantRow').each(function(){
          if($(this).find('[id*="ITEMID_REF"]').val() != '')
          {
            var grnitem = $(this).find('[id*="GRN_ID_"]').val()+'-'+$(this).find('[id*="GEID_REF_"]').val()+'-'+$(this).find('[id*="POID_REF_"]').val()+'-'+$(this).find('[id*="MRSID_REF_"]').val()+'-'+$(this).find('[id*="PIID_REF_"]').val()+'-'+$(this).find('[id*="RFQID_REF_"]').val()+'-'+$(this).find('[id*="VQID_REF_"]').val()+'-'+$(this).find('[id*="IPOID_REF_"]').val()+'-'+$(this).find('[id*="ITEMID_REF"]').val();
            GRN2.push(grnitem);
            r_count2 = parseInt(r_count2) + 1;
          }
        });
      
      var GRNNOs =  $('#hdn_ItemID18').val();
      var itemids =  $('#hdn_ItemID19').val();
      var GEIDs =  $('#hdn_ItemID20').val();
      var POIDs =  $('#hdn_ItemID22').val();
      var GRNIDs =  $('#hdn_ItemID17').val();
      var IPOIDs =  $('#hdn_ItemID23').val();
      var VQIDs =  $('#hdn_ItemID24').val();
      var RFQIDs =  $('#hdn_ItemID25').val();
      var PIIDs =  $('#hdn_ItemID26').val();
      var MRSIDs =  $('#hdn_ItemID27').val();

          if($(this).is(":checked") == true) 
          {
            var txtgrnitem = GRNIDs+'-'+txtgeid+'-'+txtpoid+'-'+txtmrsid+'-'+txtpiid+'-'+txtrfqid+'-'+txtvqid+'-'+txtipoid+'-'+txtval;
            if(jQuery.inArray(txtgrnitem, GRN2) !== -1)
            {
                  $("#ITEMIDpopup").hide();
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn").hide();
                  $("#OkBtn1").show();
                  $("#AlertMessage").text('Item already exists.');
                  $("#alert").modal('show');
                  $("#OkBtn1").focus();
                  highlighFocusBtn('activeOk1');
                  $('#hdn_ItemID').val('');
                  $('#hdn_ItemID2').val('');
                  $('#hdn_ItemID3').val('');
                  $('#hdn_ItemID4').val('');
                  $('#hdn_ItemID5').val('');
                  $('#hdn_ItemID6').val('');
                  $('#hdn_ItemID7').val('');
                  $('#hdn_ItemID8').val('');
                  $('#hdn_ItemID9').val('');
                  $('#hdn_ItemID10').val('');
                  $('#hdn_ItemID11').val('');
                  $('#hdn_ItemID12').val('');
                  $('#hdn_ItemID13').val('');
                  $('#hdn_ItemID14').val('');
                  $('#hdn_ItemID15').val('');
                  $('#hdn_ItemID16').val('');
                  $('#hdn_ItemID17').val('');
                  $('#hdn_ItemID18').val('');
                  $('#hdn_ItemID19').val('');
                  $('#hdn_ItemID20').val('');
                  $('#hdn_ItemID22').val('');
                  $('#hdn_ItemID23').val('');
                  $('#hdn_ItemID24').val('');
                  $('#hdn_ItemID25').val('');
                  $('#hdn_ItemID26').val('');
                  $('#hdn_ItemID27').val('');
                  txtval = '';
                  txtcode = '';
                  txtname = '';
                  txtspec = '';
                  txtauom = '';
                  txtmuom = '';
                  txtmuomid = '';
                  txtauomid = '';
                  txtmuomqty='';
                  txtruom = '';
                  txtamt = '';
                  txttax1 = '';
                  txttax2 = '';
                  txtpoid = '';
                  txtgeid = '';
                  txtipoid = '';
                  txtvqid = '';
                  txtrfqid = '';
                  txtpiid = '';
                  txtmrsid = '';
                  txtreceivedqtymu = '';
                  txtreceivedqtyau = '';
                  $(".blurRate").blur();
                  $('.js-selectall').prop("checked", false);
                  return false;
                  event.preventDefault();
            }

                    if($('#hdn_ItemID').val() == "" && txtval != '')
                    {
                      var txtid= $('#hdn_ItemID').val();
                      var txt_id2= $('#hdn_ItemID2').val();
                      var txt_id3= $('#hdn_ItemID3').val();
                      var txt_id4= $('#hdn_ItemID4').val();
                      var txt_id5= $('#hdn_ItemID5').val();
                      var txt_id6= $('#hdn_ItemID6').val();
                      var txt_id7= $('#hdn_ItemID7').val();
                      var txt_id8= $('#hdn_ItemID8').val();
                      var txt_id9= $('#hdn_ItemID9').val();
                      var txt_id10= $('#hdn_ItemID10').val();
                      var txt_id11= $('#hdn_ItemID11').val();
                      var txt_id12= $('#hdn_ItemID12').val();
                      var txt_id13= $('#hdn_ItemID13').val();
                      var txt_id14= $('#hdn_ItemID14').val();
                      var txt_id15= $('#hdn_ItemID15').val();
                      var txt_id16= $('#hdn_ItemID16').val();

                      var $tr = $('.material').closest('table');
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
                      $clone.find('.remove').removeAttr('disabled'); 
                      $clone.find('[id*="txtItem"]').val(txtcode);
                      $clone.find('[id*="ITEMID_REF"]').val(txtval);
                      $clone.find('[id*="GEID_REF_"]').val(txtgeid);
                      $clone.find('[id*="POID_REF_"]').val(txtpoid);
                      $clone.find('[id*="IPOID_REF_"]').val(txtipoid);
                      $clone.find('[id*="VQID_REF_"]').val(txtvqid);
                      $clone.find('[id*="RFQID_REF_"]').val(txtrfqid);
                      $clone.find('[id*="PIID_REF_"]').val(txtpiid);
                      $clone.find('[id*="MRSID_REF_"]').val(txtmrsid);
                      $clone.find('[id*="ItemName"]').val(txtname);
                      $clone.find('[id*="ItemDesc"]').val(txtspec);
                      $clone.find('[id*="txtUOM_"]').val(txtmuom);
                      $clone.find('[id*="UOMID_REF_"]').val(txtmuomid);
                      $clone.find('[id*="RECEIVED_QTY_"]').val(txtreceivedqtymu);
                      $clone.find('[id*="txtALTUOM_"]').val(txtauom);
                      $clone.find('[id*="ALT_UOMID_REF_"]').val(txtauomid);
                      $clone.find('[id*="RECEIVED_ALT_QTY_"]').val(txtreceivedqtyau);
                      $clone.find('[id*="BILL_QTY_"]').val(txtreceivedqtymu);
                      $clone.find('[id*="txtBILLUOM_"]').val(txtmuom);
                      $clone.find('[id*="BILL_UOMID_REF_"]').val(txtmuomid);
                      $clone.find('[id*="BILL_RATEPUOM_"]').val(txtruom);
                      $clone.find('[id*="DISC_PER_"]').val('0.0000');
                      $clone.find('[id*="DISC_AMT_"]').val('0.00');
                      $clone.find('[id*="TAX_AMT_"]').val(txtamt);
                      $clone.find('[id*="TT_AMT_"]').val(txttotamtatax);
                      $clone.find('[id*="TGST_AMT_"]').val(txttottaxamt);
                      if($.trim($('#Tax_State').val()) == 'OutofState')
                      { 
                        $clone.find('[id*="IGST_"]').val(txttax1);
                        $clone.find('[id*="IGST_AMT_"]').val(txttaxamt1);
                        $clone.find('[id*="SGST_"]').prop('disabled',true); 
                        $clone.find('[id*="CGST_"]').prop('disabled',true); 
                        $clone.find('[id*="SGST_AMT_"]').prop('disabled',true); 
                        $clone.find('[id*="CGST_AMT_"]').prop('disabled',true);   
                        $clone.find('[id*="SGST_"]').val('0.0000');
                        $clone.find('[id*="CGST_"]').val('0.0000');                        
                        $clone.find('[id*="SGST_AMT_"]').val('0.00');
                        $clone.find('[id*="CGST_AMT_"]').val('0.00');                          
                      }
                      else
                      { 
                        $clone.find('[id*="CGST_"]').val(txttax1);
                        $clone.find('[id*="IGST_"]').prop('disabled',true); 
                        $clone.find('[id*="SGST_"]').val(txttax2);
                        $clone.find('[id*="IGST_"]').val('0.0000');                      
                        $clone.find('[id*="CGST_AMT_"]').val(txttaxamt1);
                        $clone.find('[id*="SGST_AMT_"]').val(txttaxamt2);
                        $clone.find('[id*="IGST_AMT_"]').prop('disabled',true);                           
                        $clone.find('[id*="IGST_AMT_"]').val('0.00');                          
                      }
                      
                      $tr.closest('table').append($clone);   
                      var rowCount = $('#Row_Count1').val();
                      rowCount = parseInt(rowCount)+1;
                      $('#Row_Count1').val(rowCount);
                      if($('#GST_Reverse').is(':checked') == true)
                      {
                        var tvalue2 = parseFloat(txtamt).toFixed(2);
                        totalvalue2 = $('#tot_amt').val();
                        totalvalue2 =  parseFloat(totalvalue2) + parseFloat(tvalue2);
                        totalvalue2 = parseFloat(totalvalue2).toFixed(2);
                        $('#tot_amt').val(totalvalue2);
                      }
                      else
                      {
                        var tvalue = parseFloat(txttotamtatax).toFixed(2);
                        totalvalue = $('#tot_amt').val();
                        totalvalue =  parseFloat(totalvalue) + parseFloat(tvalue);
                        totalvalue = parseFloat(totalvalue).toFixed(2);
                        $('#tot_amt').val(totalvalue);
                      }

                      $(".blurRate").blur();
                      $("#ITEMIDpopup").hide();
                      event.preventDefault();
                    }
                    else
                    {
                      var txtid= $('#hdn_ItemID').val();
                      var txt_id2= $('#hdn_ItemID2').val();
                      var txt_id3= $('#hdn_ItemID3').val();
                      var txt_id4= $('#hdn_ItemID4').val();
                      var txt_id5= $('#hdn_ItemID5').val();
                      var txt_id6= $('#hdn_ItemID6').val();
                      var txt_id7= $('#hdn_ItemID7').val();
                      var txt_id8= $('#hdn_ItemID8').val();
                      var txt_id9= $('#hdn_ItemID9').val();
                      var txt_id10= $('#hdn_ItemID10').val();
                      var txt_id11= $('#hdn_ItemID11').val();
                      var txt_id12= $('#hdn_ItemID12').val();
                      var txt_id13= $('#hdn_ItemID13').val();
                      var txt_id14= $('#hdn_ItemID14').val();
                      var txt_id15= $('#hdn_ItemID15').val();
                      var txt_id16= $('#hdn_ItemID16').val();
                      $('#'+txtid).val(txtcode);
                      $('#'+txt_id2).val(txtval);
                      $('#'+txt_id3).val(txtname);
                      $('#'+txt_id4).val(txtmuom);
                      $('#'+txt_id5).val(txtmuomid);
                      $('#'+txt_id6).val(txtreceivedqtymu);
                      $('#'+txt_id7).val(txtauom);
                      $('#'+txt_id8).val(txtauomid);
                      $('#'+txt_id9).val(txtreceivedqtyau);
                      $('#'+txt_id10).val(txtreceivedqtymu);
                      $('#'+txt_id11).val(txtmuom);
                      $('#'+txt_id12).val(txtmuomid);
                      $('#'+txt_id13).val(txtspec);
                      $('#'+txt_id14).val(txtruom);
                      $('#'+txt_id15).val('0.0000');
                      $('#'+txt_id16).val('0.00');
                      $('#'+txtid).parent().parent().find('[id*="GEID_REF_"]').val(txtgeid);
                      $('#'+txtid).parent().parent().find('[id*="POID_REF_"]').val(txtpoid);
                      $('#'+txtid).parent().parent().find('[id*="IPOID_REF_"]').val(txtipoid);
                      $('#'+txtid).parent().parent().find('[id*="VQID_REF_"]').val(txtvqid);
                      $('#'+txtid).parent().parent().find('[id*="RFQID_REF_"]').val(txtrfqid);
                      $('#'+txtid).parent().parent().find('[id*="PIID_REF_"]').val(txtpiid);
                      $('#'+txtid).parent().parent().find('[id*="MRSID_REF_"]').val(txtmrsid);
                      $('#'+txtid).parent().parent().find('[id*="TAX_AMT_"]').val(txtamt);
                      $('#'+txtid).parent().parent().find('[id*="TT_AMT_"]').val(txttotamtatax);
                      $('#'+txtid).parent().parent().find('[id*="TGST_AMT"]').val(txttottaxamt);
                      if($.trim($('#Tax_State').val()) == 'OutofState')
                        { 
                          $('#'+txtid).parent().parent().find('[id*="IGST_"]').val(txttax1);                          
                          $('#'+txtid).parent().parent().find('[id*="IGST_AMT_"]').val(txttaxamt1);
                          $('#'+txtid).parent().parent().find('[id*="SGST_"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="CGST_"]').prop('disabled',true);
                          $('#'+txtid).parent().parent().find('[id*="SGST_AMT_"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="CGST_AMT_"]').prop('disabled',true);  
                          $('#'+txtid).parent().parent().find('[id*="SGST"]').val('0.0000');
                          $('#'+txtid).parent().parent().find('[id*="CGST_"]').val('0.0000');                           
                          $('#'+txtid).parent().parent().find('[id*="SGST_AMT_"]').val('0.00');
                          $('#'+txtid).parent().parent().find('[id*="CGST_AMT_"]').val('0.00');                            
                        }
                        else
                        { 
                          $('#'+txtid).parent().parent().find('[id*="IGST_"]').val('0.0000');
                          $('#'+txtid).parent().parent().find('[id*="CGST_"]').val(txttax1);
                          $('#'+txtid).parent().parent().find('[id*="IGST_"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="IGST_AMT_"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="SGST_"]').val(txttax2);                           
                          $('#'+txtid).parent().parent().find('[id*="SGST_AMT_"]').val(txttaxamt2);
                          $('#'+txtid).parent().parent().find('[id*="CGST_AMT_"]').val(txttaxamt1);                            
                          $('#'+txtid).parent().parent().find('[id*="IGST_AMT_"]').val('0.00');                            
                        }
                        if($('#GST_Reverse').is(':checked') == true)
                        {
                          var tvalue2 = parseFloat(txtamt).toFixed(2);
                          totalvalue2 = $('#tot_amt').val();
                          totalvalue2 =  parseFloat(totalvalue2) + parseFloat(tvalue2);
                          totalvalue2 = parseFloat(totalvalue2).toFixed(2);
                          $('#tot_amt').val(totalvalue2);
                        }
                        else
                        {
                          var tvalue = parseFloat(txttotamtatax).toFixed(2);
                          totalvalue = $('#tot_amt').val();
                          totalvalue =  parseFloat(totalvalue) + parseFloat(tvalue);
                          totalvalue = parseFloat(totalvalue).toFixed(2);
                          $('#tot_amt').val(totalvalue);
                        }
                      


                      // $("#ITEMIDpopup").hide();
                      $('#hdn_ItemID').val('');
                      $('#hdn_ItemID2').val('');
                      $('#hdn_ItemID3').val('');
                      $('#hdn_ItemID4').val('');
                      $('#hdn_ItemID5').val('');
                      $('#hdn_ItemID6').val('');
                      $('#hdn_ItemID7').val('');
                      $('#hdn_ItemID8').val('');
                      $('#hdn_ItemID9').val('');
                      $('#hdn_ItemID10').val('');
                      $('#hdn_ItemID11').val('');
                      $('#hdn_ItemID12').val('');
                      $('#hdn_ItemID13').val('');
                      $('#hdn_ItemID14').val('');
                      $('#hdn_ItemID15').val('');
                      $('#hdn_ItemID16').val('');
                      $('#hdn_ItemID17').val('');
                      $('#hdn_ItemID18').val('');
                      $('#hdn_ItemID19').val('');
                      $('#hdn_ItemID20').val('');
                      $('#hdn_ItemID22').val('');
                      $('#hdn_ItemID23').val('');
                      $('#hdn_ItemID24').val('');
                      $('#hdn_ItemID25').val('');
                      $('#hdn_ItemID26').val('');
                      $('#hdn_ItemID27').val('');
                    }
                    $(".blurRate").blur();
                    $("#ITEMIDpopup").hide();
                    event.preventDefault();
          }
          else if($(this).is(":checked") == false) 
          {
            var id = txtval;
            var geid = txtgeid;
            var poid = txtpoid;
            var ipoid = txtipoid;
            var vqid = txtvqid;
            var rfqid = txtrfqid;
            var piid = txtpiid;
            var mrsid = txtmrsid;
            var GRNIDs =  $('#hdn_ItemID17').val();
            var r_count = $('#Row_Count1').val();
            $('#Material').find('.participantRow').each(function()
            {
              var itemid = $(this).find('[id*="ITEMID_REF"]').val();
              var geid2 = $(this).find('[id*="GEID_REF"]').val();
              var poid2 = $(this).find('[id*="POID_REF"]').val();
              var ipoid2 = $(this).find('[id*="IPOID_REF"]').val();
              var vqid2 = $(this).find('[id*="VQID_REF"]').val();
              var rfqid2 = $(this).find('[id*="RFQID_REF"]').val();
              var piid2 = $(this).find('[id*="PIID_REF"]').val();
              var mrsid2 = $(this).find('[id*="MRSID_REF"]').val();
              var GRNID2 = $(this).find('[id*="GRN_ID_"]').val();
              if(id == itemid && geid == geid2 && poid == poid2 && GRNIDs == GRNID2 && ipoid == ipoid2&& vqid == vqid2&& rfqid == rfqid2&& piid == piid2 && mrsid == mrsid2)
              {
                  var rowCount = $('#Row_Count1').val();
                  if (rowCount > 1) {
                    var totalvalue = $('#TotalValue').val();
                    totalvalue = parseFloat(totalvalue - $(this).closest('.participantRow').find('[id*="TT_AMT_"]').val()).toFixed(2);
                    $('#TotalValue').val(totalvalue);
                    $(this).closest('.participantRow').remove(); 
                    rowCount = parseInt(rowCount)-1;
                  $('#Row_Count1').val(rowCount);
                  event.preventDefault();
                  }
                  else 
                  {
                    $(document).find('.dmaterial').prop('disabled', true);  
                    $("#ITEMIDpopup").hide();
                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn").hide();
                    $("#OkBtn1").show();
                    $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
                    $("#alert").modal('show');
                    $("#OkBtn1").focus();
                    highlighFocusBtn('activeOk1');
                    return false;
                    event.preventDefault();
                  }
                    $(".blurRate").blur();
                    event.preventDefault(); 
              }
              event.preventDefault();
            });
          }
      $("#Itemcodesearch").val(''); 
      $("#Itemnamesearch").val(''); 
      $("#ItemUOMsearch").val(''); 
      $("#ItemGroupsearch").val(''); 
      $("#ItemCategorysearch").val(''); 
      $("#ItemStatussearch").val(''); 
      $('.remove').removeAttr('disabled'); 

      getActionEvent();
   
      event.preventDefault();
    });
}

      

  //Item ID Dropdown Ends
//------------------------




//------------------------
     
$(document).ready(function(e) {

  var totalvalue = 0.00;
      var tvalue = 0.00;
      var ctvalue = 0.00;
      var ctgstvalue = 0.00;
      var tttdsamt21 = 0.00;
      $('#Material').find('.participantRow').each(function()
      {
        if($('#GST_Reverse').is(':checked') == true)
        {
          tvalue = $(this).find('[id*="TAX_AMT_"]').val();
          totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
          totalvalue = parseFloat(totalvalue).toFixed(2);
        }
        else
        {
          tvalue = $(this).find('[id*="TT_AMT_"]').val();
          totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
          totalvalue = parseFloat(totalvalue).toFixed(2);
        }        
      });
      if($('#CTID_REF').val() != '')
      {
        $('#CT').find('.participantRow5').each(function()
        {
          ctvalue = $(this).find('[id*="VALUE"]').val();
          ctgstvalue = $(this).find('[id*="TOTGSTAMT"]').val();
          if($('#GST_Reverse').is(':checked') == true)
          {
            totalvalue = parseFloat(totalvalue) + parseFloat(ctvalue);
            totalvalue = parseFloat(totalvalue).toFixed(2);
          }
          else
          {
            totalvalue = parseFloat(totalvalue) + parseFloat(ctvalue);
            totalvalue = parseFloat(totalvalue) + parseFloat(ctgstvalue);
            totalvalue = parseFloat(totalvalue).toFixed(2);
          }
        });
      }
      if($('#drpTDS').val() == 'Yes')
      {
        $('#TDS').find('.participantRow7').each(function()
        {
            if($(this).find('[id*="TOT_TD_AMT"]').val() != '' && $(this).find('[id*="TOT_TD_AMT"]').val() != '.00')
            {
              tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
              totalvalue = parseFloat(parseFloat(totalvalue)-parseFloat(tttdsamt21)).toFixed(2);
            }
        });
      }
      $('#tot_amt').val(totalvalue);


var Material = $("#Material").html(); 
$('#hdnMaterial').val(Material);
var TDS = $("#TDS").html(); 
$('#hdnTDS').val(TDS);
var TNC = $("#TC").html(); 
$('#hdnTNC').val(TNC);
var Calculation = $("#CT").html(); 
$('#hdnCalculation').val(Calculation);
var Payment = $("#PaymentSlabs").html(); 
$('#hdnPayment').val(Payment);
$('#tot_amt').ForceNumericOnly();
$('#Credit_days').ForceNumericOnly();
$("[id*='QTY_']").ForceNumericOnly();
$("[id*='BILL_RATEPUOM_']").ForceNumericOnly();
$("[id*='DISC_PER_']").ForceNumericOnly();
$("[id*='DISC_AMT_']").ForceNumericOnly();
$("[id*='TAX_AMT']").ForceNumericOnly();
$("[id*='TGST_AMT_']").ForceNumericOnly();
$("[id*='RATE']").ForceNumericOnly();
$("[id*='VALUE_']").ForceNumericOnly();
$("[id*='IGST']").ForceNumericOnly();
$("[id*='CGST']").ForceNumericOnly();
$("[id*='SGST']").ForceNumericOnly();
$("[id*='TT_AMT']").ForceNumericOnly();
$("[id*='hdnCCAMT']").ForceNumericOnly();
$("[id*='ASSESSABLE_VL_']").ForceNumericOnly();
$("[id*='TDS_RATE']").ForceNumericOnly();
$("[id*='TDS_AMT']").ForceNumericOnly();
$("[id*='SURCHARGE_RATE']").ForceNumericOnly();
$("[id*='SURCHARGE_AMT']").ForceNumericOnly();
$("[id*='CESS_RATE']").ForceNumericOnly();
$("[id*='CESS_AMT']").ForceNumericOnly();
$("[id*='SPCESS_RATE']").ForceNumericOnly();
$("[id*='SPCESS_AMT']").ForceNumericOnly();
$("[id*='TOT_TD_AMT']").ForceNumericOnly();
// var objlastdt = <?php echo json_encode($objlastdt[0]->PB_DOCDT); ?>;
// var today = new Date(); 
// var ardate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
// $('#PB_DOCDT').attr('min',objlastdt);
// $('#PB_DOCDT').attr('max',ardate);

var lastdt = <?php echo json_encode($objlastdt[0]->PB_DOCDT); ?>;
  var pb = <?php echo json_encode($objPBHDR); ?>;
  var today = new Date(); 
  var sbdate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2);
  if(lastdt < pb.PB_DOCDT)
  {
	$('#PB_DOCDT').attr('min',lastdt);
  }
  else
  {
	  $('#PB_DOCDT').attr('min',pb.PB_DOCDT);
  }
  $('#PB_DOCDT').attr('max',sbdate);

var PBHDR = <?php echo json_encode($objPBHDR); ?>;
var count1 = <?php echo json_encode($objCount1); ?>; 
var objtnc = <?php echo json_encode($objPBTNC); ?>;
var tncheader = <?php echo json_encode($objTNCHeader); ?>;
var tncdetails = <?php echo json_encode($objTNCDetails); ?>;
var calheader = <?php echo json_encode($objCalHeader); ?>;
var caldetails = <?php echo json_encode($objCalDetails); ?>;
var PBCal = <?php echo json_encode($objPBCAL); ?>;
var apudf = <?php echo json_encode($objUdfPBData); ?>;
var count2 = <?php echo json_encode($objCountUDF); ?>;  
var pbudf = <?php echo json_encode($objPBUDF); ?>;
var udfforpb = <?php echo json_encode($objUdfPBData2); ?>;
var totalvalue = 0.00; 

//TNC TAB Data Start
//------------------------

$.each( objtnc, function( tnckey, tncvalue ) {
        $.each( tncheader, function( tnchkey, tnchvalue ) { 
            if(tncvalue.TNCID_REF == tnchvalue.TNCID)
            {
                $('#txtTNCID_popup').val(tnchvalue.TNC_CODE);
            }
        });
        $.each( tncdetails, function( tncdkey, tncdvalue ) { 
            if(tncvalue.TNCDID_REF == tncdvalue.TNCDID)
            {
                $('#popupTNCDID_'+tnckey).val(tncdvalue.TNC_NAME);
            }
            if(tncvalue.TNCDID_REF == tncdvalue.TNCDID)
            {        
                    var txtvaltype =   tncdvalue.VALUE_TYPE;
                    var txt_id4 = $('#tdinputid_'+tnckey).attr('id');
                    var strdyn = txt_id4.split('_');
                    var lastele =   strdyn[strdyn.length-1];
                    var dynamicid = "tncdetvalue_"+lastele;
                    
                    var chkvaltype =  txtvaltype.toLowerCase();
                    var strinp = '';

                    if(chkvaltype=='date'){

                      strinp = '<input  {{$ActionStatus}} type="date" placeholder="dd/mm/yyyy" name="'+dynamicid+ '" id="'+dynamicid+'" autocomplete="off" class="form-control"  > ';       

                    }
                    else if(chkvaltype=='time'){
                      strinp= '<input {{$ActionStatus}} type="time" placeholder="h:i" name="'+dynamicid+ '" id="'+dynamicid+'" autocomplete="off" class="form-control"  > ';

                    }
                    else if(chkvaltype=='numeric'){
                      strinp = '<input {{$ActionStatus}} type="text" name="'+dynamicid+ '" id="'+dynamicid+'" autocomplete="off" class="form-control"   > ';

                    }
                    else if(chkvaltype=='text'){

                      strinp = '<input {{$ActionStatus}} type="text" name="'+dynamicid+ '" id="'+dynamicid+'" autocomplete="off" class="form-control"  > ';
                    
                    }
                    else if(chkvaltype=='boolean'){
                      if(tncvalue.VALUE == "1")
                      {
                        strinp = '<input {{$ActionStatus}} type="checkbox" name="'+dynamicid+ '" id="'+dynamicid+'" class="" checked> ';
                      }
                      else{
                        strinp = '<input {{$ActionStatus}} type="checkbox" name="'+dynamicid+ '" id="'+dynamicid+'" class="" > ';
                      }                    
                    }
                    else if(chkvaltype=='combobox'){
                      var txtoptscombo =   tncdvalue.DESCRIPTIONS;
                      var strarray = txtoptscombo.split(',');
                      var opts = '';
                      for (var i = 0; i < strarray.length; i++) 
                      {
                          opts = opts + '<option value="'+strarray[i]+'">'+strarray[i]+'</option> ';
                      }
                      strinp = '<select {{$ActionStatus}} name="'+dynamicid+ '" id="'+dynamicid+'" class="form-control" required>'+opts+'</select>' ;                   
                    }
                    $('#'+txt_id4).html('');  
                    $('#'+txt_id4).html(strinp);   //set dynamic input
                    $('#'+dynamicid).val(tncvalue.VALUE);
                    $('#TNCismandatory_'+tnckey).val(tncdvalue.IS_MANDATORY); // mandatory
                
            }
        });
    });

//TNC TAB Data End
//------------------------
//Calculation Template TAB Data Start
//------------------------
$.each(PBCal, function( pbckey, pbcvalue ) {
        $.each( calheader, function( calkey, calvalue ){ 
            if(pbcvalue.CTID_REF == calvalue.CTID)
            {
                $('#txtCTID_popup').val(calvalue.CTCODE);
            }
        });
        $.each( caldetails, function( caldkey, caldvalue ){ 
            if(pbcvalue.TID_REF == caldvalue.TID)
            {
                $('#popupTID_'+pbckey).val(caldvalue.COMPONENT);
                $('#BASIS_'+pbckey).val(caldvalue.BASIS);
                $('#SQNO_'+pbckey).val(caldvalue.SQNO);
                $('#FORMULA_'+pbckey).val(caldvalue.FORMULA);
                
            }
        });        
    });
    
    // $('#tot_amt').val(totalvalue);
    //  bindTotalValue();
    // event.preventDefault();

//Calculation Template TAB Data End
//------------------------

//UDF Template TAB Data Start
//------------------------
$.each( pbudf, function( pbukey, pbuvalue ) {
        $.each( udfforpb, function( upbkey, upbvalue ) { 
            if(pbuvalue.PB_UDFID == upbvalue.UDFPBID)
            {
                $('#popupUDFPBID_'+pbukey).val(upbvalue.LABEL);
            }
        
            if(pbuvalue.PB_UDFID == upbvalue.UDFPBID)
            {        
                    var txtvaltype2 =   upbvalue.VALUETYPE;
                    var txt_id41 = $('#udfinputid_'+pbukey).attr('id');
                    var strdyn2 = txt_id41.split('_');
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
                      if(pbuvalue.VALUE == "1")
                      {
                        strinp2 = '<input {{$ActionStatus}} type="checkbox" name="'+dynamicid2+ '" id="'+dynamicid2+'" class="" checked> ';
                      }
                      else{
                        strinp2 = '<input {{$ActionStatus}} type="checkbox" name="'+dynamicid2+ '" id="'+dynamicid2+'" class="" > ';
                      }
                    }
                    else if(chkvaltype2=='combobox'){

                    var txtoptscombo2 =   upbvalue.DESCRIPTIONS;
                    var strarray2 = txtoptscombo2.split(',');
                    var opts2 = '';

                    for (var i = 0; i < strarray2.length; i++) {
                        opts2 = opts2 + '<option value="'+strarray2[i]+'">'+strarray2[i]+'</option> ';
                    }

                    strinp2 = '<select {{$ActionStatus}} name="'+dynamicid2+ '" id="'+dynamicid2+'" class="form-control" required>'+opts2+'</select>' ;
                   
                    }
                   
                    
                    $('#'+txt_id41).html('');  
                    $('#'+txt_id41).html(strinp2);   //set dynamic input
                    $('#'+dynamicid2).val(pbuvalue.VALUE);
                    $('#UDFismandatory_'+pbukey).val(upbvalue.ISMANDATORY); // mandatory
                
            }
        });
    });

//UDF Template TAB Data End
//------------------------

// if(count1 != '')
// {
//   bindTotalValue();
// }

$('#udf').find('.participantRow4').each(function(){
  var txt_id4 = $(this).find('[id*="udfinputid"]').attr('id');
  var udfid = $(this).find('[id*="UDFPBID_REF"]').val();
  $.each( apudf, function( apukey, apuvalue ) {
    if(apuvalue.UDFPBID == udfid)
    {
      var txtvaltype2 =   apuvalue.VALUETYPE;
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
      var txtoptscombo2 =   apuvalue.DESCRIPTIONS;
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
  var viewURL = '{{route("transaction",[$FormId,"add"])}}';
              window.location.href=viewURL;
});

$('#btnExit').on('click', function() {
  var viewURL = '{{route('home')}}';
              window.location.href=viewURL;
});

// if(objPBHDR.VID_REF != '')
// {
//   if($('#CTID_REF').val()!='')
//     {
//       bindGSTCalTemplate();
//     }
//     bindTotalValue();
//     // event.preventDefault();
// }



  function bindGSTCalTemplate()
  { 
          $('#CT').find('.participantRow5').each(function()
            { 
                var basis = $(this).find('[id*="BASIS"]').val();
                var sqno = $(this).find('[id*="SQNO"]').val();
                var formula = $(this).find('[id*="FORMULA"]').val();
                var rate = $(this).find('[id*="RATE"]').val();
                var amountnet = $(this).find('[id*="VALUE"]').val();
                var netTaxableAmount = 0.00;
                var netGSTAmount = 0.00;
                var netTotalAmount = 0.00;
                var totamount = 0.00;
                var tamt = 0.00;
                var IGSTamt = 0.00;
                var CGSTamt = 0.00;
                var SGSTamt = 0.00;
                var TotGSTamt = 0.00;

                $('#Material').find('.participantRow').each(function()
                {  
                  if($(this).find('[id*="TAX_AMT_"]').val() != '' && $(this).find('[id*="TAX_AMT_"]').val() != '.00') {                   
                  var TaxableAmount = $(this).find('[id*="TAX_AMT_"]').val();
                  if (!isNaN(TaxableAmount) && TaxableAmount.length !== 0) {
                    netTaxableAmount += parseFloat(TaxableAmount);
                    }                      
                  }
                  else
                  {
                    var TaxableAmount = 0;
                    netTaxableAmount += 0;
                  }
                  if($(this).find('[id*="TGST_AMT_"]').val() != '' && $(this).find('[id*="TGST_AMT_"]').val() != '.00') {                   
                    var GSTAmount = $(this).find('[id*="TGST_AMT_"]').val();
                    if (!isNaN(GSTAmount) && GSTAmount.length !== 0) {
                      netGSTAmount += parseFloat(GSTAmount);
                    }                      
                  }
                  else
                  {
                    var GSTAmount = 0;
                    netGSTAmount += 0;
                  }
                  if($(this).find('[id*="TT_AMT_"]').val() != '' && $(this).find('[id*="TT_AMT_"]').val() != '.00') {                   
                    var TotalAmount = $(this).find('[id*="TT_AMT_"]').val();
                    if (!isNaN(TotalAmount) && TotalAmount.length !== 0) {
                      netTotalAmount += parseFloat(TotalAmount);
                    }                      
                  }
                  else
                  {
                    var TotalAmount = 0;
                    netTotalAmount += 0;
                  }
                })
                var IGST = $('#IGST_0').val();
                var CGST = $('#CGST_0').val();
                var SGST = $('#SGST_0').val();
                
                  if(formula == '')
                  {
                    if(rate > 0)
                    { 
                      if(basis == 'Item Taxable Amount')
                      {
                        if(netTaxableAmount != '0')
                        {
                          totamount = parseFloat((rate * netTaxableAmount)/100).toFixed(2);
                        }
                        else
                        {
                          totamount = 0;
                        }
                      }
                      if(basis == 'Item GST Amount')
                      {
                        if(netGSTAmount != '0')
                        {
                          totamount = parseFloat((rate * netGSTAmount)/100).toFixed(2);
                        }
                        else
                        {
                          totamount = 0;
                        }
                      }
                      if(basis == 'Amount After GST Item')
                      {
                        if(netTotalAmount != '0')
                        {
                          totamount = parseFloat((rate * netTotalAmount)/100).toFixed(2);
                        }
                        else
                        {
                          totamount = 0;
                        }
                      }
                    }
                    else
                    {
                      totamount = amountnet;
                    }
                  }
                  else
                  {
                    if(basis == 'Item Taxable Amount')
                    {
                      var basis1 = '( '+netTaxableAmount+' * '+rate+' ) / 100';
                      var basis2 = netTaxableAmount;
                      var rate1 = rate +' ) / 100';
                      if(formula.indexOf("BASIS*RATE") != -1){
                        var formula1 = formula.replace ("BASIS*RATE", basis1);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("BASIS") != -1){
                        var formula1 = formula.replace ("BASIS", basis2);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("RATE") != -1){
                        var formula1 = formula.replace ("RATE", rate1);
                        tamt = eval(formula1);
                        totamount = parseFloat(( tamt * rate)/100).toFixed(2);
                      }
                    }
                    if(basis == 'Item GST Amount')
                    {
                      var basis1 = '('+netGSTAmount+'*'+rate+')/100';
                      var basis2 = netGSTAmount;
                      var rate1 = rate+')/100';
                      if(formula.indexOf("BASIS*RATE") != -1){
                        var formula1 = formula.replace ("BASIS*RATE", basis1);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("BASIS") != -1){
                        var formula1 = formula.replace ("BASIS", basis2);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("RATE") != -1){
                        var formula1 = formula.replace ("RATE", rate1);
                        tamt = eval(formula1);
                        totamount = parseFloat(( tamt * rate)/100).toFixed(2);
                      }
                    }
                    if(basis == 'Amount After GST Item')
                    {
                      var basis1 = '( '+netTotalAmount+' * '+rate+' ) / 100';
                      var basis2 = netTotalAmount;
                      var rate1 = rate+' ) / 100';
                      if(formula.indexOf("BASIS*RATE") != -1){
                        var formula1 = formula.replace ("BASIS*RATE", basis1);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("BASIS") != -1){
                        var formula1 = formula.replace ("BASIS", basis2);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("RATE") != -1){
                        var formula1 = formula.replace ("RATE", rate1);
                        tamt = eval(formula1);
                        totamount = parseFloat(( tamt * rate)/100).toFixed(2);
                      }
                    }
                    
                  }
                  $(this).find('[id*="VALUE_"]').val(totamount);
                    IGSTamt = parseFloat((IGST * totamount)/100).toFixed(2);
                    CGSTamt = parseFloat((CGST * totamount)/100).toFixed(2);
                    SGSTamt = parseFloat((SGST * totamount)/100).toFixed(2);
                    TotGSTamt = parseFloat(parseFloat(IGSTamt)+parseFloat(CGSTamt)+parseFloat(SGSTamt)).toFixed(2);
                if($(this).find('[id*="calGST"]').is(":checked") != false)
                {
                  if (IGST != '')
                  {
                    $(this).find('[id*="calIGST_"]').val(IGST);
                    $(this).find('[id*="AMTIGST_"]').val(IGSTamt);
                    $(this).find('[id*="calIGST_"]').removeAttr('readonly');
                  }
                  else
                  {
                    $(this).find('[id*="calIGST_"]').val('0');
                    $(this).find('[id*="AMTIGST_"]').val('0');
                    $(this).find('[id*="calIGST_"]').prop('readonly',true);
                    
                  }
                  if (CGST != '')
                  {
                    $(this).find('[id*="calCGST_"]').val(CGST);
                    $(this).find('[id*="AMTCGST_"]').val(CGSTamt);
                    $(this).find('[id*="calCGST_"]').removeAttr('readonly');
                  }
                  else
                  {
                    $(this).find('[id*="calCGST_"]').val('0');
                    $(this).find('[id*="AMTCGST_"]').val('0');
                    $(this).find('[id*="calCGST_"]').prop('readonly',true);
                  }
                  if (SGST != '')
                  {
                    $(this).find('[id*="calSGST_"]').val(SGST);
                    $(this).find('[id*="AMTSGST_"]').val(SGSTamt);
                    $(this).find('[id*="calSGST_"]').removeAttr('readonly');
                  }
                  else
                  {
                    $(this).find('[id*="calSGST_"]').val('0');
                    $(this).find('[id*="AMTSGST_"]').val('0');
                    $(this).find('[id*="calSGST_"]').prop('readonly',true);
                  }
                  $(this).find('[id*="TOTGSTAMT_"]').val(TotGSTamt);
                }
                else
                {
                  $(this).find('[id*="calSGST_"]').val('0');
                  $(this).find('[id*="AMTSGST_"]').val('0');
                  $(this).find('[id*="calCGST_"]').val('0');
                  $(this).find('[id*="AMTCGST_"]').val('0');
                  $(this).find('[id*="calIGST_"]').val('0');
                  $(this).find('[id*="AMTIGST_"]').val('0');
                  $(this).find('[id*="TOTGSTAMT_"]').val('0');
                  $(this).find('[id*="calIGST_"]').prop('readonly',true);
                  $(this).find('[id*="calCGST_"]').prop('readonly',true);
                  $(this).find('[id*="calSGST_"]').prop('readonly',true);
                }
            });
            var totalvalue = 0.00;
            var tvalue = 0.00;
            var ctvalue = 0.00;
            var ctgstvalue = 0.00;
            $('#Material').find('.participantRow').each(function()
            {
              tvalue = $(this).find('[id*="TT_AMT_"]').val();
              totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
              totalvalue = parseFloat(totalvalue).toFixed(2);
            });
            if($('#CTID_REF').val() != '')
            {
              $('#CT').find('.participantRow5').each(function()
              {
                ctvalue = $(this).find('[id*="VALUE"]').val();
                ctgstvalue = $(this).find('[id*="TOTGSTAMT"]').val();
                totalvalue = parseFloat(totalvalue) + parseFloat(ctvalue);
                totalvalue = parseFloat(totalvalue) + parseFloat(ctgstvalue);
                totalvalue = parseFloat(totalvalue).toFixed(2);
              });
            }
            $('#tot_amt').val(totalvalue);
            event.preventDefault();
    }

$('#frm_trn_pbi').on('change','#GST_Reverse', function() 
{
    // bindTotalValue();
    if($('#CTID_REF').val()!='')
    {
      bindGSTCalTemplate();
    }
    bindTotalValue();
    event.preventDefault();
});



$("#TDS").on('change', "[id*='TDSApplicable']", function() 
{
  var totalamount = 0.00;
  if($(this).is(':checked') == true)
  {
    var taxamt12 = 0.00;
    $('#Material').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TAX_AMT"]').val() != '')
        {
          var taxamt21 = $(this).find('[id*="TAX_AMT"]').val();
          taxamt12 = parseFloat(parseFloat(taxamt12)+parseFloat(taxamt21)).toFixed(2);
        }
    });
    if($('#CTID_REF').val() != '')
    {
      $('#CT').find('.participantRow5').each(function()
      {
        var ctvalue = $(this).find('[id*="VALUE"]').val();
        taxamt12 = parseFloat(parseFloat(taxamt12)+parseFloat(ctvalue)).toFixed(2);
      });
    }
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
  bindTotalValue();
  if($('#CTID_REF').val()!='')
  {
    bindGSTCalTemplate();
  }
  bindTotalValue();
  if($('#tot_amt').val() < '0.00')
  {
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Total Amount must be greater than Zero. Kindly check values in Material, Calculation Template & TDS Tab.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  event.preventDefault();
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

    bindTotalValue();
    if($('#CTID_REF').val()!='')
    {
      bindGSTCalTemplate();
    }
    bindTotalValue();
    if($('#tot_amt').val() < '0.00')
    {
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn").hide();
      $("#OkBtn1").show();
      $("#AlertMessage").text('Total Amount must be greater than Zero. Kindly check values in Material, Calculation Template & TDS Tab.');
      $("#alert").modal('show');
      $("#OkBtn1").focus();
      highlighFocusBtn('activeOk1');
      return false;
    }
  event.preventDefault();
});

$("#TDS").on('focusout', "[id*='TDS_RATE_']", function() 
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

    bindTotalValue();
    if($('#CTID_REF').val()!='')
    {
      bindGSTCalTemplate();
    }
    bindTotalValue();
    if($('#tot_amt').val() < '0.00')
    {
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn").hide();
      $("#OkBtn1").show();
      $("#AlertMessage").text('Total Amount must be greater than Zero. Kindly check values in Material, Calculation Template & TDS Tab.');
      $("#alert").modal('show');
      $("#OkBtn1").focus();
      highlighFocusBtn('activeOk1');
      return false;
    }
  event.preventDefault();
});

$('#PaymentSlabs').on('change','[id*="PAY_DAYS_"]',function( event ) {
    var d = $(this).val(); 
    d = parseInt(d) - 1;
    var pdate =$('#PB_DOCDT').val();
    var ddate = new Date(pdate);
    var newddate = new Date(ddate);
    newddate.setDate(newddate.getDate() + d);
    var piddate = newddate.getFullYear() + "-" + ("0" + (newddate.getMonth() + 1)).slice(-2) + "-" + ('0' + newddate.getDate()).slice(-2) ;
    $(this).parent().parent().find('[id*="DUE_DATE_"]').val(piddate);
    event.preventDefault();
});

$("#CT").on('change',"[id*='calGST']",function() {
      if ($(this).is(":checked") == true){
        if($.trim($('#Tax_State').val()) == 'OutofState')
          {
            $(this).parent().parent().find('[id*="calIGST"]').removeAttr('disabled');
            $(this).parent().parent().find('[id*="calIGST"]').removeAttr('readonly');
            $(this).parent().parent().find('[id*="calCGST"]').prop('disabled','true');
            $(this).parent().parent().find('[id*="calCGST"]').val('0');
            $(this).parent().parent().find('[id*="calSGST"]').prop('disabled','true');
            $(this).parent().parent().find('[id*="calSGST"]').val('0');
            $(this).parent().parent().find('[id*="AMTIGST"]').removeAttr('disabled');
            $(this).parent().parent().find('[id*="AMTIGST"]').removeAttr('readonly');
            $(this).parent().parent().find('[id*="AMTCGST"]').prop('disabled','true');
            $(this).parent().parent().find('[id*="AMTSGST"]').prop('disabled','true');
            $(this).parent().parent().find('[id*="AMTCGST"]').val('0');
            $(this).parent().parent().find('[id*="AMTSGST"]').val('0');
            $(this).parent().parent().find('[id*="TOTGSTAMT"]').val('0');
            bindTotalValue();
            event.preventDefault();
          }
          else
          {
            $(this).parent().parent().find('[id*="calIGST"]').prop('disabled','true');
            $(this).parent().parent().find('[id*="calCGST"]').removeAttr('disabled');
            $(this).parent().parent().find('[id*="calSGST"]').removeAttr('disabled');
            $(this).parent().parent().find('[id*="calCGST"]').removeAttr('readonly');
            $(this).parent().parent().find('[id*="calSGST"]').removeAttr('readonly');
            $(this).parent().parent().find('[id*="AMTIGST"]').prop('disabled','true');
            $(this).parent().parent().find('[id*="AMTCGST"]').removeAttr('disabled');
            $(this).parent().parent().find('[id*="AMTSGST"]').removeAttr('disabled');
            $(this).parent().parent().find('[id*="AMTCGST"]').removeAttr('readonly');
            $(this).parent().parent().find('[id*="AMTSGST"]').removeAttr('readonly');
            $(this).parent().parent().find('[id*="calIGST"]').val('0');
            $(this).parent().parent().find('[id*="AMTIGST"]').val('0');
            $(this).parent().parent().find('[id*="TOTGSTAMT"]').val('0');
            bindTotalValue();
            event.preventDefault();
          }
      }
      else
      {
          $(this).parent().parent().find('[id*="calIGST"]').prop('disabled','true');
          $(this).parent().parent().find('[id*="calCGST"]').prop('disabled','true');
          $(this).parent().parent().find('[id*="calSGST"]').prop('disabled','true');
          $(this).parent().parent().find('[id*="AMTIGST"]').prop('disabled','true');
          $(this).parent().parent().find('[id*="AMTCGST"]').prop('disabled','true');
          $(this).parent().parent().find('[id*="AMTSGST"]').prop('disabled','true');
          $(this).parent().parent().find('[id*="calIGST"]').val('0');
          $(this).parent().parent().find('[id*="calCGST"]').val('0');
          $(this).parent().parent().find('[id*="calSGST"]').val('0');
          $(this).parent().parent().find('[id*="AMTIGST"]').val('0');
          $(this).parent().parent().find('[id*="AMTCGST"]').val('0');
          $(this).parent().parent().find('[id*="AMTSGST"]').val('0');
          $(this).parent().parent().find('[id*="TOTGSTAMT"]').val('0');
          bindTotalValue();
          event.preventDefault();
      }
  });
  $("#CT").on('change',"[id*='calIGST_']",function() {
      var rate = $(this).val();
      var total = $(this).parent().parent().find('[id*="VALUE_"]').val();
      var gstamt = parseFloat((rate*total)/100).toFixed(2);
      var totgst = $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val();
      totgst = parseFloat(parseFloat(gstamt)).toFixed(2);;
      $(this).parent().parent().find('[id*="AMTIGST_"]').val(gstamt);
      $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val(totgst);
      bindTotalValue();
      if(intRegex.test($(this).val())){
        $(this).val($(this).val() +'.0000');
      }
      event.preventDefault();
  });
  $("#CT").on('change',"[id*='calCGST_']",function() {
      var rate2 = $(this).val();
      var total2 = $(this).parent().parent().find('[id*="VALUE_"]').val();
      var gstamt2 = parseFloat((rate2*total2)/100).toFixed(2);
      var totgst2 = $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val();
      var sgstamt = $(this).parent().parent().find('[id*="AMTSGST_"]').val();
      totgst2 = parseFloat(parseFloat(sgstamt) + parseFloat(gstamt2)).toFixed(2);
      $(this).parent().parent().find('[id*="AMTCGST_"]').val(gstamt2);
      $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val(totgst2);
      bindTotalValue();
      if(intRegex.test($(this).val())){
        $(this).val($(this).val() +'.0000');
      }
      event.preventDefault();
  }); 
  $("#CT").on('change',"[id*='calSGST_']",function() {
      var rate3 = $(this).val();
      var total3 = $(this).parent().parent().find('[id*="VALUE_"]').val();
      var gstamt3 = parseFloat((rate3*total3)/100).toFixed(2);
      var totgst3 = $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val();
      var cgstamt = $(this).parent().parent().find('[id*="AMTCGST_"]').val();
      totgst3 = parseFloat(parseFloat(cgstamt) + parseFloat(gstamt3)).toFixed(2);;
      $(this).parent().parent().find('[id*="AMTSGST_"]').val(gstamt3);
      $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val(totgst3);
      bindTotalValue();
      if(intRegex.test($(this).val())){
        $(this).val($(this).val() +'.0000');
      }
      event.preventDefault();
  }); 

//delete row
$("#Material").on('click', '.dmaterial', function() {
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
});
$("#PaymentSlabs").on('click', '.remove', function() {
    var rowCount = $(this).closest('table').find('.participantRow6').length;
    if (rowCount > 1) {
    $(this).closest('.participantRow6').remove();     
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
});


//add row
$("#Material").on('click', '.material', function() {
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

$("#PaymentSlabs").on('click', '.add', function() {
  var $tr = $(this).closest('table');
  var allTrs = $tr.find('.participantRow6').last();
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
  $tr.closest('table').append($clone);         
  var rowCount5 = $('#Row_Count5').val();
  rowCount5 = parseInt(rowCount5)+1;
  $('#Row_Count5').val(rowCount5);
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
  window.location.href = "{{route('transaction',[$FormId,'add'])}}";
}//fnUndoYes


window.fnUndoNo = function (){
    $("#PB_DOCNO").focus();
}//fnUndoNo

});
</script>

@endpush

@push('bottom-scripts')
<script>

$(document).ready(function() {

    // if(PBHDR.PB_DOCNO !='')
    // {
    //   bindTotalValue();
    //   event.preventDefault();
    // }
    


    $('#frm_trn_pbi1').bootstrapValidator({       
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
            //  $("#frm_trn_pbi").submit();
        }
    });
});



$("#btnSave").click(function() {
  var formPurchaseBill = $("#frm_trn_pbi");
  if(formPurchaseBill.valid()){
 $("#FocusId").val('');
 var PB_DOCNO          =   $.trim($("#PB_DOCNO").val());
 var PB_DOCDT          =   $.trim($("#PB_DOCDT").val());
 var DEPID_REF         =   $.trim($("#DEPID_REF").val());
 var VID_REF           =   $.trim($("#VID_REF").val());
 var VENDOR_INNO       =   $.trim($("#VENDOR_INNO").val());
 var VENDOR_INDT       =   $.trim($("#VENDOR_INDT").val());

 for ( instance in CKEDITOR.instances ) {
    CKEDITOR.instances.Template_Description.updateElement();
  }

 if($('#tot_amt').val() < '0.00')
  {
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Total Amount must be greater than Zero. Kindly check values in Material, Calculation Template & TDS Tab.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else if(PB_DOCNO ===""){
     $("#FocusId").val($("#PB_DOCNO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please enter value in Document Number.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(PB_DOCDT ===""){
    $("#FocusId").val($("#PB_DOCDT"));
     $("#PB_DOCDT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Document Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }  
 else if(DEPID_REF ===""){
     $("#FocusId").val($("#DEPID_REF"));
     $("#DEPID_REF").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Department.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(VID_REF ===""){
     $("#FocusId").val($("#VID_REF"));
     $("#VID_REF").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Vendor.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(VENDOR_INNO ===""){
     $("#FocusId").val($("#VENDOR_INNO"));
     $("#VENDOR_INNO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Vendor Invoice Number.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(VENDOR_INDT ===""){
     $("#FocusId").val($("#VENDOR_INDT"));
     $("#VENDOR_INDT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Vendor Invoice Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else{
    event.preventDefault();
    var allblank = [];
    var allblank2 = [];
    var allblank3 = [];
    var allblank4 = [];
    var allblank5 = [];
    var allblank6 = [];
    var allblank7 = [];
    var allblank8 = [];
    var allblank9 = [];
    var allblank10 = [];
    var allblank11 = [];
    var allblank12 = [];

        $('#Material').find('.participantRow').each(function()
        {    
            if($.trim($(this).find("[id*=GRN_ID_]").val())!="")
            {
                  allblank.push('true');
                  if($.trim($(this).find("[id*=ITEMID_REF_]").val())!="")
                  {
                        allblank2.push('true');
                        if($.trim($(this).find("[id*=BILL_QTY_]").val())!="" && $(this).find("[id*=BILL_QTY_]").val() > '0.00' && 
                              $(this).find("[id*=BILL_QTY_]").val() != '.00')
                        {
                              allblank3.push('true');
                        }
                        else
                        {
                              allblank3.push('false');
                        }
                        if($.trim($(this).find("[id*=BILL_RATEPUOM_]").val())!="")
                        {
                          allblank4.push('true');
                        }
                        else
                        {
                          allblank4.push('true');
                        }
                        if($.trim($('#Tax_State').val())=="WithinState")
                        {
                          if($.trim($(this).find("[id*=IGST]").val())!="")
                          {
                            allblank5.push('true');
                          }
                          else
                          {
                            allblank5.push('true');
                          }
                        }
                        else
                        {
                          if($.trim($(this).find("[id*=CGST]").val())!="")
                          {
                            allblank5.push('true');
                          }
                          else
                          {
                            allblank5.push('true');
                          }
                          if($.trim($(this).find("[id*=SGST]").val())!="")
                          {
                            allblank5.push('true');
                          }
                          else
                          {
                            allblank5.push('true');
                          }
                        }
                  }
                  else
                  {
                        allblank2.push('false');
                  }
            }
            else
            {
                  allblank.push('false');
            }
        });
        if($('#TNCID_REF').val() !="")
        {
            $('#TC').find('.participantRow3').each(function(){
              if($.trim($(this).find("[id*=TNCDID_REF]").val())!="")
                {
                    allblank6.push('true');
                        if($.trim($(this).find("[id*=TNCismandatory]").val())=="1"){
                              if($.trim($(this).find('[id*="tncdetvalue"]').val()) != "")
                              {
                                allblank7.push('true');
                              }
                              else
                              {
                                allblank7.push('false');
                              } 
                        } 
                }
                else
                {
                    allblank6.push('false');
                } 
            });
        }
        if($('#CTID_REF').val() !="")
        {
            $('#CT').find('.participantRow5').each(function(){
              if($.trim($(this).find("[id*=TID_REF]").val())!="")
                {
                  allblank8.push('true');
                        if($(this).find("[id*=calGST]").is(":checked") == true)
                        {
                          if($.trim($('#Tax_State').val())!="WithinState")
                          {
                            if($.trim($(this).find("[id*=calIGST]").val())!="0")
                            {
                              allblank9.push('true');
                            }
                            else
                            {
                              allblank9.push('false');
                            }
                          }
                          else
                          {
                            if($.trim($(this).find("[id*=calCGST]").val())!="0")
                            {
                              allblank9.push('true');
                            }
                            else
                            {
                              allblank9.push('false');
                            }
                            if($.trim($(this).find("[id*=calSGST]").val())!="0")
                            {
                              allblank9.push('true');
                            }
                            else
                            {
                              allblank9.push('false');
                            }
                          }
                        } 
                }
                else
                {
                    allblank8.push('false');
                } 
            });
        }
        $('#PaymentSlabs').find('.participantRow6').each(function(){
              if($.trim($(this).find("[id*=PAY_DAYS_]").val())!="")
                {
                  if($.trim($(this).find('[id*="DUE_"]').val()) != "")
                  {
                    allblank10.push('true');
                  }
                  else
                  {
                    allblank10.push('false');
                  }       
                }                
        });
        $('#udf').find('.participantRow4').each(function(){
              if($.trim($(this).find("[id*=UDFPBID_REF_]").val())!="")
                {
                    allblank8.push('true');
                        if($.trim($(this).find("[id*=UDFismandatory]").val())=="1"){
                              if($.trim($(this).find('[id*="udfvalue"]').val()) != "")
                              {
                                allblank11.push('true');
                              }
                              else
                              {
                                allblank11.push('false');
                              }
                        }  
                }                
        });

    }
        
        if(jQuery.inArray("false", allblank) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please select GRN in Material Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank2) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please select Item in Material Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank3) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Bill Quantity must be greater than Zero in Material Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          } 
        else if(jQuery.inArray("false", allblank4) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Rate must be greater than Zero in Material Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          }
        else if(jQuery.inArray("false", allblank5) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter GST Rate in Material Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          }
        else if(jQuery.inArray("false", allblank7) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter Value / Comment in T&C Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          } 
        else if(jQuery.inArray("false", allblank9) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter GST Rate in Calculation Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          }
        else if(jQuery.inArray("false", allblank10) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter Due details in Payment Slab Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          } 
        else if(jQuery.inArray("false", allblank11) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter Value / Comment in UDF Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
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

$("#btnApprove").click(function() {
  var formPurchaseBill = $("#frm_trn_pbi");
  if(formPurchaseBill.valid()){
 $("#FocusId").val('');
 var PB_DOCNO          =   $.trim($("#PB_DOCNO").val());
 var PB_DOCDT          =   $.trim($("#PB_DOCDT").val());
 var DEPID_REF         =   $.trim($("#DEPID_REF").val());
 var VID_REF           =   $.trim($("#VID_REF").val());
 var VENDOR_INNO       =   $.trim($("#VENDOR_INNO").val());
 var VENDOR_INDT       =   $.trim($("#VENDOR_INDT").val());

  for ( instance in CKEDITOR.instances ) {
    CKEDITOR.instances.Template_Description.updateElement();
  }


 if($('#tot_amt').val() < '0.00')
  {
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Total Amount must be greater than Zero. Kindly check values in Material, Calculation Template & TDS Tab.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else if(PB_DOCNO ===""){
     $("#FocusId").val($("#PB_DOCNO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please enter value in Document Number.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(PB_DOCDT ===""){
    $("#FocusId").val($("#PB_DOCDT"));
     $("#PB_DOCDT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Document Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }  
 else if(DEPID_REF ===""){
     $("#FocusId").val($("#DEPID_REF"));
     $("#DEPID_REF").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Department.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(VID_REF ===""){
     $("#FocusId").val($("#VID_REF"));
     $("#VID_REF").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Vendor.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(VENDOR_INNO ===""){
     $("#FocusId").val($("#VENDOR_INNO"));
     $("#VENDOR_INNO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Vendor Invoice Number.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(VENDOR_INDT ===""){
     $("#FocusId").val($("#VENDOR_INDT"));
     $("#VENDOR_INDT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Vendor Invoice Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else{
    event.preventDefault();
    var allblank = [];
    var allblank2 = [];
    var allblank3 = [];
    var allblank4 = [];
    var allblank5 = [];
    var allblank6 = [];
    var allblank7 = [];
    var allblank8 = [];
    var allblank9 = [];
    var allblank10 = [];
    var allblank11 = [];
    var allblank12 = [];

        $('#Material').find('.participantRow').each(function()
        {    
            if($.trim($(this).find("[id*=GRN_ID_]").val())!="")
            {
                  allblank.push('true');
                  if($.trim($(this).find("[id*=ITEMID_REF_]").val())!="")
                  {
                        allblank2.push('true');
                        if($.trim($(this).find("[id*=BILL_QTY_]").val())!="" && $(this).find("[id*=BILL_QTY_]").val() > '0.00' && 
                              $(this).find("[id*=BILL_QTY_]").val() != '.00')
                        {
                              allblank3.push('true');
                        }
                        else
                        {
                              allblank3.push('false');
                        }
                        if($.trim($(this).find("[id*=BILL_RATEPUOM_]").val())!="")
                        {
                          allblank4.push('true');
                        }
                        else
                        {
                          allblank4.push('true');
                        }
                        if($.trim($('#Tax_State').val())=="WithinState")
                        {
                          if($.trim($(this).find("[id*=IGST]").val())!="")
                          {
                            allblank5.push('true');
                          }
                          else
                          {
                            allblank5.push('true');
                          }
                        }
                        else
                        {
                          if($.trim($(this).find("[id*=CGST]").val())!="")
                          {
                            allblank5.push('true');
                          }
                          else
                          {
                            allblank5.push('true');
                          }
                          if($.trim($(this).find("[id*=SGST]").val())!="")
                          {
                            allblank5.push('true');
                          }
                          else
                          {
                            allblank5.push('true');
                          }
                        }
                  }
                  else
                  {
                        allblank2.push('false');
                  }
            }
            else
            {
                  allblank.push('false');
            }
        });
        if($('#TNCID_REF').val() !="")
        {
            $('#TC').find('.participantRow3').each(function(){
              if($.trim($(this).find("[id*=TNCDID_REF]").val())!="")
                {
                    allblank6.push('true');
                        if($.trim($(this).find("[id*=TNCismandatory]").val())=="1"){
                              if($.trim($(this).find('[id*="tncdetvalue"]').val()) != "")
                              {
                                allblank7.push('true');
                              }
                              else
                              {
                                allblank7.push('false');
                              } 
                        } 
                }
                else
                {
                    allblank6.push('false');
                } 
            });
        }
        if($('#CTID_REF').val() !="")
        {
            $('#CT').find('.participantRow5').each(function(){
              if($.trim($(this).find("[id*=TID_REF]").val())!="")
                {
                  allblank8.push('true');
                        if($(this).find("[id*=calGST]").is(":checked") == true)
                        {
                          if($.trim($('#Tax_State').val())!="WithinState")
                          {
                            if($.trim($(this).find("[id*=calIGST]").val())!="0")
                            {
                              allblank9.push('true');
                            }
                            else
                            {
                              allblank9.push('false');
                            }
                          }
                          else
                          {
                            if($.trim($(this).find("[id*=calCGST]").val())!="0")
                            {
                              allblank9.push('true');
                            }
                            else
                            {
                              allblank9.push('false');
                            }
                            if($.trim($(this).find("[id*=calSGST]").val())!="0")
                            {
                              allblank9.push('true');
                            }
                            else
                            {
                              allblank9.push('false');
                            }
                          }
                        } 
                }
                else
                {
                    allblank8.push('false');
                } 
            });
        }
        $('#PaymentSlabs').find('.participantRow6').each(function(){
              if($.trim($(this).find("[id*=PAY_DAYS_]").val())!="")
                {
                  if($.trim($(this).find('[id*="DUE_"]').val()) != "")
                  {
                    allblank10.push('true');
                  }
                  else
                  {
                    allblank10.push('false');
                  }       
                }                
        });
        $('#udf').find('.participantRow4').each(function(){
              if($.trim($(this).find("[id*=UDFPBID_REF_]").val())!="")
                {
                    allblank8.push('true');
                        if($.trim($(this).find("[id*=UDFismandatory]").val())=="1"){
                              if($.trim($(this).find('[id*="udfvalue"]').val()) != "")
                              {
                                allblank11.push('true');
                              }
                              else
                              {
                                allblank11.push('false');
                              }
                        }  
                }                
        });

    }
        
        if(jQuery.inArray("false", allblank) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please select GRN in Material Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank2) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please select Item in Material Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank3) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Bill Quantity must be greater than Zero in Material Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          } 
        else if(jQuery.inArray("false", allblank4) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Rate must be greater than Zero in Material Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          }
        else if(jQuery.inArray("false", allblank5) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter GST Rate in Material Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          }
        else if(jQuery.inArray("false", allblank7) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter Value / Comment in T&C Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          } 
        else if(jQuery.inArray("false", allblank9) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter GST Rate in Calculation Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          }
        else if(jQuery.inArray("false", allblank10) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter Due details in Payment Slab Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          } 
        else if(jQuery.inArray("false", allblank11) !== -1){
          $("#FocusId").val($("#tot_amt"));
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter Value / Comment in UDF Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          }
        else{
                $("#alert").modal('show');
                $("#AlertMessage").text('Do you want to Approve to record.');
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

var trnpbForm = $("#frm_trn_pbi");
var formData = trnpbForm.serialize();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'{{ route("transaction",[$FormId,"update"])}}',
    type:'POST',
    data:formData,
    success:function(data) {
       
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

var trnpbForm = $("#frm_trn_pbi");
var formData = trnpbForm.serialize();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'{{ route("transaction",[$FormId,"Approve"])}}',
    type:'POST',
    data:formData,
    success:function(data) {
       
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

$("#NoBtn").click(function(){
    $("#alert").modal('hide');
    $("#LABEL").focus();
});

$("#OkBtn").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $(".text-danger").hide();
    window.location.href = '{{route("transaction",[$FormId,"index"]) }}';
});

$("#OkBtn1").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $("#OkBtn1").hide();
    $("#"+$(this).data('focusname')).focus();
    $(".text-danger").hide();
});

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

//===========================================================

//Template Master 
let tempid = "#TemplateIDTable2";
let tempid2 = "#TemplateIDTable";
let tempheaders = document.querySelectorAll(tempid2 + " th");

// Sort the table element when clicking on the table headers
tempheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(tempid, ".clsTemplateid", "td:nth-child(" + (i + 1) + ")");
  });
});

function TemplateCodeFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("Templatecodesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("TemplateTable2");
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

function TemplateDateFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("Templatenamesearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("TemplateTable2");
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

$('#ADDITIONAL').on('click','#txtTemplate_popup',function(event){
var hidden_value=$('#TEMPID_REF').val();
showSelectedCheck(hidden_value,'SELECT_TEMPLATE'); 
      $("#Templatepopup").show();
      event.preventDefault();
  });

  $("#Template_closePopup").click(function(event){
    $("#Templatepopup").hide();
  });

  $(".clstemplateid").click(function(){
    var fieldid = $(this).attr('id');
    var txtval =    $("#txt"+fieldid+"").val();
    var texdesc =   $("#txt"+fieldid+"").data("desc");
    var template_name=$("#txt"+fieldid+"").data("desc");
    var template_desc=$("#txt"+fieldid+"").data("desc3");

    // var txtid= $('#hdn_fieldid').val();
    // var txt_id2= $('#hdn_fieldid2').val();
    
    $('#txtTemplate_popup').val(texdesc);
    $('#TEMPID_REF').val(txtval);
    CKEDITOR.instances.Template_Description.setData(template_desc)   

    $("#Templatepopup").hide();
    $("#Templatecodesearch").val(''); 
    $("#Templatenamesearch").val('');         
    // event.preventDefault();
  });
// End Template Master

function getActionEvent(){
  getTotalRowValue();
  taxStatusWiseTaxCalculation();
  //reverse_gst();

}

function getTotalRowValue(){

  var RECEIVED_QTY      = 0;
  var RECEIVED_ALT_QTY  = 0;
  var BILL_QTY          = 0;
  var BILL_RATEPUOM     = 0;
  var DISC_AMT          = 0;
  var TAX_AMT           = 0;
  var IGST_AMT          = 0;
  var CGST_AMT          = 0;
  var SGST_AMT          = 0;
  var TGST_AMT          = 0;
  var TT_AMT            = 0;

  $('#Material').find('.participantRow').each(function(){
    RECEIVED_QTY        = $(this).find('[id*="RECEIVED_QTY"]').val() > 0?RECEIVED_QTY+parseFloat($(this).find('[id*="RECEIVED_QTY"]').val()):RECEIVED_QTY;
    RECEIVED_ALT_QTY        = $(this).find('[id*="RECEIVED_ALT_QTY"]').val() > 0?RECEIVED_ALT_QTY+parseFloat($(this).find('[id*="RECEIVED_ALT_QTY"]').val()):RECEIVED_ALT_QTY;
    BILL_QTY        = $(this).find('[id*="BILL_QTY"]').val() > 0?BILL_QTY+parseFloat($(this).find('[id*="BILL_QTY"]').val()):BILL_QTY;
    BILL_RATEPUOM      = $(this).find('[id*="BILL_RATEPUOM"]').val() > 0?BILL_RATEPUOM+parseFloat($(this).find('[id*="BILL_RATEPUOM"]').val()):BILL_RATEPUOM;
    DISC_AMT  = $(this).find('[id*="DISC_AMT"]').val() > 0?DISC_AMT+parseFloat($(this).find('[id*="DISC_AMT"]').val()):DISC_AMT;
    TAX_AMT   = $(this).find('[id*="TAX_AMT"]').val() > 0?TAX_AMT+parseFloat($(this).find('[id*="TAX_AMT"]').val()):TAX_AMT;
    IGST_AMT       = $(this).find('[id*="IGST_AMT"]').val() > 0?IGST_AMT+parseFloat($(this).find('[id*="IGST_AMT"]').val()):IGST_AMT;
    CGST_AMT       = $(this).find('[id*="CGST_AMT"]').val() > 0?CGST_AMT+parseFloat($(this).find('[id*="CGST_AMT"]').val()):CGST_AMT;
    SGST_AMT       = $(this).find('[id*="SGST_AMT"]').val() > 0?SGST_AMT+parseFloat($(this).find('[id*="SGST_AMT"]').val()):SGST_AMT;
    TGST_AMT      = $(this).find('[id*="TGST_AMT"]').val() > 0?TGST_AMT+parseFloat($(this).find('[id*="TGST_AMT"]').val()):TGST_AMT;
    TT_AMT       = $(this).find('[id*="TT_AMT"]').val() > 0?TT_AMT+parseFloat($(this).find('[id*="TT_AMT"]').val()):TT_AMT;
  });

  
  RECEIVED_QTY          = RECEIVED_QTY > 0?parseFloat(RECEIVED_QTY).toFixed(3):'';
  RECEIVED_ALT_QTY          = RECEIVED_ALT_QTY > 0?parseFloat(RECEIVED_ALT_QTY).toFixed(3):'';
  BILL_QTY          = BILL_QTY > 0?parseFloat(BILL_QTY).toFixed(3):'';
  BILL_RATEPUOM        = BILL_RATEPUOM > 0?parseFloat(BILL_RATEPUOM).toFixed(5):'';
  DISC_AMT    = DISC_AMT > 0?parseFloat(DISC_AMT).toFixed(2):'';
  TAX_AMT     = TAX_AMT > 0?parseFloat(TAX_AMT).toFixed(2):'';
  IGST_AMT         = IGST_AMT > 0?parseFloat(IGST_AMT).toFixed(2):'';
  CGST_AMT         = CGST_AMT > 0?parseFloat(CGST_AMT).toFixed(2):'';
  SGST_AMT         = SGST_AMT > 0?parseFloat(SGST_AMT).toFixed(2):'';
  TGST_AMT        = TGST_AMT > 0?parseFloat(TGST_AMT).toFixed(2):'';
  TT_AMT         = TT_AMT > 0?parseFloat(TT_AMT).toFixed(2):'';
  
  $("#RECEIVED_QTY_total").text(RECEIVED_QTY);
  $("#RECEIVED_ALT_QTY_total").text(RECEIVED_ALT_QTY);
  $("#BILL_QTY_total").text(BILL_QTY);
  $("#BILL_RATEPUOM_total").text(BILL_RATEPUOM);
  $("#DISC_AMT_total").text(DISC_AMT);
  $("#TAX_AMT_total").text(TAX_AMT);
  $("#IGST_AMT_total").text(IGST_AMT);
  $("#CGST_AMT_total").text(CGST_AMT);
  $("#SGST_AMT_total").text(SGST_AMT);
  $("#TGST_AMT_total").text(TGST_AMT);
  $("#TT_AMT_total").text(TT_AMT);

}


function getTaxStatus(customid){

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
    url:'{{route("transaction",[$FormId,"getTaxStatus"])}}',
    type:'POST',
    data:{id:customid},
    success:function(data) {
      if(data =="1"){
        $(".ExceptionalGST").show();
        $("#EXE_GST").prop('checked', true);
      }
      else{
        $(".ExceptionalGST").hide();
        $("#EXE_GST").prop('checked', false);
      }   
    },
    error:function(data){
    console.log("Error: Something went wrong.");                  
    },
  });
}


function taxStatusWiseTaxCalculation(){
  
  if($("#EXE_GST").is(":checked") == true){
    $('#Material').find('.participantRow').each(function(){

      var id      = $(this).find('[id*="IGST"]').attr('id');
      var ROW_ID  = id.split('_').pop();

      IGST  = parseFloat($("#IGST_"+ROW_ID).val());
      CGST  = parseFloat($("#CGST_"+ROW_ID).val());
      SGST  = parseFloat($("#SGST_"+ROW_ID).val());

      if(IGST > 0){
        $("#IGST_"+ROW_ID).prop('readonly', false);
      }

      if(CGST > 0){
        $("#CGST_"+ROW_ID).prop('readonly', false);
      }

      if(SGST > 0){
        $("#SGST_"+ROW_ID).prop('readonly', false);
      }
    });
  }
}

function getExceptionalGst(){
  taxStatusWiseTaxCalculation();

  if($("#EXE_GST").is(":checked") == false){
    $('#TotalValue').val('0.00');
    $('#Material').find('.participantRow').each(function(){
      var rowcount = $(this).closest('table').find('.participantRow').length;
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');

      $(this).find('[id*="IGST"]').prop('readonly', true);
      $(this).find('[id*="CGST"]').prop('readonly', true);
      $(this).find('[id*="SGST"]').prop('readonly', true);

      if(rowcount > 1){
        $(this).closest('.participantRow').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count1').val(rowcount);
      }
    });

    
    $('#txtTNCID_popup').val('');
    $('#TNCID_REF').val('');
    $('#TC').find('.participantRow3').each(function(){
      var rowcount = $(this).closest('table').find('.participantRow3').length;
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count2').val();
      if(rowcount > 1){
        $(this).closest('.participantRow3').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count2').val(rowcount);
      }
    });

    $('#txtCTID_popup').val('');
    $('#CTID_REF').val('');
    $('#CT').find('.participantRow5').each(function(){
      var rowcount = $(this).closest('table').find('.participantRow5').length;
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      $(this).find('input:checkbox').removeAttr('checked');
      var rowcount = $('#Row_Count4').val();
      if(rowcount > 1){
        $(this).closest('.participantRow5').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count4').val(rowcount);
      }
    });

    $('#PaymentSlabs').find('.participantRow6').each(function(){
      var rowcount = $(this).closest('table').find('.participantRow6').length;
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      if(rowcount > 1){
        $(this).closest('.participantRow6').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count5').val(rowcount);
      }
    });

    $('#TDS').find('.participantRow7').each(function(){
      var rowcount = $(this).closest('table').find('.participantRow7').length;
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      $(this).find('input:checkbox').removeAttr('checked');
      var rowcount = $('#Row_Count4').val();
      if(rowcount > 1){
        $(this).closest('.participantRow7').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count4').val(rowcount);
      }
    });

    $("#RECEIVED_QTY_total").text('');
    $("#RECEIVED_ALT_QTY_total").text('');
    $("#BILL_QTY_total").text('');
    $("#BILL_RATEPUOM_total").text('');
    $("#DISC_AMT_total").text('');
    $("#TAX_AMT_total").text('');
    $("#IGST_AMT_total").text('');
    $("#CGST_AMT_total").text('');
    $("#SGST_AMT_total").text('');
    $("#TGST_AMT_total").text('');
    $("#TT_AMT_total").text('');

  }

}

function taxGstCalculation(id,value){
  var field   = id.split('_');
  var FIELD   = field[0];
  var ROW_ID  = field[1];

  if(FIELD =="CGST" && value > 0){
    $("#SGST_"+ROW_ID).val(parseFloat(value).toFixed(4));
  }

  if(FIELD =="SGST" && value > 0){
    $("#CGST_"+ROW_ID).val(parseFloat(value).toFixed(4));
  }

  getAllMaterialCalculation();
}


function getAllMaterialCalculation(){

  $('#Material').find('.participantRow').each(function(){

    var totalvalue  = 0.00;
    var itemid      = $(this).find('[id*="ITEMID_REF"]').val();
    var mqty        = $(this).find('[id*="BILL_QTY"]').val();
    //var altuomid    = $(this).find('[id*="ALT_UOMID_REF"]').val();
    //var txtid       = $(this).find('[id*="ALT_UOMID_QTY"]').attr('id');
    var irate       = $(this).find('[id*="BILL_RATEPUOM"]').val();

  $(this).find('[id*="IGSTAMT"]').val('0');
  $(this).find('[id*="CGSTAMT"]').val('0');
  $(this).find('[id*="SGSTAMT"]').val('0');

  var tamt = parseFloat(parseFloat(mqty)*parseFloat(irate)).toFixed(2);
  var dispercnt = $(this).find('[id*="DISC_PER"]').val();
  var disamt = 0 ;      
  if (dispercnt != '' && dispercnt != '.0000')
  {
     disamt =  parseFloat((parseFloat(tamt)*parseFloat(dispercnt))/100).toFixed(2);
  }
  else if ($(this).find('[id*="DISC_AMT"]').val() != '' && $(this).find('[id*="DISC_AMT"]').val() != '0.00')
  {
     disamt = $(this).find('[id*="DISC_AMT"]').val();
  }
  tamt = parseFloat(parseFloat(tamt) - parseFloat(disamt)).toFixed(2);   
  var tp1 = $(this).find('[id*="IGST_"]').val();
  var tp2 = $(this).find('[id*="CGST_"]').val();
  var tp3 = $(this).find('[id*="SGST_"]').val();
  var tp1amt = parseFloat((tamt * tp1)/100).toFixed(2);
  var tp2amt = parseFloat((tamt * tp2)/100).toFixed(2);
  var tp3amt = parseFloat((tamt * tp3)/100).toFixed(2);
  var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2); 
  var totamt = parseFloat(parseFloat(tamt) + parseFloat(taxamt)).toFixed(2);

  if(intRegex.test($(this).val())){
    $(this).val($(this).val()+'.000');
  }
  if(intRegex.test(tamt)){
    tamt = tamt +'.00';
  }
  if(intRegex.test(totamt)){
    totamt = totamt +'.00';
  }
  if(intRegex.test(taxamt)){
    taxamt = taxamt +'.00';
  }
  if(intRegex.test(tp1amt)){
    tp1amt = tp1amt +'.00';
  }
  if(intRegex.test(tp2amt)){
    tp2amt = tp2amt +'.00';
  }
  if(intRegex.test(tp3amt)){
    tp3amt = tp3amt +'.00';
  }

  $(this).find('[id*="TAX_AMT"]').val(tamt);
  $(this).find('[id*="TT_AMT"]').val(totamt);
  $(this).find('[id*="TGST_AMT"]').val(taxamt);
  $(this).find('[id*="IGST_AMT"]').val(tp1amt);
  $(this).find('[id*="CGST_AMT"]').val(tp2amt);
  $(this).find('[id*="SGST_AMT"]').val(tp3amt);

  bindTotalValue();
  if($('#CTID_REF').val()!=''){
    bindGSTCalTemplate();
  }
  bindTotalValue();
 
  });
}

$("#Material").on('focusout', "[id*='BILL_QTY']", function() 
{
  var totalamount = 0.00;
  if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0')
  { 
    var receivedqty = $(this).parent().parent().find('[id*="RECEIVED_QTY"]').val(); 
    if(parseFloat(receivedqty) < parseFloat($(this).val()))   
    {
        $(this).val('');
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn").hide();
        $("#OkBtn1").show();
        $("#AlertMessage").text('Bill Quantity cannot be greater than Received Quantity.');
        $("#alert").modal('show');
        $("#OkBtn1").focus();
        highlighFocusBtn('activeOk1');
        return false;
    }
    else
    {
        var irate = $(this).parent().parent().find('[id*="BILL_RATEPUOM"]').val();
        var mqty = $(this).val();
        $(this).parent().parent().find('[id*="IGST_AMT_"]').val('0');
        $(this).parent().parent().find('[id*="CGST_AMT_"]').val('0');
        $(this).parent().parent().find('[id*="SGST_AMT_"]').val('0');
        var tamt = parseFloat(parseFloat(mqty)*parseFloat(irate)).toFixed(2);
        var dispercnt = $(this).parent().parent().find('[id*="DISC_PER_"]').val();
        var disamt = 0 ;      
        if (dispercnt != '' && dispercnt != '.0000')
        {
           disamt =  parseFloat((parseFloat(tamt)*parseFloat(dispercnt))/100).toFixed(2);
        }
        else if ($(this).parent().parent().find('[id*="DISC_AMT_"]').val() != '' && $(this).parent().parent().find('[id*="DISC_AMT_"]').val() != '0.00')
        {
           disamt = $(this).parent().parent().find('[id*="DISC_AMT_"]').val();
        }
        tamt = parseFloat(parseFloat(tamt) - parseFloat(disamt)).toFixed(2);   
        var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
        var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
        var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
        var tp1amt = parseFloat((tamt * tp1)/100).toFixed(2);
        var tp2amt = parseFloat((tamt * tp2)/100).toFixed(2);
        var tp3amt = parseFloat((tamt * tp3)/100).toFixed(2);
        var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2); 
        var totamt = parseFloat(parseFloat(tamt) + parseFloat(taxamt)).toFixed(2);
        
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.000');
      }
      if(intRegex.test(tamt)){
        tamt = tamt +'.00';
      }
      if(intRegex.test(totamt)){
        totamt = totamt +'.00';
      }
      if(intRegex.test(taxamt)){
        taxamt = taxamt +'.00';
      }
      if(intRegex.test(tp1amt)){
        tp1amt = tp1amt +'.00';
      }
      if(intRegex.test(tp2amt)){
        tp2amt = tp2amt +'.00';
      }
      if(intRegex.test(tp3amt)){
        tp3amt = tp3amt +'.00';
      }
      $(this).parent().parent().find('[id*="TAX_AMT_"]').val(tamt);
      $(this).parent().parent().find('[id*="TT_AMT_"]').val(totamt);
      $(this).parent().parent().find('[id*="TGST_AMT_"]').val(taxamt);
      $(this).parent().parent().find('[id*="IGST_AMT_"]').val(tp1amt);
      $(this).parent().parent().find('[id*="CGST_AMT_"]').val(tp2amt);
      $(this).parent().parent().find('[id*="SGST_AMT_"]').val(tp3amt);
      bindTotalValue();
      if($('#CTID_REF').val()!='')
      {
      bindGSTCalTemplate();
      }
      bindTotalValue();
      event.preventDefault();
    }
  }
  else
  {
      $(this).val('');
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn").hide();
      $("#OkBtn1").show();
      $("#AlertMessage").text('Bill Quantity must be greater than Zero.');
      $("#alert").modal('show');
      $("#OkBtn1").focus();
      highlighFocusBtn('activeOk1');
      return false;
  }

  getActionEvent();

});

$("#Material").on('focusout', "[id*='BILL_RATEPUOM']", function() 
{

  var totalamount = 0.00;
  if($(this).val() != '' && $(this).val() != '.00000' && $(this).val() > '0')
  { 
        var mqty = $(this).parent().parent().find('[id*="BILL_QTY_"]').val();
        var irate = $(this).val();
        $(this).parent().parent().find('[id*="IGST_AMT_"]').val('0');
        $(this).parent().parent().find('[id*="CGST_AMT_"]').val('0');
        $(this).parent().parent().find('[id*="SGST_AMT_"]').val('0');
        var tamt = parseFloat(parseFloat(mqty)*parseFloat(irate)).toFixed(2);
        var dispercnt = $(this).parent().parent().find('[id*="DISC_PER_"]').val();
        var disamt = 0 ;      
        if (dispercnt != '' && dispercnt != '.0000')
        {
           disamt =  parseFloat((parseFloat(tamt)*parseFloat(dispercnt))/100).toFixed(2);
        }
        else if ($(this).parent().parent().find('[id*="DISC_AMT_"]').val() != '' && $(this).parent().parent().find('[id*="DISC_AMT_"]').val() != '0.00')
        {
           disamt = $(this).parent().parent().find('[id*="DISC_AMT_"]').val();
        }
        tamt = parseFloat(parseFloat(tamt) - parseFloat(disamt)).toFixed(2);   
        var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
        var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
        var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
        var tp1amt = parseFloat((tamt * tp1)/100).toFixed(2);
        var tp2amt = parseFloat((tamt * tp2)/100).toFixed(2);
        var tp3amt = parseFloat((tamt * tp3)/100).toFixed(2);
        var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2); 
        var totamt = parseFloat(parseFloat(tamt) + parseFloat(taxamt)).toFixed(2);
        
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.000');
      }
      if(intRegex.test(tamt)){
        tamt = tamt +'.00';
      }
      if(intRegex.test(totamt)){
        totamt = totamt +'.00';
      }
      if(intRegex.test(taxamt)){
        taxamt = taxamt +'.00';
      }
      if(intRegex.test(tp1amt)){
        tp1amt = tp1amt +'.00';
      }
      if(intRegex.test(tp2amt)){
        tp2amt = tp2amt +'.00';
      }
      if(intRegex.test(tp3amt)){
        tp3amt = tp3amt +'.00';
      }
      $(this).parent().parent().find('[id*="TAX_AMT_"]').val(tamt);
      $(this).parent().parent().find('[id*="TT_AMT_"]').val(totamt);
      $(this).parent().parent().find('[id*="TGST_AMT_"]').val(taxamt);
      $(this).parent().parent().find('[id*="IGST_AMT_"]').val(tp1amt);
      $(this).parent().parent().find('[id*="CGST_AMT_"]').val(tp2amt);
      $(this).parent().parent().find('[id*="SGST_AMT_"]').val(tp3amt);
      bindTotalValue();
      if($('#CTID_REF').val()!='')
      {
      bindGSTCalTemplate();
      }
      
      bindTotalValue();
      
      event.preventDefault();
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


$("#Material").on('focusout', "[id*='DISC_PER']", function() 
{
    var mqty = $(this).parent().parent().find('[id*="BILL_QTY_"]').val();
    var irate = $(this).parent().parent().find('[id*="BILL_RATEPUOM_"]').val();
    var totamt = parseFloat(parseFloat(mqty)*parseFloat(irate)).toFixed(2);
    var dpert = $(this).val();
    
    if (dpert != '' && dpert != '.0000')
    {
      var disamt = parseFloat((parseFloat(totamt)*parseFloat(dpert))/100).toFixed(2);
      var amtfd = parseFloat(parseFloat(totamt) - (parseFloat(totamt)*parseFloat(dpert))/100).toFixed(2);
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.0000')
      }
      var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
      var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
      var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
      $(this).parent().parent().find('[id*="IGST_AMT_"]').val('0');
      $(this).parent().parent().find('[id*="CGST_AMT_"]').val('0');
      $(this).parent().parent().find('[id*="SGST_AMT_"]').val('0');
      var tp1amt = parseFloat((amtfd * tp1)/100).toFixed(2);
      var tp2amt = parseFloat((amtfd * tp2)/100).toFixed(2);
      var tp3amt = parseFloat((amtfd * tp3)/100).toFixed(2);
      
      var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2);      
      var netamt = parseFloat(parseFloat(amtfd) + parseFloat(taxamt)).toFixed(2);
      if(intRegex.test(amtfd)){
        amtfd = amtfd +'.00';
      }
      if(intRegex.test(taxamt)){
      taxamt = taxamt +'.00';
      }
      if(intRegex.test(tp1amt)){
        tp1amt = tp1amt +'.00';
      }
      if(intRegex.test(tp2amt)){
        tp2amt = tp2amt +'.00';
      }
      if(intRegex.test(tp3amt)){
        tp3amt = tp3amt +'.00';
      }
      if(intRegex.test(netamt)){
        netamt = netamt +'.00';
      }
      $(this).parent().parent().find('[id*="DISC_AMT_"]').val(disamt);
      $(this).parent().parent().find('[id*="TAX_AMT_"]').val(amtfd);
      $(this).parent().parent().find('[id*="TT_AMT"]').val(netamt);
      $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
      $(this).parent().parent().find('[id*="IGST_AMT_"]').val(tp1amt);
      $(this).parent().parent().find('[id*="CGST_AMT_"]').val(tp2amt);
      $(this).parent().parent().find('[id*="SGST_AMT_"]').val(tp3amt);
    }
    else
    {
      if($(this).parent().parent().find('[id*="DISC_AMT_"]').val() != '' && $(this).parent().parent().find('[id*="DISC_AMT_"]').val() != '.00')
      {
        var disamt = $(this).parent().parent().find('[id*="DISC_AMT_"]').val();
        var disper = parseFloat((parseFloat(disamt)*100)/parseFloat(totamt)).toFixed(4);
        var amtfd = parseFloat(parseFloat(totamt) - parseFloat(disamt)).toFixed(2);
        var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
        var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
        var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
        $(this).parent().parent().find('[id*="IGST_AMT_"]').val('0');
        $(this).parent().parent().find('[id*="CGST_AMT_"]').val('0');
        $(this).parent().parent().find('[id*="SGST_AMT_"]').val('0');
        var tp1amt = parseFloat((amtfd * tp1)/100).toFixed(2);
        var tp2amt = parseFloat((amtfd * tp2)/100).toFixed(2);
        var tp3amt = parseFloat((amtfd * tp3)/100).toFixed(2);
        
        var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2);      
        var netamt = parseFloat(parseFloat(amtfd) + parseFloat(taxamt)).toFixed(2);
        if(intRegex.test(amtfd)){
          amtfd = amtfd +'.00';
        }
        if(intRegex.test(taxamt)){
        taxamt = taxamt +'.00';
        }
        if(intRegex.test(tp1amt)){
          tp1amt = tp1amt +'.00';
        }
        if(intRegex.test(tp2amt)){
          tp2amt = tp2amt +'.00';
        }
        if(intRegex.test(tp3amt)){
          tp3amt = tp3amt +'.00';
        }
        if(intRegex.test(netamt)){
          netamt = netamt +'.00';
        }
        $(this).parent().parent().find('[id*="DISC_PER"]').val(disper);
        $(this).parent().parent().find('[id*="TAX_AMT_"]').val(amtfd);
        $(this).parent().parent().find('[id*="TT_AMT"]').val(netamt);
        $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
        $(this).parent().parent().find('[id*="IGST_AMT_"]').val(tp1amt);
        $(this).parent().parent().find('[id*="CGST_AMT_"]').val(tp2amt);
        $(this).parent().parent().find('[id*="SGST_AMT_"]').val(tp3amt);
      }
      else
      {
        var amtfd = parseFloat(totamt).toFixed(2);
        var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
        var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
        var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
        $(this).parent().parent().find('[id*="IGST_AMT_"]').val('0');
        $(this).parent().parent().find('[id*="CGST_AMT_"]').val('0');
        $(this).parent().parent().find('[id*="SGST_AMT_"]').val('0');
        var tp1amt = parseFloat((amtfd * tp1)/100).toFixed(2);
        var tp2amt = parseFloat((amtfd * tp2)/100).toFixed(2);
        var tp3amt = parseFloat((amtfd * tp3)/100).toFixed(2);
        var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2);      
        var netamt = parseFloat(parseFloat(amtfd) + parseFloat(taxamt)).toFixed(2);
        if(intRegex.test($(this).val())){
          $(this).val($(this).val()+'.00')
        }
        if(intRegex.test(amtfd)){
          amtfd = amtfd +'.00';
        }
        if(intRegex.test(taxamt)){
        taxamt = taxamt +'.00';
        }
        if(intRegex.test(tp1amt)){
          tp1amt = tp1amt +'.00';
        }
        if(intRegex.test(tp2amt)){
          tp2amt = tp2amt +'.00';
        }
        if(intRegex.test(tp3amt)){
          tp3amt = tp3amt +'.00';
        }
        if(intRegex.test(netamt)){
          netamt = netamt +'.00';
        }
        $(this).parent().parent().find('[id*="DISC_AMT_"]').val('0.00');
        $(this).parent().parent().find('[id*="DISC_PER"]').val('0.0000');
        $(this).parent().parent().find('[id*="TAX_AMT_"]').val(amtfd);
        $(this).parent().parent().find('[id*="TT_AMT_"]').val(netamt);
        $(this).parent().parent().find('[id*="TGST_AMT_"]').val(taxamt);
        $(this).parent().parent().find('[id*="IGST_AMT_"]').val(tp1amt);
        $(this).parent().parent().find('[id*="CGST_AMT_"]').val(tp2amt);
        $(this).parent().parent().find('[id*="SGST_AMT_"]').val(tp3amt);
      }
    }
    bindTotalValue();
    if($('#CTID_REF').val()!='')
    {
    bindGSTCalTemplate();
    }
    bindTotalValue();
    getActionEvent();
    event.preventDefault();  
});

$("#Material").on('focusout', "[id*='DISC_AMT_']", function() 
{
  var mqty = $(this).parent().parent().find('[id*="BILL_QTY_"]').val();
  var irate = $(this).parent().parent().find('[id*="BILL_RATEPUOM_"]').val();
  var totamt = parseFloat(parseFloat(mqty)*parseFloat(irate)).toFixed(2);

  if($(this).val() != '' && $(this).val() != '.00')
  {
    if(intRegex.test($(this).val())){
      $(this).val($(this).val() +'.00');
    }
      var disamt = $(this).val();
      var disper = parseFloat((parseFloat(disamt)*100)/parseFloat(totamt)).toFixed(4);
      var amtfd = parseFloat(parseFloat(totamt) - parseFloat(disamt)).toFixed(2);
      var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
      var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
      var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
      $(this).parent().parent().find('[id*="IGST_AMT_"]').val('0');
      $(this).parent().parent().find('[id*="CGST_AMT_"]').val('0');
      $(this).parent().parent().find('[id*="SGST_AMT_"]').val('0');
      var tp1amt = parseFloat((amtfd * tp1)/100).toFixed(2);
      var tp2amt = parseFloat((amtfd * tp2)/100).toFixed(2);
      var tp3amt = parseFloat((amtfd * tp3)/100).toFixed(2);
      
      var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2);      
      var netamt = parseFloat(parseFloat(amtfd) + parseFloat(taxamt)).toFixed(2);
      if(intRegex.test(amtfd)){
        amtfd = amtfd +'.00';
      }
      if(intRegex.test(taxamt)){
      taxamt = taxamt +'.00';
      }
      if(intRegex.test(tp1amt)){
        tp1amt = tp1amt +'.00';
      }
      if(intRegex.test(tp2amt)){
        tp2amt = tp2amt +'.00';
      }
      if(intRegex.test(tp3amt)){
        tp3amt = tp3amt +'.00';
      }
      if(intRegex.test(netamt)){
        netamt = netamt +'.00';
      }
      $(this).parent().parent().find('[id*="DISC_PER"]').val(disper);
      $(this).parent().parent().find('[id*="TAX_AMT_"]').val(amtfd);
      $(this).parent().parent().find('[id*="TT_AMT"]').val(netamt);
      $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
      $(this).parent().parent().find('[id*="IGST_AMT_"]').val(tp1amt);
      $(this).parent().parent().find('[id*="CGST_AMT_"]').val(tp2amt);
      $(this).parent().parent().find('[id*="SGST_AMT_"]').val(tp3amt);
  }
  else
  {
    if($(this).parent().parent().find('[id*="DISC_PER"]').val() != '' && $(this).parent().parent().find('[id*="DISC_PER"]').val() != '.00')
    {
      var disper = $(this).parent().parent().find('[id*="DISC_PER"]').val();
      var disamt = parseFloat((parseFloat(disamt)*parseFloat(totamt))/100).toFixed(2);
      var amtfd = parseFloat(parseFloat(totamt) - parseFloat(disamt)).toFixed(2);
      var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
      var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
      var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
      $(this).parent().parent().find('[id*="IGST_AMT_"]').val('0');
      $(this).parent().parent().find('[id*="CGST_AMT_"]').val('0');
      $(this).parent().parent().find('[id*="SGST_AMT_"]').val('0');
      var tp1amt = parseFloat((amtfd * tp1)/100).toFixed(2);
      var tp2amt = parseFloat((amtfd * tp2)/100).toFixed(2);
      var tp3amt = parseFloat((amtfd * tp3)/100).toFixed(2);
      
      var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2);      
      var netamt = parseFloat(parseFloat(amtfd) + parseFloat(taxamt)).toFixed(2);
      if(intRegex.test(amtfd)){
        amtfd = amtfd +'.00';
      }
      if(intRegex.test(taxamt)){
      taxamt = taxamt +'.00';
      }
      if(intRegex.test(tp1amt)){
        tp1amt = tp1amt +'.00';
      }
      if(intRegex.test(tp2amt)){
        tp2amt = tp2amt +'.00';
      }
      if(intRegex.test(tp3amt)){
        tp3amt = tp3amt +'.00';
      }
      if(intRegex.test(netamt)){
        netamt = netamt +'.00';
      }
      $(this).parent().parent().find('[id*="DISC_AMT_"]').val(disamt);
      $(this).parent().parent().find('[id*="TAX_AMT_"]').val(amtfd);
      $(this).parent().parent().find('[id*="TT_AMT"]').val(netamt);
      $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
      $(this).parent().parent().find('[id*="IGST_AMT_"]').val(tp1amt);
      $(this).parent().parent().find('[id*="CGST_AMT_"]').val(tp2amt);
      $(this).parent().parent().find('[id*="SGST_AMT_"]').val(tp3amt);
    }
    else
    {
      var amtfd = parseFloat(totamt).toFixed(2);
      var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
      var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
      var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
      $(this).parent().parent().find('[id*="IGST_AMT_"]').val('0');
      $(this).parent().parent().find('[id*="CGST_AMT_"]').val('0');
      $(this).parent().parent().find('[id*="SGST_AMT_"]').val('0');
      var tp1amt = parseFloat((amtfd * tp1)/100).toFixed(2);
      var tp2amt = parseFloat((amtfd * tp2)/100).toFixed(2);
      var tp3amt = parseFloat((amtfd * tp3)/100).toFixed(2);
      var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2);      
      var netamt = parseFloat(parseFloat(amtfd) + parseFloat(taxamt)).toFixed(2);
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00')
      }
      if(intRegex.test(amtfd)){
        amtfd = amtfd +'.00';
      }
      if(intRegex.test(taxamt)){
      taxamt = taxamt +'.00';
      }
      if(intRegex.test(tp1amt)){
        tp1amt = tp1amt +'.00';
      }
      if(intRegex.test(tp2amt)){
        tp2amt = tp2amt +'.00';
      }
      if(intRegex.test(tp3amt)){
        tp3amt = tp3amt +'.00';
      }
      if(intRegex.test(netamt)){
        netamt = netamt +'.00';
      }
      $(this).parent().parent().find('[id*="DISC_AMT_"]').val('0.00');
      $(this).parent().parent().find('[id*="DISC_PER"]').val('0.0000');
      $(this).parent().parent().find('[id*="TAX_AMT_"]').val(amtfd);
      $(this).parent().parent().find('[id*="TT_AMT_"]').val(netamt);
      $(this).parent().parent().find('[id*="TGST_AMT_"]').val(taxamt);
      $(this).parent().parent().find('[id*="IGST_AMT_"]').val(tp1amt);
      $(this).parent().parent().find('[id*="CGST_AMT_"]').val(tp2amt);
      $(this).parent().parent().find('[id*="SGST_AMT_"]').val(tp3amt);
    }
  }
  bindTotalValue();
  if($('#CTID_REF').val()!='')
  {
  bindGSTCalTemplate();
  }
  bindTotalValue();

  getActionEvent();
  event.preventDefault();  
});

function bindGSTCalTemplate(){ 
          $('#CT').find('.participantRow5').each(function()
            { 
                var basis = $(this).find('[id*="BASIS"]').val();
                var sqno = $(this).find('[id*="SQNO"]').val();
                var formula = $(this).find('[id*="FORMULA"]').val();
                var rate = $(this).find('[id*="RATE"]').val();
                var amountnet = $(this).find('[id*="VALUE"]').val();
                var netTaxableAmount = 0.00;
                var netGSTAmount = 0.00;
                var netTotalAmount = 0.00;
                var totamount = 0.00;
                var tamt = 0.00;
                var IGSTamt = 0.00;
                var CGSTamt = 0.00;
                var SGSTamt = 0.00;
                var TotGSTamt = 0.00;

                $('#Material').find('.participantRow').each(function()
                {                       
                  var TaxableAmount = $(this).find('[id*="TAX_AMT_"]').val();
                  if (!isNaN(TaxableAmount) && TaxableAmount.length !== 0) {
                    netTaxableAmount += parseFloat(TaxableAmount);
                    }                      
                  
                  var GSTAmount = $(this).find('[id*="TGST_AMT_"]').val();
                  if (!isNaN(GSTAmount) && GSTAmount.length !== 0) {
                    netGSTAmount += parseFloat(GSTAmount);
                    }
                  
                  var TotalAmount = $(this).find('[id*="TT_AMT_"]').val();
                  if (!isNaN(TotalAmount) && TotalAmount.length !== 0) {
                    netTotalAmount += parseFloat(TotalAmount);
                    }
                })
                var IGST = $('#IGST_0').val();
                var CGST = $('#CGST_0').val();
                var SGST = $('#SGST_0').val();
                
                  if(formula == '')
                  {
                    if(rate > 0)
                    { 
                      if(basis == 'Item Taxable Amount')
                      {
                        totamount = parseFloat((rate * netTaxableAmount)/100).toFixed(2);
                      }
                      if(basis == 'Item GST Amount')
                      {
                        totamount = parseFloat((rate * netGSTAmount)/100).toFixed(2);
                      }
                      if(basis == 'Amount After GST Item')
                      {
                        totamount = parseFloat((rate * netTotalAmount)/100).toFixed(2);
                      }
                    }
                    else
                    {
                      totamount = amountnet;
                    }
                  }
                  else
                  {
                    if(basis == 'Item Taxable Amount')
                    {
                      var basis1 = '( '+netTaxableAmount+' * '+rate+' ) / 100';
                      var basis2 = netTaxableAmount;
                      var rate1 = rate +' ) / 100';
                      if(formula.indexOf("BASIS*RATE") != -1){
                        var formula1 = formula.replace ("BASIS*RATE", basis1);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("BASIS") != -1){
                        var formula1 = formula.replace ("BASIS", basis2);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("RATE") != -1){
                        var formula1 = formula.replace ("RATE", rate1);
                        tamt = eval(formula1);
                        totamount = parseFloat(( tamt * rate)/100).toFixed(2);
                      }
                    }
                    if(basis == 'Item GST Amount')
                    {
                      var basis1 = '('+netGSTAmount+'*'+rate+')/100';
                      var basis2 = netGSTAmount;
                      var rate1 = rate+')/100';
                      if(formula.indexOf("BASIS*RATE") != -1){
                        var formula1 = formula.replace ("BASIS*RATE", basis1);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("BASIS") != -1){
                        var formula1 = formula.replace ("BASIS", basis2);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("RATE") != -1){
                        var formula1 = formula.replace ("RATE", rate1);
                        tamt = eval(formula1);
                        totamount = parseFloat(( tamt * rate)/100).toFixed(2);
                      }
                    }
                    if(basis == 'Amount After GST Item')
                    {
                      var basis1 = '( '+netTotalAmount+' * '+rate+' ) / 100';
                      var basis2 = netTotalAmount;
                      var rate1 = rate+' ) / 100';
                      if(formula.indexOf("BASIS*RATE") != -1){
                        var formula1 = formula.replace ("BASIS*RATE", basis1);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("BASIS") != -1){
                        var formula1 = formula.replace ("BASIS", basis2);
                        tamt = eval(formula1);
                        totamount = parseFloat((tamt * rate)/100).toFixed(2);
                      }
                      else if(formula.indexOf("RATE") != -1){
                        var formula1 = formula.replace ("RATE", rate1);
                        tamt = eval(formula1);
                        totamount = parseFloat(( tamt * rate)/100).toFixed(2);
                      }
                    }
                    
                  }
                  $(this).find('[id*="VALUE_"]').val(totamount);
                    IGSTamt = parseFloat((IGST * totamount)/100).toFixed(2);
                    CGSTamt = parseFloat((CGST * totamount)/100).toFixed(2);
                    SGSTamt = parseFloat((SGST * totamount)/100).toFixed(2);
                    TotGSTamt = parseFloat(parseFloat(IGSTamt)+parseFloat(CGSTamt)+parseFloat(SGSTamt)).toFixed(2);
                if($(this).find('[id*="calGST"]').is(":checked") != false)
                {
                  if (IGST != '')
                  {
                  $(this).find('[id*="calIGST_"]').val(IGST);
                  $(this).find('[id*="AMTIGST_"]').val(IGSTamt);
                  $(this).find('[id*="calIGST_"]').removeAttr('readonly');
                  }
                  else
                  {
                    $(this).find('[id*="calIGST_"]').val('0');
                    $(this).find('[id*="AMTIGST_"]').val('0');
                    $(this).find('[id*="calIGST_"]').prop('readonly',true);
                    
                  }
                  if (CGST != '')
                  {
                  $(this).find('[id*="calCGST_"]').val(CGST);
                  $(this).find('[id*="AMTCGST_"]').val(CGSTamt);
                  $(this).find('[id*="calCGST_"]').removeAttr('readonly');
                  }
                  else
                  {
                    $(this).find('[id*="calCGST_"]').val('0');
                    $(this).find('[id*="AMTCGST_"]').val('0');
                    $(this).find('[id*="calCGST_"]').prop('readonly',true);
                  }
                  if (SGST != '')
                  {
                  $(this).find('[id*="calSGST_"]').val(SGST);
                  $(this).find('[id*="AMTSGST_"]').val(SGSTamt);
                  $(this).find('[id*="calSGST_"]').removeAttr('readonly');
                  }
                  else
                  {
                    $(this).find('[id*="calSGST_"]').val('0');
                    $(this).find('[id*="AMTSGST_"]').val('0');
                    $(this).find('[id*="calSGST_"]').prop('readonly',true);
                  }
                  $(this).find('[id*="TOTGSTAMT_"]').val(TotGSTamt);
                }
                else
                {
                  $(this).find('[id*="calSGST_"]').val('0');
                  $(this).find('[id*="AMTSGST_"]').val('0');
                  $(this).find('[id*="calCGST_"]').val('0');
                  $(this).find('[id*="AMTCGST_"]').val('0');
                  $(this).find('[id*="calIGST_"]').val('0');
                  $(this).find('[id*="AMTIGST_"]').val('0');
                  $(this).find('[id*="TOTGSTAMT_"]').val('0');
                  $(this).find('[id*="calIGST_"]').prop('readonly',true);
                  $(this).find('[id*="calCGST_"]').prop('readonly',true);
                  $(this).find('[id*="calSGST_"]').prop('readonly',true);
                }
            });
            var totalvalue = 0.00;
            var tvalue = 0.00;
            var ctvalue = 0.00;
            var ctgstvalue = 0.00;
            var tttdsamt21 = 0.00;
              $('#Material').find('.participantRow').each(function()
              {
                  if($('#GST_Reverse').is(':checked') == true)
                  {
                    tvalue = $(this).find('[id*="TAX_AMT_"]').val();
                    totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
                    totalvalue = parseFloat(totalvalue).toFixed(2);
                  }
                  else
                  {
                    tvalue = $(this).find('[id*="TT_AMT_"]').val();
                    totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
                    totalvalue = parseFloat(totalvalue).toFixed(2);
                  }
              });
              if($('#CTID_REF').val() != '')
              {
                $('#CT').find('.participantRow5').each(function()
                {
                  ctvalue = $(this).find('[id*="VALUE"]').val();
                  ctgstvalue = $(this).find('[id*="TOTGSTAMT"]').val();
                  if($('#GST_Reverse').is(':checked') == true)
                  {
                    totalvalue = parseFloat(totalvalue) + parseFloat(ctvalue);
                    totalvalue = parseFloat(totalvalue).toFixed(2);
                  }
                  else
                  {
                    totalvalue = parseFloat(totalvalue) + parseFloat(ctvalue);
                    totalvalue = parseFloat(totalvalue) + parseFloat(ctgstvalue);
                    totalvalue = parseFloat(totalvalue).toFixed(2);
                  }
                });
              }
            
              if($('#drpTDS').val() == 'Yes')
              {
                $('#TDS').find('.participantRow7').each(function()
                {
                    if($(this).find('[id*="TOT_TD_AMT"]').val() != '' && $(this).find('[id*="TOT_TD_AMT"]').val() != '.00')
                    {
                      tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
                      totalvalue = parseFloat(parseFloat(totalvalue)+parseFloat(tttdsamt21)).toFixed(2);
                    }
                });
              }
                $('#tot_amt').val(totalvalue);
                getActionEvent();
                event.preventDefault();
        }


function bindTotalValue(){

      var totalvalue = 0.00;
      var tvalue = 0.00;
      var ctvalue = 0.00;
      var ctgstvalue = 0.00;
      var tttdsamt21 = 0.00;
      $('#Material').find('.participantRow').each(function()
      {
        if($('#GST_Reverse').is(':checked') == true)
        {
          tvalue = $(this).find('[id*="TAX_AMT_"]').val();
          totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
          totalvalue = parseFloat(totalvalue).toFixed(2);
        }
        else
        {
          tvalue = $(this).find('[id*="TT_AMT_"]').val();
          totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
          totalvalue = parseFloat(totalvalue).toFixed(2);
        }        
      });
      if($('#CTID_REF').val() != '')
      {
        $('#CT').find('.participantRow5').each(function()
        {
          ctvalue = $(this).find('[id*="VALUE"]').val();
          ctgstvalue = $(this).find('[id*="TOTGSTAMT"]').val();
          if($('#GST_Reverse').is(':checked') == true)
          {
            totalvalue = parseFloat(totalvalue) + parseFloat(ctvalue);
            totalvalue = parseFloat(totalvalue).toFixed(2);
          }
          else
          {
            totalvalue = parseFloat(totalvalue) + parseFloat(ctvalue);
            totalvalue = parseFloat(totalvalue) + parseFloat(ctgstvalue);
            totalvalue = parseFloat(totalvalue).toFixed(2);
          }
        });
      }
      if($('#drpTDS').val() == 'Yes')
      {
        $('#TDS').find('.participantRow7').each(function()
        {
            if($(this).find('[id*="TOT_TD_AMT"]').val() != '' && $(this).find('[id*="TOT_TD_AMT"]').val() != '.00')
            {
              tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
              totalvalue = parseFloat(parseFloat(totalvalue)-parseFloat(tttdsamt21)).toFixed(2);
            }
        });
      }
      $('#tot_amt').val(totalvalue);

      getActionEvent();
  }

$(document).ready(function(){
  CKEDITOR.replace( 'Template_Description' );

  <?php if(isset($objPBHDR->EXE_GST) && $objPBHDR->EXE_GST =='1'){?>
    taxStatusWiseTaxCalculation();
    $(".ExceptionalGST").show();
    $("#EXE_GST").prop('checked', true);
  <?php } ?>

   getActionEvent(); 

});



</script>


@endpush