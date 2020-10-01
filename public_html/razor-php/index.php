<?php
require_once('./config.php');
?>
<html>
<head>
    <style>
    .razorpay-payment-button {
        display: none;
    }
    </style>
</head>
<body>

<form name="razorform" action="charge.php" method="POST"> 
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>

<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key=<?php echo $api_key_id ?> 
    data-amount="200" 
    data-currency="INR"
    data-buttontext="Pay with Razorpay"
    data-name="swarna awards"
    data-image="https://swarnaawards.com/assets/img/swarna-logo-small.png"
    data-description="Test transaction"
    data-prefill.email=<?php echo $_GET['email'] ?>
    data-prefill.contact=<?php echo $_GET['mobile'] ?>
   >
</script>
<input type="hidden" custom="Hidden Element" name="hidden">
</form></body>
</html>
<script>
 $(window).on('load', function(){
	 jQuery('.razorpay-payment-button').click();
 });
</script>