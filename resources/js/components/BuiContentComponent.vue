<template>

    <div>

        <h1>Content</h1>

        <h2>{{ searched }}</h2>

    </div>


</template>

<script>
    export default {

        props:['searched'],

        data()
        {
            let obj = {

                urls:{
                    current: window.location.href
                },
            };

            return obj;
        },

        mounted() {

        },

        methods: {
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
