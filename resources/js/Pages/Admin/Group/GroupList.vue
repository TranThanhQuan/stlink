<template>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <!-- dialog for adding or editing group -->
        <el-dialog v-model="dialogVisible" :title="editMode ? 'Chỉnh Sửa nhóm' : 'Tạo nhóm'" width="50%"
            :before-close="handleClose">
            <!-- form  start -->
            <form class="mx-auto" @submit.prevent="editMode ? Updategroup() : Addgroup()">
                <!-- title -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" v-model="title" name="floating_title" id="floating_title"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="floating_title"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-2">Tiêu
                        đề</label>
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Gửi</button>
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
                    <!-- <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-4 py-3">Tên nhóm</th>
                                <th scope="col" class="px-4 py-3 text-center">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">#1</td>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"> Admin</th>

                                <td class="px-4 py-3 text-blue-900 font-bold text-center">

                                    <Link :href="route('admin.groups.permission', { id: 1 })"
                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            Phân quyền </Link>

                                    <button @click="openEditModal(group)"
                                        class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                                        Chỉnh sửa
                                    </button>

                                    <button  @click="deleteLink(group, index)"
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                        Xóa
                                    </button>

                                </td>



                            </tr>

                        </tbody>


                    </table> -->

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

                                <!-- <td class="px-4 py-3 text-blue-900 font-bold">
                                    <a :href="route('admin.groups.view', { id: group.id })"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Xem</a>
                                </td> -->




                                <td class="px-4 py-3 flex items-center justify-end">
                                    <!-- Nút Dropdown -->
                                    <button :id="`${group.id}-dropdown-button`"
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
                                    <div :id="`${group.id}-dropdown`"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="`${group.id}-dropdown-button`">
                                            <!-- <li>
                                                <a :href="route('admin.groups.view', { id: group.id })"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Chi
                                                    tiết</a>
                                            </li> -->
                                            <li>
                                                <!-- <button @click="openEditModal(group)"
                                                    class="block w-full py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-left">
                                                    Phân quyền
                                                </button> -->

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
import { Link } from '@inertiajs/vue3';


defineProps({
    groups: Array,
});

// const groups = [
//     { id: 1, name: 'Admin'},
//     { id: 2, name: 'CTV'},
//     { id: 3, name: 'user'},

// ]

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
    title.value = group.title;
    original_group.value = group.original_url;
    custom_halfback.value = group.short_code;
    endDate.value = group.expires_at;
}


// add group method
const Addgroup = async () => {
    const formData = new FormData(); // tạo form

    formData.append('title', title.value);
    formData.append('original_group', original_group.value);
    formData.append('short_code', halfback.value);
    formData.append('endDate', endDate.value);


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

                }
            },
        });
    } catch (e) {
        console.log(e);
    }

}


// reset data after add
const resetFormData = () => {
    title.value = '';
    original_group.value = '';
    custom_halfback.value = '';
    endDate.value = [];
}



const id = ref('');

// update group method
const Updategroup = async () => {
    const formData = new FormData(); // tạo form

    formData.append('title', title.value);
    formData.append('original_group', original_group.value);
    formData.append('short_code', halfback.value);
    formData.append('endDate', endDate.value);
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
const deletegroup = (group, index) => {
    Swal.fire({
        title: 'Bạn có muốn xóa group?',
        text: "Không thể hoàn tác hành động này!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Có, Hãy xóa!',
        cancelButtonText: 'Hủy!'

    }).then((result) => {
        if (result.isConfirmed) {
            try {
                router.delete('groups/destroy/' + group.id, group, {
                    onSuccess: (page) => {
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            position: 'top',
                            showConfirmButton: false,
                            title: page.props.flash.success,
                        });
                        this.delete(product, index);
                    }

                });
            } catch (e) {
                console.log(e);
            }
        }
    });
};



</script>
