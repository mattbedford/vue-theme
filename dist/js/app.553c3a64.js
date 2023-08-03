(function(){"use strict";var t={9141:function(t,e,o){var r=o(6369),s=function(){var t=this,e=t._self._c;return e("div",{attrs:{id:"app"}},[e("NavBar",{class:{active:t.scrolledDown}}),e("div",{directives:[{name:"scroll",rawName:"v-scroll",value:t.handleScroll,expression:"handleScroll"}],staticClass:"navbackground",class:{active:t.scrolledDown}}),e("router-view",{on:{addToCart:t.addItemToCart,removeFromCart:t.removeItemFromCart}}),e("footer-bar")],1)},n=[],a=(o(7658),function(){var t=this,e=t._self._c;return e("nav",[e("div",{staticClass:"nav-main"},[e("div",{staticClass:"nav-logos"},[e("router-link",{attrs:{to:"/"}},[e("img",{staticClass:"dag-icon",attrs:{src:"/wp-content/uploads/dagora-ch-icon.webp"}}),e("img",{staticClass:"dag-logo",attrs:{src:"/wp-content/uploads/LOGO-DAGORA-1024x214-1.webp"}})])],1),e("div",{staticClass:"nav-menu"},[e("router-link",{attrs:{to:"/about"}},[t._v("About")]),e("router-link",{attrs:{to:"/cart"}},[t._v("Cart")]),e("ThemeSwitcher")],1)]),e("router-link",{attrs:{to:"/cart"}},[e("div",{staticClass:"nav-cart"},[e("svg",{staticClass:"ionicon",attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"}},[e("circle",{attrs:{cx:"176",cy:"416",r:"16",fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"32"}}),e("circle",{attrs:{cx:"400",cy:"416",r:"16",fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"32"}}),e("path",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"32",d:"M48 80h64l48 272h256"}}),e("path",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"32",d:"M160 288h249.44a8 8 0 0 0 7.85-6.43l28.8-144a8 8 0 0 0-7.85-9.57H128"}})]),t.$root.inCart.length>0?e("span",{staticClass:"cart-counter"},[t._v(t._s(t.$root.inCart.length))]):t._e()])])],1)}),i=[],c=function(){var t=this,e=t._self._c;return e("div",[e("input",{staticClass:"switch-checkbox",attrs:{id:"checkbox",type:"checkbox"},on:{change:t.toggleTheme}}),e("label",{staticClass:"switch-label",attrs:{for:"checkbox"}},["light-theme"===t.userTheme?e("span",[e("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg","data-name":"Layer 1",viewBox:"0 0 122.56 122.88"}},[e("path",{attrs:{"fill-rule":"evenodd",d:"M121.85 87.3A64.31 64.31 0 1 1 36.88.4c2.94-1.37 5.92.91 4.47 4.47a56.29 56.29 0 0 0 75.75 77.4l.49-.27a3.41 3.41 0 0 1 4.61 4.61l-.35.69ZM92.46 74.67H92a16.11 16.11 0 0 0-15.8-15.74v-.52a15.08 15.08 0 0 0 11-4.72 15.19 15.19 0 0 0 4.72-11h.51a15.12 15.12 0 0 0 4.72 11 15.12 15.12 0 0 0 11 4.72v.51a16.13 16.13 0 0 0-15.69 15.75Zm10.09-46.59h-.27a7.94 7.94 0 0 0-2.49-5.81A7.94 7.94 0 0 0 94 19.78v-.27A7.94 7.94 0 0 0 99.79 17a8 8 0 0 0 2.49-5.8h.27A8 8 0 0 0 105 17a8 8 0 0 0 5.81 2.49v.27a8 8 0 0 0-5.81 2.51 7.94 7.94 0 0 0-2.49 5.81Zm-41.5 8h-.41a12.06 12.06 0 0 0-3.78-8.82A12.06 12.06 0 0 0 48 23.5v-.41a12.07 12.07 0 0 0 8.82-3.78 12.09 12.09 0 0 0 3.78-8.82h.41a12.08 12.08 0 0 0 3.77 8.82 12.09 12.09 0 0 0 8.83 3.78v.41a12.09 12.09 0 0 0-8.83 3.78 12.08 12.08 0 0 0-3.77 8.82Z"}})])]):e("span",[e("svg",{staticClass:"ionicon biggify",attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"}},[e("path",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-miterlimit":"10","stroke-width":"32",d:"M256 48v48m0 320v48m147.08-355.08-33.94 33.94M142.86 369.14l-33.94 33.94M464 256h-48m-320 0H48m355.08 147.08-33.94-33.94M142.86 142.86l-33.94-33.94"}}),e("circle",{attrs:{cx:"256",cy:"256",r:"80",fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-miterlimit":"10","stroke-width":"32"}})])]),e("div",{staticClass:"switch-toggle",class:{"switch-toggle-checked":"dark-theme"===t.userTheme}})])])},l=[],u={mounted(){const t=this.getTheme()||this.getMediaPreference();this.setTheme(t)},data(){return{userTheme:"light-theme"}},methods:{toggleTheme(){const t=localStorage.getItem("user-theme");"light-theme"===t?this.setTheme("dark-theme"):this.setTheme("light-theme")},getTheme(){return localStorage.getItem("user-theme")},setTheme(t){localStorage.setItem("user-theme",t),this.userTheme=t,document.documentElement.className=t},getMediaPreference(){const t=window.matchMedia("(prefers-color-scheme: dark)").matches;return t?"dark-theme":"light-theme"}}},m=u,d=o(1001),p=(0,d.Z)(m,c,l,!1,null,null,null),h=p.exports,v={components:{ThemeSwitcher:h}},g=v,_=(0,d.Z)(g,a,i,!1,null,null,null),f=_.exports,C=function(){var t=this,e=t._self._c;return e("div",{staticClass:"footer"},[e("div",{staticClass:"footer-inner"},[e("div",[e("span",[t._v("Dagorà Reports eShop | © Dagorà SA "+t._s(t.yearNow))])]),e("a",{attrs:{href:"https://community.dagora.ch/join-us",target:"_blank"}},[t._v("Join Dagorà")])])])},y=[],b={data(){return{yearNow:null}},mounted(){this.yearNow=(new Date).getFullYear()}},w=b,k=(0,d.Z)(w,C,y,!1,null,null,null),x=k.exports,P={data(){return{scrolledDown:!1}},components:{NavBar:f,FooterBar:x},methods:{handleScroll:function(t,e){window.scrollY>250||(console.log(t,e),window.scrollY>75?this.scrolledDown=!0:this.scrolledDown=!1)},addItemToCart(t){console.log("trying now"),this.$root.inCart.push(t)},removeItemFromCart(t){const e=this.$root.inCart.indexOf(t);this.$root.inCart.splice(e,1)}}},F=P,T=(0,d.Z)(F,s,n,!1,null,null,null),$=T.exports,j=o(2631),S=function(){var t=this,e=t._self._c;return e("div",{staticClass:"home page-wrap"},[e("section",{staticClass:"section1"},[e("div",{staticClass:"col col1"},[t._m(0),e("h1",[t._v(t._s(t.page.headline1))]),e("div",{domProps:{innerHTML:t._s(t.page.textarea1)}}),e("a",{staticClass:"btn",attrs:{href:"#reports-section"}},[t._v(t._s(t.page.cta))])]),e("div",{staticClass:"col col2"},[e("video",{attrs:{id:"background-video",autoplay:"",loop:"",muted:""},domProps:{muted:!0}},[e("source",{attrs:{src:t.randomVideo,type:"video/mp4"}})])])]),e("section",{staticClass:"section2",attrs:{id:"reports-section"}},[e("div",{staticClass:"container"},[e("h2",{staticClass:"section-title"},[t._v(t._s(t.page.headline2))]),e("div",{staticClass:"list-reports"},t._l(t.reports,(function(o){return e("div",{key:o.id,staticClass:"report"},[e("router-link",{attrs:{to:{name:"report",params:{slug:o.slug}}}},[e("div",{staticClass:"report-img"},[e("span",{staticClass:"home-report-price",domProps:{innerHTML:t._s(t.calcCHF(o.price))}}),e("img",{attrs:{src:o.cover_image,alt:""}})])]),e("div",{staticClass:"report-content"},[e("h3",[t._v(t._s(o.title))]),e("p",[t._v(t._s(o.short_desc))]),e("div",{staticClass:"btns"},[e("router-link",{staticClass:"btn",attrs:{to:{name:"report",params:{slug:o.slug}}}},[t._v("Learn more")]),t.$root.inCart.includes(o.id)?e("button",{staticClass:"btn bad",on:{click:function(e){return t.removeFromCart(o.id)}}},[t._v("Remove from cart")]):e("button",{staticClass:"btn",on:{click:function(e){return t.addToCart(o.id)}}},[t._v("Add to cart")])],1)])],1)})),0)])])])},O=[function(){var t=this,e=t._self._c;return e("div",{staticClass:"tags"},[e("span",[t._v("Luxury")]),e("span",[t._v("Travel")]),e("span",[t._v("Retail")]),e("span",[t._v("Consumer")]),e("span",[t._v("Home & living")])])}],M={name:"HomeView",data(){return{page:{headline1:"",textarea1:"",image1:"",headline2:"",textarea2:null,image2:"",cta:"",externalLink:null},videos:["/wp-content/uploads/bgr1.mp4","/wp-content/uploads/bgr2.mp4","/wp-content/uploads/bgr3.mp4","/wp-content/uploads/bgr4.mp4","/wp-content/uploads/bgr5.mp4","/wp-content/uploads/bgr6.mp4"],reports:[]}},computed:{randomVideo(){return this.videos[Math.floor(Math.random()*this.videos.length)]}},mounted(){this.getPage(),this.getReports()},methods:{async getReports(){this.reports=[];const t=`${this.rest_base}get-reports`,e={credentials:"same-origin","Content-Type":"application/json","X-WP-Nonce":this.nonce};fetch(t,{method:"GET",headers:e}).then((t=>t.json())).then((t=>{this.reports=t}))},async getPage(){const t=`${this.rest_base}get-page`,e={slug:"home"},o={credentials:"same-origin","Content-Type":"application/json","X-WP-Nonce":this.nonce};fetch(t,{method:"POST",headers:o,body:JSON.stringify(e)}).then((t=>t.json())).then((t=>{this.page=t}))},addToCart(t){this.$emit("addToCart",t)},removeFromCart(t){this.$emit("removeFromCart",t)},calcCHF(t){return`CHF ${parseFloat(t).toFixed(2)}`}}},N=M,H=(0,d.Z)(N,S,O,!1,null,null,null),L=H.exports,A=function(){var t=this,e=t._self._c;return e("div",{staticClass:"single-report page-wrap",class:t.report.id},[e("section",{staticClass:"section1"},[e("div",{staticClass:"col col1"},[e("img",{attrs:{src:t.report.cover_image}})]),e("div",{staticClass:"col col2"},[e("router-link",{attrs:{to:{name:"home",hash:"#reports-section"}}},[e("button",{staticClass:"back-to"},[e("svg",{staticClass:"ionicon",attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"}},[e("path",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"48",d:"M244 400 100 256l144-144M120 256h292"}})]),t._v(" Back to reports ")])]),e("h1",{domProps:{innerHTML:t._s(t.report.title)}}),t.report.release_date&&""!==t.report.release_date?e("h4",{domProps:{innerHTML:t._s(`Released: ${t.report.release_date}`)}}):t._e(),e("h4",{staticClass:"single-report-price",domProps:{innerHTML:t._s(t.calcCHF(t.report.price))}}),e("div",{staticClass:"description",domProps:{innerHTML:t._s(t.report.long_desc)}}),e("div",{staticClass:"btns"},[t.$root.inCart.includes(t.report.id)?e("button",{staticClass:"btn bad",on:{click:function(e){return t.removeFromCart(t.report.id)}}},[t._v("Remove from cart")]):e("button",{staticClass:"btn",on:{click:function(e){return t.addToCart(t.report.id)}}},[t._v("Add to cart")]),e("a",{attrs:{href:t.report.teaser_file,download:""}},[t.report.teaser_file?e("button",{staticClass:"btn"},[t._v("Download preview")]):t._e()])])],1)])])},Z=[],I={name:"SingleReportView",data(){return{report:[]}},created(){this.getSingleReport()},methods:{getSingleReport:async function(){this.report=[];const t=`${this.rest_base}single-report/${this.$route.params.slug}`,e={credentials:"same-origin","Content-Type":"application/json","X-WP-Nonce":this.nonce};fetch(t,{method:"GET",headers:e}).then((t=>t.json())).then((t=>{this.report=t})).catch((t=>{console.log(t)}))},addToCart(t){this.$emit("addToCart",t)},removeFromCart(t){this.$emit("removeFromCart",t)},calcCHF(t){return`CHF ${parseFloat(t).toFixed(2)}`}}},B=I,D=(0,d.Z)(B,A,Z,!1,null,null,null),R=D.exports,q=function(){var t=this,e=t._self._c;return e("div",{staticClass:"cart page-wrap"},[e("h1",[t._v("Cart | "+t._s(t.page.headline1))]),e("router-link",{attrs:{to:{name:"home",hash:"#reports-section"}}},[e("button",{staticClass:"back-to"},[e("svg",{staticClass:"ionicon",attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"}},[e("path",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"48",d:"M244 400 100 256l144-144M120 256h292"}})]),t._v(" Back to reports ")])]),e("section",{staticClass:"section1"},[e("div",{staticClass:"col col1"},[t.items&&t.items.length>0?e("div",{staticClass:"full-cart"},[t._l(t.items,(function(o,r){return e("div",{key:r,staticClass:"cart-item"},[e("img",{attrs:{src:o.cover_image}}),e("h4",{domProps:{innerHTML:t._s(o.title)}}),e("button",{staticClass:"btn bad",on:{click:function(e){return t.removeFromCart(o.id,r)}}},[t._v("Remove")]),e("h4",{domProps:{innerHTML:t._s(t.calcCHF(o.price))}})])})),e("div",{staticClass:"total"},[e("h4",[t._v("Total")]),e("h4",[t._v("CHF "+t._s(t.totalPrice))])])],2):e("div",{staticClass:"empty-cart"},[e("svg",{staticClass:"ionicon",attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"}},[e("circle",{attrs:{cx:"176",cy:"416",r:"16",fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"32"}}),e("circle",{attrs:{cx:"400",cy:"416",r:"16",fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"32"}}),e("path",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"32",d:"M48 80h64l48 272h256"}}),e("path",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"32",d:"M160 288h249.44a8 8 0 0 0 7.85-6.43l28.8-144a8 8 0 0 0-7.85-9.57H128"}})])])]),e("div",{staticClass:"col col2"},[e("PurchaseForm",{attrs:{headline:t.page.headline2,textarea:t.page.textarea2}})],1)])],1)},V=[],W=function(){var t=this,e=t._self._c;return e("div",[e("form",{staticClass:"purchase-form"},[e("h3",[t._v(t._s(t.headline))]),e("div",{staticClass:"intro",domProps:{innerHTML:t._s(t.textarea)}}),e("input",{directives:[{name:"model",rawName:"v-model",value:t.honeypot,expression:"honeypot"}],attrs:{type:"hidden",name:"required"},domProps:{value:t.honeypot},on:{input:function(e){e.target.composing||(t.honeypot=e.target.value)}}}),e("div",{staticClass:"form-section form-section-1",class:{active:0===t.currForm}},[t._m(0),e("label",[t._m(1),e("input",{directives:[{name:"model",rawName:"v-model",value:t.contact.first_name,expression:"contact.first_name"}],attrs:{type:"text",name:"first_name",required:""},domProps:{value:t.contact.first_name},on:{input:function(e){e.target.composing||t.$set(t.contact,"first_name",e.target.value)}}})]),e("label",[t._m(2),e("input",{directives:[{name:"model",rawName:"v-model",value:t.contact.last_name,expression:"contact.last_name"}],attrs:{type:"text",name:"last_name",required:""},domProps:{value:t.contact.last_name},on:{input:function(e){e.target.composing||t.$set(t.contact,"last_name",e.target.value)}}})]),e("label",[t._m(3),e("input",{directives:[{name:"model",rawName:"v-model",value:t.contact.email_address,expression:"contact.email_address"}],attrs:{type:"text",name:"email_address",required:""},domProps:{value:t.contact.email_address},on:{input:function(e){e.target.composing||t.$set(t.contact,"email_address",e.target.value)}}})]),e("button",{attrs:{type:"button"},on:{click:function(e){t.currForm=1}}},[t._v("Next")])]),e("div",{staticClass:"form-section form-section-2",class:{active:1===t.currForm}},[e("label",[t._m(4),e("input",{directives:[{name:"model",rawName:"v-model",value:t.contact.job_title,expression:"contact.job_title"}],attrs:{type:"text",name:"job_title",required:""},domProps:{value:t.contact.job_title},on:{input:function(e){e.target.composing||t.$set(t.contact,"job_title",e.target.value)}}})]),e("label",[t._m(5),e("input",{directives:[{name:"model",rawName:"v-model",value:t.contact.company_name,expression:"contact.company_name"}],attrs:{type:"text",name:"company_name",required:""},domProps:{value:t.contact.company_name},on:{input:function(e){e.target.composing||t.$set(t.contact,"company_name",e.target.value)}}})]),e("label",[t._m(6),e("select",{directives:[{name:"model",rawName:"v-model",value:t.contact.company_type,expression:"contact.company_type"}],attrs:{name:"company_type",required:""},on:{change:function(e){var o=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.$set(t.contact,"company_type",e.target.multiple?o:o[0])}}},[e("option",{attrs:{disabled:"",value:""}},[t._v("What kind of company is yours?")]),e("option",{attrs:{value:"brand"}},[t._v("Brand, Retailer, Manufacturer or Online Shop")]),e("option",{attrs:{value:"investor"}},[t._v("Investor, Family Office, Business Angel")]),e("option",{attrs:{value:"media"}},[t._v("Media / Press / Journalism")]),e("option",{attrs:{value:"institution"}},[t._v("Public Administration / Institution")]),e("option",{attrs:{value:"research"}},[t._v("Research Institute, University, School")]),e("option",{attrs:{value:"vendor"}},[t._v("Vendor / Supplier of Services for Innovation and e-Commerce")]),e("option",{attrs:{value:"other"}},[t._v("Other")])])]),e("button",{attrs:{type:"button"},on:{click:function(e){t.currForm=0}}},[t._v("Back")]),e("button",{attrs:{type:"button"},on:{click:function(e){t.currForm=2}}},[t._v("Next")])]),e("div",{staticClass:"form-section form-section-3",class:{active:2===t.currForm}},[e("div",{staticClass:"tandcs"},[e("p",[t._v("Dagorà Lifestyle Innovation Hub along with their strategic partners is committed to protecting and respecting your privacy (please see our privacy policy). We’ll only use your information to administer your account and to provide the products and services you requested from us. From time to time, we would like to contact you about our products and services, as well as other content that may be of interest to you. If you consent to us contacting you for this purpose, please tick below to confirm: ")]),e("label",[e("input",{directives:[{name:"model",rawName:"v-model",value:t.terms,expression:"terms"}],attrs:{type:"checkbox",name:"terms",required:""},domProps:{checked:Array.isArray(t.terms)?t._i(t.terms,null)>-1:t.terms},on:{change:function(e){var o=t.terms,r=e.target,s=!!r.checked;if(Array.isArray(o)){var n=null,a=t._i(o,n);r.checked?a<0&&(t.terms=o.concat([n])):a>-1&&(t.terms=o.slice(0,a).concat(o.slice(a+1)))}else t.terms=s}}}),t._m(7)]),e("p",[t._v("You can unsubscribe from these communications at any time. By submitting this form you consent to allow Dagorà and its strategic partners Netcomm Suisse, Loomish SA and the Lifestyle-Tech Competence Center to store and process the personal information submitted above to provide you the content requested. ")])]),e("button",{attrs:{type:"button"},on:{click:function(e){t.currForm=1}}},[t._v("Back")]),e("input",{staticClass:"submit-button btn",attrs:{type:"submit",value:"Get your reports",disabled:t.formIsNotValid},on:{click:function(e){return e.preventDefault(),t.handleSubmission()}}})]),e("label",{staticClass:"code-box"},[e("span",[t._v("Do you have a code for free access? Enter it here.")]),e("input",{directives:[{name:"model",rawName:"v-model",value:t.coupon_code,expression:"coupon_code"}],attrs:{type:"text",name:"coupon_code"},domProps:{value:t.coupon_code},on:{input:function(e){e.target.composing||(t.coupon_code=e.target.value)}}})]),e("div",{staticClass:"form-indicator"},[e("div",{staticClass:"form-indicator-item",class:{active:0===t.currForm},on:{click:function(e){t.currForm=0}}}),e("div",{staticClass:"form-indicator-item",class:{active:1===t.currForm},on:{click:function(e){t.currForm=1}}}),e("div",{staticClass:"form-indicator-item",class:{active:2===t.currForm},on:{click:function(e){t.currForm=2}}})])]),t.announce.status?e("div",{staticClass:"announce"},[e("span",{on:{click:function(e){return t.closeAnnounce()}}},[t._v("✖")]),e("span",{staticClass:"warning"},[e("svg",{staticClass:"ionicon",attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"}},[e("path",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"32",d:"M85.57 446.25h340.86a32 32 0 0 0 28.17-47.17L284.18 82.58c-12.09-22.44-44.27-22.44-56.36 0L57.4 399.08a32 32 0 0 0 28.17 47.17z"}}),e("path",{attrs:{fill:"none",stroke:"currentColor","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"32",d:"m250.26 195.39 5.74 122 5.73-121.95a5.74 5.74 0 0 0-5.79-6h0a5.74 5.74 0 0 0-5.68 5.95z"}}),e("path",{attrs:{d:"M256 397.25a20 20 0 1 1 20-20 20 20 0 0 1-20 20z"}})])]),e("h3",[t._v(t._s(t.announce.status))]),e("p",[t._v(t._s(t.announce.message))])]):t._e()])},J=[function(){var t=this,e=t._self._c;return e("p",{staticClass:"nb"},[e("sup",[t._v("*")]),t._v(" indicates required field")])},function(){var t=this,e=t._self._c;return e("span",[t._v("First name "),e("sup",[t._v("*")])])},function(){var t=this,e=t._self._c;return e("span",[t._v("Surname "),e("sup",[t._v("*")])])},function(){var t=this,e=t._self._c;return e("span",[t._v("Email "),e("sup",[t._v("*")])])},function(){var t=this,e=t._self._c;return e("span",[t._v("Job title "),e("sup",[t._v("*")])])},function(){var t=this,e=t._self._c;return e("span",[t._v("Company "),e("sup",[t._v("*")])])},function(){var t=this,e=t._self._c;return e("span",[t._v("Company type "),e("sup",[t._v("*")])])},function(){var t=this,e=t._self._c;return e("span",[t._v("You accept and confirm "),e("sup",[t._v("*")])])}],X={name:"SingleReportView",props:{headline:String,textarea:String},data(){return{currForm:0,announce:{status:null,message:null},contact:{first_name:"",last_name:"",email_address:"",company_name:"",company_type:"",job_title:""},terms:!1,coupon_code:"",honeypot:""}},watch:{currForm:function(t){2===t&&this.checkFormFields()}},methods:{closeAnnounce:function(){this.announce.status=null,this.announce.message=null},handleSubmission:async function(){if(this.closeAnnounce(),""!==this.honeypot)return;if(!this.contact.first_name||!this.contact.last_name||!this.contact.email_address||!this.contact.company_name||!this.contact.company_type||!this.terms)return;const t=`${this.rest_base}order-submission`,e={contact:this.contact,coupon_code:this.coupon_code,cartItems:this.$root.inCart},o={credentials:"same-origin","Content-Type":"application/json","X-WP-Nonce":this.nonce};fetch(t,{method:"POST",headers:o,body:JSON.stringify(e)}).then((t=>t.json())).then((t=>{"success"===t.status&&(this.$root.inCart=[],this.$root.ref=t.order_id,this.$router.push({name:"thank-you"})),"error"===t.status&&(this.announce.status=t.status,this.announce.message=t.message),"stripe"===t.status&&(window.location.href=t.url)}))},checkFormFields:function(){this.contact.first_name||(this.currForm=0,this.announce.status="error",this.announce.message="Please enter your first name"),this.contact.last_name||(this.currForm=0,this.announce.status="error",this.announce.message="Please enter your last name"),this.contact.email_address||(this.currForm=0,this.announce.status="error",this.announce.message="Please enter your email address"),this.contact.job_title||(this.currForm=1,this.announce.status="error",this.announce.message="Please enter your job title"),this.contact.company_name||(this.currForm=1,this.announce.status="error",this.announce.message="Please enter your company name"),this.contact.company_type||(this.currForm=1,this.announce.status="error",this.announce.message="Please select your company type")}},computed:{formIsNotValid:function(){return""!==this.honeypot||!this.contact.first_name||!this.contact.last_name||!this.contact.email_address||!this.contact.company_name||!this.contact.company_type||!this.terms}}},E=X,Y=(0,d.Z)(E,W,J,!1,null,null,null),G=Y.exports,z={name:"SingleReportView",components:{PurchaseForm:G},data(){return{page:{headline1:"",textarea1:"",image1:"",headline2:"",textarea2:null,image2:"",cta:"",externalLink:null},items:[]}},created(){this.$root.inCart&&this.$root.inCart.length>0&&this.getCartItems()},mounted(){this.getPage()},computed:{totalPrice:function(){return this.items.reduce(((t,e)=>t+parseFloat(e.price)),0).toFixed(2)}},methods:{async getPage(){const t=`${this.rest_base}get-page`,e={slug:"cart"},o={credentials:"same-origin","Content-Type":"application/json","X-WP-Nonce":this.nonce};fetch(t,{method:"POST",headers:o,body:JSON.stringify(e)}).then((t=>t.json())).then((t=>{this.page=t}))},removeFromCart(t,e){this.$emit("removeFromCart",t),this.items.splice(e,1)},calcCHF(t){return`CHF ${parseFloat(t).toFixed(2)}`},getCartItems:async function(){const t=JSON.stringify({cartItems:this.$root.inCart}),e=`${this.rest_base}cart`,o={credentials:"same-origin","Content-Type":"application/json","X-WP-Nonce":this.nonce};fetch(e,{method:"POST",headers:o,body:t}).then((t=>t.json())).then((t=>{this.items=t}))}}},U=z,K=(0,d.Z)(U,q,V,!1,null,null,null),Q=K.exports,tt=function(){var t=this,e=t._self._c;return e("div",{staticClass:"page-wrap"},[e("section",{staticClass:"section1"},[e("div",{staticClass:"col col1"},[e("h1",[t._v(t._s(t.page.headline1))]),e("div",{domProps:{innerHTML:t._s(t.page.textarea1)}}),e("div",{domProps:{innerHTML:t._s(t.page.textarea2)}})]),e("div",{staticClass:"col col2"},[e("div",{staticClass:"order-details-wrap"},[e("h3",[t._v("Your order details")]),e("div",{staticClass:"order-summary-item"},[e("h5",[t._v("Order reference:")]),e("span",[t._v(t._s(t.order.order_id)+" made on "+t._s(t.order.order_date))])]),e("div",{staticClass:"order-summary-item"},[e("h5",[t._v("Order total:")]),e("span",[t._v(t._s(t.order.order_total))])]),e("div",{staticClass:"order-summary-item"},[e("h5",[t._v("Payment method:")]),e("span",[t._v(t._s(t.order.payment_method))]),t.order.coupon_code?e("span",[t._v("("+t._s(t.order.coupon_code)+")")]):t._e()]),e("div",{staticClass:"order-summary-list"},[e("h5",[t._v("Order items:")]),e("ul",t._l(t.order.order_items,(function(o,r){return e("li",{key:r},[t._v(t._s(o))])})),0)])])])])])},et=[],ot={name:"ThankYouView",data(){return{ref:null,order:[],page:{headline1:"",textarea1:"",headline2:"",textarea2:null,cta:"",externalLink:null}}},mounted(){this.getPage(),this.$root.ref?(this.ref=this.$root.ref,this.getOrderSummary()):(this.ref=15,this.$root.ref=15,this.getOrderSummary())},methods:{getOrderSummary:async function(){const t=`${this.rest_base}order-summary`,e={ref:this.ref},o={credentials:"same-origin","Content-Type":"application/json","X-WP-Nonce":this.nonce};fetch(t,{method:"POST",headers:o,body:JSON.stringify(e)}).then((t=>t.json())).then((t=>{this.order=t}))},getPage:async function(){const t=`${this.rest_base}get-page`,e={slug:"thank-you"},o={credentials:"same-origin","Content-Type":"application/json","X-WP-Nonce":this.nonce};fetch(t,{method:"POST",headers:o,body:JSON.stringify(e)}).then((t=>t.json())).then((t=>{this.page=t}))}}},rt=ot,st=(0,d.Z)(rt,tt,et,!1,null,null,null),nt=st.exports,at=function(){var t=this,e=t._self._c;return e("div",{staticClass:"about page-wrap"},[e("section",{staticClass:"section1 stretch"},[e("div",{staticClass:"col col1"},[e("h1",{staticClass:"section-title"},[t._v(t._s(t.page.headline1))]),e("div",{domProps:{innerHTML:t._s(t.page.textarea1)}})]),e("div",{staticClass:"col col2"},[e("img",{staticClass:"page-image",attrs:{src:t.page.image1,alt:"Dagorà reports image"}})])]),e("section",{staticClass:"section2 stretch"},[e("div",{staticClass:"col col1"},[e("img",{staticClass:"page-image",attrs:{src:t.page.image2,alt:"Dagorà image"}})]),e("div",{staticClass:"col col2"},[e("h1",{staticClass:"section-title"},[t._v(t._s(t.page.headline2))]),e("div",{domProps:{innerHTML:t._s(t.page.textarea2)}}),e("a",{attrs:{href:t.page.externalLink,target:"_blank"}},[e("button",{staticClass:"btn"},[t._v(t._s(t.page.cta))])])])])])},it=[],ct={name:"AboutView",data(){return{page:{headline1:"",textarea1:"",image1:"",headline2:"",textarea2:null,image2:"",cta:"",externalLink:null},items:[]}},mounted(){this.getPage()},methods:{async getPage(){const t=`${this.rest_base}get-page`,e={slug:"about"},o={credentials:"same-origin","Content-Type":"application/json","X-WP-Nonce":this.nonce};fetch(t,{method:"POST",headers:o,body:JSON.stringify(e)}).then((t=>t.json())).then((t=>{this.page=t}))}}},lt=ct,ut=(0,d.Z)(lt,at,it,!1,null,null,null),mt=ut.exports;r.ZP.use(j.ZP);const dt=[{path:"/",name:"home",component:L},{path:"/about",name:"about",component:mt},{path:"/report/:slug",name:"report",component:R},{path:"/cart",name:"cart",component:Q},{path:"/thank-you",name:"thank-you",component:nt}],pt=new j.ZP({mode:"history",scrollBehavior(t,e,o){return t.hash?{el:t.hash,behavior:"smooth"}:o||top},base:"/",routes:dt});var ht=pt;r.ZP.config.productionTip=!1,r.ZP.directive("scroll",{inserted:function(t,e){let o=function(r){e.value(r,t)&&window.removeEventListener("scroll",o)};window.addEventListener("scroll",o)}});const vt=nonce_object;r.ZP.config.productionTip=!1,r.ZP.prototype.$wp=vt,r.ZP.mixin({data(){return{nonce:this.$wp.rest_nonce,rest_base:this.$wp.rest_base}}}),new r.ZP({router:ht,render:t=>t($),data:{inCart:[],ref:null}}).$mount("#app")}},e={};function o(r){var s=e[r];if(void 0!==s)return s.exports;var n=e[r]={exports:{}};return t[r].call(n.exports,n,n.exports,o),n.exports}o.m=t,function(){var t=[];o.O=function(e,r,s,n){if(!r){var a=1/0;for(u=0;u<t.length;u++){r=t[u][0],s=t[u][1],n=t[u][2];for(var i=!0,c=0;c<r.length;c++)(!1&n||a>=n)&&Object.keys(o.O).every((function(t){return o.O[t](r[c])}))?r.splice(c--,1):(i=!1,n<a&&(a=n));if(i){t.splice(u--,1);var l=s();void 0!==l&&(e=l)}}return e}n=n||0;for(var u=t.length;u>0&&t[u-1][2]>n;u--)t[u]=t[u-1];t[u]=[r,s,n]}}(),function(){o.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return o.d(e,{a:e}),e}}(),function(){o.d=function(t,e){for(var r in e)o.o(e,r)&&!o.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:e[r]})}}(),function(){o.g=function(){if("object"===typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(t){if("object"===typeof window)return window}}()}(),function(){o.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)}}(),function(){var t={143:0};o.O.j=function(e){return 0===t[e]};var e=function(e,r){var s,n,a=r[0],i=r[1],c=r[2],l=0;if(a.some((function(e){return 0!==t[e]}))){for(s in i)o.o(i,s)&&(o.m[s]=i[s]);if(c)var u=c(o)}for(e&&e(r);l<a.length;l++)n=a[l],o.o(t,n)&&t[n]&&t[n][0](),t[n]=0;return o.O(u)},r=self["webpackChunkcore"]=self["webpackChunkcore"]||[];r.forEach(e.bind(null,0)),r.push=e.bind(null,r.push.bind(r))}();var r=o.O(void 0,[998],(function(){return o(9141)}));r=o.O(r)})();
//# sourceMappingURL=app.553c3a64.js.map