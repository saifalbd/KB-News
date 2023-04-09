<template>
  <div class="task-show">
    <show-attachment
      :attachments="project.attachments"
      v-model:show="showAttachModal"
    ></show-attachment>
    <div class="top-part">
      <div>
        <h1>{{ project.title }}</h1>
        <div class="mt-3" v-if="project.attachments.length">
          <va-button
            preset="primary"
            icon="file_present"
            @click="showAttachModal = true"
            >Show Attachments</va-button
          >
        </div>
      </div>
      <slot>
        <h1>Right Info</h1>
      </slot>
    </div>
    <div class="description"><b>Description:</b> <span v-html="project.description"></span></div>
    <div class="comment-layout" id="commentLayout">
      <div class="row">
        <div class="flex sm12 mb-3">
          <slot name="tasks"></slot>
        </div>
        <div class="flex sm12 mb-3">
          <div class="comment-list" id="commentListRoot"></div>
          <!-- <comments :comments="comments" :taskId="task.id"></comments> -->
        </div>
        <div class="flex sm12">
          <va-inner-loading :loading="commentBusy">
            <va-form class="comment-form">
              <va-input
                v-model="comment"
                type="textarea"
                label="Comments"
                :min-rows="3"
                :max-rows="5"
                :rules="rs('comment', true)"
              />
              <div class="textarea-bottom">
                <div class="left-side">
                  <va-file-upload
                    class="small"
                    upload-button-text="Upload Attachment"
                    v-model="attachments"
                    dropzone
                  />
                </div>
                <div class="right">
                  <va-button
                    preset="secondary"
                    border-color="primary"
                    @click="addComment"
                  >
                    <va-icon name="comment"></va-icon>
                    <span class="ml-2">Add Comment</span>
                  </va-button>
                </div>
              </div>
            </va-form>
          </va-inner-loading>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AppLayout from "../../Layouts/app-layout.vue";
import PageTitleBox from "../../Components/PageTitleBox.vue";
import Comments from "./Comments.vue";
import ShowAttachment from "./showAttachment.vue";
import { ref, watch, onMounted } from "vue";
import { useToast } from "vuestic-ui";
import { rs } from "../../Plugins/Rule";
import { commentNotify, replyNofity } from "./modules";
import { mount } from "redom";
import { CommentItem } from "../../Components/Comments/index";
export default {
  props: {
    auth_id: {
      type: Number,
      required: true,
    },
    id: {
      type: [String, Number],
      required: true,
    },
    project: {
      type: Object,
      required: true,
    },
  },
  components: {
    AppLayout,
    PageTitleBox,
    Comments,
    ShowAttachment,
  },
  setup(props) {
    const { init } = useToast();
    const project = ref(props.project);
    const comments = ref([]);
    const showAttachModal = ref(false);
    const comment = ref("");
    const attachments = ref([]);
    const commentBusy = ref(false);

    // watch(props.prject, (o) => {
    //   project.value = o;
    // });

    const fetchComments = async (root) => {
      try {
        const url = route("api.comment.index", {
          model_type: "project",
          model_id: props.id,
        });
        const { data } = await axios.get(url);

        data.forEach((comment) => {
          let arg = {
            comment,
            model_type: "project",
            model_id: props.id,
            auth_id: props.auth_id,
          };
          let comDom = new CommentItem(arg);
          mount(root, comDom);
        });
      } catch (error) {
        console.error(error);
      }
    };

    const realTimeComment = (root) => {
      try {
        window.Echo.join(`comment.project.${props.id}`).listen(
          "NewComment",
          (comment) => {
            let arg = {
              comment,
              model_type: "project",
              model_id: props.id,
             auth_id: props.auth_id,
            };

            let comDom = new CommentItem(arg);
            mount(root, comDom);
            console.log("comment:" + comment.text);
          }
        );
      } catch (error) {
        console.log(error);
      }
    };
    onMounted(() => {
      let root = document.getElementById("commentListRoot");
      fetchComments(root);
      realTimeComment(root);
    });

    const addComment = async () => {
      let valid =  comment.value;
      if (!valid) return null;
      commentBusy.value = true;
      try {
        const url = route("api.comment.store");
        const formData = new FormData();
        formData.append("model_id", props.id);
        formData.append("model_type", "project");
        formData.append("text", comment.value);
        attachments.value.forEach((file, index) => {
          formData.append(`attachments[${index}]`, file);
        });
        await axios.post(url, formData);
        comment.value = "";
        init({
          message: "Succsess Fully Add Comment",
          color: "#432c50",
          closeable: true,
          duration: 2000,
        });
        form.value.reset();
      } catch (error) {
        console.error(error);
      }
      commentBusy.value = false;
    };
    return {
      rs,
      showAttachModal,
      commentBusy,
      project,
      addComment,
      comments,
      comment,
      attachments,
    };
  },
};
</script>

<style lang="scss" scoped>
.comment-form {
  padding: 5px;
  background-color: #ffc0cb4d;
  .textarea-bottom {
    display: grid;
    grid-template-columns: auto 200px;
    .right {
      display: flex;
      justify-content: center;
      align-items: center;
    }
  }
}
</style>
