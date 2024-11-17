<template>
  <div>
    <div class="breadcrumb-area">
      <!-- Top Breadcrumb Area -->
      <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(/img/bg-img/24.jpg);">
        <h2>{{product.name}}</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> {{$t('Home')}}</a></li>
                <li class="breadcrumb-item"><router-link :to="`/${$i18n.locale}/shop`">{{$t('Shop')}}</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{product.name}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <section class="single_product_details_area mb-50">
      <div class="produts-details--content mb-50">
        <div class="container">
          <div class="row justify-content-between">

            <div class="col-12 col-md-6 col-lg-5">
              <div class="single_product_thumb">
                <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <a class="product-img product-img1" :href="product.image_name" title="Product Image">
                        <img class="d-block w-100" :src="product.image_name" :alt="product.name">
                      </a>
                    </div>
                    <div v-for="image in images" class="carousel-item">
                      <a class="product-img product-img1" :href="image.image_name" title="Product Image">
                        <img class="d-block w-100" :src="image.image_name" :alt="product.name">
                      </a>
                    </div>
                  </div>
                  <ol class="carousel-indicators">
                    <li class="active" data-target="#product_details_slider" data-slide-to="0" :style="`background-image: url(${product.image_name})`">
                    </li>
                    <li v-for="(image, index) in images" data-target="#product_details_slider" :data-slide-to="index+1" :style="`background-image: url(${image.image_name})`">
                    </li>
                  </ol>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="single_product_desc">
                <h4 class="title">{{product.name}}</h4>
                <h4 class="price">${{product.price}}</h4>
                <div class="short_overview">
                  <div v-html="product.description"></div>
                </div>

                <div class="cart--area d-flex flex-wrap align-items-center">
                  <!-- Add to Cart Form -->
                  <form @submit.prevent="addProductToCart" class="cart clearfix d-flex align-items-center" method="post">
                    <div class="quantity">
                      <span class="qty-minus" @click="valueDown"><i class="fa fa-minus" aria-hidden="true"></i></span>
                      <input type="number" class="qty-text" v-on:change="changeCount($event.target.value)" id="qty" step="1" min="1" max="12" name="quantity" value="1">
                      <span class="qty-plus" @click="valueUp"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
                    <button type="submit" name="addtocart" value="5" class="btn alazea-btn ml-15">{{$t('Add to cart')}}</button>
                  </form>
                </div>

                <div class="products--meta">
                  <p><span>{{$t('SKU')}}:</span> <span>{{product.id}}</span></p>
                  <p><span>{{$t('Category')}}:</span> <span>{{category.name}}</span></p>
                  <p><span>{{$t('Tag')}}:</span> <span>{{product.tag.name}} </span></p>
                  <p>
                    <span>{{$t('Share on')}}:</span>
                    <span>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-pinterest"></i></a>
                                    <a href="#"><i class="fab fa-google-plus"></i></a>
                                </span>
                  </p>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="product_details_tab clearfix">
              <!-- Tabs -->
              <ul class="nav nav-tabs" role="tablist" id="product-details-tab">
                <li class="nav-item">
                  <a href="#description" class="nav-link active" data-toggle="tab" role="tab">Description</a>
                </li>
                <li class="nav-item">
                  <a href="#addi-info" class="nav-link" data-toggle="tab" role="tab">Additional Information</a>
                </li>
                <li class="nav-item">
                  <a href="#reviews" class="nav-link" data-toggle="tab" role="tab">Reviews <span class="text-muted">(1)</span></a>
                </li>
              </ul>
              <!-- Tab Content -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade show active" id="description">
                  <div class="description_area">
                    <p>Sed a facilisis orci. Curabitur magna urna, varius placerat placerat sodales, pretium vitae orci. Aliquam erat volutpat. Cras sit amet suscipit magna. Quisque turpis odio, facilisis vel eleifend eu, dignissim ac odio.</p>
                    <p>Interdum et malesuada fames ac ante ipsum primis in faucibus. In scelerisque augue at the moment mattis. Proin vitae arcu sit amet justo sollicitudin tincidunt sit amet ut velit.Proin placerat vel augue eget euismod. Phasellus cursus orci eu tellus vestibulum, vestibulum urna accumsan. Vestibulum ut ullamcorper sapien. Pellentesque molestie, est ac vestibulum eleifend, lorem ipsum mollis ipsum.</p>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="addi-info">
                  <div class="additional_info_area">
                    <p>What should I do if I receive a damaged parcel?
                      <br> <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit impedit similique qui, itaque delectus labore.</span></p>
                    <p>I have received my order but the wrong item was delivered to me.
                      <br> <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quam voluptatum beatae harum tempore, ab?</span></p>
                    <p>Product Receipt and Acceptance Confirmation Process
                      <br> <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum ducimus, temporibus soluta impedit minus rerum?</span></p>
                    <p>How do I cancel my order?
                      <br> <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum eius eum, minima!</span></p>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="reviews">
                  <div class="reviews_area">
                    <ul>
                      <li>
                        <div class="single_user_review mb-15">
                          <div class="review-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span>for Quality</span>
                          </div>
                          <div class="review-details">
                            <p>by <a href="#">Colorlib</a> on <span>12 Sep 2018</span></p>
                          </div>
                        </div>
                        <div class="single_user_review mb-15">
                          <div class="review-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span>for Design</span>
                          </div>
                          <div class="review-details">
                            <p>by <a href="#">Colorlib</a> on <span>12 Sep 2018</span></p>
                          </div>
                        </div>
                        <div class="single_user_review">
                          <div class="review-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span>for Value</span>
                          </div>
                          <div class="review-details">
                            <p>by <a href="#">Colorlib</a> on <span>12 Sep 2018</span></p>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>

                  <div class="submit_a_review_area mt-50">
                    <h4>Submit A Review</h4>
                    <form action="#" method="post">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group d-flex align-items-center">
                            <span class="mr-15">Your Ratings:</span>
                            <div class="stars">
                              <input type="radio" name="star" class="star-1" id="star-1">
                              <label class="star-1" for="star-1">1</label>
                              <input type="radio" name="star" class="star-2" id="star-2">
                              <label class="star-2" for="star-2">2</label>
                              <input type="radio" name="star" class="star-3" id="star-3">
                              <label class="star-3" for="star-3">3</label>
                              <input type="radio" name="star" class="star-4" id="star-4">
                              <label class="star-4" for="star-4">4</label>
                              <input type="radio" name="star" class="star-5" id="star-5">
                              <label class="star-5" for="star-5">5</label>
                              <span></span>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label for="name">Nickname</label>
                            <input type="email" class="form-control" id="name" placeholder="Nazrul">
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label for="options">Reason for your rating</label>
                            <select class="form-control" id="options">
                              <option>Quality</option>
                              <option>Value</option>
                              <option>Design</option>
                              <option>Price</option>
                              <option>Others</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                            <label for="comments">Comments</label>
                            <textarea class="form-control" id="comments" rows="5" data-max-length="150"></textarea>
                          </div>
                        </div>
                        <div class="col-12">
                          <button type="submit" class="btn alazea-btn">Submit Your Review</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div v-if="related_products.length >0" class="related-products-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <!-- Section Heading -->
            <div class="section-heading text-center">
              <h2>{{$t('Related Products')}}</h2>
            </div>
          </div>
        </div>

        <div class="row text-center mb-5 justify-content-center">
          <div id="owl-demo" class="owl-carousel owl-theme col-8 col-md-12 col-sm-12 col-lg-12">
            <div v-for="(product, index) in related_products" class="item">
              <div>
                <single-product :product="product"></single-product>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import { mapActions } from 'vuex';
  import SingleProduct from '@/components/SingleProduct.vue'
  export default {
    components: {
      SingleProduct
    },
    data() {
      return {
        product:[],
        related_products:[],
        category:[],
        images:[]
      };
    },
    beforeCreate() {
      require('magnific-popup');
      require('owl.carousel');
      this.$http.get(this.$ApiHost+'/api/get-product?slug='+this.$route.params.product_slug)
          .then( (response) =>{
            this.product = response.data['product']
            this.category = response.data['product']['category']
            this.images = response.data['product']['images']
            this.related_products = response.data['product']['related_products']
            window.document.title = this.product.name + this.$Project_seotitle[this.$i18n.locale];
            $( document ).ready(function() {
              if ($.fn.magnificPopup) {
                $('.product-img1').magnificPopup({
                  gallery: {
                    enabled: true
                  },
                  callbacks: {
                    open: function() {
                      var mfp = $.magnificPopup.instance;
                      var proto = $.magnificPopup.proto;
                      mfp.next = function() {
                        if(mfp.index < mfp.items.length - 1) {
                          proto.next.call(mfp);
                        } else {
                          // otherwise do whatever you want, e.g. hide "next" arrow
                        }
                      };
                      mfp.prev = function() {
                        if(mfp.index > 0) {
                          proto.prev.call(mfp);
                        }
                      };
                    }
                  },
                  type: 'image',
                });
              }
              $('#product_details_slider').carousel('pause');
              $("#owl-demo").owlCarousel({
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
            });
          });
    },
    methods: {
      getProduct() {
        this.$http.get(this.$ApiHost+'/api/get-product?slug='+this.$route.params.product_slug)
            .then( (response) =>{
              this.product = response.data['product']
              this.category = response.data['product']['category']
              this.images = response.data['product']['images']
              this.related_products = response.data['product']['related_products']
              window.document.title = this.product.name + this.$Project_seotitle[this.$i18n.locale];
              $( document ).ready(function() {
                if ($.fn.magnificPopup) {
                  $('.product-img1').magnificPopup({
                    gallery: {
                      enabled: true
                    },
                    callbacks: {
                      open: function() {
                        var mfp = $.magnificPopup.instance;
                        var proto = $.magnificPopup.proto;
                        mfp.next = function() {
                          if(mfp.index < mfp.items.length - 1) {
                            proto.next.call(mfp);
                          } else {
                            // otherwise do whatever you want, e.g. hide "next" arrow
                          }
                        };
                        mfp.prev = function() {
                          if(mfp.index > 0) {
                            proto.prev.call(mfp);
                          }
                        };
                      }
                    },
                    type: 'image',
                  });
                }
                $('#product_details_slider').carousel('pause');
                $("#owl-demo").owlCarousel({
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
              });
            });
      },
      ...mapActions([
        'addCurrentProduct',
      ]),
      addProductToCart() {
        let prod = {
          'index':this.product.id,
          'count':parseInt($('#qty').val())
        };
        this.addCurrentProduct(prod);
      },
      changeCount(count) {
        if(parseInt(count) && count < 100 && count > 0){
          return true
        }else {
          $('#qty').val(1)
        }
      },
      valueDown(){
        var effect = document.getElementById('qty');
        var qty = effect.value;
        if( !isNaN( qty ) && qty > 1 ) effect.value--;
        effect.dispatchEvent(new Event("change"));
        return false;
      },
      valueUp(){
        var effect = document.getElementById('qty');
        var qty = effect.value; if( !isNaN( qty )) effect.value++;
        effect.dispatchEvent(new Event("change"));
        return false;
      }
    },
    watch: {
      '$route.params.product_slug': function () {
        $('#owl-demo').trigger('destroy.owl.carousel');
        $('#product_details_slider').carousel('pause').carousel(0);
        this.getProduct()
        // $('#owl-demo').trigger('refresh.owl.carousel');
      }
    }
  };
</script>
<style scoped>
  .single-product-area .product-img {
    width: 100%;height: 300px;
  }
  @media only screen and (max-width: 576px) {
    .single-product-area .product-img {
      width: 100%;
      min-height: 100px;
      height: auto;
    }
  }
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>
<style>
  .mfp-counter{
    display: none;
  }
  .mfp-title{
    display: none;
  }
</style>