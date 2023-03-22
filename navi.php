
<header>
    <nav class="navbar">
        <div class="name">
            <a href="miniProject.php">Niramay Mehta</a>
        </div>
        <a href="portfolio.php">Portfolio</a>
        <a href="index.php">Blog</a>
        <a href="login.php">Login</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<script>
    function checkInput(e){
        var u = document.getElementById("username").value;
        var p = document.getElementById("pwd").value;

        if(u == '' || p ==''){
            document.getElementById('username').style.borderColor = "red";    
                document.getElementById('pwd').style.borderColor = "red";    
            e = e || window.event;
            e.preventDefault();
        } else {
            document.getElementById("loginForm").submit();
        }
    }

</script>

