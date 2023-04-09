<template>
  <va-button-dropdown
    v-if="dropdown"
    :label="status.title"
    :preset="props.preset"
    :loading="props.loading"
    :plain="props.plain"
    :size="props.size"
    :color="status.color"
    :text-color="props.textColor"
    :border-color="props.borderColor"
  >
    <slot></slot>
  </va-button-dropdown>
  <va-button
    v-else
    :preset="props.preset"
    :loading="props.loading"
    :plain="props.plain"
    :size="props.size"
    :color="status.color"
    :text-color="props.textColor"
    :border-color="props.borderColor"
    >{{ status.title }}</va-button
  >
</template>

<script>
import { statusList } from "../Plugins/utility";
import { ref, watch,computed } from "vue";
export default {
  props: {
    dropdown: {
      type: Boolean,
      default: false,
    },
    loading: {
      type: Boolean,
      default: false,
    },
    plain: {
      type: Boolean,
      default: false,
    },
    preset: {
      type: String,
      default: "secondary",
    },
    size: {
      type: String,
      default: "medium",
    },
    color: {
      type: String,
      default: "primary",
    },
    textColor: {
      type: String,
      default: "",
    },
    borderColor: {
      type: String,
      default: "",
    },
    status: {
      type: [Number,String],
      required: true,
    },
  },
  setup(props) {
    let status = computed(()=>{
      return statusList[parseInt(props.status)];
    })

  

    return { props, status };
  },
};
</script>

<style lang="scss" scoped>
</style>