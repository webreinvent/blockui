<template>


  <section>
    <HomeHeader></HomeHeader>

    <section class="columns">
      <div class="container column">
        <b-tabs position="is-centered" class="block" >
          <b-tab-item  label="Pictures">

            <div class="columns">

              <div class="column">
                <div class="card">
                  <header class="card-header">
                    <p class="card-header-title">
                      Component
                    </p>
                    <a href="#" class="card-header-icon" aria-label="more options">
                      <b-icon
                              pack="fas"
                              icon="angle-down"
                              size="is-small">
                      </b-icon>
                    </a>
                  </header>
                  <div class="card-content">
                    <div class="content">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.
                      <a href="#">@bulmaio</a>. <a href="#">#css</a> <a href="#">#responsive</a>
                      <br>
                      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                    </div>
                  </div>
                  <footer class="card-footer">
                    <a href="#" class="card-footer-item">Save</a>
                    <a href="#" class="card-footer-item">Edit</a>
                    <a href="#" class="card-footer-item">Delete</a>
                  </footer>
                </div>
              </div>

              <div class="column">
                <div class="card">
                  <header class="card-header">
                    <p class="card-header-title">
                      Component
                    </p>
                    <a href="#" class="card-header-icon" aria-label="more options">
              <span class="icon">
                <i class="fas fa-angle-down" aria-hidden="true"></i>
              </span>
                    </a>
                  </header>
                  <div class="card-content">
                    <div class="content">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.
                      <a href="#">@bulmaio</a>. <a href="#">#css</a> <a href="#">#responsive</a>
                      <br>
                      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                    </div>
                  </div>
                  <footer class="card-footer">
                    <a href="#" class="card-footer-item">Save</a>
                    <a href="#" class="card-footer-item">Edit</a>
                    <a href="#" class="card-footer-item">Delete</a>
                  </footer>
                </div>
              </div>

              <div class="column">
                <div class="card">
                  <header class="card-header">
                    <p class="card-header-title">
                      Component
                    </p>
                    <a href="#" class="card-header-icon" aria-label="more options">
              <span class="icon">
                <i class="fas fa-angle-down" aria-hidden="true"></i>
              </span>
                    </a>
                  </header>
                  <div class="card-content">
                    <div class="content">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.
                      <a href="#">@bulmaio</a>. <a href="#">#css</a> <a href="#">#responsive</a>
                      <br>
                      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                    </div>
                  </div>
                  <footer class="card-footer">
                    <a href="#" class="card-footer-item">Save</a>
                    <a href="#" class="card-footer-item">Edit</a>
                    <a href="#" class="card-footer-item">Delete</a>
                  </footer>
                </div>
              </div>

              <div class="column">
                <div class="card">
                  <header class="card-header">
                    <p class="card-header-title">
                      Component
                    </p>
                    <a href="#" class="card-header-icon" aria-label="more options">
              <span class="icon">
                <i class="fas fa-angle-down" aria-hidden="true"></i>
              </span>
                    </a>
                  </header>
                  <div class="card-content">
                    <div class="content">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.
                      <a href="#">@bulmaio</a>. <a href="#">#css</a> <a href="#">#responsive</a>
                      <br>
                      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                    </div>
                  </div>
                  <footer class="card-footer">
                    <a href="#" class="card-footer-item">Save</a>
                    <a href="#" class="card-footer-item">Edit</a>
                    <a href="#" class="card-footer-item">Delete</a>
                  </footer>
                </div>
              </div>

            </div>




          </b-tab-item>

          <b-tab-item label="Music">
            Lorem <br>
            ipsum <br>
            dolor <br>
            sit <br>
            amet.
          </b-tab-item>

          <b-tab-item  label="Books">
            <p>Independent, Reusable & BEM (Block Element Modifier) based UI Blocks/Components Snippets</p>
          </b-tab-item>


        </b-tabs>
      </div>
    </section>


  </section>

</template>

<script>
import HomeHeader from './../components/HomeHeader'

export default {
  name: 'HomePage',

  components: {
    HomeHeader,
  }
}
</script>
