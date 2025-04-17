<template>
    <AdminLayout :userPrefix="userPrefix">
        <LinkList :links="links" :statusCounts="statusCounts" :userPrefix="userPrefix">

        </LinkList>
    </AdminLayout>
</template>

<script setup>
    const props = defineProps({
        links: Object,
        statusCounts: Object,
        userPrefix: String,
    });



    import AdminLayout from '../Components/AdminLayout.vue';
    import LinkList from './LinkList.vue';
</script>
