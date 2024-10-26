import './assets/index.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faUser, faHome, fas } from '@fortawesome/free-solid-svg-icons';



const app = createApp(App)

library.add(faUser, faHome, fas);

app.use(createPinia())
app.use(router)
app.component('font-awesome-icon', FontAwesomeIcon);


app.mount('#app')
