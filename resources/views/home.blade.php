
@extends('layouts.app')
@section('content')
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

    @if(!empty($objSO) && !empty($right_objDataList))
    <div class="col-lg-6" id="columnchart_sales" >
    </div>
    @endif

    @if(!empty($objPO) && !empty($right_objDataList_PO))
    <div class="col-lg-6" id="columnchart_purchase" >
    </div>
    @endif
    </div>


    @if(!empty($topsales) ||!empty($obj_TopSalesBU))
<div class="row">
@if(!empty($topsales))
    <div class="col-lg-6" id="columnchart_production" >
    </div>
    @endif
    @if(!empty($obj_TopSalesBU && $company_check!='hidden'))
    <div class="col-lg-6" id="TOPSALES_BUWISE" >      
    </div>
    @endif
    </div>
    <div class="col-lg-1">
        <div>
        </div>
    </div> 
</div>
@endif

    @if(!empty($obj_TopInventoryBU) ||!empty($obj_TopPurchaseBU && $company_check!='hidden'))
<div class="row">
@if(!empty($obj_TopPurchaseBU && $company_check!='hidden'))
    <div class="col-lg-6" id="TOPPURCHASE_BUWISE" >
    </div>
    @endif
    @if(!empty($obj_TopInventoryBU && $company_check!='hidden'))
    <div class="col-lg-6" id="TOPINVENTORY_BUWISE" >      
    </div>
    @endif
    </div>
    <div class="col-lg-1">
        <div>
        </div>
    </div> 
</div>
@endif


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
  @if(!empty($objDataList) && !empty($right_objDataList))     
        
            @foreach($objDataList as $key => $val)

            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>

    <td><a href='{{route("transaction",[38,"edit","$val->SOID"]) }}'>{{isset($val->SONO) && $val->SONO !=''?$val->SONO:''}}</td></td>
    <td>{{isset($val->SODT) && $val->SODT !='' && $val->SODT !='1900-01-01' ? date('d-m-Y',strtotime($val->SODT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td>
  
    
    </tr>



    @endforeach 
    @endif

        @if(!empty($objDataList_challan) && !empty($right_objDataList_challan))      
            @foreach($objDataList_challan as $key => $val)
            @php
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
        @endphp
    <tr>
    <td>{{$module}}</td>
 
    <td><a href='{{route("transaction",[43,"edit","$val->SCID"]) }}'>{{isset($val->SCNO) && $val->SCNO !=''?$val->SCNO:''}}</a></td>
    <td>{{isset($val->SCDT) && $val->SCDT !='' && $val->SCDT !='1900-01-01' ? date('d-m-Y',strtotime($val->SCDT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td>

    
    </tr>

    @endforeach 
    @endif

    <!-- SALES INVOICE SECTION  -->

  @if(!empty($objDataList_sales_invoice) && !empty($right_objDataList_sales_invoice))     
        
            @foreach($objDataList_sales_invoice as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[44,"edit","$val->SIID"]) }}'>{{isset($val->SINO) && $val->SINO !=''?$val->SINO:''}}</td></td>
    <td>{{isset($val->SIDT) && $val->SIDT !='' && $val->SIDT !='1900-01-01' ? date('d-m-Y',strtotime($val->SIDT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td>
  
    
    </tr>
    @endforeach 
    @endif

    <!-- OPEN SALES ORDER SECTION  -->

  @if(!empty($objDataList_OSO) && !empty($right_objDataList_OSO))     
        
            @foreach($objDataList_OSO as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[40,"edit","$val->OSOID"])}}'>{{isset($val->OSONO) && $val->OSONO !=''?$val->OSONO:''}}</td></td>
    <td>{{isset($val->OSODT) && $val->OSODT !='' && $val->OSODT !='1900-01-01' ? date('d-m-Y',strtotime($val->OSODT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td>
  
    
    </tr>
    @endforeach 
    @endif


                <!--  SALES RETRUN SECTION  -->

        @if(!empty($objDataList_SR) && !empty($right_objDataList_SR))     
        
        @foreach($objDataList_SR as $key => $val)

        @php
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
        @endphp
<tr>
<td>{{$module}}</td>
<td><a href='{{route("transaction",[45,"edit","$val->SRID"])}}'>{{isset($val->SRNO) && $val->SRNO !=''?$val->SRNO:''}}</td></td>
<td>{{isset($val->SRDT) && $val->SRDT !='' && $val->SRDT !='1900-01-01' ? date('d-m-Y',strtotime($val->SRDT)):''}}</td>
<td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td>


</tr>
@endforeach 
@endif




                <!--  SALES SERVICE ORDER SECTION  -->



  @if(!empty($objDataList_SSO) && !empty($right_objDataList_SSO))     
        
        @foreach($objDataList_SSO as $key => $val)
        @php
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
        @endphp
<tr>
<td>{{$module}}</td>
<td><a href='{{route("transaction",[151,"edit","$val->SSOID"])}}'>{{isset($val->SSO_NO) && $val->SSO_NO !=''?$val->SSO_NO:''}}</td></td>
<td>{{isset($val->SSO_DT) && $val->SSO_DT !='' && $val->SSO_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->SSO_DT)):''}}</td>

<td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td>


</tr>
@endforeach 
@endif




    <!-- SALES SERVICE INVOICE SECTION  -->



  @if(!empty($objDataList_SSI) && !empty($right_objDataList_SSI))     
        
        @foreach($objDataList_SSI as $key => $val)
        @php
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
        @endphp
<tr>
<td>{{$module}}</td>
<td><a href='{{route("transaction",[156,"edit","$val->SSIID"])}}'>{{isset($val->SSI_NO) && $val->SSI_NO !=''?$val->SSI_NO:''}}</td></td>
<td>{{isset($val->SSI_DT) && $val->SSI_DT !='' && $val->SSI_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->SSI_DT)):''}}</td>

<td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td>


</tr>
@endforeach 
@endif            
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
  @if(!empty($objDataList_PO) && !empty($right_objDataList_PO))     
        
            @foreach($objDataList_PO as $key => $val)

            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[63,"edit","$val->POID"])}}'>{{isset($val->PO_NO) && $val->PO_NO !=''?$val->PO_NO:''}}</td></td>
    <td>{{isset($val->PO_DT) && $val->PO_DT !='' && $val->PO_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->PO_DT)):''}}</td>
    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
    </tr>

    @endforeach 
    @endif

    <!-- BPO SECTION  -->

  @if(!empty($objDataList_BPO) && !empty($right_objDataList_BPO))     
        
            @foreach($objDataList_BPO as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[67,"edit","$val->BPOID"])}}'>{{isset($val->BPO_NO) && $val->BPO_NO !=''?$val->BPO_NO:''}}</td></td>
    <td>{{isset($val->BPO_DT) && $val->BPO_DT !='' && $val->BPO_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->BPO_DT)):''}}</td>
    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
    </tr>

    @endforeach 
    @endif

    <!-- SPO SECTION  -->

    @if(!empty($objDataList_SPO) && !empty($right_objDataList_SPO))        
        @foreach($objDataList_SPO as $key => $val)
        @php
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
        @endphp
<tr>
<td>{{$module}}</td>
<td><a href='{{route("transaction",[69,"edit","$val->SPOID"])}}'>{{isset($val->SPO_NO) && $val->SPO_NO !=''?$val->SPO_NO:''}}</td></td>
<td>{{isset($val->SPO_DT) && $val->SPO_DT !='' && $val->SPO_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->SPO_DT)):''}}</td>
<td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
</tr>

@endforeach 
@endif



    <!-- PI SECTION  -->

    @if(!empty($objDataList_PI) && !empty($right_objDataList_PI))     
        
        @foreach($objDataList_PI as $key => $val)

        @php
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
        @endphp
<tr>
<td>{{$module}}</td>
<td><a href='{{route("transaction",[59,"edit","$val->PIID"])}}'>{{isset($val->PI_NO) && $val->PI_NO !=''?$val->PI_NO:''}}</td></td>
<td>{{isset($val->PI_DT) && $val->PI_DT !='' && $val->PI_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->PI_DT)):''}}</td>
<td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
</tr>

@endforeach 
@endif


    <!-- SPI SECTION  -->

    @if(!empty($objDataList_SPI) && !empty($right_objDataList_SPI))     
        
        @foreach($objDataList_SPI as $key => $val)

        @php
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
        @endphp
<tr>
<td>{{$module}}</td>
<td><a href='{{route("transaction",[201,"edit","$val->SPIID"])}}'>{{isset($val->SPI_NO) && $val->SPI_NO !=''?$val->SPI_NO:''}}</td></td>
<td>{{isset($val->SPI_DT) && $val->SPI_DT !='' && $val->SPI_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->SPI_DT)):''}}</td>
<td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
</tr>

@endforeach 
@endif


    <!-- PR SECTION  -->

    @if(!empty($objDataList_PR) && !empty($right_objDataList_PR))     
        
        @foreach($objDataList_PR as $key => $val)

        @php
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
        @endphp
<tr>
<td>{{$module}}</td>
<td><a href='{{route("transaction",[310,"edit","$val->PRRID"])}}'>{{isset($val->PRR_NO) && $val->PRR_NO !=''?$val->PRR_NO:''}}</td></td>
<td>{{isset($val->PRR_DT) && $val->PRR_DT !='' && $val->PRR_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->PRR_DT)):''}}</td>
<td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
</tr>

@endforeach 
@endif

    <!-- IPO SECTION  -->

    @if(!empty($objDataList_IPO) && !empty($right_objDataList_IPO))     
        
        @foreach($objDataList_IPO as $key => $val)

        @php
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
        @endphp
<tr>
<td>{{$module}}</td>
<td><a href='{{route("transaction",[299,"edit","$val->IPO_ID"])}}'>{{isset($val->IPO_NO) && $val->IPO_NO !=''?$val->IPO_NO:''}}</td></td>
<td>{{isset($val->IPO_DT) && $val->IPO_DT !='' && $val->IPO_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->IPO_DT)):''}}</td>
<td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
</tr>
@endforeach 
@endif

    <!-- PII SECTION  -->

    @if(!empty($objDataList_PII) && !empty($right_objDataList_PII))     
        
        @foreach($objDataList_PII as $key => $val)

        @php
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
        @endphp
<tr>
<td>{{$module}}</td>
<td><a href='{{route("transaction",[300,"edit","$val->PII_ID"])}}'>{{isset($val->PII_NO) && $val->PII_NO !=''?$val->PII_NO:''}}</td></td>
<td>{{isset($val->PII_DT) && $val->PII_DT !='' && $val->PII_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->PII_DT)):''}}</td>
<td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
</tr>

@endforeach 
@endif



            
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
  @if(!empty($objDataList_MRS) && !empty($right_objDataList_MRS))   
            @foreach($objDataList_MRS as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[88,"edit","$val->MRSID"])}}'>{{isset($val->MRS_NO) && $val->MRS_NO !=''?$val->MRS_NO:''}}</td></td>
    <td>{{isset($val->MRS_DT) && $val->MRS_DT !='' && $val->MRS_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->MRS_DT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td>
  
    
    </tr>
    @endforeach 
    @endif
    <!-- ==========GE====================== -->
  @if(!empty($objDataList_GE) && !empty($right_objDataList_GE))   
            @foreach($objDataList_GE as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[92,"edit","$val->GEID"])}}'>{{isset($val->GE_NO) && $val->GE_NO !=''?$val->GE_NO:''}}</td></td>
    <td>{{isset($val->GE_DT) && $val->GE_DT !='' && $val->GE_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->GE_DT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td>
  
    
    </tr>
    @endforeach 
    @endif





    <!-- ==========GRN AGAINST GE====================== -->
  @if(!empty($objDataList_GRN) && !empty($right_objDataList_GRN))   
            @foreach($objDataList_GRN as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[159,"edit","$val->GRNID"])}}'>{{isset($val->GRN_NO) && $val->GRN_NO !=''?$val->GRN_NO:''}}</td></td>
    <td>{{isset($val->GRN_DT) && $val->GRN_DT !='' && $val->GRN_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->GRN_DT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
    </tr>
    @endforeach 
    @endif      
    
    


            
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
    @if(!empty($objDataList_JV) && !empty($right_objDataList_JV))   
            @foreach($objDataList_JV as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[169,"edit","$val->JVID"])}}'>{{isset($val->JV_NO) && $val->JV_NO !=''?$val->JV_NO:''}}</td></td>
    <td>{{isset($val->JV_DT) && $val->JV_DT !='' && $val->JV_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->JV_DT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
    </tr>
    @endforeach 
    @endif    


    <!-- ==========AR DEBIT AND CREDIT NOTE====================== -->
  @if(!empty($objDataList_AR) && !empty($right_objDataList_AR))   
            @foreach($objDataList_AR as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[233,"edit","$val->ARDRCRID"])}}'>{{isset($val->AR_DOC_NO) && $val->AR_DOC_NO !=''?$val->AR_DOC_NO:''}}</td></td>
    <td>{{isset($val->AR_DOC_DT) && $val->AR_DOC_DT !='' && $val->AR_DOC_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->AR_DOC_DT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
    </tr>
    @endforeach 
    @endif    
    <!-- ==========AP DEBIT AND CREDIT NOTE====================== -->
  @if(!empty($objDataList_AP) && !empty($right_objDataList_AP))   
            @foreach($objDataList_AP as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[235,"edit","$val->APDRCRID"])}}'>{{isset($val->AP_DOC_NO) && $val->AP_DOC_NO !=''?$val->AP_DOC_NO:''}}</td></td>
    <td>{{isset($val->AP_DOC_DT) && $val->AP_DOC_DT !='' && $val->AP_DOC_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->AP_DOC_DT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
    </tr>
    @endforeach 
    @endif    


    <!-- ==========PAYMENT ENTRY====================== -->
  @if(!empty($objDataList_PAYMENT) && !empty($right_objDataList_PAYMENT))   
            @foreach($objDataList_PAYMENT as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[301,"edit","$val->PAYMENTID"])}}'>{{isset($val->PAYMENT_NO) && $val->PAYMENT_NO !=''?$val->PAYMENT_NO:''}}</td></td>
    <td>{{isset($val->PAYMENT_DT) && $val->PAYMENT_DT !='' && $val->PAYMENT_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->PAYMENT_DT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
    </tr>
    @endforeach 
    @endif    


    <!-- ==========RECEIPT ENTRY====================== -->
  @if(!empty($objDataList_RECEIPT) && !empty($right_objDataList_RECEIPT) )   
            @foreach($objDataList_RECEIPT as $key => $val)
            @php
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
            @endphp
    <tr>
    <td>{{$module}}</td>
    <td><a href='{{route("transaction",[302,"edit","$val->RECEIPTID"])}}'>{{isset($val->RECEIPT_NO) && $val->RECEIPT_NO !=''?$val->RECEIPT_NO:''}}</td></td>
    <td>{{isset($val->RECEIPT_DT) && $val->RECEIPT_DT !='' && $val->RECEIPT_DT !='1900-01-01' ? date('d-m-Y',strtotime($val->RECEIPT_DT)):''}}</td>

    <td>{{isset($val->STATUS_DESC) && $val->STATUS_DESC !=''?$val->STATUS_DESC:''}}</td> 
    </tr>
    @endforeach 
    @endif    



            
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

          @if(!empty($objDataList_TDCALL) && !empty($right_objDataList_TDCALL))   
              @foreach($objDataList_TDCALL as $key => $val)
              @php
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
                
              @endphp
              <?php
              if($tbldate == $nowdate){?>
                <tr>
                  <td>{{$module}}</td>
                  <td><a href='{{route("transaction",[439,"view","$LEAD_ID"])}}'>{{isset($val->LEAD_NO)?$val->LEAD_NO:''}}</td></td>
                  <td>{{isset($val->TASK_REMINDER_DATE) && $val->TASK_REMINDER_DATE !=''? date('d-m-Y',strtotime($val->TASK_REMINDER_DATE)):''}}</td>
                  <td>{{isset($val->COMPANY_NAME)?$val->COMPANY_NAME:''}}</td>
                  <td>{{isset($val->LEAD_DETAILS)?$val->LEAD_DETAILS:''}}</td>
                  <td>{{isset($val->CONTACT_PERSON)?$val->CONTACT_PERSON:''}}</td>
                  <td>{{isset($val->LANDLINE_NUMBER)?$val->LANDLINE_NUMBER:''}}</td>
                  <td>{{isset($val->MOBILE_NUMBER)?$val->MOBILE_NUMBER:''}}</td>
                  <td>{{isset($val->EMAIL)?$val->EMAIL:''}}</td>
                  <td>{{isset($val->DUE_DATE)?$val->DUE_DATE:''}}</td>
                  <td>{{isset($val->STATUS_DESC)?$val->STATUS_DESC:''}}</td>
              </tr>
              <?php }else{} ?>

              @endforeach 
            @endif
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
        ["Apr", {{$apr}}, "#DFFF00"],
        ["May", {{$may}}, "#FFBF00"],
        ["June", {{$june}}, "#FF7F50"],
        ["July",{{$july}}, "#DE3163"],
        ["Aug", {{$aug}}, "#9FE2BF"],
        ["Sep", {{$sep}}, "color: #40E0D0"],
        ["Oct", {{$oct}}, "color: #6495ED"],
        ["Nov", {{$nov}}, "color: #CCCCFF"],
        ["Dec", {{$dec}}, "color: #FFC0CB"],
        ["Jan", {{$jan}}, "color: #00FF00"],
        ["Feb",{{$feb}}, "color: #0000FF"],
        ["Mar", {{$mar}}, "color: #800080"]       

      ]);


      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Month wise Sales Analysis for the year {{$year}} ",
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
        ["Apr", {{$apr_purchase}}, "#DFFF00"],
        ["May", {{$may_purchase}}, "#FFBF00"],
        ["June", {{$june_purchase}}, "#FF7F50"],
        ["July",{{$july_purchase}}, "#DE3163"],
        ["Aug", {{$aug_purchase}}, "#9FE2BF"],
        ["Sep", {{$sep_purchase}}, "color: #40E0D0"],
        ["Oct", {{$oct_purchase}}, "color: #6495ED"],
        ["Nov", {{$nov_purchase}}, "color: #CCCCFF"],
        ["Dec", {{$dec_purchase}}, "color: #FFC0CB"],
        ["Jan", {{$jan_purchase}}, "color: #00FF00"],
        ["Feb",{{$feb_purchase}}, "color: #0000FF"],
        ["Mar", {{$mar_purchase}}, "color: #800080"]     
      ]);


      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Month wise Procurement  Analysis for the year {{$year}} ",
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

@if(isset($company_check) && $company_check!='hidden')
  
  <!--===============================START COLUMN CHART FOR SALES BU WISE======================================-->

  <script type="text/javascript">
  
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart_production);

    function drawChart_production() {
      
      var data =    google.visualization.arrayToDataTable([
         ["Qty", "Qty", { role: "style" } ],
   
        ["{{isset($obj_TopSalesBU[0]->BUNAME) && $obj_TopSalesBU[0]->BUNAME!='' ? $obj_TopSalesBU[0]->BUNAME:''  }}", {{isset($obj_TopSalesBU[0]->Total_Sales) && $obj_TopSalesBU[0]->Total_Sales!='' ? $obj_TopSalesBU[0]->Total_Sales:''  }}, "#DFFF00"],
        ["{{isset($obj_TopSalesBU[1]->BUNAME) && $obj_TopSalesBU[1]->BUNAME!='' ? $obj_TopSalesBU[1]->BUNAME:''  }}", {{isset($obj_TopSalesBU[1]->Total_Sales) && $obj_TopSalesBU[1]->Total_Sales!='' ? $obj_TopSalesBU[1]->Total_Sales:''  }}, "#FFBF00"], 
        ["{{isset($obj_TopSalesBU[2]->BUNAME) && $obj_TopSalesBU[2]->BUNAME!='' ? $obj_TopSalesBU[2]->BUNAME:''  }}", {{isset($obj_TopSalesBU[2]->Total_Sales) && $obj_TopSalesBU[2]->Total_Sales!='' ? $obj_TopSalesBU[2]->Total_Sales:''  }}, "#FF7F50"],   
        ["{{isset($obj_TopSalesBU[3]->BUNAME) && $obj_TopSalesBU[3]->BUNAME!='' ? $obj_TopSalesBU[3]->BUNAME:''  }}", {{isset($obj_TopSalesBU[3]->Total_Sales) && $obj_TopSalesBU[3]->Total_Sales!='' ? $obj_TopSalesBU[3]->Total_Sales:''  }}, "#DE3163"],  
        ["{{isset($obj_TopSalesBU[4]->BUNAME) && $obj_TopSalesBU[4]->BUNAME!='' ? $obj_TopSalesBU[4]->BUNAME:''  }}", {{isset($obj_TopSalesBU[4]->Total_Sales) && $obj_TopSalesBU[4]->Total_Sales!='' ? $obj_TopSalesBU[4]->Total_Sales:''  }}, "#9FE2BF"],
        <?php if(isset($obj_TopSalesBU[5]->BUNAME) && $obj_TopSalesBU[5]->BUNAME!='') {?>
        ["{{isset($obj_TopSalesBU[5]->BUNAME) && $obj_TopSalesBU[5]->BUNAME!='' ? $obj_TopSalesBU[5]->BUNAME:''  }}", {{isset($obj_TopSalesBU[5]->Total_Sales) && $obj_TopSalesBU[5]->Total_Sales!='' ? $obj_TopSalesBU[5]->Total_Sales:''  }}, "#40E0D0"],
        <?php }else if(isset($obj_TopSalesBU[6]->BUNAME) && $obj_TopSalesBU[6]->BUNAME!='') {?>
        ["{{isset($obj_TopSalesBU[6]->BUNAME) && $obj_TopSalesBU[6]->BUNAME!='' ? $obj_TopSalesBU[6]->BUNAME:''  }}", {{isset($obj_TopSalesBU[6]->Total_Sales) && $obj_TopSalesBU[6]->Total_Sales!='' ? $obj_TopSalesBU[6]->Total_Sales:''  }}, "#6495ED"],
        <?php }else if(isset($obj_TopSalesBU[7]->BUNAME) && $obj_TopSalesBU[7]->BUNAME!='') {?>
        ["{{isset($obj_TopSalesBU[7]->BUNAME) && $obj_TopSalesBU[7]->BUNAME!='' ? $obj_TopSalesBU[7]->BUNAME:''  }}", {{isset($obj_TopSalesBU[7]->Total_Sales) && $obj_TopSalesBU[7]->Total_Sales!='' ? $obj_TopSalesBU[7]->Total_Sales:''  }}, "#CCCCFF"],
        <?php }else if(isset($obj_TopSalesBU[8]->BUNAME) && $obj_TopSalesBU[8]->BUNAME!='') {?>
        ["{{isset($obj_TopSalesBU[8]->BUNAME) && $obj_TopSalesBU[8]->BUNAME!='' ? $obj_TopSalesBU[8]->BUNAME:''  }}", {{isset($obj_TopSalesBU[8]->Total_Sales) && $obj_TopSalesBU[8]->Total_Sales!='' ? $obj_TopSalesBU[8]->Total_Sales:''  }}, "#FFC0CB"],
        <?php }else if(isset($obj_TopSalesBU[9]->BUNAME) && $obj_TopSalesBU[9]->BUNAME!='') {?>
        ["{{isset($obj_TopSalesBU[9]->BUNAME) && $obj_TopSalesBU[9]->BUNAME!='' ? $obj_TopSalesBU[9]->BUNAME:''  }}", {{isset($obj_TopSalesBU[9]->Total_Sales) && $obj_TopSalesBU[9]->Total_Sales!='' ? $obj_TopSalesBU[9]->Total_Sales:''  }}, "#00FF00"],
     
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
        title: "Top 10 Selling items Business Unit Wise Year {{$year}} ",
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
   
        ["{{isset($obj_TopPurchaseBU[0]->BUNAME) && $obj_TopPurchaseBU[0]->BUNAME!='' ? $obj_TopPurchaseBU[0]->BUNAME:''  }}", {{isset($obj_TopPurchaseBU[0]->QTYS) && $obj_TopPurchaseBU[0]->QTYS!='' ? $obj_TopPurchaseBU[0]->QTYS:''  }}, "#DFFF00"],
        ["{{isset($obj_TopPurchaseBU[1]->BUNAME) && $obj_TopPurchaseBU[1]->BUNAME!='' ? $obj_TopPurchaseBU[1]->BUNAME:''  }}", {{isset($obj_TopPurchaseBU[1]->QTYS) && $obj_TopPurchaseBU[1]->QTYS!='' ? $obj_TopPurchaseBU[1]->QTYS:''  }}, "#FFBF00"], 
        ["{{isset($obj_TopPurchaseBU[2]->BUNAME) && $obj_TopPurchaseBU[2]->BUNAME!='' ? $obj_TopPurchaseBU[2]->BUNAME:''  }}", {{isset($obj_TopPurchaseBU[2]->QTYS) && $obj_TopPurchaseBU[2]->QTYS!='' ? $obj_TopPurchaseBU[2]->QTYS:''  }}, "#FF7F50"],   
        ["{{isset($obj_TopPurchaseBU[3]->BUNAME) && $obj_TopPurchaseBU[3]->BUNAME!='' ? $obj_TopPurchaseBU[3]->BUNAME:''  }}", {{isset($obj_TopPurchaseBU[3]->QTYS) && $obj_TopPurchaseBU[3]->QTYS!='' ? $obj_TopPurchaseBU[3]->QTYS:''  }}, "#DE3163"],  
        ["{{isset($obj_TopPurchaseBU[4]->BUNAME) && $obj_TopPurchaseBU[4]->BUNAME!='' ? $obj_TopPurchaseBU[4]->BUNAME:''  }}", {{isset($obj_TopPurchaseBU[4]->QTYS) && $obj_TopPurchaseBU[4]->QTYS!='' ? $obj_TopPurchaseBU[4]->QTYS:''  }}, "#9FE2BF"],
        <?php if(isset($obj_TopPurchaseBU[5]->BUNAME) && $obj_TopPurchaseBU[5]->BUNAME!='') {?>
        ["{{isset($obj_TopPurchaseBU[5]->BUNAME) && $obj_TopPurchaseBU[5]->BUNAME!='' ? $obj_TopPurchaseBU[5]->BUNAME:''  }}", {{isset($obj_TopPurchaseBU[5]->QTYS) && $obj_TopPurchaseBU[5]->QTYS!='' ? $obj_TopPurchaseBU[5]->QTYS:''  }}, "#40E0D0"],
        <?php }else if(isset($obj_TopPurchaseBU[6]->BUNAME) && $obj_TopPurchaseBU[6]->BUNAME!='') {?>
        ["{{isset($obj_TopPurchaseBU[6]->BUNAME) && $obj_TopPurchaseBU[6]->BUNAME!='' ? $obj_TopPurchaseBU[6]->BUNAME:''  }}", {{isset($obj_TopPurchaseBU[6]->QTYS) && $obj_TopPurchaseBU[6]->QTYS!='' ? $obj_TopPurchaseBU[6]->QTYS:''  }}, "#6495ED"],
        <?php }else if(isset($obj_TopPurchaseBU[7]->BUNAME) && $obj_TopPurchaseBU[7]->BUNAME!='') {?>
        ["{{isset($obj_TopPurchaseBU[7]->BUNAME) && $obj_TopPurchaseBU[7]->BUNAME!='' ? $obj_TopPurchaseBU[7]->BUNAME:''  }}", {{isset($obj_TopPurchaseBU[7]->QTYS) && $obj_TopPurchaseBU[7]->QTYS!='' ? $obj_TopPurchaseBU[7]->QTYS:''  }}, "#CCCCFF"],
        <?php }else if(isset($obj_TopPurchaseBU[8]->BUNAME) && $obj_TopPurchaseBU[8]->BUNAME!='') {?>
        ["{{isset($obj_TopPurchaseBU[8]->BUNAME) && $obj_TopPurchaseBU[8]->BUNAME!='' ? $obj_TopPurchaseBU[8]->BUNAME:''  }}", {{isset($obj_TopPurchaseBU[8]->QTYS) && $obj_TopPurchaseBU[8]->QTYS!='' ? $obj_TopPurchaseBU[8]->QTYS:''  }}, "#FFC0CB"],
        <?php }else if(isset($obj_TopPurchaseBU[9]->BUNAME) && $obj_TopPurchaseBU[9]->BUNAME!='') {?>
        ["{{isset($obj_TopPurchaseBU[9]->BUNAME) && $obj_TopPurchaseBU[9]->BUNAME!='' ? $obj_TopPurchaseBU[9]->BUNAME:''  }}", {{isset($obj_TopPurchaseBU[9]->QTYS) && $obj_TopPurchaseBU[9]->QTYS!='' ? $obj_TopPurchaseBU[9]->QTYS:''  }}, "#00FF00"],
     
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
        title: "Top 10 Procurement items Business Unit Wise Year {{$year}} ",
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
   
        ["{{isset($obj_TopInventoryBU[0]->BUNAME) && $obj_TopInventoryBU[0]->BUNAME!='' ? $obj_TopInventoryBU[0]->BUNAME:''  }}", {{isset($obj_TopInventoryBU[0]->QTYS) && $obj_TopInventoryBU[0]->QTYS!='' ? $obj_TopInventoryBU[0]->QTYS:''  }}, "#DFFF00"],
        ["{{isset($obj_TopInventoryBU[1]->BUNAME) && $obj_TopInventoryBU[1]->BUNAME!='' ? $obj_TopInventoryBU[1]->BUNAME:''  }}", {{isset($obj_TopInventoryBU[1]->QTYS) && $obj_TopInventoryBU[1]->QTYS!='' ? $obj_TopInventoryBU[1]->QTYS:''  }}, "#FFBF00"], 
        ["{{isset($obj_TopInventoryBU[2]->BUNAME) && $obj_TopInventoryBU[2]->BUNAME!='' ? $obj_TopInventoryBU[2]->BUNAME:''  }}", {{isset($obj_TopInventoryBU[2]->QTYS) && $obj_TopInventoryBU[2]->QTYS!='' ? $obj_TopInventoryBU[2]->QTYS:''  }}, "#FF7F50"],   
        ["{{isset($obj_TopInventoryBU[3]->BUNAME) && $obj_TopInventoryBU[3]->BUNAME!='' ? $obj_TopInventoryBU[3]->BUNAME:''  }}", {{isset($obj_TopInventoryBU[3]->QTYS) && $obj_TopInventoryBU[3]->QTYS!='' ? $obj_TopInventoryBU[3]->QTYS:''  }}, "#DE3163"],  
        ["{{isset($obj_TopInventoryBU[4]->BUNAME) && $obj_TopInventoryBU[4]->BUNAME!='' ? $obj_TopInventoryBU[4]->BUNAME:''  }}", {{isset($obj_TopInventoryBU[4]->QTYS) && $obj_TopInventoryBU[4]->QTYS!='' ? $obj_TopInventoryBU[4]->QTYS:''  }}, "#9FE2BF"],
        <?php if(isset($obj_TopInventoryBU[5]->BUNAME) && $obj_TopInventoryBU[5]->BUNAME!='') {?>
        ["{{isset($obj_TopInventoryBU[5]->BUNAME) && $obj_TopInventoryBU[5]->BUNAME!='' ? $obj_TopInventoryBU[5]->BUNAME:''  }}", {{isset($obj_TopInventoryBU[5]->QTYS) && $obj_TopInventoryBU[5]->QTYS!='' ? $obj_TopInventoryBU[5]->QTYS:''  }}, "#40E0D0"],
        <?php }else if(isset($obj_TopInventoryBU[6]->BUNAME) && $obj_TopInventoryBU[6]->BUNAME!='') {?>
        ["{{isset($obj_TopInventoryBU[6]->BUNAME) && $obj_TopInventoryBU[6]->BUNAME!='' ? $obj_TopInventoryBU[6]->BUNAME:''  }}", {{isset($obj_TopInventoryBU[6]->QTYS) && $obj_TopInventoryBU[6]->QTYS!='' ? $obj_TopInventoryBU[6]->QTYS:''  }}, "#6495ED"],
        <?php }else if(isset($obj_TopInventoryBU[7]->BUNAME) && $obj_TopInventoryBU[7]->BUNAME!='') {?>
        ["{{isset($obj_TopInventoryBU[7]->BUNAME) && $obj_TopInventoryBU[7]->BUNAME!='' ? $obj_TopInventoryBU[7]->BUNAME:''  }}", {{isset($obj_TopInventoryBU[7]->QTYS) && $obj_TopInventoryBU[7]->QTYS!='' ? $obj_TopInventoryBU[7]->QTYS:''  }}, "#CCCCFF"],
        <?php }else if(isset($obj_TopInventoryBU[8]->BUNAME) && $obj_TopInventoryBU[8]->BUNAME!='') {?>
        ["{{isset($obj_TopInventoryBU[8]->BUNAME) && $obj_TopInventoryBU[8]->BUNAME!='' ? $obj_TopInventoryBU[8]->BUNAME:''  }}", {{isset($obj_TopInventoryBU[8]->QTYS) && $obj_TopInventoryBU[8]->QTYS!='' ? $obj_TopInventoryBU[8]->QTYS:''  }}, "#FFC0CB"],
        <?php }else if(isset($obj_TopInventoryBU[9]->BUNAME) && $obj_TopInventoryBU[9]->BUNAME!='') {?>
        ["{{isset($obj_TopInventoryBU[9]->BUNAME) && $obj_TopInventoryBU[9]->BUNAME!='' ? $obj_TopInventoryBU[9]->BUNAME:''  }}", {{isset($obj_TopInventoryBU[9]->QTYS) && $obj_TopInventoryBU[9]->QTYS!='' ? $obj_TopInventoryBU[9]->QTYS:''  }}, "#00FF00"],
     
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
        title: "Top 10 Inventory items Business Unit Wise Year {{$year}} ",
        width: 1000,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("TOPINVENTORY_BUWISE"));
      chart.draw(view, options);
  }
  </script>
@endif
  <!--===============================END COLUMN CHART FOR PURCHASE BU WISE======================================-->

  <!--===============================START COLUMN CHART FOR SALES======================================-->


  <script type="text/javascript">
  
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart_production);

    function drawChart_production() {
      
      var data =    google.visualization.arrayToDataTable([
         ["Qty", "Qty", { role: "style" } ],
        ["{{$item1}}", {{$item1amt}}, "#DFFF00"],
        ["{{$item2}}", {{$item2amt}}, "#FFBF00"],
        ["{{$item3}}", {{$item3amt}}, "#FF7F50"],
        ["{{$item4}}", {{$item4amt}}, "#DE3163"],
        ["{{$item5}}", {{$item5amt}}, "#9FE2BF"],
 
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
          ['Apr', {{$apr}}],
          ['May', {{$may}}],
          ['June',{{$june}}],
          ['July',{{$july}}],
          ['Aug', {{$aug}}],
          ['Sep', {{$sep}}],
          ['Oct', {{$oct}}],
          ['Nov', {{$sep}}],
          ['Dec', {{$dec}}],
          ['Jan', {{$jan}}],
          ['Feb', {{$sep}}], 
          ['Mar', {{$mar}}],
        ]);

        var options = {
        title: "Monthly Wise Sales Records Financial Year {{$year}}",
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
       // alert({{$sep_purchase}}); 

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Purchase Order');
        data.addColumn('number', ' Purchase Date');

        data.addRows([ 
          ['Apr', {{$apr_purchase}}],
          ['May', {{$may_purchase}}],
          ['June',{{$june_purchase}}],
          ['July',{{$july_purchase}}],
          ['Aug', {{$aug_purchase}}],
          ['Sep', {{$sep_purchase}}],
          ['Oct', {{$oct_purchase}}],
          ['Nov', {{$sep_purchase}}],
          ['Dec', {{$sep_purchase}}],
          ['Jan', {{$jan_purchase}}],
          ['Feb', {{$sep_purchase}}], 
          ['Mar', {{$mar_purchase}}],
        ]);

        var options = {
        title: "Monthly Wise Purchase Records Financial Year {{$year}}",
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



        @endsection
        @push('bottom-css')
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
      @endpush

