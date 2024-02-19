<template>
  <div class="container">
    <h1>Adote um amigo!</h1>

    <form @submit.prevent="handleSearch">
      <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" v-model="filtros.nome" />
      </div>

      <div class="form-group">
        <label for="idade">Idade:</label>
        <input type="number" id="idade" v-model.number="filtros.idade" />
      </div>
    </form>

    <div class="pet-list">
      <div
        class="pet-item"
        v-for="pet in petsFiltrados"
        :key="pet.id"
        @click="redirectToProfile(pet.id)"
      >
        <img
          src="https://img.freepik.com/fotos-gratis/adoravel-cachorro-basenji-marrom-e-branco-sorrindo-e-dando-mais-uns-cinco-isolado-no-branco_346278-1657.jpg"
          alt="Doguinho joão"
        />
        <h2>{{ pet.pet_name }}</h2>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      pets: [],
      filtros: {
        nome: '',
        idade: null
      }
    }
  },

  methods: {
    redirectToProfile(petId) {
      this.$router.push(`/pets-adocao/${petId}/perfil`)
    },

    handleSearch() {
      axios
        .get('http://localhost:8000/api/pets/adocao')
        .then((response) => {
          this.pets = response.data
        })
        .catch(() => alert('Houve um erro'))
    }
  },

  computed: {
    petsFiltrados() {
      return this.pets.filter((pet) => {
        let passFilter = true
        if (
          this.filtros.nome &&
          pet.pet_name.toLowerCase().indexOf(this.filtros.nome.toLowerCase()) === -1
        ) {
          passFilter = false
        }
        if (this.filtros.idade !== null && pet.idade !== this.filtros.idade) {
          passFilter = false
        }

        return passFilter
      })
    }
  },

  mounted() {
    axios
      .get('http://localhost:8000/api/pets/adocao')
      .then((response) => {
        this.pets = response.data
      })
      .catch(() => alert('Houve um erro'))
  }
}
</script>

<style scoped>
.form-group {
  margin-bottom: 10px;
}

form {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

label {
  flex-basis: 100px;
}

.filters input {
  width: 50%;
  display: flex;
  gap: 10px;
}
.container {
  width: 70%;
  margin: 0 auto;
}
.pet-list {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
  gap: 10px;
}

.pet-item {
  border: 1px solid coral;
  padding: 5px;
  width: 30%;
  height: 200px;
  border-radius: 4px;
  flex-direction: column;
  display: flex;
  align-items: center;
  justify-content: center;
}

.pet-item:hover {
  box-shadow: 0 3px 10px rgb(0 0 0 / 0.7);
}

.pet-item img {
  width: 180px;
  border-radius: 5px;
}

.pet-item span {
  font-size: 18px;
  font-weight: bold;
  margin-top: 10px;
}
</style>
