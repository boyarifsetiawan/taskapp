import { makeHttpReq } from "../../../../helper/makeHttpReq";
import { successMsg } from "../../../../helper/toast-notification";
import { ShowErrorResponse } from "../../../../helper/util";

import {taskStore } from '../store/kabanStore'

export function useDeleteTask(){

    async function deleteTask(id){
        console.log(id);
        try {
            const data = await makeHttpReq('tasks','DELETE', {taskId:id})
            successMsg(data.message)
        } catch (error) {
            ShowErrorResponse(error)
        }
    }

    return {deleteTask}
}