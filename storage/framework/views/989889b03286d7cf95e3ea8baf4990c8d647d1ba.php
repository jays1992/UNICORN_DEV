
<?php $__env->startSection('content'); ?>
    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                  <a href="<?php echo e(route('master',[238,'index'])); ?>" class="btn singlebt">Machine Wise Item Info</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                    <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                    <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                    <button class="btn topnavbt" id="btnSave" disabled="disabled"><i class="fa fa-save"></i> Save</button>
                    <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                    <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                    <button class="btn topnavbt" id="btnUndo" disabled="disabled" ><i class="fa fa-undo"></i> Undo</button>
                    <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                    <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-lock"></i> Approved</button>
                    <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                    <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div><!--row-->
    </div>

<form id="frm_mst" onsubmit="return validateForm()"  method="POST" class="needs-validation"  >
    <?php echo csrf_field(); ?>
    <?php echo e(isset($objMWI->MWITEMID) ? method_field('PUT') : ''); ?>

    <div class="container-fluid filter">

<div class="inner-form">

  <div class="row">
    <div class="col-lg-2 pl"><p>Machine No </p></div>
    <div class="col-lg-2 pl">
        <input type="text" name="MACHINE_popup" id="txtmachine_popup" class="form-control mandatory" value="<?php echo e($objMachineNo->MACHINE_NO); ?>"  autocomplete="off" readonly disabled/>
        <input type="hidden" name="MACHINEID_REF" id="MACHINEID_REF" value="<?php echo e($objMachineNo->MACHINEID); ?>" class="form-control" autocomplete="off" />
    </div>              
    <div class="col-lg-2 pl"><p>Machine Description</p></div>
    <div class="col-lg-2 pl">
        <input type="text" name="MACHINENAME" id="MACHINENAME" class="form-control"  value="<?php echo e($objMachineNo->MACHINE_DESC); ?>"  autocomplete="off" readonly disabled/>
    </div>
  </div>    

   
   <div class="row">
    <div class="col-lg-2 pl"><p>De-Activated</p></div>
    <div class="col-lg-2 pl pr">
    <input type="checkbox"   name="HDR_DEACTIVATED"  id="deactive-checkbox_0" <?php echo e($objMWI->DEACTIVATED == 1 ? "checked" : ""); ?>

    value='<?php echo e($objMWI->DEACTIVATED == 1 ? 1 : 0); ?>'  disabled>
    </div>
    
    <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
    <div class="col-lg-2 pl">
      <input type="date" name="HDR_DODEACTIVATED" class="form-control" id="HDR_DODEACTIVATED" <?php echo e($objMWI->DEACTIVATED == 1 ? "" : "disabled"); ?> value="<?php echo e(isset($objMWI->DODEACTIVATED) && $objMWI->DODEACTIVATED !="" && $objMWI->DODEACTIVATED !="1900-01-01" ? $objMWI->DODEACTIVATED:''); ?>" placeholder="dd/mm/yyyy"  disabled/>
    </div>
  </div>



</div>

<div class="container-fluid">

  <div class="row">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#Material">Material </a></li> 
    </ul>

    
    <div class="tab-content">
          <div id="Material" class="tab-pane fade in active">
              <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                  <table id="exp2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top:">
                      <tr >
                          <th width="10%">Item Code<input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1"></th>
                          <th hidden>Item_ID</th>
                          <th  width="15%">Item Name</th>
                          <th>Main UOM</th>
                          <th  hidden>MAIN_UOMID_REF</th>
                          <th style="width:100px !important;">Produce Qty</th>
                          <th style="width:150px !important;">Cycle Time</th>                          
                          <th >Number of <br>Operators Required</th>                          
                          <th style="width:250px !important;">Remarks</th>                          
                          <th  style="width:100px !important;">Action</th>
                      </tr>
              </thead>
<tbody>
<?php if(!empty($objMWIMAT)): ?>
<?php $__currentLoopData = $objMWIMAT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
<tr  class="participantRow">
 

  <td><input type="text" name="popupITEMID_<?php echo e($key); ?>" id="popupITEMID_<?php echo e($key); ?>" value="<?php echo e($row->ICODE); ?>" disabled class="form-control"  autocomplete="off" style="width:150px;"  readonly/></td>
  <td  hidden><input type="text" name="ITEMID_REF_<?php echo e($key); ?>" id="ITEMID_REF_<?php echo e($key); ?>"  value="<?php echo e($row->ITEMID_REF); ?>" disabled class="form-control" autocomplete="off" /></td>

  
  <td><input type="text" name="ItemName_<?php echo e($key); ?>" id="ItemName_<?php echo e($key); ?>" value="<?php echo e($row->NAME); ?>" class="form-control"  autocomplete="off"  readonly style="width: 100%;"/></td>
  <td><input type="text" name="popupMUOM_<?php echo e($key); ?>" id="popupMUOM_<?php echo e($key); ?>"  value="<?php echo e($row->UOMCODE); ?> - <?php echo e($row->DESCRIPTIONS); ?> "  class="form-control"  autocomplete="off"  readonly/></td>
  <td  hidden><input type="text" name="MAIN_UOMID_REF_<?php echo e($key); ?>" id="MAIN_UOMID_REF_<?php echo e($key); ?>" value="<?php echo e($row->UOMID_REF); ?>" class="form-control"  autocomplete="off" /></td>
  
  <td><input type="text" name="PRODUCE_QTY_<?php echo e($key); ?>"      id="PRODUCE_QTY_<?php echo e($key); ?>"      value="<?php echo e($row->PRODUCE_QTY); ?>"    disabled  class="form-control three-digits" style="width:130px;" maxlength="13" autocomplete="off"  /></td>
  <td><input type="text" name="CYCLE_TIME_<?php echo e($key); ?>"       id="CYCLE_TIME_<?php echo e($key); ?>"       value="<?php echo e($row->CYCLE_TIME); ?>"   disabled   class="form-control"  maxlength="30" autocomplete="off"  /> </td>
  <td><input type="text" name="REQ_OPERATORS_NO_<?php echo e($key); ?>" id="REQ_OPERATORS_NO_<?php echo e($key); ?>" value="<?php echo e($row->REQ_OPERATORS_NO); ?>" disabled  class="form-control" style="width:130px;" maxlength="4" autocomplete="off"  /> </td>
  <td><input type="text" name="REMARKS_<?php echo e($key); ?>"          id="REMARKS_<?php echo e($key); ?>"          value="<?php echo e($row->REMARKS); ?>" disabled class="form-control" style="width:100%;" maxlength="200" autocomplete="off"  /> </td>

  <td align="center" ><button class="btn add material" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button>
  <button class="btn remove dmaterial"   title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>

</tr>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
 <?php endif; ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('alert'); ?>


<?php $__env->stopSection(); ?>


<?php $__env->startPush('bottom-css'); ?>
<style>


</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('bottom-scripts'); ?>
<script>

$('#btnExit').on('click', function() {
  var viewURL = '<?php echo e(route('home')); ?>';
              window.location.href=viewURL;
});

</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Production\MachineWiseItemInfo\mstfrm238view.blade.php ENDPATH**/ ?>