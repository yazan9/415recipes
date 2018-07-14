
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">415 Recipes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      
      <li class="nav-item">
        <a class="nav-link" href="/new-recipe.php">Add Recipe</a>
      </li>
      
    </ul>
    <ul class="navbar-nav mt-2 mt-lg-0 navbar-right">
        <?php
        if(isset($_SESSION['first_name'])){
          echo
          "<li class=\"nav-item dropdown\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">".ucwords($_SESSION['first_name'])
          ."
          </a>
          <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdown\">
            <a class=\"dropdown-item\" href=\"/my-recipes.php\">My Recipes</a>
            <div class=\"dropdown-divider\"></div>
            <a class=\"dropdown-item\" href=\"/view-profile.php\">Profile</a>
            <a class=\"dropdown-item\" href=\"/perform_logout.php\">Log out</a>
          </div>
          </li>";
        }
        else{
            echo "<li class=\"nav-item\">
        <a class=\"nav-link\" data-toggle=\"modal\" data-target=\"#signupModal\" href=\"#\">Sign Up</a>
      </li>
      <li class=\"nav-item\">
        <a class=\"nav-link\" data-toggle=\"modal\" data-target=\"#loginModal\" href=\"#\">Login</a>
      </li>";
        }
        ?>
  </div>
</nav>