<?php
    require("database.php");
    $db = new database();
    $mysqli = new mysqli();
    session_start();
    if(!isset($_SESSION['email'])) //check if session is closed
    {
        header('location:index.php');
    }
    else{
        $mysqli = $db->connect();
        if($mysqli->connect_errno)   //check connection
        {
            echo "Failed to connect to Database:".$mysqli->connect_error;
        }
        else 
        {
    
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Home Page</title>
    </head>
    <body>
        <!---------Header-------->
        <div class="home-page">
        <div class="formhome">
        <h1><b>Welcome <?php echo $_SESSION['name']." (".$_SESSION['id'].")"?></b></h1><br><br>
        <h5><li><b>Email: </b><?php echo $_SESSION['email']?></li></h5><br>
        <a class="btn btn-danger" href="logout.php">Logout</a><br><br><br>

        <!---------Search and Add button-------->
        <div class="headsh">
            <form action="" method="GET">   
                <div class="search">
                <input type="text" name="search" class="form-control" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Search...">
                <input type="submit" value="search" class="btn btn-secondary">
                </div>
            </form> 
            <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">Add User</button>
        </div>
        <!------Table------->
        <table id="table" class="table">
            <thead class="thead-dark">
            <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th></th>
            <th></th>
            </tr>
            </thead>
            <tbody>
        <!---------fill the table-------->
        <?php
            if(isset($_GET['search']))
            {
                $search = $_GET['search'];
                $result = $db->search($mysqli,$search);
            }
            else{
                $result = $db->read($mysqli);
            }
            while($row = mysqli_fetch_assoc($result))
            {
                echo '
                <tr>
                <td>'.$row['ID'].'</td>
                <td>'.$row['Name'].'</td>
                <td>'.$row['Email'].'</td>
                <td>'.$row['Password'].'</td>   
                <td><button class="btn btn-outline-success" data-toggle="modal" data-target="#updateModal">Edit</button></td>
                <td><a href="delete.php?id='.$row['ID'].'" class="btn btn-outline-danger">Delete</a></td>
                </tr>';
                $last=$row['ID']+1; //last id to show in create modal
            }
            echo '
            </tbody>

            <tfoo>
            <td colspan="5"></td>
            </tfoot>
            </table>';
        ?>
        </div>

        <!--------------------------------- Modal Update Form-------------------------------------->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <form class="form-horizontal" action="update.php" method="POST">
                        <div class="form-group">
                            <b>ID: </b>
                            <input id="id" class="form-control" type="number" name="id" disabled></br></br>
                        </div>
                        <div class="form-group">
                            <b>Name: </b>
                            <input id="name" class="form-control" type="text" placeholder="Enter new name" name="name" required></br></br>
                        </div>
                        <div class="form-group">
                            <b>Email: </b>
                            <input id="email" class="form-control" type="email" placeholder="Enter new email" name="email" required></br></br>
                        </div>
                        <div class="form-group">
                            <b>Password:</b>
                            <input id="password" class="form-control" type="password" placeholder="Enter new password" name="password" required></br></br>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!------------------------------ Modal Create Form------------------------------------->
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" action="create.php" method="POST">
                    <div class="form-group">
                        <b>ID: </b>
                        <input id="id" class="form-control" type="number" value="<?php echo $last ?>" name="id" disabled></br></br>
                    </div>
                    <div class="form-group">
                        <b>Name: </b>
                        <input class="form-control" type="text" placeholder="Enter your name" name="name" required></br></br>
                    </div>
                    <div class="form-group">
                        <b>Email: </b>
                        <input class="form-control" type="email" placeholder="Enter your email" name="email" required></br></br>
                    </div>
                    <div class="form-group">
                        <b>Password:</b>
                        <input class="form-control" type="password" placeholder="Enter your password" name="password" required></br></br>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-success">Add</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
                </div>       
            </div>
        </div>
    </div>
    <!----------------Bootstrap Scripts--------------->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
    
    
    <script>

    //--------- Enable ID button to send it in query--------//
    $('form').submit(function(e) {
        $(':disabled').each(function(e) {
        $(this).removeAttr('disabled');
        })
    });

    //---------Read table and send to modal----------//
        $(document).ready(function(){
            $('.btn-outline-success').on('click',function(){
        
                $('#updateModal').modal('show');
                $tr = $(this).closest('tr');
            
                var data = $tr.children("td").map(function(){
                return $(this).text();
                }).get();
            
                $('#id').val(data[0]);
                $('#name').val(data[1]);
                $('#email').val(data[2]);
                $('#password').val(data[3]);
            });
        });
</script>
    </body>
    </html>
<?php
}
$mysqli->close(); //close database
}
?>