
export const recentTasks = async (status,callBack)=>{
    const {data}= await axios.get(route('api.home.recentTask',{status}));
    callBack(data)
}