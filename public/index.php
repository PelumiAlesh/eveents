<?php require_once('../private/initialize.php'); ?>
<?php $page_title = 'Home'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<?php

$standout_events = fetch_standout_events();
$other_events = fetch_all_events();
$logged_in = check_login_status();

function getTypes($typeString) {
    $typeArray = explode(',',$typeString);
    $intersectArray = array_unique($typeArray);
    return implode(',', $intersectArray);
}
if (isset($_POST['apply_event'])) {
    $id = $_POST['id_modal'];
    $result = apply_to_event($id);
}

?>


    <div class="contain">
        <h2>Standout events</h2>
        <div class="standout-row">
            <?php while($standout_event = mysqli_fetch_assoc($standout_events)) { ?>
                <div class="card" style="width:400px">
                    <img class="card-img-top" src="images/event.jpg" alt="Card image">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo h($standout_event['name']); ?></h4>
                        <h6 class="card-title blue"><?php echo getTypes($standout_event['types']); ?></h6>
                        <p class="card-text"><?php echo substr(h($standout_event['desc']), 0, 100); ?></p>
                        <button
                            name="view-btn"
                            class="btn btn-primary view-btn"
                            data-toggle="modal"
                            data-target="#exampleModal"
                            data-desc="<?= $standout_event['desc']; ?>"
                            data-id="<?= $standout_event['id']; ?>"
                            data-typeName="<?= getTypes($standout_event['types']); ?>"
                            data-eventName="<?= $standout_event['name']; ?>"
                        >View Event
                        </button>
                    </div>
                </div>
            <?php } ?>
        </div>


        <h2 class="mt-20">Other events</h2>
        <div class="standout-row">
            <?php while($other_event = mysqli_fetch_assoc($other_events)) { ?>
                <div class="card" style="width:400px">
                    <img class="card-img-top" src="images/event.jpg" alt="Card image">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo h($other_event['name']); ?></h4>
                        <h6 class="card-title blue"><?php echo getTypes($other_event['types']); ?></h6>
                        <p class="card-text"><?php echo substr(h($other_event['desc']), 0, 100); ?></p>
                        <button
                            name="view-btn"
                            class="btn btn-primary view-btn"
                            data-toggle="modal"
                            data-target="#exampleModal"
                            data-desc="<?= $other_event['desc']; ?>"
                            data-id="<?= $other_event['id']; ?>"
                            data-typeName="<?= getTypes($other_event['types']); ?>"
                            data-eventName="<?= $other_event['name']; ?>"
                        >View Event
                        </button>
                    </div>
                </div>
            <?php } ?>
        </div>



    </div>
    <div id="snackbar">You applied successfully</div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 id="types" class="blue"></h6>

                    <p class="body-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="" method="post">
                        <div class="form-group" style="display: none">
                            <input class="form-control" id="id_modal" name="id_modal" />
                        </div>
                        <button name="apply_event" type="submit" class="btn btn-primary" <?= $logged_in ? true : "disabled" ?> >Apply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        function showToast() {
            // Get the snackbar DIV
            var x = document.getElementById("snackbar");

            // Add the "show" class to DIV
            x.className = "show";

            // After 3 seconds, remove the show class from DIV
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
        function delete_cookie( name, path ) {
            if( getCookie( name ) ) {
                document.cookie = name + "=" +
                    ((path) ? ";path="+path:"")+
                    ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
            }
        }
        if(getCookie('toast')){
            showToast()
            console.log('got here', document.cookie);
            delete_cookie('toast', '/')
            console.log('DEL here', document.cookie);
        };

        $(document).ready(function() {
            $(function () {

                $('.view-btn').on('click', function (event) {

                    const button = $(event.relatedTarget);
                    const title = $(this).attr("data-eventName");
                    const desc = $(this).attr("data-desc");
                    const id = $(this).attr("data-id");
                    const typeNames = $(this).attr("data-typeName");
                    const modal = $('#exampleModal');

                    console.log('typeName', typeNames)
                    modal.find('.modal-title').text(title);
                    modal.find('.body-text').text(desc);
                    modal.find('#types').text(typeNames);
                    modal.find('#id_modal').val(id);
                });
            });
        });
    </script>
<?php include(SHARED_PATH . '/footer.php'); ?>