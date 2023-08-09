<template>
    <div class="page-wrap">
        <section class="section1">
            <div class="col col1">
                <h1 class="section-title" v-html="page.headline1"></h1>
                <p v-html="page.textarea1"></p>
                <RouterLink to="/"><button class="btn">Go to home page</button></RouterLink>
            </div>
            <div class="col col1">
                <img :src="page.image1" alt="Person celebrating after receiving his Dagorà report">
            </div>
        </section>
    </div>
</template>

<script>
export default {
  name: "SuccessPreDownload",

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
          const data = { slug: 'success' };
          const headers = {
            credentials: 'same-origin',
            'Content-Type': 'application/json',
            'X-WP-Nonce': this.nonce,
          };
          fetch(url, { method: 'POST', headers, body: JSON.stringify(data) })
            .then((result) => result.json())
            .then((result) => { this.page = result; });
        },
        doStripeConfirm: async function() {

            if(!this.$route.query.session || !this.$route.query.email) return;
            
            const stripeId = this.$route.query.session;
            const emailId = this.$route.query.email;

            const url = `${this.rest_base}stripe-download-check`;
            const data = {
                session_id: stripeId,
                email: emailId,
            };
            const headers = {
                credentials: "same-origin",
                "Content-Type": "application/json",
                "X-WP-Nonce": this.nonce,
            };
            fetch(url, { method: "POST", headers, body: JSON.stringify(data) })
        },
      },
};

</script>