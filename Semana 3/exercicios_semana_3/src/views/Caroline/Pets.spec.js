import { flushPromises, mount } from '@vue/test-utils'
import { describe, expect, it, vi } from 'vitest'
import Pets from './Pets.vue'
import PetService from '@/services/PetService'

import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives
})

global.ResizeObserver = require('resize-observer-polyfill')

describe('Tela de listagem de pets', () => {
  vi.spyOn(PetService, 'getAllPets').mockResolvedValue([
    {
      id: 1,
      pet_name: 'Rex',
      age: 2,
      breed: { name: 'Golden', id: 1 }
    },
    {
      id: 2,
      pet_name: 'Luna',
      age: 3,
      breed: { name: 'Poodle', id: 2 }
    }
  ])

  it('Espera-se que a tela seja renderizada', () => {
    const component = mount(Pets, {
      global: {
        plugins: [vuetify]
      }
    })

    expect(component).toBeTruthy()
  })

  it('Espera-se que liste um card para cada pet', async () => {
    const component = mount(Pets, {
      global: {
        plugins: [vuetify]
      }
    })

    await flushPromises()

    expect(component.text()).toContain('Rex')
    expect(component.text()).toContain('Luna')

    expect(component.findAll("[data-test='item-pet']")).toHaveLength(2)
  })

  it('Espera-se que navegue para o perfil do pet clicado', async () => {
    const mockRouter = {
      push: vi.fn()
    }

    const component = mount(Pets, {
      global: {
        plugins: [vuetify],
        mocks: {
          $router: mockRouter
        }
      }
    })

    await flushPromises()

    component.findAll("[data-test='item-pet']")[0].trigger('click')
    expect(mockRouter.push).toHaveBeenCalledWith('/pets-adocao-2/1/perfil')
  })

  it('Espera-se que a busca filtre os pets', async () => {
    const component = mount(Pets, {
      global: {
        plugins: [vuetify]
      }
    })

    await flushPromises()

    component.getComponent("[data-test='input-search']").setValue('Rex')
    component.getComponent("[data-test='input-search']").trigger('input')

    expect(component.text()).toContain('Rex')

    //campo de busca vazio retorna todos os pets
    component.getComponent("[data-test='input-search']").setValue('')
    component.getComponent("[data-test='input-search']").trigger('input')

    await flushPromises()

    expect(component.text()).toContain('Rex')
    expect(component.text()).toContain('Luna')
  })
})
