<div class="menuleft jquery-accordion-menu"  id="jquery-accordion-menu" >
    <div class="jquery-accordion-menu-header" id="form"></div>
			<!-- <nav class="nav" role="navigation"> -->
			<ul class="nav__list" id="vertical-menu">
			  <!-- first level begin-->
			  <?php $__empty_1 = true; $__currentLoopData = $menu_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1=>$val1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
			  <li><a href="#"><?php echo e($key1); ?></a>
					<!-- second begin  -->
					<ul class="submenu">				 
						<?php $__currentLoopData = $val1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2=>$val2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><a href="#"><?php echo e($key2); ?> </a>
							<!-- third begin  -->
							<ul class="submenu">
								<?php $__currentLoopData = $val2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key3=>$val3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li>
										<?php if(strtolower($val3['heading'])==='master'): ?>
											<a href="<?php echo e(route('master',[$val3['formid'],'index' ])); ?>"><?php echo e($val3['formname']); ?></a>
										<?php elseif(strtolower($val3['heading'])==='report'): ?>
											<a href="<?php echo e(route('report',[$val3['formid'],'index' ])); ?>"><?php echo e($val3['formname']); ?></a>
										<?php elseif(strtolower($val3['heading'])==='udf'): ?>
											<a href="<?php echo e(route('master',[$val3['formid'],'index' ])); ?>"><?php echo e($val3['formname']); ?></a>
										<?php elseif(strtolower($val3['heading'])==='transactions'): ?>
											<?php
												$formid = (int)$val3['formid'];
												if(strpos(strtolower($val3['formname']), "amendment") !== false ){
													$formid--;
												}
												else if($formid == 487 ){
													$formid = 36;
												}
												else{
													$formid;
												}
											?>
											<a href="<?php echo e(route('transaction',[$formid,'index' ])); ?>"><?php echo e($val3['formname']); ?></a>		
																
										<?php else: ?>
											<a href="#"><?php echo e($val3['formname']); ?></a>
										<?php endif; ?>
									</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
							<!-- third end  -->
						</li>		  
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
					<!-- second end  -->
			  </li>	
			  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
			  	<li> No Record Found.</li>
			  <?php endif; ?>
			  <!-- first level  end-->				
			
			</ul><?php /**PATH C:\xampp3\htdocs\PROJECTS\UNICORN_DEV\resources\views/partials/leftmenu.blade.php ENDPATH**/ ?>