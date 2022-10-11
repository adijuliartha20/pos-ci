var set = 0;
jQuery(document).ready(function(){
	//set_action_table()	

	//jQuery('#dataTable1_length').find('label')

	jQuery('#dataTable2').DataTable({
		"oLanguage": {
					"sSearch": "Cari:",
					"sInfo": "Tampilkan _START_ sampai _END_ dari _TOTAL_ data",
					"sLengthMenu": "Tampilkan _MENU_ data",
					"sPrevious": "Sebelumnya",
					"sNext": "Berikutnya"
					
		},
		
		"drawCallback": function( settings ) {
			if(set==0){
				set_action_table()		
			}
			
        	//alert( 'DataTables has redrawn the table' );
    	}
	});
})


function set_action_table(){
	var opt = 	"<option value=\"edit\">Edit</option>"
				+"<option value=\"trash\">Pindah ke Sampah</option>"

	if(jQuery('#state').val()=='trash'){
		opt = 	"<option value=\"untrash\">Restore</option>"
				+"<option value=\"delete\">Delete Permanent</option>"		
	}

	var append = "<div class=\"bulk-action fleft\">"
					+"<select class=\"form-control form-control-sm\" name=\"action-table\"> "
					+"<option value=\"\">Bulk Action</option> "
					+opt
					+"</select>"	
					+"<button class=\"btn\">Terapkan</button>"	
				 +"</div>";
	jQuery('#dataTable2_length').append(append)
	jQuery('#dataTable2_previous a').text('Sebelumnya')
	jQuery('#dataTable2_next a').text('Selanjutnya')
	set=1;
}



function select_all_row(event){
	var action = '';
	if(jQuery(event.target).is(':checked')) action = 'checked';

	jQuery('[name=table-action] tr td:first-child input[type=checkbox]').each(function(){
		jQuery(this).prop('checked', action);
	})

	jQuery('#ids_top').prop('checked', action);
	jQuery('#ids_bottom').prop('checked', action);
}

function change_form_action(e){
	var action = jQuery(e.target).val()
	var url = jQuery('#active_url').val()+'/'+action;
	jQuery('#table-action').attr('action', url);
}