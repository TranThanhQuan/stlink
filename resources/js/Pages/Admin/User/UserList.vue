<template>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <!-- dialog or editing user -->
        <el-dialog v-model="dialogVisible" title="Chỉnh Sửa thông tin người dùng" width="50%"
            :before-close="handleClose">
            <!-- form  start -->
            <form class="mx-auto" @submit.prevent="UpdateUser()">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <!-- name -->
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" v-model="name" name="floating_name" id="floating_name"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " required />
                        <label for="floating_name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-2">Tên người dùng</label>
                    </div>

                    <!-- email -->
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" v-model="email" name="floating_email" id="floating_email"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " />
                        <label for="floating_email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-2">Email</label>
                    </div>
                </div>


                <div class="grid md:grid-cols-2 md:gap-6">

                    <!-- vai trò -->
                    <div class="relative z-0 w-full group">
                        <form class="mx-auto">
                            <label for="isAdmin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Vai trò
                            </label>
                            <select v-model="isAdmin" id="isAdmin" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value=0>Người dùng (User)</option>
                                <option value=1>Quản trị (Admin)</option>
                            </select>
                        </form>
                    </div>

                    <!-- Nhóm người dùng -->
                    <div class="relative z-0 w-full group">
                        <form class="mx-auto">
                            <label for="group" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nhóm người dùng
                            </label>
                            <select id="group" v-model="selectedGroup"
                                class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Chọn nhóm</option>
                                <option v-for="group in groupFillted" :value="group.id">
                                    {{ group.name }}
                                </option>
                            </select>

                        </form>
                    </div>
                </div>

                <!-- Trạng thái -->
                <div class="relative z-0 w-full mb-5 group">
                    <form class="mx-auto">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Trạng thái
                        </label>
                        <select v-model="status" id="status" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value=1>Hoạt động</option>
                            <option value=0>Không hoạt động</option>
                        </select>
                    </form>
                </div>


                <!-- password -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" v-model="password" name="floating_password" id="floating_password"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="floating_password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-2">password</label>
                </div>


                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Lưu</button>
            </form>
        </el-dialog>
        <!-- end dialog for adding or editing user -->

        <div class="mx-auto px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Tìm kiếm</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Tìm kiếm" required="">
                            </div>
                        </form>
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">

                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                    class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Lọc
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <div id="filterDropdown"
                                class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Vai trò</h6>
                                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                    <li class="flex items-center">
                                        <input id="admin" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="admin"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Quản trị
                                            </label>
                                    </li>

                                    <li class="flex items-center">
                                        <input id="User" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="User" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Người dùng
                                            </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-4 py-3">Tên người dùng</th>
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">Nhóm</th>

                                <th scope="col" class="px-4 py-3">Trạng thái</th>
                                <!-- <th scope="col" class="px-4 py-3">Thời gian tạo</th> -->

                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id" class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">#{{ user.id }}</td>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                    truncate(user.name)}}</th>

                                <td class="px-4 py-3 text-blue-900 font-bold">
                                    <a :href="user.original_url" target="_blank" rel="noopener noreferrer">
                                        {{ truncate(user.email) }}
                                    </a>
                                </td>


                                <td class="px-4 py-3">
                                    <span v-if="user.group.isAdmin == 1" class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">{{user.group.name}}</span>

                                    <span v-else  class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300">{{user.group.name}}</span>
                                </td>


                                <td class="px-4 py-3">
                                    <span v-if="user.status == 1" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">Hoạt động</span>

                                    <span v-else class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">Không hoạt động</span>
                                </td>


                                <!-- <td class="px-4 py-3">{{ formatDate(user.created_at) }}</td> -->




                                <td class="px-4 py-3 flex items-center justify-end">
                                    <!-- Nút Dropdown -->
                                    <button :id="`${user.id}-dropdown-button`"
                                        :data-dropdown-toggle="`${user.id}-dropdown`"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div :id="`${user.id}-dropdown`"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="`${user.id}-dropdown-button`">
                                            <!-- <li>
                                                <a :href="route('admin.users.view', { id: user.id })"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Chi
                                                    tiết</a>
                                            </li> -->
                                            <li>
                                                <button @click="openEditModal(user)"
                                                    class="block w-full py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-left">
                                                    Chỉnh sửa
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" @click="deleteUser(user, index)"
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

                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>



            </div>
        </div>
    </section>
</template>


<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed, onMounted } from 'vue';


const props = defineProps({
    users: Array,
});

const groups = usePage().props.groups;

const truncate = (text) => {
    return text.length > 20 ? text.slice(0, 20) + '...' : text;
};

const dialogVisible = ref(false);
const handleClose = () => {
    dialogVisible.value = false;
};


//user form data
const name = ref("");
const email = ref("");
const password = ref("");
const isAdmin = ref(null);
const status = ref(0);

//end user form data

const selectedGroup = ref(0);
const groupFillted = ref([]);
watch(isAdmin, (newValue) => {
    isAdmin.value = Number(newValue);
    groupFillted.value = groups.filter(g => Number(g.isAdmin) === Number(isAdmin.value));

    // Nếu selectedGroup không tồn tại trong groupFillted, đặt lại nó
    if (!groupFillted.value.some(g => g.id === selectedGroup.value)) {
        selectedGroup.value = "";
    }
});


//open edit modal
const openEditModal = (user) => {
    dialogVisible.value = true;

    //fill data user
    id.value = user.id;
    name.value = user.name;
    email.value = user.email;
    isAdmin.value = user.group.isAdmin;
    selectedGroup.value = user.group_id;
    status.value = user.status;
}

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleString('vi-VN', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    hour12: false,
  });
};



const id = ref('');

// update user method
const UpdateUser = async () => {
    const formData = new FormData(); // tạo form

    formData.append('name', name.value);
    // formData.append('original_user', original_user.value);
    formData.append('email', email.value);
    formData.append('isAdmin', isAdmin.value);
    formData.append('group_id', selectedGroup.value);
    formData.append('status', status.value);

    formData.append("_method", 'PUT');
    //

    try {
        await router.post('users/update/' + id.value, formData, {
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


//delete user
const deleteUser = (user, index) => {
    Swal.fire({
        title: 'Bạn có muốn xóa user?',
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
                router.delete('users/destroy/' + user.id, user, {
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

<style lang="scss" scoped>
@import "https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css";
</style>
