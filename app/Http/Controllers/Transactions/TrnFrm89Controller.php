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
use App\Helpers\Helper;
use App\Helpers\Utils;

class TrnFrm89Controller extends Controller{

    protected $form_id  = 89;
    protected $vtid_ref = 89;
    protected $view     = "transactions.inventory.MaterialIssueSlip.trnfrm";
   
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

        $objDataList	=	DB::select("select hdr.MISID,hdr.MIS_NO,hdr.MIS_DT,hdr.INDATE,
                            (
                            SELECT TOP 1 USR.DESCRIPTIONS FROM TBL_TRN_AUDITTRAIL AUD 
                            LEFT JOIN TBL_MST_USER USR ON AUD.USERID=USR.USERID 
                            WHERE  AUD.VID=hdr.MISID AND  AUD.CYID_REF=hdr.CYID_REF AND  AUD.BRID_REF=hdr.BRID_REF AND  
                            AUD.FYID_REF=hdr.FYID_REF AND  AUD.VTID_REF=hdr.VTID_REF AND AUD.ACTIONNAME='ADD'       
                            ) AS CREATED_BY,
                            hdr.STATUS,
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
                            inner join TBL_TRN_MISS01_HDR hdr
                            on a.VID = hdr.MISID 
                            and a.VTID_REF = hdr.VTID_REF 
                            and a.CYID_REF = hdr.CYID_REF 
                            and a.BRID_REF = hdr.BRID_REF
                            where a.VTID_REF = '$this->vtid_ref'
                            and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF' AND hdr.FYID_REF='$FYID_REF'
                            and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                            ORDER BY hdr.MISID DESC ");

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
        $MISID       =   $myValue['MISID'];
        $Flag       =   $myValue['Flag'];
        
        $ssrs = new \SSRS\Report('http://103.139.58.23:8181//ReportServer/', array('username' => 'App', 'password' => 'admin@123'));
        $result = $ssrs->loadReport('/UNICORN/MISPrint');
        
        $reportParameters = array(
            'MISID' => $MISID,
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
       
        $objDepartmentList  =   $this->getDepartmentList();
        $objlastdt          =   $this->getLastdt();
        
        $objUOM = DB::select('SELECT UOMID, UOMCODE, DESCRIPTIONS FROM TBL_MST_UOM  
        WHERE  CYID_REF = ?  AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?
        order by UOMCODE ASC', [$CYID_REF,  'A' ]); 
        
        $doc_req    =   array(
            'VTID_REF'=>$this->vtid_ref,
            'HDR_TABLE'=>'TBL_TRN_MISS01_HDR',
            'HDR_ID'=>'MISID',
            'HDR_DOC_NO'=>'MIS_NO',
            'HDR_DOC_DT'=>'MIS_DT'
        );
        $docarray   =   $this->getManualAutoDocNo(date('Y-m-d'),$doc_req);

        
   
        $ObjUnionUDF = DB::table("TBL_MST_UDFFOR_MIS")->select('*')
                    ->whereIn('PARENTID',function($query) use ($CYID_REF)
                                {       
                                $query->select('UDFMISID')->from('TBL_MST_UDFFOR_MIS')
                                                ->where('STATUS','=','A')
                                                ->where('PARENTID','=',0)
                                                ->where('DEACTIVATED','=',0)
                                                ->where('CYID_REF','=',$CYID_REF);                      
                    })->where('DEACTIVATED','=',0)
                    ->where('STATUS','<>','C')                    
                    ->where('CYID_REF','=',$CYID_REF);                   
                   

        $objUdfData = DB::table('TBL_MST_UDFFOR_MIS')
            ->where('STATUS','=','A')
            ->where('PARENTID','=',0)
            ->where('DEACTIVATED','=',0)
            ->where('CYID_REF','=',$CYID_REF)
            ->union($ObjUnionUDF)
            ->get()->toArray();  

        $objCountUDF = count($objUdfData);

        $FormId     =   $this->form_id;
        $AlpsStatus         =   $this->AlpsStatus();

        $TabSetting	=	Helper::getAddSetting(Auth::user()->CYID_REF,'ITEM_TAB_SETTING');
        $checkCompany   =	Helper::checkCompany(Auth::user()->CYID_REF,'zep');
        
        return view($this->view.$FormId.'add',compact([
                'AlpsStatus',
                'FormId',
                'objDepartmentList',
                'objUdfData',
               
                'objCountUDF',
               
                'objlastdt',
                'objUOM',
                'TabSetting',
                'checkCompany',
                'doc_req','docarray'
        ]));       
    }

    public function save(Request $request) {

        $r_count1 = $request['Row_Count1'];
        $r_count2 = $request['Row_Count2'];
        
        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $StoreArr   =   array();
                $ITEMID_REF =   $request['ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['HiddenRowId_'.$i];
                $exp        =   explode(",",$ITEMROWID);

                foreach($exp as $val){
                    $keyid              =   explode("#",$val);
                    $batchid            =   $keyid[0];
                    $StoreArr[]         =   $batchid;
                }

                if(!empty($StoreArr)){
                    $StoreId    =   array_unique($StoreArr);
                    $STID_REF   =   implode(",",$StoreId);
                }
                else{
                    $STID_REF   =   NULL;
                }

                $req_data[$i] = [
                    'MRSID_REF'        => $request['RGP_NO_'.$i],
                    'ITEMID_REF'       => $request['ITEMID_REF_'.$i],
                    'ITEM_SPECI'       => $request['Itemspec_'.$i],
                    'STID'             =>  $STID_REF,
                    'MRS_QTY_BL'       => $request['SE_QTY_'.$i],
                    'MAIN_UOMID_REF'   => $request['MAIN_UOMID_REF_'.$i],
                    'STOCK_INHAND'     => $request['STOCK_INHAND_'.$i],
                    'ISSUED_QTY'       => $request['RECEIVED_QTY_MU_'.$i],
                    'ALT_UOMID_REF'    => $request['ALT_UOMID_REF_'.$i],
                    'REASON_SHORT_QTY' => $request['REASON_SHORT_QTY_'.$i],
                    'REMARKS'          => $request['REMARKS_'.$i],
                    'SHORT_QTY'        => $request['SHORT_QTY_'.$i],
                    'BATCH_QTY'        => $request['HiddenRowId_'.$i],
                ];
            }
        }

       
        
        $wrapped_links["MAT"] = $req_data; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);
            
        
        for ($i=0; $i<=$r_count2; $i++){
            if(isset($request['UDF_'.$i])){
                $reqdata3[$i] = [
                    'UDF'      => $request['UDF_'.$i],
                    'COMMENT'  => $request['udfvalue_'.$i],
                ];
            }
        }

       
        
        if($r_count2 > 0){
            $wrapped_links3["UDF1"] = $reqdata3; 
            $XMLUDF = ArrayToXml::convert($wrapped_links3);
        }
        else{
            $XMLUDF=NULL;
        }


        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $dataArr    =   array();
                $ITEMID_REF =   $request['ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['HiddenRowId_'.$i];

                if($ITEMROWID !=""){
                    $exp        =   explode(",",$ITEMROWID);

                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];

                        $dataArr[$batchid]['RECEIVED_QTYM'] =   $keyid[1];
                        //$dataArr[$batchid]['LOT_NO']        =   $keyid[2];
                        //$dataArr[$batchid]['VENDOR_LOTNO']  =  $keyid[3];
                        $dataArr[$batchid]['STOCK_INHAND']  =  $keyid[2];
                    }
                }

                if(!empty($dataArr)){
                    foreach($dataArr as $key=>$val){

                        $ExpID              =   explode("#",$key);
                        $STID_REF           =   $ExpID[0];
                        $RGPID_REF          =   $ExpID[1];
                        $BATCH_CODE         =   $ExpID[2];
                        $ITEMID_REF         =   $ExpID[3];
                        $UOMID_REF          =   $ExpID[4];
                        $ALTUOM             =   $ExpID[5];
                        $AluQty             =   $this->getAltUmQty($ALTUOM,$ITEMID_REF,$val['RECEIVED_QTYM']);
                       
                        $req_data33[$i][] = [
                            'MRSID_REF'         => $RGPID_REF,
                            'ITEMID_REF'        => $ITEMID_REF,
                            'STID_REF'          => $STID_REF,
                            'BATCH_CODE'        => $BATCH_CODE,
                            'MAIN_UOMID_REF'    => $UOMID_REF,
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            'ISSUED_QTYM'       => $val['RECEIVED_QTYM'],
                            'ALT_UOMID_REF'     => $ALTUOM,
                            'ISSUED_QTYA'       => $AluQty,
                        ];

                    }
                }
            }
        }

        $wrapped_links33["MULTISTORE"] = $req_data33; 
        $XMLSTORE = ArrayToXml::convert($wrapped_links33);

        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = 'ADD';
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $MIS_NO         = $request['MIS_NO'];
        $MIS_DT         = $request['MIS_DT'];
        $DEPID_REF      = $request['DEPID_REF'];
       

        $log_data = [ 
            $MIS_NO,$MIS_DT,$DEPID_REF,$CYID_REF,$BRID_REF,
            $FYID_REF,$VTID_REF,$XMLMAT,$XMLUDF,$XMLSTORE,
            $USERID, Date('Y-m-d'),Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS
        ];  


        $sp_result = DB::select('EXEC SP_MIS_IN ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?', $log_data);  


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

            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $objResponse =  DB::table('TBL_TRN_MISS01_HDR')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('BRID_REF','=',Session::get('BRID_REF'))
            ->where('MISID','=',$id)
            ->first();

            $objDepartmentList  =   $this->getDepartmentList();
            $objlastdt          =   $this->getLastdt();

            $objDepartmentName  =[];
            if(isset($objResponse->DEPID_REF) && $objResponse->DEPID_REF !=""){
                $objDepartmentName  =   $this->getDepartmentName($objResponse->DEPID_REF);
            }

  
            $objMAT = DB::select("SELECT 
                    T1.*,
                    T2.ICODE,T2.NAME AS ITEM_NAME,
                    CONCAT(T3.UOMCODE,'-',T3.DESCRIPTIONS) AS MAIN_UOM_CODE,
                    CONCAT(T4.UOMCODE,'-',T4.DESCRIPTIONS) AS AULT_UOM_CODE,
                    T5.FROM_QTY,T5.TO_QTY,
                    T6.MRSID,T6.MRS_NO
                    FROM TBL_TRN_MISS01_MAT T1
                    LEFT JOIN TBL_MST_ITEM T2 ON T1.ITEMID_REF=T2.ITEMID
                    LEFT JOIN TBL_MST_UOM T3 ON T1.MAIN_UOMID_REF=T3.UOMID
                    LEFT JOIN TBL_MST_UOM T4 ON T1.ALT_UOMID_REF=T4.UOMID
                    LEFT JOIN TBL_MST_ITEM_UOMCONV T5 ON T1.ITEMID_REF=T5.ITEMID_REF AND T1.MAIN_UOMID_REF=T5.TO_UOMID_REF
                    LEFT JOIN TBL_TRN_MRQS01_HDR T6 ON T1.MRSID_REF=T6.MRSID
                    WHERE T1.MISID_REF='$id' ORDER BY T1.MIS_MATID ASC
                    "); 


            $objCount1 = count($objMAT);  

            

            
            $objUDF = DB::table('TBL_TRN_MISS01_UDF')                    
            ->where('MISID_REF','=',$id)
            ->orderBy('MIS_UDFID','ASC')
            ->get()->toArray();
            $objCount2 = count($objUDF); 

            $objUOM = DB::select('SELECT UOMID, UOMCODE, DESCRIPTIONS FROM TBL_MST_UOM  
            WHERE  CYID_REF = ?  AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?
            order by UOMCODE ASC', [$CYID_REF,  'A' ]); 

            $ObjUnionUDF = DB::table("TBL_MST_UDFFOR_MIS")->select('*')
                        ->whereIn('PARENTID',function($query) use ($CYID_REF)
                                    {       
                                    $query->select('UDFMISID')->from('TBL_MST_UDFFOR_MIS')
                                                    ->where('STATUS','=','A')
                                                    ->where('PARENTID','=',0)
                                                    ->where('DEACTIVATED','=',0)
                                                    ->where('CYID_REF','=',$CYID_REF);
                                                                     
                        })->where('DEACTIVATED','=',0)
                        ->where('STATUS','<>','C')                    
                        ->where('CYID_REF','=',$CYID_REF);
                                     
                    

            $objUdfData = DB::table('TBL_MST_UDFFOR_MIS')
            ->where('STATUS','=','A')
            ->where('PARENTID','=',0)
            ->where('DEACTIVATED','=',0)
            ->where('CYID_REF','=',$CYID_REF)
            ->union($ObjUnionUDF)
            ->get()->toArray();   
            $objCountUDF = count($objUdfData);        

            $ObjUnionUDF2 = DB::table("TBL_MST_UDFFOR_MIS")->select('*')
            ->whereIn('PARENTID',function($query) use ($CYID_REF)
                        {       
                        $query->select('UDFMISID')->from('TBL_MST_UDFFOR_MIS')
                                        ->where('PARENTID','=',0)
                                        ->where('DEACTIVATED','=',0)
                                        ->where('CYID_REF','=',$CYID_REF);
                                                         
            })->where('DEACTIVATED','=',0)
            ->where('CYID_REF','=',$CYID_REF);
                           
            

            $objUdfData2 = DB::table('TBL_MST_UDFFOR_MIS')
            ->where('PARENTID','=',0)
            ->where('DEACTIVATED','=',0)
            ->where('CYID_REF','=',$CYID_REF)
            ->union($ObjUnionUDF2)
            ->get()->toArray(); 

            $objItems=array();
            
            $objUOM=array();

            $objItemUOMConv=array();

            $FormId         =   $this->form_id;
            $AlpsStatus         =   $this->AlpsStatus();
            $ActionStatus   =   "";

            $TabSetting	=	Helper::getAddSetting(Auth::user()->CYID_REF,'ITEM_TAB_SETTING');
            $checkCompany   =	Helper::checkCompany(Auth::user()->CYID_REF,'zep');
        
            return view($this->view.$FormId.'edit',compact([
                'AlpsStatus',
                'FormId',
                'objRights',
                'objResponse',
                'objDepartmentList',
                'objDepartmentName',
                'objMAT',
                'objCount1',
                'objCount2',
                'objUDF',
                'objUdfData',
                'objCountUDF',
                'objItems',
                'objUdfData2',
                'objlastdt',
                'objUOM',
                'objItemUOMConv',
                'ActionStatus',
                'TabSetting',
                'checkCompany'
        ]));      


        }
     
    }

    public function update(Request $request){
        
        $r_count1 = $request['Row_Count1'];
        $r_count2 = $request['Row_Count2'];
        
        
        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $StoreArr   =   array();
                $ITEMID_REF =   $request['ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['HiddenRowId_'.$i];
                $exp        =   explode(",",$ITEMROWID);

                foreach($exp as $val){
                    $keyid              =   explode("#",$val);
                    $batchid            =   $keyid[0];
                    $StoreArr[]         =   $batchid;
                }

                if(!empty($StoreArr)){
                    $StoreId    =   array_unique($StoreArr);
                    $STID_REF   =   implode(",",$StoreId);
                }
                else{
                    $STID_REF   =   NULL;
                }

                $req_data[$i] = [
                    'MRSID_REF'        => $request['RGP_NO_'.$i],
                    'ITEMID_REF'       => $request['ITEMID_REF_'.$i],
                    'ITEM_SPECI'       => $request['Itemspec_'.$i],
                    'STID'             =>  $STID_REF,
                    'MRS_QTY_BL'       => $request['SE_QTY_'.$i],
                    'MAIN_UOMID_REF'   => $request['MAIN_UOMID_REF_'.$i],
                    'STOCK_INHAND'     => $request['STOCK_INHAND_'.$i],
                    'ISSUED_QTY'       => $request['RECEIVED_QTY_MU_'.$i],
                    'ALT_UOMID_REF'    => $request['ALT_UOMID_REF_'.$i],
                    'REASON_SHORT_QTY' => $request['REASON_SHORT_QTY_'.$i],
                    'REMARKS'          => $request['REMARKS_'.$i],
                    'SHORT_QTY'        => $request['SHORT_QTY_'.$i],
                    'BATCH_QTY'        => $request['HiddenRowId_'.$i],
                ];
            }
        }


       
        
        $wrapped_links["MAT"] = $req_data; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);
            
        
        for ($i=0; $i<=$r_count2; $i++){
            if(isset($request['UDF_'.$i])){
                $reqdata3[$i] = [
                    'UDF'      => $request['UDF_'.$i],
                    'COMMENT'  => $request['udfvalue_'.$i],
                ];
            }
        }

       
        
        if($r_count2 > 0){
            $wrapped_links3["UDF1"] = $reqdata3; 
            $XMLUDF = ArrayToXml::convert($wrapped_links3);
        }
        else{
            $XMLUDF=NULL;
        }


        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $dataArr    =   array();
                $ITEMID_REF =   $request['ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['HiddenRowId_'.$i];

                if($ITEMROWID !=""){
                    $exp        =   explode(",",$ITEMROWID);

                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];

                        $dataArr[$batchid]['RECEIVED_QTYM'] =   $keyid[1];
                        //$dataArr[$batchid]['LOT_NO']        =   $keyid[2];
                        //$dataArr[$batchid]['VENDOR_LOTNO']  =  $keyid[3];
                        $dataArr[$batchid]['STOCK_INHAND']  =  $keyid[2];
                    }
                }

                if(!empty($dataArr)){
                    foreach($dataArr as $key=>$val){

                        $ExpID              =   explode("#",$key);
                        $STID_REF           =   $ExpID[0];
                        $RGPID_REF          =   $ExpID[1];
                        $BATCH_CODE         =   $ExpID[2];
                        $ITEMID_REF         =   $ExpID[3];
                        $UOMID_REF          =   $ExpID[4];
                        $ALTUOM             =   $ExpID[5];
                        $AluQty             =   $this->getAltUmQty($ALTUOM,$ITEMID_REF,$val['RECEIVED_QTYM']);
                       
                        $req_data33[$i][] = [
                            'MRSID_REF'         => $RGPID_REF,
                            'ITEMID_REF'        => $ITEMID_REF,
                            'STID_REF'          => $STID_REF,
                            'BATCH_CODE'        => $BATCH_CODE,
                            'MAIN_UOMID_REF'    => $UOMID_REF,
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            'ISSUED_QTYM'       => $val['RECEIVED_QTYM'],
                            'ALT_UOMID_REF'     => $ALTUOM,
                            'ISSUED_QTYA'       => $AluQty,
                        ];

                    }
                }
            }
        }

        $wrapped_links33["MULTISTORE"] = $req_data33; 
        $XMLSTORE = ArrayToXml::convert($wrapped_links33);

        
        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = 'EDIT';
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $MIS_NO         = $request['MIS_NO'];
        $MIS_DT         = $request['MIS_DT'];
        $DEPID_REF      = $request['DEPID_REF'];
       

        $log_data = [ 
            $MIS_NO,$MIS_DT,$DEPID_REF,$CYID_REF,$BRID_REF,
            $FYID_REF,$VTID_REF,$XMLMAT,$XMLUDF,$XMLSTORE,
            $USERID, Date('Y-m-d'),Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS
        ];  


        $sp_result = DB::select('EXEC SP_MIS_UP ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?', $log_data);  

        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => $sp_result[0]->RESULT]);

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

            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $objResponse =  DB::table('TBL_TRN_MISS01_HDR')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('BRID_REF','=',Session::get('BRID_REF'))
            ->where('MISID','=',$id)
            ->first();

            $objDepartmentList  =   $this->getDepartmentList();
            $objlastdt          =   $this->getLastdt();

            $objDepartmentName  =[];
            if(isset($objResponse->DEPID_REF) && $objResponse->DEPID_REF !=""){
                $objDepartmentName  =   $this->getDepartmentName($objResponse->DEPID_REF);
            }

  
            $objMAT = DB::select("SELECT 
                    T1.*,
                    T2.ICODE,T2.NAME AS ITEM_NAME,
                    CONCAT(T3.UOMCODE,'-',T3.DESCRIPTIONS) AS MAIN_UOM_CODE,
                    CONCAT(T4.UOMCODE,'-',T4.DESCRIPTIONS) AS AULT_UOM_CODE,
                    T5.FROM_QTY,T5.TO_QTY,
                    T6.MRSID,T6.MRS_NO
                    FROM TBL_TRN_MISS01_MAT T1
                    LEFT JOIN TBL_MST_ITEM T2 ON T1.ITEMID_REF=T2.ITEMID
                    LEFT JOIN TBL_MST_UOM T3 ON T1.MAIN_UOMID_REF=T3.UOMID
                    LEFT JOIN TBL_MST_UOM T4 ON T1.ALT_UOMID_REF=T4.UOMID
                    LEFT JOIN TBL_MST_ITEM_UOMCONV T5 ON T1.ITEMID_REF=T5.ITEMID_REF AND T1.MAIN_UOMID_REF=T5.TO_UOMID_REF
                    LEFT JOIN TBL_TRN_MRQS01_HDR T6 ON T1.MRSID_REF=T6.MRSID
                    WHERE T1.MISID_REF='$id' ORDER BY T1.MIS_MATID ASC
                    "); 


            $objCount1 = count($objMAT);  

            

            
            $objUDF = DB::table('TBL_TRN_MISS01_UDF')                    
            ->where('MISID_REF','=',$id)
            ->orderBy('MIS_UDFID','ASC')
            ->get()->toArray();
            $objCount2 = count($objUDF); 

            $objUOM = DB::select('SELECT UOMID, UOMCODE, DESCRIPTIONS FROM TBL_MST_UOM  
            WHERE  CYID_REF = ?  AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?
            order by UOMCODE ASC', [$CYID_REF,  'A' ]); 

            $ObjUnionUDF = DB::table("TBL_MST_UDFFOR_MIS")->select('*')
                        ->whereIn('PARENTID',function($query) use ($CYID_REF)
                                    {       
                                    $query->select('UDFMISID')->from('TBL_MST_UDFFOR_MIS')
                                                    ->where('STATUS','=','A')
                                                    ->where('PARENTID','=',0)
                                                    ->where('DEACTIVATED','=',0)
                                                    ->where('CYID_REF','=',$CYID_REF);
                                                                     
                        })->where('DEACTIVATED','=',0)
                        ->where('STATUS','<>','C')                    
                        ->where('CYID_REF','=',$CYID_REF);
                                     
                    

            $objUdfData = DB::table('TBL_MST_UDFFOR_MIS')
            ->where('STATUS','=','A')
            ->where('PARENTID','=',0)
            ->where('DEACTIVATED','=',0)
            ->where('CYID_REF','=',$CYID_REF)
            ->union($ObjUnionUDF)
            ->get()->toArray();   
            $objCountUDF = count($objUdfData);        

            $ObjUnionUDF2 = DB::table("TBL_MST_UDFFOR_MIS")->select('*')
            ->whereIn('PARENTID',function($query) use ($CYID_REF)
                        {       
                        $query->select('UDFMISID')->from('TBL_MST_UDFFOR_MIS')
                                        ->where('PARENTID','=',0)
                                        ->where('DEACTIVATED','=',0)
                                        ->where('CYID_REF','=',$CYID_REF);
                                                         
            })->where('DEACTIVATED','=',0)
            ->where('CYID_REF','=',$CYID_REF);
                           
            

            $objUdfData2 = DB::table('TBL_MST_UDFFOR_MIS')
            ->where('PARENTID','=',0)
            ->where('DEACTIVATED','=',0)
            ->where('CYID_REF','=',$CYID_REF)
            ->union($ObjUnionUDF2)
            ->get()->toArray(); 

            $objItems=array();
            
            $objUOM=array();

            $objItemUOMConv=array();

            $FormId         =   $this->form_id;
            $AlpsStatus         =   $this->AlpsStatus();
            $ActionStatus   =   "disabled";

            $TabSetting	=	Helper::getAddSetting(Auth::user()->CYID_REF,'ITEM_TAB_SETTING');
            $checkCompany   =	Helper::checkCompany(Auth::user()->CYID_REF,'zep');
        
            return view($this->view.$FormId.'edit',compact([
                'AlpsStatus',
                'FormId',
                'objRights',
                'objResponse',
                'objDepartmentList',
                'objDepartmentName',
                'objMAT',
                'objCount1',
                'objCount2',
                'objUDF',
                'objUdfData',
                'objCountUDF',
                'objItems',
                'objUdfData2',
                'objlastdt',
                'objUOM',
                'objItemUOMConv',
                'ActionStatus',
                'TabSetting',
                'checkCompany'
        ]));      


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
        
        
        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $StoreArr   =   array();
                $ITEMID_REF =   $request['ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['HiddenRowId_'.$i];
                $exp        =   explode(",",$ITEMROWID);

                foreach($exp as $val){
                    $keyid              =   explode("#",$val);
                    $batchid            =   $keyid[0];
                    $StoreArr[]         =   $batchid;
                }

                if(!empty($StoreArr)){
                    $StoreId    =   array_unique($StoreArr);
                    $STID_REF   =   implode(",",$StoreId);
                }
                else{
                    $STID_REF   =   NULL;
                }

                $req_data[$i] = [
                    'MRSID_REF'        => $request['RGP_NO_'.$i],
                    'ITEMID_REF'       => $request['ITEMID_REF_'.$i],
                    'ITEM_SPECI'       => $request['Itemspec_'.$i],
                    'STID'             =>  $STID_REF,
                    'MRS_QTY_BL'       => $request['SE_QTY_'.$i],
                    'MAIN_UOMID_REF'   => $request['MAIN_UOMID_REF_'.$i],
                    'STOCK_INHAND'     => $request['STOCK_INHAND_'.$i],
                    'ISSUED_QTY'       => $request['RECEIVED_QTY_MU_'.$i],
                    'ALT_UOMID_REF'    => $request['ALT_UOMID_REF_'.$i],
                    'REASON_SHORT_QTY' => $request['REASON_SHORT_QTY_'.$i],
                    'REMARKS'          => $request['REMARKS_'.$i],
                    'SHORT_QTY'        => $request['SHORT_QTY_'.$i],
                    'BATCH_QTY'        => $request['HiddenRowId_'.$i],
                ];
            }
        }

        
        $wrapped_links["MAT"] = $req_data; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);
            
        
        for ($i=0; $i<=$r_count2; $i++){
            if(isset($request['UDF_'.$i])){
                $reqdata3[$i] = [
                    'UDF'      => $request['UDF_'.$i],
                    'COMMENT'  => $request['udfvalue_'.$i],
                ];
            }
        }

       
        
        if($r_count2 > 0){
            $wrapped_links3["UDF1"] = $reqdata3; 
            $XMLUDF = ArrayToXml::convert($wrapped_links3);
        }
        else{
            $XMLUDF=NULL;
        }


        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $dataArr    =   array();
                $ITEMID_REF =   $request['ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['HiddenRowId_'.$i];

                if($ITEMROWID !=""){
                    $exp        =   explode(",",$ITEMROWID);

                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];

                        $dataArr[$batchid]['RECEIVED_QTYM'] =   $keyid[1];
                        //$dataArr[$batchid]['LOT_NO']        =   $keyid[2];
                        //$dataArr[$batchid]['VENDOR_LOTNO']  =  $keyid[3];
                        $dataArr[$batchid]['STOCK_INHAND']  =  $keyid[2];
                    }
                }

                if(!empty($dataArr)){
                    foreach($dataArr as $key=>$val){

                        $ExpID              =   explode("#",$key);
                        $STID_REF           =   $ExpID[0];
                        $RGPID_REF          =   $ExpID[1];
                        $BATCH_CODE         =   $ExpID[2];
                        $ITEMID_REF         =   $ExpID[3];
                        $UOMID_REF          =   $ExpID[4];
                        $ALTUOM             =   $ExpID[5];
                        $AluQty             =   $this->getAltUmQty($ALTUOM,$ITEMID_REF,$val['RECEIVED_QTYM']);
                       
                        $req_data33[$i][] = [
                            'MRSID_REF'         => $RGPID_REF,
                            'ITEMID_REF'        => $ITEMID_REF,
                            'STID_REF'          => $STID_REF,
                            'BATCH_CODE'        => $BATCH_CODE,
                            'MAIN_UOMID_REF'    => $UOMID_REF,
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            'ISSUED_QTYM'       => $val['RECEIVED_QTYM'],
                            'ALT_UOMID_REF'     => $ALTUOM,
                            'ISSUED_QTYA'       => $AluQty,
                        ];

                    }
                }
            }
        }

        $wrapped_links33["MULTISTORE"] = $req_data33; 
        $XMLSTORE = ArrayToXml::convert($wrapped_links33);


        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = $Approvallevel;
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $MIS_NO         = $request['MIS_NO'];
        $MIS_DT         = $request['MIS_DT'];
        $DEPID_REF      = $request['DEPID_REF'];
       

        $log_data = [ 
            $MIS_NO,$MIS_DT,$DEPID_REF,$CYID_REF,$BRID_REF,
            $FYID_REF,$VTID_REF,$XMLMAT,$XMLUDF,$XMLSTORE,
            $USERID, Date('Y-m-d'),Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS
        ];  


        $sp_result = DB::select('EXEC SP_MIS_UP ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?', $log_data);  

        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => $sp_result[0]->RESULT]);

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
        $TABLE      =   "TBL_TRN_MISS01_HDR";
        $FIELD      =   "MISID";
        $ACTIONNAME     = $Approvallevel;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();
            
        $log_data = [ 
            $USERID_REF, $VTID_REF, $TABLE, $FIELD, $xml, $ACTIONNAME, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS
        ];

        $sp_result = DB::select('EXEC SP_TRN_MULTIAPPROVAL ?,?,?,?,?,?,?,?,?,?,?,?',  $log_data);       
        
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
        $TABLE      =   "TBL_TRN_MISS01_HDR";
        $FIELD      =   "MISID";
        $ID         =   $id;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();

        $req_data[0]=[
         'NT'  => 'TBL_TRN_MISS01_MAT',
        ];
        $req_data[1]=[
        'NT'  => 'TBL_TRN_MISS01_MULTISTORE',
        ];
        $req_data[2]=[
        'NT'  => 'TBL_TRN_MISS01_UDF',
        ];
        
        $wrapped_links["TABLES"] = $req_data; 
        $XMLTAB = ArrayToXml::convert($wrapped_links);
        
        $salesorder_cancel_data = [ $USERID_REF, $VTID_REF, $TABLE, $FIELD, $ID, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS,$XMLTAB ];

        $sp_result = DB::select('EXEC SP_TRN_CANCEL_MIS  ?,?,?,?, ?,?,?,?, ?,?,?,?', $salesorder_cancel_data);

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

            $objResponse = DB::table('TBL_TRN_MISS01_HDR')->where('MISID','=',$id)->first();

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
        
		$image_path         =   "docs/company".$CYID_REF."/MaterialIssueSlip";     
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
   

    public function codeduplicate(Request $request){

        $MIS_NO  =   trim($request['MIS_NO']);
        $objLabel = DB::table('TBL_TRN_MISS01_HDR')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('BRID_REF','=',Session::get('BRID_REF'))
        ->where('FYID_REF','=',Session::get('FYID_REF'))
        ->where('MIS_NO','=',$MIS_NO)
        ->select('MISID')->first();

        if($objLabel){  
            return Response::json(['exists' =>true,'msg' => 'Duplicate No']);
        }else{
            return Response::json(['not exists'=>true,'msg' => 'Ok']);
        }
        
        exit();
    }

    public function getStoreList(){
        return  DB::table('TBL_MST_STORE')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('BRID_REF','=',Session::get('BRID_REF'))
            ->where('STATUS','=','A')
            ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
            ->select('STID','STCODE','NAME')
            ->get();
    }

    public function getStoreName($id){
        return  DB::table('TBL_MST_STORE')
            ->where('STID','=',$id)
            ->select('STID','STCODE','NAME')
            ->first();
    }

    public function getDepartmentList(){
        return  DB::table('TBL_MST_DEPARTMENT')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('STATUS','=','A')
            //->whereRaw("NAME  NOT LIKE '%producation%'")
            ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
            ->select('DEPID','DCODE','NAME')
            ->get();
    }

    public function getDepartmentName($id){
        return  DB::table('TBL_MST_DEPARTMENT')
            ->where('DEPID','=',$id)
            ->select('DEPID','DCODE','NAME')
            ->first();
    }

    public function getLastdt(){
        $Status = "A";
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        return  DB::select('SELECT MAX(MIS_DT) MIS_DT FROM TBL_TRN_MISS01_HDR  
        WHERE  CYID_REF = ? AND BRID_REF = ?  AND VTID_REF = ? AND STATUS = ?', 
        [$CYID_REF, $BRID_REF,  $this->vtid_ref, 'A' ]);
    }

    public function getItemDetails(Request $request){
        $Status     =   $request['status'];
        $CodeNoId   =   $request['RGP_NO'];
        //$POID_REF = $request['POID_REF'];
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');
        $StdCost = 0;
        $Taxid = [];

        $AlpsStatus         =   $this->AlpsStatus();
        
        $ObjItem =  DB::select("SELECT 
        T1.ITEMID,T1.ICODE,T1.NAME,T1.ICID_REF,T1.ITEMGID_REF,T1.ALT_UOMID_REF,
        T1.ALPS_PART_NO,T1.CUSTOMER_PART_NO,T1.OEM_PART_NO,T1.BUID_REF,
        T2.* 
        FROM TBL_MST_ITEM T1
        INNER JOIN TBL_TRN_MRQS01_MAT T2 ON T1.ITEMID=T2.ITEMID_REF
        WHERE T1.CYID_REF = '$CYID_REF' 
        AND ( T1.DEACTIVATED IS NULL OR T1.DEACTIVATED = 0 ) AND T1.STATUS ='$Status' AND T2.MRSID_REF='$CodeNoId'");

       //dd($ObjItem); die;

        if(!empty($ObjItem)){

            foreach ($ObjItem as $index=>$dataRow){
                     
                $ObjMainUOM =  DB::select('SELECT TOP 1  UOMCODE, DESCRIPTIONS FROM TBL_MST_UOM  
                            WHERE  CYID_REF = ?  AND UOMID = ? 
                            AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?',
                            [$CYID_REF, $dataRow->MAIN_UOMID_REF, 'A' ]);

                $ObjAltUOM =  DB::select('SELECT TOP 1  UOMCODE, DESCRIPTIONS FROM TBL_MST_UOM  
                            WHERE  CYID_REF = ?  AND UOMID = ? 
                            AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?',
                            [$CYID_REF, $dataRow->ALT_UOMID_REF, $Status ]);
                    
                $ObjAltQTY =  DB::select('SELECT TOP 1  TO_QTY, FROM_QTY FROM TBL_MST_ITEM_UOMCONV  
                            WHERE  ITEMID_REF = ? AND TO_UOMID_REF = ? ',
                            [$dataRow->ITEMID,$dataRow->ALT_UOMID_REF]);

                $TOQTY =  isset($ObjAltQTY[0]->TO_QTY)? $ObjAltQTY[0]->TO_QTY : 0;

                //dd($TOQTY);

                //$FROMQTY =  isset($ObjAltQTY[0]->FROM_QTY)? $ObjAltQTY[0]->FROM_QTY : 0;
                
                $TOQTY =  0;
                $FROMQTY =  isset($dataRow->PENDING_QTY)? $dataRow->PENDING_QTY : 0;

                $ObjItemGroup =  DB::select('SELECT TOP 1 GROUPCODE, GROUPNAME FROM TBL_MST_ITEMGROUP  
                            WHERE  CYID_REF = ?  AND ITEMGID = ?
                            AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?', 
                            [$CYID_REF, $dataRow->ITEMGID_REF, 'A' ]);

                $ObjItemCategory =  DB::select('SELECT TOP 1 ICCODE, DESCRIPTIONS FROM TBL_MST_ITEMCATEGORY  
                            WHERE  CYID_REF = ?  AND ICID = ?
                            AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?', 
                            [$CYID_REF, $dataRow->ICID_REF, 'A' ]);


                    if(!is_null($dataRow->BUID_REF)){
                        $ObjBusinessUnit =  DB::select('SELECT TOP 1  BUCODE,BUNAME FROM TBL_MST_BUSINESSUNIT  
                        WHERE  CYID_REF = ? AND BRID_REF = ?  AND BUID = ?', 
                        [$CYID_REF, $BRID_REF, $dataRow->BUID_REF]);
                    }
                    else
                    {
                        $ObjBusinessUnit = NULL;
                    }
                        
                    $BusinessUnit       =   isset($ObjBusinessUnit) && $ObjBusinessUnit != NULL ? $ObjBusinessUnit[0]->BUCODE.'-'.$ObjBusinessUnit[0]->BUNAME : '';
                    $ALPS_PART_NO       =   $dataRow->ALPS_PART_NO;
                    $CUSTOMER_PART_NO   =   $dataRow->CUSTOMER_PART_NO;
                    $OEM_PART_NO        =   $dataRow->OEM_PART_NO;


                    $AultUmQuantity = $this->getAltUmQty($dataRow->ALT_UOMID_REF,$dataRow->ITEMID,$FROMQTY);

                    $desc6  =   $CodeNoId.'-'.$dataRow->ITEMID;

                    $row = '';
                    $row = $row.'<tr id="item_'.$dataRow->ITEMID .'"  class="clsitemid"><td  style="width:8%; text-align: center;"><input type="checkbox" id="chkId'.$dataRow->ITEMID.'"  value="'.$dataRow->ITEMID.'" class="js-selectall1"  ></td>';
                    $row = $row.'<td style="width:10%;">'.$dataRow->ICODE;
                    $row = $row.'<input type="hidden" id="uniquerowid_'.$desc6.'"   />';
                    $row = $row.'<input type="hidden" id="txtitem_'.$dataRow->ITEMID.'" data-desc="'.$dataRow->ICODE.'" data-desc6="'.$desc6.'"  data-desc7="'.$AultUmQuantity.'" data-desc8="'.$dataRow->PENDING_QTY.'"
                    value="'.$dataRow->ITEMID.'"/></td>
                    <td style="width:10%;" id="itemname_'.$dataRow->ITEMID.'" >'.$dataRow->NAME;
                    $row = $row.'<input type="hidden" id="txtitemname_'.$dataRow->ITEMID.'" data-desc="'.$dataRow->ITEM_SPECI.'"
                    value="'.$dataRow->NAME.'"/></td>';
                    $row = $row.'<td style="width:8%;" id="itemuom_'.$dataRow->ITEMID.'" ><input type="hidden" id="txtitemuom_'.$dataRow->ITEMID.'" data-desc="'.$ObjAltUOM[0]->UOMCODE.'-'.$ObjAltUOM[0]->DESCRIPTIONS.'" 
                    value="'.$dataRow->MAIN_UOMID_REF.'"/>'.$ObjMainUOM[0]->UOMCODE.'-'.$ObjMainUOM[0]->DESCRIPTIONS.'</td>';
                    $row = $row.'<td style="width:8%;" id="uomqty_'.$dataRow->ITEMID.'" ><input type="hidden" id="txtuomqty_'.$dataRow->ITEMID.'" data-desc="'.$TOQTY.'"
                    value="'.$dataRow->ALT_UOMID_REF.'"/>'.$FROMQTY.'</td>';
                    $row = $row.'<td style="width:8%;" id="irate_'.$dataRow->ITEMID.'"><input type="hidden" id="txtirate_'.$dataRow->ITEMID.'" data-desc="'.$FROMQTY.'"
                    value="'.$StdCost.'"/>'.$ObjItemGroup[0]->GROUPCODE.'-'.$ObjItemGroup[0]->GROUPNAME.'</td>';
                    $row = $row.'<td style="width:8%;" id="itax_'.$ObjItem[0]->ITEMID.'"><input type="hidden" id="txtitax_'.$ObjItem[0]->ITEMID.'" />'.$ObjItemCategory[0]->ICCODE.'-'.$ObjItemCategory[0]->DESCRIPTIONS.'</td>
                    
                    <td style="width:8%;">'.$BusinessUnit.'</td>
                    <td style="width:8%;" '.$AlpsStatus['hidden'].' >'.$ALPS_PART_NO.'</td>
                    <td style="width:8%;" '.$AlpsStatus['hidden'].' >'.$CUSTOMER_PART_NO.'</td>
                    <td style="width:8%;" '.$AlpsStatus['hidden'].' >'.$OEM_PART_NO.'</td>
                    <td style="width:8%;">Authorized</td>
                    </tr>';
                    echo $row;    
                } 
                    
                    
                }           
                else{
                 echo '<tr><td> Record not found.</td></tr>';
                }
        exit();
    }


    public function getStoreDetails(Request $request){

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $ROW_ID         =   $request['ROW_ID'];
        $RGP_NO         =   $request['RGP_NO'];
        //$POID_REF       =   $request['POID_REF'];
        $ITEMID_REF     =   $request['ITEMID_REF'];
        $MAIN_UOMID_DES =   $request['MAIN_UOMID_DES'];
        $MAIN_UOMID_REF =   $request['MAIN_UOMID_REF'];
        $ALT_UOMID_DES  =   $request['ALT_UOMID_DES'];
        $ALT_UOMID_REF  =   $request['ALT_UOMID_REF'];
        $ITEMROWID      =   $request['ITEMROWID'];
        $ACTION_TYPE    =   $request['ACTION_TYPE'] =="VIEW"?'disabled':'';
        $SRNOA          =   NULL;
        $BATCHNOA       =   NULL;
        $dataArr        =   array();
        $dataArr2       =   array();
        $dataArr3       =   array();

        if($ITEMROWID !=""){
            $exp        =   explode(",",$ITEMROWID);

            foreach($exp as $val){
                $keyid      =   explode("_",$val);
                $batchid    =   $keyid[0];
                $qty        =   $keyid[1];
               // $LOT        =   $keyid[2];
                //$VENDLOT    =   $keyid[3];
                $dataArr[$batchid]  =   $qty;
                //$dataArr2[$batchid]  =   $LOT;
                //$dataArr3[$batchid]  =   $VENDLOT;
            }
        }

        $objResponse =  DB::table('TBL_MST_ITEMCHECKFLAG')
            ->where('ITEMID_REF','=',$ITEMID_REF)
            ->select('SRNOA','BATCHNOA')
            ->first();

        if(!empty($objResponse)){
            $SRNOA      =   $objResponse->SRNOA;
            $BATCHNOA   =   $objResponse->BATCHNOA;
        }

        // $objBatch =  DB::SELECT("SELECT STID,STCODE,NAME AS STNAME ,
        // (SELECT SUM(CURRENT_QTY)  FROM TBL_MST_BATCH WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' AND FYID_REF='$FYID_REF'
        // AND STATUS='A' AND STID_REF=STID AND ITEMID_REF='$ITEMID_REF') AS TOTAL_STOCK
        // FROM TBL_MST_STORE WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' AND FYID_REF='$FYID_REF'
        // AND STATUS='A' AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 )
        // ");

        $WHERE_CURRENT_QTY  =   $request['ACTION_TYPE'] =="ADD"?" AND T1.CURRENT_QTY > 0":"";
        $objBatch =  DB::SELECT("SELECT 
        T1.BATCHID,T1.BATCH_CODE,T1.CURRENT_QTY AS TOTAL_STOCK,
        T2.STID,T2.STCODE,T2.NAME AS STNAME
        FROM TBL_MST_BATCH T1 
        LEFT JOIN TBL_MST_STORE T2 ON T2.STID=T1.STID_REF
        WHERE T1.STATUS='A' AND T1.CYID_REF ='$CYID_REF' AND T1.BRID_REF ='$BRID_REF' AND T1.FYID_REF ='$FYID_REF' AND T1.ITEMID_REF ='$ITEMID_REF' AND T1.UOMID_REF ='$MAIN_UOMID_REF' $WHERE_CURRENT_QTY
        ");

     
        echo '<thead>';
        echo '<tr>';
        echo '<th>Batch/Store</th>';
        echo '<th>Main UoM (MU)</th>';
        echo '<th>Stock-in-hand</th>';
        echo '<th>Issued Qty (MU)</th>';
        echo '<th>Alt UOM (AU)</th>';
        echo '<th>Issued Qty (AU)</th>';
        //echo '<th>Our Lot No</th>';
        //echo '<th>Vendor Lot No</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach($objBatch as $key=>$val){

            $BATCHID    =   $val->BATCHID;

            $TOTAL_STOCK    =   $val->TOTAL_STOCK !=""?$val->TOTAL_STOCK:0;

            $StoreRowId     =   $val->STID.'#'.$RGP_NO.'#'.$BATCHID.'#'.$ITEMID_REF.'#'.$MAIN_UOMID_REF.'#'.$ALT_UOMID_REF;

            $qtyvalue       =   array_key_exists($StoreRowId, $dataArr)?$dataArr[$StoreRowId]:0;
            $AluQty         =   $this->getAltUmQty($ALT_UOMID_REF,$ITEMID_REF,$qtyvalue);

            // if($request['ACTION_TYPE'] =="ADD"){
            //     $CURRENT_QTY=$TOTAL_STOCK;
            // }
            // else{
                
            //     $CURRENT_QTY=(floatval($TOTAL_STOCK)+floatval($qtyvalue));
            // }

            $CURRENT_QTY=$TOTAL_STOCK;

            $MainReceivedQty    =   $qtyvalue > 0?$qtyvalue:'';
            $AultReceivedQty    =   $AluQty > 0?$AluQty:'';       
            
            //$LOT_NO       =   array_key_exists($StoreRowId, $dataArr2)?$dataArr2[$StoreRowId]:'';
            //$VENDOR_LOTNO =   array_key_exists($StoreRowId, $dataArr3)?$dataArr3[$StoreRowId]:'';
        
            echo '<tr  class="participantRow33">';
            echo '<td hidden><input type="text" id="'.$key.'" value="'.$ROW_ID.'" ></td>';
            echo '<td style="width:25%">'.$val->BATCH_CODE.' / '.$val->STCODE.' - '.$val->STNAME.'</td>';
            echo '<td style="width:10%">'.$MAIN_UOMID_DES.'</td>';
            echo '<td style="width:10%">'.$CURRENT_QTY.'</td>';
            echo '<td style="width:15%"><input '.$ACTION_TYPE.' type="text" name="UserQty_'.$key.'" id="UserQty_'.$key.'"  value="'.$MainReceivedQty.'" onkeyup="checkStoreQty('.$ROW_ID.','.$ITEMID_REF.','.$ALT_UOMID_REF.',this.value,'.$key.','.$CURRENT_QTY.')" class="qtytext"  onkeypress="return isNumberDecimalKey(event,this)" autocomplete="off"  ></td>';
            echo '<td style="width:10%">'.$ALT_UOMID_DES.'</td>';
            echo '<td style="width:15%"><input '.$ACTION_TYPE.' type="text" name="AltUserQty_'.$key.'" id="AltUserQty_'.$key.'" value="'.$AultReceivedQty.'" class="qtytext"  autocomplete="off" readonly  ></td>';
            //echo '<td style="width:10%"><input '.$ACTION_TYPE.' type="text" name="LOT_NO_'.$key.'" id="LOT_NO_'.$key.'" value="'.$LOT_NO.'"  class="qtytext" autocomplete="off"  ></td>';
            //echo '<td style="width:10%"><input '.$ACTION_TYPE.' type="text" name="VENDOR_LOTNO_'.$key.'" id="VENDOR_LOTNO_'.$key.'" value="'.$VENDOR_LOTNO.'"  class="qtytext"  autocomplete="off"  ></td>';
            echo '<td hidden><input type="hidden" name="BATCHID_'.$key.'" id="BATCHID_'.$key.'" value="'.$StoreRowId.'" class="qtytext" ></td>';
            echo '<td hidden><input type="hidden" name="ROWID_'.$key.'" id="ROWID_'.$key.'" value="'.$ROW_ID.'" class="qtytext" ></td>';
            echo '<td hidden><input type="hidden" name="TOTAL_STOCK_'.$key.'" id="TOTAL_STOCK_'.$key.'" value="'.$CURRENT_QTY.'" class="qtytext" ></td>';
            echo '<td hidden><input type="hidden" name="BATCHNOA_'.$key.'" id="BATCHNOA_'.$key.'" value="'.$BATCHNOA.'" class="qtytext" ></td>';
            echo '</tr>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        exit();
    }

    public function getCodeNo(Request $request){
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');
        $DEPID_REF      =   $request['id'];
        $fieldid    = $request['fieldid'];

        $ObjData =  DB::select("SELECT MRSID,MRS_NO,MRS_DT 
        FROM TBL_TRN_MRQS01_HDR 
        WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' AND FYID_REF='$FYID_REF' AND DEPID_REF='$DEPID_REF' AND STATUS='A'
        AND MRSID IN (SELECT MRSID_REF FROM TBL_TRN_MRQS01_MAT WHERE PENDING_QTY > '0.000')");


        if(!empty($ObjData)){
            foreach ($ObjData as $index=>$dataRow){
                
                $row = '';
                $row = $row.'<tr >
                <td class="ROW1"> <input type="checkbox" name="SELECT_'.$fieldid.'[]" id="rgpcode_'.$dataRow->MRSID .'"  class="clssqid" value="'.$dataRow->MRSID.'" ></td>
                <td class="ROW2">'.$dataRow->MRS_NO;
                $row = $row.'<input type="hidden" id="txtrgpcode_'.$dataRow->MRSID.'" data-desc="'.$dataRow->MRS_NO.'"  value="'.$dataRow->MRSID.'"/></td>
                <td class="ROW3">'.$dataRow->MRS_DT.'</td></tr>';
                echo $row;
                
            }

        }else{
            echo '<tr><td colspan="2">Record not found.</td></tr>';
        }
    }

    public function getAltUmQty($id,$itemid,$mqty){

        $ObjData =  DB::select('SELECT top 1 TO_QTY, FROM_QTY FROM TBL_MST_ITEM_UOMCONV WHERE  ITEMID_REF = ? AND TO_UOMID_REF =?', [$itemid,$id]);
    
        if(!empty($ObjData)){
            $auomqty = ($mqty/$ObjData[0]->FROM_QTY)*($ObjData[0]->TO_QTY);
            return $auomqty;
        }else{
           return 0;
        }
    }

    public function changeAltUm(Request $request){

        $id       = $request['altumid'];
        $itemid   = $request['itemid'];
        $mqty     = $request['mqty'];

        $ObjData =  DB::select('SELECT top 1 TO_QTY, FROM_QTY FROM TBL_MST_ITEM_UOMCONV WHERE  ITEMID_REF = ? AND TO_UOMID_REF =?', [$itemid,$id]);
    
        if(!empty($ObjData)){
            $auomqty = ($mqty/$ObjData[0]->FROM_QTY)*($ObjData[0]->TO_QTY);
            echo $auomqty;
        }else{
            echo '0';
        }
        exit();
    }


    

    public function getTotalDateWiseStock(Request $request){

        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');
           
        if(isset($request['item_array']) && !empty($request['item_array'])){
            foreach($request['item_array'] as $key=>$val){
    
                $DOC_DT         =   $val['MISRDT'];
                $ITEMID_REF     =   $val['ITEMID_REF'];
                $UOMID_REF      =   $val['MAIN_UOMID_REF'];
                $RECEIVED_QTY   =   floatval($val['RECEIVED_QTY_MU']);
                $MAIN_ITEM_CODE =   $val['MAIN_ITEM_CODE'];
                $SUB_ITEM_CODE  =   $val['ITEMID_CODE'];
                $SUB_ITEM_NAME  =   $val['ITEMID_NAME'];
    
                $data           =   DB::select("SELECT SUM(A.CURRENT_QTY) AS TOTAL_CURRENT_STOCK 
                                    FROM TBL_MST_BATCH A (NOLOCK) INNER JOIN TBL_MST_STOCK_BATCH_HIS B (NOLOCK) 
                                    ON A.BATCHID = B.BATCHID_REF AND A.ITEMID_REF = B.ITEMID_REF AND A.UOMID_REF = B.UOMID_REF
                                    WHERE A.CYID_REF ='$CYID_REF' AND A.BRID_REF ='$BRID_REF' AND A.STATUS='A'  
                                    AND B.DATE <= '$DOC_DT' AND A.ITEMID_REF ='$ITEMID_REF' AND A.UOMID_REF ='$UOMID_REF' ");
    
    
                $TOTAL_STOCK    =   floatval($data[0]->TOTAL_CURRENT_STOCK);
    
                if($RECEIVED_QTY > $TOTAL_STOCK){
                    return Response::json(['result' =>false,'message' =>'Stock is not avaliable as per document date for Issued Qty for ('.$SUB_ITEM_CODE.' - '.$SUB_ITEM_NAME.') in material tab.']);
                    exit();
                }
    
            }
      
        }
    
        return Response::json(['result' =>true,'message' => '']);
        exit(); 
    }

    
}
