<template>
  <el-steps :active="active" finish-status="success">
    <el-step title="Reservation" />
    <el-step title="Confirmation" />
  </el-steps>
  <div class="flex flex-row justify-center">
    <div v-if="active == 0" class="flex">

      <ReservationForm v-model="form" @submit="nextPage"></ReservationForm>
    </div>
    <div v-if="active == 1">
      <ConfirmationView :customerName="form.customerName" :customerAddress="form.customerAddress"
        :startTime="form.startTime" :duration="form.duration" :childrens="form.childrens" />
      <div class="mt-10">
        <el-button type="primary" @click="reservationAPI"> Submit</el-button>
        <el-button @click="active--">Back </el-button>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import ReservationForm from '../components/partials/ReservationForm.vue'
import ConfirmationView from '../components/partials/ConfirmationView.vue'
import type { RuleForm } from '../components/partials/ReservationForm.vue'
import instance from '../axios/axiosInterceptor';
import { useRouter } from 'vue-router'
import dayjs from 'dayjs'


const router = useRouter();
const active = ref(0);
const form = ref<RuleForm>({
  customerName: '',
  customerAddress: '',
  startDate: null,
  startTime: null,
  duration: 1,
  childrens: [
    {
      name: null,
      birthdate: null
    }
  ]
})

const nextPage = () => {
  active.value++;
}


const convertHoursToMinutes = (hours: number): number => {
  return hours * 60;
};

const reservationAPI = () => {
  return instance.post('/reservations', {
    'customer_name': form.value.customerName,
    'customer_address': form.value.customerAddress,
    'start_time': form.value.startTime,
    'duration_minutes': convertHoursToMinutes(form.value.duration),
    'children': form.value.childrens.map((child) => ({
      name: child.name,
      birthdate: dayjs(child.birthdate).format('YYYY-MM-DD'),
    }))
  }).then((res) => {
    console.log(res); // can see the reservaton data heredata here;
    router.replace({ name: 'result' });
  }).catch((err) => {
    active.value--;
    console.error(err);
  });
}




</script>
