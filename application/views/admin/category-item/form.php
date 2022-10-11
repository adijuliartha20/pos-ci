<div class="content-i">
   	<div class="content-box">
   		<div class="row">
			<div class="col-sm-12">
				<div class="element-wrapper">
		  			<div class="element-box">
		    			<form id="formValidate" action="<?php echo ADMIN_URL.'/'.$app.'/save'; ?>">
		    				<input type="hidden" id="id" name="id" value="<?php echo (isset($data) && !empty($data) ? $data['id_cat'] :''); ?>" />
		    				<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
		      				<h5 class="form-header"><?php echo $title.' '.$action; ?></h5>
		      				<div class="form-desc">&nbsp;</a>
							</div>

							<div class="form-group">
								<label for="">Kategori</label>
								<input id="category" name="category" class="form-control" data-error="Nama Kategori Wajib diisi" placeholder="Silahkan Masukkan Nama Kategori" required="required" type="text" value="<?php echo (isset($data) && !empty($data) ? $data['category'] :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>


							<fieldset class="form-group">
								<div class="form-buttons-w">
						            <button class="btn btn-primary" type="submit" id="btn-simpan">Simpan</button>
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