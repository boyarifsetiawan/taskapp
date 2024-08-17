import { ref } from "vue"
import { makeHttpReq } from "../../../../helper/makeHttpReq"
import { ShowErrorResponse } from "../../../../helper/util"

const TypeChartData = {
    tasks: '',
    progress: ''
}

export function useGetChartData(){

    const chartData = ref({...TypeChartData})
    
    async function getChartData(projectId){
        try {
            const data = await makeHttpReq(`chart-data/projects?projectId=${projectId}`,'GET')
            console.log(data);
            chartData.value = data
            updateData()
        } catch (error) {
            // console.log(error);
            ShowErrorResponse(error)
        }

    }

    function updateData(){
        window.Echo.channel('projectProgress').listen('TrackProjectProgress', (e)=> {
            chartData.value.progress = 0
            setTimeout(()=>{
                chartData.value.progress = e.projectProgress 
            },1000)
        })

        window.Echo.channel('task').listen('TrackCompletedAndPendingTask', (e)=> {
            console.log(e.tasks);
            chartData.value.tasks = ''
            setTimeout(()=>{
                chartData.value.tasks = e.tasks
            },1000)
        })

    }

    return {chartData, getChartData}
}