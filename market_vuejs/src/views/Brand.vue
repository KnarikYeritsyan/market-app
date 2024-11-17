<template>
  <div>
    <div class="breadcrumb-area">
      <!-- Top Breadcrumb Area -->
      <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(/img/bg-img/24.jpg);">
        <h2>{{brand.name}}</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> {{$t('Home')}}</a></li>
                <li class="breadcrumb-item"><router-link :to="`/${$i18n.locale}/brands`">{{$t('Brands')}}</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{brand.name}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="related-products-area pb-4">
      <div class="container">
        <div v-if="products.length > 0" class="row">
          <div class="col-12">
            <!-- Section Heading -->
            <div class="section-heading text-center">
              <h2>{{$t('Products')}}</h2>
            </div>
          </div>
        </div>
        <div class="shop-products-area">
          <div v-if="products.length > 0" class="row justify-content-center">
            <!-- Single Product Area -->
            <div v-for="product in products" class="col-8 col-md-4 col-sm-6 col-lg-3">
              <single-product :product="product"></single-product>
            </div>

          </div>
            <div v-html="brand.description"></div>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
  import SingleProduct from '@/components/SingleProduct.vue'
  export default {
    components: {
      SingleProduct
    },
    name: 'Brand',
    data() {
      return {
        brand:[],
        products:[],
      };
    },
    created() {
      this.getBrand();
    },
    methods: {
      getBrand() {
        this.$http.get(this.$ApiHost+'/api/get-brand?slug='+this.$route.params.slug)
            .then( (response) =>{
              this.brand = response.data['brand']
              window.document.title = this.brand.name + this.$Project_seotitle[this.$i18n.locale];
              // this.brands = response.data['brands']
              this.products = response.data['brand']['products']
            });
      }
    },
    watch: {
      '$route.params.slug': function () {
        this.getBrand()
      }
    }
  };
</script>
<style scoped>
</style>