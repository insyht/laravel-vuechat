<template>
    <div class="container-fluid" id="chatmessages">
        <!-- Loop through all messages using v-for and output the relevant data (timestamp, sender name, message) -->
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
                messages: [] // Set a default
            }
        },
        methods: {
            getMessages() {
                var me = this; // because of scope create a 'me' var for 'this'
                axios.get('/messages')
                     .then(function (response) {
                        me.messages = response.data;
                     }).catch(function (error) {
                        return []; // return an empty array of chat messages if there's an error
                });
            }
        },
        created() {
            // When the component has been created, load the messages
            this.getMessages();
            // Keep loading new messages every second
            setInterval(function() {
                this.getMessages();
            }.bind(this), 1000);
        }
    }
</script>
