<template>
    <div>


        <h1>Services</h1>


        <button class="btn btn-primary" v-on:click="btnClicked">Click</button>

        {{text}}

    </div>
</template>
<script>

    export default {
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

            //------------------------------------------------------------
            btnClicked: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                this.$emit("on-click", "text")
            },

            //------------------------------------------------------------
            //------------------------------------------------------------
            afterRendering: function()
            {
                this.$nextTick(function () {
                    this.$helpers.stopNprogress();
                });
            },
            //------------------------------------------------------------
            //------------------------------------------------------------
        }
    }
</script>