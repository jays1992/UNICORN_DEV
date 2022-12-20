<?php $__env->startSection('content'); ?>

<div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[4,'index'])); ?>" class="btn singlebt">Country Master</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <a href="<?php echo e(route('master',[4,'add'])); ?>" id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</a>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <a href="#" class="btn topnavbt" disabled="disabled"><i class="fa fa-save"></i> Save</a>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button href="#" class="btn topnavbt" id="btnPrint" ><i class="fa fa-print"></i> Print</button>
                        <a href="#" class="btn topnavbt" disabled="disabled"><i class="fa fa-undo"></i> Undo</a>
                        <a href="#" class="btn topnavbt" disabled="disabled"><i class="fa fa-times"></i> Cancel</a>
                        <a href="#" class="btn topnavbt" disabled="disabled"><i class="fa fa-lock"></i> Approved</a>
                        <a href="#" class="btn topnavbt" disabled="disabled"><i class="fa fa-link"></i> Attachment</a>
                        <a href="#" class="btn topnavbt" ><i class="fa fa-power-off"></i> Exit</a>
                </div>

            </div><!--row-->
    </div><!--topnav-->	
<div class="container-fluid purchase-order-view">
        <div class="multiple ">
              <table id="countrymst" class="display nowrap table table-striped table-bordered" width="100%">
            <thead id="thead1">
            <tr>
                <th>Country Code</th>
                <th>Country Name</th>
                <th>ISD Code</th>
                <th>Language</th>
                <th>Continental</th>
                <th>Capital</th>
            </tr>
            </thead>
            <?php $__empty_1 = true; $__currentLoopData = $objCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country_row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($country_row["CTRYCODE"]); ?></td>
                    <td><?php echo e($country_row->NAME); ?></td>
                    <td><?php echo e($country_row->ISDCODE); ?></td>
                    <td><?php echo e($country_row->LANG); ?></td>
                    <td><?php echo e($country_row->CONTINENTAL); ?></td>
                    <td><?php echo e($country_row->CAPITAL); ?></td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6">No record found.</td>
                </tr>
            <?php endif; ?>
        </table>
        </div>
    </div><!--purchase-order-view-->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('bottom-scripts'); ?>
<script>
   $(document).ready(function(){

     function doprint(){
      window.print();

     }

    $("#btnPrint").click(function(){
      doprint();
    }); //btnPrint button

     doprint();  //on document load

   }); 
   
   $('#btnAdd').on('click', function() {
          var viewURL = '<?php echo e(route("master",[3,"add"])); ?>';
          window.location.href=viewURL;
      });

      $('#btnExit').on('click', function() {
        var viewURL = '<?php echo e(route('home')); ?>';
        window.location.href=viewURL;
      });

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Common\State\mstfrm3print.blade.php ENDPATH**/ ?>