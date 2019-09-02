<template>
  <b-navbar>
    <template slot="brand">
      <b-navbar-item tag="router-link" :to="{ path: '/' }">
        <img src="https://raw.githubusercontent.com/buefy/buefy/dev/static/img/buefy-logo.png"
             alt="BlockUI"
        >
      </b-navbar-item>
    </template>
    <template slot="start">
      <nuxt-link to="/" class="navbar-item">
        Home
      </nuxt-link>

      <b-navbar-item href="#">
        Documentation
      </b-navbar-item>
      <b-navbar-dropdown label="Info">
        <b-navbar-item href="#">
          About
        </b-navbar-item>
        <b-navbar-item href="#">
          Contact
        </b-navbar-item>
      </b-navbar-dropdown>
    </template>

    <template slot="end">
      <b-navbar-item tag="div">
        <div class="buttons">
          <nuxt-link to="/create" class="button is-primary">
            <strong>Create</strong>
          </nuxt-link>
          <a class="button is-light">
            Log in
          </a>
        </div>
      </b-navbar-item>
    </template>
  </b-navbar>
</template>

<style>
</style>
