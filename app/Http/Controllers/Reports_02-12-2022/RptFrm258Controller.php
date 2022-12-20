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

class RptFrm258Controller extends Controller
{
    protected $form_id = 258;
    protected $vtid_ref   = 348;  //voucher type id
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
        ->leftJoin('TBL_MST_USER_BRANCH_MAP', 'TBL_MST_USERROLMAP.USERID_REF','=','TBL_MST_USER_BRANCH_MAP.USERID_REF')
                        ->where('TBL_MST_USERROLMAP.USERID_REF','=',Auth::user()->USERID)
                        ->where('TBL_MST_USERROLMAP.CYID_REF','=',Auth::user()->CYID_REF)
                        ->where('TBL_MST_USER_BRANCH_MAP.MAPBRID_REF','=',Session::get('BRID_REF'))
                        //->where('TBL_MST_USERROLMAP.FYID_REF','=',Auth::user()->FYID_REF)
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
        $ObjCustomer = DB::table('TBL_TRN_SLSC01_HDR')
        ->leftJoin('TBL_MST_SUBLEDGER', 'TBL_MST_SUBLEDGER.SGLID','=','TBL_TRN_SLSC01_HDR.SLID_REF')
        ->where('TBL_TRN_SLSC01_HDR.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_TRN_SLSC01_HDR.BRID_REF','=',Session::get('BRID_REF'))
        ->select('TBL_MST_SUBLEDGER.SGLID','TBL_MST_SUBLEDGER.SGLCODE','TBL_MST_SUBLEDGER.SLNAME')
        ->distinct('TBL_MST_SUBLEDGER.SGLID')
        ->get();     
        
        $ObjSCNO = DB::table('TBL_TRN_SLSC01_HDR')
        ->where('TBL_TRN_SLSC01_HDR.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_TRN_SLSC01_HDR.BRID_REF','=',Session::get('BRID_REF'))
        ->select('TBL_TRN_SLSC01_HDR.SCID','TBL_TRN_SLSC01_HDR.SCNO','TBL_TRN_SLSC01_HDR.SCDT')
        ->distinct('TBL_TRN_SLSC01_HDR.SCID')
        ->get();
        $ObjItem = DB::table('TBL_TRN_SLSC01_HDR')
        ->leftJoin('TBL_TRN_SLSC01_MAT', 'TBL_TRN_SLSC01_MAT.SCID_REF','=','TBL_TRN_SLSC01_HDR.SCID')
        ->leftJoin('TBL_MST_ITEM', 'TBL_MST_ITEM.ITEMID','=','TBL_TRN_SLSC01_MAT.ITEMID_REF')
		->leftJoin('TBL_MST_BUSINESSUNIT', 'TBL_MST_ITEM.BUID_REF','=','TBL_MST_BUSINESSUNIT.BUID')
        ->where('TBL_TRN_SLSC01_HDR.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_TRN_SLSC01_HDR.BRID_REF','=',Session::get('BRID_REF'))
        ->select('TBL_MST_ITEM.ITEMID','TBL_MST_ITEM.ICODE','TBL_MST_ITEM.NAME','TBL_MST_ITEM.ALPS_PART_NO','TBL_MST_BUSINESSUNIT.BUCODE','TBL_MST_BUSINESSUNIT.BUNAME')
        ->distinct('TBL_MST_ITEM.ITEMID')
        ->get();

        $company_check=$this->AlpsStatus();

        return view('reports.sales.SalesChallanRegister.rptfrm258',compact(['objRights','objBranchGroup','objBranch','ObjCustomer',
                    'ObjSCNO','ObjItem','company_check']));        
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
        $SCNO            = $myValue['SCNO'];
        $ITEMID          = $myValue['ITEMID'];
        $Flag            = $myValue['Flag'];
        $STATUS          = $myValue['STATUS'];
        $Quantity        = $myValue['Quantity'];
    }
    else
    {
        $SGLID           = Session::get('SGLID');
        $From_Date       = Session::get('From_Date');
        $To_Date         = Session::get('To_Date');
        $BranchGroup     = Session::get('BranchGroup');
        $BranchName      = Session::get('BranchName');
        $SCNO            = Session::get('SCNO');
        $ITEMID          = Session::get('ITEMID');
        $STATUS          = Session::get('STATUS');
        $Quantity        = Session::get('Quantity');
        $Flag            = $myValue['Flag'];
    }

        
        
        $ssrs = new \SSRS\Report(Session::get('ssrs_config')['REPORT_URL'], array('username' => Session::get('ssrs_config')['username'], 'password' => Session::get('ssrs_config')['password'])); 
   
        $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/Sales_Challan_Register');
        
        $reportParameters = array(
            'p_company'                 => Auth::user()->CYID_REF,
            'p_userid'                  => Auth::user()->USERID,
            'FromDate'                  => $From_Date,
            'ToDate'                    => $To_Date,
            'p_branchgroup'             => $BranchGroup,
            'p_branch'                  => $BranchName,
            'Customer'                  => $SGLID,
            'SCNO'                      => $SCNO,
            'Item'                      => $ITEMID,          
            'STATUS'                    => $STATUS,          
            'Quantity'                  => $Quantity,          
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
                Session::put('SCNO', $SCNO);
                Session::put('ITEMID', $ITEMID);
                Session::put('STATUS', $STATUS);
                Session::put('Quantity', $Quantity);

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


     
     public function AlpsStatus(){
        $COMPANY_NAME   =   DB::table('TBL_MST_COMPANY')->where('STATUS','=','A')->where('CYID','=',Auth::user()->CYID_REF)->select('TBL_MST_COMPANY.NAME')->first()->NAME;
      //  $COMPANY_NAME="ALPS"; 
        return $hidden         =   strpos($COMPANY_NAME,"ALPS")!== false?'show':'hide'; 
    }

    
}
