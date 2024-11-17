<template>
  <div>
    <div class="breadcrumb-area">
      <!-- Top Breadcrumb Area -->
      <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(/img/bg-img/24.jpg);">
        <h2>{{$t('Tags')}}</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> {{$t('Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$t('Tags')}}</li>
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
        <li v-for="tag in tags"><router-link :to="`/${$i18n.locale}/tag/${tag.slug}`">{{tag.name}}</router-link></li>
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
          <!-- Single Product Area -->
          <div v-for="product in products" class="col-12 col-sm-6 col-lg-3">
            <single-product :product="product"></single-product>
          </div>

        </div>
          <nav v-if="pagination.last_page > 1" aria-label="Page navigation">
            <ul class="pagination">
              <li v-if="pagination.current_page != 1" v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" @click="paginateProducts(pagination.current_page-1)"><i class="fa fa-angle-left"></i></a></li>
              <li v-for="page in pagination.pages_list" class="page-item" v-bind:class="[{'disabled': page == pagination.current_page}]"><a v-bind:class="[{'active': page == pagination.current_page}]" class="page-link text-dark" @click="paginateProducts(page)">{{ page }}</a></li>
              <li v-if="pagination.current_page != pagination.last_page" v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" @click="paginateProducts(pagination.current_page+1)"><i class="fa fa-angle-right"></i></a></li>
            </ul>
          </nav>
      </div>
      </div>
    </div>

  </div>
</template>
<script>
  import SingleProduct from '@/components/SingleProduct.vue'
  import Tag from './Tag.vue'
  export default {
    data() {
      return {
        products:[],
        tags:[],
        pagination:{},
      };
    },
    components: {
      Tag,
      SingleProduct
    },
    created() {
      if(this.$route.query){
        let queryString = $.param(this.$route.query);
        this.getTags(this.$ApiHost+'/api/get-tags?'+queryString);
      }else {
        this.getTags();
      }
    },
    methods: {
      getTags(page_url) {
        page_url = page_url || this.$ApiHost+'/api/get-tags';
        this.$http.get(page_url)
            .then( (response) =>{
              this.tags = response.data['tags']
              this.products = response.data['products']['data']
              let pagination = {
                current_page: response.data['products']['current_page'],
                last_page: response.data['products']['last_page'],
                total: response.data['products']['total'],
                from: response.data['products']['from'],
                to: response.data['products']['to'],
                per_page: response.data['products']['per_page'],
                next_page_url: response.data['products']['next_page_url'],
                prev_page_url: response.data['products']['prev_page_url'],
              };
              this.pagination = pagination;
              this.pagination.pages_list =[];
              for(var i = Math.max(pagination.current_page-2,1); i <= Math.min(Math.max(pagination.current_page-2,1)+4,pagination.last_page);i++){
                this.pagination.pages_list.push(i)
              }
            });
      },
      paginateProducts(page_url) {
        let query = {
          page: page_url,
        };
        this.$router.push({ query: query })
      },
    },
    watch: {
      '$route.query': function () {
        if(this.$route.query){
          let queryString = $.param(this.$route.query);
          this.getTags(this.$ApiHost+'/api/get-tags?'+queryString);
        }else {
          this.getTags();
        }
      }
    }
  };
</script>
<style scoped>
</style>