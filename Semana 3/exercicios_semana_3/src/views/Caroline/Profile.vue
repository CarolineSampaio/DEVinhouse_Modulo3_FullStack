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

    <div v-if="pet" class="my-auto" width="80%">
      <v-row class="mx-auto mt-16">
        <v-col cols="12" md="6">
          <h1 class="mx-16 mt-5 mt-md-1 text-amber-accent-4" data-test="pet-name">
            <v-icon size="large">mdi-paw-outline</v-icon> AUmigo: <b>{{ pet.name }}</b>
          </h1>

          <v-col cols="12" md="8">
            <v-img :src="imagens[pet.id % this.imagens.length]" height="400px" fill></v-img>
          </v-col>

          <v-list class="px-5 px-md-16 text-md-body-1" width="80%">
            <v-list-item class="px-16 py-2" data-test="pet-breed">
              <b>Raça: </b>{{ pet.breed.name }}
            </v-list-item>
            <v-list-item class="px-16 py-2" data-test="pet-specie">
              <b>Espécie:</b> {{ pet.specie.name }}
            </v-list-item>
            <v-list-item class="px-16 py-2" data-test="pet-age">
              <b>Idade:</b> {{ pet.age }} ano(s)
            </v-list-item>
            <v-list-item class="px-16 py-2" data-test="pet-weight">
              <b>Peso:</b> {{ pet.weight }} kg
            </v-list-item>
            <v-list-item class="px-16 py-2" data-test="pet-size">
              <b>Porte:</b> {{ this.translateWeight(pet.size) }}
            </v-list-item>
          </v-list>
        </v-col>

        <v-col cols="12" md="6" class="pr-16">
          <v-card class="px-10 pb-2 mt-md-n5 pt-5 formCard">
            <h1 class="mt-5 mt-md-1 mb-8 text-amber-accent-4">
              <v-icon size="large">mdi-list-box-outline</v-icon> Formulário de Adoção
            </h1>

            <p class="text-md-body-1 px-5">
              Se encantou pelo <b>{{ pet.name }}</b> e está pronto para proporcionar a ele um lar
              amoroso? Preencha o formulário abaixo e entraremos em contato para dar início ao
              processo de adoção responsável.
            </p>

            <p class="text-md-body-1 px-5 pt-4">
              <b>Estamos localizados na Grande São Paulo</b>
            </p>

            <v-form @submit.prevent="handleAdoption" class="px-5 py-8">
              <v-text-field
                v-model="name"
                label="Nome completo"
                type="text"
                :error-messages="errors.name"
                variant="outlined"
                class="pb-2"
                data-test="input-name"
              ></v-text-field>

              <v-text-field
                v-model="email"
                label="E-mail"
                type="email"
                :error-messages="errors.email"
                variant="outlined"
                class="pb-2"
                data-test="input-email"
              ></v-text-field>

              <v-text-field
                v-model="contact"
                label="Telefone"
                type="text"
                :error-messages="errors.contact"
                variant="outlined"
                class="pb-2"
                data-test="input-contact"
              ></v-text-field>

              <v-textarea
                v-model="observations"
                label="Conte-nos um pouco sobre você, sua casa e a rotina da sua família"
                type="text"
                :error-messages="errors.observations"
                variant="outlined"
                class="pb-2"
                data-test="input-observations"
              ></v-textarea>

              <v-btn
                type="submit"
                color="amber-accent-4 text-white"
                class="font-weight-bold"
                size="large"
                variant="flat"
                data-test="submit-button"
              >
                Enviar
              </v-btn>
            </v-form>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </v-app>

  <v-snackbar v-model="message" timeout="3000" color="success" location="top">
    Formulário enviado com sucesso!
  </v-snackbar>
</template>

<script>
import * as yup from 'yup'
import { captureErrorYup } from '../../utils/captureErrorYup'
import PetService from '../../services/PetService'
export default {
  data() {
    return {
      pet: null,
      name: '',
      email: '',
      contact: '',
      observations: '',
      errors: {},
      message: false,

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
    translateWeight(name) {
      switch (name) {
        case 'SMALL': {
          return 'Pequeno'
        }
        case 'MEDIUM': {
          return 'Médio'
        }
        case 'LARGE': {
          return 'Grande'
        }
        case 'EXTRA_LARGE': {
          return 'Gigante'
        }
        default: {
          return name
        }
      }
    },
    handleAdoption() {
      const schema = yup.object().shape({
        name: yup
          .string()
          .min(6, 'Seu nome completo deve possuir no mínimo 6 caracteres')
          .required('Digite seu nome completo.'),
        email: yup
          .string()
          .email('Forneça um endereço de email válido')
          .required('E-mail é obrigatório.'),
        contact: yup.string().required('Um telefone para contato é obrigatório.'),
        observations: yup
          .string()
          .min(20, 'Conte-nos um pouco mais sobre você e sua família')
          .required('É obrigatório nos contar um pouco sobre você e sua família')
      })
      try {
        schema.validateSync(
          {
            name: this.name,
            email: this.email,
            contact: this.contact,
            observations: this.observations
          },
          { abortEarly: false }
        )
        this.errors = {}

        PetService.adoptPet({
          name: this.name,
          email: this.email,
          contact: this.contact,
          observations: this.observations
        })
          .then(() => {
            alert('Cadastrado com sucesso')
            this.name = ''
            this.email = ''
            this.contact = ''
            this.observations = ''
            this.message = true
          })
          .catch(() => {
            alert('Erro ao tentar realizar a adocao')
          })
      } catch (error) {
        if (error instanceof yup.ValidationError) {
          console.log(error)
          this.errors = captureErrorYup(error)
        }
      }
    }
  },
  mounted() {
    const id = this.$route.params.id
    PetService.getOnePet(id).then((data) => {
      this.pet = data
    })
  }
}
</script>

<style scoped>
.v-list-item:nth-child(even) {
  background-color: #f2f2f2; /* Cor de fundo para linhas pares (cinza) */
}

.v-list-item:nth-child(odd) {
  background-color: #fff; /* Cor de fundo para linhas ímpares (branco) */
}

.font-weight-bold {
  font-weight: bold;
}

.formCard {
  border-radius: 1rem;

  box-shadow:
    12px 16px 28px -2px var(--v-shadow-key-umbra-opacity, rgba(0, 0, 0, 0.2)),
    0px 2px 2px 0px var(--v-shadow-key-penumbra-opacity, rgba(0, 0, 0, 0.14));
}
</style>
