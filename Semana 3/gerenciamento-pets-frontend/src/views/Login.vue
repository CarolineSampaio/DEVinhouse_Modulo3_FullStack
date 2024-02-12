<template>
  <form @submit.prevent="handleSubmit">
    <v-img
      class="mx-auto my-6"
      max-width="228"
      src="https://yt3.googleusercontent.com/N2jcFNzjfqRVZ07qkh3xn1VM7ka9Xa3O8o968DAOqoX4i1nRC_yv2hhcLfSf3tY5BJ6XcBuegg=s900-c-k-c0x00ffffff-no-rj"
    ></v-img>

    <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
      <v-alert
        v-if="showError"
        title="Houve um erro ao realizar o login"
        color="error"
        closable
      ></v-alert>

      <div class="text-subtitle-1 text-medium-emphasis mt-4">Account</div>

      <v-text-field
        density="compact"
        placeholder="Email address"
        prepend-inner-icon="mdi-email-outline"
        variant="outlined"
        v-model="email"
        data-test="input-email"
      />

      <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
        Password
      </div>

      <v-text-field
        :append-inner-icon="visible ? 'mdi-eye' : 'mdi-eye-off'"
        :type="visible ? 'text' : 'password'"
        density="compact"
        placeholder="Enter your password"
        prepend-inner-icon="mdi-lock-outline"
        variant="outlined"
        @click:append-inner="visible = !visible"
        v-model="password"
        data-test="input-password"
      />

      <v-btn
        block
        class="mb-8"
        color="orange text-white"
        size="large"
        variant="flat"
        type="submit"
        data-test="submit-button"
      >
        Login
      </v-btn>
    </v-card>
  </form>
</template>

<script>
import AuthenticationService from '../services/AuthenticationService'
import api from '../services/api'

export default {
  data() {
    return {
      visible: false,
      email: '',
      password: '',
      showError: false
    }
  },
  methods: {
    handleSubmit() {
      AuthenticationService.login({
        email: this.email,
        password: this.password
      })
        .then(({ data }) => {
          api.defaults.headers.common.Authorization = `Bearer ${data.token}`
          localStorage.setItem('@token_petshop', data.token)
          localStorage.setItem('@permissions_petshop', JSON.stringify(data.permissions))
          this.$router.push('/home')
        })
        .catch((error) => {
          console.log(error)
          this.showError = true
        })
    }
  }
}
</script>
