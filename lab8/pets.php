<?php
    include 'inc/phpFuncs.php';
    include 'inc/header.php';
?>
        <script>
            $(document).ready(function() {
                $(".petLink").click(function() {

                    $('#petInfoModal').modal("show");
                    $("#petInfo").html("<img src='img/loading.gif'>");

                    $.ajax({
                        type: "GET",
                        url: "api/getPetInfo.php",
                        dataType: "json",
                        data: {
                            'id': $(this).data('id')
                        },
                        success: function(data) {
                            $("#petInfo").html(
                                "<img src='img/" + data.pictureURL + "'><br >" +
                                " Age: " + data.age + "<br>" +
                                " Breed: " + data.breed + "<br>" +
                                data.description
                            );

                            $("#petNameModalLabel").html(data.name);
                        },
                    });
                });
            });
        </script>

        <!--Modal-->
        <div class="modal fade" id="petInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="petNameModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="petInfo" class="text-center"></div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container text-center">

            <?php
                // Begin outputting to page
                $pets = getPetList();

                foreach ($pets as $pet) : ?>
                    <div class="petBar">
                        <div class="adoptText">
                            <div>
                                Name: <a href="#" class="petLink" data-id="<?= $pet['id'] ?>"><?= $pet['name'] ?></a>
                            </div>
                            <div>
                                Type: <?= $pet['type'] ?>
                            </div>

                            <button type="button" class="btn adoptButton btn-info petLink" data-id="<?= $pet['id'] ?>">Adopt Me !</button>
                        </div>
                    </div>
            <?php endforeach; ?>
        </div>
        
        
<?php
    include 'inc/footer.php';
?>

