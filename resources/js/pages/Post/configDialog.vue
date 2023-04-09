<template>
  <el-dialog
    v-model="props.show"
    :title="props.title"
    width="30%"
    :before-close="handleClose"
  >
    <span>This is a message</span>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="close">Cancel</el-button>
        <el-button type="primary" @click="close">
          Confirm
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script>
export default {
    props:{
        show:{
            type:Boolean,
            required:true
        },
        title:{
            type:String,
            default:'title'
        },
        id:{
            type:Number,
              required:true
        }
    },
    setup (props,{emit}) {

         const close = () => {
      emit("update:show", false);
    };
        
        const handleClose = (done)=>{
             done();
      close();
        }

        return {props,handleClose,close}
    }
}
</script>

<style lang="scss" scoped>

</style>