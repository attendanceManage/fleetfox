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
                Assign Category To Task
            </div>
            <div>
                <form @submit.prevent="submitEdit">
                    <select v-model="task.category_id" class="w-full p-2 border border-gray-300 rounded-md mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option v-for="cate in category" :key="cate.id" :value="cate.id">
                            {{ cate.title }}
                        </option>
                    </select>
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
        },
        category: {
            type: Object,
            required: true,
        },
    },
    emits: ["save", "cancel"],
    data() {
        return {
            form: {
                category_id: '',
            },
        };
    },
    watch: {
        task(newVal) {
            this.form.title = newVal.title || "";
            this.form.description = newVal.description || "";
            this.form.status = (newVal.status==1)?false:true;
            this.form.is_done = (newVal.status==1)?false:true;
            this.form.due_date = newVal.due_date;
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
