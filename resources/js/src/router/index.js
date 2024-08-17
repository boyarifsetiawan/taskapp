import { createRouter,createWebHistory } from "vue-router";
import { getUserData } from "../helper/getUserData";

const router = createRouter({
    history: createWebHistory('/app'),
    routes: [
        {
            path: '/register',
            name: 'reister',
            component: ()=> import('../pages/auth/AuthPage.vue'),
            meta: {requiresAuth: false},
            children:[
                {
                    path: '/register',
                    name: 'register',
                    component: ()=> import('../pages/auth/Register.vue')
                },
                {
                    path: '/login',
                    name: 'login',
                    component: ()=> import('../pages/auth/Login.vue')
                }
            ]
        },
        {
            path: '/admin',
            component: ()=> import('../pages/admin/AdminPage.vue'),
            meta: {requiresAuth: true},
            children:[
                {
                    path: '/admin',
                    name: 'admin',
                    component: ()=> import('../pages/admin/dashboard/DashboardPage.vue')
                },
                {
                    path: '/members',
                    name: 'members',
                    component: ()=> import('../pages/admin/member/MemberPage.vue')
                },
                {
                    path: '/create-member',
                    name: 'createMember',
                    component: ()=> import('../pages/admin/member/HandleForm.vue')
                },
                {
                    path: '/projects',
                    name: 'projects',
                    component: ()=> import('../pages/admin/project/ProjectPage.vue')
                },
                {
                    path: '/create-project',
                    name: 'createProject',
                    component: ()=> import('../pages/admin/project/HandleForm.vue')
                },
                {
                    path: '/kaban',
                    name: 'kaban',
                    component: ()=> import('../pages/admin/kaban/KabanBoard.vue')
                },
            ]
        }
    ]
})

router.beforeEach((to , from, next) => {
    const {userData} = getUserData()
    if(to.meta.requiresAuth && !userData?.token){
      next({name: 'login'})
    }else if(userData?.token && (to.name === 'login' || to.name === 'register')){
      next({name: 'admin'})
    }else{
      next();
    }
  })

export default router