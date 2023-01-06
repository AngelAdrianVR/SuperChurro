<template>
  <div
    class="my-3 py-6 px-6 bg-gray-100 dark:bg-slate-700 dark:border-slate-500 dark:text-gray-300 border border-dashed rounded-md border-gray-300"
    @dragover="dragover"
    @dragleave="dragleave"
    @drop="drop"
  >
    <input
      type="file"
      multiple
      name="fields[assetsFieldHandle][]"
      id="assetsFieldHandle"
      class="w-[2px] h-px opacity-0 overflow-hidden absolute"
      @change="onChange"
      ref="file"
      accept=".pdf,.jpg,.jpeg,.png,.xls,.ppt,.zip,.doc,.docx,.xslx,.txt"
    />

    <label for="assetsFieldHandle" class="block cursor-pointer text-sm text-center">
      Arrastra tus archivos o da <span class="underline">click aqui</span> para
      abrir el explorador de carpetas
    </label>
    <ul class="mt-4 lg:grid grid-cols-3 text-center" v-if="this.filelist.length" v-cloak>
      <li v-for="(file, index) in filelist" :key="index" class="text-xs text-indigo-500 p-1">
        {{ file.name }}
        <button
          type="button"
          @click="remove(filelist.indexOf(file))"
          title="Remover archivo"
        >
          <span class="text-gray-500 ml-2 font-bold text-lg hover:text-red-500">x</span>
        </button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filelist: [],
    }; // Store our uploaded files
  },
  methods: {
    onChange() {
      this.filelist = [...this.$refs.file.files];
    },
    remove(i) {
      this.filelist.splice(i, 1);
    },
    dragover(event) {
      event.preventDefault();
      // Add some visual fluff to show the user can drop its files
      if (!event.currentTarget.classList.contains("bg-indigo-100")) {
        event.currentTarget.classList.remove("bg-gray-100");
        event.currentTarget.classList.add("bg-indigo-100");
        event.currentTarget.classList.add("border-indigo-300");
      }
    },
    dragleave(event) {
      // Clean up
      event.currentTarget.classList.add("bg-gray-100");
      event.currentTarget.classList.add("border-gray-300");
      event.currentTarget.classList.remove("bg-indigo-100");
      event.currentTarget.classList.remove("border-indigo-300");
    },
    drop(event) {
      event.preventDefault();
      this.$refs.file.files = event.dataTransfer.files;
      this.onChange(); // Trigger the onChange event manually
      // Clean up
      this.dragleave(event);
      console.log(this.filelist);
    },
  },
};
</script>