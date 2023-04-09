<template>
    <form-dialog
        :show="props.show"
        @update:show="emit('update:show', $event)"
        :busy="busy"
        title="Edit Tag"
           is-edit
        @add="save"
    >
        <va-form ref="form">
            <div class="layout gutter--md">
                <div class="row align-content--center">
                    <div class="flex xs12">
                        <va-input
                            v-model="title"
                            label="Title"
                            placeholder="Title Here"
                              :rules="rs('title',true)"
                        />
                    </div>
                       <div class="flex xs12 mt-4">
                        <va-input
                            v-model="slug"
                            label="slug"
                            placeholder="Title Here"
                            :rules="rs('slug',true)"
                        />
                    </div>
                </div>
            </div>
        </va-form>
    </form-dialog>
</template>

<script>
import { ref, watch } from "vue";
import FormDialog from "../../Components/FormDialog.vue";
import { validErorrs } from "../../Plugins/utility";
import { rs } from "../../Plugins/Rule";
export default {
    components: { FormDialog },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
        item: {
            type: Object,
            required: true,
        },
    },

    setup(props, { emit }) {
        let busy = ref(false);
        const form = ref(null);
        let item = ref(props.item);
        let title = ref(props.item.title);
        let slug = ref(props.item.slug)
        watch(props.item, (o) => {
            item.value = o;
            title.value = o.title;
        });

       const change = ()=>{
            slug.value = split(lowerCase(trim(title.value)),' ').join('-');
        }
        const save = async () => {
            let url = route("api.category.update", { category: item.value.id });
            let valid = await form.value.validate();
            if (!valid) return null;
            try {
                const { data } = await axios.put(url, { title: title.value,slug:slug.value });
                emit(
                    "replace",
                    addProtos(data, {
                        action: true,
                        showEdit: false,
                    })
                );
            } catch (error) {
                validErorrs(error);
            }
        };

        return { props, form, emit, save,rs, title, busy,slug,change };
    },
};
</script>

<style lang="scss" scoped></style>
