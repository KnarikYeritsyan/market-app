import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    loading: false,
    auth_error: null,
    status: '',
    token: localStorage.getItem('token') || '',
    user: {},
    // cartProducts: JSON.parse(localStorage.getItem('products')) || [],
    cartProductsCounts: JSON.parse(localStorage.getItem('products_counts')) || {},
  },
  mutations: {
    ADD_PRODUCT: (state, product) => {
      // !state.cartProducts.includes(product.id)?state.cartProducts.push(product.id):'';
      !state.cartProductsCounts[product.id]?state.cartProductsCounts[product.id]=1:state.cartProductsCounts[product.id]+=1;
      state.cartProductsCounts = {...state.cartProductsCounts};
      localStorage.setItem('products', JSON.stringify(state.cartProducts))
      localStorage.setItem('products_counts', JSON.stringify(state.cartProductsCounts))
    },
    ADD_CURRENT_PRODUCT: (state, product) => {
      !state.cartProductsCounts[product.index]?state.cartProductsCounts[product.index]=product.count:state.cartProductsCounts[product.index]=parseInt(state.cartProductsCounts[product.index])+product.count;
      state.cartProductsCounts = {...state.cartProductsCounts};
      localStorage.setItem('products_counts', JSON.stringify(state.cartProductsCounts))
    },
    REMOVE_PRODUCT: (state, index) => {
      // state.cartProducts.splice(index, 1);
      // state.cartProducts.splice(state.cartProducts.indexOf(index), 1);
      delete state.cartProductsCounts[index];
      state.cartProductsCounts = {...state.cartProductsCounts};
      localStorage.setItem('products', JSON.stringify(state.cartProducts))
      localStorage.setItem('products_counts', JSON.stringify(state.cartProductsCounts))
    },
    EMPTY_CART: (state, index) => {
      state.cartProductsCounts = {};
      localStorage.removeItem('products_counts')
    },
    CHANGE_COUNT: (state, index) => {
      state.cartProductsCounts = { ...state.cartProductsCounts, [index.index]: index.count }
      localStorage.setItem('products_counts', JSON.stringify(state.cartProductsCounts))
    },
    auth_request(state) {
      state.status = 'loading'
      state.loading = true
    },
    auth_success(state, token, user) {
      state.status = 'success'
      state.token = token
      state.user = user
      state.loading = false
    },
    auth_error(state) {
      state.status = 'error'
      state.loading = false;
      // state.auth_error = payload.error;
      state.auth_error = 'Invalid username or password';
    },
    logout(state) {
      state.status = ''
      state.token = ''
      state.user = ''
    },
  },
  actions: {
    addProduct: ({commit}, product) => {
      commit('ADD_PRODUCT', product);
    },
    addCurrentProduct: ({commit}, product) => {
      commit('ADD_CURRENT_PRODUCT', product);
    },
    removeProduct: ({commit}, index) => {
      commit('REMOVE_PRODUCT', index);
    },
    emptyCart: ({commit}, index) => {
      commit('EMPTY_CART', index);
    },
    changeProductCount: ({commit}, index) => {
      commit('CHANGE_COUNT', index);
    },
    login({commit}, user) {
      commit('auth_request')
      return new Promise((resolve, reject) => {
        axios.post(api_host+'api/auth/login', user)
            .then(resp => {
              const token = resp.data.token
              const user = resp.data.user
              localStorage.setItem('token', token)
              axios.defaults.headers.common['Authorization'] = 'Bearer '+token
              commit('auth_success', token, user)
              resolve(resp.data)
            })
            .catch(err => {
              commit('auth_error')
              localStorage.removeItem('token')
              reject(err)
            })
      })
    },
    register({commit}, user) {
      return new Promise((resolve, reject) => {
        commit('auth_request')
        axios({url: 'http://127.0.0.1:8000/api/auth/register', data: user, method: 'POST'})
            .then(resp => {
              const token = resp.data.token
              const user = resp.data.user
              localStorage.setItem('token', token)
              // Add the following line:
              axios.defaults.headers.common['Authorization'] = token
              commit('auth_success', token, user)
              resolve(resp)
            })
            .catch(err => {
              commit('auth_error', err)
              localStorage.removeItem('token')
              reject(err)
            })
      })
    },
    refresh_token({commit}) {
      return new Promise((resolve, reject) => {
        axios.get(api_host+'api/auth/refresh')
            .then(resp => {
              const token = resp.data.token
              localStorage.setItem('token', token)
              axios.defaults.headers.common['Authorization'] = 'Bearer '+token
              resolve(resp)
            }).catch(error=>{
              reject(error)
        })
      })
    },
    logout({commit}) {
      return new Promise((resolve, reject) => {
        commit('logout')
        axios.post(api_host+'api/auth/logout', {})
            .then(resp => {
              localStorage.removeItem('token')
              delete axios.defaults.headers.common['Authorization']
              resolve()
            })
      })
    },
    force_logout({commit}) {
      return new Promise((resolve, reject) => {
        commit('logout')
           localStorage.removeItem('token')
           delete axios.defaults.headers.common['Authorization']
           resolve()
      })
    }
  },
  getters: {
    // getProductsInCart: state => state.cartProducts,
    getProductsInCart: state => Object.keys(state.cartProductsCounts),
    getProductsCounts: state =>state.cartProductsCounts,
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
  },
  modules: {
  }
})
