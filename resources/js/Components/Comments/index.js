import { el, svg, mount, unmount } from "redom";
import { icon } from "../../Plugins/icon";
import { LikeButton } from "./LikeButton";
import { ReplayModal } from "./replay";
export class CommentItem {
    constructor(arg) {
        try {
            const { comment, model_type, model_id, auth_id } = arg;
            this.comment = comment;
            if (!model_type) throw new Error("model_type argument are missing");
            if (!model_id) throw new Error("model_id argument are missing");
            if (!auth_id) throw new Error("auth_id argument are missing");
            this.model_type = model_type;
            this.model_id = model_id;
            this.auth_id = auth_id;

            this.likeBtn = new LikeButton(comment, auth_id);

            this.childDom = this.childrenDom(comment);
            this.el = this.commentItem(comment);
        } catch (error) {
            console.error(error);
        }
    }

 
    commentItem(comment) {
        return el(".comment-list-item", {}, [
            
            this.innerBox(comment),
            this.actionBar(comment),
            this.childDom,
        ]);
    }

    toggole(show) {
        if (show) {
            this.el.classList.remove("none");
        } else {
            this.el.classList.add("none");
        }
    }

    realTimeReplyUpdate(comment) {
        try {
            window.Echo.join(`comment.reply.${comment.id}`).listen(
                "NewComment",
                (e) => {
                    let arg = {
                        comment: e,
                        model_type: this.model_type,
                        model_id: this.model_id,
                        auth_id: this.auth_id,
                    };

                    let dom = new CommentItem(
                       arg
                    );
                
                    mount(this.childDom, dom);
                }
            );

            if (comment.user.id != this.auth_id) {
                window.Echo.join(`commentRemove.${comment.id}`).listen(
                    "RemoveComment",
                    (comment_id) => {
                        this.toggole(false);
                    }
                );
            }
        } catch (error) {
            console.log(error);
        }
    }

    onmount() {
        this.comment.replayes.forEach((rep) => {
            let arg = {
                comment: rep,
                model_type: this.model_type,
                model_id: this.model_id,
                auth_id: this.auth_id,
            };

            let dom = new CommentItem(arg);
            mount(this.childDom, dom);
        });

        this.realTimeReplyUpdate(this.comment);
    }

    showReacts(comment){
        return el('div',{class:'view-react-button'},[
           el('span',[
            icon.create(icon.like),
           icon.create(icon.disLike)
           ]),
           el('b',comment.reactCount)
        ])
    }

    innerBox(comment) {
        return el(".inner", {}, [
            el("div", {}, [this.avaterBox(comment)]),
            el(".text-box", {}, [
                el("p", {}, [
                  el('span',{
                    style:`display: flex;
                    justify-content: space-between;`
                  },[
                    el("b", comment.user.name),
                    this.showReacts(comment)
                  ]),
                    el("small", comment.atNow),
                ]),
                el("p", comment.text),
            ]),
        ]);
    }

    childrenDom() {
        return el(".comment-list", {}, []);
    }

    replyBtnEl(comment) {
        let replayBtn = el("button", { class: "replay-btn" }, [
            icon.create(icon.reply),
        ]);

        replayBtn.addEventListener("click", () => {
            let commentLayout = document.getElementById("commentLayout");
            let arg = {
                parentComment: comment,
                model_type: this.model_type,
                model_id: this.model_id,
            };

            let replayDom = new ReplayModal(arg);
            mount(commentLayout, replayDom);
        });

        return replayBtn;
    }

    removeBtnEl(comment) {
        let removeBtn = el("span");

        if (comment.user.id == this.auth_id) {
            removeBtn = el("button", { class: "remove-btn" }, [
                icon.create(icon.remove),
            ]);
            removeBtn.addEventListener("click", () => {
                this.toggole(false);
                this.remove(comment);
            });
        }
        return removeBtn;
    }

    actionBar(comment) {
        return el(".action-bar", {}, [
            el(".action-bar-inner", {}, [
                el(".action-list", {}, [
                    this.likeBtn,
                    this.replyBtnEl(comment),
                    this.removeBtnEl(comment),
                ]),
                this.attachBtn(comment),
            ]),
        ]);
    }

    attachBtn(comment) {
        if (comment.attachments?.length) {
            return el("div", {}, [
                el(
                    "button",
                    {
                        class: "show-attach-btn",
                    },
                    [icon.create(icon.attach), "Show Attach"]
                ),
            ]);
        } else {
            return el("div");
        }
    }

    avaterBox(comment) {
        let avatar = comment.user.avatar;

        return avatar?el(
            ".va-avatar",
            {
                "aria-hidden": false,
                "aria-live": "polite",
                style: `color: rgb(255, 255, 255); 
            background-color: rgb(21, 141, 227); 
            font-size: 1rem; 
            width: 48px; 
            min-width: 48px; 
            height: 48px;`,
            },
            [
                el("img", {
                    src: avatar.url,
                }),
            ]
        ):el('div');
    }

    //functions

    async remove(comment) {
        try {
            const url = route("api.comment.destroy", { comment: comment.id });
            await axios.delete(url);
        } catch (error) {
            console.error(error);
        }
    }
}
