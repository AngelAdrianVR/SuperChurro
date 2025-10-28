<template>
  <button @click="handleRedirection()"
    class="flex justify-center items-center rounded-full py-[9px] w-10 h-10 focus:outline-none hover-3dbuttom">
    <i class="fa-solid fa-angle-left text-lg"></i>
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
