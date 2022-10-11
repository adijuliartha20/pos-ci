jQuery(document).ready(function(){
	set_first_table()
	//set_auto_number()
	jQuery('#id').focus();
})

function set_first_table(){
	var n = 5;
	for(var i=0; i<=n; i++){
		var tr = temp_tr(i);
		//console.log(tr);
		jQuery('#table-transaction tbody').append(tr)
	}
	jQuery('#max_tr').val(n)
}

function temp_tr(i){
	var temp = '<tr id="tr-'+i+'" class="empty-row">'+
					'<td>&nbsp;</td>'+
					'<td></td>'+
					'<td>&nbsp;</td>'+
					'<td>&nbsp;</td>'+
					
					'<td>&nbsp;</td>'+
					'<td>&nbsp;</td>'+
					'<td class="actions">'+

						'<input type="hidden" id="id-'+i+'" name="id[]" value="">'+
						'<input type="hidden" id="item-'+i+'" name="item[]">'+
						'<input type="hidden" id="price-'+i+'" name="price[]">'+
						//'<input type="hidden" id="capital_price-'+i+'" name="capital_price[]" value="">'+
						'<input type="hidden" id="qty-'+i+'" name="qty[]">'+
						'<input type="hidden" id="subtotal-'+i+'" name="subtotal[]">'+

						'<a id="edit_item-'+i+'" name="edit_item[]" onClick="edit_item('+i+')"><i class="os-icon os-icon-ui-49"></i></a>'+
						'<a id="delete_item-'+i+'" name="delete_item[]" class="danger" onClick="delete_item('+i+')"><i class="os-icon os-icon-ui-15"></i></a>'+
					'</td>'+
				'</tr>';
	return temp;
}




//////////////

function get_item_data(e,qty_edit){
	var min_length_id = jQuery('#min_length_id').val();
	var length_id =  jQuery('#id').val().length;

	if(length_id>=min_length_id){//get data
		var id = jQuery('#id').val()
		var dt = new Object();
			dt.id = id
			dt.reseller_mode = jQuery('#reseller_mode').val()

		//console.log(dt)	
		var url = jQuery('#active_url').val()+'/get-item';
		jQuery.post(url,dt,function(response){
			var res = jQuery.parseJSON(response);
			if(res.status=='success'){
				jQuery('#item').val(res.item);
				jQuery('#price').val(res.text_price);
				//jQuery('#capital_price').val(res.capital_price);
				jQuery('#true_price').val(res.true_price);
				jQuery('#qty').focus();
			}else{
				//alert(res.msg)
			}
		})
	}else{
		jQuery('#item').val('');
		jQuery('#price').val('');
		jQuery('#capital_price').val('');
		//jQuery('#discount').val('');
		jQuery('#qty').attr('max','');
		jQuery('#id').focus();
	}
}


jQuery('#form-add-item').submit(function(){
	var qty = jQuery('#qty').val();
	var item = jQuery('#item').val();

	if(qty>0){
		//edit mode
		var is_edit = jQuery('#is_edit').val()
		//console.log(is_edit)
		if(is_edit=='yes'){
			var i = jQuery('#curr_edit').val();
			set_value_tr(i)
		}else{
			//check available tr
			var av = '';
			var tbody =  jQuery('#table-transaction tbody');
			rows = tbody.find('tr');
			text = 'textContent' in document ? 'textContent' : 'innerText';

			for (var i = 0, len = rows.length; i < len; i++){
				if(rows[i].children[1][text]=='') {
					av = i;
					break;	
				}	
			}

			
			if(av=='' && av!='0'){//new tr
				av = jQuery('#max_tr').val()
				av = Number(av.replace(/[^0-9\.-]+/g,"")) + 1; 
				//console.log(av+1)
				var tr = temp_tr(av);
				jQuery('#table-transaction tbody').append(tr)
				jQuery('#max_tr').val(av)
			}
			
			if(av!='' || av=='0'){
				var i = av;
				console.log('add to '+i)
				set_value_tr(i)
			}
		}
	}
	
	
	
	return false;
})


function set_value_tr(i){
	var tbody =  jQuery('#table-transaction tbody');
	rows = tbody.find('tr');

	var id = jQuery('#id').val();
	var item = jQuery('#item').val();
	var price = jQuery('#price').val();
	//var capital_price = jQuery('#capital_price').val();
	var true_price = jQuery('#true_price').val();
	var qty = jQuery('#qty').val();
	
	rows[i].children[1][text] 	= id;
	rows[i].children[2][text] 	= item;
	rows[i].children[3][text] 	= price;
	//rows[i].children[4][text] 	= capital_price;
	rows[i].children[4][text] 	= qty;
	var subtotal = jQuery('#true_price').val() * jQuery('#qty').val()
	rows[i].children[5][text] 	= subtotal.format(0);

	jQuery('#id-'+i).val(id) 
	jQuery('#item-'+i).val(item) 
	jQuery('#price-'+i).val(price);
	//jQuery('#capital_price-'+i).val(capital_price);
	jQuery('#true_price-'+i).val(true_price);
	jQuery('#qty-'+i).val(qty);
	jQuery('#subtotal-'+i).val(subtotal)
	//jQuery('#max-'+i).val(max)

	jQuery('#form-add-item').trigger("reset");
	jQuery('#qty').attr('max','');
	jQuery('#true_price').val('')
	jQuery('#curr_edit').val('')
	jQuery('#is_edit').val('no')
	//console.log(i);
	jQuery('#tr-'+i).removeClass('empty-row')
	set_auto_number()
	set_total()
}

function set_total(){
	var total = 0;
	jQuery('input[name^="subtotal"]').each(function() {
		var subtotal = jQuery(this).val(); 
		subtotal = Number(subtotal.replace(/[^0-9\.-]+/g,"")); 
		if(subtotal!=''){
			total = total + subtotal
		} 
		
	});

	if(total!=0){
		total = total.format(0)
	}else{
		total = '---'
	}

	jQuery('#total-text').text(total);
}

function set_auto_number(){
	jQuery('#id').focus();
	var tbody =  jQuery('#table-transaction tbody');
	rows = tbody.find('tr');
	text = 'textContent' in document ? 'textContent' : 'innerText';

	for (var i = 0, len = rows.length; i < len; i++){
		//console.log(rows[i].children[1][text])//[text]+'33')
		if(rows[i].children[1][text]!='') rows[i].children[0][text] = i + 1 ;//+ ': ' + rows[i].children[0][text];
	}

}


Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

function reset_table(e){
	jQuery('#form-add-item').trigger("reset");
	jQuery('#table-transaction tbody').html('');
	set_first_table()
	jQuery('#total-text').text('---');
}





function edit_item(i){
	console.log(i)
	var id = jQuery('#id-'+i).val() 
	var qty = jQuery('#qty-'+i).val();

	jQuery('#id').val(id);
	jQuery('#curr_edit').val(i)
	jQuery('#is_edit').val('yes')
	get_item_data(qty)
}


function delete_item(i){
	jQuery('#tr-'+i).fadeOut()
	setTimeout(function(){
		jQuery('#tr-'+i).remove()
		set_auto_number()
		set_total()	
		reset_index_table()
	},300)
} 


function reset_index_table(){
	var av = '';
	var tbody =  jQuery('#table-transaction tbody');
	rows = tbody.find('tr');
	text = 'textContent' in document ? 'textContent' : 'innerText';

	for (var i = 0, len = rows.length; i < len; i++){
		//jQuery('tr')
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="id"]').attr('id','id-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="item"]').attr('id','item-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="price"]').attr('id','price-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="capital_price"]').attr('id','capital_price-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="qty"]').attr('id','qty-'+i);

		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="subtotal"]').attr('id','subtotal-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('a[name^="edit_item"]').attr('id','edit_item-'+i).attr('data-index',i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('a[name^="delete_item"]').attr('id','delete_item-'+i).attr('data-index',i);


		jQuery('#table-transaction tbody tr:eq('+i+')').find('a[name^="edit_item"]').attr('onclick','');
		jQuery('#table-transaction tbody tr:eq('+i+')').find('a[name^="delete_item"]').attr('onclick','');

		//console.log('edit_item-'+i)

		jQuery('#edit_item-'+i).click(function() {
			idx = jQuery(this).attr('data-index');
			edit_item(idx)
		})

		jQuery('#delete_item-'+i).click(function() {
			idx = jQuery(this).attr('data-index');
			delete_item(idx)
		})
		jQuery('#table-transaction tbody tr:eq('+i+')').attr('id','tr-'+i);
	}
}


var state = 0;
function save(event){
	var total_text = jQuery('#total-text').text()
	
	if(total_text!='---' && total_text!=''&& state==0){
		jQuery(event.target).val('Mohon Menunggu...')
		state = 1;
		var items = jQuery("input[name='id[]']").map(function(){if(jQuery(this).val()!='') return jQuery(this).val();}).get();
		var qty =  jQuery("input[name='qty[]']").map(function(){if(jQuery(this).val()!='') return jQuery(this).val();}).get();

		var dt = new Object();
		dt.items = items;
		dt.qty   = qty;

		var url = jQuery('#active_url').val()+'/save';
		jQuery.post(url,dt,function(response){
			var res = jQuery.parseJSON(response);
			var class_alert = 'alert alert-danger';
			if(res.status=='success'){
				class_alert = 'alert alert-success';
				reset_table(event)			
			}
			state=0;


			jQuery("html, body").animate({ scrollTop: 0 }, "slow");
            jQuery('#mid').focus()
        	setTimeout(function(){
            	jQuery('#alert-form').slideUp(600)	
                state=0;
            },6000)
            
			jQuery('#alert').attr('class',class_alert);
            jQuery('#middle-alert').html(res.msg);
            jQuery('#alert-form').slideDown(600);
			jQuery(event.target).val('Simpan')			
            //jQuery('#btn-save').text('Simpan')
		});	
	}
	return false;
}
