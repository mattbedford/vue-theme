<template>

      <div class="cart page-wrap">
        <h1>Cart | {{ page.headline1 }}</h1>
        <router-link :to="{name: 'home', hash: '#reports-section'}">
            <button class="back-to">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M244 400 100 256l144-144M120 256h292"/></svg>
                Back to reports
            </button>
        </router-link>
        <section class="section1">
            <div class="col col1">
                <div v-if="items && items.length > 0" class="full-cart">
                  <div class="cart-item" v-for="(lineItem, index) in items" :key="index">
                    <img :src="lineItem.cover_image">
                    <h4 v-html="lineItem.title"></h4>
                    <button class="btn bad" @click="removeFromCart(lineItem.id, index)">Remove</button>
                    <h4 v-html="calcCHF(lineItem.price)"></h4>
                  </div>
                  <div class="total">
                    <h4>Total</h4>
                    <h4>CHF {{ totalPrice }}</h4>
                  </div>
                </div>
                <div v-else class="empty-cart">
                  <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><circle cx="176" cy="416" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="400" cy="416" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M48 80h64l48 272h256"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M160 288h249.44a8 8 0 0 0 7.85-6.43l28.8-144a8 8 0 0 0-7.85-9.57H128"/></svg>
                </div>
            </div>
            <div class="col col2">
                <PurchaseForm :headline="page.headline2" :textarea="page.textarea2" />
            </div>
        </section>
      </div>
  </template>
  

<script>
import PurchaseForm from '@/components/PurchaseForm.vue';

export default {
    name: "SingleReportView",
    components: { PurchaseForm },
    data() {
        return {
          page: {
            headline1: '',
            textarea1: '',
            image1: '',
            headline2: '',
            textarea2: null,
            image2: '',
            cta: '',
            externalLink: null,
          },
          items: [],
        };
    },
    created() {
        if (this.$root.inCart && this.$root.inCart.length > 0)
            this.getCartItems();
    },
    mounted() {
      this.getPage();
    },
    computed: {
      totalPrice: function() {
        return this.items.reduce((acc, item) => acc + parseFloat(item.price), 0).toFixed(2);
      }
    },
    methods: {
      async getPage() {
          const url = `${this.rest_base}get-page`;
          const data = { slug: 'cart' };
          const headers = {
            credentials: 'same-origin',
            'Content-Type': 'application/json',
            'X-WP-Nonce': this.nonce,
          };
          fetch(url, { method: 'POST', headers, body: JSON.stringify(data) })
            .then((result) => result.json())
            .then((result) => { this.page = result; });
        },
        removeFromCart(reportId, index) {
            this.$emit("removeFromCart", reportId);
            this.items.splice(index, 1);
        },
        calcCHF(price) {
          return `CHF ${parseFloat(price).toFixed(2)}`;
        },
        getCartItems: async function () {
            const cartItems = JSON.stringify({ cartItems: this.$root.inCart });
            const url = `${this.rest_base}cart`;
            const headers = {
                credentials: "same-origin",
                "Content-Type": "application/json",
                "X-WP-Nonce": this.nonce,
            };
            fetch(url, { method: "POST", headers, body: cartItems })
                .then((result) => result.json())
                .then((result) => { this.items = result; });
        },
    },
}


</script>