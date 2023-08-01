<template>
    <div class="page-wrap">
        <section class="section1">
            <div class="col col1">
                <h1>Thank you!</h1>
                <p>Your order was submitted successfully and your reports will be sent to the email address you provided within a few minutes.</p>
                <p>Please remember to check your spam folder and if you have any issues at all, feel free to reach out to us at info@dagora.ch</p>
                <p>Thank you for trusting our reports.</p>
            </div>
            <div class="col col2">
                <div class="order-details-wrap">
                    <h3>Your order details</h3>
                    <div class="order-summary-item">
                        <h5>Order reference:</h5>
                        <span>{{ order.order_id }} made on {{ order.order_date }}</span>
                    </div>
                    <div class="order-summary-item">
                        <h5>Order total:</h5>
                        <span>{{ order.order_total }}</span>
                    </div>
                    <div class="order-summary-item">
                        <h5>Payment method:</h5>
                        <span>{{ order.payment_method }}</span>
                        <span v-if="order.coupon_code">({{ order.coupon_code }})</span>
                    </div>
                    <div class="order-summary-list">
                        <h5>Order items:</h5>
                        <ul>
                            <li v-for="(item, index) in order.order_items" :key="index">{{ item }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: 'ThankYouView',
    data() {
        return {
            ref: null,
            order: [],
        }
    },
    mounted() {
        if(this.$root.ref) {
            this.ref = this.$root.ref;
            this.getOrderSummary();
        } else {
            //TESTING
            this.ref = 15;
            this.$root.ref = 15;
            this.getOrderSummary();
            //END TESTING
            // this.$router.push({ name: 'home' });
        }
    },
    methods: {
        getOrderSummary: async function() {
            const url = `${this.rest_base}order-summary`;
            const data = {
                ref: this.ref,
            };
            const headers = {
                credentials: "same-origin",
                "Content-Type": "application/json",
                "X-WP-Nonce": this.nonce,
            };
            fetch(url, { method: "POST", headers, body: JSON.stringify(data) })
                .then((result) => result.json())
                .then((result) => { 
                    this.order = result;
                });
        }
    }
}

</script>