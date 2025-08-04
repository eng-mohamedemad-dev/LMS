<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Test Form</title>
</head>
<body>

  <form id="myForm">
    <input type="text" name="name" placeholder="Enter name" required />
    <input type="email" name="email" placeholder="Enter email" required />
    <button type="submit">Send</button>
  </form>

  <div id="result"></div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $('#myForm').submit(function(e) {
      e.preventDefault(); 
      const formData = $(this).serialize(); 
      $.ajax({
        url: 'http://127.0.0.1:8000/api/test', 
        method: 'POST', 
        data: formData, 
        success: function(response) {
          $('#result').text('Response: ' + response.message + ' | Name: ' + response.name + ' | Email: ' + response.email);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          $('#result').text('Error occurred!');
        }
      });
    });
  </script>

</body>
</html>
