$(function(){
    var map = new google.maps.Map(document.getElementById('googlemaps'), {
        center:new google.maps.LatLng(51.165691, 10.451526),
        zoom:6, 
        mapTypeId:google.maps.MapTypeId.ROADMAP
    });
    /**** Initialize Address AutoComplete ****/
    function initialize(input,result) {

        var autocomplete = new google.maps.places.Autocomplete(input);
        
        autocomplete.addListener('place_changed', function() {
            place = autocomplete.getPlace();
            var icon = input.previousElementSibling.firstChild.nextSibling;

            if (!place.geometry) {
                setTimeout(function () {
                    icon.innerHTML = '';
                    icon.innerHTML = '<i class="fa fa-times-circle alert-danger"></i>';
                    toastr.error('Rayagate Engine', "No details available for : '" + place.name + "'" );
                }, 1000);
                return;
            }
            var latlng = {
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            }
            geocodeLatLng(latlng,icon,place,result);
        });
        
    }

    var latlngs = [];
    /**** Geocoding Address By Input ****/
    function geocodeLatLng(latlng,icon,place = null,result){
        var type = '';
        if(result == document.getElementById('from')){
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
                if(place == null){
                    place = results[0];
                    document.getElementById('fromGeoAddress').value = place.formatted_address;
                }
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
                            city = this.short_name;
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
                result.value = JSON.stringify(placeObj);
                if(street_number == ''){
                    setTimeout(function () {
                        icon.innerHTML = '';
                        icon.innerHTML = '<i class="fa fa-info-circle alert-warning"></i>';
                        toastr.warning('Rayagate Engine', "Invalid Street Number" );
                    }, 1000);
                }else{
                    icon.innerHTML = '';
                    icon.innerHTML = '<i class="fa fa-check-circle alert-success"></i>';
                }              

                if(type == 'to'){
                   getDetails(latlngs[0], latlngs[1]);
                }
            }else {
                setTimeout(function () {
                    icon.innerHTML = '';
                    icon.innerHTML = '<i class="fa fa-times-circle alert-danger"></i>';
                    toastr.warning('Rayagate Engine', 'Geocode was not successful for the following reason: ' + status);
                }, 1000);
            }
        });
    }

    /**** Marker Get Location ****/
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
            setTimeout(function () {
                toastr.error('Rayagate Engine', "Geolocation is not supported by this browser." );
            }, 1000);
        }
    }
        
    function showPosition(position) {
        var latlng = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        }
        geocodeLatLng(latlng,document.getElementById("fromGeoAddress").previousElementSibling.firstChild.nextSibling,null,document.getElementById("from"));
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
                document.getElementById('myDetails').value = JSON.stringify(myDetails);
                setTimeout(function(){
                    $('form.main-page-form').submit();
                },2000);
            } 
        });  
    }

    /**** Text Sluder ****/
    $('.text-slider').slick({
        arrows: false,
        autoplay: true
    });

    /**** Marker Click ****/
    $('i.fa-map-marker').on('click',function(){
        getLocation();
    });


    /**** Tooltip ****/
    $('[data-toggle="tooltip"]').tooltip();

    /**** Initialize Swiper ****/
    var swiper = new Swiper('.swiper-container', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        loop: true,
        loopFillGroupWithBlank: true,
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows : true,
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        
    });

    /**** Go To Draft Order ****/
    $('img.fullSize').on('click',function(){
        window.location.href = $(this).siblings('.completeIt').children('.letsComplete.btn').attr('href');
    });

    /**** Delete Draft Order ****/
    $('img.deleteImage').on('click',function(){
        var id = $(this).data('id');
        $.ajax({
            url: "/orders/delete_new/id".replace('id',id),
            type: 'POST',
            data: {
                '_token': $('input[name="_token"]').val(),
                'id': id,
            },
            success: function (data) {
                if(data == 1){
                    setTimeout(function () {
                        toastr.success('Rayagate Engine', 'Draft Order Deleted Successfully');
                    }, 1000);
                    location.reload();
                }else{
                    setTimeout(function () {
                        toastr.error('Rayagate Engine', 'Error Deleting Draft Order');
                    }, 1000);
                }
            },
        });
    });


    /**** Calling Main Functions ****/
    initialize(document.getElementById('fromGeoAddress'),document.getElementById('from'));
    initialize(document.getElementById('toGeoAddress'),document.getElementById('to'));



});