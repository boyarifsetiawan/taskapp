import { ref } from "vue"
import { makeHttpReq } from "../../../../helper/makeHttpReq"
import { ShowErrorResponse } from "../../../../helper/util"


export function useGetPinnedProject(){

    const projectPinned = ref({})

    async function getPinnedProjects(){
        try {
            const data = await makeHttpReq('pinned/projects','GET')
            projectPinned.value = data?.data
        } catch (error) {
            ShowErrorResponse(error)
        }

    }

    return {projectPinned, getPinnedProjects}
}