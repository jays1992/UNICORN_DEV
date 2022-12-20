<?php
namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Response;
use Session;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Helpers\Utils;

class MstFrm204Controller extends Controller{

    protected $form_id  = 204;
    protected $vtid_ref = 127;
    protected $view     = "masters.Common.UserBranchMapping.mstfrm";
    
    protected   $messages = [
            'DOC_NO.required'   => 'Required field',
            'DOC_DT.required'   => 'Required field',
            'MAPBRID_REF.required'   => 'Required field',
        ];

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $objRights      =   $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);
        
        $FormId         =   $this->form_id;

        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');
        $USERID     =   Auth::user()->USERID;

        $objDataList=array();

        $objDataArr    =   DB::select("SELECT 
        USER_BR_MAPID AS DOC_ID,
        USER_BR_MAP_DOCNO AS DOC_NO,
        USER_BR_MAP_DOCDT AS DOC_DT,
        INDATE,
        STATUS
        FROM TBL_MST_USER_BRANCH_MAP WHERE CYID_REF='$CYID_REF'  ");

        //AND BRID_REF='$BRID_REF'

        foreach($objDataArr as $val){
            $objDataList[$val->DOC_NO]=$val;
        }

       // $objDataList=$objDataArr;

        return view($this->view.$FormId,compact(['objRights','objDataList','FormId']));

    }

    public function add(){
        $FormId     =   $this->form_id;
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $USERID     =   Auth::user()->USERID;

        $getBranch  =   $this->getBranch();

        $getCustomer= DB::select("SELECT  
        USERID AS DATA_ID,
        UCODE AS DATA_CODE,
        DESCRIPTIONS AS DATA_DESCRIPTION 
        FROM TBL_MST_USER 
        WHERE CYID_REF='$CYID_REF' AND STATUS='A' AND (DEACTIVATED=0 or DEACTIVATED is null)");

        $viewArr=array(
            'FormId',
            'getBranch',
            'getCustomer'
        );

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $docarray   =   $this->get_docno_for_master([
            'VTID_REF'=>$this->vtid_ref,
            'CYID_REF'=>Auth::user()->CYID_REF,
            'BRID_REF'=>NULL
        ]);



        return view($this->view.$FormId.'add',compact([$viewArr,'docarray'])); 
    }

    public function save(Request $request){

        $rules = [
            'DOC_NO' => 'required',
            'DOC_DT' => 'required',   
            'MAPBRID_REF' => 'required',    
        ];

        $req_data = [
            'DOC_NO'        =>    $request['DOC_NO'],
            'DOC_DT'        =>   $request['DOC_DT'],
            'MAPBRID_REF'   =>   $request['MAPBRID_REF']
        ]; 

        $validator = Validator::make( $req_data, $rules, $this->messages);

        if ($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);	
        }

        $DOC_NO         =   strtoupper(trim($request['DOC_NO']) );
        $DOC_DT         =   (isset($request['DOC_DT']) && trim($request['DOC_DT']) !="" )? date('Y-m-d',strtotime(trim($request['DOC_DT']))) : NULL ;
        $MAPBRID_REF    =   (isset($request['MAPBRID_REF']) && trim($request['MAPBRID_REF']) !="" )? trim($request['MAPBRID_REF']) : NULL ;
        
        $data2 = array();
        if(isset($request['DATA_ID']) && !empty($request['DATA_ID'])){
            foreach($request['DATA_ID'] as $key=>$val){
                $data2[] = [
                    'USERID_REF' => $val,
                    'DEACTIVATEDF'=>0,
                    'DODEACTIVATEDF'=>NULL,
                ];
            }
        }

        if(!empty($data2)){     
            $wrapped_links2["USERBRMAP"] = $data2; 
            $XML = ArrayToXml::convert($wrapped_links2);
        }else{
            $XML = NULL;
        }

        $DEACTIVATED    =   0;  
        $DODEACTIVATED  =   NULL;  

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');       
        $VTID           =   $this->vtid_ref;
        $USERID         =   Auth::user()->USERID;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "ADD";
        $IPADDRESS      =   $request->getClientIp();

        $array_data   = [
            $DOC_NO,$DOC_DT, $MAPBRID_REF,$CYID_REF,$BRID_REF,$FYID_REF,$VTID,$USERID,$UPDATE,$UPTIME, 
            $ACTION, $IPADDRESS,$XML  
        ];

        try {

            $sp_result = DB::select('EXEC SP_USERBRMAPPING_IN ?,?,?,?,?,?,?,?,?,?, ?,?,?', $array_data);

        } catch (\Throwable $th) {
            return Response::json(['errors'=>true,'msg' => 'There is some data error. Please try after sometime.','save'=>'invalid']);
        }
    
        if(Str::contains(strtoupper($sp_result[0]->RESULT), 'SUCCESS')){

            return Response::json(['success' =>true,'msg' => $sp_result[0]->RESULT]);

        }elseif(Str::contains(strtoupper($sp_result[0]->RESULT), 'DUPLICATE RECORD')){
        
            return Response::json(['errors'=>true,'msg' => $sp_result[0]->RESULT,'exist'=>'duplicate']);
            
        }else{

            return Response::json(['errors'=>true,'msg' => 'There is some data error. Please try after sometime.','save'=>'invalid']);
        }
        
        exit();    
    }

    public function edit($id){

        if(!is_null($id)){
        
            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $FormId     =   $this->form_id;
            $CYID_REF   =   Auth::user()->CYID_REF;
            $BRID_REF   =   Session::get('BRID_REF');
            $USERID     =   Auth::user()->USERID;

            $getBranch  =   $this->getBranch();

            $objResponse =  DB::table('TBL_MST_USER_BRANCH_MAP')
            ->where('CYID_REF','=',$CYID_REF)
            ->where('USER_BR_MAPID','=',$id)
            ->select('USER_BR_MAPID AS DOC_ID','USER_BR_MAP_DOCNO AS DOC_NO','USER_BR_MAP_DOCDT AS DOC_DT','MAPBRID_REF')
            ->first();

            $DOC_NO         =   $objResponse->DOC_NO;
            $MAPBRID_REF    =   $objResponse->MAPBRID_REF;

            $getCustomer  =   DB::select("SELECT  
            T1.USERID AS DATA_ID,
            T1.UCODE AS DATA_CODE,
            T1.DESCRIPTIONS AS DATA_DESCRIPTION,
            T2.USER_BR_MAPID as AUTO_MAP_ID,
            T2.USERID_REF as DATA_ID_REF,
            T2.DEACTIVATED,
            T2.DODEACTIVATED 
            FROM TBL_MST_USER T1
            LEFT JOIN TBL_MST_USER_BRANCH_MAP T2 ON T1.USERID=T2.USERID_REF AND T2.USER_BR_MAP_DOCNO='$DOC_NO' AND T2.MAPBRID_REF='$MAPBRID_REF' AND T2.CYID_REF='$CYID_REF' 
            WHERE T1.CYID_REF='$CYID_REF' AND T1.STATUS='A' AND (T1.DEACTIVATED=0 or T1.DEACTIVATED is null) ");

            $viewArr=array(
                'FormId',
                'objRights',
                'getBranch',
                'getCustomer',
                'objResponse',
            );

            return view($this->view.$FormId.'edit',compact($viewArr));

        }

    }

    public function view($id){

        if(!is_null($id)){
        
            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $FormId     =   $this->form_id;
            $CYID_REF   =   Auth::user()->CYID_REF;
            $BRID_REF   =   Session::get('BRID_REF');
            $USERID     =   Auth::user()->USERID;

            $getBranch  =   $this->getBranch();

            $objResponse =  DB::table('TBL_MST_USER_BRANCH_MAP')
            ->where('CYID_REF','=',$CYID_REF)
            ->where('USER_BR_MAPID','=',$id)
            ->select('USER_BR_MAPID AS DOC_ID','USER_BR_MAP_DOCNO AS DOC_NO','USER_BR_MAP_DOCDT AS DOC_DT','MAPBRID_REF')
            ->first();

            $DOC_NO         =   $objResponse->DOC_NO;
            $MAPBRID_REF    =   $objResponse->MAPBRID_REF;

            $getCustomer  =   DB::select("SELECT  
            T1.USERID AS DATA_ID,
            T1.UCODE AS DATA_CODE,
            T1.DESCRIPTIONS AS DATA_DESCRIPTION,
            T2.USER_BR_MAPID as AUTO_MAP_ID,
            T2.USERID_REF as DATA_ID_REF,
            T2.DEACTIVATED,
            T2.DODEACTIVATED 
            FROM TBL_MST_USER T1
            LEFT JOIN TBL_MST_USER_BRANCH_MAP T2 ON T1.USERID=T2.USERID_REF AND T2.USER_BR_MAP_DOCNO='$DOC_NO' AND T2.MAPBRID_REF='$MAPBRID_REF' AND T2.CYID_REF='$CYID_REF' 
            WHERE T1.CYID_REF='$CYID_REF' AND T1.STATUS='A' AND (T1.DEACTIVATED=0 or T1.DEACTIVATED is null) ");

            $viewArr=array(
                'FormId',
                'objRights',
                'getBranch',
                'getCustomer',
                'objResponse',
            );

            return view($this->view.$FormId.'view',compact($viewArr));

        }

    }
 
    public function update(Request $request){

        $rules = [
            'DOC_NO' => 'required',
            'DOC_DT' => 'required',   
            'MAPBRID_REF' => 'required',   
        ];

        $req_data = [
            'DOC_NO'        =>    $request['DOC_NO'],
            'DOC_DT'        =>   $request['DOC_DT'],
            'MAPBRID_REF'   =>   $request['MAPBRID_REF']
        ]; 

        $validator = Validator::make( $req_data, $rules, $this->messages);

        if ($validator->fails()){
            return Response::json(['errors' => $validator->errors()]);	
        }

        $DOC_NO         =   strtoupper(trim($request['DOC_NO']) );
        $DOC_DT         =   (isset($request['DOC_DT']) && trim($request['DOC_DT']) !="" )? date('Y-m-d',strtotime(trim($request['DOC_DT']))) : NULL ;
        $MAPBRID_REF    =   (isset($request['MAPBRID_REF']) && trim($request['MAPBRID_REF']) !="" )? trim($request['MAPBRID_REF']) : NULL ;
        
        $data2 = array();
        if(isset($request['DATA_ID']) && !empty($request['DATA_ID'])){
            foreach($request['DATA_ID'] as $key=>$val){
                $data2[] = [
                    'USER_BR_MAPID'=>isset($request['AUTO_MAP_ID_'.$key]) && $request['AUTO_MAP_ID_'.$key] !=""?$request['AUTO_MAP_ID_'.$key]:NULL,
                    'USERID_REF' => $val,
                    'DEACTIVATED'=>(isset($request['DEACTIVATED_'.$key]) )? 1 : 0 ,
                    'DODEACTIVATED'=>isset($request['DODEACTIVATED_'.$key]) && $request['DODEACTIVATED_'.$key] !=""?date("Y-m-d",strtotime($request['DODEACTIVATED_'.$key])):NULL,
                ];
            }
        }
        
        if(!empty($data2)){     
            $wrapped_links2["USERBRMAP"] = $data2; 
            $XML = ArrayToXml::convert($wrapped_links2);
        }else{
            $XML = NULL;
        }

        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');       
        $VTID       =   $this->vtid_ref;
        $USERID     =   Auth::user()->USERID;
        $UPDATE     =   Date('Y-m-d');
        
        $UPTIME     =   Date('h:i:s.u');
        $ACTION     =   "EDIT";
        $IPADDRESS  =   $request->getClientIp();
 
        $array_data   = [
            $DOC_NO,$DOC_DT, $MAPBRID_REF,$CYID_REF,$BRID_REF,$FYID_REF,$VTID,$USERID,$UPDATE,$UPTIME, 
            $ACTION, $IPADDRESS,$XML  
        ];

        try {
        
            $sp_result = DB::select('EXEC SP_USERBRMAPPING_UP ?,?,?,?,?,?,?,?,?,?, ?,?,?', $array_data);

        } catch (\Throwable $th) {
            return Response::json(['errors'=>true,'msg' => 'There is some data error. Please try after sometime.','save'=>'invalid']);
        }

        if($sp_result[0]->RESULT=="SUCCESS"){  

            return Response::json(['success' =>true,'msg' => 'Record successfully updated.']);
        
        }elseif($sp_result[0]->RESULT=="NO RECORD FOUND"){
        
            return Response::json(['errors'=>true,'msg' => 'No record found.','exist'=>'norecord']);
            
        }else{

            return Response::json(['errors'=>true,'msg' => 'Error:'.$sp_result[0]->RESULT,'save'=>'invalid']);
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
   
        $DOC_NO         =   strtoupper(trim($request['DOC_NO']) );
        $DOC_DT         =   (isset($request['DOC_DT']) && trim($request['DOC_DT']) !="" )? date('Y-m-d',strtotime(trim($request['DOC_DT']))) : NULL ;
        $MAPBRID_REF    =   (isset($request['MAPBRID_REF']) && trim($request['MAPBRID_REF']) !="" )? trim($request['MAPBRID_REF']) : NULL ;
        
        $data2 = array();
        if(isset($request['DATA_ID']) && !empty($request['DATA_ID'])){
            foreach($request['DATA_ID'] as $key=>$val){
                $data2[] = [
                    'USER_BR_MAPID'=>isset($request['AUTO_MAP_ID_'.$key]) && $request['AUTO_MAP_ID_'.$key] !=""?$request['AUTO_MAP_ID_'.$key]:NULL,
                    'USERID_REF' => $val,
                    'DEACTIVATED'=>(isset($request['DEACTIVATED_'.$key]) )? 1 : 0 ,
                    'DODEACTIVATED'=>isset($request['DODEACTIVATED_'.$key]) && $request['DODEACTIVATED_'.$key] !=""?date("Y-m-d",strtotime($request['DODEACTIVATED_'.$key])):NULL,
                ];
            }
        }
        
        if(!empty($data2)){     
            $wrapped_links2["USERBRMAP"] = $data2; 
            $XML = ArrayToXml::convert($wrapped_links2);
        }else{
            $XML = NULL;
        }

        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');       
        $VTID       =   $this->vtid_ref;
        $USERID     =   Auth::user()->USERID;
        $UPDATE     =   Date('Y-m-d');
        
        $UPTIME     =   Date('h:i:s.u');
        $ACTION     = $Approvallevel;
        $IPADDRESS  =   $request->getClientIp();

        $array_data   = [
            $DOC_NO,$DOC_DT, $MAPBRID_REF,$CYID_REF,$BRID_REF,$FYID_REF,$VTID,$USERID,$UPDATE,$UPTIME, 
            $ACTION, $IPADDRESS,$XML  
        ];

        try {

            $sp_result = DB::select('EXEC SP_USERBRMAPPING_UP ?,?,?,?,?,?,?,?,?,?, ?,?,?', $array_data);

        } catch (\Throwable $th) {
            return Response::json(['errors'=>true,'msg' => 'There is some data error. Please try after sometime.','save'=>'invalid']);
        }

        if($sp_result[0]->RESULT=="SUCCESS"){  

            return Response::json(['success' =>true,'msg' => 'Record successfully approved.']);
        
        }elseif($sp_result[0]->RESULT=="NO RECORD FOUND"){
        
            return Response::json(['errors'=>true,'msg' => 'No record found.','exist'=>'norecord']);
            
        }else{

            return Response::json(['errors'=>true,'msg' => 'Error:'.$sp_result[0]->RESULT,'save'=>'invalid']);
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
        $TABLE      =   "TBL_MST_USER_BRANCH_MAP";
        $FIELD      =   "USER_BR_MAPID";
        $ACTIONNAME     = $Approvallevel;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();
            
        $log_data = [ 
            $USERID_REF, $VTID_REF, $TABLE, $FIELD, $xml, $ACTIONNAME, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS
        ];

        $sp_result = DB::select('EXEC SP_MST_MULTIAPPROVAL ?,?,?,?,?,?,?,?,?,?,?,?',  $log_data);
        
        
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
        $TABLE      =   "TBL_MST_USER_BRANCH_MAP";
        $FIELD      =   "USER_BR_MAPID";
        $ID         =   $id;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();

        $cancelData[0]= ['NT' =>'TBL_MST_USER_BRANCH_MAP'];
        $cancel_links["TABLES"] = $cancelData;
        $cancelxml = ArrayToXml::convert($cancel_links);
        $mst_cancel_data = [ $USERID_REF, $VTID_REF, $TABLE, $FIELD, $ID, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS ,$cancelxml];
        $sp_result = DB::select('EXEC SP_MST_CANCEL  ?,?,?,?, ?,?,?,?, ?,?,?,?', $mst_cancel_data);


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

            $objResponse = DB::table('TBL_MST_USER_BRANCH_MAP')->where('USER_BR_MAPID','=',$id)->first();

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
        
		$destinationPath = storage_path()."/docs/company".$CYID_REF."/UserBranchMapping";
		$image_path         =   "docs/company".$CYID_REF."/UserBranchMapping";     
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

                   

                    $filenametostore        =  $VTID.$ATTACH_DOCNO.$USERID.$CYID_REF.$BRID_REF.$FYID_REF."#_".$filenamewithextension;  

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
            return redirect()->route("master",[$FormId,"attachment",$ATTACH_DOCNO])->with("success","No file uploaded");
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

            return redirect()->route("master",[$FormId,"attachment",$ATTACH_DOCNO])->with("success","Files successfully attached. ".$duplicate_files.$invlid_files);


        }        elseif($sp_result[0]->RESULT=="Duplicate file for same records"){
       
            return redirect()->route("master",[$FormId,"attachment",$ATTACH_DOCNO])->with("success","Duplicate file name. ".$invlid_files);
    
        }else{

            
            return redirect()->route("master",[$FormId,"attachment",$ATTACH_DOCNO])->with($sp_result[0]->RESULT);
        }
       
    }  

    public function getBranch(){
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $USERID     =   Auth::user()->USERID;

       return DB::table('TBL_MST_BRANCH')
        ->where('CYID_REF','=',$CYID_REF)
        //->where('BRID','=',$BRID_REF)
        ->where('STATUS','=','A')
        ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
        ->select("BRID AS FID","BRCODE","BRNAME")
        ->get();
    }

    public function getBranchCompanyName(Request $request){

        if(isset($request['MAPBRID_REF']) && $request['MAPBRID_REF'] !=""){

            $MAPBRID_REF    =   $request['MAPBRID_REF'];

            $objData = DB::select("SELECT T2.BG_DESC AS BRANCH_GROUP_NAME,T3.NAME AS COMPANY_NAME FROM TBL_MST_BRANCH T1
            INNER JOIN TBL_MST_BRANCH_GROUP T2 ON T1.BGID_REF=T2.BGID
            INNER JOIN TBL_MST_COMPANY T3 ON T2.CYID_REF=T3.CYID
            WHERE T1.BRID='$MAPBRID_REF' AND T1.STATUS='A'  AND (T1.DEACTIVATED=0 or T1.DEACTIVATED is null)");

            $branch=$objData[0]->BRANCH_GROUP_NAME;
            $company=$objData[0]->COMPANY_NAME;

            return Response::json(['company'=>$company,'branch' => $branch]);

        }
        else{
            return Response::json(['company'=>'','branch' => '']);
        }
        exit();
    }

    public function codeduplicate(Request $request){

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');
        $DOC_NO =   $request['DOC_NO'];
        
        $objLabel = DB::table('TBL_MST_USER_BRANCH_MAP')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('USER_BR_MAP_DOCNO','=',$DOC_NO)
        ->select('USER_BR_MAP_DOCNO')
        ->first();
        
        if($objLabel){  

            return Response::json(['exists' =>true,'msg' => 'Duplicate record']);
        
        }else{

            return Response::json(['not exists'=>true,'msg' => 'Ok']);
        }
        
        exit();
    }

    public function codeduplicate1(Request $request){

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');
        $MAPBRID_REF =   $request['MAPBRID_REF'];
        
        $objLabel = DB::table('TBL_MST_USER_BRANCH_MAP')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('MAPBRID_REF','=',$MAPBRID_REF)
        ->select('MAPBRID_REF')
        ->first();
        
        if($objLabel){  

            return Response::json(['exists' =>true,'msg' => 'Duplicate record']);
        
        }else{

            return Response::json(['not exists'=>true,'msg' => 'Ok']);
        }
        
        exit();
    }


}
