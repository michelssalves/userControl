const tbody = document.querySelector(".listar-usuarios")
const cadForm = document.getElementById("registerForm")
const editForm = document.getElementById("editForm")
const msgAlertErrorCad = document.getElementById("msgAlertErrorCad")
const msgAlertErrorEdit = document.getElementById("msgAlertErrorEdit")
const msgAlert = document.getElementById("msgAlert")
const cadModal = new bootstrap.Modal(document.getElementById("registerUserModal"))


const listUsers = async (page) => {

    const action = 'listUser'
    const dados = await fetch(`assets/controllers/userControl.php?page=${page}&action=${action}`)
    console.log(dados)
    const response = await dados.text()
    console.log(response)
    tbody.innerHTML = response

}

listUsers(1)

cadForm.addEventListener("submit", async (e) => {
    e.preventDefault()

    document.getElementById("registerButton").value = 'Saving ...'

    if (document.getElementById("name").value === "") {
        msgAlertErrorCad.innerHTML = "<div class='alert alert-danger' role='alert'>Name field is required 1!</div>"
    } else if (document.getElementById("email").value === "") {
        msgAlertErrorCad.innerHTML = "<div class='alert alert-danger' role='alert'>Email field is required 1!</div>"
    } else {
        const dadosForm = new FormData(cadForm)
        dadosForm.append("add", 1)
        const action = 'registerUser'
        const dados = await fetch(`assets/controllers/userControl.php?action=${action}`, {
            method: "POST",
            body: dadosForm,
        })
        const response = await dados.json();
        console.log(response)
        if (response['error']) {
            msgAlertErrorCad.innerHTML = response['msg']
        } else {
            msgAlert.innerHTML = response['msg']
            cadForm.reset()
            cadModal.hide()
            listUsers(1)
        }
    }
    document.getElementById("registerButton").value = 'Register'
})

async function showUser(id) {

    const action = 'viewUser'
    const dados = await fetch(`assets/controllers/userControl.php?id=${id}&action=${action}`)
    const response = await dados.json()
    console.log(response)
    if (response['error']) {
        msgAlert.innerHTML = response['msg']
    } else {
        const viewModal = new bootstrap.Modal(document.getElementById("showUserModal"))
        viewModal.show()

        document.getElementById("idUser").innerHTML = response['dados'].id
        document.getElementById("nameUser").innerHTML = response['dados'].name
        document.getElementById("emailUser").innerHTML = response['dados'].email
    }
}

async function editUser(id) {

    msgAlertErrorEdit.innerHTML = ""

    const action = 'editUser'
    const dados = await fetch(`assets/controllers/userControl.php?id=${id}&action=${action}`)
    const response = await dados.json()

    if (response['error']) {
        msgAlert.innerHTML = response['msg']
    } else {

        const editModal = new bootstrap.Modal(document.getElementById("editUserModal"))
        editModal.show()
        document.getElementById("editId").value = response['dados'].id
        document.getElementById("editName").value = response['dados'].name
        document.getElementById("editEmail").value = response['dados'].email

    }


}

editForm.addEventListener("submit", async (e) => {
    e.preventDefault()

    document.getElementById("editButton").value = 'Saving ...'

    const dadosForm = new FormData(editForm)
    console.log(editForm)
    for (var dadosFormE of dadosForm.entries()) {
        console.log(dadosFormE[0] + " - " + dadosFormE[1])

    }
    const action = 'savingEditUser'
    const dados = await fetch(`assets/controllers/userControl.php?&action=${action}`, {
        method: "POST",
        body: dadosForm
    })

    const response = await dados.json()

    if (response['error']) {

        msgAlertErrorEdit.innerHTML = response['msg']

    } else {

        msgAlertErrorEdit.innerHTML = response['msg']
        document.getElementById("editButton").value = 'Save Changes'
        listUsers(1)
    }
})

async function deleteUser(id) {

    let confirmar = confirm("Are You sure you you want to DELETE?")

    if (confirmar == true) {

        const action = 'delUser'
        const dados = await fetch(`assets/controllers/userControl.php?id=${id}&action=${action}`)

        const response = await dados.json()
        console.log(dados)
        if (response['error']) {

            msgAlert.innerHTML = response['msg']

        } else {

            msgAlert.innerHTML = response['msg']
            listUsers(1)
        }
    }

}