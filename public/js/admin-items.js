jQuery(document).ready(function(){
    jQuery('#mid').focus()
})

var state = 0;
jQuery('#formValidate').submit(function(){
    jQuery('#btn-save').text('Mohon Menunggu...')
	var error = 0;

	var mode = jQuery('#mode').val()
	if(mode=='create'){
		
	}

	if(jQuery('#category').val()=='') error++;


	if(error==0 && state==0){
        state=1;
		var form = jQuery(this);
	    
	    var arr = form.serializeArray();
	    var dt = {};
        
        for (var i = 0; i < arr.length; i++) {
        	var value = arr[i].value;

        	if(arr[i].name=='qty' || arr[i].name=='sub_total' || arr[i].name=='capital_price' || arr[i].name=='price' || arr[i].name=='discount' || arr[i].name=='plus_discount' || arr[i].name=='reseller_price'){
        		value = arr[i].value.replace(/[($)\s\._\-]+/g, '');
        		value = Number(value.replace(/[^0-9\.-]+/g,""));	
        	} 
            dt[arr[i].name] = value;
        };
        
        var url = jQuery(form).prop("action");
        jQuery.post(url,dt,function(response){
        	var res = jQuery.parseJSON(response)
            var class_alert = 'alert alert-danger';
            if(res.status=='success'){
            	class_alert = 'alert alert-success';
                
                if(mode=='create') {
                    jQuery('#formValidate').trigger("reset");   
                    jQuery('#id_item').val(res.new_id)
                }

            	
                jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                jQuery('#mid').focus()
            	setTimeout(function(){
	            	jQuery('#alert-form').slideUp(600)
	            },6000)
            }

            jQuery('#alert').attr('class',class_alert);
            jQuery('#middle-alert').html(res.msg);
            jQuery('#alert-form').slideDown(600);
            state=0;
            jQuery('#btn-save').text('Simpan')
            return false;
        })
	}else{
        jQuery('#btn-save').text('Simpan')
        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
    }
	return false;
})


function success_page(){

}

//pake jquery ganti url after submit
//jQuery
function action_row(event,id,action){
	var url  = jQuery('#active_url').val()+'/change-status';
	var dt = new Object();
		dt.id = id;
		dt.action = action;

	jQuery.post(url, dt, function(response){
		var res = jQuery.parseJSON(response)
		if(res.status=='success'){
			jQuery('#tr-'+id).fadeOut()
		}
		else alert(res.msg)	
	})
}


(function($, undefined) {
    "use strict";
    // When ready.
    $(function() {
        
        var $form = $( "#formValidate" );
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


function set_capital_price(event){
	var qty = jQuery('#qty').val()
	var sub_total = jQuery('#sub_total').val()

	if(qty!='' && sub_total!=''){
		qty = Number(qty.replace(/[^0-9\.-]+/g,""));
		sub_total = Number(sub_total.replace(/[^0-9\.-]+/g,""));
        /*if(arr[i].name=='discount') value = Number(value.replace(/[^0-9\.-]+/g,""));*/
		var capital_price = sub_total/qty;
		jQuery('#capital_price').val(capital_price)

		var input = jQuery('#capital_price').val();
			input = input.replace(/[\D\s\._\-]+/g, "");
	        input = input ? parseInt( input, 10 ) : 0;

        jQuery('#capital_price').val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
        } );
		//jQuery('#capital_price').val(capital_price)
	}
}


function mode_discount(e){
	var v = jQuery(e.target).val()
	if(v!='') jQuery('#discount').attr('required','required');
	else {
			jQuery('#discount').val('');
			jQuery('#plus_discount').val('');
			jQuery('#discount').removeAttr('required');
	}

}