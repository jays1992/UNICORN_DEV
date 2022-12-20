<?php $__env->startSection('content'); ?>

<div class="container-fluid topnav">
	<div class="row">
		<div class="col-lg-2"><a href="<?php echo e(route('master',[50,'index'])); ?>" class="btn singlebt">Vendor - Item Price List</a></div>
		<div class="col-lg-10 topnav-pd">
		  <button  id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
      <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
      <button class="btn topnavbt"  disabled><i class="fa fa-save"></i> Save</button>
      <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
      <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
      <button class="btn topnavbt" id="btnUndo"  disabled><i class="fa fa-undo"></i> Undo</button>
      <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
      <button class="btn topnavbt" id="btnApprove" disabled><i class="fa fa-lock"></i> Approved</button>
      <button class="btn topnavbt" id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
      <a href="<?php echo e(route('home')); ?>" class="btn topnavbt"><i class="fa fa-power-off"></i> Exit</a>
		</div>
	</div>
</div>

<div class="container-fluid filter">
	<form id="form_data" method="POST"  > 
  	<div class="inner-form">
      
      <div class="row">
        <div class="col-lg-1 pl"><p>PL No</p></div>
        <div class="col-lg-1 pl">
          <label><?php echo e($objMstResponse->VPL_NO); ?></label>   
        </div>

        <div class="col-lg-1 pl"><p>PL Date</p></div>
        <div class="col-lg-2 pl"> 
        <label><?php echo e((!is_null($objMstResponse->VPL_DT) && $objMstResponse->VPL_DT!='1900-01-01')? 
            \Carbon\Carbon::parse($objMstResponse->VPL_DT)->format('d/m/Y') : ''); ?></label>         
         
        </div>

     
      <div class="col-lg-1 pl"><p>Vendor Group</p></div>
        <div class="col-lg-2 pl">
        <label><?php echo e(isset($objVendorGroupName->VGCODE)?$objVendorGroupName->VGCODE. ' - ':''); ?>  <?php echo e(isset($objVendorGroupName->DESCRIPTIONS)?$objVendorGroupName->DESCRIPTIONS:''); ?></label>

        </div>

        <div class="col-lg-1 pl"><p>OR</p></div>
			
			<div class="col-lg-1 pl"><p> Vendor</p></div>
			<div class="col-lg-2 pl">
          <label><?php echo e(isset($objVendorName->VCODE)?$objVendorName->VCODE. ' - ':''); ?>  <?php echo e(isset($objVendorName->NAME)?$objVendorName->NAME:''); ?></label>

			</div>
</div>

      <div class="row">
        <div class="col-lg-1 pl"><p>From Period</p></div>
        <div class="col-lg-2 pl">
        <label><?php echo e((!is_null($objMstResponse->PERIOD_FR) && $objMstResponse->PERIOD_FR!='1900-01-01')? \Carbon\Carbon::parse($objMstResponse->PERIOD_FR)->format('d/m/Y') : ''); ?></label> 
         
        </div>
        
        <div class="col-lg-1 pl"><p>To Period</p></div>
        <div class="col-lg-2 pl">
        <label><?php echo e((!is_null($objMstResponse->PERIOD_TO) && $objMstResponse->PERIOD_TO!='1900-01-01')? \Carbon\Carbon::parse($objMstResponse->PERIOD_TO)->format('d/m/Y') : ''); ?></label> 
         
        </div>
        
        <div class="col-lg-2 pl "><p>Price List Title</p></div>
        <div class="col-lg-4 pl">
          <label><?php echo e($objMstResponse->PL_TITLE); ?></label>
          
        </div>        
        
      </div>
      
      <div class="row">
        <div class="col-lg-2 pl"><p>De-Activated</p></div>
        <div class="col-lg-1 pl pr">
        <input type="checkbox"   name="DEACTIVATED"  id="deactive-checkbox_0" <?php echo e($objMstResponse->DEACTIVATED == 1 ? "checked" : ""); ?>

        value='<?php echo e($objMstResponse->DEACTIVATED == 1 ? 1 : 0); ?>' tabindex="3" disabled>
        </div>
        
        <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
        <div class="col-lg-2 pl">
        <div class="col-lg-8 pl">
          <label><?php echo e((!is_null($objMstResponse->DODEACTIVATED) && $objMstResponse->DODEACTIVATED!='1900-01-01')? 
            \Carbon\Carbon::parse($objMstResponse->DODEACTIVATED)->format('d/m/Y') : ''); ?></label>       
        </div>
        </div>
      </div>       

	</div>
		
		
	<div class="container-fluid">
		<div class="row">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#tab1" tabindex="6">Material</a></li>
			</ul>
			<div class="tab-content">
        <div id="tab1" class="tab-pane fade in active">
            <div class="table-responsive table-wrapper-scroll-y " style="height:260px;margin-top:10px;">					
              <table id="table3" class="display nowrap table table-striped table-bordered itemlist itemlistscroll w-200" style="height:auto !important;">
                <thead id="thead1"  style="position: sticky;top: 0">
                  <tr >
                    <th style="width: 120px">Item Code<input class="form-control" type="hidden" name="Row_Count3" id ="Row_Count3" value="<?php echo e($objList1Count); ?>"></th>
                    <th>Item Name</th>
                    <th style="width: 70px">UoM Code</th>
                    <th>Item Specifications (If Any)</th>
                    <th  style="width: 130px">List Price (LP)</th>
                    <th  style="width: 120px">GST included in LP</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($objList1)): ?>
                  <?php $__currentLoopData = $objList1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr  class="participantRow">
                    <td>
                      <input  class="form-control w-100" type="text" name="ITEMID_REF_<?php echo e($key); ?>" id="TXT_ITEMID_REF_POPUP_<?php echo e($key); ?>" value="<?php echo e($row->NAME); ?>"  maxlength="20" disabled>
                    </td>
                    <td hidden>
                      <input  class="form-control w-100" type="text" name="HDN_ITEMID_REF_<?php echo e($key); ?>" id="HDN_ITEMID_REF_POPUP_<?php echo e($key); ?>" value="<?php echo e($row->ITEMID_REF); ?>" maxlength="100" disabled>
                    </td>
                    <td>
                      <input  class="form-control w-100" type="text" name="ITEMNAME_<?php echo e($key); ?>" id="ITEMNAME_<?php echo e($key); ?>" autocomplete="off" value="<?php echo e($row->NAME); ?>" disabled >
                    </td>
                    <td hidden>
                      <input  class="form-control w-100" type="text" name="HDN_UOMID_REF_<?php echo e($key); ?>" id="HDN_UOMID_REF_POPUP_<?php echo e($key); ?>" value="<?php echo e($row->UOMID_REF); ?>"  maxlength="100" disabled >
                    </td>
                    <td >
                      <input  class="form-control" style="width: 70px" type="text" name="UOM_<?php echo e($key); ?>" id="UOM_<?php echo e($key); ?>" autocomplete="off" value="<?php echo e($row->UOMCODE); ?>" disabled >
                    </td>
                    <td>
                      <input  class="form-control w-100" type="text" name="ITEM_SPEC_<?php echo e($key); ?>" id="ITEM_SPEC_<?php echo e($key); ?>" maxlength="200" value="<?php echo e($row->ITEMSPECI); ?>"  autocomplete="off" disabled >
                    </td>

                    <td>
                      <input disabled class="form-control CLS_LISTPRICE rightalign five-digits" type="text"  name="LISTPRICE_<?php echo e($key); ?>" id="IDLISTPRICE_<?php echo e($key); ?>" value="<?php echo e($row->LP); ?>"  maxlength="13" autocomplete="off"   >
                    </td>

                    <td style="text-align:center;">
                      <input disabled type="checkbox" class="filter-none"  name="GST_IN_LP_<?php echo e($key); ?>" id="IDGST_IN_LP_<?php echo e($key); ?>" value="1" autocomplete="off" <?php echo e($row->GST_IN_LP==1? "checked":""); ?> >
                    </td>
                    
                    <td>
                      <input  class="form-control " type="text" name="REMARKS_<?php echo e($key); ?>" id="REMARKS_<?php echo e($key); ?>" maxlength="200" autocomplete="off" value="<?php echo e($row->REMARKS); ?>" disabled >
                    </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?> 
                  <tr  class="participantRow">
                    <td>
                      <input  class="form-control w-100" type="text" name="ITEMID_REF_0" id="TXT_ITEMID_REF_POPUP_0" maxlength="100" disabled>
                    </td>
                    <td hidden>
                      <input  class="form-control w-100" type="text" name="HDN_ITEMID_REF_0" id="HDN_ITEMID_REF_POPUP_0" maxlength="100" disabled>
                    </td>
                    <td>
                      <input  class="form-control w-100" type="text" name="ITEMNAME_0" id="ITEMNAME_0" autocomplete="off" disabled>
                    </td>
                    <td hidden>
                      <input  class="form-control w-100" type="text" name="HDN_UOMID_REF_0" id="HDN_UOMID_REF_POPUP_0" maxlength="100" disabled>
                    </td>
                    <td >
                      <input  class="form-control" style="width: 70px" type="text" name="UOM_0" id="UOM_0" autocomplete="off" disabled>
                    </td>
                    <td>
                      <input  class="form-control w-100" type="text" name="ITEM_SPEC_0" id="ITEM_SPEC_0" maxlength="200" autocomplete="off" disabled  >
                    </td>
                    <td>
                      <input  class="form-control rightalign five-digits" type="text" name="MRP_0" id="IDMRP_0" maxlength="13" autocomplete="off"  disabled>
                    </td>
                    <td>
                      <input  class="form-control " type="text" name="REMARKS_0" id="REMARKS_0" maxlength="200" autocomplete="off"  disabled>
                    </td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>          
            </div>
        </div><!-- tab1 -->

      </div><!-- tab-content -->
		</div><!-- row -->			
	</div><!-- container-fluid -->
						
	</form>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('alert'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('bottom-css'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('bottom-scripts'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Purchase\VendorItemPriceList\mstfrm50view.blade.php ENDPATH**/ ?>