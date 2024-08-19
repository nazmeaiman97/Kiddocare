<template>
    <div class="detail-item">
        <el-text class="label">{{ label }}:</el-text>
        <el-text class="value">{{ value }}</el-text>
    </div>
</template>
  
<script setup lang="ts">
const props = defineProps({
    label: {
        type: String,
        required: true
    },
    value: {
        type: String,
        required: true
    }
});
</script>
  
<style scoped>
.detail-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.label {
    font-weight: bold;
}

.value {}
</style>
  