

<?php $__env->startSection('content'); ?>
<!-- <form id="frm_mst_se" onsubmit="return validateForm()"  method="POST"  >     -->
 
    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('transaction',[$FormId,'index'])); ?>" class="btn singlebt">Lead Generation</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                        <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSaveSE" disabled="disabled"><i class="fa fa-floppy-o"></i> Save</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo" disabled="disabled" ><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        
                        <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-thumbs-o-up"></i> Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                        
                </div>
            </div><!--row-->
    </div><!--topnav-->	
    <!-- multiple table-responsive table-wrapper-scroll-y my-custom-scrollbar -->

    <div class="container-fluid purchase-order-view filter">     
      <form id="frm_mst_edit" method="POST"> 
        <?php echo csrf_field(); ?>
        <?php echo e(isset($objResponse->LEAD_ID) ? method_field('PUT') : ''); ?>

        
      <div class="inner-form">
      <div class="row">
        <div class="col-lg-2 pl"><p>Lead No*</p></div>
        <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="text" name="LEAD_NO" id="LEAD_NO" value="<?php echo e(isset($objResponse->LEAD_NO) && $objResponse->LEAD_NO !=''?$objResponse->LEAD_NO:''); ?>" class="form-control mandatory"  autocomplete="off" readonly >
          <input type="hidden" name="MAT_ROW_ID" id="MAT_ROW_ID" >
        </div>
        <div class="col-lg-2 pl"><p>Lead Date*</p></div>
          <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="date" name="LEAD_DT" id="LEAD_DT" value="<?php echo e(isset($objResponse->LEAD_DT) && $objResponse->LEAD_DT !=''?$objResponse->LEAD_DT:''); ?>" class="form-control mandatory" >
        </div> 
          
        <div class="col-lg-1 pl"><p>Customer</p></div>
        <div class="col-lg-1 pl">
          <input <?php echo e($ActionStatus); ?> type="radio" name="CUSTOMER" id="CUSTOMER" <?php echo e(isset($objResponse->CUSTOMER_TYPE) && $objResponse->CUSTOMER_TYPE =='Customer'?'checked':''); ?> value="Customer" onclick="getCustomer(this.value)">
        </div>

        <div class="col-lg-1 pl"><p>Prospect</p></div>
        <div class="col-lg-1 pl">
          <input <?php echo e($ActionStatus); ?> type="radio" name="CUSTOMER" id="PROSPECT" <?php echo e(isset($objResponse->CUSTOMER_TYPE) && $objResponse->CUSTOMER_TYPE =='Prospect'?'checked':''); ?> value="Prospect" onclick="getCustomer(this.value)">
        </div>
      </div>
  
      <div class="row">
        <div class="col-lg-2 pl"><p id="CUSTOMER_TITLE"><?php if($objResponse->CUSTOMER_TYPE =='Customer'): ?>Customer <?php else: ?> Prospect <?php endif; ?></p></div>
        <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="hidden" name="CUSTOMER_TYPE" id="CUSTOMER_TYPE" value="<?php echo e(isset($objResponse->CUSTOMER_TYPE) && $objResponse->CUSTOMER_TYPE !=''?$objResponse->CUSTOMER_TYPE:''); ?>" class="form-control" autocomplete="off" />
          <input <?php echo e($ActionStatus); ?> type="text"  id="CUSTOMERPROSPECT_NAME" onclick="getCustProspect()"  value="<?php echo e(isset($objCustProspt->CCODE) && $objCustProspt->CCODE !=''?$objCustProspt->CCODE:''); ?> <?php echo e(isset($objCustProspt->CUSTNAME) && $objCustProspt->CUSTNAME !=''?'- '.$objCustProspt->CUSTNAME:''); ?><?php echo e(isset($objCustProspt->PCODE) && $objCustProspt->PCODE !=''?$objCustProspt->PCODE:''); ?> <?php echo e(isset($objCustProspt->PROSNAME) && $objCustProspt->PROSNAME !=''?'- '.$objCustProspt->PROSNAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
          <input <?php echo e($ActionStatus); ?> type="hidden" name="CUSTOMER_PROSPECT" id="CUSTOMER_PROSPECT" value="<?php echo e(isset($objCustProspt->CID) && $objCustProspt->CID !=''?$objCustProspt->CID:''); ?><?php echo e(isset($objCustProspt->PID) && $objCustProspt->PID !=''?$objCustProspt->PID:''); ?>" class="form-control" autocomplete="off" />
        </div>

        <div class="col-lg-2 pl"><p>Dealer</p></div>
        <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="text" name="DEALER" id="DEALER" value="<?php echo e(isset($objResp->DOCNO) && $objResp->DOCNO !=''?$objResp->DOCNO:''); ?> <?php echo e(isset($objResp->DEALERNAME) && $objResp->DEALERNAME !=''?'- '.$objResp->DEALERNAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
          <input <?php echo e($ActionStatus); ?> type="hidden" name="DEALERIDREF" id="DEALERID_REF" value="<?php echo e(isset($objResp->DEALERID_REF) && $objResp->DEALERID_REF !=''?$objResp->DEALERID_REF:''); ?>" class="form-control" autocomplete="off" />
        </div>

          <div class="col-lg-2 pl"><p>Convert Status</p></div>
          <div class="col-lg-2 pl">
            <select <?php echo e($ActionStatus); ?> name="CONVERTSTATUS" id="CONVERTSTATUS" class="form-control"  autocomplete="off">
              <option value="">Select</option>
              <option <?php echo e(isset($objResponse->CONVERT_STATUS) && $objResponse->CONVERT_STATUS == 'Prospecting'?'selected="selected"':''); ?> value="Prospecting">Prospecting</option>
              <option <?php echo e(isset($objResponse->CONVERT_STATUS) && $objResponse->CONVERT_STATUS == 'Qualifying Leads'?'selected="selected"':''); ?> value="Qualifying Leads">Qualifying Leads</option>
              <option <?php echo e(isset($objResponse->CONVERT_STATUS) && $objResponse->CONVERT_STATUS == 'Opportunity'?'selected="selected"':''); ?>value="Opportunity">Opportunity</option>
            </select> 
          </div>
        </div>       
        
        <div class="row">
            <div class="col-lg-2 pl"><p>Company Name*</p></div>
            <div class="col-lg-2 pl">
              <input <?php echo e($ActionStatus); ?> type="text" name="COMPANY_NAME" id="COMPANY_NAME" value="<?php echo e(isset($objResponse->COMPANY_NAME) && $objResponse->COMPANY_NAME !=''?$objResponse->COMPANY_NAME:''); ?>" class="form-control mandatory" autocomplete="off">                            
            </div>

            <input <?php echo e($ActionStatus); ?> type="hidden" name="FNAME" id="FNAME" value="<?php echo e(isset($objResponse->FIRST_NAME) && $objResponse->FIRST_NAME !=''?$objResponse->FIRST_NAME:''); ?>" class="form-control mandatory" autocomplete="off">                            
            <input <?php echo e($ActionStatus); ?> type="hidden" name="LNAME" id="LNAME" value="<?php echo e(isset($objResponse->LAST_NAME) && $objResponse->LAST_NAME !=''?$objResponse->LAST_NAME:''); ?>" class="form-control mandatory" autocomplete="off">                            

            <div class="col-lg-2 pl"><p>Contact Person</p></div>
            <div class="col-lg-2 pl">
              <input <?php echo e($ActionStatus); ?> type="text" name="CONTACT_PERSON" id="CONTACT_PERSON" value="<?php echo e(isset($objResponse->CONTACT_PERSON) && $objResponse->CONTACT_PERSON !=''?$objResponse->CONTACT_PERSON:''); ?>" class="form-control mandatory" autocomplete="off">                            
            </div>

            <div class="col-lg-2 pl"><p>Address*</p></div>
            <div class="col-lg-2 pl">
              <textarea <?php echo e($ActionStatus); ?> name="ADDRESS" id="ADDRESS" style="width: 192px;" class="form-control mandatory"><?php echo e(isset($objResponse->ADDRESS) && $objResponse->ADDRESS !=''?$objResponse->ADDRESS:''); ?></textarea>
            </div>
          </div>
       
          <div class="row">
          <div class="col-lg-2 pl"><p>Country*</p></div>
          <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="COUNTRY" id="COUNTRY" value="<?php echo e(isset($objResponse->CONTRYNAME) && $objResponse->CONTRYNAME !=''?$objResponse->CONTRYNAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
            <input <?php echo e($ActionStatus); ?> type="hidden" name="COUNTRYID_REF" id="COUNTRYID_REF" value="<?php echo e(isset($objResponse->CTRYID_REF) && $objResponse->CTRYID_REF !=''?$objResponse->CTRYID_REF:''); ?>" class="form-control" autocomplete="off" />
          </div>
        
          <div class="col-lg-2 pl"><p>State*</p></div>
          <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="STATE" id="STATE" value="<?php echo e(isset($objResponse->STATENAME) && $objResponse->STATENAME !=''?$objResponse->STATENAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
            <input <?php echo e($ActionStatus); ?> type="hidden" name="STATEID_REF" id="STATEID_REF" value="<?php echo e(isset($objResponse->STID_REF) && $objResponse->STID_REF !=''?$objResponse->STID_REF:''); ?>" class="form-control" autocomplete="off" />
          </div>

          <div class="col-lg-2 pl"><p>City*</p></div>
            <div class="col-lg-2 pl">
              <input <?php echo e($ActionStatus); ?> type="text" name="CITYID_REF_POPUP" id="CITYID_REF_POPUP" value="<?php echo e(isset($objResponse->CITYNAME) && $objResponse->CITYNAME !=''?$objResponse->CITYNAME:''); ?>" class="form-control mandatory" readonly tabindex="1" />
              <input <?php echo e($ActionStatus); ?> type="hidden" name="CITYID_REF" id="CITYID_REF" value="<?php echo e(isset($objResponse->CITYID_REF) && $objResponse->CITYID_REF !=''?$objResponse->CITYID_REF:''); ?>" />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 pl"><p>Pin-Code*</p></div>
            <div class="col-lg-2 pl">
              <input <?php echo e($ActionStatus); ?> type="text" name="PINCODE" id="PINCODE" value="<?php echo e(isset($objResponse->PINCODE) && $objResponse->PINCODE !=''?$objResponse->PINCODE:''); ?>" onkeypress="return onlyNumberKey(event)" maxlength="6" class="form-control mandatory" autocomplete="off">                             
            </div>
          
          <div class="col-lg-2 pl"><p>Lead Owner*</p></div>
          <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="LOWNER" id="LOWNER" value="<?php echo e(isset($objResponse->EMPCODE) && $objResponse->EMPCODE !=''?$objResponse->EMPCODE:''); ?> - <?php echo e($objResponse->FNAME); ?> <?php echo e($objResponse->MNAME); ?> <?php echo e($objResponse->LNAME); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
            <input <?php echo e($ActionStatus); ?> type="hidden" name="LOWNERID_REF" id="LOWNERID_REF" value="<?php echo e(isset($objResponse->LEADOWNERID_REF) && $objResponse->LEADOWNERID_REF !=''?$objResponse->LEADOWNERID_REF:''); ?>" class="form-control" autocomplete="off" />
          </div>

          <div class="col-lg-2 pl"><p>Industry Type*</p></div>
          <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="INTYPE" id="INTYPE" value="<?php echo e(isset($objResponse->INDSCODE) && $objResponse->INDSCODE !=''?$objResponse->INDSCODE:''); ?> - <?php echo e($objResponse->DESCRIPTIONS); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
            <input <?php echo e($ActionStatus); ?> type="hidden" name="INTYPEID_REF" id="INTYPEID_REF" value="<?php echo e(isset($objResponse->INDSID_REF) && $objResponse->INDSID_REF !=''?$objResponse->INDSID_REF:''); ?>" class="form-control" autocomplete="off" />
          </div>
          </div>

          <div class="row">
          <div class="col-lg-2 pl"><p>Designation*</p></div>
          <div class="col-lg-2 pl">
            <select <?php echo e($ActionStatus); ?> name="DESIGNID_REF" id="DESIGNID_REF" class="form-control mandatory">
              <option value="">Select</option>
              <?php $__currentLoopData = $design; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option <?php echo e(isset($objResponse->DESGINATION) && $objResponse->DESGINATION == $val->DESGID ?'selected="selected"':''); ?> value="<?php echo e($val->DESGID); ?>"><?php echo e($val->DESGCODE); ?> - <?php echo e($val->DESCRIPTIONS); ?></option> 
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>                            
          </div>
        
          <div class="col-lg-2 pl"><p>Remarks</p></div>
          <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="LEAD_DETAILS" id="LEAD_DETAILS" value="<?php echo e(isset($objResponse->LEAD_DETAILS) && $objResponse->LEAD_DETAILS !=''?$objResponse->LEAD_DETAILS:''); ?>" class="form-control mandatory" autocomplete="off">                            
          </div>

          <div class="col-lg-2 pl"><p>Website</p></div>
          <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="WEBSITENAME" id="WEBSITENAME" value="<?php echo e(isset($objResponse->WEBSITE) && $objResponse->WEBSITE !=''?$objResponse->WEBSITE:''); ?>" class="form-control">                            
          </div>
        </div>
          
        <div class="row">
          <div class="col-lg-2 pl"><p>Landline Number</p></div>
          <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="LANDNUMBER" id="LANDNUMBER" value="<?php echo e(isset($objResponse->LANDLINE_NUMBER) && $objResponse->LANDLINE_NUMBER !=''?$objResponse->LANDLINE_NUMBER:''); ?>" onkeypress="return onlyNumberKey(event)" class="form-control mandatory" autocomplete="off">                            
          </div>

          <div class="col-lg-2 pl"><p>Mobile Number*</p></div>
          <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="text" name="MOBILENUMBER" id="MOBILENUMBER" value="<?php echo e(isset($objResponse->MOBILE_NUMBER) && $objResponse->MOBILE_NUMBER !=''?$objResponse->MOBILE_NUMBER:''); ?>" onkeypress="return onlyNumberKey(event)" maxlength="12" class="form-control mandatory" autocomplete="off">                           
          </div>

          <div class="col-lg-2 pl"><p>E-Mail*</p></div>
          <div class="col-lg-2 pl">
            <input <?php echo e($ActionStatus); ?> type="email" name="EMAIL" id="EMAIL" value="<?php echo e(isset($objResponse->EMAIL) && $objResponse->EMAIL !=''?$objResponse->EMAIL:''); ?>" class="form-control mandatory" autocomplete="off">                            
          </div>
        </div>

      <div class="row">
        <div class="col-lg-2 pl"><p>Lead Source*</p></div>
        <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="text" name="LSOURCE" id="LSOURCE" value="<?php echo e(isset($objResponse->LEAD_SOURCENAME) && $objResponse->LEAD_SOURCENAME !=''?$objResponse->LEAD_SOURCENAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
          <input <?php echo e($ActionStatus); ?> type="hidden" name="LSOURCEID_REF" id="LSOURCEID_REF" value="<?php echo e(isset($objResponse->LEAD_SOURCE) && $objResponse->LEAD_SOURCE !=''?$objResponse->LEAD_SOURCE:''); ?>" class="form-control" autocomplete="off" />
        </div>

        <div class="col-lg-2 pl"><p>Lead Stage*</p></div>
        <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="text" name="LSTATUS" id="LSTATUS" value="<?php echo e(isset($objResponse->LEAD_STATUSCODE) && $objResponse->LEAD_STATUSCODE !=''?$objResponse->LEAD_STATUSCODE:''); ?> - <?php echo e($objResponse->LEAD_STATUSNAME); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
          <input <?php echo e($ActionStatus); ?> type="hidden" name="LSTATUSID_REF" id="LSTATUSID_REF" value="<?php echo e(isset($objResponse->LEAD_STATUS) && $objResponse->LEAD_STATUS !=''?$objResponse->LEAD_STATUS:''); ?>" class="form-control" autocomplete="off" />
        </div>

        <div class="col-lg-2 pl"><p>Transfer Leads*</p></div>
        <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="text" name="ASSIGTO" id="ASSIGTO" value="<?php echo e(isset($objTlead->ASSGNTOCODE) && $objTlead->ASSGNTOCODE !=''?$objTlead->ASSGNTOCODE:''); ?> - <?php echo e($objTlead->ASSGNTOFNAME); ?> <?php echo e($objTlead->ASSGNTOMNAME); ?> <?php echo e($objTlead->ASSGNTOLNAME); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
          <input <?php echo e($ActionStatus); ?> type="hidden" name="ASSIGTOID_REF" id="ASSIGTOID_REF" value="<?php echo e(isset($objTlead->ASSIGNTO_REF) && $objTlead->ASSIGNTO_REF !=''?$objTlead->ASSIGNTO_REF:''); ?>" class="form-control" autocomplete="off" />
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-2 pl"><p>Lead Closure</p></div>
        <div class="col-lg-2 pl">
          <select <?php echo e($ActionStatus); ?> name="LCLOSUR" id="LCLOSUR" class="form-control">
            <option value="">Select</option>
            <option <?php echo e(isset($objResponse->LEAD_CLOSURE) && $objResponse->LEAD_CLOSURE == '1'?'selected="selected"':''); ?> value="1">Yes</option>
            <option <?php echo e(isset($objResponse->LEAD_CLOSURE) && $objResponse->LEAD_CLOSURE == '0'?'selected="selected"':''); ?> value="0">No</option>
            </select>
        </div>

        <div class="col-lg-2 pl"><p>Remarks</p></div>
        <div class="col-lg-2 pl">
          <textarea <?php echo e($ActionStatus); ?> name="REMARKS" id="REMARKS" style="width: 192px;" class="form-control mandatory"><?php echo e(isset($objResponse->REMARKS) && $objResponse->REMARKS !=''?$objResponse->REMARKS:''); ?></textarea>
        </div>

        <div class="col-lg-2 pl"><p>Opportunity Type</p></div>
        <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="text" name="OPPRTYPE" id="OPPRTYPE_ONE" value="<?php echo e(isset($objResponse->OPPORTUNITY_TYPECODE) && $objResponse->OPPORTUNITY_TYPECODE !=''?$objResponse->OPPORTUNITY_TYPECODE:''); ?>  <?php echo e($objResponse->OPPORTUNITY_TYPENAME); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
          <input <?php echo e($ActionStatus); ?> type="hidden" name="OPPRTYPEID_REF" id="OPPRTYPEID_REF" value="<?php echo e(isset($objResponse->OPPTYTYPEID) && $objResponse->OPPTYTYPEID !=''?$objResponse->OPPTYTYPEID:''); ?>" class="form-control" autocomplete="off" />
        </div>
      </div>
  
      <div class="row">
        <div class="col-lg-2 pl"><p>Opportunity Stage</p></div>
        <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="text" name="OPPRSTAGE" id="OPPRSTAGE_ONE" value="<?php echo e(isset($objResponse->OPPORTUNITY_STAGECODE) && $objResponse->OPPORTUNITY_STAGECODE !=''?$objResponse->OPPORTUNITY_STAGECODE:''); ?>  <?php echo e($objResponse->OPPORTUNITY_STAGENAME); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
          <input type="hidden" name="OPPRSTAGEID_REF" id="OPPRSTAGEID_REF" value="<?php echo e(isset($objResponse->ID) && $objResponse->ID !=''?$objResponse->ID:''); ?>" class="form-control" autocomplete="off" />
        </div>

        <div class="col-lg-2 pl"><p>Opportuntity Stage Completed (%)</p></div>
        <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="text" name="OPPRSTAGECOMP" id="OPPRSTAGECOMP" value="<?php echo e(isset($objResponse->COMPLETE_PERCENT) && $objResponse->COMPLETE_PERCENT !=''?$objResponse->COMPLETE_PERCENT:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/>
        </div>

        <div class="col-lg-2 pl"><p>Expected date</p></div>
          <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="date" name="EXPECTED_DT" id="EXPECTED_DT" value="<?php echo e(isset($objResponse->EXPECTED_DATE) && $objResponse->EXPECTED_DATE !=''?$objResponse->EXPECTED_DATE:''); ?>" class="form-control mandatory" autocomplete="off" placeholder="dd/mm/yyyy" readonly>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-2 pl"><p>Opportunity Date</p></div>
          <div class="col-lg-2 pl">
          <input <?php echo e($ActionStatus); ?> type="date" name="OPPORTUNITY_DT" id="OPPORTUNITY_DT" value="<?php echo e(isset($objResponse->OPPORTUNITY_DATE) && $objResponse->OPPORTUNITY_DATE !=''?$objResponse->OPPORTUNITY_DATE:''); ?>" class="form-control mandatory" autocomplete="off" placeholder="dd/mm/yyyy" readonly>
        </div>
      </div>


      <div class="row">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#DetailBlock" id="MAT_TAB" >Other Contact Person</a></li>
          <li><a data-toggle="tab" href="#SiteDetails">Statuatory Details</a></li>
          <li><a data-toggle="tab" href="#NewCall">New Call</a></li>
          <li><a data-toggle="tab" href="#NewTasks">New Tasks</a></li>
          <li><a data-toggle="tab" href="#ProductDetails">Product Details</a></li>
        </ul>

        Note:- 1 row mandatory in Tab
        <div class="tab-content">
        <div id="DetailBlock" class="tab-pane fade in active">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
              <table id="example1" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                <thead id="thead1"  style="position: sticky;top: 0">                      
                  <tr>                          
                  <th rowspan="2" width="3%">Title</th>
                  <th rowspan="2" width="3%">First Name</th>
                  <th rowspan="2" width="3%">Last Name</th>
                  <th rowspan="2" width="3%">Designation</th>
                  <th rowspan="2" width="3%">Mobile</th>
                  <th rowspan="2" width="3%">E-Mail</th>
                  <th rowspan="2" width="3%">Action </th>
                </tr>                      
                  
              </thead>
                <tbody>
                  <?php if(!empty($MAT)): ?>
                  <?php $__currentLoopData = $MAT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr  class="participantRow">
                    <td>
                      <select <?php echo e($ActionStatus); ?> name="TITAL[]" id =<?php echo e("TITAL_".$key); ?> class="form-control">
                        <option value="">Select</option>
                        <option <?php echo e(isset($row->TITLE) && $row->TITLE == 'Mr'?'selected="selected"':''); ?> value="Mr">Mr.</option>
                        <option <?php echo e(isset($row->TITLE) && $row->TITLE == 'Mrs'?'selected="selected"':''); ?> value="Mrs">Mrs.</option>
                        <option <?php echo e(isset($row->TITLE) && $row->TITLE == 'Ms'?'selected="selected"':''); ?>value="Ms">Ms.</option>
                        <option <?php echo e(isset($row->TITLE) && $row->TITLE == 'Dr'?'selected="selected"':''); ?>value="Dr">Dr.</option>
                        </select>
                    <td><input <?php echo e($ActionStatus); ?>  class="form-control" type="text" name="FIRSTNAME[]" id =<?php echo e("FIRSTNAME_".$key); ?> value="<?php echo e(isset($row->FIRST_NAME) && $row->FIRST_NAME !=''?$row->FIRST_NAME:''); ?>"     autocomplete="off"></td>
                    <td><input <?php echo e($ActionStatus); ?>  class="form-control" type="text" name="LASTNAME[]"  id =<?php echo e("LASTNAME_".$key); ?>  value="<?php echo e(isset($row->LAST_NAME) && $row->LAST_NAME !=''?$row->LAST_NAME:''); ?>"        autocomplete="off"></td>
                    
                    <td><select <?php echo e($ActionStatus); ?> name="DESIG[]" id =<?php echo e("DESIG_".$key); ?> class="form-control mandatory">
                      <option value="">Select</option>  
                      <?php $__currentLoopData = $design; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e(isset($row->DESGINATION) && $row->DESGINATION == $val->DESGID ?'selected="selected"':''); ?> value="<?php echo e($val->DESGID); ?>"><?php echo e($val->DESGCODE); ?> - <?php echo e($val->DESCRIPTIONS); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </td>
                    
                    <td><input <?php echo e($ActionStatus); ?>  class="form-control" type="text" name="MOBILE[]"    id =<?php echo e("MOBILE_".$key); ?>    value="<?php echo e(isset($row->MOBILE_NUMBER) && $row->MOBILE_NUMBER !=''?$row->MOBILE_NUMBER:''); ?>"   onkeypress="return onlyNumberKey(event)" maxlength="12" autocomplete="off"></td>
                    <td><input <?php echo e($ActionStatus); ?>  class="form-control" type="text" name="EMAILS[]"    id =<?php echo e("EMAILS_".$key); ?>    value="<?php echo e(isset($row->EMAIL) && $row->EMAIL !=''?$row->EMAIL:''); ?>" autocomplete="off"></td>
                      
                    <td align="center">
                      <button <?php echo e($ActionStatus); ?> class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                      <button <?php echo e($ActionStatus); ?> class="btn remove" title="Delete" data-toggle="tooltip" disabled><i class="fa fa-trash" ></i></button>
                      </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </tbody>
              </table>
          </div>	
      </div>
  
          <div id="SiteDetails" class="tab-pane fade in ">
              <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                  <thead id="thead1"  style="position: sticky;top: 0">                      
                    <tr>                          
                    <th rowspan="2" width="3%">Site Name</th>
                    <th rowspan="2" width="3%">Address 1</th>
                    <th rowspan="2" width="3%">Address 2</th>
                    <th rowspan="2" width="3%">Country</th>
                    <th rowspan="2" width="3%">State</th>
                    <th rowspan="2" width="3%">City</th>
                    <th rowspan="2" width="3%">Pin-Code</th>
                    <th rowspan="2" width="3%">Phone No</th>
                    <th rowspan="2" width="3%">Mobile No</th>
                    <th rowspan="2" width="3%">Action</th>
                  </tr>                      
                    
                </thead>
                  <tbody>
                    <?php if(!empty($MATSITE)): ?>
                    <?php $n=1; ?>
                    <?php $__currentLoopData = $MATSITE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <tr  class="participantRow">
                      <td><input <?php echo e($ActionStatus); ?>  class="form-control" type="text" name="SITENAME[]" id =<?php echo e("SITENAME_".$key); ?> value="<?php echo e(isset($row->SITENAME) && $row->SITENAME !=''?$row->SITENAME:''); ?>" autocomplete="off"></td>
                      <td><input <?php echo e($ActionStatus); ?>  class="form-control" type="text" name="ADDRESS1[]" id =<?php echo e("ADDRESS1_".$key); ?> value="<?php echo e(isset($row->ADDRESS1) && $row->ADDRESS1 !=''?$row->ADDRESS1:''); ?>" autocomplete="off"></td>
                      <td><input <?php echo e($ActionStatus); ?>  class="form-control" type="text" name="ADDRESS2[]" id =<?php echo e("ADDRESS2_".$key); ?> value="<?php echo e(isset($row->ADDRESS2) && $row->ADDRESS2 !=''?$row->ADDRESS2:''); ?>" autocomplete="off"></td>
                      <td>
                        <select <?php echo e($ActionStatus); ?> name="CTRYID_REF[]" id =<?php echo e("CTRYID_REF_".$key); ?> onchange="getstate(this,'SDETAILS')" class="form-control mandatory">
                          <option value="">Select</option>
                          <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option <?php echo e(isset($row->CTRYID_REF) && $row->CTRYID_REF == $val->CTRYID ?'selected="selected"':''); ?> value="<?php echo e($val->CTRYID); ?>"><?php echo e(isset($val->CTRYCODE) && $val->CTRYCODE !=''?$val->CTRYCODE:''); ?> <?php echo e(isset($val->NAME) && $val->NAME !=''?'- '.$val->NAME:''); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                        </td>
                      <td><select <?php echo e($ActionStatus); ?> name="STATEIDREF[]" id =<?php echo e("STATEIDREF_".$key); ?> onchange="getcity(this,'SDCITY')" class="form-control mandatory">
                        <option value="">Select</option>
                        <option <?php echo e(isset($row->STID_REF) && $row->STID_REF == $row->STID ?'selected="selected"':''); ?> value="<?php echo e(isset($row->STID) && $row->STID !=''?$row->STID:''); ?>"><?php echo e(isset($row->STCODE) && $row->STCODE !=''?$row->STCODE:''); ?> <?php echo e(isset($row->NAME) && $row->NAME !=''?'-'.$row->NAME:''); ?></option>
                        </select>
                      </td>
                      <td><select <?php echo e($ActionStatus); ?> name="CITYIDREF[]" id =<?php echo e("CITYIDREF_".$key); ?> class="form-control mandatory">
                        <option value="">Select</option>
                        <option <?php echo e(isset($row->CITYID_REF) && $row->CITYID_REF == $row->CITYID ?'selected="selected"':''); ?> value="<?php echo e(isset($row->CITYID) && $row->CITYID !=''?$row->CITYID:''); ?>"><?php echo e(isset($row->CITYCODE) && $row->CITYCODE !=''?$row->CITYCODE:''); ?> <?php echo e(isset($row->CITYNAME) && $row->CITYNAME !=''?'-'.$row->CITYNAME:''); ?></option>
                        </select>
                      </td>
                      <td><input <?php echo e($ActionStatus); ?>  class="form-control" type="text" name="PINCODES[]" id =<?php echo e("PINCODES_".$key); ?> value="<?php echo e(isset($row->PINCODE) && $row->PINCODE !=''?$row->PINCODE:''); ?>"                        onkeypress="return onlyNumberKey(event)" maxlength="6" autocomplete="off"></td>
                      <td><input <?php echo e($ActionStatus); ?>  class="form-control" type="text" name="PHONENO[]"  id =<?php echo e("PHONENO_".$key); ?>  value="<?php echo e(isset($row->CONTACT_NUMBER) && $row->CONTACT_NUMBER !=''?$row->CONTACT_NUMBER:''); ?>"   onkeypress="return onlyNumberKey(event)" autocomplete="off"></td>
                      <td><input <?php echo e($ActionStatus); ?>  class="form-control" type="text" name="MOBILENO[]" id =<?php echo e("MOBILENO_".$key); ?> value="<?php echo e(isset($row->MOBILE_NUMBER) && $row->MOBILE_NUMBER !=''?$row->MOBILE_NUMBER:''); ?>"      onkeypress="return onlyNumberKey(event)" maxlength="12" autocomplete="off"></td>
                      
                        
                      <td align="center">
                        <button <?php echo e($ActionStatus); ?> class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                        <button <?php echo e($ActionStatus); ?> class="btn remove" title="Delete" data-toggle="tooltip" disabled><i class="fa fa-trash" ></i></button>
                        </td>
                    </tr>
                    <?php $n++; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                <?php endif; ?>
                  </tbody>
                </table>
              </div>	
          </div>
  
  
            <div id="NewCall" class="tab-pane fade in ">	
               <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                <table id="example3" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                  <thead id="thead1"  style="position: sticky;top: 0">                      
                    <tr>                          
                    <th rowspan="2">Activity Type</th>
                    <th rowspan="2">Activity Date</th>
                    <th rowspan="2">Activity Time</th>
                    <th rowspan="2">Contact Person</th>
                    <th rowspan="2">Activity Detail</th>

                    <th rowspan="2">Additonal Member Visit</th>
                    <th rowspan="2">Transport Mode</th>
                    <th rowspan="2">Expense amt</th>

                    <th rowspan="2">Response</th>
                    <th rowspan="2">Action Plan</th>
                    <th rowspan="2">Reminder Detail</th>
                    <th rowspan="2">Reminder Date</th>
                    <th rowspan="2">Reminder Time</th>
                    <th rowspan="2">Alert Message</th>
                    <th rowspan="2">Alert To</th>
                    <th rowspan="2">Action</th>
                  </tr>                      
                    
                </thead>
                  <tbody>
                    <?php if(!empty($MATNEWCALL)): ?>
                    <?php $n=1; ?>
                    <?php $__currentLoopData = $MATNEWCALL; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <tr  class="participantRow">
                      <td>
                        <select <?php echo e($ActionStatus); ?> name="ACTIVITYIDREF[]" id =<?php echo e("ACTIVITYID_REF_".$key); ?> class="form-control mandatory" style="width: 110px;">
                          <option value="">Select</option>
                          <?php $__currentLoopData = $activitytype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e(isset($row->ACTIVITYID_REF) && $row->ACTIVITYID_REF == $val->ID ?'selected="selected"':''); ?> value="<?php echo e($val->ID); ?>"><?php echo e($val->ACTIVITYNAME); ?></option> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select> 
                      </td>
                      <td><input <?php echo e($ActionStatus); ?>  class="form-control mandatory" type="date" name="ACTYDATE[]"      id =<?php echo e("ACTYDATE_".$key); ?> value="<?php echo e(isset($row->ACTIVITY_DATE) && $row->ACTIVITY_DATE !=''?$row->ACTIVITY_DATE:''); ?>" autocomplete="off"></td>
                      <td>
                        <?php
                        //$acttime = explode(".",$row->ACTIVITY_TIME);
                        $ACTIVITY_TIME = date('H:i:s',strtotime(isset($row->ACTIVITY_TIME) && $row->ACTIVITY_TIME !=''?$row->ACTIVITY_TIME:''));
                        ?>
                        <input <?php echo e($ActionStatus); ?>  class="form-control mandatory" type="time" name="ACTIVITYTIME[]"  id =<?php echo e("ACTIVITY_TIME_".$key); ?> value="<?php echo e(isset($ACTIVITY_TIME) && $ACTIVITY_TIME !=''?$ACTIVITY_TIME:''); ?>"  autocomplete="off">
                      </td>

                      <td>
                        <select <?php echo e($ActionStatus); ?> name="CONTACTPERSON[]" id =<?php echo e("CONTACTPERSON_".$key); ?> class="form-control mandatory" style="width: 120px;">
                          <option value="">Select</option>
                          <?php $__currentLoopData = $conctprsn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option <?php echo e(isset($row->CONTACT_PERSON) && $row->CONTACT_PERSON == $row->CONTACT_PERSON ?'selected="selected"':''); ?> value="<?php echo e(isset($val->FIRST_NAME) && $val->FIRST_NAME !=''?$val->FIRST_NAME:''); ?> <?php echo e(isset($val->LAST_NAME) && $val->LAST_NAME !=''?$val->LAST_NAME:''); ?>"><?php echo e(isset($row->CONTACT_PERSON) && $row->CONTACT_PERSON !=''?$row->CONTACT_PERSON:''); ?></option> 
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                        </td>
                      <td><textarea <?php echo e($ActionStatus); ?> class="form-control mandatory"            name="ACTYDETAIL[]"     id =<?php echo e("ACTYDETAIL_".$key); ?> style="width: 110px;"><?php echo e(isset($row->ACTIVITY_DETAILS) && $row->ACTIVITY_DETAILS !=''?$row->ACTIVITY_DETAILS:''); ?></textarea></td>
                      
                      <td>
                        <input <?php echo e($ActionStatus); ?> type="text" name="ADDMEMBERVISIT[]" id="ADDMEMBERVISIT_0" value="<?php echo e(isset($row->FNAME) && $row->FNAME !=''?$row->FNAME:''); ?>"  class="form-control mandatory"  autocomplete="off" readonly style="width: 160px;"/>
                      </td>
                      
                      <td hidden>
                      <input type="hidden" name="ADDMEMBERVISITID_REF[]"  id="HIDDEN_ADDMEMBERVISIT_0" value="<?php echo e(isset($row->ADDITIONAL_EMPLOYEE_ID) && $row->ADDITIONAL_EMPLOYEE_ID !=''?$row->ADDITIONAL_EMPLOYEE_ID:''); ?>"  class="form-control mandatory" autocomplete="off" />
                      </td>

                      <td>
                        <select <?php echo e($ActionStatus); ?> name="EXPDETAILS[]" id =<?php echo e("EXPDETAILS_".$key); ?> class="form-control mandatory" style="width: 110px;">
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
                        
                      <td><input <?php echo e($ActionStatus); ?>  class="form-control mandatory" type="text" name="TENTEXPAMT[]" id =<?php echo e("TENTEXPAMT_".$key); ?> value="<?php echo e(isset($row->TENTATIVE_EXPENSES) && $row->TENTATIVE_EXPENSES !=''?$row->TENTATIVE_EXPENSES:''); ?>" autocomplete="off" onkeypress="return onlyNumberKey(event)" style="width: 110px;"></td>
                      
                      
                      <td>
                        <select <?php echo e($ActionStatus); ?> name="RESPONSE[]" id =<?php echo e("RESPONSE_".$key); ?> class="form-control mandatory" style="width: 110px;">
                          <option value="">Select</option>
                          <?php $__currentLoopData = $resp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option <?php echo e(isset($row->RESPONSEID_REF) && $row->RESPONSEID_REF == $val->ID ?'selected="selected"':''); ?> value="<?php echo e($val->ID); ?>"><?php echo e($val->RESPONSENAME); ?></option> 
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select> 
                      </td>
                      <td><textarea <?php echo e($ActionStatus); ?> name="ACTPLAN[]" id =<?php echo e("ACTPLAN_".$key); ?>  class="form-control mandatory" style="width: 160px;"><?php echo e(isset($row->ACTION_PLAN) && $row->ACTION_PLAN !=''?$row->ACTION_PLAN:''); ?></textarea></td>
                      <td>
                        <select <?php echo e($ActionStatus); ?> name="REMNDETAILID_REF[]" id =<?php echo e("REMNDETAILID_REF_".$key); ?> class="form-control mandatory" style="width: 110px;">
                          <option value="">Select</option>
                          <option <?php echo e(isset($row->REMINDER_DETAIL) && $row->REMINDER_DETAIL == 'Meeting'?'selected="selected"':''); ?> value="Meeting">Meeting</option>
                          <option <?php echo e(isset($row->REMINDER_DETAIL) && $row->REMINDER_DETAIL == 'Mail'?'selected="selected"':''); ?> value="Mail">Mail</option>
                          <option <?php echo e(isset($row->REMINDER_DETAIL) && $row->REMINDER_DETAIL == 'Call'?'selected="selected"':''); ?>value="Call">Call</option>
                          </select>
                      </td>
                      <td><input <?php echo e($ActionStatus); ?> type="date" name="REMNDDATE[]" id =<?php echo e("REMNDDATE_".$key); ?> value="<?php echo e(isset($row->REMINDER_DATE) && $row->REMINDER_DATE !=''?$row->REMINDER_DATE:''); ?>" class="form-control mandatory" autocomplete="off" style="width: 110px;"></td>
                      <td>
                        <?php
                        //$remtime = explode(".",$row->REMINDER_TIME);
                        $REMINDER_TIME = date('H:i:s',strtotime(isset($row->REMINDER_TIME) && $row->REMINDER_TIME !=''?$row->REMINDER_TIME:''));
                        ?>
                        <input <?php echo e($ActionStatus); ?> type="time" name="REMINDERTIME[]" id =<?php echo e("REMINDER_TIME_".$key); ?>  value="<?php echo e(isset($REMINDER_TIME) && $REMINDER_TIME !=''?$REMINDER_TIME:''); ?>" class="form-control mandatory" autocomplete="off" style="width: 110px;">
                      </td>
                      
                      <td><textarea <?php echo e($ActionStatus); ?> name="ALERTMSG[]" id =<?php echo e("ALERTMSG_".$key); ?>  class="form-control mandatory" style="width: 160px;"><?php echo e(isset($row->ALERT_MESSAGE) && $row->ALERT_MESSAGE !=''?$row->ALERT_MESSAGE:''); ?></textarea></td>
                      
                      <td><input <?php echo e($ActionStatus); ?> type="text" name="ALERTTO[]" id =<?php echo e("ALERTTO_".$key); ?> onclick="getAlertTo(this.id,this.value)" value="<?php echo e(isset($row->ALTFNAME) && $row->ALTFNAME !=''?$row->ALTFNAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly style="width: 120px;"/></td>
                      <td hidden><input <?php echo e($ActionStatus); ?> type="hidden" name="ALERTTOID_REF[]" id =<?php echo e("ALERTTOID_REF_".$key); ?> value="<?php echo e(isset($row->ALERT_TO) && $row->ALERT_TO !=''?$row->ALERT_TO:''); ?>" class="form-control mandatory" autocomplete="off" /></td>

                      <td style="width: 110px;">
                        <button <?php echo e($ActionStatus); ?> class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                        <button <?php echo e($ActionStatus); ?> class="btn remove" title="Delete" data-toggle="tooltip" disabled><i class="fa fa-trash" ></i></button>
                        </td>
                    </tr>
                    <?php $n++; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                <?php endif; ?>
                </tbody>
              </table>
          </div>
        </div>
  
            <div id="NewTasks" class="tab-pane fade in">
                <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
                  <table id="example4" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                    <thead id="thead1"  style="position: sticky;top: 0">                      
                      <tr>                          
                      <th rowspan="2" width="3%">Task Type</th>
                      <th rowspan="2" width="3%">Assigned To</th>
                      <th rowspan="2" width="3%">Subject</th>
                      <th rowspan="2" width="3%">Priority</th>
                      <th rowspan="2" width="3%">Task Detail</th>
                      <th rowspan="2" width="3%">Due Date</th>
                      <th rowspan="2" width="3%">Status </th>
                      <th rowspan="2" width="3%">Reminder </th>
                      <th rowspan="2" width="3%">Action </th>
                    </tr>                      
                      
                  </thead>
                    <tbody>
                      <?php if(!empty($NEWTASKS)): ?>
                      <?php $n=1; ?>
                      <?php $__currentLoopData = $NEWTASKS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
                      <tr  class="participantRow">
                        <td>
                          <select <?php echo e($ActionStatus); ?> name="TASKTYPEID_REF[]" id =<?php echo e("TASKTYPEID_REF_".$key); ?> class="form-control mandatory">
                            <option value="">Select</option>
                          <?php $__currentLoopData = $tasktype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option <?php echo e(isset($row->TASKID_REF) && $row->TASKID_REF == $val->ID ?'selected="selected"':''); ?> value="<?php echo e($val->ID); ?>"><?php echo e($val->TASK_TYPENAME); ?></option> 
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select> 
                        </td>

                        <td><input <?php echo e($ActionStatus); ?> type="text" name="ASSGNDTO[]" id =<?php echo e("ASSGNDTO_".$key); ?> onclick="getAssignedTo(this.id,this.value)" value="<?php echo e(isset($row->EMPCODE) && $row->EMPCODE !=''?$row->EMPCODE:''); ?>  <?php echo e(isset($row->FNAME) && $row->FNAME !=''?$row->FNAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/></td>
                        <td hidden><input <?php echo e($ActionStatus); ?> type="hidden" name="ASSGNDTOID_REF[]" id =<?php echo e("ASSGNDTOID_REF_".$key); ?> value="<?php echo e(isset($row->EMPID) && $row->EMPID !=''?$row->EMPID:''); ?>" class="form-control" autocomplete="off" /></td>
                        
                        <td><textarea <?php echo e($ActionStatus); ?> name="SUBJECT[]" id =<?php echo e("SUBJECT_".$key); ?> class="form-control mandatory"><?php echo e(isset($row->SUBJECT) && $row->SUBJECT !=''?$row->SUBJECT:''); ?></textarea></td>
                        <td>
                          <select <?php echo e($ActionStatus); ?> name="PRIORITYID_REF[]" id =<?php echo e("PRIORITYID_REF_".$key); ?> class="form-control mandatory">
                            <option value="">Select</option>
                            <?php $__currentLoopData = $priorty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option <?php echo e(isset($row->PRIORITYID_REF) && $row->PRIORITYID_REF == $val->PAYPERIODID ?'selected="selected"':''); ?> value="<?php echo e($val->PAYPERIODID); ?>"><?php echo e($val->PAY_PERIOD_CODE); ?></option>  
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select> 
                        </td>
                        <td><textarea <?php echo e($ActionStatus); ?> name="TASKDETAIL[]" id =<?php echo e("TASKDETAIL_".$key); ?> class="form-control mandatory"><?php echo e(isset($row->TASK_DETAIL) && $row->TASK_DETAIL !=''?$row->TASK_DETAIL:''); ?></textarea></td>
                        
                        <td><input <?php echo e($ActionStatus); ?> type="date" name="DUEDATE[]" id =<?php echo e("DUEDATE_".$key); ?> value="<?php echo e(isset($row->DUE_DATE) && $row->DUE_DATE !=''?$row->DUE_DATE:''); ?>" class="form-control mandatory" autocomplete="off"> </td>
                        <td>
                          <select <?php echo e($ActionStatus); ?> name="STATUSID_REF[]" id =<?php echo e("STATUSID_REF_".$key); ?> class="form-control mandatory">
                            <option value="">Select</option>
                            <option <?php echo e(isset($row->TASK_STATUS) && $row->TASK_STATUS == 'Meeting'?'selected="selected"':''); ?> value="Meeting">Meeting</option>
                          <option <?php echo e(isset($row->TASK_STATUS) && $row->TASK_STATUS == 'Mail'?'selected="selected"':''); ?> value="Mail">Mail</option>
                          <option <?php echo e(isset($row->TASK_STATUS) && $row->TASK_STATUS == 'Call'?'selected="selected"':''); ?>value="Call">Call</option>
                          </select>
                        </td>
                        <td><input <?php echo e($ActionStatus); ?> type="date" name="REMINDER[]" id =<?php echo e("REMINDER_".$key); ?> value="<?php echo e(isset($row->TASK_REMINDER_DATE) && $row->TASK_REMINDER_DATE !=''?$row->TASK_REMINDER_DATE:''); ?>" class="form-control mandatory" autocomplete="off"></td>
                          
                        <td align="center">
                          <button <?php echo e($ActionStatus); ?> class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                          <button <?php echo e($ActionStatus); ?> class="btn remove" title="Delete" data-toggle="tooltip" disabled><i class="fa fa-trash" ></i></button>
                          </td>
                      </tr>
                      <?php $n++; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    <?php endif; ?>
                    </tbody>
                  </table>
              </div>	
          </div>




          <div id="ProductDetails" class="tab-pane fade in">
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
              <table id="example5" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
                <thead id="thead1"  style="position: sticky;top: 0">                      
                  <tr>                          
                  <th rowspan="2" width="3%">Product Code</th>
                  <th rowspan="2" width="3%">Product Name</th>
                  <th rowspan="2" width="3%">Product Qty</th>
                  <th rowspan="2" width="3%">Product Price</th>
                  <th rowspan="2" width="3%">Total Amount</th>
                  <th rowspan="2" width="3%">Action </th>
                </tr>                      
                  
              </thead>
                <tbody>
                  <?php if(!empty($PRODUCTDETAILS)): ?>
                  <?php $n=1; ?>
                  <?php $__currentLoopData = $PRODUCTDETAILS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                  <tr  class="participantRow">
                    <td><input <?php echo e($ActionStatus); ?> type="text" name="PRODUCTNAME[]" id =<?php echo e("PRODUCTNAME_".$key); ?> onclick="getProductName(this.id)"   value="<?php echo e(isset($row->ICODE) && $row->ICODE !=''?$row->ICODE:''); ?>  <?php echo e(isset($row->NAME) && $row->NAME !=''?$row->NAME:''); ?>" class="form-control mandatory"  autocomplete="off" readonly/></td>
                    <td hidden><input type="hidden" name="PRODUCTID_REF[]" id="PRODUCTID_REF_<?php echo e($key); ?>" value="<?php echo e(isset($row->ITEMID) && $row->ITEMID !=''?$row->ITEMID:''); ?>" class="form-control" autocomplete="off" /></td>
                    <td><input <?php echo e($ActionStatus); ?> type="text" id="PRODUCT_DESC_<?php echo e($key); ?>" value="<?php echo e(isset($row->NAME) && $row->NAME !=''?$row->NAME:''); ?>" class="form-control" readonly  > </td>
                    
                    <td><input <?php echo e($ActionStatus); ?> type="text" name="PRODUCT_QTY[]" id="PRODUCT_QTY_<?php echo e($key); ?>" value="<?php echo e(isset($row->QUANTITY) && $row->QUANTITY !=''?$row->QUANTITY:''); ?>" onkeyup="getProductDetails(this.id,this.value)" onkeypress="return isNumberKey(this, event);" class="form-control minAmt" onkeypress="return onlyNumberKey(event)"></td>
                    <td><input <?php echo e($ActionStatus); ?> type="text" name="PRODUCT_PRICE[]" id="PRODUCT_PRICE_<?php echo e($key); ?>" value="<?php echo e(isset($row->RATE) && $row->RATE !=''?$row->RATE:''); ?>" onkeyup="getProductDetails(this.id,this.value)" onkeypress="return isNumberKey(this, event);" class="form-control" onkeypress="return onlyNumberKey(event)"></td>
                    <td><input <?php echo e($ActionStatus); ?> type="text" name="PRODUCT_AMOUNT[]" id="TOTAL_AMOUNT_<?php echo e($key); ?>" value="<?php echo e(isset($row->AMOUNT) && $row->AMOUNT !=''?$row->AMOUNT:''); ?>" class="form-control" readonly></td>
                    <td align="center">
                      <button <?php echo e($ActionStatus); ?> class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                      <button <?php echo e($ActionStatus); ?> class="btn remove" title="Delete" data-toggle="tooltip" disabled><i class="fa fa-trash" ></i></button>
                      </td>
                  </tr>
                  <?php $n++; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                <?php endif; ?>
                </tbody>
              </table>
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

<div id="ITEMIDpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width:90%">
    <div class="modal-content" >
      <div class="modal-header"><button type="button" class="close" data-dismiss="modal" id='ITEMID_closePopup' >&times;</button></div>
      <div class="modal-body">
	      <div class="tablename"><p>Item Details</p></div>
	      <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
          <table id="ItemIDTable" class="display nowrap table  table-striped table-bordered" style="width:100%" >
            <thead>
              <tr id="none-select" class="searchalldata" hidden>
                <td> 
                  <input type="text" name="fieldid1" id="hdn_ItemID1"/>
                  <input type="text" name="fieldid2" id="hdn_ItemID2"/>
                  <input type="text" name="fieldid3" id="hdn_ItemID3"/>
                  <input type="text" name="fieldid4" id="hdn_ItemID4"/>
                  <input type="text" name="fieldid5" id="hdn_ItemID5"/>
                  <input type="text" name="fieldid6" id="hdn_ItemID6"/>
                  <input type="text" name="fieldid7" id="hdn_ItemID7"/>
                  <input type="text" name="fieldid8" id="hdn_ItemID8"/>
                  <input type="text" name="fieldid9" id="hdn_ItemID9"/>
                  <input type="text" name="fieldid10" id="hdn_ItemID10"/>
                  <input type="text" name="fieldid10" id="hdn_ItemID11"/>
                  <input type="text" name="fieldid10" id="hdn_ItemID12"/>
                  <input type="text" name="fieldid18" id="hdn_ItemID18"/>
                  <input type="text" name="fieldid19" id="hdn_ItemID19"/>
                  <input type="text" name="fieldid20" id="hdn_ItemID20"/>
                  <input type="text" name="hdn_ItemID21" id="hdn_ItemID21" value="0"/>
                  <input type="text" name="fieldid22" id="hdn_ItemID22"/>
                  <input type="text" name="fieldid23" id="hdn_ItemID23"/>
                  <input type="text" name="fieldid24" id="hdn_ItemID24"/>
                  <input type="text" name="fieldid25" id="hdn_ItemID25"/>
                </td>
              </tr>

              <tr>
                <th style="width:8%;" id="all-check">Select</th>
                <th style="width:10%;">Item Code</th>
                <th style="width:10%;">Name</th>
                <th style="width:8%;">Main UOM</th>
                <th style="width:8%;">Qty</th>
                <th style="width:8%;">Item Group</th>
                <th style="width:8%;">Item Category</th>
                <th style="width:8%;">Business Unit</th>
                <th style="width:8%;"><?php echo e(isset($TabSetting->FIELD8) && $TabSetting->FIELD8 !=''?$TabSetting->FIELD8:'Add. Info Part No'); ?></th>
                <th style="width:8%;"><?php echo e(isset($TabSetting->FIELD9) && $TabSetting->FIELD9 !=''?$TabSetting->FIELD9:'Add. Info Customer Part No'); ?></th>
                <th style="width:8%;"><?php echo e(isset($TabSetting->FIELD10) && $TabSetting->FIELD10 !=''?$TabSetting->FIELD10:'Add. Info OEM Part No.'); ?></th>
                <th style="width:8%;">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width:8%;text-align:center;"><!--<input type="checkbox" class="js-selectall" data-target=".js-selectall1" />--></td>
                <td style="width:10%;"><input type="text" id="Itemcodesearch" class="form-control" autocomplete="off" onkeyup="ItemCodeFunction(event)"></td>
                <td style="width:10%;"><input type="text" id="Itemnamesearch" class="form-control" autocomplete="off" onkeyup="ItemNameFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemUOMsearch" class="form-control" autocomplete="off" onkeyup="ItemUOMFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemQTYsearch" class="form-control" autocomplete="off" onkeyup="ItemQTYFunction(event)" readonly></td>
                <td style="width:8%;"><input type="text" id="ItemGroupsearch" class="form-control" autocomplete="off" onkeyup="ItemGroupFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemCategorysearch" class="form-control" autocomplete="off" onkeyup="ItemCategoryFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemBUsearch" class="form-control" autocomplete="off" onkeyup="ItemBUFunction(event)" readonly></td>
                <td style="width:8%;"><input type="text" id="ItemAPNsearch" class="form-control" autocomplete="off" onkeyup="ItemAPNFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemCPNsearch" class="form-control" autocomplete="off" onkeyup="ItemCPNFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemOEMPNsearch" class="form-control" autocomplete="off" onkeyup="ItemOEMPNFunction(event)"></td>
                <td style="width:8%;"><input  type="text" id="ItemStatussearch" class="form-control" autocomplete="off" onkeyup="ItemStatusFunction(event)" readonly></td>
              </tr>
            </tbody>
          </table>

          <table id="ItemIDTable2" class="display nowrap table  table-striped table-bordered" style="width:100%" >
            <thead id="thead2"></thead>
            <tbody id="tbody_ItemID" style="font-size:13px;"></tbody>
          </table>
        </div>
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
  
          <div class="tablename"><p id='title_name'></p></div>
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
              <tbody id="tbody_divpopp"></tbody>
            </table>
  
          </div>
  
          <div class="cl"></div>
  
        </div>
      </div>
    </div>
  </div>
  
  <div id="stateidref_popup" class="modal" role="dialog"  data-backdrop="static">
    <div class="modal-dialog modal-md column3_modal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id='stateidref_close' >&times;</button>
        </div>
      <div class="modal-body">
      <div class="tablename"><p>State Details</p></div>
      <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
  
        <table id="state_tab1" class="display nowrap table  table-striped table-bordered">
          <thead>
            <tr>
              <th class="ROW1">Select</th> 
              <th class="ROW2">Code</th>
              <th  class="ROW3">Name</th>
            </tr>
          </thead>
          <tbody>
          <tr>
            <td class="ROW1"><span class="check_th">&#10004;</span></td>
            <td  class="ROW2"><input type="text" class="form-control" autocomplete="off" id="statecodesearch"  onkeyup='colSearch("state_tab2","statecodesearch",1)'></td>
            <td  class="ROW3"><input type="text" class="form-control" autocomplete="off"  id="statenamesearch"  onkeyup='colSearch("state_tab2","statenamesearch",2)'></td>
          </tr>
          </tbody>
        </table>
  
        <table id="state_tab2" class="display nowrap table  table-striped table-bordered">
          <tbody id="state_body">
          </tbody>
        </table>
      </div>
      <div class="cl"></div>
        </div>
      </div>
    </div>
  </div>
  
  <div id="cityidref_popup" class="modal" role="dialog"  data-backdrop="static">
    <div class="modal-dialog modal-md column3_modal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id='cityidref_close' >&times;</button>
        </div>
      <div class="modal-body">
      <div class="tablename"><p>City Details</p></div>
      <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
  
        <table id="city_tab1" class="display nowrap table  table-striped table-bordered">
          <thead>
            <tr>
              <th class="ROW1">Select</th> 
              <th class="ROW2">Code</th>
              <th  class="ROW3">Name</th>
            </tr>
          </thead>
          <tbody>
          <tr>
            <td class="ROW1"><span class="check_th">&#10004;</span></td>
            <td  class="ROW2"><input type="text" class="form-control" autocomplete="off" id="citycodesearch"  onkeyup='colSearch("city_tab2","citycodesearch",1)'></td>
            <td  class="ROW3"><input type="text" class="form-control" autocomplete="off"  id="citynamesearch"  onkeyup='colSearch("city_tab2","citynamesearch",2)'></td>
          </tr>
          </tbody>
        </table>
  
        <table id="city_tab2" class="display nowrap table  table-striped table-bordered">
          <tbody id="city_body">
          </tbody>
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
  
  
  
/*************************************   Opportunity Type  Start  ************************** */
function getCustomer(value){
  $("#CUSTOMER_TITLE").html(value);
  $("#CUSTOMER_TYPE").val(value);
  $("#CUSTOMERPROSPECT_NAME").val('');
  $("#CUSTOMER_PROSPECT").val('');

  $("#ADDRESS").val('');
  $("#COUNTRY").val('');
  $("#COUNTRYID_REF").val('');
  $("#STATE").val('');
  $("#STATEID_REF").val('');
  $("#CITYID_REF_POPUP").val('');
  $("#CITYID_REF").val('');
  $("#PINCODE").val('');
}

function getCustProspect(){

var type  = $("input[name='CUSTOMER']:checked").val();
var msg   = type;

$('#tbody_divpopp').html('Loading...'); 
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
  $('#tbody_divpopp').html(data);
  bindCustPostEvents(type);
  },
  error:function(data){
    console.log("Error: Something went wrong.");
    $('#tbody_divpopp').html('');
  },
});

$("#tital_Name").text(msg);
$("#modalpopup").show();
}


$("#OPPRTYPE").on("click",function(event){ 

$('#tbody_divpopp').html('Loading...');
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'<?php echo e(route("transaction",[$FormId,"getOpportunityTypeCode"])); ?>',
    type:'POST',
    success:function(data) {
        $('#tbody_divpopp').html(data);
        bindOppTypeEvents();
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $('#tbody_divpopp').html('');
    },
});   
$("#title_name").text('Opportunity Type Details');     
$("#modalpopup").show();
event.preventDefault();
});

$("#modalclosePopup").on("click",function(event){ 
  $("#modalpopup").hide();
  event.preventDefault();
});

function bindOppTypeEvents(){
  $('.clsopptype').click(function(){
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc");
  $("#OPPRTYPE").val(texdesc);
  $("#OPPRTYPEID_REF").val(txtval);
  $("#modalpopup").hide();
  });
}
/*************************************   Opportunity Type  End  ************************** */
   
/*************************************   Opportunity Stage Start  ************************** */
$("#OPPRSTAGE").on("click",function(event){ 

$('#tbody_divpopp').html('Loading...');
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'<?php echo e(route("transaction",[$FormId,"getOpportunityStageCode"])); ?>',
    type:'POST',
    success:function(data) {
        $('#tbody_divpopp').html(data);
        bindOppStageEvents();
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $('#tbody_divpopp').html('');
    },
});    
$("#title_name").text('Opportunity Stage Details');    
$("#modalpopup").show();
event.preventDefault();
});

function bindOppStageEvents(){
  $('.clsoppstage').click(function(){
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc");
  var texccpert =   $("#txt"+id+"").data("ccpert");
  $("#OPPRSTAGE").val(texdesc);
  $("#OPPRSTAGEID_REF").val(txtval);
  $("#OPPRSTAGECOMP").val(texccpert);
  $("#modalpopup").hide();
  });
}
/*************************************   Opportunity Stage  End  ************************** */
   
/*************************************   Customer Start  ************************** */

function bindCustPostEvents(type){
        $('.cls'+type).click(function(){
          if($(this).is(':checked') == true){
          var id = $(this).attr('id');
          var txtval =    $("#txt"+id+"").val();
          var texdesc =   $("#txt"+id+"").data("desc");

          var texadd1 =   $("#txt"+id+"").data("cregadd1");
          var texadd2 =   $("#txt"+id+"").data("cregadd2");
          var texpin =   $("#txt"+id+"").data("cregpin");
          var texcontry =   $("#txt"+id+"").data("ccntry");
          var texstate =   $("#txt"+id+"").data("ccstate");
          var texcity =   $("#txt"+id+"").data("ccity");

          var texcontryid =   $("#txt"+id+"").data("ccntryid");
          var texstateid =   $("#txt"+id+"").data("ccstateid");
          var texcityid =   $("#txt"+id+"").data("cccityid");

          $("#CUSTOMERPROSPECT_NAME").val(texdesc);
          $("#CUSTOMER_PROSPECT").val(txtval);

          $("#ADDRESS").val(texadd1);
          $("#PINCODE").val(texpin);
          $("#COUNTRY").val(texcontry);
          $("#STATE").val(texstate);
          $("#CITYID_REF_POPUP").val(texcity);

          $("#COUNTRYID_REF").val(texcontryid);
          $("#STATEID_REF").val(texstateid);
          $("#CITYID_REF").val(texcityid);
          
          $("#modalpopup").hide();
          }
        });
      }

/*************************************   Lead Owner Start  ************************** */
$("#LOWNER").on("click",function(event){ 

$('#tbody_divpopp').html('Loading...');
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'<?php echo e(route("transaction",[$FormId,"getLeadOwnerCode"])); ?>',
    type:'POST',
    success:function(data) {
        $('#tbody_divpopp').html(data);
        bindLeadOwnerEvents();
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $('#tbody_divpopp').html('');
    },
});    
$("#title_name").text('Lead Owner Details');    
$("#modalpopup").show();
event.preventDefault();
});

function bindLeadOwnerEvents(){
  $('.clsemp').click(function(){
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc");
  $("#LOWNER").val(texdesc);
  $("#LOWNERID_REF").val(txtval);
  $("#modalpopup").hide();
  });
}
/*************************************   Lead Owner End  ************************** */

/*************************************   Industry Type Start  ************************** */
$("#INTYPE").on("click",function(event){ 

$('#tbody_divpopp').html('Loading...');
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'<?php echo e(route("transaction",[$FormId,"getIndustryTypeCode"])); ?>',
    type:'POST',
    success:function(data) {
        $('#tbody_divpopp').html(data);
        bindIndustryTypeEvents();
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $('#tbody_divpopp').html('');
    },
});    
$("#title_name").text('Industry Type Details');    
$("#modalpopup").show();
event.preventDefault();
});

function bindIndustryTypeEvents(){
  $('.clsindtype').click(function(){
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc");
  $("#INTYPE").val(texdesc);
  $("#INTYPEID_REF").val(txtval);
  $("#modalpopup").hide();
  });
}
/*************************************   Industry Type End  ************************** */

/*************************************   Industry Type Start  ************************** */
$("#ASSIGTO").on("click",function(event){ 

$('#tbody_divpopp').html('Loading...');
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'<?php echo e(route("transaction",[$FormId,"getLeadOwnerCode"])); ?>',
    type:'POST',
    success:function(data) {
        $('#tbody_divpopp').html(data);
        bindAssignedToEvents();
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $('#tbody_divpopp').html('');
    },
});    
$("#title_name").text('Assigned To Details');    
$("#modalpopup").show();
event.preventDefault();
});

function bindAssignedToEvents(){
  $('.clsemp').click(function(){
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc");
  $("#ASSIGTO").val(texdesc);
  $("#ASSIGTOID_REF").val(txtval);
  $("#modalpopup").hide();
  });
}
/*************************************   Industry Type End  ************************** */

/*************************************   Lead Source Start  ************************** */
$("#LSOURCE").on("click",function(event){ 

$('#tbody_divpopp').html('Loading...');
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'<?php echo e(route("transaction",[$FormId,"getLeadSourceCode"])); ?>',
    type:'POST',
    success:function(data) {
        $('#tbody_divpopp').html(data);
        bindLeadSourceEvents();
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $('#tbody_divpopp').html('');
    },
});    
$("#title_name").text('Lead Sourcess Details');    
$("#modalpopup").show();
event.preventDefault();
});

function bindLeadSourceEvents(){
  $('.clsldsce').click(function(){
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc");
  $("#LSOURCE").val(texdesc);
  $("#LSOURCEID_REF").val(txtval);
  $("#modalpopup").hide();
  });
}
/*************************************   Lead Source End  ************************** */


/*************************************   Dealer Start  ************************** */
$("#DEALER").on("click",function(event){ 

$('#tbody_divpopp').html('Loading...');
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'<?php echo e(route("transaction",[$FormId,"getDealerCode"])); ?>',
    type:'POST',
    success:function(data) {
        $('#tbody_divpopp').html(data);
        bindDealerEvents();
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $('#tbody_divpopp').html('');
    },
});    
$("#title_name").text('Dealer Details');    
$("#modalpopup").show();
event.preventDefault();
});

function bindDealerEvents(){
  $('.clsldlr').click(function(){
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc");
  $("#DEALER").val(texdesc);
  $("#DEALERID_REF").val(txtval);
  $("#modalpopup").hide();
  });
}
/*************************************   Dealer End  ************************** */



















/*************************************   Lead Status Start  ************************** */
$("#LSTATUS").on("click",function(event){ 

$('#tbody_divpopp').html('Loading...');
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'<?php echo e(route("transaction",[$FormId,"getLeadStatusCode"])); ?>',
    type:'POST',
    success:function(data) {
        $('#tbody_divpopp').html(data);
        bindLeadStatusEvents();
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $('#tbody_divpopp').html('');
    },
});    
$("#title_name").text('Lead Status Details');    
$("#modalpopup").show();
event.preventDefault();
});

function bindLeadStatusEvents(){
  $('.clsldst').click(function(){
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc");
  $("#LSTATUS").val(texdesc);
  $("#LSTATUSID_REF").val(txtval);
  $("#modalpopup").hide();
  });
}
/*************************************   Lead Status End  ************************** */

/*************************************   Additonal Member Visit  Start  ************************** */
$('#NewCall').on('click','[id*="ADDMEMBERVISIT"]',function(event){

var id = $(this).attr('id');


$('#tbody_divpopp').html('Loading...');
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$.ajax({
  url:'<?php echo e(route("transaction",[$FormId,"getAddMemberVisitCode"])); ?>',
  type:'POST',
  success:function(data) {
      $('#tbody_divpopp').html(data);
      bindAddMeberEvents(id);
  },
  error:function(data){
      console.log("Error: Something went wrong.");
      $('#tbody_divpopp').html('');
  },
}); 
$("#title_name").text('Additonal Member Visit Details');       
$("#modalpopup").show();
event.preventDefault();
});

$("#addmeber_closePopup").on("click",function(event){ 
$("#modalpopup").hide();
event.preventDefault();
});

function bindAddMeberEvents(id){
$('.clsaddmeb').click(function(){
var addId_Ref = []
var addCode = []
$('.clsaddmeb:checked').each(function() {     
  addId_Ref.push($(this).val())
});
$('.clsaddmeb:checked').each(function() {       
  addCode.push($(this).data("desc1"))
});

$("#"+id).val(addCode);
$("#HIDDEN_"+id).val(addId_Ref);
//$("#modalpopup").hide();
});
}
/*************************************   Additonal Member Visit  End  ************************** */


/*************************************   Country Start  ************************** */
$("#COUNTRY").on("click",function(event){ 
$('#tbody_divpopp').html('Loading...');
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url:'<?php echo e(route("transaction",[$FormId,"getCountryCode"])); ?>',
    type:'POST',
    success:function(data) {
        $('#tbody_divpopp').html(data);
        bindCountryEvents();
    },
    error:function(data){
        console.log("Error: Something went wrong.");
        $('#tbody_divpopp').html('');
    },
});    
$("#title_name").text('Country Details');    
$("#modalpopup").show();
event.preventDefault();
});

function bindCountryEvents(){
  $('.clscontry').click(function(){
  var id = $(this).attr('id');
  var txtval =    $("#txt"+id+"").val();
  var texdesc =   $("#txt"+id+"").data("desc");
  $("#COUNTRY").val(texdesc);
  $("#COUNTRYID_REF").val(txtval);
  getCountryWiseState(txtval);
  $("#modalpopup").hide();
  });
}

/*************************************   Country End  ************************** */

/*************************************   State Start  ************************** */

function getCountryWiseState(CTRYID_REF){
    $("#state_body").html('');
		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:'<?php echo e(route("transaction",[$FormId,"getCountryWiseState"])); ?>',
        type:'POST',
        data:{CTRYID_REF:CTRYID_REF},
        success:function(data) {
          $("#STATE").val('');
          $("#STATEID_REF").val('');
          $("#CITYID_REF_POPUP").val('');
          $("#CITYID_REF").val('');
          $("#State_Name").val('');
          $("#STID_REF_POPUP").val('');
          $("#STID_REF").val('');
          $("#City_Name").val('');
          $("#city_body").html('');
          $("#state_body").html(data);
          bindStateEvents(); 

        },
        error:function(data){
          console.log("Error: Something went wrong.");
          $("#state_body").html('');
          
        },
    });	
  }

  // State popup function
$("#STATE").on("click",function(event){
  var COUNTRYID_REF    =   $.trim($("#COUNTRYID_REF").val());  
  if(COUNTRYID_REF ===""){
    alertMsg('COUNTRY','Please Select Country.');
  }else{
    $("#title_name").text('State Details'); 
    $("#stateidref_popup").show();
  }
});

$("#stateidref_close").on("click",function(event){ 
  $("#stateidref_popup").hide();
});

function bindStateEvents(){
  $('.cls_stidref').click(function(){
    var id          =   $(this).attr('id');
    var txtval      =   $("#txt"+id+"").val();
    var texdesc     =   $("#txt"+id+"").data("desc");
    var texdescname =   $("#txt"+id+"").data("descname");
    $("#STATE").val(texdesc);
    $("#STATEID_REF").val(txtval);
    var CTRYID_REF	=	$("#COUNTRYID_REF").val();
	  getStateWiseCity(CTRYID_REF,txtval);
    $("#stateidref_popup").hide();
    event.preventDefault();
  });
}

/*************************************   State End  ************************** */

/*************************************   City Start  ************************** */
// Citiy popup function
function getStateWiseCity(CTRYID_REF,STID_REF){
    $("#city_body").html('');
		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
		
    $.ajax({
        url:'<?php echo e(route("transaction",[$FormId,"getStateWiseCity"])); ?>',
        type:'POST',
        data:{CTRYID_REF:CTRYID_REF,STID_REF:STID_REF},
        success:function(data) {
            $("#City_Name").val('');
            $("#CITYID_REF_POPUP").val('');
            $("#CITYID_REF").val('');
            $("#city_body").html(data);
            bindCityEvents(); 
			
        },
        error:function(data){
          console.log("Error: Something went wrong.");
          $("#city_body").html('');
          
        },
    });	
  }

$("#CITYID_REF_POPUP").on("click",function(event){ 
  var STATEID_REF    =   $.trim($("#STATEID_REF").val());  
  if(STATEID_REF ===""){
    alertMsg('STATE','Please Select State.');
  }else{
  $("#cityidref_popup").show();
  }
});

$("#CITYID_REF_POPUP").keyup(function(event){
  if(event.keyCode==13){
    $("#cityidref_popup").show();
  }
});

$("#cityidref_close").on("click",function(event){ 
  $("#cityidref_popup").hide();
});

function bindCityEvents(){
	$('.cls_cityidref').click(function(){
		var id = $(this).attr('id');
		var txtval =    $("#txt"+id+"").val();
		var texdesc =   $("#txt"+id+"").data("desc");
    var texdescname =   $("#txt"+id+"").data("descname");

    $("#City_Name").val(texdescname);
		$("#CITYID_REF_POPUP").val(texdesc);
    $("#CITYID_REF").val(txtval);
    $("#CITYID_REF_POPUP").blur(); 
	  $("#DISTCODE").focus(); 
		$("#cityidref_popup").hide();
		event.preventDefault();
	});
}

/*************************************   City End  ************************** */

/*************************************   All Search Start  ************************** */

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
  
        
        var LEAD_NO        =   $.trim($("#LEAD_NO").val());
        var LEAD_DT        =   $.trim($("#LEAD_DT").val());
        var CUSTOMER       =   $.trim($("#CUSTOMER").val());
        var PROSPECT       =   $.trim($("#PROSPECT").val());
        var COMPANY_NAME   =   $.trim($("#COMPANY_NAME").val());
        var FNAME          =   $.trim($("#FNAME").val());
        var LOWNERID_REF   =   $.trim($("#LOWNERID_REF").val());
        var INTYPEID_REF   =   $.trim($("#INTYPEID_REF").val());
        var DESIGNID_REF   =   $.trim($("#DESIGNID_REF").val());
        var MOBILENUMBER   =   $.trim($("#MOBILENUMBER").val());
        var EMAIL          =   $.trim($("#EMAIL").val());
        var LSOURCEID_REF  =   $.trim($("#LSOURCEID_REF").val());
        var LSTATUSID_REF  =   $.trim($("#LSTATUSID_REF").val());
        var ASSIGTOID_REF  =   $.trim($("#ASSIGTOID_REF").val());
        var ADDRESS        =   $.trim($("#ADDRESS").val());
        var COUNTRYID_REF  =   $.trim($("#COUNTRYID_REF").val());
        var STATEID_REF    =   $.trim($("#STATEID_REF").val());
        var CITYID_REF     =   $.trim($("#CITYID_REF").val());
        var PINCODE        =   $.trim($("#PINCODE").val());
    
        
        $("#OkBtn1").hide();
        if(LEAD_NO ===""){
          alertMsg('LEAD_NO','Please enter Lead No.');
        }
        else if(LEAD_DT ===""){
          alertMsg('LEAD_DT','Please enter Date.');
        }
        else if(COMPANY_NAME ===""){
          alertMsg('COMPANY_NAME','Please enter Company Name.');
        }
        else if(FNAME ===""){
          alertMsg('FNAME','Please enter First Name.');
        }
        
        else if(LOWNERID_REF ==="") {
          alertMsg('LOWNERID_REF','Please Select Lead Owner.');
        }
        else if(INTYPEID_REF ==="") {
          alertMsg('INTYPEID_REF','Please Select Industry Type.');
        }
        else if(DESIGNID_REF ==="") {
          alertMsg('DESIGNID_REF','Please Select Designation.');
        }
        else if(MOBILENUMBER ==="") {
          alertMsg('MOBILENUMBER','Please enter Mobile Number.');
        }
        
        else if(EMAIL ===""){
          alertMsg('EMAIL','Please enter E-Mail.');
        } 
        
        else if(LSOURCEID_REF ==="") {
          alertMsg('LSOURCEID_REF','Please Select Lead Source.');
        }
  
        else if(LSTATUSID_REF ===""){
          alertMsg('LSTATUSID_REF','Please Select Lead Status.');
        }
  
        else if(ASSIGTOID_REF ===""){
          alertMsg('ASSIGTOID_REF','Please Select Assigned To.');
        }
  
        else if(ADDRESS ===""){
          alertMsg('ADDRESS','Please enter Address.');
        }
  
        else if(COUNTRYID_REF ===""){
          alertMsg('COUNTRYID_REF','Please Select Country.');
        }
  
        else if(STATEID_REF ===""){
          alertMsg('STATEID_REF','Please Select State.');
        }
  
        else if(CITYID_REF ===""){
          alertMsg('CITYID_REF','Please Select City.');
        }
  
        else if(PINCODE.length < 6 ){
        alertMsg('PINCODE','Please enter Correct Pin-Code.');
      }
      else{
        event.preventDefault();
          var allblank1 = [];
          var focustext1= "";
          var textmsg = "";

          $('#example2').find('.participantRow').each(function(){
            if($.trim($(this).find("[id*=SITENAME]").val()) ==""){
            allblank1.push('false');
            focustext1 = $(this).find("[id*=SITENAME]").attr('id');
            textmsg = 'Please enter Site Name	Site Details Material Tab';
            }
            
            else if($.trim($(this).find("[id*=ADDRESS1]").val()) ==""){
              allblank1.push('false');
              focustext1 = $(this).find("[id*=ADDRESS1]").attr('id');
              textmsg = 'Please enter Address 1	Site Details Material Tab';
            }

            else if($.trim($(this).find("[id*=ADDRESS2]").val()) ==""){
              allblank1.push('false');
              focustext1 = $(this).find("[id*=ADDRESS2]").attr('id');
              textmsg = 'Please enter Address 2 Site Details Material Tab';
            }

            else if($.trim($(this).find("[id*=CTRYID_REF]").val()) ==""){
              allblank1.push('false');
              focustext1 = $(this).find("[id*=CTRYID_REF]").attr('id');
              textmsg = 'Please enter Country Site Details Material Tab';
            }

            else if($.trim($(this).find("[id*=STATEIDREF]").val()) ==""){
              allblank1.push('false');
              focustext1 = $(this).find("[id*=STATEIDREF]").attr('id');
              textmsg = 'Please enter State Site Details Material Tab';
            }

            else if($.trim($(this).find("[id*=CITYIDREF]").val()) ==""){
              allblank1.push('false');
              focustext1 = $(this).find("[id*=CITYIDREF]").attr('id');
              textmsg = 'Please enter City Site Details Material Tab';
            }

            else if($.trim($(this).find("[id*=PINCODES]").val()) ==""){
              allblank1.push('false');
              focustext1 = $(this).find("[id*=PINCODES]").attr('id');
              textmsg = 'Please enter Pin-Code Site Details Material Tab';
            }

            else if($.trim($(this).find("[id*=PHONENO]").val()) ==""){
              allblank1.push('false');
              focustext1 = $(this).find("[id*=PHONENO]").attr('id');
              textmsg = 'Please enter Phone No Site Details Material Tab';
            }

            else if($.trim($(this).find("[id*=MOBILENO]").val()) ==""){
              allblank1.push('false');
              focustext1 = $(this).find("[id*=MOBILENO]").attr('id');
              textmsg = 'Please enter Mobile No Site Details Material Tab';
            }

          });

        if(jQuery.inArray("false", allblank1) !== -1){
            $("#focusid").val(focustext1);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").hide();  
            $("#OkBtn").show();
            $("#AlertMessage").text(textmsg);
            $("#alert").modal('show');
            $("#OkBtn").focus();
            highlighFocusBtn('activeOk');
            return false;
          } 
          else{
            $("#alert").modal('show');
            $("#AlertMessage").text('Do you want to save to record.');
            $("#YesBtn").data("funcname","fnSaveData");  
            $("#YesBtn").focus();
            highlighFocusBtn('activeYes');
          }
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
        $("#DESCRIPTIONS").blur(function(){
            $(this).val($.trim( $(this).val() ));
            $("#ERROR_DESCRIPTIONS").hide();
            validateSingleElemnet("DESCRIPTIONS");
        });
    
        $( "#DESCRIPTIONS" ).rules( "add", {
            required: true,
            normalizer: function(value) {
                return $.trim(value);
            },
            messages: {
              required: "Required field."
            }
        });
    
        function validateSingleElemnet(element_id){
          var validator =$("#frm_mst_edit" ).validate();
             if(validator.element( "#"+element_id+"" )){
              if(element_id=="ATTCODE" || element_id=="attcode" ) {
                checkDuplicateCode();
              }
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
                    showError('ERROR_ATTCODE',data.msg);
                    $("#ATTCODE").focus();
                    }                                
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                },
            });
        }
    
        function submitData(type){
        if(formResponseMst.valid()){
          $("#alert").modal('show');
          $("#AlertMessage").text('Do you want to save to record.');
          $("#YesBtn").data("funcname",type);
          $("#YesBtn").focus();
          highlighFocusBtn('activeYes');
        }
      }

      window.fnSaveData = function (){
        submitForm('update');
      };

      window.fnApproveData = function (){
        submitForm('approve');
      }
            
function submitForm(requestType){
var getDataForm = $("#frm_mst_edit");
var formData = getDataForm.serialize() + "&requestType=" + requestType ;
//var formData = getDataForm.append(requestType);
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
      $("#OkBtn").show();
      $("#AlertMessage").text(data.msg);
      $(".text-danger").hide();
      $("#alert").modal('show');
      $("#OkBtn").focus();
      }     
      if(data.errors) {
        $("#YesBtn").hide();
        $("#NoBtn").hide();
        $("#OkBtn1").show();
        $("#AlertMessage").text(data.msg);
        $("#alert").modal('show');
        $("#OkBtn1").focus();
      }
    },
    error:function(data){
    console.log("Error: Something went wrong.");
    },
  });

}

$("#YesBtn").click(function(){
  $("#alert").modal('hide');
  var customFnName = $("#YesBtn").data("funcname");
  window[customFnName]();
});

  $("#NoBtn").click(function(){
  $("#alert").modal('hide');
  var custFnName = $("#NoBtn").data("funcname");
  window[custFnName]();
  });

    //delete row
    $("#DetailBlock").on('click', '.remove', function() {
        var rowCount = $(this).closest('table').find('.participantRow').length;
        if (rowCount > 1) {
        $(this).closest('.participantRow').remove();     
        } 
        if (rowCount <= 1) { 
              $("#YesBtn").hide();
              $("#NoBtn").hide();
              $("#OkBtn").hide();
              $("#OkBtn1").show();
              $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
              $("#alert").modal('show');
              $("#OkBtn1").focus();
              highlighFocusBtn('activeOk1');
              return false;
        }
        event.preventDefault();
    });
    
    //add row
    $("#DetailBlock").on('click', '.add', function() {
      var $tr = $(this).closest('table');
      var allTrs = $tr.find('.participantRow').last();
      var lastTr = allTrs[allTrs.length-1];
      var $clone = $(lastTr).clone();
    
      $clone.find('td').each(function(){
        var el = $(this).find(':first-child');
        var id = el.attr('id') || null;
          if(id){
              var idLength = id.split('_').pop();
              var i = id.substr(id.length-idLength.length);
              var prefix = id.substr(0, (id.length-idLength.length));
              el.attr('id', prefix+(+i+1));
          }
      });
    
      $clone.find('input:text').val('');
      $clone.find('input:hidden').val('');
      $tr.closest('table').append($clone);         
      var rowCount1 = $('#Row_Count').val();
      rowCount1 = parseInt(rowCount1)+1;
      $('#Row_Count').val(rowCount1);
      $clone.find('.remove').removeAttr('disabled'); 
      event.preventDefault();
    });
    
    //delete row
    $("#SiteDetails").on('click', '.remove', function() {
        var rowCount = $(this).closest('table').find('.participantRow').length;
        if (rowCount > 1) {
        $(this).closest('.participantRow').remove();     
        } 
        if (rowCount <= 1) { 
              $("#YesBtn").hide();
              $("#NoBtn").hide();
              $("#OkBtn").hide();
              $("#OkBtn1").show();
              $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
              $("#alert").modal('show');
              $("#OkBtn1").focus();
              highlighFocusBtn('activeOk1');
              return false;
        }
        event.preventDefault();
    });
    
    
    //add row
    $("#SiteDetails").on('click', '.add', function() {
      var $tr = $(this).closest('table');
      var allTrs = $tr.find('.participantRow').last();
      var lastTr = allTrs[allTrs.length-1];
      var $clone = $(lastTr).clone();
    
      $clone.find('td').each(function(){
        var el = $(this).find(':first-child');
        var id = el.attr('id') || null;
          if(id){
              var idLength = id.split('_').pop();
              var i = id.substr(id.length-idLength.length);
              var prefix = id.substr(0, (id.length-idLength.length));
              el.attr('id', prefix+(+i+1));
          }
      });
    
      $clone.find('input:text').val('');
      $clone.find('input:hidden').val('');
      $tr.closest('table').append($clone);         
      var rowCount1 = $('#Row_Count').val();
      rowCount1 = parseInt(rowCount1)+1;
      $('#Row_Count').val(rowCount1);
      $clone.find('.remove').removeAttr('disabled'); 
      event.preventDefault();
    });



    
    //add row NewCall
    $("#NewCall").on('click', '.add', function() {
      var $tr = $(this).closest('table');
      var allTrs = $tr.find('.participantRow').last();
      var lastTr = allTrs[allTrs.length-1];
      var $clone = $(lastTr).clone();
    
      $clone.find('td').each(function(){
        var el = $(this).find(':first-child');
        var id = el.attr('id') || null;
          if(id){
              var idLength = id.split('_').pop();
              var i = id.substr(id.length-idLength.length);
              var prefix = id.substr(0, (id.length-idLength.length));
              el.attr('id', prefix+(+i+1));
          }
      });
    
      $clone.find('input:text').val('');
      $clone.find('input:hidden').val('');
      $tr.closest('table').append($clone);         
      var rowCount1 = $('#Row_Count').val();
      rowCount1 = parseInt(rowCount1)+1;
      $('#Row_Count').val(rowCount1);
      $clone.find('.remove').removeAttr('disabled'); 
      event.preventDefault();
    });

    //delete row NewCall
    $("#NewCall").on('click', '.remove', function() {
        var rowCount = $(this).closest('table').find('.participantRow').length;
        if (rowCount > 1) {
        $(this).closest('.participantRow').remove();     
        } 
        if (rowCount <= 1) { 
              $("#YesBtn").hide();
              $("#NoBtn").hide();
              $("#OkBtn").hide();
              $("#OkBtn1").show();
              $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
              $("#alert").modal('show');
              $("#OkBtn1").focus();
              highlighFocusBtn('activeOk1');
              return false;
        }
        event.preventDefault();
    });



    //add row NewTasks
    $("#NewTasks").on('click', '.add', function() {
      var $tr = $(this).closest('table');
      var allTrs = $tr.find('.participantRow').last();
      var lastTr = allTrs[allTrs.length-1];
      var $clone = $(lastTr).clone();
    
      $clone.find('td').each(function(){
        var el = $(this).find(':first-child');
        var id = el.attr('id') || null;
          if(id){
              var idLength = id.split('_').pop();
              var i = id.substr(id.length-idLength.length);
              var prefix = id.substr(0, (id.length-idLength.length));
              el.attr('id', prefix+(+i+1));
          }
      });
    
      $clone.find('input:text').val('');
      $clone.find('input:hidden').val('');
      $tr.closest('table').append($clone);         
      var rowCount1 = $('#Row_Count').val();
      rowCount1 = parseInt(rowCount1)+1;
      $('#Row_Count').val(rowCount1);
      $clone.find('.remove').removeAttr('disabled'); 
      event.preventDefault();
    });

    //delete row NewTasks
    $("#NewTasks").on('click', '.remove', function() {
        var rowCount = $(this).closest('table').find('.participantRow').length;
        if (rowCount > 1) {
        $(this).closest('.participantRow').remove();     
        } 
        if (rowCount <= 1) { 
              $("#YesBtn").hide();
              $("#NoBtn").hide();
              $("#OkBtn").hide();
              $("#OkBtn1").show();
              $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
              $("#alert").modal('show');
              $("#OkBtn1").focus();
              highlighFocusBtn('activeOk1');
              return false;
        }
        event.preventDefault();
    });
   
    //add row ProductDetails
    $("#ProductDetails").on('click', '.add', function() {
      var $tr = $(this).closest('table');
      var allTrs = $tr.find('.participantRow').last();
      var lastTr = allTrs[allTrs.length-1];
      var $clone = $(lastTr).clone();
    
      $clone.find('td').each(function(){
        var el = $(this).find(':first-child');
        var id = el.attr('id') || null;
          if(id){
              var idLength = id.split('_').pop();
              var i = id.substr(id.length-idLength.length);
              var prefix = id.substr(0, (id.length-idLength.length));
              el.attr('id', prefix+(+i+1));
          }
      });
    
      $clone.find('input:text').val('');
      $clone.find('input:hidden').val('');
      $tr.closest('table').append($clone);         
      var rowCount1 = $('#Row_Count').val();
      rowCount1 = parseInt(rowCount1)+1;
      $('#Row_Count').val(rowCount1);
      $clone.find('.remove').removeAttr('disabled'); 
      event.preventDefault();
    });

    //delete row ProductDetails
    $("#ProductDetails").on('click', '.remove', function() {
        var rowCount = $(this).closest('table').find('.participantRow').length;
        if (rowCount > 1) {
        $(this).closest('.participantRow').remove();     
        } 
        if (rowCount <= 1) { 
              $("#YesBtn").hide();
              $("#NoBtn").hide();
              $("#OkBtn").hide();
              $("#OkBtn1").show();
              $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
              $("#alert").modal('show');
              $("#OkBtn1").focus();
              highlighFocusBtn('activeOk1');
              return false;
        }
        event.preventDefault();
    });



        
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
            window.location.href = "<?php echo e(route('transaction',[$FormId,'index'])); ?>";
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
              //window.location.href = "<?php echo e(route('transaction',[$FormId,'index'])); ?>";
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
    
        function getstate(txt,stxtid){

          var id  = txt.id;
          var val = txt.value;

          if(stxtid ==='SDETAILS'){
            var rowid = id.split('_').pop();
            var stxtid  = "STATEIDREF_"+rowid;
          }

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });	
    
            $.ajax({
                url:'<?php echo e(route("transaction",[$FormId,"getstate"])); ?>',
                type:'POST',
                data:{id:val},
                success:function(data) {
                   $("#"+stxtid).html(data);
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                },
            });	
      }
  
  
      function getcity(txt,citytxtid){

        var id  = txt.id;
        var val = txt.value;

        if(citytxtid ==='SDCITY'){
          var rowid = id.split('_').pop();
          var citytxtid  = "CITYIDREF_"+rowid;
        }

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });	
    
            $.ajax({
                url:'<?php echo e(route("transaction",[$FormId,"getcity"])); ?>',
                type:'POST',
                data:{id:val},
                success:function(data) {
                  $("#"+citytxtid).html(data);      
                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                },
            });	
        }

    function getProductName(id){

      var ROW_ID = id.split('_').pop();
      $("#MAT_ROW_ID").val(ROW_ID);

      var CODE = ''; 
      var NAME = ''; 
      var MUOM = ''; 
      var GROUP = ''; 
      var CTGRY = ''; 
      var BUNIT = ''; 
      var APART = ''; 
      var CPART = ''; 
      var OPART = ''; 
      
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART);
      $("#ITEMIDpopup").show();

    }

    $("#ITEMID_closePopup").click(function(event){
      $("#ITEMIDpopup").hide();
    });

    function loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART){
        
        $("#tbody_ItemID").html('');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url:'<?php echo e(route("transaction",[$FormId,"getItemDetails2"])); ?>',
          type:'POST',
          data:{'CODE':CODE,'NAME':NAME,'MUOM':MUOM,'GROUP':GROUP,'CTGRY':CTGRY,'BUNIT':BUNIT,'APART':APART,'CPART':CPART,'OPART':OPART},
          success:function(data) {
          $("#tbody_ItemID").html(data); 
          bindItemEvents($("#MAT_ROW_ID").val()); 
          $('.js-selectall').prop('disabled', true);
          },
          error:function(data){
          console.log("Error: Something went wrong.");
          $("#tbody_ItemID").html('');                        
          },
        });
      }

      function bindItemEvents(ROW_ID){
        $('.js-selectall1').click(function(){
        var iditem = $(this).attr('id');
        var txtval =    $("#txt"+iditem+"").data("desc1");
        var texdesc =   $("#txt"+iditem+"").data("desc2");
        var texccname =   $("#txt"+iditem+"").data("desc3");

        $('#PRODUCTNAME_'+ROW_ID+'').val(texdesc);
        $('#PRODUCTID_REF_'+ROW_ID+'').val(txtval);
        $('#PRODUCT_DESC_'+ROW_ID+'').val(texccname);
        $("#ITEMIDpopup").hide();
        });
      }

/*================================== ITEM DETAILS =================================*/

let itemtid = "#ItemIDTable2";
let itemtid2 = "#ItemIDTable";
let itemtidheaders = document.querySelectorAll(itemtid2 + " th");

itemtidheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(itemtid, ".clsitemid", "td:nth-child(" + (i + 1) + ")");
  });
});


function ItemCodeFunction(e){
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("Itemcodesearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemNameFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("Itemnamesearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemUOMFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemUOMsearch");
    filter = input.value.toUpperCase();  
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemQTYFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemQTYsearch");
    filter = input.value.toUpperCase();
    table = document.getElementById("ItemIDTable2");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[4];
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
}

function ItemGroupFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemGroupsearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemCategoryFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemCategorysearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemBUFunction(e) {
  if(e.which == 13){
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("ItemBUsearch");
  filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
   
  }
}

function ItemAPNFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemAPNsearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemCPNFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemCPNsearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART);
  }
}

function ItemOEMPNFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemOEMPNsearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART);
  }
}

function ItemStatusFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemStatussearch");
    filter = input.value.toUpperCase();
    table = document.getElementById("ItemIDTable2");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[11];
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
}

      function getAlertTo(id){

        var ROW_ID = id.split('_').pop();

        $('#tbody_divpopp').html('Loading...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'<?php echo e(route("transaction",[$FormId,"getAlertTo"])); ?>',
                type:'POST',
                success:function(data) {
                    $('#tbody_divpopp').html(data);
                    bindAlertToEvents(ROW_ID);
                },
                error:function(data){
                    console.log("Error: Something went wrong.");
                    $('#tbody_divpopp').html('');
                },
            });
            $("#title_name").text('Alert To Details');    
            $("#modalpopup").show();
            event.preventDefault();
        }

          function bindAlertToEvents(ROW_ID){
            $('.clsalertto').click(function(){
            var addId_Ref = []
            var addCode = []
            $('.clsalertto:checked').each(function() {     
              addId_Ref.push($(this).val())
            });
            $('.clsalertto:checked').each(function() {       
              addCode.push($(this).data("desc1"))
            });
            $('#ALERTTO_'+ROW_ID+'').val(addCode);
            $('#ALERTTOID_REF_'+ROW_ID+'').val(addId_Ref);
            //$("#modalpopup").hide();
            });
          }

          function getAssignedTo(id){

            var ROW_ID = id.split('_').pop();

            $('#tbody_divpopp').html('Loading...');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url:'<?php echo e(route("transaction",[$FormId,"getAssignedTo"])); ?>',
                    type:'POST',
                    success:function(data) {
                        $('#tbody_divpopp').html(data);
                        bindAssignedToEvents(ROW_ID);
                    },
                    error:function(data){
                        console.log("Error: Something went wrong.");
                        $('#tbody_divpopp').html('');
                    },
                });
                $("#title_name").text('Assigned To Details');    
                $("#modalpopup").show();
                event.preventDefault();
            }

              function bindAssignedToEvents(ROW_ID){
                $('.clsassignto').click(function(){
                var idprt = $(this).attr('id');
                var txtval =    $("#txt"+idprt+"").val();
                var texdesc =   $("#txt"+idprt+"").data("desc");
                $('#ASSGNDTO_'+ROW_ID+'').val(texdesc);
                $('#ASSGNDTOID_REF_'+ROW_ID+'').val(txtval);
                $("#modalpopup").hide();
                });
              }
          
    function getProductDetails(id,txtval){
      var ROW_ID = id.split('_').pop();
      var TotalAmount = 0;
      var PRODUCT_PRICE    =   $('#PRODUCT_PRICE_'+ROW_ID+'').val();
      var PRODUCT_QTY    =   $('#PRODUCT_QTY_'+ROW_ID+'').val();
      var TotalAmount = parseFloat((parseFloat(PRODUCT_PRICE)*parseFloat(PRODUCT_QTY))).toFixed(2);
      if(PRODUCT_PRICE==''){
        $('#TOTAL_AMOUNT_'+ROW_ID).val(PRODUCT_QTY);
      }else if(PRODUCT_QTY==''){
        $('#TOTAL_AMOUNT_'+ROW_ID).val(PRODUCT_PRICE);
      }else{
      $('#TOTAL_AMOUNT_'+ROW_ID).val(TotalAmount);
      }
    }

    $(document).ready(function(e) {
    var d = new Date(); 
    var today = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;
    $('#LEAD_DT').val(today);
    });
        
    function onlyNumberKey(evt) {
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
    
    </script>
    
    <script type="text/javascript">
      function isNumberKey(txt, evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
          //Check if the text already contains the . character
          if (txt.value.indexOf('.') === -1) {
            return true;
          } else {
            return false;
          }
        } else {
          if (charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        }
        return true;
      }
    </script>
    <?php $__env->stopPush(); ?>
  
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\PROJECTS\UNICORN_DEV\resources\views/transactions/PreSales/LeadGeneration/trnfrm439view.blade.php ENDPATH**/ ?>