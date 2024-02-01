import api from './api'

class BreedService {
  async createBreed() {}

  async getAllBreeds() {
    const response = await api.get('breeds')
    return response.data
  }
}

export default new BreedService()
