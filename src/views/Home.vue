<template>
  <div class="starter-template text-center py-5 px-3 home">
    <h1>Usuários</h1>

    <div class="alert alert-primary" role="alert" v-if="mensagens">
      {{ mensagens }}
    </div>

    <form @submit.prevent="addUser()" class="row g-3 justify-content-center">
      <div class="col-auto">
        <label for="nome" class="visually-hidden">Nome</label>
        <input v-model="nome" type="text" class="form-control" id="nome" placeholder="Fulano de Tal">
      </div>
      <div class="col-auto">
        <label for="usuario" class="visually-hidden">Usuário</label>
        <input v-model="usuario" type="text" class="form-control" id="usuario" placeholder="usuario">
      </div>
      <div class="col-auto">
        <label for="email" class="visually-hidden">E-mail</label>
        <input v-model="email" type="text" class="form-control" id="email" placeholder="usuario@gmail.com">
      </div>
      <div class="col-auto">
        <label for="senha" class="visually-hidden">Email</label>
        <input v-model="senha" type="password" class="form-control" id="senha" placeholder="Senha">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-3">Enviar</button>
      </div>
    </form>

    <table class="table">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Usuário</th>
        <th scope="col">E-mail</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in lista" :key="item">
        <td scope="row">{{ item.id }}</td>
        <td>{{ item.fullname }}</td>
        <td>{{ item.username }}</td>
        <td>{{ item.email }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  name: "Home",
  data() {
    return {
      lista: [],
      nome: '',
      usuario: '',
      email: '',
      senha: '',
      mensagens: null
    };
  },
  created: function () {
    this.fetchUsers()
  },
  methods: {
    fetchUsers: function () {
      let headers = new Headers()

      fetch("https://api.lucasbrum.net/user/list", { method: 'GET', headers: headers, mode: 'cors'})
        .then(response => response.json())
        .then(data => {
          this.lista = data.data
        }).catch(error => {
          console.log(error)
        })    
    },
    addUser2: function () {
        const postOptions = {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            fullname: this.nome,
            username: this.usuario,
            email: this.email,
            password: this.senha
          })
        };

        fetch("https://api.lucasbrum.net/user/insert", postOptions)
            .then(response => response.json())
            .then(data => {
              this.mensagens = data.messages
            })
    },
    addUser: function () {

        let username = 'lucas', password = '123'

        let headers = new Headers();

        headers.append('Content-Type', 'application/json');
        headers.append('Accept', 'application/json');
        headers.append('Authorization', 'Basic ' + base64.encode(username + ":" + password));
        headers.append('Origin', 'http://localhost:3000');

        fetch('https://api.lucasbrum.net/user/insert', {
          mode: 'cors',
          credentials: 'include',
          method: 'POST',
          headers: headers,
          body: JSON.stringify({
            fullname: this.nome,
            username: this.usuario,
            email: this.email,
            password: this.senha
          })
        })
            .then(response => response.json())
            .then(json => {
              console.log(json)
              this.mensagens = json.messages
            })
            .catch(error => console.log('Authorization failed : ' + error.message));
      }
  }
}
</script>
