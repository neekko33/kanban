<script setup>
import { MdEditor } from "md-editor-v3";
import "md-editor-v3/lib/style.css";
import { ref } from "vue";
import { getTags, getCategories } from "@/apis/blog";

const content = ref("# Hello World");

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
        getTags(),
        getCategories(),
    ]);
    tags.value = tagsResponse.data;
    categories.value = categoriesResponse.data;
};

const fileInput = ref(null);
const handleFileUpload = () => {
    const file = fileInput.value.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            content.value = e.target.result;
        };
        reader.readAsText(file);
    }
};

fetchData();
</script>
<template>
    <div>
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold">Add Post</h1>
            <button class="btn btn-primary">Save</button>
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
                    class="textarea textarea-bordered w-full overflow-y-scroll"
                    rows="3"
                    placeholder="Post Excerpt"
                    style="resize: none;"
                ></textarea>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Read from file</legend>
                <div class="flex gap-4 items-center">
                    <input ref="fileInput" type="file" class="file-input" accept=".md" />
                    <button class="btn btn-outline" @click.prevent="handleFileUpload">Upload</button>
                </div>
            </fieldset>
        </div>
        <MdEditor v-model="content" />
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
