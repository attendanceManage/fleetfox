<template>
    <div  v-if="show"
          class="fixed inset-0 bg-black bg-opacity-10 flex items-center justify-center z-10"
    >
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button
                @click="$emit('cancel')"
                class="absolute top-2 right-2 text-gray-500 hover:text-black text-xl"
            >
                ×
            </button>
            <div class="text-xl font-semibold mb-4 text-orange-600">
                 Task Complete Status
            </div>
            <div>
                <form @submit.prevent="submitEdit">
                    <div class="mt-4 space-y-4">
                        <!-- First Toggle -->

                        <div class="flex items-center space-x-3 ">
                                              <span class="text-sm font-medium text-gray-700  mr-2 ">
                                                Task Completed
                                            </span>
                            <label class="inline-flex items-center cursor-pointer relative">
                                <input
                                    type="checkbox"
                                    v-model="form.is_done"
                                    class="sr-only peer"
                                />
                                <div
                                    class="w-11 h-6 bg-gray-300 peer-checked:bg-orange-600 rounded-full transition-colors duration-300"
                                ></div>
                                <div
                                    class="absolute w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-5 transition-transform duration-300 ml-1 mt-0.5"
                                ></div>
                            </label>
                        </div>

                    </div>

                    <PrimaryButton
                        class="w-half  inline-flex items-center justify-center p-0.5 text-sm font-medium rounded-lg group bg-gradient-to-br from-orange-400 to-orange-500 mt-2">
                        Save
                    </PrimaryButton>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import InputModal from "@/Components/InputModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";


export default {
    components: {InputError, PrimaryButton, InputModal},
    props: {
        show: Boolean,
        task: {
            type: Object,
            required: true,
        }
    },
    emits: ["save", "cancel"],
    data() {
        return {
            form: {
                is_done: '',
            },
        };
    },
    watch: {
        task(newVal) {
            this.form.is_done = (newVal.is_done==1)?false:true;

        },
    },
    methods: {
        submitEdit() {

            this.$emit("save", {...this.form, id: this.task.id});
        },
        cancel() {
            this.$emit("cancel");
        },
        updateCategory() {
            // Emit 'updateCategory' event with the category id
            this.$emit('updateCategory');
        }
    },
};
</script>
