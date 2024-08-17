import { makeHttpReq } from "../../../helper/makeHttpReq";
import { showError, successMsg } from "../../../helper/toast-notification";
import { ShowErrorResponse } from "../../../helper/util";


export function useLogoutUser(){

        async function logout(userId){
            try {
                const data = await makeHttpReq('logout','POST', {userId} );
                
                localStorage.removeItem('userData')
                console.log(data);
                successMsg(data.message)
            } catch (error) {
                ShowErrorResponse(error)
            }
        }

    return{logout}
}