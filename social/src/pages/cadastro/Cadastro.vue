<template>
  <login-template>
    <span slot="menuesquerdo">
      <img
        src="https://static.quizur.com/i/b/5b035c77702c13.471891555b035c775c3ff9.54480388.png"
        class="responsive-img"/>
    </span>

    <span slot="principal">

      <h2>Cadastro</h2>

      <input type="text" placeholder="Nome" v-model="usuario.name">
      <input type="text" placeholder="E-mail" v-model="usuario.email">
      <input type="password" placeholder="Senha" v-model="usuario.password">
      <input type="password" placeholder="Confirme sua Senha" v-model="usuario.password_confirmation">

      <button class="btn" v-on:click="cadastro()">Enviar</button>
      <router-link to="/login" class="btn orange">Já tenho conta</router-link>
    </span>
  </login-template>
</template>

<script>
import LoginTemplate from '@/templates/LoginTemplate'

export default {
  name: 'Login',
  data () {
    return {
      usuario: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  components: {
    LoginTemplate
  },
  methods: {
    cadastro () {
      this.$http.post(`${this.$urlAPI}cadastro`, {
        name: this.usuario.name,
        email: this.usuario.email,
        password: this.usuario.password,
        password_confirmation: this.usuario.password_confirmation
      })
      .then(response => {
        if (response.data.status) {
          // login com sucesso
          this.$store.commit('setUsuario', response.data.usuario)
          sessionStorage.setItem('usuario', JSON.stringify(response.data.usuario))
          this.$router.push('/')
        } else if (response.data.status === false && response.data.validacao) {
          // erros de validação
          let erros = ''
          for (let erro of Object.values(response.data.erros)) {
            erros += erro + "\n"
          }
          alert(erros)
        } else {
          // Login inválido
          alert('Erro no cadastro. Tente novamente mais tarde.')
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
