<!DOCTYPE html>
<html>
<head>
    <title>Rock Paper Scissors Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: flex-start;
            width: 80%;
            margin-top: 20px;
        }

        .game-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 50px;
        }

        .history-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 10px;
        }

        .result {
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
        }

        .score {
            font-size: 16px;
            margin-top: 20px;
        }

        .history {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .round-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px;
        }

        .history-content {
            display: flex;
            align-items: center;
        }

        .history-img {
            width: 80px;
            height: 80px;
            margin: 5px;
        }

        .image-container {
            display: block;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .image-container img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            margin: 20px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .image-container img:hover {
            transform: scale(1.1);
        }

        .image-container input[type="radio"] {
            display: none;
        }

        .image-container img {
            cursor: pointer;
            transition: transform 0.3s;
            border: 2px solid transparent;
        }

        .image-container input[type="radio"]:checked + img {
            border: 5px solid green;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="game-section">
        <h2>Rock Paper Scissors</h2>
        <?php
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['rounds_to_play'])) {
                $_SESSION['rounds_to_play'] = $_POST['rounds_to_play'];
            }
        }
        
        if (!isset($_SESSION['user_score'])) {
            $_SESSION['user_score'] = 0;
        }
        if (!isset($_SESSION['computer_score'])) {
            $_SESSION['computer_score'] = 0;
        }
        if (!isset($_SESSION['round_count'])) {
            $_SESSION['round_count'] = 0;
        }
        if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = [];
        }
        
        if (isset($_POST['submit'])) {
            $choices = array("rock", "paper", "scissors");
            $user_choice = $_POST['choice'];
            $random_index = array_rand($choices);
            $computer_choice = $choices[$random_index];
        
            $_SESSION['round_count']++;
            $result = "";
        
            if ($user_choice == $computer_choice) {
                $result = "It's a tie!";
            } elseif (
                ($user_choice == "rock" && $computer_choice == "scissors") ||
                ($user_choice == "paper" && $computer_choice == "rock") ||
                ($user_choice == "scissors" && $computer_choice == "paper")
            ) {
                $result = "You win!";
                $_SESSION['user_score']++;
            } else {
                $result = "Computer wins!";
                $_SESSION['computer_score']++;
            }
        
            array_push($_SESSION['history'], array("Round" => $_SESSION['round_count'], "User Choice" => $user_choice, "Computer Choice" => $computer_choice, "Result" => $result));
        }
        
        if (isset($_POST['reset'])) {
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit();
        }
        
        if ($_SESSION['round_count'] < $_SESSION['rounds_to_play']) {
            echo '<form method="post" class="image-container">
            <label>
                <input type="radio" name="choice" value="rock" id="rock" onclick="selectImage(\'rock\')" ' . (isset($_POST['choice']) && $_POST['choice'] === 'rock' ? 'checked' : '') . '>
                <img src="rock.jpg" alt="Rock">
            </label>
            <label>
                <input type="radio" name="choice" value="paper" id="paper" onclick="selectImage(\'paper\')" ' . (isset($_POST['choice']) && $_POST['choice'] === 'paper' ? 'checked' : '') . '>
                <img src="paper.jpg" alt="Paper">
            </label>
            <label>
                <input type="radio" name="choice" value="scissors" id="scissors" onclick="selectImage(\'scissors\')" ' . (isset($_POST['choice']) && $_POST['choice'] === 'scissors' ? 'checked' : '') . '>
                <img src="scissors.jpg" alt="Scissors">
            </label>
            <button type="submit" name="submit">Play</button>
        </form>';
        } else {
            echo "<h3>Game Over</h3>";
            echo "<h3 class='score'>Score</h3>";
        echo "<p class='score'>User: " . $_SESSION['user_score'] . "</p>";
        echo "<p class='score'>Computer: " . $_SESSION['computer_score'] . "</p>";
        if ($_SESSION['user_score'] > $_SESSION['computer_score']) {
            echo "<img src='win.jpg' alt='Win' title='Win' class='history-img'>";
        } elseif ($_SESSION['user_score'] < $_SESSION['computer_score']) {
            echo "<img src='lose.png' alt='Lose' title='Lose' class='history-img'>";
        } else {
            echo "<p>Game Tie</p>";
        }
            echo "<form method='post'><button type='submit' name='reset'>Play Again</button></form>";
        }
        
        ?>
    </div>

    <div class="history-section">
        <?php
        echo "<h3 class='history'>Game History</h3>";
        echo "<div class='history'>";
        foreach ($_SESSION['history'] as $round) {
            echo "<div class='round-box'>";
            echo "<p>Round " . $round['Round'] . "</p>";
            echo "<div class='history-content'>";
            echo "<p>User Chose:</p>";
            echo "<img src='{$round['User Choice']}.jpg' alt='{$round['User Choice']}' title='{$round['User Choice']}' class='history-img'>";
            echo "<p>Computer Chose:</p>";
            echo "<img src='{$round['Computer Choice']}.jpg' alt='{$round['Computer Choice']}' title='{$round['Computer Choice']}' class='history-img'>";
            if ($round['Result'] === "You win!") {
                echo "<p>Result:</p>";
                echo "<img src='win.jpg' alt='Win' title='Win' class='history-img'>";
            } elseif ($round['Result'] === "Computer wins!") {
                echo "<p>Result:</p>";
                echo "<img src='lose.png' alt='Lose' title='Lose' class='history-img'>";
            } else {
                echo "<p>Result:</p>";
                echo "<img src='tie.png' alt='Tie' title='Tie' class='history-img'>";
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>




</body>
</html>
