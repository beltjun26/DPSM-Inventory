<?php

 ?>
<table class="table table-hover">
 <!-- <colgroup class="col-numbers"></colgroup> -->
 <thead>
   <tr>
     <th>NAME</th>
     <th>USERNAME</th>
     <th>TYPE</th>
   </tr>
 </thead>
 <tbody>
   <?php
     $num_rows = mysqli_num_rows($query);

     if($num_rows>0){
       while($row=$query->fetch_array()){
       ?>
         <tr>
           <td><?=$row['name']?></td>
           <td><?=$row['username']?></td>
           <td><?=$row['type']?></td>
           <td><button class="btn btn-danger pull-right" type="button" name="button">Remove</button></td>
         </tr>

       <?php
       }
     }
    ?>
 </tbody>
</table>
