import {
    createRouter,
    createWebHashHistory,
    createWebHistory,
} from "vue-router";
import { mainStore } from "../store";
const routes = [
    {
        path: "/",
        component: () => import("../pages/Authorize/login-page.vue"),
        name: "login",
    },
    {
        path: "/register",
        name: "register",
        component: () => import("../pages/Authorize/register-page.vue"),
    },
    {
        path: "/forgot-password",
        name: "forgotPassword",
        component: () => import("../pages/Authorize/forgotPassword.vue"),
    },

    
    {
        path: "/home",
        name: "home",
        component: () => import("../pages/Home/index.vue"),
    },
    {
        path: "/categories",
        name: "category",
        component: () => import("../pages/Category/index.vue"),
    },
    {
        path: "/tags",
        name: "tag",
        component: () => import("../pages/Tag/index.vue"),
    },
    {
        path:'/contacts',
        name:'contact',
        component: () => import("../pages/Contact/index.vue"),
    },
    {
        path: "/departments",
        name: "department",
        component: () => import("../pages/Department/index.vue"),
    },
    {
        path: "/designations",
        name: "designation",
        component: () => import("../pages/Designation/index.vue"),
    },
    {
        path: "/employees",
        name: "employee",
        component: () => import("../pages/Employee/index.vue"),
    },
   
    {
        path:'/posts',
        name:'post.index',
        component:()=>import('../pages/Post/index.vue')
    },
    {
        path:'/posts/:id',
        name:'post.show',
        component:()=>import('../pages/Post/show.vue'),
        props:(route)=>({id:route.params.id})
    },
    {
        path:'/posts/:id/edit',
        name:'post.edit',
        component:()=>import('../pages/Post/edit.vue'),
        props:(route)=>({id:route.params.id})
    },
    {
        path:'/posts/create',
        name:'post.create',
        component:()=>import('../pages/Post/create.vue')
    },

 
    /**Start My Jobs */

  
  
  
  
  
    {
        path:'/profile',
        name:'profile',
        component:()=>import('../pages/Profile/index.vue')
    },
    {
        path:'/user-profile/:user',
        name:'userProfile',
        component:()=>import('../pages/Profile/index.vue'),
        props: (route) => ({ user_id: route.params.user }),
    },
    
];

const router = createRouter({
    
    history: createWebHistory('/admin'),
    routes,
});

router.beforeEach((from, to) => {
    let main = mainStore();
    let token = main.token;
    let guestPath = ["/", "/register"];
    if(to.name){
        if (!guestPath.includes(from.path) && !to.name) {
            return { name: "login" };
        } else if (guestPath.includes(to.path)) {
            return true;
        } else {
            if (token) {
                return true;
            } else {
                return { name: "login" };
            }
        }
    }
   
});

export default router;
