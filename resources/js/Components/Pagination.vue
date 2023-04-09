<template>
    <div class="row justify-center mt-4" v-if="props.links.length">
        <va-button-group>
            <va-button
                @click="go(com.first.page)"
                :disabled="!com.first.page"
                :preset="com.first.active ?'':'secondary'"
                :color="com.first.active ? 'warning' : 'primary'"
                ><va-icon class="material-icons"
                    >chevron_left</va-icon
                ></va-button
            >
            <va-button 
                v-for="(link, index) in com.middles"
                :key="index"
                :disabled="!link.page"
                @click="go(link.page)"
                :preset="link.active ?'':'secondary'"
                :color="link.active ? 'warning' : 'primary'"
                >{{ link.label }}</va-button
            >
            <va-button
                :disabled="!com.last.page"
                   :preset="com.last.active ?'':'secondary'"
                :color="com.last.active ? 'warning' : 'primary'"
                @click="go(com.last.page)"
                ><va-icon class="material-icons"
                    >navigate_next</va-icon
                ></va-button
            >
        </va-button-group>
    </div>
</template>

<script>
import { ref,computed } from "@vue/reactivity";

export default {
    props: {
        links: {
            type: Array,
            default: () => [],
        },
    },
    setup(props, { emit }) {
  
        let com = computed(() => {
          let items=   props.links.map((link) => {
            const { url, label, active } = link;
            let page = null;
            if (url) {
                const searchParams = new URLSearchParams(new URL(url).search);
                page = searchParams.get("page");
            }

            return { label, active, page };
        })

              let lenght = items.length;
        let last = items.at(-1);
        let first = items.at(0);
        let middles = items.filter((e, i) => (!i ? false : i != lenght - 1));

              return { last, first, middles };
        });

  

        const go = (page) => {
            if (page) {
                emit("page", page);
            }
        };
        return { com, go, props };
    },
};
</script>

<style lang="scss" scoped></style>
