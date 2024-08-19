<template>
    <div class="flex justify-center">
        <el-card>
            <el-text>Successfully Submit the reservation, please wait for the result</el-text>
            <div class="mt-4">
                <el-button type="primary" @click="navigateToHome">Reserve More</el-button>
            </div>

        </el-card>
    </div>
</template>
  
<script setup lang="ts">
import { useRouter } from 'vue-router';

const router = useRouter();

const navigateToHome = () => {
    router.replace({ name: 'home' });
};
</script>

