<template>
  <app-layout :busy="busy">
    <div>
      <page-title-box title="Employees">
        <create-button
          title="Add Employee"
          @click="showCreate = true"
        ></create-button>
      </page-title-box>
    </div>

    <div class="filter-row">
      <div class="left-side">
        <div class="item">
          <el-select v-model="perPage" placeholder="Per Page">
            <el-option
              v-for="item in [10, 20, 30, 40, 50]"
              :key="item"
              :label="item"
              :value="item"
            />
            <template #prefix>
              <el-icon class="el-input__icon"><collection /></el-icon>
            </template>
          </el-select>
        </div>
      </div>
      <div class="right-side">
        <div class="item right mr-3">
         
        </div>
        <div class="item right">
          <el-input>
            <template #prefix>
              <el-icon class="el-input__icon"><search /></el-icon>
            </template>
          </el-input>
        </div>
      </div>
    </div>

    <el-divider />

    <div class="card-list">
      <div class="item" v-for="(item, index) in items" :key="index">
        <el-card class="card-box">
          <div class="block">
            <el-avatar :size="200" :src="item.avatar.url" />
          </div>

          <div style="padding: 14px">
            <el-descriptions
              :title="item.name"
              direction="horizontal"
              :column="1"
              size="small"
              border
            >
              <el-descriptions-item label="Designation:">{{
               item.roles.map(e=>e.name).join(',')
              }}</el-descriptions-item>
              <el-descriptions-item label="Phone:">{{
                item.phone
              }}</el-descriptions-item>
              <el-descriptions-item label="Message:"
                ><el-button
                  size="small"
                  type="info"
                  plain
                  @click="goProfile(item.id)"
                >
                  <el-icon>
                    <message />
                  </el-icon> </el-button
              ></el-descriptions-item>
              <el-descriptions-item label="Delete:"
                ><el-button
                  size="small"
                  type="danger"
                  plain
                  @click="remove(item, index)"
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
                  @click="goProfile(item.id)"
                >
                  <el-icon>
                    <more />
                  </el-icon> </el-button
              ></el-descriptions-item>
            </el-descriptions>
          </div>
        </el-card>
      
      </div>
    </div>

 
    <pagination :links="links" @page="fetchItems"></pagination>
    <create
      v-model:show="showCreate"
      :roles="roles"
      @push="push"
    ></create>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/app-layout.vue";
import PageTitleBox from "../../Components/PageTitleBox.vue";
import Pagination from "../../Components/Pagination.vue";
import Create from "./Create.vue";
import { ref } from "vue";
import CreateButton from "../../Components/CreateButton.vue";
import { confirm, dropdowns, removeSuccess } from "../../Plugins/utility";
import RemoveEditButton from "../../Components/RemoveEditButton.vue";
import { useToast } from "vuestic-ui";
import { useRouter } from "vue-router";
import {
  Delete,
  More,
  Message,
  List,
  Box,
  Search,
  Collection,
} from "@element-plus/icons-vue";

export default {
  components: {
    AppLayout,
    PageTitleBox,
    Pagination,
    Create,
    CreateButton,
    RemoveEditButton,
    Delete,
    More,
    Message,
    List,
    Box,
    Search,
    Collection,
  },
  setup() {
    const router = useRouter();

    // Start Propertise
    const busy = ref(false);
    const toast = useToast();
    const items = ref([]);
    const roles = ref([]);
    const showCreate = ref(false);
    const links = ref([]);
    const perPage = ref(10);


    // START Methods
    const fetchItems = async (page) => {
      const url = route("api.user.index", {
        perPage: perPage.value,
        page: page,
      });
      const { data } = await axios.get(url);
      links.value = data.links;

      items.value = addProtos(data.data, {
        action: true,
        showEdit: false,
      }).map((item) => {
       
        return item;
      });
      busy.value = false;
    };
    fetchItems(1);

    const replace = (employee, index) => {
      showCreate.value = false;
      items.value.splice(index, 1, employee);
    };
    const push = (employee) => {
      showCreate.value = false;
      items.value.push(employee);
    };

    dropdowns("roles", (data) => {
      roles.value = data;
    });

    const remove = async (item, index) => {
      const is = await confirm(item, "Employee", "email");
      if (!is) return null;

      try {
        const url = route("api.employee.destroy", { employee: item.id });
        await axios.delete(url);
        items.value.splice(index, 1);
        removeSuccess(toast);
      } catch (error) {
        console.log(error);
      }
    };

    const goProfile = (user) => {
      router.push({ name: "userProfile", params: { user } });
    };

    return {
      busy,
      showCreate,
      perPage,
      items,
      roles,
      
      remove,
      push,
      replace,
      fetchItems,
      goProfile,
      links,
  
    };
  },
};
</script>

<style lang="scss" scoped>
.right {
  display: flex;
  justify-content: flex-end;
}
.card-list {
  width: 100%;
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  .s-card {
    position: relative;
    margin: 5px;
    width: 250px;
    min-height: 250px;
    background-color: #f9f3ef;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;
    .s-img-box {
      width: 150px;
      aspect-ratio: 1;
      border-radius: 50%;
      overflow: hidden;
      border: 2px solid silver;
      > img {
        max-height: 100%;
        max-width: 100%;
      }
    }
    .s-name {
      font-weight: bold;
      font-size: 1.1rem;
    }
    .s-position {
      color: #8e8e8e;
    }
    .s-menu {
      position: absolute;
      top: 0;
      right: 0;
    }
  }
}
.right-side {
  .va-button-group {
    .va-button {
      height: 35px;
    }
  }
}
</style>
