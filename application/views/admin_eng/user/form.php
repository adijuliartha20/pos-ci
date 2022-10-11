<div class="content-i">
   	<div class="content-box">
   		<div class="row">
			<div class="col-sm-12">
				<div class="element-wrapper">
		  			<div class="element-box">
		    			<form id="formValidate" action="<?php echo ADMIN_URL.'/user/save'; ?>">
		    				<input type="hidden" id="id" name="id" value="<?php echo (isset($user) && !empty($user) ? $user['id_user'] :''); ?>" />
		    				<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
		    				<input type="hidden" id="is_edit_profile" name="is_edit_profile" value="<?php echo $is_edit_profile; ?>" />
		      				<h5 class="form-header"><?php echo $action.' '.$title; ?></h5>
		      				<div class="form-desc">
							Validation of the form is made possible using powerful validator plugin for bootstrap. <a href="http://1000hz.github.io/bootstrap-validator/" target="_blank">Learn more about Bootstrap Validator</a>
							</div>

							<div class="form-group">
								<label for=""> Username</label>
								<input id="username" name="username" class="form-control" data-error="Please input your User Name" placeholder="Enter username" required="required" type="text" value="<?php echo (isset($user) && !empty($user) ? $user['username'] :''); ?>" <?php echo ($mode=='edit'? 'disabled':'') ?>>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for=""> Password</label>
										<input id="password" name="password" class="form-control" data-minlength="6" placeholder="Password" <?php echo ($mode=='edit'? '':'required="required"') ?>  type="password">
										<div class="help-block form-text text-muted form-control-feedback">Minimum of 6 characters</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="">Confirm Password</label>
										<input id="confirm_password" name="confirm_password" class="form-control" data-match-error="Passwords don&#39;t match" placeholder="Confirm Password" <?php echo ($mode=='edit'? '':'required="required"') ?> type="password">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
								</div>
							</div>

							<?php 
								if($_SESSION['access'] == 'admin'){
									?>
										<div class="form-group">
											<label for=""> User Tipe</label>
											<select id="user_tipe" name="user_tipe" class="form-control">
												<?php
													$curr_type = (isset($user) && !empty($user) ? $user['user_tipe'] :'');
													$arr = array('admin'=>'Admin','editor'=>'Editor','viewer'=>'Viewer');

													foreach ($arr as $key => $value) {
														?>
															<option value="<?php echo $key; ?>" <?php echo ($key==$curr_type?'selected':''); ?> ><?php echo $value; ?></option>
														<?php
													}
												?>
								            </select>	
										</div>
									<?php
								} 

							?>
							


							<fieldset class="form-group">
					            <legend><span>Profile</span></legend>
					            <div class="row">
					            	<div class="col-sm-6">
					            		<div class="form-group">
					            			<label for=""> First Name</label>
					            			<input id="first_name" name="first_name" class="form-control" data-error="Please input your First Name" placeholder="First Name" required="required" type="text" value="<?php echo (isset($user) && !empty($user) ? $user['first_name'] :''); ?>">
					                  		<div class="help-block form-text with-errors form-control-feedback"></div>
					            		</div>
					            	</div>
					            	<div class="col-sm-6">
					            		<div class="form-group">
					            			<label for="">Last Name</label>
					            			<input id="last_name" name="last_name" class="form-control" data-error="Please input your Last Name" placeholder="Last Name" required="required" type="text" value="<?php echo (isset($user) && !empty($user) ? $user['last_name'] :''); ?>">
					                  		<div class="help-block form-text with-errors form-control-feedback"></div>
					            		</div>
					            	</div>
					            </div>

					            <div class="form-group">
									<label for="">Gender</label>
									<select id="gender" name="gender" class="form-control">
										<?php
											$curr_gender = (isset($user) && !empty($user) ? $user['gender'] :'');
											$arr_gender = array('men'=>'Men','ladies'=>'Ladies');

											foreach ($arr_gender as $key => $value) {
												?>
													<option value="<?php echo $key; ?>" <?php echo ($key==$curr_gender?'selected':''); ?> ><?php echo $value; ?></option>
												<?php
											}
										?>
						            </select>	
								</div>
								<div class="form-group">
					              	<label>Address</label>
					              	<textarea id="address" name="address" class="form-control" rows="3"><?php echo (isset($user) && !empty($user) ? $user['address'] :''); ?></textarea>
					            </div>
					            <div class="form-group">
						            <label for=""> Email address</label>
						            <input id="email" name="email" class="form-control" data-error="Your email address is invalid" placeholder="Enter email" required="required" type="email"  value="<?php echo (isset($user) && !empty($user) ? $user['email'] :''); ?>">
						            <div class="help-block form-text with-errors form-control-feedback"></div>
						        </div>

						        <div class="form-group">
									<label for=""> Phone</label>
									<input id="phone" name="phone" class="form-control" data-error="Please input your Phone Number" placeholder="Enter phone" required="required" type="text"  value="<?php echo (isset($user) && !empty($user) ? $user['phone'] :''); ?>">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>

								<div class="form-group">
									<label for=""> Picture</label>
									<input id="picture" name="picture" class="form-control" data-error="Please select picture" placeholder="Insert Picture" type="file" <?php echo ($mode=='edit'? '':'required="required"') ?>>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								<div class="form-buttons-w">
						            <button class="btn btn-primary" type="submit"> Submit</button>
						        </div>
						        <div id="alert-form" class="alert-form clearfix">
						        	<div id="alert" class="alert alert-success" role="alert">
						        		<div id="middle-alert" class="middle-alert"></div>
								    </div>	
						        </div>
						        
					        </fieldset>   
		      			</form>
		      		</div>
		      	</div>
		    </div>
		</div>
	</div>
</div>