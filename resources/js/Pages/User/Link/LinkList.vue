<template>
    <section class="bg-gray-50 dark:bg-gray-900 p-3">
        <!-- dialog for adding or editing link -->
        <el-dialog v-model="dialogVisible" :title="editMode ? 'Chỉnh Sửa Link' : 'Tạo Link Rút Gọn'" width="50%"
            :before-close="handleClose">
            <!-- form  start -->
            <form class="mx-auto" @submit.prevent="editMode ? UpdateLink() : AddLink()">
                <!-- title -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" v-model="title" name="floating_title" id="floating_title"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="floating_title"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-2">Tiêu
                        đề</label>
                </div>

                <!-- original link -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" v-model="original_link" name="floating_original_link" id="floating_original_link"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="floating_original_link"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-2">Link
                        gốc</label>
                </div>

                <!-- halfback -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" v-model="custom_halfback" name="floating_custom_halfback"
                        id="floating_custom_halfback"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="floating_custom_halfback"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-3 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-2">Tùy
                        chỉnh Half-back</label>
                </div>



                <!-- date -->

                <div v-if="editMode && new Date(endDate) > new Date()" class="relative z-0 mb-5 group">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white mb-2 block">
                            Trạng thái
                        </label>
                        <label class="inline-flex items-center mt-2 cursor-pointer">
                            <input type="checkbox" v-model="isPublic" class="sr-only peer" />
                            <div class="relative w-12 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                            dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700
                            peer-checked:after:translate-x-6 rtl:peer-checked:after:-translate-x-full
                            peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px]
                            after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all
                            dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                {{ isPublic ? 'Công khai' : 'Riêng tư' }}
                            </span>
                        </label>
                    </div>
                </div>

                <div v-if="editMode && new Date(endDate) <= new Date()" class="relative z-0 w-full mb-5 group">
                    <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">Link đã hết hạn. Vui lòng liên hệ quản trị viên để gia hạn</span>
                </div>




                <div class="relative z-0 w-full mb-5 group">
                    <span >Link rút gọn: </span>
                    <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">
                        https://{{ domain }}/{{ userPrefix }}{{ halfback }}
                    </span>

                </div>

                <div class="mb-5" v-if="!editMode">
                    <p class="text-red-600">Link có thời hạn 30 ngày kể từ ngày tạo.</p>
                </div>


                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ editMode ? 'Lưu' : 'Tạo' }}</button>
            </form>
        </el-dialog>

        <!-- end dialog for adding or editing link -->

        <div class="mx-auto">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">

                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button @click="openAddModal" type="button"
                            class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">

                            Tạo link
                            <svg class="w-4 h-4 text-white-800 dark:text-white ml-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>

                        </button>
                        <!-- <div class="flex items-center space-x-3 w-full md:w-auto">


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
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Chọn trạng thái</h6>
                                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                    <li class="flex items-center">
                                        <input id="apple1" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="apple1"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            Công khai ({{ statusCounts.active }})
                                            </label>
                                    </li>

                                    <li class="flex items-center">
                                        <input id="apple2" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="apple2"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Riêng tư ({{ statusCounts.inactive }})
                                            </label>
                                    </li>

                                    <li class="flex items-center">
                                        <input id="apple3" type="checkbox" value=""
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="apple3"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"> Hết hạn ({{ statusCounts.expired }})
                                            </label>
                                    </li>

                                </ul>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-4 py-3">Tiêu đề</th>
                                <th scope="col" class="px-4 py-3">Link gốc</th>
                                <th scope="col" class="px-4 py-3">Link rút gọn</th>
                                <th scope="col" class="px-4 py-3">Trạng thái</th>
                                <th scope="col" class="px-4 py-3">Thời gian hết hạn</th>

                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="link in links.data" :key="link.id" class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">#{{ link.id }}</td>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                    truncate(link.title)}}</th>

                                <td class="px-4 py-3 text-blue-900 dark:text-blue-200 font-bold">
                                    <a :href="link.original_url" target="_blank" rel="noopener noreferrer">
                                        {{ truncate(link.original_url) }}
                                    </a>
                                </td>

                                <td class="px-4 py-3">
                                    <a :href="`https://${domain}/${link.short_code}`">
                                        https://{{ domain }}/{{ link.short_code }}
                                    </a>
                                </td>

                                <td class="px-4 py-3">
                                    <button v-if="link.status == true" type="button"
                                        class="px-3 py-2 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Công khai</button>

                                    <button v-else-if="link.status == false" type="button"
                                            class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Riêng tư</button>

                                    <button v-else type="button"
                                        class="px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Hết
                                        hạn</button>
                                </td>

                                <td class="px-4 py-3">{{ link.expires_at_format }}</td>

                                <td class="px-4 py-3 flex items-center justify-end">
                                    <!-- Nút Dropdown -->
                                    <button :id="`${link.id}-dropdown-button`"
                                        :data-dropdown-toggle="`${link.id}-dropdown`"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div :id="`${link.id}-dropdown`"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="`${link.id}-dropdown-button`">
                                            <li>
                                                <a target="_blank" :href="route('user.links.view', { id: link.id })"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Chi tiết</a>
                                            </li>
                                            <li>
                                                <button @click="openEditModal(link)"
                                                    class="block w-full py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-left">
                                                    Chỉnh sửa
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" @click="deleteLink(link, index)"
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

                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white">{{ links.from }}-{{ links.to }}</span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">{{ links.total }}</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <!-- Nút Previous -->
                        <li>
                            <a :href="links.prev_page_url ? route('user.links.index', { page: links.current_page - 1 }) : '#'"
                                :class="['flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300',
                                    links.prev_page_url ? 'hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' : 'cursor-not-allowed opacity-50']">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>

                        <!-- Số Trang -->
                        <li v-for="page in links.last_page" :key="page">
                            <a :href="route('user.links.index', { page })" :class="['flex items-center justify-center text-sm py-2 px-3 leading-tight border',
                                page === links.current_page
                                    ? 'z-10 text-primary-600 bg-primary-50 border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white'
                                    : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'
                            ]">
                                {{ page }}
                            </a>
                        </li>

                        <!-- Nút Next -->
                        <li>
                            <a :href="links.next_page_url ? route('user.links.index', { page: links.current_page + 1 }) : '#'"
                                :class="['flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300',
                                    links.next_page_url ? 'hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' : 'cursor-not-allowed opacity-50']">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
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
    links: Object,
    statusCounts: Object,
    userPrefix: String
});


const isPublic = ref(true);

const domain = ref(window.location.hostname);

//
const truncate = (text) => {
    return text.length > 25 ? text.slice(0, 25) + '...' : text;
};

const isAddLink = ref(false);
const editMode = ref(false);
const dialogVisible = ref(false);
const handleClose = () => {
    dialogVisible.value = false;
};



//link form data
const title = ref('');
const original_link = ref('');
const endDate = ref('');
const custom_halfback = ref("");
const random_halfback = ref("");

//end link form data


//tạo random halfback
const halfback = computed(() => {
    return custom_halfback.value ? custom_halfback.value : random_halfback.value;
});

watch(original_link, (newVal) => {
    if (newVal.trim() !== "") {
        random_halfback.value = generateRandomString(6);
    }
});

function generateRandomString(length) {
    const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    let result = "";
    for (let i = 0; i < length; i++) {
        result += chars.charAt(Math.floor(Math.random() * chars.length)).toLowerCase();
    }
    return result;
}


//open add modal
const openAddModal = () => {
    if(editMode.value){
        resetFormData();
    }
    isAddLink.value = true;
    dialogVisible.value = true;
    editMode.value = false;
}


//open edit modal
const openEditModal = (link) => {
    editMode.value = true;
    isAddLink.value = false;
    dialogVisible.value = true;

    //fill data link
    id.value = link.id;
    title.value = link.title;
    original_link.value = link.original_url;
    custom_halfback.value = link.short_code;
    endDate.value = link.expires_at;
    isPublic.value = link.status === 1 ? true : false;

}


// add link method
const AddLink = async () => {
    const formData = new FormData(); // tạo form

    formData.append('title', title.value);
    formData.append('original_link', original_link.value);
    formData.append('short_code', props.userPrefix+halfback.value);
    formData.append('status', isPublic.value);

    try {
        await router.post('/user/links/store', formData, {
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
    title.value = '';
    original_link.value = '';
    custom_halfback.value = '';
    endDate.value = [];
}



const id = ref('');

// update link method
const UpdateLink = async () => {
    const formData = new FormData(); // tạo form

    formData.append('title', title.value);
    formData.append('original_link', original_link.value);
    formData.append('short_code', halfback.value);
    formData.append('endDate', endDate.value);
    formData.append('status', isPublic.value ? 1 : 0);
    formData.append("_method", 'PUT');
    //


    try {
        await router.post('links/update/' + id.value, formData, {
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
                        position: 'top',
                        showConfirmButton: false,
                        title: 'Đã xảy ra lỗi!',
                        html: errorMessages,
                        timer: 5000,
                        timerProgressBar: true,
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


//delete link
const deleteLink = (link, index) => {
    Swal.fire({
        title: 'Bạn có muốn xóa link?',
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
                router.delete('links/destroy/' + link.id, {
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
@import "https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css";

::v-deep(.el-dialog) {
  @apply bg-white dark:bg-gray-900;
}

::v-deep(.el-dialog__title) {
  @apply text-gray-900 dark:text-white;
}
</style>
