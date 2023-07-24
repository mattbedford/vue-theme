<template>
    <div>
        <form class="purchase-form">
            <h3>Complete the form to access your reports</h3>
            <p class="intro">If you have a Dagorà membership code please enter it below for free access, otherwise
                you will be directed to our secure payment gateway to complete your purchase.
            </p>
            <input type="hidden" name="required" v-model="honeypot">
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
            <label><span>Company <sup>*</sup></span>
                <input type="text" name="company_name" v-model="contact.company_name" required>
            </label>
            <label><span>Company type <sup>*</sup></span>
                <select name="company_type" v-model="contact.company_type" required>
                    <option disabled="" value="">What kind of company is yours?</option>
                    <option value="Brand, Retailer, Manufacturer or Online Shop">Brand, Retailer, Manufacturer or Online Shop</option>
                    <option value="Investor, Family Office,">Investor, Family Office, Business Angel</option>
                    <option value="Media / Press">Media / Press / Journalism</option>
                    <option value="Public Administration / Institution">Public Administration / Institution</option>
                    <option value="Research Institute, University, School">Research Institute, University, School</option>
                    <option value="Vendor / Supplier of Services">Vendor / Supplier of Services for Innovation and e-Commerce</option>
                    <option value="Other">Other</option>
                </select>
            </label>
            <label class="code-box"><span>Do you have a code for free access? Enter it here.</span>
                <input type="text" name="coupon_code" v-model="coupon_code">
            </label>
            <div class="tandcs">
                <p>Dagorà Lifestyle Innovation Hub along with their strategic partners Netcomm Suisse, Loomish and the LifeStyle-Tech Competence Center
                    are committed to protecting and respecting your privacy, and we’ll only use your personal information to administer your account and
                    to provide the products and services you requested from us. From time to time, we would like to contact you about our products and services,
                    as well as other content that may be of interest to you. If you consent to us contacting you for this purpose, please tick below to confirm:
                </p>
                <label>
                    <input type="checkbox" name="terms" v-model="terms" required><span>You accept and confirm <sup>*</sup></span>
                </label>
                <p>You can unsubscribe from these communications at any time. For more information on how to unsubscribe, our privacy practices,
                    and how we are committed to protecting and respecting your privacy, please review our Privacy Policy. By clicking submit below,
                    you consent to allow Dagorà and its strategic partners Netcomm Suisse, Loomish SA and the Lifestyle-Tech Competence Center to
                    store and process the personal information submitted above to provide you the content requested.
                </p>
            </div>
            <input type="submit" value="Get your reports" @click.prevent="handleSubmission()" :disabled="formIsNotValid" class="submit-button btn">
        </form>
    </div>
</template>

<script>
export default {
    name: 'SingleReportView',

  data() {
    return {
      contact: {
        first_name: '',
        last_name: '',
        email_address: '',
        company_name: '',
        conpany_type: '',
      },
      terms: false,
      coupon_code: '',
      honeypot: '',
    }
  },
  methods: {
    handleSubmission: async function() {
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
            .then((result) => { console.log(result); });
    },
  },
  computed: {
    formIsNotValid: function() {
      return this.honeypot !== "" || !this.contact.first_name || !this.contact.last_name || !this.contact.email_address || !this.contact.company_name || !this.contact.company_type || !this.terms;
    }
  }
}

</script>