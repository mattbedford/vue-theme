<template>
  <div class="about page-wrap">
    <section class="section1 stretch">
      <div class="col col1">
          <h1 class="section-title">{{ page.headline1 }}</h1>
          <div v-html="page.textarea1"></div>
      </div>
      <div class="col col2">
          <img class="page-image" :src="page.image1" alt="Dagorà reports image" />
      </div>
    </section>
    <section class="section2 stretch">
      <div class="col col1">
        <img class="page-image" :src="page.image2" alt="Dagorà image" />
      </div>
      <div class="col col2">
        <h1 class="section-title">{{ page.headline2 }}</h1>
        <div v-html="page.textarea2"></div>
        <a :href="page.externalLink" target="_blank"><button class="btn">{{ page.cta }}</button></a>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: "AboutView",
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
    mounted() {
      this.getPage();
    },
    methods: {
      async getPage() {
          const url = `${this.rest_base}get-page`;
          const data = { slug: 'about' };
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
};

</script>