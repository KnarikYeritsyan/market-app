<template>
  <div class="about">
    <h1>Shop view</h1>
    <div v-if="is_brand">
      <Brand></Brand>
    </div>
    <div v-if="is_cat">
      <Category></Category>
    </div>
    <div v-if="is_tag">
      <Tag></Tag>
    </div>
  </div>
</template>
<script>
  import Brand from './Brand.vue'
  import Category from './Category.vue'
  import Tag from './Tag.vue'
  export default {
    data() {
      return {
        is_cat: false,
        is_brand: false,
        is_tag: false
      };
    },
    components: {
      Brand,
      Category,
      Tag
    },
    beforeCreate() {
      this.$http.get(this.$ApiHost+'/api/getstat?slug='+this.$route.params.slug)
          .then( (response) =>{
            console.log(response.data.type)
            if(response.data.type === 'brand'){
              this.is_brand = true
            }if(response.data.type === 'tag'){
              this.is_tag = true
            }if(response.data.type === 'category'){
              this.is_cat = true
            }
          });
    },
  };
</script>