<template>

  <div id="app">
    <NavBar :class="{'active': scrolledDown}" />
    <div class="navbackground" v-scroll="handleScroll" :class="{'active': scrolledDown}"></div>


    <router-view @addToCart="addItemToCart" @removeFromCart="removeItemFromCart" />
    <footer-bar />
  </div>
</template>


<script>
import NavBar from './components/NavBar.vue';
import FooterBar from './components/FooterBar.vue';

export default {

  data() {
      return {
          scrolledDown: false,
      };
  },
  components: {
      NavBar, FooterBar
  },
  methods: {
    handleScroll: function (evt, el) {
      if(window.scrollY > 250) return;
      console.log(evt, el);
      if (window.scrollY > 100) this.scrolledDown = true;
      else this.scrolledDown = false;
    },
    addItemToCart(reportId) {
      console.log("trying now");
      this.$root.inCart.push(reportId);
    },
    removeItemFromCart(reportId) {
      const index = this.$root.inCart.indexOf(reportId);
      this.$root.inCart.splice(index, 1);
    },
  }

};
</script>


<style>

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
