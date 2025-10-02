<script setup>
import {computed, defineAsyncComponent, defineEmits, onMounted, ref} from 'vue';
import {Head, Link, router, usePage, useForm} from '@inertiajs/vue3';

import SortIcon from '@/Components/SortIcon.vue';
import Pagination from '@/Components/Pagination.vue';
import LayoutHeaderMobile from "@/Components/LayoutHeaderMobile.vue";
import SubHeader from "@/Components/SubHeader.vue";
import LayoutHeader from "@/Components/LayoutHeader.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

import Modal from "@/Components/Modal.vue";
import InputError from "@/Components/InputError.vue";
import InputModal from "@/Components/InputModal.vue";
import Toast from "@/Components/Toast.vue";
import EditCategoryModal from "@/Pages/Tasks/Edit.vue";
import ConfirmModalTask from "@/Components/ConfirmModal.vue";
import EditCategoryToTask from "@/Pages/Tasks/AssignCategory.vue";
import EditTaskDone from "@/Pages/Tasks/TaskDone.vue";

const page = usePage()
const props = defineProps({
    tasks: Object,
    categories: Object,
    filters: Object,
});


const filters = ref({...props.tasks});

function sortBy(field) {
    let direction = 'asc';
    if (filters.value.sort === field && filters.value.direction === 'asc') {
        direction = 'desc';
    }
    router.get(route('tasks'), {sort: field, direction, page: 1}, {preserveState: true, replace: true});
}


function changePage(page) {
    router.get(route('categories'), {...filters.value, page}, {preserveState: true, replace: true});
}

const showModal = ref(false)

const successMessage = ref(false)
const closeModal = () => {
    showModal.value = false
}

onMounted(() => {
    resetFlashSuccess();
})

const flashSuccess = () => {
    successMessage.value = true
}
const resetFlashSuccess = () => {
    successMessage.value = false
}

const form = useForm({
    title: '',
    description: '',
    category_id: '',
    due_date: '',
    is_done: '',
    status: ''
})

const submit = () => {
    form.post(route('tasks.store'), {
        onSuccess: () => {
            form.reset()
            closeModal()
            flashSuccess()
        }
    })
}

const date = ref('') // v-model on input

const formattedDate = computed(() => {
    if (!date.value) return ''
    const d = new Date(date.value)
    const year = d.getFullYear()
    const month = String(d.getMonth() + 1).padStart(2, '0')
    const day = String(d.getDate()).padStart(2, '0')
    return `${year}-${month}-${day}`
})

function handleDateChange() {
    console.log('Selected Date:', formattedDate.value)
}

const openEdit = (task) => {

    categoryToEdit.value = task;
    editModalVisible.value = true;
}

const openAssignCategory = (task) => {
    categoryToEdit.value = task;
    assignModalVisible.value = true;
}


const openTaskDone = (task) => {
    categoryToEdit.value = task;
    openTaskDoneModalVisible.value = true;
}


const createsuccessMessage = ref(false)
const updateuccessMessage = ref(false)
const deleteMessage = ref(false)
const confirmModalVisible = ref(false)
const TaskId = ref('')
const categoryToEdit = ref('')
const editModalVisible = ref(false)
const assignModalVisible = ref(false)
const openTaskDoneModalVisible = ref(false)


const emit = defineEmits(['refreshCategories'])
const handleSave = (updatedCategory) => {
    updateuccessMessage.value = false;
    const id = updatedCategory.id;
    axios.patch(`/tasks/${id}`, updatedCategory)
        .then(response => {
            console.log('Success:', response);
            updateuccessMessage.value = true;
            emit('updateTask');
            location.reload();
        });

    editModalVisible.value = false;
}

const handleCateSave = (updatedCategory) => {
    updateuccessMessage.value = false;
    const id = updatedCategory.id;

    axios.patch(`/tasks/${id}/category`, updatedCategory)
        .then(response => {
            console.log('Success:', response);
            updateuccessMessage.value = true;
            emit('updateTask');
            assignModalVisible.value = false;
            location.reload();
        });
}


const handleDropSave = (updatedCategory) => {
    updateuccessMessage.value = false;
    const id = updatedCategory.id;
    axios.patch(`/tasks/${id}/completed`, updatedCategory)
        .then(response => {
            console.log('Success:', response);
            updateuccessMessage.value = true;
            emit('updateTask');
            openTaskDoneModalVisible.value = false;
            location.reload();
        });
}

const deleteTask = (id => {

    confirmModalVisible.value = true;
    TaskId.id = id;


})
const handleConfirm = () => {

    form.delete(route('tasks.destroy', {id: TaskId.id}), {
        onSuccess: () => {
            emit('deleteTask', TaskId.id);
            confirmModalVisible.value = false;
            deleteMessage.value = true;
        }
    })
}

const filters2 = ref({
    category: props.filters.category || '',
})
const search = () => {
    router.get('/tasks', { category: filters2.value.category }, {
        preserveState: true,
        replace: true,
    })
}
</script>


<template>
    <Head title="Tasks"/>
    <div class="flex bg-gray-100 dark:bg-gray-900 dark:text-white min-h-screen font-sans">
        <LayoutHeader/>
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <SubHeader title="Tasks"/>
            <!-- Page Content -->

            <div>
                <div class="mx-auto max-w-full sm:px-6 sm:py-24 lg:max-w-7xl">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Filter by Category:</label>
                        <input
                            v-model="filters2.category"
                            @input="search"

                            placeholder="Enter Category "
                            class="mt-1 px-3 py-2 border border-gray-300 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                    <div class="mb-2 flex items-center justify-end">
                        <PrimaryButton @click="showModal = true"
                                       class="w-half  inline-flex items-center justify-center p-0.5 text-sm font-medium rounded-lg group bg-gradient-to-br from-orange-400 to-orange-500">
                            Create Task
                        </PrimaryButton>

                        <Modal v-if="showModal" @close="closeModal">
                            <template #title>Create Task</template>
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
                                    <div class="mt-4">
                                        <InputModal
                                            label="Due Date"
                                            id="due_date"
                                            type="date"
                                            class="mt-1 block w-full"
                                            v-model="form.due_date" @change="handleDateChange"
                                            required
                                        />

                                        <InputError class="mt-2" :message="form.errors.due_date"/>
                                    </div>
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
                        <Toast v-if="successMessage" message="Task created successfully!" type="success"/>
                        <Toast v-if="updateuccessMessage" message="Task Updated successfully!" type="success"/>
                        <Toast v-if="deleteMessage" message="Task Daleted successfully!" type="success"/>

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
                                >
                                    <div class="flex items-center space-x-1">
                                        <span>Due Date</span>

                                    </div>
                                </th>
                                <th
                                    class="border border-gray-300 px-6 py-3 cursor-pointer select-none">
                                    <div class="flex items-center space-x-1">
                                        <span>Due Date Status</span>

                                    </div>
                                </th>
                                <th class="border border-gray-300 px-6 py-3 cursor-pointer select-none">
                                    <div class="flex items-center space-x-1">
                                        <span>Is Complete</span>
                                    </div>
                                </th>
                                <th class="border border-gray-300 px-6 py-3 cursor-pointer select-none">
                                    <div class="flex items-center space-x-1">
                                        <span>Status</span>
                                    </div>
                                </th>
                                <th class="border border-gray-300 px-6 py-3 cursor-pointer select-none">
                                    <div class="flex items-center space-x-1">
                                        <span>Category</span>
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


                            <tr v-if="tasks.data.length > 0" v-for="task in tasks.data" :key="task.id"
                                class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-6 py-4">{{ task.title }}</td>
                                <td class="border border-gray-300 px-6 py-4">
                                    {{ new Date(task.due_date).toLocaleDateString() }}
                                </td>
                                <td class="border border-gray-300 px-6 py-4 ">
                                     <span
                                         class="animate-pulse inline-block px-3 py-1 text-sm font-medium border rounded-full border-gray-300 text-gray-500 text-red-600"
                                         v-if="task.due_status=='Due Soon'">{{ task.due_status }}</span>
                                    <span v-else
                                          class="inline-block px-3 py-1 text-sm font-medium border rounded-full border-gray-300 text-gray-700 bg-green-100 text-green-600"
                                    >
                                        {{ task.due_status }}
                                       </span>

                                </td>
                                <td class="border border-gray-300 px-6 py-4">
                            <span
                                class="inline-block px-3 py-1 text-sm font-medium border rounded-full border-gray-300 text-gray-700 bg-green-100 text-green-600"
                                v-if="task.is_done==0">
                                Completed
                            </span>
                                    <span
                                        class="inline-block px-3 py-1 text-sm font-medium border rounded-full border-gray-300 text-gray-500 text-red-600"
                                        v-else>Pending</span>
                             </td>
                                <td class="border border-gray-300 px-6 py-4">
                            <span
                                class="inline-block px-3 py-1 text-sm font-medium border rounded-full border-gray-300 text-gray-700 bg-green-100 text-green-600"
                                v-if="task.status==0">
                                Active
                            </span>
                                    <span
                                        class="inline-block px-3 py-1 text-sm font-medium border rounded-full border-gray-300 text-gray-500 text-red-600"
                                        v-else>Inactive</span>
                                </td>
                                <td class="border border-gray-300 px-6 py-4">
                                    <span>
                                        {{task.category_title}}

                                     </span>

                                </td>
                                <td class="border border-gray-300 px-6 py-4">

                                    <!-- Edit Button with Icon -->
                                    <button
                                        class="inline-block px-3 py-1 text-sm font-medium border rounded-full border-blue-950  text-blue-950"
                                        @click="openEdit(task)">
                                        <svg class="w-6 h-6 mr-2 text-blue-950" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6H9v-2l6-6z"/>
                                        </svg>
                                    </button>
                                    <span>&nbsp;&nbsp;</span>
                                    <span>
                                    <button
                                        class="inline-block  px-3 py-1 text-sm font-medium border rounded-full border-green-600  text-green-650"
                                        @click="openTaskDone(task)">
                                         <svg xmlns="http://www.w3.org/2000/svg"
                                              fill="currentColor"
                                              viewBox="0 0 24 24 mr-2"
                                              class="w-6 h-6 text-green-500">
                                      <path fill-rule="evenodd"
                                            d="M12 2a10 10 0 100 20 10 10 0 000-20zM10 14l6-6-1.41-1.41L10 11.17 8.41 9.59 7 11l3 3z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                       </button>
                                    </span>
                                    <span>&nbsp;&nbsp;</span>
                                    <span>
                                    <button
                                        class="inline-block  px-3 py-1 text-sm font-medium border rounded-full border-green-600  text-green-650"
                                        @click="openAssignCategory(task)">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500"
                                               fill="currentColor"
                                               viewBox="0 0 24 24 mr-2">
                                          <path
                                              d="M8 9a3 3 0 100-6 3 3 0 000 6zm5 0a1 1 0 100-2 1 1 0 000 2zm3 4a2 2 0 00-2-2H6a2 2 0 00-2 2v1h12v-1zm-3.586 3.414a1 1 0 00-1.414-1.414L10 17.586l-2.414-2.414a1 1 0 00-1.414 1.414l3.121 3.121a1 1 0 001.414 0l3.121-3.121z"/>
                                          </svg>
                                       </button>
                                    </span>
                                    <span>&nbsp;&nbsp;</span>
                                    <button @click="deleteTask(task.id)"
                                            class="inline-block  px-3 py-1 text-sm font-medium border rounded-full border-orange-500  text-orange-500">
                                        <svg class="w-6 h-6 text-orange-500 " fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                    <!-- Delete Button with Icon -->

                                </td>

                                <EditCategoryModal
                                    :show="editModalVisible"
                                    :task="categoryToEdit"
                                    @save="handleSave"
                                    @cancel="editModalVisible = false"
                                />

                                <EditCategoryToTask
                                    :show="assignModalVisible"
                                    :task="categoryToEdit"
                                    :category="categories"
                                    @save="handleCateSave"
                                    @cancel="assignModalVisible = false"
                                />

                                <EditTaskDone
                                    :show="openTaskDoneModalVisible"
                                    :task="categoryToEdit"
                                    @save="handleDropSave"
                                    @cancel="openTaskDoneModalVisible = false"
                                />

                                <ConfirmModalTask
                                    :show="confirmModalVisible"
                                    title="Delete Task"
                                    message="Are you sure you want to delete this task?"
                                    @confirm="handleConfirm"
                                    @cancel="confirmModalVisible = false"
                                />
                            </tr>
                            <tr v-else>No,Data</tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :links="tasks.links" @page-change="changePage"/>
                </div>
            </div>
        </div>
        <LayoutHeaderMobile/>
    </div>
</template>



