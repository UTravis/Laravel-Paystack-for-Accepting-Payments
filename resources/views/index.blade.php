<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Flutterwave Payments</title>
</head>
<body>
    <div class="container">
        <div class="card text-center bg-secondary mb-5">Pay Now</div>
            <div class="row">
                <div class="col-md-4">
                    <form  id="paymentForm">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount">
                        </div>
                        <div class="form-group">
                            <input type="number" name="phone_number" id="phone_number" class="form-control" placeholder="Enter Phone Number">
                        </div>
                        <input type="submit" value="Pay" class="btn btn-primary">
                    </form>
                </div>
            </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
        const paymentForm = document.getElementById('paymentForm');
        paymentForm.addEventListener('submit', function(e){
            e.preventDefault();

            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var amount = document.getElementById('amount').value;
            var phone_number = document.getElementById('phone_number').value;

            makePayment(name, email, amount, phone_number);
        })

        function makePayment(name, email, amount, phone_number) {
            FlutterwaveCheckout({
            public_key: "FLWPUBK_TEST-4df11aef1d3e74c2bfbaec48a1c462de-X",
            tx_ref: "RX1",
            amount,
            currency: "NGN",
            country: "NG",
            payment_options: " ",
            customer: {
                email,
                phone_number,
                name,
            },
            callback: function (data) {
                //making an AJAX request
                var tx_id = data.transaction_id;
                var _token =  $("input[name='_token']").val();
                $.ajax({
                    type: "POST",
                    url: "{{URL::to('verify-payment')}}",
                    data: {
                        tx_id,
                        _token
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                    }
                });
            },
            onclose: function() {
                // close modal
            },
            customizations: {
                title: "My store",
                description: "Payment for items in cart",
                logo: "https://assets.piedpiper.com/logo.png",
            },
            });
        }
</script>
</html>