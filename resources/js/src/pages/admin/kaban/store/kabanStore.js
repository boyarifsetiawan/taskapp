import { defineStore } from 'pinia';
const FormTaskInputType = {
    name:'',
    memberIds:'',
    projectId:''
};
const useTaskStore = defineStore('task', {
  state: () => ({
    formInput:{...FormTaskInputType},
    editMode:false,
    currentTaskId : 0
  })
});

export const taskStore = useTaskStore();
