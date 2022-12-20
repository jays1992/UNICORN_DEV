<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\Helper;
use Auth;
use DB;
use Session;
use Response;


class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUserRights($REQUEST){

        $USERID         =   Auth::user()->USERID;
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF'); 
        $VTID_REF       =   $REQUEST['VTID_REF'];

        return   DB::table('TBL_MST_USERROLMAP')
                ->where('TBL_MST_USERROLMAP.USERID_REF','=',$USERID)
                ->where('TBL_MST_USERROLMAP.CYID_REF','=',$CYID_REF)
                ->where('TBL_MST_USERROLMAP.BRID_REF','=',$BRID_REF)
                ->leftJoin('TBL_MST_ROLEDETAILS', 'TBL_MST_USERROLMAP.ROLLID_REF','=','TBL_MST_ROLEDETAILS.ROLLID_REF')
                ->where('TBL_MST_ROLEDETAILS.VTID_REF','=',$VTID_REF)
                ->select('TBL_MST_USERROLMAP.*', 'TBL_MST_ROLEDETAILS.*')
                ->first();
    }

    public function getManualAutoDocNo($DATE,$REQUEST){

        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF'); 
        $VTID_REF       =   $REQUEST['VTID_REF'];
        $HDR_TABLE      =   $REQUEST['HDR_TABLE'];
        $HDR_ID         =   $REQUEST['HDR_ID'];
        $HDR_DOC_NO     =   $REQUEST['HDR_DOC_NO'];
        $HDR_DOC_DT     =   $REQUEST['HDR_DOC_DT'];
		
		//dd($BRID_REF);

        $OBJ_DOC = DB::table('TBL_MST_DOCNO_DEFINITION')
        ->where('VTID_REF','=',$VTID_REF)
        ->where('CYID_REF','=',$CYID_REF)
        ->where('BRID_REF','=',$BRID_REF)
        ->where('FYID_REF','=',$FYID_REF)
        ->where('STATUS','=','A')
        ->select('TBL_MST_DOCNO_DEFINITION.*')
        ->first();
        
        $READONLY   =   'readonly';
        $MAXLENGTH  =   100;
        $DOC_NO     =   NULL;
        if(isset($OBJ_DOC->SYSTEM_GRSR) && $OBJ_DOC->SYSTEM_GRSR == "1"){

            $PREFIX         =   $OBJ_DOC->PREFIX_RQ == "1"?$OBJ_DOC->PREFIX:NULL;
            $PRE_SEP_SLASH  =   $OBJ_DOC->PRE_SEP_RQ == "1" && $OBJ_DOC->PRE_SEP_SLASH == "1"?'/':NULL;
            $PRE_SEP_HYPEN  =   $OBJ_DOC->PRE_SEP_RQ == "1" && $OBJ_DOC->PRE_SEP_HYPEN == "1"?'-':NULL;
            $NO_MAX         =   $OBJ_DOC->NO_MAX; 
            $NO_SEP_SLASH   =   $OBJ_DOC->NO_SEP_RQ == "1" && $OBJ_DOC->NO_SEP_SLASH == "1"?'/':NULL;
            $NO_SEP_HYPEN   =   $OBJ_DOC->NO_SEP_RQ == "1" && $OBJ_DOC->NO_SEP_HYPEN == "1"?'-':NULL;
            $SUFFIX         =   $OBJ_DOC->SUFFIX_RQ == "1"?$OBJ_DOC->SUFFIX:NULL;  

            if($OBJ_DOC->DOC_SERIES_TYPE ==="MONTH"){

                $MONTH  =   date('m',strtotime($DATE));
                $YEAR   =   date('Y',strtotime($DATE));

                $OBJ_HDR = DB::select("SELECT TOP 1 $HDR_DOC_NO 
                FROM $HDR_TABLE 
                WHERE CYID_REF='$CYID_REF' AND BRID_REF='$BRID_REF' AND FYID_REF='$FYID_REF' AND MONTH($HDR_DOC_DT)='$MONTH' AND YEAR($HDR_DOC_DT)='$YEAR' 
                ORDER BY $HDR_ID DESC");

                $LAST_RECORDNO  =   0;
                if(isset($OBJ_HDR) && !empty($OBJ_HDR)){
                    $strlen         =   strlen($PREFIX.$PRE_SEP_SLASH.$PRE_SEP_HYPEN.$MONTH);
                    $substr         =   substr($OBJ_HDR[0]->$HDR_DOC_NO,$strlen);
                    $substr         =   substr($substr,0,$OBJ_DOC->NO_MAX);
                    $LAST_RECORDNO  =   intval($substr);  
                }
                $AUTO_NO    = $MONTH.str_pad($LAST_RECORDNO+1, $OBJ_DOC->NO_MAX, "0", STR_PAD_LEFT);

            }
            else{
                $AUTO_NO    =   str_pad($OBJ_DOC->LAST_RECORDNO+1, $OBJ_DOC->NO_MAX, "0", STR_PAD_LEFT);
            }

            $DOC_NO         =   $PREFIX.$PRE_SEP_SLASH.$PRE_SEP_HYPEN.$AUTO_NO.$NO_SEP_SLASH.$NO_SEP_HYPEN.$SUFFIX;             
        }
        else if(isset($OBJ_DOC->MANUAL_SR) && $OBJ_DOC->MANUAL_SR == "1"){
            $READONLY   =   'readonly';
            $MAXLENGTH  =   $OBJ_DOC->MANUAL_MAXLENGTH;
        }
  
        $FY_FLAG    =   $this->checkFinancialYear($DATE);
        $FY_FLAG    =   $DOC_NO !=''?$FY_FLAG:false;
        $DOC_NO     =   $FY_FLAG ==true?$DOC_NO:NULL;

        $docarray =   array(
            'DOC_NO'=>$DOC_NO,
            'READONLY'=>$READONLY,
            'MAXLENGTH'=>$MAXLENGTH,
            'FY_FLAG'=>$FY_FLAG 
        );

        return $docarray;
    }
    
    function checkFinancialYear($selected_date){

        $data   =   DB::table('TBL_MST_FYEAR')
        ->where('CYID_REF','=',Auth::user()->CYID_REF)
        //->where('BRID_REF','=',Session::get('BRID_REF'))                                       
        ->where('FYID','=',Session::get('FYID_REF'))                                     
        ->first();

        $flag   =   false;
        if(!empty($data)){
            $start_date     =   strtotime($data->FYSTYEAR.'-'. $data->FYSTMONTH.'-01');
            $end_date       =   strtotime($data->FYENDYEAR.'-'. $data->FYENDMONTH.'-31');
            $selected_date  =   strtotime($selected_date);

            if ($start_date <= $selected_date && $selected_date <= $end_date){
                $flag   = true;
            }
        }
        return $flag;
    }

    public function AlpsStatus(){
        $formid     =   $this->form_id;
        $count      =   DB::table('TBL_MST_ADDL_TAB_SETTING')
                        ->where('CYID_REF','=',Auth::user()->CYID_REF)
                        ->where('TABLE_NAME','=','ADD_ITEM_FIELD_TYPE')
                        ->where('TAB_NAME','=','YES')
                        ->count();

        $readonly   =   '';
        $colspan    =   '';

        switch ($formid) {
            case "38":
            $colspan    =   $count > 0 ?'7':'4';
            break;

            case "43":
            $colspan    =   $count > 0 ?'7':'4';
            break;

            case "44":
            $colspan    =   $count > 0 ?'7':'4';
            break;

            case "45":
            $colspan    =   $count > 0 ?'6':'3';
            break;

            case "306":
            $colspan    =   $count > 0 ?'6':'3';
            break;

            case "307":
            $colspan    =   $count > 0 ?'6':'3';
            break;

            case "378":
            $colspan    =   $count > 0 ?'11':'8';
            break;
        }

        $disabled   =   $count > 0 ?'disabled':'';
        $hidden     =   $count > 0 ?'':'hidden';
        $readonly   =   $count > 0 ?'readonly':'';

        return array(
            'hidden'=>$hidden,
            'disabled'=>$disabled,
            'colspan'=>$colspan,
            'readonly'=>$readonly
        );

    }
    
    public function loadItemMaster($request){
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');

        $taxstate       =   trim($request['taxstate']);
        $ATYPE          =   isset($request['ATYPE']) && $request['ATYPE'] !=''?$request['ATYPE']:'';
        $CODE           =   trim($request['CODE']);
        $NAME           =   trim($request['NAME']);
        $MUOM           =   trim($request['MUOM']);
        $GROUP          =   trim($request['GROUP']);
        $CTGRY          =   trim($request['CTGRY']);
        $BUNIT          =   trim($request['BUNIT']);
        $APART          =   trim($request['APART']);
        $CPART          =   trim($request['CPART']);
        $OPART          =   trim($request['OPART']);

        if($taxstate =="OutofState"){
            $taxqry="
            isnull((select top 1 j.NRATE from TBL_MST_HSNNORMAL j (nolock) inner join TBL_MST_TAXTYPE k(nolock) on j.TAXID_REF = k.TAXID and k.STATUS='A' and k.OUTOFSTATE = 1 where j.HSNID_REF = I.HSNID_REF ),0.00) as Taxid1, 
            '0.00' as Taxid2
            ";
        }
        else{
            $taxqry="
            isnull((select top 1 j.NRATE from TBL_MST_HSNNORMAL j (nolock) inner join TBL_MST_TAXTYPE k(nolock) on j.TAXID_REF = k.TAXID and k.STATUS='A' and k.WITHINSTATE = 1 where j.HSNID_REF = I.HSNID_REF order by HSNNID),0.00) as Taxid1,                     
            isnull((select top 1 j.NRATE from TBL_MST_HSNNORMAL j (nolock) inner join TBL_MST_TAXTYPE k(nolock) on j.TAXID_REF = k.TAXID and k.STATUS='A' and k.WITHINSTATE = 1 where j.HSNID_REF = I.HSNID_REF order by HSNNID desc),0.00) as Taxid2 
            ";
        }

        $WHERE_ATYPE    =   $ATYPE =='SALES'?" AND I.MATERIAL_TYPE <> 'RM-Raw Material'":'';

        $WHERE_CODE     =   $CODE !=''?" AND I.ICODE LIKE '%$CODE%'":'';
        $WHERE_NAME     =   $NAME !=''?" AND I.NAME LIKE '%$NAME%'":'';
        $WHERE_MUOM     =   $MUOM !=''?" AND U.UOMCODE LIKE '%$MUOM%'":'';
        $WHERE_GROUP    =   $GROUP !=''?" AND IG.GROUPCODE LIKE '%$GROUP%'":'';
        $WHERE_CTGRY    =   $CTGRY !=''?" AND IC.ICCODE LIKE '%$CTGRY%'":'';
        $WHERE_BUNIT    =   $BUNIT !=''?" AND B.BUCODE LIKE '%$BUNIT%'":'';
        $WHERE_APART    =   $APART !=''?" AND I.ALPS_PART_NO LIKE '%$APART%'":'';
        $WHERE_CPART    =   $CPART !=''?" AND I.CUSTOMER_PART_NO LIKE '%$CPART%'":'';
        $WHERE_OPART    =   $OPART !=''?" AND I.OEM_PART_NO LIKE '%$OPART%'":'';

        $WHERE_CLAUSE   =   trim($WHERE_CODE.$WHERE_NAME.$WHERE_MUOM.$WHERE_GROUP.$WHERE_CTGRY.$WHERE_BUNIT.$WHERE_APART.$WHERE_CPART.$WHERE_OPART);
        $LIMIT          =   $WHERE_CLAUSE ==''?'TOP 10':'';

        $data = DB::select("SELECT $LIMIT
        I.ITEMID,
        I.ICODE,
        I.NAME AS INAME,
        I.ITEM_SPECI,
        I.MAIN_UOMID_REF,
        I.ALT_UOMID_REF,
        I.ITEMGID_REF,
        I.ICID_REF,
        I.BUID_REF,
        I.ALPS_PART_NO,
        I.CUSTOMER_PART_NO,
        I.OEM_PART_NO,
        I.ITEM_TYPE,
        I.OFFER_STATUS,
        I.STDCOST,
        U.UOMCODE,
        U.DESCRIPTIONS AS UOM_DESCRIPTIONS,
        AU.UOMCODE AS ALT_UOMCODE,
        AU.DESCRIPTIONS AS ALT_UOM_DESCRIPTIONS,
        B.BUCODE,
        B.BUNAME,
        IG.GROUPCODE,
        IG.GROUPNAME,
        IC.ICCODE,
        IC.DESCRIPTIONS AS IC_DESCRIPTIONS,
        UC.FROM_QTY AS FROMQTY,
        UC.TO_QTY AS TOQTY,
        $taxqry
        FROM TBL_MST_ITEM AS I
        LEFT JOIN TBL_MST_UOM U ON I.MAIN_UOMID_REF=U.UOMID
        LEFT JOIN TBL_MST_UOM AU ON I.ALT_UOMID_REF=AU.UOMID
        LEFT JOIN TBL_MST_BUSINESSUNIT B ON I.BUID_REF=B.BUID
        LEFT JOIN TBL_MST_ITEMGROUP IG ON I.ITEMGID_REF=IG.ITEMGID
        LEFT JOIN TBL_MST_ITEMCATEGORY IC ON I.ICID_REF=IC.ICID
        LEFT JOIN TBL_MST_ITEM_UOMCONV UC ON I.ITEMID=UC.ITEMID_REF AND I.ALT_UOMID_REF=UC.TO_UOMID_REF
        WHERE I.CYID_REF='$CYID_REF' AND I.BRID_REF='$BRID_REF' AND I.STATUS='A' AND I.DEACTIVATED ='0' $WHERE_ATYPE $WHERE_CLAUSE
        ");
        return Response::json($data);
    } 

	public function GetMonthlyBudget($DATE,$GLID_REF){

        $CYID_REF = Auth::user()->CYID_REF;
        $BRID_REF = Session::get('BRID_REF');
        $FYID_REF = Session::get('FYID_REF');
        $MONTH = date('m', strtotime($DATE));
        $month=array(); 
        $data=DB::select("SELECT F.FYSTMONTH,M.* FROM TBL_MST_BUDGET_MAT M 
        LEFT JOIN TBL_MST_BUDGET_HDR H ON H.BUGID=M.BUGID_REF
        LEFT JOIN TBL_MST_FYEAR F ON F.FYID=H.FYID_REF
        WHERE M.GLID_REF=$GLID_REF AND H.CYID_REF=$CYID_REF AND H.BRID_REF=$BRID_REF AND H.FYID_REF=$FYID_REF AND H.STATUS='A' 
        "); 
    
        if(isset($data[0]->FYSTMONTH) && $data[0]->FYSTMONTH==04){
        
        $month[]=array(
        "04"=>$data[0]->MONTH1,
        "05"=>$data[0]->MONTH2,
        "06"=>$data[0]->MONTH3,
        "07"=>$data[0]->MONTH4,
        "08"=>$data[0]->MONTH5,
        "09"=>$data[0]->MONTH6,
        "10"=>$data[0]->MONTH7,
        "11"=>$data[0]->MONTH8,
        "12"=>$data[0]->MONTH9,
        "01"=>$data[0]->MONTH10,
        "02"=>$data[0]->MONTH11,
        "03"=>$data[0]->MONTH12,
        ); 
    
    }else if(isset($data[0]->FYSTMONTH)){
    $month[]=array(
        "01"=>$data[0]->MONTH1,
        "02"=>$data[0]->MONTH2,
        "03"=>$data[0]->MONTH3,
        "04"=>$data[0]->MONTH4,
        "05"=>$data[0]->MONTH5,
        "06"=>$data[0]->MONTH6,
        "07"=>$data[0]->MONTH7,
        "08"=>$data[0]->MONTH8,
        "09"=>$data[0]->MONTH9,
        "10"=>$data[0]->MONTH10,
        "11"=>$data[0]->MONTH11,
        "12"=>$data[0]->MONTH12,
        ); 
    
    }
            
            
           $result= isset($month[0]["$MONTH"]) ? $month[0]["$MONTH"] : ''; 
           return $result; 
    }


    public function GetCurrencyMaster(){
        $Status='A';
        $d_currency = DB::table('TBL_MST_COMPANY')
        ->where('STATUS','=',$Status)
        ->where('CYID','=',Auth::user()->CYID_REF)
        ->select('TBL_MST_COMPANY.CRID_REF')
        ->first();
        $objcurrency = $d_currency->CRID_REF;

        $objothcurrency = DB::table('TBL_MST_CURRENCY')
        ->where('STATUS','=',$Status)
        ->where('CRID','<>',$objcurrency)
        ->select('TBL_MST_CURRENCY.*')
        ->get()
        ->toArray();

        return $objothcurrency; 


    }
}
