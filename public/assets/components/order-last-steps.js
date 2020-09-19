$(function(){
	
	window.order_id = $('input.tab').val();
	window.code = $('input.tab').data('tab');
	window.status = $('input.tab').data('tabs');

	$('.selectpicker').selectpicker();
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('[data-toggle="tooltip"]').tooltip();

	function changePersonData(type , newValue , person, orderPerson){
		$.ajax({
			url: "/orders/changePerson/id".replace('id',order_id),
			type: 'POST',
			data: {
				'_token': $('input[name="_token"]').val(),
				'order_id': order_id,
				'type': type,
				'value': newValue,
				'person': person,
			},
			success: function (data) {
				if (isNaN(data)) {
					$.each(data['errors'], function (i, item) {
                    	toastr.error('Rayagate Engine', item);
					});
				} else if (data == 1) {
                    toastr.success('Rayagate Engine', orderPerson +' '+type+' Updated Successfully');
				}
			},        
			error: function(data){
				toastr.error('Rayagate Engine', "Whoops \n Error may be in connection to server");
			}

		});
	}

	$('a#userSendername').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('name',newValue, 'sen', 'Sender');
		}
	});

	$('a#userSenderphone').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('phone',newValue, 'sen', 'Sender');
		}
	});

	$('a#userSenderemail').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('email',newValue, 'sen', 'Sender');
		}
	});

	$('a#userSendercompany').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('company',newValue, 'sen', 'Sender')
		}
	});

	$('a#userRecievername').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('name',newValue, 'rec', 'Receiver');
		}
	});

	$('a#userRecieverphone').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('phone',newValue, 'rec', 'Receiver');
		}
	});

	$('a#userRecieveremail').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('email',newValue, 'rec', 'Receiver');
		}
	});

	$('a#userRecievercompany').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('company',newValue, 'rec', 'Receiver')
		}
	});

	$('a#userOthername').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('name',newValue, 'oth', 'Other Biller');
		}
	});

	$('a#userOtherphone').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('phone',newValue, 'oth', 'Other Biller');
		}
	});

	$('a#userOtheremail').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('email',newValue, 'oth', 'Other Biller');
		}
	});

	$('a#userOthercompany').editable({
		mode : 'inline',
		success: function(response,newValue){
			changePersonData('company',newValue, 'oth', 'Other Biller')
		}
	});

	$('a#description').editable({
		mode: 'inline',
		success: function(response,newValue){
			$.ajax({
			url: "/orders/changeDescription/id".replace('id',order_id),
			type: 'POST',
			data: {
				'_token': $('input[name="_token"]').val(),
				'order_id': order_id,
				'description': newValue,
			},
			success: function (data) {
				if (isNaN(data)) {
					$.each(data['errors'], function (i, item) {
                    	toastr.error('Rayagate Engine', item);
					});
				} else if (data == 1) {
                    toastr.success('Rayagate Engine', 'Description Updated Successfully');
				}
			},        
			error: function(data){
				toastr.error('Rayagate Engine', "Whoops \n Error may be in connection to server");
			}

		});
		}
	});

	function getOrderOffers(){
		$.ajax({
			url: "/orders/lastSteps/code/offers".replace('code',code),
			type: 'GET',
			data: {
				'_token': $('input[name="_token"]').val(),
				'code': code,
			},
			success: function (data) {
				if(data != 1){
					$('.payment_method').empty();
					$('.payment_method').html(data);
				}
			},        
			error: function(data){
				toastr.error('Rayagate Engine', "Whoops \n Error may be in connection to server");
			}
		});	
	}

	if(window.status == 2){
		var refreshIntervalId = setInterval(getOrderOffers,5000);
	}

	function acceptOffer(element){
		$.ajax({
			url: "/orders/lastSteps/code/acceptOffer".replace('code',code),
			type: 'POST',
			data: {
				'_token': $('input[name="_token"]').val(),
				'code': code,
				'id': $(element).data('tab'),
			},
			success: function (data) {
				$('span.valid_until').data('countdown',data[3]);
				initCountDown();
				clearInterval(refreshIntervalId);
				$('.offer-design').remove();
				$('#app .payment_method').append($('.payment-data'));
				$('#app .payment_method .payment-data').fadeIn(250);
				$('.further_info .total_value').html(data[2] + " €");
				$('.further_info .cost').html(data[0] + " €");
				$('.further_info .vat').html(data[1] + " €");
			},        
			error: function(data){
				toastr.error('Rayagate Engine', "Whoops \n Error may be in connection to server");
			}
		});	
	}

	function refuseOffer(element){
		$.ajax({
			url: "/orders/lastSteps/code/refuseOffer".replace('code',code),
			type: 'POST',
			data: {
				'_token': $('input[name="_token"]').val(),
				'code': code,
				'id': $(element).data('tab'),
			},
			success: function (data) {
				if(data == 1){
					$(element).remove();
					toastr.success('Rayagate Engine', "Offer Refused Successfully");
				}
			},        
			error: function(data){
				toastr.error('Rayagate Engine', "Whoops \n Error may be in connection to server");
			}
		});	
	}

	$(document).on('click','#app .btn-danger',function(){
		refuseOffer($(this).parents('li'))
	});

	$(document).on('click','#app .btn-success',function(){
		acceptOffer($(this).parents('li'))
	});

	$("input[type=checkbox]").iCheck({
        checkboxClass: 'icheckbox_square-orange',
        radioClass: 'iradio_minimal-orange'
    }); 

    $(document).on('ifChecked','input[type=checkbox]', function(event){
    	$('.select_this.disable').removeClass('disable');
    });

    $(document).on('ifUnchecked','input[type=checkbox]',function(){
        $('.select_this').addClass('disable');
    });

    function initCountDown(){
    	$('[data-countdown]').each(function(){
	    	var $this = $(this), finalDate=$(this).data('countdown');
	    	$this.countdown(finalDate,function(event){
	    		$this.html(event.strftime('%H:%M:%S'));
	    	});
	    });
    }

    initCountDown();

    $(document).on('click','a#paypal,a#sepa',function(){
    	var value = 0;
    	if($(this).attr('id') == 'paypal'){
    		value = 0;
    	}else{
    		value = 6;
    	}
    	$('form#pay input[name="payment_type"]').val(value);
    	$('form#pay').submit();
    });

    $(document).on('click','a#bar',function(){
    	$('form#bar input[name="payment_type"]').val(8);
    	$('form#bar').submit();
    })

    $(document).on('click','a#visa',function(){
    	$('form#payment-form input[name="payment_type"]').val($(this).data('type'));
    	$('form#payment-form').submit();
    });

	// $('#loadFrom').editable({
	// 		type:'datetime',
	// 		mode:'inline',
	// 		format: 'yyyy-mm-dd hh:ii',
	// 		viewformat: 'yyyy-mm-dd hh:ii',
	// 		placement: 'right',
	// 		datetimepicker: {
	// 			todayHighlight: true,
	// 			showMeridian: true,
	// 			minuteStep: 1,
	// 			pickerPosition: "bottom-left",
	// 			format: 'yyyy-mm-dd hh:ii',

	// 		},
	// 		success: function(response,newValue){
	// 			$.ajaxSetup({
	// 				headers: {
	// 					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 				}
	// 			});
	// 			$.ajax({
	// 				url: "{{route('edit_load_from')}}",
	// 				type: 'POST',
	// 				data: {
	// 					'_token': $('input[name="_token"]').val(),
	// 					'order_id': {{$order->id}},
	// 					'load_from': newValue,
	// 				},
	// 				success: function (data) {
	// 					if(data == 1){
	// 						$.notify("Success \n Dates Updated Successfully",{ position:"top right" ,className:"success"});
	// 					}else{
	// 						$.notify("Whoops \n New Order Created !!",{ position:"top right" ,className:"Success"});
	// 						window.location.href = data;
	// 					}
	// 				},        
	// 				error: function(data){
	// 					$.notify("Whoops \n Error may be in connection to server",{ position:"top right" ,className:"error"});
	// 				}

	// 			});
	// 		}
	// 	});

	// 	$('#loadUp').editable({
	// 		type:'datetime',
	// 		mode:'inline',
	// 		format: 'yyyy-mm-dd hh:ii',
	// 		viewformat: 'yyyy-mm-dd hh:ii',
	// 		placement: 'right',
	// 		datetimepicker: {
	// 			todayHighlight: true,
	// 			showMeridian: true,
	// 			minuteStep: 1,
	// 			pickerPosition: "bottom-left",

	// 		},
	// 		success: function(response,newValue){
	// 			$.ajaxSetup({
	// 				headers: {
	// 					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 				}
	// 			});
	// 			$.ajax({
	// 				url: "{{route('edit_load_up')}}",
	// 				type: 'POST',
	// 				data: {
	// 					'_token': $('input[name="_token"]').val(),
	// 					'order_id': {{$order->id}},
	// 					'load_up': newValue,
	// 				},
	// 				success: function (data) {
	// 					if(data == 1){
	// 						$.notify("Success \n Dates Updated Successfully",{ position:"top right" ,className:"success"});
	// 					}else{
	// 						$.notify("Whoops \n New Order Created !!",{ position:"top right" ,className:"Success"});
	// 						window.location.href = data;
	// 					}
	// 				},        
	// 				error: function(data){
	// 					$.notify("Whoops \n Error may be in connection to server",{ position:"top right" ,className:"error"});
	// 				}

	// 			});
	// 		}
	// 	});


	// 	$('#deliveryFrom').editable({
	// 		type:'datetime',
	// 		mode:'inline',
	// 		format: 'yyyy-mm-dd hh:ii',
	// 		viewformat: 'yyyy-mm-dd hh:ii',
	// 		placement: 'right',
	// 		datetimepicker: {
	// 			todayHighlight: true,
	// 			showMeridian: true,
	// 			minuteStep: 1,
	// 			pickerPosition: "bottom-left",

	// 		},
	// 		success: function(response,newValue){
	// 			$.ajaxSetup({
	// 				headers: {
	// 					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 				}
	// 			});
	// 			$.ajax({
	// 				url: "{{route('edit_delivery_from')}}",
	// 				type: 'POST',
	// 				data: {
	// 					'_token': $('input[name="_token"]').val(),
	// 					'order_id': {{$order->id}},
	// 					'delivery_from': newValue,
	// 				},
	// 				success: function (data) {
	// 					if(data == 1){
	// 						$.notify("Success \n Dates Updated Successfully",{ position:"top right" ,className:"success"});
	// 					}else{
	// 						$.notify("Whoops \n New Order Created !!",{ position:"top right" ,className:"Success"});
	// 						window.location.href = data;
	// 					}
	// 				},        
	// 				error: function(data){
	// 					$.notify("Whoops \n Error may be in connection to server",{ position:"top right" ,className:"error"});
	// 				}

	// 			});
	// 		}
	// 	});

	// 	$('#deliveryUntil').editable({
	// 		type:'datetime',
	// 		mode:'inline',
	// 		format: 'yyyy-mm-dd hh:ii',
	// 		viewformat: 'yyyy-mm-dd hh:ii',
	// 		placement: 'right',
	// 		datetimepicker: {
	// 			todayHighlight: true,
	// 			showMeridian: true,
	// 			minuteStep: 1,
	// 			pickerPosition: "bottom-left",

	// 		},
	// 		success: function(response,newValue){
	// 			$.ajaxSetup({
	// 				headers: {
	// 					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 				}
	// 			});
	// 			$.ajax({
	// 				url: "{{route('edit_delivery_until')}}",
	// 				type: 'POST',
	// 				data: {
	// 					'_token': $('input[name="_token"]').val(),
	// 					'order_id': {{$order->id}},
	// 					'delivery_until': newValue,
	// 				},
	// 				success: function (data) {
	// 					if(data == 1){
	// 						$.notify("Success \n Dates Updated Successfully",{ position:"top right" ,className:"success"});
	// 					}else{
	// 						$.notify("Whoops \n New Order Created !!",{ position:"top right" ,className:"Success"});
	// 						window.location.href = data;
	// 					}
	// 				},        
	// 				error: function(data){
	// 					$.notify("Whoops \n Error may be in connection to server",{ position:"top right" ,className:"error"});
	// 				}

	// 			});
	// 		}

	// 	});

});