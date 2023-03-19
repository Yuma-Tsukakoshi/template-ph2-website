<?php
session_start();
//セッションを開始するため

require_once(dirname(__FILE__) . '/../../dbconnect.php');

$mail = $_POST['email'];

$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $mail);
$stmt->execute();
$member = $stmt->fetch();
//指定したハッシュがパスワードにマッチしているかチェック
if (password_verify($_POST['password'], $member['password'])){
  // $member[pass] : 既にハッシュ化されたパスワード
    //DBのユーザー情報をセッションに保存
    $_SESSION['id'] = $member['id'];
    $_SESSION['name'] = $member['name'];
    // $msg = 'ログインしました。';
    // echo $msg;
    // $link = '<a href="http://localhost:8080/admin/index.php">管理者画面</a>';
    header('Location: http://localhost:8080/admin/index.php');
    exit();
} else {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="http://localhost:8080/admin/auth/login_form.php">戻る</a>';
}
?>

<!-- <h1><?php echo $msg; ?></h1>
<?php echo $link; ?> -->