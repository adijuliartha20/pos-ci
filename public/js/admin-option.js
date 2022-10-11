jQuery('#formValidate').submit(function(){
	var error = 0;

	var type_discount = jQuery('#type_discount').val()

	if(type_discount!=''){
		var discount = jQuery('#discount').val()
		if(discount=='') error++;
	}
	
	if(error==0){
        jQuery('#btn-save').text('Mohon Menunggu...')
		var form = jQuery(this);
	    
	    var arr = form.serializeArray();
	    var dt = {};
	    //arr = form.serialize();
        
        for (var i = 0; i < arr.length; i++) {
        	var value = arr[i].value.replace(/[($)\s\._\-]+/g, '');

        	if(arr[i].name=='discount' || arr[i].name=='limit_month' || arr[i].name=='limit_year') value = Number(value.replace(/[^0-9\.-]+/g,""));
            dt[arr[i].name] = value;
        };
        
        var url = jQuery(form).prop("action");
        jQuery.post(url,dt,function(response){
        	var res = jQuery.parseJSON(response)
            var class_alert = 'alert alert-danger';
            if(res.status=='success'){
            	class_alert = 'alert alert-success';

            	setTimeout(function(){
	            	jQuery('#alert-form').slideUp(600)	
	            },6000)
            }

            jQuery('#alert').attr('class',class_alert);
            jQuery('#middle-alert').html(res.msg);
            jQuery('#alert-form').slideDown(600);
            jQuery('#btn-save').text('Simpan')

            return false;
        })
	}
	return false;
})


function mode_discount(e){
	var v = jQuery(e.target).val()
	if(v!='') jQuery('#discount').attr('required','required');
	else {
			jQuery('#discount').val('');
			jQuery('#discount').removeAttr('required');
	}

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
        
        /**
         * ==================================
         * When Form Submitted
         * ==================================
         */
        /*$form.on( "submit", function( event ) {
            
            var $this = $( this );
            var arr = $this.serializeArray();
        
            for (var i = 0; i < arr.length; i++) {
                    arr[i].value = arr[i].value.replace(/[($)\s\._\-]+/g, ''); // Sanitize the values.
            };
            
            console.log( arr );
            
            event.preventDefault();
        });*/
        
    });
})(jQuery);