import Client from "./clients/Client"

const resource = "/map"

export default {
    createMap(payload) {
      return Client.post(`${resource}`, payload)
    },
    getMap(id) {
        return Client.get(`${resource}/${id}`)
    },
}
