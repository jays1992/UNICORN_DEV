<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[353,'index'])); ?>" class="btn singlebt">Attribute Master</a>
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
          <div class=" table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:300px;" >
            <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
              <thead id="thead1"  style="position: sticky;top: 0">
                  <tr>
                    <th>
                      Particular 
                        <input class="form-control" type="hidden" name="Row_Count" id ="Row_Count"> 
                        <input type="hidden" id="focusid" >
                    </th>
                    <th width="5%">Earning / Deduction</th>
                    <th width="5%">Earning / Deduction Head Code</th>
                    <th width="5%">Earning / Deduction Head Description</th>
                    <th width="5%">Action</th>
                    </tr>
                </thead>
                <tbody>                  
                <?php if(!empty($objDataResponse)): ?>
                <?php $n=1; ?>
                <?php $__currentLoopData = $objDataResponse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr  class="participantRow">
                  <td><input  class="form-control w-100" type="text" name=<?php echo e("PARTICULAR_".$key); ?> id =<?php echo e("PARTICULAR_".$key); ?> value="<?php echo e($row->PARTICULAR); ?>"  maxlength="100" autocomplete="off" style="text-transform:uppercase;width:100%;" disabled></td>
                  
                  <td>
                    <select name="EARNING_DEDUCTION_0" id="EARNING_DEDUCTION_0" class="form-control w-100" style="width: 200px;" disabled>
                    <option value="" selected="">Select</option>
                    <option <?php echo e(isset($row->EARNING_DEDUCTION) && $row->EARNING_DEDUCTION == 'Earning'?'selected="selected"':''); ?> value="Earning">Earning</option>
                    <option <?php echo e(isset($row->EARNING_DEDUCTION) && $row->EARNING_DEDUCTION == 'Deduction'?'selected="selected"':''); ?> value="Deduction">Deduction</option>
                    </select>
                  </td>

                  <td><select class="form-control" name="EARNING_DEDUCTION_HEAD_0" id="EARNING_DEDUCTION_HEAD_0" style="width: 200px;" disabled>
                    <option value="" selected >Select</option>
                    <?php $__currentLoopData = $objHeadCodeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(isset($row->EARNING_DEDUCTION_HEAD) && $row->EARNING_DEDUCTION_HEAD == $val-> DEDUCTION_HEADID ?'selected="selected"':''); ?> value="<?php echo e($val-> DEDUCTION_HEADID); ?>"><?php echo e($val->DEDUCTION_HEADCODE); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </td>
                   <td><input  class="form-control w-100" type="text" name="EARNING_DEDUCTION_DES_0" id ="EARNING_DEDUCTION_DES_0"  maxlength="100" autocomplete="off" style="text-transform:uppercase;width:100%;" disabled ></td>
                  <td align="center" >
                      <button disabled class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                      <button disabled class="btn remove" title="Delete" data-toggle="tooltip" disabled><i class="fa fa-trash" ></i></button>
                  </td>
              </tr>
                  <?php $n++; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                  <?php endif; ?>     
                </tbody>
              </table>
            </div>
          </div>
        </div>

          
          

          </div>

    </div><!--purchase-order-view-->

    <script>
     $('#btnAdd').on('click', function() {
      var viewURL = '<?php echo e(route("master",[353,"add"])); ?>';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Payroll\Definition\mstfrm353view.blade.php ENDPATH**/ ?>