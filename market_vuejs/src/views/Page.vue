<template>
  <div>
    <div class="breadcrumb-area">
      <!-- Top Breadcrumb Area -->
      <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" :style="`background-image: url(${page.image_name})`">
        <h2>{{page.title}}</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> {{$t('Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{page.title}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <section class="section-padding-0-100">
      <div class="container">
        <div v-html="page.content"></div>
      </div>
    </section>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        page:[]
      };
    },
    created() {
      this.getPage();
    },
    methods: {
      getPage() {
        this.$http.get(this.$ApiHost+'/api/get-page?slug='+this.$route.params.slug)
            .then( (response) =>{
              this.page = response.data['page']
              window.document.title = this.page.title + this.$Project_seotitle[this.$i18n.locale];
            });
      }
    },
    watch: {
      '$route.params.slug': function () {
        this.getPage()
      }
    }
  };
</script>