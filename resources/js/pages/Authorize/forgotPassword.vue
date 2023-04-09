<template>
  <div class="login-page">
    <el-card>
      <template #header>
        <div class="card-header">
          <span>Forget Password</span>
        </div>
      </template>

      <el-form
        ref="ruleFormRef"
        :model="ruleForm"
        :rules="rules"
        label-position="top"
        v-loading="busy"
      >
       <el-alert title="we have emailed your password reset link" type="success" />
        <el-form-item label="Email" prop="email" :error="errors.userName">
          <el-input
            size="large"
            placeholder="Please Input"
            v-model="ruleForm.email"
          />
        </el-form-item>



        <div class="login-btn-box">
          <el-button size="large" type="primary" @click="login(ruleFormRef)">
            <el-icon>
              <open />
            </el-icon>
            <span class="ml-2">Send Password Reset Link</span>
          </el-button>
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
      email: "",
    });

    const ruleForm = reactive({
      email: ""
    });

    const rules = reactive({
      email: [
        {
          required: true,
          message: "Email Must be Required",
          trigger: "change",
        },
      ],

    });



    const login = async (formEl) => {
      await formEl.validate(async (valid, fields) => {
        if (valid) {
          try {
            const url = route('api.forgetPassword');
            busy.value = true;
            const { data } = await axios.post(url, {
              email: ruleForm.email,
            });

          

            router.push({ name: "home" });

            // console.log(data);
          } catch (error) {
            console.error(error);

            const res = error?.response;
            if (res && res.status == 422) {
              const list = res.data.errors;

              if (hasIn(list, "loginEmail")) {
                errors.userName = list.loginEmail[0];
              }

              if (hasIn(list, "loginPassword")) {
                errors.password = list.loginPassword[0];
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
