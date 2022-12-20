
<?php $__env->startSection('content'); ?>

  <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('transaction',[$FormId,'index'])); ?>" class="btn singlebt">Opportunity</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                  <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                  <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                  <button class="btn topnavbt" id="btnSave" onclick="submitData('fnSaveData')"><i class="fa fa-floppy-o"></i> Save</button>
                  <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                  <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                  <button class="btn topnavbt" id="btnUndo"  ><i class="fa fa-undo"></i> Undo</button>
                  <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                  <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-thumbs-o-up"></i> Approved</button>
                  <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                  <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div>
        </div>
        <div class="container-fluid purchase-order-view filter">     
          <form id="frm_mst_edit" method="POST"> 
            <?php echo csrf_field(); ?>
            <?php echo e(isset($objResponse->LEAD_ID) ? method_field('PUT') : ''); ?>

    
            <div class="inner-form">
              <div class="row">
                <div class="col-lg-1 pl"><p>Lead No*</p></div>
                <div class="col-lg-3 pl"><?php echo e(isset($objResponse->LEAD_NO) && $objResponse->LEAD_NO !=''?$objResponse->LEAD_NO:''); ?>

                  <input type="hidden" name="LEAD_NO" id="LEAD_NO" value="<?php echo e(isset($objResponse->LEAD_NO) && $objResponse->LEAD_NO !=''?$objResponse->LEAD_NO:''); ?>" class="form-control mandatory"  autocomplete="off" readonly >
                  <input type="hidden" name="MAT_ROW_ID" id="MAT_ROW_ID" >
                </div>
                <div class="col-lg-1 pl"><p>Lead Date*</p></div>
                  <div class="col-lg-3 pl"><?php echo e(isset($objResponse->LEAD_DT) && $objResponse->LEAD_DT !=''?date('d-m-Y',strtotime($objResponse->LEAD_DT)):''); ?>

                    <input type="hidden" name="LEAD_DT" id="LEAD_DT" onchange="checkPeriodClosing('<?php echo e($FormId); ?>',this.value,1)" value="<?php echo e(isset($objResponse->LEAD_DT) && $objResponse->LEAD_DT !=''?$objResponse->LEAD_DT:''); ?>" class="form-control mandatory" >
                </div> 
                  
                <div class="col-lg-1 pl"><p>Customer</p></div>
                <div class="col-lg-1 pl">
                  <input type="radio" name="CUSTOMER" id="CUSTOMER" <?php echo e(isset($objResponse->CUSTOMER_TYPE) && $objResponse->CUSTOMER_TYPE =='Customer'?'checked':''); ?> value="Customer" onclick="getCustomer(this.value)" disabled>
                </div>
        
                <div class="col-lg-1 pl"><p>Prospect</p></div>
                <div class="col-lg-1 pl">
                  <input type="radio" name="CUSTOMER" id="PROSPECT" <?php echo e(isset($objResponse->CUSTOMER_TYPE) && $objResponse->CUSTOMER_TYPE =='Prospect'?'checked':''); ?> value="Prospect" onclick="getCustomer(this.value)" disabled>
                </div>
              </div>
          
              <div class="row">
                <div class="col-lg-1 pl"><p id="CUSTOMER_TITLE"><?php echo e(isset($objResponse->CUSTOMER_TYPE)?$objResponse->CUSTOMER_TYPE :''); ?></p></div>
                <div class="col-lg-3 pl"><?php echo e(isset($objResponse->CCODE) && $objResponse->CCODE !=''?$objResponse->CCODE:''); ?> <?php echo e(isset($objResponse->CUSTNAME) && $objResponse->CUSTNAME !=''?'- '.$objResponse->CUSTNAME:''); ?> <?php echo e(isset($objResponse->PCODE) && $objResponse->PCODE !=''?$objResponse->PCODE:''); ?> <?php echo e(isset($objResponse->PROSNAME) && $objResponse->PROSNAME !=''?'- '.$objResponse->PROSNAME:''); ?>

                  <input type="hidden" name="CUSTOMER_TYPE" id="CUSTOMER_TYPE" value="<?php echo e(isset($objResponse->CUSTOMER_TYPE) && $objResponse->CUSTOMER_TYPE !=''?$objResponse->CUSTOMER_TYPE:''); ?>" class="form-control" autocomplete="off" />
                  <?php echo e(isset($objCustProspt->CCODE) && $objCustProspt->CCODE !=''?$objCustProspt->CCODE:''); ?> <?php echo e(isset($objCustProspt->CUSTNAME) && $objCustProspt->CUSTNAME !=''?'- '.$objCustProspt->CUSTNAME:''); ?><?php echo e(isset($objCustProspt->PCODE) && $objCustProspt->PCODE !=''?$objCustProspt->PCODE:''); ?> <?php echo e(isset($objCustProspt->PROSNAME) && $objCustProspt->PROSNAME !=''?'- '.$objCustProspt->PROSNAME:''); ?>

                  <input type="hidden" name="CUSTOMER_PROSPECT" id="CUSTOMER_PROSPECT" value="<?php echo e(isset($objCustProspt->SLID_REF) && $objCustProspt->SLID_REF !=''?$objCustProspt->SLID_REF:''); ?><?php echo e(isset($objCustProspt->PID) && $objCustProspt->PID !=''?$objCustProspt->PID:''); ?>" class="form-control" autocomplete="off" />
                </div>
        
                <select name="CONVERTSTATUS" id="CONVERTSTATUS" hidden>
                  <option <?php echo e(isset($HDR->objResponse) && $HDR->objResponse == 'Prospecting'?'selected="selected"':''); ?> value="Prospecting">Prospecting</option>
                  <option <?php echo e(isset($HDR->objResponse) && $HDR->objResponse == 'Qualifying Leads'?'selected="selected"':''); ?> value="Qualifying Leads">Qualifying Leads</option>
                  <option <?php echo e(isset($HDR->objResponse) && $HDR->objResponse == 'Opportunity'?'selected="selected"':''); ?>value="Opportunity">Opportunity</option>
                </select> 
                
                  <div class="col-lg-1 pl"><p>Company</p></div>
                    <div class="col-lg-3 pl"><?php echo e(isset($objResponse->COMPANY_NAME) && $objResponse->COMPANY_NAME !=''?$objResponse->COMPANY_NAME:''); ?>

                      <input type="hidden" name="COMPANY_NAME" id="COMPANY_NAME" value="<?php echo e(isset($objResponse->COMPANY_NAME) && $objResponse->COMPANY_NAME !=''?$objResponse->COMPANY_NAME:''); ?>" class="form-control mandatory" autocomplete="off">                            
                    </div>               
                    <input type="hidden" name="FNAME" id="FNAME" value="<?php echo e(isset($objResponse->FIRST_NAME) && $objResponse->FIRST_NAME !=''?$objResponse->FIRST_NAME:''); ?>" class="form-control mandatory" autocomplete="off">                            
                    <input type="hidden" name="LNAME" id="LNAME" value="<?php echo e(isset($objResponse->LAST_NAME) && $objResponse->LAST_NAME !=''?$objResponse->LAST_NAME:''); ?>" class="form-control mandatory" autocomplete="off">                            
                  </div>
        
                <div class="col-lg-2 pl">
                  <textarea name="ADDRESS" id="ADDRESS" hidden><?php echo e(isset($objResponse->ADDRESS) && $objResponse->ADDRESS !=''?$objResponse->ADDRESS:''); ?></textarea>
                </div>
      
                <div class="col-lg-2 pl">
                  <input type="hidden" name="COUNTRY" id="COUNTRY" value="<?php echo e(isset($objResponse->CONTRYNAME) && $objResponse->CONTRYNAME !=''?$objResponse->CONTRYNAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
                  <input type="hidden" name="COUNTRYID_REF" id="COUNTRYID_REF" value="<?php echo e(isset($objResponse->CTRYID_REF) && $objResponse->CTRYID_REF !=''?$objResponse->CTRYID_REF:''); ?>" class="form-control" autocomplete="off" />
                </div>
              </div>
      
              <div class="row">
                <div class="col-lg-2 pl">
                  <input type="hidden" name="STATE" id="STATE" value="<?php echo e(isset($objResponse->STATENAME) && $objResponse->STATENAME !=''?$objResponse->STATENAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
                  <input type="hidden" name="STATEID_REF" id="STATEID_REF" value="<?php echo e(isset($objResponse->STID_REF) && $objResponse->STID_REF !=''?$objResponse->STID_REF:''); ?>" class="form-control" autocomplete="off" />
                </div>
      
                  <div class="col-lg-2 pl">
                    <input type="hidden" name="CITYID_REF_POPUP" id="CITYID_REF_POPUP" value="<?php echo e(isset($objResponse->CITYNAME) && $objResponse->CITYNAME !=''?$objResponse->CITYNAME:''); ?>" class="form-control mandatory" readonly tabindex="1" />
                    <input type="hidden" name="CITYID_REF" id="CITYID_REF" value="<?php echo e(isset($objResponse->CITYID_REF) && $objResponse->CITYID_REF !=''?$objResponse->CITYID_REF:''); ?>" />
                  </div>
      
                  <div class="col-lg-2 pl">
                    <input type="hidden" name="PINCODE" id="PINCODE" value="<?php echo e(isset($objResponse->PINCODE) && $objResponse->PINCODE !=''?$objResponse->PINCODE:''); ?>" onkeypress="return onlyNumberKey(event)" maxlength="6" class="form-control mandatory" autocomplete="off">                             
                  </div>
                </div>
                
                <div class="row">
                <div class="col-lg-2 pl">
                  <input type="hidden" name="LOWNER" id="LOWNER" value="<?php echo e(isset($objResponse->EMPCODE) && $objResponse->EMPCODE !=''?$objResponse->EMPCODE:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
                  <input type="hidden" name="LOWNERID_REF" id="LOWNERID_REF" value="<?php echo e(isset($objResponse->LEADOWNERID_REF) && $objResponse->LEADOWNERID_REF !=''?$objResponse->LEADOWNERID_REF:''); ?>" class="form-control" autocomplete="off" />
                </div>
      
                <div class="col-lg-2 pl">
                  <input type="hidden" name="INTYPE" id="INTYPE" value="<?php echo e(isset($objResponse->INDSCODE) && $objResponse->INDSCODE !=''?$objResponse->INDSCODE:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
                  <input type="hidden" name="INTYPEID_REF" id="INTYPEID_REF" value="<?php echo e(isset($objResponse->INDSID_REF) && $objResponse->INDSID_REF !=''?$objResponse->INDSID_REF:''); ?>" class="form-control" autocomplete="off" />
                </div>
                
                <div class="col-lg-2 pl">
                  <select name="DESIGNID_REF" id="DESIGNID_REF" hidden>
                    <option value="">Select</option>
                    <?php $__currentLoopData = $design; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(isset($objResponse->DESGINATION) && $objResponse->DESGINATION == $val-> DESGID ?'selected="selected"':''); ?> value="<?php echo e($val-> DESGID); ?>"><?php echo e($val->DESGCODE); ?> - <?php echo e($val->DESCRIPTIONS); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>                            
                </div>
              </div>
      
              <div class="row">
              <div class="col-lg-2 pl">
                <input type="hidden" name="CONTACT_PERSON" id="CONTACT_PERSON" value="<?php echo e(isset($objResponse->CONTACT_PERSON) && $objResponse->CONTACT_PERSON !=''?$objResponse->CONTACT_PERSON:''); ?>" class="form-control mandatory" autocomplete="off">                            
              </div>
      
              <div class="col-lg-2 pl">
                <input type="hidden" name="LEAD_DETAILS" id="LEAD_DETAILS" value="<?php echo e(isset($objResponse->LEAD_DETAILS) && $objResponse->LEAD_DETAILS !=''?$objResponse->LEAD_DETAILS:''); ?>" class="form-control mandatory" autocomplete="off">                            
              </div>
      
              <div class="col-lg-2 pl">
                <input type="hidden" name="WEBSITENAME" id="WEBSITENAME" value="<?php echo e(isset($objResponse->WEBSITE) && $objResponse->WEBSITE !=''?$objResponse->WEBSITE:''); ?>" class="form-control">                            
              </div>
            </div>
        
            <div class="row">
              <div class="col-lg-2 pl">
                <input type="hidden" name="LANDNUMBER" id="LANDNUMBER" value="<?php echo e(isset($objResponse->LANDLINE_NUMBER) && $objResponse->LANDLINE_NUMBER !=''?$objResponse->LANDLINE_NUMBER:''); ?>" onkeypress="return onlyNumberKey(event)" class="form-control mandatory" autocomplete="off">                            
              </div>
           
              <div class="col-lg-2 pl">
                <input type="hidden" name="MOBILENUMBER" id="MOBILENUMBER" value="<?php echo e(isset($objResponse->MOBILE_NUMBER) && $objResponse->MOBILE_NUMBER !=''?$objResponse->MOBILE_NUMBER:''); ?>" onkeypress="return onlyNumberKey(event)" maxlength="12" class="form-control mandatory" autocomplete="off">                           
              </div>
            
              <div class="col-lg-2 pl">
                <input type="hidden" name="EMAIL" id="EMAIL" value="<?php echo e(isset($objResponse->EMAIL) && $objResponse->EMAIL !=''?$objResponse->EMAIL:''); ?>" class="form-control mandatory" autocomplete="off"> 
                <input type="hidden" name="REMARKS" id="REMARKS" value="<?php echo e(isset($objResponse->REMARKS) && $objResponse->REMARKS !=''?$objResponse->REMARKS:''); ?>" class="form-control mandatory" autocomplete="off"> 
                <input type="hidden" name="LCLOSUR" id="LCLOSUR" value="<?php echo e(isset($objResponse->LEAD_CLOSURE) && $objResponse->LEAD_CLOSURE !=''?$objResponse->LEAD_CLOSURE:''); ?>" class="form-control mandatory" autocomplete="off">                            
              </div>
            </div>
            
            <div class="col-lg-2 pl">
              <input type="hidden" name="DEALER" id="DEALER" value="<?php echo e(isset($objResp->DOCNO) && $objResp->DOCNO !=''?$objResp->DOCNO:''); ?> <?php echo e(isset($objResp->DEALERNAME) && $objResp->DEALERNAME !=''?'- '.$objResp->DEALERNAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
              <input type="hidden" name="DEALERIDREF" id="DEALERID_REF" value="<?php echo e(isset($objResp->DEALERID_REF) && $objResp->DEALERID_REF !=''?$objResp->DEALERID_REF:''); ?>" class="form-control" autocomplete="off" />
            </div>
        
            <div class="row">
              <div class="col-lg-2 pl">
                <input type="hidden" name="LSOURCE" id="LSOURCE" value="<?php echo e(isset($objResponse->LEAD_SOURCENAME) && $objResponse->LEAD_SOURCENAME !=''?$objResponse->LEAD_SOURCENAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
                <input type="hidden" name="LSOURCEID_REF" id="LSOURCEID_REF" value="<?php echo e(isset($objResponse->LEAD_SOURCE) && $objResponse->LEAD_SOURCE !=''?$objResponse->LEAD_SOURCE:''); ?>" class="form-control" autocomplete="off" />
              </div>
            
              <div class="col-lg-2 pl">
                <input type="hidden" name="LSTATUS" id="LSTATUS" value="<?php echo e(isset($objResponse->LEAD_STATUSCODE) && $objResponse->LEAD_STATUSCODE !=''?$objResponse->LEAD_STATUSCODE:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
                <input type="hidden" name="LSTATUSID_REF" id="LSTATUSID_REF" value="<?php echo e(isset($objResponse->LEAD_STATUS) && $objResponse->LEAD_STATUS !=''?$objResponse->LEAD_STATUS:''); ?>" class="form-control" autocomplete="off" />
              </div>
        
              <div class="col-lg-2 pl">
                <input type="hidden" name="ASSIGTO" id="ASSIGTO" value="<?php echo e(isset($objResp->ASSGNTOCODE) && $objResp->ASSGNTOCODE !=''?$objResp->ASSGNTOCODE:''); ?> - <?php echo e($objResp->ASSGNTOFNAME); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
                <input type="hidden" name="ASSIGTOID_REF" id="ASSIGTOID_REF" value="<?php echo e(isset($objResp->ASSIGNTO_REF) && $objResp->ASSIGNTO_REF !=''?$objResp->ASSIGNTO_REF:''); ?>" class="form-control" autocomplete="off" />
              </div>
            </div>

            <tbody>
              <?php if(!empty($MAT)): ?>
              <?php $__currentLoopData = $MAT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr hidden class="participantRow">
                <td hidden>
                  <select name="TITAL[]" id =<?php echo e("TITAL_".$key); ?> class="form-control" style="display: none;">
                    <option value="">Select</option>
                    <option <?php echo e(isset($row->TITLE) && $row->TITLE == 'Mr'?'selected="selected"':''); ?> value="Mr">Mr.</option>
                    <option <?php echo e(isset($row->TITLE) && $row->TITLE == 'Mrs'?'selected="selected"':''); ?> value="Mrs">Mrs.</option>
                    <option <?php echo e(isset($row->TITLE) && $row->TITLE == 'Ms'?'selected="selected"':''); ?>value="Ms">Ms.</option>
                    <option <?php echo e(isset($row->TITLE) && $row->TITLE == 'Dr'?'selected="selected"':''); ?>value="Dr">Dr.</option>
                    </select>
                <td hidden><input  class="form-control" type="hidden" name="FIRSTNAME[]" id =<?php echo e("FIRSTNAME_".$key); ?> value="<?php echo e(isset($row->FIRST_NAME) && $row->FIRST_NAME !=''?$row->FIRST_NAME:''); ?>"     autocomplete="off"></td>
                <td hidden><input  class="form-control" type="hidden" name="LASTNAME[]"  id =<?php echo e("LASTNAME_".$key); ?>  value="<?php echo e(isset($row->LAST_NAME) && $row->LAST_NAME !=''?$row->LAST_NAME:''); ?>"        autocomplete="off"></td>
                
                <td hidden><select name="DESIG[]" id =<?php echo e("DESIG_".$key); ?> class="form-control mandatory" style="display: none;">
                  <option value="">Select</option>  
                  <?php $__currentLoopData = $design; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(isset($row->DESGINATION) && $row->DESGINATION == $val->DESGID ?'selected="selected"':''); ?> value="<?php echo e($val->DESGID); ?>"><?php echo e($val->DESGCODE); ?> - <?php echo e($val->DESCRIPTIONS); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </td>
                <td hidden><input  class="form-control" type="hidden" name="MOBILE[]"    id =<?php echo e("MOBILE_".$key); ?>    value="<?php echo e(isset($row->MOBILE_NUMBER) && $row->MOBILE_NUMBER !=''?$row->MOBILE_NUMBER:''); ?>"   onkeypress="return onlyNumberKey(event)" maxlength="12" autocomplete="off"></td>
                <td hidden><input  class="form-control" type="hidden" name="EMAILS[]"    id =<?php echo e("EMAILS_".$key); ?>    value="<?php echo e(isset($row->EMAIL) && $row->EMAIL !=''?$row->EMAIL:''); ?>" autocomplete="off"></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </tbody>

            <tbody>
              <?php if(!empty($MATSITE)): ?>
              <?php $n=1; ?>
              <?php $__currentLoopData = $MATSITE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

              <tr hidden class="participantRow">
                <td hidden><input  class="form-control" type="hidden" name="SITENAME[]" id =<?php echo e("SITENAME_".$key); ?> value="<?php echo e(isset($row->SITENAME) && $row->SITENAME !=''?$row->SITENAME:''); ?>" autocomplete="off"></td>
                <td hidden><input  class="form-control" type="hidden" name="ADDRESS1[]" id =<?php echo e("ADDRESS1_".$key); ?> value="<?php echo e(isset($row->ADDRESS1) && $row->ADDRESS1 !=''?$row->ADDRESS1:''); ?>" autocomplete="off"></td>
                <td hidden><input  class="form-control" type="hidden" name="ADDRESS2[]" id =<?php echo e("ADDRESS2_".$key); ?> value="<?php echo e(isset($row->ADDRESS2) && $row->ADDRESS2 !=''?$row->ADDRESS2:''); ?>" autocomplete="off"></td>
                <td hidden>
                  <select name="CTRYID_REF[]" id =<?php echo e("CTRYID_REF_".$key); ?> onchange="getstate(this,'SDETAILS')" class="form-control mandatory" style="display: none;">
                    <option value="">Select</option>
                    <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(isset($row->CTRYID_REF) && $row->CTRYID_REF == $val->CTRYID ?'selected="selected"':''); ?> value="<?php echo e($val->CTRYID); ?>"><?php echo e(isset($val->CTRYCODE) && $val->CTRYCODE !=''?$val->CTRYCODE:''); ?> <?php echo e(isset($val->NAME) && $val->NAME !=''?'- '.$val->NAME:''); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </td>
                <td hidden><select name="STATEIDREF[]" id =<?php echo e("STATEIDREF_".$key); ?> onchange="getcity(this,'SDCITY')" class="form-control mandatory" style="display: none;">
                  <option value="">Select</option>
                  <option <?php echo e(isset($row->STID_REF) && $row->STID_REF == $row->STID ?'selected="selected"':''); ?> value="<?php echo e(isset($row->STID) && $row->STID !=''?$row->STID:''); ?>"><?php echo e(isset($row->STCODE) && $row->STCODE !=''?$row->STCODE:''); ?> <?php echo e(isset($row->NAME) && $row->NAME !=''?'-'.$row->NAME:''); ?></option>
                  </select>
                </td>
                <td hidden><select name="CITYIDREF[]" id =<?php echo e("CITYIDREF_".$key); ?> class="form-control mandatory" style="display: none;">
                  <option value="">Select</option>
                  <option <?php echo e(isset($row->CITYID_REF) && $row->CITYID_REF == $row->CITYID ?'selected="selected"':''); ?> value="<?php echo e(isset($row->CITYID) && $row->CITYID !=''?$row->CITYID:''); ?>"><?php echo e(isset($row->CITYCODE) && $row->CITYCODE !=''?$row->CITYCODE:''); ?> <?php echo e(isset($row->CITYNAME) && $row->CITYNAME !=''?'-'.$row->CITYNAME:''); ?></option>
                  </select>
                </td>
                <td hidden><input  class="form-control" type="hidden" name="PINCODES[]" id =<?php echo e("PINCODES_".$key); ?> value="<?php echo e(isset($row->PINCODE) && $row->PINCODE !=''?$row->PINCODE:''); ?>"                        onkeypress="return onlyNumberKey(event)" maxlength="6" autocomplete="off"></td>
                <td hidden><input  class="form-control" type="hidden" name="PHONENO[]"  id =<?php echo e("PHONENO_".$key); ?>  value="<?php echo e(isset($row->CONTACT_NUMBER) && $row->CONTACT_NUMBER !=''?$row->CONTACT_NUMBER:''); ?>"   onkeypress="return onlyNumberKey(event)" autocomplete="off"></td>
                <td hidden><input  class="form-control" type="hidden" name="MOBILENO[]" id =<?php echo e("MOBILENO_".$key); ?> value="<?php echo e(isset($row->MOBILE_NUMBER) && $row->MOBILE_NUMBER !=''?$row->MOBILE_NUMBER:''); ?>"      onkeypress="return onlyNumberKey(event)" maxlength="12" autocomplete="off"></td>
                
              </tr>
              <?php $n++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
          <?php endif; ?>
            </tbody>

            <tbody>
              <?php if(!empty($MATNEWCALL)): ?>
              <?php $n=1; ?>
              <?php $__currentLoopData = $MATNEWCALL; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

              <tr hidden class="participantRow">
                <td hidden>
                  <select name="ACTIVITYIDREF[]" id =<?php echo e("ACTIVITYID_REF_".$key); ?> class="form-control mandatory" style="display: none;">
                    <option value="">Select</option>
                    <?php $__currentLoopData = $activitytype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option <?php echo e(isset($row->ACTIVITYID_REF) && $row->ACTIVITYID_REF == $val->ID ?'selected="selected"':''); ?> value="<?php echo e($val->ID); ?>"><?php echo e($val->ACTIVITYNAME); ?></option> 
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select> 
                </td>
                <td hidden><input  class="form-control mandatory" type="hidden" name="ACTYDATE[]"      id =<?php echo e("ACTYDATE_".$key); ?> value="<?php echo e(isset($row->ACTIVITY_DATE) && $row->ACTIVITY_DATE !=''?$row->ACTIVITY_DATE:''); ?>" autocomplete="off"></td>
                <td hidden>
                  <?php
                  //$acttime = explode(".",$row->ACTIVITY_TIME);
                  $ACTIVITY_TIME = date('H:i:s',strtotime(isset($row->ACTIVITY_TIME) && $row->ACTIVITY_TIME !=''?$row->ACTIVITY_TIME:''));
                  ?>
                  <input  class="form-control mandatory" type="hidden" name="ACTIVITYTIME[]"  id =<?php echo e("ACTIVITY_TIME_".$key); ?> value="<?php echo e(isset($ACTIVITY_TIME) && $ACTIVITY_TIME !=''?$ACTIVITY_TIME:''); ?>"  autocomplete="off">
                </td>

                <td hidden>
                  <select name="CONTACTPERSON[]" id =<?php echo e("CONTACTPERSON_".$key); ?> class="form-control mandatory" style="display: none;">
                    <option value="">Select</option>
                    <?php $__currentLoopData = $conctprsn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(isset($row->CONTACT_PERSON) && $row->CONTACT_PERSON == $val->CONTACT_PERSON ?'selected="selected"':''); ?> value="<?php echo e(isset($val->CONTACT_PERSON) && $val->CONTACT_PERSON !=''?$val->CONTACT_PERSON:''); ?>"><?php echo e(isset($val->CONTACT_PERSON) && $val->CONTACT_PERSON !=''?$val->CONTACT_PERSON:''); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </td>
                <td hidden><textarea class="form-control mandatory"    style="display: none;"      name="ACTYDETAIL[]"     id =<?php echo e("ACTYDETAIL_".$key); ?>><?php echo e(isset($row->ACTIVITY_DETAILS) && $row->ACTIVITY_DETAILS !=''?$row->ACTIVITY_DETAILS:''); ?></textarea></td>
                
                <td hidden>
                  <input type="hidden" name="ADDMEMBERVISIT[]" id="ADDMEMBERVISIT_0" value="<?php echo e(isset($row->FNAME) && $row->FNAME !=''?$row->FNAME:''); ?>"  class="form-control mandatory"  autocomplete="off" readonly style="width: 160px;"/>
                </td>
                
                <td hidden>
                <input type="hidden" name="ADDMEMBERVISITID_REF[]"  id="HIDDEN_ADDMEMBERVISIT_0" value="<?php echo e(isset($row->ADDITIONAL_EMPLOYEE_ID) && $row->ADDITIONAL_EMPLOYEE_ID !=''?$row->ADDITIONAL_EMPLOYEE_ID:''); ?>"  class="form-control mandatory" autocomplete="off" />
                </td>

                <td hidden>
                  <select name="EXPDETAILS[]" id =<?php echo e("EXPDETAILS_".$key); ?> class="form-control mandatory" style="display: none;">
                    <option value="">Select</option>
                    <option <?php echo e(isset($row->EXPENSE_DETAILS) && $row->EXPENSE_DETAILS == 'Auto'?'selected="selected"':''); ?> value="Auto">Auto</option>
                    <option <?php echo e(isset($row->EXPENSE_DETAILS) && $row->EXPENSE_DETAILS == 'Cab'?'selected="selected"':''); ?> value="Cab">Cab</option>
                    <option <?php echo e(isset($row->EXPENSE_DETAILS) && $row->EXPENSE_DETAILS == 'Metro'?'selected="selected"':''); ?>value="Metro">Metro</option>
                    <option <?php echo e(isset($row->EXPENSE_DETAILS) && $row->EXPENSE_DETAILS == 'Byke'?'selected="selected"':''); ?>value="Byke">Byke</option>
                    <option <?php echo e(isset($row->EXPENSE_DETAILS) && $row->EXPENSE_DETAILS == 'Bus'?'selected="selected"':''); ?>value="Bus">Bus</option>
                    <option <?php echo e(isset($row->EXPENSE_DETAILS) && $row->EXPENSE_DETAILS == 'Train'?'selected="selected"':''); ?>value="Train">Train</option>
                    <option <?php echo e(isset($row->EXPENSE_DETAILS) && $row->EXPENSE_DETAILS == 'Flight'?'selected="selected"':''); ?>value="Flight">Flight</option>
                    </select> 
                  </td>
                  
                <td hidden><input  class="form-control mandatory" type="hidden" name="TENTEXPAMT[]" id =<?php echo e("TENTEXPAMT_".$key); ?> value="<?php echo e(isset($row->TENTATIVE_EXPENSES) && $row->TENTATIVE_EXPENSES !=''?$row->TENTATIVE_EXPENSES:''); ?>" autocomplete="off" onkeypress="return onlyNumberKey(event)"></td>
                
                <td hidden>
                  <select name="RESPONSE[]" id =<?php echo e("RESPONSE_".$key); ?> class="form-control mandatory" style="display: none;">
                    <option value="">Select</option>
                    <?php $__currentLoopData = $resp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(isset($row->RESPONSEID_REF) && $row->RESPONSEID_REF == $val->ID ?'selected="selected"':''); ?> value="<?php echo e($val->ID); ?>"><?php echo e($val->RESPONSENAME); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select> 
                </td>
                <td hidden><textarea name="ACTPLAN[]" id =<?php echo e("ACTPLAN_".$key); ?>  style="display: none;" class="form-control mandatory" style="width: 160px;"><?php echo e(isset($row->ACTION_PLAN) && $row->ACTION_PLAN !=''?$row->ACTION_PLAN:''); ?></textarea></td>
                <td hidden>
                  <select name="REMNDETAILID_REF[]" id =<?php echo e("REMNDETAILID_REF_".$key); ?> class="form-control mandatory" style="display: none;">
                    <option value="">Select</option>
                    <option <?php echo e(isset($row->REMINDER_DETAIL) && $row->REMINDER_DETAIL == 'Meeting'?'selected="selected"':''); ?> value="Meeting">Meeting</option>
                    <option <?php echo e(isset($row->REMINDER_DETAIL) && $row->REMINDER_DETAIL == 'Mail'?'selected="selected"':''); ?> value="Mail">Mail</option>
                    <option <?php echo e(isset($row->REMINDER_DETAIL) && $row->REMINDER_DETAIL == 'Call'?'selected="selected"':''); ?>value="Call">Call</option>
                    </select>
                </td>
                <td hidden><input type="hidden" name="REMNDDATE[]" id =<?php echo e("REMNDDATE_".$key); ?> value="<?php echo e(isset($row->REMINDER_DATE) && $row->REMINDER_DATE !=''?$row->REMINDER_DATE:''); ?>" class="form-control mandatory" autocomplete="off" style="width: 110px;"></td>
                <td hidden>
                  <?php
                  //$remtime = explode(".",$row->REMINDER_TIME);                        
                  $REMINDER_TIME = date('H:i:s',strtotime(isset($row->REMINDER_TIME) && $row->REMINDER_TIME !=''?$row->REMINDER_TIME:''));
                  ?>
                  <input type="hidden" name="REMINDERTIME[]" id =<?php echo e("REMINDER_TIME_".$key); ?>  value="<?php echo e(isset($REMINDER_TIME) && $REMINDER_TIME !=''?$REMINDER_TIME:''); ?>" class="form-control mandatory" autocomplete="off" style="width: 110px;">
                </td>
                
                <td hidden><textarea name="ALERTMSG[]" id =<?php echo e("ALERTMSG_".$key); ?> style="display: none;" class="form-control mandatory" style="width: 160px;"><?php echo e(isset($row->ALERT_MESSAGE) && $row->ALERT_MESSAGE !=''?$row->ALERT_MESSAGE:''); ?></textarea></td>
                
                <td hidden><input type="hidden" name="ALERTTO[]" id =<?php echo e("ALERTTO_".$key); ?> onclick="getAlertTo(this.id,this.value)" value="<?php echo e(isset($row->ALTFNAME) && $row->ALTFNAME !=''?$row->ALTFNAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly style="width: 120px;"/></td>
                <td hidden><input type="hidden" name="ALERTTOID_REF[]" id =<?php echo e("ALERTTOID_REF_".$key); ?> value="<?php echo e(isset($row->ALERT_TO) && $row->ALERT_TO !=''?$row->ALERT_TO:''); ?>" class="form-control mandatory" autocomplete="off" /></td>

              </tr>
              <?php $n++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
          <?php endif; ?>
          </tbody>

          <tbody>
            <?php if(!empty($NEWTASKS)): ?>
            <?php $n=1; ?>
            <?php $__currentLoopData = $NEWTASKS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr hidden class="participantRow">
              <td hidden>
                <select name="TASKTYPEID_REF[]" id =<?php echo e("TASKTYPEID_REF_".$key); ?> class="form-control mandatory" style="display: none;">
                  <option value="">Select</option>
                <?php $__currentLoopData = $tasktype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option <?php echo e(isset($row->TASKID_REF) && $row->TASKID_REF == $val->ID ?'selected="selected"':''); ?> value="<?php echo e($val->ID); ?>"><?php echo e($val->TASK_TYPENAME); ?></option> 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select> 
              </td>

              <td hidden><input type="hidden" name="ASSGNDTO[]" id =<?php echo e("ASSGNDTO_".$key); ?> onclick="getAssignedTo(this.id,this.value)" value="<?php echo e(isset($row->EMPCODE) && $row->EMPCODE !=''?$row->EMPCODE:''); ?>  <?php echo e(isset($row->FNAME) && $row->FNAME !=''?$row->FNAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/></td>
              <td hidden><input type="hidden" name="ASSGNDTOID_REF[]" id =<?php echo e("ASSGNDTOID_REF_".$key); ?> value="<?php echo e(isset($row->EMPID) && $row->EMPID !=''?$row->EMPID:''); ?>" class="form-control" autocomplete="off" /></td>
              
              <td hidden><textarea name="SUBJECT[]" id =<?php echo e("SUBJECT_".$key); ?> style="display: none;" class="form-control mandatory"><?php echo e(isset($row->SUBJECT) && $row->SUBJECT !=''?$row->SUBJECT:''); ?></textarea></td>
              <td hidden>
                <select name="PRIORITYID_REF[]" id =<?php echo e("PRIORITYID_REF_".$key); ?> class="form-control mandatory" style="display: none;">
                  <option value="">Select</option>
                  <?php $__currentLoopData = $priorty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option <?php echo e(isset($row->PRIORITYID_REF) && $row->PRIORITYID_REF == $val->PAYPERIODID ?'selected="selected"':''); ?> value="<?php echo e($val->PAYPERIODID); ?>"><?php echo e($val->PAY_PERIOD_CODE); ?></option>  
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select> 
              </td>
              <td hidden><textarea name="TASKDETAIL[]" id =<?php echo e("TASKDETAIL_".$key); ?> style="display: none;" class="form-control mandatory"><?php echo e(isset($row->TASK_DETAIL) && $row->TASK_DETAIL !=''?$row->TASK_DETAIL:''); ?></textarea></td>
              
              <td hidden><input type="hidden" name="DUEDATE[]" id =<?php echo e("DUEDATE_".$key); ?> value="<?php echo e(isset($row->DUE_DATE) && $row->DUE_DATE !=''?$row->DUE_DATE:''); ?>" class="form-control mandatory" autocomplete="off"> </td>
              <td hidden>
                <select name="STATUSID_REF[]" id =<?php echo e("STATUSID_REF_".$key); ?> class="form-control mandatory" style="display: none;">
                  <option value="">Select</option>
                  <option <?php echo e(isset($row->TASK_STATUS) && $row->TASK_STATUS == 'Meeting'?'selected="selected"':''); ?> value="Meeting">Meeting</option>
                <option <?php echo e(isset($row->TASK_STATUS) && $row->TASK_STATUS == 'Mail'?'selected="selected"':''); ?> value="Mail">Mail</option>
                <option <?php echo e(isset($row->TASK_STATUS) && $row->TASK_STATUS == 'Call'?'selected="selected"':''); ?>value="Call">Call</option>
                </select>
              </td>
              <td hidden><input type="hidden" name="REMINDER[]" id =<?php echo e("REMINDER_".$key); ?> value="<?php echo e(isset($row->TASK_REMINDER_DATE) && $row->TASK_REMINDER_DATE !=''?$row->TASK_REMINDER_DATE:''); ?>" class="form-control mandatory" autocomplete="off"></td>
              
            </tr>
            <?php $n++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
          <?php endif; ?>
          </tbody>

          <tbody>
            <?php if(!empty($PRODUCTDETAILS)): ?>
            <?php $n=1; ?>
            <?php $__currentLoopData = $PRODUCTDETAILS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr hidden  class="participantRow">
              <td hidden><input type="hidden" name="PRODUCTNAME[]" id =<?php echo e("PRODUCTNAME_".$key); ?> onclick="getProductName(this.id)"   value="<?php echo e(isset($row->ICODE) && $row->ICODE !=''?$row->ICODE:''); ?>  <?php echo e(isset($row->NAME) && $row->NAME !=''?$row->NAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/></td>
              <td hidden><input type="hidden" name="PRODUCTID_REF[]" id="PRODUCTID_REF_<?php echo e($key); ?>" value="<?php echo e(isset($row->ITEMID) && $row->ITEMID !=''?$row->ITEMID:''); ?>" class="form-control" autocomplete="off" /></td>
              <td hidden><input type="hidden" id="PRODUCT_DESC_<?php echo e($key); ?>" value="<?php echo e(isset($row->NAME) && $row->NAME !=''?$row->NAME:''); ?>" class="form-control" readonly  > </td>
              
              <td hidden><input type="hidden" name="PRODUCT_QTY[]" id="PRODUCT_QTY_<?php echo e($key); ?>" value="<?php echo e(isset($row->QUANTITY) && $row->QUANTITY !=''?$row->QUANTITY:''); ?>" onkeyup="getProductDetails(this.id,this.value)" onkeypress="return isNumberKey(this, event);" class="form-control minAmt" onkeypress="return onlyNumberKey(event)"></td>
              <td hidden><input type="hidden" name="PRODUCT_PRICE[]" id="PRODUCT_PRICE_<?php echo e($key); ?>" value="<?php echo e(isset($row->RATE) && $row->RATE !=''?$row->RATE:''); ?>" onkeyup="getProductDetails(this.id,this.value)" onkeypress="return isNumberKey(this, event);" class="form-control" onkeypress="return onlyNumberKey(event)"></td>
              <td hidden><input type="hidden" name="PRODUCT_AMOUNT[]" id="TOTAL_AMOUNT_<?php echo e($key); ?>" value="<?php echo e(isset($row->AMOUNT) && $row->AMOUNT !=''?$row->AMOUNT:''); ?>" class="form-control" readonly></td>
              
            </tr>
            <?php $n++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
          <?php endif; ?>
          </tbody>

            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#Opportunity" id="MAT_TAB" >Opportunity</a></li>
            </ul>
    
          <div class="tab-content">
          <div id="Opportunity" class="tab-pane fade in active" style="margin-left: 16px; margin-top: 10px; width: 97%;">
            <div class="row">
              <div class="col-lg-2 pl"><p>Opportunity Type*</p></div>
              <div class="col-lg-2 pl">
                <input type="text" name="OPPORTY_TYPE" id="OPPORTY_TYPE" onclick="getData('<?php echo e(route('transaction',[$FormId,'getOpportyType'])); ?>','Opportunity Type Details','OPPORTY_REF')" value="<?php echo e(isset($objResponse->OPPORTUNITY_TYPECODE) && $objResponse->OPPORTUNITY_TYPECODE !=''?$objResponse->OPPORTUNITY_TYPECODE:''); ?> <?php echo e(isset($objResponse->OPPORTUNITY_TYPENAME) && $objResponse->OPPORTUNITY_TYPENAME !=''?'- '.$objResponse->OPPORTUNITY_TYPENAME:''); ?>" class="form-control mandatory" autocomplete="off" readonly>
                <input type="hidden" name="OPPORTY_REFID" id="OPPORTY_REF" value="<?php echo e(isset($objResponse->OPPORTUNITY_TYPE_ID) && $objResponse->OPPORTUNITY_TYPE_ID !=''?$objResponse->OPPORTUNITY_TYPE_ID:''); ?>" class="form-control mandatory" autocomplete="off" readonly>
              </div>
      
              <div class="col-lg-2 pl"><p>Opportunity Date*</p></div>
                <div class="col-lg-2 pl">
                  <input type="date" name="OPPORTY_DATE" id="OPPRTY_DT" value="<?php echo e(isset($objResponse->OPPORTUNITY_DATE) && $objResponse->OPPORTUNITY_DATE !=''?$objResponse->OPPORTUNITY_DATE:''); ?>" class="form-control mandatory" autocomplete="off">                            
                </div>
        
                <div class="col-lg-2 pl"><p>Opportunity Stage*</p></div>
                <div class="col-lg-2 pl">
                  <input type="text" name="OPPORTY_STAGE" id="OPPORTY_STAGE" onclick="getData('<?php echo e(route('transaction',[$FormId,'getOpprtyStageCode'])); ?>','Response','OPPORTYSTAGE_REF')" value="<?php echo e(isset($objResponse->OPPORTUNITY_STAGECODE) && $objResponse->OPPORTUNITY_STAGECODE !=''?$objResponse->OPPORTUNITY_STAGECODE:''); ?> <?php echo e(isset($objResponse->OPPORTUNITY_STAGENAME) && $objResponse->OPPORTUNITY_STAGENAME !=''?'- '.$objResponse->OPPORTUNITY_STAGENAME:''); ?>" class="form-control mandatory" autocomplete="off" readonly>
                  <input type="hidden" name="OPPORTYSTAGE_REFID" id="OPPORTYSTAGE_REF" value="<?php echo e(isset($objResponse->OPPORTUNITY_STAGE_ID) && $objResponse->OPPORTUNITY_STAGE_ID !=''?$objResponse->OPPORTUNITY_STAGE_ID:''); ?>" class="form-control mandatory">                              
              </div>
              </div>
    
              <div class="row">
                <div class="col-lg-2 pl"><p>Opportuntity Stage Completed (%)</p></div>
                <div class="col-lg-2 pl">
                  <input type="text" name="OPPORTY_STAGECOMPLTED" id="OPPORTY_STAGECOMPLTED" value="<?php echo e(isset($objResponse->COMPLETE_PERCENT) && $objResponse->COMPLETE_PERCENT !=''?$objResponse->COMPLETE_PERCENT:''); ?>" class="form-control mandatory" autocomplete="off" readonly>                            
                </div>
    
                <div class="col-lg-2 pl"><p>Expected date*</p></div>
                <div class="col-lg-2 pl">
                  <input type="date" name="EXPECTED_DATE" id="EXPECTED_DATE" value="<?php echo e(isset($objResponse->EXPECTED_DATE) && $objResponse->EXPECTED_DATE !=''?$objResponse->EXPECTED_DATE:''); ?>" class="form-control mandatory" autocomplete="off">                            
                </div>              
                </div>
    
                  
                </div>
              </div>
            </div>
          </div>
      </div>
      </div>
      </div>
      </div>
      </form>
      </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('alert'); ?>
    <!-- Alert -->
    <div id="alert" class="modal"  role="dialog"  data-backdrop="static">
      <div class="modal-dialog" >
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
                <button onclick="setfocus();"  class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;">
                <div id="alert-active" class="activeOk"></div>OK</button>
                <button class="btn alertbt" name='OkBtn1' id="OkBtn1" style="display:none;margin-left: 90px;">
                  <div id="alert-active" class="activeOk1"></div>OK</button>
                  <input type="hidden" id="focusid" >
                
            </div><!--btdiv-->
            <div class="cl"></div>
          </div>
        </div>
      </div>
    </div>
    
    <div id="modalpopup" class="modal" role="dialog"  data-backdrop="static">
      <div class="modal-dialog modal-md column3_modal" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id='modalclosePopup' >&times;</button>
          </div>
    
          <div class="modal-body">
    
            <div class="tablename"><p id='tital_Name'></p></div>
            <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
              <table id="MachTable" class="display nowrap table  table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="ROW1">Select</th> 
                    <th class="ROW2">Code</th>
                    <th class="ROW3">Description</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="ROW1"><span class="check_th">&#10004;</span></td>
                    <td class="ROW2"><input type="text" autocomplete="off"  class="form-control" id="codesearch"  onkeyup='colSearch("tabletab2","codesearch",1)' /></td>
                    <td class="ROW3"><input type="text" autocomplete="off"  class="form-control" id="namesearch"  onkeyup='colSearch("tabletab2","namesearch",2)' /></td>
                  </tr>
                </tbody>
              </table>
    
              <table id="tabletab2" class="display nowrap table  table-striped table-bordered" >
                <thead id="thead2"></thead>
                <tbody id="getData_tbody"></tbody>
              </table>
    
            </div>
    
            <div class="cl"></div>
    
          </div>
        </div>
      </div>
    </div>
    
    
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('bottom-css'); ?>
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('bottom-scripts'); ?>
    <script>
    
    /*************************************   All Popup  ************************** */
        function getCustomer(value){
          $("#CUSTOMER_TITLE").html(value);
          $("#CUSTOMER_TYPE").val(value);
          $("#CUSTOMERPROSPECT_NAME").val('');
          $("#CUSTOMER_PROSPECT").val('');
        }
    
        function getCustProspect(){
          var type  = $("input[name='CUSTOMER']:checked").val();
          var msg   = type;
          $('#getData_tbody').html('Loading...');
    
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
    
          $.ajax({
            url:'<?php echo e(route("transaction",[$FormId,"getCustomerCode"])); ?>',
            type:'POST',
            data:{type:type},
            success:function(data) {
            $('#getData_tbody').html(data);
            bindCustPostEvents(type);
            },
            error:function(data){
              console.log("Error: Something went wrong.");
              $('#getData_tbody').html('');
            },
          });
          $("#tital_Name").text(msg);
          $("#modalpopup").show();
        }
    
      function getData(path,msg,id){
    
          var listid = $("#"+id).val();
    
          $('#getData_tbody').html('Loading...'); 
    
          $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
    
          $.ajax({
              url:path,
              type:'POST',
              data:{listid:listid},
              success:function(data) {
              $('#getData_tbody').html(data);
              bindOpportunityTypeEvents()
              bindOpportunityStageEvents()
              },
              error:function(data){
                console.log("Error: Something went wrong.");
                $('#getData_tbody').html('');
              },
            });
            $("#tital_Name").text(msg);
            $("#modalpopup").show();
            event.preventDefault();
        }
    
          $("#modalclosePopup").on("click",function(event){ 
            $("#modalpopup").hide();
            event.preventDefault();
          });
    
          function bindCustPostEvents(type){
          $('.cls'+type).click(function(){
            if($(this).is(':checked') == true){
            var id = $(this).attr('id');
            var txtval =    $("#txt"+id+"").val();
            var texdesc =   $("#txt"+id+"").data("desc");
            $("#CUSTOMERPROSPECT_NAME").val(texdesc);
            $("#CUSTOMER_PROSPECT").val(txtval);
            $("#modalpopup").hide();
            }
          });
          }
    
        function bindOpportunityTypeEvents(){
            $('.clsopptype').click(function(){
            var id = $(this).attr('id');
            var txtval =    $("#txt"+id+"").val();
            var texdesc =   $("#txt"+id+"").data("desc");
            $("#OPPORTY_TYPE").val(texdesc);
            $("#OPPORTY_REF").val(txtval);
            $("#modalpopup").hide();
            });
          }
    
        function bindOpportunityStageEvents(){
            $('.clsopstage').click(function(){
            var id = $(this).attr('id');
            var txtval =    $("#txt"+id+"").val();
            var texdesc =   $("#txt"+id+"").data("desc");
            var texdcompernt =   $("#txt"+id+"").data("compernt");
            $("#OPPORTY_STAGE").val(texdesc);
            $("#OPPORTYSTAGE_REF").val(txtval);
            $("#OPPORTY_STAGECOMPLTED").val(texdcompernt);
            $("#modalpopup").hide();
            });
          }
    
    
    /************************************* All Search Start  ************************** */
    
            let input, filter, table, tr, td, i, txtValue;
              function colSearch(ptable,ptxtbox,pcolindex) {
                  //var input, filter, table, tr, td, i, txtValue;
                  input = document.getElementById(ptxtbox);
                  filter = input.value.toUpperCase();
                  table = document.getElementById(ptable);
                  tr = table.getElementsByTagName("tr");
                  for (i = 0; i < tr.length; i++) {
                  td = tr[i].getElementsByTagName("td")[pcolindex];
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
    
    /************************************* All Search End  ************************** */
    
        function setfocus(){
            var focusid=$("#focusid").val();
            $("#"+focusid).focus();
            $("#closePopup").click();
          }
      
      function alertMsg(id,msg){
            $("#focusid").val(id);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").hide();  
            $("#OkBtn").show();              
            $("#AlertMessage").text(msg);
            $("#alert").modal('show');
            $("#OkBtn").focus();
            return false;
        }
      
      function validateForm(actionType){
          $("#focusid").val('');
    
          var OPPORTY_REF           =   $.trim($("#OPPORTY_REF").val());
          var OPPRTY_DT             =   $.trim($("#OPPRTY_DT").val());
          var OPPORTYSTAGE_REF      =   $.trim($("#OPPORTYSTAGE_REF").val());
          var EXPECTED_DATE         =   $.trim($("#EXPECTED_DATE").val());
          
          $("#OkBtn1").hide();
    
          if(OPPORTY_REF ===""){
            alertMsg('OPPORTY_TYPE','Please Select Opportunity Type.');
          }
          else if(OPPRTY_DT ===""){
            alertMsg('OPPRTY_DT','Please Select Opportunity Date.');
          }
          else if(OPPORTYSTAGE_REF ===""){
            alertMsg('OPPORTY_STAGE','Please Select Opportunity Stage.');
          }
          else if(EXPECTED_DATE ===""){
            alertMsg('EXPECTED_DATE','Please Select Expected date.');
          }
          else if(checkPeriodClosing('<?php echo e($FormId); ?>',$("#LEAD_DT").val(),0) ==0){
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text(period_closing_msg);
            $("#alert").modal('show');
            $("#OkBtn1").focus();
          }
            else{
              $("#alert").modal('show');
              $("#AlertMessage").text('Do you want to save to record.');
              $("#YesBtn").data("funcname",actionType);  
              $("#YesBtn").focus();
              highlighFocusBtn('activeYes');
          }
      }
    
        $('#btnAdd').on('click', function() {
            var viewURL = '<?php echo e(route("transaction",[$FormId,"add"])); ?>';
            window.location.href=viewURL;
        });
      
        $('#btnExit').on('click', function() {
          var viewURL = '<?php echo e(route('home')); ?>';
          window.location.href=viewURL;
        });
      
       var formResponseMst = $( "#frm_mst_edit" );
           formResponseMst.validate();
    
          function validateSingleElemnet(element_id){
            var validator =$("#frm_mst_edit" ).validate();
               if(validator.element( "#"+element_id+"" )){
                  checkDuplicateCode();
               }
            }
      
          function checkDuplicateCode(){
              var getDataForm = $("#frm_mst_edit");
              var formData = getDataForm.serialize();
    
              $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                  url:'<?php echo e(route("transaction",[$FormId,"codeduplicate"])); ?>',
                  type:'POST',
                  data:formData,
                  success:function(data) {
                    if(data.exists) {
                      $(".text-danger").hide();
                      showError('ERROR',data.msg);
                      }                                
                  },
                  error:function(data){
                    console.log("Error: Something went wrong.");
                  },
              });
          }
      
          $( "#btnSave" ).click(function() {
              if(formResponseMst.valid()){
                validateForm("fnSaveData");
              }
            });
          
          $("#YesBtn").click(function(){
              $("#alert").modal('hide');
              var customFnName = $("#YesBtn").data("funcname");
              window[customFnName]();
            });
      
         window.fnSaveData = function (){
              event.preventDefault();
              var getDataForm = $("#frm_mst_edit");
              var formData = getDataForm.serialize();
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                url:'<?php echo e(route("transactionmodify",[$FormId,"update"])); ?>',
                  type:'POST',
                  data:formData,
                  success:function(data) {
                    if(data.success) {                   
                      $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn1").show();
                      $("#OkBtn").hide();
                      $("#AlertMessage").text(data.msg);
                      $("#alert").modal('show');
                      $("#OkBtn1").focus();
                    }
                    else{
                      $("#YesBtn").hide();
                      $("#NoBtn").hide();
                      $("#OkBtn1").hide();
                      $("#OkBtn").show();
                      $("#AlertMessage").text(data.msg);
                      $("#alert").modal('show');
                      $("#OkBtn").focus();
                    }
                      
                  },
                  error:function(data){
                  console.log("Error: Something went wrong.");
                  },
              });
           }
         
          $("#NoBtn").click(function(){
            $("#alert").modal('hide');
            var custFnName = $("#NoBtn").data("funcname");
              window[custFnName]();
            });
         
          $("#OkBtn").click(function(){
              $("#alert").modal('hide');
              $("#YesBtn").show();
              $("#NoBtn").show();
              $("#OkBtn").hide();
              $("#OkBtn1").hide();
              $(".text-danger").hide(); 
          });
          
          $("#btnUndo").click(function(){
              $("#AlertMessage").text("Do you want to erase entered information in this record?");
              $("#alert").modal('show');
              $("#YesBtn").data("funcname","fnUndoYes");
              $("#YesBtn").show();
              $("#NoBtn").data("funcname","fnUndoNo");
              $("#NoBtn").show();
              $("#OkBtn").hide();
              $("#OkBtn1").hide();
              $("#NoBtn").focus();
              highlighFocusBtn('activeNo');
            });
          
              $("#OkBtn1").click(function(){
              $("#alert").modal('hide');
              $("#YesBtn").show();
              $("#NoBtn").show();
              $("#OkBtn").hide();
              $("#OkBtn1").hide();
              $(".text-danger").hide();
              window.location.href = "<?php echo e(route('transaction',[$FormId,'index'])); ?>";
              });
      
              $("#OkBtn").click(function(){
                $("#alert").modal('hide');
              });
      
          window.fnUndoYes = function (){
            window.location.href = "<?php echo e(route('transaction',[$FormId,'add'])); ?>";
          }
      
          function showError(pId,pVal){
            $("#"+pId+"").text(pVal);
            $("#"+pId+"").show();
            }
      
          function highlighFocusBtn(pclass){
             $(".activeYes").hide();
             $(".activeNo").hide();
             $("."+pclass+"").show();
          } 
          
          
$(document).ready(function(e) {
  var today = new Date(); 
  var sodate = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2) ;
  $('[id*="OPPRTY_DT"]').attr('min',sodate);
  $('[id*="EXPECTED_DATE"]').attr('min',sodate);
});
            
  </script>
  <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\transactions\PreSales\Opportunity\trnfrm486add.blade.php ENDPATH**/ ?>