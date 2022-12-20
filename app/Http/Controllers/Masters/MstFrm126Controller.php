<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\TblMstFrm126;
use DB;
use Response;
use Session;
use Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

use Spatie\ArrayToXml\ArrayToXml;
use Carbon\Carbon;


class MstFrm126Controller extends Controller
{
   
    protected $form_id = 126;
    protected $vtid_ref   = 117;  //voucher type id

    //validation messages
    protected   $messages = [
                    'DISTCODE.required' => 'Required field',
                    'DISTCODE.unique' => 'Duplicate Code',
                    'NAME.required' => 'Required field'
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

        $objDataList=DB::select("SELECT	DISTID,DISTCODE,NAME,INDATE,DEACTIVATED,DODEACTIVATED,STATUS FROM TBL_MST_DISTT");

        return view('masters.Common.District.mstfrm126',compact(['objRights','objDataList']));

    }
    
    public function add(){ 
        
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');  


        $objCountryList = DB::table('TBL_MST_COUNTRY')
        ->where('STATUS','=','A')
        ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
        ->select('CTRYID','CTRYCODE','NAME')
        ->get();

        $docarray   =   $this->get_docno_for_master([
            'VTID_REF'=>$this->vtid_ref,
            'CYID_REF'=>Auth::user()->CYID_REF,
            'BRID_REF'=>NULL
        ]);

        return view('masters.Common.District.mstfrm126add',compact(['objCountryList','docarray']));
    }

    public function getCountryWiseState(Request $request){

        $objStateList = DB::table('TBL_MST_STATE')
        ->where('STATUS','=','A')
        ->where('CTRYID_REF','=',$request['CTRYID_REF'])
        ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
        ->select('STID','NAME','STCODE')
        ->get();
    
        if(!empty($objStateList)){
            foreach($objStateList as $state){
            
                echo '<tr>
                <td width="12%" class="ROW1" align="center"> <input type="checkbox" name="SELECT_STID_REF[]" id="stidref_'.$state->STID.'" class="cls_stidref" value="'.$state->STID.'" ></td>
                <td width="39%" class="ROW2">'.$state->STCODE.'
                <input type="hidden" id="txtstidref_'.$state->STID.'" data-desc="'.$state->STCODE.'" data-descname="'.$state->NAME.'" value="'.$state->STID.'" />
                </td>
                <td width="39%" class="ROW3">'.$state->NAME.'</td>
                </tr>';
            }
        }
        else{
            echo '<tr><td colspan="2">Record not found.</td></tr>';
        }
        exit();
    }

    public function getStateWiseCity(Request $request){
        
        $objCityList = DB::table('TBL_MST_CITY')
        ->where('STATUS','=','A')
        ->where('CTRYID_REF','=',$request['CTRYID_REF'])
        ->where('STID_REF','=',$request['STID_REF'])
        ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
        ->select('CITYID','CITYCODE','NAME')
        ->get();
        
        if(!empty($objCityList)){
            foreach($objCityList as $city){
            
                echo '<tr >
                <td width="12%" class="ROW1" align="center"> <input type="checkbox" name="SELECT_CITYID_REF[]" id="cityidref_'.$city->CITYID.'" class="cls_cityidref" value="'.$city->CITYID.'" ></td>
                <td width="39%" class="ROW2">'.$city->CITYCODE.'
                <input type="hidden" id="txtcityidref_'.$city->CITYID.'"  data-desc="'.$city->CITYCODE.'" data-descname="'.$city->NAME.'"  value="'.$city->CITYID.'" />
                </td>
                <td width="39%" class="ROW3">'.$city->NAME.'</td>
                </tr>';
            }
        }
        else{
            echo '<tr><td colspan="2">Record not found.</td></tr>';
        }

        exit();
    }

   public function codeduplicate(Request $request){

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');
        $DISTCODE =   $request['DISTCODE'];

        $objLabel = DB::table('TBL_MST_DISTT')
        ->where('DISTCODE','=',$DISTCODE)
        ->select('DISTCODE')
        ->first();
        
        if($objLabel){  

            return Response::json(['exists' =>true,'msg' => 'Duplicate record']);
        
        }else{

            return Response::json(['not exists'=>true,'msg' => 'Ok']);
        }
        
        exit();
   }

   public function save(Request $request){

        $rules = [
            'DISTCODE' => 'required',
            'NAME' => 'required',     
            'CTRYID_REF' => 'required', 
            'STID_REF' => 'required',  
            'CITYID_REF' => 'required',    
        ];
        
        $req_data = [
            'DISTCODE'     =>    $request['DISTCODE'],
            'NAME' =>        $request['NAME'],
            'CTRYID_REF'     =>    $request['CTRYID_REF'],
            'STID_REF'     =>    $request['STID_REF'],
            'CITYID_REF'     =>    $request['CITYID_REF']
        ]; 


        $validator = Validator::make( $req_data, $rules, $this->messages);

        if ($validator->fails())
        {
        return Response::json(['errors' => $validator->errors()]);	
        }
        
        $DISTCODE       =   strtoupper(trim($request['DISTCODE']) );
        $NAME           =   trim($request['NAME']);  
        $CTRYID_REF     =   trim($request['CTRYID_REF']);
        $STID_REF       =   trim($request['STID_REF']);
        $CITYID_REF     =   trim($request['CITYID_REF']);

        $DEACTIVATED    =   NULL;  
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
                        $DISTCODE, $NAME,$CTRYID_REF, $STID_REF,$CITYID_REF,
                        $DEACTIVATED, $DODEACTIVATED, $CYID_REF, $BRID_REF,
                        $FYID_REF, $VTID, $USERID, $UPDATE,
                        $UPTIME, $ACTION, $IPADDRESS
                    ];  
         
        try {

            $sp_result = DB::select('EXEC SP_DISTT_IN ?,?,?,?,?, ?,?,?,?, ?,?,?,?, ?,?,?', $array_data);
           
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

            $objResponse = TblMstFrm126::where('DISTID','=',$id)->first();
            if(strtoupper($objResponse->STATUS)=="A" || strtoupper($objResponse->STATUS)=="C"){
                exit("Sorry, Only Un Approved record can edit.");
            }

            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);

            $objCountryList = DB::table('TBL_MST_COUNTRY')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->where('BRID_REF','=',Session::get('BRID_REF'))
         //   ->where('FYID_REF','=',Session::get('FYID_REF'))
            ->where('STATUS','=','A')
            ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
            ->select('CTRYID','CTRYCODE','NAME')
            ->get();

            $objCountryName = DB::table('TBL_MST_COUNTRY')
                ->where('CYID_REF','=',Auth::user()->CYID_REF)
                ->where('BRID_REF','=',Session::get('BRID_REF'))
              //  ->where('FYID_REF','=',Session::get('FYID_REF'))
                ->where('STATUS','=','A')
                ->where('CTRYID','=',$objResponse->CTRYID_REF)
                ->select('CTRYCODE','NAME')
                ->first();

            $objStateName = DB::table('TBL_MST_STATE')
                ->where('CYID_REF','=',Auth::user()->CYID_REF)
                ->where('BRID_REF','=',Session::get('BRID_REF'))
               // ->where('FYID_REF','=',Session::get('FYID_REF'))
                ->where('STATUS','=','A')
                ->where('STID','=',$objResponse->STID_REF)
                ->select('STCODE','NAME')
                ->first();

            $objCityName = DB::table('TBL_MST_CITY')
                ->where('CYID_REF','=',Auth::user()->CYID_REF)
                ->where('BRID_REF','=',Session::get('BRID_REF'))
                //->where('FYID_REF','=',Session::get('FYID_REF'))
                ->where('STATUS','=','A')
                ->where('CITYID','=',$objResponse->CITYID_REF)
                ->select('CITYCODE','NAME')
                ->first();
            
            return view('masters.Common.District.mstfrm126edit',compact(['objResponse','user_approval_level','objRights','objCountryList','objCountryName','objStateName','objCityName']));
        }

    }

     
    public function update(Request $request)
    {

      // dd($request->all());

        $update_rules = [

            'NAME' => 'required',
            'CTRYID_REF' => 'required', 
            'STID_REF' => 'required', 
            'CITYID_REF' => 'required',      
        ];
        
        $req_update_data = [

            'NAME' =>   $request['NAME'],
            'CTRYID_REF' =>   $request['CTRYID_REF'],
            'STID_REF' =>   $request['STID_REF'],
            'CITYID_REF' =>   $request['CITYID_REF']

        ]; 

       
        $validator = Validator::make( $req_update_data, $update_rules, $this->messages);

        if ($validator->fails())
        {
        return Response::json(['errors' => $validator->errors()]);	
        }
    
        $DISTCODE       =   strtoupper(trim($request['DISTCODE']) );
        $NAME   =   trim($request['NAME']); 
        $CTRYID_REF   =   trim($request['CTRYID_REF']); 
        $STID_REF   =   trim($request['STID_REF']); 
        $CITYID_REF   =   trim($request['CITYID_REF']); 

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
        $ACTION     =   "EDIT";
        $IPADDRESS  =   $request->getClientIp();
        
        $array_data   = [
            $DISTCODE, $NAME,$CTRYID_REF, $STID_REF,$CITYID_REF,
            $DEACTIVATED, $DODEACTIVATED, $CYID_REF, $BRID_REF,
            $FYID_REF, $VTID, $USERID, $UPDATE,
            $UPTIME, $ACTION, $IPADDRESS
        ];

        try {

        $sp_result = DB::select('EXEC SP_DISTT_UP ?,?,?,?,?, ?,?,?,?, ?,?,?,?, ?,?,?', $array_data);
       

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
        
        $destinationPath = storage_path()."/docs/company".$CYID_REF."/DistrictMaster";

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
            return redirect()->route("master",[126,"attachment",$ATTACH_DOCNO])->with("success","No file uploaded");
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
        
        //  echo "<pre>";
        // // print_r($uploaded_data);
        // dump($attachment_data);
        
        // echo "</pre>";

       


        // echo "<pre>";
        // print_r($attachment_data);
        // dump($ATTACHMENTS_XMl);
        
        // echo "</pre>";
          
       // try {

             //save data
             $sp_result = DB::select('EXEC SP_ATTACHMENT_IN ?,?,?,?, ?,?,?,?, ?,?,?,?', $attachment_data);

           //  dd($sp_result[0]->RESULT);
      
      //  } catch (\Throwable $th) {
        
        //    return redirect()->route("master",[126,"attachment",$ATTACH_DOCNO])->with("error","There is some error. Please try after sometime");
    
      //  }
     
        if($sp_result[0]->RESULT=="SUCCESS"){

            if(trim($duplicate_files!="")){
                $duplicate_files =  " System ignored duplicated files -  ".$duplicate_files;
            }

            if(trim($invlid_files!="")){
                $invlid_files =  " Invalid files -  ".$invlid_files;
            }

            return redirect()->route("master",[126,"attachment",$ATTACH_DOCNO])->with("success","Files successfully attached. ".$duplicate_files.$invlid_files);


        }        elseif($sp_result[0]->RESULT=="Duplicate file for same records"){
       
            return redirect()->route("master",[126,"attachment",$ATTACH_DOCNO])->with("success","Duplicate file name. ".$invlid_files);
    
        }else{

            //return redirect()->route("master",[126,"attachment",$ATTACH_DOCNO])->with("error","There is some data error. Please try after sometime.  ");
            return redirect()->route("master",[126,"attachment",$ATTACH_DOCNO])->with($sp_result[0]->RESULT);
        }
      
        
    }   

  


   



    //singleApprove begin
    public function singleapprove(Request $request)
    {
      
         $approv_rules = [
 
             'NAME' => 'required', 
             'CTRYID_REF' => 'required', 
             'STID_REF' => 'required',  
             'CITYID_REF' => 'required',          
         ];
         
         $req_approv_data = [
 
             'NAME' =>   $request['NAME'],
             'CTRYID_REF' =>   $request['CTRYID_REF'],
             'STID_REF' =>   $request['STID_REF'],
             'CITYID_REF' =>   $request['CITYID_REF']
         ]; 
 
 
         $validator = Validator::make( $req_approv_data, $approv_rules, $this->messages);
 
         if ($validator->fails())
         {
         return Response::json(['errors' => $validator->errors()]);	
         }
     
         $DISTCODE       =   strtoupper(trim($request['DISTCODE']) );
         $NAME   =   trim($request['NAME']); 
         $CTRYID_REF   =   trim($request['CTRYID_REF']);
         $STID_REF   =   trim($request['STID_REF']); 
         $CITYID_REF   =   trim($request['CITYID_REF']); 

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
         $VTID       =   $this->vtid_ref;
         $USERID     =   Auth::user()->USERID;
         $UPDATE     =   Date('Y-m-d');
         
         $UPTIME     =   Date('h:i:s.u');
         $ACTION     =   trim($request['user_approval_level']);   // user approval level value
         $IPADDRESS  =   $request->getClientIp();
         
       
            $array_data   = [
            $DISTCODE, $NAME,$CTRYID_REF, $STID_REF,$CITYID_REF,
            $DEACTIVATED, $DODEACTIVATED, $CYID_REF, $BRID_REF,
            $FYID_REF, $VTID, $USERID, $UPDATE,
            $UPTIME, $ACTION, $IPADDRESS
             ];

        try {

        $sp_result = DB::select('EXEC SP_DISTT_UP ?,?,?,?,?, ?,?,?,?, ?,?,?,?, ?,?,?', $array_data);

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
            $objResponse = TblMstFrm126::where('DISTID','=',$id)->first();

            $objCountryName = DB::table('TBL_MST_COUNTRY')
                ->where('STATUS','=','A')
                ->where('CTRYID','=',$objResponse->CTRYID_REF)
                ->select('CTRYCODE','NAME')
                ->first();

            $objStateName = DB::table('TBL_MST_STATE')
                ->where('STATUS','=','A')
                ->where('STID','=',$objResponse->STID_REF)
                ->select('STCODE','NAME')
                ->first();

            $objCityName = DB::table('TBL_MST_CITY')
                ->where('STATUS','=','A')
                ->where('CITYID','=',$objResponse->CITYID_REF)
                ->select('CITYCODE','NAME')
                ->first();


            return view('masters.Common.District.mstfrm126view',compact(['objResponse','objCountryName','objStateName','objCityName']));
        }

    }
  
    public function printdata(Request $request){
        //
        $ids_data = [];
        if(isset($request->records_ids)){
            
            $ids_data = explode(",",$request->records_ids);
        }

        $objResponse = TblMstFrm126::whereIn('DISTID',$ids_data)->get();
        
        return view('masters.Common.District.mstfrm126print',compact(['objResponse']));
   }//print


   
    

    
    //display attachments form
    public function attachment($id){

        if(!is_null($id))
        {
            //EXEC [SP_APPROVAL_LAVEL] 2,114,6,4,2
            $objResponse = TblMstFrm126::where('DISTID','=',$id)->first();

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

            return view('masters.Common.District.mstfrm126attachment',compact(['objResponse','objMstVoucherType','objAttachments']));
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
            $BRID_REF   =   Session::get('BRID_REF');
            $FYID_REF   =   Session::get('FYID_REF');       
            $TABLE      =   "TBL_MST_DISTT";
            $FIELD      =   "DISTID";
            $ACTIONNAME     = $Approvallevel;
            $UPDATE     =   Date('Y-m-d');
            $UPTIME     =   Date('h:i:s.u');
            $IPADDRESS  =   $request->getClientIp();
        
        
        
        // dd($xml);
        
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

          

   //save data

        $USERID_REF =   Auth::user()->USERID;
        $VTID_REF   =   $this->vtid_ref;  //voucher type id
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');       
        $TABLE      =   "TBL_MST_DISTT";
        $FIELD      =   "DISTID";
        $ID         =   $id;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();
        
        $canceldata[0]=[
            'NT'  => 'TBL_MST_DISTT',
       ];        
       $links["TABLES"] = $canceldata; 
       $cancelxml = ArrayToXml::convert($links);

        $mst_cancel_data = [ $USERID_REF, $VTID_REF, $TABLE, $FIELD, $ID, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS ,$cancelxml];
        $sp_result = DB::select('EXEC SP_MST_CANCEL  ?,?,?,?, ?,?,?,?, ?,?,?,?', $mst_cancel_data);
        
        //dump($sp_result);
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


}