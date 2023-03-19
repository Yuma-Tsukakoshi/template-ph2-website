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
      <a href="../auth/signout.php">ログアウト</a>
    </div>
  </header>
  <main>
    <div class="wrapper">
      <div class="container">
        <h1 class="title-text">問題作成</h1>
        <form action="../../services/create_question.php" class="question-form" method="POST" enctype="multipart/form-data">
          <!-- urlにパラメータを付加せずに送信する(password)：POST&https ⇔GET  送信先はactionで指定されたpassに向けて-->
          <!-- enctype:送信時の MIMEタイプ を指定する フォーム内にファイルの送信欄を配置する場合は、この形式を指定しておく必要があり-->
          <div class="question-text">
            <label for="question" class="form-label">問題文：</label>
            <input type="text" name="content" class="form-control required" id="question" placeholder="問題文を入力してください">
          </div>
          <div class="question-select">
            <label class="form-label">選択肢：</label>
            <input type="text"  name="choices[]" class="form-control required" placeholder="選択肢1を入力してください">
            <input type="text"  name="choices[]" class="form-control required" placeholder="選択肢2を入力してください">
            <input type="text"  name="choices[]" class="form-control required" placeholder="選択肢3を入力してください">
            <!--nameがchoices[]となっているのはformの送信時に、選択肢を配列要素として渡すため！ -->
          </div>
          <div class="question-correct">
            <label class="form-label">正解の選択肢:</label>
            <div class="form-check">
              <input type="radio" class="form-check-input" name="correctChoice" checked id="correctChoice1" value="1">
              <label for="correctChoice1" class="form-check-label">選択肢1</label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" name="correctChoice" id="correctChoice2" value="2">
              <label for="correctChoice2" class="form-check-label">選択肢2</label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" name="correctChoice" id="correctChoice3" value="3">
              <label for="correctChoice3" class="form-check-label">選択肢3</label>
            </div>
          </div>
          <div class="question-image">
            <label for="question" class="form-label">問題の画像:</label>
            <input type="file" name="image" id="image" class="form-control required">
          </div>
          <div class="question-supplement">
            <label for="question" class="form-label">補足:</label>
            <input type="text" class="form-control" name="supplement" id="supplement" placeholder="補足を入力してください">
          </div>
          <button type="submit" disabled class="btn submit">作成</button>
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