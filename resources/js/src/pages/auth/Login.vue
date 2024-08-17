<script setup>
import {loginInput, useLoginUser} from './actions/login'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'


const rules = {
      email: { required, email },
      password: { required }, 
    }
const v$ =  useVuelidate(rules, loginInput)
const {login} = useLoginUser()
async function submitLogin(){
    const result = await v$.value.$validate()

    if(!result) return

    await login()
    v$.value.$reset()
}

</script>
<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login Form</h4>
                    </div>
                    <div class="card-body">
                        {{ loginInput }}
                        <form @submit.prevent="submitLogin">
                            <div class="form-group mb-2">
                                <Error label="Email Address" :errors="v$.email.$errors">
                                    <BaseInput v-model="loginInput.email" type="email" />
                                </Error>
                            </div>
                            <div class="form-group mb-2">
                                <Error label="Password" :errors="v$.password.$errors">
                                    <BaseInput v-model="loginInput.password" type="password" />
                                </Error>
                            </div>
                                <BaseButton name="Submit" type="submit" color="btn btn-primary" />
                                <RouterLink :to="{ name: 'register' }" class="mx-4">Click here to Register</RouterLink>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>