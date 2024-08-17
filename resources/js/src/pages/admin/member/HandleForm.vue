<script setup>
import { useFormMember} from '../member/actions/handleForm'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { memberStore } from "../member/store/useMemberStore";
import {useRouter} from 'vue-router'


const rules = {
    email: { required, email },
    name: { required }, 
}

const v$ =  useVuelidate(rules, memberStore.formInput)
const {store} = useFormMember()
const router = useRouter()

async function handleSubmit(){
    const result = await v$.value.$validate()
    
    if(!result) return
    router.push('/members')

    await store()
    v$.value.$reset()
}
</script>
<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div v-if="memberStore.editMode" class="card-header text-center">
                        <h1 >Edit Member</h1>
                    </div>
                    <div v-else class="card-header text-center">
                        <h1 >Create Member</h1>
                    </div>
                    <div class="card-body">
                        {{ memberStore.formInput }}
                        <form @submit.prevent="handleSubmit">
                            <div class="form-group mb-2">
                                <Error label="Email Address" :errors="v$.email.$errors">
                                    <BaseInput v-model="memberStore.formInput.email" type="email" />
                                </Error>
                            </div>
                            <div class="form-group mb-2">
                                <Error label="Name" :errors="v$.name.$errors">
                                    <BaseInput v-model="memberStore.formInput.name"/>
                                </Error>
                            </div>
                                <BaseButton name="Submit" type="submit" color="btn btn-primary" />
                                <RouterLink :to="{ name: 'members' }" class="mx-4">Cancel</RouterLink>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>