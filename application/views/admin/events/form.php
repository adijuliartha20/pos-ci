<div class="content-i">
   	<div class="content-box">
   		<div class="row">
			<div class="col-sm-12">
				<div class="element-wrapper">
		  			<div class="element-box">
		    			<form id="formValidate" action="<?php echo ADMIN_URL.'/'.$app.'/save'; ?>">
		    				<input type="hidden" id="id" name="id" value="<?php echo (isset($data) && !empty($data) ? $data['id_event'] :''); ?>" />
		    				<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
		      				<h5 class="form-header"><?php echo $action.' '.$title; ?></h5>
		      				<div class="form-desc">&nbsp;</a>
							</div>

							<div class="form-group">
								<label for="">Nama</label>
								<input id="event" name="event" class="form-control" data-error="Nama wajib diisi" placeholder="Silahkan masukkan nama" required="required" type="text" value="<?php echo (isset($data) && !empty($data) ? $data['event'] :''); ?>">
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group">
								<label for="">Tanggal</label>
								
								<div id="list-date" class="list-date">
									<div id="first-item-date" class="item-date clearfix date-input">
										<input class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0 date fleft" placeholder="Date" type="text" required="required" name="date[]" value="<?php echo $date;?>">	
										<?php if($mode=='create') {?>
										<a href="#" class="icon-control fleft" onclick="add_item_date(event);"><i class="icon-plus"></i></a>
										<?php }?>
									</div>				
								</div>
								
							</div>



							


							<fieldset class="form-group">
								<div class="form-buttons-w">
						            <button id="btn-save" class="btn btn-primary" type="submit">Simpan</button>
						        </div>
						        <div id="alert-form" class="alert-form clearfix">
						        	<div id="alert" class="alert alert-success" role="alert">
						        		<div id="middle-alert" class="middle-alert"></div>
								    </div>	
						        </div>
						        
					        </fieldset>   
		      			</form>

		      			<div id="temp-date" class="temp-date">
							<div class="item-date clearfix date-input">
								<input class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0 date fleft" placeholder="Date" type="text" required="required" name="date[]">	
								<a href="#" class="icon-control fleft" onclick="delete_item_date(event);"><i class="icon-minus"></i></a>
							</div>	
						</div>

		      		</div>
		      	</div>
		    </div>
		</div>
	</div>
</div>