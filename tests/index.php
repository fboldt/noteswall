<!DOCTYPE html>
<html>

<head>
    <title>Tests Page</title>
</head>

<body>

<?php
function run_test($file) {
    echo "<h1>" . $file . "</h1>";
    echo "<h2>begin</h2>";
    require_once $file;
    eval(str_replace(".php","",$file)."();");
    echo "<h2>end</h2>";
}
run_test('test_localhost.php');
run_test('test_database_connection.php');
run_test('test_database_wrapper.php');
run_test('test_login.php');
?>

</body>

</html>
