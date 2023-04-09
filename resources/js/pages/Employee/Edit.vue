<template>
    <form-dialog
        :show="props.show"
        @update:show="emit('update:show', $event)"
        :busy="busy"
        title="Edit User"
           is-edit
        @add="save"
    >
        <va-form ref="form">
            <div class="layout gutter--md">
                <div class="row align-content--center">
                    <div class="flex xs12">
                        <va-input
                            v-model="name"
                            label="Name *"
                            placeholder="Name Here"
                            :rules="rs('Name', true)"
                        />
                    </div>
                    <div class="flex xs12 mt-2">
                        <va-input
                            v-model="email"
                            label="Email *"
                            placeholder="Email Here"
                            @change="changeEmail"
                            :rules="
                                rs('Email', { required: true, email: true })
                            "
                        />
                    </div>
                    <div class="flex xs12 mt-2">
                        <va-input
                            v-model="phone"
                            label="Phone"
                            placeholder="Phone Here"
                             :rules="rs('Phone', true)"
                        />
                    </div>
                    <div class="flex xs12 mt-2">
                        <va-radio
                            v-for="(option, index) in props.designation"
                            :key="index"
                            v-model="position"
                            :label="option.title"
                            :option="option.id"
                        />
                    </div>
                </div>
            </div>
        </va-form>
    </form-dialog>
</template>

<script>
import { ref,watch } from "vue";
import FormDialog from "../../Components/FormDialog.vue";
import { rs } from "../../Plugins/Rule";
import { values } from "lodash";
import { confirm, removeSuccess, validErorrs } from "../../Plugins/utility";
export default {
    components: { FormDialog },

    props: {
        designations: {
            type: Array,
            required: true,
        },
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
        const canUser = ref(null);
        const form = ref(null);
        let name = ref(props.item.name);
        let email = ref(props.item.email);
        let phone = ref(props.item.phone);

        let item = ref(props.item)

    watch(props.item,(o) => {
      item.value = o;
    });


        let position = ref(props.item.position?.id);

        let rules = {
            title: [(v) => !!v || "title are requies"],
        };

        const save = async () => {
            let url = route("api.employee.update",{employee:item.value.id});
            let valid = await form.value.validate();
            if (!valid) return null;
            try {
                const { data } = await axios.put(url, {
                    name: name.value,
                    email: email.value,
                    phone: phone.value,
                    position: position.value,
                });
               emit("replace",addProtos(data,{action: true,showEdit: false}));
            } catch (error) {
                console.error(error);

                validErorrs(error);
            }
        };

        const changeEmail = async (event) => {
            const { value } = event.target;
            let filter =
                /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            const is = filter.test(value);
            if (!is) return null;

            try {
                const url = route("api.user.showByEmail", { email: value });
                const { data } = await axios.get(url);
                const can = values(data) ? data : null;
                canUser.value = can;
                if (can) {
                    name.value = can.name;
                }
            } catch (error) {
                console.log(error);
            }
        };

        return {
            props,
            form,
            emit,
            changeEmail,
            rs,
            save,
            busy,
            rules,
            save,
            name,
            phone,
            email,
            position,
        };
    },
};
</script>

<style lang="scss" scoped></style>
