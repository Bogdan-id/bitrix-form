window.Vue = require('vue')

import router from './router/router'
import App from './components/App'
import vuetify from './vuetify'
import Snotify from 'vue-snotify'

Vue.use(Snotify, {
  toast: {
    timeout: 15000
  }
})

new Vue({
	vuetify,
	router,
	render: h => h(App)
}).$mount('#app')