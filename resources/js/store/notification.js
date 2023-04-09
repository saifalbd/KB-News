import { defineStore } from "pinia";

export const notificationStore = defineStore("notifications", {
    state() {
        return {
            count: 0,
            notifications: [],
            showModal:false,
        };
    },
    actions: {
        toggleNodal(val){
            this.showModal = val;
        },
        addNotify(notification) {
            this.notifications.unshift(notification);
            this.count++;
        },
        notificationsFetch() {
            axios.get(route("api.notification")).then(({ data }) => {
                this.notifications = data;
                this.count = data.length;
            });
        },
       
    },
    getters:{
        taskNotifications(){
            return this.notifications.filter((e) =>["TaskAssigned" , "TaskStatusChanged"].includes(e.type));
        },
        employeeAssignedNotifications(){
            return this.notifications.filter(e=>e.type=='EmployeeAssigned')
        },
     

        
    }
});
