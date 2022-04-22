<?php ob_start() ?>

<section id="new-article" class="row-padding">
    <div class="col m12">
        <div class="container card-2 round white">
            <h6 class="opacity">Kercode Network</h6>
            <form action="index.php?action=newarticle" method="POST" class="no-margin" enctype="multipart/form-data">
                <textarea name="new-article-edit" id="new-article-edit" rows="1" class="w100 margin-bottom-small no-resize"placeholder="Exprimez-vous !"></textarea>
                <div class="image-preview"></div>
                <div id="new-article-menu" class="w100 margin-bottom">
                    <button type="submit" class="btn theme"><i class="fa fa-pencil"></i>&nbsp;Publier</button>
                    <!-- Sélection des images -->
                    <label for="image-article" class="text-green"><i class="fa fa-image"></i></label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> <!-- Max Size 2mo -->
                    <input type="file" name="image-article[]" id="image-article" class="w25" accept=".png, .jpg, .jpeg" multiple>
                </div>
            </form>
        </div>
    </div>
</section>

<?php $newArticle = ob_get_clean(); ?>