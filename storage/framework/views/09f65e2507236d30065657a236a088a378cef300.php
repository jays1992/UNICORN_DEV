<?php $__env->startSection('content'); ?>


    <div class="container-fluid topnav">
            <div class="row">
                <div class="col-lg-2">
                <a href="<?php echo e(route('master',[93,'index'])); ?>" class="btn singlebt">General Ledger Master</a>
                </div><!--col-2-->

                <div class="col-lg-10 topnav-pd">
                <button class="btn topnavbt" id="btnAdd" disabled="disabled"><i class="fa fa-plus"></i> Add</button>
                        <button class="btn topnavbt" id="btnEdit" disabled="disabled"><i class="fa fa-edit"></i> Edit</button>
                        <button class="btn topnavbt" id="btnSaveSE" disabled="disabled"><i class="fa fa-save"></i> Save</button>
                        <button class="btn topnavbt" id="btnView" disabled="disabled"><i class="fa fa-eye"></i> View</button>
                        <button class="btn topnavbt" id="btnPrint" disabled="disabled"><i class="fa fa-print"></i> Print</button>
                        <button class="btn topnavbt" id="btnUndo"  disabled="disabled"><i class="fa fa-undo"></i> Undo</button>
                        <button class="btn topnavbt" id="btnCancel" disabled="disabled"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn topnavbt" id="btnApprove" disabled="disabled"><i class="fa fa-lock"></i> Approved</button>
                        <button class="btn topnavbt"  id="btnAttach" disabled="disabled"><i class="fa fa-link"></i> Attachment</button>
                        <button class="btn topnavbt" id="btnExit" ><i class="fa fa-power-off"></i> Exit</button>
                </div><!--col-10-->

            </div><!--row-->
    </div><!--topnav-->	
   
    <div class="container-fluid purchase-order-view filter">     
          <div class="inner-form">
          
                <div class="row">
                  <div class="col-lg-1 pl"><p>GL Code</p></div>
                  <div class="col-lg-2 pl">
                    <label> <?php echo e($objResponse->GLCODE); ?> </label>
                  </div>
               
                  <div class="col-lg-2 pl"><p>Name</p></div>
                  <div class="col-lg-4 pl">
                    <label> <?php echo e($objResponse->GLNAME); ?> </label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-1 pl"><p>Alias</p></div>
                  <div class="col-lg-2 pl">
                    <label> <?php echo e($objResponse->ALIAS); ?> </label>
                  </div>
               
                  <div class="col-lg-2 pl"><p>Account Sub Group</p></div>
                  <div class="col-lg-2 pl">
                  <?php $__currentLoopData = $objAccountSubGroupList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $AsgList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label> <?php echo e($objResponse->ASGID_REF==$AsgList->ASGID?$AsgList->ASGCODE.' - '.$AsgList->ASGNAME:''); ?></label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                </div>

                <div class="row">
                <div class="col-lg-2 pl"><p>De-Activated</p></div>
                <div class="col-lg-1 pl">
                <label> <?php echo e($objResponse->DEACTIVATED == 1 ? "Yes" : ""); ?> </label>
                
                </div>
                
                <div class="col-lg-2 pl"><p>Date of De-Activated</p></div>
                <div class="col-lg-2 pl">
                  <label> <?php echo e((is_null($objResponse->DODEACTIVATED) || $objResponse->DODEACTIVATED=='1900-01-01' )?'':
                  \Carbon\Carbon::parse($objResponse->DODEACTIVATED)->format('d/m/Y')); ?> </label>
                </div>
              </div>

                <div class="row">
                  <br/>
                </div>
                
                <div class="row">
                  <div class="col-lg-3 pl"><p>Checks Flag</p></div>
                </div>
                
                <div class="row">
                  <div class="col-lg-2 pl "><p>Cost Centre Applicable</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                    <label>             
                      <?php if($objResponse->CC == "1"): ?>
                          Yes
                      <?php elseif($objResponse->CC == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                  
                  <div class="col-lg-2 pl col-md-offset-2"><p>Sub Ledger</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                    
                    <label>             
                      <?php if($objResponse->SUBLEDGER == "1"): ?>
                          Yes
                      <?php elseif($objResponse->SUBLEDGER == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                </div>
                
                <div class="row">
                  <div class="col-lg-2 pl"><p>Bank Account</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                    
                    <label>             
                      <?php if($objResponse->BANKAC == "1"): ?>
                          Yes
                      <?php elseif($objResponse->BANKAC == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                  
                  <div class="col-lg-2 pl col-md-offset-2"><p>Belong to GST</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
              
                    <label>             
                      <?php if($objResponse->GST == "1"): ?>
                          Yes
                      <?php elseif($objResponse->GST == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                </div>
                
                <div class="row">
                  <div class="col-lg-2 pl"><p>GST Calculate on this GL</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                   
                    <label>             
                      <?php if($objResponse->GST_ON_THISGL == "1"): ?>
                          Yes
                      <?php elseif($objResponse->GST_ON_THISGL == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                  
                  <div class="col-lg-2 pl col-md-offset-2"><p>Belong to TDS</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                   
                    <label>             
                      <?php if($objResponse->TDS == "1"): ?>
                          Yes
                      <?php elseif($objResponse->TDS == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                </div>
                
                <div class="row">
                  <div class="col-lg-2 pl"><p>Inventory Values are affected</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                   
                    <label>             
                      <?php if($objResponse->IVAFFECTED == "1"): ?>
                          Yes
                      <?php elseif($objResponse->IVAFFECTED == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                  
                  <div class="col-lg-2 pl col-md-offset-2"><p>Interest Calculation</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                   
                    <label>             
                      <?php if($objResponse->ICALCULATION == "1"): ?>
                          Yes
                      <?php elseif($objResponse->ICALCULATION == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                </div>
                
                <div class="row">
                  <div class="col-lg-2 pl"><p>Use for Payroll</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                   
                    <label>             
                      <?php if($objResponse->UPAYROLL == "1"): ?>
                          Yes
                      <?php elseif($objResponse->UPAYROLL == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                  
                  <div class="col-lg-2 pl col-md-offset-2"><p>Belong to VAT </p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                    
                    <label>             
                      <?php if($objResponse->VAT == "1"): ?>
                          Yes
                      <?php elseif($objResponse->VAT == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                </div>
                
                <div class="row">
                  <div class="col-lg-2 pl "><p>Belong to Service Tax</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                   
                    <label>             
                      <?php if($objResponse->TAX == "1"): ?>
                          Yes
                      <?php elseif($objResponse->TAX == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                  
                  <div class="col-lg-2 pl col-md-offset-2"><p>Belong to Sale (Revenue)</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                   
                    <label>             
                      <?php if($objResponse->SALE == "1"): ?>
                          Yes
                      <?php elseif($objResponse->SALE == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                </div>
                
                <div class="row">
                  <div class="col-lg-2 pl "><p>Belong to Purchase</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
        
                   
                    <label>             
                      <?php if($objResponse->PURCHASE == "1"): ?>
                          Yes
                      <?php elseif($objResponse->PURCHASE == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                  
                  <div class="col-lg-2 pl col-md-offset-2"><p>Belong to TCS</p></div>
                  <div class="col-lg-1 pl">
                    <div class="col-lg-11 pl">
                    
                    <label>             
                      <?php if($objResponse->TCS == "1"): ?>
                          Yes
                      <?php elseif($objResponse->TCS == "0"): ?>
                          No
                      <?php else: ?>
                          
                      <?php endif; ?>
                    </label>
                    </div>
                  </div>	
                </div>



                
              





          

          </div>

    </div><!--purchase-order-view-->

    <script>
     $('#btnAdd').on('click', function() {
      var viewURL = '<?php echo e(route("master",[93,"add"])); ?>';
      window.location.href=viewURL;
  });

  $('#btnExit').on('click', function() {
    var viewURL = '<?php echo e(route('home')); ?>';
    window.location.href=viewURL;
  });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\bsquareappfordemo.com\UNICORN\resources\views\masters\Accounts\GENERALLEDGER\mstfrm93view.blade.php ENDPATH**/ ?>