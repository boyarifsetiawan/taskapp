import {APP} from './APP'
import { getUserData } from './getUserData';

const {userData} = getUserData()

export function makeHttpReq(endpoint, http, input){
    return new Promise(async (resolve, reject) => {
        try{
            const res = await fetch(`${APP.apiBaseURL}/${endpoint}`,{
                method:http,
                headers:{
                    "content-type": "application/json",
                    Authorization: "Bearer "+userData?.token
                },
                body: JSON.stringify(input)
            });
            const data = await res.json();  
            if(!res.ok){
                reject(data)
            }
            resolve(data)

        }catch(error){
            reject(error)
        }
    })
}