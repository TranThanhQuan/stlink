<template>
    <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Thông tin nhà phát hành</h1>

    <section class="bg-white dark:bg-gray-900">
        <div class="py-4 px-4 mx-auto  ">
            <div class="w-full flex items-center gap-2 mb-5">
                <p class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Tên đầy đủ:</p>
                <p class="font-normal text-black dark:text-white">{{ user.name }}</p>
            </div>

            <div class="w-full flex items-center gap-2 mb-5">
                <p class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Email:</p>
                <p class="font-normal text-black dark:text-white">{{ user.email }}</p>
            </div>

            <div class="w-full flex items-center gap-2">
                <p class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Tiền tố (prefix):</p>
                <p class="font-normal text-black dark:text-white">{{user.prefix  }}</p>

            </div>
            <p class="text-sm font-semibold tracking-tight text-gray-500">*Tiền tố này sẽ hiển thị ở đầu half-back của link rút gọn</p>


        </div>
    </section>

</template>


<script setup>



const props = defineProps({
    user: Object
});

</script>


