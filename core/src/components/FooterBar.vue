<template>
    <div class="footer">
        <div class="footer-inner">
            <div><span>Dagorà Reports eShop | &copy; Dagorà SA {{ yearNow }}</span></div>
            <a href="https://community.dagora.ch/join-us" target="_blank">Join Dagorà</a>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            yearNow: null,
        };
    },
    mounted() {
        this.yearNow = new Date().getFullYear();
    },

};
</script>
