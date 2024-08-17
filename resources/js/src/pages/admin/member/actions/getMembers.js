import { ref } from "vue"
import { makeHttpReq } from "../../../../helper/makeHttpReq"
import { ShowErrorResponse } from "../../../../helper/util"

export function useGetMembers(){

    const memberData = ref({})
    async function getMembers(page=1, query=''){
        try {
            const data = await makeHttpReq(`members?query=${query}&page=${page}`,'GET')
            memberData.value = data
        } catch (error) {
            ShowErrorResponse(error)
        }
    }

    return {getMembers, memberData}
}