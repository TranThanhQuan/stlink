<template>
    <AdminLayout>
        <h1 class="my-3 text-4xl"> Chỉnh sửa nhóm: {{ group.name }}</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                <th class="w-1/5 p-2 border border-gray-300">Module</th>
                <th class="p-2 border border-gray-300">Quyền</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="module in modules" :key="module.id" class="border border-gray-300">
                    <td class="p-2 border border-gray-300">{{ module.title }}</td>
                    <td class="p-2 border border-gray-300">
                        <div class="flex flex-wrap gap-4">
                            <div v-for="(roleLabel, roleName) in roleListArr" :key="roleName" class="w-1/6">
                                <label class="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        :id="`role_${module.name}_${roleName}`"
                                        :name="`role[${module.name}][]`"
                                        :value="roleName"
                                        v-model="roleArr[module.name]"
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
                                    />
                                    Phân quyền
                                </label>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>



        <!--  -->
        <div class="my-3">
            <Link :href="route('admin.groups.index')"
                class="my-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Trở về</Link>


            <button type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Lưu</button>
        </div>

    </AdminLayout>

</template>

<script setup>
import AdminLayout from '../Components/AdminLayout.vue'
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';


defineProps({
    group: Array,
    modules: Array,
    roleListArr: Array,
    roleArr: Array,

});



</script>
