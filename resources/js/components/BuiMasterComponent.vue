<template>

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-3">

                <bui-nav @searchBlocks="searched = $event"></bui-nav>

            </div>



            <div class="col-md-9">

                <bui-content :searched="searched" :heading="heading"></bui-content>

            </div>
        </div>
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