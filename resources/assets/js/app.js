
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);


import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));


import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })

let routes = [
    { path: '/app', component: require('./components/views/App.vue') },
    { path: '/group/:group/:user', name: 'Beneficiary', component: require('./components/views/Beneficiary.vue'), props: true },
    { path: '/comparative_report', component: require('./components/views/ComparativeReport.vue') },
    { path: '/dashboard', component: require('./components/views/Dashboard.vue') },
    { path: '/developer', component: require('./components/views/Developer.vue') },
    { path: '/group/:group/:user/evaluation', name: 'Evaluation', component: require('./components/views/Evaluation.vue'), props: true },
    { path: '/global_report', component: require('./components/views/GlobalReport.vue') },
    { path: '/home', component: require('./components/views/Home.vue') },
    { path: '/group/:group', component: require('./components/views/Group.vue') },
    { path: '/profile', component: require('./components/views/Profile.vue') },
    { path: '/progress_report', component: require('./components/views/ProgressReport.vue') },
    { path: '/resources-yttv1', component: require('./components/views/Resourcev1.vue') },
    { path: '/resources-yttv2', component: require('./components/views/Resourcev2.vue') },
    { path: '/group/:group/:user/evaluation/:id', name: 'ShowEvaluation', component: require('./components/views/ShowEvaluation.vue'), props: true },
    { path: '*', component: require('./components/extra/NotFound.vue') }
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })



Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate',function(created){
    return moment(created).locale("es").format('LL');
});


window.Fire =  new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component(
    'not-found',
    require('./components/extra/NotFound.vue')
);

Vue.component('chart-component', require('./components/ChartComponent.vue'));
Vue.component('chart-component2', require('./components/ChartComponent2.vue'));
Vue.component('chart-component3', require('./components/ChartComponent3.vue'));
Vue.component('linechart-component', require('./components/LineChartComponent.vue'));
Vue.component('beneficiaryprogress-card', require('./components/BeneficiaryProgressCard.vue'));
Vue.component('linechart-component2', require('./components/LineChartComponent2.vue'));
Vue.component('piechart-component', require('./components/PieChartComponent.vue'));
Vue.component('piechart-component2', require('./components/PieChartComponent2.vue'));
Vue.component('piechart-component3', require('./components/PieChartComponent3.vue'));
Vue.component('chart-component4', require('./components/ChartComponent4.vue'));


Vue.component('users', require('./components/Users.vue'));

Vue.component('help-desk', require('./components/extra/HelpDesk.vue'));

Vue.component('global-report-ytt', require('./components/GlobalReportYtt'));
Vue.component('population-global-report', require('./components/PopulationGlobalReport'));
Vue.component('age-group-global-report', require('./components/AgeGroupGlobalReport'));
Vue.component('risk-level-global-report', require('./components/RiskLevelGlobalReport'));

const app = new Vue({
    el: '#app',
    router,
    data:{
        search: ''
    },
    methods:{
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        },1000),

        printme() {
            window.print();
        },
        openHelpDesk() {
            $('#helpdesk').modal('show');
        }
    }
});
