
{if $objSession->IsLogin() and $objSession->getTypeUser() eq 'agency'}


    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
    <style>


        .welcome-agency-panel {
            width: 100%;
            max-width: 800px;
            text-align: center;
            margin: 0 auto;
        }

        .welcome-header {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 50px 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .welcome-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
        }

        h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p {
            font-size: 1.5rem;
            color: #7f8c8d;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .construction-icon {
            font-size: 5rem;
            margin-bottom: 30px;
            color: #6a11cb;
            animation: pulse 2s infinite;
        }

        .progress-container {
            height: 8px;
            width: 80%;
            background-color: #ecf0f1;
            border-radius: 4px;
            margin: 30px auto;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 60%;
            background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
            border-radius: 4px;
            animation: progress-animation 3s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @keyframes progress-animation {
            0% { margin-left: -50%; }
            100% { margin-left: 100%; }
        }

        @media (max-width: 768px) {
            h1 { font-size: 2.5rem; }
            p { font-size: 1.2rem; }
            .construction-icon { font-size: 4rem; }
        }
    </style>
    <div class="client-head-content">
        <div class="client-head-content_c_">
            <div class="welcome-agency-panel">
                <div class="welcome-header">
                    <div class="construction-icon">✈️</div>
                    <h1>خوش آمدید</h1>
                    <p>صفحه در دست طراحی و توسعه</p>
                    <div class="progress-container">
                        <div class="progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{else}
    {$objFunctions->redirectOutAgency()}
{/if}