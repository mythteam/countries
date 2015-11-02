<?php

$remote = 'https://raw.githubusercontent.com/herrniemand/visas/master/data/info/countries.json';

echo 'Getting data from remote..', PHP_EOL;
$json = file_get_contents($remote);
echo 'Done!', PHP_EOL;

$data = json_decode($json, true);

if (!$data) {
    throw new \Exception('Parse data error');
}
$result = [];
foreach ($data as $item) {
    $result[] = '[' . implode(',', [
        '\'full\' => ' . '\'' . $item['name']['common'] . '\'',
        '\'short\' => ' . '\'' . $item['cca2'] . '\'',
        '\'currency\' => ' . '\'' . (isset($item['currency'][0]) ? $item['currency'][0] : '') . '\'',
    ]) . ']';
}
$result = implode(',' . PHP_EOL, $result);
$php = <<<EOF
<?php
return [
    $result
];
EOF;
file_put_contents('./data/countries.php', $php);
