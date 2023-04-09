<script>
import { ref } from "@vue/reactivity";
import { defineComponent, h } from "vue";
import AddReplay from "./AddReplay.vue";
import ShowAttachment from "./showAttachment.vue";
import { VaAvatar, VaIcon, VaButtonGroup } from "vuestic-ui";
export default defineComponent({
  components: {
    VaAvatar,
    AddReplay,
    VaButtonGroup,
    ShowAttachment,
  },
  props: {
    taskId: {
      type: Number,
      required: true,
    },
    comments: {
      type: Array,
      required: true,
    },
  },
  setup(props) {
    const remove = async (id, list) => {
      try {
        const url = route("api.comment.destroy", { comment: id });
        await axios.delete(url);

        const index = list.findIndex((e) => e.id == id);
        if (index > -1) {
          list.splice(index, 1);
        }
      } catch (error) {
        console.error(error);
      }
    };

    return { props, remove };
  },
  methods: {
    icon(d) {
      let size = 18;
      return h(
        "svg",
        {
          style: `width:${size}px;height:${size}px`,
          viewBox: "0 0 24 24",
        },
        [
          h("path", {
            fill: "currentColor",
            d,
          }),
        ]
      );
    },
    commentItemField(c, list) {
      let result = h("div");
      if (c.replayes.length) {
        result = h(
          "div",
          { class: "comment-list" },
          c.replayes.map((c) => {
            return this.commentItemField(c, c.replayes);
          })
        );
      }

      let base = h("div", { class: "comment-list-item" }, [
        h("div", { class: "inner" }, [
          h("div", {}, [
            h(VaAvatar, {
              src: "https://randomuser.me/api/portraits/women/5.jpg",
            }),
          ]),
          h(
            "div",
            {
              class: "text-box",
            },
            [h("p", {}, [h("b", {}, c.user.name),h('small',c.atNow)]), h("p", {}, c.text)]
          ),
        ]),
        h("div", { class: "action-bar" }, [
          h(AddReplay, {
            show: c.showReplay,
            parent: c,
            taskId: this.props.taskId,
            "onUpdate:show": (val) => {
              c.showReplay = val;
            },
            onPush: (item) => {
              c.replayes.push(item);
              c.showReplay = false;
            },
          }),
          h("div", { class: "action-bar-inner" }, [
            h(
              "div",

              {
                class: "action-list",
              },
              [
                h("button", { class: "like-btn" }, [
                  this.icon(
                    "M5,9V21H1V9H5M9,21A2,2 0 0,1 7,19V9C7,8.45 7.22,7.95 7.59,7.59L14.17,1L15.23,2.06C15.5,2.33 15.67,2.7 15.67,3.11L15.64,3.43L14.69,8H21C22.11,8 23,8.9 23,10V12C23,12.26 22.95,12.5 22.86,12.73L19.84,19.78C19.54,20.5 18.83,21 18,21H9M9,19H18.03L21,12V10H12.21L13.34,4.68L9,9.03V19Z"
                  ),
                ]),
                h(
                  "button",
                  {
                    class: "replay-btn",
                    onClick: () => {
                      c.showReplay = true;
                    },
                  },
                  [
                    this.icon(
                      "M11,9.8V10.7L12.7,10.9C15.3,11.3 17.2,12.3 18.6,13.6C16.9,13.1 15.1,12.8 13,12.8H11V14.1L8.8,12L11,9.8M13,5L6,12L13,19V14.9C18,14.9 21.5,16.5 24,20C23,15 20,10 13,9M7,8V5L0,12L7,19V16L3,12"
                    ),
                    "Replay",
                  ]
                ),
                h("button", { class: "remove-btn",
                onClick:()=>{
                  this.remove(c.id,list)
                }
                 }, [
                  this.icon(
                    "M4 19V7H16V19C16 20.1 15.1 21 14 21H6C4.9 21 4 20.1 4 19M6 9V19H14V9H6M13.5 4H17V6H3V4H6.5L7.5 3H12.5L13.5 4M19 17V15H21V17H19M19 13V7H21V13H19Z"
                  ),
                  "Remove",
                ]),
              ]
            ),
            c.attachments?.length
              ? h("div", {}, [
                  h(ShowAttachment, {
                    attachments: c.attachments,
                    show: c.showAttachModal,
                    "onUpdate:show": (val) => {
                      c.showAttachModal = val;
                    },
                  }),
                  h(
                    "button",
                    {
                      class: "show-attach-btn",
                      onClick: () => {
                        c.showAttachModal = true;
                      },
                    },
                    [
                      this.icon(
                        "M4 19V7H16V19C16 20.1 15.1 21 14 21H6C4.9 21 4 20.1 4 19M6 9V19H14V9H6M13.5 4H17V6H3V4H6.5L7.5 3H12.5L13.5 4M19 17V15H21V17H19M19 13V7H21V13H19Z"
                      ),
                      "Show Attach",
                    ]
                  ),
                ])
              : h("div"),
          ]),
        ]),
        result,
      ]);

      return base;
    },
  },
  render() {
    return h(
      "div",
      { class: "comment-list" },
      this.props.comments.map((c) => {
        return this.commentItemField(c, this.props.comments);
      })
    );
  },
});
</script>

<style lang="scss" scoped></style>
