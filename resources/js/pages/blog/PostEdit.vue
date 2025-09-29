<script setup>
import { MdEditor } from "md-editor-v3";
import "md-editor-v3/lib/style.css";
import { ref } from "vue";
import { getTags, getCategories, getPost, updatePost } from "@/apis/blog";
import { addPost } from "../../apis/blog";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";

const router = useRouter();
const route = useRoute();

const isEdit = route.name === "PostEdit";
const tags = ref([]);
const categories = ref([]);
const post = ref({
    title: "",
    category_id: "",
    tag_ids: [],
    description: "",
    content: "",
});

const fetchData = async () => {
    const [tagsResponse, categoriesResponse] = await Promise.all([
        getTags(1, 100),
        getCategories(1, 100),
    ]);
    tags.value = tagsResponse.data.data;
    categories.value = categoriesResponse.data.data;
    if (isEdit) {
        const { data } = await getPost(route.params.id);
        post.value = {
            title: data.title,
            category_id: categories.value.find((c) => c.name === data.category)
                .id,
            tag_ids: data.tags.map(
                (tag) => tags.value.find((t) => t.name === tag).id
            ),
            description: data.description,
            content: data.content,
        };
    }
};

const fileInput = ref(null);
const handleFileUpload = () => {
    const file = fileInput.value.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            post.value.content = e.target.result;
        };
        reader.readAsText(file);
    }
};

const handleSave = async () => {
    if (isEdit) {
        const { data } = await updatePost(route.params.id, post.value);
    } else {
        const { data } = await addPost(post.value);
    }
    router.push({ name: "PostList" });
};

fetchData();
</script>
<template>
    <div>
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold">Add Post</h1>
            <button class="btn btn-primary" @click="handleSave">Save</button>
        </div>
        <div class="mb-6">
            <div class="flex gap-4 items-center">
                <fieldset class="fieldset w-[60%]">
                    <legend class="fieldset-legend">Title</legend>
                    <input
                        v-model="post.title"
                        type="text"
                        placeholder="Post Title"
                        class="input input-bordered w-full"
                    />
                </fieldset>
                <fieldset class="fieldset flex-1">
                    <legend class="fieldset-legend">Category</legend>
                    <select
                        v-model="post.category_id"
                        class="select select-bordered w-full"
                    >
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Tags</legend>
                    <div class="flex gap-4 items-center">
                        <button
                            class="btn btn-outline mr-2"
                            onclick="tag_modal.showModal()"
                        >
                            Manage Tags
                        </button>
                    </div>
                </fieldset>
            </div>
            <fieldset class="fieldset mt-2">
                <legend class="fieldset-legend">Description</legend>
                <textarea
                    v-model="post.description"
                    class="textarea textarea-bordered w-full overflow-y-scroll"
                    rows="3"
                    placeholder="Post Excerpt"
                    style="resize: none"
                ></textarea>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Read from file</legend>
                <div class="flex gap-4 items-center">
                    <input
                        ref="fileInput"
                        type="file"
                        class="file-input"
                        accept=".md"
                    />
                    <button
                        class="btn btn-outline"
                        @click.prevent="handleFileUpload"
                    >
                        Upload
                    </button>
                </div>
            </fieldset>
        </div>
        <MdEditor v-model="post.content" />
    </div>
    <dialog id="tag_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Select Tags</h3>
            <form class="my-12 grid grid-cols-4 gap-4">
                <input
                    v-for="tag in tags"
                    :key="tag.id"
                    class="btn"
                    type="checkbox"
                    name="frameworks"
                    :aria-label="tag.name"
                    :value="tag.id"
                    v-model="post.tag_ids"
                />
                <input
                    class="btn btn-square"
                    type="reset"
                    value="×"
                    @click="post.tag_ids = []"
                />
            </form>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>
</template>
