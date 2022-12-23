<!-- <!DOCTYPE html> -->
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo e(config('app.name', 'Laravel')); ?></title>
<meta name="keywords" content=" ">
<meta name="description" content=" ">
<link href="<?php echo e(asset('css/fontawesome.css')); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo e(asset('fonts/css/all.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/font-style.css')); ?>" rel='stylesheet' type='text/css'>
<link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet" >
<link href="<?php echo e(asset('css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/jquery-ui.css')); ?>" rel="Stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php echo e(asset('css/bootstrapvalidator.min.css')); ?>">

<link href="<?php echo e(asset('css/nav.css')); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet" type="text/css">


<link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet" type="text/css">

<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('ckeditor/ckeditor.js')); ?>"></script>


<script type="text/javascript">
$(document).ready(function () {
	$('.nav-toggle').click(function(e) {		
		$("body").toggleClass("openNav");
		$(".nav-toggle").toggleClass("active");
		e.preventDefault();
	});
	
	// $('#vertical-menu > li > a').click(function(){
	// 	if ($(this).attr('class') != 'active'){
	// 		$('#vertical-menu li ul').slideUp();
	// 		$(this).next().slideToggle();
	// 		$('#vertical-menu li a').removeClass('active');
	// 		$(this).addClass('active');
	// 	}
	// });

	// $('#vertical-menu > li > ul > li > a').click(function(){
	// 	if ($(this).attr('class') != 'active'){
	// 		$('#vertical-menu li ul li ul').slideUp();
	// 		$(this).next().slideToggle();
	// 		$('#vertical-menu li ul li a').removeClass('active');
	// 		$(this).addClass('active');
	// 	}
	// });
	
	
});
</script>
<script type="text/javascript">
jQuery(document).ready(function () {
	jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
	
});

$(function(){	
	$("#vertical-menu li").click(function(){
		$("#vertical-menu li.active").removeClass("active")
		$(this).addClass("active");
	})	
})	
</script>
<script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/dataTables.bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrapValidator.min.js')); ?>"></script>

<script src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/additional-methods.min.js')); ?>"></script>


<script src="<?php echo e(asset('js/custom.js')); ?>"></script>
<script src="<?php echo e(asset('js/select-table.js')); ?>"></script>
<script src="<?php echo e(asset('js/menu.js')); ?>"></script>
<script src="<?php echo e(asset('js/moment.js')); ?>"></script>
<script src="<?php echo e(asset('js/common.js')); ?>"></script>
<script type="text/javascript">


jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
			if(e.altKey || e.ctrlKey || e.metaKey || e.shiftKey){
				key = 0;  //diable special charcters. i.e disbale keycode with shift, ctrl, alt keyand meta key, meta 
			}
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};

var intRegex = /^\d+$/;
$( function() {
 $('#example2').on('keyup','.two-digits',function(){
   if($(this).val().indexOf('.')!=-1){         
       if($(this).val().split(".")[1].length > 2){                
		   $(this).val('');
		   $("#alert").modal('show');
			$("#AlertMessage").text('Enter value till two decimal only.');
			$("#YesBtn").hide(); 
			$("#NoBtn").hide();  
			$("#OkBtn1").show();
			$("#OkBtn1").focus();
			$("#OkBtn").hide();
			highlighFocusBtn('activeOk1');
       }  
    }            
    return this; //for chaining
 });
});

$( function() {
 $('#example2').on('keyup','.three-digits',function(){
   if($(this).val().indexOf('.')!=-1){         
       if($(this).val().split(".")[1].length > 3){                
		   $(this).val('');
		   $("#alert").modal('show');
			$("#AlertMessage").text('Enter value till three decimal only.');
			$("#YesBtn").hide(); 
			$("#NoBtn").hide();  
			$("#OkBtn1").show();
			$("#OkBtn1").focus();
			$("#OkBtn").hide();
			highlighFocusBtn('activeOk1');
       }  
    }            
    return this; //for chaining
 });
});

$( function() {
 $('#example2').on('keyup','.five-digits',function(){
   if($(this).val().indexOf('.')!=-1){         
       if($(this).val().split(".")[1].length > 5){                
		   $(this).val('');
		   $("#alert").modal('show');
			$("#AlertMessage").text('Enter value till five decimal only.');
			$("#YesBtn").hide(); 
			$("#NoBtn").hide();  
			$("#OkBtn1").show();
			$("#OkBtn1").focus();
			$("#OkBtn").hide();
			highlighFocusBtn('activeOk1');
       }  
    }            
    return this; //for chaining
 });
});

$( function() {
 $('#example2').on('keyup','.four-digits',function(){
   if($(this).val().indexOf('.')!=-1){         
       if($(this).val().split(".")[1].length > 4){                
		   $(this).val('');
		   $("#alert").modal('show');
			$("#AlertMessage").text('Enter value till four decimal only.');
			$("#YesBtn").hide(); 
			$("#NoBtn").hide();  
			$("#OkBtn1").show();
			$("#OkBtn1").focus();
			$("#OkBtn").hide();
			highlighFocusBtn('activeOk1');
       }  
    }            
    return this; //for chaining
 });
});






$(function () {
	
	$('#btnExit').on('click', function() {
      var viewURL = '<?php echo e(route('home')); ?>';
                  window.location.href=viewURL;
    });


//    $('.datepicker').datepicker({
//     dateFormat: "dd/mm/yy",
//     changeMonth: true,
//     changeYear: true
//    });
});


/* function check_approval_level(REQUEST_DATA,RECORD_ID,editURL){

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  
    var result = $.ajax({
                 url:'<?php echo e(route("transaction",[1001,"check_approval_level"])); ?>',
                type:'POST',
                async: false,
                dataType: 'json',
                data: {REQUEST_DATA:REQUEST_DATA,RECORD_ID:RECORD_ID},
                done: function(response) {return response;}
                }).responseText;
  
    if(result > 0){
      window.location.href=editURL;
    }
    else{
      $("#YesBtn").hide();
      $("#NoBtn").hide();
      $("#OkBtn1").show();
      $("#AlertMessage").text('CANNOT EDIT AS THE RECORD IS ALREADY MOVED TO NEXT LEVEL.');
      $("#alert").modal('show');
      $("#OkBtn1").focus();
      return false;
    }
  }
  function getDocNoByEvent(docid,date,doc_req){
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$.ajax({
		url:'<?php echo e(route("transaction",[1001,"getDocNoByEvent"])); ?>',
		type:'POST',
		dataType: 'json',
		data: {'REQUEST_DATA':date.value,doc_req:doc_req},
		success:function(result) {

			if(result.FLAG ==true){
				$("#"+docid).val(result.DOC_NO);
			}
			else{
				$("#"+docid).val('');
				$("#YesBtn").hide();
				$("#NoBtn").hide();
				$("#OkBtn1").show();
				$("#AlertMessage").text('Previous doc date not allow.');
				$("#alert").modal('show');
				$("#OkBtn1").focus();
			}
		}
		
	});
} */
</script>



<?php echo $__env->yieldPushContent('head-scripts'); ?>
<?php echo $__env->yieldPushContent('head-css'); ?>
</head>
<body>
<div class="page">
	<aside class="app-sidebar" role="navigation">
		<div class="main-sidebar-header">
			<div class="desktop-logo">
				<a href="#" id="btnExit"><img src="<?php echo e(asset('img/logo.png')); ?>" class="main-logo" /></a>
			</div>
		</div>
			<?php echo $__env->make('partials.leftmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
	</aside>
	<div class="main-content">
		<div class="main-header">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-1">
					<button href="#" class="hamburger open-panel nav-toggle">
					<span class="screen-reader-text"></span>
					</button>
					</div>
					<div class="col-sm-11">
						<ul class="menuright">
							<li><b>Welcome :</b> <?php echo e(Auth::user()->DESCRIPTIONS); ?></li>
							<!-- <li>,</li> -->
							<li><b>Company:</b> <?php if(Session::get('company_name')): ?> <?php echo e(Session::get('company_name')); ?> <?php endif; ?></li>
							<!-- <li>,</li> -->
							<li><b>Branch:</b>  <?php if(Session::get('branch_name')): ?> <?php echo e(Session::get('branch_name')); ?> <?php endif; ?></li>  
							<!-- <li>,</li> -->
							<li><b>Login Time :</b> <?php if(Session::get('login_time')): ?> <?php echo e(Session::get('login_time')); ?> <?php endif; ?></li> 
							<li>
								<a class="dropdown-item" href="<?php echo e(route('logout')); ?>"  onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out-alt" aria-hidden="true" style="color:#2d2c2b;font-size:16px;" title="Logout"  ></i>
								</a>
								<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
									<?php echo csrf_field(); ?>
								</form>
							</li>
						</ul>
					</div>
					
				</div>
			</div>
		</div>
		<div class="maintextarea">
			
			<?php echo $__env->yieldContent('content'); ?>
		</div>
	</div> <!-- new-wrapper -->

</div>
<!-- Alert -->
	<?php echo $__env->yieldContent('alert'); ?>
<!-- Alert end-->


	<?php echo $__env->yieldPushContent('bottom-scripts'); ?>
	<?php echo $__env->yieldPushContent('bottom-css'); ?>
	<footer>
	<div class="ftrbx">
	<div class="pgmncntainr">
	<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><p>Copyright B-Square Solutions © 2021</p></div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><p>Powered by B-Square Solutions Pvt. Ltd.</p></div>
	</div></div>
	</div>
	</footer>
</body>
</html><?php /**PATH C:\xampp3\htdocs\PROJECTS\UNICORN_DEV\resources\views/layouts/app.blade.php ENDPATH**/ ?>