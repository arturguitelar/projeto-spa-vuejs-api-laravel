<template>
  <span>
    <header>
      <nav-bar logo="Social" url="/" cor="blue">
        <!-- <li><router-link to="/">Home</router-link></li> -->
        <li v-if="!usuario"><router-link to="/login">Entrar</router-link></li>
        <li v-if="!usuario"><router-link to="/cadastro">Cadastrar</router-link></li>
        <li v-if="usuario"><router-link to="/perfil">{{usuario.name}}</router-link></li>
        <li v-if="usuario"><a v-on:click="sair()">Sair</a></li>
      </nav-bar>
    </header>

    <main>
      <div class="container">
        <div class="row">
          <grid-vue tamanho="4">
            <card-menu-vue>
              <slot name="menuesquerdo"/>
            </card-menu-vue>
            <card-menu-vue>
              <slot name="menuesquerdoamigos"/>
            </card-menu-vue>
          </grid-vue>
          <grid-vue tamanho="8">
            <slot name="principal"/>
          </grid-vue>
        </div>
      </div>
    </main>

    <footer-vue
      logo="Social"
      descricao="Rede Social criada através do curso da Udemy."
      cor="blue"
      ano="2018">
      <li><a class="grey-text text-lighten-3" href="#!">Home</a></li>
      <li><a class="grey-text text-lighten-3" href="#!">Blog</a></li>
      <li><a class="grey-text text-lighten-3" href="#!">Site</a></li>
      <li><a class="grey-text text-lighten-3" href="#!">Portifolio</a></li>
    </footer-vue>
  </span>
</template>

<script>
import NavBar from '@/components/layouts/NavBar'
import FooterVue from '@/components/layouts/FooterVue'
import GridVue from '@/components/layouts/GridVue'
import CardMenuVue from '@/components/layouts/CardMenuVue'

export default {
  name: 'SiteTemplate',
  data () {
    return {
      usuario: false
    }
  },
  components: {
    NavBar,
    FooterVue,
    GridVue,
    CardMenuVue
  },
  created () {
    let usuarioSession = this.$store.getters.getUsuario
    if (usuarioSession) {
      this.usuario = this.$store.getters.getUsuario
    } else {
      this.$router.push('/login')
    }
  },
  methods: {
    sair () {
      this.$store.commit('setUsuario', null)
      sessionStorage.clear()
      this.usuario = false
      this.$router.push('/login')
    }
  }
}
</script>

<style>

</style>
