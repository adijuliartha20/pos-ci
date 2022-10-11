<div class="content-i">
   	<div class="content-box">
   		<div class="row">
			<div class="col-sm-12">
				<div class="element-wrapper">
		  			<div class="element-box">
		    			<form id="formValidate" action="<?php echo ADMIN_URL.'/'.$app.'/save'; ?>">
		    				<input type="hidden" id="id_country" name="id_country" value="<?php echo (isset($data) && !empty($data) ? $data['id_country'] :''); ?>" />
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
										<label for="">Name Negara</label>
										<input id="name_country" name="name_country" class="form-control" data-error="Nama Negara wajib diisi" placeholder="Masukkan Nama Negara" required="required" type="text" value="<?php echo (isset($data['name_country']) && !empty($data['name_country']) ? $data['name_country'] :''); ?>">
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