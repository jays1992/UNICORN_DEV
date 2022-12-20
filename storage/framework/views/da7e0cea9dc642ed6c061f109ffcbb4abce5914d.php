

<?php $__env->startSection('content'); ?>
<?php $helper = app('App\Helpers\Helper'); ?>    
    

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('transaction',[$FormId,'index'])); ?>" class="btn singlebt">Payment Entry</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSave" disabled="disabled"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" <?php echo e(isset($objRights->PRINT) && $objRights->PRINT != 1 ? 'disabled' : ''); ?> ><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo"  disabled="disabled"><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-lock"></i>  Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div><!--row-->
    </div>
    
       
<div class="container-fluid filter">
  <form id="frm_trn_pay"  method="POST"> 
      <?php echo csrf_field(); ?>
      <?php echo e(isset($objPAYHDR->PAYMENTID) ? method_field('PUT') : ''); ?>


	<div class="inner-form">
	
		<div class="row">
        <div class="col-lg-1 pl"><p>Payment No*</p></div>
        <div class="col-lg-2 pl">
              <input <?php echo e($ActionStatus); ?> type="text" name="PAYMENT_NO" id="PAYMENT_NO" value="<?php echo e(isset($objPAYHDR->PAYMENT_NO)?$objPAYHDR->PAYMENT_NO:''); ?>" class="form-control mandatory"  autocomplete="off" readonly style="text-transform:uppercase" >
        </div>
        <div class="col-lg-1 pl"><p>Payment Date*</p></div>
        <div class="col-lg-2 pl">
              <input <?php echo e($ActionStatus); ?> type="date" name="PAYMENT_DT" id="PAYMENT_DT" value="<?php echo e(isset($objPAYHDR->PAYMENT_DT)?$objPAYHDR->PAYMENT_DT:''); ?>" class="form-control mandatory"  placeholder="dd/mm/yyyy" />
        </div>
        <div class="col-lg-1 pl"><p>Payment For*</p></div>
        <div class="col-lg-1 pl">
              <input <?php echo e($ActionStatus); ?> type="checkbox" name="chk_Vendor" id="chk_Vendor" <?php echo e(isset($objPAYHDR->PAYMENT_FOR) && $objPAYHDR->PAYMENT_FOR == 'Vendor' ? 'checked' : ''); ?> /> &nbsp;&nbsp;<label>   Vendor </label>
        </div>
        <div class="col-lg-1 pl">
              <input <?php echo e($ActionStatus); ?> type="checkbox" name="chk_Customer" id="chk_Customer" <?php echo e(isset($objPAYHDR->PAYMENT_FOR) && $objPAYHDR->PAYMENT_FOR == 'Customer' ? 'checked' : ''); ?> />&nbsp;&nbsp;<label>   Customer </label>
        </div>

        <div class="col-lg-1 pl">
          <input <?php echo e($ActionStatus); ?> type="checkbox" name="chk_Employee" id="chk_Employee" <?php echo e(isset($objPAYHDR->PAYMENT_FOR) && $objPAYHDR->PAYMENT_FOR == 'Employee' ? 'checked' : ''); ?> />&nbsp;&nbsp;<label>   Employee </label>
        </div>

        <div class="col-lg-1 pl">
              <input <?php echo e($ActionStatus); ?> type="checkbox" name="chk_Account" id="chk_Account" <?php echo e(isset($objPAYHDR->PAYMENT_FOR) && $objPAYHDR->PAYMENT_FOR == 'Account' ? 'checked' : ''); ?> />&nbsp;&nbsp;<label>   Account </label> 
              <input type="hidden" name="hdnpaymentfor" id="hdnpaymentfor" value="<?php echo e(isset($objPAYHDR->PAYMENT_FOR)?$objPAYHDR->PAYMENT_FOR:''); ?>" />
              <input type="hidden" name="hdnInvoice" id="hdnInvoice" />
              <input type="hidden" name="hdnAccount" id="hdnAccount" />
              <input type="hidden" name="hdnCostCenter" id="hdnCostCenter" />
              <input type="hidden" name="hdnCostCenter2" id="hdnCostCenter2" />
              <input type="hidden" name="hdntds" id="hdntds" />
			  <input type="hidden" name="BUDGET_AMOUNT" id="BUDGET_AMOUNT" class="form-control" autocomplete="off" /> 
        </div>
    </div>
    <div class="row" id="divcust1"  style="display:none">
        <div class="col-lg-1 pl"><p id="titalName"> Customer / Vendor*</p></div> 
        <div class="col-lg-2 pl">
            <?php if(isset($objPAYHDR->CUSTMER_VENDOR_ID) && $objPAYHDR->CUSTMER_VENDOR_ID != ''): ?>
               <input <?php echo e($ActionStatus); ?> type="text" name="txtcustomer" id="txtcustomer" class="form-control" value="<?php echo e(isset($objPAYCUSTVNDR->CODE) && $objPAYCUSTVNDR->CODE !=''?$objPAYCUSTVNDR->CODE:''); ?> <?php echo e(isset($objPAYCUSTVNDR->NAME) && $objPAYCUSTVNDR->NAME !=''?'- '.$objPAYCUSTVNDR->NAME:''); ?>" readonly  />
            <?php else: ?>
               <input <?php echo e($ActionStatus); ?> type="text" name="txtcustomer" id="txtcustomer" class="form-control" readonly  />
            <?php endif; ?>
                <input type="hidden" name="CUSTMER_VENDOR_ID" id="CUSTMER_VENDOR_ID"  class="form-control " value="<?php echo e(isset($objPAYHDR->CUSTMER_VENDOR_ID)?$objPAYHDR->CUSTMER_VENDOR_ID:''); ?>" />
        </div>
        <div class="col-lg-1 pl"><p>Payment On Account</p></div>        
        <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="checkbox" name="chk_PayAccount" id="chk_PayAccount" <?php echo e(isset($objPAYHDR->PAYMENT_ON_ACCOUNT) && $objPAYHDR->PAYMENT_ON_ACCOUNT == 1 ? 'checked' : ''); ?> />
        </div>
        <div class="col-lg-1 pl" id="div_account_amt" style="display:none;"><p>Amount</p></div>        
        <div class="col-lg-2 pl" id="div_account_amt2" style="display:none;">
            <input <?php echo e($ActionStatus); ?> type="text" name="AMOUNT" id="AMOUNT" class="form-control two-digits"  autocomplete="off" value="<?php echo e(isset($objPAYHDR->AMOUNT)?$objPAYHDR->AMOUNT:''); ?>" />
        </div>
    </div>
	<div class="row"  id="po_section"  >	
        <div class="col-lg-1 pl"><p>PO No</p></div>
        <div class="col-lg-2 pl">
        <input type="text" name="POpopup" id="txtPOpopup" class="form-control mandatory"  autocomplete="off" value="<?php echo e(isset($objPAYHDR->PO_NO)?$objPAYHDR->PO_NO:''); ?>"  readonly/>
        <input type="hidden" name="POID_REF" id="POID_REF" class="form-control" value="<?php echo e(isset($objPAYHDR->POID_REF)?$objPAYHDR->POID_REF:''); ?>" autocomplete="off" />
        </div>
        <div class="col-lg-1 pl"><p>PO Date</p></div>
        <div class="col-lg-2 pl">
            <input type="text" name="PODT" id="PODT" class="form-control" value="<?php echo e(isset($objPAYHDR->PO_DT)?$objPAYHDR->PO_DT:''); ?>"  autocomplete="off"  readonly  />
        </div>
    </div>
    <div class="row">
		<div id="divcust2" style="display:none;">
			<div class="col-lg-1 pl"><p>Cash / Bank Account*  </p></div>
			<div class="col-lg-2 pl">
					<input <?php echo e($ActionStatus); ?> type="text" name="txtcashbk" id="txtcashbk" class="form-control" value="<?php echo e(isset($objPAYCASHBANK->BCODE)?$objPAYCASHBANK->BCODE:''); ?> <?php echo e(isset($objPAYCASHBANK->NAME)?$objPAYCASHBANK->NAME:''); ?>" readonly  />
					<input type="hidden" name="CASH_BANK_ID" id="CASH_BANK_ID"  class="form-control " value="<?php echo e(isset($objPAYHDR->CASH_BANK_ID)?$objPAYHDR->CASH_BANK_ID:''); ?>" />
					<input type="hidden" name="PAYMENT_TYPE" id="PAYMENT_TYPE"  class="form-control " value="<?php echo e(isset($objPAYHDR->PAYMENT_TYPE)?$objPAYHDR->PAYMENT_TYPE:''); ?>" />
					<input type="hidden" name="ODLIMIT" id="ODLIMIT"  class="form-control " value="<?php echo e(isset($objPAYHDR->ODLIMIT)?$objPAYHDR->ODLIMIT:'0.00'); ?>" />
					<label style="display:none" id="BALANCE"> 
					<?php echo e(isset($objPAYCASHBANK->BCODE) && $objPAYCASHBANK->BCODE!=''? 'Balance '.$helper->getBalance($objPAYCASHBANK->GLID_REF):''); ?>

				  </label>
					<label id="BALANCE_SHOW"> 
					<?php echo e(isset($objPAYCASHBANK->BCODE) && $objPAYCASHBANK->BCODE!=''? 'Balance '.$helper->getBalance_Show($objPAYCASHBANK->GLID_REF):''); ?>

				  </label>
			</div>
		</div>
        <div class="col-lg-1 pl"><p>Transaction Date*</p></div>
        <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="date" name="TRANSACTION_DT" id="TRANSACTION_DT" class="form-control"  placeholder="dd/mm/yyyy" value="<?php echo e(isset($objPAYHDR->TRANSACTION_DT)?$objPAYHDR->TRANSACTION_DT:''); ?>"  />
        </div>
        <div class="col-lg-1 pl"><p>Instrument Type*</p></div>
        <div class="col-lg-2 pl">
            <select <?php echo e($ActionStatus); ?> name="INSTRUMENT_TYPE" id="INSTRUMENT_TYPE" class="form-control">
                <option value="Cheque" <?php echo e(isset($objPAYHDR->INSTRUMENT_TYPE) && $objPAYHDR->INSTRUMENT_TYPE == 'Cheque' ? 'selected' : ''); ?> >Cheque</option>
                <option value="NEFT" <?php echo e(isset($objPAYHDR->INSTRUMENT_TYPE) && $objPAYHDR->INSTRUMENT_TYPE == 'NEFT' ? 'selected' : ''); ?> >NEFT</option>
                <option value="RTGS" <?php echo e(isset($objPAYHDR->INSTRUMENT_TYPE) && $objPAYHDR->INSTRUMENT_TYPE == 'RTGS' ? 'selected' : ''); ?> >RTGS</option>
                <option value="CASH" <?php echo e(isset($objPAYHDR->INSTRUMENT_TYPE) && $objPAYHDR->INSTRUMENT_TYPE == 'CASH' ? 'selected' : ''); ?> >CASH</option>
                <option value="IMPS" <?php echo e(isset($objPAYHDR->INSTRUMENT_TYPE) && $objPAYHDR->INSTRUMENT_TYPE == 'IMPS' ? 'selected' : ''); ?> >IMPS</option>
                <option value="UPI" <?php echo e(isset($objPAYHDR->INSTRUMENT_TYPE) && $objPAYHDR->INSTRUMENT_TYPE == 'UPI' ? 'selected' : ''); ?> >UPI</option>
            </select>                        
        </div>
        <div class="col-lg-1 pl"><p>Instrument No*</p></div>
        <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="INSTRUMENT_NO" id="INSTRUMENT_NO" class="form-control"  autocomplete="off" value="<?php echo e(isset($objPAYHDR->INSTRUMENT_NO)?$objPAYHDR->INSTRUMENT_NO:''); ?>" />                        
        </div>
    </div>
	<div class="row">
      <div class="col-lg-1 pl"><p>FC</p></div>
      <div class="col-lg-2 pl">
          <input type="checkbox" <?php echo e($ActionStatus); ?> name="FC" id="FC" class="form-checkbox" <?php echo e(isset($objPAYHDR->FC) && $objPAYHDR->FC == 1 ? 'checked' : ''); ?> >
      </div>
      
      <div class="col-lg-1 pl"><p>Currency</p></div>
      <div class="col-lg-2 pl" id="divcurrency" >

      
          <input type="text" <?php echo e($ActionStatus); ?> name="CRID_popup" id="txtCRID_popup" disabled class="form-control"   autocomplete="off"   value="<?php echo e(isset($objPAYHDR->CRDESCRIPTION) && $objPAYHDR->CRDESCRIPTION !=''? $objPAYHDR->CRCODE.'-'.$objPAYHDR->CRDESCRIPTION:''); ?>"/>
      
          <input type="hidden"  name="CRID_REF" id="CRID_REF" class="form-control" autocomplete="off"   value="<?php echo e(isset($objPAYHDR->CRID_REF)?$objPAYHDR->CRID_REF:''); ?>" />
          
      </div>
      
      <div class="col-lg-1 pl"><p>Conversion Factor</p></div>
      <div class="col-lg-2 pl">
          <input type="text" <?php echo e($ActionStatus); ?> name="CONVFACT" id="CONVFACT" class="form-control" onkeyup="MultiCurrency_Conversion('tot_amt1')" maxlength="100" autocomplete="off" value="<?php echo e(isset($objPAYHDR->CONVFACT)?$objPAYHDR->CONVFACT:''); ?>"  />
      </div>
  </div>
    <div class="row"  id="divcust3"  style="display:none;">	
        <div class="col-lg-1 pl"><p>Bank Charge</p></div>
        <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="BANK_CHARGE" id="BANK_CHARGE" class="form-control two-digits"  autocomplete="off" value="<?php echo e(isset($objPAYHDR->BANK_CHARGE)?$objPAYHDR->BANK_CHARGE:''); ?>" />
        </div>                          
        <div class="col-lg-1 pl"><p>Amount*</p></div>
        <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="tot_amt1" id="tot_amt1" class="form-control"  autocomplete="off" readonly  />
        </div>
        <div class="col-lg-1 pl"><p>Common Narration</p></div>
        <div class="col-lg-5 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="NARRATION" id="NARRATION" class="form-control"  autocomplete="off" value="<?php echo e(isset($objPAYHDR->NARRATION)?$objPAYHDR->NARRATION:''); ?>" />                        
        </div>
    </div>

    <div class="row"  id=""  >	
        <div class="col-lg-1 pl"><p>Round of GL</p></div>
        <div class="col-lg-2 pl">
        <input type="text"  <?php echo e($ActionStatus); ?> name="GLpopup" id="txtGLpopup" class="form-control mandatory" value="<?php echo e(isset($objGl->GLCODE)?$objGl->GLCODE.'-'.$objGl->GLNAME:''); ?>"  autocomplete="off"  readonly/>
        <input type="hidden" name="GLID_REF_ROUNDOFF" id="GLID_REF_ROUNDOFF" class="form-control" value="<?php echo e(isset($objPAYHDR->ROUNDOFF_GLID)?$objPAYHDR->ROUNDOFF_GLID:''); ?>" autocomplete="off" />
        <label style="display:none" id="BALANCE_ROUNDGL"> 
                <?php echo e(isset($objGl->GLCODE) && $objGl->GLCODE!=''? 'Balance '.$helper->getBalance($objPAYHDR->ROUNDOFF_GLID):''); ?>

              </label>
        <label id="BALANCE_ROUNDGL_SHOW"> 
                <?php echo e(isset($objGl->GLCODE) && $objGl->GLCODE!=''? 'Balance '.$helper->getBalance_show($objPAYHDR->ROUNDOFF_GLID):''); ?>

              </label>
      </div>                          
        <div class="col-lg-1 pl"><p>Round of GL Amount</p></div>
        <div class="col-lg-2 pl">
            <input type="text"  <?php echo e($ActionStatus); ?> name="ROUNDOFF_AMT" id="ROUNDOFF_AMT" class="form-control" value="<?php echo e(isset($objPAYHDR->ROUNDOFF_AMT)?$objPAYHDR->ROUNDOFF_AMT:''); ?>" autocomplete="off" onkeyup="calculateBankAmount()"   />
        </div>
        <div class="col-lg-1 pl"><p>Round of Mode</p></div>
        <div class="col-lg-2 pl">
        <select name="ROUNDOFF_MODE"  <?php echo e($ActionStatus); ?>  id="ROUNDOFF_MODE" class="form-control" onchange="calculateBankAmount()" >
                <option value="Positive" <?php echo e(isset($objPAYHDR->ROUNDOFF_MODE) && $objPAYHDR->ROUNDOFF_MODE == 'Positive' ? 'selected' : ''); ?>>Debit</option>
                <option value="Negative" <?php echo e(isset($objPAYHDR->ROUNDOFF_MODE) && $objPAYHDR->ROUNDOFF_MODE == 'Negative' ? 'selected' : ''); ?>>Credit</option>
              </select>                                  
        </div>
    </div>




    <div class="row"  id="divcust4"  style="display:none;">	
        <div class="col-lg-1 pl"><p>Centerlized Payment</p></div>
        <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="checkbox" name="CENTERLIZED_PAYMENT" id="CENTERLIZED_PAYMENT" <?php echo e(isset($objPAYHDR->CENTERLIZED_PAYMENT) && $objPAYHDR->CENTERLIZED_PAYMENT == 1 ? 'checked' : ''); ?>   />
        </div> 
    </div>
	</div>

	<div class="container-fluid">
		<div class="row" id="tabs">
			<ul class="nav nav-tabs">
				<li class="active" id="div_invoice" style="display:none"><a data-toggle="tab" href="#Invoice" id="Invoice_Tab" >Invoice Details</a></li> 
        <li id="div_account" style="display:none"><a data-toggle="tab" href="#Account">Account</a></li> 
        <li id="div_tds"><a data-toggle="tab" href="#TDS">TDS</a></li>      
        <li  style="display:none"><a data-toggle="tab" href="#CostCenter">Cost Center</a></li> 
			</ul>
      <div class="tab-content">
        <div id="Invoice" class="tab-pane fade in ">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                          <tr>
                              <th width="12%">Doc No<input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1" value="<?php echo e($objCount1); ?>"></th>
                              <th width="12%">Doc Type</th>
                              <th width="12%">Supplier Invoice No</th>
                              <th width="12%">Doc Date</th>
                              <th width="12%">Amount</th>
                              <th width="12%">Balance Due</th>
                              <th width="12%">Payment Amount</th>
                              <th width="12%">Remarks</th>
                              <th width="12%">Branch</th>
                              <th width="5%">Action</th>
                          </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($objPAYINV)): ?>
                      <?php $__currentLoopData = $objPAYINV; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr  class="participantRow2">
                              <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("txtDoc_NO_".$key); ?> id=<?php echo e("txtDoc_NO_".$key); ?> class="form-control"  autocomplete="off" value="<?php echo e($row->DOCNO); ?>" readonly/></td>
                              <td hidden><input type="hidden" name=<?php echo e("DOCNO_ID_".$key); ?> id=<?php echo e("DOCNO_ID_".$key); ?> class="form-control" value="<?php echo e($row->DOCNO_ID); ?>" autocomplete="off" /> <input type="hidden" name="rowcount1[]"   class="form-control" autocomplete="off" /></td>
              
                              <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("Doc_Type_".$key); ?> id=<?php echo e("Doc_Type_".$key); ?> class="form-control"  autocomplete="off" value="<?php echo e($row->DOC_TYPE); ?>" readonly/></td>
                              
                              <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("Supplier_InvoiceNo_".$key); ?> id=<?php echo e("Supplier_InvoiceNo_".$key); ?> class="form-control"  autocomplete="off" value="<?php echo e($row->SUPPLIERINVOICE); ?>" readonly/></td>
                              
                              <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("DocDate_".$key); ?> id=<?php echo e("DocDate_".$key); ?> class="form-control" autocomplete="off" placeholder="dd/mm/yyyy" value="<?php echo e($row->DOCDT); ?>" readonly /></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("DocAmount_".$key); ?> id=<?php echo e("DocAmount_".$key); ?> class="form-control two-digits"  autocomplete="off" value="<?php echo e($row->DOCAMT); ?>" readonly/></td>
                      <?php
                          $BALANCE_DUE=number_format(($row->BALANCE_DUE+$row->PAYMENT_AMT),2, '.', '');
                      ?>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("BALANCE_DUE_".$key); ?> id=<?php echo e("BALANCE_DUE_".$key); ?> class="form-control two-digits" maxlength="15" value="<?php echo e($BALANCE_DUE); ?>" autocomplete="off"  readonly/></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("PAYMENT_AMT_".$key); ?> id=<?php echo e("PAYMENT_AMT_".$key); ?> class="form-control two-digits" maxlength="15" value="<?php echo e($row->PAYMENT_AMT); ?>" autocomplete="off" /></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("REMARKS_".$key); ?> id=<?php echo e("REMARKS_".$key); ?> class="form-control" maxlength="200" autocomplete="off" value="<?php echo e($row->REMARKS); ?>" /></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("TxtBranch_".$key); ?> id=<?php echo e("TxtBranch_".$key); ?> class="form-control" value="<?php echo e($row->BRANCH); ?>" readonly  /></td>
                              <td hidden><input type="hidden" name=<?php echo e("BRID_REF_".$key); ?> id=<?php echo e("BRID_REF_".$key); ?> class="form-control" autocomplete="off" value="<?php echo e($row->BRID_REF); ?>" /></td>
                              <td align="center" >
                                <button <?php echo e($ActionStatus); ?> class="btn add ainvoice" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                                <button <?php echo e($ActionStatus); ?> class="btn remove dinvoice" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                            </td>
                          </tr>
                          <tr></tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                          <tr  class="participantRow2">
                              <td><input <?php echo e($ActionStatus); ?> type="text" name="txtDoc_NO_0" id="txtDoc_NO_0" class="form-control"  autocomplete="off"  readonly/></td>
                              <td hidden><input type="hidden" name="rowcount1[]" id="rowcount1[]" class="form-control" autocomplete="off" /></td>
                              <td hidden><input type="hidden" name="DOCNO_ID_0" id="DOCNO_ID_0" class="form-control" autocomplete="off" /></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name="Doc_Type_0" id="Doc_Type_0" class="form-control"  autocomplete="off"  readonly/></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name="Supplier_InvoiceNo_0" id="Supplier_InvoiceNo_0" class="form-control"  autocomplete="off"  readonly/></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name="DocDate_0" id="DocDate_0" class="form-control" autocomplete="off" placeholder="dd/mm/yyyy" readonly /></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name="DocAmount_0" id="DocAmount_0" class="form-control two-digits"  autocomplete="off"  readonly/></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name="BALANCE_DUE_0" id="BALANCE_DUE_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name="PAYMENT_AMT_0" id="PAYMENT_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name="REMARKS_0" id="REMARKS_0" class="form-control" maxlength="200" autocomplete="off"  /></td>
                              <td><input <?php echo e($ActionStatus); ?> type="text" name="TxtBranch_0" id="TxtBranch_0" class="form-control" readonly  /></td>
                              <td hidden><input type="hidden" name="BRID_REF_0" id="BRID_REF_0" class="form-control" autocomplete="off" /></td>
                              <td align="center" >
                                <button <?php echo e($ActionStatus); ?> class="btn add ainvoice" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                                <button <?php echo e($ActionStatus); ?> class="btn remove dinvoice" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                              </td>
                          </tr>
                          <tr></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>	
        </div> 
        <div id="Account" class="tab-pane fade in">
            <div class="row" style="margin-top:10px;margin-left:3px;" >	
                <div class="col-lg-2 pl"><p>Bank/Cash</p></div>
                <div class="col-lg-2 pl">
                    <input type="text" <?php echo e($ActionStatus); ?> name="txtbnkcsh" id="txtbnkcsh" class="form-control" value="<?php echo e(isset($objPAYCASHBANK->BCODE)?$objPAYCASHBANK->BCODE:''); ?> <?php echo e(isset($objPAYCASHBANK->NAME)?'-'.$objPAYCASHBANK->NAME:''); ?>" readonly  />
                    <input type="hidden" name="BANK_CASH_ID" id="BANK_CASH_ID"  class="form-control" value="<?php echo e(isset($objPAYHDR->CASH_BANK_ID)?$objPAYHDR->CASH_BANK_ID:''); ?>" />
                    <input type="hidden" name="ODLIMIT_ACCOUNT" id="ODLIMIT_ACCOUNT"  class="form-control " value="<?php echo e(isset($objPAYCASHBANK->ODLIMIT)?$objPAYCASHBANK->ODLIMIT:'0.00'); ?>" />
                    <label style="display:none" id="BALANCE_ACCOUNT"> 
                <?php echo e(isset($objPAYCASHBANK->BCODE) && $objPAYCASHBANK->BCODE!=''? 'Balance '.$helper->getBalance($objPAYCASHBANK->GLID_REF):''); ?>

              </label>
                    <label id="BALANCE_ACCOUNT_SHOW"> 
                <?php echo e(isset($objPAYCASHBANK->BCODE) && $objPAYCASHBANK->BCODE!=''? 'Balance '.$helper->getBalance_show($objPAYCASHBANK->GLID_REF):''); ?>

              </label>
                
                  </div>

                <div class="col-lg-1 pl"><p>Bank Amount</p></div>
                <div class="col-lg-2 pl">
                  <input type="text" name="BANK_AMOUNT" id="BANK_AMOUNT" value="<?php echo e(isset($objPAYHDR->BANK_AMOUNT)?$objPAYHDR->BANK_AMOUNT:''); ?>" class="form-control"  readonly autocomplete="off"  />
                </div>

                <div class="col-lg-1 pl"><p>Common Narration</p></div>
                <div class="col-lg-2 pl">
                  <input <?php echo e($ActionStatus); ?> type="text" name="BANK_REMARKS" id="BANK_REMARKS" value="<?php echo e(isset($objPAYHDR->BANK_REMARKS)?$objPAYHDR->BANK_REMARKS:''); ?>" class="form-control" autocomplete="off" />
                </div>

                <div class="col-lg-1 pl"><p>Sub Ledger</p></div>
                <div class="col-lg-1 pl">
                    <input type="checkbox" name="SubGL" id="SubGL" <?php echo e(isset($objPAYHDR->SUB_LEDGER) && $objPAYHDR->SUB_LEDGER == 1 ? 'checked' : ''); ?>  disabled />
                    <input type="hidden" name="hdnAccounting" id="hdnAccounting" class="form-control"  autocomplete="off"  />
                    <input type="hidden" name="hdnCostCenter2" id="hdnCostCenter2" class="form-control" autocomplete="off" />
                </div>

            </div>
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:240px;" >
                <table id="example3" class="display nowrap table table-striped table-bordered itemlist " width="100%" style="height:auto !important;">
                  <thead id="thead1"  style="position: sticky;top: 0">
                      <tr>
                          <th>Account Code<input class="form-control" type="hidden" name="Row_Count3" id ="Row_Count3" value="<?php echo e($objCount2); ?>"></th>
                          <th>Account Name</th>
                          <th>Account Balance</th>
                          <th>Amount</th>
                          <th>Assessable Value</th>
                          <th>IGST Rate</th>
                          <th>IGST Amount</th>
                          <th>CGST Rate</th>
                          <th>CGST Amount</th>
                          <th>SGST Rate</th>
                          <th>SGST Amount</th>
                          <th>Cost Center</th>
                          <th>Type</th>
                          <th>Total</th>
                          <th width="8%">Action</th>
                      </tr>
                  </thead>
                  <tbody id="tbody_account">
                  <?php if(!empty($objPAYACCOUNT)): ?>
                    <?php $__currentLoopData = $objPAYACCOUNT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gkey => $grow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr  class="participantRow3">
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("popupAccount_".$gkey); ?> id=<?php echo e("popupAccount_".$gkey); ?> class="form-control" value="<?php echo e(isset($grow->GLCODE) && $grow->GLCODE !=''?$grow->GLCODE:''); ?> <?php echo e(isset($grow->SGLCODE) && $grow->SGLCODE !=''?$grow->SGLCODE:''); ?>" autocomplete="off" readonly/></td>
                          <td hidden><input type="hidden" name=<?php echo e("GLID_REF_".$gkey); ?> id=<?php echo e("GLID_REF_".$gkey); ?> class="form-control" value="<?php echo e($grow->GLID_REF); ?>" autocomplete="off" /></td>


                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("AccountName_".$gkey); ?> id=<?php echo e("AccountName_".$gkey); ?> class="form-control"  autocomplete="off" value="<?php echo e(isset($grow->GLNAME) && $grow->GLNAME !=''?$grow->GLNAME:''); ?> <?php echo e(isset($grow->SLNAME) && $grow->SLNAME !=''?$grow->SLNAME:''); ?>" readonly/></td>

                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("ACCOUNT_BALANCE_".$gkey); ?> id=<?php echo e("ACCOUNT_BALANCE_".$gkey); ?> class="form-control"  autocomplete="off" value="<?php echo e($helper->getBalance_show($grow->GLID_REF)); ?>" readonly/></td>
                          <td hidden><input type="hidden" name=<?php echo e("SLGL_TYPE_".$gkey); ?> id=<?php echo e("SLGL_TYPE_".$gkey); ?> value="<?php echo e($grow->SLGL_TYPE); ?>" class="form-control" autocomplete="off" /></td>

                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("AMOUNT_".$gkey); ?> id=<?php echo e("AMOUNT_".$gkey); ?> class="form-control two-digits right" maxlength="15" value="<?php echo e($grow->AMOUNT); ?>" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("ASSESSABLE_VALUE_".$gkey); ?> id=<?php echo e("ASSESSABLE_VALUE_".$gkey); ?> class="form-control two-digits right" maxlength="15" value="<?php echo e($grow->ASSESSABLE_VALUE); ?>" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("calIGST_".$gkey); ?> id=<?php echo e("calIGST_".$gkey); ?> class="form-control four-digits right" maxlength="8" value="<?php echo e($grow->IGST); ?>" autocomplete="off"  /></td>
                      <?php
                          $AmtIGST=number_format((($grow->ASSESSABLE_VALUE*$grow->IGST)/100),2, '.', '');
                      ?>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("AMTIGST_".$gkey); ?> id=<?php echo e("AMTIGST_".$gkey); ?> class="form-control two-digits right" maxlength="15" value="<?php echo e($AmtIGST); ?>" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("calCGST_".$gkey); ?> id=<?php echo e("calCGST_".$gkey); ?> class="form-control four-digits right" maxlength="8" value="<?php echo e($grow->CGST); ?>" autocomplete="off"  /></td>
                      <?php
                          $AmtCGST=number_format((($grow->ASSESSABLE_VALUE*$grow->CGST)/100),2, '.', '');
                      ?>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("AMTCGST_".$gkey); ?> id=<?php echo e("AMTCGST_".$gkey); ?> class="form-control two-digits right" maxlength="15" value="<?php echo e($AmtCGST); ?>" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("calSGST_".$gkey); ?> id=<?php echo e("calSGST_".$gkey); ?> class="form-control four-digits right" maxlength="8" value="<?php echo e($grow->SGST); ?>" autocomplete="off"  /></td>
                      <?php
                          $AmtSGST=number_format((($grow->ASSESSABLE_VALUE*$grow->SGST)/100),2, '.', '');
                      ?>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("AMTSGST_".$gkey); ?> id=<?php echo e("AMTSGST_".$gkey); ?> class="form-control two-digits right" maxlength="15" value="<?php echo e($AmtSGST); ?>" autocomplete="off"  /></td>
                          <td align="center" ><button <?php echo e($ActionStatus); ?> class="btn" id=<?php echo e("BtnCCID_".$gkey); ?> name=<?php echo e("BtnCCID_".$gkey); ?> type="button"><i class="fa fa-clone"></i></button></td>
                          <td hidden><input type="text" name=<?php echo e("CCID_REF_".$gkey); ?> id=<?php echo e("CCID_REF_".$gkey); ?> class="form-control"  autocomplete="off" value="<?php echo e($grow->CCID_REF); ?>"  readonly/></td>
                          <td>
                          <select <?php echo e($ActionStatus); ?> name=<?php echo e("TYPE_".$gkey); ?> id=<?php echo e("TYPE_".$gkey); ?>   class="form-control" style="width: 85px;">
                          <option value="Advance" <?php echo e(isset($grow->TYPE) && $grow->TYPE =="Advance" ? "selected":""); ?> >Advance</option>
                          <option value="Loan" <?php echo e(isset($grow->TYPE) && $grow->TYPE =="Loan" ? "selected":""); ?>>Loan</option>                            
                          <option value="Medical" <?php echo e(isset($grow->TYPE) && $grow->TYPE =="Medical" ? "selected":""); ?>>Medical</option>
                          <option value="Conveyance" <?php echo e(isset($grow->TYPE) && $grow->TYPE =="Conveyance" ? "selected":""); ?>>Conveyance</option>
                          <option value="Others" <?php echo e(isset($grow->TYPE) && $grow->TYPE =="Others" ? "selected":""); ?>>Others</option>
                          </select></td>
                      <?php
                          $AmtIGST=number_format((($grow->ASSESSABLE_VALUE*$grow->IGST)/100),2, '.', '');
                          $AmtCGST=number_format((($grow->ASSESSABLE_VALUE*$grow->CGST)/100),2, '.', '');
                          $AmtSGST=number_format((($grow->ASSESSABLE_VALUE*$grow->SGST)/100),2, '.', '');
                          $TotAmt=number_format(($grow->AMOUNT+$AmtIGST+$AmtCGST+$AmtSGST),2, '.', '');
                      ?>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("TOTAMT_".$gkey); ?> id=<?php echo e("TOTAMT_".$gkey); ?> class="form-control two-digits right"  maxlength="15" autocomplete="off" value="<?php echo e($TotAmt); ?>"  readonly/></td>
                          <td align="center" ><button <?php echo e($ActionStatus); ?> class="btn add aaccount" title="add" data-toggle="tooltip" type="button" ><i class="fa fa-plus"></i></button><button <?php echo e($ActionStatus); ?> class="btn remove daccount" title="Delete" data-toggle="tooltip" type="button" ><i class="fa fa-trash" ></i></button></td>
                      </tr>
                      <tr></tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                      <tr  class="participantRow3">
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="popupAccount_0" id="popupAccount_0" class="form-control"  autocomplete="off"  readonly/></td>
                          <td hidden><input type="hidden" name="GLID_REF_0" id="GLID_REF_0" class="form-control" autocomplete="off" /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="AccountName_0" id="AccountName_0" class="form-control"  autocomplete="off"  readonly/></td>                          
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="ACCOUNT_BALANCE_0" id="ACCOUNT_BALANCE_0" class="form-control"  autocomplete="off" value="" readonly/></td>
                          <td hidden><input type="hidden" name="SLGL_TYPE_0" id="SLGL_TYPE_0" class="form-control" autocomplete="off" /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="AMOUNT_0" id="AMOUNT_0" class="form-control two-digits right" maxlength="15" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="ASSESSABLE_VALUE_0" id="ASSESSABLE_VALUE_0" class="form-control two-digits right" maxlength="15" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="calIGST_0" id="calIGST_0" class="form-control four-digits right" maxlength="8" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="AMTIGST_0" id="AMTIGST_0" class="form-control two-digits right" maxlength="15" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="calCGST_0" id="calCGST_0" class="form-control four-digits right" maxlength="8" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="AMTCGST_0" id="AMTCGST_0" class="form-control two-digits right" maxlength="15" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="calSGST_0" id="calSGST_0" class="form-control four-digits right" maxlength="8" autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="AMTSGST_0" id="AMTSGST_0" class="form-control two-digits right" maxlength="15" autocomplete="off"  /></td>
                          <td align="center" ><button <?php echo e($ActionStatus); ?> class="btn" id="BtnCCID_0" name="BtnCCID_0" type="button"><i class="fa fa-clone"></i></button></td>
                          <td hidden><input type="text" name="CCID_REF_0" id="CCID_REF_0" class="form-control"  autocomplete="off"  readonly/></td>
                          
                          <td>                                 
                            <select <?php echo e($ActionStatus); ?> name="TYPE_0" id="TYPE_0" class="form-control" style="width: 85px;">
                            <option value="Advance">Advance</option>
                            <option value="Loan">Loan</option>                            
                            <option value="Medical">Medical</option>
                            <option value="Conveyance">Conveyance</option>
                            <option value="Others">Others</option>
                            </select>
                          </td>
                         
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="TOTAMT_0" id="TOTAMT_0" class="form-control two-digits right"  maxlength="15" autocomplete="off"  readonly/></td>
                          <td align="center" >
                            <button <?php echo e($ActionStatus); ?> class="btn add aaccount" title="add" data-toggle="tooltip" type="button" ><i class="fa fa-plus"></i></button>
                            <button <?php echo e($ActionStatus); ?> class="btn remove daccount" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button>
                          </td>
                      </tr>
                      <tr></tr>
                  <?php endif; ?>
                  </tbody>

                  <style>
                  .total-row{
                    text-align:right;
                    font-size:13px;
                    font-weight:bold;
                  }
                  .right{
                    text-align:right !important;
                  }
                  </style>
                  <tr>
                    <td class="total-row" colspan="3" style="text-align:center ! important;">TOTAL</td>
                    <td class="total-row" id="AMOUNT_TOTAL"></td>
                    <td class="total-row"></td>
                    <td class="total-row"></td>
                    <td class="total-row" id="AMTIGST_TOTAL"></td>
                    <td class="total-row"></td>
                    <td class="total-row" id="AMTCGST_TOTAL"></td>
                    <td class="total-row"></td>
                    <td class="total-row" id="AMTSGST_TOTAL"></td>
                    <td class="total-row"></td>
                    <td class="total-row"></td>
                    <td class="total-row" id="TOTAMT_TOTAL"></td>
                    <td class="total-row"></td>
                  </tr>

                </table>
            </div>	
        </div>  



        <div id="TDS" class="tab-pane fade in">
            <div class="row" style="margin-top:10px;margin-left:3px;" >	
                <div class="col-lg-1 pl"><p>TDS Applicable</p></div>
                <div class="col-lg-2 pl">
                  <select <?php echo e($ActionStatus); ?> name="drpTDS" id="drpTDS" class="form-control">
                      <option value=""></option>    
                      <option <?php echo e(isset($objPAYHDR->TDS) && $objPAYHDR->TDS =='1'?'selected="selected"':''); ?> value="Yes">Yes</option>
                      <option <?php echo e(isset($objPAYHDR->TDS) && $objPAYHDR->TDS =='0'?'selected="selected"':''); ?> value="No">No</option>
                  </select>
                </div>
            </div>
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                <table id="example7" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                          <tr>
                              <th width="8%">TDS<input class="form-control" type="hidden" name="Row_Count4" id ="Row_Count4"  value="<?php echo e($objCount6); ?>" /></th>
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
                    <?php if(!empty($objPAYMENTTDS)): ?>
                      <?php $__currentLoopData = $objPAYMENTTDS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tkey => $trow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr  class="participantRow7">
                          <td style="text-align:center;" >
                          <input <?php echo e($ActionStatus); ?> type="text" <?php echo e($ActionStatus); ?> name=<?php echo e("txtTDS_".$tkey); ?> id=<?php echo e("txtTDS_".$tkey); ?> class="form-control" value="<?php echo e($trow->CODE); ?>" autocomplete="off"  readonly/></td>
                          <td hidden><input type="hidden" name=<?php echo e("TDSID_REF_".$tkey); ?> id=<?php echo e("TDSID_REF_".$tkey); ?> value="<?php echo e($trow->TDSID_REF); ?>" class="form-control" autocomplete="off" /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text"  name=<?php echo e("TDSLedger_".$tkey); ?> id=<?php echo e("TDSLedger_".$tkey); ?> class="form-control" value="<?php echo e($trow->CODE_DESC); ?>" autocomplete="off"  readonly/></td>
                          <td  align="center" style="text-align:center;" ><input <?php echo e($ActionStatus); ?> type="checkbox" name=<?php echo e("TDSApplicable_".$tkey); ?> id=<?php echo e("TDSApplicable_".$tkey); ?> <?php echo e(isset($trow->TDS_APPLICABLE) && $trow->TDS_APPLICABLE == 1?'checked' : ''); ?>/></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("ASSESSABLE_VL_TDS_".$tkey); ?> id=<?php echo e("ASSESSABLE_VL_TDS_".$tkey); ?> class="form-control two-digits" value="<?php echo e($trow->ASSESSABLE_VL_TDS); ?>" maxlength="15"  autocomplete="off"  /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("TDS_RATE_".$tkey); ?> id=<?php echo e("TDS_RATE_".$tkey); ?> class="form-control four-digits" maxlength="12" value="<?php echo e($trow->TDS_RATE); ?>" autocomplete="off"  /></td>
                          <td hidden><input type="hidden" name=<?php echo e("TDS_EXEMPT_".$tkey); ?> id=<?php echo e("TDS_EXEMPT_".$tkey); ?> class="form-control two-digits" value="0.00" /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("TDS_AMT_".$tkey); ?> id=<?php echo e("TDS_AMT_".$tkey); ?> class="form-control two-digits" maxlength="15"  autocomplete="off"  value="<?php echo e($trow->TDS_AMT); ?>" readonly/></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("ASSESSABLE_VL_SURCHARGE_".$tkey); ?> id=<?php echo e("ASSESSABLE_VL_SURCHARGE_".$tkey); ?> class="form-control two-digits" value="<?php echo e($trow->ASSESSABLE_VL_SURCHARGE); ?>" maxlength="15"  autocomplete="off" /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("SURCHARGE_RATE_".$tkey); ?> id=<?php echo e("SURCHARGE_RATE_".$tkey); ?> class="form-control four-digits" maxlength="12" value="<?php echo e($trow->SURCHARGE_RATE); ?>"  autocomplete="off"  /></td>
                          <td hidden><input type="hidden" name=<?php echo e("SURCHARGE_EXEMPT_".$tkey); ?> id=<?php echo e("SURCHARGE_EXEMPT_".$tkey); ?> class="form-control two-digits" value="0.00" /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("SURCHARGE_AMT_".$tkey); ?> id=<?php echo e("SURCHARGE_AMT_".$tkey); ?> class="form-control two-digits" maxlength="15" value="<?php echo e($trow->SURCHARGE_AMT); ?>" autocomplete="off"  readonly/></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("ASSESSABLE_VL_CESS_".$tkey); ?> id=<?php echo e("ASSESSABLE_VL_CESS_".$tkey); ?> class="form-control two-digits" maxlength="15" value="<?php echo e($trow->ASSESSABLE_VL_CESS); ?>" autocomplete="off" /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("CESS_RATE_".$tkey); ?> id=<?php echo e("CESS_RATE_".$tkey); ?> class="form-control four-digits" maxlength="12" value="<?php echo e($trow->CESS_RATE); ?>" autocomplete="off"  /></td>
                          <td hidden><input type="hidden" name=<?php echo e("CESS_EXEMPT_".$tkey); ?> id=<?php echo e("CESS_EXEMPT_".$tkey); ?> class="form-control two-digits" value="0.00" /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("CESS_AMT_".$tkey); ?> id=<?php echo e("CESS_AMT_".$tkey); ?> class="form-control two-digits" maxlength="15" value="<?php echo e($trow->CESS_AMT); ?>" autocomplete="off"  readonly/></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("ASSESSABLE_VL_SPCESS_".$tkey); ?> id=<?php echo e("ASSESSABLE_VL_SPCESS_".$tkey); ?> class="form-control two-digits" maxlength="15" value="<?php echo e($trow->ASSESSABLE_VL_SPCESS); ?>"  autocomplete="off" /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("SPCESS_RATE_".$tkey); ?> id=<?php echo e("SPCESS_RATE_".$tkey); ?> class="form-control four-digits" maxlength="12" value="<?php echo e($trow->SPCESS_RATE); ?>" autocomplete="off"  /></td>
                          <td hidden><input type="hidden" name=<?php echo e("SPCESS_EXEMPT_".$tkey); ?> id=<?php echo e("SPCESS_EXEMPT_".$tkey); ?> class="form-control two-digits" value="0.00" /></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("SPCESS_AMT_".$tkey); ?> id=<?php echo e("SPCESS_AMT_".$tkey); ?> class="form-control two-digits" maxlength="15" value="<?php echo e($trow->SPCESS_AMT); ?>"  autocomplete="off"  readonly/></td>
                  <?php
                    $TotalTDS=number_format(($trow->TDS_AMT+$trow->SURCHARGE_AMT+$trow->CESS_AMT+$trow->SPCESS_AMT),2, '.', '');
                  ?>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("TOT_TD_AMT_".$tkey); ?> id=<?php echo e("TOT_TD_AMT_".$tkey); ?> class="form-control two-digits" maxlength="15" value="<?php echo e($TotalTDS); ?>"  autocomplete="off"  readonly/></td>
                            <td style="min-width: 100px;" >
                            <button <?php echo e($ActionStatus); ?> class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                            <button <?php echo e($ActionStatus); ?> class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                          </td>
                        </tr>
                        <tr></tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr  class="participantRow7">
                            <td style="text-align:center;" >
                            <input <?php echo e($ActionStatus); ?> type="text" name="txtTDS_0" id="txtTDS_0" class="form-control"  autocomplete="off"  readonly/></td>
                            <td hidden><input type="hidden" name="TDSID_REF_0" id="TDSID_REF_0" class="form-control" autocomplete="off" /></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="TDSLedger_0" id="TDSLedger_0" class="form-control"  autocomplete="off"  readonly/></td>
                            <td  align="center" style="text-align:center;" ><input <?php echo e($ActionStatus); ?> type="checkbox" name="TDSApplicable_0" id="TDSApplicable_0" /></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="ASSESSABLE_VL_TDS_0" id="ASSESSABLE_VL_TDS_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="TDS_RATE_0" id="TDS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name="TDS_EXEMPT_0" id="TDS_EXEMPT_0" class="form-control two-digits" /></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="TDS_AMT_0" id="TDS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="ASSESSABLE_VL_SURCHARGE_0" id="ASSESSABLE_VL_SURCHARGE_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="SURCHARGE_RATE_0" id="SURCHARGE_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name="SURCHARGE_EXEMPT_0" id="SURCHARGE_EXEMPT_0" class="form-control two-digits" /></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="SURCHARGE_AMT_0" id="SURCHARGE_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="ASSESSABLE_VL_CESS_0" id="ASSESSABLE_VL_CESS_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="CESS_RATE_0" id="CESS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name="CESS_EXEMPT_0" id="CESS_EXEMPT_0" class="form-control two-digits" /></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="CESS_AMT_0" id="CESS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="ASSESSABLE_VL_SPCESS_0" id="ASSESSABLE_VL_SPCESS_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="SPCESS_RATE_0" id="SPCESS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                            <td hidden><input type="hidden" name="SPCESS_EXEMPT_0" id="SPCESS_EXEMPT_0" class="form-control two-digits" /></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="SPCESS_AMT_0" id="SPCESS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name="TOT_TD_AMT_0" id="TOT_TD_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                            <td style="min-width: 100px;" >
                            <button <?php echo e($ActionStatus); ?> class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                            <button <?php echo e($ActionStatus); ?> class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button>
                          </td>
                        </tr>
                        <tr></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>	
        </div> 




        <div id="CostCenter" class="tab-pane fade" >
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="margin-top:10px;height:280px;width:50%;">
                <table id="example5" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">
                    <tr >
                        <th>GLID<input class="form-control" type="hidden" name="Row_Count2" id ="Row_Count2" value="<?php echo e($objCount3); ?>"></th>
                        <th>CCID</th>
                        <th>CC_AMT</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($objPAYCCD)): ?>
                      <?php $__currentLoopData = $objPAYCCD; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ckey => $crow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr  class="participantRow5">
                            <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("GLID_".$ckey); ?> id=<?php echo e("GLID_".$ckey); ?> class="form-control"  autocomplete="off" value="<?php echo e($crow->GLID_REF); ?>" readonly/></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("CCID_".$ckey); ?> id={"CCID_".$ckey}} class="form-control" autocomplete="off" value="<?php echo e($crow->CCID_REF); ?>"  readonly/></td>
                            <td><input <?php echo e($ActionStatus); ?> type="text" name=<?php echo e("GL_AMT_".$ckey); ?> id=<?php echo e("GL_AMT_".$ckey); ?> class="form-control two-digits" value="<?php echo e($crow->AMT); ?>"  autocomplete="off" readonly/></td>                        
                        </tr>
                        <tr></tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                      <tr  class="participantRow5">
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="GLID_0" id="GLID_0" class="form-control"  autocomplete="off"  readonly/></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="CCID_0" id="CCID_0" class="form-control" autocomplete="off"   readonly/></td>
                          <td><input <?php echo e($ActionStatus); ?> type="text" name="GL_AMT_0" id="GL_AMT_0" class="form-control two-digits"   autocomplete="off" readonly/></td>                        
                      </tr>
                      <tr></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>      
        
      </div>
    </div>
  </div>
		
	<!-- </div> -->
	</form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('alert'); ?>

<!-- PO Popup starts here   -->
<div id="PO_popup" class="modal" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-md" style="width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="PO_closePopup">&times;</button>
            </div>
            <div class="modal-body">
                <div class="tablename"><p>PO List</p></div>
                <div class="single single-select table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                <input type="hidden" class="mainitem_tab1">
                    <table id="POOrder" class="display nowrap table table-striped table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                            <th style="width:10%;">Select</th> 
                                <th style="width:40%;"> Code</th>
                                <th style="width:40%;"> Name</th>
             
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th style="text-align:center; width:10%;">&#10004;</th>  
                                <td style="width:30%;"> 
                                    <input type="text" id="PONo" class="form-control" onkeyup="PODocFunction()"  />
                                </td>
                                <td style="width:30%;">
                                    <input type="text" id="POName" class="form-control" onkeyup="PONameFunction()"  />
                                </td>
                      
                          
                            </tr>
                        </tbody>
                    </table>
                    <table id="POOrderTable2" class="display nowrap table table-striped table-bordered">
                        <thead id="thead2">
                        <tr>
        
                <td id="Data_seach_PO" colspan="4">please wait...</td>
          </tr>
                        </thead>
                        <tbody id="Dataresult_PO">
                           
                        </tbody>
                    </table>
                </div>
                <div class="cl"></div>
            </div>
        </div>
    </div>
</div>

<!-- Round of GL Popup starts here   -->
<div id="GL_popup" class="modal" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-md" style="width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="GL_closePopup1">&times;</button>
            </div>
            <div class="modal-body">
                <div class="tablename"><p>General Ledger</p></div>
                <div class="single single-select table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                <input type="hidden" class="mainitem_tab1">
                    <table id="GeneralLedger" class="display nowrap table table-striped table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                            <th style="width:10%;">Select</th> 
                                <th style="width:30%;"> Code</th>
                                <th style="width:60%;"> Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th style="text-align:center; width:10%;">&#10004;</th>

                       

                                <td style="width:30%;"> 
                                    <input type="text" id="GLcodesearch" class="form-control" onkeyup="GLCodeFunction()"  />
                                </td>
                                <td style="width:60%;">
                                    <input type="text" id="glnamesearch" class="form-control" onkeyup="GLNameFunction()"  />
                                </td>
                          
                            </tr>
                        </tbody>
                    </table>
                    <table id="GeneralLedgerTable2" class="display nowrap table table-striped table-bordered">
                        <thead id="thead2">
                        <tr>
        
                <td id="item_seach" colspan="4">please wait...</td>
          </tr>
                        </thead>
                        <tbody id="GLresult">
                           
                        </tbody>
                    </table>
                </div>
                <div class="cl"></div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice Dropdown -->
<div id="Invoicepopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width:95%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='Invoice_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Invoice</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="CodeTable" class="display nowrap table  table-striped table-bordered" style="width:100%;">
      <thead>
          <tr id="none-select" class="searchalldata" hidden>
                
                <td> 
                    <input type="hidden" name="hdn_Invoice" id="hdn_Invoice"/>
                    <input type="hidden" name="hdn_Invoice2" id="hdn_Invoice2"/>
                    <input type="hidden" name="hdn_Invoice3" id="hdn_Invoice3"/>
                    <input type="hidden" name="hdn_Invoice33" id="hdn_Invoice33"/>
                    <input type="hidden" name="hdn_Invoice4" id="hdn_Invoice4"/>
                    <input type="hidden" name="hdn_Invoice5" id="hdn_Invoice5"/>
                    <input type="hidden" name="hdn_Invoice6" id="hdn_Invoice6"/>
                    <input type="hidden" name="hdn_Invoice61" id="hdn_Invoice61"/>
                    <input type="hidden" name="hdn_Invoice7" id="hdn_Invoice7"/>
                    <input type="hidden" name="hdn_Invoice8" id="hdn_Invoice8"/>
                    <input type="hidden" name="hdn_Invoice9" id="hdn_Invoice9"/>
                    <input type="hidden" name="hdn_Invoice10" id="hdn_Invoice10"/>
                    <input type="hidden" name="hdn_Invoice11" id="hdn_Invoice11"/>
                    <input type="hidden" name="hdn_Invoice12" id="hdn_Invoice12"/>
                    <input type="hidden" name="hdn_Invoice13" id="hdn_Invoice13"/>
                    <input type="hidden" name="hdn_Invoice14" id="hdn_Invoice14"/>
                    <input type="hidden" name="hdn_Invoice15" id="hdn_Invoice15"/>
                    <input type="hidden" name="hdn_Invoice16" id="hdn_Invoice16"/>
                    <input type="hidden" name="hdn_Invoice17" id="hdn_Invoice17"/>
                    <input type="hidden" name="hdn_Invoice18" id="hdn_Invoice18"/>
                    <input type="hidden" name="hdn_Invoice19" id="hdn_Invoice19"/>
                    <input type="hidden" name="hdn_Invoice20" id="hdn_Invoice20"/>
                    <input type="hidden" name="hdn_Invoice21" id="hdn_Invoice21" value="0"/>
                    <input type="hidden" name="hdn_Invoice22" id="hdn_Invoice22"/>
                    <input type="hidden" name="hdn_Invoice23" id="hdn_Invoice23"/>
                    <input type="hidden" name="hdn_Invoice24" id="hdn_Invoice24"/>
                    <input type="hidden" name="hdn_Invoice25" id="hdn_Invoice25"/>
                    <input type="hidden" name="hdn_Invoice26" id="hdn_Invoice26"/>
                    <input type="hidden" name="hdn_Invoice27" id="hdn_Invoice27"/>
                </td>
          </tr>
          <tr>  
                  <th id="all-check" style="width:10%; text-align: center;">Select</th>
                  <th style="width:15%;">Type</th>
                  <th style="width:10%;">Doc No.</th>
                  <th style="width:10%;">Doc DT</th>
                  <th style="width:15%;">Branch</th>
                  <th style="width:7%;">Total Amount</th>
                  <th style="width:7%;">Balance Amount</th>
                  <th style="width:8%;">Supplier Invoice No</th>
                  <th style="width:8%;">Due Days</th>
				  <th style="width:10%;">Supplier Invoice Date</th>
          </tr>
      </thead>
      <tbody>
        <tr>
        <td style="width:10%; text-align: center;"><input type="checkbox" class="js-selectall" data-target=".js-selectall1" /></td>
          <td style="width:15%;">
            <input type="text" id="typesearch" class="form-control" autocomplete="off" onkeyup="TypeFunction()">
          </td>
          <td style="width:10%;">
            <input type="text" id="docsearch" class="form-control" autocomplete="off" onkeyup="DocFunction()">
          </td>
          <td style="width:10%;">
            <input type="text" id="datesearch" class="form-control" autocomplete="off" onkeyup="DateFunction()">
          </td>
          <td style="width:15%;">
            <input type="text" id="branchsearch" class="form-control" autocomplete="off" onkeyup="BranchFunction()">
          </td>
          <td style="width:7%;">
            <input type="text" id="totalsearch" class="form-control" autocomplete="off" onkeyup="TotalFunction()">
          </td>
          <td style="width:7%;">
            <input type="text" id="balsearch" class="form-control" autocomplete="off" onkeyup="BalFunction()">
          </td>
          <td style="width:8%;">
            <input type="text" id="supplier_invoiceno" class="form-control" autocomplete="off" onkeyup="SupplierInvoiceFunction()">
          </td>
          <td style="width:8%;">
            <input type="text" id="due_day" class="form-control" autocomplete="off" onkeyup="DueDaysFunction()">
          </td>
		  <td style="width:10%;">
            <input type="text" id="supplier_invoicedate" class="form-control" autocomplete="off" onkeyup="SupplierInvoicDateFunction()">
          </td>
        </tr>
      </tbody>
    </table>
    <table id="CodeTable2" class="display nowrap table  table-striped table-bordered" style="width:100%;">
      <thead id="thead2">
      </thead>
      <tbody id="tbody_invoice" style="font-size:12px;">      
      </tbody>
    </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Invoice Dropdown-->

<!--Account dropdown-->

<div id="account_popup" class="modal" role="dialog"  data-backdrop="static">
 <div class="modal-dialog modal-md" style="width:60%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='account_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Account</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="AccountCodeTable" class="display nowrap table  table-striped table-bordered" width="100%">
    <thead>
    <tr id="none-select" class="searchalldata" hidden>                
          <td> 
              <input type="hidden" name="hdn_Account" id="hdn_Account"/>
              <input type="hidden" name="hdn_Account2" id="hdn_Account2"/>
              <input type="hidden" name="hdn_Account3" id="hdn_Account3"/>
              <input type="hidden" name="hdn_Account22" id="hdn_Account22"/>
          </td>
    </tr>
    <tr>
    <th style="width:10%;">Select</th> 
            <th style="width:30%;">Code</th>
            <th style="width:60%;">Name</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <th style="text-align:center; width:10%;">&#10004;</th>
    <td style="width:30%;">
    <input type="text" id="Accountcodesearch" class="form-control" onkeyup="AccountCodeFunction()">
    </td>
    <td style="width:60%;">
    <input type="text" id="Accountnamesearch" class="form-control" onkeyup="AccountNameFunction()">
    </td>
    </tr>
    </tbody>
    </table>
      <table id="AccountCodeTable2" class="display nowrap table  table-striped table-bordered" width="100%">
        <thead id="thead2">
        </thead>
        <tbody id="tbody_account">
        
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>


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
          <td class="ROW2"><input type="text" id="glslcodesearch" class="form-control" autocomplete="off" onkeyup="GLSLCodeFunction()"></td>
          <td class="ROW3"><input type="text" id="glslnamesearch" class="form-control" autocomplete="off" onkeyup="GLSLNameFunction()"></td>
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


<!--Account dropdown-->

<!-- TDS Dropdown -->
<div id="Sectionpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='SectionclosePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Section</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="SectionTable" class="display nowrap table  table-striped table-bordered" width="100%">
    <thead>
    <tr>
            <th>Code</th>
            <th>Name</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>
    <input type="text" id="Sectioncodesearch" onkeyup="SectionCodeFunction()">
    </td>
    <td>
    <input type="text" id="Sectionnamesearch" onkeyup="SectionNameFunction()">
    </td>
    </tr>
    </tbody>
    </table>
      <table id="SectionTable2" class="display nowrap table  table-striped table-bordered" width="100%">
        <thead id="thead2">
         
        </thead>
        <tbody id="tbody_Section">
       
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- TDS Dropdown-->


<!-- Customer / Vendor Dropdown -->
<div id="Custpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width:60%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='CustclosePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p id="titalNamemp">Customer / Vendor</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="CustTable" class="display nowrap table  table-striped table-bordered" width="100%">
    <thead>
    <tr>
            <th style="width:10%;">Select</th>
            <th style="width:30%;">Code</th>
            <th style="width:60%;">Name</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <th style="text-align:center; width:10%;">&#10004;</th>
   <td style="width:30%;"> 

    <input type="text" id="Custcodesearch" class="form-control"  onkeyup="CustomerCodeFunction('<?php echo e($FormId); ?>')">
    </td>
    <td  style="width:60%;">
    <input type="text" id="Custnamesearch" class="form-control" onkeyup="CustomerNameFunction('<?php echo e($FormId); ?>')">
    </td>
    </tr>
    </tbody>
    </table>
      <table id="CustTable2" class="display nowrap table  table-striped table-bordered" width="100%">
        <thead id="thead2">
        <tr>
        
 
          </tr>
        </thead>
        <tbody id="tbody_Cust">
       
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Customer / Vendor Dropdown-->
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
        <?php $__currentLoopData = $objothcurrency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crindex=>$crRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td class="ROW1"> <input type="checkbox" name="SELECT_CRID[]" id="cridcode_<?php echo e($crindex); ?>" class="clscrid" value="<?php echo e($crRow-> CRID); ?>" ></td>
          <td class="ROW2"><?php echo e($crRow-> CRCODE); ?>

            <input type="hidden" id="txtcridcode_<?php echo e($crindex); ?>" data-desc="<?php echo e($crRow-> CRCODE); ?>" data-desc2="<?php echo e($crRow-> CRDESCRIPTION); ?>"  value="<?php echo e($crRow-> CRID); ?>"/>
          </td>
          <td class="ROW3"><?php echo e($crRow-> CRDESCRIPTION); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Currency Dropdown-->  

<!--Cost Centre dropdown-->

<div id="costpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width:100%;">
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
            <th style="width:20%;">Account Code</th>
            <th style="width:20%;">Account Name</th>
            <th style="width:20%;">Cost Centre Code</th>
            <th style="width:20%;">Amount</th>
            <th style="width:20%;">Action</th>
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
          <tr class="participantRow9">
            <td style="width:20%;">
            <input type="text" name="ppGLID_0" id="ppGLID_0" class="form-control"  autocomplete="off"  readonly/></td>
            <td hidden><input type="hidden" name="hdnGLID_0" id="hdnGLID_0" class="form-control" autocomplete="off" /></td>
            <td style="width:20%;"><input type="text" name="hdnGLName_0" id="hdnGLName_0" class="form-control"  autocomplete="off"  readonly/></td>
            <td style="width:20%;"><input type="text" name="CostCenter_0" id="CostCenter_0" class="form-control" maxlength="20"  autocomplete="off" readonly  /></td>
            <td hidden><input type="hidden" name="hdnCCID_0" id="hdnCCID_0" class="form-control" autocomplete="off" /></td>
            <td style="width:20%;"><input type="text" name="hdnAMT_0" id="hdnAMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
            <td style="width:20%;"><button class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
            <button class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button></td>
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
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='closeppcostcenter' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Cost Center</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="ppcostcenter1" class="display nowrap table  table-striped table-bordered" width="100%">
    <thead>
    <tr id="none-select" class="searchalldata" hidden>
            <td> <input type="hidden" name="hdn_cc1" id="hdn_cc1"/>
            <input type="hidden" name="hdn_cc2" id="hdn_cc2"/></td>
    </tr>
    <tr>
            <th>Code</th>
            <th>Name</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>
    <input type="text" id="ppcostcodesearch" onkeyup="ppcostCodeFunction()">
    </td>
    <td>
    <input type="text" id="ppcostnamesearch" onkeyup="ppcostNameFunction()">
    </td>
    </tr>
    </tbody>
    </table>
      <table id="ppcostcenter2" class="display nowrap table  table-striped table-bordered" width="100%">
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

<!--Cost Centre dropdown-->

<!--Bank dropdown Header Part-->

<div id="bank_popup" class="modal" role="dialog"  data-backdrop="static">
 <div class="modal-dialog modal-md" style="width:90%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='bank_closePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Bank Master</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="BankCodeTable" class="display nowrap table  table-striped table-bordered" style="width:100%;">
    <thead>    
    <tr>

      <th style="width:6%;">Select</th> 
            <th style="width:10%;">Code</th>
            <th style="width:14%;">Name</th>
            <th style="width:14%;">Branch</th>
            <th style="width:14%;">IFSC</th>
            <th style="width:14%;">Account Type</th>
            <th style="width:14%;">Account Number</th>
            <th style="width:14%;">Address</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <th style="text-align:center; width:6%;">&#10004;</th>
      <td style="width:10%;">
        <input type="text" id="bankcodesearch" class="form-control" onkeyup="BankCodeFunction()">
      </td>
      <td style="width:14%;">
        <input type="text" id="banknamesearch" class="form-control"  onkeyup="BankNameFunction()">
      </td>
      <td style="width:14%;">
        <input type="text" id="bankbranchsearch" class="form-control" onkeyup="BankBranchFunction()">
      </td>
      <td style="width:14%;">
        <input type="text" id="bankifscsearch" class="form-control" onkeyup="BankIFSCFunction()">
      </td>
      <td style="width:14%;">
        <input type="text" id="bankacctypesearch" class="form-control" onkeyup="BankAccTypeFunction()">
      </td>
      <td style="width:14%;">
        <input type="text" id="bankaccnumbersearch" class="form-control" onkeyup="BankAccNumberFunction()">
      </td>
      <td style="width:14%;">
        <input type="text" id="bankaddresssearch" class="form-control" onkeyup="BankAddressFunction()">
      </td>
    </tr>
    </tbody>
    </table>
      <table id="BankCodeTable2" class="display nowrap table  table-striped table-bordered" style="width:100%;">
        <thead id="thead2">
        </thead>
        <tbody id="tbody_bank" style="font-size:12px;">
        <?php $__currentLoopData = $objBank; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$bkRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $objSONO=NULL;
        if(isset($bkRow) && !empty($bkRow)){ if($bkRow->SYSTEM_GRSR == "1"){if($bkRow->PREFIX_RQ == "1"){$objSONO = $bkRow->PREFIX;}        
            if($bkRow->PRE_SEP_RQ == "1") { if($bkRow->PRE_SEP_SLASH == "1") {$objSONO = $objSONO.'/'; }
            if($bkRow->PRE_SEP_HYPEN == "1") { $objSONO = $objSONO.'-'; } }        
            if($bkRow->NO_MAX){$objSONO = $objSONO.str_pad($bkRow->LAST_RECORDNO+1, $bkRow->NO_MAX, "0", STR_PAD_LEFT);}            
            if($bkRow->NO_SEP_RQ == "1"){if($bkRow->NO_SEP_SLASH == "1"){$objSONO = $objSONO.'/';}if($bkRow->NO_SEP_HYPEN == "1"){
            $objSONO = $objSONO.'-'; } } if($bkRow->SUFFIX_RQ == "1") { $objSONO = $objSONO.$bkRow->SUFFIX; } } } ?>
          <tr>
          <td style="text-align:center; width:6%"> <input type="checkbox"    id="bkidcode_<?php echo e($index); ?>" class="clsbkid" value="<?php echo e($bkRow->BID); ?>" name="bankcash[]" ></td>
              <td style="width:10%;"><?php echo e($bkRow-> BCODE); ?>

                <input type="hidden" id="txtbkidcode_<?php echo e($index); ?>" 
                data-desc="<?php echo e($bkRow-> BCODE); ?>" 
                data-desc2="<?php echo e($bkRow-> NAME); ?>"  
                data-desc3="<?php echo e($bkRow-> BANK_CASH); ?>" 
                data-glid_ref="<?php echo e($bkRow->GLID_REF); ?>" 
                data-odlimit="<?php echo e($bkRow->ODLIMIT !=''? $bkRow->ODLIMIT:'0.00'); ?>" 
                data-prftype="<?php echo e(isset($objSONO)?$objSONO:''); ?>" value="<?php echo e($bkRow-> BID); ?>"/>
              </td>
              <td style="width:14%;"><?php echo e($bkRow-> NAME); ?></td>
              <td style="width:14%;"><?php echo e($bkRow-> BRANCH); ?></td>
              <td style="width:14%;"><?php echo e($bkRow-> IFSC); ?></td>
              <td style="width:14%;"><?php echo e($bkRow-> ACTYPE); ?></td>
              <td style="width:14%;"><?php echo e($bkRow-> ACNO); ?></td>
              <td style="width:14%;"><?php echo e($bkRow-> ADD1); ?> <?php echo e($bkRow-> ADD2); ?> <?php echo e($bkRow-> CITY); ?> <?php echo e($bkRow-> STATE); ?> <?php echo e($bkRow-> COUNTRY); ?> <?php echo e($bkRow-> PIN); ?></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!--Bank dropdown Header Part-->

<!--Bank dropdown Account Tab-->

<div id="bank2_popup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width:90%;">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" id='bank2_closePopup' >&times;</button>
       </div>
     <div class="modal-body">
     <div class="tablename"><p>Bank Master</p></div>
     <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
     <table id="Bank2CodeTable" class="display nowrap table  table-striped table-bordered" style="width:100%;">
     <thead> 
      <tr id="none-select" class="searchalldata" hidden>                
        <td> 
            <input type="hidden" name="hdn_bank1" id="hdn_bank1"/>
            <input type="hidden" name="hdn_bank12" id="hdn_bank12"/>
            <input type="hidden" name="hdn_bank13" id="hdn_bank13"/>
        </td>
    </tr>   
     <tr>
 
      <th style="width:6%;">Select</th> 
      <th style="width:10%;">Code</th>
      <th style="width:14%;">Name</th>
      <th style="width:14%;">Branch</th>
      <th style="width:14%;">IFSC</th>
      <th style="width:14%;">Account Type</th>
      <th style="width:14%;">Account Number</th>
      <th style="width:14%;">Address</th>
     </tr>
     </thead>
     <tbody>
     <tr>
     <th style="text-align:center; width:6%;">&#10004;</th>
       <td style="width:10%;">
         <input type="text" id="bank2codesearch" class="form-control" onkeyup="Bank2CodeFunction()">
       </td>
       <td style="width:14%;">
         <input type="text" id="bank2namesearch" class="form-control"  onkeyup="Bank2NameFunction()">
       </td>
       <td style="width:14%;">
         <input type="text" id="bank2branchsearch" class="form-control" onkeyup="Bank2BranchFunction()">
       </td>
       <td style="width:14%;">
         <input type="text" id="bank2ifscsearch" class="form-control" onkeyup="Bank2IFSCFunction()">
       </td>
       <td style="width:14%;">
         <input type="text" id="bank2acctypesearch" class="form-control" onkeyup="Bank2AccTypeFunction()">
       </td>
       <td style="width:14%;">
         <input type="text" id="bank2accnumbersearch" class="form-control" onkeyup="Bank2AccNumberFunction()">
       </td>
       <td style="width:14%;">
         <input type="text" id="bank2addresssearch" class="form-control" onkeyup="Bank2AddressFunction()">
       </td>
     </tr>
     </tbody>
     </table>
       <table id="Bank2CodeTable2" class="display nowrap table  table-striped table-bordered" style="width:100%;">
         <thead id="thead2">
         </thead>
         <tbody id="tbody_bank2" style="font-size:12px;">
         <?php $__currentLoopData = $objBank; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$bkRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>         
           <tr>
           <td style="text-align:center; width:6%"> <input type="checkbox"    id="bkidcode2_<?php echo e($index); ?>" class="clsbk2id" value="<?php echo e($bkRow->BID); ?>" name="cashbank2[]" ></td>
               <td style="width:10%;"><?php echo e($bkRow-> BCODE); ?>

                <input type="hidden" id="txtbkidcode2_<?php echo e($index); ?>" data-desc="<?php echo e($bkRow-> BCODE); ?>" data-desc2="<?php echo e($bkRow-> NAME); ?>" data-glid_ref="<?php echo e($bkRow->GLID_REF); ?>" data-odlimit="<?php echo e($bkRow->ODLIMIT !=''? $bkRow->ODLIMIT:'0.00'); ?>"  value="<?php echo e($bkRow-> BID); ?>"/>
               </td>
               <td style="width:14%;"><?php echo e($bkRow-> NAME); ?></td>
               <td style="width:14%;"><?php echo e($bkRow-> BRANCH); ?></td>
               <td style="width:14%;"><?php echo e($bkRow-> IFSC); ?></td>
               <td style="width:14%;"><?php echo e($bkRow-> ACTYPE); ?></td>
               <td style="width:14%;"><?php echo e($bkRow-> ACNO); ?></td>
               <td style="width:14%;"><?php echo e($bkRow-> ADD1); ?> <?php echo e($bkRow-> ADD2); ?> <?php echo e($bkRow-> CITY); ?> <?php echo e($bkRow-> STATE); ?> <?php echo e($bkRow-> COUNTRY); ?> <?php echo e($bkRow-> PIN); ?></td>
           </tr>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
       </table>
     </div>
     <div class="cl"></div>
       </div>
     </div>
   </div>
 </div>
<!--Bank dropdown Account Tab-->

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



<?php $__env->stopSection(); ?>


<?php $__env->startPush('bottom-css'); ?>
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
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('bottom-scripts'); ?>
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
  //Invoicepopup 
  let cltid = "#CodeTable2";
    let cltid2 = "#CodeTable";
    let clheaders = document.querySelectorAll(cltid2 + " th");

      // Sort the table element when clicking on the table headers
      clheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(cltid, ".clsclid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function TypeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("typesearch");
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

  function DocFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("docsearch");
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

  function DateFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("datesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("CodeTable2");
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

  function BranchFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("branchsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("CodeTable2");
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

  function TotalFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("totalsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("CodeTable2");
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

  function BalFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("balsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("CodeTable2");
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
  function SupplierInvoiceFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("supplier_invoiceno");
        filter = input.value.toUpperCase();
        table = document.getElementById("CodeTable2");
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
  function DueDaysFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("due_day");
        filter = input.value.toUpperCase();
        table = document.getElementById("CodeTable2");
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
  
  function SupplierInvoicDateFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("supplier_invoicedate");
        filter = input.value.toUpperCase();
        table = document.getElementById("CodeTable2");
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

  $('#Invoice').on('click','[id*="txtDoc_NO_"]',function(event){
    var CommonValue           =   $('#hdnpaymentfor').val();
    if($('#CENTERLIZED_PAYMENT').is(':checked') == true)
    {
      var centralized = 1;
    }
    else
    {
      var centralized = 0;
    }
    var Customid              =   $("#CUSTMER_VENDOR_ID").val();
    if(Customid != '')
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'<?php echo e(route("transaction",[$FormId,"getCustVdrDocument"])); ?>',
            type:'POST',
            data:{'CommonValue':CommonValue,'Customid':Customid, 'centralized':centralized},
            success:function(data){
              $("#tbody_invoice").html(data);
              bindInvoiceDocument();                    
            },
            error:function(data){
              console.log("Error: Something went wrong.");
              $("#tbody_invoice").html('');                        
            },
        });
    }
    $("#Invoicepopup").show();  

        var id = $(this).attr('id');
        var id2 = $(this).parent().parent().find('[id*="DOCNO_ID"]').attr('id');
        var id3 = $(this).parent().parent().find('[id*="Doc_Type_"]').attr('id');
        var id33 = $(this).parent().parent().find('[id*="Supplier_InvoiceNo_"]').attr('id');
        var id4 = $(this).parent().parent().find('[id*="DocDate_"]').attr('id');
        var id5 = $(this).parent().parent().find('[id*="DocAmount_"]').attr('id');
        var id6 = $(this).parent().parent().find('[id*="BALANCE_DUE_"]').attr('id');
        var id61 = $(this).parent().parent().find('[id*="PAYMENT_AMT_"]').attr('id');
        var id7 = $(this).parent().parent().find('[id*="TxtBranch_"]').attr('id');
        var id8 = $(this).parent().parent().find('[id*="BRID_REF_"]').attr('id');


        $('#hdn_Invoice').val(id);
        $('#hdn_Invoice2').val(id2);
        $('#hdn_Invoice3').val(id3);
        $('#hdn_Invoice33').val(id33);
        $('#hdn_Invoice4').val(id4);
        $('#hdn_Invoice5').val(id5);
        $('#hdn_Invoice6').val(id6);
        $('#hdn_Invoice7').val(id7);
        $('#hdn_Invoice8').val(id8);
        $('#hdn_Invoice61').val(id61);

      event.preventDefault();
  });

  $("#Invoice_closePopup").click(function(event){
    $("#Invoicepopup").hide();
    $('.js-selectall').prop("checked", false);
    event.preventDefault();
  });

  function bindInvoiceDocument(){
      $('#CodeTable2').off(); 
      $('.js-selectall').change(function(){
        var isChecked = $(this).prop("checked");
        var selector = $(this).data('target');
        $(selector).prop("checked", isChecked);

        $('#CodeTable2').find('.clsinvoiceid').each(function(){

          var fieldid   =   $(this).attr('id');
          var txtval    =   $("#txt"+fieldid+"").val();
          var txtdocno  =   $("#txt"+fieldid+"").data("desc")
          var txtdocdt  =   $("#txt"+fieldid+"").data("desc2")
          var txtbranch =   $("#txt"+fieldid+"").data("desc3")
          var txtdocamt =   $("#txt"+fieldid+"").data("desc4")
          var txtbalamt =   $("#txt"+fieldid+"").data("desc5")
          var txtbrdid  =   $("#txt"+fieldid+"").data("desc6")
          var txtsource =   $("#txt"+fieldid+"").data("desc7"); 
          var txtsuppinvno  =   $("#txt"+fieldid+"").data("desc8");       
     

          var INVOICE = [];
          $('#example2').find('.participantRow2').each(function(){
            if($(this).find('[id*="txtDoc_NO_"]').val() != '')
            {
              var item = $(this).find('[id*="txtDoc_NO_"]').val();
              INVOICE.push(item);
            }
          });
          if($(this).find('[id*="chkId"]').is(":checked") == true) 
          {

              var txtinvoice = txtdocno;

              if(jQuery.inArray(txtinvoice, INVOICE) !== -1)
              {
                    $("#Invoicepopup").hide();
                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn").hide();
                    $("#OkBtn1").show();
                    $("#AlertMessage").text('Document already exists.');
                    $("#alert").modal('show');
                    $("#OkBtn1").focus();
                    highlighFocusBtn('activeOk1');
                    $('#hdn_Invoice').val('');
                    $('#hdn_Invoice2').val('');
                    $('#hdn_Invoice3').val('');
                    $('#hdn_Invoice33').val('');
                    $('#hdn_Invoice4').val('');
                    $('#hdn_Invoice5').val('');
                    $('#hdn_Invoice6').val('');
                    $('#hdn_Invoice61').val('');
                    $('#hdn_Invoice7').val('');
                    $('#hdn_Invoice8').val('');
                    $('#hdn_Invoice9').val('');
                    txtval = '';
                    txtdocno = '';
                    txtdocdt = '';
                    txtbranch = '';
                    txtdocamt = '';
                    txtbalamt = '';
                    txtbrdid = '';
                    txtsource = '';
                    txtsuppinvno = '';
                    $('.js-selectall').prop("checked", false);
                    return false;
                    event.preventDefault();
              }

              if($('#hdn_Invoice').val() == "" && txtval != '')
              {
                
                var $tr = $('.ainvoice').closest('table');
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

                $clone.find('.remove').removeAttr('disabled'); 
                $clone.find('[id*="txtDoc_NO_"]').val(txtdocno);
                $clone.find('[id*="DOCNO_ID_"]').val(txtval);
                $clone.find('[id*="Doc_Type_"]').val(txtsource);
                $clone.find('[id*="Supplier_InvoiceNo_"]').val(txtsuppinvno);
                $clone.find('[id*="DocDate_"]').val(txtdocdt);
                $clone.find('[id*="TxtBranch_"]').val(txtbranch);
                $clone.find('[id*="BRID_REF_"]').val(txtbrdid);
                $clone.find('[id*="DocAmount_"]').val(txtdocamt);
                $clone.find('[id*="BALANCE_DUE_"]').val(txtbalamt);
                $clone.find('[id*="PAYMENT_AMT_"]').val(txtbalamt);
                $tr.closest('table').append($clone);   
                var rowCount = $('#Row_Count1').val();
                rowCount = parseInt(rowCount)+1;
                $('#Row_Count1').val(rowCount);

                $('#hdn_Invoice').val('');
                $('#hdn_Invoice2').val('');
                $('#hdn_Invoice3').val('');
                $('#hdn_Invoice33').val('');
                $('#hdn_Invoice4').val('');
                $('#hdn_Invoice5').val('');
                $('#hdn_Invoice6').val('');
                $('#hdn_Invoice61').val('');
                $('#hdn_Invoice7').val('');
                $('#hdn_Invoice8').val('');
                $('#hdn_Invoice9').val('');

                event.preventDefault();
              }
              else
              {

                var txtid= $('#hdn_Invoice').val();
                var txt_id2= $('#hdn_Invoice2').val();
                var txt_id3= $('#hdn_Invoice3').val();
                var txt_id33= $('#hdn_Invoice33').val();
                var txt_id4= $('#hdn_Invoice4').val();
                var txt_id5= $('#hdn_Invoice5').val();
                var txt_id6= $('#hdn_Invoice6').val();
                var txt_id61= $('#hdn_Invoice61').val();
                var txt_id7= $('#hdn_Invoice7').val();
                var txt_id8= $('#hdn_Invoice8').val();
               

               

                $('#'+txtid).val(txtdocno);
                $('#'+txt_id2).val(txtval);
                $('#'+txt_id3).val(txtsource);
                $('#'+txt_id33).val(txtsuppinvno);
                $('#'+txt_id4).val(txtdocdt);
                $('#'+txt_id5).val(txtdocamt);
                $('#'+txt_id6).val(txtbalamt);
                $('#'+txt_id7).val(txtbranch);
                $('#'+txt_id8).val(txtbrdid);
                $('#'+txt_id61).val(txtbalamt);
               
              


                

                $('#hdn_Invoice').val('');
                $('#hdn_Invoice2').val('');
                $('#hdn_Invoice3').val('');
                $('#hdn_Invoice33').val('');
                $('#hdn_Invoice4').val('');
                $('#hdn_Invoice5').val('');
                $('#hdn_Invoice6').val('');
                $('#hdn_Invoice61').val('');
                $('#hdn_Invoice7').val('');
                $('#hdn_Invoice8').val('');
                $('#hdn_Invoice61').val('');
                event.preventDefault();
              }
          }
          else if($(this).find('[id*="chkId"]').is(":checked") == false)
          {
       
            var invoice  = txtdocno;
            $('#example2').find('.participantRow2').each(function()
            {
              var docno = $(this).find('[id*="txtDoc_NO_"]').val();

              if(docno == invoice)
              {
                  var rowCount = $('#Row_Count1').val();
                  if (rowCount > 1) {
                    $(this).closest('.participantRow2').remove(); 
                    rowCount = parseInt(rowCount)-1;
                    $('#Row_Count1').val(rowCount);
                    event.preventDefault();
                  }
                  else 
                  {
                    $(document).find('.dinvoice').prop('disabled', true);  
                    $("#Invoicepopup").hide();
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
            // event.preventDefault();
          }

          // $("#Invoicepopup").hide();
          $("#typesearch").val(''); 
          $("#docsearch").val(''); 
          $("#datesearch").val(''); 
          $("#branchsearch").val('');
          $("#totalsearch").val(''); 
          $("#balancesearch").val('');
          $('.remove').removeAttr('disabled'); 
      //    DocFunction();
          bindTotalValue();
          
          event.preventDefault();
        });
        event.preventDefault();
      });
      $('[id*="chkId"]').change(function(){

        var fieldid   =   $(this).parent().parent().attr('id');
        var txtval    =   $("#txt"+fieldid+"").val();
        var txtdocno  =   $("#txt"+fieldid+"").data("desc")
        var txtdocdt  =   $("#txt"+fieldid+"").data("desc2")
        var txtbranch =   $("#txt"+fieldid+"").data("desc3")
        var txtdocamt =   $("#txt"+fieldid+"").data("desc4")
        var txtbalamt =   $("#txt"+fieldid+"").data("desc5")
        var txtbrdid  =   $("#txt"+fieldid+"").data("desc6")
        var txtsource =   $("#txt"+fieldid+"").data("desc7");
        var txtsuppinvno  =   $("#txt"+fieldid+"").data("desc8");

        var INVOICE = [];
        $('#example2').find('.participantRow2').each(function(){
          if($(this).find('[id*="txtDoc_NO_"]').val() != '')
          {
            var item = $(this).find('[id*="txtDoc_NO_"]').val();
            INVOICE.push(item);
          }
        });

        if($(this).is(":checked") == true) 
          {

              var txtinvoice = txtdocno;

              if(jQuery.inArray(txtinvoice, INVOICE) !== -1)
              {
                    $("#Invoicepopup").hide();
                    $("#YesBtn").hide();
                    $("#NoBtn").hide();
                    $("#OkBtn").hide();
                    $("#OkBtn1").show();
                    $("#AlertMessage").text('Document already exists.');
                    $("#alert").modal('show');
                    $("#OkBtn1").focus();
                    highlighFocusBtn('activeOk1');
                    $('#hdn_Invoice').val('');
                    $('#hdn_Invoice2').val('');
                    $('#hdn_Invoice3').val('');
                    $('#hdn_Invoice33').val('');
                    $('#hdn_Invoice4').val('');
                    $('#hdn_Invoice5').val('');
                    $('#hdn_Invoice6').val('');
                    $('#hdn_Invoice7').val('');
                    $('#hdn_Invoice8').val('');
                    $('#hdn_Invoice61').val('');
                    txtval = '';
                    txtdocno = '';
                    txtdocdt = '';
                    txtbranch = '';
                    txtdocamt = '';
                    txtbalamt = '';
                    txtbrdid = '';
                    txtsource = '';
                    txtsuppinvno = '';
                    $('.js-selectall').prop("checked", false);
                    return false;
                    event.preventDefault();
              }

              if($('#hdn_Invoice').val() == "" && txtval != '')
              {
                
                var $tr = $('.ainvoice').closest('table');
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

                $clone.find('.dinvoice').removeAttr('disabled'); 
                $clone.find('[id*="txtDoc_NO_"]').val(txtdocno);
                $clone.find('[id*="DOCNO_ID_"]').val(txtval);
                $clone.find('[id*="Doc_Type_"]').val(txtsource);
                $clone.find('[id*="Supplier_InvoiceNo_"]').val(txtsuppinvno);
                $clone.find('[id*="DocDate_"]').val(txtdocdt);
                $clone.find('[id*="TxtBranch_"]').val(txtbranch);
                $clone.find('[id*="BRID_REF_"]').val(txtbrdid);
                $clone.find('[id*="DocAmount_"]').val(txtdocamt);
                $clone.find('[id*="BALANCE_DUE_"]').val(txtbalamt);
                $clone.find('[id*="PAYMENT_AMT_"]').val(txtbalamt);
                $tr.closest('table').append($clone);   
                var rowCount = $('#Row_Count1').val();
                rowCount = parseInt(rowCount)+1;
                $('#Row_Count1').val(rowCount);

                $('#hdn_Invoice').val('');
                $('#hdn_Invoice2').val('');
                $('#hdn_Invoice3').val('');
                $('#hdn_Invoice33').val('');
                $('#hdn_Invoice4').val('');
                $('#hdn_Invoice5').val('');
                $('#hdn_Invoice6').val('');
                $('#hdn_Invoice7').val('');
                $('#hdn_Invoice8').val('');
                $('#hdn_Invoice61').val('');

                event.preventDefault();
              }
              else
              {

                var txtid= $('#hdn_Invoice').val();
                var txt_id2= $('#hdn_Invoice2').val();
                var txt_id3= $('#hdn_Invoice3').val();
                var txt_id33= $('#hdn_Invoice33').val();
                var txt_id4= $('#hdn_Invoice4').val();
                var txt_id5= $('#hdn_Invoice5').val();
                var txt_id6= $('#hdn_Invoice6').val();
                var txt_id7= $('#hdn_Invoice7').val();
                var txt_id8= $('#hdn_Invoice8').val();
                var txt_id61= $('#hdn_Invoice61').val();

                $('#'+txtid).val(txtdocno);
                $('#'+txt_id2).val(txtval);
                $('#'+txt_id3).val(txtsource);
                $('#'+txt_id33).val(txtsuppinvno);
                $('#'+txt_id4).val(txtdocdt);
                $('#'+txt_id5).val(txtdocamt);
                $('#'+txt_id6).val(txtbalamt);
                $('#'+txt_id7).val(txtbranch);
                $('#'+txt_id8).val(txtbrdid);
                $('#'+txt_id61).val(txtbalamt);
                
                

                

               
              

                $('#hdn_Invoice').val('');
                $('#hdn_Invoice2').val('');
                $('#hdn_Invoice3').val('');
                $('#hdn_Invoice33').val('');
                $('#hdn_Invoice4').val('');
                $('#hdn_Invoice5').val('');
                $('#hdn_Invoice6').val('');
                $('#hdn_Invoice7').val('');
                $('#hdn_Invoice8').val('');
                // event.preventDefault();
              }
          }
          else if($(this).is(":checked") == false)
          {
            var invoice  = txtdocno;
            $('#example2').find('.participantRow2').each(function()
            {
              var docno = $(this).find('[id*="txtDoc_NO_"]').val();

              if(docno == invoice)
              {
                  var rowCount = $('#Row_Count1').val();
                  if (rowCount > 1) {
                    $(this).closest('.participantRow2').remove(); 
                    rowCount = parseInt(rowCount)-1;
                    $('#Row_Count1').val(rowCount);
                    event.preventDefault();
                  }
                  else 
                  {
                    $(document).find('.dinvoice').prop('disabled', true);  
                    $("#Invoicepopup").hide();
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
                // event.preventDefault(); 
              }
            });
            // event.preventDefault();
          }

          // $("#Invoicepopup").hide();
          $("#typesearch").val(''); 
          $("#docsearch").val(''); 
          $("#datesearch").val(''); 
          $("#branchsearch").val('');
          $("#totalsearch").val(''); 
          $("#balancesearch").val('');
       //   DocFunction();
          bindTotalValue();
          event.preventDefault();

      });
  }
  //Invoicepopup Ends
//------------------------

//------------------------
  //CUSTOMER LIST POPUP
  let cltids = "#CustTable2";
      let cltids2 = "#CustTable";
      let custheaders = document.querySelectorAll(cltids2 + " th");

      // Sort the table element when clicking on the table headers
      custheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(cltids, ".clsglid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function CustomerCodeFunction(FORMID) {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("Custcodesearch");
        filter = input.value.toUpperCase();
        
      if(filter.length == 0)
        {
          var CODE = ''; 
          var NAME = ''; 
          loadCustomer(CODE,NAME,FORMID); 
        }
        else if(filter.length >= 3)
        {
          var CODE = filter; 
          var NAME = ''; 
          loadCustomer(CODE,NAME,FORMID); 
        }
        else
        {
          table = document.getElementById("CustTable2");
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

  function CustomerNameFunction(FORMID) {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("Custnamesearch");
        filter = input.value.toUpperCase();
        if(filter.length == 0)
        {
          var CODE = ''; 
          var NAME = ''; 
          loadCustomer(CODE,NAME,FORMID);
        }
        else if(filter.length >= 3)
        {
          var CODE = ''; 
          var NAME = filter; 
          loadCustomer(CODE,NAME,FORMID);  
        }
        else
        {
          table = document.getElementById("CustTable2");
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
    
    function loadCustomer(CODE,NAME,FORMID){
      var CommonValue = $('#hdnpaymentfor').val();     
       
      
      if(CommonValue=='Customer'){
      var url	=	'<?php echo asset('');?>transaction/'+FORMID+'/getsubledger_customer';
      }else if(CommonValue=='Vendor'){
      var url	=	'<?php echo asset('');?>transaction/'+FORMID+'/getsubledger_vendor';
      }else if(CommonValue=='Employee'){
      var url	=	'<?php echo asset('');?>transaction/'+FORMID+'/getsubledger_employee';
      }
        $("#tbody_Cust").html('');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url:url,
          type:'POST',
          data:{'CODE':CODE,'NAME':NAME,'EMPVALUE':CommonValue},
          success:function(data) {
          $("#tbody_Cust").html(data); 
          bindCustomerVendor(); 
          showSelectedCheck($("#CUSTMER_VENDOR_ID").val(),"customer_vendorid");

          },
          error:function(data){
          console.log("Error: Something went wrong.");
          $("#tbody_Cust").html('');                        
          },
        });


    }

//------------------------
 

  $('#txtcustomer').on('click',function(event){
 
    var CODE = ''; 
    var NAME = ''; 
    var FORMID = "<?php echo e($FormId); ?>";
    loadCustomer(CODE,NAME,FORMID);
    var CommonValue = $('#hdnpaymentfor').val();
    
    if(CommonValue=='Employee'){
      $('#titalNamemp').html('Employee Details');
    }
    
      // $("#tbody_Cust").html('');
      //   $.ajaxSetup({
      //       headers: {
      //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //       }
      //   });


      //   $.ajax({
      //       url:'<?php echo e(route("transaction",[$FormId,"getCustVendor"])); ?>',
      //       type:'POST',
      //       data:{'CommonValue':CommonValue},
      //       success:function(data) {
    
      //         $("#tbody_Cust").html(data);    
      //         bindCustomerVendor();                    
      //       },
      //       error:function(data){
      //         console.log("Error: Something went wrong.");
      //         $("#tbody_Cust").html('');                        
      //       },
      //   });

    
    


      
    $("#Custpopup").show();    
    event.preventDefault();
  });

  $("#CustclosePopup").click(function(event){
    $("#Custpopup").hide();
    event.preventDefault();
  });

  function bindCustomerVendor(){
    $(".clscustid").click(function(){
         
          var fieldid               =   $(this).attr('id');
          var txtval                =   $("#txt"+fieldid+"").val();
          var texdesc               =   $("#txt"+fieldid+"").data("desc")+'-'+$("#txt"+fieldid+"").data("desc2"); 
          var oldCUSTMER_VENDOR_ID  =   $("#CUSTMER_VENDOR_ID").val();
          var InvoiceClone          =   $('#hdnInvoice').val(); 

          
          $('#txtcustomer').val(texdesc);
          $('#CUSTMER_VENDOR_ID').val(txtval);


          $('#txtcustomer').val(texdesc);
          $('#CUSTMER_VENDOR_ID').val(txtval);
          $('#txtPOpopup').val('');
          $('#PODT').val('');


          var TDSClone = $('#hdnTDS').val();       


          if (txtval != oldCUSTMER_VENDOR_ID)
          {
              $('#Invoice').html(InvoiceClone);
           
              $('#TDS').html(TDSClone);
   
              $('#Row_Count6').val('1');


              var CommonValue =   $('#hdnpaymentfor').val();
              
              var customid=txtval; 
              if(CommonValue=='Vendor'){
              $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  })

                  $.ajax({
                      url:'<?php echo e(route("transaction",[301,"getTDSApplicability"])); ?>',
                      type:'POST',
                      data:{'id':customid},
                      success:function(data){
                        if(data == 1){

                          $('#drpTDS').val('Yes');
                              $.ajaxSetup({
                                  headers: {
                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  }
                              });
                              $.ajax({
                                  url:'<?php echo e(route("transaction",[301,"getTDSDetails"])); ?>',
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
							  $.ajax({
                                  url:'<?php echo e(route("transaction",[301,"getTDSDetailsCount"])); ?>',
                                  type:'POST',
                                  data:{'id':customid},
                                  success:function(data) {
                                    $("#Row_Count4").val(data);
                                    
                                  },
                                  error:function(data){
                                    $("#Row_Count4").val(1);
                                    
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
        }else if(CommonValue=='Customer'){
          $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  })

                  $.ajax({
                      url:'<?php echo e(route("transaction",[301,"getTDSApplicability_customer"])); ?>',
                      type:'POST',
                      data:{'id':customid},
                      success:function(data){
                        if(data == 1){

                          $('#drpTDS').val('Yes');
                              $.ajaxSetup({
                                  headers: {
                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  }
                              });
                              $.ajax({
                                  url:'<?php echo e(route("transaction",[301,"getTDSDetails_customer"])); ?>',
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
							  $.ajax({
                                  url:'<?php echo e(route("transaction",[301,"getTDSDetailsCount_customer"])); ?>',
                                  type:'POST',
                                  data:{'id':customid},
                                  success:function(data) {
                                    $("#Row_Count4").val(data);
                                    
                                  },
                                  error:function(data){
                                    $("#Row_Count4").val(1);
                                    
                                  },
                              })
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

                  getTaxStatus_customer(customid);
        }

          }
          $("#Custpopup").hide();
          $("#Custcodesearch").val(''); 
          $("#Custnamesearch").val(''); 
         
          
          event.preventDefault();
      });
  }
  //Customer / Vendor Ends
//------------------------

//------------------------
  //Bank Dropdown Header
  let Banktid = "#BankCodeTable2";
    let Banktid2 = "#BankCodeTable";
    let Bankheaders = document.querySelectorAll(Banktid2 + " th");

      // Sort the table element when clicking on the table headers
      Bankheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(Banktid, ".clsbkid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function BankCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bankcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("BankCodeTable2");
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

      function BankNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("banknamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("BankCodeTable2");
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

      function BankBranchFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bankbranchsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("BankCodeTable2");
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

      function BankIFSCFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bankifscsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("BankCodeTable2");
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

      function BankAccTypeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bankacctypesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("BankCodeTable2");
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

      function BankAccNumberFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bankaccnumbersearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("BankCodeTable2");
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

      function BankAddressFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bankaddresssearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("BankCodeTable2");
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

  $('#txtcashbk').on('click',function(event){    
    
    showSelectedCheck($("#CASH_BANK_ID").val(),"bankcash");

    $("#bank_popup").show();    
    event.preventDefault();
  });

  $("#bank_closePopup").click(function(event){
    $("#bank_popup").hide();
    event.preventDefault();
  });

  $(".clsbkid").click(function(){
      var fieldid               =   $(this).attr('id');
      var txtval                =   $("#txt"+fieldid+"").val();
      var texdesc               =   $("#txt"+fieldid+"").data("desc")+'-'+$("#txt"+fieldid+"").data("desc2");
      var txtflag               =   $("#txt"+fieldid+"").data("desc3");
      var odlimit               =   $("#txt"+fieldid+"").data("odlimit");
      var glid_ref               =   $("#txt"+fieldid+"").data("glid_ref");
      var prftype               =   $("#txt"+fieldid+"").data("prftype");
 

      if(txtflag == 'C')
      {
        txtflag = 'Cash';
      }
      else if(txtflag == 'B')
      {
        txtflag = 'Bank';
      }
      else
      {
        txtflag = '';
      }
            
      $('#txtcashbk').val(texdesc);
      $('#CASH_BANK_ID').val(txtval);
      $('#PAYMENT_TYPE').val(txtflag);
      $('#ODLIMIT').val(odlimit);
      $('#PAYMENT_NO').val(prftype);
      
      getBalance(glid_ref,'BALANCE','BALANCE_SHOW'); 
      $("#bank_popup").hide();
      $("#bankcodesearch").val(''); 
      $("#banknamesearch").val('');
      $("#bankbranchsearch").val(''); 
      $("#bankifscsearch").val(''); 
      $("#bankacctypesearch").val(''); 
      $("#bankaccnumbersearch").val('');
      $("#bankaddresssearch").val('');
      BankCodeFunction();
      
      event.preventDefault();
  });
  
  //Bank Dropdown Header Ends
//------------------------

//------------------------
  //Bank Dropdown Header
  let Bank2tid = "#Bank2CodeTable2";
    let Bank2tid2 = "#Bank2CodeTable";
    let Bank2headers = document.querySelectorAll(Bank2tid2 + " th");

      // Sort the table element when clicking on the table headers
      Bank2headers.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(Bank2tid, ".clsbk2id", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function Bank2CodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bank2codesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("Bank2CodeTable2");
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

      function Bank2NameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bank2namesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("Bank2CodeTable2");
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

      function Bank2BranchFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bank2branchsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("Bank2CodeTable2");
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

      function Bank2IFSCFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bank2ifscsearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("Bank2CodeTable2");
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

      function Bank2AccTypeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bank2acctypesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("Bank2CodeTable2");
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

      function Bank2AccNumberFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bank2accnumbersearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("Bank2CodeTable2");
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

      function Bank2AddressFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("bank2addresssearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("Bank2CodeTable2");
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

  $('#Account').on('click','#txtbnkcsh',function(event){  
    showSelectedCheck($("#BANK_CASH_ID").val(),"cashbank2");
    $("#bank2_popup").show();    
    event.preventDefault();
  });

  $("#bank2_closePopup").click(function(event){
    $("#bank2_popup").hide();
    event.preventDefault();
  });

  $(".clsbk2id").click(function(){
      var fieldid               =   $(this).attr('id');
      var txtval                =   $("#txt"+fieldid+"").val();
      var texdesc               =   $("#txt"+fieldid+"").data("desc")+'-'+$("#txt"+fieldid+"").data("desc2"); 
      var odlimit               =   $("#txt"+fieldid+"").data("odlimit"); 
      var glid_ref               =   $("#txt"+fieldid+"").data("glid_ref");
            
      $('#txtbnkcsh').val(texdesc);
      $('#BANK_CASH_ID').val(txtval);
      $('#ODLIMIT_ACCOUNT').val(odlimit);
      getBalance(glid_ref,'BALANCE_ACCOUNT','BALANCE_ACCOUNT_SHOW'); 
      $("#bank2_popup").hide();
      $("#bank2codesearch").val(''); 
      $("#bank2namesearch").val('');
      $("#bank2branchsearch").val(''); 
      $("#bank2ifscsearch").val(''); 
      $("#bank2acctypesearch").val(''); 
      $("#bank2accnumbersearch").val('');
      $("#bank2addresssearch").val('');
      Bank2CodeFunction();      
      event.preventDefault();
  });
  
  //Bank Dropdown Header Ends
//------------------------


//------------------------
  //Account Popup
  let Accountid = "#AccountCodeTable2";
      let Accountid2 = "#AccountCodeTable";
      let Accountheaders = document.querySelectorAll(Accountid2 + " th");

      // Sort the table element when clicking on the table headers
      Accountheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(Accountid, ".clsAccount", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function AccountCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("Accountcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("AccountCodeTable2");
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

  function AccountNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("Accountnamesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("AccountCodeTable2");
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
  $('#Account').on('click','[id*="popupAccount_"]',function(event){
        if($('#BANK_CASH_ID').val() == '')
        {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text('Select Bank / Cash Option');
            $("#alert").modal('show');
            $("#OkBtn1").focus();
            highlighFocusBtn('activeOk1');
            return false;
        }
        else
        {
          var SL = $('#SubGL').is(':checked');          
          var fieldid = $(this).parent().parent().find('[id*="GLID_REF"]').attr('id');

          $("#tbody_glsl").html('');
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'<?php echo e(route("transaction",[301,"getglsl"])); ?>',
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

        var id=$(this).attr('id');
          var result = id.split('_');     
          var hidden_val=$("#GLID_REF_"+result[1]).val();
          showSelectedCheck(hidden_val,"glname");

            //$("#account_popup").show();
            var id = $(this).attr('id');
            var id2 = $(this).parent().parent().find('[id*="GLID_REF_"]').attr('id');
            var id3 = $(this).parent().parent().find('[id*="AccountName_"]').attr('id');
            var id22 = $(this).parent().parent().find('[id*="SLGL_TYPE_"]').attr('id');
            $('#hdn_Account').val(id);
            $('#hdn_Account2').val(id2);
            $('#hdn_Account3').val(id3);
            $('#hdn_Account22').val(id22);
            event.preventDefault();
        }
      });

      $("#account_closePopup").click(function(event){
        $("#account_popup").hide();
        event.preventDefault();
      });

      $("#gl_closePopup").click(function(event){
        $("#glsl_popup").hide();
        event.preventDefault();
      });

      
      function bindGeneralLedger() {
          $(".clsglid").click(function(){
          var fieldid = $(this).attr('id');
          var txtval =    $("#txt"+fieldid+"").val();
          var txtcode =   $("#txt"+fieldid+"").data("desc");
          var txtname =   $("#txt"+fieldid+"").data("desc2");
          var txtflag =   $("#txt"+fieldid+"").data("desc22");

          var txtid= $('#hdn_Account').val();
          var txt_id2= $('#hdn_Account2').val();
          var txt_id3= $('#hdn_Account3').val();
          var txt_id22= $('#hdn_Account22').val();

          $('#'+txtid).val(txtcode);
          $('#'+txt_id2).val(txtval);
          $('#'+txt_id3).val(txtname);
          $('#'+txt_id22).val(txtflag);

          var rowid="ACCOUNT_BALANCE_"+txt_id3.split('_').pop();   
          getBalanceGrid(txtval,rowid); 

   

          $("#glsl_popup").hide();
          $("#Accountcodesearch").val(''); 
          $("#Accountnameesearch").val(''); 
          AccountCodeFunction();        
          event.preventDefault();
      });
    }
  //Bill Address Ends
//------------------------

//------------------------
  //Cost Center Dropdown
    


  $('#Account').on('click','[id*="BtnCCID"]',function(event){
    $("#costpopup").show();
    var id = $(this).parent().parent().find('[id*="CCID_REF"]').attr('id');
    var glcode = $(this).parent().parent().find('[id*="popupAccount_"]').val();
    var glid = $(this).parent().parent().find('[id*="GLID_REF"]').val();
    var gldesc = $(this).parent().parent().find('[id*="AccountName_"]').val();
    var glamt = $(this).parent().parent().find('[id*="AMOUNT_"]').val();
        $('#hdn_CCID').val(id);
        $('#hdn_CCID2').val(glcode);
        $('#hdn_CCID3').val(glid);
        $('#hdn_CCID4').val(gldesc);
        $('#hdn_CCID5').val(glamt);

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
                var GL_AMT = $(this).find('[id*="GL_AMT_"]').val();
                var cccode = '';
                $.each( objcost, function( cckey, ccvalue ) {
                  if(ccvalue.CCID == ccid)
                  {
                    cccode = ccvalue.CCCODE;
                  }
                });

                var $tr = $('.participantRow9').closest('#CostTable2');
                var allTrs = $tr.find('.participantRow9').last();
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
                $clone.find('[id*="hdnGLName"]').val(gldesc);
                $clone.find('[id*="hdnAMT_"]').val(GL_AMT);
                $clone.find('[id*="hdnCCID_"]').val(ccid);
                $clone.find('[id*="CostCenter_"]').val(cccode);
                $tr.closest('#CostTable2').append($clone);                
            }
          });

          $('#CostTable2').find('.participantRow9').each(function()
          {
            if($(this).find('[id*="hdnGLID"]').val() == '')
            {
              $(this).closest("tr").remove();
            }
          });

        }
        else
        {
            $('#CostTable2').find('.participantRow9').each(function(){
                $(this).find('[id*="ppGLID"]').val(glcode);
                $(this).find('[id*="hdnGLID"]').val(glid);
                $(this).find('[id*="hdnGLName"]').val(gldesc);
            });
        }
        bindCostCenter();        
        event.preventDefault();
  });

  $("#costpopup").on('click',"#cc_closePopup",function(event){
        var gl_amt = $('#hdn_CCID5').val();
        var ccamt = 0.00;
        if(gl_amt != '')
        {
          $('#CostTable2').find('.participantRow9').each(function(){
              var ccamt2 = $(this).find('[id*="hdnAMT"]').val();
              ccamt = parseFloat(parseFloat(ccamt)+parseFloat(ccamt2)).toFixed(2);
          });
          if(ccamt != 'NaN' && ccamt != '0.00' && ccamt != 0 )
          {
            if (parseFloat(ccamt) != parseFloat(gl_amt))
            {
                  $('[id*="hdnAMT_"]').val('');
                  $("#FocusId").val($('[id*="hdnAMT_"]'));
                  $("#ProceedBtn").focus();
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn").hide();
                  $("#OkBtn1").show();
                  $("#AlertMessage").text('Cost Center Amount must be equal to Amount entered in Account tab.');
                  $("#alert").modal('show');
                  $("#OkBtn1").focus();
                  return false;
            }          
            else
            {
            }
          }
        }        

        $('#CostTable2').find('.participantRow9').each(function(){

            var GLID_REF = $(this).find('[id*="hdnGLID_"]').val();
            var CCID_REF = $(this).find('[id*="hdnCCID_"]').val();
            var GLAMT_REF = $(this).find('[id*="hdnAMT_"]').val();
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
                    $(this).find('[id*="GL_AMT"]').val(GLAMT_REF);
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
              if(GLAMT_REF != 'NaN' && GLAMT_REF != '')
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

                $clone.find('[id*="GLID_"]').val(GLID_REF);
                $clone.find('[id*="CCID_"]').val(CCID_REF);
                $clone.find('[id*="GL_AMT_"]').val(GLAMT_REF);
                $tr.closest('table').append($clone);   
                var rowCount3 = $('#Row_Count2').val();
                rowCount3 = parseInt(rowCount3)+1;
                $('#Row_Count2').val(rowCount3); 
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
        var ccpop = $('#hdnCostCenter').val();
        $("#costpopup").html(ccpop);
        event.preventDefault();      
      });

    function bindCostCenter(){
      $('#CostTable2').on('focusout','[id*="hdnAMT"]',function(event){        
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

  function ppcostNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("ppcostnamesearch");
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

  $('#costpopup').on('focus','[id*="CostCenter"]',function(event){
    var customid = $(this).parent().parent().find('[id*="hdnGLID"]').val();
      $("#tbody_ppcost").html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'<?php echo e(route("transaction",[$FormId,"getCostCenter"])); ?>',
            type:'POST',
            data:{'customid':customid},
            success:function(data) {
              $("#tbody_ppcost").html(data);    
              bindCostCenter2();                    
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
      ppcostCodeFunction();
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

  var totalvalue = 0.00;
      var totalvalue2 = 0.00;
      var tvalue = 0.00;
      var tvalue2 = 0.00;
      if($('#hdnpaymentfor').val() != 'Account')
      {
        $('#Invoice').find('.participantRow2').each(function()
        {
            if($(this).find('[id*="PAYMENT_AMT_"]').val() != '')
            {
              tvalue = $(this).find('[id*="PAYMENT_AMT_"]').val();
              if($(this).find('[id*="Doc_Type_"]').val() == 'PURCHASE_INVOICE' 
                  || $(this).find('[id*="Doc_Type_"]').val() == 'SERVICE_PURCHASE_INVOICE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'IMPORT_PURCHASE_INVOICE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'AP_CREDIT_NOTE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'AP_INVOICE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'SALES_INVOICE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'AR_DEBIT_NOTE'
				  || $(this).find('[id*="Doc_Type_"]').val() == 'MANUAL_JOURNAL_CREDIT'
                )
              {
                totalvalue = parseFloat(parseFloat(totalvalue) + parseFloat(tvalue)).toFixed(2);
              }
              else if($(this).find('[id*="Doc_Type_"]').val() == 'PURCHASE_RETURN' 
                  || $(this).find('[id*="Doc_Type_"]').val() == 'AP_DEBIT_NOTE'
				  || $(this).find('[id*="Doc_Type_"]').val() == 'SERVICE_PURCHASE_INVOICE_DEBIT'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'DEBIT_NOTE_STOCK'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'SALES_RETURN'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'AR_CREDIT_NOTE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'CREDIT_NOTE_STOCK'
				  || $(this).find('[id*="Doc_Type_"]').val() == 'MANUAL_JOURNAL_DEBIT'
                )
              {
                totalvalue = parseFloat(parseFloat(totalvalue) - parseFloat(tvalue)).toFixed(2);
              }
              else 
              {
              totalvalue = parseFloat(parseFloat(totalvalue) + parseFloat(tvalue)).toFixed(2);
              }
            }
        });
        if( $('#BANK_CHARGE').val() != '')    
        {
          totalvalue = parseFloat(parseFloat(totalvalue) + parseFloat($('#BANK_CHARGE').val())).toFixed(2);
        } 
        if( $('#AMOUNT').val() != '')    
        {
          totalvalue = parseFloat(parseFloat(totalvalue) + parseFloat($('#AMOUNT').val())).toFixed(2);
        }  
        $('#tot_amt1').val(totalvalue);
      }
      else
      {
        $('#Account').find('.participantRow3').each(function()
        {
          tvalue2 = $(this).find('[id*="TOTAMT_"]').val();    
          totalvalue2 = parseFloat(parseFloat(totalvalue2) + parseFloat(tvalue2)).toFixed(2);      
        });
        $('#tot_amt1').val(totalvalue2);
      }

var Invoice = $("#Invoice").html(); 
$('#hdnInvoice').val(Invoice);
var Account = $("#Account").html(); 
$('#hdnAccount').val(Account);
var CostCenter2 = $("#costpopup").html(); 
$('#hdnCostCenter').val(CostCenter2);
var CostCenter = $("#CostCenter").html();


var TDS = $("#TDS").html(); 
$('#hdntds').val(TDS);

$('#hdnCostCenter2').val(CostCenter);


var objPayHDR = <?php echo json_encode($objPAYHDR); ?>;
//var objlastdt = <?php echo json_encode(isset($objPAYHDR->PAYMENT_DT)?$objPAYHDR->PAYMENT_DT:''); ?>;
//var today = new Date(); 
//var ardate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
//$('#PAYMENT_DT').attr('min',objlastdt);
// $('#PAYMENT_DT').attr('max',ardate);

if(objPayHDR.PAYMENT_FOR == 'Vendor')
{
  $('#chk_Customer').prop('checked', false);
  $('#chk_Account').prop('checked', false);
  $('#chk_Employee').prop('checked', false);
  $('#hdnpaymentfor').val('Vendor');
  $('#titalName').html('Vendor*');

  $('#po_section').show();
  // $('#div_invoice').show();
  // $('#div_account').hide();
  // $('#div_invoice').addClass('active');
  // $('#div_tds').removeClass('active');
  // $('#Invoice').show();
  // $('#Account').hide();




  $('#divcust1').show();
  $('#divcust2').show();
  $('#divcust3').show();
  $('#divcust4').show();
  $('#txtbnkcsh').val('');
  $('#BANK_CASH_ID').val('');
  $('#div_invoice').show();
  $('#div_account').hide();
  $('#Invoice').addClass('active');
  $('.nav-tabs li:eq(0) a').tab('show');
}
else if(objPayHDR.PAYMENT_FOR == 'Customer')
{
  $('#chk_Vendor').prop('checked', false);
  $('#chk_Account').prop('checked', false);
  $('#chk_Employee').prop('checked', false);
  $('#hdnpaymentfor').val('Customer');
  $('#titalName').html('Customer*');

  // $('#div_invoice').show();
  // $('#div_account').hide();
  // $('#div_invoice').addClass('active');
  // $('#div_tds').removeClass('active');
  // //$('#Invoice').show();
  // $('#Account').hide();
  
  $('#po_section').hide();
    $('#txtPOpopup').val('');
    $('#POID_REF').val('');
    $('#PODT').val('');


  $('#divcust1').show();
  $('#divcust2').show();
  $('#divcust3').show();
  $('#divcust4').show();
  $('#txtbnkcsh').val('');
  $('#BANK_CASH_ID').val('');

  $('#div_invoice').show();
  $('#div_account').hide();
  $('#Invoice').addClass('active');
  $('.nav-tabs li:eq(0) a').tab('show');
}
else if(objPayHDR.PAYMENT_FOR == 'Employee')
{
  $('#chk_Vendor').prop('checked', false);
  $('#chk_Account').prop('checked', false);
  $('#chk_Customer').prop('checked', false);
  $('#hdnpaymentfor').val('Employee');
  $('#titalName').html('Employee*');

  // $('#div_invoice').show();
  // $('#div_account').hide();
  // $('#div_invoice').addClass('active');
  // $('#div_tds').removeClass('active');
  // //$('#Invoice').show();
  // $('#Account').hide();
  
  $('#po_section').hide();
    $('#txtPOpopup').val('');
    $('#POID_REF').val('');
    $('#PODT').val('');


  $('#divcust1').show();
  $('#divcust2').show();
  $('#divcust3').show();
  $('#divcust4').show();
  $('#txtbnkcsh').val('');
  $('#BANK_CASH_ID').val('');

  $('#div_invoice').show();
  $('#div_account').hide();
  $('#Invoice').addClass('active');
  $('.nav-tabs li:eq(0) a').tab('show');
}
else if(objPayHDR.PAYMENT_FOR == 'Account')
{

  $('#chk_Vendor').prop('checked', false);
  $('#chk_Customer').prop('checked', false);
  $('#chk_Employee').prop('checked', false);
  $('#hdnpaymentfor').val('Account');

  // $('#div_invoice').hide();
  // $('#div_account').show();
  
  // $('#div_account').addClass('active');
  // $('#Account').addClass('active');
  // $('#div_tds').removeClass('active');
  // $('#Invoice').removeClass('active');

  // $('#Invoice').hide();
  // $('#Account').show();
  
	$('#po_section').hide();
    $('#txtPOpopup').val('');
    $('#POID_REF').val('');
    $('#PODT').val('');

  $('#divcust1').hide();
  $('#divcust2').hide();
  $('#divcust3').hide();
  $('#divcust4').hide();
  $('#txtcashbk').val('');
  $('#CASH_BANK_ID').val('');
  $('#txtcustomer').val('');
  $('#CUSTMER_VENDOR_ID').val('');
  $('#AMOUNT').val('');
  $('#txtcashbk').val('');
  $('#CASH_BANK_ID').val('');
  $('#PAYMENT_TYPE').val('');
  /* $('#TRANSACTION_DT').val('');
  $('#INSTRUMENT_NO').val(''); */
  $('#BANK_CHARGE').val('');
  $('#NARRATION').val('');
  $('#div_invoice').hide();
  $('#div_account').show();
  $('#Account').addClass('active');
  $('.nav-tabs li:eq(1) a').tab('show');
}

if(objPayHDR.PAYMENT_ON_ACCOUNT == "1")
{
  
  $('#div_account_amt').show();
  $('#div_account_amt2').show();
  //$('#div_invoice').hide();  
  //$('#div_invoice').removeClass('active');
  //$('#Invoice').removeClass('active');
 // $('#Invoice').hide();
  $('#divcust4').hide();
  //$('#div_tds').addClass('active');
  //$('#TDS').show();

 // $('#div_invoice').hide();
    $('#div_invoice').hide();
    $('#div_account').hide();
    $('.nav-tabs li:eq(2) a').tab('show');
}
// else if(objPayHDR.PAYMENT_FOR != 'Account' && objPayHDR.PAYMENT_ON_ACCOUNT == "0")
// {
//   $('#div_account_amt').hide();
//   $('#div_account_amt2').hide();
//   $('#AMOUNT').val('');
//   $('#div_invoice').show();  
//   $('#div_invoice').addClass('active');
//   $('#Invoice').addClass('active');
//   $('#div_tds').removeClass('active');
//   $('#Invoice').show();
//   $('#divcust4').show();
// }



$('#chk_Vendor').on('change',function()
{
  if($(this).is(':checked') == true)
  {
    $('#chk_Customer').prop('checked', false);
    $('#chk_Employee').prop('checked', false);
    $('#chk_Account').prop('checked', false);
    $('#hdnpaymentfor').val('Vendor');
    $('#titalName').html('Vendor*');

	$('#po_section').show();

    // $('#div_invoice').show();
    // $('#div_account').hide();
    // $('#div_invoice').addClass('active');
    // $('#div_tds').removeClass('active');
    // $('#Invoice').addClass('active');

    // $('#TDS').removeClass('active');
    // $('#Invoice').show();
    // $('#Account').hide();

    $('#divcust1').show();
    $('#divcust2').show();
    $('#divcust3').show();
    $('#divcust4').show();
    $('#txtcustomer').val('');
    $('#CUSTMER_VENDOR_ID').val('');
    $('#AMOUNT').val('');
    $('#txtcashbk').val('');
    $('#CASH_BANK_ID').val('');
    $('#PAYMENT_TYPE').val('');
    $('#TRANSACTION_DT').val('');
    $('#INSTRUMENT_NO').val('');
    $('#BANK_CHARGE').val('');
    $('#NARRATION').val('');
    var InvoiceClone = $('#hdnInvoice').val(); 
    var AccountClone = $('#hdnAccount').val(); 
    var CostClone = $('#hdnCostCenter2').val();
    $('#Invoice').html(InvoiceClone);
    $('#Row_Count1').val('1');
    $('#example2').find('.participantRow2').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count1').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow2').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count1').val(rowcount);
      }
    });
    $('#example3').find('.participantRow3').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count3').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow3').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count3').val(rowcount);
      }
    });
    $('#Row_Count3').val('1');
    $('#example5').find('.participantRow5').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count2').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow5').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count2').val(rowcount);
      }
    });
    $('#Row_Count2').val('1');

    $('#example7').find('.participantRow7').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count6').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow7').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count6').val(rowcount);
      }
    });
    $('#Row_Count6').val('1');

    if($("#chk_PayAccount").is(':checked') == true){
      $('#div_invoice').hide();
      $('#div_account').hide();
      $('.nav-tabs li:eq(2) a').tab('show');
    }
    else{
      $('#div_invoice').show();
      $('#div_account').hide();
      $('#Invoice_Tab').click();
    }



    var ID=$("#txtcashbk").val(); 
    if(ID===''){
      $("#BALANCE_SHOW").text('');
    }

                    
             
              

  }
  else
  {
    $(this).prop('checked', false);
    $('#hdnpaymentfor').val('');
    $('#div_invoice').hide();
    $('#div_account').hide();
    $('#div_invoice').removeClass('active');
    $('#div_tds').addClass('active');
    $('#Invoice').hide();
    $('#Account').hide();
    $('#divcust1').hide();
    $('#divcust2').hide();
    $('#divcust3').hide();
    $('#divcust4').hide();
    $('#txtcustomer').val('');
    $('#CUSTMER_VENDOR_ID').val('');
    $('#AMOUNT').val('');
    $('#txtcashbk').val('');
    $('#CASH_BANK_ID').val('');
    $('#PAYMENT_TYPE').val('');
    $('#TRANSACTION_DT').val('');
    $('#INSTRUMENT_NO').val('');
    $('#BANK_CHARGE').val('');
    $('#NARRATION').val('');
    var InvoiceClone = $('#hdnInvoice').val(); 
    var AccountClone = $('#hdnAccount').val(); 
    var CostClone = $('#hdnCostCenter2').val();
    $('#Row_Count1').val('1');
    $('#example2').find('.participantRow2').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count1').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow2').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count1').val(rowcount);
      }
    });
    $('#example3').find('.participantRow3').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count3').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow3').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count3').val(rowcount);
      }
    });
    $('#Row_Count3').val('1');
    $('#example5').find('.participantRow5').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count2').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow5').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count2').val(rowcount);
      }
    });
    $('#Row_Count2').val('1');

    $('#example7').find('.participantRow7').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count6').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow7').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count6').val(rowcount);
      }
    });
    $('#Row_Count6').val('1');
  }
});

$('#chk_Customer').on('change',function()
{
  if($(this).is(':checked') == true)
  {
    $('#chk_Vendor').prop('checked', false);
    $('#chk_Employee').prop('checked', false);
    $('#chk_Account').prop('checked', false);
    $('#hdnpaymentfor').val('Customer');
    $('#titalName').html('Customer*');

    // $('#div_invoice').show();
    // $('#div_account').hide();
    // $('#div_invoice').addClass('active');
    // $('#div_tds').removeClass('active');
    // $('#Invoice').show();
    // $('#Account').hide();
    // $('#TDS').show();
	
	$('#po_section').hide();
    $('#txtPOpopup').val('');
    $('#POID_REF').val('');
    $('#PODT').val('');

    $('#divcust1').show();
    $('#divcust2').show();
    $('#divcust3').show();
    $('#divcust4').show();
    $('#txtcustomer').val('');
    $('#CUSTMER_VENDOR_ID').val('');
    $('#AMOUNT').val('');
    $('#txtcashbk').val('');
    $('#CASH_BANK_ID').val('');
    $('#PAYMENT_TYPE').val('');
    $('#TRANSACTION_DT').val('');
    $('#INSTRUMENT_NO').val('');
    $('#BANK_CHARGE').val('');
    $('#NARRATION').val('');
    var InvoiceClone = $('#hdnInvoice').val(); 
    var AccountClone = $('#hdnAccount').val(); 
    var CostClone = $('#hdnCostCenter2').val();
    $('#Row_Count1').val('1');
    $('#example2').find('.participantRow2').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count1').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow2').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count1').val(rowcount);
      }
    });
    $('#example3').find('.participantRow3').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count3').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow3').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count3').val(rowcount);
      }
    });
    $('#Row_Count3').val('1');
    $('#example5').find('.participantRow5').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count2').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow5').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count2').val(rowcount);
      }
    });
    $('#Row_Count2').val('1');

    $('#example7').find('.participantRow7').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count6').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow7').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count6').val(rowcount);
      }
    });
    $('#Row_Count6').val('1');

    if($("#chk_PayAccount").is(':checked') == true){
      $('#div_invoice').hide();
      $('#div_account').hide();
      $('.nav-tabs li:eq(2) a').tab('show');
    }
    else{
      $('#div_invoice').show();
      $('#div_account').hide();
      $('#Invoice_Tab').click();
    }


    var ID=$("#txtcashbk").val(); 
    if(ID===''){
      $("#BALANCE_SHOW").text('');
    }


  }
  else
  {
    $(this).prop('checked', false);
    $('#hdnpaymentfor').val('');
    $('#div_invoice').hide();
    $('#div_account').hide();
    $('#div_invoice').removeClass('active');
    $('#div_tds').removeClass('active');
    $('#Invoice').hide();
    $('#Account').hide();
    $('#divcust1').hide();
    $('#divcust2').hide();
    $('#divcust3').hide();
    $('#divcust4').hide();
    $('#txtcustomer').val('');
    $('#CUSTMER_VENDOR_ID').val('');
    $('#AMOUNT').val('');
    $('#txtcashbk').val('');
    $('#CASH_BANK_ID').val('');
    $('#CASH_BANK_ID').val('');
    $('#PAYMENT_TYPE').val('');
    $('#TRANSACTION_DT').val('');
    $('#INSTRUMENT_NO').val('');
    $('#BANK_CHARGE').val('');
    $('#NARRATION').val('');
    var InvoiceClone = $('#hdnInvoice').val(); 
    var AccountClone = $('#hdnAccount').val(); 
    var CostClone = $('#hdnCostCenter2').val();
    $('#Row_Count1').val('1');
    $('#example2').find('.participantRow2').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count1').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow2').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count1').val(rowcount);
      }
    });
    $('#example3').find('.participantRow3').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count3').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow3').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count3').val(rowcount);
      }
    });
    $('#Row_Count3').val('1');
    $('#example5').find('.participantRow5').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count2').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow5').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count2').val(rowcount);
      }
    });
    $('#Row_Count2').val('1');

    $('#example7').find('.participantRow7').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count6').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow7').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count6').val(rowcount);
      }
    });
    $('#Row_Count6').val('1');
  }
});



//Employee on click function//////


$('#chk_Employee').on('change',function()
{
  if($(this).is(':checked') == true)
  {
    $('#chk_Vendor').prop('checked', false);
    $('#chk_Customer').prop('checked', false);
    $('#chk_Account').prop('checked', false);
    $('#hdnpaymentfor').val('Employee');
    $('#titalName').html('Employee*');
	
	$('#po_section').hide();
    $('#txtPOpopup').val('');
    $('#POID_REF').val('');
    $('#PODT').val('');

    $('#divcust1').show();
    $('#divcust2').show();
    $('#divcust3').show();
    $('#divcust4').show();
    $('#txtcustomer').val('');
    $('#CUSTMER_VENDOR_ID').val('');
    $('#AMOUNT').val('');
    $('#txtcashbk').val('');
    $('#CASH_BANK_ID').val('');
    $('#PAYMENT_TYPE').val('');
    $('#TRANSACTION_DT').val('');
    $('#INSTRUMENT_NO').val('');
    $('#BANK_CHARGE').val('');
    $('#NARRATION').val('');
    var InvoiceClone = $('#hdnInvoice').val(); 
    var AccountClone = $('#hdnAccount').val(); 
    var CostClone = $('#hdnCostCenter2').val();
    $('#Row_Count1').val('1');
    $('#example2').find('.participantRow2').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count1').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow2').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count1').val(rowcount);
      }
    });
    $('#example3').find('.participantRow3').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count3').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow3').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count3').val(rowcount);
      }
    });
    $('#Row_Count3').val('1');
    $('#example5').find('.participantRow5').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count2').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow5').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count2').val(rowcount);
      }
    });
    $('#Row_Count2').val('1');

    $('#example7').find('.participantRow7').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count6').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow7').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count6').val(rowcount);
      }
    });
    $('#Row_Count6').val('1');

    if($("#chk_PayAccount").is(':checked') == true){
      $('#div_invoice').hide();
      $('#div_account').hide();
      $('.nav-tabs li:eq(2) a').tab('show');
    }
    else{
      $('#div_invoice').show();
      $('#div_account').hide();
      $('#Invoice_Tab').click();
    }


    var ID=$("#txtcashbk").val(); 
    if(ID===''){
      $("#BALANCE_SHOW").text('');
    }


  }
  else
  {
    $(this).prop('checked', false);
    $('#hdnpaymentfor').val('');
    $('#div_invoice').hide();
    $('#div_account').hide();
    $('#div_invoice').removeClass('active');
    $('#div_tds').removeClass('active');
    $('#Invoice').hide();
    $('#Account').hide();
    $('#divcust1').hide();
    $('#divcust2').hide();
    $('#divcust3').hide();
    $('#divcust4').hide();
    $('#txtcustomer').val('');
    $('#CUSTMER_VENDOR_ID').val('');
    $('#AMOUNT').val('');
    $('#txtcashbk').val('');
    $('#CASH_BANK_ID').val('');
    $('#CASH_BANK_ID').val('');
    $('#PAYMENT_TYPE').val('');
    $('#TRANSACTION_DT').val('');
    $('#INSTRUMENT_NO').val('');
    $('#BANK_CHARGE').val('');
    $('#NARRATION').val('');
    var InvoiceClone = $('#hdnInvoice').val(); 
    var AccountClone = $('#hdnAccount').val(); 
    var CostClone = $('#hdnCostCenter2').val();
    $('#Row_Count1').val('1');
    $('#example2').find('.participantRow2').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count1').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow2').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count1').val(rowcount);
      }
    });
    $('#example3').find('.participantRow3').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count3').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow3').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count3').val(rowcount);
      }
    });
    $('#Row_Count3').val('1');
    $('#example5').find('.participantRow5').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count2').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow5').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count2').val(rowcount);
      }
    });
    $('#Row_Count2').val('1');

    $('#example7').find('.participantRow7').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count6').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow7').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count6').val(rowcount);
      }
    });
    $('#Row_Count6').val('1');
  }
});





$('#chk_Account').on('change',function()
{
  if($(this).is(':checked') == true)
  {
    $('#chk_Vendor').prop('checked', false);
    $('#chk_Customer').prop('checked', false);
	$('#chk_Employee').prop('checked', false);
    $('#hdnpaymentfor').val('Account');

    $('#chk_PayAccount').prop('checked', false);
    $('#div_account_amt').hide();
    $('#div_account_amt2').hide();
    $('#AMOUNT').val('');
	
	$('#po_section').hide();
    $('#txtPOpopup').val('');
    $('#POID_REF').val('');
    $('#PODT').val('');

    // $('#div_invoice').hide();
    // $('#div_account').show();
    // $('#div_account').addClass('active');
    // $('#Account').addClass('active');
    // $('#Invoice').removeClass('active');
    // $('#div_tds').removeClass('active');
    // $('#Invoice').hide();
    // $('#Account').show();

    $('#divcust1').hide();
    $('#divcust2').hide();
    $('#divcust3').hide();
    $('#divcust4').hide();
    $('#txtcustomer').val('');
    $('#CUSTMER_VENDOR_ID').val('');
    $('#AMOUNT').val('');
    $('#txtcashbk').val('');
    $('#CASH_BANK_ID').val('');
    $('#PAYMENT_TYPE').val('');
    $('#TRANSACTION_DT').val('');
    $('#INSTRUMENT_NO').val('');
    $('#BANK_CHARGE').val('');
    $('#NARRATION').val('');
    var InvoiceClone = $('#hdnInvoice').val(); 
    var AccountClone = $('#hdnAccount').val(); 
    var CostClone = $('#hdnCostCenter2').val();
    $('#Row_Count1').val('1');
    $('#example2').find('.participantRow2').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count1').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow2').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count1').val(rowcount);
      }
    });
    $('#example3').find('.participantRow3').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count3').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow3').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count3').val(rowcount);
      }
    });
    $('#Row_Count3').val('1');
    $('#example5').find('.participantRow5').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count2').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow5').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count2').val(rowcount);
      }
    });
    $('#Row_Count2').val('1');


    $('#example7').find('.participantRow7').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count6').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow7').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count6').val(rowcount);
      }
    });
    $('#Row_Count6').val('1');

    $('#div_invoice').hide();
    $('#div_account').show();
    $('.nav-tabs li:eq(1) a').tab('show');

    var ID=$("#txtbnkcsh").val(); 
    if(ID===''){
      $("#BALANCE_ACCOUNT_SHOW").text('');
    }


    
  }
  else
  {
    $(this).prop('checked', false);
    $('#hdnpaymentfor').val('');
    $('#div_invoice').hide();
    $('#div_account').hide();
    $('#div_account').removeClass('active');
    $('#Account').removeClass('active');
    $('#Invoice').removeClass('active');
    $('#div_tds').removeClass('active');
    $('#Invoice').hide();
    $('#Account').hide();
    $('#divcust1').hide();
    $('#divcust2').hide();
    $('#divcust3').hide();
    $('#divcust4').hide();
    $('#txtcustomer').val('');
    $('#CUSTMER_VENDOR_ID').val('');
    $('#AMOUNT').val('');
    $('#txtcashbk').val('');
    $('#CASH_BANK_ID').val('');
    $('#PAYMENT_TYPE').val('');
    $('#TRANSACTION_DT').val('');
    $('#INSTRUMENT_NO').val('');
    $('#BANK_CHARGE').val('');
    $('#NARRATION').val('');
    var InvoiceClone = $('#hdnInvoice').val(); 
    var AccountClone = $('#hdnAccount').val(); 
    var CostClone = $('#hdnCostCenter2').val();
    $('#Row_Count1').val('1');
    $('#example2').find('.participantRow2').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count1').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow2').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count1').val(rowcount);
      }
    });
    $('#example3').find('.participantRow3').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count3').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow3').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count3').val(rowcount);
      }
    });
    $('#Row_Count3').val('1');
    $('#example5').find('.participantRow5').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count2').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow5').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count2').val(rowcount);
      }
    });
    $('#Row_Count2').val('1');

    $('#example7').find('.participantRow7').each(function(){
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      var rowcount = $('#Row_Count6').val();
      if(rowcount > 1)
      {
        $(this).closest('.participantRow7').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count6').val(rowcount);
      }
    });
    $('#Row_Count6').val('1');
  }
});

$('#btnAdd').on('click', function() {
  var viewURL = '<?php echo e(route("transaction",[$FormId,"add"])); ?>';
              window.location.href=viewURL;
});

$('#btnExit').on('click', function() {
  var viewURL = '<?php echo e(route('home')); ?>';
              window.location.href=viewURL;
});

$('#chk_PayAccount').on('change',function()
{
  if($(this).is(':checked') == true)
  {
    $('#div_account_amt').show();
    $('#div_account_amt2').show();
    $('#AMOUNT').val('');
    $('#txtcashbk').val('');
    $('#CASH_BANK_ID').val('');
    $('#PAYMENT_TYPE').val('');
    $('#TRANSACTION_DT').val('');
    $('#INSTRUMENT_NO').val('');
    $('#BANK_CHARGE').val('');
    $('#NARRATION').val('');

    // $('#div_invoice').hide();
    // $('#div_account').hide();
    // $('#div_account').removeClass('active');
    // $('#Account').removeClass('active');
    // $('#Invoice').removeClass('active');
    // $('#Invoice').hide();
    // $('#Account').hide(); 

    $('#divcust4').hide();
    var InvoiceClone = $('#hdnInvoice').val(); 
    var AccountClone = $('#hdnAccount').val(); 
    var CostClone = $('#hdnCostCenter2').val();
    var tds = $('#hdntds').val();
    $('#Invoice').html(InvoiceClone);
    $('#Row_Count1').val('1');
    $('#Account').html(AccountClone);
    $('#Row_Count3').val('1');
    $('#CostCenter').html(CostClone);
    $('#TDS').html(tds);
    $('#Row_Count2').val('1');
    $('#Row_Count6').val('1');
    $('#div_invoice').hide();
    $('#div_account').hide();
    $('.nav-tabs li:eq(2) a').tab('show');
    bindTotalValue();
    event.preventDefault();

    
  }
  else{
    $('#div_account_amt').hide();
    $('#div_account_amt2').hide();
    $('#AMOUNT').val('');
    $('#div_invoice').show();
    $('#div_account').hide();
    $('#Invoice_Tab').click();
    

    $('#CostCenter').find('.participantRow5').each(function(){
      var rowcount = $(this).closest('table').find('.participantRow5').length;
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      $(this).find('input:checked').prop('checked', false);
      if(rowcount > 1)
      {
        $(this).closest('.participantRow5').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count2').val(rowcount);
      }
    });

    $('#Account').find('.participantRow3').each(function(){
    var rowcount = $(this).closest('table').find('.participantRow3').length;
    $(this).find('input:text').val('');
    $(this).find('input:hidden').val('');
    $(this).find('input:checked').prop('checked', false);
    if(rowcount > 1)
    {
      $(this).closest('.participantRow3').remove();
      rowcount = parseInt(rowcount) - 1;
      $('#Row_Count3').val(rowcount);
    }
  });

  $('#Invoice').find('.participantRow2').each(function(){
    var rowcount = $(this).closest('table').find('.participantRow2').length;
    $(this).find('input:text').val('');
    $(this).find('input:hidden').val('');
    $(this).find('input:checked').prop('checked', false);
    if(rowcount > 1)
    {
      $(this).closest('.participantRow2').remove();
      rowcount = parseInt(rowcount) - 1;
      $('#Row_Count1').val(rowcount);
    }
  });
    
  $('#TDS').find('.participantRow7').each(function(){
    var rowcount = $(this).closest('table').find('.participantRow7').length;
    $(this).find('input:text').val('');
    $(this).find('input:hidden').val('');
    $(this).find('input:checked').prop('checked', false);
    
    if(rowcount > 1){
      $(this).closest('.participantRow7').remove();
      rowcount = parseInt(rowcount) - 1;
      $('#Row_Count6').val(rowcount);
    }
  });

  $("#drpTDS").val('');
  bindTotalValue();
  event.preventDefault();
  }
});

$('#BANK_CHARGE').on('focusout',function(){
  if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0')
  {
    if(intRegex.test($(this).val())){
      $(this).val($(this).val()+'.00');
    }
  }
    bindTotalValue();
    event.preventDefault();
});

$('#AMOUNT').on('focusout',function(){
  if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0')
  {
    if(intRegex.test($(this).val())){
      $(this).val($(this).val()+'.00');
    }
  }
    bindTotalValue();
    event.preventDefault();
});


$('#ROUNDOFF_AMT').on('focusout',function(){

if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0')
{
  if(intRegex.test($(this).val())){
    $(this).val($(this).val()+'.00');
  }
}
  bindTotalValue();
  event.preventDefault();
});

$('#ROUNDOFF_MODE').on('change',function(){  
  bindTotalValue();
  event.preventDefault();
});


$("#Invoice").on('focusout', "[id*='PAYMENT_AMT_']", function() 
{
  if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0.00')
  {
    if(intRegex.test($(this).val())){
      $(this).val($(this).val()+'.00');
    }
    var balanceamt = $(this).parent().parent().find('[id*="BALANCE_DUE_"]').val();
    if(parseFloat($(this).val()) > parseFloat(balanceamt))
    {
      $(this).val('');
      $("#ProceedBtn").focus();
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").show();
      $("#AlertMessage").text('Please Payment Amount cannot be greater than Balance Amt.');
      $("#alert").modal('show');
      $("#OkBtn1").focus();
      return false;
    }
  }

    bindTotalValue();
    event.preventDefault();
});


$("#Account").on('focusout', "[id*='ASSESSABLE_VALUE_']", function() 
{
  if($(this).parent().parent().find('[id*="AMOUNT_"]').val() == '')
  {
    $(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val('');
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Amount cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else
  {
    if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0')
    { 

      var amt       = $(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val();
      var totamt    = $(this).parent().parent().find('[id*="AMOUNT_"]').val();

      
      if($(this).parent().parent().find('[id*="calIGST_"]').val() != '')
      {
        var igst      = $(this).parent().parent().find('[id*="calIGST_"]').val();
        var igstamt   = parseFloat((parseFloat(amt)*parseFloat(igst))/100).toFixed(2);
      }
      else
      {
        var igst      = 0;
        var igstamt   = 0;
      }
      if($(this).parent().parent().find('[id*="calCGST_"]').val() != '')
      {
        var cgst      = $(this).parent().parent().find('[id*="calCGST_"]').val();
        var cgstamt   = parseFloat((parseFloat(amt)*parseFloat(cgst))/100).toFixed(2);
      }
      else
      {
        var cgst      = 0;
        var cgstamt   = 0;
      }
      if($(this).parent().parent().find('[id*="calSGST_"]').val() != '')
      {
        var sgst      = $(this).parent().parent().find('[id*="calSGST_"]').val();
        var sgstamt   = parseFloat((parseFloat(amt)*parseFloat(sgst))/100).toFixed(2);
      }
      else
      {
        var sgst      = 0;
        var sgstamt   = 0;
      }
      
      var taxamt = parseFloat(parseFloat(igstamt) + parseFloat(cgstamt) + parseFloat(sgstamt)).toFixed(2); 
      var totamt = parseFloat(parseFloat(totamt) + parseFloat(taxamt)).toFixed(2);
      
    if(intRegex.test($(this).val())){
      $(this).val($(this).val()+'.00');
    }
    if(intRegex.test(totamt)){
      totamt = totamt +'.00';
    }
    if(intRegex.test(igstamt)){
      igstamt = igstamt +'.00';
    }
    if(intRegex.test(cgstamt)){
      cgstamt = cgstamt +'.00';
    }
    if(intRegex.test(sgstamt)){
      sgstamt = sgstamt +'.00';
    }
    if(intRegex.test(igst)){
      igst = igst +'.0000';
    }
    if(intRegex.test(cgst)){
      cgst = cgst +'.0000';
    }
    if(intRegex.test(sgst)){
      sgst = sgst +'.0000';
    }
    $(this).parent().parent().find('[id*="TOTAMT_"]').val(totamt);
    $(this).parent().parent().find('[id*="AMTIGST_"]').val(igstamt);
    $(this).parent().parent().find('[id*="AMTCGST_"]').val(cgstamt);
    $(this).parent().parent().find('[id*="AMTSGST_"]').val(sgstamt);
    $(this).parent().parent().find('[id*="calIGST_"]').val(igst);
    $(this).parent().parent().find('[id*="calCGST_"]').val(cgst);
    $(this).parent().parent().find('[id*="calSGST_"]').val(sgst);
    bindTotalValue();
    // if($('#CTID_REF').val()!='')
    // {
    // bindGSTCalTemplate();
    // }
    // bindTotalValue();
    event.preventDefault();    
    }
  }
});

$("#Account").on('focusout', "[id*='AMOUNT_']", function() 
{
  if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0')
  { 

      if($(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val() !=''){
        var amt = $(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val();
      }
      else{
        $(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val($(this).val());
        var amt = $(this).val();
      }

      var totamt    = $(this).val();

      
      if($(this).parent().parent().find('[id*="calIGST_"]').val() != '')
      {
        var igst      = $(this).parent().parent().find('[id*="calIGST_"]').val();
        var igstamt   = parseFloat((parseFloat(amt)*parseFloat(igst))/100).toFixed(2);
      }
      else
      {
        var igst      = 0;
        var igstamt   = 0;
      }
      if($(this).parent().parent().find('[id*="calCGST_"]').val() != '')
      {
        var cgst      = $(this).parent().parent().find('[id*="calCGST_"]').val();
        var cgstamt   = parseFloat((parseFloat(amt)*parseFloat(cgst))/100).toFixed(2);
      }
      else
      {
        var cgst      = 0;
        var cgstamt   = 0;
      }
      if($(this).parent().parent().find('[id*="calSGST_"]').val() != '')
      {
        var sgst      = $(this).parent().parent().find('[id*="calSGST_"]').val();
        var sgstamt   = parseFloat((parseFloat(amt)*parseFloat(sgst))/100).toFixed(2);
      }
      else
      {
        var sgst      = 0;
        var sgstamt   = 0;
      }
      
      var taxamt = parseFloat(parseFloat(igstamt) + parseFloat(cgstamt) + parseFloat(sgstamt)).toFixed(2); 
      var totamt = parseFloat(parseFloat(totamt) + parseFloat(taxamt)).toFixed(2);
      
    if(intRegex.test($(this).val())){
      $(this).val($(this).val()+'.00');
    }
    if(intRegex.test(totamt)){
      totamt = totamt +'.00';
    }
    if(intRegex.test(igstamt)){
      igstamt = igstamt +'.00';
    }
    if(intRegex.test(cgstamt)){
      cgstamt = cgstamt +'.00';
    }
    if(intRegex.test(sgstamt)){
      sgstamt = sgstamt +'.00';
    }
    if(intRegex.test(igst)){
      igst = igst +'.0000';
    }
    if(intRegex.test(cgst)){
      cgst = cgst +'.0000';
    }
    if(intRegex.test(sgst)){
      sgst = sgst +'.0000';
    }
    $(this).parent().parent().find('[id*="TOTAMT_"]').val(totamt);
    $(this).parent().parent().find('[id*="AMTIGST_"]').val(igstamt);
    $(this).parent().parent().find('[id*="AMTCGST_"]').val(cgstamt);
    $(this).parent().parent().find('[id*="AMTSGST_"]').val(sgstamt);
    $(this).parent().parent().find('[id*="calIGST_"]').val(igst);
    $(this).parent().parent().find('[id*="calCGST_"]').val(cgst);
    $(this).parent().parent().find('[id*="calSGST_"]').val(sgst);
    bindTotalValue();
    // if($('#CTID_REF').val()!='')
    // {
    // bindGSTCalTemplate();
    // }
    // bindTotalValue();
    event.preventDefault();    
  }  
});

$("#Account").on('focusout', "[id*='calIGST_']", function() 
{
  if($(this).parent().parent().find('[id*="AMOUNT_"]').val() == '')
  {
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Amount cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else if($(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val() == ''){
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Assessable Value cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else
  {
    if($(this).val() != '' && $(this).val() != '.0000' && $(this).val() > '0.0000')
    { 
        var amt       = $(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val();
        var totamt    = $(this).parent().parent().find('[id*="AMOUNT_"]').val();
        var igst      = $(this).parent().parent().find('[id*="calIGST_"]').val();
        var igstamt   = parseFloat((parseFloat(amt)*parseFloat(igst))/100).toFixed(2);
        
        
          var cgst      = 0;
          var cgstamt   = 0;
        
          var sgst      = 0;
          var sgstamt   = 0;
        
        
        var taxamt = parseFloat(parseFloat(igstamt) + parseFloat(cgstamt) + parseFloat(sgstamt)).toFixed(2); 
        var totamt = parseFloat(parseFloat(totamt) + parseFloat(taxamt)).toFixed(2);
        
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.0000');
      }
      if(intRegex.test(totamt)){
        totamt = totamt +'.00';
      }
      if(intRegex.test(igstamt)){
        igstamt = igstamt +'.00';
      }
      if(intRegex.test(cgstamt)){
        cgstamt = cgstamt +'.00';
      }
      if(intRegex.test(sgstamt)){
        sgstamt = sgstamt +'.00';
      }
      if(intRegex.test(igst)){
        igst = igst +'.0000';
      }
      if(intRegex.test(cgst)){
        cgst = cgst +'.0000';
      }
      if(intRegex.test(sgst)){
        sgst = sgst +'.0000';
      }
      $(this).parent().parent().find('[id*="TOTAMT_"]').val(totamt);
      $(this).parent().parent().find('[id*="AMTIGST_"]').val(igstamt);
      $(this).parent().parent().find('[id*="AMTCGST_"]').val(cgstamt);
      $(this).parent().parent().find('[id*="AMTSGST_"]').val(sgstamt);
      $(this).parent().parent().find('[id*="calCGST_"]').val(cgst);
      $(this).parent().parent().find('[id*="calSGST_"]').val(sgst);
      $(this).parent().parent().find('[id*="AMTCGST_"]').prop('disabled','true');
      $(this).parent().parent().find('[id*="AMTSGST_"]').prop('disabled','true');
      $(this).parent().parent().find('[id*="calCGST_"]').prop('disabled','true');
      $(this).parent().parent().find('[id*="calSGST_"]').prop('disabled','true');
      bindTotalValue();
      event.preventDefault();
    }
    else
    {
      $(this).val('0.0000');
      $(this).parent().parent().find('[id*="AMTIGST_"]').val('0.00');
      $(this).parent().parent().find('[id*="AMTCGST_"]').removeAttr('disabled');
      $(this).parent().parent().find('[id*="AMTSGST_"]').removeAttr('disabled');
      $(this).parent().parent().find('[id*="calCGST_"]').removeAttr('disabled');
      $(this).parent().parent().find('[id*="calSGST_"]').removeAttr('disabled');
      bindTotalValue();
      event.preventDefault();
    }
  }
});

$("#Account").on('focusout', "[id*='calCGST_']", function() 
{
  if($(this).parent().parent().find('[id*="AMOUNT_"]').val() == '')
  {
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Amount cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else if($(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val() == ''){
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Assessable Value cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else
  {
    if($(this).val() != '' && $(this).val() != '.0000' && $(this).val() > '0.0000')
    { 
        var amt       = $(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val();
        var totamt    = $(this).parent().parent().find('[id*="AMOUNT_"]').val();
        var cgst      = $(this).parent().parent().find('[id*="calCGST_"]').val();
        var cgstamt   = parseFloat((parseFloat(amt)*parseFloat(cgst))/100).toFixed(2);        
        
        var igst      = 0;
        var igstamt   = 0;
        
        if($(this).parent().parent().find('[id*="calSGST_"]').val() != '')
        {
          var sgst      = $(this).parent().parent().find('[id*="calSGST_"]').val();
          var sgstamt   = parseFloat((parseFloat(amt)*parseFloat(sgst))/100).toFixed(2);
        }
        else
        {
          var sgst      = 0;
          var sgstamt   = 0;
        }
        
        var taxamt = parseFloat(parseFloat(igstamt) + parseFloat(cgstamt) + parseFloat(sgstamt)).toFixed(2); 
        var totamt = parseFloat(parseFloat(totamt) + parseFloat(taxamt)).toFixed(2);
        
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.0000');
      }
      if(intRegex.test(totamt)){
        totamt = totamt +'.00';
      }
      if(intRegex.test(igstamt)){
        igstamt = igstamt +'.00';
      }
      if(intRegex.test(cgstamt)){
        cgstamt = cgstamt +'.00';
      }
      if(intRegex.test(sgstamt)){
        sgstamt = sgstamt +'.00';
      }
      if(intRegex.test(igst)){
        igst = igst +'.0000';
      }
      if(intRegex.test(cgst)){
        cgst = cgst +'.0000';
      }
      if(intRegex.test(sgst)){
        sgst = sgst +'.0000';
      }
      $(this).parent().parent().find('[id*="TOTAMT_"]').val(totamt);
      $(this).parent().parent().find('[id*="AMTIGST_"]').val(igstamt);
      $(this).parent().parent().find('[id*="AMTCGST_"]').val(cgstamt);
      $(this).parent().parent().find('[id*="AMTSGST_"]').val(sgstamt);
      $(this).parent().parent().find('[id*="calCGST_"]').val(cgst);
      $(this).parent().parent().find('[id*="calSGST_"]').val(sgst);
      $(this).parent().parent().find('[id*="AMTIGST_"]').prop('disabled','true');
      $(this).parent().parent().find('[id*="calIGST_"]').prop('disabled','true');
      bindTotalValue();
      event.preventDefault();
    }
    else
    {
      $(this).val('0.0000');
      $(this).parent().parent().find('[id*="AMTCGST_"]').val('0.00');
      $(this).parent().parent().find('[id*="AMTIGST_"]').removeAttr('disabled');
      $(this).parent().parent().find('[id*="calIGST_"]').removeAttr('disabled');
      bindTotalValue();
      event.preventDefault();
    }
  }
});

$("#Account").on('focusout', "[id*='calSGST_']", function() 
{
  if($(this).parent().parent().find('[id*="AMOUNT_"]').val() == '')
  {
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Amount cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else if($(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val() == ''){
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Assessable Value cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else
  {
    if($(this).val() != '' && $(this).val() != '.0000' && $(this).val() > '0.0000')
    { 
        var amt       = $(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val();
        var totamt    = $(this).parent().parent().find('[id*="AMOUNT_"]').val();
        var sgst      = $(this).parent().parent().find('[id*="calSGST_"]').val();
        var sgstamt   = parseFloat((parseFloat(amt)*parseFloat(sgst))/100).toFixed(2);
        
        if($(this).parent().parent().find('[id*="calIGST_"]').val() != '')
        {
          var igst      = $(this).parent().parent().find('[id*="calIGST_"]').val();
          var igstamt   = parseFloat((parseFloat(amt)*parseFloat(igst))/100).toFixed(2);
        }
        else
        {
          var igst      = 0;
          var igstamt   = 0;
        }
        if($(this).parent().parent().find('[id*="calCGST_"]').val() != '')
        {
          var cgst      = $(this).parent().parent().find('[id*="calCGST_"]').val();
          var cgstamt   = parseFloat((parseFloat(amt)*parseFloat(cgst))/100).toFixed(2);
        }
        else
        {
          var cgst      = 0;
          var cgstamt   = 0;
        }
        
        var taxamt = parseFloat(parseFloat(igstamt) + parseFloat(cgstamt) + parseFloat(sgstamt)).toFixed(2); 
        var totamt = parseFloat(parseFloat(totamt) + parseFloat(taxamt)).toFixed(2);
        
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.0000');
      }
      if(intRegex.test(totamt)){
        totamt = totamt +'.00';
      }
      if(intRegex.test(igstamt)){
        igstamt = igstamt +'.00';
      }
      if(intRegex.test(cgstamt)){
        cgstamt = cgstamt +'.00';
      }
      if(intRegex.test(sgstamt)){
        sgstamt = sgstamt +'.00';
      }
      if(intRegex.test(igst)){
        igst = igst +'.0000';
      }
      if(intRegex.test(cgst)){
        cgst = cgst +'.0000';
      }
      if(intRegex.test(sgst)){
        sgst = sgst +'.0000';
      }
      $(this).parent().parent().find('[id*="TOTAMT_"]').val(totamt);
      $(this).parent().parent().find('[id*="AMTIGST_"]').val(igstamt);
      $(this).parent().parent().find('[id*="AMTCGST_"]').val(cgstamt);
      $(this).parent().parent().find('[id*="AMTSGST_"]').val(sgstamt);
      $(this).parent().parent().find('[id*="calCGST_"]').val(cgst);
      $(this).parent().parent().find('[id*="calIGST_"]').val(igst);
      $(this).parent().parent().find('[id*="AMTIGST_"]').prop('disabled','true');
      $(this).parent().parent().find('[id*="calIGST_"]').prop('disabled','true');
      bindTotalValue();
      event.preventDefault();
    }
    else
    {
      $(this).val('0.0000');
      $(this).parent().parent().find('[id*="AMTSGST_"]').val('0.00');
      $(this).parent().parent().find('[id*="AMTIGST_"]').removeAttr('disabled');
      $(this).parent().parent().find('[id*="calIGST_"]').removeAttr('disabled');
      bindTotalValue();
      event.preventDefault();
    }
  }
});

$("#Account").on('focusout', "[id*='AMTIGST_']", function() 
{
  if($(this).parent().parent().find('[id*="AMOUNT_"]').val() == '')
  {
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Amount cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else if($(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val() == ''){
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Assessable Value cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else
  {
    if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0.00')
    { 
        var amt       = $(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val();
        var totamt    = $(this).parent().parent().find('[id*="AMOUNT_"]').val();
        var igstamt   = $(this).parent().parent().find('[id*="AMTIGST_"]').val();
        var igst      = parseFloat((parseFloat(igstamt)*100)/parseFloat(amt)).toFixed(4);
        
        if($(this).parent().parent().find('[id*="calCGST_"]').val() != '')
        {
          var cgst      = $(this).parent().parent().find('[id*="calCGST_"]').val();
          var cgstamt   = parseFloat((parseFloat(amt)*parseFloat(cgst))/100).toFixed(2);
        }
        else
        {
          var cgst      = 0;
          var cgstamt   = 0;
        }
        if($(this).parent().parent().find('[id*="calSGST_"]').val() != '')
        {
          var sgst      = $(this).parent().parent().find('[id*="calSGST_"]').val();
          var sgstamt   = parseFloat((parseFloat(amt)*parseFloat(sgst))/100).toFixed(2);
        }
        else
        {
          var sgst      = 0;
          var sgstamt   = 0;
        }
        
        var taxamt = parseFloat(parseFloat(igstamt) + parseFloat(cgstamt) + parseFloat(sgstamt)).toFixed(2); 
        var totamt = parseFloat(parseFloat(totamt) + parseFloat(taxamt)).toFixed(2);
        
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00');
      }
      if(intRegex.test(totamt)){
        totamt = totamt +'.00';
      }
      if(intRegex.test(igstamt)){
        igstamt = igstamt +'.00';
      }
      if(intRegex.test(cgstamt)){
        cgstamt = cgstamt +'.00';
      }
      if(intRegex.test(sgstamt)){
        sgstamt = sgstamt +'.00';
      }
      if(intRegex.test(igst)){
        igst = igst +'.0000';
      }
      if(intRegex.test(cgst)){
        cgst = cgst +'.0000';
      }
      if(intRegex.test(sgst)){
        sgst = sgst +'.0000';
      }
      $(this).parent().parent().find('[id*="TOTAMT_"]').val(totamt);
      $(this).parent().parent().find('[id*="AMTCGST_"]').val(cgstamt);
      $(this).parent().parent().find('[id*="AMTSGST_"]').val(sgstamt);
      $(this).parent().parent().find('[id*="calIGST_"]').val(igst);
      $(this).parent().parent().find('[id*="calCGST_"]').val(cgst);
      $(this).parent().parent().find('[id*="calSGST_"]').val(sgst);
      $(this).parent().parent().find('[id*="AMTCGST_"]').prop('disabled','true');
      $(this).parent().parent().find('[id*="AMTSGST_"]').prop('disabled','true');
      $(this).parent().parent().find('[id*="calCGST_"]').prop('disabled','true');
      $(this).parent().parent().find('[id*="calSGST_"]').prop('disabled','true');
      bindTotalValue();
      event.preventDefault();
    }
    else
    {
      $(this).val('0.00');
      $(this).parent().parent().find('[id*="calIGST_"]').val('0.0000');
      $(this).parent().parent().find('[id*="AMTCGST_"]').removeAttr('disabled');
      $(this).parent().parent().find('[id*="AMTSGST_"]').removeAttr('disabled');
      $(this).parent().parent().find('[id*="calCGST_"]').removeAttr('disabled');
      $(this).parent().parent().find('[id*="calSGST_"]').removeAttr('disabled');
      bindTotalValue();
      event.preventDefault();
    }
  }
});

$("#Account").on('focusout', "[id*='AMTCGST_']", function() 
{
  if($(this).parent().parent().find('[id*="AMOUNT_"]').val() == '')
  {
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Amount cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else if($(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val() == ''){
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Assessable Value cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else
  {
    if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0.00')
    { 
        var amt       = $(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val();
        var totamt    = $(this).parent().parent().find('[id*="AMOUNT_"]').val();
        var cgstamt   = $(this).parent().parent().find('[id*="AMTCGST_"]').val();
        var cgst      = parseFloat((parseFloat(cgstamt)*100)/parseFloat(amt)).toFixed(4);       
        
        var igst      = 0;
        var igstamt   = 0;
        
        if($(this).parent().parent().find('[id*="calSGST_"]').val() != '')
        {
          var sgst      = $(this).parent().parent().find('[id*="calSGST_"]').val();
          var sgstamt   = parseFloat((parseFloat(amt)*parseFloat(sgst))/100).toFixed(2);
        }
        else
        {
          var sgst      = 0;
          var sgstamt   = 0;
        }
        
        var taxamt = parseFloat(parseFloat(igstamt) + parseFloat(cgstamt) + parseFloat(sgstamt)).toFixed(2); 
        var totamt = parseFloat(parseFloat(totamt) + parseFloat(taxamt)).toFixed(2);
        
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00');
      }
      if(intRegex.test(totamt)){
        totamt = totamt +'.00';
      }
      if(intRegex.test(igstamt)){
        igstamt = igstamt +'.00';
      }
      if(intRegex.test(cgstamt)){
        cgstamt = cgstamt +'.00';
      }
      if(intRegex.test(sgstamt)){
        sgstamt = sgstamt +'.00';
      }
      if(intRegex.test(igst)){
        igst = igst +'.0000';
      }
      if(intRegex.test(cgst)){
        cgst = cgst +'.0000';
      }
      if(intRegex.test(sgst)){
        sgst = sgst +'.0000';
      }
      $(this).parent().parent().find('[id*="TOTAMT_"]').val(totamt);
      $(this).parent().parent().find('[id*="AMTCGST_"]').val(cgstamt);
      $(this).parent().parent().find('[id*="AMTSGST_"]').val(sgstamt);
      $(this).parent().parent().find('[id*="calIGST_"]').val(igst);
      $(this).parent().parent().find('[id*="calCGST_"]').val(cgst);
      $(this).parent().parent().find('[id*="calSGST_"]').val(sgst);
      $(this).parent().parent().find('[id*="AMTIGST_"]').prop('disabled','true');
      $(this).parent().parent().find('[id*="calIGST_"]').prop('disabled','true');
      bindTotalValue();
      event.preventDefault();
    }
    else
    {
      $(this).val('0.00');
      $(this).parent().parent().find('[id*="calIGST_"]').val('0.0000');
      $(this).parent().parent().find('[id*="AMTIGST_"]').removeAttr('disabled');
      $(this).parent().parent().find('[id*="calIGST_"]').removeAttr('disabled');
      bindTotalValue();
      event.preventDefault();
    }
  }
});

$("#Account").on('focusout', "[id*='AMTSGST_']", function() 
{
  if($(this).parent().parent().find('[id*="AMOUNT_"]').val() == ''){
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Amount cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else if($(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val() == ''){
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn").hide();
    $("#OkBtn1").show();
    $("#AlertMessage").text('Assessable Value cannot be blank.');
    $("#alert").modal('show');
    $("#OkBtn1").focus();
    highlighFocusBtn('activeOk1');
    return false;
  }
  else
  {
    if($(this).val() != '' && $(this).val() != '.00' && $(this).val() > '0.00')
    { 
        var amt       = $(this).parent().parent().find('[id*="ASSESSABLE_VALUE_"]').val();
        var totamt    = $(this).parent().parent().find('[id*="AMOUNT_"]').val();
        var sgstamt   = $(this).parent().parent().find('[id*="AMTSGST_"]').val();
        var sgst      = parseFloat((parseFloat(sgstamt)*100)/parseFloat(amt)).toFixed(4);       
        
        var igst      = 0;
        var igstamt   = 0;
        
        if($(this).parent().parent().find('[id*="calCGST_"]').val() != '')
        {
          var cgst      = $(this).parent().parent().find('[id*="calCGST_"]').val();
          var cgstamt   = parseFloat((parseFloat(amt)*parseFloat(cgst))/100).toFixed(2);
        }
        else
        {
          var cgst      = 0;
          var cgstamt   = 0;
        }
        
        var taxamt = parseFloat(parseFloat(igstamt) + parseFloat(cgstamt) + parseFloat(sgstamt)).toFixed(2); 
        var totamt = parseFloat(parseFloat(totamt) + parseFloat(taxamt)).toFixed(2);
        
      if(intRegex.test($(this).val())){
        $(this).val($(this).val()+'.00');
      }
      if(intRegex.test(totamt)){
        totamt = totamt +'.00';
      }
      if(intRegex.test(igstamt)){
        igstamt = igstamt +'.00';
      }
      if(intRegex.test(cgstamt)){
        cgstamt = cgstamt +'.00';
      }
      if(intRegex.test(sgstamt)){
        sgstamt = sgstamt +'.00';
      }
      if(intRegex.test(igst)){
        igst = igst +'.0000';
      }
      if(intRegex.test(cgst)){
        cgst = cgst +'.0000';
      }
      if(intRegex.test(sgst)){
        sgst = sgst +'.0000';
      }
      $(this).parent().parent().find('[id*="TOTAMT_"]').val(totamt);
      $(this).parent().parent().find('[id*="AMTCGST_"]').val(cgstamt);
      $(this).parent().parent().find('[id*="AMTSGST_"]').val(sgstamt);
      $(this).parent().parent().find('[id*="calIGST_"]').val(igst);
      $(this).parent().parent().find('[id*="calCGST_"]').val(cgst);
      $(this).parent().parent().find('[id*="calSGST_"]').val(sgst);
      $(this).parent().parent().find('[id*="AMTIGST_"]').prop('disabled','true');
      $(this).parent().parent().find('[id*="calIGST_"]').prop('disabled','true');
      bindTotalValue();
      event.preventDefault();
    }
    else
    {
      $(this).val('0.00');
      $(this).parent().parent().find('[id*="calIGST_"]').val('0.0000');
      $(this).parent().parent().find('[id*="AMTIGST_"]').removeAttr('disabled');
      $(this).parent().parent().find('[id*="calIGST_"]').removeAttr('disabled');
      bindTotalValue();
      event.preventDefault();
    }
  }
});

//delete row
$("#Invoice").on('click', '.dinvoice', function() {
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
    bindTotalValue(); 
    event.preventDefault();
});
$("#Account").on('click', '.daccount', function() {
    var rowCount = $(this).closest('table').find('.participantRow3').length;
    if (rowCount > 1) {
    $(this).closest('.participantRow3').remove();     
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
$("#CostTable2").on('click', '.remove', function() {
    var rowCount = $(this).closest('table').find('.participantRow9').length;
    if (rowCount > 1) {
    $(this).closest('.participantRow9').remove();     
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
$("#Invoice").on('click', '.ainvoice', function() {
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

  $clone.find('input:text').val('');
  $clone.find('input:hidden').val('');
  $tr.closest('table').append($clone);         
  var rowCount1 = $('#Row_Count1').val();
  rowCount1 = parseInt(rowCount1)+1;
  $('#Row_Count1').val(rowCount1);
  $clone.find('.dinvoice').removeAttr('disabled'); 
  event.preventDefault();
});

$("#Account").on('click', '.aaccount', function() {
  var $tr = $(this).closest('table');
  var allTrs = $tr.find('.participantRow3').last();
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
  var rowCount5 = $('#Row_Count3').val();
  rowCount5 = parseInt(rowCount5)+1;
  $('#Row_Count3').val(rowCount5);
  $clone.find('.daccount').removeAttr('disabled'); 
  event.preventDefault();
});

$("#CostTable2").on('click', '.add', function() {
  var $tr = $(this).closest('table');
  var allTrs = $tr.find('.participantRow9').last();
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
  
  $clone.find('[id*="hdnAMT_"]').val('');
  $clone.find('[id*="hdnCCID_"]').val('');
  $clone.find('[id*="CostCenter_"]').val('');
  $tr.closest('table').append($clone);
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
  window.location.href = "<?php echo e(route('transaction',[$FormId,'add'])); ?>";
}//fnUndoYes


window.fnUndoNo = function (){
   
}//fnUndoNo

});
</script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('bottom-scripts'); ?>
<script>

$(document).ready(function() {
  bindTotalValue();

//   $("#btnSave").on("submit", function( event ) {

//     if ($("#frm_trn_pay").valid()) {
//         // Do something
//         alert( "Handler for .submit() called." );
//         event.preventDefault();
//     }
// });


    $('#frm_trn_pay1').bootstrapValidator({       
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
             $("#frm_trn_pay").submit();
        }
    });
});



$("#btnSave").click(function() {
var formPaymentEntry = $("#frm_trn_pay");
if(formPaymentEntry.valid()){
 $("#FocusId").val('');
 var PAYMENT_NO          =   $.trim($("#PAYMENT_NO").val());
 var PAYMENT_DT          =   $.trim($("#PAYMENT_DT").val());
 var hdnpaymentfor       =   $.trim($("#hdnpaymentfor").val());
 var CUSTMER_VENDOR_ID   =   $.trim($("#CUSTMER_VENDOR_ID").val());
 var CASH_BANK_ID        =   $.trim($("#CASH_BANK_ID").val());
 var TRANSACTION_DT      =   $.trim($("#TRANSACTION_DT").val());
 var INSTRUMENT_TYPE     =   $.trim($("#INSTRUMENT_TYPE").val());
 var INSTRUMENT_NO       =   $.trim($("#INSTRUMENT_NO").val());
 var BANK_CASH_ID        =   $.trim($("#BANK_CASH_ID").val());
 var PAYMENT_TYPE        =   $.trim($("#PAYMENT_TYPE").val());
 var AMOUNT              =   $.trim($("#AMOUNT").val());

 
var BalId=$.trim($("#BALANCE").text());
var BalId2=$.trim($("#BALANCE_ACCOUNT").text()); 
 var TotalAmount              =   parseFloat($.trim($('#tot_amt1').val())).toFixed(2); 
 var TotalAmount_account      =   parseFloat($.trim($('#BANK_AMOUNT').val())).toFixed(2); 
 var BALANCE             =   parseFloat(parseFloat($.trim($('#ODLIMIT').val()))+parseFloat($.trim(BalId.split(' ').pop()))).toFixed(2);
 var BALANCE_ACCOUNT     =   parseFloat(parseFloat($.trim($('#ODLIMIT_ACCOUNT').val()))+parseFloat($.trim(BalId2.split(' ').pop()))).toFixed(2);


 if(TotalAmount < '0.00' || TotalAmount < '0')
 {
     $("#FocusId").val($("#PAYMENT_NO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Total Payment Amount cannot be less than Zero.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }


 if(PAYMENT_NO ===""){
     $("#FocusId").val($("#PAYMENT_NO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please enter value in Payment Number.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(PAYMENT_DT ===""){
    $("#FocusId").val($("#PAYMENT_DT"));
     $("#PAYMENT_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Payment Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }  
 else if(hdnpaymentfor ===""){
     $("#FocusId").val($("#hdnpaymentfor"));
     $("#hdnpaymentfor").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select One Option from Vendor / Customer / Invoice for paymemt.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID ===""){
     $("#FocusId").val($("#CUSTMER_VENDOR_ID"));
     $("#CUSTMER_VENDOR_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Vendor.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID ===""){
     $("#FocusId").val($("#CUSTMER_VENDOR_ID"));
     $("#CUSTMER_VENDOR_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Customer.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID ===""){
     $("#FocusId").val($("#CUSTMER_VENDOR_ID"));
     $("#CUSTMER_VENDOR_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Employee.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID == ""){
     $("#FocusId").val($("#CASH_BANK_ID"));
     $("#CASH_BANK_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Cash / Bank Account.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID != "" && TRANSACTION_DT ===""){
     $("#FocusId").val($("#TRANSACTION_DT"));
     $("#TRANSACTION_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Transaction Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 } 
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" 
        && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE===""){
     $("#FocusId").val($("#INSTRUMENT_TYPE"));
     $("#INSTRUMENT_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Type');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" 
        && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE !="" && INSTRUMENT_NO===""){
     $("#FocusId").val($("#INSTRUMENT_NO"));
     $("#INSTRUMENT_NO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Number');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID == ""){
     $("#FocusId").val($("#CASH_BANK_ID"));
     $("#CASH_BANK_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Cash / Bank Account.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID != "" && TRANSACTION_DT ===""){
     $("#FocusId").val($("#TRANSACTION_DT"));
     $("#TRANSACTION_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Transaction Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 } 
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" 
        && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE===""){
     $("#FocusId").val($("#INSTRUMENT_TYPE"));
     $("#INSTRUMENT_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Type');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" 
        && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE !="" && INSTRUMENT_NO===""){
     $("#FocusId").val($("#INSTRUMENT_NO"));
     $("#INSTRUMENT_NO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Number');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE !="" && INSTRUMENT_NO===""){
     $("#FocusId").val($("#INSTRUMENT_NO"));
     $("#INSTRUMENT_NO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Number');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE ===""){
     $("#FocusId").val($("#INSTRUMENT_TYPE"));
     $("#INSTRUMENT_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Type');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && CASH_BANK_ID != "" && TRANSACTION_DT ===""){
     $("#FocusId").val($("#TRANSACTION_DT"));
     $("#TRANSACTION_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Transaction Date');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && CASH_BANK_ID ===""){
     $("#FocusId").val($("#CASH_BANK_ID"));
     $("#CASH_BANK_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Cash / Bank Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ===""){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ==="0.00"){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ===".00"){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }

 
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID == ""){
     $("#FocusId").val($("#CASH_BANK_ID"));
     $("#CASH_BANK_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Cash / Bank Account.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID != "" && TRANSACTION_DT ===""){
     $("#FocusId").val($("#TRANSACTION_DT"));
     $("#TRANSACTION_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Transaction Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 } 
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" 
        && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE===""){
     $("#FocusId").val($("#INSTRUMENT_TYPE"));
     $("#INSTRUMENT_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Type');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" 
        && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE !="" && INSTRUMENT_NO===""){
     $("#FocusId").val($("#INSTRUMENT_NO"));
     $("#INSTRUMENT_NO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Number');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE !="" && INSTRUMENT_NO===""){
     $("#FocusId").val($("#INSTRUMENT_NO"));
     $("#INSTRUMENT_NO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Number');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE ===""){
     $("#FocusId").val($("#INSTRUMENT_TYPE"));
     $("#INSTRUMENT_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Type');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && CASH_BANK_ID != "" && TRANSACTION_DT ===""){
     $("#FocusId").val($("#TRANSACTION_DT"));
     $("#TRANSACTION_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Transaction Date');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && CASH_BANK_ID ===""){
     $("#FocusId").val($("#CASH_BANK_ID"));
     $("#CASH_BANK_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Cash / Bank Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ===""){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ==="0.00"){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Employee').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ===".00"){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }


 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE !="" && INSTRUMENT_NO===""){
     $("#FocusId").val($("#INSTRUMENT_NO"));
     $("#INSTRUMENT_NO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Number');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE ===""){
     $("#FocusId").val($("#INSTRUMENT_TYPE"));
     $("#INSTRUMENT_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Type');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && CASH_BANK_ID != "" && TRANSACTION_DT ===""){
     $("#FocusId").val($("#TRANSACTION_DT"));
     $("#TRANSACTION_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Transaction Date');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && CASH_BANK_ID ===""){
     $("#FocusId").val($("#CASH_BANK_ID"));
     $("#CASH_BANK_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Cash / Bank Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ===""){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ==="0.00"){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ===".00"){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Account').is(':checked') == true && BANK_CASH_ID ==="")
 {
     $("#FocusId").val($("#txtbnkcsh"));
     $("#txtbnkcsh").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Bank / Cash Account in Account Tab');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID !="" && parseFloat(TotalAmount) > parseFloat(BALANCE) )
 {
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('The Selected Bank / Cash Account balance is low, your available balance inclusive OD Limit is '+BALANCE);
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID !="" && parseFloat(TotalAmount) > parseFloat(BALANCE) )
 {
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('The Selected Bank / Cash Account balance is low, your available balance inclusive OD Limit is '+BALANCE);
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Account').is(':checked') == true && BANK_CASH_ID !="" && parseFloat(TotalAmount_account) > parseFloat(BALANCE_ACCOUNT) )
 {
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('The Selected Bank / Cash Account balance is low, your available balance inclusive OD Limit is '+BALANCE_ACCOUNT);
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else{
	 GetMonthlyBudget(); 
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

        if($('#chk_Vendor').is(':checked') == true && $('#chk_PayAccount').is(':checked') == false)
        {
          $('#example2').find('.participantRow2').each(function()
          {    
              if($.trim($(this).find("[id*=txtDoc_NO_]").val())!="")
              {
                    allblank.push('true');
                    if($.trim($(this).find("[id*=PAYMENT_AMT_]").val())!="")
                    {
                          allblank2.push('true');                          
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
        }
        if($('#chk_Customer').is(':checked') == true && $('#chk_PayAccount').is(':checked') == false)
        {
          $('#example2').find('.participantRow2').each(function()
          {    
              if($.trim($(this).find("[id*=txtDoc_NO_]").val())!="")
              {
                    allblank.push('true');
                    if($.trim($(this).find("[id*=PAYMENT_AMT_]").val())!="")
                    {
                          allblank2.push('true');                          
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
        }


        if($('#chk_Employee').is(':checked') == true && $('#chk_PayAccount').is(':checked') == false)
        {
          $('#example2').find('.participantRow2').each(function()
          {    
              if($.trim($(this).find("[id*=txtDoc_NO_]").val())!="")
              {
                    allblank.push('true');
                    if($.trim($(this).find("[id*=PAYMENT_AMT_]").val())!="")
                    {
                          allblank2.push('true');                          
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
        }

        
        if($('#chk_Account').is(':checked') == true && BANK_CASH_ID !="")
        {
            $('#example3').find('.participantRow3').each(function(){
              if($.trim($(this).find("[id*=popupAccount_]").val())!="")
                {
                    allblank3.push('true');
                        if($.trim($(this).find("[id*=AMOUNT_]").val())!="" && $.trim($(this).find("[id*=AMOUNT_]").val())!="0.00"
                           && $.trim($(this).find("[id*=AMOUNT_]").val())!=".00")
                           {
                              allblank4.push('true');                               
                           } 
                           else
                           {
                              allblank4.push('false');
                           }
                }
                else
                {
                    allblank3.push('false');
                } 
            });
        }

    }
        
        if(jQuery.inArray("false", allblank) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please select Document in Invoice Details Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank2) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please enter Paymemt Amount in Invoice Details Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank3) !== -1){
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please select Account Code in Account Tab.');
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
          $("#AlertMessage").text('Please enter Amount in Account Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          }
        else if(checkPeriodClosing('<?php echo e($FormId); ?>',PAYMENT_DT,0) ==0){
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text(period_closing_msg);
          $("#alert").modal('show');
          $("#OkBtn1").focus();
        }

        else if($('#chk_Account').is(':checked') == true && parseFloat($("#BANK_AMOUNT").val()) > parseFloat($("#BUDGET_AMOUNT").val()) && parseFloat($("#BUDGET_AMOUNT").val()) !=""){
              $("#ProceedBtn").focus();
              $("#YesBtn").hide();
              $("#NoBtn").hide();
              $("#OkBtn1").show();
              $("#AlertMessage").html('Kindly check total amount is more than the budget amount. <br/><br/><input type="checkbox" id="check_budget_amount" onchange="checkBudgetAmount()" >');
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
var formPaymentEntry = $("#frm_trn_pay");
if(formPaymentEntry.valid()){
 $("#FocusId").val('');
 var PAYMENT_NO          =   $.trim($("#PAYMENT_NO").val());
 var PAYMENT_DT          =   $.trim($("#PAYMENT_DT").val());
 var hdnpaymentfor       =   $.trim($("#hdnpaymentfor").val());
 var CUSTMER_VENDOR_ID   =   $.trim($("#CUSTMER_VENDOR_ID").val());
 var CASH_BANK_ID        =   $.trim($("#CASH_BANK_ID").val());
 var TRANSACTION_DT      =   $.trim($("#TRANSACTION_DT").val());
 var INSTRUMENT_TYPE     =   $.trim($("#INSTRUMENT_TYPE").val());
 var INSTRUMENT_NO       =   $.trim($("#INSTRUMENT_NO").val());
 var BANK_CASH_ID        =   $.trim($("#BANK_CASH_ID").val());
 var PAYMENT_TYPE        =   $.trim($("#PAYMENT_TYPE").val());
 var AMOUNT              =   $.trim($("#AMOUNT").val());

 var TotalAmount = $("#tot_amt1").val();

 if(TotalAmount < '0.00' || TotalAmount < '0')
 {
     $("#FocusId").val($("#PAYMENT_NO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Total Payment Amount cannot be less than Zero.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }


 if(PAYMENT_NO ===""){
     $("#FocusId").val($("#PAYMENT_NO"));
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please enter value in Payment Number.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if(PAYMENT_DT ===""){
    $("#FocusId").val($("#PAYMENT_DT"));
     $("#PAYMENT_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Payment Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }  
 else if(hdnpaymentfor ===""){
     $("#FocusId").val($("#hdnpaymentfor"));
     $("#hdnpaymentfor").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select One Option from Vendor / Customer / Invoice for paymemt.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID ===""){
     $("#FocusId").val($("#CUSTMER_VENDOR_ID"));
     $("#CUSTMER_VENDOR_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Vendor.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID ===""){
     $("#FocusId").val($("#CUSTMER_VENDOR_ID"));
     $("#CUSTMER_VENDOR_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Customer.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID == ""){
     $("#FocusId").val($("#CASH_BANK_ID"));
     $("#CASH_BANK_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Cash / Bank Account.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID != "" && TRANSACTION_DT ===""){
     $("#FocusId").val($("#TRANSACTION_DT"));
     $("#TRANSACTION_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Transaction Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 } 
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" 
        && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE===""){
     $("#FocusId").val($("#INSTRUMENT_TYPE"));
     $("#INSTRUMENT_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Type');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" 
        && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE !="" && INSTRUMENT_NO===""){
     $("#FocusId").val($("#INSTRUMENT_NO"));
     $("#INSTRUMENT_NO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Number');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID == ""){
     $("#FocusId").val($("#CASH_BANK_ID"));
     $("#CASH_BANK_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Cash / Bank Account.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && CASH_BANK_ID != "" && TRANSACTION_DT ===""){
     $("#FocusId").val($("#TRANSACTION_DT"));
     $("#TRANSACTION_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Transaction Date.');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 } 
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" 
        && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE===""){
     $("#FocusId").val($("#INSTRUMENT_TYPE"));
     $("#INSTRUMENT_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Type');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" 
        && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE !="" && INSTRUMENT_NO===""){
     $("#FocusId").val($("#INSTRUMENT_NO"));
     $("#INSTRUMENT_NO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Number');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE !="" && INSTRUMENT_NO===""){
     $("#FocusId").val($("#INSTRUMENT_NO"));
     $("#INSTRUMENT_NO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Number');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE ===""){
     $("#FocusId").val($("#INSTRUMENT_TYPE"));
     $("#INSTRUMENT_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Type');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && CASH_BANK_ID != "" && TRANSACTION_DT ===""){
     $("#FocusId").val($("#TRANSACTION_DT"));
     $("#TRANSACTION_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Transaction Date');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && CASH_BANK_ID ===""){
     $("#FocusId").val($("#CASH_BANK_ID"));
     $("#CASH_BANK_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Cash / Bank Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ===""){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ==="0.00"){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Customer').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ===".00"){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE !="" && INSTRUMENT_NO===""){
     $("#FocusId").val($("#INSTRUMENT_NO"));
     $("#INSTRUMENT_NO").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Number');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && PAYMENT_TYPE == "Bank" && CASH_BANK_ID != "" && TRANSACTION_DT !="" &&  INSTRUMENT_TYPE ===""){
     $("#FocusId").val($("#INSTRUMENT_TYPE"));
     $("#INSTRUMENT_TYPE").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Instrument Type');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && CASH_BANK_ID != "" && TRANSACTION_DT ===""){
     $("#FocusId").val($("#TRANSACTION_DT"));
     $("#TRANSACTION_DT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Transaction Date');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && CASH_BANK_ID ===""){
     $("#FocusId").val($("#CASH_BANK_ID"));
     $("#CASH_BANK_ID").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Select Cash / Bank Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ===""){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ==="0.00"){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Vendor').is(':checked') == true && CUSTMER_VENDOR_ID !="" && $('#chk_PayAccount').is(':checked') == true
        && AMOUNT ===".00"){
     $("#FocusId").val($("#AMOUNT"));
     $("#AMOUNT").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please Enter Amount for Payment on Account');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else if($('#chk_Account').is(':checked') == true && BANK_CASH_ID ==="")
 {
     $("#FocusId").val($("#txtbnkcsh"));
     $("#txtbnkcsh").val('');  
     $("#ProceedBtn").focus();
     $("#YesBtn").hide();
     $("#NoBtn").hide();
     $("#OkBtn1").show();
     $("#AlertMessage").text('Please select Bank / Cash Account in Account Tab');
     $("#alert").modal('show');
     $("#OkBtn1").focus();
     return false;
 }
 else{
	 GetMonthlyBudget(); 
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

        if($('#chk_Vendor').is(':checked') == true && $('#chk_PayAccount').is(':checked') == false)
        {
          $('#example2').find('.participantRow2').each(function()
          {    
              if($.trim($(this).find("[id*=txtDoc_NO_]").val())!="")
              {
                    allblank.push('true');
                    if($.trim($(this).find("[id*=PAYMENT_AMT_]").val())!="")
                    {
                          allblank2.push('true');                          
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
        }
        if($('#chk_Customer').is(':checked') == true && $('#chk_PayAccount').is(':checked') == false)
        {
          $('#example2').find('.participantRow2').each(function()
          {    
              if($.trim($(this).find("[id*=txtDoc_NO_]").val())!="")
              {
                    allblank.push('true');
                    if($.trim($(this).find("[id*=PAYMENT_AMT_]").val())!="")
                    {
                          allblank2.push('true');                          
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
        }

        
        if($('#chk_Account').is(':checked') == true && BANK_CASH_ID !="")
        {
            $('#example3').find('.participantRow3').each(function(){
              if($.trim($(this).find("[id*=popupAccount_]").val())!="")
                {
                    allblank3.push('true');
                        if($.trim($(this).find("[id*=AMOUNT_]").val())!="" && $.trim($(this).find("[id*=AMOUNT_]").val())!="0.00"
                           && $.trim($(this).find("[id*=AMOUNT_]").val())!=".00")
                           {
                              allblank4.push('true');                               
                           } 
                           else
                           {
                              allblank4.push('false');
                           }
                }
                else
                {
                    allblank3.push('false');
                } 
            });
        }

    }
        
        if(jQuery.inArray("false", allblank) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please select Document in Invoice Details Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank2) !== -1){
          $("#alert").modal('show');
          $("#AlertMessage").text('Please enter Paymemt Amount in Invoice Details Tab.');
          $("#YesBtn").hide(); 
          $("#NoBtn").hide();  
          $("#OkBtn1").show();
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk');
          }
        else if(jQuery.inArray("false", allblank3) !== -1){
          $("#ProceedBtn").focus();
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('Please select Account Code in Account Tab.');
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
          $("#AlertMessage").text('Please enter Amount in Account Tab.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          return false;
          }
        else if(checkPeriodClosing('<?php echo e($FormId); ?>',PAYMENT_DT,0) ==0){
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text(period_closing_msg);
          $("#alert").modal('show');
          $("#OkBtn1").focus();
        } else if($('#chk_Account').is(':checked') == true && parseFloat($("#BANK_AMOUNT").val()) > parseFloat($("#BUDGET_AMOUNT").val()) && parseFloat($("#BUDGET_AMOUNT").val()) !=""){
              $("#ProceedBtn").focus();
              $("#YesBtn").hide();
              $("#NoBtn").hide();
              $("#OkBtn1").show();
              $("#AlertMessage").html('Kindly check total amount is more than the budget amount. <br/><br/><input type="checkbox" id="check_budget_amount" onchange="checkBudgetAmount()" >');
              $("#alert").modal('show');
              $("#OkBtn1").focus();
              return false;
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

$("#YesBtn").click(function(){

$("#alert").modal('hide');
var customFnName = $("#YesBtn").data("funcname");
    window[customFnName]();

}); //yes button

// $("#btnSave" ).click(function() {
//     var formReqData = $("#frm_trn_pay");
//     if(formReqData.valid()){
//       validateForm();
//     }
// });

window.fnSaveData = function (){
//validate and save data
event.preventDefault();

     var trnseForm = $("#frm_trn_pay");
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
    url:'<?php echo e(route("transaction",[$FormId,"update"])); ?>',
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
            // window.location.href="<?php echo e(route('transaction',[90,'index'])); ?>";
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
            // window.location.href="<?php echo e(route('transaction',[90,'index'])); ?>";
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

     var trnseForm = $("#frm_trn_pay");
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
    url:'<?php echo e(route("transaction",[$FormId,"Approve"])); ?>',
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
            // window.location.href="<?php echo e(route('transaction',[90,'index'])); ?>";
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
            // window.location.href="<?php echo e(route('transaction',[90,'index'])); ?>";
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
    window.location.href = '<?php echo e(route("transaction",[$FormId,"index"])); ?>';
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
  //console.log(all_location_id); 
 
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

$(document).ready(function(){
  var lastdt = <?php echo json_encode($objlastdt[0]->PAYMENT_DT); ?>;
  var pe = <?php echo json_encode($objPAYHDR); ?>;
  var today = new Date(); 
  var sodate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2);
  if(lastdt < pe.PAYMENT_DT)
  {
	$('#PAYMENT_DT').attr('min',lastdt);
  }
  else
  {
	  $('#PAYMENT_DT').attr('min',pe.PAYMENT_DT);
  }
  $('#PAYMENT_DT').attr('max',sodate);
});


//GL SL Account
let glslid = "#GlCodeTable2";
      let glslid2 = "#GlCodeTable";
      let slglheaders = document.querySelectorAll(glslid2 + " th");

      // Sort the table element when clicking on the table headers
      slglheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(glslid, ".clscrid", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function GLSLCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("glslcodesearch");
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

  function GLSLNameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("glslnamesearch");
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


//Round of GL Starts here
let GL = "#GeneralLedgerTable2";
      let GL2 = "#GeneralLedger";
      let GLheaders = document.querySelectorAll(GL2 + " th");

      // Sort the table element when clicking on the table headers
      GLheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(GL, ".clsspid_reasoncode1", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function GLCodeFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("GLcodesearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("GeneralLedgerTable2");
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
        table = document.getElementById("GeneralLedgerTable2");
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


  $("#GL_closePopup1").click(function(event){
        $("#GL_popup").hide();
      });

  function bindGLEvents(){
      $(".clsspid_gl").click(function(){       

        var fieldid = $(this).attr('id');
        var txtval =    $("#txt"+fieldid+"").val();
        var texdesc =   $("#txt"+fieldid+"").data("desc");
        var texcode =   $("#txt"+fieldid+"").data("code"); 
        $('#txtGLpopup').val(texcode);
        $('#GLID_REF_ROUNDOFF').val(txtval);   
        getBalance(txtval,'BALANCE_ROUNDGL','BALANCE_ROUNDGL_SHOW');      
        $("#GL_popup").hide();   
        $("#GLcodesearch").val(''); 
        $("#glnamesearch").val('');            
        event.preventDefault();
      });
  }

  $('#txtGLpopup').on('click',function(event){     
                $("#GLresult").html('');
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $("#item_seach").show();
                  $.ajax({
                      url:'<?php echo e(route("transaction",[301,"get_gl_detail"])); ?>',
                      type:'POST',
                      data:{},
                      success:function(data) {                                
                        $("#item_seach").hide();
                        $("#GLresult").html(data);   
                        showSelectedCheck($("#GLID_REF_ROUNDOFF").val(),"getgl");
                        bindGLEvents();                                        
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#GLresult").html('');                        
                      },
                  }); 

                  showSelectedCheck($("#REASONCODE1_REF").val(),"getgl");
                  $("#GL_popup").show();         
    });



    function getTaxStatus_customer(customid){

var TaxStatus = $.ajax({type: 'POST',url:'<?php echo e(route("transaction",[301,"getTaxStatus_customer"])); ?>',async: false,dataType: 'json',data: {id:customid},done: function(response) {return response;}}).responseText;
  
if(TaxStatus =="1"){
  $(".ExceptionalGST").show();
  $("#EXE_GST").prop('checked', true);
}
else{
  $(".ExceptionalGST").hide();
  $("#EXE_GST").prop('checked', false);
}  

}
    function getTaxStatus(customid){

var TaxStatus = $.ajax({type: 'POST',url:'<?php echo e(route("transaction",[301,"getTaxStatus"])); ?>',async: false,dataType: 'json',data: {id:customid},done: function(response) {return response;}}).responseText;
  
if(TaxStatus =="1"){
  $(".ExceptionalGST").show();
  $("#EXE_GST").prop('checked', true);
}
else{
  $(".ExceptionalGST").hide();
  $("#EXE_GST").prop('checked', false);
}  

}


//--------------------TDS SECTION STARTS HERE---------------------------

$("#TDS").on('change', "[id*='TDSApplicable']", function(){
  var totalamount = 0.00;
  if($(this).is(':checked') == true)
  {

    $(this).parent().parent().find('[id*="TDS_RATE"]').removeAttr('readonly');

    var taxamt12 = 0.00;
    if($('#chk_PayAccount').is(':checked') == true)
	{
		var taxamt22 = $('#AMOUNT').val();
	    taxamt12 = parseFloat(parseFloat(taxamt12)+parseFloat(taxamt22)).toFixed(2);
	}
	else
	{
		$('#Material').find('.participantRow').each(function()
		{
			if($(this).find('[id*="DISAFTT_AMT"]').val() != '')
			{
			  var taxamt21 = $(this).find('[id*="DISAFTT_AMT"]').val();
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
	}
    $(this).parent().parent().find("[id*='ASSESSABLE_VL_']").val(taxamt12);
    var tdsamt = 0.00;
    var tdsrate = $(this).parent().parent().find("[id*='TDS_RATE_']").val();
    var tdsexempt = $(this).parent().parent().find("[id*='TDS_EXEMPT_']").val();
    if (parseFloat(taxamt12) > parseFloat(tdsexempt))
    {
        tdsamt = parseFloat(((parseFloat(taxamt12))*parseFloat(tdsrate))/100).toFixed(2);
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
        SURCHARGEamt = parseFloat(((parseFloat(taxamt12))*parseFloat(SURCHARGErate))/100).toFixed(2);
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
        CESSamt = parseFloat(((parseFloat(taxamt12))*parseFloat(CESSrate))/100).toFixed(2);
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
        SPCESSamt = parseFloat(((parseFloat(taxamt12))*parseFloat(SPCESSrate))/100).toFixed(2);
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
    $(this).parent().parent().find('[id*="TDS_RATE_"]').prop('readonly',true);
    $(this).parent().parent().find("[id*='ASSESSABLE_VL_']").val('0.00');
    $(this).parent().parent().find("[id*='AMT_']").val('0.00');
  }
  bindTotalValue();
  if($('#CTID_REF').val()!='')
  {
    //bindGSTCalTemplate();
  }
  bindTotalValue();
  if($('#TotalValue').val() < '0.00')
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


$("#TDS").on('focusout', "[id*='ASSESSABLE_VL_']", function(){
  var totalamount = 0.00;
  if(intRegex.test($(this).val())){
    $(this).val($(this).val() +'.00');
  }
    
  var taxamtTDS =  $(this).parent().parent().find("[id*='ASSESSABLE_VL_TDS']").val();
  var tdsamt = 0.00;
  var tdsrate = $(this).parent().parent().find("[id*='TDS_RATE_']").val();
  var tdsexempt = $(this).parent().parent().find("[id*='TDS_EXEMPT_']").val();

  if (parseFloat(taxamtTDS) > parseFloat(tdsexempt)){
    tdsamt = parseFloat(((parseFloat(taxamtTDS))*parseFloat(tdsrate))/100).toFixed(2);
  }
  else{
    tdsamt =  0.00;
  }

  $(this).parent().parent().find("[id*='TDS_AMT_']").val(tdsamt);

    var taxamtSURCHARGE =  $(this).parent().parent().find("[id*='ASSESSABLE_VL_SURCHARGE']").val();
    var SURCHARGEamt = 0.00;
    var SURCHARGErate = $(this).parent().parent().find("[id*='SURCHARGE_RATE_']").val();
    var SURCHARGEexempt = $(this).parent().parent().find("[id*='SURCHARGE_EXEMPT_']").val();
    if (parseFloat(taxamtSURCHARGE) > parseFloat(SURCHARGEexempt))
    {
        SURCHARGEamt = parseFloat(((parseFloat(taxamtSURCHARGE))*parseFloat(SURCHARGErate))/100).toFixed(2);
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
        CESSamt = parseFloat(((parseFloat(taxamtCESS))*parseFloat(CESSrate))/100).toFixed(2);
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
        SPCESSamt = parseFloat(((parseFloat(taxamtSPCESS))*parseFloat(SPCESSrate))/100).toFixed(2);
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
     // bindGSTCalTemplate();
    }
    bindTotalValue();
    if($('#TotalValue').val() < '0.00')
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

$("#TDS").on('focusout', "[id*='TDS_RATE_']", function(){
  var totalamount = 0.00;
  if(intRegex.test($(this).val())){
    $(this).val($(this).val() +'.00');
  }
    
  var taxamtTDS =  $(this).parent().parent().find("[id*='ASSESSABLE_VL_TDS']").val();
  var tdsamt = 0.00;
  var tdsrate = $(this).parent().parent().find("[id*='TDS_RATE_']").val();
  var tdsexempt = $(this).parent().parent().find("[id*='TDS_EXEMPT_']").val();

  if (parseFloat(taxamtTDS) > parseFloat(tdsexempt)){
    tdsamt = parseFloat(((parseFloat(taxamtTDS))*parseFloat(tdsrate))/100).toFixed(2);
  }
  else{
    tdsamt =  0.00;
  }

  $(this).parent().parent().find("[id*='TDS_AMT_']").val(tdsamt);

    var taxamtSURCHARGE =  $(this).parent().parent().find("[id*='ASSESSABLE_VL_SURCHARGE']").val();
    var SURCHARGEamt = 0.00;
    var SURCHARGErate = $(this).parent().parent().find("[id*='SURCHARGE_RATE_']").val();
    var SURCHARGEexempt = $(this).parent().parent().find("[id*='SURCHARGE_EXEMPT_']").val();
    if (parseFloat(taxamtSURCHARGE) > parseFloat(SURCHARGEexempt))
    {
        SURCHARGEamt = parseFloat(((parseFloat(taxamtSURCHARGE))*parseFloat(SURCHARGErate))/100).toFixed(2);
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
        CESSamt = parseFloat(((parseFloat(taxamtCESS))*parseFloat(CESSrate))/100).toFixed(2);
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
        SPCESSamt = parseFloat(((parseFloat(taxamtSPCESS))*parseFloat(SPCESSrate))/100).toFixed(2);
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
      //bindGSTCalTemplate();
    }
    bindTotalValue();
    if($('#TotalValue').val() < '0.00')
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


function getExceptionalGst(){
  if($("#EXE_GST").is(":checked") == false){
    $('#TotalValue').val('0.00');    
    $('#TDS').find('.participantRow7').each(function(){
      var rowcount = $(this).closest('table').find('.participantRow7').length;
      $(this).find('input:text').val('');
      $(this).find('input:hidden').val('');
      $(this).find('input:checkbox').removeAttr('checked');
      var rowcount = $('#Row_Count6').val();
      if(rowcount > 1){
        $(this).closest('.participantRow7').remove();
        rowcount = parseInt(rowcount) - 1;
        $('#Row_Count6').val(rowcount);
      }
    });



  }
  bindTotalValue();

}

//--------------------TDS SECTION ENDS HERE-----------------------------

  
    function bindTotalValue()
    {
      var totalvalue = 0.00;
      var totalvalue2 = 0.00;
      var tvalue = 0.00;
      var tvalue2 = 0.00;


      var CommonValue = $('#hdnpaymentfor').val();     
     

      if($('#hdnpaymentfor').val() != 'Account')
      {
        $('#Invoice').find('.participantRow2').each(function()
        {
            if($(this).find('[id*="PAYMENT_AMT_"]').val() != '')
            {
              tvalue = $(this).find('[id*="PAYMENT_AMT_"]').val();
              if($(this).find('[id*="Doc_Type_"]').val() == 'PURCHASE_INVOICE' 
                  || $(this).find('[id*="Doc_Type_"]').val() == 'SERVICE_PURCHASE_INVOICE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'IMPORT_PURCHASE_INVOICE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'AP_CREDIT_NOTE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'AP_INVOICE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'SALES_INVOICE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'AR_DEBIT_NOTE'
				  || $(this).find('[id*="Doc_Type_"]').val() == 'MANUAL_JOURNAL_CREDIT'
                )
              {
                totalvalue = parseFloat(parseFloat(totalvalue) + parseFloat(tvalue)).toFixed(2);
              }
              else if($(this).find('[id*="Doc_Type_"]').val() == 'PURCHASE_RETURN' 
                  || $(this).find('[id*="Doc_Type_"]').val() == 'AP_DEBIT_NOTE'
				  || $(this).find('[id*="Doc_Type_"]').val() == 'SERVICE_PURCHASE_INVOICE_DEBIT'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'DEBIT_NOTE_STOCK'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'SALES_RETURN'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'AR_CREDIT_NOTE'
                  || $(this).find('[id*="Doc_Type_"]').val() == 'CREDIT_NOTE_STOCK'
				  || $(this).find('[id*="Doc_Type_"]').val() == 'MANUAL_JOURNAL_DEBIT'
                )
              {
                totalvalue = parseFloat(parseFloat(totalvalue) - parseFloat(tvalue)).toFixed(2);
              }
              else 
              {
              totalvalue = parseFloat(parseFloat(totalvalue) + parseFloat(tvalue)).toFixed(2);
              }
            }
        });
        if( $('#BANK_CHARGE').val() != '')    
        {
          totalvalue = parseFloat(parseFloat(totalvalue) + parseFloat($('#BANK_CHARGE').val())).toFixed(2);
        } 
        if( $('#AMOUNT').val() != '')    
        {
          totalvalue = parseFloat(parseFloat(totalvalue) + parseFloat($('#AMOUNT').val())).toFixed(2);
        }  

        if($('#ROUNDOFF_MODE :selected').val()=='Positive' && $("#ROUNDOFF_AMT").val() !=''){
          totalvalue = parseFloat(parseFloat(totalvalue) + parseFloat($('#ROUNDOFF_AMT').val())).toFixed(2);
        }else if($('#ROUNDOFF_MODE :selected').val()=='Negative' && $("#ROUNDOFF_AMT").val() !=''){
          totalvalue = parseFloat(parseFloat(totalvalue) - parseFloat($('#ROUNDOFF_AMT').val())).toFixed(2);
        }


        if(CommonValue=='Vendor'){
        if($('#drpTDS').val() == 'Yes'){
    $('#TDS').find('.participantRow7').each(function(){
      if($(this).find('[id*="TOT_TD_AMT"]').val() != '' && $(this).find('[id*="TOT_TD_AMT"]').val() != '.00')
      {

        tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
        totalvalue = parseFloat(parseFloat(totalvalue)-parseFloat(tttdsamt21)).toFixed(2);
      }
    });
  }
  }else if(CommonValue=='Customer'){
    if($('#drpTDS').val() == 'Yes'){
    $('#TDS').find('.participantRow7').each(function(){
      if($(this).find('[id*="TOT_TD_AMT"]').val() != '' && $(this).find('[id*="TOT_TD_AMT"]').val() != '.00')
      {

        tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
        totalvalue = parseFloat(parseFloat(totalvalue)+parseFloat(tttdsamt21)).toFixed(2);
      }
    });
  }
  }

       
        $('#tot_amt1').val(totalvalue);
      }
      else
      {
        $('#Account').find('.participantRow3').each(function()
        {
          tvalue2 = $(this).find('[id*="TOTAMT_"]').val();    
          totalvalue2 = parseFloat(parseFloat(totalvalue2) + parseFloat(tvalue2)).toFixed(2);      
        });


        if($('#ROUNDOFF_MODE :selected').val()=='Positive' && $("#ROUNDOFF_AMT").val() !=''){
          totalvalue2 = parseFloat(parseFloat(totalvalue2) + parseFloat($('#ROUNDOFF_AMT').val())).toFixed(2);
        }else if($('#ROUNDOFF_MODE :selected').val()=='Negative' && $("#ROUNDOFF_AMT").val() !=''){
          totalvalue2 = parseFloat(parseFloat(totalvalue2) - parseFloat($('#ROUNDOFF_AMT').val())).toFixed(2);
        }

        if(CommonValue=='Vendor'){
        if($('#drpTDS').val() == 'Yes'){
    $('#TDS').find('.participantRow7').each(function(){
      if($(this).find('[id*="TOT_TD_AMT"]').val() != '' && $(this).find('[id*="TOT_TD_AMT"]').val() != '.00')
      {

        tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
        totalvalue2 = parseFloat(parseFloat(totalvalue2)-parseFloat(tttdsamt21)).toFixed(2);
      }
    });
  }
        }else  if(CommonValue=='Customer'){
          if($('#drpTDS').val() == 'Yes'){
    $('#TDS').find('.participantRow7').each(function(){
      if($(this).find('[id*="TOT_TD_AMT"]').val() != '' && $(this).find('[id*="TOT_TD_AMT"]').val() != '.00')
      {

        tttdsamt21 = $(this).find('[id*="TOT_TD_AMT"]').val();
        totalvalue2 = parseFloat(parseFloat(totalvalue2)+parseFloat(tttdsamt21)).toFixed(2);
      }
    });
  }
        }


        $('#tot_amt1').val(totalvalue2);
      }

      calculateBankAmount();
  }

  function calculateBankAmount(){
  
  var CommonValue         = $('#hdnpaymentfor').val(); 
  var ROUNDOFF_MODE       = $('#ROUNDOFF_MODE').val(); 
  var ROUNDOFF_AMT        = $('#ROUNDOFF_AMT').val(); 

  var TOTAL_ROUNDOFF_AMT  = ROUNDOFF_AMT !=''?parseFloat(ROUNDOFF_AMT):0;
  var TOTAL_ACCOUNT_AMT   = 0;
  var TOTAL_TDS_AMT       = 0;
  var TOTAL_BANK_AMOUNT   = 0;

  if(CommonValue=='Account'){

    $('#Account').find('.participantRow3').each(function(){
      if($(this).find('[id*="TOTAMT_"]').val() != '' && $(this).find('[id*="TOTAMT_"]').val() != '.00'){
        var TOTAMT        = $(this).find('[id*="TOTAMT_"]').val();  
        TOTAL_ACCOUNT_AMT = parseFloat(TOTAL_ACCOUNT_AMT)+parseFloat(TOTAMT);  
      }
    });

    if($('#drpTDS').val() == 'Yes'){
      $('#TDS').find('.participantRow7').each(function(){
        if($(this).find('[id*="TOT_TD_AMT"]').val() != '' && $(this).find('[id*="TOT_TD_AMT"]').val() != '.00'){
          var TOT_TD_AMT  = $(this).find('[id*="TOT_TD_AMT"]').val();
          TOTAL_TDS_AMT   = parseFloat(TOTAL_TDS_AMT)+parseFloat(TOT_TD_AMT);
        }
      });
    }
  
    if(ROUNDOFF_MODE ==='Positive'){
      var TOTAL_BANK_AMOUNT = parseFloat((parseFloat(TOTAL_ACCOUNT_AMT)-parseFloat(TOTAL_TDS_AMT))+TOTAL_ROUNDOFF_AMT).toFixed(2);
    }
    else if(ROUNDOFF_MODE ==='Negative'){
      var TOTAL_BANK_AMOUNT = parseFloat((parseFloat(TOTAL_ACCOUNT_AMT)-parseFloat(TOTAL_TDS_AMT))-TOTAL_ROUNDOFF_AMT).toFixed(2);
    }
    else{
      var TOTAL_BANK_AMOUNT = parseFloat('0.00').toFixed(2);
    }

  }

  $('#BANK_AMOUNT').val(TOTAL_BANK_AMOUNT); 
  getTotalRowValue();
}

function getTotalRowValue(){

var AMOUNT  = 0;
var AMTIGST = 0;
var AMTCGST = 0;
var AMTSGST = 0;
var TOTAMT  = 0;

$('#Account').find('.participantRow3').each(function(){
  AMOUNT  = $(this).find('[id*="AMOUNT"]').val() > 0?AMOUNT+parseFloat($(this).find('[id*="AMOUNT"]').val()):AMOUNT;
  AMTIGST = $(this).find('[id*="AMTIGST"]').val() > 0?AMTIGST+parseFloat($(this).find('[id*="AMTIGST"]').val()):AMTIGST;
  AMTCGST = $(this).find('[id*="AMTCGST"]').val() > 0?AMTCGST+parseFloat($(this).find('[id*="AMTCGST"]').val()):AMTCGST;
  AMTSGST = $(this).find('[id*="AMTSGST"]').val() > 0?AMTSGST+parseFloat($(this).find('[id*="AMTSGST"]').val()):AMTSGST;
  TOTAMT  = $(this).find('[id*="TOTAMT"]').val() > 0?TOTAMT+parseFloat($(this).find('[id*="TOTAMT"]').val()):TOTAMT;
});

AMOUNT  = AMOUNT > 0?parseFloat(AMOUNT).toFixed(2):'';
AMTIGST = AMTIGST > 0?parseFloat(AMTIGST).toFixed(2):'';
AMTCGST = AMTCGST > 0?parseFloat(AMTCGST).toFixed(2):'';
AMTSGST = AMTSGST > 0?parseFloat(AMTSGST).toFixed(2):'';
TOTAMT  = TOTAMT > 0?parseFloat(TOTAMT).toFixed(2):'';

$("#AMOUNT_TOTAL").text(AMOUNT);
$("#AMTIGST_TOTAL").text(AMTIGST);
$("#AMTCGST_TOTAL").text(AMTCGST);
$("#AMTSGST_TOTAL").text(AMTSGST);
$("#TOTAMT_TOTAL").text(TOTAMT);
}

function getBalance(bankid,fieldid,fieldidshow){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var TaxStatus = $.ajax({type: 'POST',
  url:'<?php echo e(route("transaction",[301,"getBalance"])); ?>',
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
  url:'<?php echo e(route("transaction",[301,"getBalance"])); ?>',
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

/*==================================PO POPUP STARTS HERE====================================*/
let PO = "#POOrderTable2";
      let PO2 = "#POOrder";
      let POheaders = document.querySelectorAll(PO2 + " th");
      // Sort the table element when clicking on the table headers
      POheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(PO, ".clsspid_reasoncode1", "td:nth-child(" + (i + 1) + ")");
        });
      });

      function PODocFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("PONo");
        filter = input.value.toUpperCase();
        table = document.getElementById("POOrderTable2");
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

  function PONameFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("POName");
        filter = input.value.toUpperCase();
        table = document.getElementById("POOrderTable2");
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
  


  $("#PO_closePopup").click(function(event){
        $("#PO_popup").hide();
      });

  function bindPOEvents(){
      $(".clsspid_po").click(function(){       

        var fieldid     =   $(this).attr('id');
        var txtval      =   $("#txt"+fieldid+"").val();
        var texdesc     =   $("#txt"+fieldid+"").data("desc");
        var texcode     =   $("#txt"+fieldid+"").data("code"); 
    
    
        $('#txtPOpopup').val(texcode);
        $('#POID_REF').val(txtval);   
        $('#PODT').val(texdesc);   
        $("#PO_popup").hide();   
        event.preventDefault();
      });
  }

  

  $('#txtPOpopup').on('click',function(event){  
            var SLID_REF = $('#CUSTMER_VENDOR_ID').val();
            if(SLID_REF==""){
                $("#FocusId").val('txtcustomer');
                $("#ProceedBtn").focus();
                $("#YesBtn").hide();
                $("#NoBtn").hide();
                $("#OkBtn1").show();
                $("#AlertMessage").text('Please Select Vendor.');
                $("#alert").modal('show');
                $("#OkBtn1").focus();
                return false;
            }
    
                $("#Dataresult_PO").html('');
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $("#Data_seach_PO").show();
                  $.ajax({
                      url:'<?php echo e(route("transaction",[$FormId,"get_po"])); ?>',
                      type:'POST',
                      data:{SLID_REF:SLID_REF},
                      success:function(data) {                                
                        $("#Data_seach_PO").hide();
                        $("#Dataresult_PO").html(data);   
                        showSelectedCheck($("#POID_REF").val(),"po");
                        bindPOEvents();                                        
                      },
                      error:function(data){
                        console.log("Error: Something went wrong.");
                        $("#Dataresult_PO").html('');                        
                      },
                  }); 

                  showSelectedCheck($("#POID_REF").val(),"PO");
                  $("#PO_popup").show();  

                
                  
                  
    });

/*==================================PO POPUP ENDS HERE====================================*/






$(document).ready(function(){
  calculateBankAmount();
  getTotalRowValue();
});

function GetMonthlyBudget(){
  var GLID      = [];
$('#example3').find('.participantRow3').each(function(){  
  if ($(this).find('[id*="GLID_REF"]').val() !="") {
 
    var GLID_REF = $(this).find('[id*="GLID_REF"]').val();
    GLID.push(GLID_REF);

  } 
});  
  var GLID_REF  =   $("#CASH_BANK_ID").val();
  var DATE      =   $("#PAYMENT_DT").val();
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var budget = $.ajax({type: 'POST',
  url:'<?php echo e(route("transaction",[301,"GetMonthlyBudgets"])); ?>',
  async: false,
  dataType: 'json',
  data: {GLID_REF:GLID,DATE:DATE},
  done: function(response) {return response;}}).responseText;
  $("#BUDGET_AMOUNT").val(budget); 
}



function checkBudgetAmount(){
  if($("#check_budget_amount").is(":checked") == true){
    $("#CHECK_BUDGET_AMOUT").val('1')
  }
  else{
    $("#CHECK_BUDGET_AMOUT").val('')
  }
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
        MultiCurrency_Conversion('tot_amt1'); 
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
      MultiCurrency_Conversion('tot_amt1'); 
  });
  


</script>
<input type="hidden" id="CHECK_BUDGET_AMOUT" >


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views/transactions/Accounts/PaymentEntry/trnfrm301view.blade.php ENDPATH**/ ?>