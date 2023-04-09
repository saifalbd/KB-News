import{a as ee,S as te}from"./app-layout-ddd4ecde.js";import{_ as oe}from"./PageTitleBox-3291f9d9.js";import{P as le}from"./Pagination-912d8bd3.js";import{R as se}from"./RemoveEditButton-b2c637d7.js";import{C as ae,E as ne}from"./Edit-61168de1.js";import{C as re}from"./CreateButton-a2dd5868.js";import{_ as ie,X as ce,a9 as de,aa as _e,W as ue,a7 as pe,ab as me,x as fe,Z as ve,ah as ye,ai as ke,aj as he,r as m,ac as O,h as b,w as t,u as ge,l as be,Q as Ce,R as xe,e as s,f as k,i as d,b as e,j as E,c as U,p as F,F as M,t as C}from"./app-15300521.js";import{u as we}from"./useToast-c3bf6ae8.js";import"./FormDialog-0d177dd5.js";import"./index-810449cf.js";import"./moment-fbc5633a.js";const Pe={components:{AppLayout:ee,PageTitleBox:oe,Pagination:le,Create:ae,EditVue:ne,Edit:ce,List:de,Box:_e,CreateButton:re,RemoveEditButton:se,StatusBtn:te,Delete:ue,More:pe,Search:me,Collection:fe,Expand:ve,Download:ye,Star:ke,StarFilled:he},setup(){const x=m(!1),n=m(!0),A=we(),l=ge(),f=m([]),w=m([]),h=m([]),v=m(!1),r=m([]),i=m(50),P=[{key:"user_star",label:"Star",sortable:!0},{key:"id",sortable:!0,sortingOptions:["desc","asc"]},{key:"title",sortable:!0},{key:"category.title",label:"Category",sortable:!0},{key:"employee",label:"Employee",sortable:!0},{key:"start",label:"Start",sortable:!0},{key:"end",label:"Dead Line",sortable:!0},{key:"status",sortable:!0},{key:"action",thAlign:"right",tdAlign:"right"}],S=m("asc");O("employees",a=>{w.value=a}),O("categories",a=>{h.value=a});const g=async a=>{try{const c=route("task.index",{perPage:i.value,page:a}),{data:_}=await axios.get(c);r.value=_.links,f.value=be.sortBy(addProtos(_.data,{action:!0,showEdit:!1}),"user_star").reverse()}catch(c){console.error(c)}n.value=!1};return g(1),{busy:n,showCreate:v,perPage:i,sortingOrder:S,items:f,columns:P,push:a=>{v.value=!1,f.value.push(a)},replace:(a,c)=>{v.value=!1,f.value.splice(c,1,a)},fetchItems:g,employees:w,categories:h,remove:async(a,c)=>{if(!await Ce(a,"Task","title"))return null;try{const y=route("task.destroy",{task:a.id});await axios.delete(y),f.value.splice(c,1),xe(A)}catch(y){console.log(y)}},addStar:a=>{a.user_star=!a.user_star,axios.post(route("task.changeStar",{task:a.id}),{prop:"user_star",star:a.user_star?0:1})},doArchive:(a,c)=>{f.value.splice(c,1),axios.post(route("task.doArchive",{task:a.id}),{prop:"user_archive",do:a.user_archive?0:1})},links:r,router:l,isCardWise:x}}},Se={class:"filter-row mt-2"},ze={class:"left-side"},Ee={class:"item"},Ae={class:"right-side"},Be={class:"item right mr-3"},Te={class:"item right"},Ve=["innerHTML"],Le={class:"ml-1"};function We(x,n,A,l,f,w){const h=s("create-button"),v=s("download"),r=s("el-icon"),i=s("el-button"),P=s("page-title-box"),S=s("el-option"),g=s("collection"),B=s("el-select"),T=s("list"),V=s("box"),z=s("el-button-group"),L=s("search"),a=s("el-input"),c=s("el-divider"),_=s("el-descriptions-item"),y=s("status-btn"),W=s("delete"),N=s("more"),j=s("el-descriptions"),H=s("el-card"),I=s("el-col"),Q=s("el-row"),R=s("el-link"),X=s("star-filled"),Z=s("el-avatar"),q=s("expand"),G=s("edit"),J=s("edit-vue"),K=s("va-data-table"),Y=s("pagination"),D=s("create"),$=s("app-layout");return k(),b($,{busy:l.busy},{default:t(()=>[d("div",null,[e(P,{title:"Task"},{default:t(()=>[e(h,{title:"Add Task",onClick:n[0]||(n[0]=o=>l.showCreate=!0)}),e(i,{type:"primary",onClick:n[1]||(n[1]=o=>l.router.push({name:"task.archive"}))},{default:t(()=>[e(r,null,{default:t(()=>[e(v)]),_:1}),E(" Archives ")]),_:1})]),_:1})]),d("div",Se,[d("div",ze,[d("div",Ee,[e(B,{modelValue:l.perPage,"onUpdate:modelValue":n[2]||(n[2]=o=>l.perPage=o),placeholder:"Per Page"},{prefix:t(()=>[e(r,{class:"el-input__icon"},{default:t(()=>[e(g)]),_:1})]),default:t(()=>[(k(),U(M,null,F([10,20,30,40,50,70,100],o=>e(S,{key:o,label:o,value:o},null,8,["label","value"])),64))]),_:1},8,["modelValue"])])]),d("div",Ae,[d("div",Be,[e(z,null,{default:t(()=>[e(i,{type:l.isCardWise?"info":"primary",onClick:n[3]||(n[3]=o=>l.isCardWise=!1)},{default:t(()=>[e(r,null,{default:t(()=>[e(T)]),_:1})]),_:1},8,["type"]),e(i,{type:l.isCardWise?"primary":"info",onClick:n[4]||(n[4]=o=>l.isCardWise=!0)},{default:t(()=>[e(r,null,{default:t(()=>[e(V)]),_:1})]),_:1},8,["type"])]),_:1})]),d("div",Te,[e(a,{placeholder:"Type something"},{prefix:t(()=>[e(r,{class:"el-input__icon"},{default:t(()=>[e(L)]),_:1})]),_:1})])])]),e(c),l.isCardWise?(k(),b(Q,{key:0,class:"card-list",gutter:24},{default:t(()=>[(k(!0),U(M,null,F(l.items,(o,u)=>(k(),b(I,{sm:24,md:12,key:u},{default:t(()=>[e(H,null,{default:t(()=>[e(j,{title:o.title,direction:"horizontal",column:1,size:"small",border:""},{default:t(()=>[e(_,{label:"Assgned To:"},{default:t(()=>[E(C(o.employee.model.name),1)]),_:2},1024),e(_,{label:"Dead Line:"},{default:t(()=>[E(C(o.end),1)]),_:2},1024),e(_,{label:"Status:"},{default:t(()=>[e(y,{status:o.status,size:"small"},null,8,["status"])]),_:2},1024),e(_,{label:"Delete:"},{default:t(()=>[e(i,{size:"small",type:"danger",plain:"",onClick:p=>l.remove(o,u)},{default:t(()=>[e(r,null,{default:t(()=>[e(W)]),_:1})]),_:2},1032,["onClick"])]),_:2},1024),e(_,{label:"View:"},{default:t(()=>[e(i,{size:"small",type:"info",plain:"",onClick:p=>l.router.push({name:"task.show",params:{id:o.id}})},{default:t(()=>[e(r,null,{default:t(()=>[e(N)]),_:1})]),_:2},1032,["onClick"])]),_:2},1024)]),_:2},1032,["title"]),d("div",{class:"description",innerHTML:o.description},null,8,Ve)]),_:2},1024)]),_:2},1024))),128))]),_:1})):(k(),b(K,{key:1,items:l.items,columns:l.columns,hoverable:!0,"sorting-order":l.sortingOrder,"onUpdate:sortingOrder":n[5]||(n[5]=o=>l.sortingOrder=o)},{"cell(title)":t(({rowData:o})=>[e(R,{onClick:u=>x.go({name:"task.show",params:{id:o.id}})},{default:t(()=>[d("b",null,C(o.title),1)]),_:2},1032,["onClick"])]),"cell(user_star)":t(({rowData:o})=>[e(i,{onClick:u=>l.addStar(o),size:"small",type:o.user_star?"warning":"",plain:"",round:""},{default:t(()=>[e(r,null,{default:t(()=>[e(X)]),_:1})]),_:2},1032,["onClick","type"])]),"cell(employee)":t(({rowData:o})=>[e(R,{underline:!1,onClick:u=>l.router.push({name:"userProfile",params:{user:o.employee.model.id}})},{default:t(()=>[e(Z,{size:25,src:o.employee.model.avatar.url},null,8,["src"]),d("b",Le,C(o.employee.model.name),1)]),_:2},1032,["onClick"])]),"cell(status)":t(({value:o})=>[e(y,{status:o,size:"small"},null,8,["status"])]),"cell(action)":t(({rowData:o,rowIndex:u})=>[d("div",null,[e(z,null,{default:t(()=>[e(i,{type:"primary",size:"small",title:"Archive",onClick:p=>l.doArchive(o,u)},{default:t(()=>[e(r,null,{default:t(()=>[e(v)]),_:1})]),_:2},1032,["onClick"]),e(i,{type:"primary",size:"small",onClick:p=>l.router.push({name:"task.show",params:{id:o.id}}),title:"Show"},{default:t(()=>[e(r,{size:20},{default:t(()=>[e(q)]),_:1})]),_:2},1032,["onClick"]),e(i,{type:"primary",size:"small",onClick:p=>o.showEdit=!0,title:"edit"},{default:t(()=>[e(r,{size:20},{default:t(()=>[e(G)]),_:1})]),_:2},1032,["onClick"]),e(i,{type:"danger",size:"small",onClick:p=>l.remove(o,u),title:"remove"},{default:t(()=>[e(r,null,{default:t(()=>[e(W)]),_:1})]),_:2},1032,["onClick"])]),_:2},1024),e(J,{show:o.showEdit,"onUpdate:show":p=>o.showEdit=p,item:o,employees:l.employees,categories:l.categories,onReplace:p=>l.replace(p,u)},null,8,["show","onUpdate:show","item","employees","categories","onReplace"])])]),_:1},8,["items","columns","sorting-order"])),e(Y,{links:l.links,onPage:l.fetchItems},null,8,["links","onPage"]),e(D,{show:l.showCreate,"onUpdate:show":n[6]||(n[6]=o=>l.showCreate=o),employees:l.employees,categories:l.categories,onPush:l.push},null,8,["show","employees","categories","onPush"])]),_:1},8,["busy"])}const Ze=ie(Pe,[["render",We],["__scopeId","data-v-06abb0ec"]]);export{Ze as default};
