       = $this->AssignedToEmplyee();
        $activitytype   = $this->ActivityType();
        $resp           = $this->Response();
        $tasktype       = $this->TaskType();
        $leadsource     = $this->LeadSource();
        $leadstatus     = $this->LeadStatus();
        $priorty        = $this->Priority();
        $conctprsn      = $this->ContactPerson(); 

        
        $objResponse = DB::table('TBL_TRN_LEAD_GENERATION')
                        ->where('TBL_TRN_LEAD_GENERATION.CYID_REF','=',$CYID_REF)
                        ->where('TBL_TRN_LEAD_GENERATION.BRID_REF','=',$BRID_REF)
                        ->where('LEAD_ID','=',$id)
                        ->leftJoin('TBL_MST_COUNTRY', 'TBL_TRN_LEAD_GENERATION.CTRYID_REF','=','TBL_MST_COUNTRY.CTRYID')
                        ->leftJoin('TBL_MST_STATE', 'TBL_TRN_LEAD_GENERATION.STID_REF','=','TBL_MST_STATE.STID')
                        ->leftJoin('TBL_MST_CITY', 'TBL_TRN_LEAD_GENERATION.CITYID_REF','=','TBL_MST_CITY.CITYID')
                        ->leftJoin('TBL_MST_EMPLOYEE', 'TBL_TRN_LEAD_GENERATION.LEADOWNERID_REF','=','TBL_MST_EMPLOYEE.EMPID')
                        ->leftJoin('TBL_MST_INDUSTRYTYPE', 'TBL_TRN_LEAD_GENERATION.INDSID_REF','=','TBL_MST_INDUSTRYTYPE.INDSID')
                        ->leftJoin('TBL_MST_LEAD_SOURCE', 'TBL_TRN_LEAD_GENERATION.LEAD_SOURCE','=','TBL_MST_LEAD_SOURCE.ID')
                        ->leftJoin('TBL_MST_LEAD_STATUS', 'TBL_TRN_LEAD_GENERATION.LEAD_STATUS','=','TBL_MST_LEAD_STATUS.ID')
                        ->leftJoin('TBL_MST_OPPORTUNITY_TYPE', 'TBL_TRN_LEAD_GENERATION.OPPORTUNITY_TYPE_ID','=','TBL_MST_OPPORTUNITY_TYPE.ID')
                        ->leftJoin('TBL_MST_OPPORTUNITY_STAGE', 'TBL_TRN_LEAD_GENERATION.OPPORTUNITY_STAGE_ID','=','TBL_MST_OPPORTUNITY_STAGE.ID')
                        ->select('TBL_TRN_LEAD_GENERATION.*','TBL_MST_OPPORTUNITY_TYPE.ID AS OPPTYTYPEID','TBL_MST_OPPORTUNITY_TYPE.OPPORTUNITY_TYPECODE','TBL_MST_OPPORTUNITY_TYPE.OPPORTUNITY_TYPENAME','TBL_MST_OPPORTUNITY_STAGE.ID','TBL_MST_OPPORTUNITY_STAGE.OPPORTUNITY_STAGECODE',
                        'TBL_MST_OPPORTUNITY_STAGE.OPPORTUNITY_STAGENAME','TBL_MST_OPPORTUNITY_STAGE.COMPLETE_PERCENT','TBL_MST_COUNTRY.CTRYID','TBL_MST_COUNTRY.CTRYCODE','TBL_MST_COUNTRY.NAME AS CONTRYNAME','TBL_MST_STATE.STID','TBL_MST_STATE.STCODE','TBL_MST_STATE.NAME AS STATENAME','TBL_MST_CITY.CITYID','TBL_MST_CITY.CITYCODE','TBL_MST_CITY.NAME AS CITYNAME',
                        'TBL_MST_EMPLOYEE.EMPID','TBL_MST_EMPLOYEE.EMPCODE','TBL_MST_EMPLOYEE.FNAME', 'TBL_MST_INDUSTRYTYPE.INDSID','TBL_MST_INDUSTRYTYPE.INDSCODE','TBL_MST_INDUSTRYTYPE.DESCRIPTIONS', 
                        'TBL_MST_LEAD_SOURCE.ID AS LEADSID','TBL_MST_LEAD_SOURCE.LEAD_SOURCECODE','TBL_MST_LEAD_SOURCE.LEAD_SOURCENAME','TBL_MST_LEAD_STATUS.ID AS LEADSTUSID','TBL_MST_LEAD_STATUS.LEAD_STATUSCODE','TBL_MST_LEAD_STATUS.LEAD_STATUSNAME')
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

            $MAT = DB::table('TBL_TRN_LEAD_BLOCK_DET')                  
                        ->where('TBL_TRN_LEAD_BLOCK_DET.LEADID_REF','=',$id)
                        ->get();
                        $MAT    = count($MAT) > 0 ?$MAT:[0];
            
            $MATSITE = DB::table('TBL_TRN_LEAD_SITE_DET') 
                        ->leftJoin('TBL_MST_STATE', 'TBL_TRN_LEAD_SITE_DET.STID_REF','=','TBL_MST_STATE.STID')
                        ->leftJoin('TBL_MST_CITY', 'TBL_TRN_LEAD_SITE_DET.CITYID_REF','=','TBL_MST_CITY.CITYID')
                        ->where('TBL_TRN_LEAD_SITE_DET.LEADID_REF','=',$id)
                        ->select('TBL_TRN_LEAD_SITE_DET.*', 'TBL_MST_STATE.STID','TBL_MST_STATE.STCODE','TBL_MST_STATE.NAME','TBL_MST_CITY.CITYID','TBL_MST_CITY.CITYCODE','TBL_MST_CITY.NAME AS CITYNAME')
                        ->get();
                        $MATSITE    = count($MATSITE) > 0 ?$MATSITE:[0];
            
            $MATNEWCALL = DB::select("SELECT T1.*,T2.*,T3.* FROM TBL_TRN_LEAD_ACTIVITY T1
                        LEFT JOIN TBL_MST_ACTIVITY_TYPE T2 ON T1.ACTIVITYID_REF=T2.ID
                        LEFT JOIN TBL_MST_RESPONSE_TYPE T3 ON T1.RESPONSEID_REF=T3.ID
                        WHERE T1.LEADID_REF='$id' ORDER BY T1.ACTIVITY_ID ASC");
            
                        if(isset($MATNEWCALL) && !empty($MATNEWCALL)){
                            foreach($MATNEWCALL as $key=>$val){
            
                                $ADDITIONAL_EMPLOYEE_ID       =   $val->ADDITIONAL_EMPLOYEE_ID;
                                $ALERT_TO                     =   $val->ALERT_TO;
            
                                if($ADDITIONAL_EMPLOYEE_ID !=""){
                                    $LEADACT_DATA = DB::select("select distinct stuff((select ',' + t.[FNAME] from TBL_MST_EMPLOYEE t where EMPID in($ADDITIONAL_EMPLOYEE_ID) order by t.[FNAME] for xml path('') ),1,1,'') as FNAME from TBL_MST_EMPLOYEE t1 where EMPID in($ADDITIONAL_EMPLOYEE_ID)"); 
                                    $FNAME =   isset($LEADACT_DATA[0]->FNAME) && $LEADACT_DATA[0]->FNAME !=""?$LEADACT_DATA[0]->FNAME:NULL; 
                                    $MATNEWCALL[$key]->FNAME=$FNAME;
                                }
            
                                if($ALERT_TO !=""){
                                    $LEADALTO_DATA = DB::select("select distinct stuff((select ',' + t.[FNAME] from TBL_MST_EMPLOYEE t where EMPID in($ALERT_TO) order by t.[FNAME] for xml path('') ),1,1,'') as ALTFNAME from TBL_MST_EMPLOYEE t1 where EMPID in($ALERT_TO)"); 
                                    $ALTFNAME =   isset($LEADALTO_DATA[0]->ALTFNAME) && $LEADALTO_DATA[0]->ALTFNAME !=""?$LEADALTO_DATA[0]->ALTFNAME:NULL; 
                                    $MATNEWCALL[$key]->ALTFNAME=$ALTFNAME;
                                }
                            }
                        }
                        $MATNEWCALL    = count($MATNEWCALL) > 0 ?$MATNEWCALL:[0];
            
                        //dd($MATNEWCALL);
            
            $NEWTASKS = DB::table('TBL_TRN_LEAD_TASK')
                        ->leftJoin('TBL_MST_EMPLOYEE', 'TBL_TRN_LEAD_TASK.TASK_ASSIGNTO_REF','=','TBL_MST_EMPLOYEE.EMPID')
                        ->where('TBL_TRN_LEAD_TASK.LEADID_REF','=',$id)
                        ->select('TBL_TRN_LEAD_TASK.*', 'TBL_MST_EMPLOYEE.EMPID','TBL_MST_EMPLOYEE.EMPCODE','TBL_MST_EMPLOYEE.FNAME')
                        ->get();
                        $NEWTASKS    = count($NEWTASKS) > 0 ?$NEWTASKS:[0];
            
            $PRODUCTDETAILS = DB::table('TBL_TRN_LEAD_PRODUCT') 
                        ->leftJoin('TBL_MST_ITEM', 'TBL_TRN_LEAD_PRODUCT.ITEMID_REF','=','TBL_MST_ITEM.ITEMID')
                        ->where('TBL_TRN_LEAD_PRODUCT.LEADID_REF','=',$id)
                        ->select('TBL_TRN_LEAD_PRODUCT.*', 'TBL_MST_ITEM.ITEMID','TBL_MST_ITEM.ICODE','TBL_MST_ITEM.NAME')
                        ->get();
                        $PRODUCTDETAILS    = count($PRODUCTDETAILS) > 0 ?$PRODUCTDETAILS:[0];

            $objRights = $this->getUserRights(['VTID_REF'=>$this->vtid_ref]);


            $FormId         =   $this->form_id;
            $CYID_REF   	=   Auth::user()->CYID_REF;
            $BRID_REF   	=   Session::get('BRID_REF');
            $FYID_REF   	=   Session::get('FYID_REF');     


        $objFinalAppr = DB::select("select dbo.FN_APRL('$this->vtid_ref','$CYID_REF','$BRID_REF','$FYID_REF') as FA_NO");
        $FANO = "APPROVAL".$objFinalAppr[0]->FA_NO;
            $objDataList	=	DB::select("select hdr.LEAD_ID,hdr.LEAD_NO,hdr.LEAD_DT,hdr.INDATE,
                            (
                            SELECT TOP 1 USR.DESCRIPTIONS FROM TBL_TRN_AUDITTRAIL AUD 
                            LEFT JOIN TBL_MST_USER USR ON AUD.USERID=USR.USERID 
                            WHERE  AUD.VID=hdr.LEAD_ID AND  AUD.CYID_REF=hdr.CYID_REF AND  AUD.BRID_REF=hdr.BRID_REF AND  
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
                            inner join TBL_TRN_LEAD_GENERATION hdr
                            on a.VID = hdr.LEAD_ID 
                            and a.VTID_REF = hdr.VTID_REF 
                            and a.CYID_REF = hdr.CYID_REF 
                            and a.BRID_REF = hdr.BRID_REF
                            where a.VTID_REF = '$this->vtid_ref'
                            and hdr.CYID_REF='$CYID_REF' AND hdr.BRID_REF='$BRID_REF'
                            and a.ACTID in (select max(ACTID) from TBL_TRN_AUDITTRAIL b where a.VTID_REF = b.VTID_REF and a.VID = b.VID)
                            ORDER BY hdr.LEAD_ID DESC ");

                            $REQUEST_DATA   =   array(
                                'FORMID'    =>  $this->form_id,
                                'VTID_REF'  =>  $this->vtid_ref,
                                'USERID'    =>  Auth::user()->USERID,
                                'CYID_REF'  =>  Auth::user()->CYID_REF,
                                'BRID_REF'  =>  Session::get('BRID_REF'),
                                'FYID_REF'  =>  Session::get('FYID_REF'),
                            );

                            $design         = $this->Designation();

                $objResp = DB::table('TBL_TRN_LEAD_GENERATION')
                            ->where('TBL_TRN_LEAD_GENERATION.CYID_REF','=',$CYID_REF)
                            ->where('TBL_TRN_LEAD_GENERATION.BRID_REF','=',$BRID_REF)
                            ->where('LEAD_ID','=',$id)
                            ->leftJoin('TBL_MST_EMPLOYEE', 'TBL_TRN_LEAD_GENERATION.ASSIGNTO_REF','=','TBL_MST_EMPLOYEE.EMPID')
                            ->leftJoin('TBL_MST_CUSTOMER', 'TBL_TRN_LEAD_GENERATION.DEALERID_REF','=','TBL_MST_CUSTOMER.SLID_REF')
                            ->select('TBL_TRN_LEAD_GENERATION.*','TBL_MST_EMPLOYEE.EMPID AS ASSGNTOID','TBL_MST_EMPLOYEE.EMPCODE AS ASSGNTOCODE','TBL_MST_EMPLOYEE.FNAME AS ASSGNTOFNAME',
                            'TBL_MST_CUSTOMER.SLID_REF AS DOSLID_REF','TBL_MST_CUSTOMER.CCODE AS DOCNO','TBL_MST_CUSTOMER.NAME AS DEALERNAME')
                            ->first();

            return view($this->view.$FormId.'add',compact(['objDD','emplyee','leadsource','conctprsn','priorty','leadstatus','activitytype','resp','tasktype','MAT',
            'MATSITE','MATNEWCALL','NEWTASKS','PRODUCTDETAILS','objResponse','objDataList','objRights','FormId','design','objResp','country','objCustProspt']));          
    }   

   
    public function save(Request $request){


        $LEAD_DT                =   trim($request['LEAD_DT']);
        $CUSTOMER_TYPE          =   trim($request['CUSTOMER_TYPE']);
        $CUSTOMER_PROSPECT      =   trim($request['CUSTOMER_PROSPECT']);
        $COMPANY_NAME           =   trim($request['COMPANY_NAME']);
        $FIRST_NAME             =   trim($request['FNAME']);
        $LAST_NAME              =   trim($request['LNAME']);

        $LEADOWNERID_REF        =   trim($request['LOWNERID_REF']);
        $INDSID_REF             =   trim($request['INTYPEID_REF']);
        $DESGINATION            =   trim($request['DESIGNID_REF']);
        $LANDLINE_NUMBER        =   trim($request['LANDNUMBER']);
        $MOBILE_NUMBER          =   trim($request['MOBILENUMBER']);
        $EMAIL                  =   trim($request['EMAIL']);
        $LEAD_SOURCE            =   trim($request['LSOURCEID_REF']);
        $LEAD_STATUS            =   trim($request['LSTATUSID_REF']);
        $ASSIGNTO_REF           =   trim($request['ASSIGTOID_REF']);
        $ADDRESS                =   trim($request['ADDRESS']);
        $CITYID_REF             =   trim($request['CITYID_REF']);
        $STID_REF               =   trim($request['STATEID_REF']);
        $CTRYID_REF             =   trim($request['COUNTRYID_REF']);
        $PINCODE                =   trim($request['PINCODE']);

        $DetailBlock  = array();
        if(isset($_REQUEST['TITAL']) && !empty($_REQUEST['TITAL'])){
            foreach($_REQUEST['TITAL'] as $key=>$val){

                $DetailBlock[] = array(
                'TITLE'                 => trim($_REQUEST['TITAL'][$key])?trim($_REQUEST['TITAL'][$key]):NULL,
                'FIRST_NAME'            => trim($_REQUEST['FIRSTNAME'][$key])?trim($_REQUEST['FIRSTNAME'][$key]):NULL,
                'LAST_NAME'             => trim($_REQUEST['LASTNAME'][$key])?trim($_REQUEST['LASTNAME'][$key]):NULL,
                'DESGINATION'           => trim($_REQUEST['DESIG'][$key])?trim($_REQUEST['DESIG'][$key]):NULL,
                'MOBILE_NUMBER'         => trim($_REQUEST['MOBILE'][$key])?trim($_REQUEST['MOBILE'][$key]):NULL,
                'EMAIL'                 => trim($_REQUEST['EMAILS'][$key])?trim($_REQUEST['EMAILS'][$key]):NULL,
                );
            }
        }

        //dd($DetailBlock);
    
        if(!empty($DetailBlock)){
            $wrapped_linksdb["BLOCK"] = $DetailBlock; 
            $XMLBLOCK = ArrayToXml::convert($wrapped_linksdb);
        }
        else{
            $XMLBLOCK = NULL; 
        }


        $SiteDetails  = array();
        if(isset($_REQUEST['SITENAME']) && !empty($_REQUEST['SITENAME'])){
            foreach($_REQUEST['SITENAME'] as $key=>$val){

                $SiteDetails[] = array(
                'SITENAME'               => trim($_REQUEST['SITENAME'][$key])?trim($_REQUEST['SITENAME'][$key]):NULL,
                'ADDRESS1'               => trim($_REQUEST['ADDRESS1'][$key])?trim($_REQUEST['ADDRESS1'][$key]):NULL,
                'ADDRESS2'               => trim($_REQUEST['ADDRESS2'][$key])?trim($_REQUEST['ADDRESS2'][$key]):NULL,
                'CTRYID_REF'             => trim($_REQUEST['CTRYID_REF'][$key])?trim($_REQUEST['CTRYID_REF'][$key]):NULL,
                'STID_REF'               => trim($_REQUEST['STATEIDREF'][$key])?trim($_REQUEST['STATEIDREF'][$key]):NULL,
                'CITYID_REF'             => trim($_REQUEST['CITYIDREF'][$key])?trim($_REQUEST['CITYIDREF'][$key]):NULL,
                'PINCODE'                => trim($_REQUEST['PINCODES'][$key])?trim($_REQUEST['PINCODES'][$key]):NULL,
                'CONTACT_NUMBER'         => trim($_REQUEST['PHONENO'][$key])?trim($_REQUEST['PHONENO'][$key]):NULL,
                'MOBILE_NUMBER'          => trim($_REQUEST['MOBILENO'][$key])?trim($_REQUEST['MOBILENO'][$key]):NULL,
                );
            }
        }

        //dd($SiteDetails);
    
        if(!empty($SiteDetails)){
            $wrapped_linkssd["SITE"] = $SiteDetails; 
            $XMLSITE = ArrayToXml::convert($wrapped_linkssd);
        }
        else{
            $XMLSITE = NULL; 
        }

        $NewCall  = array();
        if(isset($_REQUEST['ACTIVITYIDREF']) && !empty($_REQUEST['ACTIVITYIDREF'])){
            foreach($_REQUEST['ACTIVITYIDREF'] as $key=>$val){

                $NewCall[] = array(
                'ACTIVITYID_REF'            => trim($_REQUEST['ACTIVITYIDREF'][$key])?trim($_REQUEST['ACTIVITYIDREF'][$key]):0,
                'ACTIVITY_DATE'             => trim($_REQUEST['ACTYDATE'][$key])?trim($_REQUEST['ACTYDATE'][$key]):NULL,
                'CONTACT_PERSON'            => trim($_REQUEST['CONTACTPERSON'][$key])?trim($_REQUEST['CONTACTPERSON'][$key]):NULL,
                'ACTIVITY_DETAILS'          => trim($_REQUEST['ACTYDETAIL'][$key])?trim($_REQUEST['ACTYDETAIL'][$key]):NULL,
                'RESPONSEID_REF'            => trim($_REQUEST['RESPONSE'][$key])?trim($_REQUEST['RESPONSE'][$key]):0,
                'ACTION_PLAN'               => trim($_REQUEST['ACTPLAN'][$key])?trim($_REQUEST['ACTPLAN'][$key]):NULL,
                'REMINDER_DETAIL'           => trim($_REQUEST['REMNDETAILID_REF'][$key])?trim($_REQUEST['REMNDETAILID_REF'][$key]):NULL,
                'REMINDER_DATE'             => trim($_REQUEST['REMNDDATE'][$key])?trim($_REQUEST['REMNDDATE'][$key]):NULL,
                'ALERT_MESSAGE'             => trim($_REQUEST['ALERTMSG'][$key])?trim($_REQUEST['ALERTMSG'][$key]):NULL,
                'ALERT_TO'                  => trim($_REQUEST['ALERTTOID_REF'][$key])?trim($_REQUEST['ALERTTOID_REF'][$key]):NULL,
                'ACTIVITY_TIME'             => trim(date('H:i:s',strtotime($_REQUEST['ACTIVITYTIME'][$key])))?trim(date('H:i:s',strtotime($_REQUEST['ACTIVITYTIME'][$key]))):NULL,
                'REMINDER_TIME'             => trim(date('H:i:s',strtotime($_REQUEST['REMINDERTIME'][$key])))?trim(date('H:i:s',strtotime($_REQUEST['REMINDERTIME'][$key]))):NULL,
                'ADDITIONAL_EMPLOYEE_ID'    => trim($_REQUEST['ADDMEMBERVISITID_REF'][$key])?trim($_REQUEST['ADDMEMBERVISITID_REF'][$key]):NULL,
                'EXPENSE_DETAILS'           => trim($_REQUEST['EXPDETAILS'][$key])?trim($_REQUEST['EXPDETAILS'][$key]):NULL,
                'TENTATIVE_EXPENSES'        => trim($_REQUEST['TENTEXPAMT'][$key])?trim($_REQUEST['TENTEXPAMT'][$key]):0,
                );
            }
        }

        //dd($NewCall);
    
        if(!empty($NewCall)){
            $wrapped_linksnc["ACTIVITY"] = $NewCall; 
            $XMLACTIVITY = ArrayToXml::convert($wrapped_linksnc);
        }
        else{
            $XMLACTIVITY = NULL; 
        }


        $NewTasks  = array();
        if(isset($_REQUEST['TASKTYPEID_REF']) && !empty($_REQUEST['TASKTYPEID_REF'])){
            foreach($_REQUEST['TASKTYPEID_REF'] as $key=>$val){

                $NewTasks[] = array(
                'TASKID_REF'           => trim($_REQUEST['TASKTYPEID_REF'][$key])?trim($_REQUEST['TASKTYPEID_REF'][$key]):0,
                'TASK_ASSIGNTO_REF'    => trim($_REQUEST['ASSGNDTOID_REF'][$key])?trim($_REQUEST['ASSGNDTOID_REF'][$key]):NULL,
                'SUBJECT'              => trim($_REQUEST['SUBJECT'][$key])?trim($_REQUEST['SUBJECT'][$key]):NULL,
                'PRIORITYID_REF'       => trim($_REQUEST['PRIORITYID_REF'][$key])?trim($_REQUEST['PRIORITYID_REF'][$key]):NULL,
                'TASK_DETAIL'          => trim($_REQUEST['TASKDETAIL'][$key])?trim($_REQUEST['TASKDETAIL'][$key]):NULL,
                'DUE_DATE'             => trim($_REQUEST['DUEDATE'][$key])?trim($_REQUEST['DUEDATE'][$key]):NULL,
                'TASK_STATUS'          => trim($_REQUEST['STATUSID_REF'][$key])?trim($_REQUEST['STATUSID_REF'][$key]):NULL,
                'TASK_REMINDER_DATE'   => trim($_REQUEST['REMINDER'][$key])?trim($_REQUEST['REMINDER'][$key]):NULL,
                );
            }
        }

        //dd($NewTasks);
    
        if(!empty($NewTasks)){
            $wrapped_linksnt["TASK"] = $NewTasks; 
            $XMLTASK = ArrayToXml::convert($wrapped_linksnt);
        }
        else{
            $XMLTASK = NULL; 
        }


        $ProductDetails  = array();
        if(isset($_REQUEST['PRODUCTID_REF']) && !empty($_REQUEST['PRODUCTID_REF'])){
            foreach($_REQUEST['PRODUCTID_REF'] as $key=>$val){

                $ProductDetails[] = array(
                'ITEMID_REF'      => trim($_REQUEST['PRODUCTID_REF'][$key])?trim($_REQUEST['PRODUCTID_REF'][$key]):NULL,
                'QUANTITY'        => trim($_REQUEST['PRODUCT_QTY'][$key])?trim($_REQUEST['PRODUCT_QTY'][$key]):0,
                'RATE'            => trim($_REQUEST['PRODUCT_PRICE'][$key])?trim($_REQUEST['PRODUCT_PRICE'][$key]):0,
                'AMOUNT'          => trim($_REQUEST['PRODUCT_AMOUNT'][$key])?trim($_REQUEST['PRODUCT_AMOUNT'][$key]):0,
                );
            }
        }

        //dd($ProductDetails);
    
        if(!empty($ProductDetails)){
            $wrapped_linkspd["PRODUCT"] = $ProductDetails; 
            $XMLPRODUCT = ArrayToXml::convert($wrapped_linkspd);
        }
        else{
            $XMLPRODUCT = NULL; 
        }


        $CONVERT_STATUS         =   trim($request['CONVERTSTATUS']);
        $CONTACT_PERSON         =   trim($request['CONTACT_PERSON']);
        $LEAD_DETAILS           =   trim($request['LEAD_DETAILS']);
        $WEBSITE                =   trim($request['WEBSITENAME']);
        $LEAD_CLOSURE           =   trim($request['LCLOSUR'])?$request['LCLOSUR']:0;
        $REMARKS                =   trim($request['REMARKS'])?$request['REMARKS']:NULL;
        $DEALERID_REF           =   trim($request['DEALERIDREF'])?trim($request['DEALERIDREF']):0;
        $LEAD_FINALSTATUS       =   trim($request['LEAD_FINALSTATUS'])?trim($request['LEAD_FINALSTATUS']):NULL;


        $LEAD_NO                 =   trim($request['LEAD_NO']);
        // $LEAD_ID                 =   trim($request['LEAD_ID']);
        $OPPORTUNITY_TYPE_ID     =   trim($request['OPPORTY_REFID']);
        $OPPORTUNITY_STAGE_ID    =   trim($request['OPPORTYSTAGE_REFID']);
        $OPPORTUNITY_DATE        =   trim($request['OPPORTY_DATE']);        
        $EXPECTED_DATE           =   trim($request['EXPECTED_DATE']);        
        
        $CYID_REF       =   Auth::user()->CYID_REF;
        $BRID_REF       =   Session::get('BRID_REF');
        $FYID_REF       =   Session::get('FYID_REF');    
        $USERID_REF     =   Auth::user()->USERID;   
        $VTID_REF       =   509;
        $UPDATE         =   Date('Y-m-d');
        $UPTIME         =   Date('h:i:s.u');
        $ACTION         =   "EDIT";
        $IPADDRESS      =   $request->getClientIp();

        $array_data     = [$LEAD_NO,                $LEAD_DT,                   $CUSTOMER_TYPE,         $CUSTOMER_PROSPECT,     $COMPANY_NAME,      $FIRST_NAME,    $LAST_NAME,     $LEADOWNERID_REF,   $INDSID_REF,        $DESGINATION,
                           $LANDLINE_NUMBER,        $MOBILE_NUMBER, $EMAIL,     $LEAD_SOURCE,           $LEAD_STATUS,           $ASSIGNTO_REF,      $ADDRESS,       $CITYID_REF,    $STID_REF,          $CTRYID_REF,        $PINCODE,
                           $OPPORTUNITY_TYPE_ID,    $OPPORTUNITY_STAGE_ID,      $CYID_REF,              $BRID_REF,              $FYID_REF,          $VTID_REF,      $XMLBLOCK,      $XMLSITE,           $XMLACTIVITY,       $XMLTASK,
                           $USERID_REF,             $UPDATE,                    $UPTIME,                $ACTION,                $IPADDRESS,         $XMLPRODUCT,    $EXPECTED_DATE, $OPPORTUNITY_DATE,  $CONVERT_STATUS,    $CONTACT_PERSON,
                           $LEAD_DETAILS,           $WEBSITE,                   $REMARKS,               $LEAD_CLOSURE,          $DEALERID_REF,      $LEAD_FINALSTATUS ];

            //DD($array_data);
        
            $sp_result = DB::select('EXEC SP_LEAD_GEN_UP ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?', $array_data);



        //$sp_result = DB::select('EXEC SP_LEAD_GEN_UP ?,?,?,?,?,?, ?,?,?,?,?,?, ?,?', $array_data);

        //dd($sp_result);

        $contains = Str::contains($sp_result[0]->RESULT, 'SUCCESS');

        if($contains){
            return Response::json(['success' =>true,'msg' => $sp_result[0]->RESULT]);

        }else{
            return Response::json(['errors'=>true,'msg' =>  $sp_result[0]->RESULT]);
        }
        exit();    
    }



        public function edit($id=NULL){
            return $this->showRecord($id,'edit','');
        }
        public function view($id){
            return $this->showRecord($id,'view','disabled');
        }
    
        public function update(Request $request){
            return  $this->updateRecord($request,'update');        
        } 
        
        public function Approve(Request $request){
          return  $this->updateRecord($request,'approve');    
        }



    public function showRecord($id,$type,$ActionStatus){

        $id = urldecode(base64_decode($id));

        if(!is_null($id)){
        
            $FormId     =   $this->form_id;
            $USERID     =   Auth::user()->USERID;
            $VTID       =   $this->vtid_ref;
            $CYID_REF   =   Auth::user()->CYID_REF;
            $BRID_REF   =   Session::get('BRID_REF');
            

            $objResponse = DB::table('TBL_TRN_LEAD_GENERATION')
                        ->where('TBL_TRN_LEAD_GENERATION.CYID_REF','=',$CYID_REF)
                        ->where('TBL_TRN_LEAD_GENERATION.BRID_REF','=',$BRID_REF)
                        ->where('LEAD_ID','=',$id)
                        ->leftJoin('TBL_MST_COUNTRY', 'TBL_TRN_LEAD_GENERATION.CTRYID_REF','=','TBL_MST_COUNTRY.CTRYID')
                        ->leftJoin('TBL_MST_STATE', 'TBL_TRN_LEAD_GENERATION.STID_REF','=','TBL_MST_STATE.STID')
                        ->leftJoin('TBL_MST_CITY', 'TBL_TRN_LEAD_GENERATION.CITYID_REF','=','TBL_MST_CITY.CITYID')
                        ->leftJoin('TBL_MST_EMPLOYEE', 'TBL_TRN_LEAD_GENERATION.LEADOWNERID_REF','=','TBL_MST_EMPLOYEE.EMPID')
                        ->leftJoin('TBL_MST_INDUSTRYTYPE', 'TBL_TRN_LEAD_GENERATION.INDSID_REF','=','TBL_MST_INDUSTRYTYPE.INDSID')
                        ->leftJoin('TBL_MST_LEAD_SOURCE', 'TBL_TRN_LEAD_GENERATION.LEAD_SOURCE','=','TBL_MST_LEAD_SOURCE.ID')
                        ->leftJoin('TBL_MST_LEAD_STATUS', 'TBL_TRN_LEAD_GENERATION.LEAD_STATUS','=','TBL_MST_LEAD_STATUS.ID')
                        ->leftJoin('TBL_MST_OPPORTUNITY_TYPE', 'TBL_TRN_LEAD_GENERATION.OPPORTUNITY_TYPE_ID','=','TBL_MST_OPPORTUNITY_TYPE.ID')
                        ->leftJoin('TBL_MST_OPPORTUNITY_STAGE', 'TBL_TRN_LEAD_GENERATION.OPPORTUNITY_STAGE_ID','=','TBL_MST_OPPORTUNITY_STAGE.ID')
                        ->select('TBL_TRN_LEAD_GENERATION.*','TBL_MST_OPPORTUNITY_TYPE.ID AS OPPTYTYPEID','TBL_MST_OPPORTUNITY_TYPE.OPPORTUNITY_TYPECODE','TBL_MST_OPPORTUNITY_TYPE.OPPORTUNITY_TYPENAME','TBL_MST_OPPORTUNITY_STAGE.ID','TBL_MST_OPPORTUNITY_STAGE.OPPORTUNITY_STAGECODE',
                        'TBL_MST_OPPORTUNITY_STAGE.OPPORTUNITY_STAGENAME','TBL_MST_OPPORTUNITY_STAGE.COMPLETE_PERCENT','TBL_MST_COUNTRY.CTRYID','TBL_MST_COUNTRY.CTRYCODE','TBL_MST_COUNTRY.NAME AS CONTRYNAME','TBL_MST_STATE.STID','TBL_MST_STATE.STCODE','TBL_MST_STATE.NAME AS STATENAME','TBL_MST_CITY.CITYID','TBL_MST_CITY.CITYCODE','TBL_MST_CITY.NAME AS CITYNAME',
                        'TBL_MST_EMPLOYEE.EMPID','TBL_MST_EMPLOYEE.EMPCODE','TBL_MST_EMPLOYEE.FNAME', 'TBL_MST_INDUSTRYTYPE.INDSID','TBL_MST_INDUSTRYTYPE.INDSCODE','TBL_MST_INDUSTRYTYPE.DESCRIPTIONS', 
                        'TBL_MST_LEAD_SOURCE.ID AS LEADSID','TBL_MST_LEAD_SOURCE.LEAD_SOURCECODE','TBL_MST_LEAD_SOURCE.LEAD_SOURCENAME','TBL_MST_LEAD_STATUS.ID AS LEADSTUSID','TBL_MST_LEAD_STATUS.LEAD_STATUSCODE','TBL_MST_LEAD_STATUS.LEAD_STATUSNAME')
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


            $MAT = DB::table('TBL_TRN_LEAD_BLOCK_DET')                  
                        ->where('TBL_TRN_LEAD_BLOCK_DET.LEADID_REF','=',$id)
                        ->get();
                        $MAT    = count($MAT) > 0 ?$MAT:[0];
            
            $MATSITE = DB::table('TBL_TRN_LEAD_SITE_DET') 
                        ->leftJoin('TBL_MST_STATE', 'TBL_TRN_LEAD_SITE_DET.STID_REF','=','TBL_MST_STATE.STID')
                        ->leftJoin('TBL_MST_CITY', 'TBL_TRN_LEAD_SITE_DET.CITYID_REF','=','TBL_MST_CITY.CITYID')
                        ->where('TBL_TRN_LEAD_SITE_DET.LEADID_REF','=',$id)
                        ->select('TBL_TRN_LEAD_SITE_DET.*', 'TBL_MST_STATE.STID','TBL_MST_STATE.STCODE','TBL_MST_STATE.NAME','TBL_MST_CITY.CITYID','TBL_MST_CITY.CITYCODE','TBL_MST_CITY.NAME AS CITYNAME')
                        ->get();
                        $MATSITE    = count($MATSITE) > 0 ?$MATSITE:[0];
            
            $MATNEWCALL = DB::select("SELECT T1.*,T2.*,T3.* FROM TBL_TRN_LEAD_ACTIVITY T1
                        LEFT JOIN TBL_MST_ACTIVITY_TYPE T2 ON T1.ACTIVITYID_REF=T2.ID
                        LEFT JOIN TBL_MST_RESPONSE_TYPE T3 ON T1.RESPONSEID_REF=T3.ID
                        WHERE T1.LEADID_REF='$id' ORDER BY T1.ACTIVITY_ID ASC");
            
                        if(isset($MATNEWCALL) && !empty($MATNEWCALL)){
                            foreach($MATNEWCALL as $key=>$val){
            
                                $ADDITIONAL_EMPLOYEE_ID       =   $val->ADDITIONAL_EMPLOYEE_ID;
                                $ALERT_TO                     =   $val->ALERT_TO;
            
                                if($ADDITIONAL_EMPLOYEE_ID !=""){
                                    $LEADACT_DATA = DB::select("select distinct stuff((select ',' + t.[FNAME] from TBL_MST_EMPLOYEE t where EMPID in($ADDITIONAL_EMPLOYEE_ID) order by t.[FNAME] for xml path('') ),1,1,'') as F