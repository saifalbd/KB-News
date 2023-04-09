<template>
    <el-dialog
        :model-value="props.show"
        :before-close="handleClose"
        :show-close="false"
        style="min-width: 350px"
    >
        <template #header="{ close, titleId, titleClass }">
            <div class="my-header">
                <h4 :id="titleId" :class="titleClass">Change Avatar!</h4>
                <el-button type="danger" @click="close">
                    <el-icon class="el-icon--left"
                        ><CircleCloseFilled
                    /></el-icon>
                    Close
                </el-button>
            </div>
        </template>
        <div class="center">
            <el-avatar :size="200" :src="src" />
        </div>
        <div class="center">
            <div class="input-box">
                <input type="file" @change="fileChange" />
                <el-button type="primary">
                    <el-icon>
                        <UploadFilled />
                    </el-icon>
                    Add Image</el-button
                >
            </div>
        </div>
        <template #footer>
            <span class="dialog-footer">
                <el-button type="primary" @click="upload">
                    <el-icon>
                        <UploadFilled />
                    </el-icon>
                    Upload
                </el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script>
import { ref } from "vue";
import { CircleCloseFilled, UploadFilled } from "@element-plus/icons-vue";
export default {
    components: {
        CircleCloseFilled,
        UploadFilled,
    },
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        src: {
            type: String,
            required: true,
        },
    },
    setup(props, { emit }) {
        const busy = ref(false);
        const visible = ref(true);
        const src = ref(props.src);
        const avatar = ref(null);

        const fileChange = (event) => {
            let files = event.target.files;
            if (files.length) {
                let file = files[0];
                avatar.value = file;
                let reader = new FileReader();
                reader.onload = () => {
                    let data = reader.result;
                    src.value = data;
                };
                reader.readAsDataURL(file);
            }
        };

        const close = () => {
            emit("update:show", false);
        };
        const handleClose = (done) => {
            done();
            close();
        };

        const upload = async () => {
            if (avatar.value) {
                try {
                    const fData = new FormData();
                    fData.append("avatar", avatar.value);
                    const { data } = await axios.post(route("api.avatar"), fData);
                    close();
                    emit("update:src", data.url);
                } catch (error) {
                    console.error(error);
                }
            } else {
                close();
            }
        };
        return { props, visible, busy, src, fileChange, upload, handleClose };
    },
};
</script>

<style lang="scss" scoped>
.center {
    display: flex;
    justify-content: center;
}
.my-header {
    display: flex;
    justify-content: space-between;
}
.input-box {
    max-width: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    margin-top: 20px;
    input {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        opacity: 0;
    }
}
</style>
