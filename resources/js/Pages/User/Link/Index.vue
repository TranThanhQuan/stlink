<template>
    <UserLayout :userPrefix="userPrefix">
        <LinkList :links="links" :statusCounts="statusCounts" :userPrefix="userPrefix">

        </LinkList>
    </UserLayout>
</template>

<script setup>
    const props = defineProps({
        links: Object,
        statusCounts: Object,
        userPrefix: String,
    });



    import UserLayout from '../Components/UserLayout.vue';
    import LinkList from './LinkList.vue';
</script>
