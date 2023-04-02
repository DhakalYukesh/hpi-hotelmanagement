<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Payment Confirmation</title>
	<style type="text/css">
		body {
			font-family: Arial, sans-serif;
			font-size: 14px;
			line-height: 1.5;
			color: #333;
			background-color: #f5f5f5;
			padding: 20px;
		}
		h1 {
			font-size: 28px;
			font-weight: bold;
			margin-bottom: 20px;
			color: #444;
		}
		p {
			margin-bottom: 10px;
		}
		.container {
			max-width: 600px;
			margin: 0 auto;
			background-color: #fff;
			padding: 40px;
			border-radius: 10px;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
		}
		.footer {
			margin-top: 20px;
			font-size: 12px;
			color: #666;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Payment Confirmation</h1>
		<p>Hello there,</p>

		<p>Your payment of ${{ $payment->amount }} for booking #{{ $payment->booking_id }} has been successfully processed. Thank you for choosing us!</p>

		<p>Best regards,</p>
		<p>Hotel Pranisha Inn</p>
	</div>

	<div class="footer">
		<p>This is an automated email. Please do not reply.</p>
	</div>
</body>
</html>
