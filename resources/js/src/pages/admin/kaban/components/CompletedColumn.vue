<script setup>
import { getChar, myDebounce } from "../../../../helper/util";
import {TaskStatus} from "../actions/getDetailProject";

defineProps({
    projectData:{Object}
})
const emit=defineEmits(['fromCompletedToPending'])


</script>
<template>
    <div class="col-md-4 complete_task ">
        <div class="card card-header">
            <b>Completed</b>
        </div>

        <div
        v-for="task in projectData?.data?.tasks"
        :key="task.id"
        v-show="task.status === TaskStatus.COMPLETED ? true : false"
        draggable="true"
        @drag="emit('fromCompletedToPending',task.id,projectData?.data?.id)"
        :class="'card card-body task_card completeTask_'+task.id"
        >
            <p>{{ task.name }}</p>
            <div class="assignees">
                <button
                    v-for="(member, index) in task.task_members"
                    :key="member.id"
                    :class="'btn btn-primary member_' + index"
                >
                    {{ getChar(member?.members?.name) }}
                </button>
                {{ task?.task_members.length }} assignees
            </div>
        </div>
    </div>
</template>