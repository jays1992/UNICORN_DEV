

<?php $__env->startSection('content'); ?>

    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('transaction',[168,'index'])); ?>" class="btn singlebt">Annual Forecast Sales (AFS)</a>
                </div>

                <div class="col-lg-10 topnav-pd">
                        <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSaveSE" disabled="disabled"><i class="fa fa-floppy-o" ></i> Save</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo"  disabled="disabled"><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-thumbs-o-up"></i> Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div>
    </div>
<form id="frm_trn_se"  method="POST">   
    <?php echo csrf_field(); ?>
    <?php echo e(isset($objSE->AFSID) ? method_field('PUT') : ''); ?>

    <div class="container-fluid filter">

<div class="inner-form">

  <div class="row">
    <div class="col-lg-1 pl"><p>AFS No</p></div>
    <div class="col-lg-1 pl">
 
  
              <input type="text" name="AFSNO" id="AFSNO" value="<?php echo e($objSE->AFSNO); ?>" class="form-control mandatory"  autocomplete="off" readonly style="text-transform:uppercase"  >
           
   
      
    </div>
    
    <div class="col-lg-1 pl col-md-offset-1"><p>AFS Date</p></div>
    <div class="col-lg-2 pl">
          <input type="date" name="AFSDT" id="AFSDT" value="<?php echo e($objSE->AFSDT); ?>" class="form-control mandatory AFSDT"  placeholder="dd/mm/yyyy" >
          </div>
    
    <div class="col-lg-1 pl"><p> Department	</p></div>
    <div class="col-lg-2 pl">
    <input type="text" name="DEPTID_NAME" id="DEPTID_NAME" readonly value="<?php echo e($objSE->NAME); ?>"  class="form-control mandatory"  autocomplete="off" readonly style="text-transform:uppercase"  >
      <input type="hidden" name="DEPID_REF" id="DEPID_REF" value="<?php echo e($objSE->DEPID_REF); ?>" class="form-control mandatory"  autocomplete="off"  style="text-transform:uppercase"  >
    </div>
    
    <div class="col-lg-1 pl"><p>Financial Year</p></div>
    <div class="col-lg-2 pl">
    <input type="text" name="FYID_NAME" id="FYID_NAME" value="<?php echo e($objSE->FYDESCRIPTION); ?>" readonly  class="form-control mandatory"  autocomplete="off" readonly style="text-transform:uppercase"  >
      <input type="hidden" name="FYID_REF" id="FYID_REF" value="<?php echo e($objSE->FYID_REF); ?>" class="form-control mandatory"  autocomplete="off"  style="text-transform:uppercase"  >
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
                                      <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                                          <thead id="thead1"  style="position: sticky;top: 0">
                                                  
                                                  <tr>
                                                      <th colspan="7"></th>
                                                      <th colspan="2">April</th>
                                                      <th colspan="2">May</th>
                                                      <th colspan="2">June</th>
                                                      <th colspan="2">July</th>
                                                      <th colspan="2">August</th>
                                                      <th colspan="2">September</th>
                                                      <th colspan="2">October</th>
                                                      <th colspan="2">November</th>
                                                      <th colspan="2">December</th>
                                                      <th colspan="2">January</th>
                                                      <th colspan="2">February</th>
                                                      <th colspan="2">March</th>
                                                      <th colspan="2">Financial</th>
                                                      <th colspan=></th>
                                                      
                                                  
                                                  </tr>
                                                  <tr>
                                                      <th width="10%">Business Unit	<input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1"></th>
                                                      <th width="10%">Item Code</th>
                                                      <th  width="15%">Item Name</th>
                                                      <th>Customer</th>
                                                      <th>Part No</th>
                                                      <th>Main UOM</th>
                                                      <th width="15%">Item Specification</th>
                                                   
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                                      <th>Qty</th>
                                                      <th>Value</th>
                                              
                                                    
                                                      <th  width="6%">Action</th>
                                                  </tr>
                                          </thead>
                                          <tbody>
                                          <?php if(!empty($objSEMAT)): ?>
                                <?php $__currentLoopData = $objSEMAT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                              <tr  class="participantRow">
                                              <td style="text-align:center;">
                         
      
                         <input type="text"  name=<?php echo e("BUID_REF_".$key); ?> id=<?php echo e("BUID_REF_".$key); ?>  value="<?php echo e($row->BUCODE); ?>" onClick="get_section($(this).attr('id'))" class="form-control mandatory" style="width:91px" readonly tabindex="1" />
                        
                       
                             
                         </td>
                         <td hidden> <input type="text" name=<?php echo e("REF_BUID_".$key); ?> id=<?php echo e("REF_BUID_".$key); ?> value="<?php echo e($row->BUID_REF); ?>" /></td>
                         
                      
                                                 <!-- <td style="text-align:center;" >
                                                  <input type="text" name="txtSO_popup_0" id="txtSO_popup_0" class="form-control"  autocomplete="off"  readonly/>
                                                  <td hidden><input type="hidden" name="SOID_REF_0" id="SOID_REF_0" class="form-control" autocomplete="off" /></td>
                                                  <td hidden><input type="hidden" name="SQID_REF_0" id="SQID_REF_0" class="form-control" autocomplete="off" /></td>
                                                  <td hidden><input type="hidden" name="SEQID_REF_0" id="SEQID_REF_0" class="form-control" autocomplete="off" /></td></td>
                                                  -->
                                                  <td><input type="text" name=<?php echo e("popupITEMID_".$key); ?> id=<?php echo e("popupITEMID_".$key); ?>  class="form-control" value="<?php echo e($row->ICODE); ?>"  autocomplete="off"  readonly/></td>
                                                  <td hidden><input type="hidden" name=<?php echo e("ITEMID_REF_".$key); ?> id=<?php echo e("ITEMID_REF_".$key); ?>  class="form-control" value="<?php echo e($row->ITEMID_REF); ?>" autocomplete="off" /></td>
                                                  <td><input type="text" name=<?php echo e("ItemName_".$key); ?> id=<?php echo e("ItemName_".$key); ?>  class="form-control" value="<?php echo e($row->NAME); ?>"  autocomplete="off"  readonly/></td>
                  <td style="text-align:center;">            
      
                         <input type="text" name=<?php echo e("CID_REF_".$key); ?> id=<?php echo e("CID_REF_".$key); ?>   onClick="get_customer($(this).attr('id'))" class="form-control mandatory" value="<?php echo e($row->CCODE); ?>" style="width:91px" readonly tabindex="1" />                       
                          </td>
                         <td hidden> <input type="text" name=<?php echo e("CUSTOMERID_REF_".$key); ?> id=<?php echo e("CUSTOMERID_REF_".$key); ?>  value="<?php echo e($row->CID_REF); ?>" /></td>
                                                  <td><input type="text" name=<?php echo e("ItemPartno_".$key); ?> id=<?php echo e("ItemPartno_".$key); ?>   class="form-control three-digits" value="<?php echo e($row->PARTNO); ?>"  autocomplete="off" style="width: 82px;" readonly/></td>
                                                  <td><input type="text" name=<?php echo e("itemuom_".$key); ?> id=<?php echo e("itemuom_".$key); ?>   class="form-control"  autocomplete="off" value="<?php echo e($row->UOMID_REF); ?>" readonly/></td>
                                                  <td><input type="text" readonly name=<?php echo e("Itemspec_".$key); ?> id=<?php echo e("Itemspec_".$key); ?>  class="form-control"  value="<?php echo e($row->ITEMSPECI); ?>" autocomplete="off"  /></td>
                                      
                                                  <td><input type="text" readonly name=<?php echo e("APRIL_QTY_".$key); ?> id=<?php echo e("APRIL_QTY_".$key); ?> class="form-control three-digits" value="<?php echo e($row->MONTH1_QTY == '.000' ? '' : $row->MONTH1_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("APRIL_VALUE_".$key); ?> id=<?php echo e("APRIL_VALUE_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH1_VL == '.00' ? '' : $row->MONTH1_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("MAY_QTY_".$key); ?> id=<?php echo e("MAY_QTY_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH2_QTY == '.000' ? '' : $row->MONTH2_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("MAY_VALUE_".$key); ?> id=<?php echo e("MAY_VALUE_".$key); ?>   class="form-control three-digits" value="<?php echo e($row->MONTH2_VL == '.00' ? '' : $row->MONTH2_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("JUNE_QTY_".$key); ?> id=<?php echo e("JUNE_QTY_".$key); ?>   class="form-control three-digits" value="<?php echo e($row->MONTH3_QTY == '.000' ? '' : $row->MONTH3_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("JUNE_VALUE_".$key); ?> id=<?php echo e("JUNE_VALUE_".$key); ?>  class="form-control three-digits"  value="<?php echo e($row->MONTH3_VL == '.00' ? '' : $row->MONTH3_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("JULY_QTY_".$key); ?> id=<?php echo e("JULY_QTY_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH4_QTY == '.000' ? '' : $row->MONTH4_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("JULY_VALUE_".$key); ?> id=<?php echo e("JULY_VALUE_".$key); ?>   class="form-control three-digits"value="<?php echo e($row->MONTH4_VL == '.00' ? '' : $row->MONTH4_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("AUGUST_QTY_".$key); ?> id=<?php echo e("AUGUST_QTY_".$key); ?> class="form-control three-digits" value="<?php echo e($row->MONTH5_QTY == '.000' ? '' : $row->MONTH5_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("AUGUST_VALUE_".$key); ?> id=<?php echo e("AUGUST_VALUE_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH5_VL == '.00' ? '' : $row->MONTH5_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("SEPTEMBER_QTY_".$key); ?> id=<?php echo e("SEPTEMBER_QTY_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH6_QTY == '.000' ? '' : $row->MONTH6_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("SEPTEMBER_VALUE_".$key); ?> id=<?php echo e("SEPTEMBER_VALUE_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH6_VL == '.00' ? '' : $row->MONTH6_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("OCTOBER_QTY_".$key); ?> id=<?php echo e("OCTOBER_QTY_".$key); ?>  class="form-control three-digits"  value="<?php echo e($row->MONTH7_QTY == '.000' ? '' : $row->MONTH7_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("OCTOBER_VALUE_".$key); ?> id=<?php echo e("OCTOBER_VALUE_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH7_VL == '.00' ? '' : $row->MONTH7_VL); ?>"  maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("NOVEMBER_QTY_".$key); ?> id=<?php echo e("NOVEMBER_QTY_".$key); ?> class="form-control three-digits" value="<?php echo e($row->MONTH8_QTY == '.000' ? '' : $row->MONTH8_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("NOVEMBER_VALUE_".$key); ?> id=<?php echo e("NOVEMBER_VALUE_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH8_VL == '.00' ? '' : $row->MONTH8_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("DECEMBER_QTY_".$key); ?> id=<?php echo e("DECEMBER_QTY_".$key); ?> class="form-control three-digits" value="<?php echo e($row->MONTH9_QTY == '.000' ? '' : $row->MONTH9_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("DECEMBER_VALUE_".$key); ?> id=<?php echo e("DECEMBER_VALUE_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH9_VL == '.00' ? '' : $row->MONTH9_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("JANUARY_QTY_".$key); ?> id=<?php echo e("JANUARY_QTY_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH10_QTY == '.000' ? '' : $row->MONTH10_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("JANUARY_VALUE_".$key); ?> id=<?php echo e("JANUARY_VALUE_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH10_VL == '.00' ? '' : $row->MONTH10_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("FEBRUARY_QTY_".$key); ?> id=<?php echo e("FEBRUARY_QTY_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH11_QTY == '.000' ? '' : $row->MONTH11_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("FEBRUARY_VALUE_".$key); ?> id=<?php echo e("FEBRUARY_VALUE_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH11_VL == '.00' ? '' : $row->MONTH11_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("MARCH_QTY_0".$key); ?> id=<?php echo e("MARCH_QTY_0".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH12_QTY == '.000' ? '' : $row->MONTH12_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("MARCH_VALUE_".$key); ?> id=<?php echo e("MARCH_VALUE_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->MONTH12_VL == '.00' ? '' : $row->MONTH12_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("FY_QTY_".$key); ?> id=<?php echo e("FY_QTY_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->FY_QTY == '.000' ? '' : $row->FY_QTY); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                  <td><input type="text" readonly name=<?php echo e("FY_VALUE_".$key); ?> id=<?php echo e("FY_VALUE_".$key); ?>  class="form-control three-digits" value="<?php echo e($row->FY_VL == '.00' ? '' : $row->FY_VL); ?>" maxlength="13" style="width: 65px;" autocomplete="off"  /></td>
                                                                                                 





                        
                        <td align="center" ><button class="btn add material" title="add" data-toggle="tooltip" type="button" ><i class="fa fa-plus"></i></button>
                        <button class="btn remove dmaterial" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button></td>
            

                             
                                             
                           
                                              </tr>
                                              <tr></tr>
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
<div id="alert" class="modal"  role="dialog"  data-backdrop="static" >
  <div class="modal-dialog"  >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='closePopup' >&times;</button>
        <h4 class="modal-title">System Alert Message</h4>
      </div>
      <div class="modal-body">
	  <h5 id="AlertMessage" ></h5>
        <div class="btdiv">
            <button class="btn alertbt" name='YesBtn' id="YesBtn" data-funcname="fnSaveData">
            <div id="alert-active" class="activeYes"></div>Yes
            </button>
            <button class="btn alertbt" name='NoBtn' id="NoBtn"   data-funcname="fnUndoNo" >
            <div id="alert-active" class="activeNo"></div>No
            </button>
            <button class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;">
            <div id="alert-active" class="activeOk"></div>OK</button>
            <button class="btn alertbt" name='OkBtn1' id="OkBtn1" style="display:none;margin-left: 90px;">
            <div id="alert-active" class="activeOk1"></div>OK</button>
        </div><!--btdiv-->
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<!-- Alert -->

<?php $__env->stopSection(); ?>


<?php $__env->startPush('bottom-css'); ?>
<style>
#custom_dropdown, #udfforsemst_filter {
    display: inline-table;
    margin-left: 15px;
}
.dataTables_wrapper .row:nth-child(1) .col-sm-6:nth-child(2){text-align:right;}
#filtercolumn{color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    }



</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('bottom-scripts'); ?>
<script>


     
$(document).ready(function(e) {
var lastenqdt = ""; ?>;
var today = new Date(); 
var sodate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
$('#ENQDT').attr('min',lastenqdt);
$('#ENQDT').attr('max',sodate);
$('[id*="EDD"]').attr('min',sodate);



$('#example3').find('.participantRow3').each(function(){
      var txt_id4 = $(this).find('[id*="udfinputid"]').attr('id');
      var udfid = $(this).find('[id*="SEID_REF"]').val();
      $.each( seudf, function( seukey, seuvalue ) {
        if(seuvalue.UDFSEID == udfid)
        {
          var txtvaltype2 =   seuvalue.VALUETYPE;
          var strdyn2 = txt_id4.split('_');
          var lastele2 =   strdyn2[strdyn2.length-1];
          var dynamicid2 = "udfvalue_"+lastele2;
          
          var chkvaltype2 =  txtvaltype2.toLowerCase();
          var strinp2 = '';

          if(chkvaltype2=='date'){
          strinp2 = '<input type="date" placeholder="dd/mm/yyyy" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"  > ';       
          }
          else if(chkvaltype2=='time'){
          strinp2= '<input type="time" placeholder="h:i" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"  > ';
          }
          else if(chkvaltype2=='numeric'){
          strinp2 = '<input type="text" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"   > ';
          }
          else if(chkvaltype2=='text'){
          strinp2 = '<input type="text" name="'+dynamicid2+ '" id="'+dynamicid2+'" autocomplete="off" class="form-control"  > ';          
          }
          else if(chkvaltype2=='boolean'){            
              strinp2 = '<input type="checkbox" name="'+dynamicid2+ '" id="'+dynamicid2+'" class="" > ';
          }
          else if(chkvaltype2=='combobox'){
          var txtoptscombo2 =   seuvalue.DESCRIPTIONS;
          var strarray2 = txtoptscombo2.split(',');
          var opts2 = '';
          for (var i = 0; i < strarray2.length; i++) {
              opts2 = opts2 + '<option value="'+strarray2[i]+'">'+strarray2[i]+'</option> ';
          }
          strinp2 = '<select name="'+dynamicid2+ '" id="'+dynamicid2+'" class="form-control" required>'+opts2+'</select>' ;          
          }
          $('#'+txt_id4).html('');  
          $('#'+txt_id4).html(strinp2);
        }
      });
    });
var count1 = <?php echo json_encode($objCount1); ?>;

$('#Row_Count1').val(count1);

$.each(objSE, function(sekey,sevalue) {
  $.each(item, function(itkey,itvalue) {
      if(sevalue.ITEMID_REF == itvalue.ITEMID)
      {
        $('#popupITEMID_'+sekey).val(itvalue.ICODE);
        $('#ItemName_'+sekey).val(itvalue.NAME);
        $.each(uom, function(uomkey,uomvalue) {
          if(itvalue.MAIN_UOMID_REF == uomvalue.UOMID)
          {
            $('#popupMUOM_'+sekey).val(uomvalue.UOMCODE+'-'+uomvalue.DESCRIPTIONS);
          }
        });
        $.each(uom, function(uomkey,uomvalue) {
          if(sevalue.ALTUOMID_REF == uomvalue.UOMID)
          {
            $('#popupAUOM_'+sekey).val(uomvalue.UOMCODE+'-'+uomvalue.DESCRIPTIONS);
          }
          if(sevalue.PACKUOMID_REF == uomvalue.UOMID)
          {
            $('#PACKUOM_'+sekey).val(uomvalue.UOMCODE+'-'+uomvalue.DESCRIPTIONS);
          }
        });
      }
  });
  $.each(uomconv, function(uomckey,uomcvalue) {
    if(sevalue.ALTUOMID_REF == uomcvalue.TO_UOMID_REF && sevalue.ITEMID_REF == uomcvalue.ITEMID_REF)
    {
      var altqty = parseFloat((sevalue.MAIN_QTY * uomcvalue.TO_QTY)/ uomcvalue.FROM_QTY).toFixed(3);
      $('#ALT_UOMID_QTY_'+sekey).val(altqty);
    }
  });
  $.each(ptype, function(ptkey,ptvalue) {
    if(sevalue.PTID_REF == ptvalue.PTID)
    {
      $('#PACKSIZE_'+sekey).val(ptvalue.PTCODE+'-'+ptvalue.PTNAME);
    }
  });
});



$(function() { $('#ENQNO').focus(); });



$('#btnAdd').on('click', function() {
  var viewURL = '<?php echo e(route("transaction",[168,"add"])); ?>';
              window.location.href=viewURL;
});

$('#btnExit').on('click', function() {
  var viewURL = '<?php echo e(route('home')); ?>';
              window.location.href=viewURL;
});



});
</script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('bottom-scripts'); ?>
<script>

$(document).ready(function() {
    var d = new Date(); 
    var today = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;
    $('#ENQDT').val(today);

});





//no button
$("#NoBtn").click(function(){
    $("#alert").modal('hide');
    $("#LABEL").focus();
});

//ok button
$("#OkBtn").click(function(){
    $("#alert").modal('hide');
    $("#YesBtn").show();
    $("#NoBtn").show();
    $("#OkBtn").hide();
    $(".text-danger").hide();
    window.location.href = '<?php echo e(route("transaction",[168,"index"])); ?>';
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

</script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\transactions\sales\AnnualForecastSales\trnfrm168view.blade.php ENDPATH**/ ?>