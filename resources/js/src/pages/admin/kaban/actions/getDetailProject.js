import { ref } from "vue"
import { makeHttpReq } from "../../../../helper/makeHttpReq"
import { ShowErrorResponse } from "../../../../helper/util"

export const TaskStatus = {
    NOT_STARTED : 0,
    PENDING : 1,
    COMPLETED : 2
}

export function useGetProjectDetail(){

    const projectData = ref({})
    async function getProjectDetail(slug){
        try {
            const data = await makeHttpReq(`projects/${slug}`,'GET')
            projectData.value = data
        } catch (error) {
            ShowErrorResponse(error)
        }
    }

    return {getProjectDetail, projectData}
}