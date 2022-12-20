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

//use App\Exports\VenderMasterReport;
//use Maatwebsite\Excel\Facades\Excel;

class RptFrm548Controller extends Controller
{
    
    protected $form_id =  548;
    protected $vtid_ref   = 618;  //voucher type id
    protected $view     = "reports.purchase.VendorMaster.rptfrm";
    
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

        $ObjVendor = DB::select("SELECT      DISTINCT   S.SGLID,S.SGLCODE, S.SLNAME,S.CYID_REF,S.BRID_REF
        FROM     TBL_MST_VENDOR  AS A JOIN  TBL_MST_SUBLEDGER AS S
        ON A.VID = S.SGLID WHERE S.STATUS='A' AND A.CYID_REF= 6 AND S.BELONGS_TO='Vendor'");
      
        //dd($ObjVendor);

        $company_check=$this->AlpsStatus();
        //dd($company_check); 
        return view($this->view.$FormId,compact(['objRights','objBranchGroup','objBranch','ObjVendor','company_check','FormId']));     
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
            $Flag            = $myValue['Flag'];
            $CYID_REF          = Auth::user()->CYID_REF;
        }
        else
        {
            $SGLID           = Session::get('SGLID');
            $From_Date       = Session::get('From_Date');
            $To_Date         = Session::get('To_Date');
            $BranchGroup     = Session::get('BranchGroup');
            $BranchName      = Session::get('BranchName');
            
            $Flag            = $myValue['Flag'];
            $CYID_REF        = Session::get('CYID_REF');
        }
          

        $ssrs = new \SSRS\Report(Session::get('ssrs_config')['REPORT_URL'], array('username' => Session::get('ssrs_config')['username'], 'password' => Session::get('ssrs_config')['password'])); 
        
        $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/vender_master_report');
        
        $reportParameters = array(
            'CYID'                         => Auth::user()->CYID_REF,
            'USERID'                       => Auth::user()->USERID,
            'FROMDATE'                     => $From_Date,
            'TODATE'                       => $To_Date,
            'BRANCHGROUP'                  => $BranchGroup,
            'BRID'                         => $BranchName,
            'Vendor'                       => $SGLID,     
        );

        $CYID_REF = Auth::user()->CYID_REF;
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
            //return Excel::download(new VenderMasterReport($SGLID,$From_Date,$To_Date,$BranchGroup,$BranchName,$CYID_REF), 'VenderMasterReport.xlsx');
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

