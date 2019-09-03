var cmsManagerGod = {
    init: function () {
        $(".modal input[name='singular_name']").on('keyup keypress blur change', function () {
            var val = $(this).val();

            lastChar = val.substr(val.length - 1);

            switch (lastChar) {
                case "a":
                    val = val.substr(0, (val.length - 1)) + "e";
                    break;
                case "e":
                    val = val.substr(0, (val.length - 1)) + "i";
                    break;
                case "o":
                    val = val.substr(0, (val.length - 1)) + "i";
                    break;
            }

            $(this).closest(".modal").find("input[name='plural_name']").val(val);
        });
    },
    showEditComponent: function (id) {
        $.post("app/ajax.php",
            {cl: "Cms", mt: "getComponentById", vl: {id: id}},
            function (data) {
                console.log(data);
                data = JSON.parse(data);
                console.log(data);

                for (var prop in data) {
                    // skip se prototype
                    if (!data.hasOwnProperty(prop)) continue;

                    if ($("#editModal input[name=" + prop + "]").length > 0) {
                        $("#editModal input[name=" + prop + "]").val(data[prop])
                    }
                }
                cmsManager.openModal("edit");
            }
        );
    },
    createComponent: function () {
        var data = $("#addModal form").serialize();

        console.log(data);

        $.post("app/ajax.php",
            {cl: "Cms", mt: "createComponent", vl: data},
            function (data) {
                console.log(data);
                data = JSON.parse(data);
                console.log(data);


                if (data.success == true) {
                    cmsManager.closeModal();
                    swal({
                        title: "Fatto!",
                        text: data.msg,
                        type: "success",
                        timer: 2000,
                    });
                    var comp = data.object;
                    var tr = "<tr data-id=\"" + comp.id + "\" class=\"ui-sortable-handle\">";
                    tr += "<td class=\"filterable-cell\"><input type=\"checkbox\" class=\"check-select-row\"></td>";
                    tr += "<td class=\"filterable-cell index\"><span class=\"circle\">" + comp.sort + "</span></td>";
                    tr += "<td class=\"filterable-cell strong\">" + comp.singular_name + "</td>";
                    tr += "<td class=\"filterable-cell strong\">" + comp.plural_name + "</td>";
                    tr += "<td class=\"filterable-cell\">";
                    tr += "<a href=\"javascript:void(0)\" class=\"btn btn-primary btn-sm\">Modifica</a>";
                    tr += "<a href=\"javascript:void(0)\" class=\"btn btn-danger btn-sm\" onclick=\"cmsManagerGod.deleteItem(" + comp.id + ")\">Elimina</a>";
                    tr += "</td>";
                    tr += "</tr>";
                    $(".tab[aria-hidden=false] #main-table tbody").append(tr);
                } else {
                    swal({
                        title: "Errore!",
                        text: data.msg,
                        type: "error",
                        timer: 2000,
                    });
                }
            }
        );
    },
    editComponent: function () {
        var data = $("#editModal form").serialize();

        console.log(data);

        $.post("app/ajax.php",
            {cl: "Cms", mt: "editComponent", vl: data},
            function (data) {
                console.log(data);
                data = JSON.parse(data);
                console.log(data);


                if (data.success == true) {

                    var comp = data.object;

                    var tr = $("#main-table tr[data-id=" + comp.id + "]");

                    for (var prop in comp) {
                        if (tr.find("td[data-field='" + prop + "']").length > 0) {
                            tr.find("td[data-field='" + prop + "']").html(comp[prop]);
                        }
                    }

                    cmsManager.closeModal();
                    swal({
                        title: "Fatto!",
                        text: data.msg,
                        type: "success",
                        timer: 2000,
                    });
                } else {
                    swal({
                        title: "Errore!",
                        text: data.msg,
                        type: "error",
                        timer: 2000,
                    });
                }
            }
        );
    },
    deleteComponent: function (id) {
        swal({
                title: "Eliminare il componente scelto?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Elimina",
                cancelButtonText: "No",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                $.post("app/ajax.php",
                    {cl: "Cms", mt: "deleteComponent", vl: {id: id}},
                    function (data) {
                        console.log(data);
                        data = JSON.parse(data);
                        console.log(data);


                        if (data.success == true) {
                            cmsManager.closeModal();
                            $(".tab[aria-hidden=false] #main-table tr[data-id=" + id + "]").remove();
                            swal({
                                title: "Componente eliminato!",
                                text: "",
                                type: "success",
                                timer: 2000,
                            });
                        } else {
                            swal({
                                title: "Errore!",
                                text: data.msg,
                                type: "error",
                                timer: 2000,
                            });
                        }
                    }
                );
            });
    },
    deleteSelectedItems: function () {

    },
    showEditComponentAttribute: function (id) {
        $.post("app/ajax.php",
            {cl: "Cms", mt: "getComponentAttributeById", vl: {id: id}},
            function (data) {
                console.log(data);
                data = JSON.parse(data);
                console.log(data);

                for (var prop in data) {
                    // skip se prototype
                    if (!data.hasOwnProperty(prop)) continue;

                    if ($("#editModal input[name=" + prop + "]").length > 0) {
                        $("#editModal input[name=" + prop + "]").val(data[prop])
                    }
                }
                cmsManager.openModal("edit");
            }
        );
    },
    createComponentAttribute: function () {
        var data = $("#addModal form").serialize();

        console.log(data);

        $.post("app/ajax.php",
            {cl: "Cms", mt: "createComponentAttribute", vl: data},
            function (data) {
                console.log(data);
                data = JSON.parse(data);
                console.log(data);


                if (data.success == true) {
                    cmsManager.closeModal();
                    swal({
                        title: "Fatto!",
                        text: data.msg,
                        type: "success",
                        timer: 2000,
                    });
                    var comp = data.object;
                    var tr = "<tr data-id=\"" + comp.id + "\" class=\"ui-sortable-handle\">";
                    tr += "<td class=\"filterable-cell\"><input type=\"checkbox\" class=\"check-select-row\"></td>";
                    /* TODO: inserire i campi corretti
                    "
                    <td class=\"filterable-cell strong\" data-field=\"_cms_attribute_id\"><?php echo CMS::getAttributesById($attr->_cms_attribute_id)->type ?></td>
                    <td class=\"filterable-cell strong\" data-field=\"value_name\"><?php echo $attr->value_name ?></td>
                    <td class=\"filterable-cell strong\" data-field=\"required\"><?php echo (strlen($attr->required) > 0)? \"<span class=\\"glyphicon glyphicon-ok green\\"></span>\" : \"<span class=\\"glyphicon glyphicon-remove red\\"></span>\" ?></td>
                    <td class=\"filterable-cell strong\" data-field=\"placeholder\"><?php echo (strlen($attr->placeholder) > 0)? $attr->placeholder : \"/\" ?></td>
                    <td class=\"filterable-cell strong\" data-field=\"default_value\"><?php echo (strlen($attr->default_value) > 0)? $attr->default_value : \"/\" ?></td>
                    <td class=\"filterable-cell strong\" data-field=\"size\"><?php echo ($attr->size > 0)? $attr->size : \"/\" ?></td>
                    <td class=\"filterable-cell strong\" data-field=\"max_length\"><?php echo ($attr->max_length > 0)? $attr->max_length : \"/\" ?></td>
                    "*/
                    tr += "<td class=\"filterable-cell strong\">" + comp.singular_name + "</td>";
                    tr += "<td class=\"filterable-cell strong\">" + comp.plural_name + "</td>";
                    tr += "<td class=\"filterable-cell\">";
                    tr += "<a href=\"javascript:void(0)\" class=\"btn btn-primary btn-sm\">Modifica</a>";
                    tr += "<a href=\"javascript:void(0)\" class=\"btn btn-danger btn-sm\" onclick=\"cmsManagerGod.deleteItem(" + comp.id + ")\">Elimina</a>";
                    tr += "</td>";
                    tr += "</tr>";
                    $(".tab[aria-hidden=false] #main-table tbody").append(tr);
                } else {
                    swal({
                        title: "Errore!",
                        text: data.msg,
                        type: "error",
                        timer: 2000,
                    });
                }
            }
        );
    },
    editComponentAttribute: function () {
        var data = $("#editModal form").serialize();

        console.log(data);

        $.post("app/ajax.php",
            {cl: "Cms", mt: "editComponent", vl: data},
            function (data) {
                console.log(data);
                data = JSON.parse(data);
                console.log(data);


                if (data.success == true) {

                    var comp = data.object;

                    var tr = $("#main-table tr[data-id=" + comp.id + "]");

                    for (var prop in comp) {
                        if (tr.find("td[data-field='" + prop + "']").length > 0) {
                            tr.find("td[data-field='" + prop + "']").html(comp[prop]);
                        }
                    }

                    cmsManager.closeModal();
                    swal({
                        title: "Fatto!",
                        text: data.msg,
                        type: "success",
                        timer: 2000,
                    });
                } else {
                    swal({
                        title: "Errore!",
                        text: data.msg,
                        type: "error",
                        timer: 2000,
                    });
                }
            }
        );
    },
    deleteComponentAttribute: function (id) {
        swal({
                title: "Eliminare il componente scelto?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Elimina",
                cancelButtonText: "No",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                $.post("app/ajax.php",
                    {cl: "Cms", mt: "deleteComponent", vl: {id: id}},
                    function (data) {
                        console.log(data);
                        data = JSON.parse(data);
                        console.log(data);


                        if (data.success == true) {
                            cmsManager.closeModal();
                            $(".tab[aria-hidden=false] #main-table tr[data-id=" + id + "]").remove();
                            swal({
                                title: "Componente eliminato!",
                                text: "",
                                type: "success",
                                timer: 2000,
                            });
                        } else {
                            swal({
                                title: "Errore!",
                                text: data.msg,
                                type: "error",
                                timer: 2000,
                            });
                        }
                    }
                );
            });
    }
};