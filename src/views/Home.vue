<template>
  <div class="starter-template text-center py-5 px-3 home">
    <h1>Usuários</h1>

    <div :class="alertClass" role="alert" v-if="mensagem">
      {{ mensagem }}
    </div>

    <table class="table">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Usuário</th>
        <th scope="col">E-mail</th>
        <th scope="col">Apagar</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in registrosPaginados" :key="item">
        <td scope="row">{{ item.id }}</td>
        <td>{{ item.fullname }}</td>
        <td>{{ item.username }}</td>
        <td>{{ item.email }}</td>
        <td><a href="#" @click.prevent="delUser(item.id)">del</a></td>
      </tr>
      </tbody>
    </table>
    <Pagination @to-parent="fromChild" ref="pagination" />
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
      registrosPaginados: [],
      user: { nome: '', usuario: '', email: '', senha: '' },
      mensagem: '',
      alertClass: 'alert alert-primary',
      timestamp: 0
    };
  },
  mounted() {
    ApiHandler.fetch(this)
  },
  methods: {
    fromChild(value) {
      this.registrosPaginados = value
    },
    delUser(id) {
      ApiHandler.del(this, id)
    }
  },
  watch: {
    timestamp: function() {
      ApiHandler.fetch(this)
      this.$refs.pagination.pagina = this.$refs.pagination.total
    }
  }
}
</script>
