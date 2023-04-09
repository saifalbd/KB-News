import { el, svg, mount, unmount } from "redom";
import { icon } from "../../Plugins/icon";
export class LikeButton {
    constructor(comment, auth_id) {
      
        this.comment = comment;
        this.auth_id = auth_id;
        this.isLiked = comment.reacts.findIndex((e) => e.id == auth_id) > -1;
        this.popReactDom =  this.reactPopUpBox();
        this.el = this.button();
    }

 
  
    reactPopUpBox(){
        let like = el('div',{},[  el('div',{},[icon.create(icon.like,24)])]);
        like.addEventListener('click',()=> this.doLike(this.comment,'like'));
        let disLike = el('div',{},[ el('div',{},[icon.create(icon.disLike,24)])]);
        disLike.addEventListener('click',()=> this.doLike(this.comment,'disLike'));
        let love = el('div',{},[ el('div',{},[icon.create(icon.love,24)])]);
        love.addEventListener('click',()=> this.doLike(this.comment,'love'));
        let sad = el('div',{},[el('div',{},[icon.create(icon.sad,24)])])
        sad.addEventListener('click',()=> this.doLike(this.comment,'sad'));
        return el('.like-pop-up-box',{},[
            el('.like-pop-up',{},[
                like,
                disLike,
                love,
                sad  
              ])
        ])
    }


    updateLike(){
       
        if(this.isLiked){
            
               this.el.classList.remove("active");
               this.isLiked = false;
              
        
        }else{
          
              this.el.classList.add("active");
              this.isLiked = true;
        }
    }


    button() {
        let btn =   el("button", { class: "like-btn" }, [
            icon.create(icon.like),
     
        ])

        let dom =el('div',{class:'like-box'},[
          this.popReactDom,
           btn
          
        ]);

        if (this.comment.reactCount) {
            dom.classList.add("show-count");
        }

        if (this.isLiked) {
            dom.classList.add("active");
        }

        btn.addEventListener("click", () => {
            this.doLike(this.comment,'like');

        });

        return dom;
    }

    async doLike(comment,prop) {
        try {
            this.updateLike()
            const url = route("api.comment.toggleLike", { comment: comment.id });
            await axios.post(url, {prop});

        } catch (error) {
            console.error(error);
        }
    }
}
