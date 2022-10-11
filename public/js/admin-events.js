var state = 0;
jQuery('#formValidate').submit(function(){
	var error = 0;
	jQuery('#btn-save').text('Mohon Menunggu...')
	var mode = jQuery('#mode').val()
	if(mode=='create'){
		
	}

	if(jQuery('#category').val()=='') error++;


	if(error==0 && state==0){
		//state=1;
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


function add_item_date(e){
	var item = jQuery('#temp-date .item-date').clone();

	jQuery('#list-date .item-date:first-child').after(item);
	var id = 'date'+ID()

	jQuery('#list-date .item-date:nth-child(2) .date').attr('id',id);
	jQuery('#'+id).daterangepicker({singleDatePicker: true});
	console.log(id)
	//jQuery('#list-date .item-date:nth-child(2)').daterangepicker({singleDatePicker: true});

}

function delete_item_date(e){
	jQuery(e.target).parent().parent().slideUp(300)

	setTimeout(function(){
		jQuery(e.target).parent().parent().remove()
	},300)
}


var ID = function () {
  // Math.random should be unique because of its seeding algorithm.
  // Convert it to base 36 (numbers + letters), and grab the first 9 characters
  // after the decimal.
  return '_' + Math.random().toString(36).substr(2, 9);
};