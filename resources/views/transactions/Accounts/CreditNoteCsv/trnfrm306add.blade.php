@extends('layouts.app')
@section('content')
<div class="container-fluid topnav">
  <div class="row">
    <div class="col-lg-2">
    <a href="{{route('transaction',[$FormId,'index'])}}" class="btn singlebt">Credit Note (Stock & Value)<br/> CSV</a>
    </div>

    <div class="col-lg-10 topnav-pd">
      <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
      <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
      <button class="btn topnavbt" id="btnSaveData" ><i class="fa fa-floppy-o"></i> Save</button>
      <button style="display:none" class="btn topnavbt buttonload"> <i class="fa fa-refresh fa-spin"></i> {{Session::get('save')}}</button>
      <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
      <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
      <button class="btn topnavbt" id="btnUndo"  ><i class="fa fa-undo"></i> Undo</button>
      <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
      <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-thumbs-o-up"></i> Approved</button>
      <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
      <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
    </div>
  </div>
</div>	
    
<form id="frm_trn_add" method="POST"  >

  <div class="container-fluid purchase-order-view">
    @csrf
    <div class="container-fluid filter">
      <div class="inner-form">
                    
        <div class="row">
          <div class="col-lg-2 pl"><p>CSV No</p></div>
          <div class="col-lg-2 pl">
          <input type="text" name="CSV_NO" id="CSV_NO" value="{{$DOC_NO}}" {{$docarray['READONLY']}} class="form-control" maxlength="{{$docarray['MAXLENGTH']}}" autocomplete="off" style="text-transform:uppercase" >
          <script>docMissing(@json($docarray['FY_FLAG']));</script>
          </div>
                              
          <div class="col-lg-2 pl"><p>CSV Date</p></div>
          <div class="col-lg-2 pl">
              <input type="date" name="CSV_DT" id="CSV_DT" value="{{ old('CSV_DT') }}" onchange='checkPeriodClosing("{{$FormId}}",this.value,1),getDocNoByEvent("CSV_NO",this,@json($doc_req))' class="form-control mandatory" autocomplete="off" placeholder="dd/mm/yyyy" >
          </div>
        
        <div class="col-lg-2 pl"><p>Customer</p></div>
        <div class="col-lg-2 pl">
            <input type="text" name="SubGl_popup" id="txtgl_popup" class="form-control mandatory"  autocomplete="off" readonly/>
            <input type="hidden" name="GLID_REF" id="GLID_REF" class="form-control" autocomplete="off" /> 
            <input type="hidden" name="SLID_REF" id="SLID_REF" class="form-control" autocomplete="off" />
            <input type="hidden" name="hdnmaterial" id="hdnmaterial" class="form-control" autocomplete="off" />                                                                
        </div>

        </div>

        <div class="row">
                                
          <div class="col-lg-2 pl"><p>Bill To </p></div>
          <div class="col-lg-2 pl" id="div_billto">
              <input type="text" name="txtBILLTO1" id="txtBILLTO1" class="form-control"  autocomplete="off" readonly  />
              <input type="hidden" name="BILLTO1" id="BILLTO1" class="form-control" autocomplete="off" />
          </div>
          
          <div class="col-lg-2 pl"><p>Ship To</p></div>
          <div class="col-lg-2 pl" id="div_shipto">
              <input type="text" name="txtSHIPTO1" id="txtSHIPTO1" class="form-control"  autocomplete="off" readonly  />
              <input type="hidden" name="SHIPTO1" id="SHIPTO1" class="form-control" autocomplete="off" />
              <input type="hidden" name="Tax_State1" id="Tax_State1" class="form-control" autocomplete="off" />
          </div>
      

        <div class="col-lg-2 pl"><p>Reason of Credit Note</p></div>
        <div class="col-lg-2 pl">
          <input type="text" name="REASONOFSR" id="REASONOFSR" autocomplete="off" class="form-control mandatory" maxlength="200"  >
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
                <input type="text" name="CONVFACT" id="CONVFACT" autocomplete="off" onkeyup="MultiCurrency_Conversion('TotalValue')" class="form-control" readonly  maxlength="100" />
            </div>
        </div>   

      <div class="row">

        <div class="col-lg-2 pl"><p>Common Narration</p></div>
        <div class="col-lg-2 pl">
          <input type="text" name="COMMONNRT" id="COMMONNRT" autocomplete="off" class="form-control" maxlength="200"  >
        </div>

        <div class="col-lg-2 pl"><p>Total Value</p></div>
        <div class="col-lg-2 pl">
            <input type="text" name="TotalValue" id="TotalValue" class="form-control"  autocomplete="off" readonly  />
            <input type="hidden" name="CREDITDAYS" id="CREDITDAYS" class="form-control" autocomplete="off"/>
        </div>

        <div id="multi_currency_section" style="display:none">
        <div class="col-lg-2 pl"  ><p id="currency_section"></p></div>
        <div class="col-lg-2 pl">
            <input type="text"  name="TotalValue_Conversion" id="TotalValue_Conversion" class="form-control"  autocomplete="off" readonly  />
        </div>
        </div>

    

      </div>

      <div class="row">
        <div class="col-lg-2 pl"><p>Transaction Type</p></div>
        <div class="col-lg-2 pl">
          <select name="TRANSACTION_TYPE" id="TRANSACTION_TYPE" autocomplete="off" class="form-control" onchange="getTransactionType(this.value)" >
            <option value="CREDIT">CREDIT</option>
            <option value="DEBIT">DEBIT</option>
          </select>
        </div>

        <div class="col-lg-2 pl"><p>Direct</p></div>
        <div class="col-lg-2 pl">
          <input type="checkbox" name="Direct" id="Direct" autocomplete="off" onchange="direct()" value="1"  />
        </div>

      </div>

    </div>

    <div class="container-fluid purchase-order-view">
      <div class="row">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#Material">Material</a></li>
          <li><a data-toggle="tab" href="#udf">UDF</a></li>
          <li><a data-toggle="tab" href="#CT">Calculation Template</a></li>
        </ul>
                            
                            
                            
        <div class="tab-content">

          <div id="Material" class="tab-pane fade in active">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
              <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                <thead id="thead1"  style="position: sticky;top: 0">
                  <tr>
                    <th colspan="{{$AlpsStatus['colspan']}}"></th>
                    <th colspan="3">Invoice Qty</th>
                    <th colspan="2">Credit Note</th>
                    <th colspan="13"></th>
                  </tr>
                         
                  <tr>
                    <th hidden><input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1"></th>
                    <th rowspan="2">SI No</th>
                    <th rowspan="2">Item Code</th>
                    <th rowspan="2">Item Description</th>
                    <th rowspan="2" {{$AlpsStatus['hidden']}} > {{isset($TabSetting->FIELD8) && $TabSetting->FIELD8 !=''?$TabSetting->FIELD8:'Add. Info Part No'}}</th>
                    <th rowspan="2" {{$AlpsStatus['hidden']}} > {{isset($TabSetting->FIELD9) && $TabSetting->FIELD9 !=''?$TabSetting->FIELD9:'Add. Info Customer Part No'}}</th>
                    <th rowspan="2" {{$AlpsStatus['hidden']}} > {{isset($TabSetting->FIELD10) && $TabSetting->FIELD10 !=''?$TabSetting->FIELD10:'Add. Info OEM Part No.'}}</th>
                    <th rowspan="2">Main UOM</th>
                    <th rowspan="2">SI Qty (Main UOM)</th>
                    <th rowspan="2">SI Rate</th>
                    <th rowspan="2" hidden>ALT UOM</th>
                    <th rowspan="2" hidden>Qty (Alt UOM)</th>
                    <th rowspan="2">Main UOM</th>
                    <th rowspan="2">Qty (Main UOM)</th>
                    <th rowspan="2" hidden>ALT UOM</th>
                    <th rowspan="2" hidden>Qty (Alt UOM)</th>
                    <th rowspan="2">Store</th>
                    <th rowspan="2">Credit Note Rate</th>
                    <th rowspan="2">Credit Note Amount</th>
                    <th rowspan="2">GST Flag</th>
                    <th rowspan="2">IGST Rate %</th>
                    <th rowspan="2">IGST Amount</th>
                    <th rowspan="2">CGST Rate %</th>
                    <th rowspan="2">CGST Amount</th>
                    <th rowspan="2">SGST Rate %</th>
                    <th rowspan="2">SGST Amount</th>
                    <th rowspan="2">Total GST Amount</th>
                    <th rowspan="2">Total after GST</th>
                    <th rowspan="2" width="3%">Action</th>
                  </tr>
                <tbody>
                  <tr  class="participantRow">
                    <td hidden><input type="hidden" id="0" > </td>

                    <td hidden><input type="hidden" id="exist_0" name="exist_0" > </td>
                    
                    <td hidden><input type="hidden" name="HIDNO_0" id="HIDNO_0" class="form-control three-digits" maxlength="13"  autocomplete="off"  /></td>
                    <td><input type="text" name="txtSQ_popup_0" id="txtSQ_popup_0" class="form-control"  autocomplete="off"  readonly style="width:100px;" /></td>
                    <td hidden><input type="hidden" name="SQA_0" id="SQA_0" class="form-control" autocomplete="off" /></td>
                    <td hidden><input type="hidden" name="SEQID_REF_0" id="SEQID_REF_0" class="form-control" autocomplete="off" /></td>
                    
                    <td><input type="text" name="popupITEMID_0" id="popupITEMID_0" class="form-control"  autocomplete="off"  readonly style="width:100px;" /></td>
                    <td hidden><input type="hidden" name="ITEMID_REF_0" id="ITEMID_REF_0" class="form-control" autocomplete="off" /></td>
                    <td><input type="text" name="ItemName_0" id="ItemName_0" class="form-control"  autocomplete="off"  readonly style="width:200px;" /></td>
                    
                    <td {{$AlpsStatus['hidden']}} ><input type="text" name="Alpspartno_0" id="Alpspartno_0" class="form-control"  autocomplete="off"  readonly style="width:130px;" /></td>
                    <td {{$AlpsStatus['hidden']}} ><input type="text" name="Custpartno_0" id="Custpartno_0" class="form-control"  autocomplete="off"  readonly style="width:130px;" /></td>
                    <td {{$AlpsStatus['hidden']}} ><input type="text" name="OEMpartno_0"  id="OEMpartno_0"  class="form-control"  autocomplete="off"  readonly style="width:130px;" /></td>

                    <td hidden><input type="hidden" name="SSO_DATE_0" id="SSO_DATE_0" autocomplete="off" class="form-control" readonly style="width:100px;" ></td>
                    <td hidden><input type="hidden" name="Itemspec_0" id="Itemspec_0" class="form-control"  autocomplete="off"  /></td>
                    <td hidden><input type="hidden" name="REMARKS_0" id="REMARKS_0" class="form-control"  autocomplete="off" style="width:200px;"  /></td>
                
                    
                    <td><input type="text" name="SQMUOM_0" id="SQMUOM_0" class="form-control"  autocomplete="off"  readonly style="width:100px;" /></td>
                    <td><input type="text" name="SQMUOMQTY_0" id="SQMUOMQTY_0" class="form-control" maxlength="13"  autocomplete="off"  readonly/></td>
                    <td><input type="text" name="SI_RATE_0" id="SI_RATE_0" class="form-control"  autocomplete="off"  readonly style="width:100px;" /></td>
                    <td hidden><input type="text" name="SQAUOM_0" id="SQAUOM_0" class="form-control"  autocomplete="off"  readonly style="width:100px;" /></td>
                    <td hidden><input type="text" name="SQAUOMQTY_0" id="SQAUOMQTY_0" class="form-control" autocomplete="off"  readonly/></td>

                    
                    <td><input type="text" name="popupMUOM_0" id="popupMUOM_0" class="form-control"  autocomplete="off"  readonly style="width:100px;" /></td>
                    <td hidden><input type="hidden" name="MAIN_UOMID_REF_0" id="MAIN_UOMID_REF_0" class="form-control"  autocomplete="off" style="width:75px;" /></td>
                    <td><input type="text" name="SO_QTY_0" id="SO_QTY_0" class="form-control" maxlength="13" onkeypress="return isNumberDecimalKey(event,this)"  autocomplete="off"  style="width:75px;" /></td>
                    <td hidden><input type="hidden" name="SO_FQTY_0" id="SO_FQTY_0" class="form-control three-digits" maxlength="13"  autocomplete="off"  readonly style="width:75px;" /></td>
                    
                    <td hidden><input type="text" name="popupAUOM_0" id="popupAUOM_0" class="form-control"  autocomplete="off"  readonly style="width:100px;" /></td>
                    <td hidden><input type="hidden" name="ALT_UOMID_REF_0" id="ALT_UOMID_REF_0" class="form-control"  autocomplete="off"  readonly  style="width:75px;"  /></td>
                    <td hidden><input type="text" name="ALT_UOMID_QTY_0" id="ALT_UOMID_QTY_0" class="form-control three-digits"  autocomplete="off"   style="width:75px;" readonly /></td>
                    
                    <td style="text-align:center;" ><a class="btn checkstore" id="store_0" ><i class="fa fa-clone"></i></a></td>
                    <td  hidden><input type="hidden" name="TotalHiddenQty_0" id="TotalHiddenQty_0" ></td>
                    <td  hidden><input type="hidden" name="HiddenRowId_0" id="HiddenRowId_0" ></td>
                                    
                    <td hidden><input type="hidden" name="DISCPER_0" id="DISCPER_0" value="<?php echo 0;?>" class="form-control four-digits" maxlength="8"  autocomplete="off" style="width: 50px;"   style="width:75px;" /></td>
                    <td hidden><input type="hidden" name="DISCOUNT_AMT_0" id="DISCOUNT_AMT_0" value="<?php echo 0;?>" class="form-control two-digits" maxlength="15"  autocomplete="off"   style="width:75px;" /></td>
                    
                    <td><input type="text" name="RATEPUOM_0" id="RATEPUOM_0" class="form-control five-digits blurRate" maxlength="13"  autocomplete="off"  style="width:75px;" /></td>
                    <td><input type="text" name="DISAFTT_AMT_0" id="DISAFTT_AMT_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly style="width:75px;" /></td>
                    
                    <td style="text-align:center;" ><input type="checkbox" value="1" name='flagtype_0' id="flagtype_0" ></td>
                    
                    <td><input type="text" name="IGST_0" id="IGST_0" class="form-control four-digits" maxlength="8"  autocomplete="off"  readonly style="width:75px;" /></td>
                    <td><input type="text" name="IGSTAMT_0" id="IGSTAMT_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly style="width:75px;" /></td>
                    <td><input type="text" name="CGST_0" id="CGST_0" class="form-control four-digits" maxlength="8" autocomplete="off"  readonly style="width:75px;" /></td>
                    <td><input type="text" name="CGSTAMT_0" id="CGSTAMT_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly style="width:75px;" /></td>
                    <td><input type="text" name="SGST_0" id="SGST_0" class="form-control four-digits" maxlength="8" autocomplete="off"  readonly style="width:75px;" /></td>
                    <td><input type="text" name="SGSTAMT_0" id="SGSTAMT_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly style="width:75px;" /></td>
                    <td><input type="text" name="TGST_AMT_0" id="TGST_AMT_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly style="width:75px;" /></td>
                    <td><input type="text" name="TOT_AMT_0" id="TOT_AMT_0" class="form-control two-digits" maxlength="15" autocomplete="off"  readonly style="width:75px;" /></td>
                    <td align="center" ><button class="btn add material" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button> <button class="btn remove dmaterial" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button></td>
                
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
                        <th>UDF Fields<input class="form-control" type="hidden" name="Row_Count3" id ="Row_Count3"></th>
                        <th>Value / Comments</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($objUdfSOData as $uindex=>$uRow)
                      <tr  class="participantRow4">
                          <td><input type="text" name={{"popupUDFSOID_".$uindex}} id={{"popupUDFSOID_".$uindex}} class="form-control" value="{{$uRow->LABEL}}" autocomplete="off"  readonly/></td>
                          <td hidden><input type="hidden" name={{"UDFSOID_REF_".$uindex}} id={{"UDFSOID_REF_".$uindex}} class="form-control" value="{{$uRow->UDFCRVID}}" autocomplete="off"   /></td>
                          <td hidden><input type="hidden" name={{"UDFismandatory_".$uindex}} id={{"UDFismandatory_".$uindex}} value="{{$uRow->ISMANDATORY}}" class="form-control"   autocomplete="off" /></td>
                          <td id={{"udfinputid_".$uindex}} >
                            
                          </td>
                          <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                          
                      </tr>
                      <tr></tr>
                    @endforeach  
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
                                                    <th>Calculation Component<input class="form-control" type="hidden" name="Row_Count4" id ="Row_Count4"></th>
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
                                                    <th hidden>As per Actual</th>
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
                                                    <td style="text-align:center;" hidden><input type="checkbox" class="filter-none" name="calACTUAL_0" id="calACTUAL_0" value=""   ></td>
                                                    <td align="center" ><button class="btn add" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button><button class="btn remove" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                                                </tr>
                                                <tr></tr>
                                            </tbody>
                                    </table>
                                    </div>	
                                </div>
                                                        
      </div>
    </div>
  </div>
</div>
        
</div>

</form>
@endsection
@section('alert')
<!-- store alert popup -->
<div id="StoreModal" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width:40%;z-index:1">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='StoreModalClose' >&times;</button>
      </div>
      <div class="modal-body">
	      <div class="tablename"><p>Store Details</p></div>
        <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
          <table id="StoreTable" class="display nowrap table  table-striped table-bordered" style="width: 100%;" ></table>
        </div>

        <div class="container-fluid filter" style="margin-top:20px;margin-left:345px;">
          <div class="row">
            <div class="col-lg-6 pl"><p>TOTAL</p></div>
            <div class="col-lg-6 pl">
              <input type="text" id="TOTAL_STORE_QTY" value="0" class="form-control" readonly style="width:105px;">
            </div>
          </div>
        </div>

		    <div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<!-- message alert popup -->
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
        </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<!-- bill to alert popup -->
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

<!-- ship to alert popup -->
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
        <td class="ROW2"><input type="text" id="customercodesearch" class="form-control"  autocomplete="off" onkeyup="CustomerCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="customernamesearch" class="form-control"  autocomplete="off" onkeyup="CustomerNameFunction()"></td>
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

<!-- SI details alert popup -->
<div id="SQApopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='SQA_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>SI Details</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="SalesQuotationTable" class="display nowrap table  table-striped table-bordered" >
    <thead>
          <tr id="none-select" class="searchalldata" hidden>
            
            <td> <input type="hidden" name="fieldid" id="hdn_sqid"/>
            <input type="hidden" name="fieldid2" id="hdn_sqid2"/>
            <input type="hidden" name="fieldid2" id="hdn_sqid3"/>
            </td>
          </tr>


    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">SI No</th>
      <th class="ROW3">Date</th>
    </tr>

    </thead>
    <tbody>


    <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="SalesQuotationcodesearch" class="form-control" autocomplete="off" onkeyup="SalesQuotationCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="SalesQuotationnamesearch" class="form-control" autocomplete="off" onkeyup="SalesQuotationNameFunction()"></td>
      </tr>

    </tbody>
    </table>
      <table id="SalesQuotationTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">

        </thead>
        <tbody id="tbody_SQ">     
        
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<!-- item alert popup -->
<div id="ITEMIDpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width:90%" >
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
            </td>
      </tr>
      <!-- <tr class="topnav"><button class="btn topnavbt" id="btnOk"><i class="fa fa-check"></i> OK</button></tr> -->
      <tr>
            <th style="width:8%;" id="all-check" style="width:4%;" >Select</th>
            <th style="width:10%;">Item Code</th>
            <th style="width:10%;">Name</th>
            <th style="width:8%;">Main UOM</th>
            <th style="width:8%;">Main QTY</th>
            <th style="width:8%;">Item Group</th>
            <th style="width:8%;">Item Category</th>
            <th style="width:8%;">Business Unit</th>
            <th style="width:8%;" {{$AlpsStatus['hidden']}} >{{isset($TabSetting->FIELD8) && $TabSetting->FIELD8 !=''?$TabSetting->FIELD8:'Add. Info Part No'}}</th>
            <th style="width:8%;" {{$AlpsStatus['hidden']}} >{{isset($TabSetting->FIELD9) && $TabSetting->FIELD9 !=''?$TabSetting->FIELD9:'Add. Info Customer Part No'}}</th>
            <th style="width:8%;" {{$AlpsStatus['hidden']}} >{{isset($TabSetting->FIELD10) && $TabSetting->FIELD10 !=''?$TabSetting->FIELD10:'Add. Info OEM Part No.'}}</th>
            <th style="width:8%;">Status</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    <td style="width:8%;"><input type="checkbox" class="js-selectall" data-target=".js-selectall1" /></td>
    <td style="width:10%;"><input type="text" id="Itemcodesearch" class="form-control" autocomplete="off" onkeyup="searchItem('Itemcodesearch','1')"></td>
    <td style="width:10%;"><input type="text" id="Itemnamesearch" class="form-control" autocomplete="off" onkeyup="searchItem('Itemnamesearch','2')"></td>
    <td style="width:8%;"><input type="text" id="ItemUOMsearch" class="form-control" autocomplete="off" onkeyup="searchItem('ItemUOMsearch','3')"></td>
    <td style="width:8%;"><input type="text" id="ItemQTYsearch" class="form-control" autocomplete="off" onkeyup="searchItem('ItemQTYsearch','4')"></td>
    <td style="width:8%;"><input type="text" id="ItemGroupsearch" class="form-control" autocomplete="off" onkeyup="searchItem('ItemGroupsearch','5')"></td>
    <td style="width:8%;"><input type="text" id="ItemCategorysearch" class="form-control" autocomplete="off" onkeyup="searchItem('ItemCategorysearch','6')"></td>
    <td style="width:8%;"><input type="text" id="ItemBUsearch" class="form-control" autocomplete="off" onkeyup="searchItem('ItemBUsearch','7')"></td>
    <td style="width:8%;" {{$AlpsStatus['hidden']}} ><input type="text" id="ItemAPNsearch" autocomplete="off" class="form-control" onkeyup="searchItem('ItemAPNsearch','8')"></td>
    <td style="width:8%;" {{$AlpsStatus['hidden']}} ><input type="text" id="ItemCPNsearch" autocomplete="off" class="form-control" onkeyup="searchItem('ItemCPNsearch','9')"></td>
    <td style="width:8%;" {{$AlpsStatus['hidden']}} ><input type="text" id="ItemOEMPNsearch" autocomplete="off" class="form-control" onkeyup="searchItem('ItemOEMPNsearch','10')"></td>
    <td style="width:8%;"><input type="text" id="ItemStatussearch" class="form-control" autocomplete="off" onkeyup="searchItem('ItemStatussearch','11')"></td>
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

<!-- alt uom alert popup -->
<div id="altuompopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='altuom_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Alt UOM</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="altuomTable" class="display nowrap table  table-striped table-bordered" width="100%">
    <thead>
    <tr id="none-select" class="searchalldata" hidden>
            
            <td> <input type="hidden" name="fieldid" id="hdn_altuom"/>
            <input type="hidden" name="fieldid2" id="hdn_altuom2"/>
            <input type="hidden" name="fieldid3" id="hdn_altuom3"/>
            <input type="hidden" name="fieldid4" id="hdn_altuom4"/></td>
          </tr>
    <tr>
            <th>UOM Code</th>
            <th>UOM Desc</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>
    <input type="text" id="altuomcodesearch" onkeyup="altuomCodeFunction()">
    </td>
    <td>
    <input type="text" id="altuomnamesearch" onkeyup="altuomNameFunction()">
    </td>
    </tr>
    </tbody>
    </table>
      <table id="altuomTable2" class="display nowrap table  table-striped table-bordered" width="100%">
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
      <th class="ROW3">Description</th>
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
          <input type="hidden" id="txtCTIDcode_{{ $calindex }}" data-desc="{{ $calRow-> CTCODE }} - {{ $calRow-> CTDESCRIPTION }}"  value="{{ $calRow-> CTID }}"/></td>
          <td class="ROW3" >{{ $calRow-> CTDESCRIPTION }}</td>
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
@endsection

@push('bottom-css')
<style>
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

#StoreTable {
  border-collapse: collapse;
  width: 950px;
  border: 1px solid #ddd;
  font-size: 11px;
}

#StoreTable th {
    text-align: center;
    padding: 5px;
    font-size: 11px;
    
    color: #0f69cc;
    font-weight: 600;
}

#StoreTable td {
    text-align: center;
    padding: 5px;
    font-size: 11px;
   
    font-weight: 600;
}
.qtytext{
    display: block;
    width: 100%;
    height: 24px;
    padding: 6px 6px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
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

  $('#txtCTID_popup').click(function(event){
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
                  $('#Row_Count4').val(data);
                    bindCTIDDetailsEvents();
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                  $('#Row_Count4').val('0');
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
                  var TaxableAmount = $(this).find('[id*="DISAFTT_AMT"]').val();
                  if (!isNaN(TaxableAmount) && TaxableAmount.length !== 0) {
                    netTaxableAmount += parseFloat(TaxableAmount);
                    }                      
                  
                  var GSTAmount = $(this).find('[id*="TGST_AMT"]').val();
                  if (!isNaN(GSTAmount) && GSTAmount.length !== 0) {
                    netGSTAmount += parseFloat(GSTAmount);
                    }
                  
                  var TotalAmount = $(this).find('[id*="TOT_AMT"]').val();
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
            $('#Material').find('.participantRow').each(function()
            {
              tvalue = $(this).find('[id*="TOT_AMT"]').val();
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


            // if($('#drpTDS').val() == 'Yes'){
            //   $('#TDS').find('.participantRow7').each(function(){
            //     if($(this).find('[id*="TOT_TD_AMT"]').val() != '' && $(this).find('[id*="TOT_TD_AMT"]').val() != '.00'){
            //       tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
            //       totalvalue = parseFloat(parseFloat(totalvalue)+parseFloat(tttdsamt21)).toFixed(2);
            //     }
            //   });
            // }


            $('#TotalValue').val(totalvalue);
            MultiCurrency_Conversion('TotalValue'); 
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
                var amount1 = $(this).find('[id*="DISAFTT_AMT"]').val();

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


/*

//GL Account
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

$('#txtgl_popup').click(function(event){
    $("#glidpopup").show();
    event.preventDefault();
});

$("#gl_closePopup").click(function(event){
  $("#glidpopup").hide();
  event.preventDefault();
});

$(".clsglid").click(function(){
  var fieldid = $(this).attr('id');
  var txtval =    $("#txt"+fieldid+"").val();
  var texdesc =   $("#txt"+fieldid+"").data("desc");

  var oldGLID =   $("#GLID_REF").val();
  var MaterialClone = $('#hdnmaterial').val();
  if (txtval != oldGLID){
    $('#Material').html(MaterialClone);
    $('#TotalValue').val('0.00');
    $('#Row_Count1').val('1');
    $('#txtsubgl_popup').val('');
    $('#SLID_REF').val('');

    $("#txtBILLTO").val('');
    $("#BILLTO").val('');
    $("#txtBILLTO1").val('');
    $("#BILLTO1").val('');

    $("#txtSHIPTO").val('');
    $("#SHIPTO").val('');
    $("#txtSHIPTO1").val('');
    $("#SHIPTO1").val(''); 
  }
  
  $('#txtgl_popup').val(texdesc);
  $('#GLID_REF').val(txtval);
  $("#glidpopup").hide();
  $("#glcodesearch").val(''); 
  $("#glnamesearch").val(''); 

  //sub GL
  var customid = txtval;
  if(customid!=''){
    
    $('#tbody_subglacct').html('<tr><td colspan="2">Please wait..</td></tr>');

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url:'{{route("transaction",[$FormId,"getsubledger"])}}',
          type:'POST',
          data:{'id':customid},
          success:function(data) {
              $('#tbody_subglacct').html(data);
              bindSubLedgerEvents();
              showSelectedCheck($("#SLID_REF").val(),"SELECT_SLID_REF");
          },
          error:function(data){
            console.log("Error: Something went wrong.");
            $('#tbody_subglacct').html('');
          },
      });        
  }
  ////sub GL end
  event.preventDefault();
});


function getsubledger(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
      url:'{{route("transaction",[$FormId,"getsubledger"])}}',
      type:'POST',
      data:{'id':''},
      success:function(data) {
          $('#tbody_subglacct').html(data);
          bindSubLedgerEvents();
          showSelectedCheck($("#SLID_REF").val(),"SELECT_SLID_REF");
      },
      error:function(data){
        console.log("Error: Something went wrong.");
        $('#tbody_subglacct').html('');
      },
  });      
}

//Sub GL Account Starts
let sgltid = "#SubGLTable2";
let sgltid2 = "#SubGLTable";
let sglheaders = document.querySelectorAll(sgltid2 + " th");

// Sort the table element when clicking on the table headers
sglheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(sgltid, ".clssubgl", "td:nth-child(" + (i + 1) + ")");
  });
});

function SubGLCodeFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("subglcodesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("SubGLTable2");
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

function SubGLNameFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("subglnamesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("SubGLTable2");
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

$("#txtsubgl_popup").click(function(event){
    getsubledger();
    $("#subglpopup").show();
    event.preventDefault();
  });

$("#subgl_closePopup").on("click",function(event){ 
    $("#subglpopup").hide();
    event.preventDefault();
});

function bindSubLedgerEvents(){
  $('.clssubgl').click(function(){

    var id = $(this).attr('id');
    var txtval =    $("#txt"+id+"").val();
    var texdesc =   $("#txt"+id+"").data("desc");
    var oldSLID =   $("#SLID_REF").val();
    var MaterialClone = $('#hdnmaterial').val();
    $("#txtsubgl_popup").val(texdesc);
    $("#txtsubgl_popup").blur();
    $("#SLID_REF").val(txtval);
    if (txtval != oldSLID)
    {
        $('#Material').html(MaterialClone);
        $('#TotalValue').val('0.00');
        $('#Row_Count1').val('1');
        if ($('#DirectSO').is(":checked") == true){
            $('#Material').find('[id*="txtSQ_popup"]').prop('disabled','true')
            event.preventDefault();
        }
        else
        {
            $('#Material').find('[id*="txtSQ_popup"]').removeAttr('disabled');
            event.preventDefault();
        }
    }
    $("#subglpopup").hide();
    $("#subglcodesearch").val(''); 
    $("#subglnamesearch").val(''); 
  
    var customid = txtval;
      if(customid!=''){
        $("#CREDITDAYS").val('');
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
                $("#CREDITDAYS").val(data);                        
              },
              error:function(data){
                console.log("Error: Something went wrong.");
                $("#CREDITDAYS").val('');                        
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
                showSelectedCheck($("#BILLTO").val(),"SELECT_BILLTO");
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
                showSelectedCheck($("#SHIPTO").val(),"SELECT_SHIPTO");               
              },
              error:function(data){
                console.log("Error: Something went wrong.");
                $("#tbody_ShipTo").html('');
              },
          });  
          $("#tbody_SQ").html('');
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          })
          $.ajax({
              url:'{{route("transaction",[$FormId,"getCodeNo"])}}',
              type:'POST',
              data:{'id':$('#SLID_REF').val(),BILLTO_REF:$('#BILLTO').val(),SHIPTO_REF:$('#SHIPTO').val()},
              success:function(data) {
                $("#tbody_SQ").html(data);
                BindSalesQuotation();
                
              },
              error:function(data){
                console.log("Error: Something went wrong.");
                $("#tbody_SQ").html('');
              },
          });
      }
      event.preventDefault();
  });
}

*/


//CUSTOMER LIST POPUP
let cltid = "#GlCodeTable2";
let cltid2 = "#GlCodeTable";
let clheaders = document.querySelectorAll(cltid2 + " th");

// Sort the table element when clicking on the table headers
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


$('#txtgl_popup').click(function(event){
  var CODE = ''; 
  var NAME = ''; 
  loadCustomer(CODE,NAME);
  $("#customer_popus").show();
  event.preventDefault();
});

$("#customer_closePopup").click(function(event){
  $("#customer_popus").hide();
  $("#customercodesearch").val(''); 
  $("#customernamesearch").val(''); 
  
  event.preventDefault();
});


function bindSubLedgerEvents(){ 
  $(".clssubgl").click(function(){
  var fieldid = $(this).attr('id');
  var txtval =    $("#txt"+fieldid+"").val();
  var texdesc =   $("#txt"+fieldid+"").data("desc");
  var glid_ref =   $("#txt"+fieldid+"").data("desc2");
       
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc");
  var oldSLID =   $("#SLID_REF").val();
  var MaterialClone = $('#hdnmaterial').val();
  var TCClone = $('#hdnTC').val();
  var CTClone = $('#hdnCT').val();

  $('#txtgl_popup').val(texdesc);
  $("#txtgl_popup").blur();
  $('#SLID_REF').val(txtval);
  $('#GLID_REF').val(glid_ref);          

        $('#Material').html(MaterialClone);
        $('#TotalValue').val('0.00');
        MultiCurrency_Conversion('TotalValue'); 
        $('#Row_Count1').val('1');

        resetTab();


        if ($('#DirectSO').is(":checked") == true){
            $('#Material').find('[id*="txtSQ_popup"]').prop('disabled','true')
            event.preventDefault();
        }
        else
        {
            $('#Material').find('[id*="txtSQ_popup"]').removeAttr('disabled');
            event.preventDefault();
        }

            $("#customer_popus").hide();
            $("#customercodesearch").val(''); 
            $("#customernamesearch").val(''); 
         
            var customid = txtval;
              if(customid!=''){
                $("#CREDITDAYS").val('');
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
                        $("#CREDITDAYS").val(data);                        
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#CREDITDAYS").val('');                        
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
                        $("#div_shipto").html(data);
                        
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#txtSHIPTO").hide();
                        $("#txtSHIPTO1").show();
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

                  $("#tbody_SQ").html('');
                  $.ajax({
                      url:'{{route("transaction",[$FormId,"getCodeNo"])}}',
                      type:'POST',
                      data:{'id':$('#SLID_REF').val(),BILLTO_REF:$('#BILLTO').val(),SHIPTO_REF:$('#SHIPTO').val()},
                      success:function(data) {
                        $("#tbody_SQ").html(data);
                        BindSalesQuotation();
                        
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#tbody_SQ").html('');
                      },
                  }); 
              }
        event.preventDefault();
      });
    }

   


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
    $("#BillTopopup").show();
    showSelectedCheck($("#BILLTO").val(),"SELECT_BILLTO");
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
    $("#ShipTopopup").show();
    showSelectedCheck($("#SHIPTO").val(),"SELECT_SHIPTO");       
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
    var texdesc =   $(this).parent().parent().find('[id*="txtshipadd"]').text().trim();
    var taxstate =  $("#txt"+fieldid+"").data("desc");
    var oldShipto =   $("#SHIPTO").val();
    var MaterialClone = $('#hdnmaterial').val();

    if (txtval != oldShipto)
    {
        $('#Material').html(MaterialClone);
        $('#TotalValue').val('0.00');
        MultiCurrency_Conversion('TotalValue'); 
        $('#Row_Count1').val('1');
        if ($('#DirectSO').is(":checked") == true){
              $('#Material').find('[id*="txtSQ_popup"]').prop('disabled','true')
              event.preventDefault();
        }
        else
        {
            $('#Material').find('[id*="txtSQ_popup"]').removeAttr('disabled');
            event.preventDefault();
        }
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

//SI NO details
let sqtid = "#SalesQuotationTable2";
let sqtid2 = "#SalesQuotationTable";
let salesquotationheaders = document.querySelectorAll(sqtid2 + " th");

// Sort the table element when clicking on the table headers
salesquotationheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(sqtid, ".clssqid", "td:nth-child(" + (i + 1) + ")");
  });
});

function SalesQuotationCodeFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("SalesQuotationcodesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("SalesQuotationTable2");
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

function SalesQuotationNameFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("SalesQuotationnamesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("SalesQuotationTable2");
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

$('#Material').on('click','[id*="txtSQ_popup"]',function(event){
  
  var id = $(this).attr('id');
  var id2 = $(this).parent().parent().find('[id*="SQA"]').attr('id');
  var id3 = $(this).parent().parent().find('[id*="SSO_DATE"]').attr('id');

  var fieldid = $(this).parent().parent().find('[id*="SQA"]').attr('id');

  $('#hdn_sqid').val(id);
  $('#hdn_sqid2').val(id2);
  $('#hdn_sqid3').val(id3);

  //var GLID_REF    = $('#GLID_REF').val();
  var SLID_REF    = $('#SLID_REF').val();
  var BILLTO_REF  = $('#BILLTO').val();
  var SHIPTO_REF  = $('#SHIPTO').val();

  // if(GLID_REF ===""){
  //   showAlert('Please select GL.');
  // }
  if(SLID_REF ===""){
    showAlert('Please select Customer.','txtsubgl_popup');
  }
  else{
    $("#SQApopup").show();
    $("#tbody_SQ").html('');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $.ajax({
        url:'{{route("transaction",[$FormId,"getCodeNo"])}}',
        type:'POST',
        data:{'id':$('#SLID_REF').val(),BILLTO_REF:$('#BILLTO').val(),SHIPTO_REF:$('#SHIPTO').val(),fieldid:fieldid},
        success:function(data) {
          $("#tbody_SQ").html(data);
          BindSalesQuotation();
          showSelectedCheck($("#"+fieldid).val(),"SELECT_"+fieldid) 
        },
        error:function(data){
          console.log("Error: Something went wrong.");
          $("#tbody_SQ").html('');
        },
    });
    
    $(this).parent().parent().find('[id*="popupITEMID"]').val('');
    $(this).parent().parent().find('[id*="ITEMID_REF"]').val('');
    $(this).parent().parent().find('[id*="ItemName"]').val('');
    $(this).parent().parent().find('[id*="popupMUOM"]').val('');
    $(this).parent().parent().find('[id*="MAIN_UOMID_REF"]').val('');
    $(this).parent().parent().find('[id*="SI_RATE"]').val('');
    $(this).parent().parent().find('[id*="REMARKS"]').val('');
    $(this).parent().parent().find('[id*="SO_QTY"]').val('');
    $(this).parent().parent().find('[id*="HIDNO"]').val('');
    $(this).parent().parent().find('[id*="RATEPUOM"]').val('');
    $(this).parent().parent().find('[id*="DISCPER"]').val('');
    $(this).parent().parent().find('[id*="DISCOUNT_AMT"]').val('');
    $(this).parent().parent().find('[id*="DISAFTT_AMT"]').val('');
    $(this).parent().parent().find('[id*="IGST"]').val('');
    $(this).parent().parent().find('[id*="IGSTAMT"]').val('');
    $(this).parent().parent().find('[id*="CGST"]').val('');
    $(this).parent().parent().find('[id*="CGSTAMT"]').val('');
    $(this).parent().parent().find('[id*="SGST"]').val('');
    $(this).parent().parent().find('[id*="SGSTAMT"]').val('');
    $(this).parent().parent().find('[id*="TGST_AMT"]').val('');
    $(this).parent().parent().find('[id*="TOT_AMT"]').val('');

    $(this).parent().parent().find('[id*="SQMUOM"]').val('');
    $(this).parent().parent().find('[id*="SQMUOMQTY"]').val('');
    $(this).parent().parent().find('[id*="SQAUOM"]').val('');
    $(this).parent().parent().find('[id*="SQAUOMQTY"]').val('');
    $(this).parent().parent().find('[id*="popupAUOM"]').val('');
    $(this).parent().parent().find('[id*="ALT_UOMID_QTY"]').val('');
    $(this).parent().parent().find('[id*="ALT_UOMID_REF"]').val('');
    $(this).parent().parent().find('[id*="SO_FQTY"]').val('');
    $(this).parent().parent().find('[id*="flagtype"]').prop("checked", false);

    $(this).parent().parent().find('[id*="TotalHiddenQty"]').val('');
    $(this).parent().parent().find('[id*="HiddenRowId"]').val('');
    

  }

});

$("#SQA_closePopup").click(function(event){
  $("#SQApopup").hide();
});

function BindSalesQuotation(){
  $(".clssqid").click(function(){
    var fieldid = $(this).attr('id');
    var txtval =    $("#txt"+fieldid+"").val();
    var texdesc =   $("#txt"+fieldid+"").data("desc");
    var texdescdate =   $("#txt"+fieldid+"").data("descdate");
    
    var txtid= $('#hdn_sqid').val();
    var txt_id2= $('#hdn_sqid2').val();
    var txt_id3= $('#hdn_sqid3').val();

    $('#'+txtid).val(texdesc);
    $('#'+txt_id2).val(txtval);
    $('#'+txt_id3).val(texdescdate);
    $("#SQApopup").hide();
    
    $("#SalesQuotationcodesearch").val(''); 
    $("#SalesQuotationnamesearch").val(''); 
    SalesQuotationCodeFunction();
    event.preventDefault();
  });
}


// START ITEM CODE
let itemtid         = "#ItemIDTable2";
let itemtid2        = "#ItemIDTable";
let itemtidheaders  = document.querySelectorAll(itemtid2 + " th");

itemtidheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(itemtid, ".clsitemid", "td:nth-child(" + (i + 1) + ")");
  });
});

function searchItem(searchid,indexno){
  var input, filter, table, tr, td, i, txtValue;
  input   = document.getElementById(searchid);
  filter  = input.value.toUpperCase();

  if(filter.length == 0 && $("#Direct").prop("checked")==true){

    var CODE  = ''; 
    var NAME  = ''; 
    var MUOM  = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem('',CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 

  }
  else if(filter.length >= 3 && $("#Direct").prop("checked")==true ){

    var CODE  = indexno =='1'?filter:''; 
    var NAME  = indexno =='2'?filter:''; 
    var MUOM  = indexno =='3'?filter:''; 
    var GROUP = indexno =='5'?filter:''; 
    var CTGRY = indexno =='6'?filter:''; 
    var BUNIT = indexno =='7'?filter:''; 
    var APART = indexno =='8'?filter:''; 
    var CPART = indexno =='9'?filter:''; 
    var OPART = indexno =='10'?filter:''; 
    loadItem('',CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 

  }
  else{
    table = document.getElementById("ItemIDTable2");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[indexno];
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

function loadItem(ID,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART){

  var taxstate  = $.trim($('#Tax_State').val());

  $("#tbody_ItemID").html('');
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $.ajax({
    url:'{{route("transaction",[$FormId,"getItemList"])}}',
    type:'POST',
    data:{'taxstate':taxstate,'id':ID,'CODE':CODE,'NAME':NAME,'MUOM':MUOM,'GROUP':GROUP,'CTGRY':CTGRY,'BUNIT':BUNIT,'APART':APART,'CPART':CPART,'OPART':OPART},
    success:function(data) {
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


$('#Material').on('click','[id*="popupITEMID"]',function(event){

   
  var SalesQuotationID  = $(this).parent().parent().find('[id*="SQA"]').val();

  /* 
  var taxstate          = $.trim($('#Tax_State').val());
  
  $("#tbody_ItemID").html('');
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  $.ajax({
    url:'{{route("transaction",[$FormId,"getItemList"])}}',
    type:'POST',
    data:{'id':SalesQuotationID, 'taxstate':taxstate},
    success:function(data) {
      $("#tbody_ItemID").html(data);   
      bindItemEvents();                     
    },
    error:function(data){
      console.log("Error: Something went wrong.");
      $("#tbody_ItemID").html('');                        
    },
  }); 

  */

  if($("#SLID_REF").val() ===""){
    showAlert('Please select Customer.');
  }
  else if($("#Direct").prop("checked")==false && SalesQuotationID ===""){
    showAlert('Please select Sales Invoice in Material Tab.');
  }
  else{
    var ID    = SalesQuotationID; 
    var CODE  = ''; 
    var NAME  = ''; 
    var MUOM  = ''; 
    var GROUP = ''; 
    var CTGRY = ''; 
    var BUNIT = ''; 
    var APART = ''; 
    var CPART = ''; 
    var OPART = ''; 
    loadItem(ID,CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
    $("#ITEMIDpopup").show();
  }

  var id = $(this).attr('id');
  var id2 = $(this).parent().parent().find('[id*="ITEMID_REF"]').attr('id');
  var id3 = $(this).parent().parent().find('[id*="ItemName"]').attr('id');
  var id4 = $(this).parent().parent().find('[id*="Itemspec"]').attr('id');
  var id5 = $(this).parent().parent().find('[id*="SQMUOM"]').attr('id');
  var id6 = $(this).parent().parent().find('[id*="SQMUOMQTY"]').attr('id');
  var id66 = $(this).parent().parent().find('[id*="SI_RATE"]').attr('id');
  var id7 = $(this).parent().parent().find('[id*="SQAUOM"]').attr('id');
  var id8 = $(this).parent().parent().find('[id*="SQAUOMQTY"]').attr('id');
  var id9 = $(this).parent().parent().find('[id*="popupMUOM"]').attr('id');
  var id10 = $(this).parent().parent().find('[id*="MAIN_UOMID_REF"]').attr('id');
  var id11 = $(this).parent().parent().find('[id*="SO_QTY"]').attr('id');
  var id12 = $(this).parent().parent().find('[id*="popupAUOM"]').attr('id');
  var id13 = $(this).parent().parent().find('[id*="ALT_UOMID_REF"]').attr('id');
  var id14 = $(this).parent().parent().find('[id*="ALT_UOMID_QTY"]').attr('id');
  var id15 = $(this).parent().parent().find('[id*="RATEPUOM"]').attr('id');
  var id16 = $(this).parent().parent().find('[id*="SO_FQTY"]').attr('id');

        $('#hdn_ItemID').val(id);
        $('#hdn_ItemID2').val(id2);
        $('#hdn_ItemID3').val(id3);
        $('#hdn_ItemID4').val(id4);
        $('#hdn_ItemID5').val(id5);
        $('#hdn_ItemID6').val(id6);
        $('#hdn_ItemID66').val(id66);
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
        $('#hdn_ItemID17').val(SalesQuotationID);
        var r_count = 0;
        var SalesEnq = [];
        $('#example2').find('.participantRow').each(function(){
          if($(this).find('[id*="ITEMID_REF"]').val() != '')
          {
            SalesEnq.push($(this).find('[id*="SQA"]').val()+'-'+$(this).find('[id*="ITEMID_REF"]').val());
            r_count = parseInt(r_count)+1;
            $('#hdn_ItemID21').val(r_count);
          }
        });
        $('#hdn_ItemID18').val(SalesEnq.join(', '));
        var ItemID = [];
        $('#example2').find('.participantRow').each(function(){
          if($(this).find('[id*="ITEMID_REF"]').val() != '')
          {
            ItemID.push($(this).find('[id*="ITEMID_REF"]').val());
          }
        });
        $('#hdn_ItemID19').val(ItemID.join(', '));
        var EnquiryID = [];
        $('#example2').find('.participantRow').each(function(){
          if($(this).find('[id*="SEQID_REF"]').val() != '')
          {
            EnquiryID.push($(this).find('[id*="SEQID_REF"]').val());
          }
        });
        $('#hdn_ItemID20').val(EnquiryID.join(', '));
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
          var texdesc =  $("#txt"+fieldid+"").data("desc");
          var fieldid2 = $(this).find('[id*="itemname"]').attr('id');
          var txtname =  $("#txt"+fieldid2+"").val();
          var txtspec =  $("#txt"+fieldid2+"").data("desc");
          var fieldid3 = $(this).find('[id*="itemuom"]').attr('id');
          var txtmuomid =  $("#txt"+fieldid3+"").val();
          var txtauom =  $("#txt"+fieldid3+"").data("desc");
          var txtmuom =  $(this).find('[id*="itemuom"]').text().trim();
          var fieldid4 = $(this).find('[id*="uomqty"]').attr('id');
          var txtauomid =  $("#txt"+fieldid4+"").val();
          var txtauomqty =  $("#txt"+fieldid4+"").data("desc");
          var txtmuomqty =  $(this).find('[id*="uomqty"]').text().trim();
          var fieldid5 = $(this).find('[id*="irate"]').attr('id');
          var txtruom =  $("#txt"+fieldid5+"").val();
          var txtmqtyf = $("#txt"+fieldid5+"").data("desc");
          var fieldid6 = $(this).find('[id*="itax"]').attr('id');
          var txttax2 =  $("#txt"+fieldid6+"").val();
          var txttax1 = $("#txt"+fieldid6+"").data("desc");
          var fieldid7 = $(this).find('[id*="ise"]').attr('id');
          var txtenqno = $("#txt"+fieldid7+"").val();
          var txtenqid = $("#txt"+fieldid7+"").data("desc");
          var rcount1 = parseInt($(this).closest('table').find('.clsitemid').length);
          var rcount2 = $('#hdn_ItemID21').val();
          var r_count2 = 0;

          var desc1 =  $("#txt"+fieldid+"").data("desc1");
          var desc2  =  $("#txt"+fieldid+"").data("desc2");
          var desc3 =  $("#txt"+fieldid+"").data("desc3");
          var desc4 =  $("#txt"+fieldid+"").data("desc4");
          var desc5 =  $("#txt"+fieldid+"").data("desc5");

          var apartno =   $("#txt"+fieldid+"").data("desc22");
          var cpartno =   $("#txt"+fieldid+"").data("desc23");
          var opartno =   $("#txt"+fieldid+"").data("desc24");

          var uniquerowid = $(this).find('[id*="uniquerowid"]').attr('id');
          var desc6       =  $("#"+uniquerowid).data("desc6");

          if(txtenqno == undefined)
          {
            txtenqno = '';
          }
          if(txtenqid == undefined)
          {
            txtenqid = '';
          }
          var totalvalue = 0.00;
        var txttaxamt1 = 0.00;
        var txttaxamt2 = 0.00;
        var txttottaxamt = 0.00;
        var txttotamtatax =0.00;
        
        txtruom = parseFloat(txtruom).toFixed(5); 
        //txtauomqty = (parseFloat(txtmuomqty)/parseFloat(txtmqtyf))*parseFloat(txtauomqty);
        txtauomqty = (parseFloat(txtmuomqty))*parseFloat(txtauomqty);
        
        var txtamt = parseFloat((parseFloat(txtmuomqty)*parseFloat(txtruom))).toFixed(2);
        if(desc3 == undefined || desc3 == '')
          {
              desc3 = 0.0000;
          }
          else
          {
            
            txtamt = parseFloat(parseFloat(txtamt) - parseFloat((parseFloat(txtamt)*parseFloat(desc3))/100)).toFixed(2)
          }
          if(desc4 == undefined || desc4 == '')
          {
              desc4 = 0.00;
          }
          else
          {
           
            txtamt = parseFloat(parseFloat(txtamt) - parseFloat(desc4)).toFixed(2)
          }
        if(txttax1 == undefined || txttax1 == '')
          {
            txttax1 = 0.0000;
             txttaxamt1 = 0;
          }
          else
          {
             txttaxamt1 = parseFloat((parseFloat(txtamt)*parseFloat(txttax1))/100).toFixed(2);
          }
          if(txttax2 == undefined || txttax2 == '')
          {
            txttax2 = 0.0000;
             txttaxamt2 = 0;
          }
          else
          {
             txttaxamt2 = parseFloat((parseFloat(txtamt)*parseFloat(txttax2))/100).toFixed(2);
          }
        var txttottaxamt = parseFloat((parseFloat(txttaxamt1)+parseFloat(txttaxamt2))).toFixed(2);
        var txttotamtatax = parseFloat((parseFloat(txtamt)+parseFloat(txttottaxamt))).toFixed(2);
        // var intRegex = /^\d+$/;
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
        var SalesEnq2 = [];
        $('#example2').find('.participantRow').each(function(){
          if($(this).find('[id*="ITEMID_REF"]').val() != ''){

            var seitem  = $(this).find('[id*="exist"]').val();

            SalesEnq2.push(seitem);
            r_count2 = parseInt(r_count2) + 1;
          }
        });


  
        var salesenquiry =  $('#hdn_ItemID18').val();
        var itemids =  $('#hdn_ItemID19').val();
        var enquiryids =  $('#hdn_ItemID20').val();
    
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
                    $('#hdn_ItemID66').val('');
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
                    $('.js-selectall').prop("checked", false);
                    return false;
              }
              var txtenqitem = desc5;

              if(SalesEnq2.indexOf(desc6) != -1){
              
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
                    $('#hdn_ItemID66').val('');
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
                    $('.js-selectall').prop("checked", false);
                    return false;
              }

                  if($('#hdn_ItemID').val() == "" && txtval != '')
                  {
                    var txtid= $('#hdn_ItemID').val();
                    var txt_id2= $('#hdn_ItemID2').val();
                    var txt_id3= $('#hdn_ItemID3').val();
                    var txt_id4= $('#hdn_ItemID4').val();
                    var txt_id5= $('#hdn_ItemID5').val();
                    var txt_id6= $('#hdn_ItemID6').val();
                    var txt_id66= $('#hdn_ItemID66').val();
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
                        $clone.find('[id*="popupITEMID"]').val(texdesc);
                        $clone.find('[id*="ITEMID_REF"]').val(txtval);
                        $clone.find('[id*="SEQID_REF"]').val(txtenqid);
                        $clone.find('[id*="ItemName"]').val(txtname);
                        
                        $clone.find('[id*="Alpspartno"]').val(apartno);
                        $clone.find('[id*="Custpartno"]').val(cpartno);
                        $clone.find('[id*="OEMpartno"]').val(opartno);

                        $clone.find('[id*="Itemspec"]').val(txtspec);
                        $clone.find('[id*="SQMUOM"]').val(txtmuom);
                        $clone.find('[id*="SQMUOMQTY"]').val(txtmuomqty);
                        $clone.find('[id*="SI_RATE"]').val(txtruom);
                        $clone.find('[id*="SQAUOM"]').val(txtauom);
                        $clone.find('[id*="SQAUOMQTY"]').val(txtauomqty);
                        $clone.find('[id*="popupMUOM"]').val(txtmuom);
                        $clone.find('[id*="MAIN_UOMID_REF"]').val(txtmuomid);

                        
                        $clone.find('[id*="SO_QTY"]').val(txtmuomqty);
                        $clone.find('[id*="SO_FQTY"]').val(txtmuomqty);
                        $clone.find('[id*="popupAUOM"]').val(txtauom);
                        $clone.find('[id*="ALT_UOMID_REF"]').val(txtauomid);
                        $clone.find('[id*="ALT_UOMID_QTY"]').val(txtauomqty);
                        $clone.find('[id*="RATEPUOM"]').val(txtruom);
                        $clone.find('[id*="DISAFTT_AMT"]').val(txtamt);
                        $clone.find('[id*="TOT_AMT"]').val(txttotamtatax);
                        $clone.find('[id*="TGST_AMT"]').val(txttottaxamt);

                        $clone.find('[id*="HIDNO"]').val(desc1);
                        $clone.find('[id*="DISCPER"]').val(desc3);
                        $clone.find('[id*="DISCOUNT_AMT"]').val(desc4);
                        $clone.find('[id*="exist"]').val(desc6);

                        $clone.find('[id*="TotalHiddenQty"]').val('');
                        $clone.find('[id*="HiddenRowId"]').val('');

                        if($.trim($('#Tax_State').val()) == 'OutofState')
                        {
                          $clone.find('[id*="IGST"]').val(txttax1);
                          $clone.find('[id*="IGSTAMT"]').val(txttaxamt1);
                          $clone.find('[id*="SGST"]').prop('disabled',true); 
                          $clone.find('[id*="CGST"]').prop('disabled',true); 
                          $clone.find('[id*="SGSTAMT"]').prop('disabled',true); 
                          $clone.find('[id*="CGSTAMT"]').prop('disabled',true); 
                        }
                        else
                        {
                          $clone.find('[id*="CGST"]').val(txttax1);
                          $clone.find('[id*="IGST"]').prop('disabled',true); 
                          $clone.find('[id*="SGST"]').val(txttax2);
                          $clone.find('[id*="CGSTAMT"]').val(txttaxamt1);
                          $clone.find('[id*="SGSTAMT"]').val(txttaxamt2);
                          $clone.find('[id*="IGSTAMT"]').prop('disabled',true); 
                        }
                        
                        $tr.closest('table').append($clone);   
                        var rowCount = $('#Row_Count1').val();
                        rowCount = parseInt(rowCount)+1;
                        $('#Row_Count1').val(rowCount);
                        var tvalue = parseFloat(txttotamtatax).toFixed(2);
                        totalvalue = $('#TotalValue').val();
                        totalvalue =  parseFloat(totalvalue) + parseFloat(tvalue);
                        totalvalue = parseFloat(totalvalue).toFixed(2);
                        $('#TotalValue').val(totalvalue);
                        MultiCurrency_Conversion('TotalValue'); 
                        
                      if($clone.find('[id*="txtSQ_popup"]').val() == '')
                      {
                        $clone.find('[id*="SQMUOM"]').val('');
                        $clone.find('[id*="SQMUOMQTY"]').val('');
                        $clone.find('[id*="SQAUOM"]').val('');
                        $clone.find('[id*="SQAUOMQTY"]').val('');
                      }

                      if((parseFloat($clone.find('[id*="IGSTAMT"]').val()) > 0) || (parseFloat($clone.find('[id*="CGSTAMT"]').val()) > 0) || (parseFloat($clone.find('[id*="SGSTAMT"]').val()) > 0)){
                        $clone.find('[id*="flagtype"]').prop('checked',true); 
                      }

                      $(".blurRate").blur();

                      $("#ITEMIDpopup").hide();
                      $('.js-selectall').prop("checked", false);
      
                  

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
                      var txt_id66= $('#hdn_ItemID66').val();
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
                      $('#'+txtid).val(texdesc);
                      $('#'+txt_id2).val(txtval);
                      $('#'+txt_id3).val(txtname);
                      $('#'+txt_id4).val(txtspec);
                      $('#'+txt_id5).val(txtmuom);
                      $('#'+txt_id6).val(txtmuomqty);
                      $('#'+txt_id66).val(txtruom);
                      $('#'+txt_id7).val(txtauom);
                      $('#'+txt_id8).val(txtauomqty);
                      $('#'+txt_id9).val(txtmuom);
                      $('#'+txt_id10).val(txtmuomid);
                      $('#'+txt_id11).val(txtmuomqty);
                      $('#'+txt_id12).val(txtauom);
                      $('#'+txt_id13).val(txtauomid);
                      $('#'+txt_id14).val(txtauomqty);
                      $('#'+txt_id15).val(txtruom);
                      $('#'+txt_id16).val(txtmuomqty);

                     

                      $('#'+txtid).parent().parent().find('[id*="SEQID_REF"]').val(txtenqid);
                      $('#'+txtid).parent().parent().find('[id*="DISAFTT_AMT"]').val(txtamt);
                      $('#'+txtid).parent().parent().find('[id*="TOT_AMT"]').val(txttotamtatax);
                      $('#'+txtid).parent().parent().find('[id*="TGST_AMT"]').val(txttottaxamt);

                      $('#'+txtid).parent().parent().find('[id*="HIDNO"]').val(desc1);
                      $('#'+txtid).parent().parent().find('[id*="DISCPER"]').val(desc3);
                      $('#'+txtid).parent().parent().find('[id*="DISCOUNT_AMT"]').val(desc4);
                      $('#'+txtid).parent().parent().find('[id*="exist"]').val(desc6);

                      $('#'+txtid).parent().parent().find('[id*="TotalHiddenQty"]').val('');
                      $('#'+txtid).parent().parent().find('[id*="HiddenRowId"]').val('');

                      $('#'+txtid).parent().parent().find('[id*="Alpspartno"]').val(apartno);
                      $('#'+txtid).parent().parent().find('[id*="Custpartno"]').val(cpartno);
                      $('#'+txtid).parent().parent().find('[id*="OEMpartno"]').val(opartno);

                      if($.trim($('#Tax_State').val()) == 'OutofState')
                        {
                          $('#'+txtid).parent().parent().find('[id*="IGST"]').val(txttax1);
                          $('#'+txtid).parent().parent().find('[id*="IGSTAMT"]').val(txttaxamt1);
                          $('#'+txtid).parent().parent().find('[id*="SGST"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="CGST"]').prop('disabled',true);
                          $('#'+txtid).parent().parent().find('[id*="SGSTAMT"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="CGSTAMT"]').prop('disabled',true); 
                        }
                        else
                        {
                          $('#'+txtid).parent().parent().find('[id*="CGST"]').val(txttax1);
                          $('#'+txtid).parent().parent().find('[id*="IGST"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="IGSTAMT"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="SGST"]').val(txttax2);
                          $('#'+txtid).parent().parent().find('[id*="SGSTAMT"]').val(txttaxamt2);
                          $('#'+txtid).parent().parent().find('[id*="CGSTAMT"]').val(txttaxamt1);
                        }
                        var tvalue = parseFloat(txttotamtatax).toFixed(2);
                        totalvalue = $('#TotalValue').val();
                        totalvalue =  parseFloat(totalvalue) + parseFloat(tvalue);
                        totalvalue = parseFloat(totalvalue).toFixed(2);
                        $('#TotalValue').val(totalvalue);
                        MultiCurrency_Conversion('TotalValue'); 
                        if($('#'+txtid).parent().parent().find('[id*="txtSQ_popup"]').val() == '')
                        {
                          $('#'+txtid).parent().parent().find('[id*="SQMUOM"]').val('');
                          $('#'+txtid).parent().parent().find('[id*="SQMUOMQTY"]').val('');
                          $('#'+txtid).parent().parent().find('[id*="SQAUOM"]').val('');
                          $('#'+txtid).parent().parent().find('[id*="SQAUOMQTY"]').val('');
                        }

                      // $("#ITEMIDpopup").hide();
                      $('#hdn_ItemID').val('');
                      $('#hdn_ItemID2').val('');
                      $('#hdn_ItemID3').val('');
                      $('#hdn_ItemID4').val('');
                      $('#hdn_ItemID5').val('');
                      $('#hdn_ItemID6').val('');
                      $('#hdn_ItemID66').val('');
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

                      if((parseFloat($('#'+txtid).parent().parent().find('[id*="IGSTAMT"]').val()) > 0) || (parseFloat($('#'+txtid).parent().parent().find('[id*="CGSTAMT"]').val()) > 0) || (parseFloat($('#'+txtid).parent().parent().find('[id*="SGSTAMT"]').val()) > 0)){
                        $('#'+txtid).parent().parent().find('[id*="flagtype"]').prop('checked',true); 
                      }

                      $(".blurRate").blur();

                      $("#ITEMIDpopup").hide();
                      $('.js-selectall').prop("checked", false);

                      event.preventDefault();
                  }
                  
            }
            else if($(this).is(":checked") == false) 
            {
              var id = desc6;
              var enqid = txtenqid;
              var sqno = txtenqno;
              var r_count = $('#Row_Count1').val();
              $('#example2').find('.participantRow').each(function()
              {

                var seitem  = $(this).find('[id*="exist"]').val();

                var enquiryid = $(this).find('[id*="SEQID_REF"]').val();
                var quotationno = $(this).find('[id*="txtSQ_popup"]').val();

                // if(id == seitem)
                // {
                //     var rowCount = $('#Row_Count1').val();
                //     if (rowCount > 1) {
                //       var totalvalue = $('#TotalValue').val();
                //       totalvalue = parseFloat(totalvalue - $(this).closest('.participantRow').find('[id*="TOT_AMT_"]').val()).toFixed(2);
                //       $('#TotalValue').val(totalvalue);
                //       $(this).closest('.participantRow').remove(); 
                //       rowCount = parseInt(rowCount)-1;
                //     $('#Row_Count1').val(rowCount);
                //     }
                //     else 
                //     {
                //       $(document).find('.dmaterial').prop('disabled', true);  
                //       $("#ITEMIDpopup").hide();
                //       $("#YesBtn").hide();
                //       $("#NoBtn").hide();
                //       $("#OkBtn").hide();
                //       $("#OkBtn1").show();
                //       $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
                //       $("#alert").modal('show');
                //       $("#OkBtn1").focus();
                //       highlighFocusBtn('activeOk1');
                //       return false;

                //     }
                //       event.preventDefault(); 
                // }

                if(id == seitem){
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn").hide();
                  $("#OkBtn1").show();
                  $("#AlertMessage").text('Item already exists.');
                  $("#alert").modal('show');
                  $("#OkBtn1").focus();
                  highlighFocusBtn('activeOk1');

                  event.preventDefault(); 
              }


              });
              event.preventDefault();
            }
          $("#Itemcodesearch").val(''); 
          $("#Itemnamesearch").val(''); 
          $("#ItemUOMsearch").val(''); 
          $("#ItemGroupsearch").val(''); 
          $("#ItemCategorysearch").val(''); 
          $("#ItemStatussearch").val(''); 
          $('.remove').removeAttr('disabled'); 
         
          event.preventDefault();
        });
      });

      $('[id*="chkId"]').change(function(){
        var fieldid = $(this).parent().parent().attr('id');
        var txtval =   $("#txt"+fieldid+"").val();
        var texdesc =  $("#txt"+fieldid+"").data("desc");
        var fieldid2 = $(this).parent().parent().children('[id*="itemname"]').attr('id');
        var txtname =  $("#txt"+fieldid2+"").val();
        var txtspec =  $("#txt"+fieldid2+"").data("desc");
        var fieldid3 = $(this).parent().parent().children('[id*="itemuom"]').attr('id');
        var txtmuomid =  $("#txt"+fieldid3+"").val();
        var txtauom =  $("#txt"+fieldid3+"").data("desc");
        var txtmuom =  $(this).parent().parent().children('[id*="itemuom"]').text().trim();
        var fieldid4 = $(this).parent().parent().children('[id*="uomqty"]').attr('id');
        var txtauomid =  $("#txt"+fieldid4+"").val();
        var txtauomqty =  $("#txt"+fieldid4+"").data("desc");
        var txtmuomqty =  $(this).parent().parent().children('[id*="uomqty"]').text().trim();
        var fieldid5 = $(this).parent().parent().children('[id*="irate"]').attr('id');
        var txtruom =  $("#txt"+fieldid5+"").val();
        var txtmqtyf = $("#txt"+fieldid5+"").data("desc");
        var fieldid6 = $(this).parent().parent().children('[id*="itax"]').attr('id');
        var txttax2 =  $("#txt"+fieldid6+"").val();
        var txttax1 = $("#txt"+fieldid6+"").data("desc");
        var fieldid7 = $(this).parent().parent().children('[id*="ise"]').attr('id');
        var txtenqno = $("#txt"+fieldid7+"").val();
        var txtenqid = $("#txt"+fieldid7+"").data("desc");

        var desc1 =  $("#txt"+fieldid+"").data("desc1");
        var desc2  =  $("#txt"+fieldid+"").data("desc2");
        var desc3 =  $("#txt"+fieldid+"").data("desc3");
        var desc4 =  $("#txt"+fieldid+"").data("desc4");
        var desc5 =  $("#txt"+fieldid+"").data("desc5");

        var apartno = $("#txt"+fieldid+"").data("desc22");
        var cpartno = $("#txt"+fieldid+"").data("desc23");
        var opartno = $("#txt"+fieldid+"").data("desc24");

        var uniquerowid = $(this).parent().parent().find('[id*="uniquerowid"]').attr('id');
        var desc6       =  $("#"+uniquerowid).data("desc6");

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
        //txtauomqty = (parseFloat(txtmuomqty)/parseFloat(txtmqtyf))*parseFloat(txtauomqty);
        txtauomqty = (parseFloat(txtmuomqty))*parseFloat(txtauomqty);


        
        var txtamt = parseFloat((parseFloat(txtmuomqty)*parseFloat(txtruom))).toFixed(2);
        if(desc3 == undefined || desc3 == '')
          {
              desc3 = 0.0000;
          }
          else
          {
            
            txtamt = parseFloat(parseFloat(txtamt) - parseFloat((parseFloat(txtamt)*parseFloat(desc3))/100)).toFixed(2)
          }
          if(desc4 == undefined || desc4 == '')
          {
              desc4 = 0.00;
          }
          else
          {
           
            txtamt = parseFloat(parseFloat(txtamt) - parseFloat(desc4)).toFixed(2)
          }
        if(txttax1 == undefined || txttax1 == '')
          {
            txttax1 = 0.0000;
             txttaxamt1 = 0;
          }
          else
          {
             txttaxamt1 = parseFloat((parseFloat(txtamt)*parseFloat(txttax1))/100).toFixed(2);
          }
          if(txttax2 == undefined || txttax2 == '')
          {
            txttax2 = 0.0000;
             txttaxamt2 = 0;
          }
          else
          {
             txttaxamt2 = parseFloat((parseFloat(txtamt)*parseFloat(txttax2))/100).toFixed(2);
          }
        var txttottaxamt = parseFloat((parseFloat(txttaxamt1)+parseFloat(txttaxamt2))).toFixed(2);
        var txttotamtatax = parseFloat((parseFloat(txtamt)+parseFloat(txttottaxamt))).toFixed(2);
        // var intRegex = /^\d+$/;
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
        var SalesEnq2 = [];
        $('#example2').find('.participantRow').each(function(){
          if($(this).find('[id*="ITEMID_REF"]').val() != '')
          {
            var seitem  = $(this).find('[id*="exist"]').val();
           
            SalesEnq2.push(seitem);
          }
        });
        
        var salesenquiry =  $('#hdn_ItemID18').val();
        var itemids =  $('#hdn_ItemID19').val();
        var enquiryids =  $('#hdn_ItemID20').val();
    
            if($(this).is(":checked") == true){
              var txtenqitem = desc5;

              if(SalesEnq2.indexOf(desc6) != -1){
              
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
                    $('#hdn_ItemID66').val('');
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
                    return false;
              }

              
                      if($('#hdn_ItemID').val() == "" && txtval != '')
                      {
                        var txtid= $('#hdn_ItemID').val();
                        var txt_id2= $('#hdn_ItemID2').val();
                        var txt_id3= $('#hdn_ItemID3').val();
                        var txt_id4= $('#hdn_ItemID4').val();
                        var txt_id5= $('#hdn_ItemID5').val();
                        var txt_id6= $('#hdn_ItemID6').val();
                        var txt_id66= $('#hdn_ItemID66').val();
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
                        $clone.find('[id*="popupITEMID"]').val(texdesc);
                        $clone.find('[id*="SEQID_REF"]').val(txtenqid);
                        $clone.find('[id*="ITEMID_REF"]').val(txtval);
                        $clone.find('[id*="ItemName"]').val(txtname);
                        $clone.find('[id*="Itemspec"]').val(txtspec);

                        $clone.find('[id*="Alpspartno"]').val(apartno);
                        $clone.find('[id*="Custpartno"]').val(cpartno);
                        $clone.find('[id*="OEMpartno"]').val(opartno);

                        $clone.find('[id*="SQMUOM"]').val(txtmuom);
                        $clone.find('[id*="SQMUOMQTY"]').val(txtmuomqty);
                        $clone.find('[id*="SI_RATE"]').val(txtruom);
                        $clone.find('[id*="SQAUOM"]').val(txtauom);
                        $clone.find('[id*="SQAUOMQTY"]').val(txtauomqty);
                        $clone.find('[id*="popupMUOM"]').val(txtmuom);
                        $clone.find('[id*="MAIN_UOMID_REF"]').val(txtmuomid);
                        $clone.find('[id*="SO_QTY"]').val(txtmuomqty);
                        $clone.find('[id*="SO_FQTY"]').val(txtmuomqty);
                        $clone.find('[id*="popupAUOM"]').val(txtauom);
                        $clone.find('[id*="ALT_UOMID_REF"]').val(txtauomid);
                        $clone.find('[id*="ALT_UOMID_QTY"]').val(txtauomqty);
                        $clone.find('[id*="RATEPUOM"]').val(txtruom);
                        $clone.find('[id*="DISAFTT_AMT"]').val(txtamt);
                        $clone.find('[id*="TOT_AMT"]').val(txttotamtatax);
                        $clone.find('[id*="TGST_AMT"]').val(txttottaxamt);

                        
                        $clone.find('[id*="HIDNO"]').val(desc1);
                        $clone.find('[id*="DISCPER"]').val(desc3);
                        $clone.find('[id*="DISCOUNT_AMT"]').val(desc4);
                        $clone.find('[id*="exist"]').val(desc6);

                        $clone.find('[id*="TotalHiddenQty"]').val('');
                        $clone.find('[id*="HiddenRowId"]').val('');
                        

                        if($.trim($('#Tax_State').val()) == 'OutofState')
                        {
                          $clone.find('[id*="IGST"]').val(txttax1);
                          $clone.find('[id*="SGST"]').prop('disabled',true); 
                          $clone.find('[id*="CGST"]').prop('disabled',true); 
                          $clone.find('[id*="SGSTAMT"]').prop('disabled',true); 
                          $clone.find('[id*="CGSTAMT"]').prop('disabled',true);
                          $clone.find('[id*="IGSTAMT"]').val(txttaxamt1);
                        }
                        else
                        {
                          $clone.find('[id*="CGST"]').val(txttax1);
                          $clone.find('[id*="IGST"]').prop('disabled',true); 
                          $clone.find('[id*="SGST"]').val(txttax2);
                          $clone.find('[id*="SGSTAMT"]').val(txttaxamt2);; 
                          $clone.find('[id*="CGSTAMT"]').val(txttaxamt1);;
                          $clone.find('[id*="IGSTAMT"]').prop('disabled',true);
                        }
                        $tr.closest('table').append($clone);   
                        var rowCount = $('#Row_Count1').val();
                          rowCount = parseInt(rowCount)+1;
                          $('#Row_Count1').val(rowCount);
                          var tvalue = parseFloat(txttotamtatax).toFixed(2);
                        totalvalue = $('#TotalValue').val();
                        totalvalue =  parseFloat(totalvalue) + parseFloat(tvalue);
                        totalvalue = parseFloat(totalvalue).toFixed(2);
                        $('#TotalValue').val(totalvalue);
                        MultiCurrency_Conversion('TotalValue'); 

                        if($clone.find('[id*="txtSQ_popup"]').val() == '')
                        {
                          $clone.find('[id*="SQMUOM"]').val('');
                          $clone.find('[id*="SQMUOMQTY"]').val('');
                          $clone.find('[id*="SQAUOM"]').val('');
                          $clone.find('[id*="SQAUOMQTY"]').val('');
                        } 

                        if((parseFloat($clone.find('[id*="IGSTAMT"]').val()) > 0) || (parseFloat($clone.find('[id*="CGSTAMT"]').val() > 0)) || (parseFloat($clone.find('[id*="SGSTAMT"]').val()) > 0)){
                          $clone.find('[id*="flagtype"]').prop('checked',true); 
                        }

                        $(".blurRate").blur();

                        $("#ITEMIDpopup").hide();
                        $('.js-selectall').prop("checked", false);

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
                      var txt_id66= $('#hdn_ItemID66').val();
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
                      $('#'+txtid).val(texdesc);
                      $('#'+txt_id2).val(txtval);
                      $('#'+txt_id3).val(txtname);
                      $('#'+txt_id4).val(txtspec);
                      $('#'+txt_id5).val(txtmuom);
                      $('#'+txt_id6).val(txtmuomqty);
                      $('#'+txt_id66).val(txtruom);
                      $('#'+txt_id7).val(txtauom);
                      $('#'+txt_id8).val(txtauomqty);
                      $('#'+txt_id9).val(txtmuom);
                      $('#'+txt_id10).val(txtmuomid);
                      $('#'+txt_id11).val(txtmuomqty);
                      $('#'+txt_id12).val(txtauom);
                      $('#'+txt_id13).val(txtauomid);
                      $('#'+txt_id14).val(txtauomqty);
                      $('#'+txt_id15).val(txtruom);
                      $('#'+txt_id16).val(txtmuomqty);

                      $('#'+txtid).parent().parent().find('[id*="SEQID_REF"]').val(txtenqid);
                      $('#'+txtid).parent().parent().find('[id*="DISAFTT_AMT"]').val(txtamt);
                      $('#'+txtid).parent().parent().find('[id*="TOT_AMT"]').val(txttotamtatax);
                      $('#'+txtid).parent().parent().find('[id*="TGST_AMT"]').val(txttottaxamt);

                      $('#'+txtid).parent().parent().find('[id*="HIDNO"]').val(desc1);
                      $('#'+txtid).parent().parent().find('[id*="DISCPER"]').val(desc3);
                      $('#'+txtid).parent().parent().find('[id*="DISCOUNT_AMT"]').val(desc4);
                      $('#'+txtid).parent().parent().find('[id*="exist"]').val(desc6);

                      $('#'+txtid).parent().parent().find('[id*="TotalHiddenQty"]').val('');
                      $('#'+txtid).parent().parent().find('[id*="HiddenRowId"]').val('');
                      
                      $('#'+txtid).parent().parent().find('[id*="Alpspartno"]').val(apartno);
                      $('#'+txtid).parent().parent().find('[id*="Custpartno"]').val(cpartno);
                      $('#'+txtid).parent().parent().find('[id*="OEMpartno"]').val(opartno);

                     
                      if($.trim($('#Tax_State').val()) == 'OutofState')
                        {
                          $('#'+txtid).parent().parent().find('[id*="IGST"]').val(txttax1);
                          $('#'+txtid).parent().parent().find('[id*="IGSTAMT"]').val(txttaxamt1);
                          $('#'+txtid).parent().parent().find('[id*="SGST"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="CGST"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="CGSTAMT"]').prop('disabled',true);
                          $('#'+txtid).parent().parent().find('[id*="SGSTAMT"]').prop('disabled',true);
                        }
                        else
                        {
                          $('#'+txtid).parent().parent().find('[id*="CGST"]').val(txttax1);
                          $('#'+txtid).parent().parent().find('[id*="IGST"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="IGSTAMT"]').prop('disabled',true); 
                          $('#'+txtid).parent().parent().find('[id*="SGST"]').val(txttax2);
                          $('#'+txtid).parent().parent().find('[id*="CGSTAMT"]').val(txttaxamt1);
                          $('#'+txtid).parent().parent().find('[id*="SGSTAMT"]').val(txttaxamt1);
                        }
                        var tvalue = parseFloat(txttotamtatax).toFixed(2);
                        totalvalue = $('#TotalValue').val();
                        totalvalue =  parseFloat(totalvalue) + parseFloat(tvalue);
                        totalvalue = parseFloat(totalvalue).toFixed(2);
                        $('#TotalValue').val(totalvalue);
                        MultiCurrency_Conversion('TotalValue'); 
                      // $("#ITEMIDpopup").hide();
                      $('#hdn_ItemID').val('');
                      $('#hdn_ItemID2').val('');
                      $('#hdn_ItemID3').val('');
                      $('#hdn_ItemID4').val('');
                      $('#hdn_ItemID5').val('');
                      $('#hdn_ItemID6').val('');
                      $('#hdn_ItemID66').val('');
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
                      if($('#'+txtid).parent().parent().find('[id*="txtSQ_popup"]').val() == '')
                        {
                          $('#'+txtid).parent().parent().find('[id*="SQMUOM"]').val('');
                          $('#'+txtid).parent().parent().find('[id*="SQMUOMQTY"]').val('');
                          $('#'+txtid).parent().parent().find('[id*="SQAUOM"]').val('');
                          $('#'+txtid).parent().parent().find('[id*="SQAUOMQTY"]').val('');
                        }
                      }


                      if((parseFloat($('#'+txtid).parent().parent().find('[id*="IGSTAMT"]').val()) > 0) || (parseFloat($('#'+txtid).parent().parent().find('[id*="CGSTAMT"]').val()) > 0) || (parseFloat($('#'+txtid).parent().parent().find('[id*="SGSTAMT"]').val()) > 0)){
                        $('#'+txtid).parent().parent().find('[id*="flagtype"]').prop('checked',true); 
                      }

                      $(".blurRate").blur();

                      $("#ITEMIDpopup").hide();
                      $('.js-selectall').prop("checked", false);

                      event.preventDefault();
            }
            else if($(this).is(":checked") == false) 
            {
              var id = desc6;
              var enqid = txtenqid;
              var sqno = txtenqno;
              var r_count = $('#Row_Count1').val();
              $('#example2').find('.participantRow').each(function()
              {

                var seitem  = $(this).find('[id*="exist"]').val();
                
                var enquiryid = $(this).find('[id*="SEQID_REF"]').val();
                var quotationno = $(this).find('[id*="txtSQ_popup"]').val();

                // if(id == seitem)
                // {
                //     var rowCount = $('#Row_Count1').val();
                //     if (rowCount > 1) {
                //       var totalvalue = $('#TotalValue').val();
                //       totalvalue = parseFloat(totalvalue - $(this).closest('.participantRow').find('[id*="TOT_AMT_"]').val()).toFixed(2);
                //       $('#TotalValue').val(totalvalue);
                //       $(this).closest('.participantRow').remove(); 
                //       rowCount = parseInt(rowCount)-1;
                //     $('#Row_Count1').val(rowCount);
                //     }
                //     else 
                //     {
                //       $(document).find('.dmaterial').prop('disabled', true);  
                //       $("#ITEMIDpopup").hide();
                //       $("#YesBtn").hide();
                //       $("#NoBtn").hide();
                //       $("#OkBtn").hide();
                //       $("#OkBtn1").show();
                //       $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
                //       $("#alert").modal('show');
                //       $("#OkBtn1").focus();
                //       highlighFocusBtn('activeOk1');
                //       return false;

                //     }
                //       event.preventDefault(); 
                // }

                if(id == seitem){
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn").hide();
                  $("#OkBtn1").show();
                  $("#AlertMessage").text('Item already exists.');
                  $("#alert").modal('show');
                  $("#OkBtn1").focus();
                  highlighFocusBtn('activeOk1');

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
       
        event.preventDefault();
      });
    }


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

function altuomNameFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("altuomnamesearch");
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

      
  $('#Material').on('keydown','[id*="popupAUOM"]',function(event){
        var ItemID = $(this).parent().parent().find('[id*="ITEMID_REF"]').val();
        
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
                      data:{'id':ItemID},
                      success:function(data) {
                        
                        $("#tbody_altuom").html(data);   
                        bindAltUOM();                     
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
        var id = $(this).attr('id');
        var id2 = $(this).parent().parent().find('[id*="ALT_UOMID_REF"]').attr('id');
        var id3 = $(this).parent().parent().find('[id*="SO_QTY"]').attr('id');
        var id4 = $(this).parent().parent().find('[id*="ALT_UOMID_QTY"]').attr('id');
        
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

      $(".clsaltuom").dblclick(function(){
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
        event.preventDefault();
      });
    }


$("#Material").on('click','.add', function() {
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
        $clone.find('[id*="SQA"]').val('');
        $clone.find('[id*="SEQID_REF"]').val('');
        $clone.find('[id*="ITEMID_REF"]').val('');
        $clone.find('[id*="flagtype"]').prop('checked', false);
       
        $clone.find('[id*="TotalHiddenQty"]').val('');
        $clone.find('[id*="HiddenRowId"]').val('');
                      
        

        $tr.closest('table').append($clone);         
        var rowCount1 = $('#Row_Count1').val();
		    rowCount1 = parseInt(rowCount1)+1;
        $('#Row_Count1').val(rowCount1);
        $clone.find('.remove').removeAttr('disabled'); 
        $(".blurRate").blur();  
        event.preventDefault();
    });

    $("#Material").on('click', '.remove', function() {
        var rowCount = $(this).closest('table').find('.participantRow').length;
        if (rowCount > 1) {
        var totalvalue = $('#TotalValue').val();
        totalvalue = parseFloat(totalvalue - $(this).closest('.participantRow').find('[id*="TOT_AMT_"]').val()).toFixed(2);
        $('#TotalValue').val(totalvalue);
        MultiCurrency_Conversion('TotalValue'); 
        $(this).closest('.participantRow').remove();   
        $(".blurRate").blur();   
        } 
        if (rowCount <= 1) { 
              $(".blurRate").blur();
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
    });


    $("#example3").on('click', '.add', function() {
        var $tr = $(this).closest('table');
        var allTrs = $tr.find('.participantRow3').last();
        var lastTr = allTrs[allTrs.length-1];
        var $clone = $(lastTr).clone();
        $clone.find('td').each(function(){
            var id = $(this).attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
                $(this).attr('id', prefix+(+i+1));
            }

        }); 
        $clone.find('td').each(function(){
            var el = $(this).find(':first-child');
            var id = el.attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
                el.attr('id', prefix+(+i+1));
            }
            var name = el.attr('name') || null;
            if(name) {
                var i = name.substr(name.length-1);
                var prefix1 = name.substr(0, (name.length-1));
                el.attr('name', prefix1+(+i+1));
            }
        });
        $clone.find('input:text').val('');
        $clone.find("[id*='tdinputid']").html('');
        $clone.find('[id*="TNCDID_REF"]').val('');
        $clone.find('[id*="TNCismandatory"]').val('');
        $tr.closest('table').append($clone);         
        var rowCount2 = $('#Row_Count2').val();
		    rowCount2 = parseInt(rowCount2)+1;
        $('#Row_Count2').val(rowCount2);
        // $clone.find('.remove').removeAttr('disabled'); 
        
        event.preventDefault();
    });
    $("#example3").on('click', '.remove', function() {
        var rowCount2 = $(this).closest('table').find('.participantRow3').length;
        if (rowCount2 > 1) {
        $(this).closest('.participantRow3').remove();     
        } 
        if (rowCount2 <= 1) { 
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
    });
    $("#example4").on('click', '.add', function() {
        var $tr = $(this).closest('table');
        var allTrs = $tr.find('tbody').last();
        var lastTr = allTrs[allTrs.length-1];
        var $clone = $(lastTr).clone();
        $clone.find('td').each(function(){
            var id = $(this).attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
                $(this).attr('id', prefix+(+i+1));
            }

        }); 

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
        $clone.find("[id*='udfinputid']").html('');
        $clone.find('[id*="UDFSQID_REF"]').val('');
        $clone.find('[id*="UDFismandatory"]').val('');
        $tr.closest('table').append($clone);         
        var rowCount3 = $('#Row_Count3').val();
		    rowCount3 = parseInt(rowCount3)+1;
        $('#Row_Count3').val(rowCount3);
        // $clone.find('.remove').removeAttr('disabled'); 
        
        event.preventDefault();
    });
    $("#example4").on('click', '.remove', function() {
        var rowCount3 = $(this).closest('table').find('.participantRow4').length;
        if (rowCount3 > 1) {
        $(this).closest('.participantRow4').remove();     
        } 
        if (rowCount3 <= 1) { 
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
    });

    $("#example5").on('click', '.add', function() {
        var $tr = $(this).closest('table');
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

        $clone.find('input:text').val('');
        $clone.find('[id*="calGST"]').removeAttr('checked');
        if($clone.find('[id*="calGST"]').is(":checked") == false)
        {
          $clone.find('[id*="calIGST"]').prop('disabled','true');
          $clone.find('[id*="calCGST"]').prop('disabled','true');
          $clone.find('[id*="calSGST"]').prop('disabled','true');
          $clone.find('[id*="AMTIGST"]').prop('disabled','true');
          $clone.find('[id*="AMTCGST"]').prop('disabled','true');
          $clone.find('[id*="AMTSGST"]').prop('disabled','true');
        }
        $clone.find('[id*="TID_REF"]').val('');
        $clone.find('[id*="BASIS"]').val('');
        $clone.find('[id*="SQNO"]').val('');
        $tr.closest('table').append($clone);         
        var rowCount4 = $('#Row_Count4').val();
		    rowCount4 = parseInt(rowCount4)+1;
        $('#Row_Count4').val(rowCount4);
        // $clone.find('.remove').removeAttr('disabled'); 
        
        event.preventDefault();
    });
    $("#example5").on('click', '.remove', function() {
        var rowCount4 = $(this).closest('table').find('.participantRow5').length;
        if (rowCount4 > 1) {
        $(this).closest('.participantRow5').remove();    
        } 
        if (rowCount4 <= 1) {          
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
    });

    $("#example6").on('click', '.add', function() {
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
        $tr.closest('table').append($clone);         
        var rowCount5 = $('#Row_Count5').val();
		    rowCount5 = parseInt(rowCount5)+1;
        $('#Row_Count5').val(rowCount5);
        $clone.find('.remove').removeAttr('disabled'); 
        
        event.preventDefault();
    });
    $("#example6").on('click', '.remove', function() {
        var rowCount5 = $(this).closest('table').find('.participantRow6').length;
        if (rowCount5 > 1) {
        $(this).closest('.participantRow6').remove();     
        } 
        if (rowCount5 <= 1) {          
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
    });

$(document).ready(function(e) {
    var Material = $("#Material").html(); 
    $('#hdnmaterial').val(Material);
    var soudf = <?php echo json_encode($objUdfSOData); ?>;
    var count3 = <?php echo json_encode($objCountUDF); ?>;
    $("#Row_Count1").val(1);
    $("#Row_Count3").val(count3);
    $("#Row_Count5").val(1);
    $('#example4').find('.participantRow4').each(function(){
      var txt_id4 = $(this).find('[id*="udfinputid"]').attr('id');
      var udfid = $(this).find('[id*="UDFSOID_REF"]').val();
      $.each( soudf, function( soukey, souvalue ) {
        if(souvalue.UDFCRVID == udfid)
        {
          var txtvaltype2 =   souvalue.VALUETYPE;
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
          var txtoptscombo2 =   souvalue.DESCRIPTIONS;
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

 
    var d = new Date(); 
    var today = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;
    d.setDate(d.getDate() + 29);
    var todate = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;
    $('#CSV_DT').val(today);
    $('#OVFDT').val(today);
    $('#OVTDT').val(todate);
    $('#CUSTOMERDT').val(today);
    
    
    $('#DirectSO').change(function(){
      if ($(this).is(":checked") == true){
          $('#Material').find('[id*="txtSQ_popup"]').prop('disabled','true')
          event.preventDefault();
      }
      else
      {
          $('#Material').find('[id*="txtSQ_popup"]').removeAttr('disabled');
          event.preventDefault();
      }
    });


    $('#Material').on('focusout',"[id*='ALT_UOMID_QTY']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.000')
      }
      event.preventDefault();
    });

    function bindTotalValue()
    {
      var totalvalue = 0.00;
      var tvalue = 0.00;
      var ctvalue = 0.00;
      var ctgstvalue = 0.00;
      $('#example2').find('.participantRow').each(function()
      {
        tvalue = $(this).find('[id*="TOT_AMT"]').val();
        totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
        totalvalue = parseFloat(totalvalue).toFixed(2);
      });
      if($('#CTID_REF').val() != '')
      {
        $('#example5').find('.participantRow5').each(function()
        {
          ctvalue = $(this).find('[id*="VALUE"]').val();
          ctgstvalue = $(this).find('[id*="TOTGSTAMT"]').val();
          totalvalue = parseFloat(totalvalue) + parseFloat(ctvalue);
          totalvalue = parseFloat(totalvalue) + parseFloat(ctgstvalue);
          totalvalue = parseFloat(totalvalue).toFixed(2);
        });
      }
      $('#TotalValue').val(totalvalue);
      MultiCurrency_Conversion('TotalValue'); 
    }

    $('#Material').on('focusout',"[id*='SO_QTY']",function(){

      var totalvalue  = 0.00;
      var itemid      = $(this).parent().parent().find('[id*="ITEMID_REF"]').val();
      var mqty        = $(this).val();

      var altuomid    = $(this).parent().parent().find('[id*="ALT_UOMID_REF"]').val();
      var txtid       = $(this).parent().parent().find('[id*="ALT_UOMID_QTY"]').attr('id');
      var irate       = $(this).parent().parent().find('[id*="RATEPUOM"]').val();

      $(this).parent().parent().find('[id*="IGSTAMT"]').val('0');
      $(this).parent().parent().find('[id*="CGSTAMT"]').val('0');
      $(this).parent().parent().find('[id*="SGSTAMT"]').val('0');


      if(parseFloat(mqty) > 0){
        var tamt = parseFloat(parseFloat(mqty)*parseFloat(irate)).toFixed(2);
      }
      else{
        var tamt = parseFloat(parseFloat(irate)).toFixed(2);
      }

      
      var dispercnt = $(this).parent().parent().find('[id*="DISCPER"]').val();
      
      var disamt = 0 ;      
      if (dispercnt != '' && dispercnt != '.0000')
      {
          disamt =  parseFloat((parseFloat(tamt)*parseFloat(dispercnt))/100).toFixed(2);
      }
      else if ($(this).parent().parent().find('[id*="DISCOUNT_AMT"]').val() != '' && $(this).parent().parent().find('[id*="DISCOUNT_AMT"]').val() != '0.00')
      {
          disamt = $(this).parent().parent().find('[id*="DISCOUNT_AMT"]').val();
      }


      //alert(tamt);return false;
      //tamt = parseFloat(parseFloat(tamt) - parseFloat(disamt)).toFixed(2);


      var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
      var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
      var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
      var tp1amt = parseFloat((tamt * tp1)/100).toFixed(2);
      var tp2amt = parseFloat((tamt * tp2)/100).toFixed(2);
      var tp3amt = parseFloat((tamt * tp3)/100).toFixed(2);
      var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2); 
      var totamt = parseFloat(parseFloat(tamt) + parseFloat(taxamt)).toFixed(2);

      if(altuomid!=''){
            
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
                $("#"+txtid).val(data);                        
              },
              error:function(data){
                console.log("Error: Something went wrong.");
                $("#"+txtid).val('');                        
              },
          }); 
              
      }

     

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

      

      $(this).parent().parent().find('[id*="DISAFTT_AMT"]').val(tamt);
      $(this).parent().parent().find('[id*="TOT_AMT"]').val(totamt);
      $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
      $(this).parent().parent().find('[id*="IGSTAMT"]').val(tp1amt);
      $(this).parent().parent().find('[id*="CGSTAMT"]').val(tp2amt);
      $(this).parent().parent().find('[id*="SGSTAMT"]').val(tp3amt);



      bindTotalValue();
      if($('#CTID_REF').val()!='')
      {
      bindGSTCalTemplate();
      }
      bindTotalValue();
      event.preventDefault();
    });
    

    $('#Material').on('focusout',"[id*='RATEPUOM']",function()
    {
        var mqty = $(this).parent().parent().find('[id*="SO_QTY"]').val();
        var irate = $(this).val();
        var taxamt = $(this).parent().parent().find('[id*="TGST_AMT"]').val();
                
        if(parseFloat(mqty) > 0){
          var tamt = parseFloat(parseFloat(mqty)*parseFloat(irate)).toFixed(2);
        }
        else{
          var tamt = parseFloat(parseFloat(irate)).toFixed(2);
        }


        //var dispercnt = $(this).parent().parent().find('[id*="DISCPER"]').val();
        var dispercnt = 0;
        var disamt = 0 ;      
        if (dispercnt != '' && dispercnt != '.0000')
        {
           disamt =  parseFloat((parseFloat(tamt)*parseFloat(dispercnt))/100).toFixed(2);
        }
        else if ($(this).parent().parent().find('[id*="DISCOUNT_AMT"]').val() != '' && $(this).parent().parent().find('[id*="DISCOUNT_AMT"]').val() != '0.00')
        {
           //disamt = $(this).parent().parent().find('[id*="DISCOUNT_AMT"]').val();
           disamt = 0;
        }

        tamt = parseFloat(parseFloat(tamt) - parseFloat(disamt)).toFixed(2);        
        var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
        var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
        var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
        $(this).parent().parent().find('[id*="IGSTAMT"]').val('0');
        $(this).parent().parent().find('[id*="CGSTAMT"]').val('0');
        $(this).parent().parent().find('[id*="SGSTAMT"]').val('0');
        var tp1amt = parseFloat((tamt * tp1)/100).toFixed(2);
        var tp2amt = parseFloat((tamt * tp2)/100).toFixed(2);
        var tp3amt = parseFloat((tamt * tp3)/100).toFixed(2);
        var taxamt = parseFloat(parseFloat(tp1amt) + parseFloat(tp2amt) + parseFloat(tp3amt)).toFixed(2); 
        var totamt = parseFloat(parseFloat(tamt) + parseFloat(taxamt)).toFixed(2);
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00000')
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
      $(this).parent().parent().find('[id*="DISAFTT_AMT"]').val(tamt);
      $(this).parent().parent().find('[id*="TOT_AMT"]').val(totamt);
      $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
      $(this).parent().parent().find('[id*="IGSTAMT"]').val(tp1amt);
      $(this).parent().parent().find('[id*="CGSTAMT"]').val(tp2amt);
      $(this).parent().parent().find('[id*="SGSTAMT"]').val(tp3amt);
      bindTotalValue();
      if($('#CTID_REF').val()!='')
      {
      bindGSTCalTemplate();
      }
      bindTotalValue();
      event.preventDefault();
    });   

    $('#Material').on('focusout',"[id*='DISCPER']",function()
    { 
      var mqty = $(this).parent().parent().find('[id*="SO_QTY"]').val();
      var irate = $(this).parent().parent().find('[id*="RATEPUOM"]').val();
      var totamt = parseFloat(parseFloat(mqty)*parseFloat(irate)).toFixed(2);
      var dpert = $(this).val();
     
      if (dpert != '' && dpert != '.0000')
      {
        var amtfd = parseFloat(parseFloat(totamt) - (parseFloat(totamt)*parseFloat(dpert))/100).toFixed(2);
        if(intRegex.test($(this).val())){
          $(this).val($(this).val()+'.0000')
        }
      var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
      var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
      var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
      $(this).parent().parent().find('[id*="IGSTAMT"]').val('0');
      $(this).parent().parent().find('[id*="CGSTAMT"]').val('0');
      $(this).parent().parent().find('[id*="SGSTAMT"]').val('0');
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
      $(this).parent().parent().find('[id*="DISCOUNT_AMT"]').prop('disabled',true);
      $(this).parent().parent().find('[id*="DISAFTT_AMT"]').val(amtfd);
      $(this).parent().parent().find('[id*="TOT_AMT"]').val(netamt);
      $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
      $(this).parent().parent().find('[id*="IGSTAMT"]').val(tp1amt);
      $(this).parent().parent().find('[id*="CGSTAMT"]').val(tp2amt);
      $(this).parent().parent().find('[id*="SGSTAMT"]').val(tp3amt);
      }
      else{
        var amtfd = parseFloat(totamt).toFixed(2);
        var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
        var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
        var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
        $(this).parent().parent().find('[id*="IGSTAMT"]').val('0');
        $(this).parent().parent().find('[id*="CGSTAMT"]').val('0');
        $(this).parent().parent().find('[id*="SGSTAMT"]').val('0');
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
        $(this).parent().parent().find('[id*="DISCOUNT_AMT"]').removeAttr('disabled');
        $(this).parent().parent().find('[id*="DISAFTT_AMT"]').val(amtfd);
        $(this).parent().parent().find('[id*="TOT_AMT"]').val(netamt);
        $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
        $(this).parent().parent().find('[id*="IGSTAMT"]').val(tp1amt);
        $(this).parent().parent().find('[id*="CGSTAMT"]').val(tp2amt);
        $(this).parent().parent().find('[id*="SGSTAMT"]').val(tp3amt);
      }
      bindTotalValue();
      if($('#CTID_REF').val()!='')
      {
      bindGSTCalTemplate();
      }
      bindTotalValue();
      event.preventDefault();
    });

    $('#Material').on('focusout',"[id*='DISCOUNT_AMT']",function()
    {
      var mqty = $(this).parent().parent().find('[id*="SO_QTY"]').val();
      var irate = $(this).parent().parent().find('[id*="RATEPUOM"]').val();
      var totamt = parseFloat(parseFloat(mqty)*parseFloat(irate)).toFixed(2);
      var dpert = $(this).val();
      var dispercent = $(this).parent().parent().find('[id*="DISCPER"]').val();
      if (dpert != '' && dpert != '.00')
      {
        var amtfd = parseFloat(totamt) - parseFloat(dpert);
        if(intRegex.test($(this).val())){
          $(this).val($(this).val()+'.00')
        }
        var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
        var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
        var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
        $(this).parent().parent().find('[id*="IGSTAMT"]').val('0');
        $(this).parent().parent().find('[id*="CGSTAMT"]').val('0');
        $(this).parent().parent().find('[id*="SGSTAMT"]').val('0');
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
        $(this).parent().parent().find('[id*="DISCPER"]').prop('disabled',true);
        $(this).parent().parent().find('[id*="DISAFTT_AMT"]').val(amtfd);
        $(this).parent().parent().find('[id*="TOT_AMT"]').val(netamt);
        $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
        $(this).parent().parent().find('[id*="IGSTAMT"]').val(tp1amt);
        $(this).parent().parent().find('[id*="CGSTAMT"]').val(tp2amt);
        $(this).parent().parent().find('[id*="SGSTAMT"]').val(tp3amt);
      }
      else if (dispercent != '' && dispercent != '.0000')
      {
        var amtfd = parseFloat(parseFloat(totamt) - (parseFloat(totamt)*parseFloat(dispercent))/100).toFixed(2);
        if(intRegex.test($(this).val())){
          $(this).val($(this).val()+'.00')
        }
      var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
      var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
      var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
      $(this).parent().parent().find('[id*="IGSTAMT"]').val('0');
      $(this).parent().parent().find('[id*="CGSTAMT"]').val('0');
      $(this).parent().parent().find('[id*="SGSTAMT"]').val('0');
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
      $(this).parent().parent().find('[id*="DISCOUNT_AMT"]').prop('readonly',true);
      $(this).parent().parent().find('[id*="DISAFTT_AMT"]').val(amtfd);
      $(this).parent().parent().find('[id*="TOT_AMT"]').val(netamt);
      $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
      $(this).parent().parent().find('[id*="IGSTAMT"]').val(tp1amt);
      $(this).parent().parent().find('[id*="CGSTAMT"]').val(tp2amt);
      $(this).parent().parent().find('[id*="SGSTAMT"]').val(tp3amt);
      }
      else{
        var amtfd = parseFloat(totamt).toFixed(2);
        var tp1 = $(this).parent().parent().find('[id*="IGST_"]').val();
        var tp2 = $(this).parent().parent().find('[id*="CGST_"]').val();
        var tp3 = $(this).parent().parent().find('[id*="SGST_"]').val();
        $(this).parent().parent().find('[id*="IGSTAMT"]').val('0');
        $(this).parent().parent().find('[id*="CGSTAMT"]').val('0');
        $(this).parent().parent().find('[id*="SGSTAMT"]').val('0');
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
        $(this).parent().parent().find('[id*="DISCPER"]').removeAttr('disabled');
        $(this).parent().parent().find('[id*="DISAFTT_AMT"]').val(amtfd);
        $(this).parent().parent().find('[id*="TOT_AMT"]').val(netamt);
        $(this).parent().parent().find('[id*="TGST_AMT"]').val(taxamt);
        $(this).parent().parent().find('[id*="IGSTAMT"]').val(tp1amt);
        $(this).parent().parent().find('[id*="CGSTAMT"]').val(tp2amt);
        $(this).parent().parent().find('[id*="SGSTAMT"]').val(tp3amt);
      }
      bindTotalValue();
      if($('#CTID_REF').val()!='')
      {
      bindGSTCalTemplate();
      }
      bindTotalValue();
      event.preventDefault();
    });

    

    $('#Material').on('focusout',"[id*='IGST']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.0000')
      }
    });

    $('#Material').on('focusout',"[id*='IGST_AMT']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00')
      }
    });

    $('#Material').on('focusout',"[id*='CGST']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.0000')
      }
    });

    $('#Material').on('focusout',"[id*='CGST_AMT']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00')
      }
    });

    $('#Material').on('focusout',"[id*='SGST']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.0000')
      }
    });

    $('#Material').on('focusout',"[id*='SGST_AMT']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00')
      }
    });

    $('#Material').on('focusout',"[id*='TGST_AMT']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00')
      }
    });

    $('#Material').on('keyup',"[id*='TOT_AMT']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00')
      }
    });

    $('#example5').on('focusout',"[id*='calSGST_']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00')
      }
      bindTotalValue();
    });

    $('#example5').on('focusout',"[id*='calCGST_']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00')
      }
      bindTotalValue();
    });

    $('#example5').on('focusout',"[id*='calIGST_']",function()
    {
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00')
      }
      bindTotalValue();
    });

    $('#btnAdd').on('click', function() {
        var viewURL = '{{route("transaction",[$FormId,"add"])}}';
                  window.location.href=viewURL;
    });
    $('#btnExit').on('click', function() {
      var viewURL = '{{route('home')}}';
                  window.location.href=viewURL;
    });
    //to check the label duplicacy
     $('#CSV_NO').focusout(function(){
      var CSV_NO   =   $.trim($(this).val());
      if(CSV_NO ===""){
                $("#FocusId").val('CSV_NO');
                // $("[id*=txtlabel]").blur(); 
                $("#ProceedBtn").focus();
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn1").show();
                $("#AlertMessage").text('Please enter value in CSV_NO.');
                $("#alert").modal('show');
                $("#OkBtn1").focus();
                highlighFocusBtn('activeOk1');
                // return false;
            } 
        else{ 
        var trnsoForm = $("#frm_trn_add");
        var formData = trnsoForm.serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'{{route("transaction",[$FormId,"checkso"])}}',
            type:'POST',
            data:formData,
            success:function(data) {
               if(data.exists) {
                    $(".text-danger").hide();
                    if(data.exists) {                   
                        console.log("cancel MSG="+data.msg);
                                      $("#YesBtn").hide();
                                      $("#NoBtn").hide();
                                      $("#OkBtn1").show();
                                      $("#AlertMessage").text(data.msg);
                                      $(".text-danger").hide();
                                      $("#CSV_NO").val('');
                                      $("#alert").modal('show');
                                      $("#OkBtn1").focus();
                                      highlighFocusBtn('activeOk1');
                    }                 
                }                
            },
            error:function(data){
              console.log("Error: Something went wrong.");
            },
        });
    }
});

//SO Date Check
$('#CSV_DT').change(function( event ) {
            var today = new Date();     
            var d = new Date($(this).val()); 
            today.setHours(0, 0, 0, 0) ;
            d.setHours(0, 0, 0, 0) ;
            var sodate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
            if (d < today) {
                $(this).val(sodate);
                $("#alert").modal('show');
                $("#AlertMessage").text('SO Date cannot be less than Current date');
                $("#YesBtn").hide(); 
                $("#NoBtn").hide();  
                $("#OkBtn1").show();
                $("#OkBtn1").focus();
                highlighFocusBtn('activeOk1');
                event.preventDefault();
            }
            else
            {
                event.preventDefault();
            }

           
        });
//SO Date Check

//SO Validity to Date Check
$('#OVFDT').change(function( event ) {
            var d = document.getElementById('OVFDT').value; 
            var date = new Date(d);
            var newdate = new Date(date);
            newdate.setDate(newdate.getDate() + 29);
            var sodate = newdate.getFullYear() + "-" + ("0" + (newdate.getMonth() + 1)).slice(-2) + "-" + ('0' + newdate.getDate()).slice(-2) ;
            $('#OVTDT').val(sodate);
            
        });

//SO Validity to Date Check
$('#example6').on('change','[id*="PAY_DAYS"]',function( event ) {
            var d = $(this).val(); 
            d = parseInt(d) - 1;
            var sdate =$('#CSV_DT').val();
            var ddate = new Date(sdate);
            var newddate = new Date(ddate);
            newddate.setDate(newddate.getDate() + d);
            var soddate = newddate.getFullYear() + "-" + ("0" + (newddate.getMonth() + 1)).slice(-2) + "-" + ('0' + newddate.getDate()).slice(-2) ;
            $(this).parent().parent().find('[id*="DUE_DATE"]').val(soddate);
            
        });
//SO Date Check
        
    




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

      

   }//fnUndoNo


   $("#SOFC").change(function() {
      if ($(this).is(":checked") == true){
          $(this).parent().parent().find('#txtCRID_popup').removeAttr('disabled');
          $(this).parent().parent().find('#txtCRID_popup').prop('readonly','true');
          event.preventDefault();
      }
      else
      {
          $(this).parent().parent().find('#txtCRID_popup').prop('disabled','true');
          $(this).parent().parent().find('#txtCRID_popup').removeAttr('readonly');
          $(this).parent().parent().find('#txtCRID_popup').val('');
          $(this).parent().parent().find('#CRID_REF').val('');
          $(this).parent().parent().find('#CONVFACT').val('');
          event.preventDefault();
      }
  });

  $("#example5").on('change',"[id*='calGST']",function() {
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
  $("#example5").on('change',"[id*='calIGST_']",function() {
      var rate = $(this).val();
      var total = $(this).parent().parent().find('[id*="VALUE_"]').val();
      var gstamt = parseFloat((rate*total)/100).toFixed(2);
      var totgst = $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val();
      totgst = parseFloat(parseFloat(gstamt)).toFixed(2);;
      $(this).parent().parent().find('[id*="AMTIGST_"]').val(gstamt);
      $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val(totgst);
      bindTotalValue();
      event.preventDefault();
  });
  $("#example5").on('change',"[id*='calCGST_']",function() {
      var rate2 = $(this).val();
      var total2 = $(this).parent().parent().find('[id*="VALUE_"]').val();
      var gstamt2 = parseFloat((rate2*total2)/100).toFixed(2);
      var totgst2 = $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val();
      var sgstamt = $(this).parent().parent().find('[id*="AMTSGST_"]').val();
      totgst2 = parseFloat(parseFloat(sgstamt) + parseFloat(gstamt2)).toFixed(2);
      $(this).parent().parent().find('[id*="AMTCGST_"]').val(gstamt2);
      $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val(totgst2);
      bindTotalValue();
      event.preventDefault();
  }); 
  $("#example5").on('change',"[id*='calSGST_']",function() {
      var rate3 = $(this).val();
      var total3 = $(this).parent().parent().find('[id*="VALUE_"]').val();
      var gstamt3 = parseFloat((rate3*total3)/100).toFixed(2);
      var totgst3 = $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val();
      var cgstamt = $(this).parent().parent().find('[id*="AMTCGST_"]').val();
      totgst3 = parseFloat(parseFloat(cgstamt) + parseFloat(gstamt3)).toFixed(2);;
      $(this).parent().parent().find('[id*="AMTSGST_"]').val(gstamt3);
      $(this).parent().parent().find('[id*="TOTGSTAMT_"]').val(totgst3);
      bindTotalValue();
      event.preventDefault();
  }); 


});
</script>

@endpush

@push('bottom-scripts')
<script>

$(document).ready(function() {

  $("#btnSaveData").on("submit", function( event ) {
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
                      message: 'The SO NO is required'
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


$( "#btnSaveData" ).click(function() {
  var formSalesOrder = $("#frm_trn_add");
  if(formSalesOrder.valid()){
    validateForm();
  }
});

function validateForm(){

  $("#FocusId").val('');

  var CSV_NO            = $.trim($("#CSV_NO").val());
  var CSV_DT            = $.trim($("#CSV_DT").val());
  var SLID_REF          = $.trim($("#SLID_REF").val());
  var REASONOFSR        = $.trim($("#REASONOFSR").val());
  var TRANSACTION_TYPE  = $.trim($("#TRANSACTION_TYPE").val());

  if(CSV_NO ===""){
    showAlert('Please enter CSV NO.','CSV_NO');
  }
  else if(CSV_DT ===""){
    showAlert('Please select CSV Date.','CSV_DT');
  } 
  else if(SLID_REF ===""){
    showAlert('Please select Customer.','txtsubgl_popup');
  }
  else if(REASONOFSR ===""){
    showAlert('Please enter Reason of Credit Note.','REASONOFSR');
  }
  else if(TRANSACTION_TYPE ===""){
    showAlert('Please select transaction type.','TRANSACTION_TYPE');
  }
  else{
    event.preventDefault();
    var RackArray   = []; 
    var allblank00  = [];
    var allblank01  = [];
    var allblank02  = [];
    var allblank03  = [];
    var allblank04  = [];
    var allblank05  = [];
    var allblank06  = [];
    var allblank07  = [];
    var allblank08  = [];
    var allblank09  = [];
    var allblank5 = [];
    var allblank6 = [];
    var allblank7 = [];
    var allblank8 = [];
    var allblank9 = [];
    var allblank10 = [];
    var allblank11 = [];
    var allblank12 = [];
        
    $('#example2').find('.participantRow').each(function(){

      var SSOID_REF       =   $.trim($(this).find('[id*="SQA"]').val());
      var ITEMID_REF      =   $.trim($(this).find('[id*="ITEMID_REF"]').val());
      var exist           =   $.trim($(this).find('[id*="exist"]').val());
      var SQMUOMQTY       =   $.trim($(this).find('[id*="SQMUOMQTY"]').val());
      var SO_QTY          =   $.trim($(this).find('[id*="SO_QTY"]').val());
      var TotalHiddenQty  =   $.trim($(this).find('[id*="TotalHiddenQty"]').val());
      

      if($("#Direct").is(":checked") == false){
        if($.trim($(this).find('[id*="SQA"]').val()) != "" ){
          allblank00.push('true');
        }
        else{
          allblank00.push('false');
        }
      }
      else{
        allblank00.push('true');
      }  
      

      if($.trim($(this).find("[id*=ITEMID_REF]").val())!=""){
        allblank01.push('true');
      }
      else{
        allblank01.push('false');
      }

      if (RackArray.indexOf(exist) > -1) {
        allblank02.push('true');
      }
      else{
        allblank02.push('false');
      }

      if($.trim($(this).find("[id*=popupMUOM]").val())!=""){
        allblank03.push('true');
      }
      else{
        allblank03.push('false');
      }  

      if($.trim($(this).find('[id*="SO_QTY"]').val()) != ""){
        allblank04.push('true');  
      }
      else{
        allblank04.push('false');
      }


      if($("#Direct").is(":checked") == false){
        if(parseFloat(SQMUOMQTY) >= parseFloat(SO_QTY)){
          allblank05.push('true');
        }
        else{
          allblank05.push('false');
        } 
      }  
      else{
        allblank05.push('true');
      }

      if($.trim($(this).find('[id*="ALT_UOMID_QTY"]').val()) != ""){
        if(parseFloat($.trim($(this).find('[id*="ALT_UOMID_QTY"]').val())) > 0.000 ){
          allblank06.push('true');
        }
        else{
          allblank06.push('false');
        }  
      }
      else{
        allblank06.push('false');
      } 

      if($("#Direct").is(":checked") == false){
        if($.trim($(this).find('[id*="RATEPUOM"]').val()) != ""){
          if(parseFloat($.trim($(this).find('[id*="RATEPUOM"]').val())) > 0.000 ){
            allblank08.push('true');
          }
          else{
            allblank08.push('false');
          }  
        }
        else{
          allblank08.push('false');
        } 
      }
      else{
        allblank08.push('true');
      }
 
      if(parseFloat(SO_QTY) > 0){

        if(TotalHiddenQty !=""){
          allblank09.push('true');
        }
        else{
          allblank09.push('false');
        }
        

        if(parseFloat(SO_QTY) == parseFloat(TotalHiddenQty)){
          allblank09.push('true');
        }
        else{
          allblank09.push('false');
        }
      }

     

      if($.trim($('#Tax_State').val())=="WithinState"){
        if($.trim($(this).find("[id*=IGST]").val())!="")
        {
          allblank5.push('true');
        }
        else
        {
          allblank5.push('true');
        }
      }
      else{
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

      RackArray.push(exist);

    });

    

    $('#example4').find('.participantRow4').each(function(){
          if($.trim($(this).find("[id*=UDFSOID_REF]").val())!="")
            {
                allblank8.push('true');
                    if($.trim($(this).find("[id*=UDFismandatory]").val())=="1"){
                          if($.trim($(this).find('[id*="udfvalue"]').val()) != "")
                          {
                            allblank9.push('true');
                          }
                          else
                          {
                            allblank9.push('false');
                          }
                    }  
            }                
    });

    if($('#CTID_REF').val() !=""){
        $('#example5').find('.participantRow5').each(function(){
          if($.trim($(this).find("[id*=TID_REF]").val())!="")
            {
                
                    if($(this).find("[id*=calGST]").is(":checked") == true)
                    {
                      if($.trim($('#Tax_State').val())!="WithinState")
                      {
                        if($.trim($(this).find("[id*=calIGST]").val())!="0")
                        {
                          allblank11.push('true');
                        }
                        else
                        {
                          allblank11.push('false');
                        }
                      }
                      else
                      {
                        if($.trim($(this).find("[id*=calCGST]").val())!="0")
                        {
                          allblank11.push('true');
                        }
                        else
                        {
                          allblank11.push('false');
                        }
                        if($.trim($(this).find("[id*=calSGST]").val())!="0")
                        {
                          allblank11.push('true');
                        }
                        else
                        {
                          allblank11.push('false');
                        }
                      }
                    } 
            }
            else
            {
                allblank10.push('false');
            } 
        });
    }


    if(jQuery.inArray("false", allblank00) !== -1){
      showAlert('Please select SI NO in Material Tab.');
    }
    else if(jQuery.inArray("false", allblank01) !== -1){
      showAlert('Please select Item Code in Material Tab.');
    }
    else if(jQuery.inArray("true", allblank02) !== -1){
      showAlert('Duplicate SI NO/Item Code in Material Tab.');
    }
    else if(jQuery.inArray("false", allblank03) !== -1){
      showAlert('UOM section is missing in Material Tab.');
    }
    else if(jQuery.inArray("false", allblank04) !== -1){
      showAlert('Return Qty cannot be blank in Material Tab.');
    }
    else if(jQuery.inArray("false", allblank05) !== -1){
      showAlert('Return Qty cannot be greater then Invoice Qty in Material Tab.');
    }
    // else if(jQuery.inArray("false", allblank06) !== -1){
    //   showAlert('Return Qty (Alt UOM) cannot be zero or blank in Material Tab.');
    // }
    else if(jQuery.inArray("false", allblank08) !== -1){
      showAlert('SI Rate cannot be zero or blank in Material Tab.');
    }
    else if(jQuery.inArray("false", allblank09) !== -1){
      showAlert('Return Qty not equal of store Qty in Material Tab.');
    }
    else if(jQuery.inArray("false", allblank5) !== -1){
      showAlert('Please enter GST Rate / Value in Material Tab.');
    }
    else if(jQuery.inArray("false", allblank9) !== -1){
      showAlert('Please enter  Value / Comment in UDF Tab.');
    }
    else if(jQuery.inArray("false", allblank10) !== -1){
      showAlert('Please select Calculation Component in Calculation Template Tab.');
    }
    else if(jQuery.inArray("false", allblank11) !== -1){
      showAlert('Please Enter GST Rate / Value in Calculation Template Tab.');
    }
    else if(checkPeriodClosing('{{$FormId}}',$("#CSV_DT").val(),0) ==0){
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
        $("#YesBtn").data("funcname","fnSaveData");
        $("#YesBtn").focus();
        $("#OkBtn").hide();
        highlighFocusBtn('activeYes');
    }
  }
}

$("#YesBtn").click(function(){

$("#alert").modal('hide');
var customFnName = $("#YesBtn").data("funcname");
    window[customFnName]();

}); //yes button

window.fnSaveData = function (){

//validate and save data
event.preventDefault();

     var trnsoForm = $("#frm_trn_add");
    var formData = trnsoForm.serialize();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$("#btnSaveData").hide(); 
$(".buttonload").show(); 
$("#btnApprove").prop("disabled", true);
$.ajax({
    url:'{{ route("transaction",[$FormId,"save"])}}',
    type:'POST',
    data:formData,
    success:function(data) {
      $(".buttonload").hide(); 
      $("#btnSaveData").show();   
      $("#btnApprove").prop("disabled", false);
       
        if(data.errors) {
            $(".text-danger").hide();

            if(data.errors.CSV_NO){
                showError('ERROR_CSV_NO',data.errors.CSV_NO);
                        $("#YesBtn").hide();
                        $("#NoBtn").hide();
                        $("#OkBtn1").show();
                        $("#AlertMessage").text('Please enter correct value in CSV NO.');
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
            $("#alert").modal('show');
            $("#OkBtn").focus();
        }
        else if(data.cancel) {                   
            console.log("cancel MSG="+data.msg);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text(data.msg);
            $(".text-danger").hide();
            $("#alert").modal('show');
            $("#OkBtn1").focus();
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
        $("#btnSaveData").show();   
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

//no button
$("#NoBtn").click(function(){
    $("#alert").modal('hide');
    
});

//ok button
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

//
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

function showAlert(msg,smgid){
  $("#FocusId").val(smgid);
  $("#alert").modal('show');
  $("#AlertMessage").text(msg);
  $("#YesBtn").hide(); 
  $("#NoBtn").hide();  
  $("#OkBtn1").show();
  $("#OkBtn1").focus();
  highlighFocusBtn('activeOk');
}

function isNumberDecimalKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

    // if(($(this).val().indexOf('.') != -1) && ($(this).val().substring($(this).val().indexOf('.'),$(this).val().indexOf('.').length).length>2 )){
    //         if (charCode !== 8 && charCode !== 46 ){ 
    //           charCode.preventDefault();
    //         }
    //     }

    return true;
}


$('#Material').on('change','[id*="flagtype"]',function(event){
  $('#example2').find('.participantRow').each(function(){ 

    var divid       =   $(this).find('[id]').attr('id');
    var IGST        =   $(this).find('[id*="IGST"]').val();
    var CGST        =   $(this).find('[id*="CGST"]').val();
    var SGST        =   $(this).find('[id*="SGST"]').val();
    var ITEMID_REF  =   $(this).find('[id*="ITEMID_REF"]').val();
    var Tax_State   =   $("#Tax_State").val();

    if($(this).find('[id*="flagtype"]').is(":checked") == false){
      $(this).find('[id*="IGST"]').val('0.000');
      $(this).find('[id*="IGSTAMT"]').val('0.000');
      $(this).find('[id*="CGST"]').val('0.000');
      $(this).find('[id*="CGSTAMT"]').val('0.000');
      $(this).find('[id*="SGST"]').val('0.000');
      $(this).find('[id*="SGSTAMT"]').val('0.000');
      $(this).find('[id*="TGST_AMT"]').val('0.000');
      $(this).find('[id*="TOT_AMT"]').val($(this).find('[id*="DISAFTT_AMT"]').val());
    }
    else if($(this).find('[id*="flagtype"]').is(":checked") == true && IGST < 1 && CGST < 1 && SGST < 1){
      
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
          url:'{{route("transaction",[$FormId,"getTax"])}}',
          type:'POST',
          data:{ITEMID_REF:ITEMID_REF,Tax_State:Tax_State},
          success:function(data) {
              var myObj = JSON.parse(data);

              if(Tax_State =='OutofState'){
                $("#IGST_"+divid).val(myObj[0]);
              }
              else{
                $("#CGST_"+divid).val(myObj[0]);
                $("#SGST_"+divid).val(myObj[1]);
              }

              $("#RATEPUOM_"+divid).blur();

          },
          error:function(data){
            console.log("Error: Something went wrong.");
          },
      });        

    }
    $(".blurRate").blur();
  });
});

$("#Material").on('click', '[class*="checkstore"]', function() {

  var storeid         = $(this).attr('id').split('_');
  var ROW_ID          = storeid[1];
  var ITEMID_REF      = $("#ITEMID_REF_"+ROW_ID).val();
  var MAIN_UOMID_REF  = $("#MAIN_UOMID_REF_"+ROW_ID).val();
  var SIID_REF        = $("#SQA_"+ROW_ID).val();

  if(ITEMID_REF ===""){
    showAlert("Please select item code in material tab.");
  }
  else{
      getStoreDetails(ITEMID_REF,MAIN_UOMID_REF,ROW_ID,SIID_REF);
      $("#StoreModal").show();
      event.preventDefault();
  }

});

$("#StoreModalClose").click(function(event){
  $("#StoreModal").hide();
});


function getStoreDetails(ITEMID_REF,MAIN_UOMID_REF,ROW_ID,SIID_REF){

  var WhereId           = $("#exist_"+ROW_ID).val();
  var ITEMROWID         = $("#HiddenRowId_"+ROW_ID).val();
  var TRANSACTION_TYPE  = $("#TRANSACTION_TYPE").val();

  $("#StoreTable").html('');
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
      url:'{{route("transaction",[$FormId,"getStoreDetails"])}}',
      type:'POST',
      data:{TRANSACTION_TYPE:TRANSACTION_TYPE,ITEMID_REF:ITEMID_REF,MAIN_UOMID_REF:MAIN_UOMID_REF,ROW_ID:ROW_ID,ITEMROWID:ITEMROWID,ACTION_TYPE:'ADD',SIID_REF:SIID_REF,WhereId:WhereId},
      success:function(data) {
        $("#StoreTable").html(data);  
        getTotalStoreQty();              
      },
      error:function(data){
        console.log("Error: Something went wrong.");
        $("#StoreTable").html('');                        
      },
  }); 
}

function checkStoreQty(ROW_ID,stockQty,userQty,key,itemid){
  
  var NewQtyArr = [];
  var NewIdArr  = [];

  $('#StoreTable').find('.participantRow33').each(function(){

    if($.trim($(this).find("[id*=UserQty]").val())!="" && parseFloat($.trim($(this).find("[id*=UserQty]").val())) > 0 ){ 
      var UserQty      = parseFloat($.trim($(this).find("[id*=UserQty]").val()));
      var BatchId      = $.trim($(this).find("[id*=BATCHID]").val());

      NewQtyArr.push(UserQty);
      NewIdArr.push(BatchId+"_"+UserQty);
    }         

  });

  var TotalQty= getArraySum(NewQtyArr); 
  $("#TotalHiddenQty_"+ROW_ID).val(TotalQty);
  $("#HiddenRowId_"+ROW_ID).val(NewIdArr);
  getTotalStoreQty();
     
}

function getArraySum(a){
    var total=0;
    for(var i in a) { 
        total += a[i];
    }
    return total;
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

function direct(){
  if($("#Direct").is(":checked") == true){
    $("[id*='txtSQ_popup']").prop('disabled', true);
  }
  else{
    $("[id*='txtSQ_popup']").prop('disabled', false);
  } 

  resetTab();

}

function resetTab(){

  $('#Material').find('.participantRow').each(function(){
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

  $('#CT').find('.participantRow5').each(function(){
    var rowcount = $(this).closest('table').find('.participantRow5').length;
    $(this).find('input:text').val('');
    $(this).find('input:checkbox').prop('checked',false);      
    if(rowcount > 1)
    {
      $(this).closest('.participantRow5').remove();
      rowcount = parseInt(rowcount) - 1;
      $('#Row_Count4').val(rowcount);
    }
  });

  $('#txtCTID_popup').val('');
  $('#CTID_REF').val('');

  $("#TOTAL_STORE_QTY").val('0');

}

function getTransactionType(value){
  
    $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

      $.ajax({
        url:'{{route("transaction",[$FormId,"getCSVNo"])}}',
        type:'POST',
        data:{dataval:value},
        success:function(data) {
            $("#CSV_NO").val(data);                
        },
        error:function(data){
          console.log("Error: Something went wrong.");
        },
    });

  resetTab();
}

function getTotalStoreQty(){
  var TOTAL_QTY = 0;

  $('#StoreTable').find('.participantRow33').each(function(){

    if($.trim($(this).find("[id*=UserQty]").val())!="" && parseFloat($.trim($(this).find("[id*=UserQty]").val())) > 0 ){
     
      TOTAL_QTY = TOTAL_QTY+parseFloat($.trim($(this).find("[id*=UserQty]").val()));
    }         

  });

  $("#TOTAL_STORE_QTY").val(TOTAL_QTY);
}


		
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
	  MultiCurrency_Conversion('TotalValue'); 
  });
</script>
@endpush