<template>
    <div>


        <ul>
            <li><router-link class="nav-link" to="/">Home</router-link></li>
            <li><router-link class="nav-link" to="/services">Services</router-link></li>

        </ul>

        <input type="text" v-model="text" v-on:input="onType($event)" class="form-control" />

        <h2  >{{searched}}</h2>


    </div>
</template>
<script>
    export default {
        props: ['searched'],
        data()
        {
            let obj = {
                urls:{
                    current: window.location.href
                },
                assets: {
                },
                text: null,
            };
            return obj;
        },
        mounted() {
        },

        methods: {
            //------------------------------------------------------------
            onType: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                this.$emit('typed', this.text);

                console.log('onType', this.text);

            },
            //---------------------------------------------------------------------
            //------------------------------------------------------------
            //------------------------------------------------------------
        }
    }
</script>