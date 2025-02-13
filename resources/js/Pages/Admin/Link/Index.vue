<template>
    <AdminLayout>
        <LinkList :links="links" :statusCounts="statusCounts" >

        </LinkList>
    </AdminLayout>
</template>

<script setup>
    defineProps( {
        links: Array,
        statusCounts: Array,

    } );

    import AdminLayout from '../Components/AdminLayout.vue'
    import LinkList from './LinkList.vue'
</script>
