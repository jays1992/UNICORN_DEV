<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[145,'index'])); ?>" class="btn singlebt">Document Number Definition</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSaveSE" disabled="disabled"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo"  disabled="disabled"><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-lock"></i> Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
          <div class="inner-form">

          <div class="row">
                  <div class="col-lg-2 pl"><p>Voucher Type</p></div>
                  <div class="col-lg-2 pl">
                  
                    <label><?php echo e(isset($objVtName->VCODE)?$objVtName->VCODE:''); ?></label>
                   
                </div>

                <div class="col-lg-2 pl"><p>Voucher Type Description</p></div>
                  <div class="col-lg-3 pl">
                    <input type="text" class="form-control" id='vtdes' value="<?php echo e(isset($objVtName->DESCRIPTIONS)?$objVtName->DESCRIPTIONS:''); ?>"  disabled >
                  </div>

                <div class="col-lg-1 pl"><p>Effective Date</p></div>
                  <div class="col-lg-2 pl">
                  <input type="date" name="EFFECTIVE_DT" class="form-control mandatory" id="EFFECTIVE_DT" value="<?php echo e(isset($objResponse->EFFECTIVE_DT) && $objResponse->EFFECTIVE_DT !="" && $objResponse->EFFECTIVE_DT !="1900-01-01" ? $objResponse->EFFECTIVE_DT:''); ?>" tabindex="1" placeholder="dd/mm/yyyy" disabled  />
                   
                    <span class="text-danger" id="ERROR_EFFECTIVE_DT"></span> 
                  </div>


            </div>
                
            <div class="row" >
              <div class="col-lg-2 pl"><p>Document Type</p></div>
              <div class="col-lg-2 pl">
                <div class="col-lg-11 pl">
                <select name="DOC_TYPE" id="DOC_TYPE" class="form-control" required disabled>
                    <option value="">-- Please Select --</option>
                    <option value="master" <?php echo e(strtolower(trim($objResponse->DOC_TYPE))=="master" ? "selected":""); ?>>Master</option>
                    <option value="transactions"  <?php echo e(strtolower(trim($objResponse->DOC_TYPE))=="transactions" ? "selected":""); ?> >Transactions</option>
                </select>  
                </div>
              </div>      
          </div>

                
  <div class="row" >
      <div class="col-lg-2 pl"><p>Manual Series</p></div>
      <div class="col-lg-1 pl">
        <input type="checkbox" name="MANUAL_SR" id="MANUAL_SR" <?php echo e($objResponse->MANUAL_SR == 1 ? "checked" : ""); ?> value='1' onchange="SeriesType('MANUAL_SR');" disabled >
      </div>
      <div class="col-lg-1 pl"><p>OR</p></div>
      <div class="col-lg-2 pl"><p>System generated</p></div>
      <div class="col-lg-1 pl">
        <input type="checkbox" name="SYSTEM_GRSR" id="SYSTEM_GRSR" <?php echo e($objResponse->SYSTEM_GRSR == 1 ? "checked" : ""); ?> value='1' onchange="SeriesType('SYSTEM_GRSR');" disabled >
      </div>

      <div class="col-lg-1 pl"><p>Series Type</p></div>
      <div class="col-lg-1 pl">
        <select name="DOC_SERIES_TYPE" id="DOC_SERIES_TYPE" class="form-control" autocomplete="off" disabled  >
          <option <?php echo e(isset($objResponse->DOC_SERIES_TYPE) && $objResponse->DOC_SERIES_TYPE =='YEAR'?'selected="selected"':''); ?> value="YEAR">YEAR</option>
          <option <?php echo e(isset($objResponse->DOC_SERIES_TYPE) && $objResponse->DOC_SERIES_TYPE =='MONTH'?'selected="selected"':''); ?> value="MONTH">MONTH</option>
        </select>
      </div>

      <div class="col-lg-1 pl"><p>Prefix Type</p></div>
      <div class="col-lg-2 pl">
        <select name="PREFIX_TYPE" id="PREFIX_TYPE" class="form-control" autocomplete="off"  disabled>
          <option value="<?php echo e(isset($objResponse->PREFIX_TYPE)?$objResponse->PREFIX_TYPE:''); ?>"><?php echo e(isset($objResponse->PREFIX_TYPE)?$objResponse->PREFIX_TYPE:''); ?></option>
        </select>
      </div>

    </div>



      <div class="row"><div class="col-lg-2 pl"><p style="text-decoration: underline;font-weight:bold;font-size:13px;">Pattern for Manual Series</p></div></div>
      
      <div class="row"  >
        <div class="col-lg-2 pl"><p>Maximum Alpha Numeric </p></div>
        <div class="col-lg-1 pl col-md-offset-1">
          <input type="text" name="MANUAL_MAXLENGTH" id="MANUAL_MAXLENGTH" value="<?php echo e($objResponse->MANUAL_MAXLENGTH); ?>"  class="form-control" onkeypress="return isNumberKey(event,this)"  maxlength="9" disabled >
        </div>
      
    </div>

  <div class="row"><div class="col-lg-2 pl"><p style="text-decoration: underline;font-weight:bold;font-size:13px;">Pattern for Auto Series</p></div></div>

  <div class="row" >
    <div class="col-lg-2 pl"><p>Prefix Required</p></div>
    <div class="col-lg-1 pl">
      <input type="checkbox" name="PREFIX_RQ" id="PREFIX_RQ" <?php echo e($objResponse->PREFIX_RQ == 1 ? "checked" : ""); ?> value='1' onchange="PrefixRequired();" disabled >
    </div>
    <div class="col-lg-1 pl">
      <input type="text" name="PREFIX" id="PREFIX" class="form-control" value="<?php echo e($objResponse->PREFIX); ?>"  maxlength="4" onkeypress="return AlphaNumaric(event,this)" disabled >
    </div>
  
    <div class="col-lg-2 pl"><p>Is Separator Required after Prefix</p></div>
    <div class="col-lg-1 pl">
      <input type="checkbox" name="PRE_SEP_RQ" id="PRE_SEP_RQ" <?php echo e($objResponse->PRE_SEP_RQ == 1 ? "checked" : ""); ?> value='1' onchange="SeparatorRequiredAfterPrefix();" disabled >
    </div>
    
    <div class="col-lg-1 pl"><p>Slash "/"</p></div>
    <div class="col-lg-1 pl">
      <input type="checkbox" name="PRE_SEP_SLASH" id="PRE_SEP_SLASH" <?php echo e($objResponse->PRE_SEP_SLASH == 1 ? "checked" : ""); ?> value='1' onchange="AfterPrefixType('PRE_SEP_SLASH');" disabled >
    </div>
    
    <div class="col-lg-1 pl"><p>OR</p></div>
    <div class="col-lg-1 pl"><p>Hyphen "-"</p></div>
    <div class="col-lg-1 pl">
      <input type="checkbox" name="PRE_SEP_HYPEN" id="PRE_SEP_HYPEN" <?php echo e($objResponse->PRE_SEP_HYPEN == 1 ? "checked" : ""); ?> value='1' onchange="AfterPrefixType('PRE_SEP_HYPEN');"   disabled >
    </div>
  </div>

<div class="row">
  <div class="col-lg-2 pl"><p>Number Series max digit</p></div>
  
  <div class="col-lg-1 pl col-md-offset-1">
    <input type="text" name="NO_MAX" id="NO_MAX" class="form-control" value="<?php echo e($objResponse->NO_MAX); ?>"  maxlength="8"  onkeypress="return isNumberKey(event,this)" disabled >
  </div>

  <div class="col-lg-2 pl"><p>Number Series Start from</p></div>
  <div class="col-lg-1 pl">
    <input type="text" name="NO_START" id="NO_START" class="form-control" value="<?php echo e($objResponse->NO_START); ?>"  maxlength="8" onkeypress="return isNumberKey(event,this)" disabled >
  </div>
  
  <div class="col-lg-2 pl"><p>New number in each FY</p></div>
  <div class="col-lg-1 pl">
    <input type="checkbox" name="NEWNO_FYEAR" id="NEWNO_FYEAR" <?php echo e($objResponse->NEWNO_FYEAR == 1 ? "checked" : ""); ?> value='1' disabled >
  </div>
</div>
		
      <div class="row">
        <div class="col-lg-2 pl"><p>is Separator Required after number</p></div>
        
        <div class="col-lg-1 pl col-md-offset-1">
          <input type="checkbox" name="NO_SEP_RQ" id="NO_SEP_RQ" <?php echo e($objResponse->NO_SEP_RQ == 1 ? "checked" : ""); ?> value='1' onchange="SeparatorRequiredAfterNumber();" disabled >
        </div>
      
          
        <div class="col-lg-1 pl"><p>Slash "/"</p></div>
        <div class="col-lg-1 pl">
          <input type="checkbox" name="NO_SEP_SLASH" id="NO_SEP_SLASH" <?php echo e($objResponse->NO_SEP_SLASH == 1 ? "checked" : ""); ?> value='1' onchange="AfterNumberType('NO_SEP_SLASH');"  disabled >
        </div>
        
        <div class="col-lg-1 pl"><p>OR</p></div>
        <div class="col-lg-1 pl"><p>Hyphen "-"</p></div>
        <div class="col-lg-1 pl">
          <input type="checkbox" name="NO_SEP_HYPEN" id="NO_SEP_HYPEN" <?php echo e($objResponse->NO_SEP_HYPEN == 1 ? "checked" : ""); ?> value='1' onchange="AfterNumberType('NO_SEP_HYPEN');"  disabled >
        </div>
      </div>
		
		<div class="row">
			<div class="col-lg-2 pl"><p>Suffix Required</p></div>
			<div class="col-lg-1 pl">
				<input type="checkbox" name="SUFFIX_RQ" id="SUFFIX_RQ" <?php echo e($objResponse->SUFFIX_RQ == 1 ? "checked" : ""); ?> value='1' onchange="SuffixRequired();" disabled >
			</div>
			<div class="col-lg-1 pl">
				<input type="text" name="SUFFIX" id="SUFFIX" value="<?php echo e($objResponse->SUFFIX); ?>" class="form-control"  maxlength="6" disabled >
			</div>
		
			
		</div>




                
              <div class="row">
                <div class="col-lg-2 pl"><p>De-Activated</p></div>
                <div class="col-lg-1 pl">
                <label> <?php echo e($objResponse->DEACTIVATED == 1 ? "Yes" : ""); ?> </label>
                
                </div>
                
                <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
                <div class="col-lg-2 pl">
                  <label> <?php echo e((is_null($objResponse->DODEACTIVATED) || $objResponse->DODEACTIVATED=='1900-01-01' )?'':
                  \Carbon\Carbon::parse($objResponse->DODEACTIVATED)->format('d/m/Y')); ?> </label>
                </div>
          </div>
          

          </div>

    </div><!--purchase-order-view-->

    <script>
     $('#btnAdd').on('click', function() {
      var viewURL = '<?php echo e(route("master",[145,"add"])); ?>';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views/masters/Common/DocumentNumberDefinition/mstfrm145view.blade.php ENDPATH**/ ?>