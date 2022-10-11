<div class="content-i">
    <div class="content-box">
      	<div class="element-wrapper">
	        <!--<h6 class="element-header"><?php echo $title; ?> <?php echo $type; ?></span></h6>-->
	        <h6 class="element-header">Laporan Penjualan Belum Lunas</span></h6>
			<div class="element-box">

				<form id="form-report" class="form-inline form-desc form-report-monthly" action="<?php echo ADMIN_URL.'/report/get-sales-not-paid-report'; ?>">
			      	<span class="lbl-form-inline">Mulai</span>
			      	<select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" name="start-month">
			      		<?php
							$curr_value = date('m', time());
							foreach ($months as $key => $month) {
								?>
									<option value="<?php echo $key; ?>" <?php echo ($key==$curr_value?'selected':''); ?> ><?php echo $month; ?></option>
								<?php
							}
						?>	
			      	</select>

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
			      	<select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" name="end-month">
			      		<?php
							foreach ($months as $key => $month) {
								?>
									<option value="<?php echo $key; ?>" <?php echo ($key==$curr_value?'selected':''); ?> ><?php echo $month; ?></option>
								<?php
							}
						?>	
			      	</select>
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


<div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingFormModal" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-centered" role="document">
	  <div class="modal-content text-center">
	    <button aria-label="Close" class="close" data-dismiss="modal" type="button" id="close-form-payment"><span class="close-label"></span><span class="os-icon os-icon-close"></span></button>
	    <div class="onboarding-media">
	      <img alt="" src="<?php echo base_url().'public/'?>img/bigicon5.png" width="100px">
	    </div>
	    <div class="onboarding-content with-gradient">
	      <h4 class="onboarding-title">
	        Form Bayar
	      </h4>
	      <form id="form-payment" class="form-payment">
	      	<div class="col-sm-12">
	      		<div id="manual-discount-field" class="form-group" style="height: 0px; overflow: hidden;">
				  <label for="">Manual Diskon</label>
				  <input class="form-control currency" placeholder="Manual Discount" type="text" value="" id="manual_discount"onkeyup="calculate_discount(event)">
				</div>
				<div class="form-group">
				  <label for="">Sisa Pembayaran</label>
				  <input type="hidden" value="" disabled="disabled" id="total_payment">
				  <input class="form-control" placeholder="0" type="text" value="" disabled="disabled" id="total_payment_show" onchange="calculate_change(event)">
				</div>				
				<div class="form-group">
				  <label for="">Bayar</label>
				  <input class="form-control currency" placeholder="0" type="text" value="" id="payment" onkeyup="calculate_change(event)" onkeypress="focus_st(event)">
				</div>
				<div class="form-group">
				  <label for="">Kembalian</label>
				  <input class="form-control" placeholder="" type="text" value="" disabled="disabled" id="change">
				</div>
				<div class="form-group">
				  <label for="">Type Pembayaran</label>
				  <select class="form-control" id="payment_type">
				  	<option value="cash">Kas</option>
				  	<option value="bank_transfer">Bank Transfer</option>
				  	<option value="shopee">Shopee</option>
				  	<option value="tokopedia">Tokopedia</option>				  	
				  </select>
				</div>
				<br>
				<div class="form-group">
				  <input type="button" id="save-transaction" value="Simpan Transaksi" class="mr-2 mb-2 btn btn-danger" onclick="save_payment(event)">
				  <input type="hidden" id="id_transaction_edit">
				</div>
			</div>
	      </form>
	    </div>
	  </div>
	</div>
</div>

