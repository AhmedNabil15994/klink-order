$(function(){

    var directionsDisplay = new google.maps.DirectionsRenderer();
    var directionsService = new google.maps.DirectionsService();
    var map = new google.maps.Map(document.getElementById('googlemaps'), {
            minZoom:0,
            zoom:10, 
            mapTypeId:google.maps.MapTypeId.ROADMAP,
            mapTypeControl: false,
            streetViewControl: false,
        });

    window.id = $("#myDetails").data('id');

    /**** Initialize Map With Route Between Order Points ****/
    var markers = [];
    function initialize(start , end) {

        removeMarkers();
        
        directionsDisplay.setMap(map);
        directionsDisplay.setOptions( { suppressMarkers: true } );

        var start = new google.maps.LatLng(start[0],start[1]);
        var end = new google.maps.LatLng(end[0],end[1]);

        var marker = new google.maps.Marker({
            position: start,
            map: map,
            animation: google.maps.Animation.DROP,
            icon: '/assets/images/map-marker-red.svg'
        });

        var marker2 = new google.maps.Marker({
            position: end,
            map: map,
            animation: google.maps.Animation.DROP,
            icon: '/assets/images/slating-flag-map.svg'
        });

        markers =[marker,marker2];

        displayRoute(start,end,directionsDisplay,directionsService);
    }


    /**** Display Route On Maps Between Two Points ****/
    function displayRoute(start,end,directionsDisplay,directionsService){
        var request = {
            origin:start, 
            destination:end,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                var myRoute = response.routes[0];
            }
        });
    }

    /**** Initialize Address AutoComplete ****/
    function initializeAutoComplete(input) {

        var autocomplete = new google.maps.places.Autocomplete(input); 
        autocomplete.addListener('place_changed', function() {
            place = autocomplete.getPlace();
            if (!place.geometry) {
                setTimeout(function () {
                    $(input).removeAttr('class');
                    $(input).addClass('input-danger');
                    toastr.error('Rayagate Engine', "No details available for : '" + place.name + "'" );
                }, 1000);
                return;
            }
            var latlng = {
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            }
            geocodeLatLng(latlng,place,input);
        });
        
    }

    /**** Geocoding Address By Input ****/
    var latlngs = [];
    function geocodeLatLng(latlng,place,result){
        var type = '';
        if(result == document.getElementById('OrderfromGeoAddress')){
            type = 'from';
            latlngs[0] = latlng;
        }else{
            type = 'to';
            latlngs[1] = latlng;
        }
        geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'location': latlng}, function(results, status) {
            if (status == 'OK') {  
                var zip = '',
                    street_number = '',
                    route = '',
                    city = '',
                    country = '';
                $.each(place.address_components, function(){
                    switch(this.types[0]){
                        case "postal_code":
                            zip = this.short_name;
                            break;
                        case "street_number":
                            street_number = this.short_name;
                            break;
                        case "route":
                            route = this.short_name;
                            break;    
                        case "administrative_area_level_1":
                            city = this.long_name;
                            break;
                        case "country":
                            country = this.short_name;
                            break;                  
                    }
                });       

                var placeObj = {
                    "postal_code": zip,   
                    "home": street_number,   
                    "street": route,   
                    "city": city,   
                    "country": country,   
                    "latlng": [latlng.lat,latlng.lng],   
                };
                
                if(type == 'from'){
                    window.from = placeObj;
                }else{
                    window.to = placeObj;
                }

                if(street_number == ''){
                    setTimeout(function () {
                        $(result).removeAttr('class');
                        $(result).addClass('input-warning');
                        toastr.warning('Rayagate Engine', "Invalid Street Number" );
                    }, 1000);
                }else{
                    $(result).removeAttr('class');
                    $(result).addClass('input-success');
                }              

                if(type == 'to'){
                    getDetails(latlngs[0], latlngs[1]);
                    initialize(window.from.latlng , window.to.latlng);
                }
            }else {
                setTimeout(function () {
                    $(result).removeAttr('class');
                    $(result).addClass('input-danger');
                    toastr.warning('Rayagate Engine', 'Geocode was not successful for the following reason: ' + status);
                }, 1000);
                alert();
            }
        });
    }

    /**** Route Between Two Points ****/
    function getDetails(source , destination){
        var directionsService = new google.maps.DirectionsService();
        var start = new google.maps.LatLng(source.lat, source.lng);
        var end = new google.maps.LatLng(destination.lat, destination.lng);
        var request = {
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode.DRIVING,
                provideRouteAlternatives: true,
                unitSystem: google.maps.UnitSystem.METRIC,
            };
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
            
                var route = response.routes[0];
                var myDetails = {
                    'distance': route.legs[0].distance,
                    'duration': route.legs[0].duration,
                }
                window.details = JSON.stringify(myDetails);
                setNewValues(myDetails);
            } 
        });  
    }

    /**** Remove Google Maps Markers ****/
    function removeMarkers(){
        for(i=0; i<markers.length; i++){
            markers[i].setMap(null);
        }
    }

    function resizeMap(){
        $('.map-container').css('position','unset');
        $('.more-info').show();
        $('#googlemaps div:first').attr('id','firstDiv');
        $('#googlemaps').addClass('full-screen');
        $('#firstDiv').append($('.more-info'));
        $('#firstDiv .more-info').append($('.pac-container'));
        $('#firstDiv button.gm-fullscreen-control').addClass('button-class');
        var from = $('.from-info-box-data.from').text().trim();
        var to = $('.from-info-box-data.to').text().trim();
        $('#OrderfromGeoAddress').val(from);
        $('#OrdertoGeoAddress').val(to);
        $('#OrderfromGeoAddress,#OrdertoGeoAddress').removeAttr('class');
        document.getElementById('firstDiv').requestFullscreen();
    }

    function backSizeMap(){
        $('.map-container').css('position','relative');
        $('.more-info').hide();
        $('#firstDiv button.gm-fullscreen-control').removeClass('button-class');
        $('#googlemaps').removeClass('full-screen');
        $('#OrderfromGeoAddress,#OrdertoGeoAddress').removeAttr('class');
    }

    function exitHandler() {
        if (!document.fullscreenElement && !document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
            backSizeMap();
        }
    }  

    /**** Set Distance And Duration After Address Changed ****/
    function setNewValues(data){
        duration = data.duration.text;
        distance = data.distance.text;

        $('.from-info-box-data.from').html($('#OrderfromGeoAddress').val());
        $('.from-info-box-data.to').html($('#OrdertoGeoAddress').val());
        $('.order-info-value.duration').html(duration);
        $('.order-info-value.distance').html(distance);

        changeDetails();
    }


    function setOrderCost(){
        var cost = $('.swiper-slide.swiper-slide-active .cost-field span.cost').html();
        $('.order-info-value span.cost').html(cost);
    }

    function setOrderDimensions(){
        setTimeout(function(){
            var width = $('.swiper-slide.swiper-slide-active .vehicle-dimenstions p.width').html();
            var length = $('.swiper-slide.swiper-slide-active .vehicle-dimenstions p.length').html();
            var height = $('.swiper-slide.swiper-slide-active .vehicle-dimenstions p.height').html();

            $('.small-input .width').val(width);
            $('.small-input .length').val(length);
            $('.small-input .height').val(height);
            $('.small-input input.with-error').removeClass('with-error');
        },500);
    }

    /**** Get Shipping Specification And Changing Price According To Shipping Specification ****/
    function getShipSpec(){
        window.ship_id = $('.swiper-slide.swiper-slide-active .vehicle-images-wrapper').data('id');
        window.cost_id = $('.swiper-slide.swiper-slide-active .vehicle-images-wrapper').data('tab');
        if($('#weightInput').val()){
            var ship_id = window.ship_id;
            var cost_id = window.cost_id;
            var id = window.id;
            $.ajax({
                url: "/orders/create_new/id/getShipsSpec/".replace('id',id),
                type: 'GET',
                data: {
                    '_token': $('input[name="_token"]').val(),
                    'id': id,
                    'ship_id': ship_id,
                    'cost_id': cost_id,
                    'load_time': $('.rs-tooltip.rs-tooltip-text').html(),
                    'persons': $('.rate-value.label-span').html(),
                },
                success: function (data) {
                    $('.swiper-slide.swiper-slide-active .cost-field span.cost').empty();
                    $('.swiper-slide.swiper-slide-active .cost-field span.cost').html(data);
                    $('.order-info-value span.cost').html(data);
                    setOrderCost();
                },
            });
        }

    }

    /**** Fire This Function When Order Addresses Changed ****/
    function changeDetails(){
        var id = window.id;
        var from = window.from;
        var to = window.to;
        var details = window.details;
        $.ajax({
            url: "/orders/create_new/id/changeDetails/".replace('id',id),
            type: 'GET',
            data: {
                '_token': $('input[name="_token"]').val(),
                'id': id,
                'from': JSON.stringify(from),
                'to': JSON.stringify(to),
                'details': details,
            },
            success: function (data) {
                if(data == 1){
                    getShipSpec();
                    setTimeout(function () {
                        toastr.success('Rayagate Engine', 'Order Addresses Changed Successfully');
                    }, 1000);
                }
            },
        });

    }

    /**** To Check If Main Weight Had Been Changed ****/
    function weightChanged(){
        var id = window.id;
        $.ajax({
            url: "/orders/create_new/id/getShipsByWeight/".replace('id',id),
            type: 'GET',
            data: {
                '_token': $('input[name="_token"]').val(),
                'id': id,
                'weight': $('#weightInput').val(),
                'width': $('input.width').val(),
                'length': $('input.length').val(),
                'height': $('input.height').val(),
            },
            success: function (data) {
                if(data != ''){
                    $('.swiper-wrapper').empty();
                    $('.swiper-wrapper').html(data);
                    showSwiper();
                }else{
                    $('.swiper-wrapper').empty();
                    hideSwiper();
                    setTimeout(function () {
                        toastr.warning('Rayagate Engine', 'No Valid Ships For Corresponding Data');
                    }, 1000);
                }
            },
            error: function (data) {
                $('.swiper-wrapper').empty();
                hideSwiper();
                setTimeout(function () {
                    toastr.warning('Rayagate Engine', 'No Valid Ships For Corresponding Data');
                }, 1000);
            }

        });


    }


    /**** Store Order Details ****/
    function storeOrder(){
        if($('#weightInput').val()){
            var ship_id = window.ship_id;
            var cost_id = window.cost_id;
            var id = window.id;

            var form = $('form.shown');

            var data = {
                '_token': $('input[name="_token"]').val(),
                'id': id,
                'ship_id': ship_id,
                'cost_id': cost_id,
                'weight': $('input#weightInput').val(),
                'items': $('input#NumberOfItems').val() ,
                'width': ! $('input.width').val() ? $('.swiper-slide.swiper-slide-active .vehicle-dimenstions p.width').html() : $('input.width').val(),
                'length': ! $('input.length').val() ? $('.swiper-slide.swiper-slide-active .vehicle-dimenstions p.length').html() : $('input.length').val(),
                'height': ! $('input.height').val() ? $('.swiper-slide.swiper-slide-active .vehicle-dimenstions p.height').html() : $('input.height').val(),
                'persons': $('.rate-value.label-span').html(),
                'load_time': $('.rs-tooltip.rs-tooltip-text').html(),
                'description': $('textarea#description').val(),
            };

            $.each(data,function(key,value){
                form.append('<input type="hidden" name="'+key+'" value="'+value+'" >');
            });

            if($('textarea#description').val() && $('textarea#description').val() != ''){
                form.submit();
            }else{
                $('textarea#description').parents('div.input-parent').addClass('with-error');
            }
        }

    }

    /**** My Rate Function ****/
    function myRate(element,type){
        $('.carry.hover').removeClass(type);
        element.prevAll('.carry').addClass(type); 
        element.addClass(type);
    }



    document.addEventListener('fullscreenchange', exitHandler);
    document.addEventListener('webkitfullscreenchange', exitHandler);
    document.addEventListener('mozfullscreenchange', exitHandler);
    document.addEventListener('MSFullscreenChange', exitHandler);    

    initialize($('#OrderfromGeoAddress').data('latlng') , $('#OrdertoGeoAddress').data('latlng'));
    initializeAutoComplete(document.getElementById('OrderfromGeoAddress'));
    initializeAutoComplete(document.getElementById('OrdertoGeoAddress'));
    
    $(document).on('click','.gm-fullscreen-control',function(){
        resizeMap();
    });

    $('.show-map.md img').on('click',function(){
        resizeMap();
    });

    $(document).on('click','#googlemaps.full-screen .gm-fullscreen-control',function(){
        backSizeMap();
    });

    /**** Tooltip ****/
    $('[data-toggle="tooltip"]').tooltip();


    /**** Initialize Swiper ****/
    var swiperSettings = {
            effect: 'flip',
            grabCursor: true,
            slidesPerView: 'auto',
            loop: true,
            loopFillGroupWithBlank: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        }
    var mySwiper = new Swiper('.swiper-container', swiperSettings);
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click','.letsComplete.btn',function(e){
        e.preventDefault();
        storeOrder();
    });

    
    $('ul.rate li').on('click',function(){
        getShipSpec();
    });
    
    $('ul.rate li.carry').hover(function(){
        myRate($(this),'hover');
        var count = $('ul.rate li.carry.hover').length;
        $('.rate-value').text(count+1);
    });

    $('ul.rate li.main').hover(function(){
        $('.rate-value').text(1);
        $('.carry.hover').removeClass('hover');
    });

    /**** Inputs Validation ****/
    $('input,textarea').on('focus',function(){
        if($(this).parents('.input-parent-triple').length){
            $(this).parents('.input-parent-triple').addClass('focused');
            $(this).parent('.small-input').addClass('focused');
        }else{
            $(this).parents('.input-parent').addClass('focused');
        }
    });

    $('input,textarea').on('blur',function(){
        if($(this).parents('.input-parent-triple').length){
            $(this).parents('.input-parent-triple').removeClass('focused');
            $(this).parent('.small-input').removeClass('focused');
            if( !$(this).val() || $(this).val() == 0 ){
                if( $('#weightInput').val() || $('#weightInput').val() > 0  ){
                    $(this).addClass('with-error');
                }
            }else{
                $(this).removeClass('with-error');
            }
        }else{
            $(this).parents('.input-parent').removeClass('focused');
            if( !$(this).val() || $(this).val() == 0 ){
                if( $('#weightInput').val() || $('#weightInput').val() > 0  ){
                    $(this).parents('.input-parent').addClass('with-error');
                }
            }else{
                $(this).parents('.input-parent').removeClass('with-error');
            }
        }
    });


    $('input.width,input.length,input.height,input#weightInput').keyup(function(){
        if($('#weightInput').val() && $('#weightInput').val() > 0 ){
            weightChanged();
            if($(this).attr('id') == 'weightInput'){
                setOrderDimensions();
            }
        }else{
            hideSwiper();
        }
    });


    /**** Initialize Round Slider ****/
    function setRoundSliderByValue(value){
        $("#round-slider").roundSlider({
            radius: 40,
            width: 5,
            max: 60,
            handleSize: "+8",
            handleShape: "dot",
            sliderType: "min-range",
            value: value,
            editableTooltip: false,
            change: function(event){
                getShipSpec();
            }
        });
    }

    setRoundSliderByValue($('.rounds').val() ? $('.rounds') : 5);

    /**** Increase Input Values ****/
    $('.kurier-arrow.up').on('click',function(){
        if($(this).siblings('input').val() >= 0){
            $(this).parents('div.input-parent').removeClass('with-error');
        } 
        var inputVal = ! $(this).siblings('input').val() ? 0 : $(this).siblings('input').val()  ;
        $(this).siblings('input').val(parseInt(inputVal) + 1);

        if($(this).siblings('input').attr('id') == 'weightInput' && $(this).siblings('input').val() != 0){
            showSwiper();
        }

    });


    /**** Decrease Input Values ****/
    $('.kurier-arrow.down').on('click',function(){
        if($(this).siblings('input').val() != 0){
            var inputVal = ! $(this).siblings('input').val() ? 0 : $(this).siblings('input').val();
            $(this).siblings('input').val(parseInt(inputVal) - 1);
            if(parseInt(inputVal) - 1 == 0){
                $(this).parents('div.input-parent').addClass('with-error');
                if($(this).siblings('input').attr('id') == 'weightInput'){
                    hideSwiper();
                }
            } 
        }else{
            $(this).parents('div.input-parent').addClass('with-error');
        }
    });

    function showSwiper(){
        $('.order-pricing').fadeIn(500);
        reinitializeSwiper();
        getShipSpec();
    }

    function hideSwiper(){
        $('.order-pricing').fadeOut(500);
        setTimeout(function(){
            $('input.width,input.length,input.height').val('');
        } ,500)
    }

    function reinitializeSwiper(){
        var swiperWrapper = $('.swiper-wrapper'),
        newSlides = $('.swiper-wrapper').children('.swiper-slide').clone(true);
        mySwiper.destroy();
        swiperWrapper.empty().append(newSlides);
        $('.swiper-wrapper').attr('style', '');
        mySwiper = new Swiper('.swiper-container', swiperSettings);
        mySwiper.on('slideChangeTransitionEnd   ', function () {
            setOrderDimensions();
            getShipSpec();
        });
    }    


    /**************************************************** This For Complete Order Page ****************************************************/

    /**** Check Forms Errors ****/
    function checkErrors(){
        var counter = 0;
        $.each($('div.form-data:visible input[type="text"]'),function(key,item){
            if($(item).parents('.input-parent').css('display') != 'none'){
                if(! $(item).val() ){
                    $(item).parents('.input-parent').addClass('with-error');
                    counter = counter + 1;
                }
            }
        });

        if(counter > 0){
            $('.goods-wizard-child.active i').remove();
            $('.goods-wizard-child.active span.error-counter').remove();
            var mySpan = '<span data-toggle="tooltip" data-originial-title="Bitte füllen Sie die erforderlichen Daten aus" class="pulse error-counter badge badge-danger">'+counter+'</span>';
            $('.goods-wizard-child.active').append(mySpan);
        }else{
            $('.goods-wizard-child.active i').remove();
            $('.goods-wizard-child.active span.error-counter').remove();
            var myIcon = '<i class="fa fa-check-circle"></i>';
            $('.goods-wizard-child.active').append(myIcon);
        }
        return counter;
    }

    /**** Add New Button For Other Biller ****/
    function showOtherBiller(){
        var myButton = '<div class="goods-wizard-child" data-type="third">Andere <i class="fa fa-check-circle"></i></div>';
        $('.goods-desc.goods-wizard').append(myButton);
    }

    /**** Creating DateTimePicker Options ****/
    function initDate(minDateTime){
        var option = {
            defaultDate: minDateTime,
            minDate : minDateTime,
            sideBySide: true,
            format: "MM.DD.YYYY HH:mm",
        }
        return option;
    }

    /**** Order First Information ****/
    $('.wizard-box[data-type="prevSteps"]').on('click',function(){
        weightChanged();
        window.person = $('.rate-value.label-span').html();

        for (var i = 0; i < person-1; i++) {
            $('ul.rate li.carry[data-type="'+i+'"]').addClass('hover');
        }

        setRoundSliderByValue($("#round-slider").data('type')); 
    });

    /**** Clicking Tabs ****/
    $('.wizard-box').on('click',function(){
        $(this).addClass('active');
        $(this).siblings().removeClass('active'); 

        var formClass = $(this).data('type');
        var myForm = $('form.'+formClass);
    
        myForm.siblings('form').hide();     
        myForm.fadeIn(500);  

    });

    $('div.form-data input').keyup(function(){
        checkErrors();
    });

    /**** Sender,Reciver And Other Biller Tabs ****/ 
    $(document).on('click','.goods-wizard-child',function(){
            
        var counter = checkErrors();
        
        if(counter == 0){
            $(this).addClass('active');
            $(this).siblings().removeClass('active'); 

            var formClass = $(this).data('type');
            var myDiv = $('div.'+formClass);
        
            myDiv.siblings('div.form-data').hide();     
            myDiv.fadeIn(500);  
        }

    });

    /**** Change From Person To Person ****/
    $(document).on('change','#senderisCompany,#receiverisCompany,#otherbillingCompany',function(){
        if($(this).val() == 0){
            $(this).parents('div.input-parent').next().slideUp(250);
            var parent = $(this).parents('div.input-parent').next();
            $(parent).find('div.input-child input').val('');
            $(parent).removeClass('with-error');
        }else{
            $(this).parents('div.input-parent').next().slideDown(250);
        }
        setTimeout(function(){
            checkErrors();
        } ,250);
    });

    /**** Order Information Submit ****/
    $('.prevSteps .letsComplete.btn').on('click',function(){
        toastr.success('Rayagate Engine', 'Order Information Saved Successfully');
        $('.wizard-box[data-type="curSteps"]').click(); 
    });

    /**** Complete Order ****/
    function getNumberOfErrors(element){
        var counter = 0 ;
        $.each(element,function(key,item){
            if($(item).parents('.input-parent').css('display') != 'none'){
                if(! $(item).val() ){
                    counter = counter + 1;
                }
            }
        });
        return counter;
    }

    function completeOrder(bill_to){
        var ship_id = window.ship_id;
        var cost_id = window.cost_id;
        var id = window.id;

        var data = {
            '_token': $('input[name="_token"]').val(),
            /**** Order Information  Data ****/
            'id': id,
            'ship_id': ship_id,
            'cost_id': cost_id,
            'weight': $('input#weightInput').val(),
            'items': $('input#NumberOfItems').val() ,
            'width': ! $('input.width').val() ? $('.swiper-slide.swiper-slide-active .vehicle-dimenstions p.width').html() : $('input.width').val(),
            'length': ! $('input.length').val() ? $('.swiper-slide.swiper-slide-active .vehicle-dimenstions p.length').html() : $('input.length').val(),
            'height': ! $('input.height').val() ? $('.swiper-slide.swiper-slide-active .vehicle-dimenstions p.height').html() : $('input.height').val(),
            'persons': $('.rate-value.label-span').html(),
            'load_time': $('.rs-tooltip.rs-tooltip-text').html(),
            'description': $('textarea#description').val(),
            'bill_to': bill_to,

            /**** Sender Data ****/
            'sender' : {
                'first_name' : $('#senderfirstName').val(),
                'last_name' : $('#senderlastName').val(),
                'mobile' : $('#senderphone').val(),
                'company' : $('#sendercompany').val(),
                'email' : $('#senderemail').val(),
            },

            /**** Receiver Data ****/
            'receiver':{
                'first_name' : $('#receiverfirstName').val(),
                'last_name' : $('#receiverlastName').val(),
                'mobile' : $('#receiverphone').val(),
                'company' : $('#receivercompany').val(),
                'email' : $('#receiveremail').val(),
            },

            /**** Other Biller Data ****/
            'other_biller':{
                'first_name' : $('#otherbillingfirstName').val(),
                'last_name' : $('#otherbillinglastName').val(),
                'mobile' : $('#otherbillingphone').val(),
                'company' : $('#otherbillingcompany').val(),
                'email' : $('#otherbillingemail').val(),
            },

            /**** Order Dates ****/
            'dates':{
                'load_from': $('#sendertime').val(),
                'load_to': $('#senderLoadTill').val(),
                'deliver_from': $('#receivertime').val(),
                'deliver_to': $('#receiverLoadTill').val(),
            },
        };

        var form = $('form.curSteps');
        $.each(data,function(key,value){
            if(key == 'sender' || key == 'receiver' || key == 'other_biller' || key == 'dates'){
                form.append("<input type='hidden' name='"+key+"' value='"+JSON.stringify(value)+"' >");
            }else{
                form.append('<input type="hidden" name="'+key+'" value="'+value+'" >');
            }
        });
        form.submit();
    }

    $('.curSteps .letsComplete.btn').on('click',function(){
        
        var bill_to = $('#paymentfor').val();

        var counter1 = getNumberOfErrors($('div.form-data.first input[type="text"]'));
        var counter2 = getNumberOfErrors($('div.form-data.second input[type="text"]'));
        var counter3 = getNumberOfErrors($('div.form-data.third input[type="text"]'));

        if(counter1 == 0 && counter2 > 0){
            $('.goods-wizard-child[data-type="second"]').click();
        }

        if(counter1 == 0 && counter2 == 0){
            if(bill_to != 2){
                completeOrder(bill_to);
            }else{
                if(counter3 > 0){
                    $('.goods-wizard-child[data-type="third"]').click();
                }else{
                    completeOrder(bill_to);
                }
            }
        }
        
        

    })

    /**** Change Bill To ****/
    $('#paymentfor').on('change',function(){
        if($(this).val() == 2){
            showOtherBiller();
        }else{
            $('.third').hide(); 
            $("div.good-wizard-child[data-type='third']").remove();
        }
    });


    /**** Check Box To Copy Sender Data To Receiver ****/
    $(document).on('ifChecked','input[type=checkbox]', function(event){
        
        var first_name = $('#senderfirstName').val();
        var last_name = $('#senderlastName').val();
        var mobile = $('#senderphone').val();
        var company = $('#sendercompany').val();
        var email = $('#senderemail').val();

        $('#receiverfirstName').val(first_name);
        $('#receiverlastName').val(last_name);
        $('#receiverphone').val(mobile);
        $('#receiveremail').val(email);
        

        if(company){
            $('#receiverisCompany').val(1);
            $('#receivercompany').val(company);
            $('#receiverisCompany').parents('div.input-parent').next().slideDown(250);
        }

        $('input[type=checkbox]').not(this).iCheck('check');
        $('input[type=checkbox]').not(this).iCheck('update');
    });

    $(document).on('ifUnchecked','input[type=checkbox]',function(){
        $('#receiverfirstName,#receiverlastName,#receiverphone,#receiveremail').val('');
        $('#receiverisCompany').val(0);
        $('#receiverisCompany').parents('div.input-parent').next().slideUp(250);
    });

    $("input[type=checkbox]").iCheck({
        checkboxClass: 'icheckbox_square-orange',
        radioClass: 'iradio_minimal-orange'
    }); 

    window.minutes = $('#myDetails').data('tab');
    load_time = $('.prevSteps .rs-tooltip.rs-tooltip-text').html();
    var time = parseInt(load_time) + parseInt(window.minutes);

    /**** Initializing DateTimePickers ****/
    $('#sendertime').datetimepicker(initDate(moment(new Date()).add(1, 's').toDate()));
    $('#senderLoadTill').datetimepicker(initDate(moment(new Date()).add(6, 'h').toDate()));
    $('#receivertime').datetimepicker(initDate(moment(new Date()).add(time, 'm').toDate()));
    $('#receiverLoadTill').datetimepicker(initDate(moment(new Date()).add(20, 'h').toDate()));

    window.minutes = $('#myDetails').data('tab');
    var load_time = $('.prevSteps .rs-tooltip.rs-tooltip-text').html();

    $(document).on('dp.change','input#sendertime',function(){
        var newDateObj = moment(new Date($(this).val())).add(6, 'h').toDate();
        $('#senderLoadTill').data("DateTimePicker").destroy(); 
        $('#senderLoadTill').datetimepicker(initDate(newDateObj));

        var mins = parseInt($('.prevSteps .rs-tooltip.rs-tooltip-text').html()) + parseInt(window.minutes);
        var newDateObj2 = moment(new Date($(this).val())).add(mins, 'm').toDate();
        $('#receivertime').data("DateTimePicker").destroy(); 
        $('#receivertime').datetimepicker(initDate(newDateObj2));
    });

    $(document).on('dp.change','input#receivertime',function(){
        var newDateObj = moment(new Date($(this).val())).add(6, 'h').toDate();
        $('#receiverLoadTill').data("DateTimePicker").destroy(); 
        $('#receiverLoadTill').datetimepicker(initDate(newDateObj));
    });

});