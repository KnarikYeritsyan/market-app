<template>
    <div>
        <div class="breadcrumb-area">
            <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(/img/bg-img/24.jpg);">
                <h2>{{$t('Login')}}</h2>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> {{$t('Home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$t('Login')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <section class="about-us-area section-padding-0-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ $t('Login') }}</div>

                            <div class="card-body">
                                <form method="POST" @submit.prevent="login">
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ $t('E-Mail Address') }}</label>
                                        <div class="col-md-6">
                                            <input v-validate="'required|email'" id="email" v-model="email" type="text" class="form-control" :class="{'is-invalid': (fields.email && fields.email.touched && errors.has('email')) }" name="email" autocomplete="email" autofocus>
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ errors.first('email') }}</strong>
                                    </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ $t('Password') }}</label>

                                        <div class="col-md-6">
                                            <input v-validate="'required'" id="password" v-model="password" type="password" class="form-control" :class="{'is-invalid': (fields.password && fields.password.touched && errors.has('password')) }" name="password" autocomplete="current-password">
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ errors.first('password') }}</strong>
                                    </span>
                                        </div>
                                    </div>
                                    <div style="display: flex;justify-content: center" class="form-group row">
                                        <div class="col-md-6">
                            <span style="display: block" class="invalid-feedback" role="alert">
                               <strong>{{ authError }}</strong>
                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                                <label class="form-check-label" for="remember">
                                                    {{ $t('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-center">
                                        <i  v-show="isLoading" class="fa fa-spinner fa-spin"></i>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button :disabled="isLoading===true" type="submit" class="btn btn-primary">
                                                {{ $t('Login') }}
                                            </button>

                                            <a class="btn btn-link" href="#">
                                                {{ $t('Forgot Your Password?') }}
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
  import Vue from 'vue';
  import VeeValidate from 'vee-validate';

  Vue.use(VeeValidate);

  export default {
    data() {
      return {
        email: "",
        password: "",
        error_cl: null,
        error_message: '',
      };
    },
    methods: {
      login: function () {
        this.$validator.validateAll().then((result) => {
          if (result) {
            let email = this.email;
            let password = this.password;
            this.$store
                .dispatch('login', {email, password})
                .then((res) => {
                  // window.location.replace('/')
                  this.$router.push('/'+this.$i18n.locale)
                })
                .catch((error) => {console.log(error);
                console.log('error')
                });
          }else {
            console.log('Not Valid');
          }
        })
      }
    },
    computed: {
      authError() {
        return this.$store.state.auth_error;
      },
      isLoading() {
        return this.$store.state.loading;
      }
    }
  };
</script>