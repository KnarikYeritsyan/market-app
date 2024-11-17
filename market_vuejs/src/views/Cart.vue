<template>
  <div>
    <div class="breadcrumb-area">
      <!-- Top Breadcrumb Area -->
      <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(/img/bg-img/24.jpg);">
        <h2>{{$t('Cart')}}</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> {{$t('Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$t('Cart')}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="cart-area section-padding-0-100 clearfix">
      <div class="container">
        <div v-if="hasProduct()" class="row">
          <div class="col-12">
            <div class="cart-table clearfix">
              <table class="table table-responsive">
                <thead>
                <tr>
                  <th>{{$t('Product')}}</th>
                  <th>{{$t('Quantity')}}</th>
                  <th>{{$t('Price')}}</th>
                  <th>{{$t('Total')}}</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, index) in products">
                  <td class="cart_product_img">
                    <router-link :to="`/${$i18n.locale}${product.slug}`"><img :src="product.image_name" :alt="product.name"></router-link>
                    <h5>{{product.name}}</h5>
                  </td>
                  <td class="qty">
                    <div class="quantity">
                      <span class="qty-minus" @click="valueDown(product.id)"><i class="fa fa-minus" aria-hidden="true"></i></span>
                      <input type="number" v-on:change="changeCount(product.id,$event.target.value)" class="qty-text" :id="`qty${product.id}`" step="1" min="1" max="99" name="quantity" :value="getProductsCounts[product.id]">
                      <span class="qty-plus" @click="valueUp(product.id)"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
                  </td>
                  <td class="price"><span>${{product.price}}</span></td>
                  <td class="total_price"><span>${{product.price*getProductsCounts[product.id]}}</span></td>
                  <td class="action"><a @click="remove(product.id,$event.target)"><i class="icon_close"></i></a></td>
                </tr>
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="col-5 col-md-3">
              <div @click="empty()" style="cursor: pointer;" class="input-group">
                <div class="input-group-append">
                  <button style="border-radius: unset;background: #CCCCCC;cursor: pointer" class="input-group-text border-0" id="basic-addon2">&#x2716;</button>
                </div>
                <div style="border-radius: unset;background: #e9ecef;text-decoration: underline;" class="form-control text-center border-0">{{$t('Empty cart')}}</div>
              </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="hasProduct()" class="row">

          <!-- Coupon Discount -->
          <div class="col-12 col-lg-6">
            <div class="coupon-discount mt-70">
              <h5>COUPON DISCOUNT</h5>
              <p>Coupons can be applied in the cart prior to checkout. Add an eligible item from the booth of the seller that created the coupon code to your cart. Click the green "Apply code" button to add the coupon to your order. The order total will update to indicate the savings specific to the coupon code entered.</p>
              <form action="#" method="post">
                <input type="text" name="coupon-code" placeholder="Enter your coupon code">
                <button type="submit">APPLY COUPON</button>
              </form>
            </div>
          </div>

          <!-- Cart Totals -->
          <div class="col-12 col-lg-6">
            <div class="cart-totals-area mt-70">
              <h5 class="title--">Cart Total</h5>
              <div class="subtotal d-flex justify-content-between">
                <h5>Subtotal</h5>
                <h5>${{totalPrice()}}</h5>
              </div>
              <div class="shipping d-flex justify-content-between">
                <h5>Shipping</h5>
                <div class="shipping-address">
                  <form action="#" method="post">
                    <select class="custom-select">
                      <option selected>Country</option>
                      <option value="1">USA</option>
                      <option value="2">Latvia</option>
                      <option value="3">Japan</option>
                      <option value="4">Bangladesh</option>
                    </select>
                    <input type="text" name="shipping-text" id="shipping-text" placeholder="State">
                    <input type="text" name="shipping-zip" id="shipping-zip" placeholder="ZIP">
                    <button type="submit">Update Total</button>
                  </form>
                </div>
              </div>
              <div class="total d-flex justify-content-between">
                <h5>Total</h5>
                <h5>$9.99</h5>
              </div>
              <div class="checkout-btn">
                <a href="#" class="btn alazea-btn w-100">PROCEED TO CHECKOUT</a>
              </div>
            </div>
          </div>
        </div>

        <div v-if="!hasProduct()" class="checkout-message">
          <h3>{{$t('No products...')}}</h3>
          <router-link :to="`/${$i18n.locale}/shop`">{{$t('Back to list of products')}}</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  computed: {
    ...mapGetters([
      'getProductsInCart',
      'getProductsCounts',
    ]),
  },
  data() {
    return {
      products:[],
      total:0,
    };
  },
  created(){
    let queryString = this.getProductsInCart.join(',');
    this.$http.get(this.$ApiHost+'/api/find-products?ids='+queryString)
        .then( (response) =>{
          this.products = response.data['products'];
    })
  },
  methods: {
    ...mapActions([
      'removeProduct',
      'emptyCart',
      'changeProductCount',
    ]),
    hasProduct() {
      return this.getProductsInCart.length > 0;
    },
    totalPrice() {
      let price = 0;
      let counts = this.getProductsCounts;
      this.products.forEach(function (product) {
        price += counts[product.id]?product.price*counts[product.id]:0
    });
      return price;
    },
    remove(index,event) {
      this.removeProduct(index);
      event.closest("tr").remove();
    },
    empty() {
      this.emptyCart();
    },
    changeCount(index,count) {
      let prod = {
        'index':index,
        'count':count
      };
      if(parseInt(count) && count < 100 && count > 0){
        this.changeProductCount(prod);
      }else {
        $('#qty'+index).val(this.getProductsCounts[index])
      }
    },
    valueDown(index){
      var effect = document.getElementById('qty'+index);
      var qty = effect.value;
      if( !isNaN( qty ) && qty > 1 ) effect.value--;
      effect.dispatchEvent(new Event("change"));
      return false;
    },
    valueUp(index){
      var effect = document.getElementById('qty'+index);
      var qty = effect.value; if( !isNaN( qty )) effect.value++;
      effect.dispatchEvent(new Event("change"));
      return false;
    }
  },
};
</script>

<style scoped>
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  input[type=number] {
    -moz-appearance: textfield;
  }
    .icon_close{
        cursor: pointer;
    }
</style>
