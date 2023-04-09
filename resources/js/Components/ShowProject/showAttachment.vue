<template>
    <va-modal
        v-model="show"
        :fullscreen="false"
        hide-default-actions
        no-outside-dismiss
      
    >
        <div class="layout va-gutter-1">
            <div class="row">
                <div class="flex xs12">
                    <div class="item mb-4">
                        <div class="form-title">
                            <va-icon class="material-icons">file_present</va-icon>
                            <span class="text">Attachments</span>
                        </div>
                    </div>
                </div>
                <div class="flex xs12">
                    <div class="item">
                        <div class="row">
                            <div
                                class="flex sm12"
                                v-for="attach in props.attachments"
                                :key="attach.id"
                            >
                                <div :class="{ is_img: attach.isImg }" v-if="attach.isImg">
                                    <img :src="attach.url" :alt="attach.path" />
                                </div>
                                <div v-else>
                                    <a :href="attach.url">{{attach.path}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex xs12">
                    <div class="item actions-btns">
                        <va-button color="danger" size="small" @click="close"
                            ><va-icon class="material-icons">close</va-icon>
                            Close</va-button
                        >
                       
                    </div>
                </div>
            </div>
        </div>
    </va-modal>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
    props: {
        show: {
            type: Boolean,
            default:false
        },
        attachments: {
            type: Array,
            default() {
                return [];
            },
        },
    },
    setup(props,{emit}) {
          const close = () => {
            emit("update:show", false);
        };
        return { props,close };
    },
});
</script>

<style scoped lang="scss">
.form-title {
    .text {
        font-weight: bold;
    }
}
img{
    max-width: 100%;
}
.actions-btns {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
    button {
        margin: 0 5px;
    }
}
</style>
