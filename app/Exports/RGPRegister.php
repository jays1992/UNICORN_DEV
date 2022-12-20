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
use App\Exports\RGPRegister;
use Maatwebsite\Excel\Facades\Excel;














class RGPRegister implements FromCollection, WithHeadings
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
       



      return collect( $data=DB::select("						 SELECT       TBL_TRN_IRGP01_HDR.RGP_NO, 
      TBL_TRN_IRGP01_HDR.RGP_DT,
      BG.BG_DESC AS BRANCH_GROUP,
      BR.BRNAME,
      VG.DESCRIPTIONS AS VENDOR_GROUP,
      V.VCODE AS VENDOR_CODE,
      V.NAME AS VENDOR_NAME,
      V.SAP_VENDOR_CODE,
      V.SAP_VENDOR_NAME1,
      TBL_MST_ITEM.ICODE, 
        TBL_MST_ITEM.NAME AS ItemName, 
      TBL_MST_ITEM.ALPS_PART_NO,
     TBL_MST_ITEM.CUSTOMER_PART_NO,
     TBL_MST_ITEM.OEM_PART_NO,
      HSN.HSNCODE,
      TBL_MST_BUSINESSUNIT.BUNAME,
      TBL_MST_UOM.DESCRIPTIONS, 
      TBL_TRN_IRGP01_MAT.EDA,
      TBL_TRN_IRGP01_MAT.REMARKS,
      CASE
     WHEN TBL_TRN_IRGP01_HDR.STATUS ='A' THEN 'Approved'
     WHEN TBL_TRN_IRGP01_HDR.STATUS = 'N' THEN 'Not Approved'
     WHEN TBL_TRN_IRGP01_HDR.STATUS = 'c' THEN 'Cancelled'
     WHEN TBL_TRN_IRGP01_HDR.STATUS = 'R' THEN 'Closed'
   
     END AS STATUS 				 	 
      
      
     
FROM            TBL_TRN_IRGP01_MAT LEFT OUTER JOIN
                  TBL_TRN_IRGP01_HDR ON TBL_TRN_IRGP01_HDR.RGPID = TBL_TRN_IRGP01_MAT.RGPID_REF LEFT OUTER JOIN 
      TBL_MST_SUBLEDGER (NOLOCK) ON TBL_TRN_IRGP01_HDR.VID_REF = TBL_MST_SUBLEDGER.SGLID LEFT OUTER JOIN 
      TBL_MST_VENDOR AS V ON TBL_MST_SUBLEDGER.SGLID = V.SLID_REF LEFT OUTER JOIN
      TBL_MST_VENDORGROUP AS VG ON V.VGID_REF = VG.VGID LEFT OUTER JOIN
      TBL_MST_BRANCH AS BR WITH (NOLOCK) ON TBL_TRN_IRGP01_HDR.BRID_REF=BR.BRID LEFT OUTER JOIN
                  TBL_MST_BRANCH_GROUP AS BG WITH (NOLOCK) ON BR.BGID_REF=BG.BGID LEFT OUTER JOIN
                  TBL_MST_ITEM ON TBL_TRN_IRGP01_MAT.ITEMID_REF = TBL_MST_ITEM.ITEMID LEFT OUTER JOIN
        TBL_MST_BUSINESSUNIT ON TBL_MST_ITEM.BUID_REF = TBL_MST_BUSINESSUNIT.BUID LEFT OUTER JOIN
       TBL_MST_HSN AS HSN WITH (NOLOCK) ON TBL_MST_ITEM.HSNID_REF=HSN.HSNID LEFT OUTER JOIN
                  TBL_MST_UOM ON TBL_TRN_IRGP01_MAT.MAIN_UOMID_REF = TBL_MST_UOM.UOMID LEFT OUTER JOIN
                  TBL_MST_COMPANY ON TBL_TRN_IRGP01_HDR.CYID_REF = TBL_MST_COMPANY.CYID

      WHERE TBL_TRN_IRGP01_HDR.CYID_REF=$this->CYID AND TBL_TRN_IRGP01_HDR.STATUS='$this->STATUS' AND TBL_TRN_IRGP01_HDR.BRID_REF IN ($BranchName) AND 
      TBL_TRN_IRGP01_HDR.VID_REF IN ($SGLID) AND TBL_TRN_IRGP01_HDR.RGP_DT BETWEEN '$this->From_Date' AND '$this->To_Date'
      AND TBL_TRN_IRGP01_MAT.ITEMID_REF IN ($ITEMID) AND TBL_MST_ITEM.ITEMGID_REF IN ($ITEMGID)"));

      
    }

    public function headings(): array
    {
        //Put Here Header Name That you want in your excel sheet 
        return [
          'RGP No',
          'RGP Date',
          'Branch Group',
          'Branch Name',
          'Vendor Group',
          'Vendor Code',
          'Vendor Name',
          'SAP Vendor Code',
          'SAP Vendor Name',           		
          'Item Group Name',
         // 'Item Code',
          'Item Name',
          'ALPS Part No',
          'Customer Part No',
          'OEM Part No',
          'Billing Address',			
         // 'HSN/SAC Code',
          'Business Unit',		
          'UOM',		
          'EDA',	
          'Remarks',		
          'Status'			
      ];
    }
}





