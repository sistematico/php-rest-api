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
      fetch("https://api.lucasbrum.net/user/list").then((response) => {
        return response.json().then((json) => {
          console.log("JSON", json);
          this.list = json
        })
      })
    }
  }
}
</script>
