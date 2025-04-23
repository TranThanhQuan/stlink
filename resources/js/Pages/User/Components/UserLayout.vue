<template>
    <div class="antialiased bg-white-50 dark:bg-gray-900">
        <!-- Navbar -->
        <Navbar/>
        <!-- End Navbar -->

        <!-- Sidebar -->
        <Sidebar/>
        <!-- End Sidebar -->
        <main class="p-4 md:ml-64 min-h-screen pt-16 ">
            <slot />
        </main>
    </div>
</template>

<script setup>
    import { onMounted } from "vue";
    import { initFlowbite } from "flowbite";
    import Navbar from "./Navbar.vue";
    import Sidebar from "./Sidebar.vue";

    // initialize components based on data attribute selectors
    onMounted(() => {
        initFlowbite();
    });
</script>

<style lang="scss" scoped></style>
