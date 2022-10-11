<div class="content-i">
    <div class="content-box">
      	<div class="element-wrapper">
	        <h6 class="element-header"><?php echo $title; ?> Data <input type="button" name="" value="Add New" class="btn btn-primary"  onclick="location.href = '<?php echo ADMIN_URL.'/'.$app.'/create'; ?>';"></h6>
			<div class="element-box">
				<!--<h5 class="form-header">User Data</h5>-->
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
										<th>
											<span>Name</span>
										</th>
										<th>Position</th>
										<th>Usename</th>
										<th>Email</th>
										<th>Start Active</th>
										<!--<th>Status</th>-->
				    				</tr>
				    		</thead>
				    		<tfoot>
				    				<tr>
				    					<th class="small-th">
				    						<input type="checkbox" id="ids_bottom" class="" onClick="select_all_row(event)">
				    					</th>
				    					<th>		    						
											<span>Name</span>
				    					</th>
										<th>Position</th>
										<th>Usename</th>
										<th>Email</th>
										<th>Start Active</th>
										<!--<th>Status</th>-->
				    				</tr>
				    		</tfoot>
				    		<tbody>
				    			<?php 
				    				foreach ($data as $key => $dt) {

				    					?>
				    				<tr id="tr-<?php echo $dt['id_user']; ?>">
				    					<td>
				    						<input type="checkbox" name="ids[]" value="<?php echo $dt['id_user']; ?>" >
				    					</td>
				    					<td>
				    						<p class="text-action">
				    							<label>
				    								<span><?php echo $dt['first_name'].' '.$dt['last_name'];?></span>	
				    							</label>		    							
				    						</p>
				    						<p class="small-action">
				    							<?php 
				    								if($state=='trash'){?>
				    									<a onclick="action_row(event,<?php echo $dt['id_user']; ?>,'publish')">Restore</a> | <a onclick="action_row(event,<?php echo $dt['id_user']; ?>,'delete')">Delete Permanently</a>
				    								<?php
				    								}else{?>
				    									<a href="<?php echo ADMIN_URL.'/'.$app.'/edit/'.$dt['id_user']; ?>">Edit</a> | <a onclick="action_row(event,<?php echo $dt['id_user']; ?> , 'trash')">Move Trash</a>
				    								<?php
				    								}
				    							?>
				    							 
				    						</p>
				    					</td>
				    					<td><?php echo $dt['user_tipe']; ?></td>
				    					<td><?php echo $dt['username']; ?></td>
				    					<td><?php echo $dt['email']; ?></td>
				    					<td><?php echo $dt['start_active']; ?></td>
				    					<!--<td><?php echo $dt['status']; ?></td>-->
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