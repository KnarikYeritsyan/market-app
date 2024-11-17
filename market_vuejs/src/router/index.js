import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import store from '../store/index.js'
import axios from "axios/index";
import i18n from "../i18n";
import Category from "../views/Category";
import Tag from '../views/Tag.vue';
import Brand from '../views/Brand.vue';
import Product from '../views/Product.vue';

Vue.use(VueRouter)
const title =
  {
    en: 'Online store – My Market Perfume store',
    ru: 'Интернет-магазин – My Market магазин парфюмерии',
    am: 'Առցանց խանութ – My Market Օծանելիքի խանութ',
  };
const routes = [
  {
    path: '/',
    redirect: `/${i18n.locale}`
  },
  {
    path: '/:lang(en|ru|am)?',
    component:{
      render(c){return c('router-view')}
    },
    children:[
      {
        path: '',
        name: 'Home',
        component: Home,
        meta: {
          title: {
            en: 'Perfume online store – My Market Perfume online store',
            ru: 'Интернет-магазин парфюмерии – My Market магазин парфюмерии',
            am: 'Օծանելիքի առցանց խանութ – My Market Օծանելիքի առցանց խանութ',
          },
          metaTags: [
            {
              name: 'description',
              content: 'The home page of our example app.'
            },
            {
              property: 'og:description',
              content: 'The home page of our example app.'
            }
          ]
        }
      },
  {
    path: 'contact',
    name: 'contact',
    component: () => import(/* webpackChunkName: "about" */ '../views/Contact.vue'),
    meta: {
      title: {
        en: 'Contacts – My Market Perfume store',
        ru: 'Контакты – My Market магазин парфюмерии',
        am: 'Կոնտակտներ – My Market Օծանելիքի խանութ',
      },
    }
  },
  {
    path: 'categories',
    name: 'categories',
    component: () => import(/* webpackChunkName: "about" */ '../views/Categories.vue'),
    meta: {
      title: {
        en: 'Online store, categories – My Market Perfume store',
        ru: 'Интернет-магазин, категории – My Market магазин парфюмерии',
        am: 'Առցանց խանութ, կատեգորիաներ – My Market Օծանելիքի խանութ',
      },
    }
  },
  {
    path: 'login',
    name: 'login',
    component: () => import(/* webpackChunkName: "about" */ '@/components/auth/Login.vue'),
    meta: {
      title: {
        en: 'Login – My Market Perfume online store',
        ru: 'Войти – My Market Интернет-магазин парфюмерии',
        am: 'Մուտք – My Market Օծանելիքի առցանց խանութ',
      },
    }
  },
  {
    path: 'product/search/:slug',
    name: 'product-search',
    component: () => import('../views/ProductSearch.vue'),
    meta: {
      title: {
        en: 'Online store – My Market Perfume store',
        ru: 'Интернет-магазин – My Market магазин парфюмерии',
        am: 'Առցանց խանութ – My Market Օծանելիքի խանութ',
      },
    }
  },
  {
    path: 'shop/:slug/:product_slug',
    name: 'product',
    component: Product,
  },
  {
    path: 'shop/search',
    name: 'shop-search',
    component: () => import('../views/ShopSearch.vue'),
    meta: {
      title: {
        en: 'Online store – My Market Perfume store',
        ru: 'Интернет-магазин – My Market магазин парфюмерии',
        am: 'Առցանց խանութ – My Market Օծանելիքի խանութ',
      },
    }
  },
  {
    path: 'shop/:slug',
    name: 'category',
    component: Category,
  },
  {
    path: 'shop',
    name: 'shop',
    component: () => import('../views/Shop.vue'),
    meta: {
      title: {
        en: 'Online store – My Market Perfume store',
        ru: 'Интернет-магазин – My Market магазин парфюмерии',
        am: 'Առցանց խանութ – My Market Օծանելիքի խանութ',
      },
    }
  },
  {
    path: 'cart',
    name: 'cart',
    component: () => import('../views/Cart.vue'),
    meta: {
      title: {
        en: 'Shopping cart – My Market Perfume online store',
        ru: 'Корзина – My Market Интернет-магазин парфюмерии',
        am: 'Զամբյուղ – My Market Օծանելիքի առցանց խանութ',
      },
    }
  },
  {
    path: 'tag/:slug',
    name: 'tag',
    component: Tag,
  },
  {
    path: 'tags',
    name: 'tags',
    component: () => import('../views/Tags.vue'),
    meta: {
      title: {
        en: 'Online store, tags – My Market Perfume store',
        ru: 'Интернет-магазин, теги – My Market магазин парфюмерии',
        am: 'Առցանց խանութ, պիտակներ – My Market Օծանելիքի խանութ',
      },
    }
  },
  {
    path: 'brand/:slug',
    name: 'brand',
    component: Brand,
  },
  {
    path: 'brands',
    name: 'brands',
    component: () => import('../views/Brands.vue'),
    meta: {
      title: {
        en: 'Online store, brands – My Market Perfume store',
        ru: 'Интернет-магазин, бренды – My Market магазин парфюмерии',
        am: 'Առցանց խանութ, ապրանքանիշներ – My Market Օծանելիքի խանութ',
      },
    }
  },
  {
    path: 'register',
    name: 'register',
    component: () => import(/* webpackChunkName: "about" */ '@/components/auth/Register.vue')
  },
  {
    path: ':slug',
    name: 'page',
    component: () => import(/* webpackChunkName: "about" */ '../views/Page.vue')
  },
  {
    path: 'resources',
    name: 'resources',
    component: () => import(/* webpackChunkName: "about" */ '@/components/resources/Resources.vue'),
    meta: {
      requiresAuth: true
    }
  },
  {
    path: 'about',
    name: 'About',
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue'),
    meta: {
      title: {
        en: 'About us – My Market Perfume store',
        ru: 'О компании – My Market магазин парфюмерии',
        am: 'Մեր մասին – My Market Օծանելիքի խանութ',
      },
    },
    children: [
      {
        path: 'nested',
        component: () => import(/* webpackChunkName: "about" */ '../views/Nested.vue'),
        meta: {
          title: 'Nested - About Page - Example App'
        }
      }
    ]
  }
  ]
}
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  let language = to.params.lang;
  if(!language){
    language = 'en';
  }
  i18n.locale = language;
  axios.defaults.headers.common['Content-Language'] = i18n.locale;
  // next();
  if(to.meta.title) {
    window.document.title = to.meta.title && to.meta.title[i18n.locale] ? to.meta.title[i18n.locale] :
        title[i18n.locale];
  }
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const currentUser = store.state.token;
  if(requiresAuth && !currentUser) {
    next('/'+i18n.locale+'/login');
  } else if((to.path == '/login' || to.path == '/'+i18n.locale+'/login') && currentUser) {
    next('/'+i18n.locale);
  } else {
    next();
  }
})
let isRefreshing = false;
axios.interceptors.response.use(null, (error) => {
  // if (error.response.status == 401) {
    if(error.response.status == 401 && error.response.data.message == 'Token is Expired') {
      if (!isRefreshing) {
        isRefreshing = true;
        store.dispatch('refresh_token').then(({status}) => {
          // if (status == 200 || status == 204) {
            isRefreshing = false;
            location.reload();
            // this.$router.reload()
          // }
        }).catch(error => {
          console.error(error);
        })
      }
    }
    /*else{
      store.dispatch('force_logout').then(() => {
        window.location.replace('/');
      })
      return Promise.reject(error);
    }*/
  // }
  if (error.response.status == 500) {
    store.dispatch('force_logout').then(() => {
      window.location.replace('/');
    })
    return Promise.reject(error);
  }
});
export default router
