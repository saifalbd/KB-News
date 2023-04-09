<template>
    <div class="info-bar">
        <div class="info-bar-body">
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
import {defineProps} from 'vue'
const props = defineProps({
    title:{
        type:String,
        default:''
    }
})
</script>

<style lang="scss" scoped>



</style>