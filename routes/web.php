<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/excel-import', [App\Http\Controllers\HomeController::class, 'excelImport'])->name('excel.import');

Route::post('/github/webhooks', function () {
    try {
        $secret = "monkey@21";
        $payload = file_get_contents("php://input");
        $signature = $_SERVER["HTTP_X_HUB_SIGNATURE_256"] ?? "";
        $hash = "sha256=" . hash_hmac("sha256", $payload, $secret);
        if (!hash_equals($hash, $signature)) {
            http_response_code(403);
            exit("Invalid Signature");
        }

        $data = json_decode($payload, true);
        if ($data["ref"] === "refs/heads/new") {
            exec("cd ~/public_html/magar-gaun-krishak-samuha && git pull origin main 2>&1", $output, $returnCode);
            file_put_contents("webhook.log", implode('\n', $output), FILE_APPEND);
        }
        return response()->json('success', 200);
    } catch (Exception $e) {
        return response()->json($e->getMessage(), 500);
    }
});