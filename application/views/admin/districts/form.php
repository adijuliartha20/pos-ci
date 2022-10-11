<div class="content-i">
   	<div class="content-box">
   		<div class="row">
			<div class="col-sm-12">
				<div class="element-wrapper">
		  			<div class="element-box">
		    			<form id="formValidate" action="<?php echo ADMIN_URL.'/'.$app.'/save'; ?>">
		    				<input type="hidden" id="id_district" name="id_district" value="<?php echo (isset($data) && !empty($data) ? $data['id_district'] :''); ?>" />
		    				<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
		      				<h5 class="form-header"><?php echo $action.' '.$title; ?></h5>
		      				<div class="form-desc">
								<div id="alert-form" class="alert-form clearfix">
						        	<div id="alert" class="alert alert-success" role="alert">
						        		<div id="middle-alert" class="middle-alert"></div>
								    </div>	
						        </div>
					        </div>

					        <div class="row">
					            <div class="col-sm-6">
									<div class="form-group">
										<label for="">Negara</label>

										<select class="form-control" id="id_country" name="id_country" data-error="Please select country" placeholder="Select Country" onchange="get_province(this.value)">
											<?php
												$id_country = (isset($data['id_country']) ? $data['id_country'] : '');
												foreach ($country as $key => $dc) {
													?>	
													<option value="<?php echo $dc['id_country']; ?>"
														<?php echo ($id_country==$dc['id_country']? 'selected':'') ; ?> >
														<?php echo $dc['name_country']; ?>
													</option>
													<?php
												}
											?>
										</select>

										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
					            </div>
					        </div>

					        <div class="row">
					            <div class="col-sm-6">
									<div class="form-group">
										<label for="">Provinsi</label>

										<select class="form-control" id="id_province" name="id_province" data-error="Please select country" placeholder="Select Country" >
											<?php
												$id_province = (isset($data['id_province']) ? $data['id_province'] : '');
												foreach ($province as $key => $dc) {
													?>	
													<option value="<?php echo $dc['id_province']; ?>"
														<?php echo ($id_province==$dc['id_province']? 'selected':'') ; ?> >
														<?php echo $dc['name_province']; ?>
													</option>
													<?php
												}
											?>
										</select>

										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
					            </div>
					        </div>  
					        

					        <div class="row">
					            <div class="col-sm-6">
									<div class="form-group">
										<label for="">Nama Kabupaten</label>
										<input id="name_district" name="name_district" class="form-control" data-error="Nama Kabupaten wajib diisi" placeholder="Masukkan Nama Kabupaten" required="required" type="text" value="<?php echo (isset($data['name_district']) && !empty($data['name_district']) ? $data['name_district'] :''); ?>">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
					            </div>
					          </div>

					        

							<fieldset class="form-group">
								<div class="form-buttons-w">
						            <button class="btn btn-primary" type="submit" id="btn-save">Simpan</button>
						        </div>  
					        </fieldset>   

		      			</form>
		      		</div>
		      	</div>
		    </div>
		</div>
	</div>
</div>

<input type="hidden" id="active_url" value="<?php echo ADMIN_URL.'/'.$app; ?>">