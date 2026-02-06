<?php


$data = [
    "name" => DESCRIPTION_SITE,
    "short_name" => CLIENT_NAME,
    "description" => DESCRIPTION_SITE,
    "background_color" => "#FFFFFF",
    "theme_color" => "#FFFFFF",
    "dir" => "rtl",
    "lang" => "fa",
    "categories" => ["travel"],
    "orientation" => "portrait",

//    "prefer_related_applications" => true,
//    "scope" => SERVER_HTTP . CLIENT_DOMAIN . "/gds/app",
    "serviceworker" => SERVER_HTTP . CLIENT_DOMAIN . "/service-worker.js",
//    "related_applications" => [
//        [
//            "platform" => "play",
//            "url" => "https://play.google.com/store/apps/details?id=com.discord",
//            "id" => "com.discord"
//        ],
//    ],
    "display" => "standalone",

    "shortcuts" => [
        [
            "name" => CLIENT_NAME,
            "url" => SERVER_HTTP . CLIENT_DOMAIN . "/gds/app",
            "description" => DESCRIPTION_SITE,
            "icons" => [
                [
                    "src" => "./view/" . FRONT_TEMPLATE_NAME . "/project_files/icons/icon-192x192.png",
                    "sizes" => "192x192"
                ]
            ]
        ]
    ],
    "start_url" => SERVER_HTTP . CLIENT_DOMAIN . "/gds/app",
    "icons" => [
        [
            "src" => "./view/" . FRONT_TEMPLATE_NAME . "/project_files/icons/icon-72x72.png",
            "sizes" => "72x72",
            "type" => "image/png",
            "purpose" => "maskable any"
        ],
        [
            "src" => "./view/" . FRONT_TEMPLATE_NAME . "/project_files/icons/icon-96x96.png",
            "sizes" => "96x96",
            "type" => "image/png",
            "purpose" => "maskable any"
        ],
        [
            "src" => "./view/" . FRONT_TEMPLATE_NAME . "/project_files/icons/icon-128x128.png",
            "sizes" => "128x128",
            "type" => "image/png",
            "purpose" => "maskable any"
        ],
        [
            "src" => "./view/" . FRONT_TEMPLATE_NAME . "/project_files/icons/icon-144x144.png",
            "sizes" => "144x144",
            "type" => "image/png",
            "purpose" => "maskable any"
        ],
        [
            "src" => "./view/" . FRONT_TEMPLATE_NAME . "/project_files/icons/icon-152x152.png",
            "sizes" => "152x152",
            "type" => "image/png",
            "purpose" => "maskable any"
        ],
        [
            "src" => "./view/" . FRONT_TEMPLATE_NAME . "/project_files/icons/icon-192x192.png",
            "sizes" => "192x192",
            "type" => "image/png",
            "purpose" => "maskable any"
        ],
        [
            "src" => "./view/" . FRONT_TEMPLATE_NAME . "/project_files/icons/icon-384x384.png",
            "sizes" => "384x384",
            "type" => "image/png",
            "purpose" => "maskable any"
        ],
        [
            "src" => "./view/" . FRONT_TEMPLATE_NAME . "/project_files/icons/icon-512x512.png",
            "sizes" => "512x512",
            "type" => "image/png",
            "purpose" => "maskable any"
        ]
    ]
];

if (CLIENT_ID == 166) {

//for 1 to 5
    for ($i = 1; $i <= 5; $i++) {
        $data["screenshots"][] = [
            "src" => SERVER_HTTP . CLIENT_DOMAIN . "/gds/pwa/screenshots/" . $i . ".jpg",
            "type" => "image/jpg",
            "sizes" => "1080x2400",
            "label" => "screenshot number " . $i
        ];
    }
}


echo json_encode($data, 256);