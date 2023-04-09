<template>
    <form-dialog
        :show="props.show"
        @update:show="emit('update:show', $event)"
        :busy="busy"
        title="Create Cetegory"
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
                            @change="change"
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
import { ref } from "@vue/reactivity";
import FormDialog from "../../Components/FormDialog.vue";
import { rs } from "../../Plugins/Rule";
import {trim,replace,split,lowerCase} from 'lodash';
export default {
    components: { FormDialog },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
    },

    setup(props, { emit }) {
        let busy = ref(false);
        const form = ref(null);
        let title = ref("");
        let slug = ref('')
        let url = route("api.category.store");

        const change = ()=>{
            slug.value = split(lowerCase(trim(title.value)),' ').join('-');
        }
      
        const save = async () => {
            let valid = await form.value.validate();
            if (!valid) return null;
            try {
                const { data } = await axios.post(url, { title: title.value,slug:slug.value });
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
        };

        return { props, form, emit,rs, save, title,slug, busy,change };
    },
};
</script>

<style lang="scss" scoped></style>
