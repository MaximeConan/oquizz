<?= view('layout.header'); ?>

<!-- cette vue apelle elle meme le headear principal et enrichit son contenu pour la partie admin -->

<nav class="navbar navbar-expand-lg navbar">

  <div class="collapse navbar-collapse mb-50" id="navbarSupportedContent">

    <ul class="navbar-nav mr-auto">
        
      <li class="nav-item active">
        <a class="nav-link" href="<?= route('admin_quiz_list'); ?>">
            Quiz
        </a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="<?= route('admin_tag_list'); ?>">
            Tag
        </a>
      </li>

  </div>
</nav>
