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
use App\Exports\PaymentReport;
use Maatwebsite\Excel\Facades\Excel;

class RptFrm339Controller extends Controller
{
    protected $form_id = 339;
    protected $vtid_ref   = 427;  //voucher type id
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
        //phpinfo();
        $objRights = DB::table('TBL_MST_USERROLMAP')
        ->leftJoin('TBL_MST_USER_BRANCH_MAP', 'TBL_MST_USERROLMAP.USERID_REF','=','TBL_MST_USER_BRANCH_MAP.USERID_REF')
                        ->where('TBL_MST_USERROLMAP.USERID_REF','=',Auth::user()->USERID)
                        ->where('TBL_MST_USERROLMAP.CYID_REF','=',Auth::user()->CYID_REF)
                        ->where('TBL_MST_USER_BRANCH_MAP.MAPBRID_REF','=',Session::get('BRID_REF'))
                       // ->where('TBL_MST_USERROLMAP.FYID_REF','=',Auth::user()->FYID_REF)
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

        $objCashBank = DB::table('TBL_MST_BANK')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('BRID_REF','=',Session::get('BRID_REF'))
        ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
        ->where('STATUS','=','A')
        ->select('BID','BCODE','NAME')
        ->distinct('TBL_MST_BANK.BID')
        ->get();  
		
		$objGL = DB::table('TBL_MST_GENERALLEDGER')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('STATUS','=','A')
		->leftJoin('TBL_TRN_PAYMENT_ACCOUNT', 'TBL_MST_GENERALLEDGER.GLID','=','TBL_TRN_PAYMENT_ACCOUNT.GLID_REF')
        ->select('GLID','GLCODE','GLNAME')
        ->distinct('TBL_MST_GENERALLEDGER.GLID')
        ->get();

        $objPaymentNo =  DB::table('TBL_TRN_PAYMENT_HDR')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('BRID_REF','=',Session::get('BRID_REF'))
       // ->where('STATUS','=','A')
        ->select('PAYMENTID','PAYMENT_NO')
        ->distinct('TBL_TRN_PAYMENT_HDR.PAYMENTID')
        ->get(); 

        return view('reports.Accounts.Payment_Report.rptfrm339',compact(['objRights','objBranchGroup','objBranch','objCashBank','objPaymentNo','objGL']));        
    }  

    
   public function ViewReport($request) {

    $box = $request;        
    $myValue=  array();
    parse_str($box, $myValue);
    
    if($myValue['Flag'] == 'H')
    {
  
        $From_Date       = $myValue['From_Date'];
        $To_Date         = $myValue['To_Date'];
        $BranchGroup     = $myValue['BranchGroup'];
        $BranchName      = $myValue['BranchName'];
        $BID             = $myValue['BID'];
        $PAYMENTID       = $myValue['PAYMENTID'];
		$TYPE       	 = $myValue['TYPE'];
		$GLID       	 = $myValue['GLID'];
        $PAYMENTFOR      = $myValue['PAYMENTFOR'];
        $Flag            = $myValue['Flag'];
        $STATUS            = $myValue['STATUS'];
        $CYID_REF          = Auth::user()->CYID_REF;
    }
    else
    {

        $From_Date       = Session::get('From_Date');
        $To_Date         = Session::get('To_Date');
        $BranchGroup     = Session::get('BranchGroup');
        $BranchName      = Session::get('BranchName');
        $BID             = Session::get('BID');
        $PAYMENTID       = Session::get('PAYMENTID');
        $PAYMENTFOR      = Session::get('PAYMENTFOR');
        $STATUS     	 = Session::get('STATUS');
		$TYPE       	 = Session::get('TYPE');
		$GLID       	 = Session::get('GLID');
        $Flag            = $myValue['Flag'];
        $CYID_REF        = Auth::user()->CYID_REF;
    }

        
        

        $ssrs = new \SSRS\Report(Session::get('ssrs_config')['REPORT_URL'], array('username' => Session::get('ssrs_config')['username'], 'password' => Session::get('ssrs_config')['password'])); 
   
        $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/PaymentReport');
        
        $reportParameters = array(
            'CYID'                      => Auth::user()->CYID_REF,
            'UID'                       => Auth::user()->USERID,
            'FromDate'                  => $From_Date,
            'ToDate'                    => $To_Date,
            'Branch_Group'              => $BranchGroup,
            'BRID'                      => $BranchName,
            'Bank'                      => $BID,
            'PAYMENTFOR'                => $PAYMENTFOR,
            'PAYMENTID'                 => $PAYMENTID,
            'STATUS'                    => $STATUS,
			'GLID'                    	=> $GLID,
			'TYPE'                    	=> $TYPE
          
        );

        //dd($reportParameters); 
        $CYID_REF          = Auth::user()->CYID_REF;
        $parameters = new \SSRS\Object\ExecutionParameters($reportParameters);
        
        $ssrs->setSessionId($result->executionInfo->ExecutionID)
            ->setExecutionParameters($parameters);

            if($Flag == 'H')
            {
              
                Session::put('From_Date', $From_Date);
                Session::put('To_Date', $To_Date);
                Session::put('BranchGroup', $BranchGroup);
                Session::put('BranchName', $BranchName);
                Session::put('BID', $BID);
                Session::put('PAYMENTID', $PAYMENTID);
                Session::put('PAYMENTFOR', $PAYMENTFOR);
                Session::put('STATUS', $STATUS);
				Session::put('GLID', $GLID);
				Session::put('TYPE', $TYPE);


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
                return Excel::download(new PaymentReport($BID,$From_Date,$To_Date,$BranchGroup,$BranchName,$PAYMENTID,$STATUS,$CYID_REF,$PAYMENTFOR), 'PaymentReport.xlsx');
            }
         
     }

    
}
