<?php

session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');

if (!isset($_SESSION['id'])) {
    header('Location: http://localhost:8080/admin/auth/signup.php');
    exit();
}else{
    $is_empty = count($questions) === 0;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者画面</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="../assets/styles/common.css">
  <link rel="stylesheet" href="./admin.css">
</head>

<body>
  <header class="p-header">
    <div class="p-header__logo"><img src="../assets/img/logo.svg" alt="POSSE"></div>
    <div class="header-nav">
      <a href="./index.php">管理者画面</a>
      <a href="./questions/create.php">問題作成</a>
      <a href="./auth/signout.php">ログアウト</a>
    </div>
  </header>
  <main>
    <div class="wrapper">
      <div class="container">
        <h1 class="title-text">問題一覧</h1>
        <?php if(!$is_empty) { ?>
          <table class="table">
            <thead class="thead">
              <tr>
                <th>ID</th>
                <th>問題</th>
                <th></th><!-- 削除用 -->
              </tr>
            </thead>
            <tbody>
              <?php foreach($questions as $question){ ?>
                <tr id="question-<?=$question["id"] ?>" class="id-question"> 
                <!-- 問題の削除を行うときにid要素を取得して消すためidを書く必要がある -->
                  <td><?= $question["id"]; ?></td>
                  <td>
                    <a href="./questions/edit.php?id=<?=$question["id"]?>" class="content-question">
                      <!-- 問題を押すと?でパラメータ設定でき、押された問題のidを入力後edit.phpを開く -->
                      <?= $question["content"]; ?>
                    </a>
                  </td>
                  <td onclick="deleteQuestion(<?= $question['id'] ?>)" class="delete-btn">削除</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } else { ?>
          問題が作成されていません。
        <?php } ?>
      </div>
    </div>
  </main>

  <script>
    // async：非同期通信を行うための関数を定義
    const deleteQuestion = async (questionId) => {
      if(!confirm('削除してもよろしいでしょうか？')) return //削除するNo->return で返して終了
      const res = await fetch(`http://localhost:8080/services/delete_question.php?id=${questionId}`,{method:'DELETE' });
      //await:変数resにawaitを書くことで非同期通信が終わった後にfetch()メソッド（引数はurl）を実行。HTTPメソッドでDELETEを指定
      if (res.status ===204){ //リクエスト成功
        alert('削除に成功しました')
        document.getElementById(`question-${questionId}`).remove() //取得したHTML要素を削除する
      }else{
        alert('削除に失敗しました')
      }
    }
  </script>
  <!--非同期通信は、同期通信のような待ち時間がなく、引き続き別の処理を行えるという点でユーザビリティの向上に繋がっている。  -->
</body>
</html>