<template>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">VueJS REST API Front-End</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <router-link class="nav-link active" to="/">Início</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" to="/adicionar">Adicionar</router-link>
          </li>
        </ul>
<!--        <form class="d-flex">-->
<!--          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
<!--          <button class="btn btn-outline-success" type="submit">Search</button>-->
<!--        </form>-->
      </div>
    </div>
  </nav>
  <main class="container">
    <router-view/>
  </main><!-- /.container -->
</template>
<style lang="scss">
body {
  padding-top: 5rem;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
