<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Models\Master\TblMstFrm228;
use DB;
use Response;
use Auth;
use Session;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

use Spatie\ArrayToXml\ArrayToXml;
use Carbon\Carbon;


class MstFrm228Controller extends Controller
{
   
    protected $form_id = 228;
    protected $vtid_ref   = 183;  //voucher type id

    
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

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Auth::user()->BRID_REF;
        $FYID_REF       =   Auth::user()->FYID_REF;

        $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

        //dump($objRights);
        
        $objDataList = DB::table('TBL_MST_MACHINE_CHECKLIST')
            ->where('TBL_MST_MACHINE_CHECKLIST.CYID_REF','=',Auth::user()->CYID_REF)
            ->leftJoin('TBL_MST_MACHINE',   'TBL_MST_MACHINE.MACHINEID','=',   'TBL_MST_MACHINE_CHECKLIST.MACHINEID_REF')
            ->leftJoin('TBL_MST_MAINTENANCE_CHECKLIST',   'TBL_MST_MAINTENANCE_CHECKLIST.CKLISTID','=',   'TBL_MST_MACHINE_CHECKLIST.CKLISTID_REF')
            ->select('TBL_MST_MACHINE_CHECKLIST.*', 'TBL_MST_MACHINE.MACHINEID','TBL_MST_MACHINE.MACHINE_NO','TBL_MST_MACHINE.MACHINE_DESC','TBL_MST_MAINTENANCE_CHECKLIST.CKLISTID','TBL_MST_MAINTENANCE_CHECKLIST.CHECKLIST_NO','TBL_MST_MAINTENANCE_CHECKLIST.CHECKLIST_DESC')
            ->orderBy('TBL_MST_MACHINE_CHECKLIST.MCKLISTID', 'ASC')
            ->get();    

        // $objDataList = DB::table('TBL_MST_MAINTENANCE_CHECKLIST')
        //     ->where('TBL_MST_MAINTENANCE_CHECKLIST.CYID_REF','=',Auth::user()->CYID_REF)
        //     ->select('*')
        //     ->orderBy('TBL_MST_MAINTENANCE_CHECKLIST.CHECKLIST_NO', 'ASC')
        //     ->get();        

        ///dump($objDataList);

        return view('masters.PlantMaintenance.MachineWiseChecklist.mstfrm228',compact(['objRights','objDataList']));

    }

      
    public function add(){ 

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Auth::user()->BRID_REF;

        return view('masters.PlantMaintenance.MachineWiseChecklist.mstfrm228add');   
    }


   public function save(Request $request){

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Auth::user()->BRID_REF;
        $FYID_REF       =   Auth::user()->FYID_REF;       
        $VTID           =   $this->vtid_ref;

        $MACHINEID_REF = trim($request['MACHINEID_REF']);
        $CKLISTID_REF = trim($request['CHECKLIST_REF']);

       // dd($request->all());
        
        $objLabel = DB::table('TBL_MST_MACHINE_CHECKLIST')
                ->where('CYID_REF','=',Auth::user()->CYID_REF)
                ->where('MACHINEID_REF','=',$MACHINEID_REF)
                ->where('CKLISTID_REF','=',$CKLISTID_REF)
                ->select('MCKLISTID')
                ->first();
        
        if($objLabel){  

            return Response::json(['errors' =>true,'msg' => 'Duplicate record. Machine No and Checklist No Already exists.','save'=>'invalid']);
            
        
        }

        $data     =array();
        $existData=array();
        $r_count = $request['Row_Count'];


        for ($i=0; $i<=$r_count; $i++){

            if((isset($request['FORMID_'.$i]) && $request['FORMID_'.$i] !="")){

                $idval = trim($request['FORMID_'.$i]);
                $vtypeval = trim($request['LISTPOP1ID_'.$i]);
                $stdval= trim($request['STANDARD_VAL_'.$i]);

                $data[$i] = [
                    'MPID_REF' => $idval,
                    'MSPID_REF' =>  $vtypeval,
                    'VALUE' =>   $stdval,
                    'DEACTIVATED' => 0,
                    'DATE' =>NULL,
                ];

                $existData[$i]=strtoupper($idval.'-'.$vtypeval);

            }
        }

        if(!empty($existData)){
            $counts     = array_count_values($existData);
            $NumVal     = max($counts);

            if( $NumVal > 1){
                return Response::json(['errors'=>true,'msg' => 'Duplicate row. Please check.','save'=>'invalid']);
            }
        }

        
        if(!empty($data)){ 
            $wrapped_links["MACHINECHECKLIST"] = $data; 
            $xml = ArrayToXml::convert($wrapped_links);
        }
        else{
            $xml = NULL; 
        }  

       
        $DEACTIVATED    =   0;  
        $DODEACTIVATED  =   NULL;  
        $USERID         =   Auth::user()->USERID;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "ADD";
        $IPADDRESS      =   $request->getClientIp();


        $array_data   = [  
                        $MACHINEID_REF,  $CKLISTID_REF, $DEACTIVATED,   $DODEACTIVATED, $xml,
                        $CYID_REF,       $BRID_REF,     $FYID_REF,      $VTID,      $USERID,
                        $UPDATE,         $UPTIME,       $ACTION,        $IPADDRESS
                    ];
       
       try {

            $sp_result = DB::select('EXEC SP_MACHINE_CHECKLIST_IN ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?', $array_data);
       
        
          } catch (\Throwable $th) {
          
               return Response::json(['errors'=>true,'msg' => 'There is some data error. Please try after sometime.','save'=>'invalid']);

          }
    
        if($sp_result[0]->RESULT=="SUCCESS"){

            return Response::json(['success' =>true,'msg' => 'Record successfully inserted.']);

        }elseif($sp_result[0]->RESULT=="DUPLICATE RECORD"){
        
            return Response::json(['errors'=>true,'msg' => 'Duplicate record.','exist'=>'duplicate']);
            
        }else{

            return Response::json(['errors'=>true,'msg' => 'There is some data error. Please try after sometime.','save'=>'invalid']);
        }
        
        exit();    
    }



    public function edit($id){

        if(!is_null($id))
        {
        
            $USERID     =   Auth::user()->USERID;
            $VTID       =   $this->vtid_ref;
            $CYID_REF   =   Auth::user()->CYID_REF;
            $BRID_REF   =   Auth::user()->BRID_REF;    
            $FYID_REF   =   Auth::user()->FYID_REF;

            $sp_user_approval_req = [
                $USERID, $VTID, $CYID_REF, $BRID_REF, $FYID_REF
            ];        

            //get user approval data
            $user_approval_details = DB::select('EXEC SP_APPROVAL_LAVEL ?,?,?,?,?', $sp_user_approval_req);
            $user_approval_level = "APPROVAL".$user_approval_details[0]->LAVELS;


            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $objMstHeader = DB::table('TBL_MST_MACHINE_CHECKLIST')
                ->where('CYID_REF','=',Auth::user()->CYID_REF)
                ->where('MCKLISTID','=',$id)
                ->select('*')
                ->first();

            if(!empty($objMstHeader)){
                if(trim($objMstHeader->STATUS) !='N'){
                    exit('Error: "Not Approved" record can only be edited.');
                }
            }          
           

           $objMachineNo = DB::table('TBL_MST_MACHINE')
                        ->where('CYID_REF','=',Auth::user()->CYID_REF)
                        ->where('MACHINEID','=',$objMstHeader->MACHINEID_REF )
                        ->select('MACHINEID','MACHINE_NO','MACHINE_DESC')
                        ->first();
            
         

           $objChecklistNo = DB::table('TBL_MST_MAINTENANCE_CHECKLIST')
                        ->where('CYID_REF','=',Auth::user()->CYID_REF)
                        ->where('CKLISTID','=',$objMstHeader->CKLISTID_REF )
                        ->select('*')
                        ->first();
            

            $objResponse = DB::table('TBL_MST_MACHINE_CHECKLIST_DETAILS')
                ->where('TBL_MST_MACHINE_CHECKLIST_DETAILS.MCKLISTID_REF','=',$id)
                ->leftJoin('TBL_MST_MAINTENANCE_PARAMETER',   'TBL_MST_MAINTENANCE_PARAMETER.MPID','=',   'TBL_MST_MACHINE_CHECKLIST_DETAILS.MPID_REF')
                ->leftJoin('TBL_MST_MAINTENANCE_SUB_PARAMETER',   'TBL_MST_MAINTENANCE_SUB_PARAMETER.MSPID','=',   'TBL_MST_MACHINE_CHECKLIST_DETAILS.MSPID_REF')
                ->select('TBL_MST_MACHINE_CHECKLIST_DETAILS.*', 
                'TBL_MST_MAINTENANCE_PARAMETER.MPID','TBL_MST_MAINTENANCE_PARAMETER.MP_CODE','TBL_MST_MAINTENANCE_PARAMETER.MP_DESC',               'TBL_MST_MAINTENANCE_SUB_PARAMETER.MSPID','TBL_MST_MAINTENANCE_SUB_PARAMETER.MSP_CODE','TBL_MST_MAINTENANCE_SUB_PARAMETER.MSP_DESC')
                ->orderBy('TBL_MST_MACHINE_CHECKLIST_DETAILS.MCKLIST_DID', 'ASC')
                ->get();    

            $objCount = count($objResponse);

            return view('masters.PlantMaintenance.MachineWiseChecklist.mstfrm228edit',compact(['objResponse','user_approval_level','objRights','objMstHeader','objCount','objMachineNo','objChecklistNo']));
        }

    }

     
    public function update(Request $request)
    {

        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Auth::user()->BRID_REF;
        $FYID_REF   =   Auth::user()->FYID_REF;       
        $VTID     =   $this->vtid_ref;
        $USERID     =   Auth::user()->USERID;
        $UPDATE     =   Date('Y-m-d');
        
        $UPTIME     =   Date('h:i:s.u');
        $ACTION     =   "EDIT";
        $IPADDRESS  =   $request->getClientIp();

        $MACHINEID_REF = trim($request['MACHINEID_REF']);
        $CKLISTID_REF = trim($request['CHECKLIST_REF']);
        
        $data     =array();
        $existData=array();
        $r_count = $request['Row_Count'];

        for ($i=0; $i<=$r_count; $i++){

            if((isset($request['FORMID_'.$i]) && $request['FORMID_'.$i] !="")){

                $idval = trim($request['FORMID_'.$i]);
                $vtypeval = trim($request['LISTPOP1ID_'.$i]);
                $stdval= trim($request['STANDARD_VAL_'.$i]);

                $MCKLIST_DID = (isset($request['MCKLIST_DID_'.$i]) &&  trim($request['MCKLIST_DID_'.$i])!="" )? $request['MCKLIST_DID_'.$i] : 0 ;
                
                $data[$i] = [
                    'MPID_REF' => $idval,
                    'MSPID_REF' =>  $vtypeval ,
                    'VALUE' =>   $stdval
                ];

                $existData[$i]=strtoupper($idval.'-'.$vtypeval);

            }
        }

        if(!empty($existData)){
            $counts     = array_count_values($existData);
            $NumVal     = max($counts);

            if( $NumVal > 1){
                return Response::json(['errors'=>true,'msg' => 'Duplicate row. Please check.','save'=>'invalid']);
            }
        }
        
        
        if(!empty($data)){ 
            $wrapped_links["MACHINECHECKLIST"] = $data; 
            $xml = ArrayToXml::convert($wrapped_links);
        }
        else{
            $xml = NULL; 
        }  
       
        $HDR_DEACTIVATED = (isset($request['HDR_DEACTIVATED']) )? 1 : 0 ;
       
        $newDateString5 = NULL;
        $newdt5 = !(is_null($request['HDR_DODEACTIVATED']) ||empty($request['HDR_DODEACTIVATED']) )=="true" ? $request['HDR_DODEACTIVATED'] : NULL; 

        if(!is_null($newdt5) ){
            
            $newdt5 = str_replace( "/", "-",  $newdt5 ) ;
            $newDateString5 = Carbon::parse($newdt5)->format('Y-m-d');        
        }
        $HDR_DODEACTIVATED = $newDateString5;

        $array_data   = [  
            $MACHINEID_REF,  $CKLISTID_REF, $HDR_DEACTIVATED,   $HDR_DODEACTIVATED,   $xml,
            $CYID_REF,       $BRID_REF,     $FYID_REF,          $VTID,                $USERID,
            $UPDATE,         $UPTIME,       $ACTION,            $IPADDRESS
        ];

      
      
        try {

            $sp_result = DB::select('EXEC SP_MACHINE_CHECKLIST_UP ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?', $array_data);
    
        
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
        $BRID_REF       =   Auth::user()->BRID_REF;
        $FYID_REF       =   Auth::user()->FYID_REF;       
        // @XML	xml
        $USERID         =   Auth::user()->USERID;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "ADD";
        $IPADDRESS      =   $request->getClientIp();
        
        $destinationPath = storage_path()."/docs/company".$CYID_REF."/MachineWiseChecklist";

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
            return redirect()->route("master",[228,"attachment",$ATTACH_DOCNO])->with("success","The file is already exist");
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

            return redirect()->route("master",[228,"attachment",$ATTACH_DOCNO])->with("success","Files successfully attached. ".$duplicate_files.$invlid_files);


        }        elseif($sp_result[0]->RESULT=="Duplicate file for same records"){
       
            return redirect()->route("master",[228,"attachment",$ATTACH_DOCNO])->with("success","Duplicate file name. ".$invlid_files);
    
        }else{

            //return redirect()->route("master",[228,"attachment",$ATTACH_DOCNO])->with("error","There is some data error. Please try after sometime.  ");
            return redirect()->route("master",[228,"attachment",$ATTACH_DOCNO])->with($sp_result[0]->RESULT);
        }
      
      
        
    }   

  
    //singleApprove begin
    public function singleapprove(Request $request)
    {
      
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Auth::user()->BRID_REF;
        $FYID_REF   =   Auth::user()->FYID_REF;       
        $VTID     =   $this->vtid_ref;
        $USERID     =   Auth::user()->USERID;
        $UPDATE     =   Date('Y-m-d');
        
        $UPTIME     =   Date('h:i:s.u');
        $ACTION     =   trim($request['user_approval_level']);   // user approval level value
        $IPADDRESS  =   $request->getClientIp();

        $MACHINEID_REF = trim($request['MACHINEID_REF']);
        $CKLISTID_REF = trim($request['CHECKLIST_REF']);
        
        $data     =array();
        $existData=array();
        $r_count = $request['Row_Count'];

        for ($i=0; $i<=$r_count; $i++){

            if((isset($request['FORMID_'.$i]) && $request['FORMID_'.$i] !="")){

                $idval = trim($request['FORMID_'.$i]);
                $vtypeval = trim($request['LISTPOP1ID_'.$i]);
                $stdval= trim($request['STANDARD_VAL_'.$i]);

                //$CKLID = (isset($request['CKLID_'.$i]) &&  trim($request['CKLID_'.$i])!="" )? $request['CKLID_'.$i] : 0 ;
                
                $DEACTIVATED = (isset($request['DEACTIVATED_'.$i]) )? 1 : 0 ;
                
                $data[$i] = [
                    'MPID_REF' => $idval,
                    'MSPID_REF' =>  $vtypeval ,
                    'VALUE' =>   $stdval
                ];

                $existData[$i]=strtoupper($idval.'-'.$vtypeval);

            }
        }

        if(!empty($existData)){
            $counts     = array_count_values($existData);
            $NumVal     = max($counts);

            if( $NumVal > 1){
                return Response::json(['errors'=>true,'msg' => 'Duplicate row. Please check.','save'=>'invalid']);
            }
        }
        
        
        if(!empty($data)){ 
            $wrapped_links["MACHINECHECKLIST"] = $data; 
            $xml = ArrayToXml::convert($wrapped_links);
        }
        else{
            $xml = NULL; 
        }  
       
        $HDR_DEACTIVATED = (isset($request['HDR_DEACTIVATED']) )? 1 : 0 ;
       
        $newDateString5 = NULL;
        $newdt5 = !(is_null($request['HDR_DODEACTIVATED']) ||empty($request['HDR_DODEACTIVATED']) )=="true" ? $request['HDR_DODEACTIVATED'] : NULL; 

        if(!is_null($newdt5) ){
            
            $newdt5 = str_replace( "/", "-",  $newdt5 ) ;
            $newDateString5 = Carbon::parse($newdt5)->format('Y-m-d');        
        }
        $HDR_DODEACTIVATED = $newDateString5;

        $array_data   = [  
            $MACHINEID_REF,  $CKLISTID_REF, $HDR_DEACTIVATED,   $HDR_DODEACTIVATED,   $xml,
            $CYID_REF,       $BRID_REF,     $FYID_REF,          $VTID,                $USERID,
            $UPDATE,         $UPTIME,       $ACTION,            $IPADDRESS
        ];

     
      
        try {

            $sp_result = DB::select('EXEC SP_MACHINE_CHECKLIST_UP ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?', $array_data);
     
        } catch (\Throwable $th) {

            return Response::json(['errors'=>true,'msg' => 'Error:'.$sp_result[0]->RESULT,'save'=>'invalid']);

        }    
                    
        if($sp_result[0]->RESULT=="SUCCESS"){  
 
             return Response::json(['success' =>true,'msg' => 'Record successfully approved.']);
         
         }elseif($sp_result[0]->RESULT=="NO RECORD FOUND"){
         
             return Response::json(['errors'=>true,'msg' => 'No record found.','exist'=>'norecord']);
             
         }else{
 
             return Response::json(['errors'=>true,'msg' => 'Error:'.$sp_result[0]->RESULT,'save'=>'invalid']);
         }
         
         exit();  

     }  //singleApprove end


    public function view($id){

        if(!is_null($id))
        {
        
            $USERID     =   Auth::user()->USERID;
            $VTID       =   $this->vtid_ref;
            $CYID_REF   =   Auth::user()->CYID_REF;
            $BRID_REF   =   Auth::user()->BRID_REF;    
            $FYID_REF   =   Auth::user()->FYID_REF;

            $sp_user_approval_req = [
                $USERID, $VTID, $CYID_REF, $BRID_REF, $FYID_REF
            ];        

            //get user approval data
            $user_approval_details = DB::select('EXEC SP_APPROVAL_LAVEL ?,?,?,?,?', $sp_user_approval_req);
            $user_approval_level = "APPROVAL".$user_approval_details[0]->LAVELS;


            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $objMstHeader = DB::table('TBL_MST_MACHINE_CHECKLIST')
                ->where('CYID_REF','=',Auth::user()->CYID_REF)
                ->where('MCKLISTID','=',$id)
                ->select('*')
                ->first();


           $objMachineNo = DB::table('TBL_MST_MACHINE')
                        ->where('CYID_REF','=',Auth::user()->CYID_REF)
                        ->where('MACHINEID','=',$objMstHeader->MACHINEID_REF )
                        ->select('MACHINEID','MACHINE_NO','MACHINE_DESC')
                        ->first();
            
         

           $objChecklistNo = DB::table('TBL_MST_MAINTENANCE_CHECKLIST')
                        ->where('CYID_REF','=',Auth::user()->CYID_REF)
                        ->where('CKLISTID','=',$objMstHeader->CKLISTID_REF )
                        ->select('*')
                        ->first();
            

            $objResponse = DB::table('TBL_MST_MACHINE_CHECKLIST_DETAILS')
                ->where('TBL_MST_MACHINE_CHECKLIST_DETAILS.MCKLISTID_REF','=',$id)
                ->leftJoin('TBL_MST_MAINTENANCE_PARAMETER',   'TBL_MST_MAINTENANCE_PARAMETER.MPID','=',   'TBL_MST_MACHINE_CHECKLIST_DETAILS.MPID_REF')
                ->leftJoin('TBL_MST_MAINTENANCE_SUB_PARAMETER',   'TBL_MST_MAINTENANCE_SUB_PARAMETER.MSPID','=',   'TBL_MST_MACHINE_CHECKLIST_DETAILS.MSPID_REF')
                ->select('TBL_MST_MACHINE_CHECKLIST_DETAILS.*', 
                'TBL_MST_MAINTENANCE_PARAMETER.MPID','TBL_MST_MAINTENANCE_PARAMETER.MP_CODE','TBL_MST_MAINTENANCE_PARAMETER.MP_DESC',               'TBL_MST_MAINTENANCE_SUB_PARAMETER.MSPID','TBL_MST_MAINTENANCE_SUB_PARAMETER.MSP_CODE','TBL_MST_MAINTENANCE_SUB_PARAMETER.MSP_DESC')
                ->orderBy('TBL_MST_MACHINE_CHECKLIST_DETAILS.MCKLIST_DID', 'ASC')
                ->get();    

            $objCount = count($objResponse);

            return view('masters.PlantMaintenance.MachineWiseChecklist.mstfrm228view',compact(['objResponse','user_approval_level','objRights','objMstHeader','objCount','objMachineNo','objChecklistNo']));
        }

    }
  
    public function printdata(Request $request){
        //
        // $ids_data = [];
        // if(isset($request->records_ids)){
            
        //     $ids_data = explode(",",$request->records_ids);
        // }

        // $objResponse = TblMstFrm228::whereIn('ITEMGID',$ids_data)->get();
        
        // return view('masters.PlantMaintenance.MachineWiseChecklist.mstfrm228print',compact(['objResponse']));
   }//print


   
    

    
    //display attachments form
    public function attachment($id){

        if(!is_null($id))
        {
            //EXEC [SP_APPROVAL_LAVEL] 2,114,6,4,2
            $objResponse = DB::table('TBL_MST_MACHINE_CHECKLIST')
                ->where('CYID_REF','=',Auth::user()->CYID_REF)
                ->where('MCKLISTID','=',$id)
                ->select('*')
                ->first();

            
           $objMachineNo = DB::table('TBL_MST_MACHINE')
           ->where('CYID_REF','=',Auth::user()->CYID_REF)
           ->where('MACHINEID','=',$objResponse->MACHINEID_REF )
           ->select('MACHINEID','MACHINE_NO','MACHINE_DESC')
           ->first();



            $objChecklistNo = DB::table('TBL_MST_MAINTENANCE_CHECKLIST')
                    ->where('CYID_REF','=',Auth::user()->CYID_REF)
                    ->where('CKLISTID','=',$objResponse->CKLISTID_REF )
                    ->select('*')
                    ->first();    

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
                        ->where('TBL_MST_ATTACHMENT.BRID_REF','=',Auth::user()->BRID_REF)
                        ->where('TBL_MST_ATTACHMENT.FYID_REF','=',Auth::user()->FYID_REF)
                        ->leftJoin('TBL_MST_ATTACHMENT_DET', 'TBL_MST_ATTACHMENT.ATTACHMENTID','=','TBL_MST_ATTACHMENT_DET.ATTACHMENTID_REF')
                        ->select('TBL_MST_ATTACHMENT.*', 'TBL_MST_ATTACHMENT_DET.*')
                        ->orderBy('TBL_MST_ATTACHMENT.ATTACHMENTID','ASC')
                        ->get()->toArray();

                 // dd( $objMstVoucherType);

            return view('masters.PlantMaintenance.MachineWiseChecklist.mstfrm228attachment',compact(['objResponse','objMstVoucherType','objAttachments','objMachineNo','objChecklistNo']));
        }

    }
    
    public function MultiApprove(Request $request){

        $USERID_REF =   Auth::user()->USERID;
        $VTID_REF   =   $this->vtid_ref;  //voucher type id
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Auth::user()->BRID_REF;
        $FYID_REF   =   Auth::user()->FYID_REF;   

        $sp_Approvallevel = [
            $USERID_REF, $VTID_REF, $CYID_REF,$BRID_REF,
            $FYID_REF
        ];
        
        $sp_listing_result = DB::select('EXEC SP_APPROVAL_LAVEL ?,?,?,?, ?', $sp_Approvallevel);

        if(!empty($sp_listing_result))
            {
                foreach ($sp_listing_result as $key=>$valueitem)
            {  
                $record_status = 0;
                $Approvallevel = "APPROVAL".$valueitem->LAVELS;
            }
            }
            
            $req_data =  json_decode($request['ID']);

            // dd($req_data);
            $wrapped_links = $req_data; 
            $multi_array = $wrapped_links;
            $iddata = [];
            
            foreach($multi_array as $index=>$row)
            {
                $m_array[$index] = $row->ID;
                $iddata['APPROVAL'][]['ID'] =  $row->ID;
            }
            $xml = ArrayToXml::convert($iddata);
            
            $USERID_REF =   Auth::user()->USERID;
            $VTID_REF   =   $this->vtid_ref;  //voucher type id
            $CYID_REF   =   Auth::user()->CYID_REF;
            $BRID_REF   =   Auth::user()->BRID_REF;
            $FYID_REF   =   Auth::user()->FYID_REF;       
            $TABLE      =   "TBL_MST_MACHINE_CHECKLIST";
            $FIELD      =   "MCKLISTID";
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
        
        return Response::json(['errors'=>true,'msg' => 'No Record Found for Approval.','exist'=>'norecord']);
        
        }else{
        return Response::json(['errors'=>true,'msg' => 'There is some error in data. Please try after sometime.','exist'=>'Some Error']);
        }
        
        exit();   

          
    }


        //Cancel the data
   public function cancel(Request $request){

    $id = $request->{0};    
        

    $USERID_REF =   Auth::user()->USERID;
    $VTID_REF   =   $this->vtid_ref;  //voucher type id
    $CYID_REF   =   Auth::user()->CYID_REF;
    $BRID_REF   =   Auth::user()->BRID_REF;
    $FYID_REF   =   Auth::user()->FYID_REF;       
    $TABLE      =   "TBL_MST_MACHINE_CHECKLIST";
    $FIELD      =   "MCKLISTID";
    $ID         =   $id;
    $UPDATE     =   Date('Y-m-d');
    $UPTIME     =   Date('h:i:s.u');
    $IPADDRESS  =   $request->getClientIp();

    $req_data[0]=[
        'NT'  => 'TBL_MST_MACHINE_CHECKLIST_DETAILS',
    ];
   
    $wrapped_links["TABLES"] = $req_data; 
    
    $XMLTAB = ArrayToXml::convert($wrapped_links);
    
 

    $mst_cancel_data = [ $USERID_REF, $VTID_REF, $TABLE, $FIELD, $ID, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS ,$XMLTAB];
   // dd($mst_cancel_data);
    $sp_result = DB::select('EXEC SP_MST_CANCEL  ?,?,?,?, ?,?,?,?, ?,?,?,?', $mst_cancel_data);

    if($sp_result[0]->RESULT=="CANCELED"){  
      //  echo 'in cancel';
      return Response::json(['cancel' =>true,'msg' => 'Record successfully canceled.']);
    
    }elseif($sp_result[0]->RESULT=="NO RECORD FOR CANCEL"){
    
        //echo "NO RECORD FOR CANCEL";
        return Response::json(['errors'=>true,'msg' => 'No record found.','norecord'=>'norecord']);
        
    }else{
        //echo "--else--";
           return Response::json(['errors'=>true,'msg' => 'Error:'.$sp_result[0]->RESULT,'invalid'=>'invalid']);
    }
    
    exit(); 
}


    public function getmainsubparam(Request $request){

            $Status = "A";
            $CYID_REF = Auth::user()->CYID_REF;
            $BRID_REF   =   Auth::user()->BRID_REF;
            $cur_date = Date('Y-m-d');

            $cur_date = Date('Y-m-d');
            $ObjData = DB::select('select * from TBL_MST_MAINTENANCE_SUB_PARAMETER  where (DEACTIVATED=0 or DEACTIVATED is null or DEACTIVATED=1) AND (DODEACTIVATED is null or DODEACTIVATED>=?) and CYID_REF = ?   and STATUS = ? ', [$cur_date,$CYID_REF,'A']);
            

            if(!empty($ObjData)){

                foreach ($ObjData as $index=>$dataRow){
                
                    // $row = '';
                    // $row = $row.'<tr id="LISTPOP1code_'.$dataRow->MSPID .'"  class="clsLISTPOP1id"><td width="50%">'.$dataRow->MSP_CODE;
                    // $row = $row.'<input type="hidden" id="txtLISTPOP1code_'.$dataRow->MSPID.'" data-desc="'.$dataRow->MSP_CODE.'"  data-descdate="'.$dataRow->MSP_DESC.'"
                    // value="'.$dataRow->MSPID.'"/></td><td>'.$dataRow->MSP_DESC.'</td></tr>';
                    // echo $row;
                
                    $row = '';
                    $row = $row.'<tr >
                    <td width="12%" class="ROW1" align="center"> <input type="checkbox" name="SELECT_MSPID_REF[]" id="LISTPOP1code_'.$dataRow->MSPID .'"  class="clsLISTPOP1id" value="'.$dataRow->MSPID.'" ></td>
                    <td width="39%" class="ROW2">'.$dataRow->MSP_CODE;
                    $row = $row.'<input type="hidden" id="txtLISTPOP1code_'.$dataRow->MSPID.'" data-desc="'.$dataRow->MSP_CODE.'"  data-descdate="'.$dataRow->MSP_DESC.'"
                    value="'.$dataRow->MSPID.'"/></td><td width="39%" class="ROW3">'.$dataRow->MSP_DESC.'</td></tr>';
                    echo $row;

                }
            }else{
                echo '<tr><td colspan="2">Record not found.</td></tr>';
            }
            exit();
    }

    public function getmpdata(Request $request){

        $Status = "A";
        $CYID_REF = Auth::user()->CYID_REF;

        $cur_date = Date('Y-m-d');
        $ObjData = DB::select('select * from TBL_MST_MAINTENANCE_PARAMETER  where (DEACTIVATED=0 or DEACTIVATED is null or DEACTIVATED=1) AND (DODEACTIVATED is null or DODEACTIVATED>=?) and CYID_REF = ?   and STATUS = ? ',
                        [$cur_date,$CYID_REF,'A']);
        
        
            if(!empty($ObjData)){

            foreach ($ObjData as $index=>$dataRow){               

                // $row = '';
                // $row = $row.'<tr id="FORMcode_'.$dataRow->MPID .'"  class="clsFORMid"><td width="50%">'.$dataRow->MP_CODE;
                // $row = $row.'<input type="hidden" id="txtFORMcode_'.$dataRow->MPID.'" data-desc="'.$dataRow->MP_CODE.'"  data-descdate="'.$dataRow->MP_DESC.'"
                // value="'.$dataRow->MPID.'"/></td><td>'.$dataRow->MP_DESC.'</td></tr>';
                // echo $row;

                $row = '';
                $row = $row.'<tr >
                <td width="12%" class="ROW1" align="center"> <input type="checkbox" name="SELECT_MPID_REF[]" id="FORMcode_'.$dataRow->MPID .'"  class="clsFORMid" value="'.$dataRow->MPID.'" ></td>
                <td width="39%" class="ROW2">'.$dataRow->MP_CODE;
                $row = $row.'<input type="hidden" id="txtFORMcode_'.$dataRow->MPID.'" data-desc="'.$dataRow->MP_CODE.'"  data-descdate="'.$dataRow->MP_DESC.'"
                value="'.$dataRow->MPID.'"/></td><td width="39%" class="ROW3">'.$dataRow->MP_DESC.'</td></tr>';
                echo $row;

            }
            }else{
                echo '<tr><td colspan="3">Record not found.</td></tr>';
            }
            exit();
    }

    public function codeduplicate(Request $request){

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Auth::user()->BRID_REF;
        $FYID_REF = Auth::user()->FYID_REF;
        $MACHINEID_REF =   $request['MACHINEID_REF'];
        $CHECKLIST_REF =   $request['CHECKLIST_REF'];
        
        
        $objLabel = DB::table('TBL_MST_MACHINE_CHECKLIST')
                ->where('CYID_REF','=',Auth::user()->CYID_REF)
                ->where('MACHINEID_REF','=',$MACHINEID_REF)
                ->where('CKLISTID_REF','=',$CHECKLIST_REF)
                ->select('MCKLISTID')
                ->first();
        
        if($objLabel){  

            return Response::json(['exists' =>true,'msg' => 'Duplicate record. Machine No and Checklist No Already exists.']);
        
        }else{

            return Response::json(['notexists'=>true,'msg' => 'Ok']);
        }
        
        exit();
   }


   public function getmachines(Request $request){

        $Status = "A";
        $CYID_REF = Auth::user()->CYID_REF;

        $cur_date = Date('Y-m-d');
        $ObjData = DB::select('select * from TBL_MST_MACHINE  where (DEACTIVATED=0 or DEACTIVATED is null or DEACTIVATED=1) AND (DODEACTIVATED is null or DODEACTIVATED>=?) and CYID_REF = ?   and STATUS = ? ',  [$cur_date,$CYID_REF,'A']);
                        
        if(!empty($ObjData)){

        foreach ($ObjData as $index=>$dataRow){
            // $row = '';
            // $row = $row.'<tr id="subgl_'.$dataRow->MACHINEID .'"  class="clsmachine"><td width="50%">'.$dataRow->MACHINE_NO;
            // $row = $row.'<input type="hidden" id="txtsubgl_'.$dataRow->MACHINEID.'" data-desc="'.$dataRow->MACHINE_NO .'" data-ccname="'.$dataRow->MACHINE_DESC.'" value="'.$dataRow->MACHINEID.'"/></td>';
            // $row = $row.'<td width="50%">'.$dataRow->MACHINE_DESC.'</td>';
            // $row = $row.'</tr>';
            // echo $row;

            $row = '';
            $row = $row.'<tr >
            <td width="12%" class="ROW1" align="center"> <input type="checkbox" name="SELECT_MACHINEID_REF[]" id="subgl_'.$dataRow->MACHINEID .'"  class="clsmachine" value="'.$dataRow->MACHINEID.'" ></td>
            <td width="39%" class="ROW2">'.$dataRow->MACHINE_NO;
            $row = $row.'<input type="hidden" id="txtsubgl_'.$dataRow->MACHINEID.'" data-desc="'.$dataRow->MACHINE_NO .'" data-ccname="'.$dataRow->MACHINE_DESC.'" value="'.$dataRow->MACHINEID.'"/></td>';
            $row = $row.'<td width="39%" class="ROW3">'.$dataRow->MACHINE_DESC.'</td>';
            $row = $row.'</tr>';
            echo $row;
        }
        }else{
            echo '<tr><td colspan="3">Record not found.</td></tr>';
        }
        exit();

    }


    public function getchecklists(Request $request){

        $Status = "A";
        $CYID_REF = Auth::user()->CYID_REF;

        $cur_date = Date('Y-m-d');
        $ObjData = DB::select('select * from TBL_MST_MAINTENANCE_CHECKLIST  where (DEACTIVATED=0 or DEACTIVATED is null or DEACTIVATED=1) AND (DODEACTIVATED is null or DODEACTIVATED>=?) and CYID_REF = ?   and STATUS = ? ',  [$cur_date,$CYID_REF,'A']);
                        
        if(!empty($ObjData)){

        foreach ($ObjData as $index=>$dataRow){
            // $row = '';
            // $row = $row.'<tr id="chklist_'.$dataRow->CKLISTID .'"  class="clschecklist"><td width="50%">'.$dataRow->CHECKLIST_NO;
            // $row = $row.'<input type="hidden" id="txtchklist_'.$dataRow->CKLISTID.'" data-desc="'.$dataRow->CHECKLIST_NO .'" data-ccname="'.$dataRow->CHECKLIST_DESC.'" value="'.$dataRow->CKLISTID.'"/></td>';
            // $row = $row.'<td width="50%">'.$dataRow->CHECKLIST_DESC.'</td>';
            // $row = $row.'</tr>';
            // echo $row;

            $row = '';
            $row = $row.'<tr >
            <td width="12%" class="ROW1" align="center"> <input type="checkbox" name="SELECT_CKLISTID_REF[]" id="chklist_'.$dataRow->CKLISTID .'"  class="clschecklist" value="'.$dataRow->CKLISTID.'" ></td>
            <td width="39%" class="ROW2">'.$dataRow->CHECKLIST_NO;
            $row = $row.'<input type="hidden" id="txtchklist_'.$dataRow->CKLISTID.'" data-desc="'.$dataRow->CHECKLIST_NO .'" data-ccname="'.$dataRow->CHECKLIST_DESC.'" value="'.$dataRow->CKLISTID.'"/></td>';
            $row = $row.'<td width="39%" class="ROW3">'.$dataRow->CHECKLIST_DESC.'</td>';
            $row = $row.'</tr>';
            echo $row;

        }
        }else{
            echo '<tr><td colspan="2">Record not found.</td></tr>';
        }
        exit();

    }



} //class
