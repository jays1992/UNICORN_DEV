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

class TrnFrm1001Controller extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function check_approval_level(Request $request){

        $REQUEST_DATA   =   $request['REQUEST_DATA'];
        $RECORD_ID      =   $request['RECORD_ID'];
        $result         =   Helper::check_approval_level($REQUEST_DATA,$RECORD_ID);

        echo $result;
        exit();
    }

    public function getDocNoByEvent(Request $request){

        $REQUEST        =   $request['doc_req'];
        $DATE           =   $request['REQUEST_DATA'];
        $MONTH          =   date('m',strtotime($DATE));
        $YEAR           =   date('Y',strtotime($DATE));
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF'); 
        $VTID_REF       =   $REQUEST['VTID_REF'];
        $SETTING_TYPE   =   $REQUEST['SETTING_TYPE'];
        $HDR_TABLE      =   $REQUEST['HDR_TABLE'];
        $HDR_ID         =   $REQUEST['HDR_ID'];
        $HDR_DOC_NO     =   $REQUEST['HDR_DOC_NO'];
        $HDR_DOC_DT     =   $REQUEST['HDR_DOC_DT'];

        $AM_DOC_NO      =   $this->getManualAutoDocNo($DATE,$REQUEST);
        $DOC_NO         =   $AM_DOC_NO['DOC_NO'];

        $MAX_DOC_DT    =   DB::select("SELECT 
        MAX($HDR_DOC_DT) MAX_DOC_DT 
        FROM $HDR_TABLE 
        WHERE  CYID_REF ='$CYID_REF' AND BRID_REF ='$BRID_REF'  
        AND FYID_REF ='$FYID_REF' AND VTID_REF ='$VTID_REF' 
        AND MONTH($HDR_DOC_DT)='$MONTH' AND YEAR($HDR_DOC_DT)='$YEAR'
        ");
        
        $FLAG   =   true;
        if(isset($MAX_DOC_DT[0]->MAX_DOC_DT) && $MAX_DOC_DT[0]->MAX_DOC_DT !=''){
            $FLAG   =   strtotime($DATE) >= strtotime($MAX_DOC_DT[0]->MAX_DOC_DT)?true:false;
        }

        return Response::json(['FLAG'=>$FLAG,'DOC_NO' =>  $DOC_NO]);
        exit();
    }
    
}
