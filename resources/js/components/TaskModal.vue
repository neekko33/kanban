<script setup>
import { ref, reactive, onMounted, onUnmounted, inject } from "vue";
import { addTask, getTaskById, updateTask } from "@/apis/task";

const setAlert = inject("setAlert");
const addTaskModal = ref(null);
const taskId = ref(null);
const form = reactive({
    title: "",
    priority: 2,
    status: "todo",
    due_date: "",
    description: "",
});

const props = defineProps({
    boardId: {
        type: Number,
        required: true,
    },
    refreshTasks: {
        type: Function,
        required: true,
    },
    type: {
        type: String,
        default: "add", // or 'edit'
    },
});

const showModal = async (id) => {
    if (id) {
        taskId.value = id;
        const { data } = await getTaskById(props.boardId, id);
        form.title = data.title;
        form.priority = data.priority;
        form.status = data.status;
        form.due_date = data.due_date;
        form.description = data.description;
    }

    if (addTaskModal.value) {
        addTaskModal.value.showModal();
    }
};

const closeMopdal = () => {
    if (addTaskModal.value) {
        addTaskModal.value.close();
    }
};

const handleAddTask = async () => {
    if (!form.title.trim()) {
        setAlert("error", "Title is required");
        return;
    }
    const { data } = await addTask(props.boardId, form);
    props.refreshTasks();
    closeMopdal();
    setAlert("success", "Task added successfully");
};

const handleSaveTask = async () => {
    const { data } = await updateTask(props.boardId, taskId.value, form);
    props.refreshTasks();
    closeMopdal();
    setAlert("success", "Task updated successfully");
};

const resetForm = () => {
    form.title = "";
    form.priority = 2;
    form.status = "todo";
    form.due_date = "";
    form.description = "";
    taskId.value = null;
};

onMounted(() => {
    if (addTaskModal.value) {
        addTaskModal.value.addEventListener("close", resetForm);
    }
});

onUnmounted(() => {
    if (addTaskModal.value) {
        addTaskModal.value.removeEventListener("close", resetForm);
    }
});

defineExpose({
    showModal,
});
</script>

<template>
    <dialog ref="addTaskModal" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button
                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                >
                    ✕
                </button>
            </form>
            <h3 class="text-lg font-bold">
                {{ type === "add" ? "Add Task" : "Edit Task" }}
            </h3>
            <form class="mt-4 space-y-4">
                <div class="flex gap-4">
                    <fieldset class="fieldset flex-1">
                        <legend class="fieldset-legend">Priority</legend>
                        <select class="select" v-model="form.priority">
                            <option :value="1">High</option>
                            <option :value="2">Medium</option>
                            <option :value="3">Low</option>
                        </select>
                    </fieldset>
                    <fieldset class="fieldset flex-1">
                        <legend class="fieldset-legend">Status</legend>
                        <select class="select" v-model="form.status">
                            <option value="todo">TODO</option>
                            <option value="hold">Hold</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </fieldset>
                </div>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Title</legend>
                    <input
                        v-model="form.title"
                        type="text"
                        class="input w-full"
                        placeholder="Type here"
                    />
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Due date</legend>
                    <input
                        v-model="form.due_date"
                        type="date"
                        class="input w-full"
                    />
                    <div class="label">Optional</div>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Description</legend>
                    <textarea
                        v-model="form.description"
                        class="textarea h-24 w-full"
                        placeholder="Description"
                    ></textarea>
                    <div class="label">Optional</div>
                </fieldset>
                <div class="flex justify-end">
                    <template v-if="type === 'add'">
                        <button
                            class="btn mt-2 btn-primary"
                            @click.prevent="handleAddTask"
                        >
                            Create Task
                        </button>
                    </template>
                    <template v-else>
                        <button
                            class="btn mt-2 btn-primary"
                            @click.prevent="handleSaveTask"
                        >
                            Save Task
                        </button>
                    </template>
                </div>
            </form>
        </div>
    </dialog>
</template>
