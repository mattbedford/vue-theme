<template>
    <div class="single-report page-wrap" :class="report.id">
        <section class="section1">
            <TeaserForm class="teaser-form" v-if="showForm" headline="Download this report for free" :reportName="report.title" :teaserId="report.id"></TeaserForm>
            <div v-else class="col col1">
                <img :src="report.cover_image">
            </div>
            <div class="col col2">
                <router-link :to="{name: 'reports'}">
                    <button class="back-to">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M244 400 100 256l144-144M120 256h292"/></svg>
                        Back to reports
                    </button>
                </router-link>
                <h1 v-html="report.title"></h1>
                <h4 v-if="report.release_date && report.release_date !== ''" v-html="`Released: ${report.release_date}`"></h4>
                <h4 class="single-report-price" v-html="calcCHF(report.price)"></h4>
                <div class="description" v-html="report.long_desc"></div>
                <div class="btns">
                    <button v-if="$root.inCart.includes(report.id)" class="btn bad" @click="removeFromCart(report.id)">Remove from cart</button>
                    <button v-else class="btn" @click="addToCart(report.id)">Add to cart</button>
                    <button class="btn" v-if="report.teaser_file" @click="showForm = !showForm">
                      <span v-if="!showForm">Download preview</span>
                      <span v-else>&#x2715;</span>
                    </button>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import TeaserForm from '@/components/TeasrForm.vue';

export default {
  name: 'SingleReportView',
  components: {
    TeaserForm,
  },

  data() {
    return {
      showForm: false,
      report: [],
    }
  },
  created() {
    this.getSingleReport();
  },
  methods: {
    getSingleReport: async function() {
      this.report = [];
      const url = `${this.rest_base}single-report/${this.$route.params.slug}`;
      const headers = {
        credentials: 'same-origin',
        'Content-Type': 'application/json',
        'X-WP-Nonce': this.nonce,
      };
      fetch(url, { method: 'GET', headers })
        .then((result) => result.json())
        .then((result) => { 
          if(result[0] == 'error') this.$router.push('/404');
          this.report = result; 
        })
        .catch((error) => {
          console.log(error)
          this.$router.push('/404')
            });
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
  }
}

</script>