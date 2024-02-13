import { flushPromises, mount } from '@vue/test-utils'
import { describe, expect, it, vi } from 'vitest'
import Profile from './Profile.vue'
import PetService from '@/services/PetService'

import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives
})

global.ResizeObserver = require('resize-observer-polyfill')

describe('Tela de perfil do pet', () => {
  const mockRoute = {
    params: {
      id: 1
    }
  }

  vi.spyOn(PetService, 'getOnePet').mockResolvedValue({
    id: 16,
    name: 'Totó',
    age: 12,
    weight: '8.4',
    size: 'MEDIUM',
    breed: {
      id: 2,
      name: 'PITBULL'
    },
    specie: {
      id: 1,
      name: 'Gato'
    }
  })

  it('Espera-se que a tela seja renderizada', () => {
    const component = mount(Profile, {
      global: {
        plugins: [vuetify],
        mocks: {
          $route: mockRoute
        }
      }
    })

    expect(component).toBeTruthy()
  })

  it('Espera-se que exiba as informações do pet', async () => {
    const component = mount(Profile, {
      global: {
        plugins: [vuetify],
        mocks: {
          $route: mockRoute
        }
      }
    })

    await flushPromises()

    expect(component.get("[data-test='pet-name']").text()).toContain('AUmigo: Totó')
    expect(component.get("[data-test='pet-breed']").text()).toContain('Raça: PITBULL')
    expect(component.get("[data-test='pet-specie']").text()).toContain('Espécie: Gato')
    expect(component.get("[data-test='pet-age']").text()).toContain('Idade: 12 ano(s)')
    expect(component.get("[data-test='pet-weight']").text()).toContain('Peso: 8.4 kg')
    expect(component.get("[data-test='pet-size']").text()).toContain('Porte: Médio')
  })

  it('Espera-se que ao submeter o formulário, seja enviado os dados corretamente', async () => {
    const adoptPet = vi.spyOn(PetService, 'adoptPet').mockRejectedValue([])

    const component = mount(Profile, {
      global: {
        plugins: [vuetify],
        mocks: {
          $route: mockRoute
        }
      }
    })

    await flushPromises()

    component.getComponent("[data-test='input-name']").setValue('Dona Maria')
    component.getComponent("[data-test='input-email']").setValue('donamaria@gmail.com')
    component.getComponent("[data-test='input-contact']").setValue('4002-8922')
    component
      .getComponent("[data-test='input-observations']")
      .setValue('Por conta do yupi a mensagem precisa ter no mínimo 20 caracteres')
    component.getComponent("[data-test='submit-button']").trigger('submit')

    expect(adoptPet).toBeCalledWith({
      name: 'Dona Maria',
      email: 'donamaria@gmail.com',
      contact: '4002-8922',
      observations: 'Por conta do yupi a mensagem precisa ter no mínimo 20 caracteres'
    })
  })

  it('Espera-se que exiba uma mensagem de erro caso os dados estejam inválidos', async () => {
    vi.spyOn(PetService, 'adoptPet').mockResolvedValue([])

    const component = mount(Profile, {
      global: {
        plugins: [vuetify],
        mocks: {
          $route: mockRoute
        }
      }
    })

    await flushPromises()

    component.getComponent("[data-test='input-name']").setValue('Dona Maria')
    component.getComponent("[data-test='input-email']").setValue('donamaria@gmail.com')
    component.getComponent("[data-test='input-contact']").setValue('4002-8922')
    component.getComponent("[data-test='input-observations']").setValue('gosto de gatos') //menos de 20 caracteres
    component.getComponent("[data-test='submit-button']").trigger('submit')

    await flushPromises()

    expect(component.getComponent("[data-test='input-observations']").text()).toContain(
      'Conte-nos um pouco mais sobre você e sua família'
    )
  })
})
