<template>
  <div>
    <div class="breadcrumb-area">
      <!-- Top Breadcrumb Area -->
      <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(/img/bg-img/24.jpg);">
        <h2>{{$t('Brands')}}</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> {{$t('Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$t('Brands')}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <section class="alazea-blog-area mb-100">
      <div class="container">
        <div class="row">
          <div class="col-12 ">
            <div class="row justify-content-center">

              <div v-for="brand in brands" class="col-8 col-lg-3 col-md-4">
                <div class="single-blog-post mb-50">
                  <div class="post-thumbnail mb-30 h-100">
                    <router-link :to="`/${$i18n.locale}/brand/${brand.slug}`"><img :src="brand.image_name_resize" :alt="brand.name"></router-link>
                  </div>
                  <div class="post-content">
                    <router-link :to="`/${$i18n.locale}/brand/${brand.slug}`" class="post-title">
                      <h5>{{brand.name}}</h5>
                    </router-link>
                    <p class="post-excerpt">{{brand.excerpt}}</p>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        brands:[],
      };
    },
    created() {
      this.getBrands();
    },
    methods: {
      getBrands() {
        this.$http.get(this.$ApiHost+'/api/get-brands')
            .then( (response) =>{
              this.brands = response.data['brands']
            });
      }
    }
  };
</script>