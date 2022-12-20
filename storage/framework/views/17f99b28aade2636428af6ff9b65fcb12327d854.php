
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo e(config('app.name', 'Laravel')); ?></title>
<meta name="keywords" content=" ">
<meta name="description" content=" ">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet" type="text/css">
<style>
input:focus {
    border-bottom: 1px dashed #fff !important;
}
select:focus {
  border-bottom: 1px dashed #fff !important;
}

</style>
</head>
<body>

<!-- Alert -->
<div id="alert" class="modal"  role="dialog"  data-backdrop="static" >
  <div class="modal-dialog" style="position:relative;top:82px;left:273px;"  >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id='closePopup' >&times;</button>
        <h4 class="modal-title">System Alert Message</h4>
      </div>
      <div class="modal-body">
	  <h5 id="AlertMessage" ></h5>
        <div class="btdiv">
    
        <button class="btn alertbt" name='ProceedBtn' id="ProceedBtn" onClick="getFocus()" style="margin-left: 77px;"  > Proceed</button>
        <input type="hidden" id="FocusId">
           
        </div><!--btdiv-->
		<div class="cl"></div>
      </div>
    </div>
  </div>
</div>
<!-- Alert -->

<script>

function validateForm(){
 
    $("#FocusId").val('');
    var UCODE          =   $.trim($("#UCODE").val());
    var PASSWORD       =   $.trim($("#PASSWORD").val());
    var CYID_REF       =   $.trim($("#CYID_REF").val());
    var BRID_REF       =   $.trim($("#BRID_REF").val());
    var FYID_REF       =   $.trim($("#FYID_REF").val());

    if(UCODE ===""){
        $("#FocusId").val('UCODE');
        $("[id=UCODE]").blur(); 
        $("#alert").modal();
        $("#ProceedBtn").focus();
        $("#AlertMessage").text('Please enter user id.');
        return false;
    }
    if(existUser(UCODE) ==""){
        $("#FocusId").val('UCODE');
        $("[id=UCODE]").blur(); 
        $("#alert").modal();
        $("#ProceedBtn").focus();
        $("#AlertMessage").text('User id is not correct. Please enter again.');
        return false;   
    }
    else if(PASSWORD ===""){
        $("#FocusId").val('PASSWORD');
        $("[id=PASSWORD]").blur(); 
        $("#alert").modal();
        $("#ProceedBtn").focus();
        $("#AlertMessage").text('Password is not correct. Please enter again.');
        return false;
    }
    if(existPass(UCODE,PASSWORD) ==""){
        $("#FocusId").val('PASSWORD');
        $("[id=PASSWORD]").blur(); 
        $("#alert").modal();
        $("#ProceedBtn").focus();
        $("#AlertMessage").text('Password is not correct. Please enter again.');
        return false;   
    }
    else if(CYID_REF ===""){
        $("#FocusId").val('CYID_REF');
        $("[id=CYID_REF]").blur(); 
        $("#alert").modal();
        $("#ProceedBtn").focus();
        $("#AlertMessage").text('Please select company.');
        return false;
    }
    else if(BRID_REF ===""){
        $("#FocusId").val('BRID_REF');
        $("[id=BRID_REF]").blur(); 
        $("#alert").modal();
        $("#ProceedBtn").focus();
        $("#AlertMessage").text('Please select branch.');
        return false;
    }
    else if(FYID_REF ===""){
        $("#FocusId").val('FYID_REF');
        $("[id=FYID_REF]").blur(); 
        $("#alert").modal();
        $("#ProceedBtn").focus();
        $("#AlertMessage").text('Please select financial year.');
        return false;
    }
    else{
        event.preventDefault();
        var loginForm = $("#loginForm");
        var formData = loginForm.serialize();
        $.ajax({
            url:'<?php echo e(route('login')); ?>',
            type:'POST',
            data:formData,
            success:function(data) {
                if(data.errors) {
                    if(data.errors.UCODE){
                        $("#FocusId").val('UCODE');
                        $("[id=UCODE]").blur(); 
                        $("#alert").modal();
                        $("#ProceedBtn").focus();
                        $("#AlertMessage").text('Please enter correct user id.');
                    }
                    else if(data.errors.PASSWORD){
                        $("#FocusId").val('PASSWORD');
                        $("[id=PASSWORD]").blur(); 
                        $("#alert").modal();
                        $("#ProceedBtn").focus();
                        $("#AlertMessage").text('Password is not correct. Please enter again.');
                    }
                    else if(data.login=='invalid'){
                        $("#FocusId").val('BRID_REF');
                        $("[id=BRID_REF]").blur(); 
                        $("#alert").modal();
                        $("#ProceedBtn").focus();
                        $("#AlertMessage").text(data.msg);
                    }
                }
                if(data.success) {
                    window.location.href="<?php echo e(route('home')); ?>";
                }
            }
        });

    }

}

function getCompany(){

    $(".msg").remove();

    var UCODE       =   $.trim($("#UCODE").val());

    if(UCODE !=""){
        $.get('get-company',{UCODE:UCODE},function(data){

            if(data ==="Invalid"){
               
            }
            else{
                $("#CYID_REF").html(data);
            }
	    });
    }
    else{
       
        return false;
    }    
}

function getBranch(CYID_REF){

    var UCODE       =   $.trim($("#UCODE").val());

    $.get('get-branch',{CYID_REF:CYID_REF,UCODE:UCODE},function(data){
        $("#BRID_REF").html(data);
    });

    $.get('get-fyear',{CYID_REF:CYID_REF,UCODE:UCODE},function(data){
        $("#FYID_REF").html(data);
    });

}

function getFocus(){
    var FocusId=$("#FocusId").val();
    $("#"+FocusId).focus();
    $("#closePopup").click();
}


function existUser(UCODE){
    var posts = $.ajax({type: 'GET',url:'exist-user',async: false,dataType: 'json',data: {UCODE:UCODE},done: function(response) {return response;}}).responseText;
    return posts;
}

function existPass(UCODE,PASSWORD){
    var posts = $.ajax({type: 'GET',url:'exist-pass',async: false,dataType: 'json',data: {UCODE:UCODE,PASSWORD:PASSWORD},done: function(response) {return response;}}).responseText;
    return posts;
}



</script>

<div class="home-login">
		
		<div class="col-lg-5 col-sm-5 left-bar">
		<div  class="logo"><a href=""><img src="images/bsquare.png" alt="BSquare"></a></div><!--logo-->
		<div class="form">
        <form method="POST"  id="loginForm" onsubmit="return validateForm()"  >
            <?php echo csrf_field(); ?>
			 <div class="form-group input-icons">
			 <i class="fa fa-user icon"></i> 
              <input id="UCODE" type="text" class="form-control control" name="UCODE" value="<?php echo e(old('UCODE')); ?>" autocomplete="off" placeholder="User ID" onfocusout="getCompany()" tabindex="1" >

             </div>

			 <div class="form-group input-icons">
			 <i class="fa fa-lock icon"></i> 
		      
              <input id="PASSWORD" type="PASSWORD" class="form-control control <?php $__errorArgs = ['PASSWORD'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="PASSWORD" autocomplete="current-PASSWORD" placeholder="Password"  tabindex="2"  >

			 </div>
			 
			 <div class="form-group input-icons">
			 <i class="fa fa-building-o icon"></i>
		      <select class="form-control" id="CYID_REF" name="CYID_REF" onChange="getBranch(this.value)" tabindex="3"  >
				<option value="" selected>Company</option>
              </select>
            
               
			 </div>
			 
			 <div class="form-group input-icons">
			 <i class="fa fa-building-o icon"></i>
		      <select class="form-control" id="BRID_REF" name="BRID_REF" tabindex="4" >
				<option value="" selected>Branch</option>
              </select>
               
			 </div>
			 
			 <div class="form-group input-icons">
			 <i class="fa fa-calendar icon"></i>
		      <select class="form-control"  id="FYID_REF" name="FYID_REF" tabindex="5" >
				<option value="" selected>Financial Year</option>
            </select>
               
			 </div>
		     			  
		      <button type="submit" tabindex="6"><i class="fa fa-chevron-right"></i></button>

              


		      <div claa="cl"></div>
		     </form>
  	    </div><!--form-->
	</div><!--login-form-->

	<div class="col-lg-7 col-sm-7 bg">
		</div><!--bg-->
    </div><!--home-login-->	
    
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function () {
   $('#txtDate1, #txtDate2, #txtDate3, #txtDate4').datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth: true,
    changeYear: true
   });
});
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
<script src="js/select-table.js"></script>

<script>
$('.js-selectall').on('change', function() {
  var isChecked = $(this).prop("checked");
  var selector = $(this).data('target');
  $(selector).prop("checked", isChecked);
});
</script>

<script>
$(document).ready(function() {
    $('#example, #example2, #example3, #example4').DataTable();
} );
</script>
<script>
$('.nav-toggle').click(function(e) {
  e.preventDefault();
  $("body").toggleClass("openNav");
  $(".nav-toggle").toggleClass("active");

});
</script>

<script>
$('.single-select tr').click(function(e) {
    $('.single-select tr').removeClass('highlighted');
    $(this).addClass('highlighted');
});


</script>

</body>
</html>
<?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\auth\login_bkp.blade.php ENDPATH**/ ?>