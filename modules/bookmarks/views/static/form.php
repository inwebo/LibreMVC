<!DOCTYPE html>
<html lang="en" style="min-height: 100%;position: relative">
<head>
    <meta charset="utf-8">
    <title>Bookmarks agent</title>
</head>
<body>

<div class="row">

    <div class="container-fluid" style="">

        <div class="col-xs-12">
            <form id="bookmark" class="form-horizontal" role="form">
                <input id="id" type="hidden" name="id" value="<?php echo $this->bookmark->id; ?>">

                <div class="form-group">
                    <div class="col-lg-10">
                        <a href="#" id="bookmark-save" class="btn btn-default btn-lg btn-block" />Save</a>
                        <a href="#" id="bookmark-saving" class="btn btn-default btn-lg btn-block" style="display: none;" disabled/>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="#428bca">
                            <path opacity=".25" d="M16 0 A16 16 0 0 0 16 32 A16 16 0 0 0 16 0 M16 4 A12 12 0 0 1 16 28 A12 12 0 0 1 16 4"/>
                            <path d="M16 0 A16 16 0 0 1 32 16 L28 16 A12 12 0 0 0 16 4z">
                                <animateTransform attributeName="transform" type="rotate" from="0 16 16" to="360 16 16" dur="0.8s" repeatCount="indefinite" />
                            </path>
                        </svg>
                        </a>
                        <a href="#" id="bookmark-error" class="btn btn-danger btn-lg btn-block" style="display: none;" disabled/>Network error.</a>
                        <a href="#" id="bookmark-warning" class="btn btn-warning btn-lg btn-block" style="display: none;" disabled/>Already in base !</a>
                        <a href="#" id="bookmark-success" class="btn btn-success btn-lg btn-block" style="display: none;" disabled/>Saved</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

