<?php $__env->startSection('content'); ?>

<div class="container-fluid topnav">
	<div class="row">
		<div class="col-lg-2"><a href="<?php echo e(route('master',[48,'index'])); ?>" class="btn singlebt">Vendor Master</a></div>

		<div class="col-lg-10 topnav-pd">
		  <button  id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
      <button class="btn topnavbt"  disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
      <button id="btnSaveItem"     class="btn topnavbt" tabindex="7" disabled="disabled"><i class="fa fa-save"></i> Save</button>
      <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
      <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
      <button class="btn topnavbt" id="btnUndo"  disabled="disabled"><i class="fa fa-undo" disabled="disabled"></i> Undo</button>
      <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
      <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-lock"></i> Approved</button>
      <button class="btn topnavbt" id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
      <a href="<?php echo e(route('home')); ?>" class="btn topnavbt"><i class="fa fa-power-off"></i> Exit</a>
		</div>
	</div>
</div>

<div class="container-fluid filter">
	<form id="add_form_data" method="POST"  > 
    <?php echo csrf_field(); ?>  
    <?php echo e(isset($objMstCust->VID) ? method_field('PUT') : ''); ?>

		<div class="inner-form">
    
			<div class="row">
				<div class="col-lg-2 pl"><p>Vendor Code</p></div>
				<div class="col-lg-2 pl">
          <label><?php echo e($objMstCust->VCODE); ?></label>
				</div>
			  
				<div class="col-lg-2 pl"><p>Name</p></div>
				<div class="col-lg-2 pl">
          <label><?php echo e($objMstCust->NAME); ?></label>
        </div>
				
				<div class="col-lg-2 pl"><p>Vendor Legal Name</p></div>
				<div class="col-lg-2 pl">
          <label><?php echo e($objMstCust->VENDOR_LEGAL_NAME); ?></label>
        </div>
			</div>
			
			<div class="row">
				<div class="col-lg-2 pl"><p>Vendor Group</p></div>
				<div class="col-lg-2 pl">
					<label><?php echo e($objCusGro->VGCODE); ?> - <?php echo e($objCusGro->DESCRIPTIONS); ?></label>
				</div>
			  
			  <div class="col-lg-2 pl"><p>OLD Ref Code</p></div>
			  <div class="col-lg-2 pl">
				  <label><?php echo e($objMstCust->OLDREF_CODE); ?></label>
			  </div>
			  
			  <div class="col-lg-2 pl"><p>GL</p></div>
			  <div class="col-lg-2 pl">
				<label><?php echo e(isset($objOldGlList->GLCODE) ?  $objOldGlList->GLCODE.'-'.$objOldGlList->GLNAME :''); ?></label>
			  </div>
			  
			</div>

      
			
			<div class="row">
				<div class="col-lg-2 pl"><p>Registered Address Line 1</p></div>
				<div class="col-lg-2 pl">
					<label><?php echo e($objMstCust->REGADDL1); ?></label>
        </div>
				
					<div class="col-lg-2 pl"><p>Registered Address Line 2</p></div>
				<div class="col-lg-2 pl">
					<label><?php echo e($objMstCust->REGADDL2); ?></label>
				</div>

        <div class="col-lg-2 pl"><p>CHA</p></div>
				<div class="col-lg-2 pl">
					<input disabled type="checkbox" name="CHA" id="CHA" value="1" <?php echo e(isset($objMstCust->CHA) && $objMstCust->CHA =='1'?'checked':''); ?>   autocomplete="off">
				</div>
			
			</div>
				
		<div class="row">
			
			<div class="col-lg-2 pl"><p>Country</p></div>
			<div class="col-lg-2 pl">
			<label><?php echo e($objRegCountry->CTRYCODE); ?> - <?php echo e($objRegCountry->NAME); ?></label>
			</div>
			
			<div class="col-lg-1 pl"><p>State</p></div>
			<div class="col-lg-2 pl">
			<label><?php echo e($objRegState->STCODE); ?> - <?php echo e($objRegState->NAME); ?> </label>
			</div>
		
			<div class="col-lg-1 pl"><p>City</p></div>
			<div class="col-lg-2 pl">
				<label><?php echo e($objRegCity->CITYCODE); ?> - <?php echo e($objRegCity->NAME); ?></label>
			</div>
			
				
			<div class="col-lg-1 pl"><p>Pincode</p></div>
			<div class="col-lg-1 pl">
			<label><?php echo e($objMstCust->REGPIN); ?></label>
			</div>
		
    </div>
    
    <div class="row">
      <div class="col-lg-1 pl"><p>De-Activated</p></div>
      <div class="col-lg-1 pl pr">
      <input type="checkbox"   name="DEACTIVATED"  id="deactive-checkbox_0" <?php echo e($objMstCust->DEACTIVATED == 1 ? "checked" : ""); ?>

       value='<?php echo e($objMstCust->DEACTIVATED == 1 ? 1 : 0); ?>' disabled >
      </div>
      
      <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
      <div class="col-lg-2 pl">
      <div class="col-lg-8 pl"><?php echo e((!is_null($objMstCust->DODEACTIVATED) && $objMstCust->DODEACTIVATED!='1900-01-01')? 
        \Carbon\Carbon::parse($objMstCust->DODEACTIVATED)->format('d/m/Y') : ''); ?>

      </div>
      </div>
   </div>
    
	</div>
		
		
	<div class="container-fluid">

		<div class="row">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#material">Contact</a></li>
				<li><a data-toggle="tab" href="#statutory">Statutory</a></li>
				<li><a data-toggle="tab" href="#poc">Point of Contact</a></li>
				<li><a data-toggle="tab" href="#bank">Bank</a></li>
				<li><a data-toggle="tab" href="#location">Location</a></li>
        <li><a data-toggle="tab" href="#ALPSSpecific"><?php echo e(isset($TabSetting->TAB_NAME) && $TabSetting->TAB_NAME !=''?$TabSetting->TAB_NAME:'Additional Info'); ?></a></li>
				<li><a data-toggle="tab" href="#udf">UDF</a></li>
			</ul>

			<div class="tab-content">
				<div id="material" class="tab-pane fade in active">
					<div class="table-wrapper-scroll-x">
						<div class="row" style="margin-top:10px;">
								
							<div class="col-lg-2"><p>Corporate Address Line 1</p></div>
							<div class="col-lg-4">
								<label><?php echo e($objMstCust->CORPADDL1); ?></label>
							</div>
							
							<div class="col-lg-2"><p>Corporate Address Line 2</p></div>
							<div class="col-lg-4">
								<label><?php echo e($objMstCust->CORPADDL2); ?></label>
							</div>
							
						</div>
						
						<div class="row">
							<div class="col-lg-2"><p>Country</p></div>
							<div class="col-lg-2">	
							  <label><?php if(isset($objCorpCountry)): ?><?php echo e($objCorpCountry->CTRYCODE); ?> - <?php echo e($objCorpCountry->NAME); ?> <?php endif; ?> </label>
							</div>
							
							<div class="col-lg-2"><p>State</p></div>
							<div class="col-lg-2">		
								<label><?php if(isset($objCorpState)): ?><?php echo e($objCorpState->STCODE); ?> - <?php echo e($objCorpState->NAME); ?><?php endif; ?></label>
							</div>
							
							<div class="col-lg-2"><p>City</p></div>
							<div class="col-lg-2">
							<label><?php if(isset($objCorpCity)): ?><?php echo e($objCorpCity->CITYCODE); ?> - <?php echo e($objCorpCity->NAME); ?><?php endif; ?></label>
							</div>
					
						</div>
				
				
					<div class="row">
					
							
					<div class="col-lg-2"><p>Pincode</p></div>
					<div class="col-lg-2">
						<label><?php echo e($objMstCust->CORPPIN); ?></label>
					</div>
					
						<div class="col-lg-2"><p>Email ID</p></div>
						<div class="col-lg-2">
							<label><?php echo e($objMstCust->EMAILID); ?></label>
						</div>
						
						<div class="col-lg-2"><p>Website</p></div>
						<div class="col-lg-2">
							<label><?php echo e($objMstCust->WEBSITE); ?></label>
						</div>
						
							
					</div>
					
					<div class="row">
					<div class="col-lg-2 "><p>Phone No</p></div>
						<div class="col-lg-2">
							<label><?php echo e($objMstCust->PHNO); ?></label>
						</div>
						
						<div class="col-lg-2"><p>Mobile No</p></div>
						<div class="col-lg-2">
							<label><?php echo e($objMstCust->MONO); ?></label>
						</div>
						
						<div class="col-lg-2"><p>Contact Person</p></div>
						<div class="col-lg-2 ">
							<label><?php echo e($objMstCust->CPNAME); ?></label>
						</div>
						
						
						
					</div>
					
					<div class="row">
					<div class="col-lg-2 "><p>Skype</p></div>
						<div class="col-lg-2">
							<label><?php echo e($objMstCust->SKYPEID); ?></label>
						</div>
					</div>
					
			</div>
				</div>
				
				<div id="statutory" class="tab-pane fade"> 
				
					 <div class="table-wrapper-scroll-x" style="margin-top:10px;">
					
						<div class="row" >
					
						<div class="col-lg-2"><p>Industry Type</p></div>
						<div class="col-lg-2">
							<label><?php if(isset($objIndType)): ?><?php echo e($objIndType->INDSCODE); ?> - <?php echo e($objIndType->DESCRIPTIONS); ?><?php endif; ?></label>
						</div>
						
						<div class="col-lg-2"><p>Industry Vertical</p></div>
						<div class="col-lg-2">
							<label><?php if(isset($objIndVer)): ?><?php echo e($objIndVer->INDSVCODE); ?> - <?php echo e($objIndVer->DESCRIPTIONS); ?><?php endif; ?> </label>
						</div>
						
						<div class="col-lg-1"><p>Deals In</p></div>
						<div class="col-lg-2">
							<label><?php echo e($objMstCust->DEALSIN); ?></label>
						</div>
						
						</div>
					
					<div class="row">
						
						<div class="col-lg-2"><p>GST Type</p></div>
						<div class="col-lg-2">
							<select name="GSTTYPE" id="GSTTYPE" class="form-control mandatory" disabled >
								<option value="" selected >Select</option>
								
								<?php $__currentLoopData = $objGstTypeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$GstType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($GstType-> GSTID); ?>" <?php if($objMstCust->GSTTYPE==$GstType-> GSTID): ?> selected <?php endif; ?>) ><?php echo e($GstType->GSTCODE); ?> - <?php echo e($GstType->DESCRIPTIONS); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	
							</select>
						</div>
						


						<div class="col-lg-2"><p>Default Currency</p></div>
						<div class="col-lg-2">
							<select name="DEFCRID_REF" id="DEFCRID_REF"  class="form-control mandatory" disabled  >
								<option value="" selected >Select</option>
								<?php $__currentLoopData = $objCurrencyList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$Currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($Currency-> CRID); ?>"  <?php if($objMstCust->DEFCRID_REF==$Currency-> CRID): ?> selected <?php endif; ?>) >
                  <?php echo e($Currency->CRCODE); ?> - <?php echo e($Currency->CRDESCRIPTION); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						
						<div class="col-lg-1"><p>GSTIN</p></div>
						<div class="col-lg-2">
							<label></label><?php echo e($objMstCust->GSTIN); ?><label>
						</div>
						
						</div>
					
					
				
				<div class="row">
					<div class="col-lg-2"><p>Credit Limit</p></div>
						<div class="col-lg-2">
							<label><?php echo e($objMstCust->CREDITLIMIT); ?></label>
						</div>
						
						<div class="col-lg-2"><p>CIN </p></div>
						<div class="col-lg-2">
							<label><?php echo e($objMstCust->CIN); ?></label>
						</div>
						
						<div class="col-lg-1"><p>Credit Days </p></div>
						<div class="col-lg-1">
							<label><?php echo e($objMstCust->CREDITDAY); ?></label>
						</div>
						
						
						

				</div>
				
				<div class="row">
			    	<div class="col-lg-2"><p>PAN No </p></div>
						<div class="col-lg-2">
							<label><?php echo e($objMstCust->PANNO); ?></label>
            </div>
            <div class="col-lg-2 "><p>Exceptional for GST</p></div>
            <div class="col-lg-2"><input type="checkbox" name="EXE_GST" id="EXE_GST" class="filter-none"  <?php echo e($objMstCust->EXE_GST == 1 ? "checked" : ""); ?>  value='<?php echo e($objMstCust->EXE_GST == 1 ? 1 : 0); ?>' disabled> </div>
				</div>

        <div class="row">
        <div class="col-lg-2"><p>MSME No </p></div>
          <div class="col-lg-2">
          <label><?php echo e($objMstCust->MSMENO); ?></label>
          </div>
          <div class="col-lg-2"><p>Factory No</p></div>
          <div class="col-lg-2">
          <label><?php echo e($objMstCust->FACTORY_NO); ?></label>
            
          </div>
						</div>
				
        <div class="row">
          <div class="col-lg-2"><p>TDS Applicable</p></div>
          <div class="col-lg-2">
            <input disabled type="checkbox" name="TDS_APPLICABLE" id="TDS_APPLICABLE" value="1" onChange="TdsApplicable()" <?php echo e(isset($objMstCust->TDS_APPLICABLE) && $objMstCust->TDS_APPLICABLE ==1?'checked':''); ?> >
          </div>
        </div>

        <div class="row TDS_ACTION" style="display:none;">
          <div class="col-lg-2"><p>Certificate Number</p></div>
          <div class="col-lg-2">
            <input disabled type="text" name="CERTIFICATE_NO" id="CERTIFICATE_NO" value="<?php echo e($objMstCust->CERTIFICATE_NO); ?>" class="form-control"  maxlength="30"  autocomplete="off">
          </div>

          <div class="col-lg-2"><p>Expiry Date</p></div>
          <div class="col-lg-2">
            <input disabled type="date" name="EXPIRY_DT" id="EXPIRY_DT" value="<?php echo e($objMstCust->EXPIRY_DT); ?>" class="form-control"   autocomplete="off">
          </div>
        </div>

        <div class="row TDS_ACTION" style="display:none;">
          <div class="col-lg-2"><p>Assessee Type</p></div>
          <div class="col-lg-2">
            <select disabled  name="ASSESSEEID_REF" id="ASSESSEEID_REF" class="form-control mandatory" autocomplete="off" onChange="getTdsCode(this.value)" >
            <option value="">Select</option>
              <?php if(!empty($objAssesseeTypeList)): ?>
              <?php $__currentLoopData = $objAssesseeTypeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option <?php echo e(isset($objMstCust->ASSESSEEID_REF) && $objMstCust->ASSESSEEID_REF ==$val->NOAID?'selected="selected"':''); ?> value="<?php echo e($val->NOAID); ?>"><?php echo e($val->NOA_CODE); ?> - <?php echo e($val->NOA_NAME); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </select>
          </div>
          
          <div class="col-lg-2"><p>TDS Code</p></div>
          <div class="col-lg-2">
            <input disabled type="text" name="HOLDINGID_REF_POPUP" id="HOLDINGID_REF_POPUP" class="form-control mandatory" readonly  />
            <input type="hidden" name="HOLDINGID_REF" id="HOLDINGID_REF" value="<?php echo e($objMstCust->HOLDINGID_REF); ?>" />
            <span class="text-danger" id="ERROR_HOLDINGID_REF"></span>
          </div>
        </div>
				
			</div>
			</div>
				
			<div id="poc" class="tab-pane fade">

				<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:250px;margin-top:10px;" >
					 
					<table id="table1" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
					 
            <thead id="thead1"  style="position: sticky;top: 0">						
              <tr>
								<th>Person Name <input class="form-control" type="hidden" name="Row_Count1" id ="Row_Count1" value="<?php echo e($objPOCCount); ?>"> </th>
								<th>Designation</th>
								<th>Mobile</th>
								<th>Email</th>
								<th>LL No</th>
								<th>Authority Level</th>
								<th>Birthday</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($objPOC)): ?>
                <?php $__currentLoopData = $objPOC; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr  class="participantRow">
                  <td><input  class="form-control w-100" type="text" name="POC_NAME_<?php echo e($key); ?>" id="POC_NAME_<?php echo e($key); ?>" value="<?php echo e($row->NAME); ?>" maxlength="100" disabled></td>
                  <td><input  class="form-control w-100" type="text" name="POC_DESIG_<?php echo e($key); ?>" id="POC_DESIG_<?php echo e($key); ?>" value="<?php echo e($row->DESIG); ?>" maxlength="50" disabled></td>
                  <td><input  class="form-control w-100" type="text" name="POC_MONO_<?php echo e($key); ?>" id="POC_MONO_<?php echo e($key); ?>" value="<?php echo e($row->MONO); ?>"  maxlength="20" disabled></td>
                  <td><input  class="form-control w-100" type="text" name="POC_EMAIL_<?php echo e($key); ?>" id="POC_EMAIL_<?php echo e($key); ?>" value="<?php echo e($row->EMAIL); ?>"  maxlength="50" disabled></td>
                  <td><input  class="form-control w-100" type="text" name="POC_LLNO_<?php echo e($key); ?>" id="POC_LLNO_<?php echo e($key); ?>" value="<?php echo e($row->LLNO); ?>"  maxlength="20" disabled></td>
                  <td><input  class="form-control w-100" type="text" name="POC_AUTHLEVEL_<?php echo e($key); ?>" id="POC_AUTHLEVEL_<?php echo e($key); ?>" value="<?php echo e($row->AUTHLEVEL); ?>"  maxlength="30" disabled></td>
                  <td style="text-align:center;" ><input type="date" placeholder="dd/mm/yyyy"  name="POC_DOB_<?php echo e($key); ?>" id="POC_DOB_<?php echo e($key); ?>" value="<?php echo e((!is_null($row->DOB) && $row->DOB!='1900-01-01')? $row->DOB : ''); ?>" class="form-control" disabled></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>
                <tr  class="participantRow">
                  <td><input  class="form-control w-100" type="text" name="POC_NAME_0" id="POC_NAME_0" maxlength="100" disabled></td>
                  <td><input  class="form-control w-100" type="text" name="POC_DESIG_0" id="POC_DESIG_0" maxlength="50" disabled></td>
                  <td><input  class="form-control w-100" type="text" name="POC_MONO_0" id="POC_MONO_0" maxlength="20" disabled></td>
                  <td><input  class="form-control w-100" type="text" name="POC_EMAIL_0" id="POC_EMAIL_0" maxlength="50" disabled></td>
                  <td><input  class="form-control w-100" type="text" name="POC_LLNO_0" id="POC_LLNO_0" maxlength="20" disabled></td>
                  <td><input  class="form-control w-100" type="text" name="POC_AUTHLEVEL_0" id="POC_AUTHLEVEL_0" maxlength="30" disabled></td>
                  <td style="text-align:center;" ><input type="date" name="POC_DOB_0" id="POC_DOB_0" class="form-control" disabled ></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
				</div>
			</div>
				
				<div id="bank" class="tab-pane fade">
				  <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"  style="height:250px;margin-top:10px;" >
					
					<table id="table2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
            <thead id="thead1"  style="position: sticky;top: 0">
              <tr >
                <th>Bank Name <input class="form-control" type="hidden" name="Row_Count2" id ="Row_Count2" value="<?php echo e($objBANKCount); ?>"></th>
                <th>IFSC</th>
                <th>Branch</th>
                <th>Account Type</th>
                <th>Account No</th>
                <th>Default Bank</th>
              </tr>
            </thead>
            <tbody>
            <?php if(!empty($objBANK)): ?>
             <?php $__currentLoopData = $objBANK; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr class="participantRow">
                <td><input  class="form-control w-100" type="text" name="BANK_NAME_<?php echo e($key); ?>" id="BANK_NAME_<?php echo e($key); ?>" maxlength="100" value="<?php echo e($row->NAME); ?>" disabled></td>
                <td><input  class="form-control w-100" type="text" name="BANK_IFSC_<?php echo e($key); ?>" id="BANK_IFSC_<?php echo e($key); ?>" value="<?php echo e($row->IFSC); ?>" maxlength="20" disabled></td>
                <td><input  class="form-control w-100" type="text" name="BANK_BRANCH_<?php echo e($key); ?>" id="BANK_BRANCH_<?php echo e($key); ?>" value="<?php echo e($row->BRANCH); ?>" maxlength="100" disabled></td>
                <td>
                  <select name="BANK_ACTYPE_<?php echo e($key); ?>" id="BANK_ACTYPE_<?php echo e($key); ?>" class="form-control"  disabled>
                    <option value="" >Select</option>
                    <?php $__currentLoopData = $account_type_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atkey=>$atval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($atval); ?>"  <?php if($row->ACTYPE==$atval): ?> selected <?php endif; ?> )><?php echo e($atval); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>      
                  </select>
                </td>
                <td>
                  <input  class="form-control w-100" type="text" name="BANK_ACNO_<?php echo e($key); ?>" id="BANK_ACNO_<?php echo e($key); ?>" value="<?php echo e($row->ACNO); ?>" maxlength="30" disabled></td>
                <td align="center" ><input type="checkbox" name="BYDEFALUT_<?php echo e($key); ?>" id="BYDEFALUT_<?php echo e($key); ?>" class="filter-none"  value="1" <?php echo e(($row->BYDEFAULT == 1 || $row->BYDEFAULT=='on')?'checked':''); ?> disabled></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
              <tr class="participantRow">
                <td><input  class="form-control w-100" type="text" name="BANK_NAME_0" id="BANK_NAME_0" maxlength="100" ></td>
                <td><input  class="form-control w-100" type="text" name="BANK_IFSC_0" id="BANK_IFSC_0" maxlength="20" ></td>
                <td><input  class="form-control w-100" type="text" name="BANK_BRANCH_0" id="BANK_BRANCH_0" maxlength="100" ></td>
                <td>
                  <select name="BANK_ACTYPE_0" id="BANK_ACTYPE_0" class="form-control"  >
                    <option value="" selected >Select</option>
                    <?php $__currentLoopData = $account_type_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>      
                  </select>
                </td>
                <td><input  class="form-control w-100" type="text" name="BANK_ACNO_0" id="BANK_ACNO_0" maxlength="30" ></td>
                <td align="center" ><input type="checkbox" name="BYDEFALUT_0" id="BYDEFALUT_0" class="filter-none"  value="1" ></td>
              </tr>
            <?php endif; ?>
            </tbody>
				  </table>
				 
			</div>
				</div>
				
				<div id="location" class="tab-pane fade">
				  <div class="table-responsive table-wrapper-scroll-y " style="height:260px;margin-top:10px;">
					
					<table id="table3" class="display nowrap table table-striped table-bordered itemlist itemlistscroll w-200" style="height:auto !important;">
            <thead id="thead1"  style="position: sticky;top: 0">
              <tr >
                <th>Location Name <input class="form-control" type="hidden" name="Row_Count3" id ="Row_Count3" value="<?php echo e($objLOCCount); ?>"></th>
                <th>Location Address</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Pincode</th>
                <th>GSTIN</th>
                <th>Contact Person Name</th>
                <th>Designation</th>
                <th>Email ID</th>
                <th>Mobile No</th>
                <th>Special Instructions</th>
                <th>Bill To</th>
                <th>Default Billing</th>
                <th>Ship To</th>
                <th>Default Shipping</th>
              </tr>
            </thead>
            <tbody>
            <?php if(!empty($objLOC)): ?>
              <?php $__currentLoopData = $objLOC; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr  class="participantRow">
                <td><input  class="form-control w-100" type="text" name="LOC_NAME_<?php echo e($key); ?>" id="LOC_NAME_<?php echo e($key); ?>" value="<?php echo e($row->NAME); ?>"  maxlength="50" disabled></td>
                <td><input  class="form-control w-100" type="text" name="LOC_LADD_<?php echo e($key); ?>" id="LOC_LADD_<?php echo e($key); ?>" value="<?php echo e($row->LADD); ?>" maxlength="200" disabled ></td>

                <td><input  class="form-control w-100" type="text" name="LOC_CTRYID_REF_<?php echo e($key); ?>" id="TXTLOC_CTRYID_REF_POPUP_<?php echo e($key); ?>" value="<?php echo e($row->COU_CTRYCODE); ?> - <?php echo e($row->COU_NAME); ?>" maxlength="100"  disabled></td>
                <td hidden><input  class="form-control w-100" type="text" name="HDNLOC_CTRYID_REF_<?php echo e($key); ?>" id="HDNLOC_CTRYID_REF_POPUP_<?php echo e($key); ?>" value="<?php echo e($row->COU_CTRYID); ?>" maxlength="100" disabled></td>

                <td><input  class="form-control w-100" type="text" name="LOC_STID_REF_<?php echo e($key); ?>" id="TXTLOC_STID_REF_POPUP_<?php echo e($key); ?>" value="<?php echo e($row->STA_STCODE); ?> - <?php echo e($row->STA_NAME); ?>" maxlength="100" disabled></td>
                <td hidden><input  class="form-control w-100" type="text" name="HDNLOC_STID_REF_<?php echo e($key); ?>" id="HDNLOC_STID_REF_POPUP_<?php echo e($key); ?>" value="<?php echo e($row->STA_STID); ?>" maxlength="100" disabled></td>

                <td><input  class="form-control w-100" type="text" name="LOC_CITYID_REF_<?php echo e($key); ?>" id="TXTLOC_CITYID_REF_POPUP_<?php echo e($key); ?>" value="<?php echo e($row->CIT_CITYCODE); ?> - <?php echo e($row->CIT_NAME); ?>" maxlength="100" disabled></td>
                <td hidden><input  class="form-control w-100" type="text" name="HDNLOC_CITYID_REF_<?php echo e($key); ?>" value="<?php echo e($row->CIT_CITYID); ?>" id="HDNLOC_CITYID_REF_POPUP_<?php echo e($key); ?>" maxlength="100" disabled></td>


                <td><input  class="form-control w-100" type="text" name="LOC_PIN_<?php echo e($key); ?>" id="LOC_PIN_<?php echo e($key); ?>" maxlength="20" value="<?php echo e($row->PIN); ?>" disabled></td>
                <td><input  class="form-control w-100" type="text" name="LOC_GSTIN_<?php echo e($key); ?>" id="LOC_GSTIN_<?php echo e($key); ?>" maxlength="30" value="<?php echo e($row->GSTIN); ?>" disabled ></td>
                <td><input  class="form-control w-100" type="text" name="LOC_CPNAME_<?php echo e($key); ?>" id="LOC_CPNAME_<?php echo e($key); ?>" maxlength="30" value="<?php echo e($row->CPNAME); ?>" disabled ></td>
                <td><input  class="form-control w-100" type="text" name="LOC_CPDESIGNATION_<?php echo e($key); ?>" id="LOC_CPDESIGNATION_<?php echo e($key); ?>" maxlength="20" value="<?php echo e($row->CPDESIGNATION); ?>" disabled ></td>
                <td><input  class="form-control w-100" type="text" name="LOC_EMAIL_<?php echo e($key); ?>" id="LOC_EMAIL_<?php echo e($key); ?>" maxlength="30" value="<?php echo e($row->EMAIL); ?>" disabled></td>
                <td><input  class="form-control w-100" type="text" name="LOC_MONO_<?php echo e($key); ?>" id="LOC_MONO_<?php echo e($key); ?>" maxlength="20" value="<?php echo e($row->MONO); ?>" disabled></td>
                <td><input  class="form-control w-100" type="text" name="LOC_SPECIAL_INS_<?php echo e($key); ?>" id="LOC_SPECIAL_INS_<?php echo e($key); ?>" maxlength="50" value="<?php echo e($row->SPECIAL_INS); ?>"  disabled></td>
                
                <td style="text-align:center;" ><input type="checkbox" name="LOC_BILLTO_<?php echo e($key); ?>" id="LOC_BILLTO_<?php echo e($key); ?>" class="filter-none"  value="1" <?php echo e(($row->BILLTO == 1 || $row->BILLTO=='on')?'checked':''); ?> disabled></td>
                <td style="text-align:center;" ><input type="checkbox" name="LOC_DEFAULT_BILLTO_<?php echo e($key); ?>" id="LOC_DEFAULT_BILLTO_<?php echo e($key); ?>" class="filter-none"  value="1" <?php echo e(($row->DEFAULT_BILLING == 1 || $row->DEFAULT_BILLING=='on')?'checked':''); ?> disabled ></td>
                <td style="text-align:center;" ><input type="checkbox" name="LOC_SHIPTO_<?php echo e($key); ?>" id="LOC_SHIPTO_<?php echo e($key); ?>" class="filter-none"  value="1" <?php echo e(($row->SHIPTO == 1 || $row->SHIPTO=='on')?'checked':''); ?> disabled></td>
                <td style="text-align:center;" ><input type="checkbox" name="LOC_DEFAULT_SHIPTO_<?php echo e($key); ?>" id="LOC_DEFAULT_SHIPTO_<?php echo e($key); ?>" class="filter-none"  value="1" <?php echo e(($row->DEFAULT_SHIPPING == 1 || $row->DEFAULT_SHIPPING=='on')?'checked':''); ?> disabled></td>
                
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php else: ?> 
            <tr  class="participantRow">
              <td><input  class="form-control w-100" type="text" name="LOC_NAME_0" id="LOC_NAME_0" maxlength="50" disabled></td>
              <td><input  class="form-control w-100" type="text" name="LOC_LADD_0" id="LOC_LADD_0" maxlength="200" disabled></td>

              <td><input  class="form-control w-100" type="text" name="LOC_CTRYID_REF_0" id="TXTLOC_CTRYID_REF_POPUP_0" maxlength="100" disabled></td>
              <td hidden><input  class="form-control w-100" type="text" name="HDNLOC_CTRYID_REF_0" id="HDNLOC_CTRYID_REF_POPUP_0" maxlength="100" ></td>

              <td><input  class="form-control w-100" type="text" name="LOC_STID_REF_0" id="TXTLOC_STID_REF_POPUP_0" maxlength="100" disabled></td>
              <td hidden><input  class="form-control w-100" type="text" name="HDNLOC_STID_REF_0" id="HDNLOC_STID_REF_POPUP_0" maxlength="100" readonly></td>

              <td><input  class="form-control w-100" type="text" name="LOC_CITYID_REF_0" id="TXTLOC_CITYID_REF_POPUP_0" maxlength="100" disabled></td>
              <td hidden><input  class="form-control w-100" type="text" name="HDNLOC_CITYID_REF_0" id="HDNLOC_CITYID_REF_POPUP_0" maxlength="100" readonly></td>


              <td><input  class="form-control w-100" type="text" name="LOC_PIN_0" id="LOC_PIN_0" maxlength="20" disabled></td>
              <td><input  class="form-control w-100" type="text" name="LOC_GSTIN_0" id="LOC_GSTIN_0" maxlength="30" disabled></td>
              <td><input  class="form-control w-100" type="text" name="LOC_CPNAME_0" id="LOC_CPNAME_0" maxlength="30" disabled ></td>
              <td><input  class="form-control w-100" type="text" name="LOC_CPDESIGNATION_0" id="LOC_CPDESIGNATION_0" maxlength="20" disabled></td>
              <td><input  class="form-control w-100" type="text" name="LOC_EMAIL_0" id="LOC_EMAIL_0" maxlength="30" disabled></td>
              <td><input  class="form-control w-100" type="text" name="LOC_MONO_0" id="LOC_MONO_0" maxlength="20" disabled></td>
              <td><input  class="form-control w-100" type="text" name="LOC_SPECIAL_INS_0" id="LOC_SPECIAL_INS_0" maxlength="50" disabled></td>
              
              <td style="text-align:center;" ><input type="checkbox" name="LOC_BILLTO_0" id="LOC_BILLTO_0" class="filter-none"  value="1" disabled></td>
              <td style="text-align:center;" ><input type="checkbox" name="LOC_DEFAULT_BILLTO_0" id="LOC_DEFAULT_BILLTO_0" class="filter-none"  value="1" disabled></td>
              <td style="text-align:center;" ><input type="checkbox" name="LOC_SHIPTO_0" id="LOC_SHIPTO_0" class="filter-none"  value="1" disabled></td>
              <td style="text-align:center;" ><input type="checkbox" name="LOC_DEFAULT_SHIPTO_0" id="LOC_DEFAULT_SHIPTO_0" class="filter-none"  value="1" disabled></td>

            </tr>
            <?php endif; ?>  
            </tbody>
				  </table>
				
			</div>
				</div>

        <div id="ALPSSpecific" class="tab-pane fade">
                    
                    <div class="inner-form" style="margin-top:10px;">
                      <div class="row">
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD1) && $TabSetting->FIELD1 !=''?$TabSetting->FIELD1:'Add. Vendor Code'); ?></p></div>
                        <div class="col-lg-1 pl">
                        <input type="text" name="SAP_VENDOR_CODE" id="SAP_VENDOR_CODE" disabled value="<?php echo e($objMstCust->SAP_VENDOR_CODE); ?>" class="form-control" style="text-transform:uppercase">
                        </div>
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD2) && $TabSetting->FIELD2 !=''?$TabSetting->FIELD2:'Add. Vendor Name1'); ?></p></div>
                        <div class="col-lg-2 pl">
                        <input type="text" name="SAP_VENDOR_NAME1" id="SAP_VENDOR_NAME1" disabled value="<?php echo e($objMstCust->SAP_VENDOR_NAME1); ?>" class="form-control">
                        </div>
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD3) && $TabSetting->FIELD3 !=''?$TabSetting->FIELD3:'Add. Vendor Name2'); ?></p></div>
                        <div class="col-lg-2 pl">
                        <input type="text" name="SAP_VENDOR_NAME2" id="SAP_VENDOR_NAME2" disabled value="<?php echo e($objMstCust->SAP_VENDOR_NAME2); ?>" class="form-control">
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD4) && $TabSetting->FIELD4 !=''?$TabSetting->FIELD4:'Add. Vendor Name3'); ?></p></div>
                        <div class="col-lg-1 pl">
                        <input type="text" name="SAP_VENDOR_NAME3" id="SAP_VENDOR_NAME3" disabled value="<?php echo e($objMstCust->SAP_VENDOR_NAME3); ?>" class="form-control" >
                        </div>
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD5) && $TabSetting->FIELD5 !=''?$TabSetting->FIELD5:'Add. Corporate Group'); ?></p></div>
                        <div class="col-lg-2 pl">
                        <input type="text" name="SAP_CORPORATE_GROUP" id="SAP_CORPORATE_GROUP" disabled value="<?php echo e($objMstCust->SAP_CORPORATE_GROUP); ?>" class="form-control">
                        </div>
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD6) && $TabSetting->FIELD6 !=''?$TabSetting->FIELD6:'Add. Account Group'); ?></p></div>
                        <div class="col-lg-2 pl">
                        <input type="text" name="SAP_ACCOUNT_GROUP" id="SAP_ACCOUNT_GROUP" disabled value="<?php echo e($objMstCust->SAP_ACCOUNT_GCODE); ?>" class="form-control" >
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD7) && $TabSetting->FIELD7 !=''?$TabSetting->FIELD7:'Add. Account Group Name'); ?></p></div>
                        <div class="col-lg-1 pl">
                        <input type="text" name="SAP_ACCOUNT_GROUP_NAME" id="SAP_ACCOUNT_GROUP_NAME" disabled value="<?php echo e($objMstCust->SAP_ACCOUNT_GNAME); ?>" class="form-control" >
                        </div>
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD8) && $TabSetting->FIELD8 !=''?$TabSetting->FIELD8:'Add. Trading Partner'); ?></p></div>
                        <div class="col-lg-2 pl">
                        <input type="text" name="SAP_TRADING_PARTNER" id="SAP_TRADING_PARTNER" disabled value="<?php echo e($objMstCust->SAP_TRADING_PARTNER_CODE); ?>" class="form-control">
                        </div>
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD9) && $TabSetting->FIELD9 !=''?$TabSetting->FIELD9:'Add. Trading Partner Name'); ?></p></div>
                        <div class="col-lg-2 pl">
                        <input type="text" name="SAP_TRADING_PARTNER_NAME" id="SAP_TRADING_PARTNER_NAME" disabled value="<?php echo e($objMstCust->SAP_TRADING_PARTNER_NAME); ?>" class="form-control">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD10) && $TabSetting->FIELD10 !=''?$TabSetting->FIELD10:'Add. Invoicing Party'); ?></p></div>
                        <div class="col-lg-1 pl">
                        <input type="text" name="SAP_INVOCING_PARTY" id="SAP_INVOCING_PARTY" disabled value="<?php echo e($objMstCust->SAP_INVOICING_PARTY); ?>" class="form-control" >
                        </div>
                        <div class="col-lg-2 pl"><p><?php echo e(isset($TabSetting->FIELD11) && $TabSetting->FIELD11 !=''?$TabSetting->FIELD11:'Our Code In Vendor Book'); ?></p></div>
                        <div class="col-lg-2 pl">
                        <input type="text" name="OUR_CODE_VBOOK" id="OUR_CODE_VBOOK" disabled value="<?php echo e($objMstCust->OUR_CODE_INVBOOK); ?>" class="form-control">
                        </div>
          
                      </div>
                     
                   
           
                      
 
                      
     
     
                      
                    </div>
                  </div>

				
				
			<div id="udf" class="tab-pane fade">
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
                      <input name=<?php echo e("udffie_popup_".$udfkey); ?> id=<?php echo e("txtudffie_popup_".$udfkey); ?> value="<?php echo e($udfrow->LABEL); ?>" class="form-control" autocomplete="off" maxlength="100" disabled />
                    </td>

                    <td hidden>
                      <input type="text" name='<?php echo e("udffie_".$udfkey); ?>' id='<?php echo e("hdnudffie_popup_".$udfkey); ?>' value="<?php echo e($udfrow->UDFVID); ?>" class="form-control" maxlength="100" disabled />
                    </td>

                    <td hidden>
                      <input type="text" name=<?php echo e("udffieismandatory_".$udfkey); ?> id=<?php echo e("udffieismandatory_".$udfkey); ?> class="form-control" maxlength="100" value="<?php echo e($udfrow->ISMANDATORY); ?>" disabled />
                    </td>

                    <td id="<?php echo e("tdinputid_".$udfkey); ?>">
                      
                      <?php
                        
                        $dynamicid = "udfvalue_".$udfkey;
                        $chkvaltype = strtolower($udfrow->VALUETYPE); 

                      if($chkvaltype=='date'){

                        $strinp = '<input type="date" placeholder="dd/mm/yyyy" name="'.$dynamicid.'" id="'.$dynamicid.'" class="form-control" value="'.$udfrow->VALUE.'" disabled/> ';       

                      }else if($chkvaltype=='time'){

                          $strinp= '<input type="time" placeholder="h:i" name="'.$dynamicid.'" id="'.$dynamicid.'" class="form-control"  value="'.$udfrow->VALUE.'" disabled/> ';

                      }else if($chkvaltype=='numeric'){
                      $strinp = '<input type="text" name="'.$dynamicid. '" id="'.$dynamicid.'" class="form-control" value="'.$udfrow->VALUE.'" disabled /> ';

                      }else if($chkvaltype=='text'){

                      $strinp = '<input type="text" name="'.$dynamicid. '" id="'.$dynamicid.'" class="form-control" value="'.$udfrow->VALUE.'" disabled/> ';

                      }else if($chkvaltype=='boolean'){
                          $boolval = ''; 
                          if($udfrow->VALUE=='on' || $udfrow->VALUE=='1' ){
                            $boolval="checked";
                          }
                          $strinp = '<input type="checkbox" name="'.$dynamicid. '" id="'.$dynamicid.'" class=""  '.$boolval.' disabled/> ';

                      }else if($chkvaltype=='combobox'){
                        $strinp='';
                      $txtoptscombo =   strtoupper($udfrow->DESCRIPTIONS); ;
                      $strarray =  explode(',',$txtoptscombo);
                      $opts = '';
                      $chked='';
                        for ($i = 0; $i < count($strarray); $i++) {
                          $chked='';
                          if($strarray[$i]==$udfrow->VALUE){
                            $chked='selected="selected"';
                          }
                           $opts = $opts.'<option value="'.$strarray[$i].'"'.$chked.'  >'.$strarray[$i].'</option> ';
                        }

                        $strinp = '<select name="'.$dynamicid.'" id="'.$dynamicid.'" class="form-control" disabled >'.$opts.'</select>' ;


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
				
			  </div>

		</div>
			
		</div>
						
		</form>
  </div><!--container-fluid filter-->

  <div id="HOLDINGID_REF_popup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id='HOLDINGID_REF_close' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>TDS Code</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">

      <table id="HOLDINGID_REF_tab1" class="display nowrap table  table-striped table-bordered" width="100%" style="font-size:12px;margin:0px;padding:0px;" >
        <thead>
          <tr>
            <th width="20%">Select</th>
            <th width="40%">Code</th>
            <th width="40%">Name</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <td width="20%"></td>
          <td width="40%"><input type="text" id="HOLDINGID_REF_codesearch" onkeyup="searchTDSCode()"></td>
          <td width="40%"><input type="text" id="HOLDINGID_REF_namesearch" onkeyup="searchTDSName()"></td>
        </tr>
        </tbody>
      </table>

      <table id="HOLDINGID_REF_tab2" class="display nowrap table  table-striped table-bordered" width="100%" style="font-size:12px;margin:0px;padding:0px;">
        <tbody id="HOLDINGID_REF_body">
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  if($("#TDS_APPLICABLE").prop("checked") == true){
    $(".TDS_ACTION").show();
  }
  else{
    $(".TDS_ACTION").hide();
  }

  getTdsCode('<?php echo $objMstCust->ASSESSEEID_REF;?>');

});

function TdsApplicable(){
  $("#CERTIFICATE_NO").val('');
  $("#EXPIRY_DT").val('');
  $("#ASSESSEEID_REF").val('');
  $("#HOLDINGID_REF_POPUP").val('');
  $("#HOLDINGID_REF").val('');
  $("#HOLDINGID_REF_body").html('');

  if($("#TDS_APPLICABLE").prop("checked") == true){
    $(".TDS_ACTION").show();
  }
  else{
    $(".TDS_ACTION").hide();
  }
}

function getTdsCode(ASSESSEEID_REF){
  $("#HOLDINGID_REF_POPUP").val('');
  $("#HOLDINGID_REF").val('');

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
      url:'<?php echo e(route("master",[5,"TdsCodeList"])); ?>',
      type:'POST',
      data:{ASSESSEEID_REF:ASSESSEEID_REF,VALUE:'<?php echo $objMstCust->HOLDINGID_REF;?>'},
      success:function(data) {
        $("#HOLDINGID_REF_body").html(data);
        bindTds();
        bindTds1();
      },
      error:function(data){
        console.log("Error: Something went wrong.");
        $("#HOLDINGID_REF_body").html('');
        
      },
  });	
}

$("#HOLDINGID_REF_POPUP").on("click",function(event){ 
  $("#HOLDINGID_REF_popup").show();
});

$("#HOLDINGID_REF_POPUP").keyup(function(event){
  if(event.keyCode==13){
    $("#HOLDINGID_REF_popup").show();
  }
});

$("#HOLDINGID_REF_close").on("click",function(event){ 
  $("#HOLDINGID_REF_popup").hide();
});

function bindTds(){
  $('.cls_HOLDINGID_REF').change(function(){

    var all_location_id = document.querySelectorAll('input[name="selectAll[]"]:checked');
    var aIds = [];
    var aIds1 = [];
    for(var x = 0, l = all_location_id.length; x < l;  x++){

      var id      = all_location_id[x].value;
      var txtval  = $("#txt"+id+"").val();
      var texdesc = $("#txt"+id+"").data("desc")

      aIds.push(txtval);
      aIds1.push(texdesc);

    }

    $("#HOLDINGID_REF_POPUP").val(aIds1);
    $("#HOLDINGID_REF").val(aIds);

  });
}

function bindTds1(){
  $('.cls_HOLDINGID_REF').find(function(){

    var all_location_id = document.querySelectorAll('input[name="selectAll[]"]:checked');
    var aIds = [];
    var aIds1 = [];
    for(var x = 0, l = all_location_id.length; x < l;  x++){

      var id      = all_location_id[x].value;
      var txtval  = $("#txt"+id+"").val();
      var texdesc = $("#txt"+id+"").data("desc")

      aIds.push(txtval);
      aIds1.push(texdesc);

    }

    $("#HOLDINGID_REF_POPUP").val(aIds1);
    $("#HOLDINGID_REF").val(aIds);

  });
}

function searchTDSCode() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("HOLDINGID_REF_codesearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("HOLDINGID_REF_tab2");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function searchTDSName() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("HOLDINGID_REF_namesearch");
      filter = input.value.toUpperCase();
      table = document.getElementById("HOLDINGID_REF_tab2");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
  }
}

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Purchase\VendorMaster\mstfrm48view.blade.php ENDPATH**/ ?>