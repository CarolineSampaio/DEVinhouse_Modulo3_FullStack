<template>
  <v-app>
    <v-app-bar color="amber-accent-4 pa-2" elevation="0">
      <v-toolbar-title class="ma-16 text-white font-weight-bold">
        <v-icon class="mr-2">mdi-paw</v-icon> SOS Melhor amigo
      </v-toolbar-title>

      <div class="mr-16">
        <router-link to="/home2">
          <v-btn class="text-white font-weight-bold" prepend-icon="mdi-home" size="large">
            Home
          </v-btn>
        </router-link>

        <router-link to="/pets-adocao-2">
          <v-btn
            class="text-white font-weight-bold"
            prepend-icon="mdi-cat"
            append-icon="mdi-dog"
            size="large"
          >
            Pets
          </v-btn>
        </router-link>
      </div>
    </v-app-bar>

    <div class="mt-16 pt-16 container">
      <v-row class="d-flex align-center justify-center">
        <v-col cols="12" md="6">
          <v-icon class="text-amber-accent-4" style="font-size: 50px">mdi-paw-outline</v-icon>
          <h1 class="my-5 text-amber-accent-4">Me leva para casa</h1>

          <div
            class="block-text"
            :style="smAndDown ? 'width:100%' : 'width:80%'"
            data-test="block-text"
          >
            <p class="my-4 text-h6 text-dark-grey">
              Nós cuidamos deles. <b>Agora deixe que eles cuidem de você.</b>
            </p>
            <p class="my-4 text-h6 text-dark-grey">
              Aqui a gente cuida de animais resgatados de áreas evacuadas de Minas Gerais e queremos
              compartilhar todo esse amor com mais pessoas por meio da adoção.
            </p>
            <p class="my-4 text-h6 text-dark-grey">
              Ter um animal de estimação traz benefícios para a saúde física e mental. É uma troca
              de amor e carinho que faz bem pra todo mundo. Leve um para casa: cuide dele e deixe
              que ele cuide de você também.
            </p>
          </div>

          <router-link to="pets-adocao-2">
            <v-btn
              variant="flat"
              color="amber-accent-4 text-white"
              class="font-weight-bold px-10 my-8 text-body-1"
              size="large"
              >Adotar
            </v-btn>
          </router-link>
        </v-col>
        <v-col cols="12" md="6">
          <v-img
            class="image"
            src="https://vale.com/documents/d/guest/imagem-dogs01"
            width="800px"
          ></v-img>
        </v-col>
      </v-row>
    </div>
  </v-app>
</template>

<script setup>
import { useDisplay } from 'vuetify'
const { smAndDown } = useDisplay()
</script>

<style>
html {
  overflow-y: auto !important;
}
</style>

<style scoped>
.container {
  width: 80%;
  margin: 0 auto;
  overflow: hidden;
}

.image {
  width: 100%;
  margin: 0 auto;
}

.block-text {
  text-align: justify;
}
</style>
```
