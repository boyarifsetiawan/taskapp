import { defineStore } from 'pinia';
const FormMemberType = {
    email: '',
    name: ''
};
const useMemberStore = defineStore('member', {
  state: () => ({
    formInput:{...FormMemberType},
    editMode:false
  })
});

export const memberStore = useMemberStore();