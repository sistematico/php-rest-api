<template>
  <div class="starter-template text-center py-5 px-3 home">
    <h1>Usuários</h1>

    <div :class="alertClass" role="alert" v-if="mensagem">
      {{ mensagem }}
    </div>

    <form class="row g-3 justify-content-center" @submit.prevent="addUser()">
      <div class="col-auto">
        <label for="nome" class="visually-hidden">Nome</label>
        <input v-model="user.nome" type="text" class="form-control" id="nome" placeholder="Fulano de Tal">
      </div>
      <div class="col-auto">
        <label for="usuario" class="visually-hidden">Usuário</label>
        <input v-model="user.usuario" type="text" class="form-control" id="usuario" placeholder="usuario">
      </div>
      <div class="col-auto">
        <label for="email" class="visually-hidden">E-mail</label>
        <input v-model="user.email" type="text" class="form-control" id="email" placeholder="usuario@gmail.com">
      </div>
      <div class="col-auto">
        <label for="senha" class="visually-hidden">Email</label>
        <input v-model="user.senha" type="password" class="form-control" id="senha" placeholder="Senha" autocomplete="current-password">
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
      <tr v-for="item in registrosPaginados" :key="item">
        <td scope="row">{{ item.id }}</td>
        <td>{{ item.fullname }}</td>
        <td>{{ item.username }}</td>
        <td>{{ item.email }}</td>
      </tr>
      </tbody>
    </table>
    <Pagination :registros="registros" @toparent="fromChild" ref="pagination" />
  </div>
</template>
<script>
import Pagination from '@/components/Pagination.vue'
import { ApiHandler } from "@/js/api";

export default {
  name: "Home",
  components: { Pagination },
  data() {
    return {
      registros: [],
      registrosPaginados: [],
      user: { nome: '', usuario: '', email: '', senha: '' },
      mensagem: '',
      alertClass: 'alert alert-primary',
    };
  },
  mounted() {
    ApiHandler.fetch(this)
  },
  methods: {
    fromChild(value) {
      this.registrosPaginados = value
    },
    addUser() {
      // add (app, nome, usuario, email, senha) {
      ApiHandler.add(this, this.user.nome, this.user.usuario, this.user.email, this.user.senha)
      ApiHandler.fetch(this)
      this.$refs.pagination.pagina = this.$refs.pagination.total
    }
  }
}
</script>
