<template>
  <el-form ref="ruleFormRef" style="max-width: 600px" :model="form" :rules="rules" label-width="auto" :size="formSize"
    status-icon class="flex flex-col gap-2">
    <div class="flex flex-col gap-2">
      <PrimaryTextInput label="Customer Name" v-model="form.customerName" prop="customerName"></PrimaryTextInput>
      <PrimaryTextInput label="Address" v-model="form.customerAddress" prop="customerAddress" />
      <DatePicker v-model="form.startDate" label="Booking Date" prop="startDate" type="date"
        start-placeholder="Start Date" format="DD-MM-YYYY" :disabled-date="disabledDateF" @change="onDateChange">
      </DatePicker>
      <TimePicker v-model="form.startTime" format="HH:mm" :disabled-hours="disabledHours" label="Booking Time"
        prop="startTime" @change="onTimeChange" />
      <SelectOption v-model="form.duration" label="Duration (Hour)" prop="duration" :options="hourOptions"
        label-key="hour" value-key="hour" />
    </div>
    <el-divider />
    <div v-for="(child, index) in form.childrens" :key="index" class="flex flex-col gap-2">
      <div class="flex flex-row mb-6">
        <el-button v-if="index + 1 == form.childrens.length" @click="addChildren">Add</el-button>
        <el-button v-if="index != 0" @click="removeChild(index)" type="danger">Remove</el-button>
      </div>
      <PrimaryTextInput label="Child Name" v-model="form.childrens[index].name" :prop="'childrens.' + index + '.name'"
        :rules="{ required: true, message: 'Child Name is required', trigger: 'blur' }" />
      <DatePicker v-model="form.childrens[index].birthdate" :prop="'childrens.' + index + '.birthdate'"
        :rules="{ required: true, message: 'Birthdate is required', trigger: 'blur' }" label="Birth Date"
        :disabled-date="disabledDate" type="date" format="DD-MM-YYYY" placeholder="Pick a date" :editable="false">
      </DatePicker>
      <el-divider />
    </div>
    <el-form-item>
      <el-button type="primary" @click="submitForm">Next</el-button>
      <el-button @click="resetForm">Reset</el-button>
    </el-form-item>
  </el-form>
</template>

<script setup lang="ts">
import { ref, reactive, defineEmits, watch } from 'vue'
import PrimaryTextInput from '../PrimaryTextInput.vue'
import SelectOption from '../SelectOption.vue'
import { ElNotification } from 'element-plus'
import DatePicker from '../DatePicker.vue'
import TimePicker from '../TimePicker.vue'
import type { ComponentSize, FormInstance, FormRules } from 'element-plus'

interface Child {
  name: string | null
  birthdate: Date | null
}

export interface RuleForm {
  customerName: string,
  customerAddress: string,
  startDate: Date | null
  startTime: Date | null
  duration: number,
  childrens: Child[]
}

const props = defineProps({
  modelValue: {
    type: Object as () => RuleForm,
    required: true
  },
  formSize: {
    type: String as () => ComponentSize,
    default: 'default'
  }
})

const hourOptions = [
  {
    hour: 1
  },
  {
    hour: 2
  },
  {
    hour: 3
  }
]

const emit = defineEmits(['update:modelValue', 'submit', 'reset'])

const ruleFormRef = ref<FormInstance>()
const form = reactive(props.modelValue)

const rules = reactive<FormRules<RuleForm>>({
  customerName: [{ required: true, message: 'Name is required', trigger: 'change' }],
  customerAddress: [{ required: true, message: 'Address is required', trigger: 'change' }],
  startDate: [
    {
      required: true,
      message: 'Please select booking date',
      trigger: 'change'
    }
  ],
  startTime: [
    {
      required: true,
      message: 'Please select booking time',
      trigger: 'change'
    }
  ],
  duration: [
    {
      required: true,
      message: 'Please select duration',
      trigger: 'change'
    }
  ]
})

const MAX_CHILDRENS = 4
const MINIMUM_HOUR_TO_BOOK = 6

const addChildren = () => {
  if (form.childrens.length >= MAX_CHILDRENS) {
    return ElNotification({
      title: 'Warning',
      message: `Cannot add more than ${MAX_CHILDRENS} children at once`,
      type: 'warning'
    })
  }
  form.childrens.push({
    name: null,
    birthdate: null
  })
}

const removeChild = (index: number) => {
  if (index >= 0 && index < form.childrens.length) {
    form.childrens.splice(index, 1)
  }
}

const disabledDate = (time: Date) => {
  const now = new Date()
  const oneMonthAgo = new Date(now)
  oneMonthAgo.setMonth(now.getMonth() - 1)
  const twelveYearsAgo = new Date(now)
  twelveYearsAgo.setFullYear(now.getFullYear() - 12)
  return time < twelveYearsAgo || time > oneMonthAgo
}

const disabledDateF = (time: Date): boolean => {
  const now = new Date()
  const minDate = new Date(now)
  minDate.setDate(now.getDate() - 1)
  minDate.setHours(23, 59, 59, 999)
  if (now.getHours() > 24 - MINIMUM_HOUR_TO_BOOK) {
    minDate.setDate(now.getDate())
  }
  const thirtyDaysFromNow = new Date(now)
  thirtyDaysFromNow.setDate(now.getDate() + 30)
  return time < minDate || time > thirtyDaysFromNow
}

const disabledHours = () => {
  const currentDate = new Date()
  if (!form.startDate || currentDate.getDate() !== new Date(form.startDate).getDate()) {
    return []
  }
  const hourPlusSix = (currentDate.getHours() + MINIMUM_HOUR_TO_BOOK) % 24
  const disabled = []
  for (let i = 0; i < hourPlusSix; i++) {
    disabled.push(i)
  }
  return disabled
}

const onDateChange = (date: Date | null) => {
  if (date) {
    if (form.startTime) {
      // Update the date part of startTime while preserving time
      updateDateTime(date, form.startTime);
    } else {
      // If no time selected yet, just set the date
      form.startDate = date;
    }
  }
};

const onTimeChange = (time: Date | null) => {
  if (time && form.startDate) {
    updateDateTime(form.startDate, time);
  }
};

// Helper function to combine date and time
const updateDateTime = (date: Date, time: Date) => {
  const combinedDateTime = new Date(date);
  combinedDateTime.setHours(time.getHours(), time.getMinutes(), 0, 0);
  form.startTime = combinedDateTime;
  form.startDate = new Date(date);
};


const submitForm = async () => {
  if (!ruleFormRef.value) return
  await ruleFormRef.value.validate((valid, fields) => {
    if (valid) {
      emit('submit', form)
    } else {
      console.log('error submit!', fields)
    }
  })
}

const resetForm = () => {
  if (ruleFormRef.value) {
    ruleFormRef.value.resetFields()
    emit('reset')
  }
}

// Watch for changes to modelValue prop and update form
watch(
  () => props.modelValue,
  (newValue) => {
    Object.assign(form, newValue)
  },
  { deep: true }
)
</script>

<style scoped></style>
