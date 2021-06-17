export const ApiHandler = {
    fetch: function (app) {
        const headers = new Headers()
        const options = { method: 'GET', headers: headers, mode: 'cors'}

        fetch("https://api.lucasbrum.net/user/list", options)
            .then(response => response.json())
            .then(json => {
                switch (json.httpStatusCode) {
                    case 200:
                    case 201:
                        app.alertClass = 'alert alert-success'
                        break
                    default:
                        app.alertClass = 'alert alert-danger'
                }
                if (typeof json.data !== 'undefined') {
                    app.registros = json.data
                } else {
                    app.registros = json.data = []
                }
                app.mensagem = json.messages
            }).catch(error => {
                app.alertClass = 'alert alert-danger'
                app.mensagem = 'Houve um erro na solicitação: ' + error
            })
    },
    add: function (app, fullname, username, email, password) {
        app.loading = true
        app.btnText = 'Processando...'

        let secret = Math.floor(+new Date() / 1000)
        const headers = new Headers()

        headers.append('Content-Type', 'application/json')
        headers.append('Accept', 'application/json')
        headers.append('Authorization', 'Basic ' + btoa(username + ":" + password))
        // headers.append('Origin', 'http://localhost:3000');
        headers.append('Origin', window.location.hostname)

        const body = { fullname, username, email, password, secret }
        const options = { mode: 'cors', credentials: 'include', method: 'POST', headers: headers, body: JSON.stringify(body) }

        fetch('https://api.lucasbrum.net/user/add', options)
            .then(response => response.json())
            .then(json => {
                switch (json.httpStatusCode) {
                    case 200:
                    case 201:
                        app.btnText = 'Adicionado'
                        app.alertClass = 'alert alert-success'
                        break
                    default:
                        app.btnText = 'Adicionar'
                        app.alertClass = 'alert alert-danger'
                }
                app.mensagem = json.messages
            }).catch(error => {
                app.btnText = 'Adicionar'
                app.alertClass = 'alert alert-danger'
                app.mensagem = 'Houve um erro na solicitação: ' + error
            })
        app.loading = false
    },
    del: function (app, id) {
        const headers = new Headers();
        headers.append('Content-Type', 'application/json');
        headers.append('Accept', 'application/json');
        //headers.append('Authorization', 'Basic ' + btoa(username + ":" + password));

        const body = { id }
        const options = { mode: 'cors', credentials: 'include', method: 'POST', headers, body: JSON.stringify(body) }

        fetch('https://api.lucasbrum.net/user/delete/' + id, options)
            .then(response => response.json())
            .then(json => {
                switch (json.httpStatusCode) {
                    case 200:
                    case 201:
                        app.alertClass = 'alert alert-success'
                        break
                    default:
                        app.alertClass = 'alert alert-danger'
                }
                app.mensagem = json.messages
            }).catch(error => {
                app.alertClass = 'alert alert-danger'
                app.mensagem = 'Houve um erro na solicitação: ' + error
            })
    }
};