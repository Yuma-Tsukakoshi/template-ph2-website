<?php

/* ドライバ呼び出しを使用して MySQL データベースに接続する */
$dsn = 'mysql:dbname=posse;host=db';
$user = 'root';
$password = 'root';

$pdo = new PDO($dsn, $user, $password);

$questions_sql = "SELECT * FROM questions";
$questions = $pdo->query($questions_sql)->fetchAll(PDO::FETCH_ASSOC); 

$choices_sql = "SELECT * FROM choices";
$choices = $pdo -> query($choices_sql)->fetchAll(PDO::FETCH_ASSOC);


foreach ($choices as $key=> $choice){
  $index = array_search($choice["question_id"],array_column($questions,'id'));
  //questionsテーブルのidの値を配列として取ってくる！各設問を問題と対応させる
  $questions[$index]["choices"][] = $choice;
  // print_r("<pre>");
  // print_r($questions);
  // print_r("</pre>");
  // echo "<br>";
  //array_search: 指定した値を配列で検索し、見つかった場合に対応する最初のキーを返す
  //array_column: 
}
?>