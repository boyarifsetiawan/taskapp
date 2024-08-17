<script setup>
import {registerInput, useRegisterUser} from './actions/register'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'


const rules = {
      email: { required, email },
      password: { required }, 
    }
const v$ =  useVuelidate(rules, registerInput)
const {register} = useRegisterUser()
async function submitRegister(){
    const result = await v$.value.$validate()

    if(!result) return

    await register()
    v$.value.$reset()
}

</script>
<template>
     <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Register Form</h4>
                    </div>
                    <div class="card-body">
                        {{ registerInput }}
                        <form @submit.prevent="submitRegister">
                            <div class="form-group mb-2">
                                <Error label="Email Address" :errors="v$.email.$errors">
                                    <BaseInput v-model="registerInput.email" type="email" />
                                </Error>
                            </div>
                            <div class="form-group mb-2">
                                <Error label="Password" :errors="v$.password.$errors">
                                    <BaseInput v-model="registerInput.password" type="password" />
                                </Error>
                            </div>
                                <BaseButton name="Submit" type="submit" color="btn btn-primary" />
                                <RouterLink :to="{ name: 'login' }" class="mx-4">Click here to Login</RouterLink>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>