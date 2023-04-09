export const commentNotify = (comments,task_id)=>{
    try {
    window.Echo.join(`comment.task.${task_id}`).listen("NewComment", (e) => {
      comments.value.push(
        addProtos(e, { showReplay: false, showAttachModal: false })
      );
      console.log('comment:'+e.text)
    });
  } catch (error) {
    console.log(error);
  }
  }

 export const replyNofity = (comment)=>{
    try {
        window.Echo.join(`comment.reply.${comment.id}`).listen("NewComment", (e) => {
         let item =  addProtos(e, { showReplay: false, showAttachModal: false })
           comment.replayes.push(item);
           console.log('reply:'+e.text)
        });
      } catch (error) {
        console.log(error);
      }

  }