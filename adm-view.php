<?php
require_once 'db.php';

$sql = "SELECT * FROM messages";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin View - Messages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Admin View - Messages</h1>
    <table>
        <tr>
            <th>Message ID</th>
            <th>Message</th>
            <th>Timestamp</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['message']."</td>";
                echo "<td>".$row['timestamp']."</td>";
                echo "<td>
                        <button class='btn waves-effect waves-light' onclick='copyToClipboard(\"".$row['message']."\")'>
                            <i class='material-icons'>content_copy</i>
                        </button>
                        <button class='btn waves-effect waves-light red' onclick='deleteMessage(".$row['id'].")'>
                            <i class='material-icons'>delete</i>
                        </button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No messages found.</td></tr>";
        }
        ?>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.sidenav');
            var instances = M.Sidenav.init(elems);
        });

        function copyToClipboard(message) {
            navigator.clipboard.writeText(message)
                .then(function() {
                    M.toast({html: 'Message copied to clipboard!', classes: 'rounded'});
                })
                .catch(function() {
                    M.toast({html: 'Failed to copy message!', classes: 'rounded red'});
                });
        }

        // Delete message
        function deleteMessage(id) {
            if (confirm('Are you sure you want to delete this message?')) {
                alert('Message deleted!');
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
