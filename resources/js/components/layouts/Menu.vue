<script setup>
import { RouterLink } from "vue-router";
import { useRoute, useRouter } from "vue-router";
import routes from "@/router/routes";
import { Icon } from "@iconify/vue";
import { useAuthStore } from "@/store/store";
import { ref, computed } from "vue";

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();
const user = computed(() => authStore.user);

const menus = routes
    .find((r) => r.name === "Home")
    .children.filter((r) => r.meta?.isMenu);

const groupMap = menus.reduce((acc, curr) => {
    const groupName = curr.meta.group || "Default";
    if (acc[groupName]) {
        acc[groupName].push(curr);
    } else {
        acc[groupName] = [curr];
    }
    return acc;
}, {});

defineEmits(["toggleMenu"]);

const isCollapsed = ref(false);
const toggleMenu = () => {
    isCollapsed.value = !isCollapsed.value;
    $emit("toggleMenu", isCollapsed.value);
};
</script>

<template>
    <div :class="{ 'w-[275px]': !isCollapsed }">
        <div class="border-r h-full w-full relative border-gray-200">
            <div
                :class="isCollapsed ? 'justify-center' : 'justify-between'"
                class="border-b border-gray-200 h-16 flex items-center px-4 py-4"
            >
                <span
                    v-if="!isCollapsed"
                    class="font-bold text-2xl text-sky-500"
                    >Kanban</span
                >
                <Icon
                    @click="toggleMenu"
                    icon="heroicons:bars-4"
                    class="size-6 inline-block cursor-pointer"
                />
            </div>
            <div class="pt-2">
                <ul class="menu menu-lg w-full">
                    <template
                        v-for="group in Object.keys(groupMap)"
                        :key="group"
                    >
                        <template v-if="group === 'Default'">
                            <li
                                class="menu-item"
                                v-for="item in groupMap[group]"
                                :key="item.name"
                            >
                                <RouterLink
                                    :to="{ name: item.name }"
                                    class="flex items-center gap-2"
                                    :class="{
                                        'menu-active': route.name.startsWith(
                                            item.name
                                        ),
                                    }"
                                >
                                    <Icon
                                        :icon="item.meta.icon"
                                        class="size-5"
                                    />
                                    <template v-if="!isCollapsed">
                                        {{ item.name }}
                                    </template>
                                </RouterLink>
                            </li>
                        </template>
                        <template v-else>
                            <div
                                class="text-sm text-gray-500 px-4 my-2"
                                v-if="!isCollapsed"
                            >
                                {{ group }}
                            </div>
                            <li
                                class="menu-item"
                                v-for="item in groupMap[group]"
                                :key="item.name"
                            >
                                <RouterLink
                                    :to="{ name: item.name }"
                                    class="flex items-center gap-2"
                                    :class="{
                                        'menu-active': route.name.startsWith(
                                            item.name
                                        ),
                                    }"
                                >
                                    <Icon
                                        :icon="item.meta.icon"
                                        class="size-5"
                                    />
                                    <template v-if="!isCollapsed">
                                        {{ item.name }}
                                    </template>
                                </RouterLink>
                            </li>
                        </template>
                    </template>
                </ul>
            </div>
            <div
                :class="isCollapsed ? 'justify-center' : 'justify-between'"
                class="absolute bottom-0 w-full py-5 px-2 border-t border-gray-200 bg-gray-50 flex items-center"
            >
                <div class="flex items-center" v-if="!isCollapsed">
                    <div class="avatar">
                        <div class="w-10 rounded-full">
                            <img :src="user.avatar_url" />
                        </div>
                    </div>
                    <div class="ml-2 flex flex-col">
                        <span class="font-semibold">{{ user.name }}</span>
                        <span class="text-sm text-gray-400">{{
                            user.email
                        }}</span>
                    </div>
                </div>
                <div
                    class="h-full flex items-center justify-center cursor-pointer"
                >
                    <Icon
                        @click="router.push({ name: 'Settings' })"
                        icon="heroicons:adjustments-horizontal"
                        class="size-6 text-gray-400 hover:text-gray-600"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.menu-item {
    height: 40px;
}
</style>
