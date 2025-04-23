<template>
    <UserLayout>
        <UserInfor :user="user">

        </UserInfor>
    </UserLayout>
</template>

<script setup>
    defineProps( {
        user: Array,
    } );

    import UserLayout from '../Components/UserLayout.vue'
    import UserInfor from './UserInfor.vue'
</script>
