<template>
  <site-template>
    <span slot="menuesquerdo">
      <div class="row valign-wrapper">
        <grid-vue tamanho="4">
          <router-link :to="'/pagina/'+donoPagina.id+'/'+$slug(donoPagina.name || '', {lower:true})">
            <img :src="donoPagina.imagem" :alt="donoPagina.name" class="circle responsive-img">
          </router-link>
        </grid-vue>
        <grid-vue tamanho="8">
          <span class="black-text">
            <router-link :to="'/pagina/'+donoPagina.id+'/'+$slug(donoPagina.name || '', {lower:true})">
              <h5>{{donoPagina.name}}</h5>
            </router-link>
            <button
              v-if="exibeBtnSeguir"
              @click="amigo(donoPagina.id)"
              class="btn waves-effect waves-light blue">
              {{textoBtnSeguir}}
            </button>
          </span>
        </grid-vue>
      </div>
    </span>

    <span slot="menuesquerdoamigos">
      <h4>Seguindo</h4>
      <ul>
        <li v-for="item in amigos" :key="item.id">
          <router-link :to="'/pagina/'+item.id+'/'+$slug(item.name || '', {lower:true})">
            {{item.name}}
          </router-link>
        </li>
        <li v-if="!amigos.length">Nenhum Usuário</li>
      </ul>

      <h4>Seguidores</h4>
      <ul>
        <li v-for="item in seguidores" :key="item.id">
          <router-link :to="'/pagina/'+item.id+'/'+$slug(item.name || '', {lower:true})">
            {{item.name}}
          </router-link>
        </li>
        <li v-if="!seguidores.length">Nenhum Usuário</li>
      </ul>
    </span>

    <span slot="principal">
      <publicar-conteudo-vue/>

      <card-conteudo-vue
        v-for="item in listaConteudos"
        :key="item.id"
        :idconteudo="item.id"
        :totalcurtidas="item.total_curtidas"
        :comentarios="item.comentarios"
        :curtiuconteudo="item.curtiu_conteudo"
        :usuarioid="item.user.id"
        :perfil="item.user.imagem"
        :nome="item.user.name"
        :data="item.data">

        <card-detalhe-vue
          :img="item.imagem"
          :titulo="item.titulo"
          :txt="item.texto"
          :link="item.link"/>
      </card-conteudo-vue>

      <button
        v-if="urlProximaPagina"
        @click="carregarPaginacao()"
        class="btn waves-effect waves-light blue">
        Mais...
      </button>
      <!-- <span v-scroll="handleScroll"></span> -->
    </span>
  </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'
import GridVue from '@/components/layouts/GridVue'
import CardConteudoVue from '@/components/social/CardConteudoVue'
import CardDetalheVue from '@/components/social/CardDetalheVue'
import PublicarConteudoVue from '@/components/social/PublicarConteudoVue'

export default {
  name: 'Pagina',
  data () {
    return {
      usuario: { imagem: '', name: '' },
      urlProximaPagina: null,
      pararScroll: false,
      donoPagina: { imagem: '', name: '' },
      exibeBtnSeguir: false,
      textoBtnSeguir: 'Seguir',
      amigos: [],
      amigosLogado: [],
      seguidores: []
    }
  },
  components: {
    SiteTemplate,
    GridVue,
    CardConteudoVue,
    CardDetalheVue,
    PublicarConteudoVue
  },
  created () {
    this.atualizaPagina()
  },
  computed: {
    listaConteudos () {
      return this.$store.getters.getConteudosLinhaTempo
    }
  },
  watch: {
    '$route': 'atualizaPagina'
  },
  methods: {
    amigo (id) {
      this.$http
        .post(`${this.$urlAPI}usuario/amigo`, { id: id },
          { 'headers': {'authorization': `Bearer ${this.$store.getters.getToken}`} })
        .then(response => {
          if (response.data.status) {
            // console.log(response);
            this.amigosLogado = response.data.amigos
            this.seguidores = response.data.seguidores
            this.ehAmigo()
          } else {
            alert(response.data.erro)
          }
        })
        .catch(e => {
          alert('Erro! Tente novamente mais tarde.')
        })
    },
    ehAmigo () {
      for (let amigo of this.amigosLogado) {
        if (amigo.id === this.donoPagina.id) {
          this.textoBtnSeguir = 'Remover'
          return
        }
      }
      this.textoBtnSeguir = 'Seguir'
    },
    atualizaPagina () {
      let usuarioSession = this.$store.getters.getUsuario
    if (usuarioSession) {
      this.usuario = this.$store.getters.getUsuario

      this.$http
        .get(`${this.$urlAPI}conteudo/pagina/listar/${this.$route.params.id}`,
          {'headers': {'authorization': `Bearer ${this.$store.getters.getToken}`}})
        .then(response => {
          if (response.data.status) {
            this.$store.commit('setConteudosLinhaTempo', response.data.conteudos.data)
            this.urlProximaPagina = response.data.conteudos.next_page_url
            this.donoPagina = response.data.dono

            if (this.donoPagina.id !== this.usuario.id) {
              this.exibeBtnSeguir = true
            } else {
              this.exibeBtnSeguir = false
            }

            // requisição para 'amigos'
            this.$http
              .get(`${this.$urlAPI}usuario/listaamigospagina/${this.donoPagina.id}`,
                {'headers': {'authorization': `Bearer ${this.$store.getters.getToken}`}})
              .then(response => {
                if (response.data.status) {
                  this.amigos = response.data.amigos
                  this.amigosLogado = response.data.amigoslogado
                  this.ehAmigo()
                  this.seguidores = response.data.seguidores
                } else {
                  alert(response.data.erro)
                }
              })
              .catch(e => {
                alert('Erro! Tente novamente mais tarde.')
              })
          }
        })
        .catch(e => {
          alert('Erro! Tente novamente mais tarde.')
        })
    }
    },
    carregarPaginacao () {
      if (!this.urlProximaPagina) return

      this.$http
        .get(this.urlProximaPagina, {'headers': {'authorization': `Bearer ${this.$store.getters.getToken}`}})
        .then(response => {
          if (response.data.status && this.$route.name === 'Pagina') {
            this.$store.commit('setPaginacaoConteudosLinhaTempo', response.data.conteudos.data)
            this.urlProximaPagina = response.data.conteudos.next_page_url
            this.pararScroll = false
          }
        })
        .catch(e => {
          alert('Erro! Tente novamente mais tarde.')
        })
    },
    handleScroll () {
      if (this.pararScroll) return

      if (window.scrollY >= document.body.clientHeight - 1000) {
        this.pararScroll = true
        this.carregarPaginacao();
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
