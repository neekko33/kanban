<script setup>
import { getLatestBoard } from "@/apis/task";
import TaskCard from "@/components/TaskCard.vue";
import { ref, computed, onMounted, onUnmounted } from "vue";
import TaskModal from "@/components/TaskModal.vue";
import draggable from 'vuedraggable';

const tasks = ref([])
const boardId = ref(null);
const scrollContainer = ref(null);
const scrolled = ref(false);
const modalType = ref('add');

const addTaskModal = ref(null);

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

const fetchData = async () => {
    const { data } = await getLatestBoard();
    boardId.value = data.id;
    tasks.value = data.tasks;
}

onMounted(async () => {
    await fetchData();
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

const showAddTaskModal = () => {
    modalType.value = 'add';
    addTaskModal.value.showModal();
}

const showEditTaskModal = (id) => {
    modalType.value = 'edit';
    addTaskModal.value.showModal(id);
}

</script>
<template>
    <div class="w-full flex-1">
        <div class="flex items-center justify-between h-20 p-4">
            <h1 class="text-3xl font-bold">Sprint 1</h1>
            <button class="btn" @click="showAddTaskModal">Add Task</button>
        </div>
        <div ref="scrollContainer" class="w-full grid grid-cols-4 gap-6 px-4 overflow-scroll"
            style="height:calc(100vh - 10rem);">
            <div class="bg-gray-100 rounded-md" v-for="status in statuses" :key="status.value">
                <h2 class="font-semibold p-4 text-gray-400 sticky top-0 bg-gray-100 z-10"
                    :class="{ 'shadow-sm transition-all': scrolled }">{{ status.name }}</h2>
                <template v-if="groupedTasks[status.value]?.length">
                    <TaskCard v-for="task in groupedTasks[status.value]" :key="task.id" :task="task"
                        @click="showEditTaskModal(task.id)" />
                </template>
            </div>
        </div>
    </div>
    <TaskModal ref="addTaskModal" :board-id="boardId" :refresh-tasks="fetchData" :type="modalType" />
</template>
