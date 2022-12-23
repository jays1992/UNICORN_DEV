

<?php $__env->startSection('content'); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!--<div class="row">

    <div class="col-lg-3">
        <div class="home-box box-color1"   style="cursor:pointer;" >
            <p class="cnt-title">Sales </p>
            <p class="cnt-number" id="" >50,000 </p>


        </div>
    </div>
    
    <div class="col-lg-3">
        <div class="home-box box-color2"  style="cursor:pointer;" >
            <p class="cnt-title">Purchase</p>
              <p class="cnt-number" id="">60,000</p>
        </div>
    </div>
          
    <div class="col-lg-3">
        <div class="home-box box-color3"  style="cursor:pointer;" >
            <p class="cnt-title">Inventory</p>
            <p class="cnt-number" id="">55,000</p>
                <div id=""></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="home-box box-color3"  style="cursor:pointer;" >
            <p class="cnt-title">Production</p>
            <p class="cnt-number" id="">70,000</p>
                <div id=""></div>
        </div>
    </div>
    <div class="col-lg-1">
        <div>
        </div>
    </div>
</div>-->


<div class="row">

    <?php if(!empty($objSO) && !empty($right_objDataList)): ?>
    <div class="col-lg-6" id="columnchart_sales" >
    </div>
    <?php endif; ?>

    <?php if(!empty($objPO) && !empty($right_objDataList_PO)): ?>
    <div class="col-lg-6" id="columnchart_purchase" >
    </div>
    <?php endif; ?>
    </div>


    <?php if(!empty($topsales) ||!empty($obj_TopSalesBU)): ?>
<div class="row">
<?php if(!empty($topsales)): ?>
    <div class="col-lg-6" id="columnchart_production" >
    </div>
    <?php endif; ?>
    <?php if(!empty($obj_TopSalesBU && $company_check!='hidden')): ?>
    <div class="col-lg-6" id="TOPSALES_BUWISE" >      
    </div>
    <?php endif; ?>
    </div>
    <div class="col-lg-1">
        <div>
        </div>
    </div> 
</div>
<?php endif; ?>

    <?php if(!empty($obj_TopInventoryBU) ||!empty($obj_TopPurchaseBU && $company_check!='hidden')): ?>
<div class="row">
<?php if(!empty($obj_TopPurchaseBU && $company_check!='hidden')): ?>
    <div class="col-lg-6" id="TOPPURCHASE_BUWISE" >
    </div>
    <?php endif; ?>
    <?php if(!empty($obj_TopInventoryBU && $company_check!='hidden')): ?>
    <div class="col-lg-6" id="TOPINVENTORY_BUWISE" >      
    </div>
    <?php endif; ?>
    </div>
    <div class="col-lg-1">
        <div>
        </div>
    </div> 
</div>
<?php endif; ?>


<!--<div class="row">
    <div class="col-lg-6" id="chart_div" >
    </div>
    <div class="col-lg-6" id="chart_div_purchase" >
      
    </div>
    </div>
    <div class="col-lg-1">
        <div>
        </div>
    </div>
</div>-->



<div class="row">
    <div class="col-lg-6"  style="padding-left: 100;">
    <p class="cnt-title">To Do List for Sales Module</p>
<table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm " cellspacing="0"
  width="100%">
  <thead>
    <tr>
      <th>Module Name</th>
      <th>Document No</th>
      <th>Document Date</th>
      <th>Status</th> 

    </tr>
  </thead>
  <tbody>
  <?php if(!empty($objDataList) && !empty($right_objDataList)): ?>     
        
            <?php $__currentLoopData = $objDataList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
                $module="Sales Order";
                $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>

    <td><a href='<?php echo e(route("transaction",[38,"edit","$val->SOID"])); ?>'><?php echo e(isset($val->SONO) && $val->SONO !=''?$val->SONO:''); ?></td></td>
    <td><?php echo e(isset($val->SODT) && $val->SODT !='' && $val->SODT !='1900-01-01' ? date('d-m-Y',strtotime($val->SODT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td>
  
    
    </tr>



    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>

        <?php if(!empty($objDataList_challan) && !empty($right_objDataList_challan)): ?>      
            <?php $__currentLoopData = $objDataList_challan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="Sales Challan";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
        ?>
    <tr>
    <td><?php echo e($module); ?></td>
 
    <td><a href='<?php echo e(route("transaction",[43,"edit","$val->SCID"])); ?>'><?php echo e(isset($val->SCNO) && $val->SCNO !=''?$val->SCNO:''); ?></a></td>
    <td><?php echo e(isset($val->SCDT) && $val->SCDT !='' && $val->SCDT !='1900-01-01' ? date('d-m-Y',strtotime($val->SCDT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td>

    
    </tr>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>

    <!-- SALES INVOICE SECTION  -->

  <?php if(!empty($objDataList_sales_invoice) && !empty($right_objDataList_sales_invoice)): ?>     
        
            <?php $__currentLoopData = $objDataList_sales_invoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="Sales Invoice";
            $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[44,"edit","$val->SIID"])); ?>'><?php echo e(isset($val->SINO) && $val->SINO !=''?$val->SINO:''); ?></td></td>
    <td><?php echo e(isset($val->SIDT) && $val->SIDT !='' && $val->SIDT !='1900-01-01' ? date('d-m-Y',strtotime($val->SIDT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td>
  
    
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>

    <!-- OPEN SALES ORDER SECTION  -->

  <?php if(!empty($objDataList_OSO) && !empty($right_objDataList_OSO)): ?>     
        
            <?php $__currentLoopData = $objDataList_OSO; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="Open Sales Order";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[40,"edit","$val->OSOID"])); ?>'><?php echo e(isset($val->OSONO) && $val->OSONO !=''?$val->OSONO:''); ?></td></td>
    <td><?php echo e(isset($val->OSODT) && $val->OSODT !='' && $val->OSODT !='1900-01-01' ? date('d-m-Y',strtotime($val->OSODT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td>
  
    
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>


                <!--  SALES RETRUN SECTION  -->

        <?php if(!empty($objDataList_SR) && !empty($right_objDataList_SR)): ?>     
        
        <?php $__currentLoopData = $objDataList_SR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
        $module="Sales Return";
         $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
          if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
            $app_status = 1 ;         
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
          } 
          elseif($val->STATUS=="C"){                 
            $app_status = 2 ;              
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
          }
          elseif($val->STATUS=="N"){  
            $app_status = 0 ; 
            $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

          }
        ?>
<tr>
<td><?php echo e($module); ?></td>
<td><a href='<?php echo e(route("transaction",[45,"edit","$val->SRID"])); ?>'><?php echo e(isset($val->SRNO) && $val->SRNO !=''?$val->SRNO:''); ?></td></td>
<td><?php echo e(isset($val->SRDT) && $val->SRDT !='' && $val->SRDT !='1900-01-01' ? date('d-m-Y',strtotime($val->SRDT)):''); ?></td>
<td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td>


</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>




                <!--  SALES SERVICE ORDER SECTION  -->



  <?php if(!empty($objDataList_SSO) && !empty($right_objDataList_SSO)): ?>     
        
        <?php $__currentLoopData = $objDataList_SSO; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $module="Sales Service Order";
         $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
          if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
            $app_status = 1 ;         
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
          } 
          elseif($val->STATUS=="C"){                 
            $app_status = 2 ;              
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
          }
          elseif($val->STATUS=="N"){  
            $app_status = 0 ; 
            $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;
          }
        ?>
<tr>
<td><?php echo e($module); ?></td>
<td><a href='<?php echo e(route("transaction",[151,"edit","$val->SSOID"])); ?>'><?php echo e(isset($val->SSO_NO) && $val->SSO_NO !=''?$val->SSO_NO:''); ?></td></td>
<td><?php echo e(isset($val->SSO_DT) && $val->SSO_DT !='' && $val->SSO_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->SSO_DT)):''); ?></td>

<td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td>


</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>




    <!-- SALES SERVICE INVOICE SECTION  -->



  <?php if(!empty($objDataList_SSI) && !empty($right_objDataList_SSI)): ?>     
        
        <?php $__currentLoopData = $objDataList_SSI; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $module="Sales Service Invoice";
         $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
          if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
            $app_status = 1 ;         
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
          } 
          elseif($val->STATUS=="C"){                 
            $app_status = 2 ;              
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
          }
          elseif($val->STATUS=="N"){  
            $app_status = 0 ; 
            $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

          }
        ?>
<tr>
<td><?php echo e($module); ?></td>
<td><a href='<?php echo e(route("transaction",[156,"edit","$val->SSIID"])); ?>'><?php echo e(isset($val->SSI_NO) && $val->SSI_NO !=''?$val->SSI_NO:''); ?></td></td>
<td><?php echo e(isset($val->SSI_DT) && $val->SSI_DT !='' && $val->SSI_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->SSI_DT)):''); ?></td>

<td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td>


</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>            
  </tbody>
</table>

    </div>
    <div class="col-lg-6" style="padding-right: 100;" >
    <p class="cnt-title">To Do List for Purchase Module</p>
<table id="dtHorizontalVerticalExample1" class="table table-striped table-bordered table-sm " cellspacing="0"
  width="100%">
  <thead>
    <tr>
      <th>Module Name</th>
      <th>Document No</th>
      <th>Document Date</th>
      <th>Status</th>
  

    </tr>
  </thead>
  <tbody>
  <?php if(!empty($objDataList_PO) && !empty($right_objDataList_PO)): ?>     
        
            <?php $__currentLoopData = $objDataList_PO; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
            $module="Purchase Order";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[63,"edit","$val->POID"])); ?>'><?php echo e(isset($val->PO_NO) && $val->PO_NO !=''?$val->PO_NO:''); ?></td></td>
    <td><?php echo e(isset($val->PO_DT) && $val->PO_DT !='' && $val->PO_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->PO_DT)):''); ?></td>
    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
    </tr>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>

    <!-- BPO SECTION  -->

  <?php if(!empty($objDataList_BPO) && !empty($right_objDataList_BPO)): ?>     
        
            <?php $__currentLoopData = $objDataList_BPO; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="Blanket Purchase Order";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[67,"edit","$val->BPOID"])); ?>'><?php echo e(isset($val->BPO_NO) && $val->BPO_NO !=''?$val->BPO_NO:''); ?></td></td>
    <td><?php echo e(isset($val->BPO_DT) && $val->BPO_DT !='' && $val->BPO_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->BPO_DT)):''); ?></td>
    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
    </tr>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>

    <!-- SPO SECTION  -->

    <?php if(!empty($objDataList_SPO) && !empty($right_objDataList_SPO)): ?>        
        <?php $__currentLoopData = $objDataList_SPO; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $module="Service Purchase Order";
         $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
          if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
            $app_status = 1 ;         
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
          } 
          elseif($val->STATUS=="C"){                 
            $app_status = 2 ;              
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
          }
          elseif($val->STATUS=="N"){  
            $app_status = 0 ; 
            $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

          }
        ?>
<tr>
<td><?php echo e($module); ?></td>
<td><a href='<?php echo e(route("transaction",[69,"edit","$val->SPOID"])); ?>'><?php echo e(isset($val->SPO_NO) && $val->SPO_NO !=''?$val->SPO_NO:''); ?></td></td>
<td><?php echo e(isset($val->SPO_DT) && $val->SPO_DT !='' && $val->SPO_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->SPO_DT)):''); ?></td>
<td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>



    <!-- PI SECTION  -->

    <?php if(!empty($objDataList_PI) && !empty($right_objDataList_PI)): ?>     
        
        <?php $__currentLoopData = $objDataList_PI; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
        $module="Purchase Indent";
         $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
          if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
            $app_status = 1 ;         
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
          } 
          elseif($val->STATUS=="C"){                 
            $app_status = 2 ;              
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
          }
          elseif($val->STATUS=="N"){  
            $app_status = 0 ; 
            $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

          }
        ?>
<tr>
<td><?php echo e($module); ?></td>
<td><a href='<?php echo e(route("transaction",[59,"edit","$val->PIID"])); ?>'><?php echo e(isset($val->PI_NO) && $val->PI_NO !=''?$val->PI_NO:''); ?></td></td>
<td><?php echo e(isset($val->PI_DT) && $val->PI_DT !='' && $val->PI_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->PI_DT)):''); ?></td>
<td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>


    <!-- SPI SECTION  -->

    <?php if(!empty($objDataList_SPI) && !empty($right_objDataList_SPI)): ?>     
        
        <?php $__currentLoopData = $objDataList_SPI; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
        $module="Service Purchase Invoice";
         $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
          if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
            $app_status = 1 ;         
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
          } 
          elseif($val->STATUS=="C"){                 
            $app_status = 2 ;              
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
          }
          elseif($val->STATUS=="N"){  
            $app_status = 0 ; 
            $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

          }
        ?>
<tr>
<td><?php echo e($module); ?></td>
<td><a href='<?php echo e(route("transaction",[201,"edit","$val->SPIID"])); ?>'><?php echo e(isset($val->SPI_NO) && $val->SPI_NO !=''?$val->SPI_NO:''); ?></td></td>
<td><?php echo e(isset($val->SPI_DT) && $val->SPI_DT !='' && $val->SPI_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->SPI_DT)):''); ?></td>
<td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>


    <!-- PR SECTION  -->

    <?php if(!empty($objDataList_PR) && !empty($right_objDataList_PR)): ?>     
        
        <?php $__currentLoopData = $objDataList_PR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
        $module="Purchase Return";
         $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
          if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
            $app_status = 1 ;         
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
          } 
          elseif($val->STATUS=="C"){                 
            $app_status = 2 ;              
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
          }
          elseif($val->STATUS=="N"){  
            $app_status = 0 ; 
            $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

          }
        ?>
<tr>
<td><?php echo e($module); ?></td>
<td><a href='<?php echo e(route("transaction",[310,"edit","$val->PRRID"])); ?>'><?php echo e(isset($val->PRR_NO) && $val->PRR_NO !=''?$val->PRR_NO:''); ?></td></td>
<td><?php echo e(isset($val->PRR_DT) && $val->PRR_DT !='' && $val->PRR_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->PRR_DT)):''); ?></td>
<td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>

    <!-- IPO SECTION  -->

    <?php if(!empty($objDataList_IPO) && !empty($right_objDataList_IPO)): ?>     
        
        <?php $__currentLoopData = $objDataList_IPO; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
        $module="Import Purchase Order";
         $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
          if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
            $app_status = 1 ;         
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
          } 
          elseif($val->STATUS=="C"){                 
            $app_status = 2 ;              
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
          }
          elseif($val->STATUS=="N"){  
            $app_status = 0 ; 
            $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

          }
        ?>
<tr>
<td><?php echo e($module); ?></td>
<td><a href='<?php echo e(route("transaction",[299,"edit","$val->IPO_ID"])); ?>'><?php echo e(isset($val->IPO_NO) && $val->IPO_NO !=''?$val->IPO_NO:''); ?></td></td>
<td><?php echo e(isset($val->IPO_DT) && $val->IPO_DT !='' && $val->IPO_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->IPO_DT)):''); ?></td>
<td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>

    <!-- PII SECTION  -->

    <?php if(!empty($objDataList_PII) && !empty($right_objDataList_PII)): ?>     
        
        <?php $__currentLoopData = $objDataList_PII; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
        $module="Purchase Invoice Import";
         $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
          if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
            $app_status = 1 ;         
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
          } 
          elseif($val->STATUS=="C"){                 
            $app_status = 2 ;              
            $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
          }
          elseif($val->STATUS=="N"){  
            $app_status = 0 ; 
            $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

          }
        ?>
<tr>
<td><?php echo e($module); ?></td>
<td><a href='<?php echo e(route("transaction",[300,"edit","$val->PII_ID"])); ?>'><?php echo e(isset($val->PII_NO) && $val->PII_NO !=''?$val->PII_NO:''); ?></td></td>
<td><?php echo e(isset($val->PII_DT) && $val->PII_DT !='' && $val->PII_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->PII_DT)):''); ?></td>
<td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>



            
  </tbody>
</table>

    </div>


    </div>

<!-- ==============================================================INVENTORY AND FINANCE MODULE STARTS HERE======================================================= -->




<div class="row" style="margin-top:160px">
    <div class="col-lg-6"  style="padding-left: 100;">
    <p class="cnt-title">To Do List for Inventory Module</p>
<table id="dtHorizontalVerticalExample2" class="table table-striped table-bordered table-sm " cellspacing="0"
  width="100%">
  <thead>
    <tr>
      <th>Module Name</th>
      <th>Document No</th>
      <th>Document Date</th>
      <th>Status</th>
  

    </tr>
  </thead>
  <tbody>
  <?php if(!empty($objDataList_MRS) && !empty($right_objDataList_MRS)): ?>   
            <?php $__currentLoopData = $objDataList_MRS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="MRS";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[88,"edit","$val->MRSID"])); ?>'><?php echo e(isset($val->MRS_NO) && $val->MRS_NO !=''?$val->MRS_NO:''); ?></td></td>
    <td><?php echo e(isset($val->MRS_DT) && $val->MRS_DT !='' && $val->MRS_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->MRS_DT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td>
  
    
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>
    <!-- ==========GE====================== -->
  <?php if(!empty($objDataList_GE) && !empty($right_objDataList_GE)): ?>   
            <?php $__currentLoopData = $objDataList_GE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="Gate Entry";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[92,"edit","$val->GEID"])); ?>'><?php echo e(isset($val->GE_NO) && $val->GE_NO !=''?$val->GE_NO:''); ?></td></td>
    <td><?php echo e(isset($val->GE_DT) && $val->GE_DT !='' && $val->GE_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->GE_DT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td>
  
    
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>





    <!-- ==========GRN AGAINST GE====================== -->
  <?php if(!empty($objDataList_GRN) && !empty($right_objDataList_GRN)): ?>   
            <?php $__currentLoopData = $objDataList_GRN; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="GRN Against GE";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[159,"edit","$val->GRNID"])); ?>'><?php echo e(isset($val->GRN_NO) && $val->GRN_NO !=''?$val->GRN_NO:''); ?></td></td>
    <td><?php echo e(isset($val->GRN_DT) && $val->GRN_DT !='' && $val->GRN_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->GRN_DT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>      
    
    


            
  </tbody>









</table>

    </div>
    <div class="col-lg-6" style="padding-right: 100;" >
    <p class="cnt-title">To Do List for Finance Module</p>
<table id="dtHorizontalVerticalExample3" class="table table-striped table-bordered table-sm " cellspacing="0"
  width="100%">
  <thead>
    <tr>
      <th>Module Name</th>
      <th>Document No</th>
      <th>Document Date</th>
      <th>Status</th>
  

    </tr>
  </thead>
  <tbody>

    <!-- ==========JV====================== -->
    <?php if(!empty($objDataList_JV) && !empty($right_objDataList_JV)): ?>   
            <?php $__currentLoopData = $objDataList_JV; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="Journal Voucher";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[169,"edit","$val->JVID"])); ?>'><?php echo e(isset($val->JV_NO) && $val->JV_NO !=''?$val->JV_NO:''); ?></td></td>
    <td><?php echo e(isset($val->JV_DT) && $val->JV_DT !='' && $val->JV_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->JV_DT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>    


    <!-- ==========AR DEBIT AND CREDIT NOTE====================== -->
  <?php if(!empty($objDataList_AR) && !empty($right_objDataList_AR)): ?>   
            <?php $__currentLoopData = $objDataList_AR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="AR Debit Credit Note";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[233,"edit","$val->ARDRCRID"])); ?>'><?php echo e(isset($val->AR_DOC_NO) && $val->AR_DOC_NO !=''?$val->AR_DOC_NO:''); ?></td></td>
    <td><?php echo e(isset($val->AR_DOC_DT) && $val->AR_DOC_DT !='' && $val->AR_DOC_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->AR_DOC_DT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>    
    <!-- ==========AP DEBIT AND CREDIT NOTE====================== -->
  <?php if(!empty($objDataList_AP) && !empty($right_objDataList_AP)): ?>   
            <?php $__currentLoopData = $objDataList_AP; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="AP Debit Credit Note";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[235,"edit","$val->APDRCRID"])); ?>'><?php echo e(isset($val->AP_DOC_NO) && $val->AP_DOC_NO !=''?$val->AP_DOC_NO:''); ?></td></td>
    <td><?php echo e(isset($val->AP_DOC_DT) && $val->AP_DOC_DT !='' && $val->AP_DOC_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->AP_DOC_DT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>    


    <!-- ==========PAYMENT ENTRY====================== -->
  <?php if(!empty($objDataList_PAYMENT) && !empty($right_objDataList_PAYMENT)): ?>   
            <?php $__currentLoopData = $objDataList_PAYMENT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="Payment Entry";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[301,"edit","$val->PAYMENTID"])); ?>'><?php echo e(isset($val->PAYMENT_NO) && $val->PAYMENT_NO !=''?$val->PAYMENT_NO:''); ?></td></td>
    <td><?php echo e(isset($val->PAYMENT_DT) && $val->PAYMENT_DT !='' && $val->PAYMENT_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->PAYMENT_DT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>    


    <!-- ==========RECEIPT ENTRY====================== -->
  <?php if(!empty($objDataList_RECEIPT) && !empty($right_objDataList_RECEIPT) ): ?>   
            <?php $__currentLoopData = $objDataList_RECEIPT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $module="Receipt Entry";
             $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
              if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                $app_status = 1 ;         
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
              } 
              elseif($val->STATUS=="C"){                 
                $app_status = 2 ;              
                $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
              }
              elseif($val->STATUS=="N"){  
                $app_status = 0 ; 
                $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

              }
            ?>
    <tr>
    <td><?php echo e($module); ?></td>
    <td><a href='<?php echo e(route("transaction",[302,"edit","$val->RECEIPTID"])); ?>'><?php echo e(isset($val->RECEIPT_NO) && $val->RECEIPT_NO !=''?$val->RECEIPT_NO:''); ?></td></td>
    <td><?php echo e(isset($val->RECEIPT_DT) && $val->RECEIPT_DT !='' && $val->RECEIPT_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->RECEIPT_DT)):''); ?></td>

    <td><?php echo e(isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''); ?></td> 
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    <?php endif; ?>    



            
  </tbody>
</table>

    </div>


    </div>


    <div class="col-lg-1">
        <div>
        </div>
    </div>
</div>

<!-- ==============================================================TODAY'S CALL======================================================= -->

        <div class="row">
          <div class="col-lg-6"  style="padding-left: 100; margin-top: 56px;">
          <p class="cnt-title">To Do List for Pre Sales Module</p>
            <table id="dtHorizontalVerticalExample4" class="table table-striped table-bordered table-sm " cellspacing="0"
            width="100%">
            <thead>
              <tr>
                <th>Module Name</th>
                <th>Lead No</th>
                <th>Lead Date</th>
                <th>Company Name</th>
                <th>Lead Details</th>
                <th>Contact Person</th>
                <th>Landline No</th>
                <th>Mobile No</th>
                <th>E-Mail Id</th>
                <th>Due Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>

          <?php if(!empty($objDataList_TDCALL) && !empty($right_objDataList_TDCALL)): ?>   
              <?php $__currentLoopData = $objDataList_TDCALL; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
              $module="Today's Call";
              $DataStatus= isset($val->STATUS_DESC) && $val->STATUS_DESC!='' ? $val->STATUS_DESC : '';
                if(!Empty($val->STATUS) && $val->STATUS=="A"){ 
                  $app_status = 1 ;         
                  $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'approved')==false ? 'Final Approved' : $val->STATUS_DESC;
                } 
                elseif($val->STATUS=="C"){                 
                  $app_status = 2 ;              
                  $DataStatus =  Str::contains(strtolower($val->STATUS_DESC), 'cancelled')==false ? 'Cancelled' : $val->STATUS_DESC;
                }
                elseif($val->STATUS=="N"){  
                  $app_status = 0 ; 
                  $DataStatus = Str::contains(strtolower($val->STATUS_DESC), 'added')==false && Str::contains(strtolower($val->STATUS_DESC), 'edited')==false ? 'Added' : $val->STATUS_DESC;

                }

                $encodeid = $val->LEAD_ID;
                $LEAD_ID  = base64_encode($encodeid);
                $tbldate  = date('d-m-Y',strtotime($val->TASK_REMINDER_DATE));
                $nowdate  = date('d-m-Y');
                
              ?>
              <?php
              if($tbldate == $nowdate){?>
                <tr>
                  <td><?php echo e($module); ?></td>
                  <td><a href='<?php echo e(route("transaction",[439,"view","$LEAD_ID"])); ?>'><?php echo e(isset($val->LEAD_NO)?$val->LEAD_NO:''); ?></td></td>
                  <td><?php echo e(isset($val->TASK_REMINDER_DATE) && $val->TASK_REMINDER_DATE !=''? date('d-m-Y',strtotime($val->TASK_REMINDER_DATE)):''); ?></td>
                  <td><?php echo e(isset($val->COMPANY_NAME)?$val->COMPANY_NAME:''); ?></td>
                  <td><?php echo e(isset($val->LEAD_DETAILS)?$val->LEAD_DETAILS:''); ?></td>
                  <td><?php echo e(isset($val->CONTACT_PERSON)?$val->CONTACT_PERSON:''); ?></td>
                  <td><?php echo e(isset($val->LANDLINE_NUMBER)?$val->LANDLINE_NUMBER:''); ?></td>
                  <td><?php echo e(isset($val->MOBILE_NUMBER)?$val->MOBILE_NUMBER:''); ?></td>
                  <td><?php echo e(isset($val->EMAIL)?$val->EMAIL:''); ?></td>
                  <td><?php echo e(isset($val->DUE_DATE)?$val->DUE_DATE:''); ?></td>
                  <td><?php echo e(isset($val->STATUS_DESC)?$val->STATUS_DESC:''); ?></td>
              </tr>
              <?php }else{} ?>

              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            <?php endif; ?>
          </tbody>
        </table>
        </div>
        </div>


<!--===============================START COLUMN CHART FOR SALES======================================-->


  <script type="text/javascript">
  
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([

        ["Jan", "Sales", { role: "style" } ],
        ["Apr", <?php echo e($apr); ?>, "#DFFF00"],
        ["May", <?php echo e($may); ?>, "#FFBF00"],
        ["June", <?php echo e($june); ?>, "#FF7F50"],
        ["July",<?php echo e($july); ?>, "#DE3163"],
        ["Aug", <?php echo e($aug); ?>, "#9FE2BF"],
        ["Sep", <?php echo e($sep); ?>, "color: #40E0D0"],
        ["Oct", <?php echo e($oct); ?>, "color: #6495ED"],
        ["Nov", <?php echo e($nov); ?>, "color: #CCCCFF"],
        ["Dec", <?php echo e($dec); ?>, "color: #FFC0CB"],
        ["Jan", <?php echo e($jan); ?>, "color: #00FF00"],
        ["Feb",<?php echo e($feb); ?>, "color: #0000FF"],
        ["Mar", <?php echo e($mar); ?>, "color: #800080"]       

      ]);


      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Month wise Sales Analysis for the year <?php echo e($year); ?> ",
        width: 1000,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_sales"));
      chart.draw(view, options);
  }
  </script>

  <!--===============================END COLUMN CHART FOR SALES======================================-->


  <!--===============================START COLUMN CHART FOR PURCHASE======================================-->

  <script type="text/javascript">
  
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart_purchase);
    function drawChart_purchase() {
      var data = google.visualization.arrayToDataTable([
        ["Jan", "Purchase", { role: "style" } ],
        ["Apr", <?php echo e($apr_purchase); ?>, "#DFFF00"],
        ["May", <?php echo e($may_purchase); ?>, "#FFBF00"],
        ["June", <?php echo e($june_purchase); ?>, "#FF7F50"],
        ["July",<?php echo e($july_purchase); ?>, "#DE3163"],
        ["Aug", <?php echo e($aug_purchase); ?>, "#9FE2BF"],
        ["Sep", <?php echo e($sep_purchase); ?>, "color: #40E0D0"],
        ["Oct", <?php echo e($oct_purchase); ?>, "color: #6495ED"],
        ["Nov", <?php echo e($nov_purchase); ?>, "color: #CCCCFF"],
        ["Dec", <?php echo e($dec_purchase); ?>, "color: #FFC0CB"],
        ["Jan", <?php echo e($jan_purchase); ?>, "color: #00FF00"],
        ["Feb",<?php echo e($feb_purchase); ?>, "color: #0000FF"],
        ["Mar", <?php echo e($mar_purchase); ?>, "color: #800080"]     
      ]);


      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Month wise Procurement  Analysis for the year <?php echo e($year); ?> ",
        width: 1000,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_purchase"));
      chart.draw(view, options);
  }
  </script>

  <!--===============================END COLUMN CHART FOR PURCHASE======================================-->

<?php if(isset($company_check) && $company_check!='hidden'): ?>
  
  <!--===============================START COLUMN CHART FOR SALES BU WISE======================================-->

  <script type="text/javascript">
  
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart_production);

    function drawChart_production() {
      
      var data =    google.visualization.arrayToDataTable([
         ["Qty", "Qty", { role: "style" } ],
   
        ["<?php echo e(isset($obj_TopSalesBU[0]->BUNAME) && $obj_TopSalesBU[0]->BUNAME!='' ? $obj_TopSalesBU[0]->BUNAME:''); ?>", <?php echo e(isset($obj_TopSalesBU[0]->Total_Sales) && $obj_TopSalesBU[0]->Total_Sales!='' ? $obj_TopSalesBU[0]->Total_Sales:''); ?>, "#DFFF00"],
        ["<?php echo e(isset($obj_TopSalesBU[1]->BUNAME) && $obj_TopSalesBU[1]->BUNAME!='' ? $obj_TopSalesBU[1]->BUNAME:''); ?>", <?php echo e(isset($obj_TopSalesBU[1]->Total_Sales) && $obj_TopSalesBU[1]->Total_Sales!='' ? $obj_TopSalesBU[1]->Total_Sales:''); ?>, "#FFBF00"], 
        ["<?php echo e(isset($obj_TopSalesBU[2]->BUNAME) && $obj_TopSalesBU[2]->BUNAME!='' ? $obj_TopSalesBU[2]->BUNAME:''); ?>", <?php echo e(isset($obj_TopSalesBU[2]->Total_Sales) && $obj_TopSalesBU[2]->Total_Sales!='' ? $obj_TopSalesBU[2]->Total_Sales:''); ?>, "#FF7F50"],   
        ["<?php echo e(isset($obj_TopSalesBU[3]->BUNAME) && $obj_TopSalesBU[3]->BUNAME!='' ? $obj_TopSalesBU[3]->BUNAME:''); ?>", <?php echo e(isset($obj_TopSalesBU[3]->Total_Sales) && $obj_TopSalesBU[3]->Total_Sales!='' ? $obj_TopSalesBU[3]->Total_Sales:''); ?>, "#DE3163"],  
        ["<?php echo e(isset($obj_TopSalesBU[4]->BUNAME) && $obj_TopSalesBU[4]->BUNAME!='' ? $obj_TopSalesBU[4]->BUNAME:''); ?>", <?php echo e(isset($obj_TopSalesBU[4]->Total_Sales) && $obj_TopSalesBU[4]->Total_Sales!='' ? $obj_TopSalesBU[4]->Total_Sales:''); ?>, "#9FE2BF"],
        <?php if(isset($obj_TopSalesBU[5]->BUNAME) && $obj_TopSalesBU[5]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopSalesBU[5]->BUNAME) && $obj_TopSalesBU[5]->BUNAME!='' ? $obj_TopSalesBU[5]->BUNAME:''); ?>", <?php echo e(isset($obj_TopSalesBU[5]->Total_Sales) && $obj_TopSalesBU[5]->Total_Sales!='' ? $obj_TopSalesBU[5]->Total_Sales:''); ?>, "#40E0D0"],
        <?php }else if(isset($obj_TopSalesBU[6]->BUNAME) && $obj_TopSalesBU[6]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopSalesBU[6]->BUNAME) && $obj_TopSalesBU[6]->BUNAME!='' ? $obj_TopSalesBU[6]->BUNAME:''); ?>", <?php echo e(isset($obj_TopSalesBU[6]->Total_Sales) && $obj_TopSalesBU[6]->Total_Sales!='' ? $obj_TopSalesBU[6]->Total_Sales:''); ?>, "#6495ED"],
        <?php }else if(isset($obj_TopSalesBU[7]->BUNAME) && $obj_TopSalesBU[7]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopSalesBU[7]->BUNAME) && $obj_TopSalesBU[7]->BUNAME!='' ? $obj_TopSalesBU[7]->BUNAME:''); ?>", <?php echo e(isset($obj_TopSalesBU[7]->Total_Sales) && $obj_TopSalesBU[7]->Total_Sales!='' ? $obj_TopSalesBU[7]->Total_Sales:''); ?>, "#CCCCFF"],
        <?php }else if(isset($obj_TopSalesBU[8]->BUNAME) && $obj_TopSalesBU[8]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopSalesBU[8]->BUNAME) && $obj_TopSalesBU[8]->BUNAME!='' ? $obj_TopSalesBU[8]->BUNAME:''); ?>", <?php echo e(isset($obj_TopSalesBU[8]->Total_Sales) && $obj_TopSalesBU[8]->Total_Sales!='' ? $obj_TopSalesBU[8]->Total_Sales:''); ?>, "#FFC0CB"],
        <?php }else if(isset($obj_TopSalesBU[9]->BUNAME) && $obj_TopSalesBU[9]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopSalesBU[9]->BUNAME) && $obj_TopSalesBU[9]->BUNAME!='' ? $obj_TopSalesBU[9]->BUNAME:''); ?>", <?php echo e(isset($obj_TopSalesBU[9]->Total_Sales) && $obj_TopSalesBU[9]->Total_Sales!='' ? $obj_TopSalesBU[9]->Total_Sales:''); ?>, "#00FF00"],
     
        <?php }?>
      ]);



      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Top 10 Selling items Business Unit Wise Year <?php echo e($year); ?> ",
        width: 1000,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("TOPSALES_BUWISE"));
      chart.draw(view, options);
  }
  </script>

  <!--===============================END COLUMN CHART FOR SALES BU WISE======================================-->
  
  <!--===============================START COLUMN CHART FOR PURCHASE BU WISE======================================-->

  <script type="text/javascript">
  
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart_production);

    function drawChart_production() {
      
      var data =    google.visualization.arrayToDataTable([
         ["Qty", "Qty", { role: "style" } ],
   
        ["<?php echo e(isset($obj_TopPurchaseBU[0]->BUNAME) && $obj_TopPurchaseBU[0]->BUNAME!='' ? $obj_TopPurchaseBU[0]->BUNAME:''); ?>", <?php echo e(isset($obj_TopPurchaseBU[0]->QTYS) && $obj_TopPurchaseBU[0]->QTYS!='' ? $obj_TopPurchaseBU[0]->QTYS:''); ?>, "#DFFF00"],
        ["<?php echo e(isset($obj_TopPurchaseBU[1]->BUNAME) && $obj_TopPurchaseBU[1]->BUNAME!='' ? $obj_TopPurchaseBU[1]->BUNAME:''); ?>", <?php echo e(isset($obj_TopPurchaseBU[1]->QTYS) && $obj_TopPurchaseBU[1]->QTYS!='' ? $obj_TopPurchaseBU[1]->QTYS:''); ?>, "#FFBF00"], 
        ["<?php echo e(isset($obj_TopPurchaseBU[2]->BUNAME) && $obj_TopPurchaseBU[2]->BUNAME!='' ? $obj_TopPurchaseBU[2]->BUNAME:''); ?>", <?php echo e(isset($obj_TopPurchaseBU[2]->QTYS) && $obj_TopPurchaseBU[2]->QTYS!='' ? $obj_TopPurchaseBU[2]->QTYS:''); ?>, "#FF7F50"],   
        ["<?php echo e(isset($obj_TopPurchaseBU[3]->BUNAME) && $obj_TopPurchaseBU[3]->BUNAME!='' ? $obj_TopPurchaseBU[3]->BUNAME:''); ?>", <?php echo e(isset($obj_TopPurchaseBU[3]->QTYS) && $obj_TopPurchaseBU[3]->QTYS!='' ? $obj_TopPurchaseBU[3]->QTYS:''); ?>, "#DE3163"],  
        ["<?php echo e(isset($obj_TopPurchaseBU[4]->BUNAME) && $obj_TopPurchaseBU[4]->BUNAME!='' ? $obj_TopPurchaseBU[4]->BUNAME:''); ?>", <?php echo e(isset($obj_TopPurchaseBU[4]->QTYS) && $obj_TopPurchaseBU[4]->QTYS!='' ? $obj_TopPurchaseBU[4]->QTYS:''); ?>, "#9FE2BF"],
        <?php if(isset($obj_TopPurchaseBU[5]->BUNAME) && $obj_TopPurchaseBU[5]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopPurchaseBU[5]->BUNAME) && $obj_TopPurchaseBU[5]->BUNAME!='' ? $obj_TopPurchaseBU[5]->BUNAME:''); ?>", <?php echo e(isset($obj_TopPurchaseBU[5]->QTYS) && $obj_TopPurchaseBU[5]->QTYS!='' ? $obj_TopPurchaseBU[5]->QTYS:''); ?>, "#40E0D0"],
        <?php }else if(isset($obj_TopPurchaseBU[6]->BUNAME) && $obj_TopPurchaseBU[6]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopPurchaseBU[6]->BUNAME) && $obj_TopPurchaseBU[6]->BUNAME!='' ? $obj_TopPurchaseBU[6]->BUNAME:''); ?>", <?php echo e(isset($obj_TopPurchaseBU[6]->QTYS) && $obj_TopPurchaseBU[6]->QTYS!='' ? $obj_TopPurchaseBU[6]->QTYS:''); ?>, "#6495ED"],
        <?php }else if(isset($obj_TopPurchaseBU[7]->BUNAME) && $obj_TopPurchaseBU[7]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopPurchaseBU[7]->BUNAME) && $obj_TopPurchaseBU[7]->BUNAME!='' ? $obj_TopPurchaseBU[7]->BUNAME:''); ?>", <?php echo e(isset($obj_TopPurchaseBU[7]->QTYS) && $obj_TopPurchaseBU[7]->QTYS!='' ? $obj_TopPurchaseBU[7]->QTYS:''); ?>, "#CCCCFF"],
        <?php }else if(isset($obj_TopPurchaseBU[8]->BUNAME) && $obj_TopPurchaseBU[8]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopPurchaseBU[8]->BUNAME) && $obj_TopPurchaseBU[8]->BUNAME!='' ? $obj_TopPurchaseBU[8]->BUNAME:''); ?>", <?php echo e(isset($obj_TopPurchaseBU[8]->QTYS) && $obj_TopPurchaseBU[8]->QTYS!='' ? $obj_TopPurchaseBU[8]->QTYS:''); ?>, "#FFC0CB"],
        <?php }else if(isset($obj_TopPurchaseBU[9]->BUNAME) && $obj_TopPurchaseBU[9]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopPurchaseBU[9]->BUNAME) && $obj_TopPurchaseBU[9]->BUNAME!='' ? $obj_TopPurchaseBU[9]->BUNAME:''); ?>", <?php echo e(isset($obj_TopPurchaseBU[9]->QTYS) && $obj_TopPurchaseBU[9]->QTYS!='' ? $obj_TopPurchaseBU[9]->QTYS:''); ?>, "#00FF00"],
     
        <?php }?>
      ]);



      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Top 10 Procurement items Business Unit Wise Year <?php echo e($year); ?> ",
        width: 1000,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("TOPPURCHASE_BUWISE"));
      chart.draw(view, options);
  }
  </script>

  <!--===============================END COLUMN CHART FOR PURCHASE BU WISE======================================-->


  <!--===============================START COLUMN CHART FOR INVENTORY BU WISE======================================-->

  <script type="text/javascript">
  
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart_production);

    function drawChart_production() {
      
      var data =    google.visualization.arrayToDataTable([
         ["Qty", "Qty", { role: "style" } ],
   
        ["<?php echo e(isset($obj_TopInventoryBU[0]->BUNAME) && $obj_TopInventoryBU[0]->BUNAME!='' ? $obj_TopInventoryBU[0]->BUNAME:''); ?>", <?php echo e(isset($obj_TopInventoryBU[0]->QTYS) && $obj_TopInventoryBU[0]->QTYS!='' ? $obj_TopInventoryBU[0]->QTYS:''); ?>, "#DFFF00"],
        ["<?php echo e(isset($obj_TopInventoryBU[1]->BUNAME) && $obj_TopInventoryBU[1]->BUNAME!='' ? $obj_TopInventoryBU[1]->BUNAME:''); ?>", <?php echo e(isset($obj_TopInventoryBU[1]->QTYS) && $obj_TopInventoryBU[1]->QTYS!='' ? $obj_TopInventoryBU[1]->QTYS:''); ?>, "#FFBF00"], 
        ["<?php echo e(isset($obj_TopInventoryBU[2]->BUNAME) && $obj_TopInventoryBU[2]->BUNAME!='' ? $obj_TopInventoryBU[2]->BUNAME:''); ?>", <?php echo e(isset($obj_TopInventoryBU[2]->QTYS) && $obj_TopInventoryBU[2]->QTYS!='' ? $obj_TopInventoryBU[2]->QTYS:''); ?>, "#FF7F50"],   
        ["<?php echo e(isset($obj_TopInventoryBU[3]->BUNAME) && $obj_TopInventoryBU[3]->BUNAME!='' ? $obj_TopInventoryBU[3]->BUNAME:''); ?>", <?php echo e(isset($obj_TopInventoryBU[3]->QTYS) && $obj_TopInventoryBU[3]->QTYS!='' ? $obj_TopInventoryBU[3]->QTYS:''); ?>, "#DE3163"],  
        ["<?php echo e(isset($obj_TopInventoryBU[4]->BUNAME) && $obj_TopInventoryBU[4]->BUNAME!='' ? $obj_TopInventoryBU[4]->BUNAME:''); ?>", <?php echo e(isset($obj_TopInventoryBU[4]->QTYS) && $obj_TopInventoryBU[4]->QTYS!='' ? $obj_TopInventoryBU[4]->QTYS:''); ?>, "#9FE2BF"],
        <?php if(isset($obj_TopInventoryBU[5]->BUNAME) && $obj_TopInventoryBU[5]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopInventoryBU[5]->BUNAME) && $obj_TopInventoryBU[5]->BUNAME!='' ? $obj_TopInventoryBU[5]->BUNAME:''); ?>", <?php echo e(isset($obj_TopInventoryBU[5]->QTYS) && $obj_TopInventoryBU[5]->QTYS!='' ? $obj_TopInventoryBU[5]->QTYS:''); ?>, "#40E0D0"],
        <?php }else if(isset($obj_TopInventoryBU[6]->BUNAME) && $obj_TopInventoryBU[6]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopInventoryBU[6]->BUNAME) && $obj_TopInventoryBU[6]->BUNAME!='' ? $obj_TopInventoryBU[6]->BUNAME:''); ?>", <?php echo e(isset($obj_TopInventoryBU[6]->QTYS) && $obj_TopInventoryBU[6]->QTYS!='' ? $obj_TopInventoryBU[6]->QTYS:''); ?>, "#6495ED"],
        <?php }else if(isset($obj_TopInventoryBU[7]->BUNAME) && $obj_TopInventoryBU[7]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopInventoryBU[7]->BUNAME) && $obj_TopInventoryBU[7]->BUNAME!='' ? $obj_TopInventoryBU[7]->BUNAME:''); ?>", <?php echo e(isset($obj_TopInventoryBU[7]->QTYS) && $obj_TopInventoryBU[7]->QTYS!='' ? $obj_TopInventoryBU[7]->QTYS:''); ?>, "#CCCCFF"],
        <?php }else if(isset($obj_TopInventoryBU[8]->BUNAME) && $obj_TopInventoryBU[8]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopInventoryBU[8]->BUNAME) && $obj_TopInventoryBU[8]->BUNAME!='' ? $obj_TopInventoryBU[8]->BUNAME:''); ?>", <?php echo e(isset($obj_TopInventoryBU[8]->QTYS) && $obj_TopInventoryBU[8]->QTYS!='' ? $obj_TopInventoryBU[8]->QTYS:''); ?>, "#FFC0CB"],
        <?php }else if(isset($obj_TopInventoryBU[9]->BUNAME) && $obj_TopInventoryBU[9]->BUNAME!='') {?>
        ["<?php echo e(isset($obj_TopInventoryBU[9]->BUNAME) && $obj_TopInventoryBU[9]->BUNAME!='' ? $obj_TopInventoryBU[9]->BUNAME:''); ?>", <?php echo e(isset($obj_TopInventoryBU[9]->QTYS) && $obj_TopInventoryBU[9]->QTYS!='' ? $obj_TopInventoryBU[9]->QTYS:''); ?>, "#00FF00"],
     
        <?php }?>
      ]);



      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Top 10 Inventory items Business Unit Wise Year <?php echo e($year); ?> ",
        width: 1000,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("TOPINVENTORY_BUWISE"));
      chart.draw(view, options);
  }
  </script>
<?php endif; ?>
  <!--===============================END COLUMN CHART FOR PURCHASE BU WISE======================================-->

  <!--===============================START COLUMN CHART FOR SALES======================================-->


  <script type="text/javascript">
  
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart_production);

    function drawChart_production() {
      
      var data =    google.visualization.arrayToDataTable([
         ["Qty", "Qty", { role: "style" } ],
        ["<?php echo e($item1); ?>", <?php echo e($item1amt); ?>, "#DFFF00"],
        ["<?php echo e($item2); ?>", <?php echo e($item2amt); ?>, "#FFBF00"],
        ["<?php echo e($item3); ?>", <?php echo e($item3amt); ?>, "#FF7F50"],
        ["<?php echo e($item4); ?>", <?php echo e($item4amt); ?>, "#DE3163"],
        ["<?php echo e($item5); ?>", <?php echo e($item5amt); ?>, "#9FE2BF"],
 
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Top 5 Selling items of the month ",
        width: 1000,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_production"));
      chart.draw(view, options);
  }
  </script>


  <!--===============================END COLUMN CHART FOR SALES======================================-->

<!--===============================START PIE CHART FOR SALES======================================-->
    <!--Load the AJAX API-->

    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Sales Order');
        data.addColumn('number', 'Open Sales Order');

        data.addRows([ 
          ['Apr', <?php echo e($apr); ?>],
          ['May', <?php echo e($may); ?>],
          ['June',<?php echo e($june); ?>],
          ['July',<?php echo e($july); ?>],
          ['Aug', <?php echo e($aug); ?>],
          ['Sep', <?php echo e($sep); ?>],
          ['Oct', <?php echo e($oct); ?>],
          ['Nov', <?php echo e($sep); ?>],
          ['Dec', <?php echo e($dec); ?>],
          ['Jan', <?php echo e($jan); ?>],
          ['Feb', <?php echo e($sep); ?>], 
          ['Mar', <?php echo e($mar); ?>],
        ]);

        var options = {
        title: "Monthly Wise Sales Records Financial Year <?php echo e($year); ?>",
        width: 800,
        height: 500,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

    <!--===============================END PIE CHART FOR SALES======================================-->


    <!--===============================START PIE CHART FOR PURCHASE======================================-->
    <!--Load the AJAX API-->

    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart_purchase);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart_purchase() {
       // alert(<?php echo e($sep_purchase); ?>); 

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Purchase Order');
        data.addColumn('number', ' Purchase Date');

        data.addRows([ 
          ['Apr', <?php echo e($apr_purchase); ?>],
          ['May', <?php echo e($may_purchase); ?>],
          ['June',<?php echo e($june_purchase); ?>],
          ['July',<?php echo e($july_purchase); ?>],
          ['Aug', <?php echo e($aug_purchase); ?>],
          ['Sep', <?php echo e($sep_purchase); ?>],
          ['Oct', <?php echo e($oct_purchase); ?>],
          ['Nov', <?php echo e($sep_purchase); ?>],
          ['Dec', <?php echo e($sep_purchase); ?>],
          ['Jan', <?php echo e($jan_purchase); ?>],
          ['Feb', <?php echo e($sep_purchase); ?>], 
          ['Mar', <?php echo e($mar_purchase); ?>],
        ]);

        var options = {
        title: "Monthly Wise Purchase Records Financial Year <?php echo e($year); ?>",
        width: 800,
        height: 500,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div_purchase'));
        chart.draw(data, options);
      }




                $(document).ready(function () {
          $('#dtHorizontalVerticalExample').DataTable({
          "scrollX": true,
          "scrollY": 200,
          });
          $('#dtHorizontalVerticalExample1').DataTable({
          "scrollX": true,
          "scrollY": 200,
          });
          $('#dtHorizontalVerticalExample2').DataTable({
          "scrollX": true,
          "scrollY": 200,
          });
          $('#dtHorizontalVerticalExample3').DataTable({
          "scrollX": true,
          "scrollY": 200,
          });
          $('#dtHorizontalVerticalExample4').DataTable({
          "scrollX": true,
          "scrollY": 200,
          });
          $('.dataTables_length').addClass('bs-select');
          });
    </script>

    <!--===============================END PIE CHART FOR SALES======================================-->



        <?php $__env->stopSection(); ?>
        <?php $__env->startPush('bottom-css'); ?>
        <style>

        .dtHorizontalVerticalExampleWrapper {
        max-width: 600px;
        margin: 0 auto;
        }
        #dtHorizontalVerticalExample th, td {
        white-space: nowrap;
        }

        .dtHorizontalVerticalExampleWrapper {
        max-width: 600px;
        margin: 0 auto;
        }
        #dtHorizontalVerticalExample1 th, td {
        white-space: nowrap;
        }
        #dtHorizontalVerticalExample2 th, td {
        white-space: nowrap;
        }
        #dtHorizontalVerticalExample3 th, td {
        white-space: nowrap;
        }
        #dtHorizontalVerticalExample4 th, td {
        white-space: nowrap;
        }
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_asc_disabled:before,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:before {
        bottom: .5em;
        }




      .home-box {
          box-shadow: 1px 1px 20px #ccc;
          border: 1px solid#ccc;
          padding: 20px 0 15px;
          text-align: center;
          border-radius: 5px;
          margin-bottom: 50px;
      }

      .home-box .cnt-title {
          font-size: 1.7em;
          color: #fff;
          font-weight: 600;
        
      }

      .home-box .cnt-number {
          font-size: 2em;
          font-weight: 600;
          color: #fff;
      }

      .box-title {
          font-size: 2em;
          font-weight: 600;
          color: #337ab7;
      }

      .box-color1 {
          background: #337ab7;
      }

      .box-color2 {
          background: #e8a137;
      }

      .box-color3 {
          background: #5da70b;
      }
      </style>
      <?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PROJECTS\UNICORN_DEV\resources\views/home.blade.php ENDPATH**/ ?>