<template>
  <div class="asside-box">
    <el-menu   :collapse="!props.lg" default-active="1">
      <el-menu-item index="1" @click="go({ name: 'home' })">
        <el-icon><home-filled /></el-icon>
            <template #title><b>Home</b></template>
       
      </el-menu-item>

      <el-menu-item index="2" @click="go({ name: 'contact' })">
        <el-icon><avatar /></el-icon>
   
         <template #title><b>Contacts</b></template>
      </el-menu-item>

      <el-sub-menu index="2">
        <template #title>
          <el-icon><avatar /></el-icon>
          <span style="font-weight:bold">Employees</span>
          
        </template>
        <el-menu-item index="2-1" @click="go({ name: 'employee' })">
          <el-icon><avatar /></el-icon>
          <b>Employees</b>
        </el-menu-item>
        <el-menu-item index="2-2" @click="go({ name: 'department' })">
          <el-icon><connection /></el-icon>
          <b>Department</b>
        </el-menu-item>

        <el-menu-item index="2-3" @click="go({ name: 'designation' })">
          <el-icon><position /></el-icon>
          <b>Designation</b>
        </el-menu-item>
      </el-sub-menu>

   
      <el-menu-item index="4" @click="go({ name: 'category' })">
        <el-icon><connection /></el-icon>
  
           <template #title><b>Category</b></template>
      </el-menu-item>

            <el-menu-item index="5" @click="go({ name: 'tag' })">
        <el-icon><connection /></el-icon>
   
          <template #title><b>Tags</b></template>
      </el-menu-item>

           <el-menu-item index="4" @click="go({ name: 'post.index' })">
        <el-icon><connection /></el-icon>

               <template #title><b>Posts</b></template>
      </el-menu-item>




     
    </el-menu>
  </div>
</template>

<script>
import {
  HomeFilled,
  Collection,
  Management,
  Files,
  Connection,
  Avatar,
  Position,
  User,
} from "@element-plus/icons-vue";
import { defineComponent, reactive } from "vue";

import { useRouter } from "vue-router";

export default defineComponent({
  props:{
    lg:{
      type:Boolean,
      required:true,
    }
  },
  components: {
    HomeFilled,
    Collection,
    Management,
    Files,
    Connection,
    Avatar,
    Position,
    User,
  },
  setup(props) {
    const router = useRouter();
    const go = (to) => {
      router.push(to);
    };

    return {
      props,
      go,
    };
  },
});
</script>

<style lang="scss" scoped>
.asside-box {
}
</style>
