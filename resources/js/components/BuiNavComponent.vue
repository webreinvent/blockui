<template>

    <div>


        <div class="form-group">

            <input class="form-control" placeholder="search" v-on:input="onSearch($event)" v-model="search" >

        </div>

        <ul>
            <li v-if="blocks.length" v-for="item in blocks">
                <a v-on:click="getBlock($event)" v-bind:href="'http://localhost/blockui/block?path='+item">{{item}}</a>
            </li>
        </ul>

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
                    list: [
                        'Framework',
                        'Theme',
                    ],

                },
                blocks: {},
                search: "",
            };

            return obj;
        },

        mounted() {
            this.getBlocks();
        },

        methods: {
            //------------------------------------------------------------

            //------------------------------------------------------------
            onSearch(e)
            {
                if(e)
                {
                    e.preventDefault();
                }

                console.log('searchBlocks data', e.target.value);
                this.$emit('searchBlocks', e.target.value);

            },
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
            getBlock: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                var el = e.target;

                var url = $(el).attr('href');
                var params = {};
                this.$helpers.ajax(url, params, this.getBlockAfter);
            },
            //---------------------------------------------------------------------
            getBlockAfter: function (data) {

                console.log('block list', data);

                this.$emit('active_block', this.active_block);

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
