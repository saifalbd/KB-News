<template>
  <form-dialog
    :show="props.show"
    @update:show="showUpdate"
    :busy="busy"
    :isNext="!checkEmail"
    title="Create User"
    @add="save"
    @next="next"
    fullscreen
  >
    <va-form ref="form">
      <div class="layout gutter--md">
        <div class="row align-content--center">
          <div class="flex xs12" v-if="checkEmail">
            <va-input
              :readonly="canUser"
              v-model="name"
              label="Name *"
              placeholder="Name Here"
              :rules="rs('Name', true)"
            />
          </div>
          <div class="flex xs12 mt-2">
            <va-input
              :readonly="canUser"
              v-model="email"
              label="Email *"
              placeholder="Email Here"
        
              :rules="rs('Email', { required: true, email: true })"
            />
          </div>
          <div class="flex xs12 mt-2">
            <va-input
              :readonly="canUser"
              v-if="checkEmail"
              v-model="phone"
              label="Phone"
              placeholder="Phone Here"
              :rules="rs('Phone', true)"
            />
          </div>
                <div class="flex xs6 mt-2" v-if="checkEmail">
            <va-input
        
          v-if="!canUser"
              v-model="password"
              label="Password"
              placeholder="Password Here"
              :rules="rs('password', true)"
            />
          </div>
            <div class="flex xs6 mt-2" v-if="checkEmail">
            <va-input
           
              v-if="!canUser"
              v-model="confirm_password"
              label="Retype Password"
              placeholder="Retype Password Here"
              :rules="rs('password', true)"
            />
          </div>

          <div class="flex xs12 mt-2">
            <va-select
              v-if="checkEmail"
              v-model="roles"
              label="Roles *"
              :rules="rs('roles', true)"
              text-by="name"
              value-by="id"
              :options="props.roles"
              multiple
            >
            </va-select>
          </div>
        </div>
      </div>
    </va-form>
  </form-dialog>
</template>

<script>
import { ref } from "vue";
import FormDialog from "../../Components/FormDialog.vue";
import { rs } from "../../Plugins/Rule";
import { values } from "lodash";
import { validErorrs } from "../../Plugins/utility";
export default {
  components: { FormDialog },

  props: {
    roles: {
      type: Array,
      required: true,
    },
    show: {
      type: Boolean,
      default: false,
    },
  },

  setup(props, { emit }) {
    let busy = ref(false);
    const canUser = ref(false);
    const checkEmail = ref(false);
    const form = ref(null);
    let name = ref("");
    let email = ref("");
    let phone = ref("");
    let password = ref('');
    let confirm_password = ref('')

    let roles = ref([]);

    let rules = {
      title: [(v) => !!v || "title are requies"],
    };

    const save = async () => {
      let url = route("api.user.store");
      let valid = await form.value.validate();
      if (!valid) return null;
      try {
        const { data } = await axios.post(url, {
          name: name.value,
          email: email.value,
          phone: phone.value,
          roles: roles.value,
          password:password.value,
          confirm_password:confirm_password.value,
          
        });
        emit(
          "push",
          addProtos(data, {
            action: true,
            showEdit: false,
          })
        );
      } catch (error) {
        console.error(error);

        validErorrs(error);
      }
    };

    const next = async () => {
      try {
        let filter =
          /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        const is = filter.test(email.value);
        if (!is) return null;
        const url = route("api.user.showByEmail", { email: email.value });
        const { data } = await axios.get(url);
        const can = values(data).length ? data : null;
    
        if (can) {
          name.value = can.name;
          phone.value = can.phone
          canUser.value = true;
          roles.value = can.roles.map(e=>e.id)
        }else{
                canUser.value = false
        }

        checkEmail.value = true;
      } catch (error) {
        console.error(error);
      }
    };

    const showUpdate = (val) => {
      if (!val) {
        checkEmail.value = false;
        canUser.value = false;
        name.value = "";
        phone.value = "";
      }

      emit("update:show", val);
    };

    return {
      props,
      form,
      emit,
      checkEmail,
      next,
      rs,
      save,
      busy,
      rules,
      save,
      name,
      phone,
      email,
      password,
      confirm_password,
      roles,
      showUpdate,
      canUser,
    };
  },
};
</script>

<style lang="scss" scoped></style>
