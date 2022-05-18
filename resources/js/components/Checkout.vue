<template>
	<div id="axiosForm">
		<div class="loader" v-if="isLoading"></div>
		<div class="container checkoutBox">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
					<div class="box">
						<h3 class="box-title">Products in your Cart</h3>
						<div class="plan-selection" v-if="item.name" v-for="(item,index) in items" :key="item.id">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-sm btn-danger float-right" @click.prevent="removeFromCart(index)"><i class="lni-trash"></i></button>
								</div>
							</div>
							<div class="plan-data">
								
								<label for="quantity">{{item.name}}</label>
								<p class="plan-text">
									Quantitiy: 
									<input id="quantity" type="text" :value="item.quantity" readonly style="width:50px; text-align: center;">
									<button class="btn btn-sm btn-danger" :disabled="item.quantity == 1" @click="updateProductQuantity(item.id,'decrement')">-</button>
									<button class="btn btn-sm btn-success" @click="updateProductQuantity(item.id,'increment')">+</button>
								</p>
								
								<span class="plan-price">Price: ${{item.sale_price}}</span>
							</div>
						</div>

						<div v-if="items.totalAmount != 0">
							<!--SHIPPING METHOD-->
							<div class="panel panel-info">

								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-12">
											<h4>Shipping Address</h4>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12"><strong>Country:</strong></div>
										<div class="col-md-12">
											<input type="text" class="form-control" v-model="country" name="country" value="" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-xs-12">
											<strong>First Name:</strong>
											<input type="text" v-model="firstName" name="first_name" class="form-control" value="" />
										</div>
										<div class="span1"></div>
										<div class="col-md-6 col-xs-12">
											<strong>Last Name:</strong>
											<input type="text" v-model="lastName" name="last_name" class="form-control" value="" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12"><strong>Address:</strong></div>
										<div class="col-md-12">
											<input type="text" v-model="address" name="address" class="form-control" value="" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12"><strong>City:</strong></div>
										<div class="col-md-12">
											<input type="text" v-model="city" name="city" class="form-control" value="" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12"><strong>State:</strong></div>
										<div class="col-md-12">
											<input type="text" v-model="state" name="state" class="form-control" value="" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12"><strong>Zip / Postal Code:</strong></div>
										<div class="col-md-12">
											<input type="text" v-model="zipCode" name="zip_code" class="form-control" value="" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12"><strong>Phone Number:</strong></div>
										<div class="col-md-12"><input type="text" v-model="phone_number" name="phone_number" class="form-control" value="" /></div>
									</div>
									<div class="form-group">
										<div class="col-md-12"><strong>Email Address:</strong></div>
										<div class="col-md-12"><input type="text" v-model="email" name="email_address" class="form-control" value="" /></div>
									</div>
								</div>
							</div>
							<!--SHIPPING METHOD END-->
							<!--CREDIT CART PAYMENT-->
							<div class="panel panel-info">
								<h4>Secure Payment</h4>
								<br>
								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-12"><strong>Card Type:</strong></div>
										<div class="col-md-12">
											<select id="CreditCardType" v-model="cardType" name="CreditCardType" class="form-control">
												<option value="5">Visa</option>
												<option value="6">MasterCard</option>
												<option value="7">American Express</option>
												<option value="8">Discover</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12"><strong>Credit Card Number:</strong></div>
										<div class="col-md-12"><input type="text" class="form-control" v-model="cardNumber" value="4242424242424242" readonly/></div>
									</div>
									<div class="form-group">
										<div class="col-md-12"><strong>Card CVV:</strong></div>
										<div class="col-md-12">
											<input type="text" class="form-control input-number" v-model="cvv" value=""/>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<strong>Expiration Date</strong>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="" v-model="expMonth">
												<option value="">Month</option>
												<option value="01">01</option>
												<option value="02">02</option>
												<option value="03">03</option>
												<option value="04">04</option>
												<option value="05">05</option>
												<option value="06">06</option>
												<option value="07">07</option>
												<option value="08">08</option>
												<option value="09">09</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
											</select>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<select class="form-control" name="" v-model="expYear">
												<option value="">Year</option>
												<option v-for="year in years" :key="year" :value="year">
													{{ year }}
												</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<span>Pay secure using your credit card.</span>
										</div>
										<div class="col-md-12">
											<ul class="cards">
												<li class="visa hand">Visa</li>
												<li class="mastercard hand">MasterCard</li>
												<li class="amex hand">Amex</li>
											</ul>
											<div class="clearfix"></div>
										</div>
									</div>

									<div class="form-group">
										<div class="float-right">
											<button class="btn btn-warning btn-submit-fix" v-on:click.prevent="getUserAddress()">Place Order</button>
										</div>
									</div>

								</div>
							</div>
							<!--CREDIT CART PAYMENT END-->
						</div>
						
					</div>

				</div>
				<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">

					<div class="widget">
						<h4 class="widget-title">Order Summary</h4>
						<div class="summary-block"v-for="summaryItem in items" :key="summaryItem.id">
							<div class="summary-content" v-if="summaryItem.name">
								<div class="summary-head"><h5 class="summary-title">{{summaryItem.name}}</h5></div>
								<div class="summary-price">
									<p class="summary-text">
										${{summaryItem.total}}
									</p>
									
									<span class="summary-small-text pull-right">Q: {{summaryItem.quantity}}      X</span>
									<span class="summary-small-text pull-right">P: ${{summaryItem.sale_price}} </span>
									
								</div>
							</div>
						</div>
						
						<div class="summary-block">
							<div class="summary-content">
								<div class="summary-head"> <h5 class="summary-title">Total</h5></div>
								<div class="summary-price">
									<p class="summary-text" style="font-weight: bold;">${{items.totalAmount}}</p>
								</div>
								
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default{
	data(){
		return {
			items: [],
			firstName: '',
			lastName: '',
			email: '',
			phone_number: '',
			address: '',
			city: '',
			state: '',
			zipCode: '',
			country: '',
			cardType: '',
			cardNumber: '4242424242424242',
			expMonth: '',
			expYear: '',
			cvv: '',
			newyears: [],
			isLoading: false,
		}
	},
	methods: {
		getCartItems(){
			axios.post('/checkout/get/items')
			.then((response) => {
				this.items = response.data
				console.log(Object.keys(this.items).length);
			});

		},
		async getUserAddress(){
			if(this.firstName != '' && this.address != '' && this.cardNumber != '' && this.cvv != ''){
				this.isLoading = true;
				console.log(this.isLoading);
				axios.post('/process/user/payment',{
					'firstName': this.firstName,
					'lastName': this.lastName,
					'email': this.email,
					'phone_number': this.phone_number,
					'address': this.address,
					'city': this.city,
					'state': this.state,
					'zipCode': this.zipCode,
					'country': this.country,
					'cardType': this.cardType,
					'cardNumber': this.cardNumber,
					'expMonth': this.expMonth,
					'expYear': this.expYear,
					'cvv': this.cvv,
					'amount': this.items.totalAmount,
					'order': this.items,
				}).then((response) => {
					if(response.data.success){
						this.$toastr.s(response.data.success);
					}else{
						this.$toastr.e(response.data.error);
					}
				}).catch((error) => {
					console.log(error);
				}).finally( () => {
					console.log('disable spinner');
				});


				setTimeout(() => {
					window.location.href="/";
				},2500)

			}else{
				this.$toastr.e('User info incomplete');
			}
		},
		updateProductQuantity(productId,type){
			const vm = this;

			axios.post('/product/update/quantity',{
				'productId': productId,
				'type': type
			}).then((response) => {
				vm.items[productId].quantity = response.data.quantity;
				vm.items[productId].total = response.data.total;
				vm.$root.$emit('changeInCart', response.data.totalItemCount);

					// //calculate overall total
					var overallTotal = 0;
					$.each(vm.items, function (key,value){
						if(typeof value.total != "undefined"){
							overallTotal += value.total;
							
						}
					});
					vm.items.totalAmount = overallTotal;

				});
		},
		removeFromCart(index){

			axios.post('/product/remove', {
				'productId': index,
			}).then((response) => {

				this.$toastr.e(response.data.message);
				this.$root.$emit('changeInCart', response.data.totalItemCount);
				this.$delete(this.items,index);

				var overallTotal = 0;
				$.each(this.items, function (key,value){
					if(typeof value.total != "undefined"){
						overallTotal += value.total;

					}
				});
				this.items.totalAmount = overallTotal;

			});
		},
	},	
	created(){
		this.getCartItems();

	},
	computed: {
		years(){
			const year = new Date().getFullYear()
			let years = [];
			let newYear = year + 10;
			for(var i = year; i <= newYear; i++){
				years.push(i);
			}
			return this.newyears = years;

		},



	}

}
</script>


<style scoped>
#axiosForm{  /* Components Root Element ID */
    position: relative;
}
.loader{  /* Loader Div Class */
    position: absolute;
    top:0px;
    right:0px;
    width:100%;
    height:100%;
    background-color:#eceaea;
    background-image: url('http://i.stack.imgur.com/FhHRx.gif');
    background-size: 50px;
    background-repeat:no-repeat;
    background-position:center;
    z-index:10000000;
    opacity: 0.4;
    filter: alpha(opacity=40);
}
</style>