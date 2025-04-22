<template>
    <AdminLayout>
        <h1 class="my-3 text-4xl dark:text-white"> Chỉnh sửa nhóm: {{ group.name }}</h1>

        <form class="overflow-x-auto" @submit.prevent="PermissionGroup()">
        <!-- <div class="overflow-x-auto"> -->
            <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-900 dark:text-white">
                <th class="w-1/5 p-2 border border-gray-300 ">Module</th>
                <th class="p-2 border border-gray-300">Quyền</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="module in modules" :key="module.id" class="border border-gray-300">
                    <td class="p-2 border border-gray-300 dark:text-white">{{ module.title }}</td>
                    <td class="p-2 border border-gray-300 dark:text-white">
                        <div class="flex flex-wrap gap-4 ">
                            <div v-for="(roleLabel, roleName) in roleListArr" :key="roleName" class="w-1/6">
                                <label class="flex items-center gap-2 ">
                                    <input
                                        type="checkbox"
                                        :id="`role_${module.name}_${roleName}`"
                                        :name="`role[${module.name}][]`"
                                        :value="roleName"
                                        v-model="roleArr[module.name]"
                                        class="dark:text-black"
                                        />

                                    {{ roleLabel }}
                                </label>
                            </div>

                            <div v-if="module.name === 'groups'" class="w-1/4">
                                <label class="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        :id="`role_${module.name}_permission`"
                                        :name="`role[${module.name}][]`"
                                        value="permission"
                                        v-model="roleArr[module.name]"
                                        class="dark:text-black"
                                    />
                                    Phân quyền
                                </label>
                            </div>

                        </div>
                    </td>
                </tr>
            </tbody>
            </table>
        <!-- </div> -->
            <!--  -->
            <div class="my-3">
                <Link :href="route('admin.groups.index')"
                    class="my-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Trở về</Link>


                <button type="submit" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Lưu</button>


            </div>
        </form>



    </AdminLayout>

</template>

<script setup>
import AdminLayout from '../Components/AdminLayout.vue'
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';


const props = defineProps({
    group: Object,
    modules: Array,
    roleListArr: Object,
    roleArr: Object,
});



// update permission method
const PermissionGroup = async () => {
    const formData = new FormData(); // tạo form

    for (const moduleName in props.roleArr) {
        if (Array.isArray(props.roleArr[moduleName])) {
            props.roleArr[moduleName].forEach(role => {
                formData.append(`role[${moduleName}][]`, role);
            });
        }
    }
    formData.append("_method", 'PUT');
    //

    try {
        await router.post(route('admin.groups.updatePermission', props.group.id), formData, {

            onSuccess: (page) => {
                if (page.props.flash.success) {
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        position: 'top',
                        showConfirmButton: false,
                        title: page.props.flash.success,
                    });
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
                }
            },
        });
    } catch (e) {
        console.log(e);
    }
}

</script>
