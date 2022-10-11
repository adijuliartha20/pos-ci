<div class="content-i">
   	<div class="content-box">
   		<div class="row">
			<div class="col-sm-12">
				<div class="element-wrapper">
		  			<div class="element-box">
		    			<form id="formValidate" action="<?php echo ADMIN_URL.'/'.$app.'/save'; ?>">
		    				<input type="hidden" id="id" name="id" value="<?php echo (isset($data) && !empty($data) ? $data['id_store'] :''); ?>" />
		    				<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
		      				<h5 class="form-header"><?php echo $action.' '.$title; ?></h5>
		      				<div class="form-desc">
							Validation of the form is made possible using powerful validator plugin for bootstrap. <a href="http://1000hz.github.io/bootstrap-validator/" target="_blank">Learn more about Bootstrap Validator</a>
							</div>

							<div class="form-group">
								<label for="">Store</label>
								<input id="store" name="store" class="form-control" data-error="Please input Store Name" placeholder="Enter Store" required="required" type="text" value="<?php echo (isset($data) && !empty($data) ? $data['store'] :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
				              	<label>Address</label>
				              	<textarea id="address" name="address" class="form-control" rows="3"><?php echo (isset($data) && !empty($data) ? $data['address'] :''); ?></textarea>
				            </div>
							
							


							<fieldset class="form-group">
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