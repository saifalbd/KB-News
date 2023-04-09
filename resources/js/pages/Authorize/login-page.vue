<template>
  <div class="login-page">
    <el-card>
      <template #header>
        <div class="card-header">
          <span>Login</span>
        </div>
      </template>

      <el-form
        ref="ruleFormRef"
        :model="ruleForm"
        :rules="rules"
        label-position="top"
        v-loading="busy"
      >
        <el-form-item label="Email" prop="userName" :error="errors.userName">
          <el-input
            size="large"
            placeholder="Please Input"
            v-model="ruleForm.userName"
          />
        </el-form-item>

        <el-form-item label="Password" prop="password" :error="errors.password">
          <el-input
            show-password
            size="large"
            placeholder="Please Input"
            v-model="ruleForm.password"
          />
        </el-form-item>

        <div class="login-btn-box">
          <el-button size="large" type="primary" @click="login(ruleFormRef)">
            <el-icon>
              <open />
            </el-icon>
            <span class="ml-2">Login</span>
          </el-button>
        </div>
        <div class="redirect-info">
          Don't have an account yet?
          <el-link href="/register"><b>Register</b></el-link>
        </div>
          <div class="redirect-info">
         Forgot
          <el-link href="/forgot-password"><b>Password</b></el-link>
        </div>
      </el-form>
    </el-card>
  </div>
</template>

<script>
import { defineComponent, ref, onMounted, reactive } from "vue";
import { mainStore } from "../../store";
import { useRouter } from "vue-router";
import { Open } from "@element-plus/icons-vue";
import { hasIn } from "lodash";
import { ElNotification } from 'element-plus'
export default defineComponent({
  components: {
    Open,
  },
  setup() {
    const main = mainStore();
    const router = useRouter();
    const busy = ref(false);

    const ruleFormRef = ref();

    const errors = reactive({
      userName: "",
      password: "",
    });

    const ruleForm = reactive({
      userName: "",
      password: "",
    });

    const rules = reactive({
      userName: [
        {
          required: true,
          message: "Email Must be Required",
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
    });


const warning = (message) => {
  ElNotification({
    title: 'Warning',
    message,
    type: 'warning',
  })
}


    const login = async (formEl) => {
      await formEl.validate(async (valid, fields) => {
        if (valid) {
          try {
            const url = "/login";
            busy.value = true;
            const { data } = await axios.post(url, {
              email: ruleForm.userName,
              password: ruleForm.password,
            });

            main.addToken(data.token);
            main.addUser(data.user);

            console.log(data)

            router.push({ name: "home" });

            // console.log(data);
          } catch (error) {
            console.error(error);

            const res = error?.response;
            if (res && res.status == 422) {
              const list = res.data.errors;

              if (hasIn(list, "loginEmail")) {
                let error = list.loginEmail[0];
                errors.userName = error
                warning(error)
              }

              if (hasIn(list, "loginPassword")) {
                let error =  list.loginPassword[0];
                errors.password = error
                            warning(error)
              }
            }
          }
        } else {
          console.log("error submit!", fields);
        }
        busy.value = false;
      });
    };

    return { ruleForm, rules, errors, ruleFormRef, busy, login };
  },
});
</script>

<style scoped></style>
