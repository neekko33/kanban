<script setup>
    import { ref } from "vue";
    const count = ref(0);
    const increment = () => {
        count.value++;
    };
</script>
<template>
    <h1>Hello, Vue!</h1>
    <button @click="increment">Increment</button>
    <p>Count: {{ count }}</p>
</template>
