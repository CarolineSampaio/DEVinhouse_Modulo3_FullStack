import { describe, expect, it, vi } from 'vitest'
import FormPet from './FormPet.vue'
import { flushPromises, mount } from '@vue/test-utils'

import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { concatId } from '../utils/tests/getComponent'

import BreedService from '../services/BreedService'
import SpecieService from '../services/SpecieService'
import PetService from '../services/PetService'

const vuetify = createVuetify({
  components,
  directives
})

global.ResizeObserver = require('resize-observer-polyfill')

describe('Tela de cadastro de pet', () => {
  vi.spyOn(BreedService, 'getAllBreeds').mockResolvedValue([
    {
      id: 1,
      name: 'Caramelo'
    },
    {
      id: 2,
      name: 'RottWeiler'
    }
  ])

  vi.spyOn(SpecieService, 'getAllSpecies').mockResolvedValue([
    {
      id: 1,
      name: 'Gato'
    },
    {
      id: 2,
      name: 'Cachorro'
    }
  ])

  it('Espera-se que a tela seja renderizada', () => {
    const component = mount(FormPet, {
      global: {
        plugins: [vuetify]
      }
    })

    expect(component).toBeTruthy()
  })

  it('Espera-se que a o input de idade do pet aceite somente números', () => {
    const createPet = vi.spyOn(PetService, 'createPet').mockResolvedValue({})
    const component = mount(FormPet, {
      global: {
        plugins: [vuetify]
      }
    })

    component.getComponent(concatId('input-name')).setValue('Totozinho')
    // o valor so pode ser número pois o input é tipo number
    component.getComponent(concatId('input-age')).setValue('8')
    component.getComponent(concatId('input-weight')).setValue('6.8')

    component.getComponent(concatId('select-size')).setValue('LARGE')
    component.getComponent(concatId('select-breed')).setValue('1')
    component.getComponent(concatId('select-specie')).setValue('2')

    component.getComponent(concatId('submit-button')).trigger('submit')

    expect(createPet).toBeCalledWith({
      name: 'Totozinho',
      age: '8',
      weight: '6.8',
      size: 'LARGE',
      specie_id: '2',
      breed_id: '1'
    })
  })

  it('Espera-se que ao submenter o formulário, seja cadastrado o pet com os valores correto', () => {
    const createPet = vi.spyOn(PetService, 'createPet').mockResolvedValue({})

    const component = mount(FormPet, {
      global: {
        plugins: [vuetify]
      }
    })

    component.getComponent(concatId('input-name')).setValue('Totozinho')
    component.getComponent(concatId('input-age')).setValue('12')
    component.getComponent(concatId('input-weight')).setValue('6.8')

    component.getComponent(concatId('select-size')).setValue('LARGE')
    component.getComponent(concatId('select-breed')).setValue('1')
    component.getComponent(concatId('select-specie')).setValue('2')

    component.getComponent(concatId('submit-button')).trigger('submit')

    expect(createPet).toBeCalledWith({
      name: 'Totozinho',
      age: '12',
      weight: '6.8',
      size: 'LARGE',
      specie_id: '2',
      breed_id: '1'
    })
  })

  it('Espera-se que ao submeter o formulário sem as informações obrigatórias, exiba os erros em tela', async () => {
    const component = mount(FormPet, {
      global: {
        plugins: [vuetify]
      }
    })

    component.getComponent(concatId('submit-button')).trigger('submit')

    await flushPromises()

    expect(component.text()).toContain('O nome é obrigatório')
    expect(component.text()).toContain('O tamanho é obrigatório')
    expect(component.text()).toContain('A espécie é obrigatória')
    expect(component.text()).toContain('A raça é obrigatória')

    component.getComponent(concatId('input-name')).setValue('Totozinho')
    component.getComponent(concatId('submit-button')).trigger('submit')

    await flushPromises()

    expect(component.text()).not.toContain('O nome é obrigatório')
  })

  it('Espera-se que ao submeter o formulário e receber um error, exiba um mensagem de error na tela', async () => {
    vi.spyOn(PetService, 'createPet').mockRejectedValue(new Error())

    const component = mount(FormPet, {
      global: {
        plugins: [vuetify]
      }
    })

    component.getComponent(concatId('input-name')).setValue('Totozinho')
    component.getComponent(concatId('input-age')).setValue('12')
    component.getComponent(concatId('input-weight')).setValue('6.8')

    component.getComponent(concatId('select-size')).setValue('LARGE')
    component.getComponent(concatId('select-breed')).setValue('1')
    component.getComponent(concatId('select-specie')).setValue('2')

    component.getComponent(concatId('submit-button')).trigger('submit')

    await flushPromises()

    expect(component.text()).toContain('Houve um erro ao cadastrar o pet')
  })
})
