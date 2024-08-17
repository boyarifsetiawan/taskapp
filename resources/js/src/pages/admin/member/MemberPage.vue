<script setup>
import { handleError, onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import {useGetMembers} from './actions/getMembers'
import {useFormMember} from './actions/handleForm'
import {myDebounce} from '../../../helper/util'
import { memberStore } from "../member/store/useMemberStore";
import {getUserData} from '../../../helper/getUserData'

const {data} = getUserData()
const router = useRouter()


const {getMembers, memberData} = useGetMembers()


function editMember(member){
    memberStore.formInput = member
    router.push('/create-member')
    memberStore.editMode = true
}

const query = ref('')
const search = myDebounce(async function(){
    getMembers(1,query.value)
},1000)

async function handleGetMembers(){
    await getMembers()
}
onMounted(async ()=> {
    await handleGetMembers()
    memberStore.editMode= false
    memberStore.formInput= {}
})
</script>

<template>
    <div class="flex-col">
        <h1>Members</h1>
        <hr>
        <RouterLink to="/create-member" class="float-end btn btn-primary mb-2">Create Member</RouterLink> 
        <div class="row">
            <div class="col-md-4">
                <input type="text" v-model="query" @keydown="search" class="form-control" placeholder="Search...">
            </div>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="member in memberData?.data?.data" :key="member.id">
                    <td>{{ member.id }}</td>
                    <td>{{ member.name }}</td>
                    <td>{{ member.email }}</td>
                    <td>
                        <button @click="editMember(member)" class="btn btn-warning">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Bootstrap5Pagination v-if="memberData?.data" :data="memberData?.data" @pagination-change-page="getMembers" />


</template>