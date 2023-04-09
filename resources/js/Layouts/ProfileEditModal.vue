<template>
  <va-modal
    v-model="show"
    :fullscreen="false"
    hide-default-actions
    no-outside-dismiss
    class="form-sceen"
  >
    <va-inner-loading :loading="busy">
      <div class="layout va-gutter-1">
        <div class="row">
          <div class="flex xs12">
            <div class="item mb-4">
              <div class="form-title">
                <va-icon name="notifications"></va-icon>
                <span class="text">{{ title }}</span>
              </div>
            </div>
          </div>
          <div class="flex xs12">
            <div class="row">
              <div class="flex xs12">
                <div class="tumb-card" :class="{hasThumb}">
                  <div class="img-box" v-if="hasThumb">
                    <img :src="thumbnil" alt="" />
                  </div>
                  <div class="input-box">
                    <div
                      class="va-file-upload va-file-upload--dropzone"
                      style="background-color: rgba(21, 79, 193, 0.08)"
                    >
                      <div class="va-file-upload__field">
                        <div class="va-file-upload__field__text">
                          Click Here And Upload File
                        </div>
                      </div>
                      <input
                        type="file"
                        class="va-file-upload__field__input"
                        tabindex="-1"
                        aria-hidden="true"
                        @change="fileAded"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="flex xs12">
            <div class="item actions-btns">
              <va-button color="info" @click="update"> Skip</va-button>
              <va-button color="success" @click="update"> Next</va-button>
            </div>
          </div>
        </div>
      </div>
    </va-inner-loading>
  </va-modal>
</template>

<script>
import { defineComponent, ref } from "vue";
import { mainStore } from "../store/index";

export default defineComponent({
  model: {
    prop: "show",
    event: "change",
  },
  props: {
    show: {
      type: Boolean,
      default: true,
    },
  },
  setup(props, { emit }) {
    const main = mainStore();
    const busy = ref(false);
    const title = "Profile Thumbnil";
    let hasThumb = ref(false)
    let thumbnil = ref('');
    let attach = ref(null);
    const close = () => {
      emit("update:show", false);
    };

    const fileAded = (event) => {
      let target = event.target;

      let files = target.files;

      if (files.length) {
        let file = files[0];
        attach.value = file;
        let reader = new FileReader();

        reader.onload = () => {
          let src = reader.result;
          thumbnil.value = src;
          hasThumb.value = true;
        };
        reader.readAsDataURL(file);
      }
    };

    const update =async ()=>{
      try {
        const url = route('api.avatar',{},false);
        const f = new FormData
        if(attach.value){
          f.append('avatar',attach.value)
        }
       const {data} = await axios.post(url,f);
       main.updateAvatar(data);
       main.hideProfileModal()
      } catch (error) {
        console.error(error)
      }
    }

    return {
      title,
      attach,
      hasThumb,
      thumbnil,
      fileAded,
      update,
      busy,
      props,
      close,
    };
  },
});
</script>

<style scoped lang="scss">
.tumb-card {
  display: grid;
  grid-template-columns:100%;
  &.hasThumb{
      grid-template-columns: 200px auto;
       .input-box {
    margin-left: -30px;
       }
  }
  > div {
    display: flex;
    align-items: center;
  }
  .img-box {
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid gold;
  }
  .input-box {

    > div {
      width: 100%;
    }
  }
  img {
    width: 100%;
  }
}
.form-title {
  .text {
    font-weight: bold;
  }
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
