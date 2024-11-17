<template>
  <div>
  <section class="hero-area">
    <div class="hero-post-slides owl-carousel">
      <div v-for="slider in sliders" class="single-hero-post bg-overlay">
        <div class="slide-img bg-img" :style="`background-image: url(${slider.image_name})`"></div>
        <div class="container h-100">
          <div class="row h-100 align-items-center">
            <div class="col-12">
              <div class="hero-slides-content text-center">
                <h2>{{ slider.title }}</h2>
                <p>{{slider.description}}</p>
                <div class="welcome-btn-group">
                  <router-link :to="`/${$i18n.locale}/shop`" class="btn alazea-btn mr-30">{{$t('GET STARTED')}}</router-link>
                  <router-link :to="`/${$i18n.locale}/contact`" class="btn alazea-btn active">{{$t('CONTACT US')}}</router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
    <section class="our-services-area bg-gray section-padding-100-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <!-- Section Heading -->
            <div class="section-heading text-center">
              <h2>{{slider.name}}</h2>
              <h2>OUR SERVICES</h2>
              <p>We provide the perfect service for you.</p>
            </div>
          </div>
        </div>

        <div class="row justify-content-between">
          <div class="col-12 col-lg-5">
            <div class="alazea-service-area mb-100">

              <!-- Single Service Area -->
              <div class="single-service-area d-flex align-items-center wow fadeInUp" data-wow-delay="100ms">
                <!-- Icon -->
                <div class="service-icon mr-30">
                  <img src="/img/core-img/s1.png" alt="">
                </div>
                <!-- Content -->
                <div class="service-content">
                  <h5>Plants Care</h5>
                  <p>In Aenean purus, pretium sito amet sapien denim moste consectet sedoni urna placerat sodales.service its.</p>
                </div>
              </div>

              <!-- Single Service Area -->
              <div class="single-service-area d-flex align-items-center wow fadeInUp" data-wow-delay="300ms">
                <!-- Icon -->
                <div class="service-icon mr-30">
                  <img src="/img/core-img/s2.png" alt="">
                </div>
                <!-- Content -->
                <div class="service-content">
                  <h5>Pressure Washing</h5>
                  <p>In Aenean purus, pretium sito amet sapien denim moste consectet sedoni urna placerat sodales.service its.</p>
                </div>
              </div>

              <!-- Single Service Area -->
              <div class="single-service-area d-flex align-items-center wow fadeInUp" data-wow-delay="500ms">
                <!-- Icon -->
                <div class="service-icon mr-30">
                  <img src="/img/core-img/s3.png" alt="">
                </div>
                <!-- Content -->
                <div class="service-content">
                  <h5>Tree Service &amp; Trimming</h5>
                  <p>In Aenean purus, pretium sito amet sapien denim moste consectet sedoni urna placerat sodales.service its.</p>
                </div>
              </div>

            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="alazea-video-area bg-overlay mb-100">
              <img src="/img/bg-img/23.jpg" alt="">
              <a href="http://www.youtube.com/watch?v=7HKoqNJtMTQ" class="video-icon">
                <i class="fa fa-play" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
      <section v-for="tag in tags" v-if="tag.products_4.length > 0" class="new-arrivals-products-area bg-gray section-padding-0-100">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <div class="section-heading text-center">
                          <h2>{{tag.name}}</h2>
                          <!--<p>We have the latest products, it must be exciting for you</p>-->
                      </div>
                  </div>
              </div>
              <div class="row text-center mb-5 justify-content-center">
              <div id="owl-demo" class="owl-carousel owl-theme col-8 col-md-12 col-sm-12 col-lg-12 owl-demo">
                  <div v-for="(product, index) in tag.products_4" class="item">
                      <div>
                          <single-product :product="product"></single-product>
                      </div>
                  </div>
              </div>
              </div>

              <div class="row" style="margin-top: -80px">
                  <div class="col-12 text-center">
                      <router-link :to="`/${$i18n.locale}/tag/${tag.slug}`" class="btn alazea-btn">{{$t('View All')}}</router-link>
                  </div>
              </div>
          </div>
      </section>
      <section class="alazea-portfolio-area section-padding-100-0">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <!-- Section Heading -->
                      <div class="section-heading text-center">
                          <h2>OUR PORTFOLIO</h2>
                          <p>We devote all of our experience and efforts for creation</p>
                      </div>
                  </div>
              </div>
          </div>

      </section>
  </div>
</template>

<script>
  import SingleProduct from '@/components/SingleProduct.vue'
  export default {
    components: {
      SingleProduct
    },
  name: 'Home',
  data () {
    return {
      slider: "",
      sliders: [],
      tags: []
    }
  },
  mounted(){
    // console.log($('.hero-post-slides'))
    // require('magnific-popup');
    // require('owl.carousel');
    // require('../../public/js/active')
  },
  beforeCreate(){
    // this.getCat();
  },
  created() {
    this.getCat();
    require('magnific-popup');
    require('owl.carousel');
    // require('../../public/js/bootstrap/popper.min');
    // require('../../public/js/bootstrap/bootstrap.min');
    // require('../../public/js/plugins/imagesLoaded')
    // require('../../public/js/active')
      $( document ).ready(function() {
        if ($.fn.magnificPopup) {
          $('.portfolio-img, .product-img1').magnificPopup({
            gallery: {
              enabled: true
            },
            type: 'image',
          });
          $('.video-icon').magnificPopup({
            type: 'iframe'
          });
        }
    });
  },
  methods: {
    getCat: function () {
      this.$http.get(this.$ApiHost+'/api/sliders')
          .then( (response) =>{
            this.sliders = response.data['sliders']
            $( document ).ready(function() {
              if ($.fn.owlCarousel) {
                $(".hero-post-slides").owlCarousel({
                  items: 1,
                  margin: 0,
                  loop: true,
                  nav: false,
                  dots: false,
                  autoplay: true,
                  center: true,
                  autoplayTimeout: 5000,
                  smartSpeed: 1000
                });
              }
            })
            // console.log(response.data)
          });
      this.$http.get(this.$ApiHost+'/api/tag-products')
          .then( (response) =>{
            this.tags = response.data['tags']
            $( document ).ready(function() {
              $(".owl-demo").owlCarousel({
                pagination : false,
                margin: 30,
                nav: true,
                dots: false,
                navText: [
                    '<a class="carousel-control-prev w-auto">' +
                    '   <span style="padding: 15px" class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>' +
                    '</a>',
                  '<a class="carousel-control-next w-auto">' +
                    '   <span style="padding: 15px" class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>' +
                    '</a>'
                ],
                responsiveRefreshRate: true,
                responsiveClass: true,
                responsive : {
                  0 : {
                    items: 1
                  },
                  576 : {
                    items: 2
                  },
                  767 : {
                    items: 3
                  },
                  992 : {
                    items: 4
                  },
                  1200 : {
                    items: 4
                  },
                  1920 : {
                    items: 6
                  }
                }
              });

              $('#myCarousel').carousel({
                interval: false,
                // wrap:false
              })
              $('.carousel .carousel-item').each(function() {
                var minPerSlide = 4;
                var next = $(this).next();
                if (!next.length) {
                  next = $(this).siblings(':first');
                }
                next.children(':first-child').clone().appendTo($(this));
                for (var i = 0; i < minPerSlide; i++) {
                  next = next.next();
                  if (!next.length) {
                    next = $(this).siblings(':first');
                  }
                  next.children(':first-child').clone().appendTo($(this));
                }
              });
            })
            // console.log(this.tags)
          });
      this.$http.get(this.$ApiHost+'/api/getcategories')
          .then( (response) =>{
          });
    }
  }
}
</script>
<style scoped>
    @media (min-width: 768px) {

        .carousel-inner .carousel-item-right.active,
        .carousel-inner .carousel-item-next {
            transform: translateX(50%);
        }

        .carousel-inner .carousel-item-left.active,
        .carousel-inner .carousel-item-prev {
            transform: translateX(-50%);
        }
    }

    /* large - display 3 */
    @media (min-width: 992px) {

        .carousel-inner .carousel-item-right.active,
        .carousel-inner .carousel-item-next {
            transform: translateX(25%);
        }

        .carousel-inner .carousel-item-left.active,
        .carousel-inner .carousel-item-prev {
            transform: translateX(-25%);
        }
    }

    @media (max-width: 767px) {
        .carousel-inner .carousel-item>div {
            display: none;
        }

        .carousel-inner .carousel-item>div:first-child {
            display: block;
        }
    }

    .carousel-inner .carousel-item.active,
    .carousel-inner .carousel-item-next,
    .carousel-inner .carousel-item-prev {
        display: flex;
    }

    .carousel-inner .carousel-item-right,
    .carousel-inner .carousel-item-left {
        transform: translateX(0);
    }
</style>
