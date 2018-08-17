<template>
    <div class="container-fluid" id="chatmessages">
        <chatmessage
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
                var me = this;
                axios.get('/messages')
                     .then(function (response) {
                        me.messages = response.data;
                     }).catch(function (error) {
                        return [];
                });
            }
        },
        created() {
            this.getMessages();
            setInterval(function() {
                this.getMessages();
            }.bind(this), 1000);
        }
    }
</script>
