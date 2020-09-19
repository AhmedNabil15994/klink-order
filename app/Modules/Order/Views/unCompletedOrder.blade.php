@extends('Dashboard.Layouts.master')
@section('title',ucwords($order->code))
@section('styles')
<link rel="stylesheet" href="{{ asset('/assets/css/uncompleted_order.css') }}">
@endsection

@section('content')



<!--pageContent-->
<div class="pageContent">
	<div class="container-fluid">
		<div class="content rale" style="background: #FFF;">
			<div class="step_item step__four active" data-list="step_list_4">
				<div class="row">
					<div class="payment_info">

						<div class="col-md-4">

							<div class="row col-xs-12">
								<div class="order_info">
									<h4 class="order_heading">{{trans('frontend/order.order')}}</h4>
									<div class="order_cart">
										<div class="cart_img">
											<img src="{{asset('assets/images/shopping_cart.png')}}" alt="cart">
										</div><!--cart image-->
										<p class="order-title">
											{{trans('frontend/order.order_no')}} : <br>
											<span class="myNumberFont">
												{{ucwords($order->code)}}
											</span>
										</p>
									</div><!--order cart-->
								</div><!--order info-->
							</div><!--row-->


							<div class="row col-xs-12">
								<div class="time_info">
									<div class="store text-center col-sm-4 col-xs-12">
										<span class="store_heading">{{trans('frontend/order.store')}}</span>
										
										@if(isset($order->dates->load_from))
										<p class="store_from text-center">
											<span class="data-value">
												<a href="#" id="loadFrom" data-type="datetime" data-pk="1" data-url="" title="Select date &amp; time" class="editable editable-click" style="">
													{{ $order->dates->load_from }}
												</a>
											</span>
										</p>
										<p class="store_to text-center">
											<span class="data-value">
												<a href="#" id="loadUp" data-type="datetime" data-pk="1" data-url="" title="Select date &amp; time" class="editable editable-click">
													{{ $order->dates->load_until }}
												</a>
											</span>
										</p>
										@else
										<p class="store_from text-center">{{ $order->dates->load->day }}</p>
										<p class="store_to text-center">
											<span class="data-value">
												<a href="#" id="loadFrom" data-type="datetime" data-pk="1" data-url="" title="Select date &amp; time" class="editable editable-click">
													{{ $order->dates->load->from }}
												</a>
											</span>
											- 
											<span class="data-value">
												<a href="#" id="loadUp" data-type="datetime" data-pk="1" data-url="" title="Select date &amp; time" class="editable editable-click">
													{{ $order->dates->load->to }}
												</a>
											</span>
										</p>
										@endif
									</div>

									<div class="time_icon  col-sm-4 col-xs-12">
										<span class="glyphicon glyphicon-time"></span>
										<p><span class="myNumberFont">{{ $order->load_time }}</span> Min</p>
										<p class="persons">
										@for($personCounter = 0; $personCounter < $order->person ; $personCounter++)
                                        	<span class="back"></span> 
										@endfor
										</p>
                                        <div class="clearfix"></div>
									</div>
									<div class="deliver  col-sm-4 col-xs-12">
										<span class="deliver_heading text-center">{{trans('frontend/order.delivering')}}</span>
										@if(isset($order->dates->deliver_from))
										<p class="deliver_from text-center">
											<span class="data-value">
												<a href="#" id="deliveryFrom" data-type="datetime" data-pk="1" data-url="" title="Select date &amp; time" class="editable editable-click">
													{{ $order->dates->deliver_from }}
												</a>
											</span>
										</p>
										<p class="deliver_to text-center">
											<span class="data-value">
												<a href="#" id="deliveryUntil" data-type="datetime" data-pk="1" data-url="" title="Select date &amp; time" class="editable editable-click">
													{{ $order->dates->deliver_until}}
												</a>
											</span>
										</p>
										@else
										<p class="deliver_from text-center">{{ $order->dates->deliver->day }}</p>
										<p class="deliver_to center">
											<span class="data-value">
												<a href="#" id="deliveryFrom" data-type="datetime" data-pk="1" data-url="" title="Select date &amp; time" class="editable editable-click">
													{{ $order->dates->deliver->from }}
												</a>
											</span>
											- 
											<span class="data-value">
												<a href="#" id="deliveryUntil" data-type="datetime" data-pk="1" data-url="" title="Select date &amp; time" class="editable editable-click">
													{{ $order->dates->deliver->to }}
												</a>
											</span>
										</p>
										@endif
									</div>
								</div><!--time_info-->
							</div><!--row-->

							
						</div><!--col-->

						<div class="col-md-4">
							<div class="row col-xs-12">
								<div class="further_info">
									<h4 class="order_heading">{{trans('frontend/order.further_data')}}</h4>
									<ul class="values">
										<li>
											<span class="value_title">
												{{trans('frontend/order.measurement')}}
											</span>
											<span class="value myNumberFont">
												{{ $order->length }}, {{ $order->width }}, {{ $order->height }}/{{ $order->weight }}
											</span>
										</li>

										<li>
											<span class="value_title">
												{{trans('frontend/order.distance')}} 

											</span>
											<span class="value myNumberFont">
												{{ $order->distance }} Km
											</span>
										</li>

										<li>
											<span class="value_title">
												{{trans('frontend/order.subtotal')}} 
											</span>
											<span class="value cost myNumberFont">
												{{ $order->cost }} €

											</span>
										</li>

										<li>
											<span class="value_title">
												{{trans('frontend/order.inc')}} :
											</span>
											<span class="value vat myNumberFont">
												{{ round( $order->cost * 19/100 ,2) }} €
											</span>
										</li>


										<li>
											<span class="total">
												{{trans('frontend/order.total')}}
											</span>
											<span class="total_value myNumberFont">
												{{ round( $order->cost + ($order->cost * 19/100 ),2) }} €
											</span>
										</li>
									</ul>
								</div><!--order info-->
							</div><!--row-->
						</div><!--col-->
						<div id="app">
							<div class="col-md-4">
								<div class="payment_method">
									@if(!empty($offers) && $order->status == 2)
									@include('Order.Views.Ajax.offers')
									@elseif($order->status == 4)
									@include('Order.Views.Ajax.payment')
									@else
									<p class="loadImgp">{{trans('frontend/order.please_wait')}}
										<img src="{{asset('assets/images/ajax-loader.gif')}}">
									</p>
									@endif
									
								</div>
							</div><!--col-->
						</div>

					</div><!--payment info-->
				</div><!--payment info row-->
				<input type="hidden" name="tab" class="tab" value="{{ $order->id }}" data-tab="{{ $order->code }}" data-tabs="{{ $order->status }}">
				<div class="payment-data">
					@include('Order.Views.Ajax.payment')
				</div>
				<div class="row">
					<div class="col-sm-6 col-xs-12 col-md-4">
						<h4 class="ul-heading">{{trans('frontend/order.sender')}}</h4>
						<ul class="own-data">
							<li class="row">
								<span class="data-title">{{trans('frontend/order.name')}}</span>
								<span class="data-value">
									<a href="#" id="userSendername" data-type="text" data-title="Enter Sender Name">{{ $order->sender->name }}</a>
								</span>
							</li>
							<li class="row">
								<span class="data-title">{{trans('frontend/order.address')}}</span>
								<span class="data-value">
									{!! \Helper::displayAddress($order->from) !!}
								</span>
							</li>
							<li class="row">
								<span class="data-title">{{trans('frontend/order.phone')}} 
								@if($order->sender->email != '')	
								/ {{trans('frontend/order.email')}}
								@endif
								</span>
								<span class="data-value">
									<a href="#" id="userSenderphone" data-type="text" data-title="Enter Sender Phone">{{ $order->sender->phone }}</a>
									@if($order->sender->email != '')
									/ <a href="#" id="userSenderemail" data-type="text" data-title="Enter Sender Email">{{ $order->sender->email }}</a>
									@endif
								</span>
							</li>
							@if($order->sender->company)
							<li class="row">
								<span class="data-title">{{trans('frontend/order.company')}}</span>
								<span class="data-value">
									<a href="#" id="userSendercompany" data-type="text" title="Enter Sender Company">
										{{ $order->sender->company }}
									</a>	
								</span>
							</li>
							@endif
						</ul>
					</div>
					<div class="col-sm-6 col-xs-12 col-md-4">
						<h4 class="ul-heading">{{trans('frontend/order.receiver')}}</h4>
						<ul class="own-data last">
							<li>
								<span class="data-title">{{trans('frontend/order.name')}}</span>
								<span class="data-value">
									<a href="#" id="userRecievername" data-type="text" data-title="Enter Receiver Name">{{ $order->receiver->name }}</a>
								</span>
							</li>
							<!--don't change that-->
							<li>

								<span class="data-title">{{trans('frontend/order.address')}}</span>
								<span class="data-value">
									{!! \Helper::displayAddress($order->to) !!}
								</span>
							</li>
							<!--don't change that-->
							<li>
								<span class="data-title">{{trans('frontend/order.phone')}}
								@if($order->receiver->email != '')
								/ {{trans('frontend/order.email')}}
								@endif
								</span>
								<span class="data-value"><a href="#" id="userRecieverphone" data-type="text" data-title="Enter Receiver Phone">{{ $order->receiver->phone }}</a> 
								@if($order->receiver->email != '')
								/ <a href="#" id="userRecieveremail" data-type="text" data-title="Enter Receiver Email">{{ $order->receiver->email }}</a>
								@endif
								</span>
							</li>
							@if($order->receiver->company != '')
							<li>
								<span class="data-title">{{trans('frontend/order.company')}}</span>
								<span class="data-value">
									<a href="#" id="userRecievercompany" data-type="text" data-title="Enter Receiver Company">{{ $order->receiver->company }}</a>
								</span>
							</li>
							@endif
						</ul>
					</div>
					<div class="col-sm-6 col-xs-12 col-md-4">

						@if(isset($order->other_biller))
						<div>
							<h4 class="ul-heading">Andere</h4>
							<ul class="own-data">
								<li class="row">
									<span class="data-title">{{trans('frontend/order.name')}}</span>
									<span class="data-value">
										<a href="#" id="userOthername" data-type="text" data-title="Enter Other Biller Name">{{ $order->other_biller->name }}</a>
									</span>
								</li>
								<li class="row">
									<span class="data-title">{{trans('frontend/order.phone')}} 
									@if($order->other_biller->email != '')	
									/ {{trans('frontend/order.email')}}
									@endif
									</span>
									<span class="data-value">
										<a href="#" id="userOtherphone" data-type="text" data-title="Enter Other Biller Phone">{{ $order->other_biller->phone }}</a>
										@if($order->other_biller->email != '')
										/ <a href="#" id="userOtheremail" data-type="text" data-title="Enter Other Biller Email">{{ $order->other_biller->email }}</a>
										@endif
									</span>
								</li>
								@if($order->other_biller->company)
								<li class="row">
									<span class="data-title">{{trans('frontend/order.company')}}</span>
									<span class="data-value">
									<a href="#" id="userOthercompany" data-type="text" data-title="Enter Other Biller Company">{{ $order->other_biller->company }}</a>
									</span>
								</li>
								@endif
							</ul>
						</div>
						@endif

						<h4 class="ul-heading">{{trans('frontend/order.ship_desc')}}</h4>
						<ul class="own-data last">
							<li>
								<span class="data-title">{{trans('frontend/order.goods_desc')}}</span>
								<span class="data-value">
									<a href="#" id="description" data-type="text" data-title="Enter Description">{{ $order->description }}</a>
								</span>
							</li>
							<li>
								<span class="data-title">{{trans('frontend/order.car')}}</span>
								<span class="data-value"><img src="{{ $order->ship->image }}">{{ $order->ship->title }}</span>
							</li>
						</ul>
					</div>
				</div>

				
				


			</div><!--step four-->  




		</div>    
	</div>
</div>   

<form id="pay" method="POST" action="{{URL::to('/orders/lastSteps/'.$order->code.'/paypal')}}">
	{{csrf_field()}}
	<input type="hidden" name="order_id" value="{{$order->id}}">
	<input type="hidden" name="payment_type">
</form>

<form id="bar" method="POST" action="{{URL::to('/orders/lastSteps/'.$order->code.'/payment')}}">
	{{csrf_field()}}
	<input type="hidden" name="order_id" value="{{$order->id}}">
	<input type="hidden" name="payment_type">
</form>

<form action="<?= $request->getEndpoint() ?>" method="POST" id="payment-form">
    {{csrf_field()}}
    <?php foreach ($request->getRequestParameters() as $param => $value): ?>
    <input type="hidden" name="<?= $param ?>" value="<?= $value ?>"/>
    <?php endforeach ?>
    <input type="hidden" name="payment_type" value="">

</form>
@endsection

@section('scripts')
<script src="{{ asset('assets/components/order-last-steps.js') }}"></script>
<script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
@endsection