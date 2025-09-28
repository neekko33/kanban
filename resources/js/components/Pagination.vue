<script setup>
import { computed } from "vue";

const props = defineProps({
    total: {
        type: Number,
        default: 0,
    },
    currentPage: {
        type: Number,
        default: 1,
    },
    perPage: {
        type: Number,
        default: 12,
    },
});

defineEmits(["onPageChange"])
const totalPages = computed(() => Math.ceil(props.total / props.perPage));
</script>
<template>
    <div class="join" v-if="totalPages > 1">
        <button
            class="join-item btn"
            @click="currentPage !== 1 && $emit('onPageChange', currentPage - 1)"
        >
            «
        </button>
        <template v-for="page in totalPages" :key="page">
            <button
                class="join-item btn"
                :class="{
                    'btn-active': page === currentPage,
                }"
                @click="$emit('onPageChange', page)"
            >
                {{ page }}
            </button>
        </template>
        <button
            class="join-item btn"
            @click="currentPage !== totalPages && $emit('onPageChange', currentPage + 1)"
        >
            »
        </button>
    </div>
</template>
