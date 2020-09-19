@extends('Layouts.master')

@section('title','Home')

@section('styles')

@endsection

@section('content')
    <div class="main-page-div">
        <div class="main-page-overlay">

            <form action="{{ URL::to('/orders/create_new') }}" method="post" class="main-page-form">
                @csrf
                <div class="form-head">
                    <h1>{{trans('frontend/main.make')}}</h1>
                    <!--text slider-->
                    <div class="text-slider slick-slider">
                        <div>{{trans('frontend/main.p1')}}</div>
                        <div>{{trans('frontend/main.p2')}}</div>
                        <div>{{trans('frontend/main.p3')}}</div>
                        <div>{{trans('frontend/main.p4')}}</div>
                    </div>
                    <!--text slider-->
                </div>
                <div class="form-container">
                    <div class="main-form-input">
                        <div class="main-form-span">
                            <span class="icon">
                                <i class="fa fa-home"></i>
                            </span>
                            <label for="FromGeoAddress">Address</label>
                        </div>
                        <input type="text" placeholder="Straße Hausnummer, Postleitzahl Stadt" id="fromGeoAddress" autofocus="autofocus" style="padding-right: 61.5px;" autocomplete="off">
                        <div class="icons-wrapper">
                            <span data-placement="left" data-toggle="tooltip" title="">
                                <i class="fa fa-search"></i>
                            </span> 
                            <span data-placement="left" data-toggle="tooltip" title="Verwenden Sie Ihren aktuellen Standort">
                                <i class="fa fa-map-marker"></i>
                            </span>
                        </div>
                    </div> 
                    <input type="hidden" id="from" name="from" value="">
                    <input type="hidden" id="to" name="to" value="">
                    <input type="hidden" id="myDetails" name="details" value="">
                    <div class="main-form-input">
                        <div class="main-form-span">
                            <span class="icon">
                                <i class="fa fa-location-arrow"></i>
                            </span>
                            <label for="FromGeoAddress">Target</label>
                        </div>
                        <input type="text" placeholder="Straße Hausnummer, Postleitzahl Stadt" id="toGeoAddress" autofocus="autofocus" style="padding-right: 61.5px;" autocomplete="off">
                        <div class="icons-wrapper">
                            <span>
                                <i class="fa fa-search"></i>
                            </span> 
                        </div>
                    </div> 
                </div>
            </form>
            
            <div class="orders-small-wrapper">
                <div class="swiper-container">
                    <div class="swiper-wrapper">

                        @if(count($myOrders) > 0)
                        <!-- My Uncompleted Orders -->
                        @foreach($myOrders as $myOrderKey => $myOrderValue)
                        <div class="swiper-slide">
                            <div class="small-order">
                                <img src="{{ asset('/assets/images/delete-order.svg') }}" data-toggle="tooltip" title="löschen" alt="löschen" class="deleteImage" data-id="{{ $myOrderValue->id }}"> 
                                <img src="{{ asset('/assets/images/full-size.svg') }}" data-toggle="tooltip" style="right: 30px;" title="Bestellung anzeigen" alt="Bestellung anzeigen" class="fullSize"> 
                                <div class="small-order-cell order-from">
                                    <span class="pull-left">
                                        <i class="fa fa-home"></i>
                                    </span>
                                    <span class="pull-left small-order-cell-adress">
                                        <span> {{ $myOrderValue->from }} </span>
                                    </span>
                                    <div class="clearfix"></div>
                                </div> 
                                <div class="small-order-cell order-to">
                                    <span class="pull-left">
                                        <i class="fa fa-location-arrow"></i>
                                    </span>
                                    <span class="pull-left small-order-cell-adress">
                                        <span> {{ $myOrderValue->to }}</span>
                                    </span>
                                    <div class="clearfix"></div>
                                </div> 
                                <div class="small-order-cell completeIt">
                                    <a class="letsComplete btn" href="{{ URL::to('/orders/create_new/'.$myOrderValue->code) }}">Bestellung abschließen.</a>
                                </div> 
                                <img src="{{ asset('/assets/images/warning.svg') }}" alt="warning" class="warning-order">
                            </div>   
                        </div>
                        @endforeach
                        <!-- My Uncompleted Orders -->
                        @else
                        <!-- Advertising Orders -->
                        @foreach($adverOrders as $adverOrderKey => $adverOrderValue)
                        <div class="swiper-slide">
                            <div class="small-order">
                                <div class="advertise-order">
                                    <div class="advertise-row">
                                        <div class="advertise-address">
                                            <div class="small-order-cell order-from">
                                                <span class="pull-left">
                                                    <i class="fa fa-home"></i>
                                                </span>
                                                <span class="pull-left small-order-cell-adress">
                                                    {{ $adverOrderValue->from }}
                                                </span>
                                                <div class="clearfix"></div>
                                            </div> 
                                            <div class="small-order-cell order-to">
                                                <span class="pull-left">
                                                    <i class="fa fa-location-arrow"></i>
                                                </span>
                                                <span class="pull-left small-order-cell-adress">
                                                    {{ $adverOrderValue->to }}
                                                </span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div> 
                                        <div class="advertise-pricing">
                                            <img src="{{ URL::to('/orders/images/icon?price='.$adverOrderValue->price.'&distance='.$adverOrderValue->distance) }}" alt="">
                                        </div>
                                    </div> 
                                    <div class="advertise-row">
                                        <div class="advertise-address shipping">
                                            <img src="{{ $adverOrderValue->ship->image }}" alt="{{ $adverOrderValue->ship->title }}"> 
                                            <span style="width: 100%;">{{ $adverOrderValue->ship->title }}</span>
                                        </div> 
                                        <div class="advertise-pricing"></div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        @endforeach
                        <!-- Advertising Orders -->
                        
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div id="googlemaps" class="main-page-maps"></div>
    </div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKbJsGIea4zN3LbwdZ7o1eDt2BttMnTCc&libraries=places&language=en-EN"
  type="text/javascript"></script>
<script src="{{ asset('assets/components/home.js') }}"></script>
@endsection