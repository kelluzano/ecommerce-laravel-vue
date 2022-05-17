<template>
    <div>
        <div class="row product-items-active">
           <div class="col-md-4" v-for="product in products" :key="product.id">
            <div class="single-product-items">
                <div class="product-item-image">
                    <a href="#"><img :src="product.image_name" alt="Product" height="320px"></a>
                    <div class="product-discount-tag">
                        <p>-$50</p>
                    </div>
                </div>
                <div class="product-item-content text-center mt-30">
                    <h5 class="product-title"><a href="#">{{product.name}}</a></h5>
                    <ul class="rating">
                        <li><i class="lni-star-filled"></i></li>
                        <li><i class="lni-star-filled"></i></li>
                        <li><i class="lni-star-filled"></i></li>
                        <li><i class="lni-star-filled"></i></li>
                    </ul>
                    <span class="regular-price">${{product.price}}</span>
                    <span class="discount-price">${{product.sale_price}}</span>
                    <hr>
                    <add-to-cart-button :product-id="product.id" :user-id="auth_user_id" :product-name="product.name"/>
                </div>

            </div> <!-- single product items -->
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data() {
            return {
                products: [],
                user_id: '',
            }
        },
        methods: {
            async getProducts(){
                let response = await axios.get('/products');
                this.products = response.data;

            },
        },
        props: ['auth_user_id'],
        created(){
            this.getProducts();
            
        },
        mounted() {

        },
        updated(){
            $('.product-items-active').slick({
                dots: false,
                infinite: true,
                speed: 600,
                slidesToShow: 3,
                slidesToScroll: 1,
                adaptiveHeight: true,
                arrows: true,
                prevArrow: '<span class="prev"><i class="lni-chevron-left"></i></span>',
                nextArrow: '<span class="next"><i class="lni-chevron-right"></i></span>',
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                    }
                }
                ]
            });
        }
    }
</script>
