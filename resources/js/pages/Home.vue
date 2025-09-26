<script setup>
import Menu from "@/components/layouts/Menu.vue";
import Header from "@/components/layouts/Header.vue";
import { RouterView } from "vue-router";
</script>
<template>
    <div class="flex h-screen w-screen">
        <div class="w-[275px]">
            <Menu />
        </div>
        <div class="flex-1 flex flex-col">
            <Header />
            <RouterView />
        </div>
    </div>
</template>
