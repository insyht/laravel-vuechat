<template>
    <table>
        <tr>
            <td>
                <input type="text" class="form-control" v-model="message">
            </td>
            <td>
                <button id="sendButton" type="button" class="btn btn-default" @click="submitMessage()">Send</button>
            </td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: 'sendmessage',
        props: {
            defaultmessage: {
                required: true
            },
            token: {
                // this is the CSRF token from Laravel
                required: true
            }
        },
        data() {
            return {
                message: this.defaultmessage
            }
        },
        methods: {
            submitMessage: function () {
                var me = this;
                // Send a POST request to save and broadcast the message
                axios.post('/chat', {
                   message: this.message,
                   token: this.token
                }).then(function () {
                    me.message = ''; // Reset the message input field
                });
            }
        }
    }
</script>
