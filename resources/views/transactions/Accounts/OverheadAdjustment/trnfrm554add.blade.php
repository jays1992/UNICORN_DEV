@extends('layouts.app')
@section('content')
<script src="{{ asset('js/common.js') }}"></script>
  <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="{{route('transaction',[$FormId,'index'])}}" class="btn singlebt">Overhead Adjustment</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                  <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                  <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-pencil-square-o"></i> Edit</button>
                  <button class="btn topnavbt" id="btnSave" ><i class="fa fa-floppy-o"></i> Save</button>
                  <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                  <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                  <button class="btn topnavbt" id="btnUndo"  ><i class="fa fa-undo"></i> Undo</button>
                  <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                  <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-thumbs-o-up"></i> Approved</button>
                  <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                  <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div>
            </div>
        </div>
        
   
<div class="container-fluid purchase-order-view filter">     
    <form id="frm_mst_add" method="POST"> 
      @CSRF
    <div class="inner-form">
    <div class="row">
			<div class="col-lg-2 pl"><p>Doc No*</p></div>
			<div class="col-lg-2 pl">
        <input type="text" name="OHNO" id="OHNO" value="1011" {{$docarray['READONLY']}} class="form-control" maxlength="{{$docarray['MAXLENGTH']}}" autocomplete="off" style="text-transform:uppercase" >
        <script>docMissing(@json($docarray['FY_FLAG']));</script>
        <input type="hidden" name="MAT_ROW_ID" id="MAT_ROW_ID" >
      </div>
      <div class="col-lg-2 pl"><p>Date*</p></div>
        <div class="col-lg-2 pl">
        <input type="date" name="OHDT" id="OHDT" onchange='checkPeriodClosing("{{$FormId}}",this.value,1),getDocNoByEvent("OHNO",this,@json($doc_req))' value="{{ old('OHDT') }}" class="form-control mandatory" autocomplete="off" placeholder="dd/mm/yyyy" >
      </div>      
       
      <div class="col-lg-2 pl"><p>Type*</p></div>
        <div class="col-lg-2 pl">
        <select name="TYPE" id="TYPE" class="form-control mandatory">
          <option value="">Select</option>
          <option value="DEBIT">Debit</option>
          <option value="CREDIT">Credit</option>
          </select>  
        </div>  
		</div>       

    <div class="row">      
      <div class="col-lg-2 pl"><p>Vendor*</p></div>
      <div class="col-lg-2 pl">
        <input type="text"    name="VID_REF_Details" id="VID_REF_Details" class="form-control mandatory"  autocomplete="off" readonly/>
        <input type="hidden"  name="VID_REF"         id="VID_REF" class="form-control" autocomplete="off" />
    </div>

      <div class="col-lg-2 pl"><p>Duty Ledger*</p></div>
      <div class="col-lg-2 pl">
        <input type="text"    name="DUTY_LEDGER"         id="DUTY_LEDGER"       onclick="getData('{{route('transaction',[$FormId,'getDutyLedger'])}}','Duty Ledger Details')" class="form-control mandatory"  autocomplete="off" readonly/>
        <input type="hidden"  name="DUTY_LEDGERID_REF"   id="DUTY_LEDGERID_REF" class="form-control" autocomplete="off" />
      </div>

      <div class="col-lg-2 pl"><p>Duty Amount</p></div>
      <div class="col-lg-2 pl">
        <input type="text" name="DUTY_AMOUNT" id="DUTY_AMOUNT" class="form-control mandatory" autocomplete="off" readonly/>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-2 pl"><p>Remarks</p></div>
      <div class="col-lg-2 pl">
        <textarea name="REMARKS" id="REMARKS" style="width: 192px;" class="form-control"></textarea>
      </div>
    </div>

   
    <div class="row">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#Material">Material</a></li>
      </ul>
      Note:- 1 row mandatory in Tab
      <div class="tab-content">
        <div id="Material" class="tab-pane fade in active">
          <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height:280px;margin-top:10px;" >
            <table id="example2" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
              <thead id="thead1"  style="position: sticky;top: 0">                      
                <tr>                          
                <th rowspan="2" width="3%">Item Code<input class="form-control" type="hidden" name="Row_Count" id ="Row_Count" value="1" ></th>
                <th rowspan="2" width="3%">Item Name</th>
                <th rowspan="2" width="3%">Store </th> 
                <th rowspan="2" width="3%">Amount</th>
                <th rowspan="2" width="3%">Adjust Amount</th>
                <th rowspan="2" width="3%">Action </th>
              </tr>                    
                </thead>
                <tbody>
                <tr  class="participantRow">
                  <td><input type="text" name="ITEMCODE_0" id ="ITEMCODE_0" onclick="getItemName(this.id)" class="form-control mandatory"  autocomplete="off" readonly/></td>
                  <td hidden><input type="hidden" name="ITEMID_REF_0" id="ITEMID_REF_0" class="form-control" autocomplete="off" /></td>
                  
                  <td><input type="text" id="ITEM_DESC_0" class="form-control" readonly  > </td>           

                  <td align="center" ><button class="btn" id="BATCH_0" name="BATCH_0" onclick="get_batch(this.id);" type="button"><i class="fa fa-clone"></i></button></td>
                  
                  <td hidden><input type="hidden" name="STORE_NAME_0" id="STORE_NAME_0"  class="form-control w-100" autocomplete="off" readonly ></td>
                  <td hidden ><input type="hidden" name="TotalHiddenQty_0" id="TotalHiddenQty_0" ></td>
                  <td hidden ><input type="hidden" name="HiddenRowId_0" id="HiddenRowId_0" ></td>

                  <td><input type="text" name="BATCH_AMOUNT_0" id="BATCH_AMOUNT_0" class="form-control" readonly></td>
                  
                  <td><input type="text" name="ADJUST_AMOUNT_0" id="ADJUST_AMOUNT_0" class="form-control" readonly></td>
                  
                  <td align="center">
                    <button class="btn add" title="add" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                    <button class="btn remove" title="Delete" data-toggle="tooltip" disabled><i class="fa fa-trash" ></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
        </div>	
      </div> 
      
      <div id="Store" class="tab-pane fade" >
        <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="margin-top:10px;height:280px;width:50%;">
            <table id="example5" class="display nowrap table table-striped table-bordered itemlist" style="height:auto !important;">
                <thead id="thead1"  style="position: sticky;top: 0">
                <tr >
                    <th>Batch No<input class="form-control" type="hidden" name="Row_Count3" id ="Row_Count3"></th>
                    <th>Store</th>
                    <th>Serial No</th>
                    <th>Main UOM</th>
                    <th>Stock In Hand</th>
                    <th>Dispatch Quantity</th>
                    <th>Alt UOM</th>
                    <th>Item</th>
                    <th>Sales Order</th>
                    <th>Sales Quotation</th>
                    <th>Sales Enquiry</th>
                </tr>
                </thead>
                <tbody>
                  <tr  class="participantRow5">
                      <td><input type="text" name="BATCHNO_0" id="BATCHNO_0" class="form-control"  autocomplete="off"  /></td>
                     <td><input type="text" name="SERIALNO_0" id="SERIALNO_0" class="form-control"   autocomplete="off" /></td>
                      <td><input type="text" name="STRMUOMID_REF_0" id="STRMUOMID_REF_0" class="form-control"  autocomplete="off"  /></td>
                      <td><input type="text" name="SOTCK_0" id="SOTCK_0" class="form-control" autocomplete="off" /></td>                    
                      <td><input type="text" name="DISPATCH_MAIN_QTY_0" id="DISPATCH_MAIN_QTY_0" class="form-control"   autocomplete="off" /></td>
                      <td><input type="text" name="STRAUOMID_REF_0" id="STRAUOMID_REF_0" class="form-control" autocomplete="off"   /></td>
                      <td><input type="text" name="STRITEM_REF_0" id="STRITEM_REF_0" class="form-control"   autocomplete="off" /></td>
                      <td><input type="text" name="STRSOID_REF_0" id="STRSOID_REF_0" class="form-control"   autocomplete="off" /></td>
                      <td><input type="text" name="STRSQID_REF_0" id="STRSQID_REF_0" class="form-control"   autocomplete="off" /></td>
                      <td><input type="text" name="STRSEQID_REF_0" id="STRSEQID_REF_0" class="form-control"   autocomplete="off" /></td>
                      <td hidden ><input type="hidden" name="BATITEMID_REF[]" id="BATITEMID_REF_0" class="form-control" autocomplete="off" /></td>
                      <td hidden ><input type="hidden" name="STID_REF[]" id="STID_REF_0" class="form-control" autocomplete="off" /></td>
                      <td hidden ><input type="hidden" name="BATCHID_REF[]" id="BATCHID_REF_0" class="form-control" autocomplete="off" /></td>
                      <td hidden ><input type="hidden" name="QTY[]" id="QTY_0" class="form-control" autocomplete="off" /></td>
                      <td hidden ><input type="hidden" name="RATE[]" id="RATE_0" class="form-control" autocomplete="off" /></td>                  
                      <td hidden ><input type="hidden" name="AMOUNT[]" id="AMOUNT_0" class="form-control" autocomplete="off" /></td>                  
                      <td hidden ><input type="hidden" name="ADJUSTED_AMOUNT[]" id="ADJUSTED_AMOUNT_0" class="form-control" autocomplete="off" /></td>
                      <!-- <td align="center" ><button class="btn add UDF" title="add" data-toggle="tooltip" type="button" disabled><i class="fa fa-plus"></i></button>
                      <button class="btn remove DUDF" title="Delete" data-toggle="tooltip" type="button" disabled><i class="fa fa-trash" ></i></button></td> -->
                  </tr>
                  <tr></tr>
                </tbody>
            </table>
        </div>
    </div>

    
    </div>
    </div>

  </div>
</form>
</div>
@endsection
@section('alert')
<!-- Alert -->
<div id="alert" class="modal"  role="dialog"  data-backdrop="static">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='closePopup' >&times;</button>
        <h4 class="modal-title">System Alert Message</h4>
      </div>
      <div class="modal-body">
	    <h5 id="AlertMessage" ></h5>
        <div class="btdiv">    
            <button class="btn alertbt" name='YesBtn' id="YesBtn" data-funcname="fnSaveData">
              <div id="alert-active" class="activeYes"></div>Yes
            </button>
            <button class="btn alertbt" name='NoBtn' id="NoBtn"   data-funcname="fnUndoNo" >
              <div id="alert-active" class="activeNo"></div>No
            </button>
            <button onclick="setfocus();"  class="btn alertbt" name='OkBtn' id="OkBtn" style="display:none;margin-left: 90px;">
            <div id="alert-active" class="activeOk"></div>OK</button>
            <button class="btn alertbt" name='OkBtn1' id="OkBtn1" style="display:none;margin-left: 90px;">
              <div id="alert-active" class="activeOk1"></div>OK</button>
              <input type="hidden" id="focusid" >
            
        </div><!--btdiv-->
		    <div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<div id="vendoridpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='vendor_close_popup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Vendor Details</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="VendorCodeTable" class="display nowrap table  table-striped table-bordered" >
    <thead>
    <tr>
      <th class="ROW1">Select</th> 
      <th class="ROW2">Code</th>
      <th class="ROW3">Description</th>
    </tr>
    </thead>
    <tbody> 

      <tr>
        <th class="ROW1"><span class="check_th">&#10004;</span></th>
        <td class="ROW2"><input type="text" id="vendorcodesearch" class="form-control" autocomplete="off" onkeyup="VendorCodeFunction()"></td>
        <td class="ROW3"><input type="text" id="vendornamesearch" class="form-control" autocomplete="off" onkeyup="VendorNameFunction()"></td>
      </tr>
    </tbody>
    </table>
      <table id="VendorCodeTable2" class="display nowrap table  table-striped table-bordered" >
        <thead id="thead2"> 
        </thead>
        <tbody id="tbody_vendor" >
        </tbody>
      </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>


<!-- Store -->
<div id="storepopup" class="modal" role="dialog"  data-backdrop="static" >
  <div class="modal-dialog modal-md" style="width:1250px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='storeclosePopup' >&times;</button>
      </div>
    <div class="modal-body">
	  <div class="tablename"><p>Store</p></div>
	  <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
    <table id="storeTable" class="display nowrap table table-striped table-bordered itemlist" width="100%" style="height:auto !important;">
      <thead style="position: sticky;top: 0">
        <tr>
          <th>Batch / Lot No</th>
          <th>Stock-in-hand</th>                
          <th>Rate</th>
          <th>Amount</th>
          <th>Adjusted Amount</th>
        </tr>
        <input type="hidden" id="hdnSOID" name="hdnSOID" />
        <input type="hidden" id="hdnSQID" name="hdnSQID" />
        <input type="hidden" id="hdnSEQID" name="hdnSEQID" />
      </thead>
      <tbody id="tbody_store">
          
      </tbody>

      <tr  class="participantRowFotter">
            <td colspan="1" style="text-align:center;font-weight:bold;">TOTAL</td>    

            <td id="strSOTCK_total"   style="text-align:right;font-weight:bold;"></td>                                                                                  
            
            <td id="strRATE_total"       style="text-align:right;font-weight:bold;"></td>

            <td id="strAMOUNT_total"       style="text-align:right;font-weight:bold;"></td>

            <td id="strDISPATCH_MAIN_QTY_total"       style="text-align:right;font-weight:bold;"></td>

            <td hidden id="DISPATCH_ALT_QTY_total"   style="text-align:right;font-weight:bold;"></td>
      </tr>

    </table>
    </div>
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Store-->


<div id="ITEMIDpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md" style="width:90%">
    <div class="modal-content" >
      <div class="modal-header"><button type="button" class="close" data-dismiss="modal" id='ITEMID_closePopup' >&times;</button></div>
      <div class="modal-body">
	      <div class="tablename"><p>Item Details</p></div>
	      <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
          <table id="ItemIDTable" class="display nowrap table  table-striped table-bordered" style="width:100%" >
            <thead>
              <tr id="none-select" class="searchalldata" hidden>
                <td> 
                  <input type="text" name="fieldid1" id="hdn_ItemID1"/>
                  <input type="text" name="fieldid2" id="hdn_ItemID2"/>
                  <input type="text" name="fieldid3" id="hdn_ItemID3"/>
                  <input type="text" name="fieldid4" id="hdn_ItemID4"/>
                  <input type="text" name="fieldid5" id="hdn_ItemID5"/>
                  <input type="text" name="fieldid6" id="hdn_ItemID6"/>
                  <input type="text" name="fieldid7" id="hdn_ItemID7"/>
                  <input type="text" name="fieldid8" id="hdn_ItemID8"/>
                  <input type="text" name="fieldid9" id="hdn_ItemID9"/>
                  <input type="text" name="fieldid10" id="hdn_ItemID10"/>
                  <input type="text" name="fieldid10" id="hdn_ItemID11"/>
                  <input type="text" name="fieldid10" id="hdn_ItemID12"/>
                  <input type="text" name="fieldid18" id="hdn_ItemID18"/>
                  <input type="text" name="fieldid19" id="hdn_ItemID19"/>
                  <input type="text" name="fieldid20" id="hdn_ItemID20"/>
                  <input type="text" name="hdn_ItemID21" id="hdn_ItemID21" value="0"/>
                  <input type="text" name="fieldid22" id="hdn_ItemID22"/>
                  <input type="text" name="fieldid23" id="hdn_ItemID23"/>
                  <input type="text" name="fieldid24" id="hdn_ItemID24"/>
                  <input type="text" name="fieldid25" id="hdn_ItemID25"/>
                </td>
              </tr>

              <tr>
                <th style="width:8%;" id="all-check">Select</th>
                <th style="width:10%;">Item Code</th>
                <th style="width:10%;">Name</th>
                <th style="width:8%;">Main UOM</th>
                <th style="width:8%;">Qty</th>
                <th style="width:8%;">Item Group</th>
                <th style="width:8%;">Item Category</th>
                <th style="width:8%;">Business Unit</th>
                <th style="width:8%;">{{isset($TabSetting->FIELD8) && $TabSetting->FIELD8 !=''?$TabSetting->FIELD8:'Add. Info Part No'}}</th>
                <th style="width:8%;">{{isset($TabSetting->FIELD9) && $TabSetting->FIELD9 !=''?$TabSetting->FIELD9:'Add. Info Customer Part No'}}</th>
                <th style="width:8%;">{{isset($TabSetting->FIELD10) && $TabSetting->FIELD10 !=''?$TabSetting->FIELD10:'Add. Info OEM Part No.'}}</th>
                <th style="width:8%;">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width:8%;text-align:center;"><!--<input type="checkbox" class="js-selectall" data-target=".js-selectall1" />--></td>
                <td style="width:10%;"><input type="text" id="Itemcodesearch" class="form-control" autocomplete="off" onkeyup="ItemCodeFunction(event)"></td>
                <td style="width:10%;"><input type="text" id="Itemnamesearch" class="form-control" autocomplete="off" onkeyup="ItemNameFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemUOMsearch" class="form-control" autocomplete="off" onkeyup="ItemUOMFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemQTYsearch" class="form-control" autocomplete="off" onkeyup="ItemQTYFunction(event)" readonly></td>
                <td style="width:8%;"><input type="text" id="ItemGroupsearch" class="form-control" autocomplete="off" onkeyup="ItemGroupFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemCategorysearch" class="form-control" autocomplete="off" onkeyup="ItemCategoryFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemBUsearch" class="form-control" autocomplete="off" onkeyup="ItemBUFunction(event)" readonly></td>
                <td style="width:8%;"><input type="text" id="ItemAPNsearch" class="form-control" autocomplete="off" onkeyup="ItemAPNFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemCPNsearch" class="form-control" autocomplete="off" onkeyup="ItemCPNFunction(event)"></td>
                <td style="width:8%;"><input type="text" id="ItemOEMPNsearch" class="form-control" autocomplete="off" onkeyup="ItemOEMPNFunction(event)"></td>
                <td style="width:8%;"><input  type="text" id="ItemStatussearch" class="form-control" autocomplete="off" onkeyup="ItemStatusFunction(event)" readonly></td>
              </tr>
            </tbody>
          </table>

          <table id="ItemIDTable2" class="display nowrap table  table-striped table-bordered" style="width:100%" >
            <thead id="thead2"></thead>
            <tbody id="tbody_ItemID" style="font-size:13px;"></tbody>
          </table>
        </div>
		    <div class="cl"></div>
      </div>
    </div>
  </div>
</div>

<div id="modalpopup" class="modal" role="dialog"  data-backdrop="static">
  <div class="modal-dialog modal-md column3_modal" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='modalclosePopup' >&times;</button>
      </div>

      <div class="modal-body">

        <div class="tablename"><p id='tital_Name'></p></div>
        <div class="single single-select table-responsive  table-wrapper-scroll-y my-custom-scrollbar">
          <table id="MachTable" class="display nowrap table  table-striped table-bordered">
            <thead>
              <tr>
                <th class="ROW1">Select</th> 
                <th class="ROW2">Code</th>
                <th class="ROW3">Description</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ROW1"><span class="check_th">&#10004;</span></td>
                <td class="ROW2"><input type="text" autocomplete="off"  class="form-control" id="codesearch"  onkeyup='colSearch("tabletab2","codesearch",1)' /></td>
                <td class="ROW3"><input type="text" autocomplete="off"  class="form-control" id="namesearch"  onkeyup='colSearch("tabletab2","namesearch",2)' /></td>
              </tr>
            </tbody>
          </table>

          <table id="tabletab2" class="display nowrap table  table-striped table-bordered" >
            <thead id="thead2"></thead>
            <tbody id="getData_tbody"></tbody>
          </table>

        </div>

        <div class="cl"></div>

      </div>
    </div>
  </div>
</div>

@endsection
@push('bottom-css')
@endpush
@push('bottom-scripts')
<script>

/*************************************   All Popup  ************************** */
  function getData(path,msg){

  $('#getData_tbody').html('Loading...'); 
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
          url:path,
          type:'POST',
          success:function(data) {

          $('#getData_tbody').html(data);
          bindIndustryTypeEvents();

          },
          error:function(data){
            console.log("Error: Something went wrong.");
            $('#getData_tbody').html('');
          },
        });

          $("#tital_Name").text(msg);
          $("#modalpopup").show();
          event.preventDefault();
      }

      $("#modalclosePopup").on("click",function(event){ 
        $("#modalpopup").hide();
        event.preventDefault();
      });


/*************************************   All Popup bind  Start ************************** */    
      function bindIndustryTypeEvents(){
        $('.clsgenlager').click(function(){
        var id = $(this).attr('id');
        var txtval =    $("#txt"+id+"").val();
        var texdesc =   $("#txt"+id+"").data("desc");
        $("#DUTY_LEDGER").val(texdesc);
        $("#DUTY_LEDGERID_REF").val(txtval);
        $("#modalpopup").hide();
        });
      }

/************************************* All Popup bind End ************************** */
/*************************************   All Search Start  ************************** */

let input, filter, table, tr, td, i, txtValue;
function colSearch(ptable,ptxtbox,pcolindex) {
  //var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById(ptxtbox);
  filter = input.value.toUpperCase();
  table = document.getElementById(ptable);
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[pcolindex];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
    
/************************************* All Search End  ************************** */


function setfocus(){
  var focusid=$("#focusid").val();
  $("#"+focusid).focus();
  $("#closePopup").click();
}
  
  function alertMsg(id,msg){
    $("#focusid").val(id);
    $("#YesBtn").hide();
    $("#NoBtn").hide();
    $("#OkBtn1").hide();  
    $("#OkBtn").show();              
    $("#AlertMessage").text(msg);
    $("#alert").modal('show');
    $("#OkBtn").focus();
    return false;
  }



  
function validateForm(){
    $("#focusid").val('');

    var OHNO                =   $.trim($("#OHNO").val());
    var OHDT                =   $.trim($("#OHDT").val());
    var TYPE                =   $.trim($("#TYPE").val());
    var VID_REF             =   $.trim($("#VID_REF").val());
    var DUTY_LEDGERID_REF   =   $.trim($("#DUTY_LEDGERID_REF").val());
    
    $("#OkBtn1").hide();
    if(OHNO ===""){
      $("#focusid").val('OHNO');
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").hide();  
      $("#OkBtn").show();              
      $("#AlertMessage").text('Please Select Doc No.');
      $("#alert").modal('show');
      $("#OkBtn").focus();
      return false;
    }
    else if(OHDT ===""){
      $("#focusid").val('OHDT');
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").hide();  
      $("#OkBtn").show();              
      $("#AlertMessage").text('Please Select Date.');
      $("#alert").modal('show');
      $("#OkBtn").focus();
      return false;
    }
    else if(TYPE ===""){
      $("#focusid").val('TYPE');
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").hide();  
      $("#OkBtn").show();              
      $("#AlertMessage").text('Please Select Type.');
      $("#alert").modal('show');
      $("#OkBtn").focus();
      return false;
    }
    else if(VID_REF ===""){
      $("#focusid").val('VID_REF_Details');
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").hide();  
      $("#OkBtn").show();              
      $("#AlertMessage").text('Please Select Vendor.');
      $("#alert").modal('show');
      $("#OkBtn").focus();
      return false;
    }
    else if(DUTY_LEDGERID_REF ===""){
      $("#focusid").val('DUTY_LEDGER');
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").hide();  
      $("#OkBtn").show();              
      $("#AlertMessage").text('Please Select Duty Ledger.');
      $("#alert").modal('show');
      $("#OkBtn").focus();
      return false;
    }
    
    else{
        event.preventDefault();
          var allblank1 = [];
          var focustext1= "";
          var textmsg = "";

          $('#example2').find('.participantRow').each(function(){
          if($.trim($(this).find("[id*=ITEMID_REF]").val()) ==""){
            allblank1.push('false');
            focustext1 = $(this).find("[id*=ITEMCODE]").attr('id');
            textmsg = 'Please Select Item Code';
          }
          // else if($.trim($(this).find("[id*=AMOUNTSUB]").val()) ==""){
          //   allblank1.push('false');
          //   focustext1 = $(this).find("[id*=AMOUNTSUB]").attr('id');
          //   textmsg = 'Please enter AMOUNT-';
          // }
        });

        if(jQuery.inArray("false", allblank1) !== -1){
            $("#focusid").val(focustext1);
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").hide();  
            $("#OkBtn").show();
            $("#AlertMessage").text(textmsg);
            $("#alert").modal('show');
            $("#OkBtn").focus();
            highlighFocusBtn('activeOk');
            return false;
          }
          else if(checkPeriodClosing('{{$FormId}}',$("#OHDT").val(),0) ==0){
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn").hide();
            $("#OkBtn1").show();
            $("#AlertMessage").text(period_closing_msg);
            $("#alert").modal('show');
            $("#OkBtn1").focus();
          } 
          else{
              $("#alert").modal('show');
              $("#AlertMessage").text('Do you want to save to record.');
              $("#YesBtn").data("funcname",actionType);   
              $("#YesBtn").focus();
              highlighFocusBtn('activeYes');
          }

    }
  
}

    $('#btnAdd').on('click', function() {
        var viewURL = '{{route("transaction",[$FormId,"add"])}}';
        window.location.href=viewURL;
    });
  
    $('#btnExit').on('click', function() {
      var viewURL = '{{route('home')}}';
      window.location.href=viewURL;
    });
  
      var formResponseMst = $( "#frm_mst_add" );
          formResponseMst.validate();
      function validateSingleElemnet(element_id){
        var validator =$("#frm_mst_add" ).validate();
           if(validator.element( "#"+element_id+"" )){
            if(element_id=="OHNO" || element_id=="OHNO" ) {
              checkDuplicateCode();
            }
           }
        }
  
      function checkDuplicateCode(){
          var getDataForm = $("#frm_mst_add");
          var formData = getDataForm.serialize();
          $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url:'{{route("transaction",[$FormId,"codeduplicate"])}}',
              type:'POST',
              data:formData,
              success:function(data) {
                if(data.exists) {
                  $(".text-danger").hide();
                  showError('ERROR_OHNO',data.msg);
                  $("#OHNO").focus();
                  }                                
              },
              error:function(data){
                console.log("Error: Something went wrong.");
              },
          });
      }
  
      $( "#btnSave" ).click(function() {
          if(formResponseMst.valid()){
            validateForm("fnSaveData");
          }
        });
      
      $("#YesBtn").click(function(){
          $("#alert").modal('hide');
          var customFnName = $("#YesBtn").data("funcname");
          window[customFnName]();
        });
  
     window.fnSaveData = function (){
          event.preventDefault();
          var getDataForm = $("#frm_mst_add");
          var formData = getDataForm.serialize();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url:'{{route("transaction",[$FormId,"save"])}}',
              type:'POST',
              data:formData,
              success:function(data) {
                if(data.success) {                   
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn1").show();
                  $("#OkBtn").hide();
                  $("#AlertMessage").text(data.msg);
                  $("#alert").modal('show');
                  $("#OkBtn1").focus();
                }
                else{
                  $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn1").hide();
                  $("#OkBtn").show();
                  $("#AlertMessage").text(data.msg);
                  $("#alert").modal('show');
                  $("#OkBtn").focus();
                }                  
              },
              error:function(data){
              console.log("Error: Something went wrong.");
              },
          });        
     }

      $("#NoBtn").click(function(){
        $("#alert").modal('hide');
        var custFnName = $("#NoBtn").data("funcname");
          window[custFnName]();
        });
     
      
      $("#OkBtn").click(function(){
          $("#alert").modal('hide');
          $("#YesBtn").show();
          $("#NoBtn").show();
          $("#OkBtn").hide();
          $("#OkBtn1").hide();
          $(".text-danger").hide(); 
      });      
      
      $("#btnUndo").click(function(){
          $("#AlertMessage").text("Do you want to erase entered information in this record?");
          $("#alert").modal('show');
          $("#YesBtn").data("funcname","fnUndoYes");
          $("#YesBtn").show();
          $("#NoBtn").data("funcname","fnUndoNo");
          $("#NoBtn").show();
          $("#OkBtn").hide();
          $("#OkBtn1").hide();
          $("#NoBtn").focus();
          highlighFocusBtn('activeNo');
        });  
      
          $("#OkBtn1").click(function(){
          $("#alert").modal('hide');
          $("#YesBtn").show();
          $("#NoBtn").show();
          $("#OkBtn").hide();
          $("#OkBtn1").hide();
          $(".text-danger").hide();
          //window.location.href = "{{route('transaction',[$FormId,'index'])}}";
          });
  
          $("#OkBtn").click(function(){
            $("#alert").modal('hide');
          });
  
      window.fnUndoYes = function (){
        window.location.href = "{{route('transaction',[$FormId,'add'])}}";
      }
  
      function showError(pId,pVal){
        $("#"+pId+"").text(pVal);
        $("#"+pId+"").show();
        }
  
      function highlighFocusBtn(pclass){
         $(".activeYes").hide();
         $(".activeNo").hide();
         $("."+pclass+"").show();
      } 
     
  //add row Material
    $("#Material").on('click', '.add', function() {
      var $tr = $(this).closest('table');
      var allTrs = $tr.find('.participantRow').last();
      var lastTr = allTrs[allTrs.length-1];
      var $clone = $(lastTr).clone();
    
      $clone.find('td').each(function(){
      var el = $(this).find(':first-child');
      var id = el.attr('id') || null;
        if(id){
        var idLength = id.split('_').pop();
        var i = id.substr(id.length-idLength.length);
        var prefix = id.substr(0, (id.length-idLength.length));
        el.attr('id', prefix+(+i+1));
        }
        var name = el.attr('name') || null;
        if(name){
          var nameLength = name.split('_').pop();
          var i = name.substr(name.length-nameLength.length);
          var prefix1 = name.substr(0, (name.length-nameLength.length));
          el.attr('name', prefix1+(+i+1));
        }
      });    
      $clone.find('input:text').val('');
      $clone.find('input:hidden').val('');
      $tr.closest('table').append($clone);         
      var rowCount1 = $('#Row_Count').val();
      rowCount1 = parseInt(rowCount1)+1;
      $('#Row_Count').val(rowCount1);
      $clone.find('.remove').removeAttr('disabled'); 
      event.preventDefault();
    });

    //delete row Material
    $("#Material").on('click', '.remove', function() {
        var rowCount = $(this).closest('table').find('.participantRow').length;
        if (rowCount > 1) {
        $(this).closest('.participantRow').remove();     
        } 
        if (rowCount <= 1) { 
          $("#YesBtn").hide();
          $("#NoBtn").hide();
          $("#OkBtn").hide();
          $("#OkBtn1").show();
          $("#AlertMessage").text('There is only 1 row. So cannot be remove.');
          $("#alert").modal('show');
          $("#OkBtn1").focus();
          highlighFocusBtn('activeOk1');
          return false;
        }
        event.preventDefault();
    });

    $(document).ready(function(e) {
      var Store = $("#Store").html(); 
      $('#hdnStore').val(Store);
      $("#Row_Count3").val('1');    
    });

    function getItemName(id){
      var ROW_ID = id.split('_').pop();
      $("#MAT_ROW_ID").val(ROW_ID);
      var CODE = ''; 
      var NAME = ''; 
      var MUOM = ''; 
      var GROUP = ''; 
      var CTGRY = ''; 
      var BUNIT = ''; 
      var APART = ''; 
      var CPART = ''; 
      var OPART = '';
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART);
      $("#ITEMIDpopup").show();
    }

    $("#ITEMID_closePopup").click(function(event){
      $("#ITEMIDpopup").hide();
    });

    function loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART){        
        $("#tbody_ItemID").html('');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url:'{{route("transaction",[$FormId,"getItemDetails2"])}}',
          type:'POST',
          data:{'CODE':CODE,'NAME':NAME,'MUOM':MUOM,'GROUP':GROUP,'CTGRY':CTGRY,'BUNIT':BUNIT,'APART':APART,'CPART':CPART,'OPART':OPART},
          success:function(data) {
          $("#tbody_ItemID").html(data); 
          bindItemEvents($("#MAT_ROW_ID").val()); 
          $('.js-selectall').prop('disabled', true);
          },
          error:function(data){
          console.log("Error: Something went wrong.");
          $("#tbody_ItemID").html('');                        
          },
        });
    }


    function bindItemEvents(ROW_ID){
        $('.js-selectall1').click(function(){
        var iditem = $(this).attr('id');
        var txtval =    $("#txt"+iditem+"").data("desc1");
        var texdesc =   $("#txt"+iditem+"").data("desc2");
        var texccname =   $("#txt"+iditem+"").data("desc3");

        if($(this).is(":checked") == true) {
        $('#example5').find('.participantRow').each(function() {
        var itemid = $(this).find('[id*="ITEMID_REF"]').val();
        if(txtval) {
          if(txtval == itemid) {
            $("#YesBtn").hide();
            $("#NoBtn").hide();
            $("#OkBtn1").hide();  
            $("#OkBtn").show();              
            $("#AlertMessage").text('Item Code	already exists.');
            $("#alert").modal('show');
            $("#OkBtn").focus();
             highlighFocusBtn('activeOk');
            $('#ITEMCODE_'+ROW_ID+'').val('');
            $('#ITEMID_REF_'+ROW_ID+'').val('');
            $('#ITEM_DESC_'+ROW_ID+'').val('');
            txtval = '';
            texdesc = '';
            texccname = '';
            return false;
            }               
          }          
        });               
        $("#ITEMIDpopup").hide();
        event.preventDefault();
       }

        $('#ITEMCODE_'+ROW_ID+'').val(texdesc);
        $('#ITEMID_REF_'+ROW_ID+'').val(txtval);
        $('#ITEM_DESC_'+ROW_ID+'').val(texccname);
        $("#ITEMIDpopup").hide();
        });
      }

    
      
/*================================== ITEM DETAILS =================================*/

let itemtid = "#ItemIDTable2";
let itemtid2 = "#ItemIDTable";
let itemtidheaders = document.querySelectorAll(itemtid2 + " th");

itemtidheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(itemtid, ".clsitemid", "td:nth-child(" + (i + 1) + ")");
  });
});


function ItemCodeFunction(e){
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("Itemcodesearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemNameFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("Itemnamesearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemUOMFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemUOMsearch");
    filter = input.value.toUpperCase();  
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemQTYFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemQTYsearch");
    filter = input.value.toUpperCase();
    table = document.getElementById("ItemIDTable2");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[4];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }
}

function ItemGroupFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemGroupsearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemCategoryFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemCategorysearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemBUFunction(e) {
  if(e.which == 13){
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("ItemBUsearch");
  filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
   
  }
}

function ItemAPNFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemAPNsearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART); 
  }
}

function ItemCPNFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemCPNsearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART);
  }
}

function ItemOEMPNFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemOEMPNsearch");
    filter = input.value.toUpperCase();
      var CODE  = $("#Itemcodesearch").val();
      var NAME  = $("#Itemnamesearch").val();
      var MUOM  = $("#ItemUOMsearch").val();
      var GROUP = $("#ItemGroupsearch").val(); 
      var CTGRY = $("#ItemCategorysearch").val(); 
      var BUNIT = $("#ItemBUsearch").val(); 
      var APART = $("#ItemAPNsearch").val();
      var CPART = $("#ItemCPNsearch").val(); 
      var OPART = $("#ItemOEMPNsearch").val();
      loadItem(CODE,NAME,MUOM,GROUP,CTGRY,BUNIT,APART,CPART,OPART);
  }
}

function ItemStatusFunction(e) {
  if(e.which == 13){
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("ItemStatussearch");
    filter = input.value.toUpperCase();
    table = document.getElementById("ItemIDTable2");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[11];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }
}    
  
  $(document).ready(function(e) {
  var d = new Date(); 
  var today = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2) ;
  $('#OHDT').val(today);
  });
      
  function onlyNumberKey(evt) {
      var ASCIICode = (evt.which) ? evt.which : evt.keyCode
      if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
          return false;
      return true;
  }


$('#VID_REF_Details').click(function(event){
  var CODE = ''; 
  var NAME = ''; 
  loadVendor(CODE,NAME); 
  $("#vendoridpopup").show();
  event.preventDefault();
});

$("#vendor_close_popup").click(function(event){
  $("#vendoridpopup").hide();
  event.preventDefault();
});

function loadVendor(CODE,NAME){   
   $("#tbody_vendor").html('');
   $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
 
   $.ajax({
     url:'{{route("transaction",[$FormId,"getVendor"])}}',
     type:'POST',
     data:{'CODE':CODE,'NAME':NAME},
     success:function(data) {
       $("#tbody_vendor").html(data); 
       bindVendEvents();
       //showSelectedCheck($("#VID_REF").val(),"SELECT_VID_REF"); 
     },
     error:function(data){
     console.log("Error: Something went wrong.");
     $("#tbody_vendor").html('');                        
     },
   });
 }

 
  function bindVendEvents(){
    $(".clsvendorid").click(function(){
      var fieldid = $(this).attr('id');
      var txtval =    $("#txt"+fieldid+"").val();
      var texdesc =   $("#txt"+fieldid+"").data("desc");
  
      $('#VID_REF_Details').val(texdesc);
      $('#VID_REF').val(txtval);
      $("#vendoridpopup").hide();
      $("#VID_REF_Code_Search").val(''); 
      $("#VID_REF_Name_Search").val(''); 

      $("#vendor_codesearch").val(''); 
      $("#vendor_namesearch").val(''); 
      event.preventDefault();
    });
  }


 // START VENDOR CODE FUNCTION
let vdtid = "#VendorCodeTable2";
let vdtid2 = "#VendorCodeTable";
let vdheaders = document.querySelectorAll(vdtid2 + " th");

vdheaders.forEach(function(element, i) {
  element.addEventListener("click", function() {
    w3.sortHTML(vdtid, ".clsvendorid", "td:nth-child(" + (i + 1) + ")");
  });
});
 
function VendorCodeFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("vendorcodesearch");
    filter = input.value.toUpperCase();
    if(filter.length == 0)
    {
      var CODE = ''; 
      var NAME = ''; 
      loadVendor(CODE,NAME); 
    }
    else if(filter.length >= 3)
    {
      var CODE = filter; 
      var NAME = ''; 
      loadVendor(CODE,NAME); 
    }
    else
    {
      table = document.getElementById("VendorCodeTable2");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
      }       
    }
  }
}

function VendorNameFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("vendornamesearch");
    filter = input.value.toUpperCase();
    if(filter.length == 0)
    {
      var CODE = ''; 
      var NAME = ''; 
      loadVendor(CODE,NAME);
    }
    else if(filter.length >= 3)
    {
      var CODE = ''; 
      var NAME = filter; 
      loadVendor(CODE,NAME);  
    }
    else
    {
      table = document.getElementById("VendorCodeTable2");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
      }       
    }
  }
}


// Store Popup
let strtid = "#storeTable";
      let strheaders = document.querySelectorAll(strtid + " th");

      // Sort the table element when clicking on the table headers
      strheaders.forEach(function(element, i) {
        element.addEventListener("click", function() {
          w3.sortHTML(strtid, ".clsstrid", "td:nth-child(" + (i + 1) + ")");
        });
      });




function get_batch(id){
        var currentid=id.split("_"); 
        var rowid=currentid[1]; 
        $(".participantRowFotter").hide();
        $('#tbody_store').html('<tr><td colspan="7">Please wait ...</td></tr>');
        
        var itemid = $("#ITEMID_REF_"+rowid).val();
        var muomid = $("#MAINUOMID_REF_"+rowid).val();
        var auomid = $("#ALTUOMID_REF_"+rowid).val();
        var soqty = $("#ADJUST_AMOUNT_"+rowid).val();
        var qtyid = $("#ADJUST_AMOUNT_"+rowid).attr('id');
        var storeid = "STORE_"+rowid;
        var SOID = $("#SOID_REF_"+rowid).val();
        var SQID = $("#SQID_REF_"+rowid).val();
        var SEQID = $("#SEQID_REF_"+rowid).val();
        $('#hdnSOID').val(SOID);
        $('#hdnSQID').val(SQID);
        $('#hdnSEQID').val(SEQID);

        var ITEMROWID = $("#HiddenRowId_"+rowid).val();

        //getStoreRateAvg(itemid,rowid);
       
        if(itemid != ''){
          $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var TYPE=$('#TYPE :selected').val();

            $.ajax({
                url:'{{route("transaction",[$FormId,"getItemwiseStoreDetails"])}}',
                type:'POST',
                data:{'itemid':itemid,'muomid':muomid,'auomid':auomid,'soqty':soqty,'storeid':storeid,'qtyid':qtyid,ITEMROWID:ITEMROWID,SOID:SOID,SQID:SQID,SEQID:SEQID,ACTION_TYPE:'ADD'},
                success:function(data) {
                    $('#tbody_store').html(data);
                    $(".participantRowFotter").show();
                    bindBatchEvents();
                    getTotalRowValue();
                    event.preventDefault();

                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                  $('#tbody_store').html('');
                  $(".participantRowFotter").show();
                  bindBatchEvents();
                  getTotalRowValue();
                  event.preventDefault();
                },
            }); 

        }
        $("#storepopup").show();
      }




      
$("#storeclosePopup").click(function(event){
        var txtid = $('#hdnstoreid').val();
        var ROW_STR = txtid.split('_');
        var ROW_ID  = ROW_STR[1]; 

        var MulStoreId = '';

        var AltQtyArr = [];
        var NewQtyArr = [];
        var NewIdArr  = [];
        var STORE_NAME  = [];
        
        $('#storeTable').find('.clsstrid').each(function(){

          if($(this).find('[id*="strDISPATCH_MAIN_QTY"]').val() != '')
          {
          var batchno = $(this).find('[id*="strBATCHNO"]').val();
          var batchidref = $(this).find('[id*="strBATCHID_REF"]').val();
          var stid = $(this).find('[id*="strSTID_REF"]').val();
          var bachidref = $(this).find('[id*="strBATCHNO"]').val();
          var muomid = $(this).find('[id*="MUOM_REF"]').val();
          var itemid = $(this).find('[id*="strITEMID_REF"]').val();
          var stock = $(this).find('[id*="strSOTCK"]').val();

          var rate = $(this).find('[id*="strRATE"]').val();
          var amount = $(this).find('[id*="strAMOUNT"]').val();

          var dqty = $(this).find('[id*="strDISPATCH_MAIN_QTY"]').val();
          var aqty = $(this).find('[id*="DISPATCH_ALT_QTY"]').val();
          var auomid = $(this).find('[id*="AUOM_REF_"]').val();

          $("#BATITEMID_REF_"+ROW_ID).val(itemid);
          $("#STID_REF_"+ROW_ID).val(stid);
          $("#BATCHID_REF_"+ROW_ID).val(bachidref);
          $("#QTY_"+ROW_ID).val(stock);
          $("#RATE_"+ROW_ID).val(rate);
          $("#AMOUNT_"+ROW_ID).val(amount);
          $("#ADJUSTED_AMOUNT_"+ROW_ID).val(dqty);
          
            var $tr = $('.participantRow5').closest('table');
            var allTrs = $tr.find('.participantRow5').last();
            var lastTr = allTrs[allTrs.length-1];
            var $clone = $(lastTr).clone();

            $clone.find('td').each(function(){
              var el = $(this).find(':first-child');
              var id = el.attr('id') || null;
                if(id){
                    var idLength = id.split('_').pop();
                    var i = id.substr(id.length-idLength.length);
                    var prefix = id.substr(0, (id.length-idLength.length));
                    el.attr('id', prefix+(+i+1));
                }
              //   var name = el.attr('name') || null;
              // if(name){
              //   var nameLength = name.split('_').pop();
              //   var i = name.substr(name.length-nameLength.length);
              //   var prefix1 = name.substr(0, (name.length-nameLength.length));
              //   el.attr('name', prefix1+(+i+1));
              // }
            });

            $clone.find('[id*="BATCHNO"]').val(batchno);
            $clone.find('[id*="BATCHID_REF"]').val(bachidref);
            $clone.find('[id*="STID_REF"]').val(stid);
            $clone.find('[id*="SERIALNO"]').val('');
            $clone.find('[id*="STRMUOMID_REF"]').val(muomid);
            $clone.find('[id*="QTY"]').val(stock);
            $clone.find('[id*="RATE"]').val(rate);
            $clone.find('[id*="AMOUNT"]').val(amount);

            $clone.find('[id*="ADJUSTED_AMOUNT"]').val(dqty);
            $clone.find('[id*="STRAUOMID_REF"]').val(auomid);
            $clone.find('[id*="BATITEMID_REF"]').val(itemid);
            $tr.closest('table').append($clone);   
            var rowCount3 = $('#Row_Count3').val();
            rowCount3 = parseInt(rowCount3)+1;
            $('#Row_Count3').val(rowCount3);

          $("#BATITEMID_REF_"+ROW_ID).val(itemid);
          $("#STID_REF_"+ROW_ID).val(stid);
          $("#BATCHID_REF_"+ROW_ID).val(bachidref);
          $("#QTY_"+ROW_ID).val(stock);
          $("#RATE_"+ROW_ID).val(rate);
          $("#AMOUNT_"+ROW_ID).val(amount);
          $("#ADJUSTED_AMOUNT_"+ROW_ID).val(dqty);
            
          }
        });

        if (typeof txtid != "undefined") {
          
          var ROW_STR = txtid.split('_');
          var ROW_ID  = ROW_STR[1];         

          var TotalQty= getArraySum(NewQtyArr); 

          if(intRegex.test(TotalQty)){
            TotalQty = (TotalQty +'.000');
          }

          var TotalAltQty= getArraySum(AltQtyArr); 

          if(intRegex.test(TotalAltQty)){
            TotalAltQty = (TotalAltQty +'.000');
          }

          $("#ADJUST_AMOUNT_"+ROW_ID).val(TotalQty);
          $("#ALT_UOMID_QTY_"+ROW_ID).val(TotalAltQty);
          $("#TotalHiddenQty_"+ROW_ID).val(TotalQty);
          $("#HiddenRowId_"+ROW_ID).val(NewIdArr);
          $("#STORE_NAME_"+ROW_ID).val(STORE_NAME);

          // if(parseFloat($.trim($("#SOPENDINGQTY_"+ROW_ID).val())) != "" && parseFloat($.trim($("#SOPENDINGQTY_"+ROW_ID).val())) < parseFloat($.trim($("#TotalHiddenQty_"+ROW_ID).val())) ){
          //     $("#storepopup").hide();
          //     $("#ProceedBtn").focus();
          //     $("#YesBtn").hide();
          //     $("#CHALLAN_MAINQTY_"+ROW_ID).val('0.000');
          //     $("#NoBtn").hide();
          //     $("#OkBtn").hide();
          //     $("#OkBtn1").show();
          //     $("#AlertMessage").text('Dispatch Quantity cannot be greater than SO Pending Quantity.');
          //     $("#alert").modal('show');
          //     $("#OkBtn1").focus();
          //     return false;
          // }
        }
        
        $("#storepopup").hide();


});




function getArraySum(a){
          var total=0;
          for(var i in a) { 
              total += a[i];
          }
          return total;
      }



      	
	function bindBatchEvents(){
    var txtid = $('#hdnstoreid').val();
    var ROW_STR = txtid.split('_');
    var ROW_ID  = ROW_STR[1];
    		
  $('#storeTable').on('keyup','[id*="strDISPATCH_MAIN_QTY"]',function(event){  
  var dqty 		=	$(this).val();
  var stockqty 	= 	$(this).parent().parent().find('[id*="strSOTCK"]').val();
  var adj_amt 		=	$(this).val();
  var qty_stock 	= 	$(this).parent().parent().find('[id*="strSOTCK"]').val();
  var rate_str 	= 	$(this).parent().parent().find('[id*="strRATE"]').val();
  var amount_str 	= 	$(this).parent().parent().find('[id*="strAMOUNT"]').val();
  var item_str 	= 	$(this).parent().parent().find('[id*="strITEMID_REF"]').val();
  $("#ADJUSTED_AMOUNT_"+ROW_ID).val(adj_amt);
  $("#QTY_"+ROW_ID).val(qty_stock);
  $("#RATE_"+ROW_ID).val(rate_str);
  $("#AMOUNT_"+ROW_ID).val(rate_str);
  $("#BATCH_ITEMID_REF_"+ROW_ID).val(item_str);

  $("#BATCH_ITEMID_REF_"+ROW_ID).val(item_str);
  $("#ADJUST_AMOUNT_"+ROW_ID).val(adj_amt);

  var mqty = $(this).parent().parent().find('[id*="CONV_MAIN_QTY"]').val();
  var aqty = $(this).parent().parent().find('[id*="CONV_ALT_QTY"]').val();
  var daltqty = parseFloat((dqty * aqty)/mqty).toFixed(3);
  $(this).parent().parent().find('[id*="DISPATCH_ALT_QTY"]').val(daltqty);
  getTotalRowValue(); 
  
  });
}


function getTotalRowValue(){

var strSOTCK        = 0;
var strDISPATCH_MAIN_QTY = 0;
var strRATE      = 0; 
var DISPATCH_ALT_QTY  = 0;
var strAMOUNT      = 0; 

$('#storepopup').find('.clsstrid').each(function(){
  strSOTCK  = $(this).find('[id*="strSOTCK"]').val() > 0? strSOTCK+parseFloat($(this).find('[id*="strSOTCK"]').val()):strSOTCK;
  strDISPATCH_MAIN_QTY = $(this).find('[id*="strDISPATCH_MAIN_QTY"]').val() > 0?strDISPATCH_MAIN_QTY+parseFloat($(this).find('[id*="strDISPATCH_MAIN_QTY"]').val()):strDISPATCH_MAIN_QTY;
  strRATE      = $(this).find('[id*="strRATE"]').val() > 0?strRATE+parseFloat($(this).find('[id*="strRATE"]').val()):strRATE;
  DISPATCH_ALT_QTY  = $(this).find('[id*="DISPATCH_ALT_QTY"]').val() > 0?DISPATCH_ALT_QTY+parseFloat($(this).find('[id*="DISPATCH_ALT_QTY"]').val()):DISPATCH_ALT_QTY;
  strAMOUNT     = $(this).find('[id*="strAMOUNT"]').val() > 0?strAMOUNT+parseFloat($(this).find('[id*="strAMOUNT"]').val()):strAMOUNT;

});

strSOTCK          = strSOTCK > 0?parseFloat(strSOTCK).toFixed(3):'';
strDISPATCH_MAIN_QTY   = strDISPATCH_MAIN_QTY > 0?parseFloat(strDISPATCH_MAIN_QTY).toFixed(3):'';
strRATE        = strRATE > 0?parseFloat(strRATE).toFixed(5):'';
DISPATCH_ALT_QTY    = DISPATCH_ALT_QTY > 0?parseFloat(DISPATCH_ALT_QTY).toFixed(2):'';
strAMOUNT        = strAMOUNT > 0?parseFloat(strAMOUNT).toFixed(2):'';

//alert(strDISPATCH_MAIN_QTY);

$("#strSOTCK_total").text(strSOTCK);
$("#strDISPATCH_MAIN_QTY_total").text(strDISPATCH_MAIN_QTY);
$("#strRATE_total").text(strRATE);
$("#DISPATCH_ALT_QTY_total").text(DISPATCH_ALT_QTY);
$("#strAMOUNT_total").text(strAMOUNT);

var txtid = $('#hdnstoreid').val();
var ROW_STR = txtid.split('_');
var ROW_ID  = ROW_STR[1];

//$("#BATCH_AMOUNT_"+ROW_ID).val(strAMOUNT);

$("#ADJUST_AMOUNT_"+ROW_ID).val(strDISPATCH_MAIN_QTY);

var totalvalue = 0.00;
$('#Material').find('.participantRow').each(function() {

  tvalue = $(this).find('[id*="ADJUST_AMOUNT"]').val();
  totalvalue = parseFloat(totalvalue) + parseFloat(tvalue);
  totalvalue = parseFloat(totalvalue).toFixed(2);
});

$('#DUTY_AMOUNT').val(totalvalue);

}

function isNumberDecimalKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

    return true;
}



  </script>
  
  @endpush
