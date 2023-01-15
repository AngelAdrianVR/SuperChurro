<template>
  <div class="flex items-center border-b-2 font-bold dark:border-slate-700 w-full overflow-x-auto">
    <Link v-for="(tab, key) in tabs" :key="key" :href="route(tab.url)"
      :class="route().current(tab.url) ? 'border-teal-500 text-teal-500 border-b-2' : ''" class="px-5 py-1"
      v-html="tab.label" />
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
  },
  props: {
    tabs: Array,
  },
};
</script>
