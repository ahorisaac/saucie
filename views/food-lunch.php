<?php
session_start();

function __autoload($Class)
{
    require_once("../classes/$Class.php");
}


if (!$_SESSION['cus_name']) {
    header("location: users-login.php");
}


?>

<!DOCTYPE html>
<html>

<head>
    <title> Saucie </title>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../public/css/litera-bootstrap.css" type="text/css" rel="stylesheet">
    <link href="../public/css/staff-style.css" type="text/css" rel="stylesheet">
    <link href="../public/fontawesome/css/all.css" type="text/css" rel="stylesheet">
    <link href="../public/logo.png" rel="icon">
    <style>
        body {
            font-family: Arial;
            background-attachment: fixed;
            background-size: cover;
            background: white;
        }

        #food_img {
            width: 270px;
            height: 160px;
            border-radius: 8px;

        }

        #food_frame {
            font-family: "monospace";
            border: 1px solid dimgray;
            border-radius: 10px;
            background: linear-gradient(90deg,
                    rgba(128, 128, 128, 0.4)25%,
                    rgba(128, 128, 128, 0.4)50%,
                    rgba(128, 128, 128, 0.4)70%,
                    rgba(128, 128, 128, 0.4)100%);
            font-family: "monospace";
        }

        #food_profile_image {
            border-radius: 25px;
            width: 520px;
            height: 300px;
        }

        #lunch_frame {
            margin-left: 4px;
            margin-right: 4px;
            padding-bottom: 4px;
            padding-top: 8px;
            border: 2px solid antiquewhite;
            border-radius: 10px;
            font-family: Arial;
        }

        #lunch_frame p,
        #lunch_frame label {
            color: black;
        }

        #lunch_frame input[type="number"] {
            width: 80px;
            color: black;
            font-weight: bold;
        }

        @media screen and (max-device-width: 480px) {
            #lunch_frame {
                width: 100%;
            }
        }

        #pimg {
            width: 50px;
            height: 50px;
            border-radius: 25px;
        }

        a[class="dropdown-item"]:hover {
            background: green;
            color: white;
        }

        button[type="submit"],
        .form-group a {
            border-radius: 25px;
        }
    </style>
</head>

<body>
    <div class="container">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a href="#" class="navbar-brand">
                <h3> <i class="fa fa-cookie-bite fa-2x"></i> Saucie </h3>
            </a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
                <span class="navbar-toggler-icon"> </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mt-4 mr-2 font-weight-bold text-center">
                        <a href="customers-homepage.php">
                            <i class="fa fa-home fa-1x"></i> Customer's Homepage
                        </a>
                    </li>
                    <li class="nav-item active text-center">
                        <a href="#" class="nav-link">
                            <img src="../public/storage/customer_profileimage/<?php echo $_SESSION["cus_profileimage"]; ?>" alt="" id="pimg" class="text-center" />
                            <span class="sr-only">(current)</span>
                            <br />
                            <h6 class="text-center font-weight-bold"> <?php echo $_SESSION["cus_name"]; ?> </h6>
                        </a>
                    </li>
                    <li class="nav-item dropdown font-weight-bold text-center">
                        <a class="nav-link dropdown-toggle" href="#" id="foodCategory" data-toggle="dropdown">
                            <i class="fa fa-shopping-cart fa-2x"></i>
                            <span class="badge badge-success" style="font-size: 15px">
                                <?php $cartRow = new Food();
                                $cartNum = $cartRow->rowCountLunchCart($_SESSION["cus_id"]); ?>
                                <?php if (isset($cartNum)) {
                                    echo $cartNum;
                                } else {
                                    echo 0;
                                } ?>
                            </span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="foodCategory" id="category">
                            <a class="dropdown-item" href="food-lunch-view.php">
                                View Items / Checkout
                            </a>
                            <a class="dropdown-item" href="#"> <i class="fa fa-cart-plus fa-1x"></i> Add more items </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="text-center">
            <?php
            if (isset($_SESSION["delete_all_lunch_success"])) {
                echo $_SESSION["delete_all_lunch_success"];
                unset($_SESSION["delete_all_lunch_success"]);
            }

            if (isset($_SESSION["empty_lunch_cart"])) {
                echo $_SESSION["empty_lunch_cart"];
                unset($_SESSION["empty_lunch_cart"]);
            }

            if (isset($_SESSION["lunch_added_to_cart"])) {
                echo $_SESSION["lunch_added_to_cart"];
                unset($_SESSION["lunch_added_to_cart"]);
            }

            if (isset($_SESSION["lunch_already_in_cart"])) {
                echo $_SESSION["lunch_already_in_cart"];
                unset($_SESSION["lunch_already_in_cart"]);
            }
            ?>
        </div>


        <!-- ALL ABOUT LUNCH FRAME -->

        <div class="mb-4">
            <h3 class="text-center" style="font-family: arial;"> Lunch Homepage </h3>
            <div class="row justify-content-around">
                <?php
                $lunch = new Food();
                $lunchmeals = $lunch->selectAllLunchMeals(); ?>

                <?php foreach ($lunchmeals as $lunch) {  ?>

                    <div class="col-md-3 col-lg-3 col-sm-5 text-center ml-2 mr-2 mt-3 mb-3 shadow bg-white" style="min-width: 300px;" id="lunch_frame">
                        <img class="card-img-top" src="../public/storage/uploaded_food/<?php echo $lunch["image"]; ?>" alt="" id="food_img" />
                        <div class="text-center" style="font-family: monospace;">
                            <h4 class="" style="font-family: monospace" ;>
                                <span style="font-family: monospace; font-weight: bold"> </span> <?php echo $lunch["name"]; ?>
                            </h4>
                            <p class="" style="font-size: 18px;"> <span style="font-family: monospace; font-weight: bold"> Price Tag </span> :
                                <span> &#8358; </span> <?php echo $lunch["price_tag"]; ?>
                            </p>
                            <form class="form text-center" method="POST" action="add-to-lunch-cart.php">
                                <input type="hidden" name="food_id" value="<?php echo $lunch["id"]; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION["cus_id"]; ?>">
                                <div class="form-group row justify-content-around">
                                    <label for="quantity" style="font-size: 18px;" class="col-form label col-sm-3">
                                        <span style="font-family: monospace; font-weight: bold"> Quantity </span>
                                    </label>
                                    <input type="number" class="form-control" required name="quantity" value="1" required />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-info btn-md" name="addToCart">
                                        <i class="fa fa-cart-plus fa-1x"></i> Add to Cart
                                    </button>
                                    <a href="food-view-single-food-data.php?id=<?php echo $lunch["id"]; ?>" class="btn btn-outline-success btn-md">
                                        <i class="fa fa-book fa-1x"></i> Details
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php  } ?>
            </div>
        </div>

        <footer class="text-center mb-3 mt-3">
            <h3 class="text-center" style="font-family: arial;">
                <i class="fa fa-cookie-bite fa-1x"></i> Saucie Enterprise
            </h3>
        </footer>
    </div>



    <script src="../public/scripts/jquery-3.3.1.js"></script>
    <script src="../public/js/bootstrap.bundle.min.js"></script>
    <script src="../public/fontawesome/js/all.js"> </script>

    <script src="../public/js/staff-main.js"> </script>
</body>

</html>