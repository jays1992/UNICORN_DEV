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
//use App\Exports\ChartOfAccount;
//use Maatwebsite\Excel\Facades\Excel;

class RptFrm553Controller extends Controller
{
    
    protected $form_id =  553;
    protected $vtid_ref   = 623;  //voucher type id
    protected $view     = "reports.Payroll.ChartOfAccount.rptfrm";
    
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
        $FormId         =   $this->form_id;
       
        //dd($viewID);

        $objRights = DB::table('TBL_MST_USERROLMAP')
        ->leftJoin('TBL_MST_USER_BRANCH_MAP', 'TBL_MST_USERROLMAP.USERID_REF','=','TBL_MST_USER_BRANCH_MAP.USERID_REF')
        ->where('TBL_MST_USERROLMAP.USERID_REF','=',Auth::user()->USERID)
        ->where('TBL_MST_USERROLMAP.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_USER_BRANCH_MAP.MAPBRID_REF','=',Session::get('BRID_REF'))
        ->leftJoin('TBL_MST_ROLEDETAILS', 'TBL_MST_USERROLMAP.ROLLID_REF','=','TBL_MST_ROLEDETAILS.ROLLID_REF')
        ->where('TBL_MST_ROLEDETAILS.VTID_REF','=',$this->vtid_ref)
        ->select('TBL_MST_USERROLMAP.*', 'TBL_MST_ROLEDETAILS.*')
        ->first();

        $objBranchGroup = DB::table('TBL_MST_BRANCH_GROUP')
        ->where('TBL_MST_BRANCH_GROUP.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_BRANCH_GROUP.STATUS','=','A')
        ->where('TBL_MST_BRANCH_GROUP.DEACTIVATED','=','0')
        ->where('TBL_MST_BRANCH_GROUP.DODEACTIVATED','=',NULL)
        ->leftJoin('TBL_MST_BRANCH', 'TBL_MST_BRANCH_GROUP.BRID_REF','=','TBL_MST_BRANCH.BRID')
        ->leftJoin('TBL_MST_USER_BRANCH_MAP', 'TBL_MST_BRANCH.BRID','=','TBL_MST_USER_BRANCH_MAP.MAPBRID_REF')
        ->where('TBL_MST_USER_BRANCH_MAP.USERID_REF','=',Auth::user()->USERID)
        ->select('TBL_MST_BRANCH_GROUP.*')
        ->distinct('TBL_MST_BRANCH_GROUP.BGID')
        ->get();
        //dd($objBranchGroup);
        
        $objBranch = DB::table('TBL_MST_BRANCH')
        ->where('TBL_MST_BRANCH.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_BRANCH.STATUS','=','A')
        ->where('TBL_MST_BRANCH.DEACTIVATED','=','0')
        ->where('TBL_MST_BRANCH.DODEACTIVATED','=',NULL)
        ->leftJoin('TBL_MST_USER_BRANCH_MAP', 'TBL_MST_BRANCH.BRID','=','TBL_MST_USER_BRANCH_MAP.MAPBRID_REF')
        ->where('TBL_MST_USER_BRANCH_MAP.USERID_REF','=',Auth::user()->USERID)
        ->select('TBL_MST_BRANCH.*')
        ->distinct('TBL_MST_BRANCH.BRID')  
        ->get(); 
        //dd($objBranch);

        $ObjGenLadger = DB::table('TBL_MST_GENERALLEDGER')
        ->where('TBL_MST_GENERALLEDGER.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_GENERALLEDGER.STATUS','=','A')
        ->where('TBL_MST_GENERALLEDGER.SUBLEDGER','=','0')
        ->where('TBL_MST_GENERALLEDGER.DEACTIVATED','=','0')
        ->where('TBL_MST_GENERALLEDGER.DODEACTIVATED','=',NULL)
        ->select('TBL_MST_GENERALLEDGER.GLID','TBL_MST_GENERALLEDGER.GLCODE','TBL_MST_GENERALLEDGER.GLNAME')
        ->distinct('TBL_MST_GENERALLEDGER.GLID')
        ->get();

        //dd($ObjGenLadger);

        $company_check=$this->AlpsStatus();
        //dd($company_check); 
        return view($this->view.$FormId,compact(['objRights','objBranchGroup','objBranch','ObjGenLadger','company_check','FormId']));     
    }  

    
    public function ViewReport($request) {
        $box = $request;       
        $myValue=  array();
        //print_r($myValue); exit; 
        parse_str($box, $myValue);
        
        if($myValue['Flag'] == 'H')
        {
            $From_Date       = $myValue['From_Date'];
            $To_Date         = $myValue['To_Date'];
            $BranchGroup     = $myValue['BranchGroup'];
            $BranchName      = $myValue['BranchName'];
            $GLedger         = $myValue['GLedger'];
            $Flag            = $myValue['Flag'];
            $CYID_REF        = Auth::user()->CYID_REF;
        }
        else
        {
            $From_Date       = Session::get('From_Date');
            $To_Date         = Session::get('To_Date');
            $BranchGroup     = Session::get('BranchGroup');
            $BranchName      = Session::get('BranchName');
            $GLedger         = Session::get('GLedger');
            $Flag            = $myValue['Flag'];
            $CYID_REF        = Session::get('CYID_REF');
        } 

        $reportParameters = array(
            'CYID'                         => Auth::user()->CYID_REF,
            'USERID'                       => Auth::user()->USERID,
            'FROMDATE'                     => $From_Date,
            'TODATE'                       => $To_Date,
            'BRANCHGROUP'                  => $BranchGroup,
            'BRID'                         => $BranchName,
            'GLedger'                    => $GLedger,     
        );

        //dd($reportParameters);

        $ssrs = new \SSRS\Report(Session::get('ssrs_config')['REPORT_URL'], array('username' => Session::get('ssrs_config')['username'], 'password' => Session::get('ssrs_config')['password'])); 
        
        $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/chart_of_account');
        
        $reportParameters = array(
            'CYID'                         => Auth::user()->CYID_REF,
            'USERID'                       => Auth::user()->USERID,
            'FROMDATE'                     => $From_Date,
            'TODATE'                       => $To_Date,
            'BRANCHGROUP'                  => $BranchGroup,
            'BRID'                         => $BranchName,
            'GLedger'                    => $GLedger,     
        );

        $CYID_REF = Auth::user()->CYID_REF;
        $parameters = new \SSRS\Object\ExecutionParameters($reportParameters);
                
        $ssrs->setSessionId($result->executionInfo->ExecutionID)
            ->setExecutionParameters($parameters);

        if($Flag == 'H')
        {
            Session::put('From_Date', $From_Date);
            Session::put('To_Date', $To_Date);
            Session::put('BranchGroup', $BranchGroup);
            Session::put('BranchName', $BranchName);
            Session::put('GLadger', $GenLadger);
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
           // return Excel::download(new ChartOfAccount($From_Date,$To_Date,$BranchGroup,$BranchName,$GLadger,$CYID_REF), 'ChartOfAccount.xlsx');
            $output = $ssrs->render('EXCEL'); // PDF | XML | CSV | HTML4.0
            return $output->download('Report.xls');
        }    
    }
    
    public function AlpsStatus(){
        $COMPANY_NAME   =   DB::table('TBL_MST_COMPANY')->where('STATUS','=','A')->where('CYID','=',Auth::user()->CYID_REF)->select('TBL_MST_COMPANY.NAME')->first()->NAME;
        //$COMPANY_NAME="ALPS"; 
        return $hidden         =   strpos($COMPANY_NAME,"ALPS")!== false?'show':'hide'; 
    }  
}

