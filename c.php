<?php
session_start();

/**
 * Returns IP address of the current user.
 * @return String the IP address
 */
function ip() {
    $ip = '';
    if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != "") {
        $ip = $_SERVER['REMOTE_ADDR'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != "") {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != "") {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $ip;
}

/**
 * Builds a secure URL
 * @param type $data
 * @return type
 */
function url($data = []) {
    $value = serialize($data);
    $key = md5($value . ip() . session_id());
    $_SESSION[$key] = serialize($data);
    return '?t=' . $key;
}

function data($name = null, $default = null) {
    $token = isset($_GET['t']) ? $_GET['t'] : null;
    if ($token == null) {
        return null;
    }
    if (isset($_SESSION[$token]) == false) {
        return null;
    }
    $value = $_SESSION[$token];

    if (md5($value . ip() . session_id()) != $token) {
        die('Your usage session has expired');
    }

    $data = unserialize($value);
    if ($name === null) {
        return $data;
    }

    if (isset($data[$name]) == true) {
        return $data[$name];
    }
    return $default;
}

if (data('a', '') == '') {
    header('Location:c.php' . url(['a' => 'home']));
    exit;
}
if (data('a', '') == 'reset') {
    session_regenerate_id();
    header('Location:c.php' . url(['a' => 'home']));
    exit;
}
?>
<h1>
    Current Page: <?php echo data('a', ''); ?>
</h1>

<div>
    Menu:
    <ul>
        <li>
            <a href="<?php echo url(['a' => 'home']); ?>">Home</a>
            -            
            Current URL: <a href="<?php echo url(['a' => 'home']); ?>"><?php echo url(['a' => 'home']); ?></a>
        </li>
        <li>
            <a href="<?php echo url(['a' => 'link1']); ?>">Link 1</a>
            -            
            Current URL: <a href="<?php echo url(['a' => 'link1']); ?>"><?php echo url(['a' => 'link1']); ?></a>
        </li>
        <li>
            <a href="<?php echo url(['a' => 'link2']); ?>">Link 2</a>
            -            
            Current URL: <a href="<?php echo url(['a' => 'link2']); ?>"><?php echo url(['a' => 'link2']); ?></a>
        </li>
    </ul>
</div>

<div>
    <a href="<?php echo url(['a' => 'reset']); ?>">Reset Links</a>
</div>
