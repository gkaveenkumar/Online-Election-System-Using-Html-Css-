<?php
header('Content-Type: application/json');

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);
$candidate = $data['candidate'] ?? null;

if (!$candidate) {
    echo json_encode(['success' => false, 'message' => 'No candidate selected']);
    exit;
}

// Path to store votes
$file = 'votes.json';

// Read the existing vote data or initialize it
if (file_exists($file)) {
    $votes = json_decode(file_get_contents($file), true);
} else {
    $votes = ['John Doe' => 0, 'Jane Smith' => 0, 'Alex Johnson' => 0];
}

// Increment the vote count for the selected candidate
if (isset($votes[$candidate])) {
    $votes[$candidate]++;
    file_put_contents($file, json_encode($votes));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid candidate']);
}
