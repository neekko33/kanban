<script setup>
import Menu from "@/components/layouts/Menu.vue";
import Header from "@/components/layouts/Header.vue";
import Confirm from "@/components/Confirm.vue";
import { RouterView } from "vue-router";
import { ref, reactive, provide } from "vue";

const confirmModal = ref(null);
const confirm = reactive({
    title: "",
    message: "",
    onConfirm: null,
});

const setConfirm = (title, message, onConfirm) => {
    if (typeof onConfirm !== "function") {
        throw new Error("onConfirm must be a function");
        return;
    }

    confirm.title = title;
    confirm.message = message;
    confirm.onConfirm = onConfirm;

    confirmModal.value?.showConfirmModal();
};

provide("setConfirm", setConfirm);
</script>
<template>
    <Confirm ref="confirmModal" :confirm="confirm" />
    <div class="flex h-screen w-screen">
        <Menu />
        <div class="flex-1 flex flex-col">
            <Header />
            <RouterView />
        </div>
    </div>
</template>
