jQuery(document).ready(function(){
	set_first_table()
	set_auto_number()
	setTimeout(function(){
		jQuery('#id').focus();	
	},600)
	
})

function set_first_table(){
	var n = 6;
	for(var i=0; i<=n; i++){
		var tr = temp_tr(i);
		//console.log(tr);
		jQuery('#table-transaction tbody').append(tr)
	}
	jQuery('#max_tr').val(n)
}

function focus_qty(e){
  //event.preventDefault();
  
  if (event.keyCode === 13) {
    jQuery('#qty').focus()
  }
  if (event.keyCode == 35) {
    alert('end key press');
	}
}

function focus_st(event){
	if (event.keyCode === 13) {
    	jQuery('#save-transaction').focus()
  	}
}

function keyPressEvent(e) {
    
}


function search_customer(){
	var search_by = jQuery('#search_by').val()
	var search = jQuery('#search').val()

	//console.log(search)	;
	if(search!='' && typeof search !== 'undefined'){
		jQuery('#tbody-customer').empty();

		var loading = '<tr><td colspan="4">Loading...</td></tr>'
		jQuery('#tbody-customer').append(loading);


		var dt = new Object();
			dt.search_by = search_by;
			dt.search = search;

		var url = jQuery('#active_url').val()+'/search-customer';
        jQuery.post(url,dt,function(response){
        	var res = jQuery.parseJSON(response)
        	if(res.status=='success'){
        		var cust = res.data;
        		//console.log(cust.length);
        		if(cust.length>0){        			
        			var tr = '';
        			jQuery.each(cust,function(key, v){
        				var address = v.address+' - '+v.name_sub_district+', '+v.name_district+', '+v.name_province;
        				var id_customer = v.id_customer;
        				//var date = new Date(v.date_of_birth);
        				//var dob = dateFormat(date, 'dd F Y');
        				var dob = v.date_of_birth;

        				tr += '<tr>'+
        							'<td>'+v.name+'</td>'+
        							'<td>'+v.handphone+'</td>'+
        							'<td>'+address+'</td>'+
        							'<td>'+
        								'<a href="#" onclick="set_customer('+id_customer+')">Pilih</a>'+
        								'<input type="hidden" id="name_'+id_customer+'" value="'+v.name+'" />'+
        								'<input type="hidden" id="handphone_'+id_customer+'" value="'+v.handphone+'" />'+
        								'<input type="hidden" id="date_of_birth_'+id_customer+'" value="'+dob+'" />'+
        								'<input type="hidden" id="gender_'+id_customer+'" value="'+(v.gender=='1'? 'Laki-laki':'Perempuan')+'" />'+
        								'<input type="hidden" id="address_'+id_customer+'" value="'+v.address+'" />'+
        							'</td>'+
        						  '</tr>';
        			})
        			jQuery('#tbody-customer').empty();
        			jQuery('#tbody-customer').append(tr);
        		}else{
        			jQuery('#tbody-customer').empty();

					var loading = '<tr><td colspan="4">Konsumen tidak ditemukan</td></tr>'
					jQuery('#tbody-customer').append(loading);
        		}

        		

        		console.log(cust)
        	}
            return false;
        })	
	}
}

function set_customer(id){
	var id_customer = id;
	var name 			= jQuery('#name_'+id).val();
	var handphone 		= jQuery('#handphone_'+id).val();
	var date_of_birth 	= jQuery('#date_of_birth_'+id).val();
	var gender 			= jQuery('#gender_'+id).val();
	var address 		= jQuery('#address_'+id).val();


	console.log(name)
	console.log(handphone)
	console.log(date_of_birth)
	console.log(gender)
	console.log(address)

	jQuery('#id_customer').val(id);
	jQuery('#name').text(name);
	jQuery('#handphone').text(handphone);
	jQuery('#date_of_birth').text(date_of_birth);
	jQuery('#gender').text(gender);
	jQuery('#address').text(address);

	jQuery('#close-modal').click()

}

/*function temp_tr(i){
	var temp = '<tr id="tr-'+i+'" class="empty-row">'+
					'<td>&nbsp;</td>'+
					'<td></td>'+
					'<td>&nbsp;</td>'+
					'<td>&nbsp;</td>'+
					'<td>&nbsp;</td>'+
					'<td>&nbsp;</td>'+
					'<td>&nbsp;</td>'+
					'<td class="actions">'+

						'<input type="hidden" id="id-'+i+'" name="id[]" value="">'+
						'<input type="hidden" id="item-'+i+'" name="item[]">'+
						'<input type="hidden" id="price-'+i+'" name="price[]">'+
						'<input type="hidden" id="discount-'+i+'" name="discount[]" value="">'+
						'<input type="hidden" id="true_price-'+i+'" name="true_price[]">'+
						'<input type="hidden" id="qty-'+i+'" name="qty[]">'+
						'<input type="hidden" id="subtotal-'+i+'" name="subtotal[]">'+
						'<input type="hidden" id="max-'+i+'" name="max[]">'+

						'<a onClick="edit_item(event,'+i+')"><i class="os-icon os-icon-ui-49"></i></a>'+
						'<a class="danger" onClick="delete_item(event,'+i+')"><i class="os-icon os-icon-ui-15"></i></a>'+
					'</td>'+
				'</tr>';
	return temp;
}*/

function temp_tr(i){
	var temp = '<tr id="tr-'+i+'" class="empty-row">'+
					'<td>&nbsp;</td>'+
					'<td></td>'+
					'<td>&nbsp;</td>'+
					'<td>&nbsp;</td>'+
					'<td>&nbsp;</td>'+
					'<td>&nbsp;</td>'+
					'<td>&nbsp;</td>'+
					'<td class="actions">'+
						'<input type="hidden" id="id-'+i+'" name="id[]">'+
						'<input type="hidden" id="item-'+i+'" name="item[]">'+
						'<input type="hidden" id="price-'+i+'" name="price[]">'+
						'<input type="hidden" id="discount-'+i+'" name="discount[]">'+
						'<input type="hidden" id="true_price-'+i+'" name="true_price[]">'+
						'<input type="hidden" id="qty-'+i+'" name="qty[]">'+
						'<input type="hidden" id="subtotal-'+i+'" name="subtotal[]">'+
						'<input type="hidden" id="max-'+i+'" name="max[]">'+
						'<input type="hidden" id="id_store-'+i+'" name="id_store[]">'+

						'<a id="edit_item-'+i+'" name="edit_item[]" onClick="edit_item('+i+')"><i class="os-icon os-icon-ui-49"></i></a>'+
						'<a id="delete_item-'+i+'" name="delete_item[]" class="danger" onClick="delete_item('+i+')"><i class="os-icon os-icon-ui-15"></i></a>'+
					'</td>'+
				'</tr>';
	return temp;
}


function edit_item(i){
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
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="id"]').attr('id','id-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="item"]').attr('id','item-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="price"]').attr('id','price-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="discount"]').attr('id','discount-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="true_price"]').attr('id','true_price-'+i);

		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="qty"]').attr('id','qty-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="max"]').attr('id','max-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="subtotal"]').attr('id','subtotal-'+i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('input[name^="id_store"]').attr('id','id_store-'+i);


		jQuery('#table-transaction tbody tr:eq('+i+')').find('a[name^="edit_item"]').attr('id','edit_item-'+i).attr('data-index',i);
		jQuery('#table-transaction tbody tr:eq('+i+')').find('a[name^="delete_item"]').attr('id','delete_item-'+i).attr('data-index',i);


		jQuery('#table-transaction tbody tr:eq('+i+')').find('a[name^="edit_item"]').attr('onclick','');
		jQuery('#table-transaction tbody tr:eq('+i+')').find('a[name^="delete_item"]').attr('onclick','');

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


function get_item_data(qty_edit){
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
				//find true qty this item now 
				var curr_qty = get_true_qty(id) - qty_edit;
				var max = res.max;
				max = Number(max.replace(/[^0-9\.-]+/g,"")); 
				//console.log(max+' > '+curr_qty+'### id='+id)

				if(max > curr_qty){
					max = max - curr_qty;
					jQuery('#item').val(res.item);
					jQuery('#price').val(res.text_price);
					jQuery('#true_price').val(res.true_price);
					jQuery('#discount').val(res.text_discount);
					jQuery('#id_store').val(res.id_store);
					jQuery('#qty').attr('max',max);
					if(jQuery('#discount').is(':disabled')){
					    jQuery('#qty').focus();
					}else{
						jQuery('#discount').focus();
					}
					
				}else{
					alert('Item is empty now')
				}
			}else{
				//alert(res.msg)
			}
		})
	}else{
		jQuery('#item').val('');
		jQuery('#price').val('');
		jQuery('#true_price').val('');
		jQuery('#discount').val('');
		jQuery('#qty').attr('max','');
		jQuery('#id').focus();
	}
}

function get_true_qty(id){
	var qty = 0
	jQuery('input[name^="id"]').each(function(i) {
		var curr_id = jQuery(this).val(); 
		if(typeof curr_id != 'undefined' && curr_id==id){
			var curr_qty = jQuery('#qty-'+i).val()
			if(typeof curr_qty != 'undefined'){
				curr_qty = Number(curr_qty.replace(/[^0-9\.-]+/g,"")); 
				if(curr_qty!=''){
					qty = qty + curr_qty	
				} 		
			}
		}
	});
	return qty;
}


jQuery('#form-add-item').submit(function(){
	var qty = jQuery('#qty').val();
	var item = jQuery('#item').val();
	if(qty>0 && item!=''){
		//edit mode
		var is_edit = jQuery('#is_edit').val()
		//console.log(is_edit)
		if(is_edit=='yes'){
			var i = jQuery('#curr_edit').val();
			//console.log(i)
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
	var discount = jQuery('#discount').val();
	var true_price = jQuery('#true_price').val();
	var qty = jQuery('#qty').val();
	var id_store = jQuery('#id_store').val();
	var max = jQuery('#qty').attr('max');
	

	rows[i].children[1][text] 	= id;
	rows[i].children[2][text] 	= item;
	rows[i].children[3][text] 	= price;
	rows[i].children[4][text] 	= discount;
	rows[i].children[5][text] 	= qty;

	var dpi = jQuery('#discount_per_item').val()
	var subtotal = true_price * qty	
	if(dpi=='enable'){
		val_disc  = Number(discount.replace(/[^0-9\.-]+/g,"")); 
		subtotal = (true_price - val_disc) * jQuery('#qty').val()	
	}

	
	rows[i].children[6][text] 	= subtotal.format(0);

	jQuery('#tr-'+i).removeClass('empty-row')

	jQuery('#id-'+i).val(id) 
	jQuery('#item-'+i).val(item) 
	jQuery('#price-'+i).val(price);
	jQuery('#discount-'+i).val((discount=='' || discount=='0'? '-':discount));
	jQuery('#true_price-'+i).val(true_price);
	jQuery('#qty-'+i).val(qty);

	jQuery('#subtotal-'+i).val(subtotal)
	jQuery('#max-'+i).val(max)
	jQuery('#id_store-'+i).val(id_store)

	jQuery('#form-add-item').trigger("reset");
	jQuery('#qty').attr('max','');
	jQuery('#true_price').val('')
	jQuery('#curr_edit').val('')
	jQuery('#is_edit').val('no')
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
			//console.log(subtotal);
		} 
		
	});

	if(total!=0){
		total = total.format(0)
	}else{
		total = '---'
	}

	jQuery('#total-text').text(total);
	//console.log(total);
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





function set_value_form_payment(event){//alert('woii')
	var name_konsumen = jQuery('#name_consumen').val()
	
	//$('#form-data-consumen').validator()
	
	if(name_konsumen==''){
		jQuery('#form-val-btn').click()
		console.log('valid dulu')

		return;
	}else{

		jQuery('#show-popup').click();

		var total = 0;
		jQuery('input[name^="subtotal"]').each(function() {
			var subtotal = jQuery(this).val(); 
			subtotal = Number(subtotal.replace(/[^0-9\.-]+/g,"")); 
			if(subtotal!=''){
				total = total + subtotal	
				//console.log(subtotal);
			} 
			
		});

		if(total!=0){
			total = total.format(0)
		}else{
			total = '---'
		}
		jQuery('#total_payment_show').val(total);
		jQuery('#total_payment').val(total);
		//jQuery('#payment').focus()

		//validate show manual code
		var show_manual_discount = true;

		var old_store = '';
		var diffrent_store = 0;
		jQuery('input[name^="id_store"]').each(function() {
			id_store = jQuery(this).val()
			if(id_store!=''){
				if(old_store!='' && old_store!=id_store){
					//console.log('beda store');
					show_manual_discount = false;	
				} 
				if(old_store=='') old_store = id_store
			}

		})

		var discount = 0;
		jQuery('input[name^="discount"]').each(function() {
			var subdisc = jQuery(this).val(); 
			subdisc = Number(subdisc.replace(/[^0-9\.-]+/g,"")); 
			if(subdisc!=''){
				discount = discount + subdisc
			}
		})
		
		if(discount>0) {
			//console.log('ada discount');
			show_manual_discount = false;	
		} 
		jQuery('#manual_discount').val('')
		if(show_manual_discount){
			jQuery('#manual-discount-field').fadeIn()
			jQuery('#manual_discount').focus()
		}else{
			jQuery('#manual-discount-field').fadeOut()
			jQuery('#payment').focus()
		}
	}




	



	
}


function calculate_discount(event){
	// When user select text in the document, also abort.
    var selection = window.getSelection().toString();
    if ( selection !== '' ) {
        return;
    }
    
    // When the arrow keys are pressed, abort.
    if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
        return;
    }
    
    
    var $this = $(event.target);
    
    // Get the value.
    var input = $this.val();
    
    var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt( input, 10 ) : 0;

        $this.val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
        } );


    var total = jQuery('#total_payment').val();
    var manual_discount = jQuery('#manual_discount').val();

    total 			= Number(total.replace(/[^0-9\.-]+/g,""));    
    manual_discount = Number(manual_discount.replace(/[^0-9\.-]+/g,""));


    var total_payment_show = total - manual_discount;
	total_payment_show = total_payment_show.format(0)
	jQuery('#total_payment_show').val(total_payment_show);
}


function calculate_change(event){
	// When user select text in the document, also abort.
    var selection = window.getSelection().toString();
    if ( selection !== '' ) {
        return;
    }
    
    // When the arrow keys are pressed, abort.
    if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
        return;
    }
    
    
    var $this = $(event.target);
    
    // Get the value.
    var input = $this.val();
    
    var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt( input, 10 ) : 0;

        $this.val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
        } );

    var manual_discount = jQuery('#manual_discount').val();    
	var total = jQuery('#total_payment').val();
	var payment = jQuery('#payment').val()
	

    
    manual_discount = Number(manual_discount.replace(/[^0-9\.-]+/g,""));
	total = Number(total.replace(/[^0-9\.-]+/g,""));
	payment = Number(payment.replace(/[^0-9\.-]+/g,""));

	var change = payment - (total - manual_discount);
	change = change.format(0)
	jQuery('#change').val(change);

}

var state = 0;
function save_transaction(event){
	var manual_discount = jQuery('#manual_discount').val();
	var total = jQuery('#total_payment').val();
	var payment = jQuery('#payment').val()

	manual_discount = Number(manual_discount.replace(/[^0-9\.-]+/g,""));
	total = Number(total.replace(/[^0-9\.-]+/g,""));
	total = total - manual_discount;


	payment = Number(payment.replace(/[^0-9\.-]+/g,""));

	if(state==0){
	//if(payment >= total && state==0){
		state = 1;
		jQuery('#save-transaction').val('Mohon Menunggu...');
		var items = jQuery("input[name='id[]']").map(function(){if(jQuery(this).val()!='') return jQuery(this).val();}).get();
		var discounts =  jQuery("input[name='discount[]']").map(
									function(){
												var value = jQuery(this).val();
												value = (value=='-'? '0' : value)
												if(jQuery(this).val()!='') {
													value = Number(value.replace(/[^0-9\.-]+/g,"")); 
													return value;		
												}
											
											
									}).get();
		var qty =  jQuery("input[name='qty[]']").map(function(){if(jQuery(this).val()!='') return jQuery(this).val();}).get();

		var dt = new Object();
		dt.items = items;
		dt.discounts = discounts;
		dt.qty   = qty;
		dt.manual_discount = manual_discount;
		dt.payment = jQuery('#payment').val()
		dt.payment_type = jQuery('#payment_type').val()
		dt.status_transcation = jQuery('#status_transcation').val()
		dt.reseller_mode = jQuery('#reseller_mode').val()
		dt.id_customer = jQuery('#id_customer').val()		


		//for testing
		jQuery('#save-transaction').val('Simpan Transaksi');
		state=0;

		var url = jQuery('#active_url').val()+'/save';
		jQuery.post(url,dt,function(response){
			
			
			var res = jQuery.parseJSON(response);
			if(res.status=='success'){
				jQuery('#save-transaction').val('Simpan Transaksi');
				state=0;
				reset_table(event)
				jQuery('#close-form-payment').click()
				jQuery('#num-transaction').text(res.num_transaction)

				jQuery('#total_payment').val('')
				jQuery('#payment').val('')
				jQuery('#change').val('')

				dt.name_consumen	= jQuery('#name_consumen').val('')
				dt.phone 			= jQuery('#phone').val('')
				dt.sub_district 	= jQuery('#sub_district').val('')
				dt.district 		= jQuery('#district').val('')
				dt.province 		= jQuery('#province').val('')
				dt.address 			= jQuery('#address').val('')

				jQuery('#id_customer').val('-');
				jQuery('#name').text('-');
				jQuery('#handphone').text('-');
				jQuery('#date_of_birth').text('-');
				jQuery('#gender').text('-');
				jQuery('#address').text('-');
				
			}
		});	

	}

	return false;
}


function validate_data(){
	var items = jQuery("input[name='id[]']").map(function(){if(jQuery(this).val()!='') return jQuery(this).val();}).get();
	var discounts =  jQuery("input[name='discount[]']").map(
								function(){
											var value = jQuery(this).val();
											value = (value=='-'? '0' : value)
											if(jQuery(this).val()!='') {
												value = Number(value.replace(/[^0-9\.-]+/g,"")); 
												return value;		
											}
										
										
								}).get();
	var qty =  jQuery("input[name='qty[]']").map(function(){if(jQuery(this).val()!='') return jQuery(this).val();}).get();

	var dt = new Object();
	dt.items = items;
	dt.discounts = discounts;
	dt.qty   = qty;
	//console.log(dt)
}


function trim(str){
	return str.trim();
}
function currency_format(event){
	// When user select text in the document, also abort.
    var selection = window.getSelection().toString();
    if ( selection !== '' ) {
        return;
    }
    
    // When the arrow keys are pressed, abort.
    if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
        return;
    }
    
    
    var $this = $(event.target);
    
    // Get the value.
    var input = $this.val();
    
    var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt( input, 10 ) : 0;

        $this.val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
        } );
}



(function($, undefined) {
    "use strict";
    // When ready.
    $(function() {
        
        var $form = $( "#form-add-item" );
        var $input = $form.find( ".currency" );

        $input.on( "keyup", function( event ) {
            
            
            // When user select text in the document, also abort.
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }
            
            // When the arrow keys are pressed, abort.
            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            
            
            var $this = $( this );
            
            // Get the value.
            var input = $this.val();
            
            var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;

                $this.val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                } );
        } );
        
    });
})(jQuery);