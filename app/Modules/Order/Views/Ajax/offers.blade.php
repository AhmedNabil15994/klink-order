<div class="offer-design">
	<h4 class="order_heading">{{trans('frontend/order.offers')}}
		<img src="{{asset('assets/images/ajax-loader.gif')}}">
	</h4>
	<ul class="values">
		<li>
			<span class="value_title">{{trans('frontend/order.name')}}</span>
			<span class="value_title text-center">{{trans('frontend/order.total')}}</span>
			<span class="value_title">{{trans('frontend/order.action')}}</span>
		</li>

		@foreach($offers as $offerKey => $offerValue)
		<li data-tab="{{ $offerValue->decID }}">
			<div class="value profile"><img src="{{ $offerValue->image }}" alt="">{{ $offerValue->company }}</div>
			<div class="value myNumberFont text-center">{{ $offerValue->display_price }} €</div>
			<div class="text-center">
				<button class="btn btn-xs btn-success accept" data-toggle="tooltip" data-original-title="Accept Offer"><i class="fa fa-check-circle"></i></button>
				<button class="btn btn-xs btn-danger ignore" data-toggle="tooltip" data-original-title="Refuse Offer"><i class="fa fa-times"></i></button>
			</div>
		</li>
		@endforeach
	<ul>
</div>