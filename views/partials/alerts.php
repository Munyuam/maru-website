<?php
use App\Helpers\Session;

$flashTypes = ['success', 'error', 'warning', 'info'];

foreach ($flashTypes as $type) {
    if ($message = Session::getFlash($type)) {
        echo "<div class=\"alert alert-{$type} mb-4\">";
        echo "<div>" . htmlspecialchars($message) . "</div>";
        echo "</div>";
    }
}
?>
