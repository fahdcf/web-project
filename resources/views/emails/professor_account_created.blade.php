<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre compte a été créé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            background-color: #4723d9;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            line-height: 1.6;
            margin: 10px 0;
        }
        .content ul {
            list-style: none;
            padding: 0;
        }
        .content ul li {
            margin: 10px 0;
            font-size: 16px;
        }
        .content ul li strong {
            color: #4723d9;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4723d9;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
        .button:hover {
            background-color: #3a1ca6;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 10px;
                padding: 10px;
            }
            .header h1 {
                font-size: 20px;
            }
            .button {
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bonjour {{ $firstname }} {{ $lastname }}</h1>
        </div>
        <div class="content">
            <p>Votre compte a été créé avec succès sur la plateforme AssignPro !</p>
            <p>Voici vos informations de connexion :</p>
            <ul>
                <li><strong>Email :</strong> {{ $email }}</li>
                <li><strong>Mot de passe :</strong> {{ $password }}</li>
            </ul>
            <p>Veuillez vous connecter et modifier votre mot de passe dès que possible pour des raisons de sécurité.</p>
            <a href="https://assignpro.example.com" class="button">Se connecter à AssignPro</a>
        </div>
        <div class="footer">
            <p>Cordialement,<br>L'équipe AssignPro</p>
        </div>
    </div>
</body>
</html>