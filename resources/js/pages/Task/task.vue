<template>
  <app-layout :busy="busy">
    <div>
      <page-title-box title="Show Task no job">
        <back-button></back-button>
      </page-title-box>
    </div>
    <div v-if="task">
      <show-task :auth_id="auth_id" :id="id" :task="task">
        
        <el-descriptions direction="horizontal" :column="1" size="large" border>
          <el-descriptions-item label="Employe:">
             <el-link>
     <el-avatar :size="25" :src="task.employee.model.avatar.url" />
      <b style="font-size:15px; margin-left:5px">{{
            task.employee.model.name
          }}</b>
    </el-link>
            
          </el-descriptions-item>
          <el-descriptions-item label="Status:"><status-btn :dropdown="true" :status="task.status">
             <ul class="status-dropdown">
                <li
                  v-for="(s, index) in statusList.filter(e=>![0,1,2,3].includes(e.status))"
                  :key="index"
                  @click="changeStatus(s.status)"
                >
                  {{ s.title }}
                </li>
              </ul>
            </status-btn></el-descriptions-item>
             <el-descriptions-item label="Asigned Date:"><b>{{atNow(task.start)}}</b></el-descriptions-item>
            <el-descriptions-item label="DeadLine Date:"><b>{{atNow(task.end)}}</b></el-descriptions-item>
        </el-descriptions>
      </show-task>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/app-layout.vue";
import PageTitleBox from "../../Components/PageTitleBox.vue";
import ShowTask from "../../Components/ShowTask/index.vue";
import StatusBtn from "../../Components/statusBtn.vue";
import BackButton from '../../Components/BackButton.vue';
import { reactive, ref } from "vue";
import { mainStore } from "../../store/index";
import {useDateFormat} from '@vueuse/core';
import moment from 'moment';
import { statusList } from "../../Plugins/utility";
import { useToast } from "vuestic-ui";
export default {
  props: {
    id: {
      type: [String, Number],
      required: true,
    },
  },
  components: {
    AppLayout,
    PageTitleBox,
    ShowTask,
    StatusBtn,
    BackButton
  },
  setup(props) {
    const main = mainStore();
    const auth_id = main.auth_id;
    const task = ref(null);
    const busy = ref(true);
        const { init } = useToast();



    const atNow = (date)=> moment(date).format('DD MMM YY');

    const show = async () => {
      busy.value = true;
      try {
        const url = route("api.task.show", { task: props.id });
        const { data } = await axios.get(url);
        task.value = data;
      } catch (error) {
        console.error(error);
      }
      busy.value = false;
    };
    show();

     const changeStatus = async (status) => {
      try {
        const url = route("api.task.changeStatus", { task: props.id });
        const { data } = await axios.post(url, { status,notify:0 });
        task.value.status = status;
        init({
          message: "Succsess Fully Update Status",
          color: "#432c50",
          closeable: true,
          duration: 4000,
        });
      } catch (error) {
        console.error(error);
      }
    };

    return {
      busy,
      auth_id,
      id: props.id,
      task,
      useDateFormat,
      atNow,
      statusList,
      changeStatus
    };
  },
};
</script>

<style lang="scss" scoped></style>
