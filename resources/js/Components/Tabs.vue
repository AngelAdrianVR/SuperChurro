<template>
  <div class="flex items-center border-b-2 dark:border-slate-700 w-full overflow-x-auto dark:text-gray-300">
    <Link v-for="(tab, key) in tabs" :key="key" :href="route(tab.url)"
      :class="route().current(tab.url) ? 'border-indigo-400 text-indigo-400 border-b-2' : ''" class="px-5 py-1"
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
