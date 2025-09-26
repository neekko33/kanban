<script setup>
import { getLatestBoard } from "@/apis/task";
import TaskCard from "@/components/TaskCard.vue";
import { ref, computed, onMounted, onUnmounted } from "vue";

const tasks = ref([])
const scrollContainer = ref(null);
const scrolled = ref(false);

const statuses = [
    {
        name: "To Do",
        value: "todo"
    },
    {
        name: "Hold",
        value: "hold"
    },
    {
        name: "In Progress",
        value: "in_progress"
    },
    {
        name: "Done",
        value: "done"
    }
]


const onScroll = () => {
    scrolled.value = scrollContainer.value.scrollTop > 10;
}

onMounted(async () => {
    const { data } = await getLatestBoard();
    tasks.value = data.tasks;

    if (!scrollContainer.value) {
        return;
    }


    scrollContainer.value.addEventListener('scroll', onScroll);
})

onUnmounted(() => {
    if (scrollContainer.value) {
        scrollContainer.value.removeEventListener('scroll', onScroll);
    }
})

const groupedTasks = computed(() => {
    if (!tasks.value.length) return {};

    return tasks.value.reduce((acc, task) => {
        if (!acc[task.status]) {
            acc[task.status] = [];
        }
        acc[task.status].push(task);
        return acc;
    }, {});
});

</script>
<template>
    <div class="w-full flex-1">
        <h1 class="text-3xl font-bold h-16 p-4">Sprint 1</h1>
        <div ref="scrollContainer" class="w-full grid grid-cols-4 gap-6 px-4 mt-6 overflow-scroll"
            style="height:calc(100vh - 9.5rem);">
            <div class="bg-gray-100 rounded-md" v-for="status in statuses" :key="status.value">
                <h2 class="font-semibold p-4 text-gray-400 sticky top-0 bg-gray-100 z-10"
                    :class="{ 'shadow-sm transition-all': scrolled }">{{ status.name }}</h2>
                <template v-if="groupedTasks[status.value]?.length">
                    <TaskCard v-for="task in groupedTasks[status.value]" :key="task.id" :task="task" />
                </template>
            </div>
        </div>
    </div>
</template>
