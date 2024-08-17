
import { useToast } from "vue-toast-notification";

const toast = useToast()
export function showError(message){
    toast.error(message, {
        position: 'bottom-right',
        dismissible: true,
        duration: 4000,
    })
}

export function successMsg(message){
    toast.success(message, {
        position: 'bottom-right',
        dismissible: true,
        duration: 4000,
    })
}