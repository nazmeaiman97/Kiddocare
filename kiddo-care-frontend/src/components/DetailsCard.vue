<template>
    <el-card class="card" :shadow="shadow">
        <slot></slot>
    </el-card>
</template>
  
<script setup lang="ts">
const props = defineProps({
    shadow: {
        type: String,
        default: 'always'
    }
});
</script>
  
<style scoped>
.card {
    border-radius: 8px;
    padding: 20px;
    width: 100%;
    max-width: 500px;
}
</style>
  