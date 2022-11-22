<?php
include_once 'config.php';

$action = $_REQUEST['action'];

if ($action === 'listUser') {

    $page = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);

    if (!empty($page)) {
        $result_for_page = 10;
        $start = ($page * $result_for_page) - $result_for_page;
        $sql = "SELECT * FROM users WHERE deleted_at IS NULL ORDER BY id DESC LIMIT $start, $result_for_page ";
        $qry = $conn->prepare($sql);
        $qry->execute();

        $txtTable = "<div class='table-responsive'>
                <table class='table table-striped table-bordered'>
                    <thead class='table-dark'>
                        <tr class='align-middle'>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>";
        $pto = ',';
        while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $txtTable .= "<tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$email</td>
                    <td>
                    <button id='$id' class='btn btn-outline-primary btn-sm' onclick='showUser($id)'>To view</button>
                    <button id='$id' class='btn btn-outline-warning btn-sm' onclick='editUser($id)'>To edit</button>
                    <button id='$id' class='btn btn-outline-danger btn-sm' onclick='deleteUser($id)'>To delete</button>
                    </td>
                 </tr>";
        }

        $txtTable .= "</tbody>
                </table>
                </div>";
        // CONTA QUANTOS USUARIOS
        $sql = "SELECT COUNT(id) AS num_pages FROM users";
        $qry = $conn->prepare($sql);
        $qry->execute();
        $row = $qry->fetch(PDO::FETCH_ASSOC);

        //QUANTIDADE DE PAGINAS
        $number_pages = ceil($row['num_pages'] / $result_for_page);
        $max_link = 2;


        $txtTable .= '<nav aria-label="Page navigation example"><ul class="pagination pagination-sm justify-content-center">';

        $txtTable .= "<li class='page-item'><a class='page-link' onclick='listUsers(1)'>First Page</a></li>";

        for ($previous_page = $page - $max_link; $previous_page <= $page - 1; $previous_page++) {
            if ($previous_page >= 1) {
                $txtTable .= "<li class='page-item'><a class='page-link' href='#'onclick='listUsers($previous_page)'>$previous_page</a></li>";
            }
        }
        $txtTable .= "<li class='page-item active' ><a class='page-link' href='#'>$page</a></li>";

        for ($next_page = $page + 1; $next_page <= $page + $max_link; $next_page++) {
            if ($next_page <= $number_pages) {
                $txtTable .= "<li class='page-item'><a class='page-link' href='#' onclick='listUsers($next_page)'>$next_page</a></li>";
            }
        }
        $txtTable .= "<li class='page-item'><a class='page-link' href='#' onclick='listUsers($number_pages)'>Last Page</a></li>";
        $txtTable .= '</ul></nav>';

        echo $txtTable;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Erro, nenhum usuário Encontrado!</div>";
    }
}
if ($action === 'registerUser') {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (empty($dados['name'])) {
        $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Name field is required!</div>"];
    } elseif (empty($dados['email'])) {
        $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Email field is required!</div>"];
    } else {

        $created_at = date('Y-m-d H:i:s');
        $sql = "INSERT INTO users (name, email,created_at) VALUES (:name, :email, :created_at)";
        $qry = $conn->prepare($sql);
        $qry->bindParam(':name', $dados['name']);
        $qry->bindParam(':email', $dados['email']);
        $qry->bindParam(':created_at', $created_at);
        $qry->execute();

        if ($qry->rowCount()) {
            $return = ['error' => false, 'msg' => "<div class='alert alert-success' role='alert'>Successfully registered user!</div>"];
        } else {
            $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>User not successfully registered!</div>"];
        }
    }
    echo json_encode($return);
}
if ($action === "viewUser") {

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    if (!empty($id)) {

        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $qry = $conn->prepare($sql);
        $qry->bindParam(':id', $id);
        $qry->execute();

        $row = $qry->fetch(PDO::FETCH_ASSOC);

        $return = ['error' => false,  'dados' => $row];
    } else {

        $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>No Users Found!</div>"];
    }

    echo json_encode($return);
}
if ($action === 'delUser') {

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    if (!empty($id)) {
        $deleted_at = date('Y-m-d H:i:s');
        $sql = "UPDATE users SET deleted_at=:deleted_at WHERE id = :id";
        $qry = $conn->prepare($sql);
        $qry->bindParam(':deleted_at', $deleted_at);
        $qry->bindParam(':id', $id);
        if ($qry->execute()) {
            $return = ['error' => false, 'msg' => "<div class='alert alert-success' role='alert'>User deleted successfully!</div>"];
        } else {
            $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>User not deleted successfully!</div>"];
        }
    } else {
        $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Error, contact administrator!</div>"];
    }

    echo json_encode($return);
}
if ($action === 'editUser') {
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    if (!empty($id)) {

        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $qry = $conn->prepare($sql);
        $qry->bindParam(':id', $id);
        $qry->execute();

        $row = $qry->fetch(PDO::FETCH_ASSOC);

        $return = ['error' => false,  'dados' => $row];
    } else {

        $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>No Users Found!</div>"];
    }

    echo json_encode($return);
}
if ($action === 'savingEditUser') {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (empty($dados['id'])) {
        $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Error, Contact Administrator!</div>"];
    } elseif (empty($dados['name'])) {
        $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Name field is required!</div>"];
    } elseif (empty($dados['email'])) {
        $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Email field is required!</div>"];
    } else {

        $sql = "UPDATE users SET name=:name, email=:email WHERE id = :id";
        $qry = $conn->prepare($sql);
        $qry->bindParam(':name', $dados['name']);
        $qry->bindParam(':email', $dados['email']);
        $qry->bindParam(':id', $dados['id']);

        if ($qry->execute()) {
            $return = ['error' => false, 'msg' => "<div class='alert alert-success' role='alert'>Successfully edited user!</div>"];
        } else {
            $return = ['error' => true, 'msg' => "<div class='alert alert-danger' role='alert'>User not successfully edited!</div>"];
        }
    }

    echo json_encode($return);
}
