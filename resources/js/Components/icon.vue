<template>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <path
      :d="slots.default"
    />
  </svg>
</template>

<script>
export default {
  props: {

    size: {
      type: Number,
      default: 24,
    },
  },
  setup(props,{slots}) {
    return {props,slots};
  },
};
</script>

<style lang="scss" scoped>
</style>