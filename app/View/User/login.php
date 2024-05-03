<div class="container">

<div class="row">
<?php if(isset($model['error'])) { ?>
        <div class="row">
            <div class="alert alert-danger" role="alert">
                <?= $model['error'] ?>
            </div>
        </div>
    <?php } ?>

      <div class="col-md-12 mt-4">
        <h1 class="welcome-header text-center"><?php echo $model['title'] ?></h1>
		<h2 class="welcome-header text-center"> <?php echo $model['content'] ?>  </h2>
      </div>
    </div>
    <div class="row justify-content-center mt-2">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <form action="/users/login" method="POST">
              <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" class="form-control" id="id" name="id" required>
              </div>
              <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block mt-2">Login</button>
            </form>
          </div>
          <div class="card-footer">
            <small class="text-muted">Don't have an account? <a href="/users/register">Sign Up</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>