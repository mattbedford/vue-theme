<template>
    <div>
        <form class="purchase-form">
            <h3>{{ headline }}</h3>
            <div v-html="textarea" class="intro"></div>
            <a href="mailto:lifestyle@dagora.ch?subject=Can I please get my community coupon" class="dagmail">
                Dagorà member? Request your coupon here for free download
            </a>
            <input type="hidden" name="required" v-model="honeypot">

            <div class="form-section form-section-1" :class="{'active': currForm === 0}">
                <p class="nb"><sup>*</sup> indicates required field</p>
                <label><span>First name <sup>*</sup></span>
                    <input type="text" name="first_name" v-model="contact.first_name" required>
                </label>
                <label><span>Surname <sup>*</sup></span>
                    <input type="text" name="last_name" v-model="contact.last_name" required>
                </label>
                <label><span>Email <sup>*</sup></span>
                    <input type="text" name="email_address" v-model="contact.email_address" required>
                </label>
                <button type="button" @click="currForm = 1">Next</button>
            </div>
            <div class="form-section form-section-2" :class="{'active': currForm === 1}">
                <label><span>Job title <sup>*</sup></span>
                    <input type="text" name="job_title" v-model="contact.job_title" required>
                </label>
                <label><span>Company <sup>*</sup></span>
                    <input type="text" name="company_name" v-model="contact.company_name" required>
                </label>
                <label><span>Company type <sup>*</sup></span>
                    <select name="company_type" v-model="contact.company_type" required>
                        <option disabled="" value="">What kind of company is yours?</option>
                        <option value="brand">Brand, Retailer, Manufacturer or Online Shop</option>
                        <option value="investor">Investor, Family Office, Business Angel</option>
                        <option value="media">Media / Press / Journalism</option>
                        <option value="institution">Public Administration / Institution</option>
                        <option value="research">Research Institute, University, School</option>
                        <option value="vendor">Vendor / Supplier of Services for Innovation and e-Commerce</option>
                        <option value="other">Other</option>
                    </select>
                </label>
                <button type="button" @click="currForm = 0">Back</button>
                <button type="button" @click="currForm = 2">Next</button>
            </div>
            <div class="form-section form-section-3" :class="{'active': currForm === 2}">
                <div class="tandcs">
                    <p>Dagorà Lifestyle Innovation Hub along with their strategic partners is committed to protecting and respecting your privacy (please see our privacy policy). 
                        We’ll only use your information to administer your account and to provide the products and services you requested from us. From time to time, we would like to contact you about our products and services,
                        as well as other content that may be of interest to you. If you consent to us contacting you for this purpose, please tick below to confirm:
                    </p>
                    <label>
                        <input type="checkbox" name="terms" v-model="terms" required><span>You accept and confirm <sup>*</sup></span>
                    </label>
                    <p>You can unsubscribe from these communications at any time. By submitting this form
                        you consent to allow Dagorà and its strategic partners Netcomm Suisse, Loomish SA and the Lifestyle-Tech Competence Center to
                        store and process the personal information submitted above to provide you the content requested.
                    </p>
                </div>
                <button type="button" @click="currForm = 1">Back</button>
                <input type="submit" value="Get your reports" @click.prevent="handleSubmission()" :disabled="formIsNotValid" class="submit-button btn">
            </div>
            <label class="code-box"><span>Do you have a code for free access? Enter it here.</span>
                <input type="text" name="coupon_code" v-model="coupon_code">
            </label>
            <div class="form-indicator">
                <div class="form-indicator-item" :class="{'active': currForm === 0}" @click="currForm = 0"></div>
                <div class="form-indicator-item" :class="{'active': currForm === 1}" @click="currForm = 1"></div>
                <div class="form-indicator-item" :class="{'active': currForm === 2}" @click="currForm = 2"></div>
            </div>
        </form>
        <div class="announce" v-if="announce.status">
            <span @click="closeAnnounce()">&#10006;</span>
            <span class="warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M85.57 446.25h340.86a32 32 0 0 0 28.17-47.17L284.18 82.58c-12.09-22.44-44.27-22.44-56.36 0L57.4 399.08a32 32 0 0 0 28.17 47.17z"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="m250.26 195.39 5.74 122 5.73-121.95a5.74 5.74 0 0 0-5.79-6h0a5.74 5.74 0 0 0-5.68 5.95z"/><path d="M256 397.25a20 20 0 1 1 20-20 20 20 0 0 1-20 20z"/></svg>
            </span>
            <h3>{{ announce.status }}</h3>
            <p>{{ announce.message }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SingleReportView',
    props: {
        headline: String,
        textarea: String,
    },

  data() {
    return {
      currForm: 0,
      announce: {
        status: null,
        message: null,
      },
      contact: {
        first_name: '',
        last_name: '',
        email_address: '',
        company_name: '',
        company_type: '',
        job_title: '',
      },
      terms: false,
      coupon_code: '',
      honeypot: '',
    }
  },
  watch: {
    currForm: function(newCurrForm) {
        if(newCurrForm === 2) {
            this.checkFormFields();
        }
    }
  },
  methods: {
    closeAnnounce: function() {
        this.announce.status = null;
        this.announce.message = null;
    },
    handleSubmission: async function() {
        this.closeAnnounce();
        if(this.honeypot !== "") return;
        if( !this.contact.first_name || !this.contact.last_name 
        || !this.contact.email_address || !this.contact.company_name 
        || !this.contact.company_type || !this.terms) return;
      
        const url = `${this.rest_base}order-submission`;
        const data = {
            contact: this.contact,
            coupon_code: this.coupon_code,
            cartItems: this.$root.inCart,
        };
        const headers = {
            credentials: "same-origin",
            "Content-Type": "application/json",
            "X-WP-Nonce": this.nonce,
        };
        fetch(url, { method: "POST", headers, body: JSON.stringify(data) })
            .then((result) => result.json())
            .then((result) => { 
                if(result.status === 'success') {
                    this.$root.inCart = [];
                    this.$root.ref = result.order_id;
                    this.$router.push({ name: 'success'});
                    //this.$router.push({ name: 'thank-you', query: { order: result.order_id, coupon: this.coupon_code } });
                }
                if(result.status === 'error') {
                    this.announce.status = result.status;
                    this.announce.message = result.message;
                }
                if(result.status === 'stripe') {
                    window.location.href = result.message;
                }
             });
    },
    checkFormFields: function() {
        if(!this.contact.first_name) {
            this.currForm = 0;
            this.announce.status = 'error';
            this.announce.message = 'Please enter your first name';
        }
        if(!this.contact.last_name) {
            this.currForm = 0;
            this.announce.status = 'error';
            this.announce.message = 'Please enter your last name';
        }
        if(!this.contact.email_address) {
            this.currForm = 0;
            this.announce.status = 'error';
            this.announce.message = 'Please enter your email address';
        }
        if(!this.contact.job_title) {
            this.currForm = 1;
            this.announce.status = 'error';
            this.announce.message = 'Please enter your job title';
        }
        if(!this.contact.company_name) {
            this.currForm = 1;
            this.announce.status = 'error';
            this.announce.message = 'Please enter your company name';
        }
        if(!this.contact.company_type) {
            this.currForm = 1;
            this.announce.status = 'error';
            this.announce.message = 'Please select your company type';
        }
    }
  },
  computed: {
    formIsNotValid: function() {
      return this.honeypot !== "" || !this.contact.first_name || !this.contact.last_name || !this.contact.email_address || !this.contact.company_name || !this.contact.company_type || !this.terms;
    }
  }
}

</script>