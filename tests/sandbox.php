<?php
include('../core/helpers/upload/autoload.php');

use LibreMVC\Helpers\Upload;
use LibreMVC\Helpers\Upload\File;
if( isset($_FILES) && !empty($_FILES) ) {
    $upload = new Upload("fichier",$_FILES,"./demo/up/",array("image/jpeg"));
    //var_dump($upload);
    //$upload->setOverwriteTo(false);
    $upload->send();
}
?>
<html>
<head></head>
<body>
    <h1>Upload</h1>
    <?php if(!Upload::isSubmitted()){  ?>
    <form name="envoyer" action="sandbox.php" method="post" enctype='multipart/form-data' target="_self" >
        <fieldset>
            <legend>Fichier : Taille max du fichier <?php print(Upload::getMaxSize()); ?>o</legend>
            <ul>
                <li>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php print( Upload::maxSizeToBytes() ); ?>" />
                    <input name="fichier[]" type="file" />
                    <input name="fichier[]" type="file" />

                </li>
            </ul>
        </fieldset>
        <input name="soumis" type="hidden" value="1" />
        <input name="go" type="submit" value="Envoyer" />
    </form>
    <?php } else { ?>
    <p>
        <?php
        $uploaded = $upload->getUploadedFiles(File::STATEMENT_DONE);
        while( $uploaded->valid() ) {
            var_dump($uploaded->current());
            $uploaded->next();
        }
        $uploaded = $upload->getUploadedFiles(File::STATEMENT_FILTERED);
        while( $uploaded->valid() ) {
            var_dump($uploaded->current());
            $uploaded->next();
        }

        ?>
    </p>
    <?php } ?>
</body>
</html>
