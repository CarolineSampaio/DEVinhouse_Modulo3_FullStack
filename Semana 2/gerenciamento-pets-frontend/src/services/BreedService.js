import axios from 'axios'

class BreedService {
  async createBreed() {}

  async getAllBreeds() {
    const response = await axios.get('http://127.0.0.1:8000/api/breeds')
    return response.data
  }
}

export default new BreedService()
