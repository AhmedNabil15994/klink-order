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
                <div class="wizard-wrapper">
                    <div class="wizard-box" data-type="prevSteps">
                        <div class="wizard-image">
                            <img src="{{ asset('/assets/images/pickup.svg') }}">
                        </div> 
                        <span>Bestellinformationen</span>
                    </div> 
                    <div class="wizard-box active" data-type="curSteps">
                        <div class="wizard-image">
                            <img src="{{ asset('/assets/images/customer-service.svg') }}">
                        </div> 
                        <span>Kontaktinformation</span>
                    </div>
                </div>
                
                <form action="#" class="prevSteps" style="display: none" method="POST">
                    @csrf
                    <div class="goods-desc">
                        <div class="half-width odd input-parent focused">
                            <span data-toggle="tooltip" class="label-span" data-original-title="GESAMTGEWICHT (KG)**">
                                <label for="weightInput">GESAMTGEWICHT (KG)**</label>
                            </span> 
                            <div class="input-child">
                                <input autofocus="autofocus" placeholder="GESAMTGEWICHT (KG)**"  id="weightInput" type="text" value="{{ $order->weight }}">
                                <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Plus" class="kurier-arrow up"> 
                                <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Minus" class="kurier-arrow down">
                            </div> 
                        </div>
                        <div class="half-width even input-parent">
                            <span data-toggle="tooltip" class="label-span" data-original-title="ANZAHL DER ARTIKEL *">
                                <label for="NumberOfItems">ANZAHL DER ARTIKEL *</label>
                            </span> 
                            <div class="input-child">
                                <input placeholder="ANZAHL DER ARTIKEL *" id="NumberOfItems" type="text" value="{{ $order->items }}"> 
                                <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Plus" class="kurier-arrow up"> 
                                <img src="{{ asset('/assets/images/chevron-arrow-up.svg') }}" alt="Minus" class="kurier-arrow down">
                            </div> 
                        </div>
                        <div class="input-parent-triple">
                            <span>Gesamtmasse (CM) *</span> 
                            <div class="inputs-wrapper">
                                <div class="small-input">
                                    <input type="text" placeholder="Breite" class="width" data-type="width" value="{{ $order->width }}">
                                </div>
                                <div class="small-input">
                                    <input type="text" placeholder="Länge" class="length" data-type="length" value="{{ $order->length }}">
                                </div>
                                <div class="small-input">
                                    <input type="text" placeholder="Höhe" class="height" data-type="height" value="{{ $order->height }}">
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
                                   <li class="carry first" data-type="0">
                                       <img src="{{ asset('/assets/images/carrier.svg') }}" alt="icons">                                   
                                   </li>
                                   <li class="carry second" data-type="1">
                                       <img src="{{ asset('/assets/images/carrier.svg') }}" alt="icons">                            
                                   </li>
                                   <li class="carry third" data-type="2">
                                       <img src="{{ asset('/assets/images/carrier.svg') }}" alt="icons">
                                   </li>
                               </ul>
                               <span class="rate-value label-span">{{ $order->person }}</span>
                               <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="half-width even input-parent">
                            <span class="label-span has-max-height">
                                <label for="orderPersons">Zeit (Min)</label>
                            </span> 
                            <div class="rounds">
                                <div id="round-slider" data-type="{{ $order->load_time }}"></div>
                            </div>
                        </div>
                        <div class="input-parent">
                            <span data-toggle="tooltip" class="label-span" data-original-title="SENDUNGSBESCHREIBUNG / BESONDERHEITEN">
                                <label data-v-85189bfe="" for="description">SENDUNGSBESCHREIBUNG / BESONDERHEITEN</label>
                            </span> 
                            <div class="input-child">
                                <textarea name="description" id="description" cols="30" rows="10">{{ $order->description }}</textarea>
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

                <form action="{{ \URL::current() }}" class="curSteps" method="POST">
                    <div class="goods-desc goods-wizard">
                        <div class="goods-wizard-child active" data-type="first">
                            Absender <i class="fa fa-check-circle"></i>
                        </div> 
                        <div class="goods-wizard-child" data-type="second">
                            Empfänger <i class="fa fa-check-circle"></i>
                        </div>
                    </div>

                    <div class="first form-data">
                        <div class="goods-desc">
                            <h3 class="goods-descripe-head">Absender</h3> 
                            <div class="half-width odd input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Vorname">
                                    <label for="senderfirstName">Vorname * </label>
                                </span> 
                                @php 
                                $sender = json_decode(old('sender'));
                                $receiver = json_decode(old('receiver'));
                                $other_biller = json_decode(old('other_biller'));
                                $dates = json_decode(old('dates'));
                                @endphp
                                <div class="input-child">
                                    <input autofocus="autofocus" placeholder="Vorname" id="senderfirstName" type="text" value="{{ @$sender->first_name }}">
                                </div>
                            </div>
                            <div class="half-width input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Nachname">
                                    <label dfor="senderlastName">Nachname * </label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Nachname" id="senderlastName" type="text" value="{{ @$sender->last_name }}"> 
                                </div>
                            </div>
                            <div class="half-width odd input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Handynummer">
                                    <label for="senderphone">Handynummer * </label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Handynummer" id="senderphone" type="text" value="{{ @$sender->mobile }}"> 
                                </div>
                            </div>
                            <div class="half-width odd input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Unternehmen ?">
                                    <label for="senderisCompany">Unternehmen ?</label>
                                </span> 
                                <div class="input-child">
                                    <select placeholder="Unternehmen ?" id="senderisCompany">
                                        <option value="0">Person</option>
                                        <option value="1">Unternehmen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-parent" style="display: none;">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Unternehmen">
                                    <label for="sendercompany">Unternehmen</label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Unternehmen" id="sendercompany" type="text" value="{{ @$sender->company }}">
                                </div>
                            </div>
                            <div class="input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Email">
                                    <label for="senderemail">Email</label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Email (Optional)" id="senderemail" type="email" value="{{ @$sender->email }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="goods-desc" style="margin-left: 5px;">
                            <h3 class="goods-descripe-head">ABHOLZEIT</h3> 
                            <div class="input-parent datetimepicker">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Ladezeit Ab">
                                    <label for="sendertime">Ladezeit Ab</label>
                                </span> 
                                <div class="input-child">
                                    <input type="text" class="form-control" id="sendertime" value="{{ @$dates->load_from }}">
                                </div>
                            </div>
                            <div class="input-parent datetimepicker">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Bis">
                                    <label for="senderLoadTill">Bis</label>
                                </span> 
                                <div class="input-child">
                                    <input type="text" class="form-control" id="senderLoadTill" value="{{ @$dates->load_to }}">
                                </div>
                            </div> 
                            <div class="input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Gesetzesentwurf für">
                                    <label for="paymentfor">Gesetzesentwurf für</label>
                                </span> 
                                <div class="input-child">
                                    <select placeholder="Gesetzesentwurf für" id="paymentfor">
                                        <option value="0">Absender</option>
                                        <option value="1">Empfänger</option>
                                        <option value="2">Andere</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="second form-data">
                        <div class="goods-desc">
                            <h3 class="goods-descripe-head">Sind dieselben Absenderdaten?
                                <input type="checkbox" id="roundedOne"/> 
                                <label for="sameAsSender" data-toggle="tooltip" data-original-title="Der Empfänger ist der Absender"></label>
                            </h3> 
                            <div class="half-width odd input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Vorname">
                                    <label for="receiverfirstName">Vorname * </label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Vorname" id="receiverfirstName" type="text" value="{{ @$receiver->first_name }}">
                                </div>
                            </div>
                            <div class="half-width input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Nachname">
                                    <label for="receiverlastName">Nachname * </label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Nachname" id="receiverlastName" type="text" value="{{ @$receiver->last_name }}">
                                </div>
                            </div>
                            <div class="half-width odd input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Handynummer">
                                    <label for="receiverphone">Handynummer * </label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Handynummer" id="receiverphone" type="text" value="{{ @$receiver->phone }}"> 
                                </div>
                            </div>
                            <div class="half-width input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Unternehmen ?">
                                    <label for="receiverisCompany">Unternehmen ?</label>
                                </span> 
                                <div class="input-child">
                                    <select placeholder="Unternehmen ?" id="receiverisCompany" >
                                        <option value="0">Person</option>
                                        <option value="1">Unternehmen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-parent" style="display: none;">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Unternehmen">
                                    <label for="sendercompany">Unternehmen</label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Unternehmen" id="receivercompany" type="text" value="{{ @$receiver->company }}">  
                                </div>
                            </div>
                            <div class="input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Email">
                                    <label for="receiveremail">Email</label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Email (Optional)" id="receiveremail" type="email" value="{{ @$receiver->email }}">
                                </div> 
                            </div>
                        </div>

                        <div class="goods-desc" style="margin-left: 5px;">
                            <h3 class="goods-descripe-head">LIEFERZEIT</h3> 
                            <div class="input-parent datetimepicker">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Von">
                                    <label for="receivertime">Von</label>
                                </span> 
                                <div class="input-child">
                                    <input type="text" class="form-control" id="receivertime" value="{{ @$dates->deliver_from }}">
                                </div>
                            </div>
                            <div class="input-parent datetimepicker">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Bis">
                                    <label for="receiverLoadTill">Bis</label>
                                </span> 
                                <div class="input-child">
                                    <input type="text" class="form-control" id="receiverLoadTill" value="{{ @$dates->deliver_to }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="third form-data">
                        <div class="goods-desc">
                            <h3 class="goods-descripe-head">Andere</h3> 
                            <div class="half-width odd input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Vorname">
                                    <label for="otherbillingfirstName">Vorname * </label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Vorname" id="otherbillingfirstName" type="text" value="{{ @$other_biller->first_name }}"> 
                                </div>
                            </div>
                            <div class="half-width input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Nachname">
                                    <label for="otherbillinglastName">Nachname * </label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Nachname" id="otherbillinglastName" type="text" value="{{ @$other_biller->last_name }}">
                                </div>
                            </div>
                            <div class="half-width odd input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Handynummer">
                                    <label for="otherbillingphone">Handynummer * </label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Handynummer" id="otherbillingphone" type="text" value="{{ @$other_biller->mobile }}"> 
                                </div>
                            </div>
                            <div class="half-width input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Unternehmen ?">
                                    <label for="receiverisCompany">Unternehmen ?</label>
                                </span> 
                                <div class="input-child">
                                    <select placeholder="Unternehmen ?" id="otherbillingCompany">
                                        <option value="0">Person</option>
                                        <option value="1">Unternehmen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-parent" style="display: none;">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Unternehmen">
                                    <label for="otherbillingcompany">Unternehmen</label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Unternehmen" id="otherbillingcompany" type="text" value="{{ @$other_biller->company }}">
                                </div>
                            </div>
                            <div class="input-parent">
                                <span data-toggle="tooltip" class="label-span" data-original-title="Email">
                                    <label for="otherbillingemail">Email</label>
                                </span> 
                                <div class="input-child">
                                    <input placeholder="Email (Optional)" id="otherbillingemail" type="email" value="{{ @$other_biller->email }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    

                    <div class="small-order-cell completeIt">
                        <div class="letsComplete btn">
                            Einsenden <img src="{{ asset('/assets/images/loading.svg') }}" alt="">
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
                                <input type="hidden" id="myDetails" data-id="{{ $order->code }}" data-tab="{{ $order->minutes }}">
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKbJsGIea4zN3LbwdZ7o1eDt2BttMnTCc&libraries=places&language=en-EN" type="text/javascript"></script>
<script src="{{ asset('assets/components/order.js') }}"></script>
@endsection