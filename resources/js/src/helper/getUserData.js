
export function getUserData(){

    const data = localStorage.getItem('userData')
    const userData = JSON.parse(data)
   
    return { userData}
}