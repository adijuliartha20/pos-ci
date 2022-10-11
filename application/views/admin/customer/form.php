<div class="content-i">
   	<div class="content-box">
   		<div class="row">
			<div class="col-sm-12">
				<div class="element-wrapper">
		  			<div class="element-box">
		    			<form id="formValidate" action="<?php echo ADMIN_URL.'/'.$app.'/save'; ?>">
		    				<input type="hidden" id="id_customer" name="id_customer" value="<?php echo (isset($data) && !empty($data) ? $data['id_customer'] :''); ?>" />
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
										<label for="">Nama</label>
										<input id="name" name="name" class="form-control" data-error="Nama wajib diisi" placeholder="Masukkan Nama" required="required" type="text" value="<?php echo (isset($data['name']) && !empty($data['name']) ? $data['name'] :''); ?>">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
					            </div>
					        </div>

					        <div class="row">
					            <div class="col-sm-6">
									<div class="form-group">
										<label for="">Handphone</label>
										<input id="handphone" name="handphone" class="form-control" data-error="Handphone wajib diisi" placeholder="Masukkan No Handphone" required="required" type="text" value="<?php echo (isset($data['handphone']) && !empty($data['handphone']) ? $data['handphone'] :''); ?>">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
					            </div>
					        </div>

					        <div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										  <label for="">Tanggal Lahir</label>
										  <div class="date-input">
										  	<input id="date_of_birth" name="date_of_birth" class="single-daterange form-control" data-error="Tanggal lahir wajib diisi" placeholder="Masukkan Tanggal lahir" required="required" type="text" value="<?php echo (isset($data['date_of_birth']) && !empty($data['date_of_birth']) ? $data['date_of_birth'] :''); ?>">
											<div class="help-block form-text with-errors form-control-feedback"></div>
										  </div>
									</div>  
								</div>
				            </div>

					        <div class="row">
					            <div class="col-sm-6">
									<div class="form-group">
										<label for="">Jenis Kelamin</label>

										<select class="form-control" id="gender" name="gender" data-error="Please select id_gender" placeholder="Select Gender" o>
											
											<?php
												$gender = (isset($data['gender']) ? $data['gender'] : 0);

												$list_gender = array('Perempuan','Laki-laki');

												foreach ($list_gender as $lg => $gen) {
													?>	
													<option value="<?php echo $lg ?>"
														<?php echo ($lg==$gender? 'selected':'') ; ?> >
														<?php echo $gen; ?>
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
										<label for="">Negara</label>

										<select class="form-control" id="id_country" name="id_country" data-error="Please select country" placeholder="Select Country" onchange="get_province(this.value,false)">
											<option value="">Silahkan pilih Negara</option>
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

										<select class="form-control" id="id_province" name="id_province" data-error="Please select province" placeholder="Select Province" onchange="get_district(this.value)">
											<?php						
												
												$id_province = (isset($data['id_province']) ? $data['id_province'] : '');
												foreach ($province as $key => $dc) {
													?>	
													<option value="<?php echo $dc['id_province']; ?>"
														<?php echo ($id_province==$dc['id_province']? 'selected':'') ; ?> >
														<?php echo $dc['name_province']; ?>
													</option>
													<?php
												}											?>
										</select>

										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
					            </div>
					        </div>

					        <div class="row">
					            <div class="col-sm-6">
									<div class="form-group">
										<label for="">Kabupaten</label>

										<select class="form-control" id="id_district" name="id_district" data-error="Please select district" placeholder="Select district" onchange="get_sub_district(this.value)" >
											<?php
												$id_district = (isset($data['id_district']) ? $data['id_district'] : '');
												foreach ($districts as $key => $dc) {
													?>	
													<option value="<?php echo $dc['id_district']; ?>"
														<?php echo ($id_district==$dc['id_district']? 'selected':'') ; ?> >
														<?php echo $dc['name_district']; ?>
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
										<label for="">Nama Kecamatan</label>
										<select class="form-control" id="id_sub_district" name="id_sub_district" data-error="Please select district" placeholder="Select district" onchange="remove_class(this)" >
											<?php
												$id_sub_district = (isset($data['id_sub_district']) ? $data['id_sub_district'] : '');
												foreach ($sub_district as $key => $dc) {
													?>	
													<option value="<?php echo $dc['id_sub_district']; ?>"
														<?php echo ($id_sub_district==$dc['id_sub_district']? 'selected':'') ; ?> >
														<?php echo $dc['name_sub_district']; ?>
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
										<label for="">Alamat</label>
										<textarea id="address" name="address" class="form-control" data-error="Alamat wajib diisi" placeholder="Masukkan Alamat" required="required" rows="3"><?php echo (isset($data['address']) && !empty($data['address']) ? $data['address'] :''); ?></textarea>								
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