<?php
header('Content-Type: application/json; charset=utf-8');

// ---------- Funciones de validación ----------

function soloPost() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        responder(false, 'Método no permitido. Usa POST.', 405);
    }
}

function obtenerJson() {
    $json = file_get_contents('php://input');
    $datos = json_decode($json, true);
    if (!$datos || !isset($datos['op1'], $datos['op2'], $datos['op'])) {
        responder(false, 'Datos incompletos. Envía op1, op2 y op.', 400);
    }
    return $datos;
}

function validarNumeros($a, $b) {
    $op1 = filter_var($a, FILTER_VALIDATE_FLOAT);
    $op2 = filter_var($b, FILTER_VALIDATE_FLOAT);
    if ($op1 === false || $op2 === false) {
        responder(false, 'Los operadores deben ser valores numéricos.', 400);
    }
    return [$op1, $op2];
}

function responder($ok, $mensaje, $codigo = 200) {
    http_response_code($codigo);
    $respuesta = $ok ? ['ok' => true, 'resultado' => $mensaje] : ['ok' => false, 'error' => $mensaje];
    echo json_encode($respuesta);
    exit;
}

// ---------- Operaciones (array de funciones anónimas) ----------

$operaciones = [
    'suma' => function($a, $b) { return $a + $b; },
    'resta' => function($a, $b) { return $a - $b; },
    'multiplicacion' => function($a, $b) { return $a * $b; },
    'division' => function($a, $b) {
        if ($b == 0) {
            responder(false, 'No es posible dividir entre cero.', 400);
        }
        return $a / $b;
    }
];

// ---------- Flujo principal ----------

soloPost();
$datos = obtenerJson();
list($op1, $op2) = validarNumeros($datos['op1'], $datos['op2']);
$op = $datos['op'];

if (!array_key_exists($op, $operaciones)) {
    responder(false, 'Operación no válida. Usa: suma, resta, multiplicacion o division.', 400);
}

$resultado = $operaciones[$op]($op1, $op2);
responder(true, $resultado);