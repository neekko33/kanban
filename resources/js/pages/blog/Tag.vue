
<script setup>
import Table from "@/components/Table.vue";
import { ref, onMounted, inject } from "vue";
import { getTags, addTag, updateTag, deleteTag } from "@/apis/blog";
import Pagination from "../../components/Pagination.vue";

const setConfirm = inject("setConfirm");
const tags = ref([]);

const columns = [
    { name: "Name", field: "name" },
    { name: "Published Date", field: "created_at", timestamp: true },
    { name: "Action", field: "action" },
];

const totalPage = ref(0);
const currentPage = ref(1);
const pageSize = ref(10);

const fetchData = async (page) => {
    const {
        data: { data, total, current_page, per_page },
    } = await getTags(page);
    tags.value = data;
    totalPage.value = total;
    currentPage.value = current_page;
    pageSize.value = per_page;
};

const handlePageChange = async (newPage) => {
    currentPage.value = newPage;
    await fetchData(currentPage.value);
};

const editModal = ref(null);
const modal = ref({
    id: null,
    name: "",
    title: "New Tag",
});

const handleAddTag = () => {
    modal.value = {
        id: null,
        name: "",
        title: "New Tag",
    };
    editModal.value.showModal();
};

const handleEditTag = async (category) => {
    modal.value = {
        id: category.id,
        name: category.name,
        title: "Edit Tag",
    };
    editModal.value.showModal();
};

const handleDeleteTag = (id) => {
    setConfirm(
        "Delete Tag",
        "Are you sure you want to delete this category?",
        async () => {
            await deleteTag(id);
            await fetchData(currentPage.value);
        }
    );
};

const handleSaveTag = async () => {
    if (modal.value.id) {
        await updateTag(modal.value.id, { name: modal.value.name });
    } else {
        await addTag({ name: modal.value.name });
    }
    editModal.value.close();
    await fetchData(currentPage.value);
};

onMounted(async () => {
    await fetchData(currentPage.value);
});
</script>
<template>
    <div class="px-4 py-6">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold">Blog Tags</h1>
            <button class="btn btn-primary" @click="handleAddTag">
                New Tag
            </button>
        </div>
        <div
            class="relative overflow-auto mb-6"
            style="max-height: calc(100vh - 18rem)"
        >
            <Table
                :columns="columns"
                :data="tags"
                :current-page="currentPage"
            >
                <template #action="{ row }">
                    <button
                        class="btn btn-sm btn-outline btn-primary mr-2"
                        @click="handleEditTag(row)"
                    >
                        Edit
                    </button>
                    <button
                        class="btn btn-sm btn-error btn-outline"
                        @click="handleDeleteTag(row.id)"
                    >
                        Delete
                    </button>
                </template>
            </Table>
        </div>
        <div class="w-full flex justify-center">
            <Pagination
                :total="totalPage"
                :current-page="currentPage"
                :per-page="pageSize"
                @onPageChange="handlePageChange"
            />
        </div>
    </div>
    <dialog ref="editModal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">{{ modal.title }}</h3>
            <fieldset class="fieldset my-6">
                <legend class="fieldset-legend">Name</legend>
                <input
                    v-model="modal.name"
                    type="text"
                    class="input w-full"
                    placeholder="Type here"
                />
            </fieldset>
            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Close</button>
                </form>
                <button class="btn btn-primary" @click="handleSaveTag">
                    Save
                </button>
            </div>
        </div>
    </dialog>
</template>

