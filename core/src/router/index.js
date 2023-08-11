import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ReportView from '../views/SingleReportView.vue'
import CartView from '../views/CartView.vue'
import ThankYouView from '../views/ThankYouView.vue'
import AboutView from '../views/AboutView.vue'
import SuccessPreDownload from '../views/SuccessPreDownload.vue'
import ReportsView from '../views/ReportsView.vue'
import PathNotFound from '../views/PathNotFoundView.vue'


Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    component: AboutView,
  },
  {
    path: '/report/:slug',
    name: 'report',
    component: ReportView
  },
  {
    path: '/cart',
    name: 'cart',
    component: CartView
  },
  {
    path: '/thank-you',
    name: 'thank-you',
    component: ThankYouView
  },
  {
    path: '/success',
    name: 'success',
    component: SuccessPreDownload
  },
  {
    path: '/reports',
    name: 'reports',
    component: ReportsView
  },
  {
    path: '/:pathMatch(.*)*',
    name: '404', 
    component: PathNotFound 
  },
]

const router = new VueRouter({
  mode: 'history',
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
    },
  base: process.env.BASE_URL,
  routes
})

export default router
