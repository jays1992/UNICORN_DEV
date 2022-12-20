<?php

namespace App\Exports;
use DB;
use Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Admin\TblMstUser;


use Session;
use Response;
use SimpleXMLElement;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Chartblocks;
use App\Exports\PurchaseOrderRegister;
use Maatwebsite\Excel\Facades\Excel;














class PurchaseOrderRegister implements FromCollection, WithHeadings
{


 function __construct($SGLID,$From_Date,$To_Date,$BranchGroup,$BranchName,$ITEMGID,$ITEMID,$STATUS,$CYID) {
        $this->ITEMID = $ITEMID;
        $this->SGLID = $SGLID;
        $this->From_Date = $From_Date;
        $this->To_Date = $To_Date;
        $this->BranchName = $BranchName;
        $this->ITEMGID = $ITEMGID;
        $this->STATUS = $STATUS;
        $this->CYID = $CYID;
 }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        //dd($this->From_Date); 
        
        $ITEMID=implode(",",$this->ITEMID);
        $SGLID=implode(",",$this->SGLID);
        $BranchName=implode(",",$this->BranchName);      
        $ITEMGID=implode(",",$this->ITEMGID);
       



      return collect( $data=DB::select("SELECT TBL_TRN_PROR01_HDR.PO_NO, 
      TBL_TRN_PROR01_HDR.PO_DT,
      BG.BG_DESC AS BRANCH_GROUP,
      BR.BRNAME,
      V.VCODE AS VENDOR_CODE,
      V.NAME AS VENDOR_NAME,
      V.SAP_VENDOR_CODE,
      V.SAP_VENDOR_NAME1,
      HSN.HSNCODE,
      TBL_TRN_PRIN02_HDR.PI_NO, 
      TBL_TRN_VDQT01_HDR.VQ_NO,
      TBL_MST_ITEMGROUP.GROUPNAME,
      TBL_MST_ITEM.NAME AS Item_Name,
      TBL_MST_UOM.DESCRIPTIONS,
      B.BUNAME,
      TBL_MST_ITEM.ALPS_PART_NO,
      TBL_MST_ITEM.CUSTOMER_PART_NO,
      TBL_MST_ITEM.OEM_PART_NO,
      TBL_TRN_PROR01_MAT.PENDING_QTY,
      TBL_TRN_PROR01_MAT.PO_QTY-TBL_TRN_PROR01_MAT.PENDING_QTY AS CONSUME_QTY,
      TBL_TRN_PROR01_MAT.PO_QTY AS ACTUAL_QTY,
      TBL_TRN_PROR01_MAT.RATEP_UOM,
      
      ((TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.PO_QTY)+(case when CT.AMOUNT IS not NULL then CT.AMOUNT else  0 end))
      -(case when TBL_TRN_PROR01_MAT.DIS_AMT = '0.00' then convert(numeric(14,2),((TBL_TRN_PROR01_MAT.PO_QTY*TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.DIS_AMT)/100))
      else  TBL_TRN_PROR01_MAT.DIS_AMT end)	as AmountAfterDiscount,
      
      (((TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.PO_QTY)*(TBL_TRN_PROR01_MAT.IGST)/100)+(case when CT.AMOUNT IS not NULL then CT.AMOUNT else  0 end))
      -(case when TBL_TRN_PROR01_MAT.DIS_AMT = '0.00' then convert(numeric(14,2),((TBL_TRN_PROR01_MAT.PO_QTY*TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.DISCOUNT_PER)/100))
      else  TBL_TRN_PROR01_MAT.DIS_AMT end)	as IGST,
              
      (((TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.PO_QTY)*(TBL_TRN_PROR01_MAT.CGST)/100)+(case when CT.AMOUNT IS not NULL then CT.AMOUNT else  0 end))
      -(case when TBL_TRN_PROR01_MAT.DIS_AMT = '0.00' then convert(numeric(14,2),((TBL_TRN_PROR01_MAT.PO_QTY*TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.DISCOUNT_PER)/100))
      else  TBL_TRN_PROR01_MAT.DIS_AMT end)	as CGST,
           
      (((TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.PO_QTY)*(TBL_TRN_PROR01_MAT.CGST)/100)+(case when CT.AMOUNT IS not NULL then CT.AMOUNT else  0 end))
      -(case when TBL_TRN_PROR01_MAT.DIS_AMT = '0.00' then convert(numeric(14,2),((TBL_TRN_PROR01_MAT.PO_QTY*TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.DISCOUNT_PER)/100))
      else  TBL_TRN_PROR01_MAT.DIS_AMT end)	as SGST, 
              
      (((TBL_TRN_PROR01_MAT.RATEP_UOM * TBL_TRN_PROR01_MAT.PO_QTY)*(TBL_TRN_PROR01_MAT.CGST)/100)+ ((TBL_TRN_PROR01_MAT.RATEP_UOM * TBL_TRN_PROR01_MAT.PO_QTY)*(TBL_TRN_PROR01_MAT.CGST)/100)) AS TotalTax,
               
      ((TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.PO_QTY)+(case when TBL_TRN_PROR01_MAT.CGST IS not NULL then convert(numeric(14,2),((TBL_TRN_PROR01_MAT.PO_QTY*TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.CGST)/100)) else  0 end)+
      (case when TBL_TRN_PROR01_MAT.SGST IS not NULL then convert(numeric(14,2),((TBL_TRN_PROR01_MAT.PO_QTY*TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.SGST)/100)) else  0 end)+
      (case when TBL_TRN_PROR01_MAT.IGST IS not NULL then convert(numeric(14,2),((TBL_TRN_PROR01_MAT.PO_QTY*TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.IGST)/100)) else  0 end)+
      (case when CT.AMOUNT IS not NULL then CT.AMOUNT else  0 end))-(case when TBL_TRN_PROR01_MAT.DIS_AMT = '0.00' then convert(numeric(14,2),((TBL_TRN_PROR01_MAT.PO_QTY*TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.DISCOUNT_PER)/100)) else  TBL_TRN_PROR01_MAT.DIS_AMT end)
      as AmtafterTax,
      
      CT.AMOUNT AS CALCULATION,
      
      ((TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.PO_QTY)+(case when CT.AMOUNT IS not NULL then CT.AMOUNT else  0 end))-
      (case when TBL_TRN_PROR01_MAT.DIS_AMT = '0.00' then convert(numeric(14,2),((TBL_TRN_PROR01_MAT.PO_QTY*TBL_TRN_PROR01_MAT.RATEP_UOM*TBL_TRN_PROR01_MAT.DISCOUNT_PER)/100))
      else  TBL_TRN_PROR01_MAT.DIS_AMT end)	AS TotalTotalValue,
      
      CASE
      WHEN TBL_TRN_PROR01_HDR.STATUS ='A' THEN 'Approved'
      WHEN TBL_TRN_PROR01_HDR.STATUS = 'N' THEN 'Not Approved'
      WHEN TBL_TRN_PROR01_HDR.STATUS = 'c' THEN 'Cancelled'
      WHEN TBL_TRN_PROR01_HDR.STATUS = 'R' THEN 'Closed'			    
      END AS STATUS 
      
      FROM            TBL_TRN_PROR01_HDR LEFT OUTER JOIN
                               TBL_TRN_PROR01_MAT ON TBL_TRN_PROR01_HDR.POID = TBL_TRN_PROR01_MAT.POID_REF LEFT OUTER JOIN
                               TBL_MST_SUBLEDGER (NOLOCK) ON TBL_TRN_PROR01_HDR.VID_REF = TBL_MST_SUBLEDGER.SGLID LEFT OUTER JOIN 
                               TBL_MST_VENDOR AS V ON TBL_MST_SUBLEDGER.SGLID = V.SLID_REF LEFT OUTER JOIN
                               TBL_MST_VENDORGROUP AS VG ON V.VGID_REF = VG.VGID LEFT OUTER JOIN
                               TBL_MST_BRANCH AS BR WITH (NOLOCK) ON TBL_TRN_PROR01_HDR.BRID_REF=BR.BRID LEFT OUTER JOIN
                               TBL_MST_BRANCH_GROUP AS BG WITH (NOLOCK) ON BR.BGID_REF=BG.BGID LEFT OUTER JOIN				
                               TBL_TRN_PRIN02_HDR ON TBL_TRN_PROR01_MAT.PIID_REF = TBL_TRN_PRIN02_HDR.PIID LEFT OUTER JOIN
                               TBL_TRN_VDQT01_HDR ON TBL_TRN_PROR01_MAT.RFQPINO = TBL_TRN_VDQT01_HDR.VQID LEFT OUTER JOIN
                               TBL_MST_ITEM ON TBL_TRN_PROR01_MAT.ITEMID_REF = TBL_MST_ITEM.ITEMID LEFT OUTER JOIN
                               TBL_MST_BUSINESSUNIT AS B (NOLOCK) ON TBL_MST_ITEM.BUID_REF = B.BUID LEFT OUTER JOIN
                               TBL_MST_HSN AS HSN WITH (NOLOCK) ON TBL_MST_ITEM.HSNID_REF=HSN.HSNID LEFT OUTER JOIN
                               TBL_MST_ITEMGROUP ON TBL_MST_ITEM.ITEMGID_REF = TBL_MST_ITEMGROUP.ITEMGID LEFT OUTER JOIN
                               TBL_MST_UOM ON TBL_MST_ITEM.MAIN_UOMID_REF = TBL_MST_UOM.UOMID LEFT OUTER JOIN
                                   (SELECT        POID_REF, SUM(VALUE) + SUM(VALUE * IGST / 100) + SUM(VALUE * CGST / 100) + SUM(VALUE * SGST / 100) AS AMOUNT
                                     FROM            TBL_TRN_PROR01_CAL
                                     GROUP BY POID_REF) AS CT ON TBL_TRN_PROR01_MAT.POID_REF = CT.POID_REF
      WHERE TBL_TRN_PROR01_HDR.STATUS='$this->STATUS' AND TBL_TRN_PROR01_HDR.CYID_REF=$this->CYID AND TBL_TRN_PROR01_HDR.BRID_REF IN ($BranchName) AND TBL_TRN_PROR01_HDR.VID_REF IN ($SGLID)
      AND TBL_TRN_PROR01_MAT.ITEMID_REF IN ($ITEMID) AND TBL_TRN_PROR01_HDR.PO_DT BETWEEN '$this->From_Date' AND '$this->To_Date'"));
      
    }

    public function headings(): array
    {
        //Put Here Header Name That you want in your excel sheet 
        
 return [
    'PO No',
    'PO Date',
    'Branch Group',
    'Branch Name',
    'Vendor Code',
    'Vendor Name',
    'SAP Vendor Code',
    'SAP Vendor Name',
    'HSN Code',
    'PI NO',
    'VQ NO',   
    'Group Name',		
    'Item Name',
    'UOM',
    'Business Unit',
    'ALPS Part No',
    'Customer Part No',
    'OEM Part No',
    'Pending Qty',
    'Consumed Qty',
    'Actual Qty',
    'Rate',
    'Amount After Discount',
    'IGST',
    'CGST',
    'SGST',
    'Total TAX ',
    'Amount After TAX',
    'Calculation',
    'Total Value',
    'Status',			
];
    }
}





