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
use App\Exports\PNL;
use Maatwebsite\Excel\Facades\Excel;

class RptFrm524Controller extends Controller
{
    protected $form_id = 524;
    protected $vtid_ref   = 594;  //voucher type id
	protected $view_ref =   "AuditTrial";
    protected $repo_nam =   "Audit Trial Report";
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

		
		$CYID_REF 		= 	Auth::user()->CYID_REF;
		$FORM_ID        =   $this->form_id;
		$REPO_NAM       =   $this->repo_nam;

        $ObjMODULE = DB::select("SELECT DISTINCT G.MODULEID, G.MODULECODE, G.MODULENAME FROM TBL_MST_MODULE G
                           WHERE  G.STATUS = 'A' ");
						   
        return view('reports.Accounts.AuditTrial.rptfrm524',compact(['FORM_ID','objRights','objBranchGroup','objBranch','ObjMODULE','REPO_NAM']));        
    }

	public function getFormname($request){
		
		$MODULEID_REF = $request['MODULEID'];
		
		$ObjData      =   DB::select("SELECT A.* FROM TBL_MST_VOUCHERTYPE A  INNER JOIN TBL_MST_MODULE_VOUCHER_MAP B ON A.VTID = B.VTID_REF 
		WHERE B.MODULEID_REF = '$MODULEID_REF' AND A.STATUS='A' AND B.STATUS='A'");
		
		$row1 = '<select name="VTID" id="VTID" class="form-control mandatory"> <option value="">select</option>';			
			$row2 = '</select>';			
			$row = '';
			$row3 = '';
        if(!empty($ObjData)){
			foreach ($ObjData as $index=>$dataRow){
				$row = $row.'<option value="'.$dataRow->VTID.'" >'.$dataRow->DESCRIPTIONS.'</option>';			
			}
        }else{
            $row = '';
        }
		
		$row3 = $row1.$row.$row2;
		echo $row3;
		
        exit();
		
	}

    
   public function ViewReport($request) {

    $box = $request;        
    $myValue=  array();
    parse_str($box, $myValue);
    
    if($myValue['Flag'] == 'H')
    {
        $DESCRIPTIONS    = $myValue['VTID'];
        $MODULENAME      = $myValue['MODULEID'];
        $FROMDATE        = $myValue['From_Date'];
        $TODATE          = $myValue['To_Date'];
        $BRANCHGROUP     = $myValue['BranchGroup'];
        $BRID      		 = $myValue['BranchName'];
        $Flag            = $myValue['Flag'];     
        $CYID          	 = Auth::user()->CYID_REF;
    }
    else
    {
        $DESCRIPTIONS    = Session::get('DESCRIPTIONS');
        $MODULENAME      = Session::get('MODULENAME');
        $FROMDATE        = Session::get('FROMDATE');
        $TODATE          = Session::get('TODATE');
        $BRANCHGROUP     = Session::get('BRANCHGROUP');
        $BRID      		 = Session::get('BRID');
        $Flag            = $myValue['Flag'];
        $CYID            = Auth::user()->CYID_REF;
    }

        
        

        $ssrs = new \SSRS\Report(Session::get('ssrs_config')['REPORT_URL'], array('username' => Session::get('ssrs_config')['username'], 'password' => Session::get('ssrs_config')['password'])); 
   
        $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/AUDITTRAIL');
        
        $reportParameters = array(
            'CYID'                      => Auth::user()->CYID_REF,
            'UID'                  		=> Auth::user()->USERID,
            'FROMDATE'                  => $FROMDATE,
            'TODATE'                    => $TODATE,
            'BRANCHGROUP'             	=> $BRANCHGROUP,
            'BRID'                    	=> $BRID,
			'MODULENAME'            	=> $MODULENAME, 
            'DESCRIPTIONS'            	=> $DESCRIPTIONS,
        );

        // dd($reportParameters);
        $CYID_REF          = Auth::user()->CYID_REF;
        $parameters = new \SSRS\Object\ExecutionParameters($reportParameters);
        
        $ssrs->setSessionId($result->executionInfo->ExecutionID)
            ->setExecutionParameters($parameters);

            if($Flag == 'H')
            {
                Session::put('MODULENAME', $MODULENAME);
                Session::put('DESCRIPTIONS', $DESCRIPTIONS);
                Session::put('FROMDATE', $FROMDATE);
                Session::put('TODATE', $TODATE);
                Session::put('BRANCHGROUP', $BRANCHGROUP);
                Session::put('BRID', $BRID);

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
                //return Excel::download(new PNL($GLID,$AGID,$ASGID,$From_Date,$To_Date,$BranchName,$CYID_REF), 'PNL.xlsx');
            }
         
     } 
    
}
