<template>

    <ul>
        <li>
            Test
        </li>
    </ul>

</template>

<script>
    export default {

        data()
        {
            return {

                urls:{
                    current: window.location.href
                },
                assets: {
                    list: [
                        'Framework',
                        'Theme',
                    ],
                    blocks: []
                },

            }
        },

        mounted() {
            console.log('Component mounted.')
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

                var url = this.urls.current+"/blocks/list";
                var params = {};
                this.$helpers.ajax(url, params, this.storeItemAfter);
            },
            //---------------------------------------------------------------------
            storeItemAfter: function (data) {

                console.log('data', data);

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
