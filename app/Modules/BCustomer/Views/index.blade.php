@extends('Layouts.master')

@section('title',"BCustomer")

@section('styles')
<link rel="stylesheet" href="{{ asset('/assets/css/bcustomer.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/production/css/jquery.btnswitch.min.css') }}">
<style>
    
    .pac-container{
        top: 0;
    }
</style>
@endsection

@section('content')
    <div class="container create-order-container">
        <div class="form-map-container">
            <div class="order-form-wrapper">
                <div class="slick-tour-wrapper">
                    <div class="slick-tour-side">
                        <div class="side-tour-row">
                            <div class="tour-date-2 input-parent datetimepicker">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Start Date">
                                    <label for="tourStart">Start Date</label>
                                </span> 
                                <div class="input-child">
                                    <input type="text" class="form-control" name="TourStart" id="tourStart">
                                </div>
                            </div> 
                            <div class="tour-date-1 input-parent datetimepicker">
                                <span data-toggle="tooltip" class="label-span last-span" data-original-title="Start Time (Every Day)">
                                    <label for="tourStartTime">Start Time (Every Day)</label>
                                </span> 
                                <div class="input-child">
                                    <input type="text" class="form-control" id="tourStartTime">
                                </div>
                            </div>
                        </div> 
                        <div class="side-tour-row">
                            <div data-toggle="tooltip"class="side-tour-span" data-original-title="Week Days">Week Days</div> 
                            <div class="week-days">
                                <div data-toggle="tooltip" class="day active" data-original-title="Monday">Mo</div>
                                <div data-toggle="tooltip" class="day" data-original-title="Tuesday">Di</div>
                                <div data-toggle="tooltip" class="day" data-original-title="Wednesday">Mi</div>
                                <div data-toggle="tooltip" class="day" data-original-title="Thursday">Do</div>
                                <div data-toggle="tooltip" class="day" data-original-title="Friday">Fr</div>
                            </div> 
                            <div class="week-days">
                                <div data-toggle="tooltip" class="day" data-original-title="Saturday">Sa</div>
                                <div data-toggle="tooltip" class="day" data-original-title="Sunday">So</div>
                            </div>
                        </div>
                    </div>
                    <div class="tour-slick">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="{{ asset('/assets/images/stops/stop1.png') }}" alt=""></div>
                                <div class="swiper-slide"><img src="{{ asset('/assets/images/stops/stop2.png') }}" alt=""></div>
                            </div>
                        </div>   
                    </div>
                </div>

                <div class="tour-type-row">
                    <div id="tourtypestops" class="tourtype active" style="margin-bottom: 10px;">
                        <span>S Tour</span>
                    </div>
                    <div id="tourtypetime" class="tourtype" style="margin-bottom: 10px;">
                        <span>T Tour</span>
                    </div>
                    <div id="tourtypedates" class="tourtype" style="margin-bottom: 10px;">
                        <span>D Tour</span>
                    </div>
                    <div id="tourtypepackets" class="tourtype" style="margin-bottom: 10px;">
                        <span>P Tour</span>
                    </div>
                </div>

                <div class="stops-wrapper">
                    <div class="stop-tour-wrapper-left">
                        <div class="stops-inputs-head fieldset">
                            <div class="legend">Tour Information</div> 
                            <div class="head-main-header"></div> 
                            <div class="stops-inputs-head-main">
                                <div class="input-parent">
                                    <span data-toggle="tooltip" class="label-span" data-original-title="the number of stops in which the car would stop">
                                        <label for="TournumberOfStops">Stop Number * </label>
                                    </span> 
                                    <div class="input-child">
                                        <input placeholder="Stop Number" id="TournumberOfStops" type="text" value="2">
                                        <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Plus" class="kurier-arrow up"> 
                                        <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Minus" class="kurier-arrow down">
                                    </div>
                                </div>
                                <div class="input-parent">
                                    <span data-toggle="tooltip" class="label-span" data-original-title="Total Weight">
                                        <label for="Gesamtgewicht">Total Weight * </label>
                                    </span> 
                                    <div class="input-child">
                                        <input placeholder="Gesamtgewicht" id="weight" type="text" value="0">
                                        <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Plus" class="kurier-arrow up"> 
                                        <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Minus" class="kurier-arrow down">
                                    </div>
                                </div>
                                <div class="input-parent">
                                    <span data-toggle="tooltip" class="label-span" data-original-title="The average time the driver would stop at each stop.">
                                        <label for="tour_average_stop_time">Stop Time * </label>
                                    </span> 
                                    <div class="input-child">
                                        <input placeholder="Stop Time" id="tour_average_stop_time" type="text" value="3">
                                        <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Plus" class="kurier-arrow up"> 
                                        <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Minus" class="kurier-arrow down">
                                    </div>
                                </div>
                                <div class="input-parent">
                                    <span data-toggle="tooltip" class="label-span" data-original-title="Number Of Packets">
                                        <label for="tour_total_packets_number">Number Of Packets * </label>
                                    </span> 
                                    <div class="input-child">
                                        <input placeholder="Number Of Packets" id="tour_total_packets_number" type="text" value="1">
                                        <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Plus" class="kurier-arrow up"> 
                                        <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Minus" class="kurier-arrow down">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="stop-tour-wrapper-right"></div>
                    
                    <div class="stops-rows-wrapper">
                        <div class="stops-rows-header">
                            <div class="checkbox-component">
                                <div id="demo"></div>
                                <label for="checkbox-id-27">
                                    <span class="input-box"></span> 
                                    Do the stops change daily ?
                                </label>
                            </div>
                        </div> 
                        <div class="stops-rows-container">
                            <div class="stops-inputs-head fieldset list-enter-to">
                                <div class="legend">Stop 1</div> 
                                <div class="stop-inputs-setting">
                                    <div class="add-new-package">
                                        <button class="btn btn-danger btn-xs">
                                            <img src="{{ asset('/assets/images/rubbish-bin-delete-button.svg') }}" alt="Clear"> 
                                            <span>Clear</span>
                                        </button>
                                    </div>
                                </div> 
                                <div class="stops-inputs-head-main">
                                    <div class="input-parent location">
                                        <span class="label-span">
                                            <label for="stopLocation0">Stop Address</label>
                                        </span> 
                                        <div class="input-child">
                                            <input type="text" class="address" placeholder="Straße Hausnummer, Postleitzahl Stadt" id="stopLocation0" autofocus="autofocus" autocomplete="off">
                                        </div>
                                    </div> 
                                    <div class="input-parent">
                                        <span data-toggle="tooltip" class="label-span" data-original-title="Stop Name">
                                            <label for="stopName0">Stop Name * </label>
                                        </span> 
                                        <div class="input-child">
                                            <input placeholder="Stop Name" name="stopStop Name0" id="stopName0" type="text" value="Stop 1">
                                        </div>
                                    </div> 
                                    <div class="stopTime input-parent">
                                        <span data-toggle="tooltip" class="label-span" data-original-title="Stoptime (min)">
                                            <label for="StopsTime0">Stop Time (min)  * </label>
                                        </span> 
                                        <div class="input-child">
                                            <input placeholder="Stop Time (min)" id="StopsTime0" type="text" value="3">
                                            <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Plus" class="kurier-arrow up"> 
                                            <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Minus" class="kurier-arrow down">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="stops-inputs-head fieldset list-enter-to">
                                <div class="legend">Stop 2</div> 
                                <div class="stop-inputs-setting">
                                    <div class="add-new-package">
                                        <button class="btn btn-danger btn-xs">
                                            <img src="{{ asset('/assets/images/rubbish-bin-delete-button.svg') }}" alt="Clear"> 
                                            <span>Clear</span>
                                        </button>
                                    </div>
                                </div> 
                                <div class="stops-inputs-head-main">
                                    <div class="input-parent location">
                                        <span class="label-span">
                                            <label for="stopLocation1">Stop Address</label>
                                        </span> 
                                        <div class="input-child">
                                            <input type="text" class="address" placeholder="Straße Hausnummer, Postleitzahl Stadt" id="stopLocation1" autofocus="autofocus" autocomplete="off">
                                        </div>
                                    </div> 
                                    <div class="input-parent">
                                        <span data-toggle="tooltip" class="label-span" data-original-title="Stop Name">
                                            <label for="stopName1">Stop Name * </label>
                                        </span> 
                                        <div class="input-child">
                                            <input placeholder="Stop Name" id="stopName1" type="text" value="Stop 2">
                                        </div>
                                    </div> 
                                    <div class="stopTime input-parent">
                                        <span data-toggle="tooltip" class="label-span" data-original-title="Stoptime (min)">
                                            <label for="StopsTime1">Stop Time (min) * </label>
                                        </span> 
                                        <div class="input-child">
                                            <input placeholder="Stop Time (min)" id="StopsTime1" type="text" value="3">
                                            <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Plus" class="kurier-arrow up">
                                            <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Minus" class="kurier-arrow down">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="add-new-package" style="width: 100%;">
                            <button class="btn btn-success btn-xs">
                                <img src="{{ asset('/assets/images/add-new.svg') }}" alt="add new"> 
                                <span>Add Stop</span>
                            </button>
                        </div>
                    </div>
                    <div class="add-new-package" style="width: 100%; display: flex; justify-content: flex-end;">
                        <button class="btn btn-success btn-xs">
                            <img src="{{ asset('/assets/images/arrow-pointing-to-right.svg') }}" alt="Next"> 
                            <span>Next</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="order-info-form">     
                <div class="map-element fixed">
                    <div class="map-container">
                        <div id="googlemaps"></div>  
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD46q9wP9oq5fbgpWgldsLpDtHvfUxn_zU&libraries=places&language=de-DE"
  type="text/javascript"></script>
<script src="{{ asset('/assets/production/js/jquery.btnswitch.min.js') }}"></script>
<script src="{{ asset('assets/components/bcustomer.js') }}"></script>
@endsection