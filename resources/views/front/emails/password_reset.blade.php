<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pick N Drop - Password Reset OTP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Basic Reset and Body Styles */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Main container for the email content */
        .email-container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            max-width: 580px;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            box-sizing: border-box;
        }

        /* Header section with logo and brand name */
       

        /* Logo Image */
        .logo-image {
            max-width: 200px;
            height: auto;
        }

        /* Content section typography */
        .content p {
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 16px;
        }

        .content p:last-child {
            margin-bottom: 0;
        }

        /* OTP specific styling */
        .otp-text {
            font-size: 16px;
            font-weight: 500;
            margin: 24px 0 !important;
        }

        .otp-text strong {
            font-weight: 700;
            color: #000;
            font-size: 17px;
        }
        
        /* Footer section styling */
        .footer {
            margin-top: 32px;
        }

        .footer p {
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
        }

        .footer strong {
            font-weight: 600;
        }

    </style>
</head>
<body>

    <div class="email-container">
        <!-- Header -->
        <!-- Header -->
        <header class="header">
             <table>
                <tr>
                    <td>
                       
                    </td>
                    <td>
                        <center>
                            <img src="https://admin.pickndrop.org/public/uploads/black_logo175674796820250901picb.png" alt="Pick N Drop Logo" class="logo-image">
                        </center>
                    </td>
                    <td>
                       
                    </td>
                </tr>
            </table>
        </header>

        <!-- Main Content -->
        <main class="content">
            <p style="font-weight: 900;color:#0f1531 !important;">Hello <strong style="color:#0f1531 !important;">{{ $name }}</strong>,</p>
            <p>We Have Received A Request To Reset Your  <strong style="color:#0f1531 !important;">Pick N Drop!</strong> Account Password. <br>
            Please use the One-Time Password (OTP) below to proceed.</p>
            <p class="otp-text" style="font-weight: 900;color:#0f1531 !important;">Your OTP: <strong style="color:#0f1531 !important;">{{ $otp }}</strong></p>
            <p style="color:#0f1531 !important;">This OTP is valid for the next 5 minutes.</p>
            <p>Please do not share this code with anyone for your security. If you didn't request this, you can safely ignore this email.</p>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>Best regards,</p>
            <p><strong style="color:#0f1531 !important;">The Pick N Drop Team</strong></p>
        </footer>
    </div>

</body>
</html>


