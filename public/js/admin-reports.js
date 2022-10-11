jQuery(document).ready(function(){

})

var state = 0;
jQuery('#form-report').submit(function(){
	var error = 0;

	var mode = jQuery('#mode').val()
	if(mode=='create'){
		
	}

	if(jQuery('#category').val()=='') error++;


	if(error==0 && state==0){
		//state=1;
		jQuery('#btn-show').text('Mohon Menunggu...')
		var form = jQuery(this);
	    var formdata = false;
	    if (window.FormData){
	        formdata = new FormData(form[0]);
	    }
	    jQuery('#reports').slideUp(1200)

	    var formAction = form.attr('action');
	    jQuery.ajax({
	        url         : jQuery(form).prop("action"),
	        data        : formdata ? formdata : form.serialize(),
	        cache       : false,
	        contentType : false,
	        processData : false,
	        type        : 'POST',
	        success     : function(data, textStatus, jqXHR){
	            var res = jQuery.parseJSON(data)
	            var temp = '';


	            if(res.status=='success'){
	            	temp = res.temp
	            }else{
	            	temp = '<div class="alert alert-danger">'+res.msg+'</div>';
	            }

	            setTimeout(function(){
            		jQuery('#reports').html(temp);
            		jQuery('#reports').slideDown(600)	
            		jQuery('#btn-show').text('Tampilkan')
            		state=0;
            	},1200)
	            return false;
	        }
	    });
	}
	return false;
})


function show_report(){
	alert('masuk woi');
}

function save_payment(event){
	jQuery('#save-transaction').text('Silahkan Menunggu...');

	var id_transaction_edit = jQuery('#id_transaction_edit').val()
	var payment = jQuery('#payment').val()
	payment = Number(payment.replace(/[^0-9\.-]+/g,""));
	var payment_type = jQuery('#payment_type').val()

	var url  = jQuery('#active_url').val()+'/save-payment';
	var dt = new Object();
		dt.id = id_transaction_edit;
		dt.payment = payment;
		dt.payment_type = payment_type;

	jQuery.post(url, dt, function(response){
		jQuery('#save-transaction').text('Simpan Transaksi');
		var res = jQuery.parseJSON(response)
		if(res.status=='success'){
			if(res.status_payment=='done'){
				jQuery('#reports-'+id_transaction_edit).slideUp();
				jQuery('#reports-'+id_transaction_edit).remove();
			}else if(res.status_payment=='not-done'){
				jQuery('#list-payment-'+id_transaction_edit+' li').remove()
				var temp = temp_li(res.list_payment);			
				jQuery('#list-payment-'+id_transaction_edit).append(temp)
				jQuery('#payment-'+id_transaction_edit).attr('data-remaining_payment',res.remaining_payment);
			}
			jQuery('#close-form-payment').click()
		}
		else alert(res.msg)
	})

}


function change_status(event){
	jQuery('#save-transaction').text('Silahkan Menunggu...');

	var id_transaction_edit = jQuery('#id_transaction_edit').val()
	var status = jQuery('#status').val()

	var url  = jQuery('#active_url').val()+'/change-status-package';
	var dt = new Object();
		dt.id = id_transaction_edit;
		dt.status = status;

	jQuery.post(url, dt, function(response){
		jQuery('#save-transaction').text('Simpan');
		var res = jQuery.parseJSON(response)
		if(res.status=='success'){
			//set data
			var ul = document.getElementById('list-status-'+id_transaction_edit)
			ul.innerHTML = '';
			const list_status = res.list;
			list_status.forEach(temp_li_status);
			jQuery('#close-form-payment').click()
		}
		else alert(res.msg)
	})
}

function temp_li_status(dt){
	const status = {1: 'Beli Bahan', 2 : 'Proses Jarit', 3 : 'Proses Payet', 4 : 'Siap Kirim', 5 : 'Sudah Kirim'};

	var li = document.createElement('li');
	var span_date = document.createElement('span');
	var span_status = document.createElement('span');
	var span_name = document.createElement('span');

	span_date.appendChild(document.createTextNode(dt.date));
	span_status.appendChild(document.createTextNode(' - '+status[dt.status]));
	span_name.appendChild(document.createTextNode(' => '+dt.first_name+' '+dt.last_name));


	li.appendChild(span_date);
	li.appendChild(span_status)
	li.appendChild(span_name);

	var id = document.getElementById('id_transaction_edit').value;
	var ul = document.getElementById('list-status-'+id);
	ul.appendChild(li);
}



function temp_li(dt){
	var li = '';
	var payment = 0;
	jQuery.each(dt,function(k,v){
		payment = Number(v.payment);
		li = li+'<li>'+v.date+' - '+payment.format()+'</li>';
	})


	return li;
	//var m = new Date();
	//var dateString = m.getUTCFullYear() +"/"+ (m.getUTCMonth()+1) +"/"+ m.getUTCDate() + " " + m.getUTCHours() + ":" + m.getUTCMinutes() + ":" + m.getUTCSeconds();
}

var price = '10,000';
price = Number(price.replace(/[^0-9\.-]+/g,""));
console.log(price)


function set_pembayaran(e){
	var id = jQuery(e).attr('data-id_transaction');
	var remaining_payment = jQuery(e).attr('data-remaining_payment');
	remaining_payment = Number(remaining_payment);
	jQuery('#total_payment_show').val(remaining_payment.format());
	jQuery('#id_transaction_edit').val(id);
}



function set_ubah_status(e){
	var id = jQuery(e).attr('data-id_transaction');
	console.log(id)
	jQuery('#idt_title').text(id);
	jQuery('#id_transaction_edit').val(id);
	const button = document.getElementById('package-'+id);
	let current_status = button.getAttribute('data-status_package');
	document.getElementById('status').value = current_status;
	//console.log(current_status);
}



Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

function focus_st(event){
	if (event.keyCode === 13) {
    	jQuery('#save-transaction').focus()
  	}
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
	var total = jQuery('#total_payment_show').val();
	var payment = jQuery('#payment').val()
	
    
    manual_discount = Number(manual_discount.replace(/[^0-9\.-]+/g,""));
	total = Number(total.replace(/[^0-9\.-]+/g,""));
	payment = Number(payment.replace(/[^0-9\.-]+/g,""));

	var change = payment - (total - manual_discount);
	change = change.format(0)
	jQuery('#change').val(change);

}
