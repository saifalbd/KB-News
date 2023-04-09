<template>
  <app-layout :busy="busy">
    <page-title-box title="Show Post"> </page-title-box>
    <div class="show-post" v-if="post">
      <el-row>
        <el-col :sm="24">
          <h3 class="mb-2">{{ post.title }}</h3>
        </el-col>
        <el-col :sm="24">
          <el-descriptions
            direction="horizontal"
            :column="2"
            size="small"
            border
          >
            <el-descriptions-item
              label="Author:"
              size="small"
              type="danger"
              plain
            >
              <el-link
                @click="
                  go({
                    name: 'userProfile',
                    params: { user: post.author.id },
                  })
                "
              >
                <el-avatar :size="25" :src="post.author.avatar.sm_url" />
                <span style="margin-left: 5px">{{ post.author.name }}</span>
              </el-link>
            </el-descriptions-item>

            <!-- <el-descriptions-item label="Delete:"
                ><el-button
                  size="small"
                  type="danger"
                  plain
                  @click="remove(post, index)"
                >
                  <el-icon>
                    <delete />
                  </el-icon> </el-button
              ></el-descriptions-item>
             -->
            <el-descriptions-item label="Edit:"
              ><el-button
                size="small"
                type="info"
                plain
                @click="
                  go({
                    name: 'post.edit',
                    params: { id: post.id },
                  })
                "
              >
                <el-icon>
                  <edit-pen />
                </el-icon> </el-button
            ></el-descriptions-item>
            <el-descriptions-item label="Published:">
              <el-switch
                v-model="post.publish"
                class="ml-2"
                style="
                  --el-switch-on-color: #13ce66;
                  --el-switch-off-color: #ff4949;
                "
                inline-prompt
                active-text="Yes"
                inactive-text="No"
                @change="changeConfig($event, 'publish', post.id)"
              />
            </el-descriptions-item>

            <el-descriptions-item label="Show Author:">
              <el-switch
                v-model="post.show_author"
                class="ml-2"
                style="
                  --el-switch-on-color: #13ce66;
                  --el-switch-off-color: #ff4949;
                "
                inline-prompt
                active-text="Show"
                inactive-text="Hide"
                @change="changeConfig($event, 'show_author', post.id)"
              />
            </el-descriptions-item>
            <el-descriptions-item label="Home Page Top:">
              <el-switch
                v-model="post.on_home_top"
                class="ml-2"
                style="
                  --el-switch-on-color: #13ce66;
                  --el-switch-off-color: #ff4949;
                "
                inline-prompt
                active-text="Show"
                inactive-text="Hide"
                @change="changeConfig($event, 'on_home_top', post.id)"
              />
            </el-descriptions-item>
            <el-descriptions-item label="Feature Post:">
              <el-switch
                v-model="post.on_feature"
                class="ml-2"
                style="
                  --el-switch-on-color: #13ce66;
                  --el-switch-off-color: #ff4949;
                "
                inline-prompt
                active-text="Show"
                inactive-text="Hide"
                @change="changeConfig($event, 'on_feature', post.id)"
              />
            </el-descriptions-item>
            <el-descriptions-item label="Trending Post:">
              <el-switch
                v-model="post.on_trending"
                class="ml-2"
                style="
                  --el-switch-on-color: #13ce66;
                  --el-switch-off-color: #ff4949;
                "
                inline-prompt
                active-text="Show"
                inactive-text="Hide"
                @change="changeConfig($event, 'on_trending', post.id)"
              />
            </el-descriptions-item>
            <el-descriptions-item label="Popular Post:">
              <el-switch
                v-model="post.on_popular"
                class="ml-2"
                style="
                  --el-switch-on-color: #13ce66;
                  --el-switch-off-color: #ff4949;
                "
                inline-prompt
                active-text="Show"
                inactive-text="Hide"
                @change="changeConfig($event, 'on_popular', post.id)"
              />
            </el-descriptions-item>
            <el-descriptions-item>
              <template #label>
                <div>Intro</div>
              </template>
              <p>
                <b>{{ post.description }}</b>
              </p>
            </el-descriptions-item>
          </el-descriptions>
        </el-col>
        <el-col>
          
          <el-row :gutter="5">
            <el-col v-for="(attach, i) in post.attachments" :key="i" :sm="24" :md="6">
              <el-card  :body-style="{ padding: '0px' }">
                <template #header>
                  <div class="card-header">
                    <span>Attachment</span>
                    <el-switch
                v-model="attach.is_avatar"
                class="ml-2"
                style="
                  --el-switch-on-color: #13ce66;
                  --el-switch-off-color: #ff4949;
                "
                inline-prompt
                inactive-text="Use On Avatar"
                active-text="Avatar"
                @change="changeAvatar($event,attach,i)"
              />
                  </div>
                </template>
                <img
                  :src="attach.md_url"
                  class="image"
                />
              </el-card>
            </el-col>
          </el-row>
        </el-col>
        <el-col :sm="24">
          <div class="mt-3" v-html="post.body"></div>
        </el-col>
      </el-row>
    </div>
  </app-layout>
</template>

<script>
import { ref } from "vue";
import AppLayout from "../../Layouts/app-layout.vue";
import PageTitleBox from "../../Components/PageTitleBox.vue";
import { useRouter } from "vue-router";
import { changeConfig } from "./api";
import { Delete, MoreFilled, EditPen } from "@element-plus/icons-vue";
import { attempt } from 'lodash';

export default {
  props: {
    id: {
      type: [Number, String],
      required: true,
    },
  },
  components: {
    AppLayout,
    PageTitleBox,
    EditPen,
  },
  setup(props) {
    const busy = ref(false);
    const post = ref(null);
    const router = useRouter();

    const go = (to) => {
      router.push(to);
    };

    const show = async () => {
      busy.value = true;
      try {
        const url = route("api.post.show", { post: props.id });
        const { data } = await axios.get(url);
        data.attachments = data.attachments.map(attach=>{
          attach.is_avatar = data.avatar_id==attach.id;
          return attach;
        })
        post.value = data;
      } catch (error) {
        console.error(error);
      }
      busy.value = false;
    };
    show();

    const changeAvatar =(bool,attach,i)=>{
      let list = post.value.attachments
      let length = list.length;
      let next = ()=>{
        if(i == length-1){
          return list[0]
        }else{
          return list[i+1]
        }
      }
      let change = (id)=>axios.put(route('api.post.changeAvatar',{post:props.id}),{id})
      if(!bool){
        let n = next();
        list.forEach((e,index) => {
            e.is_avatar = e.id == n.id
        });
        change(n.id)
      }else{
           list.forEach((e,index) => {
            e.is_avatar = e.id == attach.id
        });
         change(attach.id)
      }
    }

    return { go, changeAvatar, busy, post };
  },
};
</script>

<style lang="scss" scoped></style>
