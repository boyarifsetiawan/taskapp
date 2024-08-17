<script setup>
import { useFormMember} from '../member/actions/handleForm'
import { useFormProject} from './actions/handleForm'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { projectStore } from "../project/store/useProjectStore";
import {useRouter} from 'vue-router'


const rules = {
    name: { required }, 
    startDate: { required },
    endDate: { required },
}

const v$ =  useVuelidate(rules, projectStore.formInput)
const {store} = useFormProject()
const router = useRouter()

async function handleSubmit(){
    const result = await v$.value.$validate()
    
    if(!result) return
    router.push('/projects')

    await store()
    v$.value.$reset()
}
</script>
<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div v-if="projectStore.editMode" class="card-header text-center">
                        <h1 >Edit Project</h1>
                    </div>
                    <div v-else class="card-header text-center">
                        <h1 >Create Project</h1>
                    </div>
                    <div class="card-body">
                        {{ projectStore.formInput }}
                        <form @submit.prevent="handleSubmit">
                            <div class="form-group mb-2">
                                <Error label="Name" :errors="v$.name.$errors">
                                    <BaseInput v-model="projectStore.formInput.name" type="text" />
                                </Error>
                            </div>
                            <div class="form-group mb-2">
                                <Error label="Start Date" :errors="v$.startDate.$errors">
                                    <BaseInput v-model="projectStore.formInput.startDate" type="date"/>
                                </Error>
                            </div>
                            <div class="form-group mb-2">
                                <Error label="End Date" :errors="v$.endDate.$errors">
                                    <BaseInput v-model="projectStore.formInput.endDate" type="date"/>
                                </Error>
                            </div>
                                <BaseButton name="Submit" type="submit" color="btn btn-primary" />
                                <RouterLink :to="{ name: 'projects' }" class="mx-4">Cancel</RouterLink>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>