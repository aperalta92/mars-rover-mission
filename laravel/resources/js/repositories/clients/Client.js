import axios from "axios"

const baseDomain = "http://www.mars-rover-mission.com"
const baseURL = `${baseDomain}/api/v1`

export default axios.create({
  baseURL,
  headers: {
    "Content-Type": "application/json"
  }
})
