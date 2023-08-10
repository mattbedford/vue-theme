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
        <router-link to="/reports"><span class="btn">{{ page.cta }}</span></router-link>
      </div>

      <div class="col col2">
        <video id="background-video" autoplay loop muted>
          <source :src="randomVideo" type="video/mp4">
        </video>
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
    }
  },
  computed: {
    randomVideo() {
      return this.videos[Math.floor(Math.random() * this.videos.length)];
    }
  },
  mounted() {
    this.getPage();
  },
  methods: {
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
  },
}
</script>
