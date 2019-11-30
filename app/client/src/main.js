import Vue from 'vue'
import App from './App.vue'
import jQuery from 'jquery'
global.jquery = jQuery
global.$ = jQuery
window.$ = window.jQuery = require('jquery')

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
