<?php
$InsertRecords = false;
$UpdateRecords = false;
$deleteRecords = false;

$server = "localhost";
$username = "root";
$password = "";
$database = "todoapp";

$connection = mysqli_connect($server, $username, $password, $database);
if (!$connection) {
    die("Failed to connect! " . mysqli_connect_error());
}

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "Delete from info where Id = $sno";
    $result = mysqli_query($connection, $sql);
    $delete = true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['del'])) {
        $sql = "Delete from info";
        $result = mysqli_query($connection, $sql);
        $delete = true;
    } else {
        if (isset($_POST['editid'])) {
            $id = $_POST['editid'];
            $title = $_POST['TitleEdit'];
            $description = $_POST['DescriptionEdit'];
            $date = $_POST['DateEdit'];

            $updatequery = "update info set Title='$title', description ='$description', date = '$date' where info.id='$id'";
            $result = mysqli_query($connection, $updatequery);
            if ($result) {
                $update = true;
            } else {
                echo "not updated";
            }
        } else {
            if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['date'])) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error!</strong> All fields are required.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            } else {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $date = $_POST['date'];

                if (!ctype_alpha(str_replace(' ', '', $title))) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> Title should only contain Alphabetic Characters.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                } else {
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $date = $_POST['date'];
                    $sql = "Insert into info(title, description, date) values ('$title', '$description', '$date')";
                    $Result = mysqli_query($connection, $sql);

                    if ($Result) {
                        $insert = true;
                    } else {
                        echo "Data not Inserted!";
                    }
                }
            }
        }
        if (isset($_POST['delAllTasks'])) {
            $sql = "DELETE FROM info";
            $result = mysqli_query($connection, $sql);
            if ($result) {
                $deleteRecords = true;
            } else {
                echo "Unable to delete all tasks.";
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODO APP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<body>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">UPDATES</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="TO DO APP.php" method="POST">
                        <input type="hidden" name="editid" id="editid">
                        <div class="mb-3">
                            <label for="TitleEdit" class="form-label">Title</label>
                            <input type="text" class="form-control" id="TitleEditt" name="TitleEdit" aria-describedby="emailHelp">
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" name="DescriptionEdit" id="DescriptionEdit"></textarea>
                            <label for="DescriptionEdit">Description</label>
                        </div>
                        <div class="mb-3 form-floating" style="margin-top: 20px;">
                    <input type="date" class="form-control" id="DateEdit" name="DateEdit">
                    <label for="DateEdit" class="form-label">Date</label>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Updated Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">TODO APP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            </div>
        </div>
    </nav>

    <?php
    if ($InsertRecords) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your task has been successfully added.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
   </div>";
    }
    ?>

    <?php
    if ($UpdateRecords) {
        echo "<div class='alert alert-primary alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your task has been successfully updated.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
   </div>";
    }
    ?>

    <?php
    if ($deleteRecords) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your task has been successfully deleted.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
   </div>";
    }
    ?>

<div class="container" style="background-color: transparent;">
        <div class="container" style="margin-top: 20px;">
            <h1 style="color: #CACACA; text-align: center;">TODO APP</h1>
            <form action="TO DO APP.php" method="POST">
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    <label for="title" class="form-label">Title</label>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" name="description" id="description"></textarea>
                    <label for="description">Description</label>
                </div>
                <div class="mb-3 form-floating" style="margin-top: 20px;">
                    <input type="date" class="form-control" id="date" name="date">
                    <label for="date" class="form-label">Date</label>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button style="margin-top: 10px;" type="submit" class="btn btn-success">SUBMIT</button>
                </div>
            </form>
        </div>
 
    <form id="deleteAllForm" method="post" action="TO DO APP.php">
        <div class="d-grid gap-2 col-6 mx-auto" style="margin-top: 20px; margin-bottom: 30px;">
            <button type="submit" class="btn btn-danger" name="delAllTasks">DELETE ALL TASKS</button>
        </div>
    </form>
</div>
    </div>

    <div class="container mt-4 table-success" style="background-color: #CACACA;">
        <h1>Data List</h1>
        <table id="myTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date</th> 
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $selectQuery = "SELECT * FROM info";
                $selectResult = mysqli_query($connection, $selectQuery);
                $count = 1;
                while ($row = mysqli_fetch_assoc($selectResult)) {
                    echo "<tr>
                    <td>" . $count++ . "</td>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . $row['Date'] . "</td>
                    <td>
                    <button type='button' class='btn btn-primary edit' id=" . $row['id'] . ">Edit</button>
                    <button type='button' class='btn btn-danger delete' id=d" . $row['id'] . ">Delete</button>
                    </td>
                </tr>";
                }
                ?>
            </tbody>
</table>
    </div>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
    const editButtons = document.getElementsByClassName('edit');
    Array.from(editButtons).forEach((button) => {
        button.addEventListener("click", (e) => {
            const tr = e.target.parentNode.parentNode;
            const title = tr.getElementsByTagName("td")[1].innerText;
            const description = tr.getElementsByTagName("td")[2].innerText;
            const date = tr.getElementsByTagName("td")[3].innerText;
            document.getElementById('TitleEditt').value = title;
            document.getElementById('DescriptionEdit').value = description;
            document.getElementById('DateEdit').value = date;
            document.getElementById('editid').value = e.target.id;
            $('#editModal').modal('toggle');
        });
    });

    const deleteButtons = document.getElementsByClassName('delete');
    Array.from(deleteButtons).forEach((button) => {
        button.addEventListener("click", (e) => {
            const SNo = e.target.id.substr(1);
            if (confirm("Are you sure you want to delete this task?")) {
                window.location = `/PHP/TO DO APP.php?delete=${SNo}`;
            }
        });
    });
    
    document.getElementById('deleteAllForm').addEventListener('submit', function(event) {
        if (!confirm('Are you sure you want to delete all tasks?')) {
            event.preventDefault();
        }
    });

</script>


</body>
</html>