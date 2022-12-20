<?php $__env->startSection('content'); ?>
    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                  <a href="<?php echo e(route('master',[161,'index'])); ?>" class="btn singlebt">Machine wise - Mould Info</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button href="#" id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button id="btnSave"  disabled="disabled" class="btn topnavbt" tabindex="4"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView"  disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt"  id="btnUndo" disabled="disabled"><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled" ><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" disabled="disabled" ><i class="fa fa-lock"></i> Approved</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-link" ></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit"><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
         <form id="frm_mst_edit" method="POST"  > 
          <?php echo csrf_field(); ?>
          <?php echo e(isset($objResponse->MACHINEID) ? method_field('PUT') : ''); ?>

            <div class="inner-form">
              <div class="row">
                <div class="col-lg-2 pl"><p>Machine No </p></div>
                <div class="col-lg-2 pl">
                    <input type="text" name="MACHINE_popup" id="txtmachine_popup" value="<?php echo e(isset($ObjMachine[0]->MACHINE_NO) ? $ObjMachine[0]->MACHINE_NO :''); ?>" class="form-control mandatory clsclear"  autocomplete="off" readonly disabled/>
                </div>              
                <div class="col-lg-2 pl"><p>Machine Description</p></div>
                <div class="col-lg-2 pl">
                    <input type="text" name="MACHINENAME" id="MACHINENAME" value="<?php echo e(isset($ObjMachine[0]->MACHINE_DESC) ? $ObjMachine[0]->MACHINE_DESC :''); ?>"  class="form-control clsclear"   autocomplete="off" readonly/>
                </div>
              </div>    

              <div class="row">
                  <div class="col-lg-2 pl"><p>Mould Code</p></div>
                  <div class="col-lg-2 pl">
                    <div class="col-lg-7 pl">
                      <label> <?php echo e($objResponse->MOULD_CODE); ?> </label>
                    </div>
                  </div>

                  <div class="col-lg-2 pl"><p>Mould Description</p></div>
                  <div class="col-lg-3 pl">
                    <input type="text" name="MOULD_DESC" id="MOULD_DESC" value="<?php echo e($objResponse->MOULD_DESC); ?>" class="form-control mandatory"  maxlength="200" readonly/>
                  </div>
            </div>


            <div class="row">
              <div class="col-lg-2 pl"><p>Produce Item Code</p></div>
              <div class="col-lg-2 pl">                 
                    <input type="text" name="txtPRODITEMPOP_popup" id="txtPRODITEMPOP_popup"  value="<?php echo e(isset($ObjProdItem[0]->ICODE) ? $ObjProdItem[0]->ICODE :''); ?>" class="form-control clsclear"  autocomplete="off"  readonly disabled/>
              </div>
              <div class="col-lg-2 pl"><p>Description</p></div>
              <div class="col-lg-3 pl">
                  <input type="text" name="ITEM_DESC" id="ITEM_DESC" class="form-control clsclear" value="<?php echo e(isset($ObjProdItem[0]->NAME) ? $ObjProdItem[0]->NAME :''); ?>"  autocomplete="off" readonly />
              </div>
          </div>


          <div class="row">
            <div class="col-lg-2 pl"><p>Expected Produce Qty</p></div>
            <div class="col-lg-2 pl">
                <input type="text" name="EXP_PRODUCE_QTY" id="EXP_PRODUCE_QTY" value="<?php echo e($objResponse->EXP_PRODUCE_QTY); ?>" class="form-control three-digits clsclear" maxlength="13"  autocomplete="off" readonly/>
            </div>

            <div class="col-lg-2 pl"><p>UOM</p></div>
            <div class="col-lg-2 pl">
                <input type="text" name="txtMainUOM_popup_0" id="txtMainUOM_popup_0"  value="<?php echo e(isset($ObjEXPUOM[0]->UOMCODE) ? $ObjEXPUOM[0]->UOMCODE :''); ?>-<?php echo e(isset($ObjEXPUOM[0]->DESCRIPTIONS) ? $ObjEXPUOM[0]->DESCRIPTIONS :''); ?>"  class="form-control mandatory clsclear"  autocomplete="off" readonly disabled/>
            </div>              
           
          </div>    

          <div class="row">
            <div class="col-lg-2 pl"><p>How many Qty produce in one stroke</p></div>
            <div class="col-lg-2 pl">
                <input type="text" name="PRODUCE_QTY" id="PRODUCE_QTY" value="<?php echo e($objResponse->PRODUCE_QTY); ?>" class="form-control three-digits clsclear" maxlength="13"  autocomplete="off" readonly />
            </div>

            <div class="col-lg-2 pl"><p>UOM</p></div>
            <div class="col-lg-2 pl">
                <input type="text" name="txtMainUOM_popup_1" id="txtMainUOM_popup_1"  value="<?php echo e(isset($ObjPRODUOM[0]->UOMCODE) ? $ObjPRODUOM[0]->UOMCODE :''); ?>-<?php echo e(isset($ObjPRODUOM[0]->DESCRIPTIONS) ? $ObjPRODUOM[0]->DESCRIPTIONS :''); ?>"  class="form-control mandatory clsclear"  autocomplete="off" readonly disabled/>
            </div>      
          </div>

              
            
            <div class="row">
              <div class="col-lg-2 pl"><p>De-Activated</p></div>
              <div class="col-lg-2 pl pr">
              <input type="checkbox"   name="DEACTIVATED"  id="deactive-checkbox_0" <?php echo e($objResponse->DEACTIVATED == 1 ? "checked" : ""); ?>

               value='<?php echo e($objResponse->DEACTIVATED == 1 ? 1 : 0); ?>' tabindex="2"  disabled>
              </div>
              
              <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
              <div class="col-lg-2 pl">
                <input type="date" name="DODEACTIVATED" class="form-control" id="DODEACTIVATED" <?php echo e($objResponse->DEACTIVATED == 1 ? "" : "disabled"); ?> value="<?php echo e(isset($objResponse->DODEACTIVATED) && $objResponse->DODEACTIVATED !="" && $objResponse->DODEACTIVATED !="1900-01-01" ? $objResponse->DODEACTIVATED:''); ?>" tabindex="3" placeholder="dd/mm/yyyy"  disabled/>
              </div>
            </div>
           

            <br/>
             
          </div>
        </form>
    </div><!--purchase-order-view-->


<?php $__env->stopSection(); ?>
<?php $__env->startSection('alert'); ?>

<?php $__env->stopSection(); ?>
<!-- btnSave -->

<?php $__env->startPush('bottom-scripts'); ?>
<script>

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Production\MachineWiseMouldInfo\mstfrm161view.blade.php ENDPATH**/ ?>