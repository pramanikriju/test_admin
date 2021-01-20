<html>
    <head>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Montserrat:400,600,700');
            body{
                color: #6d6d6d;
                text-align:center;
                font-family: 'Montserrat', sans-serif;
                font-size: 18px;
                line-height: 28px;
            }
            input.text, .button{
                color: #6d6d6d;
                display:inline-block;
                width:100%;
                font-size:16px;
                margin-bottom:20px;
                height:50px;
                line-height:50px;
                background-color: #edf5f9;
                border-radius:5px;
                border: 1px solid #b2d9f2;
                text-indent:15px;
                outline:none;
                -webkit-appearance: none;
            }
            select.text{
                color: #6d6d6d;
                display:inline-block;
                width:100%;
                font-size:16px;
                margin-bottom:20px;
                height:50px;
                line-height:50px;
                background-color: #edf5f9;
                border-radius:5px;
                border: 1px solid #b2d9f2;
                text-indent:15px;
                outline:none;
            }
            input.submit, a.button{
                background-color: #ffbc00;
                border: 1px solid #ffbc00;
                color: #fff;
                text-decoration:none;
            }
            .loading{
                position: absolute;
                width: 100%;
                height: 100%;
                left: 0px;
                top: 0px;
                background-color: #fff;
                background-image: url('/fe/images/loading.gif');
                background-repeat: no-repeat;
                background-position: center center;
                opacity: 0.5;
                display: none;
            }
        </style>
        <script src="/fe/js/jquery-1.11.1.min.js"></script>
    </head>

    <body>