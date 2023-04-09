<template>
  <el-button type="primary" @click="back">
    <el-icon>
      <d-arrow-left />
    </el-icon>
    <span>{{ props.title }}</span>
  </el-button>
</template>

<script>
import { DArrowLeft } from "@element-plus/icons-vue";
export default {
  components: {
    DArrowLeft,
  },
  props: {
    title: { type: String, default: "Back" },
  },
  setup(props, { emit }) {
    const back = () => {
      history.go(-1);
    };
    return { props, back };
  },
};
</script>
