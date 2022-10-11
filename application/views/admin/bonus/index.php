<div class="content-i">
    <div class="content-box">
      	<div class="element-wrapper">
	        <h6 class="element-header">Data <?php echo $title; ?> <input type="button" name="" value="Tambah" class="btn btn-primary"  onclick="location.href = '<?php echo ADMIN_URL.'/'.$app.'/create'; ?>';"></h6>
			<div class="element-box">
				<div class="form-desc">
					<a href="<?php echo ADMIN_URL.'/'.$app; ?>">Publis</a> | <a href="<?php echo ADMIN_URL.'/'.$app.'/trash'; ?>">Sampah</a>
				</div>
				<div class="table-responsive">
					<form id="table-action" method="POST">
						<table id="dataTable2" name="table-action" width="100%" class="table table-striped table-lightfont table-action">
				    		<thead>
				    				<tr>
				    					<th class="small-th">
				    						<input type="checkbox" id="ids_top" class="" onClick="select_all_row(event)">
				    					</th>
										<th><span>Range</span></th>
										<th><span>Bonus</span></th>
										<th><span>Toko</span></th>
				    				</tr>
				    		</thead>
				    		<tfoot>
				    				<tr>
				    					<th class="small-th">
				    						<input type="checkbox" id="ids_bottom" class="" onClick="select_all_row(event)">
				    					</th>
				    					<th><span>Range</span></th>
										<th><span>Toko</span></th>
				    				</tr>
				    		</tfoot>
				    		<tbody>
				    			<?php 
				    				foreach ($data as $key => $dt) {

				    					?>
				    				<tr id="tr-<?php echo $dt['id_bonus']; ?>">
				    					<td>
				    						<input type="checkbox" name="ids[]" value="<?php echo $dt['id_bonus']; ?>" >
				    					</td>
				    					<td>
				    						<p class="text-action">
				    							<label>
				    								<span><?php echo number_format($dt['start']).' - '.number_format($dt['end']);?></span>	
				    							</label>		    							
				    						</p>
				    						<p class="small-action">
				    							<?php 
				    								if($state=='trash'){?>
				    									<a onclick="action_row(event,<?php echo $dt['id_bonus']; ?>,'publish')">Restore</a> | <a onclick="action_row(event,<?php echo $dt['id_bonus']; ?>,'delete')">Delete Permanen</a>
				    								<?php
				    								}else{?>
				    									<a href="<?php echo ADMIN_URL.'/'.$app.'/edit/'.$dt['id_bonus']; ?>">Edit</a> | <a onclick="action_row(event,<?php echo $dt['id_bonus']; ?> , 'trash')">Pindah ke Sampah</a>
				    								<?php
				    								}
				    							?>
				    							 
				    						</p>
				    					</td>
				    					<td><?php echo number_format($dt['bonus']); ?></td>
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