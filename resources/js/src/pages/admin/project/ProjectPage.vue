<script setup>
import { handleError, onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import {myDebounce} from '../../../helper/util'
import {getUserData} from '../../../helper/getUserData'
import {useGetProjects } from './actions/getProjects'
import {usePinnedProjects} from './actions/pinnedProject'
import { projectStore } from './store/useProjectStore'

const router = useRouter()
const {data} = getUserData()
const {pinnedProject } = usePinnedProjects()
const { getProjects, projectData} = useGetProjects()

function editProject (project){
    projectStore.editMode = true
    projectStore.formInput = project
    router.push('/create-project')
}

// async function handlePinnedProject(id){
//     await pinnedProject(id)
// }


const query = ref('')
const search = myDebounce(async function(){
    getProjects(1,query.value)
},1000)

async function handleGetProjects(){
    await getProjects()
}
onMounted(async ()=> {
    await handleGetProjects()
    projectStore.editMode= false
    projectStore.formInput= {}
})
</script>

<template>
    <div class="flex-col">
        <h1>Project</h1>
        <hr>
        <RouterLink to="/create-project" class="float-end btn btn-primary mb-2">Create Project</RouterLink> 
        <div class="row">
            <div class="col-md-4">
                <input type="text" v-model="query" @keydown="search" class="form-control" placeholder="Search...">
            </div>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Completion</th>
                    <th>Edit</th>
                    <th>Pinned</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="project in projectData" :key="project.id">
                    <td>{{ project.id }}</td>
                    <td>{{ project.name }}</td>
                    <td>
                        <div class="progress"
                            role="progressbar"
                            aria-label="Example with label"
                            aria-valuenow="50"
                            aria-valuemin="0"
                            aria-valuemax="100">
                             <div class="progress-bar bg-success" :style="{width: project.task_progress.progress+'%'}">{{project?.task_progress?.progress}} %
                            </div> 
                        </div>
                    </td>
                    <td>
                        <button @click="editProject(project)" type="button" class="btn btn-outline-primary">Edit</button>
                    </td>

                    <td>
                        <button @click="pinnedProject(project.id)" type="button" class="btn btn-light">Pinned <i class="bi bi-activity"></i></button>
                    </td>
            
                    <td>
                        <RouterLink
                            class="btn btn-warning"
                            :to="'/kaban?query=' + project.slug"
                        >View <i class="bi bi-arrow-right"></i></RouterLink>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Bootstrap5Pagination v-if="projectData?.data" :data="projectData?.data" @pagination-change-page="getProjects" />


</template>