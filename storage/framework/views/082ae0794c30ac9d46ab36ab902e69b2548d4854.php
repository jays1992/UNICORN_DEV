 <?php $__env->startSection('content'); ?>

<div class="container-fluid topnav">
    <div class="row">
        <div class="col-lg-2">
            <a href="<?php echo e(route('master',[196,'index'])); ?>" class="btn singlebt">Gratuity Master</a>
        </div>
        <!--col-2-->

        <div class="col-lg-10 topnav-pd">
            <button href="#" id="btnSelectedRows" class="btn topnavbt" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
            <button class="btn topnavbt" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
            <button id="btnSave" class="btn topnavbt" tabindex="4"><i class="fa fa-save"></i> Save</button>
            <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
            <button class="btn topnavbt" disabled="disabled"><i class="fa fa-print"></i> Print</button>
            <button class="btn topnavbt" id="btnUndo"><i class="fa fa-undo"></i> Undo</button>
            <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
            <button class="btn topnavbt" id="btnApprove" <?php echo e((isset($objRights->APPROVAL1) || isset($objRights->APPROVAL2) || isset($objRights->APPROVAL3) || isset($objRights->APPROVAL4) || isset($objRights->APPROVAL5)) &&  ($objRights->APPROVAL1||$objRights->APPROVAL2||$objRights->APPROVAL3||$objRights->APPROVAL4||$objRights->APPROVAL5) == 1 ? '' : 'disabled'); ?>><i class="fa fa-lock"></i> Approved
            </button>
            <a href="#" class="btn topnavbt" disabled="disabled"><i class="fa fa-link"></i> Attachment</a>
            <button class="btn topnavbt" id="btnExit"><i class="fa fa-power-off"></i> Exit</button>
        </div>
        <!--col-10-->
    </div>
    <!--row-->
</div>
<!--topnav-->

<div class="container-fluid purchase-order-view filter">
    <form id="frm_mst_edit" method="POST">
        <?php echo csrf_field(); ?> <?php echo e(isset($objResponse->GRATUITYID) ? method_field('PUT') : ''); ?>

        <div class="inner-form">
            <div class="row">
                <div class="col-lg-2 pl"><p>Gratuity Code</p></div>
                <div class="col-lg-2 pl">
                    <label> <?php echo e($objResponse->GRATUITY_CODE); ?> </label>
                    <input type="hidden" name="GRATUITYID" id="GRATUITYID" value="<?php echo e($objResponse->GRATUITYID); ?>" />
                    <input type="hidden" name="GRATUITY_CODE" id="GRATUITY_CODE" value="<?php echo e($objResponse->GRATUITY_CODE); ?>" autocomplete="off" maxlength="20" />
                    <input type="hidden" name="user_approval_level" id="user_approval_level" value="<?php echo e($user_approval_level); ?>" />
                </div>
                <div class="col-lg-2 pl"><p>Description</p></div>
                <div class="col-lg-5 pl">
                    <input type="text" name="GRATUITY_DESC" id="GRATUITY_DESC" class="form-control mandatory" value="<?php echo e($objResponse->GRATUITY_DESC); ?>" maxlength="200" tabindex="2" />
                    <span class="text-danger" id="ERROR_GRATUITY_DESC"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 pl"><p>Gratuity Type</p></div>
                <input type="radio" name="GratuityType" id="gratuity_type1" value="1" style="margin-right: 10;" <?php echo e($objResponse->GRATUITY_TYPE == 1 ? "checked" : ""); ?> >
                <div class="col-lg-1 pl"><p>Gratuity Rate (%)</p></div>
                <div class="col-lg-2 pl">
                    <div class="col-lg-11 pl">
                        <input
                            type="text"
                            name="GRATUITY_RATE"
                            id="GRATUITY_RATE"
                            value='<?php echo e($objResponse->GRATUITY_RATE == "null" ? "" : $objResponse->GRATUITY_RATE); ?>'
                            class="form-control mandatory"
                            autocomplete="off"
                            maxlength="20"
                            tabindex="1"
                        />
                        <span class="text-danger" id="ERROR_GRATUITY_RATE"></span>
                    </div>
                </div>
                <div class="col-lg-2 pl"><p>Minimum Tenure in years for eligibility</p></div>
                <div class="col-lg-2 pl">
                    <div class="col-lg-11 pl">
                        <input type="text" name="MIN_YEAR" id="MIN_YEAR" value='<?php echo e($objResponse->MIN_YEAR == "null" ? "" : $objResponse->MIN_YEAR); ?>' class="form-control mandatory" autocomplete="off" maxlength="20" tabindex="1" />
                        <span class="text-danger" id="ERROR_MIN_YEAR"></span>
                    </div>
                </div>
                <div class="col-lg-1 pl"><p>Max Gratuity</p></div>
                <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                        <input
                            type="text"
                            name="MAX_GRATUITY"
                            id="MAX_GRATUITY"
                            value='<?php echo e($objResponse->MAX_GRATUITY == "null" ? "" : $objResponse->MAX_GRATUITY); ?>'
                            class="form-control mandatory"
                            autocomplete="off"
                            maxlength="20"
                            tabindex="1"
                        />
                        <span class="text-danger" id="ERROR_MAX_GRATUITY"></span>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-left: 244px;">
                <div class="col-lg-2 pl"><p>No of days of Gratuity per annum</p></div>
                <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                        <input
                            type="text"
                            name="GRATUITY_DAYS"
                            id="GRATUITY_DAYS"
                            value='<?php echo e($objResponse->GRATUITY_DAYS == "null" ? "" : $objResponse->GRATUITY_DAYS); ?>'
                            class="form-control mandatory"
                            autocomplete="off"
                            maxlength="20"
                            tabindex="1"
                        />
                        <span class="text-danger" id="ERROR_GRATUITY_DAYS"></span>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-left: 221px;">
                <input type="radio" name="GratuityType" id="gratuity_type2" value="2" style="margin-right: 10;" <?php echo e($objResponse->GRATUITY_TYPE == 2 ? "checked" : ""); ?> >
                <div class="col-lg-1 pl"><p>Fix Gratuity</p></div>
                <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                        <input
                            type="text"
                            name="GRATUITY_FIX"
                            id="GRATUITY_FIX"
                            value='<?php echo e($objResponse->GRATUITY_FIX == "null" ? "" : $objResponse->GRATUITY_FIX); ?>'
                            class="form-control mandatory"
                            autocomplete="off"
                            maxlength="20"
                            tabindex="1"
                            style="width: 93px; margin-left: 21px;"
                        />
                        <span class="text-danger" id="ERROR_GRATUITY_FIX"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 pl"><p>De-Activated</p></div>
                <div class="col-lg-2 pl pr"><input type="checkbox" name="DEACTIVATED" id="deactive-checkbox_0" <?php echo e($objResponse->DEACTIVATED == 1 ? "checked" : ""); ?> value='<?php echo e($objResponse->DEACTIVATED == 1 ? 1 : 0); ?>' tabindex="2" ></div>

                <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
                <div class="col-lg-2 pl">
                    <input type="date" name="DODEACTIVATED" class="form-control" id="DODEACTIVATED" <?php echo e($objResponse->DEACTIVATED == 1 ? "" : "disabled"); ?> value="<?php echo e(isset($objResponse->DODEACTIVATED) && $objResponse->DODEACTIVATED !="" &&
                    $objResponse->DODEACTIVATED !="1900-01-01" ? $objResponse->DODEACTIVATED:''); ?>" tabindex="3" placeholder="dd/mm/yyyy" />
                </div>
            </div>
        </div>
    </form>
</div>
<!--purchase-order-view-->

<?php $__env->stopSection(); ?> <?php $__env->startSection('alert'); ?>
<!-- Alert -->
<div id="alert" class="modal" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="closePopup">&times;</button>
                <h4 class="modal-title">System Alert Message</h4>
            </div>
            <div class="modal-body">
                <h5 id="AlertMessage"></h5>
                <div class="btdiv">
                    <button class="btn alertbt" name="YesBtn" id="YesBtn" data-funcname="fnSaveData">
                        <div id="alert-active" class="activeYes"></div>
                        Yes
                    </button>
                    <button class="btn alertbt" name="NoBtn" id="NoBtn" data-funcname="fnUndoNo">
                        <div id="alert-active" class="activeNo"></div>
                        No
                    </button>
                    <button class="btn alertbt" name="OkBtn" id="OkBtn" style="display: none; margin-left: 90px;">
                        <div id="alert-active" class="activeOk"></div>
                        OK
                    </button>
                    <button class="btn alertbt" name="OkBtn1" id="OkBtn1" style="margin-left: 90px; display: none;">
                        <div id="alert-active" class="activeOk"></div>
                        OK
                    </button>
                </div>
                <!--btdiv-->
                <div class="cl"></div>
            </div>
        </div>
    </div>
</div>
<!-- Alert -->
<?php $__env->stopSection(); ?>
<!-- btnSave -->

<?php $__env->startPush('bottom-scripts'); ?>
<script>
    $(document).ready(function(){

    $("#OT_RATE").ForceNumericOnly();
      $('#OT_RATE').on('blur',function(){
              if(intRegex.test($(this).val())){
               $(this).val($(this).val()+'.00000')
              }
              event.preventDefault();
          });

    });
    $('#btnAdd').on('click', function() {
          var viewURL = '<?php echo e(route("master",[196,"add"])); ?>';
          window.location.href=viewURL;
      });

      $('#btnExit').on('click', function() {
        var viewURL = '<?php echo e(route('home')); ?>';
        window.location.href=viewURL;
      });

     var formDataMst = $( "#frm_mst_edit" );
         formDataMst.validate();

         $("#GRATUITY_CODE").blur(function(){
          $(this).val($.trim( $(this).val() ));
          $("#ERROR_GRATUITY_CODE").hide();
          validateSingleElemnet("GRATUITY_CODE");

        });
         $("#GRATUITY_CODE").keydown(function(){
         
          $("#ERROR_GRATUITY_CODE").hide();
          validateSingleElemnet("GRATUITY_CODE");

        });

        $( "#GRATUITY_CODE" ).rules( "add", {
            required: true,
            nowhitespace: true,
            StringNumberRegex: true, //from custom.js
            messages: {
                required: "Required field.",
            }
        });

        $("#GRATUITY_DESC").blur(function(){
            $(this).val($.trim( $(this).val() ));
            $("#ERROR_GRATUITY_DESC").hide();
            validateSingleElemnet("GRATUITY_DESC");
        });

        $( "#GRATUITY_DESC" ).rules( "add", {
            required: true,
            //StringRegex: true,  //from custom.js
            normalizer: function(value) {
                return $.trim(value);
            },
            messages: {
                required: "Required field."
            }
        });





        $("#DODEACTIVATED").blur(function(){
          $(this).val($.trim( $(this).val() ));
          $("#ERROR_DODEACTIVATED").hide();
          validateSingleElemnet("DODEACTIVATED");
        });

        $( "#DODEACTIVATED" ).rules( "add", {
            required: true,
            DateValidate:true,
            normalizer: function(value) {
                return $.trim(value);
            },
            messages: {
                required: "Required field"
            }
        });

        //validae single element
        function validateSingleElemnet(element_id){
          var validator =$("#frm_mst_edit" ).validate();
              validator.element( "#"+element_id+"" );
        }

        //validate
        $( "#btnSave" ).click(function() {

    if(formDataMst.valid()){
        //set function nane of yes and no btn
        if ($('input[name="GratuityType"]:checked').length == 0) {
                     $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn").hide();
                  $("#OkBtn1").show();
                  $("#AlertMessage").text('Please select Gratuity Type.');
                  $("#alert").modal('show');
                  $("#OkBtn1").focus();


        } else   {
        $("#alert").modal('show');
        $("#AlertMessage").text('Do you want to save to record.');
        $("#YesBtn").data("funcname","fnSaveData");  //set dynamic fucntion name
        $("#YesBtn").focus();
        highlighFocusBtn('activeYes');

    } }

    });//btnSave


        //validate and approve
        $("#btnApprove").click(function() {

            if(formDataMst.valid()){
                //set function nane of yes and no btn
                if ($('input[name="GratuityType"]:checked').length == 0) {
                     $("#YesBtn").hide();
                  $("#NoBtn").hide();
                  $("#OkBtn").hide();
                  $("#OkBtn1").show();
                  $("#AlertMessage").text('Please select Gratuiry Type.');
                  $("#alert").modal('show');
                  $("#OkBtn1").focus();






        } else{

        $("#alert").modal('show');
        $("#AlertMessage").text('Do you want to save to record.');
        $("#YesBtn").data("funcname","fnApproveData");  //set dynamic fucntion name
        $("#YesBtn").focus();
        highlighFocusBtn('activeYes');

    }

            }

        });//btnSave


        $("#YesBtn").click(function(){

          $("#alert").modal('hide');
          var customFnName = $("#YesBtn").data("funcname");
              window[customFnName]();

        }); //yes button


        window.fnSaveData = function (){

            //validate and save data
            event.preventDefault();

            var getDataForm = $("#frm_mst_edit");
            var formData = getDataForm.serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'<?php echo e(route("mastermodify",[196,"update"])); ?>',
                type:'POST',
                data:formData,
                success:function(data) {

                    if(data.errors) {
                        $(".text-danger").hide();

                        if(data.errors.DESCRIPTIONS){
                            showError('ERROR_DESCRIPTIONS',data.errors.DESCRIPTIONS);
                        }
                       if(data.exist=='norecord') {

                        $("#YesBtn").hide();
                          $("#NoBtn").hide();
                          $("#OkBtn").show();

                          $("#AlertMessage").text(data.msg);

                          $("#alert").modal('show');
                          $("#OkBtn").focus();

                       }
                       if(data.save=='invalid') {

                          $("#YesBtn").hide();
                          $("#NoBtn").hide();
                          $("#OkBtn").show();

                          $("#AlertMessage").text(data.msg);

                          $("#alert").modal('show');
                          $("#OkBtn").focus();

                       }
                    }
                    if(data.success) {
                        console.log("succes MSG="+data.msg);

                        $("#YesBtn").hide();
                        $("#NoBtn").hide();
                        $("#OkBtn").show();

                        $("#AlertMessage").text(data.msg);

                        $(".text-danger").hide();
                        $("#frm_mst_edit").trigger("reset");

                        $("#alert").modal('show');
                        $("#OkBtn").focus();

                    }

                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                },
            });

        };// fnSaveData


        // save and approve
        window.fnApproveData = function (){

            //validate and save data
            event.preventDefault();

            var getDataForm = $("#frm_mst_edit");
            var formData = getDataForm.serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'<?php echo e(route("mastermodify",[196,"singleapprove"])); ?>',
                type:'POST',
                data:formData,
                success:function(data) {

                    if(data.errors) {
                        $(".text-danger").hide();

                        if(data.errors.DESCRIPTIONS){
                            showError('ERROR_DESCRIPTIONS',data.errors.DESCRIPTIONS);
                        }
                       if(data.exist=='norecord') {

                        $("#YesBtn").hide();
                          $("#NoBtn").hide();
                          $("#OkBtn").show();

                          $("#AlertMessage").text(data.msg);

                          $("#alert").modal('show');
                          $("#OkBtn").focus();

                       }
                       if(data.save=='invalid') {

                          $("#YesBtn").hide();
                          $("#NoBtn").hide();
                          $("#OkBtn").show();

                          $("#AlertMessage").text(data.msg);

                          $("#alert").modal('show');
                          $("#OkBtn").focus();

                       }
                    }
                    if(data.success) {
                        console.log("succes MSG="+data.msg);

                        $("#YesBtn").hide();
                        $("#NoBtn").hide();
                        $("#OkBtn").show();

                        $("#AlertMessage").text(data.msg);

                        $(".text-danger").hide();
                        $("#frm_mst_edit").trigger("reset");

                        $("#alert").modal('show');
                        $("#OkBtn").focus();

                    }

                },
                error:function(data){
                  console.log("Error: Something went wrong.");
                },
            });

        };// fnApproveData

        //no button
        $("#NoBtn").click(function(){

          $("#alert").modal('hide');
          var custFnName = $("#NoBtn").data("funcname");
              window[custFnName]();

        }); //no button


        $("#OkBtn").click(function(){

            $("#alert").modal('hide');

            $("#YesBtn").show();
            $("#NoBtn").show();
            $("#OkBtn").hide();

            $(".text-danger").hide();
            window.location.href = '<?php echo e(route("master",[196,"index"])); ?>';

        }); ///ok button

        $("#btnUndo").click(function(){

            $("#AlertMessage").text("Do you want to erase entered information in this record?");
            $("#alert").modal('show');

            $("#YesBtn").data("funcname","fnUndoYes");
            $("#YesBtn").show();

            $("#NoBtn").data("funcname","fnUndoNo");
            $("#NoBtn").show();

            $("#OkBtn").hide();
            $("#NoBtn").focus();
            highlighFocusBtn('activeNo');

        }); ////Undo button


        $("#OkBtn").click(function(){

            $("#alert").modal('hide');

        });////ok button


       window.fnUndoYes = function (){

          //reload form
          window.location.reload();

       }//fnUndoYes


       window.fnUndoNo = function (){

          $("#GRATUITY_CODE").focus();

       }//fnUndoNo


       $("#OkBtn1").click(function(){
        $("#alert").modal('hide');
        $("#YesBtn").show();
        $("#NoBtn").show();
        $("#OkBtn").hide();
        $("#OkBtn1").hide();
        $(".text-danger").hide();
    });


        //
        function showError(pId,pVal){

          $("#"+pId+"").text(pVal);
          $("#"+pId+"").show();

        }

        function highlighFocusBtn(pclass){
           $(".activeYes").hide();
           $(".activeNo").hide();

           $("."+pclass+"").show();
        }
</script>
<script type="text/javascript">
    $(function () {
        var today = new Date();
        var dodeactived_date = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + ("0" + today.getDate()).slice(-2);
        $("#DODEACTIVATED").attr("min", dodeactived_date);

        $("input[type=checkbox][name=DEACTIVATED]").change(function () {
            if ($(this).prop("checked")) {
                $(this).val("1");
                $("#DODEACTIVATED").removeAttr("disabled");
            } else {
                $(this).val("0");
                $("#DODEACTIVATED").prop("disabled", true);
                $("#DODEACTIVATED").val("");
            }
        });
    });

    $(function () {
        //$("#DESCRIPTIONS").focus();
    });

    $(document).ready(function () {
        $("#GRATUITY_RATE").ForceNumericOnly();
        $("#GRATUITY_RATE").on("blur", function () {
            if (intRegex.test($(this).val())) {
                $(this).val($(this).val() + ".0000");
            }
            event.preventDefault();
        });

        $("#MAX_GRATUITY").ForceNumericOnly();
        $("#MAX_GRATUITY").on("blur", function () {
            if (intRegex.test($(this).val())) {
                $(this).val($(this).val() + ".00");
            }
            event.preventDefault();
        });

        $("#GRATUITY_FIX").ForceNumericOnly();
        $("#GRATUITY_FIX").on("blur", function () {
            if (intRegex.test($(this).val())) {
                $(this).val($(this).val() + ".00");
            }
            event.preventDefault();
        });

        $("#gratuity_type1").click(function () {
            $("#GRATUITY_RATE").attr("required", "true");
            $("#MIN_YEAR").attr("required", "true");
            $("#MAX_GRATUITY").attr("required", "true");
            $("#GRATUITY_DAYS").attr("required", "true");

            $("#GRATUITY_FIX").val("");
            $("#GRATUITY_FIX").prop("disabled", true);

            $("#GRATUITY_RATE").prop("disabled", false);
            $("#MIN_YEAR").prop("disabled", false);
            $("#MAX_GRATUITY").prop("disabled", false);
            $("#GRATUITY_DAYS").prop("disabled", false);
        });

        $("#gratuity_type2").click(function () {
            $("#GRATUITY_FIX").attr("required", "true");

            $("#GRATUITY_RATE").prop("disabled", true);
            $("#MIN_YEAR").prop("disabled", true);
            $("#MAX_GRATUITY").prop("disabled", true);
            $("#GRATUITY_DAYS").prop("disabled", true);

            $("#GRATUITY_RATE").val("");
            $("#MIN_YEAR").val("");
            $("#MAX_GRATUITY").val("");
            $("#GRATUITY_DAYS").val("");

            $("#GRATUITY_FIX").prop("disabled", false);
        });

        //for the checked bonus type

        if ($("#gratuity_type1:checked").length != 0) {
            $("#GRATUITY_RATE").attr("required", "true");
            $("#MIN_YEAR").attr("required", "true");
            $("#MAX_GRATUITY").attr("required", "true");
            $("#GRATUITY_DAYS").attr("required", "true");

            $("#GRATUITY_FIX").val("");
            $("#GRATUITY_FIX").prop("disabled", true);

            $("#GRATUITY_RATE").prop("disabled", false);
            $("#MIN_YEAR").prop("disabled", false);
            $("#MAX_GRATUITY").prop("disabled", false);
            $("#GRATUITY_DAYS").prop("disabled", false);
        }

        if ($("#gratuity_type2:checked").length != 0) {
            $("#GRATUITY_FIX").attr("required", "true");

            $("#GRATUITY_RATE").prop("disabled", true);
            $("#MIN_YEAR").prop("disabled", true);
            $("#MAX_GRATUITY").prop("disabled", true);
            $("#GRATUITY_DAYS").prop("disabled", true);

            $("#GRATUITY_RATE").val("");
            $("#MIN_YEAR").val("");
            $("#MAX_GRATUITY").val("");
            $("#GRATUITY_DAYS").val("");

            $("#GRATUITY_FIX").prop("disabled", false);
        }
    });
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Payroll\GratuityMaster\mstfrm196edit.blade.php ENDPATH**/ ?>