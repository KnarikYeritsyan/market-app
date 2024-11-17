<template>
    <div>
        <h1>Protected resource page </h1>
        <span>name: {{user.name}}</span><br/>
        <span>email: {{user.email}}</span>
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
      this.getUser();
    },
    methods: {
      getUser: function () {
        this.$http.get(this.$ApiHost+'api/auth/user')
            .then( (response) =>{
              this.user=Object.values(response.data)[1];
              console.log(this.user);
            });
      }
    }
  };
</script>