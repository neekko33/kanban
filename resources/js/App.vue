<script setup>
import Menu from "./components/layouts/Menu.vue";
import { RouterView } from "vue-router";
</script>
<template>
    <div class="flex h-screen w-screen">
        <div class="w-[275px]">
            <Menu />
        </div>
        <div class="flex-1">
            <div class="px-2 border-b h-16 flex items-center">
                <h1 class="text-2xl font-bold">Header placeholder</h1>
            </div>
            <RouterView />
        </div>
    </div>
</template>
