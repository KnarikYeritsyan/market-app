<template>
  <div class="about">
    <h1>{{$t('about content')}}</h1>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        user: ""
      };
    },
    created() {
      this.getCat();
    },
    methods: {
      getCat: function () {
        this.$http.get(this.$ApiHost+'/api/getcategories')
            .then( (response) =>{
              console.log(response.data);
              console.log(response.data['categories'][0].name);
            });
      }
    }
  };
</script>