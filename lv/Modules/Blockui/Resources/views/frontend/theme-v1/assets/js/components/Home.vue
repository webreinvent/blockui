<template>
    <div class="row">


        <div class="col-md-2">

            <left></left>

        </div>



        <div class="col-md-10">




        </div>


    </div>
</template>
<script>
    import Left from './Left';
    export default {
        name: 'Home',
        components:{
            'left': Left
        },
    }
</script>