import { defineStore } from "pinia";
import { useLocalStorage,useStorage } from "@vueuse/core"
import { browserKey } from "../Plugins/utility";

const local = (key,val)=>{
    return useStorage(key,val);
}
const localObj = (key,val)=>{
    
   return useStorage(
    key,
    {},
  undefined,
  {
    serializer: {
      read: (v) => v ? JSON.parse(v) : null,
      write: (v) => JSON.stringify(v),
    },
  },
  )
}

export const mainStore = defineStore("index", {
    state() {
       return {
        user: localObj(browserKey('user'),null),
        avatar:localObj(browserKey('avatar'),null),
        auth_id:local(browserKey('auth_id'),null),
        token:local(browserKey('token'),null),
        roles:localObj(browserKey('roles'),[]),
        showProfileModal:false
       }
    },
    actions: {
        addUser(user) {
            const {id,avatar} = user;
            this.auth_id = id;
            if(avatar){
                this.avatar = avatar;
            }else{
                this.showProfileModal = true;
            }

            this.roles = user.roles;
          
            this.user = user;
        },
        addToken(token) {
            this.token = token;
        },
        updateAvatar(avatar){
            this.avatar = avatar;
        },
        hideProfileModal(){
            this.showProfileModal = false;
        }
    },
    getters: {
        canRole: (state) => {
          return (role) => state.roles.find((r) => r === role)
        },
      },
  

});
