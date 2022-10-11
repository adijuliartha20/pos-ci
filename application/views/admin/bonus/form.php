<div class="content-i">
   	<div class="content-box">
   		<div class="row">
			<div class="col-sm-12">
				<div class="element-wrapper">
		  			<div class="element-box">
		    			<form id="formValidate" action="<?php echo ADMIN_URL.'/'.$app.'/save'; ?>">
		    				<input type="hidden" id="id" name="id" value="<?php echo (isset($data) && !empty($data) ? $data['id_bonus'] :''); ?>" />
		    				<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
		      				<h5 class="form-header"><?php echo $action.' '.$title; ?></h5>
		      				<div class="form-desc"></div>

							
							<div class="form-group">
								<label for="">Batas Awal</label>
								<input id="start" name="start" class="form-control currency" data-error="Batas awal wajib diisi" placeholder="Silahkan masukkan batas awal" required="required" type="text" value="<?php echo (isset($data['start']) && !empty($data['start']) ? number_format($data['start']) :''); ?>" >
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
								<label for="">Batas Akhir</label>
								<input id="end" name="end" class="form-control currency" data-error="Batas akhir wajib diisi" placeholder="Silahkan masukkan batas akhir"  type="text" value="<?php echo (isset($data['end']) && !empty($data['end']) ? number_format($data['end']) :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
								<label for="">Bonus</label>
								<input id="bonus" name="bonus" class="form-control currency" data-error="Bonus wajib diisi" placeholder="Silahkan masukkan bonus" required="required" type="text" value="<?php echo (isset($data['bonus']) && !empty($data['bonus']) ? number_format($data['bonus']) :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							

							<div class="form-group">
								<label for="">Toko</label>
								<select class="form-control" id="id_store" name="id_store" data-error="Toko wajib diisi" placeholder="Silahkan pilih toko" required="required" >
									<option value="">Pilih Toko</option>
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