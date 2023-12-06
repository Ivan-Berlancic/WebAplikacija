<?php

function component($productname, $productprice, $productimg, $productdesc, $productid){
    $element = "
    <div class='col-md-6 col-sm-12 my-3 my-md-0'>
        <form action='index.php' method='post'>
            <div class='card shadow mb-4'>
                <div>
                    <img src='$productimg' alt='Image1' class='img-fluid card-img-top w-75'>
                </div>
                <div class='card-body'>
                    <h5 class='card-title'>$productname</h5>
                    <p class='card-text'>
                        $productdesc
                    </p>
                    <h5>
                        <span class='price'>$productprice €</span>
                    </h5>
                    <button type='submit' class='btn btn-primary my-3' name='add'>Dodaj u košaricu<i class='bi bi-cart4'></i></button>
                    <input type='hidden' name='product_id' value='$productid'>
                    
                </div>
            </div>
        </form>
    </div>
    ";
    echo $element;
}


function cartElement($productimg, $productname, $productprice, $productdesc, $productid, $index){
    $element = "
    <form action=\"cart.php?action=remove&id=$productid\" method=\"post\" class=\"cart-items\">
        <div class=\"border rounded\">
            <div class=\"row bg-white\">
                <div class=\"col-md-3 pl-0\">
                    <img src=$productimg alt=\"Image1\" class=\"img-fluid\">
                </div>
                <div class=\"col-md-6\">
                    <h5 class=\"pt-2\">$productname</h5>
                    <h5 class=\"product-price pt-2\" data-index=\"$index\">$productprice €</h5>
                    <h5 class=\"pt-2\">$productdesc</h5>
                    <button type=\"submit\" class=\"btn btn-danger mx-2 mb-2\" name=\"remove\">Remove</button>
                </div>
                
            </div>
        </div>
        <br>
    </form>
    ";
    echo $element;
}



?>

