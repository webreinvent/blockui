<template>
    <div>


        <ul class="list-group-solid" v-if="categories">
            <li v-for="category in categories" >
                <router-link
                        v-bind:to="{ path: '/blocks/'+category.name}"
                        >{{category.name}}
                    <span style="float: right;">({{category.blocks}})</span>
                </router-link>
            </li>
        </ul>


    </div>
</template>
<script>
    export default {
        props: ['searched'],
        data()
        {
            let obj = {
                urls:{
                    current: window.location.href,
                    base: $("base").attr('href'),
                },
                assets: {
                },
                categories: null,
            };
            return obj;
        },
        mounted() {

            //---------------------------------------------
            this.onLoad();
            //---------------------------------------------

        },

        methods: {
            //------------------------------------------------------------
            onLoad: function()
            {
                this.getNav();
            },
            //------------------------------------------------------------

            getNav: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                var url = this.urls.base+"/categories";

                console.log('url',url);

                var params = {};
                this.$helpers.ajax(url, params, this.getNavAfter);
            },
            //---------------------------------------------------------------------
            getNavAfter: function (data) {

                this.categories = data;

                this.$helpers.stopNprogress();
            },
            //------------------------------------------------------------
            //------------------------------------------------------------
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