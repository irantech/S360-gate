<?php
header('Content-Type: text/html; charset=utf-8');

$jsonFile = __DIR__ . "/../allModules.json";
$raw = file_get_contents("php://input");

if (!$raw) die("دادهای دریافت نشد");

$data = json_decode($raw, true);
if (!$data) die("فرمت JSON معتبر نیست");

$id = $data["id"];
$action = $data["StatusRecord"];

// اگر فایل وجود نداشت بسازیم
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, json_encode([], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

// خواندن فعلی
$modules = json_decode(file_get_contents($jsonFile), true);
if (!is_array($modules)) $modules = [];

/* ===========================================
   DELETE
=========================================== */
if ($action === "Delete") {

    $newList = [];
    foreach ($modules as $item) {
        if ($item["id"] != $id) {
            $newList[] = $item;
        }
    }

    file_put_contents($jsonFile, json_encode($newList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    exit("موفقیت حذف شد");
}

/* ===========================================
   INSERT
=========================================== */
if ($action === "Insert") {

    // اگر قبلاً وجود داشت، اول حذف شود
    foreach ($modules as $key => $item) {
        if ($item["id"] == $id) {
            unset($modules[$key]);
        }
    }

    // سپس رکورد جدید اضافه شود
    $modules[] = $data;

    file_put_contents($jsonFile, json_encode(array_values($modules), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    exit("با موفقیت درج شد");
}

/* ===========================================
   UPDATE
=========================================== */
if ($action === "Update") {

    $found = false;

    foreach ($modules as $key => $item) {
        if ($item["id"] == $id) {
            $modules[$key] = $data;
            $found = true;
            break;
        }
    }

    if (!$found) {
        exit("رکوردی برای بروزرسانی یافت نشد");
    }

    file_put_contents($jsonFile, json_encode($modules, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    exit("بروزرسانی شد");
}

// اگر هیچ اکشنی نبود
exit("هیچ عملیاتی انجام نشد");

?>
