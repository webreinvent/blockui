<template>
  <div>

    <TopMenu></TopMenu>

    <nuxt />



  </div>
</template>

<script>
import TopMenu from './../components/TopMenu'

export default {
  components:{
    TopMenu,

  },
  data () {
    return {
      items: [
        {
          title: 'Home',
          icon: 'home',
          to: { name: 'index' }
        },
        {
          title: 'Inspire',
          icon: 'lightbulb',
          to: { name: 'inspire' }
        },
        {
          title: 'Inspire',
          icon: 'lightbulb',
          to: { name: 'inspire' }
        }
      ]
    }
  }
}
</script>
