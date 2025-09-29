<script setup>
import { useRoute, RouterLink } from "vue-router";
import { ref, watch } from "vue";
import { useAuthStore } from "@/store/store";

const route = useRoute();
const { logout } = useAuthStore();
const matchedRoutes = ref(route.matched);

watch(route, (newValue) => {
    matchedRoutes.value = newValue.matched;
});
</script>

<template>
    <div class="px-4 border-b border-gray-200 h-16 flex items-center justify-between">
        <div class="breadcrumbs text-sm">
            <ul>
                <li v-for="(r, index) in matchedRoutes" :key="index">
                    <RouterLink :to="r.path">{{ r.name }}</RouterLink>
                </li>
            </ul>
        </div>
        <div>
            <button class="btn btn-outline btn-sm" @click="logout">Log out</button>
        </div>
    </div>
</template>
