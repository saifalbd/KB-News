
export const changeConfig = async function (bool,col,post){
    axios.put(route('api.post.changeConfig',{post}),{col,do:bool?1:0});
}