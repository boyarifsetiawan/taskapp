<script setup>
import { getChar } from '../../../../helper/util';
import { TaskStatus } from '../actions/getDetailProject';


defineProps({
    projectData: {Object}
})
const emit = defineEmits(['openTaskModal','fromNotStartedToPending','deleteTask'])
</script>
<template>
    <div class="col-md-4 not_started_task" >
        <div class="card card-header">
            <button @click="emit('openTaskModal')" class="btn btn-warning">Add Task</button>
        </div>
        <div
        v-for="task in projectData?.data?.tasks"
        :key="task.id"
        v-show="task.status===TaskStatus.NOT_STARTED ?true:false"
        @drag="emit('fromNotStartedToPending',task.id,projectData?.data?.id)"
        draggable="true"
        :class="'card card-body task_card notStartedTask_'+task.id">
        <div class="d-flex position-relative">
            <button @click="emit('deleteTask')" class="btn btn-secondary position-absolute top-0 end-0"><i class="bi bi-trash-fill"></i></button>
        </div>
            <p>{{task.name}}</p>
            <div class="assignees">
                <button v-for="(member,index) in task.task_members" 
                :key="member.id"
                :class="'btn btn-primary rounded-circle member_'+index ">
                {{getChar(member?.members?.name)}}
                </button>
                {{task?.task_members.length}} assignees
            </div>
        </div>
    
    </div>
</template>