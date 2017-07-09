
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

$('.panel-body .input-daterange').datepicker({
    maxViewMode: 1,
    format: "yyyy-mm-dd",
    clearBtn: true,
    autoclose: true,
    endDate: new Date(),
    startDate: new Date(new Date().setFullYear(new Date().getFullYear() - 1)),
});


// window.Vue = require("vue");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component("example", require("./components/Example.vue"));

// const app = new Vue({
//     el: "#app"
// });
