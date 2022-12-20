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

use App\Exports\GRN_Against_GE_Register;
use Maatwebsite\Excel\Facades\Excel;

class RptFrm518Controller extends Controller{

    protected $form_id  =   518;
    protected $vtid_ref =   588;  
    protected $view_ref =   "PdcEmiReport";
    protected $repo_nam =   "PDC/EMI Report";
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){ 

        $FORM_ID        =   $this->form_id;
        $VTID_REF       =   $this->vtid_ref;
        $REPO_NAM       =   $this->repo_nam;

        $USERID         =   Auth::user()->USERID;
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');    

        $objRights      =   DB::table('TBL_MST_USERROLMAP')
        ->leftJoin('TBL_MST_USER_BRANCH_MAP', 'TBL_MST_USERROLMAP.USERID_REF','=','TBL_MST_USER_BRANCH_MAP.USERID_REF')
                            ->where('TBL_MST_USERROLMAP.USERID_REF','=',$USERID)
                            ->where('TBL_MST_USERROLMAP.CYID_REF','=',$CYID_REF)
                            ->where('TBL_MST_USER_BRANCH_MAP.MAPBRID_REF','=',Session::get('BRID_REF'))
                            ->leftJoin('TBL_MST_ROLEDETAILS', 'TBL_MST_USERROLMAP.ROLLID_REF','=','TBL_MST_ROLEDETAILS.ROLLID_REF')
                            ->where('TBL_MST_ROLEDETAILS.VTID_REF','=',$VTID_REF)
                            ->select('TBL_MST_USERROLMAP.*', 'TBL_MST_ROLEDETAILS.*')
                            ->first();

        $objBranchGroup =   DB::table('TBL_MST_BRANCH_GROUP')
                            ->where('TBL_MST_BRANCH_GROUP.CYID_REF','=',$CYID_REF)
                            ->where('TBL_MST_BRANCH_GROUP.STATUS','=','A')
                            ->leftJoin('TBL_MST_BRANCH', 'TBL_MST_BRANCH_GROUP.BRID_REF','=','TBL_MST_BRANCH.BRID')
                            ->leftJoin('TBL_MST_USER_BRANCH_MAP', 'TBL_MST_BRANCH.BRID','=','TBL_MST_USER_BRANCH_MAP.MAPBRID_REF')
                            ->where('TBL_MST_USER_BRANCH_MAP.USERID_REF','=',$USERID)
                            ->select('TBL_MST_BRANCH_GROUP.*')
                            ->distinct('TBL_MST_BRANCH_GROUP.BGID')
                            ->get();

        $objBranch      =   DB::table('TBL_MST_BRANCH')
                            ->where('TBL_MST_BRANCH.CYID_REF','=',$CYID_REF)
                            ->where('TBL_MST_BRANCH.STATUS','=','A')
                            ->leftJoin('TBL_MST_USER_BRANCH_MAP', 'TBL_MST_BRANCH.BRID','=','TBL_MST_USER_BRANCH_MAP.MAPBRID_REF')
                            ->where('TBL_MST_USER_BRANCH_MAP.USERID_REF','=',$USERID)
                            ->select('TBL_MST_BRANCH.*')
                            ->distinct('TBL_MST_BRANCH.BRID')    
                            ->get();
                            

        $CustomerList   =   DB::select("SELECT DISTINCT
        T2.SLID_REF AS CUSTOMER_ID,
        CONCAT(T2.CCODE,' ',T2.NAME ) AS CUSTOMER_CODE
        FROM TBL_TRN_RECEIPT_HDR T1
        LEFT JOIN TBL_MST_CUSTOMER T2 ON T2.SLID_REF=T1.CUSTMER_VENDOR_ID
        WHERE T1.RECEIPT_FOR='Customer' AND  T1.CYID_REF='$CYID_REF'
        ");

        $BankList   =   DB::select("SELECT DISTINCT
        T1.BID AS BANK_ID,
        T1.NAME AS BANK_NAME
        FROM TBL_MST_BANK T1
        INNER JOIN TBL_TRN_RECEIPT_HDR T2 ON T2.CASH_BANK_ID=T1.BID
        WHERE T1.CYID_REF='$CYID_REF' AND T1.STATUS='A' AND (T1.DEACTIVATED IS NULL OR T1.DEACTIVATED =0)
        ");

        return view('reports.Accounts.'.$this->view_ref.'.rptfrm'.$FORM_ID,compact(['FORM_ID','REPO_NAM','objRights','objBranchGroup','objBranch','CustomerList','BankList']));        
    }  

    
    public function ViewReport($request) {

        $FORM_ID        =   $this->form_id;
        $VTID_REF       =   $this->vtid_ref;

        $USERID         =   Auth::user()->USERID;
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF'); 

        $box            =   $request;        
        $myValue        =   array();
        parse_str($box, $myValue);
    
        if($myValue['Flag'] == 'H'){
            $From_Date      =   $myValue['From_Date'];
            $To_Date        =   $myValue['To_Date'];
            $BranchGroup    =   $myValue['BranchGroup'];
            $BranchName     =   $myValue['BranchName'];
            $STATUS         =   $myValue['STATUS'];
            $CUSTOMER_ID    =   $myValue['CUSTOMER_ID'];
            $PDC_TYPE       =   $myValue['PDC_TYPE'];
            $PDC_STATUS     =   $myValue['PDC_STATUS'];
            $BANK_ID        =   $myValue['BANK_ID'];
            $Flag           =   $myValue['Flag']; 
        }
        else{
        
            $From_Date      =   Session::get('From_Date');
            $To_Date        =   Session::get('To_Date');
            $BranchGroup    =   Session::get('BranchGroup');
            $BranchName     =   Session::get('BranchName');
            $STATUS         =   Session::get('STATUS');
            $CUSTOMER_ID    =   Session::get('CUSTOMER_ID');
            $PDC_TYPE       =   Session::get('PDC_TYPE');
            $PDC_STATUS     =   Session::get('PDC_STATUS');
            $BANK_ID        =   Session::get('BANK_ID');
            $Flag           =   $myValue['Flag'];
        }
        
        $ssrs               =   new \SSRS\Report(Session::get('ssrs_config')['REPORT_URL'], array('username' => Session::get('ssrs_config')['username'], 'password' => Session::get('ssrs_config')['password'])); 
        $result             =   $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/'.$this->view_ref);
      
        $reportParameters = array(
            'p_cyid'        =>  $CYID_REF,
            'p_userid'      =>  $USERID,
            'FinancialYear' =>  $FYID_REF, 
            'p_branchgroup' =>  $BranchGroup,
            'p_branch'      =>  $BranchName,
            'FromDate'      =>  $From_Date,
            'ToDate'        =>  $To_Date,
            'CUSTOMERID'    =>  $CUSTOMER_ID,
            'PDC_TYPE'      =>  $PDC_TYPE, 
            'PDC_STATUS'    =>  $PDC_STATUS,  
            'BANK_ID'       =>  $BANK_ID           
        );


        $parameters = new \SSRS\Object\ExecutionParameters($reportParameters);
        $ssrs->setSessionId($result->executionInfo->ExecutionID)->setExecutionParameters($parameters);

        if($Flag == 'H'){
            Session::put('From_Date', $From_Date);
            Session::put('To_Date', $To_Date);
            Session::put('BranchGroup', $BranchGroup);
            Session::put('BranchName', $BranchName);
            Session::put('STATUS', $STATUS);
            Session::put('CUSTOMER_ID', $CUSTOMER_ID);
            Session::put('PDC_TYPE', $PDC_TYPE);
            Session::put('PDC_STATUS', $PDC_STATUS);
            Session::put('BANK_ID', $BANK_ID);
            $output = $ssrs->render('HTML4.0'); // PDF | XML | CSV
            echo $output;
        }
        else if($Flag == 'P'){
            $output = $ssrs->render('PDF'); // PDF | XML | CSV | HTML4.0
            return $output->download('Report.pdf');
        }
        else if($Flag == 'E'){
            $output = $ssrs->render('EXCEL'); // PDF | XML | CSV | HTML4.0
            return $output->download('Report.xls'); 
        }
         
    }


    
}
