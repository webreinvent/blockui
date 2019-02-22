<template>
    <div>


        <h1>Services</h1>



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

            //---------------------------------------------------------------------

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