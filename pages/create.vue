<template>
  <section>

    <div class="columns">

      <div class="column">

        <b-tabs class="block" >
          <b-tab-item  label="HTML">
            <h4>Codemirror</h4>
            <no-ssr placeholder="Codemirror Loading...">
              <codemirror v-model="code_mirror"
                          @input="onCmCodeChange"
                          :options="cmOption">
              </codemirror>
            </no-ssr>


          </b-tab-item>

          <b-tab-item label="CSS">
            CSS
          </b-tab-item>

          <b-tab-item  label="JS">
            JS
          </b-tab-item>


        </b-tabs>


      </div>

      <div class="column">
        <iframe id="frame"></iframe>
      </div>


    </div>


  </section>
</template>

<script src="./createJs.js"></script>
