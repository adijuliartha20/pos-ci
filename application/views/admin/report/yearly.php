<div class="content-i">
    <div class="content-box">
      	<div class="element-wrapper">
	        <!--<h6 class="element-header"><?php echo $title; ?> <?php echo $type; ?></span></h6>-->
	        <h6 class="element-header">Laporan Penjualan Tahunan</span></h6>
			<div class="element-box">

				<form id="form-report" class="form-inline form-desc" action="<?php echo ADMIN_URL.'/report/get-yearly-report'; ?>">
			      	<span class="lbl-form-inline">Mulai</span>
			      	<select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" name="start-year">
			      		<?php
							$curr_year = date('Y', time());
							foreach ($years as $key => $year) {
								?>
									<option value="<?php echo $key; ?>" <?php echo ($key==$curr_year?'selected':''); ?> ><?php echo $year; ?></option>
								<?php
							}
						?>	
			      	</select>

			      	<span class="lbl-form-inline">Sampai</span>
			      	<select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" name="end-year">
			      		<?php
							$curr_year = date('Y', time());
							foreach ($years as $key => $year) {
								?>
									<option value="<?php echo $key; ?>" <?php echo ($key==$curr_year?'selected':''); ?> ><?php echo $year; ?></option>
								<?php
							}
						?>	
			      	</select>


			      	<span class="lbl-form-inline">Toko</span>
			      	<select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" id="id_store" name="id_store" data-error="Please select Store" placeholder="Select Store" required="required" >
						<!--<option value="">Select Store</option>-->
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
				
			    <div id="reports" class="reports">
			    	
			    </div>
			    


			</div><!-- END element-box -->	
		</div><!-- END element-wrapper -->	
	</div><!-- END content-box -->
</div><!-- END content i -->
<input type="hidden" id="active_url" value="<?php echo ADMIN_URL.'/'.$app; ?>">