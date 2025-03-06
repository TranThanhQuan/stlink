<template>
    <AdminLayout>
        <GroupList :groups="groups">

        </GroupList>
    </AdminLayout>

</template>

<script setup>
    defineProps( {
        groups: Array
    } );


    import AdminLayout from '../Components/AdminLayout.vue'
    import GroupList from './GroupList.vue'
</script>
