<template>
    <div>
        <div class="card">
            <div class="container-fliud">
                <div class="wrapper row">
                    <div class="preview col-md-6">
                        
                        <div class="preview-pic tab-content">
                          <div class="tab-pane active" id="pic-1"><img :src="product.image_name" height="450" /></div>
                         
                        </div>
                      
                    </div>
                    <div class="details col-md-6">
                        <h3 class="product-title">{{product.name}}</h3>
                        <div class="rating">
                          
                                <span class="lni-star-filled" style="color:##fc924b"></span>
                                <span class="lni-star-filled"></span>
                                <span class="lni-star-filled"></span>
                                <span class="lni-star-filled"></span>
                            
                            <!-- <span class="review-no">41 reviews</span> -->
                        </div>
                        <p class="product-description">{{product.description}}</p>
                        <h4 class="price">Price: <span>${{product.price}}</span></h4>

                        <div class="action">
                           <add-to-cart-button :product-id="product.id" :user-id="auth_user_id" :product-name="product.name"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                user_id: '',
            }
        },
        props: ['product', 'auth_user_id'],

        methods: {

        },

    }
</script>

<style scoped>
    .rating span{
        color: #fc924b;
    }
</style>
