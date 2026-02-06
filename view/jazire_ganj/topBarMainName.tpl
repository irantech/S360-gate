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
    {if $smarty.const.SOFTWARE_LANG eq 'en'}
        <link rel="stylesheet" type="text/css"
              href="https://jazirehganj.com/en/user/GlobalFile/css/register.css">
    {else}
        <link rel="stylesheet" type="text/css"
              href="https://jazirehganj.com/fa/user/GlobalFile/css/register.css">
    {/if}




    <style>

        html { height: 100% }
        body {
            background: none !important;
            width: 100%;
            height: 100%;
            margin:0;

        }

    </style>





</head>
<body>
{include file="`$smarty.const.FRONT_THEMES_DIR`jazire_ganj/topBarName.tpl"}

{literal}
    <script  type="text/javascript" src="https://jazirehganj.com/fa/user/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function signout() {
            $.post('https://online.jazirehganj.com/gds/user_ajax.php',
                {flag: 'signout'},
                function (data) {
                    window.top.location.href ="https://jazirehganj.com/fa/user/home.php";
                }
            )
        }
    </script>
{/literal}
</body>

</html>
