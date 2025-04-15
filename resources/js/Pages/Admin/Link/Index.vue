<template>
    <AdminLayout>
        <LinkList :links="links" :statusCounts="statusCounts" :userPrefix="userPrefix" >

        </LinkList>
    </AdminLayout>
</template>

<script setup>
    defineProps( {
        links: Array,
        statusCounts: Array,
        userPrefix: String,

    } );

    import AdminLayout from '../Components/AdminLayout.vue'
    import LinkList from './LinkList.vue'
</script>
