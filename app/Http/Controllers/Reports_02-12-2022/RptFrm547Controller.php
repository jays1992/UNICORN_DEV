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

use App\Exports\PurchaseBillDetail;
use App\Exports\PurchaseBillSummary;
use Maatwebsite\Excel\Facades\Excel;

class RptFrm547Controller extends Controller
{
    protected $form_id = 547;
    protected $vtid_ref   = 617;  //voucher type id
    protected $view     = "reports.purchase.ItemMaster.rptfrm";
    
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
        ->where('TBL_MST_USERROLMAP.USERID_REF','=',Auth::user()->USERID)
        ->where('TBL_MST_USERROLMAP.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_USERROLMAP.BRID_REF','=',Auth::user()->BRID_REF)
        ->where('TBL_MST_USERROLMAP.FYID_REF','=',Auth::user()->FYID_REF)
        ->leftJoin('TBL_MST_ROLEDETAILS', 'TBL_MST_USERROLMAP.ROLLID_REF','=','TBL_MST_ROLEDETAILS.ROLLID_REF')
        ->where('TBL_MST_ROLEDETAILS.VTID_REF','=',$this->vtid_ref)
        ->select('TBL_MST_USERROLMAP.*', 'TBL_MST_ROLEDETAILS.*')
        ->first();

    
        $ObjItemGrp = DB::table('TBL_MST_ITEMGROUP')
        ->where('TBL_MST_ITEMGROUP.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_MST_ITEMGROUP.BRID_REF','=',Auth::user()->BRID_REF)
        ->where('TBL_MST_ITEMGROUP.STATUS','=','A', 'OR','TBL_MST_ITEMGROUP.DEACTIVATED','=','0', 'OR', 'TBL_MST_ITEMGROUP.DODEACTIVATED','=',NULL)
        ->select('TBL_MST_ITEMGROUP.ITEMGID','TBL_MST_ITEMGROUP.GROUPNAME')
        ->distinct('TBL_MST_ITEMGROUP.ITEMGID')
        ->get();
      // dd($ObjItemGrp);
       
        $ObjItemSubGrp = DB::table('TBL_MST_ITEMSUBGROUP')
        //->where('TBL_MST_ITEMSUBGROUP.CYID_REF','=',Auth::user()->CYID_REF)
        //->where('TBL_MST_ITEMSUBGROUP.BRID_REF','=',Auth::user()->BRID_REF)
        // ->where('TBL_MST_ITEMSUBGROUP.STATUS','=','A')
        ->select('TBL_MST_ITEMSUBGROUP.ISGID','TBL_MST_ITEMSUBGROUP.ISGCODE','TBL_MST_ITEMSUBGROUP.DESCRIPTIONS')
        ->distinct('TBL_MST_ITEMSUBGROUP.ISGID')
        ->get();
       //dd($ObjItemSubGrp);

       $ObjCategory = DB::table('TBL_MST_ITEMCATEGORY')
       ->where('TBL_MST_ITEMCATEGORY.CYID_REF','=',Auth::user()->CYID_REF)
       ->where('TBL_MST_ITEMCATEGORY.BRID_REF','=',Auth::user()->BRID_REF)
       ->where('TBL_MST_ITEMCATEGORY.STATUS','=','A', 'OR','TBL_MST_ITEMCATEGORY.DEACTIVATED','=','0', 'OR', 'TBL_MST_ITEMCATEGORY.DODEACTIVATED','=',NULL)
       ->select('TBL_MST_ITEMCATEGORY.ICID','TBL_MST_ITEMCATEGORY.ICCODE','TBL_MST_ITEMCATEGORY.DESCRIPTIONS')
       ->distinct('TBL_MST_ITEMCATEGORY.ICID')
       ->get();
       //dd($ObjCategory);

        $company_check=$this->AlpsStatus();  

        return view($this->view.$FormId,compact(['objRights','ObjItemGrp','company_check','ObjItemSubGrp','ObjCategory','FormId']));     
    }  

    
    public function ViewReport($request) {
        $box = $request;        
        $myValue=  array();
        parse_str($box, $myValue);
        
        if($myValue['Flag'] == 'H')
        {
            $From_Date       = $myValue['From_Date'];
            $To_Date         = $myValue['To_Date'];
            $ITEMGID         = $myValue['ITEMGID'];
            $ISGID          = $myValue['ISGID'];
            $Flag            = $myValue['Flag'];
            $CYID_REF          = Auth::user()->CYID_REF;
        }
        else
        {
            $From_Date       = Session::get('From_Date');
            $To_Date         = Session::get('To_Date');
            $ITEMGID         = Session::get('ITEMGID');
            $ISGID          = Session::get('ISGID');
            $Flag            = $myValue['Flag'];
            $CYID_REF        = Session::get('CYID_REF');
        }  
    
        $reportParameters = array(
            'CYID'                      => Auth::user()->CYID_REF,
            'USERID'                    => Auth::user()->USERID,
            'FROMDATE'                  => $From_Date,
            'TODATE'                    => $To_Date,
            'ITEMGROUP'                 => $ITEMGID,
            'ISGID'                      => $ISGID,            
        );
        //dd($reportParameters);

        $ssrs = new \SSRS\Report(Session::get('ssrs_config')['REPORT_URL'], array('username' => Session::get('ssrs_config')['username'], 'password' => Session::get('ssrs_config')['password'])); 
        
        $result = $ssrs->loadReport(Session::get('ssrs_config')['INSTANCE_NAME'].'/item_master2_report');
        
        // $reportParameters = array(
        //     'CYID'                      => Auth::user()->CYID_REF,
        //     'USERID'                    => Auth::user()->USERID,
        //     'FROMDATE'                  => $From_Date,
        //     'TODATE'                    => $To_Date,
        //     'BRANCHGROUP'               => $BranchGroup,
        //     'BRID'                      => $BranchName,
        //     'VENDOR'                    => $SGLID,
        //     'ITEMGROUP'                 => $ITEMGID,
        //     'ITEM'                      => $ITEMID,
        //     'GROUPBY'                   => $GroupBy,
        //     'ORDERBY'                   => $OrderBy,            
        //     'STATUS'                    => $STATUS,            
        //     'Quantity'                  => $Quantity,            
        // );
        // dd($reportParameters);

        $CYID_REF = Auth::user()->CYID_REF;
        $parameters = new \SSRS\Object\ExecutionParameters($reportParameters);
                
        $ssrs->setSessionId($result->executionInfo->ExecutionID)
        ->setExecutionParameters($parameters);

        if($Flag == 'H')
        {
            Session::put('From_Date', $From_Date);
            Session::put('To_Date', $To_Date);
            Session::put('ITEMGID', $ITEMGID);
            Session::put('ISGID', $ISGID);
        
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
            return Excel::download(new item_master2_report($From_Date,$To_Date,$ITEMGID,$ISGID,$CYID_REF), 'item_master2_report.xlsx');
        } 
    }

    public function AlpsStatus(){
        $COMPANY_NAME   =   DB::table('TBL_MST_COMPANY')->where('STATUS','=','A')->where('CYID','=',Auth::user()->CYID_REF)->select('TBL_MST_COMPANY.NAME')->first()->NAME;
        //  $COMPANY_NAME="ALPS"; 
        return $hidden         =   strpos($COMPANY_NAME,"ALPS")!== false?'show':'hide'; 
    } 
}
