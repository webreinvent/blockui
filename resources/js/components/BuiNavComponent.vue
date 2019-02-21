<template>

    <ul>
        <li v-if="blocks.length" v-for="item in blocks">
            {{item}}
        </li>
    </ul>

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
                    list: [
                        'Framework',
                        'Theme',
                    ],

                },
                blocks: {}
            };

            return obj;
        },

        mounted() {
            this.getBlocks();
        },

        methods: {
            //------------------------------------------------------------

            //------------------------------------------------------------
            showAddModal: function (e) {
                if(e)
                {
                    e.preventDefault();
                }
                $("#ModalAdd").modal('show');
            },
            //------------------------------------------------------------
            getBlocks: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                var url = this.urls.current+"blocks/list";
                var params = {};
                this.$helpers.ajax(url, params, this.storeItemAfter);
            },
            //---------------------------------------------------------------------
            storeItemAfter: function (data) {

                console.log('blocks list', data);

                this.blocks = data;

                this.afterRendering();
            },
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
