<div class="content-i">
   	<div class="content-box">
   		<div class="row">
			<div class="col-sm-12">
				<div class="element-wrapper">
		  			<div class="element-box">
		    			<form id="formValidate" action="<?php echo ADMIN_URL.'/'.$app.'/save'; ?>">
		    				<input type="hidden" id="id" name="id" value="<?php echo (isset($data) && !empty($data) ? $data['id_item'] :''); ?>" />
		    				<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
		      				<h5 class="form-header"><?php echo $action.' '.$title; ?></h5>
		      				<div class="form-desc">
								<div id="alert-form" class="alert-form clearfix">
						        	<div id="alert" class="alert alert-success" role="alert">
						        		<div id="middle-alert" class="middle-alert"></div>
								    </div>	
						        </div>

					        </div>

							
							<div class="form-group">
								<label for="">ID</label>
								<input id="id_item" name="id_item" class="form-control" type="text" value="<?php echo (isset($data['id_item']) && !empty($data['id_item']) ? $data['id_item'] :''); ?>" disabled>
							</div>

							<div class="form-group">
								<label for="">Manual ID</label>
								<input id="mid" name="mid" class="form-control" data-error="Please input Manual ID" placeholder="Enter Manual ID" 
										<?php echo (isset($is_manual_code) && $is_manual_code=='yes'?'required="required"':'') ?>  type="text" value="<?php echo (isset($data['mid']) && !empty($data['mid']) ? $data['mid'] :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
								<label for="">Name</label>
								<input id="item" name="item" class="form-control" data-error="Please input Name" placeholder="Enter Name" required="required" type="text" value="<?php echo (isset($data['item']) && !empty($data['item']) ? $data['item'] :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
								<label for="">Category</label>
								<select class="form-control" id="id_cat" name="id_cat" data-error="Please select Category Item" placeholder="Select Category Item" required="required" >
									<option value="">Category</option>
									<?php
										$curr_value = (isset($data['id_cat']) && !empty($data['id_cat']) ? $data['id_cat'] :'');
										$arr = $category;
										foreach ($arr as $key => $dt) {
											$id_curr = $dt['id_cat'];
											$val_curr = $dt['category'];
											?>
												<option value="<?php echo $id_curr; ?>" <?php echo ($id_curr==$curr_value?'selected':''); ?> ><?php echo $val_curr; ?></option>
											<?php
										}
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>							
							<div class="form-group">
								<label for="">Sub Total</label>
								<input id="sub_total" name="sub_total" class="form-control currency" data-error="Please input Sub total" placeholder="Enter Sub total" type="text" value="" onkeyup="set_capital_price(event)">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
								<label for="">Qty</label>
								<input id="qty" name="qty" class="form-control currency" data-error="Please input Qty" placeholder="Enter Qty" type="numeric" value="<?php echo (isset($data['qty']) && !empty($data['qty']) ? number_format($data['qty']) :''); ?>" onkeyup="set_capital_price(event)">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
								<label for="">Capital Price</label>
								<input id="capital_price" name="capital_price" class="form-control currency" data-error="Please input Capital Price" placeholder="Enter Capital Price" required="required" type="text" value="<?php echo (isset($data['capital_price']) && !empty($data['capital_price']) ? number_format($data['capital_price']) :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
								<label for="">Reseller Price</label>
								<input id="reseller_price" name="reseller_price" class="form-control currency" data-error="Please input Reseller Price" placeholder="Enter Reseller Price"  type="text" value="<?php echo (isset($data['reseller_price']) && !empty($data['reseller_price']) ? number_format($data['reseller_price']) :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
								<label for="">Price</label>
								<input id="price" name="price" class="form-control currency" data-error="Please input Price" placeholder="Enter Price" required="required" type="text" value="<?php echo (isset($data['price']) && !empty($data['price']) ? number_format($data['price']) :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
								<label for="">Type Discount</label>
								<select class="form-control" id="type_discount" name="type_discount" data-error="Please select type discount" placeholder="Select Type Discount" onchange="mode_discount(event);">
									<option value="">Select Type</option>
									<?php
										$curr_value = (isset($data['type_discount']) && !empty($data['type_discount']) ? $data['type_discount'] :'');
										$arr = array('percent'=>'Percent','value'=>'Value');

										foreach ($arr as $key => $value) {
											?>
												<option value="<?php echo $key; ?>" <?php echo ($key==$curr_value?'selected':''); ?> ><?php echo $value; ?></option>
											<?php
										}
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>

							<div class="form-group">
								<label for="">Discount</label>
								<input id="discount" name="discount" class="form-control currency" data-error="Please input discount" placeholder="Enter discount" type="text" value="<?php echo (isset($data['discount']) && !empty($data['discount']) ? number_format($data['discount']) :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>

							<div class="form-group">
								<label for="">Discount Plus</label>
								<input id="plus_discount" name="plus_discount" class="form-control currency" data-error="Please input plus discount" placeholder="Enter plus discount" type="text" value="<?php echo (isset($data['plus_discount']) && !empty($data['plus_discount']) ? number_format($data['plus_discount']) :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>

							<div class="form-group">
								<label for="">Store</label>
								<select class="form-control" id="id_store" name="id_store" data-error="Please select Store" placeholder="Select Store" required="required" >
									<option value="">Select Store</option>
									<?php
										$curr_value = (isset($data['id_store']) && !empty($data['id_store']) ? $data['id_store'] :'');
										$arr = $store;
										foreach ($arr as $key => $dt) {
											$id_curr = $dt['id_store'];
											$val_curr = $dt['store'];
											?>
												<option value="<?php echo $id_curr; ?>" <?php echo ($id_curr==$curr_value?'selected':''); ?> ><?php echo $val_curr; ?></option>
											<?php
										}
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>

							<fieldset class="form-group">
								<div class="form-buttons-w">
						            <button class="btn btn-primary" type="submit"> Submit</button>
						        </div>
						        
						        
					        </fieldset>   
		      			</form>
		      		</div>
		      	</div>
		    </div>
		</div>
	</div>
</div>