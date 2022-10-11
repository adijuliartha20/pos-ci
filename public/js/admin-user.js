var state = 0;
jQuery('#formValidate').submit(function(){
	var error = 0;
	var password = jQuery('#password').val()
	var confirm_password = jQuery('#confirm_password').val()

	var mode = jQuery('#mode').val()
	if(mode=='create'){
		if(jQuery('#username').val()=='') error++;
		if(jQuery('#password').val()=='') error++;
		if(jQuery('#confirm_password').val()=='') error++;
		if(jQuery('#picture').val()=='') error++;	
	}

	

	if(jQuery('#user_tipe').val()=='') error++;
	if(jQuery('#first_name').val()=='') error++;
	if(jQuery('#last_name').val()=='') error++;
	if(jQuery('#email').val()=='') error++;
	if(jQuery('#phone').val()=='') error++;
	


	if(password!=confirm_password){
		alert('Ulangi Password salah')
		error++;
	}

	if(error==0 && state==0){
		state = 1;
		jQuery('#btn-save').text('Mohon Menunggu...')
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
	            	//if mode edit profile & change foto
	            	var is_edit_profile = jQuery('#is_edit_profile').val()
	            	//console.log(is_edit_profile);
	            	//console.log(document.getElementById("picture").files.length)
	            	if(is_edit_profile=='yes'){
	            		if( document.getElementById("picture").files.length == 0 ){
						    jQuery('#formValidate').trigger("reset");	
						}else{
							location.reload();
						}
	            	}else{
	            		jQuery('#formValidate').trigger("reset");
	            	}

	            	
	            	class_alert = 'alert alert-success';

	            	setTimeout(function(){
		            	jQuery('#alert-form').slideUp(600)	
		            },6000)
	            }

	            jQuery('#alert').attr('class',class_alert);
	            jQuery('#middle-alert').html(res.msg);
	            jQuery('#alert-form').slideDown(600);
	         	
	         	jQuery('#btn-save').text('Simpan') 
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