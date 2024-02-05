import api from './api'

class ProfessionalService {
  async createProfessional(body) {
    const response = await api.post('professionals', body)
    return response.data
  }

  async getAllProfessionals() {
    const response = await api.get(`professionals`)
    return response.data
  }
}

export default new ProfessionalService()
