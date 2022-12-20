<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Admin\TblMstUser;
use Auth;
use DB;
use Session;
use Response;
use SimpleXMLElement;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Chartblocks;

class RptFrm283Controller extends Controller
{
    protected $form_id = 283;
    protected $vtid_ref   = 373;  //voucher type id
    // //validation messages
    // 
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
        $objRights = DB::table('TBL_MST_USERROLMAP')
                        ->where('TBL_MST_USERROLMAP.USERID_REF','=',Auth::user()->USERID)
                        ->where('TBL_MST_USERROLMAP.CYID_REF','=',Auth::user()->CYID_REF)
                        ->where('TBL_MST_USERROLMAP.BRID_REF','=',Auth::user()->BRID_REF)
                        ->where('TBL_MST_USERROLMAP.FYID_REF','=',Auth::user()->FYID_REF)
                        ->leftJoin('TBL_MST_ROLEDETAILS', 'TBL_MST_USERROLMAP.ROLLID_REF','=','TBL_MST_ROLEDETAILS.ROLLID_REF')
                        ->where('TBL_MST_ROLEDETAILS.VTID_REF','=',$this->vtid_ref)
                        ->select('TBL_MST_USERROLMAP.*', 'TBL_MST_ROLEDETAILS.*')
                        ->first();
        $objBranchGroup = DB::table('TBL_MST_BRANCH_GROUP')
        ->where('TBL_MST_BRANCH_GROUP.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_BRANCH_GROUP.STATUS','=','A')
        ->leftJoin('TBL_MST_BRANCH', 'TBL_MST_BRANCH_GROUP.BRID_REF','=','TBL_MST_BRANCH.BRID')
        ->leftJoin('TBL_MST_USER_BRANCH_MAP', 'TBL_MST_BRANCH.BRID','=','TBL_MST_USER_BRANCH_MAP.MAPBRID_REF')
        ->where('TBL_MST_USER_BRANCH_MAP.USERID_REF','=',Auth::user()->USERID)
        ->select('TBL_MST_BRANCH_GROUP.*')
        ->distinct('TBL_MST_BRANCH_GROUP.BGID')
        ->get();
        $objBranch = DB::table('TBL_MST_BRANCH')
        ->where('TBL_MST_BRANCH.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_BRANCH.STATUS','=','A')
        ->leftJoin('TBL_MST_USER_BRANCH_MAP', 'TBL_MST_BRANCH.BRID','=','TBL_MST_USER_BRANCH_MAP.MAPBRID_REF')
        ->where('TBL_MST_USER_BRANCH_MAP.USERID_REF','=',Auth::user()->USERID)
        ->select('TBL_MST_BRANCH.*')
        ->distinct('TBL_MST_BRANCH.BRID')   
        ->get(); 
        $ObjVendor = DB::table('TBL_TRN_PRPB01_HDR')
        ->leftJoin('TBL_MST_SUBLEDGER', 'TBL_MST_SUBLEDGER.SGLID','=','TBL_TRN_PRPB01_HDR.VID_REF')
        ->where('TBL_TRN_PRPB01_HDR.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_TRN_PRPB01_HDR.BRID_REF','=',Auth::user()->BRID_REF)
        ->where('TBL_TRN_PRPB01_HDR.STATUS','=','A')
        ->select('TBL_MST_SUBLEDGER.SGLID','TBL_MST_SUBLEDGER.SGLCODE','TBL_MST_SUBLEDGER.SLNAME')
        ->distinct('TBL_MST_SUBLEDGER.SGLID')
        ->get();
        $ObjItemGrp = DB::table('TBL_MST_ITEMGROUP')
        ->where('TBL_MST_ITEMGROUP.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_ITEMGROUP.BRID_REF','=',Auth::user()->BRID_REF)
        ->where('TBL_MST_ITEMGROUP.STATUS','=','A')
        ->select('TBL_MST_ITEMGROUP.ITEMGID','TBL_MST_ITEMGROUP.GROUPNAME')
        ->distinct('TBL_MST_ITEMGROUP.ITEMGID')
        ->get();
        $ObjItem = DB::table('TBL_TRN_PRPB01_HDR')
        ->leftJoin('TBL_TRN_PRPB01_MAT', 'TBL_TRN_PRPB01_MAT.PBID_REF','=','TBL_TRN_PRPB01_HDR.PBID')
        ->leftJoin('TBL_MST_ITEM', 'TBL_MST_ITEM.ITEMID','=','TBL_TRN_PRPB01_MAT.ITEMID_REF')
        ->where('TBL_TRN_PRPB01_HDR.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_TRN_PRPB01_HDR.BRID_REF','=',Auth::user()->BRID_REF)
        ->where('TBL_TRN_PRPB01_HDR.STATUS','=','A')
        ->select('TBL_MST_ITEM.ITEMID','TBL_MST_ITEM.NAME')
        ->distinct('TBL_MST_ITEM.ITEMID')
        ->get();

        return view('reports.purchase.SPORpt.rptfrm283',compact(['objRights','objBranchGroup','objBranch','ObjVendor',
                    'ObjItemGrp','ObjItem']));        
    }  

    
   public function ViewReport($request) {

    $box = $request;        
    $myValue=  array();
    parse_str($box, $myValue);
    
    if($myValue['Flag'] == 'H')
    {
        $SGLID           = $myValue['SGLID'];
        $From_Date       = $myValue['From_Date'];
        $To_Date         = $myValue['To_Date'];
        $BranchGroup     = $myValue['BranchGroup'];
        $BranchName      = $myValue['BranchName'];
        $ITEMGID         = $myValue['ITEMGID'];
        $ITEMID          = $myValue['ITEMID'];
        $GroupBy         = $myValue['GroupBy'];
        $OrderBy         = $myValue['OrderBy'];
        $ReportType      = $myValue['ReportType'];
        $Flag            = $myValue['Flag'];
    }
    else
    {
        $SGLID           = Session::get('SGLID');
        $From_Date       = Session::get('From_Date');
        $To_Date         = Session::get('To_Date');
        $BranchGroup     = Session::get('BranchGroup');
        $BranchName      = Session::get('BranchName');
        $ITEMGID         = Session::get('ITEMGID');
        $ITEMID          = Session::get('ITEMID');
        $GroupBy         = Session::get('GroupBy');
        $OrderBy         = Session::get('OrderBy');
        $ReportType      = Session::get('ReportType');
        $Flag            = $myValue['Flag'];
    }   
        
        $ssrs = new \SSRS\Report('http://103.35.123.42:8181//ReportServer/', array('username' => 'Administrator', 'password' => 'fSE7+Dagv-g^RU'));

        if($ReportType == "Detail")
        {
            $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/SPO_DETAIL');
        }
        else
        {
            $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/SPO_SUMMARY');
        }
        
        $reportParameters = array(
            'CYID'                      => Auth::user()->CYID_REF,
            'UID'                    	=> Auth::user()->USERID,
            'FROMDATE'                  => $From_Date,
            'TODATE'                    => $To_Date,
            'BGID'               		=> $BranchGroup,
            'BRID'                      => $BranchName,
            'VENDOR'                    => $SGLID,
            'ITEMGROUP'                 => $ITEMGID,
            'ITEM'                      => $ITEMID,
            'GROUPBY'                   => $GroupBy,
            'ORDERBY'                   => $OrderBy,            
        );
       
        $parameters = new \SSRS\Object\ExecutionParameters($reportParameters);
        
        $ssrs->setSessionId($result->executionInfo->ExecutionID)
            ->setExecutionParameters($parameters);

            if($Flag == 'H')
            {
                Session::put('SGLID', $SGLID);
                Session::put('From_Date', $From_Date);
                Session::put('To_Date', $To_Date);
                Session::put('BranchGroup', $BranchGroup);
                Session::put('BranchName', $BranchName);
                Session::put('ITEMGID', $ITEMGID);
                Session::put('ITEMID', $ITEMID);
                Session::put('GroupBy', $GroupBy);
                Session::put('OrderBy', $OrderBy);
                Session::put('ReportType', $ReportType);
                $output = $ssrs->render('HTML4.0'); // PDF | XML | CSV
                echo $output;
            }
            else if($Flag == 'P')
            {
                $output = $ssrs->render('PDF'); // PDF | XML | CSV | HTML4.0
                return $output->download('Report.pdf');
            }
            else if($Flag == 'E')
            {
                $output = $ssrs->render('EXCEL'); // PDF | XML | CSV | HTML4.0
                return $output->download('Report.xls');
            }
         
     }

    
}
