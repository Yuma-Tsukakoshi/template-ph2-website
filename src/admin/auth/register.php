<?php
//フォームからの値をそれぞれ変数に代入
require_once(dirname(__FILE__) . '/../../dbconnect.php');

$name = $_POST['name'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
//PASSWORD_DEFAULT:bcrypt アルゴリズムを用いてパスワードをハッシュ化する

//フォームに入力されたmailがすでに登録されていないかチェック
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email',$_POST['email']);
$stmt->execute();
$member = $stmt->fetch();
if ($member['email'] === $_POST['email']) {
    $msg = '同じメールアドレスが存在します。';
    $link = '<a href="./signup.php">戻る</a>';
} else {
    //登録されていなければinsert 
    $sql = "INSERT INTO users(name, email, password) VALUES (:name, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $_POST['name']);
    $stmt->bindValue(':email',$_POST['email']);
    $stmt->bindValue(':password', $pass);
    $stmt->execute();
    $msg = '登録が完了しました';
    $link = '<a href="http://localhost:8080/admin/auth/login_form.php">ログインページへ</a>';
}
?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>
