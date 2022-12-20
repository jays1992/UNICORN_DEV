<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[4,'index'])); ?>" class="btn singlebt">Country Master</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button id="btnSaveCountry"   class="btn topnavbt" disabled="disabled" tabindex="7"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView"  disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" disabled="disabled" ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-lock"></i> Approved</button>
                        <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-link" ></i> Attachment</button>
                        <a href="<?php echo e(route('home')); ?>" class="btn topnavbt"><i class="fa fa-power-off"></i> Exit</a>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
          <div class="inner-form">
          
              
                <div class="row">
                  <div class="col-lg-1 pl"><p>Country Code</p></div>
                  <div class="col-lg-1 pl">
                    <label> <?php echo e($objCountry->CTRYCODE); ?> </label>
                  </div>
                
                  <div class="col-lg-1 pl col-md-offset-3"><p>Country Name</p></div>
                  <div class="col-lg-4 pl">
                    <label> <?php echo e($objCountry->NAME); ?> </label>
                  </div>
                </div>
          
          
              <div class="row">
                <div class="col-lg-1 pl"><p>ISD Code</p></div>
                <div class="col-lg-2 pl">
                  <div class="col-lg-8 pl">
                    <label> <?php echo e($objCountry->ISDCODE); ?> </label>
                  </div>
                </div>
                
                <div class="col-lg-1 pl col-md-offset-2"><p>Language</p></div>
                <div class="col-lg-2 pl ">
                  <label> <?php echo e($objCountry->LANG); ?> </label>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-1 pl"><p>Continental</p></div>
                <div class="col-lg-3 pl">
                  <label> <?php echo e($objCountry->CONTINENTAL); ?> </label>
                </div>
                
                <div class="col-lg-1 pl col-md-offset-1"><p>Capital</p></div>
                <div class="col-lg-3 pl">
                  <label> <?php echo e($objCountry->CAPITAL); ?> </label>
                </div>
              </div>

          </div>

    </div><!--purchase-order-view-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\country\mstfrm4view.blade.php ENDPATH**/ ?>