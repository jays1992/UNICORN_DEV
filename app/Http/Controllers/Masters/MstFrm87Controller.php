<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Master\TblMstFrm87;
use App\Models\Admin\TblMstUser;
use Auth;
use DB;
use Session;
use Response;
use SimpleXMLElement;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MstFrm87Controller extends Controller
{
    protected $form_id = 87;
    protected $vtid_ref   = 87;  //voucher type id
    // //validation messages
    protected   $messages = [
        'LABEL.unique' => 'Duplicate Code'
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

        $objCount = DB::table('TBL_MST_UDFFOR_SRN')
                        ->where('TBL_MST_UDFFOR_SRN.CYID_REF','=',Auth::user()->CYID_REF)
                        //->where('TBL_MST_UDFFOR_SRN.BRID_REF','=',Session::get('BRID_REF'))
                        //->where('TBL_MST_UDFFOR_SRN.FYID_REF','=',Session::get('FYID_REF'))
                        ->where('TBL_MST_UDFFOR_SRN.STATUS', '!=', 'C')
                        ->where('TBL_MST_UDFFOR_SRN.PARENTID','=', 0)
                        ->select('TBL_MST_UDFFOR_SRN.*')
                        ->count();

       

        return view('masters.inventory.UDFSRN.mstfrm87',compact(['objRights','objCount']));        
    }

    public function add(){       
        return view('masters.inventory.UDFSRN.mstfrm87add');       
   }


   //display attachments form
   public function attachment($id){

    if(!is_null($id))
    {
        $objResponse = TblMstFrm87::where('UDFSRNID','=',$id)->first();

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

            return view('masters.inventory.UDFSRN.mstfrm87attachment',compact(['objResponse','objMstVoucherType','objAttachments']));
    }

}

    
   public function save(Request $request) {
    
        $r_count = $request['Row_Count'];

        $data = [
            'UDFSRNID' => "0",
            'LABEL'    => strtoupper($request['LABEL_0']),
            'VALUETYPE' => $request['VALUETYPE_0'],
            'DESCRIPTIONS' => (isset($request->DESCRIPTIONS_0)? $request->DESCRIPTIONS_0 : ""),
            'ISMANDATORY' => (isset($request['ISMANDATORY_0'])!="true" ? 0 : 1) ,
            'DEACTIVATED' => (isset($request['DEACTIVATED_0'])!="true" ? 0 : 1) ,
            'DODEACTIVATED' => !(is_null($request['DODEACTIVATED_0'])||empty($request['DODEAC style="width:20%;">Stock-in-hand</th>
                    <th style="width:20%;text-align:left;">Qty</th>
                </tr>
            </thead>';

            echo'<tbody>';
            
            if(!empty($objBatch)){
                foreach($objBatch as $key=>$val){
                    
                    $desc6          =   $val->BATCHID;
                    $qtyvalue       =   array_key_exists($desc6, $dataArr)?$dataArr[$desc6]:0;
                    $STOCK_INHAND   =   $val->STOCK;
                    $STID_REF       =   $val->STID_REF;
                    $STORE_NAME     =   DB::SELECT("SELECT CONCAT(STCODE,'-',NAME) AS StoreName FROM TBL_MST_STORE WHERE STID='$STID_REF'")[0]->StoreName;
                
                    echo '<tr class="participantRow33">';
                    echo '<td style="width:30%;text-align:left;">'.$STORE_NAME.'</td>';
                    echo '<td style="width:30%;text-align:left;">'.$val->BATCH_CODE.'</td>';
                    echo '<td style="width:20%;">'.$STOCK_INHAND.'</td>';
                    echo '<td style="width:20%;text-align:left;"><input type="text" name="UserQty_'.$key.'" id="UserQty_'.$key.'" value="'.$qtyvalue.'" class="qtytext" onkeyup="checkStoreQty('.$ROW_ID.','.$qtyvalue.',this.value,'.$key.','.$ITEMID_REF.')" autocomplete="off"  onkeypress="return isNumberDecimalKey(event,this)" '.$READONLY.' ></td>';
                    echo '<td hidden><input type="hidden" name="BATCHID_'.$key.'" id="BATCHID_'.$key.'" value="'.$desc6.'" class="qtytext" ></td>';
                    echo '</tr>';
                }
            }
            else{
                echo '<tr class="participantRow33"><td colspan="4" style="text-align:left">No data available in store</td></tr>';
            }
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
            return '0';
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

    public function getStockQty($BATCH_CODE,$SERIALNO,$STID_REF,$ITEMID_REF,$UOMID_REF){

        $CYID_REF   = Auth::user()->CYID_REF;
        $BRID_REF   = Session::get('BRID_REF');
        $FYID_REF   = Session::get('FYID_REF');

        if($BATCH_CODE !="" && $SERIALNO ==""){
            $ObjData =  DB::table('TBL_MST_BATCH')
            ->where('BATCH_CODE','=',$BATCH_CODE)
            ->where('STID_REF','=',$STID_REF)
            ->where('ITEMID_REF','=',$ITEMID_REF)
            ->where('UOMID_REF','=',$UOMID_REF)
            ->where('CYID_REF','=',$CYID_REF)
            ->where('BRID_REF','=',$BRID_REF)
            ->where('STATUS','=',"A")
            ->select('CURRENT_QTY')
            ->first();
        }
        else if($SERIALNO !="" && $BATCH_CODE ==""){
            $ObjData =  DB::table('TBL_MST_BATCH')
            ->where('SERIALNO','=',$SERIALNO)
            ->where('STID_REF','=',$STID_REF)
            ->where('ITEMID_REF','=',$ITEMID_REF)
            ->where('UOMID_REF','=',$UOMID_REF)
            ->where('CYID_REF','=',$CYID_REF)
            ->where('BRID_REF','=',$BRID_REF)
            ->where('STATUS','=',"A")
            ->select('CURRENT_QTY')
            ->first();
        }
        else if($BATCH_CODE !="" && $SERIALNO !=""){
            $ObjData =  DB::table('TBL_MST_BATCH')
            ->where('BATCH_CODE','=',$BATCH_CODE)
            ->where('SERIALNO','=',$SERIALNO)
            ->where('STID_REF','=',$STID_REF)
            ->where('ITEMID_REF','=',$ITEMID_REF)
            ->where('UOMID_REF','=',$UOMID_REF)
            ->where('CYID_REF','=',$CYID_REF)
            ->where('BRID_REF','=',$BRID_REF)
            ->where('STATUS','=',"A")
            ->select('CURRENT_QTY')
            ->first();
        }
        
        if(!empty($ObjData)){
            return $ObjData->CURRENT_QTY;
        }else{
            return '0';
        }

    }

    public function getAddressDetails(Request $request){

        $ADDRESS        =   NULL;
        $GST_NO         =   NULL;
        $COUNTRY_ID     =   NULL;
        $COUNTRY_NAME   =   NULL;
        $STATE_ID       =   NULL;
        $STATE_NAME     =   NULL;
        $CITY_ID        =   NULL;
        $CITY_NAME      =   NULL;

        if(isset($request['id']) && $request['id'] !=''){

            $SLID_REF                   =   $request['id'];
            $TBL_MST_CUSTOMER_VENDOR    =   DB::table('TBL_MST_CUSTOMER')->where('STATUS','=','A')->where('SLID_REF','=',$SLID_REF)->select('CID AS CVID')->first();

            if(isset($request['TRANSFER_TYPE']) && $request['TRANSFER_TYPE'] === "IN"){
                $TBL_MST_CUSTOMER_VENDOR    =   DB::table('TBL_MST_VENDOR')->where('STATUS','=','A')->where('SLID_REF','=',$SLID_REF)->select('VID AS CVID')->first();
            }
            
            if(isset($TBL_MST_CUSTOMER_VENDOR->CVID) && $TBL_MST_CUSTOMER_VENDOR->CVID !=''){

                $CVID_REF                       =   $TBL_MST_CUSTOMER_VENDOR->CVID;
                $TBL_MST_CUSTOMER_VENDOR_LOC    =   DB::select("SELECT top 1 
                                                    T1.CADD AS ADDRESS, 
                                                    T1.GSTIN AS GST_NO, 
                                                    T2.CTRYID AS COUNTRY_ID,
                                                    T2.NAME AS COUNTRY_NAME, 
                                                    T3.STID AS STATE_ID, 
                                                    T3.NAME AS STATE_NAME, 
                                                    T4.CITYID AS CITY_ID,
                                                    T4.NAME AS CITY_NAME
                                                    FROM TBL_MST_CUSTOMERLOCATION T1  
                                                    LEFT JOIN TBL_MST_COUNTRY T2 ON T1.CTRYID_REF=T2.CTRYID
                                                    LEFT JOIN TBL_MST_STATE T3 ON T1.STID_REF=T3.STID
                                                    LEFT JOIN TBL_MST_CITY T4 ON T1.CITYID_REF=T4.CITYID
                                                    WHERE T1.DEFAULT_BILLTO= 1 AND T1.CID_REF = '$CVID_REF'
                                                    ");

                if(isset($request['TRANSFER_TYPE']) && $request['TRANSFER_TYPE'] === "IN"){
                    $TBL_MST_CUSTOMER_VENDOR_LOC    =   DB::select("SELECT top 1 
                                                        T1.LADD AS ADDRESS, 
                                                        T1.GSTIN AS GST_NO, 
                                                        T2.CTRYID AS COUNTRY_ID,
                                                        T2.NAME AS COUNTRY_NAME, 
                                                        T3.STID AS STATE_ID, 
                                                        T3.NAME AS STATE_NAME, 
                                                        T4.CITYID AS CITY_ID,
                                                        T4.NAME AS CITY_NAME
                                                        FROM TBL_MST_VENDORLOCATION T1  
                                                        LEFT JOIN TBL_MST_COUNTRY T2 ON T1.CTRYID_REF=T2.CTRYID
                                                        LEFT JOIN TBL_MST_STATE T3 ON T1.STID_REF=T3.STID
                                                        LEFT JOIN TBL_MST_CITY T4 ON T1.CITYID_REF=T4.CITYID
                                                        WHERE T1.DEFAULT_BILLING= 1 AND T1.VID_REF = '$CVID_REF'
                                                        ");
                }

                if(isset($TBL_MST_CUSTOMER_VENDOR_LOC) && !empty($TBL_MST_CUSTOMER_VENDOR_LOC)){

                    $ADDRESS        =   $TBL_MST_CUSTOMER_VENDOR_LOC[0]->ADDRESS;
                    $GST_NO         =   $TBL_MST_CUSTOMER_VENDOR_LOC[0]->GST_NO;
                    $COUNTRY_ID     =   $TBL_MST_CUSTOMER_VENDOR_LOC[0]->COUNTRY_ID;
                    $COUNTRY_NAME   =   $TBL_MST_CUSTOMER_VENDOR_LOC[0]->COUNTRY_NAME;
                    $STATE_ID       =   $TBL_MST_CUSTOMER_VENDOR_LOC[0]->STATE_ID;
                    $STATE_NAME     =   $TBL_MST_CUSTOMER_VENDOR_LOC[0]->STATE_NAME;
                    $CITY_ID        =   $TBL_MST_CUSTOMER_VENDOR_LOC[0]->CITY_ID;
                    $CITY_NAME      =   $TBL_MST_CUSTOMER_VENDOR_LOC[0]->CITY_NAME;

                }

            }

        }

        $DATA   =   array(
                        'ADDRESS'       =>  $ADDRESS,
                        'GST_NO'        =>  $GST_NO,
                        'COUNTRY_ID'    =>  $COUNTRY_ID,
                        'COUNTRY_NAME'  =>  $COUNTRY_NAME,
                        'STATE_ID'      =>  $STATE_ID,
                        'STATE_NAME'    =>  $STATE_NAME,
                        'CITY_ID'       =>  $CITY_ID,
                        'CITY_NAME'     =>  $CITY_NAME
                    );

        return Response::json($DATA);
        exit();   
    }

    public function getBranch(Request $request){

        $CYID_REF           =   Auth::user()->CYID_REF;
        $TBL_MST_BRANCH    =   DB::select("SELECT BRID,BRCODE,BRNAME 
                                FROM TBL_MST_BRANCH 
                                WHERE STATUS='A' AND CYID_REF='$CYID_REF' AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 )
                                ");

        if(isset($TBL_MST_BRANCH) && !empty($TBL_MST_BRANCH)){
            foreach ($TBL_MST_BRANCH as $index=>$dataRow){

            echo'
            <tr>
                <td class="ROW1"><input type="checkbox" id="subgl_'.$dataRow->BRID .'" class="clsbranch" value="'.$dataRow->BRID.'" ></td>
                <td class="ROW2">'.$dataRow->BRCODE.'</td>
                <td class="ROW3">'.$dataRow->BRNAME.'</td>
                <td hidden><input type="hidden" id="txtsubgl_'.$dataRow->BRID.'" data-desc="'.$dataRow->BRNAME .'" data-ccname="'.$dataRow->BRNAME.'" value="'.$dataRow->BRID.'"/></td>
            </tr>
            ';
            }
        }
        else{
            echo '<tr><td>Record not found.</td></tr>';
        }
        exit();
    }

    public function getTransferOutNo(Request $request){

        $CYID_REF               =   Auth::user()->CYID_REF;
        $BRID_REF               =   Session::get('BRID_REF');
        $TBL_TRN_STOCK_TRNF_HDR =   DB::select("SELECT STID,STNO,STDT 
                                    FROM TBL_TRN_STOCK_TRNF_HDR 
                                    WHERE STATUS='A' AND CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF'
                                    ");

        if(isset($TBL_TRN_STOCK_TRNF_HDR) && !empty($TBL_TRN_STOCK_TRNF_HDR)){
            foreach ($TBL_TRN_STOCK_TRNF_HDR as $index=>$dataRow){

            echo'
            <tr>
                <td class="ROW1"><input type="checkbox" id="subgl_'.$dataRow->STID .'" class="clstransferoutno" value="'.$dataRow->STID.'" ></td>
                <td class="ROW2">'.$dataRow->STNO.'</td>
                <td class="ROW3">'.$dataRow->STDT.'</td>
                <td hidden><input type="hidden" id="txtsubgl_'.$dataRow->STID.'" data-desc="'.$dataRow->STNO .'" data-ccname="'.$dataRow->STDT.'" value="'.$dataRow->STID.'"/></td>
            </tr>
            ';
            }
        }
        else{
            echo '<tr><td>Record not found.</td></tr>';
        }
        exit();
    }
    
    public function getCountry(Request $request){

        $CYID_REF           =   Auth::user()->CYID_REF;
        $TBL_MST_COUNTRY    =   DB::select("SELECT CTRYID,CTRYCODE,NAME
                                FROM TBL_MST_COUNTRY 
                                WHERE STATUS='A' AND CYID_REF='$CYID_REF' AND ( DEACTIVATED IS NULL OR DEACTIVATED = 0 ) 
                                ");

        if(isset($TBL_MST_COUNTRY) && !empty($TBL_MST_COUNTRY)){
            foreach ($TBL_MST_COUNTRY as $index=>$dataRow){

            echo'
            <tr>
                <td class="ROW1"><input type="checkbox" id="subgl_'.$dataRow->CTRYID .'" class="clscontry" value="'.$dataRow->CTRYID.'" ></td>
                <td class="ROW2">'.$dataRow->CTRYCODE.'</td>
                <td class="ROW3">'.$dataRow->NAME.'</td>
                <td hidden><input type="hidden" id="txtsubgl_'.$dataRow->CTRYID.'" data-desc="'.$dataRow->CTRYCODE .'" data-ccname="'.$dataRow->NAME.'" value="'.$dataRow->CTRYID.'"/></td>
            </tr>
            ';
            }
        }
        else{
            echo '<tr><td>Record not found.</td></tr>';
        }
        exit();
    }

    public function getState(Request $request){

        $objStateList   =   DB::table('TBL_MST_STATE')
                            ->where('STATUS','=','A')
                            ->where('CTRYID_REF','=',$request['CTRYID_REF'])
                            ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
                            ->select('STID','NAME','STCODE')
                            ->get();

       
    
        if(isset($objStateList) && count($objStateList) > 0){
            foreach($objStateList as $state){
            
                echo '<tr>
                <td class="ROW1"> <input type="checkbox" name="SELECT_STID_REF[]" id="stidref_'.$state->STID.'" class="cls_stidref" value="'.$state->STID.'" ></td>
                <td class="ROW2">'.$state->STCODE.'<input type="hidden" id="txtstidref_'.$state->STID.'" data-desc="'.$state->STCODE.'-'.$state->NAME.'" data-descname="'.$state->NAME.'" value="'.$state->STID.'" /></td>
                <td class="ROW3">'.$state->NAME.'</td>
                </tr>';
            }
        }
        else{
            echo '<tr><td>Record not found.</td></tr>';
        }
        exit();
    }

    public function getCity(Request $request){
    
        $objCityList    =   DB::table('TBL_MST_CITY')
                            ->where('STATUS','=','A')
                            ->where('CTRYID_REF','=',$request['CTRYID_REF'])
                            ->where('STID_REF','=',$request['STID_REF'])
                            ->whereRaw("(DEACTIVATED=0 or DEACTIVATED is null)")
                            ->select('CITYID','CITYCODE','NAME')
                            ->get();

        if(isset($objCityList) && count($objCityList) > 0){
            foreach($objCityList as $city){
            
                echo '<tr>
                <td class="ROW1"> <input type="checkbox" name="SELECT_CITYID_REF[]" id="cityidref_'.$city->CITYID.'" class="cls_cityidref" value="'.$city->CITYID.'" ></td>
                <td class="ROW2">'.$city->CITYCODE.'<input type="hidden" id="txtcityidref_'.$city->CITYID.'"  data-desc="'.$city->CITYCODE.'-'.$city->NAME.'" data-descname="'.$city->NAME.'"  value="'.$city->CITYID.'" /></td>
                <td class="ROW3">'.$city->NAME.'</td>
                </tr>';
            }
        }
        else{
            echo '<tr><td>Record not found.</td></tr>';
        }

        exit();
    }

    public function getDocType(Request $request){

        $VTID_REF   =   $request['DOC_TYPE'];
        $STATUS     =   "A";
        $CYID_REF   =   Auth::user()->CYID_REF;
        $BRID_REF   =   Session::get('BRID_REF');
        $FYID_REF   =   Session::get('FYID_REF');
        $DOC_NO     =   NULL;
        $DOC_LEN    =   '';

        $objSON     =   DB::table('TBL_MST_DOCNO_DEFINITION')
                        ->where('VTID_REF','=',$VTID_REF)
                        ->where('CYID_REF','=',$CYID_REF)
                        ->where('BRID_REF','=',$BRID_REF)
                        ->where('FYID_REF','=',$FYID_REF)
                        ->where('STATUS','=',$STATUS)
                        ->select('TBL_MST_DOCNO_DEFINITION.*')
                        ->first();

        if( isset($objSON->SYSTEM_GRSR) && $objSON->SYSTEM_GRSR == "1"){
            
            if($objSON->PREFIX_RQ == "1")
            {
                $DOC_NO = $objSON->PREFIX;
            }        
            if($objSON->PRE_SEP_RQ == "1")
            {
                if($objSON->PRE_SEP_SLASH == "1")
                {
                $DOC_NO = $DOC_NO.'/';
                }
                if($objSON->PRE_SEP_HYPEN == "1")
                {
                $DOC_NO = $DOC_NO.'-';
                }
            }        
            if($objSON->NO_MAX)
            {   
                $DOC_NO = $DOC_NO.str_pad($objSON->LAST_RECORDNO+1, $objSON->NO_MAX, "0", STR_PAD_LEFT);
            }
            
            if($objSON->NO_SEP_RQ == "1")
            {
                if($objSON->NO_SEP_SLASH == "1")
                {
                $DOC_NO = $DOC_NO.'/';
                }
                if($objSON->NO_SEP_HYPEN == "1")
                {
                $DOC_NO = $DOC_NO.'-';
                }
            }
            if($objSON->SUFFIX_RQ == "1")
            {
                $DOC_NO = $DOC_NO.$objSON->SUFFIX;
            }
        }
        else if(isset($objSON->MANUAL_SR) && $objSON->MANUAL_SR == "1"){
            $DOC_NO     =   NULL;
            $DOC_LEN    =   isset($objSON->MANUAL_MAXLENGTH)?$objSON->MANUAL_MAXLENGTH:'';
        }

        $DATA   =   array('DOC_NO'=>$DOC_NO,'DOC_LEN'=>$DOC_LEN);

        return Response::json($DATA);
        exit();   
    }



    
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

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

class TrnFrm483Controller extends Controller{

    protected $form_id    = 483;
    protected $vtid_ref   = 553;
    protected $view       = "transactions.PreSales.FollowUp.trnfrm";
       
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

        $objRights      =   $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);
        
        $FormId         =   $this->form_id;
        $ldvtid_ref     =   509;
		$CYID_REF   	=   Auth::user()->CYID_REF;
        $BRID_REF   	=   Session::get('BRID_REF');
        $FYID_REF   	=   Session::get('FYID_REF');     


        $objFinalAppr = DB::select("select dbo.FN_APRL('$this->vtid_ref','$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
        $FANO = "APPROVAL".$objFinalAppr[0]->FA_NO;

        $objDataList = DB::table('TBL_TRN_LEAD_GENERATION')
                                ->leftJoin('TBL_MST_CUSTOMER', 'TBL_TRN_LEAD_GENERATION.CUSTOMER_PROSPECT','=','TBL_MST_CUSTOMER.SLID_REF')
                                ->leftJoin('TBL_MST_PROSPECT', 'TBL_TRN_LEAD_GENERATION.CUSTOMER_PROSPECT','=','TBL_MST_PROSPECT.PID')
                                ->leftJoin('TBL_MST_EMPLOYEE', 'TBL_TRN_LEAD_GENERATION.LEADOWNERID_REF','=','TBL_MST_EMPLOYEE.EMPID')
                                ->where('TBL_TRN_LEAD_GENERATION.VTID_REF','=',$ldvtid_ref)
                                ->where('TBL_TRN_LEAD_GENERATION.CYID_REF','=',$CYID_REF)
                                ->where('TBL_TRN_LEAD_GENERATION.BRID_REF','=',$BRID_REF)
                                ->where('TBL_TRN_LEAD_GENERATION.FYID_REF','=',$FYID_REF)                    
                                ->select('TBL_TRN_LEAD_GENERATION.*','TBL_MST_CUSTOMER.SLID_REF','TBL_MST_CUSTOMER.NAME AS CUSTNAME','TBL_MST_PROSPECT.PID',
                                'TBL_MST_PROSPECT.NAME AS PROSPTNAME','TBL_MST_EMPLOYEE.FNAME','TBL_MST_EMPLOYEE.MNAME','TBL_MST_EMPLOYEE.LNAME')
                                ->orderBy('TBL_TRN_LEAD_GENERATION.LEAD_ID','DESC')
                                ->get();

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
   
    
    public function add($id=NULL){ 

        $id = urldecode(base64_decode($id));

        $FormId   = $this->form_id;
        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');

        $doc_req    =   array(
            'VTID_REF'=>$this->vtid_ref,
            'HDR_TABLE'=>'TBL_TRN_LEAD_GENERATION',
            'HDR_ID'=>'LEAD_ID',
            'HDR_DOC_NO'=>'LEAD_NO',
            'HDR_DOC_DT'=>'LEAD_DT'
        );
        $docarray   =   $this->getManualAutoDocNo(date('Y-m-d'),$doc_req);

        $objDD = DB::table('TBL_MST_DOCNO_DEFINITION')
        ->where('VTID_REF','=',$this->vtid_ref)
        ->where('CYID_REF','=',$CYID_REF)
        ->where('BRID_REF','=',$BRID_REF)
        ->where('STATUS','=','A')
        ->select('TBL_MST_DOCNO_DEFINITION.*')
        ->first();

        $objResponse = DB::table('TBL_TRN_LEAD_GENERATION')
        ->where('CYID_REF','=',$CYID_REF)
        ->where('LEAD_ID','=',$id)
        ->select('TBL_TRN_LEAD_GENERATION.*')
        ->first();

            $CUSTOMER_TYPE = $objResponse->CUSTOMER_TYPE;
            if($CUSTOMER_TYPE ==="Customer"){
            $objCustProspt = DB::table('TBL_TRN_LEAD_GENERATION')
                            ->where('TBL_TRN_LEAD_GENERATION.CYID_REF','=',$CYID_REF)
                            ->where('TBL_TRN_LEAD_GENERATION.BRID_REF','=',$BRID_REF)
                            ->where('LEAD_ID','=',$id)
                            ->leftJoin('TBL_MST_CUSTOMER', 'TBL_TRN_LEAD_GENERATION.CUSTOMER_PROSPECT','=','TBL_MST_CUSTOMER.SLID_REF')         
                            ->select('TBL_MST_CUSTOMER.SLID_REF','TBL_MST_CUSTOMER.CCODE','TBL_MST_CUSTOMER.NAME AS CUSTNAME')
                            ->first();
            }else{
            $objCustProspt = DB::table('TBL_TRN_LEAD_GENERATION')
                            ->where('TBL_TRN_LEAD_GENERATION.CYID_REF','=',$CYID_REF)
                            ->where('TBL_TRN_LEAD_GENERATION.BRID_REF','=',$BRID_REF)
                            ->where('LEAD_ID','=',$id)
                            ->leftJoin('TBL_MST_PROSPECT', 'TBL_TRN_LEAD_GENERATION.CUSTOMER_PROSPECT','=','TBL_MST_PROSPECT.PID')
                            ->select('TBL_MST_PROSPECT.PID','TBL_MST_PROSPECT.PCODE','TBL_MST_PROSPECT.NAME AS PROSNAME')
                            ->first();
            }


            $MAT = DB::select("SELECT T1.*,T2.*,T3.*,T4.* FROM TBL_TRN_LEAD_ACTIVITY T1
            LEFT JOIN TBL_MST_ACTIVITY_TYPE T2 ON T1.ACTIVITYID_REF=T2.ID
            LEFT JOIN TBL_MST_RESPONSE_TYPE T3 ON T1.RESPONSEID_REF=T3.ID
            LEFT JOIN TBL_MST_EMPLOYEE      T4 ON T1.ALERT_TO=T4.EMPID
            WHERE T1.LEADID_REF='$id' ORDER BY T1.ACTIVITY_ID DESC");

            if(isset($MAT) && !empty($MAT)){
                foreach($MAT as $key=>$val){

                    $ADDITIONAL_EMPLOYEE_ID       =   $val->ADDITIONAL_EMPLOYEE_ID;

                    if($ADDITIONAL_EMPLOYEE_ID !=""){
                        $LEADACT_DATA = DB::select("select distinct stuff((select ',' + t.[FNAME] from TBL_MST_EMPLOYEE t where EMPID in($ADDITIONAL_EMPLOYEE_ID) order by t.[FNAME] for xml path('') ),1,1,'') as CODE_NAME from TBL_MST_EMPLOYEE t1 where EMPID in($ADDITIONAL_EMPLOYEE_ID)"); 
                        $CODE_NAME =   isset($LEADACT_DATA[0]->CODE_NAME) && $LEADACT_DATA[0]->CODE_NAME !=""?$LEADACT_DATA[0]->CODE_NAME:NULL; 
                        $MAT[$key]->CODE_NAME=$CODE_NAME;
                    }
                }
            }
            $MAT    = count($MAT) > 0 ?$MAT:[0];

        return view($this->view.$FormId.'add',compact(['objDD','objResponse','FormId','MAT','objCustProspt']));
    }

   
    public function save(Request $request){

        $ACTIVITYID_REF            =   trim($request['ACTIVITYID_REF'])?trim($request['ACTIVITYID_REF']):NULL;
        $ACTIVITY_DATE             =   trim($request['ACTITITY_DATE'])?trim($request['ACTITITY_DATE']):NULL;
        $CONTACT_PERSON            =   trim($request['CONTACTPERSON'])?trim($request['CONTACTPERSON']):NULL;
        $REMINDER_DETAIL           =   trim($request['REMNDETAIL_REF'])?trim($request['REMNDETAIL_REF']):NULL;
        $ADDITIONAL_EMPLOYEE_ID    =   trim($request['ADDMEMBERVISIT_REF'])?trim($request['ADDMEMBERVISIT_REF']):NULL;
        $RESPONSEID_REF            =   trim($request['RESPONSEID_REF'])?trim($request['RESPONSEID_REF']):NULL;
        $ACTIVITY_DETAILS          =   trim($request['ACTYDETAIL'])?trim($request['ACTYDETAIL']):NULL;
        $ACTION_PLAN               =   trim($request['ACTYNAMEPLAN'])?trim($request['ACTYNAMEPLAN']):NULL;
        $LEAD_ID                   =   trim($request['LEAD_ID'])?trim($request['LEAD_ID']):NULL;
        
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');    
        $USERID_REF     =   Auth::user()->USERID;   
        $VTID_REF       =   $