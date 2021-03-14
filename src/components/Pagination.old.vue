<template>
  <div class="pagination">
    <button @click="prevPage" :disabled="pageNumber === 0">Previous</button>
    <button @click="nextPage" :disabled="pageNumber >= pageCount()">Next</button>
  </div>
</template>
<script>
export default {
  props:{
    listData: { type:Array, required: true },
    size:{ type:Number, required:false, default: 10 }
  },
  emits: ["paginatedData"],
  data() {
    return {
      pageNumber: 0  // default to page 0
    }
  },
  methods:{
    nextPage(){
      this.pageNumber++
      this.paginatedData()
    },
    prevPage(){
      this.pageNumber--
      this.paginatedData()
    },
    pageCount(){
      let l = this.listData.length
      let s = this.size
      return Math.ceil(l/s) - 1
    },
    paginatedData(){
      let start = this.pageNumber * this.size
      let end = start + this.size
      return this.listData.slice(start, end)
      //this.$emit("enlargeText", "someValue");
    }
  }
}
</script>