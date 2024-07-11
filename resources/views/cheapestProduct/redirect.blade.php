<!-- resources/views/hiddenForm.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Automatically submit the form when the page loads
            document.getElementById("hiddenForm").submit();
        });
    </script>
</head>
<body>

@isset($route)
    <!-- Debugging output to ensure $route is correctly passed -->
    <!-- Form that submits automatically -->
    <form id="hiddenForm" action="{{ $route }}" method="POST">
        @csrf
        <input type="hidden" name="hiddenField1" value="value1">
        <!-- Add more hidden fields as needed -->
    </form>
@else
    <p>No route found. Error occurred.</p>
@endisset
</body>
</html>
