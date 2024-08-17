import { ref } from "vue";
import { makeHttpReq } from "../../../helper/makeHttpReq";
import { showError, successMsg } from "../../../helper/toast-notification";
import { ShowErrorResponse } from "../../../helper/util";


const LoginUserType = {
    email: '',
    password: ''
};

export const loginInput = ref({ ...LoginUserType })


// const loading = ref(false)
export function useLoginUser(){

        async function login(){
            try {
                // loading.value = true
                const {data} = await makeHttpReq('login','POST', loginInput.value);
                console.log(data);
                // loading.value = false
                loginInput.value = {}
                if(data.isLoggedIn){
                    localStorage.setItem('userData',JSON.stringify(data))
                    window.location.href='/app/admin'
                }
                successMsg(data.message)
            } catch (error) {
                console.log(error);
                ShowErrorResponse(error)

            }
        }

    return{login}
}