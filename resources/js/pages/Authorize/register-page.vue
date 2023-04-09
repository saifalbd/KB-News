<template>
    <div class="login-page">
        <el-card>
            <el-form
                ref="ruleFormRef"
                :model="ruleForm"
                :rules="rules"
                label-position="top"
                v-loading="busy"
            >
                <el-form-item label="Name" prop="name" :error="errors.name">
                    <el-input size="large" v-model="ruleForm.name"></el-input>
                </el-form-item>

                <el-form-item label="Email" prop="email" :error="errors.email">
                    <el-input size="large" v-model="ruleForm.email"></el-input>
                </el-form-item>

                <el-form-item label="Phone" prop="phone" :error="errors.phone">
                    <el-input size="large" v-model="ruleForm.phone"></el-input>
                </el-form-item>
                <el-form-item label="Password" prop="password" :error="errors.password">
                    <el-input
                        size="large"
                        v-model="ruleForm.password"
                        type="password"
                        show-password
                    ></el-input>
                </el-form-item>

                <el-form-item label="Password" prop="password_confirmation" :error="errors.password_confirmation">
                    <el-input
                        size="large"
                        v-model="ruleForm.password_confirmation"
                         type="password"
                        show-password
                    ></el-input>
                </el-form-item>

                <div class="login-btn-box">
                    <el-button
                        size="large"
                        type="primary"
                        @click="login(ruleFormRef)"
                    >
                        <el-icon>
                            <open />
                        </el-icon>
                        <span class="ml-2">Register</span>
                    </el-button>
                </div>

                <div class="redirect-info">
                    Already have an account? <el-link href="/"><b>Login</b></el-link>
                </div>
            </el-form>
        </el-card>
    </div>
</template>

<script>
import { defineComponent, reactive, ref } from "vue";
import { mainStore } from "../../store";
import { Open } from "@element-plus/icons-vue";
import { hasIn } from "lodash";
import {useRouter} from 'vue-router';

export default defineComponent({
    components: {
        Open,
    },
    setup() {
        const ruleFormRef = ref();
        const busy = ref(false);
        const router = useRouter();
        const ruleForm = reactive({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            phone: "",
        });


        const errors = reactive({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            phone: "",
        });

        const rules = reactive({
            name: [
                {
                    required: true,
                    message: "Name Must be Required",
                    trigger: "change",
                },
            ],
            email: [
                {
                    required: true,
                    message: "Email Must be Required",
                    trigger: "change",
                },
            ],
            phone: [
                {
                    required: true,
                    message: "Phone Must be Required",
                    trigger: "change",
                },
            ],
            password: [
                {
                    required: true,
                    message: "Password Must be Required",
                    trigger: "change",
                },
            ],
            password_confirmation: [
                {
                    required: true,
                    message: "Password Must be Required",
                    trigger: "change",
                },
            ],
        });

        const login = async (formEl) => {
            await formEl.validate(async (valid, fields) => {
                if (valid) {
                    try {
                        const url = "/register";
                        const { data } = await axios.post(url, ruleForm);
                        const main = mainStore();

                        //  main.addToken(data.token)
                        //  main.addUser(data.user);

                        router.push({ name: "login" });

                        // console.log(data);
                    } catch (error) {
                        console.error(error);
                         const res = error?.response;
            if (res && res.status == 422) {
              const list = res.data.errors;

            

              if (hasIn(list, "name")) { errors.name = list.name[0];}
              if (hasIn(list, "email")) { errors.email = list.email[0];}
              if (hasIn(list, "password")) { errors.password = list.password[0];}
              if (hasIn(list, "password_confirmation")) { errors.password_confirmation = list.password_confirmation[0];}
              if (hasIn(list, "phone")) { errors.phone = list.phone[0];}

            }}
                    
                }
            });
        };

        return { busy, ruleFormRef, ruleForm, rules,errors, login };
    },
});
</script>

<style scoped></style>
