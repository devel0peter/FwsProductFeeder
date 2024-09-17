<template>
    <div>
        <Navbar />

        <router-view v-slot="{ Component, route }">
            <div :key="route.name">
                <Component :is="Component" />
            </div>
        </router-view>
    </div>
</template>
<script setup lang="ts">
import Navbar from "@/components/NavBar.vue";
</script>
