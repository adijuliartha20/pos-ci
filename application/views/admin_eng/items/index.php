<div class="content-i">
    <div class="content-box">
      	<div class="element-wrapper">
	        <h6 class="element-header"><?php echo $title; ?> Data <input type="button" name="" value="Add New" class="btn btn-primary"  onclick="location.href = '<?php echo ADMIN_URL.'/'.$app.'/create'; ?>';"></h6>
			<div class="element-box">
				<div class="form-desc">
					<a href="<?php echo ADMIN_URL.'/'.$app; ?>">Publish</a> | <a href="<?php echo ADMIN_URL.'/'.$app.'/trash'; ?>">Trash</a>
				</div>
				<div class="table-responsive">
					<form id="table-action" method="POST">
						<table id="dataTable1" name="table-action" width="100%" class="table table-striped table-lightfont table-action">
				    		<thead>
				    				<tr>
				    					<th class="small-th">
				    						<input type="checkbox" id="ids_top" class="" onClick="select_all_row(event)">
				    					</th>
										<th><span>ID</span></th>
										<th>MID</th>
										<th>Item</th>
										<th>Category</th>
										<th>Qty</th>
										<th>Capital Price</th>
										<th>Price</th>
										<th>Discount</th>
										<th>Store</th>
				    				</tr>
				    		</thead>
				    		<tfoot>
				    				<tr>
				    					<th class="small-th">
				    						<input type="checkbox" id="ids_bottom" class="" onClick="select_all_row(event)">
				    					</th>
				    					<th><span>ID</span></th>
										<th>MID</th>
										<th>Item</th>
										<th>Category</th>
										<th>Qty</th>
										<th>Capital Price</th>
										<th>Price</th>
										<th>Discount</th>
										<th>Store</th>
				    				</tr>
				    		</tfoot>
				    		<tbody>
				    			<?php 
				    				foreach ($data as $key => $dt) {

				    					?>
				    				<tr id="tr-<?php echo $dt['id_item']; ?>">
				    					<td>
				    						<input type="checkbox" name="ids[]" value="<?php echo $dt['id_item']; ?>" >
				    					</td>
				    					<td>
				    						<p class="text-action">
				    							<label>
				    								<span><?php echo $dt['id_item'];?></span>	
				    							</label>		    							
				    						</p>
				    						<p class="small-action">
				    							<?php 
				    								if($state=='trash'){?>
				    									<a onclick="action_row(event,<?php echo $dt['id_item']; ?>,'publish')">Restore</a> | <a onclick="action_row(event,<?php echo $dt['id_item']; ?>,'delete')">Delete Permanently</a>
				    								<?php
				    								}else{?>
				    									<a href="<?php echo ADMIN_URL.'/'.$app.'/edit/'.$dt['id_item']; ?>">Edit</a> | <a onclick="action_row(event,<?php echo $dt['id_item']; ?> , 'trash')">Move Trash</a>
				    								<?php
				    								}
				    							?>
				    							 
				    						</p>
				    					</td>
				    					<td><?php echo $dt['mid']; ?></td>
				    					<td><?php echo $dt['item']; ?></td>
				    					<td><?php echo $dt['category']; ?></td>
				    					<td><?php echo $dt['qty']; ?></td>
				    					<td><?php echo number_format($dt['capital_price']); ?></td>
				    					<td><?php echo number_format($dt['price']); ?></td>
				    					<td>
				    						<?php 
				    							$type_discount = $dt['type_discount'];
				    							$discount = number_format($dt['discount']);
				    							$text_discount = ($type_discount=='percent'? $discount.'%': $discount);
				    							$plus_discount = number_format($dt['plus_discount']);
				    							if(!empty($plus_discount)){
				    								$plus_discount = ($type_discount=='percent'? $plus_discount.'%': $plus_discount);
				    								$text_discount = '('.$text_discount.'+'.$plus_discount.')';
				    							}
				    							echo $text_discount;
				    						?>
				    						
				    					</td>
				    					<td><?php echo $dt['store']; ?></td>
				    				</tr>
				    				<?php
				    				}
				    			?>
				    		</tbody>
				    	</table>
			    	</form>
				</div>
			</div><!-- END element-box -->	
		</div><!-- END element-wrapper -->	
	</div><!-- END content-box -->
</div><!-- END content i -->
<input type="hidden" id="active_url" value="<?php echo ADMIN_URL.'/'.$app; ?>">
<input type="hidden" id="state" value="<?php echo $state; ?>">