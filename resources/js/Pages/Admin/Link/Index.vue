<template>
    <AdminLayout>
        <LinkList :links="links">

        </LinkList>
    </AdminLayout>
</template>

<script setup>
    defineProps( {
        links: Array
    } );

    import AdminLayout from '../Components/AdminLayout.vue'
    import LinkList from './LinkList.vue'
</script>
