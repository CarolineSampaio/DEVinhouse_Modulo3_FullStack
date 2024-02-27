import { mount } from '@vue/test-utils'
import { describe, expect, it } from 'vitest'
import Home from './Home.vue'

import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives
})

global.ResizeObserver = require('resize-observer-polyfill')

describe('Tela Home', () => {
  it('Espera-se que a tela seja renderizada', () => {
    const component = mount(Home, {
      global: {
        plugins: [vuetify]
      }
    })

    expect(component).toBeTruthy()
  })

  it('Espera-se que o estilo lgAndUp para a largura seja aplicado na tela', () => {
    const component = mount(Home, {
      global: {
        plugins: [vuetify]
      }
    })

    //verifica se a largura da tela está em 80% para lgAndUp
    expect(component.find('.block-text').element.style.width).toBe('80%')
  })

  it('Espera-se que o estilo smAndDown para a largura seja aplicado na tela', () => {
    const component = mount(Home, {
      global: {
        plugins: [vuetify]
      }
    })

    //simula uma tela pequena(sm)
    window.innerWidth = 600
    window.innerHeight = 800

    //dispara o evento de redimensionamento para que o componente reaja
    window.dispatchEvent(new Event('resize'))

    //aguarda a próxima atualização do ciclo de vida do Vue
    return component.vm.$nextTick().then(() => {
      //verifica se o estilo foi aplicado corretamente
      expect(component.find('.block-text').element.style.width).toBe('100%')
    })
  })
})
