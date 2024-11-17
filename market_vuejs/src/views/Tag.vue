<template>
  <div>
    <div class="breadcrumb-area">
      <!-- Top Breadcrumb Area -->
      <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(/img/bg-img/24.jpg);">
        <h2>{{tag.name}}</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> {{$t('Home')}}</a></li>
                <li class="breadcrumb-item"><router-link :to="`/${$i18n.locale}/tags`">{{$t('Tags')}}</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{tag.name}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <section class="shop-page section-padding-0-0">
      <div class="container">
        <div class="single-widget-area">
          <!-- Tags -->
          <ol class="popular-tags d-flex flex-wrap">
            <li class="tags-class" v-for="tag in tags"><router-link :class="{'active':tag.slug==$route.params.slug}" :to="`/${$i18n.locale}/tag/${tag.slug}`">{{tag.name}}</router-link></li>
          </ol>
        </div>
      </div>
    </section>
    <div class="related-products-area pb-4">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <!-- Section Heading -->
            <div class="section-heading text-center">
              <h2>{{$t('Products')}}</h2>
            </div>
          </div>
        </div>
        <div class="shop-products-area">
          <div class="row">
            <div v-for="product in products" class="col-12 col-sm-6 col-lg-3">
              <single-product :product="product"></single-product>
            </div>

          </div>
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
    name: 'Tag',
    // props: ['products'],
    data() {
      return {
        products:[],
        tag:[],
        tags:[],
      };
    },
    created() {
      this.getTag();
    },
    methods: {
      getTag() {
        this.$http.get(this.$ApiHost+'/api/get-tag?slug='+this.$route.params.slug)
            .then( (response) =>{
              this.tag = response.data['tag']
              window.document.title = this.tag.name + this.$Project_seotitle[this.$i18n.locale];
              this.tags = response.data['tags']
              this.products = response.data['tag']['products']
            });
      }
    },
    watch: {
      '$route.params.slug': function () {
        this.getTag()
      }
    }
  };
</script>
<style scoped>
</style>