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
                axios.post('/chat', {
                   message: this.message,
                   token: this.token
                }).then(function () {
                    me.message = '';
                });
            }
        }
    }
</script>
