<script setup>
import { onMounted } from "vue";
import {useRoute} from "vue-router"
import BreadCrumb from "./components/BreadCrumb.vue";
import ProjectDetail from "./components/ProjectDetail.vue";
import ProjectProgress from "./components/ProjectProgress.vue"
import TaskModal from "./components/TaskModal.vue";
import NotStartedColumn from "./components/NotStartedColumn.vue"
import PendingColumn from "./components/PendingColumn.vue"
import CompletedColumn from "./components/CompletedColumn.vue"
import DeleteModal from "./components/DeleteModal.vue"


import { useGetProjectDetail} from "./actions/getDetailProject"
import { openModal, closeModal } from "../../../helper/util";
import { taskStore } from "./store/kabanStore";
import { useGetMembers } from "../member/actions/getMembers";
import { useSelectMembers } from "./actions/selectMember";
import { useDragTask } from "./actions/dragTask";
// import {useDeleteTask} from "./actions/deleteTask"


const { projectData , getProjectDetail } = useGetProjectDetail()
const {getMembers, memberData } = useGetMembers()
const {selectedMembers} = useSelectMembers()
// const {deleteTask} = useDeleteTask()

const route = useRoute()
const slug = route.query?.query
const {fromNotStartedToPending,
    fromPendingToCompleted,
    fromCompletedToPending} = useDragTask(getProjectDetail,slug)

async function openTaskModal(){
    openModal('taskModal').then(() => {
        taskStore.formInput.projectId=projectData.value?.data?.id
        taskStore.formInput.memberIds=[]
        console.log('modal open....')
    })

}

function closeTaskModal(){
    closeModal('taskModal')
}


async function refreshKabanBoard(){
    await getProjectDetail(slug)
}

onMounted(async () => {
    await getProjectDetail(slug)
    getMembers(1,'')
})
</script>
<template>
    <div class="row mb-2">
        <TaskModal 
        :members="memberData"
        @refreshKabanBoard="refreshKabanBoard"
        @getMembers="getMembers"
        @closeModal="closeTaskModal"/>
        <BreadCrumb />
        <ProjectDetail :projectData="projectData" />
        <ProjectProgress :projectData="projectData"/>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row overflow-auto" style="height: 500px;">
                <NotStartedColumn 
                @fromNotStartedToPending="fromNotStartedToPending"
                @openTaskModal="openTaskModal"
                :projectData="projectData" />


                <PendingColumn 
                @fromPendingToCompleted="fromPendingToCompleted"
                :projectData="projectData" />


                <CompletedColumn 
                @fromCompletedToPending="fromCompletedToPending"
                :projectData="projectData"/>
            </div>
        </div>
    </div>
</template>
<style >
.hovered{
    border:2px dashed rgb(157, 156, 156);
    border-radius: 5px;
}
.assignees button {
    border-radius: 50px;
    width: 40px;
    height: 40px;
    border: 1px solid grey;
}
.assignees .member_1 {
    position: relative;
    left: -10px;
}
.assignees .member_2 {
    position: relative;
    left: -20px;
}
.task_card {
    padding: 10px;
    margin-top: 7px;
}
.not_started_task {
    background-color: aliceblue;
}
.pending_task {
    background-color: rgb(232, 233, 233);
}
</style>