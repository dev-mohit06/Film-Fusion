<!DOCTYPE html>
<html>

<head>
    <title>Password Reset Request</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            margin: 20px auto;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }

        td {
            padding: 20px;
        }

        h1 {
            color: #007bff;
        }

        ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        p {
            color: #333;
            font-size: 16px;
            line-height: 1.5;
        }

        strong {
            font-weight: bold;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            color: #888;
        }
    </style>

</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">

    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="background-color: #007bff; padding: 20px;">
                <h1 style="color: white;">Welcome user,</h1>
            </td>
        </tr>
    <tr>
            <td style="padding: 20px;">
                <p>Hello User,</p>
                <p>We noticed that your friend tried to invite you into the world of films. Please create an account and join us.</p>
                <p>Website Link : <strong><a href="{{ route('login',['refCode'=>$mailData['code']]) }}">Click here</a></strong></p>
                <p style="margin-top: 30px;">Best regards,<br />Film Fusion</p>
            </td>
        </tr>
        <tr>
            <td align="center" style="background-color: #f4f4f4; padding: 10px;">
                <p style="color: #888;">If you have any questions, please contact our support team at <br> <a
                        href="mailto:support-filmfusion@smartmohit.com">support-filmfusion@smartmohit.com</a>.</p>
            </td>
        </tr>
    </table>

</body>

</html>