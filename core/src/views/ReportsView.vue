<template>
    <div class="reports page-wrap">
      <section class="section1">
        <div class="reports-header">
          <h1 class="section-title">{{ page.headline1 }}</h1>
        </div>

        <div class="tags">
            <span :class="{'active': token == 'retail'}" @click="token = 'retail'">Retail</span>
            <span :class="{'active': token == 'fashion'}" @click="token = 'fashion'">Fashion</span>
            <span :class="{'active': token == 'luxury'}" @click="token = 'luxury'">Luxury</span>
            <span :class="{'active': token == 'travel'}" @click="token = 'travel'">Travel</span>
            <span :class="{'active': token == 'food'}" @click="token = 'food'">Food</span>
            <span :class="{'active': token == 'design-furniture'}" @click="token = 'design-furniture'">Design & furniture</span>
            <span :class="{'active': token == 'electronics'}" @click="token = 'electronics'">Electronics</span>
            <span :class="{'active': token == null}" @click="token = null">All</span>
        </div>

        <div id="reports-section" class="container">
          <div class="list-reports">
            <div class="report" v-for="report in filteredReports" :key="report.id">
              <router-link :to="{name: 'report' , params:{ slug: report.slug }}">
                <div class="report-img">
                  <span class="home-report-price" v-html="calcCHF(report.price)"></span>
                  <img :src="report.cover_image" alt="">
                </div>
              </router-link>
              <div class="report-content">
                <h3>{{ report.title }}</h3>
                <p>{{ report.short_desc }}</p>
                <div class="btns">
                  <router-link :to="{name: 'report' , params:{ slug: report.slug }}" class="btn">Learn more</router-link>
                  <button v-if="$root.inCart.includes(report.id)" class="btn bad" @click="removeFromCart(report.id)">Remove from cart</button>
                  <button v-else class="btn" @click="addToCart(report.id)">Add to cart</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </template>
  
  <script>
  export default {
    name: 'HomeView',
  
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
        reports: [],
        token: null,
      }
    },
    mounted() {
    if(this.$route.query.topic) {
      this.token = this.$route.query.topic;
    }
      this.getPage();
      this.getReports();
    },
    computed: {
        filteredReports() {
            let tempReports = this.reports
            
            if(this.token) {
                tempReports = tempReports.filter((item) => {
                    return item.tags.includes(this.token)
                })
            }            
            return tempReports;
        },       
    },
    methods: {
      async getReports() {
        this.reports = [];
        const url = `${this.rest_base}get-reports`;
        const headers = {
          credentials: 'same-origin',
          'Content-Type': 'application/json',
          'X-WP-Nonce': this.nonce,
        };
        fetch(url, { method: 'GET', headers })
          .then((result) => result.json())
          .then((result) => { this.reports = result; });
      },
      async getPage() {
        const url = `${this.rest_base}get-page`;
        const data = { slug: 'reports' };
        const headers = {
          credentials: 'same-origin',
          'Content-Type': 'application/json',
          'X-WP-Nonce': this.nonce,
        };
        fetch(url, { method: 'POST', headers, body: JSON.stringify(data) })
          .then((result) => result.json())
          .then((result) => { this.page = result; });
      },
      addToCart(reportId) {
        this.$emit('addToCart', reportId);
      },
      removeFromCart(reportId) {
        this.$emit('removeFromCart', reportId);
      },
      calcCHF(price) {
        return `CHF ${parseFloat(price).toFixed(2)}`;
      },
    },
  }
  </script>
  