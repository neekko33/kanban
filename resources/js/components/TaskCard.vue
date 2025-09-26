<script setup>
const props = defineProps({
    task: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <div class="card bg-base-100 shadow-sm mx-2 my-4 p-4 text-sm cursor-pointer hover:shadow-lg transition-all">
        <h2>{{ task.title }}</h2>
        <p>{{ task.description }}</p>
        <p>{{ task.status }}</p>
        <p>{{ task.priority }}</p>
        <p>{{ task.due_date }}</p>
        <p>{{ task.created_at }}</p>
    </div>
</template>
