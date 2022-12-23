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
use Carbon\Carbon;

class TrnFrm554Controller extends Controller{

    protected $form_id    = 554;
    protected $vtid_ref   = 624;
    protected $view       = "transactions.Accounts.OverheadAdjustment.trnfrm";
       
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

        $FormId         =   $this->form_id;
		$CYID_REF   	=   Auth::user()->CYID_REF;
        $BRID_REF   	=   Session::get('BRID_REF');
        $FYID_REF   	=   Session::get('FYID_REF');
        $USERID_REF     =   Auth::user()->USERID; 

        $objRights      =   DB::table('TBL_MST_USERROLMAP')
                            ->where('TBL_MST_USERROLMAP.USERID_REF','=',Auth::user()->USERID)
                            ->where('TBL_MST_USERROLMAP.CYID_REF','=',Auth::user()->CYID_REF)
                            ->where('TBL_MST_USERROLMAP.BRID_REF','=',Session::get('BRID_REF'))                            
                            ->leftJoin('TBL_MST_ROLEDETAILS', 'TBL_MST_USERROLMAP.ROLLID_REF','=','TBL_MST_ROLEDETAILS.ROLLID_REF')
                            ->where('TBL_MST_ROLEDETAILS.VTID_REF','=',$this->vtid_ref)
                            ->select('TBL_MST_USERROLMAP.*', 'TBL_MST_ROLEDETAILS.*')
                            ->first();
        
        $objFinalAppr = DB::select("select dbo.FN_APRL('$this->vtid_ref','$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
        $FANO = "APPROVAL".$objFinalAppr[0]->FA_NO;

                $REQUEST_DATA   =   array(
                                'FORMID'    =>  $this->form_id,
                                'VTID_REF'  =>  $this->vtid_ref,
                                'USERID'    =>  Auth::user()->USERID,
                                'CYID_REF'  =>  Auth::user()->CYID_REF,
                                'BRID_REF'  =>  Session::get('BRID_REF'),
                                'FYID_REF'  =>  Session::get('FYID_REF'),
                            );             

                    
        $objDataList	=	DB::select("select hdr.OHID,hdr.OHNO,hdr.OHDT,hdr.TYPE,hdr.INDATE,
                            (
                            SELECT TOP 1 USR.DESCRIPTIONS FROM TBL_TRN_AUDITTRAIL AUD 
                            LEFT JOIN TBL_MST_USER USR ON AUD.USERID=USR.USERID 
                            WHERE  AUD.VID=hdr.OHID AND  AUD.CYID_REF=hdr.CYID_REF AND  AUD.BRID_REF=hdr.BRID_REF AND  
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
                            inner join TBL_TRN_OH_HDR hdr
                            on a.VID = hdr.OHID 
                            and a.VTID_REF = hdr.VTID_REF 
                            and a.CYID_REF = hdr.CYID_REF 
                            and a.BRID_REF = hdr.BRID_REF
                            where a.VTID_REF = '$this->vtid_ref'
                            and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF' AND hdr.FYID_REF='$FYID_REF'
                            and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                            ORDER BY hdr.OHID DESC ");

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

        $FormId   = $this->form_id;
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');        

        $doc_req    =   array(
            'VTID_REF'=>$this->vtid_ref,
            'HDR_TABLE'=>'TBL_TRN_OH_HDR',
            'HDR_ID'=>'OHID',
            'HDR_DOC_NO'=>'OHNO',
            'HDR_DOC_DT'=>'OHDT'
        );
        
        $docarray   =   $this->getManualAutoDocNo(date('Y-m-d'),$doc_req);

        return view($this->view.$FormId.'add',compact(['FormId','doc_req','docarray']));
    }

   
    public function save(Request $request){

        $r_count1 = $request['Row_Count'];
        $r_count3 = $request['Row_Count3'];

        $OHNO                =   trim($request['OHNO'])?trim($request['OHNO']):NULL;
        $OHDT                =   trim($request['OHDT'])?trim($request['OHDT']):NULL;
        $TYPE                =   trim($request['TYPE'])?trim($request['TYPE']):NULL;
        $SLID_REF            =   trim($request['VID_REF'])?trim($request['VID_REF']):NULL;
        $DUTY_GLID_REF       =   trim($request['DUTY_LEDGERID_REF'])?trim($request['DUTY_LEDGERID_REF']):NULL;
        $DUTY_AMOUNT         =   trim($request['DUTY_AMOUNT'])?trim($request['DUTY_AMOUNT']):0;
        $REMARKS             =   trim($request['REMARKS'])?trim($request['REMARKS']):NULL; 
        
        for ($i=0; $i<=$r_count1; $i++)
        {
            if(isset($request['ITEMID_REF_'.$i]))
            {
                $req_data[$i] = [
                    'SRNO' => $i+1,
                    'ITEMID_REF'    => $request['ITEMID_REF_'.$i],
                ];
                
                $store_data  = array();
                if(isset($_REQUEST['BATITEMID_REF']) && !empty($_REQUEST['BATITEMID_REF'])){
                    foreach($_REQUEST['BATITEMID_REF'] as $key=>$val){

                        $store_data[] = array(
                        'SERIALNO_REF'        => $i+1,
                        'ITEMID_REF'      => trim($_REQUEST['BATITEMID_REF'][$key])?trim($_REQUEST['BATITEMID_REF'][$key]):NULL,
                        'STID_REF'      => trim($_REQUEST['STID_REF'][$key])?trim($_REQUEST['STID_REF'][$key]):NULL,
                        'BATCHID_REF'      => trim($_REQUEST['BATCHID_REF'][$key])?trim($_REQUEST['BATCHID_REF'][$key]):NULL,
                        'QTY'      => trim($_REQUEST['QTY'][$key])?trim($_REQUEST['QTY'][$key]):NULL,
                        'RATE'      => trim($_REQUEST['RATE'][$key])?trim($_REQUEST['RATE'][$key]):NULL,
                        'AMOUNT'          => trim($_REQUEST['AMOUNT'][$key])?trim($_REQUEST['AMOUNT'][$key]):0,
                        'ADJUSTED_AMOUNT' => trim($_REQUEST['ADJUSTED_AMOUNT'][$key])?trim($_REQUEST['ADJUSTED_AMOUNT'][$key]):0,
                        );
                    }
                } 

                $req_data[$i]['BATCH']=$store_data;
            }
        }
        
       //DD($req_data);
            
        $wrapped_links["MAT"] = $req_data; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');    
        $USERID_REF     =   Auth::user()->USERID;   
        $VTID_REF       =   $this->vtid_ref;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "ADD";
        $IPADDRESS      =   $request->getClientIp();

        $array_data     = [$OHNO,                $OHDT,                   $TYPE,         $SLID_REF,     $DUTY_GLID_REF,      $DUTY_AMOUNT,    
                           $REMARKS,             $CYID_REF,               $BRID_REF,     $FYID_REF,     $VTID_REF,           $ACTION,            
                           $IPADDRESS,           $USERID_REF,             $UPDATE,       $UPTIME,       $XMLMAT ];

        $sp_result = DB::select('EXEC SP_OH_IN ?,?,?,?,?,?,   ?,?,?,?,?,?,  ?,?,?,?,?', $array_data);

        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');

        if($contains){
            return Response::json(['success' =>true,'msg' => $sp_result[0]->RESULT]);

        }else{
            return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
        }
        exit();    
    }

        public function edit($id){
            return $this->showRecord($id,'edit','');
        }
        public function view($id){
            return $this->showRecord($id,'view','disabled');
        }
    
        public function update(Request $request){
            return  $this->updateRecord($request,'update');        
        } 

    public function showRecord($id,$type,$ActionStatus){

        $id = urldecode(base64_decode($id));

        if(!is_null($id)){
        
            $FormId     =   $this->form_id;
            $USERID     =   Auth::user()->USERID;
            $VTID       =   $this->vtid_ref;
            $CYID_REF   =   Auth::user()->CYID_REF;
            $BRID_REF   =   Session::get('BRID_REF');
            $FYID_REF       =   Session::get('FYID_REF');


            $HDR = DB::table('TBL_TRN_OH_HDR')
                    ->where('TBL_TRN_OH_HDR.CYID_REF','=',$CYID_REF)
                    ->where('TBL_TRN_OH_HDR.BRID_REF','=',$BRID_REF)
                    ->where('TBL_TRN_OH_HDR.OHID','=',$id)
                    ->leftJoin('TBL_MST_VENDOR', 'TBL_TRN_OH_HDR.SLID_REF','=','TBL_MST_VENDOR.SLID_REF') 
                    ->leftJoin('TBL_MST_GENERALLEDGER', 'TBL_TRN_OH_HDR.DUTY_GLID_REF','=','TBL_MST_GENERALLEDGER.GLID') 
                    ->select('TBL_TRN_OH_HDR.*', 'TBL_MST_VENDOR.SLID_REF AS VSLID_REF','TBL_MST_VENDOR.VCODE','TBL_MST_VENDOR.NAME AS VNAME',
                    'TBL_MST_GENERALLEDGER.GLID','TBL_MST_GENERALLEDGER.GLCODE','TBL_MST_GENERALLEDGER.GLNAME')           
                    ->first();

            $MAT = DB::table('TBL_TRN_OH_MAT')                  
                    ->where('TBL_TRN_OH_MAT.OHID_REF','=',$id)
                    ->leftJoin('TBL_MST_ITEM', 'TBL_TRN_OH_MAT.ITEMID_REF','=','TBL_MST_ITEM.ITEMID') 
                    ->select('TBL_TRN_OH_MAT.*', 'TBL_MST_ITEM.ITEMID','TBL_MST_ITEM.ICODE','TBL_MST_ITEM.NAME AS ITEM_NAME')  
                    ->get();

            $MAT    = count($MAT) > 0 ?$MAT:[0];


            $objCount1 = count($MAT);
            $BACH = DB::table('TBL_TRN_OH_BATCH')                  
                    ->where('TBL_TRN_OH_BATCH.OHID_REF','=',$id)
                    ->leftJoin('TBL_MST_BATCH', 'TBL_TRN_OH_BATCH.BATCHID_REF','=','TBL_MST_BATCH.BATCHID') 
                    ->select('TBL_TRN_OH_BATCH.*', 'TBL_MST_BATCH.BATCHID','TBL_MST_BATCH.BATCH_CODE')  
                    ->get();

            $BACH    = count($BACH) > 0 ?$BACH:[0];
         
            $objRights = DB::table('TBL_MST_USERROLMAP')
            ->where('TBL_MST_USERROLMAP.USERID_REF','=',Auth::user()->USERID)
            ->where('TBL_MST_USERROLMAP.CYID_REF','=',Auth::user()->CYID_REF)
            ->where('TBL_MST_USERROLMAP.BRID_REF','=',Session::get('BRID_REF'))
            ->leftJoin('TBL_MST_ROLEDETAILS', 'TBL_MST_USERROLMAP.ROLLID_REF','=','TBL_MST_ROLEDETAILS.ROLLID_REF')
            ->where('TBL_MST_ROLEDETAILS.VTID_REF','=',$this->vtid_ref)
            ->select('TBL_MST_USERROLMAP.*', 'TBL_MST_ROLEDETAILS.*')
            ->first();
            
            return view($this->view.$FormId.$type,compact(['HDR','MAT','objRights','FormId','objCount1','BACH','ActionStatus']));
        }
    }



    public function updateRecord($request,$type){

        $r_count = $request['Row_Count3'];
        
        $r_count3 = $r_count-1;
        $OHNO                =   trim($request['OHNO'])?trim($request['OHNO']):NULL;
        $OHDT                =   trim($request['OHDT'])?trim($request['OHDT']):NULL;
        $TYPE                =   trim($request['TYPE'])?trim($request['TYPE']):NULL;
        $SLID_REF            =   trim($request['VID_REF'])?trim($request['VID_REF']):NULL;
        $DUTY_GLID_REF       =   trim($request['DUTY_LEDGERID_REF'])?trim($request['DUTY_LEDGERID_REF']):NULL;
        $DUTY_AMOUNT         =   trim($request['DUTY_AMOUNT'])?trim($request['DUTY_AMOUNT']):0;
        $REMARKS             =   trim($request['REMARKS'])?trim($request['REMARKS']):NULL;    

        for ($i=0; $i<=$r_count3; $i++) {

            $req_data3[$i] = [

                'SERIALNO_REF' => $i+1 ,
                'ITEMID_REF' => $request['ITEM_REF_'.$i],
                'STID_REF'    => $request['STID_REF_'.$i],                    
                'BATCHID_REF' => $request['BATCHID_REF_'.$i] ,
                'QTY' => $request['SOTCK_'.$i],
                'RATE' => $request['RATE_'.$i],
                'AMOUNT' => $request['AMOUNT_'.$i],                   
                'ADJUSTED_AMOUNT'         => $request['DISPATCH_MAIN_QTY_'.$i],
            ];

            $MaterialDetails  = array();
            if(isset($_REQUEST['ITEMID_REF']) && !empty($_REQUEST['ITEMID_REF'])){
                foreach($_REQUEST['ITEMID_REF'] as $key=>$val){

                    $MaterialDetails[] = array(
                    'SERIALNO'        => $i+1,
                    'ITEMID_REF'      => trim($_REQUEST['ITEMID_REF'][$key])?trim($_REQUEST['ITEMID_REF'][$key]):NULL,
                    'AMOUNT'          => trim($_REQUEST['BATCH_AMOUNT'][$key])?trim($_REQUEST['BATCH_AMOUNT'][$key]):0,
                    'ADJUSTED_AMOUNT' => trim($_REQUEST['ADJUST_AMOUNT'][$key])?trim($_REQUEST['ADJUST_AMOUNT'][$key]):0,
                    );
                }
            }

            $MaterialDetails[$i]['BATCH']=$req_data3;

        }

        //dd($MaterialDetails);

        $wrapped_links["MAT"] = $MaterialDetails; 
        $XMLMAT = ArrayToXml::convert($wrapped_links);

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');    
        $USERID_REF     =   Auth::user()->USERID;   
        $VTID_REF       =   $this->vtid_ref;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "EDIT";
        $IPADDRESS      =   $request->getClientIp();

        $array_data     = [$OHNO,                $OHDT,                   $TYPE,         $SLID_REF,     $DUTY_GLID_REF,      $DUTY_AMOUNT,    
                           $REMARKS,             $CYID_REF,               $BRID_REF,     $FYID_REF,     $VTID_REF,           $ACTION,            
                           $IPADDRESS,           $USERID_REF,             $UPDATE,       $UPTIME,       $XMLMAT ];

        $sp_result = DB::select('EXEC SP_OH_UP ?,?,?,?,?,?,   ?,?,?,?,?,?,  ?,?,?,?,?', $array_data);     

            $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');
    
            if($contains){
                return Response::json(['success' =>true,'msg' => $sp_result[0]->RESULT]);
    
            }else{
                return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
            }
            exit(); 
     
    }


     //Cancel the data
     public function cancel(Request $request){

        $id = $request->{0};

        $USERID =   Auth::user()->USERID;
        $VTID   =   $this->vtid_ref;  //voucher type id
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');  
        $TABLE      =   "TBL_TRN_OH_HDR";
        $FIELD      =   "OHID";
        $ID         =   $id;
        $UPDATE     =   Date('Y-m-d');
        $UPTIME     =   Date('h:i:s.u');
        $IPADDRESS  =   $request->getClientIp();

        $req_data[0]=[
            'NT'  => 'TBL_TRN_OH_MAT',
        ];

        $req_data[1]=[
            'NT'  => 'TBL_TRN_OH_BATCH',
        ];    
        
        $wrapped_links["TABLES"] = $req_data; 
        
        $XMLTAB = ArrayToXml::convert($wrapped_links);
        
        $mst_cancel_data = [ $USERID, $VTID, $TABLE, $FIELD, $ID, $CYID_REF, $BRID_REF,$FYID_REF,$UPDATE,$UPTIME, $IPADDRESS ,$XMLTAB];
        $sp_result = DB::select('EXEC SP_TRN_CANCEL  ?,?,?,?, ?,?,?,?, ?,?,?,?', $mst_cancel_data);

        if($sp_result[0]->RESULT=="CANCELED"){  
          
          return Response::json(['cancel' =>true,'msg' => 'Record successfully canceled.']);
        
        }elseif($sp_result[0]->RESULT=="NO RECORD FOR CANCEL"){
        
            
            return Response::json(['errors'=>true,'msg' => 'No record found.','norecord'=>'norecord']);
            
        }else{
           
               return Response::json(['errors'=>true,'msg' => 'Error:'.$sp_result[0]->RESULT,'invalid'=>'invalid']);
        }
        
        exit(); 

   }

   
   public function Approve(Request $request){

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

        if(!empty($sp_listing_result)) {
        foreach ($sp_listing_result as $key=>$salesenquiryitem) {  
            $record_status = 0;
            $Approvallevel = "APPROVAL".$salesenquiryitem->LAVELS;
            }
        }           

        $r_count = $request['Row_Count3'];
        
        $r_count3 = $r_count-1;
        $OHNO                =   trim($request['OHNO'])?trim($request['OHNO']):NULL;
        $OHDT                =   trim($request['OHDT'])?trim($request['OHDT']):NULL;
        $TYPE                =   trim($request['TYPE'])?trim($request['TYPE']):NULL;
        $SLID_REF            =   trim($request['VID_REF'])?trim($request['VID_REF']):NULL;
        $DUTY_GLID_REF       =   trim($request['DUTY_LEDGERID_REF'])?trim($request['DUTY_LEDGERID_REF']):NULL;
        $DUTY_AMOUNT         =   trim($request['DUTY_AMOUNT'])?trim($request['DUTY_AMOUNT']):0;
        $REMARKS             =   trim($request['REMARKS'])?trim($request['REMARKS']):NULL;    

    for ($i=0; $i<=$r_count3; $i++) {

        $req_data3[$i] = [

            'SERIALNO_REF' => $i+1 ,
            'ITEMID_REF' => $request['ITEM_REF_'.$i],
            'STID_REF'    => $request['STID_REF_'.$i],                    
            'BATCHID_REF' => $request['BATCHID_REF_'.$i] ,
            'QTY' => $request['SOTCK_'.$i],
            'RATE' => $request['RATE_'.$i],
            'AMOUNT' => $request['AMOUNT_'.$i],                   
            'ADJUSTED_AMOUNT'         => $request['DISPATCH_MAIN_QTY_'.$i],
        ];

        $MaterialDetails  = array();
        if(isset($_REQUEST['ITEMID_REF']) && !empty($_REQUEST['ITEMID_REF'])){
            foreach($_REQUEST['ITEMID_REF'] as $key=>$val){

                $MaterialDetails[] = array(
                'SERIALNO'        => $i+1,
                'ITEMID_REF'      => trim($_REQUEST['ITEMID_REF'][$key])?trim($_REQUEST['ITEMID_REF'][$key]):NULL,
                'AMOUNT'          => trim($_REQUEST['BATCH_AMOUNT'][$key])?trim($_REQUEST['BATCH_AMOUNT'][$key]):0,
                'ADJUSTED_AMOUNT' => trim($_REQUEST['ADJUST_AMOUNT'][$key])?trim($_REQUEST['ADJUST_AMOUNT'][$key]):0,
                );
            }
        }

        $MaterialDetails[$i]['BATCH']=$req_data3;

    }

    $wrapped_links["MAT"] = $MaterialDetails; 
    $XMLMAT = ArrayToXml::convert($wrapped_links);

    $CYID_REF       =   Auth::user()->CYID_REF;
    $BRID_REF       =   Session::get('BRID_REF');
    $FYID_REF       =   Session::get('FYID_REF');    
    $USERID_REF     =   Auth::user()->USERID;   
    $VTID_REF       =   $this->vtid_ref;
    $UPDATE         =   Date('Y-m-d');
    $UPTIME         =   Date('h:i:s.u');
    $ACTION         =   $Approvallevel;
    $IPADDRESS      =   $request->getClientIp();

    $array_data     = [$OHNO,                $OHDT,                   $TYPE,         $SLID_REF,     $DUTY_GLID_REF,      $DUTY_AMOUNT,    
                       $REMARKS,             $CYID_REF,               $BRID_REF,     $FYID_REF,     $VTID_REF,           $ACTION,            
                       $IPADDRESS,           $USERID_REF,             $UPDATE,       $UPTIME,       $XMLMAT ];

    $sp_result = DB::select('EXEC SP_OH_UP ?,?,?,?,?,?,   ?,?,?,?,?,?,  ?,?,?,?,?', $array_data);     

        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');

        if($contains){
            return Response::json(['success' =>true,'msg' => $sp_result[0]->RESULT]);

        }else{
            return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
        }
        exit(); 
 
}

    public function attachment($id){

        if(!is_null($id)){
        
            $FormId     =   $this->form_id;

            $objResponse = DB::table('TBL_TRN_OH_HDR')->where('OHID','=',$id)->first();

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

    $FormId   =   $this->form_id;
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
    
    $destinationPath = storage_path()."/docs/company".$CYID_REF."/OverheadAdjustment";

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
                               $uploaded_data[$index]["LOCATION"] = $destinationPath."/";
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
        return redirect()->route("transaction",[$FormId,"attachment",$ATTACH_DOCNO])->with("success","The file is already exist");
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
                                              
/*************************************  Duty Ledger Code    ****************************************************** */

        public function getDutyLedger(Request $request){
            
            $ObjData = DB::table('TBL_MST_GENERALLEDGER')
            ->where('CYID_REF','=',Auth::user()->CYID_REF)
            ->whereRaw('(DEACTIVATED IS NULL  OR DEACTIVATED = 0)')
            ->where('STATUS','=','A')
            ->get();

            if(isset($ObjData) && !empty($ObjData)){
                foreach ($ObjData as $index=>$dataRow){

                echo'
                <tr>
                    <td class="ROW1"><input type="checkbox" id="subgl_'.$dataRow->GLID .'" class="clsgenlager" value="'.$dataRow->GLID.'" ></td>
                    <td class="ROW2">'.$dataRow->GLCODE.'</td>
                    <td class="ROW3">'.$dataRow->GLNAME.'</td>
                    <td hidden><input type="hidden" id="txtsubgl_'.$dataRow->GLID.'" data-desc="'.$dataRow->GLCODE.'-'.$dataRow->GLNAME.'" data-ccname="'.$dataRow->GLNAME.'" value="'.$dataRow->GLID.'"/></td>
                </tr>
                ';
                }
            }
            else{
            echo '<tr><td colspan="2">Record not found.</td></tr>';
            }
        exit();
        }

                
/*************************************   Item Code Code    ****************************************************** */

            public function getItemDetails2(Request $request){

                $CYID_REF   =   Auth::user()->CYID_REF;
                $BRID_REF   =   Session::get('BRID_REF');
                $FYID_REF   =   Session::get('FYID_REF');

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
                
                $ObjItem = DB::select('EXEC sp_get_items_popup_enquiry ?,?,?,?,?,?,?,?,?,?,?,?', $sp_popup);
                
                $row        =   '';

                if(!empty($ObjItem)){
                    foreach ($ObjItem as $index=>$dataRow){
                    
                            $ITEMID             =   isset($dataRow->ITEMID)?$dataRow->ITEMID:NULL;
                            $ICODE              =   isset($dataRow->ICODE)?$dataRow->ICODE:NULL;
                            $NAME               =   isset($dataRow->NAME)?$dataRow->NAME:NULL;
                            $ITEM_SPECI         =   isset($dataRow->ITEM_SPECI)?$dataRow->ITEM_SPECI:NULL;
                            $MAIN_UOMID_REF     =   isset($dataRow->MAIN_UOMID_REF)?$dataRow->MAIN_UOMID_REF:NULL;
                            $Main_UOM           =   isset($dataRow->Main_UOM)?$dataRow->Main_UOM:NULL;
                            $ALT_UOMID_REF      =   isset($dataRow->ALT_UOMID_REF)?$dataRow->ALT_UOMID_REF:NULL;
                            $Alt_UOM            =   isset($dataRow->Alt_UOM)?$dataRow->Alt_UOM:NULL;
                            $FROMQTY            =   isset($dataRow->FROMQTY)?$dataRow->FROMQTY:NULL;
                            $TOQTY              =   isset($dataRow->TOQTY)?$dataRow->TOQTY:NULL;
                            $STDCOST            =   isset($dataRow->STDCOST)?$dataRow->STDCOST:NULL;
                            $GroupName          =   isset($dataRow->GroupName)?$dataRow->GroupName:NULL;
                            $Categoryname       =   isset($dataRow->Categoryname)?$dataRow->Categoryname:NULL;
                            $BusinessUnit       =   isset($dataRow->BusinessUnit)?$dataRow->BusinessUnit:NULL;
                            $ALPS_PART_NO       =   isset($dataRow->ALPS_PART_NO)?$dataRow->ALPS_PART_NO:NULL;
                            $CUSTOMER_PART_NO   =   isset($dataRow->CUSTOMER_PART_NO)?$dataRow->CUSTOMER_PART_NO:NULL;
                            $OEM_PART_NO        =   isset($dataRow->OEM_PART_NO)?$dataRow->OEM_PART_NO:NULL;

                            $MATERIAL_TYPE      =   isset($dataRow->MATERIAL_TYPE)?$dataRow->MATERIAL_TYPE:NULL;

                            
                            $SLID_REF           =   NULL;
                            $SOID_REF           =   NULL;
                            $SQA                =   NULL;
                            $SEQID_REF          =   NULL;
                            $item_unique_row_id =   $SLID_REF."_".$SOID_REF."_".$SQA."_".$SEQID_REF."_".$ITEMID;
            
                            $row.=' <tr id="item_'.$index.'"  class="clsitemid">
                            <td style="width:8%;text-align:center;"><input type="checkbox" id="item_'.$dataRow->ITEMID .'" class="js-selectall1" value="'.$dataRow->ITEMID.'" ></td>
                            <td style="width:10%;">'.$ICODE.'&nbsp;&nbsp;'.$MATERIAL_TYPE.'</td>
                            <td style="width:10%;">'.$NAME.'</td>
                            <td style="width:8%;">'.$Main_UOM.'</td>
                            <td style="width:8%;">'.$FROMQTY.'</td>
                            <td style="width:8%;">'.$GroupName.'</td>
                            <td style="width:8%;">'.$Categoryname.'</td>
                            <td style="width:8%;">'.$BusinessUnit.'</td>
                            <td style="width:8%;">'.$ALPS_PART_NO.'</td>
                            <td style="width:8%;">'.$CUSTOMER_PART_NO.'</td>
                            <td style="width:8%;">'.$OEM_PART_NO.'</td>
                            <td style="width:8%;">Authorized</td>
                            <td hidden>
                                    <input type="text" id="txtitem_'.$dataRow->ITEMID .'" 
                                        data-desc1="'.$ITEMID.'" 
                                        data-desc2="'.$ICODE.'" 
                                        data-desc3="'.$NAME.'" 
                                        data-desc4="'.$MAIN_UOMID_REF.'" 
                                        data-desc5="'.$Main_UOM.'" 
                                        data-desc6="'.$FROMQTY.'" 
                                        data-desc7="'.$item_unique_row_id.'" 
                                        data-desc8="'.$SQA.'"
                                        data-desc9="'.$SEQID_REF.'"
                                        data-desc10="'.$SLID_REF.'"
                                        data-desc11="'.$SOID_REF.'"
                                        data-desc12=""
                                        data-desc13=""
                                        data-desc14=""
                                        data-desc15=""
                                    />
                                </td>
                                <td hidden><input type="hidde" id="addinfoitem_'.$index.'"  data-desc101="'.$ALPS_PART_NO.'" data-desc102="'.$CUSTOMER_PART_NO.'" data-desc103="'.$OEM_PART_NO.'" ></td>
                            </tr>';
                } 
    
                echo $row;
                                   
            }           
            else{
                echo '<tr><td colspan="12"> Record not found.</td></tr>';
            }
            exit();

                }

             
    public function getVendor(Request $request){

        $Status     =   "A";
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $CODE       =   $request['CODE'];
        $NAME       =   $request['NAME'];
    
        $sp_popup = [
            $CYID_REF, $BRID_REF,$CODE,$NAME
        ]; 
        
        $ObjData = DB::select('EXEC sp_get_vendor_popup_enquiry ?,?,?,?', $sp_popup);
   
        if(!empty($ObjData)){
    
            foreach ($ObjData as $index=>$dataRow){

                $VID    =   $dataRow->SGLID;
                $VCODE  =   $dataRow->SGLCODE;
                $NAME   =   $dataRow->SLNAME;                
               
                $row = '';
                $row = $row.'<tr >
                <td class="ROW1"> <input type="checkbox" name="SELECT_VENDORID_REF[]" id="vendoridcode_'.$index.'"  class="clsvendorid" value="'.$VID.'" ></td>
                <td class="ROW2">'.$VCODE.'<input type="hidden" id="txtvendoridcode_'.$index.'" data-desc="'.$VCODE.'-'.$NAME.'" value="'.$VID.'" > </td>
                <td class="ROW3">'.$NAME.'</td>
                </tr>';
                echo $row;
            }
    
        }else{
            echo '<tr><td colspan="2">Record not found.</td></tr>';
        }
        exit();
    
    }

    
   public function getItemwiseStoreDetails(Request $request){

   
    $Status = 'A';
    $itemid = $request['itemid'];
    $uomid = $request['muomid'];
    $auomid = $request['auomid'];
    $soqty = $request['soqty'];
    $storeid = $request['storeid'];
    $qtyid = $request['qtyid'];

    $CYID_REF = Auth::user()->CYID_REF;
    $BRID_REF = Session::get('BRID_REF');
    $FYID_REF = Session::get('FYID_REF');

    $ITEMROWID  = $request['ITEMROWID'];
    $SOID       = $request['SOID']=='0'?'':$request['SOID'];
    $SQID       = $request['SQID'] =='0'?'':$request['SQID'];
    $SEQID      = $request['SEQID']=='0'?'':$request['SEQID'];
    
    $ACTION_TYPE    =   $request['ACTION_TYPE'] =="VIEW"?'disabled':'';

    // $ObjData =  DB::select('SELECT * FROM TBL_MST_BATCH  
    //         WHERE STATUS= ? AND CYID_REF = ? AND BRID_REF = ? AND FYID_REF = ?
    //         AND ITEMID_REF = ? AND UOMID_REF = ? 
    //         order by BATCH_CODE ASC', [$Status,$CYID_REF,$BRID_REF,$FYID_REF,$itemid,$uomid]);


    if($request['ACTION_TYPE'] =="ADD"){
        $ObjData    =   DB::table("TBL_MST_BATCH")->select('*')
                        ->where('STATUS','=','A')                    
                        ->where('CYID_REF','=',$CYID_REF)
                        ->where('BRID_REF','=',$BRID_REF)
                        ->where('ITEMID_REF','=',$itemid) 
                        //->where('UOMID_REF','=',$uomid) 
                        ->where('CURRENT_QTY','>',0) 
                        ->get() ->toArray(); 
    }
    else{
        $ObjData    =   DB::table("TBL_MST_BATCH")->select('*')
                        ->where('STATUS','=','A')                    
                        ->where('CYID_REF','=',$CYID_REF)
                        ->where('BRID_REF','=',$BRID_REF)
                        ->where('ITEMID_REF','=',$itemid) 
                        //->where('UOMID_REF','=',$uomid) 
                        ->get() ->toArray(); 
    }

    if(!empty($ObjData)){

        $dataArr    =   array();

        if($ITEMROWID !=""){
            $exp        =   explode(",",$ITEMROWID);
    
            foreach($exp as $val){
                $keyid      =   explode("_",$val);
                $batchid    =   $keyid[0];
                $qty        =   $keyid[1];
                $dataArr[$batchid]  =   $qty;
            }
        } 

        $row1 = '';
        $row2 = '<input type="hidden" id="hdnItemQty" name="hdnItemQty" value="'.$soqty.'" /> 
                    <input type="hidden" id="hdnstoreid" name="hdnstoreid" value="'.$storeid.'" />
                    <input type="hidden" id="hdnqtyid" name="hdnqtyid" value="'.$qtyid.'" />  ';
        $row3 = '';

    foreach ($ObjData as $dindex=>$dRow){

        $ObjStore = DB::select('SELECT TOP 1 * FROM TBL_MST_STORE WHERE STATUS = ?
                    AND STID = ?',[$Status,$dRow->STID_REF]);
        
        $ObjMUOM = DB::select('SELECT TOP 1 * FROM TBL_MST_UOM WHERE STATUS = ?
                    AND UOMID = ?',[$Status,$dRow->UOMID_REF]);

        $ObjAUOM = DB::select('SELECT TOP 1 * FROM TBL_MST_UOM WHERE STATUS = ?
                    AND UOMID = ?',[$Status,$auomid]);

        $ObjConv = DB::select('SELECT TOP 1 * FROM TBL_MST_ITEM_UOMCONV WHERE ITEMID_REF = ?
                    AND TO_UOMID_REF = ?',[$itemid,$auomid]);

        $StoreRowId = $SOID.$SQID.$SEQID.$itemid.$dRow->BATCHID.$dRow->UOMID_REF.$dRow->STID_REF.$dRow->STOCKID_REF;

        $qtyvalue   =   array_key_exists($StoreRowId, $dataArr)?$dataArr[$StoreRowId]:'';
        
        //$mqty       =   $ObjConv[0]->FROM_QTY;
        //$aqty       =   $ObjConv[0]->TO_QTY;

        if($qtyvalue !=""){
            $daltqty    =   ($qtyvalue);
        }
        else{
            $daltqty    =   "";
        }

        if($request['ACTION_TYPE'] =="ADD"){
            $CURRENT_QTY=$dRow->CURRENT_QTY;
        }
        else{
            $CURRENT_QTY=(floatval($dRow->CURRENT_QTY)+floatval($qtyvalue));
        }

        $QTY        =   $dRow->RATE !=""?floatval($dRow->RATE):0;
        $RATE       =   $dRow->CURRENT_QTY !=""?floatval($dRow->CURRENT_QTY):0;
    
        $AMOUNT = $QTY*$RATE; 

        
        $row = '';
        $row = $row.' <tr class="clsstrid">';
       
        $row = $row.'<td hidden><input type="hidden" name= "STORE_NAME_'.$dindex.'" id= "STORE_NAME_'.$dindex.'" class="form-control" value="'.$ObjStore[0]->NAME.'" /></td>';
        
        $row = $row.'<td hidden><input type="hidden" name= "strITEMID_REF_'.$dindex.'" id= "strITEMID_REF_'.$dindex.'" class="form-control" value="'.$itemid.'" /></td>';
        
        $row = $row.'<td hidden><input type="hidden" name= "strBATCHNO_'.$dindex.'" id= "strBATCHNO_'.$dindex.'" class="form-control" value="'.$dRow->BATCHID.'" readonly /></td>';

        $row = $row.'<td><input '.$ACTION_TYPE.' type="text" name= "strBATCHNOLOTNO_'.$dindex.'" id= "strBATCHNOLOTNO_'.$dindex.'" class="form-control" value="'.$dRow->BATCH_CODE.'" readonly /></td>';

        $row = $row.'<td hidden><input type="hidden" name= "strBATCHID_'.$dindex.'" id= "strBATCHID_'.$dindex.'" class="form-control" value="'.$StoreRowId.'"  /></td>';
        
        $row = $row.'<td hidden><input '.$ACTION_TYPE.' type="hidden" name= "STORE_REF_'.$dindex.'" id= "STORE_REF_'.$dindex.'" class="form-control" value="'.$ObjStore[0]->NAME.'" readonly /></td>';
        
        $row = $row.'<td hidden><input type="hidden" name= "strSTID_REF_'.$dindex.'" id= "strSTID_REF_'.$dindex.'" class="form-control" value="'.$dRow->STID_REF.'" /></td>';
        
        $row = $row.'<td hidden><input type="hidden" name= "MUOM_REF_'.$dindex.'" id= "MUOM_REF_'.$dindex.'" class="form-control" value="'.$dRow->UOMID_REF.'" /></td>';
        
        $row = $row.'<td hidden><input '.$ACTION_TYPE.' type="hidden" name= "strMAINUOMID_REF_'.$dindex.'" id= "strMAINUOMID_REF_'.$dindex.'" value="'.$ObjMUOM[0]->UOMCODE.'-'.$ObjMUOM[0]->DESCRIPTIONS.'" class="form-control" readonly /></td>';
        
        $row = $row.'<td><input '.$ACTION_TYPE.' type="text" name= "strSOTCK_'.$dindex.'" id= "strSOTCK_'.$dindex.'" class="form-control three-digits" value="'.$CURRENT_QTY.'" style="text-align:right;" readonly /></td>';
        
        $row = $row.'<td><input '.$ACTION_TYPE.' type="text" name= "strRATE_'.$dindex.'" style="text-align:right;" id= "strRATE_'.$dindex.'" class="form-control three-digits" value="'.$dRow->RATE.'" readonly /></td>';

        $row = $row.'<td><input '.$ACTION_TYPE.' type="text" name= "strAMOUNT_'.$dindex.'" style="text-align:right;" id= "strAMOUNT_'.$dindex.'" class="form-control three-digits" value="'.$AMOUNT.'" readonly /></td>';

        $row = $row.'<td><input '.$ACTION_TYPE.' type="text" name= "strDISPATCH_MAIN_QTY_'.$dindex.'" style="text-align:right;" id= "strDISPATCH_MAIN_QTY_'.$dindex.'" value="'.$qtyvalue.'" class="form-control three-digits" maxlength="13" onkeypress="return isNumberDecimalKey(event,this)" autocomplete="off"   /></td>';
        
        $row = $row.'<td hidden><input type="hidden" name= "CONV_MAIN_QTY_'.$dindex.'" id= "CONV_MAIN_QTY_'.$dindex.'" class="form-control three-digits" value=""  maxlength="13"   /></td>';
        
        $row = $row.'<td hidden><input type="hidden" name= "CONV_ALT_QTY_'.$dindex.'" id= "CONV_ALT_QTY_'.$dindex.'" class="form-control three-digits" value=""  maxlength="13"   /></td>';
        
        $row = $row.'<td hidden><input type="hidden" name= "AUOM_REF_'.$dindex.'" id= "AUOM_REF_'.$dindex.'" class="form-control" value="'.$auomid.'" /></td>';
        
        $row = $row.'<td hidden><input '.$ACTION_TYPE.' type="hidden" name= "strALTUOMID_REF_'.$dindex.'" style="text-align:right;" id= "strALTUOMID_REF_'.$dindex.'" value="" class="form-control" readonly /></td>';
        
        $row = $row.'<td hidden><input '.$ACTION_TYPE.' style="text-align:right;" type="hidden" name= "DISPATCH_ALT_QTY_'.$dindex.'" id= "DISPATCH_ALT_QTY_'.$dindex.'" class="form-control three-digits"  value="'.$daltqty.'" readonly /></td>';
        
        $row = $row.'</tr>';
        $row1 = $row1.$row;
        
    }

    $row3 = $row2.$row1;
    echo $row3;

//    echo ' <td colspan="3" style="text-align:right;">Total</td>

//     <td>2.00</td>
//     <td></td>
//     <td></td>
//     <td></td>
//     <td></td>';

    }else{
        echo '<tr><td colspan="7">Record not found.</td></tr>';
    }
    exit();

}







}