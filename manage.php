<?php
/**
 * Redirector
 * This file handles all incoming URL keys, increments the counter, and forwards
 * along to the destination if it exists
 */

require 'init.php';

session_start();

// Check if the user is trying to log in
if (!empty($_POST['password']) && $_POST['password'] == $admin_password) {
    $_SESSION['authenticated'] = true;
}

// Base URL
$base_url = 'http'.($_SERVER['SERVER_PORT'] == 443 ? 's' : '').'://'.$_SERVER['SERVER_NAME'].$path;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>lilliputian management</title>
</head>

<body>
<h1>lilliputian management</h1>

<?php
// If not logged in, show the form and exit
if (empty($_SESSION['authenticated'])) {
?>
    <form method="post">
        <label for="password">password:</label> <input type="password" name="password" id="password" />
        <input type="submit" value="log in" />
    </form>
    
    </body>
    </html>
<?php
    exit;
}

// Check if any actions need to be handled
if (isset($_GET['action'])) {
    
    // Check if the action is creating a URL
    if ($_GET['action'] == 'create') {
        $key = mysql_real_escape_string($_GET['key']);
        $url = mysql_real_escape_string($_GET['url']);
        
        $exists = mysql_query("SELECT * FROM lilliputian WHERE `key` = '{$key}'");
        
        if (mysql_num_rows($exists) > 0) {
            echo '<h3 style="color: red;">key already exists</h3>';
        }
        else {
            mysql_query("INSERT INTO lilliputian (`key`, url, created) VALUES('{$key}', '{$url}', NOW())");
            
            echo '<h3 style="color: green;">created <a href="'.htmlentities($base_url.'/'.$_GET['key']).'">'.htmlentities($base_url.'/'.$_GET['key']).'</a></h3>';
        }
    }
    
    if ($_GET['action'] == 'logout') {
        $_SESSION = array();
        session_destroy();
        // Not my finest work!
        die('<p>Logged out. <a href="'.$base_url.'/manage.php">Log back in?</a></p></body></html>');
    }
}
?>

<h2>new lilliput</h2>
<div>
    <form>
        <label for="key">key:</label> <input type="text" name="key" id="key" /><br />
        <label for="url">URL:</label> <input type="text" name="url" id="url" /><br />
        <input type="submit" name="action" value="create"/>
    </form>
</div>

<h2>existing lilliputs</h2>
<?php
// Get the existing items
$items_qry = mysql_query("SELECT * FROM lilliputian ORDER BY created DESC");

if (mysql_num_rows($items_qry) > 0) {
?>
    <table>
        <thead>
            <tr>
                <th>key</th>
                <th>URL</th>
                <th>hits</th>
                <th>created</th>
                <th></th>
            </tr>
        </thead>
    
        <tbody>
    
    <?php while ($item = mysql_fetch_array($items_qry)) { ?>
        <tr>
            <td><a href="<?php echo htmlentities($base_url.'/'.$item['key']); ?>"><?php echo htmlentities($item['key']); ?></a></td>
            <td><a href="<?php echo htmlentities($item['url']); ?>"><?php echo htmlentities($item['url']); ?></a></td>
            <td><?php echo $item['hits']; ?></td>
            <td><?php echo $item['created']; ?></td>
            <td><!--edit | delete--></td>
        </tr>
    <?php } ?>

        </tbody>
    </table>
<?php } else { ?>
    <p>none yet! create one above.</p>
<?php } ?>

<p>bookmarklet: <a href="javascript:var%20k=window.prompt('key?');window.open('<?php echo $base_url; ?>/manage.php?action=create&amp;key='+k+'&amp;url='+document.location.href);void(0);">lilliput it</a></p>
<p><a href="manage.php?action=logout">log out</a></p>

</body>
</html>