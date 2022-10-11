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
				<fieldset class="form-group">
            		<legend><span>Konsumen</span></legend>
            	</fieldset>
            	<table class="table-dt-cust">
            		<tr>
            			<td>
            				<table>
            					<tr><td>Nama</td><td>&nbsp;:&nbsp;</td><td><span id="name">-</span></td></tr>
            					<tr><td>Telepon</td><td>&nbsp;:&nbsp;</td><td><span id="handphone">-</span></td></tr>
            					<tr><td>Jenis Kelamin</td><td>&nbsp;:&nbsp;</td><td><span id="gender">-</span></td></tr>
            				</table>
            			</td>	
            			<td>
            				<table>
            					<tr><td>Lahir</td><td>&nbsp;:&nbsp;</td><td><span id="date_of_birth">-</span></td></tr>
            					<tr><td>Alamat</td><td>&nbsp;:&nbsp;</td><td><span id="address">-</span></td></tr>	
            				</table>            				
            			</td>
            		</tr>
            	</table>
            	<input type="hidden" id="id_customer">
            	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title">Cari Konsumen</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body form-inline">
				        	Pilih Berdasarkan&nbsp;
				        	<select id="search_by" class="form-control mb-2 mr-sm-2 mb-sm-0">
				        		<option value="name">Nama</option>
				        		<option value="handphone">Handphone</option>
				        	</select>
				        	<input type="text" id="search" placeholder="Silahkan ketik disini..." class="form-control mb-2 mr-sm-2 mb-sm-0" value="">
				        	<button type="button" class="btn btn-primary" onclick="search_customer()">Cari</button>

				        	<div class="table-pilih-cust table-responsive demo-icons-list">
							    <table id="table-search" class="table table-bordered table-lg table-v2 table-striped">
							      <thead>
							        <tr>							          
							          <th>
							            Nama
							          </th>
							          <th>
							            Handphone
							          </th>
							          <th>
							            Alamat
							          </th>
							          <th>
							            
							          </th>
							        </tr>
							      </thead>
							      <tbody id="tbody-customer">
							        <tr>
							          <td>
							            John Mayers
							          </td>
							          <td>
							            081246273068
							          </td>
							          <td>
							            Jalan Sedap Malam Gang Gardenia III No 19 - Denpasar Timur, Denpasar, Bali, Indonesia
							          </td>
							          <td>
							            <a href="#">Pilih</a>
							          </td>							          
							        </tr>
							        <tr>
							          <td>
							            Mike Astone
							          </td>
							          <td>
							            081727227262
							          </td>
							          <td>
							            Jalan Nusa Indah Gang XXI no 6 - Denpasar Timur, Denpasar, Bali, Indonesia
							          </td>
							          <td>
							            <a href="#">Pilih</a>
							          </td>
							        </tr>
							        <tr>
							          <td>
							            Kira Knight
							          </td>
							          <td>
							            08762627728
							          </td>
							          <td>
							            Jalan Manggis No 16 - Sengkidu, Manggis, Karangasem, Bali
							          </td>
							          <td>
							            <a href="#">Pilih</a>
							          </td>
							        </tr>            
							      </tbody>
							    </table>
							</div>
				      	</div>
				      	
				    </div>
				  </div>
				</div>



				<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Pilih Konsumen</button>

            	<fieldset class="form-group">
            		<legend><span>Pesanan</span></legend>
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
				<div class="form-group">
				  <label for="">Type Pembayaran</label>
				  <select class="form-control" id="payment_type">
				  	<option value="cash">Kas</option>
				  	<option value="bank_transfer">Bank Transfer</option>
				  	<option value="shopee">Shopee</option>
				  	<option value="tokopedia">Tokopedia</option>				  	
				  </select>
				</div>
				<div class="form-group">
				  <label for="">Status Transaksi</label>
				  <select class="form-control" id="status_transcation">
				  	<option value="1">Beli Bahan</option>
				  	<option value="2">Proses Jarit</option>
				  	<option value="3">Proses Payet</option>
				  	<option value="4">Siap Kirim</option>
				  	<option value="5">Sudah Kirim</option>
				  					  	
				  </select>
				</div>

				<br>
				<div class="form-group">
					<input type="hidden" id="id_transaction">
				  <input type="button" id="save-transaction" value="Simpan Transaksi" class="mr-2 mb-2 btn btn-danger" onclick="save_transaction(event)">
				</div>
			</div>
	      </form>




	    </div>
	  </div>
	</div>
</div>