<template>
  <button @click="handleRedirection()"
    class="flex justify-center items-center rounded-full py-[9px] px-3 focus:outline-none hover-3dbuttom">
    <i class="fa-solid fa-angle-left text-xs"></i>
  </button>
</template>

<script>
export default {
  props: {
    to: {
      type: String,
      default: null
    }
  },
  methods: {
    handleRedirection() {
      if (this.to) {
        this.$inertia.visit(this.to);
      } else {
        window.history.back();
      }
    },
  },
};
</script>
