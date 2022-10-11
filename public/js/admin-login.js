/*jQuery('#formValidate').submit(function(){
	var error = 0;
	if(jQuery('#username').val()=='') error++;
	if(jQuery('#password').val()=='') error++;

	if(error==0){
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
	            	window.location.href = jQuery('#ajax_url').val()
	            }else{
	            	jQuery('#middle-alert').html(res.msg);
	            	jQuery('#alert-form').slideDown(600);	

	            	setTimeout(function(){
		            	jQuery('#alert-form').slideUp(600)	
		            },1000)
	            }
	            jQuery('#alert').attr('class',class_alert);
	            return false;
	        }
	    });
	}
	return false;
})
//onclick="login(event,'')"



jQuery(document).ready(function(){
	window.onload = function() { 
	    document.getElementById("formValidate").onsubmit = function() { 

	    	var error = 0;
			if(jQuery('#username').val()=='') error++;
			if(jQuery('#password').val()=='') error++;
	        
	        var url_login = jQuery('#ajax_url').val()+'/login';

	        var form = jQuery("#formValidate");
		    var formdata = false;
		    if (window.FormData){
		        formdata = new FormData(form[0]);
		    }

		    console.log(formdata);

		    var dt = new Object()
		    dt.username = jQuery('#username').val()
		    dt.password = jQuery('#password').val()
		    jQuery.post(url_login, dt, function(data){
		    	var res = jQuery.parseJSON(data)
		            var class_alert = 'alert alert-danger';
		            if(res.status=='success'){
		            	window.location.href = jQuery('#ajax_url').val()
		            }else{
		            	jQuery('#middle-alert').html(res.msg);
		            	jQuery('#alert-form').slideDown(600);	

		            	setTimeout(function(){
			            	jQuery('#alert-form').slideUp(600)	
			            },1000)
		            }
		            jQuery('#alert').attr('class',class_alert);
		            return false;
		    })

		    return false;


	        jQuery.ajax({
		        url         : url_login,
		        data        : formdata ? formdata : form.serialize(),
		        cache       : false,
		        contentType : false,
		        processData : false,
		        type        : 'POST',
		        success     : function(data, textStatus, jqXHR){
		            var res = jQuery.parseJSON(data)
		            var class_alert = 'alert alert-danger';
		            if(res.status=='success'){
		            	window.location.href = jQuery('#ajax_url').val()
		            }else{
		            	jQuery('#middle-alert').html(res.msg);
		            	jQuery('#alert-form').slideDown(600);	

		            	setTimeout(function(){
			            	jQuery('#alert-form').slideUp(600)	
			            },1000)
		            }
		            jQuery('#alert').attr('class',class_alert);
		            return false;
		        }
		    });

		    

	    };
	};

});
 
*/