import { route } from "./routes"

class Api {
    construct () {
        console.log(route);
    }

    getApiRoutes(routeName) {
      return {
        'api-get-auth-user' : {
          'url': '{{ route("api-get-auth-user") }}',
          'method': 'GET'
        },
        'api-get-company-tables' : {
          'url': '{{ route("api-get-company-tables") }}',
          'method': 'GET'
        },
      }[routeName]
    }

    async connect(routeName, data, callbackOk, callbackKo) {
      const self = this;
      let queryString = ''
      const loading = {
        value: true
      }

      if (self.getApiRoutes(routeName).method === 'GET' && (data !== null && Object.keys(data).length)) {
          queryString = '?' + Object.keys(data).map(key => key + '=' + data[key]).join('&');
      }

      return await fetch(self.getApiRoutes(routeName).url + queryString, {
        method: self.getApiRoutes(routeName).method,
        headers: {
          'Content-Type': 'application/json'
        },
        body: self.getApiRoutes(routeName).method !== 'GET' ? JSON.stringify(data) : null
      })
        .then(res => {
          if (!res.ok) {
            const error = new Error(res.statusText);
            error.json = res.json();
            throw error;
          }

          return res.json();
        })
        .then(json => {
          callbackOk(json)
        })
        .catch(err => {
          callbackKo(err);
        })
        .then(() => {
          loading.value = false;
        });
    }
  }
