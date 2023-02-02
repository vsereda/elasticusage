<template>
    <div id="popup-wrapper" class="overlay-popup-message" v-bind:class="{'popup-opened': isPopupOpen}">
        <div class="popup-message">
            <h2>{{ h2Message }}</h2>
            <a class="close-popup-message" href="" @click.prevent="this.$emit('close-popup', true)">&times;</a>
            <div class="popup-message-content">
                {{ message }}
            </div>
            <div v-if="enableDialogYN">
                <button @click.prevent="this.$emit('yes-answer')">Yes</button>
                <button @click.prevent="this.$emit('no-answer')">No</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PopupMessage",
    props: {
        isPopupOpen: {
            "type": Boolean,
            "required": true,
        },
        h2Message: {
            "type": String,
            "required": true,
        },
        message: {
            "type": String,
            "required": true,
        },
        enableDialogYN: {
            "type": Boolean,
            "required": false,
            "default": false,
        },
    },
    data() {
        return {
        }
    },
    methods: {
        openPopup() {
            this.isPopupOpen = true
        },
    }
}
</script>

<style scoped>

.overlay-popup-message {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    transition: opacity 500ms;
    visibility: hidden;
    opacity: 0;
}

.popup-opened {
    visibility: visible;
    opacity: 1;
}

.popup-message {
    margin: 70px auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    width: 30%;
    position: relative;
    transition: all 5s ease-in-out;
}

.popup-message h2 {
    margin-top: 0;
    color: #333;
    font-family: Tahoma, Arial, sans-serif;
}

.popup-message .close-popup-message {
    position: absolute;
    top: 20px;
    right: 30px;
    transition: all 200ms;
    font-size: 30px;
    font-weight: bold;
    text-decoration: none;
    color: #333;
}

.popup-message .close-popup-message:hover {
    color: #06D85F;
}

.popup-message .popup-message-content {
    max-height: 30%;
    overflow: auto;
}
</style>
