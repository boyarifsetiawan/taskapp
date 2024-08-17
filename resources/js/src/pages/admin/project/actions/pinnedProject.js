import { ref } from "vue"
import { makeHttpReq } from "../../../../helper/makeHttpReq"
import { ShowErrorResponse } from "../../../../helper/util"
import { successMsg } from "../../../../helper/toast-notification";

export function usePinnedProjects(){

    async function pinnedProject(id){
        try {
            const data = await makeHttpReq('projects/pinned','POST',{projectId:id})
            successMsg(data.message)
            
        } catch (error) {
            ShowErrorResponse(error)
            console.log(error);
        }
    }

    return{ pinnedProject}
}