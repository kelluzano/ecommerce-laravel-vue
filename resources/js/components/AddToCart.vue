<template>
    <button class="btn btn-warning" v-on:click.prevent="addProductToCart()">Add to Cart</button>
</template>

<script>
    export default {
        data(){
            return {
                
            }
        },
        props: ['productId','userId','productName'],
        methods: {
            async addProductToCart(){
                //Check if user logged in

                if(this.userId == 0){
                    this.$toastr.e('You need to login, To add this product in Cart');
                    return;
                }

                let response = await axios.post('/cart', {
                    'product_id': this.productId
                });

                let msg = 'Item: '+this.productName+' added to your cart.';
                this.$toastr.s(msg);

                this.$root.$emit('changeInCart', response.data.items);
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>


