<?php
$gestione = true;
$gestione_god = true;
include("includes/header.php");
?>

<script>
    $(document).ready(function() {
        cmsManager.init("ManagerGod");
        cmsManagerGod.init();
    });
</script>

<?php if(!isset($_GET["id"]) || empty(Cms::getComponentById(htmlentities($_GET["id"])))) { ?>
<h2>Componenti</h2>

<div class="tab" aria-hidden=false>
    <p>
        <button onclick="cmsManager.openModal('create')" class="btn btn-primary">Nuovo</button>
        <button id="trashSelected" class="btn btn-danger"><i class="glyphicon glyphicon-remove" onclick="cmsManagerGod.deleteSelectedItems()"></i> Cestina selezionati</button>
    </p>
    <table class="table table-striped table-hover" id="main-table">
        <thead>
        <tr>
            <th><input type="checkbox" class="check-select-all" onclick="cmsManager.toggleAll()"></th>
            <th>Ordine</th>
            <th>Nome singolare</th>
            <th>Nome plurale</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $components = Cms::getAllComponents();
        foreach ($components as $component){ ?>
            <tr data-id="<?php echo $component->id ?>">
                <td class="filterable-cell checkbox-container"><input type="checkbox" class="check-select-row"></td>
                <td class="filterable-cell index"><span class="circle"><?php echo $component->sort ?></span></td>
                <td class="filterable-cell strong" data-field="singular_name"><?php echo $component->singular_name ?></td>
                <td class="filterable-cell strong" data-field="plural_name"><?php echo $component->plural_name ?></td>
                <td class="filterable-cell">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="cmsManagerGod.showEditComponent(<?php echo $component->id ?>)">Modifica</a>
                    <a href="./menu-god.php?id=<?php echo $component->id ?>" class="btn btn-primary btn-sm" >Gestisci campi</a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="cmsManagerGod.deleteComponent(<?php echo $component->id ?>)">Elimina</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>


<?php
/* GESTIONI ADD E MODIFY */
?>

    <div class="modal fade" data-type="create" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Chiudi</span></button>
                    <h3 class="modal-title" id="lineModalLabel">Nuovo componente</h3>
                </div>
                <div class="modal-body">
                    <form>

                        <div class="form-group">
                            <label for="singular_name">Nome singolo *</label>
                            <input type='type' placeholder="Nome singolo" id="singular_name" name="singular_name" class="form-control" required="" />
                        </div>
                        <div class="form-group">
                            <label for="plural_name">Nome plurale *</label>
                            <input type='type' placeholder="Nome plurale" id="plural_name" name="plural_name" class="form-control" required="" />
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-hover-green" data-action="save" role="button" onclick="cmsManagerGod.createComponent()">Salva</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" data-type="edit" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Chiudi</span></button>
                <h3 class="modal-title" id="lineModalLabel">Modifica componente</h3>
            </div>
            <div class="modal-body">
                <form>
                    <input type='hidden' id="id" name="id" required="" />
                    <div class="form-group">
                        <label for="singular_name">Nome singolo *</label>
                        <input type='type' placeholder="Nome singolo" id="singular_name" name="singular_name" class="form-control" required="" />
                    </div>
                    <div class="form-group">
                        <label for="plural_name">Nome plurale *</label>
                        <input type='type' placeholder="Nome plurale" id="plural_name" name="plural_name" class="form-control" required="" />
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-hover-green" data-action="save" role="button" onclick="cmsManagerGod.editComponent()">Salva</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php
    /*
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * GESTIONE CAMPI */
} else {
    $comp = Cms::getComponentById(htmlentities($_GET["id"]));
    ?>
    <br>
    <a class="btn btn-primary" href="./menu-god.php">< Indietro</a>
    <h2>Campi del componente '<?php echo $comp->singular_name ?>'</h2>

    <div class="tab" aria-hidden=false>
        <p>
            <button onclick="cmsManager.openModal('create')" class="btn btn-primary">Nuovo</button>
            <button id="trashSelected" class="btn btn-danger"><i class="glyphicon glyphicon-remove" onclick="cmsManagerGod.deleteSelectedItems()"></i> Cestina selezionati</button>
        </p>
        <table class="table table-striped table-hover" id="main-table">
            <thead>
            <tr>
                <th><input type="checkbox" class="check-select-all" onclick="cmsManager.toggleAll()"></th>
                <th>Tipo</th>
                <th>Nome</th>
                <th>Required</th>
                <th>placeholder</th>
                <th>default_value</th>
                <th>size</th>
                <th>max_length</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $attrs = Cms::getAllComponentAttributesByComponentId($comp->id);
            foreach ($attrs as $attr){ ?>
                <tr data-id="<?php echo $attr->id ?>">
                    <td class="filterable-cell checkbox-container"><input type="checkbox" class="check-select-row"></td>

                    <td class="filterable-cell strong" data-field="_cms_attribute_id"><?php echo CMS::getAttributesById($attr->_cms_attribute_id)->type ?></td>
                    <td class="filterable-cell strong" data-field="value_name"><?php echo $attr->value_name ?></td>
                    <td class="filterable-cell strong" data-field="required"><?php echo (strlen($attr->required) > 0)? "<span class=\"glyphicon glyphicon-ok green\"></span>" : "<span class=\"glyphicon glyphicon-remove red\"></span>" ?></td>
                    <td class="filterable-cell strong" data-field="placeholder"><?php echo (strlen($attr->placeholder) > 0)? $attr->placeholder : "/" ?></td>
                    <td class="filterable-cell strong" data-field="default_value"><?php echo (strlen($attr->default_value) > 0)? $attr->default_value : "/" ?></td>
                    <td class="filterable-cell strong" data-field="size"><?php echo ($attr->size > 0)? $attr->size : "/" ?></td>
                    <td class="filterable-cell strong" data-field="max_length"><?php echo ($attr->max_length > 0)? $attr->max_length : "/" ?></td>


                    <td class="filterable-cell">
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="cmsManagerGod.showEditComponentAttribute(<?php echo $attr->id ?>)">Modifica</a>
                        <a href="./menu-god.php?id=<?php echo $attr->id ?>" class="btn btn-primary btn-sm" >Gestisci campi</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="cmsManagerGod.deleteComponentAttribute(<?php echo $attr->id ?>)">Elimina</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>


    <?php
    /* GESTIONI ADD E MODIFY */
    ?>

    <div class="modal fade" data-type="create" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Chiudi</span></button>
                    <h3 class="modal-title" id="lineModalLabel">Nuovo campo</h3>
                </div>
                <div class="modal-body">
                    <form>
                        <input type='hidden' id="componentId" name="componentId" class="form-control" value="<?php echo $comp->id ?>" required="" />

                        <div class="form-group">
                            <label for="_cms_attribute_id">Tipo di campo *</label>
                            <select>
                                <?php $attributes = CMS::getAllAttributes();
                                foreach ($attributes as $attribute){
                                    echo "<option value='".$attribute->id."' >".$attribute->type."</option>";
                                } ?>
                            </select>
                            <input type='hidden' id="_cms_attribute_id" name="_cms_attribute_id" class="form-control" required="" />
                        </div>

                        <div class="form-group">
                            <label for="value_name">Nome *</label>
                            <input type='type' placeholder="Nome" id="value_name" name="value_name" class="form-control" required="" />
                        </div>

                        <div class="form-group">
                            <label for="required">Obbligatorio? *</label>
                            <input type='checkbox' id="required" name="required"  required="" />
                        </div>

                        <div class="form-group">
                            <label for="placeholder">Placeholder</label>
                            <input type='type' placeholder="Placeholder" id="placeholder" name="placeholder" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="default_value">Valore di default</label>
                            <input type='type' placeholder="Valore di default" id="default_value" name="default_value" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="size">Lunghezza campo</label>
                            <input type='type' placeholder="Lunghezza campo" id="size" name="size" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="max_length">Lunghezza massima</label>
                            <input type='number' placeholder="Lunghezza massima" id="max_length" name="max_length" class="form-control" />
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-hover-green" data-action="save" role="button" onclick="cmsManagerGod.createComponentAttribute()">Salva</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-type="edit" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Chiudi</span></button>
                    <h3 class="modal-title" id="lineModalLabel">Modifica campo</h3>
                </div>
                <div class="modal-body">
                    <form>
                        <input type='hidden' id="id" name="id" required="" />
                        <div class="form-group">
                            <label for="singular_name">Nome singolo *</label>
                            <input type='type' placeholder="Nome singolo" id="singular_name" name="singular_name" class="form-control" required="" />
                        </div>
                        <div class="form-group">
                            <label for="plural_name">Nome plurale *</label>
                            <input type='type' placeholder="Nome plurale" id="plural_name" name="plural_name" class="form-control" required="" />
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-hover-green" data-action="save" role="button" onclick="cmsManagerGod.editComponentAttribute()">Salva</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php } ?>
<script>
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
</script>

<?php
/* FINE GESTIONI */
?>



<?php
include("includes/footer.php");
?>

