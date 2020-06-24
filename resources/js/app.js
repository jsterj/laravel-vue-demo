/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//const files = require.context('./', true, /\.vue$/i)
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('transaction-root-component', require('./components/TransactionRootComponent.vue').default);
Vue.component('transaction-list-component', require('./components/TransactionListComponent.vue').default);
Vue.component('transaction-navbar-component', require('./components/TransactionNavbarComponent.vue').default);

/**
 * Define global mixins
 */
 Vue.mixin({
   methods: {
     //format a transaction amount string as currency and prepend with "+" or "-"
     formatCurrency(str, useSign) {
       str = Number(str);
       var sign = (str > 0) ? '+' : '-';
       return ((useSign) ? sign + ' ' : '') + "$" + Math.abs(str).toFixed(2);
     },
   }
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
});
