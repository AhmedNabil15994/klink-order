<h4 class="order_heading">{{trans('frontend/order.payment')}}</h4>

<ul class="payment_method new_payment_method">
    <div class="disable select_this">
    
    </div>
    <li>
        <a href="#" id="paypal" data-type="0">
            <img src="{{ asset('/assets/images/paypal.svg') }}" alt="">
        </a>
    </li>
    <li>
        <a href="#" id="visa" data-type="1">
            <img src="{{ asset('/assets/images/visa.svg') }}" alt="">
        </a>
    </li>
    <li>
        <a href="#" id="master_card" data-type="2">
            <img src="{{ asset('/assets/images/master.svg') }}" alt="">
        </a>
    </li>
    <li>
        <a href="#" id="maestro" data-type="3">
            <img src="{{ asset('/assets/images/maestro.svg') }}" alt="">
        </a>
    </li>
    <li>
        <a href="#" id="klarna" data-type="4">
            <img src="{{ asset('/assets/images/klarna.svg') }}" alt="">
        </a>
    </li>
    <li>
        <a href="#" id="sofort" data-type="5">
            <img src="{{ asset('/assets/images/sofort.svg') }}" alt="">
        </a>
    </li>
    <li>
        <a href="#" id="sepa" data-type="6">
            <img src="{{ asset('/assets/images/sepa.svg') }}" alt="">
        </a>
    </li>
    <li>
        <a href="#" id="vorkasse" data-type="7">
            <img src="{{ asset('/assets/images/vorkasse.svg') }}" alt="">
        </a>
    </li>
    <li>
        <a href="#" id="bar" data-type="8">
            <img src="{{ asset('/assets/images/bar.svg') }}" alt="">
        </a>
    </li>
    
</ul>
<div class="row col-xs-12" style="margin-top: 1.5rem;">
    <div class="col-xs-8" style="padding: 0;">
        <span class="valid_heading" style="color: #6dace6;">{{trans('frontend/order.valid_until')}}</span>
    </div>
    <div class="col-xs-4" style="padding: 0;">
        <span class="valid_until" style="color: #838383;font-size: 11px;float: right;" data-countdown="{{ $order->dates->valid_until != null ? $order->dates->valid_until : '' }}"></span>
    </div>
</div>
<div class="row step__five">
    <div class="col-xs-12">
        <div class="row col-xs-2" style="margin-bottom: 1rem;">   
                        
            <input type="checkbox" name="type" id="one" class="icheckbox_flat">

        </div>  
        <div class="col-xs-10">
            <span class="confirm-head">
                {{trans('frontend/order.confirm_order')}}
            </span>
            <p>{{trans('frontend/order.accept1')}} : <a href="{{URL::to('/terms')}}">{{trans('frontend/order.data_confirm')}}</a></p>
        </div>   
    </div>
</div>


