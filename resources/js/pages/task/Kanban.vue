<script setup>
import { getLatestBoard, addBoard, updateBoard } from "@/apis/task";
import TaskCard from "@/components/TaskCard.vue";
import { ref, computed, onMounted, onUnmounted, inject } from "vue";
import TaskModal from "@/components/TaskModal.vue";
import draggable from "vuedraggable";
import { Icon } from "@iconify/vue";

const tasks = ref([]);
const boardId = ref(null);
const boardTitle = ref("");
const isBoardEdit = ref(false);

const scrollContainer = ref(null);
const scrolled = ref(false);
const modalType = ref("add");

const addTaskModal = ref(null);

const statuses = [
    {
        name: "To Do",
        value: "todo",
    },
    {
        name: "Hold",
        value: "hold",
    },
    {
        name: "In Progress",
        value: "in_progress",
    },
    {
        name: "Done",
        value: "done",
    },
];

const onScroll = () => {
    scrolled.value = scrollContainer.value.scrollTop > 10;
};

const fetchData = async () => {
    const { data } = await getLatestBoard();
    if (!data.id) {
        boardId.value = null;
        boardTitle.value = "No Boards";
        tasks.value = [];
        return;
    }
    boardId.value = data.id;
    boardTitle.value = data.name;
    tasks.value = data.tasks;
};

onMounted(async () => {
    await fetchData();
    if (!scrollContainer.value) {
        return;
    }
    scrollContainer.value.addEventListener("scroll", onScroll);
});

onUnmounted(() => {
    if (scrollContainer.value) {
        scrollContainer.value.removeEventListener("scroll", onScroll);
    }
});

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
    if (!boardId.value) {
        setAlert("error", "Please create a board first.");
        return;
    }
    modalType.value = "add";
    addTaskModal.value.showModal();
};

const showEditTaskModal = (id) => {
    modalType.value = "edit";
    addTaskModal.value.showModal(id);
};

const setConfirm = inject("setConfirm");
const setAlert = inject("setAlert");
const handleCreateBoard = async () => {
    setConfirm(
        "Create New Board",
        "Are you sure you want to create a new board? This will discard any unsaved changes.",
        async () => {
            const { data } = await addBoard();
            await fetchData();
            setAlert("success", "New board created successfully.");
        }
    );
};

const isBoardTitleLoading = ref(false);
const handleEditBoard = async () => {
    isBoardTitleLoading.value = true;
    const { data } = await updateBoard(boardId.value, {
        name: boardTitle.value,
    });
    boardTitle.value = data.name;
    isBoardTitleLoading.value = false;
    isBoardEdit.value = false;
};
</script>
<template>
    <div class="w-full flex-1">
        <div class="flex items-center justify-between h-20 p-4">
            <div class="flex items-center gap-4">
                <div>
                    <h1
                        v-if="!isBoardEdit"
                        class="text-3xl font-bold"
                        @click="isBoardEdit = true"
                    >
                        {{ boardTitle }}
                    </h1>
                    <input
                        v-else
                        class="input"
                        :disabled="isBoardTitleLoading"
                        v-model="boardTitle"
                        type="text"
                        @blur="handleEditBoard"
                    />
                </div>
                <div
                    class="tooltip"
                    data-tip="Create a new board with undone tasks."
                >
                    <Icon
                        icon="heroicons:squares-plus-16-solid"
                        class="size-6 hover:text-gray-500 cursor-pointer"
                        @click="handleCreateBoard"
                    />
                </div>
            </div>
            <button class="btn btn-primary" @click="showAddTaskModal">
                Add Task
            </button>
        </div>
        <div
            ref="scrollContainer"
            class="w-full grid grid-cols-4 gap-6 pl-4 overflow-scroll"
            style="height: calc(100vh - 10rem)"
        >
            <div
                class="bg-gray-100 rounded-md"
                v-for="status in statuses"
                :key="status.value"
            >
                <h2
                    class="font-semibold p-4 text-gray-400 sticky top-0 bg-gray-100 z-10"
                    :class="{ 'shadow-sm transition-all': scrolled }"
                >
                    {{ status.name }}
                </h2>
                <template v-if="groupedTasks[status.value]?.length">
                    <TaskCard
                        v-for="task in groupedTasks[status.value]"
                        :key="task.id"
                        :task="task"
                        @click="showEditTaskModal(task.id)"
                    />
                </template>
            </div>
        </div>
    </div>
    <TaskModal
        ref="addTaskModal"
        :board-id="boardId"
        :refresh-tasks="fetchData"
        :type="modalType"
    />
</template>
