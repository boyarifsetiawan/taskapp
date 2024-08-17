<script setup>
defineProps({
    modelValue: {String},
    placeholder: {String},
    type: {
        type: String,
        default: 'text'
    },
})

const emit = defineEmits(['update:modelValue'])

function updateValue(event){
    const val = event.target.value
    // console.log(val);
    emit('update:modelValue',val)
}

</script>
<template>
    <input 
    :placeholder="placeholder"
    :value="modelValue" 
    :type="type" 
    @input="updateValue"
    class="form-control">
</template>