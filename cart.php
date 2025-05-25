<?php
include "php/read.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kyibo Cart</title>
<script src="https://kit.fontawesome.com/92d70a2fd8.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="style/cart.css">
<link rel="stylesheet" type="text/css" href="style/check.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-KsHPE2TvZtCqVb7dRss0Bo99tDplwo4uCYh1l6a0mtVFFo3yvuKK5KLson50SddQ" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
function showCheckoutForm() {
    document.getElementById('checkoutForm').style.display = 'block';
    document.getElementById('checkoutForm').scrollIntoView({ behavior: 'smooth' });
}
</script>
</head>
<body>
<header>
<img class="logo" href="index1.html" src="assets/logo.png" alt="logo">
<nav>
<ul class="navlinks">
<li><a href="index.html">Home</a></li>
<li><a href="shop.html">Shop</a></li>
<li><a href="contact.html">Contacts</a></li>
</ul>
</nav>
<a class="cta" href="php/logout.php"><button>Logout</button></a>
<a class="cta" href="cart.php"><button>Cart</button></a>
</header>
<div class="container">
<div class="box">
<h4 class="display-4 text-center">Your Cart</h4><br>
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success" role="alert">
        <?php echo htmlspecialchars($_GET['success']); ?>
    </div>
<?php } ?>
<?php if ($result) { if (mysqli_num_rows($result) > 0) { $total_price = 0; $total_quantity = 0; while ($rows = mysqli_fetch_assoc($result)) { $total_price += $rows['price'];
        $total_quantity++;
    } ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php mysqli_data_seek($result, 0); $i = 0; while ($rows = mysqli_fetch_assoc($result)) { $i++; ?>
            <tr>
                <th scope="row"><?=$i?></th>
                <td><img src="<?=$rows['image_url']?>" alt="<?=$rows['product_name']?>" style="width: 100px; height: auto;"></td>
                <td><?=$rows['product_name']?></td>
                <td>$<?=$rows['price']?></td>
                <td>
                    <a href="php/delete.php?id=<?=$rows['id']?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="checkout-container">
        <div class="total-price">Total Price: $<?php echo $total_price; ?></div>
        <button class="btn btn-primary" onclick="showCheckoutForm()">Checkout</button>
    </div>
    <div id="checkoutForm" style="display:none;">
        <div class="checkoutLayout">
            <div class="right">
                <h1>Checkout</h1>
                <form action="php/checkout.php" method="POST">
                    <div class="form">
                        <div class="group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" required>
                        </div>
                        <div class="group">
                            <label for="phone">Phone Number</label>
                            <input type="text" name="phone" id="phone" required>
                        </div>
                        <div class="group">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" required>
                        </div>
                        <div class="group">
                            <label for="country">Province</label>
                            <select name="country" id="country" required>
                                <option value="">Choose..</option>
                                <option value="Camarines Sur">Camarines Sur</option>
                                <option value="Albay">Albay</option>
                            </select>
                        </div>
                        <div class="group">
                            <label for="city">City</label>
                            <select name="city" id="city" required>
                                <option value="">Choose..</option>
                                <option value="Iriga">Iriga</option>
                                <option value="Baao">Baao</option>
                                <option value="Bato">Bato</option>
                                <option value="Balatan">Balatan</option>
                                <option value="Naga">Naga</option>
                                <option value="Polangui">Polangui</option>
                                <option value="Ligao">Ligao</option>
                                <option value="Daraga">Daraga</option>
                                <option value="Tabaco">Tabaco</option>
                                <option value="Legazpi">Legazpi</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                    <input type="hidden" name="total_quantity" value="<?php echo $total_quantity; ?>">
                    <div class="return">
                        <div class="row">
                            <div>Total Quantity</div>
                            <div class="totalQuantity"><?php echo $total_quantity; ?></div>
                        </div>
                        <div class="row">
                            <div>Total Price</div>
                            <div class="totalPrice">$<?php echo $total_price; ?></div>
                        </div>
                    </div>
                    <button type="submit" class="buttonCheckout">CHECKOUT</button>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-info" role="alert">Your cart is empty.</div>
<?php } } else { ?>
    <div class="alert alert-danger" role="alert"> Error fetching cart details. Please try again later. </div>
<?php } ?>
</div>
</div>
</body>
</html>