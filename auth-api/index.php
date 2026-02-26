<?php
ini_set('display_errors', 1);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'] ?? '';
    $password = $input['password'] ?? '';

    // ✅ IDENTIFIANTS FIXES (pas de BDD)
    if ($username === 'admin' && $password === 'admin') {
        $token = bin2hex(random_bytes(32));
        echo json_encode([
            'token' => $token,
            'user' => $username,
            'expires' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);
        exit();
    }

    http_response_code(401);
    echo json_encode(['error' => 'Identifiants incorrects']);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Seul POST autorisé']);
}
?>