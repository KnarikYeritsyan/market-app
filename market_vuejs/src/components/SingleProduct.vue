<template>
  <div class="single-product-area mb-5" style="border: 1px solid #CCCCCC;">
    <div class="product-img">
      <router-link :to="`/${$i18n.locale}${product.slug}`"><img style="height: 250px;" :src="product.image_name" :alt="product.name"></router-link>
      <div v-if="product.tag" class="product-tag">
        <a :style="`background-color: ${product.tag.color}`">{{product.tag.name}}</a>
      </div>
      <div  class="product-info mt-15 text-center">
        <router-link :to="`/${$i18n.locale}${product.slug}`">
          <p class="prod-name-height">{{product.name}}</p>
        </router-link>
        <h6>${{product.price}}</h6>
      </div>
      <div class="justify-content-center d-flex" style="flex-direction: column">
        <div class="product-meta d-flex justify-content-center">
          <!--<a href="#" class="wishlist-btn"><i class="icon_heart_alt"></i></a>-->
           <a @click="addProductToCart(product)" class="add-to-cart-btn">{{$t('Add to')}}</a>
        </div>
        <div :class="{'hidden':!getProductsCounts[product.id]}" class="d-flex justify-content-center">
          <div class="input-group">
            <div style="border-radius: unset;background: #e9ecef" class="form-control text-center border-0">{{ $t('in cart', { count: getProductsCounts[product.id] }) }}</div>
            <div class="input-group-append">
              <button @click="remove(product.id,$event.target)" style="border-radius: unset;background: #CCCCCC;cursor: pointer" class="input-group-text border-0" id="basic-addon2">&#x2716;</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import { mapGetters,mapActions } from 'vuex';

  export default {
    name: 'single-product',
    props: ['product'],
    computed: {
      ...mapGetters([
        'getProductsCounts',
      ]),
    },
    data() {
      return {
      }
    },
    methods: {
      ...mapActions([
        'addProduct',
        'removeProduct',
      ]),
      addProductToCart(product) {
        this.addProduct(product);
      },
      remove(index,target) {
        this.removeProduct(index);
        target.parent().parent().parent().hide();
      },
    }
  };
</script>
<style scoped>
  .single-product-area .product-img {
    /*width: 100%;height: 300px;*/
    /*background: #ffffff;*/
  }
  .add-to-cart-btn{
    cursor: pointer;
  }
  .prod-name-height{
    height: 4em;
  }
  @media only screen and (max-width: 960px) {
    .prod-name-height{
      height: 5em;
    }
  }
  @media only screen and (max-width: 576px) {
    .single-product-area .product-img {
      width: 100%;
      min-height: 100px;
      height: auto;
    }
  }
  .hidden{
    visibility: hidden;
  }
</style>