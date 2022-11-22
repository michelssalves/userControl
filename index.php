<?php include_once 'config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/skull.png">
    <title>User Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> 
</head>
<body>
    <div class="container">
        <div class="row mt-4">
            <!-- d-flex deixa todos os itens da div em uma linha só-->
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4>User List</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#registerUserModal">
                        Register
                    </button>
                </div>
            </div>
        </div>
        <hr>
        <span id="msgAlert"></span>
        <div class="row">
            <div class="col-lg-12">
                <span class="listar-usuarios"></span>
            </div>
        </div>
    </div>
    <!-- INICIO MODAL REGISTRAR -->
    <div class="modal fade" id="registerUserModal" tabindex="-1" aria-labelledby="registerUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="registerUserModalLabel">User Registration</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <span id="msgAlertErrorCad"></span>
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Name:</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-outline-primary btn-sm" id="registerButton" value="Register" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM MODAL REGISTRAR -->
    <!-- INICIO MODAL VISUALIZAR -->
    <div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="showUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="showUserModalLabel">Show User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span id="msgAlertErrorCad"></span>
                    <dl class="row">
                        <dt class="col-sm-3">Id</dt>
                        <dd class="col-sm-9"><span id="idUser"></span></dd>

                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9"><span id="nameUser"></span></dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9"><span id="emailUser"></span></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM MODAL VISUALIZAR -->
    <!-- INICIO MODAL ALTERAR -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editUserModalLabel">Change User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <span id="msgAlertErrorEdit"></span>
                        <div class="mb-3">
                            <input type="hidden" name="id" id="editId" >
                        </div>
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Name:</label>
                            <input type="text" name="name" class="form-control" id="editName" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" name="email" class="form-control" id="editEmail" placeholder="Email" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-outline-primary btn-sm" id="editButton" value="Save Changes" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM MODAL ALTERAR -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="./assets/js/custom.js"></script>
</body>
</html>