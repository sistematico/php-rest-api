<template>
  <div class="starter-template text-center py-5 px-3 home">
    <h1>Adicionar Usuário</h1>

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
  </div>
</template>
<script>
import { ApiHandler } from "@/js/api";

export default {
  name: "Adicionar",
  data() {
    return {
      user: { nome: '', usuario: '', email: '', senha: '' },
      mensagem: '',
      alertClass: 'alert alert-primary'
    }
  },
  methods: {
    addUser() {
      ApiHandler.add(this, this.user.nome, this.user.usuario, this.user.email, this.user.senha)
      //ApiHandler.fetch(this)
    }
  }
}
</script>
