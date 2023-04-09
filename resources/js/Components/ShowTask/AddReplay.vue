<template>
    <form-dialog
        :show="props.show"
        @update:show="emit('update:show', $event)"
        :busy="busy"
        title="Replay"
        @add="save"
        :fullscreen="false"
    >
        <va-form ref="form">
            <div class="layout gutter--md">
                <div class="row align-content--center">
                    <div class="flex xs12 in-box">
                        <va-input
                            v-model="text"
                            label="Replay"
                            type="textarea"
                            placeholder="Commnet Here"
                            :rules="rs('Replay', true)"
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
import { rs } from "../../Plugins/Rule";
import moment from "moment";
export default {
    components: { FormDialog },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
         taskId:{
            type:Number,
            required:true,
        },
        parent:{
            type:Object,
            required:true
        }
       
    },

    setup(props, { emit }) {
        let busy = ref(false);
        const form = ref(null);
        let text = ref("");
       // console.log(props)

        const save = async () => {
            let url = route("api.task.store");
            let valid = await form.value.validate();
            if (!valid) return null;
            try {
                const formData = new FormData();
                  const url = route("api.comment.store");
                
                formData.append("model_id", props.taskId);
                formData.append("model_type", "task");
                formData.append("parent_id", props.parent.id);
                formData.append("text", text.value);
                const { data } = await axios.post(url, formData);
               
                text.value = '';
               
emit('update:show', false)


                // attachments.value.forEach((file,index)=>{
                //      formData.append(`attachments[${index}]`,file);
                // })

            
                // emit(
                //     "push",
                //     addProtos(data, {
                //         showReplay: false,
                //     })
                // );
            } catch (error) {
                console.error(error);
                validErorrs(error);
            }
        };

        return {
            props,
            form,
            emit,
            save,
            rs,
            busy,

            text,
           
        };
    },
};
</script>

<style lang="scss" scoped></style>
