<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\TblMstFrm223;
use DB;
use Response;
use Auth;
use Session;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

use Spatie\ArrayToXml\ArrayToXml;
use Carbon\Carbon;


class MstFrm223Controller extends Controller
{
   
    protected $form_id = 223;
    protected $vtid_ref   = 185;  //voucher type id

    //validation messages
    protected   $messages = [
                    'METER_CODE.required' => 'Required field',
                    'METER_DESC.required' => 'Required field'
                ];
    
    
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


        $FormId         =   $this->form_id;
        $objDataList    =   DB::table('TBL_MST_ENERGY')
                            ->where('CYID_REF','=',Auth::user()->CYID_REF)
                            ->get();

     

        return view('masters.PlantMaintenance.EnergyMeter.mstfrm223',compact(['objRights','objDataList','FormId']));

    }



   

    
    public function add(){ 
    
		
		$CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');    
        $FYID_REF   =   Session::get('FYID_REF');

        $Status = 'A';
		
        
         $cur_date = Date('Y-m-d');
         $ObjFuelType = DB::select('select   * from TBL_MST_FUEL_TYPE  where (DEACTIVATED=0 or DEACTIVATED is null or DEACTIVATED=1) AND (DODEACTIVATED is null or DODEACTIVATED>=?)  and STATUS = ? and CYID_REF=? order by FUEL_CODE', [$cur_date, $Status, $CYID_REF]);

         $ObjMainUOM = DB::select('select   * from TBL_MST_UOM  where (DEACTIVATED=0 or DEACTIVATED is null or DEACTIVATED=1) AND (DODEACTIVATED is null or DODEACTIVATED>=?)  and STATUS = ? and CYID_REF=? order by UOMCODE', [$cur_date, $Status, $CYID_REF]);

         $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');

        $docarray   =   $this->get_docno_for_master([
            'VTID_REF'=>$this->vtid_ref,
            'CYID_REF'=>Auth::user()->CYID_REF,
            'BRID_REF'=>NULL
        ]);



        
		     
      return view('masters.PlantMaintenance.EnergyMeter.mstfrm223add',compact(['ObjFuelType','ObjMainUOM','docarray']));        
    }

   public function codeduplicate(Request $request){

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');
        $METER_CODE =   $request['METER_CODE'];
        
        $objLabel = DB::table('TBL_MST_ENERGY')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        ->where('METER_CODE','=',$METER_CODE)
        ->select('METER_CODE')
        ->first();
        
        if($objLabel){  

            return Response::json(['exists' =>true,'msg' => 'Duplicate record']);
        
        }else{

            return Response::json(['not exists'=>true,'msg' => 'Ok']);
        }
        
        exit();
   }

   public function save(Request $request){

       // dd($request->all());

        $rules = [
            'METER_CODE' => 'required',
            'METER_DESC' => 'required',          
        ];

        $req_data = [

            'METER_CODE'  => strtoupper(trim($request['METER_CODE']) ),            
            'METER_DESC' =>   $request['METER_DESC'],
           
        ]; 


        $validator = Validator::make( $req_data, $rules, $this->messages);

        if ($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);	
        }


 
        $METER_CODE   =   strtoupper(trim($request['METER_CODE']) );
        $METER_DESC   =   trim($request['METER_DESC']);  
       
        $KWH   =   !empty(trim($request['KWH'])) ? trim($request['KWH']) :null;  
        $KVARH   =  !empty(trim($request['KVARH'])) ? trim($request['KVARH']) :null;  
        $KVAH   =  !empty(trim($request['KVAH'])) ? trim($request['KVAH']) :null;  
        $MD   =  !empty(trim($request['MD'])) ? trim($request['MD']) :null; 

        $POWER_FACTOR   =  !empty(trim($request['POWER_FACTOR'])) ? trim($request['POWER_FACTOR']) :null;   
        $newDateString = NULL;        
        $newdt = !(is_null($request['DOCOMMISSION']) ||empty($request['DOCOMMISSION']) )=="true" ? $request['DOCOMMISSION'] : NULL; 
        if(!is_null($newdt) ){

            $newdt = str_replace( "/", "-",  $newdt ) ;
            $newDateString = Carbon::parse($newdt)->format('Y-m-d');        
        }
        $DOCOMMISSION = $newDateString;     


        $METER_COMPANY   =  !empty(trim($request['METER_COMPANY'])) ? trim($request['METER_COMPANY']) :null;  
        $BRAND   =  !empty(trim($request['BRAND'])) ? trim($request['BRAND']) :null;  
        $MODEL   =  !empty(trim($request['MODEL'])) ? trim($request['MODEL']) :null;  
        $SERIAL_NO   =  !empty(trim($request['SERIAL_NO'])) ? trim($request['SERIAL_NO']) :null;  
        $SANCTION_LOAD   =  !empty(trim($request['SANCTION_LOAD'])) ? trim($request['SANCTION_LOAD']) :null;  

        $SUPPLY_BY   =  !empty(trim($request['SUPPLY_BY'])) ? trim($request['SUPPLY_BY']) :null;  
        $REMARKS   =  !empty(trim($request['REMARKS'])) ? trim($request['REMARKS']) :null;  
       
        $DEACTIVATED    =   0;  
        $DODEACTIVATED  =   null;  

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');    
        $USERID         =   Auth::user()->USERID;   
        $VTID           =   $this->vtid_ref;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "ADD";
        $IPADDRESS      =   $request->getClientIp();
        
        
        $array_data   = [
                    $METER_CODE,
                    $METER_DESC,
                    $KWH,
                    $KVARH,
                    $KVAH,
                    $MD,

                    $POWER_FACTOR,
                    $DOCOMMISSION,
                    $METER_COMPANY,
                    $BRAND,
                    $MODEL,
                    $SERIAL_NO,

                    $SANCTION_LOAD,
                    $SUPPLY_BY,
                    $REMARKS,
                    $CYID_REF,                        
                    $BRID_REF,                        
                    $FYID_REF,
                        
                    $VTID, 
                    $USERID,                    
                    $UPDATE,
                    $UPTIME,
                    $ACTION,
                    $IPADDRESS,
                    
                    $DEACTIVATED,
                    $DODEACTIVATED
                        
                    ];


        try {

            $sp_result = DB::select('EXEC SP_ENERGY_IN  ?,?,?,?,?,?, ?,?,?,?,?,?, ?,?,?,?,?,?, ?,?,?,?,?,?, ?,?', $array_data);
        
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

            $objResponse = DB::table('TBL_MST_ENERGY')
                            ->where('ENERGYID','=',$id)
                            ->select('*')
                            ->first();

            if(!empty($objResponse)){
                if(strtoupper($objResponse->STATUS)=="A" || strtoupper($objResponse->STATUS)=="C"){
                    exit("Sorry, Only Un Approved record can edit.");
                }
            }                

            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

          
            return view('masters.PlantMaintenance.EnergyMeter.mstfrm223edit',compact(['objResponse','user_approval_level','objRights']));
        }

    }

     
    public function update(Request $request)
    {
        $rules = [
            'METER_CODE' => 'required',          
            'METER_DESC' => 'required',          
        ];

        $req_data = [

            'METER_CODE'  => strtoupper(trim($request['METER_CODE']) ),
            'METER_DESC' =>   $request['METER_DESC'],
           
        ]; 


        $validator = Validator::make( $req_data, $rules, $this->messages);

        if ($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);	
        }


 
        $METER_CODE   =   strtoupper(trim($request['METER_CODE']) );
        $METER_DESC   =   trim($request['METER_DESC']);  
       
        $KWH   =   !empty(trim($request['KWH'])) ? trim($request['KWH']) :null;  
        $KVARH   =  !empty(trim($request['KVARH'])) ? trim($request['KVARH']) :null;  
        $KVAH   =  !empty(trim($request['KVAH'])) ? trim($request['KVAH']) :null;  
        $MD   =  !empty(trim($request['MD'])) ? trim($request['MD']) :null; 

        $POWER_FACTOR   =  !empty(trim($request['POWER_FACTOR'])) ? trim($request['POWER_FACTOR']) :null;   
        $newDateString = NULL;        
        $newdt = !(is_null($request['DOCOMMISSION']) ||empty($request['DOCOMMISSION']) )=="true" ? $request['DOCOMMISSION'] : NULL; 
        if(!is_null($newdt) ){

            $newdt = str_replace( "/", "-",  $newdt ) ;
            $newDateString = Carbon::parse($newdt)->format('Y-m-d');        
        }
        $DOCOMMISSION = $newDateString;     


        $METER_COMPANY   =  !empty(trim($request['METER_COMPANY'])) ? trim($request['METER_COMPANY']) :null;  
        $BRAND   =  !empty(trim($request['BRAND'])) ? trim($request['BRAND']) :null;  
        $MODEL   =  !empty(trim($request['MODEL'])) ? trim($request['MODEL']) :null;  
        $SERIAL_NO   =  !empty(trim($request['SERIAL_NO'])) ? trim($request['SERIAL_NO']) :null;  
        $SANCTION_LOAD   =  !empty(trim($request['SANCTION_LOAD'])) ? trim($request['SANCTION_LOAD']) :null;  

        $SUPPLY_BY   =  !empty(trim($request['SUPPLY_BY'])) ? trim($request['SUPPLY_BY']) :null;  
        $REMARKS   =  !empty(trim($request['REMARKS'])) ? trim($request['REMARKS']) :null;  
       
        $DEACTIVATED = (isset($request['DEACTIVATED']) )? 1 : 0 ;
        $newDateString5 = NULL;
        $newdt5 = !(is_null($request['DODEACTIVATED']) ||empty($request['DODEACTIVATED']) )=="true" ? $request['DODEACTIVATED'] : NULL; 

        if(!is_null($newdt5) ){
            
            $newdt5 = str_replace( "/", "-",  $newdt5 ) ;
            $newDateString5 = Carbon::parse($newdt5)->format('Y-m-d');        
        }
        $DODEACTIVATED = $newDateString5;

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');    
        $USERID         =   Auth::user()->USERID;   
        $VTID           =   $this->vtid_ref;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "EDIT";
        $IPADDRESS      =   $request->getClientIp();
        
        
        $array_data   = [
                    $METER_CODE,
                    $METER_DESC,
                    $KWH,
                    $KVARH,
                    $KVAH,
                    $MD,

                    $POWER_FACTOR,
                    $DOCOMMISSION,
                    $METER_COMPANY,
                    $BRAND,
                    $MODEL,
                    $SERIAL_NO,

                    $SANCTION_LOAD,
                    $SUPPLY_BY,
                    $REMARKS,
                    $CYID_REF,                        
                    $BRID_REF,                        
                    $FYID_REF,
                        
                    $VTID, 
                    $USERID,                    
                    $UPDATE,
                    $UPTIME,
                    $ACTION,
                    $IPADDRESS,
                    
                    $DEACTIVATED,
                    $DODEACTIVATED
                        
                    ];


        try {

            $sp_result = DB::select('EXEC SP_ENERGY_UP  ?,?,?,?,?,?, ?,?,?,?,?,?, ?,?,?,?,?,?, ?,?,?,?,?,?, ?,?', $array_data); 
       
        } catch (\Throwable $th) {

             return Response::json(['errors'=>true,'msg' => 'Error:'.$sp_result[0]->RESULT,'save'=>'invalid']);

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
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');       
        // @XML	xml
        $USERID         =   Auth::user()->USERID;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "ADD";
        $IPADDRESS      =   $request->getClientIp();
        
        $destinationPath = storage_path()."/docs/company".$CYID_REF."/EnergyMeter";

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
            return redirect()->route("master",[223,"attachment",$ATTACH_DOCNO])->with("success","The file is already exist");
        }
     

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

            return redirect()->route("master",[223,"attachment",$ATTACH_DOCNO])->with("success","Files successfully attached. ".$duplicate_files.$invlid_files);


        }        elseif($sp_result[0]->RESULT=="Duplicate file for same records"){
       
            return redirect()->route("master",[223,"attachment",$ATTACH_DOCNO])->with("success","Duplicate file name. ".$invlid_files);
    
        }else{

            //return redirect()->route("master",[223,"attachment",$ATTACH_DOCNO])->with("error","There is some data error. Please try after sometime.  ");
            return redirect()->route("master",[223,"attachment",$ATTACH_DOCNO])->with($sp_result[0]->RESULT);
        }
      
        
    }   

  


    //singleApprove begin
    public function singleapprove(Request $request)
    {

       
        $rules = [
            'METER_CODE' => 'required',          
            'METER_DESC' => 'required',          
        ];

        $req_data = [

            'METER_CODE'  => strtoupper(trim($request['METER_CODE']) ),            
            'METER_DESC' =>   $request['METER_DESC'],
           
        ]; 


        $validator = Validator::make( $req_data, $rules, $this->messages);

        if ($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);	
        }


 
        $METER_CODE   =   strtoupper(trim($request['METER_CODE']) );
        $METER_DESC   =   trim($request['METER_DESC']);  
       
        $KWH   =   !empty(trim($request['KWH'])) ? trim($request['KWH']) :null;  
        $KVARH   =  !empty(trim($request['KVARH'])) ? trim($request['KVARH']) :null;  
        $KVAH   =  !empty(trim($request['KVAH'])) ? trim($request['KVAH']) :null;  
        $MD   =  !empty(trim($request['MD'])) ? trim($request['MD']) :null; 

        $POWER_FACTOR   =  !empty(trim($request['POWER_FACTOR'])) ? trim($request['POWER_FACTOR']) :null;   
        $newDateString = NULL;        
        $newdt = !(is_null($request['DOCOMMISSION']) ||empty($request['DOCOMMISSION']) )=="true" ? $request['DOCOMMISSION'] : NULL; 
        if(!is_null($newdt) ){

            $newdt = str_replace( "/", "-",  $newdt ) ;
            $newDateString = Carbon::parse($newdt)->format('Y-m-d');        
        }
        $DOCOMMISSION = $newDateString;     


        $METER_COMPANY   =  !empty(trim($request['METER_COMPANY'])) ? trim($request['METER_COMPANY']) :null;  
        $BRAND   =  !empty(trim($request['BRAND'])) ? trim($request['BRAND']) :null;  
        $MODEL   =  !empty(trim($request['MODEL'])) ? trim($request['MODEL']) :null;  
        $SERIAL_NO   =  !empty(trim($request['SERIAL_NO'])) ? trim($request['SERIAL_NO']) :null;  
        $SANCTION_LOAD   =  !empty(trim($request['SANCTION_LOAD'])) ? trim($request['SANCTION_LOAD']) :null;  

        $SUPPLY_BY   =  !empty(trim($request['SUPPLY_BY'])) ? trim($request['SUPPLY_BY']) :null;  
        $REMARKS   =  !empty(trim($request['REMARKS'])) ? trim($request['REMARKS']) :null;  
       
        $DEACTIVATED = (isset($request['DEACTIVATED']) )? 1 : 0 ;
        $newDateString5 = NULL;
        $newdt5 = !(is_null($request['DODEACTIVATED']) ||empty($request['DODEACTIVATED']) )=="true" ? $request['DODEACTIVATED'] : NULL; 

        if(!is_null($newdt5) ){
            
            $newdt5 = str_replace( "/", "-",  $newdt5 ) ;
            $newDateString5 = Carbon::parse($newdt5)->format('Y-m-d');        
        }
        $DODEACTIVATED = $newDateString5;

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');    
        $USERID         =   Auth::user()->USERID;   
        $VTID           =   $this->vtid_ref;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   trim($request['user_approval_level']);   // user approval level value
        $IPADDRESS      =   $request->getClientIp();
        
        
        $array_data   = [
                    $METER_CODE,
                    $METER_DESC,
                    $KWH,
                    $KVARH,
                    $KVAH,
                    $MD,

                    $POWER_FACTOR,
                    $DOCOMMISSION,
                    $METER_COMPANY,
                    $BRAND,
                    $MODEL,
                    $SERIAL_NO,

                    $SANCTION_LOAD,
                    $SUPPLY_BY,
                    $REMARKS,
                    $CYID_REF,                        
                    $BRID_REF,                        
                    $FYID_REF,
                        
                    $VTID, 
                    $USERID,                    
                    $UPDATE,
                    $UPTIME,
                    $ACTION,
                    $IPADDRESS,
                    
                    $DEACTIVATED,
                    $DODEACTIVATED

                    ];


        try {

            $sp_result = DB::select('EXEC SP_ENERGY_UP  ?,?,?,?,?,?, ?,?,?,?,?,?, ?,?,?,?,?,?, ?,?,?,?,?,?, ?,?', $array_data);       
       
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
            $BRID_REF   =   Session::get('BRID_REF');    
            $FYID_REF   =   Session::get('FYID_REF');

            $sp_user_approval_req = [
                $USERID, $VTID, $CYID_REF, $BRID_REF, $FYID_REF
            ];        

            //get user approval data
            $user_approval_details = DB::select('EXEC SP_APPROVAL_LAVEL ?,?,?,?,?', $sp_user_approval_req);
            $user_approval_level = "APPROVAL".$user_approval_details[0]->LAVELS;

            $objResponse = DB::table('TBL_MST_ENERGY')
                            ->where('ENERGYID','=',$id)
                            ->select('*')
                            ->first();

           
            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

          
            return view('masters.PlantMaintenance.EnergyMeter.mstfrm223view',compact(['objResponse','user_approval_level','objRights']));
        }

        

    }
  
    public function printdata(Request $request){
        //
        $ids_data = [];
        if(isset($request->records_ids)){
            
            $ids_data = explode(",",$request->records_ids);
        }
        $objResponse = TblMstFrm223::whereIn('ENERGYID',$ids_data)->get();
        
        return view('masters.PlantMaintenance.EnergyMeter.mstfrm223print',compact(['objResponse']));
   }//print




        //display attachments form
        public function attachment($id){

            if(!is_null($id))
            {
                //EXEC [SP_APPROVAL_LAVEL] 2,114,6,4,2
                
                $objResponse = DB::table('TBL_MST_ENERGY')
                    ->where('CYID_REF','=',Auth::user()->CYID_REF)
                    ->where('ENERGYID','=',$id)
                    ->select('*')
                    ->first();                

                
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
    
                     
    
                return view('masters.PlantMaintenance.EnergyMeter.mstfrm223attachment',compact(['objResponse','objMstVoucherType','objAttachments']));
            }
    
        }
        
    
    public function MultiApprove(Request $request){

        $USERID_REF =   Auth::user()->USERID;
        $VTID_REF   =   $this->vtid_ref;  //voucher type id
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
                foreach ($sp_listing_result as $key=>$valueitem)
                {  
                    $record_status = 0;
                    $Approvallevel = "APPROVAL".$valueitem->LAVELS;
                }
            }
        

            
            $req_data =  json_decode($request['ID']);

           
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
            $BRID_REF   =   Session::get('BRID_REF');
            $FYID_REF   =   Session::get('FYID_REF');       
            $TABLE      =   "TBL_MST_ENERGY";
            $FIELD      =   "ENERGYID";
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
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');       
        $TABLE      =   "TBL_MST_ENERGY";
        $FIELD      =   "ENERGYID";
        $ID         =   $id;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();

        $cancelData[0]= ['NT' =>'TBL_MST_ENERGY'];
        $cancel_links["TABLES"] = $cancelData;
        $cancelxml = ArrayToXml::convert($cancel_links);

        $mst_cancel_data = [ $USERID_REF, $VTID_REF, $TABLE, $FIELD, $ID, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS ,$cancelxml];

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

    public function getasset(Request $request){

        $Status = "A";
        $CYID_REF = Auth::user()->CYID_REF;
        
                      
        $cur_date = Date('Y-m-d');
        
        $ObjData = DB::select('select  * from TBL_MST_ASSET  where (DEACTIVATED=0 or DEACTIVATED is null or DEACTIVATED=1) AND (DODEACTIVATED is null or DODEACTIVATED>=?)  and CYID_REF = ? and STATUS = ? order by ASSETCODE', [$cur_date, $CYID_REF, $Status]);
                         

            if(!empty($ObjData)){

            foreach ($ObjData as $index=>$dataRow){

                $ObjACat = DB::select('select  top 1 * from TBL_MST_ASSETCATEGORY  where (ACTIVE=0 or ACTIVE is null or ACTIVE=1) AND (ACTIVEDATE is null or ACTIVEDATE>=?)  and STATUS = ? and ASCATID=? order by CATEGORY', [$cur_date, $Status, $dataRow->ASCATID_REF]);
               
                if(!empty($ObjACat)){
                    $asset_cat_id =  $ObjACat[0]->ASCATID;
                    $asset_cat_code =  $ObjACat[0]->CATEGORY;
                    $asset_cat_desc =  $ObjACat[0]->DESCRIPTIONS;
                }else{
                    $asset_cat_id =  '';
                    $asset_cat_code =  '';
                    $asset_cat_desc =  '';
                }

                $ObjAType = DB::select('select  top 1 * from TBL_MST_ASSETTYPE  where (ACTIVE=0 or ACTIVE is null or ACTIVE=1) AND (ACTIVEDATE is null or ACTIVEDATE>=?)   and ASTID=? order by ASSETTYPE', [$cur_date, $dataRow->ASTID_REF]);
               
                if(!empty($ObjAType)){
                    $asset_type_id =  $ObjAType[0]->ASTID;
                    $asset_type_code =  $ObjAType[0]->ASSETTYPE;
                    $asset_type_desc =  $ObjAType[0]->DESCRIPTIONS;
                }else{
                    $asset_type_id =  '';
                    $asset_type_code =  '';
                    $asset_type_desc =  '';
                }


                $row = '';
                $row = $row.'<tr id="LISTPOP1code_'.$dataRow->ASSETID .'"  class="clsLISTPOP1id"><td width="50%">'.$dataRow->ASSETCODE;
                $row = $row.'<input type="hidden" id="txtLISTPOP1code_'.$dataRow->ASSETID.'" data-desc="'.$dataRow->ASSETCODE.'"  data-descdate="'.$dataRow->DESCRIPTIONS.'"
                value="'.$dataRow->ASSETID.'"  data-asset_cat_id="'.$asset_cat_id.'" data-asset_cat_code="'.$asset_cat_code.'" data-asset_cat_desc="'.$asset_cat_desc.'" data-asset_type_id="'.$asset_type_id.'"  data-asset_type_code="'.$asset_type_code.'" data-asset_type_desc="'.$asset_type_desc.'"  /></td><td>'.$dataRow->DESCRIPTIONS.'</td></tr>';
                echo $row;

            }
            }else{
                echo '<tr><td colspan="2">Record not found.</td></tr>';
            }
            exit();
    }


}
