@extends('master')
@section('content')

<section id="product" class="product-area pt-100 pb-130">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-furniture" role="tabpanel" aria-labelledby="v-pills-furniture-tab">
                        <div class="product-items mt-30">
                            

                                <products :auth_user_id="{{$auth_user_id}}"></products>
                            
                        </div> <!-- product items -->
                    </div> <!-- tab pane -->

                </div> <!-- tab content --> 
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

@endsection