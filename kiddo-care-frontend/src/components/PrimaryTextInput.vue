<template>
  <div class="flex flex-col gap-4">
    <div>
      <el-form-item :label="props.label" :prop="props.prop" :rules="props.rules">
        <el-input style="width: 540px" v-bind="$attrs" />
      </el-form-item>
    </div>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  label: string
  prop: string
  rules?: Object
}>()
</script>

<style scoped>
/* Scoped styles if needed */
</style>
