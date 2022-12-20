<?php
namespace App\Http\Controllers\Transactions;

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

class TrnFrm233Controller extends Controller{

    protected $form_id  = 233;
    protected $vtid_ref = 323;
    protected $view     = "transactions.Accounts.ARDebitNote.trnfrm";

    protected   $messages = [
        'LABEL.unique' => 'Duplicate Code'
    ];

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){    
        $objRights      =   $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);
        
        $FormId         =   $this->form_id;
        $CYID_REF   	=   Auth::user()->CYID_REF;
        $BRID_REF   	=   Session::get('BRID_REF');
        $FYID_REF   	=   Session::get('FYID_REF');     


        $objFinalAppr = DB::select("select dbo.FN_APRL('$this->vtid_ref','$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
        $FANO = "APPROVAL".$objFinalAppr[0]->FA_NO;

        $objDataList	=	DB::select("select hdr.ARDRCRID,hdr.AR_DOC_NO,hdr.AR_DOC_DT,hdr.AR_TYPE,hdr.REASON_DRCR_NOTE,hdr.INDATE,
                            (
                            SELECT TOP 1 USR.DESCRIPTIONS FROM TBL_TRN_AUDITTRAIL AUD 
                            LEFT JOIN TBL_MST_USER USR ON AUD.USERID=USR.USERID 
                            WHERE  AUD.VID=hdr.ARDRCRID AND  AUD.CYID_REF=hdr.CYID_REF AND  AUD.BRID_REF=hdr.BRID_REF AND  
                            AUD.FYID_REF=hdr.FYID_REF AND  AUD.VTID_REF=hdr.VTID_REF AND AUD.ACTIONNAME='ADD'       
                            ) AS CREATED_BY,
                            hdr.STATUS, sl.SLNAME,sl.SGLCODE,
                            case when a.ACTIONNAME = '$FANO' then 'Final Approved' 
                            else case when a.ACTIONNAME = 'ADD' then 'Added'  
                                when a.ACTIONNAME = 'EDIT' then 'Edited'
                                when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
                                when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
                                when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
                                when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
                                when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
                            when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
                            end end as STATUS_DESC
                            from TBL_TRN_AUDITTRAIL a 
                            inner join TBL_TRN_FNARDRCR_HDR hdr
                            on a.VID = hdr.ARDRCRID 
                            and a.VTID_REF = hdr.VTID_REF 
                            and a.CYID_REF = hdr.CYID_REF 
                            and a.BRID_REF = hdr.BRID_REF
                            inner join TBL_MST_SUBLEDGER sl ON hdr.SLID_REF = sl.SGLID  
                            where a.VTID_REF = '$this->vtid_ref'
                            and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF' AND hdr.FYID_REF='$FYID_REF'
                            and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                            ORDER BY hdr.ARDRCRID DESC ");

                            $REQUEST_DATA   =   array(
                                'FORMID'    =>  $this->form_id,
                                'VTID_REF'  =>  $this->vtid_ref,
                                'USERID'    =>  Auth::user()->USERID,
                                'CYID_REF'  =>  Auth::user()->CYID_REF,
                                'BRID_REF'  =>  Session::get('BRID_REF'),
                                'FYID_REF'  =>  Session::get('FYID_REF'),
                            );

        

        return view($this->view.$FormId,compact(['REQUEST_DATA','objRights','objDataList','FormId']));
    }
	
	public function ViewReport($request) 
    {
        $box = $request;        
        $myValue=  array();
        parse_str($box, $myValue);
       // dd($myValue);  
        $ARDRCRID       =   $myValue['ARDRCRID'];
        $Flag          =   $myValue['Flag'];

         /* $objSalesOrder = DB::table('TBL_TRN_IPO_HDR')
         ->where('TBL_TRN_IPO_HDR.CYID_REF','=',Auth::user()->CYID_REF)
         ->where('TBL_TRN_IPO_HDR.BRID_REF','=',Auth::user()->BRID_REF)
         ->where('TBL_TRN_IPO_HDR.IPO_ID','=',$IPO_ID)
         ->select('TBL_TRN_IPO_HDR.*')
         ->first(); */
        
        
	$ssrs = new \SSRS\Report(Session::get('ssrs_config')['REPORT_URL'], array('username' => Session::get('ssrs_config')['username'], 'password' => Session::get('ssrs_config')['password'])); 
        $result = $ssrs->loadReport('/UNICORN/AR_Voucher_Print');
        
        $reportParameters = array(
            'ARDRCRID' => $ARDRCRID,
        );
        $parameters = new \SSRS\Object\ExecutionParameters($reportParameters);
        
        $ssrs->setSessionId($result->executionInfo->ExecutionID)
        ->setExecutionParameters($parameters);
        if($Flag == 'H')
        {
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
        else if($Flag == 'R')
        {
            $output = $ssrs->render('HTML4.0'); // PDF | XML | CSV | HTML4.0
            echo $output;

        }
         
     }

    public function add(){       
        $Status     = "A";
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');
       
        $objlastdt          =   $this->getLastdt();

        $objsubledger=array();
        //$objsubledger       =   $this->getsubledger();

        $objgeneralledger   =   $this->getgl();

        $objHSN             =   $this->gethsn();
        
       

        $objCostCenter = DB::table('TBL_MST_COSTCENTER')
        ->where('CYID_REF','=',$CYID_REF)
        ->where('STATUS','=','A')
        ->select('TBL_MST_COSTCENTER.*')
        ->get();

        $doc_req    =   array(
            'VTID_REF'=>$this->vtid_ref,
            'HDR_TABLE'=>'TBL_TRN_FNARDRCR_HDR',
            'HDR_ID'=>'ARDRCRID',
            'HDR_DOC_NO'=>'AR_DOC_NO',
            'HDR_DOC_DT'=>'AR_DOC_DT'
        );
        $docarray   =   $this->getManualAutoDocNo(date('Y-m-d'),$doc_req);

        
        $ObjUnionUDF = DB::table("TBL_MST_UDFFOR_AR")->select('*')
                    ->whereIn('PARENTID',function($query) use ($CYID_REF,$BRID_REF,$FYID_REF)
                                {       
                                $query->select('UDF_ARID')->from('TBL_MST_UDFFOR_AR')
                                                ->where('STATUS','=','A')
                                                ->where('PARENTID','=',0)
                                                ->where('DEACTIVATED','=',0)
                                                ->where('CYID_REF','=',$CYID_REF);
                                                                       
                    })->where('DEACTIVATED','=',0)
                    ->where('STATUS','<>','C')                    
                    ->where('CYID_REF','=',$CYID_REF);
                                     
                   

        $objUdfARData = DB::table('TBL_MST_UDFFOR_AR')
            ->where('STATUS','=','A')
            ->where('PARENTID','=',0)
            ->where('DEACTIVATED','=',0)
            ->where('CYID_REF','=',$CYID_REF)
           
            ->union($ObjUnionUDF)
            ->get()->toArray();   
        $objCountUDF = count($objUdfARData);
   
        $FormId     =   $this->form_id;
        $objothcurrency = $this->GetCurrencyMaster(); 
        
        return view($this->view.$FormId.'add',compact(['FormId','objlastdt','objsubledger'
                            ,'objUdfARData','objCountUDF','objgeneralledger','objHSN','objCostCenter','doc_req','docarray','objothcurrency']));       
    }



    // public function getsubledger(){
    //     $Status = "A";
    //     $CYID_REF = Auth::user()->CYID_REF;
    
    //     return  DB::table('TBL_MST_SUBLEDGER')
    //     ->Join('TBL_MST_CUSTOMER', 'TBL_MST_CUSTOMER.SLID_REF','=','TBL_MST_SUBLEDGER.SGLID')
    //     ->where('TBL_MST_SUBLEDGER.CYID_REF','=',$CYID_REF)
    //     ->where('TBL_MST_SUBLEDGER.STATUS','=','A')
    //     ->where('TBL_MST_CUSTOMER.DEACTIVATED','=',"0")
    //     ->select('TBL_MST_SUBLEDGER.*')
    //     ->distinct('TBL_MST_SUBLEDGER.SGLID')
    //     ->get();
    //     }

    public function getsubledger(Request $request){
        $Status = "A";
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $CODE = $request['CODE'];
        $NAME = $request['NAME'];
    
        $sp_popup = [
            $CYID_REF, $BRID_REF,$CODE,$NAME
        ]; 
        
            $ObjData = DB::select('EXEC sp_get_customer_popup_enquiry ?,?,?,?', $sp_popup);
    
            if(!empty($ObjData)){
    
            foreach ($ObjData as $index=>$dataRow){
            
                $row = '';
                $row = $row.'<tr><td class="ROW1"> <input type="checkbox" name="SELECT_CID_REF[]" id="subgl_'.$index.'" class="clssubgl" value="'.$dataRow-> SGLID.'" ></td>';
                $row = $row.'<td class="ROW2">'.$dataRow->SGLCODE;
                $row = $row.'<input type="hidden" id="txtsubgl_'.$index.'" data-desc="'.$dataRow->SGLCODE .' - ';
                $row = $row.$dataRow->SLNAME. '" data-desc2="'.$dataRow->GLID_REF. '"value="'.$dataRow->SGLID.'"/></td><td class="ROW3">'.$dataRow->SLNAME.'</td></tr>';
    
    
                echo $row;
            }
    
            }else{
                echo '<tr><td colspan="2">Record not found.</td></tr>';
            }
            exit();
    
        }


    
    public function getgl(){
        $Status = "A";
        $CYID_REF = Auth::user()->CYID_REF;
        return  DB::select('SELECT GLID, GLCODE, GLNAME, ALIAS FROM TBL_MST_GENERALLEDGER  
                    WHERE STATUS= ? AND SUBLEDGER = ? AND CYID_REF = ? order by GLCODE ASC', 
                    [$Status,'0',$CYID_REF]);
        }

    
    public function gethsn(){
        $Status = "A";
        $CYID_REF = Auth::user()->CYID_REF;

        return  DB::table('TBL_MST_HSN')
        ->Join('TBL_MST_HSNNORMAL', 'TBL_MST_HSNNORMAL.HSNID_REF','=','TBL_MST_HSN.HSNID')
        ->Join('TBL_MST_TAXTYPE', 'TBL_MST_HSNNORMAL.TAXID_REF','=','TBL_MST_TAXTYPE.TAXID')
        ->where('TBL_MST_HSN.CYID_REF','=',$CYID_REF)
        ->where('TBL_MST_TAXTYPE.FOR_SALE','=','1')
        ->where('TBL_MST_HSN.STATUS','=','A')
        ->where('TBL_MST_HSN.DEACTIVATED','=',"0")
        ->select('TBL_MST_HSN.*')
        ->distinct('TBL_MST_HSN.HSNID')
        ->get();

        }
    public function getCostCenter(Request $request){
    
        $customid = $request['customid'];
        $CYID_REF = Auth::user()->CYID_REF;

        $fieldid    = $request['fieldid'];
                
        
        $sp_result = DB::table('TBL_MST_COSTCENTER')
        ->where('CYID_REF','=',$CYID_REF)
        ->where('STATUS','=','A')
        ->select('TBL_MST_COSTCENTER.*')
        ->get(); 
        if(!empty($sp_result)){
            foreach ($sp_result as $index=>$dataRow){
            
                $row = '';
                $row = $row.' <tr >
                <td class="ROW1"> <input type="checkbox" name="SELECT_'.$fieldid.'[]" id="cccode_'.$dataRow->CCID .'"  class="clscccd" value="'.$dataRow->CCID.'" ></td>
                <td class="ROW2">'.$dataRow->CCCODE;
                $row = $row.' <input type="hidden" id="txtcccode_'.$dataRow->CCID.'" data-desc="'.$dataRow->CCCODE .'"  ';
                $row = $row.' value="'.$dataRow->CCID.'"/></td>
                <td class="ROW3">'.$dataRow->NAME.'</td></tr>';

                echo $row;
            }

            }else{
                echo '<tr><td colspan="2">Record not found.</td></tr>';
            }
        exit();
    }

    public function gettax(Request $request){
        $Status = "A";
        $id = $request['id'];
        $taxstate = $request['taxstate'];
        $BRID_REF = Session::get('BRID_REF');
        $CYID_REF = Auth::user()->CYID_REF;

        if ($taxstate == 'WithinState')
        {
            $ObjTax = DB::table('TBL_MST_TAXTYPE')
            ->leftJoin('TBL_MST_HSNNORMAL', 'TBL_MST_HSNNORMAL.TAXID_REF','=','TBL_MST_TAXTYPE.TAXID')
            ->where('TBL_MST_TAXTYPE.CYID_REF','=',$CYID_REF)
            ->where('TBL_MST_TAXTYPE.WITHINSTATE','=','1')
            ->where('TBL_MST_TAXTYPE.OUTOFSTATE','=','0')
            ->where('TBL_MST_TAXTYPE.FOR_SALE','=','1')
            ->where('TBL_MST_TAXTYPE.STATUS','=','A')
            ->where('TBL_MST_HSNNORMAL.HSNID_REF','=',$id)
            ->select('TBL_MST_TAXTYPE.TTCODE','TBL_MST_HSNNORMAL.NRATE')
            ->first(); 
        }
        else
        {
            $ObjTax = DB::table('TBL_MST_TAXTYPE')
            ->leftJoin('TBL_MST_HSNNORMAL', 'TBL_MST_HSNNORMAL.TAXID_REF','=','TBL_MST_TAXTYPE.TAXID')
            ->where('TBL_MST_TAXTYPE.CYID_REF','=',$CYID_REF)
            ->where('TBL_MST_TAXTYPE.WITHINSTATE','=','0')
            ->where('TBL_MST_TAXTYPE.OUTOFSTATE','=','1')
            ->where('TBL_MST_TAXTYPE.FOR_SALE','=','1')
            ->where('TBL_MST_TAXTYPE.STATUS','=','A')
            ->where('TBL_MST_HSNNORMAL.HSNID_REF','=',$id)
            ->select('TBL_MST_TAXTYPE.TTCODE','TBL_MST_HSNNORMAL.NRATE')
            ->first();
        }
        if($ObjTax)
        {
            echo $ObjTax->NRATE;
        }
        else
        {
            echo 0.00;
        }
    }

    public function gettax2(Request $request){
        $Status = "A";
        $id = $request['id'];
        $taxstate = $request['taxstate'];
        $TaxCode1 = $request['TaxCode1'];
        $BRID_REF = Session::get('BRID_REF');
        $CYID_REF = Auth::user()->CYID_REF;

        if ($taxstate == 'WithinState')
        {
            $ObjTax = DB::table('TBL_MST_TAXTYPE')
            ->leftJoin('TBL_MST_HSNNORMAL', 'TBL_MST_HSNNORMAL.TAXID_REF','=','TBL_MST_TAXTYPE.TAXID')
            ->where('TBL_MST_TAXTYPE.CYID_REF','=',$CYID_REF)
            ->where('TBL_MST_TAXTYPE.WITHINSTATE','=','1')
            ->where('TBL_MST_TAXTYPE.OUTOFSTATE','=','0')
            ->where('TBL_MST_TAXTYPE.TTCODE','!=',$TaxCode1)
            ->where('TBL_MST_TAXTYPE.FOR_SALE','=','1')
            ->where('TBL_MST_TAXTYPE.STATUS','=','A')
            ->where('TBL_MST_HSNNORMAL.HSNID_REF','=',$id)
            ->select('TBL_MST_HSNNORMAL.NRATE')
            ->first(); 
        }
        if($ObjTax)
        {
            echo $ObjTax->NRATE;
        }
        else
        {
            echo 0.00;
        }
    }

    public function gettaxCode(Request $request){
        $Status = "A";
        $id = $request['id'];
        $taxstate = $request['taxstate'];
        $BRID_REF = Session::get('BRID_REF');
        $CYID_REF = Auth::user()->CYID_REF;

        if ($taxstate == 'WithinState')
        {
            $ObjTax = DB::table('TBL_MST_TAXTYPE')
            ->leftJoin('TBL_MST_HSNNORMAL', 'TBL_MST_HSNNORMAL.TAXID_REF','=','TBL_MST_TAXTYPE.TAXID')
            ->where('TBL_MST_TAXTYPE.CYID_REF','=',$CYID_REF)
            ->where('TBL_MST_TAXTYPE.WITHINSTATE','=','1')
            ->where('TBL_MST_TAXTYPE.OUTOFSTATE','=','0')
            ->where('TBL_MST_TAXTYPE.FOR_SALE','=','1')
            ->where('TBL_MST_TAXTYPE.STATUS','=','A')
            ->where('TBL_MST_HSNNORMAL.HSNID_REF','=',$id)
            ->select('TBL_MST_TAXTYPE.TTCODE','TBL_MST_HSNNORMAL.NRATE')
            ->first(); 
        }
        else
        {
            $ObjTax = DB::table('TBL_MST_TAXTYPE')
            ->leftJoin('TBL_MST_HSNNORMAL', 'TBL_MST_HSNNORMAL.TAXID_REF','=','TBL_MST_TAXTYPE.TAXID')
            ->where('TBL_MST_TAXTYPE.CYID_REF','=',$CYID_REF)
            ->where('TBL_MST_TAXTYPE.WITHINSTATE','=','0')
            ->where('TBL_MST_TAXTYPE.OUTOFSTATE','=','1')
            ->where('TBL_MST_TAXTYPE.FOR_SALE','=','1')
            ->where('TBL_MST_TAXTYPE.STATUS','=','A')
            ->where('TBL_MST_HSNNORMAL.HSNID_REF','=',$id)
            ->select('TBL_MST_TAXTYPE.TTCODE','TBL_MST_HSNNORMAL.NRATE')
            ->first();
        }
        if($ObjTax)
        {
            echo $ObjTax->TTCODE;
        }
        else
        {
            echo '';
        }
    }

    public function getShipTo(Request $request){
        $Status = "A";
        $id = $request['id'];
        $BRID_REF = Session::get('BRID_REF');
        

        $ObjCust =  DB::select('SELECT top 1 CID FROM TBL_MST_CUSTOMER  
                    WHERE STATUS= ? AND SLID_REF = ? ', [$Status,$id]);
    
        $cid = $ObjCust[0]->CID;
        $ObjSHIPTO =  DB::select('SELECT top 1 * FROM TBL_MST_CUSTOMERLOCATION  
                    WHERE DEFAULT_SHIPTO= ? AND CID_REF = ? ', [1,$cid]);

        $ObjBranch =  DB::select('SELECT top 1 STID_REF FROM TBL_MST_BRANCH  
        WHERE BRID= ? ', [$BRID_REF]);

        if($ObjSHIPTO[0]->STID_REF == $ObjBranch[0]->STID_REF)
        {
            echo 'WithinState';
        }
        else
        {
            echo 'OutofState';
        }
    }

    public function getTDSApplicability(Request $request){
        $Status = "A";
        $id = $request['id'];
        $BRID_REF = Session::get('BRID_REF');
        

        $ObjCust =  DB::select('SELECT top 1 * FROM TBL_MST_CUSTOMER  
                    WHERE STATUS= ? AND SLID_REF = ? ', [$Status,$id]);
    
        if($ObjCust)
        {
            echo $ObjCust[0]->TDS_APPLICABLE;
        }
        else
        {
            echo '0';
        }
    }

    public function getTDSDetails(Request $request){
        $Status = "A";
        $id = $request['id'];
        $BRID_REF = Session::get('BRID_REF');
        
        $sp_param = [ 
            $id,$BRID_REF
        ];  

        $sp_result = DB::select('EXEC SP_GET_CUSTOMER_TDSDETAILS ?,?', $sp_param);
        
        if($sp_result)
        {
            foreach ($sp_result as $index=>$dataRow){
            
                $row = '';
                $row = $row.'<tr class="participantRow3">
                <td style="text-align:center;">
                <input type="text" name="txtTDS_'.$index.'" id="txtTDS_'.$index.'" class="form-control" value="'.$dataRow->CODE.'"  autocomplete="off"  readonly/></td>
                <td hidden><input type="hidden" name="TDSID_REF_'.$index.'" id="TDSID_REF_'.$index.'" class="form-control" value="'.$dataRow->HOLDINGID.'" autocomplete="off" /></td>
                <td><input type="text" name="TDSLedger_'.$index.'" id="TDSLedger_'.$index.'" value="'.$dataRow->CODE_DESC.'" class="form-control"  autocomplete="off"  readonly/></td>
                <td style="text-align:center;"><input type="checkbox" name="TDSApplicable_'.$index.'" id="TDSApplicable_'.$index.'" /></td>
                <td><input type="text" name="ASSESSABLE_VL_TDS_'.$index.'" id="ASSESSABLE_VL_TDS_'.$index.'"  class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
                <td><input type="text" name="TDS_RATE_'.$index.'" id="TDS_RATE_'.$index.'" value="'.$dataRow->TDS_RATE.'" class="form-control four-digits" maxlength="12"  autocomplete="off"  readonly/></td>
                <td hidden><input type="hidden" name="TDS_EXEMPT_'.$index.'" id="TDS_EXEMPT_'.$index.'" class="form-control two-digits" value="'.$dataRow->TDS_EXEMP_LIMIT.'" /></td>
                <td><input type="text" name="TDS_AMT_'.$index.'" id="TDS_AMT_'.$index.'" class="form-control two-digits" maxlength="15"  autocomplete="off" readonly /></td>
                <td><input type="text" name="ASSESSABLE_VL_SURCHARGE_'.$index.'" id="ASSESSABLE_VL_SURCHARGE_'.$index.'"  class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
                <td><input type="text" name="SURCHARGE_RATE_'.$index.'" id="SURCHARGE_RATE_'.$index.'" value="'.$dataRow->SURCHARGE_RAGE.'" class="form-control four-digits" maxlength="12"  autocomplete="off" readonly /></td>
                <td hidden><input type="hidden" name="SURCHARGE_EXEMPT_'.$index.'" id="SURCHARGE_EXEMPT_'.$index.'" class="form-control two-digits" value="'.$dataRow->SURCHARGE_EXEMP_LIMIT.'" /></td>
                <td><input type="text" name="SURCHARGE_AMT_'.$index.'" id="SURCHARGE_AMT_'.$index.'" class="form-control two-digits" maxlength="15"  autocomplete="off" readonly /></td>
                <td><input type="text" name="ASSESSABLE_VL_CESS_'.$index.'" id="ASSESSABLE_VL_CESS_'.$index.'"  class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
                <td><input type="text" name="CESS_RATE_'.$index.'" id="CESS_RATE_'.$index.'" value="'.$dataRow->CESS_RATE.'" class="form-control four-digits" maxlength="12"  autocomplete="off"  readonly/></td>
                <td hidden><input type="hidden" name="CESS_EXEMPT_'.$index.'" id="CESS_EXEMPT_'.$index.'" class="form-control two-digits" value="'.$dataRow->CESS_EXEMP_LIMIT.'" /></td>
                <td><input type="text" name="CESS_AMT_'.$index.'" id="CESS_AMT_'.$index.'" class="form-control two-digits" maxlength="15"  autocomplete="off" readonly /></td>
                <td><input type="text" name="ASSESSABLE_VL_SPCESS_'.$index.'" id="ASSESSABLE_VL_SPCESS_'.$index.'"  class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
                <td><input type="text" name="SPCESS_RATE_'.$index.'" id="SPCESS_RATE_'.$index.'" value="'.$dataRow->SP_CESS_RATE.'" class="form-control four-digits" maxlength="12"  autocomplete="off" readonly /></td>
                <td hidden><input type="hidden" name="SPCESS_EXEMPT_'.$index.'" id="SPCESS_EXEMPT_'.$index.'" class="form-control two-digits" value="'.$dataRow->SP_CESS_EXEMP_LIMIT.'" /></td>
                <td><input type="text" name="SPCESS_AMT_'.$index.'" id="SPCESS_AMT_'.$index.'" class="form-control two-digits" maxlength="15"  autocomplete="off" readonly /></td>
                <td><input type="text" name="TOT_TD_AMT_'.$index.'" id="TOT_TD_AMT_'.$index.'" class="form-control two-digits" maxlength="15"  autocomplete="off" readonly /></td>
                <td style="min-width: 100px;"><button class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                <button class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button></td>
              </tr>
              <tr></tr>';

                echo $row;
            }

            }else{
                echo '<tr  class="participantRow3">
                <td style="text-align:center;" >
                <input type="text" name="txtTDS_0" id="txtTDS_0" class="form-control"  autocomplete="off"  readonly/></td>
                <td hidden><input type="hidden" name="TDSID_REF_0" id="TDSID_REF_0" class="form-control" autocomplete="off" /></td>
                <td><input type="text" name="TDSLedger_0" id="TDSLedger_0" class="form-control"  autocomplete="off"  readonly/></td>
                <td  align="center" style="text-align:center;" ><input type="checkbox" name="TDSApplicable_0" id="TDSApplicable_0" /></td>
                <td><input type="text" name="ASSESSABLE_VL_TDS_0" id="ASSESSABLE_VL_TDS_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  /></td>
                <td><input type="text" name="TDS_RATE_0" id="TDS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                <td hidden><input type="hidden" name="TDS_EXEMPT_0" id="TDS_EXEMPT_0" class="form-control two-digits" /></td>
                <td><input type="text" name="TDS_AMT_0" id="TDS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                <td><input type="text" name="ASSESSABLE_VL_SURCHARGE_0" id="ASSESSABLE_VL_SURCHARGE_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                <td><input type="text" name="SURCHARGE_RATE_0" id="SURCHARGE_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                <td hidden><input type="hidden" name="SURCHARGE_EXEMPT_0" id="SURCHARGE_EXEMPT_0" class="form-control two-digits" /></td>
                <td><input type="text" name="SURCHARGE_AMT_0" id="SURCHARGE_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                <td><input type="text" name="ASSESSABLE_VL_CESS_0" id="ASSESSABLE_VL_CESS_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                <td><input type="text" name="CESS_RATE_0" id="CESS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                <td hidden><input type="hidden" name="CESS_EXEMPT_0" id="CESS_EXEMPT_0" class="form-control two-digits" /></td>
                <td><input type="text" name="CESS_AMT_0" id="CESS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                <td><input type="text" name="ASSESSABLE_VL_SPCESS_0" id="ASSESSABLE_VL_SPCESS_0" class="form-control two-digits" maxlength="15"  autocomplete="off" /></td>
                <td><input type="text" name="SPCESS_RATE_0" id="SPCESS_RATE_0" class="form-control four-digits" maxlength="12"  autocomplete="off"  /></td>
                <td hidden><input type="hidden" name="SPCESS_EXEMPT_0" id="SPCESS_EXEMPT_0" class="form-control two-digits" /></td>
                <td><input type="text" name="SPCESS_AMT_0" id="SPCESS_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                <td><input type="text" name="TOT_TD_AMT_0" id="TOT_TD_AMT_0" class="form-control two-digits" maxlength="15"  autocomplete="off"  readonly/></td>
                <td style="min-width: 100px;"><button class="btn add" title="add" data-toggle="tooltip" type="button"><i class="fa fa-plus"></i></button>
                <button class="btn remove" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash" ></i></button></td>
            </tr>
            <tr></tr>';
            }
        exit();
    }

    public function save(Request $request) {
        // dd($request->all());
        $r_count1 = $request['Row_Count1'];
        $r_count2 = $request['Row_Count2'];
        $r_count3 = $request['Row_Count3'];
        $r_count4 = $request['Row_Count4'];
        $GROSS_TOTAL    =   0; 
        $NET_TOTAL 		= 	$request['tot_amt'];
        $CGSTAMT        =   0; 
        $SGSTAMT        =   0; 
        $IGSTAMT        =   0; 
        $DISCOUNT       =   0; 
        $TDS_AMOUNT     =   0; 	
        $FC 		    = (isset($request['FC'])!="true" ? 0 : 1);
        $CRID_REF 		= (isset($request['CRID_REF'])) ? $request['CRID_REF'] : 0;
        $CONVFACT 		= (isset($request['CONVFACT'])) ? $request['CONVFACT'] : "";
        
        for ($i=0; $i<=$r_count1; $i++)
        {
            if(isset($request['GLID_REF_'.$i]))
            {
                $req_data[$i] = [
                    'GLID_REF'          => $request['GLID_REF_'.$i],
                    'AMT'               => (!is_null($request['GL_AMT_'.$i]) ? $request['GL_AMT_'.$i] : 0),
                    'DISC_PER'          => (!is_null($request['DISC_PER_'.$i]) ? $request['DISC_PER_'.$i] : 0),
                    'DISC_AMT'          => (!is_null($request['DISC_AMT_'.$i]) ? $request['DISC_AMT_'.$i] : 0),
                    'HSNID_REF'         => (isset($request['HSNID_REF_'.$i]) ? $request['HSNID_REF_'.$i] : ''),
                    'IGST'              => (!is_null($request['IGST_'.$i]) ? $request['IGST_'.$i] : 0),
                    'CGST'              => (!is_null($request['CGST_'.$i]) ? $request['CGST_'.$i] : 0),
                    'SGST'              => (!is_null($request['SGST_'.$i]) ? $request['SGST_'.$i] : 0),
                    'CCID_REF'          => (isset($request['CCID_REF_'.$i]) ? $request['CCID_REF_'.$i] : ''),
                    'REMARKS'           => (isset($request['REMARKS_'.$i]) ? $request['REMARKS_'.$i] : ''),
                ];
            }
        }

        $wrapped_links["DET"] = $req_data; 
        $XMLACC = ArrayToXml::convert($wrapped_links);

        for ($i=0; $i<=$r_count2; $i++)
        {
            if(isset($request['UDF_ARID_REF_'.$i]) && !is_null($request['UDF_ARID_REF_'.$i]))
            {
                $reqdata2[$i] = [
                    'UDF_ARID_REF'   => $request['UDF_ARID_REF_'.$i],
                    'VALUE'         => $request['udfvalue_'.$i],
                ];
            }
        }

        if(isset($reqdata2))
        { 
            $wrapped_links2["UDF"] = $reqdata2; 
            $XMLUDF = ArrayToXml::convert($wrapped_links2);
        }
        else
        {
            $XMLUDF = NULL; 
        }

        for ($i=0; $i<=$r_count3; $i++)
        {
            if(isset($request['GLID_'.$i]) && !is_null($request['GLID_'.$i]))
            {
                $reqdata3[$i] = [
                    'GLID_REF'   => $request['GLID_'.$i],
                    'AMT'        => (!is_null($request['CC_AMT_'.$i]) ? $request['CC_AMT_'.$i] : 0),
                    'CCID_REF'   => $request['CCID_'.$i],
                    'REMARKS'    => (!is_null($request['CC_RMKS_'.$i]) ? $request['CC_RMKS_'.$i] : ''),
                ];
            }
        }

        if(isset($reqdata3))
        { 
            $wrapped_links3["CCD"] = $reqdata3; 
            $XMLCCD = ArrayToXml::convert($wrapped_links3);
        }
        else
        {
            $XMLCCD = NULL; 
        }

        for ($i=0; $i<=$r_count4; $i++)
        {
            if(isset($request['TDSID_REF_'.$i]))
            {
                $reqdata4[$i] = [
                    'TDSID_REF'                 => $request['TDSID_REF_'.$i],
                    'ASSESSABLE_VL_TDS'         => (!is_null($request['ASSESSABLE_VL_TDS_'.$i]) ? $request['ASSESSABLE_VL_TDS_'.$i] : 0),
                    'TDS_RATE'                  => (!is_null($request['TDS_RATE_'.$i]) ? $request['TDS_RATE_'.$i] : 0),
                    'ASSESSABLE_VL_SURCHARGE'   => (!is_null($request['ASSESSABLE_VL_SURCHARGE_'.$i]) ? $request['ASSESSABLE_VL_SURCHARGE_'.$i] : 0),
                    'SURCHARGE_RATE'            => (!is_null($request['SURCHARGE_RATE_'.$i]) ? $request['SURCHARGE_RATE_'.$i] : 0),
                    'ASSESSABLE_VL_CESS'        => (!is_null($request['ASSESSABLE_VL_CESS_'.$i]) ? $request['ASSESSABLE_VL_CESS_'.$i] : 0),
                    'CESS_RATE'                 => (!is_null($request['CESS_RATE_'.$i]) ? $request['CESS_RATE_'.$i] : 0),
                    'ASSESSABLE_VL_SPCESS'      => (!is_null($request['ASSESSABLE_VL_SPCESS_'.$i]) ? $request['ASSESSABLE_VL_SPCESS_'.$i] : 0),
                    'SPCESS_RATE'               => (!is_null($request['SPCESS_RATE_'.$i]) ? $request['SPCESS_RATE_'.$i] : 0),
                ];
            }
        }
        if(isset($reqdata4))
        { 
            $wrapped_links4["TDSD"] = $reqdata4; 
            $XMLTDSD = ArrayToXml::convert($wrapped_links4);
        }
        else
        {
            $XMLTDSD = NULL; 
        }

        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = 'ADD';
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $AR_DOC_NO              = $request['AR_DOC_NO'];
        $AR_DOC_DT              = $request['AR_DOC_DT'];
        $CID_REF                = $request['CID_REF'];
        $AR_TYPE                = $request['AR_TYPE'];
        $REF_NO                 = $request['REF_NO'];
        $REF_DT                 = $request['REF_DT '];
        $REASON_DRCR_NOTE       = $request['REASON_DRCR_NOTE'];
        $COMMON_NARRATION       = $request['COMMON_NARRATION'];
        $TDS                    = ($request['drpTDS'] == 'Yes'? 1 : 0);
       
        $log_data = [ 
            $AR_DOC_NO,$AR_DOC_DT,$CID_REF,$AR_TYPE,$REF_NO,$REF_DT,$REASON_DRCR_NOTE,$COMMON_NARRATION,$TDS,$CYID_REF,$BRID_REF,
            $FYID_REF,$VTID_REF,$XMLACC,$XMLCCD,$XMLTDSD,$XMLUDF,$USERID,Date('Y-m-d'),Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS
            ,$FC,$CRID_REF,$CONVFACT,$GROSS_TOTAL,$NET_TOTAL,$CGSTAMT,$SGSTAMT,$IGSTAMT,$DISCOUNT,$TDS_AMOUNT
        ];  

        $sp_result = DB::select('EXEC SP_AR_CREDIT_DEBIIT_NOTE_IN ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?', $log_data);  

        // dd($sp_result);
        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
            if($contains){
                return Response::json(['success' =>true,'msg' => $sp_result[0]->RESULT]);
    
            }else{
                return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
            }
            exit();    
    }


    public function edit($id=NULL){
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF'); 
        $Status     =   'A';
        
        if(!is_null($id)){

                $objARDRCR = DB::table('TBL_TRN_FNARDRCR_HDR')
                        ->where('TBL_TRN_FNARDRCR_HDR.FYID_REF','=',$FYID_REF)
                        ->where('TBL_TRN_FNARDRCR_HDR.CYID_REF','=',$CYID_REF)
                        ->where('TBL_TRN_FNARDRCR_HDR.BRID_REF','=',$BRID_REF)
                        ->where('TBL_TRN_FNARDRCR_HDR.ARDRCRID','=',$id)
                        ->leftJoin('TBL_MST_CURRENCY', 'TBL_TRN_FNARDRCR_HDR.CRID_REF','=','TBL_MST_CURRENCY.CRID')
                        ->select('TBL_TRN_FNARDRCR_HDR.*','TBL_MST_CURRENCY.CRDESCRIPTION','TBL_MST_CURRENCY.CRCODE')
                        ->first();

               
                $objARDRCRSL =[];
                if(isset($objARDRCR->SLID_REF) && $objARDRCR->SLID_REF !=""){
                    $objARDRCRSL = DB::table('TBL_MST_SUBLEDGER')
                    ->where('CYID_REF','=',Auth::user()->CYID_REF)
                    ->where('BRID_REF','=',Session::get('BRID_REF'))
                    ->where('BELONGS_TO','=','Customer')
                    ->where('SGLID','=',$objARDRCR->SLID_REF)
                    ->select('TBL_MST_SUBLEDGER.SGLCODE','TBL_MST_SUBLEDGER.SLNAME')
                    ->first();
                }


                

                
                $ObjCust =[];
                if(isset($objARDRCR->SLID_REF) && $objARDRCR->SLID_REF !=""){
                    $ObjCust =  DB::select('SELECT top 1 CID FROM TBL_MST_CUSTOMER WHERE STATUS= ? AND SLID_REF = ? ', [$Status,$objARDRCR->SLID_REF]);
                }
                
                $ObjSHIPTO  =[];
                if(isset($ObjCust[0]->CID) && $ObjCust[0]->CID !=""){
                    $cid        =   $ObjCust[0]->CID;
                    $ObjSHIPTO  =   DB::select('SELECT top 1 * FROM TBL_MST_CUSTOMERLOCATION  WHERE DEFAULT_SHIPTO= ? AND CID_REF = ? ', [1,$cid]);
                }
        
                $ObjBranch =  DB::select('SELECT top 1 STID_REF FROM TBL_MST_BRANCH  WHERE BRID= ? ', [$BRID_REF]);
        
                if(isset($ObjSHIPTO[0]->STID_REF) && $ObjSHIPTO[0]->STID_REF == $ObjBranch[0]->STID_REF){
                    $objtaxstate =  'WithinState';
                }
                else
                {
                    $objtaxstate =  'OutofState';
                }

                $log_data = [ 
                    $id
                ];
                
                $objARDRCRACC = DB::select('EXEC SP_GET_ARCRDR_ACCOUNTS ?', $log_data);
                            
                                // DD($objSEMAT); 
                $objCount1 = count($objARDRCRACC);  
                
                $objARDRCRUDF = DB::table('TBL_TRN_FNARDRCR_UDF')                    
                                ->where('TBL_TRN_FNARDRCR_UDF.ARDRCRID_REF','=',$id)
                                ->get()->toArray();
                
                $objCount2 = count($objARDRCRUDF);

                $objARDRCRCCD = DB::table('TBL_TRN_FNARDRCR_CCD')                    
                                ->where('TBL_TRN_FNARDRCR_CCD.ARDRCRID_REF','=',$id)
                                ->get()->toArray();
                
                $objCount3 = count($objARDRCRCCD);

                $objARDRCRTDS = DB::select('EXEC SP_GET_ARCRDR_TDS ?', $log_data);
                
                $objCount4 = count($objARDRCRTDS);
        
                $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

                                $ObjUnionUDF = DB::table("TBL_MST_UDFFOR_AR")->select('*')
                                ->whereIn('PARENTID',function($query) use ($CYID_REF,$BRID_REF,$FYID_REF)
                                            {       
                                            $query->select('UDF_ARID')->from('TBL_MST_UDFFOR_AR')
                                                            ->where('STATUS','=','A')
                                                            ->where('PARENTID','=',0)
                                                            ->where('DEACTIVATED','=',0)
                                                            ->where('CYID_REF','=',$CYID_REF);
                                                                               
                                })->where('DEACTIVATED','=',0)
                                ->where('STATUS','<>','C')                    
                                ->where('CYID_REF','=',$CYID_REF);
                                               
                                
            
                    $objUdfARData = DB::table('TBL_MST_UDFFOR_AR')
                        ->where('STATUS','=','A')
                        ->where('PARENTID','=',0)
                        ->where('DEACTIVATED','=',0)
                        ->where('CYID_REF','=',$CYID_REF)
                        ->union($ObjUnionUDF)
                        ->get()->toArray();   
                    $objCountUDF = count($objUdfARData);

                    $objlastdt          =   $this->getLastdt();

                    $objsubledger=array();
                    //$objsubledger       =   $this->getsubledger();

                    $objgeneralledger   =   $this->getgl();

                    $objHSN             =   $this->gethsn();    
                    
                    $objCostCenter = DB::table('TBL_MST_COSTCENTER')
                    ->where('CYID_REF','=',$CYID_REF)
                    ->where('STATUS','=','A')
                    ->select('TBL_MST_COSTCENTER.*')
                    ->get();

            $FormId         =   $this->form_id;
            $ActionStatus   =   "";
            $objothcurrency = $this->GetCurrencyMaster(); 
            
            return view($this->view.$FormId.'edit',compact(['FormId','objRights','objARDRCR','objARDRCRACC','objARDRCRUDF','objARDRCRCCD','objtaxstate',
                'objARDRCRSL','objARDRCRTDS','objCount1','objCount2','objCount3','objCount4','objUdfARData','objCountUDF','objlastdt',
                'objsubledger','objgeneralledger','objHSN','objCostCenter','ActionStatus','objothcurrency']));      

        }
     
    }

    public function update(Request $request){
        
        $r_count1 = $request['Row_Count1'];
        $r_count2 = $request['Row_Count2'];
        $r_count3 = $request['Row_Count3'];
        $r_count4 = $request['Row_Count4'];
        $GROSS_TOTAL        =   0; 
        $NET_TOTAL 		    = 	$request['tot_amt'];
        $CGSTAMT        	=   0; 
        $SGSTAMT        	=   0; 
        $IGSTAMT        	=   0; 
        $DISCOUNT       	=   0; 
        $TDS_AMOUNT     	=   0; 	
        $FC 		        = (isset($request['FC'])!="true" ? 0 : 1);
        $CRID_REF 		    = (isset($request['CRID_REF'])) ? $request['CRID_REF'] : 0;
        $CONVFACT 		    = (isset($request['CONVFACT'])) ? $request['CONVFACT'] : "";
        
        for ($i=0; $i<=$r_count1; $i++)
        {
            if(isset($request['GLID_REF_'.$i]))
            {
                $GROSS_TOTAL+= $request['TAX_AMT_'.$i]; 
                $CGSTAMT+= $request['CGST_AMT_'.$i]; 
                $SGSTAMT+= $request['SGST_AMT_'.$i]; 
                $IGSTAMT+= $request['IGST_AMT_'.$i]; 
                $DISCOUNT+= $request['DISC_AMT_'.$i]; 

                $req_data[$i] = [
                    'GLID_REF'          => $request['GLID_REF_'.$i],
                    'AMT'               => (!is_null($request['GL_AMT_'.$i]) ? $request['GL_AMT_'.$i] : 0),
                    'DISC_PER'          => (!is_null($request['DISC_PER_'.$i]) ? $request['DISC_PER_'.$i] : 0),
                    'DISC_AMT'          => (!is_null($request['DISC_AMT_'.$i]) ? $request['DISC_AMT_'.$i] : 0),
                    'HSNID_REF'         => (isset($request['HSNID_REF_'.$i]) ? $request['HSNID_REF_'.$i] : ''),
                    'IGST'              => (!is_null($request['IGST_'.$i]) ? $request['IGST_'.$i] : 0),
                    'CGST'              => (!is_null($request['CGST_'.$i]) ? $request['CGST_'.$i] : 0),
                    'SGST'              => (!is_null($request['SGST_'.$i]) ? $request['SGST_'.$i] : 0),
                    'CCID_REF'          => (isset($request['CCID_REF_'.$i]) ? $request['CCID_REF_'.$i] : ''),
                    'REMARKS'           => (isset($request['REMARKS_'.$i]) ? $request['REMARKS_'.$i] : ''),
                ];
            }
        }

        $wrapped_links["DET"] = $req_data; 
        $XMLACC = ArrayToXml::convert($wrapped_links);

        for ($i=0; $i<=$r_count2; $i++)
        {
            if(isset($request['UDF_ARID_REF_'.$i]) && !is_null($request['UDF_ARID_REF_'.$i]))
            {
                $reqdata2[$i] = [
                    'UDF_ARID_REF'   => $request['UDF_ARID_REF_'.$i],
                    'VALUE'         => $request['udfvalue_'.$i],
                ];
            }
        }

        if(isset($reqdata2))
        { 
            $wrapped_links2["UDF"] = $reqdata2; 
            $XMLUDF = ArrayToXml::convert($wrapped_links2);
        }
        else
        {
            $XMLUDF = NULL; 
        }

        for ($i=0; $i<=$r_count3; $i++)
        {
            if(isset($request['GLID_'.$i]) && !is_null($request['GLID_'.$i]))
            {
                $reqdata3[$i] = [
                    'GLID_REF'   => $request['GLID_'.$i],
                    'AMT'        => (!is_null($request['CC_AMT_'.$i]) ? $request['CC_AMT_'.$i] : 0),
                    'CCID_REF'   => $request['CCID_'.$i],
                    'REMARKS'    => (!is_null($request['CC_RMKS_'.$i]) ? $request['CC_RMKS_'.$i] : ''),
                ];
            }
        }

        if(isset($reqdata3))
        { 
            $wrapped_links3["CCD"] = $reqdata3; 
            $XMLCCD = ArrayToXml::convert($wrapped_links3);
        }
        else
        {
            $XMLCCD = NULL; 
        }

        for ($i=0; $i<=$r_count4; $i++)
        {
            if(isset($request['TDSID_REF_'.$i]))
            {
                if(isset($request['drpTDS']) && $request['drpTDS'] == 'Yes'? 1 : 0==1){
                    $TDS_AMOUNT      += $request['TDS_AMT_'.$i]; 
                    }
                $reqdata4[$i] = [
                    'TDSID_REF'                 => $request['TDSID_REF_'.$i],
                    'ASSESSABLE_VL_TDS'         => (!is_null($request['ASSESSABLE_VL_TDS_'.$i]) ? $request['ASSESSABLE_VL_TDS_'.$i] : 0),
                    'TDS_RATE'                  => (!is_null($request['TDS_RATE_'.$i]) ? $request['TDS_RATE_'.$i] : 0),
                    'ASSESSABLE_VL_SURCHARGE'   => (!is_null($request['ASSESSABLE_VL_SURCHARGE_'.$i]) ? $request['ASSESSABLE_VL_SURCHARGE_'.$i] : 0),
                    'SURCHARGE_RATE'            => (!is_null($request['SURCHARGE_RATE_'.$i]) ? $request['SURCHARGE_RATE_'.$i] : 0),
                    'ASSESSABLE_VL_CESS'        => (!is_null($request['ASSESSABLE_VL_CESS_'.$i]) ? $request['ASSESSABLE_VL_CESS_'.$i] : 0),
                    'CESS_RATE'                 => (!is_null($request['CESS_RATE_'.$i]) ? $request['CESS_RATE_'.$i] : 0),
                    'ASSESSABLE_VL_SPCESS'      => (!is_null($request['ASSESSABLE_VL_SPCESS_'.$i]) ? $request['ASSESSABLE_VL_SPCESS_'.$i] : 0),
                    'SPCESS_RATE'               => (!is_null($request['SPCESS_RATE_'.$i]) ? $request['SPCESS_RATE_'.$i] : 0),
                ];
            }
        }
        if(isset($reqdata4))
        { 
            $wrapped_links4["TDSD"] = $reqdata4; 
            $XMLTDSD = ArrayToXml::convert($wrapped_links4);
        }
        else
        {
            $XMLTDSD = NULL; 
        }

        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = 'EDIT';
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $AR_DOC_NO              = $request['AR_DOC_NO'];
        $AR_DOC_DT              = $request['AR_DOC_DT'];
        $CID_REF                = $request['CID_REF'];
        $AR_TYPE                = $request['AR_TYPE'];
        $REF_NO                 = $request['REF_NO'];
        $REF_DT                 = $request['REF_DT '];
        $REASON_DRCR_NOTE       = $request['REASON_DRCR_NOTE'];
        $COMMON_NARRATION       = $request['COMMON_NARRATION'];
        $TDS                    = ($request['drpTDS'] == 'Yes'? 1 : 0);
        
       
        $log_data = [ 
            $AR_DOC_NO,$AR_DOC_DT,$CID_REF,$AR_TYPE,$REF_NO,$REF_DT,$REASON_DRCR_NOTE,$COMMON_NARRATION,$TDS,$CYID_REF,$BRID_REF,
            $FYID_REF,$VTID_REF,$XMLACC,$XMLCCD,$XMLTDSD,$XMLUDF,$USERID,Date('Y-m-d'),Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS
            ,$FC,$CRID_REF,$CONVFACT,$GROSS_TOTAL,$NET_TOTAL,$CGSTAMT,$SGSTAMT,$IGSTAMT,$DISCOUNT,$TDS_AMOUNT
        ];  

        $sp_result = DB::select('EXEC SP_AR_CREDIT_DEBIIT_NOTE_UP ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?', $log_data);  


        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => 'AR '.$AR_TYPE. ' Sucessfully Updated.']);

        }else{
            return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
        }
        exit();   
    }

    public function view($id=NULL){
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF'); 
        $Status     =   'A';
        
        if(!is_null($id)){

            $objARDRCR = DB::table('TBL_TRN_FNARDRCR_HDR')
                        ->where('TBL_TRN_FNARDRCR_HDR.FYID_REF','=',$FYID_REF)
                        ->where('TBL_TRN_FNARDRCR_HDR.CYID_REF','=',$CYID_REF)
                        ->where('TBL_TRN_FNARDRCR_HDR.BRID_REF','=',$BRID_REF)
                        ->where('TBL_TRN_FNARDRCR_HDR.ARDRCRID','=',$id)
                        ->leftJoin('TBL_MST_CURRENCY', 'TBL_TRN_FNARDRCR_HDR.CRID_REF','=','TBL_MST_CURRENCY.CRID')
                        ->select('TBL_TRN_FNARDRCR_HDR.*','TBL_MST_CURRENCY.CRDESCRIPTION','TBL_MST_CURRENCY.CRCODE')
                        ->first();

                        $objARDRCRSL =[];
                        if(isset($objARDRCR->SLID_REF) && $objARDRCR->SLID_REF !=""){
                            $objARDRCRSL = DB::table('TBL_MST_SUBLEDGER')
                            ->where('CYID_REF','=',Auth::user()->CYID_REF)
                            ->where('BRID_REF','=',Session::get('BRID_REF'))
                            ->where('BELONGS_TO','=','Customer')
                            ->where('SGLID','=',$objARDRCR->SLID_REF)
                            ->select('TBL_MST_SUBLEDGER.SGLCODE','TBL_MST_SUBLEDGER.SLNAME')
                            ->first();
                        }
                
                $ObjCust =[];
                if(isset($objARDRCR->SLID_REF) && $objARDRCR->SLID_REF !=""){
                    $ObjCust =  DB::select('SELECT top 1 CID FROM TBL_MST_CUSTOMER WHERE STATUS= ? AND SLID_REF = ? ', [$Status,$objARDRCR->SLID_REF]);
                }
                
                $ObjSHIPTO  =[];
                if(isset($ObjCust[0]->CID) && $ObjCust[0]->CID !=""){
                    $cid        =   $ObjCust[0]->CID;
                    $ObjSHIPTO  =   DB::select('SELECT top 1 * FROM TBL_MST_CUSTOMERLOCATION  WHERE DEFAULT_SHIPTO= ? AND CID_REF = ? ', [1,$cid]);
                }
        
                $ObjBranch =  DB::select('SELECT top 1 STID_REF FROM TBL_MST_BRANCH  WHERE BRID= ? ', [$BRID_REF]);
        
                if(isset($ObjSHIPTO[0]->STID_REF) && $ObjSHIPTO[0]->STID_REF == $ObjBranch[0]->STID_REF){
                    $objtaxstate =  'WithinState';
                }
                else
                {
                    $objtaxstate =  'OutofState';
                }

                $log_data = [ 
                    $id
                ];
                
                $objARDRCRACC = DB::select('EXEC SP_GET_ARCRDR_ACCOUNTS ?', $log_data);
                            
                                // DD($objSEMAT); 
                $objCount1 = count($objARDRCRACC);  
                
                $objARDRCRUDF = DB::table('TBL_TRN_FNARDRCR_UDF')                    
                                ->where('TBL_TRN_FNARDRCR_UDF.ARDRCRID_REF','=',$id)
                                ->get()->toArray();
                
                $objCount2 = count($objARDRCRUDF);

                $objARDRCRCCD = DB::table('TBL_TRN_FNARDRCR_CCD')                    
                                ->where('TBL_TRN_FNARDRCR_CCD.ARDRCRID_REF','=',$id)
                                ->get()->toArray();
                
                $objCount3 = count($objARDRCRCCD);

                $objARDRCRTDS = DB::select('EXEC SP_GET_ARCRDR_TDS ?', $log_data);
                
                $objCount4 = count($objARDRCRTDS);
        
                $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);
                
                                $ObjUnionUDF = DB::table("TBL_MST_UDFFOR_AR")->select('*')
                                ->whereIn('PARENTID',function($query) use ($CYID_REF,$BRID_REF,$FYID_REF)
                                            {       
                                            $query->select('UDF_ARID')->from('TBL_MST_UDFFOR_AR')
                                                            ->where('STATUS','=','A')
                                                            ->where('PARENTID','=',0)
                                                            ->where('DEACTIVATED','=',0)
                                                            ->where('CYID_REF','=',$CYID_REF);
                                                                               
                                })->where('DEACTIVATED','=',0)
                                ->where('STATUS','<>','C')                    
                                ->where('CYID_REF','=',$CYID_REF);
                                               
                                
            
                    $objUdfARData = DB::table('TBL_MST_UDFFOR_AR')
                        ->where('STATUS','=','A')
                        ->where('PARENTID','=',0)
                        ->where('DEACTIVATED','=',0)
                        ->where('CYID_REF','=',$CYID_REF)
                        ->union($ObjUnionUDF)
                        ->get()->toArray();   
                    $objCountUDF = count($objUdfARData);

                    $objlastdt          =   $this->getLastdt();

                    $objsubledger       =array();
                    //$objsubledger       =   $this->getsubledger();

                    $objgeneralledger   =   $this->getgl();

                    $objHSN             =   $this->gethsn();    
                    
                    $objCostCenter = DB::table('TBL_MST_COSTCENTER')
                    ->where('CYID_REF','=',$CYID_REF)
                    ->where('STATUS','=','A')
                    ->select('TBL_MST_COSTCENTER.*')
                    ->get();

                    $FormId         =   $this->form_id;
                    $ActionStatus   =   "disabled";

                    $objothcurrency = $this->GetCurrencyMaster(); 
            
            return view($this->view.$FormId.'view',compact(['FormId','objRights','objARDRCR','objARDRCRACC','objARDRCRUDF','objARDRCRCCD','objtaxstate',
                'objARDRCRSL','objARDRCRTDS','objCount1','objCount2','objCount3','objCount4','objUdfARData','objCountUDF','objlastdt',
                'objsubledger','objgeneralledger','objHSN','objCostCenter','ActionStatus','objothcurrency']));      

        }
     
    }

   public function Approve(Request $request){

        $USERID_REF =   Auth::user()->USERID;
        $VTID_REF   =   $this->vtid_ref;
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');   

        $sp_Approvallevel = [
            $USERID_REF, $VTID_REF, $CYID_REF,$BRID_REF,
            $FYID_REF
        ];
        
        $sp_listing_result = DB::select('EXEC SP_APPROVAL_LAVEL ?,?,?,?, ?', $sp_Approvallevel);

        if(!empty($sp_listing_result)){
            foreach ($sp_listing_result as $key=>$valueitem){  
                $record_status = 0;
                $Approvallevel = "APPROVAL".$valueitem->LAVELS;
            }
        }
   
        $r_count1 = $request['Row_Count1'];
        $r_count2 = $request['Row_Count2'];
        $r_count3 = $request['Row_Count3'];
        $r_count4 = $request['Row_Count4'];
        $GROSS_TOTAL        =   0; 
        $NET_TOTAL 		    = 	$request['tot_amt'];
        $CGSTAMT        	=   0; 
        $SGSTAMT        	=   0; 
        $IGSTAMT        	=   0; 
        $DISCOUNT       	=   0; 
        $TDS_AMOUNT     	=   0; 	
        $FC 		        = (isset($request['FC'])!="true" ? 0 : 1);
        $CRID_REF 		    = (isset($request['CRID_REF'])) ? $request['CRID_REF'] : 0;
        $CONVFACT 		    = (isset($request['CONVFACT'])) ? $request['CONVFACT'] : "";
        
        for ($i=0; $i<=$r_count1; $i++)
        {
            if(isset($request['GLID_REF_'.$i]))
            {
                $GROSS_TOTAL+= $request['TAX_AMT_'.$i]; 
                $CGSTAMT+= $request['CGST_AMT_'.$i]; 
                $SGSTAMT+= $request['SGST_AMT_'.$i]; 
                $IGSTAMT+= $request['IGST_AMT_'.$i]; 
                $DISCOUNT+= $request['DISC_AMT_'.$i]; 

                $req_data[$i] = [
                    'GLID_REF'          => $request['GLID_REF_'.$i],
                    'AMT'               => (!is_null($request['GL_AMT_'.$i]) ? $request['GL_AMT_'.$i] : 0),
                    'DISC_PER'          => (!is_null($request['DISC_PER_'.$i]) ? $request['DISC_PER_'.$i] : 0),
                    'DISC_AMT'          => (!is_null($request['DISC_AMT_'.$i]) ? $request['DISC_AMT_'.$i] : 0),
                    'HSNID_REF'         => (isset($request['HSNID_REF_'.$i]) ? $request['HSNID_REF_'.$i] : ''),
                    'IGST'              => (!is_null($request['IGST_'.$i]) ? $request['IGST_'.$i] : 0),
                    'CGST'              => (!is_null($request['CGST_'.$i]) ? $request['CGST_'.$i] : 0),
                    'SGST'              => (!is_null($request['SGST_'.$i]) ? $request['SGST_'.$i] : 0),
                    'CCID_REF'          => (isset($request['CCID_REF_'.$i]) ? $request['CCID_REF_'.$i] : ''),
                    'REMARKS'           => (isset($request['REMARKS_'.$i]) ? $request['REMARKS_'.$i] : ''),
                ];
            }
        }

        $wrapped_links["DET"] = $req_data; 
        $XMLACC = ArrayToXml::convert($wrapped_links);

        for ($i=0; $i<=$r_count2; $i++)
        {
            if(isset($request['UDF_ARID_REF_'.$i]) && !is_null($request['UDF_ARID_REF_'.$i]))
            {
                $reqdata2[$i] = [
                    'UDF_ARID_REF'   => $request['UDF_ARID_REF_'.$i],
                    'VALUE'         => $request['udfvalue_'.$i],
                ];
            }
        }

        if(isset($reqdata2))
        { 
            $wrapped_links2["UDF"] = $reqdata2; 
            $XMLUDF = ArrayToXml::convert($wrapped_links2);
        }
        else
        {
            $XMLUDF = NULL; 
        }

        for ($i=0; $i<=$r_count3; $i++)
        {
            if(isset($request['GLID_'.$i]) && !is_null($request['GLID_'.$i]))
            {
                $reqdata3[$i] = [
                    'GLID_REF'   => $request['GLID_'.$i],
                    'AMT'        => (!is_null($request['CC_AMT_'.$i]) ? $request['CC_AMT_'.$i] : 0),
                    'CCID_REF'   => $request['CCID_'.$i],
                    'REMARKS'    => (!is_null($request['CC_RMKS_'.$i]) ? $request['CC_RMKS_'.$i] : ''),
                ];
            }
        }

        if(isset($reqdata3))
        { 
            $wrapped_links3["CCD"] = $reqdata3; 
            $XMLCCD = ArrayToXml::convert($wrapped_links3);
        }
        else
        {
            $XMLCCD = NULL; 
        }

        for ($i=0; $i<=$r_count4; $i++)
        {
            if(isset($request['TDSID_REF_'.$i]))
            {
                
	     if(isset($request['drpTDS']) && $request['drpTDS'] == 'Yes'? 1 : 0==1){
            $TDS_AMOUNT      += $request['TDS_AMT_'.$i]; 
            }

                $reqdata4[$i] = [
                    'TDSID_REF'                 => $request['TDSID_REF_'.$i],
                    'ASSESSABLE_VL_TDS'         => (!is_null($request['ASSESSABLE_VL_TDS_'.$i]) ? $request['ASSESSABLE_VL_TDS_'.$i] : 0),
                    'TDS_RATE'                  => (!is_null($request['TDS_RATE_'.$i]) ? $request['TDS_RATE_'.$i] : 0),
                    'ASSESSABLE_VL_SURCHARGE'   => (!is_null($request['ASSESSABLE_VL_SURCHARGE_'.$i]) ? $request['ASSESSABLE_VL_SURCHARGE_'.$i] : 0),
                    'SURCHARGE_RATE'            => (!is_null($request['SURCHARGE_RATE_'.$i]) ? $request['SURCHARGE_RATE_'.$i] : 0),
                    'ASSESSABLE_VL_CESS'        => (!is_null($request['ASSESSABLE_VL_CESS_'.$i]) ? $request['ASSESSABLE_VL_CESS_'.$i] : 0),
                    'CESS_RATE'                 => (!is_null($request['CESS_RATE_'.$i]) ? $request['CESS_RATE_'.$i] : 0),
                    'ASSESSABLE_VL_SPCESS'      => (!is_null($request['ASSESSABLE_VL_SPCESS_'.$i]) ? $request['ASSESSABLE_VL_SPCESS_'.$i] : 0),
                    'SPCESS_RATE'               => (!is_null($request['SPCESS_RATE_'.$i]) ? $request['SPCESS_RATE_'.$i] : 0),
                ];
            }
        }
        if(isset($reqdata4))
        { 
            $wrapped_links4["TDSD"] = $reqdata4; 
            $XMLTDSD = ArrayToXml::convert($wrapped_links4);
        }
        else
        {
            $XMLTDSD = NULL; 
        }

        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = $Approvallevel;
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $AR_DOC_NO              = $request['AR_DOC_NO'];
        $AR_DOC_DT              = $request['AR_DOC_DT'];
        $CID_REF                = $request['CID_REF'];
        $AR_TYPE                = $request['AR_TYPE'];
        $REF_NO                 = $request['REF_NO'];
        $REF_DT                 = $request['REF_DT '];
        $REASON_DRCR_NOTE       = $request['REASON_DRCR_NOTE'];
        $COMMON_NARRATION       = $request['COMMON_NARRATION'];
        $TDS                    = ($request['drpTDS'] == 'Yes'? 1 : 0);
       
        $log_data = [ 
            $AR_DOC_NO,$AR_DOC_DT,$CID_REF,$AR_TYPE,$REF_NO,$REF_DT,$REASON_DRCR_NOTE,$COMMON_NARRATION,$TDS,$CYID_REF,$BRID_REF,
            $FYID_REF,$VTID_REF,$XMLACC,$XMLCCD,$XMLTDSD,$XMLUDF,$USERID,Date('Y-m-d'),Date('h:i:s.u'),$Approvallevel,$IPADDRESS
            ,$FC,$CRID_REF,$CONVFACT,$GROSS_TOTAL,$NET_TOTAL,$CGSTAMT,$SGSTAMT,$IGSTAMT,$DISCOUNT,$TDS_AMOUNT
        ];  

        $sp_result = DB::select('EXEC SP_AR_CREDIT_DEBIIT_NOTE_UP ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?', $log_data);  


        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => 'AR '.$AR_TYPE. ' Sucessfully Approved.']);

        }else{
            return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
        }
        exit();   
    }

    public function MultiApprove(Request $request){

        $USERID_REF =   Auth::user()->USERID;
        $VTID_REF   =   $this->vtid_ref;
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');   

        $sp_Approvallevel = [
            $USERID_REF, $VTID_REF, $CYID_REF,$BRID_REF,
            $FYID_REF
        ];
        
        $sp_listing_result = DB::select('EXEC SP_APPROVAL_LAVEL ?,?,?,?, ?', $sp_Approvallevel);

        if(!empty($sp_listing_result)){
            foreach ($sp_listing_result as $key=>$valueitem){  
                $record_status = 0;
                $Approvallevel = "APPROVAL".$valueitem->LAVELS;
            }
        }
               
        $req_data =  json_decode($request['ID']);

        $wrapped_links = $req_data; 
        $multi_array = $wrapped_links;
        $iddata = [];
        
        foreach($multi_array as $index=>$row){
            $m_array[$index] = $row->ID;
            $iddata['APPROVAL'][]['ID'] =  $row->ID;
        }

        $xml = ArrayToXml::convert($iddata);
                
        $USERID_REF =   Auth::user()->USERID;
        $VTID_REF   =   $this->vtid_ref;  
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');       
        $TABLE      =   "TBL_TRN_FNARDRCR_HDR";
        $FIELD      =   "ARDRCRID";
        $ACTIONNAME     = $Approvallevel;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();
            
        $log_data = [ 
            $USERID_REF, $VTID_REF, $TABLE, $FIELD, $xml, $ACTIONNAME, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS
        ];

        $sp_result = DB::select('EXEC SP_TRN_MULTIAPPROVAL_AR ?,?,?,?,?,?,?,?,?,?,?,?',  $log_data);       
        
        if($sp_result[0]->RESULT=="All records approved"){

        return Response::json(['approve' =>true,'msg' => 'Record successfully Approved.']);

        }elseif($sp_result[0]->RESULT=="NO RECORD FOR APPROVAL"){
        
        return Response::json(['errors'=>true,'msg' => 'No Record Found for Approval.','salesenquiry'=>'norecord']);
        
        }else{
        return Response::json(['errors'=>true,'msg' => 'There is some error in data. Please try after sometime.','salesenquiry'=>'Some Error']);
        }
        
        exit();    
    }

    public function cancel(Request $request){

        $id = $request->{0};

        $USERID_REF =   Auth::user()->USERID;
        $VTID_REF   =   $this->vtid_ref;
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');       
        $TABLE      =   "TBL_TRN_FNARDRCR_HDR";
        $FIELD      =   "ARDRCRID";
        $ID         =   $id;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();

        $req_data[0]=[
         'NT'  => 'TBL_TRN_FNARDRCR_HDR',
        ];
        $req_data[1]=[
        'NT'  => 'TBL_TRN_FNARDRCR_DET',
        ];
        $req_data[2]=[
        'NT'  => 'TBL_TRN_FNARDRCR_CCD',
        ];
        $req_data[3]=[
        'NT'  => 'TBL_TRN_FNARDRCR_TDS',
        ];
        $req_data[4]=[
        'NT'  => 'TBL_TRN_FNARDRCR_UDF',
        ];

        $wrapped_links["TABLES"] = $req_data; 
        $XMLTAB = ArrayToXml::convert($wrapped_links);
        
        $ardrcr_cancel_data = [ $USERID_REF, $VTID_REF, $TABLE, $FIELD, $ID, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS,$XMLTAB ];

        $sp_result = DB::select('EXEC SP_TRN_CANCEL_JV  ?,?,?,?, ?,?,?,?, ?,?,?,?', $ardrcr_cancel_data);

        if($sp_result[0]->RESULT=="CANCELED"){  

            return Response::json(['cancel' =>true,'msg' => 'Record successfully canceled.']);
        
        }elseif($sp_result[0]->RESULT=="NO RECORD FOR CANCEL"){
        
            return Response::json(['errors'=>true,'msg' => 'No record found.','norecord'=>'norecord']);
            
        }else{

            return Response::json(['errors'=>true,'msg' => 'Error:'.$sp_result[0]->RESULT,'invalid'=>'invalid']);
        }
        
        exit(); 
    }

    public function attachment($id){

        if(!is_null($id)){
        
            $FormId     =   $this->form_id;

            $objResponse = DB::table('TBL_TRN_FNARDRCR_HDR')->where('ARDRCRID','=',$id)->first();

            $objMstVoucherType = DB::table("TBL_MST_VOUCHERTYPE")
            ->where('VTID','=',$this->vtid_ref)
                ->select('VTID','VCODE','DESCRIPTIONS')
            ->get()
            ->toArray();

            $objAttachments = DB::table('TBL_MST_ATTACHMENT')                    
            ->where('TBL_MST_ATTACHMENT.VTID_REF','=',$this->vtid_ref)
            ->where('TBL_MST_ATTACHMENT.ATTACH_DOCNO','=',$id)
            ->where('TBL_MST_ATTACHMENT.CYID_REF','=',Auth::user()->CYID_REF)
            ->where('TBL_MST_ATTACHMENT.BRID_REF','=',Session::get('BRID_REF'))
            ->where('TBL_MST_ATTACHMENT.FYID_REF','=',Session::get('FYID_REF'))
            ->leftJoin('TBL_MST_ATTACHMENT_DET', 'TBL_MST_ATTACHMENT.ATTACHMENTID','=','TBL_MST_ATTACHMENT_DET.ATTACHMENTID_REF')
            ->select('TBL_MST_ATTACHMENT.*', 'TBL_MST_ATTACHMENT_DET.*')
            ->orderBy('TBL_MST_ATTACHMENT.ATTACHMENTID','ASC')
            ->get()->toArray();

            return view($this->view.$FormId.'attachment',compact(['FormId','objResponse','objMstVoucherType','objAttachments']));
        }

    }
  
    public function docuploads(Request $request){

        $FormId     =   $this->form_id;

        $formData = $request->all();

        $allow_extnesions = explode(",",config("erpconst.attachments.allow_extensions"));
        $allow_size = config("erpconst.attachments.max_size") * 1020 * 1024;

       
        $VTID           =   $formData["VTID_REF"]; 
        $ATTACH_DOCNO   =   $formData["ATTACH_DOCNO"]; 
        $ATTACH_DOCDT   =   $formData["ATTACH_DOCDT"]; 
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');       
       
        $USERID         =   Auth::user()->USERID;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "ADD";
        $IPADDRESS      =   $request->getClientIp();
        
		$image_path         =   "docs/company".$CYID_REF."/ARCRDRNOTE";     
        $destinationPath    =   str_replace('\\', '/', public_path($image_path));
		
        if ( !is_dir($destinationPath) ) {
            mkdir($destinationPath, 0777, true);
        }

        $uploaded_data = [];
        $invlid_files = "";

        $duplicate_files="";

        foreach($formData["REMARKS"] as $index=>$row_val){

                if(isset($formData["FILENAME"][$index])){

                    $uploadedFile = $formData["FILENAME"][$index]; 
                    
                   

                    $filenamewithextension  =   $uploadedFile ->getClientOriginalName();
                    $filesize               =   $uploadedFile ->getSize();  
                    $extension              =   strtolower( $uploadedFile ->getClientOriginalExtension() );

                   

                    $filenametostore        =  $VTID.$ATTACH_DOCNO.$USERID.$CYID_REF.$BRID_REF.$FYID_REF."_".$filenamewithextension;  

                    if ($uploadedFile->isValid()) {

                        if(in_array($extension,$allow_extnesions)){
                            
                            if($filesize < $allow_size){

                                $filename = $destinationPath."/".$filenametostore;

                                if (!file_exists($filename)) {

                                   $uploadedFile->move($destinationPath, $filenametostore);  
                                   $uploaded_data[$index]["FILENAME"] =$filenametostore;
                                   $uploaded_data[$index]["LOCATION"] = $image_path."/";
                                   $uploaded_data[$index]["REMARKS"] = is_null($row_val) ? '' : trim($row_val);

                                }else{

                                    $duplicate_files = " ". $duplicate_files.$filenamewithextension. " ";
                                }
                                

                                
                            }else{
                                
                                $invlid_files = $invlid_files.$filenamewithextension." (invalid size)  "; 
                            } 
                            
                        }else{

                            $invlid_files = $invlid_files.$filenamewithextension." (invalid extension)  ";                             
                        }
                    
                    }else{
                            
                        $invlid_files = $invlid_files.$filenamewithextension." (invalid)"; 
                    }

                }

        }

      
        if(empty($uploaded_data)){
            return redirect()->route("transaction",[$FormId,"attachment",$ATTACH_DOCNO])->with("success","No file uploaded");
        }
     

        $wrapped_links["ATTACHMENT"] = $uploaded_data;     
        $ATTACHMENTS_XMl = ArrayToXml::convert($wrapped_links);

        $attachment_data = [

            $VTID, 
            $ATTACH_DOCNO, 
            $ATTACH_DOCDT,
            $CYID_REF,
            
            $BRID_REF,
            $FYID_REF,
            $ATTACHMENTS_XMl,
            $USERID,

            $UPDATE,
            $UPTIME,
            $ACTION,
            $IPADDRESS
        ];
        

        $sp_result = DB::select('EXEC SP_ATTACHMENT_IN ?,?,?,?, ?,?,?,?, ?,?,?,?', $attachment_data);

     
        if($sp_result[0]->RESULT=="SUCCESS"){

            if(trim($duplicate_files!="")){
                $duplicate_files =  " System ignored duplicated files -  ".$duplicate_files;
            }

            if(trim($invlid_files!="")){
                $invlid_files =  " Invalid files -  ".$invlid_files;
            }

            return redirect()->route("transaction",[$FormId,"attachment",$ATTACH_DOCNO])->with("success","Files successfully attached. ".$duplicate_files.$invlid_files);


        }        elseif($sp_result[0]->RESULT=="Duplicate file for same records"){
       
            return redirect()->route("transaction",[$FormId,"attachment",$ATTACH_DOCNO])->with("success","Duplicate file name. ".$invlid_files);
    
        }else{

            
            return redirect()->route("transaction",[$FormId,"attachment",$ATTACH_DOCNO])->with($sp_result[0]->RESULT);
        }
       
    }
	
	public function getBalance(Request $request){
        $Status     =   "A";
        $ID   =   $request['id'];
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');
        
       $TaxStatus  =   DB::select('SELECT DBO.FN_GLOCBL(?,?)  AS CR_AMT', [$ID,Date('Y-m-d')]);
        
        $TaxStatus2  =   DB::select('SELECT DBO.FN_GLODBL(?,?) AS DR_AMT', [$ID,Date('Y-m-d')]);
		
		
    
       $Balance=($TaxStatus2[0]->DR_AMT - $TaxStatus[0]->CR_AMT);
            if($Balance == '' || $Balance==0){
                return  $Balance='0.00';              
            }
            else if($Balance > 0 ){
                return $Balance= number_format(abs($Balance),2).' Dr';   
            }else if($Balance < 0 ){
                return $Balance= number_format(abs($Balance),2).' Cr';              
            }
			else{
            return  $Balance='0.00';
			} 
        
    }

    public function getBalanceGrid(Request $request){
        $Status     =   "A";
        $ID   =   $request['id'];
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');
        
       
		
		$TaxStatus  =   DB::select('SELECT DBO.FN_GLOCBL(?,?)  AS CR_AMT', [$ID,Date('Y-m-d')]);
        
        $TaxStatus2  =   DB::select('SELECT DBO.FN_GLODBL(?,?) AS DR_AMT', [$ID,Date('Y-m-d')]);
		
		
    
       $Balance=($TaxStatus2[0]->DR_AMT - $TaxStatus[0]->CR_AMT);
	
	   if($Balance == '' || $Balance==0){
                return  $Balance='0.00';              
            }
			else{
				return  $Balance;
			}
        
    }
   

    public function codeduplicate(Request $request){

        $AR_DOC_NO  =   trim($request['AR_DOC_NO']);
        $objLabel = DB::table('TBL_TRN_FNARDRCR_HDR')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('BRID_REF','=',Session::get('BRID_REF'))
        ->where('FYID_REF','=',Session::get('FYID_REF'))
        ->where('AR_DOC_NO','=',$AR_DOC_NO)
        ->select('ARDRCRID')->first();

        if($objLabel){  
            return Response::json(['exists' =>true,'msg' => 'Duplicate No']);
        }else{
            return Response::json(['not exists'=>true,'msg' => 'Ok']);
        }
        
        exit();
    }

    public function getLastdt(){
        $Status = "A";
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        return  DB::select('SELECT MAX(AR_DOC_DT) AR_DOC_DT FROM TBL_TRN_FNARDRCR_HDR  
        WHERE  CYID_REF = ? AND BRID_REF = ?   AND VTID_REF = ? AND STATUS = ?', 
        [$CYID_REF, $BRID_REF,  $this->vtid_ref, 'A' ]);
    }

    


    
}
