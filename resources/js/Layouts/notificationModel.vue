<template>
    <va-modal
        v-model="show"
        :fullscreen="false"
        hide-default-actions
        no-outside-dismiss
        class="form-sceen"
    >
        <va-inner-loading :loading="busy">
            <div class="layout va-gutter-1">
                <div class="row">
                    <div class="flex xs12">
                        <div class="item mb-4">
                            <div class="form-title">
                                <va-icon name="notifications"></va-icon>
                                <span class="text">{{ title }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- taskNotifications -->
                    <div class="flex xs12" v-if="notifyStore.taskNotifications.length">
                        <va-list>
                            <va-list-label> TaskNotifications </va-list-label>
                            <va-list-item
                                class="list__item"
                                v-for="(notify, index) in notifyStore.taskNotifications"
                                :key="index"
                              
                            >
                                <va-list-item-section avatar   @click="go({name:'userProfile',params:{user:notify.data.user_id}},notify.id)">
                                    <va-avatar :size="40">
                                        <img :src="notify.fromUser.avatar.url" />
                                    </va-avatar>
                                </va-list-item-section>

                                <va-list-item-section>
                                    <va-list-item-label   @click="go({name:'userProfile',params:{user:notify.data.user_id}},notify.id)">
                                       <el-link :underline="false"><b>{{notify.fromUser.name}}</b></el-link>
                                    </va-list-item-label>

                                    <va-list-item-label    @click="go({name:'job.task.show',params:{id:notify.data.task_id}},notify.id)"
                                      
                                        :lines="index + 1"
                                    v-if="notify.type =='TaskStatusChanged'">

                                        {{ notify.data.message }} Changed Status From 
                                        <status-btn-vue :status="notify.data.beforeStatus" size="small"></status-btn-vue>
                                        To  <status-btn-vue :status="notify.data.status"  size="small"></status-btn-vue>
                                    </va-list-item-label>
                                     <va-list-item-label   @click="go({name:'job.task.show',params:{id:notify.data.task_id}},notify.id)"
                                      
                                        :lines="index + 1"
                                    v-else>
                                        {{ notify.data.message }} 
                                    </va-list-item-label>

                                </va-list-item-section>

                                <va-list-item-section icon>
                                    <va-icon
                                        name="remove_red_eye"
                                        color="background-tertiary"
                                    />
                                </va-list-item-section>
                            </va-list-item>
                        </va-list>
                    </div>
                      <div class="flex xs12" v-if="notifyStore.employeeAssignedNotifications.length">
                        <va-list>
                            <va-list-label> Employee Assigned Notifications </va-list-label>
                            <va-list-item
                                class="list__item"
                                v-for="(notify, index) in notifyStore.employeeAssignedNotifications"
                                :key="index"
                                @click="go({name:'userProfile',params:{user:notify.data.user_id}},notify.id)"
                            >
                                <va-list-item-section avatar >
                                    <va-avatar :size="40">
                                     <img :src="notify.fromUser.avatar.url" />
                                    </va-avatar>
                                </va-list-item-section>

                                <va-list-item-section>
                                    <va-list-item-label>
                                     <b>  {{notify.fromUser.name}}</b>
                                    </va-list-item-label>

                                    <va-list-item-label
                                      
                                        :lines="index + 1"
                                    >
                                        {{ notify.data.message }}
                                    </va-list-item-label>
                                </va-list-item-section>

                                <va-list-item-section icon>
                                    <va-icon
                                        name="remove_red_eye"
                                        color="background-tertiary"
                                    />
                                </va-list-item-section>
                            </va-list-item>
                        </va-list>
                    </div>
                    <div class="flex xs12">
                        <div class="item actions-btns">
                            <va-button
                                color="danger"
                                size="small"
                                @click="close"
                                ><va-icon class="material-icons">close</va-icon>
                                Close</va-button
                            >
                        </div>
                    </div>
                </div>
            </div>
        </va-inner-loading>
    </va-modal>
</template>

<script>
import { defineComponent, ref, watch,computed } from "vue";
import {notificationStore} from '../store/notification';
import {useRouter} from 'vue-router';

import statusBtnVue from "../Components/statusBtn.vue";

export default defineComponent({
    components:{
statusBtnVue
    },
    model: {
        prop: "show",
        event: "change",
    },
    props: {
        show: {
            type: Boolean,
            default: true,
        },
       
    },
    setup(props, { emit }) {
        const notifyStore = notificationStore();
        const router = useRouter();
       
       
        const busy = ref(false);
        const title = "Notifications";
        const close = () => {
            emit("update:show", false);
        };

         const go = (to,id)=>{
        axios.put(route('api.markAsReadNotify',{id}),{})
            close()
            router.push(to);
        }
      

        return {
            title,
            busy,
            props,
            close,
            go,
            notifyStore
        };
    },
});
</script>

<style scoped lang="scss">
.list__item{
    cursor: pointer;
    border-bottom: 1px solid #0000001f;
    padding: 3px 0;
    &:hover{
        background-color: #d8f5d84d;
    }
    
}
.form-title {
    .text {
        font-weight: bold;
    }
}
.actions-btns {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
    button {
        margin: 0 5px;
    }
}
</style>
