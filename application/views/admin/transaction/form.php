<div class="content-i">
    <div class="content-box">
      	<div class="element-wrapper">
	        <h6 class="element-header"><!---<?php echo $title; ?>-->Transaksi : <span id="num-transaction"><?php echo $num_transaction; ?></span></h6>
			<div class="element-box">
				<!--<h5 class="form-header">
                    Powered by Editable-Table
				</h5>-->
				<div class="form-desc clearfix">
					<div class="fleft">
						Mode Reseller &nbsp;:
						<select class="small-select" id="reseller_mode" name="reseller_mode" placeholder="" onChange="reset_table(event)">
							<option value="no">Tidak</option>
							<option value="yes">Iya</option>
						</select>
					</div>
					<div class="fright">Tanggal : <?php echo $date;?> </div>
					
				</div>
				<form  role="form" data-toggle="validator" id="formValidate">
					<fieldset class="form-group">
	            		<legend><span>Data Konsumen</span></legend>
	            		<div class="row">
			              <div class="col-sm-6">
			                <div class="form-group">
			                  <label for="">Nama</label><input class="form-control" placeholder="Nama" type="text" id="name_consumen" required="required">
			                </div>
			              </div>
			              <div class="col-sm-6">
			                <div class="form-group">
			                  <label for="">Telpon</label><input class="form-control" placeholder="Telpon" type="text" id="phone"  required="required">
			                </div>
			              </div>
			            </div>
			            <div class="row">
			              <div class="col-sm-6">
			                <div class="form-group">
			                  <label for="">Kecamatan</label><input class="form-control" placeholder="Kecamatan" type="text" id="sub_district"  required="required">
			                </div>
			              </div>
			              <div class="col-sm-6">
			                <div class="form-group">
			                  <label for="">Kabupaten</label><input class="form-control" placeholder="Kabupaten" type="text" id="district"  required="required">
			                </div>
			              </div>

			              <div class="col-sm-6">
			                <div class="form-group">
			                  <label for="">Provinsi</label><input class="form-control" placeholder="Provinsi" type="text" id="province"  required="required">
			                </div>
			              </div>

			              <div class="col-sm-6">
			                <div class="form-group">
			                  <label for="">Alamat</label><input class="form-control" placeholder="Alamat" type="text" id="address"  required="required">
			                </div>
			              </div>
			              



			              <!--<div class="form-group col-sm-12">
				              <label>Alamat Lengkap</label><textarea class="form-control" rows="3"  id="address"  required="required"></textarea>
				            </div>-->
			            </div>
			            <button class="btn btn-primary" type="submit" id="form-val-btn" style="width: 0px; height: 0px; opacity: 0;"> Submit</button>

	            	</fieldset>
            	</form>

            	<fieldset class="form-group">
            		<legend><span>Data Transaksi</span></legend>
            	</fieldset>



				<form id="form-add-item" class="form-inline">
			      	<input id="id" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Kode" type="text" onkeyup="get_item_data(0)" onkeypress="keyPressEvent(event)">
			      	<input id="item" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Barang" type="text" disabled="disabled">
			      	<input id="price" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Harga" type="text" disabled="disabled">
			      	<input id="discount" class="form-control mb-2 mr-sm-2 mb-sm-0 currency" placeholder="Diskon" type="text"
			      	<?php echo ($dpi=='enable'? '':'disabled="disabled"'); ?> onkeypress="focus_qty(event)">


			      	<input id="qty" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Jumlah" type="number" min="1" onkeypress="keyPressEvent(event)">
			      	<input type="hidden" id="true_price">
			      	<input type="hidden" id="curr_edit" value="">
			      	<input type="hidden" id="is_edit" value="">
			      	<input type="hidden" id="max_tr" value="">
			      	<input type="hidden" id="id_store" value="">
			      	<button class="mr-2 mb-2 btn btn-outline-primary btn-add" type="submit">Tambah</button>
			    </form>
				
				<br>
				<div class="table-responsive">
					<input type="hidden" id="is_manual_code" name="is_manual_code" value="<?php echo $is_manual_code; ?>" />
					<input type="hidden" id="min_length_id" name="min_length_id" value="<?php echo $min_length_id; ?>" />
					<table id="table-transaction" class="table table-editable table-striped table-lightfont">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Barang</th>
								<th>Harga</th>
								<th>Diskon</th>
								<th>Jumlah</th>
								<th>Sub Total</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tfoot>
			    			<tr>
								<th colspan="6">Total</th>
								<th id="total-text">---</th>
								<th><input type="button" name="get-form-pay" value="Bayar" class="mr-2 mb-2 btn btn-danger btn-pay-now" onclick="set_value_form_payment(event)"></th>

								<input type="button" id="show-popup"  data-target="#onboardingFormModal" data-toggle="modal" style="width: 0px; height: 0px; opacity: 0;" >
							</tr>
			    		</tfoot>
						<tbody>
						</tbody>
					</table>
				</div>
			</div><!-- END element-box -->	
		</div><!-- END element-wrapper -->	
	</div><!-- END content-box -->
</div><!-- END content i -->
<input type="hidden" id="active_url" value="<?php echo ADMIN_URL.'/'.$app; ?>">
<input type="hidden" id="state" value="<?php echo $state; ?>">
<input type="hidden" id="discount_per_item" value="<?php echo $dpi; ?>">


<!--<input type="button" name="validate-data" onClick="validate_data()" value="Validate">-->



<!--<button class="mr-2 mb-2 btn btn-primary" data-target="#onboardingFormModal" data-toggle="modal" type="button">Modal with form</button>-->
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
	      <!--<div class="onboarding-text">
	        Please input customer payment
	      </div>-->
	      <form id="form-payment" class="form-payment">
	      	<div class="col-sm-12">
	      		<div id="manual-discount-field" class="form-group" style="height: 0px; overflow: hidden;">
				  <label for="">Manual Diskon</label>
				  <input class="form-control currency" placeholder="Manual Discount" type="text" value="" id="manual_discount"onkeyup="calculate_discount(event)">
				</div>
				<div class="form-group">
				  <label for="">Total</label>
				  <input type="hidden" value="" disabled="disabled" id="total_payment">
				  <input class="form-control" placeholder="Total" type="text" value="" disabled="disabled" id="total_payment_show">
				</div>
				<div class="form-group">
				  <label for="">Bayar</label>
				  <input class="form-control currency" placeholder="Masukkan uang" type="text" value="" id="payment" onkeyup="calculate_change(event)" onkeypress="focus_st(event)">
				</div>
				<div class="form-group">
				  <label for="">Kembalian</label>
				  <input class="form-control" placeholder="" type="text" value="" disabled="disabled" id="change">
				</div>
				<br>
				<div class="form-group">
				  <input type="button" id="save-transaction" value="Simpan Transaksi" class="mr-2 mb-2 btn btn-danger" onclick="save_transaction(event)">
				</div>
			</div>
	      </form>




	    </div>
	  </div>
	</div>
</div>