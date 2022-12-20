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

class TrnFrm401Controller extends Controller{

    protected $form_id  = 401;
    protected $vtid_ref = 484;
    protected $view     = "transactions.Production.ProductionReturn.trnfrm";
   
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

        $objDataList	=	DB::select("select hdr.PRRID,hdr.PRR_NO,hdr.PRR_DT,hdr.INDATE,
                            (
                            SELECT TOP 1 USR.DESCRIPTIONS FROM TBL_TRN_AUDITTRAIL AUD 
                            LEFT JOIN TBL_MST_USER USR ON AUD.USERID=USR.USERID 
                            WHERE  AUD.VID=hdr.PRRID AND  AUD.CYID_REF=hdr.CYID_REF AND  AUD.BRID_REF=hdr.BRID_REF AND  
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
                            inner join TBL_TRN_PDPRR_HDR hdr
                            on a.VID = hdr.PRRID 
                            and a.VTID_REF = hdr.VTID_REF 
                            and a.CYID_REF = hdr.CYID_REF 
                            and a.BRID_REF = hdr.BRID_REF
                            where a.VTID_REF = '$this->vtid_ref'
                            and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF' AND hdr.FYID_REF='$FYID_REF'
                            and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                            ORDER BY hdr.PRRID DESC ");

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

    public function add(){       
        $Status     = "A";
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');
       
        $objlastdt          =   $this->getLastdt();

        $doc_req    =   array(
            'VTID_REF'=>$this->vtid_ref,
            'HDR_TABLE'=>'TBL_TRN_PDPRR_HDR',
            'HDR_ID'=>'PRRID',
            'HDR_DOC_NO'=>'PRR_NO',
            'HDR_DOC_DT'=>'PRR_DT'
        );
        $docarray   =   $this->getManualAutoDocNo(date('Y-m-d'),$doc_req);
        
        

        //dd($objDataNo);

        $ObjUnionUDF = DB::table("TBL_MST_UDFFOR_PRO")->select('*')
        ->whereIn('PARENTID',function($query) use ($CYID_REF)
                    {       
                    $query->select('UDFPROID')->from('TBL_MST_UDFFOR_PRO')
                                    ->where('STATUS','=','A')
                                    ->where('PARENTID','=',0)
                                    ->where('DEACTIVATED','=',0)
                                    ->where('CYID_REF','=',$CYID_REF);                      
        })->where('DEACTIVATED','=',0)
        ->where('STATUS','<>','C')                    
        ->where('CYID_REF','=',$CYID_REF);     
        
        //dd($ObjUnionUDF); 
       

    $objUdfData = DB::table('TBL_MST_UDFFOR_PRO')
            ->where('STATUS','=','A')
            ->where('PARENTID','=',0)
            ->where('DEACTIVATED','=',0)
            ->where('CYID_REF','=',$CYID_REF)
            ->union($ObjUnionUDF)
            ->get()->toArray();  

            $objCountUDF = count($objUdfData);
   
        $FormId     =   $this->form_id;
        $AlpsStatus =   $this->AlpsStatus();

        $TabSetting	=	Helper::getAddSetting(Auth::user()->CYID_REF,'ITEM_TAB_SETTING');
        
        return view($this->view.$FormId.'add',compact(['AlpsStatus','FormId','objlastdt','TabSetting','objUdfData','objCountUDF','doc_req','docarray']));       
    }

    public function save(Request $request) {



        $Main_r_count1 = $request['Main_Row_Count1'];
        $r_count1      = $request['Row_Count1'];
        $r_count2      = $request['Row_Count2'];


        
        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i]) && $request['ITEMID_REF_'.$i] !=''){

                $STID_REF       =   $this->getMaterialStore($request['HiddenRowId_'.$i]);
               
                $req_data[$i] = [
                    'ITEMID_REF'       => $request['ITEMID_REF_'.$i],
                    'UOMID_REF'        => $request['MAIN_UOMID_REF_'.$i],
                    'STID_REF'         => $STID_REF,
                    'RETURNQTY'        =>(!empty($request['QTY_'.$i]) ? $request['QTY_'.$i] : 0),           
                    'REASON_RETURN'    => $request['REASON_'.$i],
                    'REMARKS'          => $request['REMARKS_'.$i],
                    'BATCH_QTY'        => $request['HiddenRowId_'.$i],
                   
                ];
            }
        }


        if(isset($req_data)){
        $wrapped_links["ADD"] = $req_data; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);
        }else{
        $XMLMAT=NULL;   
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
                        $batchid            =   isset($keyid[0])?$keyid[0]:0;

                        $dataArr[$batchid]['QTY'] =   isset($keyid[1])?$keyid[1]:0;
                        $dataArr[$batchid]['STOCK_INHAND']  =  isset($keyid[2])?$keyid[2]:0;
                        $dataArr[$batchid]['RATE']  =  isset($keyid[3])?$keyid[3]:0;
                        
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
                            'UOMID_REF'         => $UOMID_REF,
                            'STID_REF'          => $STID_REF,
                            'RATE'              => $val['RATE'],
                            'RETURNQTY'         => $val['QTY'],
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            ];

                            

                    }
                }
            }
        }


        for ($i=0; $i<=$Main_r_count1; $i++){
            if(isset($request['Main_ITEMID_REF_'.$i])){
                $StoreArr   =   array();
                $ITEMID_REF =   $request['Main_ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['Main_HiddenRowId_'.$i];
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

                $req_datas[$i] = [
                    'ITEMID_REF'       => $request['Main_ITEMID_REF_'.$i],
                    'STID_REF'         =>  $STID_REF,
                    'UOMID_REF'        => $request['Main_MAIN_UOMID_REF_'.$i],
                    'ISSUEQTY'         =>     (!empty($request['Main_SE_QTY_'.$i]) ? $request['Main_SE_QTY_'.$i] : 0),
                    'RETURNQTY'        => (!empty($request['Main_RECEIVED_QTY_MU_'.$i]) ? $request['Main_RECEIVED_QTY_MU_'.$i] : 0),
                    'REASON_RETURN' => $request['Main_REASON_RETURN_QTY_'.$i],
                    'REMARKS'          => $request['Main_REMARKS_'.$i],
                    'BATCH_QTY'        => $request['Main_HiddenRowId_'.$i],
                ];
            }
        }

        
       
        


        for ($i=0; $i<=$Main_r_count1; $i++){
            if(isset($request['Main_ITEMID_REF_'.$i])){
                $dataArr    =   array();
                $ITEMID_REF =   $request['Main_ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['Main_HiddenRowId_'.$i]; 
              

                if($ITEMROWID !=""){
                    $exp        =   explode(",",$ITEMROWID);
 
                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];
                  

                        $dataArr[$batchid]['RECEIVED_QTYM'] =   isset($keyid[1])?$keyid[1]:0;
                        $dataArr[$batchid]['STOCK_INHAND']  =  isset($keyid[2])?$keyid[2]:0;
                        $dataArr[$batchid]['RATE']  =  isset($keyid[3])?$keyid[3]:0;
                    }
                }

                if(!empty($dataArr)){
                    foreach($dataArr as $key=>$val){

                        $ExpID              =   explode("#",$key);
                        $STID_REF           =   $ExpID[0];
                        $BATCH_CODE         =   $ExpID[2];
                        $ITEMID_REF         =   $ExpID[3];
                        $UOMID_REF          =   $ExpID[4];
                       
                      
                        $req_data333[$i][] = [
                            'ITEMID_REF'        => $ITEMID_REF,
                            'STID_REF'          => $STID_REF,
                            'BATCH_CODE'        => NULL,
                            'UOMID_REF'    => $UOMID_REF,
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            'RETURNQTY'       => $val['RECEIVED_QTYM'],
                            'RATE'       => $val['RATE'],
                        
                        ];

                    }
                }
            }
        }


        $wrapped_links1["MAT"] = $req_datas; 
        $Main_XMLMAT = ArrayToXml::convert($wrapped_links1);

        

        $wrapped_links333["STORE"] = $req_data333; 
        $Main_XMLSTORE = ArrayToXml::convert($wrapped_links333);



       

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

        $XMLUDF=NULL; 

        if(isset($req_data33)){
        $wrapped_links33["STOREADD"] = $req_data33; 
        $XMLSTORE = ArrayToXml::convert($wrapped_links33);
        }else{
        $XMLSTORE=NULL; 
        }

        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = 'ADD';
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $PRR_DOCNO     = $request['PRR_DOCNO'];
        $PRR_DOCDT     = $request['PRR_DT'];
        $PROID_REF     = $request['PRID_REF'];

        
        $log_data = [ 
            $PRR_DOCNO,$PRR_DOCDT,$PROID_REF,$CYID_REF,$BRID_REF,$FYID_REF,
            $VTID_REF,$Main_XMLMAT,$XMLMAT,$XMLUDF,$USERID,Date('Y-m-d'),
            Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS,$Main_XMLSTORE,$XMLSTORE
        ];  


        $sp_result = DB::select('EXEC SP_PRRO_IN ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?  ,?,?', $log_data);  


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

            $objResponse =  DB::table('TBL_TRN_PDPRR_HDR')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('BRID_REF','=',Session::get('BRID_REF'))
            ->where('PRRID','=',$id)
            ->first();
            

            $objPRO = DB::table('TBL_TRN_PDPRO_HDR')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('BRID_REF','=',Session::get('BRID_REF'))                  
            ->where('PROID','=',$objResponse->PROID_REF)     
            ->select('PROID','PRO_NO','PRO_DT','PRO_TITLE') 
            ->first();
            


          

            $objlastdt          =   $this->getLastdt();
            
            //Additional Material Tab            
            $objMAT = DB::select("SELECT 
            T1.*,T2.ICODE,T2.NAME AS ITEM_NAME,T2.ITEM_SPECI,T3.UOMCODE,T3.DESCRIPTIONS,T2.ALPS_PART_NO,T2.CUSTOMER_PART_NO,T2.OEM_PART_NO,
            T4.ICODE AS ICODE_IN ,T4.NAME AS ITEM_NAME_IN,T5.UOMCODE AS UOMCODE_IN,T5.DESCRIPTIONS AS DESCRIPTIONS_IN
            FROM TBL_TRN_PDPRR_ADD T1
            LEFT JOIN TBL_MST_ITEM T2 ON T1.ITEMID_REF=T2.ITEMID
            LEFT JOIN TBL_MST_UOM T3 ON T1.UOMID_REF=T3.UOMID
            LEFT JOIN TBL_MST_ITEM T4 ON T1.ITEMID_REF=T4.ITEMID
            LEFT JOIN TBL_MST_UOM T5 ON T1.UOMID_REF=T5.UOMID
            WHERE T1.PRRID_REF='$id' ORDER BY T1.PRR_ADDID ASC");     


            if(isset($objMAT[0]->STID_REF) && $objMAT[0]->STID_REF!=''){
                foreach($objMAT as $key=>$val){
                    $STID       =   $val->STID_REF; 
                    $STORE_DATA = DB::select("select distinct stuff((select ',' + t.[NAME] from TBL_MST_STORE t where STID in($STID) order by t.[NAME] for xml path('') ),1,1,'') as STORE_NAME from TBL_MST_STORE t1 where STID in($STID)"); 
                    $STORE_NAME =   isset($STORE_DATA[0]->STORE_NAME) && $STORE_DATA[0]->STORE_NAME !=""?$STORE_DATA[0]->STORE_NAME:NULL; 
                    $objMAT[$key]->STORE_NAME=$STORE_NAME;
              
                   
                }
            }

            //Main Material Tab  
            $Main_objMAT = DB::select("SELECT 
            T1.*,
            T2.ICODE,T2.NAME AS ITEM_NAME,T2.ITEM_SPECI,T2.ALPS_PART_NO,T2.CUSTOMER_PART_NO,T2.OEM_PART_NO,
            CONCAT(T3.UOMCODE,'-',T3.DESCRIPTIONS) AS MAIN_UOM_CODE          
            FROM TBL_TRN_PDPRR_MAT T1
            LEFT JOIN TBL_MST_ITEM T2 ON T1.ITEMID_REF=T2.ITEMID
            LEFT JOIN TBL_MST_UOM T3 ON T1.UOMID_REF=T3.UOMID       
            WHERE T1.PRRID_REF='$id' ORDER BY T1.PRR_MATID ASC
            "); 

            //dd($Main_objMAT); 



                if(isset($Main_objMAT[0]->STID_REF) && $Main_objMAT[0]->STID_REF!=''){
                foreach($Main_objMAT as $key=>$val){
                    $STID       =   $val->STID_REF;               

                    $STORE_DATA = DB::select("select distinct stuff((select ',' + t.[NAME] from TBL_MST_STORE t where STID in($STID) order by t.[NAME] for xml path('') ),1,1,'') as STORE_NAME from TBL_MST_STORE t1 where STID in($STID)"); 
                    $STORE_NAME =   isset($STORE_DATA[0]->STORE_NAME) && $STORE_DATA[0]->STORE_NAME !=""?$STORE_DATA[0]->STORE_NAME:NULL; 
                    
                    
                    $Main_objMAT[$key]->STORE_NAME=$STORE_NAME;
            
                
                }
            }


           // dd($Main_objMAT); 



            $FormId         =   $this->form_id;
            $AlpsStatus =   $this->AlpsStatus();
            $ActionStatus   =   "";

            $TabSetting	=	Helper::getAddSetting(Auth::user()->CYID_REF,'ITEM_TAB_SETTING');

            
        
            return view($this->view.$FormId.'edit',compact(['AlpsStatus','FormId','objRights','objlastdt','objResponse','objMAT','ActionStatus','TabSetting','objPRO','Main_objMAT']));      

        }
     
    }


    public function view($id=NULL){
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF'); 
        $Status     =   'A';
        
        if(!is_null($id)){

            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $objResponse =  DB::table('TBL_TRN_PDPRR_HDR')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('BRID_REF','=',Session::get('BRID_REF'))
            ->where('PRRID','=',$id)
            ->first();
            

            $objPRO = DB::table('TBL_TRN_PDPRO_HDR')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('BRID_REF','=',Session::get('BRID_REF'))                  
            ->where('PROID','=',$objResponse->PROID_REF)     
            ->select('PROID','PRO_NO','PRO_DT','PRO_TITLE') 
            ->first();
            


          

            $objlastdt          =   $this->getLastdt();
            
            //Additional Material Tab            
            $objMAT = DB::select("SELECT 
            T1.*,T2.ICODE,T2.NAME AS ITEM_NAME,T2.ITEM_SPECI,T3.UOMCODE,T3.DESCRIPTIONS,T2.ALPS_PART_NO,T2.CUSTOMER_PART_NO,T2.OEM_PART_NO,
            T4.ICODE AS ICODE_IN ,T4.NAME AS ITEM_NAME_IN,T5.UOMCODE AS UOMCODE_IN,T5.DESCRIPTIONS AS DESCRIPTIONS_IN
            FROM TBL_TRN_PDPRR_ADD T1
            LEFT JOIN TBL_MST_ITEM T2 ON T1.ITEMID_REF=T2.ITEMID
            LEFT JOIN TBL_MST_UOM T3 ON T1.UOMID_REF=T3.UOMID
            LEFT JOIN TBL_MST_ITEM T4 ON T1.ITEMID_REF=T4.ITEMID
            LEFT JOIN TBL_MST_UOM T5 ON T1.UOMID_REF=T5.UOMID
            WHERE T1.PRRID_REF='$id' ORDER BY T1.PRR_ADDID ASC"); 

            //dd($objMAT); 
            if(isset($objMAT[0]->STID_REF) && $objMAT[0]->STID_REF!=''){
                foreach($objMAT as $key=>$val){
                    $STID       =   $val->STID_REF; 
                    $STORE_DATA = DB::select("select distinct stuff((select ',' + t.[NAME] from TBL_MST_STORE t where STID in($STID) order by t.[NAME] for xml path('') ),1,1,'') as STORE_NAME from TBL_MST_STORE t1 where STID in($STID)"); 
                    $STORE_NAME =   isset($STORE_DATA[0]->STORE_NAME) && $STORE_DATA[0]->STORE_NAME !=""?$STORE_DATA[0]->STORE_NAME:NULL; 
                    $objMAT[$key]->STORE_NAME=$STORE_NAME;
            
                
                }
            }

            //Main Material Tab  
            $Main_objMAT = DB::select("SELECT 
            T1.*,
            T2.ICODE,T2.NAME AS ITEM_NAME,T2.ITEM_SPECI,T2.ALPS_PART_NO,T2.CUSTOMER_PART_NO,T2.OEM_PART_NO,
            CONCAT(T3.UOMCODE,'-',T3.DESCRIPTIONS) AS MAIN_UOM_CODE          
            FROM TBL_TRN_PDPRR_MAT T1
            LEFT JOIN TBL_MST_ITEM T2 ON T1.ITEMID_REF=T2.ITEMID
            LEFT JOIN TBL_MST_UOM T3 ON T1.UOMID_REF=T3.UOMID       
            WHERE T1.PRRID_REF='$id' ORDER BY T1.PRR_MATID ASC
            "); 

            //dd($Main_objMAT); 



                if(isset($Main_objMAT[0]->STID_REF) && $Main_objMAT[0]->STID_REF!=''){
                foreach($Main_objMAT as $key=>$val){
                    $STID       =   $val->STID_REF;               

                    $STORE_DATA = DB::select("select distinct stuff((select ',' + t.[NAME] from TBL_MST_STORE t where STID in($STID) order by t.[NAME] for xml path('') ),1,1,'') as STORE_NAME from TBL_MST_STORE t1 where STID in($STID)"); 
                    $STORE_NAME =   isset($STORE_DATA[0]->STORE_NAME) && $STORE_DATA[0]->STORE_NAME !=""?$STORE_DATA[0]->STORE_NAME:NULL; 
                    
                    
                    $Main_objMAT[$key]->STORE_NAME=$STORE_NAME;

                
                }
            }



           // dd($Main_objMAT); 



            $FormId         =   $this->form_id;
            $AlpsStatus =   $this->AlpsStatus();
            $ActionStatus   =   "disabled";

            $TabSetting	=	Helper::getAddSetting(Auth::user()->CYID_REF,'ITEM_TAB_SETTING');

            
        
            return view($this->view.$FormId.'view',compact(['AlpsStatus','FormId','objRights','objlastdt','objResponse','objMAT','ActionStatus','TabSetting','objPRO','Main_objMAT']));      

        }
     
    }

    public function update(Request $request){

        $Main_r_count1 = $request['Main_Row_Count1'];
        $r_count1      = $request['Row_Count1'];
        $r_count2      = $request['Row_Count2'];
        
        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i]) && $request['ITEMID_REF_'.$i] !=''){

                $STID_REF       =   $this->getMaterialStore($request['HiddenRowId_'.$i]);

                $req_data[$i] = [
                    'ITEMID_REF'       => $request['ITEMID_REF_'.$i],
                    'UOMID_REF'        => $request['MAIN_UOMID_REF_'.$i],
                    'STID_REF'         => $STID_REF,
                    'RETURNQTY'        =>(!empty($request['QTY_'.$i]) ? $request['QTY_'.$i] : 0),           
                    'REASON_RETURN'    => $request['REASON_'.$i],
                    'REMARKS'          => $request['REMARKS_'.$i],
                    'BATCH_QTY'        => $request['HiddenRowId_'.$i],
                   
                ];
            }
        }

        if(isset($req_data)){
        $wrapped_links["ADD"] = $req_data; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);
        }else{
        $XMLMAT=NULL;   
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
                        $batchid            =   isset($keyid[0])?$keyid[0]:0;

                        $dataArr[$batchid]['QTY'] =   isset($keyid[1])?$keyid[1]:0;
                        $dataArr[$batchid]['STOCK_INHAND']  =  isset($keyid[2])?$keyid[2]:0;
                        $dataArr[$batchid]['RATE']  =  isset($keyid[3])?$keyid[3]:0;
                        
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
                            'UOMID_REF'         => $UOMID_REF,
                            'STID_REF'          => $STID_REF,
                            'RATE'              => $val['RATE'],
                            'RETURNQTY'         => $val['QTY'],
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            ];

                            

                    }
                }
            }
        }


        for ($i=0; $i<=$Main_r_count1; $i++){
            if(isset($request['Main_ITEMID_REF_'.$i])){
                $StoreArr   =   array();
                $ITEMID_REF =   $request['Main_ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['Main_HiddenRowId_'.$i];
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

                $req_datas[$i] = [
                    'ITEMID_REF'       => $request['Main_ITEMID_REF_'.$i],
                    'STID_REF'         =>  $STID_REF,
                    'UOMID_REF'        => $request['Main_MAIN_UOMID_REF_'.$i],
                    'ISSUEQTY'         =>     (!empty($request['Main_SE_QTY_'.$i]) ? $request['Main_SE_QTY_'.$i] : 0),
                    'RETURNQTY'        => (!empty($request['Main_RECEIVED_QTY_MU_'.$i]) ? $request['Main_RECEIVED_QTY_MU_'.$i] : 0),
                    'REASON_RETURN' => $request['Main_REASON_RETURN_QTY_'.$i],
                    'REMARKS'          => $request['Main_REMARKS_'.$i],
                    'BATCH_QTY'        => $request['Main_HiddenRowId_'.$i],
                ];
            }
        }


        for ($i=0; $i<=$Main_r_count1; $i++){
            if(isset($request['Main_ITEMID_REF_'.$i])){
                $dataArr    =   array();
                $ITEMID_REF =   $request['Main_ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['Main_HiddenRowId_'.$i]; 
               
                
                if($ITEMROWID !=""){
                    $exp        =   explode(",",$ITEMROWID);

                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];
                         
                        $dataArr[$batchid]['RECEIVED_QTYM'] =   isset($keyid[1])?$keyid[1]:0;
                        $dataArr[$batchid]['STOCK_INHAND']  =  isset($keyid[2])?$keyid[2]:0;
                        $dataArr[$batchid]['RATE']  =  isset($keyid[3])?$keyid[3]:0;
                    }
                }

               
                if(!empty($dataArr)){
                    foreach($dataArr as $key=>$val){

                        $ExpID              =   explode("#",$key);

                       
                        $STID_REF           =   $ExpID[0];
                       
                        $BATCH_CODE         =   $ExpID[2];
                        $ITEMID_REF         =   $ExpID[3];
                        $UOMID_REF          =   $ExpID[4];
                       
                      
                        $req_data333[$i][] = [
                            'ITEMID_REF'        => $ITEMID_REF,
                            'STID_REF'          => $STID_REF,
                            'BATCH_CODE'        => NULL,
                            'UOMID_REF'    => $UOMID_REF,
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            'RETURNQTY'       => $val['RECEIVED_QTYM'],
                            'RATE'       => $val['RATE'],
                        
                        ];

                    }
                }
            }
        }


        $wrapped_links1["MAT"] = $req_datas; 
        $Main_XMLMAT = ArrayToXml::convert($wrapped_links1);


        $wrapped_links333["STORE"] = $req_data333; 
        $Main_XMLSTORE = ArrayToXml::convert($wrapped_links333);


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

        $XMLUDF=NULL; 

        if(isset($req_data33)){
        $wrapped_links33["STOREADD"] = $req_data33; 
        $XMLSTORE = ArrayToXml::convert($wrapped_links33);
        }else{
        $XMLSTORE=NULL; 
        }

        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = 'EDIT';
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $PRR_DOCNO     = $request['PRR_DOCNO'];
        $PRR_DOCDT     = $request['PRR_DT'];
        $PROID_REF     = $request['PRID_REF'];
   
        $log_data = [ 
            $PRR_DOCNO,$PRR_DOCDT,$PROID_REF,$CYID_REF,$BRID_REF,$FYID_REF,
            $VTID_REF,$Main_XMLMAT,$XMLMAT,$XMLUDF,$USERID,Date('Y-m-d'),
            Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS,$Main_XMLSTORE,$XMLSTORE
        ];  

        $sp_result = DB::select('EXEC SP_PRRO_UP ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?  ,?,?', $log_data);  
      
        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => $PRR_DOCNO. ' Sucessfully Updated.']);

        }else{
            return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
        }
        exit();   
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
   
        $Main_r_count1 = $request['Main_Row_Count1'];
        $r_count1      = $request['Row_Count1'];
        $r_count2      = $request['Row_Count2'];


        
        for ($i=0; $i<=$r_count1; $i++){
            if(isset($request['ITEMID_REF_'.$i]) && $request['ITEMID_REF_'.$i] !=''){

                $STID_REF       =   $this->getMaterialStore($request['HiddenRowId_'.$i]);
               
                $req_data[$i] = [
                    'ITEMID_REF'       => $request['ITEMID_REF_'.$i],
                    'UOMID_REF'        => $request['MAIN_UOMID_REF_'.$i],
                    'STID_REF'         => $STID_REF,
                    'RETURNQTY'        =>(!empty($request['QTY_'.$i]) ? $request['QTY_'.$i] : 0),           
                    'REASON_RETURN'    => $request['REASON_'.$i],
                    'REMARKS'          => $request['REMARKS_'.$i],
                    'BATCH_QTY'        => $request['HiddenRowId_'.$i],
                   
                ];
            }
        }


        if(isset($req_data)){
        $wrapped_links["ADD"] = $req_data; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);
        }else{
        $XMLMAT=NULL;   
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
                        $batchid            =   isset($keyid[0])?$keyid[0]:0;

                        $dataArr[$batchid]['QTY'] =   isset($keyid[1])?$keyid[1]:0;
                        $dataArr[$batchid]['STOCK_INHAND']  =  isset($keyid[2])?$keyid[2]:0;
                        $dataArr[$batchid]['RATE']  =  isset($keyid[3])?$keyid[3]:0;
                        
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
                            'UOMID_REF'         => $UOMID_REF,
                            'STID_REF'          => $STID_REF,
                            'RATE'              => $val['RATE'],
                            'RETURNQTY'         => $val['QTY'],
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            ];

                            

                    }
                }
            }
        }


        for ($i=0; $i<=$Main_r_count1; $i++){
            if(isset($request['Main_ITEMID_REF_'.$i])){
                $StoreArr   =   array();
                $ITEMID_REF =   $request['Main_ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['Main_HiddenRowId_'.$i];
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

                $req_datas[$i] = [
                    'ITEMID_REF'       => $request['Main_ITEMID_REF_'.$i],
                    'STID_REF'         =>  $STID_REF,
                    'UOMID_REF'        => $request['Main_MAIN_UOMID_REF_'.$i],
                    'ISSUEQTY'         =>     (!empty($request['Main_SE_QTY_'.$i]) ? $request['Main_SE_QTY_'.$i] : 0),
                    'RETURNQTY'        => (!empty($request['Main_RECEIVED_QTY_MU_'.$i]) ? $request['Main_RECEIVED_QTY_MU_'.$i] : 0),
                    'REASON_RETURN' => $request['Main_REASON_RETURN_QTY_'.$i],
                    'REMARKS'          => $request['Main_REMARKS_'.$i],
                    'BATCH_QTY'        => $request['Main_HiddenRowId_'.$i],
                ];
            }
        }

        
       
        


        for ($i=0; $i<=$Main_r_count1; $i++){
            if(isset($request['Main_ITEMID_REF_'.$i])){
                $dataArr    =   array();
                $ITEMID_REF =   $request['Main_ITEMID_REF_'.$i];
                $ITEMROWID  =   $request['Main_HiddenRowId_'.$i]; 
               
                if($ITEMROWID !=""){
                    $exp        =   explode(",",$ITEMROWID);
 
                    foreach($exp as $val){
                        $keyid              =   explode("_",$val);
                        $batchid            =   $keyid[0];
                   
                        $dataArr[$batchid]['RECEIVED_QTYM'] =   isset($keyid[1])?$keyid[1]:0;
                        $dataArr[$batchid]['STOCK_INHAND']  =  isset($keyid[2])?$keyid[2]:0;
                        $dataArr[$batchid]['RATE']  =  isset($keyid[3])?$keyid[3]:0;
                    }
                }

                if(!empty($dataArr)){
                    foreach($dataArr as $key=>$val){

                        $ExpID              =   explode("#",$key);
                        $STID_REF           =   $ExpID[0];
                        $BATCH_CODE         =   $ExpID[2];
                        $ITEMID_REF         =   $ExpID[3];
                        $UOMID_REF          =   $ExpID[4];
                       
                        $req_data333[$i][] = [
                            'ITEMID_REF'        => $ITEMID_REF,
                            'STID_REF'          => $STID_REF,
                            'BATCH_CODE'        => NULL,
                            'UOMID_REF'         => $UOMID_REF,
                            'STOCK_INHAND'      => $val['STOCK_INHAND'], 
                            'RETURNQTY'         => $val['RECEIVED_QTYM'],
                            'RATE'              => $val['RATE'],
                        
                        ];

                    }
                }
            }
        }


        $wrapped_links1["MAT"] = $req_datas; 
        $Main_XMLMAT = ArrayToXml::convert($wrapped_links1);       

        $wrapped_links333["STORE"] = $req_data333; 
        $Main_XMLSTORE = ArrayToXml::convert($wrapped_links333);

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

        $XMLUDF=NULL; 

        if(isset($req_data33)){
        $wrapped_links33["STOREADD"] = $req_data33; 
        $XMLSTORE = ArrayToXml::convert($wrapped_links33);
        }else{
        $XMLSTORE=NULL; 
        }

        $VTID_REF     =   $this->vtid_ref;
        $VID = 0;
        $USERID = Auth::user()->USERID;   
        $ACTIONNAME = $Approvallevel;
        $IPADDRESS = $request->getClientIp();
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $PRR_DOCNO     = $request['PRR_DOCNO'];
        $PRR_DOCDT     = $request['PRR_DT'];
        $PROID_REF     = $request['PRID_REF'];
      
        $log_data = [ 
            $PRR_DOCNO,$PRR_DOCDT,$PROID_REF,$CYID_REF,$BRID_REF,$FYID_REF,
            $VTID_REF,$Main_XMLMAT,$XMLMAT,$XMLUDF,$USERID,Date('Y-m-d'),
            Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS,$Main_XMLSTORE,$XMLSTORE
        ];  


        $sp_result = DB::select('EXEC SP_PRRO_UP ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?  ,?,?', $log_data);  

        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => $PRR_DOCNO. ' Sucessfully Approved.']);

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
        $TABLE      =   "TBL_TRN_PDPRR_HDR";
        $FIELD      =   "PRRID";
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
        $TABLE      =   "TBL_TRN_PDPRR_HDR";
        $FIELD      =   "PRRID";
        $ID         =   $id;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();

        $req_data[0]=[
         'NT'  => 'TBL_TRN_PDPRR_MAT',
        ];
        $req_data[1]=[
        'NT'  => 'TBL_TRN_PDPRR_STORE',
        ];
        // $req_data[2]=[
        //  'NT'  => 'TBL_TRN_PDPRR_ADD',
        // ];
        // $req_data[3]=[
        // 'NT'  => 'TBL_TRN_PDPRR_STORE_ADD',
        // ];

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

            $objResponse = DB::table('TBL_TRN_PDPRR_HDR')->where('PRRID','=',$id)->first();

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
        
		$image_path         =   "docs/company".$CYID_REF."/ProductionReturn";     
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

        $PRR_DOCNO  =   trim($request['PRR_DOCNO']);
        $objLabel = DB::table('TBL_TRN_PDPRR_HDR')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('BRID_REF','=',Session::get('BRID_REF'))
        ->where('FYID_REF','=',Session::get('FYID_REF'))
        ->where('PRR_NO','=',$PRR_DOCNO)
        ->select('PRR_NO')->first();

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

        return  DB::select('SELECT MAX(PRR_DT) PRR_DT FROM TBL_TRN_PDPRR_HDR  
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
        
        //$ObjItem = DB::select('EXEC sp_get_items_popup_enquiry_11 ?,?,?,?,?,?,?,?,?,?,?,?', $sp_popup);
        $ObjItem = DB::select('EXEC sp_get_items_popup_enquiry ?,?,?,?,?,?,?,?,?,?,?,?', $sp_popup);

       // dd($ObjItem); 

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

                //$AultUmQuantity     =   $this->getAltUmQty($ALT_UOMID_REF,$ITEMID,$FROMQTY);
                $AultUmQuantity     =   0;
                $desc6              =   $ITEMID;

               // $row = $row.'
                $row = '
                <tr id="item_'.$ITEMID .'"  class="Main_clsitemid">
                    <td style="width:8%;text-align:center;"><input type="checkbox" id="chkId'.$ITEMID.'"  value="'.$ITEMID.'" class="js-selectall1"  ></td>
                    <td style="width:10%;">'.$ICODE.'<input type="hidden" id="uniquerowid_'.$desc6.'"   /> <input type="hidden" id="txtitem_'.$ITEMID.'" data-desc="'.$ICODE.'" data-desc6="'.$desc6.'"  data-desc7="'.$AultUmQuantity.'" data-desc8="" value="'.$ITEMID.'"/></td>
                    <td style="width:10%;" id="itemname_'.$ITEMID.'" >'.$NAME.'<input type="hidden" id="txtitemname_'.$ITEMID.'" data-desc="'.$ITEM_SPECI.'" value="'.$NAME.'"/></td>
                    <td style="width:8%;" id="itemuom_'.$ITEMID.'" ><input type="hidden" id="txtitemuom_'.$ITEMID.'" data-desc="'.$Alt_UOM.'"  value="'.$MAIN_UOMID_REF.'"/>'.$Main_UOM.'</td>
                    <td style="width:8%;" id="uomqty_'.$ITEMID.'" ><input type="hidden" id="txtuomqty_'.$ITEMID.'" data-desc="'.$TOQTY.'" value="'.$ALT_UOMID_REF.'"/>'.$STDRATE.'</td>
                    <td style="width:8%;" id="irate_'.$ITEMID.'"><input type="hidden" id="txtirate_'.$ITEMID.'" data-desc="'.$FROMQTY.'" value="'.$StdCost.'"/>'.$GroupName.'</td>
                    <td style="width:8%;" id="itax_'.$ITEMID.'"><input type="hidden" id="txtitax_'.$ITEMID.'" />'.$Categoryname.'</td>
                    <td style="width:8%;">'.$BusinessUnit.'</td>
                    <td style="width:8%;" '.$AlpsStatus['hidden'].' >'.$ALPS_PART_NO.'</td>
                    <td style="width:8%;" '.$AlpsStatus['hidden'].' >'.$CUSTOMER_PART_NO.'</td>
                    <td style="width:8%;" '.$AlpsStatus['hidden'].' >'.$OEM_PART_NO.'</td>
                    <td style="width:8%;">Authorized</td>
                    <td hidden><input type="text" id="addinfoitem_'.$ITEMID .'"  data-desc101="'.$ALPS_PART_NO.'" data-desc102="'.$CUSTOMER_PART_NO.'" data-desc103="'.$OEM_PART_NO.'" ></td>
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

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');

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
                $qty                =   isset($keyid[1])?$keyid[1]:0;
                $rate               =   isset($keyid[3])?$keyid[3]:0;
                $dataArr[$batchid]  =   $qty;
                $dataArr2[$batchid] =   $rate;
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

        /*
        $objBatch =  DB::SELECT("SELECT 
        T1.BATCHID,T1.BATCH_CODE,T1.CURRENT_QTY AS TOTAL_STOCK,
        T2.STID,T2.STCODE,T2.NAME AS STNAME
        FROM TBL_MST_BATCH T1 
        LEFT JOIN TBL_MST_STORE T2 ON T2.STID=T1.STID_REF
        WHERE T1.STATUS='A' AND T1.CYID_REF ='$CYID_REF' AND T1.BRID_REF ='$BRID_REF' AND T1.ITEMID_REF ='$ITEMID_REF' AND T1.UOMID_REF ='$MAIN_UOMID_REF'
        ");
        */

        $objBatch =  DB::SELECT("SELECT '' AS BATCHID, '' as BATCH_CODE, STID,STCODE,NAME AS STNAME ,
        (SELECT SUM(CURRENT_QTY)  FROM TBL_MST_BATCH WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' 
        AND STATUS='A' AND STID_REF=STID AND ITEMID_REF='$ITEMID_REF') AS TOTAL_STOCK
        FROM TBL_MST_STORE WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' 
        AND STATUS='A' AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 )
        ");
        
        echo '<thead>';
        echo '<tr>';
        echo '<th style="width:25%;">Store</th>';
        echo '<th style="width:15%;">Main UoM (MU)</th>';
        echo '<th style="width:15%;">Stock-in-hand</th>';
        echo '<th style="width:15%;">Return Qty</th>';
        echo '<th style="width:15%;">Rate</th>';
        echo '<th style="width:15%;">Amount</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach($objBatch as $key=>$val){
            $BATCHID        =   $val->BATCH_CODE;
            $TOTAL_STOCK    =   $val->TOTAL_STOCK !=""?$val->TOTAL_STOCK:0;
            $StoreRowId     =   $val->STID.'#'.$BATCHID.'#'.$ITEMID_REF.'#'.$MAIN_UOMID_REF;
            $qtyvalue       =   array_key_exists($StoreRowId, $dataArr)?$dataArr[$StoreRowId]:0;
            $CURRENT_QTY    =   floatval($TOTAL_STOCK);
            $MainReceivedQty=   $qtyvalue > 0?$qtyvalue:'';

            $qtyrate        =   array_key_exists($StoreRowId, $dataArr2)?$dataArr2[$StoreRowId]:0;
            $st_amount      =   $qtyvalue > 0?number_format($qtyvalue*$qtyrate, 2, '.', ''):'';
            $qtyrate        =   $qtyvalue > 0?$qtyrate:'';

            
            if($ITEMID_REF !=''){
                $rateFlag       =   array_key_exists($StoreRowId, $dataArr2)?true:false;
                if($rateFlag !=true){

                    $RATE =  DB::SELECT("SELECT TOP 1 RATE FROM (
                    SELECT  A.MIS_DT AS ENTRYDATE,ISNULL(B.RATE,0)  AS RATE         
                    FROM TBL_TRN_MISS01_MULTISTORE S  INNER JOIN TBL_TRN_MISS01_HDR A ON S.MISID_REF = A.MISID             
                    LEFT JOIN TBL_MST_BATCH B ON S.ITEMID_REF=B.ITEMID_REF AND S.BATCH_CODE=B.BATCHID              
                    WHERE S.ITEMID_REF='$ITEMID_REF' AND B.CYID_REF='$CYID_REF' AND B.BRID_REF='$BRID_REF'               
                    UNION
                    SELECT  A.MISP_DT AS ENTRYDATE,ISNULL(B.RATE,0)  AS RATE         
                    FROM TBL_TRN_MISP01_MULTISTORE S  INNER JOIN TBL_TRN_MISP01_HDR A ON S.MISPID_REF = A.MISPID             
                    LEFT JOIN TBL_MST_BATCH B ON S.ITEMID_REF=B.ITEMID_REF AND S.BATCH_CODE=B.BATCHID              
                    WHERE S.ITEMID_REF='$ITEMID_REF' AND B.CYID_REF='$CYID_REF' AND B.BRID_REF='$BRID_REF'  
                    UNION
                    SELECT  A.MISRDT AS ENTRYDATE,ISNULL(B.RATE,0)    AS RATE       
                    FROM TBL_TRN_PDMISR_STORE S  INNER JOIN TBL_TRN_PDMISR_HDR A ON S.MISRID_REF = A.MISRID             
                    LEFT JOIN TBL_MST_BATCH B ON S.ITEMID_REF=B.ITEMID_REF AND S.BATCHID_REF=B.BATCHID              
                    WHERE S.ITEMID_REF='$ITEMID_REF' AND B.CYID_REF='$CYID_REF' AND B.BRID_REF='$BRID_REF'  
                    ) AS S ORDER BY S.ENTRYDATE DESC
                    ");

                    if(isset($RATE[0]->RATE) && $RATE[0]->RATE !='' && $RATE[0]->RATE > 0){
                        $qtyrate        =   number_format($RATE[0]->RATE, 2, '.', '');
                    }
                    else{
                        $qtyrate        =   number_format(0.00, '.', '');
                    }
                }
            }
            
            echo '<tr  class="participantRow33">';
            
            echo '<td style="width:25%">'.$val->STCODE.' - '.$val->STNAME.'</td>';
            echo '<td style="width:15%">'.$MAIN_UOMID_DES.'</td>';
            echo '<td style="width:15%">'.$CURRENT_QTY.'</td>';
            echo '<td style="width:15%"><input '.$ACTION_TYPE.' type="text" name="UserQty_'.$key.'" id="UserQty_'.$key.'"  value="'.$MainReceivedQty.'" onkeyup="checkStoreQty('.$ROW_ID.','.$ITEMID_REF.',this.value,'.$key.','.$CURRENT_QTY.')" class="qtytext"  onkeypress="return isNumberDecimalKey(event,this)" autocomplete="off"  ></td>';
            echo '<td style="width:15%"><input '.$ACTION_TYPE.' type="text" name="ST_RATE_'.$key.'" id="ST_RATE_'.$key.'"  value="'.$qtyrate.'" class="qtytext" onkeyup="getStoreAmount('.$key.')"  onkeypress="return isNumberDecimalKey(event,this)" autocomplete="off" ></td>';
            echo '<td style="width:15%"><input '.$ACTION_TYPE.' type="text" name="ST_AMOUNT_'.$key.'" id="ST_AMOUNT_'.$key.'" value="'.$st_amount.'"  class="qtytext"  onkeypress="return isNumberDecimalKey(event,this)" autocomplete="off" readonly ></td>';
            
            echo '<td hidden><input type="text" id="'.$key.'" value="'.$ROW_ID.'" ></td>';
            echo '<td hidden><input '.$ACTION_TYPE.' type="text" class="qtytext" name="STORE_NAME_'.$key.'" id="STORE_NAME_'.$key.'"  value="'.$val->STNAME.'"  readonly  autocomplete="off"  ></td>';
            echo '<td hidden><input type="hidden" name="BATCHID_'.$key.'" id="BATCHID_'.$key.'" value="'.$StoreRowId.'" class="qtytext" ></td>';
            echo '<td hidden><input type="hidden" name="ROWID_'.$key.'" id="ROWID_'.$key.'" value="'.$ROW_ID.'" class="qtytext" ></td>';
            echo '<td hidden><input type="hidden" name="STOCK_TYPE_'.$key.'" id="STOCK_TYPE_'.$key.'" value="'.$ST_ADJUST_TYPE.'" class="qtytext" ></td>';
            echo '<td hidden><input type="hidden" name="TOTAL_STOCK_'.$key.'" id="TOTAL_STOCK_'.$key.'" value="'.$CURRENT_QTY.'" class="qtytext" ></td>';
            echo '<td hidden><input type="hidden" name="BATCHNOA_'.$key.'" id="BATCHNOA_'.$key.'" value="'.$BATCHNOA.'" class="qtytext" ></td>';
            echo '</tr>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        exit();
    }



    public function Main_getStoreDetails(Request $request){

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $ROW_ID         =   $request['ROW_ID'];
        $RGP_NO         =   NULL;
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
                $qty                =   isset($keyid[1])?$keyid[1]:0;
                $rate               =   isset($keyid[3])?$keyid[3]:0;
                $dataArr[$batchid]  =   $qty;
                $dataArr2[$batchid] =   $rate;
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

        /*
        $objBatch =  DB::SELECT("SELECT 
        T1.BATCHID,T1.BATCH_CODE,T1.CURRENT_QTY AS TOTAL_STOCK,
        T2.STID,T2.STCODE,T2.NAME AS STNAME
        FROM TBL_MST_BATCH T1 
        LEFT JOIN TBL_MST_STORE T2 ON T2.STID=T1.STID_REF
        WHERE T1.STATUS='A' AND T1.CYID_REF ='$CYID_REF' AND T1.BRID_REF ='$BRID_REF' AND T1.FYID_REF ='$FYID_REF' AND T1.ITEMID_REF ='$ITEMID_REF' AND T1.UOMID_REF ='$MAIN_UOMID_REF'
        ");*/

        $objBatch =  DB::SELECT("SELECT '' AS BATCHID, '' as BATCH_CODE, STID,STCODE,NAME AS STNAME ,
        (SELECT SUM(CURRENT_QTY)  FROM TBL_MST_BATCH WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' 
        AND STATUS='A' AND STID_REF=STID AND ITEMID_REF='$ITEMID_REF') AS TOTAL_STOCK
        FROM TBL_MST_STORE WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' 
        AND STATUS='A' AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 )
        ");

        echo '<thead>';
        echo '<tr>';
        echo '<th style="width:25%;">Store</th>';
        echo '<th style="width:15%;">Main UoM (MU)</th>';
        echo '<th style="width:15%;">Stock-in-hand</th>';
        echo '<th style="width:15%;">Return Qty</th>';
        echo '<th style="width:15%;">Rate</th>';
        echo '<th style="width:15%;">Amount</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';


        foreach($objBatch as $key=>$val){

            $BATCHID        =   $val->BATCHID;
            $TOTAL_STOCK    =   $val->TOTAL_STOCK !=""?$val->TOTAL_STOCK:0;
            $StoreRowId     =   $val->STID.'#'.$RGP_NO.'#'.$BATCHID.'#'.$ITEMID_REF.'#'.$MAIN_UOMID_REF;
            $qtyvalue       =   array_key_exists($StoreRowId, $dataArr)?$dataArr[$StoreRowId]:0;
            $CURRENT_QTY    =   floatval($TOTAL_STOCK);
            $MainReceivedQty=   $qtyvalue > 0?$qtyvalue:'';

            $qtyrate        =   array_key_exists($StoreRowId, $dataArr2)?$dataArr2[$StoreRowId]:0;
            $st_amount      =   $qtyvalue > 0?number_format($qtyvalue*$qtyrate, 2, '.', ''):'';
            $qtyrate        =   $qtyrate > 0?number_format($qtyrate, 2, '.', ''):'';

            
            if($ITEMID_REF !=''){
                $rateFlag       =   array_key_exists($StoreRowId, $dataArr2)?true:false;
                if($rateFlag !=true){

                    $RATE =  DB::SELECT("SELECT TOP 1 RATE FROM (
                    SELECT  A.MIS_DT AS ENTRYDATE,ISNULL(B.RATE,0)  AS RATE         
                    FROM TBL_TRN_MISS01_MULTISTORE S  INNER JOIN TBL_TRN_MISS01_HDR A ON S.MISID_REF = A.MISID             
                    LEFT JOIN TBL_MST_BATCH B ON S.ITEMID_REF=B.ITEMID_REF AND S.BATCH_CODE=B.BATCHID              
                    WHERE S.ITEMID_REF='$ITEMID_REF' AND B.CYID_REF='$CYID_REF' AND B.BRID_REF='$BRID_REF'               
                    UNION
                    SELECT  A.MISP_DT AS ENTRYDATE,ISNULL(B.RATE,0)  AS RATE         
                    FROM TBL_TRN_MISP01_MULTISTORE S  INNER JOIN TBL_TRN_MISP01_HDR A ON S.MISPID_REF = A.MISPID             
                    LEFT JOIN TBL_MST_BATCH B ON S.ITEMID_REF=B.ITEMID_REF AND S.BATCH_CODE=B.BATCHID              
                    WHERE S.ITEMID_REF='$ITEMID_REF' AND B.CYID_REF='$CYID_REF' AND B.BRID_REF='$BRID_REF'  
                    UNION
                    SELECT  A.MISRDT AS ENTRYDATE,ISNULL(B.RATE,0)    AS RATE       
                    FROM TBL_TRN_PDMISR_STORE S  INNER JOIN TBL_TRN_PDMISR_HDR A ON S.MISRID_REF = A.MISRID             
                    LEFT JOIN TBL_MST_BATCH B ON S.ITEMID_REF=B.ITEMID_REF AND S.BATCHID_REF=B.BATCHID              
                    WHERE S.ITEMID_REF='$ITEMID_REF' AND B.CYID_REF='$CYID_REF' AND B.BRID_REF='$BRID_REF'  
                    ) AS S ORDER BY S.ENTRYDATE DESC
                    ");

                    if(isset($RATE[0]->RATE) && $RATE[0]->RATE !='' && $RATE[0]->RATE > 0){
                        $qtyrate        =   number_format($RATE[0]->RATE, 2, '.', '');
                    }
                    else{
                        $qtyrate        =   number_format(0.00, '.', '');
                    }
                }
            }
            

            echo '<tr  class="Main_participantRow333">';
            
            echo '<td style="width:25%">'.$val->STCODE.' - '.$val->STNAME.'</td>';
            echo '<td style="width:15%">'.$MAIN_UOMID_DES.'</td>';
            echo '<td style="width:15%">'.$CURRENT_QTY.'</td>';
            echo '<td style="width:15%"><input '.$ACTION_TYPE.' type="text" name="UserQty_'.$key.'" id="UserQty_'.$key.'"  value="'.$MainReceivedQty.'" onkeyup="Main_checkStoreQty('.$ROW_ID.','.$ITEMID_REF.',this.value,'.$key.','.$CURRENT_QTY.')" class="qtytext"  onkeypress="return isNumberDecimalKey(event,this)" autocomplete="off"  ></td>';
            echo '<td style="width:15%"><input '.$ACTION_TYPE.' type="text" name="ST_RATE_'.$key.'" id="ST_RATE_'.$key.'"  value="'.$qtyrate.'" class="qtytext" onkeyup="getStoreAmount('.$key.')"  onkeypress="return isNumberDecimalKey(event,this)" autocomplete="off" ></td>';
            echo '<td style="width:15%"><input '.$ACTION_TYPE.' type="text" name="ST_AMOUNT_'.$key.'" id="ST_AMOUNT_'.$key.'" value="'.$st_amount.'"  class="qtytext"  onkeypress="return isNumberDecimalKey(event,this)" autocomplete="off" readonly ></td>';

            echo '<td hidden><input type="text" id="'.$key.'" value="'.$ROW_ID.'" ></td>';
            echo '<td hidden style="width:15%"><input '.$ACTION_TYPE.' type="text" class="qtytext" name="STORE_NAME_'.$key.'" id="STORE_NAME_'.$key.'"  value="'.$val->STNAME.'"  readonly  autocomplete="off"  ></td>';
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

   






      
    public function get_production(Request $request) {   
             $Status = "A";
             $CYID_REF = Auth::user()->CYID_REF;
             $BRID_REF = Session::get('BRID_REF');
             $FYID_REF = Session::get('FYID_REF');        
             $objPRO = DB::table('TBL_TRN_PDPRO_HDR')
             ->where('CYID_REF','=',Auth::user()->CYID_REF)
             ->where('BRID_REF','=',Session::get('BRID_REF'))
             ->where('STATUS','=',$Status)     
             ->select('PROID','PRO_NO','PRO_DT','PRO_TITLE') 
             ->get()    
             ->toArray();
         
           // dd($objPRO); 
              
         
             if(!empty($objPRO)){        
                 foreach ($objPRO as $index=>$dataRow){   
                     $row = '';
                     $row = $row.'<tr ><td style="text-align:center; width:10%">';
                     $row = $row.'<input type="checkbox" name="getgl[]"  id="getglcode_'.$dataRow->PROID.'" class="clsspid_prr" 
                     value="'.$dataRow->PROID.'"/>             
                     </td>           
                     <td style="width:30%;">'.$dataRow->PRO_NO;
                     $row = $row.'<input type="hidden" id="txtgetglcode_'.$dataRow->PROID.'" data-code="'.$dataRow->PRO_NO.'"   data-desc="'.$dataRow->PRO_DT.'" 
                     value="'.$dataRow->PROID.'"/></td>
         
                     <td style="width:30%;">'.$dataRow->PRO_DT.'</td>
                     <td style="width:30%;">'.$dataRow->PRO_TITLE.'</td>
           
         
                    </tr>';
                     echo $row;
                 }
         
                 }else{
                     echo '<tr><td colspan="2">Record not found.</td></tr>';
                 }
         
                 exit();
         
         
         
            }



//             public function getItemDetails_production(Request $request){

//                 $Status     =   $request['status'];
//                 $PRID_REF   =   $request['PRID_REF'];
//                 $CYID_REF   =   Auth::user()->CYID_REF;
//                 $BRID_REF   =   Session::get('BRID_REF');
//                 $FYID_REF   =   Session::get('FYID_REF');       
//                 $StdCost    =   0;
//                 $Taxid      =   [];

//                 $GEID_REF   =   NULL;
//                 $POID_REF   =   NULL;
  
//                 $AlpsStatus =   $this->AlpsStatus();        
        
               
        
//                     $ObjItem =  DB::select("SELECT 
//                     T1.*,
//                     T2.ICODE,T2.NAME AS ITEM_NAME,T2.ALT_UOMID_REF,T2.ALPS_PART_NO,T2.CUSTOMER_PART_NO,T2.OEM_PART_NO,
//                     CONCAT(T3.UOMCODE,'-',T3.DESCRIPTIONS) AS MAIN_UOM_CODE,
//                     CONCAT(T4.UOMCODE,'-',T4.DESCRIPTIONS) AS AULT_UOM_CODE,G.ITEMGID AS ITEMGID_REF, T2.ICID_REF,T2.ITEM_DESC AS ITEMSPECI
//                     FROM TBL_TRN_PDMISR_MAT T1
//                     LEFT JOIN TBL_TRN_PDMISR_HDR H ON T1.MISRID_REF=H.MISRID
//                     LEFT JOIN TBL_TRN_PDRPR_HDR H2 ON H.RPRID_REF=H2.RPRID
//                     LEFT JOIN TBL_MST_ITEM T2 ON T1.ITEMID_REF=T2.ITEMID
//                     LEFT JOIN TBL_MST_ITEMGROUP G ON T2.ITEMGID_REF=G.ITEMGID
//                     LEFT JOIN TBL_MST_UOM T3 ON T1.UOMID_REF=T3.UOMID
//                     LEFT JOIN TBL_MST_UOM T4 ON T2.ALT_UOMID_REF=T4.UOMID
//                     WHERE H2.PROID_REF='$PRID_REF' AND H2.CYID_REF='$CYID_REF' AND H.STATUS='A' ORDER BY T1.MISR_MATID ASC");
        
            
//                 //dd($ObjItem); 
     
//         // /dd($ObjItem); 
//                 if(!empty($ObjItem)){
        
//                     foreach ($ObjItem as $index=>$dataRow){
                             
//                         $ObjMainUOM =  DB::select('SELECT TOP 1  UOMCODE, DESCRIPTIONS FROM TBL_MST_UOM  
//                                     WHERE  CYID_REF = ?  AND UOMID = ? 
//                                     AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?',
//                                     [$CYID_REF, $dataRow->UOMID_REF, 'A' ]);
        
//                         $ObjAltUOM =  DB::select('SELECT TOP 1  UOMCODE, DESCRIPTIONS FROM TBL_MST_UOM  
//                                     WHERE  CYID_REF = ?  AND UOMID = ? 
//                                     AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?',
//                                     [$CYID_REF, $dataRow->ALT_UOMID_REF, $Status ]);
                            
//                         $ObjAltQTY =  DB::select('SELECT TOP 1  TO_QTY, FROM_QTY FROM TBL_MST_ITEM_UOMCONV  
//                                     WHERE  ITEMID_REF = ? AND TO_UOMID_REF = ? ',
//                                     [$dataRow->ITEMID_REF,$dataRow->ALT_UOMID_REF]);
        
//                         $TOQTY =  isset($ObjAltQTY[0]->TO_QTY)? $ObjAltQTY[0]->TO_QTY : 0;
        
//                         //dd($TOQTY);
        
//                         //$FROMQTY =  isset($ObjAltQTY[0]->FROM_QTY)? $ObjAltQTY[0]->FROM_QTY : 0;
                        
//                         $TOQTY =  0;
//                         $FROMQTY =  isset($dataRow->PO_QTY)? $dataRow->PO_QTY : 0;
        
//                         $ObjItemGroup =  DB::select('SELECT TOP 1 GROUPCODE, GROUPNAME FROM TBL_MST_ITEMGROUP  
//                                     WHERE  CYID_REF = ?  AND ITEMGID = ?
//                                     AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?', 
//                                     [$CYID_REF, $dataRow->ITEMGID_REF, 'A' ]);
        
//                         $ObjItemCategory =  DB::select('SELECT TOP 1 ICCODE, DESCRIPTIONS FROM TBL_MST_ITEMCATEGORY  
//                                     WHERE  CYID_REF = ?  AND ICID = ?
//                                     AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) AND STATUS = ?', 
//                                     [$CYID_REF, $dataRow->ICID_REF, 'A' ]);

                                 
        
        
//                         $ItemRowData =  DB::select('SELECT top 1 * FROM TBL_MST_ITEM  WHERE ITEMID = ? ', [$dataRow->ITEMGID_REF]);
//                        // dd($dataRow->ITEMGID_REF); 
        
//                         if(isset($ItemRowData[0]->BUID_REF) && !is_null($ItemRowData[0]->BUID_REF)){
//                             $ObjBusinessUnit =  DB::select('SELECT TOP 1  * FROM TBL_MST_BUSINESSUNIT  
//                             WHERE  CYID_REF = ? AND BRID_REF = ?  AND BUID = ?', 
//                             [$CYID_REF, $BRID_REF, $ItemRowData[0]->BUID_REF]);
//                         }
//                         else
//                         {
//                             $ObjBusinessUnit = NULL;
//                         }
// //dd($ObjBusinessUnit); 

                        
//                         $BusinessUnit       =   isset($ObjBusinessUnit) && $ObjBusinessUnit != NULL ? $ObjBusinessUnit[0]->BUCODE.'-'.$ObjBusinessUnit[0]->BUNAME : '';
//                         $ALPS_PART_NO       =   isset($ItemRowData[0]->ALPS_PART_NO) && $ItemRowData[0]->ALPS_PART_NO != NULL ?$ItemRowData[0]->ALPS_PART_NO:'';
//                         $CUSTOMER_PART_NO   =  isset($ItemRowData[0]->CUSTOMER_PART_NO) && $ItemRowData[0]->CUSTOMER_PART_NO != NULL ?$ItemRowData[0]->CUSTOMER_PART_NO:'';
//                         $OEM_PART_NO        =   isset($ItemRowData[0]->OEM_PART_NO) && $ItemRowData[0]->OEM_PART_NO != NULL ?$ItemRowData[0]->OEM_PART_NO:'';
        
        
//                             $AultUmQuantity = $this->getAltUmQty($dataRow->ALT_UOMID_REF,$dataRow->ITEMID_REF,$FROMQTY);
        
//                             $PENDING_QTY=   0;
//                             $MRSID_REF  =   '';
//                             $PIID_REF   =   '';
//                             $RFQID_REF  =   '';
//                             $VQID_REF   =   '';
        
//                             $RATE       = NULL;
        
                
                      
//                                 $ISSUED_QTY    =   $dataRow->ISSUED_QTY;
//                                 $desc6  =   $POID_REF.'-'.$GEID_REF.'-'.$dataRow->ITEMID_REF;
                     
        
        
//                            // DD($ISSUED_QTY);
        
                            
//                             $row = '';
//                             $row = $row.'<tr id="item_'.$desc6.'"  class="clsitemid"><td  style="width:8%; text-align: center;"><input type="checkbox" id="Main_chkId'.$desc6.'"  value="'.$desc6.'" class="js-selectall1"  ></td>';
//                             $row = $row.'<td style="width:10%;">'.$dataRow->ICODE;
//                             $row = $row.'<input type="hidden" id="uniquerowid_'.$desc6.'"   />';
//                             $row = $row.'<input type="hidden" id="txtitem_'.$desc6.'" data-desc="'.$dataRow->ICODE.'" data-desc6="'.$desc6.'"  data-desc7="'.$AultUmQuantity.'" data-desc8="'.$PENDING_QTY.'" data-desc9="'.$MRSID_REF.'" data-desc10="'.$PIID_REF.'" data-desc11="'.$RFQID_REF.'" data-desc12="'.$VQID_REF.'" data-desc13="'.$RATE.'" value="'.$dataRow->ITEMID_REF.'"/></td> 
//                             <td style="width:10%;" id="itemname_'.$desc6.'" >'.$dataRow->ITEM_NAME;
//                             $row = $row.'<input type="hidden" id="txtitemname_'.$desc6.'" data-desc="'.$dataRow->ITEMSPECI.'" value="'.$dataRow->ITEM_NAME.'"/></td>';
//                             $row = $row.'<td style="width:8%;" id="itemuom_'.$desc6.'" ><input type="hidden" id="txtitemuom_'.$desc6.'" data-desc="'.$ObjAltUOM[0]->UOMCODE.'-'.$ObjAltUOM[0]->DESCRIPTIONS.'"  data-desc2="'.$ALPS_PART_NO.'" data-desc3="'.$CUSTOMER_PART_NO.'" data-desc4="'.$OEM_PART_NO.'"   value="'.$dataRow->UOMID_REF.'"/>'.$ObjMainUOM[0]->UOMCODE.'-'.$ObjMainUOM[0]->DESCRIPTIONS.'</td>';
//                             $row = $row.'<td style="width:8%;" id="uomqty_'.$desc6.'" ><input type="hidden" id="txtuomqty_'.$desc6.'" data-desc="'.$TOQTY.'" value="'.$dataRow->ALT_UOMID_REF.'"/>'.$FROMQTY.'</td>';
//                             $row = $row.'<td style="width:8%;" id="irate_'.$desc6.'"><input type="hidden" id="txtirate_'.$desc6.'" data-desc="'.$FROMQTY.'" value="'.$StdCost.'"/>'.$ObjItemGroup[0]->GROUPCODE.'-'.$ObjItemGroup[0]->GROUPNAME.'</td>';
//                             $row = $row.'<td style="width:8%;" id="itax_'.$desc6.'"><input type="hidden" id="txtitax_'.$desc6.'" />'.$ObjItemCategory[0]->ICCODE.'-'.$ObjItemCategory[0]->DESCRIPTIONS.'</td>
                            
//                             <td style="width:8%;">'.$BusinessUnit.'</td>
//                             <td style="width:8%;" '.$AlpsStatus['hidden'].' >'.$ALPS_PART_NO.'</td>
//                             <td style="width:8%;" '.$AlpsStatus['hidden'].' >'.$CUSTOMER_PART_NO.'</td>
//                             <td style="width:8%;" '.$AlpsStatus['hidden'].' >'.$OEM_PART_NO.'</td>
//                             <td style="width:8%;">Authorized</td>
//                             </tr>';
//                             echo $row;    
//                         } 
                            
                            
//                         }           
//                         else{
//                          echo '<tr><td> Record not found.</td></tr>';
//                         }
//                 exit();
//             }





            /*MAIN ITEM*/
            
            public function Main_getItemDetails(Request $request){
                $Status     =   $request['status'];
                $PRID_REF   =   $request['PRID_REF'];
                //dd($CodeNoId); 
                //$POID_REF = $request['POID_REF'];
                $CYID_REF = Auth::user()->CYID_REF;
                $BRID_REF = Session::get('BRID_REF');
                $FYID_REF = Session::get('FYID_REF');
                $StdCost = 0;
                $Taxid = [];
        
                $AlpsStatus         =   $this->AlpsStatus();
                
                // $ObjItem =  DB::select("SELECT 
                // T1.ITEMID,T1.ICODE,T1.NAME,T1.ICID_REF,T1.ITEMGID_REF,T1.ALT_UOMID_REF,
                // T1.ALPS_PART_NO,T1.CUSTOMER_PART_NO,T1.OEM_PART_NO,T1.BUID_REF,
                // T2.* 
                // FROM TBL_MST_ITEM T1
                // INNER JOIN TBL_TRN_MRQS01_MAT T2 ON T1.ITEMID=T2.ITEMID_REF
                // WHERE T1.CYID_REF = '$CYID_REF' 
                // AND ( T1.DEACTIVATED IS NULL OR T1.DEACTIVATED = 0 ) AND T1.STATUS ='$Status' AND T2.MRSID_REF='$CodeNoId'");
        
               //dd($ObjItem); die;
               
               $ObjItem =  DB::select("SELECT 
               T1.*,
               T2.ITEMID,T2.ICODE,T2.NAME,T2.ICID_REF,T2.ITEMGID_REF,T2.ALT_UOMID_REF,
               T2.ALPS_PART_NO,T2.CUSTOMER_PART_NO,T2.OEM_PART_NO,T2.BUID_REF,T2.MAIN_UOMID_REF,T2.ALT_UOMID_REF,T2.ITEM_SPECI,
               CONCAT(T3.UOMCODE,'-',T3.DESCRIPTIONS) AS MAIN_UOM_CODE,
               CONCAT(T4.UOMCODE,'-',T4.DESCRIPTIONS) AS AULT_UOM_CODE
               FROM TBL_TRN_PDMISR_MAT T1
               LEFT JOIN TBL_TRN_PDMISR_HDR H ON T1.MISRID_REF=H.MISRID
               LEFT JOIN TBL_TRN_PDRPR_HDR H2 ON H.RPRID_REF=H2.RPRID
               LEFT JOIN TBL_MST_ITEM T2 ON T1.ITEMID_REF=T2.ITEMID
               LEFT JOIN TBL_MST_ITEMGROUP G ON T2.ITEMGID_REF=G.ITEMGID
               LEFT JOIN TBL_MST_UOM T3 ON T1.UOMID_REF=T3.UOMID
               LEFT JOIN TBL_MST_UOM T4 ON T2.ALT_UOMID_REF=T4.UOMID
               WHERE H2.PROID_REF='$PRID_REF' AND H2.CYID_REF='$CYID_REF' AND H.STATUS='A' ORDER BY T1.MISR_MATID ASC");

               //dd($ObjItem); 
        
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

                        $PENDING_QTY=$dataRow->ISSUED_QTY;
        
                        //dd($TOQTY);
        
                        //$FROMQTY =  isset($ObjAltQTY[0]->FROM_QTY)? $ObjAltQTY[0]->FROM_QTY : 0;
                     
                        $TOQTY =  0;
                        $FROMQTY =  isset($PENDING_QTY)? $PENDING_QTY : 0;
        
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
        
                            $desc6  =   $dataRow->ITEMID;
        
                            $row = '';
                            $row = $row.'<tr id="item_'.$dataRow->ITEMID .'"  class="Main_clsitemid"><td  style="width:8%; text-align: center;"><input type="checkbox" id="Main_chkId'.$dataRow->ITEMID.'"  value="'.$dataRow->ITEMID.'" class="Main_js-selectall1"  ></td>';
                            $row = $row.'<td style="width:10%;">'.$dataRow->ICODE;
                            $row = $row.'<input type="hidden" id="uniquerowid_'.$desc6.'"   />';
                            $row = $row.'<input type="hidden" id="txtitem_'.$dataRow->ITEMID.'" data-desc="'.$dataRow->ICODE.'" data-desc6="'.$desc6.'"  data-desc7="'.$AultUmQuantity.'" data-desc8="'.$PENDING_QTY.'"
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
                            <td hidden><input type="text" id="addinfoitem_'.$dataRow->ITEMID .'"  data-desc101="'.$ALPS_PART_NO.'" data-desc102="'.$CUSTOMER_PART_NO.'" data-desc103="'.$OEM_PART_NO.'" ></td>
                            </tr>';
                            echo $row;    
                        } 
                            
                            
                        }           
                        else{
                         echo '<tr><td> Record not found.</td></tr>';
                        }
                exit();
            }


    
}
