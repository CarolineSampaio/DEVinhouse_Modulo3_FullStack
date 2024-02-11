<template>
  <div class="pet-info" v-if="pet">
    <ul>
      <div class="pet-image">
        <img
          src="https://img.freepik.com/fotos-gratis/adoravel-cachorro-basenji-marrom-e-branco-sorrindo-e-dando-mais-uns-cinco-isolado-no-branco_346278-1657.jpg"
          alt="Doguinho joão"
        />
      </div>
      <li>Raça: {{ pet.race.name }}</li>
      <li>Espécie: {{ pet.specie.name }}</li>
      <li>Idade: {{ pet.age }} Ano(s)</li>
      <li>Peso: {{ pet.weight }} Kg</li>
      <li>Porte: {{ pet.size }}</li>
    </ul>
  </div>
  <div>
    <form class="form" @submit.prevent="handleSubmit">
      <p>Adote seu amigo:</p>
      <div class="input-group">
        <label for="name">Nome</label>
        <input v-model="name" />
      </div>
      <div class="input-group">
        <label for="contact">Contato</label>
        <input v-model="contact" />
      </div>
      <div class="input-group">
        <label for="email">E-mail</label>
        <input v-model="email" type="email" />
      </div>

      <label for="observations">Nos conte o motivo de querer adotar esse pet:</label>
      <div class="input-group">
        <textarea name="observations" cols="50" rows="10" v-model="observations"></textarea>
      </div>
      <button class="button-style" type="submit">Adotar</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      pet: null,
      name: '',
      contact: '',
      email: '',
      observations: ''
    }
  },
  methods: {
    handleSubmit() {
      axios
        .post('http://127.0.0.1:8000/api/adocoes', {
          name: this.name,
          contact: this.contact,
          email: this.email,
          observations: this.observations
        })
        .then(() => {
          alert('Adoção cadastrada com sucesso')
        })
        .catch(() => {
          alert('Houve um erro ao fazer adoção')
        })
    }
  },
  mounted() {
    const id = this.$route.params.id
    axios.get(`http://127.0.0.1:8000/api/pets/${id}`).then((response) => {
      this.pet = response.data
    })
  }
}
</script>

<style scoped>
.pet-info {
  display: flex;
  align-items: center;
}

.pet-image img {
  max-width: 50%;
}

.form {
  display: flex;
  flex-direction: column;
  width: 30%;
}

.input-group {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

label {
  flex: 1;
  margin-right: 10px;
  text-align: right;
}

input,
textarea {
  flex: 3;
}

.button-style {
  align-self: flex-start;
  width: 20%;
}
</style>
