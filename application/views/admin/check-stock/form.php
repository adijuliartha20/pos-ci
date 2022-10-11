<div class="content-i">
    <div class="content-box">
      	<div class="element-wrapper">
	        <h6 class="element-header">Cek Stok Barang</h6>
	        
				<div id="alert-form" class="alert-form clearfix">
		        	<div id="alert" class="alert alert-success" role="alert">
		        		<div id="middle-alert" class="middle-alert"></div>
				    </div>	
		        </div>
	        
			<div class="element-box">
				<form id="form-add-item" class="form-inline">
			      	<input id="id" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="MID" type="text" onkeyup="get_item_data(0)">
			      	<input id="item" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Barang" type="text" disabled="disabled">
			      	<input id="price" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Harga" type="text" disabled="disabled">
			      	<!--<input id="capital_price" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Harga Pokok" type="text" disabled="disabled">-->
			      	<input id="qty" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Jumlah" type="number" min="1">

			      	<input type="hidden" id="true_price">
			      	<input type="hidden" id="curr_edit" value="">
			      	<input type="hidden" id="is_edit" value="">
			      	<input type="hidden" id="max_tr" value="">
			      	<button class="mr-2 mb-2 btn btn-outline-primary btn-add" type="submit">Tambah</button>
			    </form>
				
				<br>
				<div class="table-responsive">
					<input type="hidden" id="min_length_id" name="min_length_id" value="<?php echo $min_length_id; ?>" />
					<table id="table-transaction" class="table table-editable table-striped table-lightfont">
						<thead>
							<tr>
								<th>No</th>
								<th>MID</th>
								<th>Barang</th>
								<th>Harga</th>
								<th>Jumlah</th>
								<th>Sub Total</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tfoot>
			    			<tr>
								<th colspan="5">Total</th>
								<th id="total-text">---</th>
								<th><input type="button" name="save" value="Simpan" class="mr-2 mb-2 btn btn-danger" data-target="#onboardingFormModal" data-toggle="modal" onclick="save(event)"></th>
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