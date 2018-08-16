<template>
    <div class="chatmessage row">
        <div class="timestamp col-2">{{timestamp}}</div>
        <div class="sender col-2">{{sender}}:</div>
        <div class="body col"><slot></slot></div>
    </div>
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
