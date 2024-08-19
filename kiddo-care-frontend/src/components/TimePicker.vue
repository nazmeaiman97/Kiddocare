<template>
  <div class="flex flex-col gap-4">
    <el-form-item :label="props.label" :prop="props.prop">
      <el-time-picker v-bind="$attrs" />
    </el-form-item>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  label: string
  prop: string
}>()
</script>

<style scoped></style>
