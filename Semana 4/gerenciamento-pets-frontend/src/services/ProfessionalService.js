import api from './api'

class ProfessionalService {
  async createProfessional(body) {
    const response = await api.post('professionals', body)
    return response.data
  }

  async getAllProfessionals(text) {
    const response = await api.get(`professionals?text=${text}`)
    return response.data
  }
}

export default new ProfessionalService()
