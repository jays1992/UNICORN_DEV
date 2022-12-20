<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[165,'index'])); ?>" class="btn singlebt">Sales Account Set</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <a href="#" id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</a>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button id="btnSaveCountry"   class="btn topnavbt" disabled="disabled" tabindex="7"><i class="fa fa-save"></i> Save</button>
                        <a class="btn topnavbt" id="btnView"  disabled="disabled"><i class="fa fa-eye"></i> View</a>
                        <a href="#" class="btn topnavbt"  disabled="disabled"><i class="fa fa-print"></i> Print</a>
                        <a href="#" class="btn topnavbt" disabled="disabled" ><i class="fa fa-undo"></i> Undo</a>
                        <a href="#" class="btn topnavbt" disabled="disabled"><i class="fa fa-times"></i> Cancel</a>
                        <a href="#" class="btn topnavbt"  disabled="disabled"><i class="fa fa-lock"></i> Approved</a>
                        <a href="#" class="btn topnavbt"  disabled="disabled"><i class="fa fa-link" ></i> Attachment</a>
                        <a href="<?php echo e(route('home')); ?>" class="btn topnavbt"><i class="fa fa-power-off"></i> Exit</a>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	 
   
    <div class="container-fluid purchase-order-view filter">     
          <div class="inner-form">
          
              
   
          <div class="row">
          <div class="col-lg-2 pl"><p>Account set code</p></div>
                    <div class="col-lg-2 pl">
                      <div class="col-lg-7 pl">
                      <label> <?php echo e($objResponse->AC_SET_CODE); ?> </label>
                      <input type="hidden" name="SL_AC_SETID" id="SL_AC_SETID" value="<?php echo e($objResponse->SL_AC_SETID); ?>" />
                    <input type="hidden" name="AC_SET_CODE" id="AC_SET_CODE" value="<?php echo e($objResponse->AC_SET_CODE); ?>" autocomplete="off"  maxlength="20"   />
                    
                  
                          <span class="text-danger" id="ERROR_AC_SET_CODE"></span> 
                      </div>
                    </div>

                    <div class="col-lg-2 pl"><p>Account set code Description</p></div>
                    <div class="col-lg-3 pl">
                    <label> <?php echo e($objResponse->AC_SET_DESC); ?> </label>
                      
                    </div>
                </div>
                
              <div class="row">
                  <div class="col-lg-2 pl"><p>Sales Account Code</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-7 pl">
                    <label> <?php echo e($objSalesAccoutName != '' ? $objSalesAccoutName->GLCODE : ''); ?> </label>

                    </div>
                  </div>  

                  <div class="col-lg-2 pl"><p>Sales Account Description</p></div>
                  <div class="col-lg-3 pl">
                  <label> <?php echo e($objSalesAccoutName != '' ? $objSalesAccoutName->GLNAME : ''); ?> </label>
                      
                  </div>
              </div>

              <div class="row">
                  <div class="col-lg-2 pl"><p>Sales Return Code</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-7 pl">
                    <label> <?php echo e($objSalesReturnName != '' ? $objSalesReturnName->GLCODE : ''); ?></label>
                 
                    </div>
                  </div>

                  <div class="col-lg-2 pl"><p>Sales Return Description</p></div>
                  <div class="col-lg-3 pl">
                  <label>  <?php echo e($objSalesReturnName != '' ? $objSalesReturnName->GLNAME : ''); ?> </label>
                  </div>
              </div>

              <div class="row">
                    <div class="col-lg-2 pl"><p>Shortage Code</p></div>
                    <div class="col-lg-2 pl">
                      <div class="col-lg-7 pl">
                      <label> <?php echo e($objShortageName != '' ? $objShortageName->GLCODE : ''); ?> </label>
             
                      </div>
                    </div>

                    <div class="col-lg-2 pl"><p>Shortage Description</p></div>
                    <div class="col-lg-3 pl">
                    <label> <?php echo e($objShortageName != '' ? $objShortageName->GLNAME : ''); ?></label>  
                    </div>
                </div>

                <div class="row">
                  <div class="col-lg-2 pl"><p>Cost of Good Sold Code</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-7 pl">
                    <label> <?php echo e($objCostOfGoodSoldName != '' ? $objCostOfGoodSoldName->GLCODE : ''); ?> </label>  

                    </div>
                  </div>

                  <div class="col-lg-2 pl"><p> Cost of Good Sold Description</p></div>
                  <div class="col-lg-3 pl">
                  <label> <?php echo e($objCostOfGoodSoldName != '' ? $objCostOfGoodSoldName->GLNAME : ''); ?></label>  
                     
                  </div>
              </div>
              
              <div class="row">
                  <div class="col-lg-2 pl"><p>Export Sale Account Code</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-7 pl">
                    <label> <?php echo e($objExportSalesAcctName != '' ? $objExportSalesAcctName->GLCODE : ''); ?> </label>  
                    </div>
                  </div>

                  <div class="col-lg-2 pl"><p>Export Sale Account Description</p></div>
                  <div class="col-lg-3 pl">
                  <label> <?php echo e($objExportSalesAcctName != '' ? $objExportSalesAcctName->GLNAME : ''); ?></label> 
                  </div>
              </div>
			  <div class="row">
                  <div class="col-lg-2 pl"><p>Cost of Good Sold Transfer Code</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-7 pl">
                    <label> <?php echo e($objCostOfGoodSoldExportName != '' ? $objCostOfGoodSoldExportName->GLCODE : ''); ?> </label>  

                    </div>
                  </div>

                  <div class="col-lg-2 pl"><p> Cost of Good Sold Transfer Description</p></div>
                  <div class="col-lg-3 pl">
                  <label> <?php echo e($objCostOfGoodSoldExportName != '' ? $objCostOfGoodSoldExportName->GLNAME : ''); ?></label>  
                     
                  </div>
              </div>
			  <div class="row">
                  <div class="col-lg-2 pl"><p>Sales Account Code(Inter State)</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-7 pl">
                    <label> <?php echo e($objSalesISAccoutName != '' ? $objSalesISAccoutName->GLCODE : ''); ?> </label>

                    </div>
                  </div>  

                  <div class="col-lg-2 pl"><p>Sales Account Description(Inter State)</p></div>
                  <div class="col-lg-3 pl">
                  <label> <?php echo e($objSalesISAccoutName != '' ? $objSalesISAccoutName->GLNAME : ''); ?> </label>
                      
                  </div>
              </div>
			  
             
              

              <div class="row">
                <div class="col-lg-2 pl"><p>De-Activated</p></div>
                <div class="col-lg-1 pl pr">
                <input type="checkbox"   name="DEACTIVATED"  id="deactive-checkbox_0" <?php echo e($objResponse->DEACTIVATED == 1 ? "checked" : ""); ?>

                 value='<?php echo e($objResponse->DEACTIVATED == 1 ? 1 : 0); ?>' tabindex="2"  >
                </div>
                
                <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
                <div class="col-lg-2 pl">
                  <input type="date" name="DODEACTIVATED" class="form-control" id="DODEACTIVATED" <?php echo e($objResponse->DEACTIVATED == 1 ? "" : "disabled"); ?> value="<?php echo e(isset($objResponse->DODEACTIVATED) && $objResponse->DODEACTIVATED !="" && $objResponse->DODEACTIVATED !="1900-01-01" ? $objResponse->DODEACTIVATED:''); ?>" tabindex="3" placeholder="dd/mm/yyyy"  />
                </div>
             </div>


     




    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Accounts\SalesAccountSet\mstfrm165view.blade.php ENDPATH**/ ?>