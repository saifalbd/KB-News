import _, { isPlainObject } from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import {mainStore} from './store/index'
import {confirm,validErorrs} from './Plugins/utility';
window.vConfirm = confirm;
window.validErorrs = validErorrs;
window.dateFormat = "YYYY-MM-DD";
  window.axios = axios;

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
};
window.axios.interceptors.request.use(function (config) {
    const main  = mainStore();
    let token = main.token;
    if (token) {
     config.headers.Authorization = `Bearer ${token}`;
    } 
    return config;
  }, e=>Promise.reject(e));

 window.axios.interceptors.response.use(response=>response,error=> {
    if (error.response.status == 401) {
      window.location.href = '/'
    }
    return Promise.reject(error);
  })


window.addProtos =(items,protos)=>{
  try {
    if(isPlainObject(items)){
      return {...items,...protos};
    }else{
      return items.map(item=>{
        return {...item,...protos};
      })
    }
  } catch (error) {
    console.error(error)
  }
  
}
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;


window.Echo = new Echo({
  broadcaster: "pusher",
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: false,
  //auth impliment on //Layouts/app-layout.vue
  // auth: {
  //   headers: {
  //     Authorization: `Bearer ${token}`,
  //   },
  // },
})




