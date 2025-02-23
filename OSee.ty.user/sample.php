<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Account</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
      }

      .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .profile-picture {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 20px;
      }

      .logout-btn {
        background-color: #ff4d4d;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <img class="profile-picture" src="profile.jpg" alt="Profile Picture" />
      <div>
        <p><strong>Name:</strong> John Doe</p>
        <p><strong>Email:</strong> johndoe@example.com</p>
      </div>
      <button class="logout-btn" onclick="logout()">Logout</button>
    </div>

    <script>
      function logout() {
        // Perform logout actions here
        alert("Logged out successfully!");
        // For demonstration, let's redirect to a login page
        window.location.href = "login.php";
      }
    </script>
  </body>
</html>
