import { ref } from "vue";
import { makeHttpReq } from "../../../helper/makeHttpReq";
import { showError, successMsg } from "../../../helper/toast-notification";
import { ShowErrorResponse } from "../../../helper/util";
const RegisterUserType = {
    email: '',
    password: ''
};

export const registerInput = ref({ ...RegisterUserType })

const loading = ref(false)
export function useRegisterUser(){

        async function register(){
            try {
                // loading.value = true
                const data = await makeHttpReq('register','POST', registerInput.value);
                console.log(data);
                // loading.value = false
                registerInput.value = {}
                // successMsg(data.message)
                // console.log(data.message);
            } catch (error) {
                console.log(error)
                ShowErrorResponse(error)
            }
        }

    return{register}
}