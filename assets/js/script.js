
jQuery(document).ready(function($) {

	//Detecting mobile devices
	var isMobile = {
	    Android: function() {
	        return navigator.userAgent.match(/Android/i);
	    },
	    BlackBerry: function() {
	        return navigator.userAgent.match(/BlackBerry/i);
	    },
	    iOS: function() {
	        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	    },
	    Opera: function() {
	        return navigator.userAgent.match(/Opera Mini/i);
	    },
	    Windows: function() {
	        return navigator.userAgent.match(/IEMobile/i);
	    },
	    any: function() {
	        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	    }
	};

	$('.phone-call-link').click(function() {
		
		var data = {};

		// console.log($(this).data('phone-number'));
		// console.log($(this).data('hidden'));
		if($(this).data('hidden')){
			$(this).text($(this).data('phone-number'));
		}
		data['phone_number'] = $(this).data('phone-number'),
		data['tag'] = $(this).data('tag'),

		ajax_save_phone_click(data);
	   	return true;	
	});
	
	
	function ajax_save_phone_click(json){
		var jsonString = JSON.stringify(json);

		$.ajax({
			type: 'POST',
			url: ajax_url,
			data: {
				action: 'save_call_click',
				data: jsonString
			},
			success: function(data){
				console.log("return: "+ data);
			},
			error: function(jqXhr, textStatus, errorThrown){
				console.log('fail - ' +  errorThrown );
			}
		});
		return false;
	}
	

});

