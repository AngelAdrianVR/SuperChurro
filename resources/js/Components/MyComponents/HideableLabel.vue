<template>

  <div class="text-primary font-bold text-xs border border-gray3 rounded-tl-[5px] rounded-bl-[5px] transition ease-linear duration-300">
    <div class="flex space-x-3 rounded-tl-[5px] rounded-bl-[5px] cursor-pointer p-2 items-start bg-gray-50"
      @click="toggleNotification">
      <div class="rounded-full border-2 border-primary w-4 h-4 flex items-center justify-center">
        <i :class="iconClass" class="mt-[2px] mx-2 text-[8px]"></i>
      </div>
      <p v-if="showNotification">
        <slot />
      </p>
    </div>
  </div>

</template>

<script>
export default {
  props: {
    iconClass: {
      type: String,
      default: 'fa-solid fa-info',
    },
  },
  data() {
    return {
      showNotification: false,
    };
  },
  methods: {
    toggleNotification() {
      this.showNotification = !this.showNotification;
    },
  },
};
</script>
