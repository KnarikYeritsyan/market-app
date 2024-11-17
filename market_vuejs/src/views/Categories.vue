<template>
  <div>
    <div class="breadcrumb-area">
      <!-- Top Breadcrumb Area -->
      <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(/img/bg-img/24.jpg);">
        <h2>{{$t('Categories')}}</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> {{$t('Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$t('Categories')}}</li>
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

              <div v-for="category in categories" class="col-8 col-lg-3 col-md-4">
                <div class="single-blog-post mb-50">
                  <div class="post-thumbnail mb-30 h-100">
                    <router-link :to="`/${$i18n.locale}/shop/${category.slug}`"><img :src="category.image_name_resize" :alt="category.name"></router-link>
                  </div>
                  <div class="post-content">
                    <router-link :to="`/${$i18n.locale}/shop/${category.slug}`" class="post-title">
                      <h5>{{category.name}}</h5>
                    </router-link>
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
        categories:[],
      };
    },
    created() {
      this.getBrands();
    },
    methods: {
      getBrands() {
        this.$http.get(this.$ApiHost+'/api/get-categories')
            .then( (response) =>{
              this.categories = response.data['categories']
            });
      }
    }
  };
</script>