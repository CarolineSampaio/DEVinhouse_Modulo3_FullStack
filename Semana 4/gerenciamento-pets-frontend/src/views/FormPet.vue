<template>
  <v-snackbar v-model="success" timeout="3000" color="success" location="top right">
    {{ petId ? 'Pet atualizado com sucesso!' : 'Pet Cadastrado com sucesso!' }}
  </v-snackbar>

  <form @submit.prevent="handleSubmit">
    <v-card
      width="80%"
      class="mx-auto px-6 mt-4"
      :title="petId ? 'Edição do pet' : 'Cadastro de pet'"
    >
      <v-alert
        v-if="showError"
        title="Houve um erro ao cadastrar o pet"
        color="error"
        closable
      ></v-alert>

      <v-row class="mt-4">
        <v-col cols="12" md="8">
          <v-text-field
            label="Nome"
            variant="outlined"
            v-model="name"
            :error-messages="errors.name"
            data-test="input-name"
          />
        </v-col>
        <v-col cols="12" md="2" sm="6">
          <v-text-field
            label="Idade"
            type="number"
            variant="outlined"
            v-model="age"
            :error-messages="errors.age"
            data-test="input-age"
          />
        </v-col>
        <v-col cols="12" md="2" sm="6">
          <v-text-field
            label="Peso"
            type="number"
            variant="outlined"
            v-model="weight"
            :error-messages="errors.weight"
            data-test="input-weight"
            step="0.1"
          />
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" md="4">
          <v-select
            label="Tamanho"
            :items="itemsSize"
            variant="outlined"
            placeholder="Selecione um item"
            v-model="size"
            :error-messages="errors.size"
            data-test="select-size"
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-select
            label="Espécie"
            :items="itemsSpecies"
            variant="outlined"
            placeholder="Selecione um espécie"
            v-model="specie_id"
            item-title="name"
            item-value="id"
            :error-messages="errors.specie_id"
            data-test="select-specie"
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-select
            label="Raça"
            :items="itemsBreeds"
            variant="outlined"
            placeholder="Selecione um raça"
            v-model="breed_id"
            item-title="name"
            item-value="id"
            :error-messages="errors.breed_id"
            data-test="select-breed"
          />
        </v-col>
      </v-row>

      <v-card-actions class="d-flex justify-end">
        <v-btn
          color="orange text-white"
          type="submit"
          variant="flat"
          class="font-weight-bold"
          data-test="submit-button"
        >
          {{ petId ? 'Editar' : 'Cadastrar' }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </form>
</template>

<script>
import { optionsSize } from '../constants/pet.constants'
import SpecieService from '../services/SpecieService'
import BreedService from '../services/BreedService'
import PetService from '../services/PetService'

import { schemaPetForm } from '../validations/pet.validations'
import { captureErrorYup } from '../utils/captureErrorYup'
import * as yup from 'yup'

export default {
  data() {
    return {
      name: '',
      age: 1,
      weight: 1,
      size: '',
      specie_id: '',
      breed_id: '',
      errors: {},
      showError: false,

      itemsSize: optionsSize,
      itemsSpecies: [],
      itemsBreeds: [],
      success: false,

      petId: this.$route.params.id
    }
  },
  mounted() {
    if (this.petId) {
      PetService.getOnePet(this.petId)
        .then((data) => {
          this.name = data.name
          this.age = data.age
          this.weight = data.weight
          this.size = data.size
          this.specie_id = data.specie_id
          this.breed_id = data.breed_id
        })
        .catch(() => alert('Houve um erro ao buscar o pet'))
    }

    SpecieService.getAllSpecies()
      .then((data) => {
        this.itemsSpecies = data
      })
      .catch(() => alert('Houve um erro ao buscar as opções'))

    BreedService.getAllBreeds().then((data) => {
      this.itemsBreeds = data
    })
  },
  methods: {
    handleSubmit() {
      try {
        const pet = {
          name: this.name,
          age: this.age,
          weight: this.weight,
          size: this.size,
          specie_id: this.specie_id,
          breed_id: this.breed_id
        }

        schemaPetForm.validateSync(pet, { abortEarly: false })

        if (this.petId) {
          PetService.updateOnePet(this.petId, pet)
            .then(() => {
              this.success = true
            })
            .catch(() => alert('Houve um erro ao atualizar o pet'))
          return
        }

        PetService.createPet(pet)
          .then(() => {
            this.success = true

            this.name = ''
            this.age = 1
            this.weight = 1
            this.size = ''
            this.specie_id = ''
            this.breed_id = ''
            this.errors = {}
          })
          .catch(() => (this.showError = true))
      } catch (error) {
        if (error instanceof yup.ValidationError) {
          this.errors = captureErrorYup(error)
        }
      }
    }
  }
}
</script>

<style scoped></style>
