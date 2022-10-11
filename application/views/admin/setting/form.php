<div class="content-i">
   	<div class="content-box">
   		<div class="row">
			<div class="col-sm-12">
				<div class="element-wrapper">
		  			<div class="element-box">
		    			<form id="formValidate" action="<?php echo ADMIN_URL.'/'.$app.'/save'; ?>">
		      				<h5 class="form-header"><?php echo $title; ?></h5>
		      				<div class="form-desc"></div>

		      				<fieldset class="form-group-w" style="padding-bottom: 30px;">
								<div class="form-buttons--ww">
						            <button class="btn btn-primary" type="submit" id="btn-save">Simpan</button>
						        </div>
						        <div id="alert-form" class="alert-form clearfix" >
						        	<div id="alert" class="alert alert-success" role="alert">
						        		<div id="middle-alert" class="middle-alert"></div>
								    </div>	
						        </div>
						        
					        </fieldset>

							<div class="form-group">
								<label for=""><h6>Kode Manual</h6></label>
								<select class="form-control" id="manual_code" name="manual_code" data-error="Please select option manual code" placeholder="Select Manual Code" required="required">
									<?php
										$curr_value = (isset($manual_code) && !empty($manual_code) ? $manual_code :'');
										$arr = array('no'=>'Tidak Aktif','yes'=>'Aktif');

										foreach ($arr as $key => $value) {
											?>
												<option value="<?php echo $key; ?>" <?php echo ($key==$curr_value?'selected':''); ?> ><?php echo $value; ?></option>
											<?php
										}
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<p>&nbsp;</p>

							<div class="form-group">
								<label for=""><h6>Tanggal Manual</h6></label>
								<select class="form-control" id="manual_date" name="manual_date" data-error="Please select option manual date" placeholder="Select Manual Date" required="required">
									<?php
										$curr_value = (isset($manual_date) && !empty($manual_date) ? $manual_date :'');
										$arr = array('no'=>'Tidak Aktif','yes'=>'Aktif');

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
								<input id="manual_date_value" name="manual_date_value" class="single-daterange form-control" data-error="Please input date value" placeholder="Enter date value" type="text" value="<?php echo (isset($manual_date_value) && !empty($manual_date_value) ? $manual_date_value :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<p>&nbsp;</p>


							
							<h6>Diskon Per Transaksi</h6>
							<div class="form-group">
								<select class="form-control" id="type_discount" name="type_discount" data-error="Please select type discount" placeholder="Select Type Discount" onchange="mode_discount(event);">
									<option value="">Pilih Tipe</option>
									<?php
										$curr_value = (isset($type_discount) && !empty($type_discount) ? $type_discount :'');
										$arr = array('percent'=>'Persen','value'=>'Nilai');

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
								<input id="discount" name="discount" class="form-control currency" data-error="Please input discount" placeholder="Enter discount" type="text" value="<?php echo (isset($discount) && !empty($discount) ? number_format($discount) :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>

							<div class="form-group">
								<label for=""><h6>Diskon Per Barang</h6></label>
								<select class="form-control" id="discount_per_item" name="discount_per_item" data-error="Please select option manual code" placeholder="" required="required">
									<?php
										$curr_value = (isset($discount_per_item) && !empty($discount_per_item) ? $discount_per_item :'');
										$arr = array('disable'=>'Tidak Aktif','enable'=>'Aktif');

										foreach ($arr as $key => $value) {
											?>
												<option value="<?php echo $key; ?>" <?php echo ($key==$curr_value?'selected':''); ?> ><?php echo $value; ?></option>
											<?php
										}
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<p>&nbsp;</p>
							<div class="form-group">
								<label for=""><h6>Lipatkan Penjualan</h6></label>
								<select class="form-control" id="fold" name="fold" data-error="Please select option fold" placeholder="Select fold" required="required">
									<?php
										$curr_value = (isset($fold) && !empty($fold) ? $fold :'');

										for ($i=1; $i <= 10; $i++) { 
											?>
												<option value="<?php echo $i; ?>" <?php echo ($i==$curr_value?'selected':''); ?> ><?php echo $i; ?></option>
											<?php
										}
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<p>&nbsp;</p>
							<h6>Batas Grafik</h6>
							<div class="form-group">
								<input id="limit_month" name="limit_month" class="form-control currency" data-error="batas atas penjualan per bulan wajib diisi" placeholder="Masukkan batas atas penjualan per bulan" type="text" value="<?php echo (isset($limit_month) && !empty($limit_month) ? number_format($limit_month) :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">	
								<input id="limit_year" name="limit_year" class="form-control currency" data-error="batas atas penjualan per tahun wajib diisi" placeholder="Masukkan batas atas penjualan per tahun" type="text" value="<?php echo (isset($limit_year) && !empty($limit_year) ? number_format($limit_year) :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>



							<fieldset class="form-group">
								<div class="form-buttons-w">
						            <button class="btn btn-primary" type="submit" id="btn-save">Simpan</button>
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