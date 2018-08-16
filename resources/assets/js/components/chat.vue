<template>
    <div class="container-fluid" id="chatmessages">
        <chatmessage
                v-on:reloadchat="getMessages"
                v-for="message in messages"
                :key="message.id"
                :timestamp="message.timestamp.date"
                :sender="message.sender.name">
                    {{message.message}}
        </chatmessage>
    </div>
</template>

<script>
    export default {
        name: 'chat',
        data() {
            return {
                messages: []
            }
        },
        methods: {
            getMessages() {
                console.log('(re)loading chat..');
                var me = this;
                axios.get('/messages')
                     .then(function (response) {
                        me.messages = response.data;
                        console.log(response.data);
                     }).catch(function (error) {
                        return [];
                });
            }
        },
        created() {
            this.getMessages();
        }
    }
</script>
