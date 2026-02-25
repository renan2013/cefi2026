<?php
if (extension_loaded('sodium')) {
    echo 'La extensión Sodium está instalada en tu servidor.';
} else {
    echo 'La extensión Sodium no está instalada en tu servidor.';
}
?>
