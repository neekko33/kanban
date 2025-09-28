<script setup>
import { Icon } from "@iconify/vue";
import dayjs from "dayjs";

const priorityColors = {
    1: "text-red-500",
    2: "text-yellow-500",
    3: "text-green-500",
};

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div
        class="card bg-base-100 shadow-sm mx-2 my-4 p-4 cursor-pointer hover:shadow-md transition-all hover:bg-base-200"
    >
        <h2
            class="text-md font-semibold mb-2 break-words"
            :class="{ 'line-through': task.status === 'done' }"
        >
            {{ task.title }}
        </h2>
        <p class="text-sm text-gray-400 mb-2">
            {{ task.description }}
        </p>
        <p
            class="text-sm text-red-500 flex items-center mb-1 font-semibold"
            v-if="task.due_date"
        >
            <Icon
                icon="heroicons:fire-16-solid"
                class="size-4 inline-block mr-1"
            />
            {{ dayjs(task.due_date).format("YYYY/MM/DD") }}
        </p>
        <div class="flex justify-between items-center">
            <p class="text-sm text-gray-400">
                Created at {{ dayjs(task.created_at).format("YYYY/MM/DD") }}
            </p>
            <Icon
                icon="heroicons:bolt-20-solid"
                class="size-5 inline-block ml-2"
                :class="priorityColors[task.priority]"
            />
        </div>
    </div>
</template>
