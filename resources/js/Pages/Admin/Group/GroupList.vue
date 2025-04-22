<template>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <!-- dialog for adding or editing group -->
        <el-dialog v-model="dialogVisible" :title="editMode ? 'Chỉnh Sửa nhóm' : 'Tạo nhóm'" width="50%"
            :before-close="handleClose">
            <!-- form  start -->
            <form class="mx-auto" @submit.prevent="editMode ? Updategroup() : Addgroup()">
                <!-- title -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" v-model="name" name="floating_name" id="floating_name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="floating_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-2">Tên nhóm</label>
                </div>

                <!-- title -->
                <div  class="relative z-0 mb-5 group">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white mb-2 block">
                            Quyền quản trị (admin)
                        </label>
                        <label class="inline-flex items-center mt-2 cursor-pointer">
                            <input type="checkbox" v-model="isAdmin" class="sr-only peer" />
                            <div class="relative w-12 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                            dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700
                            peer-checked:after:translate-x-6 rtl:peer-checked:after:-translate-x-full
                            peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px]
                            after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all
                            dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                {{ isAdmin ? 'Có' : 'Không' }}
                            </span>
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tạo</button>
            </form>
        </el-dialog>

        <!-- end dialog for adding or editing group -->

        <div class="mx-auto px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">

                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button @click="openAddModal" type="button"
                            class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">

                            Tạo nhóm
                            <svg class="w-4 h-4 text-white-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>

                        </button>

                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-4 py-3">Tên nhóm</th>
                                <th scope="col" class="px-4 py-3">Người tạo</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="group in groups" :key="group.id" class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">#{{ group.id }}</td>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ group.name }}</th>

                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ group.user.name }}</th>

                                <td class="px-4 py-3 flex items-center justify-end">
                                    <!-- Nút Dropdown -->
                                    <button v-if="group.id !== 1" :id="`${group.id}-dropdown-button`"
                                        :data-dropdown-toggle="`${group.id}-dropdown`"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div v-if="group.id !== 1" :id="`${group.id}-dropdown`"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="`${group.id}-dropdown-button`">

                                            <li>
                                                <a :href="route('admin.groups.permission', { id: group.id })"
                                                    class="block w-full py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-left">Chỉnh sửa</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" @click="deleteGroup(group, index)"
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                Xóa
                                            </a>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </section>
</template>



<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import { router, usePage , Link } from '@inertiajs/vue3';


defineProps({
    groups: Array,
});
const dialogVisible = ref(false);
const isAddgroup = ref(false);
const editMode = ref(false);

const handleClose = () => {
    dialogVisible.value = false;
};

//form data
const name = ref('');
const isAdmin = ref(false);

//open add modal
const openAddModal = () => {
    isAddgroup.value = true;
    dialogVisible.value = true;
    editMode.value = false;
}


//open edit modal
const openEditModal = (group) => {
    editMode.value = true;
    isAddgroup.value = false;
    dialogVisible.value = true;

    //fill data group
    id.value = group.id;
}


// add group method
const Addgroup = async () => {
    const formData = new FormData(); // tạo form
    formData.append('name', name.value);
    formData.append('isAdmin', isAdmin.value === true ? 1 : 0);

    try {
        await router.post('groups/store', formData, {
            onSuccess: (page) => {
                if (page.props.flash.success) {
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        position: 'top',
                        showConfirmButton: false,
                        title: page.props.flash.success,
                        timer: 5000,
                        timerProgressBar: true,
                    });

                    dialogVisible.value = false;
                    resetFormData();
                }
            },
            onError: (errors) => {
                if (errors) {
                    let errorMessages = Object.values(errors).flat().join('<br>');

                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        timer: 5000,
                        timerProgressBar: true,
                        position: 'top',
                        showConfirmButton: false,
                        title: 'Đã xảy ra lỗi!',
                        html: errorMessages,
                    });
                    dialogVisible.value = false;

                }
            },
        });
    } catch (e) {
        console.log(e);
    }

}


// reset data after add
const resetFormData = () => {
    name.value = '';

}



const id = ref('');

// update group method
const Updategroup = async () => {
    const formData = new FormData(); // tạo form

    formData.append('name', name.value);
    formData.append("_method", 'PUT');
    //


    try {
        await router.post('groups/update/' + id.value, formData, {
            onSuccess: (page) => {
                if (page.props.flash.success) {
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        position: 'top',
                        showConfirmButton: false,
                        title: page.props.flash.success,
                    });

                    dialogVisible.value = false;
                    resetFormData();
                }
            },
            onError: (errors) => {
                if (errors) {
                    let errorMessages = Object.values(errors).flat().join('<br>');

                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        position: 'top',
                        showConfirmButton: false,
                        title: 'Đã xảy ra lỗi!',
                        html: errorMessages,
                    });
                    dialogVisible.value = false;
                    resetFormData();

                }
            },
        });
    } catch (e) {
        console.log(e);
    }
}


//delete group
const deleteGroup = (group, index) => {
    Swal.fire({
        title: 'Bạn có muốn xóa nhóm <br>"'+group.name+'" ?',
        text: "Hành động này sẽ xóa tất cả thành viên trong nhóm!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Có, Hãy xóa!',
        cancelButtonText: 'Hủy!'

    }).then((result) => {
        if (result.isConfirmed) {
            try {
                router.delete('groups/destroy/' + group.id, {
                    onSuccess: (page) => {
                        if (page.props.flash.success) {
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                position: 'top',
                                showConfirmButton: false,
                                title: page.props.flash.success,
                                timer: 5000,
                                timerProgressBar: true,
                            });

                            dialogVisible.value = false;
                        }
                    },
                    onError: (errors) => {
                        if (errors) {
                            let errorMessages = Object.values(errors).flat().join('<br>');

                            Swal.fire({
                                toast: true,
                                icon: 'error',
                                position: 'top',
                                showConfirmButton: false,
                                title: 'Đã xảy ra lỗi!',
                                html: errorMessages,
                                timer: 5000,
                                timerProgressBar: true,
                            });
                            dialogVisible.value = false;
                        }
                    },
                });
            } catch (e) {
                console.log(e);
            }
        }
    });
};



</script>

<style lang="scss" scoped>

::v-deep(.el-dialog) {
  @apply bg-white dark:bg-gray-900;
}

::v-deep(.el-dialog__title) {
  @apply text-gray-900 dark:text-white;
}
</style>
