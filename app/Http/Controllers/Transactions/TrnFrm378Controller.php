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

class TrnFrm378Controller extends Controller{

    protected $form_id  = 378;
    protected $vtid_ref = 464;
    protected $view     = "transactions.inventory.StockToStockTransafer.trnfrm";
   
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

        $objDataList	=	DB::select("select hdr.ST_STID,hdr.ST_ST_DOCNO,hdr.ST_ST_DOCDT,hdr.INDATE,hdr.ST_ST_TYPE,
                            (
                            SELECT TOP 1 USR.DESCRIPTIONS FROM TBL_TRN_AUDITTRAIL AUD 
                            LEFT JOIN TBL_MST_USER USR ON AUD.USERID=USR.USERID 
                            WHERE  AUD.VID=hdr.ST_STID AND  AUD.CYID_REF=hdr.CYID_REF AND  AUD.BRID_REF=hdr.BRID_REF AND  
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
                            inner join TBL_TRN_STOCK_STOCK_HDR hdr
                            on a.VID = hdr.ST_STID 
                            and a.VTID_REF = hdr.VTID_REF 
                            and a.CYID_REF = hdr.CYID_REF 
                            and a.BRID_REF = hdr.BRID_REF
                            where a.VTID_REF = '$this->vtid_ref'
                            and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF' AND hdr.FYID_REF='$FYID_REF'
                            and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                            ORDER BY hdr.ST_STID DESC ");

                        if(isset($objDataList) && !empty($objDataList)){
                            
                            foreach($objDataList as $key=>$val){

                                $ST_STID    =   $val->ST_STID;

                                $data = DB::select("SELECT TOP 1 
                                M1.QTY,I1.ALPS_PART_NO AS OUT_ALPS_PART_NO,I2.ALPS_PART_NO AS IN_ALPS_PART_NO
                                FROM TBL_TRN_STOCK_STOCK_MAT M1 
                                LEFT JOIN TBL_MST_ITEM I1 ON M1.ITEMID_REF=I1.ITEMID
                                LEFT JOIN TBL_MST_ITEM I2 ON M1.ITEMID_REF_IN=I2.ITEMID
                                WHERE ST_STID_REF='$ST_STID'");  

                                $objDataList[$key]->QTY               =  isset($data[0]->QTY) && $data[0]->QTY !=''?$data[0]->QTY:NULL;
                                $objDataList[$key]->OUT_ALPS_PART_NO  =  isset($data[0]->OUT_ALPS_PART_NO) && $data[0]->OUT_ALPS_PART_NO !=''?$data[0]->OUT_ALPS_PART_NO:NULL;
                                $objDataList[$key]->IN_ALPS_PART_NO   =  isset($data[0]->IN_ALPS_PART_NO) && $data[0]->IN_ALPS_PART_NO !=''?$data[0]->IN_ALPS_PART_NO:NULL;

                            }

                        }



                            $REQUEST_DATA   =   array(
                                'FORMID'    =>  $this->form_id,
                                'VTID_REF'  =>  $this->vtid_ref,
                                'USERID'    =>  Auth::user()->USERID,
                                'CYID_REF'  =>  Auth::user()->CYID_REF,
                                'BRID_REF'  =>  Session::get('BRID_REF'),
                                'FYID_REF'  =>  Session::get('FYID_REF'),
                            );

                            $AlpsStatus =   $this->AlpsStatus();

                            $TabSetting	=	Helper::getAddSetting(Auth::user()->CYID_REF,'ITEM_TAB_SETTING');

        return view($this->view.$FormId,compact(['REQUEST_DATA','objRights','objDataList','FormId','AlpsStatus','TabSetting']));
    }
	
	public function ViewReport($request) 
    {
        $box = $request;        
        $myValue=  array();
        parse_str($box, $myValue);
       // dd($myValue);  
        $ST_STID        	=   $myValue['ST_STID'];
        $Flag       		=   $myValue['Flag'];

       /*  $objSalesOrder = DB::table('TBL_TRN_SLSO01_HDR')
        ->where('TBL_TRN_SLSO01_HDR.CYID_REF','=',Auth::user()->CYID_REF)
        ->where('TBL_TRN_SLSO01_HDR.BRID_REF','=',Auth::user()->BRID_REF)
        ->where('TBL_TRN_SLSO01_HDR.SOID','=',$SOID)
        ->select('TBL_TRN_SLSO01_HDR.*')
        ->first(); */
        
        
        $ssrs = new \SSRS\Report('http://103.139.58.23:8181//ReportServer/', array('username' => 'Administrator', 'password' => 'VRt+wDPuDYLwxxC'));
        $result = $ssrs->loadReport('/UNICORN/Stock_to_Stock_Print');
        
        $reportParameters = array(
            'ST_STID' => $ST_STID,
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

        $doc_req    =   array(
            'VTID_REF'=>$this->vtid_ref,
            'HDR_TABLE'=>'TBL_TRN_STOCK_STOCK_HDR',
            'HDR_ID'=>'ST_STID',
            'HDR_DOC_NO'=>'ST_ST_DOCNO',
            'HDR_DOC_DT'=>'ST_ST_DOCDT'
        );
        $docarray   =   $this->getManualAutoDocNo(date('Y-m-d'),$doc_req);
        
        
   
        $FormId     =   $this->form_id;
        $AlpsStatus =   $this->AlpsStatus();

        $TabSetting	=	Helper::getAddSetting(Auth::user()->CYID_REF,'ITEM_TAB_SETTING');
        
        return view($this->view.$FormId.'add',compact(['AlpsStatus','FormId','objlastdt','TabSetting','doc_req','docarray']));       
    }

    public function save(Request $request) {

        $r_count1 = $request['Row_Count1'];
        $r_count2 = $request['Row_Count2'];
        
        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $STID_REF       =   $this->getMaterialStore($request['HiddenRowId_'.$i]);
                $STID_REF_IN    =   $this->getMaterialStore($request['HiddenRowId_IN_'.$i]);

                $req_data[$i] = [
                    'ITEMID_REF'       => $request['ITEMID_REF_'.$i],
                    'UOMID_REF'        => $request['MAIN_UOMID_REF_'.$i],
                    'STID'             => $STID_REF,
                    'QTY'              => $request['QTY_'.$i],
                    'RATE'             => $request['RATE_'.$i],

                    'ITEMID_REF_IN'       => $request['ITEMID_REF_IN_'.$i],
                    'UOMID_REF_IN'        => $request['MAIN_UOMID_REF_IN_'.$i],
                    'STID_IN'             => $STID_REF_IN,
                    'QTY_IN'              => $request['QTY_IN_'.$i],
                    'RATE_IN'             => $request['RATE_IN_'.$i],

                    'REASON'           => $request['REASON_'.$i],
                    'REMARKS'          => $request['REMARKS_'.$i],
                    'BATCH_QTY'        => $request['HiddenRowId_'.$i],
                    'BATCH_QTY_IN'        => $request['HiddenRowId_IN_'.$i],
                ];
            }
        }

        
        $wrapped_links["MAT"] = $req_data; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);


        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $dataArr    =   array();
                $ITEMID_REF =   $request['ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['HiddenRowId_'.$i];
                $ITEMROWID_IN  =   $request['HiddenRowId_IN_'.$i];

                if($ITEMROWID !=""){
                    $exp        =   explode(",",$ITEMROWID);

                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];

                        $dataArr[$batchid]['QTY'] =   $keyid[1];
                        $dataArr[$batchid]['STOCK_INHAND']  =  $keyid[2];
                        $dataArr[$batchid]['STOCK_TYPE']  =  'OUT';
                    }
                }

                if($ITEMROWID_IN !=""){
                    $exp        =   explode(",",$ITEMROWID_IN);

                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];

                        $dataArr[$batchid]['QTY'] =   $keyid[1];
                        $dataArr[$batchid]['STOCK_INHAND']  =  $keyid[2];
                        $dataArr[$batchid]['STOCK_TYPE']  =  'IN';
                    }
                }

                if(!empty($dataArr)){
                    foreach($dataArr as $key=>$val){

                        $ExpID              =   explode("#",$key);
                        $STID_REF           =   $ExpID[0];
                        $BATCH_CODE         =   $ExpID[1];
                        $ITEMID_REF         =   $ExpID[2];
                        $UOMID_REF          =   $ExpID[3];
                        
                        $req_data33[$i][] = [
                            'ITEMID_REF'        => $ITEMID_REF,
                            'MAIN_UOMID_REF'    => $UOMID_REF,
                            'STID_REF'          => $STID_REF,
                            'BATCH_CODE'        => $BATCH_CODE,
                            'QTY'               => $val['QTY'],
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            'STOCK_TYPE'      => $val['STOCK_TYPE'], 
                        ];

                    }
                }
            }
        }


        $wrapped_links33["STORE"] = $req_data33; 
        $XMLSTORE = ArrayToXml::convert($wrapped_links33);

        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = 'ADD';
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $ST_ST_DOCNO     = $request['ST_ST_DOCNO'];
        $ST_ST_DOCDT     = $request['ST_ST_DOCDT'];
        $ST_ST_TYPE      = $request['ST_ST_TYPE'];
       
        $log_data = [ 
            $ST_ST_DOCNO,$ST_ST_DOCDT,$CYID_REF,$BRID_REF,$FYID_REF,
            $VTID_REF,$XMLMAT,$XMLSTORE,$USERID,Date('Y-m-d'),
            Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS,$ST_ST_TYPE
        ];  

        $sp_result = DB::select('EXEC SP_STOCK_STOCK_IN ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?', $log_data);  


        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => $sp_result[0]->RESULT]);

        }else{
            return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
        }
        exit();   
    }

    public function getMaterialStore($ITEMROWID){
        $StoreArr   =   array();
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

        return $STID_REF;
    }



    public function edit($id=NULL){
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF'); 
        $Status     =   'A';
        
        if(!is_null($id)){

            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $objResponse =  DB::table('TBL_TRN_STOCK_STOCK_HDR')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('BRID_REF','=',Session::get('BRID_REF'))
            ->where('ST_STID','=',$id)
            ->first();

            $objlastdt          =   $this->getLastdt();
              
            $objMAT = DB::select("SELECT 
            T1.*,T2.ICODE,T2.NAME AS ITEM_NAME,T2.ITEM_SPECI,T2.ALPS_PART_NO, T2.CUSTOMER_PART_NO, T2.OEM_PART_NO,
            T3.UOMCODE,T3.DESCRIPTIONS,
            T4.ICODE AS ICODE_IN ,T4.NAME AS ITEM_NAME_IN,T4.ALPS_PART_NO AS ALPS_PART_NO_IN, T4.CUSTOMER_PART_NO AS CUSTOMER_PART_NO_IN, T4.OEM_PART_NO AS OEM_PART_NO_IN,
            T5.UOMCODE AS UOMCODE_IN,T5.DESCRIPTIONS AS DESCRIPTIONS_IN
            FROM TBL_TRN_STOCK_STOCK_MAT T1
            LEFT JOIN TBL_MST_ITEM T2 ON T1.ITEMID_REF=T2.ITEMID
            LEFT JOIN TBL_MST_UOM T3 ON T1.UOMID_REF=T3.UOMID
            LEFT JOIN TBL_MST_ITEM T4 ON T1.ITEMID_REF_IN=T4.ITEMID
            LEFT JOIN TBL_MST_UOM T5 ON T1.UOMID_REF_IN=T5.UOMID
            WHERE T1.ST_STID_REF='$id' ORDER BY T1.ST_ST_MATID ASC"); 
 
            if(isset($objMAT) && !empty($objMAT)){
                foreach($objMAT as $key=>$val){

                    $STID       =   $val->STID;
                    $STID_IN    =   $val->STID_IN;

                    if($STID !=""){
                        $STORE_DATA = DB::select("select distinct stuff((select ',' + t.[NAME] from TBL_MST_STORE t where STID in($STID) order by t.[NAME] for xml path('') ),1,1,'') as STORE_NAME from TBL_MST_STORE t1 where STID in($STID)"); 
                        $STORE_NAME =   isset($STORE_DATA[0]->STORE_NAME) && $STORE_DATA[0]->STORE_NAME !=""?$STORE_DATA[0]->STORE_NAME:NULL; 
                        $objMAT[$key]->STORE_NAME=$STORE_NAME;
                    }

                    if($STID_IN !=""){
                        $STORE_DATA_IN = DB::select("select distinct stuff((select ',' + t.[NAME] from TBL_MST_STORE t where STID in($STID_IN) order by t.[NAME] for xml path('') ),1,1,'') as STORE_NAME_IN from TBL_MST_STORE t1 where STID in($STID_IN)"); 
                        $STORE_NAME_IN =   isset($STORE_DATA_IN[0]->STORE_NAME_IN) && $STORE_DATA_IN[0]->STORE_NAME_IN !=""?$STORE_DATA_IN[0]->STORE_NAME_IN:NULL; 
                        $objMAT[$key]->STORE_NAME_IN=$STORE_NAME_IN;
                    }
                   
                }
            }

           

            $FormId         =   $this->form_id;
            $AlpsStatus =   $this->AlpsStatus();
            $ActionStatus   =   "";

            $TabSetting	=	Helper::getAddSetting(Auth::user()->CYID_REF,'ITEM_TAB_SETTING');
        
            return view($this->view.$FormId.'edit',compact(['AlpsStatus','FormId','objRights','objlastdt','objResponse','objMAT','ActionStatus','TabSetting']));      

        }
     
    }

    public function update(Request $request){
        
        $r_count1 = $request['Row_Count1'];
        $r_count2 = $request['Row_Count2'];
        
        
        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $STID_REF       =   $this->getMaterialStore($request['HiddenRowId_'.$i]);
                $STID_REF_IN    =   $this->getMaterialStore($request['HiddenRowId_IN_'.$i]);

                $req_data[$i] = [
                    'ITEMID_REF'       => $request['ITEMID_REF_'.$i],
                    'UOMID_REF'        => $request['MAIN_UOMID_REF_'.$i],
                    'STID'             => $STID_REF,
                    'QTY'              => $request['QTY_'.$i],
                    'RATE'             => $request['RATE_'.$i],

                    'ITEMID_REF_IN'       => $request['ITEMID_REF_IN_'.$i],
                    'UOMID_REF_IN'        => $request['MAIN_UOMID_REF_IN_'.$i],
                    'STID_IN'             => $STID_REF_IN,
                    'QTY_IN'              => $request['QTY_IN_'.$i],
                    'RATE_IN'             => $request['RATE_IN_'.$i],

                    'REASON'           => $request['REASON_'.$i],
                    'REMARKS'          => $request['REMARKS_'.$i],
                    'BATCH_QTY'        => $request['HiddenRowId_'.$i],
                    'BATCH_QTY_IN'        => $request['HiddenRowId_IN_'.$i],
                ];
            }
        }

        
        $wrapped_links["MAT"] = $req_data; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);
            
        
        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $dataArr    =   array();
                $ITEMID_REF =   $request['ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['HiddenRowId_'.$i];
                $ITEMROWID_IN  =   $request['HiddenRowId_IN_'.$i];

                if($ITEMROWID !=""){
                    $exp        =   explode(",",$ITEMROWID);

                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];

                        $dataArr[$batchid]['QTY'] =   $keyid[1];
                        $dataArr[$batchid]['STOCK_INHAND']  =  $keyid[2];
                        $dataArr[$batchid]['STOCK_TYPE']  =  'OUT';
                    }
                }

                if($ITEMROWID_IN !=""){
                    $exp        =   explode(",",$ITEMROWID_IN);

                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];

                        $dataArr[$batchid]['QTY'] =   $keyid[1];
                        $dataArr[$batchid]['STOCK_INHAND']  =  $keyid[2];
                        $dataArr[$batchid]['STOCK_TYPE']  =  'IN';
                    }
                }

                if(!empty($dataArr)){
                    foreach($dataArr as $key=>$val){

                        $ExpID              =   explode("#",$key);
                        $STID_REF           =   $ExpID[0];
                        $BATCH_CODE         =   $ExpID[1];
                        $ITEMID_REF         =   $ExpID[2];
                        $UOMID_REF          =   $ExpID[3];
                        
                        $req_data33[$i][] = [
                            'ITEMID_REF'        => $ITEMID_REF,
                            'MAIN_UOMID_REF'    => $UOMID_REF,
                            'STID_REF'          => $STID_REF,
                            'BATCH_CODE'        => $BATCH_CODE,
                            'QTY'               => $val['QTY'],
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            'STOCK_TYPE'      => $val['STOCK_TYPE'], 
                        ];

                    }
                }
            }
        }

        $wrapped_links33["STORE"] = $req_data33; 
        $XMLSTORE = ArrayToXml::convert($wrapped_links33);

        
        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = 'EDIT';
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $ST_ST_DOCNO     = $request['ST_ST_DOCNO'];
        $ST_ST_DOCDT     = $request['ST_ST_DOCDT'];
        $ST_ST_TYPE      = $request['ST_ST_TYPE'];
       
        $log_data = [ 
            $ST_ST_DOCNO,$ST_ST_DOCDT,$CYID_REF,$BRID_REF,$FYID_REF,
            $VTID_REF,$XMLMAT,$XMLSTORE,$USERID,Date('Y-m-d'),
            Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS,$ST_ST_TYPE
        ];  

        $sp_result = DB::select('EXEC SP_STOCK_STOCK_UP ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?', $log_data);
        

        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => $ST_ST_DOCNO. ' Sucessfully Updated.']);

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

            $objResponse =  DB::table('TBL_TRN_STOCK_STOCK_HDR')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('BRID_REF','=',Session::get('BRID_REF'))
            ->where('ST_STID','=',$id)
            ->first();

            $objlastdt          =   $this->getLastdt();
              
            $objMAT = DB::select("SELECT 
            T1.*,T2.ICODE,T2.NAME AS ITEM_NAME,T2.ITEM_SPECI,T2.ALPS_PART_NO, T2.CUSTOMER_PART_NO, T2.OEM_PART_NO,
            T3.UOMCODE,T3.DESCRIPTIONS,
            T4.ICODE AS ICODE_IN ,T4.NAME AS ITEM_NAME_IN,T4.ALPS_PART_NO AS ALPS_PART_NO_IN, T4.CUSTOMER_PART_NO AS CUSTOMER_PART_NO_IN, T4.OEM_PART_NO AS OEM_PART_NO_IN,
            T5.UOMCODE AS UOMCODE_IN,T5.DESCRIPTIONS AS DESCRIPTIONS_IN
            FROM TBL_TRN_STOCK_STOCK_MAT T1
            LEFT JOIN TBL_MST_ITEM T2 ON T1.ITEMID_REF=T2.ITEMID
            LEFT JOIN TBL_MST_UOM T3 ON T1.UOMID_REF=T3.UOMID
            LEFT JOIN TBL_MST_ITEM T4 ON T1.ITEMID_REF_IN=T4.ITEMID
            LEFT JOIN TBL_MST_UOM T5 ON T1.UOMID_REF_IN=T5.UOMID
            WHERE T1.ST_STID_REF='$id' ORDER BY T1.ST_ST_MATID ASC"); 

            if(isset($objMAT) && !empty($objMAT)){
                foreach($objMAT as $key=>$val){

                    $STID       =   $val->STID;
                    $STID_IN    =   $val->STID_IN;

                    $STORE_DATA = DB::select("select distinct stuff((select ',' + t.[NAME] from TBL_MST_STORE t where STID in($STID) order by t.[NAME] for xml path('') ),1,1,'') as STORE_NAME from TBL_MST_STORE t1 where STID in($STID)"); 
                    $STORE_NAME =   isset($STORE_DATA[0]->STORE_NAME) && $STORE_DATA[0]->STORE_NAME !=""?$STORE_DATA[0]->STORE_NAME:NULL; 
                    
                    $STORE_DATA_IN = DB::select("select distinct stuff((select ',' + t.[NAME] from TBL_MST_STORE t where STID in($STID_IN) order by t.[NAME] for xml path('') ),1,1,'') as STORE_NAME_IN from TBL_MST_STORE t1 where STID in($STID_IN)"); 
                    $STORE_NAME_IN =   isset($STORE_DATA_IN[0]->STORE_NAME_IN) && $STORE_DATA_IN[0]->STORE_NAME_IN !=""?$STORE_DATA_IN[0]->STORE_NAME_IN:NULL; 

                    $objMAT[$key]->STORE_NAME=$STORE_NAME;
                    $objMAT[$key]->STORE_NAME_IN=$STORE_NAME_IN;
                   
                }
            }

            $FormId         =   $this->form_id;
            $AlpsStatus =   $this->AlpsStatus();
            $ActionStatus   =   "disabled";

            $TabSetting	=	Helper::getAddSetting(Auth::user()->CYID_REF,'ITEM_TAB_SETTING');
        
            return view($this->view.$FormId.'view',compact(['AlpsStatus','FormId','objRights','objlastdt','objResponse','objMAT','ActionStatus','TabSetting']));      

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

                $STID_REF       =   $this->getMaterialStore($request['HiddenRowId_'.$i]);
                $STID_REF_IN    =   $this->getMaterialStore($request['HiddenRowId_IN_'.$i]);

                $req_data[$i] = [
                    'ITEMID_REF'       => $request['ITEMID_REF_'.$i],
                    'UOMID_REF'        => $request['MAIN_UOMID_REF_'.$i],
                    'STID'             => $STID_REF,
                    'QTY'              => $request['QTY_'.$i],
                    'RATE'             => $request['RATE_'.$i],

                    'ITEMID_REF_IN'       => $request['ITEMID_REF_IN_'.$i],
                    'UOMID_REF_IN'        => $request['MAIN_UOMID_REF_IN_'.$i],
                    'STID_IN'             => $STID_REF_IN,
                    'QTY_IN'              => $request['QTY_IN_'.$i],
                    'RATE_IN'             => $request['RATE_IN_'.$i],

                    'REASON'           => $request['REASON_'.$i],
                    'REMARKS'          => $request['REMARKS_'.$i],
                    'BATCH_QTY'        => $request['HiddenRowId_'.$i],
                    'BATCH_QTY_IN'        => $request['HiddenRowId_IN_'.$i],
                ];
            }
        }

        
        $wrapped_links["MAT"] = $req_data; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);
            
        
        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i])){

                $dataArr    =   array();
                $ITEMID_REF =   $request['ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['HiddenRowId_'.$i];
                $ITEMROWID_IN  =   $request['HiddenRowId_IN_'.$i];

                if($ITEMROWID !=""){
                    $exp        =   explode(",",$ITEMROWID);

                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];

                        $dataArr[$batchid]['QTY'] =   $keyid[1];
                        $dataArr[$batchid]['STOCK_INHAND']  =  $keyid[2];
                        $dataArr[$batchid]['STOCK_TYPE']  =  'OUT';
                    }
                }

                if($ITEMROWID_IN !=""){
                    $exp        =   explode(",",$ITEMROWID_IN);

                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];

                        $dataArr[$batchid]['QTY'] =   $keyid[1];
                        $dataArr[$batchid]['STOCK_INHAND']  =  $keyid[2];
                        $dataArr[$batchid]['STOCK_TYPE']  =  'IN';
                    }
                }

                if(!empty($dataArr)){
                    foreach($dataArr as $key=>$val){

                        $ExpID              =   explode("#",$key);
                        $STID_REF           =   $ExpID[0];
                        $BATCH_CODE         =   $ExpID[1];
                        $ITEMID_REF         =   $ExpID[2];
                        $UOMID_REF          =   $ExpID[3];
                        
                        $req_data33[$i][] = [
                            'ITEMID_REF'        => $ITEMID_REF,
                            'MAIN_UOMID_REF'    => $UOMID_REF,
                            'STID_REF'          => $STID_REF,
                            'BATCH_CODE'        => $BATCH_CODE,
                            'QTY'               => $val['QTY'],
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            'STOCK_TYPE'      => $val['STOCK_TYPE'], 
                        ];

                    }
                }
            }
        }

        $wrapped_links33["STORE"] = $req_data33; 
        $XMLSTORE = ArrayToXml::convert($wrapped_links33);


        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = $Approvallevel;
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $ST_ADJUST_DOCNO     = $request['ST_ADJUST_DOCNO'];
        $ST_ADJUST_DOCDT     = $request['ST_ADJUST_DOCDT'];
        $ST_ADJUST_TYPE      = $request['ST_ADJUST_TYPE'];
       
        $ST_ST_DOCNO     = $request['ST_ST_DOCNO'];
        $ST_ST_DOCDT     = $request['ST_ST_DOCDT'];
        $ST_ST_TYPE      = $request['ST_ST_TYPE'];
       
        $log_data = [ 
            $ST_ST_DOCNO,$ST_ST_DOCDT,$CYID_REF,$BRID_REF,$FYID_REF,
            $VTID_REF,$XMLMAT,$XMLSTORE,$USERID,Date('Y-m-d'),
            Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS,$ST_ST_TYPE
        ];  

        $sp_result = DB::select('EXEC SP_STOCK_STOCK_UP ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?', $log_data);   

        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => $ST_ADJUST_DOCNO. ' Sucessfully Approved.']);

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
        $TABLE      =   "TBL_TRN_STOCK_STOCK_HDR";
        $FIELD      =   "ST_STID";
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
        $TABLE      =   "TBL_TRN_STOCK_STOCK_HDR";
        $FIELD      =   "ST_STID";
        $ID         =   $id;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();

        $req_data[0]=[
         'NT'  => 'TBL_TRN_STOCK_STOCK_MAT',
        ];
        $req_data[1]=[
        'NT'  => 'TBL_TRN_STOCK_STOCK_STORE',
        ];

        $wrapped_links["TABLES"] = $req_data; 
        $XMLTAB = ArrayToXml::convert($wrapped_links);
        
        $salesorder_cancel_data = [ $USERID_REF, $VTID_REF, $TABLE, $FIELD, $ID, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS,$XMLTAB ];

        $sp_result = DB::select('EXEC SP_TRN_CANCEL  ?,?,?,?, ?,?,?,?, ?,?,?,?', $salesorder_cancel_data);

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

            $objResponse = DB::table('TBL_TRN_STOCK_STOCK_HDR')->where('ST_STID','=',$id)->first();

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
        
		$image_path         =   "docs/company".$CYID_REF."/StockToStockTransafer";     
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

        $ST_ST_DOCNO  =   trim($request['ST_ST_DOCNO']);
        $objLabel = DB::table('TBL_TRN_STOCK_STOCK_HDR')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('BRID_REF','=',Session::get('BRID_REF'))
        ->where('FYID_REF','=',Session::get('FYID_REF'))
        ->where('ST_ST_DOCNO','=',$ST_ST_DOCNO)
        ->select('ST_ST_DOCNO')->first();

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

        return  DB::select('SELECT MAX(ST_ST_DOCDT) ST_ST_DOCDT FROM TBL_TRN_STOCK_STOCK_HDR  
        WHERE  CYID_REF = ? AND BRID_REF = ?   AND VTID_REF = ? AND STATUS = ?', 
        [$CYID_REF, $BRID_REF,  $this->vtid_ref, 'A' ]);
    }

    public function getItemDetails(Request $request){
        
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');
        $AlpsStatus =   $this->AlpsStatus();
        
        $StdCost    =   0;
        $Taxid      =   [];
        
        $CODE       =   $request['CODE'];
        $NAME       =   $request['NAME'];
        $MUOM       =   $request['MUOM'];
        $GROUP      =   $request['GROUP'];
        $CTGRY      =   $request['CTGRY'];
        $BUNIT      =   $request['BUNIT'];
        $APART      =   $request['APART'];
        $CPART      =   $request['CPART'];
        $OPART      =   $request['OPART'];

        $sp_popup = [
            $CYID_REF, $BRID_REF, $FYID_REF,$CODE,$NAME,$MUOM,$GROUP,$CTGRY,$BUNIT,$APART,$CPART,$OPART
        ]; 
    //   /  dd($sp_popup);
        
      
        $ObjItem = DB::select('EXEC sp_get_items_popup_enquiry ?,?,?,?,?,?,?,?,?,?,?,?', $sp_popup);

        //dd(count($ObjItem)); 


        if(!empty($ObjItem)){

            //$row = '';

            foreach ($ObjItem as $index=>$dataRow){
                     
                $ITEMID             =   isset($dataRow->ITEMID)?$dataRow->ITEMID:NULL;
                $ICODE              =   isset($dataRow->ICODE)?$dataRow->ICODE:NULL;
                $NAME               =   isset($dataRow->NAME)?$dataRow->NAME:NULL;
                $ITEM_SPECI         =   isset($dataRow->ITEM_SPECI)?$dataRow->ITEM_SPECI:NULL;
                $MAIN_UOMID_REF     =   isset($dataRow->MAIN_UOMID_REF)?$dataRow->MAIN_UOMID_REF:NULL;
                $Main_UOM           =   isset($dataRow->Main_UOM)?$dataRow->Main_UOM:NULL;
                $ALT_UOMID_REF      =   isset($dataRow->ALT_UOMID_REF)?$dataRow->ALT_UOMID_REF:NULL;
                $Alt_UOM            =   isset($dataRow->Alt_UOM)?$dataRow->Alt_UOM:NULL;
                $TOQTY              =   0;
                $FROMQTY            =   1;
                $STDRATE            =   isset($dataRow->STDCOST)? $dataRow->STDCOST : 0;
                $STDCOST            =   isset($dataRow->STDCOST)?$dataRow->STDCOST:NULL;
                $GroupName          =   isset($dataRow->GroupName)?$dataRow->GroupName:NULL;
                $Categoryname       =   isset($dataRow->Categoryname)?$dataRow->Categoryname:NULL;
                $BusinessUnit       =   isset($dataRow->BusinessUnit)?$dataRow->BusinessUnit:NULL;
                $ALPS_PART_NO       =   isset($dataRow->ALPS_PART_NO)?$dataRow->ALPS_PART_NO:NULL;
                $CUSTOMER_PART_NO   =   isset($dataRow->CUSTOMER_PART_NO)?$dataRow->CUSTOMER_PART_NO:NULL;
                $OEM_PART_NO        =   isset($dataRow->OEM_PART_NO)?$dataRow->OEM_PART_NO:NULL;

                $STOCK_QTY          =   DB::select("SELECT  
                                        SUM(isnull(CURRENT_QTY,0)*isnull(RATE,0)) QTY1,SUM(isnull(CURRENT_QTY,0)) AS QTY2 
                                        FROM TBL_MST_BATCH WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' AND STATUS='A' 
                                        AND ITEMID_REF='$ITEMID'")[0];
                                       
                $STOCK_QTY1         =   isset($STOCK_QTY->QTY1) && $STOCK_QTY->QTY1 !=''?floatval($STOCK_QTY->QTY1):0;
                $STOCK_QTY2         =   isset($STOCK_QTY->QTY2) && $STOCK_QTY->QTY2 !=''?floatval($STOCK_QTY->QTY2):0;
                $TOTAL_STOCK_QTY    =   $STOCK_QTY1 > 0 && $STOCK_QTY2 > 1 ?($STOCK_QTY1/$STOCK_QTY2):0;
                $STDRATE            =   number_format($TOTAL_STOCK_QTY, 5, '.', '');
                $STDCOST            =   number_format($TOTAL_STOCK_QTY, 5, '.', '');


                //$AultUmQuantity     =   $this->getAltUmQty($ALT_UOMID_REF,$ITEMID,$FROMQTY);
                $AultUmQuantity     =   0;
                $desc6              =   $ITEMID;

               // $row = $row.'
                $row = '
                <tr id="item_'.$ITEMID .'"  class="clsitemid">
                    <td style="width:8%;text-align:center;"><input type="checkbox" id="chkId'.$ITEMID.'"  value="'.$ITEMID.'" class="js-selectall1"  ></td>
                    <td style="width:10%;">'.$ICODE.'<input type="hidden" id="uniquerowid_'.$desc6.'"   /> <input type="hidden" id="txtitem_'.$ITEMID.'" data-desc="'.$ICODE.'" data-desc6="'.$desc6.'"  data-desc7="'.$AultUmQuantity.'" data-desc8="" value="'.$ITEMID.'"/></td>
                    <td style="width:10%;" id="itemname_'.$ITEMID.'" >'.$NAME.'<input type="hidden" id="txtitemname_'.$ITEMID.'" data-desc="'.$ITEM_SPECI.'" value="'.$NAME.'"/></td>
                    <td style="width:8%;" id="itemuom_'.$ITEMID.'" ><input type="hidden" id="txtitemuom_'.$ITEMID.'" data-desc="'.$Alt_UOM.'" data-desc2="'.$ALPS_PART_NO.'" data-desc3="'.$CUSTOMER_PART_NO.'" data-desc4="'.$OEM_PART_NO.'"  value="'.$MAIN_UOMID_REF.'"/>'.$Main_UOM.'</td>
                    <td style="width:8%;" id="uomqty_'.$ITEMID.'" ><input type="hidden" id="txtuomqty_'.$ITEMID.'" data-desc="'.$TOQTY.'" value="'.$ALT_UOMID_REF.'"/>'.$STDRATE.'</td>
                    <td style="width:8%;" id="irate_'.$ITEMID.'"><input type="hidden" id="txtirate_'.$ITEMID.'" data-desc="'.$FROMQTY.'" value="'.$StdCost.'"/>'.$GroupName.'</td>
                    <td style="width:8%;" id="itax_'.$ITEMID.'"><input type="hidden" id="txtitax_'.$ITEMID.'" />'.$Categoryname.'</td>
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
            echo '<tr><td colspan="12"> Record not found.</td></tr>';
        }
        exit();
    }


    public function getStoreDetails(Request $request){

        $CYID_REF       = Auth::user()->CYID_REF;
        $BRID_REF       = Session::get('BRID_REF');
        $FYID_REF       = Session::get('FYID_REF');

        $ROW_ID         =   $request['ROW_ID'];
        $ITEMID_REF     =   $request['ITEMID_REF'];
        $MAIN_UOMID_DES =   $request['MAIN_UOMID_DES'];
        $MAIN_UOMID_REF =   $request['MAIN_UOMID_REF'];
        $ST_ADJUST_TYPE =   $request['ST_ADJUST_TYPE'];
        
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
                $keyid              =   explode("_",$val);
                $batchid            =   $keyid[0];
                $qty                =   $keyid[1];
                $dataArr[$batchid]  =   $qty;
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

        //AND T1.ITEMID_REF ='$ITEMID_REF' AND T1.UOMID_REF ='$MAIN_UOMID_REF'

        if($ST_ADJUST_TYPE =='IN'){
            /*
            $objBatch =  DB::SELECT("SELECT 
            T1.BATCHID,T1.BATCH_CODE,T1.CURRENT_QTY AS TOTAL_STOCK,
            T2.STID,T2.STCODE,T2.NAME AS STNAME
            FROM TBL_MST_BATCH T1 
            LEFT JOIN TBL_MST_STORE T2 ON T2.STID=T1.STID_REF
            WHERE T1.STATUS='A' AND T1.CYID_REF ='$CYID_REF' AND T1.BRID_REF ='$BRID_REF' AND T1.ITEMID_REF ='$ITEMID_REF'
            ");
            */

            $objBatch =  DB::SELECT("SELECT '' AS BATCHID, '' as BATCH_CODE, STID,STCODE,NAME AS STNAME ,
            (SELECT SUM(CURRENT_QTY)  FROM TBL_MST_BATCH WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' 
            AND STATUS='A' AND STID_REF=STID AND ITEMID_REF='$ITEMID_REF') AS TOTAL_STOCK
            FROM TBL_MST_STORE WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' 
            AND STATUS='A' AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 )
            ");


        }
        else{
            $WHERE_CURRENT_QTY  =   $request['ACTION_TYPE'] =="ADD"?" AND T1.CURRENT_QTY > 0":"";

            $objBatch =  DB::SELECT("SELECT 
            T1.BATCHID,T1.BATCH_CODE,T1.CURRENT_QTY AS TOTAL_STOCK,
            T2.STID,T2.STCODE,T2.NAME AS STNAME
            FROM TBL_MST_BATCH T1 
            LEFT JOIN TBL_MST_STORE T2 ON T2.STID=T1.STID_REF
            WHERE T1.STATUS='A' AND T1.CYID_REF ='$CYID_REF' AND T1.BRID_REF ='$BRID_REF' AND T1.ITEMID_REF ='$ITEMID_REF' AND T1.UOMID_REF ='$MAIN_UOMID_REF'  $WHERE_CURRENT_QTY
            ");
        }

        $StoreBatch     =   $ST_ADJUST_TYPE =='IN'?'Store':'Batch/Store';
        
        echo '<thead>';
        echo '<tr>';
        echo '<th>'.$StoreBatch.'</th>';
        echo '<th>Main UoM (MU)</th>';
        echo '<th>Stock-in-hand</th>';
        echo '<th>Qty (MU)</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach($objBatch as $key=>$val){

            $BATCHID        =   $val->BATCH_CODE;
            $TOTAL_STOCK    =   $val->TOTAL_STOCK !=""?$val->TOTAL_STOCK:0;
            $StoreRowId     =   $val->STID.'#'.$BATCHID.'#'.$ITEMID_REF.'#'.$MAIN_UOMID_REF;
            $qtyvalue       =   array_key_exists($StoreRowId, $dataArr)?$dataArr[$StoreRowId]:0;

            $CURRENT_QTY        =   floatval($TOTAL_STOCK);
            $MainReceivedQty    =   $qtyvalue > 0?$qtyvalue:'';

           
            
                echo '<tr  class="participantRow33">';
                echo '<td hidden><input type="text" id="'.$key.'" value="'.$ROW_ID.'" ></td>';
                if($ST_ADJUST_TYPE =='IN'){
                echo '<td style="width:25%">'.$val->STCODE.' - '.$val->STNAME.'</td>';
                }
                else{
                    echo '<td style="width:25%">'.$val->BATCH_CODE.' / '.$val->STCODE.' - '.$val->STNAME.'</td>';
                }
                echo '<td hidden style="width:15%"><input '.$ACTION_TYPE.' type="text" class="qtytext" name="STORE_NAME_'.$key.'" id="STORE_NAME_'.$key.'"  value="'.$val->STNAME.'"  readonly  autocomplete="off"  ></td>';
                echo '<td style="width:10%">'.$MAIN_UOMID_DES.'</td>';
          



                echo '<td style="width:15%" ><input type="text" style="text-align:right;" readonly name="strSOTCK_'.$key.'" class="form-control" id="strSOTCK_'.$key.'" value="'.$CURRENT_QTY.'"  ></td>';

                echo '<td style="width:15%"><input '.$ACTION_TYPE.' type="text" name="UserQty_'.$key.'" style="text-align:right;" id="UserQty_'.$key.'"  value="'.$MainReceivedQty.'" onkeyup="checkStoreQty('.$ROW_ID.','.$ITEMID_REF.',this.value,'.$key.','.$CURRENT_QTY.')" class="form-control"  onkeypress="return isNumberDecimalKey(event,this)" autocomplete="off"  ></td>';
                echo '<td hidden><input type="hidden" name="BATCHID_'.$key.'" id="BATCHID_'.$key.'" value="'.$StoreRowId.'" class="qtytext" ></td>';
                echo '<td hidden><input type="hidden" name="ROWID_'.$key.'" id="ROWID_'.$key.'" value="'.$ROW_ID.'" class="qtytext" ></td>';
                echo '<td hidden><input type="hidden" name="STOCK_TYPE_'.$key.'" id="STOCK_TYPE_'.$key.'" value="'.$ST_ADJUST_TYPE.'" class="qtytext" ></td>';
                echo '<td hidden><input type="hidden" name="TOTAL_STOCK_'.$key.'" id="TOTAL_STOCK_'.$key.'" value="'.$CURRENT_QTY.'" class="qtytext" ></td>';
                echo '<td hidden><input type="hidden" name="BATCHNOA_'.$key.'" id="BATCHNOA_'.$key.'" value="'.$BATCHNOA.'" class="qtytext" ></td>';
                echo '</tr>';
                echo '</tr>';

        


        }
        
        echo '</tbody>';
        echo '<tr  class="participantRowFotter">
        <td colspan="2" style="text-align:right;font-weight:bold;">TOTAL</td>
        <td id="strSOTCK_total"style="text-align:right;font-weight:bold;"></td>                                                                                  
        <td id="UserQty_total"       style="text-align:right;font-weight:bold;"></td>                                      
        </tr>';
        exit();
    }


    public function getStoreDetails_view(Request $request){

        $CYID_REF       = Auth::user()->CYID_REF;
        $BRID_REF       = Session::get('BRID_REF');
        $FYID_REF       = Session::get('FYID_REF');

        $ROW_ID         =   $request['ROW_ID'];
        $ITEMID_REF     =   $request['ITEMID_REF'];
        $MAIN_UOMID_DES =   $request['MAIN_UOMID_DES'];
        $MAIN_UOMID_REF =   $request['MAIN_UOMID_REF'];
        $ST_ADJUST_TYPE =   $request['ST_ADJUST_TYPE'];
        
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
                $keyid              =   explode("_",$val);
                $batchid            =   $keyid[0];
                $qty                =   $keyid[1];
                $dataArr[$batchid]  =   $qty;
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

        //AND T1.ITEMID_REF ='$ITEMID_REF' AND T1.UOMID_REF ='$MAIN_UOMID_REF'

        if($ST_ADJUST_TYPE =='IN'){
            /*
            $objBatch =  DB::SELECT("SELECT 
            T1.BATCHID,T1.BATCH_CODE,T1.CURRENT_QTY AS TOTAL_STOCK,
            T2.STID,T2.STCODE,T2.NAME AS STNAME
            FROM TBL_MST_BATCH T1 
            LEFT JOIN TBL_MST_STORE T2 ON T2.STID=T1.STID_REF
            WHERE T1.STATUS='A' AND T1.CYID_REF ='$CYID_REF' AND T1.BRID_REF ='$BRID_REF' AND T1.ITEMID_REF ='$ITEMID_REF'
            ");
            */

            $objBatch =  DB::SELECT("SELECT '' AS BATCHID, '' as BATCH_CODE, STID,STCODE,NAME AS STNAME ,
            (SELECT SUM(CURRENT_QTY)  FROM TBL_MST_BATCH WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' 
            AND STATUS='A' AND STID_REF=STID AND ITEMID_REF='$ITEMID_REF') AS TOTAL_STOCK
            FROM TBL_MST_STORE WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' 
            AND STATUS='A' AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 )
            ");


        }
        else{
            $objBatch =  DB::SELECT("SELECT 
            T1.BATCHID,T1.BATCH_CODE,T1.CURRENT_QTY AS TOTAL_STOCK,
            T2.STID,T2.STCODE,T2.NAME AS STNAME
            FROM TBL_MST_BATCH T1 
            LEFT JOIN TBL_MST_STORE T2 ON T2.STID=T1.STID_REF
            WHERE T1.STATUS='A' AND T1.CYID_REF ='$CYID_REF' AND T1.BRID_REF ='$BRID_REF' AND T1.ITEMID_REF ='$ITEMID_REF' AND T1.UOMID_REF ='$MAIN_UOMID_REF'
            ");
        }

        $StoreBatch     =   $ST_ADJUST_TYPE =='IN'?'Store':'Batch/Store';
        
        echo '<thead>';
        echo '<tr>';
        echo '<th>'.$StoreBatch.'</th>';
        echo '<th>Main UoM (MU)</th>';
        echo '<th>Stock-in-hand</th>';
        echo '<th>Qty (MU)</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach($objBatch as $key=>$val){

            $BATCHID        =   $val->BATCH_CODE;
            $TOTAL_STOCK    =   $val->TOTAL_STOCK !=""?$val->TOTAL_STOCK:0;
            $StoreRowId     =   $val->STID.'#'.$BATCHID.'#'.$ITEMID_REF.'#'.$MAIN_UOMID_REF;
            $qtyvalue       =   array_key_exists($StoreRowId, $dataArr)?$dataArr[$StoreRowId]:0;

            $CURRENT_QTY        =   floatval($TOTAL_STOCK);
            $MainReceivedQty    =   $qtyvalue > 0?$qtyvalue:'';

           
            
                echo '<tr  class="participantRow33">';
                echo '<td hidden><input type="text" id="'.$key.'" value="'.$ROW_ID.'" ></td>';
                if($ST_ADJUST_TYPE =='IN'){
                echo '<td style="width:25%">'.$val->STCODE.' - '.$val->STNAME.'</td>';
                }
                else{
                    echo '<td style="width:25%">'.$val->BATCH_CODE.' / '.$val->STCODE.' - '.$val->STNAME.'</td>';
                }
                echo '<td hidden style="width:15%"><input '.$ACTION_TYPE.' type="text" class="qtytext" name="STORE_NAME_'.$key.'" id="STORE_NAME_'.$key.'"  value="'.$val->STNAME.'"  readonly  autocomplete="off"  ></td>';
                echo '<td style="width:10%">'.$MAIN_UOMID_DES.'</td>';
          



                echo '<td style="width:15%" ><input type="text" style="text-align:right;" readonly name="strSOTCK_'.$key.'" class="form-control" id="strSOTCK_'.$key.'" value="'.$CURRENT_QTY.'"  ></td>';

                echo '<td style="width:15%"><input '.$ACTION_TYPE.' type="text" name="UserQty_'.$key.'" style="text-align:right;" id="UserQty_'.$key.'"  value="'.$MainReceivedQty.'" onkeyup="checkStoreQty('.$ROW_ID.','.$ITEMID_REF.',this.value,'.$key.','.$CURRENT_QTY.')" class="form-control"  onkeypress="return isNumberDecimalKey(event,this)" autocomplete="off"  ></td>';
                echo '<td hidden><input type="hidden" name="BATCHID_'.$key.'" id="BATCHID_'.$key.'" value="'.$StoreRowId.'" class="qtytext" ></td>';
                echo '<td hidden><input type="hidden" name="ROWID_'.$key.'" id="ROWID_'.$key.'" value="'.$ROW_ID.'" class="qtytext" ></td>';
                echo '<td hidden><input type="hidden" name="STOCK_TYPE_'.$key.'" id="STOCK_TYPE_'.$key.'" value="'.$ST_ADJUST_TYPE.'" class="qtytext" ></td>';
                echo '<td hidden><input type="hidden" name="TOTAL_STOCK_'.$key.'" id="TOTAL_STOCK_'.$key.'" value="'.$CURRENT_QTY.'" class="qtytext" ></td>';
                echo '<td hidden><input type="hidden" name="BATCHNOA_'.$key.'" id="BATCHNOA_'.$key.'" value="'.$BATCHNOA.'" class="qtytext" ></td>';
                echo '</tr>';
                echo '</tr>';

        


        }
        
        echo '</tbody>';
        echo '<tr  class="participantRowFotter">
        <td colspan="2" style="text-align:right;font-weight:bold;">TOTAL</td>
        <td id="strSOTCK_total"style="text-align:right;font-weight:bold;"></td>                                                                                  
        <td id="UserQty_total"       style="text-align:right;font-weight:bold;"></td>                                      
        </tr>';
        exit();
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


    public function getItemStoreWiseRate(Request $request){

        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $id         =   $request['id'];
        $ITEMID_REF =   NULL;
        $store_id   =   array();

        foreach($id as $key=>$val){

            $exp    =   explode("#",$val);

            if($key ==0){
                $ITEMID_REF =   $exp[2];
            }

            $store_id[]=$exp[0];
        }

        $StoreId    =   array_unique($store_id);
        $STID_REF   =   implode(",",$StoreId);

        $STOCK_QTY  =   DB::select("SELECT  
        SUM(isnull(CURRENT_QTY,0)*isnull(RATE,0)) QTY1,SUM(isnull(CURRENT_QTY,0)) AS QTY2 
        FROM TBL_MST_BATCH WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' AND STATUS='A' 
        AND ITEMID_REF='$ITEMID_REF' AND STID_REF in($STID_REF)")[0];
                                       
        $STOCK_QTY1         =   isset($STOCK_QTY->QTY1) && $STOCK_QTY->QTY1 !=''?floatval($STOCK_QTY->QTY1):0;
        $STOCK_QTY2         =   isset($STOCK_QTY->QTY2) && $STOCK_QTY->QTY2 !=''?floatval($STOCK_QTY->QTY2):0;
        $TOTAL_STOCK_QTY    =   $STOCK_QTY1 > 0 && $STOCK_QTY2 > 1 ?($STOCK_QTY1/$STOCK_QTY2):0;
        $STDRATE            =   number_format($TOTAL_STOCK_QTY, 5, '.', '');

        echo $STDRATE;
        exit();
        
    }

    


    
}