<?php
function arabicToPersian($inp)
{
    $out = str_replace(array('ي', 'ك'), array('ی', 'ک'), $inp);
    return ($out);
}
function changeCharsOfEachTable($pdo, $table_name, $fields)
{
    $sql = "SELECT * from " . $table_name;
    $rows = $pdo->query($sql);
    $rowCount = $rows->rowCount();
    $arr = [];
    foreach ($rows as $item) {
        $arr[] = $item;
    }
    for ($i = 0; $i < $rowCount; $i++) {
        foreach ($arr[$i] as $key => $value) {
            if (gettype($arr[$i][$key]) == "string") {
                $arr[$i][$key] = arabicToPersian($arr[$i][$key]);
            }
        }
    }
    $values = [];
    for ($i = 0; $i < $rowCount; $i++) {
        foreach ($arr[$i] as $key => $value) {
            if (in_array($key, $fields)) {
                $values[$i][$key] = $value;
            }
        }
    }
    $setPhrase = [];
    for ($i = 0; $i < $rowCount; $i++) {
        foreach ($values[$i] as $key => $value) {
            if (gettype($key) == "string") {
                $setPhrase[$i] .= $key . ' = ' . "'$value'" . ',';
            }
        }
        $setPhrase[$i] = substr($setPhrase[$i],0,-1);
        $setPhrase[$i].= ' WHERE id = '.$values[$i][0];
    }
    for ($i = 0; $i < $rowCount; $i++) {
        $sql = "UPDATE ". $table_name. " SET " . $setPhrase[$i];
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
}
try {
    $pdo = new PDO('mysql:host=localhost;dbname=aref_jazb', 'root', 159951);
    echo "we are connected to db<br>";
    changeCharsOfEachTable($pdo, 'students', ["first_name","last_name","school","introducing"]);
    changeCharsOfEachTable($pdo,'users',["first_name","last_name","education","major","home_address","work_address"]);
    changeCharsOfEachTable($pdo,'temperatures',["name"]);
    changeCharsOfEachTable($pdo,'tag_parent_twos',["name"]);
    changeCharsOfEachTable($pdo,'tag_parent_threes',["name"]);
    changeCharsOfEachTable($pdo,'tag_parent_ones',["name"]);
    changeCharsOfEachTable($pdo,'sources',["name","description"]);
    changeCharsOfEachTable($pdo,'sms_validations',["user_info"]);
    changeCharsOfEachTable($pdo,'sale_suggestions',["name"]);
    changeCharsOfEachTable($pdo,'questions',["description"]);
    changeCharsOfEachTable($pdo,'provinces',["name"]);
    changeCharsOfEachTable($pdo,'products',["name"]);
    changeCharsOfEachTable($pdo,'notices',["name"]);
    changeCharsOfEachTable($pdo,'need_tag_parent_twos',["name"]);
    changeCharsOfEachTable($pdo,'need_tag_parent_ones',["name"]);
    changeCharsOfEachTable($pdo,'messages',["message"]);
    changeCharsOfEachTable($pdo,'marketers',["first_name","last_name","address","background","education","major","university","city"]);
    changeCharsOfEachTable($pdo,'lessons',["name","description"]);
    changeCharsOfEachTable($pdo,'helps',["name"]);
    changeCharsOfEachTable($pdo,'exams',["name","description"]);
    changeCharsOfEachTable($pdo,'divi_users',["user_nicename","display_name"]);
    changeCharsOfEachTable($pdo,'collections',["name"]);
    changeCharsOfEachTable($pdo,'class_rooms',["name","description"]);
    changeCharsOfEachTable($pdo,'cities',["name"]);
    changeCharsOfEachTable($pdo,'circulars',["title","content"]);
    changeCharsOfEachTable($pdo,'call_results',["title","description"]);
    changeCharsOfEachTable($pdo,'calls',["title","description"]);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
