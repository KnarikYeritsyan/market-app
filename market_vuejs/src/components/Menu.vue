<template>
  <div>
    <ul class="dropdown">
      <li v-for="child in children">
        <router-link :to="`/${$i18n.locale}${(child.slug != '/home')?child.slug:''}`">{{child.title}}</router-link>
        <Menu v-if="child.children.length > 0" :children="child.children"></Menu>
      </li>
    </ul>
  </div>
</template>
<script>
  export default {
    name: 'Menu',
    props: ['children'],
    mounted() {
      // this.$emit('nav-class');
      /*$( document ).ready(function() {
        if ($.fn.classyNav) {
          $('#alazeaNav').classyNav();
        }
      })*/
    },
    methods: {
    }
  };
</script>