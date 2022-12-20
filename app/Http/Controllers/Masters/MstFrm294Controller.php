<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\TblMstFrm294;
use DB;
use Response;
use Session;
use Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

use Spatie\ArrayToXml\ArrayToXml;
use Carbon\Carbon;


class MstFrm294Controller extends Controller
{
   
    protected $form_id = 294;
    protected $vtid_ref   = 245;  //voucher type id 236

       
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

        $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

        //dd($objRights);

        $CYID_REF   	=   Auth::user()->CYID_REF;
        $BRID_REF   	=   Session::get('BRID_REF');
        $FYID_REF   	=   Session::get('FYID_REF');     

        $objDataList = DB::table('TBL_MST_ESI_RULE')
            ->where('TBL_MST_ESI_RULE.CYID_REF','=',Auth::user()->CYID_REF)
             ->leftJoin('TBL_MST_YEAR', 'TBL_MST_ESI_RULE.FYID_REF','=','TBL_MST_YEAR.YRID')   
            ->select('TBL_MST_ESI_RULE.*','TBL_MST_YEAR.YRDESCRIPTION')
            ->get();

        return view('masters.Payroll.ESIRules.mstfrm294',compact(['objRights','objDataList']));

    }

    public function add(){ 

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');


        $objYearList = DB::table('TBL_MST_YEAR')
        ->where('STATUS','=','A')
        ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
        ->select('YRID','YRCODE','YRDESCRIPTION')
        ->get();
        
        $obPeriodList = DB::table('TBL_MST_PAY_PERIOD')
        ->select('TBL_MST_PAY_PERIOD.*')
        ->get();

        //dd($obPeriodList);

        $objDataList    =   DB::table('TBL_MST_STATE')->get();
        //dd($objDataList);

        $docarray   =   $this->get_docno_for_master([
            'VTID_REF'=>$this->vtid_ref,
            'CYID_REF'=>Auth::user()->CYID_REF,
            'BRID_REF'=>NULL
        ]);

        return view('masters.Payroll.ESIRules.mstfrm294add',compact(['docarray','objYearList','obPeriodList','objDataList']));
    }
  
    public function getFYearName(Request $request){
        
        $YRID          =   $request['YRID'];
		
		$objFYearName = DB::table('TBL_MST_YEAR')
        ->where('YRID','=', $YRID )
        ->where('STATUS','=','A')
        ->select('YRDESCRIPTION')
        ->first();
		
		if(!empty($objFYearName)){
			echo $objFYearName->YRDESCRIPTION;
		}
		else{
			echo "";
		}
        exit();
    }

   public function codeduplicate(Request $request){

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');
        $ATTCODE =   $request['ATTCODE'];
        
        $objLabel = DB::table('TBL_MST_ATTRIBUTE')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('ATTCODE','=',$ATTCODE)
        ->select('ATTCODE')
        ->first();
        
        if($objLabel){  

            return Response::json(['exists' =>true,'msg' => 'Duplicate record']);
        
        }else{

            return Response::json(['not exists'=>true,'msg' => 'Ok']);
        }
        
        exit();
   }

   public function save(Request $request){    

    $data   =   array();
    if(isset($_REQUEST['FYID_REF']) && !empty($_REQUEST['FYID_REF'])){
        foreach($_REQUEST['FYID_REF'] as $key=>$val){
            $data[] = array(
            'FINANCIALYEAR'     => trim($val),
            'FROMPAYPERIOD'     => trim($_REQUEST['FR_PAYPID_REF'][$key]),
            'TOPAYPERIOD'       => trim($_REQUEST['TO_PAYPID_REF'][$key]),
            'CAPLIMIT'          => trim($_REQUEST['CAP_LIMIT'][$key]),
            'EMPLOYEEESIRATE'   => trim($_REQUEST['EMP_ESI_RATE'][$key]),
            'EMPLOYERESIRATE'   => trim($_REQUEST['EMPR_ESI_RATE'][$key]),
            );
        }
    }

    if(!empty($data)){
        $wrapped_links["ESIRULE"] = $data; 
        $XML = ArrayToXml::convert($wrapped_links);
    }
    else{
        $XML = NULL; 
    }

    $CYID_REF       =   Auth::user()->CYID_REF;
    $BRID_REF       =   Session::get('BRID_REF');
    $FYID_REF       = Session::get('FYID_REF');
    $VTID           =   $this->vtid_ref;
    $USERID         =   Auth::user()->USERID;
    $UPDATE         =   Date('Y-m-d');
    $UPTIME         =   Date('h:i:s.u');
    $ACTION         =   "ADD";
    $IPADDRESS      =   $request->getClientIp();
        
        $array_data   = [
                    $CYID_REF,        $BRID_REF,   $FYID_REF,     $XML, 
                    $VTID,            $USERID,     $UPDATE,        $UPTIME,
                    $ACTION,          $IPADDRESS          
                    ];

            //dd($array_data);

        $sp_result = DB::select('EXEC SP_ESIRULE_INUPDE ?,?,?,?, ?,?,?,?, ?,?', $array_data);

        return Response::json(['success' =>true,'msg' => 'Record successfully inserted.']);
        
        exit();    
    }

    public function edit($id){

        if(!is_null($id))
        {
        
            $USERID     =   Auth::user()->USERID;
            $VTID       =   $this->vtid_ref;
            $CYID_REF   =   Auth::user()->CYID_REF;
            $BRID_REF   =   Session::get('BRID_REF');    
            $FYID_REF   =   Session::get('FYID_REF');

            $sp_user_approval_req = [
                $USERID, $VTID, $CYID_REF, $BRID_REF, $FYID_REF
            ];        

            //get user approval data
            $user_approval_details = DB::select('EXEC SP_APPROVAL_LAVEL ?,?,?,?,?', $sp_user_approval_req);
            $user_approval_level = "APPROVAL".$user_approval_details[0]->LAVELS;

            $objResponse = DB::table('TBL_MST_ESI_RULE')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('ESIRULEID','=',$id)
            ->select('*')
            ->first();         
            if(strtoupper($objResponse->STATUS)=="A" || strtoupper($objResponse->STATUS)=="C"){
                exit("Sorry, Only Un Approved record can edit.");
            }

            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $objDataResponse = DB::table('TBL_MST_ESI_RULE')                    
                             ->where('TBL_MST_ESI_RULE.FYID_REF','=',$id)
                             ->select('TBL_MST_ESI_RULE.*')
                             ->get()->toArray();

            $objCount = count($objDataResponse);

            $obPeriodList = DB::table('TBL_MST_PAY_PERIOD')
                ->select('TBL_MST_PAY_PERIOD.*')
                ->get();

            $objFyDesList = DB::table('TBL_MST_ESI_RULE')
            ->where('TBL_MST_ESI_RULE.ESIRULEID','=',$id)
             ->leftJoin('TBL_MST_YEAR', 'TBL_MST_ESI_RULE.FYID_REF','=','TBL_MST_YEAR.YRID')   
            ->select('TBL_MST_ESI_RULE.*','TBL_MST_YEAR.YRDESCRIPTION')
            ->first();

                $objYearList = DB::table('TBL_MST_YEAR')
                ->where('STATUS','=','A')
                ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
                ->select('YRID','YRCODE','YRDESCRIPTION')
                ->get();
    
            $objDataList    =   DB::table('TBL_MST_STATE')
                
                ->get();

            return view('masters.Payroll.ESIRules.mstfrm294edit',compact(['objResponse','objYearList','obPeriodList','objFyDesList','objDataList','user_approval_level','objRights','objDataResponse','objCount']));
        }

    }

     
    public function update(Request $request) {    

      $data = array();
      if(isset($_REQUEST['FYID_REF']) && !empty($_REQUEST['FYID_REF'])){
          foreach($_REQUEST['FYID_REF'] as $key=>$val){

            $data[] = array(
                'FINANCIALYEAR'     => trim($val),
                'FROMPAYPERIOD'     => trim($_REQUEST['FR_PAYPID_REF'][$key]),
                'TOPAYPERIOD'       => trim($_REQUEST['TO_PAYPID_REF'][$key]),
                'CAPLIMIT'          => trim($_REQUEST['CAP_LIMIT'][$key]),
                'EMPLOYEEESIRATE'   => trim($_REQUEST['EMP_ESI_RATE'][$key]),
                'EMPLOYERESIRATE'   => trim($_REQUEST['EMPR_ESI_RATE'][$key]),
                //'DEACTIVATED'   => trim($_REQUEST['DEACTIVATED'][$key]),
                //'DODEACTIVATED'   => trim($_REQUEST['DODEACTIVATED'][$key]),
            );
          }
      }
      
      //dd($data);

      if(!empty($data)){
        $wrapped_links["ESIRULE"] = $data; 
        $XML = ArrayToXml::convert($wrapped_links);
      }
      else{
        $XML = NULL;

      }        

        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');
        $VTID     =   $this->vtid_ref;
        $USERID     =   Auth::user()->USERID;
        $UPDATE     =   Date('Y-m-d');
        
        $UPTIME     =   Date('h:i:s.u');
        $ACTION     =   "EDIT";
        $IPADDRESS  =   $request->getClientIp();
        
        $array_data   = [
            $CYID_REF,        $BRID_REF,   $FYID_REF,     $XML, 
            $VTID,            $USERID,     $UPDATE,        $UPTIME,
            $ACTION,          $IPADDRESS          
            ];

    //dd($array_data);

        $sp_result = DB::select('EXEC SP_ESIRULE_INUPDE ?,?,?,?, ?,?,?,?, ?,?', $array_data);

        return Response::json(['success' =>true,'msg' => 'Record successfully updated.']);
        
        exit();            
    } 

    //uploads attachments files
    public function docuploads(Request $request){

        $formData = $request->all();

        $allow_extnesions = explode(",",config("erpconst.attachments.allow_extensions"));
        $allow_size = config("erpconst.attachments.max_size") * 1020 * 1024;

        //echo '<br> c='."--".Config("erpconst.attachments.max_size");
        
        //get data
        $VTID           =   $formData["VTID_REF"]; 
        $ATTACH_DOCNO   =   $formData["ATTACH_DOCNO"]; 
        $ATTACH_DOCDT   =   $formData["ATTACH_DOCDT"]; 
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');       
        // @XML	xml
        $USERID         =   Auth::user()->USERID;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "ADD";
        $IPADDRESS      =   $request->getClientIp();
 
		$destinationPath = storage_path()."/docs/company".$CYID_REF."/ESIRules";

        if ( !is_dir($destinationPath) ) {
            mkdir($destinationPath, 0777, true);
        }

        $uploaded_data = [];
        $invlid_files = "";

        $duplicate_files="";

        foreach($formData["REMARKS"] as $index=>$row_val){

                if(isset($formData["FILENAME"][$index])){

                    $uploadedFile = $formData["FILENAME"][$index]; 
                    
                    //$filenamewithextension  = $formData["FILENAME"][$index]->getClientOriginalName();

                    $filenamewithextension  =   $uploadedFile ->getClientOriginalName();
                    $filesize               =   $uploadedFile ->getSize();  
                    $extension              =   strtolower( $uploadedFile ->getClientOriginalExtension() );

                    //$filenametostore        =   $filenamewithextension; 

                    $filenametostore        =  $VTID.$ATTACH_DOCNO.$USERID.$CYID_REF.$BRID_REF.$FYID_REF."#_".$filenamewithextension;  

                    if ($uploadedFile->isValid()) {

                        if(in_array($extension,$allow_extnesions)){
                            
                            if($filesize < $allow_size){

                                $filename = $destinationPath."/".$filenametostore;

                                if (!file_exists($filename)) {

                                   $uploadedFile->move($destinationPath, $filenametostore);  //upload in dir if not exists
                                   $uploaded_data[$index]["FILENAME"] =$filenametostore;
                                   $uploaded_data[$index]["LOCATION"] = $destinationPath."/";
                                   $uploaded_data[$index]["REMARKS"] = is_null($row_val) ? '' : trim($row_val);

                                }else{

                                    $duplicate_files = " ". $duplicate_files.$filenamewithextension. " ";
                                }
                                

                                
                            }else{
                                
                                $invlid_files = $invlid_files.$filenamewithextension." (invalid size)  "; 
                            } //invalid size
                            
                        }else{

                            $invlid_files = $invlid_files.$filenamewithextension." (invalid extension)  ";                             
                        }// invalid extension
                    
                    }else{
                            
                        $invlid_files = $invlid_files.$filenamewithextension." (invalid)"; 
                    }//invalid

                }

        }//foreach

      
        if(empty($uploaded_data)){
            return redirect()->route("master",[294,"attachment",$ATTACH_DOCNO])->with("success","No file uploaded");
        }
     //  dd($uploaded_data);

        $wrapped_links["ATTACHMENT"] = $uploaded_data;     //root node: <ATTACHMENT>
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
       
             //save data
             $sp_result = DB::select('EXEC SP_ATTACHMENT_IN ?,?,?,?, ?,?,?,?, ?,?,?,?', $attachment_data);
     
        if($sp_result[0]->RESULT=="SUCCESS"){

            if(trim($duplicate_files!="")){
                $duplicate_files =  " System ignored duplicated files -  ".$duplicate_files;
            }

            if(trim($invlid_files!="")){
                $invlid_files =  " Invalid files -  ".$invlid_files;
            }

            return redirect()->route("master",[294,"attachment",$ATTACH_DOCNO])->with("success","Files successfully attached. ".$duplicate_files.$invlid_files);


        }        elseif($sp_result[0]->RESULT=="Duplicate file for same records"){
       
            return redirect()->route("master",[294,"attachment",$ATTACH_DOCNO])->with("success","Duplicate file name. ".$invlid_files);
    
        }else{

            //return redirect()->route("master",[294,"attachment",$ATTACH_DOCNO])->with("error","There is some data error. Please try after sometime.  ");
            return redirect()->route("master",[294,"attachment",$ATTACH_DOCNO])->with($sp_result[0]->RESULT);
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

        if(!empty($sp_listing_result))
            {
                foreach ($sp_listing_result as $key=>$salesenquiryitem)
            {  
                $record_status = 0;
                $Approvallevel = "APPROVAL".$salesenquiryitem->LAVELS;
            }
            }
           

    $data = array();
      if(isset($_REQUEST['FYID_REF']) && !empty($_REQUEST['FYID_REF'])){
          foreach($_REQUEST['FYID_REF'] as $key=>$val){

            $data[] = array(
                'FINANCIALYEAR'     => trim($val),
                'FROMPAYPERIOD'     => trim($_REQUEST['FR_PAYPID_REF'][$key]),
                'TOPAYPERIOD'       => trim($_REQUEST['TO_PAYPID_REF'][$key]),
                'CAPLIMIT'          => trim($_REQUEST['CAP_LIMIT'][$key]),
                'EMPLOYEEESIRATE'   => trim($_REQUEST['EMP_ESI_RATE'][$key]),
                'EMPLOYERESIRATE'   => trim($_REQUEST['EMPR_ESI_RATE'][$key]),
            );
          }
      }

      //dd($data);

      if(!empty($data)){
        $wrapped_links["ESIRULE"] = $data; 
        $XML = ArrayToXml::convert($wrapped_links);
      }
      else{
        $XML = NULL;

      }           

       $wrapped_links["ESIRULE"] = $data; 
       $XML = ArrayToXml::convert($wrapped_links);    
        $DEACTIVATED = (isset($request['DEACTIVATED']) )? 1 : 0 ;
       
        $newDateString = NULL;

        $newdt = !(is_null($request['DODEACTIVATED']) ||empty($request['DODEACTIVATED']) )=="true" ? $request['DODEACTIVATED'] : NULL; 

        if(!is_null($newdt) ){
            
            $newdt = str_replace( "/", "-",  $newdt ) ;

            $newDateString = Carbon::parse($newdt)->format('Y-m-d');        
        }
        

        $DODEACTIVATED = $newDateString;

        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF'); 
        $VTID     =   $this->vtid_ref;
        $USERID     =   Auth::user()->USERID;
        $UPDATE     =   Date('Y-m-d');
        
        $UPTIME     =   Date('h:i:s.u');
        $ACTION = $Approvallevel;
        $IPADDRESS  =   $request->getClientIp();
        
        $array_data   = [
            $CYID_REF,        $BRID_REF,   $FYID_REF,     $XML, 
            $VTID,            $USERID,     $UPDATE,        $UPTIME,
            $ACTION,          $IPADDRESS          
            ];

    //dd($array_data);

        $sp_result = DB::select('EXEC SP_ESIRULE_INUPDE ?,?,?,?, ?,?,?,?, ?,?', $array_data);

        return Response::json(['success' =>true,'msg' => 'Record successfully Approved.']);               

        exit();     
    }

    public function view($id){

        if(!is_null($id))
        {
            $objResponse = DB::table('TBL_MST_ESI_RULE')->where('ESIRULEID','=',$id)->select('*')->first();

            $objDataResponse = DB::table('TBL_MST_LABOUR_WELFAREFUND_SLAB_DET')                    
            ->where('TBL_MST_LABOUR_WELFAREFUND_SLAB_DET.LWFSLABID_REF','=',$id)
            ->select('TBL_MST_LABOUR_WELFAREFUND_SLAB_DET.*')
            ->get()->toArray();

            $objCount = count($objDataResponse);

            $objYearList = DB::table('TBL_MST_YEAR')
            ->where('STATUS','=','A')
            ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
            ->select('YRID','YRCODE','YRDESCRIPTION')
            ->get();

            $obPeriodList = DB::table('TBL_MST_PAY_PERIOD')
                ->select('TBL_MST_PAY_PERIOD.*')
                ->get();
    
            $objDataList    =   DB::table('TBL_MST_STATE')
                
                ->get();

                $objFyDesList = DB::table('TBL_MST_ESI_RULE')
                    ->where('TBL_MST_ESI_RULE.ESIRULEID','=',$id)
                    ->leftJoin('TBL_MST_YEAR', 'TBL_MST_ESI_RULE.FYID_REF','=','TBL_MST_YEAR.YRID')   
                    ->select('TBL_MST_ESI_RULE.*','TBL_MST_YEAR.YRDESCRIPTION')
                    ->first();

            return view('masters.Payroll.ESIRules.mstfrm294view',compact(['objResponse','objDataResponse','obPeriodList','objFyDesList','objYearList','objDataList','objCount']));
        }

    }
  
    public function printdata(Request $request){
        //
        $ids_data = [];
        if(isset($request->records_ids)){
            
            $ids_data = explode(",",$request->records_ids);
        }

        $objResponse = TblMstFrm294::whereIn('ATTID',$ids_data)->get();
        
        return view('masters.Payroll.ESIRules.mstfrm294print',compact(['objResponse']));
   }//print

    
    //display attachments form
    public function attachment($id){

        if(!is_null($id))
        {
            //EXEC [SP_APPROVAL_LAVEL] 2,114,6,4,2
            $objResponse = DB::table('TBL_MST_ESI_RULE')->where('ESIRULEID','=',$id)->select('*')->first();

            //select * from TBL_MST_VOUCHERTYPE where VTID=114

            $objMstVoucherType = DB::table("TBL_MST_VOUCHERTYPE")
                    ->where('VTID','=',$this->vtid_ref)
                     ->select('VTID','VCODE','DESCRIPTIONS')
                    ->get()
                    ->toArray();

            
                    //uplaoded docs
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

                 // dump( $objAttachments);

            return view('masters.Payroll.ESIRules.mstfrm294attachment',compact(['objResponse','objMstVoucherType','objAttachments']));
        }

    }
          
    public function cancel(Request $request){

        $id = $request->{0};

        $objResponse = DB::table('TBL_MST_ESI_RULE')->where('ESIRULEID','=',$id)->select('*')->first();
        $FYIDREF = $objResponse->FYID_REF;

        //dd($FYIDREF);

        $USERID =   Auth::user()->USERID;
        $VTID   =   $this->vtid_ref;  //voucher type id
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   $FYIDREF;       
        $TABLE      =   "TBL_MST_ESI_RULE";
        $FIELD      =   "ESIRULEID";
        $ID         =   $id;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();

        $req_data[0]=[
            'NT'  => 'TBL_MST_ESI_RULE',
        ];
    
        $wrapped_links["TABLES"] = $req_data; 
        
        $XMLTAB = ArrayToXml::convert($wrapped_links);
        
        $mst_cancel_data = [ $USERID, $VTID, $TABLE, $FIELD, $ID, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS ,$XMLTAB];
        
        $sp_result = DB::select('EXEC SP_MST_CANCEL  ?,?,?,?, ?,?,?,?, ?,?,?,?', $mst_cancel_data);
           
        //dd($sp_result);

        if($sp_result[0]->RESULT=="CANCELED"){  
          
          return Response::json(['cancel' =>true,'msg' => 'Record successfully canceled.']);
        
        }elseif($sp_result[0]->RESULT=="NO RECORD FOR CANCEL"){
        
            
            return Response::json(['errors'=>true,'msg' => 'No record found.','norecord'=>'norecord']);
            
        }else{
           
               return Response::json(['errors'=>true,'msg' => 'Error:'.$sp_result[0]->RESULT,'invalid'=>'invalid']);
        }
        
        exit(); 


   }

   


}
