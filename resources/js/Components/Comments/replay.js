import { trim } from "lodash";
import { el, svg, mount,unmount } from "redom";
import { icon } from "../../Plugins/icon";

class ReplayCard {
    constructor(arg){

        
    const {parentComment,model_type,model_id,parentDom}  =arg
      try {
        if(!parentComment) throw new Error('Parent Comment argument are missing');
        if(!model_type) throw new Error('model_type argument are missing');
        if(!model_id) throw new Error('model_id argument are missing');
        this.model_type = model_type;
        this.model_id = model_id;
        this.parentComment = parentComment;
        this.parentDom = parentDom;
        this.fileInputDom = this.fileUploadInput();
        this.files = []
        this.fileListDom = null;
        this.attachmentNode = this.fileUploadField();
        this.el = this.card();
        this.attachD =
            "M4 19V7H16V19C16 20.1 15.1 21 14 21H6C4.9 21 4 20.1 4 19M6 9V19H14V9H6M13.5 4H17V6H3V4H6.5L7.5 3H12.5L13.5 4M19 17V15H21V17H19M19 13V7H21V13H19Z";
        
      } catch (error) {
        console.error(error)
      }
    }

 
   async asyncPost(text,files){
    

    try {

        const formData = new FormData();
        const url = route("api.comment.store");
      formData.append("model_id", this.model_id);
      formData.append("model_type", this.model_type);
      formData.append("parent_id", this.parentComment.id);
      formData.append("text", text);
      files.forEach((file, index) => {
        formData.append(`attachments[${index}]`, file);
      });
       await axios.post(url, formData);
       console.log({text,files})
        
    } catch (error) {
       console.error(error) 
    }

    }
    card() {
       
        return el("div", {class:'reply-card animate__swing'}, [
            el(".top-part", {}, [el("h2", "Title")]),
            this.middlePart(),
            this.bottomPart(),
        ]);
    }

    middlePart() {
        let input = el("textarea");
        input.addEventListener("focus", () => {
            this.el.classList.add("show-bottom");
            input.classList.remove('is-invalid')
        });
        let sendBox = el("button", {}, "Send");
        sendBox.addEventListener('click',()=>{
            let text = trim(input.value);
            if(!text){
                input.classList.add('is-invalid');
                return null;
            }
            let files = this.files.map(f=>f.file);
            this.asyncPost(text,files);
          this.parentDom.removeModal();
           

        });

        return el(".middle-part", {}, [input, sendBox]);
    }

    
    fileItem(item,index){

        let removeButton = el(
            "button",
            {
                class: "va-button va-button--normal va-button--icon-only",
                type: "button",
                "aria-disabled": false,
                "aria-label": "remove file",
                style: "background:red;",
            },
            [
                el(
                    "span",
                    {
                        class: "va-button__content",
                    },
                    [
                       
                        el("i", {
                            class: "va-icon material-icons va-button__left-icon",
                            "aria-hidden": true,
                            style: "color: rgb(255, 255, 255); font-size: 24px; height: 24px; line-height: 24px;",
                        },'clear'),
                    ]
                ),
            ]
        );

        

 
        let element = el(
            "div",
            {
                class: "va-list-item va-file-upload-list-item",
                role: "listitem",
                tabindex:index,
            },
            [
                el("div", { class: "va-list-item__inner" }, [
                    el(
                        "div",
                        {
                            class: "va-list-item-section va-list-item-section--main",
                        },
                        [
                            el(
                                "div",
                                {
                                    class: "va-file-upload-list-item__content",
                                },
                                [
                                    el(
                                        ".va-file-upload-list-item__name",
                                        item.name
                                    ),
                                    el(
                                        ".va-file-upload-list-item__size",
                                        `${item.size} KB`
                                    ),
                                    removeButton
                                ]
                            ),
                        ]
                    ),
                ]),
            ]
        )

        removeButton.addEventListener('click',()=>{
            let findIndex = this.files.findIndex(e=>e.index == index);
            if(findIndex>-1){
                this.files.splice(findIndex,1)
            }
           unmount( this.fileListDom,element);
           if(!this.files.length){
            unmount(this.attachmentNode,this.fileListDom)
           }

        })

        return element;
    }
    fileList(items) {
        return el(
            "div",
            { class: "va-list va-file-upload-list va-file-upload-list--list" },
            items.map((item,index)=>this.fileItem(item,index))
        );
    }
    fileUploadInput(){
        let input = el("input", {
            style: {
                zIndex: 2,
            },
            type: "file",
            class: "va-file-upload__field__input",
            tabindex: "-1",
            "aria-hidden": true,
            accept: true,
            multiple: true,
        });

        input.addEventListener('change',(event)=>{
            let target  = event.target;
            let files = target.files;
            this.files = Array.prototype.map.call(files,(file,index)=>{
                return {
                    index,
                    file
                }
            });
            let length = files.length;
            if(length){
                let items = Array.prototype.map.call(files,(file)=>{
                    const {name,size,type} = file;
                    return {name,size,type}
                })
               this.fileListDom =this.fileList(items)
                mount(this.attachmentNode,this.fileListDom)
                
            }else{
                if(this.fileListDom){
                    unmount(this.attachmentNode,this.fileListDom)
                }
            }
         
        })

        return input;
    }
    fileUploadField() {
        return el(".va-file-upload", {}, [
            el(".va-file-upload__field", {}, [
                el(
                    "button",
                    {
                        class: `va-button va-button--small va-button--bordered va-file-upload__field__button`,
                        style: `border-color: rgb(21, 78, 193); color: rgb(21, 78, 193); background: transparent; --1b8929fa:#154EC1; --db0b68f0:0; --73abd112:transparent; --5fe12b1f:0;`,
                    },
                    [
                        el("span", { class: "va-button__content" }, [
                           icon.create(icon.attach,18),
                            el("b", "attachment"),
                        ]),
                    ]
                ),
            ]),
            this.fileInputDom,
           
        ]);
    }
    bottomPart() {
        return el(".bottom-part", {}, [
            el(".inner", {}, [this.attachmentNode]),
        ]);
    }


    onmount(){
        // this.el.classList.add('')
    }

}

export class ReplayModal {

    constructor(arg){

        const {parentComment,model_type,model_id}  =arg

        try {
            if(!parentComment) throw new Error('Parent Comment argument are missing');
            if(!model_type) throw new Error('model_type argument are missing');
            if(!model_id) throw new Error('model_id argument are missing');
            this.model_type = model_type;
            this.model_id = model_id;
            this.parentComment = parentComment;
            this.el = this.modal();
            
        } catch (error) {
            console.error(error)
        }
    
    }


    removeModal(){
        let root = document.getElementById("commentLayout");
        unmount(root,this.el)
        
    }
    modal() {
        let overly = el('.reply-overly');
        overly.addEventListener('click',()=>{
            this.removeModal()
        })
        return el("div", { class: "reply-modal",id:'replyModal' }, [
            overly,
            
        ]);
    }


    onmount() {
        let arg = {
            parentComment:this.parentComment,
            model_type:this.model_type,
            model_id:this.model_id,
            parentDom:this
        }
       let card = new ReplayCard(arg);
       mount(this.el,card)
    }

    
   
}
