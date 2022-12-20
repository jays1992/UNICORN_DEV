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
use App\Exports\RGPRegister;
use Maatwebsite\Excel\Facades\Excel;


class RptFrm443Controller extends Controller
{
    protected $form_id    = 443;
    protected $vtid_ref   = 513;  //voucher type id
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
        $CYID_REF   	=   Auth::user()->CYID_REF;
        $BRID_REF   	=   Session::get('BRID_REF');
        $FYID_REF   	=   Session::get('FYID_REF');     

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


        $ObjPayPeriod           =       DB::select("SELECT PAYPERIODID,PAY_PERIOD_CODE,PAY_PERIOD_DESC FROM TBL_MST_PAY_PERIOD
                                        WHERE CYID_REF=$CYID_REF AND STATUS='A' AND BRID_REF=$BRID_REF AND 
                                        (DEACTIVATED IS NULL  OR DEACTIVATED = 0)");

        $ObjEmployeeType        =       DB::select("SELECT ETYPEID,ECODE,NAME FROM TBL_MST_EMPLOYEETYPE
                                        WHERE CYID_REF=$CYID_REF AND STATUS='A' AND BRID_REF=$BRID_REF AND 
                                        (DEACTIVATED IS NULL  OR DEACTIVATED = 0)");

        $ObjEmployeeCategory    =       DB::select("SELECT CATID,CATCODE,NAME FROM TBL_MST_EMPCATEGORY
                                        WHERE CYID_REF=$CYID_REF AND STATUS='A' AND BRID_REF=$BRID_REF AND 
                                        (DEACTIVATED IS NULL  OR DEACTIVATED = 0)");

        $ObjDepartment          =       DB::select("SELECT DEPID,DCODE,NAME FROM TBL_MST_DEPARTMENT
                                        WHERE CYID_REF=$CYID_REF AND STATUS='A' AND BRID_REF=$BRID_REF AND 
                                        (DEACTIVATED IS NULL  OR DEACTIVATED = 0)");

        $ObjDivision            =       DB::select("SELECT DIVID,DIVCODE,NAME FROM TBL_MST_DIVISON
                                        WHERE CYID_REF=$CYID_REF AND STATUS='A' AND BRID_REF=$BRID_REF AND 
                                        (DEACTIVATED IS NULL  OR DEACTIVATED = 0)");

        $ObjGrade               =       DB::select("SELECT GRADEID,GRADE_CODE,GRADE_DESC FROM TBL_MST_GRADE
                                        WHERE CYID_REF=$CYID_REF AND STATUS='A' AND BRID_REF=$BRID_REF AND 
                                        (DEACTIVATED IS NULL  OR DEACTIVATED = 0)");

        $ObjFyear               =       DB::select("SELECT FYID,FYCODE,FYDESCRIPTION FROM TBL_MST_FYEAR
                                        WHERE CYID_REF=$CYID_REF AND STATUS='A' AND BRID_REF=$BRID_REF AND 
                                        (DEACTIVATED IS NULL  OR DEACTIVATED = 0)");

        $ObjEmployee            =       DB::select("SELECT EMPID,EMPCODE,
                                        dbo.fn_titlecase(FNAME+ ISNULL(' '+MNAME,'')+ISNULL(' '+LNAME,'')) AS EMP_NAME   FROM TBL_MST_EMPLOYEE WHERE CYID_REF=$CYID_REF AND STATUS='A' AND BRID_REF=$BRID_REF AND (DEACTIVATED IS NULL  OR DEACTIVATED = 0)");


        $ObjLeaveType           =       DB::select("SELECT LTID,LEAVETYPE_CODE,dbo.fn_titlecase(LEAVETYPE_DESC) AS LEAVETYPE_DESC FROM TBL_MST_LEAVE_TYPE
                                        WHERE CYID_REF=$CYID_REF AND STATUS='A' AND BRID_REF=$BRID_REF AND 
                                        (DEACTIVATED IS NULL  OR DEACTIVATED = 0)");

        //dd($ObjEmployeeType); 


        


        return view('reports.Payroll.LeaveSummary.rptfrm443',compact([
        'objRights',
        'objBranchGroup',
        'objBranch',
        'ObjPayPeriod',
        'ObjEmployeeType',
        'ObjEmployeeCategory',
        'ObjDepartment',
        'ObjDivision',
        'ObjGrade',
        'ObjFyear',
        'ObjEmployee',
        'ObjLeaveType',
                    ]));        
    }  

    
   public function ViewReport($request) {

    //dd($request->all()); 

    $box = $request;        
    $myValue=  array();
    parse_str($box, $myValue);
    
    if($myValue['Flag'] == 'H')
    {
        








        
        $BranchGroup     = $myValue['BranchGroup'];
        $BranchName      = $myValue['BranchName'];
        $Flag            = $myValue['Flag'];
        $PAYPERIODID     = $myValue['PAYPERIODID'];
        $ETYPEID         = $myValue['ETYPEID'];
        $CATID           = $myValue['CATID'];
        $DEPID           = $myValue['DEPID'];
        $DIVID           = $myValue['DIVID'];
        $GRADEID         = $myValue['GRADEID'];
        $FYID            = $myValue['FYID'];
        $EMPID           = $myValue['EMPID'];
        $LTID            = $myValue['LTID'];

        $CYID_REF          = Auth::user()->CYID_REF;
    }
    else
    {
     
        
        $BranchGroup     = Session::get('BranchGroup');
        $BranchName      = Session::get('BranchName');
        $PAYPERIODID     = Session::get('PAYPERIODID');
        $ETYPEID         = Session::get('ETYPEID');
        $CATID           = Session::get('CATID');
        $DEPID           = Session::get('DEPID');
        $DIVID           = Session::get('DIVID');
        $GRADEID         = Session::get('GRADEID');
        $FYID            = Session::get('FYID');
        $EMPID           = Session::get('EMPID');
        $LTID            = Session::get('LTID');
        $Flag            = $myValue['Flag'];
        $CYID_REF          = Auth::user()->CYID_REF;
    }

        
        
          $ssrs = new \SSRS\Report(Session::get('ssrs_config')['REPORT_URL'], array('username' => Session::get('ssrs_config')['username'], 'password' => Session::get('ssrs_config')['password'])); 
   
            $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/LeaveSummary');
      
        
        $reportParameters = array(
            'p_cyid'                         => Auth::user()->CYID_REF,
            'p_userid'                       => Auth::user()->USERID,
            'p_branchgroup'                  => $BranchGroup,
            'p_branch'                       => $BranchName,
            'PayPeriod'                      => $PAYPERIODID,
            'EmployeeType'                   => $ETYPEID,
            'EmployeeCategory'               => $CATID,
            'Department'                     => $DEPID,
            'Division'                       => $DIVID,
            'Grade'                          => $GRADEID,
            'FinancialYear'                  => $FYID,
            'Employee'                       => $EMPID,
            'LeaveType'                      => $LTID,
        );

        

        $CYID_REF          = Auth::user()->CYID_REF;        
        $parameters = new \SSRS\Object\ExecutionParameters($reportParameters);        
        $ssrs->setSessionId($result->executionInfo->ExecutionID)
            ->setExecutionParameters($parameters);
         
            if($Flag == 'H')
            {                              
                Session::put('BranchGroup', $BranchGroup);
                Session::put('BranchName', $BranchName);
                Session::put('PAYPERIODID', $PAYPERIODID);
                Session::put('ETYPEID', $ETYPEID);
                Session::put('CATID', $CATID);
                Session::put('DEPID', $DEPID);           
                Session::put('DIVID', $DIVID);           
                Session::put('GRADEID', $GRADEID);           
                Session::put('FYID', $FYID);           
                Session::put('EMPID', $EMPID);           
                Session::put('LTID', $LTID);           

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
