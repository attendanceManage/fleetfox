<script setup>
import {computed, ref, onMounted, defineEmits} from 'vue';
import {Head, Link, router, useForm, usePage} from '@inertiajs/vue3';


import SortIcon from '@/Components/SortIcon.vue';
import Pagination from '@/Components/Pagination.vue';
import LayoutHeaderMobile from "@/Components/LayoutHeaderMobile.vue";
import SubHeader from "@/Components/SubHeader.vue";
import LayoutHeader from "@/Components/LayoutHeader.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import InputModal from "@/Components/InputModal.vue";
import InputError from "@/Components/InputError.vue";
import Toast from "@/Components/Toast.vue";
import ConfirmModal from "@/Components/ConfirmModal.vue";
import EditCategoryModal from "@/Pages/Categories/Edit.vue";

const props = defineProps({
    categories: Object,
    filters: Object,
});

const filters = ref({...props.filters});

function sortBy(field) {
    let direction = 'asc';
    if (filters.value.sort === field && filters.value.direction === 'asc') {
        direction = 'desc';
    }
    router.get(route('categories'), {sort: field, direction, page: 1}, {preserveState: true, replace: true});
}

function changePage(page) {
    router.get(route('categories'), {...filters.value, page}, {preserveState: true, replace: true});
}

const showModal = ref(false)

const closeModal = () => {
    showModal.value = false

}


const form = useForm({
    title: '',
    description: '',
    status: ''
})
const page = usePage()

const successMessage = ref(false)
const createsuccessMessage = ref(false)
const deleteMessage = ref(false)

onMounted(() => {
    resetFlashSuccess();
})

const flashSuccess = () => {
    createsuccessMessage.value = true
}
const resetFlashSuccess = () => {
    createsuccessMessage.value = false
}
const submit = () => {

    form.post(route('categories.store'), {
        onSuccess: () => {
            form.reset()
            closeModal()
            flashSuccess()

        }
    })
}

const confirmModalVisible = ref(false)
const cateId = ref('')
const categoryToEdit = ref('')
const editModalVisible = ref(false)

const emit = defineEmits(['refreshCategories'])

const deleteCategory = (categoryId => {

    confirmModalVisible.value = true;
    cateId.id = categoryId;


})


const updateCategory = (categoryId => {
    successMessage.value = true;
    cateId.id = categoryId;
  //  deleteMessage.value = false;
})
const handleConfirm = () => {

    form.delete(route('categories.destroy', {id: cateId.id}), {
        onSuccess: () => {
            emit('deleteCategory', cateId.id)
            confirmModalVisible.value = false;
            deleteMessage.value = true;
        }
    })
}
const openEdit = (category) => {

    categoryToEdit.value = category;
    editModalVisible.value = true;
}

const handleSave = (updatedCategory) => {

    const id = updatedCategory.id;
    successMessage.value = false;
    axios.patch(   `/categories/${id}`,updatedCategory)
        .then(response => {
            console.log('Success:', response);
            successMessage.value = true;
            emit('updateCategory');
        });

    editModalVisible.value = false;
}

</script>
<template>
    <Head title="Categories"/>
    <div class="flex bg-gray-100 dark:bg-gray-900 dark:text-white min-h-screen font-sans">
        <LayoutHeader/>
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <SubHeader title="Categories"/>
            <!-- Page Content -->
            <div>

                <div class="mx-auto max-w-full sm:px-6 sm:py-24 lg:max-w-7xl">
                    <div class="mb-2 flex items-center justify-end">

                        <PrimaryButton @click="showModal = true"
                                       class="w-half  inline-flex items-center justify-center p-0.5 text-sm font-medium rounded-lg group bg-gradient-to-br from-orange-400 to-orange-500">
                            Create Category
                        </PrimaryButton>
                        <Modal v-if="showModal" @close="closeModal">
                            <template #title>Create Category</template>
                            <template #content>
                                <form @submit.prevent="submit">
                                    <div class="mt-4">
                                        <InputModal
                                            label="Title"
                                            id="title"
                                            type="text"
                                            class="mt-1 block w-full text-blue-950 "
                                            v-model="form.title"
                                            required
                                        />

                                        <InputError class="mt-2" :message="form.errors.title"/>
                                    </div>
                                    <div class="mt-4">
                                        <InputModal
                                            label="Description"
                                            id="description"
                                            type="textarea"
                                            class="mt-1 block w-full "
                                            v-model="form.description"
                                            required
                                        />

                                        <InputError class="mt-2" :message="form.errors.description"/>
                                    </div>

                                    <div class="mt-4 space-y-4">
                                        <!-- First Toggle -->

                                        <div class="flex items-center space-x-3 ">
                                            <span class="text-sm font-medium text-gray-700  mr-2 ">
                                                Status
                                            </span>
                                            <label class="inline-flex items-center cursor-pointer relative">
                                                <input
                                                    type="checkbox"
                                                    v-model="form.status"
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

                            </template>
                        </Modal>
                        <Toast v-if="createsuccessMessage" message="Category created successfully!" type="success"/>
                        <Toast v-if="successMessage" message="Category updated successfully!" type="success"/>
                        <Toast v-if="deleteMessage" message="Category Deleted successfully!" type="success"/>


                    </div>


                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-300">
                            <thead>
                            <tr class="bg-gray-100">
                                <th
                                    class="border border-gray-300 px-6 py-3 cursor-pointer select-none"
                                    @click="sortBy('title')">
                                    <div class="flex items-center space-x-1">
                                        <span>Title</span>
                                        <SortIcon :field="'title'" :currentSort="filters.sort"
                                                  :direction="filters.direction"/>
                                    </div>
                                </th>
                                <th
                                    class="border border-gray-300 px-6 py-3 cursor-pointer select-none"
                                    @click="sortBy('created_at')">
                                    <div class="flex items-center space-x-1">
                                        <span>Created At</span>
                                        <SortIcon :field="'created_at'" :currentSort="filters.sort"
                                                  :direction="filters.direction"/>
                                    </div>
                                </th>
                                <th class="border border-gray-300 px-6 py-3 cursor-pointer select-none">
                                    <div class="flex items-center space-x-1">
                                        <span>Status</span>
                                    </div>
                                </th>
                                <th class="border border-gray-300 px-6 py-3 cursor-pointer select-none">
                                    <div class="flex items-center space-x-1">
                                        <span>Action</span>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="categories.data.length > 0" v-for="category in categories.data" :key="category.id"
                                class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-6 py-4">{{ category.title }}</td>
                                <td class="border border-gray-300 px-6 py-4">
                                    {{ new Date(category.created_at).toLocaleDateString() }}
                                </td>
                                <td class="border border-gray-300 px-6 py-4">
                            <span
                                class="inline-block px-3 py-1 text-sm font-medium border rounded-full border-gray-300 text-gray-700 bg-green-100 text-green-600"
                                v-if="category.status==0">
                                Active
                            </span>
                                    <span
                                        class="inline-block px-3 py-1 text-sm font-medium border rounded-full border-gray-300 text-gray-500 text-red-600"
                                        v-else>Inactive</span>
                                </td>
                                <td class="border border-gray-300 px-6 py-4">

                                    <!-- Edit Button with Icon -->
                                    <button
                                        class="inline-block px-3 py-1 text-sm font-medium border rounded-full border-blue-950  text-blue-950"
                                        @click="openEdit(category)">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6H9v-2l6-6z"/>
                                        </svg>
                                    </button>

                                    <span>&nbsp;&nbsp;</span>
                                    <button
                                        class="inline-block  px-3 py-1 text-sm font-medium border rounded-full border-orange-500  text-orange-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                             @click="deleteCategory(category.id)"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                    <!-- Delete Button with Icon -->
                                </td>

                                <EditCategoryModal
                                    :show="editModalVisible"
                                    :category="categoryToEdit"
                                    @save="handleSave"
                                    @cancel="editModalVisible = false"
                                />
                                <!-- Confirmation Modal -->
                                <ConfirmModal
                                    :show="confirmModalVisible"
                                    title="Delete Category"
                                    message="Are you sure you want to delete this category?"
                                    @confirm="handleConfirm"
                                    @cancel="confirmModalVisible = false"
                                />

                            </tr>
                            <tr v-else>No,Data</tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :links="categories.links" @page-change="changePage"/>
                </div>
            </div>
        </div>
        <LayoutHeaderMobile/>
    </div>
</template>



