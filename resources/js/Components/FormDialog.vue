<template>
  <el-dialog
    v-model="props.show"
    :before-close="handleClose"
    :show-close="false"
  >
    <template #header="{ close, titleId, titleClass }">
      <div
        class="my-header"
        style="display: flex; justify-content: space-between"
      >
        <h4 :id="titleId" :class="titleClass">{{ title }}</h4>
        <el-button type="danger" size="small" @click="close">
          <el-icon class="el-icon--left"><CircleCloseFilled /></el-icon>
          Close
        </el-button>
      </div>
    </template>

    <slot></slot>

    <template #footer>
      <span class="dialog-footer" v-if="!busy">
        <el-button type="primary" @click="next" v-if="props.isNext">
          <el-icon>
            <pointer />
          </el-icon>
          <span>Next</span>
        </el-button>
        <el-button type="primary" @click="add" v-else>
          <el-icon>
            <pointer />
          </el-icon>
          <span> {{ props.isEdit ? "Replace" : "Add" }}</span>
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script>
import { defineComponent } from "vue";
import { CircleCloseFilled, Pointer } from "@element-plus/icons-vue";

export default defineComponent({
  components: { CircleCloseFilled, Pointer },
  model: {
    prop: "show",
    event: "change",
  },
  props: {
    show: {
      type: Boolean,
      default: true,
    },
    isEdit: {
      type: Boolean,
      default: false,
    },
    isNext: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      required: true,
    },
    busy: {
      type: Boolean,
      default: false,
    },
    fullscreen: {
      type: Boolean,
      default: false,
    },
  },
  setup(props, { emit }) {
    const close = () => {
      emit("update:show", false);
    };
    const add = () => {
      emit("add", true);
    };
    const next = () => {
      emit("next", true);
    };
    const handleClose = (done) => {
      done();
      close();
    };
    return {
      props,
      close,
      add,
      next,
      handleClose,
    };
  },
});
</script>

<style scoped lang="scss">
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
