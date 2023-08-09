<template>
    <div class="page-wrap">
        <section class="section1">
            <div class="col col1">
                <h1 class="section-title">{{ page.headline1 }}</h1>
                <div v-html="page.textarea1"></div>
                <div v-html="page.textarea2"></div>
                <div class="results-box all-ok" v-if="downloadables">
                    <ul>
                        <li v-for="(item, index) in downloadables" :key="index" v-html="item.name" @click="unencryptDownload(item.url, item.name)"></li>
                    </ul>
                </div>
                <div class="results-box error" v-if="error[0] == 'error'">
                    <h3>Error</h3>
                    <span v-html="error[1]"></span>
                </div>
            </div>
            <div class="col col2">
                <div class="order-details-wrap">
                    <h3>Your order details</h3>
                    <div class="order-summary-item">
                        <h5>Order reference:</h5>
                        <span>{{ order.order_id }}</span>
                    </div>
                    <div class="order-summary-item">
                        <h5>Order date: </h5>
                        <span>{{ order.order_date }}</span>
                    </div>
                    <div class="order-summary-item">
                        <h5>Order total: </h5>
                        <span v-html="calcCHF(order.order_total)"></span>
                    </div>
                    <div class="order-summary-item">
                        <h5>Payment method: </h5>
                        <span>{{ order.payment_method }}&nbsp;</span>
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
            method: null,
            order: [],
            page: {
                headline1: '',
                textarea1: '',
                headline2: '',
                textarea2: null,
                cta: '',
                externalLink: null,
            },
            downloadables: [],
            error: [],
        }
    },
    mounted() {
        if(this.$route.query.order) {
            this.ref = this.$route.query.order;
            this.code = this.$route.query.coupon;
            this.method = 'coupon';
        }
        if(this.$route.query.session) {
            this.ref = this.$route.query.order;
            this.session = this.$route.query.session;
            this.method = 'stripe';
        }
        if(this.$route.query.teaser) { /*requires a url query string with email and teaser_id*/
            this.ref = this.$route.query.teaser;
            this.session = this.$route.query.email;
            this.method = 'teaser';
        }
        this.getPage();
        this.getOrderSummary();
    },
    methods: {
        calcCHF(price) {
            return `CHF ${parseFloat(price).toFixed(2)}`;
        },
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
                })
                .then(() => { 
                    
                    if(this.method === 'coupon') {
                        this.doCouponCheck(this.order.coupon_code);
                    }

                    if(this.method === 'stripe') {
                        this.doStripeCheck();
                    }

                    if(this.method === 'teaser') {
                        this.getTeaserFile();
                    }

                });
        },
        doStripeCheck: async function() {
            // Does order id match the one in stripe session?
            const url = `${this.rest_base}stripe-check`;
            const data = {
                session_id: this.session,
                order_id: this.ref,
            };
            const headers = {
                credentials: "same-origin",
                "Content-Type": "application/json",
                "X-WP-Nonce": this.nonce,
            };
            fetch(url, { method: "POST", headers, body: JSON.stringify(data) })
                .then((result) => result.json())
                .then((result) => { 
                    if(result[0] === 'success') {
                        this.downloadFiles();
                    } else {
                        this.doCriticalError();
                    }
                });
        },
        doCouponCheck: function() {
            // Does given coupon code match the one in order?
            if(this.code !== this.order.coupon_code) {
                this.doCriticalError();
            }
            this.downloadFiles();

        },
        getPage: async function() {
            const url = `${this.rest_base}get-page`;
            const data = { slug: 'thank-you' };
            const headers = {
                credentials: "same-origin",
                "Content-Type": "application/json",
                "X-WP-Nonce": this.nonce,
            };
            fetch(url, { method: "POST", headers, body: JSON.stringify(data) })
                .then((result) => result.json())
                .then((result) => { this.page = result; });
        },
        downloadFiles: async function() {
            const url = `${this.rest_base}download-files`;
            const check = this.method === 'coupon' ? this.order.coupon_code : this.session;
            const data = { ref: this.ref, method: this.method, check: check };
            const headers = {
                credentials: "same-origin",
                "Content-Type": "application/json",
                "X-WP-Nonce": this.nonce,
            };
            fetch(url, { method: "POST", headers, body: JSON.stringify(data) })
                .then((result) => result.json())
                .then((result) => { 
                    if(Array.isArray(result) && result[0] !== 'error') {
                        this.downloadables = result;
                    } else {
                        this.doCriticalError(result);
                    }
                });
        },
        getTeaserFile: async function() {
            const url = `${this.rest_base}teaser-file`;
            const check = this.session;
            const data = { ref: this.ref, method: this.method, check: check };
            const headers = {
                credentials: "same-origin",
                "Content-Type": "application/json",
                "X-WP-Nonce": this.nonce,
            };
            fetch(url, { method: "POST", headers, body: JSON.stringify(data) })
                .then((result) => result.json())
                .then((result) => { 
                    if(Array.isArray(result) && result[0] !== 'error') {
                        this.downloadables = result[1];
                    } else {
                        this.doCriticalError(result);
                    }
                });
        },
        doCriticalError: function(err) {
            this.error = err;
        },
        decode(s) {
            var e={},i,b=0,c,x,l=0,a,r='',w=String.fromCharCode,L=s.length;
            var A="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
            for(i=0;i<64;i++){e[A.charAt(i)]=i;}
            for(x=0;x<L;x++){
                c=e[s.charAt(x)];b=(b<<6)+c;l+=6;
                while(l>=8){((a=(b>>>(l-=8))&0xff)||(x<(L-2)))&&(r+=w(a));}
            }
            return r;
        },
        unencryptDownload: function(url, name) {
            const decoded = this.decode(url);
            var link = document.createElement('a');
            link.href = decoded;
            link.style.display = 'none';
            link.download = name;
            document.body.appendChild(link);
            link.click();   
        },
    }
}

</script>