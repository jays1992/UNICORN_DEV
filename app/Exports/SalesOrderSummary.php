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
use App\Exports\SalesOrderSummary;
use Maatwebsite\Excel\Facades\Excel;



class SalesOrderSummary implements FromCollection, WithHeadings
{


    protected $itemid;

 function __construct($SGLID,$From_Date,$To_Date,$BranchGroup,$BranchName,$EMPID,$ITEMGID,$ITEMID,$STATUS,$CYID) {
        $this->ITEMID = $ITEMID;
        $this->SGLID = $SGLID;
        $this->From_Date = $From_Date;
        $this->To_Date = $To_Date;
        $this->BranchName = $BranchName;
        $this->EMPID = $EMPID;
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
        $EMPID=implode(",",$this->EMPID);
        $ITEMGID=implode(",",$this->ITEMGID);
       



      return collect( $data=DB::select("SELECT   TBL_TRN_SLSO01_HDR.SONO,
      TBL_TRN_SLSO01_HDR.SODT,
      BG.BG_DESC AS BRANCH_GROUP,
      BR.BRNAME,
      C.CCODE AS CUSTOMER_CODE,
      C.NAME AS CUSTOMER_NAME,
      C.SAP_CUSTOMER_CODE,
      C.SAP_CUSTOMER_NAME, 
      CL.NAME AS BILLTO,
      SUM(TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM) as GROSS_AMOUNT,
      SUM(((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM)+(case when TBL_TRN_SLSO01_MAT.CGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.CGST)/100)) else  0 end)+
          (case when TBL_TRN_SLSO01_MAT.SGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.SGST)/100)) else  0 end)+
          (case when TBL_TRN_SLSO01_MAT.IGST IS not NULL then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.IGST)/100)) else  0 end)+
          (case when CT.AMOUNT IS not NULL then CT.AMOUNT else  0 end))-(case when TBL_TRN_SLSO01_MAT.DISCOUNT_AMT = '0.00' then convert(numeric(14,2),((TBL_TRN_SLSO01_MAT.SO_QTY*TBL_TRN_SLSO01_MAT.RATEPUOM*TBL_TRN_SLSO01_MAT.DISCPER)/100)) else  TBL_TRN_SLSO01_MAT.DISCOUNT_AMT end))
          as NET_AMOUNT,
      
                CASE
                WHEN TBL_TRN_SLSO01_HDR.STATUS ='A' THEN 'Approved'
                WHEN TBL_TRN_SLSO01_HDR.STATUS = 'N' THEN 'Not Approved'
                WHEN TBL_TRN_SLSO01_HDR.STATUS = 'c' THEN 'Cancelled'
                WHEN TBL_TRN_SLSO01_HDR.STATUS = 'R' THEN 'Closed' 
            END AS STATUS                     
            FROM            TBL_TRN_SLSO01_MAT (NOLOCK) LEFT OUTER JOIN
                                     TBL_TRN_SLSO01_HDR (NOLOCK) ON TBL_TRN_SLSO01_HDR.SOID = TBL_TRN_SLSO01_MAT.SOID_REF  LEFT OUTER JOIN
                                     TBL_MST_SUBLEDGER (NOLOCK) ON TBL_TRN_SLSO01_HDR.SLID_REF = TBL_MST_SUBLEDGER.SGLID LEFT OUTER JOIN
                                     TBL_MST_EMPLOYEE (NOLOCK) ON TBL_TRN_SLSO01_HDR.SPID_REF = TBL_MST_EMPLOYEE.EMPID LEFT OUTER JOIN
                                     TBL_MST_CUSTOMER AS C ON TBL_MST_SUBLEDGER.SGLID = C.SLID_REF LEFT OUTER JOIN
                                     TBL_MST_ITEM (NOLOCK) ON TBL_TRN_SLSO01_MAT.ITEMID_REF = TBL_MST_ITEM.ITEMID LEFT OUTER JOIN
                                     TBL_MST_BUSINESSUNIT (NOLOCK) ON TBL_MST_ITEM.BUID_REF = TBL_MST_BUSINESSUNIT.BUID LEFT OUTER JOIN
                                     TBL_MST_UOM (NOLOCK) AS MU ON TBL_TRN_SLSO01_MAT.MAIN_UOMID_REF = MU.UOMID LEFT OUTER JOIN
                                     TBL_MST_CUSTOMERLOCATION (NOLOCK) AS CL ON TBL_TRN_SLSO01_HDR.BILLTO = CL.CLID LEFT OUTER JOIN
                                     TBL_MST_BRANCH AS BR WITH (NOLOCK) ON TBL_TRN_SLSO01_HDR.BRID_REF=BR.BRID LEFT OUTER JOIN
                                     TBL_MST_BRANCH_GROUP AS BG WITH (NOLOCK) ON BR.BGID_REF=BG.BGID LEFT OUTER JOIN
                                     TBL_MST_CUSTOMERLOCATION (NOLOCK) ON TBL_TRN_SLSO01_HDR.SHIPTO = TBL_MST_CUSTOMERLOCATION.CLID LEFT OUTER JOIN
                                     TBL_MST_ITEMGROUP (NOLOCK) ON TBL_MST_ITEM.ITEMGID_REF = TBL_MST_ITEMGROUP.ITEMGID  LEFT OUTER JOIN
                                         (SELECT        SOID_REF, SUM(VALUE) + SUM(VALUE * IGST / 100) + SUM(VALUE * CGST / 100) + SUM(VALUE * SGST / 100) AS AMOUNT
                                           FROM            TBL_TRN_SLSO01_CAL (NOLOCK)
                                           GROUP BY SOID_REF) AS CT ON TBL_TRN_SLSO01_MAT.SOID_REF = CT.SOID_REF
            WHERE         (TBL_TRN_SLSO01_HDR.STATUS = '$this->STATUS') AND (TBL_TRN_SLSO01_HDR.CYID_REF = $this->CYID ) AND (TBL_TRN_SLSO01_HDR.BRID_REF in( $BranchName)) AND 
                                     (TBL_TRN_SLSO01_HDR.SODT BETWEEN '$this->From_Date' AND '$this->To_Date')
            AND (TBL_TRN_SLSO01_HDR.SLID_REF in ( $SGLID))
                                     AND (TBL_TRN_SLSO01_HDR.SPID_REF in ( $EMPID))
                                     AND (TBL_MST_ITEM.ITEMGID_REF in ( $ITEMGID))
                                     AND (TBL_TRN_SLSO01_MAT.ITEMID_REF in ( $ITEMID))
      GROUP BY TBL_TRN_SLSO01_HDR.SONO,
      TBL_TRN_SLSO01_HDR.SODT,
      BG.BG_DESC,
      BR.BRNAME,
      C.CCODE,
      C.NAME ,
      C.SAP_CUSTOMER_CODE,
      C.SAP_CUSTOMER_NAME, 
      CL.NAME,
      TBL_TRN_SLSO01_HDR.STATUS"));

      
    }

    public function headings(): array
    {
        //Put Here Header Name That you want in your excel sheet 
        return [
            'Sales Order No',
            'Sales Order Date',
            'Branch Group',
            'Branch Name',
            'Customer Code',
            'Customer Name',
            'SAP Customer Code',
            'SAP Customer Name',
            'Shipping Address',           
            'Gross Amount',           
            'Net Amount',           
            'Status',
        ];
    }
}





