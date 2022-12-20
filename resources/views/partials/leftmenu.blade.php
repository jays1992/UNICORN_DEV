<div class="menuleft jquery-accordion-menu"  id="jquery-accordion-menu" >
    <div class="jquery-accordion-menu-header" id="form"></div>
			<!-- <nav class="nav" role="navigation"> -->
			<ul class="nav__list" id="vertical-menu">
			  <!-- first level begin-->
			  @forelse($menu_data as $key1=>$val1)
			  <li><a href="#">{{$key1}}</a>
					<!-- second begin  -->
					<ul class="submenu">				 
						@foreach($val1 as $key2=>$val2)
						<li><a href="#">{{$key2}} </a>
							<!-- third begin  -->
							<ul class="submenu">
								@foreach($val2 as $key3=>$val3)
									<li>
										@if(strtolower($val3['heading'])==='master')
											<a href="{{route('master',[$val3['formid'],'index' ])}}">{{$val3['formname']}}</a>
										@elseif(strtolower($val3['heading'])==='report')
											<a href="{{route('report',[$val3['formid'],'index' ])}}">{{$val3['formname']}}</a>
										@elseif(strtolower($val3['heading'])==='udf')
											<a href="{{route('master',[$val3['formid'],'index' ])}}">{{$val3['formname']}}</a>
										@elseif(strtolower($val3['heading'])==='transactions')
											@php
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
											@endphp
											<a href="{{route('transaction',[$formid,'index' ])}}">{{$val3['formname']}}</a>		
																
										@else
											<a href="#">{{$val3['formname']}}</a>
										@endif
									</li>
								@endforeach
							</ul>
							<!-- third end  -->
						</li>		  
						@endforeach
					</ul>
					<!-- second end  -->
			  </li>	
			  @empty
			  	<li> No Record Found.</li>
			  @endforelse
			  <!-- first level  end-->				
			
			</ul>