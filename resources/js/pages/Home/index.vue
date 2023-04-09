<template>
  <app-layout :busy="busy">
    <div>
      <page-title-box></page-title-box>
    </div>
    <div class="home-page">
      
     
     
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/app-layout.vue";
import PageTitleBox from "../../Components/PageTitleBox.vue";
import { ref,computed } from "vue";

import { recentTasks } from "./api";
import moment from "moment";
import { useRouter } from "vue-router";
import statusBtnVue from "../../Components/statusBtn.vue";
export default {
  components: {
    AppLayout,
    PageTitleBox,
    statusBtnVue,
  },
  setup() {
    const busy = ref(false);
    const router = useRouter();
   

    const atNow = (date) => {
      return moment(date).fromNow();
    };
    const go = (to) => {
      router.push(to);
    };

  
  


    return { atNow, go, busy};
  },
};
</script>

<style lang="scss" scoped>
.page-layout {
  display: grid;
  grid-template-columns: auto 270px;
}
.right-side {
  .list-title {
    margin: 5px;
  }
 
}
</style>
