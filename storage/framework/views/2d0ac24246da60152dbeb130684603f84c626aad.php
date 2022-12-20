<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[146,'index'])); ?>" class="btn singlebt">Company Master</a>
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
                  <div class="col-lg-1 pl"><p>Company Code</p></div>
                  <div class="col-lg-2 pl">
                  <label> <?php echo e($objResponse->CYCODE); ?> </label>
                </div>
       
		
                <div class="col-lg-1 pl"><p>Company Name</p></div>
                <div class="col-lg-2 pl">
                <label> <?php echo e($objResponse->NAME); ?> </label>
                </div>
			
                <div class="col-lg-1 pl"><p>GSTIN No</p></div>
                <div class="col-lg-1 pl"> 
                <label> <?php echo e($objResponse->GSTINNO); ?> </label>
                 
                </div>
                
                <div class="col-lg-1 pl"><p>CIN No</p></div>
                <div class="col-lg-1 pl">
                <label> <?php echo e($objResponse->CINNO); ?> </label>
                  
                </div>
                
                <div class="col-lg-1 pl"><p>PAN No</p></div>
                <div class="col-lg-1 pl ">
                <label> <?php echo e($objResponse->PANNO); ?> </label>
                 
                </div>
              </div>
			
              <div class="row">
                
              
                <div class="col-lg-2 pl"><p>Registered Address Line 1</p></div>
                <div class="col-lg-3 pl">
                <label> <?php echo e($objResponse->REGADDL1); ?> </label>
 
                
                </div>
                
                <div class="col-lg-2 pl "><p>Registered Address Line 2</p></div>
                <div class="col-lg-3 pl">
                <label> <?php echo e($objResponse->REGADDL2); ?> </label>
        
                  
                </div>
                
                <div class="col-lg-1 pl"><p>Pincode</p></div>
                  <div class="col-lg-1 pl">
                  <label> <?php echo e($objResponse->REGPINCODE); ?> </label>
             
                  </div>

              </div>
		
              <div class="row">
                
                <div class="col-lg-1 pl"><p>Country</p></div>
                <div class="col-lg-2 pl">
                <label> <?php echo e(isset($objRegCountryName->CTRYCODE)?$objRegCountryName->CTRYCODE. ' - ':''); ?>  <?php echo e(isset($objRegCountryName->NAME)?$objRegCountryName->NAME:''); ?> </label>

                </div>
                
                <div class="col-lg-1 pl"><p>State</p></div>
                <div class="col-lg-2 pl">
                <label><?php echo e(isset($objRegStateName->STCODE)?$objRegStateName->STCODE. ' - ':''); ?>  <?php echo e(isset($objRegStateName->NAME)?$objRegStateName->NAME:''); ?> </label>
    
                </div>
                
                <div class="col-lg-1 pl"><p>City</p></div>
                <div class="col-lg-2 pl">
                <label> <?php echo e(isset($objRegCityName->CITYCODE)?$objRegCityName->CITYCODE. ' - ':''); ?>  <?php echo e(isset($objRegCityName->NAME)?$objRegCityName->NAME:''); ?> </label>
     
                </div>
                
                <div class="col-lg-1 pl"><p>Landmark</p></div>
                <div class="col-lg-2 pl">
                <label> <?php echo e($objResponse->REGLM); ?> </label>
                 
                </div>
              
              </div>
		
            <div class="row">
              <div class="col-lg-2 pl"><p>Corporate Address Line 1</p></div>
              <div class="col-lg-3 pl">
              <label> <?php echo e($objResponse->CORPADDL1); ?> </label>
             
              
              </div>
              
              <div class="col-lg-2 pl"><p>Corporate Address Line 2</p></div>
              <div class="col-lg-3 pl">
              <label> <?php echo e($objResponse->CORPADDL2); ?> </label>
             
              </div>
              
              <div class="col-lg-1 pl"><p>Pincode</p></div>
                <div class="col-lg-1 pl">
                <label> <?php echo e($objResponse->CORPPINCODE); ?> </label>
                  
                </div>
              
            </div>
            
		<div class="row">
			
			<div class="col-lg-1 pl"><p>Country</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e(isset($objCorCountryName->CTRYCODE)?$objCorCountryName->CTRYCODE. ' - ':''); ?>  <?php echo e(isset($objCorCountryName->NAME)?$objCorCountryName->NAME:''); ?></label>
 
			</div>
			
			<div class="col-lg-1 pl"><p>State</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e(isset($objCorStateName->STCODE)?$objCorStateName->STCODE. ' - ':''); ?>  <?php echo e(isset($objCorStateName->NAME)?$objCorStateName->NAME:''); ?> </label>

			</div>
			
			<div class="col-lg-1 pl"><p>City</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e(isset($objCorCityName->CITYCODE)?$objCorCityName->CITYCODE. ' - ':''); ?>  <?php echo e(isset($objCorCityName->NAME)?$objCorCityName->NAME:''); ?></label>
      
			</div>
			
			<div class="col-lg-1 pl"><p>Landmark</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->CORPLM); ?> </label>
			
			</div>
		
		</div>
		
		<div class="row">
			<div class="col-lg-1 pl"><p>Email ID</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->EMAILID); ?> </label>
				
			</div>
			
			<div class="col-lg-1 pl"><p>Phone No</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->PHNO); ?> </label>
				
			</div>
			
			<div class="col-lg-1 pl"><p>Mobile No</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->MONO); ?> </label>
			
			</div>

			<div class="col-lg-1 pl"><p>Website</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->WEBSITE); ?> </label>
			
			</div>			
		</div>
		
		<div class="row">
			
			<div class="col-lg-1 pl"><p>Skype</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->SKYPEID); ?> </label>
				
			</div>
			
			<div class="col-lg-2 pl"><p>Authorised Person Name</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->AUTHPNAME); ?> </label>
			
			</div>
			
			<div class="col-lg-1 pl"><p>Designation</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->AUTHPDESG); ?> </label>
				
			</div>
			
		</div>
		
		<div class="row">
			
			
			
			<div class="col-lg-1 pl"><p>Industry Type</p></div>
			<div class="col-lg-2 pl ">
      <label> <?php echo e(isset($objIndtypeName->INDSCODE)?$objIndtypeName->INDSCODE. ' - ':''); ?>  <?php echo e(isset($objIndtypeName->DESCRIPTIONS)?$objIndtypeName->DESCRIPTIONS:''); ?> </label>

			</div>
			
			<div class="col-lg-2 pl"><p>Industry Vertical</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e(isset($objIndVerName->INDSVCODE)?$objIndVerName->INDSVCODE. ' - ':''); ?>  <?php echo e(isset($objIndVerName->DESCRIPTIONS)?$objIndVerName->DESCRIPTIONS:''); ?> </label>

			</div>
			
			<div class="col-lg-1 pl"><p>Deals In</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->DEALSIN); ?> </label>
				
			</div>
			
			<div class="col-lg-1 pl"><p>GST Type</p></div>
			<div class="col-lg-1 pl">

								<?php $__currentLoopData = $objGstTypeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$GstType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <label> <?php echo e(isset($objResponse->GSTTYPE) && $objResponse->GSTTYPE == $GstType->GSTID?$GstType->GSTCODE.' - '.$GstType->DESCRIPTIONS:''); ?> </label>


							
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			</div>
			
	</div>
	
		<div class="row">

			<div class="col-lg-2 pl"><p>Default Currency</p></div>
			<div class="col-lg-2 pl">
      
			
         
								<?php $__currentLoopData = $objCurrencyList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$Currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <label> <?php echo e(isset($objResponse->CRID_REF) && $objResponse->CRID_REF == $Currency->CRID?$Currency->CRCODE.' - '.$Currency->CRDESCRIPTION:''); ?> </label>

								
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
			</div>
			
			
			<div class="col-lg-1 pl"><p>MSME No</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->MSME_NO); ?> </label>
			
			</div>
			
			
			<div class="col-lg-1 pl"><p>Factory ACT No</p></div>
			<div class="col-lg-2 pl">
      <label> <?php echo e($objResponse->FACTORY_ACT_NO); ?> </label>
			
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
<ul class="nav nav-tabs">
<li class="active"><a data-toggle="tab" href="#ALPSSpecific">ALPS Specific</a></li>
    <li class=""><a data-toggle="tab" href="#tab1">UDF</a></li>
	<li class=""><a data-toggle="tab" href="#tab2">Logo</a></li>
</ul>



<div class="tab-content">
<div id="ALPSSpecific" class="tab-pane fade in active">                    
                    <div class="inner-form" style="margin-top:10px;">
                      <div class="row">
                        <div class="col-lg-1 pl"><p>SAP Code		</p></div>
                        <div class="col-lg-1 pl">
                        <input type="text" name="SAP_CODE" id="SAP_CODE" disabled value="<?php echo e(old('SAP_CODE',$objResponse->SAP_CODE)); ?>" class="form-control" style="text-transform:uppercase">
                        </div>
                        <div class="col-lg-1 pl"><p>ALPS Ref No			</p></div>
                        <div class="col-lg-1 pl">
                        <input type="text" name="ALPS_REFNO" id="ALPS_REFNO" disabled value="<?php echo e(old('ALPS_REFNO',$objResponse->ALPS_REFNO)); ?>" class="form-control" style="text-transform:uppercase">
                        </div>              
                      </div>                      
                    </div>
                  </div>


        <div id="tab1" class="tab-pane fade">
              <div class="table-responsive table-wrapper-scroll-y " style="margin-top:10px;height:280px;width:50%;">
                <table id="udffietable" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                  <thead id="thead1"  style="position: sticky;top: 0">
                    <tr >
                    <th>UDF Fields <input class="form-control" type="hidden" name="Row_Count4" id ="Row_Count4" value="<?php echo e($objudfCount); ?>"> </th>
                    <th>Value / Comments</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php $__currentLoopData = $objUDF; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $udfkey => $udfrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr  class="participantRow">
                    <td>
                      <input disabled name=<?php echo e("udffie_popup_".$udfkey); ?> id=<?php echo e("txtudffie_popup_".$udfkey); ?> value="<?php echo e($udfrow->LABEL); ?>" class="form-control <?php if($udfrow->ISMANDATORY==1): ?> mandatory <?php endif; ?>" autocomplete="off" maxlength="100" />
                    </td>

                    <td hidden>
                      <input disabled type="text" name='<?php echo e("udffie_".$udfkey); ?>' id='<?php echo e("hdnudffie_popup_".$udfkey); ?>' value="<?php echo e($udfrow->UDFCOID); ?>" class="form-control" maxlength="100" />
                    </td>

                    <td hidden>
                      <input disabled type="text" name=<?php echo e("udffieismandatory_".$udfkey); ?> id=<?php echo e("udffieismandatory_".$udfkey); ?> class="form-control" maxlength="100" value="<?php echo e($udfrow->ISMANDATORY); ?>" />
                    </td>

                    <td id="<?php echo e("tdinputid_".$udfkey); ?>">
                      <?php
                        $dynamicid = "udfvalue_".$udfkey;
                        $chkvaltype = strtolower($udfrow->VALUETYPE); 

                      if($chkvaltype=='date'){

                        $strinp = '<input disabled type="date" placeholder="dd/mm/yyyy" name="'.$dynamicid.'" id="'.$dynamicid.'" class="form-control" value="'.$udfrow->UDF_VALUE.'" /> ';       

                      }else if($chkvaltype=='time'){

                          $strinp= '<input disabled type="time" placeholder="h:i" name="'.$dynamicid.'" id="'.$dynamicid.'" class="form-control"  value="'.$udfrow->UDF_VALUE.'"/> ';

                      }else if($chkvaltype=='numeric'){
                      $strinp = '<input disabled type="text" name="'.$dynamicid. '" id="'.$dynamicid.'" class="form-control" value="'.$udfrow->UDF_VALUE.'"/> ';

                      }else if($chkvaltype=='text'){

                      $strinp = '<input disabled type="text" name="'.$dynamicid. '" id="'.$dynamicid.'" class="form-control" value="'.$udfrow->UDF_VALUE.'"/> ';

                      }else if($chkvaltype=='boolean'){
                          $boolval = ''; 
                          if($udfrow->UDF_VALUE=='on' || $udfrow->UDF_VALUE=='1' ){
                            $boolval="checked";
                          }
                          $strinp = '<input disabled type="checkbox" name="'.$dynamicid. '" id="'.$dynamicid.'" class=""  '.$boolval.' /> ';

                      }else if($chkvaltype=='combobox'){
                        $strinp='';
                        $txtoptscombo =   strtoupper($udfrow->DESCRIPTIONS); ;
                        $strarray =  explode(',',$txtoptscombo);
                        $opts = '';
                        $chked='';
                          for ($i = 0; $i < count($strarray); $i++) {
                            $chked='';
                            if($strarray[$i]==$udfrow->UDF_VALUE){
                              $chked='selected="selected"';
                            }
                            $opts = $opts.'<option value="'.$strarray[$i].'"'.$chked.'  >'.$strarray[$i].'</option> ';
                          }

                        $strinp = '<select disabled name="'.$dynamicid.'" id="'.$dynamicid.'" class="form-control" >'.$opts.'</select>' ;
                      }
                      echo $strinp;
                      ?>
                    </td>                   
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                  </tbody>
                </table>
              </div>
            </div>
	
	<div id="tab2" class="tab-pane fade">
		<div class="table-wrapper-scroll-x" style="margin-top:10px;">
			<div class="row">
				<div class="col-lg-2 "><p>Company Logo </p></div>

        <div class="col-lg-3 ">
        <?php if($objResponse->LOGO !=""): ?>
          <img src="<?php echo e(asset($objResponse->LOGO)); ?>" style="width:100px;" > 
        <?php endif; ?>  
       
          
				</div>
			</div>	
		</div>
    </div>
	
	
  </div>

</div>





                
              
          

          </div>

    </div><!--purchase-order-view-->

    <script>
     $('#btnAdd').on('click', function() {
      var viewURL = '<?php echo e(route("master",[146,"add"])); ?>';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Common\CompanyMaster\mstfrm146view.blade.php ENDPATH**/ ?>