@extends('Layouts.master')

@section('title',ucfirst($order->code))

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/order.css') }}">
@endsection

@section('content')
    <div class="container create-order-container">
        <div class="order-data">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="order-data-box">
                        <img src="{{ asset('/assets/images/distance.svg') }}" alt="icons"> 
                        <div class="order-data-info">
                            <div class="order-info-head">Entfernung.</div> 
                            <div class="order-info-value distance">{{ $order->distance }} km</div>
                        </div>
                    </div> 
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="order-data-box">
                        <img src="{{ asset('/assets/images/stopwatch.svg') }}" alt="icons"> 
                        <div class="order-data-info">
                            <div class="order-info-head">Dauer.</div> 
                            <div class="order-info-value duration">
                                @if($order->duration[0] == 0)
                                    {{ $order->duration[1] }} Minuten
                                @else
                                    {{ $order->duration[0] }} Stunden ,{{ $order->duration[1] }} Minuten
                                @endif
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="order-data-box">
                        <img src="{{ asset('/assets/images/euro.svg') }}" alt="icons"> 
                        <div class="order-data-info">
                            <div class="order-info-head">Kosten.</div> 
                            <div class="order-info-value"><span class="cost">{{ $order->cost }}</span> €</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-map-container">
            <div class="order-form-wrapper">
                <form action="{{ \URL::current().'/storeOrderDetails' }}" class="shown" method="POST">
                    @csrf
                    <div class="goods-desc">
                        <div class="half-width odd input-parent focused">
                            <span data-toggle="tooltip" class="label-span" data-original-title="GESAMTGEWICHT (KG)**">
                                <label for="weightInput">GESAMTGEWICHT (KG)**</label>
                            </span> 
                            <div class="input-child">
                                <input autofocus="autofocus" placeholder="GESAMTGEWICHT (KG)**"  id="weightInput" type="text" aria-required="true" aria-invalid="false">
                                <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Plus" class="kurier-arrow up"> 
                                <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Minus" class="kurier-arrow down">
                            </div> 
                        </div>
                        <div class="half-width even input-parent">
                            <span data-toggle="tooltip" class="label-span" data-original-title="ANZAHL DER ARTIKEL *">
                                <label for="NumberOfItems">ANZAHL DER ARTIKEL *</label>
                            </span> 
                            <div class="input-child">
                                <input placeholder="ANZAHL DER ARTIKEL *" id="NumberOfItems" type="text" aria-required="true" aria-invalid="false" value="1"> 
                                <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Plus" class="kurier-arrow up"> 
                                <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Minus" class="kurier-arrow down">
                            </div> 
                        </div>
                        <div class="input-parent-triple">
                            <span>Gesamtmasse (CM) *</span> 
                            <div class="inputs-wrapper">
                                <div class="small-input">
                                    <input type="text" placeholder="Breite" class="width" data-type="width">
                                </div>
                                <div class="small-input">
                                    <input type="text" placeholder="Länge" class="length" data-type="length">
                                </div>
                                <div class="small-input">
                                    <input type="text" placeholder="Höhe" class="height" data-type="height">
                                </div>
                            </div>
                        </div>
                        <div class="half-width odd input-parent">
                            <span class="label-span has-max-height">
                                <label for="orderPersons">Aushilfsfahrer</label>
                            </span> 
                            <div class="rating-input-child">
                               <ul class="rate" data-toggle="tooltip" data-original-title="Der Transportfahrer ist kein Umzugshilfe, nun kann er bis zu 5 Minuten mithelfen">
                                   <li class="main">
                                       <img src="{{ asset('/assets/images/driver-icon.svg') }}" alt="icons">
                                   </li>
                                   <li class="carry">
                                       <img src="{{ asset('/assets/images/carrier.svg') }}" alt="icons">                                   
                                   </li>
                                   <li class="carry">
                                       <img src="{{ asset('/assets/images/carrier.svg') }}" alt="icons">                            
                                   </li>
                                   <li class="carry">
                                       <img src="{{ asset('/assets/images/carrier.svg') }}" alt="icons">
                                   </li>
                               </ul>
                               <span class="rate-value label-span">1</span>
                               <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="half-width even input-parent">
                            <span class="label-span has-max-height">
                                <label for="orderPersons">Zeit (Min)</label>
                            </span> 
                            <div class="rounds" value="{{ \App\Models\Variables::getVar('ORDER_MIN_LOAD_TIME') }}">
                                <div id="round-slider"></div>
                            </div>
                        </div>
                        <div class="input-parent">
                            <span data-toggle="tooltip" class="label-span" data-original-title="SENDUNGSBESCHREIBUNG / BESONDERHEITEN">
                                <label data-v-85189bfe="" for="description">SENDUNGSBESCHREIBUNG / BESONDERHEITEN</label>
                            </span> 
                            <div class="input-child">
                                <textarea name="description" id="description" cols="30" rows="10" aria-required="true" aria-invalid="false"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="order-pricing">

                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($allShips as $shipKey => $shipValue)
                                <div class="swiper-slide">
                                    <div class="vehicle-slider">
                                        <div class="vehicle-cost">
                                            <div class="cost-field">
                                                <span>{{ $shipValue->cost }} €</span> 
                                            </div>
                                        </div> 
                                        <div class="vehicle-image">
                                            <div class="vehicle-images-wrapper">
                                                <li class="is-checked checkbox check">
                                                    <i class="fa fa-check"></i>
                                                </li> 
                                                <img src="{{ $shipValue->ship->image }}" alt="">
                                            </div>
                                        </div> 
                                        <div class="vehicle-name">{{ $shipValue->ship->title }}</div> 
                                        <div class="vehicle-dimenstions">
                                            <span><b>Width:</b>{{ $shipValue->ship->width / 10 }}</span> 
                                            <span><b>Length:</b>{{ $shipValue->ship->length / 10 }}</span> 
                                            <span><b>Height:</b>{{ $shipValue->ship->height / 10 }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                        
                        <div class="small-order-cell completeIt">
                            <button role="button" class="letsComplete btn" style="min-height: 40px;">Einsenden <img src="{{ asset('/assets/images/loading.svg') }}"></button>
                        </div>
                    </div>        
                </form>
            </div>
            <div class="order-info-form">
                <div class="show-map">
                    <img src="{{ asset('/assets/images/map.svg') }}" alt="Show Map.">
                </div>
                <div class="from-to-info">
                    <div class="from-info-box">
                        <img src="{{ asset('/assets/images/map-marker.svg') }}" alt="icons">
                        <div class="from-info-box-data from">
                            {!! \Helper::displayAddress($source) !!}
                        </div> 
                        <div class="show-map md">
                            <img src="{{ asset('/assets/images/edit.svg') }}" alt="Edit">
                        </div>
                    </div> 
                    <div class="from-info-box">
                        <img src="{{ asset('/assets/images/slating-flag.svg') }}" alt="icons">
                        <div class="from-info-box-data to">
                            {!! \Helper::displayAddress($destination) !!}
                        </div> 
                    </div> 
                </div>
                <div class="map-element">
                    <div class="map-container">
                        <div class="more-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="from-info-box">
                                        <img src="{{ asset('/assets/images/map-marker.svg') }}" alt="icons">
                                        <input type="text" placeholder="Straße Hausnummer, Postleitzahl Stadt" id="OrderfromGeoAddress" data-latlng="{{ $sourceLatLng }}" autocomplete="off"> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="from-info-box">
                                        <img src="{{ asset('/assets/images/slating-flag.svg') }}" alt="icons">
                                        <input type="text" placeholder="Straße Hausnummer, Postleitzahl Stadt" id="OrdertoGeoAddress" data-latlng="{{ $destinationLatLng }}" autocomplete="off">
                                    </div>
                                </div>
                                <input type="hidden" id="myDetails" data-id="{{ $order->code }}">
                            </div>
                        </div>
                        <div id="googlemaps"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKbJsGIea4zN3LbwdZ7o1eDt2BttMnTCc&libraries=places&language=en-EN"
  type="text/javascript"></script>
<script src="{{ asset('assets/components/order.js') }}"></script>
@endsection