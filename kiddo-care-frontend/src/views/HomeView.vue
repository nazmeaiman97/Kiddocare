<template>
  <el-steps style="max-width: 600px" :active="active" finish-status="success">
    <el-step title="Reservation" />
    <el-step title="Confirmation" />
  </el-steps>
  <div>
    <ReservationForm v-model="form" @submit="handleSubmit"></ReservationForm>
    <ConfirmationView></ConfirmationView>
  </div>

  <el-button style="margin-top: 12px" @click="next">Next step</el-button>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import ReservationForm from '../components/partials/ReservationForm.vue'
import ConfirmationView from '../components/partials/ConfirmationView.vue'
import type { RuleForm } from '../components/partials/ReservationForm.vue'

const form = ref<RuleForm>({
  customerName: null,
  startDate: null,
  startTime: null,
  durations: null,
  childrens: [
    {
      name: null,
      address: null,
      birthdate: null
    }
  ]
})

const handleSubmit = (formData: RuleForm) => {
  if (active.value++ > 2) active.value = 0
}

const active = ref(0)

const next = () => {
  if (active.value++ > 2) active.value = 0
}
</script>
