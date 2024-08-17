import { makeHttpReq } from "../../../../helper/makeHttpReq";
import { successMsg } from "../../../../helper/toast-notification";
import { ShowErrorResponse } from "../../../../helper/util";

import {taskStore } from '../store/kabanStore'

export function useCreateTask(){

    async function createTask(){
        try {
            const data = await makeHttpReq('tasks','POST', taskStore.formInput)
            successMsg(data.message)
        } catch (error) {
            ShowErrorResponse(error)
        }
    }

    return {createTask}
}