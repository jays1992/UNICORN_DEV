<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[150,'index'])); ?>" class="btn singlebt">User Master</a>
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
                  <div class="col-lg-2 pl"><p>User Code</p></div>
                  <div class="col-lg-1 pl">
                    <label> <?php echo e($objResponse->UCODE); ?> </label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-2 pl"><p>User Description</p></div>
                  <div class="col-lg-4 pl">
                    <label> <?php echo e($objResponse->DESCRIPTIONS); ?> </label>
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

          <div class="row">
                  <div class="col-lg-10 pl">
                    <div class=" table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:300px;" >
                      <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                        <thead id="thead1"  style="position: sticky;top: 0">
                        <tr>
                          <th>
                              Employee Code
                              <input class="form-control" type="hidden" name="Row_Count" id ="Row_Count"> 
                              <input type="hidden" id="focusid" >
                              <input type="hidden" id="errorid" >
                          </th>
                          <th>Employee Name</th>
                          <th>Start Period</th>
                          <th>End Period</th>
                          <th>De-Activated</th>
                          <th>Date of De-Activated</th>
                          <th>Supper User</th>
                          <!--<th width="5%">Action</th>-->
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($objDataResponse)): ?>
                        <?php $n=1; ?>
                        <?php $__currentLoopData = $objDataResponse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr  class="participantRow">
                            <td>
                              <input type="text" name="POPUP_EMPID_0" id="POPUP_EMPID_0" class="form-control showEmp"  value="<?php echo e($row->EMPCODE); ?>" readonly  style="width:100%;"  disabled />
                              </td>
                              <td hidden><input type="hidden" name=<?php echo e("EMPID_REF_".$key); ?> id =<?php echo e("EMPID_REF_".$key); ?> value="<?php echo e($row->EMPID_REF); ?>" disabled /></td>
                              <td><input  class="form-control w-100" type="text" name=<?php echo e("EMP_NAME_".$key); ?> id =<?php echo e("EMP_NAME_".$key); ?> value="<?php echo e($row->FNAME); ?> <?php echo e($row->MNAME); ?> <?php echo e($row->LNAME); ?>" maxlength="200" readonly style="width:100%;" disabled ></td>
                              <td><input  class="form-control w-100" type="date" name=<?php echo e("STARTPD_".$key); ?> id =<?php echo e("STARTPD_".$key); ?> value="<?php echo e(isset($row->STARTPD) && $row->STARTPD !="" && $row->STARTPD !="1900-01-01" ? $row->STARTPD:''); ?>"  autocomplete="off" style="width:100%;" disabled ></td>
                              <td><input  class="form-control w-100" type="date" name=<?php echo e("ENDPD_".$key); ?> id =<?php echo e("ENDPD_".$key); ?> value="<?php echo e(isset($row->ENDPD) && $row->ENDPD !="" && $row->ENDPD !="1900-01-01" ? $row->ENDPD:''); ?>"   autocomplete="off" style="width:100%;" disabled ></td>
                              <td><input  class="" type="checkbox" name=<?php echo e("EMPDEACTIVATED_".$key); ?> id =<?php echo e("EMPDEACTIVATED_".$key); ?>  value="1"  autocomplete="off" style="width:100%;"  <?php echo e($row->DEACTIVATED == 1 ? "checked" : ""); ?> disabled ></td>
                              <td><input  class="form-control w-100" type="date" name=<?php echo e("EMPDODEACTIVATED_".$key); ?> id =<?php echo e("EMPDODEACTIVATED_".$key); ?>  autocomplete="off" style="width:100%;" value="<?php echo e(isset($row->DODEACTIVATED) && $row->DODEACTIVATED !="" && $row->DODEACTIVATED !="1900-01-01" ? $row->DODEACTIVATED:''); ?>" <?php echo e($row->DEACTIVATED == 1 ? "" : "disabled"); ?> disabled  ></td>
                              <td><input  class="" type="checkbox" name=<?php echo e("SUPPERUSER_".$key); ?> id =<?php echo e("SUPPERUSER_".$key); ?> value="1"  autocomplete="off" style="width:100%;" <?php echo e($row->SUPPERUSER == 1 ? "checked" : ""); ?> disabled></td>
                              
                              <!--
                              <td align="center" >
                                  <button class="btn add" title="add" data-toggle="tooltip" <?php echo e(isset($row->DEACTIVATED) && $row->DEACTIVATED ==1?'':'disabled'); ?> disabled ><i class="fa fa-plus"></i></button>
                                  <button class="btn remove" title="Delete" data-toggle="tooltip" <?php echo e(isset($n) && $n ==1?'disabled':''); ?> disabled ><i class="fa fa-trash" ></i></button>
                              </td>
                              -->
                          </tr>

                          <?php $n++; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  

                           <?php else: ?>

                          <tr  class="participantRow">
                              <td>
                              <input type="text" name="POPUP_EMPID_0" id="POPUP_EMPID_0" class="form-control showEmp" readonly  style="width:100%;" disabled  />
                              </td>
                              <td hidden><input type="hidden" name="EMPID_REF_0" id="EMPID_REF_0" disabled /></td>
                              <td><input  class="form-control w-100" type="text"  id ="EMP_NAME_0" maxlength="200" readonly style="width:100%;" disabled ></td>
                              <td><input  class="form-control w-100" type="date" name="STARTPD_0" id ="STARTPD_0" autocomplete="off" style="width:100%;" disabled ></td>
                              <td><input  class="form-control w-100" type="date" name="ENDPD_0" id ="ENDPD_0"  autocomplete="off" style="width:100%;" disabled ></td>
                              <td><input  class="" type="checkbox" name="EMPDEACTIVATED_0" id ="EMPDEACTIVATED_0" value="1"  autocomplete="off" style="width:100%;" disabled ></td>
                              <td><input  class="form-control w-100" type="date" name="EMPDODEACTIVATED_0" id ="EMPDODEACTIVATED_0"  autocomplete="off" style="width:100%;" disabled  ></td>
                              
                              
                              <!--
                              <td align="center" >
                                  <button class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                                  <button class="btn remove" title="Delete" data-toggle="tooltip" disabled><i class="fa fa-trash" ></i></button>
                              </td>
                              -->
                          </tr>

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
      var viewURL = '<?php echo e(route("master",[150,"add"])); ?>';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Common\UserMaster\mstfrm150view.blade.php ENDPATH**/ ?>