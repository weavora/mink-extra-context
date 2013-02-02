<?php

sleep(7);

?>
<html>
<body>
    <div class="content">some text</div>
    <a href="slow_page.php">link</a>
    <form action="slow_page.php" method="POST">
        <input type="submit" value="Submit" />
    </form>
</body>
</html>