<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[195,'index'])); ?>" class="btn singlebt">Bonus Master</a>
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
                        <button class="btn topnavbt" id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">    
          <div class="inner-form">
          
              
          <div class="row">
          <div class="col-lg-2 pl"><p>Bonus Code</p></div>
                  <div class="col-lg-2 pl">
                  <label> <?php echo e($objResponse->BONUS_CODE); ?> </label>
                    <input type="hidden" name="BONUSID" id="BONUSID" value="<?php echo e($objResponse->BONUSID); ?>" />
                    <input type="hidden" name="BONUS_CODE" id="BONUS_CODE" value="<?php echo e($objResponse->BONUS_CODE); ?>" autocomplete="off"  maxlength="20"   />
               
                  </div>
                  <div class="col-lg-2 pl"><p>Description</p></div>
                  <div class="col-lg-5 pl">
                    <input type="text" name="BONUS_DESC" id="BONUS_DESC" disabled class="form-control mandatory" value="<?php echo e($objResponse->BONUS_DESC); ?>" maxlength="200" tabindex="2"  />
                    <span class="text-danger" id="ERROR_BONUS_DESC"></span> 
                  </div>

                </div>


                <div class="row">
                  <div class="col-lg-2 pl"><p>Bonus Type</p></div>
                  <input type="radio"   name="BonusType"  id="bonus_type1" disabled value="1" style=" margin-right: 10;" <?php echo e($objResponse->BONUS_TYPE == 1 ? "checked" : ""); ?>  >
                  <div class="col-lg-1 pl"><p>Bonus Rate (%)</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-11 pl">
                        <input type="text" name="BONUS_RATE" id="BONUS_RATE" disabled  value='<?php echo e($objResponse->BONUS_RATE == "null" ? "" : $objResponse->BONUS_RATE); ?>' class="form-control mandatory" autocomplete="off" maxlength="20" tabindex="1" />
                        <span class="text-danger" id="ERROR_BONUS_RATE"></span> 
                    </div>
                  </div>
                  <div class="col-lg-2 pl"><p>Maximum Basic Salary in a month</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-11 pl">
                        <input type="text" name="BASIC_SALARY" id="BASIC_SALARY"  disabled  value='<?php echo e($objResponse->MAX_SALARY == "null" ? "" : $objResponse->MAX_SALARY); ?>' class="form-control mandatory" autocomplete="off" maxlength="20" tabindex="1"  />
                        <span class="text-danger" id="ERROR_BASIC_SALARY"></span> 
                    </div>
                  </div>
                  <div class="col-lg-1 pl"><p>Max Bonus</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                        <input type="text" name="MAX_BONUS" id="MAX_BONUS" disabled  value='<?php echo e($objResponse->MAX_BONUS == "null" ? "" : $objResponse->MAX_BONUS); ?>' class="form-control mandatory" autocomplete="off" maxlength="20" tabindex="1"  />
                        <span class="text-danger" id="ERROR_MAX_BONUS"></span> 
                    </div>
                    
                  </div>
                  
                </div>

                <div class="row" style=" margin-left: 221px;">      
                  <input type="radio"   name="BonusType"  id="bonus_type2" disabled value="2" style=" margin-right: 10;" <?php echo e($objResponse->BONUS_TYPE == 2 ? "checked" : ""); ?>  >
                  <div class="col-lg-1 pl"><p>Flat Bonus</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                    <input type="text" name="FLAT_BONUS" id="FLAT_BONUS" disabled value='<?php echo e($objResponse->BONUS_FLAT == "null" ? "" : $objResponse->BONUS_FLAT); ?>' class="form-control mandatory" autocomplete="off" maxlength="20" tabindex="1" style="width: 93px;
margin-left: 21px;" />
                        <span class="text-danger" id="ERROR_OT_RATE"></span> 
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
      var viewURL = '<?php echo e(route("master",[195,"add"])); ?>';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Payroll\BonusMaster\mstfrm195view.blade.php ENDPATH**/ ?>