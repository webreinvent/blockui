<template>

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-3">

                <bui-nav @searchBlocks="searched = $event"></bui-nav>



            </div>



            <div class="col-md-9">


                <bui-content :heading="heading"></bui-content>

                {{searched}}

            </div>
        </div>
    </div>

</template>

<script>

    import Nav from './BuiNavComponent.vue';
    import Content from './BuiContentComponent.vue';

    export default {

        components: {
            'bui-nav': Nav,
            'bui-content': Content,
        },
        data()
        {
            let obj = {

                urls:{
                    current: window.location.href
                },
                assets: {
                },
                blocks: {},
                active_block: null,
                heading: "BlockUi",
                searched: null,
            };

            return obj;
        },

        mounted() {


        },

        watch: {
            active_block: function(val)
            {
                console.log('val', val);
            }
        },

        methods: {
            //------------------------------------------------------------

            searchBlocks: function (e) {
                if(e)
                {
                    e.preventDefault();
                }


                console.log("master", e);

            },
            //---------------------------------------------------------------------

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
