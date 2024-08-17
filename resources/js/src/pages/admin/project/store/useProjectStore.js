import { defineStore } from 'pinia';
const FormProjectType = {
    name: '',
    startDate: '',
    endDate: '',
};
const useProjectStore = defineStore('project', {
  state: () => ({
    formInput:{...FormProjectType},
    editMode:false
  })
});

export const projectStore = useProjectStore();