<template>
  <div class="flex flex-col gap-4">
    <el-form-item :label="props.label" :prop="props.prop" :rules="props.rules">
      <el-date-picker v-bind="$attrs" />
    </el-form-item>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  label: string
  prop: string
  rules?: Object
}>()
</script>

<style scoped></style>
