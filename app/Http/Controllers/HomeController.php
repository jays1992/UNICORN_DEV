<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\TblMstUser;
use Auth;
use DB;
use Session;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Helpers\Utils;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF'); 



        $objRights = DB::table('TBL_MST_USERROLMAP')
        ->where('TBL_MST_USERROLMAP.USERID_REF','=',Auth::user()->USERID)
        ->where('TBL_MST_USERROLMAP.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_USERROLMAP.BRID_REF','=',Session::get('BRID_REF'))
        ->where('TBL_MST_USERROLMAP.FYID_REF','=',Session::get('FYID_REF'))
        ->leftJoin('TBL_MST_ROLEDETAILS', 'TBL_MST_USERROLMAP.ROLLID_REF','=','TBL_MST_ROLEDETAILS.ROLLID_REF')
        ->where('TBL_MST_ROLEDETAILS.VTID_REF','=',38)
        ->select('TBL_MST_USERROLMAP.*', 'TBL_MST_ROLEDETAILS.*')
        ->first();

    //     $db_menu = DB::select('select * from VW_MENU  where userid_ref is not null AND VT_SEQUENCE is not null 
    //     AND userid_ref=?  AND cyid_ref = ?   AND brid_ref = ?  AND vtid_ref = ?     order by MODULE_SEQUENCE ASC,VT_SEQUENCE ASC, ranks ASC ', 
    //     [Auth::user()->USERID, Auth::user()->CYID_REF, Session::get('BRID_REF'),$VTID_REF]);

    //    dd($db_menu); 

 

      



      $year=date('Y');
  

//====================SALES Invoice SECTION ===============================

       
		$sp_popup = [
            $CYID_REF, $BRID_REF,$FYID_REF,$year
        ]; 
        
            $objSO = DB::select('EXEC SP_GET_SALES_AMOUNT ?,?,?,?', $sp_popup);
     
		$amount = [];
		$MonthArr = [];
		$month = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan','Feb','Mar'];
	   $apr=0.00; 
	   $may=0.00; 
	   $june=0.00; 
	   $july=0.00; 
	   $aug=0.00;  
	   $sep=0.00;  
	   $oct=0.00; 
	   $nov=0.00; 
	   $dec=0.00; 
	   $jan=0.00; 
	   $feb=0.00;  
	   $mar=0.00; 
    foreach ($objSO as $key => $value) {
		
		  if($value->MTH == 4)
		  {
            $apr=$value->AMOUNT;
		  }
		  else if($value->MTH == 5)
		  {
            $may=$value->AMOUNT;
		  }
		  else if($value->MTH == 6)
		  {
            $june=$value->AMOUNT;
		  }
		  else if($value->MTH == 7)
		  {
            $july=$value->AMOUNT;
		  }
		  else if($value->MTH == 8)
		  {
            $aug=$value->AMOUNT;
		  }
		  else if($value->MTH == 9)
		  {
            $sep=$value->AMOUNT;
		  }
		  else if($value->MTH == 10)
		  {
            $oct=$value->AMOUNT;
		  }
		  else if($value->MTH == 11)
		  {
            $nov=$value->AMOUNT;
		  }
		  else if($value->MTH == 12)
		  {
            $dec=$value->AMOUNT;
		  }
		  else if($value->MTH == 1)
		  {
            $jan=$value->AMOUNT;
		  }
		  else if($value->MTH == 2)
		  {
            $feb=$value->AMOUNT;
		  }
		  else if($value->MTH == 3)
		  {
            $mar=$value->AMOUNT;
		  }
    }
	
   //==============================PURCHASE INVOICE SECTION ========================================
   $sp_popup = [
            $CYID_REF, $BRID_REF,$FYID_REF,$year
        ]; 
        
            $objPO = DB::select('EXEC SP_GET_PURCHASE_AMOUNT ?,?,?,?', $sp_popup);
     
		$amount = [];
		$MonthArr = [];
		$month = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan','Feb','Mar'];
	   $apr_purchase=0.00; 
	   $may_purchase=0.00; 
	   $june_purchase=0.00; 
	   $july_purchase=0.00; 
	   $aug_purchase=0.00;  
	   $sep_purchase=0.00;  
	   $oct_purchase=0.00; 
	   $nov_purchase=0.00; 
	   $dec_purchase=0.00; 
	   $jan_purchase=0.00; 
	   $feb_purchase=0.00;  
	   $mar_purchase=0.00; 
    foreach ($objPO as $key => $value) {
		
		  if($value->MTH == 4)
		  {
            $apr_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 5)
		  {
            $may_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 6)
		  {
            $june_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 7)
		  {
            $july_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 8)
		  {
            $aug_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 9)
		  {
            $sep_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 10)
		  {
            $oct_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 11)
		  {
            $nov_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 12)
		  {
            $dec_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 1)
		  {
            $jan_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 2)
		  {
            $feb_purchase=$value->AMOUNT;
		  }
		  else if($value->MTH == 3)
		  {
            $mar_purchase=$value->AMOUNT;
		  }
    }
   
        $obj_TopSalesBU = DB::table('TBL_TRN_SLSI01_HDR')
        ->where('TBL_TRN_SLSI01_HDR.CYID_REF','=',$CYID_REF)
        ->where('TBL_TRN_SLSI01_HDR.BRID_REF','=',$BRID_REF)
        ->where('TBL_TRN_SLSI01_HDR.FYID_REF','=',$FYID_REF)
        ->where('TBL_TRN_SLSI01_HDR.STATUS','=','A') 
        ->where('TBL_MST_BUSINESSUNIT.BUNAME','!=','') 
        //->whereMonth('SIDT', date('m'))
        //->whereYear('SIDT', date('Y'))
        ->leftJoin('TBL_TRN_SLSI01_MAT','TBL_TRN_SLSI01_MAT.SIID_REF','=','TBL_TRN_SLSI01_HDR.SIID')
        ->leftJoin('TBL_MST_ITEM','TBL_MST_ITEM.ITEMID','=','TBL_TRN_SLSI01_MAT.ITEMID_REF')    
        ->leftJoin('TBL_MST_BUSINESSUNIT', 'TBL_MST_ITEM.BUID_REF','=','TBL_MST_BUSINESSUNIT.BUID')          
        ->select('TBL_MST_BUSINESSUNIT.BUNAME',   DB::raw('SUM(TBL_TRN_SLSI01_MAT.SIMAIN_QTY) as Total_Sales'))
        ->groupBy('TBL_MST_BUSINESSUNIT.BUNAME')
        ->orderBy('Total_Sales','desc')
        ->limit(10)
        ->get()->toArray();

        $obj_TopPurchaseBU = DB::select("SELECT top 10 K.BUNAME,SUM(K.QTY) AS QTYS FROM
        (SELECT  B.BUNAME,SUM(M.BILL_QTY) AS QTY
        FROM 
        TBL_TRN_PRPB01_MAT M LEFT JOIN TBL_TRN_PRPB01_HDR H ON M.PBID_REF=H.PBID
        LEFT JOIN TBL_MST_ITEM AS I WITH (NOLOCK) ON M.ITEMID_REF=I.ITEMID
        LEFT JOIN TBL_MST_BUSINESSUNIT AS B WITH (NOLOCK) ON I.BUID_REF=B.BUID
        
        WHERE H.CYID_REF=$CYID_REF
        AND H.BRID_REF=$BRID_REF
        AND H.FYID_REF=$FYID_REF
        AND H.STATUS='A'
        AND B.BUNAME IS NOT NULL
        GROUP BY B.BUNAME
        UNION 
        SELECT  B.BUNAME,SUM(M.BILL_QTY) AS QTY
        FROM 
        TBL_TRN_PII_MAT M LEFT JOIN TBL_TRN_PII_HDR H ON M.PII_ID_REF=H.PII_ID
        LEFT JOIN TBL_MST_ITEM AS I WITH (NOLOCK) ON M.ITEMID_REF=I.ITEMID
        LEFT JOIN TBL_MST_BUSINESSUNIT AS B WITH (NOLOCK) ON I.BUID_REF=B.BUID
        
        WHERE H.CYID_REF=$CYID_REF
        AND H.BRID_REF=$BRID_REF
        AND H.FYID_REF=$FYID_REF
        AND H.STATUS='A'
        AND B.BUNAME IS NOT NULL
        GROUP BY B.BUNAME
        UNION 
        SELECT  B.BUNAME,SUM(M.BILL_QTY) AS QTY
        FROM 
        TBL_TRN_PRPB02_SRV M LEFT JOIN TBL_TRN_PRPB02_HDR H ON M.SPIID_REF=H.SPIID
        LEFT JOIN TBL_MST_ITEM AS I WITH (NOLOCK) ON M.SRVID_REF=I.ITEMID
        LEFT JOIN TBL_MST_BUSINESSUNIT AS B WITH (NOLOCK) ON I.BUID_REF=B.BUID
        WHERE H.CYID_REF=$CYID_REF
        AND H.BRID_REF=$BRID_REF
        AND H.FYID_REF=$FYID_REF
        AND H.STATUS='A'
        AND B.BUNAME IS NOT NULL
        GROUP BY B.BUNAME
        ) as K
        GROUP BY K.BUNAME
        ORDER BY QTYS DESC");

       //dd($obj_TopPurchaseBU); 


        $obj_TopInventoryBU = DB::select("SELECT  TOP 10 BU.BUNAME,SUM(A.CURRENT_QTY) AS QTYS
                                        FROM TBL_MST_BATCH A (NOLOCK) INNER JOIN TBL_MST_STOCK_BATCH_HIS B (NOLOCK) 
                                        ON A.BATCHID = B.BATCHID_REF AND A.ITEMID_REF = B.ITEMID_REF AND A.UOMID_REF = B.UOMID_REF
                                        LEFT JOIN TBL_MST_ITEM AS I WITH (NOLOCK) ON A.ITEMID_REF=I.ITEMID
                                        LEFT JOIN TBL_MST_BUSINESSUNIT AS BU WITH (NOLOCK) ON I.BUID_REF=BU.BUID
                                        WHERE A.CYID_REF =$CYID_REF AND BU.BUNAME IS NOT NULL AND A.BRID_REF =$BRID_REF AND  A.STATUS='A'  
                                        AND A.FYID_REF =$FYID_REF AND B.DATE <= GETDATE() 
                                        GROUP BY BU.BUNAME
                                        ORDER BY QTYS DESC "  
                                    );

       //dd($obj_TopInventoryBU); 



        $topsales = DB::table('TBL_TRN_SLSI01_HDR')
        ->where('TBL_TRN_SLSI01_HDR.CYID_REF','=',$CYID_REF)
        ->where('TBL_TRN_SLSI01_HDR.BRID_REF','=',$BRID_REF)
        ->where('TBL_TRN_SLSI01_HDR.FYID_REF','=',$FYID_REF)
        ->where('TBL_TRN_SLSI01_HDR.STATUS','=','A') 
        ->whereMonth('SIDT', date('m'))
        ->whereYear('SIDT', date('Y'))
        ->leftJoin('TBL_TRN_SLSI01_MAT','TBL_TRN_SLSI01_MAT.SIID_REF','=','TBL_TRN_SLSI01_HDR.SIID')
        ->leftJoin('TBL_MST_ITEM','TBL_MST_ITEM.ITEMID','=','TBL_TRN_SLSI01_MAT.ITEMID_REF')        
        ->select('TBL_MST_ITEM.NAME',   DB::raw('SUM(TBL_TRN_SLSI01_MAT.SIMAIN_QTY) as Total_Sales'))
        ->groupBy('TBL_MST_ITEM.NAME')
        ->orderBy('Total_Sales','desc')
        ->limit(5)
        ->get()->toArray();


        

        //dd($topsales); 

      
        
        $item1=  (isset($topsales[0]->NAME) ? $topsales[0]->NAME : '');
        $item1amt=(isset($topsales[0]->NAME) ? $topsales[0]->Total_Sales : ''); 
       // dd($item1amt); 

        $item2=  (isset($topsales[1]->NAME) ? $topsales[1]->NAME : '');
        $item2amt=(isset($topsales[1]->NAME) ? $topsales[1]->Total_Sales : ''); 

        $item3=  (isset($topsales[2]->NAME) ? $topsales[2]->NAME : '');
        $item3amt=(isset($topsales[2]->NAME) ? $topsales[2]->Total_Sales : ''); 

        $item4=  (isset($topsales[3]->NAME) ? $topsales[3]->NAME : '');
        $item4amt=(isset($topsales[3]->NAME) ? $topsales[3]->Total_Sales : ''); 

        
        $item5=  (isset($topsales[4]->NAME) ? $topsales[4]->NAME : '');
        $item5amt=(isset($topsales[4]->NAME) ? $topsales[4]->Total_Sales : ''); 

        



        //To do list for Sales 

        
        $objFinalAppr = DB::select("select dbo.FN_APRL('38','$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
        $FANO = "APPROVAL".$objFinalAppr[0]->FA_NO;

        $objDataList	=	DB::select("select hdr.SOID,hdr.SONO,hdr.SODT,hdr.CUSTOMERPONO,hdr.OVFDT,hdr.OVTDT,hdr.INDATE,hdr.STATUS, sl.SLNAME,
                        case when a.ACTIONNAME = '$FANO' then 'Final Approved' 
                        else case when a.ACTIONNAME = 'ADD' then 'Added'  
                            when a.ACTIONNAME = 'EDIT' then 'Added'
                            when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                            when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                            when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                            when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                            when a.ACTIONNAME = ' ' then 'Final Approved'
                        when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                        end end as STATUS_DESC
                        from TBL_TRN_AUDITTRAIL a 
                        inner join TBL_TRN_SLSO01_HDR hdr
                        on a.VID = hdr.SOID 
                        and a.VTID_REF = hdr.VTID_REF 
                        and a.CYID_REF = hdr.CYID_REF 
                        and a.BRID_REF = hdr.BRID_REF
                        inner join TBL_MST_SUBLEDGER sl ON hdr.SLID_REF = sl.SGLID  
                        where a.VTID_REF = 38
                        and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF' AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'
                        and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                        ORDER BY hdr.SOID DESC ");
                        //dd($objDataList); 



// ======================================================SALES CHALLAN=====================================================================

                        $objFinalAppr_challan = DB::select("select dbo.FN_APRL('43','$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
                        $FANO_challan = "APPROVAL".$objFinalAppr_challan[0]->FA_NO;
                
                        $objDataList_challan	=	DB::select("select hdr.SCID,hdr.SCNO,hdr.SCDT,hdr.remarks,hdr.INDATE,
                                            hdr.STATUS, sl.SLNAME,
                                            case when a.ACTIONNAME = '$FANO_challan' then 'Final Approved' 
                                            else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                                when a.ACTIONNAME = 'EDIT' then 'Added'
                                                when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                                when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                                when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                                when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                                when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved'
                                            when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                            end end as STATUS_DESC
                                            from TBL_TRN_AUDITTRAIL a 
                                            inner join TBL_TRN_SLSC01_HDR hdr
                                            on a.VID = hdr.SCID 
                                            and a.VTID_REF = hdr.VTID_REF 
                                            and a.CYID_REF = hdr.CYID_REF 
                                            and a.BRID_REF = hdr.BRID_REF
                                            inner join TBL_MST_SUBLEDGER sl ON hdr.SLID_REF = sl.SGLID  
                                            where a.VTID_REF = 43
                                            and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF'  AND hdr.STATUS='N'
                                            and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                            ORDER BY hdr.SCID DESC ");
              //  dd($objDataList_challan); 

                       
// ======================================================SALES INVOICE=====================================================================

              $objFinalAppr_invoice = DB::select("select dbo.FN_APRL(44,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
              $FANO_invoice = "APPROVAL".$objFinalAppr_invoice[0]->FA_NO;
      
              $objDataList_sales_invoice	=	DB::select("select hdr.SIID,hdr.SINO,hdr.SIDT,hdr.INDATE,
                                  hdr.STATUS, sl.SLNAME,
                                  case when a.ACTIONNAME = '$FANO_invoice' then 'Final Approved' 
                                  else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                      when a.ACTIONNAME = 'EDIT' then 'Added'
                                      when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                      when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                      when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                      when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                      when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                  when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                  end end as STATUS_DESC
                                  from TBL_TRN_AUDITTRAIL a 
                                  inner join TBL_TRN_SLSI01_HDR hdr
                                  on a.VID = hdr.SIID 
                                  and a.VTID_REF = hdr.VTID_REF 
                                  and a.CYID_REF = hdr.CYID_REF 
                                  and a.BRID_REF = hdr.BRID_REF
                                  inner join TBL_MST_SUBLEDGER sl ON hdr.SLID_REF = sl.SGLID  
                                  where a.VTID_REF = 44
                                  and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'
                                  and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                  ORDER BY hdr.SIID DESC ");





// ========================================OPEN SALES ORDER====================================================================




$objFinalAppr_OSO = DB::select("select dbo.FN_APRL(40,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
$FANO_OSO = "APPROVAL".$objFinalAppr_OSO[0]->FA_NO;

$objDataList_OSO	=	DB::select("SELECT hdr.OSOID,hdr.OSONO,hdr.OSODT,hdr.OVFDT,hdr.OVTDT,
                    hdr.STATUS, sl.SLNAME,
                    case when a.ACTIONNAME = '$FANO_OSO' then 'Final Approved' 
                    else case when a.ACTIONNAME = 'ADD' then 'Added'  
                        when a.ACTIONNAME = 'EDIT' then 'Added'
                        when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                        when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                        when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                        when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                        when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                    when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                    end end as STATUS_DESC
                    from TBL_TRN_AUDITTRAIL a 
                    inner join TBL_TRN_SLSO03_HDR hdr
                    on a.VID = hdr.OSOID 
                    and a.VTID_REF = hdr.VTID_REF 
                    and a.CYID_REF = hdr.CYID_REF 
                    and a.BRID_REF = hdr.BRID_REF
                    inner join TBL_MST_SUBLEDGER sl ON hdr.SLID_REF = sl.SGLID  
                    where a.VTID_REF = 40
                    and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'
                    and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                    ORDER BY hdr.OSOID DESC");


//   DD($objDataList_OSO); 




// ====================================================== SALES RETURN=====================================================================


                    $objFinalAppr_SR = DB::select("select dbo.FN_APRL(45,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
                    $FANO_SR = "APPROVAL".$objFinalAppr_SR[0]->FA_NO;
            
                    $objDataList_SR	=	DB::select("SELECT hdr.SRID,hdr.SRNO,hdr.SRDT,hdr.INDATE,
                                        hdr.STATUS, sl.SLNAME,
                                        case when a.ACTIONNAME = '$FANO_SR' then 'Final Approved' 
                                        else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                            when a.ACTIONNAME = 'EDIT' then 'Added'
                                            when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                        when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                        end end as STATUS_DESC
                                        from TBL_TRN_AUDITTRAIL a 
                                        inner join TBL_TRN_SLSR01_HDR hdr
                                        on a.VID = hdr.SRID 
                                        and a.VTID_REF = hdr.VTID_REF 
                                        and a.CYID_REF = hdr.CYID_REF 
                                        and a.BRID_REF = hdr.BRID_REF
                                        inner join TBL_MST_SUBLEDGER sl ON hdr.SLID_REF = sl.SGLID  
                                        where a.VTID_REF =45
                                        and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'
                                        and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                        ORDER BY hdr.SRID DESC ");

                                      //  DD($objDataList_SR); 


        // ====================================================== SALES SERVICE ORDER=====================================================================
            

            $objFinalAppr_SSO = DB::select("select dbo.FN_APRL(151,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_SSO = "APPROVAL".$objFinalAppr_SSO[0]->FA_NO;
                                
            $objDataList_SSO	=	DB::select("SELECT hdr.SSOID,hdr.SSO_NO,hdr.SSO_DT,hdr.OVF_DT,hdr.OVT_DT,hdr.INDATE,
                                                            hdr.STATUS, sl.SLNAME,
                                                            case when a.ACTIONNAME = '$FANO_SSO' then 'Final Approved' 
                                                            else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                                                when a.ACTIONNAME = 'EDIT' then 'Added'
                                                                when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                                                when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                                                when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                                                when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                                                when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved'
                                                            when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                                            end end as STATUS_DESC
                                                            from TBL_TRN_AUDITTRAIL a 
                                                            inner join TBL_TRN_SLSO04_HDR hdr
                                                            on a.VID = hdr.SSOID 
                                                            and a.VTID_REF = hdr.VTID_REF 
                                                            and a.CYID_REF = hdr.CYID_REF 
                                                            and a.BRID_REF = hdr.BRID_REF
                                                            inner join TBL_MST_SUBLEDGER sl ON hdr.SLID_REF = sl.SGLID  
                                                            where a.VTID_REF = 151
                                                            and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'
                                                            and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                                            ORDER BY hdr.SSOID DESC ");
                                                           // DD($objDataList_SSO);



      // ====================================================== SALES SERVICE INVOICE=====================================================================


      $objFinalAppr_SSI = DB::select("select dbo.FN_APRL(252,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
      $FANO_SSI = "APPROVAL".$objFinalAppr_SSI[0]->FA_NO;

      $objDataList_SSI	=	DB::select("SELECT hdr.SSIID,hdr.SSI_NO,hdr.SSI_DT,hdr.DUE_DT,hdr.INDATE,
                          hdr.STATUS, sl.SLNAME,
                          case when a.ACTIONNAME = '$FANO_SSI' then 'Final Approved' 
                          else case when a.ACTIONNAME = 'ADD' then 'Added'  
                              when a.ACTIONNAME = 'EDIT' then 'Edited'
                              when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                              when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                              when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                              when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                              when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                          when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                          end end as STATUS_DESC
                          from TBL_TRN_AUDITTRAIL a 
                          inner join TBL_TRN_SLSI02_HDR hdr
                          on a.VID = hdr.SSIID 
                          and a.VTID_REF = hdr.VTID_REF 
                          and a.CYID_REF = hdr.CYID_REF 
                          and a.BRID_REF = hdr.BRID_REF
                          inner join TBL_MST_SUBLEDGER sl ON hdr.SGLID_REF = sl.SGLID  
                          where a.VTID_REF = 252
                          and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'
                          and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                          ORDER BY hdr.SSIID DESC ");

                       //   dd($objDataList_SSI); 

    // ====================================================== PURCHASE ORDER=====================================================================

                       $objFinalAppr_PO = DB::select("select dbo.FN_APRL(63,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
                       $FANO_PO = "APPROVAL".$objFinalAppr_PO[0]->FA_NO;
               
                       $objDataList_PO	=	DB::select("SELECT hdr.POID,hdr.PO_NO,hdr.PO_DT,hdr.PO_VRF,hdr.PO_VTO,hdr.INDATE,
                                           hdr.STATUS, sl.SLNAME,
                                           case when a.ACTIONNAME = '$FANO_PO' then 'Final Approved' 
                                           else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                               when a.ACTIONNAME = 'EDIT' then 'Added'
                                               when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                               when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                               when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                               when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                               when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved'
                                           when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                           end end as STATUS_DESC
                                           from TBL_TRN_AUDITTRAIL a 
                                           inner join TBL_TRN_PROR01_HDR hdr
                                           on a.VID = hdr.POID 
                                           and a.VTID_REF = hdr.VTID_REF 
                                           and a.CYID_REF = hdr.CYID_REF 
                                           and a.BRID_REF = hdr.BRID_REF
                                           inner join TBL_MST_SUBLEDGER sl ON hdr.VID_REF = sl.SGLID  
                                           where a.VTID_REF = 63
                                           and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'
                                           and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                           ORDER BY hdr.POID DESC ");

                                        //   DD($objDataList_PO); 
    // ====================================================== BLANKET PURCHASE ORDER=====================================================================


            $objFinalAppr_BPO = DB::select("select dbo.FN_APRL(67,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_BPO = "APPROVAL".$objFinalAppr_BPO[0]->FA_NO;
    
            $objDataList_BPO	=	DB::select("SELECT hdr.BPOID,hdr.BPO_NO,hdr.BPO_DT,hdr.INDATE,
                                                            hdr.STATUS, sl.SLNAME,
                                                            case when a.ACTIONNAME = '$FANO_BPO' then 'Final Approved' 
                                                            else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                                                when a.ACTIONNAME = 'EDIT' then 'Added'
                                                                when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                                                when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                                                when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                                                when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                                                when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                                            when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                                            end end as STATUS_DESC
                                                            from TBL_TRN_AUDITTRAIL a 
                                                            inner join TBL_TRN_PROR03_HDR hdr
                                                            on a.VID = hdr.BPOID 
                                                            and a.VTID_REF = hdr.VTID_REF 
                                                            and a.CYID_REF = hdr.CYID_REF 
                                                            and a.BRID_REF = hdr.BRID_REF
                                                            inner join TBL_MST_SUBLEDGER sl ON hdr.VID_REF = sl.SGLID  
                                                            where a.VTID_REF = 67
                                                            and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'
                                                            and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                                            ORDER BY hdr.BPOID DESC ");

    // ====================================================== SERVICE PURCHASE ORDER=====================================================================

    $objFinalAppr_SPO = DB::select("select dbo.FN_APRL(69,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
    $FANO_SPO = "APPROVAL".$objFinalAppr_SPO[0]->FA_NO;

    $objDataList_SPO	=	DB::select("SELECT hdr.SPOID,hdr.SPO_NO,hdr.SPO_DT,hdr.VALID_FR,hdr.VALID_TO,hdr.REMARKS,hdr.INDATE,
                        hdr.STATUS, sl.SLNAME,
                        case when a.ACTIONNAME = '$FANO_SPO' then 'Final Approved' 
                        else case when a.ACTIONNAME = 'ADD' then 'Added'  
                            when a.ACTIONNAME = 'EDIT' then 'Added'
                            when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                            when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                            when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                            when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                            when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                        when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                        end end as STATUS_DESC
                        from TBL_TRN_AUDITTRAIL a 
                        inner join TBL_TRN_PROR04_HDR hdr
                        on a.VID = hdr.SPOID 
                        and a.VTID_REF = hdr.VTID_REF 
                        and a.CYID_REF = hdr.CYID_REF 
                        and a.BRID_REF = hdr.BRID_REF
                        inner join TBL_MST_SUBLEDGER sl ON hdr.VID_REF = sl.SGLID  
                        where a.VTID_REF = 69
                        and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'
                        and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                        ORDER BY hdr.SPOID DESC ");


    // ====================================================== PURCHASE INDENT ORDER=====================================================================

        $objFinalAppr_PI = DB::select("select dbo.FN_APRL(59,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
        $FANO_PI = "APPROVAL".$objFinalAppr_PI[0]->FA_NO;

        $objDataList_PI	=	DB::select("SELECT hdr.PIID,hdr.PI_NO,hdr.PI_DT,hdr.remarks,hdr.INDATE,
                            hdr.STATUS,
                            case when a.ACTIONNAME = '$FANO_PI' then 'Final Approved' 
                            else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                when a.ACTIONNAME = 'EDIT' then 'Added'
                                when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved'
                            when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                            end end as STATUS_DESC
                            from TBL_TRN_AUDITTRAIL a 
                            inner join TBL_TRN_PRIN02_HDR hdr
                            on a.VID = hdr.PIID 
                            and a.VTID_REF = hdr.VTID_REF 
                            and a.CYID_REF = hdr.CYID_REF 
                            and a.BRID_REF = hdr.BRID_REF
                            where a.VTID_REF = 59
                            and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'
                            and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                            ORDER BY hdr.PIID DESC ");


    // ====================================================== SPI=====================================================================

        $objFinalAppr_SPI = DB::select("select dbo.FN_APRL(201,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
        $FANO_SPI = "APPROVAL".$objFinalAppr_SPI[0]->FA_NO;

        $objDataList_SPI	=	DB::select("SELECT hdr.SPIID,hdr.SPI_NO,hdr.SPI_DT,hdr.REMARKS,hdr.INDATE,
                                                hdr.STATUS, sl.SLNAME,
                                                case when a.ACTIONNAME = '$FANO_SPI' then 'Final Approved' 
                                                else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                                    when a.ACTIONNAME = 'EDIT' then 'Added'
                                                    when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                                    when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                                    when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                                    when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                                    when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved'
                                                when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                                end end as STATUS_DESC
                                                from TBL_TRN_AUDITTRAIL a 
                                                inner join TBL_TRN_PRPB02_HDR hdr
                                                on a.VID = hdr.SPIID 
                                                and a.VTID_REF = hdr.VTID_REF 
                                                and a.CYID_REF = hdr.CYID_REF 
                                                and a.BRID_REF = hdr.BRID_REF
                                                inner join TBL_MST_SUBLEDGER sl ON hdr.VID_REF = sl.SGLID  
                                                where a.VTID_REF = 201
                                                and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF'  AND hdr.STATUS='N'
                                                and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                                ORDER BY hdr.SPIID DESC ");

 // ====================================================== PURCHASE RETURN=====================================================================


            $objFinalAppr_PR = DB::select("select dbo.FN_APRL(95,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_PR = "APPROVAL".$objFinalAppr_PR[0]->FA_NO;
    
            $objDataList_PR	=	DB::select("SELECT hdr.PRRID,hdr.PRR_NO,hdr.PRR_DT,hdr.VCL_NO,hdr.DRIVER_NAME,hdr.INDATE,
                                        hdr.STATUS, sl.SLNAME,
                                        case when a.ACTIONNAME = '$FANO_PR' then 'Final Approved' 
                                        else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                            when a.ACTIONNAME = 'EDIT' then 'Edited'
                                            when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved'
                                        when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                        end end as STATUS_DESC
                                        from TBL_TRN_AUDITTRAIL a 
                                        inner join TBL_TRN_PRRT01_HDR hdr
                                        on a.VID = hdr.PRRID 
                                        and a.VTID_REF = hdr.VTID_REF 
                                        and a.CYID_REF = hdr.CYID_REF 
                                        and a.BRID_REF = hdr.BRID_REF
                                        inner join TBL_MST_SUBLEDGER sl ON hdr.VID_REF = sl.SGLID  
                                        where a.VTID_REF = 95
                                        and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF'  AND hdr.STATUS='N'
                                        and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                        ORDER BY hdr.PRRID DESC ");


 // ====================================================== IPO=====================================================================


            $objFinalAppr_IPO = DB::select("select dbo.FN_APRL(167,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_IPO = "APPROVAL".$objFinalAppr_IPO[0]->FA_NO;
    
            $objDataList_IPO	=	DB::select("SELECT hdr.IPO_ID,hdr.IPO_NO,hdr.IPO_DT,hdr.INDATE,
                                        hdr.STATUS, sl.SLNAME,
                                        case when a.ACTIONNAME = '$FANO_IPO' then 'Final Approved' 
                                        else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                            when a.ACTIONNAME = 'EDIT' then 'Added'
                                            when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved'
                                        when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                        end end as STATUS_DESC
                                        from TBL_TRN_AUDITTRAIL a 
                                        inner join TBL_TRN_IPO_HDR hdr
                                        on a.VID = hdr.IPO_ID 
                                        and a.VTID_REF = hdr.VTID_REF 
                                        and a.CYID_REF = hdr.CYID_REF 
                                        and a.BRID_REF = hdr.BRID_REF
                                        inner join TBL_MST_SUBLEDGER sl ON hdr.VID_REF = sl.SGLID  
                                        where a.VTID_REF = 167
                                        and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF'  AND hdr.STATUS='N'
                                        and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                        ORDER BY hdr.IPO_ID DESC ");

                                       // dd($objDataList_IPO); 




 // ====================================================== PII=====================================================================


            $objFinalAppr_PII = DB::select("select dbo.FN_APRL(390,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_PII = "APPROVAL".$objFinalAppr_PII[0]->FA_NO;
    
            $objDataList_PII	=	DB::select("SELECT hdr.PII_ID,hdr.PII_NO,hdr.PII_DT,hdr.INDATE,
                                        hdr.STATUS, sl.SLNAME,
                                        case when a.ACTIONNAME = '$FANO_PII' then 'Final Approved' 
                                        else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                            when a.ACTIONNAME = 'EDIT' then 'Added'
                                            when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                            when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved'
                                        when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                        end end as STATUS_DESC
                                        from TBL_TRN_AUDITTRAIL a 
                                        inner join TBL_TRN_PII_HDR hdr
                                        on a.VID = hdr.PII_ID 
                                        and a.VTID_REF = hdr.VTID_REF 
                                        and a.CYID_REF = hdr.CYID_REF 
                                        and a.BRID_REF = hdr.BRID_REF
                                        inner join TBL_MST_SUBLEDGER sl ON hdr.VID_REF = sl.SGLID  
                                        where a.VTID_REF = 390 
                                        and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'  
                                        and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                        ORDER BY hdr.PII_ID DESC ");

                  //  dd($objDataList_PII); 


 // ====================================================== MRS=====================================================================


                  $objFinalAppr_MRS = DB::select("select dbo.FN_APRL(88,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
                  $FANO_MRS = "APPROVAL".$objFinalAppr_MRS[0]->FA_NO;
          
                  $objDataList_MRS	=	DB::select("SELECT hdr.MRSID,hdr.MRS_NO,hdr.MRS_DT,hdr.REMARKS,hdr.INDATE,
                                      hdr.STATUS,
                                      case when a.ACTIONNAME = '$FANO_MRS' then 'Final Approved' 
                                      else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                          when a.ACTIONNAME = 'EDIT' then 'Added'
                                          when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                          when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                          when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                          when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                          when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                      when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                      end end as STATUS_DESC
                                      from TBL_TRN_AUDITTRAIL a 
                                      inner join TBL_TRN_MRQS01_HDR hdr
                                      on a.VID = hdr.MRSID 
                                      and a.VTID_REF = hdr.VTID_REF 
                                      and a.CYID_REF = hdr.CYID_REF 
                                      and a.BRID_REF = hdr.BRID_REF 
                                      where a.VTID_REF = 88
                                      and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'  
                                      and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                      ORDER BY hdr.MRSID DESC ");

                                  //  dd($objDataList_MRS); 


 // ====================================================== MRS=====================================================================


            $objFinalAppr_GE = DB::select("select dbo.FN_APRL(92,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_GE = "APPROVAL".$objFinalAppr_GE[0]->FA_NO;
    
            $objDataList_GE	=	DB::select("SELECT hdr.GEID,hdr.GE_NO,hdr.GE_DT,hdr.INDATE,
                                                      hdr.STATUS, sl.SLNAME,
                                                      case when a.ACTIONNAME = '$FANO_GE' then 'Final Approved' 
                                                      else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                                          when a.ACTIONNAME = 'EDIT' then 'Edited'
                                                          when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                                      when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                                      end end as STATUS_DESC
                                                      from TBL_TRN_AUDITTRAIL a 
                                                      inner join TBL_TRN_IMGE01_HDR hdr
                                                      on a.VID = hdr.GEID 
                                                      and a.VTID_REF = hdr.VTID_REF 
                                                      and a.CYID_REF = hdr.CYID_REF 
                                                      and a.BRID_REF = hdr.BRID_REF
                                                      inner join TBL_MST_SUBLEDGER sl ON hdr.VID_REF = sl.SGLID  
                                                      where a.VTID_REF = 92
                                                      and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'  
                                                      and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                                      ORDER BY hdr.GEID DESC ");
              //     dd($objDataList_GE); 
                         
 // ====================================================== TODAY'S CALL =====================================================================


            $objFinalAppr_TDCALL = DB::select("select dbo.FN_APRL(439,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_TDCALL = "APPROVAL".$objFinalAppr_TDCALL[0]->FA_NO;

            $objDataList_TDCALL	=	DB::select("SELECT hdr.LEAD_ID,hdr.LEAD_NO,hdr.LEAD_DT,hdr.COMPANY_NAME,hdr.LEAD_DETAILS,hdr.CONTACT_PERSON,hdr.LANDLINE_NUMBER,
                                                        hdr.MOBILE_NUMBER,hdr.EMAIL,lt.DUE_DATE,lt.TASK_REMINDER_DATE,lt.TASK_ID,hdr.INDATE,hdr.STATUS,

                                case when a.ACTIONNAME = '$FANO_TDCALL' then 'Final Approved' 
                                else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                    when a.ACTIONNAME = 'EDIT' then 'Added'
                                    when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                    when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                    when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                    when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                    when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                end end as STATUS_DESC
                                from TBL_TRN_AUDITTRAIL a 
                                inner join TBL_TRN_LEAD_GENERATION hdr
                                left join TBL_TRN_LEAD_TASK lt ON hdr.LEAD_ID = lt.LEADID_REF 
                                on a.VID = hdr.LEAD_ID 
                                and a.VTID_REF = hdr.VTID_REF 
                                and a.CYID_REF = hdr.CYID_REF 
                                and a.BRID_REF = hdr.BRID_REF 
                                where a.VTID_REF = 509
                                and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'  
                                and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                ORDER BY hdr.LEAD_ID DESC ");

                              //dd($objDataList_TDCALL); 


    // ====================================================== GRN AGAINST GE=====================================================================
        
              $objFinalAppr_GRN = DB::select("select dbo.FN_APRL(94,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
              $FANO_GRN = "APPROVAL".$objFinalAppr_GRN[0]->FA_NO;
      
              $objDataList_GRN	=	DB::select("SELECT hdr.GRNID,hdr.GRN_NO,hdr.GRN_DT,hdr.INDATE,
                                  hdr.STATUS, sl.SLNAME,
                                  case when a.ACTIONNAME = '$FANO_GRN' then 'Final Approved' 
                                  else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                      when a.ACTIONNAME = 'EDIT' then 'Edited'
                                      when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                      when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                      when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                      when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                      when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                  when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                  end end as STATUS_DESC
                                  from TBL_TRN_AUDITTRAIL a 
                                  inner join TBL_TRN_IGRN02_HDR hdr
                                  on a.VID = hdr.GRNID 
                                  and a.VTID_REF = hdr.VTID_REF 
                                  and a.CYID_REF = hdr.CYID_REF 
                                  and a.BRID_REF = hdr.BRID_REF
                                  inner join TBL_MST_SUBLEDGER sl ON hdr.VID_REF = sl.SGLID  
                                  where a.VTID_REF = 94
                                  and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'  
                                  and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                  ORDER BY hdr.GRNID DESC ");

                                  //dd($objDataList_GRN); 

 // ======================================================JV=====================================================================


            $objFinalAppr_JV = DB::select("select dbo.FN_APRL(165,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_JV = "APPROVAL".$objFinalAppr_JV[0]->FA_NO;
                          
            $objDataList_JV	=	DB::select("SELECT hdr.JVID,hdr.JV_NO,hdr.JV_DT,hdr.REVERSE_DT,hdr.SOURCE_DOCNO,hdr.SOURCE_DOCDT,hdr.INDATE,
                                                      hdr.STATUS,
                                                      case when a.ACTIONNAME = '$FANO_JV' then 'Final Approved' 
                                                      else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                                          when a.ACTIONNAME = 'EDIT' then 'Edited'
                                                          when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                                      when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                                      end end as STATUS_DESC
                                                      from TBL_TRN_AUDITTRAIL a 
                                                      right join TBL_TRN_FJRV01_HDR hdr
                                                      on a.VID = hdr.JVID 
                                                      and a.VTID_REF = hdr.VTID_REF
                                                      and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)							 
                                                      where hdr.CYID_REF = $CYID_REF
                                                      and hdr.BRID_REF = $BRID_REF  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'  
                                                      ORDER BY hdr.JVID DESC ");
                                //dd($objDataList_JV);


 // ======================================================AR DEBIT CREDIT NOTE=====================================================================


            $objFinalAppr_AR = DB::select("select dbo.FN_APRL(223,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_AR = "APPROVAL".$objFinalAppr_AR[0]->FA_NO;
                          
            $objDataList_AR	=	DB::select("SELECT hdr.ARDRCRID,hdr.AR_DOC_NO,hdr.AR_DOC_DT,hdr.INDATE,
                                                      hdr.STATUS,
                                                      case when a.ACTIONNAME = '$FANO_AR' then 'Final Approved' 
                                                      else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                                          when a.ACTIONNAME = 'EDIT' then 'Added'
                                                          when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                                      when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                                      end end as STATUS_DESC
                                                      from TBL_TRN_AUDITTRAIL a 
                                                      right join TBL_TRN_FNARDRCR_HDR hdr
                                                      on a.VID = hdr.ARDRCRID 
                                                      and a.VTID_REF = hdr.VTID_REF
                                                      and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)							 
                                                      where hdr.CYID_REF = $CYID_REF
                                                      and hdr.BRID_REF = $BRID_REF  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'  
                                                      ORDER BY hdr.ARDRCRID DESC ");
                                                      
                                //dd($objDataList_AR);

 // ======================================================AP DEBIT CREDIT NOTE=====================================================================


            $objFinalAppr_AP = DB::select("select dbo.FN_APRL(225,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_AP = "APPROVAL".$objFinalAppr_AP[0]->FA_NO;
                          
            $objDataList_AP	=	DB::select("SELECT hdr.APDRCRID,hdr.AP_DOC_NO,hdr.AP_DOC_DT,hdr.INDATE,
                                                      hdr.STATUS,
                                                      case when a.ACTIONNAME = '$FANO_AP' then 'Final Approved' 
                                                      else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                                          when a.ACTIONNAME = 'EDIT' then 'Added'
                                                          when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                                      when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                                      end end as STATUS_DESC
                                                      from TBL_TRN_AUDITTRAIL a 
                                                      right join TBL_TRN_FNAPDRCR_HDR hdr
                                                      on a.VID = hdr.APDRCRID 
                                                      and a.VTID_REF = hdr.VTID_REF
                                                      and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)							 
                                                      where hdr.CYID_REF = $CYID_REF
                                                      and hdr.BRID_REF = $BRID_REF  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'  
                                                      ORDER BY hdr.APDRCRID DESC ");
                                                      
                              //  dd($objDataList_AP);


 // ======================================================PAYMENT ENTRY=====================================================================


            $objFinalAppr_PAYMENT = DB::select("select dbo.FN_APRL(391,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
            $FANO_PAYMENT = "APPROVAL".$objFinalAppr_PAYMENT[0]->FA_NO;
                          
            $objDataList_PAYMENT	=	DB::select("SELECT hdr.PAYMENTID,hdr.PAYMENT_NO,hdr.PAYMENT_DT,hdr.INDATE,
                                                      hdr.STATUS,
                                                      case when a.ACTIONNAME = '$FANO_PAYMENT' then 'Final Approved' 
                                                      else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                                          when a.ACTIONNAME = 'EDIT' then 'Added'
                                                          when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                                          when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                                      when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                                      end end as STATUS_DESC
                                                      from TBL_TRN_AUDITTRAIL a 
                                                      right join TBL_TRN_PAYMENT_HDR hdr
                                                      on a.VID = hdr.PAYMENTID 
                                                      and a.VTID_REF = hdr.VTID_REF
                                                      and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)							 
                                                      where hdr.CYID_REF = $CYID_REF
                                                      and hdr.BRID_REF = $BRID_REF  AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'  
                                                      ORDER BY hdr.PAYMENTID DESC ");
                                                      
// dd($objDataList_PAYMENT);


 // ======================================================RECEIPT ENTRY=====================================================================


        $objFinalAppr_RECEIPT = DB::select("select dbo.FN_APRL(392,'$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
        $FANO_RECEIPT = "APPROVAL".$objFinalAppr_RECEIPT[0]->FA_NO;

        $objDataList_RECEIPT	=	DB::select("SELECT hdr.RECEIPTID,hdr.RECEIPT_NO,hdr.RECEIPT_DT,hdr.RECEIPT_FOR,hdr.RECEIPT_TYPE,hdr.NARRATION,hdr.INDATE,
                                                hdr.STATUS, sl.SLNAME,
                                                case when a.ACTIONNAME = '$FANO_RECEIPT' then 'Final Approved' 
                                                else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                                    when a.ACTIONNAME = 'EDIT' then 'Edited'
                                                    when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                                    when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                                    when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                                    when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                                    when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                                                when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                                                end end as STATUS_DESC
                                                from TBL_TRN_AUDITTRAIL a 
                                                inner join TBL_TRN_RECEIPT_HDR hdr
                                                on a.VID = hdr.RECEIPTID 
                                                and a.VTID_REF = hdr.VTID_REF 
                                                and a.CYID_REF = hdr.CYID_REF 
                                                and a.BRID_REF = hdr.BRID_REF
                                                left join TBL_MST_SUBLEDGER sl ON hdr.CUSTMER_VENDOR_ID = sl.SGLID  
                                                where a.VTID_REF = 392
                                                and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF' AND hdr.FYID_REF='$FYID_REF' AND hdr.STATUS='N'  
                                                and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                                                ORDER BY hdr.RECEIPTID DESC ");
                                              //  DD($objDataList_RECEIPT); 
        //Right for Sales Module
        $right_objDataList=$this->menu_right(38); 
        $right_objDataList_challan=$this->menu_right(43); 
        $right_objDataList_sales_invoice=$this->menu_right(44); 
        $right_objDataList_OSO=$this->menu_right(40); 
        $right_objDataList_SR=$this->menu_right(45); 
        $right_objDataList_SSO=$this->menu_right(151); 
        $right_objDataList_SSI=$this->menu_right(252); 

        //Right for Purchase Module
        $right_objDataList_PO=$this->menu_right(63); 
        $right_objDataList_BPO=$this->menu_right(67); 
        $right_objDataList_SPO=$this->menu_right(69); 
        $right_objDataList_PI=$this->menu_right(59); 
        $right_objDataList_SPI=$this->menu_right(201); 
        $right_objDataList_PR=$this->menu_right(95); 
        $right_objDataList_IPO=$this->menu_right(167); 
        $right_objDataList_PII=$this->menu_right(390); 


        //Right for Inventory Module
        $right_objDataList_MRS=$this->menu_right(88); 
        $right_objDataList_GE=$this->menu_right(92); 
        $right_objDataList_GRN=$this->menu_right(94); 

        
        //Right for Finance Module
        $right_objDataList_JV=$this->menu_right(165); 
        $right_objDataList_AR=$this->menu_right(223); 
        $right_objDataList_AP=$this->menu_right(225); 
        $right_objDataList_PAYMENT=$this->menu_right(391); 
        $right_objDataList_RECEIPT=$this->menu_right(392); 

        $right_objDataList_TDCALL=$this->menu_right(558);                          
        $company_check=$this->AlpsStatus();
        //dd($company_check); 


      //  dd($right_receipt); 
                                                            

        return view('home',compact(['objDataList_RECEIPT','objDataList_PAYMENT','objDataList_AP','objDataList_AR','objDataList_JV','objDataList_GRN',
		'objDataList_GE','objDataList_MRS','objDataList_MRS','objDataList_TDCALL','objDataList_PII','objDataList_IPO','objDataList_PR','objDataList_SPI','objDataList_PI',
		'objDataList_SPO','objDataList_BPO','objDataList_PO','objDataList_SSI','objDataList_SSO','objDataList_SR','objDataList_OSO','objDataList_sales_invoice',
		'objDataList_challan','objDataList','topsales','apr','may','june','july','aug','sep','oct','nov','dec','jan','feb','mar',
        'year','apr_purchase','may_purchase','june_purchase','july_purchase','aug_purchase','sep_purchase','oct_purchase','nov_purchase',
        'dec_purchase','jan_purchase','feb_purchase','mar_purchase','item1','item2','item3','item4','item5','item1amt','item2amt','item3amt','item4amt',
		'item5amt','objSO','objPO','right_objDataList','right_objDataList_challan','right_objDataList_sales_invoice','right_objDataList_OSO',
		'right_objDataList_SR','right_objDataList_SSO','right_objDataList_SSI','right_objDataList_PO','right_objDataList_BPO','right_objDataList_SPO',
		'right_objDataList_PI','right_objDataList_SPI','right_objDataList_PR','right_objDataList_IPO','right_objDataList_PII','right_objDataList_MRS','right_objDataList_TDCALL',
		'right_objDataList_GE','right_objDataList_GRN','right_objDataList_JV','right_objDataList_AR','right_objDataList_AP','right_objDataList_PAYMENT',
		'right_objDataList_RECEIPT','obj_TopSalesBU','obj_TopPurchaseBU','obj_TopInventoryBU','company_check']));
    }

    public function AlpsStatus(){

         // $COMPANY_NAME ="ALPS India Pvt Ltd";
         $COMPANY_NAME   =   DB::table('TBL_MST_COMPANY')->where('STATUS','=','A')->where('CYID','=',Auth::user()->CYID_REF)->select('TBL_MST_COMPANY.NAME')->first()->NAME;    
           
           $hidden         =   strpos($COMPANY_NAME,"ALPS")!== false?'':'hidden';         
          return  $hidden;
      
      }

    public function menu_right($VTID_REF){
        $db_menu = DB::select('select * from VW_MENU  where userid_ref is not null AND VT_SEQUENCE is not null 
        AND userid_ref=?  AND cyid_ref = ?   AND brid_ref = ?  AND vtid_ref = ?     order by MODULE_SEQUENCE ASC,VT_SEQUENCE ASC, ranks ASC ', 
        [Auth::user()->USERID, Auth::user()->CYID_REF, Session::get('BRID_REF'),$VTID_REF]);
        return $db_menu; 

    }

    public function check_approval_level(Request $request){

        $REQUEST_DATA   =   $request['REQUEST_DATA'];
        $RECORD_ID      =   $request['RECORD_ID'];
        $result         =   Helper::check_approval_level($REQUEST_DATA,$RECORD_ID);

        echo $result;
        exit();

    }

}
