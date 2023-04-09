<template>
  <app-layout :busy="busy">
    <div>
      <page-title-box title="Create Posts"> </page-title-box>
    </div>
    <el-card>
      <el-form label-position="top" :model="form" :rules="rules" ref="formEl">
        <el-form-item label="Post Title" prop="title">
          <el-input v-model="form.title" />
        </el-form-item>

        <el-form-item label="Categories" prop="categories">
          <el-select
            v-model="form.categories"
            multiple
            filterable
            placeholder="Select"
            style="width: 100%"
          >
            <el-option
              v-for="item in categoriesDropdowns"
              :key="item.id"
              :label="item.title"
              :value="item.id"
            />
          </el-select>
        </el-form-item>

        <el-form-item label="Tags">
          <el-select-v2
            v-model="form.tags"
            :options="tags"
            placeholder="Please Tags"
            style="width: 100%; margin-right: 16px; vertical-align: middle"
            allow-create
            filterable
            multiple
            clearable
          />
        </el-form-item>

        <el-form-item label="Sort Description" prop="Description">
          <el-input type="textarea" v-model="form.description" />
        </el-form-item>

        <el-row :gutter="24">
          <el-col :sm="24" style="min-height: 150px; margin-bottom: 50px">
            <QuillEditor
              theme="snow"
              :toolbar="[
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['image', 'blockquote', 'code-block'],
                [{ align: [] }],
              ]"
              contentType="html"
              v-model:content="form.body"
              placeholder="Description Html Contant"
            />
          </el-col>

          <el-col :sm="24">
         

            <div>
              <el-descriptions
                direction="horizontal"
                :column="2"
                size="large"
                border
              >
               <el-descriptions-item label="Show Author:">
                  <el-switch v-model="form.show_author" class="ml-2"
                  style="
                    --el-switch-on-color: #13ce66;
                    --el-switch-off-color: #ff4949;
                  "
                  inline-prompt
                   active-text="Show"
    inactive-text="Hide" />
                </el-descriptions-item>
                <el-descriptions-item label="Feature Post:">
                  <el-switch v-model="form.on_feature" class="ml-2"
                  style="
                    --el-switch-on-color: #13ce66;
                    --el-switch-off-color: #ff4949;
                  "
                  inline-prompt
                   active-text="Show"
    inactive-text="Hide"/>
                </el-descriptions-item>
                <el-descriptions-item label="Home Page Top:">
                  <el-switch v-model="form.on_home_top" class="ml-2"
                  style="
                    --el-switch-on-color: #13ce66;
                    --el-switch-off-color: #ff4949;
                  "
                  inline-prompt
                   active-text="Show"
    inactive-text="Hide" />
                </el-descriptions-item>
                 <el-descriptions-item label="Popular Post:">
                  <el-switch v-model="form.on_popular" class="ml-2"
                  style="
                    --el-switch-on-color: #13ce66;
                    --el-switch-off-color: #ff4949;
                  "
                  inline-prompt
                   active-text="Show"
    inactive-text="Hide"/>
                </el-descriptions-item>
                <el-descriptions-item label="Trending Post:">
                  <el-switch v-model="form.on_trending" class="ml-2"
                  style="
                    --el-switch-on-color: #13ce66;
                    --el-switch-off-color: #ff4949;
                  "
                  inline-prompt
                   active-text="Show"
    inactive-text="Hide" />
                </el-descriptions-item>
               
              </el-descriptions>
            </div>
          </el-col>

          <el-col :sm="12" :md="6" v-for="(src, i) in images" :key="i">
            <el-card shadow="never">
              <el-image :src="src"></el-image>
            </el-card>
          </el-col>
          <el-col :sm="24">
            <div class="upload-box">
              <el-card class="box-card" shadow="never">
                <input type="file" @change="fileChange" multiple />
                <div>
                  <div><b>Upload Images</b></div>
                  <el-icon size="100"><UploadFilled /></el-icon>
                </div>
              </el-card>
            </div>
          </el-col>
          <el-col :sm="24" style="text-align: center; padding-top: 50px">
            <el-button size="large" type="primary" @click="onSubmit(formEl)"
              >
                <el-icon>
                <upload-filled/>
              </el-icon>
              <span>Create Post</span>
              </el-button
            >
          </el-col>
        </el-row>
      </el-form>
    </el-card>
  </app-layout>
</template>

<script>
import { reactive, ref } from "vue";
import AppLayout from "../../Layouts/app-layout.vue";
import PageTitleBox from "../../Components/PageTitleBox.vue";
import { useRouter } from "vue-router";
import {
  Delete,
  Download,
  Plus,
  ZoomIn,
  UploadFilled,
} from "@element-plus/icons-vue";
import { dropdowns } from "../../Plugins/utility";

export default {
  components: {
    AppLayout,
    PageTitleBox,
    Delete,
    Download,
    Plus,
    ZoomIn,
    UploadFilled,
  },
  setup() {
    const busy = ref(false);
    const categoriesDropdowns = ref([]);
    const tags = ref([]);
    const router = useRouter();
    const go = (to) => {
      router.push(to);
    };

    const formEl = ref();

    const form = reactive({
      on_feature: false,
      on_home_top: false,
      on_popular: false,
      on_trending: false,
      show_author:false,
      categories: [],
      tags: [],
      attachments: [],
      title: "",
      description: "",
      body: "",
    });
    const rules = reactive({
      categories: [
        {
          required: true,
          message: "Categories Must be Required",
          trigger: "change",
        },
      ],
      title: [
        {
          required: true,
          message: "Title Must be Required",
          trigger: "change",
        },
      ],
    });

    const images = ref([]);

    dropdowns("categories", (data) => {
      categoriesDropdowns.value = data;
    });

    dropdowns("tags", (data) => {
      tags.value = data.map((e) => ({ value: e.title, label: e.title }));
    });

    const fileChange = (event) => {
      const files = event.target.files;
      form.attachments = files;
      images.value = [];
      Array.prototype.forEach.call(files, (file) => {
        let reader = new FileReader();

        reader.onload = () => {
          let result = reader.result;
          images.value.push(result);
        };

        reader.readAsDataURL(file);
      });
    };

    const onSubmit = async (formEl) => {
      await formEl.validate(async (valid, fields) => {
        if (valid) {
          busy.value = true;
          try {
            const f = new FormData();
            f.append("title", form.title);
            f.append("description", form.description);
            f.append("body", form.body);
            f.append("on_feature", form.on_feature ? 1 : 0),
              f.append("on_home_top", form.on_home_top ? 1 : 0),
              f.append("on_popular", form.on_popular ? 1 : 0),
              f.append("on_trending", form.on_trending ? 1 : 0),
              form.tags.forEach((c, i) => {
                f.append(`tags[${i}]`, c);
              });
            form.categories.forEach((c, i) => {
              f.append(`categories[${i}]`, c);
            });

            Array.prototype.forEach.call(form.attachments, (a, i) => {
              f.append(`attachments[${i}]`, a);
            });

            const { data } = await axios.post(route("api.post.store"), f);
            go({ name: "post.index" });
          } catch (error) {
            console.error(error);
          }
          busy.value = false;
        }
      });
    };

    return {
      busy,
      go,

      categoriesDropdowns,
      tags,
      formEl,
      images,
      fileChange,
      onSubmit,
      form,
      rules,
    };
  },
};
</script>

<style lang="scss" scoped>
.upload-box {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 50px;
}
.box-card {
  position: relative;
  min-width: 300px;
  display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  .el-card__body {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: 100%;
    background: red;
    input {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 1;
      opacity: 0;
    }
  }
}
</style>