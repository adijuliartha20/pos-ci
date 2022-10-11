<div class="content-i">
    <div class="content-box">
      	<div class="element-wrapper">
	        <h6 class="element-header"><?php echo $title; ?></h6>
			<div class="element-box">
				<form id="form-add-item" class="form-inline">
			      	<input id="id" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="ID" type="text" onkeyup="get_item_data(0)">
			      	<input id="item" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Item" type="text" disabled="disabled">
			      	<input id="price" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Price" type="text" disabled="disabled">
			      	<input id="capital_price" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Capital Price" type="text" disabled="disabled">
			      	<input id="qty" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Qty" type="number" min="1">

			      	<input type="hidden" id="true_price">
			      	<input type="hidden" id="curr_edit" value="">
			      	<input type="hidden" id="is_edit" value="">
			      	<input type="hidden" id="max_tr" value="">
			      	<button class="mr-2 mb-2 btn btn-outline-primary btn-add" type="submit">Add</button>
			    </form>
				
				<br>
				<div class="table-responsive">
					<input type="hidden" id="min_length_id" name="min_length_id" value="<?php echo $min_length_id; ?>" />
					<table id="table-transaction" class="table table-editable table-striped table-lightfont">
						<thead>
							<tr>
								<th>No</th>
								<th>ID</th>
								<th>Item</th>
								<th>Price</th>
								<th>Capital Price</th>
								<th>Qty</th>
								<th>Subtotal</th>
								<th>Action</th>
							</tr>
						</thead>
						<tfoot>
			    			<tr>
								<th colspan="6">Total</th>
								<th id="total-text">---</th>
								<th><input type="button" name="save" value="Save" class="mr-2 mb-2 btn btn-danger" data-target="#onboardingFormModal" data-toggle="modal" onclick="save(event)"></th>
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



<!--<button class="mr-2 mb-2 btn btn-primary" data-target="#onboardingFormModal" data-toggle="modal" type="button">Modal with form</button>-->
<!--<div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingFormModal" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-centered" role="document">
	  <div class="modal-content text-center">
	    <button aria-label="Close" class="close" data-dismiss="modal" type="button" id="close-form-payment"><span class="close-label"></span><span class="os-icon os-icon-close"></span></button>
	    <div class="onboarding-media">
	      <img alt="" src="<?php echo base_url().'public/'?>img/bigicon5.png" width="100px">
	    </div>
	    <div class="onboarding-content with-gradient">
	      <h4 class="onboarding-title">
	        Payment
	      </h4>
	      
	      <form id="form-payment" class="form-payment">
	      	<div class="col-sm-12">
				<div class="form-group">
				  <label for="">Total</label>
				  <input class="form-control" placeholder="Total" type="text" value="" disabled="disabled" id="total_payment">
				</div>
				<div class="form-group">
				  <label for="">Payment</label>
				  <input class="form-control currency" placeholder="Enter your payment" type="text" value="" id="payment" onkeyup="calculate_change(event)">
				</div>
				<div class="form-group">
				  <label for="">Change</label>
				  <input class="form-control" placeholder="" type="text" value="" disabled="disabled" id="change">
				</div>
				<br>
				<div class="form-group">
				  <input type="button" value="Save Transaction" class="mr-2 mb-2 btn btn-danger" onclick="save_transaction(event)">
				</div>
			</div>
	      </form>
	    </div>
	  </div>
	</div>
</div>-->