<template>
  <div class="row">
    <div class="card">
      <div class="card-content">
        <div class="row valign-wrapper">
          <grid-vue tamanho="1">
            <router-link :to="'/pagina/'+usuarioid+'/'+$slug(nome || '', {lower:true})">
              <img :src="perfil" :alt="nome" class="circle responsive-img">
            </router-link>
          </grid-vue>
          <grid-vue tamanho="11">
            <span class="black-text">
              <router-link :to="'/pagina/'+usuarioid+'/'+$slug(nome || '', {lower:true})">
                <strong>{{nome}}</strong> - <small>{{data}}</small>
              </router-link>
            </span>
          </grid-vue>
        </div>

        <!-- detalhes do card -->
        <slot/>
      </div>
      <div class="card-action">
        <p>
          <a href="#" @click.prevent="curtir(idconteudo)">
            <i class="material-icons">{{curtiu}}</i>
            <span>{{totalCurtidas}}</span>
          </a>

          <a href="#" @click.prevent="abrirComentarios()">
            <i class="material-icons">insert_comment</i>
            <span>{{listaComentarios.length}}</span>
          </a>
        </p>

        <p v-if="exibirComentario" class="right-align">
          <input
            v-model="textoComentario"
            type="text"
            placeholder="Comentar"/>
          <button
            v-if="textoComentario"
            @click="comentar(idconteudo)"
            class="btn waves-effect waves-light orange">
            <i class="material-icons">send</i>
          </button>
        </p>

        <p v-if="exibirComentario">
          <ul class="collection">
            <li
              v-for="item in comentarios"
              :key="item.id"
              class="collection-item avatar">
              <img :src="item.user.imagem" alt="" class="circle">
              <span class="title">
                {{item.user.name}} <small> - {{item.data}}</small>
              </span>
              <p>
                {{item.texto}}
              </p>
            </li>
          </ul>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import GridVue from '@/components/layouts/GridVue'

export default {
  name: 'CardConteudoVue',
  props: [
    'idconteudo',
    'perfil',
    'nome',
    'data',
    'totalcurtidas',
    'comentarios',
    'curtiuconteudo',
    'usuarioid'
  ],
  data () {
    return {
      curtiu: this.curtiuconteudo ? 'favorite' : 'favorite_border',
      totalCurtidas: this.totalcurtidas,
      exibirComentario: false,
      textoComentario: '',
      listaComentarios: this.comentarios || []
    }
  },
  components: {
    GridVue
  },
  methods: {
    curtir (id) {
      let url = ''

      if (this.$route.name === 'Home') {
        url = 'conteudo/curtir/'
      } else {
        url = 'conteudo/curtirpagina/'
      }

      this.$http
        .put(`${this.$urlAPI+url+id}`, {},
          { 'headers': {'authorization': `Bearer ${this.$store.getters.getToken}`} })
        .then(response => {
          if (response.data.status) {
            this.totalCurtidas = response.data.curtidas
            this.$store.commit('setConteudosLinhaTempo', response.data.lista.conteudos.data)
            // Troca o sinal de curtir
            if (this.curtiu === 'favorite_border') {
              this.curtiu = 'favorite'
            } else {
              this.curtiu = 'favorite_border'
            }
          } else {
            alert(response.data.erro)
          }
        })
        .catch(e => {
          alert('Erro! Tente novamente mais tarde.')
        })
    },
    abrirComentarios () {
      this.exibirComentario = !this.exibirComentario
    },
    comentar (id) {
      if (!this.textoComentario) return

      let url = ''

      if (this.$route.name === 'Home') {
        url = 'conteudo/comentar/'
      } else {
        url = 'conteudo/comentarpagina/'
      }

      this.$http
        .put(`${this.$urlAPI+url+id}`,
          { texto: this.textoComentario },
          { 'headers': {'authorization': `Bearer ${this.$store.getters.getToken}`} })
        .then(response => {
          if (response.status) {
            this.textoComentario = '';
            this.$store.commit('setConteudosLinhaTempo', response.data.lista.conteudos.data)
          } else {
            alert(response.data.erro)
          }
        })
        .catch(e => {
          alert('Erro! Tente novamente mais tarde.')
        })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
