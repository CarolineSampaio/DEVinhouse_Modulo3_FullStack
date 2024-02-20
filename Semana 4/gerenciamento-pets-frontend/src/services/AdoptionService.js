import api from './api'

class AdoptionService {
  async getAllAdoptions(search = '') {
    const response = await api.get(`adoptions?search=${search}`)
    return response.data
  }

  async approve(data) {
    const response = await api.post('adoptions/realized', data)
    return response.data
  }
}

export default new AdoptionService()
