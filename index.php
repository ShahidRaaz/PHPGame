<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<form name="myForm" method="post" action="game.php" onsubmit="return validateForm()">
<h1>Star the Game</h1>
    <label for="name">Enter your name:</label>
    <input type="text" name="name" id="name" required>
    <br><br>
    <label for="age">Enter your age:</label>
    <input type="number" name="age" id="age" required>
    <br><br>
    <label for="email">Enter your email:</label>
    <input type="email" name="email" id="email" required>
    <br><br>
    <label for="rounds_to_play">Enter number of rounds to play:</label>
    <input type="number" name="rounds_to_play" id="rounds_to_play" required>
    <br><br>
    <button type="submit">Start the Game</button>
</form>

<script>
    function validateForm() {
        let name = document.forms["myForm"]["name"].value;
        let age = document.forms["myForm"]["age"].value;
        let email = document.forms["myForm"]["email"].value;
        let rounds = document.forms["myForm"]["rounds_to_play"].value;

        if (name === "" || age === "" || email === "" || rounds === "") {
            alert("All fields must be filled out");
            return false;
        }

        if (isNaN(age) || age < 1) {
            alert("Age must be a valid number");
            return false;
        }

        if (isNaN(rounds) || rounds < 1) {
            alert("Rounds to play must be a valid number");
            return false;
        }

        return true;
    }
</script>

</body>
</html>
