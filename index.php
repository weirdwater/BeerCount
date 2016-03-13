<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['drinker']) && isset($_POST['drinkers']) ) {
    $drinkerIndex = $_POST['drinker'];
    $drinkers = string_to_array($_POST['drinkers']);
    $drinkers[$drinkerIndex][1]++;
}
else {
    $drinkers = [
        [
            'Andreas',
            0
        ],
        [
            'Arjo',
            0
        ],
        [
            'Hans',
            0
        ],
        [
            'Guests',
            0
        ]

    ];
}
$title = 'Beer Score';
$drinkers_string = array_to_string($drinkers);

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
                    <h2><?= $drinker[0] ?></h2>
                    <h3><?= $drinker[1] ?></h3>
                    <form action="#" method="post">
                        <input type="hidden" name="drinker" value="<?= $key ?>" />
                        <input type="hidden" name="drinkers" value="<?= $drinkers_string ?>" />
                        <input type="submit" value="+1" />
                    </form>
                </section>
            <?php } ?>
        </div>
    </div>
</body>
</html>