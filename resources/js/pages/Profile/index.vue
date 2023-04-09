<template>
  <app-layout :busy="false">
    <el-progress
      :percentage="100"
      status="success"
      :indeterminate="true"
      :duration="5"
      v-if="busy"
    />
    <div class="profile" v-else>
    <section class="top-section">
        <div class="edit-circle" v-if="!user_id">
          <el-button type="primary" size="small" circle @click="showProfileEdit = true">
            <el-icon>
              <edit></edit>
            </el-icon>
          </el-button>
        </div>
        <el-row class="s-body" :gutter="24">
          <el-col class="left-side" :sm="24" :md="12">
            <el-row :gutter="24">
              <el-col :sm="24" :md="6">
                    <div class="avatar-box">
                      <div class="inner" >
                        <el-avatar :size="120" :src="d.avatar.url" />
                        <div class="camera-icon" v-if="!user_id" @click="showAvatarModel = true"><el-button type="info" circle>
                          <el-icon>
                            <camera/>
                          </el-icon>
                        </el-button>

                        </div>
                      </div>
                    </div>
               
              </el-col>
              <el-col :sm="24" :md="18">
                <el-descriptions
                  direction="horizontal"
                  :column="1"
                  size="large"
                  border
                >
                  <el-descriptions-item label="Name:">
                    {{ d.name }}
                  </el-descriptions-item>
                  <el-descriptions-item label="Designation:"
                    >
                    {{d.roles.map(e=>e.name).join(',')}}
                    </el-descriptions-item
                  >
                  <el-descriptions-item label="Joining:"
                    >{{atNow(d.created_at)}}</el-descriptions-item
                  >
                </el-descriptions>
                <div style="text-align: center" class="mt-3">
                  <el-button type="primary">
                    <el-icon>
                      <edit></edit>
                    </el-icon>
                    Message
                  </el-button>
                </div>
              </el-col>
            </el-row>
          </el-col>
          <el-col class="right-side" :sm="24" :md="12">
            <el-descriptions
              direction="horizontal"
              :column="1"
              size="large"
              border
            >
              <el-descriptions-item label="Phone:">{{
                d.phone
              }}</el-descriptions-item>
              <el-descriptions-item label="Email:">{{
                d.email
              }}</el-descriptions-item>
              <el-descriptions-item label="Birthday:">{{
                d.profile.birth_date
              }}</el-descriptions-item>
              <el-descriptions-item label="Address:"
                >{{d.profile.address}}</el-descriptions-item
              >
              <el-descriptions-item label="Gender:">{{
                d.profile.gender
              }}</el-descriptions-item>
            </el-descriptions>
          </el-col>
        </el-row>
      </section>
      <section class="mt-3">
        <el-row :gutter="24">
          <el-col :sm="24" :md="12">
            <div>
              <el-card class="box-card">
                <div class="edit-circle" v-if="!user_id">
                  <el-button type="primary" size="small" circle @click="showPersonalInfoEdit = true">
                    <el-icon>
                      <edit></edit>
                    </el-icon>
                  </el-button>
                </div>

                <el-descriptions
                  title="Personal Informations"
                  direction="horizontal"
                  :column="1"
                  size="large"
                  border
                >
                  <el-descriptions-item label="Nationality:">{{
                    d.personal_information.nationality
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Religion:">{{
                    d.personal_information.religion
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Birthday:">{{
                    d.profile.birth_day
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Marital status:">{{
                    d.personal_information.marital_status
                  }}</el-descriptions-item>
                </el-descriptions>
              </el-card>
            </div>
          </el-col>
                 <el-col :sm="24" :md="12">
            <div>
              <el-card class="box-card">
                <div class="edit-circle" v-if="!user_id">
                  <el-button type="primary" size="small" circle @click="showEmergencyConEdit=true">
                    <el-icon>
                      <edit></edit>
                    </el-icon>
                  </el-button>
                </div>
                <h3 class="mb-2">Emergency Contacts</h3>
                <el-descriptions v-for="(con,i) in d.emergency_contacts" :key="i"
                  :title="con.type"
                  direction="horizontal"
                  :column="1"
                  size="large"
                  border
                >
                  <el-descriptions-item label="Type:">{{
                    con.type
                  }}</el-descriptions-item>
                       <el-descriptions-item label="Name:">{{
                    con.name
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Relationship:">{{
                    con.relationship
                  }}</el-descriptions-item>
                  <el-descriptions-item label="Phone:">{{
                    con.phone
                  }}</el-descriptions-item>
                 
                </el-descriptions>
              </el-card>
            </div>
          </el-col>
        </el-row>
      </section>
      <edit-profile-vue v-model:show="showProfileEdit" :roleList="roleList" :item="d"></edit-profile-vue>
      <personal-information-edit-vue v-model:show="showPersonalInfoEdit" :item="d.personal_information"></personal-information-edit-vue>
      <emergency-contact-edit-vue v-model:show="showEmergencyConEdit" :items="d.emergency_contacts"></emergency-contact-edit-vue>
      <change-avatar v-model:show="showAvatarModel" v-model:src="d.avatar.url"></change-avatar>
    </div>
    
  </app-layout>
</template>

<script>
import { Edit,Camera } from "@element-plus/icons-vue";

import AppLayout from "../../Layouts/app-layout.vue";
import { storeToRefs } from 'pinia'
import { reactive, ref } from "vue";
import EditProfileVue from './EditProfile.vue';
import PersonalInformationEditVue from './PersonalInformationEdit.vue';
import EmergencyContactEditVue from './EmergencyContactEdit.vue';
import ChangeAvatar from './ChangeAvatar.vue';
import { mainStore } from "../../store/index";
import moment from 'moment';
import { dropdowns } from '../../Plugins/utility';
export default {
  props:{
    user_id:{
      type:[Number,String]
    }
  },
  components: {
    AppLayout,
    Edit,
    Camera,
    EditProfileVue,
    PersonalInformationEditVue,
    EmergencyContactEditVue,
    ChangeAvatar
  },
  setup(props) {
    const user_id  = props.user_id;
    const roleList = reactive([]);
      const main = mainStore();
      const { canRole } = storeToRefs(main);
    let showProfileEdit = ref(false);
    let showPersonalInfoEdit = ref(false);
    let showEmergencyConEdit = ref(false);
    let showAvatarModel = ref(false);
    const busy = ref(true);
    const d = ref(null);

    axios.get(route("api.profile", { user: props.user_id?props.user_id:main.auth_id })).then(({ data }) => {
      d.value = data;
      busy.value = false;
    });

    dropdowns('roles',(data)=>{
      roleList.push(...data)
    })

    const atNow = (date)=>moment(date).fromNow();

    return {atNow, d,roleList, busy,showProfileEdit,showPersonalInfoEdit,showEmergencyConEdit,showAvatarModel,user_id };
  },
};
</script>

<style lang="scss" scoped>
.avatar-box{
  position: relative;
  display: flex;
  justify-content: center;
  .inner{
    position: relative;
    .camera-icon{
      position: absolute;
      bottom: 0px;
      right: 0;
      transform: translate(0px,-10px);
      border: 2px solid goldenrod;
      border-radius: 50%;
    }
  }
}
</style>
