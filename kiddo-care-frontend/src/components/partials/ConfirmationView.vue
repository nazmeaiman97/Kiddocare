<template>
  <div class="customer-details-container">
    <el-card class="customer-card" shadow="always">
      <div class="pb-10">
        <el-text size="large" type="primary">Customer Details</el-text>
      </div>
      <DetailItem label="Customer Name" :value="customerName" />
      <DetailItem label="Customer Address" :value="customerAddress" />
      <DetailItem label="Start At" :value="toLocaleStringHelper(startTime)" />
      <DetailItem label="End At" :value="calculatedEndDate" />
      <DetailItem label="Duration" :value="`${duration} hours`" />
    </el-card>

    <el-card class="children-card" shadow="hover">

      <div v-for="(child, index) in childrens" :key="index" class="child-item">
        <div class="pb-10">
          <el-text size="large" type="primary">Children {{ index + 1 }}</el-text>
        </div>
        <DetailItem label="Name" :value="child.name" />
        <DetailItem label="Birth Date" :value="toLocaleStringHelper(child.birthdate, true)" />
        <DetailItem label="Age" :value="calculateAge(child.birthdate)" />
      </div>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import DetailItem from '../DetailItem.vue'

const props = defineProps({
  customerName: {
    type: String,
    required: true,
  },
  customerAddress: {
    type: String,
    required: true,
  },
  startTime: {
    type: String,
    required: true,
  },
  duration: {
    type: Number,
    required: true,
  },
  childrens: {
    type: Array as () => Array<{ name: string | null, address: string | null, birthdate: string }>,
    required: true,
  }
});

const toLocaleStringHelper = (date: string, dateOnly: boolean = false) => {
  const convertDate = new Date(date);

  if (!dateOnly) {
    return convertDate.toLocaleString();
  }

  return convertDate.toLocaleDateString();

}

// Calculate the end date based on start date and duration
const calculatedEndDate = computed(() => {
  const start = new Date(props.startTime);
  const end = new Date(start.getTime() + props.duration * 60 * 60 * 1000);
  return end.toLocaleString(); // Convert to a readable format
});

// Calculate age based on birthdate
const calculateAge = (birthdate: string | null): string => {
  if (!birthdate) return '0 years';

  const birthDateObj = new Date(birthdate);
  const today = new Date();

  let years = today.getFullYear() - birthDateObj.getFullYear();
  let months = today.getMonth() - birthDateObj.getMonth();

  if (months < 0 || (months === 0 && today.getDate() < birthDateObj.getDate())) {
    years--;
    months += 12;
  }

  return `${years} years${months > 0 ? `, ${months} months` : ''}`;
};
</script>

<style scoped>
.customer-details-container {
  display: flex;
  flex-direction: column;
  gap: 20px;
  align-items: center;
}

.customer-card,
.children-card {
  width: 100%;
  max-width: 500px;
}

.card-title {
  font-weight: bold;
  font-size: 1.2em;
  margin-bottom: 40px;
  padding-bottom: 20px;
  color: #409EFF;
  /* Primary color */
}

.detail-item {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.label {
  font-weight: bold;
}

.value {}

.child-item {
  margin-top: 15px;
  padding-top: 10px;
  border-top: 1px solid #ebeef5;
}

.child-item:first-of-type {
  border-top: none;
  padding-top: 0;
}

.el-card {
  border-radius: 8px;
  padding: 20px;
}
</style>
