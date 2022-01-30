<template>
  <div class="movie-manager-container">
    <b-card-header header-tag="nav">
      <b-nav>
        <b-nav-item to='/'>Home</b-nav-item>
        <b-nav-item to='/add'>Add a New Movie</b-nav-item>
      </b-nav>
    </b-card-header>

    <router-view />
  </div>
</template>

<script>
export default {
    
};
</script>