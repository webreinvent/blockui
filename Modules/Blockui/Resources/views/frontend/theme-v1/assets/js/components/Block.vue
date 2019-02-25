<template>
    <div>



        <div class="row">

            <div class="col-md-12" v-if="block"  >

                <h2>{{block.name}}</h2>
                <p v-if="block.description">{{block.description}}</p>

            </div>

            <div class="col-md-12">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"
                           data-toggle="pill" href="#pills-preview" role="tab" >Preview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link "
                           data-toggle="pill" href="#pills-html" role="tab" >HTML</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link "
                           data-toggle="pill" href="#pills-css" role="tab" >CSS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link "
                           data-toggle="pill" href="#pills-js" role="tab" >JS</a>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent" v-if="block">
                    <div class="tab-pane fade show active" id="pills-preview" role="tabpanel" >
                        <iframe v-bind:src="block.iframe"></iframe>
                    </div>
                    <div class="tab-pane fade show " id="pills-html" role="tabpanel" >

                    </div>
                    <div class="tab-pane fade show " id="pills-css" role="tabpanel" ></div>
                    <div class="tab-pane fade show " id="pills-js" role="tabpanel" ></div>
                </div>



            </div>




        </div>



    </div>
</template>
<script>
    export default {
        props:['query', 'segments'],
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
                block: null,
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
                    this.getBlock();
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

                this.getBlock();

            },
            //---------------------------------------------------------------------
            getBlock: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                var url = this.urls.base+"/block";
                var params = {
                    category: this.segments.category,
                    name: this.segments.name,
                };

                console.log('url', url);
                console.log('params', params);

                this.$helpers.ajax(url, params, this.getBlocksAfter);
            },
            //---------------------------------------------------------------------
            getBlocksAfter: function (data) {

                console.log('block', data);
                this.block = data;

                this.aceEditor('pills-html', 'html', this.block.html, 15);
                this.aceEditor('pills-css', 'css', this.block.css, 5);
                this.aceEditor('pills-js', 'javascript', this.block.js, 5);

                this.$helpers.stopNprogress();
            },
            //---------------------------------------------------------------------
            aceEditor: function (element_id, mode, data, height) {

                var editor = ace.edit(element_id);

                if(!height)
                {
                    height = 15;
                }

                editor.setOptions({
                    fontFamily: "consolas",
                    fontSize: "15px"
                });

                editor.setTheme("ace/theme/monokai");
                editor.getSession().setMode("ace/mode/"+mode);


                editor.getSession().setUseWrapMode(true);
                editor.setOption('minLines', 10); // this is required for the auto synced scroll
                editor.setOption('maxLines', 25); // this is required for the auto synced scroll
                editor.setAutoScrollEditorIntoView(false);
                editor.$blockScrolling = Infinity;


                if(data)
                {
                    editor.getSession().setValue(data);
                }

                /*
                editor.getSession().on('change', function() {
                 UiKitModule.data[element_id] = editor.getSession().getValue();
                 UiKitModule.prepareIFrameHTML();
                 });

                 */

                return editor;
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