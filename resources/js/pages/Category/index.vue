<template>
  <app-layout :busy="busy">
    <div>
      <page-title-box title="Categories">
        <create-button
          title="Add Category"
          @click="showCreate = true"
        ></create-button>
      </page-title-box>
    </div>

    <div class="row mt-4">
      <div class="flex md6">
        <div class="item">
          <va-select
            class="flex mb-2 md6"
            label="Per Page"
            v-model="perPage"
            :options="[10, 20, 30, 40, 50]"
          />
        </div>
      </div>

      <div class="flex lg6">
        <div class="item right">
          <va-input class="flex mb-2 md6" label="Search">
            <template #prepend>
              <va-icon class="material-icons">search</va-icon>
            </template>
          </va-input>
        </div>
      </div>
    </div>

    <el-table :data="items" border style="width: 100%">
      <el-table-column prop="id" label="serial" />
      <el-table-column prop="title" label="Title" />
      <el-table-column prop="slug" label="Slug" />

      <el-table-column prop="is_popular" label="Popular">
        <template #default="{ row }">
          <el-switch
            v-model="row.is_popular"
            @change="popularChange($event, row.id)"
          />
        </template>
      </el-table-column>

      <el-table-column fixed="right" label="Operations" width="120">
        <template #default="{ row, $index }">
          <remove-edit-button
            @editClick="row.showEdit = true"
            @removeClick="remove(row, $index)"
          >
            <edit
              v-model:show="row.showEdit"
              :item="row"
              @replace="replace($event, $index)"
            ></edit>
          </remove-edit-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination :links="links" @page="fetchItems"></pagination>
    <create v-model:show="showCreate" @push="push"></create>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/app-layout.vue";
import PageTitleBox from "../../Components/PageTitleBox.vue";
import Pagination from "../../Components/Pagination.vue";
import Create from "./Create.vue";
import Edit from "./Edit.vue";
import { ref } from "vue";
import CreateButton from "../../Components/CreateButton.vue";
import { confirm, removeSuccess } from "../../Plugins/utility";
import RemoveEditButton from "../../Components/RemoveEditButton.vue";
import { useToast } from "vuestic-ui";
export default {
  components: {
    AppLayout,
    PageTitleBox,
    Pagination,
    Create,
    Edit,
    CreateButton,
    RemoveEditButton,
  },
  setup() {
    // Start Propertis
    const busy = ref(false);
    const toast = useToast();
    const items = ref([]);
    const showCreate = ref(false);
    const links = ref([]);

    const perPage = ref(10);

    // START METHODS
    const fetchItems = async (page) => {
      busy.value = true;
      const url = route("api.category.index", {
        perPage: perPage.value,
        page: page,
      });
      const { data } = await axios.get(url);
      links.value = data.links;
      items.value = addProtos(data.data, {
        action: true,
        showEdit: false,
      });
      busy.value = false;
    };
    fetchItems(1);
    const push = (category) => {
      showCreate.value = false;
      items.value.push(category);
    };
    const replace = (category, index) => {
      showCreate.value = false;
      items.value.splice(index, 1, category);
    };

    const remove = async (item, index) => {
      const is = await confirm(item, "Category");
      if (!is) return null;
      try {
        const url = route("api.category.destroy", { category: item.id });
        await axios.delete(url);
        items.value.splice(index, 1);

        removeSuccess(toast);
      } catch (error) {
        console.log(error);
      }
    };

    const popularChange = (event, id) => {
      const url = route("api.category.popularChange", { category: id });
      axios.put(url, { do: !!event });
    };

    return {
      showCreate,
      perPage,
      items,
      popularChange,
      push,
      replace,
      fetchItems,
      remove,
      links,
      busy,
    };
  },
};
</script>

<style lang="scss" scoped>
.right {
  display: flex;
  justify-content: flex-end;
}
</style>
