import axios from "axios";
import coreConfig from "../config"

export const httpClient = axios.create({
    baseURL: coreConfig.SYMFONY_URL
})

function setHeaders() {
    if (localStorage.getItem("jwt_admin")) {
        httpClient.defaults.headers.common['Authorization'] = `Bearer ` + localStorage.getItem("jwt_admin");
    } else {
        delete httpClient.defaults.headers.common['Authorization'];
    }
}
const symfonyApiService = {

    get(path) {
        setHeaders()
        return httpClient.get(path)
            .catch((error) => { throw new Error(error) })
    },
    post(path, body) {
        setHeaders()
        return httpClient.post(path, body)
            .catch((error) => { throw new Error(error) })
    },
    put(path, body) {
        setHeaders()
        return httpClient.put(path, body)
            .catch((error) => { throw new Error(error) })
    },
    delete(path) {
        setHeaders()
        return httpClient.delete(path)
            .catch((error) => { throw new Error(error) })
    }
}

export default symfonyApiService