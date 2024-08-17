import { ref } from "vue";
import { makeHttpReq } from "../../../../helper/makeHttpReq"


export function useGetProjects(){

    const projectData = ref({})
    async function getProjects(page=1, query='' ){
        const {data} = await makeHttpReq(`projects?query=${query}&page=${page}`,'GET')
        projectData.value = data
    }

    return{projectData, getProjects}
}