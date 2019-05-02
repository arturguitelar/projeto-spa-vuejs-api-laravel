<template>
  <div class="row">
    <grid-vue class="input-field" tamanho="12">
      <input type="text" v-model="conteudo.titulo">
      <textarea
        v-if="conteudo.titulo"
        v-model="conteudo.texto"
        class="materialize-textarea"
        placeholder="Conteúdo"></textarea>
      <input type="text"
        v-if="conteudo.titulo && conteudo.texto"
        v-model="conteudo.link"
        placeholder="Link">
      <input type="text"
        v-if="conteudo.titulo && conteudo.texto"
        v-model="conteudo.imagem"
        placeholder="Url da Imagem">
      <label>O que está acontecendo?</label>
    </grid-vue>

    <p class="right-align">
      <button
        @click="addConteudo()"
        v-if="conteudo.titulo && conteudo.texto"
        class="btn waves-effect waves-light">Publicar</button>
    </p>
  </div>
</template>

<script>
import GridVue from '@/components/layouts/GridVue'

export default {
  name: 'PublicarConteudoVue',
  props: [],
  data () {
    return {
      conteudo: {
        titulo: '',
        texto: '',
        link: '',
        imagem: ''
      }
    }
  },
  components: {
    GridVue
  },
  methods: {
    addConteudo () {
      this.$http.post(`${this.$urlAPI}conteudo/adicionar`,
        {
          titulo: this.conteudo.titulo,
          texto: this.conteudo.texto,
          link: this.conteudo.link,
          imagem: this.conteudo.imagem,
        },
        { 'headers': { 'authorization': `Bearer ${this.$store.getters.getToken}` }})
        .then(response => {
          if (response.data.status) {
            // console.log('response:', response.data.conteudos)
            this.conteudo = { titulo: '', texto: '', link: '', imagem: '' }
            this.$store.commit('setConteudosLinhaTempo', response.data.conteudos.data)
          } else if (response.data.status === false && response.data.validacao) {
            // erro de validação
            let erros = ''
            for (let erro of Object.values(response.data.erros)) {
              erros += erro + "\n"
            }
            alert(erros)
          }
        })
        .catch(e => {
          console.error(e)
          alert('Erro! Tente mais tarde')
        })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
