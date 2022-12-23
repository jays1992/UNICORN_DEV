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

class TrnFrm542Controller extends Controller{

    protected $form_id  =   542;
    protected $vtid_ref =   612;
    protected $view     =   "transactions.sales.ServiceInvoice.trnfrm542";
   
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){  



       
        
        $objRights  =   $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);
  
        $CYID_REF   	=   Auth::user()->CYID_REF;
        $BRID_REF   	=   Session::get('BRID_REF');
        $FYID_REF   	=   Session::get('FYID_REF');   
        $FormId         =   $this->form_id;





$objFinalAppr = DB::select("select dbo.FN_APRL('$this->vtid_ref','$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
        $FANO = "APPROVAL".$objFinalAppr[0]->FA_NO;

        $objDataList	=	DB::select("select 
        hdr.DGID,hdr.DOCNO,hdr.DOCDT,hdr.INDATE,hdr.STATUS,
        (
        SELECT TOP 1 USR.DESCRIPTIONS FROM TBL_TRN_AUDITTRAIL AUD 
        LEFT JOIN TBL_MST_USER USR ON AUD.USERID=USR.USERID 
        WHERE  AUD.VID=hdr.DGID AND  AUD.CYID_REF=hdr.CYID_REF AND  AUD.BRID_REF=hdr.BRID_REF AND  
        AUD.FYID_REF=hdr.FYID_REF AND  AUD.VTID_REF=hdr.VTID_REF AND AUD.ACTIONNAME='ADD'       
        ) AS CREATED_BY,
        
        case when a.ACTIONNAME = '$FANO' then 'Final Approved' 
        else case when a.ACTIONNAME = 'ADD' then 'Added'  
            when a.ACTIONNAME = 'EDIT' then 'Edited'
            when a.ACTIONNAME = 'APPROVAL1' then 'First Level Approved'
            when a.ACTIONNAME = 'APPROVAL2' then 'Second Level Approved'
            when a.ACTIONNAME = 'APPROVAL3' then 'Third Level Approved'
            when a.ACTIONNAME = 'APPROVAL4' then 'Fourth Level Approved'
            when a.ACTIONNAME = 'APPROVAL5' then 'Final Approved' 
            when a.ACTIONNAME = 'CANCEL' then 'Cancelled'
            when a.ACTIONNAME = 'CLOSE' then 'Closed'
        end end as STATUS_DESC
        from TBL_TRN_AUDITTRAIL a 
        inner join TBL_TRN_DISPATCH_GOODS_HDR hdr
        on a.VID = hdr.DGID 
        
        and a.CYID_REF = hdr.CYID_REF 
        and a.BRID_REF = hdr.BRID_REF
        where a.VTID_REF = '$this->vtid_ref'
        and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF' AND hdr.FYID_REF='$FYID_REF'
        and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
        ORDER BY hdr.DGID DESC ");

        

        return view($this->view,compact(['FormId','objRights','objDataList']));
    }
	
	

    public function add(){

        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');
        $FormId     =   $this->form_id;

        $doc_req    =   array(
            'VTID_REF'          =>$this->vtid_ref,
            'HDR_TABLE'         =>'TBL_TRN_DISPATCH_GOODS_HDR',
            'HDR_ID'=>'DGID',
            'HDR_DOC_NO'=>'DOCNO',
            'HDR_DOC_DT'=>'DOCDT',
            'HDR_DOC_TYPE'=>'transaction'
        );

        $docarray   =   $this->getManualAutoDocNo(date('Y-m-d'),$doc_req); 
        return view($this->view.'add', compact(['FormId','doc_req','docarray']));       
    }


    public function save(Request $request){

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');
        $VTID_REF       =   $this->vtid_ref;
        $USERID_REF     =   Auth::user()->USERID;   
        $ACTIONNAME     =   'ADD';
        $IPADDRESS      =   $request->getClientIp();
        
        


        $REQ_DET    =   array();
        $XML_DET    =   NULL;
        if(isset($_REQUEST['DOCUMENT_TYPE']) && !empty($_REQUEST['DOCUMENT_TYPE'])){
            foreach($_REQUEST['DOCUMENT_TYPE'] as $key=>$val){
                if(trim($_REQUEST['DOCUMENT_TYPE'][$key]) !=''){
                    $REQ_DET[] = array(
                        'DOCUMENT_TYPE'         => trim($_REQUEST['DOCUMENT_TYPE'][$key])?trim($_REQUEST['DOCUMENT_TYPE'][$key]):NULL,
                        'DOCID_REF'             => trim($_REQUEST['DOCUMENTID_REF'][$key])?trim($_REQUEST['DOCUMENTID_REF'][$key]):NULL,
                        'DOCID_DT'              => trim($_REQUEST['DOCUMENT_DT'][$key])?trim($_REQUEST['DOCUMENT_DT'][$key]):NULL,
                        'TRANSPORTID_REF'       => trim($_REQUEST['TRANSPORTERID_REF'][$key])?trim($_REQUEST['TRANSPORTERID_REF'][$key]):NULL,
                        'DOCKET_NO'             => trim($_REQUEST['DOCKET_NO'][$key])?trim($_REQUEST['DOCKET_NO'][$key]):NULL,
                        'DISPATCH_DT'           => trim($_REQUEST['DISPATCH_DT'][$key])?trim($_REQUEST['DISPATCH_DT'][$key]):NULL,
                        'MODE'                  => trim($_REQUEST['MODE'][$key])?trim($_REQUEST['MODE'][$key]):NULL,
                        'REMARKS'               => trim($_REQUEST['REMARKS'][$key])?trim($_REQUEST['REMARKS'][$key]):NULL
                    );
                }
            }  
        }

       
        if(!empty($REQ_DET)){
            $ARR_DET["PAY"] =   $REQ_DET; 
            $XML_DET        =   ArrayToXml::convert($ARR_DET);
        }


       
        

        $DOC_NO                 =   $request['DOC_NO'];
        $DOC_DATE               =   $request['DOC_DATE'];
      
       
        $log_data = [
            $DOC_NO,$DOC_DATE,
            $CYID_REF,$BRID_REF,$FYID_REF,$VTID_REF,
            $USERID_REF,Date('Y-m-d'),Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS,$XML_DET
        ];

        

        $sp_result  =   DB::select('EXEC SP_DISPATCH_GOODS_IN ?,?,?,?,?, ?,?,?,?,?, ?,?', $log_data);  
        
        $contains   =   Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => $sp_result[0]->RESULT]);
        }
        else{
            return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
        }
        exit();   
    }

    public function edit($id=NULL){

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF'); 
        $FormId         =   $this->form_id;
        $ActionStatus   =   "";
        
        if(!is_null($id)){

            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $GSTdata = ['GSTID','GSTCODE','DESCRIPTIONS'];
           
            $HDR            =   DB::select("SELECT 
                                T1.*,
                                FROM TBL_TRN_DISPATCH_GOODS_HDR T1
                                WHERE T1.DGID='$id'
                                ");
                  
            $HDR            =   count($HDR) > 0?$HDR[0]:[];
            $DET            =   DB::select("SELECT * FROM TBL_TRN_DISPATCH_GOODS_DET WHERE DGID_REF='$id'");          

            return view($this->view.'edit',compact(['FormId','objRights','ActionStatus','HDR','DET']));      
        }
     
    }
    
    public function view($id=NULL){

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF'); 
        $FormId         =   $this->form_id;
        $ActionStatus   =   "disabled";
        
        if(!is_null($id)){

            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $GSTdata = ['GSTID','GSTCODE','DESCRIPTIONS'];
            $objGstTypeList       = Helper::getTableData('TBL_MST_GSTTYPE',$GSTdata,NULL, NULL, NULL,'GSTCODE','ASC');

            $HDR            =   DB::select("SELECT 
                                T1.*,
                                CONCAT(T2.CCODE,' - ',T2.NAME) AS CUSTOMER_NAME
                                FROM TBL_TRN_SERVICE_INVOICE_HDR T1
                                LEFT JOIN TBL_MST_CUSTOMER T2 ON T1.CUSTOMER_ID=T2.SLID_REF
                                WHERE T1.DGID='$id'
                                ");
                  
            $HDR            =   count($HDR) > 0?$HDR[0]:[];
            $PKG            =   DB::select("SELECT * FROM TBL_TRN_SERVICE_INVOICE_PKG WHERE SIID_REF='$id'");
            $DIS            =   DB::select("SELECT * FROM TBL_TRN_SERVICE_INVOICE_DIS WHERE SIID_REF='$id'");
            $TAX            =   DB::select("SELECT * FROM TBL_TRN_SERVICE_INVOICE_TAX WHERE SIID_REF='$id'");
            $PAY            =   DB::select("SELECT * FROM TBL_TRN_SERVICE_INVOICE_PAY WHERE SIID_REF='$id'");


            $objUdf         =   $this->getUdf(['VTID_REF'=>$this->vtid_ref]);
            $objtempUdf     =   $objUdf;
            foreach ($objtempUdf as $index => $udfvalue) {

                $objSavedUDF =  DB::table('TBL_TRN_SERVICE_INVOICE_UDF')
                ->where('SIID_REF','=',$id)
                ->where('UDFID_REF','=',$udfvalue->UDFID)
                ->select('UDF_VALUE')
                ->get()->toArray();

                if(!empty($objSavedUDF)){
                    $objUdf[$index]->UDF_VALUE = $objSavedUDF[0]->UDF_VALUE;
                }
                else{
                    $objUdf[$index]->UDF_VALUE = NULL; 
                }
            }
            $objtempUdf     = [];

            return view($this->view.'view',compact(['FormId','objRights','ActionStatus','HDR','PKG','DIS','TAX','PAY','objUdf','objGstTypeList']));      
        }
     
    }

    public function update(Request $request){
 
        $VTID_REF   =   $this->vtid_ref;
        $USERID_REF =   Auth::user()->USERID;   
        $ACTIONNAME =   'EDIT';
        $IPADDRESS  =   $request->getClientIp();
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');

        $REQ_DET    =   array();
        $XML_DET    =   NULL;
        if(isset($_REQUEST['DOCUMENT_TYPE']) && !empty($_REQUEST['DOCUMENT_TYPE'])){
            foreach($_REQUEST['DOCUMENT_TYPE'] as $key=>$val){
                if(trim($_REQUEST['DOCUMENT_TYPE'][$key]) !=''){
                    $REQ_DET[] = array(
                        'DOCUMENT_TYPE'         => trim($_REQUEST['DOCUMENT_TYPE'][$key])?trim($_REQUEST['DOCUMENT_TYPE'][$key]):NULL,
                        'DOCID_REF'             => trim($_REQUEST['DOCUMENTID_REF'][$key])?trim($_REQUEST['DOCUMENTID_REF'][$key]):NULL,
                        'DOCID_DT'              => trim($_REQUEST['DOCUMENT_DT'][$key])?trim($_REQUEST['DOCUMENT_DT'][$key]):NULL,
                        'TRANSPORTID_REF'       => trim($_REQUEST['TRANSPORTERID_REF'][$key])?trim($_REQUEST['TRANSPORTERID_REF'][$key]):NULL,
                        'DOCKET_NO'             => trim($_REQUEST['DOCKET_NO'][$key])?trim($_REQUEST['DOCKET_NO'][$key]):NULL,
                        'DISPATCH_DT'           => trim($_REQUEST['DISPATCH_DT'][$key])?trim($_REQUEST['DISPATCH_DT'][$key]):NULL,
                        'MODE'                  => trim($_REQUEST['MODE'][$key])?trim($_REQUEST['MODE'][$key]):NULL,
                        'REMARKS'               => trim($_REQUEST['REMARKS'][$key])?trim($_REQUEST['REMARKS'][$key]):NULL
                    );
                }
            }  
        }

       
        if(!empty($REQ_DET)){
            $ARR_DET["PAY"] =   $REQ_DET; 
            $XML_DET        =   ArrayToXml::convert($ARR_DET);
        }


       
        

        $DOCID                 =   $request['DOCID'];
        $DOC_NO                 =   $request['DOC_NO'];
        $DOC_DATE               =   $request['DOC_DATE'];
      
       
        $log_data = [
            $DOCID,$DOC_NO,$DOC_DATE,
            $XML_DET,$CYID_REF,$BRID_REF,$FYID_REF,$VTID_REF,
            $USERID_REF,Date('Y-m-d'),Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS
        ];
       
        $sp_result  =   DB::select('EXEC SP_DISPATCH_GOODS_UP ?,?,?,?,?, ?,?,?,?,?, ?,?,?', $log_data); 

        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => $DOC_NO. ' Sucessfully Updated.']);
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
   
        $VTID_REF   =   $this->vtid_ref;
        $USERID_REF = Auth::user()->USERID;   
        $ACTIONNAME = $Approvallevel;
        $IPADDRESS  = $request->getClientIp();
        $CYID_REF   = Auth::user()->CYID_REF;
        $BRID_REF   = Session::get('BRID_REF');
        $FYID_REF   = Session::get('FYID_REF');

        $REQ_DET    =   array();
        $XML_DET    =   NULL;
        if(isset($_REQUEST['DOCUMENT_TYPE']) && !empty($_REQUEST['DOCUMENT_TYPE'])){
            foreach($_REQUEST['DOCUMENT_TYPE'] as $key=>$val){
                if(trim($_REQUEST['DOCUMENT_TYPE'][$key]) !=''){
                    $REQ_DET[] = array(
                        'DOCUMENT_TYPE'         => trim($_REQUEST['DOCUMENT_TYPE'][$key])?trim($_REQUEST['DOCUMENT_TYPE'][$key]):NULL,
                        'DOCID_REF'             => trim($_REQUEST['DOCUMENTID_REF'][$key])?trim($_REQUEST['DOCUMENTID_REF'][$key]):NULL,
                        'DOCID_DT'              => trim($_REQUEST['DOCUMENT_DT'][$key])?trim($_REQUEST['DOCUMENT_DT'][$key]):NULL,
                        'TRANSPORTID_REF'       => trim($_REQUEST['TRANSPORTERID_REF'][$key])?trim($_REQUEST['TRANSPORTERID_REF'][$key]):NULL,
                        'DOCKET_NO'             => trim($_REQUEST['DOCKET_NO'][$key])?trim($_REQUEST['DOCKET_NO'][$key]):NULL,
                        'DISPATCH_DT'           => trim($_REQUEST['DISPATCH_DT'][$key])?trim($_REQUEST['DISPATCH_DT'][$key]):NULL,
                        'MODE'                  => trim($_REQUEST['MODE'][$key])?trim($_REQUEST['MODE'][$key]):NULL,
                        'REMARKS'               => trim($_REQUEST['REMARKS'][$key])?trim($_REQUEST['REMARKS'][$key]):NULL
                    );
                }
            }  
        }

       
        if(!empty($REQ_DET)){
            $ARR_DET["PAY"] =   $REQ_DET; 
            $XML_DET        =   ArrayToXml::convert($ARR_DET);
        }


        $DOCID                  =   $request['DOCID'];
        $DOC_NO                 =   $request['DOC_NO'];
        $DOC_DATE               =   $request['DOC_DATE'];
      
       
        $log_data = [
            $DOCID,$DOC_NO,$DOC_DATE,
            $XML_DET,$CYID_REF,$BRID_REF,$FYID_REF,$VTID_REF,
            $USERID_REF,Date('Y-m-d'),Date('h:i:s.u'),$ACTIONNAME,$IPADDRESS
        ];
       
        $sp_result  =   DB::select('EXEC SP_DISPATCH_GOODS_UP ?,?,?,?,?, ?,?,?,?,?, ?,?,?', $log_data); 

        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
        if($contains){
            return Response::json(['success' =>true,'msg' => $DOC_NO. ' Sucessfully Approved.']);

        }else{
            return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
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
        $TABLE      =   "TBL_TRN_DISPATCH_GOODS_HDR";
        $FIELD      =   "DGID";
        $ID         =   $id;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();

        $req_data[0]=[
            'NT'  => 'TBL_TRN_DISPATCH_GOODS_DET'
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

        $FormId = $this->form_id;
        if(!is_null($id)){
            $objMst =   DB::table("TBL_TRN_DISPATCH_GOODS_HDR")
            ->where('DGID','=',$id)
            ->select('*')
            ->first();        

            $objMstVoucherType  =   DB::table("TBL_MST_VOUCHERTYPE")
            ->where('VTID','=',$this->vtid_ref)
            ->select('VTID','VCODE','DESCRIPTIONS','INDATE')
            ->get()
            ->toArray();
                        
            $objAttachments =   DB::table('TBL_MST_ATTACHMENT')                    
            ->where('TBL_MST_ATTACHMENT.VTID_REF','=',$this->vtid_ref)
            ->where('TBL_MST_ATTACHMENT.ATTACH_DOCNO','=',$id)
            ->where('TBL_MST_ATTACHMENT.CYID_REF','=',Auth::user()->CYID_REF)
            ->where('TBL_MST_ATTACHMENT.BRID_REF','=',Session::get('BRID_REF'))
            ->where('TBL_MST_ATTACHMENT.FYID_REF','=',Session::get('FYID_REF'))
            ->leftJoin('TBL_MST_ATTACHMENT_DET', 'TBL_MST_ATTACHMENT.ATTACHMENTID','=','TBL_MST_ATTACHMENT_DET.ATTACHMENTID_REF')
            ->select('TBL_MST_ATTACHMENT.*', 'TBL_MST_ATTACHMENT_DET.*')
            ->orderBy('TBL_MST_ATTACHMENT.ATTACHMENTID','ASC')
            ->get()->toArray();

            $dirname =   'DispatchGoods';
                
            return view($this->view.'attachment',compact(['FormId','objMst','objMstVoucherType','objAttachments','dirname']));
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
        
		$image_path         =   "docs/company".$CYID_REF."/DispatchGoods";     
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

                    $filenametostore        =  $VTID.$ATTACH_DOCNO.date('YmdHis')."_".str_replace(' ', '', $filenamewithextension);   

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


    
   


    public function getDocument(Request $request){
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');
        $DOCUMENT_TYPE       =   $request['DOCUMENT_TYPE'];  


        if($DOCUMENT_TYPE=='SI'){
        $data   =   DB::select("SELECT DGID AS DOCID,SINO AS DOCNO,SIDT AS DOCDT FROM TBL_TRN_SLSI01_HDR --WHERE CYID_REF=$CYID_REF AND BRID_REF=$BRID_REF --AND FYID_REF=$FYID_REF AND STATUS='A'     
        "); 
        }else if($DOCUMENT_TYPE=='RGP'){
        $data   =   DB::select("SELECT RGPID AS DOCID,RGP_NO AS DOCNO,RGP_DT AS DOCDT FROM TBL_TRN_IRGP01_HDR --WHERE CYID_REF=$CYID_REF AND BRID_REF=$BRID_REF --AND FYID_REF=$FYID_REF AND STATUS='A'   
        "); 
            
        }else if($DOCUMENT_TYPE=='NRGP'){
        $data   =   DB::select("SELECT NRGPID AS DOCID,NRGP_NO AS DOCNO,NRGP_DT AS DOCDT FROM TBL_TRN_NRGP01_HDR --WHERE CYID_REF=$CYID_REF AND BRID_REF=$BRID_REF --AND FYID_REF=$FYID_REF AND STATUS='A'   
        "); 
            
        }

        return Response::json($data);
    }

    public function getTransporterMaster(Request $request){
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');     
        $data           =   DB::select("SELECT TRANSPORTERID AS DOCID,TRANSPORTER_CODE AS DOCNO,TRANSPORTER_NAME AS DOCDT FROM TBL_MST_TRANSPORTER WHERE CYID_REF=$CYID_REF AND STATUS='A' AND (DEACTIVATED=0 OR DEACTIVATED IS NULL)    
        "); 
        
        return Response::json($data);
    }


    
    
     
}
