<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Yumna</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding-top:40px;
            background-image:
            linear-gradient(rgba(0,0,0,0.2),
            rgba(0,0,0,0.2)),
            url('/image/bckgrndyumna.jpeg');

            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
        }

        .login-box{
            width:400px;
            background:white;
            padding:40px;
            border-radius:20px;

            backdrop-filter: blur(5px);
        }

        .logo{
            display:flex;
            align-items:center;
            gap:15px;

             margin-bottom:50px;
        }

        .logo-img{
            width:55px;
        }

        .logo h2{
            font-size:35px;
        }

        .logo p{
            color:gray;
        }

        .subtitle{
            color:gray;
            margin-bottom:40px;
        }

        input{
            width:100%;
            padding:12px;
            margin-top:10px;
            margin-bottom:20px;

            border:none;
            border-bottom:1px solid #ccc;
        }

        button{
            width:100%;
            padding:12px;
            border:none;
            background:#233b73;
            color:white;
            border-radius:8px;
            cursor:pointer;
        }

        .welcome{
            margin-bottom:30px;
        }

    </style>

</head>
<body>

    <div class="login-box">
    <div class="logo">
    <img src="/image/logoyumna.jpg"
         class="logo-img">
    <div>
        <h2>YUMNA</h2>
        <p>Sistem Manajemen Stok</p>
    </div>

    </div>
        <div class="subtitle">
        </div>

        <div class="welcome">
            <h3>Selamat Datang</h3>
            <p>Masuk ke akun anda untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('login') }}">

            @csrf

            <input type="email"
                   name="email"
                   placeholder="Email"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Password"
                   required>

            <button type="submit">
                MASUK
            </button>

        </form>

    </div>

</body>
</html>