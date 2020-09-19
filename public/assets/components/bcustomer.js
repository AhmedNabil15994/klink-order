$(function(){
    var map = new google.maps.Map(document.getElementById('googlemaps'), {
        center:new google.maps.LatLng(51.165691, 10.451526),
        zoom:6, 
        mapTypeControl: false,
        streetViewControl: false,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    });
    /**** Initialize Address AutoComplete ****/
    function initialize(input) {

        var autocomplete = new google.maps.places.Autocomplete(input);
        
        autocomplete.addListener('place_changed', function() {
            place = autocomplete.getPlace();
            if (!place.geometry) {
                setTimeout(function () {
                    toastr.error('Rayagate Engine', "No details available for : '" + place.name + "'" );
                }, 1000);
                return;
            }
            var latlng = {
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            }
        });
        
    }

    initialize(document.getElementById('stopLocation0'));


    
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

    $('div.day').on('click',function(){
        $(this).toggleClass('active'); 
    });

    var date =  moment(new Date());
    var time = moment(new Date()).format("hh:mm");


    $('#tourStart').datetimepicker({
        defaultDate:date,
        minDate : date,
        format: "MM.DD.YYYY",
    });

    $('#tourStartTime').val('08:00');

    $('#tourStartTime').datetimepicker({
        format: "HH:mm",
    });

    var swiperSettings = {
        slidesPerView: 'auto',
        loop: true,
        loopFillGroupWithBlank: true,
        
    }
    var mySwiper = new Swiper('.swiper-container', swiperSettings);

    $(document).on('click','.tour-type-row .tourtype',function(){
        $(this).siblings('.active').removeClass('active');
        $(this).addClass('active');
    });

    function removeActive(){
        $('#tourOthertime').remove();
        $('#tourOtherdates').remove();
        $('.tourtype.with-other-type').removeClass('with-other-type');
    }

    $(document).on('click','#tourtypetime ',function(){
        removeActive();
        $('.tour-type-row').addClass('height-160');
        $(this).addClass('with-other-type');
        $(this).append('<div id="tourOthertime" class="tour-type-child"><div class="tourtype active"><span>Pro Minuten berechnet</span></div><div class="tourtype"><span>Pro Stunden berechnet</span></div></div>');
    });

    $(document).on('click','#tourtypedates ',function(){
        removeActive();
        $('.tour-type-row').addClass('height-160');
        $(this).addClass('with-other-type');
        $(this).append('<div id="tourOtherdates" class="tour-type-child"><div class="tourtype active"><span>Pro Tag berechnet </span></div><div class="tourtype"><span>Pro Woche berechnet </span></div><div class="tourtype"><span>Pro Monat berechnet </span></div></div>');
    });

    $(document).on('click','#tourOthertime,#tourOtherdates',function(e){
        e.preventDefault();
        e.stopPropagation(); 
    });

    $(document).on('click','#tourtypestops,#tourtypepackets',function(){
        removeActive();
        $('.tourtype.with-other-type').removeClass('with-other-type');
    });

    $(document).on('scroll',function(){
        var value = $(window).scrollTop();
        if( value <= $('.container.create-order-container').height() - 500){
            $('.map-element.fixed').css('marginTop',value); 
        }
    });

    function dailyStops(){
        $('.stop-tour-wrapper-left .stops-inputs-head.fieldset:nth-child(2)').remove();
        var bigComponent = '<div class="stops-inputs-head fieldset list-enter-to">'+
                                '<div class="legend">Stop 2</div>'+ 
                                '<div class="stop-inputs-setting">'+
                                    '<div class="add-new-package">'+
                                        '<button class="btn btn-danger btn-xs">'+
                                            '<img src="/assets/images/rubbish-bin-delete-button.svg" alt="Clear">'+ 
                                            '<span>Clear</span>'+
                                        '</button>'+
                                    '</div>'+
                                '</div>' +
                                '<div class="stops-inputs-head-main">'+
                                    '<div class="input-parent location">'+
                                        '<span class="label-span">'+
                                            '<label for="stopLocation1">Stop Address</label>'+
                                        '</span>' +
                                        '<div class="input-child">'+
                                            '<input type="text" placeholder="Straße Hausnummer, Postleitzahl Stadt" class="address" id="stopLocation1" autofocus="autofocus" autocomplete="off">'+
                                        '</div>'+
                                    '</div>' +
                                    '<div class="input-parent">'+
                                        '<span data-toggle="tooltip" class="label-span" data-original-title="Stop Name">'+
                                            '<label for="stopName1">Stop Name * </label>'+
                                        '</span>'+
                                        '<div class="input-child">'+
                                            '<input placeholder="Stop Name" id="stopName1" type="text" value="Stop 2">'+
                                        '</div>'+
                                    '</div> '+
                                    '<div class="stopTime input-parent">'+
                                        '<span data-toggle="tooltip" class="label-span" data-original-title="Stoptime (min)">'+
                                            '<label for="StopsTime1">Stop Time (min) * </label>'+
                                        '</span> '+
                                        '<div class="input-child">'+
                                            '<input placeholder="Stop Time (min)" id="StopsTime1" type="text" value="3">'+
                                            '<img src="/assets/images/chevron-arrow-up.svg" alt="Plus" class="kurier-arrow up">'+
                                            '<img src="/assets/images/chevron-arrow-up.svg" alt="Minus" class="kurier-arrow down">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
        $('.stops-rows-container').append(bigComponent);
    }

    function notDailyStops(){
        $('.stop-tour-wrapper-left .stops-inputs-head.fieldset:nth-child(2)').remove();
        var smallComponent = '<div class="stops-inputs-head fieldset">'+
                                '<div class="legend">Distances</div>'+ 
                                '<div class="head-main-header"></div>'+
                                '<div class="stops-inputs-head-main">'+
                                    '<div class="input-parent">'+
                                        '<span data-toggle="tooltip" class="label-span" data-original-title="The Expected Total Time OF Tour">'+
                                            '<label for="Gesamtzeit">Total Time * </label>'+
                                        '</span>'+
                                        '<div class="input-child">'+
                                            '<input placeholder="Total Time" id="total_time" type="text">'+
                                            '<img src="/assets/images/chevron-arrow-up.svg" alt="Plus" class="kurier-arrow up">'+ 
                                            '<img src="/assets/images/chevron-arrow-up.svg" alt="Minus" class="kurier-arrow down">'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="input-parent">'+
                                        '<span data-toggle="tooltip" class="label-span" data-original-title="Total Kilometers driven.">'+
                                            '<label for="Distance">Distance * </label>'+
                                        '</span>'+
                                        '<div class="input-child">'+
                                            '<input placeholder="Distance" id="distance" type="text">'+
                                            '<img src="/assets/images/chevron-arrow-up.svg" alt="Plus" class="kurier-arrow up"> '+
                                            '<img src="/assets/images/chevron-arrow-up.svg" alt="Minus" class="kurier-arrow down">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
        $('.stop-tour-wrapper-left').append(smallComponent);
    
        $('.stops-rows-container .stops-inputs-head.fieldset:nth-child(2)').remove();
    }

    $('#demo').btnSwitch({
        Theme: 'iOS',
        OnValue: false,
        OnCallback: function(){
            dailyStops();
        },
        OffCallback: function(){
            notDailyStops();
        },
    });




});