<template>
    <table>
        <tr>
            <td>
                <input type="text" class="form-control" v-model="message">
            </td>
            <td>
                <button id="sendButton" type="button" class="btn btn-default" @click="submitMessage(this.message)">Send
                </button>
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
                    // trigger reload event on chat component
                    console.log('trigger start');
                    console.log(me.$emit('reloadchat'));
                    console.log('trigger done');
                });
            }
        }
    }
</script>
