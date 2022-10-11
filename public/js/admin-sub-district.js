var state = 0;
jQuery('#formValidate').submit(function(){
	var error = 0;
	jQuery('#btn-save').text('Mohon Menunggu...')
	var mode = jQuery('#mode').val()
	if(mode=='create'){
		
	}

	//if(jQuery('#category').val()=='') error++;


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
	var select = document.getElementById("id_district");
	select.options.length = 0;
    select.options[select.options.length] = new Option('Silahkan Menunggu...', '0', false, false);


    var url  = jQuery('#ajax_url').val()+'/districts/get-district';
	var dt = new Object();
		dt.id = id_province;

	//console.log(dt)
	
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
