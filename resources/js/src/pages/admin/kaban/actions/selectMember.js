import { ref } from "vue";
import { taskStore } from "../store/kabanStore";
import { showError } from "../../../../helper/toast-notification";



export function useSelectMembers(){
    
    const selectedMembers = ref([])

    function selectMember(member){
        const exist = selectedMembers.value.filter((memberItem) => memberItem.id === member.id) 

        if(exist.length === 0){
            selectedMembers.value.push({
                id:member.id,
                name:member.name,
                email:member.email
            })
            taskStore.formInput.memberIds.push(member.id)
        }else{
            showError('you have already selected this member')
        }
    }

    function unSelectMember(memberId){
        const filteredMembers = selectedMembers.value.filter((memberItem) => memberItem.id !== memberId)
        const filteredMemberIds = taskStore.formInput.memberIds.filter((id) => id !== memberId)

        selectedMembers.value = filteredMembers
        taskStore.formInput.memberIds = filteredMemberIds
    }

    return {unSelectMember, selectMember, selectedMembers}
}