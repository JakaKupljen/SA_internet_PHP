<div class="container">
    <h3 class="mb-3">Objavi novico</h3>
    <form action="/articles/update?id=<?php echo $article->id; ?>" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Naslov</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $article->title; ?>">
        </div>
        <div class="mb-3">
            <label for="abstract" class="form-label">Povzetek</label>
            <input type="text" class="form-control" id="abstract" name="abstract" value="<?php echo $article->abstract; ?>">
        </div>
        <div class="mb-3">
            <label for="text">Vsebina</label>
            <textarea class="form-control" id="text" name="text" rows="3"><?php echo $article->text; ?></textarea>
        </div>
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['USER_ID']; ?>">
        <button type="submit" class="btn btn-primary" name="publish">Objavi</button>
        <label class="text-danger"><?php echo $error; ?></label>
    </form>
</div>