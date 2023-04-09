<template>
  <el-dialog
    :model-value="props.show"
    title="Personal Information"
    :before-close="handleClose"
    style="max-width: 470px"
  >
    <el-form
      label-position="right"
      label-width="150px"
      :model="formFields"
      :rules="rules"
      ref="ruleFormRef"
      style="max-width: 460px"
    >
      <el-form-item label="Nationality" prop="nationality">
        <el-input v-model="formFields.nationality" />
      </el-form-item>
      <el-form-item label="Religion" prop="religion">
        <el-select v-model="formFields.religion" placeholder="Select">
          <el-option label="Islam" value="islam" />
          <el-option label="Christianity" value="christianity" />
          <el-option label="Hinduism" value="hinduism" />
        </el-select>
      </el-form-item>

      <el-form-item label="Marital Status" prop="marital_status">
        <el-select v-model="formFields.marital_status" placeholder="Select">
          <el-option label="married" value="married" />
          <el-option label="un married" value="un married" />
        </el-select>
      </el-form-item>
    </el-form>

    <template #footer>
      <span class="dialog-footer">
        <el-button @click="handleClose(() => {})">Cancel</el-button>
        <el-button type="primary" @click="submit(ruleFormRef)">
          Confirm
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script>
import { ref, reactive } from "vue";

export default {
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    item: {
      type: Object,
      required: true,
    },
  },
  setup(props, { emit }) {
    const ruleFormRef = ref();
    const dialogVisible = ref(false);
    const handleClose = (done) => {
      done();
      emit("update:show", false);
    };

    const formFields = reactive({
      nationality: props.item.nationality,
      religion: props.item.religion,
      marital_status: props.item.marital_status,
    });

    const rules = reactive({
      nationality: [
        {
          required: true,
          message: "nationality Required",
          trigger: "change",
        },
      ],
      religion: [
        {
          required: true,
          message: "religion Required",
          trigger: "change",
        },
      ],
      marital_status: [
        {
          required: true,
          message: "marital status Required",
          trigger: "change",
        },
      ],
    });

    const submit = async (formEl) => {
      try {
        if (!formEl) return;
        await formEl.validate(async (valid, fields) => {
          if (valid) {
            await axios.put(route("api.updatePersonalInformation"), formFields);
            emit("update:show", false);
          }
        });
      } catch (error) {
        console.error(error);
      }
    };

    return {
      props,
      dialogVisible,
      formFields,
      rules,
      ruleFormRef,
      handleClose,
      submit,
    };
  },
};
</script>

<style lang="scss" scoped>
</style>