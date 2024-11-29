<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice Template</title>
    <meta name="author" content="user" />
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Calibri, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #393939;
            padding: 20px;
        }

        h1 {
            font-size: 40pt;
            color: #3A5775;
            text-align: left;
        }

        h2 {
            font-size: 12pt;
            color: #3A5775;
            font-weight: bold;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: left;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11pt;
        }

        .details {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin: 20px 0;
        }

        .details .client,
        .details .invoice-info {
            font-size: 12pt;
        }

        .details .client p,
        .details .invoice-info p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 12pt;
        }

        .table th {
            background-color: #3A5775;
            color: white;
        }

        .table td:nth-child(odd) {
            background-color: #EEF3F7;
        }

        .footer {
            margin-top: 30px;
            text-align: left;
        }

        .footer p {
            font-size: 12pt;
        }

        .total {
            font-weight: bold;
            color: #3A5775;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h1>INVOICE</h1>
            <h2>Your Company Name</h2>
            <p>1234 Main Street, City, State ZIP</p>
            <p>Phone: (555) 555-5555 | Email: contact@yourcompany.com</p>
        </div>

        <!-- Client & Invoice Details Section -->
        <div class="details">
            <!-- Client Details -->
            <div class="client">
                <p><strong>Client Name:</strong> John Doe</p>
                <p><strong>Address:</strong> 5678 Elm Street, Another City, State ZIP</p>
            </div>

            <!-- Invoice Details -->
            <div class="invoice-info">
                <p><strong>Invoice Date:</strong> November 29, 2024</p>
                <p><strong>Invoice Number:</strong> INV-12345</p>
            </div>
        </div>

        <!-- Table Section -->
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <img src="path/to/image.jpg" alt="Product A Image"
                                style="width: 50px; height: 50px; margin-right: 10px;" />
                            <span>Product A</span>
                        </div>
                    </td>
                    <td>2</td>
                    <td>$50.00</td>
                    <td>$100.00</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Product B</td>
                    <td>3</td>
                    <td>$30.00</td>
                    <td>$90.00</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Service C</td>
                    <td>1</td>
                    <td>$120.00</td>
                    <td>$120.00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="total">Subtotal</td>
                    <td>$310.00</td>
                </tr>
                <tr>
                    <td colspan="4" class="total">Tax (10%)</td>
                    <td>$31.00</td>
                </tr>
                <tr>
                    <td colspan="4" class="total">Total</td>
                    <td>$341.00</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer Section -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>Please make payment by the due date specified above.</p>
        </div>
    </div>
</body>

</html>
