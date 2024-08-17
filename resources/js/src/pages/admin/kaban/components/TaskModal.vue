<script setup>
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { ref } from "vue";
import { showError } from "../../../../helper/toast-notification";
import { taskStore } from "../store/kabanStore";
import { myDebounce } from "../../../../helper/util";
import { useSelectMembers } from "../actions/selectMember";
import { useCreateTask } from "../actions/createTask";

defineProps({
    members: {Object}
})

const emit = defineEmits(['closeModal','refreshKabanBoard','getMembers'])

const rules = {
    name: { required }, // Matches state.lastName
};
const v$ = useVuelidate(rules, taskStore.formInput);

const { selectMember, unSelectMember, selectedMembers } = useSelectMembers();
const { createTask } = useCreateTask();

async function submitTask() {
    const result = await v$.value.$validate();
    
    if (!result) return;
  
    if(taskStore.formInput.memberIds.length >0){
        await createTask();
        taskStore.formInput.memberIds=[]
        taskStore.formInput.name=""
        emit('closeModal')
        v$.value.$reset()
        emit('refreshKabanBoard')
    }else{
        showError('please select a member !')
    }    
    
}


const query = ref("");
const searchMember=myDebounce(async function(){
    emit('getMembers',1,query.value)
},200)
</script>
<template>
    <!-- Modal -->
    <div
        class="modal fade"
        id="taskModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <!--  -->
                <form
                @submit.prevent="submitTask"
                    enctype="multipart/form-data"
                >
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            Add Task
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            @click="emit('closeModal')"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body" >
                        <div class="select-members">
                            <span
                                v-for="member in selectedMembers"
                                @click="unSelectMember(member.id)"
                                :key="member.id"
                            >
                                {{ member.name }} <b>x</b>
                            </span>
                        </div>
                        <!-- <span v-else>Select a members..</span> -->

                        <div class="row">
                            <div class="row">
                                <div class="col-md-9 mb-3">
                                    <Error label="Name"  :errors="v$.name.$errors">
                                        <BaseInput
                                            type="text"
                                            placeholder="Task name"
                                            v-model="taskStore.formInput.name"
                                            />
                                    </Error>
                                </div>
                                <div class="col-md-3 display-flex mt-4 p-1">
                                    <BaseButton name="Add Task" type="submit" color="btn btn-primary" />
                                </div>

                            </div>
                            <!-- <br />
                            <br />
                            <br /> -->

                            <div class="form-group">
                                <!-- @keyup="searchMember" -->
                                <BaseInput
                                    type="text"
                                    v-model="query"
                                    @keydown="searchMember"
                                    placeholder="Search a member..."
                                />
                            </div>

                            <br />
                            <br />
                        </div>
                        <br />
                        <table class="table table-hover table-sm">
                            <thead style="font-weight: bold">
                                <tr>
                                    <td>ID</td>
                                    <td>Name</td>
                                    <td>Select</td>
                                </tr>
                            </thead>
                            <tr
                                v-for="member in members?.data?.data"
                                :key="member.id"
                            >
                                <td># {{ member.id }}</td>
                                <td>{{ member.name }}</td>
                                <td>
                                    <button
                                    @click="selectMember(member)"
                                        type="button"
                                        class="btn btn-light"
                                        style="
                                            border-radius: 10px;
                                            background-color: aliceblue;
                                        "
                                    >
                                        <b>+</b> Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<style scoped>
.select-members span {
    padding: 5px;
    border-radius: 4px;
    border: 1px solid gray;
    cursor: pointer;
    margin: 2px;
}
.select-members span b {
    color: red;
}
</style>