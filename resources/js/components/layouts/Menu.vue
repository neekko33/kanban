<script setup>
import { RouterLink } from "vue-router";
import { useRoute } from 'vue-router';
import routes from '@/router/routes';
import { Icon } from '@iconify/vue';

const route = useRoute();

const menus = routes.find(r => r.name === 'Home').children.filter(r => r.meta?.isMenu);

const groupMap = menus.reduce((acc, curr) => {
    const groupName = curr.meta.group || 'Default';
    if (acc[groupName]) {
        acc[groupName].push(curr);
    } else {
        acc[groupName] = [curr];
    }
    return acc;
}, {})

</script>

<template>
    <div class="border-r h-full w-full relative border-gray-200">
        <div class="border-b border-gray-200 h-16 flex justify-between items-center px-4 py-4">
            <span class="font-bold text-2xl text-sky-500">Kanban</span>
            <Icon icon="heroicons:bars-4" class="size-6 inline-block cursor-pointer" />
        </div>
        <div class="pt-2">
            <ul class="menu menu-lg w-full">
                <template v-for="group in Object.keys(groupMap)" :key="group">
                    <template v-if="group === 'Default'">
                        <li class="menu-item" v-for="item in groupMap[group]" :key="item.name">
                            <RouterLink :to="{ name: item.name }" class="flex items-center gap-2"
                                :class="{ 'menu-active': route.name === item.name }">
                                <Icon :icon="item.meta.icon" class="size-5" />
                                {{ item.name }}
                            </RouterLink>
                        </li>
                    </template>
                    <template v-else>
                        <div class="text-sm text-gray-500 px-4 my-2">
                            {{ group }}
                        </div>
                        <li class="menu-item" v-for="item in groupMap[group]" :key="item.name">
                            <RouterLink :to="{ name: item.name }" class="flex items-center gap-2"
                                :class="{ 'menu-active': route.name === item.name }">
                                <Icon :icon="item.meta.icon" class="size-5" />
                                {{ item.name }}
                            </RouterLink>
                        </li>
                    </template>
                </template>
            </ul>
        </div>
        <div
            class="absolute bottom-0 w-full py-5 px-2 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
            <div class="flex items-center">
                <div class="avatar">
                    <div class="w-10 rounded-full">
                        <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" />
                    </div>
                </div>
                <div class="ml-2 flex flex-col">
                    <span class="font-semibold">Neekko33</span>
                    <span class="text-sm text-gray-400">Neekko33@gmail.com</span>
                </div>
            </div>
            <div class="h-full flex items-center justify-center cursor-pointer">
                <Icon icon="heroicons:chevron-up-down" class="size-6 text-gray-500" />
            </div>
        </div>
    </div>
</template>

<style scoped>
.menu-item {
    height: 40px;
}
</style>
