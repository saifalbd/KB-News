<template>
  <app-layout :busy="busy">
    <div>
      <page-title-box title="Posts">
        <create-button
          title="Add Posts"
          @click="go({ name: 'post.create' })"
        ></create-button>
      </page-title-box>
    </div>

    <el-row>
      <el-col :sm="24" :md="6" v-for="post in items" :key="post.id">
        <el-card class="card-box">
          <div class="block" v-if="post.attachments.length">
            <el-image
              :src="post.attachments[0].url"
              :zoom-rate="1.2"
              :preview-src-list="post.attachments.map((e) => e.url)"
              :initial-index="0"
              fit="cover"
            />
          </div>

          <div style="padding: 14px">
            <el-descriptions
              :title="post.title"
              direction="horizontal"
              :column="1"
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

              <el-descriptions-item label="Delete:"
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
              <el-descriptions-item label="View:"
                ><el-button
                  size="small"
                  type="info"
                  plain
                  @click="go({ name: 'post.show', params: { id: post.id } })"
                >
                  <el-icon>
                    <more-filled />
                  </el-icon> </el-button
              ></el-descriptions-item>
                 <el-descriptions-item label="Edit:"
                ><el-button
                  size="small"
                  type="info"
                  plain
                  @click="go({ name: 'post.edit', params: { id: post.id } })"
                >
                  <el-icon>
                    <more-filled />
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
                  @change="changeConfig($event,'publish',post.id)"
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
                  @change="changeConfig($event,'show_author',post.id)"
                />
              </el-descriptions-item>
              <el-descriptions-item
                label="Home Page Top:"
              >
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
                    @change="changeConfig($event,'on_home_top',post.id)"
                />
              </el-descriptions-item>
              <el-descriptions-item
                label="Feature Post:"
              >
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
                    @change="changeConfig($event,'on_feature',post.id)"
                />
              </el-descriptions-item>
              <el-descriptions-item
                label="Trending Post:"
              >
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
                    @change="changeConfig($event,'on_trending',post.id)"
                />
              </el-descriptions-item>
              <el-descriptions-item
                label="Popular Post:"
              >
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
                    @change="changeConfig($event,'on_popular',post.id)"
                />
              </el-descriptions-item>
            </el-descriptions>
          </div>
        </el-card>
        <config-dialog
          :title="post.title"
          :id="post.id"
          v-model:show="post.showConfig"
        ></config-dialog>
      </el-col>
    </el-row>
  </app-layout>
</template>

<script>
import { ref } from "vue";
import AppLayout from "../../Layouts/app-layout.vue";
import PageTitleBox from "../../Components/PageTitleBox.vue";
import CreateButton from "../../Components/CreateButton.vue";
import { Delete, MoreFilled,EditPen } from "@element-plus/icons-vue";
import { useRouter } from "vue-router";
import { confirm, removeSuccess } from "../../Plugins/utility";
import ConfigDialog from "./configDialog.vue";
import {changeConfig} from './api'
export default {
  components: {
    MoreFilled,
    Delete,
    EditPen,
    AppLayout,
    PageTitleBox,
    CreateButton,
    ConfigDialog,
  },
  setup() {
    const busy = ref(false);
    const router = useRouter();
    const items = ref([]);
    const go = (to) => {
      router.push(to);
    };

    const fetchItems = async () => {
      try {
        busy.value = true;
        const url = route("api.post.index");
        const { data } = await axios.get(url);
        console.log(data);
        items.value = data.map((item) => {
          item.showConfig = false;
          return item;
        });
      } catch (error) {
        console.error(error);
      }
      busy.value = false;
    };

    fetchItems();

    const remove = async (post, index) => {
      const is = await confirm(post, "Post", "title");
      if (!is) return null;

      try {
        const url = route("api.post.destroy", { post: post.id });
        await axios.delete(url);
        items.value.splice(index, 1);
        removeSuccess(toast);
      } catch (error) {
        console.log(error);
      }
    };

    return {
      items,
      remove,
      busy,
      go,
      changeConfig
    };
  },
};
</script>

<style lang="scss" scoped>
.card-box {
  margin: 5px;
}
</style>