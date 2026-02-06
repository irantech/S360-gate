{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
<!doctype html>
<html lang="fa">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" type="text/css" href="https://www.bamekhalkhal.com/fa/user/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://www.bamekhalkhal.com/fa/user/css/style.css">

    <style>


        body {

            position: relative;
            overflow-x: hidden;
            direction: rtl;
            background:none !important;
        }




    </style>

</head>
<body>
{include file="`$smarty.const.FRONT_THEMES_DIR`sayolga/topBarName.tpl"}

{literal}
    <script  type="text/javascript" src="https://www.bamekhalkhal.com/fa/user/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">
        function signout() {
            $.post('https://online.bamekhalkhal.com/gds/user_ajax.php',
                {flag: 'signout'},
                function (data) {
                    window.top.location.href ="https://bamekhalkhal.com/fa/user/home.php";
                }
            )
        }
    </script>
{/literal}
</body>

</html>
