<?php ob_start() ?>

<div id="new-article" class="row-padding">
    <div class="col m12">
        <div class="card-2 round white">
            <div class="container padding">
                <h6 class="opacity">Kercode Network</h6>
                <form action="index.php?action=newarticle" method="POST">
                    <textarea name="new-article-edit" id="new-article-edit" rows="1" class="w100 open-textarea" style="resize: none" placeholder="Exprimez-vous !"></textarea>
                    <div id="new-article-menu" class="w100">
                        <button type="submit" class="btn theme"><i class="fa fa-pencil"></i>&nbsp;Publier</button>
                        <a href="#" class="text-green" title="Ajouter une image"><i class="fa fa-image"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $newArticle = ob_get_clean(); ?>