<script setup>
import { RouterView } from "vue-router";
import Alert from "./components/Alert.vue";
import { ref, reactive, provide } from "vue";

const alert = reactive({
    show: false,
    type: "success",
    message: "",
});

const setAlert = (type, message) => {
    alert.type = type;
    alert.message = message;
    alert.show = true;
    setTimeout(() => {
        alert.show = false;
    }, 3000);
};

provide("setAlert", setAlert);
</script>
<template>
    <Alert :alert="alert" />
    <RouterView></RouterView>
</template>
