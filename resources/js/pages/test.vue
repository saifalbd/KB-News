<template>
  <div class="comment-layout" id="commentLayout">
    <div class="row">
      <div class="flex sm12 mb-3">
        <div class="comment-list" id="commentListRoot"></div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive,onMounted } from 'vue';
import { el, mount } from "redom";
import {CommentItem} from '../Components/Comments/index'
import {ReplayModal} from '../Components/Comments/replay'
export default {
  setup() {
    const comments = reactive([{"id":98,"text":"quip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.","parent_id":null,"likeCount":5,"atNow":"16 hours ago","user":{"id":1,"name":"Saiful islam"},"attachments":[],"replayes":[{"id":103,"text":"new reply","parent_id":98,"likeCount":5,"atNow":"16 hours ago","user":{"id":1,"name":"Saiful islam"},"attachments":[],"replayes":[]}]},{"id":99,"text":"ssss","parent_id":null,"likeCount":5,"atNow":"16 hours ago","user":{"id":1,"name":"Saiful islam"},"attachments":[],"replayes":[{"id":101,"text":"sss","parent_id":99,"likeCount":5,"atNow":"16 hours ago","user":{"id":1,"name":"Saiful islam"},"attachments":[],"replayes":[]}]},{"id":100,"text":"ssss","parent_id":null,"likeCount":5,"atNow":"16 hours ago","user":{"id":1,"name":"Saiful islam"},"attachments":[],"replayes":[]}])
   onMounted(()=>{
    let root = document.getElementById("commentListRoot");
    let commentLayout = document.getElementById('commentLayout')
    comments.forEach(comment=>{
      let arg = {
            comment,
            model_type: "task",
            model_id: 1,
            auth_id: 1,
          };

        let comDom = new CommentItem(arg);
        mount(root,comDom)
    });
    // let replaydom = new ReplayModal();
    // mount(commentLayout,replaydom)
   })
   return {comments};
  },
};
</script>

<style lang="scss" scoped>
</style>