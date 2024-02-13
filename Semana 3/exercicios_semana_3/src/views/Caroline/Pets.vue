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
      <h1 class="my-5 text-amber-accent-4">Encontre seu melhor amigo</h1>

      <v-form class="d-flex align-center justify-center">
        <v-text-field
          v-model="search"
          label="Pesquisar por nome, raça, peso ou idade"
          prepend-inner-icon="mdi-magnify"
          class="mx-2"
          outlined
          dense
          @input="searchPets"
          data-test="input-search"
        ></v-text-field>
      </v-form>

      <v-row>
        <v-col cols="6" md="3" v-for="pet in FilteredPets" :key="pet.id" class="pa-5">
          <v-card
            data-test="item-pet"
            @click="redirectToProfile(pet.id)"
            class="PetsCards"
            variant="flat"
          >
            <v-img :src="imagens[pet.id % imagens.length]" height="400px" cover></v-img>
            <v-card-title class="text-h5 text-amber-accent-4 font-weight-bold">{{
              pet.pet_name
            }}</v-card-title>
            <v-card-subtitle class="text-body-1">Raça: {{ pet.breed.name }}</v-card-subtitle>
            <v-card-text class="text-body-1 pt-2">Idade: {{ pet.age }} anos</v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </v-app>
</template>

<script>
import axios from 'axios'
import PetService from '../../services/PetService'

export default {
  data() {
    return {
      pets: [],
      search: '',
      FilteredPets: [],
      imagens: [
        'https://i.pinimg.com/564x/94/af/b4/94afb47cacb76da8586a729a82c39dc2.jpg',
        'https://i.pinimg.com/564x/96/ca/98/96ca9814aecaa525461b638a3e447093.jpg',
        'https://i.pinimg.com/736x/a7/32/82/a732824b5f1de413123d5ecc4b2caecd.jpg',
        'https://i.pinimg.com/564x/4a/46/fd/4a46fd4c8392251174d2dc4f329d3c7a.jpg',
        'https://i.pinimg.com/564x/21/ab/9f/21ab9fcced5a0a40a95bd10dafcafa66.jpg',
        'https://i.pinimg.com/564x/70/cf/9c/70cf9cf849de134bf106ac476bdee4b8.jpg',
        'https://i.pinimg.com/564x/23/0e/54/230e54a61f2a0fc5ee0663da3231c427.jpg',
        'https://i.pinimg.com/564x/86/77/e2/8677e21e07a8ae3fadcfc14eebc7d128.jpg'
      ]
    }
  },
  methods: {
    redirectToProfile(petId) {
      this.$router.push(`/pets-adocao-2/${petId}/perfil`)
    },
    searchPets() {
      axios
        .get('http://localhost:8000/api/pets/adocao', {
          params: {
            search: this.search
          }
        })
        .then((response) => {
          this.FilteredPets = response.data
        })
        .catch(() => alert('Houve um erro. Entre em contato com a ONG'))
    }
  },
  mounted() {
    PetService.getAllPets()
      .then((data) => {
        this.pets = this.FilteredPets = data
      })
      .catch(() => alert('Houve um erro. Entre em contato com a ONG'))
  }
}
</script>
<style scoped>
.container {
  width: 80%;
  margin: 0 auto;
}

.PetsCards {
  border-radius: 1rem;
  background: linear-gradient(
    130deg,
    rgb(216, 216, 216) 0%,
    rgb(255, 255, 255) 80%,
    rgb(216, 216, 216) 100%
  );
  box-shadow:
    12px 16px 28px -2px var(--v-shadow-key-umbra-opacity, rgba(0, 0, 0, 0.2)),
    0px 2px 2px 0px var(--v-shadow-key-penumbra-opacity, rgba(0, 0, 0, 0.14));
}
.PetsCards:hover {
  transform: scale(1.05);
  transition: 0.3s;
}
</style>
