<?php

namespace App\Http\View\Composers;

use Auth;
use DB;
use Session;
use Illuminate\Contracts\View\View;

class LeftMenusComposer
{
    public function compose(View $view){

        $menu_data= array();

        
        
        $db_menu = DB::select('select * from VW_MENU  where userid_ref is not null AND VT_SEQUENCE is not null 
        AND userid_ref=?  AND cyid_ref = ?      order by MODULE_SEQUENCE ASC,VT_SEQUENCE ASC, ranks ASC ', 
        [Auth::user()->USERID, Auth::user()->CYID_REF,]);
        
        foreach ($db_menu as $index => $row) {

            $menu_data[$row->modulename][$row->heading][$row->formid]['moduleid']=$row->moduleid;
            $menu_data[$row->modulename][$row->heading][$row->formid]['modulename']=$row->modulename;
            $menu_data[$row->modulename][$row->heading][$row->formid]['formid']=$row->formid;
            $menu_data[$row->modulename][$row->heading][$row->formid]['formname']=$row->formname;
            $menu_data[$row->modulename][$row->heading][$row->formid]['heading']=$row->heading;
            $menu_data[$row->modulename][$row->heading][$row->formid]['vtid_ref']=$row->vtid_ref;
            $menu_data[$row->modulename][$row->heading][$row->formid]['cyid_ref']=$row->cyid_ref;
            $menu_data[$row->modulename][$row->heading][$row->formid]['brid_ref']=$row->brid_ref;
            $menu_data[$row->modulename][$row->heading][$row->formid]['fyid_ref']=$row->fyid_ref;

        }
        $view->with('menu_data',$menu_data);
		
		Session::put('save','Submitting');
		Session::put('approve','Approving');
		Session::put('report_button','Loading');
		$ssrs_config=["REPORT_URL"=>"http://103.139.58.23:8181//ReportServer/","INSTANCE_NAME"=>"/UNICORN","username"=>"Administrator","password"=>"VRt+wDPuDYLwxxC"];        
        Session::put('ssrs_config',$ssrs_config);
		
		$report_dynamic_cols    =DB::select("SELECT FIELD8,FIELD9,FIELD10 FROM TBL_MST_ADDL_TAB_SETTING WHERE TABLE_NAME='ITEM_TAB_SETTING'");
        Session::put('report_dynamic_cols',isset($report_dynamic_cols[0]) ? $report_dynamic_cols[0] : '');
		
		$DefaultCurrency = DB::select("SELECT 'Total Value in '+CONCAT(dbo.fn_titlecase(C.CRDESCRIPTION),' - (',C.CRCODE+')') AS CURRENCY from TBL_MST_COMPANY CP
        LEFT JOIN TBL_MST_CURRENCY C ON C.CRID=CP.CRID_REF
        WHERE CYID=? ", 
        [Auth::user()->CYID_REF]);
        $objCurrency=isset($DefaultCurrency[0]->CURRENCY) && $DefaultCurrency[0]->CURRENCY !="" ? $DefaultCurrency[0]->CURRENCY:'Total Value';
        Session::put('default_currency',$objCurrency);
        

    }
}