<template>
    <div class="row">

        <div class="col-md-2">

            <left></left>

        </div>



        <div class="col-md-10">


            <div class="row">

                <div class="col-md-4" v-if="blocks" v-for="block in blocks" >

                    <div class="card" style="cursor: pointer;" >
                        <div class="card-image">
                            <img v-if="block.thumbnail" style="width: 100%;" v-bind:src="block.thumbnail" />
                            <img v-else style="width: 100%;" src="https://via.placeholder.com/500x300.png?text=Thumbnail+Missing" />
                        </div>

                        <div class="card-title">
                            {{block.name}}
                        </div>

                        <div v-if="block.description" class="card-details">
                            {{block.description}}
                        </div>

                        <div class="card-link">
                            <router-link class="btn btn-block btn-primary"
                                         v-bind:to="{ path: '/blocks/'+segments.category+'/'+block.name}"
                            >View</router-link>
                        </div>

                    </div>

                </div>


            </div>

        </div>





    </div>
</template>
<script>

    import Left from './Left';

    export default {
        props:['query', 'segments'],
        components:{
            'left': Left
        },
        data()
        {
            let obj = {
                urls:{
                    current: window.location.href,
                    base: $("base").attr('href'),
                },
                assets: {
                },
                text: null,
                blocks: null,
            };
            return obj;
        },
        mounted() {

            this.onLoad();
        },
        watch: {
            segments: {
                immediate: true,
                deep: true,
                handler(newValue, oldValue) {
                    console.log('Prop changed: ', newValue, ' | was: ', oldValue);
                    this.segments = newValue;
                    this.getBlocks();
                }
            }
        },
        methods: {
            //------------------------------------------------------------

            onLoad: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                this.getBlocks();

            },
            //---------------------------------------------------------------------
            getBlocks: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                var url = this.urls.base+"/blocks";
                var params = {
                    category: this.segments.category
                };

                console.log('url', url);
                console.log('params', params);

                this.$helpers.ajax(url, params, this.getBlocksAfter);
            },
            //---------------------------------------------------------------------
            getBlocksAfter: function (data) {

                console.log('blocks', data);
                this.blocks = data;

                this.$helpers.stopNprogress();
            },
            //---------------------------------------------------------------------

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