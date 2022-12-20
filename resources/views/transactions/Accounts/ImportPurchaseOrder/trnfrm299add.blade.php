
@extends('layouts.app')
@section('content')

@php
$disabled = $AlpsStatus['disabled'];
$hidden   = $AlpsStatus['hidden'];
@endphp
    

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="{{route('transaction',[$FormId,'index'])}}" class="btn singlebt">Import Purchase Order(IPO)</a>
                </div>

                <div class="col-lg-10 topnav-pd">
                        <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSave" ><i class="fa fa-save"></i> Save</button>
                        <button style="display:none" class="btn topnavbt buttonload"> <i class="fa fa-refresh fa-spin"></i> {{Session::get('save')}}</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo"  ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-lock"></i>  Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div>
    </div>

    <form id="frm_trn_add" onsubmit="return validateForm()"  method="POST" class="needs-validation"  >
    <div class="container-fluid filter">

	<div class="inner-form">
	
		<div class="row">
        <div class="col-lg-2 pl"><p>IPO No</p></div>
        <div class="col-lg-2 pl">
            <input type="text" name="IPO_NO" id="IPO_NO" value="{{$docarray['DOC_NO']}}" {{$docarray['READONLY']}} class="form-control" maxlength="{{$docarray['MAXLENGTH']}}" autocomplete="off" style="text-transform:uppercase" >
            <script>docMissing(@json($docarray['FY_FLAG']));</script>
        </div>
        <div class="col-lg-2 pl"><p>IPO Date</p></div>
        <div class="col-lg-2 pl">
                  <input type="date" name="IPO_DT" id="IPO_DT" value="{{ old('IPO_DT') }}" onchange='checkPeriodClosing("{{$FormId}}",this.value,1),getDocNoByEvent("IPO_NO",this,@json($doc_req))' class="form-control mandatory"  placeholder="dd/mm/yyyy" />
        </div>
		
		
        <div class="col-lg-2 pl"><p>Vendor</p></div>
        <div class="col-lg-2 pl">
                <input type="text" name="txtvendor" id="txtvendor" class="form-control"  readonly  />
                <input type="hidden" name="VID_REF" id="VID_REF"  class="form-control " />
                <input type="hidden" name="hdnMaterial" id="hdnMaterial" class="form-control" autocomplete="off" />
                <input type="hidden" name="hdnTDS" id="hdnTDS" class="form-control" autocomplete="off" />
                <input type="hidden" name="hdnTNC" id="hdnTNC" class="form-control" autocomplete="off" />
                <input type="hidden" name="hdnCalculation" id="hdnCalculation" class="form-control" autocomplete="off" />
                <input type="hidden" name="hdnPayment" id="hdnPayment" class="form-control" autocomplete="off" />
                  
        </div>
    </div>
	
	
    <div class="row">
        <div class="col-lg-2 pl"><p>Foreign Currency</p></div>
        <div class="col-lg-1 pl">
            <input type="checkbox" name="FC" id="FC" class="form-checkbox" >
        </div>                            
        <div class="col-lg-2 pl col-md-offset-1"><p>Currency</p></div>
        <div class="col-lg-2 pl" id="divcurrency" >
            <input type="text" name="CRID_popup" id="txtCRID_popup" class="form-control"  autocomplete="off"  disabled/>
            <input type="hidden" name="CRID_REF" id="CRID_REF" class="form-control" autocomplete="off" />                                
        </div>                            
        <div class="col-lg-2 pl"><p>Conversion Factor</p></div>
        <div class="col-lg-2 pl">
            <input type="text" name="CONVFACT" id="CONVFACT" autocomplete="off" onkeyup="MultiCurrency_Conversion('tot_amt')" class="form-control" readonly  maxlength="100" />
        </div>
      </div>   
	
	
    <div class="row">

        <div class="col-lg-2 pl"><p>Sale Order No</p></div> 
        <div class="col-lg-2 pl">
          <input type="text" name="SALE_ORDER_NO" id="SALE_ORDER_NO"  maxlength="30" class="form-control" autocomplete="off" />
        </div>

        <div class="col-lg-2 pl"><p> Document Type</p></div>
        <div class="col-lg-2 pl">
          <select name="DOC_TYPE" id="DOC_TYPE" class="form-control" >
            <option value="">Select</option>
            <option value="ZAF2">ZAF2</option>
            <option value="ZAP0">ZAP0</option>
            <option value="ZAP2">ZAP2</option>
            <option value="ZAS0">ZAS0</option>
            <option value="ZAS6">ZAS6</option>
          </select>
        </div>

        <div class="col-lg-2 pl"><p>Bill To </p></div>
        <div class="col-lg-2 pl" id="div_billto">
          <input type="text" name="txtBILLTO1" id="txtBILLTO1" class="form-control"  autocomplete="off" readonly  />
          <input type="hidden" name="BILLTO1" id="BILLTO1" class="form-control" autocomplete="off" />
        </div>

	</div>
	
	<div class="row">
        
        <div class="col-lg-2 pl"><p>Ship To</p></div>
        <div class="col-lg-2 pl" id="div_shipto">
            <input type="text" name="txtSHIPTO1" id="txtSHIPTO1" class="form-control"  autocomplete="off" readonly  />
            <input type="hidden" name="SHIPTO1" id="SHIPTO1" class="form-control" autocomplete="off" />
            <input type="hidden" name="Tax_State1" id="Tax_State1" class="form-control" autocomplete="off" />
        </div>
    
        <div class="col-lg-2 pl"><p>Remarks</p></div>
        <div class="col-lg-6 pl">
            <input type="text" name="REMARKS" id="REMARKS" autocomplete="off" class="form-control" maxlength="200"  >
        </div>
	</div>
	
	<div class="row">
		<div class="col-lg-2 pl"><p>FOB</p></div>
		<div class="col-lg-2 pl">
			<select  name="FOB" id="FOB" class="form-control" autocomplete="off" >
				<option value="NO">NO</option>
				<option value="YES">YES</option>
			</select>
		</div>


    <div class="col-lg-2 pl"><p>Customer</p></div>
    <div class="col-lg-2 pl">
        <input type="text" name="SubGl_popup" id="txtsubgl_popup" class="form-control mandatory"   autocomplete="off" readonly/>
        <input type="hidden" name="SLID_REF" id="SLID_REF" class="form-control" autocomplete="off" />
        <input type="hidden" name="GLID_REF" id="GLID_REF" class="form-control" autocomplete="off"  />                                                     
    </div>

		<div class="col-lg-2 pl"><p>Requested Delivery Date</p></div>
		<div class="col-lg-2 pl">
			<input type="date" name="REQ_DELIVERY_DATE" id="REQ_DELIVERY_DATE" class="form-control" autocomplete="off"  placeholder="dd/mm/yyyy" >
		</div>

	</div>
	
	
	<div class="row">	
          
		<div class="col-lg-2 pl"><p>Imort Duty</p></div>
		<div class="col-lg-2 pl">
			<select  name="IMPORT_DUTYID_REF" id="IMPORT_DUTYID_REF" class="form-control" autocomplete="off" >
				<option value="">Select</option>
				@if(isset($objImportDuty) && !empty($objImportDuty))
				@foreach($objImportDuty as $val)
				<option value="{{$val->IMPORT_DUTYID}}">{{$val->IMPORT_DUTY_CODE}}</option>
				@endforeach
				@endif
			</select>  
		</div>

		<div class="col-lg-2 pl"><p>Ref No </p></div>
		<div class="col-lg-2 pl">
			<input type="text" name="REF_NO" id="REF_NO" class="form-control" maxlength="100" autocomplete="off" >
		</div>
		
    <div class="col-lg-2 pl"><p>Credit Days</p></div>
    <div class="col-lg-2 pl">
      <input type="text" name="Credit_days" id="Credit_days" onkeyup="getDueDate()" maxlength="200" class="form-control"  autocomplete="off"   />
    </div>
		
	</div>
		

	  <div class="row">

        <div class="col-lg-2 pl"><p>Due Date</p></div>
        <div class="col-lg-2 pl">
            <input type="date" name="DUE_DATE" id="DUE_DATE" value="{{ old('DUE_DATE') }}" class="form-control"  placeholder="dd/mm/yyyy"  />                        
        </div>
		
        <div hidden class="col-lg-1 pl"><p>Reverse GST</p></div>
        <div hidden class="col-lg-2 pl">
            <input type="checkbox" name="GST_Reverse" id="GST_Reverse"    />                          
        </div>
   	
        <div hidden class="col-lg-1 pl"><p>GST Input Not Avail</p></div>
        <div hidden class="col-lg-2 pl">
            <input type="checkbox" name="GST_N_Avail" id="GST_N_Avail"    />
        </div> 

		
        <div class="col-lg-2 pl"><p id="currency_section">{{Session::get('default_currency')}}</p></div>
        <div class="col-lg-2 pl">
            <input type="text" name="tot_amt" id="tot_amt" class="form-control"  autocomplete="off" readonly  />
        </div>

        <div id="multi_currency_section" style="display:none">
        <div class="col-lg-2 pl"  ><p>{{Session::get('default_currency')}}</p></div>
        <div class="col-lg-2 pl">
            <input type="text"  name="TotalValue_Conversion" id="TotalValue_Conversion" class="form-control"  autocomplete="off" readonly  />
        </div>
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
			</ul>
      <div class="tab-content">
		
		<div id="Material" class="tab-pane fade in active">
			<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:400px;margin-top:10px;" >
				<table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
					<thead id="thead1"  style="position: sticky;top: 0">           
						<tr>
							<th rowspan="2" hidden>SQ / SQA No </th>
							<th rowspan="2">Item Code <input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1"> </th>
							<th rowspan="2">Item Name</th>
							<th rowspan="2">Item Specification</th>

              <th rowspan="2" {{$hidden}}>{{isset($TabSetting->FIELD8) && $TabSetting->FIELD8 !=''?$TabSetting->FIELD8:'Add. Info Part No'}}</th>
              <th rowspan="2" {{$hidden}}>{{isset($TabSetting->FIELD9) && $TabSetting->FIELD9 !=''?$TabSetting->FIELD9:'Add. Info Customer Part No'}}</th>
              <th rowspan="2" {{$hidden}}>{{isset($TabSetting->FIELD10) && $TabSetting->FIELD10 !=''?$TabSetting->FIELD10:'Add. Info OEM Part No.'}}</th>

							<th rowspan="2">Main UoM (MU)</th>
							<th rowspan="2">IPO Qty (MU)</th>
							<th rowspan="2">Alt UOM (AU)</th>
							<th rowspan="2">IPO Qty (AU)</th>
							<th rowspan="2">Rate as per MU</th>
							<th colspan="2">Discount</th>
							<th rowspan="2">IPO Amount</th>
							<th rowspan="2">Freight Amount</th>
							<th rowspan="2">Insurance Amount</th>
							<th rowspan="2">Assessable Value</th>
							<th rowspan="2">Custom Duty Rate %</th>
							<th rowspan="2">Custom Duty Amount</th>
							<th rowspan="2">SWS Rate %</th>
							<th rowspan="2">SWS Amount</th>
							<th rowspan="2">Total Custom Duty</th>
							<th rowspan="2">Taxable Value</th>
							<th rowspan="2">IGST Rate %</th>
							<th rowspan="2">IGST Amount</th>
							<th rowspan="2">Value after GST</th>
							<th rowspan="2" width="3%">Action</th>
						</tr>
						<tr>
							<th>%</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>	
						<tr  class="participantRow">
							<td hidden style="text-align:center;" ><input style="width:100px;" type="text" name="txtSQ_popup_0" id="txtSQ_popup_0" class="form-control"  autocomplete="off"  readonly style="width:130px;text-align:right;"/></td>
							<td hidden><input type="hidden" name="SQA_0" id="SQA_0" class="form-control" autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td hidden><input type="hidden" name="SEQID_REF_0" id="SEQID_REF_0" class="form-control" autocomplete="off" style="width:130px;text-align:right;" /></td>
						  
							<td><input type="text" name="popupITEMID_0" id="popupITEMID_0" class="form-control"  autocomplete="off"  readonly style="width:130px;" /></td>
							<td hidden><input type="hidden" name="ITEMID_REF_0" id="ITEMID_REF_0" class="form-control" autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="ItemName_0" id="ItemName_0" class="form-control"  autocomplete="off"  readonly style="width:130px;"/></td>
							<td><input type="text" name="Itemspec_0" id="Itemspec_0" class="form-control"  autocomplete="off" style="width:130px;"  /></td>

              <td {{$hidden}} ><input type="text" name="Alpspartno_0" id="Alpspartno_0" class="form-control"  autocomplete="off"  style="width:130px;text-align:right;" readonly /></td>
              <td {{$hidden}} ><input type="text" name="Custpartno_0" id="Custpartno_0" class="form-control"  autocomplete="off"  style="width:130px;text-align:right;" readonly /></td>
              <td {{$hidden}} ><input type="text" name="OEMpartno_0" id="OEMpartno_0" class="form-control"  autocomplete="off"  style="width:130px;text-align:right;" readonly /></td>
						  
							<td><input type="text" name="popupMUOM_0" id="popupMUOM_0" class="form-control"  autocomplete="off"  readonly style="width:130px;"/></td>
							<td hidden><input type="hidden" name="MAIN_UOMID_REF_0" id="MAIN_UOMID_REF_0" class="form-control"  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="SO_QTY_0" id="SO_QTY_0"  onkeyup="onChangeAmount(this.id,this.value)" onblur="getTextDec(this.id,'3')" class="form-control three-digits" maxlength="13"  autocomplete="off" style="width:130px;text-align:right;"  /></td>
							<td hidden><input type="hidden" name="SO_FQTY_0" id="SO_FQTY_0" class="form-control three-digits" maxlength="13"  autocomplete="off"  readonly style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="popupAUOM_0" id="popupAUOM_0" class="form-control"  autocomplete="off"  readonly style="width:130px;" /></td>
							<td hidden><input type="hidden" name="ALT_UOMID_REF_0" id="ALT_UOMID_REF_0" class="form-control"  autocomplete="off"  readonly style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="ALT_UOMID_QTY_0" id="ALT_UOMID_QTY_0" class="form-control three-digits" maxlength="13" autocomplete="off"  readonly style="width:130px;text-align:right;"/></td>
							<td><input type="text" name="RATEPUOM_0" id="RATEPUOM_0" onkeyup="onChangeAmount(this.id,this.value)" onblur="getTextDec(this.id,'5')" class="form-control" maxlength="13"  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input {{$disabled}} type="text" name="DISC_PER_0" id="DISC_PER_0" onkeyup="onChangeAmount(this.id,this.value)" onblur="getTextDec(this.id,'2')" class="form-control four-digits" maxlength="8"  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input {{$disabled}} type="text" name="DISC_AMT_0" id="DISC_AMT_0" onkeyup="onChangeAmount(this.id,this.value)" onblur="getTextDec(this.id,'2')" class="form-control two-digits" maxlength="15"  autocomplete="off" style="width:130px;text-align:right;"  /></td>
							<td><input type="text" name="DISAFTT_AMT_0" id="DISAFTT_AMT_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly style="width:130px;text-align:right;" /></td>
						 

							<td><input type="text" name="FREIGHT_AMT_0"           id="FREIGHT_AMT_0"            onkeyup="onChangeAmount(this.id,this.value)"  class="form-control four-digits"   autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="INSURANCE_AMT_0"         id="INSURANCE_AMT_0"          onkeyup="onChangeAmount(this.id,this.value)"  class="form-control four-digits"   autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="ASSESSABLE_VALUE_0"      id="ASSESSABLE_VALUE_0"       class="form-control four-digits" readonly  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="CUSTOME_DUTY_RATE_PER_0" id="CUSTOME_DUTY_RATE_PER_0"  class="form-control four-digits" readonly  autocomplete="off" style="width:130px;text-align:right;"/></td>
							<td><input type="text" name="CUSTOME_DUTY_RATE_AMT_0" id="CUSTOME_DUTY_RATE_AMT_0"  class="form-control four-digits" readonly  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="SWS_RATE_PER_0"          id="SWS_RATE_PER_0"           class="form-control four-digits" readonly  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="SWS_RATE_AMT_0"          id="SWS_RATE_AMT_0"           class="form-control four-digits" readonly  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="TOTAL_CUSTOME_DUTY_0"    id="TOTAL_CUSTOME_DUTY_0"     class="form-control four-digits" readonly  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="TAXABLE_VALUE_0"         id="TAXABLE_VALUE_0"          class="form-control four-digits" readonly  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="IGST_RATE_PER_0"         id="IGST_RATE_PER_0"               class="form-control four-digits" readonly  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="IGST_RATE_AMT_0"         id="IGST_RATE_AMT_0"               class="form-control four-digits" readonly  autocomplete="off" style="width:130px;text-align:right;" /></td>
							<td><input type="text" name="VALUE_AFTER_GST_0"       id="VALUE_AFTER_GST_0"        class="form-control four-digits" readonly  autocomplete="off" style="width:130px;text-align:right;" /></td>

							<td align="center" ><button class="btn add material" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button> <button class="btn remove dmaterial" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button></td>
					  
						</tr>
						<tr></tr>
					</tbody>

          <tr  class="participantRowFotter">
            <td colspan="4" style="text-align:center;font-weight:bold;">TOTAL</td> 
			<td {{$hidden}} colspan="3"></td>
            <td id="SO_QTY_total"     style="text-align:right;font-weight:bold;"></td>
            <td></td>
            <td id="ALT_UOMID_QTY_total" style="text-align:right;font-weight:bold;"></td>
            <td id="RATEPUOM_total"         style="text-align:right;font-weight:bold;"></td>
            <td></td>
            <td id="DISC_AMT_total"    style="text-align:right;font-weight:bold;"></td>
            <td id="DISAFTT_AMT_total"    style="text-align:right;font-weight:bold;"></td>
            <td id="FREIGHT_AMT_total"         style="text-align:right;font-weight:bold;"></td>
            <td id="INSURANCE_AMT_total"          style="text-align:right;font-weight:bold;"></td>
            <td id="ASSESSABLE_VALUE_total"          style="text-align:right;font-weight:bold;"></td>
            <td></td>
            <td id="CUSTOME_DUTY_RATE_AMT_total"          style="text-align:right;font-weight:bold;"></td>
            <td></td>
            <td id="SWS_RATE_AMT_total"        style="text-align:right;font-weight:bold;"></td>
            <td id="TOTAL_CUSTOME_DUTY_total"        style="text-align:right;font-weight:bold;"></td>
            <td id="TAXABLE_VALUE_total"        style="text-align:right;font-weight:bold;"></td>
            <td></td>
            <td id="IGST_RATE_AMT_total"        style="text-align:right;font-weight:bold;"></td>
            <td id="VALUE_AFTER_GST_total"       style="text-align:right;font-weight:bold;"></td>
            <td></td>                                    
          </tr>

				</table>
			</div>	
		</div>
		
        <div id="TC" class="tab-pane fade">
            <div class="row" style="margin-top:10px;margin-left:3px;" >	
                <div class="col-lg-1 pl"><p>T&C Template</p></div>
                <div class="col-lg-2 pl">
                <input type="text" name="txtTNCID_popup" id="txtTNCID_popup" class="form-control"  autocomplete="off"  readonly/>
                  <input type="hidden" name="TNCID_REF" id="TNCID_REF" class="form-control" autocomplete="off" />
                </div>
            </div>
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="margin-top:10px;height:240px;width:50%;">
                <table id="example3" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                    <tr >
                        <th>Terms & Conditions Description<input class="form-control" type="hidden" name="Row_Count2" id ="Row_Count2"></th>
                        <th>Value / Comment</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="tncbody">
                    <tr  class="participantRow3">
                      <td><input type="text" name="popupTNCDID_0" id="popupTNCDID_0" class="form-control"  autocomplete="off"  readonly/></td>
                      <td hidden><input type="hidden" name="TNCDID_REF_0" id="TNCDID_REF_0" class="form-control" autocomplete="off" /></td>
                      <td hidden><input type="hidden" name="TNCismandatory_0" id="TNCismandatory_0" class="form-control" autocomplete="off" /></td>
                      <td id="tdinputid_0">
                      {{-- dynamic input --}} 
                      </td>
                        <td align="center" ><button class="btn add TNC" title="add" data-toggle="tooltip"  type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DTNC" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                    </tr>
                <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="CT" class="tab-pane fade">
            <div class="row" style="margin-top:10px;margin-left:3px;" >	
                <div class="col-lg-2 pl"><p>Calculation Template</p></div>
                <div class="col-lg-2 pl">
                <input type="text" name="txtCTID_popup" id="txtCTID_popup" class="form-control"  autocomplete="off"  readonly/>
                  <input type="hidden" name="CTID_REF" id="CTID_REF" class="form-control" autocomplete="off" />
                </div>
            </div>
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:240px;" >
                <table id="example5" class="display nowrap table table-striped table-bordered itemlist " width="100%" style="height:auto !important;">
                  <thead id="thead1"  style="position: sticky;top: 0">
                      <tr>
                          <th>Calculation Component<input class="form-control" type="hidden" name="Row_Count3" id ="Row_Count3"></th>
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
                      <tr  class="participantRow5">
                          <td><input type="text" name="popupTID_0" id="popupTID_0" class="form-control"  autocomplete="off"  readonly/></td>
                          <td hidden><input type="hidden" name="TID_REF_0" id="TID_REF_0" class="form-control" autocomplete="off" /></td>
                          <td><input type="text" name="RATE_0" id="RATE_0" class="form-control four-digits" maxlength="8" autocomplete="off"  readonly/></td>
                          <td hidden><input type="hidden" name="BASIS_0" id="BASIS_0" class="form-control" autocomplete="off" /></td>
                          <td hidden><input type="hidden" name="SQNO_0" id="SQNO_0" class="form-control" autocomplete="off" /></td>
                          <td><input type="text" name="VALUE_0" id="VALUE_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly/></td>
                          <td style="text-align:center;" ><input type="checkbox" class="filter-none" name="calGST_0" id="calGST_0" value="" ></td>
                          <td><input type="text" name="calIGST_0" id="calIGST_0" class="form-control four-digits" maxlength="8" autocomplete="off"  readonly/></td>
                          <td><input type="text" name="AMTIGST_0" id="AMTIGST_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly/></td>
                          <td><input type="text" name="calCGST_0" id="calCGST_0" class="form-control four-digits" maxlength="8" autocomplete="off"  readonly/></td>
                          <td><input type="text" name="AMTCGST_0" id="AMTCGST_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly/></td>
                          <td><input type="text" name="calSGST_0" id="calSGST_0" class="form-control four-digits" maxlength="8" autocomplete="off"  readonly/></td>
                          <td><input type="text" name="AMTSGST_0" id="AMTSGST_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly/></td>
                          <td><input type="text" name="TOTGSTAMT_0" id="TOTGSTAMT_0" class="form-control two-digits"  maxlength="15" autocomplete="off"  readonly/></td>
                          <td style="text-align:center;"><input type="checkbox" class="filter-none" name="calACTUAL_0" id="calACTUAL_0" value=""   ></td>
                          <td align="center" ><button class="btn add" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                      </tr>
                      <tr></tr>
                  </tbody>
                </table>
            </div>	
        </div>
        <div id="PaymentSlabs" class="tab-pane fade">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="margin-top:10px;height:280px;width:55%;">
                <table id="example6" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                      <tr >
                          <th>Day(s)<input class="form-control" type="hidden" name="Row_Count5" id ="Row_Count5"></th>
                          <th>Due %</th>
                          <th>Remarks</th>
                          <th>Due Date</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr  class="participantRow6">
                          <td> <input type="text" class="form-control" id="PAY_DAYS_0" name="PAY_DAYS_0"  autocomplete="off" /> </td>
                          <td> <input type="text" class="form-control four-digits" id="DUE_0" name="DUE_0" maxlength="8" autocomplete="off" /> </td>
                          <td> <input type="text" class="form-control" id="PSREMARKS_0" name="PSREMARKS_0" autocomplete="off"  /> </td>
                          <td> <input type="date" class="form-control" id="DUE_DATE_0" name="DUE_DATE_0" autocomplete="off"  readonly /> </td>
                          <td align="center" style="min-width: 100px;" ><button class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button><button class="btn remove" title="Delete" data-toggle="tooltip" type="button" ><i class="fa fa-trash" ></i></button></td>
                      </tr>
                      <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="TDS" class="tab-pane fade">
            <div class="row" style="margin-top:10px;margin-left:3px;" >	
                <div class="col-lg-1 pl"><p>TDS Applicable</p></div>
                <div class="col-lg-2 pl">
                  <select name="drpTDS" id="drpTDS" class="form-control">
                      <option value=""></option>    
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                  </select>
                </div>
            </div>
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                <table id="example7" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
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
                          <tr  class="participantRow7">
                              <td style="text-align:center;" >
                              <input type="text" name="txtTDS_0" id="txtTDS_0" class="form-control"  autocomplete="off"  readonly/></td>
                              <td hidden><input type="hidden" name="TDSID_REF_0" id="TDSID_REF_0" class="form-control" autocomplete="off" /></td>
                              <td><input type="text" name="TDSLedger_0" id="TDSLedger_0" class="form-control"  autocomplete="off"  readonly/></td>
                              <td  align="center" style="text-align:center;" ><input type="checkbox" name="TDSApplicable_0" id="TDSApplicable_0" /></td>
                              <td><input type="text" name="ASSESSABLE_VL_TDS_0" id="ASSESSABLE_VL_TDS_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
                              <td><input type="text" name="TDS_RATE_0" id="TDS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                              <td hidden><input type="hidden" name="TDS_EXEMPT_0" id="TDS_EXEMPT_0" class="form-control two-digits" /></td>
                              <td><input type="text" name="TDS_AMT_0" id="TDS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                              <td><input type="text" name="ASSESSABLE_VL_SURCHARGE_0" id="ASSESSABLE_VL_SURCHARGE_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                              <td><input type="text" name="SURCHARGE_RATE_0" id="SURCHARGE_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                              <td hidden><input type="hidden" name="SURCHARGE_EXEMPT_0" id="SURCHARGE_EXEMPT_0" class="form-control two-digits" /></td>
                              <td><input type="text" name="SURCHARGE_AMT_0" id="SURCHARGE_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                              <td><input type="text" name="ASSESSABLE_VL_CESS_0" id="ASSESSABLE_VL_CESS_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                              <td><input type="text" name="CESS_RATE_0" id="CESS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                              <td hidden><input type="hidden" name="CESS_EXEMPT_0" id="CESS_EXEMPT_0" class="form-control two-digits" /></td>
                              <td><input type="text" name="CESS_AMT_0" id="CESS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                              <td><input type="text" name="ASSESSABLE_VL_SPCESS_0" id="ASSESSABLE_VL_SPCESS_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                              <td><input type="text" name="SPCESS_RATE_0" id="SPCESS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                              <td hidden><input type="hidden" name="SPCESS_EXEMPT_0" id="SPCESS_EXEMPT_0" class="form-control two-digits" /></td>
                              <td><input type="text" name="SPCESS_AMT_0" id="SPCESS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                              <td><input type="text" name="TOT_TD_AMT_0" id="TOT_TD_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                              <td style="min-width: 100px;" ><button class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                              <button class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button></td>
                          </tr>
                          <tr></tr>
                    </tbody>
            </table>
            </div>	
        </div> 
        <div id="udf" class="tab-pane fade">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="margin-top:10px;height:280px;width:50%;">
                <table id="example4" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                    <tr >
                        <th>UDF Fields<input class="form-control" type="hidden" name="Row_Count6" id ="Row_Count6"></th>
                        <th>Value / Comments</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($objUdfPBData)
                    @foreach($objUdfPBData as $uindex=>$uRow)
                      <tr  class="participantRow4">
                          <td><input type="text" name={{"popupUDFPBID_".$uindex}} id={{"popupUDFPBID_".$uindex}} class="form-control" value="{{$uRow->LABEL}}" autocomplete="off"  readonly/></td>
                          <td hidden><input type="hidden" name={{"UDFPBID_REF_".$uindex}} id={{"UDFPBID_REF_".$uindex}} class="form-control" value="{{$uRow->UDFIPOID}}" autocomplete="off"   /></td>
                          <td hidden><input type="hidden" name={{"UDFismandatory_".$uindex}} id={{"UDFismandatory_".$uindex}} value="{{$uRow->ISMANDATORY}}" class="form-control"   autocomplete="off" /></td>
                          <td id={{"udfinputid_".$uindex}} >
                          </td>
                          <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>                          
                      </tr>
                      <tr></tr>
                    @endforeach
                    @else
                      <tr  class="participantRow4">
                          <td><input type="text" name="popupUDFPBID_0" id="popupUDFPBID_0" class="form-control" value="" autocomplete="off"  readonly/></td>
                          <td hidden><input type="hidden" name="UDFPBID_REF_0" id="UDFPBID_REF_0" class="form-control" value="" autocomplete="off"   /></td>
                          <td hidden><input type="hidden" name="UDFismandatory_0" id="UDFismandatory_0" value="" class="form-control"   autocomplete="off" /></td>
                          <td id="udfinputid_0" >
                          </td>
                          <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>                          
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
	
</div>

<!-- </div> -->
</form>
@endsection
@section('alert')

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
        <td class="ROW2"><input type="text" id="vendorcodesearch" class="form-control" onkeyup="VendorCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="vendornamesearch" class="form-control" onkeyup="VendorNameFunction()"></td>
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
      <td class="ROW2"><input type="text" id="BillTocodesearch" class="form-control" onkeyup="BillToCodeFunction()"></td>
      <td class="ROW3"><input type="text" id="BillTonamesearch" class="form-control" onkeyup="BillToNameFunction()"></td>
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
      <td class="ROW2"><input type="text" id="ShipTocodesearch" class="form-control" onkeyup="ShipToCodeFunction()"></td>
      <td class="ROW3"><input type="text" id="ShipTonamesearch" class="form-control" onkeyup="ShipToNameFunction()"></td>
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
    <table id="TNCIDTable" class="display nowrap table  table-striped table-bordered">
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
        <td class="ROW2"><input type="text" id="TNCcodesearch" class="form-control" onkeyup="TNCCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="TNCnamesearch" class="form-control" onkeyup="TNCNameFunction()"></td>
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
          <td class="ROW2">{{ $tncRow-> TNC_CODE }} <input type="hidden" id="txttncidcode_{{ $tncindex }}" data-desc="{{ $tncRow-> TNC_CODE }} - {{ $tncRow-> TNC_DESC }}" value="{{ $tncRow-> TNCID }}"/></td>
          <td class="ROW3">{{ $tncRow-> TNC_DESC }}</td>
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
    <input type="text" id="tncdetcodesearch" onkeyup="TNCDetCodeFunction()">
    </td>
    <td>
    <input type="text" id="tncdetnamesearch" onkeyup="TNCDetNameFunction()">
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
    <table id="CTIDTable" class="display nowrap table  table-striped table-bordered">
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
        <td class="ROW2"><input type="text" id="CTIDcodesearch" class="form-control" onkeyup="CTIDCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="CTIDnamesearch" class="form-control" onkeyup="CTIDNameFunction()"></td>
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
          <td class="ROW2">{{ $calRow-> CTCODE }} <input type="hidden" id="txtCTIDcode_{{ $calindex }}" data-desc="{{ $calRow-> CTCODE }} - {{ $calRow-> CTDESCRIPTION }}" value="{{ $calRow-> CTID }}"/></td>
          <td class="ROW3">{{ $calRow-> CTDESCRIPTION }}</td>
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
    <input type="text" id="CTIDdetcodesearch" onkeyup="CTIDDetCodeFunction()">
    </td>
    <td>
    <input type="text" id="CTIDdetnamesearch" onkeyup="CTIDDetNameFunction()">
    </td>
    <td>
    <input type="text" id="CTIDdetratesearch" onkeyup="CTIDDetRateFunction()">
    </td>
    <td>
    <input type="text" id="CTIDdetamountsearch" onkeyup="CTIDDetAmountFunction()">
    </td>
    <td>
    <input type="text" id="CTIDdetformulasearch" onkeyup="CTIDDetFormulaFunction()">
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
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='GRN_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Good Receipt Note</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="GRNTable" class="display nowrap table  table-striped table-bordered" width="100%">
    <thead>
          <tr id="none-select" class="searchalldata" hidden>
            
            <td> <input type="hidden" name="hdn_GRN" id="hdn_GRN"/>
            <input type="hidden" name="hdn_GRN2" id="hdn_GRN2"/></td>
          </tr>
    <tr>
            <th>Good Receipt No</th>
            <th>Good Receipt Date</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>
    <input type="text" id="GRNcodesearch" onkeyup="GRNCodeFunction()">
    </td>
    <td>
    <input type="text" id="GRNnamesearch" onkeyup="GRNNameFunction()">
    </td>
    </tr>
    </tbody>
    </table>
      <table id="GRNTable2" class="display nowrap table  table-striped table-bordered" width="100%">
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
            
            <td> <input type="hidden" name="fieldid" id="hdn_ItemID"/>
            <input type="hidden" name="fieldid2" id="hdn_ItemID2"/>
            <input type="hidden" name="fieldid3" id="hdn_ItemID3"/>
            <input type="hidden" name="fieldid4" id="hdn_ItemID4"/>
            <input type="hidden" name="fieldid5" id="hdn_ItemID5"/>
            <input type="hidden" name="fieldid6" id="hdn_ItemID6"/>
            <input type="hidden" name="fieldid7" id="hdn_ItemID7"/>
            <input type="hidden" name="fieldid8" id="hdn_ItemID8"/>
            <input type="hidden" name="fieldid9" id="hdn_ItemID9"/>
            <input type="hidden" name="fieldid10" id="hdn_ItemID10"/>
            <input type="hidden" name="fieldid11" id="hdn_ItemID11"/>
            <input type="hidden" name="fieldid12" id="hdn_ItemID12"/>
            <input type="hidden" name="fieldid13" id="hdn_ItemID13"/>
            <input type="hidden" name="fieldid14" id="hdn_ItemID14"/>
            <input type="hidden" name="fieldid15" id="hdn_ItemID15"/>
            <input type="hidden" name="fieldid16" id="hdn_ItemID16"/>
            <input type="hidden" name="fieldid17" id="hdn_ItemID17"/>
            <input type="hidden" name="fieldid18" id="hdn_ItemID18"/>
            <input type="hidden" name="fieldid19" id="hdn_ItemID19"/>
            <input type="hidden" name="fieldid20" id="hdn_ItemID20"/>
            <input type="hidden" name="hdn_ItemID21" id="hdn_ItemID21" value="0"/>

            <input type="hidden" name="fieldid22" id="hdn_ItemID22"/>
            <input type="hidden" name="fieldid23" id="hdn_ItemID23"/>
            <input type="hidden" name="fieldid24" id="hdn_ItemID24"/>
            <input type="hidden" name="fieldid25" id="hdn_ItemID25"/>
            <input type="hidden" name="fieldid26" id="hdn_ItemID26"/>
            <input type="hidden" name="fieldid27" id="hdn_ItemID27"/>
            <input type="hidden" name="fieldid28" id="hdn_ItemID28"/>
            <input type="hidden" name="fieldid29" id="hdn_ItemID29"/>
            <input type="hidden" name="fieldid30" id="hdn_ItemID30"/>
            <input type="hidden" name="fieldid31" id="hdn_ItemID31"/>
            <input type="hidden" name="fieldid32" id="hdn_ItemID32"/>
            <input type="hidden" name="fieldid33" id="hdn_ItemID33"/>
            


            </td>
      </tr>
      <!-- <tr class="topnav"><button class="btn topnavbt" id="btnOk"><i class="fa fa-check"></i> OK</button></tr> -->
      <tr>
            <th style="width:8%;" id="all-check">Select</th>
            <th style="width:10%;">Item Code</th>
            <th style="width:10%;">Name</th>
            <th style="width:8%;">Main UOM</th>
            <th style="width:8%;">Main QTY</th>
            <th style="width:8%;">Item Group</th>
            <th style="width:8%;">Item Category</th>
            <th style="width:8%;">Business Unit</th>
            <th {{$hidden}} style="width:8%;">{{isset($TabSetting->FIELD8) && $TabSetting->FIELD8 !=''?$TabSetting->FIELD8:'Add. Info Part No'}}</th>
            <th {{$hidden}} style="width:8%;">{{isset($TabSetting->FIELD9) && $TabSetting->FIELD9 !=''?$TabSetting->FIELD9:'Add. Info Customer Part No'}}</th>
            <th {{$hidden}} style="width:8%;">{{isset($TabSetting->FIELD10) && $TabSetting->FIELD10 !=''?$TabSetting->FIELD10:'Add. Info OEM Part No.'}}</th>
            <th style="width:8%;">Status</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    <td style="width:8%;"><input type="checkbox" class="js-selectall" data-target=".js-selectall1" /></td>
    <td style="width:10%;"><input type="text" id="Itemcodesearch" class="form-control" onkeyup="ItemCodeFunction()"></td>
    <td style="width:10%;"><input type="text" id="Itemnamesearch" class="form-control" onkeyup="ItemNameFunction()"></td>
    <td style="width:8%;"><input type="text" id="ItemUOMsearch" class="form-control" onkeyup="ItemUOMFunction()"></td>
    <td style="width:8%;"><input type="text" id="ItemQTYsearch" class="form-control" onkeyup="ItemQTYFunction()"></td>
    <td style="width:8%;"><input type="text" id="ItemGroupsearch" class="form-control" onkeyup="ItemGroupFunction()"></td>
    <td style="width:8%;"><input type="text" id="ItemCategorysearch" class="form-control" onkeyup="ItemCategoryFunction()"></td>
    
    <td style="width:8%;"><input type="text" id="ItemBUsearch" class="form-control" onkeyup="ItemBUFunction()"></td>
    <td {{$hidden}} style="width:8%;"><input type="text" id="ItemAPNsearch" class="form-control" onkeyup="ItemAPNFunction()"></td>
    <td {{$hidden}} style="width:8%;"><input type="text" id="ItemCPNsearch" class="form-control" onkeyup="ItemCPNFunction()"></td>
    <td {{$hidden}} style="width:8%;"><input type="text" id="ItemOEMPNsearch" class="form-control" onkeyup="ItemOEMPNFunction()"></td>

    <td style="width:8%;"><input  type="text" id="ItemStatussearch" class="form-control" onkeyup="ItemStatusFunction()"></td>
    </tr>
    </tbody>
    </table>
      <table id="ItemIDTable2" class="display nowrap table  table-striped table-bordered" style="width:100%" >
        <thead id="thead2">

        </thead>
        <tbody id="tbody_ItemID">     
          <div class="loader" id="item_loader" style="display:none;"></div>
          
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Item Code Dropdown-->

<!-- ALT UOM Dropdown -->
<div id="altuompopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='altuom_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>ALT UOM</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="altuomTable" class="display nowrap table  table-striped table-bordered" >
    <thead>
    <tr id="none-select" class="searchalldata" hidden>
            
            <td> <input type="hidden" name="fieldid" id="hdn_altuom"/>
            <input type="hidden" name="fieldid2" id="hdn_altuom2"/>
            <input type="hidden" name="fieldid3" id="hdn_altuom3"/>
            <input type="hidden" name="fieldid4" id="hdn_altuom4"/></td>
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
        <td class="ROW2"><input type="text" id="altuomcodesearch" class="form-control" onkeyup="altuomCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="altuomnamesearch" class="form-control" onkeyup="altuomNameFunction()"></td>
      </tr>
    </tbody>
    </table>
      <table id="altuomTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">
          
        </thead>
        <tbody id="tbody_altuom">       
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- ALT UOM Dropdown-->



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
            <button class="btn alertbt" name='OkBtn1' id="OkBtn1" onclick="getFocus()" style="display:none;margin-left: 90px;">
            <div id="alert-active" class="activeOk1"></div>OK</button>
			<input type="hidden" id="FocusId" >
        </div><!--btdiv-->
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Alert -->

<!-- Customer  Dropdown -->
<div id="customer_popus" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='customer_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Customer</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="GlCodeTable" class="display nowrap table  table-striped table-bordered">
    <thead>
    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Code</th>
      <th class="ROW3">Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="ROW1"><span class="check_th">&#10004;</span></td>
        <td class="ROW2"><input type="text" id="customercodesearch" class="form-control" onkeyup="CustomerCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="customernamesearch" class="form-control" onkeyup="CustomerNameFunction()"></td>
    </tr>
    </tbody>
    </table>
      <table id="GlCodeTable2" class="display nowrap table  table-striped table-bordered">
        <thead id="thead2">
        </thead>
        <tbody id="tbody_subglacct">
        
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- CUSTOMER Dropdown-->

@endsection


@push('bottom-css')
<style>
#custom_dropdown, #frm_trn_so_filter {
    display: inline-table;
    margin-left: 15px;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 7px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
.dataTables_wrapper .row:nth-child(1) .col-sm-6:nth-child(2){text-align:right;}
#filtercolumn{color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    }

/* .table-bordered.itemlist tr th {
    padding: 5px 5px;
    font-size: 13px;
    border: 1px solid#0f69cc !important;
    color: #0f69cc;
    background: #eff7fb;
    font-weight: 400;
    text-align: center;
    position: sticky;
    top: 0;
} */
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
    width: 16%;
}
#CTIDDetTable2 {
  border-collapse: collapse;
  width: 1050px;
  border: 1px solid #ddd;
  font-size: 11px;
}

#CTIDDetTable2 th{
    text-align: left;
    padding: 5px;
    
    font-size: 11px;
   
    color: #0f69cc;
    font-weight: 600;
}

#CTIDDetTable2 td {
  text-align: left;
    padding: 5px;
    font-size: 11px;
  
    font-weight: 600;
    width: 20%;
}



.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 20px;
  height: 20px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}
/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
@endpush


@push('bottom-scripts')
<script>
/*================================ SHORTING FUNCTION ================================*/
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


/*================================ CUSTOMER FUNCTION ================================*/

let cltid = "#GlCodeTable2";
let cltid2 = "#GlCodeTable";
let clheaders = document.querySelectorAll(cltid2 + " th");

clheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(cltid, ".clsglid", "td:nth-child(" + (i + 1) + ")");
  });
});

function CustomerCodeFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("customercodesearch");
    filter = input.value.toUpperCase();
    
  if(filter.length == 0)
    {
      var CODE = ''; 
      var NAME = ''; 
      loadCustomer(CODE,NAME); 
    }
    else if(filter.length >= 3)
    {
      var CODE = filter; 
      var NAME = ''; 
      loadCustomer(CODE,NAME); 
    }
    else
    {
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
}

function CustomerNameFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("customernamesearch");
    filter = input.value.toUpperCase();
    if(filter.length == 0)
    {
      var CODE = ''; 
      var NAME = ''; 
      loadCustomer(CODE,NAME);
    }
    else if(filter.length >= 3)
    {
      var CODE = ''; 
      var NAME = filter; 
      loadCustomer(CODE,NAME);  
    }
    else
    {
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
}
  
function loadCustomer(CODE,NAME){

    $("#tbody_subglacct").html('');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url:'{{route("transaction",[$FormId,"getsubledger"])}}',
      type:'POST',
      data:{'CODE':CODE,'NAME':NAME},
      success:function(data) {
      $("#tbody_subglacct").html(data); 
      bindSubLedgerEvents(); 
      showSelectedCheck($("#SLID_REF").val(),"SELECT_SLID_REF");

      },
      error:function(data){
      console.log("Error: Something went wrong.");
      $("#tbody_subglacct").html('');                        
      },
    });
}

$("#txtsubgl_popup").click(function(event){
  var CODE = ''; 
  var NAME = ''; 

  loadCustomer(CODE,NAME);
  $("#customer_popus").show();
  event.preventDefault();
});

$("#customer_closePopup").on("click",function(event){ 
    $("#customer_popus").hide();
    $("#customercodesearch").val(''); 
    $("#customernamesearch").val(''); 
    CustomerCodeFunction();
    event.preventDefault();
});

function bindSubLedgerEvents(){
  $('.clssubgl').click(function(){

    var id = $(this).attr('id');
    var txtval =    $("#txt"+id+"").val();
    var texdesc =   $("#txt"+id+"").data("desc");
    var glid    =   $("#txt"+id+"").data("desc2");

    $("#txtsubgl_popup").val(texdesc);
    $("#txtsubgl_popup").blur();
    $("#SLID_REF").val(txtval);
    $("#GLID_REF").val(glid);

    $("#customer_popus").hide();
    $("#customercodesearch").val(''); 
    $("#customernamesearch").val(''); 
    CustomerCodeFunction();

    event.preventDefault();
  });
}

/*================================ VENDOR FUNCTION ================================*/

let tid = "#VendorCodeTable2";
let tid2 = "#VendorCodeTable";
let headers = document.querySelectorAll(tid2 + " th");

      
headers.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(tid, ".clsvendorid", "td:nth-child(" + (i + 1) + ")");
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
        var texdesc =   $("#txt"+fieldid+"").data("desc");
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
            $('#Material').html(MaterialClone);
            $('#TDS').html(TDSClone);
            $('#TC').html(TNCClone);
            $('#CT').html(CalculationClone);
            $('#PaymentSlabs').html(PaymentClone);
            $('#tot_amt').val('0.00');
            MultiCurrency_Conversion('tot_amt'); 
            $('#Row_Count1').val('1');
            $('#Row_Count2').val('1');
            $('#Row_Count3').val('1');
            $('#Row_Count4').val('1');
            $('#Row_Count5').val('1');
        }
        $("#vendoridpopup").hide();
        $("#vendorcodesearch").val(''); 
        $("#vendornamesearch").val(''); 
        VendorCodeFunction();
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
                        var pdate =$('#IPO_DT').val();
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

  function GRNNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("GRNnamesearch");
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

  $('#Material').on('focus','[id*="txtGRN_NO_"]',function(event){
    var customid = $('#VID_REF').val();
    $("#tbody_GRN").html('');
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      })
      $.ajax({
          url:'{{route("transaction",[$FormId,"getgoodsreceiptnote"])}}',
          type:'POST',
          data:{'id':customid},
          success:function(data) {
            $("#tbody_GRN").html(data);
            BindGoodsReceiptNote();
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
      $(".clsgrnid").dblclick(function(){
        var fieldid = $(this).attr('id');
        var txtval =    $("#txt"+fieldid+"").val();
        var texdesc =   $("#txt"+fieldid+"").data("desc");
        
        var txtid= $('#hdn_GRN').val();
        var txt_id2= $('#hdn_GRN2').val();

        $('#'+txtid).val(texdesc);
        $('#'+txt_id2).val(txtval);
        $("#GRNpopup").hide();
        
        $("#GRNcodesearch").val(''); 
        $("#GRNnamesearch").val(''); 
        GRNCodeFunction();
        event.preventDefault();
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
  $('#div_billto').on('focus','#txtBILLTO',function(event){

        showSelectedCheck($("#BILLTO").val(),"SELECT_BILLTO");

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
          BillToCodeFunction();        
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

  $('#div_shipto').on('focus','#txtSHIPTO',function(event){
        showSelectedCheck($("#SHIPTO").val(),"SELECT_SHIPTO");
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
          var texdesc =   $(this).children('[id*="txtshipadd"]').text().trim();
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
            MultiCurrency_Conversion('tot_amt'); 
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
          ShipToCodeFunction();        
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
  $('#TC').on('focus','#txtTNCID_popup',function(event){
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
        TNCCodeFunction();
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
// $('#TC').on('focus','[id*="popupTNCDID"]',function(){
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
            var txtvaluetype = $.trim($(this).find('[id*="tncvalue"]').text().trim());
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
            TNCDetCodeFunction();
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
  $('#CT').on('focus','#txtCTID_popup',function(event){
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
        CTIDCodeFunction();
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
                  var TaxableAmount = $(this).find('[id*="ASSESSABLE_VALUE_"]').val();
                  if (!isNaN(TaxableAmount) && TaxableAmount.length !== 0) {
                    netTaxableAmount += parseFloat(TaxableAmount);
                    }                      
                  
                  var GSTAmount = $(this).find('[id*="TGST_AMT_"]').val();
                  if (!isNaN(GSTAmount) && GSTAmount.length !== 0) {
                    netGSTAmount += parseFloat(GSTAmount);
                    }
                  
                  var TotalAmount = $(this).find('[id*="VALUE_AFTER_GST_"]').val();
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
                  if($('#GST_N_Avail').is(':checked') == true)
                  {
                    tvalue = $(this).find('[id*="ASSESSABLE_VALUE_"]').val();
                    totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
                    totalvalue = parseFloat(totalvalue).toFixed(2);
                  }
                  else
                  {
                    tvalue = $(this).find('[id*="VALUE_AFTER_GST_"]').val();
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
                  if($('#GST_N_Avail').is(':checked') == true)
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
                MultiCurrency_Conversion('tot_amt'); 
                getActionEvent();
                event.preventDefault();
        }

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
// $('#CT').on('focus','[id*="popupTID"]',function(){
//      $("#ctiddetpopup").show();
//      $('#hdn_ctiddet').val($(this).attr('id'));
//      event.preventDefault();
//   });

$("#ctiddet_closePopup").on("click",function(event){ 
     $("#ctiddetpopup").hide();
});

function bindCTIDDetailsEvents(){
        $('.clsctiddet').dblclick(function(){    
            var id = $(this).attr('id');
            var txtid =    $("#txt"+id+"").val();
            var txtname =   $("#txt"+id+"").data("desc");
            var fieldid2 = $(this).find('[id*="ctidbasis"]').attr('id');
            var txtbasis = $.trim($(this).find('[id*="ctidbasis"]').text().trim());
            var txtactual =  $("#txt"+fieldid2+"").val();
            var txtgst =  $("#txt"+fieldid2+"").data("desc");
            var fieldid3 = $(this).find('[id*="ctidformula_"]').attr('id');
            var txtrate = $.trim($(this).find('[id*="ctidformula_"]').text().trim());
            var txtsqno =  $("#txt"+fieldid3+"").val();
            var txtformula =  $("#txt"+fieldid3+"").data("desc");
            var txtamount = $.trim($(this).find('[id*="ctidamount_"]').text().trim());
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
                var amount1 = $(this).find('[id*="ASSESSABLE_VALUE_"]').val();

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
            CTIDDetCodeFunction();
            getActionEvent();
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

  $('#Material').on('focus','[id*="txtHSN"]',function(event){
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
    getActionEvent();
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
    MultiCurrency_Conversion('tot_amt'); 
              
      event.preventDefault();
  });
  //HSN Account Ends
//------------------------
//------------------------
  //Item ID Dropdown
  let itemtid = "#ItemIDTable2";
let itemtid2 = "#ItemIDTable";
let itemtidheaders = document.querySelectorAll(itemtid2 + " th");

itemtidheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(itemtid, ".clsitemid", "td:nth-child(" + (i + 1) + ")");
  });
});

function ItemCodeFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("Itemcodesearch");
  filter = input.value.toUpperCase();

  if(filter.length == 0)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else if(filter.length >= 3)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = filter; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else
  {
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
}

function ItemNameFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("Itemnamesearch");
  filter = input.value.toUpperCase();

  if(filter.length == 0)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else if(filter.length >= 3)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = filter; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else
  {
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
}

function ItemUOMFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("ItemUOMsearch");
  filter = input.value.toUpperCase();  
  if(filter.length == 0)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else if(filter.length >= 3)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = filter; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else
  {
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
  if(filter.length == 0)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else if(filter.length >= 3)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = filter; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else
  {
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
}

function ItemCategoryFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("ItemCategorysearch");
  filter = input.value.toUpperCase();
  if(filter.length == 0)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else if(filter.length >= 3)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = filter; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else
  {
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
}

function ItemBUFunction() {
var input, filter, table, tr, td, i, txtValue;
input = document.getElementById("ItemBUsearch");
filter = input.value.toUpperCase();
if(filter.length == 0)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else if(filter.length >= 3)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = filter; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else
  {
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
}

function ItemAPNFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("ItemAPNsearch");
  filter = input.value.toUpperCase();
  if(filter.length == 0)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else if(filter.length >= 3)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = filter; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else
  {
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
}

function ItemCPNFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("ItemCPNsearch");
  filter = input.value.toUpperCase();
  if(filter.length == 0)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
  else if(filter.length >= 3)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = filter; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART);
  }
  else
  {
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
}

function ItemOEMPNFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("ItemOEMPNsearch");
  filter = input.value.toUpperCase();
  if(filter.length == 0)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART);
  }
  else if(filter.length >= 3)
  {
    if ($('#Tax_State').length) 
    {
      var taxstate = $('#Tax_State').val();
    }
    else
    {
      var taxstate = '';
    }
    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = filter; 
    loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART);
  }
  else
  {
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
}

function ItemStatusFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("ItemStatussearch");
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

function loadItem(taxstate,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART){
	
    var IMPORT_DUTYID_REF = $.trim($('#IMPORT_DUTYID_REF').val());
	  var VID_REF           = $.trim($('#VID_REF').val());

    $('#item_loader').show();
		$("#tbody_ItemID").html('');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
      url:'{{route("transaction",[$FormId,"getItemDetails"])}}',
			type:'POST',
			data:{'taxstate':taxstate,'CODE':CODE,'NAME':NAME,'MUOM':MUOM,'GROUP':GROUP,'CTGRY':CTGRY,'BUNIT':BUNIT,'APART':APART,'CPART':CPART,'OPART':OPART,'IMPORT_DUTYID_REF':IMPORT_DUTYID_REF,'VID_REF':VID_REF},
			success:function(data) {
        $('#item_loader').hide();
			$("#tbody_ItemID").html(data); 
			bindItemEvents(); 
      $('.js-selectall').prop('disabled', true);
			},
			error:function(data){
			console.log("Error: Something went wrong.");
			$("#tbody_ItemID").html('');                        
			},
		});

}

  //Item ID Dropdown Ends
//------------------------




//------------------------
     
$(document).ready(function(e) {
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

var objlastdt = <?php echo json_encode($objlastdt[0]->IPO_DT); ?>;
var today = new Date(); 
var ardate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
$('#IPO_DT').attr('min',objlastdt);
$('#IPO_DT').attr('max',ardate);
$('#IPO_DT').val(ardate);

var apudf = <?php echo json_encode($objUdfPBData); ?>;
var count2 = <?php echo json_encode($objCountUDF); ?>;
$("#Row_Count1").val(1);
$("#Row_Count3").val(1);
$("#Row_Count4").val(1);
$("#Row_Count5").val(1);
$("#Row_Count6").val(1);
$("#Row_Count2").val(count2);
$('#udf').find('.participantRow4').each(function(){
  var txt_id4 = $(this).find('[id*="udfinputid"]').attr('id');
  var udfid = $(this).find('[id*="UDFPBID_REF"]').val();
  $.each( apudf, function( apukey, apuvalue ) {
    if(apuvalue.UDFIPOID == udfid)
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
  var viewURL = '{{route("transaction",[$FormId,"add"])}}';
              window.location.href=viewURL;
});

$('#btnExit').on('click', function() {
  var viewURL = '{{route('home')}}';
              window.location.href=viewURL;
});

function bindTotalValue()
    {
      var totalvalue = 0.00;
      var tvalue = 0.00;
      var ctvalue = 0.00;
      var ctgstvalue = 0.00;
      var tttdsamt21 = 0.00;
      $('#Material').find('.participantRow').each(function()
      {
        if($('#GST_N_Avail').is(':checked') == true)
        {
          tvalue = $(this).find('[id*="ASSESSABLE_VALUE_"]').val();
          totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
          totalvalue = parseFloat(totalvalue).toFixed(2);
        }
        else
        {
          tvalue = $(this).find('[id*="VALUE_AFTER_GST_"]').val();
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
          if($('#GST_N_Avail').is(':checked') == true)
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
      MultiCurrency_Conversion('tot_amt'); 
      getActionEvent();
  }

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
                  if($(this).find('[id*="ASSESSABLE_VALUE_"]').val() != '' && $(this).find('[id*="ASSESSABLE_VALUE_"]').val() != '.00') {                   
                  var TaxableAmount = $(this).find('[id*="ASSESSABLE_VALUE_"]').val();
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
                  if($(this).find('[id*="VALUE_AFTER_GST_"]').val() != '' && $(this).find('[id*="VALUE_AFTER_GST_"]').val() != '.00') {                   
                    var TotalAmount = $(this).find('[id*="VALUE_AFTER_GST_"]').val();
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
              tvalue = $(this).find('[id*="VALUE_AFTER_GST_"]').val();
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
            MultiCurrency_Conversion('tot_amt'); 
            getActionEvent();
            event.preventDefault();
    }

$('#GST_N_Avail').on('change', function() 
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
        if($(this).find('[id*="VALUE_AFTER_GST"]').val() != '')
        {
          var taxamt21 = $(this).find('[id*="VALUE_AFTER_GST"]').val();
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

    $('#Material').find('.participantRow').each(function()
    {
        if($(this).find('[id*="TT_AMT"]').val() != '')
        {
          var ttamt21 = $(this).find('[id*="TT_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(ttamt21)).toFixed(2);
        }
    });

    $('#TDS').find('.participantRow7').each(function()
    {
        if($(this).find('[id*="TOT_TD_AMT"]').val() != '')
        {
          var tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
          totalamount = parseFloat(parseFloat(totalamount)+parseFloat(tttdsamt21)).toFixed(2);
        }
    });
    $('#tot_amt').val(totalamount);
    MultiCurrency_Conversion('tot_amt'); 
    getActionEvent();
});

$('#PaymentSlabs').on('change','[id*="PAY_DAYS_"]',function( event ) {
    var d = $(this).val(); 
    d = parseInt(d) - 1;
    var pdate =$('#IPO_DT').val();
    var ddate = new Date(pdate);
    var newddate = new Date(ddate);
    newddate.setDate(newddate.getDate() + d);
    var piddate = newddate.getFullYear() + "-" + ("0" + (newddate.getMonth() + 1)).slice(-2) + "-" + ('0' + newddate.getDate()).slice(-2) ;
    $(this).parent().parent().find('[id*="DUE_DATE_"]').val(piddate);
    getActionEvent();
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
      getActionEvent();
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
      getActionEvent();
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
      getActionEvent();
      event.preventDefault();
  }); 

//delete row
$("#Material").on('click', '.remove', function() {
    var rowCount = $(this).closest('table').find('.participantRow').length;
    if (rowCount > 1) {
		var totalvalue = $('#tot_amt').val();
        totalvalue = parseFloat(totalvalue - $(this).closest('.participantRow').find('[id*="VALUE_AFTER_GST"]').val()).toFixed(2);
        $('#tot_amt').val(totalvalue);
        MultiCurrency_Conversion('tot_amt'); 
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
    getActionEvent();
    event.preventDefault();
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
    getActionEvent();
    event.preventDefault();
});


//add row
$("#Material").on('click', '.add', function() {
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
  getActionEvent();
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
  getActionEvent();
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
    $("#IPO_NO").focus();
}//fnUndoNo

});
</script>

@endpush

@push('bottom-scripts')
<script>

$(document).ready(function() {

  $("#btnSave").on("submit", function( event ) {

    if ($("#frm_trn_add").valid()) {
        // Do something
        alert( "Handler for .submit() called." );
        event.preventDefault();
    }
});


    $('#frm_trn_add1').bootstrapValidator({       
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
             $("#frm_trn_add").submit();
        }
    });
});



function validateForm(){
 
  $("#FocusId").val('');
  var IPO_NO          	=   $.trim($("#IPO_NO").val());
  var IPO_DT          	=   $.trim($("#IPO_DT").val());
  var VID_REF   			=   $.trim($("#VID_REF").val());
  //var FC				=   $('#FC').is(":checked");
  //var CRID_REF        	=   $.trim($("#CRID_REF").val());
  //var CONVFACT        	=   $.trim($("#CONVFACT").val());
  var SALE_ORDER_NO			=   $.trim($("#SALE_ORDER_NO").val());
  var DOC_TYPE   		=   $.trim($("#DOC_TYPE").val());
  var SLID_REF       		=   $.trim($("#SLID_REF").val());
  var REQ_DELIVERY_DATE       		=   $.trim($("#REQ_DELIVERY_DATE").val());
  var IMPORT_DUTYID_REF	=   $.trim($("#IMPORT_DUTYID_REF").val());
  var Credit_days			=   $.trim($("#Credit_days").val());
  var required_status = @json($required_status);
	
  if(IPO_NO ===""){
    $("#FocusId").val('IPO_NO');
    $("#ProceedBtn").focus();
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Please enter value in IPO No.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    return false;
  }
	else if(IPO_DT ===""){
		$("#FocusId").val('IPO_DT');
		$("#IPO_DT").val('');  
		$("#ProceedBtn").focus();
		$("#YesBtn").hide();
		$("#NoBtn").hide();
		$("#OkBtn1").show();
		$("#AlertMessage").text('Please select IPO Date.');
		$("#alert").modal('show');
		$("#OkBtn1").focus();
		return false;
	}  
	else if(VID_REF ===""){
		$("#FocusId").val('txtvendor');
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
	/* else if(FC == false){
		$("#FocusId").val('FC');
		$("#ProceedBtn").focus();
		$("#YesBtn").hide();
		$("#NoBtn").hide();
		$("#OkBtn1").show();
		$("#AlertMessage").text('Please select FC.');
		$("#alert").modal('show');
		$("#OkBtn1").focus();
		return false;
	}
	else if(CRID_REF ===""){
		$("#FocusId").val('txtCRID_popup'); 
		$("#ProceedBtn").focus();
		$("#YesBtn").hide();
		$("#NoBtn").hide();
		$("#OkBtn1").show();
		$("#AlertMessage").text('Please select Currency.');
		$("#alert").modal('show');
		$("#OkBtn1").focus();
		return false;
	} 
	else if(CONVFACT ===""){
		$("#FocusId").val('CONVFACT'); 
		$("#ProceedBtn").focus();
		$("#YesBtn").hide();
		$("#NoBtn").hide();
		$("#OkBtn1").show();
		$("#AlertMessage").text('Please select Conversion Factor.');
		$("#alert").modal('show');
		$("#OkBtn1").focus();
		return false;
	}  */
	else if(required_status > 0 && SALE_ORDER_NO ===""){
		$("#FocusId").val('SALE_ORDER_NO'); 
		$("#ProceedBtn").focus();
		$("#YesBtn").hide();
		$("#NoBtn").hide();
		$("#OkBtn1").show();
		$("#AlertMessage").text('Please enter sale order No.');
		$("#alert").modal('show');
		$("#OkBtn1").focus();
		return false;
	} 
	else if(required_status > 0 && DOC_TYPE ===""){
		$("#FocusId").val('DOC_TYPE'); 
		$("#ProceedBtn").focus();
		$("#YesBtn").hide();
		$("#NoBtn").hide();
		$("#OkBtn1").show();
		$("#AlertMessage").text('Please select document type.');
		$("#alert").modal('show');
		$("#OkBtn1").focus();
		return false;
	} 
	else if(required_status > 0 && SLID_REF ===""){
		$("#FocusId").val('txtsubgl_popup'); 
		$("#ProceedBtn").focus();
		$("#YesBtn").hide();
		$("#NoBtn").hide();
		$("#OkBtn1").show();
		$("#AlertMessage").text('Please select customer.');
		$("#alert").modal('show');
		$("#OkBtn1").focus();
		return false;
	} 
	else if(REQ_DELIVERY_DATE ===""){
		$("#FocusId").val('REQ_DELIVERY_DATE'); 
		$("#ProceedBtn").focus();
		$("#YesBtn").hide();
		$("#NoBtn").hide();
		$("#OkBtn1").show();
		$("#AlertMessage").text('Please select requested delivery date.');
		$("#alert").modal('show');
		$("#OkBtn1").focus();
		return false;
	} 
	else if(Credit_days ===""){
		$("#FocusId").val('Credit_days'); 
		$("#ProceedBtn").focus();
		$("#YesBtn").hide();
		$("#NoBtn").hide();
		$("#OkBtn1").show();
		$("#AlertMessage").text('Please select Credit Days.');
		$("#alert").modal('show');
		$("#OkBtn1").focus();
		return false;
	} 
  else{

    event.preventDefault();
		var allblank1 	= [];
		var allblank2 	= [];
		var allblank3 	= [];
		var allblank4 	= [];
		var allblank5 	= [];
		var allblank6 	= [];
		var allblank7 	= [];
		var allblank8 	= [];
		var allblank9 	= [];
		var allblank10 	= [];
		var allblank11 	= [];
		var allblank12 	= [];
		var allblank13 	= [];
		var focustext   = "";
      
		$('#Material').find('.participantRow').each(function(){

			if($.trim($(this).find("[id*=ITEMID_REF]").val()) ===""){
				allblank1.push('false');
				focustext = $(this).find("[id*=popupITEMID]").attr('id');
			}
			else if($.trim($(this).find("[id*=SO_QTY]").val()) ===""){
				allblank2.push('false');
				focustext = $(this).find("[id*=SO_QTY]").attr('id');
			}
			else if($.trim($(this).find("[id*=RATEPUOM]").val()) ===""){
				allblank3.push('false');
				focustext = $(this).find("[id*=RATEPUOM]").attr('id');
			}
			else{
				allblank1.push('true');
				allblank2.push('true');
				allblank3.push('true');
				focustext   = "";
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
        
        if(jQuery.inArray("false", allblank1) !== -1){
          $("#alert").modal('show');
          $("#FocusId").val(focustext);
          $("#AlertMessage").text('Please select Item Code in Material Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank2) !== -1){
          $("#alert").modal('show');
          $("#FocusId").val(focustext);
          $("#AlertMessage").text('Please enter IPO Qty (MU) in Material Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank3) !== -1){
          $("#FocusId").val(focustext);
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please enter Rate as per MU in Material Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          } 
          else if(jQuery.inArray("false", allblank6) !== -1){
          $("#FocusId").val(focustext);
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please select Terms & Condition Description in T&C Tab.');
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
          else if($("#CHECK_GST_TDS").val() ===''){
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").html('Kindly cross check GST & TDS Details. <br/><br/><input type="checkbox" id="check_gst_tds" onchange="checkGstTds()" >');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
        }
        else if(checkPeriodClosing('{{$FormId}}',$("#IPO_DT").val(),0) ==0){
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text(period_closing_msg);
          $("#alert").modal('show');
          $("#OkBtn1").focus();
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

$("#YesBtn").click(function(){

$("#alert").modal('hide');
var customFnName = $("#YesBtn").data("funcname");
    window[customFnName]();

}); //yes button

$("#btnSave" ).click(function() {
    var formReqData = $("#frm_trn_add");
    if(formReqData.valid()){
      validateForm();
    }
});

window.fnSaveData = function (){

//validate and save data
event.preventDefault();

     var trnseForm = $("#frm_trn_add");
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
    url:'{{ route("transaction",[$FormId,"save"])}}',
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
	
	if($("#FocusId").val() !=''){
		var FocusId=$("#FocusId").val();
		$("#"+FocusId).focus();
	}
	
    $("#closePopup").click();
}

function highlighFocusBtn(pclass){
    $(".activeYes").hide();
    $(".activeNo").hide();
    $("."+pclass+"").show();
}

    						
   $("#FC").change(function() {
      if ($(this).is(":checked") == true){
          $(this).parent().parent().find('#txtCRID_popup').removeAttr('disabled');
          $(this).parent().parent().find('#txtCRID_popup').prop('readonly','true');
          $('#CONVFACT').prop('readonly',false);
          event.preventDefault();
      }
      else
      {
          $(this).parent().parent().find('#txtCRID_popup').prop('disabled','true');
          $(this).parent().parent().find('#txtCRID_popup').removeAttr('readonly');
          $(this).parent().parent().find('#txtCRID_popup').val('');
          $(this).parent().parent().find('#CRID_REF').val('');
          $(this).parent().parent().find('#CONVFACT').val('');
          $('#CONVFACT').prop('readonly',true);
          event.preventDefault();
      }
	  MultiCurrency_Conversion('tot_amt'); 
  });
  
//------------------------
  
		
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
        MultiCurrency_Conversion('TotalValue'); 
        event.preventDefault();
      });

      

  //Currency Dropdown Ends		
//------------------------


function getDueDate(){
  
  $('#DUE_DATE').val('');
  var date  = $("#IPO_DT").val();
  var days  = $("#Credit_days").val();
  

  if(days !=""){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:'{{route("transaction",[$FormId,"getDueDate"])}}',
        type:'POST',
        data:{'date':date,'days':days},
        success:function(data) {
          $('#DUE_DATE').val(data);
        },
        error:function(data){
          console.log("Error: Something went wrong.");
          $('#DUE_DATE').val('');
        },
    }); 

  }    

}

//==================================POPUP =======================================

$('#Material').on('click','[id*="popupITEMID"]',function(event){

	var SalesQuotationID  = $(this).parent().parent().find('[id*="txtSQ_popup"]').val();
	var taxstate          = $.trim($('#Tax_State').val());
	var IMPORT_DUTYID_REF = $.trim($('#IMPORT_DUTYID_REF').val());
	var VID_REF           = $.trim($('#VID_REF').val());


  if(VID_REF ===""){
		$("#FocusId").val('txtvendor');
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
  else{
    
    /*
    $('#item_loader').show();
    $("#tbody_ItemID").html('');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url:'{{route("transaction",[$FormId,"getItemDetails"])}}',
      type:'POST',
      data:{'taxstate':taxstate,'IMPORT_DUTYID_REF':IMPORT_DUTYID_REF,'VID_REF':VID_REF},
      success:function(data) {
        $('#item_loader').hide();
        $("#tbody_ItemID").html(data);    
        bindItemEvents();   
        $('.js-selectall').prop('disabled', true);                     
      },
      error:function(data){
        console.log("Error: Something went wrong.");
        $("#tbody_ItemID").html('');                        
      },
    }); 
    */

    var CODE = ''; 
    var NAME = ''; 
    var MUOM = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem('',CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART);


    $("#ITEMIDpopup").show();

    
    var id    = $(this).attr('id');
    var id2   = $(this).parent().parent().find('[id*="ITEMID_REF"]').attr('id');
    var id3   = $(this).parent().parent().find('[id*="ItemName"]').attr('id');
    var id4   = $(this).parent().parent().find('[id*="Itemspec"]').attr('id');
    var id9   = $(this).parent().parent().find('[id*="popupMUOM"]').attr('id');
    var id10  = $(this).parent().parent().find('[id*="MAIN_UOMID_REF"]').attr('id');
    var id11  = $(this).parent().parent().find('[id*="SO_QTY"]').attr('id');
    var id12  = $(this).parent().parent().find('[id*="popupAUOM"]').attr('id');
    var id13  = $(this).parent().parent().find('[id*="ALT_UOMID_REF"]').attr('id');
    var id14  = $(this).parent().parent().find('[id*="ALT_UOMID_QTY"]').attr('id');
    var id15  = $(this).parent().parent().find('[id*="RATEPUOM"]').attr('id');
    var id16  = $(this).parent().parent().find('[id*="SO_FQTY"]').attr('id');

    var id22  = $(this).parent().parent().find('[id*="FREIGHT_AMT"]').attr('id');
    var id23  = $(this).parent().parent().find('[id*="INSURANCE_AMT"]').attr('id');
    var id24  = $(this).parent().parent().find('[id*="ASSESSABLE_VALUE"]').attr('id');
    var id25  = $(this).parent().parent().find('[id*="CUSTOME_DUTY_RATE_PER"]').attr('id');
    var id26  = $(this).parent().parent().find('[id*="CUSTOME_DUTY_RATE_AMT"]').attr('id');
    var id27  = $(this).parent().parent().find('[id*="SWS_RATE_PER"]').attr('id');
    var id28  = $(this).parent().parent().find('[id*="SWS_RATE_AMT"]').attr('id');
    var id29  = $(this).parent().parent().find('[id*="TOTAL_CUSTOME_DUTY"]').attr('id');
    var id30  = $(this).parent().parent().find('[id*="TAXABLE_VALUE"]').attr('id');
    var id31  = $(this).parent().parent().find('[id*="IGST_RATE_PER"]').attr('id');
    var id32  = $(this).parent().parent().find('[id*="IGST_RATE_AMT"]').attr('id');
    var id33  = $(this).parent().parent().find('[id*="VALUE_AFTER_GST"]').attr('id');

  
    $('#hdn_ItemID').val(id);
    $('#hdn_ItemID2').val(id2);
    $('#hdn_ItemID3').val(id3);
    $('#hdn_ItemID4').val(id4);
    $('#hdn_ItemID9').val(id9);
    $('#hdn_ItemID10').val(id10);
    $('#hdn_ItemID11').val(id11);
    $('#hdn_ItemID12').val(id12);
    $('#hdn_ItemID13').val(id13);
    $('#hdn_ItemID14').val(id14);
    $('#hdn_ItemID15').val(id15);
    $('#hdn_ItemID16').val(id16);
    $('#hdn_ItemID17').val(SalesQuotationID);

    $('#hdn_ItemID22').val(id22);
    $('#hdn_ItemID23').val(id23);
    $('#hdn_ItemID24').val(id24);
    $('#hdn_ItemID25').val(id25);
    $('#hdn_ItemID26').val(id26);
    $('#hdn_ItemID27').val(id27);
    $('#hdn_ItemID28').val(id28);
    $('#hdn_ItemID29').val(id29);
    $('#hdn_ItemID30').val(id30);
    $('#hdn_ItemID31').val(id31);
    $('#hdn_ItemID32').val(id32);
    $('#hdn_ItemID33').val(id33);

    var r_count = 0;
    var SalesEnq = [];
    $('#Material').find('.participantRow').each(function(){
      if($(this).find('[id*="ITEMID_REF"]').val() != '')
      {
        SalesEnq.push($(this).find('[id*="txtSQ_popup"]').val());
        r_count = parseInt(r_count)+1;
        $('#hdn_ItemID21').val(r_count);
      }
    });

    $('#hdn_ItemID18').val(SalesEnq.join(', '));
    var ItemID = [];
    $('#Material').find('.participantRow').each(function(){
      if($(this).find('[id*="ITEMID_REF"]').val() != '')
      {
        ItemID.push($(this).find('[id*="ITEMID_REF"]').val());
      }
    });

    $('#hdn_ItemID19').val(ItemID.join(', '));
    var EnquiryID = [];
    $('#Material').find('.participantRow').each(function(){
      if($(this).find('[id*="SEQID_REF"]').val() != '')
      {
        EnquiryID.push($(this).find('[id*="SEQID_REF"]').val());
      }
    });

    $('#hdn_ItemID20').val(EnquiryID.join(', '));
    event.preventDefault();

  }

});

$("#ITEMID_closePopup").click(function(event){
  $("#ITEMIDpopup").hide();
  $('.js-selectall').prop("checked", false);
});



function bindItemEvents(){

  $('#ItemIDTable2').off();

  $('[id*="chkId"]').change(function(){
    var fieldid               = $(this).parent().parent().attr('id');
    var txtval                = $("#txt"+fieldid+"").val();
    var texdesc               = $("#txt"+fieldid+"").data("desc");
    var fieldid2              = $(this).parent().parent().children('[id*="itemname"]').attr('id');
    var txtname               = $("#txt"+fieldid2+"").val();
    var txtspec               = $("#txt"+fieldid2+"").data("desc");
    var fieldid3              = $(this).parent().parent().children('[id*="itemuom"]').attr('id');
    var txtmuomid             = $("#txt"+fieldid3+"").val();
    var txtauom               = $("#txt"+fieldid3+"").data("desc");

    var apartno               = $("#txt"+fieldid3+"").data("desc2");
    var cpartno               = $("#txt"+fieldid3+"").data("desc3");
    var opartno               = $("#txt"+fieldid3+"").data("desc4");

    var txtmuom               = $(this).parent().parent().children('[id*="itemuom"]').text().trim();
    var fieldid4              = $(this).parent().parent().children('[id*="uomqty"]').attr('id');
    var txtauomid             = $("#txt"+fieldid4+"").val();
    var txtauomqty            = $("#txt"+fieldid4+"").data("desc");
    var txtmuomqty            = $(this).parent().parent().children('[id*="uomqty"]').text().trim();
    var fieldid5              = $(this).parent().parent().children('[id*="irate"]').attr('id');
    var txtruom               = $("#txt"+fieldid5+"").val();
    var txtmqtyf              = $("#txt"+fieldid5+"").data("desc");
    var fieldid6              = $(this).parent().parent().children('[id*="itax"]').attr('id');
    var txttax2               = $("#txt"+fieldid6+"").val();
    var txttax1               = $("#txt"+fieldid6+"").data("desc");
    var fieldid7              = $(this).parent().parent().children('[id*="ise"]').attr('id');
    var txtenqno              = $("#txt"+fieldid7+"").val();
    var txtenqid              = $("#txt"+fieldid7+"").data("desc");

    var texdescountPer        =  $("#txt"+fieldid+"").data("desc1");
    var texdescountAmount     =  $("#txt"+fieldid+"").data("desc2");
    
    if(txtenqno == undefined){
      txtenqno = '';
    }

    if(txtenqid == undefined){
      txtenqid = '';
    }

    var totalvalue = 0.00;
    var txttaxamt1 = 0.00;
    var txttaxamt2 = 0.00;
    var txttottaxamt = 0.00;
    var txttotamtatax =0.00;
    
    txtruom = parseFloat(txtruom).toFixed(5); 
    txtauomqty = (parseFloat(txtmuomqty)/parseFloat(txtmqtyf))*parseFloat(txtauomqty);
    
    var txtamt = parseFloat((parseFloat(txtmuomqty)*parseFloat(txtruom))).toFixed(2);

    
    if(txttax1 == undefined || txttax1 == ''){
      txttax1 = 0.0000;
      txttaxamt1 = 0;
    }
    else{
        txttaxamt1 = parseFloat((parseFloat(txtamt)*parseFloat(txttax1))/100).toFixed(2);
    }

    if(txttax2 == undefined || txttax2 == ''){
      txttax2 = 0.0000;
      txttaxamt2 = 0;
    }
    else{
        txttaxamt2 = parseFloat((parseFloat(txtamt)*parseFloat(txttax2))/100).toFixed(2);
    }

    var txttottaxamt = parseFloat((parseFloat(txttaxamt1)+parseFloat(txttaxamt2))).toFixed(2);
    var txttotamtatax = parseFloat((parseFloat(txtamt)+parseFloat(txttottaxamt))).toFixed(2);
    
    if(intRegex.test(txtauomqty)){
        txtauomqty = (txtauomqty +'.000');
    }

    if(intRegex.test(txtmuomqty)){
      txtmuomqty = (txtmuomqty +'.000');
    }

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

    var customer_duty_rate  = $("#txt"+fieldid+"").data("desc4");
    var sws_rate            = $("#txt"+fieldid+"").data("desc5");
    var igst_rate           = $("#txt"+fieldid+"").data("desc6");

    var ipo_amount          = txtamt;
    var freight_amount      = 0;
    var insurance_amount    = 0;
    var assessable_value    = parseFloat(parseFloat(ipo_amount)+parseFloat(freight_amount)+parseFloat(insurance_amount)).toFixed(2);
    var custom_duty_amount  = parseFloat((parseFloat(assessable_value)*parseFloat(customer_duty_rate))/100).toFixed(2);
    var sws_amount          = parseFloat((parseFloat(custom_duty_amount)*parseFloat(sws_rate))/100).toFixed(2);
    var total_custom_duty   = parseFloat(custom_duty_amount)+parseFloat(sws_amount);
    var taxable_value       = parseFloat(parseFloat(assessable_value)+parseFloat(custom_duty_amount)+parseFloat(sws_amount)).toFixed(2);
    var igst_amount         = parseFloat((parseFloat(taxable_value)*parseFloat(igst_rate))/100).toFixed(2);
    var value_after_gst     = parseFloat(taxable_value)+parseFloat(igst_amount);
    

    var SalesEnq2 = [];
    $('#Material').find('.participantRow').each(function(){
      if($(this).find('[id*="ITEMID_REF"]').val() != '')
      {
        var seitem = $(this).find('[id*="txtSQ_popup"]').val()+'-'+$(this).find('[id*="SEQID_REF"]').val()+'-'+$(this).find('[id*="ITEMID_REF"]').val();
        SalesEnq2.push(seitem);
      }
    });
    
    var salesenquiry =  $('#hdn_ItemID18').val();
    var itemids =  $('#hdn_ItemID19').val();
    var enquiryids =  $('#hdn_ItemID20').val();

    if($(this).is(":checked") == true){

      
      var txtenqitem = txtenqno+'-'+txtenqid+'-'+txtval;

      if(jQuery.inArray(txtenqitem, SalesEnq2) !== -1){
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
        $('#hdn_ItemID28').val('');
        $('#hdn_ItemID29').val('');
        $('#hdn_ItemID30').val('');
        $('#hdn_ItemID31').val('');
        $('#hdn_ItemID32').val('');
        $('#hdn_ItemID33').val('');

        txtval = '';
        texdesc = '';
        txtname = '';
        txtmuom = '';
        txtauom = '';
        txtmuomid = '';
        txtauomid = '';
        txtauomqty='';
        txtmuomqty='';
        txtruom = '';
        txtamt = '';
        txttax1 = '';
        txttax2 = '';
        txtenqno = '';
        txtenqid = '';

        customer_duty_rate  = '';
        sws_rate            = '';
        igst_rate           = '';

        ipo_amount          = '';
        freight_amount      = '';
        insurance_amount    = '';
        assessable_value    = '';
        custom_duty_amount  = '';
        sws_amount          = '';
        total_custom_duty   = '';
        taxable_value       = '';
        igst_amount         = '';
        value_after_gst     = '';

        $(".blurRate").blur();
        return false;

      }
      

      if($('#hdn_ItemID').val() == "" && txtval != ''){

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
        $clone.find('[id*="popupITEMID"]').val(texdesc);
        $clone.find('[id*="ITEMID_REF"]').val(txtval);
        $clone.find('[id*="ItemName"]').val(txtname);
        $clone.find('[id*="Itemspec"]').val(txtspec);
        $clone.find('[id*="popupMUOM"]').val(txtmuom);
        $clone.find('[id*="MAIN_UOMID_REF"]').val(txtmuomid);
        $clone.find('[id*="SO_QTY"]').val(txtmuomqty);
        $clone.find('[id*="popupAUOM"]').val(txtauom);
        $clone.find('[id*="ALT_UOMID_REF"]').val(txtauomid);
        $clone.find('[id*="ALT_UOMID_QTY"]').val(txtauomqty);
        $clone.find('[id*="RATEPUOM"]').val(txtruom);
        $clone.find('[id*="SO_FQTY"]').val(txtmuomqty);
        $clone.find('[id*="FREIGHT_AMT"]').val(freight_amount);
        $clone.find('[id*="INSURANCE_AMT"]').val(insurance_amount);
        $clone.find('[id*="ASSESSABLE_VALUE"]').val(assessable_value);
        $clone.find('[id*="CUSTOME_DUTY_RATE_PER"]').val(customer_duty_rate);
        $clone.find('[id*="CUSTOME_DUTY_RATE_AMT"]').val(custom_duty_amount);
        $clone.find('[id*="SWS_RATE_PER"]').val(sws_rate);
        $clone.find('[id*="SWS_RATE_AMT"]').val(sws_amount);
        $clone.find('[id*="TOTAL_CUSTOME_DUTY"]').val(total_custom_duty);
        $clone.find('[id*="TAXABLE_VALUE"]').val(taxable_value);
        $clone.find('[id*="IGST_RATE_PER"]').val(igst_rate);
        $clone.find('[id*="IGST_RATE_AMT"]').val(igst_amount);
        $clone.find('[id*="VALUE_AFTER_GST"]').val(value_after_gst);

        $clone.find('[id*="SEQID_REF"]').val(txtenqid);
        $clone.find('[id*="DISAFTT_AMT"]').val(txtamt);

        $clone.find('[id*="Alpspartno"]').val(apartno);
        $clone.find('[id*="Custpartno"]').val(cpartno);
        $clone.find('[id*="OEMpartno"]').val(opartno);

        $clone.find('[id*="DISC_PER"]').val(texdescountPer);
        $clone.find('[id*="DISC_AMT"]').val(texdescountAmount);

                                  
        $tr.closest('table').append($clone);   
        var rowCount = $('#Row_Count1').val();
        rowCount = parseInt(rowCount)+1;
        $('#Row_Count1').val(rowCount);


        var tvalue = parseFloat(value_after_gst).toFixed(2);
        totalvalue = $('#tot_amt').val();
        totalvalue =  parseFloat(totalvalue) + parseFloat(tvalue);
        totalvalue = parseFloat(totalvalue).toFixed(2);
        $('#tot_amt').val(totalvalue);
        MultiCurrency_Conversion('tot_amt'); 

        $(".blurRate").blur();
        //$("#ITEMIDpopup").hide();
        event.preventDefault();

      }
      else{

        var txtid     = $('#hdn_ItemID').val();
        var txt_id2   = $('#hdn_ItemID2').val();
        var txt_id3   = $('#hdn_ItemID3').val();
        var txt_id4   = $('#hdn_ItemID4').val();
        var txt_id9   = $('#hdn_ItemID9').val();
        var txt_id10  = $('#hdn_ItemID10').val();
        var txt_id11  = $('#hdn_ItemID11').val();
        var txt_id12  = $('#hdn_ItemID12').val();
        var txt_id13  = $('#hdn_ItemID13').val();
        var txt_id14  = $('#hdn_ItemID14').val();
        var txt_id15  = $('#hdn_ItemID15').val();
        var txt_id16  = $('#hdn_ItemID16').val();

        var txt_id22  = $('#hdn_ItemID22').val();
        var txt_id23  = $('#hdn_ItemID23').val();
        var txt_id24  = $('#hdn_ItemID24').val();
        var txt_id25  = $('#hdn_ItemID25').val();
        var txt_id26  = $('#hdn_ItemID26').val();
        var txt_id27  = $('#hdn_ItemID27').val();
        var txt_id28  = $('#hdn_ItemID28').val();
        var txt_id29  = $('#hdn_ItemID29').val();
        var txt_id30  = $('#hdn_ItemID30').val();
        var txt_id31  = $('#hdn_ItemID31').val();
        var txt_id32  = $('#hdn_ItemID32').val();
        var txt_id33  = $('#hdn_ItemID33').val();

        $('#'+txtid).val(texdesc);
        $('#'+txt_id2).val(txtval);
        $('#'+txt_id3).val(txtname);
        $('#'+txt_id4).val(txtspec);
        $('#'+txt_id9).val(txtmuom);
        $('#'+txt_id10).val(txtmuomid);
        $('#'+txt_id11).val(txtmuomqty);
        $('#'+txt_id12).val(txtauom);
        $('#'+txt_id13).val(txtauomid);
        $('#'+txt_id14).val(txtauomqty);
        $('#'+txt_id15).val(txtruom);
        $('#'+txt_id16).val(txtmuomqty);

        $('#'+txt_id22).val(freight_amount);
        $('#'+txt_id23).val(insurance_amount);
        $('#'+txt_id24).val(assessable_value);
        $('#'+txt_id25).val(customer_duty_rate);
        $('#'+txt_id26).val(custom_duty_amount);
        $('#'+txt_id27).val(sws_rate);
        $('#'+txt_id28).val(sws_amount);
        $('#'+txt_id29).val(total_custom_duty);
        $('#'+txt_id30).val(taxable_value);
        $('#'+txt_id31).val(igst_rate);
        $('#'+txt_id32).val(igst_amount);
        $('#'+txt_id33).val(value_after_gst);


        $('#'+txtid).parent().parent().find('[id*="SEQID_REF"]').val(txtenqid);
        $('#'+txtid).parent().parent().find('[id*="DISAFTT_AMT"]').val(txtamt);

        $('#'+txtid).parent().parent().find('[id*="Alpspartno"]').val(apartno);
        $('#'+txtid).parent().parent().find('[id*="Custpartno"]').val(cpartno);
        $('#'+txtid).parent().parent().find('[id*="OEMpartno"]').val(opartno);


        var tvalue = parseFloat(value_after_gst).toFixed(2);
        totalvalue = $('#tot_amt').val();
        totalvalue =  parseFloat(totalvalue) + parseFloat(tvalue);
        totalvalue = parseFloat(totalvalue).toFixed(2);
        $('#tot_amt').val(totalvalue);
        MultiCurrency_Conversion('tot_amt'); 

        $('#hdn_ItemID').val('');
        $('#hdn_ItemID2').val('');
        $('#hdn_ItemID3').val('');
        $('#hdn_ItemID4').val('');
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
        $('#hdn_ItemID28').val('');
        $('#hdn_ItemID29').val('');
        $('#hdn_ItemID30').val('');
        $('#hdn_ItemID31').val('');
        $('#hdn_ItemID32').val('');
        $('#hdn_ItemID33').val('');

        $('#'+txtid).parent().parent().find('[id*="DISC_PER"]').val(texdescountPer);
        $('#'+txtid).parent().parent().find('[id*="DISC_AMT"]').val(texdescountAmount);

        $(".blurRate").blur();
        //$("#ITEMIDpopup").hide();
        event.preventDefault();

      }

    }
    else if($(this).is(":checked") == false){

      var id = txtval;
      var enqid = txtenqid;
      var sqno = txtenqno;
      var r_count = $('#Row_Count1').val();

      $('#Material').find('.participantRow').each(function(){

        var itemid = $(this).find('[id*="ITEMID_REF"]').val();
        var enquiryid = $(this).find('[id*="SEQID_REF"]').val();
        var quotationno = $(this).find('[id*="txtSQ_popup"]').val();

        if(id == itemid && enqid == enquiryid && sqno == quotationno ){

          var rowCount = $('#Row_Count1').val();
          
          if (rowCount > 1) {
            var totalvalue = $('#tot_amt').val();
            totalvalue = parseFloat(totalvalue - $(this).closest('.participantRow').find('[id*="VALUE_AFTER_GST_"]').val()).toFixed(2);
            $('#tot_amt').val(totalvalue);
            MultiCurrency_Conversion('tot_amt'); 
            $(this).closest('.participantRow').remove(); 
            rowCount = parseInt(rowCount)-1;
            $('#Row_Count1').val(rowCount);
          }
          else{
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
          }

          $(".blurRate").blur();
          event.preventDefault(); 
        }

      });

    }

    $("#Itemcodesearch").val(''); 
    $("#Itemnamesearch").val(''); 
    $("#ItemUOMsearch").val(''); 
    $("#ItemGroupsearch").val(''); 
    $("#ItemCategorysearch").val(''); 
    $("#ItemStatussearch").val(''); 
    $('.remove').removeAttr('disabled'); 
    //ItemCodeFunction();
    getActionEvent();
    event.preventDefault();
  });

}

      

  //Item ID Dropdown Ends
//------------------------



//------------------------
  //ALT UOM Dropdown

  let altutid = "#altuomTable2";
      let altutid2 = "#altuomTable";
      let altutidheaders = document.querySelectorAll(altutid2 + " th");

      // Sort the table element when clicking on the table headers
      altutidheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(altutid, ".clsaltuom", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function altuomCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("altuomcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("altuomTable2");
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

      function altuomNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("altuomnamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("altuomTable2");
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

      

  $('#Material').on('focus','[id*="popupAUOM"]',function(event){
        var ItemID = $(this).parent().parent().find('[id*="ITEMID_REF"]').val();

        var id = $(this).attr('id');
        var id2 = $(this).parent().parent().find('[id*="ALT_UOMID_REF"]').attr('id');
        var id3 = $(this).parent().parent().find('[id*="SO_QTY"]').attr('id');
        var id4 = $(this).parent().parent().find('[id*="ALT_UOMID_QTY"]').attr('id');

        
        if(ItemID !=''){
                $("#tbody_altuom").html('');
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getAltUOM"])}}',
                      type:'POST',
                      data:{'id':ItemID,'fieldid':id2},
                      success:function(data) {
                        
                        $("#tbody_altuom").html(data);   
                        bindAltUOM(); 
                        showSelectedCheck($("#"+id2).val(),"SELECT_"+id2)                 
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#tbody_altuom").html('');                        
                      },
                  }); 
        }
        else
        {
                $("#altuompopup").hide();
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn").hide();
                $("#OkBtn1").show();
                $("#AlertMessage").text('Please Select Item First.');
                $("#alert").modal('show');
                $("#OkBtn1").focus();
                highlighFocusBtn('activeOk1');
                return false;
        }

       
        $("#altuompopup").show();


        
        $('#hdn_altuom').val(id);
        $('#hdn_altuom2').val(id2);
        $('#hdn_altuom3').val(id3);
        $('#hdn_altuom4').val(id4);
        event.preventDefault();
      });

      $("#altuom_closePopup").click(function(event){
        $("#altuompopup").hide();
      });

    function bindAltUOM(){

      $('#altuomTable2').off(); 

      $(".clsaltuom").click(function(){
        var fieldid = $(this).attr('id');
        var txtval =   $("#txt"+fieldid+"").val();
        var texdesc =  $("#txt"+fieldid+"").data("desc");
        var txtid= $('#hdn_altuom').val();
        var txt_id2= $('#hdn_altuom2').val();
        var txt_id3= $('#hdn_altuom3').val();
        var txt_id4= $('#hdn_altuom4').val();
        $('#'+txtid).val(texdesc);
        $('#'+txt_id2).val(txtval);

        var itemid = $('#'+txtid).parent().parent().find('[id*="ITEMID_REF"]').val();
        var altuomid = txtval;
        var mqty = $('#'+txtid).parent().parent().find('[id*="SO_QTY"]').val();

        if(altuomid!=''){
              $('#'+txt_id4).val('');
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getaltuomqty"])}}',
                      type:'POST',
                      data:{'id':altuomid, 'itemid':itemid, 'mqty':mqty},
                      success:function(data) {
                        if(intRegex.test(data)){
                            data = (data +'.000');
                        }
                        $('#'+txt_id4).val(data);                        
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $('#'+txt_id4).val('');                        
                      },
                  }); 
                      
              }

        $("#altuompopup").hide();
        $("#altuomcodesearch").val(''); 
        $("#altuomnamesearch").val(''); 
        
        altuomCodeFunction();
        getActionEvent();
        event.preventDefault();
      });
    }

      
function onChangeAmount(textid,textval){
	
    if($.trim(textval) !="" && parseFloat($.trim(textval)) >= 0 ){
    
        var expstr				=	textid.split("_");
        var indexid 			= 	$(expstr).last()[0];
        
        var tot_amt_pre			    =	  $("#tot_amt").val();
        var value_after_gst_pre	=	  $("#VALUE_AFTER_GST_"+indexid).val();
        var tot_amt     		    = 	parseFloat(parseFloat(tot_amt_pre) - parseFloat(value_after_gst_pre));
        
        var customer_duty_rate  = 	$("#CUSTOME_DUTY_RATE_PER_"+indexid).val();
        var sws_rate            = 	$("#SWS_RATE_PER_"+indexid).val();
        var igst_rate           = 	$("#IGST_RATE_PER_"+indexid).val();

        var ipo_qty             =   $.trim($("#SO_QTY_"+indexid).val()) !=""?$.trim($("#SO_QTY_"+indexid).val()):"1";
        var rate_as_per_mu      =   parseFloat($("#RATEPUOM_"+indexid).val()) * parseFloat(ipo_qty);

        var disc_per            =   $.trim($("#DISC_PER_"+indexid).val()) !=""?parseFloat($.trim($("#DISC_PER_"+indexid).val())):parseFloat("0.00");
        var disc_percent        =   parseFloat((parseFloat(rate_as_per_mu)*parseFloat(disc_per))/100).toFixed(2);
        var disc_amount         =   $.trim($("#DISC_AMT_"+indexid).val()) !=""?parseFloat($.trim($("#DISC_AMT_"+indexid).val())):parseFloat("0.00");

        
        var ipo_amount          =   parseFloat((rate_as_per_mu - disc_amount - disc_percent)).toFixed(2);
        var freight_amount      = 	$("#FREIGHT_AMT_"+indexid).val();
        var insurance_amount    = 	$("#INSURANCE_AMT_"+indexid).val();
        var assessable_value    = 	parseFloat(parseFloat(ipo_amount)+parseFloat(freight_amount)+parseFloat(insurance_amount)).toFixed(2);
        var custom_duty_amount  = 	parseFloat((parseFloat(assessable_value)*parseFloat(customer_duty_rate))/100).toFixed(2);
        var sws_amount          = 	parseFloat((parseFloat(custom_duty_amount)*parseFloat(sws_rate))/100).toFixed(2);
        var total_custom_duty   = 	parseFloat(parseFloat(custom_duty_amount)+parseFloat(sws_amount)).toFixed(2);
        var taxable_value       = 	parseFloat(parseFloat(assessable_value)+parseFloat(custom_duty_amount)+parseFloat(sws_amount)).toFixed(2);
        var igst_amount         = 	parseFloat((parseFloat(taxable_value)*parseFloat(igst_rate))/100).toFixed(2);
        var value_after_gst     = 	parseFloat(parseFloat(taxable_value) + parseFloat(igst_amount)).toFixed(2);
        var tot_amt_new     	  =	  parseFloat(parseFloat(tot_amt) + parseFloat(value_after_gst)).toFixed(2);


        $("#DISAFTT_AMT_"+indexid).val(parseFloat(ipo_amount).toFixed(2));
        $("#FREIGHT_AMT_"+indexid).val(parseFloat(freight_amount).toFixed(2));
        $("#INSURANCE_AMT_"+indexid).val(parseFloat(insurance_amount).toFixed(2));
        $("#ASSESSABLE_VALUE_"+indexid).val(parseFloat(assessable_value).toFixed(2));
        $("#CUSTOME_DUTY_RATE_PER_"+indexid).val(parseFloat(customer_duty_rate).toFixed(2));
        $("#CUSTOME_DUTY_RATE_AMT_"+indexid).val(parseFloat(custom_duty_amount).toFixed(2));
        $("#SWS_RATE_PER_"+indexid).val(parseFloat(sws_rate).toFixed(2));
        $("#SWS_RATE_AMT_"+indexid).val(parseFloat(sws_amount).toFixed(2));
        $("#TOTAL_CUSTOME_DUTY_"+indexid).val(parseFloat(total_custom_duty).toFixed(2));
        $("#TAXABLE_VALUE_"+indexid).val(parseFloat(taxable_value).toFixed(2));
        $("#IGST_RATE_PER_"+indexid).val(parseFloat(igst_rate).toFixed(2));
        $("#IGST_RATE_AMT_"+indexid).val(parseFloat(igst_amount).toFixed(2));
        $("#VALUE_AFTER_GST_"+indexid).val(parseFloat(value_after_gst).toFixed(2));
        $("#tot_amt").val(tot_amt_new);

    }
    getActionEvent();
	
}

$('#Material').on('click','[id*="DISC_AMT"]',function(event){
    $(this).parent().parent().find('[id*="DISC_AMT"]').prop('readonly',false);
    $(this).parent().parent().find('[id*="DISC_PER"]').prop('readonly',true);
    $(this).parent().parent().find('[id*="DISC_PER"]').val('');
    getActionEvent();
});

$('#Material').on('click','[id*="DISC_PER"]',function(event){
    $(this).parent().parent().find('[id*="DISC_PER"]').prop('readonly',false);
    $(this).parent().parent().find('[id*="DISC_AMT"]').prop('readonly',true);
    $(this).parent().parent().find('[id*="DISC_AMT"]').val('');
    getActionEvent();
});


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

function getActionEvent(){
  getTotalRowValue();
}

function getTotalRowValue(){
  
  var SO_QTY                = 0;
  var ALT_UOMID_QTY         = 0;
  var RATEPUOM              = 0;
  var DISC_AMT              = 0;
  var DISAFTT_AMT           = 0;
  var FREIGHT_AMT           = 0;
  var INSURANCE_AMT         = 0;
  var ASSESSABLE_VALUE      = 0;
  var CUSTOME_DUTY_RATE_AMT = 0;
  var SWS_RATE_AMT          = 0;
  var TOTAL_CUSTOME_DUTY    = 0;
  var TAXABLE_VALUE         = 0;
  var IGST_RATE_AMT         = 0;
  var VALUE_AFTER_GST       = 0;

  $('#Material').find('.participantRow').each(function(){
    SO_QTY                = $(this).find('[id*="SO_QTY"]').val() > 0?SO_QTY+parseFloat($(this).find('[id*="SO_QTY"]').val()):SO_QTY;
    ALT_UOMID_QTY         = $(this).find('[id*="ALT_UOMID_QTY"]').val() > 0?ALT_UOMID_QTY+parseFloat($(this).find('[id*="ALT_UOMID_QTY"]').val()):ALT_UOMID_QTY;
    RATEPUOM              = $(this).find('[id*="RATEPUOM"]').val() > 0?RATEPUOM+parseFloat($(this).find('[id*="RATEPUOM"]').val()):RATEPUOM;
    DISC_AMT              = $(this).find('[id*="DISC_AMT"]').val() > 0?DISC_AMT+parseFloat($(this).find('[id*="DISC_AMT"]').val()):DISC_AMT;
    DISAFTT_AMT           = $(this).find('[id*="DISAFTT_AMT"]').val() > 0?DISAFTT_AMT+parseFloat($(this).find('[id*="DISAFTT_AMT"]').val()):DISAFTT_AMT;
    FREIGHT_AMT           = $(this).find('[id*="FREIGHT_AMT"]').val() > 0?FREIGHT_AMT+parseFloat($(this).find('[id*="FREIGHT_AMT"]').val()):FREIGHT_AMT;
    INSURANCE_AMT         = $(this).find('[id*="INSURANCE_AMT"]').val() > 0?INSURANCE_AMT+parseFloat($(this).find('[id*="INSURANCE_AMT"]').val()):INSURANCE_AMT;
    ASSESSABLE_VALUE      = $(this).find('[id*="ASSESSABLE_VALUE"]').val() > 0?ASSESSABLE_VALUE+parseFloat($(this).find('[id*="ASSESSABLE_VALUE"]').val()):ASSESSABLE_VALUE;
    CUSTOME_DUTY_RATE_AMT = $(this).find('[id*="CUSTOME_DUTY_RATE_AMT"]').val() > 0?CUSTOME_DUTY_RATE_AMT+parseFloat($(this).find('[id*="CUSTOME_DUTY_RATE_AMT"]').val()):CUSTOME_DUTY_RATE_AMT;
    SWS_RATE_AMT          = $(this).find('[id*="SWS_RATE_AMT"]').val() > 0?SWS_RATE_AMT+parseFloat($(this).find('[id*="SWS_RATE_AMT"]').val()):SWS_RATE_AMT;
    TOTAL_CUSTOME_DUTY    = $(this).find('[id*="TOTAL_CUSTOME_DUTY"]').val() > 0?TOTAL_CUSTOME_DUTY+parseFloat($(this).find('[id*="TOTAL_CUSTOME_DUTY"]').val()):TOTAL_CUSTOME_DUTY;
    TAXABLE_VALUE         = $(this).find('[id*="TAXABLE_VALUE"]').val() > 0?TAXABLE_VALUE+parseFloat($(this).find('[id*="TAXABLE_VALUE"]').val()):TAXABLE_VALUE;
    IGST_RATE_AMT         = $(this).find('[id*="IGST_RATE_AMT"]').val() > 0?IGST_RATE_AMT+parseFloat($(this).find('[id*="IGST_RATE_AMT"]').val()):IGST_RATE_AMT;
    VALUE_AFTER_GST       = $(this).find('[id*="VALUE_AFTER_GST"]').val() > 0?VALUE_AFTER_GST+parseFloat($(this).find('[id*="VALUE_AFTER_GST"]').val()):VALUE_AFTER_GST;
  });


  SO_QTY                = SO_QTY > 0?parseFloat(SO_QTY).toFixed(3):'';
  ALT_UOMID_QTY         = ALT_UOMID_QTY > 0?parseFloat(ALT_UOMID_QTY).toFixed(3):'';
  RATEPUOM              = RATEPUOM > 0?parseFloat(RATEPUOM).toFixed(5):'';
  DISC_AMT              = DISC_AMT > 0?parseFloat(DISC_AMT).toFixed(2):'';
  DISAFTT_AMT           = DISAFTT_AMT > 0?parseFloat(DISAFTT_AMT).toFixed(2):'';
  FREIGHT_AMT           = FREIGHT_AMT > 0?parseFloat(FREIGHT_AMT).toFixed(2):'';
  INSURANCE_AMT         = INSURANCE_AMT > 0?parseFloat(INSURANCE_AMT).toFixed(2):'';
  ASSESSABLE_VALUE      = ASSESSABLE_VALUE > 0?parseFloat(ASSESSABLE_VALUE).toFixed(2):'';
  CUSTOME_DUTY_RATE_AMT = CUSTOME_DUTY_RATE_AMT > 0?parseFloat(CUSTOME_DUTY_RATE_AMT).toFixed(2):'';
  SWS_RATE_AMT          = SWS_RATE_AMT > 0?parseFloat(SWS_RATE_AMT).toFixed(2):'';
  TOTAL_CUSTOME_DUTY    = TOTAL_CUSTOME_DUTY > 0?parseFloat(TOTAL_CUSTOME_DUTY).toFixed(2):'';
  TAXABLE_VALUE         = TAXABLE_VALUE > 0?parseFloat(TAXABLE_VALUE).toFixed(2):'';
  IGST_RATE_AMT         = IGST_RATE_AMT > 0?parseFloat(IGST_RATE_AMT).toFixed(2):'';
  VALUE_AFTER_GST       = VALUE_AFTER_GST > 0?parseFloat(VALUE_AFTER_GST).toFixed(2):'';

  $("#SO_QTY_total").text(SO_QTY);
  $("#ALT_UOMID_QTY_total").text(ALT_UOMID_QTY);
  $("#RATEPUOM_total").text(RATEPUOM);
  $("#DISC_AMT_total").text(DISC_AMT);
  $("#DISAFTT_AMT_total").text(DISAFTT_AMT);
  $("#FREIGHT_AMT_total").text(FREIGHT_AMT);
  $("#INSURANCE_AMT_total").text(INSURANCE_AMT);
  $("#ASSESSABLE_VALUE_total").text(ASSESSABLE_VALUE);
  $("#CUSTOME_DUTY_RATE_AMT_total").text(CUSTOME_DUTY_RATE_AMT);
  $("#SWS_RATE_AMT_total").text(SWS_RATE_AMT);
  $("#TOTAL_CUSTOME_DUTY_total").text(TOTAL_CUSTOME_DUTY);
  $("#TAXABLE_VALUE_total").text(TAXABLE_VALUE);
  $("#IGST_RATE_AMT_total").text(IGST_RATE_AMT);
  $("#VALUE_AFTER_GST_total").text(VALUE_AFTER_GST);
  MultiCurrency_Conversion('tot_amt'); 

}

function getTextDec(id,n){
  $("#"+id).val(parseFloat($("#"+id).val()).toFixed(n));
}
</script>

<script>
function checkGstTds(){
  if($("#check_gst_tds").is(":checked") == true){
    $("#CHECK_GST_TDS").val('1')
  }
  else{
    $("#CHECK_GST_TDS").val('')
  }
}
</script>
<input type="hidden" id="CHECK_GST_TDS" >
@endpush

