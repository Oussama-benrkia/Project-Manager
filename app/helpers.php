<?php

use App\Models\history;

function logAction($action, $user_id, $model, $model_id = null, $data = null) {
    history::create(
        [
            'action' => $action,
            'user_id' => $user_id,
            'model' => $model,
            'model_id' => $model_id,
            'data' => $data,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );
}
?>