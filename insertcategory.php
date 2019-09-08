<?php
require "database.php";

$sql = "SELECT categories, status FROM categories where status=0";
//$sql = "SELECT url as categories, status FROM producturls where status=0";
$result = $conn->query($sql);

?>

<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
    </head>
    <body>
        <div class="container">
            <div class="jumbotron">
            <section class="mb-4">
            <!--Section heading-->
            <h2>Category URL</h2>
            <div class="row">
                <!--Grid column-->
                <div class="col-md-9 mb-md-0 mb-5">
                    <form id="contact-form" name="contact-form" action="cat.php" method="POST">
                        <!--Grid row-->
                        <div class="row">
                            <!--Grid column-->
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="name" class="">URL</label>
                                    <input type="text" required id="url" name="url" class="form-control">
                                </div>
                            </div>
                            <!--Grid column-->
                        </div>
                        <!--Grid row-->
                    </form>

                    <div class="text-center text-md-left">
                        <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Send</a>
                    </div>
                    <div class="status"></div>
                </div>
                <!--Grid column-->
            </div>
        </section>
            </div>
        </div>
        <!--Section: Contact v.2-->


        <!--Section: Contact v.2-->
        <h2>categories List</h2>
        <table class="table">
            <?php
        if ($result->num_rows > 0) :
            $i=0;
            while($row = $result->fetch_assoc()) {
                $i++;

                $color="red";
                if((int)$row["status"] == 1){
                    $color="green";
                }
        ?>

        <tr style="background: <?php echo $color;?>" >
            <td><?php  echo $i;?></td>
            <td><?php  echo $row["categories"];?></td>
            <td><?php  echo $row["status"];?></td>
        </tr>

        <?php } else:?>
            <tr style="background: #ddd;"><td><?php echo "0 results";?></td></tr>
        <?php endif;?>
        </table>


        <?php 
        $sql = "SELECT url as categories, status FROM producturls where status=0";
        $result = $conn->query($sql);
        ?>
        <h2>Product List</h2>
        <table class="table">
            <?php
        if ($result->num_rows > 0) :
            $i=0;
            while($row = $result->fetch_assoc()) {
                $i++;

                $color="red";
                if((int)$row["status"] == 1){
                    $color="green";
                }
        ?>

        <tr style="background: <?php echo $color;?>" >
            <td><?php  echo $i;?></td>
            <td><?php  echo $row["categories"];?></td>
            <td><?php  echo $row["status"];?></td>
        </tr>

        <?php } else:?>
            <tr style="background: #ddd;"><td><?php echo "0 results";?></td></tr>
        <?php endif;?>
        </table>
    </body>
</html>








