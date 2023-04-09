<template>
  <div class="task-show">
    <show-attachment
      :attachments="task.attachments"
      v-model:show="showAttachModal"
    ></show-attachment>
    <div class="top-part">
      <div>
        <h1>{{ task.title }}</h1>
        <div class="mt-3" v-if="task.attachments.length">
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
    <div class="description">
      <b>Description:</b> <span v-html="task.description"></span>
    </div>
    <div class="comment-layout" id="commentLayout">
      <div class="row">
        <div class="flex sm12 mb-3">
          <div class="comment-list" id="commentListRoot"></div>
          <!-- <comments :comments="comments" :taskId="task.id"></comments> -->
        </div>
        <div class="flex sm12">
          <el-card v-loading="commentBusy">
            <el-form label-position="top">
              <el-form-item label="Comment" prop="desc">
                <el-input type="textarea" v-model="comment" />
              </el-form-item>

              <el-row :gutter="24">
                <el-col :sm="18" :md="18" style="text-align:center;">
                  <el-row :gutter="24">
                    <el-col :span="24">
                      <div>
                        <input type="file"  multiple @change="fileChange">
                      </div>
                    </el-col>
                    <el-col :span="24" v-for="(f,i) in attachments" :key="i">
                      {{f.name}}
                    </el-col>
                  </el-row>
                </el-col>
                <el-col :sm="6" :md="6" style="text-align:right;">
                  <el-button type="primary" @click="addComment">
                    <el-icon>
                      <arrow-right-bold/>
                    </el-icon>
                    <span>Send</span>
                  </el-button>
                </el-col>
              </el-row>
            </el-form>
          </el-card>
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
import { mount } from "redom";
import { CommentItem } from "../../Components/Comments/index";
import {ArrowRightBold} from '@element-plus/icons-vue';
export default {
  props: {
    auth_id: {
      type: [String, Number],
      required: true,
    },
    id: {
      type: [String, Number],
      required: true,
    },
    task: {
      type: Object,
      required: true,
    },
  },
  components: {
    AppLayout,
    PageTitleBox,
    Comments,
    ShowAttachment,
    ArrowRightBold
  },
  setup(props) {
    const { init } = useToast();
    const form = ref(null);
    const task = ref(props.task);
    const comments = ref([]);
    const showAttachModal = ref(false);
    const comment = ref("");
    const attachments = ref([]);
    const commentBusy = ref(false);
   

    watch(props.task, (o) => {
      task.value = o;
    });

    const fetchComments = async (root) => {
      try {
        const url = route("api.comment.index", {
          model_type: "task",
          model_id: props.id,
        });
        const { data } = await axios.get(url);

        data.forEach((comment) => {
          let arg = {
            comment,
            model_type: "task",
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
        window.Echo.join(`comment.task.${props.id}`).listen(
          "NewComment",
          (comment) => {
            let arg = {
              comment,
              model_type: "task",
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
      let valid = comment.value;
      if (!valid) return null;
      commentBusy.value = true;
      try {
        const url = route("api.comment.store");
        const formData = new FormData();
        formData.append("model_id", props.id);
        formData.append("model_type", "task");
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

    const fileChange = (event)=>{
      let files = event.target.files;
      if(files && files.length){
        attachments.value = files;
      }else{
        attachments.value = []
      }

    }
   
    return {
      rs,
      showAttachModal,
      commentBusy,
      task,
      addComment,
      comments,
      comment,
      attachments,
      fileChange
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
