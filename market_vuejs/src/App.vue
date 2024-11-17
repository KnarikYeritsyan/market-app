<template>
  <div id="app">
  <header class="header-area">
    <div class="top-header-area">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="top-header-content d-flex align-items-center justify-content-between">
              <div class="top-header-meta">
                <a href="#" data-toggle="tooltip" data-placement="bottom" :title="settings['contact.email']"><i class="far fa-envelope" aria-hidden="true"></i> <span>{{$t('Email')}}: {{settings['contact.email']}}</span></a>
                <a href="#" data-toggle="tooltip" data-placement="bottom" :title="settings['contact.phone']"><i class="fas fa-phone" aria-hidden="true"></i> <span>{{$t('Call us')}}: {{settings['contact.phone']}}</span></a>
              </div>
              <div class="top-header-meta d-flex">
                <img :src="`/img/lang/${$i18n.locale}.png`" width="30px" height="20x">
                <div class="language-dropdown">
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle mr-30" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$i18n.locale.toUpperCase()}}</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a v-for="(lang, i) in langs" @click.prevent="setlocale(lang)" class="dropdown-item" :class="{'adisabled':($i18n.locale === lang)}" href="#">{{ lang.toUpperCase() }}</a>
                    </div>
                  </div>
                </div>
                <div v-if="!isLoggedIn" class="login">
                  <router-link :to="`/${$i18n.locale}/login`"><i class="fa fa-user" aria-hidden="true"></i> <span>{{$t('Login')}}</span></router-link>
                </div>
                <div class="cart">
                  <router-link :to="`/${$i18n.locale}/cart`"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>{{$t('Cart')}} <span v-if="hasProduct()" class="cart-quantity">({{ getProductsInCart.length }})</span></span></router-link>
                </div>
                <div v-if="isLoggedIn">
                <div class="language-dropdown logout-dropdown">
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle ml-30" type="button" id="dropdownlogoutButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$t('user')}}</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownlogoutButton">
                      <a class="dropdown-item" @click="logout">
                        {{$t('Logout')}}
                      </a>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="alazea-main-menu">
      <div class="classy-nav-container breakpoint-off">
        <div class="container">
          <nav class="classy-navbar justify-content-between" id="alazeaNav">
            <router-link :to="`/${$i18n.locale}`" class="nav-brand"><img :src="$ApiHost+settings['site.logo']" alt=""></router-link>
            <div class="classy-navbar-toggler">
              <span class="navbarToggler"><span></span><span></span><span></span></span>
            </div>
            <div class="classy-menu">
              <div class="classycloseIcon">
                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
              </div>
              <div class="classynav">
                <ul>
                    <li v-for="men in menu">
                        <a v-if="men.children.length > 0" href="#">{{men.title}}</a>
                        <ul v-if="men.children.length > 0" class="dropdown">
                            <li v-for="child in men.children">
                                <router-link :to="`/${$i18n.locale}${(child.slug != '/home')?child.slug:''}`">{{child.title}}</router-link>
                                <ul v-if="child.children.length > 0" class="dropdown">
                                    <li v-for="grandchild in child.children">
                                        <router-link v-if="grandchild.children.length == 0" :to="`/${$i18n.locale}${(grandchild.slug != '/home')?grandchild.slug:''}`">{{grandchild.title}}</router-link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <router-link v-else :to="`/${$i18n.locale}${(men.slug != '/home')?men.slug:''}`">{{men.title}}</router-link>
                    </li>
                </ul>
                <div id="searchIcon">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </nav>
          <div class="search-form">
            <form id="search-area" @submit.prevent="searchProducts">
              <input type="search" name="search" id="search-term" :placeholder="$t('Find in catalog')">
              <button type="submit" class="btn btn-info float-right mt-2">{{$t('Search')}}</button>
            </form>
            <div class="closeIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
          </div>
        </div>
      </div>
    </div>
  </header>
    <router-view></router-view>
    <footer class="footer-area bg-img" style="background-image: url(/img/bg-img/3.jpg);">
      <div class="main-footer-area">
        <div class="container">
          <div class="row">
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="single-footer-widget">
                <div class="footer-logo mb-30">
                  <router-link :to="`/${$i18n.locale}`"><img :src="$ApiHost+settings['site.logo']" alt=""></router-link>
                </div>
                <p>{{$t('footer_text')}}</p>
                <div class="social-info">
                  <a target="_blank" v-for="item in social_items" :href="item.link">
                    <!--<i class="" :class="`fab fa-${item.type}`" aria-hidden="true"></i>-->
                    <i class="" :class="{'fab': item.type != 'envelope','fa': item.type == 'envelope',['fa-'+item.type]:true}" aria-hidden="true"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="single-footer-widget">
                <div class="widget-title">
                  <h5>{{$t('QUICK LINK')}}</h5>
                </div>
                <nav class="widget-nav">
                  <ul>
                    <li v-for="menu in footer_links">
                      <a target="_blank" v-if="menu.group == 'custom_link'" :href="menu.url">{{menu.title}}</a>
                      <router-link v-else :to="`/${$i18n.locale}${menu.slug}`">{{menu.title}}</router-link>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="single-footer-widget random-products">
                <div class="widget-title">
                  <h5>{{$t('OUR PRODUCTS')}}</h5>
                </div>
                <div v-for="product in random_products" class="single-best-seller-product d-flex align-items-center">
                  <div class="product-thumbnail">
                    <router-link :to="`/${$i18n.locale}${product.slug}`"><img :src="product.image_name" :alt="product.name"></router-link>
                  </div>
                  <div class="product-info">
                    <router-link :to="`/${$i18n.locale}${product.slug}`">{{product.name}}</router-link>
                    <p>${{product.price}}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="single-footer-widget">
                <div class="widget-title">
                  <h5>{{$t('CONTACT')}}</h5>
                </div>
                <div class="contact-information">
                  <p><span>{{$t('Address')}}:</span> {{settings['contact.address']}}</p>
                  <p><span>{{$t('Phone')}}:</span> {{settings['contact.phone']}}</p>
                  <p><span>{{$t('Email')}}:</span> {{settings['contact.email']}}</p>
                  <p><span>{{$t('Open hours')}}:</span> {{settings['contact.open_hours']}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom-area">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="border-line"></div>
            </div>
            <div class="col-12 col-md-6">
              <div class="copywrite-text">
                <p>&copy;
                  Copyright &copy; {{year}} All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                </p>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="footer-nav">
                <nav>
                  <ul>
                    <li v-for="menu in footer_menu"><a v-if="menu.group == 'custom_link'" target="_blank" :href="menu.url">{{menu.title}}</a><router-link v-else :to="`/${$i18n.locale}${menu.slug}`">{{menu.title}}</router-link></li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>

  </div>
</template>

<script>
    import '../public/js/bootstrap/bootstrap.min'
    import Menu from '@/components/Menu.vue'
    import { mapGetters } from 'vuex';

    export default {
  components: {
    Menu
  },
  data () {
    return {
      langs: ['en', 'ru', 'am'],
      year: new Date().getFullYear(),
      slider: "",
      settings:'',
      menu:[],
      footer_menu:[],
      footer_links:[],
      social_items:[],
      random_products:[],
    }
  },
  beforeCreate() {
    // require('../public/js/bootstrap/bootstrap.min');
    this.$http.get(this.$ApiHost+'/api/settings')
        .then( (response) =>{
          this.settings = response.data['settings']
          this.footer_menu = response.data['footer_menu']
          this.footer_links = response.data['footer_links']
          this.menu = response.data['menu']
          this.social_items = response.data['social_items']
          $( document ).ready(function() {
            if ($.fn.classyNav) {
              $('#alazeaNav').classyNav();
            }
          })
        });
    this.$http.get(this.$ApiHost+'/api/two-random-products')
        .then( (response) =>{
          this.random_products = response.data['products']
        });
    require('../public/js/plugins/classy-nav')
    require('../public/js/plugins/sticky')
    require('../public/js/plugins/scrollup')
    require('../public/js/active')
  },
  mounted() {
    // require('../public/js/plugins/classy-nav')
    // require('../public/js/plugins/sticky')
    // require('../public/js/plugins/scrollup')
    // require('../public/js/active')
  },
  computed: {
    ...mapGetters([
      'getProductsInCart',
    ]),
    isLoggedIn: function () {
      return this.$store.getters.isLoggedIn;
    }
  },
  methods: {
    navbarclass:function () {
      $( document ).ready(function() {
        if ($.fn.classyNav) {
          $('#alazeaNav').classyNav();
        }
      })
    },
    hasProduct() {
      return this.getProductsInCart.length > 0;
    },
    searchProducts() {
      let querystring = $('#search-term').val();
      if(querystring) {
        $('.search-form').removeClass('active');
        this.$router.push({path: `/${this.$i18n.locale}/product/search/${querystring}`})
      }
    },
    stripTrailingSlash: function(str) {
      return str.replace(/\/$/, '')
    },
    logout: function () {
      this.$store.dispatch('logout').then(() => {
        this.$router.push('/'+this.$i18n.locale+'/login');
      });
    },
    setlocale(locale){
      this.$i18n.locale = locale;
      this.$router.push({
        params:{lang:locale}
      })
      window.location.href = this.stripTrailingSlash(location.href);
    },
    getCat: function () {
      this.$http.get(this.$ApiHost+'/api/settings')
          .then( (response) =>{
            this.settings = response.data['settings']
            this.footer_menu = response.data['footer_menu']
            this.footer_links = response.data['footer_links']
            this.menu = response.data['menu']
            this.social_items = response.data['social_items']
            $( document ).ready(function() {
              if ($.fn.classyNav) {
                $('#alazeaNav').classyNav();
              }
            })
          });
    }
  }
}
</script>

<style scoped>
    .adisabled{
        pointer-events: none;
    }
  .random-products img{
    height: 90px;
    width: 70px;
  }
</style>
