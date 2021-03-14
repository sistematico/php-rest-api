export const ApiHandler2 = {
fetchUsers: function () {
let headers = new Headers()

fetch("https://api.lucasbrum.net/user/list", { method: 'GET', headers: headers, mode: 'cors'})
.then(response => response.json())
.then(data => {
this.lista = data.data
this.$refs.paginationComponent.paginatedData()
}).catch(error => {
this.alertClass = 'alert alert-danger'
console.log(error)
})
},
addUser: function () {
// const postOptions = {
//   method: "POST",
//   headers: { "Content-Type": "application/json" },
//   body: JSON.stringify({
//     fullname: this.nome,
//     username: this.usuario,
//     email: this.email,
//     password: this.senha
//   })
// };

let username = 'lucas', password = '123'
let headers = new Headers();
headers.append('Content-Type', 'application/json');
headers.append('Accept', 'application/json');
headers.append('Authorization', 'Basic ' + btoa(username + ":" + password));
headers.append('Origin', 'http://localhost:3000');

fetch('https://api.lucasbrum.net/user/insert', {
mode: 'cors',
credentials: 'include',
method: 'POST',
headers: headers,
body: JSON.stringify({
fullname: this.nome,
username: this.usuario,
email: this.email,
password: this.senha
})
})
.then(response => response.json())
.then(json => {
console.log(json.httpStatusCode)

switch (json.httpStatusCode) {
    case 200:
    case 201:
        this.alertClass = 'alert alert-success'
        break;
    default:
        this.alertClass = 'alert alert-danger'
}

this.mensagens = json.messages
})
.catch(error => {
this.alertClass = 'alert alert-danger'
this.mensagens = 'Erro: ' + error.message
})

this.fetchUsers()
},
fetchPaginatedData: function (value) {
//console.log("enlarging text");
this.paginatedResult = value

},


};