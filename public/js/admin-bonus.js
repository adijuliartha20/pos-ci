jQuery('#formValidate').submit(function(){
	var error = 0;

	var mode = jQuery('#mode').val()
	if(mode=='create'){
		
	}

	if(jQuery('#category').val()=='') error++;


	if(error==0){
        jQuery('#btn-save').text('Mohon Menunggu...')
		var form = jQuery(this);
	    
	    var arr = form.serializeArray();
	    var dt = {};
        
        for (var i = 0; i < arr.length; i++) {
        	var value = arr[i].value;

        	if(arr[i].name=='start' || arr[i].name=='end' || arr[i].name=='bonus'){
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
                
                if(mode=='create') jQuery('#formValidate').trigger("reset");

            	jQuery('#id_item').val(res.new_id)
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


