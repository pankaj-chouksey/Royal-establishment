<?php

include "../../database/connection.php";

if(isset($_GET['id'])){

    $id = $_GET['id'];

    /* CURRENT STATUS */

    $query = mysqli_query($conn,

    "

    SELECT status FROM products
    WHERE id='$id'

    "

    );

    $product = mysqli_fetch_assoc($query);

    /* TOGGLE */

    if($product['status'] == 'active'){

        $new_status = 'inactive';

    } else {

        $new_status = 'active';

    }

    /* UPDATE */

    mysqli_query($conn,

    "

    UPDATE products

    SET status='$new_status'

    WHERE id='$id'

    "

    );

}

header("Location:view-products.php");

exit();

?>