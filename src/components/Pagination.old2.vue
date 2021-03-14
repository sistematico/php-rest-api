<template>
  <div class="pagination">
    <button @click="proxima()" :disabled="pagina === 0">Previous</button>
    <button @click="anterior()" :disabled="pagina >= pageCount()">Next</button>
  </div>
</template>
<script>
export default {
  props:{
    lista: { type: Array, required: false }
  },
  emits: ['update:lista'],
  data() {
    return {
      pagina: 0,  // default to page 0
      tamanho: 10,
      listaPaginada: []
    }
  },
  mounted() {
   // this.calculoPaginacao()
  },
  methods:{
    proxima() { this.pagina++ },
    anterior() { this.pagina-- },
    pageCount(){
      //let l = this.lista.length
      //let s = this.tamanho
      //return Math.ceil(l/s) - 1
    },
    calculoPaginacao() {
      //let inicio = this.pagina * this.tamanho
      //let fim = inicio + this.tamanho
      //this.$emit('update:list', this.lista.slice(inicio, fim))
      //return lst.slice(inicio, fim)
    }
  },
  watch: {
    pagina: function (val) {
      // when the hash prop changes, this function will be fired.
      location.reload()
    }
  }
}
</script>