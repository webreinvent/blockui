<template>

    <div class="row">

        <div class="col-md-12">


            <h1>{{heading}}</h1>
            <p>Modular & BEM based UI Component Blocks</p>

            {{active_block}}

        </div>

    </div>

</template>

<script>
    export default {

        props: ['heading'],

        data()
        {
            let obj = {

                urls:{
                    current: window.location.href
                },
                assets: {
                },
                active_block: null

            };

            return obj;
        },

        mounted() {

        },

        methods: {
            //------------------------------------------------------------

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
