
    <style>


        body {
            font-family: iranyekan;
            margin: 0px;
            direction: rtl;
            padding: 0px;
        }
        i.svg-icon {
            width: 17px;
            height: 17px;
            position: absolute;
            right: 0px;
            top:0px;
            bottom:0px;
            margin: auto;
        }
        i.svg-icon svg {
            width: 17px;
            height: 17px;
            fill:#fff;
        }
        .top-bar {
            padding: 8px 13px;

            color: #fff;
            font-size: 13px;
        }

        .top-bar a {
            color: #fff;
            position: relative;
            text-decoration: none;
            margin-right: 0px;
            border-left: 1px solid #fff;
            padding-left: 20px;
        }

        .no-border{
            border: none !important;
        }

        .top-bar-inner {
            display: flex;
            max-width: 100%;
        }

        .top-bar-inner .tell {
            margin-right: auto;
        }

        .top-bar-inner .tell a , .top-bar-inner .tell span {
            font-family: persian-number ;
            /*! background-image: url(data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNDgyLjYgNDgyLjYiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4Mi42IDQ4Mi42OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMiIgaGVpZ2h0PSI1MTIiIGNsYXNzPSIiPjxnPjxnPgoJPHBhdGggZD0iTTk4LjMzOSwzMjAuOGM0Ny42LDU2LjksMTA0LjksMTAxLjcsMTcwLjMsMTMzLjRjMjQuOSwxMS44LDU4LjIsMjUuOCw5NS4zLDI4LjJjMi4zLDAuMSw0LjUsMC4yLDYuOCwwLjIgICBjMjQuOSwwLDQ0LjktOC42LDYxLjItMjYuM2MwLjEtMC4xLDAuMy0wLjMsMC40LTAuNWM1LjgtNywxMi40LTEzLjMsMTkuMy0yMGM0LjctNC41LDkuNS05LjIsMTQuMS0xNCAgIGMyMS4zLTIyLjIsMjEuMy01MC40LTAuMi03MS45bC02MC4xLTYwLjFjLTEwLjItMTAuNi0yMi40LTE2LjItMzUuMi0xNi4yYy0xMi44LDAtMjUuMSw1LjYtMzUuNiwxNi4xbC0zNS44LDM1LjggICBjLTMuMy0xLjktNi43LTMuNi05LjktNS4yYy00LTItNy43LTMuOS0xMS02Yy0zMi42LTIwLjctNjIuMi00Ny43LTkwLjUtODIuNGMtMTQuMy0xOC4xLTIzLjktMzMuMy0zMC42LTQ4LjggICBjOS40LTguNSwxOC4yLTE3LjQsMjYuNy0yNi4xYzMtMy4xLDYuMS02LjIsOS4yLTkuM2MxMC44LTEwLjgsMTYuNi0yMy4zLDE2LjYtMzZzLTUuNy0yNS4yLTE2LjYtMzZsLTI5LjgtMjkuOCAgIGMtMy41LTMuNS02LjgtNi45LTEwLjItMTAuNGMtNi42LTYuOC0xMy41LTEzLjgtMjAuMy0yMC4xYy0xMC4zLTEwLjEtMjIuNC0xNS40LTM1LjItMTUuNGMtMTIuNywwLTI0LjksNS4zLTM1LjYsMTUuNWwtMzcuNCwzNy40ICAgYy0xMy42LDEzLjYtMjEuMywzMC4xLTIyLjksNDkuMmMtMS45LDIzLjksMi41LDQ5LjMsMTMuOSw4MEMzMi43MzksMjI5LjYsNTkuMTM5LDI3My43LDk4LjMzOSwzMjAuOHogTTI1LjczOSwxMDQuMiAgIGMxLjItMTMuMyw2LjMtMjQuNCwxNS45LTM0bDM3LjItMzcuMmM1LjgtNS42LDEyLjItOC41LDE4LjQtOC41YzYuMSwwLDEyLjMsMi45LDE4LDguN2M2LjcsNi4yLDEzLDEyLjcsMTkuOCwxOS42ICAgYzMuNCwzLjUsNi45LDcsMTAuNCwxMC42bDI5LjgsMjkuOGM2LjIsNi4yLDkuNCwxMi41LDkuNCwxOC43cy0zLjIsMTIuNS05LjQsMTguN2MtMy4xLDMuMS02LjIsNi4zLTkuMyw5LjQgICBjLTkuMyw5LjQtMTgsMTguMy0yNy42LDI2LjhjLTAuMiwwLjItMC4zLDAuMy0wLjUsMC41Yy04LjMsOC4zLTcsMTYuMi01LDIyLjJjMC4xLDAuMywwLjIsMC41LDAuMywwLjggICBjNy43LDE4LjUsMTguNCwzNi4xLDM1LjEsNTcuMWMzMCwzNyw2MS42LDY1LjcsOTYuNCw4Ny44YzQuMywyLjgsOC45LDUsMTMuMiw3LjJjNCwyLDcuNywzLjksMTEsNmMwLjQsMC4yLDAuNywwLjQsMS4xLDAuNiAgIGMzLjMsMS43LDYuNSwyLjUsOS43LDIuNWM4LDAsMTMuMi01LjEsMTQuOS02LjhsMzcuNC0zNy40YzUuOC01LjgsMTIuMS04LjksMTguMy04LjljNy42LDAsMTMuOCw0LjcsMTcuNyw4LjlsNjAuMyw2MC4yICAgYzEyLDEyLDExLjksMjUtMC4zLDM3LjdjLTQuMiw0LjUtOC42LDguOC0xMy4zLDEzLjNjLTcsNi44LTE0LjMsMTMuOC0yMC45LDIxLjdjLTExLjUsMTIuNC0yNS4yLDE4LjItNDIuOSwxOC4yICAgYy0xLjcsMC0zLjUtMC4xLTUuMi0wLjJjLTMyLjgtMi4xLTYzLjMtMTQuOS04Ni4yLTI1LjhjLTYyLjItMzAuMS0xMTYuOC03Mi44LTE2Mi4xLTEyN2MtMzcuMy00NC45LTYyLjQtODYuNy03OS0xMzEuNSAgIEMyOC4wMzksMTQ2LjQsMjQuMTM5LDEyNC4zLDI1LjczOSwxMDQuMnoiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIGNsYXNzPSJhY3RpdmUtcGF0aCIgc3R5bGU9ImZpbGw6I0ZGRkZGRiIgZGF0YS1vbGRfY29sb3I9IiMwMDAwMDAiPjwvcGF0aD4KPC9nPjwvZz4gPC9zdmc+); */
            padding-left: 8px;
            background-size: 17px;
            background-position: right center;
            background-repeat: no-repeat;
            position: relative;
            color: #fff;
        }

        .top-bar-inner .logedin-links {
            margin-right: auto;
            display: flex;
        }

        .top-bar-inner .logedin-links div {
            margin: 0px 10px;
            display: flex;
            align-items: center;
        }

        .top-bar-inner .logedin-links div a {

            padding-right: 22px;
            background-repeat: no-repeat;
            background-size: 17px;
            min-height: 17px;
            background-position: right center;
        }

        .top-bar-inner .logedin-links div:first-child a {
            background-image: url(data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTIiIGhlaWdodD0iNTEyIiBjbGFzcz0iIj48Zz48Zz4KCTxnPgoJCTxwYXRoIGQ9Ik00MzcuMDIsMzMwLjk4Yy0yNy44ODMtMjcuODgyLTYxLjA3MS00OC41MjMtOTcuMjgxLTYxLjAxOEMzNzguNTIxLDI0My4yNTEsNDA0LDE5OC41NDgsNDA0LDE0OCAgICBDNDA0LDY2LjM5MywzMzcuNjA3LDAsMjU2LDBTMTA4LDY2LjM5MywxMDgsMTQ4YzAsNTAuNTQ4LDI1LjQ3OSw5NS4yNTEsNjQuMjYyLDEyMS45NjIgICAgYy0zNi4yMSwxMi40OTUtNjkuMzk4LDMzLjEzNi05Ny4yODEsNjEuMDE4QzI2LjYyOSwzNzkuMzMzLDAsNDQzLjYyLDAsNTEyaDQwYzAtMTE5LjEwMyw5Ni44OTctMjE2LDIxNi0yMTZzMjE2LDk2Ljg5NywyMTYsMjE2ICAgIGg0MEM1MTIsNDQzLjYyLDQ4NS4zNzEsMzc5LjMzMyw0MzcuMDIsMzMwLjk4eiBNMjU2LDI1NmMtNTkuNTUxLDAtMTA4LTQ4LjQ0OC0xMDgtMTA4UzE5Ni40NDksNDAsMjU2LDQwICAgIGM1OS41NTEsMCwxMDgsNDguNDQ4LDEwOCwxMDhTMzE1LjU1MSwyNTYsMjU2LDI1NnoiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIGNsYXNzPSJhY3RpdmUtcGF0aCIgc3R5bGU9ImZpbGw6I0ZGRkZGRiIgZGF0YS1vbGRfY29sb3I9IiMwMDAwMDAiPjwvcGF0aD4KCTwvZz4KPC9nPjwvZz4gPC9zdmc+);
        }

        .top-bar-inner .logedin-links div:last-child a {
            background-image: url(data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjUxMiIgdmlld0JveD0iMCAtMTAgNDkwLjY2NjY3IDQ5MCIgd2lkdGg9IjUxMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBjbGFzcz0iIj48Zz48cGF0aCBkPSJtNDc0LjY2Nzk2OSAyNTFoLTMwOS4zMzU5MzhjLTguODMyMDMxIDAtMTYtNy4xNjc5NjktMTYtMTZzNy4xNjc5NjktMTYgMTYtMTZoMzA5LjMzNTkzOGM4LjgzMjAzMSAwIDE2IDcuMTY3OTY5IDE2IDE2cy03LjE2Nzk2OSAxNi0xNiAxNnptMCAwIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBjbGFzcz0iYWN0aXZlLXBhdGgiIHN0eWxlPSJmaWxsOiNGRkZGRkYiIGRhdGEtb2xkX2NvbG9yPSIjMDAwMDAwIj48L3BhdGg+PHBhdGggZD0ibTI1MC42Njc5NjkgMzM2LjMzMjAzMWMtNC4wOTc2NTcgMC04LjE5MTQwNy0xLjU1NDY4Ny0xMS4zMDg1OTQtNC42OTE0MDZsLTg1LjMzMjAzMS04NS4zMzIwMzFjLTYuMjUtNi4yNTM5MDYtNi4yNS0xNi4zODY3MTkgMC0yMi42MzY3MTlsODUuMzMyMDMxLTg1LjMzMjAzMWM2LjI1LTYuMjUgMTYuMzgyODEzLTYuMjUgMjIuNjM2NzE5IDAgNi4yNSA2LjI1IDYuMjUgMTYuMzgyODEyIDAgMjIuNjMyODEybC03NC4wMjczNDQgNzQuMDI3MzQ0IDc0LjAyNzM0NCA3NC4wMjczNDRjNi4yNSA2LjI1IDYuMjUgMTYuMzgyODEyIDAgMjIuNjMyODEyLTMuMTM2NzE5IDMuMTE3MTg4LTcuMjM0Mzc1IDQuNjcxODc1LTExLjMyODEyNSA0LjY3MTg3NXptMCAwIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBjbGFzcz0iYWN0aXZlLXBhdGgiIHN0eWxlPSJmaWxsOiNGRkZGRkYiIGRhdGEtb2xkX2NvbG9yPSIjMDAwMDAwIj48L3BhdGg+PHBhdGggZD0ibTIzNC42Njc5NjkgNDY5LjY2Nzk2OWMtMTI5LjM4NjcxOSAwLTIzNC42Njc5NjktMTA1LjI4MTI1LTIzNC42Njc5NjktMjM0LjY2Nzk2OXMxMDUuMjgxMjUtMjM0LjY2Nzk2OSAyMzQuNjY3OTY5LTIzNC42Njc5NjljOTcuMDg1OTM3IDAgMTgyLjgwNDY4NyA1OC40MTAxNTcgMjE4LjQxMDE1NiAxNDguODI0MjE5IDMuMjQyMTg3IDguMjEwOTM4LS44MTI1IDE3LjQ5MjE4OC05LjAyMzQzNyAyMC43NTM5MDYtOC4yMTQ4NDQgMy4yMDMxMjUtMTcuNDk2MDk0LS43ODkwNjItMjAuNzU3ODEzLTkuMDQyOTY4LTMwLjc0MjE4Ny03OC4wODIwMzItMTA0Ljc4OTA2My0xMjguNTM1MTU3LTE4OC42Mjg5MDYtMTI4LjUzNTE1Ny0xMTEuNzQ2MDk0IDAtMjAyLjY2Nzk2OSA5MC45MjU3ODEtMjAyLjY2Nzk2OSAyMDIuNjY3OTY5czkwLjkyMTg3NSAyMDIuNjY3OTY5IDIwMi42Njc5NjkgMjAyLjY2Nzk2OWM4My44Mzk4NDMgMCAxNTcuODg2NzE5LTUwLjQ1MzEyNSAxODguNjI4OTA2LTEyOC41MTE3MTkgMy4yNDIxODctOC4yNTc4MTIgMTIuNTIzNDM3LTEyLjI0NjA5NCAyMC43NTc4MTMtOS4wNDY4NzUgOC4yMTA5MzcgMy4yNDIxODcgMTIuMjY1NjI0IDEyLjU0Mjk2OSA5LjAyMzQzNyAyMC43NTc4MTMtMzUuNjA1NDY5IDkwLjM5MDYyNC0xMjEuMzI0MjE5IDE0OC44MDA3ODEtMjE4LjQxMDE1NiAxNDguODAwNzgxem0wIDAiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIGNsYXNzPSJhY3RpdmUtcGF0aCIgc3R5bGU9ImZpbGw6I0ZGRkZGRiIgZGF0YS1vbGRfY29sb3I9IiMwMDAwMDAiPjwvcGF0aD48L2c+IDwvc3ZnPg==);
        }

        .top-bar-inner .logedin-links div:last-child {
            margin-left: 0px;
            padding-right: 20px;
            border-right: 1px solid #fff;
        }

        .top-bar-inner .loged-in span:first-child {
            margin-left: 2px;
            font-size: 13px;
        }

        .top-bar-inner .loged-in span:last-child {
            font-size: 12px;
            opacity: 0.8;
        }

        .top-bar-inner .loged-in span:last-child i {
            font-style: normal;
        }

        .top-bar-inner .login-register {
            display: flex;
            margin: 0;
        }
        .user_box div {

            display: inline-block;
            padding-right: 25px;
            margin-top: 6px;

        }

        .top-bar-inner .login-register > div {
            margin: 0 10px;
        }

        .top-bar-inner .login-register > div > a {
            padding-right: 22px;
            background-size: 17px;
            background-repeat: no-repeat;
            background-position: right center;
        }

        .top-bar-inner .login-register > div.login a {
            /*! background-image: url(data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjUxMiIgdmlld0JveD0iMCAtMTAgNDkwLjY2NjY3IDQ5MCIgd2lkdGg9IjUxMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Zz48cGF0aCBkPSJtMzI1LjMzMjAzMSAyNTFoLTMwOS4zMzIwMzFjLTguODMyMDMxIDAtMTYtNy4xNjc5NjktMTYtMTZzNy4xNjc5NjktMTYgMTYtMTZoMzA5LjMzMjAzMWM4LjgzMjAzMSAwIDE2IDcuMTY3OTY5IDE2IDE2cy03LjE2Nzk2OSAxNi0xNiAxNnptMCAwIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBjbGFzcz0iYWN0aXZlLXBhdGgiIHN0eWxlPSJmaWxsOiNGRkZGRkYiIGRhdGEtb2xkX2NvbG9yPSIjMDAwMDAwIj48L3BhdGg+PHBhdGggZD0ibTI0MCAzMzYuMzMyMDMxYy00LjA5NzY1NiAwLTguMTkxNDA2LTEuNTU0Njg3LTExLjMwODU5NC00LjY5MTQwNi02LjI1LTYuMjUtNi4yNS0xNi4zODI4MTMgMC0yMi42MzY3MTlsNzQuMDI3MzQ0LTc0LjAyMzQzNy03NC4wMjczNDQtNzQuMDI3MzQ0Yy02LjI1LTYuMjUtNi4yNS0xNi4zODY3MTkgMC0yMi42MzY3MTkgNi4yNTM5MDYtNi4yNSAxNi4zODY3MTktNi4yNSAyMi42MzY3MTkgMGw4NS4zMzIwMzEgODUuMzM1OTM4YzYuMjUgNi4yNSA2LjI1IDE2LjM4MjgxMiAwIDIyLjYzMjgxMmwtODUuMzMyMDMxIDg1LjMzMjAzMmMtMy4xMzY3MTkgMy4xNjAxNTYtNy4yMzA0NjkgNC43MTQ4NDMtMTEuMzI4MTI1IDQuNzE0ODQzem0wIDAiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIGNsYXNzPSJhY3RpdmUtcGF0aCIgc3R5bGU9ImZpbGw6I0ZGRkZGRiIgZGF0YS1vbGRfY29sb3I9IiMwMDAwMDAiPjwvcGF0aD48cGF0aCBkPSJtMjU2IDQ2OS42Njc5NjljLTk3LjA4OTg0NCAwLTE4Mi44MDQ2ODgtNTguNDEwMTU3LTIxOC40MTAxNTYtMTQ4LjgyNDIxOS0zLjI0MjE4OC04LjE5MTQwNi44MDg1OTQtMTcuNDkyMTg4IDkuMDIzNDM3LTIwLjczNDM3NSA4LjE5MTQwNy0zLjE5OTIxOSAxNy41MTU2MjUuNzg5MDYzIDIwLjc1NzgxMyA5LjA0Njg3NSAzMC43NDIxODcgNzguMDU4NTk0IDEwNC43ODkwNjIgMTI4LjUxMTcxOSAxODguNjI4OTA2IDEyOC41MTE3MTkgMTExLjc0MjE4OCAwIDIwMi42Njc5NjktOTAuOTI1NzgxIDIwMi42Njc5NjktMjAyLjY2Nzk2OXMtOTAuOTI1NzgxLTIwMi42Njc5NjktMjAyLjY2Nzk2OS0yMDIuNjY3OTY5Yy04My44Mzk4NDQgMC0xNTcuODg2NzE5IDUwLjQ1MzEyNS0xODguNjI4OTA2IDEyOC41MTE3MTktMy4yNjU2MjUgOC4yNTc4MTItMTIuNTY2NDA2IDEyLjI0NjA5NC0yMC43NTc4MTMgOS4wNDY4NzUtOC4yMTQ4NDMtMy4yNDIxODctMTIuMjY1NjI1LTEyLjU0Mjk2OS05LjAyMzQzNy0yMC43MzQzNzUgMzUuNjA1NDY4LTkwLjQxNDA2MiAxMjEuMzIwMzEyLTE0OC44MjQyMTkgMjE4LjQxMDE1Ni0xNDguODI0MjE5IDEyOS4zODY3MTkgMCAyMzQuNjY3OTY5IDEwNS4yODEyNSAyMzQuNjY3OTY5IDIzNC42Njc5NjlzLTEwNS4yODEyNSAyMzQuNjY3OTY5LTIzNC42Njc5NjkgMjM0LjY2Nzk2OXptMCAwIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBjbGFzcz0iYWN0aXZlLXBhdGgiIHN0eWxlPSJmaWxsOiNGRkZGRkYiIGRhdGEtb2xkX2NvbG9yPSIjMDAwMDAwIj48L3BhdGg+PC9nPiA8L3N2Zz4=); */
        }

        .top-bar-inner .login-register > div.register a {
            /*! background-image: url(data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTIiIGhlaWdodD0iNTEyIiBjbGFzcz0iIj48Zz48Zz4KCTxnPgoJCTxwYXRoIGQ9Ik0zNjcuNTcsMjU2LjkwOWMtOS44MzktNC42NzctMTkuODc4LTguNzA2LTMwLjA5My0xMi4wODFDMzcwLjU2LDIxOS45OTYsMzkyLDE4MC40NTUsMzkyLDEzNkMzOTIsNjEuMDEsMzMwLjk5MSwwLDI1NiwwICAgIGMtNzQuOTkxLDAtMTM2LDYxLjAxLTEzNiwxMzZjMCw0NC41MDQsMjEuNDg4LDg0LjA4NCw1NC42MzMsMTA4LjkxMWMtMzAuMzY4LDkuOTk4LTU4Ljg2MywyNS41NTUtODMuODAzLDQ2LjA2OSAgICBjLTQ1LjczMiwzNy42MTctNzcuNTI5LDkwLjA4Ni04OS41MzIsMTQ3Ljc0M2MtMy43NjIsMTguMDY2LDAuNzQ1LDM2LjYyMiwxMi4zNjMsNTAuOTA4QzI1LjIyMiw1MDMuODQ3LDQyLjM2NSw1MTIsNjAuNjkzLDUxMiAgICBIMzA3YzExLjA0NiwwLDIwLTguOTU0LDIwLTIwYzAtMTEuMDQ2LTguOTU0LTIwLTIwLTIwSDYwLjY5M2MtOC41MzgsMC0xMy42ODktNC43NjYtMTUuOTk5LTcuNjA2ICAgIGMtMy45ODktNC45MDUtNS41MzMtMTEuMjktNC4yMzYtMTcuNTE5YzIwLjc1NS05OS42OTUsMTA4LjY5MS0xNzIuNTIxLDIxMC4yNC0xNzQuOTc3YzEuNzU5LDAuMDY4LDMuNTI2LDAuMTAyLDUuMzAyLDAuMTAyICAgIGMxLjc5MywwLDMuNTc4LTAuMDM1LDUuMzU0LTAuMTA0YzMxLjEyLDAuNzMsNjEuMDUsNy44MzIsODkuMDQ0LDIxLjE0YzkuOTc3LDQuNzQsMjEuOTA3LDAuNDk5LDI2LjY0OS05LjQ3OCAgICBDMzgxLjc4OSwyNzMuNTgyLDM3Ny41NDcsMjYxLjY1MSwzNjcuNTcsMjU2LjkwOXogTTI2MC44NzgsMjMxLjg3N2MtMS42MjMtMC4wMjktMy4yNDktMC4wNDQtNC44NzgtMC4wNDQgICAgYy0xLjYxNCwwLTMuMjI4LDAuMDE2LTQuODQsMC4wNDZDMjAwLjQ2NSwyMjkuMzUsMTYwLDE4Ny4zMTIsMTYwLDEzNmMwLTUyLjkzNSw0My4wNjUtOTYsOTYtOTZzOTYsNDMuMDY1LDk2LDk2ICAgIEMzNTIsMTg3LjI5OSwzMTEuNTU1LDIyOS4zMjksMjYwLjg3OCwyMzEuODc3eiIgZGF0YS1vcmlnaW5hbD0iIzAwMDAwMCIgY2xhc3M9ImFjdGl2ZS1wYXRoIiBzdHlsZT0iZmlsbDojRkZGRkZGIiBkYXRhLW9sZF9jb2xvcj0iIzAwMDAwMCI+PC9wYXRoPgoJPC9nPgo8L2c+PGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNDkyLDM5N2gtNTV2LTU1YzAtMTEuMDQ2LTguOTU0LTIwLTIwLTIwYy0xMS4wNDYsMC0yMCw4Ljk1NC0yMCwyMHY1NWgtNTVjLTExLjA0NiwwLTIwLDguOTU0LTIwLDIwICAgIGMwLDExLjA0Niw4Ljk1NCwyMCwyMCwyMGg1NXY1NWMwLDExLjA0Niw4Ljk1NCwyMCwyMCwyMGMxMS4wNDYsMCwyMC04Ljk1NCwyMC0yMHYtNTVoNTVjMTEuMDQ2LDAsMjAtOC45NTQsMjAtMjAgICAgQzUxMiw0MDUuOTU0LDUwMy4wNDYsMzk3LDQ5MiwzOTd6IiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBjbGFzcz0iYWN0aXZlLXBhdGgiIHN0eWxlPSJmaWxsOiNGRkZGRkYiIGRhdGEtb2xkX2NvbG9yPSIjMDAwMDAwIj48L3BhdGg+Cgk8L2c+CjwvZz48L2c+IDwvc3ZnPg==); */
        }

        .top-bar-inner .login-register .login {
            margin-right: 0px;

            border-left: 1px solid #fff;
            padding-left: 20px;

        }

        @media (max-width: 576px) {
            .top-bar-inner .loged-in span:last-child {
                display: block;
            }


        }

        @media (max-width: 760px) {
            .tell{
                display: none;
            }
        }
        @media (max-width: 430px) {

            .top-bar-inner {
                flex-wrap: wrap;
            }

            .top-bar-inner .logedin-links div:first-child {
                margin-right: 0px;
            }

            .top-bar-inner .loged-in {
                flex: 0 0 100%;
                justify-content: center;
                justify-items: center;
                text-align: center;
                margin-bottom: 10px;
            }

            .top-bar-inner .logedin-links {
                flex: 0 0 100%;
                justify-content: center;
            }

            .top-bar-inner .loged-in span:last-child {
                display: inline-block !important;
            }
        }

        @media (max-width: 350px) {
            .top-bar, .top-bar * {
                font-size: 11px
            }

            .top-bar-inner .loged-in span *, .top-bar-inner .loged-in span {

                font-size: 11px;
            }

            .top-bar-inner .login-register > div > a, .top-bar-inner .logedin-links div a, .top-bar-inner .tell span {
                background-size: 15px;
            }
        }

        .social_header ul{ margin-top: 5px;}
        .social_header{ flex:  0 0 200px; }
        .social_header li{ display: inline-block}
        .social_header li { padding: 0 5px;}


    </style>


<div class="top-bar">
    <div class="container">
        <div class="top-bar-inner">
            <div class="login-register">
                <div class="user_box ml-auto">
                    {if $objSession->IsLogin() }

                        <a target="_parent" class="userProfile-name" href="{$smarty.const.ROOT_ADDRESS}/userProfile">
                            <span >{$objSession->getNameUser()} عزیز خوش آمدید</span>
                            {if $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}
                                <span class="CreditHide">(اعتبار آژانس شما {$objFunctions->CalculateCredit($objSession->getUserId())} ریال)</span>
                            {/if}
                        </a>

                        <div class="user_box_profile user_box_link"><span></span><a target="_parent" href="{$smarty.const.ROOT_ADDRESS}/userProfile">پروفایل کاربری</a>
                        </div>

                        <div class="user_box_logout user_box_link "><span></span><a style=" cursor: pointer " class="no-border" target="_parent" onclick="signout()">خروج</a>
                        </div>

                    {else}


                    {/if}
                </div>
                {if $objSession->IsLogin() }

                {else}



                    <div class="login">
                        <a target="_parent" class="no-border" href="{$smarty.const.ROOT_ADDRESS}/loginUser">
                            <i class="svg-icon">
                                <svg height="490pt" viewBox="0 -10 490.66667 490" width="490pt" xmlns="http://www.w3.org/2000/svg"><path d="m325.332031 251h-309.332031c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h309.332031c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path d="m240 336.332031c-4.097656 0-8.191406-1.554687-11.308594-4.691406-6.25-6.25-6.25-16.382813 0-22.636719l74.027344-74.023437-74.027344-74.027344c-6.25-6.25-6.25-16.386719 0-22.636719 6.253906-6.25 16.386719-6.25 22.636719 0l85.332031 85.335938c6.25 6.25 6.25 16.382812 0 22.632812l-85.332031 85.332032c-3.136719 3.160156-7.230469 4.714843-11.328125 4.714843zm0 0"/><path d="m256 469.667969c-97.089844 0-182.804688-58.410157-218.410156-148.824219-3.242188-8.191406.808594-17.492188 9.023437-20.734375 8.191407-3.199219 17.515625.789063 20.757813 9.046875 30.742187 78.058594 104.789062 128.511719 188.628906 128.511719 111.742188 0 202.667969-90.925781 202.667969-202.667969s-90.925781-202.667969-202.667969-202.667969c-83.839844 0-157.886719 50.453125-188.628906 128.511719-3.265625 8.257812-12.566406 12.246094-20.757813 9.046875-8.214843-3.242187-12.265625-12.542969-9.023437-20.734375 35.605468-90.414062 121.320312-148.824219 218.410156-148.824219 129.386719 0 234.667969 105.28125 234.667969 234.667969s-105.28125 234.667969-234.667969 234.667969zm0 0"/></svg>
                            </i>
                            ورود</a>
                    </div>
                    <div class="register">
                        <a  target="_parent" class="no-border" href="{$smarty.const.ROOT_ADDRESS}/registerUser">
                            <i class="svg-icon">
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
						<g>
                            <g>
                                <path d="M367.57,256.909c-9.839-4.677-19.878-8.706-30.093-12.081C370.56,219.996,392,180.455,392,136C392,61.01,330.991,0,256,0
									c-74.991,0-136,61.01-136,136c0,44.504,21.488,84.084,54.633,108.911c-30.368,9.998-58.863,25.555-83.803,46.069
									c-45.732,37.617-77.529,90.086-89.532,147.743c-3.762,18.066,0.745,36.622,12.363,50.908C25.222,503.847,42.365,512,60.693,512
									H307c11.046,0,20-8.954,20-20c0-11.046-8.954-20-20-20H60.693c-8.538,0-13.689-4.766-15.999-7.606
									c-3.989-4.905-5.533-11.29-4.236-17.519c20.755-99.695,108.691-172.521,210.24-174.977c1.759,0.068,3.526,0.102,5.302,0.102
									c1.793,0,3.578-0.035,5.354-0.104c31.12,0.73,61.05,7.832,89.044,21.14c9.977,4.74,21.907,0.499,26.649-9.478
									C381.789,273.582,377.547,261.651,367.57,256.909z M260.878,231.877c-1.623-0.029-3.249-0.044-4.878-0.044
									c-1.614,0-3.228,0.016-4.84,0.046C200.465,229.35,160,187.312,160,136c0-52.935,43.065-96,96-96s96,43.065,96,96
									C352,187.299,311.555,229.329,260.878,231.877z"/>
                            </g>
                        </g>
                                    <g>
                                        <g>
                                            <path d="M492,397h-55v-55c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v55h-55c-11.046,0-20,8.954-20,20
									c0,11.046,8.954,20,20,20h55v55c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20v-55h55c11.046,0,20-8.954,20-20
									C512,405.954,503.046,397,492,397z"/>
                                        </g>
                                    </g>
					 </svg>
                            </i>
                            ثبت نام</a>
                    </div>
                {/if}
            </div>



            <div class="tell">
                <a href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}</a>
                <span style="padding-top: 15px;  float: left;">



                	<i class="svg-icon">
					<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 482.6 482.6" style="enable-background:new 0 0 482.6 482.6;" xml:space="preserve">
					<g>
					<path d="M98.339,320.8c47.6,56.9,104.9,101.7,170.3,133.4c24.9,11.8,58.2,25.8,95.3,28.2c2.3,0.1,4.5,0.2,6.8,0.2
					c24.9,0,44.9-8.6,61.2-26.3c0.1-0.1,0.3-0.3,0.4-0.5c5.8-7,12.4-13.3,19.3-20c4.7-4.5,9.5-9.2,14.1-14
					c21.3-22.2,21.3-50.4-0.2-71.9l-60.1-60.1c-10.2-10.6-22.4-16.2-35.2-16.2c-12.8,0-25.1,5.6-35.6,16.1l-35.8,35.8
					c-3.3-1.9-6.7-3.6-9.9-5.2c-4-2-7.7-3.9-11-6c-32.6-20.7-62.2-47.7-90.5-82.4c-14.3-18.1-23.9-33.3-30.6-48.8
					c9.4-8.5,18.2-17.4,26.7-26.1c3-3.1,6.1-6.2,9.2-9.3c10.8-10.8,16.6-23.3,16.6-36s-5.7-25.2-16.6-36l-29.8-29.8
					c-3.5-3.5-6.8-6.9-10.2-10.4c-6.6-6.8-13.5-13.8-20.3-20.1c-10.3-10.1-22.4-15.4-35.2-15.4c-12.7,0-24.9,5.3-35.6,15.5l-37.4,37.4
					c-13.6,13.6-21.3,30.1-22.9,49.2c-1.9,23.9,2.5,49.3,13.9,80C32.739,229.6,59.139,273.7,98.339,320.8z M25.739,104.2
					c1.2-13.3,6.3-24.4,15.9-34l37.2-37.2c5.8-5.6,12.2-8.5,18.4-8.5c6.1,0,12.3,2.9,18,8.7c6.7,6.2,13,12.7,19.8,19.6
					c3.4,3.5,6.9,7,10.4,10.6l29.8,29.8c6.2,6.2,9.4,12.5,9.4,18.7s-3.2,12.5-9.4,18.7c-3.1,3.1-6.2,6.3-9.3,9.4
					c-9.3,9.4-18,18.3-27.6,26.8c-0.2,0.2-0.3,0.3-0.5,0.5c-8.3,8.3-7,16.2-5,22.2c0.1,0.3,0.2,0.5,0.3,0.8
					c7.7,18.5,18.4,36.1,35.1,57.1c30,37,61.6,65.7,96.4,87.8c4.3,2.8,8.9,5,13.2,7.2c4,2,7.7,3.9,11,6c0.4,0.2,0.7,0.4,1.1,0.6
					c3.3,1.7,6.5,2.5,9.7,2.5c8,0,13.2-5.1,14.9-6.8l37.4-37.4c5.8-5.8,12.1-8.9,18.3-8.9c7.6,0,13.8,4.7,17.7,8.9l60.3,60.2
					c12,12,11.9,25-0.3,37.7c-4.2,4.5-8.6,8.8-13.3,13.3c-7,6.8-14.3,13.8-20.9,21.7c-11.5,12.4-25.2,18.2-42.9,18.2
					c-1.7,0-3.5-0.1-5.2-0.2c-32.8-2.1-63.3-14.9-86.2-25.8c-62.2-30.1-116.8-72.8-162.1-127c-37.3-44.9-62.4-86.7-79-131.5
					C28.039,146.4,24.139,124.3,25.739,104.2z"/>
					</g>
					</svg>
				</i>

                </span>

            </div>
        </div>
    </div>
</div>

