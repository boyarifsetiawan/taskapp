<script setup>
defineProps({
    name: String,
    color: String,
    type:{
        type: String,
        default: 'button'
    }
})

</script>

<template >
    <button  :type="type" :class="color">{{ name }}</button>
</template>