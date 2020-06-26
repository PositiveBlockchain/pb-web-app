<template>
    <Transition name="fade">
        <div v-if="isShown" @click.self="close"
             class="fixed inset-0 w-full h-screen flex items-center justify-center bg-gray-600 bg-opacity-75">
            <div class="relative w-full max-w-2xl bg-white shadow-lg rounded-lg p-8">
                <button
                    aria-label="close"
                    class="absolute top-0 right-0 text-xl text-gray-500 my-2 mx-4"
                    @click.prevent="close">
                    ×
                </button>
                <div class="modal-header mb-5">
                    <h1 class="modal-title text-2xl" v-text="title">{{title}}</h1>
                </div>
                <div class="moda-body leading-relaxed" v-html="body">

                </div>
                <slot></slot>
            </div>
        </div>
    </Transition>
</template>

<script>
    export default {
        name: "CardModal",
        data() {
            return {
                isShown: false,
                modalData: null,
                title: '',
                body: '',
            };
        },
        props: {
            showing: {
                required: true,
                type: Boolean
            }
        },
        created() {
            eventHub.$on('pb-modal-show', this.show);
            eventHub.$on('pb-modal-close', this.close);
        },
        methods: {
            show(data) {
                this.isShown = true;
                this.modalData = data.data;
                this.title = data.title;
                this.body = data.body;
            },
            close() {
                this.modalData = null;
                this.isShown = false;
            }
        }
    }
</script>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: all 0.4s;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }
</style>
