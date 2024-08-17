import { ref } from "vue";
import { makeHttpReq } from "../../../../helper/makeHttpReq";
import { showError, successMsg } from "../../../../helper/toast-notification";
import { ShowErrorResponse } from "../../../../helper/util";
import { memberStore } from "../store/useMemberStore";



// const loading = ref(false)
export function useFormMember(){
    
    async function store(){
        try {
            const data = memberStore.editMode === true ? await updateMember(memberStore.formInput.id) :  await createMember() 
            successMsg(data.message)
        } catch (error) {
            console.log(error);
            ShowErrorResponse(error)
        }
    }

    return{store}
}

async function createMember(){
    const data = await makeHttpReq('members','POST', memberStore.formInput);
    memberStore.formInput = {}
    return data
}

async function updateMember(id){
    const data = await makeHttpReq(`members/${id}`,'PUT', memberStore.formInput);
    memberStore.formInput = {}
    memberStore.editMode = false
    return data
}