<template>
    <app-layout :busy="busy">
        <div>
            <page-title-box title="Designations">
                <create-button title="Add Designation" @click="showCreate = true"></create-button>
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

        <va-data-table
            :items="items"
            :columns="columns"
            :hoverable="true"
            v-model:sort-by="sortBy"
            v-model:sorting-order="sortingOrder"
        >
            <template #cell(action)="{ rowData, rowIndex }">
                <remove-edit-button
                    @editClick="rowData.showEdit = true"
                    @removeClick="remove(rowData, rowIndex)"
                >
                   <edit
                        v-model:show="rowData.showEdit"
                        :item="rowData"
                        @replace="replace($event, rowIndex)"
                    ></edit>
                </remove-edit-button>
            </template>
        </va-data-table>
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
import { ref} from "vue";
import CreateButton from '../../Components/CreateButton.vue';
import { confirm, removeSuccess } from "../../Plugins/utility";
import RemoveEditButton from "../../Components/RemoveEditButton.vue";
import { useToast } from 'vuestic-ui'
export default {
    components: {
        AppLayout,
        PageTitleBox,
        Pagination,
        Create,
        Edit,
        CreateButton,
        RemoveEditButton
    },
    setup() {
        // Start Propertis
        const busy = ref(false)
         const toast = useToast();
        const items = ref([]);
        const showCreate = ref(false);
        const links = ref([]);

        const perPage = ref(10);
        const sortBy = ref("title");
        const columns = [
            { key: "id", sortable: true, sortingOptions: ["desc", "asc"] },
            { key: "title", sortable: true },
            {
                key: "action",
                thAlign: "right",
                tdAlign: "right",
            },
        ];
        const sortingOrder = ref("asc");

        // START METHODS
        const fetchItems = async (page) => {
            busy.value = true;
            const url = route("api.designation.index", {
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
        const push = (designation) => {
            showCreate.value = false;
            items.value.push(designation);
        };
        const replace = (designation, index) => {
            showCreate.value = false;
            items.value.splice(index, 1, designation);
        };

        const remove = async (item, index) => {
            const is = await confirm(item, "Designation");
            if (!is) return null;
            try {
                const url = route("api.designation.destroy", { designation: item.id });
                await axios.delete(url);
                items.value.splice(index, 1);
                
                removeSuccess(toast);
            } catch (error) {
                console.log(error);
            }
        };

        return {
            showCreate,
            perPage,
            sortingOrder,
            items,
            columns,
            sortBy,
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
