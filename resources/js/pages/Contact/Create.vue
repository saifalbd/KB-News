<template>
    <form-dialog
        :show="props.show"
        @update:show="emit('update:show', $event)"
        :busy="busy"
        title="Create Contact"
        @add="save"
    >
        <el-form label-position="top">
            <el-row :gutter="24">

                <el-col :span="24">
                          <div class="avatar-box">
                      <div class="inner" >
                        <el-avatar :size="120" :src="src" />
                        <div class="camera-icon"><el-button type="info" circle>
                          <el-icon>
                            <camera/>
                          </el-icon>
                        </el-button>

                        </div>
                            <input type="file" @change="fileChange">
                      </div>
                  
                    </div>
                </el-col>
                
                <el-col :span="24">
                    <div class="input-box">
                        <el-form-item prop="name">
                            <el-input v-model="form.name">
                                <template #prepend>Name</template>
                            </el-input>
                        </el-form-item>
                    </div>
                </el-col>
                <!-- start input Coll -->
                <el-col
                    :sm="24"
                    :md="24"
                    v-for="(phone, i) in form.phone"
                    :key="i"
                >
                    <!-- start input box -->
                    <div class="input-box">
                        <el-input v-model="phone.value">
                            <template #prepend>Phone</template>
                        </el-input>

                        <div class="group-box">
                            <el-button-group>
                                <el-button
                                    size="small"
                                    type="primary"
                                    plain
                                    @click="morePhone"
                                    v-if="i == form.phone.length - 1"
                                >
                                    <el-icon>
                                        <element-plus />
                                    </el-icon>
                                </el-button>
                                <el-button
                                    size="small"
                                    type="danger"
                                    plain
                                    @click="removePhone(i)"
                                    v-if="i"
                                >
                                    <el-icon class="el-icon--right">
                                        <remove />
                                    </el-icon>
                                </el-button>
                            </el-button-group>
                        </div>
                    </div>
                </el-col>

                <!-- start input Coll -->
                <el-col
                    :sm="24"
                    :md="24"
                    v-for="(email, i) in form.email"
                    :key="i"
                >
                    <!-- start input box -->

                    <div class="input-box">
                        <el-input v-model="email.value">
                            <template #prepend>Email</template>
                        </el-input>

                        <div class="group-box">
                            <el-button-group>
                                <el-button
                                    size="small"
                                    type="primary"
                                    plain
                                    @click="moreEmail"
                                    v-if="i == form.email.length - 1"
                                >
                                    <el-icon>
                                        <element-plus />
                                    </el-icon>
                                </el-button>
                                <el-button
                                    size="small"
                                    type="danger"
                                    plain
                                    @click="removeEmail(i)"
                                    v-if="i"
                                >
                                    <el-icon class="el-icon--right">
                                        <remove />
                                    </el-icon>
                                </el-button>
                            </el-button-group>
                        </div>
                    </div>
                </el-col>

                <!-- start input Coll -->
                <el-col
                    :sm="24"
                    :md="24"
                    v-for="(web, i) in form.website"
                    :key="i"
                >
                    <!-- start input box -->
                    <div class="input-box">
                        <el-input v-model="web.value">
                            <template #prepend>Website</template>
                        </el-input>

                        <div class="group-box">
                            <el-button-group>
                                <el-button
                                    size="small"
                                    type="primary"
                                    plain
                                    @click="moreWebsite"
                                    v-if="i == form.website.length - 1"
                                >
                                    <el-icon>
                                        <element-plus />
                                    </el-icon>
                                </el-button>
                                <el-button
                                    size="small"
                                    type="danger"
                                    plain
                                    @click="removeWebSite(i)"
                                    v-if="i"
                                >
                                    <el-icon class="el-icon--right">
                                        <remove />
                                    </el-icon>
                                </el-button>
                            </el-button-group>
                        </div>
                    </div>
                </el-col>
                <el-col>
                   <el-form-item label="Address">
                     <el-input type="textarea" v-model="form.address"></el-input>
                   </el-form-item>
                </el-col>
            </el-row>
        </el-form>
    </form-dialog>
</template>

<script>
import { reactive, ref } from "@vue/reactivity";
import FormDialog from "../../Components/FormDialog.vue";
import { ElementPlus, Remove,Camera } from "@element-plus/icons-vue";
export default {
    components: { FormDialog, ElementPlus, Remove,Camera },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
    },

    setup(props, { emit }) {
        let busy = ref(false);
        const form = reactive({
            name: "",
            phone: [{ value: "" }],
            email: [{ value: "" }],
            website: [{ value: "" }],
            address: '',
        });


    
        

        const morePhone = () => form.phone.push({ value: "" });
        const removePhone = (i) => form.phone.splice(i, 1);
        const moreEmail = () => form.email.push({ value: "" });
        const removeEmail = (i) => form.email.splice(i, 1);
        const moreWebsite = () => form.website.push({ value: "" });
        const removeWebSite = (i) => form.website.splice(i, 1);
        const moreAddress = (i) => {};

           const src = ref(props.src);
        const avatar = ref(null);

        const fileChange = (event) => {
            let files = event.target.files;
            if (files.length) {
                let file = files[0];
                avatar.value = file;
                let reader = new FileReader();
                reader.onload = () => {
                    let data = reader.result;
                    src.value = data;
                };
                reader.readAsDataURL(file);
            }
        };

        const save = async ()=>{
            try {
                    let d = new FormData();
        d.append('name',form.name);
        d.append('address',form.address);
        form.phone.forEach((e,i)=>{d.append(`phone[${i}]`,e.value) })
        form.email.forEach((e,i)=>{d.append(`email[${i}]`,e.value) })
        form.website.forEach((e,i)=>{d.append(`website[${i}]`,e.value) })
        if(avatar.value){
            d.append('avatar',avatar.value)
        }
        
        const {data} = await axios.post(route('api.contact.store'),d);

                
            } catch (error) {
                console.error(error)
            }
        }

        return {
            props,
            form,
            emit,
            busy,
            src,
            avatar,
            fileChange,
            save,
            morePhone,
            removePhone,
            moreEmail,
            removeEmail,
            moreWebsite,
            removeWebSite,
            moreAddress,
        };
    },
};
</script>

<style lang="scss" scoped>
.input-box {
    display: grid;
    grid-template-columns: auto 100px;
    margin-bottom: 5px;
    .group-box {
        display: flex;
        justify-content: center;
        align-content: center;

        align-items: center;
    }
}
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
    input{
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
    }
  }

}
</style>
