import Client from "./clients/Client"

const resource = "/rover"

export default {
    createRover(payload) {
        return Client.post(`${resource}`, payload)
    },
    moveRover(id, payload) {
      return Client.post(`${resource}/${id}/move`, payload)
    },
}
