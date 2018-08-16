<template>
    <span class="chatmessage">
        <span class="timestamp">{{timestamp}}</span>
        <span class="sender">{{sender}}:</span>
        <span class="body"><slot></slot></span>
    </span>
</template>

<script>
    export default {
        name: 'chatmessage',
        props: {
            timestamp: {
                required: true
            },
            sender: {
                required: true
            }
        }
    }
</script>

<style scoped>

</style>
