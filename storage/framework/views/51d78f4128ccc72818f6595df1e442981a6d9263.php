<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[129,'index'])); ?>" class="btn singlebt">Sub Ledger Master</a>
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
                <div class="col-lg-2 pl"><p>GL Code</p></div>
                <div class="col-lg-4 pl">
                
                    <label><?php echo e(isset($objGlName->GLCODE)?$objGlName->GLCODE.'-'.$objGlName->GLNAME:''); ?></label>
                 
                </div>
              </div>

                <div class="row">
                  <div class="col-lg-2 pl"><p>SL Code</p></div>
                  <div class="col-lg-1 pl">
                    <label> <?php echo e($objResponse->SGLCODE); ?> </label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-2 pl"><p>SL Name</p></div>
                  <div class="col-lg-4 pl">
                    <label> <?php echo e($objResponse->SLNAME); ?> </label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-2 pl"><p>Alias</p></div>
                  <div class="col-lg-4 pl">
                    <label> <?php echo e($objResponse->SALIAS); ?> </label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-2 pl"><p>Checks Flag</p></div>
                </div>

                <div class="row">
                  <div class="col-lg-2 pl"><p>Cost Centre Applicable</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                    <label>             
                      <?php if($objResponse->CC == "1"): ?>
                          Yes
                      <?php elseif($objResponse->CC == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                  </div> 
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
      var viewURL = '<?php echo e(route("master",[129,"add"])); ?>';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Accounts\SubLedgerMaster\mstfrm129view.blade.php ENDPATH**/ ?>