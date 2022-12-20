

<?php $__env->startSection('content'); ?>
    
<?php $__env->stopSection(); ?>

<?php if(!empty($objitem)): ?>
        <?php $__currentLoopData = $objitem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$objitems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr id="mainitemidcode_substitute_<?php echo e($index); ?>" class="mainitem_tab1">
                                <td width="25%">
                                    <?php echo e($objitems-> ICODE); ?>

                                    <input
                                        type="hidden"
                                        id="txtmainitemidcode_substitute_<?php echo e($index); ?>"
                                        data-code="<?php echo e($objitems-> ICODE); ?>"
                                        data-uomno="<?php echo e($objitems-> MAIN_UOMID_REF); ?>"
                                        data-name="<?php echo e($objitems-> NAME); ?>"
                                        data-uom="<?php echo e($objitems-> UOMCODE.'-'.$objitems-> DESCRIPTIONS); ?>"
                                        value="<?php echo e($objitems-> ITEMID); ?>"
                                  
                                    />
                                </td>
                                <td width="25%"><?php echo e($objitems-> NAME); ?></td>
                                <td width="25%"><?php echo e($objitems-> UOMCODE); ?>-<?php echo e($objitems-> DESCRIPTIONS); ?></td>
                                <td width="25%"><?php echo e($objitems-> DRAWINGNO); ?></td>
                            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>

                         <tr>
                         <td colspan="4">No record found!</td>                                   
                        </tr

        <?php endif; ?>




    

<?php $__env->startPush('bottom-css'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startPush('bottom-scripts'); ?>
<script>
$("#YesBtn").click(function(){

$("#alert").modal('hide');
var customFnName = $("#YesBtn").data("funcname");
    window[customFnName]();

}); //yes button



//no button
$("#NoBtn").click(function(){
    $("#alert").modal('hide');
    $("#SONO").focus();
});

//ok button
$("#OkBtn").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $(".text-danger").hide();
    window.location.href = '<?php echo e(route("transaction",[270,"index"])); ?>';
});

$("#OkBtn1").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $("#OkBtn1").hide();
    $("#"+$(this).data('focusname')).focus();
    // $("[id*=txtlabel]").focus();
    $(".text-danger").hide();
});

//
function showError(pId,pVal){
    $("#"+pId+"").text(pVal);
    $("#"+pId+"").show();
}
function getFocus(){
    var FocusId=$("#FocusId").val();
    $("#"+FocusId).focus();
    $("#closePopup").click();
}
function highlighFocusBtn(pclass){
       $(".activeYes").hide();
       $(".activeNo").hide();
       
       $("."+pclass+"").show();
    }

    



 
$('#btnExit').on('click', function() {
  var viewURL = '<?php echo e(route('home')); ?>';
              window.location.href=viewURL;
});

</script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\transactions\inventory\StoretoStoreTransafer\item.blade.php ENDPATH**/ ?>