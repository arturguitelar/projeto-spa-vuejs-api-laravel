<template>
  <span>
    <div v-if="img && img != '#'" class="card-image">
      <a v-if="link && link != '#'" :href="link" target="_blank">
        <img :src="img">
        <span class="card-title">{{titulo || ''}}</span>
      </a>
      <span v-if="!link || link == '#'">
        <img :src="img">
        <span class="card-title">{{titulo || ''}}</span>
      </span>
    </div>

    <div v-if="txt" class="card-content">
      <span
        v-if="!img || img == '#'"
        class="card-title">
        {{titulo || ''}}
      </span>
      <p>{{txt || ''}}</p>
      <p v-if="link && link != '#'">
        <a :href="link" target="_blank">Confira mais aqui...</a>
      </p>
    </div>
  </span>
</template>

<script>
export default {
  name: 'CardDetalheVue',
  props: ['img', 'titulo', 'txt', 'link'],
  data () {
    return {

    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
