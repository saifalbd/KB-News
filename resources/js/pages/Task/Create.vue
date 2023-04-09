<template>
    <form-dialog
        :show="props.show"
        @update:show="emit('update:show', $event)"
        :busy="formBusy"
        title="Create Task"
        @add="save"
        :fullscreen="true"
    >
        <va-form ref="form">
            <div class="layout gutter--md">
                <div class="row align-content--center">
                    <div class="flex xs12 in-box">
                        <va-input
                            v-model="title"
                            label="Title *"
                            placeholder="Title Here"
                            :rules="rs('title', true)"
                        />
                    </div>

                    <div class="flex xs12 in-box">
                        <va-select
                            v-model="category"
                            label="Project Category *"
                            placeholder="Category Here"
                            :rules="rs('Category', true)"
                            text-by="title"
                            value-by="id"
                            :options="props.categories"
                        />
                    </div>

                    <div class="flex xs12 in-box">
                        <va-select
                            v-model="employee"
                            label="Task Employee *"
                            placeholder="Task Employee Here"
                            :rules="rs('member', true)"
                            searchable
                            text-by="name"
                            :options="props.employees"
                        >
                            <template #content="{ value }">
                                <va-chip size="small" class="mr-1 my-1">
                                    {{ value.name }}
                                </va-chip>
                            </template>
                        </va-select>
                    </div>

                    <div class="flex xs6 in-box">
                        <va-input
                            v-model="start"
                            label="Start *"
                            type="date"
                            placeholder="Start Here"
                            :rules="rs('start', true)"
                        />
                    </div>
                    <div class="flex xs6 in-box">
                        <va-input
                            v-model="end"
                            type="date"
                            label="Dead Line *"
                            placeholder="Dead Line Here"
                            :rules="rs('dead line', true)"
                        />
                    </div>
                    <div class="flex xs12 in-box">
                        <va-file-upload v-model="attachments" dropzone />
                    </div>
                  <div class="flex xs12" style="min-height:150px; margin-bottom:50px">
                           <QuillEditor theme="snow" toolbar="minimal" contentType="html" v-model:content="description" placeholder="Description Html Contant"/>
                    </div>
                </div>
            </div>
        </va-form>
    </form-dialog>
</template>

<script>
import { ref, watch } from "vue";
import FormDialog from "../../Components/FormDialog.vue";
import { rs } from "../../Plugins/Rule";
import moment from "moment";
export default {
    components: { FormDialog },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
        employees: {
            type: Array,
            required: true,
        },
        categories: {
            type: Array,
            required: true,
        },
    },

    setup(props, { emit }) {
        let busy = ref(false);
        const formBusy = ref(false);
        const form = ref(null);
        let title = ref("");
        let category = ref(null);
        let employee = ref(null);
        const start = ref(moment().format(dateFormat));
        const end = ref(null);
        const description = ref("");
        const attachments = ref([]);

        const save = async () => {
            let url = route("api.task.store");
            let valid = await form.value.validate();
            if (!valid) return null;
            formBusy.value = true;
            try {
                const formData = new FormData();
                formData.append("title", title.value);
                formData.append("category", category.value);
                formData.append("employee", employee.value?.id);
                formData.append("start", start.value);
                formData.append("end", end.value);
                formData.append("description", description.value);
                attachments.value.forEach((file,index)=>{
                     formData.append(`attachments[${index}]`,file); 
                })

                const { data } = await axios.post(url,formData);
                emit(
                    "push",
                    addProtos(data, {
                        action: true,
                        showEdit: false,
                    })
                );
            } catch (error) {
                console.error(error);
                validErorrs(error);
            }
            formBusy.value = false
        };

        return {
            props,
            form,
            emit,
            save,
            rs,
            busy,
            formBusy,

            title,
            start,
            end,
            employee,
            category,
            description,
            attachments,
        };
    },
};
</script>

<style lang="scss" scoped></style>
