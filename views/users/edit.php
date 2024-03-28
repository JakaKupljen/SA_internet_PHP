<div class="container">
    <h3 class="mb-3">Spremeni geslo</h3>
    <form action="/users/edit" method="POST">
        <div class="mb-3">
            <label for="password" class="form-label">Staro geslo</label>
            <input type="password" class="form-control" id="old_password" name="old_password" value="<?php echo isset($_POST["old_password"]) ? $_POST["old_password"]: ""; ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Geslo</label>
            <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"]: ""; ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Ponovi geslo</label>
            <input type="password" class="form-control" id="repeat" name="repeat_password" value="<?php echo isset($_POST["repeat_password"]) ? $_POST["repeat_password"]: ""; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="register">Spremeni geslo</button>
        <label class="text-danger"><?php echo $error; ?></label>
    </form>
</div>