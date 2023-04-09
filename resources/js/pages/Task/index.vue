<template>
  <app-layout :busy="busy">
    <div>
      <page-title-box title="Task">
        <create-button
          title="Add Task"
          @click="showCreate = true"
        ></create-button>
          <el-button type="primary" @click="router.push({name:'task.archive'})">
            <el-icon>
              <download/>
            </el-icon>
            Archives
          </el-button>
      </page-title-box>
    </div>

    <div class="filter-row mt-2">
      <div class="left-side">
        <div class="item">
          <el-select v-model="perPage" placeholder="Per Page">
            <el-option
              v-for="item in [10, 20, 30, 40, 50, 70, 100]"
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
          <el-button-group>
            <el-button
              :type="isCardWise ? 'info' : 'primary'"
              @click="isCardWise = false"
            >
              <el-icon><list /></el-icon>
            </el-button>
            <el-button
              :type="!isCardWise ? 'info' : 'primary'"
              @click="isCardWise = true"
            >
              <el-icon><box /></el-icon>
            </el-button>
          </el-button-group>
        </div>
        <div class="item right">
          <el-input placeholder="Type something">
            <template #prefix>
              <el-icon class="el-input__icon"><search /></el-icon>
            </template>
          </el-input>
        </div>
      </div>
    </div>
    <el-divider />

    <el-row class="card-list" v-if="isCardWise" :gutter="24">
      <el-col :sm="24" :md="12" v-for="(item, index) in items" :key="index">
        <el-card>
          <el-descriptions
            :title="item.title"
            direction="horizontal"
            :column="1"
            size="small"
            border
          >
            <el-descriptions-item label="Assgned To:">{{
              item.employee.model.name
            }}</el-descriptions-item>
            <el-descriptions-item label="Dead Line:">{{
              item.end
            }}</el-descriptions-item>
            <el-descriptions-item label="Status:">
              <status-btn :status="item.status" size="small"></status-btn>
            </el-descriptions-item>

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
                @click="
                  router.push({
                    name: 'task.show',
                    params: { id: item.id },
                  })
                "
              >
                <el-icon>
                  <more />
                </el-icon> </el-button
            ></el-descriptions-item>
          </el-descriptions>
          <div class="description" v-html="item.description"></div>
        </el-card>
      </el-col>
    </el-row>
<!--  v-model:sort-by="sortBy" -->
    <va-data-table
      v-else
      :items="items"
      :columns="columns"
      :hoverable="true"
     
      v-model:sorting-order="sortingOrder"
    >
    <template #cell(title)="{rowData}">
  <el-link @click="
                      go({
                        name: 'task.show',
                        params: { id: rowData.id },
                      })
                    "><b>{{rowData.title}}</b></el-link>
    </template>
       <template #cell(user_star)="{ rowData}">
        <el-button @click="addStar(rowData)" size="small" :type="rowData.user_star?'warning':''" plain round>
          <el-icon>
            <star-filled/>
          </el-icon>
        </el-button>
      </template>

      <template #cell(employee)="{ rowData }">
        <el-link
          :underline="false"
          @click="
            router.push({
              name: 'userProfile',
              params: { user: rowData.employee.model.id },
            })
          "
        >
          <el-avatar :size="25" :src="rowData.employee.model.avatar.url" />
          <b class="ml-1">
            {{ rowData.employee.model.name }}
          </b>
        </el-link>
      </template>
      <template #cell(status)="{ value }">
        <status-btn :status="value" size="small"></status-btn>
      </template>
      <template #cell(action)="{ rowData, rowIndex }">
        <div>
          <el-button-group>
            <el-button type="primary" size="small" title="Archive" @click="doArchive(rowData, rowIndex)">
              <el-icon>
                <download />
              </el-icon>
            </el-button>

            <el-button
              type="primary"
              size="small"
              @click="
                router.push({
                  name: 'task.show',
                  params: { id: rowData.id },
                })
              "
              title="Show"
            >
              <el-icon :size="20">
                <expand />
              </el-icon>
            </el-button>
            <el-button
              type="primary"
              size="small"
              @click="rowData.showEdit = true"
              title="edit"
            >
              <el-icon :size="20">
                <edit />
              </el-icon>
            </el-button>
            <el-button
              type="danger"
              size="small"
              @click="remove(rowData, rowIndex)"
              title="remove"
            >
              <el-icon>
                <delete />
              </el-icon>
            </el-button>
          </el-button-group>

          <edit-vue
            v-model:show="rowData.showEdit"
            :item="rowData"
            :employees="employees"
            :categories="categories"
            @replace="replace($event, rowIndex)"
          ></edit-vue>
        </div>
      </template>
    </va-data-table>
    <pagination :links="links" @page="fetchItems"></pagination>
    <create
      v-model:show="showCreate"
      :employees="employees"
      :categories="categories"
      @push="push"
    ></create>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/app-layout.vue";
import PageTitleBox from "../../Components/PageTitleBox.vue";
import Pagination from "../../Components/Pagination.vue";
import RemoveEditButton from "../../Components/RemoveEditButton.vue";
import Create from "./Create.vue";
import EditVue from "./Edit.vue";
import { ref } from "vue";
import CreateButton from "../../Components/CreateButton.vue";
import { confirm, removeSuccess, dropdowns } from "../../Plugins/utility";
import { useToast } from "vuestic-ui";
import { useRouter } from "vue-router";
import StatusBtn from "../../Components/statusBtn.vue";
import {sortBy} from 'lodash';
import {
  Delete,
  More,
  List,
  Box,
  Search,
  Collection,
  Expand,
  Edit,
  Download,
  Star,
  StarFilled,
} from "@element-plus/icons-vue";
export default {
  components: {
    AppLayout,
    PageTitleBox,
    Pagination,
    Create,
    EditVue,
    Edit,
    List,
    Box,
    CreateButton,
    RemoveEditButton,
    StatusBtn,
    Delete,
    More,
    Search,
    Collection,
    Expand,
    Download,
    Star,
    StarFilled,
  },
  setup() {
    // Start Propertis
    const isCardWise = ref(false);
    const busy = ref(true);
    const toast = useToast();
    const router = useRouter();

    const items = ref([]);
    const employees = ref([]);
    const categories = ref([]);
    const showCreate = ref(false);
    const links = ref([]);

    const perPage = ref(50);
    // const sortBy = ref("title");
    const columns = [
      { key: "user_star",label:'Star', sortable: true },
      { key: "id", sortable: true, sortingOptions: ["desc", "asc"] },
      { key: "title", sortable: true },

      { key: "category.title", label: "Category", sortable: true },
      { key: "employee", label: "Employee", sortable: true },
      { key: "start", label: "Start", sortable: true },
      { key: "end", label: "Dead Line", sortable: true },

      { key: "status", sortable: true },
      {
        key: "action",
        thAlign: "right",
        tdAlign: "right",
      },
    ];
    const sortingOrder = ref("asc");

    // START METHODS
    dropdowns("employees", (data) => {
      employees.value = data;
    });

    dropdowns("categories", (data) => {
      categories.value = data;
    });
    const fetchItems = async (page) => {
      try {
        const url = route("api.task.index", {
          perPage: perPage.value,
          page: page,
        });
        const { data } = await axios.get(url);
        links.value = data.links;
        items.value = sortBy(addProtos(data.data, {
          action: true,
          showEdit: false,
        }),'user_star').reverse();
      } catch (error) {
        console.error(error);
      }
      busy.value = false;
    };
    fetchItems(1);
    const push = (projrct) => {
      showCreate.value = false;
      items.value.push(projrct);
    };
    const replace = (project, index) => {
      showCreate.value = false;
      items.value.splice(index, 1, project);
    };

    const remove = async (item, index) => {
      const is = await confirm(item, "Task", "title");
      if (!is) return null;
      try {
        const url = route("api.task.destroy", { task: item.id });
        await axios.delete(url);
        items.value.splice(index, 1);
        removeSuccess(toast);
      } catch (error) {
        console.log(error);
      }
    };

    const addStar = (item)=>{
      
      item.user_star = !item.user_star;
      axios.post(route('api.task.changeStar',{task:item.id}),{prop:'user_star', star:item.user_star?0:1})
    }

    const doArchive = (item,index)=>{
       items.value.splice(index, 1);
      axios.post(route('api.task.doArchive',{task:item.id}),{prop:'user_archive', do:item.user_archive?0:1})
    }

    return {
      busy,
      showCreate,
      perPage,
      sortingOrder,
      items,
      columns,
    
      push,
      replace,
      fetchItems,
      employees,
      categories,
      remove,
      addStar,
      doArchive,
      links,
      router,
      isCardWise,
    };
  },
};
</script>

<style lang="scss" scoped>
.right {
  display: flex;
  justify-content: flex-end;
}

.description {
  height: 200px;
  overflow: auto;
  margin-top: 5px;
}
</style>
