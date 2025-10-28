<template>
  <div class="inline">
    <figure 
      @click="triggerImageInput"
      class="flex items-center justify-center rounded-lg border-2 border-dashed border-gray-300 dar:border-gray-600 w-full h-48 cursor-pointer relative bg-gray-50 dar:bg-gray-900 hover:border-indigo-500 dar:hover:border-indigo-400 hover:bg-gray-100 dar:hover:bg-gray-800 transition duration-150 ease-in-out"
    >
      <i 
        v-if="image && canDelete" 
        @click.stop="clearImage"
        class="fa-solid fa-xmark absolute p-1.5 top-2 right-2 z-10 text-sm bg-white dar:bg-gray-800 text-gray-700 dar:text-gray-300 rounded-full cursor-pointer hover:bg-gray-200 dar:hover:bg-gray-700"
        aria-label="Quitar imagen"
      ></i>
      
      <div v-if="!image" class="flex flex-col items-center text-gray-400 dar:text-gray-500">
        <i class="fa-solid fa-camera text-3xl"></i>
        <span class="mt-2 text-sm">Click para subir</span>
      </div>
      
      <img 
        v-if="image" 
        :src="image" 
        :alt="alt" 
        class="w-full h-full object-contain bg-no-repeat rounded-md p-1" 
      />
      
      <input 
        ref="fileInput" 
        type="file" 
        @change="handleImageUpload" 
        class="hidden" 
        accept="image/*" 
      />
    </figure>
  </div>
</template>

<script>
export default {
  data() {
    return {
      image: null,
      formData: {
        file: null,
      },
    };
  },
  props: {
    alt: {
      type: String,
      default: "Vista previa no disponible",
    },
    canDelete: {
      type: Boolean,
      default: true,
    },
    imageUrl: {
      type: String,
      default: null,
    },
  },
  watch: {
    imageUrl: {
      immediate: true,
      handler(newImageUrl) {
        this.image = newImageUrl;
      },
    },
  },
  emits: ['imagen', 'cleared'],
  methods: {
    triggerImageInput() {
      this.$refs.fileInput.click();
    },
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (!file) return;

      this.formData.file = file;
      
      const imageURL = URL.createObjectURL(file);
      this.image = imageURL;
      // Emitir evento al componente padre con la imagen
      this.$emit("imagen", file);
    },
    clearImage() {
      this.image = null;
      this.formData.file = null;
      // Limpiar el valor del input para permitir subir el mismo archivo de nuevo
      this.$refs.fileInput.value = ''; 
      this.$emit("cleared");
      this.$emit("imagen", null); // Informar que la imagen se ha quitado
    },
  },
};
</script>
