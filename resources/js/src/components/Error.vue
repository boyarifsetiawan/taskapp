<script setup>
import {defineProps} from 'vue'
const props = defineProps({
    label: {
        type: String,
        default: ''
    },
    errors: {
        type: Array,
    }
})
</script>
<template>
    <label for="email" class="mb-2">{{ props.label }}</label>
    <div :class="{ error: props.errors.length }">
    <slot></slot>
        <div class="input-errors" v-for="error of props.errors" :key="error.$uid">
            <span class="error-msg">{{ error.$message }}</span>
        </div>
    </div>
</template>
<style scope>
.input-errors{
    color: rgb(190, 6, 6);
}
</style>