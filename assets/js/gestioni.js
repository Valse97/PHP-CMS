var cmsManager = {
    name: "",
    init: function(name){
        this.name = name;
        /*$("#main-table tbody tr").draggable({
            appendTo:"body",
            helper:"clone"
        });
        $("#main-table tbody").droppable({
            activeClass:"ui-state-default",
            hoverClass:"ui-state-hover",
            accept:":not(.ui-sortable-helper)",
            drop:function (event, ui) {
                $('.placeholder').remove();
                row = ui.draggable;
                $(this).append(row);
            }
        });*/

        $( function() {
            $( "#tabs" ).tabs();
            $( "#tabs" ).removeClass("hidden");
        } );

        var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                    $(this).css("background-color","#ececec")
                });
                return $helper;
            },
            updateIndex = function(e, ui) {
                $('td.index', ui.item.parent()).each(function (i) {
                    $(this).find("span").html(i + 1);
                });
            };

        $("#main-table tbody").sortable({
            helper: fixHelperModified,
            stop: updateIndex
        }).disableSelection();
    },
    toggleAll: function () {
        $(".tab[aria-hidden=false] #main-table .check-select-row").prop('checked',$(".tab[aria-hidden=false] #main-table .check-select-all").prop('checked'));
    },
    createItem: function (){
        var data = $("#addModal form").serialize();

        console.log(data);

        $.post( "app/ajax.php",
            {cl: "Cms", mt: "createComponent", vl: data},
            function(data) {
                cmsManager.closeModal();
                swal({
                    title: "Elemento creato!",
                    text: "",
                    type: "success",
                    timer: 2000,
                });
            }
        );
        /*swal({
            title: "Eliminare l'elemento scelto?",
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
            $.post( "app/ajax.php",
                {cl: "Gestione"+name, mt: "delete",vl: id},
                function(data) {
                    swal({
                        title: "Elemento eliminato!",
                        text: "",
                        type: "success",
                        timer: 2000,
                    },  function() {
                        $(".tab[aria-hidden=false] #main-table tr[data-id="+id+"]").remove();
                    });
                }
            );
        });*/
    },
    showEdit: function (id){
        $.post( "app/ajax.php",
            {cl: "Cms", mt: "getComponentById", vl: id},
            function(data) {
                console.log(data);

                this.openModal("edit");
            }
        );
    },
    editItem: function (){
        var data = $("#editModal form").serialize();

        console.log(data);

        $.post( "app/ajax.php",
            {cl: "Cms", mt: "editComponent", vl: data},
            function(data) {
                cmsManager.closeModal();
                swal({
                    title: "Elemento modificato!",
                    text: "",
                    type: "success",
                    timer: 2000,
                });
            }
        );
    },
    deleteItem: function (id){
        swal({
            title: "Eliminare l'elemento scelto?",
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
            $.post( "app/ajax.php",
                {cl: "Gestione"+name, mt: "delete",vl: id},
                function(data) {
                    swal({
                        title: "Elemento eliminato!",
                        text: "",
                        type: "success",
                        timer: 2000,
                    },  function() {
                        $(".tab[aria-hidden=false] #main-table tr[data-id="+id+"]").remove();
                    });
                }
            );
        });
    },
    deleteSelectedItems: function (){

    },
    openModal: function(type){
        $(".modal[data-type="+type+"]").modal();
    },
    closeModal: function(){
        $('.modal').modal('hide');
    }
};