<template>
  <el-form-item :label="label" :prop="prop" :rules="rules">
    <el-select v-model="localValue" v-bind="$attrs" @change="handleChange">
      <el-option
        v-for="item in options"
        :key="getOptionKey(item)"
        :label="getOptionLabel(item)"
        :value="getOptionValue(item)"
      />
    </el-select>
  </el-form-item>
</template>

<script setup lang="ts">
import { defineEmits, defineProps, ref, watch } from 'vue'

interface Option {
  [key: string]: any
}

const props = defineProps<{
  label: string
  prop: string
  rules?: Record<string, any>
  options: Option[]
  modelValue: any
  labelKey: string
  valueKey: string
}>()

const emit = defineEmits(['update:modelValue'])

const { options, modelValue, labelKey, valueKey } = props

// Local reference to manage the modelValue
const localValue = ref(modelValue)

const getOptionLabel = (item: Option) => {
  return item[labelKey]
}

const getOptionValue = (item: Option) => {
  return item[valueKey]
}

const getOptionKey = (item: Option) => {
  return item[valueKey] // Ensure the key is unique
}

// Watch for changes in modelValue prop and update localValue accordingly
watch(
  () => props.modelValue,
  (newValue) => {
    localValue.value = newValue
  }
)

const handleChange = (value: any) => {
  emit('update:modelValue', value)
}
</script>
