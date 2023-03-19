<?php 

require_once(dirname(__FILE__) . '/../../dbconnect.php');

$sql = "SELECT * FROM questions WHERE id = :id";
$stmt = $pdo->prepare($sql);
//userによってsql文が変わる->then prepare() : else query()
$stmt ->bindValue(":id",$_REQUEST["id"]);
$stmt ->execute();
$question = $stmt->fetch();
//fetch():データ１行を配列で取得 default:PDO::FETCH_BOTH (デフォルト)・・・結果セットに返された際のカラム名と 0 で始まるカラム番号で添字を付けた配列を返します。

$sql = "SELECT * FROM choices WHERE question_id = :question_id";
$stmt = $pdo->prepare($sql);
$stmt ->bindValue(":question_id",$_REQUEST["id"]);
$stmt ->execute();
$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
//fetchAll(PDO::FETCH_ASSOC):各データを配列indexと各カラムの値が連想配列で取得できる
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE管理者画面</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="../../assets/styles/common.css">
  <link rel="stylesheet" href="../admin.css">
</head>
<body>
  <header class="p-header">
    <div class="p-header__logo"><img src="../../assets/img/logo.svg" alt="POSSE"></div>
    <div class="header-nav">
      <a href="../index.php">管理者画面</a>
      <a href="./create.php">問題作成</a>
      <a href="../auth/logout.php">ログアウト</a>
    </div>
  </header>
  <main>
    <div class="wrapper">
      <div class="container">
        <h1 class="title-text">問題編集</h1>
        <form action="../../services/update_question.php" class="question-form" method="POST" enctype="multipart/form-data">
          <div class="question-text">
            <label for="question" class="form-label">問題文：</label>
            <input type="text" name="content" class="form-control required" id="question" value="<?= $question["content"] ?>" placeholder="問題文を入力してください">
          </div>
          <div class="question-select">
            <label class="form-label">選択肢：</label>
            <?php foreach($choices as $key=> $choice){ ?>
              <input type="text"  name="choices[]" class="form-control required" placeholder="選択肢を入力してください" value="<?= $choice["name"] ?>">
            <?php } ?>
          </div>
          <div class="question-correct">
            <label class="form-label">正解の選択肢:</label>
            <?php foreach($choices as $key=> $choice){ ?>
              <div class="form-check">
                <input type="radio" class="form-check-input" name="correctChoice" id="correctChoice<?= $key ?>" value="<?= $key + 1 ?>" <?= $choice["valid"] === 1 ? 'checked' : '' ?> >
                <label for="correctChoice<?= $key+1?>" class="form-check-label">選択肢<?= $key + 1 ?></label>
              </div>
            <?php } ?>
          </div>
          <div class="question-image">
            <label for="question" class="form-label">問題の画像:</label>
            <input type="file" name="image" id="image" class="form-control required">
          </div>
          <div class="question-supplement">
            <label for="question" class="form-label">補足:</label>
            <input type="text" class="form-control" name="supplement" id="supplement" placeholder="補足を入力してください" value="<?= $question["supplement"] ?>">
          </div>
          <input type="hidden" name="question_id" value="<?= $question["id"] ?>">
          <!-- ブラウザ上では見えないことを利用して、ユーザーからの命令がどのような種類なのかをサーバーに送信するときに判断させるために -->
          <button type="submit" class="btn submit">更新</button>
        </form>
      </div>
    </div>
  </main>

  <script>
    const submitButton = document.querySelector('.btn.submit')
    const inputDoms = Array.from(document.querySelectorAll('.required'))
    inputDoms.forEach(inputDom => {
      inputDom.addEventListener('input',event=>{
        const isFilled = inputDoms.filter(d=>d.value).length === inputDoms.length
        submitButton.disabled = !isFilled
      })
    });
  </script>

</body>
</html>