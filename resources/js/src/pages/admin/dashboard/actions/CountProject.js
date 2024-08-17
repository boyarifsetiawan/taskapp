import { ref } from "vue"
import { makeHttpReq } from "../../../../helper/makeHttpReq"
import { ShowErrorResponse } from "../../../../helper/util"


export function useCountProjects(){

    const totalProjects = ref({})

    async function getTotalProjects(){
        try {
            const data = await makeHttpReq('count-projects','GET')
            totalProjects.value = data
            updateData()
        } catch (error) {
            ShowErrorResponse(error)
        }
    }

    function updateData(){
        window.Echo.channel('countProject').listen('NewProjectCreated', (e)=> {
            totalProjects.value = { count: e.countProject }
            console.log(e);
        })
    }

    return {totalProjects, getTotalProjects}
}