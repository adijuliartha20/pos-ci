var state = 0;
jQuery('#formValidate').submit(function(){
	var error = 0;
	jQuery('#btn-save').text('Mohon Menunggu...')
	var mode = jQuery('#mode').val()
	if(mode=='create'){
		
	}

	var country  		= jQuery('#id_country').val();
	var province 		= jQuery('#id_province').val();
	var district 		= jQuery('#id_district').val();
	var sub_district 	= jQuery('#id_sub_district').val();
	var address 		= jQuery('#address').val();
	console.log(address)

	if(country=='' || country==null) {		
		jQuery('#id_country').addClass('error-field');
		error++;	
	}
	if(province=='' || province==null) {
		jQuery('#id_province').addClass('error-field');
		error++;	
	}
	if(district=='' || district==null){
		jQuery('#id_district').addClass('error-field');
		error++;	
	}
	if(sub_district=='' || sub_district==null){
		jQuery('#id_sub_district').addClass('error-field');
		error++;	
	}

	/*if(address=='' || address==null){
		jQuery('#address').addClass('error-field');
		error++;	
	}*/


	console.log(error)
	console.log(state)

	if(error==0 && state==0){
		state=1;
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
	            
	            jQuery('#btn-save').text('Simpan')
	            state=0;
	            return false;
	        }
	    });
	}else{
		 jQuery('#btn-save').text('Simpan')
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






function get_province(id_country, set_district = false){
	var element = document.getElementById("id_country");
	element.classList.remove("error-field");

	set_option_null('country')

	var select = document.getElementById("id_province");	
	select.options.length = 0;
    select.options[select.options.length] = new Option('Silahkan Menunggu...', '0', false, false);

    var url  = jQuery('#ajax_url').val()+'/province/get-province';
	var dt = new Object();
		dt.id = id_country;

	jQuery.post(url, dt, function(response){
		var res = jQuery.parseJSON(response)
		if(res.status=='success'){
			select.options.length = 0;
			var province = res.province;

			select.options[select.options.length] = new Option('Silahkan pilih Provinsi', '0', false, false);

			for (var i = 0; i < province.length; i++) {
				select.options[select.options.length] = new Option(province[i].name, province[i].id , false, false);

				//select.options.length++;

			}

			if(set_district){

			}
		}
		else alert(res.msg)	
	})
}

function get_district(id_province){
	var element = document.getElementById("id_province");
	element.classList.remove("error-field");

	set_option_null('province')


	var select = document.getElementById("id_district");
	select.options.length = 0;
    select.options[select.options.length] = new Option('Silahkan Menunggu...', '0', false, false);


    var url  = jQuery('#ajax_url').val()+'/districts/get-district';
	var dt = new Object();
		dt.id = id_province;
	
	jQuery.post(url, dt, function(response){
		var res = jQuery.parseJSON(response)
		if(res.status=='success'){
			select.options.length = 0;
			var data = res.districts;

			select.options[select.options.length] = new Option('Silahkan pilih Kabupaten', '0', false, false);

			for (var i = 0; i < data.length; i++) {
				select.options[select.options.length] = new Option(data[i].name, data[i].id , false, false);

				//select.options.length++;

			}

		}
		else alert(res.msg)
	})
}

function get_sub_district(id_district){
	var element = document.getElementById("id_district");
	element.classList.remove("error-field");


	var select = document.getElementById("id_sub_district");
	select.options.length = 0;
    select.options[select.options.length] = new Option('Silahkan Menunggu...', '0', false, false);


    var url  = jQuery('#ajax_url').val()+'/sub-district/get-sub-district';
	var dt = new Object();
		dt.id = id_district;
	jQuery.post(url, dt, function(response){
		var res = jQuery.parseJSON(response)
		if(res.status=='success'){
			select.options.length = 0;
			var data = res.sub_districts;

			select.options[select.options.length] = new Option('Silahkan pilih Kabupaten', '0', false, false);

			for (var i = 0; i < data.length; i++) {
				select.options[select.options.length] = new Option(data[i].name, data[i].id , false, false);
			}
		}
		else alert(res.msg)
	})
}

function remove_class(element){
	element.classList.remove("error-field");
}

function set_option_null(state=''){
	if(state=='country'){
		var id_province = document.getElementById("id_province");
		id_province.options.length = 0;
	}

	if(state=='province' || state=='country'){
		var id_district = document.getElementById("id_district");
		id_district.options.length = 0;
	}

	var id_sub_district = document.getElementById("id_sub_district");
	id_sub_district.options.length = 0;
}