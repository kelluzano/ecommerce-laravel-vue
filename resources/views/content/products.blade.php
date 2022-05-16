@extends('master')
@section('content')

  <section id="product" class="product-area pt-100 pb-130">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="collection-menu text-center mt-30">
                        <h4 class="collection-tilte">OUR COLLECTION</h4>
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="active" id="v-pills-furniture-tab" data-toggle="pill" href="#v-pills-furniture" role="tab" aria-controls="v-pills-furniture" aria-selected="true">Furniture</a>
                            
                            <a id="v-pills-decorative-tab" data-toggle="pill" href="#v-pills-decorative" role="tab" aria-controls="v-pills-decorative" aria-selected="false">Decorative</a>
                            
                            <a id="v-pills-lighting-tab" data-toggle="pill" href="#v-pills-lighting" role="tab" aria-controls="v-pills-lighting" aria-selected="false">Lighting</a>
                            
                            <a id="v-pills-outdoor-tab" data-toggle="pill" href="#v-pills-outdoor" role="tab" aria-controls="v-pills-outdoor" aria-selected="false">Outdoor</a>
                            
                            <a id="v-pills-storage-tab" data-toggle="pill" href="#v-pills-storage" role="tab" aria-controls="v-pills-storage" aria-selected="false">Storage</a>
                        </div> <!-- nav -->
                    </div> <!-- collection menu -->
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-furniture" role="tabpanel" aria-labelledby="v-pills-furniture-tab">
                            <div class="product-items mt-30">
                                <div class="row product-items-active">
                                   @if(isset($products))
                                @foreach($products as $product)
                                <div class="col-md-4">
                                    <div class="single-product-items">
                                        <div class="product-item-image">
                                            <a href="#"><img src="{{ $product->image_name }}" alt="Product" height="320px"></a>
                                            <div class="product-discount-tag">
                                                <p>-$50</p>
                                            </div>
                                        </div>
                                        <div class="product-item-content text-center mt-30">
                                            <h5 class="product-title"><a href="#">{{ $product->name }}</a></h5>
                                            <ul class="rating">
                                                <li><i class="lni-star-filled"></i></li>
                                                <li><i class="lni-star-filled"></i></li>
                                                <li><i class="lni-star-filled"></i></li>
                                                <li><i class="lni-star-filled"></i></li>
                                            </ul>
                                            <span class="regular-price">${{$product->price}}</span>
                                            <span class="discount-price">${{$product->sale_price}}</span>
                                            <hr>
                                            <add-to-cart-button product-id="{{$product->id}}" user-id="{{ auth()->user()->id ?? 0}}"/>
                                        </div>

                                    </div> <!-- single product items -->
                                </div>
                                @endforeach
                                @endif
                                </div> <!-- row -->
                            </div> <!-- product items -->
                        </div> <!-- tab pane -->

                      

                
                    </div> <!-- tab content --> 
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

@endsection