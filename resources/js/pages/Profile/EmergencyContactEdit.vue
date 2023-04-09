<template>
  <el-dialog
    :model-value="props.show"
    title="Emergency Contacts"
    :before-close="handleClose"
    style="max-width: 470px"
  >
    <el-form
      label-position="right"
      label-width="100px"
      :model="formFields"
      ref="ruleFormRef"
      style="max-width: 460px"
    >
      <el-card
        v-for="(e, i) in formFields.items"
        :key="i"
        class="box-card mb-2"
      >
        <div class="edit-circle" v-if="i>0">
          <el-button
          type="danger"
            size="small"
            circle
            @click="remove(i)"
          >
            <el-icon>
             <delete></delete>
            </el-icon>
          </el-button>
        </div>
        <el-form-item label="Type" :prop="`items.${i}.type`" :rules="typeRules">
          <el-select v-model="e.type" :disabled="true">
            <el-option label="Primary" value="primary" />
            <el-option label="Secondary" value="secondary" />
          </el-select>
        </el-form-item>
           <el-form-item
          label="Name"
          :prop="`items.${i}.name`"
          :rules="nameRules"
        >
          <el-input v-model="e.name" />
        </el-form-item>
        <el-form-item
          label="Relationship"
          :prop="`items.${i}.relationship`"
          :rules="relationshipRules"
        >
          <el-select v-model="e.relationship">
            <el-option label="Father" value="father" />
            <el-option label="Mother" value="mother" />
            <el-option label="Wife" value="wife" />
            <el-option label="Brother" value="brother" />
            <el-option label="Cousin" value="cousin" />
          </el-select>
        </el-form-item>
        
        <el-form-item
          label="Phone"
          :prop="`items.${i}.phone`"
          :rules="phoneRules"
        >
          <el-input v-model="e.phone" />
        </el-form-item>
      </el-card>
      <div
        class="mt-2"
        style="width: 100%; text-align: center"
        v-if="formFields.items.length < 2"
      >
        <el-button @click="more(i)">
            <el-icon>
                <more></more>
            </el-icon>
            More
        </el-button>
      </div>
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
import {Delete,More} from "@element-plus/icons-vue";
export default {
    components:{
       Delete,
       More
    },
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    items: {
      type: Array,
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

    const formFields = reactive({ items: [] });

    props.items.forEach((item) => {
      formFields.items.push({
        type: item.type,
        relationship: item.relationship,
        phone: item.phone,
        name:item.name
      });
    });

    const more = (i) => {
      formFields.items.push({
        type: "secondary",
        relationship: "",
        phone: "",
        name:''
      });
    };

    const remove = (i)=>{
        formFields.items.splice(i,1)
    }

    const nameRules = {
      required: true,
      message: "Type Required",
      trigger: "blur",
    };

    const typeRules = {
      required: true,
      message: "Type Required",
      trigger: "blur",
    };

    const relationshipRules = {
      required: true,
      message: "Relationship Required",
      trigger: "blur",
    };

    const phoneRules = {
      required: true,
      message: "Phone Required",
      trigger: "blur",
    };

    const submit = async (formEl) => {
      try {
        if (!formEl) return;
        await formEl.validate(async (valid, fields) => {
          if (valid) {
          
            await axios.put(route("api.emergencyContactUpdate"), formFields);
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
      nameRules,
      typeRules,
      relationshipRules,
      phoneRules,
      ruleFormRef,
      handleClose,
      submit,
      more,
      remove
    };
  },
};
</script>

<style lang="scss" scoped>
</style>