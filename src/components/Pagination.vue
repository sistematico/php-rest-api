<template>
  <div class="pagination">
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" :class="pagina === 0 ? 'disabled' : ''">
          <a class="page-link" href="#" @click="anterior()" v-if="pagina > 0">Anterior</a>
          <span class="page-link" v-else>Anterior</span>
        </li>
        <li class="page-item disabled">
          <span class="page-link">{{ pagina + 1 }} de {{ total + 1 }}</span>
        </li>
        <li class="page-item" :class="pagina >= total ? 'disabled' : ''">
          <a class="page-link" href="#" @click="proxima()" v-if="pagina < total">Próxima</a>
          <span class="page-link" v-else>Próxima</span>
        </li>
      </ul>
    </nav>
  </div>
</template>
<script>
export default {
  name: "Pagination",
  props: {
    //registros: { type: Array },
    toParent: { type: Function }
  },
  data() {
    return {
      pagina: 0,
      total: 1,
      tamanho: 5,
      registros: []
    };
  },
  methods: {
    proxima() {
      this.pagina++;
      this.paginacao();
    },
    anterior() {
      this.pagina--;
      this.paginacao();
    },
    paginacao() {
      let l = this.registros.length;
      let s = this.tamanho;
      this.total = Math.ceil(l / s) - 1;

      let inicio = this.pagina * this.tamanho;
      let fim = inicio + this.tamanho;
      this.$emit('to-parent', this.registros.slice(inicio, fim));
    },
  },
  watch: {
    pagina: function () {
      this.paginacao()
    },
    registros: function() {
      this.paginacao()
    }
  },
};
</script>