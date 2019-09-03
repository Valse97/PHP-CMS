
<?php
$menu = 0;
$gestione = true;
include("./include/header.php");
$nome = "Slider";
$nome = ucfirst($nome);
?>



<script>
    $(document).ready(function() {
        cmsManager.init("<?php echo $nome ?>");
    });
</script>

<div class="section gestione">
    <h2>Gestion Slider</h2>
    <div id="tabs" class="hidden mb-md">
        <ul>
            <li><a href="#tabs-1">Non loggati</a></li>
            <li><a href="#tabs-2">Member</a></li>
            <li><a href="#tabs-3">Owner</a></li>
        </ul>

        <?php for($i=1;$i<=3;$i++){ ?>
            <div id="tabs-<?php echo $i ?>" class="tab">
                <p>
                    <a href="#" class="btn btn-primary">Nuovo</a>
                    <button id="trashSelected" class="btn btn-danger"><i class="glyphicon glyphicon-remove" onclick="gestione.deleteSelectedItems()"></i> Cestina selezionati</button>
                </p>
                <table class="table table-striped table-hover" id="main-table">
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="check-select-all" onclick="gestione.toggleAll()"></th>
                        <th>Ordine</th>
                        <th>Immagine</th>
                        <th>Testo bottone sopra</th>
                        <th>Testo bottone sotto</th>
                        <th>Visibile</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $n = 1;
                    for($id=0;$id<8;$id++){ ?>
                        <tr data-id="<?php echo $id ?>">
                            <td class="filterable-cell"><input type="checkbox" class="check-select-row"></td>
                            <td class="filterable-cell index"><span class="circle"><?php echo $n ?></span></td>
                            <td class="filterable-cell img-container"><img src="images/slider/Banner%20Set%20-%20Logged%20OutBanner%202%20-%20Leica%20Akademie.jpg" ></td>
                            <td class="filterable-cell">Leica M-Set <?php echo $n ?></td>
                            <td class="filterable-cell">Leica M-Set</td>
                            <td class="filterable-cell"><i class="pl-sm glyphicon glyphicon-ok green"></i></td>
                            <td class="filterable-cell">
                                <a href="#" class="btn btn-primary btn-sm">Modifica</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="gestione.deleteItem(<?php echo $id ?>)">Elimina</a>
                            </td>
                        </tr>
                        <?php
                        $n++;
                    } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>



<?php
/* GESTIONI ADD E MODIFY */
?>

<div id="lighbox-background"></div>

<div class="form-add">
    <form class="form-horizontal" id="add-item" action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <div id="image_preview"><img id="previewing" src="images/blank.png" /></div>
            <div class="form-group">
                <label class="col-md-4 col-md-offset-0 control-label" for="image">Scegli immagine *</label>
                <div class='col-md-8 input-container'>
                    <input type="file" id="image" name="image" class="form-control" required="" value="<?php ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 col-md-offset-0 control-label" for="button_text_up">Data di scadenza *</label>
                <div class='col-md-8'>
                    <input type='type' id="button_text_up" name="button_text_up" class="form-control" required="" value="<?php ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 col-md-offset-0 control-label" for="button_text_down">Data di scadenza *</label>
                <div class='col-md-8'>
                    <input type='type' id="button_text_down" name="button_text_down" class="form-control" required="" value="<?php ?>" />
                </div>
            </div>
        </fieldset>
    </form>
</div>

<script>
    $(document).ready(function (e) {
        $("#add-item").on('submit',(function(e) {
            e.preventDefault();
            $("#message").empty();
            $.ajax({
                url: "app/ajax_php_file.php", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data)   // A function to be called if request succeeds
                {
                    console.log(data)
                    data = JSON.parse(data);
                    console.log(data)
                    if(data.success==true){
                        swal({
                            title: "Fatto",
                            text: "L'oggetto è stato creato",
                            type: "success"
                        })
                    }else{
                        swal({
                            title: "Errore",
                            text: data.msg,
                            type: "error"
                        })
                    }
                }
            });
        }));

// Function to preview image after validation
        $(function() {
            $("input[type=file]").change(function() {
                var file = this.files[0];
                var imagefile = file.type;
                var match= ["image/jpeg","image/png","image/jpg"];
                if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
                {
                    $('.preview-img').attr('src','images/blank.png');
                    $("#message").html("<span id='error_message'>Sono permessi solo file con estenzione .jpeg, .jpg e .png.</span>");
                    return false;
                }
                else
                {
                    var container = $(this).closest(".input-container").get(0);
                    var prefix = "col-";
                    var classes = container.className.split(" ").filter(function(c) {
                        return c.lastIndexOf(prefix, 0) !== 0;
                    });
                    container.className = classes.join(" ").trim();
                    $(this).closest(".input-container").addClass("col-md-7");

                    if($(this).closest(".input-container").parent().find(".icon-preview-container").length == 0) {
                        $(this).closest(".input-container").parent().append("<div class='col-md-1 icon-preview-container'><span class='glyphicon glyphicon-collapse-down'></span><div class='img-preview-container'><img class='img-preview' src='images/blank.png'></div></div>");
                    }else{
                        $(this).closest(".input-container").parent().find(".img-preview").src = "images/user.png";
                    }


                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);

                }
            });
        });
        function imageIsLoaded(e) {
            console.log(e);
            console.log(a);
            $('.preview-img').css("display", "block");
            $('.preview-img').attr('src', e.target.result);
            $('.preview-img').attr('width', '100px');
//            $('.preview-img').attr('height', '230px');
        };
    });
</script>

<?php
/* FINE GESTIONI */
?>

<?php include("./include/footer.php"); ?>