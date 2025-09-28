<script setup>
import { ref, defineExpose } from "vue";

const props = defineProps({
    confirm: {
        type: Object,
        required: true,
    },
});

const confirmModal = ref(null);
const showConfirmModal = () => {
    confirmModal.value.showModal();
};

const handleConfirm = async () => {
    if (typeof props.confirm.onConfirm === "function") {
        await props.confirm.onConfirm();
    }
    confirmModal.value.close();
};

defineExpose({
    showConfirmModal,
});
</script>
<template>
    <dialog ref="confirmModal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">{{ confirm.title }}</h3>
            <p class="py-4">{{ confirm.message }}</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">close</button>
                </form>
                <button class="btn btn-primary" @click="handleConfirm">
                    ok
                </button>
            </div>
        </div>
    </dialog>
</template>
