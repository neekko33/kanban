<script setup>
import { useRoute, RouterLink } from "vue-router";
import { ref, watch } from "vue";

const route = useRoute();
const matchedRoutes = ref(route.matched);

watch(route, (newValue) => {
    matchedRoutes.value = newValue.matched;
});
</script>

<template>
    <div class="pl-4 border-b border-gray-200 h-16 flex items-center">
        <div class="breadcrumbs text-sm">
            <ul>
                <li v-for="(r, index) in matchedRoutes" :key="index">
                    <RouterLink :to="r.path">{{ r.name }}</RouterLink>
                </li>
            </ul>
        </div>
    </div>
</template>
