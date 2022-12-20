@extends('layouts.app')
@section('content')

<div class="container-fluid topnav">
    <div class="row">
        <div class="col-lg-2">
        <a href="{{route('transaction',[$FormId,'index'])}}" class="btn singlebt">Gate Entry (GE)</a>
        </div>

        <div class="col-lg-10 topnav-pd">
                <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                <button class="btn topnavbt" id="btnSaveSE" disabled="disabled"><i class="fa fa-floppy-o" ></i> Save</button>
                <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                <button class="btn topnavbt" id="btnUndo"  disabled="disabled"><i class="fa fa-undo"></i> Undo</button>
                <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-thumbs-o-up"></i> Approved</button>
                <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
        </div>
    </div>
</div>


<form id="frm_trn_edit" onsubmit="return validateForm()"  method="POST" class="needs-validation"  >
  @csrf
  {{isset($objResponse->GEID[0]) ? method_field('PUT') : '' }}  
  <div class="container-fluid filter">
	  <div class="inner-form">
		  <div class="row">
        <div class="col-lg-1 pl"><p>GE No</p></div>
        
        <div class="col-lg-1 pl">
            <input {{$ActionStatus}} type="text" name="GE_NO" id="GE_NO" value="{{isset($objResponse->GE_NO) && $objResponse->GE_NO !=''?$objResponse->GE_NO:''}}" class="form-control mandatory"  autocomplete="off" readonly style="text-transform:uppercase"  >
        </div>
			
        <div class="col-lg-1 pl"><p>GE Date</p></div>
        <div class="col-lg-2 pl">
              <input {{$ActionStatus}} type="date" name="GE_DT" id="GE_DT" value="{{isset($objResponse->GE_DT) && $objResponse->GE_DT !=''?$objResponse->GE_DT:''}}" class="form-control mandatory" autocomplete="off" >
        </div>

        <div class="col-lg-1 pl"><p>GE Time</p></div>
        <div class="col-lg-2 pl">
              <input {{$ActionStatus}} type="time" name="GE_TM" id="GE_TM" value="{{isset($objResponse->GE_TM) && $objResponse->GE_TM !=''?date('H:i:s',strtotime($objResponse->GE_TM)):''}}" class="form-control mandatory"  autocomplete="off"  >
        </div>

        <div class="col-lg-2 pl"><p>Security Supervisor</p></div>
        <div class="col-lg-2 pl">
          <input {{$ActionStatus}} type="text" name="SECURITY_SUP" id="SECURITY_SUP" value="{{isset($objResponse->SECURITY_SUP) && $objResponse->SECURITY_SUP !=''?$objResponse->SECURITY_SUP:''}}" maxlength="100" class="form-control" autocomplete="off"   >
        </div>
      </div>


      <div class="row">
        

        <div class="col-lg-1 pl"><p>Security Guard</p></div>
        <div class="col-lg-2 pl">
          <input {{$ActionStatus}} type="text" name="SECURITY_GUARD" id="SECURITY_GUARD" value="{{isset($objResponse->SECURITY_GUARD) && $objResponse->SECURITY_GUARD !=''?$objResponse->SECURITY_GUARD:''}}" maxlength="100" class="form-control" autocomplete="off"   >
        </div>
        <div class="col-lg-1 pl"></div>

        <div class="col-lg-2 pl"><p>Type</p></div>
        <div class="col-lg-2 pl">
          <select {{$ActionStatus}} name="TYPE" id="TYPE" class="form-control"  autocomplete="off" onchange="getType(this.value)" >
            <option {{isset($objResponse->TYPE) && $objResponse->TYPE ==='Vendor'?'selected="selected"':''}} value="Vendor">Vendor</option>
            <option {{isset($objResponse->TYPE) && $objResponse->TYPE ==='Customer'?'selected="selected"':''}} value="Customer"  {{isset($objResponse->GETYPE) && $objResponse->GETYPE =='RGP'?'':'disabled'}}>Customer</option>
            <option {{isset($objResponse->TYPE) && $objResponse->TYPE ==='Employee'?'selected="selected"':''}} value="Employee" {{isset($objResponse->GETYPE) && $objResponse->GETYPE =='RGP'?'':'disabled'}}>Employee</option>
          </select>
        </div>

        <div class="col-lg-2 pl"><p id='fieldtype' >{{$objResponse->TYPE}}</p></div>
        <div class="col-lg-2 pl">
          <input {{$ActionStatus}} type="text"    name="VID_REF_Details" id="VID_REF_Details" value="{{isset($objVendorName->VCODE) && $objVendorName->VCODE !=''?$objVendorName->VCODE.' - '.$objVendorName->NAME:''}}" class="form-control mandatory"  autocomplete="off" readonly/>
          <input type="hidden"  name="VID_REF"         id="VID_REF" value="{{isset($objResponse->VID_REF) && $objResponse->VID_REF !=''?$objResponse->VID_REF:''}}" class="form-control" autocomplete="off" />
        </div>
      </div>

      <div class="row">

        <div class="col-lg-4 pl">

          <div class="col-lg-2 pl"><p>PO</p></div>
          <div class="col-lg-1 pl">
              <input {{$ActionStatus}} type="checkbox" name="GETYPE" id="PO" {{isset($objResponse->GETYPE) && $objResponse->GETYPE =='PO'?'checked':''}} value="PO" onchange="PoRgpType('PO');"  />
          </div>

          <div class="col-lg-2 pl"><p>RGP</p></div>
          <div class="col-lg-1 pl">
              <input {{$ActionStatus}} type="checkbox" name="GETYPE" id="RGP"  {{isset($objResponse->GETYPE) && $objResponse->GETYPE =='RGP'?'checked':''}} value="RGP" onchange="PoRgpType('RGP');"  />    
          </div>

          <div class="col-lg-2 pl"><p>IPO</p></div>
          <div class="col-lg-1 pl">
              <input {{$ActionStatus}} type="checkbox" name="GETYPE" id="IPO"  {{isset($objResponse->GETYPE) && $objResponse->GETYPE =='IPO'?'checked':''}} value="IPO" onchange="PoRgpType('IPO');"  />    
          </div>

          <div class="col-lg-2 pl"><p>BPO</p></div>
          <div class="col-lg-1 pl">
              <input {{$ActionStatus}} type="checkbox" name="GETYPE" id="BPO"  {{isset($objResponse->GETYPE) && $objResponse->GETYPE =='BPO'?'checked':''}} value="BPO" onchange="PoRgpType('BPO');"  />    
          </div>

        </div>

        
        
        <div class="col-lg-2 pl"><p>PO/RGP/IPO/BPO No</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="text" name="PO_NO_Details" id="PO_NO_Details" value="{{isset($objPoRgpName) && $objPoRgpName!=''?$objPoRgpName:''}}" class="form-control mandatory"  autocomplete="off" readonly/>
            <input type="hidden" name="PO_NO" id="PO_NO" value="{{isset($objResponse->PO_NO) && $objResponse->PO_NO !=''?$objResponse->PO_NO:''}}" class="form-control" autocomplete="off" />
        </div>

        

        <div class="col-lg-2 pl"><p id="fieldtype1" >{{$objResponse->TYPE}} Bill No</p></div>
        <div class="col-lg-2 pl">
              <input {{$ActionStatus}} type="text" name="VENDOR_BILLNO" id="VENDOR_BILLNO" onkeyup="deleteDate('VENDOR_BILLDT',this.value),checkDuplicateVendorBillNo(this.value,'')"  value="{{isset($objResponse->VENDOR_BILLNO) && $objResponse->VENDOR_BILLNO !=''?$objResponse->VENDOR_BILLNO:''}}" maxlength="20"  class="form-control" autocomplete="off"   >

              <input type="hidden" name="VENDOR_BILLNO_LAST" id="VENDOR_BILLNO_LAST" value="{{isset($objResponse->VENDOR_BILLNO) && $objResponse->VENDOR_BILLNO !=''?$objResponse->VENDOR_BILLNO:''}}" class="form-control" autocomplete="off" />

              <input type="hidden" name="VID_REF_LAST" id="VID_REF_LAST" value="{{isset($objResponse->VID_REF) && $objResponse->VID_REF !=''?$objResponse->VID_REF:''}}" class="form-control" autocomplete="off" />
        </div>
      </div>

    <div class="row">
      <div class="col-lg-2 pl"><p>Bill Date</p></div>
			<div class="col-lg-2 pl">
				  <input {{$ActionStatus}} type="date" name="VENDOR_BILLDT" id="VENDOR_BILLDT" value="{{isset($objResponse->VENDOR_BILLDT) && $objResponse->VENDOR_BILLDT !=''?$objResponse->VENDOR_BILLDT:''}}"  class="form-control" autocomplete="off"   >
      </div>

      <div class="col-lg-2 pl"><p id="fieldtype2">{{$objResponse->TYPE}} Challan No</p></div>
        <div class="col-lg-2 pl">
          <input {{$ActionStatus}} type="text" name="VENDOR_CHNO" id="VENDOR_CHNO" onkeyup="deleteDate('VENDOR_CHDT',this.value);" value="{{isset($objResponse->VENDOR_CHNO) && $objResponse->VENDOR_CHNO !=''?$objResponse->VENDOR_CHNO:''}}" maxlength="20"  class="form-control" autocomplete="off"   >
        </div>

      <div class="col-lg-2 pl"><p>Challan Date</p></div>
			<div class="col-lg-2 pl">
				<input {{$ActionStatus}} type="date" name="VENDOR_CHDT" id="VENDOR_CHDT" value="{{isset($objResponse->VENDOR_CHDT) && $objResponse->VENDOR_CHDT !=''?$objResponse->VENDOR_CHDT:''}}"  class="form-control" autocomplete="off"   >
      </div>
    </div>

    

    <div class="row">
      <div class="col-lg-2 pl"><p>Gate No</p></div>
      <div class="col-lg-2 pl">
        <input {{$ActionStatus}} type="text" name="GATE_NO" id="GATE_NO" value="{{isset($objResponse->GATE_NO) && $objResponse->GATE_NO !=''?$objResponse->GATE_NO:''}}" maxlength="15"  class="form-control" autocomplete="off"   >
      </div>

      <div class="col-lg-2 pl"><p>Gate Register No</p></div>
      <div class="col-lg-2 pl">
        <input {{$ActionStatus}} type="text" name="GATE_RGNO" id="GATE_RGNO"  onkeyup="deleteDate('DATE',this.value);"  value="{{isset($objResponse->GATE_RGNO) && $objResponse->GATE_RGNO !=''?$objResponse->GATE_RGNO:''}}" maxlength="15"  class="form-control" autocomplete="off"   >
      </div>

      <div class="col-lg-2 pl"><p>Date</p></div>
			<div class="col-lg-2 pl">
				  <input {{$ActionStatus}} type="date" name="DATE" id="DATE" value="{{isset($objResponse->DATE) && $objResponse->DATE !=''?$objResponse->DATE:''}}"  class="form-control" autocomplete="off"   >
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-2 pl"><p>BOE No</p></div>
      <div class="col-lg-2 pl">
        <input {{$ActionStatus}} type="text" name="BOE_NO" id="BOE_NO" value="{{isset($objResponse->BOE_NO) && $objResponse->BOE_NO !=''?$objResponse->BOE_NO:''}}" maxlength="30"  class="form-control" autocomplete="off"   >
      </div>
      <div class="col-lg-2 pl"><p>BOE Date</p></div>
			<div class="col-lg-2 pl">
				  <input {{$ActionStatus}} type="date" name="BOE_DATE" id="BOE_DATE"  class="form-control" value="{{isset($objResponse->BOE_DATE) && $objResponse->BOE_DATE !=''?$objResponse->BOE_DATE:''}}" autocomplete="off"   >
      </div>

      <div class="col-lg-2 pl"><p>Country of Origin</p></div>
      <div class="col-lg-2 pl">
      <input {{$ActionStatus}} type="text" name="COUNTRY_ORIGIN" id="COUNTRY_ORIGIN" value="{{isset($objResponse->COUNTRY_ORIGIN) && $objResponse->COUNTRY_ORIGIN !=''?$objResponse->COUNTRY_ORIGIN:''}}" maxlength="50"  class="form-control" autocomplete="off"   > 
    </div>
    </div>

    
    
    <div class="row">
      <div class="col-lg-2 pl"><p>Port detail</p></div>
      <div class="col-lg-2 pl">
        <input {{$ActionStatus}} type="text" name="PORT_DETAIL" id="PORT_DETAIL" maxlength="200" value="{{isset($objResponse->PORT_DETAIL) && $objResponse->PORT_DETAIL !=''?$objResponse->PORT_DETAIL:''}}"  class="form-control" autocomplete="off"   >
      </div>

      <div class="col-lg-2 pl"><p>Airway/Way Bill No.</p></div>
      <div class="col-lg-2 pl">
      <input {{$ActionStatus}} type="text" name="AIRBILL_NO" id="AIRBILL_NO" maxlength="30" value="{{isset($objResponse->AIRBILL_NO) && $objResponse->AIRBILL_NO !=''?$objResponse->AIRBILL_NO:''}}"  class="form-control" autocomplete="off"   > 
    </div>

    <div class="col-lg-2 pl"><p>Airway/Way Bill Date</p></div>
			<div class="col-lg-2 pl">
				  <input {{$ActionStatus}} type="date" name="AIRBILL_DATE" id="AIRBILL_DATE" value="{{isset($objResponse->AIR_DATE) && $objResponse->AIR_DATE !=''?$objResponse->AIR_DATE:''}}"  class="form-control" autocomplete="off"   >
      </div>

    </div>

    <div class="row">
      <div class="col-lg-2 pl"><p>Freight Terms</p></div>
      <div class="col-lg-2 pl">
        <input {{$ActionStatus}} type="text" name="FREIGHT_TERMS" id="FREIGHT_TERMS" value="{{isset($objResponse->FREIGHT_TERMS) && $objResponse->FREIGHT_TERMS !=''?$objResponse->FREIGHT_TERMS:''}}" maxlength="200"  class="form-control" autocomplete="off"   >
      </div>

      <div class="col-lg-2 pl"><p>Carrier Agent</p></div>
      <div class="col-lg-2 pl">
      <input {{$ActionStatus}} type="text" name="CARRIERF_AGENT" id="CARRIERF_AGENT" value="{{isset($objResponse->CARRIERF_AGENT) && $objResponse->CARRIERF_AGENT !=''?$objResponse->CARRIERF_AGENT:''}}" maxlength="200"  class="form-control" autocomplete="off"   > 
    </div>

    <div class="col-lg-2 pl"><p>E-way Bill No.</p></div>
			<div class="col-lg-2 pl">
      <input {{$ActionStatus}} type="text" name="EWAY_BILLNO" id="EWAY_BILLNO" value="{{isset($objResponse->EWAY_BILLNO) && $objResponse->EWAY_BILLNO !=''?$objResponse->EWAY_BILLNO:''}}" maxlength="30"  class="form-control" autocomplete="off"   > 
      </div>

    </div>

    <div class="row">
      <div class="col-lg-2 pl"><p>E-way bill Date</p></div>
      <div class="col-lg-2 pl">
      <input {{$ActionStatus}} type="date" name="EWAY_BILLDATE" id="EWAY_BILLDATE" value="{{isset($objResponse->EWAY_BILLDATE) && $objResponse->EWAY_BILLDATE !=''?$objResponse->EWAY_BILLDATE:''}}"  class="form-control" autocomplete="off"   >
      </div>

      <div class="col-lg-2 pl"><p>Total Boxes</p></div>
      <div class="col-lg-2 pl">
      <input {{$ActionStatus}} type="text" name="TOTAL_BOXES" onkeypress="return isNumberKey(event,this)" id="TOTAL_BOXES" value="{{isset($objResponse->TOTAL_BOXES) && $objResponse->TOTAL_BOXES !=''?$objResponse->TOTAL_BOXES:''}}" maxlength="15"  class="form-control" autocomplete="off"   > 
    </div>

    <div class="col-lg-2 pl"><p>Truck Seal No.</p></div>
			<div class="col-lg-2 pl">
      <input {{$ActionStatus}} type="text" name="TRUCK_SEAL_NO" id="TRUCK_SEAL_NO" value="{{isset($objResponse->TRUCK_SEAL_NO) && $objResponse->TRUCK_SEAL_NO !=''?$objResponse->TRUCK_SEAL_NO:''}}" maxlength="200"  class="form-control" autocomplete="off"   > 
      </div>

    </div>

    <div class="row">
      <div class="col-lg-2 pl"><p>Remarks</p></div>
      <div class="col-lg-2 pl">
        <input {{$ActionStatus}} type="text" name="REMARKS" id="REMARKS" value="{{isset($objResponse->REMARKS) && $objResponse->REMARKS !=''?$objResponse->REMARKS:''}}" maxlength="200"  class="form-control" autocomplete="off"   >
      </div>

      <div class="col-lg-2 pl"><p>Currency</p></div>
        <div class="col-lg-2 pl" id="divcurrency" >
            <input {{$ActionStatus}} type="text" name="CRID_popup" id="txtCRID_popup" value="{{isset($objResponse->CRCODE) && $objResponse->CRCODE !=''?$objResponse->CRCODE.'-'.$objResponse->CRDESCRIPTION:''}}" class="form-control"  autocomplete="off"  disabled/>
            <input {{$ActionStatus}} type="hidden" name="CRID_REF" id="CRID_REF" value="{{isset($objResponse->CRID_REF) && $objResponse->CRID_REF !=''?$objResponse->CRID_REF:''}}" class="form-control" autocomplete="off" />                                
        </div>

        <div class="col-lg-2 pl"><p>Conversion Factor</p></div>
        <div class="col-lg-2 pl">
            <input {{$ActionStatus}} type="text" name="CONVFACT" id="CONVFACT" autocomplete="off" value="{{isset($objResponse->CONVFACT) && $objResponse->CONVFACT !=''?$objResponse->CONVFACT:''}}" class="form-control" maxlength="100" />
        </div>
    </div>

	</div>

	<div class="container-fluid">

		<div class="row">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#Vehicle" id="VehicleTab">Vehicle</a></li>
        <li><a data-toggle="tab" href="#Unloading" id="UnloadingTab">Unloading</a></li>
				<li><a data-toggle="tab" href="#udf" id="udfTab" >UDF</a></li>
			</ul>
			
			<div class="tab-content">

				<div id="Vehicle" class="tab-pane fade in active">
          <div class="inner-form">
            <div class="row">
              <div class="col-lg-2 pl"><p>LR No</p></div>
              <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="LR_NO" id="LR_NO" onkeyup="deleteDate('LR_DT',this.value);" value="{{isset($objResponseVcl->LR_NO) && $objResponseVcl->LR_NO !=''?$objResponseVcl->LR_NO:''}}" maxlength="30" class="form-control" autocomplete="off" >
              </div>
          
              <div class="col-lg-2 pl"><p>LR Date</p></div>
              <div class="col-lg-2 pl">
                    <input {{$ActionStatus}} type="date" name="LR_DT" id="LR_DT" value="{{isset($objResponseVcl->LR_DT) && $objResponseVcl->LR_DT !=''?$objResponseVcl->LR_DT:''}}" class="form-control" autocomplete="off" >
              </div>

              <div class="col-lg-2 pl"><p>Primary Mode of Transport</p></div>
              <div class="col-lg-2 pl">
                <select {{$ActionStatus}}  name="TRANSPORT_MODE" id="TRANSPORT_MODE" class="form-control" autocomplete="off" >
                  <option value="">Select</option>
                  <option {{isset($objResponseVcl->TRANSPORT_MODE) && $objResponseVcl->TRANSPORT_MODE =='By Road'?'selected="selected"':''}} value="By Road">By Road</option>
                  <option {{isset($objResponseVcl->TRANSPORT_MODE) && $objResponseVcl->TRANSPORT_MODE =='By Sea'?'selected="selected"':''}} value="By Sea">By Sea</option>
                  <option {{isset($objResponseVcl->TRANSPORT_MODE) && $objResponseVcl->TRANSPORT_MODE =='By Air'?'selected="selected"':''}} value="By Air">By Air</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-2 pl"><p>Vehicle No</p></div>
              <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="VEHICLE_NO" id="VEHICLE_NO" value="{{isset($objResponseVcl->VEHICLE_NO) && $objResponseVcl->VEHICLE_NO !=''?$objResponseVcl->VEHICLE_NO:''}}" maxlength="30" class="form-control" autocomplete="off" >
              </div>
          
              <div class="col-lg-2 pl"><p>Vehicle Category</p></div>
              <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="VEHICLE_CAT" id="VEHICLE_CAT" value="{{isset($objResponseVcl->VEHICLE_CAT) && $objResponseVcl->VEHICLE_CAT !=''?$objResponseVcl->VEHICLE_CAT:''}}" maxlength="100" class="form-control" autocomplete="off" >
              </div>

              <div class="col-lg-2 pl"><p>Transporter</p></div>
              <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="TRANSPORTER_Details" id="TRANSPORTER_Details" value="{{isset($objTransporterName->TRANSPORTER_CODE) && $objTransporterName->TRANSPORTER_CODE !=''?$objTransporterName->TRANSPORTER_CODE.' - '.$objTransporterName->TRANSPORTER_NAME:''}}"  class="form-control"  autocomplete="off" readonly/>
                <input type="hidden" name="TRANSPORTER" id="TRANSPORTER" value="{{isset($objResponseVcl->TRANSPORTER) && $objResponseVcl->TRANSPORTER !=''?$objResponseVcl->TRANSPORTER:''}}" class="form-control" autocomplete="off" />
              </div>
            </div>

            <div class="row">
              <div class="col-lg-2 pl"><p>Driver Name</p></div>
              <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="DRIVER_NAME" id="DRIVER_NAME" value="{{isset($objResponseVcl->DRIVER_NAME) && $objResponseVcl->DRIVER_NAME !=''?$objResponseVcl->DRIVER_NAME:''}}" maxlength="100" class="form-control" autocomplete="off" >
              </div>
          
              <div class="col-lg-2 pl"><p>Weighment Machine</p></div>
              <div class="col-lg-2 pl">
                    <input {{$ActionStatus}} type="text" name="WEIGHMENT_MACHINE" id="WEIGHMENT_MACHINE" value="{{isset($objResponseVcl->WEIGHMENT_MACHINE) && $objResponseVcl->WEIGHMENT_MACHINE !=''?$objResponseVcl->WEIGHMENT_MACHINE:''}}" class="form-control" autocomplete="off" >
              </div>

              <div class="col-lg-2 pl"><p>Weighment Slip No</p></div>
              <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="WEIGHMENT_SLIP" id="WEIGHMENT_SLIP" value="{{isset($objResponseVcl->WEIGHMENT_SLIP) && $objResponseVcl->WEIGHMENT_SLIP !=''?$objResponseVcl->WEIGHMENT_SLIP:''}}"  maxlength="10"  class="form-control"  autocomplete="off"/>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-2 pl"><p>Gross Weight (KGS)</p></div>
              <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="GROSS_WEIGHT" id="GROSS_WEIGHT" onkeyup="weightCalculation();" value="{{isset($objResponseVcl->GROSS_WEIGHT) && $objResponseVcl->GROSS_WEIGHT !=''?$objResponseVcl->GROSS_WEIGHT:''}}" maxlength="50" onkeypress="return isNumberDecimalKey(event,this)" class="form-control" autocomplete="off" >
              </div>
          
              <div class="col-lg-2 pl"><p>Tare Weight (KGS)</p></div>
              <div class="col-lg-2 pl">
                    <input {{$ActionStatus}} type="text" name="TARE_WEIGHT" id="TARE_WEIGHT" onkeyup="weightCalculation();" value="{{isset($objResponseVcl->TARE_WEIGHT) && $objResponseVcl->TARE_WEIGHT !=''?$objResponseVcl->TARE_WEIGHT:''}}" maxlength="50" onkeypress="return isNumberDecimalKey(event,this)" class="form-control" autocomplete="off" >
              </div>

              <div class="col-lg-2 pl"><p>Net Weight (KGS)</p></div>
              <div class="col-lg-2 pl">
                <input {{$ActionStatus}} type="text" name="NET_WEIGHT" id="NET_WEIGHT" value="{{isset($objResponseVcl->NET_WEIGHT) && $objResponseVcl->NET_WEIGHT !=''?$objResponseVcl->NET_WEIGHT:''}}" maxlength="50" onkeypress="return isNumberDecimalKey(event,this)" class="form-control" autocomplete="off" readonly  >
              </div>
            </div>


          </div>

				</div>

        <div id="Unloading" class="tab-pane fade">	
          <div class="inner-form">
            <div class="row">
                <div class="col-lg-2 pl"><p>Unloading Bay No</p></div>
                <div class="col-lg-2 pl">
                  <input {{$ActionStatus}} type="text" name="UNL_BAYNO" id="UNL_BAYNO" value="{{isset($objResponseUnl->UNL_BAYNO) && $objResponseUnl->UNL_BAYNO !=''?$objResponseUnl->UNL_BAYNO:''}}" maxlength="30" class="form-control" autocomplete="off" >
                </div>
            
                <div class="col-lg-2 pl"><p>Stock Custodian</p></div>
                <div class="col-lg-2 pl">
                      <input {{$ActionStatus}} type="text" name="ST_CUSTODIAN" id="ST_CUSTODIAN" value="{{isset($objResponseUnl->ST_CUSTODIAN) && $objResponseUnl->ST_CUSTODIAN !=''?$objResponseUnl->ST_CUSTODIAN:''}}" class="form-control" autocomplete="off" >
                </div>

                <div class="col-lg-2 pl"><p>Unload Method</p></div>
                <div class="col-lg-2 pl">
                  <input {{$ActionStatus}} type="text" name="UNL_METHOD" id="UNL_METHOD" value="{{isset($objResponseUnl->UNL_METHOD) && $objResponseUnl->UNL_METHOD !=''?$objResponseUnl->UNL_METHOD:''}}" maxlength="100"  class="form-control"  autocomplete="off"/>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-2 pl"><p>Primary Packing Type</p></div>
                <div class="col-lg-2 pl">
                  
                  <input {{$ActionStatus}} type="text" name="PTID_REF_Details" id="PTID_REF_Details" value="{{isset($objPackingName->PTCODE) && $objPackingName->PTCODE !=''?$objPackingName->PTCODE.' - '.$objPackingName->PTNAME:''}}" class="form-control"   autocomplete="off" readonly/>
                    <input type="hidden" name="PTID_REF" id="PTID_REF" value="{{isset($objResponseUnl->PTID_REF) && $objResponseUnl->PTID_REF !=''?$objResponseUnl->PTID_REF:''}}" class="form-control" autocomplete="off" />
                </div>
            
                <div class="col-lg-2 pl"><p>No of Packing</p></div>
                <div class="col-lg-2 pl">
                      <input {{$ActionStatus}} type="text" name="PACKING_NO" id="PACKING_NO" value="{{isset($objResponseUnl->PACKING_NO) && $objResponseUnl->PACKING_NO !=''?$objResponseUnl->PACKING_NO:''}}" onkeypress="return isNumberDecimalKey(event,this)" class="form-control" autocomplete="off" >
                </div>

                <div class="col-lg-2 pl"><p>Primary Packaging Condition</p></div>
                <div class="col-lg-2 pl">
                  <input {{$ActionStatus}} type="text" name="PACKING_CONDITION" id="PACKING_CONDITION"  value="{{isset($objResponseUnl->PACKING_CONDITION) && $objResponseUnl->PACKING_CONDITION !=''?$objResponseUnl->PACKING_CONDITION:''}}" maxlength="200"  class="form-control"  autocomplete="off"/>
                </div>
              </div>
          </div>
				</div>

				<div id="udf" class="tab-pane fade">
					<div class="table-responsive table-wrapper-scroll-y " style="margin-top:10px;height:280px;width:50%;">
						<table id="example3" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
							<thead id="thead1"  style="position: sticky;top: 0">
							  <tr >
								<th>UDF Fields<input class="form-control" type="hidden" name="Row_Count2" id ="Row_Count2"></th>
								<th>Value / Comments</th>
								<th>Action</th>
							  </tr>
							</thead>
							<tbody>
              @foreach($objUDF as $uindex=>$uRow)
                <tr  class="participantRow3">
                    <td><input {{$ActionStatus}} type="text" name={{"popupSEID_".$uindex}} id={{"popupSEID_".$uindex}} class="form-control" value="{{$uRow->UDF}}" autocomplete="off"  readonly/></td>
                    <td hidden><input type="hidden" name={{"UDF_".$uindex}} id={{"UDF_".$uindex}} class="form-control" value="{{$uRow->UDF}}" autocomplete="off"   /></td>
                    <td hidden><input type="hidden" name={{"UDFismandatory_".$uindex}} id={{"UDFismandatory_".$uindex}} value="{{$uRow->UDF}}" class="form-control"   autocomplete="off" /></td>
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
				
			</div>
		</div>
		
	</div>
	
</div>

</form>
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
        </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>


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

<div id="PO_NO_Modal" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='PO_NO_Modal_Close' >&times;</button>
      </div>
      <div class="modal-body">
	      <div class="tablename"><p>PO/RGP/IPO/BPO No</p></div>
	      <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
          <table id="PO_NO_Table" class="display nowrap table  table-striped table-bordered">
            <thead>
              <tr>
                <th class="ROW1">Select</th> 
                <th class="ROW2">PO/RGP/IPO/BPO No</th>
                <th class="ROW3">PO/RGP/IPO/BPO Date</th>
              </tr>
            </thead>
            <tbody>

              <tr>
                <th class="ROW1"><span class="check_th">&#10004;</span></th>
                <td class="ROW2"><input type="text" id="PO_NO_Code_Search" class="form-control" autocomplete="off" onkeyup="PO_NO_Code_Function()"></td>
                <td class="ROW3"><input type="text" id="PO_NO_Name_Search" class="form-control" autocomplete="off" onkeyup="PO_NO_Name_Function()"></td>
              </tr>

            </tbody>
            </table>
            <table id="PO_NO_Table2" class="display nowrap table  table-striped table-bordered" >
              <thead id="thead2">          
              </thead>
              <tbody id="PO_NO_Body" >
              </tbody>
            </table>
          </div>
		    <div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<div id="TRANSPORTER_Modal" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='TRANSPORTER_Modal_Close' >&times;</button>
      </div>
      <div class="modal-body">
	      <div class="tablename"><p> Transporter</p></div>
	      <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
          <table id="TRANSPORTER_Table" class="display nowrap table  table-striped table-bordered" >
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
                <td class="ROW2"><input type="text" id="TRANSPORTER_Code_Search" class="form-control" autocomplete="off" onkeyup="TRANSPORTER_Code_Function()"></td>
                <td class="ROW3"><input type="text" id="TRANSPORTER_Name_Search" class="form-control" autocomplete="off" onkeyup="TRANSPORTER_Name_Function()"></td>
              </tr>
            </tbody>
            </table>
            <table id="TRANSPORTER_Table2" class="display nowrap table  table-striped table-bordered">
              <thead id="thead2">          
              </thead>
              <tbody>
              @foreach ($objTransporterList as $key=>$val)
              <tr >
                <td class="ROW1"> <input type="checkbox" name="SELECT_TRANSPORTER[]" id="TRANSPORTER_TDID_{{ $key }}" class="TRANSPORTER_Row" value="{{ $val-> TRANSPORTERID }}" ></td>
                <td class="ROW2" >{{ $val-> TRANSPORTER_CODE }} <input type="hidden" id="txtTRANSPORTER_TDID_{{ $key }}" data-desc="{{ $val-> TRANSPORTER_CODE }} - {{ $val-> TRANSPORTER_NAME }}"  value="{{ $val-> TRANSPORTERID }}"/></td>
                <td class="ROW3">{{ $val-> TRANSPORTER_NAME }}</td>
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

<div id="PTID_REF_Modal" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='PTID_REF_Modal_Close' >&times;</button>
      </div>
      <div class="modal-body">
	      <div class="tablename"><p> Primary Packing Type</p></div>
	      <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
          <table id="PTID_REF_Table" class="display nowrap table  table-striped table-bordered" >
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
                <td class="ROW2"><input type="text" id="PTID_REF_Code_Search" class="form-control" autocomplete="off" onkeyup="PTID_REF_Code_Function()"></td>
                <td class="ROW3"><input type="text" id="PTID_REF_Name_Search" class="form-control" autocomplete="off" onkeyup="PTID_REF_Name_Function()"></td>
              </tr>

            </tbody>
            </table>
            <table id="PTID_REF_Table2" class="display nowrap table  table-striped table-bordered" >
              <thead id="thead2">          
              </thead>
              <tbody>
              @foreach ($objPackingList as $key=>$val)
              <tr >
                <td class="ROW1"> <input type="checkbox" name="SELECT_PTID_REF[]" id="PTID_REF_TDID_{{ $key }}" class="PTID_REF_Row" value="{{ $val-> PTID }}" ></td>
                <td class="ROW2" >{{ $val-> PTCODE }} <input type="hidden" id="txtPTID_REF_TDID_{{ $key }}" data-desc="{{ $val-> PTCODE }} - {{ $val-> PTNAME }}"  value="{{ $val-> PTID }}"/></td>
                <td class="ROW3">{{ $val-> PTNAME }}</td>
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

<div id="EMPLOYEE_popup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='EMPLOYEE_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Employee</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="EmployeeTable" class="display nowrap table  table-striped table-bordered" >
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
        <td class="ROW2"><input type="text" id="Employeecodesearch" class="form-control" autocomplete="off" onkeyup="EmployeeCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="Employeenamesearch" class="form-control" autocomplete="off" onkeyup="EmployeeNameFunction()"></td>
      </tr>

    </tbody>
    </table>
      <table id="EmployeeTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2">
          
        </thead>
        <tbody >     
        @foreach ($Employee as $key=>$val)
        <tr >
          <td class="ROW1"> <input type="checkbox" name="SELECT_EMPLOYEE[]" id="spidcode_{{ $key }}" class="clssemployee" value="{{ $val-> EMPID }}" ></td>  
          <td class="ROW2">{{ $val-> EMPCODE }} <input type="hidden" id="txtspidcode_{{ $key }}" data-desc="{{ $val-> EMPCODE }} - {{ $val-> FNAME }}  {{ $val-> LNAME }}"  value="{{ $val-> EMPID }}"/></td>
          <td class="ROW3">{{ $val-> FNAME }} {{ $val-> MNAME }} {{ $val-> LNAME }}</td>
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
@endsection

@push('bottom-css')
<style>
.errormsg{
  color:red;
}
.text-danger{
  color:red !important;
}
#custom_dropdown, #udfforsemst_filter {
    display: inline-table;
    margin-left: 15px;
}


#VID_REF_Code_Search {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  font-size: 11px;
  padding: 5px 5px 5px 5px;
  border: 1px solid #ddd;
  margin-bottom: 5px;
}
#VID_REF_Name_Search {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  font-size: 11px;
  padding: 5px 5px 5px 5px;
  border: 1px solid #ddd;
  margin-bottom: 5px;
}
#VID_REF_GL_Search {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  font-size: 11px;
  padding: 5px 5px 5px 5px;
  border: 1px solid #ddd;
  margin-bottom: 5px;
}
#VID_REF_Country_Search {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  font-size: 11px;
  padding: 5px 5px 5px 5px;
  border: 1px solid #ddd;
  margin-bottom: 5px;
}
#VID_REF_State_Search {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  font-size: 11px;
  padding: 5px 5px 5px 5px;
  border: 1px solid #ddd;
  margin-bottom: 5px;
}
#VID_REF_City_Search {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  font-size: 11px;
  padding: 5px 5px 5px 5px;
  border: 1px solid #ddd;
  margin-bottom: 5px;
}

#VID_REF_Table {
  border-collapse: collapse;
  width: 950px;
  border: 1px solid #ddd;
  font-size: 11px;
}

#VID_REF_Table th {
    text-align: center;
    padding: 5px;
  
    font-size: 11px;
   
    color: #0f69cc;
    font-weight: 600;
}

#VID_REF_Table td {
    text-align: center;
    padding: 5px;
    font-size: 11px;
   
    font-weight: 600;
}

#VID_REF_Table2 {
  border-collapse: collapse;
  width: 950px;
  border: 1px solid #ddd;
  font-size: 11px;
}

#VID_REF_Table2 th{
    text-align: left;
    padding: 5px;
  
    font-size: 11px;
   
    color: #0f69cc;
    font-weight: 600;
}

#VID_REF_Table2 td {
  text-align: left;
    padding: 5px;
    font-size: 11px;
    
    font-weight: 600;
    width: 16%;
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

// START VENDOR CODE FUNCTION
let vdtid = "#VendorCodeTable2";
let vdtid2 = "#VendorCodeTable";
let vdheaders = document.querySelectorAll(vdtid2 + " th");

      
vdheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(vdtid, ".clsvendorid", "td:nth-child(" + (i + 1) + ")");
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
      bindVendEvents();
      showSelectedCheck($("#VID_REF").val(),"SELECT_VID_REF"); 
    },
    error:function(data){
    console.log("Error: Something went wrong.");
    $("#tbody_vendor").html('');                        
    },
  });
}




$('#VID_REF_Details').click(function(event){

  var TYPE  = $("#TYPE").val();

  if(TYPE ==='Vendor'){
    var CODE = ''; 
    var NAME = ''; 
    loadVendor(CODE,NAME);  
    $("#vendoridpopup").show();
  }
  else if(TYPE ==='Customer'){
    var CODE = ''; 
    var NAME = ''; 
    loadCustomer(CODE,NAME);
    $("#customer_popus").show();
  }
  else if(TYPE ==='Employee'){
    showSelectedCheck($("#EMPLOYEE").val(),"SELECT_EMPLOYEE");
    $("#EMPLOYEE_popup").show();
  }

  event.preventDefault();
});

$("#vendor_close_popup").click(function(event){
  $("#vendoridpopup").hide();
  event.preventDefault();
});

function bindVendEvents(){

  $(".clsvendorid").click(function(){
    var fieldid = $(this).attr('id');
    var txtval =    $("#txt"+fieldid+"").val();
    var texdesc =   $("#txt"+fieldid+"").data("desc");
    
    $('#VID_REF_Details').val(texdesc);
    $('#VID_REF').val(txtval);
    $("#vendoridpopup").hide();
    $("#VID_REF_Code_Search").val(''); 
    $("#VID_REF_Name_Search").val(''); 

    $('#PO_NO_Details').val('');
    $('#PO_NO').val('');
    $("#PO_NO_Body").html('');
    $('#VENDOR_BILLNO').val('');
    $('#VENDOR_BILLDT').val('');
    $('#VENDOR_CHNO').val('');
    $('#VENDOR_CHDT').val('');

    $("#vendoridpopup").hide();
    $("#vendor_codesearch").val(''); 
    $("#vendor_namesearch").val(''); 
   
    event.preventDefault();
  });

}



function PoRgpType(type){
  $("#TYPE").prop("selectedIndex", 0);
  $("#TYPE option[value='Customer']").prop('disabled',true);
  $("#TYPE option[value='Employee']").prop('disabled',true);
  $("#VID_REF_Details").val('');
  $("#VID_REF").val('');
  $("#PO_NO_Details").val('');
  $("#PO_NO").val('');
  
  if(type =="PO"){
    if($("#PO").prop("checked") == true){
      $("#RGP").prop("checked", false);
      $("#IPO").prop("checked", false);
      $("#BPO").prop("checked", false);
    }
  }
  else if(type =="RGP"){
    if($("#RGP").prop("checked") == true){
      $("#PO").prop("checked", false);
      $("#IPO").prop("checked", false);
      $("#BPO").prop("checked", false);

      $("#TYPE option[value='Customer']").prop('disabled',false);
      $("#TYPE option[value='Employee']").prop('disabled',false);
    }
  }
  else if(type =="IPO"){
    if($("#IPO").prop("checked") == true){
      $("#RGP").prop("checked", false);
      $("#PO").prop("checked", false);
      $("#BPO").prop("checked", false);
    }
  }
  else if(type =="BPO"){
    if($("#BPO").prop("checked") == true){
      $("#RGP").prop("checked", false);
      $("#PO").prop("checked", false);
      $("#IPO").prop("checked", false);
    }
  }
}

function getPoRgp(Type,VID_REF,CTYPE){
    $("#PO_NO_Body").html('');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:'{{route("transaction",[$FormId,"getPoRgp"])}}',
        type:'POST',
        data:{Type:Type,VID_REF:VID_REF,CTYPE:CTYPE,value:'{{isset($objResponse->PO_NO) && $objResponse->PO_NO !=''?$objResponse->PO_NO:''}}'},
        success:function(data) {
          $("#PO_NO_Body").html(data);  
          bind_PO_NO_Events();               
        },
        error:function(data){
          console.log("Error: Something went wrong.");
          $("#PO_NO_Body").html('');                        
        },
    }); 

}

//PO NO

let PO_NO_tid = "#PO_NO_Table2";
let PO_NO_tid2 = "#PO_NO_Table";
let PO_NO_headers = document.querySelectorAll(PO_NO_tid2 + " th");

PO_NO_headers.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(PO_NO_tid, ".PO_NO_Row", "td:nth-child(" + (i + 1) + ")");
  });
});

function PO_NO_Code_Function() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("PO_NO_Code_Search");
  filter = input.value.toUpperCase();
  table = document.getElementById("PO_NO_Table2");
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

function PO_NO_Name_Function() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("PO_NO_Name_Search");
      filter = input.value.toUpperCase();
      table = document.getElementById("PO_NO_Table2");
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

$('#PO_NO_Details').click(function(event){
  $(".errormsg").remove();
  var TYPE    = $("#TYPE").val();
  var VID_REF = $("#VID_REF").val();
  var GETYPE  = $.trim($('input[name="GETYPE"]:checked').val()); 
   
  if(TYPE ===""){
    $("#TYPE").focus();
    $("#TYPE").after('<span  class="errormsg">Please Select Type</span>');
    return false;
  }
  else if(VID_REF ===""){
    $("#VID_REF_Details").focus();
    $("#VID_REF_Details").after('<span  class="errormsg">Please Select '+TYPE+'</span>');
    return false;
  }
  else if(GETYPE ===""){
    $("#VENDOR_BILLDT").before('<span  class="errormsg">Select PO/RGP/IPO/BPO</span>');
    return false;
  }
  else{
    getPoRgp(GETYPE,VID_REF,TYPE);
    $("#PO_NO_Modal").show();
  }
  event.preventDefault();
});

$("#PO_NO_Modal_Close").click(function(event){
  $("#PO_NO_Modal").hide();
  event.preventDefault();
});

function bind_PO_NO_Events(){
  $(".PO_NO_CHECK").change(function(){

    var txtval   = [];
    var texdesc  = [];
    
    $('#PO_NO_Table2').find('.PO_NO_Row').each(function(){
      var text_id     = $.trim($(this).find("[id*=txtPO_NO_TDID]").val());
      var text_attr   = $.trim($(this).find("[id*=txtPO_NO_TDID]").attr('id'));
      var text_check  = $.trim($(this).find("[id*=txtPO_NO_CHECK]").attr('id'));
      var text_des    =   $("#"+text_attr).data("desc");

      if($("#"+text_check).prop("checked") == true){
        txtval.push(text_id);
        texdesc.push(text_des);
      }
     
    });

    $('#PO_NO_Details').val(texdesc);
    $('#PO_NO').val(txtval);
    $("#PO_NO_Code_Search").val(''); 
    $("#PO_NO_Name_Search").val('');    
    event.preventDefault();
  });

  $(".PO_NO_CHECK").change(function() {    
    if ($(this).is(":checked") == true){
      var fieldid = $(this).attr('id');
      var desfc       =  $("#"+fieldid).data("desfc");
      if(desfc==1){
      var currency_id       =  $("#"+fieldid).data("descrefid");
      var currencyName      =  $("#"+fieldid).data("descyname");
      var ConversionFactor  =  $("#"+fieldid).data("desconvrnftor");
      $('#CRID_REF').val(currency_id);
      $('#txtCRID_popup').val(currencyName);
      $('#CONVFACT').val(ConversionFactor); 
      $('#CONVFACT').prop('readonly',false);
      }else if(desfc ===""){
      $('#CRID_REF').val('');
      $('#txtCRID_popup').val('');
      $('#CONVFACT').val(''); 
      $('#CONVFACT').prop('readonly',false);
      }else{
        $('#PO_NO_Details').val('');
        $('#PO_NO').val('');
        $('#CRID_REF').val('');
        $('#txtCRID_popup').val('');
        $('#CONVFACT').val('');
        $('#CONVFACT').prop('readonly',true);
        $("#PO_NO_Modal").hide();
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").show();
        $("#AlertMessage").text('You Can Select Same Currency PO');
        $("#alert").modal('show');
        $("#OkBtn1").focus();
      }         
    }
  });

}

//TRANSPORTER

let TRANSPORTER_tid = "#TRANSPORTER_Table2";
let TRANSPORTER_tid2 = "#TRANSPORTER_Table";
let TRANSPORTER_headers = document.querySelectorAll(TRANSPORTER_tid2 + " th");

TRANSPORTER_headers.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(TRANSPORTER_tid, ".TRANSPORTER_Row", "td:nth-child(" + (i + 1) + ")");
  });
});

function TRANSPORTER_Code_Function() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("TRANSPORTER_Code_Search");
  filter = input.value.toUpperCase();
  table = document.getElementById("TRANSPORTER_Table2");
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

function TRANSPORTER_Name_Function() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("TRANSPORTER_Name_Search");
      filter = input.value.toUpperCase();
      table = document.getElementById("TRANSPORTER_Table2");
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

$('#TRANSPORTER_Details').click(function(event){
  showSelectedCheck($("#TRANSPORTER").val(),"SELECT_TRANSPORTER");
  $("#TRANSPORTER_Modal").show();
  event.preventDefault();
});

$("#TRANSPORTER_Modal_Close").click(function(event){
  $("#TRANSPORTER_Modal").hide();
  event.preventDefault();
});

$(".TRANSPORTER_Row").click(function(){
  
  var fieldid = $(this).attr('id');
  var txtval =    $("#txt"+fieldid+"").val();
  var texdesc =   $("#txt"+fieldid+"").data("desc");

  $('#TRANSPORTER_Details').val(texdesc);
  $('#TRANSPORTER').val(txtval);
  $("#TRANSPORTER_Modal").hide();
  $("#TRANSPORTER_Code_Search").val(''); 
  $("#TRANSPORTER_Name_Search").val(''); 

  event.preventDefault();
});

//Packing Type 

let PTID_REF_tid = "#PTID_REF_Table2";
let PTID_REF_tid2 = "#PTID_REF_Table";
let PTID_REF_headers = document.querySelectorAll(PTID_REF_tid2 + " th");

PTID_REF_headers.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(PTID_REF_tid, ".PTID_REF_Row", "td:nth-child(" + (i + 1) + ")");
  });
});

function PTID_REF_Code_Function() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("PTID_REF_Code_Search");
  filter = input.value.toUpperCase();
  table = document.getElementById("PTID_REF_Table2");
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

function PTID_REF_Name_Function() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("PTID_REF_Name_Search");
      filter = input.value.toUpperCase();
      table = document.getElementById("PTID_REF_Table2");
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

$('#PTID_REF_Details').click(function(event){
  showSelectedCheck($("#PTID_REF").val(),"SELECT_PTID_REF");
  $("#PTID_REF_Modal").show();
  event.preventDefault();
});

$("#PTID_REF_Modal_Close").click(function(event){
  $("#PTID_REF_Modal").hide();
  event.preventDefault();
});

$(".PTID_REF_Row").click(function(){
  
  var fieldid = $(this).attr('id');
  var txtval =    $("#txt"+fieldid+"").val();
  var texdesc =   $("#txt"+fieldid+"").data("desc");

  $('#PTID_REF_Details').val(texdesc);
  $('#PTID_REF').val(txtval);
  $("#PTID_REF_Modal").hide();
  $("#PTID_REF_Code_Search").val(''); 
  $("#PTID_REF_Name_Search").val(''); 
 
  event.preventDefault();
});


$(document).ready(function(e) {
var Material = $("#Material").html(); 
$('#hdnmaterial').val(Material);
// var lastdt = <?php echo json_encode(isset($objResponse->GE_DT)?$objResponse->GE_DT:''); ?>;
// var today = new Date(); 
// var sodate = <?php echo json_encode(isset($objResponse->GE_DT)?$objResponse->GE_DT:''); ?>;
// $('#GE_DT').attr('min',lastdt);
// $('#GE_DT').attr('max',sodate);

var lastdt = <?php echo json_encode($objlastdt[0]->GE_DT); ?>;
  var ge = <?php echo json_encode($objResponse); ?>;
  var today = new Date(); 
  var sodate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2);
  if(lastdt < ge.GE_DT)
  {
	$('#GE_DT').attr('min',lastdt);
  }
  else
  {
	  $('#GE_DT').attr('min',ge.GE_DT);
  }
  $('#GE_DT').attr('max',sodate);

var seudf = <?php echo json_encode($objUdfData); ?>;
var count2 = <?php echo json_encode($objCountUDF); ?>;

$('#example3').find('.participantRow3').each(function(){
      var txt_id4 = $(this).find('[id*="udfinputid"]').attr('id');
      var udfid = $(this).find('[id*="UDF"]').val();

      $.each( seudf, function( seukey, seuvalue ) {
        if(seuvalue.UDFGEID == udfid)
        {

          var txtvaltype2 =   seuvalue.VALUETYPE;
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
          var txtoptscombo2 =   seuvalue.DESCRIPTIONS;
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


var count2 = <?php echo json_encode($objCount2); ?>;
$('#Row_Count2').val(count2);

var soudf = <?php echo json_encode($objUDF); ?>;
var udfforse = <?php echo json_encode($objUdfData2); ?>;
$.each( soudf, function( soukey, souvalue ) {

    $.each( udfforse, function( usokey, usovalue ) { 
        if(souvalue.UDF == usovalue.UDFGEID)
        {
            $('#popupSEID_'+soukey).val(usovalue.LABEL);
        }
    
        if(souvalue.UDF == usovalue.UDFGEID){        
                var txtvaltype2 =   usovalue.VALUETYPE;
                var txt_id41 = $('#udfinputid_'+soukey).attr('id');
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
                    if(souvalue.SOUVALUE == "1")
                    {
                    strinp2 = '<input {{$ActionStatus}} type="checkbox" name="'+dynamicid2+ '" id="'+dynamicid2+'" class="" checked> ';
                    }
                    else{
                    strinp2 = '<input {{$ActionStatus}} type="checkbox" name="'+dynamicid2+ '" id="'+dynamicid2+'" class="" > ';
                    }
                }
                else if(chkvaltype2=='combobox'){

                var txtoptscombo2 =   usovalue.DESCRIPTIONS;
                var strarray2 = txtoptscombo2.split(',');
                var opts2 = '';

                for (var i = 0; i < strarray2.length; i++) {
                    opts2 = opts2 + '<option value="'+strarray2[i]+'">'+strarray2[i]+'</option> ';
                }

                strinp2 = '<select {{$ActionStatus}} name="'+dynamicid2+ '" id="'+dynamicid2+'" class="form-control" required>'+opts2+'</select>' ;
                
                }
                
                
                $('#'+txt_id41).html('');  
                $('#'+txt_id41).html(strinp2);   
                $('#'+dynamicid2).val(souvalue.COMMENT);
                $('#UDFismandatory_'+soukey).val(usovalue.ISMANDATORY);
            
        }
    });
  
});


$(function() { 
  
  getPoRgp("{{isset($objResponse->GETYPE) && $objResponse->GETYPE !=''?$objResponse->GETYPE:''}}","{{isset($objResponse->VID_REF) && $objResponse->VID_REF !=''?$objResponse->VID_REF:''}}","{{isset($objResponse->TYPE) && $objResponse->TYPE !=''?$objResponse->TYPE:''}}")
});



$('#btnAdd').on('click', function() {
  var viewURL = '{{route("transaction",[$FormId,"add"])}}';
              window.location.href=viewURL;
});

$('#btnExit').on('click', function() {
  var viewURL = '{{route('home')}}';
              window.location.href=viewURL;
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
    window.location.reload();
}

window.fnUndoNo = function (){
   
}

function growTextarea (i,elem) {
    var elem = $(elem);
    var resizeTextarea = function( elem ) {
        var scrollLeft = window.pageXOffset || (document.documentElement || document.body.parentNode || document.body).scrollLeft;
        var scrollTop  = window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop;  
        elem.css('height', 'auto').css('height', elem.prop('scrollHeight') );
        window.scrollTo(scrollLeft, scrollTop);
    };

    elem.on('input', function() {
        resizeTextarea( $(this) );
    });
    resizeTextarea( $(elem) );
    }
    $('.growTextarea').each(growTextarea);
});
</script>

@endpush

@push('bottom-scripts')
<script>

$(document).ready(function() {
    var d = new Date(); 
    var today = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;

    $('#frm_trn_edit1').bootstrapValidator({
       
        fields: {
            txtlabel: {
                validators: {
                    notEmpty: {
                        message: 'The GE No is required'
                    }
                }
            },            
        },
        submitHandler: function(validator, form, submitButton) {
            alert( "Handler for .submit() called." );
             event.preventDefault();
             $("#frm_trn_edit").submit();
        }
    });
});


$( "#btnSaveSE" ).click(function() {
    var formReqData = $("#frm_trn_edit");
    if(formReqData.valid()){
      validateForm('fnSaveData');
    }
});

$( "#btnApprove" ).click(function() {
    var formReqData = $("#frm_trn_edit");
    if(formReqData.valid()){
      validateForm('fnApproveData');
    }
});


$("#YesBtn").click(function(){

$("#alert").modal('hide');
var customFnName = $("#YesBtn").data("funcname");
    window[customFnName]();

});

window.fnSaveData = function (){
event.preventDefault();
      var trnFormReq = $("#frm_trn_edit");
      var formData = trnFormReq.serialize();
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $("#btnSaveSE").hide(); 
  $(".buttonload").show(); 
  $("#btnApprove").prop("disabled", true);
  $.ajax({
      url:'{{ route("transactionmodify",[$FormId,"update"])}}',
      type:'POST',
      data:formData,
      success:function(data) {
        $(".buttonload").hide(); 
        $("#btnSaveSE").show();   
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
                ("#YesBtn").hide();
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
        $("#btnSaveSE").show();   
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
event.preventDefault();
      var trnFormReq = $("#frm_trn_edit");
      var formData = trnFormReq.serialize();
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $("#btnApprove").hide(); 
  $(".buttonload_approve").show();  
  $("#btnSaveSE").prop("disabled", true);
  $.ajax({
      url:'{{ route("transactionmodify",[$FormId,"Approve"])}}',
      type:'POST',
      data:formData,
      success:function(data) {
        $("#btnApprove").show();  
        $(".buttonload_approve").hide();  
        $("#btnSaveSE").prop("disabled", false);
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
                ("#YesBtn").hide();
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
        $("#btnApprove").show();  
        $(".buttonload_approve").hide();  
        $("#btnSaveSE").prop("disabled", false);
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

function validateForm(actionType){
 
  $(".errormsg").remove();
  $("#FocusId").val('');
  var GE_NO         =   $.trim($("#GE_NO").val());
  var GE_DT         =   $.trim($("#GE_DT").val());
  var GE_TM         =   $.trim($("#GE_TM").val());
  var VID_REF       =   $.trim($("#VID_REF").val());
  var PO_NO         =   $.trim($("#PO_NO").val());
  var VENDOR_BILLNO =   $.trim($("#VENDOR_BILLNO").val());
  var VENDOR_BILLDT =   $.trim($("#VENDOR_BILLDT").val());
  var VENDOR_CHNO   =   $.trim($("#VENDOR_CHNO").val());
  var VENDOR_CHDT   =   $.trim($("#VENDOR_CHDT").val());
  var GATE_RGNO     =   $.trim($("#GATE_RGNO").val());
  var DATE          =   $.trim($("#DATE").val());
  var LR_NO         =   $.trim($("#LR_NO").val());
  var LR_DT         =   $.trim($("#LR_DT").val());
  var GROSS_WEIGHT  =   $.trim($("#GROSS_WEIGHT").val());
  var TARE_WEIGHT   =   $.trim($("#TARE_WEIGHT").val());
  var NET_WEIGHT    =   $.trim($("#NET_WEIGHT").val());


  var GETYPE        =   $.trim($('input[name="GETYPE"]:checked').val());
  var TYPE          =   $.trim($("#TYPE").val());
 // alert($('input[name="GETYPE"]:checked').val());


  //alert(GETYPE); 

  var BOE_NO    =   $.trim($("#BOE_NO").val());
  var BOE_DATE    =   $.trim($("#BOE_DATE").val());
  var COUNTRY_ORIGIN    =   $.trim($("#COUNTRY_ORIGIN").val());
  var PORT_DETAIL    =   $.trim($("#PORT_DETAIL").val());
  var AIRBILL_NO    =   $.trim($("#AIRBILL_NO").val());
  var AIRBILL_DATE    =   $.trim($("#AIRBILL_DATE").val());
  var FREIGHT_TERMS    =   $.trim($("#FREIGHT_TERMS").val());
  var CARRIERF_AGENT    =   $.trim($("#CARRIERF_AGENT").val());
  var TOTAL_BOXES    =   $.trim($("#TOTAL_BOXES").val());
  var EWAY_BILLDATE    =   $.trim($("#EWAY_BILLDATE").val());
  var EWAY_BILLNO    =   $.trim($("#EWAY_BILLNO").val());
  var TRUCK_SEAL_NO    =   $.trim($("#TRUCK_SEAL_NO").val());

  if(GE_NO ===""){
     $("#FocusId").val($("#GE_NO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('GE No is required.');
     $("#alert").modal('show')
     $("#OkBtn1").focus();
     return false;
  }
  else if(GE_DT ===""){
    $("#GE_DT").focus();
    $("#GE_DT").after('<span  class="errormsg">Select GE Date.</span>');
    return false;
  }
  else if(GE_TM ===""){
    $("#GE_TM").focus();
    $("#GE_TM").after('<span  class="errormsg">Select GE Time.</span>');
    return false;
  }  
  else if(VID_REF ===""){
    $("#VID_REF").focus();
    $("#VID_REF").after('<span  class="errormsg">Select '+TYPE+' name.</span>');
    return false;
  }
  else if(PO_NO ===""){
    $("#PO_NO").focus();
    $("#PO_NO").after('<span  class="errormsg">Select PO/RGP No.</span>');
    return false;
  }
  else if(VENDOR_BILLNO ===""){
    $("#VENDOR_BILLNO").focus();
    $("#VENDOR_BILLNO").after('<span  class="errormsg">Select '+TYPE+' Bill No.</span>');
    return false;
  }
  else if(checkDuplicateVendorBillNo(VENDOR_BILLNO,'save') ===true){
    $("#VENDOR_BILLNO").focus();
    $("#VENDOR_BILLNO").after('<span  class="errormsg">'+TYPE+' Bill No already exists.</span>');
    return false;
  }
  else if(VENDOR_BILLNO !="" && VENDOR_BILLDT ===""){
    $("#VENDOR_BILLDT").focus();
    $("#VENDOR_BILLDT").after('<span  class="errormsg">Select bill date.</span>');
    return false;
  }
  else if(VENDOR_CHNO !="" && VENDOR_CHDT ===""){
    $("#VENDOR_CHDT").focus();
    $("#VENDOR_CHDT").after('<span  class="errormsg">Select challan date.</span>');
    return false;
  }
  
  else if(GATE_RGNO !="" && DATE ===""){
    $("#DATE").focus();
    $("#DATE").after('<span  class="errormsg">Select date.</span>');
    return false;
  }

  //ADDITIONAL FIELDS VALIDATION

  else if(GETYPE =="IPO" && BOE_NO ===""){
    $("#BOE_NO").focus();
    $("#BOE_NO").after('<span  class="errormsg">Please Enter BOE No.</span>');
    return false;
  }
  else if(GETYPE =="IPO" && BOE_DATE ===""){
    $("#BOE_DATE").focus();
    $("#BOE_DATE").after('<span  class="errormsg">Please select BOE Date.</span>');
    return false;
  }
  else if(GETYPE =="IPO" && COUNTRY_ORIGIN ===""){
    $("#COUNTRY_ORIGIN").focus();
    $("#COUNTRY_ORIGIN").after('<span  class="errormsg">Please enter Origin of Country.</span>');
    return false;
  }
  else if(GETYPE =="IPO" && PORT_DETAIL ===""){
    $("#PORT_DETAIL").focus();
    $("#PORT_DETAIL").after('<span  class="errormsg">Please Enter Port Detail.</span>');
    return false;
  }
  else if(GETYPE =="IPO" && AIRBILL_NO ===""){
    $("#AIRBILL_NO").focus();
    $("#AIRBILL_NO").after('<span  class="errormsg">Please Enter Airway/Way Bill No.</span>');
    return false;
  }
  else if(GETYPE =="IPO" && AIRBILL_DATE ===""){
    $("#AIRBILL_DATE").focus();
    $("#AIRBILL_DATE").after('<span  class="errormsg">Please Select Airway/Way Bill Date.</span>');
    return false;
  }
  else if(GETYPE =="IPO" && FREIGHT_TERMS ===""){
    $("#FREIGHT_TERMS").focus();
    $("#FREIGHT_TERMS").after('<span  class="errormsg">Please Enter Freight Terms.</span>');
    return false;
  }
  else if(GETYPE =="IPO" && CARRIERF_AGENT ===""){
    $("#CARRIERF_AGENT").focus();
    $("#CARRIERF_AGENT").after('<span  class="errormsg">Please Enter Career Agent.</span>');
    return false;
  }
  else if(GETYPE =="IPO" && CARRIERF_AGENT ===""){
    $("#CARRIERF_AGENT").focus();
    $("#CARRIERF_AGENT").after('<span  class="errormsg">Please Enter Freight Terms.</span>');
    return false;
  }

  // else if(EWAY_BILLNO ===""){
  //   $("#EWAY_BILLNO").focus();
  //   $("#EWAY_BILLNO").after('<span  class="errormsg">Please Enter Eway Bill No.</span>');
  //   return false;
  // }
  // else if(EWAY_BILLDATE ===""){
  //   $("#EWAY_BILLDATE").focus();
  //   $("#EWAY_BILLDATE").after('<span  class="errormsg">Please Select Eway Bill Date.</span>');
  //   return false;
  // }

  
  else if(GETYPE =="IPO" && TOTAL_BOXES ===""){
    $("#TOTAL_BOXES").focus();
    $("#TOTAL_BOXES").after('<span  class="errormsg">Please Enter Total Boxes.</span>');
    return false;
  }
  
  else if(GETYPE =="IPO" && TRUCK_SEAL_NO ===""){
    $("#TRUCK_SEAL_NO").focus();
    $("#TRUCK_SEAL_NO").after('<span  class="errormsg">Please Enter Truck Seal No.</span>');
    return false;
  }






  else if(LR_NO !="" && LR_DT ===""){
    $("#VehicleTab" ).trigger( "click" );
    $("#LR_DT").focus();
    $("#LR_DT").after('<span  class="errormsg">Select LR Date.</span>');
    return false;
  }
  else if(GROSS_WEIGHT !="" && TARE_WEIGHT ===""){
    $("#VehicleTab" ).trigger( "click" );
    $("#TARE_WEIGHT").focus();
    $("#TARE_WEIGHT").after('<span  class="errormsg">Please enter tare weight.</span>');
    return false;
  }
  else if(TARE_WEIGHT !="" && GROSS_WEIGHT ===""){
    $("#VehicleTab" ).trigger( "click" );
    $("#GROSS_WEIGHT").focus();
    $("#GROSS_WEIGHT").after('<span  class="errormsg">Please enter gross weight.</span>');
    return false;
  }
  else if(GROSS_WEIGHT !="" && /^[0-9.\s]+$/.test(GROSS_WEIGHT)==false){
    $("#VehicleTab" ).trigger( "click" );
    $("#GROSS_WEIGHT").focus();
    $("#GROSS_WEIGHT").after('<span  class="errormsg">Allow no and decimal.</span>');
    return false;
  }
  else if(TARE_WEIGHT !="" && /^[0-9.\s]+$/.test(TARE_WEIGHT)==false){
    $("#VehicleTab" ).trigger( "click" );
    $("#TARE_WEIGHT").focus();
    $("#TARE_WEIGHT").after('<span  class="errormsg">Allow no and decimal.</span>');
    return false;
  }
  else if(NET_WEIGHT !="" && /^[0-9.\s]+$/.test(NET_WEIGHT)==false){
    $("#VehicleTab" ).trigger( "click" );
    $("#NET_WEIGHT").focus();
    $("#NET_WEIGHT").after('<span  class="errormsg">Allow no and decimal.</span>');
    return false;
  }
 else{
    event.preventDefault();
    var allblank1 = [];

    $('#example3').find('.participantRow3').each(function(){
      if($.trim($(this).find("[id*=UDF]").val())!=""){
        if($.trim($(this).find("[id*=UDFismandatory]").val())=="1"){
              if($.trim($(this).find('[id*="udfvalue"]').val()) != "")
              {
                allblank1.push('true');
              }
              else
              {
                allblank1.push('false');
              }
        }  
      }                
    });

 
    if(jQuery.inArray("false", allblank1) !== -1){
      $("#udfTab" ).trigger( "click" );
      $("#AlertMessage").text('Please enter  Value / Comment in UDF Tab.');
      $("#YesBtn").hide(); 
      $("#NoBtn").hide();  
      $("#OkBtn1").show();
      $("#OkBtn1").focus();
      $("#alert").modal('show');
      highlighFocusBtn('activeOk');
    }
    else{
          $("#alert").modal('show');
          $("#AlertMessage").text('Do you want to save to record.');
          $("#YesBtn").data("funcname",actionType);
          $("#YesBtn").focus();
          $("#OkBtn").hide();
          highlighFocusBtn('activeYes');
    }
  }
}

function LessDateValidateWithToday(value){

if(value !=""){
    var today = new Date(); 
    var d = new Date(value);
    today.setHours(0, 0, 0, 0) ;
    d.setHours(0, 0, 0, 0) ;

    if(d < today){
        return false;
    }
    else {
      return true;
    }
}
else{
  return true;
}
}

function isNumberDecimalKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

    return true;
}

function weightCalculation(){
  $(".errormsg").remove();

  var GROSS_WEIGHT  = parseFloat($.trim($("#GROSS_WEIGHT").val()));
  var TARE_WEIGHT   = parseFloat($.trim($("#TARE_WEIGHT").val()));

  if(TARE_WEIGHT > GROSS_WEIGHT){
    $("#TARE_WEIGHT").focus();
    $("#TARE_WEIGHT").val('');
    $("#NET_WEIGHT").val('');
    $("#TARE_WEIGHT").after('<span  class="errormsg">Enter correct Tare weight.</span>');
  }
  else{
    if($.trim($("#GROSS_WEIGHT").val()) !="" && $.trim($("#TARE_WEIGHT").val()) !=""){
      $("#NET_WEIGHT").val((GROSS_WEIGHT-TARE_WEIGHT));
    }
  }

}

function deleteDate(id,data){
  if(data ===""){
    $("#"+id).val('');
  }
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
function isNumberKey(e,t){
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        }
        else if (e) {
            var charCode = e.which;
        }
        else { return true; }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {         
        return false;
        }
         return true;

    }
    catch (err) {
        alert(err.Description);
    }
}



function checkDuplicateVendorBillNo(VENDOR_BILLNO,ACTION){

  if($.trim($("#VID_REF_LAST").val()) !=$.trim($("#VID_REF").val()) || $.trim($("#VENDOR_BILLNO_LAST").val()) !=$.trim($("#VENDOR_BILLNO").val()) ){
  $(".errormsg").remove();
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var VID_REF=$("#VID_REF").val(); 
  if(VID_REF==''){
    $("#VID_REF_Details").focus();
    $("#VENDOR_BILLNO").val('');
    $("#VID_REF").after('<span  class="errormsg">Please Select Vendor First.</span>');
    return false;
  }
var checkDuplicateVendorBillNo = $.ajax({type: 'POST',url:'{{route("transaction",[$FormId,"checkDuplicateVendorBillNo"])}}',async: false,dataType: 'json',data: {VENDOR_BILLNO:VENDOR_BILLNO,VID_REF:VID_REF},done: function(response) {return response;}}).responseText;
  
if(checkDuplicateVendorBillNo =="1"){
  if(ACTION=='save'){
    return true;
  }else{
     $("#VENDOR_BILLNO").focus();
     $("#VENDOR_BILLNO").after('<span  class="errormsg">Vendor Bill No already exists.</span>');
     return false; 
  }
}
else{
  if(ACTION=='save'){
    return false;
  }else{
    $("#VENDOR_BILLNO").after('');
  }


}  

}else{
  return false;
}
}

function getType(type){
  $("#fieldtype").text(type);
  $("#fieldtype1").text(type+' Bill No');
  $("#fieldtype2").text(type+' Challan No');
  $("#VID_REF_Details").val('');
  $("#VID_REF").val('');
  $("#PO_NO_Details").val('');
  $("#PO_NO").val('');
}

//============================ START EMPLOYEE FUNCTION ============================
let sptid = "#EmployeeTable2";
let sptid2 = "#EmployeeTable";
let requestuserheaders = document.querySelectorAll(sptid2 + " th");


requestuserheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(sptid, ".clssemployee", "td:nth-child(" + (i + 1) + ")");
  });
});

function EmployeeCodeFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("Employeecodesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("EmployeeTable2");
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

function EmployeeNameFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("Employeenamesearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("EmployeeTable2");
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

$("#EMPLOYEE_closePopup").click(function(event){
  $("#EMPLOYEE_popup").hide();
});

$(".clssemployee").click(function(){
  var fieldid = $(this).attr('id');
  var txtval  = $("#txt"+fieldid+"").val();
  var texdesc = $("#txt"+fieldid+"").data("desc");
  
  $('#VID_REF_Details').val(texdesc);
  $('#VID_REF').val(txtval);
  $("#EMPLOYEE_popup").hide();

  $("#Employeecodesearch").val(''); 
  $("#Employeenamesearch").val(''); 
  event.preventDefault();
});

//============================ END EMPLOYEE FUNCTION ============================

//============================ CUSTOMER ============================

let cltid     = "#GlCodeTable2";
let cltid2    = "#GlCodeTable";
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

$("#customer_closePopup").on("click",function(event){ 
    $("#customer_popus").hide();
    $("#customercodesearch").val(''); 
    $("#customernamesearch").val(''); 
   
    event.preventDefault();
});

function bindSubLedgerEvents(){
  $('.clssubgl').click(function(){

    var id      = $(this).attr('id');
    var txtval  = $("#txt"+id+"").val();
    var texdesc = $("#txt"+id+"").data("desc");
  
    $('#VID_REF_Details').val(texdesc);
    $('#VID_REF').val(txtval);

    $("#customer_popus").hide();
    $("#customercodesearch").val(''); 
    $("#customernamesearch").val(''); 
    event.preventDefault();
  });
}

</script>
@endpush