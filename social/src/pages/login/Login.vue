<template>
  <login-template>
    <span slot="menuesquerdo">
      <img
        src="https://static.quizur.com/i/b/5b035c77702c13.471891555b035c775c3ff9.54480388.png"
        class="responsive-img"/>
    </span>

    <span slot="principal">

      <h2>Login</h2>

      <input type="text" placeholder="E-mail" v-model="usuario.email">
      <input type="password" placeholder="Senha" v-model="usuario.password">

      <button class="btn" @click="login">Entrar</button>
      <router-link to="/cadastro" class="btn orange">Cadastre-se</router-link>
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
        email: '',
        password: ''
      }
    }
  },
  components: {
    LoginTemplate
  },
  methods: {
    login () {
      this.$http.post(`${this.$urlAPI}login`, {
        email: this.usuario.email,
        password: this.usuario.password
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
          // login não existe
          alert('Login inválido.')
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
