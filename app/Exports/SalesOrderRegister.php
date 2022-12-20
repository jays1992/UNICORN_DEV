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
use App\Exports\SalesOrderRegister;
use Maatwebsite\Excel\Facades\Excel;














class SalesOrderRegister implements FromCollection, WithHeadings
{

 function __construct($SGLID,$From_Date,$To_Date,$BranchGroup,$BranchName,$EMPID,$ITEMGID,$ITEMID,$STATUS,$CYID,$SOID) {
        $this->ITEMID = $ITEMID;
        $this->SGLID = $SGLID;
        $this->From_Date = $From_Date;
        $this->To_Date = $To_Date;
        $this->BranchName = $BranchName;
        $this->EMPID = $EMPID;
        $this->ITEMGID = $ITEMGID;
        $this->STATUS = $STATUS;
        $this->CYID = $CYID;
        $this->SOID = $SOID;
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
        $EMPID=implode(",",$this->EMPID);
        $ITEMGID=implode(",",$this->ITEMGID);
        $SOID=implode(",",$this->SOID);
       



      return collect( $data=DB::select("SELECT TBL_TRN_SLSO01_HDR.SONO,
      TBL_TRN_SLSO01_HDR.SODT,
      TBL_TRN_SLSO01_HDR.OVFDT,
      TBL_TRN_SLSO01_HDR.OVTDT,
      TBL_MST_GENERALLEDGER.GLNAME,
      TBL_MST_EMPLOYEE.FNAME,
      BG.BG_DESC AS BRANCH_GROUP,
      BR.BRNAME,
      CG.DESCRIPTIONS AS CUSTOMER_GROUP,
      C.CCODE AS CUSTOMER_CODE,
      C.NAME AS CUSTOMER_NAME,
      C.SAP_CUSTOMER_CODE,
      C.SAP_CUSTOMER_NAME,
      TBL_MST_STATE.NAME AS STATE,
      TBL_TRN_SLEQ01_HDR.ENQNO,
      TBL_MST_ITEMGROUP.GROUPNAME, 
       TBL_MST_ITEM.ICODE,
        TBL_MST_ITEM.NAME,
       TBL_MST_ITEM.ALPS_PART_NO,
       TBL_MST_ITEM.CUSTOMER_PART_NO,
       TBL_MST_ITEM.OEM_PART_NO,
       TBL_MST_BUSINESSUNIT.BUNAME,
       HSN.HSNCODE,
       TBL_MST_UOM.DESCRIPTIONS AS UOM,
       TBL_TRN_SLSO01_MAT.PENDING_QTY,
       TBL_TRN_SLSO01_MAT.SO_QTY-TBL_TRN_SLSO01_MAT.PENDING_QTY AS CONSUMED_QTY,
       TBL_TRN_SLSO01_MAT.SO_QTY,
       TBL_TRN_SLSO01_MAT.RATEPUOM,
      (TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM)-(case when TBL_TRN_SLSO01_MAT.DISCOUNT_AMT = '0.00' then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.DISCPER)/100)) else  TBL_TRN_SLSO01_MAT.DISCOUNT_AMT end
      ) AS AMOUNT_AFTER_DISCOUNT,
      (case when TBL_TRN_SLSO01_MAT.IGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.IGST)/100)) else  0 end) AS IGST,
        (case when TBL_TRN_SLSO01_MAT.CGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.CGST)/100)) else  0 end) AS CGST,
        (case when TBL_TRN_SLSO01_MAT.SGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.SGST)/100)) else  0 end) AS SGST,
      
        (case when TBL_TRN_SLSO01_MAT.IGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.IGST)/100)) else  0 end) +
        (case when TBL_TRN_SLSO01_MAT.CGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.CGST)/100)) else  0 end)+
        (case when TBL_TRN_SLSO01_MAT.SGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.SGST)/100)) else  0 end) AS TOTAL_TAXES,
      
      
        ((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM)+(case when TBL_TRN_SLSO01_MAT.IGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.IGST)/100)) else  0 end) +
        (case when TBL_TRN_SLSO01_MAT.CGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.CGST)/100)) else  0 end)+
        (case when TBL_TRN_SLSO01_MAT.SGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.SGST)/100)) else  0 end)) AS AMOUNT_AFTER_TAX,
      
      
        CT.AMOUNT AS CALCULATION,
      
      
        ((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM)+(case when TBL_TRN_SLSO01_MAT.IGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.IGST)/100)) else  0 end) +
        (case when TBL_TRN_SLSO01_MAT.CGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.CGST)/100)) else  0 end)+
        (case when TBL_TRN_SLSO01_MAT.SGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.SGST)/100)) else  0 end)+(case when CT.AMOUNT IS not NULL then CT.AMOUNT else  0 end)) AS TOTAL_VALUE,
      
      
         CASE
                    WHEN TBL_TRN_SLSO01_HDR.STATUS ='A' THEN 'Approved'
                    WHEN TBL_TRN_SLSO01_HDR.STATUS = 'N' THEN 'Not Approved'
                    WHEN TBL_TRN_SLSO01_HDR.STATUS = 'c' THEN 'Cancelled'
                    WHEN TBL_TRN_SLSO01_HDR.STATUS = 'R' THEN 'Closed'
                            
                END AS STATUS 
      
      
      FROM        TBL_TRN_SLSO01_HDR LEFT OUTER JOIN
                        TBL_TRN_SLSO01_MAT ON TBL_TRN_SLSO01_HDR.SOID = TBL_TRN_SLSO01_MAT.SOID_REF LEFT OUTER JOIN
                        TBL_MST_GENERALLEDGER ON TBL_TRN_SLSO01_HDR.GLID_REF = TBL_MST_GENERALLEDGER.GLID LEFT OUTER JOIN 
                        TBL_MST_SUBLEDGER (NOLOCK) ON TBL_TRN_SLSO01_HDR.SLID_REF = TBL_MST_SUBLEDGER.SGLID LEFT OUTER JOIN 
                        TBL_MST_CUSTOMER AS C ON TBL_MST_SUBLEDGER.SGLID = C.SLID_REF LEFT OUTER JOIN
                        TBL_MST_CUSTOMERGROUP AS CG ON C.CGID_REF = CG.CGID LEFT OUTER JOIN
                        TBL_MST_BRANCH AS BR WITH (NOLOCK) ON TBL_TRN_SLSO01_HDR.BRID_REF=BR.BRID LEFT OUTER JOIN
                        TBL_MST_BRANCH_GROUP AS BG WITH (NOLOCK) ON BR.BGID_REF=BG.BGID LEFT OUTER JOIN
                        TBL_MST_CUSTOMER ON TBL_MST_SUBLEDGER.SGLID = TBL_MST_CUSTOMER.SLID_REF LEFT OUTER JOIN
                        TBL_MST_CITY ON TBL_MST_CUSTOMER.REGCITYID_REF = TBL_MST_CITY.CITYID LEFT OUTER JOIN
                        TBL_MST_STATE ON TBL_MST_CUSTOMER.REGSTID_REF = TBL_MST_STATE.STID LEFT OUTER JOIN
                        TBL_MST_EMPLOYEE ON TBL_TRN_SLSO01_HDR.SPID_REF = TBL_MST_EMPLOYEE.EMPID LEFT OUTER JOIN
                        TBL_MST_ITEM ON TBL_TRN_SLSO01_MAT.ITEMID_REF = TBL_MST_ITEM.ITEMID LEFT OUTER JOIN
                          TBL_MST_BUSINESSUNIT ON TBL_MST_ITEM.BUID_REF = TBL_MST_BUSINESSUNIT.BUID LEFT OUTER JOIN
                         TBL_MST_HSN AS HSN WITH (NOLOCK) ON TBL_MST_ITEM.HSNID_REF=HSN.HSNID LEFT OUTER JOIN
                        TBL_MST_ITEMGROUP ON TBL_MST_ITEM.ITEMGID_REF = TBL_MST_ITEMGROUP.ITEMGID LEFT OUTER JOIN
                        TBL_MST_UOM ON TBL_MST_ITEM.MAIN_UOMID_REF = TBL_MST_UOM.UOMID LEFT OUTER JOIN
                        TBL_TRN_SLEQ01_HDR ON TBL_TRN_SLSO01_MAT.SEQID_REF = TBL_TRN_SLEQ01_HDR.SEQID LEFT OUTER JOIN
                            (SELECT     SOID_REF, SUM(VALUE) + SUM(VALUE * IGST / 100) + SUM(VALUE * CGST / 100) + SUM(VALUE * SGST / 100) AS AMOUNT
                             FROM        TBL_TRN_SLSO01_CAL
                             GROUP BY SOID_REF) AS CT ON TBL_TRN_SLSO01_MAT.SOID_REF = CT.SOID_REF
      WHERE       TBL_TRN_SLSO01_HDR.STATUS='$this->STATUS' and C.SLID_REF IN ($SGLID)
      AND TBL_MST_ITEM.ITEMGID_REF IN ($ITEMGID) 
      AND TBL_MST_ITEM.ITEMID IN ($ITEMID) 
      AND TBL_TRN_SLSO01_HDR.SPID_REF IN ($EMPID)
      AND TBL_TRN_SLSO01_HDR.CYID_REF=$this->CYID
      AND TBL_TRN_SLSO01_HDR.BRID_REF IN ($BranchName)
      AND TBL_TRN_SLSO01_HDR.SOID IN ($SOID)
      AND TBL_TRN_SLSO01_HDR.SODT BETWEEN '$this->From_Date' AND '$this->To_Date'"));

      
    }

    public function headings(): array
    {
        //Put Here Header Name That you want in your excel sheet 
        return [
            'Sales Order No',
            'Sales Order Date',
            'Valid From Date',
            'Valid To Date',
            'GL Name',
            'Sales Person',
            'Branch Group',
            'Branch Group',
            'Customer Group',
			      'Customer Code',
            'Customer Name',
            'SAP Customer Code',
            'SAP Customer Name',
            'State',
            'Enquiry No',
            'Item Group',
            'Item Code',
            'Item Name',
            'ALPS Part No',
            'Customer Part No',
            'OEM Part No',
            'Business Unit',
            'HSN/SAC Code',
            'UOM',
            'Pending Qty',
            'Consumed Qty',
            'Actual Qty',
            'Rate Per UOM',
            'Amount After Discount',
            'IGST',
            'CGST',
            'SGST',
            'Total Tax',
            'Amount After Tax',
            'Calculation Temp Amount',
            'Total Order Value',
            'Status',            
        ];
    }
}




