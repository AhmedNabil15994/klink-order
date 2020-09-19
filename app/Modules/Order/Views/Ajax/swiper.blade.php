@foreach($allShips as $shipKey => $shipValue)
<div class="swiper-slide">
    <div class="vehicle-slider">
        <div class="vehicle-cost">
            <div class="cost-field">
                <span><span class="cost">{{ $shipValue->cost }}</span> €</span> 
            </div>
        </div> 
        <div class="vehicle-image">
            <div class="vehicle-images-wrapper" data-id="{{ $shipValue->ship->id }}" data-tab="{{ $shipValue->id }}">
                <li class="is-checked checkbox check">
                    <i class="fa fa-check"></i>
                </li> 
                <img src="{{ $shipValue->ship->image }}" alt="">
            </div>
        </div> 
        <div class="vehicle-name">{{ $shipValue->ship->title }}</div> 
        <div class="vehicle-dimenstions">
            <span><b>Width:</b> <p class="width">{{ $shipValue->ship->width / 10 }}</p></span> 
            <span><b>Length:</b> <p class="length">{{ $shipValue->ship->length / 10 }}</p></span> 
            <span><b>Height:</b> <p class="height">{{ $shipValue->ship->height / 10 }}</p></span>
        </div>
    </div>
</div>
@endforeach