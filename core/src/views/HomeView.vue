<template>
  <div class="home page-wrap">
    <section class="section1">
      <div class="col col1">
        <div class="tags">
          <span>Luxury</span>
          <span>Travel</span>
          <span>Retail</span>
          <span>Consumer</span>
          <span>Home & living</span>
        </div>
        <h1>{{ page.headline1 }}</h1>
        <div v-html="page.textarea1"></div>
        <a href="#reports-section" class="btn">{{ page.cta }}</a>
      </div>

      <div class="col col2">
        <video id="background-video" autoplay loop muted>
          <source :src="randomVideo" type="video/mp4">
        </video>
      </div>
    </section>
    <section class="section2" id="reports-section">
      <div class="container">
        <h2 class="section-title">{{ page.headline2 }}</h2>
        <div class="list-reports">
          <div class="report" v-for="report in reports" :key="report.id">
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
      videos: [
        '/wp-content/uploads/bgr1.mp4',
        '/wp-content/uploads/bgr2.mp4',
        '/wp-content/uploads/bgr3.mp4',
        '/wp-content/uploads/bgr4.mp4',
        '/wp-content/uploads/bgr5.mp4',
        '/wp-content/uploads/bgr6.mp4',
      ],
      reports: [],
    }
  },
  computed: {
    randomVideo() {
      return this.videos[Math.floor(Math.random() * this.videos.length)];
    }
  },
  mounted() {
    this.getPage();
    this.getReports();
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
      const data = { slug: 'home' };
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
