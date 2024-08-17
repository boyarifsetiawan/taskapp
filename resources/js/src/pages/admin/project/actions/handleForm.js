import { ref } from "vue";
import { makeHttpReq } from "../../../../helper/makeHttpReq";
import { showError, successMsg } from "../../../../helper/toast-notification";
import { ShowErrorResponse } from "../../../../helper/util";
import { projectStore } from "../store/useProjectStore";



// const loading = ref(false)
export function useFormProject(){
    
    async function store(){
        try {
            const data = projectStore.editMode === true ? await updateProject(projectStore.formInput.id) :  await createProject() 
            successMsg(data.message)
        } catch (error) {
            console.log(error);
            ShowErrorResponse(error)
        }
    }

    return{store}
}

async function createProject(){
    const data = await makeHttpReq('projects','POST', projectStore.formInput);
    projectStore.formInput = {}
    return data
}

async function updateProject(id){
    const data = await makeHttpReq(`projects/${id}`,'PUT', projectStore.formInput);
    projectStore.formInput = {}
    projectStore.editMode = false
    return data
}