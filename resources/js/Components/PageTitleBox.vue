<template>
    <div class="top-title-box">
        <div class="top-title">{{props.title}}</div>
        <div>
           <slot></slot>
        </div>
    </div>
</template>

<script setup>
import {defineProps} from 'vue'
const props = defineProps({
    title:{type:String,default:'Home Page'},
   
})

</script>
