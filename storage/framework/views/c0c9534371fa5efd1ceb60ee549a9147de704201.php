
<?php $__env->startSection('content'); ?>
<!-- <form id="frm_mst_se" onsubmit="return validateForm()"  method="POST"  >     -->

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[1,'index'])); ?>" class="btn singlebt">Calculation Template</a>
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
                        
                </div>
            </div><!--row-->
    </div><!--topnav-->	
    <!-- multiple table-responsive table-wrapper-scroll-y my-custom-scrollbar -->
    <div class="container-fluid purchase-order-view filter">   
      
    <form id="frm_mst_calculation"  method="POST">  
    <?php echo csrf_field(); ?>
          <?php echo e(isset($objCalculation->CTID) ? method_field('PUT') : ''); ?>

                <div class="inner-form">
                    
                    <div class="row">
                        <div class="col-lg-2 pl"><p>Calculation Template Code</p></div>
                        <div class="col-lg-2 pl">
                            <div class="col-lg-12 pl">
                                <label style="text-transform: uppercase;"><?php echo e($objCalculation->CTCODE); ?></label>
                            </div>
                        </div>

                        <div class="col-lg-2 pl"><p>Module</p></div>
                        <div class="col-lg-2 pl">
                            <div class="col-lg-12 pl">
                                <label ><?php echo e($objCalculation->MODULE_NAME); ?></label>
                            </div>
                        </div>

                        <div class="col-lg-2 pl"><p>TYPE</p></div>
                        <div class="col-lg-2 pl">
                            <div class="col-lg-12 pl">
                                <label ><?php echo e($objCalculation->TYPE); ?></label>
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="col-lg-2 pl"><p>Calculation Template Description</p></div>
                        <div class="col-lg-5 pl">
                            <label><?php echo e($objCalculation->CTDESCRIPTION); ?></label>
                        </div>
                    </div>	
                            
                    <div class="row">
                        <div class="col-lg-2 pl"><p>De-Activated</p></div>
                        <div class="col-lg-1 pl">
                            <input type="checkbox" name="DEACTIVATED" id="deactive"  <?php echo e($objCalculation->DEACTIVATED == 1 ? 'checked' : ''); ?> disabled>
                        </div>
                        
                        <div class="col-lg-2 pl col-md-offset-1"><p>Date of De-Activated</p></div>
                        <div class="col-lg-2 pl">
                        <div class="col-lg-8 pl">
                        <label><?php echo e(($objCalculation->DODEACTIVATED)=='1900-01-01'?'':$objCalculation->DODEACTIVATED); ?></label>
                        </div>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="table-responsive table-wrapper-scroll-y " style="height:330px;margin-top:10px;">
                        <table id="example2" class="display nowrap table table-striped table-bordered itemlist dataTable" style="height:auto !important;">
                            <thead id="thead1"   style="position: sticky;top: 0; white-space:none;">
                                <tr>
                                    <th style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">Calculation Component Name <input class="form-control" type="hidden" name="Row_Count" id ="Row_Count">  </th>
                                    <th width="5%" style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">SQ No</th>
                                    <th style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">Basis</th>
                                    <th style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">GL</th>
                                    <th width="5%" style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">Formula</th>
                                    <th width="5%" style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">Rate %</th>
                                    <th style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">Formula</th>
                                    <th width="5%">Amount</th>
                                    <th style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">GST Calc on</th>
                                    <th style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">As per Actual</th>
                                    <th style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">Landed Cost Included</th>
                                    <th width="5%" style="vertical-align:middle; font-family: 'Roboto',sans-serif; font-size:11px; font-weight: 600;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($objCalculationtemp)): ?>
                                    <?php $__currentLoopData = $objCalculationtemp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr  class="participantRow">
                                            <td hidden> <label><?php echo e($row->TID); ?></label>
                                            </td>
                                            <td style="width:10%;"><label  style="text-transform: uppercase;"><?php echo e($row->COMPONENT); ?></label></td>
                                            <td style="width:1%;"><label><?php echo e($row->SQNO); ?></label></td>
                                            <td style="width:15%;"><label><?php echo e($row->BASIS); ?></label></td>
                                            <td style="width:15%;"><label name=<?php echo e("GLID_".$key); ?> id=<?php echo e("lblgl_".$key); ?>><?php echo e($row->GLID_REF); ?></label></td>   
                                            <td  style="text-align:center;" ><input type="checkbox" name=<?php echo e("FORMULAYESNO_".$key); ?> id=<?php echo e("chkfrm_".$key); ?> <?php echo e($row->FORMULAYESNO == 1 ? 'checked' : ''); ?>   style="float: revert;" disabled></td>
                                            <td style="width:7%; text-align: right;"><label><?php echo e($row->RATEPERCENTATE); ?></label></td>
                                            <td style="width:15%;"><label><?php echo e($row->FORMULA); ?></label></td>
                                            <td style="width:10%; text-align: right;" ><label><?php echo e($row->AMOUNT); ?></label></td>
                                            <td style="text-align:center;" ><input type="checkbox" name=<?php echo e("GST_".$key); ?> id=<?php echo e("chkgst_".$key); ?>   style="float: revert;"  <?php echo e($row->GST == 1 ? 'checked' : ''); ?> disabled></td>
                                            <td style="text-align:center;" ><input type="checkbox" name=<?php echo e("ACTUAL_".$key); ?> id=<?php echo e("chkact_".$key); ?>    style="float: revert;"  <?php echo e($row->ACTUAL == 1 ? 'checked' : ''); ?> disabled></td>
                                            <td style="text-align:center;" ><input type="checkbox" name=<?php echo e("LANDEDCOST_".$key); ?> id=<?php echo e("chklndc_".$key); ?>    style="float: revert;"  <?php echo e($row->LANDEDCOST == 1 ? 'checked' : ''); ?> disabled></td>
                                            <td align="center"><button class="btn add" title="add" data-toggle="tooltip" disabled><i class="fa fa-plus"></i></button><button class="btn remove" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td>
                                        </tr>
                                        <tr></tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                <?php endif; ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </form> 
</div><!--purchase-order-view-->
<!-- </form>    -->
<!-- </div> -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views/masters/Common/CalculationTemplate/mstfrm1view.blade.php ENDPATH**/ ?>