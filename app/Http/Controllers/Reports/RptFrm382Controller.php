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

class RptFrm382Controller extends Controller
{
    protected $form_id = 382;
    protected $vtid_ref   = 468;  //voucher type id
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



        $ObjCustomerGroup = DB::table('TBL_MST_CUSTOMERGROUP')
        ->where('TBL_MST_CUSTOMERGROUP.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_CUSTOMERGROUP.BRID_REF','=',Session::get('BRID_REF'))
        ->where('TBL_MST_CUSTOMERGROUP.STATUS','=','A')
        ->select('TBL_MST_CUSTOMERGROUP.CGID','TBL_MST_CUSTOMERGROUP.CGROUP','TBL_MST_CUSTOMERGROUP.DESCRIPTIONS')
        ->distinct('TBL_MST_CUSTOMERGROUP.CGID')
        ->get();         



        $ObjCustomer = DB::table('TBL_MST_SUBLEDGER')
        ->Join('TBL_MST_CUSTOMER', 'TBL_MST_CUSTOMER.SLID_REF','=','TBL_MST_SUBLEDGER.SGLID')
        ->where('TBL_MST_SUBLEDGER.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_SUBLEDGER.BRID_REF','=',Session::get('BRID_REF'))
        ->where('TBL_MST_SUBLEDGER.STATUS','=','A')
        ->where('TBL_MST_SUBLEDGER.BELONGS_TO','=','Customer')
        ->select('TBL_MST_SUBLEDGER.SGLID','TBL_MST_SUBLEDGER.SGLCODE','TBL_MST_SUBLEDGER.SLNAME')
        ->distinct()
        ->get();
        
       //dd($ObjCustomer); 
     

        return view('reports.Sales.CustomerAgeingReport.rptfrm382',compact(['objRights','objBranchGroup','objBranch','ObjCustomerGroup','ObjCustomer']));        
    }  

    
   public function ViewReport($request) {

    $box = $request;        
    $myValue=  array();
    parse_str($box, $myValue);
    
    if($myValue['Flag'] == 'H')
    {
        $CDG             = $myValue['CDG'];
        $CUSTOMER        = $myValue['CUSTOMER'];
        $AsOnDate        = $myValue['AsOnDate'];
        $BranchGroup     = $myValue['BranchGroup'];
        $BranchName      = $myValue['BranchName'];
        $ReportType      = $myValue['ReportType'];
        $ReportBasis     = $myValue['ReportBasis'];
        $Flag            = $myValue['Flag'];
    }
    else
    {
        $CDG             = Session::get('CDG');
        $CUSTOMER        = Session::get('CUSTOMER');
        $AsOnDate        = Session::get('AsOnDate');
        $ReportBasis     = Session::get('ReportBasis');
        $BranchGroup     = Session::get('BranchGroup');
        $BranchName      = Session::get('BranchName');
        $ReportType      = $myValue['ReportType'];
        $Flag            = $myValue['Flag'];
    }

        
        

                
    $ssrs = new \SSRS\Report(Session::get('ssrs_config')['REPORT_URL'], array('username' => Session::get('ssrs_config')['username'], 'password' => Session::get('ssrs_config')['password'])); 
   
    if($ReportType == "Detail")
    {
        $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/Cust_Ageing_Detail');

    }
    else
    {
        $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/Cust_Ageing');

    }


   


        
        $reportParameters = array(
            'CYID'                      => Auth::user()->CYID_REF,
            'UID'                       => Auth::user()->USERID,
            'ASONDATE'                  => $AsOnDate,
            'BRID_REF'                  => $BranchName,
            'CGID_REF'                  => $CDG,          
            'ID'                        => $CUSTOMER, 
            'REPORTBASIS'               => $ReportBasis,
        );
        //dd($ReportType);
        $parameters = new \SSRS\Object\ExecutionParameters($reportParameters);
       
        
        $ssrs->setSessionId($result->executionInfo->ExecutionID)
            ->setExecutionParameters($parameters);

        // dd($ssrs); 

            if($Flag == 'H')
            {
                Session::put('CDG', $CDG);
                Session::put('CUSTOMER', $CUSTOMER);
                Session::put('AsOnDate', $AsOnDate);
                Session::put('ReportBasis', $ReportBasis);
                Session::put('BranchGroup', $BranchGroup);
                Session::put('BranchName', $BranchName);

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
