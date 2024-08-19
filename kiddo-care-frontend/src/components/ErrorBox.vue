<template>
    <el-card style="max-width: 480px">
        <template #header>
            <div class="card-header">
                <span>Error!</span>
            </div>
        </template>
        <slot></slot>
        <template #footer>Please adjust the input accordingly</template>
    </el-card>
</template>
  
<script setup lang="ts">

</script>
  
<style scoped>
.card {
    border-radius: 8px;
    padding: 20px;
    width: 100%;
    max-width: 500px;
}
</style>
  