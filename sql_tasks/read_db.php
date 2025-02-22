<?php
$host = 'db'; 
$username = 'root';
$pw = 'password'; 
$database = 'crud';

$conn = mysqli_connect($host, $username, $pw, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM student";
$result = mysqli_query($conn, $sql);
?>
    <table cellpadding="7px">
        <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Address</th>
            <th>Class</th>
            <th>Phone</th>
        </thead>
        <tbody>

        <?php if(mysqli_num_rows($result) > 0){
            
                while($row=mysqli_fetch_assoc($result)){?>
                    <tr>    
                        <td><?php echo $row['sid']; ?></td>
                        <td><?php echo $row['sname'];?></td>
                        <td><?php echo $row['saddress'];?></td>
                        <td><?php echo $row['sclass'];?></td>
                        <td><?php echo $row['sphone'];?></td>
                    </tr>
        <?php   } 
        }?>
        </tbody>
    </table>
</div>