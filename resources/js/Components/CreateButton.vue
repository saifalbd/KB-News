<template>
 
    <el-button type="primary" plain  @click="emit('click',true)">
        <el-icon>
            <element-plus/>
        </el-icon>
        <span>{{props.title}}</span>
    </el-button>
</template>

<script>
import {ElementPlus} from '@element-plus/icons-vue';
export default {
    components:{
        ElementPlus
    },
    props:{
        title:{type:String,required:true}
    },
    setup (props,{emit}) {
        return {props,emit}
    }
}
</script>
