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
        <h1>Dagorà Reports eShop</h1>
        <p>Get access to the latest data and studies as well as quantitative and qualitative reports across a range of lifestyle industries and verticals.
          Reports can be purchased individually or accessed freely by Dagorà Community Associates.
        </p>
        <a href="#reports-section" class="btn">Explore Reports</a>
      </div>

      <div class="col col2">
        <video id="background-video" autoplay loop muted>
          <source :src="randomVideo" type="video/mp4">
        </video>
      </div>
    </section>
    <section class="section2" id="reports-section">
      <div class="container">
        <h2 class="section-title">The Dagorà Reports</h2>
        <div class="list-reports">
          <div class="report" v-for="report in reports" :key="report.id">
            <div class="report-img">
              <img :src="report.cover_image" alt="">
            </div>
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
    addToCart(reportId) {
      this.$emit('addToCart', reportId);
    },
    removeFromCart(reportId) {
      this.$emit('removeFromCart', reportId);
    }
  },
}
</script>
