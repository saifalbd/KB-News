<template>
  <div class="flex-right">
    <el-button-group>
      <el-button
        type="primary"
        size="small"
        @click="emit('viewClick', true)"
        v-if="props.isView"
      >
        <el-icon>
          <expand />
        </el-icon>
      </el-button>
      <el-button
        type="primary"
        size="small"
        @click="emit('editClick', true)"
        v-if="isEdit"
      >
        <el-icon>
          <edit />
        </el-icon>
      </el-button>
      <el-button
        type="danger"
        size="small"
        @click="emit('removeClick', true)"
        v-if="isDelete"
      >
        <el-icon>
          <delete />
        </el-icon>
      </el-button>
    </el-button-group>

    <slot></slot>
  </div>
</template>

<script>
import {
  ArrowLeft,
  ArrowRight,
  Delete,
  Edit,
  Share,
  Expand,
} from "@element-plus/icons-vue";
export default {
  components: {
    ArrowLeft,
    ArrowRight,
    Delete,
    Edit,
    Share,
    Expand,
  },
  props: {
    isView: {
      type: Boolean,
      default: false,
    },
    isEdit: {
      type: Boolean,
      default: true,
    },
    isDelete: {
      type: Boolean,
      default: true,
    },
  },
  setup(props, { emit }) {
    return { emit, props };
  },
};
</script>


