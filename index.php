<?php
include 'settings.php';

try {
    $db = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('SET NAMES \'utf8\'');
} catch (PDOException $e) {
    echo 'Whoops something went wrong! [1] '. $e->getMessage() .' '. $e->getFile();
    exit;
}

// Add to log
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['drinker']) ) {
    $drinkerId = $_POST['drinker'];

    try {
        $addBeer = $db->prepare("
            INSERT INTO Log (beerId, drinkerId)
            VALUES (2, ?)
        ");
        $addBeer->bindParam(1, $drinkerId, PDO::PARAM_INT);
        $addBeer->execute();
    } catch (PDOException $e) {
        echo 'Whoops something went wrong! [2] '. $e->getMessage() .' '. $e->getFile();
        exit;
    }
}

// Fetch all drinker data
try {
    $drinkers = $db->query("
      SELECT d.drinkerId, d.name, (
        SELECT COUNT(entryId)
        FROM Log l
        WHERE l.drinkerId = d.drinkerId
      ) as 'count'
      FROM Drinkers d
    ");
    $drinkers->execute();
    $drinkers = $drinkers->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Whoops something went wrong! [3] '. $e->getMessage() .' '. $e->getFile();
    exit;
}

$title = 'Beer Score';

function array_to_string(array $array, $lvl = 0)
{
    $dividers = ['|',',',';',':'];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = array_to_string($value, $lvl + 1);
        }
    }
    $string = implode($dividers[$lvl], $array);
    return $string;
}

function string_to_array($string, $lvl = 0)
{
    $dividers = ['|',',',';',':'];
    $array = explode($dividers[$lvl], $string);
    foreach ($array as $key => $value) {

        $next_lvl = $lvl + 1;
        $pattern = '/' . $dividers[$next_lvl] . '/';
        if (preg_match($pattern, $value)) {
            $array[$key] = string_to_array($value, $next_lvl);
        }
    }
    return $array;
}

function pre_dump($var)
{
    echo "<pre>";
    var_dump($var);
    exit;
}

?>
<!doctype html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>
    <div class="container">
        <header>
            <h1><?= $title ?></h1>
            <link rel="stylesheet" href="stylesheets/site.css" />
        </header>
        <div class="drinkers">
            <?php foreach ($drinkers as $key => $drinker) { ?>
                <section class="drinker">
                    <h2><?= $drinker['name'] ?></h2>
                    <h3><?= $drinker['count'] ?></h3>
                    <form action="#" method="post">
                        <input type="hidden" name="drinker" value="<?= $drinker['drinkerId']  ?>" />
                        <input type="submit" value="+1" />
                    </form>
                </section>
            <?php } ?>
        </div>
    </div>
</body>
</html>