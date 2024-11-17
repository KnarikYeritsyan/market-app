<template>
  <div>
    <div class="breadcrumb-area">
      <!-- Top Breadcrumb Area -->
      <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(/img/bg-img/24.jpg);">
        <h2>{{$t('Shop')}}</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> {{$t('Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$t('Shop')}}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <section class="shop-page section-padding-0-100">
      <div class="container">
        <div class="row">
          <!-- Shop Sorting Data -->
          <div class="col-12">
            <div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
              <!-- Shop Page Count -->
              <div class="shop-page-count">
                <p>{{ $t('Showing', { from: pagination.from, to: pagination.to, total: pagination.total }) }}</p>
              </div>
              <!-- Search by Terms -->
              <div class="search_by_terms">
                <div class="form-inline">
                  {{$t('Sort by')}}:
                  <select @change="sortProducts($event)" name="sort_by" class="custom-select widget-title">
                    <option value="created_at:desc" :selected="$route.query.sort_by == 'created_at:desc'">{{$t('date_added')}}</option>
                    <option value="price:asc" :selected="$route.query.sort_by == 'price:asc'">{{$t('price_low')}}</option>
                    <option value="price:desc" :selected="$route.query.sort_by == 'price:desc'">{{$t('price_high')}}</option>
                    <option value="name:asc" :selected="$route.query.sort_by == 'name:asc'">{{$t('Name_pr')}}</option>
                  </select>
                  <span class="ml-4">{{$t('Show Items')}}:</span>
                  <select @change="showProducts($event)" name="show_items" class="custom-select widget-title">
                    <option value="5" :selected="$route.query.show_items == '5'">5</option>
                    <option value="9" :selected="$route.query.show_items == '9'">9</option>
                    <option value="12" :selected="$route.query.show_items == '12'">12</option>
                    <option value="18" :selected="$route.query.show_items == '18'">18</option>
                    <option value="24" :selected="$route.query.show_items == '24'">24</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <!-- Sidebar Area -->
          <div class="col-12 text-center mb-2">
          <a class="btn alazea-btn btn-filter">{{$t('Filter')}}</a>
          </div>
          <form id="filter-area" @submit.prevent="filterProducts" class="col-12 col-md-4 col-lg-3">
            <div class="shop-sidebar-area">
              <div class="shop-widget catagory mb-50">
                <h4 class="widget-title">{{$t('Categories')}}</h4>
                <div class="widget-desc">
                  <!-- Single Checkbox -->
                  <div v-for="category in categories" class="custom-control custom-checkbox d-flex align-items-center mb-2">
                    <input :value="category.id" name="category[]" type="checkbox" class="custom-control-input" :id="`customCheck${category.id}`">
                    <label class="custom-control-label" :for="`customCheck${category.id}`">{{category.name}} <span class="text-muted">({{category.products_count}})</span></label>
                  </div>
                  <!-- Single Checkbox -->
                </div>
              </div>
              <!-- Shop Widget -->
              <div class="shop-widget price mb-50">
                <h4 class="widget-title">{{$t('Prices')}}</h4>
                <div class="widget-desc">
                  <div class="slider-range">
                    <div id="slider-range-price" data-min="8" data-max="30" data-unit="$" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="399" data-value-max="4000" data-label-result="Price:">
                    </div>
                    <div class="range-price">
                      <div class="form-group row">
                        <label for="from_price" class="col-2 col-form-label">{{$t('from')}}</label>
                        <div class="col-4">
                          <input id="from_price" type="text" class="form-control " name="from_price" value="399">
                        </div>
                        <label for="to_price" class="col-form-label">{{$t('to')}}</label>
                        <div class="col-4">
                          <input id="to_price" type="text" class="form-control" name="to_price" value="4000">
                        </div>
                        <label class="col-form-label">$</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="shop-widget catagory mb-50">
                <h4 class="widget-title">{{$t('Volume')}}</h4>
                <div class="widget-desc">
                  <!-- Single Checkbox -->
                  <div v-for="volume in volumes" class="custom-control custom-checkbox d-flex align-items-center mb-2">
                    <input :value="volume" name="volume[]" type="checkbox" class="custom-control-input" :id="`customCheckvol${volume}`">
                    <label class="custom-control-label" :for="`customCheckvol${volume}`">{{volume}}</label>
                  </div>
                  <!-- Single Checkbox -->
                </div>
              </div>
              <div class="shop-widget catagory mb-50">
                <h4 class="widget-title">{{$t('Aroma')}}</h4>
                <div class="widget-desc">
                  <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                    <input value="universal" name="aroma[]" type="checkbox" class="custom-control-input" id="customCheckaroma">
                    <label class="custom-control-label" for="customCheckaroma">{{$t('Universal')}}</label>
                  </div>
                </div>
              </div>
              <div class="shop-widget catagory mb-50">
                <h4 class="widget-title">{{$t('For Who')}}</h4>
                <div class="widget-desc">
                  <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                    <input value="woman" name="type[]" type="checkbox" class="custom-control-input" id="customCheckforwoman">
                    <label class="custom-control-label" for="customCheckforwoman">{{$t('Woman')}}</label>
                  </div>
                  <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                    <input value="man" name="type[]" type="checkbox" class="custom-control-input" id="customCheckformen">
                    <label class="custom-control-label" for="customCheckformen">{{$t('Man')}}</label>
                  </div>
                  <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                    <input value="unisex" name="type[]" type="checkbox" class="custom-control-input" id="customCheckforuni">
                    <label class="custom-control-label" for="customCheckforuni">{{$t('Unisex')}}</label>
                  </div>
                </div>
              </div>
              <div class="col-12 text-center mb-2">
                <button type="submit" class="btn alazea-btn">{{$t('Search_n')}}</button>
              </div>

            </div>
          </form>

          <!-- All Products Area -->
          <div class="col-12 col-md-8 col-lg-9">
            <div class="shop-products-area">
              <div v-if="products" class="row justify-content-center">
                <!-- Single Product Area -->
                <div v-for="product in products" class="col-8 col-md-6 col-sm-6 col-lg-4">
                  <single-product :product="product"></single-product>
                </div>

              </div>

              <!-- Pagination -->
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
    </section>
  </div>
</template>
<script>
  require('../../public/js/plugins/jquery-ui')
  import SingleProduct from '@/components/SingleProduct.vue'
  export default {
    components: {
      SingleProduct
    },
    data() {
      return {
        is_cat: false,
        products:[],
        categories:[],
        volumes:[50,100,75,70,125,90,7.5,80],
        pagination:{},
      };
    },
    beforeCreate() {
    },
    created() {
      // console.log(this.$route)
      if(this.$route.query){
        let queryString = $.param(this.$route.query);
        this.getProducts(this.$ApiHost+'/api/get-products?'+queryString);
      }else {
        this.getProducts();
      }
      $( document ).ready(function() {
        $('.btn-filter').click(function () {
          $('#filter-area').toggle()
        })
        var min_val = $('#slider-range-price').data('value-min');
        var max_val = $('#slider-range-price').data('value-max');
          $('#slider-range-price').slider({
            range: true,
            min: 150,
            max: 10000,
            values: [min_val, max_val],
            slide: function (event, ui) {
              $('#from_price').val(ui.values[0])
              $('#to_price').val(ui.values[1])
            }
          });
      })
    },
    methods: {
      getProducts(page_url) {
        page_url = page_url || this.$ApiHost+'/api/get-products';
        this.$http.get(page_url)
            .then( (response) =>{
              this.products = response.data['products']['data']
              this.categories = response.data['categories']
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
        // this.$router.replace({ query: {page: page_url} })
        let query = {
          page: page_url,
          show_items: this.$route.query.show_items,
          sort_by: this.$route.query.sort_by
        };
        this.$router.push({ query: query })
      },
      sortProducts(event) {
        let query = {
          // page: this.$route.query.page,
          show_items: this.$route.query.show_items,
          sort_by: event.target.value
        };
        this.$router.push({ query: query })
      },
      showProducts(event) {
        let query = {
          // page: this.$route.query.page,
          show_items: event.target.value,
          sort_by: this.$route.query.sort_by,
        };
        this.$router.push({ query: query })
      },
      filterProducts() {
        let querystring = $('#filter-area').serialize();
        this.$router.push({ path: `/${this.$i18n.locale}/shop/search?${querystring}` })
      }
    },
    watch: {
      '$route.query': function () {
        if(this.$route.query){
          let queryString = $.param(this.$route.query);
          this.getProducts(this.$ApiHost+'/api/get-products?'+queryString);
        }else {
          this.getProducts();
        }
      }
    }
  };
</script>
<style scoped>
  .btn-filter{
    display: none;
  }
  @media only screen and (max-width: 767px) {
    .btn-filter{
      display: inline-block;
    }
    #filter-area{
      display: none;
    }
  }
</style>