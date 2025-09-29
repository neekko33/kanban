<script setup>
import Table from "@/components/Table.vue";
import { ref, onMounted, inject } from "vue";
import { getPosts, deletePost } from "@/apis/blog";
import Pagination from "../../components/Pagination.vue";
import { useRouter } from "vue-router";

const setConfirm = inject("setConfirm");
const router = useRouter();

const posts = ref([]);

const columns = [
    { name: "Title", field: "title" },
    { name: "Category", field: "category" },
    { name: "Tag", field: "tags" },
    { name: "Published Date", field: "created_at", timestamp: true },
    { name: "Action", field: "action" },
];

const totalPage = ref(0);
const currentPage = ref(1);
const pageSize = ref(10);

const fetchData = async (page) => {
    const {
        data: { data, total, current_page, per_page },
    } = await getPosts(page, pageSize.value);
    posts.value = data;
    totalPage.value = total;
    currentPage.value = current_page;
    pageSize.value = per_page;
};

const handlePageChange = async (newPage) => {
    currentPage.value = newPage;
    await fetchData(currentPage.value);
};

const handleDeletePost = (id) => {
    setConfirm(
        "Delete Post",
        "Are you sure you want to delete this post?",
        async () => {
            await deletePost(id);
            await fetchData(currentPage.value);
        }
    );
};
onMounted(async () => {
    await fetchData(currentPage.value);
});
</script>
<template>
    <div>
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold">Blog Posts</h1>
            <button
                class="btn btn-primary"
                @click="router.push({ name: 'PostCreate' })"
            >
                New Post
            </button>
        </div>
        <div
            class="relative overflow-auto mb-6"
            style="max-height: calc(100vh - 18rem)"
        >
            <Table :columns="columns" :data="posts" :current-page="currentPage">
                <template #tags="{ row }">
                    <div class="flex flex-wrap gap-1">
                        <span
                            v-for="tag in row.tags"
                            :key="tag"
                            class="badge badge-info badge-outline badge-sm"
                        >
                            {{ tag }}
                        </span>
                    </div>
                </template>
                <template #action="{ row }">
                    <button
                        class="btn btn-sm btn-outline btn-primary mr-2"
                        @click="
                            router.push({
                                name: 'PostEdit',
                                params: { id: row.id },
                            })
                        "
                    >
                        Edit
                    </button>
                    <button
                        class="btn btn-sm btn-error btn-outline"
                        @click="handleDeletePost(row.id)"
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
</template>
