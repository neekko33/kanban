<script setup>
import dayjs from "dayjs";
defineProps({
    columns: {
        type: Array,
        default: () => [],
    },
    data: {
        type: Array,
        default: () => [],
    },
});
</script>
<template>
    <div
        class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100"
    >
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th v-for="column in columns" :key="column.field">
                        {{ column.name }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in data" :key="item.id">
                    <th>{{ index + 1 }}</th>
                    <td v-for="column in columns" :key="column.field">
                        <slot :name="column.field" :row="item">
                            <span v-if="column.timestamp">
                                {{
                                    dayjs(item[column.field]).format(
                                        "YYYY-MM-DD"
                                    )
                                }}
                            </span>
                            <span v-else>
                                {{ item[column.field] }}
                            </span>
                        </slot>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
