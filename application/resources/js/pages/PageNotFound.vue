<template>
    <h1>404 Page not found!</h1>
</template>

<script>
import router from "../router";

export default {
    name: "PageNotFound",
    created: function() {
        setTimeout(function () {
            router.push({ name: "home"});
        }, 5000);
    }
}
</script>

<style scoped>

</style>
