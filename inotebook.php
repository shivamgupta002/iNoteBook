<!-- ------------------ Connection to the database ---------------------------------------- -->
<?php
$insert = false;
$update = false;
$delete = false;

$serverName = "localhost";
$username = "root";
$password = "";
$database = "notes";
$conn = mysqli_connect("$serverName", "$username", "$password", "$database");
if (!$conn) {
    die("Failed to connect to the server due to this reason --> " . mysqli_connect_error());
}
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //  -------------------------------  update the record -----------------------------
    if (isset($_POST['srNoEdit'])) {
        $sno = $_POST['srNoEdit'];
        $title = $_POST['titleEdit'];
        $des = $_POST['desEdit'];

        $sql = "UPDATE `notes` SET `title` ='$title',`des` = '$des' WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "We cant't update your data";
        }
    } else {
        $title = $_POST['title'];
        $des = $_POST['des'];
        $sql = "INSERT INTO `notes` (`title`, `des`) VALUES ('$title', '$des')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $insert = true;
        } else {
            echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
        }
    }
}
?>

<!-- ----------------------------------  HTML ---------------------------------------------------------- -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Required meta tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Datatable jquery-->
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <!-- Datatable -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>iNotebook</title>
</head>

<body>
    <!-- ----------------------------- Edit Modal --------------------------------------------------------- -->

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="inotebook.php" method="post">
                        <input type="hidden" name="srNoEdit" id="srNoEdit">
                        <div class=" form-group mb-3">
                            <label for="exampleInputEmail1" class="form-label">Edit Note</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3 form-group ">
                            <label for="des" class="form-label">New Description</label>
                            <textarea class="form-control" placeholder="Leave a comment here" id="desEdit" name="desEdit" row="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary my-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------- Navbar ------------------------------------------------------------ -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">iNotebook</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- --------------------------------  alert   ----------------------------------------------- -->
    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inserted successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
    </button>
  </div>";
    }
    ?>
    <?php
    if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    
    </button>
  </div>";
    }
    ?>
    <?php
    if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
    ?>

    <!-- -------------------------------- Text-Area(Note) -------------------------------- -->
    <div class="container">
        <h2>Add Your Note</h2>
        <form action="inotebook.php" method="post">
            <div class="form-group mb-3 my-2">
                <label for="exampleInputEmail1" class="form-label">New Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Write your note title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 form-group ">
                <label for="des" class="form-label"> Description</label>
                <textarea class="form-control" placeholder="Leave a Note here" id="des" name="des" row="6"></textarea>
            </div>
            <button type="submit" class="btn btn-primary my-3">Submit</button>
        </form>
    </div>
    <!-- ------------------------------------- Table ------------------------------------------------------ -->
    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.no.</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `notes`";
                $result = mysqli_query($conn, $sql);
                $sno = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo  "<tr>
            <th scope=``row`>" . $sno . "</th>
            <td> " . $row['title'] . "</td>
            <td>" . $row['des'] . "</td>
            <td>
           <button class='btn btn-sm btn-primary edit mx-1' id=" . $row['sno'] . ">Edit</button>
           <button class='btn btn-sm btn-danger delete' id=d" . $row['sno'] . ">Delete</button>
           </td>
           </tr>";
                }

                ?>
            </tbody>
        </table>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        // ------------------------For Edit ----------------------------
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                des = tr.getElementsByTagName("td")[1].innerText;
                // console.log(title, des);
                desEdit.value = des;
                titleEdit.value = title;
                srNoEdit.value = e.target.id;
                $('#editModal').modal('toggle');
            })
        })
        // ------------------------For delete ----------------------------
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                sno = e.target.id.substr(1);
                if (confirm("Press a button")) {
                    console.log("yes");
                    window.location = `/myproject/inotebook.php?delete=${sno}`;
                } else {
                    console.log("no");
                }
            })
        })
    </script>

</body>

</html>