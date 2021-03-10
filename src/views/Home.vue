<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
    <HelloWorld msg="Welcome to Your Vue.js App" />
    <ul>
      <li v-for="item in lista" :key="item">
        {{ item.id }} - {{ item.fullname }} 
      </li>
    </ul>
    
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
      lista: {},
    };
  },
  created: function () {
    this.fetchUsers()
  },
  methods: {
    fetchUsers: function () {
      // let headers = new Headers()
      // headers.append('Access-Control-Allow-Origin', 'https://rest.lucasbrum.net');
      // headers.append('Access-Control-Allow-Credentials', 'true');
      // let options = { method: 'GET', headers: headers, mode: 'cors'}
      
      fetch("https://api.lucasbrum.net/user/list")
        .then(json => {
          console.log(json)
          this.lista = JSON.stringify(json.data)
        }).catch(error => {
          console.log(error)
        })    
    }
  }
}
</script>
