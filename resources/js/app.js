import './bootstrap';


import {createApp} from 'vue';
import router from './routes';
import { createVuestic } from 'vuestic-ui'

import ElementPlus from 'element-plus'


import { createPinia } from 'pinia'

import App from './App.vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';







const app = createApp(App);
app.use(router)
app.use(createPinia())
app.use(createVuestic())
app.use(ElementPlus);
// for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
//     app.component(key, component)
//   }

app.component('QuillEditor', QuillEditor)
app.mount("#app");