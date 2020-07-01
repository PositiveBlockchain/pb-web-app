<template>
    <div class="loader ease-linear rounded-full border-8 border-t-8 border-green-200 h-32 w-32"></div>
</template>

<script>
    export default {
        name: "Spinner",
        props: {
            width: {
                type: Number,
                default: 64
            },
            height: {
                type: Number,
                default: 64
            }
        },
    }
</script>

<style scoped>
    .loader {
        border-top-color: #2bbf89;
        -webkit-animation: spinner linear 1.5s infinite;
        animation: spinner linear 1.5s infinite;
    }

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spinner {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
