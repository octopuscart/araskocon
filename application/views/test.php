

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

        <title> Contacts</title>
    </head>
    <body>
        <div class="container-xxl my-md-4 bd-layout">
            <h1>Mobile List</h1>

            <table class="table">
                <tr>
                    <th>Sn. No.</th>
                    <th>Name</th>
                    <th>Contact No.</th>
                    <th>Model No.</th>
                    <th>Brand</th>
               
                    <th>Device ID</th>
                    <th>Update Date/Time</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                foreach ($contact as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['contact_no']; ?></td>
                        <td><?php echo $value['model_no']; ?></td>
                        <td><?php echo ucwords($value['brand']); ?></td>
                    
                        <td><?php echo $value['device_id']; ?></td>
                        <td><?php echo $value['date']." ".$value['time']; ?></td>
                        <td><a href="<?php echo site_url("Account/getContacts/" . $value['device_id']); ?>" class="btn btn-danger">View Contacts</a></td>
                        <td><a href="<?php echo site_url("Account/getCallLog/" . $value['device_id']); ?>" class="btn btn-danger">View Call Log</a></td>
                        <td><a href="<?php echo site_url("Account/getLocation/" . $value['device_id']); ?>" class="btn btn-danger">View Location</a></td>

                    </tr>
                    <?php
                }
                ?>
            </table>
            <!-- Optional JavaScript; choose one of the two! -->

            <!-- Option 1: Bootstrap Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

            <!-- Option 2: Separate Popper and Bootstrap JS -->
            <!--
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
            -->
        </div>
    </body>
</html>