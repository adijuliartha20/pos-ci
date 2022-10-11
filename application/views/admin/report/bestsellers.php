<div class="content-i">
    <div class="content-box">
      	<div class="element-wrapper">
	        <h6 class="element-header">Laporan Barang Terlaris</h6>
			<div class="element-box">
				<form id="form-report" class="form-inline form-desc" action="<?php echo ADMIN_URL.'/report/get-bestsellers-report'; ?>">
			      	<span class="lbl-form-inline">Mulai</span><input class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Start Date" type="text" required="required" id="start" name="start">
			      	<span class="lbl-form-inline">Sampai</span><input class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" placeholder="End Date" type="text" required="required" id="end" name="end">
			      	<span class="lbl-form-inline">Toko</span>
			      	<select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" id="id_store" name="id_store" data-error="Please select Store" placeholder="Select Store" required="required" >
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
					<button class="mr-2 mb-2 btn btn-outline-primary btn-add" type="submit" id="btn-show">Tampilkan</button>
			    </form>				
			    <div id="reports" class="reports"></div>
			</div><!-- END element-box -->	
		</div><!-- END element-wrapper -->	
	</div><!-- END content-box -->
</div><!-- END content i -->
<input type="hidden" id="active_url" value="<?php echo ADMIN_URL.'/'.$app; ?>">