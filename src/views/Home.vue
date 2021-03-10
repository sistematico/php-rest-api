<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
    <HelloWorld msg="Welcome to Your Vue.js App" />
    {{ list }}
  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from "@/components/HelloWorld.vue";

export default {
  name: "Home",
  components: {
    HelloWorld,
  },
  data() {
    return {
      list: 'Lista',
    };
  },
  created: function () {
    this.fetchUsers()
  },
  methods: {
    fetchUsers: function () {
      //let headers = new Headers()
      //{ method: 'GET', header: headers, mode: 'no-cors'}
      
      fetch("https://api.lucasbrum.net/user/list", {method: 'GET'})
        .then(json => {
          console.log(json)
          this.list = JSON.stringify(json)
        }).catch(error => {
          console.log(error)
        })    
    }
  }
}
</script>
