<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">

                        <div class="row">

                            <div class="col-md-7">Manage Component</div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <select class="form-control" v-model="new_item.type">
                                        <option value="">Select Type</option>
                                        <option v-for="item in assets.list">{{item}}</option>
                                    </select>

                                </div>

                            </div>

                            <div class="col-md-2">

                                <div class="form-group">
                                    <button v-on:click="showAddModal($event)" class="btn btn-primary">Add</button>
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="card-body">


                        <table class="table">

                            <tr>
                                <td>Name</td>
                                <td>Slug</td>
                                <td>Created By</td>
                            </tr>

                            <tr>
                                <td>Name</td>
                                <td>Slug</td>
                                <td>Created By</td>
                            </tr>

                        </table>



                    </div>



                </div>
            </div>
        </div>


        <!--modal-->
        <div class="modal fade" id="ModalAdd" aria-hidden="false"
             role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <form class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Title</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <div class="row"  >


                            <div class="col-xs-12 col-md-6 form-group">
                                <label class="form-control-label">Name</label>
                                <input type="text" class="form-control" v-model="new_item.name" >
                            </div>


                            <div class="col-xs-12 col-md-12 pull-xs-right">
                                <button v-on:click="storeItem($event)" class="btn btn-primary"
                                        type="submit">Save</button>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--/modal-->


    </div>






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
                    ]
                },

                new_item:{
                    type: ""

                }

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
            storeItem: function (e) {
                if(e)
                {
                    e.preventDefault();
                }

                var url = this.urls.current+"/store";
                var params = this.new_item;
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
