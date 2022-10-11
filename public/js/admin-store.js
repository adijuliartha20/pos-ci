var state = 0;
jQuery('#formValidate').submit(function(){
	var error = 0;

	var mode = jQuery('#mode').val()
	if(mode=='create'){
		
	}

	if(jQuery('#store').val()=='') error++;
	if(jQuery('#address').val()=='') error++;


	if(error==0 && state==0){
		state = 1;
		var form = jQuery(this);
	    var formdata = false;
	    if (window.FormData){
	        formdata = new FormData(form[0]);
	    }

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
	            var class_alert = 'alert alert-danger';
	            if(res.status=='success'){
	            	if(mode=='create') jQuery('#formValidate').trigger("reset");
	            	class_alert = 'alert alert-success';
	            	setTimeout(function(){
		            	jQuery('#alert-form').slideUp(600)
		            },6000)
	            }
	            jQuery('#alert').attr('class',class_alert);
	            jQuery('#middle-alert').html(res.msg);
	            jQuery('#alert-form').slideDown(600);
	            state = 0;	            
	            return false;
	        }
	    });
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